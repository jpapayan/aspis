<?php require_once('AspisMain.php'); ?><?php
function add_user (  ) {
if ( func_num_args())
 {global $current_user,$wp_roles;
$user_id = int_cast(func_get_arg((0)));
if ( ((isset($_POST[0][('role')]) && Aspis_isset( $_POST [0][('role')]))))
 {$new_role = sanitize_text_field($_POST[0]['role']);
if ( (($user_id[0] != $current_user[0]->id[0]) || deAspis($wp_roles[0]->role_objects[0][$new_role[0]][0]->has_cap(array('edit_users',false)))))
 {$editable_roles = get_editable_roles();
if ( (denot_boolean(attachAspis($editable_roles,$new_role[0]))))
 wp_die(__(array('You can&#8217;t give users that role.',false)));
$user = array(new WP_User($user_id),false);
$user[0]->set_role($new_role);
}}}else 
{{add_action(array('user_register',false),array('add_user',false));
return edit_user();
}} }
function edit_user ( $user_id = array(0,false) ) {
global $current_user,$wp_roles,$wpdb;
if ( ($user_id[0] != (0)))
 {$update = array(true,false);
$user[0]->ID = int_cast($user_id);
$userdata = get_userdata($user_id);
$user[0]->user_login = $wpdb[0]->escape($userdata[0]->user_login);
}else 
{{$update = array(false,false);
$user = array('',false);
}}if ( ((denot_boolean($update)) && ((isset($_POST[0][('user_login')]) && Aspis_isset( $_POST [0][('user_login')])))))
 $user[0]->user_login = sanitize_user($_POST[0]['user_login'],array(true,false));
$pass1 = $pass2 = array('',false);
if ( ((isset($_POST[0][('pass1')]) && Aspis_isset( $_POST [0][('pass1')]))))
 $pass1 = $_POST[0]['pass1'];
if ( ((isset($_POST[0][('pass2')]) && Aspis_isset( $_POST [0][('pass2')]))))
 $pass2 = $_POST[0]['pass2'];
if ( (((isset($_POST[0][('role')]) && Aspis_isset( $_POST [0][('role')]))) && deAspis(current_user_can(array('edit_users',false)))))
 {$new_role = sanitize_text_field($_POST[0]['role']);
if ( (($user_id[0] != $current_user[0]->id[0]) || deAspis($wp_roles[0]->role_objects[0][$new_role[0]][0]->has_cap(array('edit_users',false)))))
 $user[0]->role = $new_role;
$editable_roles = get_editable_roles();
if ( (denot_boolean(attachAspis($editable_roles,$new_role[0]))))
 wp_die(__(array('You can&#8217;t give users that role.',false)));
}if ( ((isset($_POST[0][('email')]) && Aspis_isset( $_POST [0][('email')]))))
 $user[0]->user_email = sanitize_text_field($_POST[0]['email']);
if ( ((isset($_POST[0][('url')]) && Aspis_isset( $_POST [0][('url')]))))
 {if ( (((empty($_POST[0][('url')]) || Aspis_empty( $_POST [0][('url')]))) || (deAspis($_POST[0]['url']) == ('http://'))))
 {$user[0]->user_url = array('',false);
}else 
{{$user[0]->user_url = sanitize_url($_POST[0]['url']);
$user[0]->user_url = deAspis(Aspis_preg_match(array('/^(https?|ftps?|mailto|news|irc|gopher|nntp|feed|telnet):/is',false),$user[0]->user_url)) ? $user[0]->user_url : concat1('http://',$user[0]->user_url);
}}}if ( ((isset($_POST[0][('first_name')]) && Aspis_isset( $_POST [0][('first_name')]))))
 $user[0]->first_name = sanitize_text_field($_POST[0]['first_name']);
if ( ((isset($_POST[0][('last_name')]) && Aspis_isset( $_POST [0][('last_name')]))))
 $user[0]->last_name = sanitize_text_field($_POST[0]['last_name']);
if ( ((isset($_POST[0][('nickname')]) && Aspis_isset( $_POST [0][('nickname')]))))
 $user[0]->nickname = sanitize_text_field($_POST[0]['nickname']);
if ( ((isset($_POST[0][('display_name')]) && Aspis_isset( $_POST [0][('display_name')]))))
 $user[0]->display_name = sanitize_text_field($_POST[0]['display_name']);
if ( ((isset($_POST[0][('description')]) && Aspis_isset( $_POST [0][('description')]))))
 $user[0]->description = Aspis_trim($_POST[0]['description']);
foreach ( deAspis(_wp_get_user_contactmethods()) as $method =>$name )
{restoreTaint($method,$name);
{if ( ((isset($_POST[0][$method[0]]) && Aspis_isset( $_POST [0][$method[0]]))))
 $user[0]->$method[0] = sanitize_text_field(attachAspis($_POST,$method[0]));
}}if ( $update[0])
 {$user[0]->rich_editing = (((isset($_POST[0][('rich_editing')]) && Aspis_isset( $_POST [0][('rich_editing')]))) && (('false') == deAspis($_POST[0]['rich_editing']))) ? array('false',false) : array('true',false);
$user[0]->admin_color = ((isset($_POST[0][('admin_color')]) && Aspis_isset( $_POST [0][('admin_color')]))) ? sanitize_text_field($_POST[0]['admin_color']) : array('fresh',false);
}$user[0]->comment_shortcuts = (((isset($_POST[0][('comment_shortcuts')]) && Aspis_isset( $_POST [0][('comment_shortcuts')]))) && (('true') == deAspis($_POST[0]['comment_shortcuts']))) ? array('true',false) : array('',false);
$user[0]->use_ssl = array(0,false);
if ( (!((empty($_POST[0][('use_ssl')]) || Aspis_empty( $_POST [0][('use_ssl')])))))
 $user[0]->use_ssl = array(1,false);
$errors = array(new WP_Error(),false);
if ( ($user[0]->user_login[0] == ('')))
 $errors[0]->add(array('user_login',false),__(array('<strong>ERROR</strong>: Please enter a username.',false)));
do_action_ref_array(array('check_passwords',false),array(array($user[0]->user_login,&$pass1,&$pass2),false));
if ( $update[0])
 {if ( (((empty($pass1) || Aspis_empty( $pass1))) && (!((empty($pass2) || Aspis_empty( $pass2))))))
 $errors[0]->add(array('pass',false),__(array('<strong>ERROR</strong>: You entered your new password only once.',false)),array(array('form-field' => array('pass1',false,false)),false));
elseif ( ((!((empty($pass1) || Aspis_empty( $pass1)))) && ((empty($pass2) || Aspis_empty( $pass2)))))
 $errors[0]->add(array('pass',false),__(array('<strong>ERROR</strong>: You entered your new password only once.',false)),array(array('form-field' => array('pass2',false,false)),false));
}else 
{{if ( ((empty($pass1) || Aspis_empty( $pass1))))
 $errors[0]->add(array('pass',false),__(array('<strong>ERROR</strong>: Please enter your password.',false)),array(array('form-field' => array('pass1',false,false)),false));
elseif ( ((empty($pass2) || Aspis_empty( $pass2))))
 $errors[0]->add(array('pass',false),__(array('<strong>ERROR</strong>: Please enter your password twice.',false)),array(array('form-field' => array('pass2',false,false)),false));
}}if ( (false !== strpos(deAspis(Aspis_stripslashes($pass1)),"\\")))
 $errors[0]->add(array('pass',false),__(array('<strong>ERROR</strong>: Passwords may not contain the character "\\".',false)),array(array('form-field' => array('pass1',false,false)),false));
if ( ($pass1[0] != $pass2[0]))
 $errors[0]->add(array('pass',false),__(array('<strong>ERROR</strong>: Please enter the same password in the two password fields.',false)),array(array('form-field' => array('pass1',false,false)),false));
if ( (!((empty($pass1) || Aspis_empty( $pass1)))))
 $user[0]->user_pass = $pass1;
if ( ((denot_boolean($update)) && (denot_boolean(validate_username($user[0]->user_login)))))
 $errors[0]->add(array('user_login',false),__(array('<strong>ERROR</strong>: This username is invalid. Please enter a valid username.',false)));
if ( ((denot_boolean($update)) && deAspis(username_exists($user[0]->user_login))))
 $errors[0]->add(array('user_login',false),__(array('<strong>ERROR</strong>: This username is already registered. Please choose another one.',false)));
if ( ((empty($user[0]->user_email) || Aspis_empty( $user[0] ->user_email ))))
 {$errors[0]->add(array('empty_email',false),__(array('<strong>ERROR</strong>: Please enter an e-mail address.',false)),array(array('form-field' => array('email',false,false)),false));
}elseif ( (denot_boolean(is_email($user[0]->user_email))))
 {$errors[0]->add(array('invalid_email',false),__(array('<strong>ERROR</strong>: The e-mail address isn&#8217;t correct.',false)),array(array('form-field' => array('email',false,false)),false));
}elseif ( (deAspis(($owner_id = email_exists($user[0]->user_email))) && ($owner_id[0] != $user[0]->ID[0])))
 {$errors[0]->add(array('email_exists',false),__(array('<strong>ERROR</strong>: This email is already registered, please choose another one.',false)),array(array('form-field' => array('email',false,false)),false));
}do_action_ref_array(array('user_profile_update_errors',false),array(array(&$errors,$update,&$user),false));
if ( deAspis($errors[0]->get_error_codes()))
 return $errors;
if ( $update[0])
 {$user_id = wp_update_user(attAspis(get_object_vars(deAspisRC($user))));
}else 
{{$user_id = wp_insert_user(attAspis(get_object_vars(deAspisRC($user))));
wp_new_user_notification($user_id,((isset($_POST[0][('send_password')]) && Aspis_isset( $_POST [0][('send_password')]))) ? $pass1 : array('',false));
}}return $user_id;
 }
function get_author_user_ids (  ) {
global $wpdb;
$level_key = concat2($wpdb[0]->prefix,'user_level');
return $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT user_id FROM ",$wpdb[0]->usermeta)," WHERE meta_key = %s AND meta_value != '0'"),$level_key));
 }
function get_editable_authors ( $user_id ) {
global $wpdb;
$editable = get_editable_user_ids($user_id);
if ( (denot_boolean($editable)))
 {return array(false,false);
}else 
{{$editable = Aspis_join(array(',',false),$editable);
$authors = $wpdb[0]->get_results(concat2(concat(concat2(concat1("SELECT * FROM ",$wpdb[0]->users)," WHERE ID IN ("),$editable),") ORDER BY display_name"));
}}return apply_filters(array('get_editable_authors',false),$authors);
 }
function get_editable_user_ids ( $user_id,$exclude_zeros = array(true,false),$post_type = array('post',false) ) {
global $wpdb;
$user = array(new WP_User($user_id),false);
if ( (denot_boolean($user[0]->has_cap(concat2(concat1("edit_others_",$post_type),"s")))))
 {if ( (deAspis($user[0]->has_cap(concat2(concat1("edit_",$post_type),"s"))) || ($exclude_zeros[0] == false)))
 return array(array($user[0]->id),false);
else 
{return array(array(),false);
}}$level_key = concat2($wpdb[0]->prefix,'user_level');
$query = $wpdb[0]->prepare(concat2(concat1("SELECT user_id FROM ",$wpdb[0]->usermeta)," WHERE meta_key = %s"),$level_key);
if ( $exclude_zeros[0])
 $query = concat2($query," AND meta_value != '0'");
return $wpdb[0]->get_col($query);
 }
function get_editable_roles (  ) {
global $wp_roles;
$all_roles = $wp_roles[0]->roles;
$editable_roles = apply_filters(array('editable_roles',false),$all_roles);
return $editable_roles;
 }
function get_nonauthor_user_ids (  ) {
global $wpdb;
$level_key = concat2($wpdb[0]->prefix,'user_level');
return $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT user_id FROM ",$wpdb[0]->usermeta)," WHERE meta_key = %s AND meta_value = '0'"),$level_key));
 }
function get_others_unpublished_posts ( $user_id,$type = array('any',false) ) {
global $wpdb;
$editable = get_editable_user_ids($user_id);
if ( deAspis(Aspis_in_array($type,array(array(array('draft',false),array('pending',false)),false))))
 $type_sql = concat2(concat1(" post_status = '",$type),"' ");
else 
{$type_sql = array(" ( post_status = 'draft' OR post_status = 'pending' ) ",false);
}$dir = (('pending') == $type[0]) ? array('ASC',false) : array('DESC',false);
if ( (denot_boolean($editable)))
 {$other_unpubs = array('',false);
}else 
{{$editable = Aspis_join(array(',',false),$editable);
$other_unpubs = $wpdb[0]->get_results($wpdb[0]->prepare(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT ID, post_title, post_author FROM ",$wpdb[0]->posts)," WHERE post_type = 'post' AND "),$type_sql)," AND post_author IN ("),$editable),") AND post_author != %d ORDER BY post_modified "),$dir),$user_id));
}}return apply_filters(array('get_others_drafts',false),$other_unpubs);
 }
function get_others_drafts ( $user_id ) {
return get_others_unpublished_posts($user_id,array('draft',false));
 }
function get_others_pending ( $user_id ) {
return get_others_unpublished_posts($user_id,array('pending',false));
 }
function get_user_to_edit ( $user_id ) {
$user = array(new WP_User($user_id),false);
$user_contactmethods = _wp_get_user_contactmethods();
foreach ( $user_contactmethods[0] as $method =>$name )
{restoreTaint($method,$name);
{if ( ((empty($user[0]->{$method[0]}) || Aspis_empty( $user[0] ->{$method[0]} ))))
 $user[0]->{$method[0]} = array('',false);
}}if ( ((empty($user[0]->description) || Aspis_empty( $user[0] ->description ))))
 $user[0]->description = array('',false);
$user = sanitize_user_object($user,array('edit',false));
return $user;
 }
function get_users_drafts ( $user_id ) {
global $wpdb;
$query = $wpdb[0]->prepare(concat2(concat1("SELECT ID, post_title FROM ",$wpdb[0]->posts)," WHERE post_type = 'post' AND post_status = 'draft' AND post_author = %d ORDER BY post_modified DESC"),$user_id);
$query = apply_filters(array('get_users_drafts',false),$query);
return $wpdb[0]->get_results($query);
 }
function wp_delete_user ( $id,$reassign = array('novalue',false) ) {
global $wpdb;
$id = int_cast($id);
$user = array(new WP_User($id),false);
do_action(array('delete_user',false),$id);
if ( ($reassign[0] == ('novalue')))
 {$post_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_author = %d"),$id));
if ( $post_ids[0])
 {foreach ( $post_ids[0] as $post_id  )
wp_delete_post($post_id);
}$link_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT link_id FROM ",$wpdb[0]->links)," WHERE link_owner = %d"),$id));
if ( $link_ids[0])
 {foreach ( $link_ids[0] as $link_id  )
wp_delete_link($link_id);
}}else 
{{$reassign = int_cast($reassign);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_author = %d WHERE post_author = %d"),$reassign,$id));
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->links)," SET link_owner = %d WHERE link_owner = %d"),$reassign,$id));
}}$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->usermeta)," WHERE user_id = %d"),$id));
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->users)," WHERE ID = %d"),$id));
wp_cache_delete($id,array('users',false));
wp_cache_delete($user[0]->user_login,array('userlogins',false));
wp_cache_delete($user[0]->user_email,array('useremail',false));
wp_cache_delete($user[0]->user_nicename,array('userslugs',false));
do_action(array('deleted_user',false),$id);
return array(true,false);
 }
function wp_revoke_user ( $id ) {
$id = int_cast($id);
$user = array(new WP_User($id),false);
$user[0]->remove_all_caps();
 }
if ( (!(class_exists(('WP_User_Search')))))
 {class WP_User_Search{var $results;
var $search_term;
var $page;
var $role;
var $raw_page;
var $users_per_page = array(50,false);
var $first_user;
var $last_user;
var $query_limit;
var $query_sort;
var $query_from_where;
var $total_users_for_query = array(0,false);
var $too_many_total_users = array(false,false);
var $search_errors;
var $paging_text;
function WP_User_Search ( $search_term = array('',false),$page = array('',false),$role = array('',false) ) {
{$this->search_term = $search_term;
$this->raw_page = (('') == $page[0]) ? array(false,false) : int_cast($page);
$this->page = deAspis(int_cast((array(('') == $page[0],false)))) ? array(1,false) : $page;
$this->role = $role;
$this->prepare_query();
$this->query();
$this->prepare_vars_for_template_usage();
$this->do_paging();
} }
function prepare_query (  ) {
{global $wpdb;
$this->first_user = array(($this->page[0] - (1)) * $this->users_per_page[0],false);
$this->query_limit = $wpdb[0]->prepare(array(" LIMIT %d, %d",false),$this->first_user,$this->users_per_page);
$this->query_sort = array(' ORDER BY user_login',false);
$search_sql = array('',false);
if ( $this->search_term[0])
 {$searches = array(array(),false);
$search_sql = array('AND (',false);
foreach ( (array(array('user_login',false),array('user_nicename',false),array('user_email',false),array('user_url',false),array('display_name',false))) as $col  )
arrayAssignAdd($searches[0][],addTaint(concat($col,concat2(concat1(" LIKE '%",$this->search_term),"%'"))));
$search_sql = concat($search_sql,Aspis_implode(array(' OR ',false),$searches));
$search_sql = concat2($search_sql,')');
}$this->query_from_where = concat1("FROM ",$wpdb[0]->users);
if ( $this->role[0])
 $this->query_from_where = concat($this->query_from_where ,$wpdb[0]->prepare(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" INNER JOIN ",$wpdb[0]->usermeta)," ON "),$wpdb[0]->users),".ID = "),$wpdb[0]->usermeta),".user_id WHERE "),$wpdb[0]->usermeta),".meta_key = '"),$wpdb[0]->prefix),"capabilities' AND "),$wpdb[0]->usermeta),".meta_value LIKE %s"),concat2(concat1('%',$this->role),'%')));
else 
{$this->query_from_where = concat2($this->query_from_where ," WHERE 1=1");
}$this->query_from_where = concat($this->query_from_where ,concat1(" ",$search_sql));
} }
function query (  ) {
{global $wpdb;
$this->results = $wpdb[0]->get_col(concat(concat(concat1('SELECT ID ',$this->query_from_where),$this->query_sort),$this->query_limit));
if ( $this->results[0])
 $this->total_users_for_query = $wpdb[0]->get_var(concat1('SELECT COUNT(ID) ',$this->query_from_where));
else 
{$this->search_errors = array(new WP_Error(array('no_matching_users_found',false),__(array('No matching users were found!',false))),false);
}} }
function prepare_vars_for_template_usage (  ) {
{$this->search_term = Aspis_stripslashes($this->search_term);
} }
function do_paging (  ) {
{if ( ($this->total_users_for_query[0] > $this->users_per_page[0]))
 {$args = array(array(),false);
if ( (!((empty($this->search_term) || Aspis_empty( $this ->search_term )))))
 arrayAssign($args[0],deAspis(registerTaint(array('usersearch',false))),addTaint(Aspis_urlencode($this->search_term)));
if ( (!((empty($this->role) || Aspis_empty( $this ->role )))))
 arrayAssign($args[0],deAspis(registerTaint(array('role',false))),addTaint(Aspis_urlencode($this->role)));
$this->paging_text = paginate_links(array(array(deregisterTaint(array('total',false)) => addTaint(attAspis(ceil(($this->total_users_for_query[0] / $this->users_per_page[0])))),deregisterTaint(array('current',false)) => addTaint($this->page),'base' => array('users.php?%_%',false,false),'format' => array('userspage=%#%',false,false),deregisterTaint(array('add_args',false)) => addTaint($args)),false));
if ( $this->paging_text[0])
 {$this->paging_text = Aspis_sprintf(concat2(concat1('<span class="displaying-num">',__(array('Displaying %s&#8211;%s of %s',false))),'</span>%s'),number_format_i18n(array((($this->page[0] - (1)) * $this->users_per_page[0]) + (1),false)),number_format_i18n(attAspisRC(min(deAspisRC(array($this->page[0] * $this->users_per_page[0],false)),deAspisRC($this->total_users_for_query)))),number_format_i18n($this->total_users_for_query),$this->paging_text);
}}} }
function get_results (  ) {
{return array_cast($this->results);
} }
function page_links (  ) {
{echo AspisCheckPrint($this->paging_text);
} }
function results_are_paged (  ) {
{if ( $this->paging_text[0])
 return array(true,false);
return array(false,false);
} }
function is_search (  ) {
{if ( $this->search_term[0])
 return array(true,false);
return array(false,false);
} }
}}add_action(array('admin_init',false),array('default_password_nag_handler',false));
function default_password_nag_handler ( $errors = array(false,false) ) {
global $user_ID;
if ( (denot_boolean(get_usermeta($user_ID,array('default_password_nag',false)))))
 return ;
if ( ((('hide') == deAspis(get_user_setting(array('default_password_nag',false)))) || (((isset($_GET[0][('default_password_nag')]) && Aspis_isset( $_GET [0][('default_password_nag')]))) && (('0') == deAspis($_GET[0]['default_password_nag'])))))
 {delete_user_setting(array('default_password_nag',false));
update_usermeta($user_ID,array('default_password_nag',false),array(false,false));
} }
add_action(array('profile_update',false),array('default_password_nag_edit_user',false),array(10,false),array(2,false));
function default_password_nag_edit_user ( $user_ID,$old_data ) {
global $user_ID;
if ( (denot_boolean(get_usermeta($user_ID,array('default_password_nag',false)))))
 return ;
$new_data = get_userdata($user_ID);
if ( ($new_data[0]->user_pass[0] != $old_data[0]->user_pass[0]))
 {delete_user_setting(array('default_password_nag',false));
update_usermeta($user_ID,array('default_password_nag',false),array(false,false));
} }
add_action(array('admin_notices',false),array('default_password_nag',false));
function default_password_nag (  ) {
global $user_ID;
if ( (denot_boolean(get_usermeta($user_ID,array('default_password_nag',false)))))
 return ;
echo AspisCheckPrint(array('<div class="error default-password-nag"><p>',false));
printf(deAspis(__(array("Notice: you're using the auto-generated password for your account. Would you like to change it to something you'll remember easier?<br />
			  <a href='%s'>Yes, Take me to my profile page</a> | <a href='%s' id='default-password-nag-no'>No Thanks, Do not remind me again.</a>",false))),(deconcat2(admin_url(array('profile.php',false)),'#password')),'?default_password_nag=0');
echo AspisCheckPrint(array('</p></div>',false));
 }
;
?>
<?php 