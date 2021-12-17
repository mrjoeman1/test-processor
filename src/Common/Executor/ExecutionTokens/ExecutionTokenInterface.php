<?php

namespace Processor\Common\Executor\ExecutionTokens;

use Processor\Exceptions\ProcessorException;

/**
 * Token for in-memory variables processing
 */
interface ExecutionTokenInterface {
	/**
	 * Process param according token's logic
	 *
	 * @param mixed $param
	 * @return mixed
	 * @throws ProcessorException
	 */
	public function process($param);

	/**
	 * Checks if token can be applied
	 *
	 * @param mixed $param Operation parameter
	 * @return bool
	 * @throws ProcessorException
	 */
	public function check($param): bool;

	/**
	 * Returns token template
	 *
	 * @return string
	 */
	public static function getTemplate(): string;
}