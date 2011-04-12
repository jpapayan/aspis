<?php require_once('AspisMain.php'); ?><?php
function wp_schedule_single_event ( $timestamp,$hook,$args = array(array(),false) ) {
$next = wp_next_scheduled($hook,$args);
if ( ($next[0] && ($next[0] <= ($timestamp[0] + (600)))))
 return ;
$crons = _get_cron_array();
$key = attAspis(md5(deAspis(Aspis_serialize($args))));
arrayAssign($crons[0][$timestamp[0]][0][$hook[0]][0],deAspis(registerTaint($key)),addTaint(array(array('schedule' => array(false,false,false),deregisterTaint(array('args',false)) => addTaint($args)),false)));
AspisInternalFunctionCall("uksort",AspisPushRefParam($crons),AspisInternalCallback(array("strnatcasecmp",false)),array(0));
_set_cron_array($crons);
 }
function wp_schedule_event ( $timestamp,$recurrence,$hook,$args = array(array(),false) ) {
$crons = _get_cron_array();
$schedules = wp_get_schedules();
$key = attAspis(md5(deAspis(Aspis_serialize($args))));
if ( (!((isset($schedules[0][$recurrence[0]]) && Aspis_isset( $schedules [0][$recurrence[0]])))))
 return array(false,false);
arrayAssign($crons[0][$timestamp[0]][0][$hook[0]][0],deAspis(registerTaint($key)),addTaint(array(array(deregisterTaint(array('schedule',false)) => addTaint($recurrence),deregisterTaint(array('args',false)) => addTaint($args),deregisterTaint(array('interval',false)) => addTaint($schedules[0][$recurrence[0]][0]['interval'])),false)));
AspisInternalFunctionCall("uksort",AspisPushRefParam($crons),AspisInternalCallback(array("strnatcasecmp",false)),array(0));
_set_cron_array($crons);
 }
function wp_reschedule_event ( $timestamp,$recurrence,$hook,$args = array(array(),false) ) {
$crons = _get_cron_array();
$schedules = wp_get_schedules();
$key = attAspis(md5(deAspis(Aspis_serialize($args))));
$interval = array(0,false);
if ( ((0) == $interval[0]))
 $interval = $schedules[0][$recurrence[0]][0]['interval'];
if ( ((0) == $interval[0]))
 $interval = $crons[0][$timestamp[0]][0][$hook[0]][0][$key[0]][0]['interval'];
if ( ((0) == $interval[0]))
 return array(false,false);
$now = attAspis(time());
if ( ($timestamp[0] >= $now[0]))
 $timestamp = array($now[0] + $interval[0],false);
else 
{$timestamp = array($now[0] + ($interval[0] - (($now[0] - $timestamp[0]) % $interval[0])),false);
}wp_schedule_event($timestamp,$recurrence,$hook,$args);
 }
function wp_unschedule_event ( $timestamp,$hook,$args = array(array(),false) ) {
$crons = _get_cron_array();
$key = attAspis(md5(deAspis(Aspis_serialize($args))));
unset($crons[0][$timestamp[0]][0][$hook[0]][0][$key[0]]);
if ( ((empty($crons[0][$timestamp[0]][0][$hook[0]]) || Aspis_empty( $crons [0][$timestamp[0]] [0][$hook[0]]))))
 unset($crons[0][$timestamp[0]][0][$hook[0]]);
if ( ((empty($crons[0][$timestamp[0]]) || Aspis_empty( $crons [0][$timestamp[0]]))))
 unset($crons[0][$timestamp[0]]);
_set_cron_array($crons);
 }
function wp_clear_scheduled_hook ( $hook ) {
$args = Aspis_array_slice(array(func_get_args(),false),array(1,false));
while ( deAspis($timestamp = wp_next_scheduled($hook,$args)) )
wp_unschedule_event($timestamp,$hook,$args);
 }
function wp_next_scheduled ( $hook,$args = array(array(),false) ) {
$crons = _get_cron_array();
$key = attAspis(md5(deAspis(Aspis_serialize($args))));
if ( ((empty($crons) || Aspis_empty( $crons))))
 return array(false,false);
foreach ( $crons[0] as $timestamp =>$cron )
{restoreTaint($timestamp,$cron);
{if ( ((isset($cron[0][$hook[0]][0][$key[0]]) && Aspis_isset( $cron [0][$hook[0]] [0][$key[0]]))))
 return $timestamp;
}}return array(false,false);
 }
function spawn_cron ( $local_time = array(0,false) ) {
if ( (denot_boolean($local_time)))
 $local_time = attAspis(time());
if ( (defined(('DOING_CRON')) || ((isset($_GET[0][('doing_wp_cron')]) && Aspis_isset( $_GET [0][('doing_wp_cron')])))))
 return ;
$timer_accurate = check_server_timer($local_time);
if ( (denot_boolean($timer_accurate)))
 return ;
$flag = get_transient(array('doing_cron',false));
if ( ($flag[0] > ($local_time[0] + ((10) * (60)))))
 $flag = array(0,false);
if ( (($flag[0] + (60)) > $local_time[0]))
 return ;
$crons = _get_cron_array();
if ( (!(is_array($crons[0]))))
 return ;
$keys = attAspisRC(array_keys(deAspisRC($crons)));
if ( (((isset($keys[0][(0)]) && Aspis_isset( $keys [0][(0)]))) && (deAspis(attachAspis($keys,(0))) > $local_time[0])))
 return ;
if ( (defined(('ALTERNATE_WP_CRON')) && ALTERNATE_WP_CRON))
 {if ( ((!((empty($_POST) || Aspis_empty( $_POST)))) || defined(('DOING_AJAX'))))
 return ;
set_transient(array('doing_cron',false),$local_time);
ob_start();
wp_redirect(add_query_arg(array('doing_wp_cron',false),array('',false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
echo AspisCheckPrint(array(' ',false));
while ( deAspis(@attAspis(ob_end_flush())) )
;
flush();
@include_once (deconcat12(ABSPATH,'wp-cron.php'));
return ;
}set_transient(array('doing_cron',false),$local_time);
$cron_url = concat2(get_option(array('siteurl',false)),'/wp-cron.php?doing_wp_cron');
wp_remote_post($cron_url,array(array('timeout' => array(0.01,false,false),'blocking' => array(false,false,false),deregisterTaint(array('sslverify',false)) => addTaint(apply_filters(array('https_local_ssl_verify',false),array(true,false)))),false));
 }
function wp_cron (  ) {
if ( ((strpos(deAspis($_SERVER[0]['REQUEST_URI']),'/wp-cron.php') !== false) || (defined(('DISABLE_WP_CRON')) && DISABLE_WP_CRON)))
 return ;
if ( (false === deAspis($crons = _get_cron_array())))
 return ;
$local_time = attAspis(time());
$keys = attAspisRC(array_keys(deAspisRC($crons)));
if ( (((isset($keys[0][(0)]) && Aspis_isset( $keys [0][(0)]))) && (deAspis(attachAspis($keys,(0))) > $local_time[0])))
 return ;
$schedules = wp_get_schedules();
foreach ( $crons[0] as $timestamp =>$cronhooks )
{restoreTaint($timestamp,$cronhooks);
{if ( ($timestamp[0] > $local_time[0]))
 break ;
foreach ( deAspis(array_cast($cronhooks)) as $hook =>$args )
{restoreTaint($hook,$args);
{if ( (((isset($schedules[0][$hook[0]][0][('callback')]) && Aspis_isset( $schedules [0][$hook[0]] [0][('callback')]))) && (denot_boolean(Aspis_call_user_func($schedules[0][$hook[0]][0]['callback'])))))
 continue ;
spawn_cron($local_time);
break (2);
}}}} }
function wp_get_schedules (  ) {
$schedules = array(array('hourly' => array(array('interval' => array(3600,false,false),deregisterTaint(array('display',false)) => addTaint(__(array('Once Hourly',false)))),false,false),'twicedaily' => array(array('interval' => array(43200,false,false),deregisterTaint(array('display',false)) => addTaint(__(array('Twice Daily',false)))),false,false),'daily' => array(array('interval' => array(86400,false,false),deregisterTaint(array('display',false)) => addTaint(__(array('Once Daily',false)))),false,false),),false);
return Aspis_array_merge(apply_filters(array('cron_schedules',false),array(array(),false)),$schedules);
 }
function wp_get_schedule ( $hook,$args = array(array(),false) ) {
$crons = _get_cron_array();
$key = attAspis(md5(deAspis(Aspis_serialize($args))));
if ( ((empty($crons) || Aspis_empty( $crons))))
 return array(false,false);
foreach ( $crons[0] as $timestamp =>$cron )
{restoreTaint($timestamp,$cron);
{if ( ((isset($cron[0][$hook[0]][0][$key[0]]) && Aspis_isset( $cron [0][$hook[0]] [0][$key[0]]))))
 return $cron[0][$hook[0]][0][$key[0]][0]['schedule'];
}}return array(false,false);
 }
function _get_cron_array (  ) {
$cron = get_option(array('cron',false));
if ( (!(is_array($cron[0]))))
 return array(false,false);
if ( (!((isset($cron[0][('version')]) && Aspis_isset( $cron [0][('version')])))))
 $cron = _upgrade_cron_array($cron);
unset($cron[0][('version')]);
return $cron;
 }
function _set_cron_array ( $cron ) {
arrayAssign($cron[0],deAspis(registerTaint(array('version',false))),addTaint(array(2,false)));
update_option(array('cron',false),$cron);
 }
function _upgrade_cron_array ( $cron ) {
if ( (((isset($cron[0][('version')]) && Aspis_isset( $cron [0][('version')]))) && ((2) == deAspis($cron[0]['version']))))
 return $cron;
$new_cron = array(array(),false);
foreach ( deAspis(array_cast($cron)) as $timestamp =>$hooks )
{restoreTaint($timestamp,$hooks);
{foreach ( deAspis(array_cast($hooks)) as $hook =>$args )
{restoreTaint($hook,$args);
{$key = attAspis(md5(deAspis(Aspis_serialize($args[0]['args']))));
arrayAssign($new_cron[0][$timestamp[0]][0][$hook[0]][0],deAspis(registerTaint($key)),addTaint($args));
}}}}arrayAssign($new_cron[0],deAspis(registerTaint(array('version',false))),addTaint(array(2,false)));
update_option(array('cron',false),$new_cron);
return $new_cron;
 }
function check_server_timer ( $local_time ) {
return array(true,false);
 }
