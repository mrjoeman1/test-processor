<?php

namespace Processor\Common\Executor;

use Processor\Common\Executor\ExecutionTokens\ExecutionTokenInterface;
use Processor\Common\Executor\ExecutionTokens\StepResultToken;
use Processor\Common\Executor\ExecutionTokens\VariableToken;
use Processor\Common\Operations\OperationFactoryInterface;
use Processor\Common\Process;
use Processor\Exceptions\ExecutionException;
use Processor\Exceptions\ProcessorException;

/**
 * Executes processes
 */
class ProcessExecutor {
	/**
	 * @var OperationFactoryInterface Operations factory
	 */
	private OperationFactoryInterface $operationFactory;

	/**
	 * @var Process|null Process instance
	 */
	private ?Process $process;

	/**
	 * @var ExecutionTokenInterface[] Supported execution tokens for memory-variables processing
	 */
	private array $executionTokens = [];

	/**
	 * Constructor
	 *
	 * @param OperationFactoryInterface $operationFactory Operations factory
	 */
	public function __construct(OperationFactoryInterface $operationFactory) {
		$this->operationFactory = $operationFactory;
	}

	/**
	 * Set a Process instance
	 *
	 * @param Process $process Process instance
	 * @return ProcessExecutor
	 */
	public function setProcess(Process $process): ProcessExecutor {
		$this->process = $process;
		$this->executionTokens = [
			new VariableToken($this->process),
			new StepResultToken($this->process),
		];
		return $this;
	}

	/**
	 * Executes process
	 *
	 * @return mixed
	 * @throws ProcessorException
	 */
	public function execute() {
		if (!$this->process) {
			throw new ExecutionException('Processes is not set');
		}
		$processResult = null;
		// execute each step
		foreach ($this->process->getSteps() as $step) {
			$operationName = $step->getOperationName();
			// prepare values for params (it can be in-memory variables)
			$operationParams = array_map(
				fn($param) => $this->processParam($param),
				$step->getOperationParams()
			);
			$operation = $this->operationFactory->create($operationName, $operationParams);
			// execute (perform) operation
			$operationResult = $operation->perform();
			$step->setExecutionResult($operationResult);
			// refresh total result of Process
			$processResult = $operationResult;
		}
		$this->process->setExecutionResult($processResult);
		return $processResult;
	}

	/**
	 * Prepare params. Checks if param is a variable and replaces it by value
	 *
	 * @param mixed $param $param
	 * @return mixed
	 * @throws ProcessorException
	 */
	private function processParam($param) {
		// find an applicable token and process
		foreach ($this->executionTokens as $token) {
			if ($token->check($param)) {
				return $token->process($param);
			}
		}
		return $param;
	}
}