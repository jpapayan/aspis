<?php
if ( !class_exists('nggImage') ) :
/**
* Image PHP class for the WordPress plugin NextGEN Gallery
* 
* @author 		Alex Rabe 
* @copyright 	Copyright 2007-2008
*/
class nggImage{
	
	/**** Public variables ****/	
	var $errmsg			=	'';			// Error message to display, if any
	var $error			=	FALSE; 		// Error state
	var $imageURL		=	'';			// URL Path to the image
	var $thumbURL		=	'';			// URL Path to the thumbnail
	var $imagePath		=	'';			// Server Path to the image
	var $thumbPath		=	'';			// Server Path to the thumbnail
	var $href			=	'';			// A href link code
	
	// TODO: remove thumbPrefix and thumbFolder (constants)
	var $thumbPrefix	=	'thumbs_';	// FolderPrefix to the thumbnail
	var $thumbFolder	=	'/thumbs/';	// Foldername to the thumbnail
	
	/**** Image Data ****/
	var $galleryid		=	0;			// Gallery ID
	var $pid			=	0;			// Image ID	
	var $filename		=	'';			// Image filename
	var $description	=	'';			// Image description	
	var $alttext		=	'';			// Image alttext	
	var $imagedate		=	'';			// Image date/time	
	var $exclude		=	'';			// Image exclude
	var $thumbcode		=	'';			// Image effect code

	/**** Gallery Data ****/
	var $name			=	'';			// Gallery name
	var $path			=	'';			// Gallery path	
	var $title			=	'';			// Gallery title
	var $pageid			=	0;			// Gallery page ID
	var $previewpic		=	0;			// Gallery preview pic		

	var $permalink		=	'';
	var $tags			=   '';
		
	/**
	 * Constructor
	 * 
	 * @param object $gallery The nggGallery object representing the gallery containing this image
	 * @return void
	 */
	function nggImage($gallery) {			
			
		//This must be an object
		$gallery = (object) $gallery;

		// Build up the object
		foreach ($gallery as $key => $value)
			$this->$key = $value ;
		
		// Finish initialisation
		$this->name			= $gallery->name;
		$this->path			= $gallery->path;
		$this->title		= stripslashes($gallery->title);
		$this->pageid		= $gallery->pageid;		
		$this->previewpic	= $gallery->previewpic;
	
		// set urls and paths
		$this->imageURL		= get_option ('siteurl') . '/' . $this->path . '/' . $this->filename;
		$this->thumbURL 	= get_option ('siteurl') . '/' . $this->path . '/thumbs/thumbs_' . $this->filename;
		$this->imagePath	= WINABSPATH.$this->path . '/' . $this->filename;
		$this->thumbPath	= WINABSPATH.$this->path . '/thumbs/thumbs_' . $this->filename;
		$this->meta_data	= unserialize($this->meta_data);
		$this->imageHTML	= $this->get_href_link();
		$this->thumbHTML	= $this->get_href_thumb_link();
		
		wp_cache_add($this->pid, $this, 'ngg_image');
		
		// Get tags only if necessary
		unset($this->tags);
	}
	
	/**
	* Get the thumbnail code (to add effects on thumbnail click)
	*
	* Applies the filter 'ngg_get_thumbcode'
	*/
	function get_thumbcode($galleryname = '') {
		// read the option setting
		$ngg_options = get_option('ngg_options');
		
		// get the effect code
		if ($ngg_options['thumbEffect'] != "none")
			$this->thumbcode = stripslashes($ngg_options['thumbCode']);		
		
		// for highslide to a different approach	
		if ($ngg_options['thumbEffect'] == "highslide")
			$this->thumbcode = str_replace("%GALLERY_NAME%", "'".$galleryname."'", $this->thumbcode);
		else
			$this->thumbcode = str_replace("%GALLERY_NAME%", $galleryname, $this->thumbcode);
				
		return apply_filters('ngg_get_thumbcode', $this->thumbcode, $this);
	}
	
	function get_href_link() {
		// create the a href link from the picture
		$this->href  = "\n".'<a href="'.$this->imageURL.'" title="'.htmlspecialchars( stripslashes($this->description) ).'" '.$this->get_thumbcode($this->name).'>'."\n\t";
		$this->href .= '<img alt="'.$this->alttext.'" src="'.$this->imageURL.'"/>'."\n".'</a>'."\n";

		return $this->href;
	}

	function get_href_thumb_link() {
		// create the a href link with the thumbanil
		$this->href  = "\n".'<a href="'.$this->imageURL.'" title="'.htmlspecialchars( stripslashes($this->description) ).'" '.$this->get_thumbcode($this->name).'>'."\n\t";
		$this->href .= '<img alt="'.$this->alttext.'" src="'.$this->thumbURL.'"/>'."\n".'</a>'."\n";

		return $this->href;
	}
	
	/**
	 * This function creates a cache for all singlepics to reduce the CPU load
	 * 
	 * @param int $width
	 * @param int $height
	 * @param string $mode could be watermark | web20 | crop
	 * @return the url for the image or false if failed 
	 */
	function cached_singlepic_file($width = '', $height = '', $mode = '' ) {

		$ngg_options = get_option('ngg_options');
		
		include_once( nggGallery::graphic_library() );
		
		// cache filename should be unique
		$cachename   	= $this->pid . '_' . $mode . '_'. $width . 'x' . $height . '_' . $this->filename;
		$cachefolder 	= WINABSPATH .$ngg_options['gallerypath'] . 'cache/';
		$cached_url  	= get_option ('siteurl') . '/' . $ngg_options['gallerypath'] . 'cache/' . $cachename;
		$cached_file	= $cachefolder . $cachename;
		
		// check first for the file
		if ( file_exists($cached_file) )
			return $cached_url;
		
		// create folder if needed
		if ( !file_exists($cachefolder) )
			if ( !wp_mkdir_p($cachefolder) )
				return false;
		
		$thumb = new ngg_Thumbnail($this->imagePath, TRUE);
		// echo $thumb->errmsg;
		
		if (!$thumb->error) {
            if ($mode == 'crop') {
        		// check for portrait format
        		if ($thumb->currentDimensions['height'] < $thumb->currentDimensions['width']) {
                    list ( $width, $ratio_h ) = wp_constrain_dimensions($thumb->currentDimensions['width'], $thumb->currentDimensions['height'], $width);
                    $thumb->resize($width, $ratio_h);
        			$ypos = ($thumb->currentDimensions['height'] - $height) / 2;
        			$thumb->crop(0, $ypos, $width, $height);
        		} else {
        		    $thumb->resize($width, 0);
                    $ypos = ($thumb->currentDimensions['height'] - $height) / 2;
        			$thumb->crop(0, $ypos, $width, $height);	
        		}                
            } else
                $thumb->resize($width , $height);
			
			if ($mode == 'watermark') {
				if ($ngg_options['wmType'] == 'image') {
					$thumb->watermarkImgPath = $ngg_options['wmPath'];
					$thumb->watermarkImage($ngg_options['wmPos'], $ngg_options['wmXpos'], $ngg_options['wmYpos']); 
				}
				if ($ngg_options['wmType'] == 'text') {
					$thumb->watermarkText = $ngg_options['wmText'];
					$thumb->watermarkCreateText($ngg_options['wmColor'], $ngg_options['wmFont'], $ngg_options['wmSize'], $ngg_options['wmOpaque']);
					$thumb->watermarkImage($ngg_options['wmPos'], $ngg_options['wmXpos'], $ngg_options['wmYpos']);  
				}
			}
			
			if ($mode == 'web20') {
				$thumb->createReflection(40,40,50,false,'#a4a4a4');
			}
			
			// save the new cache picture
			$thumb->save($cached_file,$ngg_options['imgQuality']);
		}
		$thumb->destruct();
		
		// check again for the file
		if (file_exists($cached_file))
			return $cached_url;
		
		return false;
	}
	
	/**
	 * Get the tags associated to this image
	 */
	function get_tags() {
		if ( !isset($this->tags) )
			$this->tags = wp_get_object_terms($this->pid, 'ngg_tag', 'fields=all');

		return $this->tags;
	}
	
	/**
	 * Get the permalink to the image
	 * TODO Get a permalink to a page presenting the image
	 */
	function get_permalink() {
		if ($this->permalink == '')
			$this->permalink = $this->imageURL;

		return $this->permalink; 
	}
}
endif;
?>