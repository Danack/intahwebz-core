<?php


namespace Intahwebz;

use Intahwebz\Route;

interface Router {

	function generateCurrentURL($parameters, $absolute = false);

    function generateURL(Routable $routable,  $absolute = false);
    function generateURLForRoute($routeName, $parameters = array(), $absolute = false);

    function forward($routeName, $parameters = array(), $absolute = false);

    function forwardToRoute(Route $route, $parameters, $absolute = false);

    /**
     * @param $routeName
     * @return \Intahwebz\Route
     */
    function	reRouteRequest($routeName);
}



?>