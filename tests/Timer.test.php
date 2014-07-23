<?php

# TODO increase coverage

class Timer_Test extends PHPUnit_Framework_TestCase {
    private $fetch;

    public function setUp() {
        $this->fetch = new PHPBenchTime\Timer;
    }

    public function testClassAttributes() {
        $this->assertClassHasAttribute( 'startTime', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'endTime', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'pauseTime', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'totalTime', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'laps', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'isRunning', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'isPaused', 'PHPBenchTime\Timer' );
        $this->assertClassHasAttribute( 'lapCount', 'PHPBenchTime\Timer' );
    }
}
