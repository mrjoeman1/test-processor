<?php

namespace Processor\Config;

use Processor\Common\Executor\ExecutionTokens\VariableToken;
use Processor\Exceptions\ConfigException;
use Processor\Exceptions\ProcessorException;

/**
 * Interpreter for the default config format
 */
class ConfigInterpreter implements ConfigInterpreterInterface {
	/**
	 * Section tag for input variables
	 */
	const SECTION_INPUT = '[INPUT]';

	/**
	 * Section tag for output path
	 */
	const SECTION_OUTPUT = '[OUTPUT]';

	/**
	 * Section tag for process description
	 */
	const SECTION_PROCESS = '[PROCESS]';

	/**
	 * Section tag for input variables definition
	 */
	const DEFINITION_VARIABLE_REGEXP = '/(?<name><token>[a-zA-Z]+)\s*\=\s*(?<value>.+)/i';

	/**
	 * Section tag for process step definition
	 */
	const DEFINITION_STEP_REGEXP = '/(?<operation>[^\s]+)\s+(?<operands>.+)/i';

	/**
	 * Comment symbol
	 */
	const COMMENT_SYMBOL = '#';

	/**
	 * @var string Path to the config file
	 */
	private string $filePath;

	/**
	 * @var Config Building config
	 */
	private Config $config;

	/**
	 * Constructor
	 *
	 * @param string $filePath Path to the config file
	 */
	public function __construct(string $filePath) {
		$this->filePath = $filePath;
		$this->config = new Config();
	}

	/**
	 * @inheritDoc
	 */
	public function make(): Config {
		// Try to open file context
		if (!file_exists($this->filePath)) {
			throw new ConfigException("Config file {$this->filePath} is not exists");
		}
		$handle = fopen($this->filePath, 'r');
		if (!$handle) {
			throw new ConfigException("Can't read config file {$this->filePath}");
		}

		// iterate each line in the file
		$currentSection = null;
		$lineNumber = 0;
		while ($line = fgets($handle)) {
			$lineNumber++;
			$line = trim($line);
			$preparedLine = strtoupper($line);
			// skip commented and empty lines
			if ($preparedLine === '' || $this->isLineCommentedOut($preparedLine)) {
				continue;
			}
			// setup current section for next lines
			if (in_array($preparedLine, $this->getSectionsTags())) {
				$currentSection = $preparedLine;
				continue;
			}
			// process sections
			if (!$currentSection) {
				continue;
			}
			switch ($currentSection) {
				case self::SECTION_INPUT:
					$this->parseInput($preparedLine, $lineNumber);
					break;
				case self::SECTION_OUTPUT:
					$this->parseOutput($line, $lineNumber);
					break;
				case self::SECTION_PROCESS:
					$this->parseStep($preparedLine, $lineNumber);
					break;
			}
		}

		fclose($handle);
		$this->validateConfig();

		return $this->config;
	}

	/**
	 * Parse input variables from the line
	 *
	 * @param string $line Line from file
	 * @param int $lineNumber Line number
	 * @throws ProcessorException
	 */
	private function parseInput(string $line, int $lineNumber): void {
		// replace <token> by variable token template
		$variableTemplate = VariableToken::getTemplate();
		$regexp = str_replace("<token>", $variableTemplate, self::DEFINITION_VARIABLE_REGEXP);
		// match variable name and value from line
		$matches = [];
		preg_match($regexp, $line, $matches);
		if (!isset($matches['name']) || !isset($matches['value'])) {
			throw new ConfigException("$lineNumber: Wrong syntax");
		}
		$name = $matches['name'];
		$value = $matches['value'];

		$this->config->addInput($name, $value);
	}

	/**
	 * Parse output path from the line
	 *
	 * @param string $line Line from file
	 * @param int $lineNumber Line number
	 */
	private function parseOutput(string $line, int $lineNumber): void {
		$this->config->setOutput($line);
	}

	/**
	 * Parse process step (operation) from the line
	 *
	 * @param string $line Line from file
	 * @param int $lineNumber Line number
	 * @throws ConfigException
	 */
	private function parseStep(string $line, int $lineNumber): void {
		// match step operation name and parameters from line
		$matches = [];
		preg_match(self::DEFINITION_STEP_REGEXP, $line, $matches);
		if (!isset($matches['operation'])) {
			throw new ConfigException("$lineNumber: Operation is not defined");
		}
		// at least one operand should be set
		if (empty($matches['operands'])) {
			throw new ConfigException("$lineNumber: Operands should be set");
		}

		$operationName = $matches['operation'];
		$operandsExpression = str_replace(' ', '', $matches['operands']);
		$operationParams = explode(',', $operandsExpression);

		$this->config->addStep($operationName, $operationParams);
	}

	/**
	 * Returns tags array of supported sections
	 *
	 * @return array
	 */
	private function getSectionsTags(): array {
		return [
			strtoupper(self::SECTION_INPUT),
			strtoupper(self::SECTION_OUTPUT),
			strtoupper(self::SECTION_PROCESS),
		];
	}

	/**
	 * Is line commented out
	 *
	 * @param string $line Line from file
	 * @return bool
	 */
	private function isLineCommentedOut(string $line): bool {
		return strpos($line, self::COMMENT_SYMBOL) === 0;
	}

	/**
	 * Validates created Config
	 *
	 * @throws ConfigException
	 */
	private function validateConfig(): void {
		if (empty($this->config->getOutput())) {
			throw new ConfigException('Output should be set in config');
		}
		if (empty($this->config->getSteps())) {
			throw new ConfigException('Config should has one step at least');
		}
	}
}