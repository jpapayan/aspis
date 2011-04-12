<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('WP_MEMORY_LIMIT')))))
 define(('WP_MEMORY_LIMIT'),'32M');
if ( (function_exists(('memory_get_usage')) && (deAspis(int_cast(@array(ini_get('memory_limit'),false))) < deAspis(Aspis_abs(Aspis_intval(array(WP_MEMORY_LIMIT,false)))))))
 @array(ini_set('memory_limit',WP_MEMORY_LIMIT),false);
set_magic_quotes_runtime(0);
@array(ini_set('magic_quotes_sybase',0),false);
if ( function_exists(('date_default_timezone_set')))
 date_default_timezone_set(('UTC'));
function wp_unregister_GLOBALS (  ) {
if ( (!(ini_get('register_globals'))))
 return ;
if ( ((isset($_REQUEST[0][('GLOBALS')]) && Aspis_isset( $_REQUEST [0][('GLOBALS')]))))
 Aspis_exit(array('GLOBALS overwrite attempt detected',false));
$noUnset = array(array(array('GLOBALS',false),array('_GET',false),array('_POST',false),array('_COOKIE',false),array('_REQUEST',false),array('_SERVER',false),array('_ENV',false),array('_FILES',false),array('table_prefix',false)),false);
$input = Aspis_array_merge($_GET,$_POST,$_COOKIE,$_SERVER,$_ENV,$_FILES,(((isset($_SESSION) && Aspis_isset( $_SESSION))) && is_array($_SESSION[0])) ? $_SESSION : array(array(),false));
foreach ( $input[0] as $k =>$v )
{restoreTaint($k,$v);
if ( ((denot_boolean(Aspis_in_array($k,$noUnset))) && ((isset($GLOBALS[0][$k[0]]) && Aspis_isset( $GLOBALS [0][$k[0]])))))
 {arrayAssign($GLOBALS[0],deAspis(registerTaint($k)),addTaint(array(NULL,false)));
unset($GLOBALS[0][$k[0]]);
}} }
wp_unregister_GLOBALS();
unset($wp_filter,$cache_lastcommentmodified,$cache_lastpostdate);
if ( (!((isset($blog_id) && Aspis_isset( $blog_id)))))
 $blog_id = array(1,false);
if ( (((empty($_SERVER[0][('REQUEST_URI')]) || Aspis_empty( $_SERVER [0][('REQUEST_URI')]))) || (((php_sapi_name()) != ('cgi-fcgi')) && deAspis(Aspis_preg_match(array('/^Microsoft-IIS\//',false),$_SERVER[0]['SERVER_SOFTWARE'])))))
 {if ( ((isset($_SERVER[0][('HTTP_X_ORIGINAL_URL')]) && Aspis_isset( $_SERVER [0][('HTTP_X_ORIGINAL_URL')]))))
 {arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint($_SERVER[0]['HTTP_X_ORIGINAL_URL']));
}else 
{if ( ((isset($_SERVER[0][('HTTP_X_REWRITE_URL')]) && Aspis_isset( $_SERVER [0][('HTTP_X_REWRITE_URL')]))))
 {arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint($_SERVER[0]['HTTP_X_REWRITE_URL']));
}else 
{{if ( ((!((isset($_SERVER[0][('PATH_INFO')]) && Aspis_isset( $_SERVER [0][('PATH_INFO')])))) && ((isset($_SERVER[0][('ORIG_PATH_INFO')]) && Aspis_isset( $_SERVER [0][('ORIG_PATH_INFO')])))))
 arrayAssign($_SERVER[0],deAspis(registerTaint(array('PATH_INFO',false))),addTaint($_SERVER[0]['ORIG_PATH_INFO']));
if ( ((isset($_SERVER[0][('PATH_INFO')]) && Aspis_isset( $_SERVER [0][('PATH_INFO')]))))
 {if ( (deAspis($_SERVER[0]['PATH_INFO']) == deAspis($_SERVER[0]['SCRIPT_NAME'])))
 arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint($_SERVER[0]['PATH_INFO']));
else 
{arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(concat($_SERVER[0]['SCRIPT_NAME'],$_SERVER[0]['PATH_INFO'])));
}}if ( (((isset($_SERVER[0][('QUERY_STRING')]) && Aspis_isset( $_SERVER [0][('QUERY_STRING')]))) && (!((empty($_SERVER[0][('QUERY_STRING')]) || Aspis_empty( $_SERVER [0][('QUERY_STRING')]))))))
 {arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(concat($_SERVER[0]['REQUEST_URI'],concat1('?',$_SERVER[0]['QUERY_STRING']))));
}}}}}if ( (((isset($_SERVER[0][('SCRIPT_FILENAME')]) && Aspis_isset( $_SERVER [0][('SCRIPT_FILENAME')]))) && (strpos(deAspis($_SERVER[0]['SCRIPT_FILENAME']),'php.cgi') == (strlen(deAspis($_SERVER[0]['SCRIPT_FILENAME'])) - (7)))))
 arrayAssign($_SERVER[0],deAspis(registerTaint(array('SCRIPT_FILENAME',false))),addTaint($_SERVER[0]['PATH_TRANSLATED']));
if ( (strpos(deAspis($_SERVER[0]['SCRIPT_NAME']),'php.cgi') !== false))
 unset($_SERVER[0][('PATH_INFO')]);
$PHP_SELF = $_SERVER[0]['PHP_SELF'];
if ( ((empty($PHP_SELF) || Aspis_empty( $PHP_SELF))))
 arrayAssign($_SERVER[0],deAspis(registerTaint(array('PHP_SELF',false))),addTaint($PHP_SELF = Aspis_preg_replace(array("/(\?.*)?$/",false),array('',false),$_SERVER[0]["REQUEST_URI"])));
if ( (version_compare('4.3',deAspisRC(array(phpversion(),false)),'>')))
 {Aspis_exit(Aspis_sprintf(array('Your server is running PHP version %s but WordPress requires at least 4.3.',false),array(phpversion(),false)));
}if ( (!(defined(('WP_CONTENT_DIR')))))
 define(('WP_CONTENT_DIR'),(deconcat12(ABSPATH,'wp-content')));
if ( (file_exists((deconcat12(ABSPATH,'.maintenance'))) && (!(defined(('WP_INSTALLING'))))))
 {include (deconcat12(ABSPATH,'.maintenance'));
if ( ((time() - $upgrading[0]) < (600)))
 {if ( file_exists((deconcat12(WP_CONTENT_DIR,'/maintenance.php'))))
 {require_once (deconcat12(WP_CONTENT_DIR,'/maintenance.php'));
Aspis_exit();
}$protocol = $_SERVER[0]["SERVER_PROTOCOL"];
if ( ((('HTTP/1.1') != $protocol[0]) && (('HTTP/1.0') != $protocol[0])))
 $protocol = array('HTTP/1.0',false);
header((deconcat2($protocol," 503 Service Unavailable")),true,(503));
header(('Content-Type: text/html; charset=utf-8'));
header(('Retry-After: 600'));
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
<?php Aspis_exit();
}}if ( ((!(extension_loaded('mysql'))) && (!(file_exists((deconcat12(WP_CONTENT_DIR,'/db.php')))))))
 Aspis_exit(array('Your PHP installation appears to be missing the MySQL extension which is required by WordPress.',false));
function timer_start (  ) {
global $timestart;
$mtime = Aspis_explode(array(' ',false),attAspisRC(microtime()));
$mtime = array(deAspis(attachAspis($mtime,(1))) + deAspis(attachAspis($mtime,(0))),false);
$timestart = $mtime;
return array(true,false);
 }
function timer_stop ( $display = array(0,false),$precision = array(3,false) ) {
global $timestart,$timeend;
$mtime = attAspisRC(microtime());
$mtime = Aspis_explode(array(' ',false),$mtime);
$mtime = array(deAspis(attachAspis($mtime,(1))) + deAspis(attachAspis($mtime,(0))),false);
$timeend = $mtime;
$timetotal = array($timeend[0] - $timestart[0],false);
$r = function_exists(('number_format_i18n')) ? number_format_i18n($timetotal,$precision) : attAspis(number_format($timetotal[0],$precision[0]));
if ( $display[0])
 echo AspisCheckPrint($r);
return $r;
 }
timer_start();
if ( (defined(('WP_DEBUG')) && WP_DEBUG))
 {if ( defined(('E_DEPRECATED')))
 error_reporting(deAspisRC(array((E_ALL & deAspis(not_bitwise(array(E_DEPRECATED,false)))) & deAspis(not_bitwise(array(E_STRICT,false))),false)));
else 
{error_reporting(E_ALL);
}if ( ((!(defined(('WP_DEBUG_DISPLAY')))) || WP_DEBUG_DISPLAY))
 ini_set('display_errors',1);
if ( (defined(('WP_DEBUG_LOG')) && WP_DEBUG_LOG))
 {ini_set('log_errors',1);
ini_set('error_log',(deconcat12(WP_CONTENT_DIR,'/debug.log')));
}}else 
{{define(('WP_DEBUG'),false);
if ( defined(('E_RECOVERABLE_ERROR')))
 error_reporting(deAspisRC(array(((((E_ERROR | E_WARNING) | E_PARSE) | E_USER_ERROR) | E_USER_WARNING) | E_RECOVERABLE_ERROR,false)));
else 
{error_reporting(deAspisRC(array((((E_ERROR | E_WARNING) | E_PARSE) | E_USER_ERROR) | E_USER_WARNING,false)));
}}}if ( (defined(('WP_CACHE')) && WP_CACHE))
 @include (deconcat12(WP_CONTENT_DIR,'/advanced-cache.php'));
if ( (!(defined(('MEDIA_TRASH')))))
 define(('MEDIA_TRASH'),false);
define(('WPINC'),'wp-includes');
if ( (!(defined(('WP_LANG_DIR')))))
 {if ( (file_exists((deconcat12(WP_CONTENT_DIR,'/languages'))) && deAspis(@attAspis(is_dir((deconcat12(WP_CONTENT_DIR,'/languages')))))))
 {define(('WP_LANG_DIR'),(deconcat12(WP_CONTENT_DIR,'/languages')));
if ( (!(defined(('LANGDIR')))))
 {define(('LANGDIR'),'wp-content/languages');
}}else 
{{define(('WP_LANG_DIR'),(deconcat2(concat12(ABSPATH,WPINC),'/languages')));
if ( (!(defined(('LANGDIR')))))
 {define(('LANGDIR'),(deconcat12(WPINC,'/languages')));
}}}}require (deconcat2(concat12(ABSPATH,WPINC),'/compat.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/functions.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/classes.php'));
require_wp_db();
if ( (!((empty($wpdb[0]->error) || Aspis_empty( $wpdb[0] ->error )))))
 dead_db();
$wpdb[0]->field_types = array(array('post_author' => array('%d',false,false),'post_parent' => array('%d',false,false),'menu_order' => array('%d',false,false),'term_id' => array('%d',false,false),'term_group' => array('%d',false,false),'term_taxonomy_id' => array('%d',false,false),'parent' => array('%d',false,false),'count' => array('%d',false,false),'object_id' => array('%d',false,false),'term_order' => array('%d',false,false),'ID' => array('%d',false,false),'commment_ID' => array('%d',false,false),'comment_post_ID' => array('%d',false,false),'comment_parent' => array('%d',false,false),'user_id' => array('%d',false,false),'link_id' => array('%d',false,false),'link_owner' => array('%d',false,false),'link_rating' => array('%d',false,false),'option_id' => array('%d',false,false),'blog_id' => array('%d',false,false),'meta_id' => array('%d',false,false),'post_id' => array('%d',false,false),'user_status' => array('%d',false,false),'umeta_id' => array('%d',false,false),'comment_karma' => array('%d',false,false),'comment_count' => array('%d',false,false)),false);
$prefix = $wpdb[0]->set_prefix($table_prefix);
if ( deAspis(is_wp_error($prefix)))
 wp_die(array('<strong>ERROR</strong>: <code>$table_prefix</code> in <code>wp-config.php</code> can only contain numbers, letters, and underscores.',false));
function wp_clone ( $object ) {
static $can_clone;
if ( (!((isset($can_clone) && Aspis_isset( $can_clone)))))
 {$can_clone = array(version_compare(deAspisRC(array(phpversion(),false)),'5.0','>='),false);
}return $can_clone[0] ? array(clone ($object[0]),false) : $object;
 }
function is_admin (  ) {
if ( defined(('WP_ADMIN')))
 return array(WP_ADMIN,false);
return array(false,false);
 }
if ( file_exists((deconcat12(WP_CONTENT_DIR,'/object-cache.php'))))
 {require_once (deconcat12(WP_CONTENT_DIR,'/object-cache.php'));
$_wp_using_ext_object_cache = array(true,false);
}else 
{{require_once (deconcat2(concat12(ABSPATH,WPINC),'/cache.php'));
$_wp_using_ext_object_cache = array(false,false);
}}wp_cache_init();
if ( function_exists(('wp_cache_add_global_groups')))
 {wp_cache_add_global_groups(array(array(array('users',false),array('userlogins',false),array('usermeta',false),array('site-transient',false)),false));
wp_cache_add_non_persistent_groups(array(array(array('comment',false),array('counts',false),array('plugins',false)),false));
}require (deconcat2(concat12(ABSPATH,WPINC),'/plugin.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/default-filters.php'));
include_once (deconcat2(concat12(ABSPATH,WPINC),'/pomo/mo.php'));
require_once (deconcat2(concat12(ABSPATH,WPINC),'/l10n.php'));
if ( ((denot_boolean(is_blog_installed())) && ((strpos(deAspis($_SERVER[0]['PHP_SELF']),'install.php') === false) && (!(defined(('WP_INSTALLING')))))))
 {if ( defined(('WP_SITEURL')))
 $link = concat12(WP_SITEURL,'/wp-admin/install.php');
elseif ( (strpos(deAspis($_SERVER[0]['PHP_SELF']),'wp-admin') !== false))
 $link = concat2(Aspis_preg_replace(array('|/wp-admin/?.*?$|',false),array('/',false),$_SERVER[0]['PHP_SELF']),'wp-admin/install.php');
else 
{$link = concat2(Aspis_preg_replace(array('|/[^/]+?$|',false),array('/',false),$_SERVER[0]['PHP_SELF']),'wp-admin/install.php');
}require_once (deconcat2(concat12(ABSPATH,WPINC),'/kses.php'));
require_once (deconcat2(concat12(ABSPATH,WPINC),'/pluggable.php'));
require_once (deconcat2(concat12(ABSPATH,WPINC),'/formatting.php'));
wp_redirect($link);
Aspis_exit();
}require (deconcat2(concat12(ABSPATH,WPINC),'/formatting.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/capabilities.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/query.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/theme.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/user.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/meta.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/general-template.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/link-template.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/author-template.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/post.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/post-template.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/category.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/category-template.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/comment.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/comment-template.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/rewrite.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/feed.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/bookmark.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/bookmark-template.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/kses.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/cron.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/version.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/deprecated.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/script-loader.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/taxonomy.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/update.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/canonical.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/shortcodes.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/media.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/http.php'));
require (deconcat2(concat12(ABSPATH,WPINC),'/widgets.php'));
if ( (!(defined(('WP_CONTENT_URL')))))
 define(('WP_CONTENT_URL'),(deconcat2(get_option(array('siteurl',false)),'/wp-content')));
if ( (!(defined(('WP_PLUGIN_DIR')))))
 define(('WP_PLUGIN_DIR'),(deconcat12(WP_CONTENT_DIR,'/plugins')));
if ( (!(defined(('WP_PLUGIN_URL')))))
 define(('WP_PLUGIN_URL'),(deconcat12(WP_CONTENT_URL,'/plugins')));
if ( (!(defined(('PLUGINDIR')))))
 define(('PLUGINDIR'),'wp-content/plugins');
if ( (!(defined(('WPMU_PLUGIN_DIR')))))
 define(('WPMU_PLUGIN_DIR'),(deconcat12(WP_CONTENT_DIR,'/mu-plugins')));
if ( (!(defined(('WPMU_PLUGIN_URL')))))
 define(('WPMU_PLUGIN_URL'),(deconcat12(WP_CONTENT_URL,'/mu-plugins')));
if ( (!(defined(('MUPLUGINDIR')))))
 define(('MUPLUGINDIR'),'wp-content/mu-plugins');
if ( is_dir(WPMU_PLUGIN_DIR))
 {if ( deAspis($dh = attAspis(opendir(WPMU_PLUGIN_DIR))))
 {while ( (deAspis(($plugin = attAspis(readdir($dh[0])))) !== false) )
{if ( (deAspis(Aspis_substr($plugin,negate(array(4,false)))) == ('.php')))
 {include_once (deconcat(concat12(WPMU_PLUGIN_DIR,'/'),$plugin));
}}}}do_action(array('muplugins_loaded',false));
define(('COOKIEHASH'),deAspisRC(attAspis(md5(deAspis(get_option(array('siteurl',false)))))));
$wp_default_secret_key = array('put your unique phrase here',false);
if ( (!(defined(('USER_COOKIE')))))
 define(('USER_COOKIE'),(deconcat12('wordpressuser_',COOKIEHASH)));
if ( (!(defined(('PASS_COOKIE')))))
 define(('PASS_COOKIE'),(deconcat12('wordpresspass_',COOKIEHASH)));
if ( (!(defined(('AUTH_COOKIE')))))
 define(('AUTH_COOKIE'),(deconcat12('wordpress_',COOKIEHASH)));
if ( (!(defined(('SECURE_AUTH_COOKIE')))))
 define(('SECURE_AUTH_COOKIE'),(deconcat12('wordpress_sec_',COOKIEHASH)));
if ( (!(defined(('LOGGED_IN_COOKIE')))))
 define(('LOGGED_IN_COOKIE'),(deconcat12('wordpress_logged_in_',COOKIEHASH)));
if ( (!(defined(('TEST_COOKIE')))))
 define(('TEST_COOKIE'),'wordpress_test_cookie');
if ( (!(defined(('COOKIEPATH')))))
 define(('COOKIEPATH'),deAspisRC(Aspis_preg_replace(array('|https?://[^/]+|i',false),array('',false),concat2(get_option(array('home',false)),'/'))));
if ( (!(defined(('SITECOOKIEPATH')))))
 define(('SITECOOKIEPATH'),deAspisRC(Aspis_preg_replace(array('|https?://[^/]+|i',false),array('',false),concat2(get_option(array('siteurl',false)),'/'))));
if ( (!(defined(('ADMIN_COOKIE_PATH')))))
 define(('ADMIN_COOKIE_PATH'),(deconcat12(SITECOOKIEPATH,'wp-admin')));
if ( (!(defined(('PLUGINS_COOKIE_PATH')))))
 define(('PLUGINS_COOKIE_PATH'),deAspisRC(Aspis_preg_replace(array('|https?://[^/]+|i',false),array('',false),array(WP_PLUGIN_URL,false))));
if ( (!(defined(('COOKIE_DOMAIN')))))
 define(('COOKIE_DOMAIN'),false);
if ( (!(defined(('FORCE_SSL_ADMIN')))))
 define(('FORCE_SSL_ADMIN'),false);
force_ssl_admin(array(FORCE_SSL_ADMIN,false));
if ( (!(defined(('FORCE_SSL_LOGIN')))))
 define(('FORCE_SSL_LOGIN'),false);
force_ssl_login(array(FORCE_SSL_LOGIN,false));
if ( (!(defined(('AUTOSAVE_INTERVAL')))))
 define(('AUTOSAVE_INTERVAL'),60);
if ( (!(defined(('EMPTY_TRASH_DAYS')))))
 define(('EMPTY_TRASH_DAYS'),30);
require (deconcat2(concat12(ABSPATH,WPINC),'/vars.php'));
create_initial_taxonomies();
if ( deAspis(get_option(array('hack_file',false))))
 {if ( file_exists((deconcat12(ABSPATH,'my-hacks.php'))))
 require (deconcat12(ABSPATH,'my-hacks.php'));
}$current_plugins = apply_filters(array('active_plugins',false),get_option(array('active_plugins',false)));
if ( (is_array($current_plugins[0]) && (!(defined(('WP_INSTALLING'))))))
 {foreach ( $current_plugins[0] as $plugin  )
{if ( ((deAspis(validate_file($plugin)) || (('.php') != deAspis(Aspis_substr($plugin,negate(array(4,false)))))) || (!(file_exists((deconcat(concat12(WP_PLUGIN_DIR,'/'),$plugin)))))))
 continue ;
include_once (deconcat(concat12(WP_PLUGIN_DIR,'/'),$plugin));
}unset($plugin);
}unset($current_plugins);
require (deconcat2(concat12(ABSPATH,WPINC),'/pluggable.php'));
if ( function_exists(('mb_internal_encoding')))
 {if ( (denot_boolean(@array(mb_internal_encoding(deAspisRC(get_option(array('blog_charset',false)))),false))))
 mb_internal_encoding('UTF-8');
}if ( (defined(('WP_CACHE')) && function_exists(('wp_cache_postload'))))
 wp_cache_postload();
do_action(array('plugins_loaded',false));
$default_constants = array(array('WP_POST_REVISIONS' => array(true,false,false)),false);
foreach ( $default_constants[0] as $c =>$v )
{restoreTaint($c,$v);
@attAspis(define($c[0],deAspisRC($v)));
}unset($default_constants,$c,$v);
if ( (get_magic_quotes_gpc()))
 {$_GET = stripslashes_deep($_GET);
$_POST = stripslashes_deep($_POST);
$_COOKIE = stripslashes_deep($_COOKIE);
}function edited_setup (  ) {
$_GET = add_magic_quotes($_GET);
$_POST = add_magic_quotes($_POST);
$_COOKIE = add_magic_quotes($_COOKIE);
$_SERVER = add_magic_quotes($_SERVER);
$_REQUEST = Aspis_array_merge($_GET,$_POST);
 }
edited_setup();
do_action(array('sanitize_comment_cookies',false));
$wp_the_query = array(new WP_Query(),false);
$wp_query = &$wp_the_query;
$wp_rewrite = array(new WP_Rewrite(),false);
$wp = array(new WP(),false);
$wp_widget_factory = array(new WP_Widget_Factory(),false);
do_action(array('setup_theme',false));
define(('TEMPLATEPATH'),deAspisRC(get_template_directory()));
define(('STYLESHEETPATH'),deAspisRC(get_stylesheet_directory()));
load_default_textdomain();
$locale = get_locale();
$locale_file = concat1(WP_LANG_DIR,concat2(concat1("/",$locale),".php"));
if ( is_readable($locale_file[0]))
 require_once deAspis(($locale_file));
require_once (deconcat2(concat12(ABSPATH,WPINC),'/locale.php'));
$wp_locale = array(new WP_Locale(),false);
if ( ((TEMPLATEPATH !== STYLESHEETPATH) && file_exists((deconcat12(STYLESHEETPATH,'/functions.php')))))
 include (deconcat12(STYLESHEETPATH,'/functions.php'));
if ( file_exists((deconcat12(TEMPLATEPATH,'/functions.php'))))
 include (deconcat12(TEMPLATEPATH,'/functions.php'));
require_if_theme_supports(array('post-thumbnails',false),concat2(concat12(ABSPATH,WPINC),'/post-thumbnail-template.php'));
function shutdown_action_hook (  ) {
do_action(array('shutdown',false));
wp_cache_close();
 }
register_shutdown_function(AspisInternalCallback(array('shutdown_action_hook',false)));
$wp[0]->init();
do_action(array('init',false));
;
?>
<?php 