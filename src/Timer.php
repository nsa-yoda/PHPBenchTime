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

/**
 * TimerState
 * Enum-backed timer state
 */
enum TimerState: int
{
    case RUNNING = 1;
    case PAUSED  = 0;
    case STOPPED = -1;
}

class Timer
{
    /**
     * Maintains the state of the timer (RUNNING, PAUSED, STOPPED)
     * @var TimerState
     */
    private TimerState $state = TimerState::STOPPED;

    /**
     * Time that $this->start() was called
     * @var float
     */
    private float $startTime = 0.0;

    /**
     * Time that $this->end() was called
     * @var float
     */
    private float $endTime = 0.0;

    /**
     * Total time spent in pause
     * @var float
     */
    private float $totalPauseTime = 0.0;

    /**
     * Time spent in pause
     * @var float
     */
    private float $pauseTime = 0.0;

    /**
     * All laps
     * @var array
     */
    private array $laps = array();

    /**
     * Total lap count, inclusive of the current lap
     * @var int
     */
    private int $lapCount = 0;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * Resets the timers, laps and summary
     */
    public function reset(): void
    {
        $this->state          = TimerState::STOPPED;
        $this->startTime      = 0.0;
        $this->endTime        = 0.0;
        $this->totalPauseTime = 0.0;
        $this->pauseTime      = 0.0;
        $this->laps           = [];
        $this->lapCount       = 0;
    }

    /**
     * Starts the timer
     * @param string $name
     */
    public function start(string $name = "start"): void
    {
        $this->reset();
        $this->state = TimerState::RUNNING;

        # Set the start time
        $this->startTime = $this->getCurrentTime();

        # Create a lap with this start time - this is needded for laps to work
        $this->lap($name);
    }

    /**
     * Ends the timer
     */
    public function end(): void
    {
        # If someone ends while paused, finalize pause time first
        if ($this->state === TimerState::PAUSED) {
            $this->unpause();
        }

        $this->state = TimerState::STOPPED;

        # Set the end time
        $this->endTime = $this->getCurrentTime();

        # end the last lap - this is necessary for laps to output summary correctly
        $this->endLap();
    }

    /**
     * Creates a new lap in lap array property
     * @param null $name
     */
    public function lap(?string $name = null): void
    {
        $this->endLap(); # end the last lap - this is necessary

        # Create new lap
        $this->laps[] = array(
            "name"  => ( $name ? $name : $this->lapCount ),
            "start" => $this->getCurrentTime(),
            "end"   => -1.0,
            "total" => -1.0,
        );

        $this->lapCount += 1;
    }

    /**
     * Assign end and total times to the previous lap
     */
    public function endLap(): void
    {
        $lapCount = count($this->laps) - 1;
        if (count($this->laps) > 0) {
            $end = $this->getCurrentTime();
            $this->laps[$lapCount]['end']   = $end;
            $this->laps[$lapCount]['total'] = $this->laps[$lapCount]['end'] - $this->laps[$lapCount]['start'];
        }
    }

    /**
     * Returns a summary of all timer activity so far
     * @return array
     */
    public function summary(): array
    {
        $nowOrEnd   = ($this->endTime > 0.0) ? $this->endTime : $this->getCurrentTime();
        $rawTotal   = $nowOrEnd - $this->startTime;
        $activeTotal = max(0.0, $rawTotal - $this->totalPauseTime);

        return array(
            'running' => $this->state->value,
            'start'   => $this->startTime,
            'end'     => $this->endTime,
            'total'   => $activeTotal,
            'paused'  => $this->totalPauseTime,
            'laps'    => $this->laps
        );
    }

    /**
     * Initiates a pause in the timer
     */
    public function pause(): void
    {
        if ($this->state !== TimerState::RUNNING) {
            return;
        }

        $this->state = TimerState::PAUSED;
        $this->pauseTime = $this->getCurrentTime();
    }

    /**
     * Cancels the pause previously set
     */
    public function unpause(): void
    {
        if ($this->state !== TimerState::PAUSED) {
            return;
        }

        $this->state = TimerState::RUNNING;
        $this->totalPauseTime += $this->getCurrentTime() - $this->pauseTime;
        $this->pauseTime      = 0.0;
    }

    /**
     * Returns the current time
     * @return float
     */
    public function getCurrentTime(): float
    {
        return microtime(true);
    }

    /**
     * Returns the timer state
     * @return TimerState
     */
    public function getState(): TimerState
    {
        return $this->state;
    }

    /**
     * Returns time that $this->start() was called
     * @return float
     */
    public function getStartTime(): float
    {
        return $this->startTime;
    }

    /**
     * Returns time that $this->end() was called
     * @return float
     */
    public function getEndTime(): float
    {
        return $this->endTime;
    }

    /**
     * Returns total time spent in pause
     * @return float
     */
    public function getTotalPauseTime(): float
    {
        return $this->totalPauseTime;
    }

    /**
     * Returns time spent in pause (current pause only; 0 if not paused)
     * @return float
     */
    public function getPauseTime(): float
    {
        return $this->pauseTime;
    }

    /**
     * Returns all laps (copy-on-write array; callers should treat as read-only)
     * @return array
     */
    public function getLaps(): array
    {
        return $this->laps;
    }

    /**
     * Returns total lap count, inclusive of the current lap
     * @return int
     */
    public function getLapCount(): int
    {
        return $this->lapCount;
    }
}