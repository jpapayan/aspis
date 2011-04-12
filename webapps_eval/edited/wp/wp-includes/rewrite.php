<?php require_once('AspisMain.php'); ?><?php
function add_rewrite_rule ( $regex,$redirect,$after = array('bottom',false) ) {
global $wp_rewrite;
$wp_rewrite[0]->add_rule($regex,$redirect,$after);
 }
function add_rewrite_tag ( $tagname,$regex ) {
if ( (((strlen($tagname[0]) < (3)) || (deAspis(attachAspis($tagname,(0))) != ('%'))) || (deAspis(attachAspis($tagname,(strlen($tagname[0]) - (1)))) != ('%'))))
 {return ;
}$qv = Aspis_trim($tagname,array('%',false));
global $wp_rewrite,$wp;
$wp[0]->add_query_var($qv);
$wp_rewrite[0]->add_rewrite_tag($tagname,$regex,concat2($qv,'='));
 }
function add_feed ( $feedname,$function ) {
global $wp_rewrite;
if ( (denot_boolean(Aspis_in_array($feedname,$wp_rewrite[0]->feeds))))
 {arrayAssignAdd($wp_rewrite[0]->feeds[0][],addTaint($feedname));
}$hook = concat1('do_feed_',$feedname);
remove_action($hook,$hook,array(10,false),array(1,false));
add_action($hook,$function,array(10,false),array(1,false));
return $hook;
 }
define(('EP_PERMALINK'),1);
define(('EP_ATTACHMENT'),2);
define(('EP_DATE'),4);
define(('EP_YEAR'),8);
define(('EP_MONTH'),16);
define(('EP_DAY'),32);
define(('EP_ROOT'),64);
define(('EP_COMMENTS'),128);
define(('EP_SEARCH'),256);
define(('EP_CATEGORIES'),512);
define(('EP_TAGS'),1024);
define(('EP_AUTHORS'),2048);
define(('EP_PAGES'),4096);
define(('EP_NONE'),0);
define(('EP_ALL'),8191);
function add_rewrite_endpoint ( $name,$places ) {
global $wp_rewrite;
$wp_rewrite[0]->add_endpoint($name,$places);
 }
function _wp_filter_taxonomy_base ( $base ) {
if ( (!((empty($base) || Aspis_empty( $base)))))
 {$base = Aspis_preg_replace(array('|^/index\.php/|',false),array('',false),$base);
$base = Aspis_trim($base,array('/',false));
}return $base;
 }
function url_to_postid ( $url ) {
global $wp_rewrite;
$url = apply_filters(array('url_to_postid',false),$url);
if ( deAspis(Aspis_preg_match(array('#[?&](p|page_id|attachment_id)=(\d+)#',false),$url,$values)))
 {$id = absint(attachAspis($values,(2)));
if ( $id[0])
 return $id;
}$rewrite = $wp_rewrite[0]->wp_rewrite_rules();
if ( ((empty($rewrite) || Aspis_empty( $rewrite))))
 return array(0,false);
$url_split = Aspis_explode(array('#',false),$url);
$url = attachAspis($url_split,(0));
$url_split = Aspis_explode(array('?',false),$url);
$url = attachAspis($url_split,(0));
if ( ((false !== strpos(deAspis(get_option(array('home',false))),'://www.')) && (false === strpos($url[0],'://www.'))))
 $url = Aspis_str_replace(array('://',false),array('://www.',false),$url);
if ( (false === strpos(deAspis(get_option(array('home',false))),'://www.')))
 $url = Aspis_str_replace(array('://www.',false),array('://',false),$url);
if ( (denot_boolean($wp_rewrite[0]->using_index_permalinks())))
 $url = Aspis_str_replace(array('index.php/',false),array('',false),$url);
if ( (false !== strpos($url[0],deAspisRC(get_option(array('home',false))))))
 {$url = Aspis_str_replace(get_option(array('home',false)),array('',false),$url);
}else 
{{$home_path = Aspis_parse_url(get_option(array('home',false)));
$home_path = $home_path[0]['path'];
$url = Aspis_str_replace($home_path,array('',false),$url);
}}$url = Aspis_trim($url,array('/',false));
$request = $url;
$request_match = $request;
foreach ( $rewrite[0] as $match =>$query )
{restoreTaint($match,$query);
{if ( (((!((empty($url) || Aspis_empty( $url)))) && (strpos($match[0],deAspisRC($url)) === (0))) && ($url[0] != $request[0])))
 {$request_match = concat(concat2($url,'/'),$request);
}if ( deAspis(Aspis_preg_match(concat2(concat1("!^",$match),"!"),$request_match,$matches)))
 {$query = Aspis_preg_replace(array("!^.+\?!",false),array('',false),$query);
$query = Aspis_addslashes(WP_MatchesMapRegex::apply($query,$matches));
global $wp;
AspisInternalFunctionCall("parse_str",$query[0],AspisPushRefParam($query_vars),array(1));
$query = array(array(),false);
foreach ( deAspis(array_cast($query_vars)) as $key =>$value )
{restoreTaint($key,$value);
{if ( deAspis(Aspis_in_array($key,$wp[0]->public_query_vars)))
 arrayAssign($query[0],deAspis(registerTaint($key)),addTaint($value));
}}$query = array(new WP_Query($query),false);
if ( ($query[0]->is_single[0] || $query[0]->is_page[0]))
 return $query[0]->post[0]->ID;
else 
{return array(0,false);
}}}}return array(0,false);
 }
class WP_Rewrite{var $permalink_structure;
var $use_trailing_slashes;
var $category_base;
var $tag_base;
var $category_structure;
var $tag_structure;
var $author_base = array('author',false);
var $author_structure;
var $date_structure;
var $page_structure;
var $search_base = array('search',false);
var $search_structure;
var $comments_base = array('comments',false);
var $feed_base = array('feed',false);
var $comments_feed_structure;
var $feed_structure;
var $front;
var $root = array('',false);
var $index = array('index.php',false);
var $matches = array('',false);
var $rules;
var $extra_rules = array(array(),false);
var $extra_rules_top = array(array(),false);
var $non_wp_rules = array(array(),false);
var $extra_permastructs = array(array(),false);
var $endpoints;
var $use_verbose_rules = array(false,false);
var $use_verbose_page_rules = array(true,false);
var $rewritecode = array(array(array('%year%',false),array('%monthnum%',false),array('%day%',false),array('%hour%',false),array('%minute%',false),array('%second%',false),array('%postname%',false),array('%post_id%',false),array('%category%',false),array('%tag%',false),array('%author%',false),array('%pagename%',false),array('%search%',false)),false);
var $rewritereplace = array(array(array('([0-9]{4})',false),array('([0-9]{1,2})',false),array('([0-9]{1,2})',false),array('([0-9]{1,2})',false),array('([0-9]{1,2})',false),array('([0-9]{1,2})',false),array('([^/]+)',false),array('([0-9]+)',false),array('(.+?)',false),array('(.+?)',false),array('([^/]+)',false),array('([^/]+?)',false),array('(.+)',false)),false);
var $queryreplace = array(array(array('year=',false),array('monthnum=',false),array('day=',false),array('hour=',false),array('minute=',false),array('second=',false),array('name=',false),array('p=',false),array('category_name=',false),array('tag=',false),array('author_name=',false),array('pagename=',false),array('s=',false)),false);
var $feeds = array(array(array('feed',false),array('rdf',false),array('rss',false),array('rss2',false),array('atom',false)),false);
function using_permalinks (  ) {
{if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 return array(false,false);
else 
{return array(true,false);
}} }
function using_index_permalinks (  ) {
{if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 {return array(false,false);
}if ( deAspis(Aspis_preg_match(concat2(concat1('#^/*',$this->index),'#'),$this->permalink_structure)))
 {return array(true,false);
}return array(false,false);
} }
function using_mod_rewrite_permalinks (  ) {
{if ( (deAspis($this->using_permalinks()) && (denot_boolean($this->using_index_permalinks()))))
 return array(true,false);
else 
{return array(false,false);
}} }
function preg_index ( $number ) {
{$match_prefix = array('$',false);
$match_suffix = array('',false);
if ( (!((empty($this->matches) || Aspis_empty( $this ->matches )))))
 {$match_prefix = concat2(concat1('$',$this->matches),'[');
$match_suffix = array(']',false);
}return concat(concat($match_prefix,$number),$match_suffix);
} }
function page_uri_index (  ) {
{global $wpdb;
$posts = get_page_hierarchy($wpdb[0]->get_results(concat2(concat1("SELECT ID, post_name, post_parent FROM ",$wpdb[0]->posts)," WHERE post_type = 'page'")));
$posts = Aspis_array_reverse($posts,array(true,false));
$page_uris = array(array(),false);
$page_attachment_uris = array(array(),false);
if ( (denot_boolean($posts)))
 return array(array(array(array(),false),array(array(),false)),false);
foreach ( $posts[0] as $id =>$post )
{restoreTaint($id,$post);
{$uri = get_page_uri($id);
$attachments = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT ID, post_name, post_parent FROM ",$wpdb[0]->posts)," WHERE post_type = 'attachment' AND post_parent = %d"),$id));
if ( $attachments[0])
 {foreach ( $attachments[0] as $attachment  )
{$attach_uri = get_page_uri($attachment[0]->ID);
arrayAssign($page_attachment_uris[0],deAspis(registerTaint($attach_uri)),addTaint($attachment[0]->ID));
}}arrayAssign($page_uris[0],deAspis(registerTaint($uri)),addTaint($id));
}}return array(array($page_uris,$page_attachment_uris),false);
} }
function page_rewrite_rules (  ) {
{$rewrite_rules = array(array(),false);
$page_structure = $this->get_page_permastruct();
if ( (denot_boolean($this->use_verbose_page_rules)))
 {$this->add_rewrite_tag(array('%pagename%',false),array("(.+?)",false),array('pagename=',false));
$rewrite_rules = Aspis_array_merge($rewrite_rules,$this->generate_rewrite_rules($page_structure,array(EP_PAGES,false)));
return $rewrite_rules;
}$page_uris = $this->page_uri_index();
$uris = attachAspis($page_uris,(0));
$attachment_uris = attachAspis($page_uris,(1));
if ( is_array($attachment_uris[0]))
 {foreach ( $attachment_uris[0] as $uri =>$pagename )
{restoreTaint($uri,$pagename);
{$this->add_rewrite_tag(array('%pagename%',false),concat2(concat1("(",$uri),")"),array('attachment=',false));
$rewrite_rules = Aspis_array_merge($rewrite_rules,$this->generate_rewrite_rules($page_structure,array(EP_PAGES,false)));
}}}if ( is_array($uris[0]))
 {foreach ( $uris[0] as $uri =>$pagename )
{restoreTaint($uri,$pagename);
{$this->add_rewrite_tag(array('%pagename%',false),concat2(concat1("(",$uri),")"),array('pagename=',false));
$rewrite_rules = Aspis_array_merge($rewrite_rules,$this->generate_rewrite_rules($page_structure,array(EP_PAGES,false)));
}}}return $rewrite_rules;
} }
function get_date_permastruct (  ) {
{if ( ((isset($this->date_structure) && Aspis_isset( $this ->date_structure ))))
 {return $this->date_structure;
}if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 {$this->date_structure = array('',false);
return array(false,false);
}$endians = array(array(array('%year%/%monthnum%/%day%',false),array('%day%/%monthnum%/%year%',false),array('%monthnum%/%day%/%year%',false)),false);
$this->date_structure = array('',false);
$date_endian = array('',false);
foreach ( $endians[0] as $endian  )
{if ( (false !== strpos($this->permalink_structure[0],deAspisRC($endian))))
 {$date_endian = $endian;
break ;
}}if ( ((empty($date_endian) || Aspis_empty( $date_endian))))
 $date_endian = array('%year%/%monthnum%/%day%',false);
$front = $this->front;
Aspis_preg_match_all(array('/%.+?%/',false),$this->permalink_structure,$tokens);
$tok_index = array(1,false);
foreach ( deAspis(array_cast(attachAspis($tokens,(0)))) as $token  )
{if ( (($token[0] == ('%post_id%')) && ($tok_index[0] <= (3))))
 {$front = concat2($front,'date/');
break ;
}postincr($tok_index);
}$this->date_structure = concat($front,$date_endian);
return $this->date_structure;
} }
function get_year_permastruct (  ) {
{$structure = $this->get_date_permastruct($this->permalink_structure);
if ( ((empty($structure) || Aspis_empty( $structure))))
 {return array(false,false);
}$structure = Aspis_str_replace(array('%monthnum%',false),array('',false),$structure);
$structure = Aspis_str_replace(array('%day%',false),array('',false),$structure);
$structure = Aspis_preg_replace(array('#/+#',false),array('/',false),$structure);
return $structure;
} }
function get_month_permastruct (  ) {
{$structure = $this->get_date_permastruct($this->permalink_structure);
if ( ((empty($structure) || Aspis_empty( $structure))))
 {return array(false,false);
}$structure = Aspis_str_replace(array('%day%',false),array('',false),$structure);
$structure = Aspis_preg_replace(array('#/+#',false),array('/',false),$structure);
return $structure;
} }
function get_day_permastruct (  ) {
{return $this->get_date_permastruct($this->permalink_structure);
} }
function get_category_permastruct (  ) {
{if ( ((isset($this->category_structure) && Aspis_isset( $this ->category_structure ))))
 {return $this->category_structure;
}if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 {$this->category_structure = array('',false);
return array(false,false);
}if ( ((empty($this->category_base) || Aspis_empty( $this ->category_base ))))
 $this->category_structure = trailingslashit(concat2($this->front,'category'));
else 
{$this->category_structure = trailingslashit(concat(concat1('/',$this->root),$this->category_base));
}$this->category_structure = concat2($this->category_structure ,'%category%');
return $this->category_structure;
} }
function get_tag_permastruct (  ) {
{if ( ((isset($this->tag_structure) && Aspis_isset( $this ->tag_structure ))))
 {return $this->tag_structure;
}if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 {$this->tag_structure = array('',false);
return array(false,false);
}if ( ((empty($this->tag_base) || Aspis_empty( $this ->tag_base ))))
 $this->tag_structure = trailingslashit(concat2($this->front,'tag'));
else 
{$this->tag_structure = trailingslashit(concat(concat1('/',$this->root),$this->tag_base));
}$this->tag_structure = concat2($this->tag_structure ,'%tag%');
return $this->tag_structure;
} }
function get_extra_permastruct ( $name ) {
{if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 return array(false,false);
if ( ((isset($this->extra_permastructs[0][$name[0]]) && Aspis_isset( $this ->extra_permastructs [0][$name[0]] ))))
 return $this->extra_permastructs[0][$name[0]];
return array(false,false);
} }
function get_author_permastruct (  ) {
{if ( ((isset($this->author_structure) && Aspis_isset( $this ->author_structure ))))
 {return $this->author_structure;
}if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 {$this->author_structure = array('',false);
return array(false,false);
}$this->author_structure = concat2(concat($this->front,$this->author_base),'/%author%');
return $this->author_structure;
} }
function get_search_permastruct (  ) {
{if ( ((isset($this->search_structure) && Aspis_isset( $this ->search_structure ))))
 {return $this->search_structure;
}if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 {$this->search_structure = array('',false);
return array(false,false);
}$this->search_structure = concat2(concat($this->root,$this->search_base),'/%search%');
return $this->search_structure;
} }
function get_page_permastruct (  ) {
{if ( ((isset($this->page_structure) && Aspis_isset( $this ->page_structure ))))
 {return $this->page_structure;
}if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 {$this->page_structure = array('',false);
return array(false,false);
}$this->page_structure = concat2($this->root,'%pagename%');
return $this->page_structure;
} }
function get_feed_permastruct (  ) {
{if ( ((isset($this->feed_structure) && Aspis_isset( $this ->feed_structure ))))
 {return $this->feed_structure;
}if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 {$this->feed_structure = array('',false);
return array(false,false);
}$this->feed_structure = concat2(concat($this->root,$this->feed_base),'/%feed%');
return $this->feed_structure;
} }
function get_comment_feed_permastruct (  ) {
{if ( ((isset($this->comment_feed_structure) && Aspis_isset( $this ->comment_feed_structure ))))
 {return $this->comment_feed_structure;
}if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 {$this->comment_feed_structure = array('',false);
return array(false,false);
}$this->comment_feed_structure = concat2(concat(concat2(concat($this->root,$this->comments_base),'/'),$this->feed_base),'/%feed%');
return $this->comment_feed_structure;
} }
function add_rewrite_tag ( $tag,$pattern,$query ) {
{$position = Aspis_array_search($tag,$this->rewritecode);
if ( ((false !== $position[0]) && (null !== $position[0])))
 {arrayAssign($this->rewritereplace[0],deAspis(registerTaint($position)),addTaint($pattern));
arrayAssign($this->queryreplace[0],deAspis(registerTaint($position)),addTaint($query));
}else 
{{arrayAssignAdd($this->rewritecode[0][],addTaint($tag));
arrayAssignAdd($this->rewritereplace[0][],addTaint($pattern));
arrayAssignAdd($this->queryreplace[0][],addTaint($query));
}}} }
function generate_rewrite_rules ( $permalink_structure,$ep_mask = array(EP_NONE,false),$paged = array(true,false),$feed = array(true,false),$forcomments = array(false,false),$walk_dirs = array(true,false),$endpoints = array(true,false) ) {
{$feedregex2 = array('',false);
foreach ( deAspis(array_cast($this->feeds)) as $feed_name  )
{$feedregex2 = concat($feedregex2,concat2($feed_name,'|'));
}$feedregex2 = concat2(concat1('(',Aspis_trim($feedregex2,array('|',false))),')/?$');
$feedregex = concat(concat2($this->feed_base,'/'),$feedregex2);
$trackbackregex = array('trackback/?$',false);
$pageregex = array('page/?([0-9]{1,})/?$',false);
$commentregex = array('comment-page-([0-9]{1,})/?$',false);
if ( $endpoints[0])
 {$ep_query_append = array(array(),false);
foreach ( deAspis(array_cast($this->endpoints)) as $endpoint  )
{$epmatch = concat2(attachAspis($endpoint,(1)),'(/(.*))?/?$');
$epquery = concat2(concat1('&',attachAspis($endpoint,(1))),'=');
arrayAssign($ep_query_append[0],deAspis(registerTaint($epmatch)),addTaint(array(array(attachAspis($endpoint,(0)),$epquery),false)));
}}$front = Aspis_substr($permalink_structure,array(0,false),attAspis(strpos($permalink_structure[0],'%')));
Aspis_preg_match_all(array('/%.+?%/',false),$permalink_structure,$tokens);
$num_tokens = attAspis(count(deAspis(attachAspis($tokens,(0)))));
$index = $this->index;
$feedindex = $index;
$trackbackindex = $index;
for ( $i = array(0,false) ; ($i[0] < $num_tokens[0]) ; preincr($i) )
{if ( ((0) < $i[0]))
 {arrayAssign($queries[0],deAspis(registerTaint($i)),addTaint(concat2(attachAspis($queries,($i[0] - (1))),'&')));
}else 
{{arrayAssign($queries[0],deAspis(registerTaint($i)),addTaint(array('',false)));
}}$query_token = concat(Aspis_str_replace($this->rewritecode,$this->queryreplace,attachAspis($tokens[0][(0)],$i[0])),$this->preg_index(array($i[0] + (1),false)));
arrayAssign($queries[0],deAspis(registerTaint($i)),addTaint(concat(attachAspis($queries,$i[0]),$query_token)));
}$structure = $permalink_structure;
if ( ($front[0] != ('/')))
 {$structure = Aspis_str_replace($front,array('',false),$structure);
}$structure = Aspis_trim($structure,array('/',false));
if ( $walk_dirs[0])
 {$dirs = Aspis_explode(array('/',false),$structure);
}else 
{{arrayAssignAdd($dirs[0][],addTaint($structure));
}}$num_dirs = attAspis(count($dirs[0]));
$front = Aspis_preg_replace(array('|^/+|',false),array('',false),$front);
$post_rewrite = array(array(),false);
$struct = $front;
for ( $j = array(0,false) ; ($j[0] < $num_dirs[0]) ; preincr($j) )
{$struct = concat($struct,concat2(attachAspis($dirs,$j[0]),'/'));
$struct = Aspis_ltrim($struct,array('/',false));
$match = Aspis_str_replace($this->rewritecode,$this->rewritereplace,$struct);
$num_toks = Aspis_preg_match_all(array('/%.+?%/',false),$struct,$toks);
$query = (((isset($queries) && Aspis_isset( $queries))) && is_array($queries[0])) ? attachAspis($queries,($num_toks[0] - (1))) : array('',false);
switch ( deAspis(attachAspis($dirs,$j[0])) ) {
case ('%year%'):$ep_mask_specific = array(EP_YEAR,false);
break ;
case ('%monthnum%'):$ep_mask_specific = array(EP_MONTH,false);
break ;
case ('%day%'):$ep_mask_specific = array(EP_DAY,false);
break ;
 }
$pagematch = concat($match,$pageregex);
$pagequery = concat(concat2(concat(concat2($index,'?'),$query),'&paged='),$this->preg_index(array($num_toks[0] + (1),false)));
$commentmatch = concat($match,$commentregex);
$commentquery = concat(concat2(concat(concat2($index,'?'),$query),'&cpage='),$this->preg_index(array($num_toks[0] + (1),false)));
if ( deAspis(get_option(array('page_on_front',false))))
 {$rootcommentmatch = concat($match,$commentregex);
$rootcommentquery = concat(concat2(concat(concat2(concat(concat2($index,'?'),$query),'&page_id='),get_option(array('page_on_front',false))),'&cpage='),$this->preg_index(array($num_toks[0] + (1),false)));
}$feedmatch = concat($match,$feedregex);
$feedquery = concat(concat2(concat(concat2($feedindex,'?'),$query),'&feed='),$this->preg_index(array($num_toks[0] + (1),false)));
$feedmatch2 = concat($match,$feedregex2);
$feedquery2 = concat(concat2(concat(concat2($feedindex,'?'),$query),'&feed='),$this->preg_index(array($num_toks[0] + (1),false)));
if ( $forcomments[0])
 {$feedquery = concat2($feedquery,'&withcomments=1');
$feedquery2 = concat2($feedquery2,'&withcomments=1');
}$rewrite = array(array(),false);
if ( $feed[0])
 $rewrite = array(array(deregisterTaint($feedmatch) => addTaint($feedquery),deregisterTaint($feedmatch2) => addTaint($feedquery2)),false);
if ( $paged[0])
 $rewrite = Aspis_array_merge($rewrite,array(array(deregisterTaint($pagematch) => addTaint($pagequery)),false));
if ( (((EP_PAGES & $ep_mask[0]) || (EP_PERMALINK & $ep_mask[0])) || (EP_NONE & $ep_mask[0])))
 $rewrite = Aspis_array_merge($rewrite,array(array(deregisterTaint($commentmatch) => addTaint($commentquery)),false));
else 
{if ( ((EP_ROOT & $ep_mask[0]) && deAspis(get_option(array('page_on_front',false)))))
 $rewrite = Aspis_array_merge($rewrite,array(array(deregisterTaint($rootcommentmatch) => addTaint($rootcommentquery)),false));
}if ( $endpoints[0])
 {foreach ( deAspis(array_cast($ep_query_append)) as $regex =>$ep )
{restoreTaint($regex,$ep);
{if ( ((deAspis(attachAspis($ep,(0))) & $ep_mask[0]) || (deAspis(attachAspis($ep,(0))) & $ep_mask_specific[0])))
 {arrayAssign($rewrite[0],deAspis(registerTaint(concat($match,$regex))),addTaint(concat(concat(concat(concat2($index,'?'),$query),attachAspis($ep,(1))),$this->preg_index(array($num_toks[0] + (2),false)))));
}}}}if ( $num_toks[0])
 {$post = array(false,false);
$page = array(false,false);
if ( ((((strpos($struct[0],'%postname%') !== false) || (strpos($struct[0],'%post_id%') !== false)) || (strpos($struct[0],'%pagename%') !== false)) || ((((((strpos($struct[0],'%year%') !== false) && (strpos($struct[0],'%monthnum%') !== false)) && (strpos($struct[0],'%day%') !== false)) && (strpos($struct[0],'%hour%') !== false)) && (strpos($struct[0],'%minute%') !== false)) && (strpos($struct[0],'%second%') !== false))))
 {$post = array(true,false);
if ( (strpos($struct[0],'%pagename%') !== false))
 $page = array(true,false);
}if ( $post[0])
 {$post = array(true,false);
$trackbackmatch = concat($match,$trackbackregex);
$trackbackquery = concat2(concat(concat2($trackbackindex,'?'),$query),'&tb=1');
$match = Aspis_rtrim($match,array('/',false));
$submatchbase = Aspis_str_replace(array(array(array('(',false),array(')',false)),false),array('',false),$match);
$sub1 = concat2($submatchbase,'/([^/]+)/');
$sub1tb = concat($sub1,$trackbackregex);
$sub1feed = concat($sub1,$feedregex);
$sub1feed2 = concat($sub1,$feedregex2);
$sub1comment = concat($sub1,$commentregex);
$sub2 = concat2($submatchbase,'/attachment/([^/]+)/');
$sub2tb = concat($sub2,$trackbackregex);
$sub2feed = concat($sub2,$feedregex);
$sub2feed2 = concat($sub2,$feedregex2);
$sub2comment = concat($sub2,$commentregex);
$subquery = concat(concat2($index,'?attachment='),$this->preg_index(array(1,false)));
$subtbquery = concat2($subquery,'&tb=1');
$subfeedquery = concat(concat2($subquery,'&feed='),$this->preg_index(array(2,false)));
$subcommentquery = concat(concat2($subquery,'&cpage='),$this->preg_index(array(2,false)));
if ( (!((empty($endpoints) || Aspis_empty( $endpoints)))))
 {foreach ( deAspis(array_cast($ep_query_append)) as $regex =>$ep )
{restoreTaint($regex,$ep);
{if ( (deAspis(attachAspis($ep,(0))) & EP_ATTACHMENT))
 {arrayAssign($rewrite[0],deAspis(registerTaint(concat($sub1,$regex))),addTaint(concat(concat($subquery,attachAspis($ep,(1))),$this->preg_index(array(2,false)))));
arrayAssign($rewrite[0],deAspis(registerTaint(concat($sub2,$regex))),addTaint(concat(concat($subquery,attachAspis($ep,(1))),$this->preg_index(array(2,false)))));
}}}}$sub1 = concat2($sub1,'?$');
$sub2 = concat2($sub2,'?$');
$match = concat2($match,'(/[0-9]+)?/?$');
$query = concat(concat2(concat(concat2($index,'?'),$query),'&page='),$this->preg_index(array($num_toks[0] + (1),false)));
}else 
{{$match = concat2($match,'?$');
$query = concat(concat2($index,'?'),$query);
}}$rewrite = Aspis_array_merge($rewrite,array(array(deregisterTaint($match) => addTaint($query)),false));
if ( $post[0])
 {$rewrite = Aspis_array_merge(array(array(deregisterTaint($trackbackmatch) => addTaint($trackbackquery)),false),$rewrite);
if ( (denot_boolean($page)))
 $rewrite = Aspis_array_merge($rewrite,array(array(deregisterTaint($sub1) => addTaint($subquery),deregisterTaint($sub1tb) => addTaint($subtbquery),deregisterTaint($sub1feed) => addTaint($subfeedquery),deregisterTaint($sub1feed2) => addTaint($subfeedquery),deregisterTaint($sub1comment) => addTaint($subcommentquery)),false));
$rewrite = Aspis_array_merge(array(array(deregisterTaint($sub2) => addTaint($subquery),deregisterTaint($sub2tb) => addTaint($subtbquery),deregisterTaint($sub2feed) => addTaint($subfeedquery),deregisterTaint($sub2feed2) => addTaint($subfeedquery),deregisterTaint($sub2comment) => addTaint($subcommentquery)),false),$rewrite);
}}$post_rewrite = Aspis_array_merge($rewrite,$post_rewrite);
}return $post_rewrite;
} }
function generate_rewrite_rule ( $permalink_structure,$walk_dirs = array(false,false) ) {
{return $this->generate_rewrite_rules($permalink_structure,array(EP_NONE,false),array(false,false),array(false,false),array(false,false),$walk_dirs);
} }
function rewrite_rules (  ) {
{$rewrite = array(array(),false);
if ( ((empty($this->permalink_structure) || Aspis_empty( $this ->permalink_structure ))))
 {return $rewrite;
}$robots_rewrite = array(array(deregisterTaint(array('robots\.txt$',false)) => addTaint(concat2($this->index,'?robots=1'))),false);
$default_feeds = array(array(deregisterTaint(array('.*wp-atom.php$',false)) => addTaint(concat2($this->index,'?feed=atom')),deregisterTaint(array('.*wp-rdf.php$',false)) => addTaint(concat2($this->index,'?feed=rdf')),deregisterTaint(array('.*wp-rss.php$',false)) => addTaint(concat2($this->index,'?feed=rss')),deregisterTaint(array('.*wp-rss2.php$',false)) => addTaint(concat2($this->index,'?feed=rss2')),deregisterTaint(array('.*wp-feed.php$',false)) => addTaint(concat2($this->index,'?feed=feed')),deregisterTaint(array('.*wp-commentsrss2.php$',false)) => addTaint(concat2($this->index,'?feed=rss2&withcomments=1'))),false);
$post_rewrite = $this->generate_rewrite_rules($this->permalink_structure,array(EP_PERMALINK,false));
$post_rewrite = apply_filters(array('post_rewrite_rules',false),$post_rewrite);
$date_rewrite = $this->generate_rewrite_rules($this->get_date_permastruct(),array(EP_DATE,false));
$date_rewrite = apply_filters(array('date_rewrite_rules',false),$date_rewrite);
$root_rewrite = $this->generate_rewrite_rules(concat2($this->root,'/'),array(EP_ROOT,false));
$root_rewrite = apply_filters(array('root_rewrite_rules',false),$root_rewrite);
$comments_rewrite = $this->generate_rewrite_rules(concat($this->root,$this->comments_base),array(EP_COMMENTS,false),array(true,false),array(true,false),array(true,false),array(false,false));
$comments_rewrite = apply_filters(array('comments_rewrite_rules',false),$comments_rewrite);
$search_structure = $this->get_search_permastruct();
$search_rewrite = $this->generate_rewrite_rules($search_structure,array(EP_SEARCH,false));
$search_rewrite = apply_filters(array('search_rewrite_rules',false),$search_rewrite);
$category_rewrite = $this->generate_rewrite_rules($this->get_category_permastruct(),array(EP_CATEGORIES,false));
$category_rewrite = apply_filters(array('category_rewrite_rules',false),$category_rewrite);
$tag_rewrite = $this->generate_rewrite_rules($this->get_tag_permastruct(),array(EP_TAGS,false));
$tag_rewrite = apply_filters(array('tag_rewrite_rules',false),$tag_rewrite);
$author_rewrite = $this->generate_rewrite_rules($this->get_author_permastruct(),array(EP_AUTHORS,false));
$author_rewrite = apply_filters(array('author_rewrite_rules',false),$author_rewrite);
$page_rewrite = $this->page_rewrite_rules();
$page_rewrite = apply_filters(array('page_rewrite_rules',false),$page_rewrite);
foreach ( $this->extra_permastructs[0] as $permastruct  )
$this->extra_rules_top = Aspis_array_merge($this->extra_rules_top,$this->generate_rewrite_rules($permastruct,array(EP_NONE,false)));
if ( $this->use_verbose_page_rules[0])
 $this->rules = Aspis_array_merge($this->extra_rules_top,$robots_rewrite,$default_feeds,$page_rewrite,$root_rewrite,$comments_rewrite,$search_rewrite,$category_rewrite,$tag_rewrite,$author_rewrite,$date_rewrite,$post_rewrite,$this->extra_rules);
else 
{$this->rules = Aspis_array_merge($this->extra_rules_top,$robots_rewrite,$default_feeds,$root_rewrite,$comments_rewrite,$search_rewrite,$category_rewrite,$tag_rewrite,$author_rewrite,$date_rewrite,$post_rewrite,$page_rewrite,$this->extra_rules);
}do_action_ref_array(array('generate_rewrite_rules',false),array(array(array($this,false)),false));
$this->rules = apply_filters(array('rewrite_rules_array',false),$this->rules);
return $this->rules;
} }
function wp_rewrite_rules (  ) {
{$this->rules = get_option(array('rewrite_rules',false));
if ( ((empty($this->rules) || Aspis_empty( $this ->rules ))))
 {$this->matches = array('matches',false);
$this->rewrite_rules();
update_option(array('rewrite_rules',false),$this->rules);
}return $this->rules;
} }
function mod_rewrite_rules (  ) {
{if ( (denot_boolean($this->using_permalinks())))
 {return array('',false);
}$site_root = Aspis_parse_url(get_option(array('siteurl',false)));
if ( ((isset($site_root[0][('path')]) && Aspis_isset( $site_root [0][('path')]))))
 {$site_root = trailingslashit($site_root[0]['path']);
}$home_root = Aspis_parse_url(get_option(array('home',false)));
if ( ((isset($home_root[0][('path')]) && Aspis_isset( $home_root [0][('path')]))))
 {$home_root = trailingslashit($home_root[0]['path']);
}else 
{{$home_root = array('/',false);
}}$rules = array("<IfModule mod_rewrite.c>\n",false);
$rules = concat2($rules,"RewriteEngine On\n");
$rules = concat($rules,concat2(concat1("RewriteBase ",$home_root),"\n"));
foreach ( deAspis(array_cast($this->non_wp_rules)) as $match =>$query )
{restoreTaint($match,$query);
{$match = Aspis_str_replace(array('.+?',false),array('.+',false),$match);
if ( (($match[0] == ('(.+)/?$')) || ($match[0] == ('([^/]+)/?$'))))
 {}$rules = concat($rules,concat2(concat(concat(concat2(concat1('RewriteRule ^',$match),' '),$home_root),$query)," [QSA,L]\n"));
}}if ( $this->use_verbose_rules[0])
 {$this->matches = array('',false);
$rewrite = $this->rewrite_rules();
$num_rules = attAspis(count($rewrite[0]));
$rules = concat($rules,concat(concat12("RewriteCond %{REQUEST_FILENAME} -f [OR]\n","RewriteCond %{REQUEST_FILENAME} -d\n"),concat2(concat1("RewriteRule ^.*$ - [S=",$num_rules),"]\n")));
foreach ( deAspis(array_cast($rewrite)) as $match =>$query )
{restoreTaint($match,$query);
{$match = Aspis_str_replace(array('.+?',false),array('.+',false),$match);
if ( (($match[0] == ('(.+)/?$')) || ($match[0] == ('([^/]+)/?$'))))
 {}if ( (strpos($query[0],deAspisRC($this->index)) !== false))
 {$rules = concat($rules,concat2(concat(concat(concat2(concat1('RewriteRule ^',$match),' '),$home_root),$query)," [QSA,L]\n"));
}else 
{{$rules = concat($rules,concat2(concat(concat(concat2(concat1('RewriteRule ^',$match),' '),$site_root),$query)," [QSA,L]\n"));
}}}}}else 
{{$rules = concat($rules,concat(concat12("RewriteCond %{REQUEST_FILENAME} !-f\n","RewriteCond %{REQUEST_FILENAME} !-d\n"),concat2(concat1("RewriteRule . ",$home_root)," [L]\n")));
}}$rules = concat2($rules,"</IfModule>\n");
$rules = apply_filters(array('mod_rewrite_rules',false),$rules);
$rules = apply_filters(array('rewrite_rules',false),$rules);
return $rules;
} }
function iis7_url_rewrite_rules ( $add_parent_tags = array(false,false),$indent = array("  ",false),$end_of_line = array("\n",false) ) {
{if ( (denot_boolean($this->using_permalinks())))
 {return array('',false);
}$rules = array('',false);
$extra_indent = array('',false);
if ( $add_parent_tags[0])
 {$rules = concat($rules,concat1("<configuration>",$end_of_line));
$rules = concat($rules,concat(concat2($indent,"<system.webServer>"),$end_of_line));
$rules = concat($rules,concat(concat2(concat($indent,$indent),"<rewrite>"),$end_of_line));
$rules = concat($rules,concat(concat2(concat(concat($indent,$indent),$indent),"<rules>"),$end_of_line));
$extra_indent = concat(concat(concat($indent,$indent),$indent),$indent);
}$rules = concat($rules,concat(concat2($extra_indent,"<rule name=\"wordpress\" patternSyntax=\"Wildcard\">"),$end_of_line));
$rules = concat($rules,concat(concat2(concat($extra_indent,$indent),"<match url=\"*\" />"),$end_of_line));
$rules = concat($rules,concat(concat2(concat(concat($extra_indent,$indent),$indent),"<conditions>"),$end_of_line));
$rules = concat($rules,concat(concat2(concat(concat(concat($extra_indent,$indent),$indent),$indent),"<add input=\"{REQUEST_FILENAME}\" matchType=\"IsFile\" negate=\"true\" />"),$end_of_line));
$rules = concat($rules,concat(concat2(concat(concat(concat($extra_indent,$indent),$indent),$indent),"<add input=\"{REQUEST_FILENAME}\" matchType=\"IsDirectory\" negate=\"true\" />"),$end_of_line));
$rules = concat($rules,concat(concat2(concat(concat($extra_indent,$indent),$indent),"</conditions>"),$end_of_line));
$rules = concat($rules,concat(concat2(concat($extra_indent,$indent),"<action type=\"Rewrite\" url=\"index.php\" />"),$end_of_line));
$rules = concat($rules,concat2($extra_indent,"</rule>"));
if ( $add_parent_tags[0])
 {$rules = concat($rules,concat(concat2(concat(concat(concat($end_of_line,$indent),$indent),$indent),"</rules>"),$end_of_line));
$rules = concat($rules,concat(concat2(concat($indent,$indent),"</rewrite>"),$end_of_line));
$rules = concat($rules,concat(concat2($indent,"</system.webServer>"),$end_of_line));
$rules = concat2($rules,"</configuration>");
}$rules = apply_filters(array('iis7_url_rewrite_rules',false),$rules);
return $rules;
} }
function add_rule ( $regex,$redirect,$after = array('bottom',false) ) {
{$index = ((strpos($redirect[0],'?') == false) ? attAspis(strlen($redirect[0])) : attAspis(strpos($redirect[0],'?')));
$front = Aspis_substr($redirect,array(0,false),$index);
if ( ($front[0] != $this->index[0]))
 {$this->add_external_rule($regex,$redirect);
}else 
{{if ( (('bottom') == $after[0]))
 $this->extra_rules = Aspis_array_merge($this->extra_rules,array(array(deregisterTaint($regex) => addTaint($redirect)),false));
else 
{$this->extra_rules_top = Aspis_array_merge($this->extra_rules_top,array(array(deregisterTaint($regex) => addTaint($redirect)),false));
}}}} }
function add_external_rule ( $regex,$redirect ) {
{arrayAssign($this->non_wp_rules[0],deAspis(registerTaint($regex)),addTaint($redirect));
} }
function add_endpoint ( $name,$places ) {
{global $wp;
arrayAssignAdd($this->endpoints[0][],addTaint(array(array($places,$name),false)));
$wp[0]->add_query_var($name);
} }
function add_permastruct ( $name,$struct,$with_front = array(true,false) ) {
{if ( $with_front[0])
 $struct = concat($this->front,$struct);
arrayAssign($this->extra_permastructs[0],deAspis(registerTaint($name)),addTaint($struct));
} }
function flush_rules ( $hard = array(true,false) ) {
{delete_option(array('rewrite_rules',false));
$this->wp_rewrite_rules();
if ( ($hard[0] && function_exists(('save_mod_rewrite_rules'))))
 save_mod_rewrite_rules();
if ( ($hard[0] && function_exists(('iis7_save_url_rewrite_rules'))))
 iis7_save_url_rewrite_rules();
} }
function init (  ) {
{$this->extra_rules = $this->non_wp_rules = $this->endpoints = array(array(),false);
$this->permalink_structure = get_option(array('permalink_structure',false));
$this->front = Aspis_substr($this->permalink_structure,array(0,false),attAspis(strpos($this->permalink_structure[0],'%')));
$this->root = array('',false);
if ( deAspis($this->using_index_permalinks()))
 {$this->root = concat2($this->index,'/');
}$this->category_base = get_option(array('category_base',false));
$this->tag_base = get_option(array('tag_base',false));
unset($this->category_structure);
unset($this->author_structure);
unset($this->date_structure);
unset($this->page_structure);
unset($this->search_structure);
unset($this->feed_structure);
unset($this->comment_feed_structure);
$this->use_trailing_slashes = (deAspis(Aspis_substr($this->permalink_structure,negate(array(1,false)),array(1,false))) == ('/')) ? array(true,false) : array(false,false);
if ( deAspis(Aspis_preg_match(array("/^[^%]*%(?:postname|category|tag|author)%/",false),$this->permalink_structure)))
 $this->use_verbose_page_rules = array(true,false);
else 
{$this->use_verbose_page_rules = array(false,false);
}} }
function set_permalink_structure ( $permalink_structure ) {
{if ( ($permalink_structure[0] != $this->permalink_structure[0]))
 {update_option(array('permalink_structure',false),$permalink_structure);
$this->init();
do_action(array('permalink_structure_changed',false),$this->permalink_structure,$permalink_structure);
}} }
function set_category_base ( $category_base ) {
{if ( ($category_base[0] != $this->category_base[0]))
 {update_option(array('category_base',false),$category_base);
$this->init();
}} }
function set_tag_base ( $tag_base ) {
{if ( ($tag_base[0] != $this->tag_base[0]))
 {update_option(array('tag_base',false),$tag_base);
$this->init();
}} }
function WP_Rewrite (  ) {
{$this->init();
} }
};
?>
<?php 