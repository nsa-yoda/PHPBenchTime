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

    private $starTime;
    private $pauseTime;
    private $endTime;
    private $phpVersion;
    private $lapName;

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
    public final function Start( $lapName = "" ) {
        if ( empty( $this->phpVersion ) )
            $this->GetPHPVersion();

        if ( isset( $lapName ) ) {
            $this->starTime = (array)$this->starTime;
            $this->lapName   = $lapName;
        }

        # Set the current start value
        if ( is_array( $this->starTime ) ) { # Check if array (lap)
            if ( empty( $this->lapName ) )
                $this->starTime[] = $this->GetCurrentTime();
            else
                $this->starTime[$this->lapName] = $this->GetCurrentTime();
        } else {
            $this->starTime = $this->GetCurrentTime();
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
    public final function Lap( $lapName = "" ) {
        if ( isset( $lapName ) )
            $this->lapName = $lapName;

        # Cast starTime as array if its not an array, else
        if ( !is_array( $this->starTime ) )
            $this->starTime = array( $this->starTime );

        $this->Start();
    }


    /**
     * Pause timer function
     *
     * @return true Always returns true
     * @todo Implement Pause()
     */
    public final function Pause() {

    }


    /**
     * Unpause timer function
     *
     * @return true Always returns true
     * @todo Implement Unpause()
     */
    public final function Unpause() {

    }


    /**
     * End timer function
     *
     * @return true Always returns true
     */
    public final function End() {
        if ( is_array( $this->starTime ) )
            return array(
                'Laps'  => $this->starTime,
                'Total' => round( ( $this->GetCurrentTime() - $this->starTime[0] ), 4 )
            );

        else {
            return array(
                'Start' => $this->starTime,
                'End'   => $this->GetCurrentTime(),
                'Total' => $this->GetTotalTime()
            );
        }
    }


    /**
     * Get the current timer value
     *
     * @return float current timer value
     * @param  int   Number of decimals to round to
     */
    private final function GetTotalTime( $decimals = 4 ) {
        return round( ( $this->GetCurrentTime() - $this->starTime ), $decimals );
    }

    /**
     * Get the current time in seconds
     *
     * @return float Returns current time in float seconds
     */
    private final function GetCurrentTime() {
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
    private final function GetPHPVersion() {
        $this->phpVersion = (string)substr( PHP_VERSION, 0, 3 );
    }
}
