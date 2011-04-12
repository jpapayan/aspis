<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

/**
 * nggAdmin - Class for admin operation
 * 
 * @package NextGEN Gallery
 * @author Alex Rabe
 * @copyright 2007-2009
 * @access public
 */
class nggAdmin{

	/**
	 * create a new gallery & folder
	 * 
	 * @class nggAdmin
	 * @param string $gallerytitle
	 * @param string $defaultpath
	 * @param bool $output if the function should show an error messsage or not
	 * @return 
	 */
	function create_gallery($gallerytitle, $defaultpath, $output = true) {

		global $wpdb, $user_ID;
 
		// get the current user ID
		get_currentuserinfo();

		//cleanup pathname
		$galleryname = sanitize_file_name( $gallerytitle );
		$galleryname = apply_filters('ngg_gallery_name', $galleryname);
		$nggpath = $defaultpath . $galleryname;
		$nggRoot = WINABSPATH . $defaultpath;
		$txt = '';
		
		// No gallery name ?
		if ( empty($galleryname) ) {	
			if ($output) nggGallery::show_error( __('No valid gallery name!', 'nggallery') );
			return false;
		}
		
		// check for main folder
		if ( !is_dir($nggRoot) ) {
			if ( !wp_mkdir_p( $nggRoot ) ) {
				$txt  = __('Directory', 'nggallery').' <strong>' . $defaultpath . '</strong> '.__('didn\'t exist. Please create first the main gallery folder ', 'nggallery').'!<br />';
				$txt .= __('Check this link, if you didn\'t know how to set the permission :', 'nggallery').' <a href="http://codex.wordpress.org/Changing_File_Permissions">http://codex.wordpress.org/Changing_File_Permissions</a> ';
				if ($output) nggGallery::show_error($txt);
				return false;
			}
		}

		// check for permission settings, Safe mode limitations are not taken into account. 
		if ( !is_writeable( $nggRoot ) ) {
			$txt  = __('Directory', 'nggallery').' <strong>' . $defaultpath . '</strong> '.__('is not writeable !', 'nggallery').'<br />';
			$txt .= __('Check this link, if you didn\'t know how to set the permission :', 'nggallery').' <a href="http://codex.wordpress.org/Changing_File_Permissions">http://codex.wordpress.org/Changing_File_Permissions</a> ';
			if ($output) nggGallery::show_error($txt);
			return false;
		}
		
		// 1. Create new gallery folder
		if ( !is_dir(WINABSPATH . $nggpath) ) {
			if ( !wp_mkdir_p (WINABSPATH . $nggpath) ) 
				$txt  = __('Unable to create directory ', 'nggallery').$nggpath.'!<br />';
		}
		
		// 2. Check folder permission
		if ( !is_writeable(WINABSPATH . $nggpath ) )
			$txt .= __('Directory', 'nggallery').' <strong>'.$nggpath.'</strong> '.__('is not writeable !', 'nggallery').'<br />';

		// 3. Now create "thumbs" folder inside
		if ( !is_dir(WINABSPATH . $nggpath . '/thumbs') ) {				
			if ( !wp_mkdir_p ( WINABSPATH . $nggpath . '/thumbs') ) 
				$txt .= __('Unable to create directory ', 'nggallery').' <strong>' . $nggpath . '/thumbs !</strong>';
		}
		
		if (SAFE_MODE) {
			$help  = __('The server setting Safe-Mode is on !', 'nggallery');	
			$help .= '<br />'.__('If you have problems, please create directory', 'nggallery').' <strong>' . $nggpath . '</strong> ';	
			$help .= __('and the thumbnails directory', 'nggallery').' <strong>' . $nggpath . '/thumbs</strong> '.__('with permission 777 manually !', 'nggallery');
			if ($output) nggGallery::show_message($help);
		}
		
		// show a error message			
		if ( !empty($txt) ) {
			if (SAFE_MODE) {
			// for safe_mode , better delete folder, both folder must be created manually
				@rmdir(WINABSPATH . $nggpath . '/thumbs');
				@rmdir(WINABSPATH . $nggpath);
			}
			if ($output) nggGallery::show_error($txt);
			return false;
		}
		
		$result = $wpdb->get_var("SELECT name FROM $wpdb->nggallery WHERE name = '$galleryname' ");
		
		if ($result) {
			if ($output) nggGallery::show_error( _n( 'Gallery', 'Galleries', 1, 'nggallery' ) .' <strong>' . $galleryname . '</strong> '.__('already exists', 'nggallery'));
			return false;			
		} else { 
			$result = $wpdb->query( $wpdb->prepare("INSERT INTO $wpdb->nggallery (name, path, title, author) VALUES (%s, %s, %s, %s)", $galleryname, $nggpath, $gallerytitle , $user_ID) );
			// and give me the new id
			$gallery_id = (int) $wpdb->insert_id;
			// here you can inject a custom function
			do_action('ngg_created_new_gallery', $gallery_id);

			// return only the id if defined
			if ($return_id)
				return $gallery_id;
				
			if ($result) {
				$message  = __('Gallery %1$s successfully created.<br/>You can show this gallery with the tag %2$s.<br/>','nggallery');
				$message  = sprintf($message, $galleryname, '[nggallery id=' . $gallery_id . ']');
				$message .= '<a href="' . admin_url() . 'admin.php?page=nggallery-manage-gallery&mode=edit&gid=' . $gallery_id . '" >';
				$message .= __('Edit gallery','nggallery');
				$message .= '</a>';
				
				if ($output) nggGallery::show_message($message); 
			}
			return true;
		} 
	}
	
	/**
	 * nggAdmin::import_gallery()
	 * TODO: Check permission of existing thumb folder & images
	 * 
	 * @class nggAdmin
	 * @param string $galleryfolder contains relative path to the gallery itself
	 * @return void
	 */
	function import_gallery($galleryfolder) {
		
		global $wpdb, $user_ID;

		// get the current user ID
		get_currentuserinfo();
		
		$created_msg = '';
		
		// remove trailing slash at the end, if somebody use it
		if (substr($galleryfolder, -1) == '/') $galleryfolder = substr($galleryfolder, 0, -1);
		$gallerypath = WINABSPATH . $galleryfolder;
		
		if (!is_dir($gallerypath)) {
			nggGallery::show_error(__('Directory', 'nggallery').' <strong>'.$gallerypath.'</strong> '.__('doesn&#96;t exist!', 'nggallery'));
			return ;
		}
		
		// read list of images
		$new_imageslist = nggAdmin::scandir($gallerypath);

		if (empty($new_imageslist)) {
			nggGallery::show_message(__('Directory', 'nggallery').' <strong>'.$gallerypath.'</strong> '.__('contains no pictures', 'nggallery'));
			return;
		}
		
		// check & create thumbnail folder
		if ( !nggGallery::get_thumbnail_folder($gallerypath) )
			return;
		
		// take folder name as gallery name		
		$galleryname = basename($galleryfolder);
		$galleryname = apply_filters('ngg_gallery_name', $galleryname);
		
		// check for existing gallery folder
		$gallery_id = $wpdb->get_var("SELECT gid FROM $wpdb->nggallery WHERE path = '$galleryfolder' ");

		if (!$gallery_id) {
			$result = $wpdb->query( $wpdb->prepare("INSERT INTO $wpdb->nggallery (name, path, title, author) VALUES (%s, %s, %s, %s)", $galleryname, $galleryfolder, $galleryname , $user_ID) );
			if (!$result) {
				nggGallery::show_error(__('Database error. Could not add gallery!','nggallery'));
				return;
			}
			$created_msg = _n( 'Gallery', 'Galleries', 1, 'nggallery' ) . ' <strong>' . $galleryname . '</strong> ' . __('successfully created!','nggallery') . '<br />';
			$gallery_id  = $wpdb->insert_id;  // get index_id
		}
		
		// Look for existing image list
		$old_imageslist = $wpdb->get_col("SELECT filename FROM $wpdb->nggpictures WHERE galleryid = '$gallery_id' ");
		
		// if no images are there, create empty array
		if ($old_imageslist == NULL) 
			$old_imageslist = array();
			
		// check difference
		$new_images = array_diff($new_imageslist, $old_imageslist);
		
		// all images must be valid files
		foreach($new_images as $key => $picture) {
			if (!@getimagesize($gallerypath . '/' . $picture) ) {
				unset($new_images[$key]);
				@unlink($gallerypath . '/' . $picture);				
			}
		}
				
		// add images to database		
		$image_ids = nggAdmin::add_Images($gallery_id, $new_images);
		
		//add the preview image if needed
		nggAdmin::set_gallery_preview ( $gallery_id );

		// now create thumbnails
		nggAdmin::do_ajax_operation( 'create_thumbnail' , $image_ids, __('Create new thumbnails','nggallery') );
		
		//TODO:Message will not shown, because AJAX routine require more time, message should be passed to AJAX
		nggGallery::show_message( $created_msg . count($image_ids) .__(' picture(s) successfully added','nggallery') );
		
		return;

	}

	/**
	 * Scan folder for new images
	 * 
	 * @class nggAdmin
	 * @param string $dirname
	 * @return array $files list of image filenames 
	 */
	function scandir( $dirname = '.' ) { 
		$ext = array('jpeg', 'jpg', 'png', 'gif'); 

		$files = array(); 
		if( $handle = opendir( $dirname ) ) { 
			while( false !== ( $file = readdir( $handle ) ) ) {
				$info = pathinfo( $file );
				// just look for images with the correct extension
                if ( isset($info['extension']) )
				    if ( in_array( strtolower($info['extension']), $ext) )
					   $files[] = utf8_encode( $file );
			}		
			closedir( $handle ); 
		} 
		sort( $files );
		return ( $files ); 
	} 
	
	/**
	 * nggAdmin::createThumbnail() - function to create or recreate a thumbnail
	 * 
	 * @class nggAdmin
	 * @param object | int $image contain all information about the image or the id
	 * @return string result code
	 * @since v1.0.0
	 */
	function create_thumbnail($image) {
		
		global $ngg;
		
		if(! class_exists('ngg_Thumbnail'))
			require_once( nggGallery::graphic_library() );
		
		if ( is_numeric($image) )
			$image = nggdb::find_image( $image );

		if ( !is_object($image) ) 
			return __('Object didn\'t contain correct data','nggallery');

		// before we start we import the meta data to database (required for uploads before V1.4.0)
		nggAdmin::maybe_import_meta( $image->pid );
        		
		// check for existing thumbnail
		if (file_exists($image->thumbPath))
			if (!is_writable($image->thumbPath))
				return $image->filename . __(' is not writeable ','nggallery');

		$thumb = new ngg_Thumbnail($image->imagePath, TRUE);

		// skip if file is not there
		if (!$thumb->error) {
			if ($ngg->options['thumbfix'])  {
				// check for portrait format
				if ($thumb->currentDimensions['height'] > $thumb->currentDimensions['width']) {
					// first resize to the wanted width
					$thumb->resize($ngg->options['thumbwidth'], 0);
					// get optimal y startpos
					$ypos = ($thumb->currentDimensions['height'] - $ngg->options['thumbheight']) / 2;
					$thumb->crop(0, $ypos, $ngg->options['thumbwidth'],$ngg->options['thumbheight']);	
				} else {
					// first resize to the wanted height
					$thumb->resize(0, $ngg->options['thumbheight']);	
					// get optimal x startpos
					$xpos = ($thumb->currentDimensions['width'] - $ngg->options['thumbwidth']) / 2;
					$thumb->crop($xpos, 0, $ngg->options['thumbwidth'],$ngg->options['thumbheight']);	
				}
			//this create a thumbnail but keep ratio settings	
			} else {
				$thumb->resize($ngg->options['thumbwidth'],$ngg->options['thumbheight']);	
			}
			
			// save the new thumbnail
			$thumb->save($image->thumbPath, $ngg->options['thumbquality']);
			nggAdmin::chmod ($image->thumbPath); 
			
			//read the new sizes
			$new_size = @getimagesize ( $image->thumbPath );
			$size['width'] = $new_size[0];
			$size['height'] = $new_size[1]; 
			
			// add them to the database
			nggdb::update_image_meta($image->pid, array( 'thumbnail' => $size) );
		} 
				
		$thumb->destruct();
		
		if ( !empty($thumb->errmsg) )
			return ' <strong>' . $image->filename . ' (Error : '.$thumb->errmsg .')</strong>';
		
		// success
		return '1'; 
	}
	
	/**
	 * nggAdmin::resize_image() - create a new image, based on the height /width
	 * 
	 * @class nggAdmin
	 * @param object | int $image contain all information about the image or the id
	 * @param integer $width optional 
	 * @param integer $height optional
	 * @return string result code
	 */
	function resize_image($image, $width = 0, $height = 0) {
		
		global $ngg;
		
		if(! class_exists('ngg_Thumbnail'))
			require_once( nggGallery::graphic_library() );

		if ( is_numeric($image) )
			$image = nggdb::find_image( $image );
		
		if ( !is_object($image) ) 
			return __('Object didn\'t contain correct data','nggallery');	
		
		// before we start we import the meta data to database (required for uploads before V1.4.0)
		nggAdmin::maybe_import_meta( $image->pid );
		
		// if no parameter is set, take global settings
		$width  = ($width  == 0) ? $ngg->options['imgWidth']  : $width;
		$height = ($height == 0) ? $ngg->options['imgHeight'] : $height;
		
		if (!is_writable($image->imagePath))
			return ' <strong>' . $image->filename . __(' is not writeable','nggallery') . '</strong>';
		
		$file = new ngg_Thumbnail($image->imagePath, TRUE);

		// skip if file is not there
		if (!$file->error) {
			
			// If required save a backup copy of the file
			if ( ($ngg->options['imgBackup'] == 1) && (!file_exists($image->imagePath . '_backup')) )
				@copy ($image->imagePath, $image->imagePath . '_backup');
			
			$file->resize($width, $height, 4);
			$file->save($image->imagePath, $ngg->options['imgQuality']);
			// read the new sizes
			$size = @getimagesize ( $image->imagePath );
			// add them to the database
			nggdb::update_image_meta($image->pid, array( 'width' => $size[0], 'height' => $size[1] ) );
			$file->destruct();
		} else {
            $file->destruct();
			return ' <strong>' . $image->filename . ' (Error : ' . $file->errmsg . ')</strong>';
		}

		return '1';
	}
	
	/**
	 * Rotated/Flip an image based on the orientation flag or a definded angle
	 * 
	 * @param int|object $image
	 * @param string (optional) $dir, CW (clockwise)or CCW (counter clockwise), if set to false, the exif flag will be used
	 * @param string (optional)  $flip, could be either false | V (flip vertical) | H (flip horizontal)
	 * @return string result code
	 */
	function rotate_image($image, $dir = false, $flip = false) {

		global $ngg;

		if(! class_exists('ngg_Thumbnail'))
			require_once( nggGallery::graphic_library() );
		
		if ( is_numeric($image) )
			$image = nggdb::find_image( $image );
		
		if ( !is_object($image) ) 
			return __('Object didn\'t contain correct data','nggallery');		
	
		if (!is_writable($image->imagePath))
			return ' <strong>' . $image->filename . __(' is not writeable','nggallery') . '</strong>';
		
		// if you didn't define a rotation, we look for the orientation flag in EXIF
		if ( $dir === false ) {
			$meta = new nggMeta( $image->pid );
			$exif = $meta->get_EXIF();
	
			if (isset($exif['Orientation'])) {
				
				switch ($exif['Orientation']) {
					case 5 : // vertical flip + 90 rotate right
						$flip = 'V';
					case 6 : // 90 rotate right
						$dir = 'CW';
						break;
					case 7 : // horizontal flip + 90 rotate right
						$flip = 'H';
					case 8 : // 90 rotate left
						$dir = 'CCW';
						break;
					case 4 : // vertical flip
						$flip = 'V';
						break;
					case 3 : // 180 rotate left
						$dir = 180;
						break;
					case 2 : // horizontal flip
						$flip = 'H';
						break;						
					case 1 : // no action in the case it doesn't need a rotation
					default:
						return '0';
						break; 
				}
			} else
                return '0';
		}
		$file = new ngg_Thumbnail( $image->imagePath, TRUE );
		
		// skip if file is not there
		if (!$file->error) {

			// If required save a backup copy of the file
			if ( ($ngg->options['imgBackup'] == 1) && (!file_exists($image->imagePath . '_backup')) )
				@copy ($image->imagePath, $image->imagePath . '_backup');

			// before we start we import the meta data to database (required for uploads before V1.4.X)
			nggAdmin::maybe_import_meta( $image->pid );

			if ( $dir !== 0 )
				$file->rotateImage( $dir );
			if ( $dir === 180)
				$file->rotateImage( 'CCW' ); // very special case, we rotate the image two times
			if ( $flip == 'H')
				$file->flipImage(true, false);
			if ( $flip == 'V')
				$file->flipImage(false, true);
					
			$file->save($image->imagePath, $ngg->options['imgQuality']);
			
			// read the new sizes
			$size = @getimagesize ( $image->imagePath );
			// add them to the database
			nggdb::update_image_meta($image->pid, array( 'width' => $size[0], 'height' => $size[1] ) );
			
		}
		
		$file->destruct();

		if ( !empty($file->errmsg) )
			return ' <strong>' . $image->filename . ' (Error : '.$file->errmsg .')</strong>';		

		return '1';
		
	}

	/**
	 * nggAdmin::set_watermark() - set the watermark for the image
	 * 
	 * @class nggAdmin
	 * @param object | int $image contain all information about the image or the id
	 * @return string result code
	 */
	function set_watermark($image) {
		
		global $ngg;

		if(! class_exists('ngg_Thumbnail'))
			require_once( nggGallery::graphic_library() );
		
		if ( is_numeric($image) )
			$image = nggdb::find_image( $image );
		
		if ( !is_object($image) ) 
			return __('Object didn\'t contain correct data','nggallery');		

		// before we start we import the meta data to database (required for uploads before V1.4.0)
		nggAdmin::maybe_import_meta( $image->pid );	

		if (!is_writable($image->imagePath))
			return ' <strong>' . $image->filename . __(' is not writeable','nggallery') . '</strong>';
		
		$file = new ngg_Thumbnail( $image->imagePath, TRUE );

		// skip if file is not there
		if (!$file->error) {
			
			// If required save a backup copy of the file
			if ( ($ngg->options['imgBackup'] == 1) && (!file_exists($image->imagePath . '_backup')) )
				@copy ($image->imagePath, $image->imagePath . '_backup');
			
			if ($ngg->options['wmType'] == 'image') {
				$file->watermarkImgPath = $ngg->options['wmPath'];
				$file->watermarkImage($ngg->options['wmPos'], $ngg->options['wmXpos'], $ngg->options['wmYpos']); 
			}
			if ($ngg->options['wmType'] == 'text') {
				$file->watermarkText = $ngg->options['wmText'];
				$file->watermarkCreateText($ngg->options['wmColor'], $ngg->options['wmFont'], $ngg->options['wmSize'], $ngg->options['wmOpaque']);
				$file->watermarkImage($ngg->options['wmPos'], $ngg->options['wmXpos'], $ngg->options['wmYpos']);  
			}
			$file->save($image->imagePath, $ngg->options['imgQuality']);
		}
		
		$file->destruct();

		if ( !empty($file->errmsg) )
			return ' <strong>' . $image->filename . ' (Error : '.$file->errmsg .')</strong>';		

		return '1';
	}

	/**
	 * Recover image from backup copy and reprocess it
	 * 
	 * @class nggAdmin
	 * @since 1.5.0
	 * @param object | int $image contain all information about the image or the id
	 * @return string result code
	 */
	
	function recover_image($image) {

		global $ngg;
		
		if ( is_numeric($image) )
			$image = nggdb::find_image( $image );
		
		if ( !is_object( $image ) ) 
			return __('Object didn\'t contain correct data','nggallery');		
			
		if (!is_writable( $image->imagePath ))
			return ' <strong>' . $image->filename . __(' is not writeable','nggallery') . '</strong>';
		
		if (!file_exists( $image->imagePath . '_backup' )) {
			return ' <strong>'.__('File do not exists','nggallery').'</strong>';
		}

		if (!@copy( $image->imagePath . '_backup' , $image->imagePath) )
			return ' <strong>'.__('Couldn\'t restore original image','nggallery').'</strong>';
		
		require_once(NGGALLERY_ABSPATH . '/lib/meta.php');
		
		$meta_obj = new nggMeta( $image->pid );
					
        $common = $meta_obj->get_common_meta();
        $common['saved']  = true; 
		$result = nggdb::update_image_meta($image->pid, $common);			
		
		return '1';
		
	}
		
	/**
	 * Add images to database
	 * 
	 * @class nggAdmin
	 * @param int $galleryID
	 * @param array $imageslist
	 * @return array $image_ids Id's which are sucessful added
	 */
	function add_Images($galleryID, $imageslist) {
		
		global $wpdb, $ngg;
		
		$image_ids = array();
		
		if ( is_array($imageslist) ) {
			foreach($imageslist as $picture) {
				
				// strip off the extension of the filename
				$path_parts = pathinfo( $picture );
				$alttext = ( !isset($path_parts['filename']) ) ? substr($path_parts['basename'], 0,strpos($path_parts['basename'], '.')) : $path_parts['filename'];
				// save it to the database 
				$result = $wpdb->query( $wpdb->prepare("INSERT INTO $wpdb->nggpictures (galleryid, filename, alttext, exclude) VALUES (%s, %s, %s, 0)", $galleryID, $picture, $alttext) );
				// and give me the new id
				$pic_id = (int) $wpdb->insert_id;
				
				if ($result) 
					$image_ids[] = $pic_id;

				// add the metadata
				nggAdmin::import_MetaData( $pic_id );
				
				// auto rotate
				nggAdmin::rotate_image( $pic_id );		

				// Autoresize image if required
				if ($ngg->options['imgAutoResize'])
						nggAdmin::resize_image( $pic_id );
				
				// action hook for post process after the image is added to the database
				$image = array( 'id' => $pic_id, 'filename' => $picture, 'galleryID' => $galleryID);
				do_action('ngg_added_new_image', $image);
									
			} 
		} // is_array
		
		do_action('ngg_after_new_images_added', $galleryID, $image_ids );
		
		return $image_ids;
		
	}
	
	/**
	 * Import some meta data into the database (if avialable)
	 * 
	 * @class nggAdmin
	 * @param array|int $imagesIds
	 * @return string result code
	 */
	function import_MetaData($imagesIds) {
			
		global $wpdb;
		
		require_once(NGGALLERY_ABSPATH . '/lib/image.php');
		
		if (!is_array($imagesIds))
			$imagesIds = array($imagesIds);
		
		foreach($imagesIds as $imageID) {
			
			$image = nggdb::find_image( $imageID );
			if (!$image->error) {

				$meta = nggAdmin::get_MetaData( $image->pid );
				
				// get the title
				$alttext = empty( $meta['title'] ) ? $image->alttext : $meta['title'];
				
				// get the caption / description field
				$description = empty( $meta['caption'] ) ? $image->description : $meta['caption'];
					
				// get the file date/time from exif
				$timestamp = $meta['timestamp'];
				// first update database
				$result = $wpdb->query( 
					$wpdb->prepare("UPDATE $wpdb->nggpictures SET 
						alttext = %s, 
						description = %s, 
						imagedate = %s
					WHERE pid = %d", $alttext, $description, $timestamp, $image->pid) );

				if ($result === false)
					return ' <strong>' . $image->filename . ' ' . __('(Error : Couldn\'t not update data base)', 'nggallery') . '</strong>';		
				
				//this flag will inform us that the import is already one time performed
				$meta['common']['saved']  = true; 
				$result = nggdb::update_image_meta($image->pid, $meta['common']);
				
				if ($result === false)
					return ' <strong>' . $image->filename . ' ' . __('(Error : Couldn\'t not update meta data)', 'nggallery') . '</strong>';		

				// add the tags if we found some
				if ($meta['keywords']) {
					$taglist = explode(',', $meta['keywords']);
					wp_set_object_terms($image->pid, $taglist, 'ngg_tag');
				}

			} else
				return ' <strong>' . $image->filename . ' ' . __('(Error : Couldn\'t not find image)', 'nggallery') . '</strong>';// error check
		}
		
		return '1';		
	}

	/**
	 * nggAdmin::get_MetaData()
	 * 
	 * @class nggAdmin
	 * @require NextGEN Meta class
	 * @param int $id image ID
	 * @return array metadata
	 */
	function get_MetaData($id) {
		
		require_once(NGGALLERY_ABSPATH . '/lib/meta.php');
		
		$meta = array();

		$pdata = new nggMeta( $id );
		
		$meta['title'] = trim ( $pdata->get_META('title') );		
		$meta['caption'] = trim ( $pdata->get_META('caption') );	
		$meta['keywords'] = trim ( $pdata->get_META('keywords') );
		$meta['timestamp'] = $pdata->get_date_time();
		// this contain other useful meta information
		$meta['common'] = $pdata->get_common_meta();
		
		return $meta;
		
	}

	/**
	 * Maybe import some meta data to the database. The functions checks the flag 'saved'
	 * and if based on compat reason (pre V1.4.0) we save then some meta datas to the database
	 * 
	 * @since V1.4.0
	 * @param int $id
	 * @return result
	 */
	function maybe_import_meta( $id ) {
				
		require_once(NGGALLERY_ABSPATH . '/lib/meta.php');
				
		$meta_obj = new nggMeta( $id );
        
		if ( $meta_obj->image->meta_data['saved'] != true ) {
            $common = $meta_obj->get_common_meta();
            //this flag will inform us that the import is already one time performed
            $common['saved']  = true; 
			$result = nggdb::update_image_meta($id, $common);
		} else
			return false;
		
		return $result;		

	}

	/**
	 * Unzip a file via the PclZip class
	 * 
	 * @class nggAdmin
	 * @require PclZip class
	 * @param string $dir
	 * @param string $file
	 * @return bool
	 */
	function unzip($dir, $file) {
		
		if(! class_exists('PclZip'))
			require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
				
		$archive = new PclZip($file);

		// extract all files in one folder
		if ($archive->extract(PCLZIP_OPT_PATH, $dir, PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_CB_PRE_EXTRACT, 'ngg_getOnlyImages') == 0) {
			nggGallery::show_error( 'Error : ' . $archive->errorInfo(true) );
			return false;
		}

		return true;
	}
 
	/**
	 * nggAdmin::getOnlyImages()
	 * 
	 * @class nggAdmin
	 * @param mixed $p_event
	 * @param mixed $p_header
	 * @return bool
	 */
	function getOnlyImages($p_event, $p_header)	{
		
		$info = pathinfo($p_header['filename']);
		// check for extension
		$ext = array('jpeg', 'jpg', 'png', 'gif'); 
		if ( in_array( strtolower($info['extension']), $ext) ) {
			// For MAC skip the ".image" files
			if ($info['basename']{0} ==  '.' ) 
				return 0;
			else 
				return 1;
		}
		// ----- all other files are skipped
		else {
		  return 0;
		}
	}

	/**
	 * Import a ZIP file via a upload form or a URL
	 * 
	 * @class nggAdmin
	 * @param int (optional) $galleryID
	 * @return bool $result
	 */
	function import_zipfile($galleryID) {

		global $ngg, $wpdb;
		
		if (nggAdmin::check_quota())
			return false;
		
		$defaultpath = $ngg->options['gallerypath'];		
		$zipurl = $_POST['zipurl'];
		
		// if someone entered a URL try to upload it
		if (!empty($zipurl) && (function_exists('curl_init')) ) {
			
			if (!(preg_match('/^http(s)?:\/\//i', $zipurl) )) {
				nggGallery::show_error( __('No valid URL path ','nggallery') );
				return false; 
			}
			
			$temp_zipfile = tempnam('/tmp', 'zipimport_');
			$filename = basename($zipurl);
			
			//Grab the zip via cURL
			$save = fopen ( $temp_zipfile, "w" );
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_FILE, $save );
			curl_setopt ( $ch, CURLOPT_HEADER, 0 );
			curl_setopt ( $ch, CURLOPT_BINARYTRANSFER, 1 );
			curl_setopt ( $ch, CURLOPT_URL, $zipurl );
			$success = curl_exec ( $ch );
			if (!$success)
				nggGallery::show_error( __('Import via cURL failed.','nggallery') . ' Error code ' . curl_errno( $ch ) . ' : ' . curl_error( $ch ) );
			curl_close ( $ch );
			fclose($save);
			
			if (!$success)
				return false; 
			
		} else {
			
			$temp_zipfile = $_FILES['zipfile']['tmp_name'];
			$filename = $_FILES['zipfile']['name']; 
						
			// Chrome return a empty content-type : http://code.google.com/p/chromium/issues/detail?id=6800
			if ( !preg_match('/chrome/i', $_SERVER['HTTP_USER_AGENT']) ) {
				// check if file is a zip file
				if ( !preg_match('/(zip|download|octet-stream)/i', $_FILES['zipfile']['type']) ) {
					@unlink($temp_zipfile); // del temp file
					nggGallery::show_error(__('Uploaded file was no or a faulty zip file ! The server recognize : ','nggallery').$_FILES['zipfile']['type']);
					return false; 
				}
			}
		}

		// should this unpacked into a new folder ?		
		if ( $galleryID == '0' ) {	
			//cleanup and take the zipfile name as folder name
			$foldername = sanitize_title(strtok ($filename, '.'));
			$foldername = $defaultpath . $foldername;
		} else {
			// get foldername if selected
			$foldername = $wpdb->get_var("SELECT path FROM $wpdb->nggallery WHERE gid = '$galleryID' ");
		}
		
		if ( empty($foldername) ) {
			nggGallery::show_error( __('Could not get a valid foldername', 'nggallery') );
			return false;
		}
		
		// set complete folder path
		$newfolder = WINABSPATH . $foldername;

		// check first if the traget folder exist
		if (!is_dir($newfolder)) {
			// create new directories
			if (!wp_mkdir_p ($newfolder)) {
				$message = sprintf(__('Unable to create directory %s. Is its parent directory writable by the server?', 'nggallery'), $newfolder);
				nggGallery::show_error($message);
				return false;
			}
			if (!wp_mkdir_p ($newfolder . '/thumbs')) {
				nggGallery::show_error(__('Unable to create directory ', 'nggallery') . $newfolder . '/thumbs !');
				return false;
			}
		} 
		
		// unzip and del temp file		
		$result = nggAdmin::unzip($newfolder, $temp_zipfile);
		@unlink($temp_zipfile);		

		if ($result) {
			$message = __('Zip-File successfully unpacked','nggallery') . '<br />';		

			// parse now the folder and add to database
			$message .= nggAdmin::import_gallery( $foldername );
			nggGallery::show_message($message);
		}
		
		return true;
	}

	/**
	 * Function for uploading of images via the upload form
	 * 
	 * @class nggAdmin
	 * @return void
	 */
	function upload_images() {
	
		global $nggdb;
		
		// WPMU action
		if (nggAdmin::check_quota())
			return;

		// Images must be an array
		$imageslist = array();

		// get selected gallery
		$galleryID = (int) $_POST['galleryselect'];

		if ($galleryID == 0) {
			nggGallery::show_error(__('No gallery selected !','nggallery'));
			return;	
		}

		// get the path to the gallery	
		$gallery = $nggdb->find_gallery($galleryID);

		if ( empty($gallery->path) ){
			nggGallery::show_error(__('Failure in database, no gallery path set !','nggallery'));
			return;
		} 
	
		// read list of images
		$dirlist = nggAdmin::scandir($gallery->abspath);
		
		$imagefiles = $_FILES['imagefiles'];
		
		if (is_array($imagefiles)) {
			foreach ($imagefiles['name'] as $key => $value) {

				// look only for uploded files
				if ($imagefiles['error'][$key] == 0) {
					
					$temp_file = $imagefiles['tmp_name'][$key];
					
					//clean filename and extract extension
					$filepart = nggGallery::fileinfo( $imagefiles['name'][$key] );
					$filename = $filepart['basename'];
						
					// check for allowed extension and if it's an image file
					$ext = array('jpg', 'png', 'gif'); 
					if ( !in_array($filepart['extension'], $ext) || !@getimagesize($temp_file) ){ 
						nggGallery::show_error('<strong>' . $imagefiles['name'][$key] . ' </strong>' . __('is no valid image file!','nggallery'));
						continue;
					}
	
					// check if this filename already exist in the folder
					$i = 0;
					while ( in_array( $filename, $dirlist ) ) {
						$filename = $filepart['filename'] . '_' . $i++ . '.' .$filepart['extension'];
					}
					
					$dest_file = $gallery->abspath . '/' . $filename;
					
					//check for folder permission
					if ( !is_writeable($gallery->abspath) ) {
						$message = sprintf(__('Unable to write to directory %s. Is this directory writable by the server?', 'nggallery'), $gallery->abspath);
						nggGallery::show_error($message);
						return;				
					}
					
					// save temp file to gallery
					if ( !@move_uploaded_file($temp_file, $dest_file) ){
						nggGallery::show_error(__('Error, the file could not moved to : ','nggallery') . $dest_file);
						nggAdmin::check_safemode( $gallery->abspath );		
						continue;
					} 
					if ( !nggAdmin::chmod($dest_file) ) {
						nggGallery::show_error(__('Error, the file permissions could not set','nggallery'));
						continue;
					}
					
					// add to imagelist & dirlist
					$imageslist[] = $filename;
					$dirlist[] = $filename;
	
				}
			}
		}
		
		if (count($imageslist) > 0) {
			
			// add images to database		
			$image_ids = nggAdmin::add_Images($galleryID, $imageslist);

			//create thumbnails
			nggAdmin::do_ajax_operation( 'create_thumbnail' , $image_ids, __('Create new thumbnails','nggallery') );
			
			//add the preview image if needed
			nggAdmin::set_gallery_preview ( $galleryID );
			
			nggGallery::show_message( count($image_ids) . __(' Image(s) successfully added','nggallery'));
		}
		
		return;

	}
	
	/**
	 * Upload function will be called via teh Flash uploader
	 * 
	 * @class nggAdmin
	 * @param integer $galleryID
	 * @return string $result
	 */
	function swfupload_image($galleryID = 0) {

		global $wpdb;
		
		if ($galleryID == 0)
			return __('No gallery selected !', 'nggallery');

		// WPMU action
		if (nggAdmin::check_quota())
			return '0';

		// Check the upload
		if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name']) || $_FILES['Filedata']['error'] != 0) 
			return __('Invalid upload. Error Code : ', 'nggallery') . $_FILES['Filedata']['error'];

		// get the filename and extension
		$temp_file = $_FILES['Filedata']['tmp_name'];

		$filepart = nggGallery::fileinfo( $_FILES['Filedata']['name'] );
		$filename = $filepart['basename'];

		// check for allowed extension
		$ext = array('jpg', 'png', 'gif'); 
		if (!in_array($filepart['extension'], $ext))
			return $_FILES[$key]['name'] . __('is no valid image file!', 'nggallery');

		// get the path to the gallery	
		$gallerypath = $wpdb->get_var("SELECT path FROM $wpdb->nggallery WHERE gid = '$galleryID' ");
		if (!$gallerypath){
			@unlink($temp_file);		
			return __('Failure in database, no gallery path set !', 'nggallery');
		} 

		// read list of images
		$imageslist = nggAdmin::scandir( WINABSPATH . $gallerypath );

		// check if this filename already exist
		$i = 0;
		while (in_array($filename, $imageslist)) {
			$filename = $filepart['filename'] . '_' . $i++ . '.' . $filepart['extension'];
		}
		
		$dest_file = WINABSPATH . $gallerypath . '/' . $filename;
				
		// save temp file to gallery
		if ( !@move_uploaded_file($_FILES["Filedata"]['tmp_name'], $dest_file) ){
			nggAdmin::check_safemode(WINABSPATH.$gallerypath);	
			return __('Error, the file could not moved to : ','nggallery').$dest_file;
		} 
		
		if ( !nggAdmin::chmod($dest_file) )
			return __('Error, the file permissions could not set','nggallery');
		
		return '0';
	}	
	
	/**
	 * Check the Quota under WPMU. Only needed for this case
	 * 
	 * @class nggAdmin
	 * @return bool $result
	 */
	function check_quota() {

			if ( (IS_WPMU) && wpmu_enable_function('wpmuQuotaCheck'))
				if( $error = upload_is_user_over_quota( false ) ) {
					nggGallery::show_error( __( 'Sorry, you have used your space allocation. Please delete some files to upload more files.','nggallery' ) );
					return true;
				}
			return false;
	}
	
	/**
	 * Set correct file permissions (taken from wp core)
	 * 
	 * @class nggAdmin
	 * @param string $filename
	 * @return bool $result
	 */
	function chmod($filename = '') {

		$stat = @ stat(dirname($filename));
		$perms = $stat['mode'] & 0007777;
		$perms = $perms & 0000666;
		if ( @chmod($filename, $perms) )
			return true;
			
		return false;
	}
	
	/**
	 * Check UID in folder and Script
	 * Read http://www.php.net/manual/en/features.safe-mode.php to understand safe_mode
	 * 
	 * @class nggAdmin
	 * @param string $foldername
	 * @return bool $result
	 */
	function check_safemode($foldername) {

		if ( SAFE_MODE ) {
			
			$script_uid = ( ini_get('safe_mode_gid') ) ? getmygid() : getmyuid();
			$folder_uid = fileowner($foldername);

			if ($script_uid != $folder_uid) {
				$message  = sprintf(__('SAFE MODE Restriction in effect! You need to create the folder <strong>%s</strong> manually','nggallery'), $foldername);
				$message .= '<br />' . sprintf(__('When safe_mode is on, PHP checks to see if the owner (%s) of the current script matches the owner (%s) of the file to be operated on by a file function or its directory','nggallery'), $script_uid, $folder_uid );
				nggGallery::show_error($message);
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Capability check. Check is the ID fit's to the user_ID
	 * 
	 * @class nggAdmin
	 * @param int $check_ID is the user_id
	 * @return bool $result
	 */
	function can_manage_this_gallery($check_ID) {
		
		global $user_ID, $wp_roles;
		
		if ( !current_user_can('NextGEN Manage others gallery') ) {
			// get the current user ID
			get_currentuserinfo();
			
			if ( $user_ID != $check_ID)
				return false;
		}
		
		return true;
	
	}
	
	/**
	 * Move images from one folder to another
	 * 
	 * @class nggAdmin
	 * @param array|int $pic_ids ID's of the images
	 * @param int $dest_gid destination gallery
	 * @return void
	 */
	function move_images($pic_ids, $dest_gid) {

		$errors = '';
		$count = 0;

		if ( !is_array($pic_ids) )
			$pic_ids = array($pic_ids);
		
		// Get destination gallery
		$destination  = nggdb::find_gallery( $dest_gid );
		$dest_abspath = WINABSPATH . $destination->path;
		
		if ( $destination == null ) {
			nggGallery::show_error(__('The destination gallery does not exist','nggallery'));
			return;
		}
		
		// Check for folder permission
		if ( !is_writeable( $dest_abspath ) ) {
			$message = sprintf(__('Unable to write to directory %s. Is this directory writable by the server?', 'nggallery'), $dest_abspath );
			nggGallery::show_error($message);
			return;				
		}
				
		// Get pictures
		$images = nggdb::find_images_in_list($pic_ids);

		foreach ($images as $image) {		
			
			$i = 0;
			$tmp_prefix = '';
			
			$destination_file_name = $image->filename;
			// check if the filename already exist, then we add a copy_ prefix
			while (file_exists( $dest_abspath . '/' . $destination_file_name)) {
				$tmp_prefix = 'copy_' . ($i++) . '_';
				$destination_file_name = $tmp_prefix . $image->filename;
			}
			
			$destination_path = $dest_abspath . '/' . $destination_file_name;
			$destination_thumbnail = $dest_abspath . '/thumbs/thumbs_' . $destination_file_name;

			// Move files
			if ( !@rename($image->imagePath, $destination_path) ) {
				$errors .= sprintf(__('Failed to move image %1$s to %2$s','nggallery'), 
					'<strong>' . $image->filename . '</strong>', $destination_path) . '<br />';
				continue;				
			}
			
			// Move the thumbnail, if possible
			!@rename($image->thumbPath, $destination_thumbnail);
			
			// Change the gallery id in the database , maybe the filename
			if ( nggdb::update_image($image->pid, $dest_gid, $destination_file_name) )
				$count++;

		}

		if ( $errors != '' )
			nggGallery::show_error($errors);

		$link = '<a href="' . admin_url() . 'admin.php?page=nggallery-manage-gallery&mode=edit&gid=' . $destination->gid . '" >' . $destination->title . '</a>';
		$messages  = sprintf(__('Moved %1$s picture(s) to gallery : %2$s .','nggallery'), $count, $link);
		nggGallery::show_message($messages);

		return;
	}
	
	/**
	 * Copy images to another gallery
	 * 
	 * @class nggAdmin
	 * @param array|int $pic_ids ID's of the images
	 * @param int $dest_gid destination gallery
	 * @return void
	 */
	function copy_images($pic_ids, $dest_gid) {
		
		$errors = $messages = '';
		
		if (!is_array($pic_ids))
			$pic_ids = array($pic_ids);
		
		// Get destination gallery
		$destination = nggdb::find_gallery( $dest_gid );
		if ( $destination == null ) {
			nggGallery::show_error(__('The destination gallery does not exist','nggallery'));
			return;
		}
		
		// Check for folder permission
		if (!is_writeable(WINABSPATH.$destination->path)) {
			$message = sprintf(__('Unable to write to directory %s. Is this directory writable by the server?', 'nggallery'), WINABSPATH.$destination->path);
			nggGallery::show_error($message);
			return;				
		}
				
		// Get pictures
		$images = nggdb::find_images_in_list($pic_ids);
		$destination_path = WINABSPATH . $destination->path;
		
		foreach ($images as $image) {		
			// WPMU action
			if ( nggAdmin::check_quota() )
				return;
			
			$i = 0;
			$tmp_prefix = ''; 
			$destination_file_name = $image->filename;
			while (file_exists($destination_path . '/' . $destination_file_name)) {
				$tmp_prefix = 'copy_' . ($i++) . '_';
				$destination_file_name = $tmp_prefix . $image->filename;
			}
			
			$destination_file_path = $destination_path . '/' . $destination_file_name;
			$destination_thumb_file_path = $destination_path . '/' . $image->thumbFolder . $image->thumbPrefix . $destination_file_name;

			// Copy files
			if ( !@copy($image->imagePath, $destination_file_path) ) {
				$errors .= sprintf(__('Failed to copy image %1$s to %2$s','nggallery'), 
					$image->filename, $destination_file_path) . '<br />';
				continue;				
			}
			
			// Copy the thumbnail if possible
			!@copy($image->thumbPath, $destination_thumb_file_path);
			
			// Create new database entry for the image
			$new_pid = nggdb::insert_image( $destination->gid, $destination_file_name, $image->alttext, $image->description, $image->exclude);

			if (!isset($new_pid)) {				
				$errors .= sprintf(__('Failed to copy database row for picture %s','nggallery'), $image->pid) . '<br />';
				continue;				
			}
				
			// Copy tags
			nggTags::copy_tags($image->pid, $new_pid);
			
			if ( $tmp_prefix != '' ) {
				$messages .= sprintf(__('Image %1$s (%2$s) copied as image %3$s (%4$s) &raquo; The file already existed in the destination gallery.','nggallery'),
					 $image->pid, $image->filename, $new_pid, $destination_file_name) . '<br />';
			} else {
				$messages .= sprintf(__('Image %1$s (%2$s) copied as image %3$s (%4$s)','nggallery'),
					 $image->pid, $image->filename, $new_pid, $destination_file_name) . '<br />';
			}

		}
		
		// Finish by showing errors or success
		if ( $errors == '' ) {
			$link = '<a href="' . admin_url() . 'admin.php?page=nggallery-manage-gallery&mode=edit&gid=' . $destination->gid . '" >' . $destination->title . '</a>';
			$messages .= '<hr />' . sprintf(__('Copied %1$s picture(s) to gallery: %2$s .','nggallery'), count($images), $link);
		} 

		if ( $messages != '' )
			nggGallery::show_message($messages);

		if ( $errors != '' )
			nggGallery::show_error($errors);

		return;
	}
	
	/**
	 * Initate the Ajax operation
	 * 
	 * @class nggAdmin	 
	 * @param string $operation name of the function which should be executed
	 * @param array $image_array
	 * @param string $title name of the operation
	 * @return string the javascript output
	 */
	function do_ajax_operation( $operation, $image_array, $title = '' ) {
		
		if ( !is_array($image_array) || empty($image_array) )
			return;

		$js_array  = implode('","', $image_array);
		
		// send out some JavaScript, which initate the ajax operation
		?>
		<script type="text/javascript">

			Images = new Array("<?php echo $js_array; ?>");

			nggAjaxOptions = {
				operation: "<?php echo $operation; ?>",
				ids: Images,		
			  	header: "<?php echo $title; ?>",
			  	maxStep: Images.length
			};
			
			jQuery(document).ready( function(){ 
				nggProgressBar.init( nggAjaxOptions );
				nggAjax.init( nggAjaxOptions );
			} );
		</script>
		
		<div id="progressbar_container" class="wrap"></div>
		
		<?php	
	}
	
	/**
	 * nggAdmin::set_gallery_preview() - define a preview pic after the first upload, can be changed in the gallery settings
	 * 
	 * @class nggAdmin
	 * @param int $galleryID
	 * @return void
	 */
	function set_gallery_preview( $galleryID ) {
		
		global $wpdb;
		
		$gallery = nggdb::find_gallery( $galleryID );
		
		// in the case no preview image is setup, we do this now
		if ($gallery->previewpic == 0) {
			$firstImage = $wpdb->get_var("SELECT pid FROM $wpdb->nggpictures WHERE exclude != 1 AND galleryid = '$galleryID' ORDER by pid DESC limit 0,1");
			if ($firstImage) {
				$wpdb->query("UPDATE $wpdb->nggallery SET previewpic = '$firstImage' WHERE gid = '$galleryID'");
				wp_cache_delete($galleryID, 'ngg_gallery');
			}
		}
		
		return;
	}

	/**
	 * Return a JSON coded array of Image ids for a requested gallery
	 * 
	 * @class nggAdmin
	 * @param int $galleryID
	 * @return arry (JSON)
	 */
	function get_image_ids( $galleryID ) {
		
		if ( !function_exists('json_encode') )
			return(-2);
		
		$gallery = nggdb::get_ids_from_gallery($galleryID, 'pid', 'ASC', false);

		header('Content-Type: text/plain; charset=' . get_option('blog_charset'), true);
		$output = json_encode($gallery);
		
		return $output;
	}

	/**
	 * Decode upload error to normal message
	 *
	 * @class nggAdmin
	 * @access internal
	 * @param int $code php upload error code
	 * @return string message
	 */
	
	function decode_upload_error( $code ) {
		
	        switch ($code) {
	            case UPLOAD_ERR_INI_SIZE:
	                $message = __ ( 'The uploaded file exceeds the upload_max_filesize directive in php.ini', 'nggallery' );
	                break;
	            case UPLOAD_ERR_FORM_SIZE:
	                $message = __ ( 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'nggallery' );
	                break;
	            case UPLOAD_ERR_PARTIAL:
	                $message = __ ( 'The uploaded file was only partially uploaded', 'nggallery' );
	                break;
	            case UPLOAD_ERR_NO_FILE:
	                $message = __ ( 'No file was uploaded', 'nggallery' );
	                break;
	            case UPLOAD_ERR_NO_TMP_DIR:
	                $message = __ ( 'Missing a temporary folder', 'nggallery' );
	                break;
	            case UPLOAD_ERR_CANT_WRITE:
	                $message = __ ( 'Failed to write file to disk', 'nggallery' );
	                break;
	            case UPLOAD_ERR_EXTENSION:
	                $message = __ ( 'File upload stopped by extension', 'nggallery' );
	                break;
	            default:
	                $message = __ ( 'Unknown upload error', 'nggallery' );
	                break;
	        }

	        return $message; 
	}

} // END class nggAdmin

/**
 * TODO: Cannot be member of a class ? Check PCLZIP later...
 * 
 * @param mixed $p_event
 * @param mixed $p_header
 * @return
 */
function ngg_getOnlyImages($p_event, $p_header)	{
	
	return nggAdmin::getOnlyImages($p_event, $p_header);
	
}
?>