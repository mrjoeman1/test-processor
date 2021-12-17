<?php

namespace Processor\Common;

use Processor\Config\Config;

/**
 * Director for process building from a config
 */
class ProcessConfigurator {
	/**
	 * Processes builder
	 *
	 * @var ProcessBuilder
	 */
	private ProcessBuilder $builder;

	/**
	 * @var Config Config model
	 */
	private Config $config;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->builder = new ProcessBuilder();
	}

	/**
	 * Set config for import and building process
	 *
	 * @param Config $config Config model
	 * @return ProcessConfigurator
	 */
	public function setConfig(Config $config): ProcessConfigurator {
		$this->config = $config;
		return $this;
	}

	/**
	 * Makes a Process from a Config
	 *
	 * @return Process
	 */
	public function make(): Process {
		$inputs = $this->config->getInputs();
		$this->builder->setInputs($inputs);
		foreach ($this->config->getSteps() as $step) {
			$operationName = $step['name'];
			$operationParams = $step['params'];
			$this->builder->addStep($operationName, $operationParams);
		}
		return $this->builder->get();
	}
}