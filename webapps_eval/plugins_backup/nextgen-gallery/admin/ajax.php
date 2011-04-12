<?php

/**
 * @author Alex Rabe
 * @copyright 2008 - 2009
 */

add_action('wp_ajax_ngg_ajax_operation', 'ngg_ajax_operation' );

function ngg_ajax_operation() {
		
	global $wpdb;

	// if nonce is not correct it returns -1
	check_ajax_referer( "ngg-ajax" );
	
	// check for correct capability
	if ( !is_user_logged_in() )
		die('-1');

	// check for correct NextGEN capability
	if ( !current_user_can('NextGEN Upload images') && !current_user_can('NextGEN Manage gallery') ) 
		die('-1');	
	
	// include the ngg function
	include_once (dirname (__FILE__). '/functions.php');

	// Get the image id
	if ( isset($_POST['image'])) {
		$id = (int) $_POST['image'];
		// let's get the image data
		$picture = nggdb::find_image( $id );
		// what do you want to do ?		
		switch ( $_POST['operation'] ) {
			case 'create_thumbnail' :
				$result = nggAdmin::create_thumbnail($picture);
			break;
			case 'resize_image' :
				$result = nggAdmin::resize_image($picture);
			break;
			case 'rotate_cw' :
				$result = nggAdmin::rotate_image($picture, 'CW');
				nggAdmin::create_thumbnail($picture);
			break;
			case 'rotate_ccw' :
				$result = nggAdmin::rotate_image($picture, 'CCW');
				nggAdmin::create_thumbnail($picture);
			break;			
			case 'set_watermark' :
				$result = nggAdmin::set_watermark($picture);
			break;
			case 'recover_image' :
				$result = nggAdmin::recover_image($picture);
			break;			
			case 'import_metadata' :
				$result = nggAdmin::import_MetaData( $id );
			break;
			case 'get_image_ids' :
				$result = nggAdmin::get_image_ids( $id );
			break;
			default :
				do_action( 'ngg_ajax_' . $_POST['operation'] );
				die('-1');	
			break;		
		}
		// A success should return a '1'
		die ($result);
	}
	
	// The script should never stop here
	die('0');
}

add_action('wp_ajax_createNewThumb', 'createNewThumb');
	
function createNewThumb() {
	
    global $ngg;
    
	// check for correct capability
	if ( !is_user_logged_in() )
		die('-1');
		
	// check for correct NextGEN capability
	if ( !current_user_can('NextGEN Manage gallery') ) 
		die('-1');	

	include_once( nggGallery::graphic_library() );

	$id 	 = (int) $_POST['id'];
	$picture = nggdb::find_image( $id );

	$x = round( $_POST['x'] * $_POST['rr'], 0);
	$y = round( $_POST['y'] * $_POST['rr'], 0);
	$w = round( $_POST['w'] * $_POST['rr'], 0);
	$h = round( $_POST['h'] * $_POST['rr'], 0);
	
	$thumb = new ngg_Thumbnail($picture->imagePath, TRUE);
	
	$thumb->crop($x, $y, $w, $h);
    
    // Note : the routine is a bit different to create_thumbnail(), due to rounding it's resized in the other way
	if ($ngg->options['thumbfix'])  {
		// check for portrait format
		if ($thumb->currentDimensions['height'] > $thumb->currentDimensions['width']) {
			// first resize to the wanted height, here changed to create_thumbnail()
			$thumb->resize(0, $ngg->options['thumbheight']);
			// get optimal y startpos
			$ypos = ($thumb->currentDimensions['height'] - $ngg->options['thumbheight']) / 2;
			$thumb->crop(0, $ypos, $ngg->options['thumbwidth'],$ngg->options['thumbheight']);	
		} else {
			// first resize to the wanted width, here changed to create_thumbnail()
            $thumb->resize($ngg->options['thumbwidth'], 0);
			//	
			// get optimal x startpos
			$xpos = ($thumb->currentDimensions['width'] - $ngg->options['thumbwidth']) / 2;
			$thumb->crop($xpos, 0, $ngg->options['thumbwidth'],$ngg->options['thumbheight']);	
		}
	//this create a thumbnail but keep ratio settings	
	} else {
		$thumb->resize($ngg->options['thumbwidth'],$ngg->options['thumbheight']);	
	}    
	
	if ( $thumb->save($picture->thumbPath, 100)) {
		
		//read the new sizes
		$new_size = @getimagesize ( $picture->thumbPath );
		$size['width'] = $new_size[0];
		$size['height'] = $new_size[1]; 
		
		// add them to the database
		nggdb::update_image_meta($picture->pid, array( 'thumbnail' => $size) );
		
		echo "OK";
	} else {
		header('HTTP/1.1 500 Internal Server Error');			
		echo "KO";
	}
	
	exit();
	
}
	
add_action('wp_ajax_rotateImage', 'ngg_rotateImage');
	
function ngg_rotateImage() {
	
	// check for correct capability
	if ( !is_user_logged_in() )
		die('-1');
		
	// check for correct NextGEN capability
	if ( !current_user_can('NextGEN Manage gallery') ) 
		die('-1');	

	require_once( dirname( dirname(__FILE__) ) . '/ngg-config.php');

	// include the ngg function
	include_once (dirname (__FILE__). '/functions.php');
			
	$ngg_options = get_option('ngg_options');
	
	$id = (int) $_POST['id'];
	$result = '-1';
	
	switch ( $_POST['ra'] ) {
		case 'cw' :
			$result = nggAdmin::rotate_image($id, 'CW');
		break;
		case 'ccw' :
			$result = nggAdmin::rotate_image($id, 'CCW');
		break;
		case 'fv' :
			$result = nggAdmin::rotate_image($id, 0, 'V');
		break;
		case 'fh' :
			$result = nggAdmin::rotate_image($id, 0, 'H');
		break;
	}
    
    // recreate the thumbnail     
    nggAdmin::create_thumbnail($id);
	
	if ( $result == 1 )
		die('1');

	header('HTTP/1.1 500 Internal Server Error');			
	die( $result );
	
}

add_action('wp_ajax_ngg_dashboard', 'ngg_ajax_dashboard');
function ngg_ajax_dashboard() {
    
   	require_once( dirname( dirname(__FILE__) ) . '/admin/admin.php');
	require_once( dirname( dirname(__FILE__) ) . '/admin/overview.php');
    
   	if ( !current_user_can('NextGEN Gallery overview') ) 
		die('-1');	
        
    @header( 'Content-Type: ' . get_option( 'html_type' ) . '; charset=' . get_option( 'blog_charset' ) );
    @header( 'X-Content-Type-Options: nosniff' ); 
    
    switch ( $_GET['jax'] ) {
    
    case 'ngg_lastdonators' :
    	ngg_overview_donators();
    	break;
    
    case 'dashboard_primary' :
    	ngg_overview_news();
    	break;
    
    case 'ngg_locale' :
    	ngg_locale();
    	break;
    
    case 'dashboard_plugins' :
    	ngg_related_plugins();
    	break;

    }
    die();    
}