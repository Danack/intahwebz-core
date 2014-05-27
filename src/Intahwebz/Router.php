<?php


namespace Intahwebz;


interface Router {

    /**
     * @param $routeName
     * @return Route
     */
    function getRoute($routeName);
    function generateURLForRoute(
        $routeName,
        $parameters = array(),
        $absolute = false
    );

    /**
     * @param Request $request
     * @return \Intahwebz\MatchedRoute
     */
    function matchRouteForRequest(Request $request);
}

