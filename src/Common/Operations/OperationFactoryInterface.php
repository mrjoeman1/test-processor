<?php

namespace Processor\Common\Operations;

use Processor\Exceptions\OperationException;

/**
 * Operations factory interface
 */
interface OperationFactoryInterface {
	/**
	 * Creates operation
	 *
	 * @param string $name Operation name
	 * @param array $params Operation params
	 * @return OperationInterface
	 * @throws OperationException
	 */
	public function create(string $name, array $params): OperationInterface;
}