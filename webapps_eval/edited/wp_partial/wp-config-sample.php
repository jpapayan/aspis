<?php require_once('AspisMain.php'); ?><?php
define('DB_NAME','putyourdbnamehere');
define('DB_USER','usernamehere');
define('DB_PASSWORD','yourpasswordhere');
define('DB_HOST','localhost');
define('DB_CHARSET','utf8');
define('DB_COLLATE','');
define('AUTH_KEY','put your unique phrase here');
define('SECURE_AUTH_KEY','put your unique phrase here');
define('LOGGED_IN_KEY','put your unique phrase here');
define('NONCE_KEY','put your unique phrase here');
$table_prefix = 'wp_';
define('WPLANG','');
if ( !defined('ABSPATH'))
 define('ABSPATH',dirname(__FILE__) . '/');
require_once (ABSPATH . 'wp-settings.php');