<?php

namespace Intahwebz {


class Functions{
	public static function wtf(){
	}
}

}


namespace { // global code

function getClassName($namespaceClass) {
	$lastSlashPosition = mb_strrpos($namespaceClass, '\\');

	if ($lastSlashPosition !== false){
		return mb_substr($namespaceClass, $lastSlashPosition + 1);
	}

	return $namespaceClass;
}

function getNamespace($namespaceClass) {
	$lastSlashPosition = mb_strrpos($namespaceClass, '\\');

	if ($lastSlashPosition !== false){
		return mb_substr($namespaceClass, 0, $lastSlashPosition);
	}

	return "\\";
}

}

?>