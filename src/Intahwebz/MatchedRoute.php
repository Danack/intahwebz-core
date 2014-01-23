<?php


namespace Intahwebz;


class MatchedRoute {

    /**
     * @var \Intahwebz\Route
     */
    private $route;
    
    private $params;
    
    function __construct(\Intahwebz\Route $route, array $params) {
        $this->params = $params;
        $this->route = $route;
    }

    /**
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @return \Intahwebz\Route
     */
    public function getRoute() {
        return $this->route;
    }
}

 