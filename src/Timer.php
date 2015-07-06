<?php
/**
 * PHPBenchTime
 * A light benchmark timer class for PHP
 *
 * @author   Juan L. Sanchez <juan.sanchez@juanleonardosanchez.com>
 * @license  MIT
 * @version  2.0.0
 * @internal 07.23.2014
 */

namespace PHPBenchTime;

class Timer {

    /**
     * Time that $this->start() was called
     *
     * @var int
     */
    private $startTime = 0;

    /**
     * Time that $this->end() was called
     *
     * @var int
     */
    private $endTime = 0;

    /**
     * Total time spent in pause
     *
     * @var int
     */
    private $totalPauseTime = 0;

    /**
     * Time spent in pause
     *
     * @var int
     */
    private $pauseTime = 0;

    /**
     * Contains all laps
     *
     * @var array
     */
    private $laps = array();

    /**
     * Is the timer currently actively running?
     *
     * @var bool
     */
    private $isRunning = false;

    /**
     * Keeps track of what lap we are currently on
     *
     * @var int
     */
    private $lapCount = 0;

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
        $this->laps      = array();
        $this->isRunning = false;
        $this->lapCount  = 0;
    }

    /**
     * Starts the timer
     */
    public function start() {
        $this->setRunningPaused( true, false );

        # Set the start time
        $this->startTime = $this->getCurrentTime();

        # Create a lap with this start time
        $this->lap( "start" );
    }

    /**
     * Ends the timer
     */
    public function end() {
        $this->setRunningPaused( false, true );

        # Set the end time
        $this->endTime = $this->getCurrentTime();

        # end the last lap
        $this->endLap();

        return $this->summary();
    }

    /**
     * Creates a new lap in lap array property
     */
    public function lap( $name = null ) {
        # end the last lap
        $this->endLap();

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
     * Returns a summary of all timer activity so far
     *
     * @return array
     */
    public function summary() {
        return array(
            'running' => ( $this->isRunning === true ? "true" : "false" ),
            'start'   => $this->startTime,
            'end'     => $this->endTime,
            'total'   => $this->envTime - $this->startTime,
            'paused'  => $this->totalPauseTime,
            'laps'    => $this->laps
        );
    }

    /**
     * Initiates a pause in the timer
     */
    public function pause() {
        $this->setRunningPaused( false, true );
        $this->pauseTime = $this->getCurrentTime();
    }

    /**
     * Cancels the pause previously set
     */
    public function unPause() {
        $this->setRunningPaused( true, false );
        $this->totalPauseTime = $this->getCurrentTime() - $this->pauseTime;
        $this->pauseTime      = 0;
    }

    /**
     * Assign end and total times to the previous lap
     */
    private function endLap() {
        $lapCount = count( $this->laps ) - 1;
        if ( count( $this->laps ) > 0 ) {
            $this->laps[$lapCount]['end']   = $this->getCurrentTime();
            $this->laps[$lapCount]['total'] = $this->laps[$lapCount]['end'] - $this->laps[$lapCount]['start'];
        }
    }

    /**
     * Handles isRunning
     *
     * @param $running
     * @param $paused
     */
    private function setRunningPaused( $running, $paused ) {
        $this->isRunning = is_bool( $running ) ? $running : false;
    }

    /**
     * Returns the current time
     *
     * @return float
     */
    private function getCurrentTime() {
        return microtime( true );
    }
}


