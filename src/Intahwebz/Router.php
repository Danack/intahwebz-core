<?php


namespace Intahwebz;


interface Router {

	function generateCurrentURL($parameters, $absolute = false);

    function getRoute($routeName, $parameters = array());
    function generateURL(Routable $routable,  $absolute = false);
    function generateURLForRoute($routeName, $parameters = array(), $absolute = false);

    function forward($routeName, $parameters = array(), $absolute = false);

    function forwardToRoute(Route $route, $parameters, $absolute = false);

    /**
     * @param Request $request
     * @return Route
     */
    function getRouteForRequest(Request $request);
    
    /**
     * @param $routeName
     * @return \Intahwebz\Route
     */
    function	reRouteRequest($routeName);
}

