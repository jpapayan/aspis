<?php require_once('AspisMain.php'); ?><?php
function get_preferred_from_update_core (  ) {
$updates = get_core_updates();
if ( (!(is_array($updates[0]))))
 return array(false,false);
if ( ((empty($updates) || Aspis_empty( $updates))))
 return object_cast(array(array('response' => array('latest',false,false)),false));
return attachAspis($updates,(0));
 }
function get_core_updates ( $options = array(array(),false) ) {
$options = Aspis_array_merge(array(array('available' => array(true,false,false),'dismissed' => array(false,false,false)),false),$options);
$dismissed = get_option(array('dismissed_update_core',false));
if ( (!(is_array($dismissed[0]))))
 $dismissed = array(array(),false);
$from_api = get_transient(array('update_core',false));
if ( ((empty($from_api) || Aspis_empty( $from_api))))
 return array(false,false);
if ( ((!((isset($from_api[0]->updates) && Aspis_isset( $from_api[0] ->updates )))) || (!(is_array($from_api[0]->updates[0])))))
 return array(false,false);
$updates = $from_api[0]->updates;
if ( (!(is_array($updates[0]))))
 return array(false,false);
$result = array(array(),false);
foreach ( $updates[0] as $update  )
{if ( array_key_exists((deconcat(concat2($update[0]->current,'|'),$update[0]->locale)),deAspisRC($dismissed)))
 {if ( deAspis($options[0]['dismissed']))
 {$update[0]->dismissed = array(true,false);
arrayAssignAdd($result[0][],addTaint($update));
}}else 
{{if ( deAspis($options[0]['available']))
 {$update[0]->dismissed = array(false,false);
arrayAssignAdd($result[0][],addTaint($update));
}}}}return $result;
 }
function dismiss_core_update ( $update ) {
$dismissed = get_option(array('dismissed_update_core',false));
arrayAssign($dismissed[0],deAspis(registerTaint(concat(concat2($update[0]->current,'|'),$update[0]->locale))),addTaint(array(true,false)));
return update_option(array('dismissed_update_core',false),$dismissed);
 }
function undismiss_core_update ( $version,$locale ) {
$dismissed = get_option(array('dismissed_update_core',false));
$key = concat(concat2($version,'|'),$locale);
if ( (!((isset($dismissed[0][$key[0]]) && Aspis_isset( $dismissed [0][$key[0]])))))
 return array(false,false);
unset($dismissed[0][$key[0]]);
return update_option(array('dismissed_update_core',false),$dismissed);
 }
function find_core_update ( $version,$locale ) {
$from_api = get_transient(array('update_core',false));
if ( (!(is_array($from_api[0]->updates[0]))))
 return array(false,false);
$updates = $from_api[0]->updates;
foreach ( $updates[0] as $update  )
{if ( (($update[0]->current[0] == $version[0]) && ($update[0]->locale[0] == $locale[0])))
 return $update;
}return array(false,false);
 }
function core_update_footer ( $msg = array('',false) ) {
if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 return Aspis_sprintf(__(array('Version %s',false)),$GLOBALS[0]['wp_version']);
$cur = get_preferred_from_update_core();
if ( (!((isset($cur[0]->current) && Aspis_isset( $cur[0] ->current )))))
 $cur[0]->current = array('',false);
if ( (!((isset($cur[0]->url) && Aspis_isset( $cur[0] ->url )))))
 $cur[0]->url = array('',false);
if ( (!((isset($cur[0]->response) && Aspis_isset( $cur[0] ->response )))))
 $cur[0]->response = array('',false);
switch ( $cur[0]->response[0] ) {
case ('development'):return Aspis_sprintf(__(array('You are using a development version (%1$s). Cool! Please <a href="%2$s">stay updated</a>.',false)),$GLOBALS[0]['wp_version'],array('update-core.php',false));
break ;
case ('upgrade'):if ( deAspis(current_user_can(array('manage_options',false))))
 {return Aspis_sprintf(concat2(concat1('<strong>',__(array('<a href="%1$s">Get Version %2$s</a>',false))),'</strong>'),array('update-core.php',false),$cur[0]->current);
break ;
}case ('latest'):default :return Aspis_sprintf(__(array('Version %s',false)),$GLOBALS[0]['wp_version']);
break ;
 }
 }
add_filter(array('update_footer',false),array('core_update_footer',false));
function update_nag (  ) {
global $pagenow;
if ( (('update-core.php') == $pagenow[0]))
 return ;
$cur = get_preferred_from_update_core();
if ( ((!((isset($cur[0]->response) && Aspis_isset( $cur[0] ->response )))) || ($cur[0]->response[0] != ('upgrade'))))
 return array(false,false);
if ( deAspis(current_user_can(array('manage_options',false))))
 $msg = Aspis_sprintf(__(array('WordPress %1$s is available! <a href="%2$s">Please update now</a>.',false)),$cur[0]->current,array('update-core.php',false));
else 
{$msg = Aspis_sprintf(__(array('WordPress %1$s is available! Please notify the site administrator.',false)),$cur[0]->current);
}echo AspisCheckPrint(concat2(concat1("<div id='update-nag'>",$msg),"</div>"));
 }
add_action(array('admin_notices',false),array('update_nag',false),array(3,false));
function update_right_now_message (  ) {
$cur = get_preferred_from_update_core();
$msg = Aspis_sprintf(__(array('You are using <span class="b">WordPress %s</span>.',false)),$GLOBALS[0]['wp_version']);
if ( ((((isset($cur[0]->response) && Aspis_isset( $cur[0] ->response ))) && ($cur[0]->response[0] == ('upgrade'))) && deAspis(current_user_can(array('manage_options',false)))))
 $msg = concat($msg,concat2(concat1(" <a href='update-core.php' class='button'>",Aspis_sprintf(__(array('Update to %s',false)),$cur[0]->current[0] ? $cur[0]->current : __(array('Latest',false)))),'</a>'));
echo AspisCheckPrint(concat2(concat1("<span id='wp-version-message'>",$msg),"</span>"));
 }
function get_plugin_updates (  ) {
$all_plugins = get_plugins();
$upgrade_plugins = array(array(),false);
$current = get_transient(array('update_plugins',false));
foreach ( deAspis(array_cast($all_plugins)) as $plugin_file =>$plugin_data )
{restoreTaint($plugin_file,$plugin_data);
{if ( ((isset($current[0]->response[0][$plugin_file[0]]) && Aspis_isset( $current[0] ->response [0][$plugin_file[0]] ))))
 {arrayAssign($upgrade_plugins[0],deAspis(registerTaint($plugin_file)),addTaint(object_cast($plugin_data)));
$upgrade_plugins[0][$plugin_file[0]][0]->update = $current[0]->response[0][$plugin_file[0]];
}}}return $upgrade_plugins;
 }
function wp_plugin_update_rows (  ) {
$plugins = get_transient(array('update_plugins',false));
if ( (((isset($plugins[0]->response) && Aspis_isset( $plugins[0] ->response ))) && is_array($plugins[0]->response[0])))
 {$plugins = attAspisRC(array_keys(deAspisRC($plugins[0]->response)));
foreach ( $plugins[0] as $plugin_file  )
{add_action(concat1("after_plugin_row_",$plugin_file),array('wp_plugin_update_row',false),array(10,false),array(2,false));
}} }
add_action(array('admin_init',false),array('wp_plugin_update_rows',false));
function wp_plugin_update_row ( $file,$plugin_data ) {
$current = get_transient(array('update_plugins',false));
if ( (!((isset($current[0]->response[0][$file[0]]) && Aspis_isset( $current[0] ->response [0][$file[0]] )))))
 return array(false,false);
$r = $current[0]->response[0][$file[0]];
$plugins_allowedtags = array(array('a' => array(array('href' => array(array(),false,false),'title' => array(array(),false,false)),false,false),'abbr' => array(array('title' => array(array(),false,false)),false,false),'acronym' => array(array('title' => array(array(),false,false)),false,false),'code' => array(array(),false,false),'em' => array(array(),false,false),'strong' => array(array(),false,false)),false);
$plugin_name = wp_kses($plugin_data[0]['Name'],$plugins_allowedtags);
$details_url = admin_url(concat2(concat1('plugin-install.php?tab=plugin-information&plugin=',$r[0]->slug),'&TB_iframe=true&width=600&height=800'));
echo AspisCheckPrint(array('<tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">',false));
if ( (denot_boolean(current_user_can(array('update_plugins',false)))))
 printf(deAspis(__(array('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s Details</a>.',false))),deAspisRC($plugin_name),deAspisRC(esc_url($details_url)),deAspisRC(esc_attr($plugin_name)),deAspisRC($r[0]->new_version));
else 
{if ( ((empty($r[0]->package) || Aspis_empty( $r[0] ->package ))))
 printf(deAspis(__(array('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s Details</a> <em>automatic upgrade unavailable for this plugin</em>.',false))),deAspisRC($plugin_name),deAspisRC(esc_url($details_url)),deAspisRC(esc_attr($plugin_name)),deAspisRC($r[0]->new_version));
else 
{printf(deAspis(__(array('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s Details</a> or <a href="%5$s">upgrade automatically</a>.',false))),deAspisRC($plugin_name),deAspisRC(esc_url($details_url)),deAspisRC(esc_attr($plugin_name)),deAspisRC($r[0]->new_version),deAspisRC(wp_nonce_url(concat1('update.php?action=upgrade-plugin&plugin=',$file),concat1('upgrade-plugin_',$file))));
}}do_action(concat1("in_plugin_update_message-",$file),$plugin_data,$r);
echo AspisCheckPrint(array('</div></td></tr>',false));
 }
function wp_update_plugin ( $plugin,$feedback = array('',false) ) {
if ( (!((empty($feedback) || Aspis_empty( $feedback)))))
 add_filter(array('update_feedback',false),$feedback);
include (deconcat12(ABSPATH,'wp-admin/includes/class-wp-upgrader.php'));
$upgrader = array(new Plugin_Upgrader(),false);
return $upgrader[0]->upgrade($plugin);
 }
function get_theme_updates (  ) {
$themes = get_themes();
$current = get_transient(array('update_themes',false));
$update_themes = array(array(),false);
foreach ( $themes[0] as $theme  )
{$theme = object_cast($theme);
if ( ((isset($current[0]->response[0][$theme[0]->Stylesheet[0]]) && Aspis_isset( $current[0] ->response [0][$theme[0] ->Stylesheet [0]] ))))
 {arrayAssign($update_themes[0],deAspis(registerTaint($theme[0]->Stylesheet)),addTaint($theme));
$update_themes[0][$theme[0]->Stylesheet[0]][0]->update = $current[0]->response[0][$theme[0]->Stylesheet[0]];
}}return $update_themes;
 }
function wp_update_theme ( $theme,$feedback = array('',false) ) {
if ( (!((empty($feedback) || Aspis_empty( $feedback)))))
 add_filter(array('update_feedback',false),$feedback);
include (deconcat12(ABSPATH,'wp-admin/includes/class-wp-upgrader.php'));
$upgrader = array(new Theme_Upgrader(),false);
return $upgrader[0]->upgrade($theme);
 }
function wp_update_core ( $current,$feedback = array('',false) ) {
if ( (!((empty($feedback) || Aspis_empty( $feedback)))))
 add_filter(array('update_feedback',false),$feedback);
include (deconcat12(ABSPATH,'wp-admin/includes/class-wp-upgrader.php'));
$upgrader = array(new Core_Upgrader(),false);
return $upgrader[0]->upgrade($current);
 }
function maintenance_nag (  ) {
global $upgrading;
if ( (!((isset($upgrading) && Aspis_isset( $upgrading)))))
 return array(false,false);
if ( deAspis(current_user_can(array('manage_options',false))))
 $msg = Aspis_sprintf(__(array('An automated WordPress update has failed to complete - <a href="%s">please attempt the update again now</a>.',false)),array('update-core.php',false));
else 
{$msg = __(array('An automated WordPress update has failed to complete! Please notify the site administrator.',false));
}echo AspisCheckPrint(concat2(concat1("<div id='update-nag'>",$msg),"</div>"));
 }
add_action(array('admin_notices',false),array('maintenance_nag',false));
;
?>
<?php 