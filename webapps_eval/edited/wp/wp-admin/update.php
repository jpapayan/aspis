<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
include_once (deconcat12(ABSPATH,'wp-admin/includes/class-wp-upgrader.php'));
if ( ((isset($_GET[0][('action')]) && Aspis_isset( $_GET [0][('action')]))))
 {$plugin = ((isset($_REQUEST[0][('plugin')]) && Aspis_isset( $_REQUEST [0][('plugin')]))) ? Aspis_trim($_REQUEST[0]['plugin']) : array('',false);
$theme = ((isset($_REQUEST[0][('theme')]) && Aspis_isset( $_REQUEST [0][('theme')]))) ? Aspis_urldecode($_REQUEST[0]['theme']) : array('',false);
$action = ((isset($_REQUEST[0][('action')]) && Aspis_isset( $_REQUEST [0][('action')]))) ? $_REQUEST[0]['action'] : array('',false);
if ( (('upgrade-plugin') == $action[0]))
 {if ( (denot_boolean(current_user_can(array('update_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to update plugins for this blog.',false)));
check_admin_referer(concat1('upgrade-plugin_',$plugin));
$title = __(array('Upgrade Plugin',false));
$parent_file = array('plugins.php',false);
$submenu_file = array('plugins.php',false);
require_once ('admin-header.php');
$nonce = concat1('upgrade-plugin_',$plugin);
$url = concat1('update.php?action=upgrade-plugin&plugin=',$plugin);
$upgrader = array(new Plugin_Upgrader(array(new Plugin_Upgrader_Skin(array(compact('title','nonce','url','plugin'),false)),false)),false);
$upgrader[0]->upgrade($plugin);
include ('admin-footer.php');
}elseif ( (('activate-plugin') == $action[0]))
 {if ( (denot_boolean(current_user_can(array('update_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to update plugins for this blog.',false)));
check_admin_referer(concat1('activate-plugin_',$plugin));
if ( ((!((isset($_GET[0][('failure')]) && Aspis_isset( $_GET [0][('failure')])))) && (!((isset($_GET[0][('success')]) && Aspis_isset( $_GET [0][('success')]))))))
 {wp_redirect(concat(concat2(concat1('update.php?action=activate-plugin&failure=true&plugin=',$plugin),'&_wpnonce='),$_GET[0]['_wpnonce']));
activate_plugin($plugin);
wp_redirect(concat(concat2(concat1('update.php?action=activate-plugin&success=true&plugin=',$plugin),'&_wpnonce='),$_GET[0]['_wpnonce']));
Aspis_exit();
}iframe_header(__(array('Plugin Reactivation',false)),array(true,false));
if ( ((isset($_GET[0][('success')]) && Aspis_isset( $_GET [0][('success')]))))
 echo AspisCheckPrint(concat2(concat1('<p>',__(array('Plugin reactivated successfully.',false))),'</p>'));
if ( ((isset($_GET[0][('failure')]) && Aspis_isset( $_GET [0][('failure')]))))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Plugin failed to reactivate due to a fatal error.',false))),'</p>'));
if ( defined(('E_RECOVERABLE_ERROR')))
 error_reporting(deAspisRC(array(((((E_ERROR | E_WARNING) | E_PARSE) | E_USER_ERROR) | E_USER_WARNING) | E_RECOVERABLE_ERROR,false)));
else 
{error_reporting(deAspisRC(array((((E_ERROR | E_WARNING) | E_PARSE) | E_USER_ERROR) | E_USER_WARNING,false)));
}@array(ini_set('display_errors',true),false);
include (deconcat(concat12(WP_PLUGIN_DIR,'/'),$plugin));
}iframe_footer();
}elseif ( (('install-plugin') == $action[0]))
 {if ( (denot_boolean(current_user_can(array('install_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to install plugins for this blog.',false)));
include_once (deconcat12(ABSPATH,'wp-admin/includes/plugin-install.php'));
check_admin_referer(concat1('install-plugin_',$plugin));
$api = plugins_api(array('plugin_information',false),array(array(deregisterTaint(array('slug',false)) => addTaint($plugin),'fields' => array(array('sections' => array(false,false,false)),false,false)),false));
if ( deAspis(is_wp_error($api)))
 wp_die($api);
$title = __(array('Plugin Install',false));
$parent_file = array('plugins.php',false);
$submenu_file = array('plugin-install.php',false);
require_once ('admin-header.php');
$title = Aspis_sprintf(__(array('Installing Plugin: %s',false)),concat(concat2($api[0]->name,' '),$api[0]->version));
$nonce = concat1('install-plugin_',$plugin);
$url = concat1('update.php?action=install-plugin&plugin=',$plugin);
$type = array('web',false);
$upgrader = array(new Plugin_Upgrader(array(new Plugin_Installer_Skin(array(compact('title','url','nonce','plugin','api'),false)),false)),false);
$upgrader[0]->install($api[0]->download_link);
include ('admin-footer.php');
}elseif ( (('upload-plugin') == $action[0]))
 {if ( (denot_boolean(current_user_can(array('install_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to install plugins for this blog.',false)));
check_admin_referer(array('plugin-upload',false));
$file_upload = array(new File_Upload_Upgrader(array('pluginzip',false),array('package',false)),false);
$title = __(array('Upload Plugin',false));
$parent_file = array('plugins.php',false);
$submenu_file = array('plugin-install.php',false);
require_once ('admin-header.php');
$title = Aspis_sprintf(__(array('Installing Plugin from uploaded file: %s',false)),Aspis_basename($file_upload[0]->filename));
$nonce = array('plugin-upload',false);
$url = add_query_arg(array(array(deregisterTaint(array('package',false)) => addTaint($file_upload[0]->filename)),false),array('update.php?action=upload-plugin',false));
$type = array('upload',false);
$upgrader = array(new Plugin_Upgrader(array(new Plugin_Installer_Skin(array(compact('type','title','nonce','url'),false)),false)),false);
$upgrader[0]->install($file_upload[0]->package);
include ('admin-footer.php');
}elseif ( (('upgrade-theme') == $action[0]))
 {if ( (denot_boolean(current_user_can(array('update_themes',false)))))
 wp_die(__(array('You do not have sufficient permissions to update themes for this blog.',false)));
check_admin_referer(concat1('upgrade-theme_',$theme));
add_thickbox();
wp_enqueue_script(array('theme-preview',false));
$title = __(array('Upgrade Theme',false));
$parent_file = array('themes.php',false);
$submenu_file = array('themes.php',false);
require_once ('admin-header.php');
$nonce = concat1('upgrade-theme_',$theme);
$url = concat1('update.php?action=upgrade-theme&theme=',$theme);
$upgrader = array(new Theme_Upgrader(array(new Theme_Upgrader_Skin(array(compact('title','nonce','url','theme'),false)),false)),false);
$upgrader[0]->upgrade($theme);
include ('admin-footer.php');
}elseif ( (('install-theme') == $action[0]))
 {if ( (denot_boolean(current_user_can(array('install_themes',false)))))
 wp_die(__(array('You do not have sufficient permissions to install themes for this blog.',false)));
include_once (deconcat12(ABSPATH,'wp-admin/includes/theme-install.php'));
check_admin_referer(concat1('install-theme_',$theme));
$api = themes_api(array('theme_information',false),array(array(deregisterTaint(array('slug',false)) => addTaint($theme),'fields' => array(array('sections' => array(false,false,false)),false,false)),false));
if ( deAspis(is_wp_error($api)))
 wp_die($api);
add_thickbox();
wp_enqueue_script(array('theme-preview',false));
$title = __(array('Install Themes',false));
$parent_file = array('themes.php',false);
$submenu_file = array('theme-install.php',false);
require_once ('admin-header.php');
$title = Aspis_sprintf(__(array('Installing theme: %s',false)),concat(concat2($api[0]->name,' '),$api[0]->version));
$nonce = concat1('install-theme_',$theme);
$url = concat1('update.php?action=install-theme&theme=',$theme);
$type = array('web',false);
$upgrader = array(new Theme_Upgrader(array(new Theme_Installer_Skin(array(compact('title','url','nonce','plugin','api'),false)),false)),false);
$upgrader[0]->install($api[0]->download_link);
include ('admin-footer.php');
}elseif ( (('upload-theme') == $action[0]))
 {if ( (denot_boolean(current_user_can(array('install_themes',false)))))
 wp_die(__(array('You do not have sufficient permissions to install themes for this blog.',false)));
check_admin_referer(array('theme-upload',false));
$file_upload = array(new File_Upload_Upgrader(array('themezip',false),array('package',false)),false);
$title = __(array('Upload Theme',false));
$parent_file = array('themes.php',false);
$submenu_file = array('theme-install.php',false);
add_thickbox();
wp_enqueue_script(array('theme-preview',false));
require_once ('admin-header.php');
$title = Aspis_sprintf(__(array('Installing Theme from uploaded file: %s',false)),Aspis_basename($file_upload[0]->filename));
$nonce = array('theme-upload',false);
$url = add_query_arg(array(array(deregisterTaint(array('package',false)) => addTaint($file_upload[0]->filename)),false),array('update.php?action=upload-theme',false));
$type = array('upload',false);
$upgrader = array(new Theme_Upgrader(array(new Theme_Installer_Skin(array(compact('type','title','nonce','url'),false)),false)),false);
$upgrader[0]->install($file_upload[0]->package);
include ('admin-footer.php');
}else 
{{do_action(concat1('update-custom_',$action));
}}}