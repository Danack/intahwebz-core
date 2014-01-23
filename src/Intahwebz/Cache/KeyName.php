<?php


namespace Intahwebz\Cache;


trait KeyName {

    static function getClassKey($entity = null) {
        $key = get_class();
        
        if ($entity) {
            $key .= $entity;
        }

        return $key;
    }
}

 