<?php


namespace Intahwebz;


interface Request {

    function getClientIP();
    function getHostName();
    function setRouteParameters($routeParameters);
    function getScheme();
    function getRequestParams();
    function getPath();
    function getPort();
    function getMethod();

    function getReferrer();
        /**
     * @param $variableName
     * @param mixed $default
     * @param mixed $minimum
     * @param mixed $maximum
     * @return mixed
     */
    function getVariable($variableName, $default = false, $minimum = false, $maximum = false);

    function checkIfModifiedHeader($unixTime);
    
} 