<?php require_once('AspisMain.php'); ?><?php
if ( (!((isset($wp_did_header) && Aspis_isset( $wp_did_header)))))
 {$wp_did_header = array(true,false);
require_once (deconcat2(Aspis_dirname(array(__FILE__,false)),'/wp-load.php'));
wp();
require_once (deconcat2(concat12(ABSPATH,WPINC),'/template-loader.php'));
};
