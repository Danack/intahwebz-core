<?php


namespace Intahwebz\Logger;

use Psr\Log\LoggerInterface;


class EchoLogger implements LoggerInterface{

    private function process(
        $message,
        /** @noinspection PhpUnusedParameterInspection */ $context) { 
        echo $message."\n";
    }
    
    public function emergency($message, array $context = array()) {
        $this->process("Emergency: ".$message, $context);
    }

    public function alert($message, array $context = array()) {
        $this->process("Alert: ".$message, $context);
    }

    public function critical($message, array $context = array()) {
        $this->process("Critical: ".$message, $context);
    }

    public function error($message, array $context = array()) {
        $this->process("Error: ".$message, $context);
    }

    public function warning($message, array $context = array()) {
        $this->process("Warning: ".$message, $context);
    }

    public function notice($message, array $context = array()) {
        $this->process("Notice: ".$message, $context);
    }

    public function info($message, array $context = array()) {
        $this->process("Info: ".$message, $context);
    }

    public function debug($message, array $context = array()) {
        $this->process("Debug: ".$message, $context);
    }

    public function log($level, $message, array $context = array()) {
        $this->process("Log: ".$message, $context);
    }
}

 