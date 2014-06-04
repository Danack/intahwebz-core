<?php


namespace Intahwebz\Cache;


class InMemoryCache implements \Intahwebz\ObjectCache {

    private $data = []; 
    
    function __construct() {
    }

    function get($keyName) {
        if (array_key_exists($keyName, $this->data)) {
            return $this->data[$keyName];
        }

        return null;
    }

    function put($keyName, $object, $ttl = 60) {
        $this->data[$keyName] = $object; 
    }

    function clear($keyName) {
        unset($this->data[$keyName]);
    }
}




