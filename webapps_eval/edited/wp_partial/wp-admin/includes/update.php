<?php require_once('AspisMain.php'); ?><?php
function get_preferred_from_update_core (  ) {
$updates = get_core_updates();
if ( !is_array($updates))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( empty($updates))
 {$AspisRetTemp = (object)array('response' => 'latest');
return $AspisRetTemp;
}{$AspisRetTemp = $updates[0];
return $AspisRetTemp;
} }
function get_core_updates ( $options = array() ) {
$options = array_merge(array('available' => true,'dismissed' => false),$options);
$dismissed = get_option('dismissed_update_core');
if ( !is_array($dismissed))
 $dismissed = array();
$from_api = get_transient('update_core');
if ( empty($from_api))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !isset($from_api->updates) || !is_array($from_api->updates))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$updates = $from_api->updates;
if ( !is_array($updates))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$result = array();
foreach ( $updates as $update  )
{if ( array_key_exists($update->current . '|' . $update->locale,$dismissed))
 {if ( $options['dismissed'])
 {$update->dismissed = true;
$result[] = $update;
}}else 
{{if ( $options['available'])
 {$update->dismissed = false;
$result[] = $update;
}}}}{$AspisRetTemp = $result;
return $AspisRetTemp;
} }
function dismiss_core_update ( $update ) {
$dismissed = get_option('dismissed_update_core');
$dismissed[$update->current . '|' . $update->locale] = true;
{$AspisRetTemp = update_option('dismissed_update_core',$dismissed);
return $AspisRetTemp;
} }
function undismiss_core_update ( $version,$locale ) {
$dismissed = get_option('dismissed_update_core');
$key = $version . '|' . $locale;
if ( !isset($dismissed[$key]))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}unset($dismissed[$key]);
{$AspisRetTemp = update_option('dismissed_update_core',$dismissed);
return $AspisRetTemp;
} }
function find_core_update ( $version,$locale ) {
$from_api = get_transient('update_core');
if ( !is_array($from_api->updates))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$updates = $from_api->updates;
foreach ( $updates as $update  )
{if ( $update->current == $version && $update->locale == $locale)
 {$AspisRetTemp = $update;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function core_update_footer ( $msg = '' ) {
if ( !current_user_can('manage_options'))
 {$AspisRetTemp = sprintf(__('Version %s'),$GLOBALS[0]['wp_version']);
return $AspisRetTemp;
}$cur = get_preferred_from_update_core();
if ( !isset($cur->current))
 $cur->current = '';
if ( !isset($cur->url))
 $cur->url = '';
if ( !isset($cur->response))
 $cur->response = '';
switch ( $cur->response ) {
case 'development':{$AspisRetTemp = sprintf(__('You are using a development version (%1$s). Cool! Please <a href="%2$s">stay updated</a>.'),$GLOBALS[0]['wp_version'],'update-core.php');
return $AspisRetTemp;
}break ;
case 'upgrade':if ( current_user_can('manage_options'))
 {{$AspisRetTemp = sprintf('<strong>' . __('<a href="%1$s">Get Version %2$s</a>') . '</strong>','update-core.php',$cur->current);
return $AspisRetTemp;
}break ;
}case 'latest':default :{$AspisRetTemp = sprintf(__('Version %s'),$GLOBALS[0]['wp_version']);
return $AspisRetTemp;
}break ;
 }
 }
add_filter('update_footer','core_update_footer');
function update_nag (  ) {
{global $pagenow;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $pagenow,"\$pagenow",$AspisChangesCache);
}if ( 'update-core.php' == $pagenow)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
return ;
}$cur = get_preferred_from_update_core();
if ( !isset($cur->response) || $cur->response != 'upgrade')
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
return $AspisRetTemp;
}if ( current_user_can('manage_options'))
 $msg = sprintf(__('WordPress %1$s is available! <a href="%2$s">Please update now</a>.'),$cur->current,'update-core.php');
else 
{$msg = sprintf(__('WordPress %1$s is available! Please notify the site administrator.'),$cur->current);
}echo "<div id='update-nag'>$msg</div>";
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pagenow",$AspisChangesCache);
 }
add_action('admin_notices','update_nag',3);
function update_right_now_message (  ) {
$cur = get_preferred_from_update_core();
$msg = sprintf(__('You are using <span class="b">WordPress %s</span>.'),$GLOBALS[0]['wp_version']);
if ( isset($cur->response) && $cur->response == 'upgrade' && current_user_can('manage_options'))
 $msg .= " <a href='update-core.php' class='button'>" . sprintf(__('Update to %s'),$cur->current ? $cur->current : __('Latest')) . '</a>';
echo "<span id='wp-version-message'>$msg</span>";
 }
function get_plugin_updates (  ) {
$all_plugins = get_plugins();
$upgrade_plugins = array();
$current = get_transient('update_plugins');
foreach ( (array)$all_plugins as $plugin_file =>$plugin_data )
{if ( isset($current->response[$plugin_file]))
 {$upgrade_plugins[$plugin_file] = (object)$plugin_data;
$upgrade_plugins[$plugin_file]->update = $current->response[$plugin_file];
}}{$AspisRetTemp = $upgrade_plugins;
return $AspisRetTemp;
} }
function wp_plugin_update_rows (  ) {
$plugins = get_transient('update_plugins');
if ( isset($plugins->response) && is_array($plugins->response))
 {$plugins = array_keys($plugins->response);
foreach ( $plugins as $plugin_file  )
{add_action("after_plugin_row_$plugin_file",'wp_plugin_update_row',10,2);
}} }
add_action('admin_init','wp_plugin_update_rows');
function wp_plugin_update_row ( $file,$plugin_data ) {
$current = get_transient('update_plugins');
if ( !isset($current->response[$file]))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$r = $current->response[$file];
$plugins_allowedtags = array('a' => array('href' => array(),'title' => array()),'abbr' => array('title' => array()),'acronym' => array('title' => array()),'code' => array(),'em' => array(),'strong' => array());
$plugin_name = wp_kses($plugin_data['Name'],$plugins_allowedtags);
$details_url = admin_url('plugin-install.php?tab=plugin-information&plugin=' . $r->slug . '&TB_iframe=true&width=600&height=800');
echo '<tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">';
if ( !current_user_can('update_plugins'))
 printf(__('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s Details</a>.'),$plugin_name,esc_url($details_url),esc_attr($plugin_name),$r->new_version);
else 
{if ( empty($r->package))
 printf(__('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s Details</a> <em>automatic upgrade unavailable for this plugin</em>.'),$plugin_name,esc_url($details_url),esc_attr($plugin_name),$r->new_version);
else 
{printf(__('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%3$s">View version %4$s Details</a> or <a href="%5$s">upgrade automatically</a>.'),$plugin_name,esc_url($details_url),esc_attr($plugin_name),$r->new_version,wp_nonce_url('update.php?action=upgrade-plugin&plugin=' . $file,'upgrade-plugin_' . $file));
}}do_action("in_plugin_update_message-$file",$plugin_data,$r);
echo '</div></td></tr>';
 }
function wp_update_plugin ( $plugin,$feedback = '' ) {
if ( !empty($feedback))
 add_filter('update_feedback',$feedback);
include ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
$upgrader = new Plugin_Upgrader();
{$AspisRetTemp = $upgrader->upgrade($plugin);
return $AspisRetTemp;
} }
function get_theme_updates (  ) {
$themes = get_themes();
$current = get_transient('update_themes');
$update_themes = array();
foreach ( $themes as $theme  )
{$theme = (object)$theme;
if ( isset($current->response[$theme->Stylesheet]))
 {$update_themes[$theme->Stylesheet] = $theme;
$update_themes[$theme->Stylesheet]->update = $current->response[$theme->Stylesheet];
}}{$AspisRetTemp = $update_themes;
return $AspisRetTemp;
} }
function wp_update_theme ( $theme,$feedback = '' ) {
if ( !empty($feedback))
 add_filter('update_feedback',$feedback);
include ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
$upgrader = new Theme_Upgrader();
{$AspisRetTemp = $upgrader->upgrade($theme);
return $AspisRetTemp;
} }
function wp_update_core ( $current,$feedback = '' ) {
if ( !empty($feedback))
 add_filter('update_feedback',$feedback);
include ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
$upgrader = new Core_Upgrader();
{$AspisRetTemp = $upgrader->upgrade($current);
return $AspisRetTemp;
} }
function maintenance_nag (  ) {
{global $upgrading;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $upgrading,"\$upgrading",$AspisChangesCache);
}if ( !isset($upgrading))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$upgrading",$AspisChangesCache);
return $AspisRetTemp;
}if ( current_user_can('manage_options'))
 $msg = sprintf(__('An automated WordPress update has failed to complete - <a href="%s">please attempt the update again now</a>.'),'update-core.php');
else 
{$msg = __('An automated WordPress update has failed to complete! Please notify the site administrator.');
}echo "<div id='update-nag'>$msg</div>";
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$upgrading",$AspisChangesCache);
 }
add_action('admin_notices','maintenance_nag');
;
?>
<?php 