<?php require_once('AspisMain.php'); ?><?php
class WP_Roles{var $roles;
var $role_objects = array(array(),false);
var $role_names = array(array(),false);
var $role_key;
var $use_db = array(true,false);
function WP_Roles (  ) {
{$this->_init();
} }
function _init (  ) {
{global $wpdb;
global $wp_user_roles;
$this->role_key = concat2($wpdb[0]->prefix,'user_roles');
if ( (!((empty($wp_user_roles) || Aspis_empty( $wp_user_roles)))))
 {$this->roles = $wp_user_roles;
$this->use_db = array(false,false);
}else 
{{$this->roles = get_option($this->role_key);
}}if ( ((empty($this->roles) || Aspis_empty( $this ->roles ))))
 return ;
$this->role_objects = array(array(),false);
$this->role_names = array(array(),false);
foreach ( deAspis(array_cast($this->roles)) as $role =>$data )
{restoreTaint($role,$data);
{arrayAssign($this->role_objects[0],deAspis(registerTaint($role)),addTaint(array(new WP_Role($role,$this->roles[0][$role[0]][0][('capabilities')]),false)));
arrayAssign($this->role_names[0],deAspis(registerTaint($role)),addTaint($this->roles[0][$role[0]][0][('name')]));
}}} }
function add_role ( $role,$display_name,$capabilities = array(array(),false) ) {
{if ( ((isset($this->roles[0][$role[0]]) && Aspis_isset( $this ->roles [0][$role[0]] ))))
 return ;
arrayAssign($this->roles[0],deAspis(registerTaint($role)),addTaint(array(array(deregisterTaint(array('name',false)) => addTaint($display_name),deregisterTaint(array('capabilities',false)) => addTaint($capabilities)),false)));
if ( $this->use_db[0])
 update_option($this->role_key,$this->roles);
arrayAssign($this->role_objects[0],deAspis(registerTaint($role)),addTaint(array(new WP_Role($role,$capabilities),false)));
arrayAssign($this->role_names[0],deAspis(registerTaint($role)),addTaint($display_name));
return $this->role_objects[0][$role[0]];
} }
function remove_role ( $role ) {
{if ( (!((isset($this->role_objects[0][$role[0]]) && Aspis_isset( $this ->role_objects [0][$role[0]] )))))
 return ;
unset($this->role_objects[0][$role[0]]);
unset($this->role_names[0][$role[0]]);
unset($this->roles[0][$role[0]]);
if ( $this->use_db[0])
 update_option($this->role_key,$this->roles);
} }
function add_cap ( $role,$cap,$grant = array(true,false) ) {
{arrayAssign($this->roles[0][$role[0]][0][('capabilities')][0],deAspis(registerTaint($cap)),addTaint($grant));
if ( $this->use_db[0])
 update_option($this->role_key,$this->roles);
} }
function remove_cap ( $role,$cap ) {
{unset($this->roles[0][$role[0]][0][('capabilities')][0][$cap[0]]);
if ( $this->use_db[0])
 update_option($this->role_key,$this->roles);
} }
function &get_role ( $role ) {
{if ( ((isset($this->role_objects[0][$role[0]]) && Aspis_isset( $this ->role_objects [0][$role[0]] ))))
 return $this->role_objects[0][$role[0]];
else 
{return array(null,false);
}} }
function get_names (  ) {
{return $this->role_names;
} }
function is_role ( $role ) {
{return array((isset($this->role_names[0][$role[0]]) && Aspis_isset( $this ->role_names [0][$role[0]] )),false);
} }
}class WP_Role{var $name;
var $capabilities;
function WP_Role ( $role,$capabilities ) {
{$this->name = $role;
$this->capabilities = $capabilities;
} }
function add_cap ( $cap,$grant = array(true,false) ) {
{global $wp_roles;
if ( (!((isset($wp_roles) && Aspis_isset( $wp_roles)))))
 $wp_roles = array(new WP_Roles(),false);
arrayAssign($this->capabilities[0],deAspis(registerTaint($cap)),addTaint($grant));
$wp_roles[0]->add_cap($this->name,$cap,$grant);
} }
function remove_cap ( $cap ) {
{global $wp_roles;
if ( (!((isset($wp_roles) && Aspis_isset( $wp_roles)))))
 $wp_roles = array(new WP_Roles(),false);
unset($this->capabilities[0][$cap[0]]);
$wp_roles[0]->remove_cap($this->name,$cap);
} }
function has_cap ( $cap ) {
{$capabilities = apply_filters(array('role_has_cap',false),$this->capabilities,$cap,$this->name);
if ( (!((empty($capabilities[0][$cap[0]]) || Aspis_empty( $capabilities [0][$cap[0]])))))
 return attachAspis($capabilities,$cap[0]);
else 
{return array(false,false);
}} }
}class WP_User{var $data;
var $ID = array(0,false);
var $id = array(0,false);
var $caps = array(array(),false);
var $cap_key;
var $roles = array(array(),false);
var $allcaps = array(array(),false);
var $first_name = array('',false);
var $last_name = array('',false);
var $filter = array(null,false);
function WP_User ( $id,$name = array('',false) ) {
{if ( (((empty($id) || Aspis_empty( $id))) && ((empty($name) || Aspis_empty( $name)))))
 return ;
if ( (!(is_numeric(deAspisRC($id)))))
 {$name = $id;
$id = array(0,false);
}if ( (!((empty($id) || Aspis_empty( $id)))))
 $this->data = get_userdata($id);
else 
{$this->data = get_userdatabylogin($name);
}if ( ((empty($this->data[0]->ID) || Aspis_empty( $this ->data[0] ->ID ))))
 return ;
foreach ( get_object_vars(deAspisRC($this->data)) as $key =>$value )
{restoreTaint($key,$value);
{$this->{$key[0]} = $value;
}}$this->id = $this->ID;
$this->_init_caps();
} }
function _init_caps (  ) {
{global $wpdb;
$this->cap_key = concat2($wpdb[0]->prefix,'capabilities');
$this->caps = &$this->{$this->cap_key[0]};
if ( (!(is_array($this->caps[0]))))
 $this->caps = array(array(),false);
$this->get_role_caps();
} }
function get_role_caps (  ) {
{global $wp_roles;
if ( (!((isset($wp_roles) && Aspis_isset( $wp_roles)))))
 $wp_roles = array(new WP_Roles(),false);
if ( is_array($this->caps[0]))
 $this->roles = attAspisRC(array_filter(deAspisRC(attAspisRC(array_keys(deAspisRC($this->caps)))),AspisInternalCallback(array(array(&$wp_roles,array('is_role',false)),false))));
$this->allcaps = array(array(),false);
foreach ( deAspis(array_cast($this->roles)) as $role  )
{$role = &$wp_roles[0]->get_role($role);
$this->allcaps = Aspis_array_merge(array_cast($this->allcaps),array_cast($role[0]->capabilities));
}$this->allcaps = Aspis_array_merge(array_cast($this->allcaps),array_cast($this->caps));
} }
function add_role ( $role ) {
{arrayAssign($this->caps[0],deAspis(registerTaint($role)),addTaint(array(true,false)));
update_usermeta($this->ID,$this->cap_key,$this->caps);
$this->get_role_caps();
$this->update_user_level_from_caps();
} }
function remove_role ( $role ) {
{if ( (((empty($this->roles[0][$role[0]]) || Aspis_empty( $this ->roles [0][$role[0]] ))) || (count($this->roles[0]) <= (1))))
 return ;
unset($this->caps[0][$role[0]]);
update_usermeta($this->ID,$this->cap_key,$this->caps);
$this->get_role_caps();
} }
function set_role ( $role ) {
{foreach ( deAspis(array_cast($this->roles)) as $oldrole  )
unset($this->caps[0][$oldrole[0]]);
if ( (!((empty($role) || Aspis_empty( $role)))))
 {arrayAssign($this->caps[0],deAspis(registerTaint($role)),addTaint(array(true,false)));
$this->roles = array(array(deregisterTaint($role) => addTaint(array(true,false))),false);
}else 
{{$this->roles = array(false,false);
}}update_usermeta($this->ID,$this->cap_key,$this->caps);
$this->get_role_caps();
$this->update_user_level_from_caps();
do_action(array('set_user_role',false),$this->ID,$role);
} }
function level_reduction ( $max,$item ) {
{if ( deAspis(Aspis_preg_match(array('/^level_(10|[0-9])$/i',false),$item,$matches)))
 {$level = Aspis_intval(attachAspis($matches,(1)));
return attAspisRC(max(deAspisRC($max),deAspisRC($level)));
}else 
{{return $max;
}}} }
function update_user_level_from_caps (  ) {
{global $wpdb;
$this->user_level = attAspisRC(array_reduce(deAspisRC(attAspisRC(array_keys(deAspisRC($this->allcaps)))),AspisInternalCallback(array(array(array($this,false),array('level_reduction',false)),false)),(0)));
update_usermeta($this->ID,concat2($wpdb[0]->prefix,'user_level'),$this->user_level);
} }
function add_cap ( $cap,$grant = array(true,false) ) {
{arrayAssign($this->caps[0],deAspis(registerTaint($cap)),addTaint($grant));
update_usermeta($this->ID,$this->cap_key,$this->caps);
} }
function remove_cap ( $cap ) {
{if ( ((empty($this->caps[0][$cap[0]]) || Aspis_empty( $this ->caps [0][$cap[0]] ))))
 return ;
unset($this->caps[0][$cap[0]]);
update_usermeta($this->ID,$this->cap_key,$this->caps);
} }
function remove_all_caps (  ) {
{global $wpdb;
$this->caps = array(array(),false);
update_usermeta($this->ID,$this->cap_key,array('',false));
update_usermeta($this->ID,concat2($wpdb[0]->prefix,'user_level'),array('',false));
$this->get_role_caps();
} }
function has_cap ( $cap ) {
{if ( is_numeric(deAspisRC($cap)))
 $cap = $this->translate_level_to_cap($cap);
$args = Aspis_array_slice(array(func_get_args(),false),array(1,false));
$args = Aspis_array_merge(array(array($cap,$this->ID),false),$args);
$caps = Aspis_call_user_func_array(array('map_meta_cap',false),$args);
$capabilities = apply_filters(array('user_has_cap',false),$this->allcaps,$caps,$args);
foreach ( deAspis(array_cast($caps)) as $cap  )
{if ( (((empty($capabilities[0][$cap[0]]) || Aspis_empty( $capabilities [0][$cap[0]]))) || (denot_boolean(attachAspis($capabilities,$cap[0])))))
 return array(false,false);
}return array(true,false);
} }
function translate_level_to_cap ( $level ) {
{return concat1('level_',$level);
} }
}function map_meta_cap ( $cap,$user_id ) {
$args = Aspis_array_slice(array(func_get_args(),false),array(2,false));
$caps = array(array(),false);
switch ( $cap[0] ) {
case ('delete_user'):arrayAssignAdd($caps[0][],addTaint(array('delete_users',false)));
break ;
case ('edit_user'):if ( ((!((isset($args[0][(0)]) && Aspis_isset( $args [0][(0)])))) || ($user_id[0] != deAspis(attachAspis($args,(0))))))
 {arrayAssignAdd($caps[0][],addTaint(array('edit_users',false)));
}break ;
case ('delete_post'):$author_data = get_userdata($user_id);
$post = get_post(attachAspis($args,(0)));
if ( (('page') == $post[0]->post_type[0]))
 {$args = Aspis_array_merge(array(array(array('delete_page',false),$user_id),false),$args);
return Aspis_call_user_func_array(array('map_meta_cap',false),$args);
}if ( (('') != $post[0]->post_author[0]))
 {$post_author_data = get_userdata($post[0]->post_author);
}else 
{{$post_author_data = $author_data;
}}if ( ($user_id[0] == $post_author_data[0]->ID[0]))
 {if ( (('publish') == $post[0]->post_status[0]))
 {arrayAssignAdd($caps[0][],addTaint(array('delete_published_posts',false)));
}elseif ( (('trash') == $post[0]->post_status[0]))
 {if ( (('publish') == deAspis(get_post_meta($post[0]->ID,array('_wp_trash_meta_status',false),array(true,false)))))
 arrayAssignAdd($caps[0][],addTaint(array('delete_published_posts',false)));
}else 
{{arrayAssignAdd($caps[0][],addTaint(array('delete_posts',false)));
}}}else 
{{arrayAssignAdd($caps[0][],addTaint(array('delete_others_posts',false)));
if ( (('publish') == $post[0]->post_status[0]))
 arrayAssignAdd($caps[0][],addTaint(array('delete_published_posts',false)));
elseif ( (('private') == $post[0]->post_status[0]))
 arrayAssignAdd($caps[0][],addTaint(array('delete_private_posts',false)));
}}break ;
case ('delete_page'):$author_data = get_userdata($user_id);
$page = get_page(attachAspis($args,(0)));
$page_author_data = get_userdata($page[0]->post_author);
if ( (('') != $page[0]->post_author[0]))
 {$page_author_data = get_userdata($page[0]->post_author);
}else 
{{$page_author_data = $author_data;
}}if ( ($user_id[0] == $page_author_data[0]->ID[0]))
 {if ( ($page[0]->post_status[0] == ('publish')))
 {arrayAssignAdd($caps[0][],addTaint(array('delete_published_pages',false)));
}elseif ( (('trash') == $page[0]->post_status[0]))
 {if ( (('publish') == deAspis(get_post_meta($page[0]->ID,array('_wp_trash_meta_status',false),array(true,false)))))
 arrayAssignAdd($caps[0][],addTaint(array('delete_published_pages',false)));
}else 
{{arrayAssignAdd($caps[0][],addTaint(array('delete_pages',false)));
}}}else 
{{arrayAssignAdd($caps[0][],addTaint(array('delete_others_pages',false)));
if ( ($page[0]->post_status[0] == ('publish')))
 arrayAssignAdd($caps[0][],addTaint(array('delete_published_pages',false)));
elseif ( ($page[0]->post_status[0] == ('private')))
 arrayAssignAdd($caps[0][],addTaint(array('delete_private_pages',false)));
}}break ;
case ('edit_post'):$author_data = get_userdata($user_id);
$post = get_post(attachAspis($args,(0)));
if ( (('page') == $post[0]->post_type[0]))
 {$args = Aspis_array_merge(array(array(array('edit_page',false),$user_id),false),$args);
return Aspis_call_user_func_array(array('map_meta_cap',false),$args);
}$post_author_data = get_userdata($post[0]->post_author);
if ( ($user_id[0] == $post_author_data[0]->ID[0]))
 {if ( (('publish') == $post[0]->post_status[0]))
 {arrayAssignAdd($caps[0][],addTaint(array('edit_published_posts',false)));
}elseif ( (('trash') == $post[0]->post_status[0]))
 {if ( (('publish') == deAspis(get_post_meta($post[0]->ID,array('_wp_trash_meta_status',false),array(true,false)))))
 arrayAssignAdd($caps[0][],addTaint(array('edit_published_posts',false)));
}else 
{{arrayAssignAdd($caps[0][],addTaint(array('edit_posts',false)));
}}}else 
{{arrayAssignAdd($caps[0][],addTaint(array('edit_others_posts',false)));
if ( (('publish') == $post[0]->post_status[0]))
 arrayAssignAdd($caps[0][],addTaint(array('edit_published_posts',false)));
elseif ( (('private') == $post[0]->post_status[0]))
 arrayAssignAdd($caps[0][],addTaint(array('edit_private_posts',false)));
}}break ;
case ('edit_page'):$author_data = get_userdata($user_id);
$page = get_page(attachAspis($args,(0)));
$page_author_data = get_userdata($page[0]->post_author);
if ( ($user_id[0] == $page_author_data[0]->ID[0]))
 {if ( (('publish') == $page[0]->post_status[0]))
 {arrayAssignAdd($caps[0][],addTaint(array('edit_published_pages',false)));
}elseif ( (('trash') == $page[0]->post_status[0]))
 {if ( (('publish') == deAspis(get_post_meta($page[0]->ID,array('_wp_trash_meta_status',false),array(true,false)))))
 arrayAssignAdd($caps[0][],addTaint(array('edit_published_pages',false)));
}else 
{{arrayAssignAdd($caps[0][],addTaint(array('edit_pages',false)));
}}}else 
{{arrayAssignAdd($caps[0][],addTaint(array('edit_others_pages',false)));
if ( (('publish') == $page[0]->post_status[0]))
 arrayAssignAdd($caps[0][],addTaint(array('edit_published_pages',false)));
elseif ( (('private') == $page[0]->post_status[0]))
 arrayAssignAdd($caps[0][],addTaint(array('edit_private_pages',false)));
}}break ;
case ('read_post'):$post = get_post(attachAspis($args,(0)));
if ( (('page') == $post[0]->post_type[0]))
 {$args = Aspis_array_merge(array(array(array('read_page',false),$user_id),false),$args);
return Aspis_call_user_func_array(array('map_meta_cap',false),$args);
}if ( (('private') != $post[0]->post_status[0]))
 {arrayAssignAdd($caps[0][],addTaint(array('read',false)));
break ;
}$author_data = get_userdata($user_id);
$post_author_data = get_userdata($post[0]->post_author);
if ( ($user_id[0] == $post_author_data[0]->ID[0]))
 arrayAssignAdd($caps[0][],addTaint(array('read',false)));
else 
{arrayAssignAdd($caps[0][],addTaint(array('read_private_posts',false)));
}break ;
case ('read_page'):$page = get_page(attachAspis($args,(0)));
if ( (('private') != $page[0]->post_status[0]))
 {arrayAssignAdd($caps[0][],addTaint(array('read',false)));
break ;
}$author_data = get_userdata($user_id);
$page_author_data = get_userdata($page[0]->post_author);
if ( ($user_id[0] == $page_author_data[0]->ID[0]))
 arrayAssignAdd($caps[0][],addTaint(array('read',false)));
else 
{arrayAssignAdd($caps[0][],addTaint(array('read_private_pages',false)));
}break ;
case ('unfiltered_upload'):if ( (defined(('ALLOW_UNFILTERED_UPLOADS')) && (ALLOW_UNFILTERED_UPLOADS == true)))
 arrayAssignAdd($caps[0][],addTaint($cap));
else 
{arrayAssignAdd($caps[0][],addTaint(array('do_not_allow',false)));
}break ;
default :arrayAssignAdd($caps[0][],addTaint($cap));
 }
return apply_filters(array('map_meta_cap',false),$caps,$cap,$user_id,$args);
 }
function current_user_can ( $capability ) {
$current_user = wp_get_current_user();
if ( ((empty($current_user) || Aspis_empty( $current_user))))
 return array(false,false);
$args = Aspis_array_slice(array(func_get_args(),false),array(1,false));
$args = Aspis_array_merge(array(array($capability),false),$args);
return Aspis_call_user_func_array(array(array(&$current_user,array('has_cap',false)),false),$args);
 }
function author_can ( $post,$capability ) {
if ( (denot_boolean($post = get_post($post))))
 return array(false,false);
$author = array(new WP_User($post[0]->post_author),false);
if ( ((empty($author) || Aspis_empty( $author))))
 return array(false,false);
$args = Aspis_array_slice(array(func_get_args(),false),array(2,false));
$args = Aspis_array_merge(array(array($capability),false),$args);
return Aspis_call_user_func_array(array(array(&$author,array('has_cap',false)),false),$args);
 }
function get_role ( $role ) {
global $wp_roles;
if ( (!((isset($wp_roles) && Aspis_isset( $wp_roles)))))
 $wp_roles = array(new WP_Roles(),false);
return $wp_roles[0]->get_role($role);
 }
function add_role ( $role,$display_name,$capabilities = array(array(),false) ) {
global $wp_roles;
if ( (!((isset($wp_roles) && Aspis_isset( $wp_roles)))))
 $wp_roles = array(new WP_Roles(),false);
return $wp_roles[0]->add_role($role,$display_name,$capabilities);
 }
function remove_role ( $role ) {
global $wp_roles;
if ( (!((isset($wp_roles) && Aspis_isset( $wp_roles)))))
 $wp_roles = array(new WP_Roles(),false);
return $wp_roles[0]->remove_role($role);
 }
;
?>
<?php 