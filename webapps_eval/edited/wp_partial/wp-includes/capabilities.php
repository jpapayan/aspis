<?php require_once('AspisMain.php'); ?><?php
class WP_Roles{var $roles;
var $role_objects = array();
var $role_names = array();
var $role_key;
var $use_db = true;
function WP_Roles (  ) {
{$this->_init();
} }
function _init (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}{global $wp_user_roles;
$AspisVar1 = &AspisCleanTaintedGlobalUntainted( $wp_user_roles,"\$wp_user_roles",$AspisChangesCache);
}$this->role_key = $wpdb->prefix . 'user_roles';
if ( !empty($wp_user_roles))
 {$this->roles = $wp_user_roles;
$this->use_db = false;
}else 
{{$this->roles = get_option($this->role_key);
}}if ( empty($this->roles))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_user_roles",$AspisChangesCache);
return ;
}$this->role_objects = array();
$this->role_names = array();
foreach ( (array)$this->roles as $role =>$data )
{$this->role_objects[$role] = new WP_Role($role,$this->roles[$role]['capabilities']);
$this->role_names[$role] = $this->roles[$role]['name'];
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_user_roles",$AspisChangesCache);
 }
function add_role ( $role,$display_name,$capabilities = array() ) {
{if ( isset($this->roles[$role]))
 {return ;
}$this->roles[$role] = array('name' => $display_name,'capabilities' => $capabilities);
if ( $this->use_db)
 update_option($this->role_key,$this->roles);
$this->role_objects[$role] = new WP_Role($role,$capabilities);
$this->role_names[$role] = $display_name;
{$AspisRetTemp = $this->role_objects[$role];
return $AspisRetTemp;
}} }
function remove_role ( $role ) {
{if ( !isset($this->role_objects[$role]))
 {return ;
}unset($this->role_objects[$role]);
unset($this->role_names[$role]);
unset($this->roles[$role]);
if ( $this->use_db)
 update_option($this->role_key,$this->roles);
} }
function add_cap ( $role,$cap,$grant = true ) {
{$this->roles[$role]['capabilities'][$cap] = $grant;
if ( $this->use_db)
 update_option($this->role_key,$this->roles);
} }
function remove_cap ( $role,$cap ) {
{unset($this->roles[$role]['capabilities'][$cap]);
if ( $this->use_db)
 update_option($this->role_key,$this->roles);
} }
function &get_role ( $role ) {
{if ( isset($this->role_objects[$role]))
 {$AspisRetTemp = &$this->role_objects[$role];
return $AspisRetTemp;
}else 
{{$AspisRetTemp = null;
return $AspisRetTemp;
}}} }
function get_names (  ) {
{{$AspisRetTemp = $this->role_names;
return $AspisRetTemp;
}} }
function is_role ( $role ) {
{{$AspisRetTemp = isset($this->role_names[$role]);
return $AspisRetTemp;
}} }
}class WP_Role{var $name;
var $capabilities;
function WP_Role ( $role,$capabilities ) {
{$this->name = $role;
$this->capabilities = $capabilities;
} }
function add_cap ( $cap,$grant = true ) {
{{global $wp_roles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_roles,"\$wp_roles",$AspisChangesCache);
}if ( !isset($wp_roles))
 $wp_roles = new WP_Roles();
$this->capabilities[$cap] = $grant;
$wp_roles->add_cap($this->name,$cap,$grant);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
 }
function remove_cap ( $cap ) {
{{global $wp_roles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_roles,"\$wp_roles",$AspisChangesCache);
}if ( !isset($wp_roles))
 $wp_roles = new WP_Roles();
unset($this->capabilities[$cap]);
$wp_roles->remove_cap($this->name,$cap);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
 }
function has_cap ( $cap ) {
{$capabilities = apply_filters('role_has_cap',$this->capabilities,$cap,$this->name);
if ( !empty($capabilities[$cap]))
 {$AspisRetTemp = $capabilities[$cap];
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
return $AspisRetTemp;
}}} }
}class WP_User{var $data;
var $ID = 0;
var $id = 0;
var $caps = array();
var $cap_key;
var $roles = array();
var $allcaps = array();
var $first_name = '';
var $last_name = '';
var $filter = null;
function WP_User ( $id,$name = '' ) {
{if ( empty($id) && empty($name))
 {return ;
}if ( !is_numeric($id))
 {$name = $id;
$id = 0;
}if ( !empty($id))
 $this->data = get_userdata($id);
else 
{$this->data = get_userdatabylogin($name);
}if ( empty($this->data->ID))
 {return ;
}foreach ( get_object_vars($this->data) as $key =>$value )
{$this->{$key} = $value;
}$this->id = $this->ID;
$this->_init_caps();
} }
function _init_caps (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$this->cap_key = $wpdb->prefix . 'capabilities';
$this->caps = &$this->{$this->cap_key};
if ( !is_array($this->caps))
 $this->caps = array();
$this->get_role_caps();
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_role_caps (  ) {
{{global $wp_roles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_roles,"\$wp_roles",$AspisChangesCache);
}if ( !isset($wp_roles))
 $wp_roles = new WP_Roles();
if ( is_array($this->caps))
 $this->roles = array_filter(array_keys($this->caps),array(&$wp_roles,'is_role'));
$this->allcaps = array();
foreach ( (array)$this->roles as $role  )
{$role = &$wp_roles->get_role($role);
$this->allcaps = array_merge((array)$this->allcaps,(array)$role->capabilities);
}$this->allcaps = array_merge((array)$this->allcaps,(array)$this->caps);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
 }
function add_role ( $role ) {
{$this->caps[$role] = true;
update_usermeta($this->ID,$this->cap_key,$this->caps);
$this->get_role_caps();
$this->update_user_level_from_caps();
} }
function remove_role ( $role ) {
{if ( empty($this->roles[$role]) || (count($this->roles) <= 1))
 {return ;
}unset($this->caps[$role]);
update_usermeta($this->ID,$this->cap_key,$this->caps);
$this->get_role_caps();
} }
function set_role ( $role ) {
{foreach ( (array)$this->roles as $oldrole  )
unset($this->caps[$oldrole]);
if ( !empty($role))
 {$this->caps[$role] = true;
$this->roles = array($role => true);
}else 
{{$this->roles = false;
}}update_usermeta($this->ID,$this->cap_key,$this->caps);
$this->get_role_caps();
$this->update_user_level_from_caps();
do_action('set_user_role',$this->ID,$role);
} }
function level_reduction ( $max,$item ) {
{if ( preg_match('/^level_(10|[0-9])$/i',$item,$matches))
 {$level = intval($matches[1]);
{$AspisRetTemp = max($max,$level);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = $max;
return $AspisRetTemp;
}}}} }
function update_user_level_from_caps (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$this->user_level = array_reduce(array_keys($this->allcaps),array(&$this,'level_reduction'),0);
update_usermeta($this->ID,$wpdb->prefix . 'user_level',$this->user_level);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function add_cap ( $cap,$grant = true ) {
{$this->caps[$cap] = $grant;
update_usermeta($this->ID,$this->cap_key,$this->caps);
} }
function remove_cap ( $cap ) {
{if ( empty($this->caps[$cap]))
 {return ;
}unset($this->caps[$cap]);
update_usermeta($this->ID,$this->cap_key,$this->caps);
} }
function remove_all_caps (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$this->caps = array();
update_usermeta($this->ID,$this->cap_key,'');
update_usermeta($this->ID,$wpdb->prefix . 'user_level','');
$this->get_role_caps();
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function has_cap ( $cap ) {
{if ( is_numeric($cap))
 $cap = $this->translate_level_to_cap($cap);
$args = array_slice(func_get_args(),1);
$args = array_merge(array($cap,$this->ID),$args);
$caps = AspisUntainted_call_user_func_array('map_meta_cap',$args);
$capabilities = apply_filters('user_has_cap',$this->allcaps,$caps,$args);
foreach ( (array)$caps as $cap  )
{if ( empty($capabilities[$cap]) || !$capabilities[$cap])
 {$AspisRetTemp = false;
return $AspisRetTemp;
}}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function translate_level_to_cap ( $level ) {
{{$AspisRetTemp = 'level_' . $level;
return $AspisRetTemp;
}} }
}function map_meta_cap ( $cap,$user_id ) {
$args = array_slice(func_get_args(),2);
$caps = array();
switch ( $cap ) {
case 'delete_user':$caps[] = 'delete_users';
break ;
case 'edit_user':if ( !isset($args[0]) || $user_id != $args[0])
 {$caps[] = 'edit_users';
}break ;
case 'delete_post':$author_data = get_userdata($user_id);
$post = get_post($args[0]);
if ( 'page' == $post->post_type)
 {$args = array_merge(array('delete_page',$user_id),$args);
{$AspisRetTemp = AspisUntainted_call_user_func_array('map_meta_cap',$args);
return $AspisRetTemp;
}}if ( '' != $post->post_author)
 {$post_author_data = get_userdata($post->post_author);
}else 
{{$post_author_data = $author_data;
}}if ( $user_id == $post_author_data->ID)
 {if ( 'publish' == $post->post_status)
 {$caps[] = 'delete_published_posts';
}elseif ( 'trash' == $post->post_status)
 {if ( 'publish' == get_post_meta($post->ID,'_wp_trash_meta_status',true))
 $caps[] = 'delete_published_posts';
}else 
{{$caps[] = 'delete_posts';
}}}else 
{{$caps[] = 'delete_others_posts';
if ( 'publish' == $post->post_status)
 $caps[] = 'delete_published_posts';
elseif ( 'private' == $post->post_status)
 $caps[] = 'delete_private_posts';
}}break ;
case 'delete_page':$author_data = get_userdata($user_id);
$page = get_page($args[0]);
$page_author_data = get_userdata($page->post_author);
if ( '' != $page->post_author)
 {$page_author_data = get_userdata($page->post_author);
}else 
{{$page_author_data = $author_data;
}}if ( $user_id == $page_author_data->ID)
 {if ( $page->post_status == 'publish')
 {$caps[] = 'delete_published_pages';
}elseif ( 'trash' == $page->post_status)
 {if ( 'publish' == get_post_meta($page->ID,'_wp_trash_meta_status',true))
 $caps[] = 'delete_published_pages';
}else 
{{$caps[] = 'delete_pages';
}}}else 
{{$caps[] = 'delete_others_pages';
if ( $page->post_status == 'publish')
 $caps[] = 'delete_published_pages';
elseif ( $page->post_status == 'private')
 $caps[] = 'delete_private_pages';
}}break ;
case 'edit_post':$author_data = get_userdata($user_id);
$post = get_post($args[0]);
if ( 'page' == $post->post_type)
 {$args = array_merge(array('edit_page',$user_id),$args);
{$AspisRetTemp = AspisUntainted_call_user_func_array('map_meta_cap',$args);
return $AspisRetTemp;
}}$post_author_data = get_userdata($post->post_author);
if ( $user_id == $post_author_data->ID)
 {if ( 'publish' == $post->post_status)
 {$caps[] = 'edit_published_posts';
}elseif ( 'trash' == $post->post_status)
 {if ( 'publish' == get_post_meta($post->ID,'_wp_trash_meta_status',true))
 $caps[] = 'edit_published_posts';
}else 
{{$caps[] = 'edit_posts';
}}}else 
{{$caps[] = 'edit_others_posts';
if ( 'publish' == $post->post_status)
 $caps[] = 'edit_published_posts';
elseif ( 'private' == $post->post_status)
 $caps[] = 'edit_private_posts';
}}break ;
case 'edit_page':$author_data = get_userdata($user_id);
$page = get_page($args[0]);
$page_author_data = get_userdata($page->post_author);
if ( $user_id == $page_author_data->ID)
 {if ( 'publish' == $page->post_status)
 {$caps[] = 'edit_published_pages';
}elseif ( 'trash' == $page->post_status)
 {if ( 'publish' == get_post_meta($page->ID,'_wp_trash_meta_status',true))
 $caps[] = 'edit_published_pages';
}else 
{{$caps[] = 'edit_pages';
}}}else 
{{$caps[] = 'edit_others_pages';
if ( 'publish' == $page->post_status)
 $caps[] = 'edit_published_pages';
elseif ( 'private' == $page->post_status)
 $caps[] = 'edit_private_pages';
}}break ;
case 'read_post':$post = get_post($args[0]);
if ( 'page' == $post->post_type)
 {$args = array_merge(array('read_page',$user_id),$args);
{$AspisRetTemp = AspisUntainted_call_user_func_array('map_meta_cap',$args);
return $AspisRetTemp;
}}if ( 'private' != $post->post_status)
 {$caps[] = 'read';
break ;
}$author_data = get_userdata($user_id);
$post_author_data = get_userdata($post->post_author);
if ( $user_id == $post_author_data->ID)
 $caps[] = 'read';
else 
{$caps[] = 'read_private_posts';
}break ;
case 'read_page':$page = get_page($args[0]);
if ( 'private' != $page->post_status)
 {$caps[] = 'read';
break ;
}$author_data = get_userdata($user_id);
$page_author_data = get_userdata($page->post_author);
if ( $user_id == $page_author_data->ID)
 $caps[] = 'read';
else 
{$caps[] = 'read_private_pages';
}break ;
case 'unfiltered_upload':if ( defined('ALLOW_UNFILTERED_UPLOADS') && ALLOW_UNFILTERED_UPLOADS == true)
 $caps[] = $cap;
else 
{$caps[] = 'do_not_allow';
}break ;
default :$caps[] = $cap;
 }
{$AspisRetTemp = apply_filters('map_meta_cap',$caps,$cap,$user_id,$args);
return $AspisRetTemp;
} }
function current_user_can ( $capability ) {
$current_user = wp_get_current_user();
if ( empty($current_user))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$args = array_slice(func_get_args(),1);
$args = array_merge(array($capability),$args);
{$AspisRetTemp = AspisUntainted_call_user_func_array(array(&$current_user,'has_cap'),$args);
return $AspisRetTemp;
} }
function author_can ( $post,$capability ) {
if ( !$post = get_post($post))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$author = new WP_User($post->post_author);
if ( empty($author))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$args = array_slice(func_get_args(),2);
$args = array_merge(array($capability),$args);
{$AspisRetTemp = AspisUntainted_call_user_func_array(array(&$author,'has_cap'),$args);
return $AspisRetTemp;
} }
function get_role ( $role ) {
{global $wp_roles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_roles,"\$wp_roles",$AspisChangesCache);
}if ( !isset($wp_roles))
 $wp_roles = new WP_Roles();
{$AspisRetTemp = $wp_roles->get_role($role);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
 }
function add_role ( $role,$display_name,$capabilities = array() ) {
{global $wp_roles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_roles,"\$wp_roles",$AspisChangesCache);
}if ( !isset($wp_roles))
 $wp_roles = new WP_Roles();
{$AspisRetTemp = $wp_roles->add_role($role,$display_name,$capabilities);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
 }
function remove_role ( $role ) {
{global $wp_roles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_roles,"\$wp_roles",$AspisChangesCache);
}if ( !isset($wp_roles))
 $wp_roles = new WP_Roles();
{$AspisRetTemp = $wp_roles->remove_role($role);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_roles",$AspisChangesCache);
 }
;
?>
<?php 