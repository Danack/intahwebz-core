<?php


namespace Intahwebz;


interface Request {

    function getHostName();
    function getRefererParams();
    function setRouteParameters($routeParameters);
    function getScheme();
    function getRequestParams();
    function getPath();
    function getPort();
    function getMethod();
    function getVariable($variableName, $default = false, $minimum = false, $maximum = false);
} 