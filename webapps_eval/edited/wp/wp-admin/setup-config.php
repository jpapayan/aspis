<?php require_once('AspisMain.php'); ?><?php
define(('WP_INSTALLING'),true);
error_reporting(0);
define(('ABSPATH'),(deconcat2(Aspis_dirname(Aspis_dirname(array(__FILE__,false))),'/')));
define(('WPINC'),'wp-includes');
define(('WP_CONTENT_DIR'),(deconcat12(ABSPATH,'wp-content')));
require_once (deconcat2(concat12(ABSPATH,WPINC),'/compat.php'));
require_once (deconcat2(concat12(ABSPATH,WPINC),'/functions.php'));
require_once (deconcat2(concat12(ABSPATH,WPINC),'/classes.php'));
if ( (!(file_exists((deconcat12(ABSPATH,'wp-config-sample.php'))))))
 wp_die(array('Sorry, I need a wp-config-sample.php file to work from. Please re-upload this file from your WordPress installation.',false));
$configFile = Aspis_file(concat12(ABSPATH,'wp-config-sample.php'));
if ( file_exists((deconcat12(ABSPATH,'wp-config.php'))))
 wp_die(array("<p>The file 'wp-config.php' already exists. If you need to reset any of the configuration items in this file, please delete it first. You may try <a href='install.php'>installing now</a>.</p>",false));
if ( (file_exists((deconcat12(ABSPATH,'../wp-config.php'))) && (!(file_exists((deconcat12(ABSPATH,'../wp-settings.php')))))))
 wp_die(array("<p>The file 'wp-config.php' already exists one level above your WordPress installation. If you need to reset any of the configuration items in this file, please delete it first. You may try <a href='install.php'>installing now</a>.</p>",false));
if ( (version_compare('4.3',deAspisRC(array(phpversion(),false)),'>')))
 wp_die(Aspis_sprintf(array('Your server is running PHP version %s but WordPress requires at least 4.3.',false),array(phpversion(),false)));
if ( ((!(extension_loaded('mysql'))) && (!(file_exists((deconcat12(ABSPATH,'wp-content/db.php')))))))
 wp_die(array('Your PHP installation appears to be missing the MySQL extension which is required by WordPress.',false));
if ( ((isset($_GET[0][('step')]) && Aspis_isset( $_GET [0][('step')]))))
 $step = $_GET[0]['step'];
else 
{$step = array(0,false);
}function display_header (  ) {
header(('Content-Type: text/html; charset=utf-8'));
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WordPress &rsaquo; Setup Configuration File</title>
<link rel="stylesheet" href="css/install.css" type="text/css" />

</head>
<body>
<h1 id="logo"><img alt="WordPress" src="images/wordpress-logo.png" /></h1>
<?php  }
switch ( $step[0] ) {
case (0):display_header();
;
?>

<p>Welcome to WordPress. Before getting started, we need some information on the database. You will need to know the following items before proceeding.</p>
<ol>
	<li>Database name</li>
	<li>Database username</li>
	<li>Database password</li>
	<li>Database host</li>
	<li>Table prefix (if you want to run more than one WordPress in a single database) </li>
</ol>
<p><strong>If for any reason this automatic file creation doesn't work, don't worry. All this does is fill in the database information to a configuration file. You may also simply open <code>wp-config-sample.php</code> in a text editor, fill in your information, and save it as <code>wp-config.php</code>. </strong></p>
<p>In all likelihood, these items were supplied to you by your Web Host. If you do not have this information, then you will need to contact them before you can continue. If you&#8217;re all ready&hellip;</p>

<p class="step"><a href="setup-config.php?step=1" class="button">Let&#8217;s go!</a></p>
<?php break ;
case (1):display_header();
;
?>
<form method="post" action="setup-config.php?step=2">
	<p>Below you should enter your database connection details. If you're not sure about these, contact your host. </p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">Database Name</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" value="wordpress" /></td>
			<td>The name of the database you want to run WP in. </td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">User Name</label></th>
			<td><input name="uname" id="uname" type="text" size="25" value="username" /></td>
			<td>Your MySQL username</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">Password</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value="password" /></td>
			<td>...and MySQL password.</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">Database Host</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
			<td>99% chance you won't need to change this value.</td>
		</tr>
		<tr>
			<th scope="row"><label for="prefix">Table Prefix</label></th>
			<td><input name="prefix" id="prefix" type="text" id="prefix" value="wp_" size="25" /></td>
			<td>If you want to run multiple WordPress installations in a single database, change this.</td>
		</tr>
	</table>
	<p class="step"><input name="submit" type="submit" value="Submit" class="button" /></p>
</form>
<?php break ;
case (2):$dbname = Aspis_trim($_POST[0]['dbname']);
$uname = Aspis_trim($_POST[0]['uname']);
$passwrd = Aspis_trim($_POST[0]['pwd']);
$dbhost = Aspis_trim($_POST[0]['dbhost']);
$prefix = Aspis_trim($_POST[0]['prefix']);
if ( ((empty($prefix) || Aspis_empty( $prefix))))
 $prefix = array('wp_',false);
define(('DB_NAME'),deAspisRC($dbname));
define(('DB_USER'),deAspisRC($uname));
define(('DB_PASSWORD'),deAspisRC($passwrd));
define(('DB_HOST'),deAspisRC($dbhost));
require_wp_db();
if ( (!((empty($wpdb[0]->error) || Aspis_empty( $wpdb[0] ->error )))))
 wp_die($wpdb[0]->error[0]->get_error_message());
foreach ( $configFile[0] as $line_num =>$line )
{restoreTaint($line_num,$line);
{switch ( deAspis(Aspis_substr($line,array(0,false),array(16,false))) ) {
case ("define('DB_NAME'"):arrayAssign($configFile[0],deAspis(registerTaint($line_num)),addTaint(Aspis_str_replace(array("putyourdbnamehere",false),$dbname,$line)));
break ;
case ("define('DB_USER'"):arrayAssign($configFile[0],deAspis(registerTaint($line_num)),addTaint(Aspis_str_replace(array("'usernamehere'",false),concat2(concat1("'",$uname),"'"),$line)));
break ;
case ("define('DB_PASSW"):arrayAssign($configFile[0],deAspis(registerTaint($line_num)),addTaint(Aspis_str_replace(array("'yourpasswordhere'",false),concat2(concat1("'",$passwrd),"'"),$line)));
break ;
case ("define('DB_HOST'"):arrayAssign($configFile[0],deAspis(registerTaint($line_num)),addTaint(Aspis_str_replace(array("localhost",false),$dbhost,$line)));
break ;
case ('$table_prefix  ='):arrayAssign($configFile[0],deAspis(registerTaint($line_num)),addTaint(Aspis_str_replace(array('wp_',false),$prefix,$line)));
break ;
 }
}}if ( (!(is_writable(ABSPATH))))
 {display_header();
;
?>
<p>Sorry, but I can't write the <code>wp-config.php</code> file.</p>
<p>You can create the <code>wp-config.php</code> manually and paste the following text into it.</p>
<textarea cols="90" rows="15"><?php foreach ( $configFile[0] as $line  )
{echo AspisCheckPrint(Aspis_htmlentities($line));
};
?></textarea>
<p>After you've done that, click "Run the install."</p>
<p class="step"><a href="install.php" class="button">Run the install</a></p>
<?php }else 
{$handle = attAspis(fopen((deconcat12(ABSPATH,'wp-config.php')),('w')));
foreach ( $configFile[0] as $line  )
{fwrite($handle[0],$line[0]);
}fclose($handle[0]);
chmod((deconcat12(ABSPATH,'wp-config.php')),(0666));
display_header();
;
?>
<p>All right sparky! You've made it through this part of the installation. WordPress can now communicate with your database. If you are ready, time now to&hellip;</p>

<p class="step"><a href="install.php" class="button">Run the install</a></p>
<?php }break ;
 }
;
?>
</body>
</html>
<?php 