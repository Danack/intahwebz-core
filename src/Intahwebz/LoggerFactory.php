<?php


namespace Intahwebz;

use Psr\Log\AbstractLogger;

interface LoggerFactory {

	/**
	 * return AbstractLogger;
	 */
	function get($object);
}


