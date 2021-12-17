[![Initial Task](https://docs.google.com/document/d/1p7dJSah0TVOoti_3AUVHvFtqvT1mZGlFEtrbgs5EAJM)](https://docs.google.com/document/d/1p7dJSah0TVOoti_3AUVHvFtqvT1mZGlFEtrbgs5EAJM)

Processor
=======
A simple library to execute process described by a file.

Example
-------
```php
use Processor\Processor;
use Processor\Config\ConfigInterpreter;

// You can to implement your own config interpreter for other file formats.
// A custom interpreter can provide a config from any type of storage (File, DB, Array and etc.):
// - Just implement ConfigInterpreterInterface
// - In your config format you able to use token "$<name>" to access input variables in operations,
//   and token "&<idx>" to access result of previous executed steps 

$configInterpreter = new ConfigInterpreter("relative-path-to-config-file");

$processor = new Processor($configInterpreter);
$processor->process();
```

Advanced examples
-------
```php
use Processor\Processor;
use Processor\Config\ConfigInterpreter;

// You can to implement your own types of operations 
// 1) In a new operation implement OperationInterface.
// 2) Create a new factory by implementation OperationFactoryInterface.
// Or extend OperationFactory class to keep support the list of default operations 

// define wich a file format we want to use for process description
$operationFactory = new MyOperationFactory();
$configInterpreter = new ConfigInterpreter("path-to-config-file");

$processor = new Processor($configInterpreter);
$processor->setOperationFactory($operationFactory);
$processor->process();
```

Default process configuration format
-------
```
# This config supports only math operations.
# Symbol for comments is "#" (in begin of a line)

# Section describes input variables that cab be accessed 
# on any step of process. To access them use syntax $<variable-name>.
# E.g. $a or $myVariable (only eng characters)

[INPUT]
<variable-name> = <variable-value>
...

# Section describes path to file where result of execution will be saved

[OUTPUT]
<relative-file-path>

# Section describes steps of process.
# Each step is an operation (<operation>):
# ADD - math "+"
# SUB - math "-"
# MUL - math "*"
# POW - math "^"
# <operand-a>, <operand-b> could be a digit, variable ($<variable-name>) 
# or result of a previos step (&<step-idx>), e.g. &1 is result of first step 

[PROCESS]
<operand-a> <operation> <operand-b>
```

Example of config
-------
```
# This config describes process from execution math formula:
# ax² + bx

[INPUT]
$a = 10
$b = 55
$c = 17

[OUTPUT]
results/test_formula.log

[PROCESS]
$x POW 2
$a MUL &1
$b MUL $x
&2 ADD &3
```