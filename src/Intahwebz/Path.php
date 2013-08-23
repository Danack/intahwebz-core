<?php


namespace Intahwebz;


class Path {

    private $path;

    function __construct($string) {
        $this->path = $string;
    }

    function getPath() {
        return $this->path;
    }
}




?> 