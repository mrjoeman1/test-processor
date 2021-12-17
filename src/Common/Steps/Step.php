<?php

namespace Processor\Common\Steps;

/**
 * Step model
 */
class Step {
	/**
	 * @var string Step operation name
	 */
	private string $operationName;

	/**
	 * @var array Step params
	 */
	private array $operationParams = [];

	/**
	 * @var mixed Result of step execution
	 */
	private $executionResult = null;

	/**
	 * Constructor
	 *
	 * @param string $operationName Step operation name
	 * @param array $operationParams Step params
	 */
	public function __construct(string $operationName, array $operationParams) {
		$this->operationName = $operationName;
		$this->operationParams = $operationParams;
	}

	/**
	 * Operation name
	 *
	 * @return string
	 */
	public function getOperationName(): string {
		return $this->operationName;
	}

	/**
	 * Operation params
	 *
	 * @return array
	 */
	public function getOperationParams(): array {
		return $this->operationParams;
	}

	/**
	 * Result of execution
	 *
	 * @return mixed
	 */
	public function getExecutionResult() {
		return $this->executionResult;
	}

	/**
	 * Set result of execution
	 *
	 * @param mixed $executionResult Value
	 */
	public function setExecutionResult($executionResult): void {
		$this->executionResult = $executionResult;
	}

	/**
	 * Reset result of execution
	 */
	public function resetResult(): void {
		$this->executionResult = null;
	}
}