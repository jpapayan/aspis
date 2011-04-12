<?php require_once('AspisMain.php'); ?><?php
require (deconcat2(Aspis_dirname(array(__FILE__,false)),'/wp-load.php'));
if ( (deAspis(force_ssl_admin()) && (denot_boolean(is_ssl()))))
 {if ( ((0) === strpos(deAspis($_SERVER[0]['REQUEST_URI']),'http')))
 {wp_redirect(Aspis_preg_replace(array('|^http://|',false),array('https://',false),$_SERVER[0]['REQUEST_URI']));
Aspis_exit();
}else 
{{wp_redirect(concat(concat1('https://',$_SERVER[0]['HTTP_HOST']),$_SERVER[0]['REQUEST_URI']));
Aspis_exit();
}}}function login_header ( $title = array('Log In',false),$message = array('',false),$wp_error = array('',false) ) {
global $error,$is_iphone,$interim_login;
add_filter(array('pre_option_blog_public',false),Aspis_create_function(array('$a',false),array('return 0;',false)));
add_action(array('login_head',false),array('noindex',false));
if ( ((empty($wp_error) || Aspis_empty( $wp_error))))
 $wp_error = array(new WP_Error(),false);
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes();
;
?>>
<head>
	<title><?php bloginfo(array('name',false));
;
?> &rsaquo; <?php echo AspisCheckPrint($title);
;
?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo(array('html_type',false));
;
?>; charset=<?php bloginfo(array('charset',false));
;
?>" />
<?php wp_admin_css(array('login',false),array(true,false));
wp_admin_css(array('colors-fresh',false),array(true,false));
if ( $is_iphone[0])
 {;
?>
	<meta name="viewport" content="width=320; initial-scale=0.9; maximum-scale=1.0; user-scalable=0;" />
	<style type="text/css" media="screen">
	form { margin-left: 0px; }
	#login { margin-top: 20px; }
	</style>
<?php }elseif ( (((isset($interim_login) && Aspis_isset( $interim_login))) && $interim_login[0]))
 {;
?>
	<style type="text/css" media="all">
	.login #login { margin: 20px auto; }
	</style>
<?php }do_action(array('login_head',false));
;
?>
</head>
<body class="login">

<div id="login"><h1><a href="<?php echo AspisCheckPrint(apply_filters(array('login_headerurl',false),array('http://wordpress.org/',false)));
;
?>" title="<?php echo AspisCheckPrint(apply_filters(array('login_headertitle',false),__(array('Powered by WordPress',false))));
;
?>"><?php bloginfo(array('name',false));
;
?></a></h1>
<?php $message = apply_filters(array('login_message',false),$message);
if ( (!((empty($message) || Aspis_empty( $message)))))
 echo AspisCheckPrint(concat2($message,"\n"));
if ( (!((empty($error) || Aspis_empty( $error)))))
 {$wp_error[0]->add(array('error',false),$error);
unset($error);
}if ( deAspis($wp_error[0]->get_error_code()))
 {$errors = array('',false);
$messages = array('',false);
foreach ( deAspis($wp_error[0]->get_error_codes()) as $code  )
{$severity = $wp_error[0]->get_error_data($code);
foreach ( deAspis($wp_error[0]->get_error_messages($code)) as $error  )
{if ( (('message') == $severity[0]))
 $messages = concat($messages,concat2(concat1('	',$error),"<br />\n"));
else 
{$errors = concat($errors,concat2(concat1('	',$error),"<br />\n"));
}}}if ( (!((empty($errors) || Aspis_empty( $errors)))))
 echo AspisCheckPrint(concat2(concat1('<div id="login_error">',apply_filters(array('login_errors',false),$errors)),"</div>\n"));
if ( (!((empty($messages) || Aspis_empty( $messages)))))
 echo AspisCheckPrint(concat2(concat1('<p class="message">',apply_filters(array('login_messages',false),$messages)),"</p>\n"));
} }
function retrieve_password (  ) {
global $wpdb;
$errors = array(new WP_Error(),false);
if ( (((empty($_POST[0][('user_login')]) || Aspis_empty( $_POST [0][('user_login')]))) && ((empty($_POST[0][('user_email')]) || Aspis_empty( $_POST [0][('user_email')])))))
 $errors[0]->add(array('empty_username',false),__(array('<strong>ERROR</strong>: Enter a username or e-mail address.',false)));
if ( strpos(deAspis($_POST[0]['user_login']),'@'))
 {$user_data = get_user_by_email(Aspis_trim($_POST[0]['user_login']));
if ( ((empty($user_data) || Aspis_empty( $user_data))))
 $errors[0]->add(array('invalid_email',false),__(array('<strong>ERROR</strong>: There is no user registered with that email address.',false)));
}else 
{{$login = Aspis_trim($_POST[0]['user_login']);
$user_data = get_userdatabylogin($login);
}}do_action(array('lostpassword_post',false));
if ( deAspis($errors[0]->get_error_code()))
 return $errors;
if ( (denot_boolean($user_data)))
 {$errors[0]->add(array('invalidcombo',false),__(array('<strong>ERROR</strong>: Invalid username or e-mail.',false)));
return $errors;
}$user_login = $user_data[0]->user_login;
$user_email = $user_data[0]->user_email;
do_action(array('retreive_password',false),$user_login);
do_action(array('retrieve_password',false),$user_login);
$allow = apply_filters(array('allow_password_reset',false),array(true,false),$user_data[0]->ID);
if ( (denot_boolean($allow)))
 return array(new WP_Error(array('no_password_reset',false),__(array('Password reset is not allowed for this user',false))),false);
else 
{if ( deAspis(is_wp_error($allow)))
 return $allow;
}$key = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT user_activation_key FROM ",$wpdb[0]->users)," WHERE user_login = %s"),$user_login));
if ( ((empty($key) || Aspis_empty( $key))))
 {$key = wp_generate_password(array(20,false),array(false,false));
do_action(array('retrieve_password_key',false),$user_login,$key);
$wpdb[0]->update($wpdb[0]->users,array(array(deregisterTaint(array('user_activation_key',false)) => addTaint($key)),false),array(array(deregisterTaint(array('user_login',false)) => addTaint($user_login)),false));
}$message = concat2(__(array('Someone has asked to reset the password for the following site and username.',false)),"\r\n\r\n");
$message = concat($message,concat2(get_option(array('siteurl',false)),"\r\n\r\n"));
$message = concat($message,concat2(Aspis_sprintf(__(array('Username: %s',false)),$user_login),"\r\n\r\n"));
$message = concat($message,concat2(__(array('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.',false)),"\r\n\r\n"));
$message = concat($message,concat2(site_url(concat(concat2(concat1("wp-login.php?action=rp&key=",$key),"&login="),Aspis_rawurlencode($user_login)),array('login',false)),"\r\n"));
$blogname = wp_specialchars_decode(get_option(array('blogname',false)),array(ENT_QUOTES,false));
$title = Aspis_sprintf(__(array('[%s] Password Reset',false)),$blogname);
$title = apply_filters(array('retrieve_password_title',false),$title);
$message = apply_filters(array('retrieve_password_message',false),$message,$key);
if ( ($message[0] && (denot_boolean(wp_mail($user_email,$title,$message)))))
 Aspis_exit(concat2(concat(concat2(concat1('<p>',__(array('The e-mail could not be sent.',false))),"<br />\n"),__(array('Possible reason: your host may have disabled the mail() function...',false))),'</p>'));
return array(true,false);
 }
function reset_password ( $key,$login ) {
global $wpdb;
$key = Aspis_preg_replace(array('/[^a-z0-9]/i',false),array('',false),$key);
if ( (((empty($key) || Aspis_empty( $key))) || (!(is_string(deAspisRC($key))))))
 return array(new WP_Error(array('invalid_key',false),__(array('Invalid key',false))),false);
if ( (((empty($login) || Aspis_empty( $login))) || (!(is_string(deAspisRC($login))))))
 return array(new WP_Error(array('invalid_key',false),__(array('Invalid key',false))),false);
$user = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->users)," WHERE user_activation_key = %s AND user_login = %s"),$key,$login));
if ( ((empty($user) || Aspis_empty( $user))))
 return array(new WP_Error(array('invalid_key',false),__(array('Invalid key',false))),false);
$new_pass = wp_generate_password();
do_action(array('password_reset',false),$user,$new_pass);
wp_set_password($new_pass,$user[0]->ID);
update_usermeta($user[0]->ID,array('default_password_nag',false),array(true,false));
$message = concat2(Aspis_sprintf(__(array('Username: %s',false)),$user[0]->user_login),"\r\n");
$message = concat($message,concat2(Aspis_sprintf(__(array('Password: %s',false)),$new_pass),"\r\n"));
$message = concat($message,concat2(site_url(array('wp-login.php',false),array('login',false)),"\r\n"));
$blogname = wp_specialchars_decode(get_option(array('blogname',false)),array(ENT_QUOTES,false));
$title = Aspis_sprintf(__(array('[%s] Your new password',false)),$blogname);
$title = apply_filters(array('password_reset_title',false),$title);
$message = apply_filters(array('password_reset_message',false),$message,$new_pass);
if ( ($message[0] && (denot_boolean(wp_mail($user[0]->user_email,$title,$message)))))
 Aspis_exit(concat2(concat(concat2(concat1('<p>',__(array('The e-mail could not be sent.',false))),"<br />\n"),__(array('Possible reason: your host may have disabled the mail() function...',false))),'</p>'));
wp_password_change_notification($user);
return array(true,false);
 }
function register_new_user ( $user_login,$user_email ) {
$errors = array(new WP_Error(),false);
$user_login = sanitize_user($user_login);
$user_email = apply_filters(array('user_registration_email',false),$user_email);
if ( ($user_login[0] == ('')))
 $errors[0]->add(array('empty_username',false),__(array('<strong>ERROR</strong>: Please enter a username.',false)));
elseif ( (denot_boolean(validate_username($user_login))))
 {$errors[0]->add(array('invalid_username',false),__(array('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.',false)));
$user_login = array('',false);
}elseif ( deAspis(username_exists($user_login)))
 $errors[0]->add(array('username_exists',false),__(array('<strong>ERROR</strong>: This username is already registered, please choose another one.',false)));
if ( ($user_email[0] == ('')))
 {$errors[0]->add(array('empty_email',false),__(array('<strong>ERROR</strong>: Please type your e-mail address.',false)));
}elseif ( (denot_boolean(is_email($user_email))))
 {$errors[0]->add(array('invalid_email',false),__(array('<strong>ERROR</strong>: The email address isn&#8217;t correct.',false)));
$user_email = array('',false);
}elseif ( deAspis(email_exists($user_email)))
 $errors[0]->add(array('email_exists',false),__(array('<strong>ERROR</strong>: This email is already registered, please choose another one.',false)));
do_action(array('register_post',false),$user_login,$user_email,$errors);
$errors = apply_filters(array('registration_errors',false),$errors,$user_login,$user_email);
if ( deAspis($errors[0]->get_error_code()))
 return $errors;
$user_pass = wp_generate_password();
$user_id = wp_create_user($user_login,$user_pass,$user_email);
if ( (denot_boolean($user_id)))
 {$errors[0]->add(array('registerfail',false),Aspis_sprintf(__(array('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !',false)),get_option(array('admin_email',false))));
return $errors;
}wp_new_user_notification($user_id,$user_pass);
return $user_id;
 }
$action = ((isset($_REQUEST[0][('action')]) && Aspis_isset( $_REQUEST [0][('action')]))) ? $_REQUEST[0]['action'] : array('login',false);
$errors = array(new WP_Error(),false);
if ( ((isset($_GET[0][('key')]) && Aspis_isset( $_GET [0][('key')]))))
 $action = array('resetpass',false);
if ( ((denot_boolean(Aspis_in_array($action,array(array(array('logout',false),array('lostpassword',false),array('retrievepassword',false),array('resetpass',false),array('rp',false),array('register',false),array('login',false)),false),array(true,false)))) && (false === deAspis(has_filter(concat1('login_form_',$action))))))
 $action = array('login',false);
nocache_headers();
header((deconcat(concat2(concat1('Content-Type: ',get_bloginfo(array('html_type',false))),'; charset='),get_bloginfo(array('charset',false)))));
if ( defined(('RELOCATE')))
 {if ( (((isset($_SERVER[0][('PATH_INFO')]) && Aspis_isset( $_SERVER [0][('PATH_INFO')]))) && (deAspis($_SERVER[0]['PATH_INFO']) != deAspis($_SERVER[0]['PHP_SELF']))))
 arrayAssign($_SERVER[0],deAspis(registerTaint(array('PHP_SELF',false))),addTaint(Aspis_str_replace($_SERVER[0]['PATH_INFO'],array('',false),$_SERVER[0]['PHP_SELF'])));
$schema = (((isset($_SERVER[0][('HTTPS')]) && Aspis_isset( $_SERVER [0][('HTTPS')]))) && (deAspis(Aspis_strtolower($_SERVER[0]['HTTPS'])) == ('on'))) ? array('https://',false) : array('http://',false);
if ( (deAspis(Aspis_dirname(concat(concat($schema,$_SERVER[0]['HTTP_HOST']),$_SERVER[0]['PHP_SELF']))) != deAspis(get_option(array('siteurl',false)))))
 update_option(array('siteurl',false),Aspis_dirname(concat(concat($schema,$_SERVER[0]['HTTP_HOST']),$_SERVER[0]['PHP_SELF'])));
}setcookie(TEST_COOKIE,('WP Cookie check'),(0),COOKIEPATH,COOKIE_DOMAIN);
if ( (SITECOOKIEPATH != COOKIEPATH))
 setcookie(TEST_COOKIE,('WP Cookie check'),(0),SITECOOKIEPATH,COOKIE_DOMAIN);
do_action(concat1('login_form_',$action));
$http_post = (array(('POST') == deAspis($_SERVER[0]['REQUEST_METHOD']),false));
switch ( $action[0] ) {
case ('logout'):check_admin_referer(array('log-out',false));
wp_logout();
$redirect_to = array('wp-login.php?loggedout=true',false);
if ( ((isset($_REQUEST[0][('redirect_to')]) && Aspis_isset( $_REQUEST [0][('redirect_to')]))))
 $redirect_to = $_REQUEST[0]['redirect_to'];
wp_safe_redirect($redirect_to);
Aspis_exit();
break ;
case ('lostpassword'):case ('retrievepassword'):if ( $http_post[0])
 {$errors = retrieve_password();
if ( (denot_boolean(is_wp_error($errors))))
 {wp_redirect(array('wp-login.php?checkemail=confirm',false));
Aspis_exit();
}}if ( (((isset($_GET[0][('error')]) && Aspis_isset( $_GET [0][('error')]))) && (('invalidkey') == deAspis($_GET[0]['error']))))
 $errors[0]->add(array('invalidkey',false),__(array('Sorry, that key does not appear to be valid.',false)));
do_action(array('lost_password',false));
login_header(__(array('Lost Password',false)),concat2(concat1('<p class="message">',__(array('Please enter your username or e-mail address. You will receive a new password via e-mail.',false))),'</p>'),$errors);
$user_login = ((isset($_POST[0][('user_login')]) && Aspis_isset( $_POST [0][('user_login')]))) ? Aspis_stripslashes($_POST[0]['user_login']) : array('',false);
;
?>

<form name="lostpasswordform" id="lostpasswordform" action="<?php echo AspisCheckPrint(site_url(array('wp-login.php?action=lostpassword',false),array('login_post',false)));
;
?>" method="post">
	<p>
		<label><?php _e(array('Username or E-mail:',false));
;
?><br />
		<input type="text" name="user_login" id="user_login" class="input" value="<?php echo AspisCheckPrint(esc_attr($user_login));
;
?>" size="20" tabindex="10" /></label>
	</p>
<?php do_action(array('lostpassword_form',false));
;
?>
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="<?php esc_attr_e(array('Get New Password',false));
;
?>" tabindex="100" /></p>
</form>

<p id="nav">
<?php if ( deAspis(get_option(array('users_can_register',false))))
 {;
?>
<a href="<?php echo AspisCheckPrint(site_url(array('wp-login.php',false),array('login',false)));
;
?>"><?php _e(array('Log in',false));
;
?></a> |
<a href="<?php echo AspisCheckPrint(site_url(array('wp-login.php?action=register',false),array('login',false)));
;
?>"><?php _e(array('Register',false));
;
?></a>
<?php }else 
{;
?>
<a href="<?php echo AspisCheckPrint(site_url(array('wp-login.php',false),array('login',false)));
;
?>"><?php _e(array('Log in',false));
;
?></a>
<?php };
?>
</p>

</div>

<p id="backtoblog"><a href="<?php bloginfo(array('url',false));
;
?>/" title="<?php _e(array('Are you lost?',false));
;
?>"><?php printf(deAspis(__(array('&larr; Back to %s',false))),deAspisRC(get_bloginfo(array('title',false),array('display',false))));
;
?></a></p>

<script type="text/javascript">
try{document.getElementById('user_login').focus();}catch(e){}
</script>
</body>
</html>
<?php break ;
case ('resetpass'):case ('rp'):$errors = reset_password($_GET[0]['key'],$_GET[0]['login']);
if ( (denot_boolean(is_wp_error($errors))))
 {wp_redirect(array('wp-login.php?checkemail=newpass',false));
Aspis_exit();
}wp_redirect(array('wp-login.php?action=lostpassword&error=invalidkey',false));
Aspis_exit();
break ;
case ('register'):if ( (denot_boolean(get_option(array('users_can_register',false)))))
 {wp_redirect(array('wp-login.php?registration=disabled',false));
Aspis_exit();
}$user_login = array('',false);
$user_email = array('',false);
if ( $http_post[0])
 {require_once (deconcat2(concat12(ABSPATH,WPINC),'/registration.php'));
$user_login = $_POST[0]['user_login'];
$user_email = $_POST[0]['user_email'];
$errors = register_new_user($user_login,$user_email);
if ( (denot_boolean(is_wp_error($errors))))
 {wp_redirect(array('wp-login.php?checkemail=registered',false));
Aspis_exit();
}}login_header(__(array('Registration Form',false)),concat2(concat1('<p class="message register">',__(array('Register For This Site',false))),'</p>'),$errors);
;
?>

<form name="registerform" id="registerform" action="<?php echo AspisCheckPrint(site_url(array('wp-login.php?action=register',false),array('login_post',false)));
;
?>" method="post">
	<p>
		<label><?php _e(array('Username',false));
;
?><br />
		<input type="text" name="user_login" id="user_login" class="input" value="<?php echo AspisCheckPrint(esc_attr(Aspis_stripslashes($user_login)));
;
?>" size="20" tabindex="10" /></label>
	</p>
	<p>
		<label><?php _e(array('E-mail',false));
;
?><br />
		<input type="text" name="user_email" id="user_email" class="input" value="<?php echo AspisCheckPrint(esc_attr(Aspis_stripslashes($user_email)));
;
?>" size="25" tabindex="20" /></label>
	</p>
<?php do_action(array('register_form',false));
;
?>
	<p id="reg_passmail"><?php _e(array('A password will be e-mailed to you.',false));
;
?></p>
	<br class="clear" />
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="<?php esc_attr_e(array('Register',false));
;
?>" tabindex="100" /></p>
</form>

<p id="nav">
<a href="<?php echo AspisCheckPrint(site_url(array('wp-login.php',false),array('login',false)));
;
?>"><?php _e(array('Log in',false));
;
?></a> |
<a href="<?php echo AspisCheckPrint(site_url(array('wp-login.php?action=lostpassword',false),array('login',false)));
;
?>" title="<?php _e(array('Password Lost and Found',false));
;
?>"><?php _e(array('Lost your password?',false));
;
?></a>
</p>

</div>

<p id="backtoblog"><a href="<?php bloginfo(array('url',false));
;
?>/" title="<?php _e(array('Are you lost?',false));
;
?>"><?php printf(deAspis(__(array('&larr; Back to %s',false))),deAspisRC(get_bloginfo(array('title',false),array('display',false))));
;
?></a></p>

<script type="text/javascript">
try{document.getElementById('user_login').focus();}catch(e){}
</script>
</body>
</html>
<?php break ;
case ('login'):default :$secure_cookie = array('',false);
$interim_login = array((isset($_REQUEST[0][('interim-login')]) && Aspis_isset( $_REQUEST [0][('interim-login')])),false);
if ( ((!((empty($_POST[0][('log')]) || Aspis_empty( $_POST [0][('log')])))) && (denot_boolean(force_ssl_admin()))))
 {$user_name = sanitize_user($_POST[0]['log']);
if ( deAspis($user = get_userdatabylogin($user_name)))
 {if ( deAspis(get_user_option(array('use_ssl',false),$user[0]->ID)))
 {$secure_cookie = array(true,false);
force_ssl_admin(array(true,false));
}}}if ( ((isset($_REQUEST[0][('redirect_to')]) && Aspis_isset( $_REQUEST [0][('redirect_to')]))))
 {$redirect_to = $_REQUEST[0]['redirect_to'];
if ( ($secure_cookie[0] && (false !== strpos($redirect_to[0],'wp-admin'))))
 $redirect_to = Aspis_preg_replace(array('|^http://|',false),array('https://',false),$redirect_to);
}else 
{{$redirect_to = admin_url();
}}if ( ((((((denot_boolean($secure_cookie)) && deAspis(is_ssl())) && deAspis(force_ssl_login())) && (denot_boolean(force_ssl_admin()))) && ((0) !== strpos($redirect_to[0],'https'))) && ((0) === strpos($redirect_to[0],'http'))))
 $secure_cookie = array(false,false);
$user = wp_signon(array('',false),$secure_cookie);
$redirect_to = apply_filters(array('login_redirect',false),$redirect_to,((isset($_REQUEST[0][('redirect_to')]) && Aspis_isset( $_REQUEST [0][('redirect_to')]))) ? $_REQUEST[0]['redirect_to'] : array('',false),$user);
if ( (denot_boolean(is_wp_error($user))))
 {if ( $interim_login[0])
 {$message = concat2(concat1('<p class="message">',__(array('You have logged in successfully.',false))),'</p>');
login_header(array('',false),$message);
;
?>
			<script type="text/javascript">setTimeout( function(){window.close()}, 8000);</script>
			<p class="alignright">
			<input type="button" class="button-primary" value="<?php esc_attr_e(array('Close',false));
;
?>" onclick="window.close()" /></p>
			</div></body></html>
<?php Aspis_exit();
}if ( ((denot_boolean($user[0]->has_cap(array('edit_posts',false)))) && ((((empty($redirect_to) || Aspis_empty( $redirect_to))) || ($redirect_to[0] == ('wp-admin/'))) || ($redirect_to[0] == deAspis(admin_url())))))
 $redirect_to = admin_url(array('profile.php',false));
wp_safe_redirect($redirect_to);
Aspis_exit();
}$errors = $user;
if ( (!((empty($_GET[0][('loggedout')]) || Aspis_empty( $_GET [0][('loggedout')])))))
 $errors = array(new WP_Error(),false);
if ( (((isset($_POST[0][('testcookie')]) && Aspis_isset( $_POST [0][('testcookie')]))) && ((empty($_COOKIE[0][TEST_COOKIE]) || Aspis_empty( $_COOKIE [0][TEST_COOKIE])))))
 $errors[0]->add(array('test_cookie',false),__(array("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress.",false)));
if ( (((isset($_GET[0][('loggedout')]) && Aspis_isset( $_GET [0][('loggedout')]))) && (TRUE == deAspis($_GET[0]['loggedout']))))
 $errors[0]->add(array('loggedout',false),__(array('You are now logged out.',false)),array('message',false));
elseif ( (((isset($_GET[0][('registration')]) && Aspis_isset( $_GET [0][('registration')]))) && (('disabled') == deAspis($_GET[0]['registration']))))
 $errors[0]->add(array('registerdisabled',false),__(array('User registration is currently not allowed.',false)));
elseif ( (((isset($_GET[0][('checkemail')]) && Aspis_isset( $_GET [0][('checkemail')]))) && (('confirm') == deAspis($_GET[0]['checkemail']))))
 $errors[0]->add(array('confirm',false),__(array('Check your e-mail for the confirmation link.',false)),array('message',false));
elseif ( (((isset($_GET[0][('checkemail')]) && Aspis_isset( $_GET [0][('checkemail')]))) && (('newpass') == deAspis($_GET[0]['checkemail']))))
 $errors[0]->add(array('newpass',false),__(array('Check your e-mail for your new password.',false)),array('message',false));
elseif ( (((isset($_GET[0][('checkemail')]) && Aspis_isset( $_GET [0][('checkemail')]))) && (('registered') == deAspis($_GET[0]['checkemail']))))
 $errors[0]->add(array('registered',false),__(array('Registration complete. Please check your e-mail.',false)),array('message',false));
elseif ( $interim_login[0])
 $errors[0]->add(array('expired',false),__(array('Your session has expired. Please log-in again.',false)),array('message',false));
login_header(__(array('Log In',false)),array('',false),$errors);
if ( ((isset($_POST[0][('log')]) && Aspis_isset( $_POST [0][('log')]))))
 $user_login = ((('incorrect_password') == deAspis($errors[0]->get_error_code())) || (('empty_password') == deAspis($errors[0]->get_error_code()))) ? esc_attr(Aspis_stripslashes($_POST[0]['log'])) : array('',false);
;
?>

<?php if ( ((!((isset($_GET[0][('checkemail')]) && Aspis_isset( $_GET [0][('checkemail')])))) || (denot_boolean(Aspis_in_array($_GET[0]['checkemail'],array(array(array('confirm',false),array('newpass',false)),false))))))
 {;
?>
<form name="loginform" id="loginform" action="<?php echo AspisCheckPrint(site_url(array('wp-login.php',false),array('login_post',false)));
;
?>" method="post">
	<p>
		<label><?php _e(array('Username',false));
;
?><br />
		<input type="text" name="log" id="user_login" class="input" value="<?php echo AspisCheckPrint(esc_attr($user_login));
;
?>" size="20" tabindex="10" /></label>
	</p>
	<p>
		<label><?php _e(array('Password',false));
;
?><br />
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" /></label>
	</p>
<?php do_action(array('login_form',false));
;
?>
	<p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" /> <?php esc_attr_e(array('Remember Me',false));
;
?></label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="<?php esc_attr_e(array('Log In',false));
;
?>" tabindex="100" />
<?php if ( $interim_login[0])
 {;
?>
		<input type="hidden" name="interim-login" value="1" />
<?php }else 
{{;
?>
		<input type="hidden" name="redirect_to" value="<?php echo AspisCheckPrint(esc_attr($redirect_to));
;
?>" />
<?php }};
?>
		<input type="hidden" name="testcookie" value="1" />
	</p>
</form>
<?php };
?>

<?php if ( (denot_boolean($interim_login)))
 {;
?>
<p id="nav">
<?php if ( (((isset($_GET[0][('checkemail')]) && Aspis_isset( $_GET [0][('checkemail')]))) && deAspis(Aspis_in_array($_GET[0]['checkemail'],array(array(array('confirm',false),array('newpass',false)),false)))))
 {;
?>
<?php }elseif ( deAspis(get_option(array('users_can_register',false))))
 {;
?>
<a href="<?php echo AspisCheckPrint(site_url(array('wp-login.php?action=register',false),array('login',false)));
;
?>"><?php _e(array('Register',false));
;
?></a> |
<a href="<?php echo AspisCheckPrint(site_url(array('wp-login.php?action=lostpassword',false),array('login',false)));
;
?>" title="<?php _e(array('Password Lost and Found',false));
;
?>"><?php _e(array('Lost your password?',false));
;
?></a>
<?php }else 
{;
?>
<a href="<?php echo AspisCheckPrint(site_url(array('wp-login.php?action=lostpassword',false),array('login',false)));
;
?>" title="<?php _e(array('Password Lost and Found',false));
;
?>"><?php _e(array('Lost your password?',false));
;
?></a>
<?php };
?>
</p>

<p id="backtoblog"><a href="<?php bloginfo(array('url',false));
;
?>/" title="<?php _e(array('Are you lost?',false));
;
?>"><?php printf(deAspis(__(array('&larr; Back to %s',false))),deAspisRC(get_bloginfo(array('title',false),array('display',false))));
;
?></a></p>
<?php };
?>
</div>

<script type="text/javascript">
<?php if ( ($user_login[0] || $interim_login[0]))
 {;
?>
setTimeout( function(){ try{
d = document.getElementById('user_pass');
d.value = '';
d.focus();
} catch(e){}
}, 200);
<?php }else 
{{;
?>
try{document.getElementById('user_login').focus();}catch(e){}
<?php }};
?>
</script>
</body>
</html>
<?php break ;
 }
;
?>
<?php 