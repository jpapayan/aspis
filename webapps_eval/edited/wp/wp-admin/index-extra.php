<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
require ('includes/dashboard.php');
require_once (deconcat2(concat12(ABSPATH,WPINC),'/rss.php'));
@header((deconcat(concat2(concat1('Content-Type: ',get_option(array('html_type',false))),'; charset='),get_option(array('blog_charset',false)))));
switch ( deAspis($_GET[0]['jax']) ) {
case ('dashboard_incoming_links'):wp_dashboard_incoming_links_output();
break ;
case ('dashboard_primary'):wp_dashboard_rss_output(array('dashboard_primary',false));
break ;
case ('dashboard_secondary'):wp_dashboard_secondary_output();
break ;
case ('dashboard_plugins'):wp_dashboard_plugins_output();
break ;
 }
;
