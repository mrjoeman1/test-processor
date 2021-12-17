<?php

namespace Processor\Common\Executor\ExecutionTokens;

use Processor\Exceptions\ExecutionException;

/**
 * Token for variables processing
 */
class StepResultToken extends AbstractToken {
	/**
	 * Token template
	 */
	private const TEMPLATE = '\&';

	/**
	 * @inheritDoc
	 */
	public function process($param) {
		$template = self::TEMPLATE;
		preg_match("/{$template}(?<idx>.+)/i", $param, $matches);
		if (empty($matches['idx'])) {
			throw new ExecutionException("Wrong results index $param");
		}

		$steps = $this->process->getSteps();
		$resultIdx = $matches['idx'];
		if (!is_numeric($resultIdx) || $resultIdx < 1 || $resultIdx > count($steps)) {
			throw new ExecutionException("Wrong results index $param. Step with index $resultIdx doesn't exist");
		}

		$result = $steps[$resultIdx-1]->getExecutionResult();
		if ($result === null) {
			throw new ExecutionException("Wrong step results variable $param. Step $resultIdx was not executed before");
		}

		return $result;
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
		return preg_match("/{$template}.+/i", $param) === 1;
	}
}