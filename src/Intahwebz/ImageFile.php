<?php


namespace Intahwebz;


interface ImageFile {

	function saveImage($destFileName);

	function setResize($resizeParam);

	function setWidthHeight($maxWidth, $maxHeight);
}