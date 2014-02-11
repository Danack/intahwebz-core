<?php


namespace Intahwebz\Cache;


trait KeyName {

    static function getClassKey($entity = null) {
        $key = get_class();
        
        if ($entity) {
            //NEVER USE AN UNDERSCORE AS A SEPARATOR - it confuses the autoloader.
            $key .= 'X'.$entity;
        }

        return $key;
    }
}

 