<?php require_once('AspisMain.php'); ?><?php
if ( !defined('WP_MEMORY_LIMIT'))
 define('WP_MEMORY_LIMIT','32M');
if ( function_exists('memory_get_usage') && ((int)@ini_get('memory_limit') < abs(intval(WP_MEMORY_LIMIT))))
 @ini_set('memory_limit',WP_MEMORY_LIMIT);
set_magic_quotes_runtime(0);
@ini_set('magic_quotes_sybase',0);
if ( function_exists('date_default_timezone_set'))
 date_default_timezone_set('UTC');
function wp_unregister_GLOBALS (  ) {
if ( !ini_get('register_globals'))
 {return ;
}if ( (isset($_REQUEST[0]['GLOBALS']) && Aspis_isset($_REQUEST[0]['GLOBALS'])))
 exit('GLOBALS overwrite attempt detected');
$noUnset = array('GLOBALS','_GET','_POST','_COOKIE','_REQUEST','_SERVER','_ENV','_FILES','table_prefix');
$input = array_merge(deAspisWarningRC($_GET),deAspisWarningRC($_POST),deAspisWarningRC($_COOKIE),deAspisWarningRC($_SERVER),deAspisWarningRC($_ENV),deAspisWarningRC($_FILES),isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());
foreach ( $input as $k =>$v )
if ( !in_array($k,$noUnset) && isset($GLOBALS[0][$k]))
 {$GLOBALS[0][$k] = NULL;
unset($GLOBALS[0][$k]);
} }
wp_unregister_GLOBALS();
unset($wp_filter,$cache_lastcommentmodified,$cache_lastpostdate);
if ( !isset($blog_id))
 $blog_id = 1;
if ( (empty($_SERVER[0]['REQUEST_URI']) || Aspis_empty($_SERVER[0]['REQUEST_URI'])) || (php_sapi_name() != 'cgi-fcgi' && preg_match('/^Microsoft-IIS\//',deAspisWarningRC($_SERVER[0]['SERVER_SOFTWARE']))))
 {if ( (isset($_SERVER[0]['HTTP_X_ORIGINAL_URL']) && Aspis_isset($_SERVER[0]['HTTP_X_ORIGINAL_URL'])))
 {$_SERVER[0]['REQUEST_URI'] = attAspisRCO(deAspisWarningRC($_SERVER[0]['HTTP_X_ORIGINAL_URL']));
}else 
{if ( (isset($_SERVER[0]['HTTP_X_REWRITE_URL']) && Aspis_isset($_SERVER[0]['HTTP_X_REWRITE_URL'])))
 {$_SERVER[0]['REQUEST_URI'] = attAspisRCO(deAspisWarningRC($_SERVER[0]['HTTP_X_REWRITE_URL']));
}else 
{{if ( !(isset($_SERVER[0]['PATH_INFO']) && Aspis_isset($_SERVER[0]['PATH_INFO'])) && (isset($_SERVER[0]['ORIG_PATH_INFO']) && Aspis_isset($_SERVER[0]['ORIG_PATH_INFO'])))
 $_SERVER[0]['PATH_INFO'] = attAspisRCO(deAspisWarningRC($_SERVER[0]['ORIG_PATH_INFO']));
if ( (isset($_SERVER[0]['PATH_INFO']) && Aspis_isset($_SERVER[0]['PATH_INFO'])))
 {if ( deAspisWarningRC($_SERVER[0]['PATH_INFO']) == deAspisWarningRC($_SERVER[0]['SCRIPT_NAME']))
 $_SERVER[0]['REQUEST_URI'] = attAspisRCO(deAspisWarningRC($_SERVER[0]['PATH_INFO']));
else 
{$_SERVER[0]['REQUEST_URI'] = attAspisRCO(deAspisWarningRC($_SERVER[0]['SCRIPT_NAME']) . deAspisWarningRC($_SERVER[0]['PATH_INFO']));
}}if ( (isset($_SERVER[0]['QUERY_STRING']) && Aspis_isset($_SERVER[0]['QUERY_STRING'])) && !(empty($_SERVER[0]['QUERY_STRING']) || Aspis_empty($_SERVER[0]['QUERY_STRING'])))
 {$_SERVER[0]['REQUEST_URI'] .= attAspisRCO('?' . deAspisWarningRC($_SERVER[0]['QUERY_STRING']));
}}}}}if ( (isset($_SERVER[0]['SCRIPT_FILENAME']) && Aspis_isset($_SERVER[0]['SCRIPT_FILENAME'])) && (strpos(deAspisWarningRC($_SERVER[0]['SCRIPT_FILENAME']),'php.cgi') == strlen(deAspisWarningRC($_SERVER[0]['SCRIPT_FILENAME'])) - 7))
 $_SERVER[0]['SCRIPT_FILENAME'] = attAspisRCO(deAspisWarningRC($_SERVER[0]['PATH_TRANSLATED']));
if ( strpos(deAspisWarningRC($_SERVER[0]['SCRIPT_NAME']),'php.cgi') !== false)
 unset($_SERVER[0]['PATH_INFO']);
$PHP_SELF = deAspisWarningRC($_SERVER[0]['PHP_SELF']);
if ( empty($PHP_SELF))
 $_SERVER[0]['PHP_SELF'] = attAspisRCO($PHP_SELF = preg_replace("/(\?.*)?$/",'',deAspisWarningRC($_SERVER[0]["REQUEST_URI"])));
if ( version_compare('4.3',phpversion(),'>'))
 {exit(sprintf('Your server is running PHP version %s but WordPress requires at least 4.3.',phpversion()));
}if ( !defined('WP_CONTENT_DIR'))
 define('WP_CONTENT_DIR',ABSPATH . 'wp-content');
if ( file_exists(ABSPATH . '.maintenance') && !defined('WP_INSTALLING'))
 {include (ABSPATH . '.maintenance');
if ( (time() - $upgrading) < 600)
 {if ( file_exists(WP_CONTENT_DIR . '/maintenance.php'))
 {require_once (WP_CONTENT_DIR . '/maintenance.php');
exit();
}$protocol = deAspisWarningRC($_SERVER[0]["SERVER_PROTOCOL"]);
if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol)
 $protocol = 'HTTP/1.0';
header("$protocol 503 Service Unavailable",true,503);
header('Content-Type: text/html; charset=utf-8');
header('Retry-After: 600');
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Maintenance</title>

</head>
<body>
	<h1>Briefly unavailable for scheduled maintenance. Check back in a minute.</h1>
</body>
</html>
<?php exit();
}}if ( !extension_loaded('mysql') && !file_exists(WP_CONTENT_DIR . '/db.php'))
 exit('Your PHP installation appears to be missing the MySQL extension which is required by WordPress.');
function timer_start (  ) {
{global $timestart;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $timestart,"\$timestart",$AspisChangesCache);
}$mtime = explode(' ',microtime());
$mtime = $mtime[1] + $mtime[0];
$timestart = $mtime;
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$timestart",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$timestart",$AspisChangesCache);
 }
function timer_stop ( $display = 0,$precision = 3 ) {
{global $timestart,$timeend;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $timestart,"\$timestart",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($timeend,"\$timeend",$AspisChangesCache);
}$mtime = microtime();
$mtime = explode(' ',$mtime);
$mtime = $mtime[1] + $mtime[0];
$timeend = $mtime;
$timetotal = $timeend - $timestart;
$r = (function_exists('number_format_i18n')) ? number_format_i18n($timetotal,$precision) : number_format($timetotal,$precision);
if ( $display)
 echo $r;
{$AspisRetTemp = $r;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$timestart",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$timeend",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$timestart",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$timeend",$AspisChangesCache);
 }
timer_start();
if ( defined('WP_DEBUG') && WP_DEBUG)
 {if ( defined('E_DEPRECATED'))
 error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
else 
{error_reporting(E_ALL);
}if ( !defined('WP_DEBUG_DISPLAY') || WP_DEBUG_DISPLAY)
 ini_set('display_errors',1);
if ( defined('WP_DEBUG_LOG') && WP_DEBUG_LOG)
 {ini_set('log_errors',1);
ini_set('error_log',WP_CONTENT_DIR . '/debug.log');
}}else 
{{define('WP_DEBUG',false);
if ( defined('E_RECOVERABLE_ERROR'))
 error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);
else 
{error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING);
}}}if ( defined('WP_CACHE') && WP_CACHE)
 @include WP_CONTENT_DIR . '/advanced-cache.php';
if ( !defined('MEDIA_TRASH'))
 define('MEDIA_TRASH',false);
define('WPINC','wp-includes');
if ( !defined('WP_LANG_DIR'))
 {if ( file_exists(WP_CONTENT_DIR . '/languages') && @is_dir(WP_CONTENT_DIR . '/languages'))
 {define('WP_LANG_DIR',WP_CONTENT_DIR . '/languages');
if ( !defined('LANGDIR'))
 {define('LANGDIR','wp-content/languages');
}}else 
{{define('WP_LANG_DIR',ABSPATH . WPINC . '/languages');
if ( !defined('LANGDIR'))
 {define('LANGDIR',WPINC . '/languages');
}}}}require (ABSPATH . WPINC . '/compat.php');
require (ABSPATH . WPINC . '/functions.php');
require (ABSPATH . WPINC . '/classes.php');
require_wp_db();
if ( !empty($wpdb->error))
 dead_db();
$wpdb->field_types = array('post_author' => '%d','post_parent' => '%d','menu_order' => '%d','term_id' => '%d','term_group' => '%d','term_taxonomy_id' => '%d','parent' => '%d','count' => '%d','object_id' => '%d','term_order' => '%d','ID' => '%d','commment_ID' => '%d','comment_post_ID' => '%d','comment_parent' => '%d','user_id' => '%d','link_id' => '%d','link_owner' => '%d','link_rating' => '%d','option_id' => '%d','blog_id' => '%d','meta_id' => '%d','post_id' => '%d','user_status' => '%d','umeta_id' => '%d','comment_karma' => '%d','comment_count' => '%d');
$prefix = $wpdb->set_prefix($table_prefix);
if ( is_wp_error($prefix))
 wp_die('<strong>ERROR</strong>: <code>$table_prefix</code> in <code>wp-config.php</code> can only contain numbers, letters, and underscores.');
function wp_clone ( $object ) {
static $can_clone;
if ( !isset($can_clone))
 {$can_clone = version_compare(phpversion(),'5.0','>=');
}{$AspisRetTemp = $can_clone ? clone ($object) : $object;
return $AspisRetTemp;
} }
function is_admin (  ) {
if ( defined('WP_ADMIN'))
 {$AspisRetTemp = WP_ADMIN;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
if ( file_exists(WP_CONTENT_DIR . '/object-cache.php'))
 {require_once (WP_CONTENT_DIR . '/object-cache.php');
$_wp_using_ext_object_cache = true;
}else 
{{require_once (ABSPATH . WPINC . '/cache.php');
$_wp_using_ext_object_cache = false;
}}wp_cache_init();
if ( function_exists('wp_cache_add_global_groups'))
 {wp_cache_add_global_groups(array('users','userlogins','usermeta','site-transient'));
wp_cache_add_non_persistent_groups(array('comment','counts','plugins'));
}require (ABSPATH . WPINC . '/plugin.php');
require (ABSPATH . WPINC . '/default-filters.php');
include_once (ABSPATH . WPINC . '/pomo/mo.php');
require_once (ABSPATH . WPINC . '/l10n.php');
if ( !is_blog_installed() && (strpos(deAspisWarningRC($_SERVER[0]['PHP_SELF']),'install.php') === false && !defined('WP_INSTALLING')))
 {if ( defined('WP_SITEURL'))
 $link = WP_SITEURL . '/wp-admin/install.php';
elseif ( strpos(deAspisWarningRC($_SERVER[0]['PHP_SELF']),'wp-admin') !== false)
 $link = preg_replace('|/wp-admin/?.*?$|','/',deAspisWarningRC($_SERVER[0]['PHP_SELF'])) . 'wp-admin/install.php';
else 
{$link = preg_replace('|/[^/]+?$|','/',deAspisWarningRC($_SERVER[0]['PHP_SELF'])) . 'wp-admin/install.php';
}require_once (ABSPATH . WPINC . '/kses.php');
require_once (ABSPATH . WPINC . '/pluggable.php');
require_once (ABSPATH . WPINC . '/formatting.php');
wp_redirect($link);
exit();
}require (ABSPATH . WPINC . '/formatting.php');
require (ABSPATH . WPINC . '/capabilities.php');
require (ABSPATH . WPINC . '/query.php');
require (ABSPATH . WPINC . '/theme.php');
require (ABSPATH . WPINC . '/user.php');
require (ABSPATH . WPINC . '/meta.php');
require (ABSPATH . WPINC . '/general-template.php');
require (ABSPATH . WPINC . '/link-template.php');
require (ABSPATH . WPINC . '/author-template.php');
require (ABSPATH . WPINC . '/post.php');
require (ABSPATH . WPINC . '/post-template.php');
require (ABSPATH . WPINC . '/category.php');
require (ABSPATH . WPINC . '/category-template.php');
require (ABSPATH . WPINC . '/comment.php');
require (ABSPATH . WPINC . '/comment-template.php');
require (ABSPATH . WPINC . '/rewrite.php');
require (ABSPATH . WPINC . '/feed.php');
require (ABSPATH . WPINC . '/bookmark.php');
require (ABSPATH . WPINC . '/bookmark-template.php');
require (ABSPATH . WPINC . '/kses.php');
require (ABSPATH . WPINC . '/cron.php');
require (ABSPATH . WPINC . '/version.php');
require (ABSPATH . WPINC . '/deprecated.php');
require (ABSPATH . WPINC . '/script-loader.php');
require (ABSPATH . WPINC . '/taxonomy.php');
require (ABSPATH . WPINC . '/update.php');
require (ABSPATH . WPINC . '/canonical.php');
require (ABSPATH . WPINC . '/shortcodes.php');
require (ABSPATH . WPINC . '/media.php');
require (ABSPATH . WPINC . '/http.php');
require (ABSPATH . WPINC . '/widgets.php');
if ( !defined('WP_CONTENT_URL'))
 define('WP_CONTENT_URL',get_option('siteurl') . '/wp-content');
if ( !defined('WP_PLUGIN_DIR'))
 define('WP_PLUGIN_DIR',WP_CONTENT_DIR . '/plugins');
if ( !defined('WP_PLUGIN_URL'))
 define('WP_PLUGIN_URL',WP_CONTENT_URL . '/plugins');
if ( !defined('PLUGINDIR'))
 define('PLUGINDIR','wp-content/plugins');
if ( !defined('WPMU_PLUGIN_DIR'))
 define('WPMU_PLUGIN_DIR',WP_CONTENT_DIR . '/mu-plugins');
if ( !defined('WPMU_PLUGIN_URL'))
 define('WPMU_PLUGIN_URL',WP_CONTENT_URL . '/mu-plugins');
if ( !defined('MUPLUGINDIR'))
 define('MUPLUGINDIR','wp-content/mu-plugins');
if ( is_dir(WPMU_PLUGIN_DIR))
 {if ( $dh = opendir(WPMU_PLUGIN_DIR))
 {while ( ($plugin = readdir($dh)) !== false )
{if ( substr($plugin,-4) == '.php')
 {include_once (WPMU_PLUGIN_DIR . '/' . $plugin);
}}}}do_action('muplugins_loaded');
define('COOKIEHASH',md5(get_option('siteurl')));
$wp_default_secret_key = 'put your unique phrase here';
if ( !defined('USER_COOKIE'))
 define('USER_COOKIE','wordpressuser_' . COOKIEHASH);
if ( !defined('PASS_COOKIE'))
 define('PASS_COOKIE','wordpresspass_' . COOKIEHASH);
if ( !defined('AUTH_COOKIE'))
 define('AUTH_COOKIE','wordpress_' . COOKIEHASH);
if ( !defined('SECURE_AUTH_COOKIE'))
 define('SECURE_AUTH_COOKIE','wordpress_sec_' . COOKIEHASH);
if ( !defined('LOGGED_IN_COOKIE'))
 define('LOGGED_IN_COOKIE','wordpress_logged_in_' . COOKIEHASH);
if ( !defined('TEST_COOKIE'))
 define('TEST_COOKIE','wordpress_test_cookie');
if ( !defined('COOKIEPATH'))
 define('COOKIEPATH',preg_replace('|https?://[^/]+|i','',get_option('home') . '/'));
if ( !defined('SITECOOKIEPATH'))
 define('SITECOOKIEPATH',preg_replace('|https?://[^/]+|i','',get_option('siteurl') . '/'));
if ( !defined('ADMIN_COOKIE_PATH'))
 define('ADMIN_COOKIE_PATH',SITECOOKIEPATH . 'wp-admin');
if ( !defined('PLUGINS_COOKIE_PATH'))
 define('PLUGINS_COOKIE_PATH',preg_replace('|https?://[^/]+|i','',WP_PLUGIN_URL));
if ( !defined('COOKIE_DOMAIN'))
 define('COOKIE_DOMAIN',false);
if ( !defined('FORCE_SSL_ADMIN'))
 define('FORCE_SSL_ADMIN',false);
force_ssl_admin(FORCE_SSL_ADMIN);
if ( !defined('FORCE_SSL_LOGIN'))
 define('FORCE_SSL_LOGIN',false);
force_ssl_login(FORCE_SSL_LOGIN);
if ( !defined('AUTOSAVE_INTERVAL'))
 define('AUTOSAVE_INTERVAL',60);
if ( !defined('EMPTY_TRASH_DAYS'))
 define('EMPTY_TRASH_DAYS',30);
require (ABSPATH . WPINC . '/vars.php');
create_initial_taxonomies();
if ( get_option('hack_file'))
 {if ( file_exists(ABSPATH . 'my-hacks.php'))
 require (ABSPATH . 'my-hacks.php');
}$current_plugins = apply_filters('active_plugins',get_option('active_plugins'));
if ( is_array($current_plugins) && !defined('WP_INSTALLING'))
 {foreach ( $current_plugins as $plugin  )
{if ( validate_file($plugin) || '.php' != substr($plugin,-4) || !file_exists(WP_PLUGIN_DIR . '/' . $plugin))
 continue ;
include_once (WP_PLUGIN_DIR . '/' . $plugin);
}unset($plugin);
}unset($current_plugins);
require (ABSPATH . WPINC . '/pluggable.php');
if ( function_exists('mb_internal_encoding'))
 {if ( !@mb_internal_encoding(get_option('blog_charset')))
 mb_internal_encoding('UTF-8');
}if ( defined('WP_CACHE') && function_exists('wp_cache_postload'))
 wp_cache_postload();
do_action('plugins_loaded');
$default_constants = array('WP_POST_REVISIONS' => true);
foreach ( $default_constants as $c =>$v )
@define($c,$v);
unset($default_constants,$c,$v);
if ( get_magic_quotes_gpc())
 {$_GET = attAspisRCO(stripslashes_deep(deAspisWarningRC($_GET)));
$_POST = attAspisRCO(stripslashes_deep(deAspisWarningRC($_POST)));
$_COOKIE = attAspisRCO(stripslashes_deep(deAspisWarningRC($_COOKIE)));
}function  edited_setup (   ) {
$_GET = add_magic_quotes( $_GET);
$_POST = add_magic_quotes( $_POST);
$_COOKIE = add_magic_quotes( $_COOKIE);
$_SERVER = add_magic_quotes( $_SERVER);
$_REQUEST = Aspis_array_merge( $_GET,$_POST);
 }
edited_setup();
do_action('sanitize_comment_cookies');
$wp_the_query = &new WP_Query();
$wp_query = &$wp_the_query;
$wp_rewrite = &new WP_Rewrite();
$wp = &new WP();
$wp_widget_factory = &new WP_Widget_Factory();
do_action('setup_theme');
define('TEMPLATEPATH',get_template_directory());
define('STYLESHEETPATH',get_stylesheet_directory());
load_default_textdomain();
$locale = get_locale();
$locale_file = WP_LANG_DIR . "/$locale.php";
if ( is_readable($locale_file))
 require_once ($locale_file);
require_once (ABSPATH . WPINC . '/locale.php');
$wp_locale = &new WP_Locale();
if ( TEMPLATEPATH !== STYLESHEETPATH && file_exists(STYLESHEETPATH . '/functions.php'))
 include (STYLESHEETPATH . '/functions.php');
if ( file_exists(TEMPLATEPATH . '/functions.php'))
 include (TEMPLATEPATH . '/functions.php');
require_if_theme_supports('post-thumbnails',ABSPATH . WPINC . '/post-thumbnail-template.php');
function shutdown_action_hook (  ) {
do_action('shutdown');
wp_cache_close();
 }
register_shutdown_function('shutdown_action_hook');
$wp->init();
do_action('init');
;
?>
<?php 