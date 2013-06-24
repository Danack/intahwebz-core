<?php


namespace Intahwebz;


interface Router {

	static function	generateCurrentURL($parameters, $absolute = FALSE);

	static function generateURLForRoute($routeName, $parameters = array(), $absolute = FALSE);

	static function forward($routeName, $parameters = array(), $absolute = FALSE);

	static function forwardToRoute($route, $parameters, $absolute = false);

	//Todo - probably shouldn't need to pass in the view
	function	reRouteRequest($routeName, $view);
}



?>