<?php

namespace Processor\Common\Operations;

use Processor\Exceptions\OperationException;

/**
 * Abstract class of operations
 */
abstract class AbstractOperation implements OperationInterface {
	/**
	 * @var string Operation name
	 */
	protected string $name;

	/**
	 * @var array Operation params
	 */
	protected array $params = [];

	/**
	 * Constructor
	 *
	 * @param array $params Operation params
	 * @throws OperationException
	 */
	public function __construct(array $params) {
		$this->params = $params;
		$this->validateParams();
	}

	/**
	 * @inheritDoc
	 */
	public function getName(): string {
		return $this->name;
	}
	/**
	 * Validate params
	 *
	 * @throws OperationException
	 */
	abstract protected function validateParams(): void;
}