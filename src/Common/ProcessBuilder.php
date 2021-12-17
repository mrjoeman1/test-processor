<?php

namespace Processor\Common;

use Processor\Common\Steps\Step;

/**
 * Process model
 */
class ProcessBuilder {
	/**
	 * @var Process Instance of Process
	 */
	private Process $process;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->reset();
	}

	/**
	 * Reset builder
	 *
	 * @return ProcessBuilder
	 */
	public function reset(): ProcessBuilder {
		$this->process = new Process();
		return $this;
	}

	/**
	 * Add Step to process
	 *
	 * @param string $operationName Name of step operation
	 * @param array $operationParams Params of step operation
	 * @return ProcessBuilder
	 */
	public function addStep(string $operationName, array $operationParams): ProcessBuilder {
		$step = new Step($operationName, $operationParams);
		$this->process->addStep($step);
		return $this;
	}

	/**
	 * Set input variables
	 *
	 * @param array $inputs Array of input variables
	 * @return ProcessBuilder
	 */
	public function setInputs(array $inputs): ProcessBuilder {
		$this->process->setInputs($inputs);
		return $this;
	}

	/**
	 * Returns built process
	 *
	 * @return Process
	 */
	public function get(): Process {
		$process = $this->process;
		$this->reset();
		return $process;
	}
}