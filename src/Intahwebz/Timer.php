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
        $this->description = null;
    }

    function dumpTime() {

        $totals = array();

        foreach ($this->timeRecords as $timeRecord) {
            $time = $timeRecord[0];
            $description =  $timeRecord[1];

            if(isset($totals[$description])) {
                $total = $totals[$description];
                $total['called'] += 1;
                $total['time'] += $time;
            }
            else {
                $total = array();
                $total['called'] = 1;
                $total['time'] = $time;

                $totals[$description] = $total;
            }
        }

        echo "Timer results\n";

        foreach ($totals as $description => $total) {
            echo '"'.$description.'", ';
            echo 'called '.$total['called'].' time, ';
            
            
            $time = $total['time'];
            
            if ($time < 0.000001) {
                $time = ' < 0.000001';
            }
            else {
                $time = round($time, 6);
            }
            
            echo 'total time:'.$time."\n";
        }
    }
}

 