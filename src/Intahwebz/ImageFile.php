<?php


namespace Intahwebz;

echo "Lol this is amazing....";
exit(0);

abstract class ImageFile {

	public $srcWidth, $srcHeight;
	public $destWidth, $destHeight;

	abstract function saveImage($destFileName);

	function setWidthHeightFromWidth($newWidth) {
		$newHeight = ($newWidth * $this->srcHeight) / $this->srcWidth;
		$this->destWidth = intval(ceil($newWidth));
		$this->destHeight = intval(ceil($newHeight));
	}

	function setWidthHeightFromHeight($newHeight) {
		$newWidth = ($newHeight * $this->srcWidth) / $this->srcHeight;
		$this->destWidth = intval(ceil($newWidth));
		$this->destHeight = intval(ceil($newHeight));
	}

	function setWidthHeightFromMaxDimensions($maxWidth, $maxHeight) {
		$ratio = $this->srcWidth / $this->srcHeight;

		$newWidth = false;
		$newHeight = false;


		if($this->srcWidth > $maxWidth || $this->srcHeight > $maxHeight){
			$newWidth = $maxWidth;
			$newHeight = $newWidth / $ratio;

			if($newHeight > $maxHeight){
				$newHeight  = $maxHeight;
				$newWidth = $maxHeight * $ratio;
			}
		}

		$newWidth = intval(ceil($newWidth));
		$newHeight = intval(ceil($newHeight));

		$this->destWidth = $newWidth;
		$this->destHeight = $newHeight;
	}

	function setResize($resizeParam){
		if($resizeParam == 'thumbnail' || $resizeParam == 'thumb'){
			$this->setWidthHeightFromMaxDimensions(THUMBNAIL_SIZE, THUMBNAIL_SIZE);
		}

		if ($resizeParam == 'original') {
			//TODO - Avoid resize
			$this->destWidth = $this->srcWidth;
			$this->destHeight = $this->srcHeight;;
			return;
		}

		$pattern = '#(\d+)([a-zA-Z]*)(\d*)#u';

		$matchResult = preg_match($pattern, $resizeParam, $matches);

		if ($matchResult == 0) {
			//Match failed, just set Thumbnail size
			$this->setWidthHeightFromMaxDimensions(THUMBNAIL_SIZE, THUMBNAIL_SIZE);
			return;
		}

		$size = intval($matches[1]);
		if ($size <= 1) {
			$this->setWidthHeightFromMaxDimensions(THUMBNAIL_SIZE, THUMBNAIL_SIZE);
			return;
		}

		$setting = strtolower($matches[2]);

		switch($setting) {

			case('x'): {
				$height = $this->clampValue($matches[3]);
				$this->destWidth = $size;
				$this->destHeight = $height;
				return;
			}

			case('w'): {
				$this->setWidthHeightFromWidth($size);
				return;
			}

			case('h'): {
				$this->setWidthHeightFromHeight($size);
				return;
			}

			default:{
				$this->setWidthHeightFromMaxDimensions($size, $size);
				return;
			}
		}
	}

	function clampValue($height){
		$height = intval($height);

		if ($height < 5) {
			$height = 5;
		}
		else if ($height > 2048) {
			$height = 2048;
		}

		return $height;
	}

}