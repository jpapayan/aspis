<?php require_once('AspisMain.php'); ?><?php
do_action(array('load_feed_engine',false));
define(('RSS'),'RSS');
define(('ATOM'),'Atom');
define(('MAGPIE_USER_AGENT'),(deconcat1('WordPress/',$GLOBALS[0]['wp_version'])));
class MagpieRSS{var $parser;
var $current_item = array(array(),false);
var $items = array(array(),false);
var $channel = array(array(),false);
var $textinput = array(array(),false);
var $image = array(array(),false);
var $feed_type;
var $feed_version;
var $stack = array(array(),false);
var $inchannel = array(false,false);
var $initem = array(false,false);
var $incontent = array(false,false);
var $intextinput = array(false,false);
var $inimage = array(false,false);
var $current_field = array('',false);
var $current_namespace = array(false,false);
var $_CONTENT_CONSTRUCTS = array(array(array('content',false),array('summary',false),array('info',false),array('title',false),array('tagline',false),array('copyright',false)),false);
function MagpieRSS ( $source ) {
{if ( (!(function_exists(('xml_parser_create')))))
 trigger_error("Failed to load PHP's XML Extension. http://www.php.net/manual/en/ref.xml.php");
$parser = @array(xml_parser_create(),false);
if ( (!(is_resource(deAspisRC($parser)))))
 trigger_error("Failed to create an instance of PHP's XML parser. http://www.php.net/manual/en/ref.xml.php");
$this->parser = $parser;
Aspis_xml_set_object($this->parser,array($this,false));
Aspis_xml_set_element_handler($this->parser,array('feed_start_element',false),array('feed_end_element',false));
Aspis_xml_set_character_data_handler($this->parser,array('feed_cdata',false));
$status = attAspis(xml_parse($this->parser[0],$source[0]));
if ( (denot_boolean($status)))
 {$errorcode = array(xml_get_error_code(deAspisRC($this->parser)),false);
if ( ($errorcode[0] != XML_ERROR_NONE))
 {$xml_error = array(xml_error_string(deAspisRC($errorcode)),false);
$error_line = array(xml_get_current_line_number(deAspisRC($this->parser)),false);
$error_col = array(xml_get_current_column_number(deAspisRC($this->parser)),false);
$errormsg = concat(concat2(concat(concat2($xml_error," at line "),$error_line),", column "),$error_col);
$this->error($errormsg);
}}xml_parser_free(deAspisRC($this->parser));
$this->normalize();
} }
function feed_start_element ( $p,$element,&$attrs ) {
{$el = $element = Aspis_strtolower($element);
$attrs = Aspis_array_change_key_case($attrs,array(CASE_LOWER,false));
$ns = array(false,false);
if ( strpos($element[0],':'))
 {list($ns,$el) = deAspisList(Aspis_split(array(':',false),$element,array(2,false)),array());
}if ( ($ns[0] and ($ns[0] != ('rdf'))))
 {$this->current_namespace = $ns;
}if ( (!((isset($this->feed_type) && Aspis_isset( $this ->feed_type )))))
 {if ( ($el[0] == ('rdf')))
 {$this->feed_type = array(RSS,false);
$this->feed_version = array('1.0',false);
}elseif ( ($el[0] == ('rss')))
 {$this->feed_type = array(RSS,false);
$this->feed_version = $attrs[0]['version'];
}elseif ( ($el[0] == ('feed')))
 {$this->feed_type = array(ATOM,false);
$this->feed_version = $attrs[0]['version'];
$this->inchannel = array(true,false);
}return ;
}if ( ($el[0] == ('channel')))
 {$this->inchannel = array(true,false);
}elseif ( (($el[0] == ('item')) or ($el[0] == ('entry'))))
 {$this->initem = array(true,false);
if ( ((isset($attrs[0][('rdf:about')]) && Aspis_isset( $attrs [0][('rdf:about')]))))
 {arrayAssign($this->current_item[0],deAspis(registerTaint(array('about',false))),addTaint($attrs[0]['rdf:about']));
}}elseif ( ((($this->feed_type[0] == RSS) and ($this->current_namespace[0] == (''))) and ($el[0] == ('textinput'))))
 {$this->intextinput = array(true,false);
}elseif ( ((($this->feed_type[0] == RSS) and ($this->current_namespace[0] == (''))) and ($el[0] == ('image'))))
 {$this->inimage = array(true,false);
}elseif ( (($this->feed_type[0] == ATOM) and deAspis(Aspis_in_array($el,$this->_CONTENT_CONSTRUCTS))))
 {if ( ($el[0] == ('content')))
 {$el = array('atom_content',false);
}$this->incontent = $el;
}elseif ( (($this->feed_type[0] == ATOM) and $this->incontent[0]))
 {$attrs_str = Aspis_join(array(' ',false),attAspisRC(array_map(AspisInternalCallback(array(array(array('MagpieRSS',false),array('map_attrs',false)),false)),deAspisRC(attAspisRC(array_keys(deAspisRC($attrs)))),deAspisRC(Aspis_array_values($attrs)))));
$this->append_content(concat2(concat(concat2(concat1("<",$element)," "),$attrs_str),">"));
Aspis_array_unshift($this->stack,$el);
}elseif ( (($this->feed_type[0] == ATOM) and ($el[0] == ('link'))))
 {if ( (((isset($attrs[0][('rel')]) && Aspis_isset( $attrs [0][('rel')]))) and (deAspis($attrs[0]['rel']) == ('alternate'))))
 {$link_el = array('link',false);
}else 
{{$link_el = concat1('link_',$attrs[0]['rel']);
}}$this->append($link_el,$attrs[0]['href']);
}else 
{{Aspis_array_unshift($this->stack,$el);
}}} }
function feed_cdata ( $p,$text ) {
{if ( (($this->feed_type[0] == ATOM) and $this->incontent[0]))
 {$this->append_content($text);
}else 
{{$current_el = Aspis_join(array('_',false),Aspis_array_reverse($this->stack));
$this->append($current_el,$text);
}}} }
function feed_end_element ( $p,$el ) {
{$el = Aspis_strtolower($el);
if ( (($el[0] == ('item')) or ($el[0] == ('entry'))))
 {arrayAssignAdd($this->items[0][],addTaint($this->current_item));
$this->current_item = array(array(),false);
$this->initem = array(false,false);
}elseif ( ((($this->feed_type[0] == RSS) and ($this->current_namespace[0] == (''))) and ($el[0] == ('textinput'))))
 {$this->intextinput = array(false,false);
}elseif ( ((($this->feed_type[0] == RSS) and ($this->current_namespace[0] == (''))) and ($el[0] == ('image'))))
 {$this->inimage = array(false,false);
}elseif ( (($this->feed_type[0] == ATOM) and deAspis(Aspis_in_array($el,$this->_CONTENT_CONSTRUCTS))))
 {$this->incontent = array(false,false);
}elseif ( (($el[0] == ('channel')) or ($el[0] == ('feed'))))
 {$this->inchannel = array(false,false);
}elseif ( (($this->feed_type[0] == ATOM) and $this->incontent[0]))
 {if ( ($this->stack[0][(0)][0] == $el[0]))
 {$this->append_content(concat2(concat1("</",$el),">"));
}else 
{{$this->append_content(concat2(concat1("<",$el)," />"));
}}Aspis_array_shift($this->stack);
}else 
{{Aspis_array_shift($this->stack);
}}$this->current_namespace = array(false,false);
} }
function concat ( &$str1,$str2 = array("",false) ) {
{if ( (!((isset($str1) && Aspis_isset( $str1)))))
 {$str1 = array("",false);
}$str1 = concat($str1,$str2);
} }
function append_content ( $text ) {
{if ( $this->initem[0])
 {$this->concat($this->current_item[0][$this->incontent[0]],$text);
}elseif ( $this->inchannel[0])
 {$this->concat($this->channel[0][$this->incontent[0]],$text);
}} }
function append ( $el,$text ) {
{if ( (denot_boolean($el)))
 {return ;
}if ( $this->current_namespace[0])
 {if ( $this->initem[0])
 {$this->concat($this->current_item[0][$this->current_namespace[0]][0][$el[0]],$text);
}elseif ( $this->inchannel[0])
 {$this->concat($this->channel[0][$this->current_namespace[0]][0][$el[0]],$text);
}elseif ( $this->intextinput[0])
 {$this->concat($this->textinput[0][$this->current_namespace[0]][0][$el[0]],$text);
}elseif ( $this->inimage[0])
 {$this->concat($this->image[0][$this->current_namespace[0]][0][$el[0]],$text);
}}else 
{{if ( $this->initem[0])
 {$this->concat($this->current_item[0][$el[0]],$text);
}elseif ( $this->intextinput[0])
 {$this->concat($this->textinput[0][$el[0]],$text);
}elseif ( $this->inimage[0])
 {$this->concat($this->image[0][$el[0]],$text);
}elseif ( $this->inchannel[0])
 {$this->concat($this->channel[0][$el[0]],$text);
}}}} }
function normalize (  ) {
{if ( deAspis($this->is_atom()))
 {arrayAssign($this->channel[0],deAspis(registerTaint(array('descripton',false))),addTaint($this->channel[0][('tagline')]));
for ( $i = array(0,false) ; ($i[0] < count($this->items[0])) ; postincr($i) )
{$item = $this->items[0][$i[0]];
if ( ((isset($item[0][('summary')]) && Aspis_isset( $item [0][('summary')]))))
 arrayAssign($item[0],deAspis(registerTaint(array('description',false))),addTaint($item[0]['summary']));
if ( ((isset($item[0][('atom_content')]) && Aspis_isset( $item [0][('atom_content')]))))
 arrayAssign($item[0][('content')][0],deAspis(registerTaint(array('encoded',false))),addTaint($item[0]['atom_content']));
arrayAssign($this->items[0],deAspis(registerTaint($i)),addTaint($item));
}}elseif ( deAspis($this->is_rss()))
 {arrayAssign($this->channel[0],deAspis(registerTaint(array('tagline',false))),addTaint($this->channel[0][('description')]));
for ( $i = array(0,false) ; ($i[0] < count($this->items[0])) ; postincr($i) )
{$item = $this->items[0][$i[0]];
if ( ((isset($item[0][('description')]) && Aspis_isset( $item [0][('description')]))))
 arrayAssign($item[0],deAspis(registerTaint(array('summary',false))),addTaint($item[0]['description']));
if ( ((isset($item[0][('content')][0][('encoded')]) && Aspis_isset( $item [0][('content')] [0][('encoded')]))))
 arrayAssign($item[0],deAspis(registerTaint(array('atom_content',false))),addTaint($item[0][('content')][0]['encoded']));
arrayAssign($this->items[0],deAspis(registerTaint($i)),addTaint($item));
}}} }
function is_rss (  ) {
{if ( ($this->feed_type[0] == RSS))
 {return $this->feed_version;
}else 
{{return array(false,false);
}}} }
function is_atom (  ) {
{if ( ($this->feed_type[0] == ATOM))
 {return $this->feed_version;
}else 
{{return array(false,false);
}}} }
function map_attrs ( $k,$v ) {
{return concat2(concat(concat2($k,"=\""),$v),"\"");
} }
function error ( $errormsg,$lvl = array(E_USER_WARNING,false) ) {
{if ( ((isset($php_errormsg) && Aspis_isset( $php_errormsg))))
 {$errormsg = concat($errormsg,concat2(concat1(" (",$php_errormsg),")"));
}if ( MAGPIE_DEBUG)
 {trigger_error(deAspisRC($errormsg),deAspisRC($lvl));
}else 
{{error_log(deAspisRC($errormsg),0);
}}} }
}if ( (!(function_exists(('fetch_rss')))))
 {function fetch_rss ( $url ) {
init();
if ( (!((isset($url) && Aspis_isset( $url)))))
 {return array(false,false);
}if ( (!(MAGPIE_CACHE_ON)))
 {$resp = _fetch_remote_file($url);
if ( deAspis(is_success($resp[0]->status)))
 {return _response_to_rss($resp);
}else 
{{return array(false,false);
}}}else 
{{$cache = array(new RSSCache(array(MAGPIE_CACHE_DIR,false),array(MAGPIE_CACHE_AGE,false)),false);
if ( (MAGPIE_DEBUG and $cache[0]->ERROR[0]))
 {debug($cache[0]->ERROR,array(E_USER_WARNING,false));
}$cache_status = array(0,false);
$request_headers = array(array(),false);
$rss = array(0,false);
$errormsg = array(0,false);
if ( (denot_boolean($cache[0]->ERROR)))
 {$cache_status = $cache[0]->check_cache($url);
}if ( ($cache_status[0] == ('HIT')))
 {$rss = $cache[0]->get($url);
if ( (((isset($rss) && Aspis_isset( $rss))) and $rss[0]))
 {$rss[0]->from_cache = array(1,false);
if ( (MAGPIE_DEBUG > (1)))
 {debug(array("MagpieRSS: Cache HIT",false),array(E_USER_NOTICE,false));
}return $rss;
}}if ( ($cache_status[0] == ('STALE')))
 {$rss = $cache[0]->get($url);
if ( (((isset($rss[0]->etag) && Aspis_isset( $rss[0] ->etag ))) and $rss[0]->last_modified[0]))
 {arrayAssign($request_headers[0],deAspis(registerTaint(array('If-None-Match',false))),addTaint($rss[0]->etag));
arrayAssign($request_headers[0],deAspis(registerTaint(array('If-Last-Modified',false))),addTaint($rss[0]->last_modified));
}}$resp = _fetch_remote_file($url,$request_headers);
if ( (((isset($resp) && Aspis_isset( $resp))) and $resp[0]))
 {if ( ($resp[0]->status[0] == ('304')))
 {if ( (MAGPIE_DEBUG > (1)))
 {debug(concat1("Got 304 for ",$url));
}$cache[0]->set($url,$rss);
return $rss;
}elseif ( deAspis(is_success($resp[0]->status)))
 {$rss = _response_to_rss($resp);
if ( $rss[0])
 {if ( (MAGPIE_DEBUG > (1)))
 {debug(array("Fetch successful",false));
}$cache[0]->set($url,$rss);
return $rss;
}}else 
{{$errormsg = concat2(concat1("Failed to fetch ",$url),". ");
if ( $resp[0]->error[0])
 {$http_error = Aspis_substr($resp[0]->error,array(0,false),negate(array(2,false)));
$errormsg = concat($errormsg,concat2(concat1("(HTTP Error: ",$http_error),")"));
}else 
{{$errormsg = concat($errormsg,concat2(concat1("(HTTP Response: ",$resp[0]->response_code),')'));
}}}}}else 
{{$errormsg = array("Unable to retrieve RSS file for unknown reasons.",false);
}}if ( $rss[0])
 {if ( MAGPIE_DEBUG)
 {debug(concat1("Returning STALE object for ",$url));
}return $rss;
}return array(false,false);
}} }
}function _fetch_remote_file ( $url,$headers = array("",false) ) {
$resp = wp_remote_request($url,array(array(deregisterTaint(array('headers',false)) => addTaint($headers),'timeout' => array(MAGPIE_FETCH_TIME_OUT,false,false)),false));
if ( deAspis(is_wp_error($resp)))
 {$error = Aspis_array_shift($resp[0]->errors);
$resp = array(new stdClass,false);
$resp[0]->status = array(500,false);
$resp[0]->response_code = array(500,false);
$resp[0]->error = concat2(attachAspis($error,(0)),"\n");
return $resp;
}$response = array(new stdClass,false);
$response[0]->status = $resp[0][('response')][0]['code'];
$response[0]->response_code = $resp[0][('response')][0]['code'];
$response[0]->headers = $resp[0]['headers'];
$response[0]->results = $resp[0]['body'];
return $response;
 }
function _response_to_rss ( $resp ) {
$rss = array(new MagpieRSS($resp[0]->results),false);
if ( ($rss[0] && ((!((isset($rss[0]->ERROR) && Aspis_isset( $rss[0] ->ERROR )))) || (denot_boolean($rss[0]->ERROR)))))
 {foreach ( deAspis(array_cast($resp[0]->headers)) as $h  )
{if ( strpos($h[0],": "))
 {list($field,$val) = deAspisList(Aspis_explode(array(": ",false),$h,array(2,false)),array());
}else 
{{$field = $h;
$val = array("",false);
}}if ( ($field[0] == ('ETag')))
 {$rss[0]->etag = $val;
}if ( ($field[0] == ('Last-Modified')))
 {$rss[0]->last_modified = $val;
}}return $rss;
}else 
{{$errormsg = array("Failed to parse RSS file.",false);
if ( $rss[0])
 {$errormsg = concat($errormsg,concat2(concat1(" (",$rss[0]->ERROR),")"));
}return array(false,false);
}} }
function init (  ) {
if ( defined(('MAGPIE_INITALIZED')))
 {return ;
}else 
{{define(('MAGPIE_INITALIZED'),1);
}}if ( (!(defined(('MAGPIE_CACHE_ON')))))
 {define(('MAGPIE_CACHE_ON'),1);
}if ( (!(defined(('MAGPIE_CACHE_DIR')))))
 {define(('MAGPIE_CACHE_DIR'),'./cache');
}if ( (!(defined(('MAGPIE_CACHE_AGE')))))
 {define(('MAGPIE_CACHE_AGE'),deAspisRC(array((60) * (60),false)));
}if ( (!(defined(('MAGPIE_CACHE_FRESH_ONLY')))))
 {define(('MAGPIE_CACHE_FRESH_ONLY'),0);
}if ( (!(defined(('MAGPIE_DEBUG')))))
 {define(('MAGPIE_DEBUG'),0);
}if ( (!(defined(('MAGPIE_USER_AGENT')))))
 {$ua = concat1('WordPress/',$GLOBALS[0]['wp_version']);
if ( MAGPIE_CACHE_ON)
 {$ua = concat2($ua,')');
}else 
{{$ua = concat2($ua,'; No cache)');
}}define(('MAGPIE_USER_AGENT'),deAspisRC($ua));
}if ( (!(defined(('MAGPIE_FETCH_TIME_OUT')))))
 {define(('MAGPIE_FETCH_TIME_OUT'),2);
}if ( (!(defined(('MAGPIE_USE_GZIP')))))
 {define(('MAGPIE_USE_GZIP'),true);
} }
function is_info ( $sc ) {
return array(($sc[0] >= (100)) && ($sc[0] < (200)),false);
 }
function is_success ( $sc ) {
return array(($sc[0] >= (200)) && ($sc[0] < (300)),false);
 }
function is_redirect ( $sc ) {
return array(($sc[0] >= (300)) && ($sc[0] < (400)),false);
 }
function is_error ( $sc ) {
return array(($sc[0] >= (400)) && ($sc[0] < (600)),false);
 }
function is_client_error ( $sc ) {
return array(($sc[0] >= (400)) && ($sc[0] < (500)),false);
 }
function is_server_error ( $sc ) {
return array(($sc[0] >= (500)) && ($sc[0] < (600)),false);
 }
class RSSCache{var $BASE_CACHE;
var $MAX_AGE = array(43200,false);
var $ERROR = array('',false);
function RSSCache ( $base = array('',false),$age = array('',false) ) {
{$this->BASE_CACHE = concat12(WP_CONTENT_DIR,'/cache');
if ( $base[0])
 {$this->BASE_CACHE = $base;
}if ( $age[0])
 {$this->MAX_AGE = $age;
}} }
function set ( $url,$rss ) {
{global $wpdb;
$cache_option = concat1('rss_',$this->file_name($url));
set_transient($cache_option,$rss,$this->MAX_AGE);
return $cache_option;
} }
function get ( $url ) {
{$this->ERROR = array("",false);
$cache_option = concat1('rss_',$this->file_name($url));
if ( (denot_boolean($rss = get_transient($cache_option))))
 {$this->debug(concat2(concat(concat2(concat1("Cache doesn't contain: ",$url)," (cache option: "),$cache_option),")"));
return array(0,false);
}return $rss;
} }
function check_cache ( $url ) {
{$this->ERROR = array("",false);
$cache_option = concat1('rss_',$this->file_name($url));
if ( deAspis(get_transient($cache_option)))
 {return array('HIT',false);
}else 
{{return array('MISS',false);
}}} }
function serialize ( $rss ) {
{return Aspis_serialize($rss);
} }
function unserialize ( $data ) {
{return Aspis_unserialize($data);
} }
function file_name ( $url ) {
{return attAspis(md5($url[0]));
} }
function error ( $errormsg,$lvl = array(E_USER_WARNING,false) ) {
{if ( ((isset($php_errormsg) && Aspis_isset( $php_errormsg))))
 {$errormsg = concat($errormsg,concat2(concat1(" (",$php_errormsg),")"));
}$this->ERROR = $errormsg;
if ( MAGPIE_DEBUG)
 {trigger_error(deAspisRC($errormsg),deAspisRC($lvl));
}else 
{{error_log(deAspisRC($errormsg),0);
}}} }
function debug ( $debugmsg,$lvl = array(E_USER_NOTICE,false) ) {
{if ( MAGPIE_DEBUG)
 {$this->error(concat1("MagpieRSS [debug] ",$debugmsg),$lvl);
}} }
}if ( (!(function_exists(('parse_w3cdtf')))))
 {function parse_w3cdtf ( $date_str ) {
$pat = array("/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})(:(\d{2}))?(?:([-+])(\d{2}):?(\d{2})|(Z))?/",false);
if ( deAspis(Aspis_preg_match($pat,$date_str,$match)))
 {list($year,$month,$day,$hours,$minutes,$seconds) = deAspisList(array(array(attachAspis($match,(1)),attachAspis($match,(2)),attachAspis($match,(3)),attachAspis($match,(4)),attachAspis($match,(5)),attachAspis($match,(7))),false),array());
$epoch = attAspis(gmmktime($hours[0],$minutes[0],$seconds[0],$month[0],$day[0],$year[0]));
$offset = array(0,false);
if ( (deAspis(attachAspis($match,(11))) == ('Z')))
 {}else 
{{list($tz_mod,$tz_hour,$tz_min) = deAspisList(array(array(attachAspis($match,(8)),attachAspis($match,(9)),attachAspis($match,(10))),false),array());
if ( (denot_boolean($tz_hour)))
 {$tz_hour = array(0,false);
}if ( (denot_boolean($tz_min)))
 {$tz_min = array(0,false);
}$offset_secs = array((($tz_hour[0] * (60)) + $tz_min[0]) * (60),false);
if ( ($tz_mod[0] == ('+')))
 {$offset_secs = array($offset_secs[0] * deAspis(negate(array(1,false))),false);
}$offset = $offset_secs;
}}$epoch = array($epoch[0] + $offset[0],false);
return $epoch;
}else 
{{return negate(array(1,false));
}} }
}if ( (!(function_exists(('wp_rss')))))
 {function wp_rss ( $url,$num_items = array(-1,false) ) {
if ( deAspis($rss = fetch_rss($url)))
 {echo AspisCheckPrint(array('<ul>',false));
if ( ($num_items[0] !== deAspis(negate(array(1,false)))))
 {$rss[0]->items = Aspis_array_slice($rss[0]->items,array(0,false),$num_items);
}foreach ( deAspis(array_cast($rss[0]->items)) as $item  )
{printf(('<li><a href="%1$s" title="%2$s">%3$s</a></li>'),deAspisRC(esc_url($item[0]['link'])),deAspisRC(esc_attr(Aspis_strip_tags($item[0]['description']))),deAspisRC(Aspis_htmlentities($item[0]['title'])));
}echo AspisCheckPrint(array('</ul>',false));
}else 
{{_e(array('An error has occurred, which probably means the feed is down. Try again later.',false));
}} }
}if ( (!(function_exists(('get_rss')))))
 {function get_rss ( $url,$num_items = array(5,false) ) {
$rss = fetch_rss($url);
if ( $rss[0])
 {$rss[0]->items = Aspis_array_slice($rss[0]->items,array(0,false),$num_items);
foreach ( deAspis(array_cast($rss[0]->items)) as $item  )
{echo AspisCheckPrint(array("<li>\n",false));
echo AspisCheckPrint(concat2(concat(concat2(concat1("<a href='",attachAspis($item,link)),"' title='"),attachAspis($item,description)),"'>"));
echo AspisCheckPrint(Aspis_htmlentities($item[0]['title']));
echo AspisCheckPrint(array("</a><br />\n",false));
echo AspisCheckPrint(array("</li>\n",false));
}}else 
{{return array(false,false);
}} }
};
?>
<?php 