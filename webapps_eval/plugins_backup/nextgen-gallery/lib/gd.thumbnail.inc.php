<?php
/**
 * gd.thumbnail.inc.php
 * 
 * @author 		Ian Selby (ian@gen-x-design.com)
 * @copyright 	Copyright 2006-2009
 * @version 	1.2.0 (based on 1.1.3)
 * @modded      by Alex Rabe
 * 
 */

/**
 * PHP class for dynamically resizing, cropping, and rotating images for thumbnail purposes and either displaying them on-the-fly or saving them.
 *
 */
class ngg_Thumbnail {
    /**
     * Error message to display, if any
     *
     * @var string
     */
    var $errmsg;
    /**
     * Whether or not there is an error
     *
     * @var boolean
     */
    var $error;
    /**
     * Format of the image file
     *
     * @var string
     */
    var $format;
    /**
     * File name and path of the image file
     *
     * @var string
     */
    var $fileName;
    /**
     * Current dimensions of working image
     *
     * @var array
     */
    var $currentDimensions;
    /**
     * New dimensions of working image
     *
     * @var array
     */
    var $newDimensions;
    /**
     * Image resource for newly manipulated image
     *
     * @var resource
     * @access private
     */
    var $newImage;
    /**
     * Image resource for image before previous manipulation
     *
     * @var resource
     * @access private
     */
    var $oldImage;
    /**
     * Image resource for image being currently manipulated
     *
     * @var resource
     * @access private
     */
    var $workingImage;
    /**
     * Percentage to resize image by
     *
     * @var int
     * @access private
     */
    var $percent;
    /**
     * Maximum width of image during resize
     *
     * @var int
     * @access private
     */
    var $maxWidth;
    /**
     * Maximum height of image during resize
     *
     * @var int
     * @access private
     */
    var $maxHeight;
    /**
     * Image for Watermark
     *
     * @var string
     * 
     */
    var $watermarkImgPath;
    /**
     * Text for Watermark
     *
     * @var string
     * 
     */
    var $watermarkText;
    /**
     * Image Resource ID for Watermark
     *
     * @var string
     * 
     */
    function ngg_Thumbnail($fileName,$no_ErrorImage = false) {
        //make sure the GD library is installed
    	if(!function_exists("gd_info")) {
        	echo 'You do not have the GD Library installed.  This class requires the GD library to function properly.' . "\n";
        	echo 'visit http://us2.php.net/manual/en/ref.image.php for more information';
        	exit;
        }
    	//initialize variables
        $this->errmsg               = '';
        $this->error                = false;
        $this->currentDimensions    = array();
        $this->newDimensions        = array();
        $this->fileName             = $fileName;
        $this->percent              = 100;
        $this->maxWidth             = 0;
        $this->maxHeight            = 0;
        $this->watermarkImgPath		= '';
        $this->watermarkText		= '';

        //check to see if file exists
        if(!file_exists($this->fileName)) {
            $this->errmsg = 'File not found';
            $this->error = true;
        }
        //check to see if file is readable
        elseif(!is_readable($this->fileName)) {
            $this->errmsg = 'File is not readable';
            $this->error = true;
        }

        //if there are no errors, determine the file format
        if($this->error == false) {
            //check if gif
            if(stristr(strtolower($this->fileName),'.gif')) $this->format = 'GIF';
            //check if jpg
            elseif(stristr(strtolower($this->fileName),'.jpg') || stristr(strtolower($this->fileName),'.jpeg')) $this->format = 'JPG';
            //check if png
            elseif(stristr(strtolower($this->fileName),'.png')) $this->format = 'PNG';
            //unknown file format
            else {
                $this->errmsg = 'Unknown file format';
                $this->error = true;
            }
        }
        
		// increase memory-limit if possible, GD needs this for large images
		// @ini_set('memory_limit', '128M');
        
		if($this->error == false) { 
        // Check memory consumption if file exists
			$this->checkMemoryForImage($this->fileName);
		}

        //initialize resources if no errors
        if($this->error == false) { 

            switch($this->format) {            	
                case 'GIF':
                    $this->oldImage = ImageCreateFromGif($this->fileName);
                    break;
                case 'JPG':
                       $this->oldImage = ImageCreateFromJpeg($this->fileName);
                    break;
                case 'PNG':
                    $this->oldImage = ImageCreateFromPng($this->fileName);
					break;
            }
			if (!$this->oldImage) { 
				$this->errmsg = 'Create Image failed. Check memory limit';
		        $this->error = true;
		    } else {
	            $size = GetImageSize($this->fileName);
    	        $this->currentDimensions = array('width'=>$size[0],'height'=>$size[1]);
	            $this->newImage = $this->oldImage;
	        }
        }


        if($this->error == true) {
        	if(!$no_ErrorImage)
            	$this->showErrorImage();
            return;
        }
    }

    /**
     * Calculate the memory limit
     *
     */
	function checkMemoryForImage( $filename ){
		
		if ( (function_exists('memory_get_usage')) && (ini_get('memory_limit')) ) {
			$imageInfo = getimagesize($filename);
			switch($this->format) {            	
                case 'GIF':
                	// measured factor 1 is better
                    $CHANNEL = 1;
                    break;
                case 'JPG':
                    $CHANNEL = $imageInfo['channels'];
                    break;
                case 'PNG':
					// didn't get the channel for png
                    $CHANNEL = 3;
					break;
            }
		    $MB = 1048576;  // number of bytes in 1M
		    $K64 = 65536;    // number of bytes in 64K
		    $TWEAKFACTOR = 1.68;  // Or whatever works for you
		    $memoryNeeded = round( ( $imageInfo[0] * $imageInfo[1]
		                                           * $imageInfo['bits']
		                                           * $CHANNEL / 8
		                             + $K64
		                           ) * $TWEAKFACTOR
		                         );
		    $memoryNeeded = memory_get_usage() + $memoryNeeded;
			// get memory limit
			$memory_limit = ini_get('memory_limit');
			if ($memory_limit != '') {
				$memory_limit = substr($memory_limit, 0, -1) * 1024 * 1024;
			}
			
			if ($memoryNeeded > $memory_limit) {
				$memoryNeeded = round ($memoryNeeded / 1024 / 1024, 2);
				$this->errmsg = 'Exceed Memory limit. Require : '.$memoryNeeded. " MByte" ;
		        $this->error = true;
	        }
		}
	    return;
	}

    /**
     * Must be called to free up allocated memory after all manipulations are done
     *
     */
    function destruct() {
        if(is_resource($this->newImage)) @ImageDestroy($this->newImage);
        if(is_resource($this->oldImage)) @ImageDestroy($this->oldImage);
        if(is_resource($this->workingImage)) @ImageDestroy($this->workingImage);
    }

    /**
     * Returns the current width of the image
     *
     * @return int
     */
    function getCurrentWidth() {
        return $this->currentDimensions['width'];
    }

    /**
     * Returns the current height of the image
     *
     * @return int
     */
    function getCurrentHeight() {
        return $this->currentDimensions['height'];
    }

    /**
     * Calculates new image width
     *
     * @param int $width
     * @param int $height
     * @return array
     */
    function calcWidth($width,$height) {
        $newWp = (100 * $this->maxWidth) / $width;
        $newHeight = ($height * $newWp) / 100;
        return array('newWidth'=>intval($this->maxWidth),'newHeight'=>intval($newHeight));
    }

    /**
     * Calculates new image height
     *
     * @param int $width
     * @param int $height
     * @return array
     */
    function calcHeight($width,$height) {
        $newHp = (100 * $this->maxHeight) / $height;
        $newWidth = ($width * $newHp) / 100;
        return array('newWidth'=>intval($newWidth),'newHeight'=>intval($this->maxHeight));
    }

    /**
     * Calculates new image size based on percentage
     *
     * @param int $width
     * @param int $height
     * @return array
     */
    function calcPercent($width,$height) {
        $newWidth = ($width * $this->percent) / 100;
        $newHeight = ($height * $this->percent) / 100;
        return array('newWidth'=>intval($newWidth),'newHeight'=>intval($newHeight));
    }

    /**
     * Calculates new image size based on width and height, while constraining to maxWidth and maxHeight
     *
     * @param int $width
     * @param int $height
     */
    function calcImageSize($width,$height) {
        $newSize = array('newWidth'=>$width,'newHeight'=>$height);

        if($this->maxWidth > 0) {

            $newSize = $this->calcWidth($width,$height);

            if($this->maxHeight > 0 && $newSize['newHeight'] > $this->maxHeight) {
                $newSize = $this->calcHeight($newSize['newWidth'],$newSize['newHeight']);
            }

            //$this->newDimensions = $newSize;
        }

        if($this->maxHeight > 0) {
            $newSize = $this->calcHeight($width,$height);

            if($this->maxWidth > 0 && $newSize['newWidth'] > $this->maxWidth) {
                $newSize = $this->calcWidth($newSize['newWidth'],$newSize['newHeight']);
            }

            //$this->newDimensions = $newSize;
        }

        $this->newDimensions = $newSize;
    }

    /**
     * Calculates new image size based percentage
     *
     * @param int $width
     * @param int $height
     */
    function calcImageSizePercent($width,$height) {
        if($this->percent > 0) {
            $this->newDimensions = $this->calcPercent($width,$height);
        }
    }

    /**
     * Displays error image
     *
     */
    function showErrorImage() {
        header('Content-type: image/png');
        $errImg = ImageCreate(220,25);
        $bgColor = imagecolorallocate($errImg,0,0,0);
        $fgColor1 = imagecolorallocate($errImg,255,255,255);
        $fgColor2 = imagecolorallocate($errImg,255,0,0);
        imagestring($errImg,3,6,6,'Error:',$fgColor2);
        imagestring($errImg,3,55,6,$this->errmsg,$fgColor1);
        imagepng($errImg);
        imagedestroy($errImg);
    }

    /**
     * Resizes image to fixed Width x Height
     * 
     * @param int $Width
     * @param int $Height
     * @param int $resampleMode
     */
    function resizeFix($Width = 0, $Height = 0, $resampleMode = 3) {
        $this->newWidth = $Width;
        $this->newHeight = $Height;

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($this->newWidth,$this->newHeight);
		}
		else {
			$this->workingImage = ImageCreate($this->newWidth,$this->newHeight);
		}

//		ImageCopyResampled(
		$this->fastimagecopyresampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			0,
			0,
			$this->newWidth,
			$this->newHeight,
			$this->currentDimensions['width'],
			$this->currentDimensions['height'],
			$resampleMode
		);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $this->newWidth;
		$this->currentDimensions['height'] = $this->newHeight;
	}


    /**
     * Resizes image to maxWidth x maxHeight
     *
     * @param int $maxWidth
     * @param int $maxHeight
     * @param int $resampleMode
     */
    function resize($maxWidth = 0, $maxHeight = 0, $resampleMode = 3) {
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;

        $this->calcImageSize($this->currentDimensions['width'],$this->currentDimensions['height']);

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}
		else {
			$this->workingImage = ImageCreate($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}

//		ImageCopyResampled(
		$this->fastimagecopyresampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			0,
			0,
			$this->newDimensions['newWidth'],
			$this->newDimensions['newHeight'],
			$this->currentDimensions['width'],
			$this->currentDimensions['height'],
			$resampleMode
		);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $this->newDimensions['newWidth'];
		$this->currentDimensions['height'] = $this->newDimensions['newHeight'];
	}

	/**
	 * Resizes the image by $percent percent
	 *
	 * @param int $percent
	 */
	function resizePercent($percent = 0) {
	    $this->percent = $percent;

	    $this->calcImageSizePercent($this->currentDimensions['width'],$this->currentDimensions['height']);

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}
		else {
			$this->workingImage = ImageCreate($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}

		ImageCopyResampled(
			$this->workingImage,
			$this->oldImage,
			0,
			0,
			0,
			0,
			$this->newDimensions['newWidth'],
			$this->newDimensions['newHeight'],
			$this->currentDimensions['width'],
			$this->currentDimensions['height']
		);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $this->newDimensions['newWidth'];
		$this->currentDimensions['height'] = $this->newDimensions['newHeight'];
	}

	/**
	 * Crops the image from calculated center in a square of $cropSize pixels
	 *
	 * @param int $cropSize
	 * @param int $resampleMode
	 */
	function cropFromCenter($cropSize, $resampleMode = 3) {
	    if($cropSize > $this->currentDimensions['width']) $cropSize = $this->currentDimensions['width'];
	    if($cropSize > $this->currentDimensions['height']) $cropSize = $this->currentDimensions['height'];

	    $cropX = intval(($this->currentDimensions['width'] - $cropSize) / 2);
	    $cropY = intval(($this->currentDimensions['height'] - $cropSize) / 2);

	    if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($cropSize,$cropSize);
		}
		else {
			$this->workingImage = ImageCreate($cropSize,$cropSize);
		}

//		imagecopyresampled(
		$this->fastimagecopyresampled(
            $this->workingImage,
            $this->oldImage,
            0,
            0,
            $cropX,
            $cropY,
            $cropSize,
            $cropSize,
            $cropSize,
            $cropSize,
            $resampleMode
		);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $cropSize;
		$this->currentDimensions['height'] = $cropSize;
	}

	/**
	 * Advanced cropping function that crops an image using $startX and $startY as the upper-left hand corner.
	 *
	 * @param int $startX
	 * @param int $startY
	 * @param int $width
	 * @param int $height
	 */
	function crop($startX, $startY, $width, $height) {
	    //make sure the cropped area is not greater than the size of the image
	    if($width > $this->currentDimensions['width']) $width = $this->currentDimensions['width'];
	    if($height > $this->currentDimensions['height']) $height = $this->currentDimensions['height'];
	    //make sure not starting outside the image
	    if(($startX + $width) > $this->currentDimensions['width']) $startX = ($this->currentDimensions['width'] - $width);
	    if(($startY + $height) > $this->currentDimensions['height']) $startY = ($this->currentDimensions['height'] - $height);
	    if($startX < 0) $startX = 0;
	    if($startY < 0) $startY = 0;

	    if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($width,$height);
		}
		else {
			$this->workingImage = ImageCreate($width,$height);
		}

		imagecopyresampled(
            $this->workingImage,
            $this->oldImage,
            0,
            0,
            $startX,
            $startY,
            $width,
            $height,
            $width,
            $height
		);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $width;
		$this->currentDimensions['height'] = $height;
	}

	/**
	 * Outputs the image to the screen, or saves to $name if supplied.  Quality of JPEG images can be controlled with the $quality variable
	 *
	 * @param int $quality
	 * @param string $name
	 */
	function show($quality=100,$name = '') {
	    switch($this->format) {
	        case 'GIF':
	            if($name != '') {
	               @ImageGif($this->newImage,$name) or $this->error = true;
	            }
	            else {
	               header('Content-type: image/gif');
	               ImageGif($this->newImage);
	            }
	            break;
	        case 'JPG':
	            if($name != '') {
	               @ImageJpeg($this->newImage,$name,$quality) or $this->error = true;
	            }
	            else {
	               header('Content-type: image/jpeg');
	               ImageJpeg($this->newImage,'',$quality);
	            }
	            break;
	        case 'PNG':
	            if($name != '') {
	            	@ImagePng($this->newImage,$name) or $this->error = true;
	            }
	            else {
	               header('Content-type: image/png');
	               ImagePng($this->newImage);
	            }
	            break;
	    }
	}

	/**
	 * Saves image as $name (can include file path), with quality of # percent if file is a jpeg
	 *
	 * @param string $name
	 * @param int $quality
	 * @return bool errorstate
	 */
	function save($name,$quality=100) {
	    $this->show($quality,$name);
	    if ($this->error == true) {
	    	$this->errmsg = 'Create Image failed. Check safe mode settings';
	    	return false;
	    }
	    return true;
	}

	/**
	 * Creates Apple-style reflection under image, optionally adding a border to main image
	 *
	 * @param int $percent
	 * @param int $reflection
	 * @param int $white
	 * @param bool $border
	 * @param string $borderColor
	 */
	function createReflection($percent,$reflection,$white,$border = true,$borderColor = '#a4a4a4') {
        $width = $this->currentDimensions['width'];
        $height = $this->currentDimensions['height'];

        $reflectionHeight = intval($height * ($reflection / 100));
        $newHeight = $height + $reflectionHeight;
        $reflectedPart = $height * ($percent / 100);

        $this->workingImage = ImageCreateTrueColor($width,$newHeight);

        ImageAlphaBlending($this->workingImage,true);

        $colorToPaint = ImageColorAllocateAlpha($this->workingImage,255,255,255,0);
        ImageFilledRectangle($this->workingImage,0,0,$width,$newHeight,$colorToPaint);

        imagecopyresampled(
                            $this->workingImage,
                            $this->newImage,
                            0,
                            0,
                            0,
                            $reflectedPart,
                            $width,
                            $reflectionHeight,
                            $width,
                            ($height - $reflectedPart));
        $this->imageFlipVertical();

        imagecopy($this->workingImage,$this->newImage,0,0,0,0,$width,$height);

        imagealphablending($this->workingImage,true);

        for($i=0;$i<$reflectionHeight;$i++) {
            $colorToPaint = imagecolorallocatealpha($this->workingImage,255,255,255,($i/$reflectionHeight*-1+1)*$white);
            imagefilledrectangle($this->workingImage,0,$height+$i,$width,$height+$i,$colorToPaint);
        }

        if($border == true) {
            $rgb = $this->hex2rgb($borderColor,false);
            $colorToPaint = imagecolorallocate($this->workingImage,$rgb[0],$rgb[1],$rgb[2]);
            imageline($this->workingImage,0,0,$width,0,$colorToPaint); //top line
            imageline($this->workingImage,0,$height,$width,$height,$colorToPaint); //bottom line
            imageline($this->workingImage,0,0,0,$height,$colorToPaint); //left line
            imageline($this->workingImage,$width-1,0,$width-1,$height,$colorToPaint); //right line
        }

        $this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $width;
		$this->currentDimensions['height'] = $newHeight;
	}

	/**
	 * Flip an image.
	 *
	 * @param bool $horz flip the image in horizontal mode
	 * @param bool $vert flip the image in vertical mode
	 */
	function flipImage( $horz = false, $vert = false ) {
		
		$sx = $vert ? ($this->currentDimensions['width'] - 1) : 0;
		$sy = $horz ? ($this->currentDimensions['height'] - 1) : 0;
		$sw = $vert ? -$this->currentDimensions['width'] : $this->currentDimensions['width'];
		$sh = $horz ? -$this->currentDimensions['height'] : $this->currentDimensions['height'];
		
		$this->workingImage = imagecreatetruecolor( $this->currentDimensions['width'], $this->currentDimensions['height'] ); 
		
		imagecopyresampled($this->workingImage, $this->oldImage, 0, 0, $sx, $sy, $this->currentDimensions['width'], $this->currentDimensions['height'], $sw, $sh) ;
		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		
		return true;
	}
	
	/**
	 * Rotate an image clockwise or counter clockwise
	 *
	 * @param string $direction could be CW or CCW
	 */
	function rotateImage( $dir = 'CW' ) {
		
		$angle = ($dir == 'CW') ? 90 : -90;
		
		if ( function_exists('imagerotate') ) {
	        $this->workingImage = imagerotate($this->oldImage, 360 - $angle, 0); // imagerotate() rotates CCW 
	        $this->currentDimensions['width']  = imagesx($this->workingImage);
	    	$this->currentDimensions['height'] = imagesy($this->workingImage);
    	    $this->oldImage = $this->workingImage;
			$this->newImage = $this->workingImage;
			return true;
		}
		
		$this->workingImage = imagecreatetruecolor( $this->currentDimensions['height'], $this->currentDimensions['width'] ); 
		
	    imagealphablending($this->workingImage, false); 
	    imagesavealpha($this->workingImage, true); 

		switch ($angle) {
			
			case 90 :
				for( $x = 0; $x < $this->currentDimensions['width']; $x++ ) { 
	   	            for( $y = 0; $y < $this->currentDimensions['height']; $y++ ) { 
	  	                if ( !imagecopy($this->workingImage, $this->oldImage, $this->currentDimensions['height'] - $y - 1, $x, $x, $y, 1, 1) ) 
	  	                    return false; 
	 	            } 
	  	        } 
			break;
			
			case -90 :
				for( $x = 0; $x < $this->currentDimensions['width']; $x++ ) { 
	 	            for( $y = 0; $y < $this->currentDimensions['height']; $y++ ) { 
	 	                if ( !imagecopy($this->workingImage, $this->oldImage, $y, $this->currentDimensions['width'] - $x - 1, $x, $y, 1, 1) ) 
	 	                    return false; 
	 	            } 
	 	        } 
			break;
						
			default : 
				return false;
		}

		$this->currentDimensions['width']  = imagesx($this->workingImage);
	    $this->currentDimensions['height'] = imagesy($this->workingImage);			
	    $this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		
	    return true;
		
	}	

	/**
	 * Inverts working image, used by reflection function
	 * 
	 * @access	private
	 */
	function imageFlipVertical() {
	    $x_i = imagesx($this->workingImage);
	    $y_i = imagesy($this->workingImage);

	    for($x = 0; $x < $x_i; $x++) {
	        for($y = 0; $y < $y_i; $y++) {
	            imagecopy($this->workingImage,$this->workingImage,$x,$y_i - $y - 1, $x, $y, 1, 1);
	        }
	    }
	}

	/**
	 * Converts hexidecimal color value to rgb values and returns as array/string
	 *
	 * @param string $hex
	 * @param bool $asString
	 * @return array|string
	 */
	function hex2rgb($hex, $asString = false) {
        // strip off any leading #
        if (0 === strpos($hex, '#')) {
           $hex = substr($hex, 1);
        } else if (0 === strpos($hex, '&H')) {
           $hex = substr($hex, 2);
        }

        // break into hex 3-tuple
        $cutpoint = ceil(strlen($hex) / 2)-1;
        $rgb = explode(':', wordwrap($hex, $cutpoint, ':', $cutpoint), 3);

        // convert each tuple to decimal
        $rgb[0] = (isset($rgb[0]) ? hexdec($rgb[0]) : 0);
        $rgb[1] = (isset($rgb[1]) ? hexdec($rgb[1]) : 0);
        $rgb[2] = (isset($rgb[2]) ? hexdec($rgb[2]) : 0);

        return ($asString ? "{$rgb[0]} {$rgb[1]} {$rgb[2]}" : $rgb);
    }
    
	/**
     * Based on the Watermark function by Marek Malcherek  
     * http://www.malcherek.de
     *
 	 * @param string $color
	 * @param string $wmFont
	 * @param int $wmSize
 	 * @param int $wmOpaque
     */
	function watermarkCreateText($color = '000000',$wmFont, $wmSize = 10, $wmOpaque = 90 ){
		// set font path
		$wmFontPath = NGGALLERY_ABSPATH."fonts/".$wmFont;
		if ( !is_readable($wmFontPath))
			return;	
			
		// This function requires both the GD library and the FreeType library. 
		if ( !function_exists('ImageTTFBBox') )
			return;
	
		$TextSize = @ImageTTFBBox($wmSize, 0, $wmFontPath, $this->watermarkText) or die;
		$TextWidth = abs($TextSize[2]) + abs($TextSize[0]);
		$TextHeight = abs($TextSize[7]) + abs($TextSize[1]);
		// Create Image for Text
		$this->workingImage = ImageCreateTrueColor($TextWidth, $TextHeight);
		ImageSaveAlpha($this->workingImage, true);
		ImageAlphaBlending($this->workingImage, false);
		$bgText = imagecolorallocatealpha($this->workingImage, 255, 255, 255, 127);
		imagefill($this->workingImage, 0, 0, $bgText);
		$wmTransp = 127 -( $wmOpaque * 1.27 );
		$rgb = $this->hex2rgb($color,false);
		$TextColor = imagecolorallocatealpha($this->workingImage, $rgb[0], $rgb[1], $rgb[2], $wmTransp);
		
		// Create Text on image
		imagettftext($this->workingImage, $wmSize, 0, 0, abs($TextSize[5]), $TextColor, $wmFontPath, $this->watermarkText);
		$this->watermarkImgPath = $this->workingImage;

		return;		
	}
    
    /**
     * Modfied Watermark function by Steve Peart 
     * http://parasitehosting.com/
     *
 	 * @param string $relPOS
	 * @param int $xPOS
 	 * @param int $yPOS
     */
    function watermarkImage( $relPOS = 'botRight', $xPOS = 0, $yPOS = 0) {
    	
		// if it's a resource ID take it as watermark text image
    	if(is_resource($this->watermarkImgPath)) {
    		$this->workingImage = $this->watermarkImgPath;
    	} else {
		// Would you really want to use anything other than a png? 
		$this->workingImage = @imagecreatefrompng($this->watermarkImgPath);
		// if it's not a valid file die...
		if (empty($this->workingImage) or (!$this->workingImage))
			return;
		}
		
		imagealphablending($this->workingImage, false);
		imagesavealpha($this->workingImage, true);
		$sourcefile_width=imageSX($this->oldImage);
		$sourcefile_height=imageSY($this->oldImage);
		$watermarkfile_width=imageSX($this->workingImage);
		$watermarkfile_height=imageSY($this->workingImage);
		switch(substr($relPOS, 0, 3)){
			case 'top': $dest_y = 0 + $yPOS; break;
			case 'mid': $dest_y = ($sourcefile_height / 2) - ($watermarkfile_height / 2); break;
			case 'bot': $dest_y = $sourcefile_height - $watermarkfile_height - $yPOS; break;
			default   : $dest_y = 0; break;
		}
		switch(substr($relPOS, 3)){
			case 'Left'	:	$dest_x = 0 + $xPOS; break;
			case 'Center':	$dest_x = ($sourcefile_width / 2) - ($watermarkfile_width / 2); break;
			case 'Right':	$dest_x = $sourcefile_width - $watermarkfile_width - $xPOS; break;
			default : 		$dest_x = 0; break;
		}
		
		// debug	
		// $this->errmsg = 'X '.$dest_x.' Y '.$dest_y;
		// $this->showErrorImage();

		// if a gif, we have to upsample it to a truecolor image
		if($this->format == 'GIF') {
			$tempimage = imagecreatetruecolor($sourcefile_width,$sourcefile_height);
			imagecopy($tempimage, $this->oldImage, 0, 0, 0, 0,$sourcefile_width, $sourcefile_height);
			$this->newImage = $tempimage;
		}
		
		imagecopy($this->newImage, $this->workingImage, $dest_x, $dest_y, 0, 0,$watermarkfile_width, $watermarkfile_height);
	}
	
    /**
     * Fast imagecopyresampled by tim@leethost.com
     *
     */	
	function fastimagecopyresampled (&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 3) {
		// Plug-and-Play fastimagecopyresampled function replaces much slower imagecopyresampled.
		// Just include this function and change all "imagecopyresampled" references to "fastimagecopyresampled".
		// Typically from 30 to 60 times faster when reducing high resolution images down to thumbnail size using the default quality setting.
		// Author: Tim Eckel - Date: 12/17/04 - Project: FreeRingers.net - Freely distributable.
		//
		// Optional "quality" parameter (defaults is 3).  Fractional values are allowed, for example 1.5.
		// 1 = Up to 600 times faster.  Poor results, just uses imagecopyresized but removes black edges.
		// 2 = Up to 95 times faster.  Images may appear too sharp, some people may prefer it.
		// 3 = Up to 60 times faster.  Will give high quality smooth results very close to imagecopyresampled.
		// 4 = Up to 25 times faster.  Almost identical to imagecopyresampled for most images.
		// 5 = No speedup.  Just uses imagecopyresampled, highest quality but no advantage over imagecopyresampled.
		
		if (empty($src_image) || empty($dst_image)) { return false; }
		
		if ($quality <= 1) {
			$temp = imagecreatetruecolor ($dst_w + 1, $dst_h + 1);
			imagecopyresized ($temp, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w + 1, $dst_h + 1, $src_w, $src_h);
			imagecopyresized ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $dst_w, $dst_h);
			imagedestroy ($temp);
		} elseif ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h)) {
			$tmp_w = $dst_w * $quality;
			$tmp_h = $dst_h * $quality;
			// on whatever reason PHP 4.4.8 stopped here.
			$temp = imagecreatetruecolor ($tmp_w + 1, $tmp_h + 1);
			imagecopyresized ($temp, $src_image, $dst_x * $quality, $dst_y * $quality, $src_x, $src_y, $tmp_w + 1, $tmp_h + 1, $src_w, $src_h);
			imagecopyresampled ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $tmp_w, $tmp_h);
			imagedestroy ($temp);
		} else {
			imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		}
		return true;
	}
}
?>