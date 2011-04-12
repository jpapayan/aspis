<?php require_once('AspisMain.php'); ?><?php
@header((deconcat(concat2(concat1('Content-Type: ',get_option(array('html_type',false))),'; charset='),get_option(array('blog_charset',false)))));
if ( (!((isset($_GET[0][("page")]) && Aspis_isset( $_GET [0][("page")])))))
 require_once ('admin.php');
get_admin_page_title();
$title = esc_html(Aspis_strip_tags($title));
wp_user_settings();
wp_menu_unfold();
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php do_action(array('admin_xml_ns',false));
;
?> <?php language_attributes();
;
?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo(array('html_type',false));
;
?>; charset=<?php echo AspisCheckPrint(get_option(array('blog_charset',false)));
;
?>" />
<title><?php echo AspisCheckPrint($title);
;
?> &lsaquo; <?php bloginfo(array('name',false));
?>  &#8212; WordPress</title>
<?php wp_admin_css(array('css/global',false));
wp_admin_css();
wp_admin_css(array('css/colors',false));
wp_admin_css(array('css/ie',false));
wp_enqueue_script(array('utils',false));
$hook_suffix = array('',false);
if ( ((isset($page_hook) && Aspis_isset( $page_hook))))
 $hook_suffix = $page_hook;
else 
{if ( ((isset($plugin_page) && Aspis_isset( $plugin_page))))
 $hook_suffix = $plugin_page;
else 
{if ( ((isset($pagenow) && Aspis_isset( $pagenow))))
 $hook_suffix = $pagenow;
}}$admin_body_class = Aspis_preg_replace(array('/[^a-z0-9_-]+/i',false),array('-',false),$hook_suffix);
;
?>
<script type="text/javascript">
//<![CDATA[
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
var userSettings = {'url':'<?php echo AspisCheckPrint(array(SITECOOKIEPATH,false));
;
?>','uid':'<?php if ( (!((isset($current_user) && Aspis_isset( $current_user)))))
 $current_user = wp_get_current_user();
echo AspisCheckPrint($current_user[0]->ID);
;
?>','time':'<?php echo AspisCheckPrint(attAspis(time()));
?>'};
var ajaxurl = '<?php echo AspisCheckPrint(admin_url(array('admin-ajax.php',false)));
;
?>', pagenow = '<?php echo AspisCheckPrint(Aspis_substr($pagenow,array(0,false),negate(array(4,false))));
;
?>', adminpage = '<?php echo AspisCheckPrint($admin_body_class);
;
?>',  thousandsSeparator = '<?php echo AspisCheckPrint($wp_locale[0]->number_format[0][('thousands_sep')]);
;
?>', decimalPoint = '<?php echo AspisCheckPrint($wp_locale[0]->number_format[0][('decimal_point')]);
;
?>';
//]]>
</script>
<?php if ( deAspis(Aspis_in_array($pagenow,array(array(array('post.php',false),array('post-new.php',false),array('page.php',false),array('page-new.php',false)),false))))
 {add_action(array('admin_print_footer_scripts',false),array('wp_tiny_mce',false),array(25,false));
wp_enqueue_script(array('quicktags',false));
}do_action(array('admin_enqueue_scripts',false),$hook_suffix);
do_action(concat1("admin_print_styles-",$hook_suffix));
do_action(array('admin_print_styles',false));
do_action(concat1("admin_print_scripts-",$hook_suffix));
do_action(array('admin_print_scripts',false));
do_action(concat1("admin_head-",$hook_suffix));
do_action(array('admin_head',false));
if ( (deAspis(get_user_setting(array('mfold',false))) == ('f')))
 {$admin_body_class = concat2($admin_body_class,' folded');
}if ( $is_iphone[0])
 {;
?>
<style type="text/css">.row-actions{visibility:visible;}</style>
<?php };
?>
</head>
<body class="wp-admin no-js <?php echo AspisCheckPrint(concat(apply_filters(array('admin_body_class',false),array('',false)),concat1(" ",$admin_body_class)));
;
?>">
<script type="text/javascript">
//<![CDATA[
(function(){
var c = document.body.className;
c = c.replace(/no-js/, 'js');
document.body.className = c;
})();
//]]>
</script>

<div id="wpwrap">
<div id="wpcontent">
<div id="wphead">
<?php $blog_name = get_bloginfo(array('name',false),array('display',false));
if ( (('') == $blog_name[0]))
 {$blog_name = array('&nbsp;',false);
}else 
{{$blog_name_excerpt = wp_html_excerpt($blog_name,array(40,false));
if ( ($blog_name[0] != $blog_name_excerpt[0]))
 $blog_name_excerpt = concat2(Aspis_trim($blog_name_excerpt),'&hellip;');
$blog_name = $blog_name_excerpt;
}}$title_class = array('',false);
if ( function_exists(('mb_strlen')))
 {if ( ((mb_strlen(deAspisRC($blog_name),'UTF-8')) > (30)))
 $title_class = array('class="long-title"',false);
}else 
{{if ( (strlen($blog_name[0]) > (30)))
 $title_class = array('class="long-title"',false);
}};
?>

<img id="header-logo" src="../wp-includes/images/blank.gif" alt="" width="32" height="32" /> <h1 id="site-heading" <?php echo AspisCheckPrint($title_class);
?>><a href="<?php echo AspisCheckPrint(trailingslashit(get_bloginfo(array('url',false))));
;
?>" title="<?php _e(array('Visit Site',false));
?>"><span id="site-title"><?php echo AspisCheckPrint($blog_name);
?></span> <em id="site-visit-button"><?php _e(array('Visit Site',false));
?></em></a></h1>

<div id="wphead-info">
<div id="user_info">
<p><?php printf(deAspis(__(array('Howdy, <a href="%1$s" title="Edit your profile">%2$s</a>',false))),'profile.php',deAspisRC($user_identity));
?>
<?php if ( (denot_boolean($is_opera)))
 {;
?><span class="turbo-nag hidden"> | <a href="tools.php"><?php _e(array('Turbo',false));
?></a></span><?php };
?> |
<a href="<?php echo AspisCheckPrint(wp_logout_url());
?>" title="<?php _e(array('Log Out',false));
?>"><?php _e(array('Log Out',false));
;
?></a></p>
</div>

<?php favorite_actions($hook_suffix);
;
?>
</div>
</div>

<div id="wpbody">
<?php require (deconcat12(ABSPATH,'wp-admin/menu-header.php'));
;
?>

<div id="wpbody-content">
<?php screen_meta($hook_suffix);
do_action(array('admin_notices',false));
if ( ($parent_file[0] == ('options-general.php')))
 {require (deconcat12(ABSPATH,'wp-admin/options-head.php'));
}