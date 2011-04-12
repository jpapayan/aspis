<?php
/**
 * XML-RPC protocol support for NextGEN Gallery
 *
 * @package NextGEN Gallery
 * @author Alex Rabe
 * @copyright 2009
 */
class nggXMLRPC{
	
	/**
	 * Init the methods for the XMLRPC hook
	 * 
	 */	
	function __construct() {
		
		add_filter('xmlrpc_methods', array(&$this, 'add_methods') );
	}
	
	function add_methods($methods) {
	    
		$methods['ngg.installed'] = array(&$this, 'nggInstalled');
	    $methods['ngg.uploadImage'] = array(&$this, 'uploadImage');
	    $methods['ngg.getGalleries'] = array(&$this, 'getGalleries');
	    $methods['ngg.getImages'] = array(&$this, 'getImages');
	    $methods['ngg.newGallery'] = array(&$this, 'newGallery');
	    
		return $methods;
	}

	/**
	 * Check if NextGEN Gallery is installed
	 * 
	 * @since 1.4
	 * 
	 * @param none
	 * @return string version number
	 */
	function nggInstalled($args) {
		global $ngg;
		return array( 'version' => $ngg->version );
	}
	
	/**
	 * Log user in.
	 *
	 * @since 2.8
	 *
	 * @param string $username User's username.
	 * @param string $password User's password.
	 * @return mixed WP_User object if authentication passed, false otherwise
	 */
	function login($username, $password) {
		if ( !get_option( 'enable_xmlrpc' ) ) {
			$this->error = new IXR_Error( 405, sprintf( __( 'XML-RPC services are disabled on this blog.  An admin user can enable them at %s'),  admin_url('options-writing.php') ) );
			return false;
		}

		$user = wp_authenticate($username, $password);

		if (is_wp_error($user)) {
			$this->error = new IXR_Error(403, __('Bad login/pass combination.'));
			return false;
		}

		set_current_user( $user->ID );
		return $user;
	}

	/**
	 * Method "ngg.uploadImage"
	 * Uploads a image to a gallery
	 *
	 * @since 1.4
	 * 
	 * @copyright addapted from WP Core
	 * @param array $args Method parameters.
	 * 			- int blog_id
	 *	    	- string username
	 *	    	- string password
	 *	    	- struct data
	 *	          o string name
	 *            o string type (optional)
	 *	          o base64 bits 
	 *	          o bool overwrite (optional)
	 *			  o int gallery 
	 *			  o int image_id  (optional) 	 
	 * @return array with image meta data
	 */
	function uploadImage($args) {
		global $wpdb;
		
		require_once ( dirname ( dirname( __FILE__ ) ). '/admin/functions.php' );	// admin functions
		require_once ( 'meta.php' );			// meta data import

		$blog_ID	= (int) $args[0];
		$username	= $wpdb->escape($args[1]);
		$password	= $wpdb->escape($args[2]);
		$data		= $args[3];

		$name = $data['name'];
		$type = $data['type'];
		$bits = $data['bits'];
		
		// gallery & image id
		$gid  	= (int) $data['gallery'];  // required field
		$pid  	= (int) $data['image_id']; // optional but more foolproof of overwrite
		$image	= false; // container for the image object 

		logIO('O', '(NGG) Received '.strlen($bits).' bytes');

		if ( !$user = $this->login($username, $password) )
			return $this->error;

		// Check if you have the correct capability for upload
		if ( !current_user_can('NextGEN Upload images') ) {
			logIO('O', '(NGG) User does not have upload_files capability');
			$this->error = new IXR_Error(401, __('You are not allowed to upload files to this site.'));
			return $this->error;
		}
		
		// Look for the gallery , could we find it ?
		if ( !$gallery = nggdb::find_gallery($gid) ) 
			return new IXR_Error(404, __('Could not find gallery ' . $gid ));
		
		// Now check if you have the correct capability for this gallery
		if ( !nggAdmin::can_manage_this_gallery($gallery->author) ) {
			logIO('O', '(NGG) User does not have upload_files capability');
			$this->error = new IXR_Error(401, __('You are not allowed to upload files to this gallery.'));
			return $this->error;
		}           
		                                                 
		//clean filename and extract extension
		$filepart = nggGallery::fileinfo( $name );
		$name = $filepart['basename'];
		
		// check for allowed extension and if it's an image file
		$ext = array('jpg', 'png', 'gif'); 
		if ( !in_array($filepart['extension'], $ext) ){ 
			logIO('O', '(NGG) Not allowed file type');
			$this->error = new IXR_Error(401, __('This is no valid image file.','nggallery'));
			return $this->error;
		}	

		// in the case you would overwrite the image, let's delete the old one first
		if(!empty($data["overwrite"]) && ($data["overwrite"] == true)) {
			
			// search for the image based on the filename, if it's not already provided
			if ($pid == 0)
				$pid = $wpdb->get_col(" SELECT pid FROM {$wpdb->nggpictures} WHERE filename = '{$name}' AND galleryid = '{$gid}' ");
			
			if ( !$image = nggdb::find_image( $pid ) )
				return new IXR_Error(404, __('Could not find image id ' . $pid ));			

			// sync the gallery<->image parameter, otherwise we may copy it to the wrong gallery
			$gallery = $image;
			
			// delete now the image
			if ( !@unlink( $image->imagePath ) ) {
				$errorString = sprintf(__('Failed to delete image %1$s ','nggallery'), $image->imagePath);
				logIO('O', '(NGG) ' . $errorString);
				return new IXR_Error(500, $errorString);
			}
		}

		// upload routine from wp core, load first the image to the upload folder, $upload['file'] contain the path
		$upload = wp_upload_bits($name, $type, $bits);
		if ( ! empty($upload['error']) ) {
			$errorString = sprintf(__('Could not write file %1$s (%2$s)'), $name, $upload['error']);
			logIO('O', '(NGG) ' . $errorString);
			return new IXR_Error(500, $errorString);
		}
		
		// this is the dir to the gallery		
		$path = WINABSPATH . $gallery->path;
		
		// check if the filename already exist, if not add a counter index
		$filename = wp_unique_filename( $path, $name );
		$destination = $path . '/'. $filename;

		// Move files to gallery folder
		if ( !@rename($upload['file'], $destination ) ) {
			$errorString = sprintf(__('Failed to move image %1$s to %2$s','nggallery'), '<strong>' . $upload['file'] . '</strong>', $destination);
			logIO('O', '(NGG) ' . $errorString);
			return new IXR_Error(500, $errorString);
		}
		
		//add to database if it's a new image
		if(empty($data["overwrite"]) || ($data["overwrite"] == false)) {
			$pid_array = nggAdmin::add_Images( $gallery->gid, array( $filename ) );
			// the first element is our new image id
			if (count($pid_array) == 1)
				$pid = $pid_array[0];
		}
		
		//get all information about the image, in the case it's a new one
		if (!$image)
			$image = nggdb::find_image( $pid );
		
		// create again the thumbnail, should return a '1'
		nggAdmin::create_thumbnail( $image );
		
		return apply_filters( 'ngg_upload_image', $image );

	}

	/**
	 * Method "ngg.newGallery"
	 * Create a new gallery
	 * 
	 * @since 1.4
	 * 
	 * @param array $args Method parameters.
	 * 			- int blog_id
	 *	    	- string username
	 *	    	- string password
	 *	    	- string new gallery name
	 * @return int with new gallery ID
	 */
	function newGallery($args) {
		
		global $ngg, $wpdb;

		require_once ( dirname ( dirname( __FILE__ ) ). '/admin/functions.php' );	// admin functions

		$blog_ID    = (int) $args[0];
		$username	= $wpdb->escape($args[1]);
		$password	= $wpdb->escape($args[2]);
		$name   	= $wpdb->escape($args[3]);
		$id 		= false;

		if ( !$user = $this->login($username, $password) )
			return $this->error;

		if( !current_user_can( 'NextGEN Manage gallery' ) )
			return new IXR_Error( 401, __( 'Sorry, you must be able to manage galleries to view the list of galleries' ) );

		if ( !empty( $name ) )
			$id = nggAdmin::create_gallery($name, $ngg->options['gallerypath'], false);
		
		if ( !$id )
			return new IXR_Error(500, __('Sorry, could not create the gallery'));

		return($id);
		
	}

	/**
	 * Method "ngg.getGalleries"
	 * Return the list of all galleries
	 * 
	 * @since 1.4
	 * 
	 * @param array $args Method parameters.
	 * 			- int blog_id
	 *	    	- string username
	 *	    	- string password
	 * @return array with all galleries
	 */
	function getGalleries($args) {
		
		global $nggdb, $wpdb;

		$blog_ID    = (int) $args[0];
		$username	= $wpdb->escape($args[1]);
		$password	= $wpdb->escape($args[2]);

		if ( !$user = $this->login($username, $password) )
			return $this->error;

		if( !current_user_can( 'NextGEN Manage gallery' ) )
			return new IXR_Error( 401, __( 'Sorry, you must be able to manage galleries to view the list of galleries' ) );
		
		$gallery_list = $nggdb->find_all_galleries('gid', 'asc', true, 0, 0, false);
		
		return($gallery_list);
		
	}

	/**
	 * Method "ngg.getImages"
	 * Return the list of all imgaes inside a gallery
	 * 
	 * @since 1.4
	 * 
	 * @param array $args Method parameters.
	 * 			- int blog_id
	 *	    	- string username
	 *	    	- string password
	 *	    	- int gallery_id 
	 * @return array with all images
	 */
	function getImages($args) {
		
		global $nggdb, $wpdb;

		require_once ( dirname ( dirname( __FILE__ ) ). '/admin/functions.php' );	// admin functions

		$blog_ID    = (int) $args[0];
		$username	= $wpdb->escape($args[1]);
		$password	= $wpdb->escape($args[2]);
		$gid    	= (int) $args[3];

		if ( !$user = $this->login($username, $password) )
			return $this->error;

		// Look for the gallery , could we find it ?
		if ( !$gallery = nggdb::find_gallery( $gid ) ) 
			return new IXR_Error(404, __('Could not find gallery ' . $gid ));

		// Now check if you have the correct capability for this gallery
		if ( !nggAdmin::can_manage_this_gallery($gallery->author) ) {
			logIO('O', '(NGG) User does not have upload_files capability');
			$this->error = new IXR_Error(401, __('You are not allowed to upload files to this gallery.'));
			return $this->error;
		}
		
		// get picture values
		$picture_list = $nggdb->get_gallery( $gid, 'pid', 'ASC', false );
		
		return($picture_list);
		
	}

	/**
	 * PHP5 style destructor and will run when database object is destroyed.
	 *
	 * @return bool Always true
	 */
	function __destruct() {
		
	}
}

$nggxmlrpc = new nggXMLRPC();