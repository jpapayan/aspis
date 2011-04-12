<?php require_once('AspisMain.php'); ?><?php
function wp_schedule_single_event ( $timestamp,$hook,$args = array() ) {
$next = wp_next_scheduled($hook,$args);
if ( $next && $next <= $timestamp + 600)
 {return ;
}$crons = _get_cron_array();
$key = md5(serialize($args));
$crons[$timestamp][$hook][$key] = array('schedule' => false,'args' => $args);
uksort($crons,"strnatcasecmp");
_set_cron_array($crons);
 }
function wp_schedule_event ( $timestamp,$recurrence,$hook,$args = array() ) {
$crons = _get_cron_array();
$schedules = wp_get_schedules();
$key = md5(serialize($args));
if ( !isset($schedules[$recurrence]))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$crons[$timestamp][$hook][$key] = array('schedule' => $recurrence,'args' => $args,'interval' => $schedules[$recurrence]['interval']);
uksort($crons,"strnatcasecmp");
_set_cron_array($crons);
 }
function wp_reschedule_event ( $timestamp,$recurrence,$hook,$args = array() ) {
$crons = _get_cron_array();
$schedules = wp_get_schedules();
$key = md5(serialize($args));
$interval = 0;
if ( 0 == $interval)
 $interval = $schedules[$recurrence]['interval'];
if ( 0 == $interval)
 $interval = $crons[$timestamp][$hook][$key]['interval'];
if ( 0 == $interval)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$now = time();
if ( $timestamp >= $now)
 $timestamp = $now + $interval;
else 
{$timestamp = $now + ($interval - (($now - $timestamp) % $interval));
}wp_schedule_event($timestamp,$recurrence,$hook,$args);
 }
function wp_unschedule_event ( $timestamp,$hook,$args = array() ) {
$crons = _get_cron_array();
$key = md5(serialize($args));
unset($crons[$timestamp][$hook][$key]);
if ( empty($crons[$timestamp][$hook]))
 unset($crons[$timestamp][$hook]);
if ( empty($crons[$timestamp]))
 unset($crons[$timestamp]);
_set_cron_array($crons);
 }
function wp_clear_scheduled_hook ( $hook ) {
$args = array_slice(func_get_args(),1);
while ( $timestamp = wp_next_scheduled($hook,$args) )
wp_unschedule_event($timestamp,$hook,$args);
 }
function wp_next_scheduled ( $hook,$args = array() ) {
$crons = _get_cron_array();
$key = md5(serialize($args));
if ( empty($crons))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}foreach ( $crons as $timestamp =>$cron )
{if ( isset($cron[$hook][$key]))
 {$AspisRetTemp = $timestamp;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function spawn_cron ( $local_time = 0 ) {
if ( !$local_time)
 $local_time = time();
if ( defined('DOING_CRON') || (isset($_GET[0]['doing_wp_cron']) && Aspis_isset($_GET[0]['doing_wp_cron'])))
 {return ;
}$timer_accurate = check_server_timer($local_time);
if ( !$timer_accurate)
 {return ;
}$flag = get_transient('doing_cron');
if ( $flag > $local_time + 10 * 60)
 $flag = 0;
if ( $flag + 60 > $local_time)
 {return ;
}$crons = _get_cron_array();
if ( !is_array($crons))
 {return ;
}$keys = array_keys($crons);
if ( isset($keys[0]) && $keys[0] > $local_time)
 {return ;
}if ( defined('ALTERNATE_WP_CRON') && ALTERNATE_WP_CRON)
 {if ( !(empty($_POST) || Aspis_empty($_POST)) || defined('DOING_AJAX'))
 {return ;
}set_transient('doing_cron',$local_time);
ob_start();
wp_redirect(add_query_arg('doing_wp_cron','',stripslashes(deAspisWarningRC($_SERVER[0]['REQUEST_URI']))));
echo ' ';
while ( @ob_end_flush() )
;
flush();
@include_once (ABSPATH . 'wp-cron.php');
{return ;
}}set_transient('doing_cron',$local_time);
$cron_url = get_option('siteurl') . '/wp-cron.php?doing_wp_cron';
wp_remote_post($cron_url,array('timeout' => 0.01,'blocking' => false,'sslverify' => apply_filters('https_local_ssl_verify',true)));
 }
function wp_cron (  ) {
if ( strpos(deAspisWarningRC($_SERVER[0]['REQUEST_URI']),'/wp-cron.php') !== false || (defined('DISABLE_WP_CRON') && DISABLE_WP_CRON))
 {return ;
}if ( false === $crons = _get_cron_array())
 {return ;
}$local_time = time();
$keys = array_keys($crons);
if ( isset($keys[0]) && $keys[0] > $local_time)
 {return ;
}$schedules = wp_get_schedules();
foreach ( $crons as $timestamp =>$cronhooks )
{if ( $timestamp > $local_time)
 break ;
foreach ( (array)$cronhooks as $hook =>$args )
{if ( isset($schedules[$hook]['callback']) && !AspisUntainted_call_user_func($schedules[$hook]['callback']))
 continue ;
spawn_cron($local_time);
break 2;
}} }
function wp_get_schedules (  ) {
$schedules = array('hourly' => array('interval' => 3600,'display' => __('Once Hourly')),'twicedaily' => array('interval' => 43200,'display' => __('Twice Daily')),'daily' => array('interval' => 86400,'display' => __('Once Daily')),);
{$AspisRetTemp = array_merge(apply_filters('cron_schedules',array()),$schedules);
return $AspisRetTemp;
} }
function wp_get_schedule ( $hook,$args = array() ) {
$crons = _get_cron_array();
$key = md5(serialize($args));
if ( empty($crons))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}foreach ( $crons as $timestamp =>$cron )
{if ( isset($cron[$hook][$key]))
 {$AspisRetTemp = $cron[$hook][$key]['schedule'];
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function _get_cron_array (  ) {
$cron = get_option('cron');
if ( !is_array($cron))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !isset($cron['version']))
 $cron = _upgrade_cron_array($cron);
unset($cron['version']);
{$AspisRetTemp = $cron;
return $AspisRetTemp;
} }
function _set_cron_array ( $cron ) {
$cron['version'] = 2;
update_option('cron',$cron);
 }
function _upgrade_cron_array ( $cron ) {
if ( isset($cron['version']) && 2 == $cron['version'])
 {$AspisRetTemp = $cron;
return $AspisRetTemp;
}$new_cron = array();
foreach ( (array)$cron as $timestamp =>$hooks )
{foreach ( (array)$hooks as $hook =>$args )
{$key = md5(serialize($args['args']));
$new_cron[$timestamp][$hook][$key] = $args;
}}$new_cron['version'] = 2;
update_option('cron',$new_cron);
{$AspisRetTemp = $new_cron;
return $AspisRetTemp;
} }
function check_server_timer ( $local_time ) {
{$AspisRetTemp = true;
return $AspisRetTemp;
} }
