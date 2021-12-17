<?php

namespace Processor;

use Processor\Common\Executor\ProcessExecutor;
use Processor\Common\Operations\OperationFactory;
use Processor\Common\Operations\OperationFactoryInterface;
use Processor\Common\ProcessConfigurator;
use Processor\Config\ConfigInterpreterInterface;
use Processor\Exceptions\ProcessorException;
use Processor\Writers\FileWriter;
use Processor\Writers\WriterInterface;

/**
 * Facade of the library
 */
class Processor {
	/**
	 * @var ConfigInterpreterInterface Interpreter for process config
	 */
	protected ConfigInterpreterInterface $configInterpreter;

	/**
	 * @var ProcessConfigurator Director for process building from a config
	 */
	protected ProcessConfigurator $processConfigurator;

	/**
	 * @var ProcessExecutor Executor of processes
	 */
	protected ProcessExecutor $processExecutor;

	/**
	 * @var WriterInterface Results writer
	 */
	protected WriterInterface $resultsWriter;

	/**
	 * Processor constructor.
	 */
	public function __construct(ConfigInterpreterInterface $configInterpreter) {
		$this->configInterpreter = $configInterpreter;
		$operationFactory = new OperationFactory();
		$this->processConfigurator = new ProcessConfigurator();
		$this->processExecutor = new ProcessExecutor($operationFactory);
		$this->resultsWriter = new FileWriter();
	}

	/**
	 * Run process
	 *
	 * @throws ProcessorException
	 */
	public function process(): void {
		// import config
		$config = $this->configInterpreter->make();
		// build a process instance from the config
		$process = $this->processConfigurator->setConfig($config)->make();
		// execute the process
		$result = $this->processExecutor->setProcess($process)->execute();
		// write result
		$this->resultsWriter->writeResult($config->getOutput(), $result);
		// clear memory, reset execution results
		$process->reset();
	}

	/**
	 * Set Operations factory
	 *
	 * @param OperationFactoryInterface $operationFactory Operations factory
	 * @return void
	 */
	public function setOperationFactory(OperationFactoryInterface $operationFactory): void {
		$this->processExecutor = new ProcessExecutor($operationFactory);
	}
}