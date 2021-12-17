<?php

namespace Processor\Common\Executor\ExecutionTokens;

use Processor\Exceptions\ExecutionException;

/**
 * Token for variables processing
 */
class VariableToken extends AbstractToken {
	/**
	 * Token template
	 */
	private const TEMPLATE = '\$';

	/**
	 * @inheritDoc
	 */
	public function process($param) {
		$template = self::TEMPLATE;
		preg_match("/(?<name>{$template}[a-zA-Z]+)/i", $param, $matches);
		if (empty($matches['name'])) {
			throw new ExecutionException("Wrong operation param $param");
		}

		$variableName = $matches['name'];

		$inputs = $this->process->getInputs();
		if (!isset($inputs[$variableName])) {
			throw new ExecutionException("Variable with name $variableName was not found");
		}

		return $inputs[$variableName];
	}

	/**
	 * @inheritDoc
	 */
	public static function getTemplate(): string {
		return self::TEMPLATE;
	}

	/**
	 * @inheritDoc
	 */
	public function check($param): bool {
		$template = self::TEMPLATE;
		return preg_match("/{$template}[a-zA-Z]+/i", $param) === 1;
	}
}