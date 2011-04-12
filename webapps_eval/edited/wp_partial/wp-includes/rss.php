<?php require_once('AspisMain.php'); ?><?php
do_action('load_feed_engine');
define('RSS','RSS');
define('ATOM','Atom');
define('MAGPIE_USER_AGENT','WordPress/' . $GLOBALS[0]['wp_version']);
class MagpieRSS{var $parser;
var $current_item = array();
var $items = array();
var $channel = array();
var $textinput = array();
var $image = array();
var $feed_type;
var $feed_version;
var $stack = array();
var $inchannel = false;
var $initem = false;
var $incontent = false;
var $intextinput = false;
var $inimage = false;
var $current_field = '';
var $current_namespace = false;
var $_CONTENT_CONSTRUCTS = array('content','summary','info','title','tagline','copyright');
function MagpieRSS ( $source ) {
{if ( !function_exists('xml_parser_create'))
 trigger_error("Failed to load PHP's XML Extension. http://www.php.net/manual/en/ref.xml.php");
$parser = @xml_parser_create();
if ( !is_resource($parser))
 trigger_error("Failed to create an instance of PHP's XML parser. http://www.php.net/manual/en/ref.xml.php");
$this->parser = $parser;
xml_set_object($this->parser,$this);
xml_set_element_handler($this->parser,'feed_start_element','feed_end_element');
xml_set_character_data_handler($this->parser,'feed_cdata');
$status = xml_parse($this->parser,$source);
if ( !$status)
 {$errorcode = xml_get_error_code($this->parser);
if ( $errorcode != XML_ERROR_NONE)
 {$xml_error = xml_error_string($errorcode);
$error_line = xml_get_current_line_number($this->parser);
$error_col = xml_get_current_column_number($this->parser);
$errormsg = "$xml_error at line $error_line, column $error_col";
$this->error($errormsg);
}}xml_parser_free($this->parser);
$this->normalize();
} }
function feed_start_element ( $p,$element,&$attrs ) {
{$el = $element = strtolower($element);
$attrs = array_change_key_case($attrs,CASE_LOWER);
$ns = false;
if ( strpos($element,':'))
 {list($ns,$el) = split(':',$element,2);
}if ( $ns and $ns != 'rdf')
 {$this->current_namespace = $ns;
}if ( !isset($this->feed_type))
 {if ( $el == 'rdf')
 {$this->feed_type = RSS;
$this->feed_version = '1.0';
}elseif ( $el == 'rss')
 {$this->feed_type = RSS;
$this->feed_version = $attrs['version'];
}elseif ( $el == 'feed')
 {$this->feed_type = ATOM;
$this->feed_version = $attrs['version'];
$this->inchannel = true;
}{return ;
}}if ( $el == 'channel')
 {$this->inchannel = true;
}elseif ( $el == 'item' or $el == 'entry')
 {$this->initem = true;
if ( isset($attrs['rdf:about']))
 {$this->current_item['about'] = $attrs['rdf:about'];
}}elseif ( $this->feed_type == RSS and $this->current_namespace == '' and $el == 'textinput')
 {$this->intextinput = true;
}elseif ( $this->feed_type == RSS and $this->current_namespace == '' and $el == 'image')
 {$this->inimage = true;
}elseif ( $this->feed_type == ATOM and in_array($el,$this->_CONTENT_CONSTRUCTS))
 {if ( $el == 'content')
 {$el = 'atom_content';
}$this->incontent = $el;
}elseif ( $this->feed_type == ATOM and $this->incontent)
 {$attrs_str = join(' ',array_map(array('MagpieRSS','map_attrs'),array_keys($attrs),array_values($attrs)));
$this->append_content("<$element $attrs_str>");
array_unshift($this->stack,$el);
}elseif ( $this->feed_type == ATOM and $el == 'link')
 {if ( isset($attrs['rel']) and $attrs['rel'] == 'alternate')
 {$link_el = 'link';
}else 
{{$link_el = 'link_' . $attrs['rel'];
}}$this->append($link_el,$attrs['href']);
}else 
{{array_unshift($this->stack,$el);
}}} }
function feed_cdata ( $p,$text ) {
{if ( $this->feed_type == ATOM and $this->incontent)
 {$this->append_content($text);
}else 
{{$current_el = join('_',array_reverse($this->stack));
$this->append($current_el,$text);
}}} }
function feed_end_element ( $p,$el ) {
{$el = strtolower($el);
if ( $el == 'item' or $el == 'entry')
 {$this->items[] = $this->current_item;
$this->current_item = array();
$this->initem = false;
}elseif ( $this->feed_type == RSS and $this->current_namespace == '' and $el == 'textinput')
 {$this->intextinput = false;
}elseif ( $this->feed_type == RSS and $this->current_namespace == '' and $el == 'image')
 {$this->inimage = false;
}elseif ( $this->feed_type == ATOM and in_array($el,$this->_CONTENT_CONSTRUCTS))
 {$this->incontent = false;
}elseif ( $el == 'channel' or $el == 'feed')
 {$this->inchannel = false;
}elseif ( $this->feed_type == ATOM and $this->incontent)
 {if ( $this->stack[0] == $el)
 {$this->append_content("</$el>");
}else 
{{$this->append_content("<$el />");
}}array_shift($this->stack);
}else 
{{array_shift($this->stack);
}}$this->current_namespace = false;
} }
function concat ( &$str1,$str2 = "" ) {
{if ( !isset($str1))
 {$str1 = "";
}$str1 .= $str2;
} }
function append_content ( $text ) {
{if ( $this->initem)
 {$this->concat($this->current_item[$this->incontent],$text);
}elseif ( $this->inchannel)
 {$this->concat($this->channel[$this->incontent],$text);
}} }
function append ( $el,$text ) {
{if ( !$el)
 {{return ;
}}if ( $this->current_namespace)
 {if ( $this->initem)
 {$this->concat($this->current_item[$this->current_namespace][$el],$text);
}elseif ( $this->inchannel)
 {$this->concat($this->channel[$this->current_namespace][$el],$text);
}elseif ( $this->intextinput)
 {$this->concat($this->textinput[$this->current_namespace][$el],$text);
}elseif ( $this->inimage)
 {$this->concat($this->image[$this->current_namespace][$el],$text);
}}else 
{{if ( $this->initem)
 {$this->concat($this->current_item[$el],$text);
}elseif ( $this->intextinput)
 {$this->concat($this->textinput[$el],$text);
}elseif ( $this->inimage)
 {$this->concat($this->image[$el],$text);
}elseif ( $this->inchannel)
 {$this->concat($this->channel[$el],$text);
}}}} }
function normalize (  ) {
{if ( $this->is_atom())
 {$this->channel['descripton'] = $this->channel['tagline'];
for ( $i = 0 ; $i < count($this->items) ; $i++ )
{$item = $this->items[$i];
if ( isset($item['summary']))
 $item['description'] = $item['summary'];
if ( isset($item['atom_content']))
 $item['content']['encoded'] = $item['atom_content'];
$this->items[$i] = $item;
}}elseif ( $this->is_rss())
 {$this->channel['tagline'] = $this->channel['description'];
for ( $i = 0 ; $i < count($this->items) ; $i++ )
{$item = $this->items[$i];
if ( isset($item['description']))
 $item['summary'] = $item['description'];
if ( isset($item['content']['encoded']))
 $item['atom_content'] = $item['content']['encoded'];
$this->items[$i] = $item;
}}} }
function is_rss (  ) {
{if ( $this->feed_type == RSS)
 {{$AspisRetTemp = $this->feed_version;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = false;
return $AspisRetTemp;
}}}} }
function is_atom (  ) {
{if ( $this->feed_type == ATOM)
 {{$AspisRetTemp = $this->feed_version;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = false;
return $AspisRetTemp;
}}}} }
function map_attrs ( $k,$v ) {
{{$AspisRetTemp = "$k=\"$v\"";
return $AspisRetTemp;
}} }
function error ( $errormsg,$lvl = E_USER_WARNING ) {
{if ( isset($php_errormsg))
 {$errormsg .= " ($php_errormsg)";
}if ( MAGPIE_DEBUG)
 {trigger_error($errormsg,$lvl);
}else 
{{error_log($errormsg,0);
}}} }
}if ( !function_exists('fetch_rss'))
 {function fetch_rss ( $url ) {
init();
if ( !isset($url))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( !MAGPIE_CACHE_ON)
 {$resp = _fetch_remote_file($url);
if ( is_success($resp->status))
 {{$AspisRetTemp = _response_to_rss($resp);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = false;
return $AspisRetTemp;
}}}}else 
{{$cache = new RSSCache(MAGPIE_CACHE_DIR,MAGPIE_CACHE_AGE);
if ( MAGPIE_DEBUG and $cache->ERROR)
 {debug($cache->ERROR,E_USER_WARNING);
}$cache_status = 0;
$request_headers = array();
$rss = 0;
$errormsg = 0;
if ( !$cache->ERROR)
 {$cache_status = $cache->check_cache($url);
}if ( $cache_status == 'HIT')
 {$rss = $cache->get($url);
if ( isset($rss) and $rss)
 {$rss->from_cache = 1;
if ( MAGPIE_DEBUG > 1)
 {debug("MagpieRSS: Cache HIT",E_USER_NOTICE);
}{$AspisRetTemp = $rss;
return $AspisRetTemp;
}}}if ( $cache_status == 'STALE')
 {$rss = $cache->get($url);
if ( isset($rss->etag) and $rss->last_modified)
 {$request_headers['If-None-Match'] = $rss->etag;
$request_headers['If-Last-Modified'] = $rss->last_modified;
}}$resp = _fetch_remote_file($url,$request_headers);
if ( isset($resp) and $resp)
 {if ( $resp->status == '304')
 {if ( MAGPIE_DEBUG > 1)
 {debug("Got 304 for $url");
}$cache->set($url,$rss);
{$AspisRetTemp = $rss;
return $AspisRetTemp;
}}elseif ( is_success($resp->status))
 {$rss = _response_to_rss($resp);
if ( $rss)
 {if ( MAGPIE_DEBUG > 1)
 {debug("Fetch successful");
}$cache->set($url,$rss);
{$AspisRetTemp = $rss;
return $AspisRetTemp;
}}}else 
{{$errormsg = "Failed to fetch $url. ";
if ( $resp->error)
 {$http_error = substr($resp->error,0,-2);
$errormsg .= "(HTTP Error: $http_error)";
}else 
{{$errormsg .= "(HTTP Response: " . $resp->response_code . ')';
}}}}}else 
{{$errormsg = "Unable to retrieve RSS file for unknown reasons.";
}}if ( $rss)
 {if ( MAGPIE_DEBUG)
 {debug("Returning STALE object for $url");
}{$AspisRetTemp = $rss;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
}}} }
}function _fetch_remote_file ( $url,$headers = "" ) {
$resp = wp_remote_request($url,array('headers' => $headers,'timeout' => MAGPIE_FETCH_TIME_OUT));
if ( is_wp_error($resp))
 {$error = array_shift($resp->errors);
$resp = new stdClass;
$resp->status = 500;
$resp->response_code = 500;
$resp->error = $error[0] . "\n";
{$AspisRetTemp = $resp;
return $AspisRetTemp;
}}$response = new stdClass;
$response->status = $resp['response']['code'];
$response->response_code = $resp['response']['code'];
$response->headers = $resp['headers'];
$response->results = $resp['body'];
{$AspisRetTemp = $response;
return $AspisRetTemp;
} }
function _response_to_rss ( $resp ) {
$rss = new MagpieRSS($resp->results);
if ( $rss && (!isset($rss->ERROR) || !$rss->ERROR))
 {foreach ( (array)$resp->headers as $h  )
{if ( strpos($h,": "))
 {list($field,$val) = explode(": ",$h,2);
}else 
{{$field = $h;
$val = "";
}}if ( $field == 'ETag')
 {$rss->etag = $val;
}if ( $field == 'Last-Modified')
 {$rss->last_modified = $val;
}}{$AspisRetTemp = $rss;
return $AspisRetTemp;
}}else 
{{$errormsg = "Failed to parse RSS file.";
if ( $rss)
 {$errormsg .= " (" . $rss->ERROR . ")";
}{$AspisRetTemp = false;
return $AspisRetTemp;
}}} }
function init (  ) {
if ( defined('MAGPIE_INITALIZED'))
 {{return ;
}}else 
{{define('MAGPIE_INITALIZED',1);
}}if ( !defined('MAGPIE_CACHE_ON'))
 {define('MAGPIE_CACHE_ON',1);
}if ( !defined('MAGPIE_CACHE_DIR'))
 {define('MAGPIE_CACHE_DIR','./cache');
}if ( !defined('MAGPIE_CACHE_AGE'))
 {define('MAGPIE_CACHE_AGE',60 * 60);
}if ( !defined('MAGPIE_CACHE_FRESH_ONLY'))
 {define('MAGPIE_CACHE_FRESH_ONLY',0);
}if ( !defined('MAGPIE_DEBUG'))
 {define('MAGPIE_DEBUG',0);
}if ( !defined('MAGPIE_USER_AGENT'))
 {$ua = 'WordPress/' . $GLOBALS[0]['wp_version'];
if ( MAGPIE_CACHE_ON)
 {$ua = $ua . ')';
}else 
{{$ua = $ua . '; No cache)';
}}define('MAGPIE_USER_AGENT',$ua);
}if ( !defined('MAGPIE_FETCH_TIME_OUT'))
 {define('MAGPIE_FETCH_TIME_OUT',2);
}if ( !defined('MAGPIE_USE_GZIP'))
 {define('MAGPIE_USE_GZIP',true);
} }
function is_info ( $sc ) {
{$AspisRetTemp = $sc >= 100 && $sc < 200;
return $AspisRetTemp;
} }
function is_success ( $sc ) {
{$AspisRetTemp = $sc >= 200 && $sc < 300;
return $AspisRetTemp;
} }
function is_redirect ( $sc ) {
{$AspisRetTemp = $sc >= 300 && $sc < 400;
return $AspisRetTemp;
} }
function is_error ( $sc ) {
{$AspisRetTemp = $sc >= 400 && $sc < 600;
return $AspisRetTemp;
} }
function is_client_error ( $sc ) {
{$AspisRetTemp = $sc >= 400 && $sc < 500;
return $AspisRetTemp;
} }
function is_server_error ( $sc ) {
{$AspisRetTemp = $sc >= 500 && $sc < 600;
return $AspisRetTemp;
} }
class RSSCache{var $BASE_CACHE;
var $MAX_AGE = 43200;
var $ERROR = '';
function RSSCache ( $base = '',$age = '' ) {
{$this->BASE_CACHE = WP_CONTENT_DIR . '/cache';
if ( $base)
 {$this->BASE_CACHE = $base;
}if ( $age)
 {$this->MAX_AGE = $age;
}} }
function set ( $url,$rss ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$cache_option = 'rss_' . $this->file_name($url);
set_transient($cache_option,$rss,$this->MAX_AGE);
{$AspisRetTemp = $cache_option;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get ( $url ) {
{$this->ERROR = "";
$cache_option = 'rss_' . $this->file_name($url);
if ( !$rss = get_transient($cache_option))
 {$this->debug("Cache doesn't contain: $url (cache option: $cache_option)");
{$AspisRetTemp = 0;
return $AspisRetTemp;
}}{$AspisRetTemp = $rss;
return $AspisRetTemp;
}} }
function check_cache ( $url ) {
{$this->ERROR = "";
$cache_option = 'rss_' . $this->file_name($url);
if ( get_transient($cache_option))
 {{$AspisRetTemp = 'HIT';
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = 'MISS';
return $AspisRetTemp;
}}}} }
function serialize ( $rss ) {
{{$AspisRetTemp = serialize($rss);
return $AspisRetTemp;
}} }
function unserialize ( $data ) {
{{$AspisRetTemp = AspisUntainted_unserialize($data);
return $AspisRetTemp;
}} }
function file_name ( $url ) {
{{$AspisRetTemp = md5($url);
return $AspisRetTemp;
}} }
function error ( $errormsg,$lvl = E_USER_WARNING ) {
{if ( isset($php_errormsg))
 {$errormsg .= " ($php_errormsg)";
}$this->ERROR = $errormsg;
if ( MAGPIE_DEBUG)
 {trigger_error($errormsg,$lvl);
}else 
{{error_log($errormsg,0);
}}} }
function debug ( $debugmsg,$lvl = E_USER_NOTICE ) {
{if ( MAGPIE_DEBUG)
 {$this->error("MagpieRSS [debug] $debugmsg",$lvl);
}} }
}if ( !function_exists('parse_w3cdtf'))
 {function parse_w3cdtf ( $date_str ) {
$pat = "/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})(:(\d{2}))?(?:([-+])(\d{2}):?(\d{2})|(Z))?/";
if ( preg_match($pat,$date_str,$match))
 {list($year,$month,$day,$hours,$minutes,$seconds) = array($match[1],$match[2],$match[3],$match[4],$match[5],$match[7]);
$epoch = gmmktime($hours,$minutes,$seconds,$month,$day,$year);
$offset = 0;
if ( $match[11] == 'Z')
 {}else 
{{list($tz_mod,$tz_hour,$tz_min) = array($match[8],$match[9],$match[10]);
if ( !$tz_hour)
 {$tz_hour = 0;
}if ( !$tz_min)
 {$tz_min = 0;
}$offset_secs = (($tz_hour * 60) + $tz_min) * 60;
if ( $tz_mod == '+')
 {$offset_secs = $offset_secs * -1;
}$offset = $offset_secs;
}}$epoch = $epoch + $offset;
{$AspisRetTemp = $epoch;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = -1;
return $AspisRetTemp;
}}} }
}if ( !function_exists('wp_rss'))
 {function wp_rss ( $url,$num_items = -1 ) {
if ( $rss = fetch_rss($url))
 {echo '<ul>';
if ( $num_items !== -1)
 {$rss->items = array_slice($rss->items,0,$num_items);
}foreach ( (array)$rss->items as $item  )
{printf('<li><a href="%1$s" title="%2$s">%3$s</a></li>',esc_url($item['link']),esc_attr(strip_tags($item['description'])),htmlentities($item['title']));
}echo '</ul>';
}else 
{{_e('An error has occurred, which probably means the feed is down. Try again later.');
}} }
}if ( !function_exists('get_rss'))
 {function get_rss ( $url,$num_items = 5 ) {
$rss = fetch_rss($url);
if ( $rss)
 {$rss->items = array_slice($rss->items,0,$num_items);
foreach ( (array)$rss->items as $item  )
{echo "<li>\n";
echo "<a href='$item[link]' title='$item[description]'>";
echo htmlentities($item['title']);
echo "</a><br />\n";
echo "</li>\n";
}}else 
{{{$AspisRetTemp = false;
return $AspisRetTemp;
}}} }
};
?>
<?php 