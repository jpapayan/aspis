<?php require_once('AspisMain.php'); ?><?php
function add_rewrite_rule ( $regex,$redirect,$after = 'bottom' ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$wp_rewrite->add_rule($regex,$redirect,$after);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function add_rewrite_tag ( $tagname,$regex ) {
if ( strlen($tagname) < 3 || $tagname[0] != '%' || $tagname[strlen($tagname) - 1] != '%')
 {{return ;
}}$qv = trim($tagname,'%');
{global $wp_rewrite,$wp;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp,"\$wp",$AspisChangesCache);
}$wp->add_query_var($qv);
$wp_rewrite->add_rewrite_tag($tagname,$regex,$qv . '=');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp",$AspisChangesCache);
 }
function add_feed ( $feedname,$function ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}if ( !in_array($feedname,$wp_rewrite->feeds))
 {$wp_rewrite->feeds[] = $feedname;
}$hook = 'do_feed_' . $feedname;
remove_action($hook,$hook,10,1);
add_action($hook,$function,10,1);
{$AspisRetTemp = $hook;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
define('EP_PERMALINK',1);
define('EP_ATTACHMENT',2);
define('EP_DATE',4);
define('EP_YEAR',8);
define('EP_MONTH',16);
define('EP_DAY',32);
define('EP_ROOT',64);
define('EP_COMMENTS',128);
define('EP_SEARCH',256);
define('EP_CATEGORIES',512);
define('EP_TAGS',1024);
define('EP_AUTHORS',2048);
define('EP_PAGES',4096);
define('EP_NONE',0);
define('EP_ALL',8191);
function add_rewrite_endpoint ( $name,$places ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$wp_rewrite->add_endpoint($name,$places);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function _wp_filter_taxonomy_base ( $base ) {
if ( !empty($base))
 {$base = preg_replace('|^/index\.php/|','',$base);
$base = trim($base,'/');
}{$AspisRetTemp = $base;
return $AspisRetTemp;
} }
function url_to_postid ( $url ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$url = apply_filters('url_to_postid',$url);
if ( preg_match('#[?&](p|page_id|attachment_id)=(\d+)#',$url,$values))
 {$id = absint($values[2]);
if ( $id)
 {$AspisRetTemp = $id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}$rewrite = $wp_rewrite->wp_rewrite_rules();
if ( empty($rewrite))
 {$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}$url_split = explode('#',$url);
$url = $url_split[0];
$url_split = explode('?',$url);
$url = $url_split[0];
if ( false !== strpos(get_option('home'),'://www.') && false === strpos($url,'://www.'))
 $url = str_replace('://','://www.',$url);
if ( false === strpos(get_option('home'),'://www.'))
 $url = str_replace('://www.','://',$url);
if ( !$wp_rewrite->using_index_permalinks())
 $url = str_replace('index.php/','',$url);
if ( false !== strpos($url,get_option('home')))
 {$url = str_replace(get_option('home'),'',$url);
}else 
{{$home_path = parse_url(get_option('home'));
$home_path = $home_path['path'];
$url = str_replace($home_path,'',$url);
}}$url = trim($url,'/');
$request = $url;
$request_match = $request;
foreach ( $rewrite as $match =>$query )
{if ( (!empty($url)) && (strpos($match,$url) === 0) && ($url != $request))
 {$request_match = $url . '/' . $request;
}if ( preg_match("!^$match!",$request_match,$matches))
 {$query = preg_replace("!^.+\?!",'',$query);
$query = addslashes(WP_MatchesMapRegex::apply($query,$matches));
{global $wp;
$AspisVar1 = &AspisCleanTaintedGlobalUntainted( $wp,"\$wp",$AspisChangesCache);
}parse_str($query,$query_vars);
$query = array();
foreach ( (array)$query_vars as $key =>$value )
{if ( in_array($key,$wp->public_query_vars))
 $query[$key] = $value;
}$query = new WP_Query($query);
if ( $query->is_single || $query->is_page)
 {$AspisRetTemp = $query->post->ID;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp",$AspisChangesCache);
return $AspisRetTemp;
}}}}{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp",$AspisChangesCache);
 }
class WP_Rewrite{var $permalink_structure;
var $use_trailing_slashes;
var $category_base;
var $tag_base;
var $category_structure;
var $tag_structure;
var $author_base = 'author';
var $author_structure;
var $date_structure;
var $page_structure;
var $search_base = 'search';
var $search_structure;
var $comments_base = 'comments';
var $feed_base = 'feed';
var $comments_feed_structure;
var $feed_structure;
var $front;
var $root = '';
var $index = 'index.php';
var $matches = '';
var $rules;
var $extra_rules = array();
var $extra_rules_top = array();
var $non_wp_rules = array();
var $extra_permastructs = array();
var $endpoints;
var $use_verbose_rules = false;
var $use_verbose_page_rules = true;
var $rewritecode = array('%year%','%monthnum%','%day%','%hour%','%minute%','%second%','%postname%','%post_id%','%category%','%tag%','%author%','%pagename%','%search%');
var $rewritereplace = array('([0-9]{4})','([0-9]{1,2})','([0-9]{1,2})','([0-9]{1,2})','([0-9]{1,2})','([0-9]{1,2})','([^/]+)','([0-9]+)','(.+?)','(.+?)','([^/]+)','([^/]+?)','(.+)');
var $queryreplace = array('year=','monthnum=','day=','hour=','minute=','second=','name=','p=','category_name=','tag=','author_name=','pagename=','s=');
var $feeds = array('feed','rdf','rss','rss2','atom');
function using_permalinks (  ) {
{if ( empty($this->permalink_structure))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = true;
return $AspisRetTemp;
}}} }
function using_index_permalinks (  ) {
{if ( empty($this->permalink_structure))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( preg_match('#^/*' . $this->index . '#',$this->permalink_structure))
 {{$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function using_mod_rewrite_permalinks (  ) {
{if ( $this->using_permalinks() && !$this->using_index_permalinks())
 {$AspisRetTemp = true;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
return $AspisRetTemp;
}}} }
function preg_index ( $number ) {
{$match_prefix = '$';
$match_suffix = '';
if ( !empty($this->matches))
 {$match_prefix = '$' . $this->matches . '[';
$match_suffix = ']';
}{$AspisRetTemp = "$match_prefix$number$match_suffix";
return $AspisRetTemp;
}} }
function page_uri_index (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$posts = get_page_hierarchy($wpdb->get_results("SELECT ID, post_name, post_parent FROM $wpdb->posts WHERE post_type = 'page'"));
$posts = array_reverse($posts,true);
$page_uris = array();
$page_attachment_uris = array();
if ( !$posts)
 {$AspisRetTemp = array(array(),array());
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}foreach ( $posts as $id =>$post )
{$uri = get_page_uri($id);
$attachments = $wpdb->get_results($wpdb->prepare("SELECT ID, post_name, post_parent FROM $wpdb->posts WHERE post_type = 'attachment' AND post_parent = %d",$id));
if ( $attachments)
 {foreach ( $attachments as $attachment  )
{$attach_uri = get_page_uri($attachment->ID);
$page_attachment_uris[$attach_uri] = $attachment->ID;
}}$page_uris[$uri] = $id;
}{$AspisRetTemp = array($page_uris,$page_attachment_uris);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function page_rewrite_rules (  ) {
{$rewrite_rules = array();
$page_structure = $this->get_page_permastruct();
if ( !$this->use_verbose_page_rules)
 {$this->add_rewrite_tag('%pagename%',"(.+?)",'pagename=');
$rewrite_rules = array_merge($rewrite_rules,$this->generate_rewrite_rules($page_structure,EP_PAGES));
{$AspisRetTemp = $rewrite_rules;
return $AspisRetTemp;
}}$page_uris = $this->page_uri_index();
$uris = $page_uris[0];
$attachment_uris = $page_uris[1];
if ( is_array($attachment_uris))
 {foreach ( $attachment_uris as $uri =>$pagename )
{$this->add_rewrite_tag('%pagename%',"($uri)",'attachment=');
$rewrite_rules = array_merge($rewrite_rules,$this->generate_rewrite_rules($page_structure,EP_PAGES));
}}if ( is_array($uris))
 {foreach ( $uris as $uri =>$pagename )
{$this->add_rewrite_tag('%pagename%',"($uri)",'pagename=');
$rewrite_rules = array_merge($rewrite_rules,$this->generate_rewrite_rules($page_structure,EP_PAGES));
}}{$AspisRetTemp = $rewrite_rules;
return $AspisRetTemp;
}} }
function get_date_permastruct (  ) {
{if ( isset($this->date_structure))
 {{$AspisRetTemp = $this->date_structure;
return $AspisRetTemp;
}}if ( empty($this->permalink_structure))
 {$this->date_structure = '';
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$endians = array('%year%/%monthnum%/%day%','%day%/%monthnum%/%year%','%monthnum%/%day%/%year%');
$this->date_structure = '';
$date_endian = '';
foreach ( $endians as $endian  )
{if ( false !== strpos($this->permalink_structure,$endian))
 {$date_endian = $endian;
break ;
}}if ( empty($date_endian))
 $date_endian = '%year%/%monthnum%/%day%';
$front = $this->front;
preg_match_all('/%.+?%/',$this->permalink_structure,$tokens);
$tok_index = 1;
foreach ( (array)$tokens[0] as $token  )
{if ( ($token == '%post_id%') && ($tok_index <= 3))
 {$front = $front . 'date/';
break ;
}$tok_index++;
}$this->date_structure = $front . $date_endian;
{$AspisRetTemp = $this->date_structure;
return $AspisRetTemp;
}} }
function get_year_permastruct (  ) {
{$structure = $this->get_date_permastruct($this->permalink_structure);
if ( empty($structure))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$structure = str_replace('%monthnum%','',$structure);
$structure = str_replace('%day%','',$structure);
$structure = preg_replace('#/+#','/',$structure);
{$AspisRetTemp = $structure;
return $AspisRetTemp;
}} }
function get_month_permastruct (  ) {
{$structure = $this->get_date_permastruct($this->permalink_structure);
if ( empty($structure))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$structure = str_replace('%day%','',$structure);
$structure = preg_replace('#/+#','/',$structure);
{$AspisRetTemp = $structure;
return $AspisRetTemp;
}} }
function get_day_permastruct (  ) {
{{$AspisRetTemp = $this->get_date_permastruct($this->permalink_structure);
return $AspisRetTemp;
}} }
function get_category_permastruct (  ) {
{if ( isset($this->category_structure))
 {{$AspisRetTemp = $this->category_structure;
return $AspisRetTemp;
}}if ( empty($this->permalink_structure))
 {$this->category_structure = '';
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( empty($this->category_base))
 $this->category_structure = trailingslashit($this->front . 'category');
else 
{$this->category_structure = trailingslashit('/' . $this->root . $this->category_base);
}$this->category_structure .= '%category%';
{$AspisRetTemp = $this->category_structure;
return $AspisRetTemp;
}} }
function get_tag_permastruct (  ) {
{if ( isset($this->tag_structure))
 {{$AspisRetTemp = $this->tag_structure;
return $AspisRetTemp;
}}if ( empty($this->permalink_structure))
 {$this->tag_structure = '';
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( empty($this->tag_base))
 $this->tag_structure = trailingslashit($this->front . 'tag');
else 
{$this->tag_structure = trailingslashit('/' . $this->root . $this->tag_base);
}$this->tag_structure .= '%tag%';
{$AspisRetTemp = $this->tag_structure;
return $AspisRetTemp;
}} }
function get_extra_permastruct ( $name ) {
{if ( empty($this->permalink_structure))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( isset($this->extra_permastructs[$name]))
 {$AspisRetTemp = $this->extra_permastructs[$name];
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function get_author_permastruct (  ) {
{if ( isset($this->author_structure))
 {{$AspisRetTemp = $this->author_structure;
return $AspisRetTemp;
}}if ( empty($this->permalink_structure))
 {$this->author_structure = '';
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->author_structure = $this->front . $this->author_base . '/%author%';
{$AspisRetTemp = $this->author_structure;
return $AspisRetTemp;
}} }
function get_search_permastruct (  ) {
{if ( isset($this->search_structure))
 {{$AspisRetTemp = $this->search_structure;
return $AspisRetTemp;
}}if ( empty($this->permalink_structure))
 {$this->search_structure = '';
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->search_structure = $this->root . $this->search_base . '/%search%';
{$AspisRetTemp = $this->search_structure;
return $AspisRetTemp;
}} }
function get_page_permastruct (  ) {
{if ( isset($this->page_structure))
 {{$AspisRetTemp = $this->page_structure;
return $AspisRetTemp;
}}if ( empty($this->permalink_structure))
 {$this->page_structure = '';
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->page_structure = $this->root . '%pagename%';
{$AspisRetTemp = $this->page_structure;
return $AspisRetTemp;
}} }
function get_feed_permastruct (  ) {
{if ( isset($this->feed_structure))
 {{$AspisRetTemp = $this->feed_structure;
return $AspisRetTemp;
}}if ( empty($this->permalink_structure))
 {$this->feed_structure = '';
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->feed_structure = $this->root . $this->feed_base . '/%feed%';
{$AspisRetTemp = $this->feed_structure;
return $AspisRetTemp;
}} }
function get_comment_feed_permastruct (  ) {
{if ( isset($this->comment_feed_structure))
 {{$AspisRetTemp = $this->comment_feed_structure;
return $AspisRetTemp;
}}if ( empty($this->permalink_structure))
 {$this->comment_feed_structure = '';
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->comment_feed_structure = $this->root . $this->comments_base . '/' . $this->feed_base . '/%feed%';
{$AspisRetTemp = $this->comment_feed_structure;
return $AspisRetTemp;
}} }
function add_rewrite_tag ( $tag,$pattern,$query ) {
{$position = array_search($tag,$this->rewritecode);
if ( false !== $position && null !== $position)
 {$this->rewritereplace[$position] = $pattern;
$this->queryreplace[$position] = $query;
}else 
{{$this->rewritecode[] = $tag;
$this->rewritereplace[] = $pattern;
$this->queryreplace[] = $query;
}}} }
function generate_rewrite_rules ( $permalink_structure,$ep_mask = EP_NONE,$paged = true,$feed = true,$forcomments = false,$walk_dirs = true,$endpoints = true ) {
{$feedregex2 = '';
foreach ( (array)$this->feeds as $feed_name  )
{$feedregex2 .= $feed_name . '|';
}$feedregex2 = '(' . trim($feedregex2,'|') . ')/?$';
$feedregex = $this->feed_base . '/' . $feedregex2;
$trackbackregex = 'trackback/?$';
$pageregex = 'page/?([0-9]{1,})/?$';
$commentregex = 'comment-page-([0-9]{1,})/?$';
if ( $endpoints)
 {$ep_query_append = array();
foreach ( (array)$this->endpoints as $endpoint  )
{$epmatch = $endpoint[1] . '(/(.*))?/?$';
$epquery = '&' . $endpoint[1] . '=';
$ep_query_append[$epmatch] = array($endpoint[0],$epquery);
}}$front = substr($permalink_structure,0,strpos($permalink_structure,'%'));
preg_match_all('/%.+?%/',$permalink_structure,$tokens);
$num_tokens = count($tokens[0]);
$index = $this->index;
$feedindex = $index;
$trackbackindex = $index;
for ( $i = 0 ; $i < $num_tokens ; ++$i )
{if ( 0 < $i)
 {$queries[$i] = $queries[$i - 1] . '&';
}else 
{{$queries[$i] = '';
}}$query_token = str_replace($this->rewritecode,$this->queryreplace,$tokens[0][$i]) . $this->preg_index($i + 1);
$queries[$i] .= $query_token;
}$structure = $permalink_structure;
if ( $front != '/')
 {$structure = str_replace($front,'',$structure);
}$structure = trim($structure,'/');
if ( $walk_dirs)
 {$dirs = explode('/',$structure);
}else 
{{$dirs[] = $structure;
}}$num_dirs = count($dirs);
$front = preg_replace('|^/+|','',$front);
$post_rewrite = array();
$struct = $front;
for ( $j = 0 ; $j < $num_dirs ; ++$j )
{$struct .= $dirs[$j] . '/';
$struct = ltrim($struct,'/');
$match = str_replace($this->rewritecode,$this->rewritereplace,$struct);
$num_toks = preg_match_all('/%.+?%/',$struct,$toks);
$query = (isset($queries) && is_array($queries)) ? $queries[$num_toks - 1] : '';
switch ( $dirs[$j] ) {
case '%year%':$ep_mask_specific = EP_YEAR;
break ;
case '%monthnum%':$ep_mask_specific = EP_MONTH;
break ;
case '%day%':$ep_mask_specific = EP_DAY;
break ;
 }
$pagematch = $match . $pageregex;
$pagequery = $index . '?' . $query . '&paged=' . $this->preg_index($num_toks + 1);
$commentmatch = $match . $commentregex;
$commentquery = $index . '?' . $query . '&cpage=' . $this->preg_index($num_toks + 1);
if ( get_option('page_on_front'))
 {$rootcommentmatch = $match . $commentregex;
$rootcommentquery = $index . '?' . $query . '&page_id=' . get_option('page_on_front') . '&cpage=' . $this->preg_index($num_toks + 1);
}$feedmatch = $match . $feedregex;
$feedquery = $feedindex . '?' . $query . '&feed=' . $this->preg_index($num_toks + 1);
$feedmatch2 = $match . $feedregex2;
$feedquery2 = $feedindex . '?' . $query . '&feed=' . $this->preg_index($num_toks + 1);
if ( $forcomments)
 {$feedquery .= '&withcomments=1';
$feedquery2 .= '&withcomments=1';
}$rewrite = array();
if ( $feed)
 $rewrite = array($feedmatch => $feedquery,$feedmatch2 => $feedquery2);
if ( $paged)
 $rewrite = array_merge($rewrite,array($pagematch => $pagequery));
if ( EP_PAGES & $ep_mask || EP_PERMALINK & $ep_mask || EP_NONE & $ep_mask)
 $rewrite = array_merge($rewrite,array($commentmatch => $commentquery));
else 
{if ( EP_ROOT & $ep_mask && get_option('page_on_front'))
 $rewrite = array_merge($rewrite,array($rootcommentmatch => $rootcommentquery));
}if ( $endpoints)
 {foreach ( (array)$ep_query_append as $regex =>$ep )
{if ( $ep[0] & $ep_mask || $ep[0] & $ep_mask_specific)
 {$rewrite[$match . $regex] = $index . '?' . $query . $ep[1] . $this->preg_index($num_toks + 2);
}}}if ( $num_toks)
 {$post = false;
$page = false;
if ( strpos($struct,'%postname%') !== false || strpos($struct,'%post_id%') !== false || strpos($struct,'%pagename%') !== false || (strpos($struct,'%year%') !== false && strpos($struct,'%monthnum%') !== false && strpos($struct,'%day%') !== false && strpos($struct,'%hour%') !== false && strpos($struct,'%minute%') !== false && strpos($struct,'%second%') !== false))
 {$post = true;
if ( strpos($struct,'%pagename%') !== false)
 $page = true;
}if ( $post)
 {$post = true;
$trackbackmatch = $match . $trackbackregex;
$trackbackquery = $trackbackindex . '?' . $query . '&tb=1';
$match = rtrim($match,'/');
$submatchbase = str_replace(array('(',')'),'',$match);
$sub1 = $submatchbase . '/([^/]+)/';
$sub1tb = $sub1 . $trackbackregex;
$sub1feed = $sub1 . $feedregex;
$sub1feed2 = $sub1 . $feedregex2;
$sub1comment = $sub1 . $commentregex;
$sub2 = $submatchbase . '/attachment/([^/]+)/';
$sub2tb = $sub2 . $trackbackregex;
$sub2feed = $sub2 . $feedregex;
$sub2feed2 = $sub2 . $feedregex2;
$sub2comment = $sub2 . $commentregex;
$subquery = $index . '?attachment=' . $this->preg_index(1);
$subtbquery = $subquery . '&tb=1';
$subfeedquery = $subquery . '&feed=' . $this->preg_index(2);
$subcommentquery = $subquery . '&cpage=' . $this->preg_index(2);
if ( !empty($endpoints))
 {foreach ( (array)$ep_query_append as $regex =>$ep )
{if ( $ep[0] & EP_ATTACHMENT)
 {$rewrite[$sub1 . $regex] = $subquery . $ep[1] . $this->preg_index(2);
$rewrite[$sub2 . $regex] = $subquery . $ep[1] . $this->preg_index(2);
}}}$sub1 .= '?$';
$sub2 .= '?$';
$match = $match . '(/[0-9]+)?/?$';
$query = $index . '?' . $query . '&page=' . $this->preg_index($num_toks + 1);
}else 
{{$match .= '?$';
$query = $index . '?' . $query;
}}$rewrite = array_merge($rewrite,array($match => $query));
if ( $post)
 {$rewrite = array_merge(array($trackbackmatch => $trackbackquery),$rewrite);
if ( !$page)
 $rewrite = array_merge($rewrite,array($sub1 => $subquery,$sub1tb => $subtbquery,$sub1feed => $subfeedquery,$sub1feed2 => $subfeedquery,$sub1comment => $subcommentquery));
$rewrite = array_merge(array($sub2 => $subquery,$sub2tb => $subtbquery,$sub2feed => $subfeedquery,$sub2feed2 => $subfeedquery,$sub2comment => $subcommentquery),$rewrite);
}}$post_rewrite = array_merge($rewrite,$post_rewrite);
}{$AspisRetTemp = $post_rewrite;
return $AspisRetTemp;
}} }
function generate_rewrite_rule ( $permalink_structure,$walk_dirs = false ) {
{{$AspisRetTemp = $this->generate_rewrite_rules($permalink_structure,EP_NONE,false,false,false,$walk_dirs);
return $AspisRetTemp;
}} }
function rewrite_rules (  ) {
{$rewrite = array();
if ( empty($this->permalink_structure))
 {{$AspisRetTemp = $rewrite;
return $AspisRetTemp;
}}$robots_rewrite = array('robots\.txt$' => $this->index . '?robots=1');
$default_feeds = array('.*wp-atom.php$' => $this->index . '?feed=atom','.*wp-rdf.php$' => $this->index . '?feed=rdf','.*wp-rss.php$' => $this->index . '?feed=rss','.*wp-rss2.php$' => $this->index . '?feed=rss2','.*wp-feed.php$' => $this->index . '?feed=feed','.*wp-commentsrss2.php$' => $this->index . '?feed=rss2&withcomments=1');
$post_rewrite = $this->generate_rewrite_rules($this->permalink_structure,EP_PERMALINK);
$post_rewrite = apply_filters('post_rewrite_rules',$post_rewrite);
$date_rewrite = $this->generate_rewrite_rules($this->get_date_permastruct(),EP_DATE);
$date_rewrite = apply_filters('date_rewrite_rules',$date_rewrite);
$root_rewrite = $this->generate_rewrite_rules($this->root . '/',EP_ROOT);
$root_rewrite = apply_filters('root_rewrite_rules',$root_rewrite);
$comments_rewrite = $this->generate_rewrite_rules($this->root . $this->comments_base,EP_COMMENTS,true,true,true,false);
$comments_rewrite = apply_filters('comments_rewrite_rules',$comments_rewrite);
$search_structure = $this->get_search_permastruct();
$search_rewrite = $this->generate_rewrite_rules($search_structure,EP_SEARCH);
$search_rewrite = apply_filters('search_rewrite_rules',$search_rewrite);
$category_rewrite = $this->generate_rewrite_rules($this->get_category_permastruct(),EP_CATEGORIES);
$category_rewrite = apply_filters('category_rewrite_rules',$category_rewrite);
$tag_rewrite = $this->generate_rewrite_rules($this->get_tag_permastruct(),EP_TAGS);
$tag_rewrite = apply_filters('tag_rewrite_rules',$tag_rewrite);
$author_rewrite = $this->generate_rewrite_rules($this->get_author_permastruct(),EP_AUTHORS);
$author_rewrite = apply_filters('author_rewrite_rules',$author_rewrite);
$page_rewrite = $this->page_rewrite_rules();
$page_rewrite = apply_filters('page_rewrite_rules',$page_rewrite);
foreach ( $this->extra_permastructs as $permastruct  )
$this->extra_rules_top = array_merge($this->extra_rules_top,$this->generate_rewrite_rules($permastruct,EP_NONE));
if ( $this->use_verbose_page_rules)
 $this->rules = array_merge($this->extra_rules_top,$robots_rewrite,$default_feeds,$page_rewrite,$root_rewrite,$comments_rewrite,$search_rewrite,$category_rewrite,$tag_rewrite,$author_rewrite,$date_rewrite,$post_rewrite,$this->extra_rules);
else 
{$this->rules = array_merge($this->extra_rules_top,$robots_rewrite,$default_feeds,$root_rewrite,$comments_rewrite,$search_rewrite,$category_rewrite,$tag_rewrite,$author_rewrite,$date_rewrite,$post_rewrite,$page_rewrite,$this->extra_rules);
}do_action_ref_array('generate_rewrite_rules',array($this));
$this->rules = apply_filters('rewrite_rules_array',$this->rules);
{$AspisRetTemp = $this->rules;
return $AspisRetTemp;
}} }
function wp_rewrite_rules (  ) {
{$this->rules = get_option('rewrite_rules');
if ( empty($this->rules))
 {$this->matches = 'matches';
$this->rewrite_rules();
update_option('rewrite_rules',$this->rules);
}{$AspisRetTemp = $this->rules;
return $AspisRetTemp;
}} }
function mod_rewrite_rules (  ) {
{if ( !$this->using_permalinks())
 {{$AspisRetTemp = '';
return $AspisRetTemp;
}}$site_root = parse_url(get_option('siteurl'));
if ( isset($site_root['path']))
 {$site_root = trailingslashit($site_root['path']);
}$home_root = parse_url(get_option('home'));
if ( isset($home_root['path']))
 {$home_root = trailingslashit($home_root['path']);
}else 
{{$home_root = '/';
}}$rules = "<IfModule mod_rewrite.c>\n";
$rules .= "RewriteEngine On\n";
$rules .= "RewriteBase $home_root\n";
foreach ( (array)$this->non_wp_rules as $match =>$query )
{$match = str_replace('.+?','.+',$match);
if ( $match == '(.+)/?$' || $match == '([^/]+)/?$')
 {}$rules .= 'RewriteRule ^' . $match . ' ' . $home_root . $query . " [QSA,L]\n";
}if ( $this->use_verbose_rules)
 {$this->matches = '';
$rewrite = $this->rewrite_rules();
$num_rules = count($rewrite);
$rules .= "RewriteCond %{REQUEST_FILENAME} -f [OR]\n" . "RewriteCond %{REQUEST_FILENAME} -d\n" . "RewriteRule ^.*$ - [S=$num_rules]\n";
foreach ( (array)$rewrite as $match =>$query )
{$match = str_replace('.+?','.+',$match);
if ( $match == '(.+)/?$' || $match == '([^/]+)/?$')
 {}if ( strpos($query,$this->index) !== false)
 {$rules .= 'RewriteRule ^' . $match . ' ' . $home_root . $query . " [QSA,L]\n";
}else 
{{$rules .= 'RewriteRule ^' . $match . ' ' . $site_root . $query . " [QSA,L]\n";
}}}}else 
{{$rules .= "RewriteCond %{REQUEST_FILENAME} !-f\n" . "RewriteCond %{REQUEST_FILENAME} !-d\n" . "RewriteRule . {$home_root}{$this->index} [L]\n";
}}$rules .= "</IfModule>\n";
$rules = apply_filters('mod_rewrite_rules',$rules);
$rules = apply_filters('rewrite_rules',$rules);
{$AspisRetTemp = $rules;
return $AspisRetTemp;
}} }
function iis7_url_rewrite_rules ( $add_parent_tags = false,$indent = "  ",$end_of_line = "\n" ) {
{if ( !$this->using_permalinks())
 {{$AspisRetTemp = '';
return $AspisRetTemp;
}}$rules = '';
$extra_indent = '';
if ( $add_parent_tags)
 {$rules .= "<configuration>" . $end_of_line;
$rules .= $indent . "<system.webServer>" . $end_of_line;
$rules .= $indent . $indent . "<rewrite>" . $end_of_line;
$rules .= $indent . $indent . $indent . "<rules>" . $end_of_line;
$extra_indent = $indent . $indent . $indent . $indent;
}$rules .= $extra_indent . "<rule name=\"wordpress\" patternSyntax=\"Wildcard\">" . $end_of_line;
$rules .= $extra_indent . $indent . "<match url=\"*\" />" . $end_of_line;
$rules .= $extra_indent . $indent . $indent . "<conditions>" . $end_of_line;
$rules .= $extra_indent . $indent . $indent . $indent . "<add input=\"{REQUEST_FILENAME}\" matchType=\"IsFile\" negate=\"true\" />" . $end_of_line;
$rules .= $extra_indent . $indent . $indent . $indent . "<add input=\"{REQUEST_FILENAME}\" matchType=\"IsDirectory\" negate=\"true\" />" . $end_of_line;
$rules .= $extra_indent . $indent . $indent . "</conditions>" . $end_of_line;
$rules .= $extra_indent . $indent . "<action type=\"Rewrite\" url=\"index.php\" />" . $end_of_line;
$rules .= $extra_indent . "</rule>";
if ( $add_parent_tags)
 {$rules .= $end_of_line . $indent . $indent . $indent . "</rules>" . $end_of_line;
$rules .= $indent . $indent . "</rewrite>" . $end_of_line;
$rules .= $indent . "</system.webServer>" . $end_of_line;
$rules .= "</configuration>";
}$rules = apply_filters('iis7_url_rewrite_rules',$rules);
{$AspisRetTemp = $rules;
return $AspisRetTemp;
}} }
function add_rule ( $regex,$redirect,$after = 'bottom' ) {
{$index = (strpos($redirect,'?') == false ? strlen($redirect) : strpos($redirect,'?'));
$front = substr($redirect,0,$index);
if ( $front != $this->index)
 {$this->add_external_rule($regex,$redirect);
}else 
{{if ( 'bottom' == $after)
 $this->extra_rules = array_merge($this->extra_rules,array($regex => $redirect));
else 
{$this->extra_rules_top = array_merge($this->extra_rules_top,array($regex => $redirect));
}}}} }
function add_external_rule ( $regex,$redirect ) {
{$this->non_wp_rules[$regex] = $redirect;
} }
function add_endpoint ( $name,$places ) {
{{global $wp;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp,"\$wp",$AspisChangesCache);
}$this->endpoints[] = array($places,$name);
$wp->add_query_var($name);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp",$AspisChangesCache);
 }
function add_permastruct ( $name,$struct,$with_front = true ) {
{if ( $with_front)
 $struct = $this->front . $struct;
$this->extra_permastructs[$name] = $struct;
} }
function flush_rules ( $hard = true ) {
{delete_option('rewrite_rules');
$this->wp_rewrite_rules();
if ( $hard && function_exists('save_mod_rewrite_rules'))
 save_mod_rewrite_rules();
if ( $hard && function_exists('iis7_save_url_rewrite_rules'))
 iis7_save_url_rewrite_rules();
} }
function init (  ) {
{$this->extra_rules = $this->non_wp_rules = $this->endpoints = array();
$this->permalink_structure = get_option('permalink_structure');
$this->front = substr($this->permalink_structure,0,strpos($this->permalink_structure,'%'));
$this->root = '';
if ( $this->using_index_permalinks())
 {$this->root = $this->index . '/';
}$this->category_base = get_option('category_base');
$this->tag_base = get_option('tag_base');
unset($this->category_structure);
unset($this->author_structure);
unset($this->date_structure);
unset($this->page_structure);
unset($this->search_structure);
unset($this->feed_structure);
unset($this->comment_feed_structure);
$this->use_trailing_slashes = (substr($this->permalink_structure,-1,1) == '/') ? true : false;
if ( preg_match("/^[^%]*%(?:postname|category|tag|author)%/",$this->permalink_structure))
 $this->use_verbose_page_rules = true;
else 
{$this->use_verbose_page_rules = false;
}} }
function set_permalink_structure ( $permalink_structure ) {
{if ( $permalink_structure != $this->permalink_structure)
 {update_option('permalink_structure',$permalink_structure);
$this->init();
do_action('permalink_structure_changed',$this->permalink_structure,$permalink_structure);
}} }
function set_category_base ( $category_base ) {
{if ( $category_base != $this->category_base)
 {update_option('category_base',$category_base);
$this->init();
}} }
function set_tag_base ( $tag_base ) {
{if ( $tag_base != $this->tag_base)
 {update_option('tag_base',$tag_base);
$this->init();
}} }
function WP_Rewrite (  ) {
{$this->init();
} }
};
?>
<?php 