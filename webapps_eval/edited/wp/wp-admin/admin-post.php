<?php require_once('AspisMain.php'); ?><?php
define(('WP_ADMIN'),true);
if ( defined(('ABSPATH')))
 require_once (deconcat12(ABSPATH,'wp-load.php'));
else 
{require_once ('../wp-load.php');
}require_once (deconcat12(ABSPATH,'wp-admin/includes/admin.php'));
nocache_headers();
do_action(array('admin_init',false));
$action = array('admin_post',false);
if ( (denot_boolean(wp_validate_auth_cookie())))
 $action = concat2($action,'_nopriv');
if ( (!((empty($_REQUEST[0][('action')]) || Aspis_empty( $_REQUEST [0][('action')])))))
 $action = concat($action,concat1('_',$_REQUEST[0]['action']));
do_action($action);
;
