<?php require_once('AspisMain.php'); ?><?php
function create_initial_post_types (  ) {
register_post_type('post',array('exclude_from_search' => false));
register_post_type('page',array('exclude_from_search' => false));
register_post_type('attachment',array('exclude_from_search' => false));
register_post_type('revision',array('exclude_from_search' => true));
 }
add_action('init','create_initial_post_types',0);
function get_attached_file ( $attachment_id,$unfiltered = false ) {
$file = get_post_meta($attachment_id,'_wp_attached_file',true);
if ( 0 !== strpos($file,'/') && !preg_match('|^.:\\\|',$file) && (($uploads = wp_upload_dir()) && false === $uploads['error']))
 $file = $uploads['basedir'] . "/$file";
if ( $unfiltered)
 {$AspisRetTemp = $file;
return $AspisRetTemp;
}{$AspisRetTemp = apply_filters('get_attached_file',$file,$attachment_id);
return $AspisRetTemp;
} }
function update_attached_file ( $attachment_id,$file ) {
if ( !get_post($attachment_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$file = apply_filters('update_attached_file',$file,$attachment_id);
$file = _wp_relative_upload_path($file);
{$AspisRetTemp = update_post_meta($attachment_id,'_wp_attached_file',$file);
return $AspisRetTemp;
} }
function _wp_relative_upload_path ( $path ) {
$new_path = $path;
if ( ($uploads = wp_upload_dir()) && false === $uploads['error'])
 {if ( 0 === strpos($new_path,$uploads['basedir']))
 {$new_path = str_replace($uploads['basedir'],'',$new_path);
$new_path = ltrim($new_path,'/');
}}{$AspisRetTemp = apply_filters('_wp_relative_upload_path',$new_path,$path);
return $AspisRetTemp;
} }
function &get_children ( $args = '',$output = OBJECT ) {
$kids = array();
if ( empty($args))
 {if ( isset($GLOBALS[0]['post']))
 {$args = array('post_parent' => (int)$GLOBALS[0]['post']->post_parent);
}else 
{{{$AspisRetTemp = &$kids;
return $AspisRetTemp;
}}}}elseif ( is_object($args))
 {$args = array('post_parent' => (int)$args->post_parent);
}elseif ( is_numeric($args))
 {$args = array('post_parent' => (int)$args);
}$defaults = array('numberposts' => -1,'post_type' => 'any','post_status' => 'any','post_parent' => 0,);
$r = wp_parse_args($args,$defaults);
$children = get_posts($r);
if ( !$children)
 {$AspisRetTemp = &$kids;
return $AspisRetTemp;
}update_post_cache($children);
foreach ( $children as $key =>$child )
$kids[$child->ID] = &$children[$key];
if ( $output == OBJECT)
 {{$AspisRetTemp = &$kids;
return $AspisRetTemp;
}}elseif ( $output == ARRAY_A)
 {foreach ( (array)$kids as $kid  )
$weeuns[$kid->ID] = get_object_vars($kids[$kid->ID]);
{$AspisRetTemp = &$weeuns;
return $AspisRetTemp;
}}elseif ( $output == ARRAY_N)
 {foreach ( (array)$kids as $kid  )
$babes[$kid->ID] = array_values(get_object_vars($kids[$kid->ID]));
{$AspisRetTemp = &$babes;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = &$kids;
return $AspisRetTemp;
}}} }
function get_extended ( $post ) {
if ( preg_match('/<!--more(.*?)?-->/',$post,$matches))
 {list($main,$extended) = explode($matches[0],$post,2);
}else 
{{$main = $post;
$extended = '';
}}$main = preg_replace('/^[\s]*(.*)[\s]*$/','\\1',$main);
$extended = preg_replace('/^[\s]*(.*)[\s]*$/','\\1',$extended);
{$AspisRetTemp = array('main' => $main,'extended' => $extended);
return $AspisRetTemp;
} }
function &get_post ( &$post,$output = OBJECT,$filter = 'raw' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$null = null;
if ( empty($post))
 {if ( isset($GLOBALS[0]['post']))
 $_post = &$GLOBALS[0]['post'];
else 
{{$AspisRetTemp = &$null;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}elseif ( is_object($post) && empty($post->filter))
 {_get_post_ancestors($post);
$_post = sanitize_post($post,'raw');
wp_cache_add($post->ID,$_post,'posts');
}else 
{{if ( is_object($post))
 $post = $post->ID;
$post = (int)$post;
if ( !$_post = wp_cache_get($post,'posts'))
 {$_post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d LIMIT 1",$post));
if ( !$_post)
 {$AspisRetTemp = &$null;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}_get_post_ancestors($_post);
$_post = sanitize_post($_post,'raw');
wp_cache_add($_post->ID,$_post,'posts');
}}}if ( $filter != 'raw')
 $_post = sanitize_post($_post,$filter);
if ( $output == OBJECT)
 {{$AspisRetTemp = &$_post;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( $output == ARRAY_A)
 {$__post = get_object_vars($_post);
{$AspisRetTemp = &$__post;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( $output == ARRAY_N)
 {$__post = array_values(get_object_vars($_post));
{$AspisRetTemp = &$__post;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = &$_post;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_post_ancestors ( $post ) {
$post = get_post($post);
if ( !empty($post->ancestors))
 {$AspisRetTemp = $post->ancestors;
return $AspisRetTemp;
}{$AspisRetTemp = array();
return $AspisRetTemp;
} }
function get_post_field ( $field,$post,$context = 'display' ) {
$post = (int)$post;
$post = get_post($post);
if ( is_wp_error($post))
 {$AspisRetTemp = $post;
return $AspisRetTemp;
}if ( !is_object($post))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}if ( !isset($post->$field))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = sanitize_post_field($field,$post->$field,$post->ID,$context);
return $AspisRetTemp;
} }
function get_post_mime_type ( $ID = '' ) {
$post = &get_post($ID);
if ( is_object($post))
 {$AspisRetTemp = $post->post_mime_type;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function get_post_status ( $ID = '' ) {
$post = get_post($ID);
if ( is_object($post))
 {if ( ('attachment' == $post->post_type) && $post->post_parent && ($post->ID != $post->post_parent))
 {$AspisRetTemp = get_post_status($post->post_parent);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = $post->post_status;
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function get_post_statuses (  ) {
$status = array('draft' => __('Draft'),'pending' => __('Pending Review'),'private' => __('Private'),'publish' => __('Published'));
{$AspisRetTemp = $status;
return $AspisRetTemp;
} }
function get_page_statuses (  ) {
$status = array('draft' => __('Draft'),'private' => __('Private'),'publish' => __('Published'));
{$AspisRetTemp = $status;
return $AspisRetTemp;
} }
function get_post_type ( $post = false ) {
{global $posts;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $posts,"\$posts",$AspisChangesCache);
}if ( false === $post)
 $post = $posts[0];
elseif ( (int)$post)
 $post = get_post($post,OBJECT);
if ( is_object($post))
 {$AspisRetTemp = $post->post_type;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$posts",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$posts",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$posts",$AspisChangesCache);
 }
function get_post_types ( $args = array(),$output = 'names' ) {
{global $wp_post_types;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_post_types,"\$wp_post_types",$AspisChangesCache);
}$do_names = false;
if ( 'names' == $output)
 $do_names = true;
$post_types = array();
foreach ( (array)$wp_post_types as $post_type  )
{if ( empty($args))
 {if ( $do_names)
 $post_types[] = $post_type->name;
else 
{$post_types[] = $post_type;
}}elseif ( array_intersect_assoc((array)$post_type,$args))
 {if ( $do_names)
 $post_types[] = $post_type->name;
else 
{$post_types[] = $post_type;
}}}{$AspisRetTemp = $post_types;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_post_types",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_post_types",$AspisChangesCache);
 }
function register_post_type ( $post_type,$args = array() ) {
{global $wp_post_types;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_post_types,"\$wp_post_types",$AspisChangesCache);
}if ( !is_array($wp_post_types))
 $wp_post_types = array();
$defaults = array('exclude_from_search' => true);
$args = wp_parse_args($args,$defaults);
$post_type = sanitize_user($post_type,true);
$args['name'] = $post_type;
$wp_post_types[$post_type] = (object)$args;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_post_types",$AspisChangesCache);
 }
function set_post_type ( $post_id = 0,$post_type = 'post' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post_type = sanitize_post_field('post_type',$post_type,$post_id,'db');
$return = $wpdb->update($wpdb->posts,array('post_type' => $post_type),array('ID' => $post_id));
if ( 'page' == $post_type)
 clean_page_cache($post_id);
else 
{clean_post_cache($post_id);
}{$AspisRetTemp = $return;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_posts ( $args = null ) {
$defaults = array('numberposts' => 5,'offset' => 0,'category' => 0,'orderby' => 'post_date','order' => 'DESC','include' => '','exclude' => '','meta_key' => '','meta_value' => '','post_type' => 'post','suppress_filters' => true);
$r = wp_parse_args($args,$defaults);
if ( empty($r['post_status']))
 $r['post_status'] = ('attachment' == $r['post_type']) ? 'inherit' : 'publish';
if ( !empty($r['numberposts']))
 $r['posts_per_page'] = $r['numberposts'];
if ( !empty($r['category']))
 $r['cat'] = $r['category'];
if ( !empty($r['include']))
 {$incposts = preg_split('/[\s,]+/',$r['include']);
$r['posts_per_page'] = count($incposts);
$r['post__in'] = $incposts;
}elseif ( !empty($r['exclude']))
 $r['post__not_in'] = preg_split('/[\s,]+/',$r['exclude']);
$r['caller_get_posts'] = true;
$get_posts = new WP_Query;
{$AspisRetTemp = $get_posts->query($r);
return $AspisRetTemp;
} }
function add_post_meta ( $post_id,$meta_key,$meta_value,$unique = false ) {
if ( $the_post = wp_is_post_revision($post_id))
 $post_id = $the_post;
{$AspisRetTemp = add_metadata('post',$post_id,$meta_key,$meta_value,$unique);
return $AspisRetTemp;
} }
function delete_post_meta ( $post_id,$meta_key,$meta_value = '' ) {
if ( $the_post = wp_is_post_revision($post_id))
 $post_id = $the_post;
{$AspisRetTemp = delete_metadata('post',$post_id,$meta_key,$meta_value);
return $AspisRetTemp;
} }
function get_post_meta ( $post_id,$key,$single = false ) {
{$AspisRetTemp = get_metadata('post',$post_id,$key,$single);
return $AspisRetTemp;
} }
function update_post_meta ( $post_id,$meta_key,$meta_value,$prev_value = '' ) {
if ( $the_post = wp_is_post_revision($post_id))
 $post_id = $the_post;
{$AspisRetTemp = update_metadata('post',$post_id,$meta_key,$meta_value,$prev_value);
return $AspisRetTemp;
} }
function delete_post_meta_by_key ( $post_meta_key ) {
if ( !$post_meta_key)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post_ids = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT post_id FROM $wpdb->postmeta WHERE meta_key = %s",$post_meta_key));
if ( $post_ids)
 {$postmetaids = $wpdb->get_col($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE meta_key = %s",$post_meta_key));
$in = implode(',',array_fill(1,count($postmetaids),'%d'));
do_action('delete_postmeta',$postmetaids);
$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE meta_id IN($in)",$postmetaids));
do_action('deleted_postmeta',$postmetaids);
foreach ( $post_ids as $post_id  )
wp_cache_delete($post_id,'post_meta');
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_post_custom ( $post_id = 0 ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}if ( !$post_id)
 $post_id = (int)$id;
$post_id = (int)$post_id;
if ( !wp_cache_get($post_id,'post_meta'))
 update_postmeta_cache($post_id);
{$AspisRetTemp = wp_cache_get($post_id,'post_meta');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function get_post_custom_keys ( $post_id = 0 ) {
$custom = get_post_custom($post_id);
if ( !is_array($custom))
 {return ;
}if ( $keys = array_keys($custom))
 {$AspisRetTemp = $keys;
return $AspisRetTemp;
} }
function get_post_custom_values ( $key = '',$post_id = 0 ) {
if ( !$key)
 {$AspisRetTemp = null;
return $AspisRetTemp;
}$custom = get_post_custom($post_id);
{$AspisRetTemp = isset($custom[$key]) ? $custom[$key] : null;
return $AspisRetTemp;
} }
function is_sticky ( $post_id = null ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}$post_id = absint($post_id);
if ( !$post_id)
 $post_id = absint($id);
$stickies = get_option('sticky_posts');
if ( !is_array($stickies))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}if ( in_array($post_id,$stickies))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function sanitize_post ( $post,$context = 'display' ) {
if ( is_object($post))
 {if ( isset($post->filter) && $context == $post->filter)
 {$AspisRetTemp = $post;
return $AspisRetTemp;
}if ( !isset($post->ID))
 $post->ID = 0;
foreach ( array_keys(get_object_vars($post)) as $field  )
$post->$field = sanitize_post_field($field,$post->$field,$post->ID,$context);
$post->filter = $context;
}else 
{{if ( isset($post['filter']) && $context == $post['filter'])
 {$AspisRetTemp = $post;
return $AspisRetTemp;
}if ( !isset($post['ID']))
 $post['ID'] = 0;
foreach ( array_keys($post) as $field  )
$post[$field] = sanitize_post_field($field,$post[$field],$post['ID'],$context);
$post['filter'] = $context;
}}{$AspisRetTemp = $post;
return $AspisRetTemp;
} }
function sanitize_post_field ( $field,$value,$post_id,$context ) {
$int_fields = array('ID','post_parent','menu_order');
if ( in_array($field,$int_fields))
 $value = (int)$value;
if ( 'raw' == $context)
 {$AspisRetTemp = $value;
return $AspisRetTemp;
}$prefixed = false;
if ( false !== strpos($field,'post_'))
 {$prefixed = true;
$field_no_prefix = str_replace('post_','',$field);
}if ( 'edit' == $context)
 {$format_to_edit = array('post_content','post_excerpt','post_title','post_password');
if ( $prefixed)
 {$value = apply_filters("edit_$field",$value,$post_id);
$value = apply_filters("${field_no_prefix}_edit_pre",$value,$post_id);
}else 
{{$value = apply_filters("edit_post_$field",$value,$post_id);
}}if ( in_array($field,$format_to_edit))
 {if ( 'post_content' == $field)
 $value = format_to_edit($value,user_can_richedit());
else 
{$value = format_to_edit($value);
}}else 
{{$value = esc_attr($value);
}}}else 
{if ( 'db' == $context)
 {if ( $prefixed)
 {$value = apply_filters("pre_$field",$value);
$value = apply_filters("${field_no_prefix}_save_pre",$value);
}else 
{{$value = apply_filters("pre_post_$field",$value);
$value = apply_filters("${field}_pre",$value);
}}}else 
{{if ( $prefixed)
 $value = apply_filters($field,$value,$post_id,$context);
else 
{$value = apply_filters("post_$field",$value,$post_id,$context);
}}}}if ( 'attribute' == $context)
 $value = esc_attr($value);
else 
{if ( 'js' == $context)
 $value = esc_js($value);
}{$AspisRetTemp = $value;
return $AspisRetTemp;
} }
function stick_post ( $post_id ) {
$stickies = get_option('sticky_posts');
if ( !is_array($stickies))
 $stickies = array($post_id);
if ( !in_array($post_id,$stickies))
 $stickies[] = $post_id;
update_option('sticky_posts',$stickies);
 }
function unstick_post ( $post_id ) {
$stickies = get_option('sticky_posts');
if ( !is_array($stickies))
 {return ;
}if ( !in_array($post_id,$stickies))
 {return ;
}$offset = array_search($post_id,$stickies);
if ( false === $offset)
 {return ;
}array_splice($stickies,$offset,1);
update_option('sticky_posts',$stickies);
 }
function wp_count_posts ( $type = 'post',$perm = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$user = wp_get_current_user();
$cache_key = $type;
$query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE post_type = %s";
if ( 'readable' == $perm && is_user_logged_in())
 {if ( !current_user_can("read_private_{$type}s"))
 {$cache_key .= '_' . $perm . '_' . $user->ID;
$query .= " AND (post_status != 'private' OR ( post_author = '$user->ID' AND post_status = 'private' ))";
}}$query .= ' GROUP BY post_status';
$count = wp_cache_get($cache_key,'counts');
if ( false !== $count)
 {$AspisRetTemp = $count;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$count = $wpdb->get_results($wpdb->prepare($query,$type),ARRAY_A);
$stats = array('publish' => 0,'private' => 0,'draft' => 0,'pending' => 0,'future' => 0,'trash' => 0);
foreach ( (array)$count as $row_num =>$row )
{$stats[$row['post_status']] = $row['num_posts'];
}$stats = (object)$stats;
wp_cache_set($cache_key,$stats,'counts');
{$AspisRetTemp = $stats;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_count_attachments ( $mime_type = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$and = wp_post_mime_type_where($mime_type);
$count = $wpdb->get_results("SELECT post_mime_type, COUNT( * ) AS num_posts FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status != 'trash' $and GROUP BY post_mime_type",ARRAY_A);
$stats = array();
foreach ( (array)$count as $row  )
{$stats[$row['post_mime_type']] = $row['num_posts'];
}$stats['trash'] = $wpdb->get_var("SELECT COUNT( * ) FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status = 'trash' $and");
{$AspisRetTemp = (object)$stats;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_match_mime_types ( $wildcard_mime_types,$real_mime_types ) {
$matches = array();
if ( is_string($wildcard_mime_types))
 $wildcard_mime_types = array_map('trim',explode(',',$wildcard_mime_types));
if ( is_string($real_mime_types))
 $real_mime_types = array_map('trim',explode(',',$real_mime_types));
$wild = '[-._a-z0-9]*';
foreach ( (array)$wildcard_mime_types as $type  )
{$type = str_replace('*',$wild,$type);
$patternses[1][$type] = "^$type$";
if ( false === strpos($type,'/'))
 {$patternses[2][$type] = "^$type/";
$patternses[3][$type] = $type;
}}asort($patternses);
foreach ( $patternses as $patterns  )
foreach ( $patterns as $type =>$pattern )
foreach ( (array)$real_mime_types as $real  )
if ( preg_match("#$pattern#",$real) && (empty($matches[$type]) || false === array_search($real,$matches[$type])))
 $matches[$type][] = $real;
{$AspisRetTemp = $matches;
return $AspisRetTemp;
} }
function wp_post_mime_type_where ( $post_mime_types ) {
$where = '';
$wildcards = array('','%','%/%');
if ( is_string($post_mime_types))
 $post_mime_types = array_map('trim',explode(',',$post_mime_types));
foreach ( (array)$post_mime_types as $mime_type  )
{$mime_type = preg_replace('/\s/','',$mime_type);
$slashpos = strpos($mime_type,'/');
if ( false !== $slashpos)
 {$mime_group = preg_replace('/[^-*.a-zA-Z0-9]/','',substr($mime_type,0,$slashpos));
$mime_subgroup = preg_replace('/[^-*.+a-zA-Z0-9]/','',substr($mime_type,$slashpos + 1));
if ( empty($mime_subgroup))
 $mime_subgroup = '*';
else 
{$mime_subgroup = str_replace('/','',$mime_subgroup);
}$mime_pattern = "$mime_group/$mime_subgroup";
}else 
{{$mime_pattern = preg_replace('/[^-*.a-zA-Z0-9]/','',$mime_type);
if ( false === strpos($mime_pattern,'*'))
 $mime_pattern .= '/*';
}}$mime_pattern = preg_replace('/\*+/','%',$mime_pattern);
if ( in_array($mime_type,$wildcards))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}if ( false !== strpos($mime_pattern,'%'))
 $wheres[] = "post_mime_type LIKE '$mime_pattern'";
else 
{$wheres[] = "post_mime_type = '$mime_pattern'";
}}if ( !empty($wheres))
 $where = ' AND (' . join(' OR ',$wheres) . ') ';
{$AspisRetTemp = $where;
return $AspisRetTemp;
} }
function wp_delete_post ( $postid = 0,$force_delete = false ) {
{global $wpdb,$wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}if ( !$post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d",$postid)))
 {$AspisRetTemp = $post;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}if ( !$force_delete && ($post->post_type == 'post' || $post->post_type == 'page') && get_post_status($postid) != 'trash' && EMPTY_TRASH_DAYS > 0)
 {$AspisRetTemp = wp_trash_post($postid);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}if ( $post->post_type == 'attachment')
 {$AspisRetTemp = wp_delete_attachment($postid,$force_delete);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}do_action('delete_post',$postid);
delete_post_meta($postid,'_wp_trash_meta_status');
delete_post_meta($postid,'_wp_trash_meta_time');
wp_delete_object_term_relationships($postid,get_object_taxonomies($post->post_type));
$parent_data = array('post_parent' => $post->post_parent);
$parent_where = array('post_parent' => $postid);
if ( 'page' == $post->post_type)
 {if ( get_option('page_on_front') == $postid)
 {update_option('show_on_front','posts');
delete_option('page_on_front');
}if ( get_option('page_for_posts') == $postid)
 {delete_option('page_for_posts');
}$children_query = $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_parent = %d AND post_type='page'",$postid);
$children = $wpdb->get_results($children_query);
$wpdb->update($wpdb->posts,$parent_data,$parent_where + array('post_type' => 'page'));
}else 
{{unstick_post($postid);
}}$revision_ids = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'revision'",$postid));
foreach ( $revision_ids as $revision_id  )
wp_delete_post_revision($revision_id);
$wpdb->update($wpdb->posts,$parent_data,$parent_where + array('post_type' => 'attachment'));
$comment_ids = $wpdb->get_col($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = %d",$postid));
if ( !empty($comment_ids))
 {do_action('delete_comment',$comment_ids);
$in_comment_ids = "'" . implode("', '",$comment_ids) . "'";
$wpdb->query("DELETE FROM $wpdb->comments WHERE comment_ID IN($in_comment_ids)");
do_action('deleted_comment',$comment_ids);
}$post_meta_ids = $wpdb->get_col($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id = %d ",$postid));
if ( !empty($post_meta_ids))
 {do_action('delete_postmeta',$post_meta_ids);
$in_post_meta_ids = "'" . implode("', '",$post_meta_ids) . "'";
$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_id IN($in_post_meta_ids)");
do_action('deleted_postmeta',$post_meta_ids);
}do_action('delete_post',$postid);
$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->posts WHERE ID = %d",$postid));
do_action('deleted_post',$postid);
if ( 'page' == $post->post_type)
 {clean_page_cache($postid);
foreach ( (array)$children as $child  )
clean_page_cache($child->ID);
$wp_rewrite->flush_rules(false);
}else 
{{clean_post_cache($postid);
}}wp_clear_scheduled_hook('publish_future_post',$postid);
do_action('deleted_post',$postid);
{$AspisRetTemp = $post;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
 }
function wp_trash_post ( $post_id = 0 ) {
if ( EMPTY_TRASH_DAYS == 0)
 {$AspisRetTemp = wp_delete_post($post_id);
return $AspisRetTemp;
}if ( !$post = wp_get_single_post($post_id,ARRAY_A))
 {$AspisRetTemp = $post;
return $AspisRetTemp;
}if ( $post['post_status'] == 'trash')
 {$AspisRetTemp = false;
return $AspisRetTemp;
}do_action('trash_post',$post_id);
add_post_meta($post_id,'_wp_trash_meta_status',$post['post_status']);
add_post_meta($post_id,'_wp_trash_meta_time',time());
$post['post_status'] = 'trash';
wp_insert_post($post);
wp_trash_post_comments($post_id);
do_action('trashed_post',$post_id);
{$AspisRetTemp = $post;
return $AspisRetTemp;
} }
function wp_untrash_post ( $post_id = 0 ) {
if ( !$post = wp_get_single_post($post_id,ARRAY_A))
 {$AspisRetTemp = $post;
return $AspisRetTemp;
}if ( $post['post_status'] != 'trash')
 {$AspisRetTemp = false;
return $AspisRetTemp;
}do_action('untrash_post',$post_id);
$post_status = get_post_meta($post_id,'_wp_trash_meta_status',true);
$post['post_status'] = $post_status;
delete_post_meta($post_id,'_wp_trash_meta_status');
delete_post_meta($post_id,'_wp_trash_meta_time');
wp_insert_post($post);
wp_untrash_post_comments($post_id);
do_action('untrashed_post',$post_id);
{$AspisRetTemp = $post;
return $AspisRetTemp;
} }
function wp_trash_post_comments ( $post = null ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post = get_post($post);
if ( empty($post))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$post_id = $post->ID;
do_action('trash_post_comments',$post_id);
$comments = $wpdb->get_results($wpdb->prepare("SELECT comment_ID, comment_approved FROM $wpdb->comments WHERE comment_post_ID = %d",$post_id));
if ( empty($comments))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$statuses = array();
foreach ( $comments as $comment  )
$statuses[$comment->comment_ID] = $comment->comment_approved;
add_post_meta($post_id,'_wp_trash_meta_comments_status',$statuses);
$result = $wpdb->update($wpdb->comments,array('comment_approved' => 'post-trashed'),array('comment_post_ID' => $post_id));
clean_comment_cache(array_keys($statuses));
do_action('trashed_post_comments',$post_id,$statuses);
{$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_untrash_post_comments ( $post = null ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post = get_post($post);
if ( empty($post))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$post_id = $post->ID;
$statuses = get_post_meta($post_id,'_wp_trash_meta_comments_status',true);
if ( empty($statuses))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}do_action('untrash_post_comments',$post_id);
$group_by_status = array();
foreach ( $statuses as $comment_id =>$comment_status )
$group_by_status[$comment_status][] = $comment_id;
foreach ( $group_by_status as $status =>$comments )
{if ( 'post-trashed' == $status)
 $status = '0';
$comments_in = implode("', '",$comments);
$wpdb->query("UPDATE $wpdb->comments SET comment_approved = '$status' WHERE comment_ID IN ('" . $comments_in . "')");
}clean_comment_cache(array_keys($statuses));
delete_post_meta($post_id,'_wp_trash_meta_comments_status');
do_action('untrashed_post_comments',$post_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_get_post_categories ( $post_id = 0,$args = array() ) {
$post_id = (int)$post_id;
$defaults = array('fields' => 'ids');
$args = wp_parse_args($args,$defaults);
$cats = wp_get_object_terms($post_id,'category',$args);
{$AspisRetTemp = $cats;
return $AspisRetTemp;
} }
function wp_get_post_tags ( $post_id = 0,$args = array() ) {
{$AspisRetTemp = wp_get_post_terms($post_id,'post_tag',$args);
return $AspisRetTemp;
} }
function wp_get_post_terms ( $post_id = 0,$taxonomy = 'post_tag',$args = array() ) {
$post_id = (int)$post_id;
$defaults = array('fields' => 'all');
$args = wp_parse_args($args,$defaults);
$tags = wp_get_object_terms($post_id,$taxonomy,$args);
{$AspisRetTemp = $tags;
return $AspisRetTemp;
} }
function wp_get_recent_posts ( $num = 10 ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$num = (int)$num;
if ( $num)
 {$limit = "LIMIT $num";
}$sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'post' AND post_status IN ( 'draft', 'publish', 'future', 'pending', 'private' ) ORDER BY post_date DESC $limit";
$result = $wpdb->get_results($sql,ARRAY_A);
{$AspisRetTemp = $result ? $result : array();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_get_single_post ( $postid = 0,$mode = OBJECT ) {
$postid = (int)$postid;
$post = get_post($postid,$mode);
if ( $mode == OBJECT)
 {$post->post_category = wp_get_post_categories($postid);
$post->tags_input = wp_get_post_tags($postid,array('fields' => 'names'));
}else 
{{$post['post_category'] = wp_get_post_categories($postid);
$post['tags_input'] = wp_get_post_tags($postid,array('fields' => 'names'));
}}{$AspisRetTemp = $post;
return $AspisRetTemp;
} }
function wp_insert_post ( $postarr = array(),$wp_error = false ) {
{global $wpdb,$wp_rewrite,$user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($user_ID,"\$user_ID",$AspisChangesCache);
}$defaults = array('post_status' => 'draft','post_type' => 'post','post_author' => $user_ID,'ping_status' => get_option('default_ping_status'),'post_parent' => 0,'menu_order' => 0,'to_ping' => '','pinged' => '','post_password' => '','guid' => '','post_content_filtered' => '','post_excerpt' => '','import_id' => 0);
$postarr = wp_parse_args($postarr,$defaults);
$postarr = sanitize_post($postarr,'db');
extract(($postarr),EXTR_SKIP);
$update = false;
if ( !empty($ID))
 {$update = true;
$previous_status = get_post_field('post_status',$ID);
}else 
{{$previous_status = 'new';
}}if ( ('' == $post_content) && ('' == $post_title) && ('' == $post_excerpt) && ('attachment' != $post_type))
 {if ( $wp_error)
 {$AspisRetTemp = new WP_Error('empty_content',__('Content, title, and excerpt are empty.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}}}if ( empty($post_category) || 0 == count($post_category) || !is_array($post_category))
 {$post_category = array(get_option('default_category'));
}if ( !isset($tags_input))
 $tags_input = array();
if ( empty($post_author))
 $post_author = $user_ID;
if ( empty($post_status))
 $post_status = 'draft';
if ( empty($post_type))
 $post_type = 'post';
$post_ID = 0;
if ( $update)
 {$post_ID = (int)$ID;
$guid = get_post_field('guid',$post_ID);
}if ( 'pending' == $post_status && !current_user_can('publish_posts'))
 $post_name = '';
if ( !isset($post_name) || empty($post_name))
 {if ( !in_array($post_status,array('draft','pending')))
 $post_name = sanitize_title($post_title);
else 
{$post_name = '';
}}else 
{{$post_name = sanitize_title($post_name);
}}if ( empty($post_date) || '0000-00-00 00:00:00' == $post_date)
 $post_date = current_time('mysql');
if ( empty($post_date_gmt) || '0000-00-00 00:00:00' == $post_date_gmt)
 {if ( !in_array($post_status,array('draft','pending')))
 $post_date_gmt = get_gmt_from_date($post_date);
else 
{$post_date_gmt = '0000-00-00 00:00:00';
}}if ( $update || '0000-00-00 00:00:00' == $post_date)
 {$post_modified = current_time('mysql');
$post_modified_gmt = current_time('mysql',1);
}else 
{{$post_modified = $post_date;
$post_modified_gmt = $post_date_gmt;
}}if ( 'publish' == $post_status)
 {$now = gmdate('Y-m-d H:i:59');
if ( mysql2date('U',$post_date_gmt,false) > mysql2date('U',$now,false))
 $post_status = 'future';
}if ( empty($comment_status))
 {if ( $update)
 $comment_status = 'closed';
else 
{$comment_status = get_option('default_comment_status');
}}if ( empty($ping_status))
 $ping_status = get_option('default_ping_status');
if ( isset($to_ping))
 $to_ping = preg_replace('|\s+|',"\n",$to_ping);
else 
{$to_ping = '';
}if ( !isset($pinged))
 $pinged = '';
if ( isset($post_parent))
 $post_parent = (int)$post_parent;
else 
{$post_parent = 0;
}if ( !empty($post_ID))
 {if ( $post_parent == $post_ID)
 {$post_parent = 0;
}elseif ( !empty($post_parent))
 {$parent_post = get_post($post_parent);
if ( $parent_post->post_parent == $post_ID)
 $post_parent = 0;
}}if ( isset($menu_order))
 $menu_order = (int)$menu_order;
else 
{$menu_order = 0;
}if ( !isset($post_password) || 'private' == $post_status)
 $post_password = '';
$post_name = wp_unique_post_slug($post_name,$post_ID,$post_status,$post_type,$post_parent);
$data = compact(array('post_author','post_date','post_date_gmt','post_content','post_content_filtered','post_title','post_excerpt','post_status','post_type','comment_status','ping_status','post_password','post_name','to_ping','pinged','post_modified','post_modified_gmt','post_parent','menu_order','guid'));
$data = apply_filters('wp_insert_post_data',$data,$postarr);
$data = stripslashes_deep($data);
$where = array('ID' => $post_ID);
if ( $update)
 {do_action('pre_post_update',$post_ID);
if ( false === $wpdb->update($wpdb->posts,$data,$where))
 {if ( $wp_error)
 {$AspisRetTemp = new WP_Error('db_update_error',__('Could not update post in the database'),$wpdb->last_error);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}}}}else 
{{if ( isset($post_mime_type))
 $data['post_mime_type'] = stripslashes($post_mime_type);
if ( !empty($import_id))
 {$import_id = (int)$import_id;
if ( !$wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE ID = %d",$import_id)))
 {$data['ID'] = $import_id;
}}if ( false === $wpdb->insert($wpdb->posts,$data))
 {if ( $wp_error)
 {$AspisRetTemp = new WP_Error('db_insert_error',__('Could not insert post into the database'),$wpdb->last_error);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}}}$post_ID = (int)$wpdb->insert_id;
$where = array('ID' => $post_ID);
}}if ( empty($data['post_name']) && !in_array($data['post_status'],array('draft','pending')))
 {$data['post_name'] = sanitize_title($data['post_title'],$post_ID);
$wpdb->update($wpdb->posts,array('post_name' => $data['post_name']),$where);
}wp_set_post_categories($post_ID,$post_category);
if ( !empty($tags_input))
 wp_set_post_tags($post_ID,$tags_input);
if ( !empty($tax_input))
 {foreach ( $tax_input as $taxonomy =>$tags )
{wp_set_post_terms($post_ID,$tags,$taxonomy);
}}$current_guid = get_post_field('guid',$post_ID);
if ( 'page' == $data['post_type'])
 clean_page_cache($post_ID);
else 
{clean_post_cache($post_ID);
}if ( !$update && '' == $current_guid)
 $wpdb->update($wpdb->posts,array('guid' => get_permalink($post_ID)),$where);
$post = get_post($post_ID);
if ( !empty($page_template) && 'page' == $data['post_type'])
 {$post->page_template = $page_template;
$page_templates = get_page_templates();
if ( 'default' != $page_template && !in_array($page_template,$page_templates))
 {if ( $wp_error)
 {$AspisRetTemp = new WP_Error('invalid_page_template',__('The page template is invalid.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}}}update_post_meta($post_ID,'_wp_page_template',$page_template);
}wp_transition_post_status($data['post_status'],$previous_status,$post);
if ( $update)
 do_action('edit_post',$post_ID,$post);
do_action('save_post',$post_ID,$post);
do_action('wp_insert_post',$post_ID,$post);
{$AspisRetTemp = $post_ID;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$user_ID",$AspisChangesCache);
 }
function wp_update_post ( $postarr = array() ) {
if ( is_object($postarr))
 {$postarr = get_object_vars($postarr);
$postarr = deAspisWarningRC(add_magic_quotes(attAspisRCO($postarr)));
}$post = wp_get_single_post($postarr['ID'],ARRAY_A);
$post = deAspisWarningRC(add_magic_quotes(attAspisRCO($post)));
if ( isset($postarr['post_category']) && is_array($postarr['post_category']) && 0 != count($postarr['post_category']))
 $post_cats = $postarr['post_category'];
else 
{$post_cats = $post['post_category'];
}if ( in_array($post['post_status'],array('draft','pending')) && empty($postarr['edit_date']) && ('0000-00-00 00:00:00' == $post['post_date_gmt']))
 $clear_date = true;
else 
{$clear_date = false;
}$postarr = array_merge($post,$postarr);
$postarr['post_category'] = $post_cats;
if ( $clear_date)
 {$postarr['post_date'] = current_time('mysql');
$postarr['post_date_gmt'] = '';
}if ( $postarr['post_type'] == 'attachment')
 {$AspisRetTemp = wp_insert_attachment($postarr);
return $AspisRetTemp;
}{$AspisRetTemp = wp_insert_post($postarr);
return $AspisRetTemp;
} }
function wp_publish_post ( $post_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post = get_post($post_id);
if ( empty($post))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}if ( 'publish' == $post->post_status)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$wpdb->update($wpdb->posts,array('post_status' => 'publish'),array('ID' => $post_id));
$old_status = $post->post_status;
$post->post_status = 'publish';
wp_transition_post_status('publish',$old_status,$post);
foreach ( (array)get_object_taxonomies('post') as $taxonomy  )
{$tt_ids = wp_get_object_terms($post_id,$taxonomy,'fields=tt_ids');
wp_update_term_count($tt_ids,$taxonomy);
}do_action('edit_post',$post_id,$post);
do_action('save_post',$post_id,$post);
do_action('wp_insert_post',$post_id,$post);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function check_and_publish_future_post ( $post_id ) {
$post = get_post($post_id);
if ( empty($post))
 {return ;
}if ( 'future' != $post->post_status)
 {return ;
}$time = strtotime($post->post_date_gmt . ' GMT');
if ( $time > time())
 {wp_clear_scheduled_hook('publish_future_post',$post_id);
wp_schedule_single_event($time,'publish_future_post',array($post_id));
{return ;
}}{$AspisRetTemp = wp_publish_post($post_id);
return $AspisRetTemp;
} }
function wp_unique_post_slug ( $slug,$post_ID,$post_status,$post_type,$post_parent ) {
if ( in_array($post_status,array('draft','pending')))
 {$AspisRetTemp = $slug;
return $AspisRetTemp;
}{global $wpdb,$wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$feeds = $wp_rewrite->feeds;
if ( !is_array($feeds))
 $feeds = array();
$hierarchical_post_types = apply_filters('hierarchical_post_types',array('page'));
if ( 'attachment' == $post_type)
 {$check_sql = "SELECT post_name FROM $wpdb->posts WHERE post_name = %s AND ID != %d LIMIT 1";
$post_name_check = $wpdb->get_var($wpdb->prepare($check_sql,$slug,$post_ID));
if ( $post_name_check || in_array($slug,$feeds))
 {$suffix = 2;
do {$alt_post_name = substr($slug,0,200 - (strlen($suffix) + 1)) . "-$suffix";
$post_name_check = $wpdb->get_var($wpdb->prepare($check_sql,$alt_post_name,$post_ID));
$suffix++;
}while ($post_name_check )
;
$slug = $alt_post_name;
}}elseif ( in_array($post_type,$hierarchical_post_types))
 {$check_sql = "SELECT post_name FROM $wpdb->posts WHERE post_name = %s AND post_type IN ( '" . implode("', '",deAspisWarningRC(esc_sql(attAspisRCO($hierarchical_post_types)))) . "' ) AND ID != %d AND post_parent = %d LIMIT 1";
$post_name_check = $wpdb->get_var($wpdb->prepare($check_sql,$slug,$post_ID,$post_parent));
if ( $post_name_check || in_array($slug,$feeds))
 {$suffix = 2;
do {$alt_post_name = substr($slug,0,200 - (strlen($suffix) + 1)) . "-$suffix";
$post_name_check = $wpdb->get_var($wpdb->prepare($check_sql,$alt_post_name,$post_ID,$post_parent));
$suffix++;
}while ($post_name_check )
;
$slug = $alt_post_name;
}}else 
{{$check_sql = "SELECT post_name FROM $wpdb->posts WHERE post_name = %s AND post_type = %s AND ID != %d LIMIT 1";
$post_name_check = $wpdb->get_var($wpdb->prepare($check_sql,$slug,$post_type,$post_ID));
if ( $post_name_check || in_array($slug,$wp_rewrite->feeds))
 {$suffix = 2;
do {$alt_post_name = substr($slug,0,200 - (strlen($suffix) + 1)) . "-$suffix";
$post_name_check = $wpdb->get_var($wpdb->prepare($check_sql,$alt_post_name,$post_type,$post_ID));
$suffix++;
}while ($post_name_check )
;
$slug = $alt_post_name;
}}}{$AspisRetTemp = $slug;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
 }
function wp_add_post_tags ( $post_id = 0,$tags = '' ) {
{$AspisRetTemp = wp_set_post_tags($post_id,$tags,true);
return $AspisRetTemp;
} }
function wp_set_post_tags ( $post_id = 0,$tags = '',$append = false ) {
{$AspisRetTemp = wp_set_post_terms($post_id,$tags,'post_tag',$append);
return $AspisRetTemp;
} }
function wp_set_post_terms ( $post_id = 0,$tags = '',$taxonomy = 'post_tag',$append = false ) {
$post_id = (int)$post_id;
if ( !$post_id)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( empty($tags))
 $tags = array();
$tags = is_array($tags) ? $tags : explode(',',trim($tags," \n\t\r\0\x0B,"));
wp_set_object_terms($post_id,$tags,$taxonomy,$append);
 }
function wp_set_post_categories ( $post_ID = 0,$post_categories = array() ) {
$post_ID = (int)$post_ID;
if ( !is_array($post_categories) || 0 == count($post_categories) || empty($post_categories))
 $post_categories = array(get_option('default_category'));
else 
{if ( 1 == count($post_categories) && '' == $post_categories[0])
 {$AspisRetTemp = true;
return $AspisRetTemp;
}}$post_categories = array_map('intval',$post_categories);
$post_categories = array_unique($post_categories);
{$AspisRetTemp = wp_set_object_terms($post_ID,$post_categories,'category');
return $AspisRetTemp;
} }
function wp_transition_post_status ( $new_status,$old_status,$post ) {
do_action('transition_post_status',$new_status,$old_status,$post);
do_action("${old_status}_to_$new_status",$post);
do_action("${new_status}_$post->post_type",$post->ID,$post);
 }
function add_ping ( $post_id,$uri ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$pung = $wpdb->get_var($wpdb->prepare("SELECT pinged FROM $wpdb->posts WHERE ID = %d",$post_id));
$pung = trim($pung);
$pung = preg_split('/\s/',$pung);
$pung[] = $uri;
$new = implode("\n",$pung);
$new = apply_filters('add_ping',$new);
$new = stripslashes($new);
{$AspisRetTemp = $wpdb->update($wpdb->posts,array('pinged' => $new),array('ID' => $post_id));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_enclosed ( $post_id ) {
$custom_fields = get_post_custom($post_id);
$pung = array();
if ( !is_array($custom_fields))
 {$AspisRetTemp = $pung;
return $AspisRetTemp;
}foreach ( $custom_fields as $key =>$val )
{if ( 'enclosure' != $key || !is_array($val))
 continue ;
foreach ( $val as $enc  )
{$enclosure = split("\n",$enc);
$pung[] = trim($enclosure[0]);
}}$pung = apply_filters('get_enclosed',$pung);
{$AspisRetTemp = $pung;
return $AspisRetTemp;
} }
function get_pung ( $post_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$pung = $wpdb->get_var($wpdb->prepare("SELECT pinged FROM $wpdb->posts WHERE ID = %d",$post_id));
$pung = trim($pung);
$pung = preg_split('/\s/',$pung);
$pung = apply_filters('get_pung',$pung);
{$AspisRetTemp = $pung;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_to_ping ( $post_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$to_ping = $wpdb->get_var($wpdb->prepare("SELECT to_ping FROM $wpdb->posts WHERE ID = %d",$post_id));
$to_ping = trim($to_ping);
$to_ping = preg_split('/\s/',$to_ping,-1,PREG_SPLIT_NO_EMPTY);
$to_ping = apply_filters('get_to_ping',$to_ping);
{$AspisRetTemp = $to_ping;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function trackback_url_list ( $tb_list,$post_id ) {
if ( !empty($tb_list))
 {$postdata = wp_get_single_post($post_id,ARRAY_A);
extract(($postdata),EXTR_SKIP);
$excerpt = strip_tags($post_excerpt ? $post_excerpt : $post_content);
if ( strlen($excerpt) > 255)
 {$excerpt = substr($excerpt,0,252) . '...';
}$trackback_urls = explode(',',$tb_list);
foreach ( (array)$trackback_urls as $tb_url  )
{$tb_url = trim($tb_url);
trackback($tb_url,stripslashes($post_title),$excerpt,$post_id);
}} }
function get_all_page_ids (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !$page_ids = wp_cache_get('all_page_ids','posts'))
 {$page_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_type = 'page'");
wp_cache_add('all_page_ids',$page_ids,'posts');
}{$AspisRetTemp = $page_ids;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function &get_page ( &$page,$output = OBJECT,$filter = 'raw' ) {
if ( empty($page))
 {if ( isset($GLOBALS[0]['post']) && isset($GLOBALS[0]['post']->ID))
 {{$AspisRetTemp = get_post($GLOBALS[0]['post'],$output,$filter);
return $AspisRetTemp;
}}else 
{{$page = null;
{$AspisRetTemp = &$page;
return $AspisRetTemp;
}}}}$the_page = get_post($page,$output,$filter);
{$AspisRetTemp = &$the_page;
return $AspisRetTemp;
} }
function get_page_by_path ( $page_path,$output = OBJECT ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$page_path = rawurlencode(urldecode($page_path));
$page_path = str_replace('%2F','/',$page_path);
$page_path = str_replace('%20',' ',$page_path);
$page_paths = '/' . trim($page_path,'/');
$leaf_path = sanitize_title(basename($page_paths));
$page_paths = explode('/',$page_paths);
$full_path = '';
foreach ( (array)$page_paths as $pathdir  )
$full_path .= ($pathdir != '' ? '/' : '') . sanitize_title($pathdir);
$pages = $wpdb->get_results($wpdb->prepare("SELECT ID, post_name, post_parent FROM $wpdb->posts WHERE post_name = %s AND (post_type = 'page' OR post_type = 'attachment')",$leaf_path));
if ( empty($pages))
 {$AspisRetTemp = null;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}foreach ( $pages as $page  )
{$path = '/' . $leaf_path;
$curpage = $page;
while ( $curpage->post_parent != 0 )
{$curpage = $wpdb->get_row($wpdb->prepare("SELECT ID, post_name, post_parent FROM $wpdb->posts WHERE ID = %d and post_type='page'",$curpage->post_parent));
$path = '/' . $curpage->post_name . $path;
}if ( $path == $full_path)
 {$AspisRetTemp = get_page($page->ID,$output);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = null;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_page_by_title ( $page_title,$output = OBJECT ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$page = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='page'",$page_title));
if ( $page)
 {$AspisRetTemp = get_page($page,$output);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = null;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function &get_page_children ( $page_id,$pages ) {
$page_list = array();
foreach ( (array)$pages as $page  )
{if ( $page->post_parent == $page_id)
 {$page_list[] = $page;
if ( $children = get_page_children($page->ID,$pages))
 $page_list = array_merge($page_list,$children);
}}{$AspisRetTemp = &$page_list;
return $AspisRetTemp;
} }
function &get_page_hierarchy ( &$pages,$page_id = 0 ) {
if ( empty($pages))
 {$return = array();
{$AspisRetTemp = &$return;
return $AspisRetTemp;
}}$children = array();
foreach ( (array)$pages as $p  )
{$parent_id = intval($p->post_parent);
$children[$parent_id][] = $p;
}$result = array();
_page_traverse_name($page_id,$children,$result);
{$AspisRetTemp = &$result;
return $AspisRetTemp;
} }
function _page_traverse_name ( $page_id,&$children,&$result ) {
if ( isset($children[$page_id]))
 {foreach ( (array)$children[$page_id] as $child  )
{$result[$child->ID] = $child->post_name;
_page_traverse_name($child->ID,$children,$result);
}} }
function get_page_uri ( $page_id ) {
$page = get_page($page_id);
$uri = $page->post_name;
if ( $page->post_parent == $page->ID)
 {$AspisRetTemp = $uri;
return $AspisRetTemp;
}while ( $page->post_parent != 0 )
{$page = get_page($page->post_parent);
$uri = $page->post_name . "/" . $uri;
}{$AspisRetTemp = $uri;
return $AspisRetTemp;
} }
function &get_pages ( $args = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$defaults = array('child_of' => 0,'sort_order' => 'ASC','sort_column' => 'post_title','hierarchical' => 1,'exclude' => '','include' => '','meta_key' => '','meta_value' => '','authors' => '','parent' => -1,'exclude_tree' => '','number' => '','offset' => 0);
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
$number = (int)$number;
$offset = (int)$offset;
$cache = array();
$key = md5(serialize(compact(array_keys($defaults))));
if ( $cache = wp_cache_get('get_pages','posts'))
 {if ( is_array($cache) && isset($cache[$key]))
 {$pages = apply_filters('get_pages',$cache[$key],$r);
{$AspisRetTemp = &$pages;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}if ( !is_array($cache))
 $cache = array();
$inclusions = '';
if ( !empty($include))
 {$child_of = 0;
$parent = -1;
$exclude = '';
$meta_key = '';
$meta_value = '';
$hierarchical = false;
$incpages = preg_split('/[\s,]+/',$include);
if ( count($incpages))
 {foreach ( $incpages as $incpage  )
{if ( empty($inclusions))
 $inclusions = $wpdb->prepare(' AND ( ID = %d ',$incpage);
else 
{$inclusions .= $wpdb->prepare(' OR ID = %d ',$incpage);
}}}}if ( !empty($inclusions))
 $inclusions .= ')';
$exclusions = '';
if ( !empty($exclude))
 {$expages = preg_split('/[\s,]+/',$exclude);
if ( count($expages))
 {foreach ( $expages as $expage  )
{if ( empty($exclusions))
 $exclusions = $wpdb->prepare(' AND ( ID <> %d ',$expage);
else 
{$exclusions .= $wpdb->prepare(' AND ID <> %d ',$expage);
}}}}if ( !empty($exclusions))
 $exclusions .= ')';
$author_query = '';
if ( !empty($authors))
 {$post_authors = preg_split('/[\s,]+/',$authors);
if ( count($post_authors))
 {foreach ( $post_authors as $post_author  )
{if ( 0 == intval($post_author))
 {$post_author = get_userdatabylogin($post_author);
if ( empty($post_author))
 continue ;
if ( empty($post_author->ID))
 continue ;
$post_author = $post_author->ID;
}if ( '' == $author_query)
 $author_query = $wpdb->prepare(' post_author = %d ',$post_author);
else 
{$author_query .= $wpdb->prepare(' OR post_author = %d ',$post_author);
}}if ( '' != $author_query)
 $author_query = " AND ($author_query)";
}}$join = '';
$where = "$exclusions $inclusions ";
if ( !empty($meta_key) || !empty($meta_value))
 {$join = " LEFT JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id )";
$meta_key = stripslashes($meta_key);
$meta_value = stripslashes($meta_value);
if ( !empty($meta_key))
 $where .= $wpdb->prepare(" AND $wpdb->postmeta.meta_key = %s",$meta_key);
if ( !empty($meta_value))
 $where .= $wpdb->prepare(" AND $wpdb->postmeta.meta_value = %s",$meta_value);
}if ( $parent >= 0)
 $where .= $wpdb->prepare(' AND post_parent = %d ',$parent);
$query = "SELECT * FROM $wpdb->posts $join WHERE (post_type = 'page' AND post_status = 'publish') $where ";
$query .= $author_query;
$query .= " ORDER BY " . $sort_column . " " . $sort_order;
if ( !empty($number))
 $query .= ' LIMIT ' . $offset . ',' . $number;
$pages = $wpdb->get_results($query);
if ( empty($pages))
 {$pages = apply_filters('get_pages',array(),$r);
{$AspisRetTemp = &$pages;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}$num_pages = count($pages);
for ( $i = 0 ; $i < $num_pages ; $i++ )
{$pages[$i] = sanitize_post($pages[$i],'raw');
}update_page_cache($pages);
if ( $child_of || $hierarchical)
 $pages = &get_page_children($child_of,$pages);
if ( !empty($exclude_tree))
 {$exclude = (int)$exclude_tree;
$children = get_page_children($exclude,$pages);
$excludes = array();
foreach ( $children as $child  )
$excludes[] = $child->ID;
$excludes[] = $exclude;
$num_pages = count($pages);
for ( $i = 0 ; $i < $num_pages ; $i++ )
{if ( in_array($pages[$i]->ID,$excludes))
 unset($pages[$i]);
}}$cache[$key] = $pages;
wp_cache_set('get_pages',$cache,'posts');
$pages = apply_filters('get_pages',$pages,$r);
{$AspisRetTemp = &$pages;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function is_local_attachment ( $url ) {
if ( strpos($url,get_bloginfo('url')) === false)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( strpos($url,get_bloginfo('url') . '/?attachment_id=') !== false)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}if ( $id = url_to_postid($url))
 {$post = &get_post($id);
if ( 'attachment' == $post->post_type)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_insert_attachment ( $object,$file = false,$parent = 0 ) {
{global $wpdb,$user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($user_ID,"\$user_ID",$AspisChangesCache);
}$defaults = array('post_status' => 'draft','post_type' => 'post','post_author' => $user_ID,'ping_status' => get_option('default_ping_status'),'post_parent' => 0,'menu_order' => 0,'to_ping' => '','pinged' => '','post_password' => '','guid' => '','post_content_filtered' => '','post_excerpt' => '','import_id' => 0);
$object = wp_parse_args($object,$defaults);
if ( !empty($parent))
 $object['post_parent'] = $parent;
$object = sanitize_post($object,'db');
extract(($object),EXTR_SKIP);
if ( !isset($post_category) || 0 == count($post_category) || !is_array($post_category))
 {$post_category = array(get_option('default_category'));
}if ( empty($post_author))
 $post_author = $user_ID;
$post_type = 'attachment';
$post_status = 'inherit';
if ( !empty($ID))
 {$update = true;
$post_ID = (int)$ID;
}else 
{{$update = false;
$post_ID = 0;
}}if ( empty($post_name))
 $post_name = sanitize_title($post_title);
else 
{$post_name = sanitize_title($post_name);
}$post_name = wp_unique_post_slug($post_name,$post_ID,$post_status,$post_type,$post_parent);
if ( empty($post_date))
 $post_date = current_time('mysql');
if ( empty($post_date_gmt))
 $post_date_gmt = current_time('mysql',1);
if ( empty($post_modified))
 $post_modified = $post_date;
if ( empty($post_modified_gmt))
 $post_modified_gmt = $post_date_gmt;
if ( empty($comment_status))
 {if ( $update)
 $comment_status = 'closed';
else 
{$comment_status = get_option('default_comment_status');
}}if ( empty($ping_status))
 $ping_status = get_option('default_ping_status');
if ( isset($to_ping))
 $to_ping = preg_replace('|\s+|',"\n",$to_ping);
else 
{$to_ping = '';
}if ( isset($post_parent))
 $post_parent = (int)$post_parent;
else 
{$post_parent = 0;
}if ( isset($menu_order))
 $menu_order = (int)$menu_order;
else 
{$menu_order = 0;
}if ( !isset($post_password))
 $post_password = '';
if ( !isset($pinged))
 $pinged = '';
$data = compact(array('post_author','post_date','post_date_gmt','post_content','post_content_filtered','post_title','post_excerpt','post_status','post_type','comment_status','ping_status','post_password','post_name','to_ping','pinged','post_modified','post_modified_gmt','post_parent','menu_order','post_mime_type','guid'));
$data = stripslashes_deep($data);
if ( $update)
 {$wpdb->update($wpdb->posts,$data,array('ID' => $post_ID));
}else 
{{if ( !empty($import_id))
 {$import_id = (int)$import_id;
if ( !$wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE ID = %d",$import_id)))
 {$data['ID'] = $import_id;
}}$wpdb->insert($wpdb->posts,$data);
$post_ID = (int)$wpdb->insert_id;
}}if ( empty($post_name))
 {$post_name = sanitize_title($post_title,$post_ID);
$wpdb->update($wpdb->posts,compact("post_name"),array('ID' => $post_ID));
}wp_set_post_categories($post_ID,$post_category);
if ( $file)
 update_attached_file($post_ID,$file);
clean_post_cache($post_ID);
if ( isset($post_parent) && $post_parent < 0)
 add_post_meta($post_ID,'_wp_attachment_temp_parent',$post_parent,true);
if ( $update)
 {do_action('edit_attachment',$post_ID);
}else 
{{do_action('add_attachment',$post_ID);
}}{$AspisRetTemp = $post_ID;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$user_ID",$AspisChangesCache);
 }
function wp_delete_attachment ( $post_id,$force_delete = false ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !$post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d",$post_id)))
 {$AspisRetTemp = $post;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( 'attachment' != $post->post_type)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( !$force_delete && EMPTY_TRASH_DAYS && MEDIA_TRASH && 'trash' != $post->post_status)
 {$AspisRetTemp = wp_trash_post($post_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}delete_post_meta($post_id,'_wp_trash_meta_status');
delete_post_meta($post_id,'_wp_trash_meta_time');
$meta = wp_get_attachment_metadata($post_id);
$backup_sizes = get_post_meta($post->ID,'_wp_attachment_backup_sizes',true);
$file = get_attached_file($post_id);
do_action('delete_attachment',$post_id);
wp_delete_object_term_relationships($post_id,array('category','post_tag'));
wp_delete_object_term_relationships($post_id,get_object_taxonomies($post->post_type));
$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND meta_value = %d",$post_id));
$comment_ids = $wpdb->get_col($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = %d",$post_id));
if ( !empty($comment_ids))
 {do_action('delete_comment',$comment_ids);
$in_comment_ids = "'" . implode("', '",$comment_ids) . "'";
$wpdb->query("DELETE FROM $wpdb->comments WHERE comment_ID IN($in_comment_ids)");
do_action('deleted_comment',$comment_ids);
}$post_meta_ids = $wpdb->get_col($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id = %d ",$post_id));
if ( !empty($post_meta_ids))
 {do_action('delete_postmeta',$post_meta_ids);
$in_post_meta_ids = "'" . implode("', '",$post_meta_ids) . "'";
$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_id IN($in_post_meta_ids)");
do_action('deleted_postmeta',$post_meta_ids);
}do_action('delete_post',$post_id);
$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->posts WHERE ID = %d",$post_id));
do_action('deleted_post',$post_id);
$uploadpath = wp_upload_dir();
if ( !empty($meta['thumb']))
 {if ( !$wpdb->get_row($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE meta_key = '_wp_attachment_metadata' AND meta_value LIKE %s AND post_id <> %d",'%' . $meta['thumb'] . '%',$post_id)))
 {$thumbfile = str_replace(basename($file),$meta['thumb'],$file);
$thumbfile = apply_filters('wp_delete_file',$thumbfile);
@unlink(path_join($uploadpath['basedir'],$thumbfile));
}}$sizes = apply_filters('intermediate_image_sizes',array('thumbnail','medium','large'));
foreach ( $sizes as $size  )
{if ( $intermediate = image_get_intermediate_size($post_id,$size))
 {$intermediate_file = apply_filters('wp_delete_file',$intermediate['path']);
@unlink(path_join($uploadpath['basedir'],$intermediate_file));
}}if ( is_array($backup_sizes))
 {foreach ( $backup_sizes as $size  )
{$del_file = path_join(dirname($meta['file']),$size['file']);
$del_file = apply_filters('wp_delete_file',$del_file);
@unlink(path_join($uploadpath['basedir'],$del_file));
}}$file = apply_filters('wp_delete_file',$file);
if ( !empty($file))
 @unlink($file);
clean_post_cache($post_id);
{$AspisRetTemp = $post;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_get_attachment_metadata ( $post_id,$unfiltered = false ) {
$post_id = (int)$post_id;
if ( !$post = &get_post($post_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$data = get_post_meta($post->ID,'_wp_attachment_metadata',true);
if ( $unfiltered)
 {$AspisRetTemp = $data;
return $AspisRetTemp;
}{$AspisRetTemp = apply_filters('wp_get_attachment_metadata',$data,$post->ID);
return $AspisRetTemp;
} }
function wp_update_attachment_metadata ( $post_id,$data ) {
$post_id = (int)$post_id;
if ( !$post = &get_post($post_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$data = apply_filters('wp_update_attachment_metadata',$data,$post->ID);
{$AspisRetTemp = update_post_meta($post->ID,'_wp_attachment_metadata',$data);
return $AspisRetTemp;
} }
function wp_get_attachment_url ( $post_id = 0 ) {
$post_id = (int)$post_id;
if ( !$post = &get_post($post_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$url = '';
if ( $file = get_post_meta($post->ID,'_wp_attached_file',true))
 {if ( ($uploads = wp_upload_dir()) && false === $uploads['error'])
 {if ( 0 === strpos($file,$uploads['basedir']))
 $url = str_replace($uploads['basedir'],$uploads['baseurl'],$file);
elseif ( false !== strpos($file,'wp-content/uploads'))
 $url = $uploads['baseurl'] . substr($file,strpos($file,'wp-content/uploads') + 18);
else 
{$url = $uploads['baseurl'] . "/$file";
}}}if ( empty($url))
 $url = get_the_guid($post->ID);
if ( 'attachment' != $post->post_type || empty($url))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = apply_filters('wp_get_attachment_url',$url,$post->ID);
return $AspisRetTemp;
} }
function wp_get_attachment_thumb_file ( $post_id = 0 ) {
$post_id = (int)$post_id;
if ( !$post = &get_post($post_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !is_array($imagedata = wp_get_attachment_metadata($post->ID)))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$file = get_attached_file($post->ID);
if ( !empty($imagedata['thumb']) && ($thumbfile = str_replace(basename($file),$imagedata['thumb'],$file)) && file_exists($thumbfile))
 {$AspisRetTemp = apply_filters('wp_get_attachment_thumb_file',$thumbfile,$post->ID);
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_get_attachment_thumb_url ( $post_id = 0 ) {
$post_id = (int)$post_id;
if ( !$post = &get_post($post_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$url = wp_get_attachment_url($post->ID))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$sized = image_downsize($post_id,'thumbnail');
if ( $sized)
 {$AspisRetTemp = $sized[0];
return $AspisRetTemp;
}if ( !$thumb = wp_get_attachment_thumb_file($post->ID))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$url = str_replace(basename($url),basename($thumb),$url);
{$AspisRetTemp = apply_filters('wp_get_attachment_thumb_url',$url,$post->ID);
return $AspisRetTemp;
} }
function wp_attachment_is_image ( $post_id = 0 ) {
$post_id = (int)$post_id;
if ( !$post = &get_post($post_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$file = get_attached_file($post->ID))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$ext = preg_match('/\.([^.]+)$/',$file,$matches) ? strtolower($matches[1]) : false;
$image_exts = array('jpg','jpeg','gif','png');
if ( 'image/' == substr($post->post_mime_type,0,6) || $ext && 'import' == $post->post_mime_type && in_array($ext,$image_exts))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_mime_type_icon ( $mime = 0 ) {
if ( !is_numeric($mime))
 $icon = wp_cache_get("mime_type_icon_$mime");
if ( empty($icon))
 {$post_id = 0;
$post_mimes = array();
if ( is_numeric($mime))
 {$mime = (int)$mime;
if ( $post = &get_post($mime))
 {$post_id = (int)$post->ID;
$ext = preg_replace('/^.+?\.([^.]+)$/','$1',$post->guid);
if ( !empty($ext))
 {$post_mimes[] = $ext;
if ( $ext_type = wp_ext2type($ext))
 $post_mimes[] = $ext_type;
}$mime = $post->post_mime_type;
}else 
{{$mime = 0;
}}}else 
{{$post_mimes[] = $mime;
}}$icon_files = wp_cache_get('icon_files');
if ( !is_array($icon_files))
 {$icon_dir = apply_filters('icon_dir',ABSPATH . WPINC . '/images/crystal');
$icon_dir_uri = apply_filters('icon_dir_uri',includes_url('images/crystal'));
$dirs = apply_filters('icon_dirs',array($icon_dir => $icon_dir_uri));
$icon_files = array();
while ( $dirs )
{$dir = array_shift($keys = array_keys($dirs));
$uri = array_shift($dirs);
if ( $dh = opendir($dir))
 {while ( false !== $file = readdir($dh) )
{$file = basename($file);
if ( substr($file,0,1) == '.')
 continue ;
if ( !in_array(strtolower(substr($file,-4)),array('.png','.gif','.jpg')))
 {if ( is_dir("$dir/$file"))
 $dirs["$dir/$file"] = "$uri/$file";
continue ;
}$icon_files["$dir/$file"] = "$uri/$file";
}closedir($dh);
}}wp_cache_set('icon_files',$icon_files,600);
}foreach ( $icon_files as $file =>$uri )
$types[preg_replace('/^([^.]*).*$/','$1',basename($file))] = &$icon_files[$file];
if ( !empty($mime))
 {$post_mimes[] = substr($mime,0,strpos($mime,'/'));
$post_mimes[] = substr($mime,strpos($mime,'/') + 1);
$post_mimes[] = str_replace('/','_',$mime);
}$matches = wp_match_mime_types(array_keys($types),$post_mimes);
$matches['default'] = array('default');
foreach ( $matches as $match =>$wilds )
{if ( isset($types[$wilds[0]]))
 {$icon = $types[$wilds[0]];
if ( !is_numeric($mime))
 wp_cache_set("mime_type_icon_$mime",$icon);
break ;
}}}{$AspisRetTemp = apply_filters('wp_mime_type_icon',$icon,$mime,$post_id);
return $AspisRetTemp;
} }
function wp_check_for_changed_slugs ( $post_id ) {
if ( !(isset($_POST[0]['wp-old-slug']) && Aspis_isset($_POST[0]['wp-old-slug'])) || !strlen(deAspisWarningRC($_POST[0]['wp-old-slug'])))
 {$AspisRetTemp = $post_id;
return $AspisRetTemp;
}$post = &get_post($post_id);
if ( $post->post_status != 'publish' || $post->post_type != 'post')
 {$AspisRetTemp = $post_id;
return $AspisRetTemp;
}if ( $post->post_name == deAspisWarningRC($_POST[0]['wp-old-slug']))
 {$AspisRetTemp = $post_id;
return $AspisRetTemp;
}$old_slugs = (array)get_post_meta($post_id,'_wp_old_slug');
if ( !count($old_slugs) || !in_array(deAspisWarningRC($_POST[0]['wp-old-slug']),$old_slugs))
 add_post_meta($post_id,'_wp_old_slug',deAspisWarningRC($_POST[0]['wp-old-slug']));
if ( in_array($post->post_name,$old_slugs))
 delete_post_meta($post_id,'_wp_old_slug',$post->post_name);
{$AspisRetTemp = $post_id;
return $AspisRetTemp;
} }
function get_private_posts_cap_sql ( $post_type ) {
{global $user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $user_ID,"\$user_ID",$AspisChangesCache);
}$cap = '';
if ( $post_type == 'post')
 {$cap = 'read_private_posts';
}elseif ( $post_type == 'page')
 {$cap = 'read_private_pages';
}else 
{{$cap = apply_filters('pub_priv_sql_capability',$cap);
if ( empty($cap))
 {{$AspisRetTemp = '1 = 0';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}}}}$sql = '(post_status = \'publish\'';
if ( current_user_can($cap))
 {$sql .= ' OR post_status = \'private\'';
}elseif ( is_user_logged_in())
 {$sql .= ' OR post_status = \'private\' AND post_author = \'' . $user_ID . '\'';
}$sql .= ')';
{$AspisRetTemp = $sql;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
 }
function get_lastpostdate ( $timezone = 'server' ) {
{global $cache_lastpostdate,$wpdb,$blog_id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $cache_lastpostdate,"\$cache_lastpostdate",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($blog_id,"\$blog_id",$AspisChangesCache);
}$add_seconds_server = date('Z');
if ( !isset($cache_lastpostdate[$blog_id][$timezone]))
 {switch ( strtolower($timezone) ) {
case 'gmt':$lastpostdate = $wpdb->get_var("SELECT post_date_gmt FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date_gmt DESC LIMIT 1");
break ;
case 'blog':$lastpostdate = $wpdb->get_var("SELECT post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date_gmt DESC LIMIT 1");
break ;
case 'server':$lastpostdate = $wpdb->get_var("SELECT DATE_ADD(post_date_gmt, INTERVAL '$add_seconds_server' SECOND) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date_gmt DESC LIMIT 1");
break ;
 }
$cache_lastpostdate[$blog_id][$timezone] = $lastpostdate;
}else 
{{$lastpostdate = $cache_lastpostdate[$blog_id][$timezone];
}}{$AspisRetTemp = apply_filters('get_lastpostdate',$lastpostdate,$timezone);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$cache_lastpostdate",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$blog_id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$cache_lastpostdate",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$blog_id",$AspisChangesCache);
 }
function get_lastpostmodified ( $timezone = 'server' ) {
{global $cache_lastpostmodified,$wpdb,$blog_id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $cache_lastpostmodified,"\$cache_lastpostmodified",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($blog_id,"\$blog_id",$AspisChangesCache);
}$add_seconds_server = date('Z');
if ( !isset($cache_lastpostmodified[$blog_id][$timezone]))
 {switch ( strtolower($timezone) ) {
case 'gmt':$lastpostmodified = $wpdb->get_var("SELECT post_modified_gmt FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_modified_gmt DESC LIMIT 1");
break ;
case 'blog':$lastpostmodified = $wpdb->get_var("SELECT post_modified FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_modified_gmt DESC LIMIT 1");
break ;
case 'server':$lastpostmodified = $wpdb->get_var("SELECT DATE_ADD(post_modified_gmt, INTERVAL '$add_seconds_server' SECOND) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_modified_gmt DESC LIMIT 1");
break ;
 }
$lastpostdate = get_lastpostdate($timezone);
if ( $lastpostdate > $lastpostmodified)
 {$lastpostmodified = $lastpostdate;
}$cache_lastpostmodified[$blog_id][$timezone] = $lastpostmodified;
}else 
{{$lastpostmodified = $cache_lastpostmodified[$blog_id][$timezone];
}}{$AspisRetTemp = apply_filters('get_lastpostmodified',$lastpostmodified,$timezone);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$cache_lastpostmodified",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$blog_id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$cache_lastpostmodified",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$blog_id",$AspisChangesCache);
 }
function update_post_cache ( &$posts ) {
if ( !$posts)
 {return ;
}foreach ( $posts as $post  )
wp_cache_add($post->ID,$post,'posts');
 }
function clean_post_cache ( $id ) {
{global $_wp_suspend_cache_invalidation,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_suspend_cache_invalidation,"\$_wp_suspend_cache_invalidation",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( !empty($_wp_suspend_cache_invalidation))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_suspend_cache_invalidation",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return ;
}$id = (int)$id;
wp_cache_delete($id,'posts');
wp_cache_delete($id,'post_meta');
clean_object_term_cache($id,'post');
wp_cache_delete('wp_get_archives','general');
do_action('clean_post_cache',$id);
if ( $children = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_parent = %d",$id)))
 {foreach ( $children as $cid  )
clean_post_cache($cid);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_suspend_cache_invalidation",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function update_page_cache ( &$pages ) {
update_post_cache($pages);
 }
function clean_page_cache ( $id ) {
clean_post_cache($id);
wp_cache_delete('all_page_ids','posts');
wp_cache_delete('get_pages','posts');
do_action('clean_page_cache',$id);
 }
function update_post_caches ( &$posts ) {
if ( !$posts)
 {return ;
}update_post_cache($posts);
$post_ids = array();
for ( $i = 0 ; $i < count($posts) ; $i++ )
$post_ids[] = $posts[$i]->ID;
update_object_term_cache($post_ids,'post');
update_postmeta_cache($post_ids);
 }
function update_postmeta_cache ( $post_ids ) {
{$AspisRetTemp = update_meta_cache('post',$post_ids);
return $AspisRetTemp;
} }
function _transition_post_status ( $new_status,$old_status,$post ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( $old_status != 'publish' && $new_status == 'publish')
 {if ( '' == get_the_guid($post->ID))
 $wpdb->update($wpdb->posts,array('guid' => get_permalink($post->ID)),array('ID' => $post->ID));
do_action('private_to_published',$post->ID);
}wp_clear_scheduled_hook('publish_future_post',$post->ID);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function _future_post_hook ( $deprecated = '',$post ) {
wp_clear_scheduled_hook('publish_future_post',$post->ID);
wp_schedule_single_event(strtotime($post->post_date_gmt . ' GMT'),'publish_future_post',array($post->ID));
 }
function _publish_post_hook ( $post_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( defined('XMLRPC_REQUEST'))
 do_action('xmlrpc_publish_post',$post_id);
if ( defined('APP_REQUEST'))
 do_action('app_publish_post',$post_id);
if ( defined('WP_IMPORTING'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$data = array('post_id' => $post_id,'meta_value' => '1');
if ( get_option('default_pingback_flag'))
 {$wpdb->insert($wpdb->postmeta,$data + array('meta_key' => '_pingme'));
do_action('added_postmeta',$wpdb->insert_id,$post_id,'_pingme',1);
}$wpdb->insert($wpdb->postmeta,$data + array('meta_key' => '_encloseme'));
do_action('added_postmeta',$wpdb->insert_id,$post_id,'_encloseme',1);
wp_schedule_single_event(time(),'do_pings');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function _save_post_hook ( $post_id,$post ) {
if ( $post->post_type == 'page')
 {clean_page_cache($post_id);
if ( !defined('WP_IMPORTING'))
 {{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$wp_rewrite->flush_rules(false);
}}else 
{{clean_post_cache($post_id);
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function _get_post_ancestors ( &$_post ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( isset($_post->ancestors))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$_post->ancestors = array();
if ( empty($_post->post_parent) || $_post->ID == $_post->post_parent)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$id = $_post->ancestors[] = $_post->post_parent;
while ( $ancestor = $wpdb->get_var($wpdb->prepare("SELECT `post_parent` FROM $wpdb->posts WHERE ID = %d LIMIT 1",$id)) )
{if ( $id == $ancestor)
 break ;
$id = $_post->ancestors[] = $ancestor;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function _wp_post_revision_fields ( $post = null,$autosave = false ) {
static $fields = false;
if ( !$fields)
 {$fields = array('post_title' => __('Title'),'post_content' => __('Content'),'post_excerpt' => __('Excerpt'),);
$fields = apply_filters('_wp_post_revision_fields',$fields);
foreach ( array('ID','post_name','post_parent','post_date','post_date_gmt','post_status','post_type','comment_count','post_author') as $protect  )
unset($fields[$protect]);
}if ( !is_array($post))
 {$AspisRetTemp = $fields;
return $AspisRetTemp;
}$return = array();
foreach ( array_intersect(array_keys($post),array_keys($fields)) as $field  )
$return[$field] = $post[$field];
$return['post_parent'] = $post['ID'];
$return['post_status'] = 'inherit';
$return['post_type'] = 'revision';
$return['post_name'] = $autosave ? "$post[ID]-autosave" : "$post[ID]-revision";
$return['post_date'] = isset($post['post_modified']) ? $post['post_modified'] : '';
$return['post_date_gmt'] = isset($post['post_modified_gmt']) ? $post['post_modified_gmt'] : '';
{$AspisRetTemp = $return;
return $AspisRetTemp;
} }
function wp_save_post_revision ( $post_id ) {
if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
 {return ;
}if ( !constant('WP_POST_REVISIONS'))
 {return ;
}if ( !$post = get_post($post_id,ARRAY_A))
 {return ;
}if ( !in_array($post['post_type'],array('post','page')))
 {return ;
}$return = _wp_put_post_revision($post);
if ( !is_numeric(WP_POST_REVISIONS) || WP_POST_REVISIONS < 0)
 {$AspisRetTemp = $return;
return $AspisRetTemp;
}$revisions = wp_get_post_revisions($post_id,array('order' => 'ASC'));
$delete = count($revisions) - WP_POST_REVISIONS;
if ( $delete < 1)
 {$AspisRetTemp = $return;
return $AspisRetTemp;
}$revisions = array_slice($revisions,0,$delete);
for ( $i = 0 ; isset($revisions[$i]) ; $i++ )
{if ( false !== strpos($revisions[$i]->post_name,'autosave'))
 continue ;
wp_delete_post_revision($revisions[$i]->ID);
}{$AspisRetTemp = $return;
return $AspisRetTemp;
} }
function wp_get_post_autosave ( $post_id ) {
if ( !$post = get_post($post_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$q = array('name' => "{$post->ID}-autosave",'post_parent' => $post->ID,'post_type' => 'revision','post_status' => 'inherit');
$autosave_query = new WP_Query;
add_action('parse_query','_wp_get_post_autosave_hack');
$autosave = $autosave_query->query($q);
remove_action('parse_query','_wp_get_post_autosave_hack');
if ( $autosave && is_array($autosave) && is_object($autosave[0]))
 {$AspisRetTemp = $autosave[0];
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function _wp_get_post_autosave_hack ( $query ) {
$query->is_single = false;
 }
function wp_is_post_revision ( $post ) {
if ( !$post = wp_get_post_revision($post))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = (int)$post->post_parent;
return $AspisRetTemp;
} }
function wp_is_post_autosave ( $post ) {
if ( !$post = wp_get_post_revision($post))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( "{$post->post_parent}-autosave" !== $post->post_name)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = (int)$post->post_parent;
return $AspisRetTemp;
} }
function _wp_put_post_revision ( $post = null,$autosave = false ) {
if ( is_object($post))
 $post = get_object_vars($post);
elseif ( !is_array($post))
 $post = get_post($post,ARRAY_A);
if ( !$post || empty($post['ID']))
 {return ;
}if ( isset($post['post_type']) && 'revision' == $post['post_type'])
 {$AspisRetTemp = new WP_Error('post_type',__('Cannot create a revision of a revision'));
return $AspisRetTemp;
}$post = _wp_post_revision_fields($post,$autosave);
$post = deAspisWarningRC(add_magic_quotes(attAspisRCO($post)));
$revision_id = wp_insert_post($post);
if ( is_wp_error($revision_id))
 {$AspisRetTemp = $revision_id;
return $AspisRetTemp;
}if ( $revision_id)
 do_action('_wp_put_post_revision',$revision_id);
{$AspisRetTemp = $revision_id;
return $AspisRetTemp;
} }
function &wp_get_post_revision ( &$post,$output = OBJECT,$filter = 'raw' ) {
$null = null;
if ( !$revision = get_post($post,OBJECT,$filter))
 {$AspisRetTemp = &$revision;
return $AspisRetTemp;
}if ( 'revision' !== $revision->post_type)
 {$AspisRetTemp = &$null;
return $AspisRetTemp;
}if ( $output == OBJECT)
 {{$AspisRetTemp = &$revision;
return $AspisRetTemp;
}}elseif ( $output == ARRAY_A)
 {$_revision = get_object_vars($revision);
{$AspisRetTemp = &$_revision;
return $AspisRetTemp;
}}elseif ( $output == ARRAY_N)
 {$_revision = array_values(get_object_vars($revision));
{$AspisRetTemp = &$_revision;
return $AspisRetTemp;
}}{$AspisRetTemp = &$revision;
return $AspisRetTemp;
} }
function wp_restore_post_revision ( $revision_id,$fields = null ) {
if ( !$revision = wp_get_post_revision($revision_id,ARRAY_A))
 {$AspisRetTemp = $revision;
return $AspisRetTemp;
}if ( !is_array($fields))
 $fields = array_keys(_wp_post_revision_fields());
$update = array();
foreach ( array_intersect(array_keys($revision),$fields) as $field  )
$update[$field] = $revision[$field];
if ( !$update)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$update['ID'] = $revision['post_parent'];
$update = deAspisWarningRC(add_magic_quotes(attAspisRCO($update)));
$post_id = wp_update_post($update);
if ( is_wp_error($post_id))
 {$AspisRetTemp = $post_id;
return $AspisRetTemp;
}if ( $post_id)
 do_action('wp_restore_post_revision',$post_id,$revision['ID']);
{$AspisRetTemp = $post_id;
return $AspisRetTemp;
} }
function wp_delete_post_revision ( $revision_id ) {
if ( !$revision = wp_get_post_revision($revision_id))
 {$AspisRetTemp = $revision;
return $AspisRetTemp;
}$delete = wp_delete_post($revision->ID);
if ( is_wp_error($delete))
 {$AspisRetTemp = $delete;
return $AspisRetTemp;
}if ( $delete)
 do_action('wp_delete_post_revision',$revision->ID,$revision);
{$AspisRetTemp = $delete;
return $AspisRetTemp;
} }
function wp_get_post_revisions ( $post_id = 0,$args = null ) {
if ( !constant('WP_POST_REVISIONS'))
 {$AspisRetTemp = array();
return $AspisRetTemp;
}if ( (!$post = get_post($post_id)) || empty($post->ID))
 {$AspisRetTemp = array();
return $AspisRetTemp;
}$defaults = array('order' => 'DESC','orderby' => 'date');
$args = wp_parse_args($args,$defaults);
$args = array_merge($args,array('post_parent' => $post->ID,'post_type' => 'revision','post_status' => 'inherit'));
if ( !$revisions = get_children($args))
 {$AspisRetTemp = array();
return $AspisRetTemp;
}{$AspisRetTemp = $revisions;
return $AspisRetTemp;
} }
function _set_preview ( $post ) {
if ( !is_object($post))
 {$AspisRetTemp = $post;
return $AspisRetTemp;
}$preview = wp_get_post_autosave($post->ID);
if ( !is_object($preview))
 {$AspisRetTemp = $post;
return $AspisRetTemp;
}$preview = sanitize_post($preview);
$post->post_content = $preview->post_content;
$post->post_title = $preview->post_title;
$post->post_excerpt = $preview->post_excerpt;
{$AspisRetTemp = $post;
return $AspisRetTemp;
} }
function _show_post_preview (  ) {
if ( (isset($_GET[0]['preview_id']) && Aspis_isset($_GET[0]['preview_id'])) && (isset($_GET[0]['preview_nonce']) && Aspis_isset($_GET[0]['preview_nonce'])))
 {$id = (int)deAspisWarningRC($_GET[0]['preview_id']);
if ( false == wp_verify_nonce(deAspisWarningRC($_GET[0]['preview_nonce']),'post_preview_' . $id))
 wp_die(__('You do not have permission to preview drafts.'));
add_filter('the_preview','_set_preview');
} }
