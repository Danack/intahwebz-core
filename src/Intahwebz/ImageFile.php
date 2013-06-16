<?php


namespace Intahwebz;


interface ImageFile {

	function saveImage($destFileName);

	function setWidthHeight($maxWidth, $maxHeight);
}