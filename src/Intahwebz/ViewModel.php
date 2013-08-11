<?php


namespace Intahwebz;


interface ViewModel
{

	function getVariable($name);

    /**
     * @param array $functionArgs First entry is function name, the rest are the function parameters.
     * @return mixed
     */
    function call(array $functionArgs);


	function isVariableSet($string);

	//TODO - this name sucks
	function assign($variable, $value);
}



?>