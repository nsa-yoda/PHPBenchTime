<?php
/**
 * PHPBenchTime
 * A light benchmark timer class for PHP
 *
 * @author   Juan L. Sanchez <juan.sanchez@juanleonardosanchez.com>
 * @license  MIT
 * @version  2.1.0
 * @internal 07.23.2014
 */

namespace PHPBenchTime;

class Timer {
    /**
     * Handle the running state of the timer
     */
    const RUNNING = 1;
    const PAUSED = 0;
    const STOPPED = -1;

    /**
     * Maintains the state of the timer (RUNNING, PAUSED, STOPPED)
     * @var int
     */
    public int $state = self::STOPPED;

    /**
     * Time that $this->start() was called
     * @var int
     */
    public int $startTime = 0;

    /**
     * Time that $this->end() was called
     * @var int
     */
    public int $endTime = 0;

    /**
     * Total time spent in pause
     * @var int
     */
    public int $totalPauseTime = 0;

    /**
     * Time spent in pause
     * @var int
     */
    public int $pauseTime = 0;

    /**
     * All laps
     * @var array
     */
    public array $laps = array();

    /**
     * Total lap count, inclusive of the current lap
     * @var int
     */
    public int $lapCount = 0;

    /**
     * Class constructor
     */
    public function __construct() {
        $this->reset();
    }

    /**
     * Resets the timers, laps and summary
     */
    public function reset() {
        $this->startTime = 0;
        $this->endTime   = 0;
        $this->pauseTime = 0;
        $this->laps      = [];
        $this->lapCount  = 0;
    }

    /**
     * Starts the timer
     * @param string $name
     */
    public function start( $name = "start" ) {
        $this->state = self::RUNNING;

        # Set the start time
        $this->startTime = $this->getCurrentTime();

        # Create a lap with this start time
        $this->lap( $name );
    }

    /**
     * Ends the timer
     */
    public function end() {
        $this->state = self::STOPPED;

        # Set the end time
        $this->endTime = $this->getCurrentTime();

        # end the last lap
        $this->endLap();
    }

    /**
     * Creates a new lap in lap array property
     * @param null $name
     */
    public function lap( $name = null ) {
        $this->endLap(); # end the last lap

        # Create new lap
        $this->laps[] = array(
            "name"  => ( $name ? $name : $this->lapCount ),
            "start" => $this->getCurrentTime(),
            "end"   => -1,
            "total" => -1,
        );

        $this->lapCount += 1;
    }

    /**
     * Assign end and total times to the previous lap
     */
    public function endLap() {
        $lapCount = count( $this->laps ) - 1;
        if ( count( $this->laps ) > 0 ) {
            $this->laps[$lapCount]['end']   = $this->getCurrentTime();
            $this->laps[$lapCount]['total'] = $this->laps[$lapCount]['end'] - $this->laps[$lapCount]['start'];
        }
    }

    /**
     * Returns a summary of all timer activity so far
     * @return array
     */
    public function summary() {
        return array(
            'running' => $this->state,
            'start'   => $this->startTime,
            'end'     => $this->endTime,
            'total'   => $this->endTime - $this->startTime,
            'paused'  => $this->totalPauseTime,
            'laps'    => $this->laps
        );
    }

    /**
     * Initiates a pause in the timer
     */
    public function pause() {
        $this->state = self::PAUSED;
        $this->pauseTime = $this->getCurrentTime();
    }

    /**
     * Cancels the pause previously set
     */
    public function unpause() {
        $this->state = self::RUNNING;
        $this->totalPauseTime += $this->getCurrentTime() - $this->pauseTime;
        $this->pauseTime      = 0;
    }

    /**
     * Returns the current time
     * @return float
     */
    public function getCurrentTime() {
        return microtime( true );
    }
}


