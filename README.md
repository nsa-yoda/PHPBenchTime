# PHPBenchTime v3.0.0

[![Latest Stable Version](https://poser.pugx.org/jsanc623/phpbenchtime/version.svg)](https://packagist.org/packages/jsanc623/phpbenchtime)
[![Total Downloads](https://poser.pugx.org/jsanc623/phpbenchtime/downloads.svg)](https://packagist.org/packages/jsanc623/phpbenchtime)
[![Monthly Downloads](https://poser.pugx.org/jsanc623/phpbenchtime/d/monthly.png)](https://packagist.org/packages/jsanc623/phpbenchtime)
[![License](https://poser.pugx.org/jsanc623/phpbenchtime/license.svg)](https://packagist.org/packages/jsanc623/phpbenchtime)

[![CI](https://github.com/nsa-yoda/PHPBenchTime/actions/workflows/ci.yml/badge.svg)](https://github.com/nsa-yoda/PHPBenchTime/actions/workflows/ci.yml)
[![Dependabot Updates](https://github.com/nsa-yoda/PHPBenchTime/actions/workflows/dependabot/dependabot-updates/badge.svg)](https://github.com/nsa-yoda/PHPBenchTime/actions/workflows/dependabot/dependabot-updates)
[![pages-build-deployment](https://github.com/nsa-yoda/PHPBenchTime/actions/workflows/pages/pages-build-deployment/badge.svg)](https://github.com/nsa-yoda/PHPBenchTime/actions/workflows/pages/pages-build-deployment)

A lightweight benchmark timer for PHP with laps, pause/unpause support, and a simple summary output.  
Designed for clarity, correctness, and minimal overhead.

> **PHPBenchTime v3.0 requires PHP 8.1+** (enum-backed state, typed properties, private internals).

If you’re interested, there is also a Python implementation:  
👉 **PyBenchTime** — https://github.com/nsa-yoda/PyBenchTime

---

## Installation

Install via Composer:

```bash
composer require nsa-yoda/phpbenchtime
```

Autoloading is handled automatically.

## Quick Start

```php 
<?php

require __DIR__ . '/vendor/autoload.php';

use PHPBenchTime\Timer;

$t = new Timer();
$t->start();
sleep(1);
$t->end();

print_r($t->summary());
?>
```

## Core Concepts

- Timers are stateful and controlled via methods only
- All internal properties are private
- State is represented by a PHP 8.1 enum
- All timings are floats (seconds, from microtime(true))
- summary() returns a read-only snapshot

## Public API

### Methods

```php
start(string $name = "start"): void
end(): void
reset(): void
lap(?string $name = null): void
summary(): array
pause(): void
unpause(): void
```

### Read-only Getters

```php
getState(): TimerState
getStartTime(): float
getEndTime(): float
getPauseTime(): float
getTotalPauseTime(): float
getLaps(): array
getLapCount(): int
```

## Basic Usage

```php
$t = new Timer();
$t->start();

sleep(3);

$t->end();

print_r($t->summary());
```

### Example Output

```php
Array
(
    [running] => -1
    [start]   => 1706812345.1234
    [end]     => 1706812348.1239
    [total]   => 3.0005
    [paused]  => 0
    [laps]    => Array
        (
            [0] => Array
                (
                    [name]  => start
                    [start] => 1706812345.1234
                    [end]   => 1706812348.1239
                    [total] => 3.0005
                )
        )
)
```

running is the enum value:
1 = RUNNING, 0 = PAUSED, -1 = STOPPED

### Laps

Laps allow you to isolate portions of execution time.
Each call to lap() automatically closes the previous lap.

```php
$t = new Timer();
$t->start();

sleep(1);
$t->lap();

sleep(2);
$t->lap();

$t->end();
```

### Named Laps

For clearer output, provide names to start() and lap():

```php
$t = new Timer();
$t->start('bootstrap');

sleep(1);
$t->lap('database');

sleep(1);
$t->lap('render');

$t->end();
```

### Pause & Unpause

Paused time is excluded from total runtime but still tracked.

```php
$t = new Timer();
$t->start();

sleep(1);
$t->lap('before pause');

$t->pause();
sleep(3); // excluded from total
$t->unpause();

sleep(1);
$t->lap('after pause');

$t->end();
```

Paused duration is available via:

```php
$t->getTotalPauseTime();
```

Calling end() while paused will automatically finalize the pause.

## Documentation

A richer usage guide (with examples and explanations) is available in: `docs/index.html`

This file can be found on th rpojrects GitHub Pages: https://nsa-yoda.github.io/PHPBenchTime/

## History

- v3.0.0 - Changes to tighten up the codebase for PHP8.1, strongly typed, and enums etc
- v2.1.0 - Performance improvements, unit tests, PHP 8.1 modernization
- v2.0.0 - Complete rewrite: pause/unpause, centralized lap system, detailed summary
- v1.3.0 - Laps, laps, laps
- v1.2.0 - Non-static namespaces
- v1.1.0 - Static namespaces
- v1.0.0 - Static birth




