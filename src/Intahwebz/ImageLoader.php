<?php


namespace Intahwebz;

use Intahwebz\ImageFile;

interface ImageLoader{

	/**
	 * @param $srcFileName
	 * @return ImageFile
	 */
	function createImageFromFile($srcFileName);

	/**
	 * @param $blob
	 * @return ImageFile
	 */
	function createImageFromBlob($blob);

}



?>