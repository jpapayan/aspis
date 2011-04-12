<?php require_once('AspisMain.php'); ?><?php
require ('./wp-load.php');
wp_redirect(get_bloginfo('rss_url'),301);
;
