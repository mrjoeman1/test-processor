<?php

namespace Processor\Common\Operations;

use Processor\Exceptions\OperationException;

/**
 * Default operations factory
 */
class OperationFactory implements OperationFactoryInterface {
	const OPERATION_ADD = 'ADD';
	const OPERATION_SUBTRACT = 'SUB';
	const OPERATION_MULTIPLY = 'MUL';
	const OPERATION_POW = 'POW';

	/**
	 * @inheritDoc
	 */
	public function create(string $name, array $params): OperationInterface {
		switch ($name) {
			case self::OPERATION_ADD:
				return new AddOperation($params);
			case self::OPERATION_SUBTRACT:
				return new SubtractOperation($params);
			case self::OPERATION_MULTIPLY:
				return new MultiplyOperation($params);
			case self::OPERATION_POW:
				return new PowOperation($params);
		}
		throw new OperationException("Unsupported type of operation {$name}");
	}
}