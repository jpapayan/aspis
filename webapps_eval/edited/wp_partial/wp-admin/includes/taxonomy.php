<?php require_once('AspisMain.php'); ?><?php
function category_exists ( $cat_name,$parent = 0 ) {
$id = is_term($cat_name,'category',$parent);
if ( is_array($id))
 $id = $id['term_id'];
{$AspisRetTemp = $id;
return $AspisRetTemp;
} }
function get_category_to_edit ( $id ) {
$category = get_category($id,OBJECT,'edit');
{$AspisRetTemp = $category;
return $AspisRetTemp;
} }
function wp_create_category ( $cat_name,$parent = 0 ) {
if ( $id = category_exists($cat_name))
 {$AspisRetTemp = $id;
return $AspisRetTemp;
}{$AspisRetTemp = wp_insert_category(array('cat_name' => $cat_name,'category_parent' => $parent));
return $AspisRetTemp;
} }
function wp_create_categories ( $categories,$post_id = '' ) {
$cat_ids = array();
foreach ( $categories as $category  )
{if ( $id = category_exists($category))
 $cat_ids[] = $id;
else 
{if ( $id = wp_create_category($category))
 $cat_ids[] = $id;
}}if ( $post_id)
 wp_set_post_categories($post_id,$cat_ids);
{$AspisRetTemp = $cat_ids;
return $AspisRetTemp;
} }
function wp_delete_category ( $cat_ID ) {
$cat_ID = (int)$cat_ID;
$default = get_option('default_category');
if ( $cat_ID == $default)
 {$AspisRetTemp = 0;
return $AspisRetTemp;
}{$AspisRetTemp = wp_delete_term($cat_ID,'category',array('default' => $default));
return $AspisRetTemp;
} }
function wp_insert_category ( $catarr,$wp_error = false ) {
$cat_defaults = array('cat_ID' => 0,'cat_name' => '','category_description' => '','category_nicename' => '','category_parent' => '');
$catarr = wp_parse_args($catarr,$cat_defaults);
extract(($catarr),EXTR_SKIP);
if ( trim($cat_name) == '')
 {if ( !$wp_error)
 {$AspisRetTemp = 0;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = new WP_Error('cat_name',__('You did not enter a category name.'));
return $AspisRetTemp;
}}}$cat_ID = (int)$cat_ID;
if ( !empty($cat_ID))
 $update = true;
else 
{$update = false;
}$name = $cat_name;
$description = $category_description;
$slug = $category_nicename;
$parent = $category_parent;
$parent = (int)$parent;
if ( $parent < 0)
 $parent = 0;
if ( empty($parent) || !category_exists($parent) || ($cat_ID && cat_is_ancestor_of($cat_ID,$parent)))
 $parent = 0;
$args = compact('name','slug','parent','description');
if ( $update)
 $cat_ID = wp_update_term($cat_ID,'category',$args);
else 
{$cat_ID = wp_insert_term($cat_name,'category',$args);
}if ( is_wp_error($cat_ID))
 {if ( $wp_error)
 {$AspisRetTemp = $cat_ID;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = 0;
return $AspisRetTemp;
}}}{$AspisRetTemp = $cat_ID['term_id'];
return $AspisRetTemp;
} }
function wp_update_category ( $catarr ) {
$cat_ID = (int)$catarr['cat_ID'];
if ( isset($catarr['category_parent']) && ($cat_ID == $catarr['category_parent']))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$category = get_category($cat_ID,ARRAY_A);
$category = deAspisWarningRC(add_magic_quotes(attAspisRCO($category)));
$catarr = array_merge($category,$catarr);
{$AspisRetTemp = wp_insert_category($catarr);
return $AspisRetTemp;
} }
function get_tags_to_edit ( $post_id,$taxonomy = 'post_tag' ) {
{$AspisRetTemp = get_terms_to_edit($post_id,$taxonomy);
return $AspisRetTemp;
} }
function get_terms_to_edit ( $post_id,$taxonomy = 'post_tag' ) {
$post_id = (int)$post_id;
if ( !$post_id)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$tags = wp_get_post_terms($post_id,$taxonomy,array());
if ( !$tags)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( is_wp_error($tags))
 {$AspisRetTemp = $tags;
return $AspisRetTemp;
}foreach ( $tags as $tag  )
$tag_names[] = $tag->name;
$tags_to_edit = join(',',$tag_names);
$tags_to_edit = esc_attr($tags_to_edit);
$tags_to_edit = apply_filters('terms_to_edit',$tags_to_edit,$taxonomy);
{$AspisRetTemp = $tags_to_edit;
return $AspisRetTemp;
} }
function tag_exists ( $tag_name ) {
{$AspisRetTemp = is_term($tag_name,'post_tag');
return $AspisRetTemp;
} }
function wp_create_tag ( $tag_name ) {
{$AspisRetTemp = wp_create_term($tag_name,'post_tag');
return $AspisRetTemp;
} }
function wp_create_term ( $tag_name,$taxonomy = 'post_tag' ) {
if ( $id = is_term($tag_name,$taxonomy))
 {$AspisRetTemp = $id;
return $AspisRetTemp;
}{$AspisRetTemp = wp_insert_term($tag_name,$taxonomy);
return $AspisRetTemp;
} }
