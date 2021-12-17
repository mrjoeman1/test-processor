<?php

namespace Processor\Writers;

use Processor\Exceptions\WriterException;

/**
 * Writer to file
 */
class FileWriter implements WriterInterface {
	/**
	 * @inheritDoc
	 */
	public function writeResult(string $output, $result): void {
		$dir = dirname($output);
		if (!file_exists($dir)) {
			mkdir($dir);
		}
		$result = file_put_contents($output, $result);
		if ($result === false) {
			throw new WriterException('Error during writing result');
		}
	}
}