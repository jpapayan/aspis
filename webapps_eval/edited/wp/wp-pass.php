<?php require_once('AspisMain.php'); ?><?php
require (deconcat2(Aspis_dirname(array(__FILE__,false)),'/wp-load.php'));
if ( (get_magic_quotes_gpc()))
 arrayAssign($_POST[0],deAspis(registerTaint(array('post_password',false))),addTaint(Aspis_stripslashes($_POST[0]['post_password'])));
setcookie((deconcat12('wp-postpass_',COOKIEHASH)),deAspis($_POST[0]['post_password']),(time() + (864000)),COOKIEPATH);
wp_safe_redirect(wp_get_referer());
;
