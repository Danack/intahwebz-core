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
		$newWidth = ($newHeight * $this->srcHeight) / $this->srcWidth;
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
			$size = THUMBNAIL_SIZE;
			$this->setWidthHeightFromMaxDimensions(THUMBNAIL_SIZE, THUMBNAIL_SIZE);
		}

		if ($size == 'original') {
			//TODO - Avoid resize
			$this->destWidth = $this->srcWidth;
			$this->destHeight = $this->srcHeight;;
			return;
		}

		$pattern = '#(\d+)(\w?)#u';

		$matches = preg_match($pattern, $resizeParam, $match);

		if ($matches == 0) {
			//Match failed, just set Thumbnail size
			$this->setWidthHeightFromMaxDimensions(THUMBNAIL_SIZE, THUMBNAIL_SIZE);
		}

		var_dump($matches);

		return $size;
	}

}