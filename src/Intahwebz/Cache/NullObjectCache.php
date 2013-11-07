<?php


namespace Intahwebz\Cache;


class NullObjectCache implements \Intahwebz\ObjectCache {

	function 	get($keyName){
		return null;
	}

	function 	put($keyName, $object, $ttl = 360){
		//Do nothing
	}

	function	clear($keyname){
		//Nothing to clear.
	}
}


