<?php require_once('AspisMain.php'); ?><?php
function create_initial_taxonomies (  ) {
register_taxonomy(array('category',false),array('post',false),array(array('hierarchical' => array(true,false,false),'update_count_callback' => array('_update_post_term_count',false,false),deregisterTaint(array('label',false)) => addTaint(__(array('Categories',false))),'query_var' => array(false,false,false),'rewrite' => array(false,false,false)),false));
register_taxonomy(array('post_tag',false),array('post',false),array(array('hierarchical' => array(false,false,false),'update_count_callback' => array('_update_post_term_count',false,false),deregisterTaint(array('label',false)) => addTaint(__(array('Post Tags',false))),'query_var' => array(false,false,false),'rewrite' => array(false,false,false)),false));
register_taxonomy(array('link_category',false),array('link',false),array(array('hierarchical' => array(false,false,false),deregisterTaint(array('label',false)) => addTaint(__(array('Categories',false))),'query_var' => array(false,false,false),'rewrite' => array(false,false,false)),false));
 }
add_action(array('init',false),array('create_initial_taxonomies',false),array(0,false));
function get_object_taxonomies ( $object ) {
global $wp_taxonomies;
if ( is_object($object[0]))
 {if ( ($object[0]->post_type[0] == ('attachment')))
 return get_attachment_taxonomies($object);
$object = $object[0]->post_type;
}$object = array_cast($object);
$taxonomies = array(array(),false);
foreach ( deAspis(array_cast($wp_taxonomies)) as $taxonomy  )
{if ( deAspis(Aspis_array_intersect($object,array_cast($taxonomy[0]->object_type))))
 arrayAssignAdd($taxonomies[0][],addTaint($taxonomy[0]->name));
}return $taxonomies;
 }
function get_taxonomy ( $taxonomy ) {
global $wp_taxonomies;
if ( (denot_boolean(is_taxonomy($taxonomy))))
 return array(false,false);
return attachAspis($wp_taxonomies,$taxonomy[0]);
 }
function is_taxonomy ( $taxonomy ) {
global $wp_taxonomies;
return array((isset($wp_taxonomies[0][$taxonomy[0]]) && Aspis_isset( $wp_taxonomies [0][$taxonomy[0]])),false);
 }
function is_taxonomy_hierarchical ( $taxonomy ) {
if ( (denot_boolean(is_taxonomy($taxonomy))))
 return array(false,false);
$taxonomy = get_taxonomy($taxonomy);
return $taxonomy[0]->hierarchical;
 }
function register_taxonomy ( $taxonomy,$object_type,$args = array(array(),false) ) {
global $wp_taxonomies,$wp_rewrite,$wp;
if ( (!(is_array($wp_taxonomies[0]))))
 $wp_taxonomies = array(array(),false);
$defaults = array(array('hierarchical' => array(false,false,false),'update_count_callback' => array('',false,false),'rewrite' => array(true,false,false),'query_var' => array(true,false,false)),false);
$args = wp_parse_args($args,$defaults);
if ( ((false !== deAspis($args[0]['query_var'])) && (!((empty($wp) || Aspis_empty( $wp))))))
 {if ( (true === deAspis($args[0]['query_var'])))
 arrayAssign($args[0],deAspis(registerTaint(array('query_var',false))),addTaint($taxonomy));
arrayAssign($args[0],deAspis(registerTaint(array('query_var',false))),addTaint(sanitize_title_with_dashes($args[0]['query_var'])));
$wp[0]->add_query_var($args[0]['query_var']);
}if ( ((false !== deAspis($args[0]['rewrite'])) && (!((empty($wp_rewrite) || Aspis_empty( $wp_rewrite))))))
 {if ( (!(is_array(deAspis($args[0]['rewrite'])))))
 arrayAssign($args[0],deAspis(registerTaint(array('rewrite',false))),addTaint(array(array(),false)));
if ( (!((isset($args[0][('rewrite')][0][('slug')]) && Aspis_isset( $args [0][('rewrite')] [0][('slug')])))))
 arrayAssign($args[0][('rewrite')][0],deAspis(registerTaint(array('slug',false))),addTaint(sanitize_title_with_dashes($taxonomy)));
$wp_rewrite[0]->add_rewrite_tag(concat2(concat1("%",$taxonomy),"%"),array('([^/]+)',false),deAspis($args[0]['query_var']) ? concat2($args[0]['query_var'],"=") : concat(concat2(concat1("taxonomy=",$taxonomy),"&term="),$term));
$wp_rewrite[0]->add_permastruct($taxonomy,concat2(concat(concat2($args[0][('rewrite')][0]['slug'],"/%"),$taxonomy),"%"));
}arrayAssign($args[0],deAspis(registerTaint(array('name',false))),addTaint($taxonomy));
arrayAssign($args[0],deAspis(registerTaint(array('object_type',false))),addTaint($object_type));
arrayAssign($wp_taxonomies[0],deAspis(registerTaint($taxonomy)),addTaint(object_cast($args)));
 }
function get_objects_in_term ( $terms,$taxonomies,$args = array(array(),false) ) {
global $wpdb;
if ( (!(is_array($terms[0]))))
 $terms = array(array($terms),false);
if ( (!(is_array($taxonomies[0]))))
 $taxonomies = array(array($taxonomies),false);
foreach ( deAspis(array_cast($taxonomies)) as $taxonomy  )
{if ( (denot_boolean(is_taxonomy($taxonomy))))
 return array(new WP_Error(array('invalid_taxonomy',false),__(array('Invalid Taxonomy',false))),false);
}$defaults = array(array('order' => array('ASC',false,false)),false);
$args = wp_parse_args($args,$defaults);
extract(($args[0]),EXTR_SKIP);
$order = (('desc') == deAspis(Aspis_strtolower($order))) ? array('DESC',false) : array('ASC',false);
$terms = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC($terms)));
$taxonomies = concat2(concat1("'",Aspis_implode(array("', '",false),$taxonomies)),"'");
$terms = concat2(concat1("'",Aspis_implode(array("', '",false),$terms)),"'");
$object_ids = $wpdb[0]->get_col(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT tr.object_id FROM ",$wpdb[0]->term_relationships)," AS tr INNER JOIN "),$wpdb[0]->term_taxonomy)," AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tt.taxonomy IN ("),$taxonomies),") AND tt.term_id IN ("),$terms),") ORDER BY tr.object_id "),$order));
if ( (denot_boolean($object_ids)))
 return array(array(),false);
return $object_ids;
 }
function &get_term ( $term,$taxonomy,$output = array(OBJECT,false),$filter = array('raw',false) ) {
global $wpdb;
$null = array(null,false);
if ( ((empty($term) || Aspis_empty( $term))))
 {$error = array(new WP_Error(array('invalid_term',false),__(array('Empty Term',false))),false);
return $error;
}if ( (denot_boolean(is_taxonomy($taxonomy))))
 {$error = array(new WP_Error(array('invalid_taxonomy',false),__(array('Invalid Taxonomy',false))),false);
return $error;
}if ( (is_object($term[0]) && ((empty($term[0]->filter) || Aspis_empty( $term[0] ->filter )))))
 {wp_cache_add($term[0]->term_id,$term,$taxonomy);
$_term = $term;
}else 
{{if ( is_object($term[0]))
 $term = $term[0]->term_id;
$term = int_cast($term);
if ( (denot_boolean($_term = wp_cache_get($term,$taxonomy))))
 {$_term = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat(concat2(concat1("SELECT t.*, tt.* FROM ",$wpdb[0]->terms)," AS t INNER JOIN "),$wpdb[0]->term_taxonomy)," AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy = %s AND t.term_id = %s LIMIT 1"),$taxonomy,$term));
if ( (denot_boolean($_term)))
 return $null;
wp_cache_add($term,$_term,$taxonomy);
}}}$_term = apply_filters(array('get_term',false),$_term,$taxonomy);
$_term = apply_filters(concat1("get_",$taxonomy),$_term,$taxonomy);
$_term = sanitize_term($_term,$taxonomy,$filter);
if ( ($output[0] == OBJECT))
 {return $_term;
}elseif ( ($output[0] == ARRAY_A))
 {$__term = attAspis(get_object_vars(deAspisRC($_term)));
return $__term;
}elseif ( ($output[0] == ARRAY_N))
 {$__term = Aspis_array_values(attAspis(get_object_vars(deAspisRC($_term))));
return $__term;
}else 
{{return $_term;
}} }
function get_term_by ( $field,$value,$taxonomy,$output = array(OBJECT,false),$filter = array('raw',false) ) {
global $wpdb;
if ( (denot_boolean(is_taxonomy($taxonomy))))
 return array(false,false);
if ( (('slug') == $field[0]))
 {$field = array('t.slug',false);
$value = sanitize_title($value);
if ( ((empty($value) || Aspis_empty( $value))))
 return array(false,false);
}else 
{if ( (('name') == $field[0]))
 {$value = Aspis_stripslashes($value);
$field = array('t.name',false);
}else 
{{$field = array('t.term_id',false);
$value = int_cast($value);
}}}$term = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat(concat2(concat(concat2(concat1("SELECT t.*, tt.* FROM ",$wpdb[0]->terms)," AS t INNER JOIN "),$wpdb[0]->term_taxonomy)," AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy = %s AND "),$field)," = %s LIMIT 1"),$taxonomy,$value));
if ( (denot_boolean($term)))
 return array(false,false);
wp_cache_add($term[0]->term_id,$term,$taxonomy);
$term = sanitize_term($term,$taxonomy,$filter);
if ( ($output[0] == OBJECT))
 {return $term;
}elseif ( ($output[0] == ARRAY_A))
 {return attAspis(get_object_vars(deAspisRC($term)));
}elseif ( ($output[0] == ARRAY_N))
 {return Aspis_array_values(attAspis(get_object_vars(deAspisRC($term))));
}else 
{{return $term;
}} }
function get_term_children ( $term_id,$taxonomy ) {
if ( (denot_boolean(is_taxonomy($taxonomy))))
 return array(new WP_Error(array('invalid_taxonomy',false),__(array('Invalid Taxonomy',false))),false);
$term_id = Aspis_intval($term_id);
$terms = _get_term_hierarchy($taxonomy);
if ( (!((isset($terms[0][$term_id[0]]) && Aspis_isset( $terms [0][$term_id[0]])))))
 return array(array(),false);
$children = attachAspis($terms,$term_id[0]);
foreach ( deAspis(array_cast(attachAspis($terms,$term_id[0]))) as $child  )
{if ( ((isset($terms[0][$child[0]]) && Aspis_isset( $terms [0][$child[0]]))))
 $children = Aspis_array_merge($children,get_term_children($child,$taxonomy));
}return $children;
 }
function get_term_field ( $field,$term,$taxonomy,$context = array('display',false) ) {
$term = int_cast($term);
$term = get_term($term,$taxonomy);
if ( deAspis(is_wp_error($term)))
 return $term;
if ( (!(is_object($term[0]))))
 return array('',false);
if ( (!((isset($term[0]->$field[0]) && Aspis_isset( $term[0] ->$field[0] )))))
 return array('',false);
return sanitize_term_field($field,$term[0]->$field[0],$term[0]->term_id,$taxonomy,$context);
 }
function get_term_to_edit ( $id,$taxonomy ) {
$term = get_term($id,$taxonomy);
if ( deAspis(is_wp_error($term)))
 return $term;
if ( (!(is_object($term[0]))))
 return array('',false);
return sanitize_term($term,$taxonomy,array('edit',false));
 }
function &get_terms ( $taxonomies,$args = array('',false) ) {
global $wpdb;
$empty_array = array(array(),false);
$single_taxonomy = array(false,false);
if ( (!(is_array($taxonomies[0]))))
 {$single_taxonomy = array(true,false);
$taxonomies = array(array($taxonomies),false);
}foreach ( deAspis(array_cast($taxonomies)) as $taxonomy  )
{if ( (denot_boolean(is_taxonomy($taxonomy))))
 {$error = array(new WP_Error(array('invalid_taxonomy',false),__(array('Invalid Taxonomy',false))),false);
return $error;
}}$in_taxonomies = concat2(concat1("'",Aspis_implode(array("', '",false),$taxonomies)),"'");
$defaults = array(array('orderby' => array('name',false,false),'order' => array('ASC',false,false),'hide_empty' => array(true,false,false),'exclude' => array('',false,false),'exclude_tree' => array('',false,false),'include' => array('',false,false),'number' => array('',false,false),'fields' => array('all',false,false),'slug' => array('',false,false),'parent' => array('',false,false),'hierarchical' => array(true,false,false),'child_of' => array(0,false,false),'get' => array('',false,false),'name__like' => array('',false,false),'pad_counts' => array(false,false,false),'offset' => array('',false,false),'search' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
arrayAssign($args[0],deAspis(registerTaint(array('number',false))),addTaint(absint($args[0]['number'])));
arrayAssign($args[0],deAspis(registerTaint(array('offset',false))),addTaint(absint($args[0]['offset'])));
if ( (((denot_boolean($single_taxonomy)) || (denot_boolean(is_taxonomy_hierarchical(attachAspis($taxonomies,(0)))))) || (('') !== deAspis($args[0]['parent']))))
 {arrayAssign($args[0],deAspis(registerTaint(array('child_of',false))),addTaint(array(0,false)));
arrayAssign($args[0],deAspis(registerTaint(array('hierarchical',false))),addTaint(array(false,false)));
arrayAssign($args[0],deAspis(registerTaint(array('pad_counts',false))),addTaint(array(false,false)));
}if ( (('all') == deAspis($args[0]['get'])))
 {arrayAssign($args[0],deAspis(registerTaint(array('child_of',false))),addTaint(array(0,false)));
arrayAssign($args[0],deAspis(registerTaint(array('hide_empty',false))),addTaint(array(0,false)));
arrayAssign($args[0],deAspis(registerTaint(array('hierarchical',false))),addTaint(array(false,false)));
arrayAssign($args[0],deAspis(registerTaint(array('pad_counts',false))),addTaint(array(false,false)));
}extract(($args[0]),EXTR_SKIP);
if ( $child_of[0])
 {$hierarchy = _get_term_hierarchy(attachAspis($taxonomies,(0)));
if ( (!((isset($hierarchy[0][$child_of[0]]) && Aspis_isset( $hierarchy [0][$child_of[0]])))))
 return $empty_array;
}if ( $parent[0])
 {$hierarchy = _get_term_hierarchy(attachAspis($taxonomies,(0)));
if ( (!((isset($hierarchy[0][$parent[0]]) && Aspis_isset( $hierarchy [0][$parent[0]])))))
 return $empty_array;
}$filter_key = deAspis((has_filter(array('list_terms_exclusions',false)))) ? Aspis_serialize($GLOBALS[0][('wp_filter')][0]['list_terms_exclusions']) : array('',false);
$key = attAspis(md5((deconcat(concat(Aspis_serialize(array(compact(deAspisRC(attAspisRC(array_keys(deAspisRC($defaults))))),false)),Aspis_serialize($taxonomies)),$filter_key))));
$last_changed = wp_cache_get(array('last_changed',false),array('terms',false));
if ( (denot_boolean($last_changed)))
 {$last_changed = attAspis(time());
wp_cache_set(array('last_changed',false),$last_changed,array('terms',false));
}$cache_key = concat(concat2(concat1("get_terms:",$key),":"),$last_changed);
$cache = wp_cache_get($cache_key,array('terms',false));
if ( (false !== $cache[0]))
 {$cache = apply_filters(array('get_terms',false),$cache,$taxonomies,$args);
return $cache;
}$_orderby = Aspis_strtolower($orderby);
if ( (('count') == $_orderby[0]))
 $orderby = array('tt.count',false);
else 
{if ( (('name') == $_orderby[0]))
 $orderby = array('t.name',false);
else 
{if ( (('slug') == $_orderby[0]))
 $orderby = array('t.slug',false);
else 
{if ( (('term_group') == $_orderby[0]))
 $orderby = array('t.term_group',false);
elseif ( (((empty($_orderby) || Aspis_empty( $_orderby))) || (('id') == $_orderby[0])))
 $orderby = array('t.term_id',false);
}}}$orderby = apply_filters(array('get_terms_orderby',false),$orderby,$args);
$where = array('',false);
$inclusions = array('',false);
if ( (!((empty($include) || Aspis_empty( $include)))))
 {$exclude = array('',false);
$exclude_tree = array('',false);
$interms = Aspis_preg_split(array('/[\s,]+/',false),$include);
if ( count($interms[0]))
 {foreach ( deAspis(array_cast($interms)) as $interm  )
{if ( ((empty($inclusions) || Aspis_empty( $inclusions))))
 $inclusions = concat2(concat1(' AND ( t.term_id = ',Aspis_intval($interm)),' ');
else 
{$inclusions = concat($inclusions,concat2(concat1(' OR t.term_id = ',Aspis_intval($interm)),' '));
}}}}if ( (!((empty($inclusions) || Aspis_empty( $inclusions)))))
 $inclusions = concat2($inclusions,')');
$where = concat($where,$inclusions);
$exclusions = array('',false);
if ( (!((empty($exclude_tree) || Aspis_empty( $exclude_tree)))))
 {$excluded_trunks = Aspis_preg_split(array('/[\s,]+/',false),$exclude_tree);
foreach ( deAspis(array_cast($excluded_trunks)) as $extrunk  )
{$excluded_children = array_cast(get_terms(attachAspis($taxonomies,(0)),array(array(deregisterTaint(array('child_of',false)) => addTaint(Aspis_intval($extrunk)),'fields' => array('ids',false,false)),false)));
arrayAssignAdd($excluded_children[0][],addTaint($extrunk));
foreach ( deAspis(array_cast($excluded_children)) as $exterm  )
{if ( ((empty($exclusions) || Aspis_empty( $exclusions))))
 $exclusions = concat2(concat1(' AND ( t.term_id <> ',Aspis_intval($exterm)),' ');
else 
{$exclusions = concat($exclusions,concat2(concat1(' AND t.term_id <> ',Aspis_intval($exterm)),' '));
}}}}if ( (!((empty($exclude) || Aspis_empty( $exclude)))))
 {$exterms = Aspis_preg_split(array('/[\s,]+/',false),$exclude);
if ( count($exterms[0]))
 {foreach ( deAspis(array_cast($exterms)) as $exterm  )
{if ( ((empty($exclusions) || Aspis_empty( $exclusions))))
 $exclusions = concat2(concat1(' AND ( t.term_id <> ',Aspis_intval($exterm)),' ');
else 
{$exclusions = concat($exclusions,concat2(concat1(' AND t.term_id <> ',Aspis_intval($exterm)),' '));
}}}}if ( (!((empty($exclusions) || Aspis_empty( $exclusions)))))
 $exclusions = concat2($exclusions,')');
$exclusions = apply_filters(array('list_terms_exclusions',false),$exclusions,$args);
$where = concat($where,$exclusions);
if ( (!((empty($slug) || Aspis_empty( $slug)))))
 {$slug = sanitize_title($slug);
$where = concat($where,concat2(concat1(" AND t.slug = '",$slug),"'"));
}if ( (!((empty($name__like) || Aspis_empty( $name__like)))))
 $where = concat($where,concat2(concat1(" AND t.name LIKE '",$name__like),"%'"));
if ( (('') !== $parent[0]))
 {$parent = int_cast($parent);
$where = concat($where,concat2(concat1(" AND tt.parent = '",$parent),"'"));
}if ( ($hide_empty[0] && (denot_boolean($hierarchical))))
 $where = concat2($where,' AND tt.count > 0');
if ( ((((!((empty($number) || Aspis_empty( $number)))) && (denot_boolean($hierarchical))) && ((empty($child_of) || Aspis_empty( $child_of)))) && (('') === $parent[0])))
 {if ( $offset[0])
 $limit = concat(concat2(concat1('LIMIT ',$offset),','),$number);
else 
{$limit = concat1('LIMIT ',$number);
}}else 
{$limit = array('',false);
}if ( (!((empty($search) || Aspis_empty( $search)))))
 {$search = like_escape($search);
$where = concat($where,concat2(concat1(" AND (t.name LIKE '%",$search),"%')"));
}$selects = array(array(),false);
if ( (('all') == $fields[0]))
 $selects = array(array(array('t.*',false),array('tt.*',false)),false);
else 
{if ( (('ids') == $fields[0]))
 $selects = array(array(array('t.term_id',false),array('tt.parent',false),array('tt.count',false)),false);
else 
{if ( (('names') == $fields[0]))
 $selects = array(array(array('t.term_id',false),array('tt.parent',false),array('tt.count',false),array('t.name',false)),false);
}}$select_this = Aspis_implode(array(', ',false),apply_filters(array('get_terms_fields',false),$selects,$args));
$query = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT ",$select_this)," FROM "),$wpdb[0]->terms)," AS t INNER JOIN "),$wpdb[0]->term_taxonomy)," AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ("),$in_taxonomies),") "),$where)," ORDER BY "),$orderby)," "),$order)," "),$limit);
$terms = $wpdb[0]->get_results($query);
if ( (('all') == $fields[0]))
 {update_term_cache($terms);
}if ( ((empty($terms) || Aspis_empty( $terms))))
 {wp_cache_add($cache_key,array(array(),false),array('terms',false));
$terms = apply_filters(array('get_terms',false),array(array(),false),$taxonomies,$args);
return $terms;
}if ( $child_of[0])
 {$children = _get_term_hierarchy(attachAspis($taxonomies,(0)));
if ( (!((empty($children) || Aspis_empty( $children)))))
 $terms = &_get_term_children($child_of,$terms,$taxonomies[0][(0)]);
}if ( ($pad_counts[0] && (('all') == $fields[0])))
 _pad_term_counts($terms,attachAspis($taxonomies,(0)));
if ( (($hierarchical[0] && $hide_empty[0]) && is_array($terms[0])))
 {foreach ( $terms[0] as $k =>$term )
{restoreTaint($k,$term);
{if ( (denot_boolean($term[0]->count)))
 {$children = _get_term_children($term[0]->term_id,$terms,attachAspis($taxonomies,(0)));
if ( is_array($children[0]))
 foreach ( $children[0] as $child  )
if ( $child[0]->count[0])
 continue (2);
unset($terms[0][$k[0]]);
}}}}Aspis_reset($terms);
$_terms = array(array(),false);
if ( (('ids') == $fields[0]))
 {while ( deAspis($term = Aspis_array_shift($terms)) )
arrayAssignAdd($_terms[0][],addTaint($term[0]->term_id));
$terms = $_terms;
}elseif ( (('names') == $fields[0]))
 {while ( deAspis($term = Aspis_array_shift($terms)) )
arrayAssignAdd($_terms[0][],addTaint($term[0]->name));
$terms = $_terms;
}if ( (((0) < $number[0]) && (deAspis(Aspis_intval(@attAspis(count($terms[0])))) > $number[0])))
 {$terms = Aspis_array_slice($terms,$offset,$number);
}wp_cache_add($cache_key,$terms,array('terms',false));
$terms = apply_filters(array('get_terms',false),$terms,$taxonomies,$args);
return $terms;
 }
function is_term ( $term,$taxonomy = array('',false),$parent = array(0,false) ) {
global $wpdb;
$select = concat2(concat1("SELECT term_id FROM ",$wpdb[0]->terms)," as t WHERE ");
$tax_select = concat2(concat(concat2(concat1("SELECT tt.term_id, tt.term_taxonomy_id FROM ",$wpdb[0]->terms)," AS t INNER JOIN "),$wpdb[0]->term_taxonomy)," as tt ON tt.term_id = t.term_id WHERE ");
if ( is_int(deAspisRC($term)))
 {if ( ((0) == $term[0]))
 return array(0,false);
$where = array('t.term_id = %d',false);
if ( (!((empty($taxonomy) || Aspis_empty( $taxonomy)))))
 return $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat($tax_select,$where)," AND tt.taxonomy = %s"),$term,$taxonomy),array(ARRAY_A,false));
else 
{return $wpdb[0]->get_var($wpdb[0]->prepare(concat($select,$where),$term));
}}$term = Aspis_trim(Aspis_stripslashes($term));
if ( (('') === deAspis($slug = sanitize_title($term))))
 return array(0,false);
$where = array('t.slug = %s',false);
$else_where = array('t.name = %s',false);
$where_fields = array(array($slug),false);
$else_where_fields = array(array($term),false);
if ( (!((empty($taxonomy) || Aspis_empty( $taxonomy)))))
 {$parent = int_cast($parent);
if ( ($parent[0] > (0)))
 {arrayAssignAdd($where_fields[0][],addTaint($parent));
arrayAssignAdd($else_where_fields[0][],addTaint($parent));
$where = concat2($where,' AND tt.parent = %d');
$else_where = concat2($else_where,' AND tt.parent = %d');
}arrayAssignAdd($where_fields[0][],addTaint($taxonomy));
arrayAssignAdd($else_where_fields[0][],addTaint($taxonomy));
if ( deAspis($result = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat(concat2(concat(concat2(concat1("SELECT tt.term_id, tt.term_taxonomy_id FROM ",$wpdb[0]->terms)," AS t INNER JOIN "),$wpdb[0]->term_taxonomy)," as tt ON tt.term_id = t.term_id WHERE "),$where)," AND tt.taxonomy = %s"),$where_fields),array(ARRAY_A,false))))
 return $result;
return $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat(concat2(concat(concat2(concat1("SELECT tt.term_id, tt.term_taxonomy_id FROM ",$wpdb[0]->terms)," AS t INNER JOIN "),$wpdb[0]->term_taxonomy)," as tt ON tt.term_id = t.term_id WHERE "),$else_where)," AND tt.taxonomy = %s"),$else_where_fields),array(ARRAY_A,false));
}if ( deAspis($result = $wpdb[0]->get_var($wpdb[0]->prepare(concat(concat2(concat1("SELECT term_id FROM ",$wpdb[0]->terms)," as t WHERE "),$where),$where_fields))))
 return $result;
return $wpdb[0]->get_var($wpdb[0]->prepare(concat(concat2(concat1("SELECT term_id FROM ",$wpdb[0]->terms)," as t WHERE "),$else_where),$else_where_fields));
 }
function sanitize_term ( $term,$taxonomy,$context = array('display',false) ) {
if ( (('raw') == $context[0]))
 return $term;
$fields = array(array(array('term_id',false),array('name',false),array('description',false),array('slug',false),array('count',false),array('parent',false),array('term_group',false)),false);
$do_object = array(false,false);
if ( is_object($term[0]))
 $do_object = array(true,false);
$term_id = $do_object[0] ? $term[0]->term_id : (((isset($term[0][('term_id')]) && Aspis_isset( $term [0][('term_id')]))) ? $term[0]['term_id'] : array(0,false));
foreach ( deAspis(array_cast($fields)) as $field  )
{if ( $do_object[0])
 {if ( ((isset($term[0]->$field[0]) && Aspis_isset( $term[0] ->$field[0] ))))
 $term[0]->$field[0] = sanitize_term_field($field,$term[0]->$field[0],$term_id,$taxonomy,$context);
}else 
{{if ( ((isset($term[0][$field[0]]) && Aspis_isset( $term [0][$field[0]]))))
 arrayAssign($term[0],deAspis(registerTaint($field)),addTaint(sanitize_term_field($field,attachAspis($term,$field[0]),$term_id,$taxonomy,$context)));
}}}if ( $do_object[0])
 $term[0]->filter = $context;
else 
{arrayAssign($term[0],deAspis(registerTaint(array('filter',false))),addTaint($context));
}return $term;
 }
function sanitize_term_field ( $field,$value,$term_id,$taxonomy,$context ) {
if ( ((((('parent') == $field[0]) || (('term_id') == $field[0])) || (('count') == $field[0])) || (('term_group') == $field[0])))
 {$value = int_cast($value);
if ( ($value[0] < (0)))
 $value = array(0,false);
}if ( (('raw') == $context[0]))
 return $value;
if ( (('edit') == $context[0]))
 {$value = apply_filters(concat1("edit_term_",$field),$value,$term_id,$taxonomy);
$value = apply_filters(concat(concat2(concat1("edit_",$taxonomy),"_"),$field),$value,$term_id);
if ( (('description') == $field[0]))
 $value = format_to_edit($value);
else 
{$value = esc_attr($value);
}}else 
{if ( (('db') == $context[0]))
 {$value = apply_filters(concat1("pre_term_",$field),$value,$taxonomy);
$value = apply_filters(concat(concat2(concat1("pre_",$taxonomy),"_"),$field),$value);
if ( (('slug') == $field[0]))
 $value = apply_filters(array('pre_category_nicename',false),$value);
}else 
{if ( (('rss') == $context[0]))
 {$value = apply_filters(concat2(concat1("term_",$field),"_rss"),$value,$taxonomy);
$value = apply_filters(concat2(concat(concat2($taxonomy,"_"),$field),"_rss"),$value);
}else 
{{$value = apply_filters(concat1("term_",$field),$value,$term_id,$taxonomy,$context);
$value = apply_filters(concat(concat2($taxonomy,"_"),$field),$value,$term_id,$context);
}}}}if ( (('attribute') == $context[0]))
 $value = esc_attr($value);
else 
{if ( (('js') == $context[0]))
 $value = esc_js($value);
}return $value;
 }
function wp_count_terms ( $taxonomy,$args = array(array(),false) ) {
global $wpdb;
$defaults = array(array('ignore_empty' => array(false,false,false)),false);
$args = wp_parse_args($args,$defaults);
extract(($args[0]),EXTR_SKIP);
$where = array('',false);
if ( $ignore_empty[0])
 $where = array('AND count > 0',false);
return $wpdb[0]->get_var($wpdb[0]->prepare(concat(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->term_taxonomy)," WHERE taxonomy = %s "),$where),$taxonomy));
 }
function wp_delete_object_term_relationships ( $object_id,$taxonomies ) {
global $wpdb;
$object_id = int_cast($object_id);
if ( (!(is_array($taxonomies[0]))))
 $taxonomies = array(array($taxonomies),false);
foreach ( deAspis(array_cast($taxonomies)) as $taxonomy  )
{$tt_ids = wp_get_object_terms($object_id,$taxonomy,array('fields=tt_ids',false));
$in_tt_ids = concat2(concat1("'",Aspis_implode(array("', '",false),$tt_ids)),"'");
do_action(array('delete_term_relationships',false),$object_id,$tt_ids);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat(concat2(concat1("DELETE FROM ",$wpdb[0]->term_relationships)," WHERE object_id = %d AND term_taxonomy_id IN ("),$in_tt_ids),")"),$object_id));
do_action(array('deleted_term_relationships',false),$object_id,$tt_ids);
wp_update_term_count($tt_ids,$taxonomy);
} }
function wp_delete_term ( $term,$taxonomy,$args = array(array(),false) ) {
global $wpdb;
$term = int_cast($term);
if ( (denot_boolean($ids = is_term($term,$taxonomy))))
 return array(false,false);
if ( deAspis(is_wp_error($ids)))
 return $ids;
$tt_id = $ids[0]['term_taxonomy_id'];
$defaults = array(array(),false);
$args = wp_parse_args($args,$defaults);
extract(($args[0]),EXTR_SKIP);
if ( ((isset($default) && Aspis_isset( $default))))
 {$default = int_cast($default);
if ( (denot_boolean(is_term($default,$taxonomy))))
 unset($default);
}if ( deAspis(is_taxonomy_hierarchical($taxonomy)))
 {$term_obj = get_term($term,$taxonomy);
if ( deAspis(is_wp_error($term_obj)))
 return $term_obj;
$parent = $term_obj[0]->parent;
$edit_tt_ids = $wpdb[0]->get_col(concat(concat2(concat1("SELECT `term_taxonomy_id` FROM ",$wpdb[0]->term_taxonomy)," WHERE `parent` = "),int_cast($term_obj[0]->term_id)));
do_action(array('edit_term_taxonomies',false),$edit_tt_ids);
$wpdb[0]->update($wpdb[0]->term_taxonomy,array(compact('parent'),false),array((array(deregisterTaint(array('parent',false)) => addTaint($term_obj[0]->term_id))) + (compact('taxonomy')),false));
do_action(array('edited_term_taxonomies',false),$edit_tt_ids);
}$objects = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT object_id FROM ",$wpdb[0]->term_relationships)," WHERE term_taxonomy_id = %d"),$tt_id));
foreach ( deAspis(array_cast($objects)) as $object  )
{$terms = wp_get_object_terms($object,$taxonomy,array(array('fields' => array('ids',false,false),'orderby' => array('none',false,false)),false));
if ( (((1) == count($terms[0])) && ((isset($default) && Aspis_isset( $default)))))
 {$terms = array(array($default),false);
}else 
{{$terms = Aspis_array_diff($terms,array(array($term),false));
if ( ((((isset($default) && Aspis_isset( $default))) && ((isset($force_default) && Aspis_isset( $force_default)))) && $force_default[0]))
 $terms = Aspis_array_merge($terms,array(array($default),false));
}}$terms = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC($terms)));
wp_set_object_terms($object,$terms,$taxonomy);
}do_action(array('delete_term_taxonomy',false),$tt_id);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->term_taxonomy)," WHERE term_taxonomy_id = %d"),$tt_id));
do_action(array('deleted_term_taxonomy',false),$tt_id);
if ( (denot_boolean($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->term_taxonomy)," WHERE term_id = %d"),$term)))))
 $wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->terms)," WHERE term_id = %d"),$term));
clean_term_cache($term,$taxonomy);
do_action(array('delete_term',false),$term,$tt_id,$taxonomy);
do_action(concat1("delete_",$taxonomy),$term,$tt_id);
return array(true,false);
 }
function wp_get_object_terms ( $object_ids,$taxonomies,$args = array(array(),false) ) {
global $wpdb;
if ( (!(is_array($taxonomies[0]))))
 $taxonomies = array(array($taxonomies),false);
foreach ( deAspis(array_cast($taxonomies)) as $taxonomy  )
{if ( (denot_boolean(is_taxonomy($taxonomy))))
 return array(new WP_Error(array('invalid_taxonomy',false),__(array('Invalid Taxonomy',false))),false);
}if ( (!(is_array($object_ids[0]))))
 $object_ids = array(array($object_ids),false);
$object_ids = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC($object_ids)));
$defaults = array(array('orderby' => array('name',false,false),'order' => array('ASC',false,false),'fields' => array('all',false,false)),false);
$args = wp_parse_args($args,$defaults);
$terms = array(array(),false);
if ( (count($taxonomies[0]) > (1)))
 {foreach ( $taxonomies[0] as $index =>$taxonomy )
{restoreTaint($index,$taxonomy);
{$t = get_taxonomy($taxonomy);
if ( ((((isset($t[0]->args) && Aspis_isset( $t[0] ->args ))) && is_array($t[0]->args[0])) && ($args[0] != deAspis(Aspis_array_merge($args,$t[0]->args)))))
 {unset($taxonomies[0][$index[0]]);
$terms = Aspis_array_merge($terms,wp_get_object_terms($object_ids,$taxonomy,Aspis_array_merge($args,$t[0]->args)));
}}}}else 
{{$t = get_taxonomy(attachAspis($taxonomies,(0)));
if ( (((isset($t[0]->args) && Aspis_isset( $t[0] ->args ))) && is_array($t[0]->args[0])))
 $args = Aspis_array_merge($args,$t[0]->args);
}}extract(($args[0]),EXTR_SKIP);
if ( (('count') == $orderby[0]))
 $orderby = array('tt.count',false);
else 
{if ( (('name') == $orderby[0]))
 $orderby = array('t.name',false);
else 
{if ( (('slug') == $orderby[0]))
 $orderby = array('t.slug',false);
else 
{if ( (('term_group') == $orderby[0]))
 $orderby = array('t.term_group',false);
else 
{if ( (('term_order') == $orderby[0]))
 $orderby = array('tr.term_order',false);
else 
{if ( (('none') == $orderby[0]))
 {$orderby = array('',false);
$order = array('',false);
}else 
{{$orderby = array('t.term_id',false);
}}}}}}}if ( ((('tt_ids') == $fields[0]) && (!((empty($orderby) || Aspis_empty( $orderby))))))
 $orderby = array('tr.term_taxonomy_id',false);
if ( (!((empty($orderby) || Aspis_empty( $orderby)))))
 $orderby = concat1("ORDER BY ",$orderby);
$taxonomies = concat2(concat1("'",Aspis_implode(array("', '",false),$taxonomies)),"'");
$object_ids = Aspis_implode(array(', ',false),$object_ids);
$select_this = array('',false);
if ( (('all') == $fields[0]))
 $select_this = array('t.*, tt.*',false);
else 
{if ( (('ids') == $fields[0]))
 $select_this = array('t.term_id',false);
else 
{if ( (('names') == $fields[0]))
 $select_this = array('t.name',false);
else 
{if ( (('all_with_object_id') == $fields[0]))
 $select_this = array('t.*, tt.*, tr.object_id',false);
}}}$query = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT ",$select_this)," FROM "),$wpdb[0]->terms)," AS t INNER JOIN "),$wpdb[0]->term_taxonomy)," AS tt ON tt.term_id = t.term_id INNER JOIN "),$wpdb[0]->term_relationships)," AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tt.taxonomy IN ("),$taxonomies),") AND tr.object_id IN ("),$object_ids),") "),$orderby)," "),$order);
if ( ((('all') == $fields[0]) || (('all_with_object_id') == $fields[0])))
 {$terms = Aspis_array_merge($terms,$wpdb[0]->get_results($query));
update_term_cache($terms);
}else 
{if ( ((('ids') == $fields[0]) || (('names') == $fields[0])))
 {$terms = Aspis_array_merge($terms,$wpdb[0]->get_col($query));
}else 
{if ( (('tt_ids') == $fields[0]))
 {$terms = $wpdb[0]->get_col(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT tr.term_taxonomy_id FROM ",$wpdb[0]->term_relationships)," AS tr INNER JOIN "),$wpdb[0]->term_taxonomy)," AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tr.object_id IN ("),$object_ids),") AND tt.taxonomy IN ("),$taxonomies),") "),$orderby)," "),$order));
}}}if ( (denot_boolean($terms)))
 $terms = array(array(),false);
return apply_filters(array('wp_get_object_terms',false),$terms,$object_ids,$taxonomies,$args);
 }
function wp_insert_term ( $term,$taxonomy,$args = array(array(),false) ) {
global $wpdb;
if ( (denot_boolean(is_taxonomy($taxonomy))))
 return array(new WP_Error(array('invalid_taxonomy',false),__(array('Invalid taxonomy',false))),false);
if ( (is_int(deAspisRC($term)) && ((0) == $term[0])))
 return array(new WP_Error(array('invalid_term_id',false),__(array('Invalid term ID',false))),false);
if ( (('') == deAspis(Aspis_trim($term))))
 return array(new WP_Error(array('empty_term_name',false),__(array('A name is required for this term',false))),false);
$defaults = array(array('alias_of' => array('',false,false),'description' => array('',false,false),'parent' => array(0,false,false),'slug' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
arrayAssign($args[0],deAspis(registerTaint(array('name',false))),addTaint($term));
arrayAssign($args[0],deAspis(registerTaint(array('taxonomy',false))),addTaint($taxonomy));
$args = sanitize_term($args,$taxonomy,array('db',false));
extract(($args[0]),EXTR_SKIP);
$name = Aspis_stripslashes($name);
$description = Aspis_stripslashes($description);
if ( ((empty($slug) || Aspis_empty( $slug))))
 $slug = sanitize_title($name);
$term_group = array(0,false);
if ( $alias_of[0])
 {$alias = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT term_id, term_group FROM ",$wpdb[0]->terms)," WHERE slug = %s"),$alias_of));
if ( $alias[0]->term_group[0])
 {$term_group = $alias[0]->term_group;
}else 
{{$term_group = array(deAspis($wpdb[0]->get_var(concat1("SELECT MAX(term_group) FROM ",$wpdb[0]->terms))) + (1),false);
do_action(array('edit_terms',false),$alias[0]->term_id);
$wpdb[0]->update($wpdb[0]->terms,array(compact('term_group'),false),array(array(deregisterTaint(array('term_id',false)) => addTaint($alias[0]->term_id)),false));
do_action(array('edited_terms',false),$alias[0]->term_id);
}}}if ( (denot_boolean($term_id = is_term($slug))))
 {if ( (false === deAspis($wpdb[0]->insert($wpdb[0]->terms,array(compact('name','slug','term_group'),false)))))
 return array(new WP_Error(array('db_insert_error',false),__(array('Could not insert term into the database',false)),$wpdb[0]->last_error),false);
$term_id = int_cast($wpdb[0]->insert_id);
}else 
{if ( (deAspis(is_taxonomy_hierarchical($taxonomy)) && (!((empty($parent) || Aspis_empty( $parent))))))
 {$slug = wp_unique_term_slug($slug,object_cast($args));
if ( (false === deAspis($wpdb[0]->insert($wpdb[0]->terms,array(compact('name','slug','term_group'),false)))))
 return array(new WP_Error(array('db_insert_error',false),__(array('Could not insert term into the database',false)),$wpdb[0]->last_error),false);
$term_id = int_cast($wpdb[0]->insert_id);
}}if ( ((empty($slug) || Aspis_empty( $slug))))
 {$slug = sanitize_title($slug,$term_id);
do_action(array('edit_terms',false),$term_id);
$wpdb[0]->update($wpdb[0]->terms,array(compact('slug'),false),array(compact('term_id'),false));
do_action(array('edited_terms',false),$term_id);
}$tt_id = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat(concat2(concat1("SELECT tt.term_taxonomy_id FROM ",$wpdb[0]->term_taxonomy)," AS tt INNER JOIN "),$wpdb[0]->terms)," AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = %s AND t.term_id = %d"),$taxonomy,$term_id));
if ( (!((empty($tt_id) || Aspis_empty( $tt_id)))))
 return array(array(deregisterTaint(array('term_id',false)) => addTaint($term_id),deregisterTaint(array('term_taxonomy_id',false)) => addTaint($tt_id)),false);
$wpdb[0]->insert($wpdb[0]->term_taxonomy,array((compact('term_id','taxonomy','description','parent')) + (array('count' => array(0,false,false))),false));
$tt_id = int_cast($wpdb[0]->insert_id);
do_action(array("create_term",false),$term_id,$tt_id,$taxonomy);
do_action(concat1("create_",$taxonomy),$term_id,$tt_id);
$term_id = apply_filters(array('term_id_filter',false),$term_id,$tt_id);
clean_term_cache($term_id,$taxonomy);
do_action(array("created_term",false),$term_id,$tt_id,$taxonomy);
do_action(concat1("created_",$taxonomy),$term_id,$tt_id);
return array(array(deregisterTaint(array('term_id',false)) => addTaint($term_id),deregisterTaint(array('term_taxonomy_id',false)) => addTaint($tt_id)),false);
 }
function wp_set_object_terms ( $object_id,$terms,$taxonomy,$append = array(false,false) ) {
global $wpdb;
$object_id = int_cast($object_id);
if ( (denot_boolean(is_taxonomy($taxonomy))))
 return array(new WP_Error(array('invalid_taxonomy',false),__(array('Invalid Taxonomy',false))),false);
if ( (!(is_array($terms[0]))))
 $terms = array(array($terms),false);
if ( (denot_boolean($append)))
 $old_tt_ids = wp_get_object_terms($object_id,$taxonomy,array(array('fields' => array('tt_ids',false,false),'orderby' => array('none',false,false)),false));
$tt_ids = array(array(),false);
$term_ids = array(array(),false);
foreach ( deAspis(array_cast($terms)) as $term  )
{if ( (!(strlen(deAspis(Aspis_trim($term))))))
 continue ;
if ( (denot_boolean($term_info = is_term($term,$taxonomy))))
 $term_info = wp_insert_term($term,$taxonomy);
if ( deAspis(is_wp_error($term_info)))
 return $term_info;
arrayAssignAdd($term_ids[0][],addTaint($term_info[0]['term_id']));
$tt_id = $term_info[0]['term_taxonomy_id'];
arrayAssignAdd($tt_ids[0][],addTaint($tt_id));
if ( deAspis($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT term_taxonomy_id FROM ",$wpdb[0]->term_relationships)," WHERE object_id = %d AND term_taxonomy_id = %d"),$object_id,$tt_id))))
 continue ;
do_action(array('add_term_relationship',false),$object_id,$tt_id);
$wpdb[0]->insert($wpdb[0]->term_relationships,array(array(deregisterTaint(array('object_id',false)) => addTaint($object_id),deregisterTaint(array('term_taxonomy_id',false)) => addTaint($tt_id)),false));
do_action(array('added_term_relationship',false),$object_id,$tt_id);
}wp_update_term_count($tt_ids,$taxonomy);
if ( (denot_boolean($append)))
 {$delete_terms = Aspis_array_diff($old_tt_ids,$tt_ids);
if ( $delete_terms[0])
 {$in_delete_terms = concat2(concat1("'",Aspis_implode(array("', '",false),$delete_terms)),"'");
do_action(array('delete_term_relationships',false),$object_id,$delete_terms);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat(concat2(concat1("DELETE FROM ",$wpdb[0]->term_relationships)," WHERE object_id = %d AND term_taxonomy_id IN ("),$in_delete_terms),")"),$object_id));
do_action(array('deleted_term_relationships',false),$object_id,$delete_terms);
wp_update_term_count($delete_terms,$taxonomy);
}}$t = get_taxonomy($taxonomy);
if ( (((denot_boolean($append)) && ((isset($t[0]->sort) && Aspis_isset( $t[0] ->sort )))) && $t[0]->sort[0]))
 {$values = array(array(),false);
$term_order = array(0,false);
$final_tt_ids = wp_get_object_terms($object_id,$taxonomy,array('fields=tt_ids',false));
foreach ( $tt_ids[0] as $tt_id  )
if ( deAspis(Aspis_in_array($tt_id,$final_tt_ids)))
 arrayAssignAdd($values[0][],addTaint($wpdb[0]->prepare(array("(%d, %d, %d)",false),$object_id,$tt_id,preincr($term_order))));
if ( $values[0])
 $wpdb[0]->query(concat2(concat(concat2(concat1("INSERT INTO ",$wpdb[0]->term_relationships)," (object_id, term_taxonomy_id, term_order) VALUES "),Aspis_join(array(',',false),$values))," ON DUPLICATE KEY UPDATE term_order = VALUES(term_order)"));
}do_action(array('set_object_terms',false),$object_id,$terms,$tt_ids,$taxonomy,$append,$old_tt_ids);
return $tt_ids;
 }
function wp_unique_term_slug ( $slug,$term ) {
global $wpdb;
if ( (deAspis(is_taxonomy_hierarchical($term[0]->taxonomy)) && (!((empty($term[0]->parent) || Aspis_empty( $term[0] ->parent ))))))
 {$the_parent = $term[0]->parent;
while ( (!((empty($the_parent) || Aspis_empty( $the_parent)))) )
{$parent_term = get_term($the_parent,$term[0]->taxonomy);
if ( (deAspis(is_wp_error($parent_term)) || ((empty($parent_term) || Aspis_empty( $parent_term)))))
 break ;
$slug = concat($slug,concat1('-',$parent_term[0]->slug));
if ( ((empty($parent_term[0]->parent) || Aspis_empty( $parent_term[0] ->parent ))))
 break ;
$the_parent = $parent_term[0]->parent;
}}if ( (!((empty($args[0][('term_id')]) || Aspis_empty( $args [0][('term_id')])))))
 $query = $wpdb[0]->prepare(concat2(concat1("SELECT slug FROM ",$wpdb[0]->terms)," WHERE slug = %s AND term_id != %d"),$slug,$args[0]['term_id']);
else 
{$query = $wpdb[0]->prepare(concat2(concat1("SELECT slug FROM ",$wpdb[0]->terms)," WHERE slug = %s"),$slug);
}if ( deAspis($wpdb[0]->get_var($query)))
 {$num = array(2,false);
do {$alt_slug = concat($slug,concat1("-",$num));
postincr($num);
$slug_check = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT slug FROM ",$wpdb[0]->terms)," WHERE slug = %s"),$alt_slug));
}while ($slug_check[0] )
;
$slug = $alt_slug;
}return $slug;
 }
function wp_update_term ( $term_id,$taxonomy,$args = array(array(),false) ) {
global $wpdb;
if ( (denot_boolean(is_taxonomy($taxonomy))))
 return array(new WP_Error(array('invalid_taxonomy',false),__(array('Invalid taxonomy',false))),false);
$term_id = int_cast($term_id);
$term = get_term($term_id,$taxonomy,array(ARRAY_A,false));
if ( deAspis(is_wp_error($term)))
 return $term;
$term = add_magic_quotes($term);
$args = Aspis_array_merge($term,$args);
$defaults = array(array('alias_of' => array('',false,false),'description' => array('',false,false),'parent' => array(0,false,false),'slug' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
$args = sanitize_term($args,$taxonomy,array('db',false));
extract(($args[0]),EXTR_SKIP);
$name = Aspis_stripslashes($name);
$description = Aspis_stripslashes($description);
if ( (('') == deAspis(Aspis_trim($name))))
 return array(new WP_Error(array('empty_term_name',false),__(array('A name is required for this term',false))),false);
$empty_slug = array(false,false);
if ( ((empty($slug) || Aspis_empty( $slug))))
 {$empty_slug = array(true,false);
$slug = sanitize_title($name);
}if ( $alias_of[0])
 {$alias = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT term_id, term_group FROM ",$wpdb[0]->terms)," WHERE slug = %s"),$alias_of));
if ( $alias[0]->term_group[0])
 {$term_group = $alias[0]->term_group;
}else 
{{$term_group = array(deAspis($wpdb[0]->get_var(concat1("SELECT MAX(term_group) FROM ",$wpdb[0]->terms))) + (1),false);
do_action(array('edit_terms',false),$alias[0]->term_id);
$wpdb[0]->update($wpdb[0]->terms,array(compact('term_group'),false),array(array(deregisterTaint(array('term_id',false)) => addTaint($alias[0]->term_id)),false));
do_action(array('edited_terms',false),$alias[0]->term_id);
}}}$id = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT term_id FROM ",$wpdb[0]->terms)," WHERE slug = %s"),$slug));
if ( ($id[0] && ($id[0] != $term_id[0])))
 {if ( ($empty_slug[0] || ($parent[0] != $term[0]->parent[0])))
 $slug = wp_unique_term_slug($slug,object_cast($args));
else 
{return array(new WP_Error(array('duplicate_term_slug',false),Aspis_sprintf(__(array('The slug &#8220;%s&#8221; is already in use by another term',false)),$slug)),false);
}}do_action(array('edit_terms',false),$term_id);
$wpdb[0]->update($wpdb[0]->terms,array(compact('name','slug','term_group'),false),array(compact('term_id'),false));
if ( ((empty($slug) || Aspis_empty( $slug))))
 {$slug = sanitize_title($name,$term_id);
$wpdb[0]->update($wpdb[0]->terms,array(compact('slug'),false),array(compact('term_id'),false));
}do_action(array('edited_terms',false),$term_id);
$tt_id = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat(concat2(concat1("SELECT tt.term_taxonomy_id FROM ",$wpdb[0]->term_taxonomy)," AS tt INNER JOIN "),$wpdb[0]->terms)," AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = %s AND t.term_id = %d"),$taxonomy,$term_id));
do_action(array('edit_term_taxonomy',false),$tt_id);
$wpdb[0]->update($wpdb[0]->term_taxonomy,array(compact('term_id','taxonomy','description','parent'),false),array(array(deregisterTaint(array('term_taxonomy_id',false)) => addTaint($tt_id)),false));
do_action(array('edited_term_taxonomy',false),$tt_id);
do_action(array("edit_term",false),$term_id,$tt_id,$taxonomy);
do_action(concat1("edit_",$taxonomy),$term_id,$tt_id);
$term_id = apply_filters(array('term_id_filter',false),$term_id,$tt_id);
clean_term_cache($term_id,$taxonomy);
do_action(array("edited_term",false),$term_id,$tt_id,$taxonomy);
do_action(concat1("edited_",$taxonomy),$term_id,$tt_id);
return array(array(deregisterTaint(array('term_id',false)) => addTaint($term_id),deregisterTaint(array('term_taxonomy_id',false)) => addTaint($tt_id)),false);
 }
function wp_defer_term_counting ( $defer = array(null,false) ) {
static $_defer = array(false,false);
if ( is_bool(deAspisRC($defer)))
 {$_defer = $defer;
if ( (denot_boolean($defer)))
 wp_update_term_count(array(null,false),array(null,false),array(true,false));
}return $_defer;
 }
function wp_update_term_count ( $terms,$taxonomy,$do_deferred = array(false,false) ) {
static $_deferred = array(array(),false);
if ( $do_deferred[0])
 {foreach ( deAspis(array_cast(attAspisRC(array_keys(deAspisRC($_deferred))))) as $tax  )
{wp_update_term_count_now(attachAspis($_deferred,$tax[0]),$tax);
unset($_deferred[0][$tax[0]]);
}}if ( ((empty($terms) || Aspis_empty( $terms))))
 return array(false,false);
if ( (!(is_array($terms[0]))))
 $terms = array(array($terms),false);
if ( deAspis(wp_defer_term_counting()))
 {if ( (!((isset($_deferred[0][$taxonomy[0]]) && Aspis_isset( $_deferred [0][$taxonomy[0]])))))
 arrayAssign($_deferred[0],deAspis(registerTaint($taxonomy)),addTaint(array(array(),false)));
arrayAssign($_deferred[0],deAspis(registerTaint($taxonomy)),addTaint(attAspisRC(array_unique(deAspisRC(Aspis_array_merge(attachAspis($_deferred,$taxonomy[0]),$terms))))));
return array(true,false);
}return wp_update_term_count_now($terms,$taxonomy);
 }
function wp_update_term_count_now ( $terms,$taxonomy ) {
global $wpdb;
$terms = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC($terms)));
$taxonomy = get_taxonomy($taxonomy);
if ( (!((empty($taxonomy[0]->update_count_callback) || Aspis_empty( $taxonomy[0] ->update_count_callback )))))
 {Aspis_call_user_func($taxonomy[0]->update_count_callback,$terms);
}else 
{{foreach ( deAspis(array_cast($terms)) as $term  )
{$count = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->term_relationships)," WHERE term_taxonomy_id = %d"),$term));
do_action(array('edit_term_taxonomy',false),$term);
$wpdb[0]->update($wpdb[0]->term_taxonomy,array(compact('count'),false),array(array(deregisterTaint(array('term_taxonomy_id',false)) => addTaint($term)),false));
do_action(array('edited_term_taxonomy',false),$term);
}}}clean_term_cache($terms);
return array(true,false);
 }
function clean_object_term_cache ( $object_ids,$object_type ) {
if ( (!(is_array($object_ids[0]))))
 $object_ids = array(array($object_ids),false);
foreach ( $object_ids[0] as $id  )
foreach ( deAspis(get_object_taxonomies($object_type)) as $taxonomy  )
wp_cache_delete($id,concat2($taxonomy,"_relationships"));
do_action(array('clean_object_term_cache',false),$object_ids,$object_type);
 }
function clean_term_cache ( $ids,$taxonomy = array('',false) ) {
global $wpdb;
static $cleaned = array(array(),false);
if ( (!(is_array($ids[0]))))
 $ids = array(array($ids),false);
$taxonomies = array(array(),false);
if ( ((empty($taxonomy) || Aspis_empty( $taxonomy))))
 {$tt_ids = Aspis_implode(array(', ',false),$ids);
$terms = $wpdb[0]->get_results(concat2(concat(concat2(concat1("SELECT term_id, taxonomy FROM ",$wpdb[0]->term_taxonomy)," WHERE term_taxonomy_id IN ("),$tt_ids),")"));
foreach ( deAspis(array_cast($terms)) as $term  )
{arrayAssignAdd($taxonomies[0][],addTaint($term[0]->taxonomy));
wp_cache_delete($term[0]->term_id,$term[0]->taxonomy);
}$taxonomies = attAspisRC(array_unique(deAspisRC($taxonomies)));
}else 
{{foreach ( $ids[0] as $id  )
{wp_cache_delete($id,$taxonomy);
}$taxonomies = array(array($taxonomy),false);
}}foreach ( $taxonomies[0] as $taxonomy  )
{if ( ((isset($cleaned[0][$taxonomy[0]]) && Aspis_isset( $cleaned [0][$taxonomy[0]]))))
 continue ;
arrayAssign($cleaned[0],deAspis(registerTaint($taxonomy)),addTaint(array(true,false)));
wp_cache_delete(array('all_ids',false),$taxonomy);
wp_cache_delete(array('get',false),$taxonomy);
delete_option(concat2($taxonomy,"_children"));
}wp_cache_set(array('last_changed',false),attAspis(time()),array('terms',false));
do_action(array('clean_term_cache',false),$ids,$taxonomy);
 }
function &get_object_term_cache ( $id,$taxonomy ) {
$cache = wp_cache_get($id,concat2($taxonomy,"_relationships"));
return $cache;
 }
function update_object_term_cache ( $object_ids,$object_type ) {
if ( ((empty($object_ids) || Aspis_empty( $object_ids))))
 return ;
if ( (!(is_array($object_ids[0]))))
 $object_ids = Aspis_explode(array(',',false),$object_ids);
$object_ids = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC($object_ids)));
$taxonomies = get_object_taxonomies($object_type);
$ids = array(array(),false);
foreach ( deAspis(array_cast($object_ids)) as $id  )
{foreach ( $taxonomies[0] as $taxonomy  )
{if ( (false === deAspis(wp_cache_get($id,concat2($taxonomy,"_relationships")))))
 {arrayAssignAdd($ids[0][],addTaint($id));
break ;
}}}if ( ((empty($ids) || Aspis_empty( $ids))))
 return array(false,false);
$terms = wp_get_object_terms($ids,$taxonomies,array('fields=all_with_object_id',false));
$object_terms = array(array(),false);
foreach ( deAspis(array_cast($terms)) as $term  )
arrayAssign($object_terms[0][$term[0]->object_id[0]][0][$term[0]->taxonomy[0]][0],deAspis(registerTaint($term[0]->term_id)),addTaint($term));
foreach ( $ids[0] as $id  )
{foreach ( $taxonomies[0] as $taxonomy  )
{if ( (!((isset($object_terms[0][$id[0]][0][$taxonomy[0]]) && Aspis_isset( $object_terms [0][$id[0]] [0][$taxonomy[0]])))))
 {if ( (!((isset($object_terms[0][$id[0]]) && Aspis_isset( $object_terms [0][$id[0]])))))
 arrayAssign($object_terms[0],deAspis(registerTaint($id)),addTaint(array(array(),false)));
arrayAssign($object_terms[0][$id[0]][0],deAspis(registerTaint($taxonomy)),addTaint(array(array(),false)));
}}}foreach ( $object_terms[0] as $id =>$value )
{restoreTaint($id,$value);
{foreach ( $value[0] as $taxonomy =>$terms )
{restoreTaint($taxonomy,$terms);
{wp_cache_set($id,$terms,concat2($taxonomy,"_relationships"));
}}}} }
function update_term_cache ( $terms,$taxonomy = array('',false) ) {
foreach ( deAspis(array_cast($terms)) as $term  )
{$term_taxonomy = $taxonomy;
if ( ((empty($term_taxonomy) || Aspis_empty( $term_taxonomy))))
 $term_taxonomy = $term[0]->taxonomy;
wp_cache_add($term[0]->term_id,$term,$term_taxonomy);
} }
function _get_term_hierarchy ( $taxonomy ) {
if ( (denot_boolean(is_taxonomy_hierarchical($taxonomy))))
 return array(array(),false);
$children = get_option(concat2($taxonomy,"_children"));
if ( is_array($children[0]))
 return $children;
$children = array(array(),false);
$terms = get_terms($taxonomy,array('get=all',false));
foreach ( $terms[0] as $term  )
{if ( ($term[0]->parent[0] > (0)))
 arrayAssignAdd($children[0][$term[0]->parent[0]][0][],addTaint($term[0]->term_id));
}update_option(concat2($taxonomy,"_children"),$children);
return $children;
 }
function &_get_term_children ( $term_id,$terms,$taxonomy ) {
$empty_array = array(array(),false);
if ( ((empty($terms) || Aspis_empty( $terms))))
 return $empty_array;
$term_list = array(array(),false);
$has_children = _get_term_hierarchy($taxonomy);
if ( (((0) != $term_id[0]) && (!((isset($has_children[0][$term_id[0]]) && Aspis_isset( $has_children [0][$term_id[0]]))))))
 return $empty_array;
foreach ( deAspis(array_cast($terms)) as $term  )
{$use_id = array(false,false);
if ( (!(is_object($term[0]))))
 {$term = get_term($term,$taxonomy);
if ( deAspis(is_wp_error($term)))
 return $term;
$use_id = array(true,false);
}if ( ($term[0]->term_id[0] == $term_id[0]))
 continue ;
if ( ($term[0]->parent[0] == $term_id[0]))
 {if ( $use_id[0])
 arrayAssignAdd($term_list[0][],addTaint($term[0]->term_id));
else 
{arrayAssignAdd($term_list[0][],addTaint($term));
}if ( (!((isset($has_children[0][$term[0]->term_id[0]]) && Aspis_isset( $has_children [0][$term[0] ->term_id [0]])))))
 continue ;
if ( deAspis($children = _get_term_children($term[0]->term_id,$terms,$taxonomy)))
 $term_list = Aspis_array_merge($term_list,$children);
}}return $term_list;
 }
function _pad_term_counts ( &$terms,$taxonomy ) {
global $wpdb;
if ( (denot_boolean(is_taxonomy_hierarchical($taxonomy))))
 return ;
$term_hier = _get_term_hierarchy($taxonomy);
if ( ((empty($term_hier) || Aspis_empty( $term_hier))))
 return ;
$term_items = array(array(),false);
foreach ( deAspis(array_cast($terms)) as $key =>$term )
{restoreTaint($key,$term);
{$terms_by_id[0][deAspis(registerTaint($term[0]->term_id))] = &addTaintR($terms[0][$key[0]]);
arrayAssign($term_ids[0],deAspis(registerTaint($term[0]->term_taxonomy_id)),addTaint($term[0]->term_id));
}}$results = $wpdb[0]->get_results(concat2(concat(concat2(concat(concat2(concat1("SELECT object_id, term_taxonomy_id FROM ",$wpdb[0]->term_relationships)," INNER JOIN "),$wpdb[0]->posts)," ON object_id = ID WHERE term_taxonomy_id IN ("),Aspis_join(array(',',false),attAspisRC(array_keys(deAspisRC($term_ids))))),") AND post_type = 'post' AND post_status = 'publish'"));
foreach ( $results[0] as $row  )
{$id = attachAspis($term_ids,$row[0]->term_taxonomy_id[0]);
arrayAssign($term_items[0][$id[0]][0],deAspis(registerTaint($row[0]->object_id)),addTaint(((isset($term_items[0][$id[0]][0][$row[0]->object_id[0]]) && Aspis_isset( $term_items [0][$id[0]] [0][$row[0] ->object_id [0]]))) ? preincr(attachAspis($term_items[0][$id[0]],$row[0]->object_id[0])) : array(1,false)));
}foreach ( $term_ids[0] as $term_id  )
{$child = $term_id;
while ( deAspis($parent = $terms_by_id[0][$child[0]][0]->parent) )
{if ( (!((empty($term_items[0][$term_id[0]]) || Aspis_empty( $term_items [0][$term_id[0]])))))
 foreach ( deAspis(attachAspis($term_items,$term_id[0])) as $item_id =>$touches )
{restoreTaint($item_id,$touches);
{arrayAssign($term_items[0][$parent[0]][0],deAspis(registerTaint($item_id)),addTaint(((isset($term_items[0][$parent[0]][0][$item_id[0]]) && Aspis_isset( $term_items [0][$parent[0]] [0][$item_id[0]]))) ? preincr(attachAspis($term_items[0][$parent[0]],$item_id[0])) : array(1,false)));
}}$child = $parent;
}}foreach ( deAspis(array_cast($term_items)) as $id =>$items )
{restoreTaint($id,$items);
if ( ((isset($terms_by_id[0][$id[0]]) && Aspis_isset( $terms_by_id [0][$id[0]]))))
 $terms_by_id[0][$id[0]][0]->count = attAspis(count($items[0]));
} }
function _update_post_term_count ( $terms ) {
global $wpdb;
foreach ( deAspis(array_cast($terms)) as $term  )
{$count = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->term_relationships),", "),$wpdb[0]->posts)," WHERE "),$wpdb[0]->posts),".ID = "),$wpdb[0]->term_relationships),".object_id AND post_status = 'publish' AND post_type = 'post' AND term_taxonomy_id = %d"),$term));
do_action(array('edit_term_taxonomy',false),$term);
$wpdb[0]->update($wpdb[0]->term_taxonomy,array(compact('count'),false),array(array(deregisterTaint(array('term_taxonomy_id',false)) => addTaint($term)),false));
do_action(array('edited_term_taxonomy',false),$term);
} }
function get_term_link ( $term,$taxonomy ) {
global $wp_rewrite;
if ( (!(is_object($term[0]))))
 {if ( is_int(deAspisRC($term)))
 {$term = &get_term($term,$taxonomy);
}else 
{{$term = &get_term_by(array('slug',false),$term,$taxonomy);
}}}if ( deAspis(is_wp_error($term)))
 return $term;
if ( ($taxonomy[0] == ('category')))
 return get_category_link(int_cast($term[0]->term_id));
if ( ($taxonomy[0] == ('post_tag')))
 return get_tag_link(int_cast($term[0]->term_id));
$termlink = $wp_rewrite[0]->get_extra_permastruct($taxonomy);
$slug = $term[0]->slug;
if ( ((empty($termlink) || Aspis_empty( $termlink))))
 {$file = trailingslashit(get_option(array('home',false)));
$t = get_taxonomy($taxonomy);
if ( $t[0]->query_var[0])
 $termlink = concat(concat2(concat(concat2($file,"?"),$t[0]->query_var),"="),$slug);
else 
{$termlink = concat(concat2(concat(concat2($file,"?taxonomy="),$taxonomy),"&term="),$slug);
}}else 
{{$termlink = Aspis_str_replace(concat2(concat1("%",$taxonomy),"%"),$slug,$termlink);
$termlink = concat(get_option(array('home',false)),user_trailingslashit($termlink,array('category',false)));
}}return apply_filters(array('term_link',false),$termlink,$term,$taxonomy);
 }
function the_taxonomies ( $args = array(array(),false) ) {
$defaults = array(array('post' => array(0,false,false),'before' => array('',false,false),'sep' => array(' ',false,false),'after' => array('',false,false),),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
echo AspisCheckPrint(concat(concat($before,Aspis_join($sep,get_the_taxonomies($post))),$after));
 }
function get_the_taxonomies ( $post = array(0,false) ) {
if ( is_int(deAspisRC($post)))
 $post = &get_post($post);
elseif ( (!(is_object($post[0]))))
 $post = &$GLOBALS[0][('post')];
$taxonomies = array(array(),false);
if ( (denot_boolean($post)))
 return $taxonomies;
$template = apply_filters(array('taxonomy_template',false),array('%s: %l.',false));
foreach ( deAspis(get_object_taxonomies($post)) as $taxonomy  )
{$t = array_cast(get_taxonomy($taxonomy));
if ( ((empty($t[0][('label')]) || Aspis_empty( $t [0][('label')]))))
 arrayAssign($t[0],deAspis(registerTaint(array('label',false))),addTaint($taxonomy));
if ( ((empty($t[0][('args')]) || Aspis_empty( $t [0][('args')]))))
 arrayAssign($t[0],deAspis(registerTaint(array('args',false))),addTaint(array(array(),false)));
if ( ((empty($t[0][('template')]) || Aspis_empty( $t [0][('template')]))))
 arrayAssign($t[0],deAspis(registerTaint(array('template',false))),addTaint($template));
$terms = get_object_term_cache($post[0]->ID,$taxonomy);
if ( ((empty($terms) || Aspis_empty( $terms))))
 $terms = wp_get_object_terms($post[0]->ID,$taxonomy,$t[0]['args']);
$links = array(array(),false);
foreach ( $terms[0] as $term  )
arrayAssignAdd($links[0][],addTaint(concat(concat1("<a href='",esc_attr(get_term_link($term,$taxonomy))),concat2(concat1("'>",$term[0]->name),"</a>"))));
if ( $links[0])
 arrayAssign($taxonomies[0],deAspis(registerTaint($taxonomy)),addTaint(wp_sprintf($t[0]['template'],$t[0]['label'],$links,$terms)));
}return $taxonomies;
 }
function get_post_taxonomies ( $post = array(0,false) ) {
$post = &get_post($post);
return get_object_taxonomies($post);
 }
function is_object_in_term ( $object_id,$taxonomy,$terms = array(null,false) ) {
if ( (denot_boolean($object_id = int_cast($object_id))))
 return array(new WP_Error(array('invalid_object',false),__(array('Invalid object ID',false))),false);
$object_terms = get_object_term_cache($object_id,$taxonomy);
if ( ((empty($object_terms) || Aspis_empty( $object_terms))))
 $object_terms = wp_get_object_terms($object_id,$taxonomy);
if ( deAspis(is_wp_error($object_terms)))
 return $object_terms;
if ( ((empty($object_terms) || Aspis_empty( $object_terms))))
 return array(false,false);
if ( ((empty($terms) || Aspis_empty( $terms))))
 return (not_boolean(array((empty($object_terms) || Aspis_empty( $object_terms)),false)));
$terms = array_cast($terms);
if ( deAspis($ints = attAspisRC(array_filter(deAspisRC($terms),AspisInternalCallback(array('is_int',false))))))
 $strs = Aspis_array_diff($terms,$ints);
else 
{$strs = &$terms;
}foreach ( $object_terms[0] as $object_term  )
{if ( ($ints[0] && deAspis(Aspis_in_array($object_term[0]->term_id,$ints))))
 return array(true,false);
if ( $strs[0])
 {if ( deAspis(Aspis_in_array($object_term[0]->term_id,$strs)))
 return array(true,false);
if ( deAspis(Aspis_in_array($object_term[0]->name,$strs)))
 return array(true,false);
if ( deAspis(Aspis_in_array($object_term[0]->slug,$strs)))
 return array(true,false);
}}return array(false,false);
 }
;
?>
<?php 