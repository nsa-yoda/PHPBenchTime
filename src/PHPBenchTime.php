<?php
/**
 * PHPBenchTime
 * A light static benchmark timer class for PHP
 *
 * @author Juan L. Sanchez <juan.sanchez@juanleonardosanchez.com>
 * @license MIT
 * @version 1.0.1
 * @internal 11.17.2012
 */

namespace PHPBenchTime;

class Timer{
    private static $_startTime;
    private static $_pauseTime;
    private static $_endTime;
    private static $_phpVersion;
    private static $_lapName;

    /**
     * Construct
     */
    public function __construct(){}


    /**
     * Start timer function
     *
     * @return true Always returns true
     */
    public final static function Start($lapName){
        if(empty(self::$_phpVersion))
            self::_PHPVersion();

        if(isset($lapName)){
            self::$_startTime = (array)self::$_startTime;
            self::$_lapName = $lapName;
        }

        # Set the current start value
        if(is_array(self::$_startTime)){ # Check if array (lap)
            if(empty(self::$_lapName))
                self::$_startTime[] = self::_CurrentTimeFloat();
            else
                self::$_startTime[self::$_lapName] = self::_CurrentTimeFloat();
        } else {
            self::$_startTime = self::_CurrentTimeFloat();
        }

        self::$_pauseTime = 0;
        self::$_endTime = 0;
        return true;
    }


    /**
     * Lap timer function
     * Modifies the return into an array
     *
     * @return true Always returns true
     */
    public final static function Lap($lapName = ""){
        if(isset($lapName))
            self::$_lapName = $lapName;

        # Cast _startTime as array if its not an array, else
        if(!is_array(self::$_startTime))
            self::$_startTime = array(self::$_startTime);

        self::Start();
    }


    /**
     * Pause timer function
     *
     * @return true Always returns true
     * @todo Implement Pause()
     */
    public final static function Pause(){

    }

    
    /**
     * Unpause timer function
     *
     * @return true Always returns true
     * @todo Implement Unpause()
     */
    public final static function Unpause(){}


    /**
     * End timer function
     *
     * @return true Always returns true
     */
    public final static function End(){
        if(is_array(self::$_startTime))
            return self::$_startTime;
        else {
            return array(
                    'Start' => self::$_startTime,
                    'End' => self::_CurrentTimeFloat(),
                    'Total' => self::_TotalTime()
                   );
        }
    }
    

    /**
     * Get the current timer value
     *
     * @return rounded current timer value
     * @param int $decimals Number of decimals to round to
     */
    private final static function _TotalTime($decimals = 4){
        return round((self::_CurrentTimeFloat() - self::$_startTime), $decimals);
    }

    /**
     * Get the current time in seconds
     *
     * @return float Returns current time in float seconds
     */
    private final static function _CurrentTimeFloat(){
        if(self::$_phpVersion < 5.0){
            list($usec, $sec) = explode(" ", microtime());
            return ( (float)$usec + (float)$sec );
        } else {
            return microtime(true);
        }
    }

    /**
     * Get the current PHP version
     *
     * @internal Sets self::$_phpVersion
     */
    private final static function _PHPVersion(){
        self::$_phpVersion = (string)substr(PHP_VERSION, 0, 3);
    }
}
?>