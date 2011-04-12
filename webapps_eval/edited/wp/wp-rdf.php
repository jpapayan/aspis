<?php require_once('AspisMain.php'); ?><?php
require ('./wp-load.php');
wp_redirect(get_bloginfo(array('rdf_url',false)),array(301,false));
;
