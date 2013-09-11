<?php

namespace Intahwebz;

/**
 * Helper class that just holds data about the controllers for routes.
 */
class RouteMapping {

    public	$scheme;		//"BaseReality\\Controller",

    public	$className;		// "Images",

    public 	$methodName;		// "show",

    public function	__construct($routeMappingInfo){
        $this->scheme = $routeMappingInfo[0];
        $this->className = $routeMappingInfo[1];
        $this->methodName = $routeMappingInfo[2];
    }

    /**
     * Gets the class path for mapped controller
     *
     * @return string
     */
    function getClassPath(){
        $classPath = $this->className;

        if(mb_strlen($this->scheme) > 0){
            $classPath = $this->scheme."\\".$this->className;
        }

        return $classPath;
    }
}

