<?php
namespace PHPBenchTime\Tests;

use PHPUnit\Framework\TestCase;
use PHPBenchTime\Timer;
use PHPBenchTime\TimerState;

class TimerTest extends TestCase
{
    private function newTimer(): Timer
    {
        return new Timer();
    }

    public function testGettersExistAndReturnDefaults(): void
    {
        $timer = $this->newTimer();

        $this->assertSame(TimerState::STOPPED, $timer->getState());
        $this->assertSame(0.0, $timer->getStartTime());
        $this->assertSame(0.0, $timer->getEndTime());
        $this->assertSame(0.0, $timer->getPauseTime());
        $this->assertSame(0.0, $timer->getTotalPauseTime());
        $this->assertSame([], $timer->getLaps());
        $this->assertSame(0, $timer->getLapCount());
    }

    public function testStart(): void
    {
        $timer = $this->newTimer();

        $before = microtime(true);
        $timer->start('test_start');
        $after = microtime(true);

        $this->assertSame(TimerState::RUNNING, $timer->getState());

        $startTime = $timer->getStartTime();
        $this->assertGreaterThanOrEqual($before, $startTime);
        $this->assertLessThanOrEqual($after, $startTime);

        $this->assertSame(1, $timer->getLapCount());
        $this->assertCount(1, $timer->getLaps());
        $this->assertSame('test_start', $timer->getLaps()[0]['name']);
    }

    public function testLap(): void
    {
        $timer = $this->newTimer();

        $timer->start('initial');
        $timer->lap('second');

        $this->assertSame(2, $timer->getLapCount());
        $this->assertCount(2, $timer->getLaps());

        $laps = $timer->getLaps();

        // Previous lap ended when second lap started
        $this->assertGreaterThanOrEqual(0.0, $laps[0]['total']);
        $this->assertGreaterThanOrEqual($laps[0]['start'], $laps[0]['end']);

        // New lap is open until ended
        $this->assertSame('second', $laps[1]['name']);
        $this->assertSame(-1.0, $laps[1]['end']);
        $this->assertSame(-1.0, $laps[1]['total']);
    }

    public function testSummaryKeysAndDefaults(): void
    {
        $timer = $this->newTimer();

        $summary = $timer->summary();

        $this->assertArrayHasKey('running', $summary);
        $this->assertArrayHasKey('start', $summary);
        $this->assertArrayHasKey('end', $summary);
        $this->assertArrayHasKey('total', $summary);
        $this->assertArrayHasKey('paused', $summary);
        $this->assertArrayHasKey('laps', $summary);

        print_r($summary);

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
        $timer = $this->newTimer();

        $timer->start('pause_test');

        $timer->pause();
        $this->assertSame(TimerState::PAUSED, $timer->getState());
        $this->assertGreaterThan(0.0, $timer->getPauseTime());

        usleep(5_000);

        $timer->unpause();
        $this->assertSame(TimerState::RUNNING, $timer->getState());
        $this->assertSame(0.0, $timer->getPauseTime());
        $this->assertGreaterThan(0.0, $timer->getTotalPauseTime());
    }

    public function testEndStopsTimerAndEndsLastLap(): void
    {
        $timer = $this->newTimer();

        $timer->start('end_test');
        usleep(5_000);
        $timer->end();

        $this->assertSame(TimerState::STOPPED, $timer->getState());
        $this->assertGreaterThan(0.0, $timer->getEndTime());
        $this->assertGreaterThanOrEqual($timer->getStartTime(), $timer->getEndTime());

        $laps = $timer->getLaps();
        $this->assertCount(1, $laps);
        $this->assertGreaterThanOrEqual(0.0, $laps[0]['total']);
        $this->assertGreaterThanOrEqual($laps[0]['start'], $laps[0]['end']);
    }

    public function testGetCurrentTime(): void
    {
        $timer = $this->newTimer();

        $before = microtime(true);
        $t = $timer->getCurrentTime();
        $after = microtime(true);

        $this->assertGreaterThanOrEqual($before, $t);
        $this->assertLessThanOrEqual($after, $t);
    }
}