<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
require ('includes/dashboard.php');
require_once (ABSPATH . WPINC . '/rss.php');
@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
switch ( deAspisWarningRC($_GET[0]['jax']) ) {
case 'dashboard_incoming_links':wp_dashboard_incoming_links_output();
break ;
case 'dashboard_primary':wp_dashboard_rss_output('dashboard_primary');
break ;
case 'dashboard_secondary':wp_dashboard_secondary_output();
break ;
case 'dashboard_plugins':wp_dashboard_plugins_output();
break ;
 }
;
