<?php

namespace Processor\Common\Operations;

use Processor\Exceptions\OperationException;

/**
 * Abstract class for math operations
 */
abstract class MathOperation extends AbstractOperation  {
	/**
	 * Validate params
	 *
	 * @throws OperationException
	 */
	protected function validateParams(): void {
		if (count($this->params) != 2) {
			throw new OperationException("Invalid number of params in operation {$this->name}");
		}
		if (!is_numeric($this->params[0]) || !is_numeric($this->params[1])) {
			throw new OperationException("Invalid type of params in operation {$this->name}. Should be float.");
		}
	}
}