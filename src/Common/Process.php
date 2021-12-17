<?php

namespace Processor\Common;

use Processor\Common\Steps\Step;

/**
 * Process model
 */
class Process {
	/**
	 * @var Step[] Steps stack
	 */
	private array $steps;

	/**
	 * @var array Array of input variables
	 */
	private array $inputs;

	/**
	 * @var mixed Result of step execution
	 */
	private $executionResult = null;

	/**
	 * Constructor
	 * @param Step[]|null $steps Steps stack
	 * @param array|null $inputs Array of input variables
	 */
	public function __construct(?array $steps = [], ?array $inputs = []) {
		$this->steps = $steps;
		$this->inputs = $inputs;
	}

	/**
	 * Add step to the process stack
	 *
	 * @param Step $step Step
	 * @return void
	 */
	public function addStep(Step $step): void {
		$this->steps[] = $step;
	}

	/**
	 * Set input variables
	 *
	 * @param array $inputs Array of input variables
	 */
	public function setInputs(array $inputs): void {
		$this->inputs = $inputs;
	}

	/**
	 * Process Steps
	 *
	 * @return Step[]
	 */
	public function getSteps(): array {
		return $this->steps;
	}

	/**
	 * Process input variables
	 *
	 * @return array
	 */
	public function getInputs(): array {
		return $this->inputs;
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

	/**
	 * Resets processing results in memory
	 *
	 * @return void
	 */
	public function reset(): void {
		foreach ($this->getSteps() as $step) {
			$step->resetResult();
		}
		$this->resetResult();
	}
}