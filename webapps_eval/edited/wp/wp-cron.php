<?php require_once('AspisMain.php'); ?><?php
ignore_user_abort(true);
if ( (((!((empty($_POST) || Aspis_empty( $_POST)))) || defined(('DOING_AJAX'))) || defined(('DOING_CRON'))))
 Aspis_exit();
define(('DOING_CRON'),true);
if ( (!(defined(('ABSPATH')))))
 {require_once ('./wp-load.php');
}if ( (false === deAspis($crons = _get_cron_array())))
 Aspis_exit();
$keys = attAspisRC(array_keys(deAspisRC($crons)));
$local_time = attAspis(time());
if ( (((isset($keys[0][(0)]) && Aspis_isset( $keys [0][(0)]))) && (deAspis(attachAspis($keys,(0))) > $local_time[0])))
 Aspis_exit();
foreach ( $crons[0] as $timestamp =>$cronhooks )
{restoreTaint($timestamp,$cronhooks);
{if ( ($timestamp[0] > $local_time[0]))
 break ;
foreach ( $cronhooks[0] as $hook =>$keys )
{restoreTaint($hook,$keys);
{foreach ( $keys[0] as $k =>$v )
{restoreTaint($k,$v);
{$schedule = $v[0]['schedule'];
if ( ($schedule[0] != false))
 {$new_args = array(array($timestamp,$schedule,$hook,$v[0]['args']),false);
Aspis_call_user_func_array(array('wp_reschedule_event',false),$new_args);
}wp_unschedule_event($timestamp,$hook,$v[0]['args']);
do_action_ref_array($hook,$v[0]['args']);
}}}}}}Aspis_exit();
