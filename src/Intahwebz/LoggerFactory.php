<?php


namespace Intahwebz;


interface LoggerFactory {

	/**
	 * return Psr\Log\AbstractLogger;
	 */
	function get($object);
}


