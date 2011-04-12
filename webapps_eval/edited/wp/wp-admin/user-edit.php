<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (!(defined(('IS_PROFILE_PAGE')))))
 define(('IS_PROFILE_PAGE'),false);
wp_enqueue_script(array('user-profile',false));
wp_enqueue_script(array('password-strength-meter',false));
$title = IS_PROFILE_PAGE ? __(array('Profile',false)) : __(array('Edit User',false));
if ( (deAspis(current_user_can(array('edit_users',false))) && (!(IS_PROFILE_PAGE))))
 $submenu_file = array('users.php',false);
else 
{$submenu_file = array('profile.php',false);
}$parent_file = array('users.php',false);
wp_reset_vars(array(array(array('action',false),array('redirect',false),array('profile',false),array('user_id',false),array('wp_http_referer',false)),false));
$wp_http_referer = remove_query_arg(array(array(array('update',false),array('delete_count',false)),false),Aspis_stripslashes($wp_http_referer));
$user_id = int_cast($user_id);
if ( (denot_boolean($user_id)))
 {if ( IS_PROFILE_PAGE)
 {$current_user = wp_get_current_user();
$user_id = $current_user[0]->ID;
}else 
{{wp_die(__(array('Invalid user ID.',false)));
}}}elseif ( (denot_boolean(get_userdata($user_id))))
 {wp_die(__(array('Invalid user ID.',false)));
}$all_post_caps = array(array(array('posts',false),array('pages',false)),false);
$user_can_edit = array(false,false);
foreach ( $all_post_caps[0] as $post_cap  )
$user_can_edit = array($user_can_edit[0] | deAspis(current_user_can(concat1("edit_",$post_cap))),false);
function use_ssl_preference ( $user ) {
;
?>
	<tr>
		<th scope="row"><?php _e(array('Use https',false));
?></th>
		<td><label for="use_ssl"><input name="use_ssl" type="checkbox" id="use_ssl" value="1" <?php checked(array('1',false),$user[0]->use_ssl);
;
?> /> <?php _e(array('Always use https when visiting the admin',false));
;
?></label></td>
	</tr>
<?php  }
switch ( $action[0] ) {
case ('switchposts'):check_admin_referer();
break ;
case ('update'):check_admin_referer(concat1('update-user_',$user_id));
if ( (denot_boolean(current_user_can(array('edit_user',false),$user_id))))
 wp_die(__(array('You do not have permission to edit this user.',false)));
if ( IS_PROFILE_PAGE)
 do_action(array('personal_options_update',false),$user_id);
else 
{do_action(array('edit_user_profile_update',false),$user_id);
}$errors = edit_user($user_id);
if ( (denot_boolean(is_wp_error($errors))))
 {$redirect = concat2((IS_PROFILE_PAGE ? array("profile.php?",false) : concat2(concat1("user-edit.php?user_id=",$user_id),"&")),"updated=true");
$redirect = add_query_arg(array('wp_http_referer',false),Aspis_urlencode($wp_http_referer),$redirect);
wp_redirect($redirect);
Aspis_exit();
}default :$profileuser = get_user_to_edit($user_id);
if ( (denot_boolean(current_user_can(array('edit_user',false),$user_id))))
 wp_die(__(array('You do not have permission to edit this user.',false)));
include ('admin-header.php');
;
?>

<?php if ( ((isset($_GET[0][('updated')]) && Aspis_isset( $_GET [0][('updated')]))))
 {;
?>
<div id="message" class="updated fade">
	<p><strong><?php _e(array('User updated.',false));
?></strong></p>
	<?php if ( ($wp_http_referer[0] && (!(IS_PROFILE_PAGE))))
 {;
?>
	<p><a href="users.php"><?php _e(array('&larr; Back to Authors and Users',false));
;
?></a></p>
	<?php };
?>
</div>
<?php };
?>
<?php if ( (((isset($errors) && Aspis_isset( $errors))) && deAspis(is_wp_error($errors))))
 {;
?>
<div class="error">
	<ul>
	<?php foreach ( deAspis($errors[0]->get_error_messages()) as $message  )
echo AspisCheckPrint(concat2(concat1("<li>",$message),"</li>"));
;
?>
	</ul>
</div>
<?php };
?>

<div class="wrap" id="profile-page">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<form id="your-profile" action="<?php if ( IS_PROFILE_PAGE)
 {echo AspisCheckPrint(admin_url(array('profile.php',false)));
}else 
{{echo AspisCheckPrint(admin_url(array('user-edit.php',false)));
}};
?>" method="post">
<?php wp_nonce_field(concat1('update-user_',$user_id));
?>
<?php if ( $wp_http_referer[0])
 {;
?>
	<input type="hidden" name="wp_http_referer" value="<?php echo AspisCheckPrint(esc_url($wp_http_referer));
;
?>" />
<?php };
?>
<p>
<input type="hidden" name="from" value="profile" />
<input type="hidden" name="checkuser_id" value="<?php echo AspisCheckPrint($user_ID);
?>" />
</p>

<h3><?php _e(array('Personal Options',false));
;
?></h3>

<table class="form-table">
<?php if ( (deAspis(rich_edit_exists()) && (!(IS_PROFILE_PAGE && (denot_boolean($user_can_edit))))))
 {;
?>
	<tr>
		<th scope="row"><?php _e(array('Visual Editor',false));
?></th>
		<td><label for="rich_editing"><input name="rich_editing" type="checkbox" id="rich_editing" value="false" <?php checked(array('false',false),$profileuser[0]->rich_editing);
;
?> /> <?php _e(array('Disable the visual editor when writing',false));
;
?></label></td>
	</tr>
<?php };
?>
<?php if ( (count($_wp_admin_css_colors[0]) > (1)))
 {;
?>
<tr>
<th scope="row"><?php _e(array('Admin Color Scheme',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Admin Color Scheme',false));
?></span></legend>
<?php $current_color = get_user_option(array('admin_color',false),$user_id);
if ( ((empty($current_color) || Aspis_empty( $current_color))))
 $current_color = array('fresh',false);
foreach ( $_wp_admin_css_colors[0] as $color =>$color_info )
{restoreTaint($color,$color_info);
{;
?>
<div class="color-option"><input name="admin_color" id="admin_color_<?php echo AspisCheckPrint($color);
;
?>" type="radio" value="<?php echo AspisCheckPrint(esc_attr($color));
?>" class="tog" <?php checked($color,$current_color);
;
?> />
	<table class="color-palette">
	<tr>
	<?php foreach ( $color_info[0]->colors[0] as $html_color  )
{;
?>
	<td style="background-color: <?php echo AspisCheckPrint($html_color);
?>" title="<?php echo AspisCheckPrint($color);
?>">&nbsp;</td>
	<?php };
?>
	</tr>
	</table>

	<label for="admin_color_<?php echo AspisCheckPrint($color);
;
?>"><?php echo AspisCheckPrint($color_info[0]->name);
?></label>
</div>
	<?php }};
?>
</fieldset></td>
</tr>
<?php if ( (!(IS_PROFILE_PAGE && (denot_boolean($user_can_edit)))))
 {;
?>
<tr>
<th scope="row"><?php _e(array('Keyboard Shortcuts',false));
;
?></th>
<td><label for="comment_shortcuts"><input type="checkbox" name="comment_shortcuts" id="comment_shortcuts" value="true" <?php if ( (!((empty($profileuser[0]->comment_shortcuts) || Aspis_empty( $profileuser[0] ->comment_shortcuts )))))
 checked(array('true',false),$profileuser[0]->comment_shortcuts);
;
?> /> <?php _e(array('Enable keyboard shortcuts for comment moderation.',false));
;
?></label> <?php _e(array('<a href="http://codex.wordpress.org/Keyboard_Shortcuts">More information</a>',false));
;
?></td>
</tr>
<?php }}do_action(array('personal_options',false),$profileuser);
;
?>
</table>
<?php if ( IS_PROFILE_PAGE)
 do_action(array('profile_personal_options',false),$profileuser);
;
?>

<h3><?php _e(array('Name',false));
?></h3>

<table class="form-table">
	<tr>
		<th><label for="user_login"><?php _e(array('Username',false));
;
?></label></th>
		<td><input type="text" name="user_login" id="user_login" value="<?php echo AspisCheckPrint(esc_attr($profileuser[0]->user_login));
;
?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e(array('Your username cannot be changed.',false));
;
?></span></td>
	</tr>

<?php if ( (!(IS_PROFILE_PAGE)))
 {;
?>
<tr><th><label for="role"><?php _e(array('Role:',false));
?></label></th>
<td><select name="role" id="role">
<?php $user_roles = $profileuser[0]->roles;
$user_role = Aspis_array_shift($user_roles);
wp_dropdown_roles($user_role);
if ( $user_role[0])
 echo AspisCheckPrint(concat2(concat1('<option value="">',__(array('&mdash; No role for this blog &mdash;',false))),'</option>'));
else 
{echo AspisCheckPrint(concat2(concat1('<option value="" selected="selected">',__(array('&mdash; No role for this blog &mdash;',false))),'</option>'));
};
?>
</select></td></tr>
<?php };
?>

<tr>
	<th><label for="first_name"><?php _e(array('First name',false));
?></label></th>
	<td><input type="text" name="first_name" id="first_name" value="<?php echo AspisCheckPrint(esc_attr($profileuser[0]->first_name));
?>" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="last_name"><?php _e(array('Last name',false));
?></label></th>
	<td><input type="text" name="last_name" id="last_name" value="<?php echo AspisCheckPrint(esc_attr($profileuser[0]->last_name));
?>" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="nickname"><?php _e(array('Nickname',false));
;
?> <span class="description"><?php _e(array('(required)',false));
;
?></span></label></th>
	<td><input type="text" name="nickname" id="nickname" value="<?php echo AspisCheckPrint(esc_attr($profileuser[0]->nickname));
?>" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="display_name"><?php _e(array('Display name publicly as',false));
?></label></th>
	<td>
		<select name="display_name" id="display_name">
		<?php $public_display = array(array(),false);
arrayAssign($public_display[0],deAspis(registerTaint(array('display_nickname',false))),addTaint($profileuser[0]->nickname));
arrayAssign($public_display[0],deAspis(registerTaint(array('display_username',false))),addTaint($profileuser[0]->user_login));
if ( (!((empty($profileuser[0]->first_name) || Aspis_empty( $profileuser[0] ->first_name )))))
 arrayAssign($public_display[0],deAspis(registerTaint(array('display_firstname',false))),addTaint($profileuser[0]->first_name));
if ( (!((empty($profileuser[0]->last_name) || Aspis_empty( $profileuser[0] ->last_name )))))
 arrayAssign($public_display[0],deAspis(registerTaint(array('display_lastname',false))),addTaint($profileuser[0]->last_name));
if ( ((!((empty($profileuser[0]->first_name) || Aspis_empty( $profileuser[0] ->first_name )))) && (!((empty($profileuser[0]->last_name) || Aspis_empty( $profileuser[0] ->last_name ))))))
 {arrayAssign($public_display[0],deAspis(registerTaint(array('display_firstlast',false))),addTaint(concat(concat2($profileuser[0]->first_name,' '),$profileuser[0]->last_name)));
arrayAssign($public_display[0],deAspis(registerTaint(array('display_lastfirst',false))),addTaint(concat(concat2($profileuser[0]->last_name,' '),$profileuser[0]->first_name)));
}if ( (denot_boolean(Aspis_in_array($profileuser[0]->display_name,$public_display))))
 $public_display = array((array(deregisterTaint(array('display_displayname',false)) => addTaint($profileuser[0]->display_name))) + $public_display[0],false);
$public_display = attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC($public_display)));
foreach ( $public_display[0] as $id =>$item )
{restoreTaint($id,$item);
{;
?>
			<option id="<?php echo AspisCheckPrint($id);
;
?>" value="<?php echo AspisCheckPrint(esc_attr($item));
;
?>"<?php selected($profileuser[0]->display_name,$item);
;
?>><?php echo AspisCheckPrint($item);
;
?></option>
		<?php }};
?>
		</select>
	</td>
</tr>
</table>

<h3><?php _e(array('Contact Info',false));
?></h3>

<table class="form-table">
<tr>
	<th><label for="email"><?php _e(array('E-mail',false));
;
?> <span class="description"><?php _e(array('(required)',false));
;
?></span></label></th>
	<td><input type="text" name="email" id="email" value="<?php echo AspisCheckPrint(esc_attr($profileuser[0]->user_email));
?>" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="url"><?php _e(array('Website',false));
?></label></th>
	<td><input type="text" name="url" id="url" value="<?php echo AspisCheckPrint(esc_attr($profileuser[0]->user_url));
?>" class="regular-text code" /></td>
</tr>

<?php foreach ( deAspis(_wp_get_user_contactmethods()) as $name =>$desc )
{restoreTaint($name,$desc);
{;
?>
<tr>
	<th><label for="<?php echo AspisCheckPrint($name);
;
?>"><?php echo AspisCheckPrint(apply_filters(concat2(concat1('user_',$name),'_label'),$desc));
;
?></label></th>
	<td><input type="text" name="<?php echo AspisCheckPrint($name);
;
?>" id="<?php echo AspisCheckPrint($name);
;
?>" value="<?php echo AspisCheckPrint(esc_attr($profileuser[0]->$name[0]));
?>" class="regular-text" /></td>
</tr>
<?php }};
?>
</table>

<h3><?php IS_PROFILE_PAGE ? _e(array('About Yourself',false)) : _e(array('About the user',false));
;
?></h3>

<table class="form-table">
<tr>
	<th><label for="description"><?php _e(array('Biographical Info',false));
;
?></label></th>
	<td><textarea name="description" id="description" rows="5" cols="30"><?php echo AspisCheckPrint(esc_html($profileuser[0]->description));
;
?></textarea><br />
	<span class="description"><?php _e(array('Share a little biographical information to fill out your profile. This may be shown publicly.',false));
;
?></span></td>
</tr>

<?php $show_password_fields = apply_filters(array('show_password_fields',false),array(true,false),$profileuser);
if ( $show_password_fields[0])
 {;
?>
<tr id="password">
	<th><label for="pass1"><?php _e(array('New Password',false));
;
?></label></th>
	<td><input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" /> <span class="description"><?php _e(array("If you would like to change the password type a new one. Otherwise leave this blank.",false));
;
?></span><br />
		<input type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off" /> <span class="description"><?php _e(array("Type your new password again.",false));
;
?></span><br />
		<div id="pass-strength-result"><?php _e(array('Strength indicator',false));
;
?></div>
		<p class="description indicator-hint"><?php _e(array('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).',false));
;
?></p>
	</td>
</tr>
<?php };
?>
</table>

<?php if ( IS_PROFILE_PAGE)
 {do_action(array('show_user_profile',false),$profileuser);
}else 
{{do_action(array('edit_user_profile',false),$profileuser);
}};
?>

<?php if ( ((count($profileuser[0]->caps[0]) > count($profileuser[0]->roles[0])) && deAspis(apply_filters(array('additional_capabilities_display',false),array(true,false),$profileuser))))
 {;
?>
<br class="clear" />
	<table width="99%" style="border: none;" cellspacing="2" cellpadding="3" class="editform">
		<tr>
			<th scope="row"><?php _e(array('Additional Capabilities',false));
?></th>
			<td><?php $output = array('',false);
foreach ( $profileuser[0]->caps[0] as $cap =>$value )
{restoreTaint($cap,$value);
{if ( (denot_boolean($wp_roles[0]->is_role($cap))))
 {if ( ($output[0] != ('')))
 $output = concat2($output,', ');
$output = concat($output,$value[0] ? $cap : concat1("Denied: ",$cap));
}}}echo AspisCheckPrint($output);
;
?></td>
		</tr>
	</table>
<?php };
?>

<p class="submit">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="user_id" id="user_id" value="<?php echo AspisCheckPrint(esc_attr($user_id));
;
?>" />
	<input type="submit" class="button-primary" value="<?php IS_PROFILE_PAGE ? esc_attr_e(array('Update Profile',false)) : esc_attr_e(array('Update User',false));
?>" name="submit" />
</p>
</form>
</div>
<?php break ;
 }
include ('admin-footer.php');
;
?>
<?php 