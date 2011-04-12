<?php require_once('AspisMain.php'); ?><?php
function username_exists ( $username ) {
if ( deAspis($user = get_userdatabylogin($username)))
 {return $user[0]->ID;
}else 
{{return array(null,false);
}} }
function email_exists ( $email ) {
if ( deAspis($user = get_user_by_email($email)))
 return $user[0]->ID;
return array(false,false);
 }
function validate_username ( $username ) {
$sanitized = sanitize_user($username,array(true,false));
$valid = (array($sanitized[0] == $username[0],false));
return apply_filters(array('validate_username',false),$valid,$username);
 }
function wp_insert_user ( $userdata ) {
global $wpdb;
extract(($userdata[0]),EXTR_SKIP);
if ( (!((empty($ID) || Aspis_empty( $ID)))))
 {$ID = int_cast($ID);
$update = array(true,false);
$old_user_data = get_userdata($ID);
}else 
{{$update = array(false,false);
$user_pass = wp_hash_password($user_pass);
}}$user_login = sanitize_user($user_login,array(true,false));
$user_login = apply_filters(array('pre_user_login',false),$user_login);
if ( ((empty($user_nicename) || Aspis_empty( $user_nicename))))
 $user_nicename = sanitize_title($user_login);
$user_nicename = apply_filters(array('pre_user_nicename',false),$user_nicename);
if ( ((empty($user_url) || Aspis_empty( $user_url))))
 $user_url = array('',false);
$user_url = apply_filters(array('pre_user_url',false),$user_url);
if ( ((empty($user_email) || Aspis_empty( $user_email))))
 $user_email = array('',false);
$user_email = apply_filters(array('pre_user_email',false),$user_email);
if ( ((empty($display_name) || Aspis_empty( $display_name))))
 $display_name = $user_login;
$display_name = apply_filters(array('pre_user_display_name',false),$display_name);
if ( ((empty($nickname) || Aspis_empty( $nickname))))
 $nickname = $user_login;
$nickname = apply_filters(array('pre_user_nickname',false),$nickname);
if ( ((empty($first_name) || Aspis_empty( $first_name))))
 $first_name = array('',false);
$first_name = apply_filters(array('pre_user_first_name',false),$first_name);
if ( ((empty($last_name) || Aspis_empty( $last_name))))
 $last_name = array('',false);
$last_name = apply_filters(array('pre_user_last_name',false),$last_name);
if ( ((empty($description) || Aspis_empty( $description))))
 $description = array('',false);
$description = apply_filters(array('pre_user_description',false),$description);
if ( ((empty($rich_editing) || Aspis_empty( $rich_editing))))
 $rich_editing = array('true',false);
if ( ((empty($comment_shortcuts) || Aspis_empty( $comment_shortcuts))))
 $comment_shortcuts = array('false',false);
if ( ((empty($admin_color) || Aspis_empty( $admin_color))))
 $admin_color = array('fresh',false);
$admin_color = Aspis_preg_replace(array('|[^a-z0-9 _.\-@]|i',false),array('',false),$admin_color);
if ( ((empty($use_ssl) || Aspis_empty( $use_ssl))))
 $use_ssl = array(0,false);
if ( ((empty($user_registered) || Aspis_empty( $user_registered))))
 $user_registered = attAspis(gmdate(('Y-m-d H:i:s')));
$user_nicename_check = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->users)," WHERE user_nicename = %s AND user_login != %s LIMIT 1"),$user_nicename,$user_login));
if ( $user_nicename_check[0])
 {$suffix = array(2,false);
while ( $user_nicename_check[0] )
{$alt_user_nicename = concat($user_nicename,concat1("-",$suffix));
$user_nicename_check = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->users)," WHERE user_nicename = %s AND user_login != %s LIMIT 1"),$alt_user_nicename,$user_login));
postincr($suffix);
}$user_nicename = $alt_user_nicename;
}$data = array(compact('user_pass','user_email','user_url','user_nicename','display_name','user_registered'),false);
$data = stripslashes_deep($data);
if ( $update[0])
 {$wpdb[0]->update($wpdb[0]->users,$data,array(compact('ID'),false));
$user_id = int_cast($ID);
}else 
{{$wpdb[0]->insert($wpdb[0]->users,array($data[0] + (compact('user_login')),false));
$user_id = int_cast($wpdb[0]->insert_id);
}}update_usermeta($user_id,array('first_name',false),$first_name);
update_usermeta($user_id,array('last_name',false),$last_name);
update_usermeta($user_id,array('nickname',false),$nickname);
update_usermeta($user_id,array('description',false),$description);
update_usermeta($user_id,array('rich_editing',false),$rich_editing);
update_usermeta($user_id,array('comment_shortcuts',false),$comment_shortcuts);
update_usermeta($user_id,array('admin_color',false),$admin_color);
update_usermeta($user_id,array('use_ssl',false),$use_ssl);
foreach ( deAspis(_wp_get_user_contactmethods()) as $method =>$name )
{restoreTaint($method,$name);
{if ( ((empty(${$method[0]}) || Aspis_empty( ${$method[0]}))))
 ${$method[0]} = array('',false);
update_usermeta($user_id,$method,${$method[0]});
}}if ( ((isset($role) && Aspis_isset( $role))))
 {$user = array(new WP_User($user_id),false);
$user[0]->set_role($role);
}elseif ( (denot_boolean($update)))
 {$user = array(new WP_User($user_id),false);
$user[0]->set_role(get_option(array('default_role',false)));
}wp_cache_delete($user_id,array('users',false));
wp_cache_delete($user_login,array('userlogins',false));
if ( $update[0])
 do_action(array('profile_update',false),$user_id,$old_user_data);
else 
{do_action(array('user_register',false),$user_id);
}return $user_id;
 }
function wp_update_user ( $userdata ) {
$ID = int_cast($userdata[0]['ID']);
$user = get_userdata($ID);
$user = add_magic_quotes(attAspis(get_object_vars(deAspisRC($user))));
if ( (!((empty($userdata[0][('user_pass')]) || Aspis_empty( $userdata [0][('user_pass')])))))
 {$plaintext_pass = $userdata[0]['user_pass'];
arrayAssign($userdata[0],deAspis(registerTaint(array('user_pass',false))),addTaint(wp_hash_password($userdata[0]['user_pass'])));
}$userdata = Aspis_array_merge($user,$userdata);
$user_id = wp_insert_user($userdata);
$current_user = wp_get_current_user();
if ( ($current_user[0]->id[0] == $ID[0]))
 {if ( ((isset($plaintext_pass) && Aspis_isset( $plaintext_pass))))
 {wp_clear_auth_cookie();
wp_set_auth_cookie($ID);
}}return $user_id;
 }
function wp_create_user ( $username,$password,$email = array('',false) ) {
$user_login = esc_sql($username);
$user_email = esc_sql($email);
$user_pass = $password;
$userdata = array(compact('user_login','user_email','user_pass'),false);
return wp_insert_user($userdata);
 }
function _wp_get_user_contactmethods (  ) {
$user_contactmethods = array(array(deregisterTaint(array('aim',false)) => addTaint(__(array('AIM',false))),deregisterTaint(array('yim',false)) => addTaint(__(array('Yahoo IM',false))),deregisterTaint(array('jabber',false)) => addTaint(__(array('Jabber / Google Talk',false)))),false);
return apply_filters(array('user_contactmethods',false),$user_contactmethods);
 }
;
?>
<?php 