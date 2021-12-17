<?php

namespace Processor\Common\Operations;

/**
 * Math operation "^"
 */
class PowOperation extends MathOperation {
	/**
	 * @inheritdoc
	 */
	protected string $name = 'POW';

	/**
	 * @inheritDoc
	 */
	public function perform() {
		return $this->params[0] ** $this->params[1];
	}
}