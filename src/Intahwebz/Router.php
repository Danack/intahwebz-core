<?php


namespace Intahwebz;


interface Router {

	function generateCurrentURL($parameters, $absolute = false);

    function getRoute($routeName, $parameters = array());
    function generateURL(Routable $routable,  $absolute = false);
    function generateURLForRoute($routeName, $parameters = array(), $absolute = false);

    /**
     * Redirect (302) a request
     * @param $routeName
     * @param array $parameters
     * @param bool $absolute
     * @return mixed
     */
    function forward($routeName, $parameters = array(), $absolute = false);

    /**
     * @param Request $request
     * @return Route
     */
    function getRouteForRequest(Request $request);
    
    /**
     * Reroute a request internally (same process).
     * @param $routeName
     * @return \Intahwebz\Route
     */
    function	reRouteRequest($routeName);
}

