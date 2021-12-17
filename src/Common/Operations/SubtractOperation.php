<?php

namespace Processor\Common\Operations;

/**
 * Math operation "-"
 */
class SubtractOperation extends MathOperation {
	/**
	 * @inheritdoc
	 */
	protected string $name = 'SUB';

	/**
	 * @inheritDoc
	 */
	public function perform() {
		return $this->params[0] - $this->params[1];
	}
}