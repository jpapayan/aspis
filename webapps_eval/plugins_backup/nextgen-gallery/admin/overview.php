<?php  
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

/**
 * nggallery_admin_overview()
 *
 * Add the admin overview the dashboard style 
 * @return mixed content
 */
function nggallery_admin_overview()  {
    
	?>
	<div class="wrap ngg-wrap">
		<h2><?php _e('NextGEN Gallery Overview', 'nggallery') ?></h2>
        <?php if (version_compare(PHP_VERSION, '5.0.0', '<')) ngg_check_for_PHP5(); ?>
		<div id="dashboard-widgets-wrap" class="ngg-overview">
		    <div id="dashboard-widgets" class="metabox-holder">
				<div id="post-body">
					<div id="dashboard-widgets-main-content">
						<div class="postbox-container" style="width:49%;">
							<?php do_meta_boxes('ngg_overview', 'left', ''); ?>
						</div>
			    		<div class="postbox-container" style="width:49%;">
							<?php do_meta_boxes('ngg_overview', 'right', ''); ?>
						</div>						
					</div>
				</div>
		    </div>
		</div>
	</div>
	<script type="text/javascript">
		//<![CDATA[
        var ajaxWidgets, ajaxPopulateWidgets;
        
        jQuery(document).ready( function($) {
        	// These widgets are sometimes populated via ajax
        	ajaxWidgets = [
        		'ngg_lastdonators',
        		'dashboard_primary',
        		'ngg_locale',
        		'dashboard_plugins'
        	];
        
        	ajaxPopulateWidgets = function(el) {
        		show = function(id, i) {
        			var p, e = $('#' + id + ' div.inside:visible').find('.widget-loading');
        			if ( e.length ) {
        				p = e.parent();
        				setTimeout( function(){
        					p.load('admin-ajax.php?action=ngg_dashboard&jax=' + id, '', function() {
        						p.hide().slideDown('normal', function(){
        							$(this).css('display', '');
        							if ( 'dashboard_plugins' == id && $.isFunction(tb_init) )
        								tb_init('#dashboard_plugins a.thickbox');
        						});
        					});
        				}, i * 500 );
        			}
        		}
        		if ( el ) {
        			el = el.toString();
        			if ( $.inArray(el, ajaxWidgets) != -1 )
        				show(el, 0);
        		} else {
        			$.each( ajaxWidgets, function(i) {
        				show(this, i);
        			});
        		}
        	};
        	ajaxPopulateWidgets();
        } );

		jQuery(document).ready( function($) {
			// postboxes setup
			postboxes.add_postbox_toggles('ngg-overview');
		});
		//]]>
	</script>
	<?php
}

/**
 * Load the meta boxes
 *
 */
add_meta_box('dashboard_right_now', __('Welcome to NextGEN Gallery !', 'nggallery'), 'ngg_overview_right_now', 'ngg_overview', 'left', 'core');
if ( !(get_locale() == 'en_US') )
	add_meta_box('ngg_locale', __('Translation', 'nggallery'), 'ngg_widget_locale', 'ngg_overview', 'left', 'core');
add_meta_box('dashboard_primary', __('Latest News', 'nggallery'), 'ngg_widget_overview_news', 'ngg_overview', 'right', 'core');
add_meta_box('ngg_lastdonators', __('Recent donators', 'nggallery'), 'ngg_widget_overview_donators', 'ngg_overview', 'left', 'core');
add_meta_box('ngg_server', __('Server Settings', 'nggallery'), 'ngg_overview_server', 'ngg_overview', 'left', 'core');
add_meta_box('dashboard_plugins', __('Related plugins', 'nggallery'), 'ngg_widget_related_plugins', 'ngg_overview', 'right', 'core');
add_meta_box('ngg_gd_lib', __('Graphic Library', 'nggallery'), 'ngg_overview_graphic_lib', 'ngg_overview', 'right', 'core');

/**
 * Show the server settings in a dashboard widget
 * 
 * @return void
 */
function ngg_overview_server() {
?>
<div id="dashboard_server_settings" class="dashboard-widget-holder wp_dashboard_empty">
	<div class="ngg-dashboard-widget">
	  <?php if (IS_WPMU) {
	  	if (wpmu_enable_function('wpmuQuotaCheck'))
			echo ngg_SpaceManager::details();
		else {
			//TODO:WPMU message in WP2.5 style
			echo ngg_SpaceManager::details();
		}
	  } else { ?>
	  	<div class="dashboard-widget-content">
      		<ul class="settings">
      		<?php ngg_get_serverinfo(); ?>
	   		</ul>
		</div>
	  <?php } ?>
    </div>
</div>
<?php	
}

/**
 * Show the GD lib info in a dashboard widget
 * 
 * @return void
 */
function ngg_overview_graphic_lib() {
?>
<div id="dashboard_graphic_settings" class="dashboard-widget-holder">
	<div class="ngg-dashboard-widget">
	  	<div class="dashboard-widget-content">
	  		<ul class="settings">
			<?php ngg_gd_info(); ?>
			</ul>
		</div>
    </div>
</div>
<?php	
}

/**
 * Show the most recent donators
 * 
 * @return void
 */
function ngg_widget_overview_donators() { 
    echo '<p class="widget-loading hide-if-no-js">' . __( 'Loading&#8230;' ) . '</p><p class="describe hide-if-js">' . __('This widget requires JavaScript.') . '</p>';
}
 
function ngg_overview_donators() {
	global $ngg;
	
	$i = 0;
	$list = '';
	
	$supporter = nggAdminPanel::get_remote_array($ngg->donators);

	// Ensure that this is a array
	if ( !is_array($supporter) )
		return _e('Thanks to all donators...', 'nggallery');
		
	$supporter = array_reverse($supporter);
	
	foreach ($supporter as $name => $url) {
		$i++;
		if ($url)
			$list .= "<li><a href=\"$url\">$name</a></li>\n";
		else
			$list .= "<li>$name</li>";
		if ($i > 4)
			break;
	}

?>
<div id="dashboard_server_settings" class="dashboard-widget-holder">
	<div class="ngg-dashboard-widget">
	  	<div class="dashboard-widget-content">
	  		<ul class="settings">
			<?php echo $list; ?>
			</ul>
			<p class="textright">
				<a class="button" href="admin.php?page=nggallery-about#donators"><?php _e('View all', 'nggallery'); ?></a>
			</p>
		</div>
    </div>
</div>
<?php	
}

/**
 * Show the latest NextGEN Gallery news
 * 
 * @return void
 */
function ngg_widget_overview_news() { 
    echo '<p class="widget-loading hide-if-no-js">' . __( 'Loading&#8230;' ) . '</p><p class="describe hide-if-js">' . __('This widget requires JavaScript.') . '</p>';
} 
function ngg_overview_news(){

?>
<div class="rss-widget">
    <?php
    $rss = @fetch_feed( 'http://feeds.feedburner.com/alexrabe' );
      
    if ( is_object($rss) ) {

        if ( is_wp_error($rss) ) {
            echo '<p>' . sprintf(__('Newsfeed could not be loaded.  Check the <a href="%s">front page</a> to check for updates.', 'nggallery'), 'http://alexrabe.de/') . '</p>';
    		return;
        }
        
        echo '<ul>';
		foreach ( $rss->get_items(0, 3) as $item ) {
    		$link = $item->get_link();
    		while ( stristr($link, 'http') != $link )
    			$link = substr($link, 1);
    		$link = esc_url(strip_tags($link));
    		$title = esc_attr(strip_tags($item->get_title()));
    		if ( empty($title) )
    			$title = __('Untitled');
    
    		$desc = str_replace( array("\n", "\r"), ' ', esc_attr( strip_tags( @html_entity_decode( $item->get_description(), ENT_QUOTES, get_option('blog_charset') ) ) ) );
    		$desc = wp_html_excerpt( $desc, 360 );
    
    		// Append ellipsis. Change existing [...] to [&hellip;].
    		if ( '[...]' == substr( $desc, -5 ) )
    			$desc = substr( $desc, 0, -5 ) . '[&hellip;]';
    		elseif ( '[&hellip;]' != substr( $desc, -10 ) )
    			$desc .= ' [&hellip;]';
    
    		$desc = esc_html( $desc );
            
			$date = $item->get_date();
            $diff = '';
            
			if ( $date ) {
			    
                $diff = human_time_diff( strtotime($date, time()) );
                 
				if ( $date_stamp = strtotime( $date ) )
					$date = ' <span class="rss-date">' . date_i18n( get_option( 'date_format' ), $date_stamp ) . '</span>';
				else
					$date = '';
			}            
        ?>
          <li><a class="rsswidget" title="" href='<?php echo $link; ?>'><?php echo $title; ?></a>
		  <span class="rss-date"><?php echo $date; ?></span> 
          <div class="rssSummary"><strong><?php echo $diff; ?></strong> - <?php echo $desc; ?></div></li>
        <?php
        }
        echo '</ul>';
      }
    ?>
</div>
<?php
}

/**
 * Show a summary of the used images
 * 
 * @return void
 */
function ngg_overview_right_now() {
	global $wpdb;
	$images    = intval( $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->nggpictures") );
	$galleries = intval( $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->nggallery") );
	$albums    = intval( $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->nggalbum") );
?>

<div class="table table_content">
	<p class="sub"><?php _e('At a Glance', 'nggallery'); ?></p>
	<table>
		<tbody>
			<tr class="first">
				<td class="first b"><a href="admin.php?page=nggallery-add-gallery"><?php echo $images; ?></a></td>
				<td class="t"><?php echo _n( 'Image', 'Images', $images, 'nggallery' ); ?></td>
				<td class="b"></td>
				<td class="last"></td>
			</tr>
			<tr>
				<td class="first b"><a href="admin.php?page=nggallery-manage-gallery"><?php echo $galleries; ?></a></td>
				<td class="t"><?php echo _n( 'Gallery', 'Galleries', $galleries, 'nggallery' ); ?></td>
				<td class="b"></td>
				<td class="last"></td>
			</tr>
			<tr>
				<td class="first b"><a href="admin.php?page=nggallery-manage-album"><?php echo $albums; ?></a></td>
				<td class="t"><?php echo _n( 'Album', 'Albums', $albums, 'nggallery' ); ?></td>
				<td class="b"></td>
				<td class="last"></td>
			</tr>
		</tbody>
	</table>
</div>
<div class="versions" style="padding-top:14px">
    <p>
	<?php if(current_user_can('NextGEN Upload images')): ?><a class="button rbutton" href="admin.php?page=nggallery-add-gallery"><?php _e('Upload pictures', 'nggallery') ?></a><?php endif; ?>
	<?php _e('Here you can control your images, galleries and albums.', 'nggallery') ?>
	</p>
	<span>
	<?php
		$userlevel = '<span class="b">' . (current_user_can('manage_options') ? __('Gallery Administrator', 'nggallery') : __('Gallery Editor', 'nggallery')) . '</span>';
        printf(__('You currently have %s rights.', 'nggallery'), $userlevel);
    ?>
    </span>
</div>
<?php
}

/**
 * Looks up for translation file
 * 
 * @return void
 */
function ngg_widget_locale() {
    
	require_once(NGGALLERY_ABSPATH . '/lib/locale.php');
	
	$locale = new ngg_locale();
	
	$overview_url = admin_url() . 'admin.php?page=' . NGGFOLDER;
	
	// Check if someone would like to update the translation file
	if ( isset($_GET['locale']) && $_GET['locale'] == 'update' ) {
		check_admin_referer('ngg_update_locale');
		
		$result = $locale->download_locale();
		
		if ($result == true) {
		?>
		<p class="hint"><?php _e('Translation file successful updated. Please reload page.', 'nggallery'); ?></p>
		<p class="textright">
			<a class="button" href="<?php echo esc_url(strip_tags($overview_url)); ?>"><?php _e('Reload page', 'nggallery'); ?></a>
		</p>
		<?php
		} else {
		?>
		<p class="hint"><?php _e('Translation file couldn\'t be updated', 'nggallery'); ?></p>
		<?php		
		}
		
		return;
	}
        
    echo '<p class="widget-loading hide-if-no-js">' . __( 'Loading&#8230;' ) . '</p><p class="describe hide-if-js">' . __('This widget requires JavaScript.') . '</p>';
} 

function ngg_locale() {
	global $ngg;
	
	require_once(NGGALLERY_ABSPATH . '/lib/locale.php');
	
	$locale = new ngg_locale();
	$overview_url = admin_url() . 'admin.php?page=' . NGGFOLDER;
    $result = $locale->check();
	$update_url    = wp_nonce_url ( $overview_url . '&amp;locale=update', 'ngg_update_locale');

	//Translators can change this text via gettext
	if ($result == 'installed') {
		echo $ngg->translator;
		if ( !is_wp_error($locale->response) && $locale->response['response']['code'] == '200') {
		?>
		<p class="textright">
			<a class="button" href="<?php echo esc_url( strip_tags($update_url) ); ?>"><?php _e('Update', 'nggallery'); ?></a>
		</p>
		<?php
		}
	}
	
	//Translators can change this text via gettext
	if ($result == 'available') {
		?>
		<p><strong>Download now your language file !</strong></p>
		<p class="textright">
			<a class="button" href="<?php echo esc_url( strip_tags($update_url) ); ?>"><?php _e('Download', 'nggallery'); ?></a>
		</p>
		<?php
	}

	
	if ($result == 'not_exist')
		echo '<p class="hint">'. sprintf( '<strong>Would you like to help to translate this plugin ?</strong> <a target="_blank" href="%s">Download</a> the current pot file and read <a href="http://alexrabe.de/wordpress-plugins/wordtube/translation-of-plugins/">here</a> how you can translate the plugin.', NGGALLERY_URLPATH . 'lang/nggallery.pot').'</p>';

}

/**
 * Show GD Library version information
 * 
 * @return void
 */
function ngg_gd_info() {
	
	if(function_exists("gd_info")){
		$info = gd_info();
		$keys = array_keys($info);
		for($i=0; $i<count($keys); $i++) {
			if(is_bool($info[$keys[$i]]))
				echo "<li> " . $keys[$i] ." : <span>" . ngg_gd_yesNo($info[$keys[$i]]) . "</span></li>\n";
			else
				echo "<li> " . $keys[$i] ." : <span>" . $info[$keys[$i]] . "</span></li>\n";
		}
	}
	else {
		echo '<h4>'.__('No GD support', 'nggallery').'!</h4>';
	}
}

/**
 * Return localized Yes or no 
 * 
 * @param bool $bool
 * @return return 'Yes' | 'No'
 */
function ngg_gd_yesNo( $bool ){
	if($bool) 
		return __('Yes', 'nggallery');
	else 
		return __('No', 'nggallery');
}


/**
 * Show up some server infor's
 * @author GamerZ (http://www.lesterchan.net)
 * 
 * @return void
 */
function ngg_get_serverinfo() {

	global $wpdb;
	// Get MYSQL Version
	$sqlversion = $wpdb->get_var("SELECT VERSION() AS version");
	// GET SQL Mode
	$mysqlinfo = $wpdb->get_results("SHOW VARIABLES LIKE 'sql_mode'");
	if (is_array($mysqlinfo)) $sql_mode = $mysqlinfo[0]->Value;
	if (empty($sql_mode)) $sql_mode = __('Not set', 'nggallery');
	// Get PHP Safe Mode
	if(ini_get('safe_mode')) $safe_mode = __('On', 'nggallery');
	else $safe_mode = __('Off', 'nggallery');
	// Get PHP allow_url_fopen
	if(ini_get('allow_url_fopen')) $allow_url_fopen = __('On', 'nggallery');
	else $allow_url_fopen = __('Off', 'nggallery'); 
	// Get PHP Max Upload Size
	if(ini_get('upload_max_filesize')) $upload_max = ini_get('upload_max_filesize');	
	else $upload_max = __('N/A', 'nggallery');
	// Get PHP Output buffer Size
	if(ini_get('pcre.backtrack_limit')) $backtrack_limit = ini_get('pcre.backtrack_limit');	
	else $backtrack_limit = __('N/A', 'nggallery');
	// Get PHP Max Post Size
	if(ini_get('post_max_size')) $post_max = ini_get('post_max_size');
	else $post_max = __('N/A', 'nggallery');
	// Get PHP Max execution time
	if(ini_get('max_execution_time')) $max_execute = ini_get('max_execution_time');
	else $max_execute = __('N/A', 'nggallery');
	// Get PHP Memory Limit 
	if(ini_get('memory_limit')) $memory_limit = ini_get('memory_limit');
	else $memory_limit = __('N/A', 'nggallery');
	// Get actual memory_get_usage
	if (function_exists('memory_get_usage')) $memory_usage = round(memory_get_usage() / 1024 / 1024, 2) . __(' MByte', 'nggallery');
	else $memory_usage = __('N/A', 'nggallery');
	// required for EXIF read
	if (is_callable('exif_read_data')) $exif = __('Yes', 'nggallery'). " ( V" . substr(phpversion('exif'),0,4) . ")" ;
	else $exif = __('No', 'nggallery');
	// required for meta data
	if (is_callable('iptcparse')) $iptc = __('Yes', 'nggallery');
	else $iptc = __('No', 'nggallery');
	// required for meta data
	if (is_callable('xml_parser_create')) $xml = __('Yes', 'nggallery');
	else $xml = __('No', 'nggallery');
	
?>
	<li><?php _e('Operating System', 'nggallery'); ?> : <span><?php echo PHP_OS; ?>&nbsp;(<?php echo (PHP_INT_SIZE * 8) ?>&nbsp;Bit)</span></li>
	<li><?php _e('Server', 'nggallery'); ?> : <span><?php echo $_SERVER["SERVER_SOFTWARE"]; ?></span></li>
	<li><?php _e('Memory usage', 'nggallery'); ?> : <span><?php echo $memory_usage; ?></span></li>
	<li><?php _e('MYSQL Version', 'nggallery'); ?> : <span><?php echo $sqlversion; ?></span></li>
	<li><?php _e('SQL Mode', 'nggallery'); ?> : <span><?php echo $sql_mode; ?></span></li>
	<li><?php _e('PHP Version', 'nggallery'); ?> : <span><?php echo PHP_VERSION; ?></span></li>
	<li><?php _e('PHP Safe Mode', 'nggallery'); ?> : <span><?php echo $safe_mode; ?></span></li>
	<li><?php _e('PHP Allow URL fopen', 'nggallery'); ?> : <span><?php echo $allow_url_fopen; ?></span></li>
	<li><?php _e('PHP Memory Limit', 'nggallery'); ?> : <span><?php echo $memory_limit; ?></span></li>
	<li><?php _e('PHP Max Upload Size', 'nggallery'); ?> : <span><?php echo $upload_max; ?></span></li>
	<li><?php _e('PHP Max Post Size', 'nggallery'); ?> : <span><?php echo $post_max; ?></span></li>
	<li><?php _e('PCRE Backtracking Limit', 'nggallery'); ?> : <span><?php echo $backtrack_limit; ?></span></li>
	<li><?php _e('PHP Max Script Execute Time', 'nggallery'); ?> : <span><?php echo $max_execute; ?>s</span></li>
	<li><?php _e('PHP Exif support', 'nggallery'); ?> : <span><?php echo $exif; ?></span></li>
	<li><?php _e('PHP IPTC support', 'nggallery'); ?> : <span><?php echo $iptc; ?></span></li>
	<li><?php _e('PHP XML support', 'nggallery'); ?> : <span><?php echo $xml; ?></span></li>
<?php
}

/**
 * Inform about the end of PHP4
 * 
 * @return void
 */
function ngg_check_for_PHP5() {
    ?>
	<div class="updated">
		<p><?php _e('NextGEN Gallery contains some functions which are only available under PHP 5.2. You are using the old PHP 4 version, upgrade now! It\'s no longer supported by the PHP group. Many shared hosting providers offer both PHP 4 and PHP 5, running simultaneously. Ask your provider if they can do this.', 'nggallery'); ?></p>
	</div>
    <?php
}

/**
 * WPMU feature taken from Z-Space Upload Quotas
 * @author Dylan Reeve
 * @url http://dylan.wibble.net/
 *
 */
class ngg_SpaceManager {
 
 	function getQuota() {
		if (function_exists('get_space_allowed'))
			$quota = get_space_allowed();
		else
			$quota = get_site_option( "blog_upload_space" );
			
		return $quota;
	}
	 
	function details() {
		
		// take default seetings
		$settings = array(

			'remain'	=> array(
			'color_text'	=> 'white',
			'color_bar'		=> '#0D324F',
			'color_bg'		=> '#a0a0a0',
			'decimals'		=> 2,
			'unit'			=> 'm',
			'display'		=> true,
			'graph'			=> false
			),

			'used'		=> array(
			'color_text'	=> 'white',
			'color_bar'		=> '#0D324F',
			'color_bg'		=> '#a0a0a0',
			'decimals'		=> 2,
			'unit'			=> 'm',
			'display'		=> true,
			'graph'			=> true
			)
		);

		$quota = ngg_SpaceManager::getQuota() * 1024 * 1024;
		$used = get_dirsize( constant( 'ABSPATH' ) . constant( 'UPLOADS' ) );
//		$used = get_dirsize( ABSPATH."wp-content/blogs.dir/".$blog_id."/files" );
		
		if ($used > $quota) $percentused = '100';
		else $percentused = ( $used / $quota ) * 100;

		$remaining = $quota - $used;
		$percentremain = 100 - $percentused;

		$out = '';
		$out .= '<div id="spaceused"> <h3>'.__('Storage Space','nggallery').'</h3>';

		if ($settings['used']['display']) {
			$out .= __('Upload Space Used:','nggallery') . "\n";
			$out .= ngg_SpaceManager::buildGraph($settings['used'], $used,$quota,$percentused);
			$out .= "<br />";
		}

		if($settings['remain']['display']) {
			$out .= __('Upload Space Remaining:','nggallery') . "\n";
			$out .= ngg_SpaceManager::buildGraph($settings['remain'], $remaining,$quota,$percentremain);

		}

		$out .= "</div>";

		echo $out;
	}

	function buildGraph($settings, $size, $quota, $percent) {
		$color_bar = $settings['color_bar'];
		$color_bg = $settings['color_bg'];
		$color_text = $settings['color_text'];
		
		switch ($settings['unit']) {
			case "b":
				$unit = "B";
				break;
				
			case "k":
				$unit = "KB";
				$size = $size / 1024;
				$quota = $quota / 1024;
				break;
				
			case "g":   // Gigabytes, really?
				$unit = "GB";
				$size = $size / 1024 / 1024 / 1024;
				$quota = $quota / 1024 / 1024 / 1024;
				break;
				
			default:
				$unit = "MB";
				$size = $size / 1024 / 1024;
				$quota = $quota / 1024 / 1024;
				break;
		}

		$size = round($size, (int)$settings['decimals']);

		$pct = round(($size / $quota)*100);

		if ($settings['graph']) {
			//TODO:move style to CSS
			$out = '<div style="display: block; margin: 0; padding: 0; height: 15px; border: 1px inset; width: 100%; background-color: '.$color_bg.';">'."\n";
			$out .= '<div style="display: block; height: 15px; border: none; background-color: '.$color_bar.'; width: '.$pct.'%;">'."\n";
			$out .= '<div style="display: inline; position: relative; top: 0; left: 0; font-size: 10px; color: '.$color_text.'; font-weight: bold; padding-bottom: 2px; padding-left: 5px;">'."\n";
			$out .= $size.$unit;
			$out .= "</div>\n</div>\n</div>\n";
		} else {
			$out = "<strong>".$size.$unit." ( ".number_format($percent)."%)"."</strong><br />";
		}

		return $out;
	}

}

/**
 * ngg_get_phpinfo() - Extract all of the data from phpinfo into a nested array
 * 
 * @author jon@sitewizard.ca
 * @return array
 */
function ngg_get_phpinfo() {

	ob_start();
	phpinfo();
	$phpinfo = array('phpinfo' => array());
	
	if ( preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', ob_get_clean(), $matches, PREG_SET_ORDER) )
	    foreach($matches as $match) {
	        if(strlen($match[1]))
	            $phpinfo[$match[1]] = array();
	        elseif(isset($match[3]))
	            $phpinfo[end(array_keys($phpinfo))][$match[2]] = isset($match[4]) ? array($match[3], $match[4]) : $match[3];
	        else
	            $phpinfo[end(array_keys($phpinfo))][] = $match[2];
	    }
	    
	return $phpinfo;
}

/**
 * Show NextGEN Gallery related plugins. Fetch plugins from wp.org which have added 'nextgen-gallery' as tag in readme.txt
 * 
 * @return postbox output
 */
function ngg_widget_related_plugins() { 
    echo '<p class="widget-loading hide-if-no-js">' . __( 'Loading&#8230;' ) . '</p><p class="describe hide-if-js">' . __('This widget requires JavaScript.') . '</p>';
}  
function ngg_related_plugins() {
	include(ABSPATH . 'wp-admin/includes/plugin-install.php');

	// this api sucks , tags will not be used in the correct way : nextgen-gallery cannot be searched
	$api = plugins_api('query_plugins', array('search' => 'nextgen') );
	
	if ( is_wp_error($api) )
		return;
	
	// don't show my own plugin :-) and some other plugins, which come up with the search result
	$blacklist = array(
		'nextgen-gallery',
		'galleria-wp',
		'photosmash-galleries',
		'flash-album-gallery',
		'events-calendar',
		'widgets',
		'side-content',
		'featurific-for-wordpress',
		'smooth-gallery-replacement',
		'livesig',
		'wordpress-gallery-slideshow',
		'nkmimagefield',
		'nextgen-ajax'
	);
	
	$i = 0; 
	while ( $i < 4 ) {

		// pick them randomly	
		if ( 0 == count($api->plugins) )
			return;
			
		$key = array_rand($api->plugins);
		$plugin = $api->plugins[$key];

		// don't forget to remove them
		unset($api->plugins[$key]);
		
		if ( !isset($plugin->name) )
			continue;
			
		if ( in_array($plugin->slug , $blacklist ) ) 
			continue;

		$link   = esc_url( $plugin->homepage );
		$title  = esc_html( $plugin->name );
			
		$description = esc_html( strip_tags(@html_entity_decode($plugin->short_description, ENT_QUOTES, get_option('blog_charset'))) );
	
		$ilink = wp_nonce_url('plugin-install.php?tab=plugin-information&plugin=' . $plugin->slug, 'install-plugin_' . $plugin->slug) .
							'&amp;TB_iframe=true&amp;width=600&amp;height=800';
	
		echo "<h5><a href='$link'>$title</a></h5>&nbsp;<span>(<a href='$ilink' class='thickbox' title='$title'>" . __( 'Install' ) . "</a>)</span>\n";
		echo "<p>$description<strong> " . __( 'Author' ) . " : </strong>$plugin->author</p>\n";
		
		$i++;
	}

}
?>