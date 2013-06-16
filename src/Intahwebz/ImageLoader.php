<?php


namespace Intahwebz;


interface ImageLoader{

	function createImageFromFile($srcFileName);
	function createImageFromBlob($blob);

}



?>