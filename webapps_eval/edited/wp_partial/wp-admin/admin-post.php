<?php require_once('AspisMain.php'); ?><?php
define('WP_ADMIN',true);
if ( defined('ABSPATH'))
 require_once (ABSPATH . 'wp-load.php');
else 
{require_once ('../wp-load.php');
}require_once (ABSPATH . 'wp-admin/includes/admin.php');
nocache_headers();
do_action('admin_init');
$action = 'admin_post';
if ( !wp_validate_auth_cookie())
 $action .= '_nopriv';
if ( !(empty($_REQUEST[0]['action']) || Aspis_empty($_REQUEST[0]['action'])))
 $action .= '_' . deAspisWarningRC($_REQUEST[0]['action']);
do_action($action);
;
