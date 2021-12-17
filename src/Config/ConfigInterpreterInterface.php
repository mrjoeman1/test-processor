<?php

namespace Processor\Config;

use Processor\Exceptions\ConfigException;

/**
 * Interface for interpreters of process config
 */
interface ConfigInterpreterInterface {
	/**
	 * Runs interpretation and makes Config instance
	 *
	 * @return Config
	 * @throws ConfigException
	 */
	public function make(): Config;
}