<?php


namespace Intahwebz;


interface Router {

	function	generateCurrentURL($parameters, $absolute = FALSE);

	function generateURLForRoute($routeName, $parameters = array(), $absolute = FALSE);

	function forward($routeName, $parameters = array(), $absolute = FALSE);

	function forwardToRoute($route, $parameters, $absolute = false);

	//Todo - probably shouldn't need to pass in the view
	function	reRouteRequest($routeName, $view);
}



?>