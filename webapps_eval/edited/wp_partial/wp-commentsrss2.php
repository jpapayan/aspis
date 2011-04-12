<?php require_once('AspisMain.php'); ?><?php
require ('./wp-load.php');
wp_redirect(get_bloginfo('comments_rss2_url'),301);
;
