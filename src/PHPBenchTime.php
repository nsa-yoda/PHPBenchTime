<?php
/**
 * PHPBenchTime
 * A light benchmark timer class for PHP
 *
 * @author   Juan L. Sanchez <juan.sanchez@juanleonardosanchez.com>
 * @license  MIT
 * @version  1.3.0
 * @internal 12.04.2012
 */

namespace PHPBenchTime;

class Timer {

    private $startTime;
    private $pauseTime;
    private $endTime;
    private $phpVersion;
    private $lapName;
    private $isRunning;

    /**
     * Construct
     */
    public function __construct() {

    }


    /**
     * Starts the timer
     *
     * @param string $lapName
     * @return true Always returns true
     */
    public function Start( $lapName = "" ) {
        $this->isRunning = true;

        if ( empty( $this->phpVersion ) )
            $this->GetPHPVersion();

        if ( isset( $lapName ) ) {
            $this->startTime = (array)$this->startTime;
            $this->lapName   = $lapName;
        }

        # Set the current start value
        if ( is_array( $this->startTime ) ) { # Check if array (lap)
            if ( empty( $this->lapName ) )
                $this->startTime[] = $this->GetCurrentTime();
            else
                $this->startTime[$this->lapName] = $this->GetCurrentTime();
        } else {
            $this->startTime = $this->GetCurrentTime();
        }

        $this->pauseTime = 0;
        $this->endTime   = 0;

        return true;
    }


    /**
     * Starts a new lap
     *
     * @param string $lapName
     * @return true Always returns true
     */
    public function Lap( $lapName = "" ) {
        if ( isset( $lapName ) )
            $this->lapName = $lapName;

        # Cast startTime as array if its not an array, else
        if ( !is_array( $this->startTime ) )
            $this->startTime = array( $this->startTime );

        $this->Start();
    }


    /**
     * End timer function
     *
     * @return true Always returns true
     */
    public function End() {
        $this->isRunning = false;

        if ( is_array( $this->startTime ) )
            return array(
                'Laps'  => $this->startTime,
                'Total' => round( ( $this->GetCurrentTime() - $this->startTime[0] ), 4 )
            );

        else {
            return array(
                'Start' => $this->startTime,
                'End'   => $this->GetCurrentTime(),
                'Total' => $this->GetTotalTime()
            );
        }
    }


    /**
     * Returns an array containing a running summary of current timing
     *
     * @return array
     */
    public function Summary() {
        $summary = array(
            'running' => ( $this->isRunning === true ? "true" : "false" ),
            'start'   => ( isset( $this->startTime ) && !empty( $this->endTime ) ? $this->startTime : -1 ),
            'end'     => ( isset( $this->endTime ) && !empty( $this->endTime ) ? $this->endTime : -1 ),
            'total'   => $this->GetTotalTime(),
            'laps'    => ( is_array( $this->startTime ) ? $this->startTime : NULL )
        );

        return $summary;
    }


    /**
     * Pause timer function
     *
     * @return true Always returns true
     * @todo Implement Pause()
     */
    public function Pause() {
        $this->isRunning = false;
    }


    /**
     * Unpause timer function
     *
     * @return true Always returns true
     * @todo Implement Unpause()
     */
    public function Unpause() {
        $this->isRunning = true;
    }


    /**
     * Get the current timer value
     *
     * @return float current timer value
     * @param  int   Number of decimals to round to
     */
    private function GetTotalTime( $decimals = 4 ) {
        return round( ( $this->GetCurrentTime() - $this->startTime ), $decimals );
    }

    /**
     * Get the current time in seconds
     *
     * @return float Returns current time in float seconds
     */
    private function GetCurrentTime() {
        if ( $this->phpVersion < 5.0 ) {
            list( $usec, $sec ) = explode( " ", microtime() );

            return ( (float)$usec + (float)$sec );
        } else {
            return microtime( true );
        }
    }

    /**
     * Get the current PHP version
     *
     * @internal Sets $this->phpVersion
     */
    private function GetPHPVersion() {
        $this->phpVersion = (string)substr( PHP_VERSION, 0, 3 );
    }
}
