<?php


namespace Intahwebz;


interface View {

	function getVariable($name);
	function call($functionArgs);

	function isVariableSet($string);

	//TODO - this name sucks
	function assign($variable, $value);
}



?>