<?php require_once('AspisMain.php'); ?><?php
require (dirname(__FILE__) . '/wp-load.php');
if ( get_magic_quotes_gpc())
 $_POST[0]['post_password'] = attAspisRCO(stripslashes(deAspisWarningRC($_POST[0]['post_password'])));
setcookie('wp-postpass_' . COOKIEHASH,deAspisWarningRC($_POST[0]['post_password']),time() + 864000,COOKIEPATH);
wp_safe_redirect(wp_get_referer());
;
