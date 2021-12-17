<?php

namespace Processor\Writers;

use Processor\Exceptions\WriterException;

interface WriterInterface {
	/**
	 * Writes process result to some storage
	 *
	 * @param string $output Output path
	 * @param mixed $result Process result
	 * @throws WriterException
	 */
	public function writeResult(string $output, $result): void;
}