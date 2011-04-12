<?php require_once('AspisMain.php'); ?><?php
function get_all_category_ids (  ) {
if ( (denot_boolean($cat_ids = wp_cache_get(array('all_category_ids',false),array('category',false)))))
 {$cat_ids = get_terms(array('category',false),array('fields=ids&get=all',false));
wp_cache_add(array('all_category_ids',false),$cat_ids,array('category',false));
}return $cat_ids;
 }
function &get_categories ( $args = array('',false) ) {
$defaults = array(array('type' => array('category',false,false)),false);
$args = wp_parse_args($args,$defaults);
$taxonomy = apply_filters(array('get_categories_taxonomy',false),array('category',false),$args);
if ( (('link') == deAspis($args[0]['type'])))
 $taxonomy = array('link_category',false);
$categories = array_cast(get_terms($taxonomy,$args));
foreach ( deAspis(attAspisRC(array_keys(deAspisRC($categories)))) as $k  )
_make_cat_compat(attachAspis($categories,$k[0]));
return $categories;
 }
function &get_category ( $category,$output = array(OBJECT,false),$filter = array('raw',false) ) {
$category = get_term($category,array('category',false),$output,$filter);
if ( deAspis(is_wp_error($category)))
 return $category;
_make_cat_compat($category);
return $category;
 }
function get_category_by_path ( $category_path,$full_match = array(true,false),$output = array(OBJECT,false) ) {
$category_path = Aspis_rawurlencode(Aspis_urldecode($category_path));
$category_path = Aspis_str_replace(array('%2F',false),array('/',false),$category_path);
$category_path = Aspis_str_replace(array('%20',false),array(' ',false),$category_path);
$category_paths = concat1('/',Aspis_trim($category_path,array('/',false)));
$leaf_path = sanitize_title(Aspis_basename($category_paths));
$category_paths = Aspis_explode(array('/',false),$category_paths);
$full_path = array('',false);
foreach ( deAspis(array_cast($category_paths)) as $pathdir  )
$full_path = concat($full_path,concat((($pathdir[0] != ('')) ? array('/',false) : array('',false)),sanitize_title($pathdir)));
$categories = get_terms(array('category',false),concat1("get=all&slug=",$leaf_path));
if ( ((empty($categories) || Aspis_empty( $categories))))
 return array(null,false);
foreach ( $categories[0] as $category  )
{$path = concat1('/',$leaf_path);
$curcategory = $category;
while ( (($curcategory[0]->parent[0] != (0)) && ($curcategory[0]->parent[0] != $curcategory[0]->term_id[0])) )
{$curcategory = get_term($curcategory[0]->parent,array('category',false));
if ( deAspis(is_wp_error($curcategory)))
 return $curcategory;
$path = concat(concat1('/',$curcategory[0]->slug),$path);
}if ( ($path[0] == $full_path[0]))
 return get_category($category[0]->term_id,$output);
}if ( (denot_boolean($full_match)))
 return get_category($categories[0][(0)][0]->term_id,$output);
return array(null,false);
 }
function get_category_by_slug ( $slug ) {
$category = get_term_by(array('slug',false),$slug,array('category',false));
if ( $category[0])
 _make_cat_compat($category);
return $category;
 }
function get_cat_ID ( $cat_name = array('General',false) ) {
$cat = get_term_by(array('name',false),$cat_name,array('category',false));
if ( $cat[0])
 return $cat[0]->term_id;
return array(0,false);
 }
function get_cat_name ( $cat_id ) {
$cat_id = int_cast($cat_id);
$category = &get_category($cat_id);
return $category[0]->name;
 }
function cat_is_ancestor_of ( $cat1,$cat2 ) {
if ( (!((isset($cat1[0]->term_id) && Aspis_isset( $cat1[0] ->term_id )))))
 $cat1 = &get_category($cat1);
if ( (!((isset($cat2[0]->parent) && Aspis_isset( $cat2[0] ->parent )))))
 $cat2 = &get_category($cat2);
if ( (((empty($cat1[0]->term_id) || Aspis_empty( $cat1[0] ->term_id ))) || ((empty($cat2[0]->parent) || Aspis_empty( $cat2[0] ->parent )))))
 return array(false,false);
if ( ($cat2[0]->parent[0] == $cat1[0]->term_id[0]))
 return array(true,false);
return cat_is_ancestor_of($cat1,get_category($cat2[0]->parent));
 }
function sanitize_category ( $category,$context = array('display',false) ) {
return sanitize_term($category,array('category',false),$context);
 }
function sanitize_category_field ( $field,$value,$cat_id,$context ) {
return sanitize_term_field($field,$value,$cat_id,array('category',false),$context);
 }
function &get_tags ( $args = array('',false) ) {
$tags = get_terms(array('post_tag',false),$args);
if ( ((empty($tags) || Aspis_empty( $tags))))
 {$return = array(array(),false);
return $return;
}$tags = apply_filters(array('get_tags',false),$tags,$args);
return $tags;
 }
function &get_tag ( $tag,$output = array(OBJECT,false),$filter = array('raw',false) ) {
return get_term($tag,array('post_tag',false),$output,$filter);
 }
function update_category_cache (  ) {
return array(true,false);
 }
function clean_category_cache ( $id ) {
clean_term_cache($id,array('category',false));
 }
function _make_cat_compat ( &$category ) {
if ( is_object($category[0]))
 {$category[0]->cat_ID = $category[0]->term_id;
$category[0]->category_count = $category[0]->count;
$category[0]->category_description = $category[0]->description;
$category[0]->cat_name = $category[0]->name;
$category[0]->category_nicename = $category[0]->slug;
$category[0]->category_parent = $category[0]->parent;
}elseif ( (is_array($category[0]) && ((isset($category[0][('term_id')]) && Aspis_isset( $category [0][('term_id')])))))
 {$category[0][deAspis(registerTaint(array('cat_ID',false)))] = &addTaintR($category[0][('term_id')]);
$category[0][deAspis(registerTaint(array('category_count',false)))] = &addTaintR($category[0][('count')]);
$category[0][deAspis(registerTaint(array('category_description',false)))] = &addTaintR($category[0][('description')]);
$category[0][deAspis(registerTaint(array('cat_name',false)))] = &addTaintR($category[0][('name')]);
$category[0][deAspis(registerTaint(array('category_nicename',false)))] = &addTaintR($category[0][('slug')]);
$category[0][deAspis(registerTaint(array('category_parent',false)))] = &addTaintR($category[0][('parent')]);
} }
;
?>
<?php 