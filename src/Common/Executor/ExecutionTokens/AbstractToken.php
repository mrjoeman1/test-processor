<?php

namespace Processor\Common\Executor\ExecutionTokens;

use Processor\Common\Process;
use Processor\Exceptions\ProcessorException;

/**
 * Abstract Token for variables processing
 */
abstract class AbstractToken implements ExecutionTokenInterface {
	/**
	 * @var Process Process instance
	 */
	protected Process $process;

	/**
	 * Constructor
	 *
	 * @param Process $process Process instance
	 */
	public function __construct(Process $process) {
		$this->process = $process;
	}
}