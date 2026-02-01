<?php
namespace PHPBenchTime\Tests;

use PHPUnit\Framework\TestCase;
use PHPBenchTime\Timer;
use PHPBenchTime\TimerState;

class TimerTest extends TestCase
{
    private Timer $timer;

    public function setUp(): void
    {
        $this->timer = new Timer();
    }

    public function testGettersExistAndReturnDefaults(): void
    {
        $this->assertSame(TimerState::STOPPED, $this->timer->getState());
        $this->assertSame(0.0, $this->timer->getStartTime());
        $this->assertSame(0.0, $this->timer->getEndTime());
        $this->assertSame(0.0, $this->timer->getPauseTime());
        $this->assertSame(0.0, $this->timer->getTotalPauseTime());
        $this->assertSame([], $this->timer->getLaps());
        $this->assertSame(0, $this->timer->getLapCount());
    }

    public function testStart(): void
    {
        $before = microtime(true);

        $this->timer->start('test_start');

        $after = microtime(true);

        $this->assertSame(TimerState::RUNNING, $this->timer->getState());

        $startTime = $this->timer->getStartTime();
        $this->assertGreaterThanOrEqual($before, $startTime);
        $this->assertLessThanOrEqual($after, $startTime);

        // start() creates the first lap
        $this->assertSame(1, $this->timer->getLapCount());
        $this->assertCount(1, $this->timer->getLaps());
        $this->assertSame('test_start', $this->timer->getLaps()[0]['name']);
    }

    public function testLap(): void
    {
        $this->timer->start('initial');

        $this->timer->lap('second');

        $this->assertSame(2, $this->timer->getLapCount());
        $this->assertCount(2, $this->timer->getLaps());

        $laps = $this->timer->getLaps();

        // The previous lap should have been ended when a new lap starts
        $this->assertGreaterThanOrEqual(0.0, $laps[0]['total']);
        $this->assertGreaterThanOrEqual($laps[0]['start'], $laps[0]['end']);

        // New lap should be open (end/total default -1.0 until ended)
        $this->assertSame('second', $laps[1]['name']);
        $this->assertSame(-1.0, $laps[1]['end']);
        $this->assertSame(-1.0, $laps[1]['total']);
    }

    public function testSummaryKeysAndDefaults(): void
    {
        $summary = $this->timer->summary();

        $this->assertArrayHasKey('running', $summary);
        $this->assertArrayHasKey('start', $summary);
        $this->assertArrayHasKey('end', $summary);
        $this->assertArrayHasKey('total', $summary);
        $this->assertArrayHasKey('paused', $summary);
        $this->assertArrayHasKey('laps', $summary);

        $this->assertSame(TimerState::STOPPED->value, $summary['running']);
        $this->assertSame(0.0, $summary['start']);
        $this->assertSame(0.0, $summary['end']);
        $this->assertSame(0.0, $summary['total']);
        $this->assertSame(0.0, $summary['paused']);
        $this->assertIsArray($summary['laps']);
        $this->assertCount(0, $summary['laps']);
    }

    public function testPauseAndUnpause(): void
    {
        $this->timer->start('pause_test');

        $this->timer->pause();
        $this->assertSame(TimerState::PAUSED, $this->timer->getState());
        $this->assertGreaterThan(0.0, $this->timer->getPauseTime());

        // Ensure some measurable pause time accrues
        usleep(5_000);

        $this->timer->unpause();
        $this->assertSame(TimerState::RUNNING, $this->timer->getState());
        $this->assertSame(0.0, $this->timer->getPauseTime());
        $this->assertGreaterThan(0.0, $this->timer->getTotalPauseTime());
    }

    public function testEndStopsTimerAndEndsLastLap(): void
    {
        $this->timer->start('end_test');

        usleep(5_000);

        $this->timer->end();

        $this->assertSame(TimerState::STOPPED, $this->timer->getState());
        $this->assertGreaterThan(0.0, $this->timer->getEndTime());
        $this->assertGreaterThanOrEqual($this->timer->getStartTime(), $this->timer->getEndTime());

        $laps = $this->timer->getLaps();
        $this->assertCount(1, $laps);
        $this->assertGreaterThanOrEqual(0.0, $laps[0]['total']);
        $this->assertGreaterThanOrEqual($laps[0]['start'], $laps[0]['end']);
    }

    public function testGetCurrentTime(): void
    {
        $t = $this->timer->getCurrentTime();

        $this->assertGreaterThanOrEqual(microtime(true) - 3, $t);
        $this->assertLessThanOrEqual(microtime(true) + 3, $t);
    }
}