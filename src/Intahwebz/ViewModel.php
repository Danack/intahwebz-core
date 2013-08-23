<?php


namespace Intahwebz;


interface ViewModel {

    /**
     * @param array $functionArgs First entry is function name, the rest are the function parameters.
     * @return mixed
     */
    function call(array $functionArgs);

    function getVariable($name);

    function isVariableSet($name);

    function setVariable($name, $value);
}
