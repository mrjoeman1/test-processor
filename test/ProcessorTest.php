<?php

require_once "autoloader.php";

use Processor\Config\ConfigInterpreter;
use Processor\Exceptions\ProcessorException;
use Processor\Processor;

class ProcessorTest {
	public function test() {
		$configInterpreter = new ConfigInterpreter("test.process");
		$processor = new Processor($configInterpreter);
		try {
			$processor->process();
		} catch (ProcessorException $exception) {
			echo $exception->getMessage() . "\n";
		}
	}
}

$test = new ProcessorTest();
$test->test();