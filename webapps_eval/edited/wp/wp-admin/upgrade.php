<?php require_once('AspisMain.php'); ?><?php
define(('WP_INSTALLING'),true);
require ('../wp-load.php');
timer_start();
require_once (deconcat12(ABSPATH,'wp-admin/includes/upgrade.php'));
delete_transient(array('update_core',false));
if ( ((isset($_GET[0][('step')]) && Aspis_isset( $_GET [0][('step')]))))
 $step = $_GET[0]['step'];
else 
{$step = array(0,false);
}if ( (('upgrade_db') === $step[0]))
 {wp_upgrade();
Aspis_exit(array('0',false));
}$step = int_cast($step);
$php_version = array(phpversion(),false);
$mysql_version = $wpdb[0]->db_version();
$php_compat = array(version_compare(deAspisRC($php_version),deAspisRC($required_php_version),'>='),false);
$mysql_compat = array((version_compare(deAspisRC($mysql_version),deAspisRC($required_mysql_version),'>=')) || file_exists((deconcat12(WP_CONTENT_DIR,'/db.php'))),false);
@header((deconcat(concat2(concat1('Content-Type: ',get_option(array('html_type',false))),'; charset='),get_option(array('blog_charset',false)))));
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes();
;
?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo(array('html_type',false));
;
?>; charset=<?php echo AspisCheckPrint(get_option(array('blog_charset',false)));
;
?>" />
	<title><?php _e(array('WordPress &rsaquo; Upgrade',false));
;
?></title>
	<?php wp_admin_css(array('install',false),array(true,false));
;
?>
</head>
<body>
<h1 id="logo"><img alt="WordPress" src="images/wordpress-logo.png" /></h1>

<?php if ( ((deAspis(get_option(array('db_version',false))) == $wp_db_version[0]) || (denot_boolean(is_blog_installed()))))
 {;
?>

<h2><?php _e(array('No Upgrade Required',false));
;
?></h2>
<p><?php _e(array('Your WordPress database is already up-to-date!',false));
;
?></p>
<p class="step"><a class="button" href="<?php echo AspisCheckPrint(get_option(array('home',false)));
;
?>/"><?php _e(array('Continue',false));
;
?></a></p>

<?php }elseif ( ((denot_boolean($php_compat)) || (denot_boolean($mysql_compat))))
 {if ( ((denot_boolean($mysql_compat)) && (denot_boolean($php_compat))))
 printf(deAspis(__(array('You cannot upgrade because WordPress %1$s requires PHP version %2$s or higher and MySQL version %3$s or higher. You are running PHP version %4$s and MySQL version %5$s.',false))),deAspisRC($wp_version),deAspisRC($required_php_version),deAspisRC($required_mysql_version),deAspisRC($php_version),deAspisRC($mysql_version));
elseif ( (denot_boolean($php_compat)))
 printf(deAspis(__(array('You cannot upgrade because WordPress %1$s requires PHP version %2$s or higher. You are running version %3$s.',false))),deAspisRC($wp_version),deAspisRC($required_php_version),deAspisRC($php_version));
elseif ( (denot_boolean($mysql_compat)))
 printf(deAspis(__(array('You cannot upgrade because WordPress %1$s requires MySQL version %2$s or higher. You are running version %3$s.',false))),deAspisRC($wp_version),deAspisRC($required_mysql_version),deAspisRC($mysql_version));
;
?>
<?php }else 
{switch ( $step[0] ) {
case (0):$goback = Aspis_stripslashes(wp_get_referer());
$goback = esc_url_raw($goback);
$goback = Aspis_urlencode($goback);
;
?>
<h2><?php _e(array('Database Upgrade Required',false));
;
?></h2>
<p><?php _e(array('WordPress has been updated! Before we send you on your way, we have to upgrade your database to the newest version.',false));
;
?></p>
<p><?php _e(array('The upgrade process may take a little while, so please be patient.',false));
;
?></p>
<p class="step"><a class="button" href="upgrade.php?step=1&amp;backto=<?php echo AspisCheckPrint($goback);
;
?>"><?php _e(array('Upgrade WordPress Database',false));
;
?></a></p>
<?php break ;
;
case (1):wp_upgrade();
$backto = ((empty($_GET[0][('backto')]) || Aspis_empty( $_GET [0][('backto')]))) ? array('',false) : $_GET[0]['backto'];
$backto = Aspis_stripslashes(Aspis_urldecode($backto));
$backto = esc_url_raw($backto);
$backto = wp_validate_redirect($backto,concat2(__get_option(array('home',false)),'/'));
;
?>
<h2><?php _e(array('Upgrade Complete',false));
;
?></h2>
	<p><?php _e(array('Your WordPress database has been successfully upgraded!',false));
;
?></p>
	<p class="step"><a class="button" href="<?php echo AspisCheckPrint($backto);
;
?>"><?php _e(array('Continue',false));
;
?></a></p>

<!--
<pre>
<?php printf(deAspis(__(array('%s queries',false))),deAspisRC($wpdb[0]->num_queries));
;
?>

<?php printf(deAspis(__(array('%s seconds',false))),deAspisRC(timer_stop(array(0,false))));
;
?>
</pre>
-->

<?php break ;
 }
};
?>
</body>
</html>
<?php 