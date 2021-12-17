<?php

namespace Processor\Config;

/**
 * Process config model
 */
class Config {
	/**
	 * @var array Array of input variables
	 */
	private array $inputs = [];

	/**
	 * Output for process results
	 *
	 * @var string
	 */
	private string $output;

	/**
	 * @var array Array of steps
	 */
	private array $steps = [];

	/**
	 * Adds an input variable for process
	 *
	 * @param string $name Variable name
	 * @param mixed $value Value of the variable
	 * @return void
	 */
	public function addInput(string $name, $value): void {
		$this->inputs[$name] = $value;
	}

	/**
	 * Input variables
	 *
	 * @return array
	 */
	public function getInputs(): array {
		return $this->inputs;
	}


	/**
	 * Set output for process results
	 *
	 * @param string $output Path to output
	 */
	public function setOutput(string $output): void {
		$this->output = $output;
	}

	/**
	 * Output for process results
	 *
	 * @return string
	 */
	public function getOutput(): string {
		return $this->output;
	}

	/**
	 * Adds a Step
	 *
	 * @param string $operationName Step operation name
	 * @param array $operationParams Step operation params
	 * @return void
	 */
	public function addStep(string $operationName, array $operationParams): void {
		$this->steps[] = [
			'operationName' => $operationName,
			'params' => $operationParams
		];
	}

	/**
	 * Steps
	 *
	 * @return array
	 */
	public function getSteps(): array {
		return $this->steps;
	}
}