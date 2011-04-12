<?php require_once('AspisMain.php'); ?><?php
define(('WP_INSTALLING'),true);
require_once (deconcat2(Aspis_dirname(Aspis_dirname(array(__FILE__,false))),'/wp-load.php'));
require_once (deconcat2(Aspis_dirname(array(__FILE__,false)),'/includes/upgrade.php'));
if ( ((isset($_GET[0][('step')]) && Aspis_isset( $_GET [0][('step')]))))
 $step = $_GET[0]['step'];
else 
{$step = array(0,false);
}function display_header (  ) {
header(('Content-Type: text/html; charset=utf-8'));
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes();
;
?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php _e(array('WordPress &rsaquo; Installation',false));
;
?></title>
	<?php wp_admin_css(array('install',false),array(true,false));
;
?>
</head>
<body>
<h1 id="logo"><img alt="WordPress" src="images/wordpress-logo.png" /></h1>

<?php  }
function display_setup_form ( $error = array(null,false) ) {
$blog_public = array(1,false);
if ( (((isset($_POST) && Aspis_isset( $_POST))) && (!((empty($_POST) || Aspis_empty( $_POST))))))
 {$blog_public = array((isset($_POST[0][('blog_public')]) && Aspis_isset( $_POST [0][('blog_public')])),false);
}if ( (!(is_null(deAspisRC($error)))))
 {;
?>
<p><?php printf(deAspis(__(array('<strong>ERROR</strong>: %s',false))),deAspisRC($error));
;
?></p>
<?php };
?>
<form id="setup" method="post" action="install.php?step=2">
	<table class="form-table">
		<tr>
			<th scope="row"><label for="weblog_title"><?php _e(array('Blog Title',false));
;
?></label></th>
			<td><input name="weblog_title" type="text" id="weblog_title" size="25" value="<?php echo AspisCheckPrint((((isset($_POST[0][('weblog_title')]) && Aspis_isset( $_POST [0][('weblog_title')]))) ? esc_attr($_POST[0]['weblog_title']) : array('',false)));
;
?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="admin_email"><?php _e(array('Your E-mail',false));
;
?></label></th>
			<td><input name="admin_email" type="text" id="admin_email" size="25" value="<?php echo AspisCheckPrint((((isset($_POST[0][('admin_email')]) && Aspis_isset( $_POST [0][('admin_email')]))) ? esc_attr($_POST[0]['admin_email']) : array('',false)));
;
?>" /><br />
			<?php _e(array('Double-check your email address before continuing.',false));
;
?></td>
		</tr>
		<tr>
			<td colspan="2"><label><input type="checkbox" name="blog_public" value="1" <?php checked($blog_public);
;
?> /> <?php _e(array('Allow my blog to appear in search engines like Google and Technorati.',false));
;
?></label></td>
		</tr>
	</table>
	<p class="step"><input type="submit" name="Submit" value="<?php esc_attr_e(array('Install WordPress',false));
;
?>" class="button" /></p>
</form>
<?php  }
if ( deAspis(is_blog_installed()))
 {display_header();
Aspis_exit(concat2(concat(concat2(concat1('<h1>',__(array('Already Installed',false))),'</h1><p>'),__(array('You appear to have already installed WordPress. To reinstall please clear your old database tables first.',false))),'</p></body></html>'));
}$php_version = array(phpversion(),false);
$mysql_version = $wpdb[0]->db_version();
$php_compat = array(version_compare(deAspisRC($php_version),deAspisRC($required_php_version),'>='),false);
$mysql_compat = array((version_compare(deAspisRC($mysql_version),deAspisRC($required_mysql_version),'>=')) || file_exists((deconcat12(WP_CONTENT_DIR,'/db.php'))),false);
if ( ((denot_boolean($mysql_compat)) && (denot_boolean($php_compat))))
 $compat = Aspis_sprintf(__(array('You cannot install because WordPress %1$s requires PHP version %2$s or higher and MySQL version %3$s or higher. You are running PHP version %4$s and MySQL version %5$s.',false)),$wp_version,$required_php_version,$required_mysql_version,$php_version,$mysql_version);
elseif ( (denot_boolean($php_compat)))
 $compat = Aspis_sprintf(__(array('You cannot install because WordPress %1$s requires PHP version %2$s or higher. You are running version %3$s.',false)),$wp_version,$required_php_version,$php_version);
elseif ( (denot_boolean($mysql_compat)))
 $compat = Aspis_sprintf(__(array('You cannot install because WordPress %1$s requires MySQL version %2$s or higher. You are running version %3$s.',false)),$wp_version,$required_mysql_version,$mysql_version);
if ( ((denot_boolean($mysql_compat)) || (denot_boolean($php_compat))))
 {display_header();
Aspis_exit(concat2(concat(concat2(concat1('<h1>',__(array('Insufficient Requirements',false))),'</h1><p>'),$compat),'</p></body></html>'));
}switch ( $step[0] ) {
case (0):case (1):display_header();
;
?>
<h1><?php _e(array('Welcome',false));
;
?></h1>
<p><?php printf(deAspis(__(array('Welcome to the famous five minute WordPress installation process! You may want to browse the <a href="%s">ReadMe documentation</a> at your leisure.  Otherwise, just fill in the information below and you&#8217;ll be on your way to using the most extendable and powerful personal publishing platform in the world.',false))),'../readme.html');
;
?></p>
<!--<h2 class="step"><a href="install.php?step=1"><?php _e(array('First Step',false));
;
?></a></h2>-->

<h1><?php _e(array('Information needed',false));
;
?></h1>
<p><?php _e(array('Please provide the following information.  Don&#8217;t worry, you can always change these settings later.',false));
;
?></p>



<?php display_setup_form();
break ;
case (2):if ( (!((empty($wpdb[0]->error) || Aspis_empty( $wpdb[0] ->error )))))
 wp_die($wpdb[0]->error[0]->get_error_message());
display_header();
$weblog_title = ((isset($_POST[0][('weblog_title')]) && Aspis_isset( $_POST [0][('weblog_title')]))) ? Aspis_stripslashes($_POST[0]['weblog_title']) : array('',false);
$admin_email = ((isset($_POST[0][('admin_email')]) && Aspis_isset( $_POST [0][('admin_email')]))) ? Aspis_stripslashes($_POST[0]['admin_email']) : array('',false);
$public = ((isset($_POST[0][('blog_public')]) && Aspis_isset( $_POST [0][('blog_public')]))) ? int_cast($_POST[0]['blog_public']) : array(0,false);
$error = array(false,false);
if ( ((empty($admin_email) || Aspis_empty( $admin_email))))
 {display_setup_form(__(array('you must provide an e-mail address.',false)));
$error = array(true,false);
}else 
{if ( (denot_boolean(is_email($admin_email))))
 {display_setup_form(__(array('that isn&#8217;t a valid e-mail address.  E-mail addresses look like: <code>username@example.com</code>',false)));
$error = array(true,false);
}}if ( ($error[0] === false))
 {$wpdb[0]->show_errors();
$result = wp_install($weblog_title,array('admin',false),$admin_email,$public);
extract(($result[0]),EXTR_SKIP);
;
?>

<h1><?php _e(array('Success!',false));
;
?></h1>

<p><?php printf(deAspis(__(array('WordPress has been installed. Were you expecting more steps? Sorry to disappoint.',false))),'');
;
?></p>

<table class="form-table">
	<tr>
		<th><?php _e(array('Username',false));
;
?></th>
		<td><code>admin</code></td>
	</tr>
	<tr>
		<th><?php _e(array('Password',false));
;
?></th>
		<td><?php if ( (!((empty($password) || Aspis_empty( $password)))))
 {echo AspisCheckPrint(concat2(concat1('<code>',$password),'</code><br />'));
}echo AspisCheckPrint(concat2(concat1('<p>',$password_message),'</p>'));
;
?></td>
	</tr>
</table>

<p class="step"><a href="../wp-login.php" class="button"><?php _e(array('Log In',false));
;
?></a></p>

<?php }break ;
 }
;
?>
<script type="text/javascript">var t = document.getElementById('weblog_title'); if (t){ t.focus(); }</script>
</body>
</html>
<?php 