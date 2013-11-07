<?php


namespace Intahwebz\Cache;


class APCObjectCache implements \Intahwebz\ObjectCache {

    function __construct() {
    }

    function 	get($keyName){
        $result = apc_fetch($keyName, $success);
        if ($success === false){
            return null;
        }
        return $result;
    }

    function 	put($keyName, $object, $ttl = 60){
        apc_store($keyName, $object, $ttl);
    }

    function	clear($keyName){
        apc_delete($keyName);
    }
}




