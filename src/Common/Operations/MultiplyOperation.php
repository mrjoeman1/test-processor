<?php

namespace Processor\Common\Operations;

/**
 * Math operation "*"
 */
class MultiplyOperation extends MathOperation {
	/**
	 * @inheritdoc
	 */
	protected string $name = 'MUL';

	/**
	 * @inheritDoc
	 */
	public function perform() {
		return $this->params[0] * $this->params[1];
	}
}