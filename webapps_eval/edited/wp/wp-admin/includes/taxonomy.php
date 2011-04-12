<?php require_once('AspisMain.php'); ?><?php
function category_exists ( $cat_name,$parent = array(0,false) ) {
$id = is_term($cat_name,array('category',false),$parent);
if ( is_array($id[0]))
 $id = $id[0]['term_id'];
return $id;
 }
function get_category_to_edit ( $id ) {
$category = get_category($id,array(OBJECT,false),array('edit',false));
return $category;
 }
function wp_create_category ( $cat_name,$parent = array(0,false) ) {
if ( deAspis($id = category_exists($cat_name)))
 return $id;
return wp_insert_category(array(array(deregisterTaint(array('cat_name',false)) => addTaint($cat_name),deregisterTaint(array('category_parent',false)) => addTaint($parent)),false));
 }
function wp_create_categories ( $categories,$post_id = array('',false) ) {
$cat_ids = array(array(),false);
foreach ( $categories[0] as $category  )
{if ( deAspis($id = category_exists($category)))
 arrayAssignAdd($cat_ids[0][],addTaint($id));
else 
{if ( deAspis($id = wp_create_category($category)))
 arrayAssignAdd($cat_ids[0][],addTaint($id));
}}if ( $post_id[0])
 wp_set_post_categories($post_id,$cat_ids);
return $cat_ids;
 }
function wp_delete_category ( $cat_ID ) {
$cat_ID = int_cast($cat_ID);
$default = get_option(array('default_category',false));
if ( ($cat_ID[0] == $default[0]))
 return array(0,false);
return wp_delete_term($cat_ID,array('category',false),array(array(deregisterTaint(array('default',false)) => addTaint($default)),false));
 }
function wp_insert_category ( $catarr,$wp_error = array(false,false) ) {
$cat_defaults = array(array('cat_ID' => array(0,false,false),'cat_name' => array('',false,false),'category_description' => array('',false,false),'category_nicename' => array('',false,false),'category_parent' => array('',false,false)),false);
$catarr = wp_parse_args($catarr,$cat_defaults);
extract(($catarr[0]),EXTR_SKIP);
if ( (deAspis(Aspis_trim($cat_name)) == ('')))
 {if ( (denot_boolean($wp_error)))
 return array(0,false);
else 
{return array(new WP_Error(array('cat_name',false),__(array('You did not enter a category name.',false))),false);
}}$cat_ID = int_cast($cat_ID);
if ( (!((empty($cat_ID) || Aspis_empty( $cat_ID)))))
 $update = array(true,false);
else 
{$update = array(false,false);
}$name = $cat_name;
$description = $category_description;
$slug = $category_nicename;
$parent = $category_parent;
$parent = int_cast($parent);
if ( ($parent[0] < (0)))
 $parent = array(0,false);
if ( ((((empty($parent) || Aspis_empty( $parent))) || (denot_boolean(category_exists($parent)))) || ($cat_ID[0] && deAspis(cat_is_ancestor_of($cat_ID,$parent)))))
 $parent = array(0,false);
$args = array(compact('name','slug','parent','description'),false);
if ( $update[0])
 $cat_ID = wp_update_term($cat_ID,array('category',false),$args);
else 
{$cat_ID = wp_insert_term($cat_name,array('category',false),$args);
}if ( deAspis(is_wp_error($cat_ID)))
 {if ( $wp_error[0])
 return $cat_ID;
else 
{return array(0,false);
}}return $cat_ID[0]['term_id'];
 }
function wp_update_category ( $catarr ) {
$cat_ID = int_cast($catarr[0]['cat_ID']);
if ( (((isset($catarr[0][('category_parent')]) && Aspis_isset( $catarr [0][('category_parent')]))) && ($cat_ID[0] == deAspis($catarr[0]['category_parent']))))
 return array(false,false);
$category = get_category($cat_ID,array(ARRAY_A,false));
$category = add_magic_quotes($category);
$catarr = Aspis_array_merge($category,$catarr);
return wp_insert_category($catarr);
 }
function get_tags_to_edit ( $post_id,$taxonomy = array('post_tag',false) ) {
return get_terms_to_edit($post_id,$taxonomy);
 }
function get_terms_to_edit ( $post_id,$taxonomy = array('post_tag',false) ) {
$post_id = int_cast($post_id);
if ( (denot_boolean($post_id)))
 return array(false,false);
$tags = wp_get_post_terms($post_id,$taxonomy,array(array(),false));
if ( (denot_boolean($tags)))
 return array(false,false);
if ( deAspis(is_wp_error($tags)))
 return $tags;
foreach ( $tags[0] as $tag  )
arrayAssignAdd($tag_names[0][],addTaint($tag[0]->name));
$tags_to_edit = Aspis_join(array(',',false),$tag_names);
$tags_to_edit = esc_attr($tags_to_edit);
$tags_to_edit = apply_filters(array('terms_to_edit',false),$tags_to_edit,$taxonomy);
return $tags_to_edit;
 }
function tag_exists ( $tag_name ) {
return is_term($tag_name,array('post_tag',false));
 }
function wp_create_tag ( $tag_name ) {
return wp_create_term($tag_name,array('post_tag',false));
 }
function wp_create_term ( $tag_name,$taxonomy = array('post_tag',false) ) {
if ( deAspis($id = is_term($tag_name,$taxonomy)))
 return $id;
return wp_insert_term($tag_name,$taxonomy);
 }
