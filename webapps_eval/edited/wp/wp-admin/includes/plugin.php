<?php require_once('AspisMain.php'); ?><?php
function get_plugin_data ( $plugin_file,$markup = array(true,false),$translate = array(true,false) ) {
$default_headers = array(array('Name' => array('Plugin Name',false,false),'PluginURI' => array('Plugin URI',false,false),'Version' => array('Version',false,false),'Description' => array('Description',false,false),'Author' => array('Author',false,false),'AuthorURI' => array('Author URI',false,false),'TextDomain' => array('Text Domain',false,false),'DomainPath' => array('Domain Path',false,false)),false);
$plugin_data = get_file_data($plugin_file,$default_headers,array('plugin',false));
arrayAssign($plugin_data[0],deAspis(registerTaint(array('Title',false))),addTaint($plugin_data[0]['Name']));
if ( ($markup[0] || $translate[0]))
 $plugin_data = _get_plugin_data_markup_translate($plugin_file,$plugin_data,$markup,$translate);
return $plugin_data;
 }
function _get_plugin_data_markup_translate ( $plugin_file,$plugin_data,$markup = array(true,false),$translate = array(true,false) ) {
if ( ($translate[0] && (!((empty($plugin_data[0][('TextDomain')]) || Aspis_empty( $plugin_data [0][('TextDomain')]))))))
 {if ( (!((empty($plugin_data[0][('DomainPath')]) || Aspis_empty( $plugin_data [0][('DomainPath')])))))
 load_plugin_textdomain($plugin_data[0]['TextDomain'],array(false,false),concat(Aspis_dirname($plugin_file),$plugin_data[0]['DomainPath']));
else 
{load_plugin_textdomain($plugin_data[0]['TextDomain'],array(false,false),Aspis_dirname($plugin_file));
}foreach ( (array(array('Name',false),array('PluginURI',false),array('Description',false),array('Author',false),array('AuthorURI',false),array('Version',false))) as $field  )
arrayAssign($plugin_data[0],deAspis(registerTaint($field)),addTaint(translate(attachAspis($plugin_data,$field[0]),$plugin_data[0]['TextDomain'])));
}if ( $markup[0])
 {if ( ((!((empty($plugin_data[0][('PluginURI')]) || Aspis_empty( $plugin_data [0][('PluginURI')])))) && (!((empty($plugin_data[0][('Name')]) || Aspis_empty( $plugin_data [0][('Name')]))))))
 arrayAssign($plugin_data[0],deAspis(registerTaint(array('Title',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$plugin_data[0]['PluginURI']),'" title="'),__(array('Visit plugin homepage',false))),'">'),$plugin_data[0]['Name']),'</a>')));
else 
{arrayAssign($plugin_data[0],deAspis(registerTaint(array('Title',false))),addTaint($plugin_data[0]['Name']));
}if ( ((!((empty($plugin_data[0][('AuthorURI')]) || Aspis_empty( $plugin_data [0][('AuthorURI')])))) && (!((empty($plugin_data[0][('Author')]) || Aspis_empty( $plugin_data [0][('Author')]))))))
 arrayAssign($plugin_data[0],deAspis(registerTaint(array('Author',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$plugin_data[0]['AuthorURI']),'" title="'),__(array('Visit author homepage',false))),'">'),$plugin_data[0]['Author']),'</a>')));
arrayAssign($plugin_data[0],deAspis(registerTaint(array('Description',false))),addTaint(wptexturize($plugin_data[0]['Description'])));
if ( (!((empty($plugin_data[0][('Author')]) || Aspis_empty( $plugin_data [0][('Author')])))))
 arrayAssign($plugin_data[0],deAspis(registerTaint(array('Description',false))),addTaint(concat($plugin_data[0]['Description'],concat2(concat1(' <cite>',Aspis_sprintf(__(array('By %s',false)),$plugin_data[0]['Author'])),'.</cite>'))));
}$plugins_allowedtags = array(array('a' => array(array('href' => array(array(),false,false),'title' => array(array(),false,false)),false,false),'abbr' => array(array('title' => array(array(),false,false)),false,false),'acronym' => array(array('title' => array(array(),false,false)),false,false),'code' => array(array(),false,false),'em' => array(array(),false,false),'strong' => array(array(),false,false)),false);
arrayAssign($plugin_data[0],deAspis(registerTaint(array('Title',false))),addTaint(wp_kses($plugin_data[0]['Title'],$plugins_allowedtags)));
arrayAssign($plugin_data[0],deAspis(registerTaint(array('Version',false))),addTaint(wp_kses($plugin_data[0]['Version'],$plugins_allowedtags)));
arrayAssign($plugin_data[0],deAspis(registerTaint(array('Description',false))),addTaint(wp_kses($plugin_data[0]['Description'],$plugins_allowedtags)));
arrayAssign($plugin_data[0],deAspis(registerTaint(array('Author',false))),addTaint(wp_kses($plugin_data[0]['Author'],$plugins_allowedtags)));
return $plugin_data;
 }
function get_plugin_files ( $plugin ) {
$plugin_file = concat(concat12(WP_PLUGIN_DIR,'/'),$plugin);
$dir = Aspis_dirname($plugin_file);
$plugin_files = array(array($plugin),false);
if ( (is_dir($dir[0]) && ($dir[0] != WP_PLUGIN_DIR)))
 {$plugins_dir = @attAspis(opendir($dir[0]));
if ( $plugins_dir[0])
 {while ( (deAspis(($file = attAspis(readdir($plugins_dir[0])))) !== false) )
{if ( (deAspis(Aspis_substr($file,array(0,false),array(1,false))) == ('.')))
 continue ;
if ( is_dir((deconcat(concat2($dir,'/'),$file))))
 {$plugins_subdir = @attAspis(opendir((deconcat(concat2($dir,'/'),$file))));
if ( $plugins_subdir[0])
 {while ( (deAspis(($subfile = attAspis(readdir($plugins_subdir[0])))) !== false) )
{if ( (deAspis(Aspis_substr($subfile,array(0,false),array(1,false))) == ('.')))
 continue ;
arrayAssignAdd($plugin_files[0][],addTaint(plugin_basename(concat(concat2(concat(concat2($dir,"/"),$file),"/"),$subfile))));
}@closedir($plugins_subdir[0]);
}}else 
{{if ( (deAspis(plugin_basename(concat(concat2($dir,"/"),$file))) != $plugin[0]))
 arrayAssignAdd($plugin_files[0][],addTaint(plugin_basename(concat(concat2($dir,"/"),$file))));
}}}@closedir($plugins_dir[0]);
}}return $plugin_files;
 }
function get_plugins ( $plugin_folder = array('',false) ) {
if ( (denot_boolean($cache_plugins = wp_cache_get(array('plugins',false),array('plugins',false)))))
 $cache_plugins = array(array(),false);
if ( ((isset($cache_plugins[0][$plugin_folder[0]]) && Aspis_isset( $cache_plugins [0][$plugin_folder[0]]))))
 return attachAspis($cache_plugins,$plugin_folder[0]);
$wp_plugins = array(array(),false);
$plugin_root = array(WP_PLUGIN_DIR,false);
if ( (!((empty($plugin_folder) || Aspis_empty( $plugin_folder)))))
 $plugin_root = concat($plugin_root,$plugin_folder);
$plugins_dir = @attAspis(opendir($plugin_root[0]));
$plugin_files = array(array(),false);
if ( $plugins_dir[0])
 {while ( (deAspis(($file = attAspis(readdir($plugins_dir[0])))) !== false) )
{if ( (deAspis(Aspis_substr($file,array(0,false),array(1,false))) == ('.')))
 continue ;
if ( is_dir((deconcat(concat2($plugin_root,'/'),$file))))
 {$plugins_subdir = @attAspis(opendir((deconcat(concat2($plugin_root,'/'),$file))));
if ( $plugins_subdir[0])
 {while ( (deAspis(($subfile = attAspis(readdir($plugins_subdir[0])))) !== false) )
{if ( (deAspis(Aspis_substr($subfile,array(0,false),array(1,false))) == ('.')))
 continue ;
if ( (deAspis(Aspis_substr($subfile,negate(array(4,false)))) == ('.php')))
 arrayAssignAdd($plugin_files[0][],addTaint(concat(concat2($file,"/"),$subfile)));
}}}else 
{{if ( (deAspis(Aspis_substr($file,negate(array(4,false)))) == ('.php')))
 arrayAssignAdd($plugin_files[0][],addTaint($file));
}}}}@closedir($plugins_dir[0]);
@closedir($plugins_subdir[0]);
if ( ((denot_boolean($plugins_dir)) || ((empty($plugin_files) || Aspis_empty( $plugin_files)))))
 return $wp_plugins;
foreach ( $plugin_files[0] as $plugin_file  )
{if ( (!(is_readable((deconcat(concat2($plugin_root,"/"),$plugin_file))))))
 continue ;
$plugin_data = get_plugin_data(concat(concat2($plugin_root,"/"),$plugin_file),array(false,false),array(false,false));
if ( ((empty($plugin_data[0][('Name')]) || Aspis_empty( $plugin_data [0][('Name')]))))
 continue ;
arrayAssign($wp_plugins[0],deAspis(registerTaint(plugin_basename($plugin_file))),addTaint($plugin_data));
}AspisInternalFunctionCall("uasort",AspisPushRefParam($wp_plugins),AspisInternalCallback(Aspis_create_function(array('$a, $b',false),array('return strnatcasecmp( $a["Name"], $b["Name"] );',false))),array(0));
arrayAssign($cache_plugins[0],deAspis(registerTaint($plugin_folder)),addTaint($wp_plugins));
wp_cache_set(array('plugins',false),$cache_plugins,array('plugins',false));
return $wp_plugins;
 }
function is_plugin_active ( $plugin ) {
return Aspis_in_array($plugin,apply_filters(array('active_plugins',false),get_option(array('active_plugins',false))));
 }
function activate_plugin ( $plugin,$redirect = array('',false) ) {
$current = get_option(array('active_plugins',false));
$plugin = plugin_basename(Aspis_trim($plugin));
$valid = validate_plugin($plugin);
if ( deAspis(is_wp_error($valid)))
 return $valid;
if ( (denot_boolean(Aspis_in_array($plugin,$current))))
 {if ( (!((empty($redirect) || Aspis_empty( $redirect)))))
 wp_redirect(add_query_arg(array('_error_nonce',false),wp_create_nonce(concat1('plugin-activation-error_',$plugin)),$redirect));
ob_start();
@include (deconcat(concat12(WP_PLUGIN_DIR,'/'),$plugin));
arrayAssignAdd($current[0][],addTaint($plugin));
AspisInternalFunctionCall("sort",AspisPushRefParam($current),array(0));
do_action(array('activate_plugin',false),Aspis_trim($plugin));
update_option(array('active_plugins',false),$current);
do_action(concat1('activate_',Aspis_trim($plugin)));
do_action(array('activated_plugin',false),Aspis_trim($plugin));
ob_end_clean();
}return array(null,false);
 }
function deactivate_plugins ( $plugins,$silent = array(false,false) ) {
$current = get_option(array('active_plugins',false));
if ( (!(is_array($plugins[0]))))
 $plugins = array(array($plugins),false);
foreach ( $plugins[0] as $plugin  )
{$plugin = plugin_basename($plugin);
if ( (denot_boolean(is_plugin_active($plugin))))
 continue ;
if ( (denot_boolean($silent)))
 do_action(array('deactivate_plugin',false),Aspis_trim($plugin));
$key = Aspis_array_search($plugin,array_cast($current));
if ( (false !== $key[0]))
 Aspis_array_splice($current,$key,array(1,false));
if ( (denot_boolean($silent)))
 {do_action(concat1('deactivate_',Aspis_trim($plugin)));
do_action(array('deactivated_plugin',false),Aspis_trim($plugin));
}}update_option(array('active_plugins',false),$current);
 }
function activate_plugins ( $plugins,$redirect = array('',false) ) {
if ( (!(is_array($plugins[0]))))
 $plugins = array(array($plugins),false);
$errors = array(array(),false);
foreach ( deAspis(array_cast($plugins)) as $plugin  )
{if ( (!((empty($redirect) || Aspis_empty( $redirect)))))
 $redirect = add_query_arg(array('plugin',false),$plugin,$redirect);
$result = activate_plugin($plugin,$redirect);
if ( deAspis(is_wp_error($result)))
 arrayAssign($errors[0],deAspis(registerTaint($plugin)),addTaint($result));
}if ( (!((empty($errors) || Aspis_empty( $errors)))))
 return array(new WP_Error(array('plugins_invalid',false),__(array('One of the plugins is invalid.',false)),$errors),false);
return array(true,false);
 }
function delete_plugins ( $plugins,$redirect = array('',false) ) {
global $wp_filesystem;
if ( ((empty($plugins) || Aspis_empty( $plugins))))
 return array(false,false);
$checked = array(array(),false);
foreach ( $plugins[0] as $plugin  )
arrayAssignAdd($checked[0][],addTaint(concat1('checked[]=',$plugin)));
ob_start();
$url = wp_nonce_url(concat1('plugins.php?action=delete-selected&verify-delete=1&',Aspis_implode(array('&',false),$checked)),array('bulk-manage-plugins',false));
if ( (false === deAspis(($credentials = request_filesystem_credentials($url)))))
 {$data = attAspis(ob_get_contents());
ob_end_clean();
if ( (!((empty($data) || Aspis_empty( $data)))))
 {include_once (deconcat12(ABSPATH,'wp-admin/admin-header.php'));
echo AspisCheckPrint($data);
include (deconcat12(ABSPATH,'wp-admin/admin-footer.php'));
Aspis_exit();
}return ;
}if ( (denot_boolean(WP_Filesystem($credentials))))
 {request_filesystem_credentials($url,array('',false),array(true,false));
$data = attAspis(ob_get_contents());
ob_end_clean();
if ( (!((empty($data) || Aspis_empty( $data)))))
 {include_once (deconcat12(ABSPATH,'wp-admin/admin-header.php'));
echo AspisCheckPrint($data);
include (deconcat12(ABSPATH,'wp-admin/admin-footer.php'));
Aspis_exit();
}return ;
}if ( (!(is_object($wp_filesystem[0]))))
 return array(new WP_Error(array('fs_unavailable',false),__(array('Could not access filesystem.',false))),false);
if ( (deAspis(is_wp_error($wp_filesystem[0]->errors)) && deAspis($wp_filesystem[0]->errors[0]->get_error_code())))
 return array(new WP_Error(array('fs_error',false),__(array('Filesystem error',false)),$wp_filesystem[0]->errors),false);
$plugins_dir = $wp_filesystem[0]->wp_plugins_dir();
if ( ((empty($plugins_dir) || Aspis_empty( $plugins_dir))))
 return array(new WP_Error(array('fs_no_plugins_dir',false),__(array('Unable to locate WordPress Plugin directory.',false))),false);
$plugins_dir = trailingslashit($plugins_dir);
$errors = array(array(),false);
foreach ( $plugins[0] as $plugin_file  )
{if ( deAspis(is_uninstallable_plugin($plugin_file)))
 uninstall_plugin($plugin_file);
$this_plugin_dir = trailingslashit(Aspis_dirname(concat($plugins_dir,$plugin_file)));
if ( (strpos($plugin_file[0],'/') && ($this_plugin_dir[0] != $plugins_dir[0])))
 $deleted = $wp_filesystem[0]->delete($this_plugin_dir,array(true,false));
else 
{$deleted = $wp_filesystem[0]->delete(concat($plugins_dir,$plugin_file));
}if ( (denot_boolean($deleted)))
 arrayAssignAdd($errors[0][],addTaint($plugin_file));
}if ( (!((empty($errors) || Aspis_empty( $errors)))))
 return array(new WP_Error(array('could_not_remove_plugin',false),Aspis_sprintf(__(array('Could not fully remove the plugin(s) %s',false)),Aspis_implode(array(', ',false),$errors))),false);
if ( deAspis($current = get_transient(array('update_plugins',false))))
 {unset($current[0]->response[0][$plugin_file[0]]);
set_transient(array('update_plugins',false),$current);
}return array(true,false);
 }
function validate_active_plugins (  ) {
$check_plugins = apply_filters(array('active_plugins',false),get_option(array('active_plugins',false)));
if ( (!(is_array($check_plugins[0]))))
 {update_option(array('active_plugins',false),array(array(),false));
return ;
}$invalid = array(array(),false);
foreach ( $check_plugins[0] as $check_plugin  )
{$result = validate_plugin($check_plugin);
if ( deAspis(is_wp_error($result)))
 {arrayAssign($invalid[0],deAspis(registerTaint($check_plugin)),addTaint($result));
deactivate_plugins($check_plugin,array(true,false));
}}return $invalid;
 }
function validate_plugin ( $plugin ) {
if ( deAspis(validate_file($plugin)))
 return array(new WP_Error(array('plugin_invalid',false),__(array('Invalid plugin path.',false))),false);
if ( (!(file_exists((deconcat(concat12(WP_PLUGIN_DIR,'/'),$plugin))))))
 return array(new WP_Error(array('plugin_not_found',false),__(array('Plugin file does not exist.',false))),false);
$installed_plugins = get_plugins();
if ( (!((isset($installed_plugins[0][$plugin[0]]) && Aspis_isset( $installed_plugins [0][$plugin[0]])))))
 return array(new WP_Error(array('no_plugin_header',false),__(array('The plugin does not have a valid header.',false))),false);
return array(0,false);
 }
function is_uninstallable_plugin ( $plugin ) {
$file = plugin_basename($plugin);
$uninstallable_plugins = array_cast(get_option(array('uninstall_plugins',false)));
if ( (((isset($uninstallable_plugins[0][$file[0]]) && Aspis_isset( $uninstallable_plugins [0][$file[0]]))) || file_exists((deconcat2(concat(concat12(WP_PLUGIN_DIR,'/'),Aspis_dirname($file)),'/uninstall.php')))))
 return array(true,false);
return array(false,false);
 }
function uninstall_plugin ( $plugin ) {
$file = plugin_basename($plugin);
$uninstallable_plugins = array_cast(get_option(array('uninstall_plugins',false)));
if ( file_exists((deconcat2(concat(concat12(WP_PLUGIN_DIR,'/'),Aspis_dirname($file)),'/uninstall.php'))))
 {if ( ((isset($uninstallable_plugins[0][$file[0]]) && Aspis_isset( $uninstallable_plugins [0][$file[0]]))))
 {unset($uninstallable_plugins[0][$file[0]]);
update_option(array('uninstall_plugins',false),$uninstallable_plugins);
}unset($uninstallable_plugins);
define(('WP_UNINSTALL_PLUGIN'),deAspisRC($file));
include (deconcat2(concat(concat12(WP_PLUGIN_DIR,'/'),Aspis_dirname($file)),'/uninstall.php'));
return array(true,false);
}if ( ((isset($uninstallable_plugins[0][$file[0]]) && Aspis_isset( $uninstallable_plugins [0][$file[0]]))))
 {$callable = attachAspis($uninstallable_plugins,$file[0]);
unset($uninstallable_plugins[0][$file[0]]);
update_option(array('uninstall_plugins',false),$uninstallable_plugins);
unset($uninstallable_plugins);
include (deconcat(concat12(WP_PLUGIN_DIR,'/'),$file));
add_action(concat1('uninstall_',$file),$callable);
do_action(concat1('uninstall_',$file));
} }
function add_menu_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false),$icon_url = array('',false),$position = array(NULL,false) ) {
global $menu,$admin_page_hooks,$_registered_pages;
$file = plugin_basename($file);
arrayAssign($admin_page_hooks[0],deAspis(registerTaint($file)),addTaint(sanitize_title($menu_title)));
$hookname = get_plugin_page_hookname($file,array('',false));
if ( (((!((empty($function) || Aspis_empty( $function)))) && (!((empty($hookname) || Aspis_empty( $hookname))))) && deAspis(current_user_can($access_level))))
 add_action($hookname,$function);
if ( ((empty($icon_url) || Aspis_empty( $icon_url))))
 {$icon_url = array('images/generic.png',false);
}elseif ( (deAspis(is_ssl()) && ((0) === strpos($icon_url[0],'http://'))))
 {$icon_url = concat1('https://',Aspis_substr($icon_url,array(7,false)));
}$new_menu = array(array($menu_title,$access_level,$file,$page_title,concat1('menu-top ',$hookname),$hookname,$icon_url),false);
if ( (NULL === $position[0]))
 {arrayAssignAdd($menu[0][],addTaint($new_menu));
}else 
{{arrayAssign($menu[0],deAspis(registerTaint($position)),addTaint($new_menu));
}}arrayAssign($_registered_pages[0],deAspis(registerTaint($hookname)),addTaint(array(true,false)));
return $hookname;
 }
function add_object_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false),$icon_url = array('',false) ) {
global $_wp_last_object_menu;
postincr($_wp_last_object_menu);
return add_menu_page($page_title,$menu_title,$access_level,$file,$function,$icon_url,$_wp_last_object_menu);
 }
function add_utility_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false),$icon_url = array('',false) ) {
global $_wp_last_utility_menu;
postincr($_wp_last_utility_menu);
return add_menu_page($page_title,$menu_title,$access_level,$file,$function,$icon_url,$_wp_last_utility_menu);
 }
function add_submenu_page ( $parent,$page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
global $submenu;
global $menu;
global $_wp_real_parent_file;
global $_wp_submenu_nopriv;
global $_registered_pages;
$file = plugin_basename($file);
$parent = plugin_basename($parent);
if ( ((isset($_wp_real_parent_file[0][$parent[0]]) && Aspis_isset( $_wp_real_parent_file [0][$parent[0]]))))
 $parent = attachAspis($_wp_real_parent_file,$parent[0]);
if ( (denot_boolean(current_user_can($access_level))))
 {arrayAssign($_wp_submenu_nopriv[0][$parent[0]][0],deAspis(registerTaint($file)),addTaint(array(true,false)));
return array(false,false);
}if ( ((!((isset($submenu[0][$parent[0]]) && Aspis_isset( $submenu [0][$parent[0]])))) && ($file[0] != $parent[0])))
 {foreach ( deAspis(array_cast($menu)) as $parent_menu  )
{if ( ((deAspis(attachAspis($parent_menu,(2))) == $parent[0]) && deAspis(current_user_can(attachAspis($parent_menu,(1))))))
 arrayAssignAdd($submenu[0][$parent[0]][0][],addTaint($parent_menu));
}}arrayAssignAdd($submenu[0][$parent[0]][0][],addTaint(array(array($menu_title,$access_level,$file,$page_title),false)));
$hookname = get_plugin_page_hookname($file,$parent);
if ( ((!((empty($function) || Aspis_empty( $function)))) && (!((empty($hookname) || Aspis_empty( $hookname))))))
 add_action($hookname,$function);
arrayAssign($_registered_pages[0],deAspis(registerTaint($hookname)),addTaint(array(true,false)));
if ( (('tools.php') == $parent[0]))
 arrayAssign($_registered_pages[0],deAspis(registerTaint(get_plugin_page_hookname($file,array('edit.php',false)))),addTaint(array(true,false)));
return $hookname;
 }
function add_management_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
return add_submenu_page(array('tools.php',false),$page_title,$menu_title,$access_level,$file,$function);
 }
function add_options_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
return add_submenu_page(array('options-general.php',false),$page_title,$menu_title,$access_level,$file,$function);
 }
function add_theme_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
return add_submenu_page(array('themes.php',false),$page_title,$menu_title,$access_level,$file,$function);
 }
function add_users_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
if ( deAspis(current_user_can(array('edit_users',false))))
 $parent = array('users.php',false);
else 
{$parent = array('profile.php',false);
}return add_submenu_page($parent,$page_title,$menu_title,$access_level,$file,$function);
 }
function add_dashboard_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
return add_submenu_page(array('index.php',false),$page_title,$menu_title,$access_level,$file,$function);
 }
function add_posts_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
return add_submenu_page(array('edit.php',false),$page_title,$menu_title,$access_level,$file,$function);
 }
function add_media_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
return add_submenu_page(array('upload.php',false),$page_title,$menu_title,$access_level,$file,$function);
 }
function add_links_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
return add_submenu_page(array('link-manager.php',false),$page_title,$menu_title,$access_level,$file,$function);
 }
function add_pages_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
return add_submenu_page(array('edit-pages.php',false),$page_title,$menu_title,$access_level,$file,$function);
 }
function add_comments_page ( $page_title,$menu_title,$access_level,$file,$function = array('',false) ) {
return add_submenu_page(array('edit-comments.php',false),$page_title,$menu_title,$access_level,$file,$function);
 }
function get_admin_page_parent ( $parent = array('',false) ) {
global $parent_file;
global $menu;
global $submenu;
global $pagenow;
global $plugin_page;
global $_wp_real_parent_file;
global $_wp_menu_nopriv;
global $_wp_submenu_nopriv;
if ( ((!((empty($parent) || Aspis_empty( $parent)))) && (('admin.php') != $parent[0])))
 {if ( ((isset($_wp_real_parent_file[0][$parent[0]]) && Aspis_isset( $_wp_real_parent_file [0][$parent[0]]))))
 $parent = attachAspis($_wp_real_parent_file,$parent[0]);
return $parent;
}if ( (($pagenow[0] == ('admin.php')) && ((isset($plugin_page) && Aspis_isset( $plugin_page)))))
 {foreach ( deAspis(array_cast($menu)) as $parent_menu  )
{if ( (deAspis(attachAspis($parent_menu,(2))) == $plugin_page[0]))
 {$parent_file = $plugin_page;
if ( ((isset($_wp_real_parent_file[0][$parent_file[0]]) && Aspis_isset( $_wp_real_parent_file [0][$parent_file[0]]))))
 $parent_file = attachAspis($_wp_real_parent_file,$parent_file[0]);
return $parent_file;
}}if ( ((isset($_wp_menu_nopriv[0][$plugin_page[0]]) && Aspis_isset( $_wp_menu_nopriv [0][$plugin_page[0]]))))
 {$parent_file = $plugin_page;
if ( ((isset($_wp_real_parent_file[0][$parent_file[0]]) && Aspis_isset( $_wp_real_parent_file [0][$parent_file[0]]))))
 $parent_file = attachAspis($_wp_real_parent_file,$parent_file[0]);
return $parent_file;
}}if ( (((isset($plugin_page) && Aspis_isset( $plugin_page))) && ((isset($_wp_submenu_nopriv[0][$pagenow[0]][0][$plugin_page[0]]) && Aspis_isset( $_wp_submenu_nopriv [0][$pagenow[0]] [0][$plugin_page[0]])))))
 {$parent_file = $pagenow;
if ( ((isset($_wp_real_parent_file[0][$parent_file[0]]) && Aspis_isset( $_wp_real_parent_file [0][$parent_file[0]]))))
 $parent_file = attachAspis($_wp_real_parent_file,$parent_file[0]);
return $parent_file;
}foreach ( deAspis(attAspisRC(array_keys(deAspisRC(array_cast($submenu))))) as $parent  )
{foreach ( deAspis(attachAspis($submenu,$parent[0])) as $submenu_array  )
{if ( ((isset($_wp_real_parent_file[0][$parent[0]]) && Aspis_isset( $_wp_real_parent_file [0][$parent[0]]))))
 $parent = attachAspis($_wp_real_parent_file,$parent[0]);
if ( (deAspis(attachAspis($submenu_array,(2))) == $pagenow[0]))
 {$parent_file = $parent;
return $parent;
}else 
{if ( (((isset($plugin_page) && Aspis_isset( $plugin_page))) && ($plugin_page[0] == deAspis(attachAspis($submenu_array,(2))))))
 {$parent_file = $parent;
return $parent;
}}}}if ( ((empty($parent_file) || Aspis_empty( $parent_file))))
 $parent_file = array('',false);
return array('',false);
 }
function get_admin_page_title (  ) {
global $title;
global $menu;
global $submenu;
global $pagenow;
global $plugin_page;
if ( (((isset($title) && Aspis_isset( $title))) && (!((empty($title) || Aspis_empty( $title))))))
 {return $title;
}$hook = get_plugin_page_hook($plugin_page,$pagenow);
$parent = $parent1 = get_admin_page_parent();
if ( ((empty($parent) || Aspis_empty( $parent))))
 {foreach ( deAspis(array_cast($menu)) as $menu_array  )
{if ( ((isset($menu_array[0][(3)]) && Aspis_isset( $menu_array [0][(3)]))))
 {if ( (deAspis(attachAspis($menu_array,(2))) == $pagenow[0]))
 {$title = attachAspis($menu_array,(3));
return attachAspis($menu_array,(3));
}else 
{if ( ((((isset($plugin_page) && Aspis_isset( $plugin_page))) && ($plugin_page[0] == deAspis(attachAspis($menu_array,(2))))) && ($hook[0] == deAspis(attachAspis($menu_array,(3))))))
 {$title = attachAspis($menu_array,(3));
return attachAspis($menu_array,(3));
}}}else 
{{$title = attachAspis($menu_array,(0));
return $title;
}}}}else 
{{foreach ( deAspis(attAspisRC(array_keys(deAspisRC($submenu)))) as $parent  )
{foreach ( deAspis(attachAspis($submenu,$parent[0])) as $submenu_array  )
{if ( ((((isset($plugin_page) && Aspis_isset( $plugin_page))) && ($plugin_page[0] == deAspis(attachAspis($submenu_array,(2))))) && (((($parent[0] == $pagenow[0]) || ($parent[0] == $plugin_page[0])) || ($plugin_page[0] == $hook[0])) || (($pagenow[0] == ('admin.php')) && ($parent1[0] != deAspis(attachAspis($submenu_array,(2))))))))
 {$title = attachAspis($submenu_array,(3));
return attachAspis($submenu_array,(3));
}if ( ((deAspis(attachAspis($submenu_array,(2))) != $pagenow[0]) || ((isset($_GET[0][('page')]) && Aspis_isset( $_GET [0][('page')])))))
 continue ;
if ( ((isset($submenu_array[0][(3)]) && Aspis_isset( $submenu_array [0][(3)]))))
 {$title = attachAspis($submenu_array,(3));
return attachAspis($submenu_array,(3));
}else 
{{$title = attachAspis($submenu_array,(0));
return $title;
}}}}if ( ((!((isset($title) && Aspis_isset( $title)))) || ((empty($title) || Aspis_empty( $title)))))
 {foreach ( $menu[0] as $menu_array  )
{if ( (((((isset($plugin_page) && Aspis_isset( $plugin_page))) && ($plugin_page[0] == deAspis(attachAspis($menu_array,(2))))) && ($pagenow[0] == ('admin.php'))) && ($parent1[0] == deAspis(attachAspis($menu_array,(2))))))
 {$title = attachAspis($menu_array,(3));
return attachAspis($menu_array,(3));
}}}}}return $title;
 }
function get_plugin_page_hook ( $plugin_page,$parent_page ) {
$hook = get_plugin_page_hookname($plugin_page,$parent_page);
if ( deAspis(has_action($hook)))
 return $hook;
else 
{return array(null,false);
} }
function get_plugin_page_hookname ( $plugin_page,$parent_page ) {
global $admin_page_hooks;
$parent = get_admin_page_parent($parent_page);
$page_type = array('admin',false);
if ( ((((empty($parent_page) || Aspis_empty( $parent_page))) || (('admin.php') == $parent_page[0])) || ((isset($admin_page_hooks[0][$plugin_page[0]]) && Aspis_isset( $admin_page_hooks [0][$plugin_page[0]])))))
 {if ( ((isset($admin_page_hooks[0][$plugin_page[0]]) && Aspis_isset( $admin_page_hooks [0][$plugin_page[0]]))))
 $page_type = array('toplevel',false);
else 
{if ( ((isset($admin_page_hooks[0][$parent[0]]) && Aspis_isset( $admin_page_hooks [0][$parent[0]]))))
 $page_type = attachAspis($admin_page_hooks,$parent[0]);
}}else 
{if ( ((isset($admin_page_hooks[0][$parent[0]]) && Aspis_isset( $admin_page_hooks [0][$parent[0]]))))
 {$page_type = attachAspis($admin_page_hooks,$parent[0]);
}}$plugin_name = Aspis_preg_replace(array('!\.php!',false),array('',false),$plugin_page);
return concat(concat2($page_type,'_page_'),$plugin_name);
 }
function user_can_access_admin_page (  ) {
global $pagenow;
global $menu;
global $submenu;
global $_wp_menu_nopriv;
global $_wp_submenu_nopriv;
global $plugin_page;
global $_registered_pages;
$parent = get_admin_page_parent();
if ( ((!((isset($plugin_page) && Aspis_isset( $plugin_page)))) && ((isset($_wp_submenu_nopriv[0][$parent[0]][0][$pagenow[0]]) && Aspis_isset( $_wp_submenu_nopriv [0][$parent[0]] [0][$pagenow[0]])))))
 return array(false,false);
if ( ((isset($plugin_page) && Aspis_isset( $plugin_page))))
 {if ( ((isset($_wp_submenu_nopriv[0][$parent[0]][0][$plugin_page[0]]) && Aspis_isset( $_wp_submenu_nopriv [0][$parent[0]] [0][$plugin_page[0]]))))
 return array(false,false);
$hookname = get_plugin_page_hookname($plugin_page,$parent);
if ( (!((isset($_registered_pages[0][$hookname[0]]) && Aspis_isset( $_registered_pages [0][$hookname[0]])))))
 return array(false,false);
}if ( ((empty($parent) || Aspis_empty( $parent))))
 {if ( ((isset($_wp_menu_nopriv[0][$pagenow[0]]) && Aspis_isset( $_wp_menu_nopriv [0][$pagenow[0]]))))
 return array(false,false);
if ( ((isset($_wp_submenu_nopriv[0][$pagenow[0]][0][$pagenow[0]]) && Aspis_isset( $_wp_submenu_nopriv [0][$pagenow[0]] [0][$pagenow[0]]))))
 return array(false,false);
if ( (((isset($plugin_page) && Aspis_isset( $plugin_page))) && ((isset($_wp_submenu_nopriv[0][$pagenow[0]][0][$plugin_page[0]]) && Aspis_isset( $_wp_submenu_nopriv [0][$pagenow[0]] [0][$plugin_page[0]])))))
 return array(false,false);
if ( (((isset($plugin_page) && Aspis_isset( $plugin_page))) && ((isset($_wp_menu_nopriv[0][$plugin_page[0]]) && Aspis_isset( $_wp_menu_nopriv [0][$plugin_page[0]])))))
 return array(false,false);
foreach ( deAspis(attAspisRC(array_keys(deAspisRC($_wp_submenu_nopriv)))) as $key  )
{if ( ((isset($_wp_submenu_nopriv[0][$key[0]][0][$pagenow[0]]) && Aspis_isset( $_wp_submenu_nopriv [0][$key[0]] [0][$pagenow[0]]))))
 return array(false,false);
if ( (((isset($plugin_page) && Aspis_isset( $plugin_page))) && ((isset($_wp_submenu_nopriv[0][$key[0]][0][$plugin_page[0]]) && Aspis_isset( $_wp_submenu_nopriv [0][$key[0]] [0][$plugin_page[0]])))))
 return array(false,false);
}return array(true,false);
}if ( ((((isset($plugin_page) && Aspis_isset( $plugin_page))) && ($plugin_page[0] == $parent[0])) && ((isset($_wp_menu_nopriv[0][$plugin_page[0]]) && Aspis_isset( $_wp_menu_nopriv [0][$plugin_page[0]])))))
 return array(false,false);
if ( ((isset($submenu[0][$parent[0]]) && Aspis_isset( $submenu [0][$parent[0]]))))
 {foreach ( deAspis(attachAspis($submenu,$parent[0])) as $submenu_array  )
{if ( (((isset($plugin_page) && Aspis_isset( $plugin_page))) && (deAspis(attachAspis($submenu_array,(2))) == $plugin_page[0])))
 {if ( deAspis(current_user_can(attachAspis($submenu_array,(1)))))
 return array(true,false);
else 
{return array(false,false);
}}else 
{if ( (deAspis(attachAspis($submenu_array,(2))) == $pagenow[0]))
 {if ( deAspis(current_user_can(attachAspis($submenu_array,(1)))))
 return array(true,false);
else 
{return array(false,false);
}}}}}foreach ( $menu[0] as $menu_array  )
{if ( (deAspis(attachAspis($menu_array,(2))) == $parent[0]))
 {if ( deAspis(current_user_can(attachAspis($menu_array,(1)))))
 return array(true,false);
else 
{return array(false,false);
}}}return array(true,false);
 }
function register_setting ( $option_group,$option_name,$sanitize_callback = array('',false) ) {
return add_option_update_handler($option_group,$option_name,$sanitize_callback);
 }
function unregister_setting ( $option_group,$option_name,$sanitize_callback = array('',false) ) {
return remove_option_update_handler($option_group,$option_name,$sanitize_callback);
 }
function add_option_update_handler ( $option_group,$option_name,$sanitize_callback = array('',false) ) {
global $new_whitelist_options;
arrayAssignAdd($new_whitelist_options[0][$option_group[0]][0][],addTaint($option_name));
if ( ($sanitize_callback[0] != ('')))
 add_filter(concat1("sanitize_option_",$option_name),$sanitize_callback);
 }
function remove_option_update_handler ( $option_group,$option_name,$sanitize_callback = array('',false) ) {
global $new_whitelist_options;
$pos = Aspis_array_search($option_name,array_cast($new_whitelist_options));
if ( ($pos[0] !== false))
 unset($new_whitelist_options[0][$option_group[0]][0][$pos[0]]);
if ( ($sanitize_callback[0] != ('')))
 remove_filter(concat1("sanitize_option_",$option_name),$sanitize_callback);
 }
function option_update_filter ( $options ) {
global $new_whitelist_options;
if ( is_array($new_whitelist_options[0]))
 $options = add_option_whitelist($new_whitelist_options,$options);
return $options;
 }
add_filter(array('whitelist_options',false),array('option_update_filter',false));
function add_option_whitelist ( $new_options,$options = array('',false) ) {
if ( ($options[0] == ('')))
 {global $whitelist_options;
}else 
{{$whitelist_options = $options;
}}foreach ( $new_options[0] as $page =>$keys )
{restoreTaint($page,$keys);
{foreach ( $keys[0] as $key  )
{if ( ((!((isset($whitelist_options[0][$page[0]]) && Aspis_isset( $whitelist_options [0][$page[0]])))) || (!(is_array(deAspis(attachAspis($whitelist_options,$page[0])))))))
 {arrayAssign($whitelist_options[0],deAspis(registerTaint($page)),addTaint(array(array(),false)));
arrayAssignAdd($whitelist_options[0][$page[0]][0][],addTaint($key));
}else 
{{$pos = Aspis_array_search($key,attachAspis($whitelist_options,$page[0]));
if ( ($pos[0] === false))
 arrayAssignAdd($whitelist_options[0][$page[0]][0][],addTaint($key));
}}}}}return $whitelist_options;
 }
function remove_option_whitelist ( $del_options,$options = array('',false) ) {
if ( ($options[0] == ('')))
 {global $whitelist_options;
}else 
{{$whitelist_options = $options;
}}foreach ( $del_options[0] as $page =>$keys )
{restoreTaint($page,$keys);
{foreach ( $keys[0] as $key  )
{if ( (((isset($whitelist_options[0][$page[0]]) && Aspis_isset( $whitelist_options [0][$page[0]]))) && is_array(deAspis(attachAspis($whitelist_options,$page[0])))))
 {$pos = Aspis_array_search($key,attachAspis($whitelist_options,$page[0]));
if ( ($pos[0] !== false))
 unset($whitelist_options[0][$page[0]][0][$pos[0]]);
}}}}return $whitelist_options;
 }
function settings_fields ( $option_group ) {
echo AspisCheckPrint(concat2(concat1("<input type='hidden' name='option_page' value='",esc_attr($option_group)),"' />"));
echo AspisCheckPrint(array('<input type="hidden" name="action" value="update" />',false));
wp_nonce_field(concat2($option_group,"-options"));
 }
;
?>
<?php 