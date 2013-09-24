<?php

include "PHPBenchTime.php";

class Timer_Test extends PHPUnit_Framework_TestCase{
    public function setUp(){
        $this->fetch = new PHPBenchTime\Timer;
    }
    
	public function testClassAttributes(){
		$this->assertClassHasAttribute("_startTime", "PHPBenchTime\Timer");
		$this->assertClassHasAttribute("_pauseTime", "PHPBenchTime\Timer");
		$this->assertClassHasAttribute("_endTime", "PHPBenchTime\Timer");
		$this->assertClassHasAttribute("_phpVersion", "PHPBenchTime\Timer");
		$this->assertClassHasAttribute("_lapName", "PHPBenchTime\Timer");
	}

	public function testStartFunctionNoName(){
		$this->assertTrue($this->fetch->Start());
		$this->assertArrayHasKey(0, $this->fetch->_startTime);
		$this->assertEmpty($this->fetch->_lapName);

		$this->assertTrue($this->fetch->Start("Lapname"));
		$this->assertArrayHasKey(0, $this->fetch->_startTime);
		$this->assertNotNull($this->fetch->_lapName);
	}

	public function testLap(){
		$mockLap = $this->getMock('PHPBenchTime\Timer');
		$mockLap->expects($this->any())->method("Lap")->will($this->returnValue(null));
	}

	public function testEnd(){
		$this->assertArrayHasKey("Start", $this->fetch->End());
		$this->assertArrayHasKey("End", $this->fetch->End());
	}
}
