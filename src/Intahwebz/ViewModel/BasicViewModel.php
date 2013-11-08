<?php


namespace Intahwebz\ViewModel;

use Intahwebz\ViewModel;

class BasicViewModel implements ViewModel {

    /**
     * @var array Stores the bound functions that are available through the viewModel
     */
    private $boundFunctions = array();

    protected $template;

    protected $routeParams = array();

    protected $response = null;

    /**
     * @var \Intahwebz\Route
     */
    protected $route;
    
    /**
     * @var array Stores the variables available in the ViewModel
     */
    private $variables = array();

    /**
     * @param $name
     * @internal param $variable
     * @return mixed
     */
    function getVariable($name) {
        if (array_key_exists($name, $this->variables) == true) {
            return $this->variables[$name];
        }

        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    function isVariableSet($name){
        return array_key_exists($name, $this->variables);
    }

    /**
     * @param $name
     * @param $value
     */
    function setVariable($name, $value){
        $this->variables[$name] = $value;
    }

    /**
     * @param $functionName
     * @param callable $callable
     */
    function bindFunction($functionName, callable $callable){
        $this->boundFunctions[$functionName] = $callable;
    }



    /**
     * @param array $params
     * @return mixed
     * @throws ViewModelException
     * 
     * TODO - should this be replaced with one method to get the callable, and then calling it from the calling code?
     * That would make the stack trace be smaller.
     */
    function call(array $params) {
        $functionName = array_shift($params);

        if (array_key_exists($functionName, $this->boundFunctions) == true) {
            return call_user_func_array($this->boundFunctions[$functionName], $params);
        }

        if (method_exists($this, $functionName) == true) {
            return call_user_func_array([$this, $functionName], $params);
        }

        throw new ViewModelException("No method [$functionName]");
    }

    
    function setTemplate($templateFile) {
        $this->template = $templateFile;
    }

    function getTemplate() {
        return $this->template;
    }

    /**
     * @param $message
     * @return mixed
     */
    function addStatusMessage($message) {
        //does nothing - for now.
    }

    function getStatusMessages() {
        return array();
    }

    function setRoute(\Intahwebz\Route $route){
        $this->route = $route;
    }
    
    function setRouteParams(array $params){
        $this->routeParams = $params;
    }

    /**
     * @param $data
     */
    function setResponse($data){
        $this->response = $data;
    }
}

