<?php

namespace Processor\Common\Operations;

/**
 * Math operation "+"
 */
class AddOperation extends MathOperation {
	/**
	 * @inheritdoc
	 */
	protected string $name = 'ADD';

	/**
	 * @inheritDoc
	 */
	public function perform() {
		return $this->params[0] + $this->params[1];
	}
}