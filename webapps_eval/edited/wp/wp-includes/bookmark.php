<?php require_once('AspisMain.php'); ?><?php
function get_bookmark ( $bookmark,$output = array(OBJECT,false),$filter = array('raw',false) ) {
global $wpdb;
if ( ((empty($bookmark) || Aspis_empty( $bookmark))))
 {if ( ((isset($GLOBALS[0][('link')]) && Aspis_isset( $GLOBALS [0][('link')]))))
 $_bookmark = &$GLOBALS[0][('link')];
else 
{$_bookmark = array(null,false);
}}elseif ( is_object($bookmark[0]))
 {wp_cache_add($bookmark[0]->link_id,$bookmark,array('bookmark',false));
$_bookmark = $bookmark;
}else 
{{if ( (((isset($GLOBALS[0][('link')]) && Aspis_isset( $GLOBALS [0][('link')]))) && ($GLOBALS[0][('link')][0]->link_id[0] == $bookmark[0])))
 {$_bookmark = &$GLOBALS[0][('link')];
}elseif ( (denot_boolean($_bookmark = wp_cache_get($bookmark,array('bookmark',false)))))
 {$_bookmark = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->links)," WHERE link_id = %d LIMIT 1"),$bookmark));
$_bookmark[0]->link_category = attAspisRC(array_unique(deAspisRC(wp_get_object_terms($_bookmark[0]->link_id,array('link_category',false),array('fields=ids',false)))));
wp_cache_add($_bookmark[0]->link_id,$_bookmark,array('bookmark',false));
}}}$_bookmark = sanitize_bookmark($_bookmark,$filter);
if ( ($output[0] == OBJECT))
 {return $_bookmark;
}elseif ( ($output[0] == ARRAY_A))
 {return attAspis(get_object_vars(deAspisRC($_bookmark)));
}elseif ( ($output[0] == ARRAY_N))
 {return Aspis_array_values(attAspis(get_object_vars(deAspisRC($_bookmark))));
}else 
{{return $_bookmark;
}} }
function get_bookmark_field ( $field,$bookmark,$context = array('display',false) ) {
$bookmark = int_cast($bookmark);
$bookmark = get_bookmark($bookmark);
if ( deAspis(is_wp_error($bookmark)))
 return $bookmark;
if ( (!(is_object($bookmark[0]))))
 return array('',false);
if ( (!((isset($bookmark[0]->$field[0]) && Aspis_isset( $bookmark[0] ->$field[0] )))))
 return array('',false);
return sanitize_bookmark_field($field,$bookmark[0]->$field[0],$bookmark[0]->link_id,$context);
 }
function get_link ( $bookmark_id,$output = array(OBJECT,false),$filter = array('raw',false) ) {
return get_bookmark($bookmark_id,$output,$filter);
 }
function get_bookmarks ( $args = array('',false) ) {
global $wpdb;
$defaults = array(array('orderby' => array('name',false,false),'order' => array('ASC',false,false),deregisterTaint(array('limit',false)) => addTaint(negate(array(1,false))),'category' => array('',false,false),'category_name' => array('',false,false),'hide_invisible' => array(1,false,false),'show_updated' => array(0,false,false),'include' => array('',false,false),'exclude' => array('',false,false),'search' => array('',false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
$cache = array(array(),false);
$key = attAspis(md5(deAspis(Aspis_serialize($r))));
if ( deAspis($cache = wp_cache_get(array('get_bookmarks',false),array('bookmark',false))))
 {if ( (is_array($cache[0]) && ((isset($cache[0][$key[0]]) && Aspis_isset( $cache [0][$key[0]])))))
 return apply_filters(array('get_bookmarks',false),attachAspis($cache,$key[0]),$r);
}if ( (!(is_array($cache[0]))))
 $cache = array(array(),false);
$inclusions = array('',false);
if ( (!((empty($include) || Aspis_empty( $include)))))
 {$exclude = array('',false);
$category = array('',false);
$category_name = array('',false);
$inclinks = Aspis_preg_split(array('/[\s,]+/',false),$include);
if ( count($inclinks[0]))
 {foreach ( $inclinks[0] as $inclink  )
{if ( ((empty($inclusions) || Aspis_empty( $inclusions))))
 $inclusions = concat2(concat1(' AND ( link_id = ',Aspis_intval($inclink)),' ');
else 
{$inclusions = concat($inclusions,concat2(concat1(' OR link_id = ',Aspis_intval($inclink)),' '));
}}}}if ( (!((empty($inclusions) || Aspis_empty( $inclusions)))))
 $inclusions = concat2($inclusions,')');
$exclusions = array('',false);
if ( (!((empty($exclude) || Aspis_empty( $exclude)))))
 {$exlinks = Aspis_preg_split(array('/[\s,]+/',false),$exclude);
if ( count($exlinks[0]))
 {foreach ( $exlinks[0] as $exlink  )
{if ( ((empty($exclusions) || Aspis_empty( $exclusions))))
 $exclusions = concat2(concat1(' AND ( link_id <> ',Aspis_intval($exlink)),' ');
else 
{$exclusions = concat($exclusions,concat2(concat1(' AND link_id <> ',Aspis_intval($exlink)),' '));
}}}}if ( (!((empty($exclusions) || Aspis_empty( $exclusions)))))
 $exclusions = concat2($exclusions,')');
if ( (!((empty($category_name) || Aspis_empty( $category_name)))))
 {if ( deAspis($category = get_term_by(array('name',false),$category_name,array('link_category',false))))
 {$category = $category[0]->term_id;
}else 
{{arrayAssign($cache[0],deAspis(registerTaint($key)),addTaint(array(array(),false)));
wp_cache_set(array('get_bookmarks',false),$cache,array('bookmark',false));
return apply_filters(array('get_bookmarks',false),array(array(),false),$r);
}}}if ( (!((empty($search) || Aspis_empty( $search)))))
 {$search = like_escape($search);
$search = concat2(concat(concat2(concat(concat2(concat1(" AND ( (link_url LIKE '%",$search),"%') OR (link_name LIKE '%"),$search),"%') OR (link_description LIKE '%"),$search),"%') ) ");
}$category_query = array('',false);
$join = array('',false);
if ( (!((empty($category) || Aspis_empty( $category)))))
 {$incategories = Aspis_preg_split(array('/[\s,]+/',false),$category);
if ( count($incategories[0]))
 {foreach ( $incategories[0] as $incat  )
{if ( ((empty($category_query) || Aspis_empty( $category_query))))
 $category_query = concat2(concat1(' AND ( tt.term_id = ',Aspis_intval($incat)),' ');
else 
{$category_query = concat($category_query,concat2(concat1(' OR tt.term_id = ',Aspis_intval($incat)),' '));
}}}}if ( (!((empty($category_query) || Aspis_empty( $category_query)))))
 {$category_query = concat2($category_query,") AND taxonomy = 'link_category'");
$join = concat2(concat(concat2(concat(concat2(concat1(" INNER JOIN ",$wpdb[0]->term_relationships)," AS tr ON ("),$wpdb[0]->links),".link_id = tr.object_id) INNER JOIN "),$wpdb[0]->term_taxonomy)," as tt ON tt.term_taxonomy_id = tr.term_taxonomy_id");
}if ( ($show_updated[0] && deAspis(get_option(array('links_recently_updated_time',false)))))
 {$recently_updated_test = concat2(concat1(", IF (DATE_ADD(link_updated, INTERVAL ",get_option(array('links_recently_updated_time',false)))," MINUTE) >= NOW(), 1,0) as recently_updated ");
}else 
{{$recently_updated_test = array('',false);
}}$get_updated = deAspis(($show_updated)) ? array(', UNIX_TIMESTAMP(link_updated) AS link_updated_f ',false) : array('',false);
$orderby = Aspis_strtolower($orderby);
$length = array('',false);
switch ( $orderby[0] ) {
case ('length'):$length = array(", CHAR_LENGTH(link_name) AS length",false);
break ;
case ('rand'):$orderby = array('rand()',false);
break ;
default :$orderby = concat1("link_",$orderby);
 }
if ( (('link_id') == $orderby[0]))
 $orderby = concat2($wpdb[0]->links,".link_id");
$visible = array('',false);
if ( $hide_invisible[0])
 $visible = array("AND link_visible = 'Y'",false);
$query = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT * ",$length)," "),$recently_updated_test)," "),$get_updated)," FROM "),$wpdb[0]->links)," "),$join)," WHERE 1=1 "),$visible)," "),$category_query);
$query = concat($query,concat(concat2(concat(concat2(concat1(" ",$exclusions)," "),$inclusions)," "),$search));
$query = concat($query,concat(concat2(concat1(" ORDER BY ",$orderby)," "),$order));
if ( ($limit[0] != deAspis(negate(array(1,false)))))
 $query = concat($query,concat1(" LIMIT ",$limit));
$results = $wpdb[0]->get_results($query);
arrayAssign($cache[0],deAspis(registerTaint($key)),addTaint($results));
wp_cache_set(array('get_bookmarks',false),$cache,array('bookmark',false));
return apply_filters(array('get_bookmarks',false),$results,$r);
 }
function sanitize_bookmark ( $bookmark,$context = array('display',false) ) {
$fields = array(array(array('link_id',false),array('link_url',false),array('link_name',false),array('link_image',false),array('link_target',false),array('link_category',false),array('link_description',false),array('link_visible',false),array('link_owner',false),array('link_rating',false),array('link_updated',false),array('link_rel',false),array('link_notes',false),array('link_rss',false),),false);
if ( is_object($bookmark[0]))
 {$do_object = array(true,false);
$link_id = $bookmark[0]->link_id;
}else 
{{$do_object = array(false,false);
$link_id = $bookmark[0]['link_id'];
}}foreach ( $fields[0] as $field  )
{if ( $do_object[0])
 {if ( ((isset($bookmark[0]->$field[0]) && Aspis_isset( $bookmark[0] ->$field[0] ))))
 $bookmark[0]->$field[0] = sanitize_bookmark_field($field,$bookmark[0]->$field[0],$link_id,$context);
}else 
{{if ( ((isset($bookmark[0][$field[0]]) && Aspis_isset( $bookmark [0][$field[0]]))))
 arrayAssign($bookmark[0],deAspis(registerTaint($field)),addTaint(sanitize_bookmark_field($field,attachAspis($bookmark,$field[0]),$link_id,$context)));
}}}return $bookmark;
 }
function sanitize_bookmark_field ( $field,$value,$bookmark_id,$context ) {
$int_fields = array(array(array('link_id',false),array('link_rating',false)),false);
if ( deAspis(Aspis_in_array($field,$int_fields)))
 $value = int_cast($value);
$yesno = array(array(array('link_visible',false)),false);
if ( deAspis(Aspis_in_array($field,$yesno)))
 $value = Aspis_preg_replace(array('/[^YNyn]/',false),array('',false),$value);
if ( (('link_target') == $field[0]))
 {$targets = array(array(array('_top',false),array('_blank',false)),false);
if ( (denot_boolean(Aspis_in_array($value,$targets))))
 $value = array('',false);
}if ( (('raw') == $context[0]))
 return $value;
if ( (('edit') == $context[0]))
 {$format_to_edit = array(array(array('link_notes',false)),false);
$value = apply_filters(concat1("edit_",$field),$value,$bookmark_id);
if ( deAspis(Aspis_in_array($field,$format_to_edit)))
 {$value = format_to_edit($value);
}else 
{{$value = esc_attr($value);
}}}else 
{if ( (('db') == $context[0]))
 {$value = apply_filters(concat1("pre_",$field),$value);
}else 
{{$value = apply_filters($field,$value,$bookmark_id,$context);
}}}if ( (('attribute') == $context[0]))
 $value = esc_attr($value);
else 
{if ( (('js') == $context[0]))
 $value = esc_js($value);
}return $value;
 }
function clean_bookmark_cache ( $bookmark_id ) {
wp_cache_delete($bookmark_id,array('bookmark',false));
wp_cache_delete(array('get_bookmarks',false),array('bookmark',false));
 }
;
?>
<?php 