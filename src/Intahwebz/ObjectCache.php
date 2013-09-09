<?php


namespace Intahwebz;


interface ObjectCache {

	function 	get($keyName);
	function 	put($keyName, $object, $ttl);
	function	clear($keyName);
}