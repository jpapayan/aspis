<?php require_once('AspisMain.php'); ?><?php
function get_bookmark ( $bookmark,$output = OBJECT,$filter = 'raw' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( empty($bookmark))
 {if ( isset($GLOBALS[0]['link']))
 $_bookmark = &$GLOBALS[0]['link'];
else 
{$_bookmark = null;
}}elseif ( is_object($bookmark))
 {wp_cache_add($bookmark->link_id,$bookmark,'bookmark');
$_bookmark = $bookmark;
}else 
{{if ( isset($GLOBALS[0]['link']) && ($GLOBALS[0]['link']->link_id == $bookmark))
 {$_bookmark = &$GLOBALS[0]['link'];
}elseif ( !$_bookmark = wp_cache_get($bookmark,'bookmark'))
 {$_bookmark = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->links WHERE link_id = %d LIMIT 1",$bookmark));
$_bookmark->link_category = array_unique(wp_get_object_terms($_bookmark->link_id,'link_category','fields=ids'));
wp_cache_add($_bookmark->link_id,$_bookmark,'bookmark');
}}}$_bookmark = sanitize_bookmark($_bookmark,$filter);
if ( $output == OBJECT)
 {{$AspisRetTemp = $_bookmark;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( $output == ARRAY_A)
 {{$AspisRetTemp = get_object_vars($_bookmark);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( $output == ARRAY_N)
 {{$AspisRetTemp = array_values(get_object_vars($_bookmark));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = $_bookmark;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_bookmark_field ( $field,$bookmark,$context = 'display' ) {
$bookmark = (int)$bookmark;
$bookmark = get_bookmark($bookmark);
if ( is_wp_error($bookmark))
 {$AspisRetTemp = $bookmark;
return $AspisRetTemp;
}if ( !is_object($bookmark))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}if ( !isset($bookmark->$field))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = sanitize_bookmark_field($field,$bookmark->$field,$bookmark->link_id,$context);
return $AspisRetTemp;
} }
function get_link ( $bookmark_id,$output = OBJECT,$filter = 'raw' ) {
{$AspisRetTemp = get_bookmark($bookmark_id,$output,$filter);
return $AspisRetTemp;
} }
function get_bookmarks ( $args = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$defaults = array('orderby' => 'name','order' => 'ASC','limit' => -1,'category' => '','category_name' => '','hide_invisible' => 1,'show_updated' => 0,'include' => '','exclude' => '','search' => '');
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
$cache = array();
$key = md5(serialize($r));
if ( $cache = wp_cache_get('get_bookmarks','bookmark'))
 {if ( is_array($cache) && isset($cache[$key]))
 {$AspisRetTemp = apply_filters('get_bookmarks',$cache[$key],$r);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}if ( !is_array($cache))
 $cache = array();
$inclusions = '';
if ( !empty($include))
 {$exclude = '';
$category = '';
$category_name = '';
$inclinks = preg_split('/[\s,]+/',$include);
if ( count($inclinks))
 {foreach ( $inclinks as $inclink  )
{if ( empty($inclusions))
 $inclusions = ' AND ( link_id = ' . intval($inclink) . ' ';
else 
{$inclusions .= ' OR link_id = ' . intval($inclink) . ' ';
}}}}if ( !empty($inclusions))
 $inclusions .= ')';
$exclusions = '';
if ( !empty($exclude))
 {$exlinks = preg_split('/[\s,]+/',$exclude);
if ( count($exlinks))
 {foreach ( $exlinks as $exlink  )
{if ( empty($exclusions))
 $exclusions = ' AND ( link_id <> ' . intval($exlink) . ' ';
else 
{$exclusions .= ' AND link_id <> ' . intval($exlink) . ' ';
}}}}if ( !empty($exclusions))
 $exclusions .= ')';
if ( !empty($category_name))
 {if ( $category = get_term_by('name',$category_name,'link_category'))
 {$category = $category->term_id;
}else 
{{$cache[$key] = array();
wp_cache_set('get_bookmarks',$cache,'bookmark');
{$AspisRetTemp = apply_filters('get_bookmarks',array(),$r);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}}if ( !empty($search))
 {$search = like_escape($search);
$search = " AND ( (link_url LIKE '%$search%') OR (link_name LIKE '%$search%') OR (link_description LIKE '%$search%') ) ";
}$category_query = '';
$join = '';
if ( !empty($category))
 {$incategories = preg_split('/[\s,]+/',$category);
if ( count($incategories))
 {foreach ( $incategories as $incat  )
{if ( empty($category_query))
 $category_query = ' AND ( tt.term_id = ' . intval($incat) . ' ';
else 
{$category_query .= ' OR tt.term_id = ' . intval($incat) . ' ';
}}}}if ( !empty($category_query))
 {$category_query .= ") AND taxonomy = 'link_category'";
$join = " INNER JOIN $wpdb->term_relationships AS tr ON ($wpdb->links.link_id = tr.object_id) INNER JOIN $wpdb->term_taxonomy as tt ON tt.term_taxonomy_id = tr.term_taxonomy_id";
}if ( $show_updated && get_option('links_recently_updated_time'))
 {$recently_updated_test = ", IF (DATE_ADD(link_updated, INTERVAL " . get_option('links_recently_updated_time') . " MINUTE) >= NOW(), 1,0) as recently_updated ";
}else 
{{$recently_updated_test = '';
}}$get_updated = ($show_updated) ? ', UNIX_TIMESTAMP(link_updated) AS link_updated_f ' : '';
$orderby = strtolower($orderby);
$length = '';
switch ( $orderby ) {
case 'length':$length = ", CHAR_LENGTH(link_name) AS length";
break ;
case 'rand':$orderby = 'rand()';
break ;
default :$orderby = "link_" . $orderby;
 }
if ( 'link_id' == $orderby)
 $orderby = "$wpdb->links.link_id";
$visible = '';
if ( $hide_invisible)
 $visible = "AND link_visible = 'Y'";
$query = "SELECT * $length $recently_updated_test $get_updated FROM $wpdb->links $join WHERE 1=1 $visible $category_query";
$query .= " $exclusions $inclusions $search";
$query .= " ORDER BY $orderby $order";
if ( $limit != -1)
 $query .= " LIMIT $limit";
$results = $wpdb->get_results($query);
$cache[$key] = $results;
wp_cache_set('get_bookmarks',$cache,'bookmark');
{$AspisRetTemp = apply_filters('get_bookmarks',$results,$r);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function sanitize_bookmark ( $bookmark,$context = 'display' ) {
$fields = array('link_id','link_url','link_name','link_image','link_target','link_category','link_description','link_visible','link_owner','link_rating','link_updated','link_rel','link_notes','link_rss',);
if ( is_object($bookmark))
 {$do_object = true;
$link_id = $bookmark->link_id;
}else 
{{$do_object = false;
$link_id = $bookmark['link_id'];
}}foreach ( $fields as $field  )
{if ( $do_object)
 {if ( isset($bookmark->$field))
 $bookmark->$field = sanitize_bookmark_field($field,$bookmark->$field,$link_id,$context);
}else 
{{if ( isset($bookmark[$field]))
 $bookmark[$field] = sanitize_bookmark_field($field,$bookmark[$field],$link_id,$context);
}}}{$AspisRetTemp = $bookmark;
return $AspisRetTemp;
} }
function sanitize_bookmark_field ( $field,$value,$bookmark_id,$context ) {
$int_fields = array('link_id','link_rating');
if ( in_array($field,$int_fields))
 $value = (int)$value;
$yesno = array('link_visible');
if ( in_array($field,$yesno))
 $value = preg_replace('/[^YNyn]/','',$value);
if ( 'link_target' == $field)
 {$targets = array('_top','_blank');
if ( !in_array($value,$targets))
 $value = '';
}if ( 'raw' == $context)
 {$AspisRetTemp = $value;
return $AspisRetTemp;
}if ( 'edit' == $context)
 {$format_to_edit = array('link_notes');
$value = apply_filters("edit_$field",$value,$bookmark_id);
if ( in_array($field,$format_to_edit))
 {$value = format_to_edit($value);
}else 
{{$value = esc_attr($value);
}}}else 
{if ( 'db' == $context)
 {$value = apply_filters("pre_$field",$value);
}else 
{{$value = apply_filters($field,$value,$bookmark_id,$context);
}}}if ( 'attribute' == $context)
 $value = esc_attr($value);
else 
{if ( 'js' == $context)
 $value = esc_js($value);
}{$AspisRetTemp = $value;
return $AspisRetTemp;
} }
function clean_bookmark_cache ( $bookmark_id ) {
wp_cache_delete($bookmark_id,'bookmark');
wp_cache_delete('get_bookmarks','bookmark');
 }
;
?>
<?php 