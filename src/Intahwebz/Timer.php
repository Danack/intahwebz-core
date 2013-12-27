<?php


namespace Intahwebz;


class Timer {

    private $timeRecords = array();

    private $startTime = null;
    private $description = null;

    function startTimer($description) {
        if ($this->startTime != null) {
            $this->stopTimer();
        }

        $this->startTime = microtime(true);
        $this->description = $description;
    }

    function stopTimer() {
        $time = microtime(true) - $this->startTime;
        $this->timeRecords[] = array($time, $this->description);

        $this->startTime = null;
        $this->lineNumber = null;
        $this->description = null;
    }

    function dumpTime() {
        var_dump($this->timeRecords);
    }
}

 