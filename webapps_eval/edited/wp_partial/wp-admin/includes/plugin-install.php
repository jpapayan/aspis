<?php require_once('AspisMain.php'); ?><?php
function plugins_api ( $action,$args = null ) {
if ( is_array($args))
 $args = (object)$args;
if ( !isset($args->per_page))
 $args->per_page = 24;
$args = apply_filters('plugins_api_args',$args,$action);
$res = apply_filters('plugins_api',false,$action,$args);
if ( !$res)
 {$request = wp_remote_post('http://api.wordpress.org/plugins/info/1.0/',array('body' => array('action' => $action,'request' => serialize($args))));
if ( is_wp_error($request))
 {$res = new WP_Error('plugins_api_failed',__('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'),$request->get_error_message());
}else 
{{$res = AspisUntainted_unserialize($request['body']);
if ( !$res)
 $res = new WP_Error('plugins_api_failed',__('An unknown error occurred'),$request['body']);
}}}elseif ( !is_wp_error($res))
 {$res->external = true;
}{$AspisRetTemp = apply_filters('plugins_api_result',$res,$action,$args);
return $AspisRetTemp;
} }
function install_popular_tags ( $args = array() ) {
if ( !($cache = wp_cache_get('popular_tags','api')) && !($cache = get_option('wporg_popular_tags')))
 add_option('wporg_popular_tags',array(),'','no');
if ( $cache && $cache->timeout + 3 * 60 * 60 > time())
 {$AspisRetTemp = $cache->cached;
return $AspisRetTemp;
}$tags = plugins_api('hot_tags',$args);
if ( is_wp_error($tags))
 {$AspisRetTemp = $tags;
return $AspisRetTemp;
}$cache = (object)array('timeout' => time(),'cached' => $tags);
update_option('wporg_popular_tags',$cache);
wp_cache_set('popular_tags',$cache,'api');
{$AspisRetTemp = $tags;
return $AspisRetTemp;
} }
add_action('install_plugins_search','install_search',10,1);
function install_search ( $page ) {
$type = (isset($_REQUEST[0]['type']) && Aspis_isset($_REQUEST[0]['type'])) ? stripslashes(deAspisWarningRC($_REQUEST[0]['type'])) : '';
$term = (isset($_REQUEST[0]['s']) && Aspis_isset($_REQUEST[0]['s'])) ? stripslashes(deAspisWarningRC($_REQUEST[0]['s'])) : '';
$args = array();
switch ( $type ) {
case 'tag':$args['tag'] = sanitize_title_with_dashes($term);
break ;
case 'term':$args['search'] = $term;
break ;
case 'author':$args['author'] = $term;
break ;
 }
$args['page'] = $page;
$api = plugins_api('query_plugins',$args);
if ( is_wp_error($api))
 wp_die($api);
add_action('install_plugins_table_header','install_search_form');
display_plugins_table($api->plugins,$api->info['page'],$api->info['pages']);
{return ;
} }
add_action('install_plugins_dashboard','install_dashboard');
function install_dashboard (  ) {
;
?>
	<p><?php _e('Plugins extend and expand the functionality of WordPress. You may automatically install plugins from the <a href="http://wordpress.org/extend/plugins/">WordPress Plugin Directory</a> or upload a plugin in .zip format via this page.');
?></p>

	<h4><?php _e('Search');
?></h4>
	<p class="install-help"><?php _e('Search for plugins by keyword, author, or tag.');
?></p>
	<?php install_search_form();
;
?>

	<h4><?php _e('Popular tags');
?></h4>
	<p class="install-help"><?php _e('You may also browse based on the most popular tags in the Plugin Directory:');
?></p>
	<?php $api_tags = install_popular_tags();
$tags = array();
foreach ( (array)$api_tags as $tag  )
$tags[$tag['name']] = (object)array('link' => esc_url(admin_url('plugin-install.php?tab=search&type=tag&s=' . urlencode($tag['name']))),'name' => $tag['name'],'id' => sanitize_title_with_dashes($tag['name']),'count' => $tag['count']);
echo '<p class="popular-tags">';
echo wp_generate_tag_cloud($tags,array('single_text' => __('%d plugin'),'multiple_text' => __('%d plugins')));
echo '</p><br class="clear" />';
 }
function install_search_form (  ) {
$type = (isset($_REQUEST[0]['type']) && Aspis_isset($_REQUEST[0]['type'])) ? stripslashes(deAspisWarningRC($_REQUEST[0]['type'])) : '';
$term = (isset($_REQUEST[0]['s']) && Aspis_isset($_REQUEST[0]['s'])) ? stripslashes(deAspisWarningRC($_REQUEST[0]['s'])) : '';
;
?><form id="search-plugins" method="post" action="<?php echo admin_url('plugin-install.php?tab=search');
;
?>">
		<select name="type" id="typeselector">
			<option value="term"<?php selected('term',$type);
?>><?php _e('Term');
;
?></option>
			<option value="author"<?php selected('author',$type);
?>><?php _e('Author');
;
?></option>
			<option value="tag"<?php selected('tag',$type);
?>><?php echo _x('Tag','Plugin Installer');
;
?></option>
		</select>
		<input type="text" name="s" value="<?php echo esc_attr($term);
?>" />
		<label class="screen-reader-text" for="plugin-search-input"><?php _e('Search Plugins');
;
?></label>
		<input type="submit" id="plugin-search-input" name="search" value="<?php esc_attr_e('Search Plugins');
;
?>" class="button" />
	</form><?php  }
add_action('install_plugins_featured','install_featured',10,1);
function install_featured ( $page = 1 ) {
$args = array('browse' => 'featured','page' => $page);
$api = plugins_api('query_plugins',$args);
if ( is_wp_error($api))
 wp_die($api);
display_plugins_table($api->plugins,$api->info['page'],$api->info['pages']);
 }
add_action('install_plugins_popular','install_popular',10,1);
function install_popular ( $page = 1 ) {
$args = array('browse' => 'popular','page' => $page);
$api = plugins_api('query_plugins',$args);
display_plugins_table($api->plugins,$api->info['page'],$api->info['pages']);
 }
add_action('install_plugins_upload','install_plugins_upload',10,1);
function install_plugins_upload ( $page = 1 ) {
;
?>
	<h4><?php _e('Install a plugin in .zip format');
?></h4>
	<p class="install-help"><?php _e('If you have a plugin in a .zip format, You may install it by uploading it here.');
?></p>
	<form method="post" enctype="multipart/form-data" action="<?php echo admin_url('update.php?action=upload-plugin');
?>">
		<?php wp_nonce_field('plugin-upload');
?>
		<label class="screen-reader-text" for="pluginzip"><?php _e('Plugin zip file');
;
?></label>
		<input type="file" id="pluginzip" name="pluginzip" />
		<input type="submit" class="button" value="<?php esc_attr_e('Install Now');
?>" />
	</form>
<?php  }
add_action('install_plugins_new','install_new',10,1);
function install_new ( $page = 1 ) {
$args = array('browse' => 'new','page' => $page);
$api = plugins_api('query_plugins',$args);
if ( is_wp_error($api))
 wp_die($api);
display_plugins_table($api->plugins,$api->info['page'],$api->info['pages']);
 }
add_action('install_plugins_updated','install_updated',10,1);
function install_updated ( $page = 1 ) {
$args = array('browse' => 'updated','page' => $page);
$api = plugins_api('query_plugins',$args);
display_plugins_table($api->plugins,$api->info['page'],$api->info['pages']);
 }
function display_plugins_table ( $plugins,$page = 1,$totalpages = 1 ) {
$type = (isset($_REQUEST[0]['type']) && Aspis_isset($_REQUEST[0]['type'])) ? stripslashes(deAspisWarningRC($_REQUEST[0]['type'])) : '';
$term = (isset($_REQUEST[0]['s']) && Aspis_isset($_REQUEST[0]['s'])) ? stripslashes(deAspisWarningRC($_REQUEST[0]['s'])) : '';
$plugins_allowedtags = array('a' => array('href' => array(),'title' => array(),'target' => array()),'abbr' => array('title' => array()),'acronym' => array('title' => array()),'code' => array(),'pre' => array(),'em' => array(),'strong' => array(),'ul' => array(),'ol' => array(),'li' => array(),'p' => array(),'br' => array());
;
?>
	<div class="tablenav">
		<div class="alignleft actions">
		<?php do_action('install_plugins_table_header');
;
?>
		</div>
		<?php $url = esc_url(deAspisWarningRC($_SERVER[0]['REQUEST_URI']));
if ( !empty($term))
 $url = add_query_arg('s',$term,$url);
if ( !empty($type))
 $url = add_query_arg('type',$type,$url);
$page_links = paginate_links(array('base' => add_query_arg('paged','%#%',$url),'format' => '','prev_text' => __('&laquo;'),'next_text' => __('&raquo;'),'total' => $totalpages,'current' => $page));
if ( $page_links)
 echo "\t\t<div class='tablenav-pages'>$page_links</div>";
;
?>
		<br class="clear" />
	</div>
	<table class="widefat" id="install-plugins" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="name"><?php _e('Name');
;
?></th>
				<th scope="col" class="num"><?php _e('Version');
;
?></th>
				<th scope="col" class="num"><?php _e('Rating');
;
?></th>
				<th scope="col" class="desc"><?php _e('Description');
;
?></th>
				<th scope="col" class="action-links"><?php _e('Actions');
;
?></th>
			</tr>
		</thead>

		<tfoot>
			<tr>
				<th scope="col" class="name"><?php _e('Name');
;
?></th>
				<th scope="col" class="num"><?php _e('Version');
;
?></th>
				<th scope="col" class="num"><?php _e('Rating');
;
?></th>
				<th scope="col" class="desc"><?php _e('Description');
;
?></th>
				<th scope="col" class="action-links"><?php _e('Actions');
;
?></th>
			</tr>
		</tfoot>

		<tbody class="plugins">
		<?php if ( empty($plugins))
 echo '<tr><td colspan="5">',__('No plugins match your request.'),'</td></tr>';
foreach ( (array)$plugins as $plugin  )
{if ( is_object($plugin))
 $plugin = (array)$plugin;
$title = wp_kses($plugin['name'],$plugins_allowedtags);
$description = strip_tags($plugin['description']);
if ( strlen($description) > 400)
 $description = mb_substr($description,0,400) . '&#8230;';
$description = preg_replace('/&[^;\s]{0,6}$/','',$description);
$description = trim($description);
$description = preg_replace("|(\r?\n)+|","\n",$description);
$description = nl2br($description);
$version = wp_kses($plugin['version'],$plugins_allowedtags);
$name = strip_tags($title . ' ' . $version);
$author = $plugin['author'];
if ( !empty($plugin['author']))
 $author = ' <cite>' . sprintf(__('By %s'),$author) . '.</cite>';
$author = wp_kses($author,$plugins_allowedtags);
if ( isset($plugin['homepage']))
 $title = '<a target="_blank" href="' . esc_attr($plugin['homepage']) . '">' . $title . '</a>';
$action_links = array();
$action_links[] = '<a href="' . admin_url('plugin-install.php?tab=plugin-information&amp;plugin=' . $plugin['slug'] . '&amp;TB_iframe=true&amp;width=600&amp;height=550') . '" class="thickbox onclick" title="' . esc_attr($name) . '">' . __('Install') . '</a>';
$action_links = apply_filters('plugin_install_action_links',$action_links,$plugin);
;
?>
			<tr>
				<td class="name"><?php echo $title;
;
?></td>
				<td class="vers"><?php echo $version;
;
?></td>
				<td class="vers">
					<div class="star-holder" title="<?php printf(_n('(based on %s rating)','(based on %s ratings)',$plugin['num_ratings']),number_format_i18n($plugin['num_ratings']));
?>">
						<div class="star star-rating" style="width: <?php echo esc_attr($plugin['rating']);
?>px"></div>
						<div class="star star5"><img src="<?php echo admin_url('images/star.gif');
;
?>" alt="<?php _e('5 stars');
?>" /></div>
						<div class="star star4"><img src="<?php echo admin_url('images/star.gif');
;
?>" alt="<?php _e('4 stars');
?>" /></div>
						<div class="star star3"><img src="<?php echo admin_url('images/star.gif');
;
?>" alt="<?php _e('3 stars');
?>" /></div>
						<div class="star star2"><img src="<?php echo admin_url('images/star.gif');
;
?>" alt="<?php _e('2 stars');
?>" /></div>
						<div class="star star1"><img src="<?php echo admin_url('images/star.gif');
;
?>" alt="<?php _e('1 star');
?>" /></div>
					</div>
				</td>
				<td class="desc"><?php echo $description,$author;
;
?></td>
				<td class="action-links"><?php if ( !empty($action_links))
 echo implode(' | ',$action_links);
;
?></td>
			</tr>
			<?php };
?>
		</tbody>
	</table>

	<div class="tablenav">
		<?php if ( $page_links)
 echo "\t\t<div class='tablenav-pages'>$page_links</div>";
;
?>
		<br class="clear" />
	</div>

<?php  }
add_action('install_plugins_pre_plugin-information','install_plugin_information');
function install_plugin_information (  ) {
{global $tab;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $tab,"\$tab",$AspisChangesCache);
}$api = plugins_api('plugin_information',array('slug' => stripslashes(deAspisWarningRC($_REQUEST[0]['plugin']))));
if ( is_wp_error($api))
 wp_die($api);
$plugins_allowedtags = array('a' => array('href' => array(),'title' => array(),'target' => array()),'abbr' => array('title' => array()),'acronym' => array('title' => array()),'code' => array(),'pre' => array(),'em' => array(),'strong' => array(),'div' => array(),'p' => array(),'ul' => array(),'ol' => array(),'li' => array(),'h1' => array(),'h2' => array(),'h3' => array(),'h4' => array(),'h5' => array(),'h6' => array(),'img' => array('src' => array(),'class' => array(),'alt' => array()));
foreach ( (array)$api->sections as $section_name =>$content )
$api->sections[$section_name] = wp_kses($content,$plugins_allowedtags);
foreach ( array('version','author','requires','tested','homepage','downloaded','slug') as $key  )
$api->$key = wp_kses($api->$key,$plugins_allowedtags);
$section = (isset($_REQUEST[0]['section']) && Aspis_isset($_REQUEST[0]['section'])) ? stripslashes(deAspisWarningRC($_REQUEST[0]['section'])) : 'description';
if ( empty($section) || !isset($api->sections[$section]))
 $section = array_shift($section_titles = array_keys((array)$api->sections));
iframe_header(__('Plugin Install'));
echo "<div id='$tab-header'>\n";
echo "<ul id='sidemenu'>\n";
foreach ( (array)$api->sections as $section_name =>$content )
{$title = $section_name;
$title = ucwords(str_replace('_',' ',$title));
$class = ($section_name == $section) ? ' class="current"' : '';
$href = add_query_arg(array('tab' => $tab,'section' => $section_name));
$href = esc_url($href);
$san_title = esc_attr(sanitize_title_with_dashes($title));
echo "\t<li><a name='$san_title' target='' href='$href'$class>$title</a></li>\n";
}echo "</ul>\n";
echo "</div>\n";
;
?>
	<div class="alignright fyi">
		<?php if ( !empty($api->download_link))
 {;
?>
		<p class="action-button">
		<?php $type = 'install';
$update_plugins = get_transient('update_plugins');
if ( is_object($update_plugins))
 {foreach ( (array)$update_plugins->response as $file =>$plugin )
{if ( $plugin->slug === $api->slug)
 {$type = 'update_available';
$update_file = $file;
break ;
}}}if ( 'install' == $type && is_dir(WP_PLUGIN_DIR . '/' . $api->slug))
 {$installed_plugin = get_plugins('/' . $api->slug);
if ( !empty($installed_plugin))
 {$key = array_shift($key = array_keys($installed_plugin));
if ( version_compare($api->version,$installed_plugin[$key]['Version'],'='))
 {$type = 'latest_installed';
}elseif ( version_compare($api->version,$installed_plugin[$key]['Version'],'<'))
 {$type = 'newer_installed';
$newer_version = $installed_plugin[$key]['Version'];
}else 
{{delete_transient('update_plugins');
$update_file = $api->slug . '/' . $key;
$type = 'update_available';
}}}}switch ( $type ) {
default :;
case 'install':if ( current_user_can('install_plugins'))
 {;
?><a href="<?php echo wp_nonce_url(admin_url('update.php?action=install-plugin&plugin=' . $api->slug),'install-plugin_' . $api->slug);
?>" target="_parent"><?php _e('Install Now');
?></a><?php }break ;
case 'update_available':if ( current_user_can('update_plugins'))
 {;
?><a href="<?php echo wp_nonce_url(admin_url('update.php?action=upgrade-plugin&plugin=' . $update_file),'upgrade-plugin_' . $update_file);
?>" target="_parent"><?php _e('Install Update Now');
?></a><?php }break ;
case 'newer_installed':if ( current_user_can('install_plugins') || current_user_can('update_plugins'))
 {;
?><a><?php printf(__('Newer Version (%s) Installed'),$newer_version);
?></a><?php }break ;
case 'latest_installed':if ( current_user_can('install_plugins') || current_user_can('update_plugins'))
 {;
?><a><?php _e('Latest Version Installed');
?></a><?php }break ;
 }
;
?>
		</p>
		<?php };
?>
		<h2 class="mainheader"><?php _e('FYI');
?></h2>
		<ul>
<?php if ( !empty($api->version))
 {;
?>
			<li><strong><?php _e('Version:');
?></strong> <?php echo $api->version;
?></li>
<?php }if ( !empty($api->author))
 {;
?>
			<li><strong><?php _e('Author:');
?></strong> <?php echo links_add_target($api->author,'_blank');
?></li>
<?php }if ( !empty($api->last_updated))
 {;
?>
			<li><strong><?php _e('Last Updated:');
?></strong> <span title="<?php echo $api->last_updated;
?>"><?php printf(__('%s ago'),human_time_diff(strtotime($api->last_updated)));
?></span></li>
<?php }if ( !empty($api->requires))
 {;
?>
			<li><strong><?php _e('Requires WordPress Version:');
?></strong> <?php printf(__('%s or higher'),$api->requires);
?></li>
<?php }if ( !empty($api->tested))
 {;
?>
			<li><strong><?php _e('Compatible up to:');
?></strong> <?php echo $api->tested;
?></li>
<?php }if ( !empty($api->downloaded))
 {;
?>
			<li><strong><?php _e('Downloaded:');
?></strong> <?php printf(_n('%s time','%s times',$api->downloaded),number_format_i18n($api->downloaded));
?></li>
<?php }if ( !empty($api->slug) && empty($api->external))
 {;
?>
			<li><a target="_blank" href="http://wordpress.org/extend/plugins/<?php echo $api->slug;
?>/"><?php _e('WordPress.org Plugin Page &#187;');
?></a></li>
<?php }if ( !empty($api->homepage))
 {;
?>
			<li><a target="_blank" href="<?php echo $api->homepage;
?>"><?php _e('Plugin Homepage  &#187;');
?></a></li>
<?php };
?>
		</ul>
		<?php if ( !empty($api->rating))
 {;
?>
		<h2><?php _e('Average Rating');
?></h2>
		<div class="star-holder" title="<?php printf(_n('(based on %s rating)','(based on %s ratings)',$api->num_ratings),number_format_i18n($api->num_ratings));
;
?>">
			<div class="star star-rating" style="width: <?php echo esc_attr($api->rating);
?>px"></div>
			<div class="star star5"><img src="<?php echo admin_url('images/star.gif');
;
?>" alt="<?php _e('5 stars');
?>" /></div>
			<div class="star star4"><img src="<?php echo admin_url('images/star.gif');
;
?>" alt="<?php _e('4 stars');
?>" /></div>
			<div class="star star3"><img src="<?php echo admin_url('images/star.gif');
;
?>" alt="<?php _e('3 stars');
?>" /></div>
			<div class="star star2"><img src="<?php echo admin_url('images/star.gif');
;
?>" alt="<?php _e('2 stars');
?>" /></div>
			<div class="star star1"><img src="<?php echo admin_url('images/star.gif');
;
?>" alt="<?php _e('1 star');
?>" /></div>
		</div>
		<small><?php printf(_n('(based on %s rating)','(based on %s ratings)',$api->num_ratings),number_format_i18n($api->num_ratings));
;
?></small>
		<?php };
?>
	</div>
	<div id="section-holder" class="wrap">
	<?php if ( !empty($api->tested) && version_compare(substr($GLOBALS[0]['wp_version'],0,strlen($api->tested)),$api->tested,'>'))
 echo '<div class="updated"><p>' . __('<strong>Warning:</strong> This plugin has <strong>not been tested</strong> with your current version of WordPress.') . '</p></div>';
else 
{if ( !empty($api->requires) && version_compare(substr($GLOBALS[0]['wp_version'],0,strlen($api->requires)),$api->requires,'<'))
 echo '<div class="updated"><p>' . __('<strong>Warning:</strong> This plugin has <strong>not been marked as compatible</strong> with your version of WordPress.') . '</p></div>';
}foreach ( (array)$api->sections as $section_name =>$content )
{$title = $section_name;
$title[0] = strtoupper($title[0]);
$title = str_replace('_',' ',$title);
$content = links_add_base_url($content,'http://wordpress.org/extend/plugins/' . $api->slug . '/');
$content = links_add_target($content,'_blank');
$san_title = esc_attr(sanitize_title_with_dashes($title));
$display = ($section_name == $section) ? 'block' : 'none';
echo "\t<div id='section-{$san_title}' class='section' style='display: {$display};'>\n";
echo "\t\t<h2 class='long-header'>$title</h2>";
echo $content;
echo "\t</div>\n";
}echo "</div>\n";
iframe_footer();
exit();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$tab",$AspisChangesCache);
 }
