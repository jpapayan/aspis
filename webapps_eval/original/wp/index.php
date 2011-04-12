<?php
$time = round(microtime(true), 6);

/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require('./wp-blog-header.php');


$time2 = round(microtime(true), 6);
$generation = round(($time2 - $time)*1000,3);
$f=@file_get_contents("stats.txt");
if ($f==false) $all_results=array();
else $all_results=unserialize($f);
$all_results[]=$generation;
file_put_contents("stats.txt",serialize($all_results));

echo "This page took $generation ms to render";
?>