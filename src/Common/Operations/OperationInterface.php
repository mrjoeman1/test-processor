<?php

namespace Processor\Common\Operations;

use Processor\Exceptions\OperationException;

/**
 * Operations interface
 */
interface OperationInterface {
	/**
	 * Perform operation
	 *
	 * @return mixed
	 * @throws OperationException
	 */
	public function perform();

	/**
	 * Operation name
	 *
	 * @return string
	 */
	public function getName(): string;
}