<?php


namespace Intahwebz;


class Path {

    private $path;

    function __construct($string) {
        if ($string == null) {
            throw new \Exception("Path cannot be null for class ".get_class($this));
        }
        $this->path = $string;
    }

    function getPath() {
        return $this->path;
    }

    function getSafePath($directory) {
        
        if (!$directory) {
            throw new \Exception("directory is false, cannot build path from it.");
        }
        if (strlen($directory) < 1) {
            throw new \Exception("directory is zero length, cannot build path from it.");
        }
        return $this->path.'/'.$directory.'/';
    }
}


