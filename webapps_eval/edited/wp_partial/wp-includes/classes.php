<?php require_once('AspisMain.php'); ?><?php
class WP{var $public_query_vars = array('m','p','posts','w','cat','withcomments','withoutcomments','s','search','exact','sentence','debug','calendar','page','paged','more','tb','pb','author','order','orderby','year','monthnum','day','hour','minute','second','name','category_name','tag','feed','author_name','static','pagename','page_id','error','comments_popup','attachment','attachment_id','subpost','subpost_id','preview','robots','taxonomy','term','cpage');
var $private_query_vars = array('offset','posts_per_page','posts_per_archive_page','showposts','nopaging','post_type','post_status','category__in','category__not_in','category__and','tag__in','tag__not_in','tag__and','tag_slug__in','tag_slug__and','tag_id','post_mime_type','perm','comments_per_page');
var $extra_query_vars = array();
var $query_vars;
var $query_string;
var $request;
var $matched_rule;
var $matched_query;
var $did_permalink = false;
function add_query_var ( $qv ) {
{if ( !in_array($qv,$this->public_query_vars))
 $this->public_query_vars[] = $qv;
} }
function set_query_var ( $key,$value ) {
{$this->query_vars[$key] = $value;
} }
function parse_request ( $extra_query_vars = '' ) {
{{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$this->query_vars = array();
$taxonomy_query_vars = array();
if ( is_array($extra_query_vars))
 $this->extra_query_vars = &$extra_query_vars;
else 
{if ( !empty($extra_query_vars))
 parse_str($extra_query_vars,$this->extra_query_vars);
}$rewrite = $wp_rewrite->wp_rewrite_rules();
if ( !empty($rewrite))
 {$error = '404';
$this->did_permalink = true;
if ( (isset($_SERVER[0]['PATH_INFO']) && Aspis_isset($_SERVER[0]['PATH_INFO'])))
 $pathinfo = deAspisWarningRC($_SERVER[0]['PATH_INFO']);
else 
{$pathinfo = '';
}$pathinfo_array = explode('?',$pathinfo);
$pathinfo = str_replace("%","%25",$pathinfo_array[0]);
$req_uri = deAspisWarningRC($_SERVER[0]['REQUEST_URI']);
$req_uri_array = explode('?',$req_uri);
$req_uri = $req_uri_array[0];
$self = deAspisWarningRC($_SERVER[0]['PHP_SELF']);
$home_path = parse_url(get_option('home'));
if ( isset($home_path['path']))
 $home_path = $home_path['path'];
else 
{$home_path = '';
}$home_path = trim($home_path,'/');
$req_uri = str_replace($pathinfo,'',rawurldecode($req_uri));
$req_uri = trim($req_uri,'/');
$req_uri = preg_replace("|^$home_path|",'',$req_uri);
$req_uri = trim($req_uri,'/');
$pathinfo = trim($pathinfo,'/');
$pathinfo = preg_replace("|^$home_path|",'',$pathinfo);
$pathinfo = trim($pathinfo,'/');
$self = trim($self,'/');
$self = preg_replace("|^$home_path|",'',$self);
$self = trim($self,'/');
if ( !empty($pathinfo) && !preg_match('|^.*' . $wp_rewrite->index . '$|',$pathinfo))
 {$request = $pathinfo;
}else 
{{if ( $req_uri == $wp_rewrite->index)
 $req_uri = '';
$request = $req_uri;
}}$this->request = $request;
$request_match = $request;
foreach ( (array)$rewrite as $match =>$query )
{if ( $req_uri == 'wp-app.php')
 break ;
if ( (!empty($req_uri)) && (strpos($match,$req_uri) === 0) && ($req_uri != $request))
 {$request_match = $req_uri . '/' . $request;
}if ( preg_match("#^$match#",$request_match,$matches) || preg_match("#^$match#",urldecode($request_match),$matches))
 {$this->matched_rule = $match;
$query = preg_replace("!^.+\?!",'',$query);
$query = addslashes(WP_MatchesMapRegex::apply($query,$matches));
$this->matched_query = $query;
parse_str($query,$perma_query_vars);
if ( (isset($_GET[0]['error']) && Aspis_isset($_GET[0]['error'])))
 unset($_GET[0]['error']);
if ( isset($error))
 unset($error);
break ;
}}if ( empty($request) || $req_uri == $self || strpos(deAspisWarningRC($_SERVER[0]['PHP_SELF']),'wp-admin/') !== false)
 {if ( (isset($_GET[0]['error']) && Aspis_isset($_GET[0]['error'])))
 unset($_GET[0]['error']);
if ( isset($error))
 unset($error);
if ( isset($perma_query_vars) && strpos(deAspisWarningRC($_SERVER[0]['PHP_SELF']),'wp-admin/') !== false)
 unset($perma_query_vars);
$this->did_permalink = false;
}}$this->public_query_vars = apply_filters('query_vars',$this->public_query_vars);
foreach ( $GLOBALS[0]['wp_taxonomies'] as $taxonomy =>$t )
if ( $t->query_var)
 $taxonomy_query_vars[$t->query_var] = $taxonomy;
for ( $i = 0 ; $i < count($this->public_query_vars) ; $i += 1 )
{$wpvar = $this->public_query_vars[$i];
if ( isset($this->extra_query_vars[$wpvar]))
 $this->query_vars[$wpvar] = $this->extra_query_vars[$wpvar];
elseif ( isset($GLOBALS[0][$wpvar]))
 $this->query_vars[$wpvar] = $GLOBALS[0][$wpvar];
elseif ( !(empty($_POST[0][$wpvar]) || Aspis_empty($_POST[0][$wpvar])))
 $this->query_vars[$wpvar] = deAspisWarningRC($_POST[0][$wpvar]);
elseif ( !(empty($_GET[0][$wpvar]) || Aspis_empty($_GET[0][$wpvar])))
 $this->query_vars[$wpvar] = deAspisWarningRC($_GET[0][$wpvar]);
elseif ( !empty($perma_query_vars[$wpvar]))
 $this->query_vars[$wpvar] = $perma_query_vars[$wpvar];
if ( !empty($this->query_vars[$wpvar]))
 {$this->query_vars[$wpvar] = (string)$this->query_vars[$wpvar];
if ( in_array($wpvar,$taxonomy_query_vars))
 {$this->query_vars['taxonomy'] = $taxonomy_query_vars[$wpvar];
$this->query_vars['term'] = $this->query_vars[$wpvar];
}}}foreach ( (array)$this->private_query_vars as $var  )
{if ( isset($this->extra_query_vars[$var]))
 $this->query_vars[$var] = $this->extra_query_vars[$var];
elseif ( isset($GLOBALS[0][$var]) && '' != $GLOBALS[0][$var])
 $this->query_vars[$var] = $GLOBALS[0][$var];
}if ( isset($error))
 $this->query_vars['error'] = $error;
$this->query_vars = apply_filters('request',$this->query_vars);
do_action_ref_array('parse_request',array($this));
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function send_headers (  ) {
{$headers = array('X-Pingback' => get_bloginfo('pingback_url'));
$status = null;
$exit_required = false;
if ( is_user_logged_in())
 $headers = array_merge($headers,wp_get_nocache_headers());
if ( !empty($this->query_vars['error']) && '404' == $this->query_vars['error'])
 {$status = 404;
if ( !is_user_logged_in())
 $headers = array_merge($headers,wp_get_nocache_headers());
$headers['Content-Type'] = get_option('html_type') . '; charset=' . get_option('blog_charset');
}else 
{if ( empty($this->query_vars['feed']))
 {$headers['Content-Type'] = get_option('html_type') . '; charset=' . get_option('blog_charset');
}else 
{{if ( !empty($this->query_vars['withcomments']) || (empty($this->query_vars['withoutcomments']) && (!empty($this->query_vars['p']) || !empty($this->query_vars['name']) || !empty($this->query_vars['page_id']) || !empty($this->query_vars['pagename']) || !empty($this->query_vars['attachment']) || !empty($this->query_vars['attachment_id']))))
 $wp_last_modified = mysql2date('D, d M Y H:i:s',get_lastcommentmodified('GMT'),0) . ' GMT';
else 
{$wp_last_modified = mysql2date('D, d M Y H:i:s',get_lastpostmodified('GMT'),0) . ' GMT';
}$wp_etag = '"' . md5($wp_last_modified) . '"';
$headers['Last-Modified'] = $wp_last_modified;
$headers['ETag'] = $wp_etag;
if ( (isset($_SERVER[0]['HTTP_IF_NONE_MATCH']) && Aspis_isset($_SERVER[0]['HTTP_IF_NONE_MATCH'])))
 $client_etag = stripslashes(stripslashes(deAspisWarningRC($_SERVER[0]['HTTP_IF_NONE_MATCH'])));
else 
{$client_etag = false;
}$client_last_modified = (empty($_SERVER[0]['HTTP_IF_MODIFIED_SINCE']) || Aspis_empty($_SERVER[0]['HTTP_IF_MODIFIED_SINCE'])) ? '' : trim(deAspisWarningRC($_SERVER[0]['HTTP_IF_MODIFIED_SINCE']));
$client_modified_timestamp = $client_last_modified ? strtotime($client_last_modified) : 0;
$wp_modified_timestamp = strtotime($wp_last_modified);
if ( ($client_last_modified && $client_etag) ? (($client_modified_timestamp >= $wp_modified_timestamp) && ($client_etag == $wp_etag)) : (($client_modified_timestamp >= $wp_modified_timestamp) || ($client_etag == $wp_etag)))
 {$status = 304;
$exit_required = true;
}}}}$headers = apply_filters('wp_headers',$headers,$this);
if ( !empty($status))
 status_header($status);
foreach ( (array)$headers as $name =>$field_value )
@header("{$name}: {$field_value}");
if ( $exit_required)
 exit();
do_action_ref_array('send_headers',array($this));
} }
function build_query_string (  ) {
{$this->query_string = '';
foreach ( (array)array_keys($this->query_vars) as $wpvar  )
{if ( '' != $this->query_vars[$wpvar])
 {$this->query_string .= (strlen($this->query_string) < 1) ? '' : '&';
if ( !is_scalar($this->query_vars[$wpvar]))
 continue ;
$this->query_string .= $wpvar . '=' . rawurlencode($this->query_vars[$wpvar]);
}}if ( has_filter('query_string'))
 {$this->query_string = apply_filters('query_string',$this->query_string);
parse_str($this->query_string,$this->query_vars);
}} }
function register_globals (  ) {
{{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}foreach ( (array)$wp_query->query_vars as $key =>$value )
{$GLOBALS[0][$key] = $value;
}$GLOBALS[0]['query_string'] = $this->query_string;
$GLOBALS[0]['posts'] = &$wp_query->posts;
$GLOBALS[0]['post'] = $wp_query->post;
$GLOBALS[0]['request'] = $wp_query->request;
if ( is_single() || is_page())
 {$GLOBALS[0]['more'] = 1;
$GLOBALS[0]['single'] = 1;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function init (  ) {
{wp_get_current_user();
} }
function query_posts (  ) {
{{global $wp_the_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_the_query,"\$wp_the_query",$AspisChangesCache);
}$this->build_query_string();
$wp_the_query->query($this->query_vars);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_the_query",$AspisChangesCache);
 }
function handle_404 (  ) {
{{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}if ( (0 == count($wp_query->posts)) && !is_404() && !is_search() && ($this->did_permalink || (!(empty($_SERVER[0]['QUERY_STRING']) || Aspis_empty($_SERVER[0]['QUERY_STRING'])) && (false === strpos(deAspisWarningRC($_SERVER[0]['REQUEST_URI']),'?')))))
 {if ( (is_tag() || is_category() || is_author()) && $wp_query->get_queried_object())
 {if ( !is_404())
 status_header(200);
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return ;
}}$wp_query->set_404();
status_header(404);
nocache_headers();
}elseif ( !is_404())
 {status_header(200);
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function main ( $query_args = '' ) {
{$this->init();
$this->parse_request($query_args);
$this->send_headers();
$this->query_posts();
$this->handle_404();
$this->register_globals();
do_action_ref_array('wp',array($this));
} }
function WP (  ) {
{} }
}class WP_Error{var $errors = array();
var $error_data = array();
function WP_Error ( $code = '',$message = '',$data = '' ) {
{if ( empty($code))
 {return ;
}$this->errors[$code][] = $message;
if ( !empty($data))
 $this->error_data[$code] = $data;
} }
function get_error_codes (  ) {
{if ( empty($this->errors))
 {$AspisRetTemp = array();
return $AspisRetTemp;
}{$AspisRetTemp = array_keys($this->errors);
return $AspisRetTemp;
}} }
function get_error_code (  ) {
{$codes = $this->get_error_codes();
if ( empty($codes))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = $codes[0];
return $AspisRetTemp;
}} }
function get_error_messages ( $code = '' ) {
{if ( empty($code))
 {$all_messages = array();
foreach ( (array)$this->errors as $code =>$messages )
$all_messages = array_merge($all_messages,$messages);
{$AspisRetTemp = $all_messages;
return $AspisRetTemp;
}}if ( isset($this->errors[$code]))
 {$AspisRetTemp = $this->errors[$code];
return $AspisRetTemp;
}else 
{{$AspisRetTemp = array();
return $AspisRetTemp;
}}} }
function get_error_message ( $code = '' ) {
{if ( empty($code))
 $code = $this->get_error_code();
$messages = $this->get_error_messages($code);
if ( empty($messages))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = $messages[0];
return $AspisRetTemp;
}} }
function get_error_data ( $code = '' ) {
{if ( empty($code))
 $code = $this->get_error_code();
if ( isset($this->error_data[$code]))
 {$AspisRetTemp = $this->error_data[$code];
return $AspisRetTemp;
}{$AspisRetTemp = null;
return $AspisRetTemp;
}} }
function add ( $code,$message,$data = '' ) {
{$this->errors[$code][] = $message;
if ( !empty($data))
 $this->error_data[$code] = $data;
} }
function add_data ( $data,$code = '' ) {
{if ( empty($code))
 $code = $this->get_error_code();
$this->error_data[$code] = $data;
} }
}function is_wp_error ( $thing ) {
if ( is_object($thing) && is_a($thing,'WP_Error'))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
class Walker{var $tree_type;
var $db_fields;
var $max_pages = 1;
function start_lvl ( &$output ) {
{} }
function end_lvl ( &$output ) {
{} }
function start_el ( &$output ) {
{} }
function end_el ( &$output ) {
{} }
function display_element ( $element,&$children_elements,$max_depth,$depth = 0,$args,&$output ) {
{if ( !$element)
 {return ;
}$id_field = $this->db_fields['id'];
if ( is_array($args[0]))
 $args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
$cb_args = array_merge(array(&$output,$element,$depth),$args);
AspisUntainted_call_user_func_array(array(&$this,'start_el'),$cb_args);
$id = $element->$id_field;
if ( ($max_depth == 0 || $max_depth > $depth + 1) && isset($children_elements[$id]))
 {foreach ( $children_elements[$id] as $child  )
{if ( !isset($newlevel))
 {$newlevel = true;
$cb_args = array_merge(array(&$output,$depth),$args);
AspisUntainted_call_user_func_array(array(&$this,'start_lvl'),$cb_args);
}$this->display_element($child,$children_elements,$max_depth,$depth + 1,$args,$output);
}unset($children_elements[$id]);
}if ( isset($newlevel) && $newlevel)
 {$cb_args = array_merge(array(&$output,$depth),$args);
AspisUntainted_call_user_func_array(array(&$this,'end_lvl'),$cb_args);
}$cb_args = array_merge(array(&$output,$element,$depth),$args);
AspisUntainted_call_user_func_array(array(&$this,'end_el'),$cb_args);
} }
function walk ( $elements,$max_depth ) {
{$args = array_slice(func_get_args(),2);
$output = '';
if ( $max_depth < -1)
 {$AspisRetTemp = $output;
return $AspisRetTemp;
}if ( empty($elements))
 {$AspisRetTemp = $output;
return $AspisRetTemp;
}$id_field = $this->db_fields['id'];
$parent_field = $this->db_fields['parent'];
if ( -1 == $max_depth)
 {$empty_array = array();
foreach ( $elements as $e  )
$this->display_element($e,$empty_array,1,0,$args,$output);
{$AspisRetTemp = $output;
return $AspisRetTemp;
}}$top_level_elements = array();
$children_elements = array();
foreach ( $elements as $e  )
{if ( 0 == $e->$parent_field)
 $top_level_elements[] = $e;
else 
{$children_elements[$e->$parent_field][] = $e;
}}if ( empty($top_level_elements))
 {$first = array_slice($elements,0,1);
$root = $first[0];
$top_level_elements = array();
$children_elements = array();
foreach ( $elements as $e  )
{if ( $root->$parent_field == $e->$parent_field)
 $top_level_elements[] = $e;
else 
{$children_elements[$e->$parent_field][] = $e;
}}}foreach ( $top_level_elements as $e  )
$this->display_element($e,$children_elements,$max_depth,0,$args,$output);
if ( ($max_depth == 0) && count($children_elements) > 0)
 {$empty_array = array();
foreach ( $children_elements as $orphans  )
foreach ( $orphans as $op  )
$this->display_element($op,$empty_array,1,0,$args,$output);
}{$AspisRetTemp = $output;
return $AspisRetTemp;
}} }
function paged_walk ( $elements,$max_depth,$page_num,$per_page ) {
{if ( empty($elements) || $max_depth < -1)
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$args = array_slice(func_get_args(),4);
$output = '';
$id_field = $this->db_fields['id'];
$parent_field = $this->db_fields['parent'];
$count = -1;
if ( -1 == $max_depth)
 $total_top = count($elements);
if ( $page_num < 1 || $per_page < 0)
 {$paging = false;
$start = 0;
if ( -1 == $max_depth)
 $end = $total_top;
$this->max_pages = 1;
}else 
{{$paging = true;
$start = ((int)$page_num - 1) * (int)$per_page;
$end = $start + $per_page;
if ( -1 == $max_depth)
 $this->max_pages = ceil($total_top / $per_page);
}}if ( -1 == $max_depth)
 {if ( !empty($args[0]['reverse_top_level']))
 {$elements = array_reverse($elements);
$oldstart = $start;
$start = $total_top - $end;
$end = $total_top - $oldstart;
}$empty_array = array();
foreach ( $elements as $e  )
{$count++;
if ( $count < $start)
 continue ;
if ( $count >= $end)
 break ;
$this->display_element($e,$empty_array,1,0,$args,$output);
}{$AspisRetTemp = $output;
return $AspisRetTemp;
}}$top_level_elements = array();
$children_elements = array();
foreach ( $elements as $e  )
{if ( 0 == $e->$parent_field)
 $top_level_elements[] = $e;
else 
{$children_elements[$e->$parent_field][] = $e;
}}$total_top = count($top_level_elements);
if ( $paging)
 $this->max_pages = ceil($total_top / $per_page);
else 
{$end = $total_top;
}if ( !empty($args[0]['reverse_top_level']))
 {$top_level_elements = array_reverse($top_level_elements);
$oldstart = $start;
$start = $total_top - $end;
$end = $total_top - $oldstart;
}if ( !empty($args[0]['reverse_children']))
 {foreach ( $children_elements as $parent =>$children )
$children_elements[$parent] = array_reverse($children);
}foreach ( $top_level_elements as $e  )
{$count++;
if ( $end >= $total_top && $count < $start)
 $this->unset_children($e,$children_elements);
if ( $count < $start)
 continue ;
if ( $count >= $end)
 break ;
$this->display_element($e,$children_elements,$max_depth,0,$args,$output);
}if ( $end >= $total_top && count($children_elements) > 0)
 {$empty_array = array();
foreach ( $children_elements as $orphans  )
foreach ( $orphans as $op  )
$this->display_element($op,$empty_array,1,0,$args,$output);
}{$AspisRetTemp = $output;
return $AspisRetTemp;
}} }
function get_number_of_root_elements ( $elements ) {
{$num = 0;
$parent_field = $this->db_fields['parent'];
foreach ( $elements as $e  )
{if ( 0 == $e->$parent_field)
 $num++;
}{$AspisRetTemp = $num;
return $AspisRetTemp;
}} }
function unset_children ( $e,&$children_elements ) {
{if ( !$e || !$children_elements)
 {return ;
}$id_field = $this->db_fields['id'];
$id = $e->$id_field;
if ( !empty($children_elements[$id]) && is_array($children_elements[$id]))
 foreach ( (array)$children_elements[$id] as $child  )
$this->unset_children($child,$children_elements);
if ( isset($children_elements[$id]))
 unset($children_elements[$id]);
} }
}class Walker_Page extends Walker{var $tree_type = 'page';
var $db_fields = array('parent' => 'post_parent','id' => 'ID');
function start_lvl ( &$output,$depth ) {
{$indent = str_repeat("\t",$depth);
$output .= "\n$indent<ul>\n";
} }
function end_lvl ( &$output,$depth ) {
{$indent = str_repeat("\t",$depth);
$output .= "$indent</ul>\n";
} }
function start_el ( &$output,$page,$depth,$args,$current_page ) {
{if ( $depth)
 $indent = str_repeat("\t",$depth);
else 
{$indent = '';
}extract(($args),EXTR_SKIP);
$css_class = array('page_item','page-item-' . $page->ID);
if ( !empty($current_page))
 {$_current_page = get_page($current_page);
if ( isset($_current_page->ancestors) && in_array($page->ID,(array)$_current_page->ancestors))
 $css_class[] = 'current_page_ancestor';
if ( $page->ID == $current_page)
 $css_class[] = 'current_page_item';
elseif ( $_current_page && $page->ID == $_current_page->post_parent)
 $css_class[] = 'current_page_parent';
}elseif ( $page->ID == get_option('page_for_posts'))
 {$css_class[] = 'current_page_parent';
}$css_class = implode(' ',apply_filters('page_css_class',$css_class,$page));
$output .= $indent . '<li class="' . $css_class . '"><a href="' . get_page_link($page->ID) . '" title="' . esc_attr(apply_filters('the_title',$page->post_title)) . '">' . $link_before . apply_filters('the_title',$page->post_title) . $link_after . '</a>';
if ( !empty($show_date))
 {if ( 'modified' == $show_date)
 $time = $page->post_modified;
else 
{$time = $page->post_date;
}$output .= " " . mysql2date($date_format,$time);
}} }
function end_el ( &$output,$page,$depth ) {
{$output .= "</li>\n";
} }
}class Walker_PageDropdown extends Walker{var $tree_type = 'page';
var $db_fields = array('parent' => 'post_parent','id' => 'ID');
function start_el ( &$output,$page,$depth,$args ) {
{$pad = str_repeat('&nbsp;',$depth * 3);
$output .= "\t<option class=\"level-$depth\" value=\"$page->ID\"";
if ( $page->ID == $args['selected'])
 $output .= ' selected="selected"';
$output .= '>';
$title = esc_html($page->post_title);
$output .= "$pad$title";
$output .= "</option>\n";
} }
}class Walker_Category extends Walker{var $tree_type = 'category';
var $db_fields = array('parent' => 'parent','id' => 'term_id');
function start_lvl ( &$output,$depth,$args ) {
{if ( 'list' != $args['style'])
 {return ;
}$indent = str_repeat("\t",$depth);
$output .= "$indent<ul class='children'>\n";
} }
function end_lvl ( &$output,$depth,$args ) {
{if ( 'list' != $args['style'])
 {return ;
}$indent = str_repeat("\t",$depth);
$output .= "$indent</ul>\n";
} }
function start_el ( &$output,$category,$depth,$args ) {
{extract(($args));
$cat_name = esc_attr($category->name);
$cat_name = apply_filters('list_cats',$cat_name,$category);
$link = '<a href="' . get_category_link($category->term_id) . '" ';
if ( $use_desc_for_title == 0 || empty($category->description))
 $link .= 'title="' . sprintf(__('View all posts filed under %s'),$cat_name) . '"';
else 
{$link .= 'title="' . esc_attr(strip_tags(apply_filters('category_description',$category->description,$category))) . '"';
}$link .= '>';
$link .= $cat_name . '</a>';
if ( (!empty($feed_image)) || (!empty($feed)))
 {$link .= ' ';
if ( empty($feed_image))
 $link .= '(';
$link .= '<a href="' . get_category_feed_link($category->term_id,$feed_type) . '"';
if ( empty($feed))
 $alt = ' alt="' . sprintf(__('Feed for all posts filed under %s'),$cat_name) . '"';
else 
{{$title = ' title="' . $feed . '"';
$alt = ' alt="' . $feed . '"';
$name = $feed;
$link .= $title;
}}$link .= '>';
if ( empty($feed_image))
 $link .= $name;
else 
{$link .= "<img src='$feed_image'$alt$title" . ' />';
}$link .= '</a>';
if ( empty($feed_image))
 $link .= ')';
}if ( isset($show_count) && $show_count)
 $link .= ' (' . intval($category->count) . ')';
if ( isset($show_date) && $show_date)
 {$link .= ' ' . gmdate('Y-m-d',$category->last_update_timestamp);
}if ( isset($current_category) && $current_category)
 $_current_category = get_category($current_category);
if ( 'list' == $args['style'])
 {$output .= "\t<li";
$class = 'cat-item cat-item-' . $category->term_id;
if ( isset($current_category) && $current_category && ($category->term_id == $current_category))
 $class .= ' current-cat';
elseif ( isset($_current_category) && $_current_category && ($category->term_id == $_current_category->parent))
 $class .= ' current-cat-parent';
$output .= ' class="' . $class . '"';
$output .= ">$link\n";
}else 
{{$output .= "\t$link<br />\n";
}}} }
function end_el ( &$output,$page,$depth,$args ) {
{if ( 'list' != $args['style'])
 {return ;
}$output .= "</li>\n";
} }
}class Walker_CategoryDropdown extends Walker{var $tree_type = 'category';
var $db_fields = array('parent' => 'parent','id' => 'term_id');
function start_el ( &$output,$category,$depth,$args ) {
{$pad = str_repeat('&nbsp;',$depth * 3);
$cat_name = apply_filters('list_cats',$category->name,$category);
$output .= "\t<option class=\"level-$depth\" value=\"" . $category->term_id . "\"";
if ( $category->term_id == $args['selected'])
 $output .= ' selected="selected"';
$output .= '>';
$output .= $pad . $cat_name;
if ( $args['show_count'])
 $output .= '&nbsp;&nbsp;(' . $category->count . ')';
if ( $args['show_last_update'])
 {$format = 'Y-m-d';
$output .= '&nbsp;&nbsp;' . gmdate($format,$category->last_update_timestamp);
}$output .= "</option>\n";
} }
}class WP_Ajax_Response{var $responses = array();
function WP_Ajax_Response ( $args = '' ) {
{if ( !empty($args))
 $this->add($args);
} }
function add ( $args = '' ) {
{$defaults = array('what' => 'object','action' => false,'id' => '0','old_id' => false,'position' => 1,'data' => '','supplemental' => array());
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
$position = preg_replace('/[^a-z0-9:_-]/i','',$position);
if ( is_wp_error($id))
 {$data = $id;
$id = 0;
}$response = '';
if ( is_wp_error($data))
 {foreach ( (array)$data->get_error_codes() as $code  )
{$response .= "<wp_error code='$code'><![CDATA[" . $data->get_error_message($code) . "]]></wp_error>";
if ( !$error_data = $data->get_error_data($code))
 continue ;
$class = '';
if ( is_object($error_data))
 {$class = ' class="' . get_class($error_data) . '"';
$error_data = get_object_vars($error_data);
}$response .= "<wp_error_data code='$code'$class>";
if ( is_scalar($error_data))
 {$response .= "<![CDATA[$error_data]]>";
}elseif ( is_array($error_data))
 {foreach ( $error_data as $k =>$v )
$response .= "<$k><![CDATA[$v]]></$k>";
}$response .= "</wp_error_data>";
}}else 
{{$response = "<response_data><![CDATA[$data]]></response_data>";
}}$s = '';
if ( is_array($supplemental))
 {foreach ( $supplemental as $k =>$v )
$s .= "<$k><![CDATA[$v]]></$k>";
$s = "<supplemental>$s</supplemental>";
}if ( false === $action)
 $action = deAspisWarningRC($_POST[0]['action']);
$x = '';
$x .= "<response action='{$action}_$id'>";
$x .= "<$what id='$id' " . (false === $old_id ? '' : "old_id='$old_id' ") . "position='$position'>";
$x .= $response;
$x .= $s;
$x .= "</$what>";
$x .= "</response>";
$this->responses[] = $x;
{$AspisRetTemp = $x;
return $AspisRetTemp;
}} }
function send (  ) {
{header('Content-Type: text/xml');
echo "<?xml version='1.0' standalone='yes'?><wp_ajax>";
foreach ( (array)$this->responses as $response  )
echo $response;
echo '</wp_ajax>';
exit();
} }
}class WP_MatchesMapRegex{var $_matches;
var $output;
var $_subject;
var $_pattern = '(\$matches\[[1-9]+[0-9]*\])';
function WP_MatchesMapRegex ( $subject,$matches ) {
{$this->_subject = $subject;
$this->_matches = $matches;
$this->output = $this->_map();
} }
function apply ( $subject,$matches ) {
{$oSelf = &new WP_MatchesMapRegex($subject,$matches);
{$AspisRetTemp = $oSelf->output;
return $AspisRetTemp;
}} }
function _map (  ) {
{$callback = array(&$this,'callback');
{$AspisRetTemp = preg_replace_callback($this->_pattern,$callback,$this->_subject);
return $AspisRetTemp;
}} }
function callback ( $matches ) {
{$index = intval(substr($matches[0],9,-1));
{$AspisRetTemp = (isset($this->_matches[$index]) ? $this->_matches[$index] : '');
return $AspisRetTemp;
}} }
};
?>
<?php 