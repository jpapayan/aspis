<?php require_once('AspisMain.php'); ?><?php
function get_all_category_ids (  ) {
if ( !$cat_ids = wp_cache_get('all_category_ids','category'))
 {$cat_ids = get_terms('category','fields=ids&get=all');
wp_cache_add('all_category_ids',$cat_ids,'category');
}{$AspisRetTemp = $cat_ids;
return $AspisRetTemp;
} }
function &get_categories ( $args = '' ) {
$defaults = array('type' => 'category');
$args = wp_parse_args($args,$defaults);
$taxonomy = apply_filters('get_categories_taxonomy','category',$args);
if ( 'link' == $args['type'])
 $taxonomy = 'link_category';
$categories = (array)get_terms($taxonomy,$args);
foreach ( array_keys($categories) as $k  )
_make_cat_compat($categories[$k]);
{$AspisRetTemp = &$categories;
return $AspisRetTemp;
} }
function &get_category ( $category,$output = OBJECT,$filter = 'raw' ) {
$category = get_term($category,'category',$output,$filter);
if ( is_wp_error($category))
 {$AspisRetTemp = &$category;
return $AspisRetTemp;
}_make_cat_compat($category);
{$AspisRetTemp = &$category;
return $AspisRetTemp;
} }
function get_category_by_path ( $category_path,$full_match = true,$output = OBJECT ) {
$category_path = rawurlencode(urldecode($category_path));
$category_path = str_replace('%2F','/',$category_path);
$category_path = str_replace('%20',' ',$category_path);
$category_paths = '/' . trim($category_path,'/');
$leaf_path = sanitize_title(basename($category_paths));
$category_paths = explode('/',$category_paths);
$full_path = '';
foreach ( (array)$category_paths as $pathdir  )
$full_path .= ($pathdir != '' ? '/' : '') . sanitize_title($pathdir);
$categories = get_terms('category',"get=all&slug=$leaf_path");
if ( empty($categories))
 {$AspisRetTemp = null;
return $AspisRetTemp;
}foreach ( $categories as $category  )
{$path = '/' . $leaf_path;
$curcategory = $category;
while ( ($curcategory->parent != 0) && ($curcategory->parent != $curcategory->term_id) )
{$curcategory = get_term($curcategory->parent,'category');
if ( is_wp_error($curcategory))
 {$AspisRetTemp = $curcategory;
return $AspisRetTemp;
}$path = '/' . $curcategory->slug . $path;
}if ( $path == $full_path)
 {$AspisRetTemp = get_category($category->term_id,$output);
return $AspisRetTemp;
}}if ( !$full_match)
 {$AspisRetTemp = get_category($categories[0]->term_id,$output);
return $AspisRetTemp;
}{$AspisRetTemp = null;
return $AspisRetTemp;
} }
function get_category_by_slug ( $slug ) {
$category = get_term_by('slug',$slug,'category');
if ( $category)
 _make_cat_compat($category);
{$AspisRetTemp = $category;
return $AspisRetTemp;
} }
function get_cat_ID ( $cat_name = 'General' ) {
$cat = get_term_by('name',$cat_name,'category');
if ( $cat)
 {$AspisRetTemp = $cat->term_id;
return $AspisRetTemp;
}{$AspisRetTemp = 0;
return $AspisRetTemp;
} }
function get_cat_name ( $cat_id ) {
$cat_id = (int)$cat_id;
$category = &get_category($cat_id);
{$AspisRetTemp = $category->name;
return $AspisRetTemp;
} }
function cat_is_ancestor_of ( $cat1,$cat2 ) {
if ( !isset($cat1->term_id))
 $cat1 = &get_category($cat1);
if ( !isset($cat2->parent))
 $cat2 = &get_category($cat2);
if ( empty($cat1->term_id) || empty($cat2->parent))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( $cat2->parent == $cat1->term_id)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = cat_is_ancestor_of($cat1,get_category($cat2->parent));
return $AspisRetTemp;
} }
function sanitize_category ( $category,$context = 'display' ) {
{$AspisRetTemp = sanitize_term($category,'category',$context);
return $AspisRetTemp;
} }
function sanitize_category_field ( $field,$value,$cat_id,$context ) {
{$AspisRetTemp = sanitize_term_field($field,$value,$cat_id,'category',$context);
return $AspisRetTemp;
} }
function &get_tags ( $args = '' ) {
$tags = get_terms('post_tag',$args);
if ( empty($tags))
 {$return = array();
{$AspisRetTemp = &$return;
return $AspisRetTemp;
}}$tags = apply_filters('get_tags',$tags,$args);
{$AspisRetTemp = &$tags;
return $AspisRetTemp;
} }
function &get_tag ( $tag,$output = OBJECT,$filter = 'raw' ) {
{$AspisRetTemp = get_term($tag,'post_tag',$output,$filter);
return $AspisRetTemp;
} }
function update_category_cache (  ) {
{$AspisRetTemp = true;
return $AspisRetTemp;
} }
function clean_category_cache ( $id ) {
clean_term_cache($id,'category');
 }
function _make_cat_compat ( &$category ) {
if ( is_object($category))
 {$category->cat_ID = $category->term_id;
$category->category_count = $category->count;
$category->category_description = $category->description;
$category->cat_name = $category->name;
$category->category_nicename = $category->slug;
$category->category_parent = $category->parent;
}elseif ( is_array($category) && isset($category['term_id']))
 {$category['cat_ID'] = &$category['term_id'];
$category['category_count'] = &$category['count'];
$category['category_description'] = &$category['description'];
$category['cat_name'] = &$category['name'];
$category['category_nicename'] = &$category['slug'];
$category['category_parent'] = &$category['parent'];
} }
;
?>
<?php 