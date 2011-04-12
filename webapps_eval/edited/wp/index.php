<?php require_once('AspisMain.php'); ?><?php
$time = attAspis(round(deAspis(attAspisRC(microtime(true))),(6)));
define(('WP_USE_THEMES'),true);
require ('./wp-blog-header.php');
$time2 = attAspis(round(deAspis(attAspisRC(microtime(true))),(6)));
$generation = attAspis(round((($time2[0] - $time[0]) * (1000)),(3)));
$f = @attAspis(file_get_contents(("stats.txt")));
if ( ($f[0] == false))
 $all_results = array(array(),false);
else 
{$all_results = Aspis_unserialize($f);
}arrayAssignAdd($all_results[0][],addTaint($generation));
file_put_contents("stats.txt",deAspisRC(Aspis_serialize($all_results)));
echo AspisCheckPrint(concat2(concat1("This page took ",$generation)," ms to render"));
;
