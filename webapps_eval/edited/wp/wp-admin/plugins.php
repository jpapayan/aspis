<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('activate_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to manage plugins for this blog.',false)));
if ( ((isset($_POST[0][('clear-recent-list')]) && Aspis_isset( $_POST [0][('clear-recent-list')]))))
 $action = array('clear-recent-list',false);
elseif ( (!((empty($_REQUEST[0][('action')]) || Aspis_empty( $_REQUEST [0][('action')])))))
 $action = $_REQUEST[0]['action'];
elseif ( (!((empty($_REQUEST[0][('action2')]) || Aspis_empty( $_REQUEST [0][('action2')])))))
 $action = $_REQUEST[0]['action2'];
else 
{$action = array(false,false);
}$plugin = ((isset($_REQUEST[0][('plugin')]) && Aspis_isset( $_REQUEST [0][('plugin')]))) ? $_REQUEST[0]['plugin'] : array('',false);
$default_status = get_user_option(array('plugins_last_view',false));
if ( ((empty($default_status) || Aspis_empty( $default_status))))
 $default_status = array('all',false);
$status = ((isset($_REQUEST[0][('plugin_status')]) && Aspis_isset( $_REQUEST [0][('plugin_status')]))) ? $_REQUEST[0]['plugin_status'] : $default_status;
if ( (denot_boolean(Aspis_in_array($status,array(array(array('all',false),array('active',false),array('inactive',false),array('recent',false),array('upgrade',false),array('search',false)),false)))))
 $status = array('all',false);
if ( (($status[0] != $default_status[0]) && (('search') != $status[0])))
 update_usermeta($current_user[0]->ID,array('plugins_last_view',false),$status);
$page = ((isset($_REQUEST[0][('paged')]) && Aspis_isset( $_REQUEST [0][('paged')]))) ? $_REQUEST[0]['paged'] : array(1,false);
arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('error',false),array('deleted',false),array('activate',false),array('activate-multi',false),array('deactivate',false),array('deactivate-multi',false),array('_error_nonce',false)),false),$_SERVER[0]['REQUEST_URI'])));
if ( (!((empty($action) || Aspis_empty( $action)))))
 {switch ( $action[0] ) {
case ('activate'):if ( (denot_boolean(current_user_can(array('activate_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to activate plugins for this blog.',false)));
check_admin_referer(concat1('activate-plugin_',$plugin));
$result = activate_plugin($plugin,concat1('plugins.php?error=true&plugin=',$plugin));
if ( deAspis(is_wp_error($result)))
 wp_die($result);
$recent = array_cast(get_option(array('recently_activated',false)));
if ( ((isset($recent[0][$plugin[0]]) && Aspis_isset( $recent [0][$plugin[0]]))))
 {unset($recent[0][$plugin[0]]);
update_option(array('recently_activated',false),$recent);
}wp_redirect(concat(concat2(concat1("plugins.php?activate=true&plugin_status=",$status),"&paged="),$page));
Aspis_exit();
break ;
case ('activate-selected'):if ( (denot_boolean(current_user_can(array('activate_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to activate plugins for this blog.',false)));
check_admin_referer(array('bulk-manage-plugins',false));
$plugins = ((isset($_POST[0][('checked')]) && Aspis_isset( $_POST [0][('checked')]))) ? array_cast($_POST[0]['checked']) : array(array(),false);
$plugins = attAspisRC(array_filter(deAspisRC($plugins),AspisInternalCallback(Aspis_create_function(array('$plugin',false),array('return !is_plugin_active($plugin);',false)))));
if ( ((empty($plugins) || Aspis_empty( $plugins))))
 {wp_redirect(concat(concat2(concat1("plugins.php?plugin_status=",$status),"&paged="),$page));
Aspis_exit();
}activate_plugins($plugins,array('plugins.php?error=true',false));
$recent = array_cast(get_option(array('recently_activated',false)));
foreach ( $plugins[0] as $plugin =>$time )
{restoreTaint($plugin,$time);
if ( ((isset($recent[0][$plugin[0]]) && Aspis_isset( $recent [0][$plugin[0]]))))
 unset($recent[0][$plugin[0]]);
}update_option(array('recently_activated',false),$recent);
wp_redirect(concat(concat2(concat1("plugins.php?activate-multi=true&plugin_status=",$status),"&paged="),$page));
Aspis_exit();
break ;
case ('error_scrape'):if ( (denot_boolean(current_user_can(array('activate_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to activate plugins for this blog.',false)));
check_admin_referer(concat1('plugin-activation-error_',$plugin));
$valid = validate_plugin($plugin);
if ( deAspis(is_wp_error($valid)))
 wp_die($valid);
if ( defined(('E_RECOVERABLE_ERROR')))
 error_reporting(deAspisRC(array(((((E_ERROR | E_WARNING) | E_PARSE) | E_USER_ERROR) | E_USER_WARNING) | E_RECOVERABLE_ERROR,false)));
else 
{error_reporting(deAspisRC(array((((E_ERROR | E_WARNING) | E_PARSE) | E_USER_ERROR) | E_USER_WARNING,false)));
}@array(ini_set('display_errors',true),false);
include (deconcat(concat12(WP_PLUGIN_DIR,'/'),$plugin));
do_action(concat1('activate_',$plugin));
Aspis_exit();
break ;
case ('deactivate'):if ( (denot_boolean(current_user_can(array('activate_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to deactivate plugins for this blog.',false)));
check_admin_referer(concat1('deactivate-plugin_',$plugin));
deactivate_plugins($plugin);
update_option(array('recently_activated',false),array((array(deregisterTaint($plugin) => addTaint(attAspis(time())))) + deAspis(array_cast(get_option(array('recently_activated',false)))),false));
wp_redirect(concat(concat2(concat1("plugins.php?deactivate=true&plugin_status=",$status),"&paged="),$page));
Aspis_exit();
break ;
case ('deactivate-selected'):if ( (denot_boolean(current_user_can(array('activate_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to deactivate plugins for this blog.',false)));
check_admin_referer(array('bulk-manage-plugins',false));
$plugins = ((isset($_POST[0][('checked')]) && Aspis_isset( $_POST [0][('checked')]))) ? array_cast($_POST[0]['checked']) : array(array(),false);
$plugins = attAspisRC(array_filter(deAspisRC($plugins),AspisInternalCallback(array('is_plugin_active',false))));
if ( ((empty($plugins) || Aspis_empty( $plugins))))
 {wp_redirect(concat(concat2(concat1("plugins.php?plugin_status=",$status),"&paged="),$page));
Aspis_exit();
}deactivate_plugins($plugins);
$deactivated = array(array(),false);
foreach ( $plugins[0] as $plugin  )
arrayAssign($deactivated[0],deAspis(registerTaint($plugin)),addTaint(attAspis(time())));
update_option(array('recently_activated',false),array($deactivated[0] + deAspis(array_cast(get_option(array('recently_activated',false)))),false));
wp_redirect(concat(concat2(concat1("plugins.php?deactivate-multi=true&plugin_status=",$status),"&paged="),$page));
Aspis_exit();
break ;
case ('delete-selected'):if ( (denot_boolean(current_user_can(array('delete_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to delete plugins for this blog.',false)));
check_admin_referer(array('bulk-manage-plugins',false));
$plugins = ((isset($_REQUEST[0][('checked')]) && Aspis_isset( $_REQUEST [0][('checked')]))) ? array_cast($_REQUEST[0]['checked']) : array(array(),false);
$plugins = attAspisRC(array_filter(deAspisRC($plugins),AspisInternalCallback(Aspis_create_function(array('$plugin',false),array('return !is_plugin_active($plugin);',false)))));
if ( ((empty($plugins) || Aspis_empty( $plugins))))
 {wp_redirect(concat(concat2(concat1("plugins.php?plugin_status=",$status),"&paged="),$page));
Aspis_exit();
}include (deconcat12(ABSPATH,'wp-admin/update.php'));
$parent_file = array('plugins.php',false);
if ( (!((isset($_REQUEST[0][('verify-delete')]) && Aspis_isset( $_REQUEST [0][('verify-delete')])))))
 {wp_enqueue_script(array('jquery',false));
require_once ('admin-header.php');
;
?>
			<div class="wrap">
				<h2><?php _e(array('Delete Plugin(s)',false));
;
?></h2>
				<?php $files_to_delete = $plugin_info = array(array(),false);
foreach ( deAspis(array_cast($plugins)) as $plugin  )
{if ( (('.') == deAspis(Aspis_dirname($plugin))))
 {arrayAssignAdd($files_to_delete[0][],addTaint(concat(concat12(WP_PLUGIN_DIR,'/'),$plugin)));
if ( deAspis($data = get_plugin_data(concat(concat12(WP_PLUGIN_DIR,'/'),$plugin))))
 arrayAssign($plugin_info[0],deAspis(registerTaint($plugin)),addTaint($data));
}else 
{{$files = list_files(concat(concat12(WP_PLUGIN_DIR,'/'),Aspis_dirname($plugin)));
if ( $files[0])
 {$files_to_delete = Aspis_array_merge($files_to_delete,$files);
}if ( deAspis($folder_plugins = get_plugins(concat1('/',Aspis_dirname($plugin)))))
 $plugin_info = Aspis_array_merge($plugin_info,$folder_plugins);
}}};
?>
				<p><?php _e(array('Deleting the selected plugins will remove the following plugin(s) and their files:',false));
;
?></p>
					<ul class="ul-disc">
						<?php foreach ( $plugin_info[0] as $plugin  )
echo AspisCheckPrint(array('<li>',false)),AspisCheckPrint(Aspis_sprintf(__(array('<strong>%s</strong> by <em>%s</em>',false)),$plugin[0]['Name'],$plugin[0]['Author'])),AspisCheckPrint(array('</li>',false));
;
?>
					</ul>
				<p><?php _e(array('Are you sure you wish to delete these files?',false));
?></p>
				<form method="post" action="<?php echo AspisCheckPrint(esc_url($_SERVER[0]['REQUEST_URI']));
;
?>" style="display:inline;">
					<input type="hidden" name="verify-delete" value="1" />
					<input type="hidden" name="action" value="delete-selected" />
					<?php foreach ( deAspis(array_cast($plugins)) as $plugin  )
echo AspisCheckPrint(concat2(concat1('<input type="hidden" name="checked[]" value="',esc_attr($plugin)),'" />'));
;
?>
					<?php wp_nonce_field(array('bulk-manage-plugins',false));
?>
					<input type="submit" name="submit" value="<?php esc_attr_e(array('Yes, Delete these files',false));
?>" class="button" />
				</form>
				<form method="post" action="<?php echo AspisCheckPrint(esc_url(wp_get_referer()));
;
?>" style="display:inline;">
					<input type="submit" name="submit" value="<?php esc_attr_e(array('No, Return me to the plugin list',false));
?>" class="button" />
				</form>

				<p><a href="#" onclick="jQuery('#files-list').toggle(); return false;"><?php _e(array('Click to view entire list of files which will be deleted',false));
;
?></a></p>
				<div id="files-list" style="display:none;">
					<ul class="code">
					<?php foreach ( deAspis(array_cast($files_to_delete)) as $file  )
echo AspisCheckPrint(concat2(concat1('<li>',Aspis_str_replace(array(WP_PLUGIN_DIR,false),array('',false),$file)),'</li>'));
;
?>
					</ul>
				</div>
			</div>
				<?php require_once ('admin-footer.php');
Aspis_exit();
}$delete_result = delete_plugins($plugins);
set_transient(concat1('plugins_delete_result_',$user_ID),$delete_result);
wp_redirect(concat(concat2(concat1("plugins.php?deleted=true&plugin_status=",$status),"&paged="),$page));
Aspis_exit();
break ;
case ('clear-recent-list'):update_option(array('recently_activated',false),array(array(),false));
break ;
 }
}wp_enqueue_script(array('plugin-install',false));
add_thickbox();
$help = concat2(concat1('<p>',__(array('Plugins extend and expand the functionality of WordPress. Once a plugin is installed, you may activate it or deactivate it here.',false))),'</p>');
$help = concat($help,concat2(concat1('<p>',Aspis_sprintf(__(array('If something goes wrong with a plugin and you can&#8217;t use WordPress, delete or rename that file in the <code>%s</code> directory and it will be automatically deactivated.',false)),array(WP_PLUGIN_DIR,false))),'</p>'));
$help = concat($help,concat2(concat1('<p>',Aspis_sprintf(__(array('You can find additional plugins for your site by using the new <a href="%1$s">Plugin Browser/Installer</a> functionality or by browsing the <a href="http://wordpress.org/extend/plugins/">WordPress Plugin Directory</a> directly and installing manually.  To <em>manually</em> install a plugin you generally just need to upload the plugin file into your <code>%2$s</code> directory.  Once a plugin has been installed, you may activate it here.',false)),array('plugin-install.php',false),array(WP_PLUGIN_DIR,false))),'</p>'));
add_contextual_help(array('plugins',false),$help);
$title = __(array('Manage Plugins',false));
require_once ('admin-header.php');
$invalid = validate_active_plugins();
if ( (!((empty($invalid) || Aspis_empty( $invalid)))))
 foreach ( $invalid[0] as $plugin_file =>$error )
{restoreTaint($plugin_file,$error);
echo AspisCheckPrint(concat2(concat1('<div id="message" class="error"><p>',Aspis_sprintf(__(array('The plugin <code>%s</code> has been <strong>deactivated</strong> due to an error: %s',false)),esc_html($plugin_file),$error[0]->get_error_message())),'</p></div>'));
};
?>

<?php if ( ((isset($_GET[0][('error')]) && Aspis_isset( $_GET [0][('error')]))))
 {;
?>
	<div id="message" class="updated fade"><p><?php _e(array('Plugin could not be activated because it triggered a <strong>fatal error</strong>.',false));
?></p>
	<?php if ( deAspis(wp_verify_nonce($_GET[0]['_error_nonce'],concat1('plugin-activation-error_',$plugin))))
 {;
?>
	<iframe style="border:0" width="100%" height="70px" src="<?php echo AspisCheckPrint(admin_url(concat(concat2(concat1('plugins.php?action=error_scrape&amp;plugin=',esc_attr($plugin)),'&amp;_wpnonce='),esc_attr($_GET[0]['_error_nonce']))));
;
?>"></iframe>
	<?php };
?>
	</div>
<?php }elseif ( ((isset($_GET[0][('deleted')]) && Aspis_isset( $_GET [0][('deleted')]))))
 {$delete_result = get_transient(concat1('plugins_delete_result_',$user_ID));
delete_transient(array('plugins_delete_result',false));
if ( deAspis(is_wp_error($delete_result)))
 {;
?>
		<div id="message" class="updated fade"><p><?php printf(deAspis(__(array('Plugin could not be deleted due to an error: %s',false))),deAspisRC($delete_result[0]->get_error_message()));
;
?></p></div>
		<?php }else 
{;
?>
		<div id="message" class="updated fade"><p><?php _e(array('The selected plugins have been <strong>deleted</strong>.',false));
;
?></p></div>
		<?php };
?>
<?php }elseif ( ((isset($_GET[0][('activate')]) && Aspis_isset( $_GET [0][('activate')]))))
 {;
?>
	<div id="message" class="updated fade"><p><?php _e(array('Plugin <strong>activated</strong>.',false));
?></p></div>
<?php }elseif ( ((isset($_GET[0][('activate-multi')]) && Aspis_isset( $_GET [0][('activate-multi')]))))
 {;
?>
	<div id="message" class="updated fade"><p><?php _e(array('Selected plugins <strong>activated</strong>.',false));
;
?></p></div>
<?php }elseif ( ((isset($_GET[0][('deactivate')]) && Aspis_isset( $_GET [0][('deactivate')]))))
 {;
?>
	<div id="message" class="updated fade"><p><?php _e(array('Plugin <strong>deactivated</strong>.',false));
?></p></div>
<?php }elseif ( ((isset($_GET[0][('deactivate-multi')]) && Aspis_isset( $_GET [0][('deactivate-multi')]))))
 {;
?>
	<div id="message" class="updated fade"><p><?php _e(array('Selected plugins <strong>deactivated</strong>.',false));
;
?></p></div>
<?php };
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?> <a href="plugin-install.php" class="button add-new-h2"><?php echo AspisCheckPrint(esc_html_x(array('Add New',false),array('plugin',false)));
;
?></a></h2>

<?php $all_plugins = get_plugins();
$search_plugins = array(array(),false);
$active_plugins = array(array(),false);
$inactive_plugins = array(array(),false);
$recent_plugins = array(array(),false);
$recently_activated = get_option(array('recently_activated',false),array(array(),false));
$upgrade_plugins = array(array(),false);
set_transient(array('plugin_slugs',false),attAspisRC(array_keys(deAspisRC($all_plugins))),array(86400,false));
foreach ( $recently_activated[0] as $key =>$time )
{restoreTaint($key,$time);
if ( (($time[0] + ((((7) * (24)) * (60)) * (60))) < time()))
 unset($recently_activated[0][$key[0]]);
}if ( ($recently_activated[0] != deAspis(get_option(array('recently_activated',false)))))
 update_option(array('recently_activated',false),$recently_activated);
$current = get_transient(array('update_plugins',false));
foreach ( deAspis(array_cast($all_plugins)) as $plugin_file =>$plugin_data )
{restoreTaint($plugin_file,$plugin_data);
{$plugin_data = _get_plugin_data_markup_translate($plugin_file,$plugin_data,array(false,false),array(true,false));
arrayAssign($all_plugins[0],deAspis(registerTaint($plugin_file)),addTaint($plugin_data));
if ( deAspis(is_plugin_active($plugin_file)))
 {arrayAssign($active_plugins[0],deAspis(registerTaint($plugin_file)),addTaint($plugin_data));
}else 
{{if ( ((isset($recently_activated[0][$plugin_file[0]]) && Aspis_isset( $recently_activated [0][$plugin_file[0]]))))
 arrayAssign($recent_plugins[0],deAspis(registerTaint($plugin_file)),addTaint($plugin_data));
arrayAssign($inactive_plugins[0],deAspis(registerTaint($plugin_file)),addTaint($plugin_data));
}}if ( ((isset($current[0]->response[0][$plugin_file[0]]) && Aspis_isset( $current[0] ->response [0][$plugin_file[0]] ))))
 arrayAssign($upgrade_plugins[0],deAspis(registerTaint($plugin_file)),addTaint($plugin_data));
}}$total_all_plugins = attAspis(count($all_plugins[0]));
$total_inactive_plugins = attAspis(count($inactive_plugins[0]));
$total_active_plugins = attAspis(count($active_plugins[0]));
$total_recent_plugins = attAspis(count($recent_plugins[0]));
$total_upgrade_plugins = attAspis(count($upgrade_plugins[0]));
if ( ((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))))
 {function _search_plugins_filter_callback ( $plugin ) {
static $term;
if ( is_null(deAspisRC($term)))
 $term = Aspis_stripslashes($_GET[0]['s']);
if ( (((((((stripos(deAspisRC($plugin[0]['Name']),deAspisRC($term))) !== false) || ((stripos(deAspisRC($plugin[0]['Description']),deAspisRC($term))) !== false)) || ((stripos(deAspisRC($plugin[0]['Author']),deAspisRC($term))) !== false)) || ((stripos(deAspisRC($plugin[0]['PluginURI']),deAspisRC($term))) !== false)) || ((stripos(deAspisRC($plugin[0]['AuthorURI']),deAspisRC($term))) !== false)) || ((stripos(deAspisRC($plugin[0]['Version']),deAspisRC($term))) !== false)))
 return array(true,false);
else 
{return array(false,false);
} }
$status = array('search',false);
$search_plugins = attAspisRC(array_filter(deAspisRC($all_plugins),AspisInternalCallback(array('_search_plugins_filter_callback',false))));
$total_search_plugins = attAspis(count($search_plugins[0]));
}$plugin_array_name = concat2($status,"_plugins");
if ( (((empty(${$plugin_array_name[0]}) || Aspis_empty( ${$plugin_array_name[0]}))) && ($status[0] != ('all'))))
 {$status = array('all',false);
$plugin_array_name = concat2($status,"_plugins");
}$plugins = &${$plugin_array_name[0]};
$total_this_page = concat2(concat1("total_",$status),"_plugins");
$total_this_page = ${$total_this_page[0]};
$plugins_per_page = int_cast(get_user_option(array('plugins_per_page',false),array(0,false),array(false,false)));
if ( (((empty($plugins_per_page) || Aspis_empty( $plugins_per_page))) || ($plugins_per_page[0] < (1))))
 $plugins_per_page = array(999,false);
$plugins_per_page = apply_filters(array('plugins_per_page',false),$plugins_per_page);
$start = array(($page[0] - (1)) * $plugins_per_page[0],false);
$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('paged',false),array('%#%',false))),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint(attAspis(ceil(($total_this_page[0] / $plugins_per_page[0])))),deregisterTaint(array('current',false)) => addTaint($page)),false));
$page_links_text = Aspis_sprintf(concat2(concat1('<span class="displaying-num">',__(array('Displaying %s&#8211;%s of %s',false))),'</span>%s'),number_format_i18n(array($start[0] + (1),false)),number_format_i18n(attAspisRC(min(deAspisRC(array($page[0] * $plugins_per_page[0],false)),deAspisRC($total_this_page)))),concat2(concat1('<span class="total-type-count">',number_format_i18n($total_this_page)),'</span>'),$page_links);
function print_plugins_table ( $plugins,$context = array('',false) ) {
global $page;
;
?>
<table class="widefat" cellspacing="0" id="<?php echo AspisCheckPrint($context);
?>-plugins-table">
	<thead>
	<tr>
		<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
		<th scope="col" class="manage-column"><?php _e(array('Plugin',false));
;
?></th>
		<th scope="col" class="manage-column"><?php _e(array('Description',false));
;
?></th>
	</tr>
	</thead>

	<tfoot>
	<tr>
		<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
		<th scope="col" class="manage-column"><?php _e(array('Plugin',false));
;
?></th>
		<th scope="col" class="manage-column"><?php _e(array('Description',false));
;
?></th>
	</tr>
	</tfoot>

	<tbody class="plugins">
<?php if ( ((empty($plugins) || Aspis_empty( $plugins))))
 {echo AspisCheckPrint(concat2(concat1('<tr>
			<td colspan="3">',__(array('No plugins to show',false))),'</td>
		</tr>'));
}foreach ( deAspis(array_cast($plugins)) as $plugin_file =>$plugin_data )
{restoreTaint($plugin_file,$plugin_data);
{$actions = array(array(),false);
$is_active = is_plugin_active($plugin_file);
if ( $is_active[0])
 arrayAssignAdd($actions[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',wp_nonce_url(concat(concat2(concat(concat2(concat1('plugins.php?action=deactivate&amp;plugin=',$plugin_file),'&amp;plugin_status='),$context),'&amp;paged='),$page),concat1('deactivate-plugin_',$plugin_file))),'" title="'),__(array('Deactivate this plugin',false))),'">'),__(array('Deactivate',false))),'</a>')));
else 
{arrayAssignAdd($actions[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',wp_nonce_url(concat(concat2(concat(concat2(concat1('plugins.php?action=activate&amp;plugin=',$plugin_file),'&amp;plugin_status='),$context),'&amp;paged='),$page),concat1('activate-plugin_',$plugin_file))),'" title="'),__(array('Activate this plugin',false))),'" class="edit">'),__(array('Activate',false))),'</a>')));
}if ( (deAspis(current_user_can(array('edit_plugins',false))) && is_writable((deconcat(concat12(WP_PLUGIN_DIR,'/'),$plugin_file)))))
 arrayAssignAdd($actions[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="plugin-editor.php?file=',$plugin_file),'" title="'),__(array('Open this file in the Plugin Editor',false))),'" class="edit">'),__(array('Edit',false))),'</a>')));
if ( ((denot_boolean($is_active)) && deAspis(current_user_can(array('delete_plugins',false)))))
 arrayAssignAdd($actions[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',wp_nonce_url(concat(concat2(concat(concat2(concat1('plugins.php?action=delete-selected&amp;checked[]=',$plugin_file),'&amp;plugin_status='),$context),'&amp;paged='),$page),array('bulk-manage-plugins',false))),'" title="'),__(array('Delete this plugin',false))),'" class="delete">'),__(array('Delete',false))),'</a>')));
$actions = apply_filters(array('plugin_action_links',false),$actions,$plugin_file,$plugin_data,$context);
$actions = apply_filters(concat1("plugin_action_links_",$plugin_file),$actions,$plugin_file,$plugin_data,$context);
$action_count = attAspis(count($actions[0]));
$class = $is_active[0] ? array('active',false) : array('inactive',false);
echo AspisCheckPrint(concat(concat(concat2(concat1("
	<tr class='",$class),"'>
		<th scope='row' class='check-column'><input type='checkbox' name='checked[]' value='"),esc_attr($plugin_file)),concat2(concat(concat2(concat(concat2(concat1("' /></th>
		<td class='plugin-title'><strong>",$plugin_data[0]['Name']),"</strong></td>
		<td class='desc'><p>"),$plugin_data[0]['Description']),"</p></td>
	</tr>
	<tr class='"),$class)," second'>
		<td></td>
		<td class='plugin-title'>")));
echo AspisCheckPrint(array('<div class="row-actions-visible">',false));
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{$sep = (deAspis(Aspis_end($actions)) == $link[0]) ? array('',false) : array(' | ',false);
echo AspisCheckPrint(concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$link),$sep),"</span>"));
}}echo AspisCheckPrint(array("</div></td>
		<td class='desc'>",false));
$plugin_meta = array(array(),false);
if ( (!((empty($plugin_data[0][('Version')]) || Aspis_empty( $plugin_data [0][('Version')])))))
 arrayAssignAdd($plugin_meta[0][],addTaint(Aspis_sprintf(__(array('Version %s',false)),$plugin_data[0]['Version'])));
if ( (!((empty($plugin_data[0][('Author')]) || Aspis_empty( $plugin_data [0][('Author')])))))
 {$author = $plugin_data[0]['Author'];
if ( (!((empty($plugin_data[0][('AuthorURI')]) || Aspis_empty( $plugin_data [0][('AuthorURI')])))))
 $author = concat2(concat(concat2(concat(concat2(concat1('<a href="',$plugin_data[0]['AuthorURI']),'" title="'),__(array('Visit author homepage',false))),'">'),$plugin_data[0]['Author']),'</a>');
arrayAssignAdd($plugin_meta[0][],addTaint(Aspis_sprintf(__(array('By %s',false)),$author)));
}if ( (!((empty($plugin_data[0][('PluginURI')]) || Aspis_empty( $plugin_data [0][('PluginURI')])))))
 arrayAssignAdd($plugin_meta[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$plugin_data[0]['PluginURI']),'" title="'),__(array('Visit plugin site',false))),'">'),__(array('Visit plugin site',false))),'</a>')));
$plugin_meta = apply_filters(array('plugin_row_meta',false),$plugin_meta,$plugin_file,$plugin_data,$context);
echo AspisCheckPrint(Aspis_implode(array(' | ',false),$plugin_meta));
echo AspisCheckPrint(array("</td>
	</tr>\n",false));
do_action(array('after_plugin_row',false),$plugin_file,$plugin_data,$context);
do_action(concat1("after_plugin_row_",$plugin_file),$plugin_file,$plugin_data,$context);
}};
?>
	</tbody>
</table>
<?php  }
function print_plugin_actions ( $context,$field_name = array('action',false) ) {
;
?>
	<div class="alignleft actions">
		<select name="<?php echo AspisCheckPrint($field_name);
;
?>">
			<option value="" selected="selected"><?php _e(array('Bulk Actions',false));
;
?></option>
	<?php if ( (('active') != $context[0]))
 {;
?>
			<option value="activate-selected"><?php _e(array('Activate',false));
;
?></option>
	<?php };
?>
	<?php if ( ((('inactive') != $context[0]) && (('recent') != $context[0])))
 {;
?>
			<option value="deactivate-selected"><?php _e(array('Deactivate',false));
;
?></option>
	<?php };
?>
	<?php if ( (deAspis(current_user_can(array('delete_plugins',false))) && (('active') != $context[0])))
 {;
?>
			<option value="delete-selected"><?php _e(array('Delete',false));
;
?></option>
	<?php };
?>
		</select>
		<input type="submit" name="doaction_active" value="<?php esc_attr_e(array('Apply',false));
;
?>" class="button-secondary action" />
	<?php if ( (('recent') == $context[0]))
 {;
?>
		<input type="submit" name="clear-recent-list" value="<?php esc_attr_e(array('Clear List',false));
?>" class="button-secondary" />
	<?php };
?>
	</div>
<?php  }
;
?>

<form method="get" action="">
<p class="search-box">
	<label class="screen-reader-text" for="plugin-search-input"><?php _e(array('Search Plugins',false));
;
?>:</label>
	<input type="text" id="plugin-search-input" name="s" value="<?php _admin_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e(array('Search Plugins',false));
;
?>" class="button" />
</p>
</form>

<form method="post" action="<?php echo AspisCheckPrint(admin_url(array('plugins.php',false)));
?>">
<?php wp_nonce_field(array('bulk-manage-plugins',false));
?>
<input type="hidden" name="plugin_status" value="<?php echo AspisCheckPrint(esc_attr($status));
?>" />
<input type="hidden" name="paged" value="<?php echo AspisCheckPrint(esc_attr($page));
?>" />

<ul class="subsubsub">
<?php $status_links = array(array(),false);
$class = (('all') == $status[0]) ? array(' class="current"',false) : array('',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat1("<li><a href='plugins.php?plugin_status=all' ",$class),">"),Aspis_sprintf(_nx(array('All <span class="count">(%s)</span>',false),array('All <span class="count">(%s)</span>',false),$total_all_plugins,array('plugins',false)),number_format_i18n($total_all_plugins))),'</a>')));
if ( (!((empty($active_plugins) || Aspis_empty( $active_plugins)))))
 {$class = (('active') == $status[0]) ? array(' class="current"',false) : array('',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat1("<li><a href='plugins.php?plugin_status=active' ",$class),">"),Aspis_sprintf(_n(array('Active <span class="count">(%s)</span>',false),array('Active <span class="count">(%s)</span>',false),$total_active_plugins),number_format_i18n($total_active_plugins))),'</a>')));
}if ( (!((empty($recent_plugins) || Aspis_empty( $recent_plugins)))))
 {$class = (('recent') == $status[0]) ? array(' class="current"',false) : array('',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat1("<li><a href='plugins.php?plugin_status=recent' ",$class),">"),Aspis_sprintf(_n(array('Recently Active <span class="count">(%s)</span>',false),array('Recently Active <span class="count">(%s)</span>',false),$total_recent_plugins),number_format_i18n($total_recent_plugins))),'</a>')));
}if ( (!((empty($inactive_plugins) || Aspis_empty( $inactive_plugins)))))
 {$class = (('inactive') == $status[0]) ? array(' class="current"',false) : array('',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat1("<li><a href='plugins.php?plugin_status=inactive' ",$class),">"),Aspis_sprintf(_n(array('Inactive <span class="count">(%s)</span>',false),array('Inactive <span class="count">(%s)</span>',false),$total_inactive_plugins),number_format_i18n($total_inactive_plugins))),'</a>')));
}if ( (!((empty($upgrade_plugins) || Aspis_empty( $upgrade_plugins)))))
 {$class = (('upgrade') == $status[0]) ? array(' class="current"',false) : array('',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat1("<li><a href='plugins.php?plugin_status=upgrade' ",$class),">"),Aspis_sprintf(_n(array('Upgrade Available <span class="count">(%s)</span>',false),array('Upgrade Available <span class="count">(%s)</span>',false),$total_upgrade_plugins),number_format_i18n($total_upgrade_plugins))),'</a>')));
}if ( (!((empty($search_plugins) || Aspis_empty( $search_plugins)))))
 {$class = (('search') == $status[0]) ? array(' class="current"',false) : array('',false);
$term = ((isset($_REQUEST[0][('s')]) && Aspis_isset( $_REQUEST [0][('s')]))) ? Aspis_urlencode(Aspis_stripslashes($_REQUEST[0]['s'])) : array('',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1("<li><a href='plugins.php?s=",$term),"' "),$class),">"),Aspis_sprintf(_n(array('Search Results <span class="count">(%s)</span>',false),array('Search Results <span class="count">(%s)</span>',false),$total_search_plugins),number_format_i18n($total_search_plugins))),'</a>')));
}echo AspisCheckPrint(concat2(Aspis_implode(array(" |</li>\n",false),$status_links),'</li>'));
unset($status_links);
;
?>
</ul>

<div class="tablenav">
<?php if ( $page_links[0])
 echo AspisCheckPrint(array('<div class="tablenav-pages">',false)),AspisCheckPrint($page_links_text),AspisCheckPrint(array('</div>',false));
print_plugin_actions($status);
;
?>
</div>
<div class="clear"></div>
<?php if ( ($total_this_page[0] > $plugins_per_page[0]))
 $plugins = Aspis_array_slice($plugins,$start,$plugins_per_page);
print_plugins_table($plugins,$status);
;
?>
<div class="tablenav">
<?php if ( $page_links[0])
 echo AspisCheckPrint(concat2(concat1("<div class='tablenav-pages'>",$page_links_text),"</div>"));
print_plugin_actions($status,array("action2",false));
;
?>
</div>
</form>

<?php if ( ((empty($all_plugins) || Aspis_empty( $all_plugins))))
 {;
?>
<p><?php _e(array('You do not appear to have any plugins available at this time.',false));
?></p>
<?php };
?>

</div>

<?php include ('admin-footer.php');
;
?>
<?php 