<?php
/**
 * nggAdminPanel - Admin Section for NextGEN Gallery
 * 
 * @package NextGEN Gallery
 * @author Alex Rabe
 * @copyright 2008-2009
 * @since 1.0.0
 */
class nggAdminPanel{
	
	// constructor
	function nggAdminPanel() {

		// Add the admin menu
		add_action( 'admin_menu', array (&$this, 'add_menu') );
		
		// Add the script and style files
		add_action('admin_print_scripts', array(&$this, 'load_scripts') );
		add_action('admin_print_styles', array(&$this, 'load_styles') );
		
		add_action( 'admin_print_footer_scripts', 'codepress_footer_js' );

		add_filter('contextual_help', array(&$this, 'show_help'), 10, 2);
		add_filter('screen_meta_screen', array(&$this, 'edit_screen_meta'));
	}

	// integrate the menu	
	function add_menu()  {
	
		add_menu_page( _n( 'Gallery', 'Galleries', 1, 'nggallery' ), _n( 'Gallery', 'Galleries', 1, 'nggallery' ), 'NextGEN Gallery overview', NGGFOLDER, array (&$this, 'show_menu'), NGGALLERY_URLPATH .'admin/images/nextgen.png' );
	    add_submenu_page( NGGFOLDER , __('Overview', 'nggallery'), __('Overview', 'nggallery'), 'NextGEN Gallery overview', NGGFOLDER, array (&$this, 'show_menu'));
		add_submenu_page( NGGFOLDER , __('Add Gallery / Images', 'nggallery'), __('Add Gallery / Images', 'nggallery'), 'NextGEN Upload images', 'nggallery-add-gallery', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , __('Manage Gallery', 'nggallery'), __('Manage Gallery', 'nggallery'), 'NextGEN Manage gallery', 'nggallery-manage-gallery', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , _n( 'Album', 'Albums', 1, 'nggallery' ), _n( 'Album', 'Albums', 1, 'nggallery' ), 'NextGEN Edit album', 'nggallery-manage-album', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , __('Tags', 'nggallery'), __('Tags', 'nggallery'), 'NextGEN Manage tags', 'nggallery-tags', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , __('Options', 'nggallery'), __('Options', 'nggallery'), 'NextGEN Change options', 'nggallery-options', array (&$this, 'show_menu'));
	    if (wpmu_enable_function('wpmuStyle'))
			add_submenu_page( NGGFOLDER , __('Style', 'nggallery'), __('Style', 'nggallery'), 'NextGEN Change style', 'nggallery-style', array (&$this, 'show_menu'));
	    if (wpmu_enable_function('wpmuRoles'))
			add_submenu_page( NGGFOLDER , __('Roles', 'nggallery'), __('Roles', 'nggallery'), 'activate_plugins', 'nggallery-roles', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , __('About this Gallery', 'nggallery'), __('About', 'nggallery'), 'NextGEN Gallery overview', 'nggallery-about', array (&$this, 'show_menu'));
		if ( wpmu_site_admin() )
			add_submenu_page( 'wpmu-admin.php' , __('NextGEN Gallery', 'nggallery'), __('NextGEN Gallery', 'nggallery'), 'activate_plugins', 'nggallery-wpmu', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , __('Reset / Uninstall', 'nggallery'), __('Reset / Uninstall', 'nggallery'), 'activate_plugins', 'nggallery-setup', array (&$this, 'show_menu'));

		//register the column fields
		$this->register_columns();	

	}

	// load the script for the defined page and load only this code	
	function show_menu() {
		
		global $ngg;
		
		// init PluginChecker
		$nggCheck 			= new CheckPlugin();	
		$nggCheck->URL 		= NGGURL;
		$nggCheck->version 	= NGGVERSION;
		$nggCheck->name 	= 'ngg';

		// check for upgrade and show upgrade screen
		if( get_option( 'ngg_db_version' ) != NGG_DBVERSION ) {
			include_once ( dirname (__FILE__) . '/functions.php' );
			include_once ( dirname (__FILE__) . '/upgrade.php' );
			nggallery_upgrade_page();
			return;			
		}
		
		// Show update message
        if ( current_user_can('activate_plugins') )
    		if ( $nggCheck->startCheck() && (!IS_WPMU) ) {
    			echo '<div class="plugin-update">' . __('A new version of NextGEN Gallery is available !', 'nggallery') . ' <a href="http://wordpress.org/extend/plugins/nextgen-gallery/download/" target="_blank">' . __('Download here', 'nggallery') . '</a></div>' ."\n";
    		}
		
		// Set installation date
		if( empty($ngg->options['installDate']) ) {
			$ngg->options['installDate'] = time();
			update_option('ngg_options', $ngg->options);			
		}
		
		// Show donation message only one time.
		if (isset ( $_GET['hide_donation']) ) {
			$ngg->options['hideDonation'] = true;
			update_option('ngg_options', $ngg->options);			
		}
		
		if( $ngg->options['hideDonation'] !== true ) {
			if ( time() > ( $ngg->options['installDate'] + ( 60 * 60 * 24 * 30 ) ) ) {
			?>	
				<div id="donator_message">
					<p><?php echo str_replace('%s', 'http://alexrabe.de/donation', __('Thanks for using this plugin, I hope you are satisfied ! If you would like to support the further development, please consider a <strong><a href="%s">donation</a></strong>! If you still need some help, please post your questions <a href="http://wordpress.org/tags/nextgen-gallery?forum_id=10">here</a> .', 'nggallery')); ?>
						<span>
							<a href="<?php echo add_query_arg( array( 'hide_donation' => 'true') ); ?>" >
								<small><?php _e('OK, hide this message now !', 'nggallery'); ?></small>
							</a>
						<span>
					</p>
				</div>
			<?php
			}
		}
		
  		switch ($_GET['page']){
			case "nggallery-add-gallery" :
				include_once ( dirname (__FILE__) . '/functions.php' );		// admin functions
				include_once ( dirname (__FILE__) . '/addgallery.php' );	// nggallery_admin_add_gallery
				$ngg->addgallery_page = new nggAddGallery ();
				$ngg->addgallery_page->controller();
				break;
			case "nggallery-manage-gallery" :
				include_once ( dirname (__FILE__) . '/functions.php' );		// admin functions
				include_once ( dirname (__FILE__) . '/manage.php' );		// nggallery_admin_manage_gallery
				// Initate the Manage Gallery page
				$ngg->manage_page = new nggManageGallery ();
				// Render the output now, because you cannot access a object during the constructor is not finished
				$ngg->manage_page->controller();
				
				break;
			case "nggallery-manage-album" :
				include_once ( dirname (__FILE__) . '/album.php' );			// nggallery_admin_manage_album
				$ngg->manage_album = new nggManageAlbum ();
				$ngg->manage_album->controller();
				break;				
			case "nggallery-options" :
				include_once ( dirname (__FILE__) . '/settings.php' );		// nggallery_admin_options
				$ngg->option_page = new nggOptions ();
				$ngg->option_page->controller();
				break;
			case "nggallery-tags" :
				include_once ( dirname (__FILE__) . '/tags.php' );			// nggallery_admin_tags
				break;
			case "nggallery-style" :
				include_once ( dirname (__FILE__) . '/style.php' );			// nggallery_admin_style
				nggallery_admin_style();
				break;
			case "nggallery-setup" :
				include_once ( dirname (__FILE__) . '/setup.php' );			// nggallery_admin_setup
				nggallery_admin_setup();
				break;
			case "nggallery-roles" :
				include_once ( dirname (__FILE__) . '/roles.php' );			// nggallery_admin_roles
				nggallery_admin_roles();
				break;
			case "nggallery-import" :
				include_once ( dirname (__FILE__) . '/myimport.php' );		// nggallery_admin_import
				nggallery_admin_import();
				break;
			case "nggallery-about" :
				include_once ( dirname (__FILE__) . '/about.php' );		// nggallery_admin_about
				nggallery_admin_about();
				break;
			case "nggallery-wpmu" :
				include_once ( dirname (__FILE__) . '/style.php' );		
				include_once ( dirname (__FILE__) . '/wpmu.php' );			// nggallery_wpmu_admin
				nggallery_wpmu_setup();
				break;
			case "nggallery" :
			default :
				include_once ( dirname (__FILE__) . '/overview.php' ); 	// nggallery_admin_overview
				nggallery_admin_overview();
				break;
		}
	}
	
	function load_scripts() {
		
		// no need to go on if it's not a plugin page
		if( !isset($_GET['page']) )
			return;

		wp_register_script('ngg-ajax', NGGALLERY_URLPATH . 'admin/js/ngg.ajax.js', array('jquery'), '1.4.0');
		wp_localize_script('ngg-ajax', 'nggAjaxSetup', array(
					'url' => admin_url('admin-ajax.php'),
					'action' => 'ngg_ajax_operation',
					'operation' => '',
					'nonce' => wp_create_nonce( 'ngg-ajax' ),
					'ids' => '',
					'permission' => __('You do not have the correct permission', 'nggallery'),
					'error' => __('Unexpected Error', 'nggallery'),
					'failure' => __('A failure occurred', 'nggallery')				
		) );
		wp_register_script('ngg-progressbar', NGGALLERY_URLPATH .'admin/js/ngg.progressbar.js', array('jquery'), '1.0.0');
		wp_register_script('swfupload_f10', NGGALLERY_URLPATH .'admin/js/swfupload.js', array('jquery'), '2.2.0');
				
		switch ($_GET['page']) {
			case NGGFOLDER : 
				wp_enqueue_script( 'postbox' );
				add_thickbox();
			break;	
			case "nggallery-manage-gallery" :
				wp_enqueue_script( 'postbox' );
				wp_enqueue_script( 'ngg-ajax' );
				wp_enqueue_script( 'ngg-progressbar' );
				//wp_enqueue_script( 'jquery-ui-dialog' );
				//TODO:Add Inline edit later
				//wp_enqueue_script( 'ngg-inline-edit', NGGALLERY_URLPATH .'admin/js/ngg.inline-edit-images.js', array('jquery'), '1.0.0' );
				add_thickbox();
			break;
			case "nggallery-manage-album" :
				wp_enqueue_script( 'jquery-ui-sortable' );
				add_thickbox();
			break;
			case "nggallery-options" :
				wp_enqueue_script( 'jquery-ui-tabs' );
				wp_enqueue_script( 'ngg-colorpicker', NGGALLERY_URLPATH .'admin/js/colorpicker/js/colorpicker.js', array('jquery'), '1.0');
			break;		
			case "nggallery-add-gallery" :
				wp_enqueue_script( 'jquery-ui-tabs' );
				wp_enqueue_script( 'mutlifile', NGGALLERY_URLPATH .'admin/js/jquery.MultiFile.js', array('jquery'), '1.4.4' );
				wp_enqueue_script( 'ngg-swfupload-handler', NGGALLERY_URLPATH .'admin/js/swfupload.handler.js', array('swfupload_f10'), '1.0.0' );
				wp_enqueue_script( 'ngg-ajax' );
				wp_enqueue_script( 'ngg-progressbar' );
			break;
			case "nggallery-style" :
				wp_enqueue_script( 'codepress' );
				wp_enqueue_script( 'ngg-colorpicker', NGGALLERY_URLPATH .'admin/js/colorpicker/js/colorpicker.js', array('jquery'), '1.0');
			break;

		}
	}		
	
	function load_styles() {
		
		// no need to go on if it's not a plugin page
		if( !isset($_GET['page']) )
			return;

		switch ($_GET['page']) {
			case NGGFOLDER :
				wp_enqueue_style( 'thickbox');	
			case "nggallery-about" :
				wp_enqueue_style( 'nggadmin', NGGALLERY_URLPATH .'admin/css/nggadmin.css', false, '2.8.1', 'screen' );
				wp_admin_css( 'css/dashboard' );
			break;
			case "nggallery-add-gallery" :
			case "nggallery-options" :
				wp_enqueue_style( 'nggtabs', NGGALLERY_URLPATH .'admin/css/jquery.ui.tabs.css', false, '2.5.0', 'screen' );
				wp_enqueue_style( 'nggcolorpicker', NGGALLERY_URLPATH .'admin/js/colorpicker/css/colorpicker.css', false, '1.0', 'screen');
			case "nggallery-manage-gallery" :
			case "nggallery-roles" :
			case "nggallery-manage-album" :
				//wp_enqueue_style( 'jqueryui', NGGALLERY_URLPATH .'admin/css/jquery-ui.css', false, '1.7.1', 'screen' );
				wp_enqueue_style( 'nggadmin', NGGALLERY_URLPATH .'admin/css/nggadmin.css', false, '2.8.1', 'screen' );
				wp_enqueue_style( 'thickbox');			
			break;
			case "nggallery-tags" :
				wp_enqueue_style( 'nggtags', NGGALLERY_URLPATH .'admin/css/tags-admin.css', false, '2.6.1', 'screen' );
				break;
			case "nggallery-style" :
				wp_admin_css( 'css/theme-editor' );
				wp_enqueue_style('nggcolorpicker', NGGALLERY_URLPATH.'admin/js/colorpicker/css/colorpicker.css', false, '1.0', 'screen');
				wp_enqueue_style('nggadmincp', NGGALLERY_URLPATH.'admin/css/nggColorPicker.css', false, '1.0', 'screen');
			break;
		}	
	}
	
	function show_help($help, $screen) {
		
		// since WP3.0 it's an object
		if ( is_object($screen) )
			$screen = $screen->id;
		
		$link = '';
		// menu title is localized...
		$i18n = strtolower  ( _n( 'Gallery', 'Galleries', 1, 'nggallery' ) );

		switch ($screen) {
			case 'toplevel_page_' . NGGFOLDER :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Introduction</a>', 'nggallery');
			break;
			case "{$i18n}_page_nggallery-setup" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Setup</a>', 'nggallery');
			break;
			case "{$i18n}_page_nggallery-about" :
				$link  = __('<a href="http://alexrabe.de/wordpress-plugins/nextgen-gallery/languages/" target="_blank">Translation by alex rabe</a>', 'nggallery');
			break;
			case "{$i18n}_page_nggallery-roles" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Roles / Capabilities</a>', 'nggallery');
			break;
			case "{$i18n}_page_nggallery-style" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Styles</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/templates/" target="_blank">' . __('Templates', 'nggallery') . '</a>';
			break;
			case "{$i18n}_page_nggallery-gallery" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Gallery management</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/gallery-page/" target="_blank">' . __('Gallery example', 'nggallery') . '</a>';
			break;
			case "{$i18n}_page_nggallery-manage-gallery" :
			case "nggallery-manage-gallery":
			case "nggallery-manage-images":
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Gallery management</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/gallery-tags/" target="_blank">' . __('Gallery tags', 'nggallery') . '</a>';
			break;
			case "{$i18n}_page_nggallery-manage-album" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Album management</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/album/" target="_blank">' . __('Album example', 'nggallery') . '</a>';
				$link .= ' | <a href="http://nextgen-gallery.com/albumtags/" target="_blank">' . __('Album tags', 'nggallery') . '</a>';
			break;
			case "{$i18n}_page_nggallery-tags" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Gallery tags</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/related-images/" target="_blank">' . __('Related images', 'nggallery') . '</a>';
				$link .= ' | <a href="http://nextgen-gallery.com/gallery-tags/" target="_blank">' . __('Gallery tags', 'nggallery') . '</a>';
				$link .= ' | <a href="http://nextgen-gallery.com/albumtags/" target="_blank">' . __('Album tags', 'nggallery') . '</a>';
			break;
			case "{$i18n}_page_nggallery-options" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-image-management/" target="_blank">Image management</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/custom-fields/" target="_blank">' . __('Custom fields', 'nggallery') . '</a>';
			break;
		}
		
		if ( !empty($link) ) {
			$help  = '<h5>' . __('Get help with NextGEN Gallery', 'nggallery') . '</h5>';
			$help .= '<div class="metabox-prefs">';
			$help .= $link;
			$help .= "</div>\n";
			$help .= '<h5>' . __('More Help & Info', 'nggallery') . '</h5>';
			$help .= '<div class="metabox-prefs">';
			$help .= __('<a href="http://wordpress.org/tags/nextgen-gallery?forum_id=10" target="_blank">Support Forums</a>', 'nggallery');
			$help .= ' | <a href="http://alexrabe.de/wordpress-plugins/nextgen-gallery/faq/" target="_blank">' . __('FAQ', 'nggallery') . '</a>';
			$help .= ' | <a href="http://code.google.com/p/nextgen-gallery/issues/list" target="_blank">' . __('Feature request', 'nggallery') . '</a>';
			$help .= ' | <a href="http://alexrabe.de/wordpress-plugins/nextgen-gallery/languages/" target="_blank">' . __('Get your language pack', 'nggallery') . '</a>';
			$help .= ' | <a href="http://code.google.com/p/nextgen-gallery/" target="_blank">' . __('Contribute development', 'nggallery') . '</a>';
			$help .= ' | <a href="http://wordpress.org/extend/plugins/nextgen-gallery" target="_blank">' . __('Download latest version', 'nggallery') . '</a>';
			$help .= "</div>\n";
		} 
		
		return $help;
	}
	
	function edit_screen_meta($screen) {

		// menu title is localized, so we need to change the toplevel name
		$i18n = strtolower  ( _n( 'Gallery', 'Galleries', 1, 'nggallery' ) );
		
		switch ($screen) {
			case "{$i18n}_page_nggallery-manage-gallery" :
				// we would like to have screen option only at the manage images / gallery page
				if ( isset ($_POST['sortGallery']) )
					$screen = $screen;
				else if ( ($_GET['mode'] == 'edit') || isset ($_POST['backToGallery']) )
					$screen = 'nggallery-manage-images';
				else if ( ($_GET['mode'] == 'sort') )
					$screen = $screen;
				else
					$screen = 'nggallery-manage-gallery';	
			break;
		}

		return $screen;
	}

	function register_column_headers($screen, $columns) {
		global $_wp_column_headers;
	
		if ( !isset($_wp_column_headers) )
			$_wp_column_headers = array();
	
		$_wp_column_headers[$screen] = $columns;
	}

	function register_columns() {
		include_once ( dirname (__FILE__) . '/manage-images.php' );
		
		$this->register_column_headers('nggallery-manage-images', ngg_manage_gallery_columns() );	
	}

	/**
	 * Read an array from a remote url
	 * 
	 * @param string $url
	 * @return array of the content
	 */
	function get_remote_array($url) {
		if ( function_exists('wp_remote_request') ) {
					
			$options = array();
			$options['headers'] = array(
				'User-Agent' => 'NextGEN Gallery Information Reader V' . NGGVERSION . '; (' . get_bloginfo('url') .')'
			 );
			 
			$response = wp_remote_request($url, $options);
			
			if ( is_wp_error( $response ) )
				return false;
		
			if ( 200 != $response['response']['code'] )
				return false;
		   	
			$content = unserialize($response['body']);
	
			if (is_array($content)) 
				return $content;
		}
		
		return false;	
	}

}

function wpmu_site_admin() {
	// Check for site admin
	if ( function_exists('is_site_admin') )
		if ( is_site_admin() )
			return true;
			
	return false;
}

function wpmu_enable_function($value) {
	if (IS_WPMU) {
		$ngg_options = get_site_option('ngg_options');
		return $ngg_options[$value];
	}
	// if this is not WPMU, enable it !
	return true;
}

/**
 * WordPress PHP class to check for a new version.
 * @author Alex Rabe
 * @version 1.50
 *
 // Dashboard update notification example
	function myPlugin_update_dashboard() {
	  $Check = new CheckPlugin();	
	  $Check->URL 	= "YOUR URL";
	  $Check->version = "1.00";
	  $Check->name 	= "myPlugin";
	  if ($Check->startCheck()) {
 	    echo '<h3>Update Information</h3>';
	    echo '<p>A new version is available</p>';
	  } 
	}
	
	add_action('activity_box_end', 'myPlugin_update_dashboard', '0');
 *
 */
if ( !class_exists( "CheckPlugin" ) ) {  
	class CheckPlugin {
		/**
		 * URL with the version of the plugin
		 * @var string
		 */
		var $URL = 'myURL';
		/**
		 * Version of thsi programm or plugin
		 * @var string
		 */
		var $version = '1.00';
		/**
		 * Name of the plugin (will be used in the options table)
		 * @var string
		 */
		var $name = 'myPlugin';
		/**
		 * Waiting period until the next check in seconds
		 * @var int
		 */
		var $period = 86400;					
					
		/**
		 * check for a new version, returns true if a version is avaiable
		 */
		function startCheck() {

			// If we know that a update exists, don't check it again
			if (get_option( $this->name . '_update_exists' ) == 'true' )
				return true;

			$check_intervall = get_option( $this->name . '_next_update' );

			if ( ($check_intervall < time() ) or (empty($check_intervall)) ) {
				
				// Do not bother the server to often
				$check_intervall = time() + $this->period;
				update_option( $this->name . '_next_update', $check_intervall );
				
				if ( function_exists('wp_remote_request') ) {
					
					$options = array();
					$options['headers'] = array(
						'User-Agent' => 'NextGEN Gallery Version Checker V' . NGGVERSION . '; (' . get_bloginfo('url') .')'
					 );
					$response = wp_remote_request($this->URL, $options);
					
					if ( is_wp_error( $response ) )
						return false;
				
					if ( 200 != $response['response']['code'] )
						return false;
				   	
					$server_version = unserialize($response['body']);

					if (is_array($server_version)) {
						if ( version_compare($server_version[$this->name], $this->version, '>') ) {
							update_option( $this->name . '_update_exists', 'true' );
							return true;
						}
					} 
						
					delete_option( $this->name . '_update_exists' );					
					return false;
				}				
			}
		}
	}
}

?>