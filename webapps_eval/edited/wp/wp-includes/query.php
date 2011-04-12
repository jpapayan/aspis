<?php require_once('AspisMain.php'); ?><?php
function get_query_var ( $var ) {
global $wp_query;
return $wp_query[0]->get($var);
 }
function set_query_var ( $var,$value ) {
global $wp_query;
return $wp_query[0]->set($var,$value);
 }
function &query_posts ( $query ) {
unset($GLOBALS[0][('wp_query')]);
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('wp_query',false))),addTaint(array(new WP_Query(),false)));
return $GLOBALS[0][('wp_query')][0]->query($query);
 }
function wp_reset_query (  ) {
unset($GLOBALS[0][('wp_query')]);
$GLOBALS[0][deAspis(registerTaint(array('wp_query',false)))] = &addTaintR($GLOBALS[0][('wp_the_query')]);
global $wp_query;
if ( (!((empty($wp_query[0]->post) || Aspis_empty( $wp_query[0] ->post )))))
 {arrayAssign($GLOBALS[0],deAspis(registerTaint(array('post',false))),addTaint($wp_query[0]->post));
setup_postdata($wp_query[0]->post);
} }
function is_archive (  ) {
global $wp_query;
return $wp_query[0]->is_archive;
 }
function is_attachment (  ) {
global $wp_query;
return $wp_query[0]->is_attachment;
 }
function is_author ( $author = array('',false) ) {
global $wp_query;
if ( (denot_boolean($wp_query[0]->is_author)))
 return array(false,false);
if ( ((empty($author) || Aspis_empty( $author))))
 return array(true,false);
$author_obj = $wp_query[0]->get_queried_object();
$author = array_cast($author);
if ( deAspis(Aspis_in_array($author_obj[0]->ID,$author)))
 return array(true,false);
elseif ( deAspis(Aspis_in_array($author_obj[0]->nickname,$author)))
 return array(true,false);
elseif ( deAspis(Aspis_in_array($author_obj[0]->user_nicename,$author)))
 return array(true,false);
return array(false,false);
 }
function is_category ( $category = array('',false) ) {
global $wp_query;
if ( (denot_boolean($wp_query[0]->is_category)))
 return array(false,false);
if ( ((empty($category) || Aspis_empty( $category))))
 return array(true,false);
$cat_obj = $wp_query[0]->get_queried_object();
$category = array_cast($category);
if ( deAspis(Aspis_in_array($cat_obj[0]->term_id,$category)))
 return array(true,false);
elseif ( deAspis(Aspis_in_array($cat_obj[0]->name,$category)))
 return array(true,false);
elseif ( deAspis(Aspis_in_array($cat_obj[0]->slug,$category)))
 return array(true,false);
return array(false,false);
 }
function is_tag ( $slug = array('',false) ) {
global $wp_query;
if ( (denot_boolean($wp_query[0]->is_tag)))
 return array(false,false);
if ( ((empty($slug) || Aspis_empty( $slug))))
 return array(true,false);
$tag_obj = $wp_query[0]->get_queried_object();
$slug = array_cast($slug);
if ( deAspis(Aspis_in_array($tag_obj[0]->slug,$slug)))
 return array(true,false);
return array(false,false);
 }
function is_tax ( $slug = array('',false) ) {
global $wp_query;
if ( (denot_boolean($wp_query[0]->is_tax)))
 return array(false,false);
if ( ((empty($slug) || Aspis_empty( $slug))))
 return array(true,false);
return Aspis_in_array(get_query_var(array('taxonomy',false)),array_cast($slug));
 }
function is_comments_popup (  ) {
global $wp_query;
return $wp_query[0]->is_comments_popup;
 }
function is_date (  ) {
global $wp_query;
return $wp_query[0]->is_date;
 }
function is_day (  ) {
global $wp_query;
return $wp_query[0]->is_day;
 }
function is_feed (  ) {
global $wp_query;
return $wp_query[0]->is_feed;
 }
function is_front_page (  ) {
if ( ((('posts') == deAspis(get_option(array('show_on_front',false)))) && deAspis(is_home())))
 return array(true,false);
elseif ( (((('page') == deAspis(get_option(array('show_on_front',false)))) && deAspis(get_option(array('page_on_front',false)))) && deAspis(is_page(get_option(array('page_on_front',false))))))
 return array(true,false);
else 
{return array(false,false);
} }
function is_home (  ) {
global $wp_query;
return $wp_query[0]->is_home;
 }
function is_month (  ) {
global $wp_query;
return $wp_query[0]->is_month;
 }
function is_page ( $page = array('',false) ) {
global $wp_query;
if ( (denot_boolean($wp_query[0]->is_page)))
 return array(false,false);
if ( ((empty($page) || Aspis_empty( $page))))
 return array(true,false);
$page_obj = $wp_query[0]->get_queried_object();
$page = array_cast($page);
if ( deAspis(Aspis_in_array($page_obj[0]->ID,$page)))
 return array(true,false);
elseif ( deAspis(Aspis_in_array($page_obj[0]->post_title,$page)))
 return array(true,false);
else 
{if ( deAspis(Aspis_in_array($page_obj[0]->post_name,$page)))
 return array(true,false);
}return array(false,false);
 }
function is_paged (  ) {
global $wp_query;
return $wp_query[0]->is_paged;
 }
function is_plugin_page (  ) {
global $plugin_page;
if ( ((isset($plugin_page) && Aspis_isset( $plugin_page))))
 return array(true,false);
return array(false,false);
 }
function is_preview (  ) {
global $wp_query;
return $wp_query[0]->is_preview;
 }
function is_robots (  ) {
global $wp_query;
return $wp_query[0]->is_robots;
 }
function is_search (  ) {
global $wp_query;
return $wp_query[0]->is_search;
 }
function is_single ( $post = array('',false) ) {
global $wp_query;
if ( (denot_boolean($wp_query[0]->is_single)))
 return array(false,false);
if ( ((empty($post) || Aspis_empty( $post))))
 return array(true,false);
$post_obj = $wp_query[0]->get_queried_object();
$post = array_cast($post);
if ( deAspis(Aspis_in_array($post_obj[0]->ID,$post)))
 return array(true,false);
elseif ( deAspis(Aspis_in_array($post_obj[0]->post_title,$post)))
 return array(true,false);
elseif ( deAspis(Aspis_in_array($post_obj[0]->post_name,$post)))
 return array(true,false);
return array(false,false);
 }
function is_singular (  ) {
global $wp_query;
return $wp_query[0]->is_singular;
 }
function is_time (  ) {
global $wp_query;
return $wp_query[0]->is_time;
 }
function is_trackback (  ) {
global $wp_query;
return $wp_query[0]->is_trackback;
 }
function is_year (  ) {
global $wp_query;
return $wp_query[0]->is_year;
 }
function is_404 (  ) {
global $wp_query;
return $wp_query[0]->is_404;
 }
function have_posts (  ) {
global $wp_query;
return $wp_query[0]->have_posts();
 }
function in_the_loop (  ) {
global $wp_query;
return $wp_query[0]->in_the_loop;
 }
function rewind_posts (  ) {
global $wp_query;
return $wp_query[0]->rewind_posts();
 }
function the_post (  ) {
global $wp_query;
$wp_query[0]->the_post();
 }
function have_comments (  ) {
global $wp_query;
return $wp_query[0]->have_comments();
 }
function the_comment (  ) {
global $wp_query;
return $wp_query[0]->the_comment();
 }
class WP_Query{var $query;
var $query_vars = array(array(),false);
var $queried_object;
var $queried_object_id;
var $request;
var $posts;
var $post_count = array(0,false);
var $current_post = array(-1,false);
var $in_the_loop = array(false,false);
var $post;
var $comments;
var $comment_count = array(0,false);
var $current_comment = array(-1,false);
var $comment;
var $found_posts = array(0,false);
var $max_num_pages = array(0,false);
var $max_num_comment_pages = array(0,false);
var $is_single = array(false,false);
var $is_preview = array(false,false);
var $is_page = array(false,false);
var $is_archive = array(false,false);
var $is_date = array(false,false);
var $is_year = array(false,false);
var $is_month = array(false,false);
var $is_day = array(false,false);
var $is_time = array(false,false);
var $is_author = array(false,false);
var $is_category = array(false,false);
var $is_tag = array(false,false);
var $is_tax = array(false,false);
var $is_search = array(false,false);
var $is_feed = array(false,false);
var $is_comment_feed = array(false,false);
var $is_trackback = array(false,false);
var $is_home = array(false,false);
var $is_404 = array(false,false);
var $is_comments_popup = array(false,false);
var $is_admin = array(false,false);
var $is_attachment = array(false,false);
var $is_singular = array(false,false);
var $is_robots = array(false,false);
var $is_posts_page = array(false,false);
function init_query_flags (  ) {
{$this->is_single = array(false,false);
$this->is_page = array(false,false);
$this->is_archive = array(false,false);
$this->is_date = array(false,false);
$this->is_year = array(false,false);
$this->is_month = array(false,false);
$this->is_day = array(false,false);
$this->is_time = array(false,false);
$this->is_author = array(false,false);
$this->is_category = array(false,false);
$this->is_tag = array(false,false);
$this->is_tax = array(false,false);
$this->is_search = array(false,false);
$this->is_feed = array(false,false);
$this->is_comment_feed = array(false,false);
$this->is_trackback = array(false,false);
$this->is_home = array(false,false);
$this->is_404 = array(false,false);
$this->is_paged = array(false,false);
$this->is_admin = array(false,false);
$this->is_attachment = array(false,false);
$this->is_singular = array(false,false);
$this->is_robots = array(false,false);
$this->is_posts_page = array(false,false);
} }
function init (  ) {
{unset($this->posts);
unset($this->query);
$this->query_vars = array(array(),false);
unset($this->queried_object);
unset($this->queried_object_id);
$this->post_count = array(0,false);
$this->current_post = negate(array(1,false));
$this->in_the_loop = array(false,false);
$this->init_query_flags();
} }
function parse_query_vars (  ) {
{$this->parse_query(array('',false));
} }
function fill_query_vars ( $array ) {
{$keys = array(array(array('error',false),array('m',false),array('p',false),array('post_parent',false),array('subpost',false),array('subpost_id',false),array('attachment',false),array('attachment_id',false),array('name',false),array('hour',false),array('static',false),array('pagename',false),array('page_id',false),array('second',false),array('minute',false),array('hour',false),array('day',false),array('monthnum',false),array('year',false),array('w',false),array('category_name',false),array('tag',false),array('cat',false),array('tag_id',false),array('author_name',false),array('feed',false),array('tb',false),array('paged',false),array('comments_popup',false),array('meta_key',false),array('meta_value',false),array('preview',false)),false);
foreach ( $keys[0] as $key  )
{if ( (!((isset($array[0][$key[0]]) && Aspis_isset( $array [0][$key[0]])))))
 arrayAssign($array[0],deAspis(registerTaint($key)),addTaint(array('',false)));
}$array_keys = array(array(array('category__in',false),array('category__not_in',false),array('category__and',false),array('post__in',false),array('post__not_in',false),array('tag__in',false),array('tag__not_in',false),array('tag__and',false),array('tag_slug__in',false),array('tag_slug__and',false)),false);
foreach ( $array_keys[0] as $key  )
{if ( (!((isset($array[0][$key[0]]) && Aspis_isset( $array [0][$key[0]])))))
 arrayAssign($array[0],deAspis(registerTaint($key)),addTaint(array(array(),false)));
}return $array;
} }
function parse_query ( $query ) {
{if ( ((!((empty($query) || Aspis_empty( $query)))) || (!((isset($this->query) && Aspis_isset( $this ->query ))))))
 {$this->init();
if ( is_array($query[0]))
 $this->query_vars = $query;
else 
{AspisInternalFunctionCall("parse_str",$query[0],AspisPushRefParam($this->query_vars),array(1));
}$this->query = $query;
}$this->query_vars = $this->fill_query_vars($this->query_vars);
$qv = &$this->query_vars;
if ( (!((empty($qv[0][('robots')]) || Aspis_empty( $qv [0][('robots')])))))
 $this->is_robots = array(true,false);
arrayAssign($qv[0],deAspis(registerTaint(array('p',false))),addTaint(absint($qv[0]['p'])));
arrayAssign($qv[0],deAspis(registerTaint(array('page_id',false))),addTaint(absint($qv[0]['page_id'])));
arrayAssign($qv[0],deAspis(registerTaint(array('year',false))),addTaint(absint($qv[0]['year'])));
arrayAssign($qv[0],deAspis(registerTaint(array('monthnum',false))),addTaint(absint($qv[0]['monthnum'])));
arrayAssign($qv[0],deAspis(registerTaint(array('day',false))),addTaint(absint($qv[0]['day'])));
arrayAssign($qv[0],deAspis(registerTaint(array('w',false))),addTaint(absint($qv[0]['w'])));
arrayAssign($qv[0],deAspis(registerTaint(array('m',false))),addTaint(absint($qv[0]['m'])));
arrayAssign($qv[0],deAspis(registerTaint(array('paged',false))),addTaint(absint($qv[0]['paged'])));
arrayAssign($qv[0],deAspis(registerTaint(array('cat',false))),addTaint(Aspis_preg_replace(array('|[^0-9,-]|',false),array('',false),$qv[0]['cat'])));
arrayAssign($qv[0],deAspis(registerTaint(array('pagename',false))),addTaint(Aspis_trim($qv[0]['pagename'])));
arrayAssign($qv[0],deAspis(registerTaint(array('name',false))),addTaint(Aspis_trim($qv[0]['name'])));
if ( (('') !== deAspis($qv[0]['hour'])))
 arrayAssign($qv[0],deAspis(registerTaint(array('hour',false))),addTaint(absint($qv[0]['hour'])));
if ( (('') !== deAspis($qv[0]['minute'])))
 arrayAssign($qv[0],deAspis(registerTaint(array('minute',false))),addTaint(absint($qv[0]['minute'])));
if ( (('') !== deAspis($qv[0]['second'])))
 arrayAssign($qv[0],deAspis(registerTaint(array('second',false))),addTaint(absint($qv[0]['second'])));
if ( (('') != deAspis($qv[0]['subpost'])))
 arrayAssign($qv[0],deAspis(registerTaint(array('attachment',false))),addTaint($qv[0]['subpost']));
if ( (('') != deAspis($qv[0]['subpost_id'])))
 arrayAssign($qv[0],deAspis(registerTaint(array('attachment_id',false))),addTaint($qv[0]['subpost_id']));
arrayAssign($qv[0],deAspis(registerTaint(array('attachment_id',false))),addTaint(absint($qv[0]['attachment_id'])));
if ( ((('') != deAspis($qv[0]['attachment'])) || (!((empty($qv[0][('attachment_id')]) || Aspis_empty( $qv [0][('attachment_id')]))))))
 {$this->is_single = array(true,false);
$this->is_attachment = array(true,false);
}elseif ( (('') != deAspis($qv[0]['name'])))
 {$this->is_single = array(true,false);
}elseif ( deAspis($qv[0]['p']))
 {$this->is_single = array(true,false);
}elseif ( ((((((('') !== deAspis($qv[0]['hour'])) && (('') !== deAspis($qv[0]['minute']))) && (('') !== deAspis($qv[0]['second']))) && (('') != deAspis($qv[0]['year']))) && (('') != deAspis($qv[0]['monthnum']))) && (('') != deAspis($qv[0]['day']))))
 {$this->is_single = array(true,false);
}elseif ( (((('') != deAspis($qv[0]['static'])) || (('') != deAspis($qv[0]['pagename']))) || (!((empty($qv[0][('page_id')]) || Aspis_empty( $qv [0][('page_id')]))))))
 {$this->is_page = array(true,false);
$this->is_single = array(false,false);
}elseif ( (!((empty($qv[0][('s')]) || Aspis_empty( $qv [0][('s')])))))
 {$this->is_search = array(true,false);
}else 
{{if ( (('') !== deAspis($qv[0]['second'])))
 {$this->is_time = array(true,false);
$this->is_date = array(true,false);
}if ( (('') !== deAspis($qv[0]['minute'])))
 {$this->is_time = array(true,false);
$this->is_date = array(true,false);
}if ( (('') !== deAspis($qv[0]['hour'])))
 {$this->is_time = array(true,false);
$this->is_date = array(true,false);
}if ( deAspis($qv[0]['day']))
 {if ( (denot_boolean($this->is_date)))
 {$this->is_day = array(true,false);
$this->is_date = array(true,false);
}}if ( deAspis($qv[0]['monthnum']))
 {if ( (denot_boolean($this->is_date)))
 {$this->is_month = array(true,false);
$this->is_date = array(true,false);
}}if ( deAspis($qv[0]['year']))
 {if ( (denot_boolean($this->is_date)))
 {$this->is_year = array(true,false);
$this->is_date = array(true,false);
}}if ( deAspis($qv[0]['m']))
 {$this->is_date = array(true,false);
if ( (strlen(deAspis($qv[0]['m'])) > (9)))
 {$this->is_time = array(true,false);
}else 
{if ( (strlen(deAspis($qv[0]['m'])) > (7)))
 {$this->is_day = array(true,false);
}else 
{if ( (strlen(deAspis($qv[0]['m'])) > (5)))
 {$this->is_month = array(true,false);
}else 
{{$this->is_year = array(true,false);
}}}}}if ( (('') != deAspis($qv[0]['w'])))
 {$this->is_date = array(true,false);
}if ( (((empty($qv[0][('cat')]) || Aspis_empty( $qv [0][('cat')]))) || (deAspis($qv[0]['cat']) == ('0'))))
 {$this->is_category = array(false,false);
}else 
{{if ( (strpos(deAspis($qv[0]['cat']),'-') !== false))
 {$this->is_category = array(false,false);
}else 
{{$this->is_category = array(true,false);
}}}}if ( (('') != deAspis($qv[0]['category_name'])))
 {$this->is_category = array(true,false);
}if ( ((!(is_array(deAspis($qv[0]['category__in'])))) || ((empty($qv[0][('category__in')]) || Aspis_empty( $qv [0][('category__in')])))))
 {arrayAssign($qv[0],deAspis(registerTaint(array('category__in',false))),addTaint(array(array(),false)));
}else 
{{arrayAssign($qv[0],deAspis(registerTaint(array('category__in',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC($qv[0]['category__in'])))));
$this->is_category = array(true,false);
}}if ( ((!(is_array(deAspis($qv[0]['category__not_in'])))) || ((empty($qv[0][('category__not_in')]) || Aspis_empty( $qv [0][('category__not_in')])))))
 {arrayAssign($qv[0],deAspis(registerTaint(array('category__not_in',false))),addTaint(array(array(),false)));
}else 
{{arrayAssign($qv[0],deAspis(registerTaint(array('category__not_in',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC($qv[0]['category__not_in'])))));
}}if ( ((!(is_array(deAspis($qv[0]['category__and'])))) || ((empty($qv[0][('category__and')]) || Aspis_empty( $qv [0][('category__and')])))))
 {arrayAssign($qv[0],deAspis(registerTaint(array('category__and',false))),addTaint(array(array(),false)));
}else 
{{arrayAssign($qv[0],deAspis(registerTaint(array('category__and',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC($qv[0]['category__and'])))));
$this->is_category = array(true,false);
}}if ( (('') != deAspis($qv[0]['tag'])))
 $this->is_tag = array(true,false);
arrayAssign($qv[0],deAspis(registerTaint(array('tag_id',false))),addTaint(absint($qv[0]['tag_id'])));
if ( (!((empty($qv[0][('tag_id')]) || Aspis_empty( $qv [0][('tag_id')])))))
 $this->is_tag = array(true,false);
if ( ((!(is_array(deAspis($qv[0]['tag__in'])))) || ((empty($qv[0][('tag__in')]) || Aspis_empty( $qv [0][('tag__in')])))))
 {arrayAssign($qv[0],deAspis(registerTaint(array('tag__in',false))),addTaint(array(array(),false)));
}else 
{{arrayAssign($qv[0],deAspis(registerTaint(array('tag__in',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC($qv[0]['tag__in'])))));
$this->is_tag = array(true,false);
}}if ( ((!(is_array(deAspis($qv[0]['tag__not_in'])))) || ((empty($qv[0][('tag__not_in')]) || Aspis_empty( $qv [0][('tag__not_in')])))))
 {arrayAssign($qv[0],deAspis(registerTaint(array('tag__not_in',false))),addTaint(array(array(),false)));
}else 
{{arrayAssign($qv[0],deAspis(registerTaint(array('tag__not_in',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC($qv[0]['tag__not_in'])))));
}}if ( ((!(is_array(deAspis($qv[0]['tag__and'])))) || ((empty($qv[0][('tag__and')]) || Aspis_empty( $qv [0][('tag__and')])))))
 {arrayAssign($qv[0],deAspis(registerTaint(array('tag__and',false))),addTaint(array(array(),false)));
}else 
{{arrayAssign($qv[0],deAspis(registerTaint(array('tag__and',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC($qv[0]['tag__and'])))));
$this->is_category = array(true,false);
}}if ( ((!(is_array(deAspis($qv[0]['tag_slug__in'])))) || ((empty($qv[0][('tag_slug__in')]) || Aspis_empty( $qv [0][('tag_slug__in')])))))
 {arrayAssign($qv[0],deAspis(registerTaint(array('tag_slug__in',false))),addTaint(array(array(),false)));
}else 
{{arrayAssign($qv[0],deAspis(registerTaint(array('tag_slug__in',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('sanitize_title',false)),deAspisRC($qv[0]['tag_slug__in'])))));
$this->is_tag = array(true,false);
}}if ( ((!(is_array(deAspis($qv[0]['tag_slug__and'])))) || ((empty($qv[0][('tag_slug__and')]) || Aspis_empty( $qv [0][('tag_slug__and')])))))
 {arrayAssign($qv[0],deAspis(registerTaint(array('tag_slug__and',false))),addTaint(array(array(),false)));
}else 
{{arrayAssign($qv[0],deAspis(registerTaint(array('tag_slug__and',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('sanitize_title',false)),deAspisRC($qv[0]['tag_slug__and'])))));
$this->is_tag = array(true,false);
}}if ( (((empty($qv[0][('taxonomy')]) || Aspis_empty( $qv [0][('taxonomy')]))) || ((empty($qv[0][('term')]) || Aspis_empty( $qv [0][('term')])))))
 {$this->is_tax = array(false,false);
foreach ( deAspis($GLOBALS[0]['wp_taxonomies']) as $taxonomy =>$t )
{restoreTaint($taxonomy,$t);
{if ( (($t[0]->query_var[0] && ((isset($qv[0][$t[0]->query_var[0]]) && Aspis_isset( $qv [0][$t[0] ->query_var [0]])))) && (('') != deAspis(attachAspis($qv,$t[0]->query_var[0])))))
 {arrayAssign($qv[0],deAspis(registerTaint(array('taxonomy',false))),addTaint($taxonomy));
arrayAssign($qv[0],deAspis(registerTaint(array('term',false))),addTaint(attachAspis($qv,$t[0]->query_var[0])));
$this->is_tax = array(true,false);
break ;
}}}}else 
{{$this->is_tax = array(true,false);
}}if ( (((empty($qv[0][('author')]) || Aspis_empty( $qv [0][('author')]))) || (deAspis($qv[0]['author']) == ('0'))))
 {$this->is_author = array(false,false);
}else 
{{$this->is_author = array(true,false);
}}if ( (('') != deAspis($qv[0]['author_name'])))
 {$this->is_author = array(true,false);
}if ( (((($this->is_date[0] || $this->is_author[0]) || $this->is_category[0]) || $this->is_tag[0]) || $this->is_tax[0]))
 $this->is_archive = array(true,false);
}}if ( (('') != deAspis($qv[0]['feed'])))
 $this->is_feed = array(true,false);
if ( (('') != deAspis($qv[0]['tb'])))
 $this->is_trackback = array(true,false);
if ( ((('') != deAspis($qv[0]['paged'])) && (deAspis(Aspis_intval($qv[0]['paged'])) > (1))))
 $this->is_paged = array(true,false);
if ( (('') != deAspis($qv[0]['comments_popup'])))
 $this->is_comments_popup = array(true,false);
if ( (('') != deAspis($qv[0]['preview'])))
 $this->is_preview = array(true,false);
if ( deAspis(is_admin()))
 $this->is_admin = array(true,false);
if ( (false !== strpos(deAspis($qv[0]['feed']),'comments-')))
 {arrayAssign($qv[0],deAspis(registerTaint(array('feed',false))),addTaint(Aspis_str_replace(array('comments-',false),array('',false),$qv[0]['feed'])));
arrayAssign($qv[0],deAspis(registerTaint(array('withcomments',false))),addTaint(array(1,false)));
}$this->is_singular = array(($this->is_single[0] || $this->is_page[0]) || $this->is_attachment[0],false);
if ( ($this->is_feed[0] && ((!((empty($qv[0][('withcomments')]) || Aspis_empty( $qv [0][('withcomments')])))) || (((empty($qv[0][('withoutcomments')]) || Aspis_empty( $qv [0][('withoutcomments')]))) && $this->is_singular[0]))))
 $this->is_comment_feed = array(true,false);
if ( (!(((((((($this->is_singular[0] || $this->is_archive[0]) || $this->is_search[0]) || $this->is_feed[0]) || $this->is_trackback[0]) || $this->is_404[0]) || $this->is_admin[0]) || $this->is_comments_popup[0]) || $this->is_robots[0])))
 $this->is_home = array(true,false);
if ( ((($this->is_home[0] && (((empty($this->query) || Aspis_empty( $this ->query ))) || (deAspis($qv[0]['preview']) == ('true')))) && (('page') == deAspis(get_option(array('show_on_front',false))))) && deAspis(get_option(array('page_on_front',false)))))
 {$this->is_page = array(true,false);
$this->is_home = array(false,false);
arrayAssign($qv[0],deAspis(registerTaint(array('page_id',false))),addTaint(get_option(array('page_on_front',false))));
}if ( (('') != deAspis($qv[0]['pagename'])))
 {$this->queried_object = &get_page_by_path($qv[0][('pagename')]);
if ( (!((empty($this->queried_object) || Aspis_empty( $this ->queried_object )))))
 $this->queried_object_id = int_cast($this->queried_object[0]->ID);
else 
{unset($this->queried_object);
}if ( (((('page') == deAspis(get_option(array('show_on_front',false)))) && ((isset($this->queried_object_id) && Aspis_isset( $this ->queried_object_id )))) && ($this->queried_object_id[0] == deAspis(get_option(array('page_for_posts',false))))))
 {$this->is_page = array(false,false);
$this->is_home = array(true,false);
$this->is_posts_page = array(true,false);
}}if ( deAspis($qv[0]['page_id']))
 {if ( ((('page') == deAspis(get_option(array('show_on_front',false)))) && (deAspis($qv[0]['page_id']) == deAspis(get_option(array('page_for_posts',false))))))
 {$this->is_page = array(false,false);
$this->is_home = array(true,false);
$this->is_posts_page = array(true,false);
}}if ( (!((empty($qv[0][('post_type')]) || Aspis_empty( $qv [0][('post_type')])))))
 {if ( is_array(deAspis($qv[0]['post_type'])))
 arrayAssign($qv[0],deAspis(registerTaint(array('post_type',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('sanitize_user',false)),deAspisRC($qv[0]['post_type']),deAspisRC(array(array(array(true,false)),false))))));
else 
{arrayAssign($qv[0],deAspis(registerTaint(array('post_type',false))),addTaint(sanitize_user($qv[0]['post_type'],array(true,false))));
}}if ( (!((empty($qv[0][('post_status')]) || Aspis_empty( $qv [0][('post_status')])))))
 arrayAssign($qv[0],deAspis(registerTaint(array('post_status',false))),addTaint(Aspis_preg_replace(array('|[^a-z0-9_,-]|',false),array('',false),$qv[0]['post_status'])));
if ( ($this->is_posts_page[0] && ((!((isset($qv[0][('withcomments')]) && Aspis_isset( $qv [0][('withcomments')])))) || (denot_boolean($qv[0]['withcomments'])))))
 $this->is_comment_feed = array(false,false);
$this->is_singular = array(($this->is_single[0] || $this->is_page[0]) || $this->is_attachment[0],false);
if ( (('404') == deAspis($qv[0]['error'])))
 $this->set_404();
if ( (!((empty($query) || Aspis_empty( $query)))))
 do_action_ref_array(array('parse_query',false),array(array(array($this,false)),false));
} }
function set_404 (  ) {
{$is_feed = $this->is_feed;
$this->init_query_flags();
$this->is_404 = array(true,false);
$this->is_feed = $is_feed;
} }
function get ( $query_var ) {
{if ( ((isset($this->query_vars[0][$query_var[0]]) && Aspis_isset( $this ->query_vars [0][$query_var[0]] ))))
 {return $this->query_vars[0][$query_var[0]];
}return array('',false);
} }
function set ( $query_var,$value ) {
{arrayAssign($this->query_vars[0],deAspis(registerTaint($query_var)),addTaint($value));
} }
function &get_posts (  ) {
{global $wpdb,$user_ID;
do_action_ref_array(array('pre_get_posts',false),array(array(array($this,false)),false));
$q = &$this->query_vars;
$q = $this->fill_query_vars($q);
$distinct = array('',false);
$whichcat = array('',false);
$whichauthor = array('',false);
$whichmimetype = array('',false);
$where = array('',false);
$limits = array('',false);
$join = array('',false);
$search = array('',false);
$groupby = array('',false);
$fields = concat2($wpdb[0]->posts,".*");
$post_status_join = array(false,false);
$page = array(1,false);
if ( (!((isset($q[0][('caller_get_posts')]) && Aspis_isset( $q [0][('caller_get_posts')])))))
 arrayAssign($q[0],deAspis(registerTaint(array('caller_get_posts',false))),addTaint(array(false,false)));
if ( (!((isset($q[0][('suppress_filters')]) && Aspis_isset( $q [0][('suppress_filters')])))))
 arrayAssign($q[0],deAspis(registerTaint(array('suppress_filters',false))),addTaint(array(false,false)));
if ( (!((isset($q[0][('post_type')]) && Aspis_isset( $q [0][('post_type')])))))
 {if ( $this->is_search[0])
 arrayAssign($q[0],deAspis(registerTaint(array('post_type',false))),addTaint(array('any',false)));
else 
{arrayAssign($q[0],deAspis(registerTaint(array('post_type',false))),addTaint(array('',false)));
}}$post_type = $q[0]['post_type'];
if ( ((!((isset($q[0][('posts_per_page')]) && Aspis_isset( $q [0][('posts_per_page')])))) || (deAspis($q[0]['posts_per_page']) == (0))))
 arrayAssign($q[0],deAspis(registerTaint(array('posts_per_page',false))),addTaint(get_option(array('posts_per_page',false))));
if ( (((isset($q[0][('showposts')]) && Aspis_isset( $q [0][('showposts')]))) && deAspis($q[0]['showposts'])))
 {arrayAssign($q[0],deAspis(registerTaint(array('showposts',false))),addTaint(int_cast($q[0]['showposts'])));
arrayAssign($q[0],deAspis(registerTaint(array('posts_per_page',false))),addTaint($q[0]['showposts']));
}if ( ((((isset($q[0][('posts_per_archive_page')]) && Aspis_isset( $q [0][('posts_per_archive_page')]))) && (deAspis($q[0]['posts_per_archive_page']) != (0))) && ($this->is_archive[0] || $this->is_search[0])))
 arrayAssign($q[0],deAspis(registerTaint(array('posts_per_page',false))),addTaint($q[0]['posts_per_archive_page']));
if ( (!((isset($q[0][('nopaging')]) && Aspis_isset( $q [0][('nopaging')])))))
 {if ( (deAspis($q[0]['posts_per_page']) == deAspis(negate(array(1,false)))))
 {arrayAssign($q[0],deAspis(registerTaint(array('nopaging',false))),addTaint(array(true,false)));
}else 
{{arrayAssign($q[0],deAspis(registerTaint(array('nopaging',false))),addTaint(array(false,false)));
}}}if ( $this->is_feed[0])
 {arrayAssign($q[0],deAspis(registerTaint(array('posts_per_page',false))),addTaint(get_option(array('posts_per_rss',false))));
arrayAssign($q[0],deAspis(registerTaint(array('nopaging',false))),addTaint(array(false,false)));
}arrayAssign($q[0],deAspis(registerTaint(array('posts_per_page',false))),addTaint(int_cast($q[0]['posts_per_page'])));
if ( (deAspis($q[0]['posts_per_page']) < deAspis(negate(array(1,false)))))
 arrayAssign($q[0],deAspis(registerTaint(array('posts_per_page',false))),addTaint(Aspis_abs($q[0]['posts_per_page'])));
else 
{if ( (deAspis($q[0]['posts_per_page']) == (0)))
 arrayAssign($q[0],deAspis(registerTaint(array('posts_per_page',false))),addTaint(array(1,false)));
}if ( ((!((isset($q[0][('comments_per_page')]) && Aspis_isset( $q [0][('comments_per_page')])))) || (deAspis($q[0]['comments_per_page']) == (0))))
 arrayAssign($q[0],deAspis(registerTaint(array('comments_per_page',false))),addTaint(get_option(array('comments_per_page',false))));
if ( ((($this->is_home[0] && (((empty($this->query) || Aspis_empty( $this ->query ))) || (deAspis($q[0]['preview']) == ('true')))) && (('page') == deAspis(get_option(array('show_on_front',false))))) && deAspis(get_option(array('page_on_front',false)))))
 {$this->is_page = array(true,false);
$this->is_home = array(false,false);
arrayAssign($q[0],deAspis(registerTaint(array('page_id',false))),addTaint(get_option(array('page_on_front',false))));
}if ( ((isset($q[0][('page')]) && Aspis_isset( $q [0][('page')]))))
 {arrayAssign($q[0],deAspis(registerTaint(array('page',false))),addTaint(Aspis_trim($q[0]['page'],array('/',false))));
arrayAssign($q[0],deAspis(registerTaint(array('page',false))),addTaint(absint($q[0]['page'])));
}if ( deAspis($q[0]['m']))
 {arrayAssign($q[0],deAspis(registerTaint(array('m',false))),addTaint(concat1('',Aspis_preg_replace(array('|[^0-9]|',false),array('',false),$q[0]['m']))));
$where = concat($where,concat(concat2(concat1(" AND YEAR(",$wpdb[0]->posts),".post_date)="),Aspis_substr($q[0]['m'],array(0,false),array(4,false))));
if ( (strlen(deAspis($q[0]['m'])) > (5)))
 $where = concat($where,concat(concat2(concat1(" AND MONTH(",$wpdb[0]->posts),".post_date)="),Aspis_substr($q[0]['m'],array(4,false),array(2,false))));
if ( (strlen(deAspis($q[0]['m'])) > (7)))
 $where = concat($where,concat(concat2(concat1(" AND DAYOFMONTH(",$wpdb[0]->posts),".post_date)="),Aspis_substr($q[0]['m'],array(6,false),array(2,false))));
if ( (strlen(deAspis($q[0]['m'])) > (9)))
 $where = concat($where,concat(concat2(concat1(" AND HOUR(",$wpdb[0]->posts),".post_date)="),Aspis_substr($q[0]['m'],array(8,false),array(2,false))));
if ( (strlen(deAspis($q[0]['m'])) > (11)))
 $where = concat($where,concat(concat2(concat1(" AND MINUTE(",$wpdb[0]->posts),".post_date)="),Aspis_substr($q[0]['m'],array(10,false),array(2,false))));
if ( (strlen(deAspis($q[0]['m'])) > (13)))
 $where = concat($where,concat(concat2(concat1(" AND SECOND(",$wpdb[0]->posts),".post_date)="),Aspis_substr($q[0]['m'],array(12,false),array(2,false))));
}if ( (('') !== deAspis($q[0]['hour'])))
 $where = concat($where,concat2(concat(concat2(concat1(" AND HOUR(",$wpdb[0]->posts),".post_date)='"),$q[0]['hour']),"'"));
if ( (('') !== deAspis($q[0]['minute'])))
 $where = concat($where,concat2(concat(concat2(concat1(" AND MINUTE(",$wpdb[0]->posts),".post_date)='"),$q[0]['minute']),"'"));
if ( (('') !== deAspis($q[0]['second'])))
 $where = concat($where,concat2(concat(concat2(concat1(" AND SECOND(",$wpdb[0]->posts),".post_date)='"),$q[0]['second']),"'"));
if ( deAspis($q[0]['year']))
 $where = concat($where,concat2(concat(concat2(concat1(" AND YEAR(",$wpdb[0]->posts),".post_date)='"),$q[0]['year']),"'"));
if ( deAspis($q[0]['monthnum']))
 $where = concat($where,concat2(concat(concat2(concat1(" AND MONTH(",$wpdb[0]->posts),".post_date)='"),$q[0]['monthnum']),"'"));
if ( deAspis($q[0]['day']))
 $where = concat($where,concat2(concat(concat2(concat1(" AND DAYOFMONTH(",$wpdb[0]->posts),".post_date)='"),$q[0]['day']),"'"));
if ( (('') != deAspis($q[0]['name'])))
 {arrayAssign($q[0],deAspis(registerTaint(array('name',false))),addTaint(sanitize_title($q[0]['name'])));
$where = concat($where,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->posts),".post_name = '"),$q[0]['name']),"'"));
}else 
{if ( (('') != deAspis($q[0]['pagename'])))
 {if ( ((isset($this->queried_object_id) && Aspis_isset( $this ->queried_object_id ))))
 $reqpage = $this->queried_object_id;
else 
{{$reqpage = get_page_by_path($q[0]['pagename']);
if ( (!((empty($reqpage) || Aspis_empty( $reqpage)))))
 $reqpage = $reqpage[0]->ID;
else 
{$reqpage = array(0,false);
}}}$page_for_posts = get_option(array('page_for_posts',false));
if ( (((('page') != deAspis(get_option(array('show_on_front',false)))) || ((empty($page_for_posts) || Aspis_empty( $page_for_posts)))) || ($reqpage[0] != $page_for_posts[0])))
 {arrayAssign($q[0],deAspis(registerTaint(array('pagename',false))),addTaint(Aspis_str_replace(array('%2F',false),array('/',false),Aspis_urlencode(Aspis_urldecode($q[0]['pagename'])))));
$page_paths = concat1('/',Aspis_trim($q[0]['pagename'],array('/',false)));
arrayAssign($q[0],deAspis(registerTaint(array('pagename',false))),addTaint(sanitize_title(Aspis_basename($page_paths))));
arrayAssign($q[0],deAspis(registerTaint(array('name',false))),addTaint($q[0]['pagename']));
$where = concat($where,concat2(concat(concat2(concat1(" AND (",$wpdb[0]->posts),".ID = '"),$reqpage),"')"));
$reqpage_obj = get_page($reqpage);
if ( (is_object($reqpage_obj[0]) && (('attachment') == $reqpage_obj[0]->post_type[0])))
 {$this->is_attachment = array(true,false);
$this->is_page = array(true,false);
arrayAssign($q[0],deAspis(registerTaint(array('attachment_id',false))),addTaint($reqpage));
}}}elseif ( (('') != deAspis($q[0]['attachment'])))
 {arrayAssign($q[0],deAspis(registerTaint(array('attachment',false))),addTaint(Aspis_str_replace(array('%2F',false),array('/',false),Aspis_urlencode(Aspis_urldecode($q[0]['attachment'])))));
$attach_paths = concat1('/',Aspis_trim($q[0]['attachment'],array('/',false)));
arrayAssign($q[0],deAspis(registerTaint(array('attachment',false))),addTaint(sanitize_title(Aspis_basename($attach_paths))));
arrayAssign($q[0],deAspis(registerTaint(array('name',false))),addTaint($q[0]['attachment']));
$where = concat($where,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->posts),".post_name = '"),$q[0]['attachment']),"'"));
}}if ( deAspis($q[0]['w']))
 $where = concat($where,concat2(concat(concat2(concat1(" AND WEEK(",$wpdb[0]->posts),".post_date, 1)='"),$q[0]['w']),"'"));
if ( deAspis(Aspis_intval($q[0]['comments_popup'])))
 arrayAssign($q[0],deAspis(registerTaint(array('p',false))),addTaint(absint($q[0]['comments_popup'])));
if ( deAspis($q[0]['attachment_id']))
 arrayAssign($q[0],deAspis(registerTaint(array('p',false))),addTaint(absint($q[0]['attachment_id'])));
if ( deAspis($q[0]['p']))
 {$where = concat($where,concat(concat2(concat1(" AND ",$wpdb[0]->posts),".ID = "),$q[0]['p']));
}elseif ( deAspis($q[0]['post__in']))
 {$post__in = Aspis_implode(array(',',false),attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC($q[0]['post__in']))));
$where = concat($where,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->posts),".ID IN ("),$post__in),")"));
}elseif ( deAspis($q[0]['post__not_in']))
 {$post__not_in = Aspis_implode(array(',',false),attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC($q[0]['post__not_in']))));
$where = concat($where,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->posts),".ID NOT IN ("),$post__not_in),")"));
}if ( is_numeric(deAspisRC($q[0]['post_parent'])))
 $where = concat($where,$wpdb[0]->prepare(concat2(concat1(" AND ",$wpdb[0]->posts),".post_parent = %d "),$q[0]['post_parent']));
if ( deAspis($q[0]['page_id']))
 {if ( ((('page') != deAspis(get_option(array('show_on_front',false)))) || (deAspis($q[0]['page_id']) != deAspis(get_option(array('page_for_posts',false))))))
 {arrayAssign($q[0],deAspis(registerTaint(array('p',false))),addTaint($q[0]['page_id']));
$where = concat(concat2(concat1(" AND ",$wpdb[0]->posts),".ID = "),$q[0]['page_id']);
}}if ( (!((empty($q[0][('s')]) || Aspis_empty( $q [0][('s')])))))
 {arrayAssign($q[0],deAspis(registerTaint(array('s',false))),addTaint(Aspis_stripslashes($q[0]['s'])));
if ( (!((empty($q[0][('sentence')]) || Aspis_empty( $q [0][('sentence')])))))
 {arrayAssign($q[0],deAspis(registerTaint(array('search_terms',false))),addTaint(array(array($q[0]['s']),false)));
}else 
{{Aspis_preg_match_all(array('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/',false),$q[0]['s'],$matches);
arrayAssign($q[0],deAspis(registerTaint(array('search_terms',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('_search_terms_tidy',false)),deAspisRC(attachAspis($matches,(0)))))));
}}$n = (!((empty($q[0][('exact')]) || Aspis_empty( $q [0][('exact')])))) ? array('',false) : array('%',false);
$searchand = array('',false);
foreach ( deAspis(array_cast($q[0]['search_terms'])) as $term  )
{$term = addslashes_gpc($term);
$search = concat($search,concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2($searchand,"(("),$wpdb[0]->posts),".post_title LIKE '"),$n),"') OR ("),$wpdb[0]->posts),".post_content LIKE '"),$n),"'))"));
$searchand = array(' AND ',false);
}$term = esc_sql($q[0]['s']);
if ( ((((empty($q[0][('sentence')]) || Aspis_empty( $q [0][('sentence')]))) && (count(deAspis($q[0]['search_terms'])) > (1))) && (deAspis(attachAspis($q[0][('search_terms')],(0))) != deAspis($q[0]['s']))))
 $search = concat($search,concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" OR (",$wpdb[0]->posts),".post_title LIKE '"),$n),"') OR ("),$wpdb[0]->posts),".post_content LIKE '"),$n),"')"));
if ( (!((empty($search) || Aspis_empty( $search)))))
 {$search = concat2(concat1(" AND (",$search),") ");
if ( (denot_boolean(is_user_logged_in())))
 $search = concat($search,concat2(concat1(" AND (",$wpdb[0]->posts),".post_password = '') "));
}}if ( ((((empty($q[0][('cat')]) || Aspis_empty( $q [0][('cat')]))) || (deAspis($q[0]['cat']) == ('0'))) || $this->is_singular[0]))
 {$whichcat = array('',false);
}else 
{{arrayAssign($q[0],deAspis(registerTaint(array('cat',false))),addTaint(concat2(concat1('',Aspis_urldecode($q[0]['cat'])),'')));
arrayAssign($q[0],deAspis(registerTaint(array('cat',false))),addTaint(addslashes_gpc($q[0]['cat'])));
$cat_array = Aspis_preg_split(array('/[,\s]+/',false),$q[0]['cat']);
arrayAssign($q[0],deAspis(registerTaint(array('cat',false))),addTaint(array('',false)));
$req_cats = array(array(),false);
foreach ( deAspis(array_cast($cat_array)) as $cat  )
{$cat = Aspis_intval($cat);
arrayAssignAdd($req_cats[0][],addTaint($cat));
$in = (array($cat[0] > (0),false));
$cat = Aspis_abs($cat);
if ( $in[0])
 {arrayAssignAdd($q[0][('category__in')][0][],addTaint($cat));
arrayAssign($q[0],deAspis(registerTaint(array('category__in',false))),addTaint(Aspis_array_merge($q[0]['category__in'],get_term_children($cat,array('category',false)))));
}else 
{{arrayAssignAdd($q[0][('category__not_in')][0][],addTaint($cat));
arrayAssign($q[0],deAspis(registerTaint(array('category__not_in',false))),addTaint(Aspis_array_merge($q[0]['category__not_in'],get_term_children($cat,array('category',false)))));
}}}arrayAssign($q[0],deAspis(registerTaint(array('cat',false))),addTaint(Aspis_implode(array(',',false),$req_cats)));
}}if ( (!((empty($q[0][('category__in')]) || Aspis_empty( $q [0][('category__in')])))))
 {$join = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" INNER JOIN ",$wpdb[0]->term_relationships)," ON ("),$wpdb[0]->posts),".ID = "),$wpdb[0]->term_relationships),".object_id) INNER JOIN "),$wpdb[0]->term_taxonomy)," ON ("),$wpdb[0]->term_relationships),".term_taxonomy_id = "),$wpdb[0]->term_taxonomy),".term_taxonomy_id) ");
$whichcat = concat($whichcat,concat2(concat1(" AND ",$wpdb[0]->term_taxonomy),".taxonomy = 'category' "));
$include_cats = concat2(concat1("'",Aspis_implode(array("', '",false),$q[0]['category__in'])),"'");
$whichcat = concat($whichcat,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->term_taxonomy),".term_id IN ("),$include_cats),") "));
}if ( (!((empty($q[0][('category__not_in')]) || Aspis_empty( $q [0][('category__not_in')])))))
 {$cat_string = concat2(concat1("'",Aspis_implode(array("', '",false),$q[0]['category__not_in'])),"'");
$whichcat = concat($whichcat,concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" AND ",$wpdb[0]->posts),".ID NOT IN ( SELECT tr.object_id FROM "),$wpdb[0]->term_relationships)," AS tr INNER JOIN "),$wpdb[0]->term_taxonomy)," AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tt.taxonomy = 'category' AND tt.term_id IN ("),$cat_string),") )"));
}if ( ((('') != deAspis($q[0]['category_name'])) && (denot_boolean($this->is_singular))))
 {arrayAssign($q[0],deAspis(registerTaint(array('category_name',false))),addTaint(Aspis_implode(array('/',false),attAspisRC(array_map(AspisInternalCallback(array('sanitize_title',false)),deAspisRC(Aspis_explode(array('/',false),$q[0]['category_name'])))))));
$reqcat = get_category_by_path($q[0]['category_name']);
arrayAssign($q[0],deAspis(registerTaint(array('category_name',false))),addTaint(Aspis_str_replace(array('%2F',false),array('/',false),Aspis_urlencode(Aspis_urldecode($q[0]['category_name'])))));
$cat_paths = concat1('/',Aspis_trim($q[0]['category_name'],array('/',false)));
arrayAssign($q[0],deAspis(registerTaint(array('category_name',false))),addTaint(sanitize_title(Aspis_basename($cat_paths))));
$cat_paths = concat1('/',Aspis_trim(Aspis_urldecode($q[0]['category_name']),array('/',false)));
arrayAssign($q[0],deAspis(registerTaint(array('category_name',false))),addTaint(sanitize_title(Aspis_basename($cat_paths))));
$cat_paths = Aspis_explode(array('/',false),$cat_paths);
$cat_path = array('',false);
foreach ( deAspis(array_cast($cat_paths)) as $pathdir  )
$cat_path = concat($cat_path,concat((($pathdir[0] != ('')) ? array('/',false) : array('',false)),sanitize_title($pathdir)));
if ( ((empty($reqcat) || Aspis_empty( $reqcat))))
 $reqcat = get_category_by_path($q[0]['category_name'],array(false,false));
if ( (!((empty($reqcat) || Aspis_empty( $reqcat)))))
 $reqcat = $reqcat[0]->term_id;
else 
{$reqcat = array(0,false);
}arrayAssign($q[0],deAspis(registerTaint(array('cat',false))),addTaint($reqcat));
$join = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" INNER JOIN ",$wpdb[0]->term_relationships)," ON ("),$wpdb[0]->posts),".ID = "),$wpdb[0]->term_relationships),".object_id) INNER JOIN "),$wpdb[0]->term_taxonomy)," ON ("),$wpdb[0]->term_relationships),".term_taxonomy_id = "),$wpdb[0]->term_taxonomy),".term_taxonomy_id) ");
$whichcat = concat2(concat1(" AND ",$wpdb[0]->term_taxonomy),".taxonomy = 'category' ");
$in_cats = array(array($q[0]['cat']),false);
$in_cats = Aspis_array_merge($in_cats,get_term_children($q[0]['cat'],array('category',false)));
$in_cats = concat2(concat1("'",Aspis_implode(array("', '",false),$in_cats)),"'");
$whichcat = concat($whichcat,concat2(concat(concat2(concat1("AND ",$wpdb[0]->term_taxonomy),".term_id IN ("),$in_cats),")"));
$groupby = concat2($wpdb[0]->posts,".ID");
}if ( (('') != deAspis($q[0]['tag'])))
 {if ( (strpos(deAspis($q[0]['tag']),',') !== false))
 {$tags = Aspis_preg_split(array('/[,\s]+/',false),$q[0]['tag']);
foreach ( deAspis(array_cast($tags)) as $tag  )
{$tag = sanitize_term_field(array('slug',false),$tag,array(0,false),array('post_tag',false),array('db',false));
arrayAssignAdd($q[0][('tag_slug__in')][0][],addTaint($tag));
}}else 
{if ( (deAspis(Aspis_preg_match(array('/[+\s]+/',false),$q[0]['tag'])) || (!((empty($q[0][('cat')]) || Aspis_empty( $q [0][('cat')]))))))
 {$tags = Aspis_preg_split(array('/[+\s]+/',false),$q[0]['tag']);
foreach ( deAspis(array_cast($tags)) as $tag  )
{$tag = sanitize_term_field(array('slug',false),$tag,array(0,false),array('post_tag',false),array('db',false));
arrayAssignAdd($q[0][('tag_slug__and')][0][],addTaint($tag));
}}else 
{{arrayAssign($q[0],deAspis(registerTaint(array('tag',false))),addTaint(sanitize_term_field(array('slug',false),$q[0]['tag'],array(0,false),array('post_tag',false),array('db',false))));
arrayAssignAdd($q[0][('tag_slug__in')][0][],addTaint($q[0]['tag']));
}}}}if ( ((((!((empty($q[0][('category__in')]) || Aspis_empty( $q [0][('category__in')])))) || (!((empty($q[0][('meta_key')]) || Aspis_empty( $q [0][('meta_key')]))))) || (!((empty($q[0][('tag__in')]) || Aspis_empty( $q [0][('tag__in')]))))) || (!((empty($q[0][('tag_slug__in')]) || Aspis_empty( $q [0][('tag_slug__in')]))))))
 {$groupby = concat2($wpdb[0]->posts,".ID");
}if ( ((!((empty($q[0][('tag__in')]) || Aspis_empty( $q [0][('tag__in')])))) && ((empty($q[0][('cat')]) || Aspis_empty( $q [0][('cat')])))))
 {$join = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" INNER JOIN ",$wpdb[0]->term_relationships)," ON ("),$wpdb[0]->posts),".ID = "),$wpdb[0]->term_relationships),".object_id) INNER JOIN "),$wpdb[0]->term_taxonomy)," ON ("),$wpdb[0]->term_relationships),".term_taxonomy_id = "),$wpdb[0]->term_taxonomy),".term_taxonomy_id) ");
$whichcat = concat($whichcat,concat2(concat1(" AND ",$wpdb[0]->term_taxonomy),".taxonomy = 'post_tag' "));
$include_tags = concat2(concat1("'",Aspis_implode(array("', '",false),$q[0]['tag__in'])),"'");
$whichcat = concat($whichcat,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->term_taxonomy),".term_id IN ("),$include_tags),") "));
$reqtag = is_term(attachAspis($q[0][('tag__in')],(0)),array('post_tag',false));
if ( (!((empty($reqtag) || Aspis_empty( $reqtag)))))
 arrayAssign($q[0],deAspis(registerTaint(array('tag_id',false))),addTaint($reqtag[0]['term_id']));
}if ( ((!((empty($q[0][('tag_slug__in')]) || Aspis_empty( $q [0][('tag_slug__in')])))) && ((empty($q[0][('cat')]) || Aspis_empty( $q [0][('cat')])))))
 {$join = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" INNER JOIN ",$wpdb[0]->term_relationships)," ON ("),$wpdb[0]->posts),".ID = "),$wpdb[0]->term_relationships),".object_id) INNER JOIN "),$wpdb[0]->term_taxonomy)," ON ("),$wpdb[0]->term_relationships),".term_taxonomy_id = "),$wpdb[0]->term_taxonomy),".term_taxonomy_id) INNER JOIN "),$wpdb[0]->terms)," ON ("),$wpdb[0]->term_taxonomy),".term_id = "),$wpdb[0]->terms),".term_id) ");
$whichcat = concat($whichcat,concat2(concat1(" AND ",$wpdb[0]->term_taxonomy),".taxonomy = 'post_tag' "));
$include_tags = concat2(concat1("'",Aspis_implode(array("', '",false),$q[0]['tag_slug__in'])),"'");
$whichcat = concat($whichcat,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->terms),".slug IN ("),$include_tags),") "));
$reqtag = get_term_by(array('slug',false),attachAspis($q[0][('tag_slug__in')],(0)),array('post_tag',false));
if ( (!((empty($reqtag) || Aspis_empty( $reqtag)))))
 arrayAssign($q[0],deAspis(registerTaint(array('tag_id',false))),addTaint($reqtag[0]->term_id));
}if ( (!((empty($q[0][('tag__not_in')]) || Aspis_empty( $q [0][('tag__not_in')])))))
 {$tag_string = concat2(concat1("'",Aspis_implode(array("', '",false),$q[0]['tag__not_in'])),"'");
$whichcat = concat($whichcat,concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" AND ",$wpdb[0]->posts),".ID NOT IN ( SELECT tr.object_id FROM "),$wpdb[0]->term_relationships)," AS tr INNER JOIN "),$wpdb[0]->term_taxonomy)," AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tt.taxonomy = 'post_tag' AND tt.term_id IN ("),$tag_string),") )"));
}$intersections = array(array('category__and' => array('category',false,false),'tag__and' => array('post_tag',false,false),'tag_slug__and' => array('post_tag',false,false),'tag__in' => array('post_tag',false,false),'tag_slug__in' => array('post_tag',false,false)),false);
$tagin = array(array(array('tag__in',false),array('tag_slug__in',false)),false);
foreach ( $intersections[0] as $item =>$taxonomy )
{restoreTaint($item,$taxonomy);
{if ( ((empty($q[0][$item[0]]) || Aspis_empty( $q [0][$item[0]]))))
 continue ;
if ( (deAspis(Aspis_in_array($item,$tagin)) && ((empty($q[0][('cat')]) || Aspis_empty( $q [0][('cat')])))))
 continue ;
if ( ($item[0] != ('category__and')))
 {$reqtag = is_term(attachAspis($q[0][$item[0]],(0)),array('post_tag',false));
if ( (!((empty($reqtag) || Aspis_empty( $reqtag)))))
 arrayAssign($q[0],deAspis(registerTaint(array('tag_id',false))),addTaint($reqtag[0]['term_id']));
}if ( deAspis(Aspis_in_array($item,array(array(array('tag_slug__and',false),array('tag_slug__in',false)),false))))
 $taxonomy_field = array('slug',false);
else 
{$taxonomy_field = array('term_id',false);
}arrayAssign($q[0],deAspis(registerTaint($item)),addTaint(attAspisRC(array_unique(deAspisRC(attachAspis($q,$item[0]))))));
$tsql = concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT p.ID FROM ",$wpdb[0]->posts)," p INNER JOIN "),$wpdb[0]->term_relationships)," tr ON (p.ID = tr.object_id) INNER JOIN "),$wpdb[0]->term_taxonomy)," tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) INNER JOIN "),$wpdb[0]->terms)," t ON (tt.term_id = t.term_id)");
$tsql = concat($tsql,concat2(concat(concat2(concat(concat2(concat1(" WHERE tt.taxonomy = '",$taxonomy),"' AND t."),$taxonomy_field)," IN ('"),Aspis_implode(array("', '",false),attachAspis($q,$item[0]))),"')"));
if ( (denot_boolean(Aspis_in_array($item,$tagin))))
 {$tsql = concat($tsql,concat1(" GROUP BY p.ID HAVING count(p.ID) = ",attAspis(count(deAspis(attachAspis($q,$item[0]))))));
}$post_ids = $wpdb[0]->get_col($tsql);
if ( count($post_ids[0]))
 $whichcat = concat($whichcat,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->posts),".ID IN ("),Aspis_implode(array(', ',false),$post_ids)),") "));
else 
{{$whichcat = array(" AND 0 = 1",false);
break ;
}}}}if ( $this->is_tax[0])
 {if ( (('') != deAspis($q[0]['taxonomy'])))
 {$taxonomy = $q[0]['taxonomy'];
arrayAssign($tt[0],deAspis(registerTaint($taxonomy)),addTaint($q[0]['term']));
$terms = get_terms($q[0]['taxonomy'],array(array(deregisterTaint(array('slug',false)) => addTaint($q[0]['term'])),false));
}else 
{{foreach ( deAspis($GLOBALS[0]['wp_taxonomies']) as $taxonomy =>$t )
{restoreTaint($taxonomy,$t);
{if ( ($t[0]->query_var[0] && (('') != deAspis(attachAspis($q,$t[0]->query_var[0])))))
 {$terms = get_terms($taxonomy,array(array(deregisterTaint(array('slug',false)) => addTaint(attachAspis($q,$t[0]->query_var[0]))),false));
if ( (denot_boolean(is_wp_error($terms))))
 break ;
}}}}}if ( (deAspis(is_wp_error($terms)) || ((empty($terms) || Aspis_empty( $terms)))))
 {$whichcat = array(" AND 0 ",false);
}else 
{{foreach ( $terms[0] as $term  )
arrayAssignAdd($term_ids[0][],addTaint($term[0]->term_id));
$post_ids = get_objects_in_term($term_ids,$taxonomy);
if ( ((denot_boolean(is_wp_error($post_ids))) && count($post_ids[0])))
 {$whichcat = concat($whichcat,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->posts),".ID IN ("),Aspis_implode(array(', ',false),$post_ids)),") "));
$post_type = array('any',false);
arrayAssign($q[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('publish',false)));
$post_status_join = array(true,false);
}else 
{{$whichcat = array(" AND 0 ",false);
}}}}}if ( (((empty($q[0][('author')]) || Aspis_empty( $q [0][('author')]))) || (deAspis($q[0]['author']) == ('0'))))
 {$whichauthor = array('',false);
}else 
{{arrayAssign($q[0],deAspis(registerTaint(array('author',false))),addTaint(concat2(concat1('',Aspis_urldecode($q[0]['author'])),'')));
arrayAssign($q[0],deAspis(registerTaint(array('author',false))),addTaint(addslashes_gpc($q[0]['author'])));
if ( (strpos(deAspis($q[0]['author']),'-') !== false))
 {$eq = array('!=',false);
$andor = array('AND',false);
arrayAssign($q[0],deAspis(registerTaint(array('author',false))),addTaint(Aspis_explode(array('-',false),$q[0]['author'])));
arrayAssign($q[0],deAspis(registerTaint(array('author',false))),addTaint(concat1('',absint(attachAspis($q[0][('author')],(1))))));
}else 
{{$eq = array('=',false);
$andor = array('OR',false);
}}$author_array = Aspis_preg_split(array('/[,\s]+/',false),$q[0]['author']);
$whichauthor = concat($whichauthor,concat(concat2(concat(concat2(concat1(" AND (",$wpdb[0]->posts),".post_author "),$eq),' '),absint(attachAspis($author_array,(0)))));
for ( $i = array(1,false) ; ($i[0] < count($author_array[0])) ; $i = array($i[0] + (1),false) )
{$whichauthor = concat($whichauthor,concat(concat2(concat(concat(concat1(' ',$andor),concat2(concat1(" ",$wpdb[0]->posts),".post_author ")),$eq),' '),absint(attachAspis($author_array,$i[0]))));
}$whichauthor = concat2($whichauthor,')');
}}if ( (('') != deAspis($q[0]['author_name'])))
 {if ( (strpos(deAspis($q[0]['author_name']),'/') !== false))
 {arrayAssign($q[0],deAspis(registerTaint(array('author_name',false))),addTaint(Aspis_explode(array('/',false),$q[0]['author_name'])));
if ( deAspis(attachAspis($q[0][('author_name')],(count(deAspis($q[0]['author_name'])) - (1)))))
 {arrayAssign($q[0],deAspis(registerTaint(array('author_name',false))),addTaint(attachAspis($q[0][('author_name')],(count(deAspis($q[0]['author_name'])) - (1)))));
}else 
{{arrayAssign($q[0],deAspis(registerTaint(array('author_name',false))),addTaint(attachAspis($q[0][('author_name')],(count(deAspis($q[0]['author_name'])) - (2)))));
}}}arrayAssign($q[0],deAspis(registerTaint(array('author_name',false))),addTaint(sanitize_title($q[0]['author_name'])));
arrayAssign($q[0],deAspis(registerTaint(array('author',false))),addTaint($wpdb[0]->get_var(concat2(concat(concat2(concat1("SELECT ID FROM ",$wpdb[0]->users)," WHERE user_nicename='"),$q[0]['author_name']),"'"))));
arrayAssign($q[0],deAspis(registerTaint(array('author',false))),addTaint(get_user_by(array('slug',false),$q[0]['author_name'])));
if ( deAspis($q[0]['author']))
 arrayAssign($q[0],deAspis(registerTaint(array('author',false))),addTaint($q[0][('author')][0]->ID));
$whichauthor = concat($whichauthor,concat2(concat(concat2(concat1(" AND (",$wpdb[0]->posts),".post_author = "),absint($q[0]['author'])),')'));
}if ( (((isset($q[0][('post_mime_type')]) && Aspis_isset( $q [0][('post_mime_type')]))) && (('') != deAspis($q[0]['post_mime_type']))))
 $whichmimetype = wp_post_mime_type_where($q[0]['post_mime_type']);
$where = concat($where,concat(concat(concat($search,$whichcat),$whichauthor),$whichmimetype));
if ( (((empty($q[0][('order')]) || Aspis_empty( $q [0][('order')]))) || ((deAspis(Aspis_strtoupper($q[0]['order'])) != ('ASC')) && (deAspis(Aspis_strtoupper($q[0]['order'])) != ('DESC')))))
 arrayAssign($q[0],deAspis(registerTaint(array('order',false))),addTaint(array('DESC',false)));
if ( ((empty($q[0][('orderby')]) || Aspis_empty( $q [0][('orderby')]))))
 {arrayAssign($q[0],deAspis(registerTaint(array('orderby',false))),addTaint(concat(concat2($wpdb[0]->posts,".post_date "),$q[0]['order'])));
}elseif ( (('none') == deAspis($q[0]['orderby'])))
 {arrayAssign($q[0],deAspis(registerTaint(array('orderby',false))),addTaint(array('',false)));
}else 
{{$allowed_keys = array(array(array('author',false),array('date',false),array('title',false),array('modified',false),array('menu_order',false),array('parent',false),array('ID',false),array('rand',false),array('comment_count',false)),false);
if ( (!((empty($q[0][('meta_key')]) || Aspis_empty( $q [0][('meta_key')])))))
 {arrayAssignAdd($allowed_keys[0][],addTaint($q[0]['meta_key']));
arrayAssignAdd($allowed_keys[0][],addTaint(array('meta_value',false)));
}arrayAssign($q[0],deAspis(registerTaint(array('orderby',false))),addTaint(Aspis_urldecode($q[0]['orderby'])));
arrayAssign($q[0],deAspis(registerTaint(array('orderby',false))),addTaint(addslashes_gpc($q[0]['orderby'])));
$orderby_array = Aspis_explode(array(' ',false),$q[0]['orderby']);
if ( ((empty($orderby_array) || Aspis_empty( $orderby_array))))
 arrayAssignAdd($orderby_array[0][],addTaint($q[0]['orderby']));
arrayAssign($q[0],deAspis(registerTaint(array('orderby',false))),addTaint(array('',false)));
for ( $i = array(0,false) ; ($i[0] < count($orderby_array[0])) ; postincr($i) )
{$orderby = attachAspis($orderby_array,$i[0]);
switch ( $orderby[0] ) {
case ('menu_order'):break ;
case ('ID'):$orderby = concat2($wpdb[0]->posts,".ID");
break ;
case ('rand'):$orderby = array('RAND()',false);
break ;
case deAspis($q[0]['meta_key']):case ('meta_value'):$orderby = concat2($wpdb[0]->postmeta,".meta_value");
break ;
case ('comment_count'):$orderby = concat2($wpdb[0]->posts,".comment_count");
break ;
default :$orderby = concat(concat2($wpdb[0]->posts,".post_"),$orderby);
 }
if ( deAspis(Aspis_in_array(attachAspis($orderby_array,$i[0]),$allowed_keys)))
 arrayAssign($q[0],deAspis(registerTaint(array('orderby',false))),addTaint(concat($q[0]['orderby'],concat((($i[0] == (0)) ? array('',false) : array(',',false)),$orderby))));
}if ( (!((empty($q[0][('orderby')]) || Aspis_empty( $q [0][('orderby')])))))
 arrayAssign($q[0],deAspis(registerTaint(array('orderby',false))),addTaint(concat($q[0]['orderby'],concat1(" ",$q[0]['order']))));
if ( ((empty($q[0][('orderby')]) || Aspis_empty( $q [0][('orderby')]))))
 arrayAssign($q[0],deAspis(registerTaint(array('orderby',false))),addTaint(concat(concat2($wpdb[0]->posts,".post_date "),$q[0]['order'])));
}}if ( is_array($post_type[0]))
 $post_type_cap = array('multiple_post_type',false);
else 
{$post_type_cap = $post_type;
}$exclude_post_types = array('',false);
foreach ( deAspis(get_post_types(array(array('exclude_from_search' => array(true,false,false)),false))) as $_wp_post_type  )
$exclude_post_types = concat($exclude_post_types,$wpdb[0]->prepare(concat2(concat1(" AND ",$wpdb[0]->posts),".post_type != %s"),$_wp_post_type));
if ( (('any') == $post_type[0]))
 {$where = concat($where,$exclude_post_types);
}elseif ( ((!((empty($post_type) || Aspis_empty( $post_type)))) && is_array($post_type[0])))
 {$where = concat($where,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->posts),".post_type IN ('"),Aspis_join(array("', '",false),$post_type)),"')"));
}elseif ( (!((empty($post_type) || Aspis_empty( $post_type)))))
 {$where = concat($where,concat2(concat(concat2(concat1(" AND ",$wpdb[0]->posts),".post_type = '"),$post_type),"'"));
}elseif ( $this->is_attachment[0])
 {$where = concat($where,concat2(concat1(" AND ",$wpdb[0]->posts),".post_type = 'attachment'"));
$post_type_cap = array('post',false);
}elseif ( $this->is_page[0])
 {$where = concat($where,concat2(concat1(" AND ",$wpdb[0]->posts),".post_type = 'page'"));
$post_type_cap = array('page',false);
}else 
{{$where = concat($where,concat2(concat1(" AND ",$wpdb[0]->posts),".post_type = 'post'"));
$post_type_cap = array('post',false);
}}if ( (((isset($q[0][('post_status')]) && Aspis_isset( $q [0][('post_status')]))) && (('') != deAspis($q[0]['post_status']))))
 {$statuswheres = array(array(),false);
$q_status = Aspis_explode(array(',',false),$q[0]['post_status']);
$r_status = array(array(),false);
$p_status = array(array(),false);
if ( (deAspis($q[0]['post_status']) == ('any')))
 {arrayAssignAdd($r_status[0][],addTaint(concat2($wpdb[0]->posts,".post_status <> 'trash'")));
}else 
{{if ( deAspis(Aspis_in_array(array('draft',false),$q_status)))
 arrayAssignAdd($r_status[0][],addTaint(concat2($wpdb[0]->posts,".post_status = 'draft'")));
if ( deAspis(Aspis_in_array(array('pending',false),$q_status)))
 arrayAssignAdd($r_status[0][],addTaint(concat2($wpdb[0]->posts,".post_status = 'pending'")));
if ( deAspis(Aspis_in_array(array('future',false),$q_status)))
 arrayAssignAdd($r_status[0][],addTaint(concat2($wpdb[0]->posts,".post_status = 'future'")));
if ( deAspis(Aspis_in_array(array('inherit',false),$q_status)))
 arrayAssignAdd($r_status[0][],addTaint(concat2($wpdb[0]->posts,".post_status = 'inherit'")));
if ( deAspis(Aspis_in_array(array('private',false),$q_status)))
 arrayAssignAdd($p_status[0][],addTaint(concat2($wpdb[0]->posts,".post_status = 'private'")));
if ( deAspis(Aspis_in_array(array('publish',false),$q_status)))
 arrayAssignAdd($r_status[0][],addTaint(concat2($wpdb[0]->posts,".post_status = 'publish'")));
if ( deAspis(Aspis_in_array(array('trash',false),$q_status)))
 arrayAssignAdd($r_status[0][],addTaint(concat2($wpdb[0]->posts,".post_status = 'trash'")));
}}if ( (((empty($q[0][('perm')]) || Aspis_empty( $q [0][('perm')]))) || (('readable') != deAspis($q[0]['perm']))))
 {$r_status = Aspis_array_merge($r_status,$p_status);
unset($p_status);
}if ( (!((empty($r_status) || Aspis_empty( $r_status)))))
 {if ( (((!((empty($q[0][('perm')]) || Aspis_empty( $q [0][('perm')])))) && (('editable') == deAspis($q[0]['perm']))) && (denot_boolean(current_user_can(concat2(concat1("edit_others_",$post_type_cap),"s"))))))
 arrayAssignAdd($statuswheres[0][],addTaint(concat2(concat(concat2(concat2(concat(concat2(concat1("(",$wpdb[0]->posts),".post_author = "),$user_ID)," "),"AND ("),Aspis_join(array(' OR ',false),$r_status)),"))")));
else 
{arrayAssignAdd($statuswheres[0][],addTaint(concat2(concat1("(",Aspis_join(array(' OR ',false),$r_status)),")")));
}}if ( (!((empty($p_status) || Aspis_empty( $p_status)))))
 {if ( (((!((empty($q[0][('perm')]) || Aspis_empty( $q [0][('perm')])))) && (('readable') == deAspis($q[0]['perm']))) && (denot_boolean(current_user_can(concat2(concat1("read_private_",$post_type_cap),"s"))))))
 arrayAssignAdd($statuswheres[0][],addTaint(concat2(concat(concat2(concat2(concat(concat2(concat1("(",$wpdb[0]->posts),".post_author = "),$user_ID)," "),"AND ("),Aspis_join(array(' OR ',false),$p_status)),"))")));
else 
{arrayAssignAdd($statuswheres[0][],addTaint(concat2(concat1("(",Aspis_join(array(' OR ',false),$p_status)),")")));
}}if ( $post_status_join[0])
 {$join = concat($join,concat2(concat(concat2(concat1(" LEFT JOIN ",$wpdb[0]->posts)," AS p2 ON ("),$wpdb[0]->posts),".post_parent = p2.ID) "));
foreach ( $statuswheres[0] as $index =>$statuswhere )
{restoreTaint($index,$statuswhere);
arrayAssign($statuswheres[0],deAspis(registerTaint($index)),addTaint(concat2(concat(concat2(concat(concat2(concat1("(",$statuswhere)," OR ("),$wpdb[0]->posts),".post_status = 'inherit' AND "),Aspis_str_replace($wpdb[0]->posts,array('p2',false),$statuswhere)),"))")));
}}foreach ( $statuswheres[0] as $statuswhere  )
$where = concat($where,concat1(" AND ",$statuswhere));
}elseif ( (denot_boolean($this->is_singular)))
 {$where = concat($where,concat2(concat1(" AND (",$wpdb[0]->posts),".post_status = 'publish'"));
if ( deAspis(is_admin()))
 $where = concat($where,concat2(concat(concat2(concat(concat2(concat1(" OR ",$wpdb[0]->posts),".post_status = 'future' OR "),$wpdb[0]->posts),".post_status = 'draft' OR "),$wpdb[0]->posts),".post_status = 'pending'"));
if ( deAspis(is_user_logged_in()))
 {$where = concat($where,deAspis(current_user_can(concat2(concat1("read_private_",$post_type_cap),"s"))) ? concat2(concat1(" OR ",$wpdb[0]->posts),".post_status = 'private'") : concat2(concat(concat2(concat(concat2(concat1(" OR ",$wpdb[0]->posts),".post_author = "),$user_ID)," AND "),$wpdb[0]->posts),".post_status = 'private'"));
}$where = concat2($where,')');
}if ( ((!((empty($q[0][('meta_key')]) || Aspis_empty( $q [0][('meta_key')])))) || (!((empty($q[0][('meta_value')]) || Aspis_empty( $q [0][('meta_value')]))))))
 $join = concat($join,concat2(concat(concat2(concat(concat2(concat1(" JOIN ",$wpdb[0]->postmeta)," ON ("),$wpdb[0]->posts),".ID = "),$wpdb[0]->postmeta),".post_id) "));
if ( (!((empty($q[0][('meta_key')]) || Aspis_empty( $q [0][('meta_key')])))))
 $where = concat($where,$wpdb[0]->prepare(concat2(concat1(" AND ",$wpdb[0]->postmeta),".meta_key = %s "),$q[0]['meta_key']));
if ( (!((empty($q[0][('meta_value')]) || Aspis_empty( $q [0][('meta_value')])))))
 {if ( (((!((isset($q[0][('meta_compare')]) && Aspis_isset( $q [0][('meta_compare')])))) || ((empty($q[0][('meta_compare')]) || Aspis_empty( $q [0][('meta_compare')])))) || (denot_boolean(Aspis_in_array($q[0]['meta_compare'],array(array(array('=',false),array('!=',false),array('>',false),array('>=',false),array('<',false),array('<=',false)),false))))))
 arrayAssign($q[0],deAspis(registerTaint(array('meta_compare',false))),addTaint(array('=',false)));
$where = concat($where,$wpdb[0]->prepare(concat2(concat(concat2(concat1("AND ",$wpdb[0]->postmeta),".meta_value "),$q[0]['meta_compare'])," %s "),$q[0]['meta_value']));
}if ( (denot_boolean($q[0]['suppress_filters'])))
 {$where = apply_filters(array('posts_where',false),$where);
$join = apply_filters(array('posts_join',false),$join);
}if ( (((empty($q[0][('nopaging')]) || Aspis_empty( $q [0][('nopaging')]))) && (denot_boolean($this->is_singular))))
 {$page = absint($q[0]['paged']);
if ( ((empty($page) || Aspis_empty( $page))))
 {$page = array(1,false);
}if ( ((empty($q[0][('offset')]) || Aspis_empty( $q [0][('offset')]))))
 {$pgstrt = array('',false);
$pgstrt = concat12(($page[0] - (1)) * deAspis($q[0]['posts_per_page']),', ');
$limits = concat(concat1('LIMIT ',$pgstrt),$q[0]['posts_per_page']);
}else 
{{arrayAssign($q[0],deAspis(registerTaint(array('offset',false))),addTaint(absint($q[0]['offset'])));
$pgstrt = concat2($q[0]['offset'],', ');
$limits = concat(concat1('LIMIT ',$pgstrt),$q[0]['posts_per_page']);
}}}if ( ($this->is_comment_feed[0] && (($this->is_archive[0] || $this->is_search[0]) || (denot_boolean($this->is_singular)))))
 {if ( ($this->is_archive[0] || $this->is_search[0]))
 {$cjoin = concat2(concat(concat2(concat(concat2(concat(concat2(concat1("JOIN ",$wpdb[0]->posts)," ON ("),$wpdb[0]->comments),".comment_post_ID = "),$wpdb[0]->posts),".ID) "),$join)," ");
$cwhere = concat1("WHERE comment_approved = '1' ",$where);
$cgroupby = concat2($wpdb[0]->comments,".comment_id");
}else 
{{$cjoin = concat2(concat(concat2(concat(concat2(concat1("JOIN ",$wpdb[0]->posts)," ON ( "),$wpdb[0]->comments),".comment_post_ID = "),$wpdb[0]->posts),".ID )");
$cwhere = array("WHERE post_status = 'publish' AND comment_approved = '1'",false);
$cgroupby = array('',false);
}}if ( (denot_boolean($q[0]['suppress_filters'])))
 {$cjoin = apply_filters(array('comment_feed_join',false),$cjoin);
$cwhere = apply_filters(array('comment_feed_where',false),$cwhere);
$cgroupby = apply_filters(array('comment_feed_groupby',false),$cgroupby);
$corderby = apply_filters(array('comment_feed_orderby',false),array('comment_date_gmt DESC',false));
$climits = apply_filters(array('comment_feed_limits',false),concat1('LIMIT ',get_option(array('posts_per_rss',false))));
}$cgroupby = (!((empty($cgroupby) || Aspis_empty( $cgroupby)))) ? concat1('GROUP BY ',$cgroupby) : array('',false);
$corderby = (!((empty($corderby) || Aspis_empty( $corderby)))) ? concat1('ORDER BY ',$corderby) : array('',false);
$this->comments = array_cast($wpdb[0]->get_results(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT ",$distinct)," "),$wpdb[0]->comments),".* FROM "),$wpdb[0]->comments)," "),$cjoin)," "),$cwhere)," "),$cgroupby)," "),$corderby)," "),$climits)));
$this->comment_count = attAspis(count($this->comments[0]));
$post_ids = array(array(),false);
foreach ( $this->comments[0] as $comment  )
arrayAssignAdd($post_ids[0][],addTaint(int_cast($comment[0]->comment_post_ID)));
$post_ids = Aspis_join(array(',',false),$post_ids);
$join = array('',false);
if ( $post_ids[0])
 $where = concat2(concat(concat2(concat1("AND ",$wpdb[0]->posts),".ID IN ("),$post_ids),") ");
else 
{$where = array("AND 0",false);
}}$orderby = $q[0]['orderby'];
if ( (denot_boolean($q[0]['suppress_filters'])))
 {$where = apply_filters(array('posts_where_paged',false),$where);
$groupby = apply_filters(array('posts_groupby',false),$groupby);
$join = apply_filters(array('posts_join_paged',false),$join);
$orderby = apply_filters(array('posts_orderby',false),$orderby);
$distinct = apply_filters(array('posts_distinct',false),$distinct);
$limits = apply_filters(array('post_limits',false),$limits);
$fields = apply_filters(array('posts_fields',false),$fields);
}do_action(array('posts_selection',false),concat(concat(concat(concat($where,$groupby),$orderby),$limits),$join));
if ( (denot_boolean($q[0]['suppress_filters'])))
 {$where = apply_filters(array('posts_where_request',false),$where);
$groupby = apply_filters(array('posts_groupby_request',false),$groupby);
$join = apply_filters(array('posts_join_request',false),$join);
$orderby = apply_filters(array('posts_orderby_request',false),$orderby);
$distinct = apply_filters(array('posts_distinct_request',false),$distinct);
$fields = apply_filters(array('posts_fields_request',false),$fields);
$limits = apply_filters(array('post_limits_request',false),$limits);
}if ( (!((empty($groupby) || Aspis_empty( $groupby)))))
 $groupby = concat1('GROUP BY ',$groupby);
if ( (!((empty($orderby) || Aspis_empty( $orderby)))))
 $orderby = concat1('ORDER BY ',$orderby);
$found_rows = array('',false);
if ( (!((empty($limits) || Aspis_empty( $limits)))))
 $found_rows = array('SQL_CALC_FOUND_ROWS',false);
$this->request = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" SELECT ",$found_rows)," "),$distinct)," "),$fields)," FROM "),$wpdb[0]->posts)," "),$join)," WHERE 1=1 "),$where)," "),$groupby)," "),$orderby)," "),$limits);
if ( (denot_boolean($q[0]['suppress_filters'])))
 $this->request = apply_filters(array('posts_request',false),$this->request);
$this->posts = $wpdb[0]->get_results($this->request);
if ( (denot_boolean($q[0]['suppress_filters'])))
 $this->posts = apply_filters(array('posts_results',false),$this->posts);
if ( (((!((empty($this->posts) || Aspis_empty( $this ->posts )))) && $this->is_comment_feed[0]) && $this->is_singular[0]))
 {$cjoin = apply_filters(array('comment_feed_join',false),array('',false));
$cwhere = apply_filters(array('comment_feed_where',false),concat2(concat1("WHERE comment_post_ID = '",$this->posts[0][(0)][0]->ID),"' AND comment_approved = '1'"));
$cgroupby = apply_filters(array('comment_feed_groupby',false),array('',false));
$cgroupby = (!((empty($cgroupby) || Aspis_empty( $cgroupby)))) ? concat1('GROUP BY ',$cgroupby) : array('',false);
$corderby = apply_filters(array('comment_feed_orderby',false),array('comment_date_gmt DESC',false));
$corderby = (!((empty($corderby) || Aspis_empty( $corderby)))) ? concat1('ORDER BY ',$corderby) : array('',false);
$climits = apply_filters(array('comment_feed_limits',false),concat1('LIMIT ',get_option(array('posts_per_rss',false))));
$comments_request = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT ",$wpdb[0]->comments),".* FROM "),$wpdb[0]->comments)," "),$cjoin)," "),$cwhere)," "),$cgroupby)," "),$corderby)," "),$climits);
$this->comments = $wpdb[0]->get_results($comments_request);
$this->comment_count = attAspis(count($this->comments[0]));
}if ( (!((empty($limits) || Aspis_empty( $limits)))))
 {$found_posts_query = apply_filters(array('found_posts_query',false),array('SELECT FOUND_ROWS()',false));
$this->found_posts = $wpdb[0]->get_var($found_posts_query);
$this->found_posts = apply_filters(array('found_posts',false),$this->found_posts);
$this->max_num_pages = attAspis(ceil(($this->found_posts[0] / deAspis($q[0]['posts_per_page']))));
}if ( ((!((empty($this->posts) || Aspis_empty( $this ->posts )))) && ($this->is_single[0] || $this->is_page[0])))
 {$status = get_post_status($this->posts[0][(0)]);
if ( (('publish') != $status[0]))
 {if ( (denot_boolean(is_user_logged_in())))
 {$this->posts = array(array(),false);
}else 
{{if ( deAspis(Aspis_in_array($status,array(array(array('draft',false),array('pending',false),array('trash',false)),false))))
 {if ( (denot_boolean(current_user_can(concat1("edit_",$post_type_cap),$this->posts[0][(0)][0]->ID))))
 {$this->posts = array(array(),false);
}else 
{{$this->is_preview = array(true,false);
$this->posts[0][(0)][0]->post_date = current_time(array('mysql',false));
}}}else 
{if ( (('future') == $status[0]))
 {$this->is_preview = array(true,false);
if ( (denot_boolean(current_user_can(concat1("edit_",$post_type_cap),$this->posts[0][(0)][0]->ID))))
 {$this->posts = array(array(),false);
}}else 
{{if ( (denot_boolean(current_user_can(concat1("read_",$post_type_cap),$this->posts[0][(0)][0]->ID))))
 $this->posts = array(array(),false);
}}}}}}if ( ($this->is_preview[0] && deAspis(current_user_can(concat1("edit_",$post_type_cap),$this->posts[0][(0)][0]->ID))))
 arrayAssign($this->posts[0],deAspis(registerTaint(array(0,false))),addTaint(apply_filters(array('the_preview',false),$this->posts[0][(0)])));
}$sticky_posts = get_option(array('sticky_posts',false));
if ( (((($this->is_home[0] && ($page[0] <= (1))) && is_array($sticky_posts[0])) && (!((empty($sticky_posts) || Aspis_empty( $sticky_posts))))) && (denot_boolean($q[0]['caller_get_posts']))))
 {$num_posts = attAspis(count($this->posts[0]));
$sticky_offset = array(0,false);
for ( $i = array(0,false) ; ($i[0] < $num_posts[0]) ; postincr($i) )
{if ( deAspis(Aspis_in_array($this->posts[0][$i[0]][0]->ID,$sticky_posts)))
 {$sticky_post = $this->posts[0][$i[0]];
Aspis_array_splice($this->posts,$i,array(1,false));
Aspis_array_splice($this->posts,$sticky_offset,array(0,false),array(array($sticky_post),false));
postincr($sticky_offset);
$offset = Aspis_array_search($sticky_post[0]->ID,$sticky_posts);
Aspis_array_splice($sticky_posts,$offset,array(1,false));
}}if ( (!((empty($sticky_posts) || Aspis_empty( $sticky_posts)))))
 {$stickies__in = Aspis_implode(array(',',false),attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC($sticky_posts))));
$stickies_where = array('',false);
if ( ((('any') != $post_type[0]) && (('') != $post_type[0])))
 {if ( is_array($post_type[0]))
 {$post_types = Aspis_join(array("', '",false),$post_type);
}else 
{{$post_types = $post_type;
}}$stickies_where = concat2(concat(concat2(concat1("AND ",$wpdb[0]->posts),".post_type IN ('"),$post_types),"')");
}$stickies = $wpdb[0]->get_results(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," WHERE "),$wpdb[0]->posts),".ID IN ("),$stickies__in),") "),$stickies_where));
foreach ( $stickies[0] as $sticky_post  )
{if ( (('publish') != $sticky_post[0]->post_status[0]))
 continue ;
Aspis_array_splice($this->posts,$sticky_offset,array(0,false),array(array($sticky_post),false));
postincr($sticky_offset);
}}}if ( (denot_boolean($q[0]['suppress_filters'])))
 $this->posts = apply_filters(array('the_posts',false),$this->posts);
$this->post_count = attAspis(count($this->posts[0]));
for ( $i = array(0,false) ; ($i[0] < $this->post_count[0]) ; postincr($i) )
{arrayAssign($this->posts[0],deAspis(registerTaint($i)),addTaint(sanitize_post($this->posts[0][$i[0]],array('raw',false))));
}update_post_caches($this->posts);
if ( ($this->post_count[0] > (0)))
 {$this->post = $this->posts[0][(0)];
}return $this->posts;
} }
function next_post (  ) {
{postincr($this->current_post);
$this->post = $this->posts[0][$this->current_post[0]];
return $this->post;
} }
function the_post (  ) {
{global $post;
$this->in_the_loop = array(true,false);
if ( ($this->current_post[0] == deAspis(negate(array(1,false)))))
 do_action_ref_array(array('loop_start',false),array(array(array($this,false)),false));
$post = $this->next_post();
setup_postdata($post);
} }
function have_posts (  ) {
{if ( (($this->current_post[0] + (1)) < $this->post_count[0]))
 {return array(true,false);
}elseif ( ((($this->current_post[0] + (1)) == $this->post_count[0]) && ($this->post_count[0] > (0))))
 {do_action_ref_array(array('loop_end',false),array(array(array($this,false)),false));
$this->rewind_posts();
}$this->in_the_loop = array(false,false);
return array(false,false);
} }
function rewind_posts (  ) {
{$this->current_post = negate(array(1,false));
if ( ($this->post_count[0] > (0)))
 {$this->post = $this->posts[0][(0)];
}} }
function next_comment (  ) {
{postincr($this->current_comment);
$this->comment = $this->comments[0][$this->current_comment[0]];
return $this->comment;
} }
function the_comment (  ) {
{global $comment;
$comment = $this->next_comment();
if ( ($this->current_comment[0] == (0)))
 {do_action(array('comment_loop_start',false));
}} }
function have_comments (  ) {
{if ( (($this->current_comment[0] + (1)) < $this->comment_count[0]))
 {return array(true,false);
}elseif ( (($this->current_comment[0] + (1)) == $this->comment_count[0]))
 {$this->rewind_comments();
}return array(false,false);
} }
function rewind_comments (  ) {
{$this->current_comment = negate(array(1,false));
if ( ($this->comment_count[0] > (0)))
 {$this->comment = $this->comments[0][(0)];
}} }
function &query ( $query ) {
{$this->parse_query($query);
return $this->get_posts();
} }
function get_queried_object (  ) {
{if ( ((isset($this->queried_object) && Aspis_isset( $this ->queried_object ))))
 {return $this->queried_object;
}$this->queried_object = array(NULL,false);
$this->queried_object_id = array(0,false);
if ( $this->is_category[0])
 {$cat = $this->get(array('cat',false));
$category = &get_category($cat);
if ( deAspis(is_wp_error($category)))
 return array(NULL,false);
$this->queried_object = &$category;
$this->queried_object_id = int_cast($cat);
}else 
{if ( $this->is_tag[0])
 {$tag_id = $this->get(array('tag_id',false));
$tag = &get_term($tag_id,array('post_tag',false));
if ( deAspis(is_wp_error($tag)))
 return array(NULL,false);
$this->queried_object = &$tag;
$this->queried_object_id = int_cast($tag_id);
}else 
{if ( $this->is_tax[0])
 {$tax = $this->get(array('taxonomy',false));
$slug = $this->get(array('term',false));
$term = &get_terms($tax,array(array(deregisterTaint(array('slug',false)) => addTaint($slug)),false));
if ( (deAspis(is_wp_error($term)) || ((empty($term) || Aspis_empty( $term)))))
 return array(NULL,false);
$term = attachAspis($term,(0));
$this->queried_object = $term;
$this->queried_object_id = $term[0]->term_id;
}else 
{if ( $this->is_posts_page[0])
 {$this->queried_object = &get_page(get_option(array('page_for_posts',false)));
$this->queried_object_id = int_cast($this->queried_object[0]->ID);
}else 
{if ( $this->is_single[0])
 {$this->queried_object = $this->post;
$this->queried_object_id = int_cast($this->post[0]->ID);
}else 
{if ( $this->is_page[0])
 {$this->queried_object = $this->post;
$this->queried_object_id = int_cast($this->post[0]->ID);
}else 
{if ( $this->is_author[0])
 {$author_id = int_cast($this->get(array('author',false)));
$author = get_userdata($author_id);
$this->queried_object = $author;
$this->queried_object_id = $author_id;
}}}}}}}return $this->queried_object;
} }
function get_queried_object_id (  ) {
{$this->get_queried_object();
if ( ((isset($this->queried_object_id) && Aspis_isset( $this ->queried_object_id ))))
 {return $this->queried_object_id;
}return array(0,false);
} }
function WP_Query ( $query = array('',false) ) {
{if ( (!((empty($query) || Aspis_empty( $query)))))
 {$this->query($query);
}} }
}function wp_old_slug_redirect (  ) {
global $wp_query;
if ( (deAspis(is_404()) && (('') != $wp_query[0]->query_vars[0][('name')][0])))
 {global $wpdb;
$query = concat2(concat(concat2(concat(concat2(concat1("SELECT post_id FROM ",$wpdb[0]->postmeta),", "),$wpdb[0]->posts)," WHERE ID = post_id AND meta_key = '_wp_old_slug' AND meta_value='"),$wp_query[0]->query_vars[0][('name')]),"'");
if ( (('') != $wp_query[0]->query_vars[0][('year')][0]))
 $query = concat($query,concat2(concat1(" AND YEAR(post_date) = '",$wp_query[0]->query_vars[0][('year')]),"'"));
if ( (('') != $wp_query[0]->query_vars[0][('monthnum')][0]))
 $query = concat($query,concat2(concat1(" AND MONTH(post_date) = '",$wp_query[0]->query_vars[0][('monthnum')]),"'"));
if ( (('') != $wp_query[0]->query_vars[0][('day')][0]))
 $query = concat($query,concat2(concat1(" AND DAYOFMONTH(post_date) = '",$wp_query[0]->query_vars[0][('day')]),"'"));
$id = int_cast($wpdb[0]->get_var($query));
if ( (denot_boolean($id)))
 return ;
$link = get_permalink($id);
if ( (denot_boolean($link)))
 return ;
wp_redirect($link,array('301',false));
Aspis_exit();
} }
function setup_postdata ( $post ) {
global $id,$authordata,$day,$currentmonth,$page,$pages,$multipage,$more,$numpages;
$id = int_cast($post[0]->ID);
$authordata = get_userdata($post[0]->post_author);
$day = mysql2date(array('d.m.y',false),$post[0]->post_date,array(false,false));
$currentmonth = mysql2date(array('m',false),$post[0]->post_date,array(false,false));
$numpages = array(1,false);
$page = get_query_var(array('page',false));
if ( (denot_boolean($page)))
 $page = array(1,false);
if ( ((deAspis(is_single()) || deAspis(is_page())) || deAspis(is_feed())))
 $more = array(1,false);
$content = $post[0]->post_content;
if ( strpos($content[0],'<!--nextpage-->'))
 {if ( ($page[0] > (1)))
 $more = array(1,false);
$multipage = array(1,false);
$content = Aspis_str_replace(array("\n<!--nextpage-->\n",false),array('<!--nextpage-->',false),$content);
$content = Aspis_str_replace(array("\n<!--nextpage-->",false),array('<!--nextpage-->',false),$content);
$content = Aspis_str_replace(array("<!--nextpage-->\n",false),array('<!--nextpage-->',false),$content);
$pages = Aspis_explode(array('<!--nextpage-->',false),$content);
$numpages = attAspis(count($pages[0]));
}else 
{{arrayAssign($pages[0],deAspis(registerTaint(array(0,false))),addTaint($post[0]->post_content));
$multipage = array(0,false);
}}do_action_ref_array(array('the_post',false),array(array(&$post),false));
return array(true,false);
 }
;
?>
<?php 