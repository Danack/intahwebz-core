<?php


namespace Intahwebz;


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

		$pattern = '#(\d+)(\w?)#u';

		$matchResult = preg_match($pattern, $resizeParam, $matches);

		//var_dump($matches);
		//exit(0);
		if ($matchResult == 0) {
			//Match failed, just set Thumbnail size
			$this->setWidthHeightFromMaxDimensions(THUMBNAIL_SIZE, THUMBNAIL_SIZE);
		}

		$size = $matches[1];
		$setting = strtolower($matches[2]);

		switch($setting) {
			case('w'): {
				$this->setWidthHeightFromWidth($size);
				break;
			}

			case('h'): {
				$this->setWidthHeightFromHeight($size);
				break;
			}

			default:{
			$this->setWidthHeightFromMaxDimensions($size, $size);
			break;
			}
		}
	}

}