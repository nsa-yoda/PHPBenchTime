<?php
namespace TimerTestNamespace;

include "src/Timer.php";

class Timer_Test extends \PHPUnit_Framework_TestCase {
    private $timer;

    public function setUp() {
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
        $this->assertGreaterThan(0, count($summary['total']));
    }

    public function testPause() {
        $this->timer->pause();
        $this->assertEquals(\PHPBenchTime\Timer::PAUSED, $this->timer->state);
    }

    public function testUnpause() {
        $this->timer->unPause();
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
