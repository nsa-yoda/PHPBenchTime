<?php
namespace TimerTestNamespace;

use PHPUnit\Framework\TestCase;

require_once("../src/Timer.php");

class Timer extends TestCase {
    private \PHPBenchTime\Timer $timer;

    public function setUp(): void {
        $this->timer = new \PHPBenchTime\Timer;
    }

    public function testClassAttributes() {
        $this->assertClassHasAttribute( 'startTime', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'endTime', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'pauseTime', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'laps', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'lapCount', 'PHPBenchTime\Timer' );
    }

    public function testStart() {
        $this->timer->start('test_start');
        $this->assertEquals(\PHPBenchTime\Timer::RUNNING, $this->timer->state);
        $this->assertGreaterThanOrEqual(microtime(true) - 3, $this->timer->startTime);
        $this->assertLessThanOrEqual(microtime(true) + 3, $this->timer->startTime);
    }

    public function testLap() {
	    $this->timer->lap();
        $this->assertGreaterThan(0, $this->timer->lapCount);
        $this->assertGreaterThan(0, count($this->timer->laps));
    }

    public function testSummary() {
	    $summary = $this->timer->summary();
        $this->assertArrayHasKey('running', $summary);
        $this->assertArrayHasKey('start', $summary);
        $this->assertArrayHasKey('end', $summary);
        $this->assertArrayHasKey('total', $summary);
        $this->assertArrayHasKey('paused', $summary);
        $this->assertArrayHasKey('laps', $summary);
        $this->assertEquals(0, $summary['total']);
    }

    public function testPause() {
        $this->timer->pause();
        $this->assertEquals(\PHPBenchTime\Timer::PAUSED, $this->timer->state);
    }

    public function testUnpause() {
        $this->timer->unpause();
        $this->assertEquals(\PHPBenchTime\Timer::RUNNING, $this->timer->state);
        $this->assertGreaterThan(0, $this->timer->totalPauseTime);
        $this->assertEquals(0, $this->timer->pauseTime);
    }

    public function endLap() {
        $this->timer->endLap();
        $this->assertGreaterThan(0, count($this->timer->laps));
    }

    public function getCurrentTime() {
        $this->assertGreaterThanOrEqual(microtime(true) - 3, $this->timer->getCurrentTime());
        $this->assertLessThanOrEqual(microtime(true) + 3, $this->timer->getCurrentTime());
    }

    public function testEnd() {
        $this->timer->end();
        $this->assertEquals(\PHPBenchTime\Timer::STOPPED, $this->timer->state);
    }
}
