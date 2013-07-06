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

function convertNamespaceClassToFilepath($namespaceClass){
	return mb_str_replace('\\', "/",  $namespaceClass);
}


	function ensureDirectoryExists($filePath){
		$pathSegments = array();

		$slashPosition = 0;
		$finished = false;

		while($finished === false){

			$slashPosition = mb_strpos($filePath, '/', $slashPosition + 1);

			if($slashPosition === false ){
				$finished = true;
			}
			else{
				$pathSegments[] = mb_substr($filePath, 0, $slashPosition);
			}

			$maxPaths = 20;
			if (count($pathSegments) > $maxPaths){
				throw new \Exception("Trying to create a directory more than $maxPaths deep. What is wrong with you?");
			}
		}

		foreach($pathSegments as $segment){
			//echo "check $segment<br/>";

			if(file_exists($segment) === false){
				//echo "Had to create directory $segment";
				$result = mkdir($segment);

				if($result == false){
					throw new \Exception("Failed to create segment [$segment] in ensureDirectoryExists($filePath).");
					return false;
				}
			}
		}

		return true;
	}



	function renameMultiplatform($oldFilename, $newFilename) {
		$result = true;

		ensureDirectoryExists($newFilename);

		$renameResult = rename($oldFilename, $newFilename);

		if (!$renameResult) {
			if (copy($oldFilename, $newFilename) == true) {
				unlink($oldFilename);
				$result = true;
			}
			else{
				$result = false;
			}
		}

		return $result;
	}



	function convertFilepathToNamespaceClass($filepath){

		$dotPosition = mb_strpos($filepath, '.');
		if ($dotPosition !== false){
			$filepath = mb_substr($filepath, 0, $dotPosition);
		}

		return mb_str_replace("/", '\\', $filepath);
	}


	define('OBJECT_TYPE', 'x-objectType');

	function parse_classname($name){
		return array(
			'namespace' => array_slice(explode('\\', $name), 0, -1),
			'classname' => join('', array_slice(explode('\\', $name), -1)),
		);
	}

	function class_uses_deep($class, $autoload = true) {
		$traits = [];
		do {
			$traits = array_merge(class_uses($class, $autoload), $traits);
		} while($class = get_parent_class($class));
		foreach ($traits as $trait => $same) {
			$traits = array_merge(class_uses($trait, $autoload), $traits);
		}
		return array_unique($traits);
	}



	/**
	 * Return a JSON string for all of the public variables of an object.
	 *
	 *
	 * @param $object
	 * @return string
	 */
	function json_encode_object_internal($object){
		if (is_object($object) == true || is_array($object) == true) {
			$params = array();

			if (is_object($object) == true) {
				$type = get_class($object);
				$params[OBJECT_TYPE] = $type;
			}

			foreach ($object as $key => $value) {
				$value = json_encode_object_internal($value);
				$params[$key] = $value;
			}

			return $params;
		}

		return $object;
	}

	function json_encode_object($object){
		$params = json_encode_object_internal($object);
		//return json_encode($params, JSON_HEX_APOS|JSON_PRETTY_PRINT);
		//Cannot use pretty print - it breaks Javascript :(
		return json_encode($params, JSON_HEX_APOS);
	}


	function json_decode_object($jsonString){
		$jsonData = json_decode($jsonString, true);
		return json_decode_object_internal($jsonData);
	}


	function json_decode_object_internal($jsonData){
		if (is_array($jsonData)) {
			$data = array();
			$isObject = false;

			if (array_key_exists(OBJECT_TYPE, $jsonData) == true) {
				$objectType = $jsonData[OBJECT_TYPE];
				$data = new $objectType();
				$isObject = true;
			}

			foreach ($jsonData as $key => $value) {
				if ($key == OBJECT_TYPE) {
					continue;
				}

				if (is_array($value) == true) {
					$value = json_decode_object_internal($value);
				}

				if ($isObject == true) {
					$data->$key = $value;
				}
				else{
					$data[$key] = $value;
				}
			}

			return $data;
		}
		return $jsonData; //was a value
	}

}

?>