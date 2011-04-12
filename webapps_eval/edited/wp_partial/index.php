<?php require_once('AspisMain.php'); ?><?php
$time = round(microtime(true),6);
define('WP_USE_THEMES',true);
require ('./wp-blog-header.php');
$time2 = round(microtime(true),6);
$generation = round(($time2 - $time) * 1000,3);
$f = @file_get_contents("stats.txt");
if ( $f == false)
 $all_results = array();
else 
{$all_results = AspisUntainted_unserialize($f);
}$all_results[] = $generation;
file_put_contents("stats.txt",serialize($all_results));
echo "This page took $generation ms to render";
;
