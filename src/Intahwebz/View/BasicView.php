<?php


namespace Intahwebz\View;

use Intahwebz\View;

class BasicView implements View {

    private $variables = array();

    /**
     * @param $variable
     * @return bool
     */
    function getVariable($variable) {
        if (array_key_exists($variable, $this->variables) == true) {
            return $this->variables[$variable];
        }

        return false;
    }

//    /**
//     *
//     * TODO - should this be part of BaseTemplate as it is going to be the same for every view?
//     *
//     * @param $params
//     * @return mixed|void
//     */
//    function call($params) {
//        $functionName = array_shift($params);
//
//        if (array_key_exists($functionName, $this->boundFunctions) == true) {
//            return call_user_func_array($this->boundFunctions[$functionName], $params);
//        }
//
//        if (method_exists($this, $functionName) == false) {
//            throw new JigException("No method $functionName");
//        }
//
//        return call_user_func_array([$this, $functionName], $params);
//    }


    function isVariableSet($string){
        return array_key_exists($string, $this->variables);
        //return false;
    }

    function assign($variable, $value){
        $this->variables[$variable] = $value;
    }
}



?>