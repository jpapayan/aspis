<?php require_once('AspisMain.php'); ?><?php
function create_initial_taxonomies (  ) {
register_taxonomy('category','post',array('hierarchical' => true,'update_count_callback' => '_update_post_term_count','label' => __('Categories'),'query_var' => false,'rewrite' => false));
register_taxonomy('post_tag','post',array('hierarchical' => false,'update_count_callback' => '_update_post_term_count','label' => __('Post Tags'),'query_var' => false,'rewrite' => false));
register_taxonomy('link_category','link',array('hierarchical' => false,'label' => __('Categories'),'query_var' => false,'rewrite' => false));
 }
add_action('init','create_initial_taxonomies',0);
function get_object_taxonomies ( $object ) {
{global $wp_taxonomies;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_taxonomies,"\$wp_taxonomies",$AspisChangesCache);
}if ( is_object($object))
 {if ( $object->post_type == 'attachment')
 {$AspisRetTemp = get_attachment_taxonomies($object);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_taxonomies",$AspisChangesCache);
return $AspisRetTemp;
}$object = $object->post_type;
}$object = (array)$object;
$taxonomies = array();
foreach ( (array)$wp_taxonomies as $taxonomy  )
{if ( array_intersect($object,(array)$taxonomy->object_type))
 $taxonomies[] = $taxonomy->name;
}{$AspisRetTemp = $taxonomies;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_taxonomies",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_taxonomies",$AspisChangesCache);
 }
function get_taxonomy ( $taxonomy ) {
{global $wp_taxonomies;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_taxonomies,"\$wp_taxonomies",$AspisChangesCache);
}if ( !is_taxonomy($taxonomy))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_taxonomies",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $wp_taxonomies[$taxonomy];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_taxonomies",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_taxonomies",$AspisChangesCache);
 }
function is_taxonomy ( $taxonomy ) {
{global $wp_taxonomies;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_taxonomies,"\$wp_taxonomies",$AspisChangesCache);
}{$AspisRetTemp = isset($wp_taxonomies[$taxonomy]);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_taxonomies",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_taxonomies",$AspisChangesCache);
 }
function is_taxonomy_hierarchical ( $taxonomy ) {
if ( !is_taxonomy($taxonomy))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$taxonomy = get_taxonomy($taxonomy);
{$AspisRetTemp = $taxonomy->hierarchical;
return $AspisRetTemp;
} }
function register_taxonomy ( $taxonomy,$object_type,$args = array() ) {
{global $wp_taxonomies,$wp_rewrite,$wp;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_taxonomies,"\$wp_taxonomies",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp,"\$wp",$AspisChangesCache);
}if ( !is_array($wp_taxonomies))
 $wp_taxonomies = array();
$defaults = array('hierarchical' => false,'update_count_callback' => '','rewrite' => true,'query_var' => true);
$args = wp_parse_args($args,$defaults);
if ( false !== $args['query_var'] && !empty($wp))
 {if ( true === $args['query_var'])
 $args['query_var'] = $taxonomy;
$args['query_var'] = sanitize_title_with_dashes($args['query_var']);
$wp->add_query_var($args['query_var']);
}if ( false !== $args['rewrite'] && !empty($wp_rewrite))
 {if ( !is_array($args['rewrite']))
 $args['rewrite'] = array();
if ( !isset($args['rewrite']['slug']))
 $args['rewrite']['slug'] = sanitize_title_with_dashes($taxonomy);
$wp_rewrite->add_rewrite_tag("%$taxonomy%",'([^/]+)',$args['query_var'] ? "{$args['query_var']}=" : "taxonomy=$taxonomy&term=$term");
$wp_rewrite->add_permastruct($taxonomy,"{$args['rewrite']['slug']}/%$taxonomy%");
}$args['name'] = $taxonomy;
$args['object_type'] = $object_type;
$wp_taxonomies[$taxonomy] = (object)$args;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_taxonomies",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp",$AspisChangesCache);
 }
function get_objects_in_term ( $terms,$taxonomies,$args = array() ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !is_array($terms))
 $terms = array($terms);
if ( !is_array($taxonomies))
 $taxonomies = array($taxonomies);
foreach ( (array)$taxonomies as $taxonomy  )
{if ( !is_taxonomy($taxonomy))
 {$AspisRetTemp = new WP_Error('invalid_taxonomy',__('Invalid Taxonomy'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}$defaults = array('order' => 'ASC');
$args = wp_parse_args($args,$defaults);
extract(($args),EXTR_SKIP);
$order = ('desc' == strtolower($order)) ? 'DESC' : 'ASC';
$terms = array_map('intval',$terms);
$taxonomies = "'" . implode("', '",$taxonomies) . "'";
$terms = "'" . implode("', '",$terms) . "'";
$object_ids = $wpdb->get_col("SELECT tr.object_id FROM $wpdb->term_relationships AS tr INNER JOIN $wpdb->term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tt.taxonomy IN ($taxonomies) AND tt.term_id IN ($terms) ORDER BY tr.object_id $order");
if ( !$object_ids)
 {$AspisRetTemp = array();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $object_ids;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function &get_term ( $term,$taxonomy,$output = OBJECT,$filter = 'raw' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$null = null;
if ( empty($term))
 {$error = new WP_Error('invalid_term',__('Empty Term'));
{$AspisRetTemp = &$error;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}if ( !is_taxonomy($taxonomy))
 {$error = new WP_Error('invalid_taxonomy',__('Invalid Taxonomy'));
{$AspisRetTemp = &$error;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}if ( is_object($term) && empty($term->filter))
 {wp_cache_add($term->term_id,$term,$taxonomy);
$_term = $term;
}else 
{{if ( is_object($term))
 $term = $term->term_id;
$term = (int)$term;
if ( !$_term = wp_cache_get($term,$taxonomy))
 {$_term = $wpdb->get_row($wpdb->prepare("SELECT t.*, tt.* FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy = %s AND t.term_id = %s LIMIT 1",$taxonomy,$term));
if ( !$_term)
 {$AspisRetTemp = &$null;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}wp_cache_add($term,$_term,$taxonomy);
}}}$_term = apply_filters('get_term',$_term,$taxonomy);
$_term = apply_filters("get_$taxonomy",$_term,$taxonomy);
$_term = sanitize_term($_term,$taxonomy,$filter);
if ( $output == OBJECT)
 {{$AspisRetTemp = &$_term;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( $output == ARRAY_A)
 {$__term = get_object_vars($_term);
{$AspisRetTemp = &$__term;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( $output == ARRAY_N)
 {$__term = array_values(get_object_vars($_term));
{$AspisRetTemp = &$__term;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = &$_term;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_term_by ( $field,$value,$taxonomy,$output = OBJECT,$filter = 'raw' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !is_taxonomy($taxonomy))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( 'slug' == $field)
 {$field = 't.slug';
$value = sanitize_title($value);
if ( empty($value))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{if ( 'name' == $field)
 {$value = stripslashes($value);
$field = 't.name';
}else 
{{$field = 't.term_id';
$value = (int)$value;
}}}$term = $wpdb->get_row($wpdb->prepare("SELECT t.*, tt.* FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy = %s AND $field = %s LIMIT 1",$taxonomy,$value));
if ( !$term)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}wp_cache_add($term->term_id,$term,$taxonomy);
$term = sanitize_term($term,$taxonomy,$filter);
if ( $output == OBJECT)
 {{$AspisRetTemp = $term;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( $output == ARRAY_A)
 {{$AspisRetTemp = get_object_vars($term);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( $output == ARRAY_N)
 {{$AspisRetTemp = array_values(get_object_vars($term));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = $term;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_term_children ( $term_id,$taxonomy ) {
if ( !is_taxonomy($taxonomy))
 {$AspisRetTemp = new WP_Error('invalid_taxonomy',__('Invalid Taxonomy'));
return $AspisRetTemp;
}$term_id = intval($term_id);
$terms = _get_term_hierarchy($taxonomy);
if ( !isset($terms[$term_id]))
 {$AspisRetTemp = array();
return $AspisRetTemp;
}$children = $terms[$term_id];
foreach ( (array)$terms[$term_id] as $child  )
{if ( isset($terms[$child]))
 $children = array_merge($children,get_term_children($child,$taxonomy));
}{$AspisRetTemp = $children;
return $AspisRetTemp;
} }
function get_term_field ( $field,$term,$taxonomy,$context = 'display' ) {
$term = (int)$term;
$term = get_term($term,$taxonomy);
if ( is_wp_error($term))
 {$AspisRetTemp = $term;
return $AspisRetTemp;
}if ( !is_object($term))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}if ( !isset($term->$field))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = sanitize_term_field($field,$term->$field,$term->term_id,$taxonomy,$context);
return $AspisRetTemp;
} }
function get_term_to_edit ( $id,$taxonomy ) {
$term = get_term($id,$taxonomy);
if ( is_wp_error($term))
 {$AspisRetTemp = $term;
return $AspisRetTemp;
}if ( !is_object($term))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = sanitize_term($term,$taxonomy,'edit');
return $AspisRetTemp;
} }
function &get_terms ( $taxonomies,$args = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$empty_array = array();
$single_taxonomy = false;
if ( !is_array($taxonomies))
 {$single_taxonomy = true;
$taxonomies = array($taxonomies);
}foreach ( (array)$taxonomies as $taxonomy  )
{if ( !is_taxonomy($taxonomy))
 {$error = &new WP_Error('invalid_taxonomy',__('Invalid Taxonomy'));
{$AspisRetTemp = &$error;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}$in_taxonomies = "'" . implode("', '",$taxonomies) . "'";
$defaults = array('orderby' => 'name','order' => 'ASC','hide_empty' => true,'exclude' => '','exclude_tree' => '','include' => '','number' => '','fields' => 'all','slug' => '','parent' => '','hierarchical' => true,'child_of' => 0,'get' => '','name__like' => '','pad_counts' => false,'offset' => '','search' => '');
$args = wp_parse_args($args,$defaults);
$args['number'] = absint($args['number']);
$args['offset'] = absint($args['offset']);
if ( !$single_taxonomy || !is_taxonomy_hierarchical($taxonomies[0]) || '' !== $args['parent'])
 {$args['child_of'] = 0;
$args['hierarchical'] = false;
$args['pad_counts'] = false;
}if ( 'all' == $args['get'])
 {$args['child_of'] = 0;
$args['hide_empty'] = 0;
$args['hierarchical'] = false;
$args['pad_counts'] = false;
}extract(($args),EXTR_SKIP);
if ( $child_of)
 {$hierarchy = _get_term_hierarchy($taxonomies[0]);
if ( !isset($hierarchy[$child_of]))
 {$AspisRetTemp = &$empty_array;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}if ( $parent)
 {$hierarchy = _get_term_hierarchy($taxonomies[0]);
if ( !isset($hierarchy[$parent]))
 {$AspisRetTemp = &$empty_array;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}$filter_key = (has_filter('list_terms_exclusions')) ? serialize($GLOBALS[0]['wp_filter']['list_terms_exclusions']) : '';
$key = md5(serialize(compact(array_keys($defaults))) . serialize($taxonomies) . $filter_key);
$last_changed = wp_cache_get('last_changed','terms');
if ( !$last_changed)
 {$last_changed = time();
wp_cache_set('last_changed',$last_changed,'terms');
}$cache_key = "get_terms:$key:$last_changed";
$cache = wp_cache_get($cache_key,'terms');
if ( false !== $cache)
 {$cache = apply_filters('get_terms',$cache,$taxonomies,$args);
{$AspisRetTemp = &$cache;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}$_orderby = strtolower($orderby);
if ( 'count' == $_orderby)
 $orderby = 'tt.count';
else 
{if ( 'name' == $_orderby)
 $orderby = 't.name';
else 
{if ( 'slug' == $_orderby)
 $orderby = 't.slug';
else 
{if ( 'term_group' == $_orderby)
 $orderby = 't.term_group';
elseif ( empty($_orderby) || 'id' == $_orderby)
 $orderby = 't.term_id';
}}}$orderby = apply_filters('get_terms_orderby',$orderby,$args);
$where = '';
$inclusions = '';
if ( !empty($include))
 {$exclude = '';
$exclude_tree = '';
$interms = preg_split('/[\s,]+/',$include);
if ( count($interms))
 {foreach ( (array)$interms as $interm  )
{if ( empty($inclusions))
 $inclusions = ' AND ( t.term_id = ' . intval($interm) . ' ';
else 
{$inclusions .= ' OR t.term_id = ' . intval($interm) . ' ';
}}}}if ( !empty($inclusions))
 $inclusions .= ')';
$where .= $inclusions;
$exclusions = '';
if ( !empty($exclude_tree))
 {$excluded_trunks = preg_split('/[\s,]+/',$exclude_tree);
foreach ( (array)$excluded_trunks as $extrunk  )
{$excluded_children = (array)get_terms($taxonomies[0],array('child_of' => intval($extrunk),'fields' => 'ids'));
$excluded_children[] = $extrunk;
foreach ( (array)$excluded_children as $exterm  )
{if ( empty($exclusions))
 $exclusions = ' AND ( t.term_id <> ' . intval($exterm) . ' ';
else 
{$exclusions .= ' AND t.term_id <> ' . intval($exterm) . ' ';
}}}}if ( !empty($exclude))
 {$exterms = preg_split('/[\s,]+/',$exclude);
if ( count($exterms))
 {foreach ( (array)$exterms as $exterm  )
{if ( empty($exclusions))
 $exclusions = ' AND ( t.term_id <> ' . intval($exterm) . ' ';
else 
{$exclusions .= ' AND t.term_id <> ' . intval($exterm) . ' ';
}}}}if ( !empty($exclusions))
 $exclusions .= ')';
$exclusions = apply_filters('list_terms_exclusions',$exclusions,$args);
$where .= $exclusions;
if ( !empty($slug))
 {$slug = sanitize_title($slug);
$where .= " AND t.slug = '$slug'";
}if ( !empty($name__like))
 $where .= " AND t.name LIKE '{$name__like}%'";
if ( '' !== $parent)
 {$parent = (int)$parent;
$where .= " AND tt.parent = '$parent'";
}if ( $hide_empty && !$hierarchical)
 $where .= ' AND tt.count > 0';
if ( !empty($number) && !$hierarchical && empty($child_of) && '' === $parent)
 {if ( $offset)
 $limit = 'LIMIT ' . $offset . ',' . $number;
else 
{$limit = 'LIMIT ' . $number;
}}else 
{$limit = '';
}if ( !empty($search))
 {$search = like_escape($search);
$where .= " AND (t.name LIKE '%$search%')";
}$selects = array();
if ( 'all' == $fields)
 $selects = array('t.*','tt.*');
else 
{if ( 'ids' == $fields)
 $selects = array('t.term_id','tt.parent','tt.count');
else 
{if ( 'names' == $fields)
 $selects = array('t.term_id','tt.parent','tt.count','t.name');
}}$select_this = implode(', ',apply_filters('get_terms_fields',$selects,$args));
$query = "SELECT $select_this FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ($in_taxonomies) $where ORDER BY $orderby $order $limit";
$terms = $wpdb->get_results($query);
if ( 'all' == $fields)
 {update_term_cache($terms);
}if ( empty($terms))
 {wp_cache_add($cache_key,array(),'terms');
$terms = apply_filters('get_terms',array(),$taxonomies,$args);
{$AspisRetTemp = &$terms;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}if ( $child_of)
 {$children = _get_term_hierarchy($taxonomies[0]);
if ( !empty($children))
 $terms = &_get_term_children($child_of,$terms,$taxonomies[0]);
}if ( $pad_counts && 'all' == $fields)
 _pad_term_counts($terms,$taxonomies[0]);
if ( $hierarchical && $hide_empty && is_array($terms))
 {foreach ( $terms as $k =>$term )
{if ( !$term->count)
 {$children = _get_term_children($term->term_id,$terms,$taxonomies[0]);
if ( is_array($children))
 foreach ( $children as $child  )
if ( $child->count)
 continue 2;
unset($terms[$k]);
}}}reset($terms);
$_terms = array();
if ( 'ids' == $fields)
 {while ( $term = array_shift($terms) )
$_terms[] = $term->term_id;
$terms = $_terms;
}elseif ( 'names' == $fields)
 {while ( $term = array_shift($terms) )
$_terms[] = $term->name;
$terms = $_terms;
}if ( 0 < $number && intval(@count($terms)) > $number)
 {$terms = array_slice($terms,$offset,$number);
}wp_cache_add($cache_key,$terms,'terms');
$terms = apply_filters('get_terms',$terms,$taxonomies,$args);
{$AspisRetTemp = &$terms;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function is_term ( $term,$taxonomy = '',$parent = 0 ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$select = "SELECT term_id FROM $wpdb->terms as t WHERE ";
$tax_select = "SELECT tt.term_id, tt.term_taxonomy_id FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy as tt ON tt.term_id = t.term_id WHERE ";
if ( is_int($term))
 {if ( 0 == $term)
 {$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$where = 't.term_id = %d';
if ( !empty($taxonomy))
 {$AspisRetTemp = $wpdb->get_row($wpdb->prepare($tax_select . $where . " AND tt.taxonomy = %s",$term,$taxonomy),ARRAY_A);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = $wpdb->get_var($wpdb->prepare($select . $where,$term));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}$term = trim(stripslashes($term));
if ( '' === $slug = sanitize_title($term))
 {$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$where = 't.slug = %s';
$else_where = 't.name = %s';
$where_fields = array($slug);
$else_where_fields = array($term);
if ( !empty($taxonomy))
 {$parent = (int)$parent;
if ( $parent > 0)
 {$where_fields[] = $parent;
$else_where_fields[] = $parent;
$where .= ' AND tt.parent = %d';
$else_where .= ' AND tt.parent = %d';
}$where_fields[] = $taxonomy;
$else_where_fields[] = $taxonomy;
if ( $result = $wpdb->get_row($wpdb->prepare("SELECT tt.term_id, tt.term_taxonomy_id FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy as tt ON tt.term_id = t.term_id WHERE $where AND tt.taxonomy = %s",$where_fields),ARRAY_A))
 {$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $wpdb->get_row($wpdb->prepare("SELECT tt.term_id, tt.term_taxonomy_id FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy as tt ON tt.term_id = t.term_id WHERE $else_where AND tt.taxonomy = %s",$else_where_fields),ARRAY_A);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}if ( $result = $wpdb->get_var($wpdb->prepare("SELECT term_id FROM $wpdb->terms as t WHERE $where",$where_fields)))
 {$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $wpdb->get_var($wpdb->prepare("SELECT term_id FROM $wpdb->terms as t WHERE $else_where",$else_where_fields));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function sanitize_term ( $term,$taxonomy,$context = 'display' ) {
if ( 'raw' == $context)
 {$AspisRetTemp = $term;
return $AspisRetTemp;
}$fields = array('term_id','name','description','slug','count','parent','term_group');
$do_object = false;
if ( is_object($term))
 $do_object = true;
$term_id = $do_object ? $term->term_id : (isset($term['term_id']) ? $term['term_id'] : 0);
foreach ( (array)$fields as $field  )
{if ( $do_object)
 {if ( isset($term->$field))
 $term->$field = sanitize_term_field($field,$term->$field,$term_id,$taxonomy,$context);
}else 
{{if ( isset($term[$field]))
 $term[$field] = sanitize_term_field($field,$term[$field],$term_id,$taxonomy,$context);
}}}if ( $do_object)
 $term->filter = $context;
else 
{$term['filter'] = $context;
}{$AspisRetTemp = $term;
return $AspisRetTemp;
} }
function sanitize_term_field ( $field,$value,$term_id,$taxonomy,$context ) {
if ( 'parent' == $field || 'term_id' == $field || 'count' == $field || 'term_group' == $field)
 {$value = (int)$value;
if ( $value < 0)
 $value = 0;
}if ( 'raw' == $context)
 {$AspisRetTemp = $value;
return $AspisRetTemp;
}if ( 'edit' == $context)
 {$value = apply_filters("edit_term_$field",$value,$term_id,$taxonomy);
$value = apply_filters("edit_${taxonomy}_$field",$value,$term_id);
if ( 'description' == $field)
 $value = format_to_edit($value);
else 
{$value = esc_attr($value);
}}else 
{if ( 'db' == $context)
 {$value = apply_filters("pre_term_$field",$value,$taxonomy);
$value = apply_filters("pre_${taxonomy}_$field",$value);
if ( 'slug' == $field)
 $value = apply_filters('pre_category_nicename',$value);
}else 
{if ( 'rss' == $context)
 {$value = apply_filters("term_${field}_rss",$value,$taxonomy);
$value = apply_filters("${taxonomy}_${field}_rss",$value);
}else 
{{$value = apply_filters("term_$field",$value,$term_id,$taxonomy,$context);
$value = apply_filters("${taxonomy}_$field",$value,$term_id,$context);
}}}}if ( 'attribute' == $context)
 $value = esc_attr($value);
else 
{if ( 'js' == $context)
 $value = esc_js($value);
}{$AspisRetTemp = $value;
return $AspisRetTemp;
} }
function wp_count_terms ( $taxonomy,$args = array() ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$defaults = array('ignore_empty' => false);
$args = wp_parse_args($args,$defaults);
extract(($args),EXTR_SKIP);
$where = '';
if ( $ignore_empty)
 $where = 'AND count > 0';
{$AspisRetTemp = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->term_taxonomy WHERE taxonomy = %s $where",$taxonomy));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_delete_object_term_relationships ( $object_id,$taxonomies ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$object_id = (int)$object_id;
if ( !is_array($taxonomies))
 $taxonomies = array($taxonomies);
foreach ( (array)$taxonomies as $taxonomy  )
{$tt_ids = wp_get_object_terms($object_id,$taxonomy,'fields=tt_ids');
$in_tt_ids = "'" . implode("', '",$tt_ids) . "'";
do_action('delete_term_relationships',$object_id,$tt_ids);
$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->term_relationships WHERE object_id = %d AND term_taxonomy_id IN ($in_tt_ids)",$object_id));
do_action('deleted_term_relationships',$object_id,$tt_ids);
wp_update_term_count($tt_ids,$taxonomy);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_delete_term ( $term,$taxonomy,$args = array() ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$term = (int)$term;
if ( !$ids = is_term($term,$taxonomy))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( is_wp_error($ids))
 {$AspisRetTemp = $ids;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$tt_id = $ids['term_taxonomy_id'];
$defaults = array();
$args = wp_parse_args($args,$defaults);
extract(($args),EXTR_SKIP);
if ( isset($default))
 {$default = (int)$default;
if ( !is_term($default,$taxonomy))
 unset($default);
}if ( is_taxonomy_hierarchical($taxonomy))
 {$term_obj = get_term($term,$taxonomy);
if ( is_wp_error($term_obj))
 {$AspisRetTemp = $term_obj;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$parent = $term_obj->parent;
$edit_tt_ids = $wpdb->get_col("SELECT `term_taxonomy_id` FROM $wpdb->term_taxonomy WHERE `parent` = " . (int)$term_obj->term_id);
do_action('edit_term_taxonomies',$edit_tt_ids);
$wpdb->update($wpdb->term_taxonomy,compact('parent'),array('parent' => $term_obj->term_id) + compact('taxonomy'));
do_action('edited_term_taxonomies',$edit_tt_ids);
}$objects = $wpdb->get_col($wpdb->prepare("SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d",$tt_id));
foreach ( (array)$objects as $object  )
{$terms = wp_get_object_terms($object,$taxonomy,array('fields' => 'ids','orderby' => 'none'));
if ( 1 == count($terms) && isset($default))
 {$terms = array($default);
}else 
{{$terms = array_diff($terms,array($term));
if ( isset($default) && isset($force_default) && $force_default)
 $terms = array_merge($terms,array($default));
}}$terms = array_map('intval',$terms);
wp_set_object_terms($object,$terms,$taxonomy);
}do_action('delete_term_taxonomy',$tt_id);
$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->term_taxonomy WHERE term_taxonomy_id = %d",$tt_id));
do_action('deleted_term_taxonomy',$tt_id);
if ( !$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->term_taxonomy WHERE term_id = %d",$term)))
 $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->terms WHERE term_id = %d",$term));
clean_term_cache($term,$taxonomy);
do_action('delete_term',$term,$tt_id,$taxonomy);
do_action("delete_$taxonomy",$term,$tt_id);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_get_object_terms ( $object_ids,$taxonomies,$args = array() ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !is_array($taxonomies))
 $taxonomies = array($taxonomies);
foreach ( (array)$taxonomies as $taxonomy  )
{if ( !is_taxonomy($taxonomy))
 {$AspisRetTemp = new WP_Error('invalid_taxonomy',__('Invalid Taxonomy'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}if ( !is_array($object_ids))
 $object_ids = array($object_ids);
$object_ids = array_map('intval',$object_ids);
$defaults = array('orderby' => 'name','order' => 'ASC','fields' => 'all');
$args = wp_parse_args($args,$defaults);
$terms = array();
if ( count($taxonomies) > 1)
 {foreach ( $taxonomies as $index =>$taxonomy )
{$t = get_taxonomy($taxonomy);
if ( isset($t->args) && is_array($t->args) && $args != array_merge($args,$t->args))
 {unset($taxonomies[$index]);
$terms = array_merge($terms,wp_get_object_terms($object_ids,$taxonomy,array_merge($args,$t->args)));
}}}else 
{{$t = get_taxonomy($taxonomies[0]);
if ( isset($t->args) && is_array($t->args))
 $args = array_merge($args,$t->args);
}}extract(($args),EXTR_SKIP);
if ( 'count' == $orderby)
 $orderby = 'tt.count';
else 
{if ( 'name' == $orderby)
 $orderby = 't.name';
else 
{if ( 'slug' == $orderby)
 $orderby = 't.slug';
else 
{if ( 'term_group' == $orderby)
 $orderby = 't.term_group';
else 
{if ( 'term_order' == $orderby)
 $orderby = 'tr.term_order';
else 
{if ( 'none' == $orderby)
 {$orderby = '';
$order = '';
}else 
{{$orderby = 't.term_id';
}}}}}}}if ( ('tt_ids' == $fields) && !empty($orderby))
 $orderby = 'tr.term_taxonomy_id';
if ( !empty($orderby))
 $orderby = "ORDER BY $orderby";
$taxonomies = "'" . implode("', '",$taxonomies) . "'";
$object_ids = implode(', ',$object_ids);
$select_this = '';
if ( 'all' == $fields)
 $select_this = 't.*, tt.*';
else 
{if ( 'ids' == $fields)
 $select_this = 't.term_id';
else 
{if ( 'names' == $fields)
 $select_this = 't.name';
else 
{if ( 'all_with_object_id' == $fields)
 $select_this = 't.*, tt.*, tr.object_id';
}}}$query = "SELECT $select_this FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id INNER JOIN $wpdb->term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tt.taxonomy IN ($taxonomies) AND tr.object_id IN ($object_ids) $orderby $order";
if ( 'all' == $fields || 'all_with_object_id' == $fields)
 {$terms = array_merge($terms,$wpdb->get_results($query));
update_term_cache($terms);
}else 
{if ( 'ids' == $fields || 'names' == $fields)
 {$terms = array_merge($terms,$wpdb->get_col($query));
}else 
{if ( 'tt_ids' == $fields)
 {$terms = $wpdb->get_col("SELECT tr.term_taxonomy_id FROM $wpdb->term_relationships AS tr INNER JOIN $wpdb->term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tr.object_id IN ($object_ids) AND tt.taxonomy IN ($taxonomies) $orderby $order");
}}}if ( !$terms)
 $terms = array();
{$AspisRetTemp = apply_filters('wp_get_object_terms',$terms,$object_ids,$taxonomies,$args);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_insert_term ( $term,$taxonomy,$args = array() ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !is_taxonomy($taxonomy))
 {$AspisRetTemp = new WP_Error('invalid_taxonomy',__('Invalid taxonomy'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( is_int($term) && 0 == $term)
 {$AspisRetTemp = new WP_Error('invalid_term_id',__('Invalid term ID'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( '' == trim($term))
 {$AspisRetTemp = new WP_Error('empty_term_name',__('A name is required for this term'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$defaults = array('alias_of' => '','description' => '','parent' => 0,'slug' => '');
$args = wp_parse_args($args,$defaults);
$args['name'] = $term;
$args['taxonomy'] = $taxonomy;
$args = sanitize_term($args,$taxonomy,'db');
extract(($args),EXTR_SKIP);
$name = stripslashes($name);
$description = stripslashes($description);
if ( empty($slug))
 $slug = sanitize_title($name);
$term_group = 0;
if ( $alias_of)
 {$alias = $wpdb->get_row($wpdb->prepare("SELECT term_id, term_group FROM $wpdb->terms WHERE slug = %s",$alias_of));
if ( $alias->term_group)
 {$term_group = $alias->term_group;
}else 
{{$term_group = $wpdb->get_var("SELECT MAX(term_group) FROM $wpdb->terms") + 1;
do_action('edit_terms',$alias->term_id);
$wpdb->update($wpdb->terms,compact('term_group'),array('term_id' => $alias->term_id));
do_action('edited_terms',$alias->term_id);
}}}if ( !$term_id = is_term($slug))
 {if ( false === $wpdb->insert($wpdb->terms,compact('name','slug','term_group')))
 {$AspisRetTemp = new WP_Error('db_insert_error',__('Could not insert term into the database'),$wpdb->last_error);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$term_id = (int)$wpdb->insert_id;
}else 
{if ( is_taxonomy_hierarchical($taxonomy) && !empty($parent))
 {$slug = wp_unique_term_slug($slug,(object)$args);
if ( false === $wpdb->insert($wpdb->terms,compact('name','slug','term_group')))
 {$AspisRetTemp = new WP_Error('db_insert_error',__('Could not insert term into the database'),$wpdb->last_error);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$term_id = (int)$wpdb->insert_id;
}}if ( empty($slug))
 {$slug = sanitize_title($slug,$term_id);
do_action('edit_terms',$term_id);
$wpdb->update($wpdb->terms,compact('slug'),compact('term_id'));
do_action('edited_terms',$term_id);
}$tt_id = $wpdb->get_var($wpdb->prepare("SELECT tt.term_taxonomy_id FROM $wpdb->term_taxonomy AS tt INNER JOIN $wpdb->terms AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = %s AND t.term_id = %d",$taxonomy,$term_id));
if ( !empty($tt_id))
 {$AspisRetTemp = array('term_id' => $term_id,'term_taxonomy_id' => $tt_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$wpdb->insert($wpdb->term_taxonomy,compact('term_id','taxonomy','description','parent') + array('count' => 0));
$tt_id = (int)$wpdb->insert_id;
do_action("create_term",$term_id,$tt_id,$taxonomy);
do_action("create_$taxonomy",$term_id,$tt_id);
$term_id = apply_filters('term_id_filter',$term_id,$tt_id);
clean_term_cache($term_id,$taxonomy);
do_action("created_term",$term_id,$tt_id,$taxonomy);
do_action("created_$taxonomy",$term_id,$tt_id);
{$AspisRetTemp = array('term_id' => $term_id,'term_taxonomy_id' => $tt_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_set_object_terms ( $object_id,$terms,$taxonomy,$append = false ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$object_id = (int)$object_id;
if ( !is_taxonomy($taxonomy))
 {$AspisRetTemp = new WP_Error('invalid_taxonomy',__('Invalid Taxonomy'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( !is_array($terms))
 $terms = array($terms);
if ( !$append)
 $old_tt_ids = wp_get_object_terms($object_id,$taxonomy,array('fields' => 'tt_ids','orderby' => 'none'));
$tt_ids = array();
$term_ids = array();
foreach ( (array)$terms as $term  )
{if ( !strlen(trim($term)))
 continue ;
if ( !$term_info = is_term($term,$taxonomy))
 $term_info = wp_insert_term($term,$taxonomy);
if ( is_wp_error($term_info))
 {$AspisRetTemp = $term_info;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$term_ids[] = $term_info['term_id'];
$tt_id = $term_info['term_taxonomy_id'];
$tt_ids[] = $tt_id;
if ( $wpdb->get_var($wpdb->prepare("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = %d AND term_taxonomy_id = %d",$object_id,$tt_id)))
 continue ;
do_action('add_term_relationship',$object_id,$tt_id);
$wpdb->insert($wpdb->term_relationships,array('object_id' => $object_id,'term_taxonomy_id' => $tt_id));
do_action('added_term_relationship',$object_id,$tt_id);
}wp_update_term_count($tt_ids,$taxonomy);
if ( !$append)
 {$delete_terms = array_diff($old_tt_ids,$tt_ids);
if ( $delete_terms)
 {$in_delete_terms = "'" . implode("', '",$delete_terms) . "'";
do_action('delete_term_relationships',$object_id,$delete_terms);
$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->term_relationships WHERE object_id = %d AND term_taxonomy_id IN ($in_delete_terms)",$object_id));
do_action('deleted_term_relationships',$object_id,$delete_terms);
wp_update_term_count($delete_terms,$taxonomy);
}}$t = get_taxonomy($taxonomy);
if ( !$append && isset($t->sort) && $t->sort)
 {$values = array();
$term_order = 0;
$final_tt_ids = wp_get_object_terms($object_id,$taxonomy,'fields=tt_ids');
foreach ( $tt_ids as $tt_id  )
if ( in_array($tt_id,$final_tt_ids))
 $values[] = $wpdb->prepare("(%d, %d, %d)",$object_id,$tt_id,++$term_order);
if ( $values)
 $wpdb->query("INSERT INTO $wpdb->term_relationships (object_id, term_taxonomy_id, term_order) VALUES " . join(',',$values) . " ON DUPLICATE KEY UPDATE term_order = VALUES(term_order)");
}do_action('set_object_terms',$object_id,$terms,$tt_ids,$taxonomy,$append,$old_tt_ids);
{$AspisRetTemp = $tt_ids;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_unique_term_slug ( $slug,$term ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( is_taxonomy_hierarchical($term->taxonomy) && !empty($term->parent))
 {$the_parent = $term->parent;
while ( !empty($the_parent) )
{$parent_term = get_term($the_parent,$term->taxonomy);
if ( is_wp_error($parent_term) || empty($parent_term))
 break ;
$slug .= '-' . $parent_term->slug;
if ( empty($parent_term->parent))
 break ;
$the_parent = $parent_term->parent;
}}if ( !empty($args['term_id']))
 $query = $wpdb->prepare("SELECT slug FROM $wpdb->terms WHERE slug = %s AND term_id != %d",$slug,$args['term_id']);
else 
{$query = $wpdb->prepare("SELECT slug FROM $wpdb->terms WHERE slug = %s",$slug);
}if ( $wpdb->get_var($query))
 {$num = 2;
do {$alt_slug = $slug . "-$num";
$num++;
$slug_check = $wpdb->get_var($wpdb->prepare("SELECT slug FROM $wpdb->terms WHERE slug = %s",$alt_slug));
}while ($slug_check )
;
$slug = $alt_slug;
}{$AspisRetTemp = $slug;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_update_term ( $term_id,$taxonomy,$args = array() ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !is_taxonomy($taxonomy))
 {$AspisRetTemp = new WP_Error('invalid_taxonomy',__('Invalid taxonomy'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$term_id = (int)$term_id;
$term = get_term($term_id,$taxonomy,ARRAY_A);
if ( is_wp_error($term))
 {$AspisRetTemp = $term;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$term = deAspisWarningRC(add_magic_quotes(attAspisRCO($term)));
$args = array_merge($term,$args);
$defaults = array('alias_of' => '','description' => '','parent' => 0,'slug' => '');
$args = wp_parse_args($args,$defaults);
$args = sanitize_term($args,$taxonomy,'db');
extract(($args),EXTR_SKIP);
$name = stripslashes($name);
$description = stripslashes($description);
if ( '' == trim($name))
 {$AspisRetTemp = new WP_Error('empty_term_name',__('A name is required for this term'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$empty_slug = false;
if ( empty($slug))
 {$empty_slug = true;
$slug = sanitize_title($name);
}if ( $alias_of)
 {$alias = $wpdb->get_row($wpdb->prepare("SELECT term_id, term_group FROM $wpdb->terms WHERE slug = %s",$alias_of));
if ( $alias->term_group)
 {$term_group = $alias->term_group;
}else 
{{$term_group = $wpdb->get_var("SELECT MAX(term_group) FROM $wpdb->terms") + 1;
do_action('edit_terms',$alias->term_id);
$wpdb->update($wpdb->terms,compact('term_group'),array('term_id' => $alias->term_id));
do_action('edited_terms',$alias->term_id);
}}}$id = $wpdb->get_var($wpdb->prepare("SELECT term_id FROM $wpdb->terms WHERE slug = %s",$slug));
if ( $id && ($id != $term_id))
 {if ( $empty_slug || ($parent != $term->parent))
 $slug = wp_unique_term_slug($slug,(object)$args);
else 
{{$AspisRetTemp = new WP_Error('duplicate_term_slug',sprintf(__('The slug &#8220;%s&#8221; is already in use by another term'),$slug));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}do_action('edit_terms',$term_id);
$wpdb->update($wpdb->terms,compact('name','slug','term_group'),compact('term_id'));
if ( empty($slug))
 {$slug = sanitize_title($name,$term_id);
$wpdb->update($wpdb->terms,compact('slug'),compact('term_id'));
}do_action('edited_terms',$term_id);
$tt_id = $wpdb->get_var($wpdb->prepare("SELECT tt.term_taxonomy_id FROM $wpdb->term_taxonomy AS tt INNER JOIN $wpdb->terms AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = %s AND t.term_id = %d",$taxonomy,$term_id));
do_action('edit_term_taxonomy',$tt_id);
$wpdb->update($wpdb->term_taxonomy,compact('term_id','taxonomy','description','parent'),array('term_taxonomy_id' => $tt_id));
do_action('edited_term_taxonomy',$tt_id);
do_action("edit_term",$term_id,$tt_id,$taxonomy);
do_action("edit_$taxonomy",$term_id,$tt_id);
$term_id = apply_filters('term_id_filter',$term_id,$tt_id);
clean_term_cache($term_id,$taxonomy);
do_action("edited_term",$term_id,$tt_id,$taxonomy);
do_action("edited_$taxonomy",$term_id,$tt_id);
{$AspisRetTemp = array('term_id' => $term_id,'term_taxonomy_id' => $tt_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_defer_term_counting ( $defer = null ) {
static $_defer = false;
if ( is_bool($defer))
 {$_defer = $defer;
if ( !$defer)
 wp_update_term_count(null,null,true);
}{$AspisRetTemp = $_defer;
return $AspisRetTemp;
} }
function wp_update_term_count ( $terms,$taxonomy,$do_deferred = false ) {
static $_deferred = array();
if ( $do_deferred)
 {foreach ( (array)array_keys($_deferred) as $tax  )
{wp_update_term_count_now($_deferred[$tax],$tax);
unset($_deferred[$tax]);
}}if ( empty($terms))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !is_array($terms))
 $terms = array($terms);
if ( wp_defer_term_counting())
 {if ( !isset($_deferred[$taxonomy]))
 $_deferred[$taxonomy] = array();
$_deferred[$taxonomy] = array_unique(array_merge($_deferred[$taxonomy],$terms));
{$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = wp_update_term_count_now($terms,$taxonomy);
return $AspisRetTemp;
} }
function wp_update_term_count_now ( $terms,$taxonomy ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$terms = array_map('intval',$terms);
$taxonomy = get_taxonomy($taxonomy);
if ( !empty($taxonomy->update_count_callback))
 {AspisUntainted_call_user_func($taxonomy->update_count_callback,$terms);
}else 
{{foreach ( (array)$terms as $term  )
{$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d",$term));
do_action('edit_term_taxonomy',$term);
$wpdb->update($wpdb->term_taxonomy,compact('count'),array('term_taxonomy_id' => $term));
do_action('edited_term_taxonomy',$term);
}}}clean_term_cache($terms);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function clean_object_term_cache ( $object_ids,$object_type ) {
if ( !is_array($object_ids))
 $object_ids = array($object_ids);
foreach ( $object_ids as $id  )
foreach ( get_object_taxonomies($object_type) as $taxonomy  )
wp_cache_delete($id,"{$taxonomy}_relationships");
do_action('clean_object_term_cache',$object_ids,$object_type);
 }
function clean_term_cache ( $ids,$taxonomy = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}static $cleaned = array();
if ( !is_array($ids))
 $ids = array($ids);
$taxonomies = array();
if ( empty($taxonomy))
 {$tt_ids = implode(', ',$ids);
$terms = $wpdb->get_results("SELECT term_id, taxonomy FROM $wpdb->term_taxonomy WHERE term_taxonomy_id IN ($tt_ids)");
foreach ( (array)$terms as $term  )
{$taxonomies[] = $term->taxonomy;
wp_cache_delete($term->term_id,$term->taxonomy);
}$taxonomies = array_unique($taxonomies);
}else 
{{foreach ( $ids as $id  )
{wp_cache_delete($id,$taxonomy);
}$taxonomies = array($taxonomy);
}}foreach ( $taxonomies as $taxonomy  )
{if ( isset($cleaned[$taxonomy]))
 continue ;
$cleaned[$taxonomy] = true;
wp_cache_delete('all_ids',$taxonomy);
wp_cache_delete('get',$taxonomy);
delete_option("{$taxonomy}_children");
}wp_cache_set('last_changed',time(),'terms');
do_action('clean_term_cache',$ids,$taxonomy);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function &get_object_term_cache ( $id,$taxonomy ) {
$cache = wp_cache_get($id,"{$taxonomy}_relationships");
{$AspisRetTemp = &$cache;
return $AspisRetTemp;
} }
function update_object_term_cache ( $object_ids,$object_type ) {
if ( empty($object_ids))
 {return ;
}if ( !is_array($object_ids))
 $object_ids = explode(',',$object_ids);
$object_ids = array_map('intval',$object_ids);
$taxonomies = get_object_taxonomies($object_type);
$ids = array();
foreach ( (array)$object_ids as $id  )
{foreach ( $taxonomies as $taxonomy  )
{if ( false === wp_cache_get($id,"{$taxonomy}_relationships"))
 {$ids[] = $id;
break ;
}}}if ( empty($ids))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$terms = wp_get_object_terms($ids,$taxonomies,'fields=all_with_object_id');
$object_terms = array();
foreach ( (array)$terms as $term  )
$object_terms[$term->object_id][$term->taxonomy][$term->term_id] = $term;
foreach ( $ids as $id  )
{foreach ( $taxonomies as $taxonomy  )
{if ( !isset($object_terms[$id][$taxonomy]))
 {if ( !isset($object_terms[$id]))
 $object_terms[$id] = array();
$object_terms[$id][$taxonomy] = array();
}}}foreach ( $object_terms as $id =>$value )
{foreach ( $value as $taxonomy =>$terms )
{wp_cache_set($id,$terms,"{$taxonomy}_relationships");
}} }
function update_term_cache ( $terms,$taxonomy = '' ) {
foreach ( (array)$terms as $term  )
{$term_taxonomy = $taxonomy;
if ( empty($term_taxonomy))
 $term_taxonomy = $term->taxonomy;
wp_cache_add($term->term_id,$term,$term_taxonomy);
} }
function _get_term_hierarchy ( $taxonomy ) {
if ( !is_taxonomy_hierarchical($taxonomy))
 {$AspisRetTemp = array();
return $AspisRetTemp;
}$children = get_option("{$taxonomy}_children");
if ( is_array($children))
 {$AspisRetTemp = $children;
return $AspisRetTemp;
}$children = array();
$terms = get_terms($taxonomy,'get=all');
foreach ( $terms as $term  )
{if ( $term->parent > 0)
 $children[$term->parent][] = $term->term_id;
}update_option("{$taxonomy}_children",$children);
{$AspisRetTemp = $children;
return $AspisRetTemp;
} }
function &_get_term_children ( $term_id,$terms,$taxonomy ) {
$empty_array = array();
if ( empty($terms))
 {$AspisRetTemp = &$empty_array;
return $AspisRetTemp;
}$term_list = array();
$has_children = _get_term_hierarchy($taxonomy);
if ( (0 != $term_id) && !isset($has_children[$term_id]))
 {$AspisRetTemp = &$empty_array;
return $AspisRetTemp;
}foreach ( (array)$terms as $term  )
{$use_id = false;
if ( !is_object($term))
 {$term = get_term($term,$taxonomy);
if ( is_wp_error($term))
 {$AspisRetTemp = &$term;
return $AspisRetTemp;
}$use_id = true;
}if ( $term->term_id == $term_id)
 continue ;
if ( $term->parent == $term_id)
 {if ( $use_id)
 $term_list[] = $term->term_id;
else 
{$term_list[] = $term;
}if ( !isset($has_children[$term->term_id]))
 continue ;
if ( $children = _get_term_children($term->term_id,$terms,$taxonomy))
 $term_list = array_merge($term_list,$children);
}}{$AspisRetTemp = &$term_list;
return $AspisRetTemp;
} }
function _pad_term_counts ( &$terms,$taxonomy ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !is_taxonomy_hierarchical($taxonomy))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$term_hier = _get_term_hierarchy($taxonomy);
if ( empty($term_hier))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$term_items = array();
foreach ( (array)$terms as $key =>$term )
{$terms_by_id[$term->term_id] = &$terms[$key];
$term_ids[$term->term_taxonomy_id] = $term->term_id;
}$results = $wpdb->get_results("SELECT object_id, term_taxonomy_id FROM $wpdb->term_relationships INNER JOIN $wpdb->posts ON object_id = ID WHERE term_taxonomy_id IN (" . join(',',array_keys($term_ids)) . ") AND post_type = 'post' AND post_status = 'publish'");
foreach ( $results as $row  )
{$id = $term_ids[$row->term_taxonomy_id];
$term_items[$id][$row->object_id] = isset($term_items[$id][$row->object_id]) ? ++$term_items[$id][$row->object_id] : 1;
}foreach ( $term_ids as $term_id  )
{$child = $term_id;
while ( $parent = $terms_by_id[$child]->parent )
{if ( !empty($term_items[$term_id]))
 foreach ( $term_items[$term_id] as $item_id =>$touches )
{$term_items[$parent][$item_id] = isset($term_items[$parent][$item_id]) ? ++$term_items[$parent][$item_id] : 1;
}$child = $parent;
}}foreach ( (array)$term_items as $id =>$items )
if ( isset($terms_by_id[$id]))
 $terms_by_id[$id]->count = count($items);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function _update_post_term_count ( $terms ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}foreach ( (array)$terms as $term  )
{$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->term_relationships, $wpdb->posts WHERE $wpdb->posts.ID = $wpdb->term_relationships.object_id AND post_status = 'publish' AND post_type = 'post' AND term_taxonomy_id = %d",$term));
do_action('edit_term_taxonomy',$term);
$wpdb->update($wpdb->term_taxonomy,compact('count'),array('term_taxonomy_id' => $term));
do_action('edited_term_taxonomy',$term);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_term_link ( $term,$taxonomy ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}if ( !is_object($term))
 {if ( is_int($term))
 {$term = &get_term($term,$taxonomy);
}else 
{{$term = &get_term_by('slug',$term,$taxonomy);
}}}if ( is_wp_error($term))
 {$AspisRetTemp = $term;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}if ( $taxonomy == 'category')
 {$AspisRetTemp = get_category_link((int)$term->term_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}if ( $taxonomy == 'post_tag')
 {$AspisRetTemp = get_tag_link((int)$term->term_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}$termlink = $wp_rewrite->get_extra_permastruct($taxonomy);
$slug = $term->slug;
if ( empty($termlink))
 {$file = trailingslashit(get_option('home'));
$t = get_taxonomy($taxonomy);
if ( $t->query_var)
 $termlink = "$file?$t->query_var=$slug";
else 
{$termlink = "$file?taxonomy=$taxonomy&term=$slug";
}}else 
{{$termlink = str_replace("%$taxonomy%",$slug,$termlink);
$termlink = get_option('home') . user_trailingslashit($termlink,'category');
}}{$AspisRetTemp = apply_filters('term_link',$termlink,$term,$taxonomy);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function the_taxonomies ( $args = array() ) {
$defaults = array('post' => 0,'before' => '','sep' => ' ','after' => '',);
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
echo $before . join($sep,get_the_taxonomies($post)) . $after;
 }
function get_the_taxonomies ( $post = 0 ) {
if ( is_int($post))
 $post = &get_post($post);
elseif ( !is_object($post))
 $post = &$GLOBALS[0]['post'];
$taxonomies = array();
if ( !$post)
 {$AspisRetTemp = $taxonomies;
return $AspisRetTemp;
}$template = apply_filters('taxonomy_template','%s: %l.');
foreach ( get_object_taxonomies($post) as $taxonomy  )
{$t = (array)get_taxonomy($taxonomy);
if ( empty($t['label']))
 $t['label'] = $taxonomy;
if ( empty($t['args']))
 $t['args'] = array();
if ( empty($t['template']))
 $t['template'] = $template;
$terms = get_object_term_cache($post->ID,$taxonomy);
if ( empty($terms))
 $terms = wp_get_object_terms($post->ID,$taxonomy,$t['args']);
$links = array();
foreach ( $terms as $term  )
$links[] = "<a href='" . esc_attr(get_term_link($term,$taxonomy)) . "'>$term->name</a>";
if ( $links)
 $taxonomies[$taxonomy] = wp_sprintf($t['template'],$t['label'],$links,$terms);
}{$AspisRetTemp = $taxonomies;
return $AspisRetTemp;
} }
function get_post_taxonomies ( $post = 0 ) {
$post = &get_post($post);
{$AspisRetTemp = get_object_taxonomies($post);
return $AspisRetTemp;
} }
function is_object_in_term ( $object_id,$taxonomy,$terms = null ) {
if ( !$object_id = (int)$object_id)
 {$AspisRetTemp = new WP_Error('invalid_object',__('Invalid object ID'));
return $AspisRetTemp;
}$object_terms = get_object_term_cache($object_id,$taxonomy);
if ( empty($object_terms))
 $object_terms = wp_get_object_terms($object_id,$taxonomy);
if ( is_wp_error($object_terms))
 {$AspisRetTemp = $object_terms;
return $AspisRetTemp;
}if ( empty($object_terms))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( empty($terms))
 {$AspisRetTemp = (!empty($object_terms));
return $AspisRetTemp;
}$terms = (array)$terms;
if ( $ints = array_filter($terms,'is_int'))
 $strs = array_diff($terms,$ints);
else 
{$strs = &$terms;
}foreach ( $object_terms as $object_term  )
{if ( $ints && in_array($object_term->term_id,$ints))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}if ( $strs)
 {if ( in_array($object_term->term_id,$strs))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}if ( in_array($object_term->name,$strs))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}if ( in_array($object_term->slug,$strs))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
;
?>
<?php 