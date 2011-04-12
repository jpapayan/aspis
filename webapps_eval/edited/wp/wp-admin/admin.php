<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('WP_ADMIN')))))
 define(('WP_ADMIN'),TRUE);
if ( defined(('ABSPATH')))
 require_once (deconcat12(ABSPATH,'wp-load.php'));
else 
{require_once ('../wp-load.php');
}if ( deAspis(get_option(array('db_upgraded',false))))
 {$wp_rewrite[0]->flush_rules();
update_option(array('db_upgraded',false),array(false,false));
do_action(array('after_db_upgrade',false));
}elseif ( (deAspis(get_option(array('db_version',false))) != $wp_db_version[0]))
 {wp_redirect(admin_url(concat1('upgrade.php?_wp_http_referer=',Aspis_urlencode(Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])))));
Aspis_exit();
}require_once (deconcat12(ABSPATH,'wp-admin/includes/admin.php'));
auth_redirect();
nocache_headers();
update_category_cache();
if ( ((denot_boolean(wp_next_scheduled(array('wp_scheduled_delete',false)))) && (!(defined(('WP_INSTALLING'))))))
 wp_schedule_event(attAspis(time()),array('daily',false),array('wp_scheduled_delete',false));
set_screen_options();
$posts_per_page = get_option(array('posts_per_page',false));
$date_format = get_option(array('date_format',false));
$time_format = get_option(array('time_format',false));
wp_reset_vars(array(array(array('profile',false),array('redirect',false),array('redirect_url',false),array('a',false),array('text',false),array('trackback',false),array('pingback',false)),false));
wp_admin_css_color(array('classic',false),__(array('Blue',false)),admin_url(array("css/colors-classic.css",false)),array(array(array('#073447',false),array('#21759B',false),array('#EAF3FA',false),array('#BBD8E7',false)),false));
wp_admin_css_color(array('fresh',false),__(array('Gray',false)),admin_url(array("css/colors-fresh.css",false)),array(array(array('#464646',false),array('#6D6D6D',false),array('#F1F1F1',false),array('#DFDFDF',false)),false));
wp_enqueue_script(array('common',false));
wp_enqueue_script(array('jquery-color',false));
$editing = array(false,false);
if ( ((isset($_GET[0][('page')]) && Aspis_isset( $_GET [0][('page')]))))
 {$plugin_page = Aspis_stripslashes($_GET[0]['page']);
$plugin_page = plugin_basename($plugin_page);
}require (deconcat12(ABSPATH,'wp-admin/menu.php'));
do_action(array('admin_init',false));
if ( ((isset($plugin_page) && Aspis_isset( $plugin_page))))
 {if ( (denot_boolean($page_hook = get_plugin_page_hook($plugin_page,$pagenow))))
 {$page_hook = get_plugin_page_hook($plugin_page,$plugin_page);
if ( ((((empty($page_hook) || Aspis_empty( $page_hook))) && (('edit.php') == $pagenow[0])) && (('') != deAspis(get_plugin_page_hook($plugin_page,array('tools.php',false))))))
 {if ( (!((empty($_SERVER[0][('QUERY_STRING')]) || Aspis_empty( $_SERVER [0][('QUERY_STRING')])))))
 $query_string = $_SERVER[0]['QUERY_STRING'];
else 
{$query_string = concat1('page=',$plugin_page);
}wp_redirect(concat1('tools.php?',$query_string));
Aspis_exit();
}}if ( $page_hook[0])
 {do_action(concat1('load-',$page_hook));
if ( (!((isset($_GET[0][('noheader')]) && Aspis_isset( $_GET [0][('noheader')])))))
 require_once (deconcat12(ABSPATH,'wp-admin/admin-header.php'));
do_action($page_hook);
}else 
{{if ( deAspis(validate_file($plugin_page)))
 {wp_die(__(array('Invalid plugin page',false)));
}if ( (!(file_exists((deconcat1(WP_PLUGIN_DIR,concat1("/",$plugin_page)))) && is_file((deconcat1(WP_PLUGIN_DIR,concat1("/",$plugin_page)))))))
 wp_die(Aspis_sprintf(__(array('Cannot load %s.',false)),Aspis_htmlentities($plugin_page)));
do_action(concat1('load-',$plugin_page));
if ( (!((isset($_GET[0][('noheader')]) && Aspis_isset( $_GET [0][('noheader')])))))
 require_once (deconcat12(ABSPATH,'wp-admin/admin-header.php'));
include (deconcat1(WP_PLUGIN_DIR,concat1("/",$plugin_page)));
}}include (deconcat12(ABSPATH,'wp-admin/admin-footer.php'));
Aspis_exit();
}else 
{if ( ((isset($_GET[0][('import')]) && Aspis_isset( $_GET [0][('import')]))))
 {$importer = $_GET[0]['import'];
if ( (denot_boolean(current_user_can(array('import',false)))))
 wp_die(__(array('You are not allowed to import.',false)));
if ( deAspis(validate_file($importer)))
 {wp_die(__(array('Invalid importer.',false)));
}if ( (((!((isset($wp_importers) && Aspis_isset( $wp_importers)))) || (!((isset($wp_importers[0][$importer[0]]) && Aspis_isset( $wp_importers [0][$importer[0]]))))) || (!(is_callable(deAspisRC(attachAspis($wp_importers[0][$importer[0]],(2))))))))
 {if ( (!(file_exists((deconcat1(ABSPATH,concat2(concat1("wp-admin/import/",$importer),".php")))))))
 {wp_die(__(array('Cannot load importer.',false)));
}include (deconcat1(ABSPATH,concat2(concat1("wp-admin/import/",$importer),".php")));
}$parent_file = array('tools.php',false);
$submenu_file = array('import.php',false);
$title = __(array('Import',false));
if ( (!((isset($_GET[0][('noheader')]) && Aspis_isset( $_GET [0][('noheader')])))))
 require_once (deconcat12(ABSPATH,'wp-admin/admin-header.php'));
require_once (deconcat12(ABSPATH,'wp-admin/includes/upgrade.php'));
define(('WP_IMPORTING'),true);
Aspis_call_user_func(attachAspis($wp_importers[0][$importer[0]],(2)));
include (deconcat12(ABSPATH,'wp-admin/admin-footer.php'));
global $wp_rewrite;
$wp_rewrite[0]->flush_rules(array(false,false));
Aspis_exit();
}else 
{{do_action(concat1("load-",$pagenow));
}}}if ( (!((empty($_REQUEST[0][('action')]) || Aspis_empty( $_REQUEST [0][('action')])))))
 do_action(concat1('admin_action_',$_REQUEST[0]['action']));
;
?>
<?php 