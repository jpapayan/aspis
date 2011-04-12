<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('create_users',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
require_once (deconcat2(concat12(ABSPATH,WPINC),'/registration.php'));
if ( (((isset($_REQUEST[0][('action')]) && Aspis_isset( $_REQUEST [0][('action')]))) && (('adduser') == deAspis($_REQUEST[0]['action']))))
 {check_admin_referer(array('add-user',false));
if ( (denot_boolean(current_user_can(array('create_users',false)))))
 wp_die(__(array('You can&#8217;t create users.',false)));
$user_id = add_user();
if ( deAspis(is_wp_error($user_id)))
 {$add_user_errors = $user_id;
}else 
{{$new_user_login = apply_filters(array('pre_user_login',false),sanitize_user(Aspis_stripslashes($_REQUEST[0]['user_login']),array(true,false)));
$redirect = concat2(concat1('users.php?usersearch=',Aspis_urlencode($new_user_login)),'&update=add');
wp_redirect(concat(concat2($redirect,'#user-'),$user_id));
Aspis_exit();
}}}$title = __(array('Add New User',false));
$parent_file = array('users.php',false);
wp_enqueue_script(array('wp-ajax-response',false));
wp_enqueue_script(array('user-profile',false));
wp_enqueue_script(array('password-strength-meter',false));
require_once ('admin-header.php');
;
?>
<div class="wrap">
<?php screen_icon();
;
?>
<h2 id="add-new-user"><?php _e(array('Add New User',false));
?></h2>

<?php if ( (((isset($errors) && Aspis_isset( $errors))) && deAspis(is_wp_error($errors))))
 {;
?>
	<div class="error">
		<ul>
		<?php foreach ( deAspis($errors[0]->get_error_messages()) as $err  )
echo AspisCheckPrint(concat2(concat1("<li>",$err),"</li>\n"));
;
?>
		</ul>
	</div>
<?php }if ( (!((empty($messages) || Aspis_empty( $messages)))))
 {foreach ( $messages[0] as $msg  )
echo AspisCheckPrint($msg);
};
?>

<?php if ( (((isset($add_user_errors) && Aspis_isset( $add_user_errors))) && deAspis(is_wp_error($add_user_errors))))
 {;
?>
	<div class="error">
		<?php foreach ( deAspis($add_user_errors[0]->get_error_messages()) as $message  )
echo AspisCheckPrint(concat2(concat1("<p>",$message),"</p>"));
;
?>
	</div>
<?php };
?>
<div id="ajax-response"></div>

<?php if ( deAspis(get_option(array('users_can_register',false))))
 echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Users can <a href="%1$s">register themselves</a> or you can manually create users here.',false)),site_url(array('wp-register.php',false)))),'</p>'));
else 
{echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Users cannot currently <a href="%1$s">register themselves</a>, but you can manually create users here.',false)),admin_url(array('options-general.php#users_can_register',false)))),'</p>'));
};
?>
<form action="#add-new-user" method="post" name="adduser" id="adduser" class="add:users: validate">
<?php wp_nonce_field(array('add-user',false));
?>
<?php foreach ( (array('user_login' => array('login',false,false),'first_name' => array('firstname',false,false),'last_name' => array('lastname',false,false),'email' => array('email',false,false),'url' => array('uri',false,false),'role' => array('role',false,false))) as $post_field =>$var )
{restoreTaint($post_field,$var);
{$var = concat1("new_user_",$var);
if ( (!((isset(${$var[0]}) && Aspis_isset( ${$var[0]})))))
 ${$var[0]} = ((isset($_POST[0][$post_field[0]]) && Aspis_isset( $_POST [0][$post_field[0]]))) ? Aspis_stripslashes(attachAspis($_POST,$post_field[0])) : array('',false);
}}$new_user_send_password = array((denot_boolean($_POST)) || ((isset($_POST[0][('send_password')]) && Aspis_isset( $_POST [0][('send_password')]))),false);
;
?>
<table class="form-table">
	<tr class="form-field form-required">
		<th scope="row"><label for="user_login"><?php _e(array('Username',false));
;
?> <span class="description"><?php _e(array('(required)',false));
;
?></span></label>
		<input name="action" type="hidden" id="action" value="adduser" /></th>
		<td><input name="user_login" type="text" id="user_login" value="<?php echo AspisCheckPrint(esc_attr($new_user_login));
;
?>" aria-required="true" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name"><?php _e(array('First Name',false));
?> </label></th>
		<td><input name="first_name" type="text" id="first_name" value="<?php echo AspisCheckPrint(esc_attr($new_user_firstname));
;
?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="last_name"><?php _e(array('Last Name',false));
?> </label></th>
		<td><input name="last_name" type="text" id="last_name" value="<?php echo AspisCheckPrint(esc_attr($new_user_lastname));
;
?>" /></td>
	</tr>
	<tr class="form-field form-required">
		<th scope="row"><label for="email"><?php _e(array('E-mail',false));
;
?> <span class="description"><?php _e(array('(required)',false));
;
?></span></label></th>
		<td><input name="email" type="text" id="email" value="<?php echo AspisCheckPrint(esc_attr($new_user_email));
;
?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="url"><?php _e(array('Website',false));
?></label></th>
		<td><input name="url" type="text" id="url" class="code" value="<?php echo AspisCheckPrint(esc_attr($new_user_uri));
;
?>" /></td>
	</tr>

<?php if ( deAspis(apply_filters(array('show_password_fields',false),array(true,false))))
 {;
?>
	<tr class="form-field form-required">
		<th scope="row"><label for="pass1"><?php _e(array('Password',false));
;
?> <span class="description"><?php _e(array('(twice, required)',false));
;
?></span></label></th>
		<td><input name="pass1" type="password" id="pass1" autocomplete="off" />
		<br />
		<input name="pass2" type="password" id="pass2" autocomplete="off" />
		<br />
		<div id="pass-strength-result"><?php _e(array('Strength indicator',false));
;
?></div>
		<p class="description indicator-hint"><?php _e(array('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).',false));
;
?></p>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="send_password"><?php _e(array('Send Password?',false));
?></label></th>
		<td><label for="send_password"><input type="checkbox" name="send_password" id="send_password" <?php checked($new_user_send_password,array(true,false));
;
?> /> <?php _e(array('Send this password to the new user by email.',false));
;
?></label></td>
	</tr>
<?php };
?>

	<tr class="form-field">
		<th scope="row"><label for="role"><?php _e(array('Role',false));
;
?></label></th>
		<td><select name="role" id="role">
			<?php if ( (denot_boolean($new_user_role)))
 $new_user_role = (!((empty($current_role) || Aspis_empty( $current_role)))) ? $current_role : get_option(array('default_role',false));
wp_dropdown_roles($new_user_role);
;
?>
			</select>
		</td>
	</tr>
</table>
<p class="submit">
	<input name="adduser" type="submit" id="addusersub" class="button-primary" value="<?php esc_attr_e(array('Add User',false));
?>" />
</p>
</form>

</div>
<?php include ('admin-footer.php');
;
?>
<?php 