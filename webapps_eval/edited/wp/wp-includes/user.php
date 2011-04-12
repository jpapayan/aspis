<?php require_once('AspisMain.php'); ?><?php
function wp_signon ( $credentials = array('',false),$secure_cookie = array('',false) ) {
if ( ((empty($credentials) || Aspis_empty( $credentials))))
 {if ( (!((empty($_POST[0][('log')]) || Aspis_empty( $_POST [0][('log')])))))
 arrayAssign($credentials[0],deAspis(registerTaint(array('user_login',false))),addTaint($_POST[0]['log']));
if ( (!((empty($_POST[0][('pwd')]) || Aspis_empty( $_POST [0][('pwd')])))))
 arrayAssign($credentials[0],deAspis(registerTaint(array('user_password',false))),addTaint($_POST[0]['pwd']));
if ( (!((empty($_POST[0][('rememberme')]) || Aspis_empty( $_POST [0][('rememberme')])))))
 arrayAssign($credentials[0],deAspis(registerTaint(array('remember',false))),addTaint($_POST[0]['rememberme']));
}if ( (!((empty($credentials[0][('remember')]) || Aspis_empty( $credentials [0][('remember')])))))
 arrayAssign($credentials[0],deAspis(registerTaint(array('remember',false))),addTaint(array(true,false)));
else 
{arrayAssign($credentials[0],deAspis(registerTaint(array('remember',false))),addTaint(array(false,false)));
}do_action_ref_array(array('wp_authenticate',false),array(array(&$credentials[0][('user_login')],&$credentials[0][('user_password')]),false));
if ( (('') === $secure_cookie[0]))
 $secure_cookie = deAspis(is_ssl()) ? array(true,false) : array(false,false);
global $auth_secure_cookie;
$auth_secure_cookie = $secure_cookie;
add_filter(array('authenticate',false),array('wp_authenticate_cookie',false),array(30,false),array(3,false));
$user = wp_authenticate($credentials[0]['user_login'],$credentials[0]['user_password']);
if ( deAspis(is_wp_error($user)))
 {if ( (deAspis($user[0]->get_error_codes()) == (array(array('empty_username',false),array('empty_password',false)))))
 {$user = array(new WP_Error(array('',false),array('',false)),false);
}return $user;
}wp_set_auth_cookie($user[0]->ID,$credentials[0]['remember'],$secure_cookie);
do_action(array('wp_login',false),$credentials[0]['user_login']);
return $user;
 }
add_filter(array('authenticate',false),array('wp_authenticate_username_password',false),array(20,false),array(3,false));
function wp_authenticate_username_password ( $user,$username,$password ) {
if ( is_a(deAspisRC($user),('WP_User')))
 {return $user;
}if ( (((empty($username) || Aspis_empty( $username))) || ((empty($password) || Aspis_empty( $password)))))
 {$error = array(new WP_Error(),false);
if ( ((empty($username) || Aspis_empty( $username))))
 $error[0]->add(array('empty_username',false),__(array('<strong>ERROR</strong>: The username field is empty.',false)));
if ( ((empty($password) || Aspis_empty( $password))))
 $error[0]->add(array('empty_password',false),__(array('<strong>ERROR</strong>: The password field is empty.',false)));
return $error;
}$userdata = get_userdatabylogin($username);
if ( (denot_boolean($userdata)))
 {return array(new WP_Error(array('invalid_username',false),Aspis_sprintf(__(array('<strong>ERROR</strong>: Invalid username. <a href="%s" title="Password Lost and Found">Lost your password</a>?',false)),site_url(array('wp-login.php?action=lostpassword',false),array('login',false)))),false);
}$userdata = apply_filters(array('wp_authenticate_user',false),$userdata,$password);
if ( deAspis(is_wp_error($userdata)))
 {return $userdata;
}if ( (denot_boolean(wp_check_password($password,$userdata[0]->user_pass,$userdata[0]->ID))))
 {return array(new WP_Error(array('incorrect_password',false),Aspis_sprintf(__(array('<strong>ERROR</strong>: Incorrect password. <a href="%s" title="Password Lost and Found">Lost your password</a>?',false)),site_url(array('wp-login.php?action=lostpassword',false),array('login',false)))),false);
}$user = array(new WP_User($userdata[0]->ID),false);
return $user;
 }
function wp_authenticate_cookie ( $user,$username,$password ) {
if ( is_a(deAspisRC($user),('WP_User')))
 {return $user;
}if ( (((empty($username) || Aspis_empty( $username))) && ((empty($password) || Aspis_empty( $password)))))
 {$user_id = wp_validate_auth_cookie();
if ( $user_id[0])
 return array(new WP_User($user_id),false);
global $auth_secure_cookie;
if ( $auth_secure_cookie[0])
 $auth_cookie = array(SECURE_AUTH_COOKIE,false);
else 
{$auth_cookie = array(AUTH_COOKIE,false);
}if ( (!((empty($_COOKIE[0][$auth_cookie[0]]) || Aspis_empty( $_COOKIE [0][$auth_cookie[0]])))))
 return array(new WP_Error(array('expired_session',false),__(array('Please log in again.',false))),false);
}return $user;
 }
function get_profile ( $field,$user = array(false,false) ) {
global $wpdb;
if ( (denot_boolean($user)))
 $user = esc_sql(attachAspis($_COOKIE,USER_COOKIE));
return $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat(concat2(concat1("SELECT ",$field)," FROM "),$wpdb[0]->users)," WHERE user_login = %s"),$user));
 }
function get_usernumposts ( $userid ) {
global $wpdb;
$userid = int_cast($userid);
$count = $wpdb[0]->get_var(concat($wpdb[0]->prepare(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->posts)," WHERE post_author = %d AND post_type = 'post' AND "),$userid),get_private_posts_cap_sql(array('post',false))));
return apply_filters(array('get_usernumposts',false),$count,$userid);
 }
function user_pass_ok ( $user_login,$user_pass ) {
$user = wp_authenticate($user_login,$user_pass);
if ( deAspis(is_wp_error($user)))
 return array(false,false);
return array(true,false);
 }
function get_user_option ( $option,$user = array(0,false),$check_blog_options = array(true,false) ) {
global $wpdb;
$option = Aspis_preg_replace(array('|[^a-z0-9_]|i',false),array('',false),$option);
if ( ((empty($user) || Aspis_empty( $user))))
 $user = wp_get_current_user();
else 
{$user = get_userdata($user);
}if ( ((isset($user[0]->{(deconcat($wpdb[0]->prefix,$option))}) && Aspis_isset( $user[0] ->{(deconcat($wpdb[0] ->prefix ,$option))} ))))
 $result = $user[0]->{(deconcat($wpdb[0]->prefix,$option))};
elseif ( ((isset($user[0]->{$option[0]}) && Aspis_isset( $user[0] ->{$option[0]} ))))
 $result = $user[0]->{$option[0]};
elseif ( $check_blog_options[0])
 $result = get_option($option);
else 
{$result = array(false,false);
}return apply_filters(concat1("get_user_option_",$option),$result,$option,$user);
 }
function update_user_option ( $user_id,$option_name,$newvalue,$global = array(false,false) ) {
global $wpdb;
if ( (denot_boolean($global)))
 $option_name = concat($wpdb[0]->prefix,$option_name);
return update_usermeta($user_id,$option_name,$newvalue);
 }
function get_users_of_blog ( $id = array('',false) ) {
global $wpdb,$blog_id;
if ( ((empty($id) || Aspis_empty( $id))))
 $id = int_cast($blog_id);
$users = $wpdb[0]->get_results(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT user_id, user_id AS ID, user_login, display_name, user_email, meta_value FROM ",$wpdb[0]->users),", "),$wpdb[0]->usermeta)," WHERE "),$wpdb[0]->users),".ID = "),$wpdb[0]->usermeta),".user_id AND meta_key = '"),$wpdb[0]->prefix),"capabilities' ORDER BY "),$wpdb[0]->usermeta),".user_id"));
return $users;
 }
function delete_usermeta ( $user_id,$meta_key,$meta_value = array('',false) ) {
global $wpdb;
if ( (!(is_numeric(deAspisRC($user_id)))))
 return array(false,false);
$meta_key = Aspis_preg_replace(array('|[^a-z0-9_]|i',false),array('',false),$meta_key);
if ( (is_array($meta_value[0]) || is_object($meta_value[0])))
 $meta_value = Aspis_serialize($meta_value);
$meta_value = Aspis_trim($meta_value);
$cur = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->usermeta)," WHERE user_id = %d AND meta_key = %s"),$user_id,$meta_key));
if ( ($cur[0] && $cur[0]->umeta_id[0]))
 do_action(array('delete_usermeta',false),$cur[0]->umeta_id,$user_id,$meta_key,$meta_value);
if ( (!((empty($meta_value) || Aspis_empty( $meta_value)))))
 $wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->usermeta)," WHERE user_id = %d AND meta_key = %s AND meta_value = %s"),$user_id,$meta_key,$meta_value));
else 
{$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->usermeta)," WHERE user_id = %d AND meta_key = %s"),$user_id,$meta_key));
}wp_cache_delete($user_id,array('users',false));
if ( ($cur[0] && $cur[0]->umeta_id[0]))
 do_action(array('deleted_usermeta',false),$cur[0]->umeta_id,$user_id,$meta_key,$meta_value);
return array(true,false);
 }
function get_usermeta ( $user_id,$meta_key = array('',false) ) {
global $wpdb;
$user_id = int_cast($user_id);
if ( (denot_boolean($user_id)))
 return array(false,false);
if ( (!((empty($meta_key) || Aspis_empty( $meta_key)))))
 {$meta_key = Aspis_preg_replace(array('|[^a-z0-9_]|i',false),array('',false),$meta_key);
$user = wp_cache_get($user_id,array('users',false));
if ( ((false !== $user[0]) && ((isset($user[0]->$meta_key[0]) && Aspis_isset( $user[0] ->$meta_key[0] )))))
 $metas = array(array($user[0]->$meta_key[0]),false);
else 
{$metas = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT meta_value FROM ",$wpdb[0]->usermeta)," WHERE user_id = %d AND meta_key = %s"),$user_id,$meta_key));
}}else 
{{$metas = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT meta_value FROM ",$wpdb[0]->usermeta)," WHERE user_id = %d"),$user_id));
}}if ( ((empty($metas) || Aspis_empty( $metas))))
 {if ( ((empty($meta_key) || Aspis_empty( $meta_key))))
 return array(array(),false);
else 
{return array('',false);
}}$metas = attAspisRC(array_map(AspisInternalCallback(array('maybe_unserialize',false)),deAspisRC($metas)));
if ( (count($metas[0]) == (1)))
 return attachAspis($metas,(0));
else 
{return $metas;
} }
function update_usermeta ( $user_id,$meta_key,$meta_value ) {
global $wpdb;
if ( (!(is_numeric(deAspisRC($user_id)))))
 return array(false,false);
$meta_key = Aspis_preg_replace(array('|[^a-z0-9_]|i',false),array('',false),$meta_key);
if ( is_string(deAspisRC($meta_value)))
 $meta_value = Aspis_stripslashes($meta_value);
$meta_value = maybe_serialize($meta_value);
if ( ((empty($meta_value) || Aspis_empty( $meta_value))))
 {return delete_usermeta($user_id,$meta_key);
}$cur = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->usermeta)," WHERE user_id = %d AND meta_key = %s"),$user_id,$meta_key));
if ( $cur[0])
 do_action(array('update_usermeta',false),$cur[0]->umeta_id,$user_id,$meta_key,$meta_value);
if ( (denot_boolean($cur)))
 $wpdb[0]->insert($wpdb[0]->usermeta,array(compact('user_id','meta_key','meta_value'),false));
else 
{if ( ($cur[0]->meta_value[0] != $meta_value[0]))
 $wpdb[0]->update($wpdb[0]->usermeta,array(compact('meta_value'),false),array(compact('user_id','meta_key'),false));
else 
{return array(false,false);
}}wp_cache_delete($user_id,array('users',false));
if ( (denot_boolean($cur)))
 do_action(array('added_usermeta',false),$wpdb[0]->insert_id,$user_id,$meta_key,$meta_value);
else 
{do_action(array('updated_usermeta',false),$cur[0]->umeta_id,$user_id,$meta_key,$meta_value);
}return array(true,false);
 }
function setup_userdata ( $for_user_id = array('',false) ) {
global $user_login,$userdata,$user_level,$user_ID,$user_email,$user_url,$user_pass_md5,$user_identity;
if ( (('') == $for_user_id[0]))
 $user = wp_get_current_user();
else 
{$user = array(new WP_User($for_user_id),false);
}if ( ((0) == $user[0]->ID[0]))
 return ;
$userdata = $user[0]->data;
$user_login = $user[0]->user_login;
$user_level = deAspis(int_cast(array((isset($user[0]->user_level) && Aspis_isset( $user[0] ->user_level )),false))) ? $user[0]->user_level : array(0,false);
$user_ID = int_cast($user[0]->ID);
$user_email = $user[0]->user_email;
$user_url = $user[0]->user_url;
$user_pass_md5 = attAspis(md5($user[0]->user_pass[0]));
$user_identity = $user[0]->display_name;
 }
function wp_dropdown_users ( $args = array('',false) ) {
global $wpdb;
$defaults = array(array('show_option_all' => array('',false,false),'show_option_none' => array('',false,false),'orderby' => array('display_name',false,false),'order' => array('ASC',false,false),'include' => array('',false,false),'exclude' => array('',false,false),'multi' => array(0,false,false),'show' => array('display_name',false,false),'echo' => array(1,false,false),'selected' => array(0,false,false),'name' => array('user',false,false),'class' => array('',false,false)),false);
arrayAssign($defaults[0],deAspis(registerTaint(array('selected',false))),addTaint(deAspis(is_author()) ? get_query_var(array('author',false)) : array(0,false)));
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
$query = concat1("SELECT * FROM ",$wpdb[0]->users);
$query_where = array(array(),false);
if ( is_array($include[0]))
 $include = Aspis_join(array(',',false),$include);
$include = Aspis_preg_replace(array('/[^0-9,]/',false),array('',false),$include);
if ( $include[0])
 arrayAssignAdd($query_where[0][],addTaint(concat2(concat1("ID IN (",$include),")")));
if ( is_array($exclude[0]))
 $exclude = Aspis_join(array(',',false),$exclude);
$exclude = Aspis_preg_replace(array('/[^0-9,]/',false),array('',false),$exclude);
if ( $exclude[0])
 arrayAssignAdd($query_where[0][],addTaint(concat2(concat1("ID NOT IN (",$exclude),")")));
if ( $query_where[0])
 $query = concat($query,concat1(" WHERE ",Aspis_join(array(' AND',false),$query_where)));
$query = concat($query,concat(concat2(concat1(" ORDER BY ",$orderby)," "),$order));
$users = $wpdb[0]->get_results($query);
$output = array('',false);
if ( (!((empty($users) || Aspis_empty( $users)))))
 {$id = $multi[0] ? array("",false) : concat2(concat1("id='",$name),"'");
$output = concat2(concat(concat2(concat(concat2(concat1("<select name='",$name),"' "),$id)," class='"),$class),"'>\n");
if ( $show_option_all[0])
 $output = concat($output,concat2(concat1("\t<option value='0'>",$show_option_all),"</option>\n"));
if ( $show_option_none[0])
 $output = concat($output,concat2(concat1("\t<option value='-1'>",$show_option_none),"</option>\n"));
foreach ( deAspis(array_cast($users)) as $user  )
{$user[0]->ID = int_cast($user[0]->ID);
$_selected = ($user[0]->ID[0] == $selected[0]) ? array(" selected='selected'",false) : array('',false);
$display = (!((empty($user[0]->$show[0]) || Aspis_empty( $user[0] ->$show[0] )))) ? $user[0]->$show[0] : concat2(concat1('(',$user[0]->user_login),')');
$output = concat($output,concat2(concat(concat2(concat(concat2(concat1("\t<option value='",$user[0]->ID),"'"),$_selected),">"),esc_html($display)),"</option>\n"));
}$output = concat2($output,"</select>");
}$output = apply_filters(array('wp_dropdown_users',false),$output);
if ( $echo[0])
 echo AspisCheckPrint($output);
return $output;
 }
function _fill_user ( &$user ) {
global $wpdb;
$show = $wpdb[0]->hide_errors();
$metavalues = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT meta_key, meta_value FROM ",$wpdb[0]->usermeta)," WHERE user_id = %d"),$user[0]->ID));
$wpdb[0]->show_errors($show);
if ( $metavalues[0])
 {foreach ( deAspis(array_cast($metavalues)) as $meta  )
{$value = maybe_unserialize($meta[0]->meta_value);
$user[0]->{$meta[0]->meta_key[0]} = $value;
}}$level = concat2($wpdb[0]->prefix,'user_level');
if ( ((isset($user[0]->{$level[0]}) && Aspis_isset( $user[0] ->{$level[0]} ))))
 $user[0]->user_level = $user[0]->{$level[0]};
if ( ((isset($user[0]->first_name) && Aspis_isset( $user[0] ->first_name ))))
 $user[0]->user_firstname = $user[0]->first_name;
if ( ((isset($user[0]->last_name) && Aspis_isset( $user[0] ->last_name ))))
 $user[0]->user_lastname = $user[0]->last_name;
if ( ((isset($user[0]->description) && Aspis_isset( $user[0] ->description ))))
 $user[0]->user_description = $user[0]->description;
wp_cache_add($user[0]->ID,$user,array('users',false));
wp_cache_add($user[0]->user_login,$user[0]->ID,array('userlogins',false));
wp_cache_add($user[0]->user_email,$user[0]->ID,array('useremail',false));
wp_cache_add($user[0]->user_nicename,$user[0]->ID,array('userslugs',false));
 }
function sanitize_user_object ( $user,$context = array('display',false) ) {
if ( is_object($user[0]))
 {if ( (!((isset($user[0]->ID) && Aspis_isset( $user[0] ->ID )))))
 $user[0]->ID = array(0,false);
if ( ((isset($user[0]->data) && Aspis_isset( $user[0] ->data ))))
 $vars = attAspis(get_object_vars(deAspisRC($user[0]->data)));
else 
{$vars = attAspis(get_object_vars(deAspisRC($user)));
}foreach ( deAspis(attAspisRC(array_keys(deAspisRC($vars)))) as $field  )
{if ( (is_string(deAspisRC($user[0]->$field[0])) || is_numeric(deAspisRC($user[0]->$field[0]))))
 $user[0]->$field[0] = sanitize_user_field($field,$user[0]->$field[0],$user[0]->ID,$context);
}$user[0]->filter = $context;
}else 
{{if ( (!((isset($user[0][('ID')]) && Aspis_isset( $user [0][('ID')])))))
 arrayAssign($user[0],deAspis(registerTaint(array('ID',false))),addTaint(array(0,false)));
foreach ( deAspis(attAspisRC(array_keys(deAspisRC($user)))) as $field  )
arrayAssign($user[0],deAspis(registerTaint($field)),addTaint(sanitize_user_field($field,attachAspis($user,$field[0]),$user[0]['ID'],$context)));
arrayAssign($user[0],deAspis(registerTaint(array('filter',false))),addTaint($context));
}}return $user;
 }
function sanitize_user_field ( $field,$value,$user_id,$context ) {
$int_fields = array(array(array('ID',false)),false);
if ( deAspis(Aspis_in_array($field,$int_fields)))
 $value = int_cast($value);
if ( (('raw') == $context[0]))
 return $value;
if ( ((!(is_string(deAspisRC($value)))) && (!(is_numeric(deAspisRC($value))))))
 return $value;
$prefixed = array(false,false);
if ( (false !== strpos($field[0],'user_')))
 {$prefixed = array(true,false);
$field_no_prefix = Aspis_str_replace(array('user_',false),array('',false),$field);
}if ( (('edit') == $context[0]))
 {if ( $prefixed[0])
 {$value = apply_filters(concat1("edit_",$field),$value,$user_id);
}else 
{{$value = apply_filters(concat1("edit_user_",$field),$value,$user_id);
}}if ( (('description') == $field[0]))
 $value = esc_html($value);
else 
{$value = esc_attr($value);
}}else 
{if ( (('db') == $context[0]))
 {if ( $prefixed[0])
 {$value = apply_filters(concat1("pre_",$field),$value);
}else 
{{$value = apply_filters(concat1("pre_user_",$field),$value);
}}}else 
{{if ( $prefixed[0])
 $value = apply_filters($field,$value,$user_id,$context);
else 
{$value = apply_filters(concat1("user_",$field),$value,$user_id,$context);
}}}}if ( (('user_url') == $field[0]))
 $value = esc_url($value);
if ( (('attribute') == $context[0]))
 $value = esc_attr($value);
else 
{if ( (('js') == $context[0]))
 $value = esc_js($value);
}return $value;
 }
;
?>
<?php 