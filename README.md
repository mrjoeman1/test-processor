[![Initial Task](https://docs.google.com/document/d/1p7dJSah0TVOoti_3AUVHvFtqvT1mZGlFEtrbgs5EAJM)](https://docs.google.com/document/d/1p7dJSah0TVOoti_3AUVHvFtqvT1mZGlFEtrbgs5EAJM)

Processor
=======
A simple library to execute processes described by files.

[![Diagram](https://drive.google.com/file/d/1rRwwtHbplkQKzCem9LX8QCsCBLPF_Sh5/view?usp=sharing)](https://drive.google.com/file/d/1rRwwtHbplkQKzCem9LX8QCsCBLPF_Sh5/view?usp=sharing)

Example
-------
```php
use Processor\Processor;
use Processor\Config\ConfigInterpreter;

// You can to implement your own config interpreters for other file formats.
// A custom interpreter may process a config from an any type of storage (File, DB, Array and etc.):
// - Just implement ConfigInterpreterInterface
// - In your config format you are able to use syntax "$<name>" to access input variables in operations,
//   and syntax "&<idx>" to access result of a previous executed step

$configInterpreter = new ConfigInterpreter("relative-path-to-config-file");

$processor = new Processor($configInterpreter);
$processor->process();
```

Advanced examples
-------
```php
use Processor\Processor;
use Processor\Config\ConfigInterpreter;

// You able to support your own types of operations 
// 1) Implement OperationInterface in a new operation.
// 2) Create a new factory by implementation OperationFactoryInterface.
// Or extend OperationFactory class to keep support the list of the default operations 

$operationFactory = new MyOperationFactory();
$configInterpreter = new ConfigInterpreter("path-to-config-file");

$processor = new Processor($configInterpreter);
$processor->setOperationFactory($operationFactory);
$processor->process();
```

Default config format
-------
```
# This config supports only math operations.
# Symbol for comments is "#" (at beginning of a line)

# Section describes input variables that can be accessed 
# on any step of process. To access them use syntax $<variable-name>.
# E.g. $a or $myVariable (only eng characters)

[INPUT]
$<variable-name> = <variable-value>
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
# <operand> could be a digit, a variable ($<variable-name>) 
# or result of a previos step (&<step-idx>), e.g. &1 is result of first step 

[PROCESS]
<operation> <operand>,<operand>,<operand>,...
...
```

Example of config
-------
```
# This config describes process from execution math formula:
# ax?? + bx

[INPUT]
$a = 10
$b = 55
$x = 17

[OUTPUT]
results/test_formula.log

[PROCESS]
POW $x,2
MUL $a,&1
MUL $b,$x
ADD &2,&3
```
