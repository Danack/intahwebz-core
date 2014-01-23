<?php


namespace Intahwebz;


interface Router {

    function getRoute($routeName);
    function generateURL(Routable $routable,  $absolute = false);
    function generateURLForRoute($routeName, $parameters = array(), $absolute = false);

    /**
     * @param Request $request
     * @return \Intahwebz\MatchedRoute
     */
    function matchRouteForRequest(Request $request);
}

