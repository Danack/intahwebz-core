<?php

namespace Intahwebz;

/**
 * Helper class that just holds data about the controllers for routes.
 */
interface RouteMapping {

  
    /**
     * Gets the class path for mapped controller
     *
     * @return string
     */
    function getClassPath();
    
    
    function getMethodName();
    
    
    function getScheme();
    

}

