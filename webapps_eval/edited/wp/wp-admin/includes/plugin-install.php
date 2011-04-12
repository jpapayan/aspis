<?php require_once('AspisMain.php'); ?><?php
function plugins_api ( $action,$args = array(null,false) ) {
if ( is_array($args[0]))
 $args = object_cast($args);
if ( (!((isset($args[0]->per_page) && Aspis_isset( $args[0] ->per_page )))))
 $args[0]->per_page = array(24,false);
$args = apply_filters(array('plugins_api_args',false),$args,$action);
$res = apply_filters(array('plugins_api',false),array(false,false),$action,$args);
if ( (denot_boolean($res)))
 {$request = wp_remote_post(array('http://api.wordpress.org/plugins/info/1.0/',false),array(array('body' => array(array(deregisterTaint(array('action',false)) => addTaint($action),deregisterTaint(array('request',false)) => addTaint(Aspis_serialize($args))),false,false)),false));
if ( deAspis(is_wp_error($request)))
 {$res = array(new WP_Error(array('plugins_api_failed',false),__(array('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>',false)),$request[0]->get_error_message()),false);
}else 
{{$res = Aspis_unserialize($request[0]['body']);
if ( (denot_boolean($res)))
 $res = array(new WP_Error(array('plugins_api_failed',false),__(array('An unknown error occurred',false)),$request[0]['body']),false);
}}}elseif ( (denot_boolean(is_wp_error($res))))
 {$res[0]->external = array(true,false);
}return apply_filters(array('plugins_api_result',false),$res,$action,$args);
 }
function install_popular_tags ( $args = array(array(),false) ) {
if ( ((denot_boolean(($cache = wp_cache_get(array('popular_tags',false),array('api',false))))) && (denot_boolean(($cache = get_option(array('wporg_popular_tags',false)))))))
 add_option(array('wporg_popular_tags',false),array(array(),false),array('',false),array('no',false));
if ( ($cache[0] && (($cache[0]->timeout[0] + (((3) * (60)) * (60))) > time())))
 return $cache[0]->cached;
$tags = plugins_api(array('hot_tags',false),$args);
if ( deAspis(is_wp_error($tags)))
 return $tags;
$cache = object_cast(array(array(deregisterTaint(array('timeout',false)) => addTaint(attAspis(time())),deregisterTaint(array('cached',false)) => addTaint($tags)),false));
update_option(array('wporg_popular_tags',false),$cache);
wp_cache_set(array('popular_tags',false),$cache,array('api',false));
return $tags;
 }
add_action(array('install_plugins_search',false),array('install_search',false),array(10,false),array(1,false));
function install_search ( $page ) {
$type = ((isset($_REQUEST[0][('type')]) && Aspis_isset( $_REQUEST [0][('type')]))) ? Aspis_stripslashes($_REQUEST[0]['type']) : array('',false);
$term = ((isset($_REQUEST[0][('s')]) && Aspis_isset( $_REQUEST [0][('s')]))) ? Aspis_stripslashes($_REQUEST[0]['s']) : array('',false);
$args = array(array(),false);
switch ( $type[0] ) {
case ('tag'):arrayAssign($args[0],deAspis(registerTaint(array('tag',false))),addTaint(sanitize_title_with_dashes($term)));
break ;
case ('term'):arrayAssign($args[0],deAspis(registerTaint(array('search',false))),addTaint($term));
break ;
case ('author'):arrayAssign($args[0],deAspis(registerTaint(array('author',false))),addTaint($term));
break ;
 }
arrayAssign($args[0],deAspis(registerTaint(array('page',false))),addTaint($page));
$api = plugins_api(array('query_plugins',false),$args);
if ( deAspis(is_wp_error($api)))
 wp_die($api);
add_action(array('install_plugins_table_header',false),array('install_search_form',false));
display_plugins_table($api[0]->plugins,$api[0]->info[0][('page')],$api[0]->info[0][('pages')]);
return ;
 }
add_action(array('install_plugins_dashboard',false),array('install_dashboard',false));
function install_dashboard (  ) {
;
?>
	<p><?php _e(array('Plugins extend and expand the functionality of WordPress. You may automatically install plugins from the <a href="http://wordpress.org/extend/plugins/">WordPress Plugin Directory</a> or upload a plugin in .zip format via this page.',false));
?></p>

	<h4><?php _e(array('Search',false));
?></h4>
	<p class="install-help"><?php _e(array('Search for plugins by keyword, author, or tag.',false));
?></p>
	<?php install_search_form();
;
?>

	<h4><?php _e(array('Popular tags',false));
?></h4>
	<p class="install-help"><?php _e(array('You may also browse based on the most popular tags in the Plugin Directory:',false));
?></p>
	<?php $api_tags = install_popular_tags();
$tags = array(array(),false);
foreach ( deAspis(array_cast($api_tags)) as $tag  )
arrayAssign($tags[0],deAspis(registerTaint($tag[0]['name'])),addTaint(object_cast(array(array(deregisterTaint(array('link',false)) => addTaint(esc_url(admin_url(concat1('plugin-install.php?tab=search&type=tag&s=',Aspis_urlencode($tag[0]['name']))))),deregisterTaint(array('name',false)) => addTaint($tag[0]['name']),deregisterTaint(array('id',false)) => addTaint(sanitize_title_with_dashes($tag[0]['name'])),deregisterTaint(array('count',false)) => addTaint($tag[0]['count'])),false))));
echo AspisCheckPrint(array('<p class="popular-tags">',false));
echo AspisCheckPrint(wp_generate_tag_cloud($tags,array(array(deregisterTaint(array('single_text',false)) => addTaint(__(array('%d plugin',false))),deregisterTaint(array('multiple_text',false)) => addTaint(__(array('%d plugins',false)))),false)));
echo AspisCheckPrint(array('</p><br class="clear" />',false));
 }
function install_search_form (  ) {
$type = ((isset($_REQUEST[0][('type')]) && Aspis_isset( $_REQUEST [0][('type')]))) ? Aspis_stripslashes($_REQUEST[0]['type']) : array('',false);
$term = ((isset($_REQUEST[0][('s')]) && Aspis_isset( $_REQUEST [0][('s')]))) ? Aspis_stripslashes($_REQUEST[0]['s']) : array('',false);
;
?><form id="search-plugins" method="post" action="<?php echo AspisCheckPrint(admin_url(array('plugin-install.php?tab=search',false)));
;
?>">
		<select name="type" id="typeselector">
			<option value="term"<?php selected(array('term',false),$type);
?>><?php _e(array('Term',false));
;
?></option>
			<option value="author"<?php selected(array('author',false),$type);
?>><?php _e(array('Author',false));
;
?></option>
			<option value="tag"<?php selected(array('tag',false),$type);
?>><?php echo AspisCheckPrint(_x(array('Tag',false),array('Plugin Installer',false)));
;
?></option>
		</select>
		<input type="text" name="s" value="<?php echo AspisCheckPrint(esc_attr($term));
?>" />
		<label class="screen-reader-text" for="plugin-search-input"><?php _e(array('Search Plugins',false));
;
?></label>
		<input type="submit" id="plugin-search-input" name="search" value="<?php esc_attr_e(array('Search Plugins',false));
;
?>" class="button" />
	</form><?php  }
add_action(array('install_plugins_featured',false),array('install_featured',false),array(10,false),array(1,false));
function install_featured ( $page = array(1,false) ) {
$args = array(array('browse' => array('featured',false,false),deregisterTaint(array('page',false)) => addTaint($page)),false);
$api = plugins_api(array('query_plugins',false),$args);
if ( deAspis(is_wp_error($api)))
 wp_die($api);
display_plugins_table($api[0]->plugins,$api[0]->info[0][('page')],$api[0]->info[0][('pages')]);
 }
add_action(array('install_plugins_popular',false),array('install_popular',false),array(10,false),array(1,false));
function install_popular ( $page = array(1,false) ) {
$args = array(array('browse' => array('popular',false,false),deregisterTaint(array('page',false)) => addTaint($page)),false);
$api = plugins_api(array('query_plugins',false),$args);
display_plugins_table($api[0]->plugins,$api[0]->info[0][('page')],$api[0]->info[0][('pages')]);
 }
add_action(array('install_plugins_upload',false),array('install_plugins_upload',false),array(10,false),array(1,false));
function install_plugins_upload ( $page = array(1,false) ) {
;
?>
	<h4><?php _e(array('Install a plugin in .zip format',false));
?></h4>
	<p class="install-help"><?php _e(array('If you have a plugin in a .zip format, You may install it by uploading it here.',false));
?></p>
	<form method="post" enctype="multipart/form-data" action="<?php echo AspisCheckPrint(admin_url(array('update.php?action=upload-plugin',false)));
?>">
		<?php wp_nonce_field(array('plugin-upload',false));
?>
		<label class="screen-reader-text" for="pluginzip"><?php _e(array('Plugin zip file',false));
;
?></label>
		<input type="file" id="pluginzip" name="pluginzip" />
		<input type="submit" class="button" value="<?php esc_attr_e(array('Install Now',false));
?>" />
	</form>
<?php  }
add_action(array('install_plugins_new',false),array('install_new',false),array(10,false),array(1,false));
function install_new ( $page = array(1,false) ) {
$args = array(array('browse' => array('new',false,false),deregisterTaint(array('page',false)) => addTaint($page)),false);
$api = plugins_api(array('query_plugins',false),$args);
if ( deAspis(is_wp_error($api)))
 wp_die($api);
display_plugins_table($api[0]->plugins,$api[0]->info[0][('page')],$api[0]->info[0][('pages')]);
 }
add_action(array('install_plugins_updated',false),array('install_updated',false),array(10,false),array(1,false));
function install_updated ( $page = array(1,false) ) {
$args = array(array('browse' => array('updated',false,false),deregisterTaint(array('page',false)) => addTaint($page)),false);
$api = plugins_api(array('query_plugins',false),$args);
display_plugins_table($api[0]->plugins,$api[0]->info[0][('page')],$api[0]->info[0][('pages')]);
 }
function display_plugins_table ( $plugins,$page = array(1,false),$totalpages = array(1,false) ) {
$type = ((isset($_REQUEST[0][('type')]) && Aspis_isset( $_REQUEST [0][('type')]))) ? Aspis_stripslashes($_REQUEST[0]['type']) : array('',false);
$term = ((isset($_REQUEST[0][('s')]) && Aspis_isset( $_REQUEST [0][('s')]))) ? Aspis_stripslashes($_REQUEST[0]['s']) : array('',false);
$plugins_allowedtags = array(array('a' => array(array('href' => array(array(),false,false),'title' => array(array(),false,false),'target' => array(array(),false,false)),false,false),'abbr' => array(array('title' => array(array(),false,false)),false,false),'acronym' => array(array('title' => array(array(),false,false)),false,false),'code' => array(array(),false,false),'pre' => array(array(),false,false),'em' => array(array(),false,false),'strong' => array(array(),false,false),'ul' => array(array(),false,false),'ol' => array(array(),false,false),'li' => array(array(),false,false),'p' => array(array(),false,false),'br' => array(array(),false,false)),false);
;
?>
	<div class="tablenav">
		<div class="alignleft actions">
		<?php do_action(array('install_plugins_table_header',false));
;
?>
		</div>
		<?php $url = esc_url($_SERVER[0]['REQUEST_URI']);
if ( (!((empty($term) || Aspis_empty( $term)))))
 $url = add_query_arg(array('s',false),$term,$url);
if ( (!((empty($type) || Aspis_empty( $type)))))
 $url = add_query_arg(array('type',false),$type,$url);
$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('paged',false),array('%#%',false),$url)),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint($totalpages),deregisterTaint(array('current',false)) => addTaint($page)),false));
if ( $page_links[0])
 echo AspisCheckPrint(concat2(concat1("\t\t<div class='tablenav-pages'>",$page_links),"</div>"));
;
?>
		<br class="clear" />
	</div>
	<table class="widefat" id="install-plugins" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="name"><?php _e(array('Name',false));
;
?></th>
				<th scope="col" class="num"><?php _e(array('Version',false));
;
?></th>
				<th scope="col" class="num"><?php _e(array('Rating',false));
;
?></th>
				<th scope="col" class="desc"><?php _e(array('Description',false));
;
?></th>
				<th scope="col" class="action-links"><?php _e(array('Actions',false));
;
?></th>
			</tr>
		</thead>

		<tfoot>
			<tr>
				<th scope="col" class="name"><?php _e(array('Name',false));
;
?></th>
				<th scope="col" class="num"><?php _e(array('Version',false));
;
?></th>
				<th scope="col" class="num"><?php _e(array('Rating',false));
;
?></th>
				<th scope="col" class="desc"><?php _e(array('Description',false));
;
?></th>
				<th scope="col" class="action-links"><?php _e(array('Actions',false));
;
?></th>
			</tr>
		</tfoot>

		<tbody class="plugins">
		<?php if ( ((empty($plugins) || Aspis_empty( $plugins))))
 echo AspisCheckPrint(array('<tr><td colspan="5">',false)),AspisCheckPrint(__(array('No plugins match your request.',false))),AspisCheckPrint(array('</td></tr>',false));
foreach ( deAspis(array_cast($plugins)) as $plugin  )
{if ( is_object($plugin[0]))
 $plugin = array_cast($plugin);
$title = wp_kses($plugin[0]['name'],$plugins_allowedtags);
$description = Aspis_strip_tags($plugin[0]['description']);
if ( (strlen($description[0]) > (400)))
 $description = concat12(mb_substr(deAspisRC($description),0,400),'&#8230;');
$description = Aspis_preg_replace(array('/&[^;\s]{0,6}$/',false),array('',false),$description);
$description = Aspis_trim($description);
$description = Aspis_preg_replace(array("|(\r?\n)+|",false),array("\n",false),$description);
$description = Aspis_nl2br($description);
$version = wp_kses($plugin[0]['version'],$plugins_allowedtags);
$name = Aspis_strip_tags(concat(concat2($title,' '),$version));
$author = $plugin[0]['author'];
if ( (!((empty($plugin[0][('author')]) || Aspis_empty( $plugin [0][('author')])))))
 $author = concat2(concat1(' <cite>',Aspis_sprintf(__(array('By %s',false)),$author)),'.</cite>');
$author = wp_kses($author,$plugins_allowedtags);
if ( ((isset($plugin[0][('homepage')]) && Aspis_isset( $plugin [0][('homepage')]))))
 $title = concat2(concat(concat2(concat1('<a target="_blank" href="',esc_attr($plugin[0]['homepage'])),'">'),$title),'</a>');
$action_links = array(array(),false);
arrayAssignAdd($action_links[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',admin_url(concat2(concat1('plugin-install.php?tab=plugin-information&amp;plugin=',$plugin[0]['slug']),'&amp;TB_iframe=true&amp;width=600&amp;height=550'))),'" class="thickbox onclick" title="'),esc_attr($name)),'">'),__(array('Install',false))),'</a>')));
$action_links = apply_filters(array('plugin_install_action_links',false),$action_links,$plugin);
;
?>
			<tr>
				<td class="name"><?php echo AspisCheckPrint($title);
;
?></td>
				<td class="vers"><?php echo AspisCheckPrint($version);
;
?></td>
				<td class="vers">
					<div class="star-holder" title="<?php printf(deAspis(_n(array('(based on %s rating)',false),array('(based on %s ratings)',false),$plugin[0]['num_ratings'])),deAspisRC(number_format_i18n($plugin[0]['num_ratings'])));
?>">
						<div class="star star-rating" style="width: <?php echo AspisCheckPrint(esc_attr($plugin[0]['rating']));
?>px"></div>
						<div class="star star5"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('5 stars',false));
?>" /></div>
						<div class="star star4"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('4 stars',false));
?>" /></div>
						<div class="star star3"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('3 stars',false));
?>" /></div>
						<div class="star star2"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('2 stars',false));
?>" /></div>
						<div class="star star1"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('1 star',false));
?>" /></div>
					</div>
				</td>
				<td class="desc"><?php echo AspisCheckPrint($description),AspisCheckPrint($author);
;
?></td>
				<td class="action-links"><?php if ( (!((empty($action_links) || Aspis_empty( $action_links)))))
 echo AspisCheckPrint(Aspis_implode(array(' | ',false),$action_links));
;
?></td>
			</tr>
			<?php };
?>
		</tbody>
	</table>

	<div class="tablenav">
		<?php if ( $page_links[0])
 echo AspisCheckPrint(concat2(concat1("\t\t<div class='tablenav-pages'>",$page_links),"</div>"));
;
?>
		<br class="clear" />
	</div>

<?php  }
add_action(array('install_plugins_pre_plugin-information',false),array('install_plugin_information',false));
function install_plugin_information (  ) {
global $tab;
$api = plugins_api(array('plugin_information',false),array(array(deregisterTaint(array('slug',false)) => addTaint(Aspis_stripslashes($_REQUEST[0]['plugin']))),false));
if ( deAspis(is_wp_error($api)))
 wp_die($api);
$plugins_allowedtags = array(array('a' => array(array('href' => array(array(),false,false),'title' => array(array(),false,false),'target' => array(array(),false,false)),false,false),'abbr' => array(array('title' => array(array(),false,false)),false,false),'acronym' => array(array('title' => array(array(),false,false)),false,false),'code' => array(array(),false,false),'pre' => array(array(),false,false),'em' => array(array(),false,false),'strong' => array(array(),false,false),'div' => array(array(),false,false),'p' => array(array(),false,false),'ul' => array(array(),false,false),'ol' => array(array(),false,false),'li' => array(array(),false,false),'h1' => array(array(),false,false),'h2' => array(array(),false,false),'h3' => array(array(),false,false),'h4' => array(array(),false,false),'h5' => array(array(),false,false),'h6' => array(array(),false,false),'img' => array(array('src' => array(array(),false,false),'class' => array(array(),false,false),'alt' => array(array(),false,false)),false,false)),false);
foreach ( deAspis(array_cast($api[0]->sections)) as $section_name =>$content )
{restoreTaint($section_name,$content);
arrayAssign($api[0]->sections[0],deAspis(registerTaint($section_name)),addTaint(wp_kses($content,$plugins_allowedtags)));
}foreach ( (array(array('version',false),array('author',false),array('requires',false),array('tested',false),array('homepage',false),array('downloaded',false),array('slug',false))) as $key  )
$api[0]->$key[0] = wp_kses($api[0]->$key[0],$plugins_allowedtags);
$section = ((isset($_REQUEST[0][('section')]) && Aspis_isset( $_REQUEST [0][('section')]))) ? Aspis_stripslashes($_REQUEST[0]['section']) : array('description',false);
if ( (((empty($section) || Aspis_empty( $section))) || (!((isset($api[0]->sections[0][$section[0]]) && Aspis_isset( $api[0] ->sections [0][$section[0]] ))))))
 $section = Aspis_array_shift($section_titles = attAspisRC(array_keys(deAspisRC(array_cast($api[0]->sections)))));
iframe_header(__(array('Plugin Install',false)));
echo AspisCheckPrint(concat2(concat1("<div id='",$tab),"-header'>\n"));
echo AspisCheckPrint(array("<ul id='sidemenu'>\n",false));
foreach ( deAspis(array_cast($api[0]->sections)) as $section_name =>$content )
{restoreTaint($section_name,$content);
{$title = $section_name;
$title = Aspis_ucwords(Aspis_str_replace(array('_',false),array(' ',false),$title));
$class = ($section_name[0] == $section[0]) ? array(' class="current"',false) : array('',false);
$href = add_query_arg(array(array(deregisterTaint(array('tab',false)) => addTaint($tab),deregisterTaint(array('section',false)) => addTaint($section_name)),false));
$href = esc_url($href);
$san_title = esc_attr(sanitize_title_with_dashes($title));
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\t<li><a name='",$san_title),"' target='' href='"),$href),"'"),$class),">"),$title),"</a></li>\n"));
}}echo AspisCheckPrint(array("</ul>\n",false));
echo AspisCheckPrint(array("</div>\n",false));
;
?>
	<div class="alignright fyi">
		<?php if ( (!((empty($api[0]->download_link) || Aspis_empty( $api[0] ->download_link )))))
 {;
?>
		<p class="action-button">
		<?php $type = array('install',false);
$update_plugins = get_transient(array('update_plugins',false));
if ( is_object($update_plugins[0]))
 {foreach ( deAspis(array_cast($update_plugins[0]->response)) as $file =>$plugin )
{restoreTaint($file,$plugin);
{if ( ($plugin[0]->slug[0] === $api[0]->slug[0]))
 {$type = array('update_available',false);
$update_file = $file;
break ;
}}}}if ( ((('install') == $type[0]) && is_dir((deconcat(concat12(WP_PLUGIN_DIR,'/'),$api[0]->slug)))))
 {$installed_plugin = get_plugins(concat1('/',$api[0]->slug));
if ( (!((empty($installed_plugin) || Aspis_empty( $installed_plugin)))))
 {$key = Aspis_array_shift($key = attAspisRC(array_keys(deAspisRC($installed_plugin))));
if ( (version_compare(deAspisRC($api[0]->version),deAspisRC($installed_plugin[0][$key[0]][0]['Version']),'=')))
 {$type = array('latest_installed',false);
}elseif ( (version_compare(deAspisRC($api[0]->version),deAspisRC($installed_plugin[0][$key[0]][0]['Version']),'<')))
 {$type = array('newer_installed',false);
$newer_version = $installed_plugin[0][$key[0]][0]['Version'];
}else 
{{delete_transient(array('update_plugins',false));
$update_file = concat(concat2($api[0]->slug,'/'),$key);
$type = array('update_available',false);
}}}}switch ( $type[0] ) {
default :;
case ('install'):if ( deAspis(current_user_can(array('install_plugins',false))))
 {;
?><a href="<?php echo AspisCheckPrint(wp_nonce_url(admin_url(concat1('update.php?action=install-plugin&plugin=',$api[0]->slug)),concat1('install-plugin_',$api[0]->slug)));
?>" target="_parent"><?php _e(array('Install Now',false));
?></a><?php }break ;
case ('update_available'):if ( deAspis(current_user_can(array('update_plugins',false))))
 {;
?><a href="<?php echo AspisCheckPrint(wp_nonce_url(admin_url(concat1('update.php?action=upgrade-plugin&plugin=',$update_file)),concat1('upgrade-plugin_',$update_file)));
?>" target="_parent"><?php _e(array('Install Update Now',false));
?></a><?php }break ;
case ('newer_installed'):if ( (deAspis(current_user_can(array('install_plugins',false))) || deAspis(current_user_can(array('update_plugins',false)))))
 {;
?><a><?php printf(deAspis(__(array('Newer Version (%s) Installed',false))),deAspisRC($newer_version));
?></a><?php }break ;
case ('latest_installed'):if ( (deAspis(current_user_can(array('install_plugins',false))) || deAspis(current_user_can(array('update_plugins',false)))))
 {;
?><a><?php _e(array('Latest Version Installed',false));
?></a><?php }break ;
 }
;
?>
		</p>
		<?php };
?>
		<h2 class="mainheader"><?php _e(array('FYI',false));
?></h2>
		<ul>
<?php if ( (!((empty($api[0]->version) || Aspis_empty( $api[0] ->version )))))
 {;
?>
			<li><strong><?php _e(array('Version:',false));
?></strong> <?php echo AspisCheckPrint($api[0]->version);
?></li>
<?php }if ( (!((empty($api[0]->author) || Aspis_empty( $api[0] ->author )))))
 {;
?>
			<li><strong><?php _e(array('Author:',false));
?></strong> <?php echo AspisCheckPrint(links_add_target($api[0]->author,array('_blank',false)));
?></li>
<?php }if ( (!((empty($api[0]->last_updated) || Aspis_empty( $api[0] ->last_updated )))))
 {;
?>
			<li><strong><?php _e(array('Last Updated:',false));
?></strong> <span title="<?php echo AspisCheckPrint($api[0]->last_updated);
?>"><?php printf(deAspis(__(array('%s ago',false))),deAspisRC(human_time_diff(attAspis(strtotime($api[0]->last_updated[0])))));
?></span></li>
<?php }if ( (!((empty($api[0]->requires) || Aspis_empty( $api[0] ->requires )))))
 {;
?>
			<li><strong><?php _e(array('Requires WordPress Version:',false));
?></strong> <?php printf(deAspis(__(array('%s or higher',false))),deAspisRC($api[0]->requires));
?></li>
<?php }if ( (!((empty($api[0]->tested) || Aspis_empty( $api[0] ->tested )))))
 {;
?>
			<li><strong><?php _e(array('Compatible up to:',false));
?></strong> <?php echo AspisCheckPrint($api[0]->tested);
?></li>
<?php }if ( (!((empty($api[0]->downloaded) || Aspis_empty( $api[0] ->downloaded )))))
 {;
?>
			<li><strong><?php _e(array('Downloaded:',false));
?></strong> <?php printf(deAspis(_n(array('%s time',false),array('%s times',false),$api[0]->downloaded)),deAspisRC(number_format_i18n($api[0]->downloaded)));
?></li>
<?php }if ( ((!((empty($api[0]->slug) || Aspis_empty( $api[0] ->slug )))) && ((empty($api[0]->external) || Aspis_empty( $api[0] ->external )))))
 {;
?>
			<li><a target="_blank" href="http://wordpress.org/extend/plugins/<?php echo AspisCheckPrint($api[0]->slug);
?>/"><?php _e(array('WordPress.org Plugin Page &#187;',false));
?></a></li>
<?php }if ( (!((empty($api[0]->homepage) || Aspis_empty( $api[0] ->homepage )))))
 {;
?>
			<li><a target="_blank" href="<?php echo AspisCheckPrint($api[0]->homepage);
?>"><?php _e(array('Plugin Homepage  &#187;',false));
?></a></li>
<?php };
?>
		</ul>
		<?php if ( (!((empty($api[0]->rating) || Aspis_empty( $api[0] ->rating )))))
 {;
?>
		<h2><?php _e(array('Average Rating',false));
?></h2>
		<div class="star-holder" title="<?php printf(deAspis(_n(array('(based on %s rating)',false),array('(based on %s ratings)',false),$api[0]->num_ratings)),deAspisRC(number_format_i18n($api[0]->num_ratings)));
;
?>">
			<div class="star star-rating" style="width: <?php echo AspisCheckPrint(esc_attr($api[0]->rating));
?>px"></div>
			<div class="star star5"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('5 stars',false));
?>" /></div>
			<div class="star star4"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('4 stars',false));
?>" /></div>
			<div class="star star3"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('3 stars',false));
?>" /></div>
			<div class="star star2"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('2 stars',false));
?>" /></div>
			<div class="star star1"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('1 star',false));
?>" /></div>
		</div>
		<small><?php printf(deAspis(_n(array('(based on %s rating)',false),array('(based on %s ratings)',false),$api[0]->num_ratings)),deAspisRC(number_format_i18n($api[0]->num_ratings)));
;
?></small>
		<?php };
?>
	</div>
	<div id="section-holder" class="wrap">
	<?php if ( ((!((empty($api[0]->tested) || Aspis_empty( $api[0] ->tested )))) && (version_compare(deAspisRC(Aspis_substr($GLOBALS[0]['wp_version'],array(0,false),attAspis(strlen($api[0]->tested[0])))),deAspisRC($api[0]->tested),'>'))))
 echo AspisCheckPrint(concat2(concat1('<div class="updated"><p>',__(array('<strong>Warning:</strong> This plugin has <strong>not been tested</strong> with your current version of WordPress.',false))),'</p></div>'));
else 
{if ( ((!((empty($api[0]->requires) || Aspis_empty( $api[0] ->requires )))) && (version_compare(deAspisRC(Aspis_substr($GLOBALS[0]['wp_version'],array(0,false),attAspis(strlen($api[0]->requires[0])))),deAspisRC($api[0]->requires),'<'))))
 echo AspisCheckPrint(concat2(concat1('<div class="updated"><p>',__(array('<strong>Warning:</strong> This plugin has <strong>not been marked as compatible</strong> with your version of WordPress.',false))),'</p></div>'));
}foreach ( deAspis(array_cast($api[0]->sections)) as $section_name =>$content )
{restoreTaint($section_name,$content);
{$title = $section_name;
arrayAssign($title[0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_strtoupper(attachAspis($title,(0)))));
$title = Aspis_str_replace(array('_',false),array(' ',false),$title);
$content = links_add_base_url($content,concat2(concat1('http://wordpress.org/extend/plugins/',$api[0]->slug),'/'));
$content = links_add_target($content,array('_blank',false));
$san_title = esc_attr(sanitize_title_with_dashes($title));
$display = ($section_name[0] == $section[0]) ? array('block',false) : array('none',false);
echo AspisCheckPrint(concat2(concat(concat2(concat1("\t<div id='section-",$san_title),"' class='section' style='display: "),$display),";'>\n"));
echo AspisCheckPrint(concat2(concat1("\t\t<h2 class='long-header'>",$title),"</h2>"));
echo AspisCheckPrint($content);
echo AspisCheckPrint(array("\t</div>\n",false));
}}echo AspisCheckPrint(array("</div>\n",false));
iframe_footer();
Aspis_exit();
 }
