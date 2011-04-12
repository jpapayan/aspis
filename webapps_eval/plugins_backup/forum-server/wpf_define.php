<?php
if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
	
define('WPFPLUGIN', "forum-server");

define('WPFDIR', dirname(plugin_basename(__FILE__)));
define('WPFPATH', WP_CONTENT_DIR . '/plugins/' . WPFDIR . '/');
define('WPFURL', WP_CONTENT_URL . '/plugins/' . WPFDIR . '/');
define('SKINDIR', WP_CONTENT_DIR . '/plugins/' . WPFDIR . '/skins/');
define('SKINURL', WP_CONTENT_URL . '/plugins/' . WPFDIR . '/skins/');
define('NO_SKIN_SCREENSHOT_URL', WP_CONTENT_URL . '/plugins/' . WPFDIR . '/skins/default.png');
//define("ADMIN_BASE_URL", "{$_SERVER['PHP_SELF']}?page=".WPFPLUGIN."/fs-admin//fs-admin.php&amp;vasthtml_action=");
define("ADMIN_BASE_URL", "admin.php?page=".WPFPLUGIN."/fs-admin/fs-admin.php&amp;vasthtml_action=");

define("ADMIN_PROFILE_URL", get_bloginfo("url")."/wp-admin/user-edit.php?user_id=");
define("PROFILE_URL", get_bloginfo("url")."/wp-admin/profile.php");

define("ADMIN_ROW_COL", "rows='8' cols='35'");
define("ROW_COL", "rows='20' cols='80'");

define("PHP_SELF", "{$_SERVER['PHP_SELF']}");

define('MAIN', "main");
define('FORUM', "forum");
define('THREAD', "thread");
define('SEARCH', "search");
define('PROFILE', "profile");
define('POSTREPLY', "postreply");
define('EDITPOST', "editpost");
define("NEWTOPICS", "newtopics");
define("NEWTOPIC", "newtopic");

define("CAT", 	__("Category", "vasthtml"));
if (!defined('FORUM')) {
	define("FORUM", __("Forum", "vasthtml"));
}
define("TOPIC", __("Topic", "vasthtml"));
define("POST", 	__("Post", "vasthtml"));

// What to display in the forum
define('USER', "nickname");
// Maybe change
define("SORT_ORDER", "DESC");

?>