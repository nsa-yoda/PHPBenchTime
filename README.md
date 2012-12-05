PHPBenchTime v1.3.0
===================

A light benchmark timer class for PHP

On Packagist
============
https://packagist.org/packages/jsanc623/phpbenchtime

Methods
=======
```
public Start();
public Lap();
public Pause();
public Unpause();
public End();
private _TotalTime();
private _CurrentTimeFloat();
private _PHPVersion();
```

Simple Usage
============
PHPBenchTime is simple to use, let's require the file and use the namespace with 
a nickname:

```
require('PHPBenchTime.php');
use PHPBenchTime\Timer as Timer;
$Benchmark = new Timer;
```


That was easy! Now lets start a timer:

```
$Benchmark->Start();
```

Then lets just sleep for 3 seconds:
```
sleep(3);
```

Now, lets end the timer, and put results in $time:
```
$time = $Benchmark->End();
```

When we end a timer, we receive an array back, containing the start time,
end time and difference between start and end times:
```
Array
(
    [Start] => 1353194312.2802
    [End] => 1353194314.2804
    [Total] => 2.0001
)
```

Advanced Usage : Laps
=====================

PHPBenchTime also allows you to set laps between code execution, which allows 
you to determine what part of your code is causing a bottleneck. Let's start a timer:

```
require('PHPBenchTime.php');
use PHPBenchTime\Timer as Timer;
$Benchmark = new Timer;

$Benchmark->Start();
```

Then, let's sleep for a couple of seconds between laps:
```
sleep(1);
$Benchmark->Lap();
sleep(2);
$Benchmark->Lap();
```

Now, let's end the timer:
```
$time = $Benchmark->End();
```

Let's see the results:
```
Array
(
	[Laps] =>
	    [0] => 1353195346.6762
	    [1] => 1353195347.6763
	    [2] => 1353195349.6764
	[Total] => 3.0002
)
```

Advanced Usage : Named Laps
===========================
PHPBenchTime can also perform named laps, laps that allow you to name each one
to know more safely where each lap is located...so again, let's start a timer:
```
require('PHPBenchTime.php');
use PHPBenchTime\Timer as Timer;
$Benchmark = new Timer;

$Benchmark->Start("Start");
```

Then, let's sleep for a couple of seconds between laps:
```
sleep(1);
$Benchmark->Lap("First Lap");
sleep(2);
$Benchmark->Lap("Second Lap");
```

Now, let's end the timer:
```
$time = $Benchmark->End();
```

Let's see the result:
```
Array
(
	[Laps] => 
   		[Start] => 1353195603.1876
   		[First Lap] => 1353195604.1877
   		[Second Lap] => 1353195606.1878
   	[Total] => 3.0002
)
```

TODO
====
PHPBenchTime still has to mature quite a bit...for example, there are methods 
for Pause and Unpause, but they have not yet been implemented.

PHPBenchTime could benefit from a bit of code cleanup and performance mods, 
as well as DRY methodologies in certain areas.

HISTORY
=======

* v1.0.0: Static Birth! 
* v1.1.0: Static Namespaces! 
* v1.2.0: Non-Static Namespaces! 
* v1.3.0: Laps! Laps! Laps! 
