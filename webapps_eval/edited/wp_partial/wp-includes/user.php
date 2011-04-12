<?php require_once('AspisMain.php'); ?><?php
function wp_signon ( $credentials = '',$secure_cookie = '' ) {
if ( empty($credentials))
 {if ( !(empty($_POST[0]['log']) || Aspis_empty($_POST[0]['log'])))
 $credentials['user_login'] = deAspisWarningRC($_POST[0]['log']);
if ( !(empty($_POST[0]['pwd']) || Aspis_empty($_POST[0]['pwd'])))
 $credentials['user_password'] = deAspisWarningRC($_POST[0]['pwd']);
if ( !(empty($_POST[0]['rememberme']) || Aspis_empty($_POST[0]['rememberme'])))
 $credentials['remember'] = deAspisWarningRC($_POST[0]['rememberme']);
}if ( !empty($credentials['remember']))
 $credentials['remember'] = true;
else 
{$credentials['remember'] = false;
}do_action_ref_array('wp_authenticate',array($credentials['user_login'],$credentials['user_password']));
if ( '' === $secure_cookie)
 $secure_cookie = is_ssl() ? true : false;
{global $auth_secure_cookie;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $auth_secure_cookie,"\$auth_secure_cookie",$AspisChangesCache);
}$auth_secure_cookie = $secure_cookie;
add_filter('authenticate','wp_authenticate_cookie',30,3);
$user = wp_authenticate($credentials['user_login'],$credentials['user_password']);
if ( is_wp_error($user))
 {if ( $user->get_error_codes() == array('empty_username','empty_password'))
 {$user = new WP_Error('','');
}{$AspisRetTemp = $user;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$auth_secure_cookie",$AspisChangesCache);
return $AspisRetTemp;
}}wp_set_auth_cookie($user->ID,$credentials['remember'],$secure_cookie);
do_action('wp_login',$credentials['user_login']);
{$AspisRetTemp = $user;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$auth_secure_cookie",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$auth_secure_cookie",$AspisChangesCache);
 }
add_filter('authenticate','wp_authenticate_username_password',20,3);
function wp_authenticate_username_password ( $user,$username,$password ) {
if ( is_a($user,'WP_User'))
 {{$AspisRetTemp = $user;
return $AspisRetTemp;
}}if ( empty($username) || empty($password))
 {$error = new WP_Error();
if ( empty($username))
 $error->add('empty_username',__('<strong>ERROR</strong>: The username field is empty.'));
if ( empty($password))
 $error->add('empty_password',__('<strong>ERROR</strong>: The password field is empty.'));
{$AspisRetTemp = $error;
return $AspisRetTemp;
}}$userdata = get_userdatabylogin($username);
if ( !$userdata)
 {{$AspisRetTemp = new WP_Error('invalid_username',sprintf(__('<strong>ERROR</strong>: Invalid username. <a href="%s" title="Password Lost and Found">Lost your password</a>?'),site_url('wp-login.php?action=lostpassword','login')));
return $AspisRetTemp;
}}$userdata = apply_filters('wp_authenticate_user',$userdata,$password);
if ( is_wp_error($userdata))
 {{$AspisRetTemp = $userdata;
return $AspisRetTemp;
}}if ( !wp_check_password($password,$userdata->user_pass,$userdata->ID))
 {{$AspisRetTemp = new WP_Error('incorrect_password',sprintf(__('<strong>ERROR</strong>: Incorrect password. <a href="%s" title="Password Lost and Found">Lost your password</a>?'),site_url('wp-login.php?action=lostpassword','login')));
return $AspisRetTemp;
}}$user = new WP_User($userdata->ID);
{$AspisRetTemp = $user;
return $AspisRetTemp;
} }
function wp_authenticate_cookie ( $user,$username,$password ) {
if ( is_a($user,'WP_User'))
 {{$AspisRetTemp = $user;
return $AspisRetTemp;
}}if ( empty($username) && empty($password))
 {$user_id = wp_validate_auth_cookie();
if ( $user_id)
 {$AspisRetTemp = new WP_User($user_id);
return $AspisRetTemp;
}{global $auth_secure_cookie;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $auth_secure_cookie,"\$auth_secure_cookie",$AspisChangesCache);
}if ( $auth_secure_cookie)
 $auth_cookie = SECURE_AUTH_COOKIE;
else 
{$auth_cookie = AUTH_COOKIE;
}if ( !(empty($_COOKIE[0][$auth_cookie]) || Aspis_empty($_COOKIE[0][$auth_cookie])))
 {$AspisRetTemp = new WP_Error('expired_session',__('Please log in again.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$auth_secure_cookie",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = $user;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$auth_secure_cookie",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$auth_secure_cookie",$AspisChangesCache);
 }
function get_profile ( $field,$user = false ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !$user)
 $user = deAspisWarningRC(esc_sql(attAspisRCO(deAspisWarningRC($_COOKIE[0][USER_COOKIE]))));
{$AspisRetTemp = $wpdb->get_var($wpdb->prepare("SELECT $field FROM $wpdb->users WHERE user_login = %s",$user));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_usernumposts ( $userid ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$userid = (int)$userid;
$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = %d AND post_type = 'post' AND ",$userid) . get_private_posts_cap_sql('post'));
{$AspisRetTemp = apply_filters('get_usernumposts',$count,$userid);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function user_pass_ok ( $user_login,$user_pass ) {
$user = wp_authenticate($user_login,$user_pass);
if ( is_wp_error($user))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = true;
return $AspisRetTemp;
} }
function get_user_option ( $option,$user = 0,$check_blog_options = true ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$option = preg_replace('|[^a-z0-9_]|i','',$option);
if ( empty($user))
 $user = wp_get_current_user();
else 
{$user = get_userdata($user);
}if ( isset($user->{$wpdb->prefix . $option}))
 $result = $user->{$wpdb->prefix . $option};
elseif ( isset($user->{$option}))
 $result = $user->{$option};
elseif ( $check_blog_options)
 $result = get_option($option);
else 
{$result = false;
}{$AspisRetTemp = apply_filters("get_user_option_{$option}",$result,$option,$user);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function update_user_option ( $user_id,$option_name,$newvalue,$global = false ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !$global)
 $option_name = $wpdb->prefix . $option_name;
{$AspisRetTemp = update_usermeta($user_id,$option_name,$newvalue);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_users_of_blog ( $id = '' ) {
{global $wpdb,$blog_id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($blog_id,"\$blog_id",$AspisChangesCache);
}if ( empty($id))
 $id = (int)$blog_id;
$users = $wpdb->get_results("SELECT user_id, user_id AS ID, user_login, display_name, user_email, meta_value FROM $wpdb->users, $wpdb->usermeta WHERE {$wpdb->users}.ID = {$wpdb->usermeta}.user_id AND meta_key = '{$wpdb->prefix}capabilities' ORDER BY {$wpdb->usermeta}.user_id");
{$AspisRetTemp = $users;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$blog_id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$blog_id",$AspisChangesCache);
 }
function delete_usermeta ( $user_id,$meta_key,$meta_value = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !is_numeric($user_id))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$meta_key = preg_replace('|[^a-z0-9_]|i','',$meta_key);
if ( is_array($meta_value) || is_object($meta_value))
 $meta_value = serialize($meta_value);
$meta_value = trim($meta_value);
$cur = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->usermeta WHERE user_id = %d AND meta_key = %s",$user_id,$meta_key));
if ( $cur && $cur->umeta_id)
 do_action('delete_usermeta',$cur->umeta_id,$user_id,$meta_key,$meta_value);
if ( !empty($meta_value))
 $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->usermeta WHERE user_id = %d AND meta_key = %s AND meta_value = %s",$user_id,$meta_key,$meta_value));
else 
{$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->usermeta WHERE user_id = %d AND meta_key = %s",$user_id,$meta_key));
}wp_cache_delete($user_id,'users');
if ( $cur && $cur->umeta_id)
 do_action('deleted_usermeta',$cur->umeta_id,$user_id,$meta_key,$meta_value);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_usermeta ( $user_id,$meta_key = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$user_id = (int)$user_id;
if ( !$user_id)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( !empty($meta_key))
 {$meta_key = preg_replace('|[^a-z0-9_]|i','',$meta_key);
$user = wp_cache_get($user_id,'users');
if ( false !== $user && isset($user->$meta_key))
 $metas = array($user->$meta_key);
else 
{$metas = $wpdb->get_col($wpdb->prepare("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = %d AND meta_key = %s",$user_id,$meta_key));
}}else 
{{$metas = $wpdb->get_col($wpdb->prepare("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = %d",$user_id));
}}if ( empty($metas))
 {if ( empty($meta_key))
 {$AspisRetTemp = array();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = '';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}$metas = array_map('maybe_unserialize',$metas);
if ( count($metas) == 1)
 {$AspisRetTemp = $metas[0];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = $metas;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function update_usermeta ( $user_id,$meta_key,$meta_value ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !is_numeric($user_id))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$meta_key = preg_replace('|[^a-z0-9_]|i','',$meta_key);
if ( is_string($meta_value))
 $meta_value = stripslashes($meta_value);
$meta_value = maybe_serialize($meta_value);
if ( empty($meta_value))
 {{$AspisRetTemp = delete_usermeta($user_id,$meta_key);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}$cur = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->usermeta WHERE user_id = %d AND meta_key = %s",$user_id,$meta_key));
if ( $cur)
 do_action('update_usermeta',$cur->umeta_id,$user_id,$meta_key,$meta_value);
if ( !$cur)
 $wpdb->insert($wpdb->usermeta,compact('user_id','meta_key','meta_value'));
else 
{if ( $cur->meta_value != $meta_value)
 $wpdb->update($wpdb->usermeta,compact('meta_value'),compact('user_id','meta_key'));
else 
{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}wp_cache_delete($user_id,'users');
if ( !$cur)
 do_action('added_usermeta',$wpdb->insert_id,$user_id,$meta_key,$meta_value);
else 
{do_action('updated_usermeta',$cur->umeta_id,$user_id,$meta_key,$meta_value);
}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function setup_userdata ( $for_user_id = '' ) {
{global $user_login,$userdata,$user_level,$user_ID,$user_email,$user_url,$user_pass_md5,$user_identity;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $user_login,"\$user_login",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($userdata,"\$userdata",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($user_level,"\$user_level",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($user_ID,"\$user_ID",$AspisChangesCache);
$AspisVar4 = &AspisCleanTaintedGlobalUntainted($user_email,"\$user_email",$AspisChangesCache);
$AspisVar5 = &AspisCleanTaintedGlobalUntainted($user_url,"\$user_url",$AspisChangesCache);
$AspisVar6 = &AspisCleanTaintedGlobalUntainted($user_pass_md5,"\$user_pass_md5",$AspisChangesCache);
$AspisVar7 = &AspisCleanTaintedGlobalUntainted($user_identity,"\$user_identity",$AspisChangesCache);
}if ( '' == $for_user_id)
 $user = wp_get_current_user();
else 
{$user = new WP_User($for_user_id);
}if ( 0 == $user->ID)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_login",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$userdata",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_level",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$user_ID",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$user_email",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$user_url",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$user_pass_md5",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$user_identity",$AspisChangesCache);
return ;
}$userdata = $user->data;
$user_login = $user->user_login;
$user_level = (int)isset($user->user_level) ? $user->user_level : 0;
$user_ID = (int)$user->ID;
$user_email = $user->user_email;
$user_url = $user->user_url;
$user_pass_md5 = md5($user->user_pass);
$user_identity = $user->display_name;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_login",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$userdata",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_level",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$user_ID",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$user_email",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$user_url",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$user_pass_md5",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$user_identity",$AspisChangesCache);
 }
function wp_dropdown_users ( $args = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$defaults = array('show_option_all' => '','show_option_none' => '','orderby' => 'display_name','order' => 'ASC','include' => '','exclude' => '','multi' => 0,'show' => 'display_name','echo' => 1,'selected' => 0,'name' => 'user','class' => '');
$defaults['selected'] = is_author() ? get_query_var('author') : 0;
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
$query = "SELECT * FROM $wpdb->users";
$query_where = array();
if ( is_array($include))
 $include = join(',',$include);
$include = preg_replace('/[^0-9,]/','',$include);
if ( $include)
 $query_where[] = "ID IN ($include)";
if ( is_array($exclude))
 $exclude = join(',',$exclude);
$exclude = preg_replace('/[^0-9,]/','',$exclude);
if ( $exclude)
 $query_where[] = "ID NOT IN ($exclude)";
if ( $query_where)
 $query .= " WHERE " . join(' AND',$query_where);
$query .= " ORDER BY $orderby $order";
$users = $wpdb->get_results($query);
$output = '';
if ( !empty($users))
 {$id = $multi ? "" : "id='$name'";
$output = "<select name='$name' $id class='$class'>\n";
if ( $show_option_all)
 $output .= "\t<option value='0'>$show_option_all</option>\n";
if ( $show_option_none)
 $output .= "\t<option value='-1'>$show_option_none</option>\n";
foreach ( (array)$users as $user  )
{$user->ID = (int)$user->ID;
$_selected = $user->ID == $selected ? " selected='selected'" : '';
$display = !empty($user->$show) ? $user->$show : '(' . $user->user_login . ')';
$output .= "\t<option value='$user->ID'$_selected>" . esc_html($display) . "</option>\n";
}$output .= "</select>";
}$output = apply_filters('wp_dropdown_users',$output);
if ( $echo)
 echo $output;
{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function _fill_user ( &$user ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$show = $wpdb->hide_errors();
$metavalues = $wpdb->get_results($wpdb->prepare("SELECT meta_key, meta_value FROM $wpdb->usermeta WHERE user_id = %d",$user->ID));
$wpdb->show_errors($show);
if ( $metavalues)
 {foreach ( (array)$metavalues as $meta  )
{$value = maybe_unserialize($meta->meta_value);
$user->{$meta->meta_key} = $value;
}}$level = $wpdb->prefix . 'user_level';
if ( isset($user->{$level}))
 $user->user_level = $user->{$level};
if ( isset($user->first_name))
 $user->user_firstname = $user->first_name;
if ( isset($user->last_name))
 $user->user_lastname = $user->last_name;
if ( isset($user->description))
 $user->user_description = $user->description;
wp_cache_add($user->ID,$user,'users');
wp_cache_add($user->user_login,$user->ID,'userlogins');
wp_cache_add($user->user_email,$user->ID,'useremail');
wp_cache_add($user->user_nicename,$user->ID,'userslugs');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function sanitize_user_object ( $user,$context = 'display' ) {
if ( is_object($user))
 {if ( !isset($user->ID))
 $user->ID = 0;
if ( isset($user->data))
 $vars = get_object_vars($user->data);
else 
{$vars = get_object_vars($user);
}foreach ( array_keys($vars) as $field  )
{if ( is_string($user->$field) || is_numeric($user->$field))
 $user->$field = sanitize_user_field($field,$user->$field,$user->ID,$context);
}$user->filter = $context;
}else 
{{if ( !isset($user['ID']))
 $user['ID'] = 0;
foreach ( array_keys($user) as $field  )
$user[$field] = sanitize_user_field($field,$user[$field],$user['ID'],$context);
$user['filter'] = $context;
}}{$AspisRetTemp = $user;
return $AspisRetTemp;
} }
function sanitize_user_field ( $field,$value,$user_id,$context ) {
$int_fields = array('ID');
if ( in_array($field,$int_fields))
 $value = (int)$value;
if ( 'raw' == $context)
 {$AspisRetTemp = $value;
return $AspisRetTemp;
}if ( !is_string($value) && !is_numeric($value))
 {$AspisRetTemp = $value;
return $AspisRetTemp;
}$prefixed = false;
if ( false !== strpos($field,'user_'))
 {$prefixed = true;
$field_no_prefix = str_replace('user_','',$field);
}if ( 'edit' == $context)
 {if ( $prefixed)
 {$value = apply_filters("edit_$field",$value,$user_id);
}else 
{{$value = apply_filters("edit_user_$field",$value,$user_id);
}}if ( 'description' == $field)
 $value = esc_html($value);
else 
{$value = esc_attr($value);
}}else 
{if ( 'db' == $context)
 {if ( $prefixed)
 {$value = apply_filters("pre_$field",$value);
}else 
{{$value = apply_filters("pre_user_$field",$value);
}}}else 
{{if ( $prefixed)
 $value = apply_filters($field,$value,$user_id,$context);
else 
{$value = apply_filters("user_$field",$value,$user_id,$context);
}}}}if ( 'user_url' == $field)
 $value = esc_url($value);
if ( 'attribute' == $context)
 $value = esc_attr($value);
else 
{if ( 'js' == $context)
 $value = esc_js($value);
}{$AspisRetTemp = $value;
return $AspisRetTemp;
} }
;
?>
<?php 