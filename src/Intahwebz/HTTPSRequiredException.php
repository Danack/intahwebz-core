<?php


namespace Intahwebz;


class HTTPSRequiredException extends \Exception {

    private $redirectAutomatically;

    public function __construct($redirectAutomatically, $message = "", $code = 0, Exception $previous = null) { 
        parent::__construct($message, $code, $previous);
        $this->redirectAutomatically = $redirectAutomatically;
    
    }

    /**
     * @return string
     */
    public function getRedirectAutomatically() {
        return $this->redirectAutomatically;
    }
    
    
    
}

 