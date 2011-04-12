<?php
/*
Plugin Name: NextGEN Gallery
Plugin URI: http://alexrabe.de/?page_id=80
Description: A NextGENeration Photo gallery for the Web 2.0.
Author: Alex Rabe
Version: 1.5.1

Author URI: http://alexrabe.de/

Copyright 2007-2010 by Alex Rabe & NextGEN DEV-Team

The NextGEN button is taken from the Fugue Icons of http://www.pinvoke.com/.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Please note  :

The JW Image Rotator (Slideshow) is not part of this license and is available
under a Creative Commons License, which allowing you to use, modify and redistribute 
them for noncommercial purposes. 

For commercial use please look at the Jeroen's homepage : http://www.longtailvideo.com 

*/ 

// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

// ini_set('display_errors', '1');
// ini_set('error_reporting', E_ALL);
if (!class_exists('nggLoader')) {
class nggLoader {
	
	var $version     = '1.5.1';
	var $dbversion   = '1.5.0';
	var $minium_WP   = '2.9';
	var $minium_WPMU = '2.9';
	var $updateURL   = 'http://nextgen.boelinger.com/version.php';
	var $donators    = 'http://nextgen.boelinger.com/donators.php';
	var $options     = '';
	var $manage_page;
	var $add_PHP5_notice = false;
	
	function nggLoader() {

		// Load the language file
		$this->load_textdomain();
		
		// All credits to the tranlator 
		$this->translator  = '<p class="hint">'. __('<strong>Translation by : </strong><a target="_blank" href="http://alexrabe.de/wordpress-plugins/nextgen-gallery/languages/">See here</a>', 'nggallery') . '</p>';
		$this->translator .= '<p class="hint">'. __('<strong>This translation is not yet updated for Version 1.5.0</strong>. If you would like to help with translation, download the current po from the plugin folder and read <a href="http://alexrabe.de/wordpress-plugins/wordtube/translation-of-plugins/">here</a> how you can translate the plugin.', 'nggallery') . '</p>'; 

		// Stop the plugin if we missed the requirements
		if ( ( !$this->required_version() ) || ( !$this->check_memory_limit() ) )
			return;
			
		// Get some constants first
		$this->load_options();
		$this->define_constant();
		$this->define_tables();
		$this->load_dependencies();
		$this->start_rewrite_module();
		
		$this->plugin_name = plugin_basename(__FILE__);
		
		// Init options & tables during activation & deregister init option
		register_activation_hook( $this->plugin_name, array(&$this, 'activate') );
		register_deactivation_hook( $this->plugin_name, array(&$this, 'deactivate') );	

		// Register a uninstall hook to remove all tables & option automatic
		register_uninstall_hook( $this->plugin_name, array('nggLoader', 'uninstall') );

		// Start this plugin once all other plugins are fully loaded
		add_action( 'plugins_loaded', array(&$this, 'start_plugin') );
		
		// Register_taxonomy must be used during the init
		add_action( 'init', array(&$this, 'register_taxonomy') );
		
		// Add a message for PHP4 Users, can disable the update message later on
		if (version_compare(PHP_VERSION, '5.0.0', '<'))
			add_filter('transient_update_plugins', array(&$this, 'disable_upgrade'));
		
		//Add some links on the plugin page
		add_filter('plugin_row_meta', array(&$this, 'add_plugin_links'), 10, 2);	
		
	}
	
	function start_plugin() {

		global $nggRewrite;
				
		// Content Filters
		add_filter('ngg_gallery_name', 'sanitize_title');

		// Check if we are in the admin area
		if ( is_admin() ) {	
			
			// Pass the init check or show a message
			if (get_option( 'ngg_init_check' ) != false )
				add_action( 'admin_notices', create_function('', 'echo \'<div id="message" class="error"><p><strong>' . get_option( "ngg_init_check" ) . '</strong></p></div>\';') );
				
		} else {			
			
			// Add MRSS to wp_head
			if ( $this->options['useMediaRSS'] )
				add_action('wp_head', array('nggMediaRss', 'add_mrss_alternate_link'));
			
			// If activated, add PicLens/Cooliris javascript to footer
			if ( $this->options['usePicLens'] )
				add_action('wp_head', array('nggMediaRss', 'add_piclens_javascript'));
                
            // Look for XML request, before page is render
            add_action('parse_request',  array(&$this, 'check_request') );    
				
			// Add the script and style files
			add_action('wp_print_scripts', array(&$this, 'load_scripts') );
			add_action('wp_print_styles', array(&$this, 'load_styles') );
			
			// Add a version number to the header
			add_action('wp_head', create_function('', 'echo "\n<meta name=\'NextGEN\' content=\'' . $this->version . '\' />\n";') );

		}	
	}

    function check_request( $wp ) {
    	
    	if ( !array_key_exists('callback', $wp->query_vars) )
    		return;
        
        if ( $wp->query_vars['callback'] == 'imagerotator') {
            require_once (dirname (__FILE__) . '/xml/imagerotator.php');
            exit();
        }

        if ( $wp->query_vars['callback'] == 'json') {
            require_once (dirname (__FILE__) . '/xml/json.php');
            exit();
        }

        if ( $wp->query_vars['callback'] == 'image') {
            require_once (dirname (__FILE__) . '/nggshow.php');
            exit();
        }
        
		//TODO:see trac #12400 could be an option for WP3.0 
        if ( $wp->query_vars['callback'] == 'ngg-ajax') {
            require_once (dirname (__FILE__) . '/xml/ajax.php');
            exit();
        }
        
    }
	
	function required_version() {
		
		global $wp_version, $wpmu_version;
		
		// Check for WPMU installation
		if (!defined ('IS_WPMU'))
			define('IS_WPMU', version_compare($wpmu_version, $this->minium_WPMU, '>=') );
			
		// Check for WP version installation
		$wp_ok  =  version_compare($wp_version, $this->minium_WP, '>=');
		
		if ( ($wp_ok == FALSE) and (IS_WPMU == FALSE) ) {
			add_action(
				'admin_notices', 
				create_function(
					'', 
					'global $ngg; printf (\'<div id="message" class="error"><p><strong>\' . __(\'Sorry, NextGEN Gallery works only under WordPress %s or higher\', "nggallery" ) . \'</strong></p></div>\', $ngg->minium_WP );'
				)
			);
			return false;
		}
		
		return true;
		
	}
	
	function check_memory_limit() {
		
		$memory_limit = (int) substr( ini_get('memory_limit'), 0, -1);
		//This works only with enough memory, 12MB is silly, wordpress requires already 16MB :-)
		if ( ($memory_limit != 0) && ($memory_limit < 12 ) ) {
			add_action(
				'admin_notices', 
				create_function(
					'', 
					'echo \'<div id="message" class="error"><p><strong>' . __('Sorry, NextGEN Gallery works only with a Memory Limit of 16 MB higher', 'nggallery') . '</strong></p></div>\';'
				)
			);
			return false;
		}
		
		return true;
		
	}
	
	function define_tables() {		
		global $wpdb;
		
		// add database pointer 
		$wpdb->nggpictures					= $wpdb->prefix . 'ngg_pictures';
		$wpdb->nggallery					= $wpdb->prefix . 'ngg_gallery';
		$wpdb->nggalbum						= $wpdb->prefix . 'ngg_album';
		
	}
	
	function register_taxonomy() {
		global $wp_rewrite;

		// Register the NextGEN taxonomy
		$args = array(
 	            'label' => __('Picture tag', 'nggallery'),
 	            'template' => __('Picture tag: %2$l.', 'nggallery'),
	            'helps' => __('Separate picture tags with commas.', 'nggallery'),
	            'sort' => true,
 	            'args' => array('orderby' => 'term_order')
				);
					
		register_taxonomy( 'ngg_tag', 'nggallery', $args );
	}
	
	function define_constant() {
		
		//TODO:SHOULD BE REMOVED LATER
		define('NGGVERSION', $this->version);
		// Minimum required database version
		define('NGG_DBVERSION', $this->dbversion);
		define('NGGURL', $this->updateURL);

		// required for Windows & XAMPP
		define('WINABSPATH', str_replace("\\", "/", ABSPATH) );
			
		// define URL
		define('NGGFOLDER', plugin_basename( dirname(__FILE__)) );
		
		define('NGGALLERY_ABSPATH', trailingslashit( str_replace("\\","/", WP_PLUGIN_DIR . '/' . plugin_basename( dirname(__FILE__) ) ) ) );
		define('NGGALLERY_URLPATH', trailingslashit( WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) ) );
		
		// look for imagerotator
		define('NGGALLERY_IREXIST', !empty( $this->options['irURL'] ));

		// get value for safe mode
		if ( (gettype( ini_get('safe_mode') ) == 'string') ) {
			// if sever did in in a other way
			if ( ini_get('safe_mode') == 'off' ) define('SAFE_MODE', FALSE);
			else define( 'SAFE_MODE', ini_get('safe_mode') );
		} else
		define( 'SAFE_MODE', ini_get('safe_mode') );
		
	}
	
	function load_dependencies() {
		global $nggdb;
	
		// Load global libraries												// average memory usage (in bytes)
		require_once (dirname (__FILE__) . '/lib/core.php');					//  94.840
		require_once (dirname (__FILE__) . '/lib/ngg-db.php');					// 132.400
		require_once (dirname (__FILE__) . '/lib/image.php');					//  59.424
		require_once (dirname (__FILE__) . '/lib/post-thumbnail.php');			//  n.a.
		require_once (dirname (__FILE__) . '/widgets/widgets.php');				// 298.792
		
		//Just needed if you access remote to WordPress
		if ( defined('XMLRPC_REQUEST') )
			require_once (dirname (__FILE__) . '/lib/xmlrpc.php');
			
		// We didn't need all stuff during a AJAX operation
		if ( defined('DOING_AJAX') )
			require_once (dirname (__FILE__) . '/admin/ajax.php');
		else {
			require_once (dirname (__FILE__) . '/lib/meta.php');				// 131.856
			require_once (dirname (__FILE__) . '/lib/tags.php');				// 117.136
			require_once (dirname (__FILE__) . '/lib/media-rss.php');			//  82.768
			require_once (dirname (__FILE__) . '/lib/rewrite.php');				//  71.936
			include_once (dirname (__FILE__) . '/admin/tinymce/tinymce.php'); 	//  22.408

			// Load backend libraries
			if ( is_admin() ) {	
				require_once (dirname (__FILE__) . '/admin/admin.php');
				require_once (dirname (__FILE__) . '/admin/media-upload.php');
				$this->nggAdminPanel = new nggAdminPanel();
				
			// Load frontend libraries							
			} else {
				require_once (dirname (__FILE__) . '/lib/navigation.php');		// 242.016
				require_once (dirname (__FILE__) . '/nggfunctions.php');		// n.a.
				require_once (dirname (__FILE__) . '/lib/shortcodes.php'); 		// 92.664
			}	
		}
	}
	
	function load_textdomain() {
		
		load_plugin_textdomain('nggallery', false, dirname( plugin_basename(__FILE__) ) . '/lang');

	}
	
	function load_scripts() {
		
		//	activate Thickbox
		if ($this->options['thumbEffect'] == 'thickbox') {
			wp_enqueue_script( 'thickbox' );
			// Load the thickbox images after all other scripts
			add_action( 'wp_footer', array(&$this, 'load_thickbox_images'), 11 );

		}

		// activate modified Shutter reloaded if not use the Shutter plugin
		if ( ($this->options['thumbEffect'] == "shutter") && !function_exists('srel_makeshutter') ) {
			wp_register_script('shutter', NGGALLERY_URLPATH .'shutter/shutter-reloaded.js', false ,'1.3.0');
			wp_localize_script('shutter', 'shutterSettings', array(
						'msgLoading' => __('L O A D I N G', 'nggallery'),
						'msgClose' => __('Click to Close', 'nggallery'),
						'imageCount' => '1'				
			) );
			wp_enqueue_script( 'shutter' );
	    }
		
		// required for the slideshow
		if ( NGGALLERY_IREXIST == true ) 
			wp_enqueue_script('swfobject', NGGALLERY_URLPATH .'admin/js/swfobject.js', FALSE, '2.2');

		// Load AJAX navigation script, works only with shutter script as we need to add the listener
		if ( $this->options['galAjaxNav'] ) { 
			if ( ($this->options['thumbEffect'] == "shutter") || function_exists('srel_makeshutter') ) {
				wp_enqueue_script ( 'ngg_script', NGGALLERY_URLPATH . 'js/ngg.js', array('jquery'), '2.0');
				wp_localize_script( 'ngg_script', 'ngg_ajax', array('path'		=> NGGALLERY_URLPATH,
                                                                    'callback'  => get_option ('siteurl') . '/' . 'index.php?callback=ngg-ajax',
																	'loading'	=> __('loading', 'nggallery'),
				) );
			}
		}
		
	}
	
	function load_thickbox_images() {
		// WP core reference relative to the images. Bad idea
		echo "\n" . '<script type="text/javascript">tb_pathToImage = "' . get_option('siteurl') . '/wp-includes/js/thickbox/loadingAnimation.gif";tb_closeImage = "' . get_option('siteurl') . '/wp-includes/js/thickbox/tb-close.png";</script>'. "\n";			
	}
	
	function load_styles() {
		
		// check first the theme folder for a nggallery.css
		if ( nggGallery::get_theme_css_file() )
			wp_enqueue_style('NextGEN', nggGallery::get_theme_css_file() , false, '1.0.0', 'screen'); 
		else if ($this->options['activateCSS'])
			wp_enqueue_style('NextGEN', NGGALLERY_URLPATH . 'css/' . $this->options['CSSfile'], false, '1.0.0', 'screen'); 
		
		//	activate Thickbox
		if ($this->options['thumbEffect'] == 'thickbox') 
			wp_enqueue_style( 'thickbox');

		// activate modified Shutter reloaded if not use the Shutter plugin
		if ( ($this->options['thumbEffect'] == 'shutter') && !function_exists('srel_makeshutter') )
			wp_enqueue_style('shutter', NGGALLERY_URLPATH .'shutter/shutter-reloaded.css', false, '1.3.0', 'screen');
		
	}
	
	function load_options() {
		// Load the options
		$this->options = get_option('ngg_options');
	}
	
	// Add rewrite rules
	function start_rewrite_module() {
		global $nggRewrite;	
			
		if ( class_exists('nggRewrite') )
			$nggRewrite = new nggRewrite();	
	}
		
	function activate() {
		
		//Since version 1.4.0 it's tested only with PHP5.2, currently we keep PHP4 support a while
        //if (version_compare(PHP_VERSION, '5.2.0', '<')) { 
        //        deactivate_plugins(plugin_basename(__FILE__)); // Deactivate ourself
        //        wp_die("Sorry, but you can't run this plugin, it requires PHP 5.2 or higher."); 
		//		return; 
        //} 

		include_once (dirname (__FILE__) . '/admin/install.php');
		
		// check for tables
		nggallery_install();
		// remove the update message
		delete_option( 'ngg_update_exists' );
		
	}
	
	function deactivate() {
		
		// remove & reset the init check option
		delete_option( 'ngg_init_check' );
		delete_option( 'ngg_update_exists' );
	}

	function uninstall() {
        include_once (dirname (__FILE__) . '/admin/install.php');
        nggallery_uninstall();
	}
	
	function disable_upgrade($option){

	 	$this_plugin = plugin_basename(__FILE__);
	 	
		// PHP5.2 is required for NGG V1.4.0 
		if ( version_compare($option->response[ $this_plugin ]->new_version, '1.4.0', '>=') )
			return $option;

	    if( isset($option->response[ $this_plugin ]) ){
	        //TODO:Clear its download link, not now but maybe later
	        //$option->response[ $this_plugin ]->package = '';
	        
	        //Add a notice message
	        if ($this->add_PHP5_notice == false){
   	    		add_action( "in_plugin_update_message-$this->plugin_name", create_function('', 'echo \'<br /><span style="color:red">Please update to PHP5.2 as soon as possible, the plugin is not tested under PHP4 anymore</span>\';') );
	    		$this->add_PHP5_notice = true;
			}
		}
	    return $option;
	}
	
	// Taken from Google XML Sitemaps from Arne Brachhold
	function add_plugin_links($links, $file) {
		
		if ( $file == plugin_basename(__FILE__) ) {
			$links[] = '<a href="admin.php?page=nextgen-gallery">' . __('Overview', 'nggallery') . '</a>';
			$links[] = '<a href="http://wordpress.org/tags/nextgen-gallery?forum_id=10">' . __('Get help', 'nggallery') . '</a>';
			$links[] = '<a href="http://code.google.com/p/nextgen-gallery/">' . __('Contribute', 'nggallery') . '</a>';
			$links[] = '<a href="http://alexrabe.de/donation/">' . __('Donate', 'nggallery') . '</a>';
		}
		return $links;
	}
	
}
	// Let's start the holy plugin
	global $ngg;
	$ngg = new nggLoader();
}
?>
