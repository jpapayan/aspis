<?php
/**
* Main PHP class for the WordPress plugin NextGEN Gallery
* 
* @author 		Alex Rabe 
* @copyright 	Copyright 2007 - 2009
* 
*/
class nggGallery {
	
	/**
	* Show a error messages
	*/
	function show_error($message) {
		echo '<div class="wrap"><h2></h2><div class="error" id="error"><p>' . $message . '</p></div></div>' . "\n";
	}
	
	/**
	* Show a system messages
	*/
	function show_message($message) {
		echo '<div class="wrap"><h2></h2><div class="updated fade" id="message"><p>' . $message . '</p></div></div>' . "\n";
	}

	/**
	* get the thumbnail url to the image
	*/
	function get_thumbnail_url($imageID, $picturepath = '', $fileName = ''){
	
		// get the complete url to the thumbnail
		global $wpdb;
		
		// safety first
		$imageID = (int) $imageID;
		
		// get gallery values
		if ( empty($fileName) ) {
			list($fileName, $picturepath ) = $wpdb->get_row("SELECT p.filename, g.path FROM $wpdb->nggpictures AS p INNER JOIN $wpdb->nggallery AS g ON (p.galleryid = g.gid) WHERE p.pid = '$imageID' ", ARRAY_N);
		}
		
		if ( empty($picturepath) ) {
			$picturepath = $wpdb->get_var("SELECT g.path FROM $wpdb->nggpictures AS p INNER JOIN $wpdb->nggallery AS g ON (p.galleryid = g.gid) WHERE p.pid = '$imageID' ");
		}
		
		// set gallery url
		$folder_url 	= get_option ('siteurl') . '/' . $picturepath.nggGallery::get_thumbnail_folder($picturepath, FALSE);
		$thumbnailURL	= $folder_url . 'thumbs_' . $fileName;
		
		return $thumbnailURL;
	}
	
	/**
	* get the complete url to the image
	*/
	function get_image_url($imageID, $picturepath = '', $fileName = '') {		
		global $wpdb;

		// safety first
		$imageID = (int) $imageID;
		
		// get gallery values
		if (empty($fileName)) {
			list($fileName, $picturepath ) = $wpdb->get_row("SELECT p.filename, g.path FROM $wpdb->nggpictures AS p INNER JOIN $wpdb->nggallery AS g ON (p.galleryid = g.gid) WHERE p.pid = '$imageID' ", ARRAY_N);
		}

		if (empty($picturepath)) {
			$picturepath = $wpdb->get_var("SELECT g.path FROM $wpdb->nggpictures AS p INNER JOIN $wpdb->nggallery AS g ON (p.galleryid = g.gid) WHERE p.pid = '$imageID' ");
		}
		
		// set gallery url
		$imageURL 	= get_option ('siteurl') . '/' . $picturepath . '/' . $fileName;
		
		return $imageURL;	
	}

	/**
	* nggGallery::get_thumbnail_folder()
	* 
	* @param mixed $gallerypath
	* @param bool $include_Abspath
	* @return string $foldername
	*/
	function create_thumbnail_folder($gallerypath, $include_Abspath = TRUE) {
		if (!$include_Abspath) {
			$gallerypath = WINABSPATH . $gallerypath;
		}
		
		if (!file_exists($gallerypath)) {
			return FALSE;
		}
		
		if (is_dir($gallerypath . '/thumbs/')) {
			return '/thumbs/';
		}
		
		if (is_admin()) {
			if (!is_dir($gallerypath . '/thumbs/')) {
				if ( !wp_mkdir_p($gallerypath . '/thumbs/') ) {
					if (SAFE_MODE) {
						nggAdmin::check_safemode($gallerypath . '/thumbs/');	
					} else {
						nggGallery::show_error(__('Unable to create directory ', 'nggallery') . $gallerypath . '/thumbs !');
					}
					return FALSE;
				}
				return '/thumbs/';
			}
		}
		
		return FALSE;
		
	}

	/**
	* nggGallery::get_thumbnail_folder()
	* 
	* @param mixed $gallerypath
	* @param bool $include_Abspath
	* @deprecated use create_thumbnail_folder() if needed;
	* @return string $foldername
	*/
	function get_thumbnail_folder($gallerypath, $include_Abspath = TRUE) {
		return nggGallery::create_thumbnail_folder($gallerypath, $include_Abspath);
	}
	
	/**
	* nggGallery::get_thumbnail_prefix() - obsolete
	* 
	* @param string $gallerypath
	* @param bool   $include_Abspath
	* @deprecated prefix is now fixed to "thumbs_";
	* @return string  "thumbs_";
	*/
	function get_thumbnail_prefix($gallerypath, $include_Abspath = TRUE) {
		return 'thumbs_';		
	}
	
	/**
	* nggGallery::get_option() - get the options and overwrite them with custom meta settings
	*
	* @param string $key
	* @return array $options
	*/
	function get_option($key) {
		// get first the options from the database 
		$options = get_option($key);
		
		// Get all key/value data for the current post. 
		$meta_array = get_post_custom();
		
		// Ensure that this is a array
		if ( !is_array($meta_array) )
			$meta_array = array($meta_array);
		
		// assign meta key to db setting key
		$meta_tags = array(
			'string' => array(
				'ngg_gal_ShowOrder' 		=> 'galShowOrder',
				'ngg_gal_Sort' 				=> 'galSort',
				'ngg_gal_SortDirection' 	=> 'galSortDir',
				'ngg_gal_ShowDescription'	=> 'galShowDesc',
				'ngg_ir_Audio' 				=> 'irAudio',
				'ngg_ir_Overstretch'		=> 'irOverstretch',
				'ngg_ir_Transition'			=> 'irTransition',
				'ngg_ir_Backcolor' 			=> 'irBackcolor',
				'ngg_ir_Frontcolor' 		=> 'irFrontcolor',
				'ngg_ir_Lightcolor' 		=> 'irLightcolor'
			),

			'int' => array(
				'ngg_gal_Images' 			=> 'galImages',
				'ngg_gal_Columns'			=> 'galColumns',
				'ngg_paged_Galleries'		=> 'galPagedGalleries',
				'ngg_ir_Width' 				=> 'irWidth',
				'ngg_ir_Height' 			=> 'irHeight',
				'ngg_ir_Rotatetime' 		=> 'irRotatetime'
			),

			'bool' => array(
				'ngg_gal_ShowSlide'			=> 'galShowSlide',
				'ngg_gal_ShowPiclense'		=> 'usePicLens',
				'ngg_gal_ImageBrowser' 		=> 'galImgBrowser',
				'ngg_gal_HideImages' 		=> 'galHiddenImg',
				'ngg_ir_Shuffle' 			=> 'irShuffle',
				'ngg_ir_LinkFromDisplay' 	=> 'irLinkfromdisplay',
				'ngg_ir_ShowNavigation'		=> 'irShownavigation',
				'ngg_ir_ShowWatermark' 		=> 'irWatermark',
				'ngg_ir_Overstretch'		=> 'irOverstretch',
				'ngg_ir_Kenburns' 			=> 'irKenburns'
			)
		);
		
		foreach ($meta_tags as $typ => $meta_keys){
			foreach ($meta_keys as $key => $db_value){
				// if the kex exist overwrite it with the custom field
				if (array_key_exists($key, $meta_array)){
					switch ($typ) {
					case 'string':
						$options[$db_value] = (string) esc_attr($meta_array[$key][0]);
						break;
					case 'int':
						$options[$db_value] = (int) $meta_array[$key][0];
						break;
					case 'bool':
						$options[$db_value] = (bool) $meta_array[$key][0];
						break;	
					}
				}
			}
		}
		
		return $options;
	}
	
	/**
	* nggGallery::scale_image() - Scale down a image
	* 
	* @param mixed $location (filename)
	* @param int $maxw - max width
	* @param int $maxh -  max height
	* @return array (width, heigth) 
	*/
	function scale_image($location, $maxw = 0, $maxh = 0){
		$img = @getimagesize($location);
		if ($img){
			$w = $img[0];
			$h = $img[1];
			
			$dim = array('w','h');
			foreach($dim AS $val) {
				$max = "max{$val}";
				if(${$val} > ${$max} && ${$max}){
					$alt = ($val == 'w') ? 'h' : 'w';
					$ratio = ${$alt} / ${$val};
					${$val} = ${$max};
					${$alt} = ${$val} * $ratio;
				}
			}
			
			return array( $w, $h );
		}
		return false;
	} 
	
	/**
	* Renders a section of user display code.  The code is first checked for in the current theme display directory
	* before defaulting to the plugin
	* Call the function :	nggGallery::render ('template_name', array ('var1' => $var1, 'var2' => $var2));
	*
	* @autor John Godley
	* @param string $template_name Name of the template file (without extension)
	* @param string $vars Array of variable name=>value that is available to the display code (optional)
	* @return void
	**/
	function render($template_name, $vars = array ()) {
		foreach ($vars AS $key => $val) {
			$$key = $val;
		}
		
		// hook into the render feature to allow other plugins to include templates
		$custom_template = apply_filters( 'ngg_render_template', false, $template_name );
		
		if ( ( $custom_template != false ) &&  file_exists ($custom_template) ) {
			include ( $custom_template );
		} else if (file_exists (STYLESHEETPATH . "/nggallery/$template_name.php")) {
			include (STYLESHEETPATH . "/nggallery/$template_name.php");
		} else if (file_exists (NGGALLERY_ABSPATH . "/view/$template_name.php")) {
			include (NGGALLERY_ABSPATH . "/view/$template_name.php");
		} else {
			echo "<p>Rendering of template $template_name.php failed</p>";
		}
	}
	
	/**
	* Captures an section of user display code.
	*
	* @autor John Godley
	* @param string $template_name Name of the template file (without extension)
	* @param string $vars Array of variable name=>value that is available to the display code (optional)
	* @return void
	**/
	function capture ($template_name, $vars = array ()) {
		ob_start ();
		nggGallery::render ($template_name, $vars);
		$output = ob_get_contents ();
		ob_end_clean ();
		
		return $output;
	}
	
	/**
	 * nggGallery::graphic_library() - switch between GD and ImageMagick
	 * 
	 * @return path to the selected library
	 */
	function graphic_library() {
		
		$ngg_options = get_option('ngg_options');
		
		if ( $ngg_options['graphicLibrary'] == 'im')
			return NGGALLERY_ABSPATH . '/lib/imagemagick.inc.php';
		else
			return NGGALLERY_ABSPATH . '/lib/gd.thumbnail.inc.php';
		
	}
	
	function get_theme_css_file() {
		if ( file_exists (STYLESHEETPATH . '/nggallery.css') )
			return get_stylesheet_directory_uri() . '/nggallery.css';
		else
			return false;		
	}

	/**
	 * Support for i18n with polyglot or qtrans
	 * 
	 * @param string $in
	 * @return string $in localized
	 */
	function i18n($in) {
		
		if ( function_exists( 'langswitch_filter_langs_with_message' ) )
			$in = langswitch_filter_langs_with_message($in);
				
		if ( function_exists( 'polyglot_filter' ))
			$in = polyglot_filter($in);
		
		if ( function_exists( 'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage' ))
			$in = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($in);
		
		$in = apply_filters('localization', $in);
		
		return $in;
	}
	
	/**
	 * Check the memory_limit and calculate a recommended memory size
	 * 
	 * @since V1.2.0
	 * @return string message about recommended image size
	 */
	function check_memory_limit() {

		if ( (function_exists('memory_get_usage')) && (ini_get('memory_limit')) ) {
			
			// get memory limit
			$memory_limit = ini_get('memory_limit');
			if ($memory_limit != '')
				$memory_limit = substr($memory_limit, 0, -1) * 1024 * 1024;
			
			// calculate the free memory 	
			$freeMemory = $memory_limit - memory_get_usage();
			
			// build the test sizes
			$sizes = array();
			$sizes[] = array ( 'width' => 800,  'height' => 600);
			$sizes[] = array ( 'width' => 1024, 'height' => 768);
			$sizes[] = array ( 'width' => 1280, 'height' => 960);  // 1MP	
			$sizes[] = array ( 'width' => 1600, 'height' => 1200); // 2MP
			$sizes[] = array ( 'width' => 2016, 'height' => 1512); // 3MP
			$sizes[] = array ( 'width' => 2272, 'height' => 1704); // 4MP
			$sizes[] = array ( 'width' => 2560, 'height' => 1920); // 5MP
			
			// test the classic sizes
			foreach ($sizes as $size){
				// very, very rough estimation
				if ($freeMemory < round( $size['width'] * $size['height'] * 5.09 )) {
                	$result = sprintf(  __( 'Note : Based on your server memory limit you should not upload larger images then <strong>%d x %d</strong> pixel', 'nggallery' ), $size['width'], $size['height']); 
					return $result;
				}
			}
		}
		return;
	}
	
	/**
	 * Slightly modfifed version of pathinfo(), clean up filename & rename jpeg to jpg
	 * 
	 * @param string $name The name being checked. 
	 * @return array containing information about file
	 */
	function fileinfo( $name ) {
		
		//Sanitizes a filename replacing whitespace with dashes
		$name = sanitize_file_name($name);
		
		//get the parts of the name
		$filepart = pathinfo ( strtolower($name) );
		
		if ( empty($filepart) )
			return false;
		
		// required until PHP 5.2.0
		if ( empty($filepart['filename']) ) 
			$filepart['filename'] = substr($filepart['basename'],0 ,strlen($filepart['basename']) - (strlen($filepart['extension']) + 1) );
		
		$filepart['filename'] = sanitize_title_with_dashes( $filepart['filename'] );
		
		//extension jpeg will not be recognized by the slideshow, so we rename it
		$filepart['extension'] = ($filepart['extension'] == 'jpeg') ? 'jpg' : $filepart['extension'];
		
		//combine the new file name
		$filepart['basename'] = $filepart['filename'] . '.' . $filepart['extension'];
		
		return $filepart;
	}
	
	/**
	 * Check for extended capabilites. Must previously registers with add_ngg_capabilites()
	 * 
	 * @since 1.5.0
	 * @param string $capability
	 * @return bool $result of capability check
	 */
	function current_user_can( $capability ) {
		
		global $_ngg_capabilites;
		
		if ( is_array($_ngg_capabilites) )
			if ( in_array($capability , $_ngg_capabilites) )
				return current_user_can( $capability );	
		
		return true;
	}

	/**
	 * Check for extended capabilites and echo disabled="disabled" for input form
	 * 
	 * @since 1.5.0
	 * @param string $capability
	 * @return void
	 */
	function current_user_can_form( $capability ) {
		
		if ( !nggGallery::current_user_can( $capability ))
			echo 'disabled="disabled"';
	}

	/**
	 * Register more capabilities for custom use and add it to the administrator
	 * 
	 * @since 1.5.0
	 * @param string $capability
	 * @param bool $register the new capability automatic to the admin role 
	 * @return void
	 */
	function add_capabilites( $capability , $register = true ) {
		global $_ngg_capabilites;
		
		if ( !is_array($_ngg_capabilites) )
			$_ngg_capabilites = array();
		
		$_ngg_capabilites[] = $capability;
		
		if ( $register ) {
			$role = get_role('administrator');
			if ( !empty($role) )
				$role->add_cap( $capability );
		}
		
	}
}

?>