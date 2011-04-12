<?php require_once('AspisMain.php'); ?><?php
function wp_version_check (  ) {
if ( defined(('WP_INSTALLING')))
 return ;
global $wp_version,$wpdb,$wp_local_package;
$php_version = array(phpversion(),false);
$current = get_transient(array('update_core',false));
if ( (!(is_object($current[0]))))
 {$current = array(new stdClass,false);
$current[0]->updates = array(array(),false);
$current[0]->version_checked = $wp_version;
}$locale = apply_filters(array('core_version_check_locale',false),get_locale());
$current[0]->last_checked = attAspis(time());
set_transient(array('update_core',false),$current);
if ( method_exists(deAspisRC($wpdb),('db_version')))
 $mysql_version = Aspis_preg_replace(array('/[^0-9.].*/',false),array('',false),$wpdb[0]->db_version());
else 
{$mysql_version = array('N/A',false);
}$local_package = ((isset($wp_local_package) && Aspis_isset( $wp_local_package))) ? $wp_local_package : array('',false);
$url = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("http://api.wordpress.org/core/version-check/1.3/?version=",$wp_version),"&php="),$php_version),"&locale="),$locale),"&mysql="),$mysql_version),"&local_package="),$local_package);
$options = array(array(deregisterTaint(array('timeout',false)) => addTaint(((defined(('DOING_CRON')) && DOING_CRON) ? array(30,false) : array(3,false))),deregisterTaint(array('user-agent',false)) => addTaint(concat(concat2(concat1('WordPress/',$wp_version),'; '),get_bloginfo(array('url',false))))),false);
$response = wp_remote_get($url,$options);
if ( deAspis(is_wp_error($response)))
 return array(false,false);
if ( ((200) != deAspis($response[0][('response')][0]['code'])))
 return array(false,false);
$body = Aspis_trim($response[0]['body']);
$body = Aspis_str_replace(array(array(array("\r\n",false),array("\r",false)),false),array("\n",false),$body);
$new_options = array(array(),false);
foreach ( deAspis(Aspis_explode(array("\n\n",false),$body)) as $entry  )
{$returns = Aspis_explode(array("\n",false),$entry);
$new_option = array(new stdClass(),false);
$new_option[0]->response = esc_attr(attachAspis($returns,(0)));
if ( ((isset($returns[0][(1)]) && Aspis_isset( $returns [0][(1)]))))
 $new_option[0]->url = esc_url(attachAspis($returns,(1)));
if ( ((isset($returns[0][(2)]) && Aspis_isset( $returns [0][(2)]))))
 $new_option[0]->package = esc_url(attachAspis($returns,(2)));
if ( ((isset($returns[0][(3)]) && Aspis_isset( $returns [0][(3)]))))
 $new_option[0]->current = esc_attr(attachAspis($returns,(3)));
if ( ((isset($returns[0][(4)]) && Aspis_isset( $returns [0][(4)]))))
 $new_option[0]->locale = esc_attr(attachAspis($returns,(4)));
arrayAssignAdd($new_options[0][],addTaint($new_option));
}$updates = array(new stdClass(),false);
$updates[0]->updates = $new_options;
$updates[0]->last_checked = attAspis(time());
$updates[0]->version_checked = $wp_version;
set_transient(array('update_core',false),$updates);
 }
function wp_update_plugins (  ) {
global $wp_version;
if ( defined(('WP_INSTALLING')))
 return array(false,false);
if ( (!(function_exists(('get_plugins')))))
 require_once (deconcat12(ABSPATH,'wp-admin/includes/plugin.php'));
$plugins = get_plugins();
$active = get_option(array('active_plugins',false));
$current = get_transient(array('update_plugins',false));
if ( (!(is_object($current[0]))))
 $current = array(new stdClass,false);
$new_option = array(new stdClass,false);
$new_option[0]->last_checked = attAspis(time());
$timeout = (('load-plugins.php') == deAspis(current_filter())) ? array(3600,false) : array(43200,false);
$time_not_changed = array(((isset($current[0]->last_checked) && Aspis_isset( $current[0] ->last_checked ))) && ($timeout[0] > (time() - $current[0]->last_checked[0])),false);
$plugin_changed = array(false,false);
foreach ( $plugins[0] as $file =>$p )
{restoreTaint($file,$p);
{arrayAssign($new_option[0]->checked[0],deAspis(registerTaint($file)),addTaint($p[0]['Version']));
if ( ((!((isset($current[0]->checked[0][$file[0]]) && Aspis_isset( $current[0] ->checked [0][$file[0]] )))) || (deAspis(Aspis_strval($current[0]->checked[0][$file[0]])) !== deAspis(Aspis_strval($p[0]['Version'])))))
 $plugin_changed = array(true,false);
}}if ( (((isset($current[0]->response) && Aspis_isset( $current[0] ->response ))) && is_array($current[0]->response[0])))
 {foreach ( $current[0]->response[0] as $plugin_file =>$update_details )
{restoreTaint($plugin_file,$update_details);
{if ( (!((isset($plugins[0][$plugin_file[0]]) && Aspis_isset( $plugins [0][$plugin_file[0]])))))
 {$plugin_changed = array(true,false);
break ;
}}}}if ( ($time_not_changed[0] && (denot_boolean($plugin_changed))))
 return array(false,false);
$current[0]->last_checked = attAspis(time());
set_transient(array('update_plugins',false),$current);
$to_send = object_cast(array(compact('plugins','active'),false));
$options = array(array(deregisterTaint(array('timeout',false)) => addTaint(((defined(('DOING_CRON')) && DOING_CRON) ? array(30,false) : array(3,false))),'body' => array(array(deregisterTaint(array('plugins',false)) => addTaint(Aspis_serialize($to_send))),false,false),deregisterTaint(array('user-agent',false)) => addTaint(concat(concat2(concat1('WordPress/',$wp_version),'; '),get_bloginfo(array('url',false))))),false);
$raw_response = wp_remote_post(array('http://api.wordpress.org/plugins/update-check/1.0/',false),$options);
if ( deAspis(is_wp_error($raw_response)))
 return array(false,false);
if ( ((200) != deAspis($raw_response[0][('response')][0]['code'])))
 return array(false,false);
$response = Aspis_unserialize($raw_response[0]['body']);
if ( (false !== $response[0]))
 $new_option[0]->response = $response;
else 
{$new_option[0]->response = array(array(),false);
}set_transient(array('update_plugins',false),$new_option);
 }
function wp_update_themes (  ) {
global $wp_version;
if ( defined(('WP_INSTALLING')))
 return array(false,false);
if ( (!(function_exists(('get_themes')))))
 require_once (deconcat12(ABSPATH,'wp-includes/theme.php'));
$installed_themes = get_themes();
$current_theme = get_transient(array('update_themes',false));
if ( (!(is_object($current_theme[0]))))
 $current_theme = array(new stdClass,false);
$new_option = array(new stdClass,false);
$new_option[0]->last_checked = attAspis(time());
$timeout = (('load-themes.php') == deAspis(current_filter())) ? array(3600,false) : array(43200,false);
$time_not_changed = array(((isset($current_theme[0]->last_checked) && Aspis_isset( $current_theme[0] ->last_checked ))) && ($timeout[0] > (time() - $current_theme[0]->last_checked[0])),false);
$themes = array(array(),false);
$checked = array(array(),false);
arrayAssign($themes[0],deAspis(registerTaint(array('current_theme',false))),addTaint(array_cast($current_theme)));
foreach ( deAspis(array_cast($installed_themes)) as $theme_title =>$theme )
{restoreTaint($theme_title,$theme);
{arrayAssign($themes[0],deAspis(registerTaint($theme[0]['Stylesheet'])),addTaint(array(array(),false)));
arrayAssign($checked[0],deAspis(registerTaint($theme[0]['Stylesheet'])),addTaint($theme[0]['Version']));
foreach ( deAspis(array_cast($theme)) as $key =>$value )
{restoreTaint($key,$value);
{arrayAssign($themes[0][deAspis($theme[0]['Stylesheet'])][0],deAspis(registerTaint($key)),addTaint($value));
}}}}$theme_changed = array(false,false);
foreach ( $checked[0] as $slug =>$v )
{restoreTaint($slug,$v);
{arrayAssign($new_option[0]->checked[0],deAspis(registerTaint($slug)),addTaint($v));
if ( ((!((isset($current_theme[0]->checked[0][$slug[0]]) && Aspis_isset( $current_theme[0] ->checked [0][$slug[0]] )))) || (deAspis(Aspis_strval($current_theme[0]->checked[0][$slug[0]])) !== deAspis(Aspis_strval($v)))))
 $theme_changed = array(true,false);
}}if ( (((isset($current_theme[0]->response) && Aspis_isset( $current_theme[0] ->response ))) && is_array($current_theme[0]->response[0])))
 {foreach ( $current_theme[0]->response[0] as $slug =>$update_details )
{restoreTaint($slug,$update_details);
{if ( (!((isset($checked[0][$slug[0]]) && Aspis_isset( $checked [0][$slug[0]])))))
 {$theme_changed = array(true,false);
break ;
}}}}if ( ($time_not_changed[0] && (denot_boolean($theme_changed))))
 return array(false,false);
$current_theme[0]->last_checked = attAspis(time());
set_transient(array('update_themes',false),$current_theme);
$current_theme[0]->template = get_option(array('template',false));
$options = array(array(deregisterTaint(array('timeout',false)) => addTaint(((defined(('DOING_CRON')) && DOING_CRON) ? array(30,false) : array(3,false))),'body' => array(array(deregisterTaint(array('themes',false)) => addTaint(Aspis_serialize($themes))),false,false),deregisterTaint(array('user-agent',false)) => addTaint(concat(concat2(concat1('WordPress/',$wp_version),'; '),get_bloginfo(array('url',false))))),false);
$raw_response = wp_remote_post(array('http://api.wordpress.org/themes/update-check/1.0/',false),$options);
if ( deAspis(is_wp_error($raw_response)))
 return array(false,false);
if ( ((200) != deAspis($raw_response[0][('response')][0]['code'])))
 return array(false,false);
$response = Aspis_unserialize($raw_response[0]['body']);
if ( $response[0])
 {$new_option[0]->checked = $checked;
$new_option[0]->response = $response;
}set_transient(array('update_themes',false),$new_option);
 }
function _maybe_update_core (  ) {
global $wp_version;
$current = get_transient(array('update_core',false));
if ( (((((isset($current[0]->last_checked) && Aspis_isset( $current[0] ->last_checked ))) && ((43200) > (time() - $current[0]->last_checked[0]))) && ((isset($current[0]->version_checked) && Aspis_isset( $current[0] ->version_checked )))) && ($current[0]->version_checked[0] == $wp_version[0])))
 return ;
wp_version_check();
 }
function _maybe_update_plugins (  ) {
$current = get_transient(array('update_plugins',false));
if ( (((isset($current[0]->last_checked) && Aspis_isset( $current[0] ->last_checked ))) && ((43200) > (time() - $current[0]->last_checked[0]))))
 return ;
wp_update_plugins();
 }
function _maybe_update_themes (  ) {
$current = get_transient(array('update_themes',false));
if ( (((isset($current[0]->last_checked) && Aspis_isset( $current[0] ->last_checked ))) && ((43200) > (time() - $current[0]->last_checked[0]))))
 return ;
wp_update_themes();
 }
add_action(array('admin_init',false),array('_maybe_update_core',false));
add_action(array('wp_version_check',false),array('wp_version_check',false));
add_action(array('load-plugins.php',false),array('wp_update_plugins',false));
add_action(array('load-update.php',false),array('wp_update_plugins',false));
add_action(array('load-update-core.php',false),array('wp_update_plugins',false));
add_action(array('admin_init',false),array('_maybe_update_plugins',false));
add_action(array('wp_update_plugins',false),array('wp_update_plugins',false));
add_action(array('load-themes.php',false),array('wp_update_themes',false));
add_action(array('load-update.php',false),array('wp_update_themes',false));
add_action(array('admin_init',false),array('_maybe_update_themes',false));
add_action(array('wp_update_themes',false),array('wp_update_themes',false));
if ( ((denot_boolean(wp_next_scheduled(array('wp_version_check',false)))) && (!(defined(('WP_INSTALLING'))))))
 wp_schedule_event(attAspis(time()),array('twicedaily',false),array('wp_version_check',false));
if ( ((denot_boolean(wp_next_scheduled(array('wp_update_plugins',false)))) && (!(defined(('WP_INSTALLING'))))))
 wp_schedule_event(attAspis(time()),array('twicedaily',false),array('wp_update_plugins',false));
if ( ((denot_boolean(wp_next_scheduled(array('wp_update_themes',false)))) && (!(defined(('WP_INSTALLING'))))))
 wp_schedule_event(attAspis(time()),array('twicedaily',false),array('wp_update_themes',false));
;
?>
<?php 