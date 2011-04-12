<?php require_once('AspisMain.php'); ?><?php
ignore_user_abort(true);
if ( !(empty($_POST) || Aspis_empty($_POST)) || defined('DOING_AJAX') || defined('DOING_CRON'))
 exit();
define('DOING_CRON',true);
if ( !defined('ABSPATH'))
 {require_once ('./wp-load.php');
}if ( false === $crons = _get_cron_array())
 exit();
$keys = array_keys($crons);
$local_time = time();
if ( isset($keys[0]) && $keys[0] > $local_time)
 exit();
foreach ( $crons as $timestamp =>$cronhooks )
{if ( $timestamp > $local_time)
 break ;
foreach ( $cronhooks as $hook =>$keys )
{foreach ( $keys as $k =>$v )
{$schedule = $v['schedule'];
if ( $schedule != false)
 {$new_args = array($timestamp,$schedule,$hook,$v['args']);
AspisUntainted_call_user_func_array('wp_reschedule_event',$new_args);
}wp_unschedule_event($timestamp,$hook,$v['args']);
do_action_ref_array($hook,$v['args']);
}}}exit();
