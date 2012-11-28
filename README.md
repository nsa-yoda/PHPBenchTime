PHPBenchTime v1.1.0
===================

A light static benchmark timer class for PHP

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
PHPBenchTime is simple to use, lets start a timer:

```
BenchTime::Start();
```

Then lets just sleep for 3 seconds:
```
sleep(3);
```

Now, lets end the timer, and put results in $time:
```
$time = BenchTime::End();
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
BenchTime::Start();
```

Then, let's sleep for a couple of seconds between laps:
```
sleep(1);
BenchTime::Lap();
sleep(2);
BenchTime::Lap();
```

Now, let's end the timer:
```
$time = BenchTime::End();
```

Let's see the results:
```
Array
(
    [0] => 1353195346.6762
    [1] => 1353195347.6763
    [2] => 1353195349.6764
)
```

Advanced Usage : Named Laps
===========================
PHPBenchTime can also perform named laps, laps that allow you to name each one
to know more safely where each lap is located...so again, let's start a timer:
```
BenchTime::Start("Start");
```

Then, let's sleep for a couple of seconds between laps:
```
sleep(1);
BenchTime::Lap("First Lap");
sleep(2);
BenchTime::Lap("Second Lap");
```

Now, let's end the timer:
```
$time = BenchTime::End();
```

Let's see the result:
```
Array
(
    [Start] => 1353195603.1876
    [First Lap] => 1353195604.1877
    [Second Lap] => 1353195606.1878
)
```

TODO
====
PHPBenchTime still has to mature quite a bit...for example, there are methods 
for Pause and Unpause, but they have not yet been implemented.

PHPBenchTime could benefit from a bit of code cleanup and performance mods, 
as well as DRY methodologies in certain areas.