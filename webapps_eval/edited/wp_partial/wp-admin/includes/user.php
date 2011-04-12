<?php require_once('AspisMain.php'); ?><?php
function add_user (  ) {
if ( func_num_args())
 {{global $current_user,$wp_roles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $current_user,"\$current_user",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_roles,"\$wp_roles",$AspisChangesCache);
}$user_id = (int)func_get_arg(0);
if ( (isset($_POST[0]['role']) && Aspis_isset($_POST[0]['role'])))
 {$new_role = sanitize_text_field(deAspisWarningRC($_POST[0]['role']));
if ( $user_id != $current_user->id || $wp_roles->role_objects[$new_role]->has_cap('edit_users'))
 {$editable_roles = get_editable_roles();
if ( !$editable_roles[$new_role])
 wp_die(__('You can&#8217;t give users that role.'));
$user = new WP_User($user_id);
$user->set_role($new_role);
}}}else 
{{add_action('user_register','add_user');
{$AspisRetTemp = edit_user();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_roles",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_roles",$AspisChangesCache);
 }
function edit_user ( $user_id = 0 ) {
{global $current_user,$wp_roles,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $current_user,"\$current_user",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_roles,"\$wp_roles",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( $user_id != 0)
 {$update = true;
$user->ID = (int)$user_id;
$userdata = get_userdata($user_id);
$user->user_login = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($userdata->user_login)),array(0));
}else 
{{$update = false;
$user = '';
}}if ( !$update && (isset($_POST[0]['user_login']) && Aspis_isset($_POST[0]['user_login'])))
 $user->user_login = sanitize_user(deAspisWarningRC($_POST[0]['user_login']),true);
$pass1 = $pass2 = '';
if ( (isset($_POST[0]['pass1']) && Aspis_isset($_POST[0]['pass1'])))
 $pass1 = deAspisWarningRC($_POST[0]['pass1']);
if ( (isset($_POST[0]['pass2']) && Aspis_isset($_POST[0]['pass2'])))
 $pass2 = deAspisWarningRC($_POST[0]['pass2']);
if ( (isset($_POST[0]['role']) && Aspis_isset($_POST[0]['role'])) && current_user_can('edit_users'))
 {$new_role = sanitize_text_field(deAspisWarningRC($_POST[0]['role']));
if ( $user_id != $current_user->id || $wp_roles->role_objects[$new_role]->has_cap('edit_users'))
 $user->role = $new_role;
$editable_roles = get_editable_roles();
if ( !$editable_roles[$new_role])
 wp_die(__('You can&#8217;t give users that role.'));
}if ( (isset($_POST[0]['email']) && Aspis_isset($_POST[0]['email'])))
 $user->user_email = sanitize_text_field(deAspisWarningRC($_POST[0]['email']));
if ( (isset($_POST[0]['url']) && Aspis_isset($_POST[0]['url'])))
 {if ( (empty($_POST[0]['url']) || Aspis_empty($_POST[0]['url'])) || deAspisWarningRC($_POST[0]['url']) == 'http://')
 {$user->user_url = '';
}else 
{{$user->user_url = sanitize_url(deAspisWarningRC($_POST[0]['url']));
$user->user_url = preg_match('/^(https?|ftps?|mailto|news|irc|gopher|nntp|feed|telnet):/is',$user->user_url) ? $user->user_url : 'http://' . $user->user_url;
}}}if ( (isset($_POST[0]['first_name']) && Aspis_isset($_POST[0]['first_name'])))
 $user->first_name = sanitize_text_field(deAspisWarningRC($_POST[0]['first_name']));
if ( (isset($_POST[0]['last_name']) && Aspis_isset($_POST[0]['last_name'])))
 $user->last_name = sanitize_text_field(deAspisWarningRC($_POST[0]['last_name']));
if ( (isset($_POST[0]['nickname']) && Aspis_isset($_POST[0]['nickname'])))
 $user->nickname = sanitize_text_field(deAspisWarningRC($_POST[0]['nickname']));
if ( (isset($_POST[0]['display_name']) && Aspis_isset($_POST[0]['display_name'])))
 $user->display_name = sanitize_text_field(deAspisWarningRC($_POST[0]['display_name']));
if ( (isset($_POST[0]['description']) && Aspis_isset($_POST[0]['description'])))
 $user->description = trim(deAspisWarningRC($_POST[0]['description']));
foreach ( _wp_get_user_contactmethods() as $method =>$name )
{if ( (isset($_POST[0][$method]) && Aspis_isset($_POST[0][$method])))
 $user->$method = sanitize_text_field(deAspisWarningRC($_POST[0][$method]));
}if ( $update)
 {$user->rich_editing = (isset($_POST[0]['rich_editing']) && Aspis_isset($_POST[0]['rich_editing'])) && 'false' == deAspisWarningRC($_POST[0]['rich_editing']) ? 'false' : 'true';
$user->admin_color = (isset($_POST[0]['admin_color']) && Aspis_isset($_POST[0]['admin_color'])) ? sanitize_text_field(deAspisWarningRC($_POST[0]['admin_color'])) : 'fresh';
}$user->comment_shortcuts = (isset($_POST[0]['comment_shortcuts']) && Aspis_isset($_POST[0]['comment_shortcuts'])) && 'true' == deAspisWarningRC($_POST[0]['comment_shortcuts']) ? 'true' : '';
$user->use_ssl = 0;
if ( !(empty($_POST[0]['use_ssl']) || Aspis_empty($_POST[0]['use_ssl'])))
 $user->use_ssl = 1;
$errors = new WP_Error();
if ( $user->user_login == '')
 $errors->add('user_login',__('<strong>ERROR</strong>: Please enter a username.'));
do_action_ref_array('check_passwords',array($user->user_login,$pass1,$pass2));
if ( $update)
 {if ( empty($pass1) && !empty($pass2))
 $errors->add('pass',__('<strong>ERROR</strong>: You entered your new password only once.'),array('form-field' => 'pass1'));
elseif ( !empty($pass1) && empty($pass2))
 $errors->add('pass',__('<strong>ERROR</strong>: You entered your new password only once.'),array('form-field' => 'pass2'));
}else 
{{if ( empty($pass1))
 $errors->add('pass',__('<strong>ERROR</strong>: Please enter your password.'),array('form-field' => 'pass1'));
elseif ( empty($pass2))
 $errors->add('pass',__('<strong>ERROR</strong>: Please enter your password twice.'),array('form-field' => 'pass2'));
}}if ( false !== strpos(stripslashes($pass1),"\\"))
 $errors->add('pass',__('<strong>ERROR</strong>: Passwords may not contain the character "\\".'),array('form-field' => 'pass1'));
if ( $pass1 != $pass2)
 $errors->add('pass',__('<strong>ERROR</strong>: Please enter the same password in the two password fields.'),array('form-field' => 'pass1'));
if ( !empty($pass1))
 $user->user_pass = $pass1;
if ( !$update && !validate_username($user->user_login))
 $errors->add('user_login',__('<strong>ERROR</strong>: This username is invalid. Please enter a valid username.'));
if ( !$update && username_exists($user->user_login))
 $errors->add('user_login',__('<strong>ERROR</strong>: This username is already registered. Please choose another one.'));
if ( empty($user->user_email))
 {$errors->add('empty_email',__('<strong>ERROR</strong>: Please enter an e-mail address.'),array('form-field' => 'email'));
}elseif ( !is_email($user->user_email))
 {$errors->add('invalid_email',__('<strong>ERROR</strong>: The e-mail address isn&#8217;t correct.'),array('form-field' => 'email'));
}elseif ( ($owner_id = email_exists($user->user_email)) && $owner_id != $user->ID)
 {$errors->add('email_exists',__('<strong>ERROR</strong>: This email is already registered, please choose another one.'),array('form-field' => 'email'));
}do_action_ref_array('user_profile_update_errors',array($errors,$update,$user));
if ( $errors->get_error_codes())
 {$AspisRetTemp = $errors;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_roles",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( $update)
 {$user_id = wp_update_user(get_object_vars($user));
}else 
{{$user_id = wp_insert_user(get_object_vars($user));
wp_new_user_notification($user_id,(isset($_POST[0]['send_password']) && Aspis_isset($_POST[0]['send_password'])) ? $pass1 : '');
}}{$AspisRetTemp = $user_id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_roles",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_roles",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpdb",$AspisChangesCache);
 }
function get_author_user_ids (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$level_key = $wpdb->prefix . 'user_level';
{$AspisRetTemp = $wpdb->get_col($wpdb->prepare("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = %s AND meta_value != '0'",$level_key));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_editable_authors ( $user_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$editable = get_editable_user_ids($user_id);
if ( !$editable)
 {{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{$editable = join(',',$editable);
$authors = $wpdb->get_results("SELECT * FROM $wpdb->users WHERE ID IN ($editable) ORDER BY display_name");
}}{$AspisRetTemp = apply_filters('get_editable_authors',$authors);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_editable_user_ids ( $user_id,$exclude_zeros = true,$post_type = 'post' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$user = new WP_User($user_id);
if ( !$user->has_cap("edit_others_{$post_type}s"))
 {if ( $user->has_cap("edit_{$post_type}s") || $exclude_zeros == false)
 {$AspisRetTemp = array($user->id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = array();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}$level_key = $wpdb->prefix . 'user_level';
$query = $wpdb->prepare("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = %s",$level_key);
if ( $exclude_zeros)
 $query .= " AND meta_value != '0'";
{$AspisRetTemp = $wpdb->get_col($query);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_editable_roles (  ) {
{global $wp_roles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_roles,"\$wp_roles",$AspisChangesCache);
}$all_roles = $wp_roles->roles;
$editable_roles = apply_filters('editable_roles',$all_roles);
{$AspisRetTemp = $editable_roles;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
 }
function get_nonauthor_user_ids (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$level_key = $wpdb->prefix . 'user_level';
{$AspisRetTemp = $wpdb->get_col($wpdb->prepare("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = %s AND meta_value = '0'",$level_key));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_others_unpublished_posts ( $user_id,$type = 'any' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$editable = get_editable_user_ids($user_id);
if ( in_array($type,array('draft','pending')))
 $type_sql = " post_status = '$type' ";
else 
{$type_sql = " ( post_status = 'draft' OR post_status = 'pending' ) ";
}$dir = ('pending' == $type) ? 'ASC' : 'DESC';
if ( !$editable)
 {$other_unpubs = '';
}else 
{{$editable = join(',',$editable);
$other_unpubs = $wpdb->get_results($wpdb->prepare("SELECT ID, post_title, post_author FROM $wpdb->posts WHERE post_type = 'post' AND $type_sql AND post_author IN ($editable) AND post_author != %d ORDER BY post_modified $dir",$user_id));
}}{$AspisRetTemp = apply_filters('get_others_drafts',$other_unpubs);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_others_drafts ( $user_id ) {
{$AspisRetTemp = get_others_unpublished_posts($user_id,'draft');
return $AspisRetTemp;
} }
function get_others_pending ( $user_id ) {
{$AspisRetTemp = get_others_unpublished_posts($user_id,'pending');
return $AspisRetTemp;
} }
function get_user_to_edit ( $user_id ) {
$user = new WP_User($user_id);
$user_contactmethods = _wp_get_user_contactmethods();
foreach ( $user_contactmethods as $method =>$name )
{if ( empty($user->{$method}))
 $user->{$method} = '';
}if ( empty($user->description))
 $user->description = '';
$user = sanitize_user_object($user,'edit');
{$AspisRetTemp = $user;
return $AspisRetTemp;
} }
function get_users_drafts ( $user_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$query = $wpdb->prepare("SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'draft' AND post_author = %d ORDER BY post_modified DESC",$user_id);
$query = apply_filters('get_users_drafts',$query);
{$AspisRetTemp = $wpdb->get_results($query);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_delete_user ( $id,$reassign = 'novalue' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$id = (int)$id;
$user = new WP_User($id);
do_action('delete_user',$id);
if ( $reassign == 'novalue')
 {$post_ids = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_author = %d",$id));
if ( $post_ids)
 {foreach ( $post_ids as $post_id  )
wp_delete_post($post_id);
}$link_ids = $wpdb->get_col($wpdb->prepare("SELECT link_id FROM $wpdb->links WHERE link_owner = %d",$id));
if ( $link_ids)
 {foreach ( $link_ids as $link_id  )
wp_delete_link($link_id);
}}else 
{{$reassign = (int)$reassign;
$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET post_author = %d WHERE post_author = %d",$reassign,$id));
$wpdb->query($wpdb->prepare("UPDATE $wpdb->links SET link_owner = %d WHERE link_owner = %d",$reassign,$id));
}}$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->usermeta WHERE user_id = %d",$id));
$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->users WHERE ID = %d",$id));
wp_cache_delete($id,'users');
wp_cache_delete($user->user_login,'userlogins');
wp_cache_delete($user->user_email,'useremail');
wp_cache_delete($user->user_nicename,'userslugs');
do_action('deleted_user',$id);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_revoke_user ( $id ) {
$id = (int)$id;
$user = new WP_User($id);
$user->remove_all_caps();
 }
if ( !class_exists('WP_User_Search'))
 {class WP_User_Search{var $results;
var $search_term;
var $page;
var $role;
var $raw_page;
var $users_per_page = 50;
var $first_user;
var $last_user;
var $query_limit;
var $query_sort;
var $query_from_where;
var $total_users_for_query = 0;
var $too_many_total_users = false;
var $search_errors;
var $paging_text;
function WP_User_Search ( $search_term = '',$page = '',$role = '' ) {
{$this->search_term = $search_term;
$this->raw_page = ('' == $page) ? false : (int)$page;
$this->page = (int)('' == $page) ? 1 : $page;
$this->role = $role;
$this->prepare_query();
$this->query();
$this->prepare_vars_for_template_usage();
$this->do_paging();
} }
function prepare_query (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$this->first_user = ($this->page - 1) * $this->users_per_page;
$this->query_limit = $wpdb->prepare(" LIMIT %d, %d",$this->first_user,$this->users_per_page);
$this->query_sort = ' ORDER BY user_login';
$search_sql = '';
if ( $this->search_term)
 {$searches = array();
$search_sql = 'AND (';
foreach ( array('user_login','user_nicename','user_email','user_url','display_name') as $col  )
$searches[] = $col . " LIKE '%$this->search_term%'";
$search_sql .= implode(' OR ',$searches);
$search_sql .= ')';
}$this->query_from_where = "FROM $wpdb->users";
if ( $this->role)
 $this->query_from_where .= $wpdb->prepare(" INNER JOIN $wpdb->usermeta ON $wpdb->users.ID = $wpdb->usermeta.user_id WHERE $wpdb->usermeta.meta_key = '{$wpdb->prefix}capabilities' AND $wpdb->usermeta.meta_value LIKE %s",'%' . $this->role . '%');
else 
{$this->query_from_where .= " WHERE 1=1";
}$this->query_from_where .= " $search_sql";
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function query (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$this->results = $wpdb->get_col('SELECT ID ' . $this->query_from_where . $this->query_sort . $this->query_limit);
if ( $this->results)
 $this->total_users_for_query = $wpdb->get_var('SELECT COUNT(ID) ' . $this->query_from_where);
else 
{$this->search_errors = new WP_Error('no_matching_users_found',__('No matching users were found!'));
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function prepare_vars_for_template_usage (  ) {
{$this->search_term = stripslashes($this->search_term);
} }
function do_paging (  ) {
{if ( $this->total_users_for_query > $this->users_per_page)
 {$args = array();
if ( !empty($this->search_term))
 $args['usersearch'] = urlencode($this->search_term);
if ( !empty($this->role))
 $args['role'] = urlencode($this->role);
$this->paging_text = paginate_links(array('total' => ceil($this->total_users_for_query / $this->users_per_page),'current' => $this->page,'base' => 'users.php?%_%','format' => 'userspage=%#%','add_args' => $args));
if ( $this->paging_text)
 {$this->paging_text = sprintf('<span class="displaying-num">' . __('Displaying %s&#8211;%s of %s') . '</span>%s',number_format_i18n(($this->page - 1) * $this->users_per_page + 1),number_format_i18n(min($this->page * $this->users_per_page,$this->total_users_for_query)),number_format_i18n($this->total_users_for_query),$this->paging_text);
}}} }
function get_results (  ) {
{{$AspisRetTemp = (array)$this->results;
return $AspisRetTemp;
}} }
function page_links (  ) {
{echo $this->paging_text;
} }
function results_are_paged (  ) {
{if ( $this->paging_text)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function is_search (  ) {
{if ( $this->search_term)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
}}add_action('admin_init','default_password_nag_handler');
function default_password_nag_handler ( $errors = false ) {
{global $user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $user_ID,"\$user_ID",$AspisChangesCache);
}if ( !get_usermeta($user_ID,'default_password_nag'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return ;
}if ( 'hide' == get_user_setting('default_password_nag') || (isset($_GET[0]['default_password_nag']) && Aspis_isset($_GET[0]['default_password_nag'])) && '0' == deAspisWarningRC($_GET[0]['default_password_nag']))
 {delete_user_setting('default_password_nag');
update_usermeta($user_ID,'default_password_nag',false);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
 }
add_action('profile_update','default_password_nag_edit_user',10,2);
function default_password_nag_edit_user ( $user_ID,$old_data ) {
{global $user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $user_ID,"\$user_ID",$AspisChangesCache);
}if ( !get_usermeta($user_ID,'default_password_nag'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return ;
}$new_data = get_userdata($user_ID);
if ( $new_data->user_pass != $old_data->user_pass)
 {delete_user_setting('default_password_nag');
update_usermeta($user_ID,'default_password_nag',false);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
 }
add_action('admin_notices','default_password_nag');
function default_password_nag (  ) {
{global $user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $user_ID,"\$user_ID",$AspisChangesCache);
}if ( !get_usermeta($user_ID,'default_password_nag'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return ;
}echo '<div class="error default-password-nag"><p>';
printf(__("Notice: you're using the auto-generated password for your account. Would you like to change it to something you'll remember easier?<br />
			  <a href='%s'>Yes, Take me to my profile page</a> | <a href='%s' id='default-password-nag-no'>No Thanks, Do not remind me again.</a>"),admin_url('profile.php') . '#password','?default_password_nag=0');
echo '</p></div>';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
 }
;
?>
<?php 