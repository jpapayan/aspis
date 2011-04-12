<?php require_once('AspisMain.php'); ?><?php
define(('DB_NAME'),'wordpress');
define(('DB_USER'),'wordpress');
define(('DB_PASSWORD'),'pass2rule@ll8');
define(('DB_HOST'),'localhost');
define(('DB_CHARSET'),'utf8');
define(('DB_COLLATE'),'');
define(('AUTH_KEY'),'put your unique phrase here');
define(('SECURE_AUTH_KEY'),'put your unique phrase here');
define(('LOGGED_IN_KEY'),'put your unique phrase here');
define(('NONCE_KEY'),'put your unique phrase here');
$table_prefix = array('wp_',false);
define(('WPLANG'),'');
if ( (!(defined(('ABSPATH')))))
 define(('ABSPATH'),(deconcat2(Aspis_dirname(array(__FILE__,false)),'/')));
require_once (deconcat12(ABSPATH,'wp-settings.php'));
