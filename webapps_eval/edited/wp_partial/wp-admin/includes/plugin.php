<?php require_once('AspisMain.php'); ?><?php
function get_plugin_data ( $plugin_file,$markup = true,$translate = true ) {
$default_headers = array('Name' => 'Plugin Name','PluginURI' => 'Plugin URI','Version' => 'Version','Description' => 'Description','Author' => 'Author','AuthorURI' => 'Author URI','TextDomain' => 'Text Domain','DomainPath' => 'Domain Path');
$plugin_data = get_file_data($plugin_file,$default_headers,'plugin');
$plugin_data['Title'] = $plugin_data['Name'];
if ( $markup || $translate)
 $plugin_data = _get_plugin_data_markup_translate($plugin_file,$plugin_data,$markup,$translate);
{$AspisRetTemp = $plugin_data;
return $AspisRetTemp;
} }
function _get_plugin_data_markup_translate ( $plugin_file,$plugin_data,$markup = true,$translate = true ) {
if ( $translate && !empty($plugin_data['TextDomain']))
 {if ( !empty($plugin_data['DomainPath']))
 load_plugin_textdomain($plugin_data['TextDomain'],false,dirname($plugin_file) . $plugin_data['DomainPath']);
else 
{load_plugin_textdomain($plugin_data['TextDomain'],false,dirname($plugin_file));
}foreach ( array('Name','PluginURI','Description','Author','AuthorURI','Version') as $field  )
$plugin_data[$field] = translate($plugin_data[$field],$plugin_data['TextDomain']);
}if ( $markup)
 {if ( !empty($plugin_data['PluginURI']) && !empty($plugin_data['Name']))
 $plugin_data['Title'] = '<a href="' . $plugin_data['PluginURI'] . '" title="' . __('Visit plugin homepage') . '">' . $plugin_data['Name'] . '</a>';
else 
{$plugin_data['Title'] = $plugin_data['Name'];
}if ( !empty($plugin_data['AuthorURI']) && !empty($plugin_data['Author']))
 $plugin_data['Author'] = '<a href="' . $plugin_data['AuthorURI'] . '" title="' . __('Visit author homepage') . '">' . $plugin_data['Author'] . '</a>';
$plugin_data['Description'] = wptexturize($plugin_data['Description']);
if ( !empty($plugin_data['Author']))
 $plugin_data['Description'] .= ' <cite>' . sprintf(__('By %s'),$plugin_data['Author']) . '.</cite>';
}$plugins_allowedtags = array('a' => array('href' => array(),'title' => array()),'abbr' => array('title' => array()),'acronym' => array('title' => array()),'code' => array(),'em' => array(),'strong' => array());
$plugin_data['Title'] = wp_kses($plugin_data['Title'],$plugins_allowedtags);
$plugin_data['Version'] = wp_kses($plugin_data['Version'],$plugins_allowedtags);
$plugin_data['Description'] = wp_kses($plugin_data['Description'],$plugins_allowedtags);
$plugin_data['Author'] = wp_kses($plugin_data['Author'],$plugins_allowedtags);
{$AspisRetTemp = $plugin_data;
return $AspisRetTemp;
} }
function get_plugin_files ( $plugin ) {
$plugin_file = WP_PLUGIN_DIR . '/' . $plugin;
$dir = dirname($plugin_file);
$plugin_files = array($plugin);
if ( is_dir($dir) && $dir != WP_PLUGIN_DIR)
 {$plugins_dir = @opendir($dir);
if ( $plugins_dir)
 {while ( ($file = readdir($plugins_dir)) !== false )
{if ( substr($file,0,1) == '.')
 continue ;
if ( is_dir($dir . '/' . $file))
 {$plugins_subdir = @opendir($dir . '/' . $file);
if ( $plugins_subdir)
 {while ( ($subfile = readdir($plugins_subdir)) !== false )
{if ( substr($subfile,0,1) == '.')
 continue ;
$plugin_files[] = plugin_basename("$dir/$file/$subfile");
}@closedir($plugins_subdir);
}}else 
{{if ( plugin_basename("$dir/$file") != $plugin)
 $plugin_files[] = plugin_basename("$dir/$file");
}}}@closedir($plugins_dir);
}}{$AspisRetTemp = $plugin_files;
return $AspisRetTemp;
} }
function get_plugins ( $plugin_folder = '' ) {
if ( !$cache_plugins = wp_cache_get('plugins','plugins'))
 $cache_plugins = array();
if ( isset($cache_plugins[$plugin_folder]))
 {$AspisRetTemp = $cache_plugins[$plugin_folder];
return $AspisRetTemp;
}$wp_plugins = array();
$plugin_root = WP_PLUGIN_DIR;
if ( !empty($plugin_folder))
 $plugin_root .= $plugin_folder;
$plugins_dir = @opendir($plugin_root);
$plugin_files = array();
if ( $plugins_dir)
 {while ( ($file = readdir($plugins_dir)) !== false )
{if ( substr($file,0,1) == '.')
 continue ;
if ( is_dir($plugin_root . '/' . $file))
 {$plugins_subdir = @opendir($plugin_root . '/' . $file);
if ( $plugins_subdir)
 {while ( ($subfile = readdir($plugins_subdir)) !== false )
{if ( substr($subfile,0,1) == '.')
 continue ;
if ( substr($subfile,-4) == '.php')
 $plugin_files[] = "$file/$subfile";
}}}else 
{{if ( substr($file,-4) == '.php')
 $plugin_files[] = $file;
}}}}@closedir($plugins_dir);
@closedir($plugins_subdir);
if ( !$plugins_dir || empty($plugin_files))
 {$AspisRetTemp = $wp_plugins;
return $AspisRetTemp;
}foreach ( $plugin_files as $plugin_file  )
{if ( !is_readable("$plugin_root/$plugin_file"))
 continue ;
$plugin_data = get_plugin_data("$plugin_root/$plugin_file",false,false);
if ( empty($plugin_data['Name']))
 continue ;
$wp_plugins[plugin_basename($plugin_file)] = $plugin_data;
}uasort($wp_plugins,create_function('$a, $b','return strnatcasecmp( $a["Name"], $b["Name"] );'));
$cache_plugins[$plugin_folder] = $wp_plugins;
wp_cache_set('plugins',$cache_plugins,'plugins');
{$AspisRetTemp = $wp_plugins;
return $AspisRetTemp;
} }
function is_plugin_active ( $plugin ) {
{$AspisRetTemp = in_array($plugin,apply_filters('active_plugins',get_option('active_plugins')));
return $AspisRetTemp;
} }
function activate_plugin ( $plugin,$redirect = '' ) {
$current = get_option('active_plugins');
$plugin = plugin_basename(trim($plugin));
$valid = validate_plugin($plugin);
if ( is_wp_error($valid))
 {$AspisRetTemp = $valid;
return $AspisRetTemp;
}if ( !in_array($plugin,$current))
 {if ( !empty($redirect))
 wp_redirect(add_query_arg('_error_nonce',wp_create_nonce('plugin-activation-error_' . $plugin),$redirect));
ob_start();
@include (WP_PLUGIN_DIR . '/' . $plugin);
$current[] = $plugin;
sort($current);
do_action('activate_plugin',trim($plugin));
update_option('active_plugins',$current);
do_action('activate_' . trim($plugin));
do_action('activated_plugin',trim($plugin));
ob_end_clean();
}{$AspisRetTemp = null;
return $AspisRetTemp;
} }
function deactivate_plugins ( $plugins,$silent = false ) {
$current = get_option('active_plugins');
if ( !is_array($plugins))
 $plugins = array($plugins);
foreach ( $plugins as $plugin  )
{$plugin = plugin_basename($plugin);
if ( !is_plugin_active($plugin))
 continue ;
if ( !$silent)
 do_action('deactivate_plugin',trim($plugin));
$key = array_search($plugin,(array)$current);
if ( false !== $key)
 array_splice($current,$key,1);
if ( !$silent)
 {do_action('deactivate_' . trim($plugin));
do_action('deactivated_plugin',trim($plugin));
}}update_option('active_plugins',$current);
 }
function activate_plugins ( $plugins,$redirect = '' ) {
if ( !is_array($plugins))
 $plugins = array($plugins);
$errors = array();
foreach ( (array)$plugins as $plugin  )
{if ( !empty($redirect))
 $redirect = add_query_arg('plugin',$plugin,$redirect);
$result = activate_plugin($plugin,$redirect);
if ( is_wp_error($result))
 $errors[$plugin] = $result;
}if ( !empty($errors))
 {$AspisRetTemp = new WP_Error('plugins_invalid',__('One of the plugins is invalid.'),$errors);
return $AspisRetTemp;
}{$AspisRetTemp = true;
return $AspisRetTemp;
} }
function delete_plugins ( $plugins,$redirect = '' ) {
{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}if ( empty($plugins))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$checked = array();
foreach ( $plugins as $plugin  )
$checked[] = 'checked[]=' . $plugin;
ob_start();
$url = wp_nonce_url('plugins.php?action=delete-selected&verify-delete=1&' . implode('&',$checked),'bulk-manage-plugins');
if ( false === ($credentials = request_filesystem_credentials($url)))
 {$data = ob_get_contents();
ob_end_clean();
if ( !empty($data))
 {include_once (ABSPATH . 'wp-admin/admin-header.php');
echo $data;
include (ABSPATH . 'wp-admin/admin-footer.php');
exit();
}{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return ;
}}if ( !WP_Filesystem($credentials))
 {request_filesystem_credentials($url,'',true);
$data = ob_get_contents();
ob_end_clean();
if ( !empty($data))
 {include_once (ABSPATH . 'wp-admin/admin-header.php');
echo $data;
include (ABSPATH . 'wp-admin/admin-footer.php');
exit();
}{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return ;
}}if ( !is_object($wp_filesystem))
 {$AspisRetTemp = new WP_Error('fs_unavailable',__('Could not access filesystem.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->get_error_code())
 {$AspisRetTemp = new WP_Error('fs_error',__('Filesystem error'),$wp_filesystem->errors);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$plugins_dir = $wp_filesystem->wp_plugins_dir();
if ( empty($plugins_dir))
 {$AspisRetTemp = new WP_Error('fs_no_plugins_dir',__('Unable to locate WordPress Plugin directory.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$plugins_dir = trailingslashit($plugins_dir);
$errors = array();
foreach ( $plugins as $plugin_file  )
{if ( is_uninstallable_plugin($plugin_file))
 uninstall_plugin($plugin_file);
$this_plugin_dir = trailingslashit(dirname($plugins_dir . $plugin_file));
if ( strpos($plugin_file,'/') && $this_plugin_dir != $plugins_dir)
 $deleted = $wp_filesystem->delete($this_plugin_dir,true);
else 
{$deleted = $wp_filesystem->delete($plugins_dir . $plugin_file);
}if ( !$deleted)
 $errors[] = $plugin_file;
}if ( !empty($errors))
 {$AspisRetTemp = new WP_Error('could_not_remove_plugin',sprintf(__('Could not fully remove the plugin(s) %s'),implode(', ',$errors)));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( $current = get_transient('update_plugins'))
 {unset($current->response[$plugin_file]);
set_transient('update_plugins',$current);
}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
function validate_active_plugins (  ) {
$check_plugins = apply_filters('active_plugins',get_option('active_plugins'));
if ( !is_array($check_plugins))
 {update_option('active_plugins',array());
{return ;
}}$invalid = array();
foreach ( $check_plugins as $check_plugin  )
{$result = validate_plugin($check_plugin);
if ( is_wp_error($result))
 {$invalid[$check_plugin] = $result;
deactivate_plugins($check_plugin,true);
}}{$AspisRetTemp = $invalid;
return $AspisRetTemp;
} }
function validate_plugin ( $plugin ) {
if ( validate_file($plugin))
 {$AspisRetTemp = new WP_Error('plugin_invalid',__('Invalid plugin path.'));
return $AspisRetTemp;
}if ( !file_exists(WP_PLUGIN_DIR . '/' . $plugin))
 {$AspisRetTemp = new WP_Error('plugin_not_found',__('Plugin file does not exist.'));
return $AspisRetTemp;
}$installed_plugins = get_plugins();
if ( !isset($installed_plugins[$plugin]))
 {$AspisRetTemp = new WP_Error('no_plugin_header',__('The plugin does not have a valid header.'));
return $AspisRetTemp;
}{$AspisRetTemp = 0;
return $AspisRetTemp;
} }
function is_uninstallable_plugin ( $plugin ) {
$file = plugin_basename($plugin);
$uninstallable_plugins = (array)get_option('uninstall_plugins');
if ( isset($uninstallable_plugins[$file]) || file_exists(WP_PLUGIN_DIR . '/' . dirname($file) . '/uninstall.php'))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function uninstall_plugin ( $plugin ) {
$file = plugin_basename($plugin);
$uninstallable_plugins = (array)get_option('uninstall_plugins');
if ( file_exists(WP_PLUGIN_DIR . '/' . dirname($file) . '/uninstall.php'))
 {if ( isset($uninstallable_plugins[$file]))
 {unset($uninstallable_plugins[$file]);
update_option('uninstall_plugins',$uninstallable_plugins);
}unset($uninstallable_plugins);
define('WP_UNINSTALL_PLUGIN',$file);
include WP_PLUGIN_DIR . '/' . dirname($file) . '/uninstall.php';
{$AspisRetTemp = true;
return $AspisRetTemp;
}}if ( isset($uninstallable_plugins[$file]))
 {$callable = $uninstallable_plugins[$file];
unset($uninstallable_plugins[$file]);
update_option('uninstall_plugins',$uninstallable_plugins);
unset($uninstallable_plugins);
include WP_PLUGIN_DIR . '/' . $file;
add_action('uninstall_' . $file,$callable);
do_action('uninstall_' . $file);
} }
function add_menu_page ( $page_title,$menu_title,$access_level,$file,$function = '',$icon_url = '',$position = NULL ) {
{global $menu,$admin_page_hooks,$_registered_pages;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $menu,"\$menu",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($admin_page_hooks,"\$admin_page_hooks",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($_registered_pages,"\$_registered_pages",$AspisChangesCache);
}$file = plugin_basename($file);
$admin_page_hooks[$file] = sanitize_title($menu_title);
$hookname = get_plugin_page_hookname($file,'');
if ( !empty($function) && !empty($hookname) && current_user_can($access_level))
 add_action($hookname,$function);
if ( empty($icon_url))
 {$icon_url = 'images/generic.png';
}elseif ( is_ssl() && 0 === strpos($icon_url,'http://'))
 {$icon_url = 'https://' . substr($icon_url,7);
}$new_menu = array($menu_title,$access_level,$file,$page_title,'menu-top ' . $hookname,$hookname,$icon_url);
if ( NULL === $position)
 {$menu[] = $new_menu;
}else 
{{$menu[$position] = $new_menu;
}}$_registered_pages[$hookname] = true;
{$AspisRetTemp = $hookname;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$admin_page_hooks",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$admin_page_hooks",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$_registered_pages",$AspisChangesCache);
 }
function add_object_page ( $page_title,$menu_title,$access_level,$file,$function = '',$icon_url = '' ) {
{global $_wp_last_object_menu;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_last_object_menu,"\$_wp_last_object_menu",$AspisChangesCache);
}$_wp_last_object_menu++;
{$AspisRetTemp = add_menu_page($page_title,$menu_title,$access_level,$file,$function,$icon_url,$_wp_last_object_menu);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_last_object_menu",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_last_object_menu",$AspisChangesCache);
 }
function add_utility_page ( $page_title,$menu_title,$access_level,$file,$function = '',$icon_url = '' ) {
{global $_wp_last_utility_menu;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_last_utility_menu,"\$_wp_last_utility_menu",$AspisChangesCache);
}$_wp_last_utility_menu++;
{$AspisRetTemp = add_menu_page($page_title,$menu_title,$access_level,$file,$function,$icon_url,$_wp_last_utility_menu);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_last_utility_menu",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_last_utility_menu",$AspisChangesCache);
 }
function add_submenu_page ( $parent,$page_title,$menu_title,$access_level,$file,$function = '' ) {
{global $submenu;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $submenu,"\$submenu",$AspisChangesCache);
}{global $menu;
$AspisVar1 = &AspisCleanTaintedGlobalUntainted( $menu,"\$menu",$AspisChangesCache);
}{global $_wp_real_parent_file;
$AspisVar2 = &AspisCleanTaintedGlobalUntainted( $_wp_real_parent_file,"\$_wp_real_parent_file",$AspisChangesCache);
}{global $_wp_submenu_nopriv;
$AspisVar3 = &AspisCleanTaintedGlobalUntainted( $_wp_submenu_nopriv,"\$_wp_submenu_nopriv",$AspisChangesCache);
}{global $_registered_pages;
$AspisVar4 = &AspisCleanTaintedGlobalUntainted( $_registered_pages,"\$_registered_pages",$AspisChangesCache);
}$file = plugin_basename($file);
$parent = plugin_basename($parent);
if ( isset($_wp_real_parent_file[$parent]))
 $parent = $_wp_real_parent_file[$parent];
if ( !current_user_can($access_level))
 {$_wp_submenu_nopriv[$parent][$file] = true;
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}}if ( !isset($submenu[$parent]) && $file != $parent)
 {foreach ( (array)$menu as $parent_menu  )
{if ( $parent_menu[2] == $parent && current_user_can($parent_menu[1]))
 $submenu[$parent][] = $parent_menu;
}}$submenu[$parent][] = array($menu_title,$access_level,$file,$page_title);
$hookname = get_plugin_page_hookname($file,$parent);
if ( !empty($function) && !empty($hookname))
 add_action($hookname,$function);
$_registered_pages[$hookname] = true;
if ( 'tools.php' == $parent)
 $_registered_pages[get_plugin_page_hookname($file,'edit.php')] = true;
{$AspisRetTemp = $hookname;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_registered_pages",$AspisChangesCache);
 }
function add_management_page ( $page_title,$menu_title,$access_level,$file,$function = '' ) {
{$AspisRetTemp = add_submenu_page('tools.php',$page_title,$menu_title,$access_level,$file,$function);
return $AspisRetTemp;
} }
function add_options_page ( $page_title,$menu_title,$access_level,$file,$function = '' ) {
{$AspisRetTemp = add_submenu_page('options-general.php',$page_title,$menu_title,$access_level,$file,$function);
return $AspisRetTemp;
} }
function add_theme_page ( $page_title,$menu_title,$access_level,$file,$function = '' ) {
{$AspisRetTemp = add_submenu_page('themes.php',$page_title,$menu_title,$access_level,$file,$function);
return $AspisRetTemp;
} }
function add_users_page ( $page_title,$menu_title,$access_level,$file,$function = '' ) {
if ( current_user_can('edit_users'))
 $parent = 'users.php';
else 
{$parent = 'profile.php';
}{$AspisRetTemp = add_submenu_page($parent,$page_title,$menu_title,$access_level,$file,$function);
return $AspisRetTemp;
} }
function add_dashboard_page ( $page_title,$menu_title,$access_level,$file,$function = '' ) {
{$AspisRetTemp = add_submenu_page('index.php',$page_title,$menu_title,$access_level,$file,$function);
return $AspisRetTemp;
} }
function add_posts_page ( $page_title,$menu_title,$access_level,$file,$function = '' ) {
{$AspisRetTemp = add_submenu_page('edit.php',$page_title,$menu_title,$access_level,$file,$function);
return $AspisRetTemp;
} }
function add_media_page ( $page_title,$menu_title,$access_level,$file,$function = '' ) {
{$AspisRetTemp = add_submenu_page('upload.php',$page_title,$menu_title,$access_level,$file,$function);
return $AspisRetTemp;
} }
function add_links_page ( $page_title,$menu_title,$access_level,$file,$function = '' ) {
{$AspisRetTemp = add_submenu_page('link-manager.php',$page_title,$menu_title,$access_level,$file,$function);
return $AspisRetTemp;
} }
function add_pages_page ( $page_title,$menu_title,$access_level,$file,$function = '' ) {
{$AspisRetTemp = add_submenu_page('edit-pages.php',$page_title,$menu_title,$access_level,$file,$function);
return $AspisRetTemp;
} }
function add_comments_page ( $page_title,$menu_title,$access_level,$file,$function = '' ) {
{$AspisRetTemp = add_submenu_page('edit-comments.php',$page_title,$menu_title,$access_level,$file,$function);
return $AspisRetTemp;
} }
function get_admin_page_parent ( $parent = '' ) {
{global $parent_file;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $parent_file,"\$parent_file",$AspisChangesCache);
}{global $menu;
$AspisVar1 = &AspisCleanTaintedGlobalUntainted( $menu,"\$menu",$AspisChangesCache);
}{global $submenu;
$AspisVar2 = &AspisCleanTaintedGlobalUntainted( $submenu,"\$submenu",$AspisChangesCache);
}{global $pagenow;
$AspisVar3 = &AspisCleanTaintedGlobalUntainted( $pagenow,"\$pagenow",$AspisChangesCache);
}{global $plugin_page;
$AspisVar4 = &AspisCleanTaintedGlobalUntainted( $plugin_page,"\$plugin_page",$AspisChangesCache);
}{global $_wp_real_parent_file;
$AspisVar5 = &AspisCleanTaintedGlobalUntainted( $_wp_real_parent_file,"\$_wp_real_parent_file",$AspisChangesCache);
}{global $_wp_menu_nopriv;
$AspisVar6 = &AspisCleanTaintedGlobalUntainted( $_wp_menu_nopriv,"\$_wp_menu_nopriv",$AspisChangesCache);
}{global $_wp_submenu_nopriv;
$AspisVar7 = &AspisCleanTaintedGlobalUntainted( $_wp_submenu_nopriv,"\$_wp_submenu_nopriv",$AspisChangesCache);
}if ( !empty($parent) && 'admin.php' != $parent)
 {if ( isset($_wp_real_parent_file[$parent]))
 $parent = $_wp_real_parent_file[$parent];
{$AspisRetTemp = $parent;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$_wp_submenu_nopriv",$AspisChangesCache);
return $AspisRetTemp;
}}if ( $pagenow == 'admin.php' && isset($plugin_page))
 {foreach ( (array)$menu as $parent_menu  )
{if ( $parent_menu[2] == $plugin_page)
 {$parent_file = $plugin_page;
if ( isset($_wp_real_parent_file[$parent_file]))
 $parent_file = $_wp_real_parent_file[$parent_file];
{$AspisRetTemp = $parent_file;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$_wp_submenu_nopriv",$AspisChangesCache);
return $AspisRetTemp;
}}}if ( isset($_wp_menu_nopriv[$plugin_page]))
 {$parent_file = $plugin_page;
if ( isset($_wp_real_parent_file[$parent_file]))
 $parent_file = $_wp_real_parent_file[$parent_file];
{$AspisRetTemp = $parent_file;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$_wp_submenu_nopriv",$AspisChangesCache);
return $AspisRetTemp;
}}}if ( isset($plugin_page) && isset($_wp_submenu_nopriv[$pagenow][$plugin_page]))
 {$parent_file = $pagenow;
if ( isset($_wp_real_parent_file[$parent_file]))
 $parent_file = $_wp_real_parent_file[$parent_file];
{$AspisRetTemp = $parent_file;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$_wp_submenu_nopriv",$AspisChangesCache);
return $AspisRetTemp;
}}foreach ( array_keys((array)$submenu) as $parent  )
{foreach ( $submenu[$parent] as $submenu_array  )
{if ( isset($_wp_real_parent_file[$parent]))
 $parent = $_wp_real_parent_file[$parent];
if ( $submenu_array[2] == $pagenow)
 {$parent_file = $parent;
{$AspisRetTemp = $parent;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$_wp_submenu_nopriv",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{if ( isset($plugin_page) && ($plugin_page == $submenu_array[2]))
 {$parent_file = $parent;
{$AspisRetTemp = $parent;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$_wp_submenu_nopriv",$AspisChangesCache);
return $AspisRetTemp;
}}}}}if ( empty($parent_file))
 $parent_file = '';
{$AspisRetTemp = '';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$_wp_submenu_nopriv",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$_wp_real_parent_file",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$_wp_submenu_nopriv",$AspisChangesCache);
 }
function get_admin_page_title (  ) {
{global $title;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $title,"\$title",$AspisChangesCache);
}{global $menu;
$AspisVar1 = &AspisCleanTaintedGlobalUntainted( $menu,"\$menu",$AspisChangesCache);
}{global $submenu;
$AspisVar2 = &AspisCleanTaintedGlobalUntainted( $submenu,"\$submenu",$AspisChangesCache);
}{global $pagenow;
$AspisVar3 = &AspisCleanTaintedGlobalUntainted( $pagenow,"\$pagenow",$AspisChangesCache);
}{global $plugin_page;
$AspisVar4 = &AspisCleanTaintedGlobalUntainted( $plugin_page,"\$plugin_page",$AspisChangesCache);
}if ( isset($title) && !empty($title))
 {{$AspisRetTemp = $title;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$title",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
return $AspisRetTemp;
}}$hook = get_plugin_page_hook($plugin_page,$pagenow);
$parent = $parent1 = get_admin_page_parent();
if ( empty($parent))
 {foreach ( (array)$menu as $menu_array  )
{if ( isset($menu_array[3]))
 {if ( $menu_array[2] == $pagenow)
 {$title = $menu_array[3];
{$AspisRetTemp = $menu_array[3];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$title",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{if ( isset($plugin_page) && ($plugin_page == $menu_array[2]) && ($hook == $menu_array[3]))
 {$title = $menu_array[3];
{$AspisRetTemp = $menu_array[3];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$title",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
return $AspisRetTemp;
}}}}else 
{{$title = $menu_array[0];
{$AspisRetTemp = $title;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$title",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
return $AspisRetTemp;
}}}}}else 
{{foreach ( array_keys($submenu) as $parent  )
{foreach ( $submenu[$parent] as $submenu_array  )
{if ( isset($plugin_page) && ($plugin_page == $submenu_array[2]) && (($parent == $pagenow) || ($parent == $plugin_page) || ($plugin_page == $hook) || (($pagenow == 'admin.php') && ($parent1 != $submenu_array[2]))))
 {$title = $submenu_array[3];
{$AspisRetTemp = $submenu_array[3];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$title",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
return $AspisRetTemp;
}}if ( $submenu_array[2] != $pagenow || (isset($_GET[0]['page']) && Aspis_isset($_GET[0]['page'])))
 continue ;
if ( isset($submenu_array[3]))
 {$title = $submenu_array[3];
{$AspisRetTemp = $submenu_array[3];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$title",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{$title = $submenu_array[0];
{$AspisRetTemp = $title;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$title",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
return $AspisRetTemp;
}}}}}if ( !isset($title) || empty($title))
 {foreach ( $menu as $menu_array  )
{if ( isset($plugin_page) && ($plugin_page == $menu_array[2]) && ($pagenow == 'admin.php') && ($parent1 == $menu_array[2]))
 {$title = $menu_array[3];
{$AspisRetTemp = $menu_array[3];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$title",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
return $AspisRetTemp;
}}}}}}{$AspisRetTemp = $title;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$title",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$title",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$plugin_page",$AspisChangesCache);
 }
function get_plugin_page_hook ( $plugin_page,$parent_page ) {
$hook = get_plugin_page_hookname($plugin_page,$parent_page);
if ( has_action($hook))
 {$AspisRetTemp = $hook;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = null;
return $AspisRetTemp;
}} }
function get_plugin_page_hookname ( $plugin_page,$parent_page ) {
{global $admin_page_hooks;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $admin_page_hooks,"\$admin_page_hooks",$AspisChangesCache);
}$parent = get_admin_page_parent($parent_page);
$page_type = 'admin';
if ( empty($parent_page) || 'admin.php' == $parent_page || isset($admin_page_hooks[$plugin_page]))
 {if ( isset($admin_page_hooks[$plugin_page]))
 $page_type = 'toplevel';
else 
{if ( isset($admin_page_hooks[$parent]))
 $page_type = $admin_page_hooks[$parent];
}}else 
{if ( isset($admin_page_hooks[$parent]))
 {$page_type = $admin_page_hooks[$parent];
}}$plugin_name = preg_replace('!\.php!','',$plugin_page);
{$AspisRetTemp = $page_type . '_page_' . $plugin_name;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$admin_page_hooks",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$admin_page_hooks",$AspisChangesCache);
 }
function user_can_access_admin_page (  ) {
{global $pagenow;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $pagenow,"\$pagenow",$AspisChangesCache);
}{global $menu;
$AspisVar1 = &AspisCleanTaintedGlobalUntainted( $menu,"\$menu",$AspisChangesCache);
}{global $submenu;
$AspisVar2 = &AspisCleanTaintedGlobalUntainted( $submenu,"\$submenu",$AspisChangesCache);
}{global $_wp_menu_nopriv;
$AspisVar3 = &AspisCleanTaintedGlobalUntainted( $_wp_menu_nopriv,"\$_wp_menu_nopriv",$AspisChangesCache);
}{global $_wp_submenu_nopriv;
$AspisVar4 = &AspisCleanTaintedGlobalUntainted( $_wp_submenu_nopriv,"\$_wp_submenu_nopriv",$AspisChangesCache);
}{global $plugin_page;
$AspisVar5 = &AspisCleanTaintedGlobalUntainted( $plugin_page,"\$plugin_page",$AspisChangesCache);
}{global $_registered_pages;
$AspisVar6 = &AspisCleanTaintedGlobalUntainted( $_registered_pages,"\$_registered_pages",$AspisChangesCache);
}$parent = get_admin_page_parent();
if ( !isset($plugin_page) && isset($_wp_submenu_nopriv[$parent][$pagenow]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}if ( isset($plugin_page))
 {if ( isset($_wp_submenu_nopriv[$parent][$plugin_page]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}$hookname = get_plugin_page_hookname($plugin_page,$parent);
if ( !isset($_registered_pages[$hookname]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}}if ( empty($parent))
 {if ( isset($_wp_menu_nopriv[$pagenow]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}if ( isset($_wp_submenu_nopriv[$pagenow][$pagenow]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}if ( isset($plugin_page) && isset($_wp_submenu_nopriv[$pagenow][$plugin_page]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}if ( isset($plugin_page) && isset($_wp_menu_nopriv[$plugin_page]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}foreach ( array_keys($_wp_submenu_nopriv) as $key  )
{if ( isset($_wp_submenu_nopriv[$key][$pagenow]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}if ( isset($plugin_page) && isset($_wp_submenu_nopriv[$key][$plugin_page]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}}if ( isset($plugin_page) && ($plugin_page == $parent) && isset($_wp_menu_nopriv[$plugin_page]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}if ( isset($submenu[$parent]))
 {foreach ( $submenu[$parent] as $submenu_array  )
{if ( isset($plugin_page) && ($submenu_array[2] == $plugin_page))
 {if ( current_user_can($submenu_array[1]))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}}}else 
{if ( $submenu_array[2] == $pagenow)
 {if ( current_user_can($submenu_array[1]))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}}}}}}foreach ( $menu as $menu_array  )
{if ( $menu_array[2] == $parent)
 {if ( current_user_can($menu_array[1]))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}}}}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$menu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$submenu",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_menu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$_wp_submenu_nopriv",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$plugin_page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$_registered_pages",$AspisChangesCache);
 }
function register_setting ( $option_group,$option_name,$sanitize_callback = '' ) {
{$AspisRetTemp = add_option_update_handler($option_group,$option_name,$sanitize_callback);
return $AspisRetTemp;
} }
function unregister_setting ( $option_group,$option_name,$sanitize_callback = '' ) {
{$AspisRetTemp = remove_option_update_handler($option_group,$option_name,$sanitize_callback);
return $AspisRetTemp;
} }
function add_option_update_handler ( $option_group,$option_name,$sanitize_callback = '' ) {
{global $new_whitelist_options;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $new_whitelist_options,"\$new_whitelist_options",$AspisChangesCache);
}$new_whitelist_options[$option_group][] = $option_name;
if ( $sanitize_callback != '')
 add_filter("sanitize_option_{$option_name}",$sanitize_callback);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$new_whitelist_options",$AspisChangesCache);
 }
function remove_option_update_handler ( $option_group,$option_name,$sanitize_callback = '' ) {
{global $new_whitelist_options;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $new_whitelist_options,"\$new_whitelist_options",$AspisChangesCache);
}$pos = array_search($option_name,(array)$new_whitelist_options);
if ( $pos !== false)
 unset($new_whitelist_options[$option_group][$pos]);
if ( $sanitize_callback != '')
 remove_filter("sanitize_option_{$option_name}",$sanitize_callback);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$new_whitelist_options",$AspisChangesCache);
 }
function option_update_filter ( $options ) {
{global $new_whitelist_options;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $new_whitelist_options,"\$new_whitelist_options",$AspisChangesCache);
}if ( is_array($new_whitelist_options))
 $options = add_option_whitelist($new_whitelist_options,$options);
{$AspisRetTemp = $options;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$new_whitelist_options",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$new_whitelist_options",$AspisChangesCache);
 }
add_filter('whitelist_options','option_update_filter');
function add_option_whitelist ( $new_options,$options = '' ) {
if ( $options == '')
 {{global $whitelist_options;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $whitelist_options,"\$whitelist_options",$AspisChangesCache);
}}else 
{{$whitelist_options = $options;
}}foreach ( $new_options as $page =>$keys )
{foreach ( $keys as $key  )
{if ( !isset($whitelist_options[$page]) || !is_array($whitelist_options[$page]))
 {$whitelist_options[$page] = array();
$whitelist_options[$page][] = $key;
}else 
{{$pos = array_search($key,$whitelist_options[$page]);
if ( $pos === false)
 $whitelist_options[$page][] = $key;
}}}}{$AspisRetTemp = $whitelist_options;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$whitelist_options",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$whitelist_options",$AspisChangesCache);
 }
function remove_option_whitelist ( $del_options,$options = '' ) {
if ( $options == '')
 {{global $whitelist_options;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $whitelist_options,"\$whitelist_options",$AspisChangesCache);
}}else 
{{$whitelist_options = $options;
}}foreach ( $del_options as $page =>$keys )
{foreach ( $keys as $key  )
{if ( isset($whitelist_options[$page]) && is_array($whitelist_options[$page]))
 {$pos = array_search($key,$whitelist_options[$page]);
if ( $pos !== false)
 unset($whitelist_options[$page][$pos]);
}}}{$AspisRetTemp = $whitelist_options;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$whitelist_options",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$whitelist_options",$AspisChangesCache);
 }
function settings_fields ( $option_group ) {
echo "<input type='hidden' name='option_page' value='" . esc_attr($option_group) . "' />";
echo '<input type="hidden" name="action" value="update" />';
wp_nonce_field("$option_group-options");
 }
;
?>
<?php 