<?php require_once('AspisMain.php'); ?><?php
function wp_version_check (  ) {
if ( defined('WP_INSTALLING'))
 {return ;
}{global $wp_version,$wpdb,$wp_local_package;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_version,"\$wp_version",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_local_package,"\$wp_local_package",$AspisChangesCache);
}$php_version = phpversion();
$current = get_transient('update_core');
if ( !is_object($current))
 {$current = new stdClass;
$current->updates = array();
$current->version_checked = $wp_version;
}$locale = apply_filters('core_version_check_locale',get_locale());
$current->last_checked = time();
set_transient('update_core',$current);
if ( method_exists($wpdb,'db_version'))
 $mysql_version = preg_replace('/[^0-9.].*/','',$wpdb->db_version());
else 
{$mysql_version = 'N/A';
}$local_package = isset($wp_local_package) ? $wp_local_package : '';
$url = "http://api.wordpress.org/core/version-check/1.3/?version=$wp_version&php=$php_version&locale=$locale&mysql=$mysql_version&local_package=$local_package";
$options = array('timeout' => ((defined('DOING_CRON') && DOING_CRON) ? 30 : 3),'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url'));
$response = wp_remote_get($url,$options);
if ( is_wp_error($response))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_local_package",$AspisChangesCache);
return $AspisRetTemp;
}if ( 200 != $response['response']['code'])
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_local_package",$AspisChangesCache);
return $AspisRetTemp;
}$body = trim($response['body']);
$body = str_replace(array("\r\n","\r"),"\n",$body);
$new_options = array();
foreach ( explode("\n\n",$body) as $entry  )
{$returns = explode("\n",$entry);
$new_option = new stdClass();
$new_option->response = esc_attr($returns[0]);
if ( isset($returns[1]))
 $new_option->url = esc_url($returns[1]);
if ( isset($returns[2]))
 $new_option->package = esc_url($returns[2]);
if ( isset($returns[3]))
 $new_option->current = esc_attr($returns[3]);
if ( isset($returns[4]))
 $new_option->locale = esc_attr($returns[4]);
$new_options[] = $new_option;
}$updates = new stdClass();
$updates->updates = $new_options;
$updates->last_checked = time();
$updates->version_checked = $wp_version;
set_transient('update_core',$updates);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_local_package",$AspisChangesCache);
 }
function wp_update_plugins (  ) {
{global $wp_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_version,"\$wp_version",$AspisChangesCache);
}if ( defined('WP_INSTALLING'))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}if ( !function_exists('get_plugins'))
 require_once (ABSPATH . 'wp-admin/includes/plugin.php');
$plugins = get_plugins();
$active = get_option('active_plugins');
$current = get_transient('update_plugins');
if ( !is_object($current))
 $current = new stdClass;
$new_option = new stdClass;
$new_option->last_checked = time();
$timeout = 'load-plugins.php' == current_filter() ? 3600 : 43200;
$time_not_changed = isset($current->last_checked) && $timeout > (time() - $current->last_checked);
$plugin_changed = false;
foreach ( $plugins as $file =>$p )
{$new_option->checked[$file] = $p['Version'];
if ( !isset($current->checked[$file]) || strval($current->checked[$file]) !== strval($p['Version']))
 $plugin_changed = true;
}if ( isset($current->response) && is_array($current->response))
 {foreach ( $current->response as $plugin_file =>$update_details )
{if ( !isset($plugins[$plugin_file]))
 {$plugin_changed = true;
break ;
}}}if ( $time_not_changed && !$plugin_changed)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}$current->last_checked = time();
set_transient('update_plugins',$current);
$to_send = (object)compact('plugins','active');
$options = array('timeout' => ((defined('DOING_CRON') && DOING_CRON) ? 30 : 3),'body' => array('plugins' => serialize($to_send)),'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url'));
$raw_response = wp_remote_post('http://api.wordpress.org/plugins/update-check/1.0/',$options);
if ( is_wp_error($raw_response))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}if ( 200 != $raw_response['response']['code'])
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}$response = AspisUntainted_unserialize($raw_response['body']);
if ( false !== $response)
 $new_option->response = $response;
else 
{$new_option->response = array();
}set_transient('update_plugins',$new_option);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
 }
function wp_update_themes (  ) {
{global $wp_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_version,"\$wp_version",$AspisChangesCache);
}if ( defined('WP_INSTALLING'))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}if ( !function_exists('get_themes'))
 require_once (ABSPATH . 'wp-includes/theme.php');
$installed_themes = get_themes();
$current_theme = get_transient('update_themes');
if ( !is_object($current_theme))
 $current_theme = new stdClass;
$new_option = new stdClass;
$new_option->last_checked = time();
$timeout = 'load-themes.php' == current_filter() ? 3600 : 43200;
$time_not_changed = isset($current_theme->last_checked) && $timeout > (time() - $current_theme->last_checked);
$themes = array();
$checked = array();
$themes['current_theme'] = (array)$current_theme;
foreach ( (array)$installed_themes as $theme_title =>$theme )
{$themes[$theme['Stylesheet']] = array();
$checked[$theme['Stylesheet']] = $theme['Version'];
foreach ( (array)$theme as $key =>$value )
{$themes[$theme['Stylesheet']][$key] = $value;
}}$theme_changed = false;
foreach ( $checked as $slug =>$v )
{$new_option->checked[$slug] = $v;
if ( !isset($current_theme->checked[$slug]) || strval($current_theme->checked[$slug]) !== strval($v))
 $theme_changed = true;
}if ( isset($current_theme->response) && is_array($current_theme->response))
 {foreach ( $current_theme->response as $slug =>$update_details )
{if ( !isset($checked[$slug]))
 {$theme_changed = true;
break ;
}}}if ( $time_not_changed && !$theme_changed)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}$current_theme->last_checked = time();
set_transient('update_themes',$current_theme);
$current_theme->template = get_option('template');
$options = array('timeout' => ((defined('DOING_CRON') && DOING_CRON) ? 30 : 3),'body' => array('themes' => serialize($themes)),'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url'));
$raw_response = wp_remote_post('http://api.wordpress.org/themes/update-check/1.0/',$options);
if ( is_wp_error($raw_response))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}if ( 200 != $raw_response['response']['code'])
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}$response = AspisUntainted_unserialize($raw_response['body']);
if ( $response)
 {$new_option->checked = $checked;
$new_option->response = $response;
}set_transient('update_themes',$new_option);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
 }
function _maybe_update_core (  ) {
{global $wp_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_version,"\$wp_version",$AspisChangesCache);
}$current = get_transient('update_core');
if ( isset($current->last_checked) && 43200 > (time() - $current->last_checked) && isset($current->version_checked) && $current->version_checked == $wp_version)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return ;
}wp_version_check();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
 }
function _maybe_update_plugins (  ) {
$current = get_transient('update_plugins');
if ( isset($current->last_checked) && 43200 > (time() - $current->last_checked))
 {return ;
}wp_update_plugins();
 }
function _maybe_update_themes (  ) {
$current = get_transient('update_themes');
if ( isset($current->last_checked) && 43200 > (time() - $current->last_checked))
 {return ;
}wp_update_themes();
 }
add_action('admin_init','_maybe_update_core');
add_action('wp_version_check','wp_version_check');
add_action('load-plugins.php','wp_update_plugins');
add_action('load-update.php','wp_update_plugins');
add_action('load-update-core.php','wp_update_plugins');
add_action('admin_init','_maybe_update_plugins');
add_action('wp_update_plugins','wp_update_plugins');
add_action('load-themes.php','wp_update_themes');
add_action('load-update.php','wp_update_themes');
add_action('admin_init','_maybe_update_themes');
add_action('wp_update_themes','wp_update_themes');
if ( !wp_next_scheduled('wp_version_check') && !defined('WP_INSTALLING'))
 wp_schedule_event(time(),'twicedaily','wp_version_check');
if ( !wp_next_scheduled('wp_update_plugins') && !defined('WP_INSTALLING'))
 wp_schedule_event(time(),'twicedaily','wp_update_plugins');
if ( !wp_next_scheduled('wp_update_themes') && !defined('WP_INSTALLING'))
 wp_schedule_event(time(),'twicedaily','wp_update_themes');
;
?>
<?php 