<?php require_once('AspisMain.php'); ?><?php
function create_initial_post_types (  ) {
register_post_type(array('post',false),array(array('exclude_from_search' => array(false,false,false)),false));
register_post_type(array('page',false),array(array('exclude_from_search' => array(false,false,false)),false));
register_post_type(array('attachment',false),array(array('exclude_from_search' => array(false,false,false)),false));
register_post_type(array('revision',false),array(array('exclude_from_search' => array(true,false,false)),false));
 }
add_action(array('init',false),array('create_initial_post_types',false),array(0,false));
function get_attached_file ( $attachment_id,$unfiltered = array(false,false) ) {
$file = get_post_meta($attachment_id,array('_wp_attached_file',false),array(true,false));
if ( ((((0) !== strpos($file[0],'/')) && (denot_boolean(Aspis_preg_match(array('|^.:\\\|',false),$file)))) && (deAspis(($uploads = wp_upload_dir())) && (false === deAspis($uploads[0]['error'])))))
 $file = concat($uploads[0]['basedir'],concat1("/",$file));
if ( $unfiltered[0])
 return $file;
return apply_filters(array('get_attached_file',false),$file,$attachment_id);
 }
function update_attached_file ( $attachment_id,$file ) {
if ( (denot_boolean(get_post($attachment_id))))
 return array(false,false);
$file = apply_filters(array('update_attached_file',false),$file,$attachment_id);
$file = _wp_relative_upload_path($file);
return update_post_meta($attachment_id,array('_wp_attached_file',false),$file);
 }
function _wp_relative_upload_path ( $path ) {
$new_path = $path;
if ( (deAspis(($uploads = wp_upload_dir())) && (false === deAspis($uploads[0]['error']))))
 {if ( ((0) === strpos($new_path[0],deAspisRC($uploads[0]['basedir']))))
 {$new_path = Aspis_str_replace($uploads[0]['basedir'],array('',false),$new_path);
$new_path = Aspis_ltrim($new_path,array('/',false));
}}return apply_filters(array('_wp_relative_upload_path',false),$new_path,$path);
 }
function &get_children ( $args = array('',false),$output = array(OBJECT,false) ) {
$kids = array(array(),false);
if ( ((empty($args) || Aspis_empty( $args))))
 {if ( ((isset($GLOBALS[0][('post')]) && Aspis_isset( $GLOBALS [0][('post')]))))
 {$args = array(array(deregisterTaint(array('post_parent',false)) => addTaint(int_cast($GLOBALS[0][('post')][0]->post_parent))),false);
}else 
{{return $kids;
}}}elseif ( is_object($args[0]))
 {$args = array(array(deregisterTaint(array('post_parent',false)) => addTaint(int_cast($args[0]->post_parent))),false);
}elseif ( is_numeric(deAspisRC($args)))
 {$args = array(array(deregisterTaint(array('post_parent',false)) => addTaint(int_cast($args))),false);
}$defaults = array(array(deregisterTaint(array('numberposts',false)) => addTaint(negate(array(1,false))),'post_type' => array('any',false,false),'post_status' => array('any',false,false),'post_parent' => array(0,false,false),),false);
$r = wp_parse_args($args,$defaults);
$children = get_posts($r);
if ( (denot_boolean($children)))
 return $kids;
update_post_cache($children);
foreach ( $children[0] as $key =>$child )
{restoreTaint($key,$child);
$kids[0][deAspis(registerTaint($child[0]->ID))] = &addTaintR($children[0][$key[0]]);
}if ( ($output[0] == OBJECT))
 {return $kids;
}elseif ( ($output[0] == ARRAY_A))
 {foreach ( deAspis(array_cast($kids)) as $kid  )
arrayAssign($weeuns[0],deAspis(registerTaint($kid[0]->ID)),addTaint(attAspis(get_object_vars(deAspisRC(attachAspis($kids,$kid[0]->ID[0]))))));
return $weeuns;
}elseif ( ($output[0] == ARRAY_N))
 {foreach ( deAspis(array_cast($kids)) as $kid  )
arrayAssign($babes[0],deAspis(registerTaint($kid[0]->ID)),addTaint(Aspis_array_values(attAspis(get_object_vars(deAspisRC(attachAspis($kids,$kid[0]->ID[0])))))));
return $babes;
}else 
{{return $kids;
}} }
function get_extended ( $post ) {
if ( deAspis(Aspis_preg_match(array('/<!--more(.*?)?-->/',false),$post,$matches)))
 {list($main,$extended) = deAspisList(Aspis_explode(attachAspis($matches,(0)),$post,array(2,false)),array());
}else 
{{$main = $post;
$extended = array('',false);
}}$main = Aspis_preg_replace(array('/^[\s]*(.*)[\s]*$/',false),array('\\1',false),$main);
$extended = Aspis_preg_replace(array('/^[\s]*(.*)[\s]*$/',false),array('\\1',false),$extended);
return array(array(deregisterTaint(array('main',false)) => addTaint($main),deregisterTaint(array('extended',false)) => addTaint($extended)),false);
 }
function &get_post ( &$post,$output = array(OBJECT,false),$filter = array('raw',false) ) {
global $wpdb;
$null = array(null,false);
if ( ((empty($post) || Aspis_empty( $post))))
 {if ( ((isset($GLOBALS[0][('post')]) && Aspis_isset( $GLOBALS [0][('post')]))))
 $_post = &$GLOBALS[0][('post')];
else 
{return $null;
}}elseif ( (is_object($post[0]) && ((empty($post[0]->filter) || Aspis_empty( $post[0] ->filter )))))
 {_get_post_ancestors($post);
$_post = sanitize_post($post,array('raw',false));
wp_cache_add($post[0]->ID,$_post,array('posts',false));
}else 
{{if ( is_object($post[0]))
 $post = $post[0]->ID;
$post = int_cast($post);
if ( (denot_boolean($_post = wp_cache_get($post,array('posts',false)))))
 {$_post = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," WHERE ID = %d LIMIT 1"),$post));
if ( (denot_boolean($_post)))
 return $null;
_get_post_ancestors($_post);
$_post = sanitize_post($_post,array('raw',false));
wp_cache_add($_post[0]->ID,$_post,array('posts',false));
}}}if ( ($filter[0] != ('raw')))
 $_post = sanitize_post($_post,$filter);
if ( ($output[0] == OBJECT))
 {return $_post;
}elseif ( ($output[0] == ARRAY_A))
 {$__post = attAspis(get_object_vars(deAspisRC($_post)));
return $__post;
}elseif ( ($output[0] == ARRAY_N))
 {$__post = Aspis_array_values(attAspis(get_object_vars(deAspisRC($_post))));
return $__post;
}else 
{{return $_post;
}} }
function get_post_ancestors ( $post ) {
$post = get_post($post);
if ( (!((empty($post[0]->ancestors) || Aspis_empty( $post[0] ->ancestors )))))
 return $post[0]->ancestors;
return array(array(),false);
 }
function get_post_field ( $field,$post,$context = array('display',false) ) {
$post = int_cast($post);
$post = get_post($post);
if ( deAspis(is_wp_error($post)))
 return $post;
if ( (!(is_object($post[0]))))
 return array('',false);
if ( (!((isset($post[0]->$field[0]) && Aspis_isset( $post[0] ->$field[0] )))))
 return array('',false);
return sanitize_post_field($field,$post[0]->$field[0],$post[0]->ID,$context);
 }
function get_post_mime_type ( $ID = array('',false) ) {
$post = &get_post($ID);
if ( is_object($post[0]))
 return $post[0]->post_mime_type;
return array(false,false);
 }
function get_post_status ( $ID = array('',false) ) {
$post = get_post($ID);
if ( is_object($post[0]))
 {if ( (((('attachment') == $post[0]->post_type[0]) && $post[0]->post_parent[0]) && ($post[0]->ID[0] != $post[0]->post_parent[0])))
 return get_post_status($post[0]->post_parent);
else 
{return $post[0]->post_status;
}}return array(false,false);
 }
function get_post_statuses (  ) {
$status = array(array(deregisterTaint(array('draft',false)) => addTaint(__(array('Draft',false))),deregisterTaint(array('pending',false)) => addTaint(__(array('Pending Review',false))),deregisterTaint(array('private',false)) => addTaint(__(array('Private',false))),deregisterTaint(array('publish',false)) => addTaint(__(array('Published',false)))),false);
return $status;
 }
function get_page_statuses (  ) {
$status = array(array(deregisterTaint(array('draft',false)) => addTaint(__(array('Draft',false))),deregisterTaint(array('private',false)) => addTaint(__(array('Private',false))),deregisterTaint(array('publish',false)) => addTaint(__(array('Published',false)))),false);
return $status;
 }
function get_post_type ( $post = array(false,false) ) {
global $posts;
if ( (false === $post[0]))
 $post = attachAspis($posts,(0));
elseif ( deAspis(int_cast($post)))
 $post = get_post($post,array(OBJECT,false));
if ( is_object($post[0]))
 return $post[0]->post_type;
return array(false,false);
 }
function get_post_types ( $args = array(array(),false),$output = array('names',false) ) {
global $wp_post_types;
$do_names = array(false,false);
if ( (('names') == $output[0]))
 $do_names = array(true,false);
$post_types = array(array(),false);
foreach ( deAspis(array_cast($wp_post_types)) as $post_type  )
{if ( ((empty($args) || Aspis_empty( $args))))
 {if ( $do_names[0])
 arrayAssignAdd($post_types[0][],addTaint($post_type[0]->name));
else 
{arrayAssignAdd($post_types[0][],addTaint($post_type));
}}elseif ( deAspis(Aspis_array_intersect_assoc(array_cast($post_type),$args)))
 {if ( $do_names[0])
 arrayAssignAdd($post_types[0][],addTaint($post_type[0]->name));
else 
{arrayAssignAdd($post_types[0][],addTaint($post_type));
}}}return $post_types;
 }
function register_post_type ( $post_type,$args = array(array(),false) ) {
global $wp_post_types;
if ( (!(is_array($wp_post_types[0]))))
 $wp_post_types = array(array(),false);
$defaults = array(array('exclude_from_search' => array(true,false,false)),false);
$args = wp_parse_args($args,$defaults);
$post_type = sanitize_user($post_type,array(true,false));
arrayAssign($args[0],deAspis(registerTaint(array('name',false))),addTaint($post_type));
arrayAssign($wp_post_types[0],deAspis(registerTaint($post_type)),addTaint(object_cast($args)));
 }
function set_post_type ( $post_id = array(0,false),$post_type = array('post',false) ) {
global $wpdb;
$post_type = sanitize_post_field(array('post_type',false),$post_type,$post_id,array('db',false));
$return = $wpdb[0]->update($wpdb[0]->posts,array(array(deregisterTaint(array('post_type',false)) => addTaint($post_type)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($post_id)),false));
if ( (('page') == $post_type[0]))
 clean_page_cache($post_id);
else 
{clean_post_cache($post_id);
}return $return;
 }
function get_posts ( $args = array(null,false) ) {
$defaults = array(array('numberposts' => array(5,false,false),'offset' => array(0,false,false),'category' => array(0,false,false),'orderby' => array('post_date',false,false),'order' => array('DESC',false,false),'include' => array('',false,false),'exclude' => array('',false,false),'meta_key' => array('',false,false),'meta_value' => array('',false,false),'post_type' => array('post',false,false),'suppress_filters' => array(true,false,false)),false);
$r = wp_parse_args($args,$defaults);
if ( ((empty($r[0][('post_status')]) || Aspis_empty( $r [0][('post_status')]))))
 arrayAssign($r[0],deAspis(registerTaint(array('post_status',false))),addTaint((('attachment') == deAspis($r[0]['post_type'])) ? array('inherit',false) : array('publish',false)));
if ( (!((empty($r[0][('numberposts')]) || Aspis_empty( $r [0][('numberposts')])))))
 arrayAssign($r[0],deAspis(registerTaint(array('posts_per_page',false))),addTaint($r[0]['numberposts']));
if ( (!((empty($r[0][('category')]) || Aspis_empty( $r [0][('category')])))))
 arrayAssign($r[0],deAspis(registerTaint(array('cat',false))),addTaint($r[0]['category']));
if ( (!((empty($r[0][('include')]) || Aspis_empty( $r [0][('include')])))))
 {$incposts = Aspis_preg_split(array('/[\s,]+/',false),$r[0]['include']);
arrayAssign($r[0],deAspis(registerTaint(array('posts_per_page',false))),addTaint(attAspis(count($incposts[0]))));
arrayAssign($r[0],deAspis(registerTaint(array('post__in',false))),addTaint($incposts));
}elseif ( (!((empty($r[0][('exclude')]) || Aspis_empty( $r [0][('exclude')])))))
 arrayAssign($r[0],deAspis(registerTaint(array('post__not_in',false))),addTaint(Aspis_preg_split(array('/[\s,]+/',false),$r[0]['exclude'])));
arrayAssign($r[0],deAspis(registerTaint(array('caller_get_posts',false))),addTaint(array(true,false)));
$get_posts = array(new WP_Query,false);
return $get_posts[0]->query($r);
 }
function add_post_meta ( $post_id,$meta_key,$meta_value,$unique = array(false,false) ) {
if ( deAspis($the_post = wp_is_post_revision($post_id)))
 $post_id = $the_post;
return add_metadata(array('post',false),$post_id,$meta_key,$meta_value,$unique);
 }
function delete_post_meta ( $post_id,$meta_key,$meta_value = array('',false) ) {
if ( deAspis($the_post = wp_is_post_revision($post_id)))
 $post_id = $the_post;
return delete_metadata(array('post',false),$post_id,$meta_key,$meta_value);
 }
function get_post_meta ( $post_id,$key,$single = array(false,false) ) {
return get_metadata(array('post',false),$post_id,$key,$single);
 }
function update_post_meta ( $post_id,$meta_key,$meta_value,$prev_value = array('',false) ) {
if ( deAspis($the_post = wp_is_post_revision($post_id)))
 $post_id = $the_post;
return update_metadata(array('post',false),$post_id,$meta_key,$meta_value,$prev_value);
 }
function delete_post_meta_by_key ( $post_meta_key ) {
if ( (denot_boolean($post_meta_key)))
 return array(false,false);
global $wpdb;
$post_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT DISTINCT post_id FROM ",$wpdb[0]->postmeta)," WHERE meta_key = %s"),$post_meta_key));
if ( $post_ids[0])
 {$postmetaids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT meta_id FROM ",$wpdb[0]->postmeta)," WHERE meta_key = %s"),$post_meta_key));
$in = Aspis_implode(array(',',false),Aspis_array_fill(array(1,false),attAspis(count($postmetaids[0])),array('%d',false)));
do_action(array('delete_postmeta',false),$postmetaids);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat(concat2(concat1("DELETE FROM ",$wpdb[0]->postmeta)," WHERE meta_id IN("),$in),")"),$postmetaids));
do_action(array('deleted_postmeta',false),$postmetaids);
foreach ( $post_ids[0] as $post_id  )
wp_cache_delete($post_id,array('post_meta',false));
return array(true,false);
}return array(false,false);
 }
function get_post_custom ( $post_id = array(0,false) ) {
global $id;
if ( (denot_boolean($post_id)))
 $post_id = int_cast($id);
$post_id = int_cast($post_id);
if ( (denot_boolean(wp_cache_get($post_id,array('post_meta',false)))))
 update_postmeta_cache($post_id);
return wp_cache_get($post_id,array('post_meta',false));
 }
function get_post_custom_keys ( $post_id = array(0,false) ) {
$custom = get_post_custom($post_id);
if ( (!(is_array($custom[0]))))
 return ;
if ( deAspis($keys = attAspisRC(array_keys(deAspisRC($custom)))))
 return $keys;
 }
function get_post_custom_values ( $key = array('',false),$post_id = array(0,false) ) {
if ( (denot_boolean($key)))
 return array(null,false);
$custom = get_post_custom($post_id);
return ((isset($custom[0][$key[0]]) && Aspis_isset( $custom [0][$key[0]]))) ? attachAspis($custom,$key[0]) : array(null,false);
 }
function is_sticky ( $post_id = array(null,false) ) {
global $id;
$post_id = absint($post_id);
if ( (denot_boolean($post_id)))
 $post_id = absint($id);
$stickies = get_option(array('sticky_posts',false));
if ( (!(is_array($stickies[0]))))
 return array(false,false);
if ( deAspis(Aspis_in_array($post_id,$stickies)))
 return array(true,false);
return array(false,false);
 }
function sanitize_post ( $post,$context = array('display',false) ) {
if ( is_object($post[0]))
 {if ( (((isset($post[0]->filter) && Aspis_isset( $post[0] ->filter ))) && ($context[0] == $post[0]->filter[0])))
 return $post;
if ( (!((isset($post[0]->ID) && Aspis_isset( $post[0] ->ID )))))
 $post[0]->ID = array(0,false);
foreach ( deAspis(attAspisRC(array_keys(deAspisRC(attAspis(get_object_vars(deAspisRC($post))))))) as $field  )
$post[0]->$field[0] = sanitize_post_field($field,$post[0]->$field[0],$post[0]->ID,$context);
$post[0]->filter = $context;
}else 
{{if ( (((isset($post[0][('filter')]) && Aspis_isset( $post [0][('filter')]))) && ($context[0] == deAspis($post[0]['filter']))))
 return $post;
if ( (!((isset($post[0][('ID')]) && Aspis_isset( $post [0][('ID')])))))
 arrayAssign($post[0],deAspis(registerTaint(array('ID',false))),addTaint(array(0,false)));
foreach ( deAspis(attAspisRC(array_keys(deAspisRC($post)))) as $field  )
arrayAssign($post[0],deAspis(registerTaint($field)),addTaint(sanitize_post_field($field,attachAspis($post,$field[0]),$post[0]['ID'],$context)));
arrayAssign($post[0],deAspis(registerTaint(array('filter',false))),addTaint($context));
}}return $post;
 }
function sanitize_post_field ( $field,$value,$post_id,$context ) {
$int_fields = array(array(array('ID',false),array('post_parent',false),array('menu_order',false)),false);
if ( deAspis(Aspis_in_array($field,$int_fields)))
 $value = int_cast($value);
if ( (('raw') == $context[0]))
 return $value;
$prefixed = array(false,false);
if ( (false !== strpos($field[0],'post_')))
 {$prefixed = array(true,false);
$field_no_prefix = Aspis_str_replace(array('post_',false),array('',false),$field);
}if ( (('edit') == $context[0]))
 {$format_to_edit = array(array(array('post_content',false),array('post_excerpt',false),array('post_title',false),array('post_password',false)),false);
if ( $prefixed[0])
 {$value = apply_filters(concat1("edit_",$field),$value,$post_id);
$value = apply_filters(concat2($field_no_prefix,"_edit_pre"),$value,$post_id);
}else 
{{$value = apply_filters(concat1("edit_post_",$field),$value,$post_id);
}}if ( deAspis(Aspis_in_array($field,$format_to_edit)))
 {if ( (('post_content') == $field[0]))
 $value = format_to_edit($value,user_can_richedit());
else 
{$value = format_to_edit($value);
}}else 
{{$value = esc_attr($value);
}}}else 
{if ( (('db') == $context[0]))
 {if ( $prefixed[0])
 {$value = apply_filters(concat1("pre_",$field),$value);
$value = apply_filters(concat2($field_no_prefix,"_save_pre"),$value);
}else 
{{$value = apply_filters(concat1("pre_post_",$field),$value);
$value = apply_filters(concat2($field,"_pre"),$value);
}}}else 
{{if ( $prefixed[0])
 $value = apply_filters($field,$value,$post_id,$context);
else 
{$value = apply_filters(concat1("post_",$field),$value,$post_id,$context);
}}}}if ( (('attribute') == $context[0]))
 $value = esc_attr($value);
else 
{if ( (('js') == $context[0]))
 $value = esc_js($value);
}return $value;
 }
function stick_post ( $post_id ) {
$stickies = get_option(array('sticky_posts',false));
if ( (!(is_array($stickies[0]))))
 $stickies = array(array($post_id),false);
if ( (denot_boolean(Aspis_in_array($post_id,$stickies))))
 arrayAssignAdd($stickies[0][],addTaint($post_id));
update_option(array('sticky_posts',false),$stickies);
 }
function unstick_post ( $post_id ) {
$stickies = get_option(array('sticky_posts',false));
if ( (!(is_array($stickies[0]))))
 return ;
if ( (denot_boolean(Aspis_in_array($post_id,$stickies))))
 return ;
$offset = Aspis_array_search($post_id,$stickies);
if ( (false === $offset[0]))
 return ;
Aspis_array_splice($stickies,$offset,array(1,false));
update_option(array('sticky_posts',false),$stickies);
 }
function wp_count_posts ( $type = array('post',false),$perm = array('',false) ) {
global $wpdb;
$user = wp_get_current_user();
$cache_key = $type;
$query = concat2(concat1("SELECT post_status, COUNT( * ) AS num_posts FROM ",$wpdb[0]->posts)," WHERE post_type = %s");
if ( ((('readable') == $perm[0]) && deAspis(is_user_logged_in())))
 {if ( (denot_boolean(current_user_can(concat2(concat1("read_private_",$type),"s")))))
 {$cache_key = concat($cache_key,concat(concat2(concat1('_',$perm),'_'),$user[0]->ID));
$query = concat($query,concat2(concat1(" AND (post_status != 'private' OR ( post_author = '",$user[0]->ID),"' AND post_status = 'private' ))"));
}}$query = concat2($query,' GROUP BY post_status');
$count = wp_cache_get($cache_key,array('counts',false));
if ( (false !== $count[0]))
 return $count;
$count = $wpdb[0]->get_results($wpdb[0]->prepare($query,$type),array(ARRAY_A,false));
$stats = array(array('publish' => array(0,false,false),'private' => array(0,false,false),'draft' => array(0,false,false),'pending' => array(0,false,false),'future' => array(0,false,false),'trash' => array(0,false,false)),false);
foreach ( deAspis(array_cast($count)) as $row_num =>$row )
{restoreTaint($row_num,$row);
{arrayAssign($stats[0],deAspis(registerTaint($row[0]['post_status'])),addTaint($row[0]['num_posts']));
}}$stats = object_cast($stats);
wp_cache_set($cache_key,$stats,array('counts',false));
return $stats;
 }
function wp_count_attachments ( $mime_type = array('',false) ) {
global $wpdb;
$and = wp_post_mime_type_where($mime_type);
$count = $wpdb[0]->get_results(concat2(concat(concat2(concat1("SELECT post_mime_type, COUNT( * ) AS num_posts FROM ",$wpdb[0]->posts)," WHERE post_type = 'attachment' AND post_status != 'trash' "),$and)," GROUP BY post_mime_type"),array(ARRAY_A,false));
$stats = array(array(),false);
foreach ( deAspis(array_cast($count)) as $row  )
{arrayAssign($stats[0],deAspis(registerTaint($row[0]['post_mime_type'])),addTaint($row[0]['num_posts']));
}arrayAssign($stats[0],deAspis(registerTaint(array('trash',false))),addTaint($wpdb[0]->get_var(concat(concat2(concat1("SELECT COUNT( * ) FROM ",$wpdb[0]->posts)," WHERE post_type = 'attachment' AND post_status = 'trash' "),$and))));
return object_cast($stats);
 }
function wp_match_mime_types ( $wildcard_mime_types,$real_mime_types ) {
$matches = array(array(),false);
if ( is_string(deAspisRC($wildcard_mime_types)))
 $wildcard_mime_types = attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC(Aspis_explode(array(',',false),$wildcard_mime_types))));
if ( is_string(deAspisRC($real_mime_types)))
 $real_mime_types = attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC(Aspis_explode(array(',',false),$real_mime_types))));
$wild = array('[-._a-z0-9]*',false);
foreach ( deAspis(array_cast($wildcard_mime_types)) as $type  )
{$type = Aspis_str_replace(array('*',false),$wild,$type);
arrayAssign($patternses[0][(1)][0],deAspis(registerTaint($type)),addTaint(concat2(concat1("^",$type),"$")));
if ( (false === strpos($type[0],'/')))
 {arrayAssign($patternses[0][(2)][0],deAspis(registerTaint($type)),addTaint(concat2(concat1("^",$type),"/")));
arrayAssign($patternses[0][(3)][0],deAspis(registerTaint($type)),addTaint($type));
}}AspisInternalFunctionCall("asort",AspisPushRefParam($patternses),array(0));
foreach ( $patternses[0] as $patterns  )
foreach ( $patterns[0] as $type =>$pattern )
{restoreTaint($type,$pattern);
foreach ( deAspis(array_cast($real_mime_types)) as $real  )
if ( (deAspis(Aspis_preg_match(concat2(concat1("#",$pattern),"#"),$real)) && (((empty($matches[0][$type[0]]) || Aspis_empty( $matches [0][$type[0]]))) || (false === deAspis(Aspis_array_search($real,attachAspis($matches,$type[0])))))))
 arrayAssignAdd($matches[0][$type[0]][0][],addTaint($real));
}return $matches;
 }
function wp_post_mime_type_where ( $post_mime_types ) {
$where = array('',false);
$wildcards = array(array(array('',false),array('%',false),array('%/%',false)),false);
if ( is_string(deAspisRC($post_mime_types)))
 $post_mime_types = attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC(Aspis_explode(array(',',false),$post_mime_types))));
foreach ( deAspis(array_cast($post_mime_types)) as $mime_type  )
{$mime_type = Aspis_preg_replace(array('/\s/',false),array('',false),$mime_type);
$slashpos = attAspis(strpos($mime_type[0],'/'));
if ( (false !== $slashpos[0]))
 {$mime_group = Aspis_preg_replace(array('/[^-*.a-zA-Z0-9]/',false),array('',false),Aspis_substr($mime_type,array(0,false),$slashpos));
$mime_subgroup = Aspis_preg_replace(array('/[^-*.+a-zA-Z0-9]/',false),array('',false),Aspis_substr($mime_type,array($slashpos[0] + (1),false)));
if ( ((empty($mime_subgroup) || Aspis_empty( $mime_subgroup))))
 $mime_subgroup = array('*',false);
else 
{$mime_subgroup = Aspis_str_replace(array('/',false),array('',false),$mime_subgroup);
}$mime_pattern = concat(concat2($mime_group,"/"),$mime_subgroup);
}else 
{{$mime_pattern = Aspis_preg_replace(array('/[^-*.a-zA-Z0-9]/',false),array('',false),$mime_type);
if ( (false === strpos($mime_pattern[0],'*')))
 $mime_pattern = concat2($mime_pattern,'/*');
}}$mime_pattern = Aspis_preg_replace(array('/\*+/',false),array('%',false),$mime_pattern);
if ( deAspis(Aspis_in_array($mime_type,$wildcards)))
 return array('',false);
if ( (false !== strpos($mime_pattern[0],'%')))
 arrayAssignAdd($wheres[0][],addTaint(concat2(concat1("post_mime_type LIKE '",$mime_pattern),"'")));
else 
{arrayAssignAdd($wheres[0][],addTaint(concat2(concat1("post_mime_type = '",$mime_pattern),"'")));
}}if ( (!((empty($wheres) || Aspis_empty( $wheres)))))
 $where = concat2(concat1(' AND (',Aspis_join(array(' OR ',false),$wheres)),') ');
return $where;
 }
function wp_delete_post ( $postid = array(0,false),$force_delete = array(false,false) ) {
global $wpdb,$wp_rewrite;
if ( (denot_boolean($post = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$postid)))))
 return $post;
if ( ((((denot_boolean($force_delete)) && (($post[0]->post_type[0] == ('post')) || ($post[0]->post_type[0] == ('page')))) && (deAspis(get_post_status($postid)) != ('trash'))) && (EMPTY_TRASH_DAYS > (0))))
 return wp_trash_post($postid);
if ( ($post[0]->post_type[0] == ('attachment')))
 return wp_delete_attachment($postid,$force_delete);
do_action(array('delete_post',false),$postid);
delete_post_meta($postid,array('_wp_trash_meta_status',false));
delete_post_meta($postid,array('_wp_trash_meta_time',false));
wp_delete_object_term_relationships($postid,get_object_taxonomies($post[0]->post_type));
$parent_data = array(array(deregisterTaint(array('post_parent',false)) => addTaint($post[0]->post_parent)),false);
$parent_where = array(array(deregisterTaint(array('post_parent',false)) => addTaint($postid)),false);
if ( (('page') == $post[0]->post_type[0]))
 {if ( (deAspis(get_option(array('page_on_front',false))) == $postid[0]))
 {update_option(array('show_on_front',false),array('posts',false));
delete_option(array('page_on_front',false));
}if ( (deAspis(get_option(array('page_for_posts',false))) == $postid[0]))
 {delete_option(array('page_for_posts',false));
}$children_query = $wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," WHERE post_parent = %d AND post_type='page'"),$postid);
$children = $wpdb[0]->get_results($children_query);
$wpdb[0]->update($wpdb[0]->posts,$parent_data,array($parent_where[0] + (array('post_type' => array('page',false,false))),false));
}else 
{{unstick_post($postid);
}}$revision_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_parent = %d AND post_type = 'revision'"),$postid));
foreach ( $revision_ids[0] as $revision_id  )
wp_delete_post_revision($revision_id);
$wpdb[0]->update($wpdb[0]->posts,$parent_data,array($parent_where[0] + (array('post_type' => array('attachment',false,false))),false));
$comment_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT comment_ID FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d"),$postid));
if ( (!((empty($comment_ids) || Aspis_empty( $comment_ids)))))
 {do_action(array('delete_comment',false),$comment_ids);
$in_comment_ids = concat2(concat1("'",Aspis_implode(array("', '",false),$comment_ids)),"'");
$wpdb[0]->query(concat2(concat(concat2(concat1("DELETE FROM ",$wpdb[0]->comments)," WHERE comment_ID IN("),$in_comment_ids),")"));
do_action(array('deleted_comment',false),$comment_ids);
}$post_meta_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT meta_id FROM ",$wpdb[0]->postmeta)," WHERE post_id = %d "),$postid));
if ( (!((empty($post_meta_ids) || Aspis_empty( $post_meta_ids)))))
 {do_action(array('delete_postmeta',false),$post_meta_ids);
$in_post_meta_ids = concat2(concat1("'",Aspis_implode(array("', '",false),$post_meta_ids)),"'");
$wpdb[0]->query(concat2(concat(concat2(concat1("DELETE FROM ",$wpdb[0]->postmeta)," WHERE meta_id IN("),$in_post_meta_ids),")"));
do_action(array('deleted_postmeta',false),$post_meta_ids);
}do_action(array('delete_post',false),$postid);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$postid));
do_action(array('deleted_post',false),$postid);
if ( (('page') == $post[0]->post_type[0]))
 {clean_page_cache($postid);
foreach ( deAspis(array_cast($children)) as $child  )
clean_page_cache($child[0]->ID);
$wp_rewrite[0]->flush_rules(array(false,false));
}else 
{{clean_post_cache($postid);
}}wp_clear_scheduled_hook(array('publish_future_post',false),$postid);
do_action(array('deleted_post',false),$postid);
return $post;
 }
function wp_trash_post ( $post_id = array(0,false) ) {
if ( (EMPTY_TRASH_DAYS == (0)))
 return wp_delete_post($post_id);
if ( (denot_boolean($post = wp_get_single_post($post_id,array(ARRAY_A,false)))))
 return $post;
if ( (deAspis($post[0]['post_status']) == ('trash')))
 return array(false,false);
do_action(array('trash_post',false),$post_id);
add_post_meta($post_id,array('_wp_trash_meta_status',false),$post[0]['post_status']);
add_post_meta($post_id,array('_wp_trash_meta_time',false),attAspis(time()));
arrayAssign($post[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('trash',false)));
wp_insert_post($post);
wp_trash_post_comments($post_id);
do_action(array('trashed_post',false),$post_id);
return $post;
 }
function wp_untrash_post ( $post_id = array(0,false) ) {
if ( (denot_boolean($post = wp_get_single_post($post_id,array(ARRAY_A,false)))))
 return $post;
if ( (deAspis($post[0]['post_status']) != ('trash')))
 return array(false,false);
do_action(array('untrash_post',false),$post_id);
$post_status = get_post_meta($post_id,array('_wp_trash_meta_status',false),array(true,false));
arrayAssign($post[0],deAspis(registerTaint(array('post_status',false))),addTaint($post_status));
delete_post_meta($post_id,array('_wp_trash_meta_status',false));
delete_post_meta($post_id,array('_wp_trash_meta_time',false));
wp_insert_post($post);
wp_untrash_post_comments($post_id);
do_action(array('untrashed_post',false),$post_id);
return $post;
 }
function wp_trash_post_comments ( $post = array(null,false) ) {
global $wpdb;
$post = get_post($post);
if ( ((empty($post) || Aspis_empty( $post))))
 return ;
$post_id = $post[0]->ID;
do_action(array('trash_post_comments',false),$post_id);
$comments = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT comment_ID, comment_approved FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d"),$post_id));
if ( ((empty($comments) || Aspis_empty( $comments))))
 return ;
$statuses = array(array(),false);
foreach ( $comments[0] as $comment  )
arrayAssign($statuses[0],deAspis(registerTaint($comment[0]->comment_ID)),addTaint($comment[0]->comment_approved));
add_post_meta($post_id,array('_wp_trash_meta_comments_status',false),$statuses);
$result = $wpdb[0]->update($wpdb[0]->comments,array(array('comment_approved' => array('post-trashed',false,false)),false),array(array(deregisterTaint(array('comment_post_ID',false)) => addTaint($post_id)),false));
clean_comment_cache(attAspisRC(array_keys(deAspisRC($statuses))));
do_action(array('trashed_post_comments',false),$post_id,$statuses);
return $result;
 }
function wp_untrash_post_comments ( $post = array(null,false) ) {
global $wpdb;
$post = get_post($post);
if ( ((empty($post) || Aspis_empty( $post))))
 return ;
$post_id = $post[0]->ID;
$statuses = get_post_meta($post_id,array('_wp_trash_meta_comments_status',false),array(true,false));
if ( ((empty($statuses) || Aspis_empty( $statuses))))
 return array(true,false);
do_action(array('untrash_post_comments',false),$post_id);
$group_by_status = array(array(),false);
foreach ( $statuses[0] as $comment_id =>$comment_status )
{restoreTaint($comment_id,$comment_status);
arrayAssignAdd($group_by_status[0][$comment_status[0]][0][],addTaint($comment_id));
}foreach ( $group_by_status[0] as $status =>$comments )
{restoreTaint($status,$comments);
{if ( (('post-trashed') == $status[0]))
 $status = array('0',false);
$comments_in = Aspis_implode(array("', '",false),$comments);
$wpdb[0]->query(concat2(concat(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->comments)," SET comment_approved = '"),$status),"' WHERE comment_ID IN ('"),$comments_in),"')"));
}}clean_comment_cache(attAspisRC(array_keys(deAspisRC($statuses))));
delete_post_meta($post_id,array('_wp_trash_meta_comments_status',false));
do_action(array('untrashed_post_comments',false),$post_id);
 }
function wp_get_post_categories ( $post_id = array(0,false),$args = array(array(),false) ) {
$post_id = int_cast($post_id);
$defaults = array(array('fields' => array('ids',false,false)),false);
$args = wp_parse_args($args,$defaults);
$cats = wp_get_object_terms($post_id,array('category',false),$args);
return $cats;
 }
function wp_get_post_tags ( $post_id = array(0,false),$args = array(array(),false) ) {
return wp_get_post_terms($post_id,array('post_tag',false),$args);
 }
function wp_get_post_terms ( $post_id = array(0,false),$taxonomy = array('post_tag',false),$args = array(array(),false) ) {
$post_id = int_cast($post_id);
$defaults = array(array('fields' => array('all',false,false)),false);
$args = wp_parse_args($args,$defaults);
$tags = wp_get_object_terms($post_id,$taxonomy,$args);
return $tags;
 }
function wp_get_recent_posts ( $num = array(10,false) ) {
global $wpdb;
$num = int_cast($num);
if ( $num[0])
 {$limit = concat1("LIMIT ",$num);
}$sql = concat(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," WHERE post_type = 'post' AND post_status IN ( 'draft', 'publish', 'future', 'pending', 'private' ) ORDER BY post_date DESC "),$limit);
$result = $wpdb[0]->get_results($sql,array(ARRAY_A,false));
return $result[0] ? $result : array(array(),false);
 }
function wp_get_single_post ( $postid = array(0,false),$mode = array(OBJECT,false) ) {
$postid = int_cast($postid);
$post = get_post($postid,$mode);
if ( ($mode[0] == OBJECT))
 {$post[0]->post_category = wp_get_post_categories($postid);
$post[0]->tags_input = wp_get_post_tags($postid,array(array('fields' => array('names',false,false)),false));
}else 
{{arrayAssign($post[0],deAspis(registerTaint(array('post_category',false))),addTaint(wp_get_post_categories($postid)));
arrayAssign($post[0],deAspis(registerTaint(array('tags_input',false))),addTaint(wp_get_post_tags($postid,array(array('fields' => array('names',false,false)),false))));
}}return $post;
 }
function wp_insert_post ( $postarr = array(array(),false),$wp_error = array(false,false) ) {
global $wpdb,$wp_rewrite,$user_ID;
$defaults = array(array('post_status' => array('draft',false,false),'post_type' => array('post',false,false),deregisterTaint(array('post_author',false)) => addTaint($user_ID),deregisterTaint(array('ping_status',false)) => addTaint(get_option(array('default_ping_status',false))),'post_parent' => array(0,false,false),'menu_order' => array(0,false,false),'to_ping' => array('',false,false),'pinged' => array('',false,false),'post_password' => array('',false,false),'guid' => array('',false,false),'post_content_filtered' => array('',false,false),'post_excerpt' => array('',false,false),'import_id' => array(0,false,false)),false);
$postarr = wp_parse_args($postarr,$defaults);
$postarr = sanitize_post($postarr,array('db',false));
extract(($postarr[0]),EXTR_SKIP);
$update = array(false,false);
if ( (!((empty($ID) || Aspis_empty( $ID)))))
 {$update = array(true,false);
$previous_status = get_post_field(array('post_status',false),$ID);
}else 
{{$previous_status = array('new',false);
}}if ( ((((('') == $post_content[0]) && (('') == $post_title[0])) && (('') == $post_excerpt[0])) && (('attachment') != $post_type[0])))
 {if ( $wp_error[0])
 return array(new WP_Error(array('empty_content',false),__(array('Content, title, and excerpt are empty.',false))),false);
else 
{return array(0,false);
}}if ( ((((empty($post_category) || Aspis_empty( $post_category))) || ((0) == count($post_category[0]))) || (!(is_array($post_category[0])))))
 {$post_category = array(array(get_option(array('default_category',false))),false);
}if ( (!((isset($tags_input) && Aspis_isset( $tags_input)))))
 $tags_input = array(array(),false);
if ( ((empty($post_author) || Aspis_empty( $post_author))))
 $post_author = $user_ID;
if ( ((empty($post_status) || Aspis_empty( $post_status))))
 $post_status = array('draft',false);
if ( ((empty($post_type) || Aspis_empty( $post_type))))
 $post_type = array('post',false);
$post_ID = array(0,false);
if ( $update[0])
 {$post_ID = int_cast($ID);
$guid = get_post_field(array('guid',false),$post_ID);
}if ( ((('pending') == $post_status[0]) && (denot_boolean(current_user_can(array('publish_posts',false))))))
 $post_name = array('',false);
if ( ((!((isset($post_name) && Aspis_isset( $post_name)))) || ((empty($post_name) || Aspis_empty( $post_name)))))
 {if ( (denot_boolean(Aspis_in_array($post_status,array(array(array('draft',false),array('pending',false)),false)))))
 $post_name = sanitize_title($post_title);
else 
{$post_name = array('',false);
}}else 
{{$post_name = sanitize_title($post_name);
}}if ( (((empty($post_date) || Aspis_empty( $post_date))) || (('0000-00-00 00:00:00') == $post_date[0])))
 $post_date = current_time(array('mysql',false));
if ( (((empty($post_date_gmt) || Aspis_empty( $post_date_gmt))) || (('0000-00-00 00:00:00') == $post_date_gmt[0])))
 {if ( (denot_boolean(Aspis_in_array($post_status,array(array(array('draft',false),array('pending',false)),false)))))
 $post_date_gmt = get_gmt_from_date($post_date);
else 
{$post_date_gmt = array('0000-00-00 00:00:00',false);
}}if ( ($update[0] || (('0000-00-00 00:00:00') == $post_date[0])))
 {$post_modified = current_time(array('mysql',false));
$post_modified_gmt = current_time(array('mysql',false),array(1,false));
}else 
{{$post_modified = $post_date;
$post_modified_gmt = $post_date_gmt;
}}if ( (('publish') == $post_status[0]))
 {$now = attAspis(gmdate(('Y-m-d H:i:59')));
if ( (deAspis(mysql2date(array('U',false),$post_date_gmt,array(false,false))) > deAspis(mysql2date(array('U',false),$now,array(false,false)))))
 $post_status = array('future',false);
}if ( ((empty($comment_status) || Aspis_empty( $comment_status))))
 {if ( $update[0])
 $comment_status = array('closed',false);
else 
{$comment_status = get_option(array('default_comment_status',false));
}}if ( ((empty($ping_status) || Aspis_empty( $ping_status))))
 $ping_status = get_option(array('default_ping_status',false));
if ( ((isset($to_ping) && Aspis_isset( $to_ping))))
 $to_ping = Aspis_preg_replace(array('|\s+|',false),array("\n",false),$to_ping);
else 
{$to_ping = array('',false);
}if ( (!((isset($pinged) && Aspis_isset( $pinged)))))
 $pinged = array('',false);
if ( ((isset($post_parent) && Aspis_isset( $post_parent))))
 $post_parent = int_cast($post_parent);
else 
{$post_parent = array(0,false);
}if ( (!((empty($post_ID) || Aspis_empty( $post_ID)))))
 {if ( ($post_parent[0] == $post_ID[0]))
 {$post_parent = array(0,false);
}elseif ( (!((empty($post_parent) || Aspis_empty( $post_parent)))))
 {$parent_post = get_post($post_parent);
if ( ($parent_post[0]->post_parent[0] == $post_ID[0]))
 $post_parent = array(0,false);
}}if ( ((isset($menu_order) && Aspis_isset( $menu_order))))
 $menu_order = int_cast($menu_order);
else 
{$menu_order = array(0,false);
}if ( ((!((isset($post_password) && Aspis_isset( $post_password)))) || (('private') == $post_status[0])))
 $post_password = array('',false);
$post_name = wp_unique_post_slug($post_name,$post_ID,$post_status,$post_type,$post_parent);
$data = array(compact(deAspisRC(array(array(array('post_author',false),array('post_date',false),array('post_date_gmt',false),array('post_content',false),array('post_content_filtered',false),array('post_title',false),array('post_excerpt',false),array('post_status',false),array('post_type',false),array('comment_status',false),array('ping_status',false),array('post_password',false),array('post_name',false),array('to_ping',false),array('pinged',false),array('post_modified',false),array('post_modified_gmt',false),array('post_parent',false),array('menu_order',false),array('guid',false)),false))),false);
$data = apply_filters(array('wp_insert_post_data',false),$data,$postarr);
$data = stripslashes_deep($data);
$where = array(array(deregisterTaint(array('ID',false)) => addTaint($post_ID)),false);
if ( $update[0])
 {do_action(array('pre_post_update',false),$post_ID);
if ( (false === deAspis($wpdb[0]->update($wpdb[0]->posts,$data,$where))))
 {if ( $wp_error[0])
 return array(new WP_Error(array('db_update_error',false),__(array('Could not update post in the database',false)),$wpdb[0]->last_error),false);
else 
{return array(0,false);
}}}else 
{{if ( ((isset($post_mime_type) && Aspis_isset( $post_mime_type))))
 arrayAssign($data[0],deAspis(registerTaint(array('post_mime_type',false))),addTaint(Aspis_stripslashes($post_mime_type)));
if ( (!((empty($import_id) || Aspis_empty( $import_id)))))
 {$import_id = int_cast($import_id);
if ( (denot_boolean($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$import_id)))))
 {arrayAssign($data[0],deAspis(registerTaint(array('ID',false))),addTaint($import_id));
}}if ( (false === deAspis($wpdb[0]->insert($wpdb[0]->posts,$data))))
 {if ( $wp_error[0])
 return array(new WP_Error(array('db_insert_error',false),__(array('Could not insert post into the database',false)),$wpdb[0]->last_error),false);
else 
{return array(0,false);
}}$post_ID = int_cast($wpdb[0]->insert_id);
$where = array(array(deregisterTaint(array('ID',false)) => addTaint($post_ID)),false);
}}if ( (((empty($data[0][('post_name')]) || Aspis_empty( $data [0][('post_name')]))) && (denot_boolean(Aspis_in_array($data[0]['post_status'],array(array(array('draft',false),array('pending',false)),false))))))
 {arrayAssign($data[0],deAspis(registerTaint(array('post_name',false))),addTaint(sanitize_title($data[0]['post_title'],$post_ID)));
$wpdb[0]->update($wpdb[0]->posts,array(array(deregisterTaint(array('post_name',false)) => addTaint($data[0]['post_name'])),false),$where);
}wp_set_post_categories($post_ID,$post_category);
if ( (!((empty($tags_input) || Aspis_empty( $tags_input)))))
 wp_set_post_tags($post_ID,$tags_input);
if ( (!((empty($tax_input) || Aspis_empty( $tax_input)))))
 {foreach ( $tax_input[0] as $taxonomy =>$tags )
{restoreTaint($taxonomy,$tags);
{wp_set_post_terms($post_ID,$tags,$taxonomy);
}}}$current_guid = get_post_field(array('guid',false),$post_ID);
if ( (('page') == deAspis($data[0]['post_type'])))
 clean_page_cache($post_ID);
else 
{clean_post_cache($post_ID);
}if ( ((denot_boolean($update)) && (('') == $current_guid[0])))
 $wpdb[0]->update($wpdb[0]->posts,array(array(deregisterTaint(array('guid',false)) => addTaint(get_permalink($post_ID))),false),$where);
$post = get_post($post_ID);
if ( ((!((empty($page_template) || Aspis_empty( $page_template)))) && (('page') == deAspis($data[0]['post_type']))))
 {$post[0]->page_template = $page_template;
$page_templates = get_page_templates();
if ( ((('default') != $page_template[0]) && (denot_boolean(Aspis_in_array($page_template,$page_templates)))))
 {if ( $wp_error[0])
 return array(new WP_Error(array('invalid_page_template',false),__(array('The page template is invalid.',false))),false);
else 
{return array(0,false);
}}update_post_meta($post_ID,array('_wp_page_template',false),$page_template);
}wp_transition_post_status($data[0]['post_status'],$previous_status,$post);
if ( $update[0])
 do_action(array('edit_post',false),$post_ID,$post);
do_action(array('save_post',false),$post_ID,$post);
do_action(array('wp_insert_post',false),$post_ID,$post);
return $post_ID;
 }
function wp_update_post ( $postarr = array(array(),false) ) {
if ( is_object($postarr[0]))
 {$postarr = attAspis(get_object_vars(deAspisRC($postarr)));
$postarr = add_magic_quotes($postarr);
}$post = wp_get_single_post($postarr[0]['ID'],array(ARRAY_A,false));
$post = add_magic_quotes($post);
if ( ((((isset($postarr[0][('post_category')]) && Aspis_isset( $postarr [0][('post_category')]))) && is_array(deAspis($postarr[0]['post_category']))) && ((0) != count(deAspis($postarr[0]['post_category'])))))
 $post_cats = $postarr[0]['post_category'];
else 
{$post_cats = $post[0]['post_category'];
}if ( ((deAspis(Aspis_in_array($post[0]['post_status'],array(array(array('draft',false),array('pending',false)),false))) && ((empty($postarr[0][('edit_date')]) || Aspis_empty( $postarr [0][('edit_date')])))) && (('0000-00-00 00:00:00') == deAspis($post[0]['post_date_gmt']))))
 $clear_date = array(true,false);
else 
{$clear_date = array(false,false);
}$postarr = Aspis_array_merge($post,$postarr);
arrayAssign($postarr[0],deAspis(registerTaint(array('post_category',false))),addTaint($post_cats));
if ( $clear_date[0])
 {arrayAssign($postarr[0],deAspis(registerTaint(array('post_date',false))),addTaint(current_time(array('mysql',false))));
arrayAssign($postarr[0],deAspis(registerTaint(array('post_date_gmt',false))),addTaint(array('',false)));
}if ( (deAspis($postarr[0]['post_type']) == ('attachment')))
 return wp_insert_attachment($postarr);
return wp_insert_post($postarr);
 }
function wp_publish_post ( $post_id ) {
global $wpdb;
$post = get_post($post_id);
if ( ((empty($post) || Aspis_empty( $post))))
 return ;
if ( (('publish') == $post[0]->post_status[0]))
 return ;
$wpdb[0]->update($wpdb[0]->posts,array(array('post_status' => array('publish',false,false)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($post_id)),false));
$old_status = $post[0]->post_status;
$post[0]->post_status = array('publish',false);
wp_transition_post_status(array('publish',false),$old_status,$post);
foreach ( deAspis(array_cast(get_object_taxonomies(array('post',false)))) as $taxonomy  )
{$tt_ids = wp_get_object_terms($post_id,$taxonomy,array('fields=tt_ids',false));
wp_update_term_count($tt_ids,$taxonomy);
}do_action(array('edit_post',false),$post_id,$post);
do_action(array('save_post',false),$post_id,$post);
do_action(array('wp_insert_post',false),$post_id,$post);
 }
function check_and_publish_future_post ( $post_id ) {
$post = get_post($post_id);
if ( ((empty($post) || Aspis_empty( $post))))
 return ;
if ( (('future') != $post[0]->post_status[0]))
 return ;
$time = attAspis(strtotime((deconcat2($post[0]->post_date_gmt,' GMT'))));
if ( ($time[0] > time()))
 {wp_clear_scheduled_hook(array('publish_future_post',false),$post_id);
wp_schedule_single_event($time,array('publish_future_post',false),array(array($post_id),false));
return ;
}return wp_publish_post($post_id);
 }
function wp_unique_post_slug ( $slug,$post_ID,$post_status,$post_type,$post_parent ) {
if ( deAspis(Aspis_in_array($post_status,array(array(array('draft',false),array('pending',false)),false))))
 return $slug;
global $wpdb,$wp_rewrite;
$feeds = $wp_rewrite[0]->feeds;
if ( (!(is_array($feeds[0]))))
 $feeds = array(array(),false);
$hierarchical_post_types = apply_filters(array('hierarchical_post_types',false),array(array(array('page',false)),false));
if ( (('attachment') == $post_type[0]))
 {$check_sql = concat2(concat1("SELECT post_name FROM ",$wpdb[0]->posts)," WHERE post_name = %s AND ID != %d LIMIT 1");
$post_name_check = $wpdb[0]->get_var($wpdb[0]->prepare($check_sql,$slug,$post_ID));
if ( ($post_name_check[0] || deAspis(Aspis_in_array($slug,$feeds))))
 {$suffix = array(2,false);
do {$alt_post_name = concat(Aspis_substr($slug,array(0,false),array((200) - (strlen($suffix[0]) + (1)),false)),concat1("-",$suffix));
$post_name_check = $wpdb[0]->get_var($wpdb[0]->prepare($check_sql,$alt_post_name,$post_ID));
postincr($suffix);
}while ($post_name_check[0] )
;
$slug = $alt_post_name;
}}elseif ( deAspis(Aspis_in_array($post_type,$hierarchical_post_types)))
 {$check_sql = concat2(concat(concat2(concat1("SELECT post_name FROM ",$wpdb[0]->posts)," WHERE post_name = %s AND post_type IN ( '"),Aspis_implode(array("', '",false),esc_sql($hierarchical_post_types))),"' ) AND ID != %d AND post_parent = %d LIMIT 1");
$post_name_check = $wpdb[0]->get_var($wpdb[0]->prepare($check_sql,$slug,$post_ID,$post_parent));
if ( ($post_name_check[0] || deAspis(Aspis_in_array($slug,$feeds))))
 {$suffix = array(2,false);
do {$alt_post_name = concat(Aspis_substr($slug,array(0,false),array((200) - (strlen($suffix[0]) + (1)),false)),concat1("-",$suffix));
$post_name_check = $wpdb[0]->get_var($wpdb[0]->prepare($check_sql,$alt_post_name,$post_ID,$post_parent));
postincr($suffix);
}while ($post_name_check[0] )
;
$slug = $alt_post_name;
}}else 
{{$check_sql = concat2(concat1("SELECT post_name FROM ",$wpdb[0]->posts)," WHERE post_name = %s AND post_type = %s AND ID != %d LIMIT 1");
$post_name_check = $wpdb[0]->get_var($wpdb[0]->prepare($check_sql,$slug,$post_type,$post_ID));
if ( ($post_name_check[0] || deAspis(Aspis_in_array($slug,$wp_rewrite[0]->feeds))))
 {$suffix = array(2,false);
do {$alt_post_name = concat(Aspis_substr($slug,array(0,false),array((200) - (strlen($suffix[0]) + (1)),false)),concat1("-",$suffix));
$post_name_check = $wpdb[0]->get_var($wpdb[0]->prepare($check_sql,$alt_post_name,$post_type,$post_ID));
postincr($suffix);
}while ($post_name_check[0] )
;
$slug = $alt_post_name;
}}}return $slug;
 }
function wp_add_post_tags ( $post_id = array(0,false),$tags = array('',false) ) {
return wp_set_post_tags($post_id,$tags,array(true,false));
 }
function wp_set_post_tags ( $post_id = array(0,false),$tags = array('',false),$append = array(false,false) ) {
return wp_set_post_terms($post_id,$tags,array('post_tag',false),$append);
 }
function wp_set_post_terms ( $post_id = array(0,false),$tags = array('',false),$taxonomy = array('post_tag',false),$append = array(false,false) ) {
$post_id = int_cast($post_id);
if ( (denot_boolean($post_id)))
 return array(false,false);
if ( ((empty($tags) || Aspis_empty( $tags))))
 $tags = array(array(),false);
$tags = is_array($tags[0]) ? $tags : Aspis_explode(array(',',false),Aspis_trim($tags,array(" \n\t\r\0\x0B,",false)));
wp_set_object_terms($post_id,$tags,$taxonomy,$append);
 }
function wp_set_post_categories ( $post_ID = array(0,false),$post_categories = array(array(),false) ) {
$post_ID = int_cast($post_ID);
if ( (((!(is_array($post_categories[0]))) || ((0) == count($post_categories[0]))) || ((empty($post_categories) || Aspis_empty( $post_categories)))))
 $post_categories = array(array(get_option(array('default_category',false))),false);
else 
{if ( (((1) == count($post_categories[0])) && (('') == deAspis(attachAspis($post_categories,(0))))))
 return array(true,false);
}$post_categories = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC($post_categories)));
$post_categories = attAspisRC(array_unique(deAspisRC($post_categories)));
return wp_set_object_terms($post_ID,$post_categories,array('category',false));
 }
function wp_transition_post_status ( $new_status,$old_status,$post ) {
do_action(array('transition_post_status',false),$new_status,$old_status,$post);
do_action(concat(concat2($old_status,"_to_"),$new_status),$post);
do_action(concat(concat2($new_status,"_"),$post[0]->post_type),$post[0]->ID,$post);
 }
function add_ping ( $post_id,$uri ) {
global $wpdb;
$pung = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT pinged FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$post_id));
$pung = Aspis_trim($pung);
$pung = Aspis_preg_split(array('/\s/',false),$pung);
arrayAssignAdd($pung[0][],addTaint($uri));
$new = Aspis_implode(array("\n",false),$pung);
$new = apply_filters(array('add_ping',false),$new);
$new = Aspis_stripslashes($new);
return $wpdb[0]->update($wpdb[0]->posts,array(array(deregisterTaint(array('pinged',false)) => addTaint($new)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($post_id)),false));
 }
function get_enclosed ( $post_id ) {
$custom_fields = get_post_custom($post_id);
$pung = array(array(),false);
if ( (!(is_array($custom_fields[0]))))
 return $pung;
foreach ( $custom_fields[0] as $key =>$val )
{restoreTaint($key,$val);
{if ( ((('enclosure') != $key[0]) || (!(is_array($val[0])))))
 continue ;
foreach ( $val[0] as $enc  )
{$enclosure = Aspis_split(array("\n",false),$enc);
arrayAssignAdd($pung[0][],addTaint(Aspis_trim(attachAspis($enclosure,(0)))));
}}}$pung = apply_filters(array('get_enclosed',false),$pung);
return $pung;
 }
function get_pung ( $post_id ) {
global $wpdb;
$pung = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT pinged FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$post_id));
$pung = Aspis_trim($pung);
$pung = Aspis_preg_split(array('/\s/',false),$pung);
$pung = apply_filters(array('get_pung',false),$pung);
return $pung;
 }
function get_to_ping ( $post_id ) {
global $wpdb;
$to_ping = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT to_ping FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$post_id));
$to_ping = Aspis_trim($to_ping);
$to_ping = Aspis_preg_split(array('/\s/',false),$to_ping,negate(array(1,false)),array(PREG_SPLIT_NO_EMPTY,false));
$to_ping = apply_filters(array('get_to_ping',false),$to_ping);
return $to_ping;
 }
function trackback_url_list ( $tb_list,$post_id ) {
if ( (!((empty($tb_list) || Aspis_empty( $tb_list)))))
 {$postdata = wp_get_single_post($post_id,array(ARRAY_A,false));
extract(($postdata[0]),EXTR_SKIP);
$excerpt = Aspis_strip_tags($post_excerpt[0] ? $post_excerpt : $post_content);
if ( (strlen($excerpt[0]) > (255)))
 {$excerpt = concat2(Aspis_substr($excerpt,array(0,false),array(252,false)),'...');
}$trackback_urls = Aspis_explode(array(',',false),$tb_list);
foreach ( deAspis(array_cast($trackback_urls)) as $tb_url  )
{$tb_url = Aspis_trim($tb_url);
trackback($tb_url,Aspis_stripslashes($post_title),$excerpt,$post_id);
}} }
function get_all_page_ids (  ) {
global $wpdb;
if ( (denot_boolean($page_ids = wp_cache_get(array('all_page_ids',false),array('posts',false)))))
 {$page_ids = $wpdb[0]->get_col(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_type = 'page'"));
wp_cache_add(array('all_page_ids',false),$page_ids,array('posts',false));
}return $page_ids;
 }
function &get_page ( &$page,$output = array(OBJECT,false),$filter = array('raw',false) ) {
if ( ((empty($page) || Aspis_empty( $page))))
 {if ( (((isset($GLOBALS[0][('post')]) && Aspis_isset( $GLOBALS [0][('post')]))) && ((isset($GLOBALS[0][('post')][0]->ID) && Aspis_isset( $GLOBALS [0][('post')][0] ->ID )))))
 {return get_post($GLOBALS[0]['post'],$output,$filter);
}else 
{{$page = array(null,false);
return $page;
}}}$the_page = get_post($page,$output,$filter);
return $the_page;
 }
function get_page_by_path ( $page_path,$output = array(OBJECT,false) ) {
global $wpdb;
$page_path = Aspis_rawurlencode(Aspis_urldecode($page_path));
$page_path = Aspis_str_replace(array('%2F',false),array('/',false),$page_path);
$page_path = Aspis_str_replace(array('%20',false),array(' ',false),$page_path);
$page_paths = concat1('/',Aspis_trim($page_path,array('/',false)));
$leaf_path = sanitize_title(Aspis_basename($page_paths));
$page_paths = Aspis_explode(array('/',false),$page_paths);
$full_path = array('',false);
foreach ( deAspis(array_cast($page_paths)) as $pathdir  )
$full_path = concat($full_path,concat((($pathdir[0] != ('')) ? array('/',false) : array('',false)),sanitize_title($pathdir)));
$pages = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT ID, post_name, post_parent FROM ",$wpdb[0]->posts)," WHERE post_name = %s AND (post_type = 'page' OR post_type = 'attachment')"),$leaf_path));
if ( ((empty($pages) || Aspis_empty( $pages))))
 return array(null,false);
foreach ( $pages[0] as $page  )
{$path = concat1('/',$leaf_path);
$curpage = $page;
while ( ($curpage[0]->post_parent[0] != (0)) )
{$curpage = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT ID, post_name, post_parent FROM ",$wpdb[0]->posts)," WHERE ID = %d and post_type='page'"),$curpage[0]->post_parent));
$path = concat(concat1('/',$curpage[0]->post_name),$path);
}if ( ($path[0] == $full_path[0]))
 return get_page($page[0]->ID,$output);
}return array(null,false);
 }
function get_page_by_title ( $page_title,$output = array(OBJECT,false) ) {
global $wpdb;
$page = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_title = %s AND post_type='page'"),$page_title));
if ( $page[0])
 return get_page($page,$output);
return array(null,false);
 }
function &get_page_children ( $page_id,$pages ) {
$page_list = array(array(),false);
foreach ( deAspis(array_cast($pages)) as $page  )
{if ( ($page[0]->post_parent[0] == $page_id[0]))
 {arrayAssignAdd($page_list[0][],addTaint($page));
if ( deAspis($children = get_page_children($page[0]->ID,$pages)))
 $page_list = Aspis_array_merge($page_list,$children);
}}return $page_list;
 }
function &get_page_hierarchy ( &$pages,$page_id = array(0,false) ) {
if ( ((empty($pages) || Aspis_empty( $pages))))
 {$return = array(array(),false);
return $return;
}$children = array(array(),false);
foreach ( deAspis(array_cast($pages)) as $p  )
{$parent_id = Aspis_intval($p[0]->post_parent);
arrayAssignAdd($children[0][$parent_id[0]][0][],addTaint($p));
}$result = array(array(),false);
_page_traverse_name($page_id,$children,$result);
return $result;
 }
function _page_traverse_name ( $page_id,&$children,&$result ) {
if ( ((isset($children[0][$page_id[0]]) && Aspis_isset( $children [0][$page_id[0]]))))
 {foreach ( deAspis(array_cast(attachAspis($children,$page_id[0]))) as $child  )
{arrayAssign($result[0],deAspis(registerTaint($child[0]->ID)),addTaint($child[0]->post_name));
_page_traverse_name($child[0]->ID,$children,$result);
}} }
function get_page_uri ( $page_id ) {
$page = get_page($page_id);
$uri = $page[0]->post_name;
if ( ($page[0]->post_parent[0] == $page[0]->ID[0]))
 return $uri;
while ( ($page[0]->post_parent[0] != (0)) )
{$page = get_page($page[0]->post_parent);
$uri = concat(concat2($page[0]->post_name,"/"),$uri);
}return $uri;
 }
function &get_pages ( $args = array('',false) ) {
global $wpdb;
$defaults = array(array('child_of' => array(0,false,false),'sort_order' => array('ASC',false,false),'sort_column' => array('post_title',false,false),'hierarchical' => array(1,false,false),'exclude' => array('',false,false),'include' => array('',false,false),'meta_key' => array('',false,false),'meta_value' => array('',false,false),'authors' => array('',false,false),deregisterTaint(array('parent',false)) => addTaint(negate(array(1,false))),'exclude_tree' => array('',false,false),'number' => array('',false,false),'offset' => array(0,false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
$number = int_cast($number);
$offset = int_cast($offset);
$cache = array(array(),false);
$key = attAspis(md5(deAspis(Aspis_serialize(array(compact(deAspisRC(attAspisRC(array_keys(deAspisRC($defaults))))),false)))));
if ( deAspis($cache = wp_cache_get(array('get_pages',false),array('posts',false))))
 {if ( (is_array($cache[0]) && ((isset($cache[0][$key[0]]) && Aspis_isset( $cache [0][$key[0]])))))
 {$pages = apply_filters(array('get_pages',false),attachAspis($cache,$key[0]),$r);
return $pages;
}}if ( (!(is_array($cache[0]))))
 $cache = array(array(),false);
$inclusions = array('',false);
if ( (!((empty($include) || Aspis_empty( $include)))))
 {$child_of = array(0,false);
$parent = negate(array(1,false));
$exclude = array('',false);
$meta_key = array('',false);
$meta_value = array('',false);
$hierarchical = array(false,false);
$incpages = Aspis_preg_split(array('/[\s,]+/',false),$include);
if ( count($incpages[0]))
 {foreach ( $incpages[0] as $incpage  )
{if ( ((empty($inclusions) || Aspis_empty( $inclusions))))
 $inclusions = $wpdb[0]->prepare(array(' AND ( ID = %d ',false),$incpage);
else 
{$inclusions = concat($inclusions,$wpdb[0]->prepare(array(' OR ID = %d ',false),$incpage));
}}}}if ( (!((empty($inclusions) || Aspis_empty( $inclusions)))))
 $inclusions = concat2($inclusions,')');
$exclusions = array('',false);
if ( (!((empty($exclude) || Aspis_empty( $exclude)))))
 {$expages = Aspis_preg_split(array('/[\s,]+/',false),$exclude);
if ( count($expages[0]))
 {foreach ( $expages[0] as $expage  )
{if ( ((empty($exclusions) || Aspis_empty( $exclusions))))
 $exclusions = $wpdb[0]->prepare(array(' AND ( ID <> %d ',false),$expage);
else 
{$exclusions = concat($exclusions,$wpdb[0]->prepare(array(' AND ID <> %d ',false),$expage));
}}}}if ( (!((empty($exclusions) || Aspis_empty( $exclusions)))))
 $exclusions = concat2($exclusions,')');
$author_query = array('',false);
if ( (!((empty($authors) || Aspis_empty( $authors)))))
 {$post_authors = Aspis_preg_split(array('/[\s,]+/',false),$authors);
if ( count($post_authors[0]))
 {foreach ( $post_authors[0] as $post_author  )
{if ( ((0) == deAspis(Aspis_intval($post_author))))
 {$post_author = get_userdatabylogin($post_author);
if ( ((empty($post_author) || Aspis_empty( $post_author))))
 continue ;
if ( ((empty($post_author[0]->ID) || Aspis_empty( $post_author[0] ->ID ))))
 continue ;
$post_author = $post_author[0]->ID;
}if ( (('') == $author_query[0]))
 $author_query = $wpdb[0]->prepare(array(' post_author = %d ',false),$post_author);
else 
{$author_query = concat($author_query,$wpdb[0]->prepare(array(' OR post_author = %d ',false),$post_author));
}}if ( (('') != $author_query[0]))
 $author_query = concat2(concat1(" AND (",$author_query),")");
}}$join = array('',false);
$where = concat2(concat(concat2($exclusions," "),$inclusions)," ");
if ( ((!((empty($meta_key) || Aspis_empty( $meta_key)))) || (!((empty($meta_value) || Aspis_empty( $meta_value))))))
 {$join = concat2(concat(concat2(concat(concat2(concat1(" LEFT JOIN ",$wpdb[0]->postmeta)," ON ( "),$wpdb[0]->posts),".ID = "),$wpdb[0]->postmeta),".post_id )");
$meta_key = Aspis_stripslashes($meta_key);
$meta_value = Aspis_stripslashes($meta_value);
if ( (!((empty($meta_key) || Aspis_empty( $meta_key)))))
 $where = concat($where,$wpdb[0]->prepare(concat2(concat1(" AND ",$wpdb[0]->postmeta),".meta_key = %s"),$meta_key));
if ( (!((empty($meta_value) || Aspis_empty( $meta_value)))))
 $where = concat($where,$wpdb[0]->prepare(concat2(concat1(" AND ",$wpdb[0]->postmeta),".meta_value = %s"),$meta_value));
}if ( ($parent[0] >= (0)))
 $where = concat($where,$wpdb[0]->prepare(array(' AND post_parent = %d ',false),$parent));
$query = concat2(concat(concat2(concat(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," "),$join)," WHERE (post_type = 'page' AND post_status = 'publish') "),$where)," ");
$query = concat($query,$author_query);
$query = concat($query,concat(concat2(concat1(" ORDER BY ",$sort_column)," "),$sort_order));
if ( (!((empty($number) || Aspis_empty( $number)))))
 $query = concat($query,concat(concat2(concat1(' LIMIT ',$offset),','),$number));
$pages = $wpdb[0]->get_results($query);
if ( ((empty($pages) || Aspis_empty( $pages))))
 {$pages = apply_filters(array('get_pages',false),array(array(),false),$r);
return $pages;
}$num_pages = attAspis(count($pages[0]));
for ( $i = array(0,false) ; ($i[0] < $num_pages[0]) ; postincr($i) )
{arrayAssign($pages[0],deAspis(registerTaint($i)),addTaint(sanitize_post(attachAspis($pages,$i[0]),array('raw',false))));
}update_page_cache($pages);
if ( ($child_of[0] || $hierarchical[0]))
 $pages = &get_page_children($child_of,$pages);
if ( (!((empty($exclude_tree) || Aspis_empty( $exclude_tree)))))
 {$exclude = int_cast($exclude_tree);
$children = get_page_children($exclude,$pages);
$excludes = array(array(),false);
foreach ( $children[0] as $child  )
arrayAssignAdd($excludes[0][],addTaint($child[0]->ID));
arrayAssignAdd($excludes[0][],addTaint($exclude));
$num_pages = attAspis(count($pages[0]));
for ( $i = array(0,false) ; ($i[0] < $num_pages[0]) ; postincr($i) )
{if ( deAspis(Aspis_in_array($pages[0][$i[0]][0]->ID,$excludes)))
 unset($pages[0][$i[0]]);
}}arrayAssign($cache[0],deAspis(registerTaint($key)),addTaint($pages));
wp_cache_set(array('get_pages',false),$cache,array('posts',false));
$pages = apply_filters(array('get_pages',false),$pages,$r);
return $pages;
 }
function is_local_attachment ( $url ) {
if ( (strpos($url[0],deAspisRC(get_bloginfo(array('url',false)))) === false))
 return array(false,false);
if ( (strpos($url[0],(deconcat2(get_bloginfo(array('url',false)),'/?attachment_id='))) !== false))
 return array(true,false);
if ( deAspis($id = url_to_postid($url)))
 {$post = &get_post($id);
if ( (('attachment') == $post[0]->post_type[0]))
 return array(true,false);
}return array(false,false);
 }
function wp_insert_attachment ( $object,$file = array(false,false),$parent = array(0,false) ) {
global $wpdb,$user_ID;
$defaults = array(array('post_status' => array('draft',false,false),'post_type' => array('post',false,false),deregisterTaint(array('post_author',false)) => addTaint($user_ID),deregisterTaint(array('ping_status',false)) => addTaint(get_option(array('default_ping_status',false))),'post_parent' => array(0,false,false),'menu_order' => array(0,false,false),'to_ping' => array('',false,false),'pinged' => array('',false,false),'post_password' => array('',false,false),'guid' => array('',false,false),'post_content_filtered' => array('',false,false),'post_excerpt' => array('',false,false),'import_id' => array(0,false,false)),false);
$object = wp_parse_args($object,$defaults);
if ( (!((empty($parent) || Aspis_empty( $parent)))))
 arrayAssign($object[0],deAspis(registerTaint(array('post_parent',false))),addTaint($parent));
$object = sanitize_post($object,array('db',false));
extract(($object[0]),EXTR_SKIP);
if ( (((!((isset($post_category) && Aspis_isset( $post_category)))) || ((0) == count($post_category[0]))) || (!(is_array($post_category[0])))))
 {$post_category = array(array(get_option(array('default_category',false))),false);
}if ( ((empty($post_author) || Aspis_empty( $post_author))))
 $post_author = $user_ID;
$post_type = array('attachment',false);
$post_status = array('inherit',false);
if ( (!((empty($ID) || Aspis_empty( $ID)))))
 {$update = array(true,false);
$post_ID = int_cast($ID);
}else 
{{$update = array(false,false);
$post_ID = array(0,false);
}}if ( ((empty($post_name) || Aspis_empty( $post_name))))
 $post_name = sanitize_title($post_title);
else 
{$post_name = sanitize_title($post_name);
}$post_name = wp_unique_post_slug($post_name,$post_ID,$post_status,$post_type,$post_parent);
if ( ((empty($post_date) || Aspis_empty( $post_date))))
 $post_date = current_time(array('mysql',false));
if ( ((empty($post_date_gmt) || Aspis_empty( $post_date_gmt))))
 $post_date_gmt = current_time(array('mysql',false),array(1,false));
if ( ((empty($post_modified) || Aspis_empty( $post_modified))))
 $post_modified = $post_date;
if ( ((empty($post_modified_gmt) || Aspis_empty( $post_modified_gmt))))
 $post_modified_gmt = $post_date_gmt;
if ( ((empty($comment_status) || Aspis_empty( $comment_status))))
 {if ( $update[0])
 $comment_status = array('closed',false);
else 
{$comment_status = get_option(array('default_comment_status',false));
}}if ( ((empty($ping_status) || Aspis_empty( $ping_status))))
 $ping_status = get_option(array('default_ping_status',false));
if ( ((isset($to_ping) && Aspis_isset( $to_ping))))
 $to_ping = Aspis_preg_replace(array('|\s+|',false),array("\n",false),$to_ping);
else 
{$to_ping = array('',false);
}if ( ((isset($post_parent) && Aspis_isset( $post_parent))))
 $post_parent = int_cast($post_parent);
else 
{$post_parent = array(0,false);
}if ( ((isset($menu_order) && Aspis_isset( $menu_order))))
 $menu_order = int_cast($menu_order);
else 
{$menu_order = array(0,false);
}if ( (!((isset($post_password) && Aspis_isset( $post_password)))))
 $post_password = array('',false);
if ( (!((isset($pinged) && Aspis_isset( $pinged)))))
 $pinged = array('',false);
$data = array(compact(deAspisRC(array(array(array('post_author',false),array('post_date',false),array('post_date_gmt',false),array('post_content',false),array('post_content_filtered',false),array('post_title',false),array('post_excerpt',false),array('post_status',false),array('post_type',false),array('comment_status',false),array('ping_status',false),array('post_password',false),array('post_name',false),array('to_ping',false),array('pinged',false),array('post_modified',false),array('post_modified_gmt',false),array('post_parent',false),array('menu_order',false),array('post_mime_type',false),array('guid',false)),false))),false);
$data = stripslashes_deep($data);
if ( $update[0])
 {$wpdb[0]->update($wpdb[0]->posts,$data,array(array(deregisterTaint(array('ID',false)) => addTaint($post_ID)),false));
}else 
{{if ( (!((empty($import_id) || Aspis_empty( $import_id)))))
 {$import_id = int_cast($import_id);
if ( (denot_boolean($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$import_id)))))
 {arrayAssign($data[0],deAspis(registerTaint(array('ID',false))),addTaint($import_id));
}}$wpdb[0]->insert($wpdb[0]->posts,$data);
$post_ID = int_cast($wpdb[0]->insert_id);
}}if ( ((empty($post_name) || Aspis_empty( $post_name))))
 {$post_name = sanitize_title($post_title,$post_ID);
$wpdb[0]->update($wpdb[0]->posts,array(compact("post_name"),false),array(array(deregisterTaint(array('ID',false)) => addTaint($post_ID)),false));
}wp_set_post_categories($post_ID,$post_category);
if ( $file[0])
 update_attached_file($post_ID,$file);
clean_post_cache($post_ID);
if ( (((isset($post_parent) && Aspis_isset( $post_parent))) && ($post_parent[0] < (0))))
 add_post_meta($post_ID,array('_wp_attachment_temp_parent',false),$post_parent,array(true,false));
if ( $update[0])
 {do_action(array('edit_attachment',false),$post_ID);
}else 
{{do_action(array('add_attachment',false),$post_ID);
}}return $post_ID;
 }
function wp_delete_attachment ( $post_id,$force_delete = array(false,false) ) {
global $wpdb;
if ( (denot_boolean($post = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$post_id)))))
 return $post;
if ( (('attachment') != $post[0]->post_type[0]))
 return array(false,false);
if ( ((((denot_boolean($force_delete)) && EMPTY_TRASH_DAYS) && MEDIA_TRASH) && (('trash') != $post[0]->post_status[0])))
 return wp_trash_post($post_id);
delete_post_meta($post_id,array('_wp_trash_meta_status',false));
delete_post_meta($post_id,array('_wp_trash_meta_time',false));
$meta = wp_get_attachment_metadata($post_id);
$backup_sizes = get_post_meta($post[0]->ID,array('_wp_attachment_backup_sizes',false),array(true,false));
$file = get_attached_file($post_id);
do_action(array('delete_attachment',false),$post_id);
wp_delete_object_term_relationships($post_id,array(array(array('category',false),array('post_tag',false)),false));
wp_delete_object_term_relationships($post_id,get_object_taxonomies($post[0]->post_type));
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->postmeta)," WHERE meta_key = '_thumbnail_id' AND meta_value = %d"),$post_id));
$comment_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT comment_ID FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d"),$post_id));
if ( (!((empty($comment_ids) || Aspis_empty( $comment_ids)))))
 {do_action(array('delete_comment',false),$comment_ids);
$in_comment_ids = concat2(concat1("'",Aspis_implode(array("', '",false),$comment_ids)),"'");
$wpdb[0]->query(concat2(concat(concat2(concat1("DELETE FROM ",$wpdb[0]->comments)," WHERE comment_ID IN("),$in_comment_ids),")"));
do_action(array('deleted_comment',false),$comment_ids);
}$post_meta_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT meta_id FROM ",$wpdb[0]->postmeta)," WHERE post_id = %d "),$post_id));
if ( (!((empty($post_meta_ids) || Aspis_empty( $post_meta_ids)))))
 {do_action(array('delete_postmeta',false),$post_meta_ids);
$in_post_meta_ids = concat2(concat1("'",Aspis_implode(array("', '",false),$post_meta_ids)),"'");
$wpdb[0]->query(concat2(concat(concat2(concat1("DELETE FROM ",$wpdb[0]->postmeta)," WHERE meta_id IN("),$in_post_meta_ids),")"));
do_action(array('deleted_postmeta',false),$post_meta_ids);
}do_action(array('delete_post',false),$post_id);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$post_id));
do_action(array('deleted_post',false),$post_id);
$uploadpath = wp_upload_dir();
if ( (!((empty($meta[0][('thumb')]) || Aspis_empty( $meta [0][('thumb')])))))
 {if ( (denot_boolean($wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT meta_id FROM ",$wpdb[0]->postmeta)," WHERE meta_key = '_wp_attachment_metadata' AND meta_value LIKE %s AND post_id <> %d"),concat2(concat1('%',$meta[0]['thumb']),'%'),$post_id)))))
 {$thumbfile = Aspis_str_replace(Aspis_basename($file),$meta[0]['thumb'],$file);
$thumbfile = apply_filters(array('wp_delete_file',false),$thumbfile);
@attAspis(unlink(deAspis(path_join($uploadpath[0]['basedir'],$thumbfile))));
}}$sizes = apply_filters(array('intermediate_image_sizes',false),array(array(array('thumbnail',false),array('medium',false),array('large',false)),false));
foreach ( $sizes[0] as $size  )
{if ( deAspis($intermediate = image_get_intermediate_size($post_id,$size)))
 {$intermediate_file = apply_filters(array('wp_delete_file',false),$intermediate[0]['path']);
@attAspis(unlink(deAspis(path_join($uploadpath[0]['basedir'],$intermediate_file))));
}}if ( is_array($backup_sizes[0]))
 {foreach ( $backup_sizes[0] as $size  )
{$del_file = path_join(Aspis_dirname($meta[0]['file']),$size[0]['file']);
$del_file = apply_filters(array('wp_delete_file',false),$del_file);
@attAspis(unlink(deAspis(path_join($uploadpath[0]['basedir'],$del_file))));
}}$file = apply_filters(array('wp_delete_file',false),$file);
if ( (!((empty($file) || Aspis_empty( $file)))))
 @attAspis(unlink($file[0]));
clean_post_cache($post_id);
return $post;
 }
function wp_get_attachment_metadata ( $post_id,$unfiltered = array(false,false) ) {
$post_id = int_cast($post_id);
if ( (denot_boolean($post = &get_post($post_id))))
 return array(false,false);
$data = get_post_meta($post[0]->ID,array('_wp_attachment_metadata',false),array(true,false));
if ( $unfiltered[0])
 return $data;
return apply_filters(array('wp_get_attachment_metadata',false),$data,$post[0]->ID);
 }
function wp_update_attachment_metadata ( $post_id,$data ) {
$post_id = int_cast($post_id);
if ( (denot_boolean($post = &get_post($post_id))))
 return array(false,false);
$data = apply_filters(array('wp_update_attachment_metadata',false),$data,$post[0]->ID);
return update_post_meta($post[0]->ID,array('_wp_attachment_metadata',false),$data);
 }
function wp_get_attachment_url ( $post_id = array(0,false) ) {
$post_id = int_cast($post_id);
if ( (denot_boolean($post = &get_post($post_id))))
 return array(false,false);
$url = array('',false);
if ( deAspis($file = get_post_meta($post[0]->ID,array('_wp_attached_file',false),array(true,false))))
 {if ( (deAspis(($uploads = wp_upload_dir())) && (false === deAspis($uploads[0]['error']))))
 {if ( ((0) === strpos($file[0],deAspisRC($uploads[0]['basedir']))))
 $url = Aspis_str_replace($uploads[0]['basedir'],$uploads[0]['baseurl'],$file);
elseif ( (false !== strpos($file[0],'wp-content/uploads')))
 $url = concat($uploads[0]['baseurl'],Aspis_substr($file,array(strpos($file[0],'wp-content/uploads') + (18),false)));
else 
{$url = concat($uploads[0]['baseurl'],concat1("/",$file));
}}}if ( ((empty($url) || Aspis_empty( $url))))
 $url = get_the_guid($post[0]->ID);
if ( ((('attachment') != $post[0]->post_type[0]) || ((empty($url) || Aspis_empty( $url)))))
 return array(false,false);
return apply_filters(array('wp_get_attachment_url',false),$url,$post[0]->ID);
 }
function wp_get_attachment_thumb_file ( $post_id = array(0,false) ) {
$post_id = int_cast($post_id);
if ( (denot_boolean($post = &get_post($post_id))))
 return array(false,false);
if ( (!(is_array(deAspis($imagedata = wp_get_attachment_metadata($post[0]->ID))))))
 return array(false,false);
$file = get_attached_file($post[0]->ID);
if ( (((!((empty($imagedata[0][('thumb')]) || Aspis_empty( $imagedata [0][('thumb')])))) && deAspis(($thumbfile = Aspis_str_replace(Aspis_basename($file),$imagedata[0]['thumb'],$file)))) && file_exists($thumbfile[0])))
 return apply_filters(array('wp_get_attachment_thumb_file',false),$thumbfile,$post[0]->ID);
return array(false,false);
 }
function wp_get_attachment_thumb_url ( $post_id = array(0,false) ) {
$post_id = int_cast($post_id);
if ( (denot_boolean($post = &get_post($post_id))))
 return array(false,false);
if ( (denot_boolean($url = wp_get_attachment_url($post[0]->ID))))
 return array(false,false);
$sized = image_downsize($post_id,array('thumbnail',false));
if ( $sized[0])
 return attachAspis($sized,(0));
if ( (denot_boolean($thumb = wp_get_attachment_thumb_file($post[0]->ID))))
 return array(false,false);
$url = Aspis_str_replace(Aspis_basename($url),Aspis_basename($thumb),$url);
return apply_filters(array('wp_get_attachment_thumb_url',false),$url,$post[0]->ID);
 }
function wp_attachment_is_image ( $post_id = array(0,false) ) {
$post_id = int_cast($post_id);
if ( (denot_boolean($post = &get_post($post_id))))
 return array(false,false);
if ( (denot_boolean($file = get_attached_file($post[0]->ID))))
 return array(false,false);
$ext = deAspis(Aspis_preg_match(array('/\.([^.]+)$/',false),$file,$matches)) ? Aspis_strtolower(attachAspis($matches,(1))) : array(false,false);
$image_exts = array(array(array('jpg',false),array('jpeg',false),array('gif',false),array('png',false)),false);
if ( ((('image/') == deAspis(Aspis_substr($post[0]->post_mime_type,array(0,false),array(6,false)))) || (($ext[0] && (('import') == $post[0]->post_mime_type[0])) && deAspis(Aspis_in_array($ext,$image_exts)))))
 return array(true,false);
return array(false,false);
 }
function wp_mime_type_icon ( $mime = array(0,false) ) {
if ( (!(is_numeric(deAspisRC($mime)))))
 $icon = wp_cache_get(concat1("mime_type_icon_",$mime));
if ( ((empty($icon) || Aspis_empty( $icon))))
 {$post_id = array(0,false);
$post_mimes = array(array(),false);
if ( is_numeric(deAspisRC($mime)))
 {$mime = int_cast($mime);
if ( deAspis($post = &get_post($mime)))
 {$post_id = int_cast($post[0]->ID);
$ext = Aspis_preg_replace(array('/^.+?\.([^.]+)$/',false),array('$1',false),$post[0]->guid);
if ( (!((empty($ext) || Aspis_empty( $ext)))))
 {arrayAssignAdd($post_mimes[0][],addTaint($ext));
if ( deAspis($ext_type = wp_ext2type($ext)))
 arrayAssignAdd($post_mimes[0][],addTaint($ext_type));
}$mime = $post[0]->post_mime_type;
}else 
{{$mime = array(0,false);
}}}else 
{{arrayAssignAdd($post_mimes[0][],addTaint($mime));
}}$icon_files = wp_cache_get(array('icon_files',false));
if ( (!(is_array($icon_files[0]))))
 {$icon_dir = apply_filters(array('icon_dir',false),concat2(concat12(ABSPATH,WPINC),'/images/crystal'));
$icon_dir_uri = apply_filters(array('icon_dir_uri',false),includes_url(array('images/crystal',false)));
$dirs = apply_filters(array('icon_dirs',false),array(array(deregisterTaint($icon_dir) => addTaint($icon_dir_uri)),false));
$icon_files = array(array(),false);
while ( $dirs[0] )
{$dir = Aspis_array_shift($keys = attAspisRC(array_keys(deAspisRC($dirs))));
$uri = Aspis_array_shift($dirs);
if ( deAspis($dh = attAspis(opendir($dir[0]))))
 {while ( (false !== deAspis($file = attAspis(readdir($dh[0])))) )
{$file = Aspis_basename($file);
if ( (deAspis(Aspis_substr($file,array(0,false),array(1,false))) == ('.')))
 continue ;
if ( (denot_boolean(Aspis_in_array(Aspis_strtolower(Aspis_substr($file,negate(array(4,false)))),array(array(array('.png',false),array('.gif',false),array('.jpg',false)),false)))))
 {if ( is_dir((deconcat(concat2($dir,"/"),$file))))
 arrayAssign($dirs[0],deAspis(registerTaint(concat(concat2($dir,"/"),$file))),addTaint(concat(concat2($uri,"/"),$file)));
continue ;
}arrayAssign($icon_files[0],deAspis(registerTaint(concat(concat2($dir,"/"),$file))),addTaint(concat(concat2($uri,"/"),$file)));
}closedir($dh[0]);
}}wp_cache_set(array('icon_files',false),$icon_files,array(600,false));
}foreach ( $icon_files[0] as $file =>$uri )
{restoreTaint($file,$uri);
$types[0][deAspis(registerTaint(Aspis_preg_replace(array('/^([^.]*).*$/',false),array('$1',false),Aspis_basename($file))))] = &addTaintR($icon_files[0][$file[0]]);
}if ( (!((empty($mime) || Aspis_empty( $mime)))))
 {arrayAssignAdd($post_mimes[0][],addTaint(Aspis_substr($mime,array(0,false),attAspis(strpos($mime[0],'/')))));
arrayAssignAdd($post_mimes[0][],addTaint(Aspis_substr($mime,array(strpos($mime[0],'/') + (1),false))));
arrayAssignAdd($post_mimes[0][],addTaint(Aspis_str_replace(array('/',false),array('_',false),$mime)));
}$matches = wp_match_mime_types(attAspisRC(array_keys(deAspisRC($types))),$post_mimes);
arrayAssign($matches[0],deAspis(registerTaint(array('default',false))),addTaint(array(array(array('default',false)),false)));
foreach ( $matches[0] as $match =>$wilds )
{restoreTaint($match,$wilds);
{if ( ((isset($types[0][deAspis(attachAspis($wilds,(0)))]) && Aspis_isset( $types [0][deAspis(attachAspis( $wilds ,(0)))]))))
 {$icon = attachAspis($types,deAspis(attachAspis($wilds,(0))));
if ( (!(is_numeric(deAspisRC($mime)))))
 wp_cache_set(concat1("mime_type_icon_",$mime),$icon);
break ;
}}}}return apply_filters(array('wp_mime_type_icon',false),$icon,$mime,$post_id);
 }
function wp_check_for_changed_slugs ( $post_id ) {
if ( ((!((isset($_POST[0][('wp-old-slug')]) && Aspis_isset( $_POST [0][('wp-old-slug')])))) || (!(strlen(deAspis($_POST[0]['wp-old-slug']))))))
 return $post_id;
$post = &get_post($post_id);
if ( (($post[0]->post_status[0] != ('publish')) || ($post[0]->post_type[0] != ('post'))))
 return $post_id;
if ( ($post[0]->post_name[0] == deAspis($_POST[0]['wp-old-slug'])))
 return $post_id;
$old_slugs = array_cast(get_post_meta($post_id,array('_wp_old_slug',false)));
if ( ((!(count($old_slugs[0]))) || (denot_boolean(Aspis_in_array($_POST[0]['wp-old-slug'],$old_slugs)))))
 add_post_meta($post_id,array('_wp_old_slug',false),$_POST[0]['wp-old-slug']);
if ( deAspis(Aspis_in_array($post[0]->post_name,$old_slugs)))
 delete_post_meta($post_id,array('_wp_old_slug',false),$post[0]->post_name);
return $post_id;
 }
function get_private_posts_cap_sql ( $post_type ) {
global $user_ID;
$cap = array('',false);
if ( ($post_type[0] == ('post')))
 {$cap = array('read_private_posts',false);
}elseif ( ($post_type[0] == ('page')))
 {$cap = array('read_private_pages',false);
}else 
{{$cap = apply_filters(array('pub_priv_sql_capability',false),$cap);
if ( ((empty($cap) || Aspis_empty( $cap))))
 {return array('1 = 0',false);
}}}$sql = array('(post_status = \'publish\'',false);
if ( deAspis(current_user_can($cap)))
 {$sql = concat2($sql,' OR post_status = \'private\'');
}elseif ( deAspis(is_user_logged_in()))
 {$sql = concat($sql,concat2(concat1(' OR post_status = \'private\' AND post_author = \'',$user_ID),'\''));
}$sql = concat2($sql,')');
return $sql;
 }
function get_lastpostdate ( $timezone = array('server',false) ) {
global $cache_lastpostdate,$wpdb,$blog_id;
$add_seconds_server = attAspis(date(('Z')));
if ( (!((isset($cache_lastpostdate[0][$blog_id[0]][0][$timezone[0]]) && Aspis_isset( $cache_lastpostdate [0][$blog_id[0]] [0][$timezone[0]])))))
 {switch ( deAspis(Aspis_strtolower($timezone)) ) {
case ('gmt'):$lastpostdate = $wpdb[0]->get_var(concat2(concat1("SELECT post_date_gmt FROM ",$wpdb[0]->posts)," WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date_gmt DESC LIMIT 1"));
break ;
case ('blog'):$lastpostdate = $wpdb[0]->get_var(concat2(concat1("SELECT post_date FROM ",$wpdb[0]->posts)," WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date_gmt DESC LIMIT 1"));
break ;
case ('server'):$lastpostdate = $wpdb[0]->get_var(concat2(concat(concat2(concat1("SELECT DATE_ADD(post_date_gmt, INTERVAL '",$add_seconds_server),"' SECOND) FROM "),$wpdb[0]->posts)," WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date_gmt DESC LIMIT 1"));
break ;
 }
arrayAssign($cache_lastpostdate[0][$blog_id[0]][0],deAspis(registerTaint($timezone)),addTaint($lastpostdate));
}else 
{{$lastpostdate = attachAspis($cache_lastpostdate[0][$blog_id[0]],$timezone[0]);
}}return apply_filters(array('get_lastpostdate',false),$lastpostdate,$timezone);
 }
function get_lastpostmodified ( $timezone = array('server',false) ) {
global $cache_lastpostmodified,$wpdb,$blog_id;
$add_seconds_server = attAspis(date(('Z')));
if ( (!((isset($cache_lastpostmodified[0][$blog_id[0]][0][$timezone[0]]) && Aspis_isset( $cache_lastpostmodified [0][$blog_id[0]] [0][$timezone[0]])))))
 {switch ( deAspis(Aspis_strtolower($timezone)) ) {
case ('gmt'):$lastpostmodified = $wpdb[0]->get_var(concat2(concat1("SELECT post_modified_gmt FROM ",$wpdb[0]->posts)," WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_modified_gmt DESC LIMIT 1"));
break ;
case ('blog'):$lastpostmodified = $wpdb[0]->get_var(concat2(concat1("SELECT post_modified FROM ",$wpdb[0]->posts)," WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_modified_gmt DESC LIMIT 1"));
break ;
case ('server'):$lastpostmodified = $wpdb[0]->get_var(concat2(concat(concat2(concat1("SELECT DATE_ADD(post_modified_gmt, INTERVAL '",$add_seconds_server),"' SECOND) FROM "),$wpdb[0]->posts)," WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_modified_gmt DESC LIMIT 1"));
break ;
 }
$lastpostdate = get_lastpostdate($timezone);
if ( ($lastpostdate[0] > $lastpostmodified[0]))
 {$lastpostmodified = $lastpostdate;
}arrayAssign($cache_lastpostmodified[0][$blog_id[0]][0],deAspis(registerTaint($timezone)),addTaint($lastpostmodified));
}else 
{{$lastpostmodified = attachAspis($cache_lastpostmodified[0][$blog_id[0]],$timezone[0]);
}}return apply_filters(array('get_lastpostmodified',false),$lastpostmodified,$timezone);
 }
function update_post_cache ( &$posts ) {
if ( (denot_boolean($posts)))
 return ;
foreach ( $posts[0] as $post  )
wp_cache_add($post[0]->ID,$post,array('posts',false));
 }
function clean_post_cache ( $id ) {
global $_wp_suspend_cache_invalidation,$wpdb;
if ( (!((empty($_wp_suspend_cache_invalidation) || Aspis_empty( $_wp_suspend_cache_invalidation)))))
 return ;
$id = int_cast($id);
wp_cache_delete($id,array('posts',false));
wp_cache_delete($id,array('post_meta',false));
clean_object_term_cache($id,array('post',false));
wp_cache_delete(array('wp_get_archives',false),array('general',false));
do_action(array('clean_post_cache',false),$id);
if ( deAspis($children = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_parent = %d"),$id))))
 {foreach ( $children[0] as $cid  )
clean_post_cache($cid);
} }
function update_page_cache ( &$pages ) {
update_post_cache($pages);
 }
function clean_page_cache ( $id ) {
clean_post_cache($id);
wp_cache_delete(array('all_page_ids',false),array('posts',false));
wp_cache_delete(array('get_pages',false),array('posts',false));
do_action(array('clean_page_cache',false),$id);
 }
function update_post_caches ( &$posts ) {
if ( (denot_boolean($posts)))
 return ;
update_post_cache($posts);
$post_ids = array(array(),false);
for ( $i = array(0,false) ; ($i[0] < count($posts[0])) ; postincr($i) )
arrayAssignAdd($post_ids[0][],addTaint($posts[0][$i[0]][0]->ID));
update_object_term_cache($post_ids,array('post',false));
update_postmeta_cache($post_ids);
 }
function update_postmeta_cache ( $post_ids ) {
return update_meta_cache(array('post',false),$post_ids);
 }
function _transition_post_status ( $new_status,$old_status,$post ) {
global $wpdb;
if ( (($old_status[0] != ('publish')) && ($new_status[0] == ('publish'))))
 {if ( (('') == deAspis(get_the_guid($post[0]->ID))))
 $wpdb[0]->update($wpdb[0]->posts,array(array(deregisterTaint(array('guid',false)) => addTaint(get_permalink($post[0]->ID))),false),array(array(deregisterTaint(array('ID',false)) => addTaint($post[0]->ID)),false));
do_action(array('private_to_published',false),$post[0]->ID);
}wp_clear_scheduled_hook(array('publish_future_post',false),$post[0]->ID);
 }
function _future_post_hook ( $deprecated = array('',false),$post ) {
wp_clear_scheduled_hook(array('publish_future_post',false),$post[0]->ID);
wp_schedule_single_event(attAspis(strtotime((deconcat2($post[0]->post_date_gmt,' GMT')))),array('publish_future_post',false),array(array($post[0]->ID),false));
 }
function _publish_post_hook ( $post_id ) {
global $wpdb;
if ( defined(('XMLRPC_REQUEST')))
 do_action(array('xmlrpc_publish_post',false),$post_id);
if ( defined(('APP_REQUEST')))
 do_action(array('app_publish_post',false),$post_id);
if ( defined(('WP_IMPORTING')))
 return ;
$data = array(array(deregisterTaint(array('post_id',false)) => addTaint($post_id),'meta_value' => array('1',false,false)),false);
if ( deAspis(get_option(array('default_pingback_flag',false))))
 {$wpdb[0]->insert($wpdb[0]->postmeta,array($data[0] + (array('meta_key' => array('_pingme',false,false))),false));
do_action(array('added_postmeta',false),$wpdb[0]->insert_id,$post_id,array('_pingme',false),array(1,false));
}$wpdb[0]->insert($wpdb[0]->postmeta,array($data[0] + (array('meta_key' => array('_encloseme',false,false))),false));
do_action(array('added_postmeta',false),$wpdb[0]->insert_id,$post_id,array('_encloseme',false),array(1,false));
wp_schedule_single_event(attAspis(time()),array('do_pings',false));
 }
function _save_post_hook ( $post_id,$post ) {
if ( ($post[0]->post_type[0] == ('page')))
 {clean_page_cache($post_id);
if ( (!(defined(('WP_IMPORTING')))))
 {global $wp_rewrite;
$wp_rewrite[0]->flush_rules(array(false,false));
}}else 
{{clean_post_cache($post_id);
}} }
function _get_post_ancestors ( &$_post ) {
global $wpdb;
if ( ((isset($_post[0]->ancestors) && Aspis_isset( $_post[0] ->ancestors ))))
 return ;
$_post[0]->ancestors = array(array(),false);
if ( (((empty($_post[0]->post_parent) || Aspis_empty( $_post[0] ->post_parent ))) || ($_post[0]->ID[0] == $_post[0]->post_parent[0])))
 return ;
$id = arrayAssignAdd($_post[0]->ancestors[0][],addTaint($_post[0]->post_parent));
while ( deAspis($ancestor = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT `post_parent` FROM ",$wpdb[0]->posts)," WHERE ID = %d LIMIT 1"),$id))) )
{if ( ($id[0] == $ancestor[0]))
 break ;
$id = arrayAssignAdd($_post[0]->ancestors[0][],addTaint($ancestor));
} }
function _wp_post_revision_fields ( $post = array(null,false),$autosave = array(false,false) ) {
static $fields = array(false,false);
if ( (denot_boolean($fields)))
 {$fields = array(array(deregisterTaint(array('post_title',false)) => addTaint(__(array('Title',false))),deregisterTaint(array('post_content',false)) => addTaint(__(array('Content',false))),deregisterTaint(array('post_excerpt',false)) => addTaint(__(array('Excerpt',false))),),false);
$fields = apply_filters(array('_wp_post_revision_fields',false),$fields);
foreach ( (array(array('ID',false),array('post_name',false),array('post_parent',false),array('post_date',false),array('post_date_gmt',false),array('post_status',false),array('post_type',false),array('comment_count',false),array('post_author',false))) as $protect  )
unset($fields[0][$protect[0]]);
}if ( (!(is_array($post[0]))))
 return $fields;
$return = array(array(),false);
foreach ( deAspis(Aspis_array_intersect(attAspisRC(array_keys(deAspisRC($post))),attAspisRC(array_keys(deAspisRC($fields))))) as $field  )
arrayAssign($return[0],deAspis(registerTaint($field)),addTaint(attachAspis($post,$field[0])));
arrayAssign($return[0],deAspis(registerTaint(array('post_parent',false))),addTaint($post[0]['ID']));
arrayAssign($return[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('inherit',false)));
arrayAssign($return[0],deAspis(registerTaint(array('post_type',false))),addTaint(array('revision',false)));
arrayAssign($return[0],deAspis(registerTaint(array('post_name',false))),addTaint($autosave[0] ? concat2(attachAspis($post,ID),"-autosave") : concat2(attachAspis($post,ID),"-revision")));
arrayAssign($return[0],deAspis(registerTaint(array('post_date',false))),addTaint(((isset($post[0][('post_modified')]) && Aspis_isset( $post [0][('post_modified')]))) ? $post[0]['post_modified'] : array('',false)));
arrayAssign($return[0],deAspis(registerTaint(array('post_date_gmt',false))),addTaint(((isset($post[0][('post_modified_gmt')]) && Aspis_isset( $post [0][('post_modified_gmt')]))) ? $post[0]['post_modified_gmt'] : array('',false)));
return $return;
 }
function wp_save_post_revision ( $post_id ) {
if ( (defined(('DOING_AUTOSAVE')) && DOING_AUTOSAVE))
 return ;
if ( (denot_boolean(attAspisRC(constant(('WP_POST_REVISIONS'))))))
 return ;
if ( (denot_boolean($post = get_post($post_id,array(ARRAY_A,false)))))
 return ;
if ( (denot_boolean(Aspis_in_array($post[0]['post_type'],array(array(array('post',false),array('page',false)),false)))))
 return ;
$return = _wp_put_post_revision($post);
if ( ((!(is_numeric(WP_POST_REVISIONS))) || (WP_POST_REVISIONS < (0))))
 return $return;
$revisions = wp_get_post_revisions($post_id,array(array('order' => array('ASC',false,false)),false));
$delete = array(count($revisions[0]) - WP_POST_REVISIONS,false);
if ( ($delete[0] < (1)))
 return $return;
$revisions = Aspis_array_slice($revisions,array(0,false),$delete);
for ( $i = array(0,false) ; ((isset($revisions[0][$i[0]]) && Aspis_isset( $revisions [0][$i[0]]))) ; postincr($i) )
{if ( (false !== strpos($revisions[0][$i[0]][0]->post_name[0],'autosave')))
 continue ;
wp_delete_post_revision($revisions[0][$i[0]][0]->ID);
}return $return;
 }
function wp_get_post_autosave ( $post_id ) {
if ( (denot_boolean($post = get_post($post_id))))
 return array(false,false);
$q = array(array(deregisterTaint(array('name',false)) => addTaint(concat2($post[0]->ID,"-autosave")),deregisterTaint(array('post_parent',false)) => addTaint($post[0]->ID),'post_type' => array('revision',false,false),'post_status' => array('inherit',false,false)),false);
$autosave_query = array(new WP_Query,false);
add_action(array('parse_query',false),array('_wp_get_post_autosave_hack',false));
$autosave = $autosave_query[0]->query($q);
remove_action(array('parse_query',false),array('_wp_get_post_autosave_hack',false));
if ( (($autosave[0] && is_array($autosave[0])) && is_object(deAspis(attachAspis($autosave,(0))))))
 return attachAspis($autosave,(0));
return array(false,false);
 }
function _wp_get_post_autosave_hack ( $query ) {
$query[0]->is_single = array(false,false);
 }
function wp_is_post_revision ( $post ) {
if ( (denot_boolean($post = wp_get_post_revision($post))))
 return array(false,false);
return int_cast($post[0]->post_parent);
 }
function wp_is_post_autosave ( $post ) {
if ( (denot_boolean($post = wp_get_post_revision($post))))
 return array(false,false);
if ( ((deconcat2($post[0]->post_parent,"-autosave")) !== $post[0]->post_name[0]))
 return array(false,false);
return int_cast($post[0]->post_parent);
 }
function _wp_put_post_revision ( $post = array(null,false),$autosave = array(false,false) ) {
if ( is_object($post[0]))
 $post = attAspis(get_object_vars(deAspisRC($post)));
elseif ( (!(is_array($post[0]))))
 $post = get_post($post,array(ARRAY_A,false));
if ( ((denot_boolean($post)) || ((empty($post[0][('ID')]) || Aspis_empty( $post [0][('ID')])))))
 return ;
if ( (((isset($post[0][('post_type')]) && Aspis_isset( $post [0][('post_type')]))) && (('revision') == deAspis($post[0]['post_type']))))
 return array(new WP_Error(array('post_type',false),__(array('Cannot create a revision of a revision',false))),false);
$post = _wp_post_revision_fields($post,$autosave);
$post = add_magic_quotes($post);
$revision_id = wp_insert_post($post);
if ( deAspis(is_wp_error($revision_id)))
 return $revision_id;
if ( $revision_id[0])
 do_action(array('_wp_put_post_revision',false),$revision_id);
return $revision_id;
 }
function &wp_get_post_revision ( &$post,$output = array(OBJECT,false),$filter = array('raw',false) ) {
$null = array(null,false);
if ( (denot_boolean($revision = get_post($post,array(OBJECT,false),$filter))))
 return $revision;
if ( (('revision') !== $revision[0]->post_type[0]))
 return $null;
if ( ($output[0] == OBJECT))
 {return $revision;
}elseif ( ($output[0] == ARRAY_A))
 {$_revision = attAspis(get_object_vars(deAspisRC($revision)));
return $_revision;
}elseif ( ($output[0] == ARRAY_N))
 {$_revision = Aspis_array_values(attAspis(get_object_vars(deAspisRC($revision))));
return $_revision;
}return $revision;
 }
function wp_restore_post_revision ( $revision_id,$fields = array(null,false) ) {
if ( (denot_boolean($revision = wp_get_post_revision($revision_id,array(ARRAY_A,false)))))
 return $revision;
if ( (!(is_array($fields[0]))))
 $fields = attAspisRC(array_keys(deAspisRC(_wp_post_revision_fields())));
$update = array(array(),false);
foreach ( deAspis(Aspis_array_intersect(attAspisRC(array_keys(deAspisRC($revision))),$fields)) as $field  )
arrayAssign($update[0],deAspis(registerTaint($field)),addTaint(attachAspis($revision,$field[0])));
if ( (denot_boolean($update)))
 return array(false,false);
arrayAssign($update[0],deAspis(registerTaint(array('ID',false))),addTaint($revision[0]['post_parent']));
$update = add_magic_quotes($update);
$post_id = wp_update_post($update);
if ( deAspis(is_wp_error($post_id)))
 return $post_id;
if ( $post_id[0])
 do_action(array('wp_restore_post_revision',false),$post_id,$revision[0]['ID']);
return $post_id;
 }
function wp_delete_post_revision ( $revision_id ) {
if ( (denot_boolean($revision = wp_get_post_revision($revision_id))))
 return $revision;
$delete = wp_delete_post($revision[0]->ID);
if ( deAspis(is_wp_error($delete)))
 return $delete;
if ( $delete[0])
 do_action(array('wp_delete_post_revision',false),$revision[0]->ID,$revision);
return $delete;
 }
function wp_get_post_revisions ( $post_id = array(0,false),$args = array(null,false) ) {
if ( (denot_boolean(attAspisRC(constant(('WP_POST_REVISIONS'))))))
 return array(array(),false);
if ( ((denot_boolean($post = get_post($post_id))) || ((empty($post[0]->ID) || Aspis_empty( $post[0] ->ID )))))
 return array(array(),false);
$defaults = array(array('order' => array('DESC',false,false),'orderby' => array('date',false,false)),false);
$args = wp_parse_args($args,$defaults);
$args = Aspis_array_merge($args,array(array(deregisterTaint(array('post_parent',false)) => addTaint($post[0]->ID),'post_type' => array('revision',false,false),'post_status' => array('inherit',false,false)),false));
if ( (denot_boolean($revisions = get_children($args))))
 return array(array(),false);
return $revisions;
 }
function _set_preview ( $post ) {
if ( (!(is_object($post[0]))))
 return $post;
$preview = wp_get_post_autosave($post[0]->ID);
if ( (!(is_object($preview[0]))))
 return $post;
$preview = sanitize_post($preview);
$post[0]->post_content = $preview[0]->post_content;
$post[0]->post_title = $preview[0]->post_title;
$post[0]->post_excerpt = $preview[0]->post_excerpt;
return $post;
 }
function _show_post_preview (  ) {
if ( (((isset($_GET[0][('preview_id')]) && Aspis_isset( $_GET [0][('preview_id')]))) && ((isset($_GET[0][('preview_nonce')]) && Aspis_isset( $_GET [0][('preview_nonce')])))))
 {$id = int_cast($_GET[0]['preview_id']);
if ( (false == deAspis(wp_verify_nonce($_GET[0]['preview_nonce'],concat1('post_preview_',$id)))))
 wp_die(__(array('You do not have permission to preview drafts.',false)));
add_filter(array('the_preview',false),array('_set_preview',false));
} }
