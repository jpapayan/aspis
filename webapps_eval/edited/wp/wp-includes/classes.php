<?php require_once('AspisMain.php'); ?><?php
class WP{var $public_query_vars = array(array(array('m',false),array('p',false),array('posts',false),array('w',false),array('cat',false),array('withcomments',false),array('withoutcomments',false),array('s',false),array('search',false),array('exact',false),array('sentence',false),array('debug',false),array('calendar',false),array('page',false),array('paged',false),array('more',false),array('tb',false),array('pb',false),array('author',false),array('order',false),array('orderby',false),array('year',false),array('monthnum',false),array('day',false),array('hour',false),array('minute',false),array('second',false),array('name',false),array('category_name',false),array('tag',false),array('feed',false),array('author_name',false),array('static',false),array('pagename',false),array('page_id',false),array('error',false),array('comments_popup',false),array('attachment',false),array('attachment_id',false),array('subpost',false),array('subpost_id',false),array('preview',false),array('robots',false),array('taxonomy',false),array('term',false),array('cpage',false)),false);
var $private_query_vars = array(array(array('offset',false),array('posts_per_page',false),array('posts_per_archive_page',false),array('showposts',false),array('nopaging',false),array('post_type',false),array('post_status',false),array('category__in',false),array('category__not_in',false),array('category__and',false),array('tag__in',false),array('tag__not_in',false),array('tag__and',false),array('tag_slug__in',false),array('tag_slug__and',false),array('tag_id',false),array('post_mime_type',false),array('perm',false),array('comments_per_page',false)),false);
var $extra_query_vars = array(array(),false);
var $query_vars;
var $query_string;
var $request;
var $matched_rule;
var $matched_query;
var $did_permalink = array(false,false);
function add_query_var ( $qv ) {
{if ( (denot_boolean(Aspis_in_array($qv,$this->public_query_vars))))
 arrayAssignAdd($this->public_query_vars[0][],addTaint($qv));
} }
function set_query_var ( $key,$value ) {
{arrayAssign($this->query_vars[0],deAspis(registerTaint($key)),addTaint($value));
} }
function parse_request ( $extra_query_vars = array('',false) ) {
{global $wp_rewrite;
$this->query_vars = array(array(),false);
$taxonomy_query_vars = array(array(),false);
if ( is_array($extra_query_vars[0]))
 $this->extra_query_vars = &$extra_query_vars;
else 
{if ( (!((empty($extra_query_vars) || Aspis_empty( $extra_query_vars)))))
 AspisInternalFunctionCall("parse_str",$extra_query_vars[0],AspisPushRefParam($this->extra_query_vars),array(1));
}$rewrite = $wp_rewrite[0]->wp_rewrite_rules();
if ( (!((empty($rewrite) || Aspis_empty( $rewrite)))))
 {$error = array('404',false);
$this->did_permalink = array(true,false);
if ( ((isset($_SERVER[0][('PATH_INFO')]) && Aspis_isset( $_SERVER [0][('PATH_INFO')]))))
 $pathinfo = $_SERVER[0]['PATH_INFO'];
else 
{$pathinfo = array('',false);
}$pathinfo_array = Aspis_explode(array('?',false),$pathinfo);
$pathinfo = Aspis_str_replace(array("%",false),array("%25",false),attachAspis($pathinfo_array,(0)));
$req_uri = $_SERVER[0]['REQUEST_URI'];
$req_uri_array = Aspis_explode(array('?',false),$req_uri);
$req_uri = attachAspis($req_uri_array,(0));
$self = $_SERVER[0]['PHP_SELF'];
$home_path = Aspis_parse_url(get_option(array('home',false)));
if ( ((isset($home_path[0][('path')]) && Aspis_isset( $home_path [0][('path')]))))
 $home_path = $home_path[0]['path'];
else 
{$home_path = array('',false);
}$home_path = Aspis_trim($home_path,array('/',false));
$req_uri = Aspis_str_replace($pathinfo,array('',false),Aspis_rawurldecode($req_uri));
$req_uri = Aspis_trim($req_uri,array('/',false));
$req_uri = Aspis_preg_replace(concat2(concat1("|^",$home_path),"|"),array('',false),$req_uri);
$req_uri = Aspis_trim($req_uri,array('/',false));
$pathinfo = Aspis_trim($pathinfo,array('/',false));
$pathinfo = Aspis_preg_replace(concat2(concat1("|^",$home_path),"|"),array('',false),$pathinfo);
$pathinfo = Aspis_trim($pathinfo,array('/',false));
$self = Aspis_trim($self,array('/',false));
$self = Aspis_preg_replace(concat2(concat1("|^",$home_path),"|"),array('',false),$self);
$self = Aspis_trim($self,array('/',false));
if ( ((!((empty($pathinfo) || Aspis_empty( $pathinfo)))) && (denot_boolean(Aspis_preg_match(concat2(concat1('|^.*',$wp_rewrite[0]->index),'$|'),$pathinfo)))))
 {$request = $pathinfo;
}else 
{{if ( ($req_uri[0] == $wp_rewrite[0]->index[0]))
 $req_uri = array('',false);
$request = $req_uri;
}}$this->request = $request;
$request_match = $request;
foreach ( deAspis(array_cast($rewrite)) as $match =>$query )
{restoreTaint($match,$query);
{if ( ($req_uri[0] == ('wp-app.php')))
 break ;
if ( (((!((empty($req_uri) || Aspis_empty( $req_uri)))) && (strpos($match[0],deAspisRC($req_uri)) === (0))) && ($req_uri[0] != $request[0])))
 {$request_match = concat(concat2($req_uri,'/'),$request);
}if ( (deAspis(Aspis_preg_match(concat2(concat1("#^",$match),"#"),$request_match,$matches)) || deAspis(Aspis_preg_match(concat2(concat1("#^",$match),"#"),Aspis_urldecode($request_match),$matches))))
 {$this->matched_rule = $match;
$query = Aspis_preg_replace(array("!^.+\?!",false),array('',false),$query);
$query = Aspis_addslashes(WP_MatchesMapRegex::apply($query,$matches));
$this->matched_query = $query;
AspisInternalFunctionCall("parse_str",$query[0],AspisPushRefParam($perma_query_vars),array(1));
if ( ((isset($_GET[0][('error')]) && Aspis_isset( $_GET [0][('error')]))))
 unset($_GET[0][('error')]);
if ( ((isset($error) && Aspis_isset( $error))))
 unset($error);
break ;
}}}if ( ((((empty($request) || Aspis_empty( $request))) || ($req_uri[0] == $self[0])) || (strpos(deAspis($_SERVER[0]['PHP_SELF']),'wp-admin/') !== false)))
 {if ( ((isset($_GET[0][('error')]) && Aspis_isset( $_GET [0][('error')]))))
 unset($_GET[0][('error')]);
if ( ((isset($error) && Aspis_isset( $error))))
 unset($error);
if ( (((isset($perma_query_vars) && Aspis_isset( $perma_query_vars))) && (strpos(deAspis($_SERVER[0]['PHP_SELF']),'wp-admin/') !== false)))
 unset($perma_query_vars);
$this->did_permalink = array(false,false);
}}$this->public_query_vars = apply_filters(array('query_vars',false),$this->public_query_vars);
foreach ( deAspis($GLOBALS[0]['wp_taxonomies']) as $taxonomy =>$t )
{restoreTaint($taxonomy,$t);
if ( $t[0]->query_var[0])
 arrayAssign($taxonomy_query_vars[0],deAspis(registerTaint($t[0]->query_var)),addTaint($taxonomy));
}for ( $i = array(0,false) ; ($i[0] < count($this->public_query_vars[0])) ; $i = array((1) + $i[0],false) )
{$wpvar = $this->public_query_vars[0][$i[0]];
if ( ((isset($this->extra_query_vars[0][$wpvar[0]]) && Aspis_isset( $this ->extra_query_vars [0][$wpvar[0]] ))))
 arrayAssign($this->query_vars[0],deAspis(registerTaint($wpvar)),addTaint($this->extra_query_vars[0][$wpvar[0]]));
elseif ( ((isset($GLOBALS[0][$wpvar[0]]) && Aspis_isset( $GLOBALS [0][$wpvar[0]]))))
 arrayAssign($this->query_vars[0],deAspis(registerTaint($wpvar)),addTaint(attachAspis($GLOBALS,$wpvar[0])));
elseif ( (!((empty($_POST[0][$wpvar[0]]) || Aspis_empty( $_POST [0][$wpvar[0]])))))
 arrayAssign($this->query_vars[0],deAspis(registerTaint($wpvar)),addTaint(attachAspis($_POST,$wpvar[0])));
elseif ( (!((empty($_GET[0][$wpvar[0]]) || Aspis_empty( $_GET [0][$wpvar[0]])))))
 arrayAssign($this->query_vars[0],deAspis(registerTaint($wpvar)),addTaint(attachAspis($_GET,$wpvar[0])));
elseif ( (!((empty($perma_query_vars[0][$wpvar[0]]) || Aspis_empty( $perma_query_vars [0][$wpvar[0]])))))
 arrayAssign($this->query_vars[0],deAspis(registerTaint($wpvar)),addTaint(attachAspis($perma_query_vars,$wpvar[0])));
if ( (!((empty($this->query_vars[0][$wpvar[0]]) || Aspis_empty( $this ->query_vars [0][$wpvar[0]] )))))
 {arrayAssign($this->query_vars[0],deAspis(registerTaint($wpvar)),addTaint(string_cast($this->query_vars[0][$wpvar[0]])));
if ( deAspis(Aspis_in_array($wpvar,$taxonomy_query_vars)))
 {arrayAssign($this->query_vars[0],deAspis(registerTaint(array('taxonomy',false))),addTaint(attachAspis($taxonomy_query_vars,$wpvar[0])));
arrayAssign($this->query_vars[0],deAspis(registerTaint(array('term',false))),addTaint($this->query_vars[0][$wpvar[0]]));
}}}foreach ( deAspis(array_cast($this->private_query_vars)) as $var  )
{if ( ((isset($this->extra_query_vars[0][$var[0]]) && Aspis_isset( $this ->extra_query_vars [0][$var[0]] ))))
 arrayAssign($this->query_vars[0],deAspis(registerTaint($var)),addTaint($this->extra_query_vars[0][$var[0]]));
elseif ( (((isset($GLOBALS[0][$var[0]]) && Aspis_isset( $GLOBALS [0][$var[0]]))) && (('') != deAspis(attachAspis($GLOBALS,$var[0])))))
 arrayAssign($this->query_vars[0],deAspis(registerTaint($var)),addTaint(attachAspis($GLOBALS,$var[0])));
}if ( ((isset($error) && Aspis_isset( $error))))
 arrayAssign($this->query_vars[0],deAspis(registerTaint(array('error',false))),addTaint($error));
$this->query_vars = apply_filters(array('request',false),$this->query_vars);
do_action_ref_array(array('parse_request',false),array(array(array($this,false)),false));
} }
function send_headers (  ) {
{$headers = array(array(deregisterTaint(array('X-Pingback',false)) => addTaint(get_bloginfo(array('pingback_url',false)))),false);
$status = array(null,false);
$exit_required = array(false,false);
if ( deAspis(is_user_logged_in()))
 $headers = Aspis_array_merge($headers,wp_get_nocache_headers());
if ( ((!((empty($this->query_vars[0][('error')]) || Aspis_empty( $this ->query_vars [0][('error')] )))) && (('404') == $this->query_vars[0][('error')][0])))
 {$status = array(404,false);
if ( (denot_boolean(is_user_logged_in())))
 $headers = Aspis_array_merge($headers,wp_get_nocache_headers());
arrayAssign($headers[0],deAspis(registerTaint(array('Content-Type',false))),addTaint(concat(concat2(get_option(array('html_type',false)),'; charset='),get_option(array('blog_charset',false)))));
}else 
{if ( ((empty($this->query_vars[0][('feed')]) || Aspis_empty( $this ->query_vars [0][('feed')] ))))
 {arrayAssign($headers[0],deAspis(registerTaint(array('Content-Type',false))),addTaint(concat(concat2(get_option(array('html_type',false)),'; charset='),get_option(array('blog_charset',false)))));
}else 
{{if ( ((!((empty($this->query_vars[0][('withcomments')]) || Aspis_empty( $this ->query_vars [0][('withcomments')] )))) || (((empty($this->query_vars[0][('withoutcomments')]) || Aspis_empty( $this ->query_vars [0][('withoutcomments')] ))) && ((((((!((empty($this->query_vars[0][('p')]) || Aspis_empty( $this ->query_vars [0][('p')] )))) || (!((empty($this->query_vars[0][('name')]) || Aspis_empty( $this ->query_vars [0][('name')] ))))) || (!((empty($this->query_vars[0][('page_id')]) || Aspis_empty( $this ->query_vars [0][('page_id')] ))))) || (!((empty($this->query_vars[0][('pagename')]) || Aspis_empty( $this ->query_vars [0][('pagename')] ))))) || (!((empty($this->query_vars[0][('attachment')]) || Aspis_empty( $this ->query_vars [0][('attachment')] ))))) || (!((empty($this->query_vars[0][('attachment_id')]) || Aspis_empty( $this ->query_vars [0][('attachment_id')] ))))))))
 $wp_last_modified = concat2(mysql2date(array('D, d M Y H:i:s',false),get_lastcommentmodified(array('GMT',false)),array(0,false)),' GMT');
else 
{$wp_last_modified = concat2(mysql2date(array('D, d M Y H:i:s',false),get_lastpostmodified(array('GMT',false)),array(0,false)),' GMT');
}$wp_etag = concat2(concat1('"',attAspis(md5($wp_last_modified[0]))),'"');
arrayAssign($headers[0],deAspis(registerTaint(array('Last-Modified',false))),addTaint($wp_last_modified));
arrayAssign($headers[0],deAspis(registerTaint(array('ETag',false))),addTaint($wp_etag));
if ( ((isset($_SERVER[0][('HTTP_IF_NONE_MATCH')]) && Aspis_isset( $_SERVER [0][('HTTP_IF_NONE_MATCH')]))))
 $client_etag = Aspis_stripslashes(Aspis_stripslashes($_SERVER[0]['HTTP_IF_NONE_MATCH']));
else 
{$client_etag = array(false,false);
}$client_last_modified = ((empty($_SERVER[0][('HTTP_IF_MODIFIED_SINCE')]) || Aspis_empty( $_SERVER [0][('HTTP_IF_MODIFIED_SINCE')]))) ? array('',false) : Aspis_trim($_SERVER[0]['HTTP_IF_MODIFIED_SINCE']);
$client_modified_timestamp = $client_last_modified[0] ? attAspis(strtotime($client_last_modified[0])) : array(0,false);
$wp_modified_timestamp = attAspis(strtotime($wp_last_modified[0]));
if ( (($client_last_modified[0] && $client_etag[0]) ? (($client_modified_timestamp[0] >= $wp_modified_timestamp[0]) && ($client_etag[0] == $wp_etag[0])) : (($client_modified_timestamp[0] >= $wp_modified_timestamp[0]) || ($client_etag[0] == $wp_etag[0]))))
 {$status = array(304,false);
$exit_required = array(true,false);
}}}}$headers = apply_filters(array('wp_headers',false),$headers,array($this,false));
if ( (!((empty($status) || Aspis_empty( $status)))))
 status_header($status);
foreach ( deAspis(array_cast($headers)) as $name =>$field_value )
{restoreTaint($name,$field_value);
@header((deconcat(concat2($name,": "),$field_value)));
}if ( $exit_required[0])
 Aspis_exit();
do_action_ref_array(array('send_headers',false),array(array(array($this,false)),false));
} }
function build_query_string (  ) {
{$this->query_string = array('',false);
foreach ( deAspis(array_cast(attAspisRC(array_keys(deAspisRC($this->query_vars))))) as $wpvar  )
{if ( (('') != $this->query_vars[0][$wpvar[0]][0]))
 {$this->query_string = concat($this->query_string ,(strlen($this->query_string[0]) < (1)) ? array('',false) : array('&',false));
if ( (!(is_scalar(deAspisRC($this->query_vars[0][$wpvar[0]])))))
 continue ;
$this->query_string = concat($this->query_string ,concat(concat2($wpvar,'='),Aspis_rawurlencode($this->query_vars[0][$wpvar[0]])));
}}if ( deAspis(has_filter(array('query_string',false))))
 {$this->query_string = apply_filters(array('query_string',false),$this->query_string);
AspisInternalFunctionCall("parse_str",$this->query_string[0],AspisPushRefParam($this->query_vars),array(1));
}} }
function register_globals (  ) {
{global $wp_query;
foreach ( deAspis(array_cast($wp_query[0]->query_vars)) as $key =>$value )
{restoreTaint($key,$value);
{arrayAssign($GLOBALS[0],deAspis(registerTaint($key)),addTaint($value));
}}arrayAssign($GLOBALS[0],deAspis(registerTaint(array('query_string',false))),addTaint($this->query_string));
$GLOBALS[0][deAspis(registerTaint(array('posts',false)))] = &addTaintR($wp_query[0]->posts);
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('post',false))),addTaint($wp_query[0]->post));
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('request',false))),addTaint($wp_query[0]->request));
if ( (deAspis(is_single()) || deAspis(is_page())))
 {arrayAssign($GLOBALS[0],deAspis(registerTaint(array('more',false))),addTaint(array(1,false)));
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('single',false))),addTaint(array(1,false)));
}} }
function init (  ) {
{wp_get_current_user();
} }
function query_posts (  ) {
{global $wp_the_query;
$this->build_query_string();
$wp_the_query[0]->query($this->query_vars);
} }
function handle_404 (  ) {
{global $wp_query;
if ( (((((0) == count($wp_query[0]->posts[0])) && (denot_boolean(is_404()))) && (denot_boolean(is_search()))) && ($this->did_permalink[0] || ((!((empty($_SERVER[0][('QUERY_STRING')]) || Aspis_empty( $_SERVER [0][('QUERY_STRING')])))) && (false === strpos(deAspis($_SERVER[0]['REQUEST_URI']),'?'))))))
 {if ( (((deAspis(is_tag()) || deAspis(is_category())) || deAspis(is_author())) && deAspis($wp_query[0]->get_queried_object())))
 {if ( (denot_boolean(is_404())))
 status_header(array(200,false));
return ;
}$wp_query[0]->set_404();
status_header(array(404,false));
nocache_headers();
}elseif ( (denot_boolean(is_404())))
 {status_header(array(200,false));
}} }
function main ( $query_args = array('',false) ) {
{$this->init();
$this->parse_request($query_args);
$this->send_headers();
$this->query_posts();
$this->handle_404();
$this->register_globals();
do_action_ref_array(array('wp',false),array(array(array($this,false)),false));
} }
function WP (  ) {
{} }
}class WP_Error{var $errors = array(array(),false);
var $error_data = array(array(),false);
function WP_Error ( $code = array('',false),$message = array('',false),$data = array('',false) ) {
{if ( ((empty($code) || Aspis_empty( $code))))
 return ;
arrayAssignAdd($this->errors[0][$code[0]][0][],addTaint($message));
if ( (!((empty($data) || Aspis_empty( $data)))))
 arrayAssign($this->error_data[0],deAspis(registerTaint($code)),addTaint($data));
} }
function get_error_codes (  ) {
{if ( ((empty($this->errors) || Aspis_empty( $this ->errors ))))
 return array(array(),false);
return attAspisRC(array_keys(deAspisRC($this->errors)));
} }
function get_error_code (  ) {
{$codes = $this->get_error_codes();
if ( ((empty($codes) || Aspis_empty( $codes))))
 return array('',false);
return attachAspis($codes,(0));
} }
function get_error_messages ( $code = array('',false) ) {
{if ( ((empty($code) || Aspis_empty( $code))))
 {$all_messages = array(array(),false);
foreach ( deAspis(array_cast($this->errors)) as $code =>$messages )
{restoreTaint($code,$messages);
$all_messages = Aspis_array_merge($all_messages,$messages);
}return $all_messages;
}if ( ((isset($this->errors[0][$code[0]]) && Aspis_isset( $this ->errors [0][$code[0]] ))))
 return $this->errors[0][$code[0]];
else 
{return array(array(),false);
}} }
function get_error_message ( $code = array('',false) ) {
{if ( ((empty($code) || Aspis_empty( $code))))
 $code = $this->get_error_code();
$messages = $this->get_error_messages($code);
if ( ((empty($messages) || Aspis_empty( $messages))))
 return array('',false);
return attachAspis($messages,(0));
} }
function get_error_data ( $code = array('',false) ) {
{if ( ((empty($code) || Aspis_empty( $code))))
 $code = $this->get_error_code();
if ( ((isset($this->error_data[0][$code[0]]) && Aspis_isset( $this ->error_data [0][$code[0]] ))))
 return $this->error_data[0][$code[0]];
return array(null,false);
} }
function add ( $code,$message,$data = array('',false) ) {
{arrayAssignAdd($this->errors[0][$code[0]][0][],addTaint($message));
if ( (!((empty($data) || Aspis_empty( $data)))))
 arrayAssign($this->error_data[0],deAspis(registerTaint($code)),addTaint($data));
} }
function add_data ( $data,$code = array('',false) ) {
{if ( ((empty($code) || Aspis_empty( $code))))
 $code = $this->get_error_code();
arrayAssign($this->error_data[0],deAspis(registerTaint($code)),addTaint($data));
} }
}function is_wp_error ( $thing ) {
if ( (is_object($thing[0]) && is_a(deAspisRC($thing),('WP_Error'))))
 return array(true,false);
return array(false,false);
 }
class Walker{var $tree_type;
var $db_fields;
var $max_pages = array(1,false);
function start_lvl ( &$output ) {
{} }
function end_lvl ( &$output ) {
{} }
function start_el ( &$output ) {
{} }
function end_el ( &$output ) {
{} }
function display_element ( $element,&$children_elements,$max_depth,$depth = array(0,false),$args,&$output ) {
{if ( (denot_boolean($element)))
 return ;
$id_field = $this->db_fields[0][('id')];
if ( is_array(deAspis(attachAspis($args,(0)))))
 arrayAssign($args[0][(0)][0],deAspis(registerTaint(array('has_children',false))),addTaint(not_boolean(array((empty($children_elements[0][deAspis($element[0]->$id_field[0])]) || Aspis_empty( $children_elements [0][deAspis($element[0] ->$id_field[0] )])),false))));
$cb_args = Aspis_array_merge(array(array(&$output,$element,$depth),false),$args);
Aspis_call_user_func_array(array(array(array($this,false),array('start_el',false)),false),$cb_args);
$id = $element[0]->$id_field[0];
if ( ((($max_depth[0] == (0)) || ($max_depth[0] > ($depth[0] + (1)))) && ((isset($children_elements[0][$id[0]]) && Aspis_isset( $children_elements [0][$id[0]])))))
 {foreach ( deAspis(attachAspis($children_elements,$id[0])) as $child  )
{if ( (!((isset($newlevel) && Aspis_isset( $newlevel)))))
 {$newlevel = array(true,false);
$cb_args = Aspis_array_merge(array(array(&$output,$depth),false),$args);
Aspis_call_user_func_array(array(array(array($this,false),array('start_lvl',false)),false),$cb_args);
}$this->display_element($child,$children_elements,$max_depth,array($depth[0] + (1),false),$args,$output);
}unset($children_elements[0][$id[0]]);
}if ( (((isset($newlevel) && Aspis_isset( $newlevel))) && $newlevel[0]))
 {$cb_args = Aspis_array_merge(array(array(&$output,$depth),false),$args);
Aspis_call_user_func_array(array(array(array($this,false),array('end_lvl',false)),false),$cb_args);
}$cb_args = Aspis_array_merge(array(array(&$output,$element,$depth),false),$args);
Aspis_call_user_func_array(array(array(array($this,false),array('end_el',false)),false),$cb_args);
} }
function walk ( $elements,$max_depth ) {
{$args = Aspis_array_slice(array(func_get_args(),false),array(2,false));
$output = array('',false);
if ( ($max_depth[0] < deAspis(negate(array(1,false)))))
 return $output;
if ( ((empty($elements) || Aspis_empty( $elements))))
 return $output;
$id_field = $this->db_fields[0][('id')];
$parent_field = $this->db_fields[0][('parent')];
if ( (deAspis(negate(array(1,false))) == $max_depth[0]))
 {$empty_array = array(array(),false);
foreach ( $elements[0] as $e  )
$this->display_element($e,$empty_array,array(1,false),array(0,false),$args,$output);
return $output;
}$top_level_elements = array(array(),false);
$children_elements = array(array(),false);
foreach ( $elements[0] as $e  )
{if ( ((0) == deAspis($e[0]->$parent_field[0])))
 arrayAssignAdd($top_level_elements[0][],addTaint($e));
else 
{arrayAssignAdd($children_elements[0][deAspis($e[0]->$parent_field[0])][0][],addTaint($e));
}}if ( ((empty($top_level_elements) || Aspis_empty( $top_level_elements))))
 {$first = Aspis_array_slice($elements,array(0,false),array(1,false));
$root = attachAspis($first,(0));
$top_level_elements = array(array(),false);
$children_elements = array(array(),false);
foreach ( $elements[0] as $e  )
{if ( (deAspis($root[0]->$parent_field[0]) == deAspis($e[0]->$parent_field[0])))
 arrayAssignAdd($top_level_elements[0][],addTaint($e));
else 
{arrayAssignAdd($children_elements[0][deAspis($e[0]->$parent_field[0])][0][],addTaint($e));
}}}foreach ( $top_level_elements[0] as $e  )
$this->display_element($e,$children_elements,$max_depth,array(0,false),$args,$output);
if ( (($max_depth[0] == (0)) && (count($children_elements[0]) > (0))))
 {$empty_array = array(array(),false);
foreach ( $children_elements[0] as $orphans  )
foreach ( $orphans[0] as $op  )
$this->display_element($op,$empty_array,array(1,false),array(0,false),$args,$output);
}return $output;
} }
function paged_walk ( $elements,$max_depth,$page_num,$per_page ) {
{if ( (((empty($elements) || Aspis_empty( $elements))) || ($max_depth[0] < deAspis(negate(array(1,false))))))
 return array('',false);
$args = Aspis_array_slice(array(func_get_args(),false),array(4,false));
$output = array('',false);
$id_field = $this->db_fields[0][('id')];
$parent_field = $this->db_fields[0][('parent')];
$count = negate(array(1,false));
if ( (deAspis(negate(array(1,false))) == $max_depth[0]))
 $total_top = attAspis(count($elements[0]));
if ( (($page_num[0] < (1)) || ($per_page[0] < (0))))
 {$paging = array(false,false);
$start = array(0,false);
if ( (deAspis(negate(array(1,false))) == $max_depth[0]))
 $end = $total_top;
$this->max_pages = array(1,false);
}else 
{{$paging = array(true,false);
$start = array((deAspis(int_cast($page_num)) - (1)) * deAspis(int_cast($per_page)),false);
$end = array($start[0] + $per_page[0],false);
if ( (deAspis(negate(array(1,false))) == $max_depth[0]))
 $this->max_pages = attAspis(ceil(($total_top[0] / $per_page[0])));
}}if ( (deAspis(negate(array(1,false))) == $max_depth[0]))
 {if ( (!((empty($args[0][(0)][0][('reverse_top_level')]) || Aspis_empty( $args [0][(0)] [0][('reverse_top_level')])))))
 {$elements = Aspis_array_reverse($elements);
$oldstart = $start;
$start = array($total_top[0] - $end[0],false);
$end = array($total_top[0] - $oldstart[0],false);
}$empty_array = array(array(),false);
foreach ( $elements[0] as $e  )
{postincr($count);
if ( ($count[0] < $start[0]))
 continue ;
if ( ($count[0] >= $end[0]))
 break ;
$this->display_element($e,$empty_array,array(1,false),array(0,false),$args,$output);
}return $output;
}$top_level_elements = array(array(),false);
$children_elements = array(array(),false);
foreach ( $elements[0] as $e  )
{if ( ((0) == deAspis($e[0]->$parent_field[0])))
 arrayAssignAdd($top_level_elements[0][],addTaint($e));
else 
{arrayAssignAdd($children_elements[0][deAspis($e[0]->$parent_field[0])][0][],addTaint($e));
}}$total_top = attAspis(count($top_level_elements[0]));
if ( $paging[0])
 $this->max_pages = attAspis(ceil(($total_top[0] / $per_page[0])));
else 
{$end = $total_top;
}if ( (!((empty($args[0][(0)][0][('reverse_top_level')]) || Aspis_empty( $args [0][(0)] [0][('reverse_top_level')])))))
 {$top_level_elements = Aspis_array_reverse($top_level_elements);
$oldstart = $start;
$start = array($total_top[0] - $end[0],false);
$end = array($total_top[0] - $oldstart[0],false);
}if ( (!((empty($args[0][(0)][0][('reverse_children')]) || Aspis_empty( $args [0][(0)] [0][('reverse_children')])))))
 {foreach ( $children_elements[0] as $parent =>$children )
{restoreTaint($parent,$children);
arrayAssign($children_elements[0],deAspis(registerTaint($parent)),addTaint(Aspis_array_reverse($children)));
}}foreach ( $top_level_elements[0] as $e  )
{postincr($count);
if ( (($end[0] >= $total_top[0]) && ($count[0] < $start[0])))
 $this->unset_children($e,$children_elements);
if ( ($count[0] < $start[0]))
 continue ;
if ( ($count[0] >= $end[0]))
 break ;
$this->display_element($e,$children_elements,$max_depth,array(0,false),$args,$output);
}if ( (($end[0] >= $total_top[0]) && (count($children_elements[0]) > (0))))
 {$empty_array = array(array(),false);
foreach ( $children_elements[0] as $orphans  )
foreach ( $orphans[0] as $op  )
$this->display_element($op,$empty_array,array(1,false),array(0,false),$args,$output);
}return $output;
} }
function get_number_of_root_elements ( $elements ) {
{$num = array(0,false);
$parent_field = $this->db_fields[0][('parent')];
foreach ( $elements[0] as $e  )
{if ( ((0) == deAspis($e[0]->$parent_field[0])))
 postincr($num);
}return $num;
} }
function unset_children ( $e,&$children_elements ) {
{if ( ((denot_boolean($e)) || (denot_boolean($children_elements))))
 return ;
$id_field = $this->db_fields[0][('id')];
$id = $e[0]->$id_field[0];
if ( ((!((empty($children_elements[0][$id[0]]) || Aspis_empty( $children_elements [0][$id[0]])))) && is_array(deAspis(attachAspis($children_elements,$id[0])))))
 foreach ( deAspis(array_cast(attachAspis($children_elements,$id[0]))) as $child  )
$this->unset_children($child,$children_elements);
if ( ((isset($children_elements[0][$id[0]]) && Aspis_isset( $children_elements [0][$id[0]]))))
 unset($children_elements[0][$id[0]]);
} }
}class Walker_Page extends Walker{var $tree_type = array('page',false);
var $db_fields = array(array('parent' => array('post_parent',false),'id' => array('ID',false)),false);
function start_lvl ( &$output,$depth ) {
{$indent = Aspis_str_repeat(array("\t",false),$depth);
$output = concat($output,concat2(concat1("\n",$indent),"<ul>\n"));
} }
function end_lvl ( &$output,$depth ) {
{$indent = Aspis_str_repeat(array("\t",false),$depth);
$output = concat($output,concat2($indent,"</ul>\n"));
} }
function start_el ( &$output,$page,$depth,$args,$current_page ) {
{if ( $depth[0])
 $indent = Aspis_str_repeat(array("\t",false),$depth);
else 
{$indent = array('',false);
}extract(($args[0]),EXTR_SKIP);
$css_class = array(array(array('page_item',false),concat1('page-item-',$page[0]->ID)),false);
if ( (!((empty($current_page) || Aspis_empty( $current_page)))))
 {$_current_page = get_page($current_page);
if ( (((isset($_current_page[0]->ancestors) && Aspis_isset( $_current_page[0] ->ancestors ))) && deAspis(Aspis_in_array($page[0]->ID,array_cast($_current_page[0]->ancestors)))))
 arrayAssignAdd($css_class[0][],addTaint(array('current_page_ancestor',false)));
if ( ($page[0]->ID[0] == $current_page[0]))
 arrayAssignAdd($css_class[0][],addTaint(array('current_page_item',false)));
elseif ( ($_current_page[0] && ($page[0]->ID[0] == $_current_page[0]->post_parent[0])))
 arrayAssignAdd($css_class[0][],addTaint(array('current_page_parent',false)));
}elseif ( ($page[0]->ID[0] == deAspis(get_option(array('page_for_posts',false)))))
 {arrayAssignAdd($css_class[0][],addTaint(array('current_page_parent',false)));
}$css_class = Aspis_implode(array(' ',false),apply_filters(array('page_css_class',false),$css_class,$page));
$output = concat($output,concat2(concat(concat(concat(concat2(concat(concat2(concat(concat2(concat(concat2($indent,'<li class="'),$css_class),'"><a href="'),get_page_link($page[0]->ID)),'" title="'),esc_attr(apply_filters(array('the_title',false),$page[0]->post_title))),'">'),$link_before),apply_filters(array('the_title',false),$page[0]->post_title)),$link_after),'</a>'));
if ( (!((empty($show_date) || Aspis_empty( $show_date)))))
 {if ( (('modified') == $show_date[0]))
 $time = $page[0]->post_modified;
else 
{$time = $page[0]->post_date;
}$output = concat($output,concat1(" ",mysql2date($date_format,$time)));
}} }
function end_el ( &$output,$page,$depth ) {
{$output = concat2($output,"</li>\n");
} }
}class Walker_PageDropdown extends Walker{var $tree_type = array('page',false);
var $db_fields = array(array('parent' => array('post_parent',false),'id' => array('ID',false)),false);
function start_el ( &$output,$page,$depth,$args ) {
{$pad = Aspis_str_repeat(array('&nbsp;',false),array($depth[0] * (3),false));
$output = concat($output,concat2(concat(concat2(concat1("\t<option class=\"level-",$depth),"\" value=\""),$page[0]->ID),"\""));
if ( ($page[0]->ID[0] == deAspis($args[0]['selected'])))
 $output = concat2($output,' selected="selected"');
$output = concat2($output,'>');
$title = esc_html($page[0]->post_title);
$output = concat($output,concat($pad,$title));
$output = concat2($output,"</option>\n");
} }
}class Walker_Category extends Walker{var $tree_type = array('category',false);
var $db_fields = array(array('parent' => array('parent',false),'id' => array('term_id',false)),false);
function start_lvl ( &$output,$depth,$args ) {
{if ( (('list') != deAspis($args[0]['style'])))
 return ;
$indent = Aspis_str_repeat(array("\t",false),$depth);
$output = concat($output,concat2($indent,"<ul class='children'>\n"));
} }
function end_lvl ( &$output,$depth,$args ) {
{if ( (('list') != deAspis($args[0]['style'])))
 return ;
$indent = Aspis_str_repeat(array("\t",false),$depth);
$output = concat($output,concat2($indent,"</ul>\n"));
} }
function start_el ( &$output,$category,$depth,$args ) {
{extract(($args[0]));
$cat_name = esc_attr($category[0]->name);
$cat_name = apply_filters(array('list_cats',false),$cat_name,$category);
$link = concat2(concat1('<a href="',get_category_link($category[0]->term_id)),'" ');
if ( (($use_desc_for_title[0] == (0)) || ((empty($category[0]->description) || Aspis_empty( $category[0] ->description )))))
 $link = concat($link,concat2(concat1('title="',Aspis_sprintf(__(array('View all posts filed under %s',false)),$cat_name)),'"'));
else 
{$link = concat($link,concat2(concat1('title="',esc_attr(Aspis_strip_tags(apply_filters(array('category_description',false),$category[0]->description,$category)))),'"'));
}$link = concat2($link,'>');
$link = concat($link,concat2($cat_name,'</a>'));
if ( ((!((empty($feed_image) || Aspis_empty( $feed_image)))) || (!((empty($feed) || Aspis_empty( $feed))))))
 {$link = concat2($link,' ');
if ( ((empty($feed_image) || Aspis_empty( $feed_image))))
 $link = concat2($link,'(');
$link = concat($link,concat2(concat1('<a href="',get_category_feed_link($category[0]->term_id,$feed_type)),'"'));
if ( ((empty($feed) || Aspis_empty( $feed))))
 $alt = concat2(concat1(' alt="',Aspis_sprintf(__(array('Feed for all posts filed under %s',false)),$cat_name)),'"');
else 
{{$title = concat2(concat1(' title="',$feed),'"');
$alt = concat2(concat1(' alt="',$feed),'"');
$name = $feed;
$link = concat($link,$title);
}}$link = concat2($link,'>');
if ( ((empty($feed_image) || Aspis_empty( $feed_image))))
 $link = concat($link,$name);
else 
{$link = concat($link,concat2(concat(concat(concat2(concat1("<img src='",$feed_image),"'"),$alt),$title),' />'));
}$link = concat2($link,'</a>');
if ( ((empty($feed_image) || Aspis_empty( $feed_image))))
 $link = concat2($link,')');
}if ( (((isset($show_count) && Aspis_isset( $show_count))) && $show_count[0]))
 $link = concat($link,concat2(concat1(' (',Aspis_intval($category[0]->count)),')'));
if ( (((isset($show_date) && Aspis_isset( $show_date))) && $show_date[0]))
 {$link = concat($link,concat1(' ',attAspis(gmdate(('Y-m-d'),$category[0]->last_update_timestamp[0]))));
}if ( (((isset($current_category) && Aspis_isset( $current_category))) && $current_category[0]))
 $_current_category = get_category($current_category);
if ( (('list') == deAspis($args[0]['style'])))
 {$output = concat2($output,"\t<li");
$class = concat1('cat-item cat-item-',$category[0]->term_id);
if ( ((((isset($current_category) && Aspis_isset( $current_category))) && $current_category[0]) && ($category[0]->term_id[0] == $current_category[0])))
 $class = concat2($class,' current-cat');
elseif ( ((((isset($_current_category) && Aspis_isset( $_current_category))) && $_current_category[0]) && ($category[0]->term_id[0] == $_current_category[0]->parent[0])))
 $class = concat2($class,' current-cat-parent');
$output = concat($output,concat2(concat1(' class="',$class),'"'));
$output = concat($output,concat2(concat1(">",$link),"\n"));
}else 
{{$output = concat($output,concat2(concat1("\t",$link),"<br />\n"));
}}} }
function end_el ( &$output,$page,$depth,$args ) {
{if ( (('list') != deAspis($args[0]['style'])))
 return ;
$output = concat2($output,"</li>\n");
} }
}class Walker_CategoryDropdown extends Walker{var $tree_type = array('category',false);
var $db_fields = array(array('parent' => array('parent',false),'id' => array('term_id',false)),false);
function start_el ( &$output,$category,$depth,$args ) {
{$pad = Aspis_str_repeat(array('&nbsp;',false),array($depth[0] * (3),false));
$cat_name = apply_filters(array('list_cats',false),$category[0]->name,$category);
$output = concat($output,concat2(concat(concat2(concat1("\t<option class=\"level-",$depth),"\" value=\""),$category[0]->term_id),"\""));
if ( ($category[0]->term_id[0] == deAspis($args[0]['selected'])))
 $output = concat2($output,' selected="selected"');
$output = concat2($output,'>');
$output = concat($output,concat($pad,$cat_name));
if ( deAspis($args[0]['show_count']))
 $output = concat($output,concat2(concat1('&nbsp;&nbsp;(',$category[0]->count),')'));
if ( deAspis($args[0]['show_last_update']))
 {$format = array('Y-m-d',false);
$output = concat($output,concat1('&nbsp;&nbsp;',attAspis(gmdate($format[0],$category[0]->last_update_timestamp[0]))));
}$output = concat2($output,"</option>\n");
} }
}class WP_Ajax_Response{var $responses = array(array(),false);
function WP_Ajax_Response ( $args = array('',false) ) {
{if ( (!((empty($args) || Aspis_empty( $args)))))
 $this->add($args);
} }
function add ( $args = array('',false) ) {
{$defaults = array(array('what' => array('object',false,false),'action' => array(false,false,false),'id' => array('0',false,false),'old_id' => array(false,false,false),'position' => array(1,false,false),'data' => array('',false,false),'supplemental' => array(array(),false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
$position = Aspis_preg_replace(array('/[^a-z0-9:_-]/i',false),array('',false),$position);
if ( deAspis(is_wp_error($id)))
 {$data = $id;
$id = array(0,false);
}$response = array('',false);
if ( deAspis(is_wp_error($data)))
 {foreach ( deAspis(array_cast($data[0]->get_error_codes())) as $code  )
{$response = concat($response,concat2(concat(concat2(concat1("<wp_error code='",$code),"'><![CDATA["),$data[0]->get_error_message($code)),"]]></wp_error>"));
if ( (denot_boolean($error_data = $data[0]->get_error_data($code))))
 continue ;
$class = array('',false);
if ( is_object($error_data[0]))
 {$class = concat2(concat1(' class="',attAspis(get_class(deAspisRC($error_data)))),'"');
$error_data = attAspis(get_object_vars(deAspisRC($error_data)));
}$response = concat($response,concat2(concat(concat2(concat1("<wp_error_data code='",$code),"'"),$class),">"));
if ( is_scalar(deAspisRC($error_data)))
 {$response = concat($response,concat2(concat1("<![CDATA[",$error_data),"]]>"));
}elseif ( is_array($error_data[0]))
 {foreach ( $error_data[0] as $k =>$v )
{restoreTaint($k,$v);
$response = concat($response,concat2(concat(concat2(concat(concat2(concat1("<",$k),"><![CDATA["),$v),"]]></"),$k),">"));
}}$response = concat2($response,"</wp_error_data>");
}}else 
{{$response = concat2(concat1("<response_data><![CDATA[",$data),"]]></response_data>");
}}$s = array('',false);
if ( is_array($supplemental[0]))
 {foreach ( $supplemental[0] as $k =>$v )
{restoreTaint($k,$v);
$s = concat($s,concat2(concat(concat2(concat(concat2(concat1("<",$k),"><![CDATA["),$v),"]]></"),$k),">"));
}$s = concat2(concat1("<supplemental>",$s),"</supplemental>");
}if ( (false === $action[0]))
 $action = $_POST[0]['action'];
$x = array('',false);
$x = concat($x,concat2(concat(concat2(concat1("<response action='",$action),"_"),$id),"'>"));
$x = concat($x,concat(concat(concat2(concat(concat2(concat1("<",$what)," id='"),$id),"' "),((false === $old_id[0]) ? array('',false) : concat2(concat1("old_id='",$old_id),"' "))),concat2(concat1("position='",$position),"'>")));
$x = concat($x,$response);
$x = concat($x,$s);
$x = concat($x,concat2(concat1("</",$what),">"));
$x = concat2($x,"</response>");
arrayAssignAdd($this->responses[0][],addTaint($x));
return $x;
} }
function send (  ) {
{header(('Content-Type: text/xml'));
echo AspisCheckPrint(array("<?xml version='1.0' standalone='yes'?><wp_ajax>",false));
foreach ( deAspis(array_cast($this->responses)) as $response  )
echo AspisCheckPrint($response);
echo AspisCheckPrint(array('</wp_ajax>',false));
Aspis_exit();
} }
}class WP_MatchesMapRegex{var $_matches;
var $output;
var $_subject;
var $_pattern = array('(\$matches\[[1-9]+[0-9]*\])',false);
function WP_MatchesMapRegex ( $subject,$matches ) {
{$this->_subject = $subject;
$this->_matches = $matches;
$this->output = $this->_map();
} }
function apply ( $subject,$matches ) {
{$oSelf = array(new WP_MatchesMapRegex($subject,$matches),false);
return $oSelf[0]->output;
} }
function _map (  ) {
{$callback = array(array(array($this,false),array('callback',false)),false);
return Aspis_preg_replace_callback($this->_pattern,$callback,$this->_subject);
} }
function callback ( $matches ) {
{$index = Aspis_intval(Aspis_substr(attachAspis($matches,(0)),array(9,false),negate(array(1,false))));
return (((isset($this->_matches[0][$index[0]]) && Aspis_isset( $this ->_matches [0][$index[0]] ))) ? $this->_matches[0][$index[0]] : array('',false));
} }
};
?>
<?php 