<?php
namespace Intahwebz;

interface Session {

	public static function setSessionVariable($sessionName, $serializedData);

	public static function getSessionVariable($name, $default = false, $clear = false);

	public static function unsetSessionVariable($sessionName);

}