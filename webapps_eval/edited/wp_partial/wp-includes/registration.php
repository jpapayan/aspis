<?php require_once('AspisMain.php'); ?><?php
function username_exists ( $username ) {
if ( $user = get_userdatabylogin($username))
 {{$AspisRetTemp = $user->ID;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = null;
return $AspisRetTemp;
}}} }
function email_exists ( $email ) {
if ( $user = get_user_by_email($email))
 {$AspisRetTemp = $user->ID;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function validate_username ( $username ) {
$sanitized = sanitize_user($username,true);
$valid = ($sanitized == $username);
{$AspisRetTemp = apply_filters('validate_username',$valid,$username);
return $AspisRetTemp;
} }
function wp_insert_user ( $userdata ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}extract(($userdata),EXTR_SKIP);
if ( !empty($ID))
 {$ID = (int)$ID;
$update = true;
$old_user_data = get_userdata($ID);
}else 
{{$update = false;
$user_pass = wp_hash_password($user_pass);
}}$user_login = sanitize_user($user_login,true);
$user_login = apply_filters('pre_user_login',$user_login);
if ( empty($user_nicename))
 $user_nicename = sanitize_title($user_login);
$user_nicename = apply_filters('pre_user_nicename',$user_nicename);
if ( empty($user_url))
 $user_url = '';
$user_url = apply_filters('pre_user_url',$user_url);
if ( empty($user_email))
 $user_email = '';
$user_email = apply_filters('pre_user_email',$user_email);
if ( empty($display_name))
 $display_name = $user_login;
$display_name = apply_filters('pre_user_display_name',$display_name);
if ( empty($nickname))
 $nickname = $user_login;
$nickname = apply_filters('pre_user_nickname',$nickname);
if ( empty($first_name))
 $first_name = '';
$first_name = apply_filters('pre_user_first_name',$first_name);
if ( empty($last_name))
 $last_name = '';
$last_name = apply_filters('pre_user_last_name',$last_name);
if ( empty($description))
 $description = '';
$description = apply_filters('pre_user_description',$description);
if ( empty($rich_editing))
 $rich_editing = 'true';
if ( empty($comment_shortcuts))
 $comment_shortcuts = 'false';
if ( empty($admin_color))
 $admin_color = 'fresh';
$admin_color = preg_replace('|[^a-z0-9 _.\-@]|i','',$admin_color);
if ( empty($use_ssl))
 $use_ssl = 0;
if ( empty($user_registered))
 $user_registered = gmdate('Y-m-d H:i:s');
$user_nicename_check = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_nicename = %s AND user_login != %s LIMIT 1",$user_nicename,$user_login));
if ( $user_nicename_check)
 {$suffix = 2;
while ( $user_nicename_check )
{$alt_user_nicename = $user_nicename . "-$suffix";
$user_nicename_check = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_nicename = %s AND user_login != %s LIMIT 1",$alt_user_nicename,$user_login));
$suffix++;
}$user_nicename = $alt_user_nicename;
}$data = compact('user_pass','user_email','user_url','user_nicename','display_name','user_registered');
$data = stripslashes_deep($data);
if ( $update)
 {$wpdb->update($wpdb->users,$data,compact('ID'));
$user_id = (int)$ID;
}else 
{{$wpdb->insert($wpdb->users,$data + compact('user_login'));
$user_id = (int)$wpdb->insert_id;
}}update_usermeta($user_id,'first_name',$first_name);
update_usermeta($user_id,'last_name',$last_name);
update_usermeta($user_id,'nickname',$nickname);
update_usermeta($user_id,'description',$description);
update_usermeta($user_id,'rich_editing',$rich_editing);
update_usermeta($user_id,'comment_shortcuts',$comment_shortcuts);
update_usermeta($user_id,'admin_color',$admin_color);
update_usermeta($user_id,'use_ssl',$use_ssl);
foreach ( _wp_get_user_contactmethods() as $method =>$name )
{if ( empty($$method))
 $$method = '';
update_usermeta($user_id,$method,$$method);
}if ( isset($role))
 {$user = new WP_User($user_id);
$user->set_role($role);
}elseif ( !$update)
 {$user = new WP_User($user_id);
$user->set_role(get_option('default_role'));
}wp_cache_delete($user_id,'users');
wp_cache_delete($user_login,'userlogins');
if ( $update)
 do_action('profile_update',$user_id,$old_user_data);
else 
{do_action('user_register',$user_id);
}{$AspisRetTemp = $user_id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_update_user ( $userdata ) {
$ID = (int)$userdata['ID'];
$user = get_userdata($ID);
$user = deAspisWarningRC(add_magic_quotes(attAspisRCO(get_object_vars($user))));
if ( !empty($userdata['user_pass']))
 {$plaintext_pass = $userdata['user_pass'];
$userdata['user_pass'] = wp_hash_password($userdata['user_pass']);
}$userdata = array_merge($user,$userdata);
$user_id = wp_insert_user($userdata);
$current_user = wp_get_current_user();
if ( $current_user->id == $ID)
 {if ( isset($plaintext_pass))
 {wp_clear_auth_cookie();
wp_set_auth_cookie($ID);
}}{$AspisRetTemp = $user_id;
return $AspisRetTemp;
} }
function wp_create_user ( $username,$password,$email = '' ) {
$user_login = deAspisWarningRC(esc_sql(attAspisRCO($username)));
$user_email = deAspisWarningRC(esc_sql(attAspisRCO($email)));
$user_pass = $password;
$userdata = compact('user_login','user_email','user_pass');
{$AspisRetTemp = wp_insert_user($userdata);
return $AspisRetTemp;
} }
function _wp_get_user_contactmethods (  ) {
$user_contactmethods = array('aim' => __('AIM'),'yim' => __('Yahoo IM'),'jabber' => __('Jabber / Google Talk'));
{$AspisRetTemp = apply_filters('user_contactmethods',$user_contactmethods);
return $AspisRetTemp;
} }
;
?>
<?php 