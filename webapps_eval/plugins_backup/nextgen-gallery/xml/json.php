<?php
/**
* REST Application Programming Interface PHP class for the WordPress plugin NextGEN Gallery
* Should emulate some kind of Flickr JSON callback : ?format=json&api_key=1234567890&method=search&term=myterm

* 
* @author 		Alex Rabe 
* @copyright 	Copyright 2010
* @since		1.5.0
* @require		PHP 5.2.0 or higher
* 
*/

class nggAPI {

	/**
	  *	$_GET Variables 
	  * 
	  * @since 1.5.0
	  * @access private
	  * @var string
	  */
    var $format		=	false;		// $_GET['format'] 	: Return a XML oder JSON output
	var $api_key	=	false;		// $_GET['api_key']	: Protect the access via a random key (required if user is not logged into backend)
	var $method		=	false;		// $_GET['method']	: search | gallery | image |tag
	var $term		=	false;		// $_GET['term']   	: The search term (required for method search | tag)
	var $id			=	false;		// $_GET['id']	  	: gallery or image id (required for method gallery | image)
	var $limit		=	false;		// $_GET['limit']	: maxium of images which we request

	/**
	 * Contain the final output
	 *
	 * @since 1.5.0
	 * @access private
	 * @var string
	 */	
	var $output		=	'';

	/**
	 * Holds the requested innformation as array
	 *
	 * @since 1.5.0
	 * @access private
	 * @var array
	 */	
	var $result		=	'';
	
	/**
	 * Init the variables
	 * 
	 */	
	function __construct() {
		
		// Enable the JSON API when you add define('NGG_JSON_ENABLE',true); in the wp-config.php file
		if ( !defined('NGG_JSON_ENABLED') )
			wp_die('JSON API not enabled. Add <strong>define(\'NGG_JSON_ENABLE\', true);</strong> to your wp-config.php file');

		if ( !function_exists('json_encode') )
			wp_die('Json_encode not available. You need to use PHP 5.2');
		
		// Read the parameter on init
		$this->format 	= strtolower( $_GET['format'] );
		$this->api_key 	= $_GET['api_key']; 
		$this->method 	= strtolower( $_GET['method'] ); 
		$this->term		= strtolower( $_GET['term'] ); 
		$this->id 		= (int) $_GET['id'];
		$this->limit 	= (int) $_GET['limit'];		
		$this->result	= array();
		
		$this->start_process();
		$this->render_output();
	}

	function start_process() {
		
		if ( !$this->valid_access() ) 
			return;
		
		switch ( $this->method ) {
			case 'search' :
				//search for some images
				$this->result['images'] = array_merge( (array) nggdb::search_for_images( $this->term ), (array) nggTags::find_images_for_tags( $this->term , 'ASC' ));
			break;
			case 'gallery' :
				//search for some a gallery
				$this->result['images'][] = nggdb::get_gallery( $this->id, 'pid', 'ASC' );
			break;
			case 'image' :
				//search for some image
				$this->result['images'][] = nggdb::find_image( $this->id );
			break;
			case 'tag' :
				//search for images based on tags
				$this->result['images'][] = nggTags::find_images_for_tags( $this->term , 'ASC' );
			break;
			case 'recent' :
				//search for images based on tags
				$this->result['images'] = nggdb::find_last_images( 0 , $this->limit );
			break;
			default :
				$this->result = array ('stat' => 'fail', 'code' => '98', 'message' => 'Method not known.');
				return false;	
			break;		
		}

		// result should be fine	
		$this->result['stat'] = 'ok';	
	}
	
	function valid_access() {
		
		// if we are logged in, then we can go on
		if ( is_user_logged_in() )
			return true;
		
		//TODO:Implement an API KEY check later
		if 	($this->api_key != false)
			return true;
		
		$this->result = array ('stat' => 'fail', 'code' => '99', 'message' => 'Insufficient permissions. Method requires read privileges; none granted.');
		return false;
	}
	
	function render_output() {
		
		if ($this->format == 'json') {
			header('Content-Type: text/plain; charset=' . get_option('blog_charset'), true);
			$this->output = json_encode($this->result);
		} else {
			header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
			//TODO:Implement XML Output
			$this->output  = "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>\n";
			$this->output .= "<rsp stat=' " . $this->result['stat'] . "'><err code='00' msg='Currently not supported' /></rsp>\n";
		}	
		
	}

	/**
	 * PHP5 style destructor and will run when the class is finished.
	 *
	 * @return output
	 */
	function __destruct() {
		echo $this->output;
	}

}

// let's use it
$nggAPI = new nggAPI;