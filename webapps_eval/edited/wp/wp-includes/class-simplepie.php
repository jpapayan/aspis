<?php require_once('AspisMain.php'); ?><?php
define(('SIMPLEPIE_NAME'),'SimplePie');
define(('SIMPLEPIE_VERSION'),'1.2');
define(('SIMPLEPIE_BUILD'),'20090627192103');
define(('SIMPLEPIE_URL'),'http://simplepie.org');
define(('SIMPLEPIE_USERAGENT'),(deconcat2(concat2(concat2(concat2(concat2(concat12(SIMPLEPIE_NAME,'/'),SIMPLEPIE_VERSION),' (Feed Parser; '),SIMPLEPIE_URL),'; Allow like Gecko) Build/'),SIMPLEPIE_BUILD)));
define(('SIMPLEPIE_LINKBACK'),(deconcat2(concat2(concat2(concat2(concat2(concat2(concat2(concat12('<a href="',SIMPLEPIE_URL),'" title="'),SIMPLEPIE_NAME),' '),SIMPLEPIE_VERSION),'">'),SIMPLEPIE_NAME),'</a>')));
define(('SIMPLEPIE_LOCATOR_NONE'),0);
define(('SIMPLEPIE_LOCATOR_AUTODISCOVERY'),1);
define(('SIMPLEPIE_LOCATOR_LOCAL_EXTENSION'),2);
define(('SIMPLEPIE_LOCATOR_LOCAL_BODY'),4);
define(('SIMPLEPIE_LOCATOR_REMOTE_EXTENSION'),8);
define(('SIMPLEPIE_LOCATOR_REMOTE_BODY'),16);
define(('SIMPLEPIE_LOCATOR_ALL'),31);
define(('SIMPLEPIE_TYPE_NONE'),0);
define(('SIMPLEPIE_TYPE_RSS_090'),1);
define(('SIMPLEPIE_TYPE_RSS_091_NETSCAPE'),2);
define(('SIMPLEPIE_TYPE_RSS_091_USERLAND'),4);
define(('SIMPLEPIE_TYPE_RSS_091'),6);
define(('SIMPLEPIE_TYPE_RSS_092'),8);
define(('SIMPLEPIE_TYPE_RSS_093'),16);
define(('SIMPLEPIE_TYPE_RSS_094'),32);
define(('SIMPLEPIE_TYPE_RSS_10'),64);
define(('SIMPLEPIE_TYPE_RSS_20'),128);
define(('SIMPLEPIE_TYPE_RSS_RDF'),65);
define(('SIMPLEPIE_TYPE_RSS_SYNDICATION'),190);
define(('SIMPLEPIE_TYPE_RSS_ALL'),255);
define(('SIMPLEPIE_TYPE_ATOM_03'),256);
define(('SIMPLEPIE_TYPE_ATOM_10'),512);
define(('SIMPLEPIE_TYPE_ATOM_ALL'),768);
define(('SIMPLEPIE_TYPE_ALL'),1023);
define(('SIMPLEPIE_CONSTRUCT_NONE'),0);
define(('SIMPLEPIE_CONSTRUCT_TEXT'),1);
define(('SIMPLEPIE_CONSTRUCT_HTML'),2);
define(('SIMPLEPIE_CONSTRUCT_XHTML'),4);
define(('SIMPLEPIE_CONSTRUCT_BASE64'),8);
define(('SIMPLEPIE_CONSTRUCT_IRI'),16);
define(('SIMPLEPIE_CONSTRUCT_MAYBE_HTML'),32);
define(('SIMPLEPIE_CONSTRUCT_ALL'),63);
define(('SIMPLEPIE_SAME_CASE'),1);
define(('SIMPLEPIE_LOWERCASE'),2);
define(('SIMPLEPIE_UPPERCASE'),4);
define(('SIMPLEPIE_PCRE_HTML_ATTRIBUTE'),'((?:[\x09\x0A\x0B\x0C\x0D\x20]+[^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3D\x3E]*(?:[\x09\x0A\x0B\x0C\x0D\x20]*=[\x09\x0A\x0B\x0C\x0D\x20]*(?:"(?:[^"]*)"|\'(?:[^\']*)\'|(?:[^\x09\x0A\x0B\x0C\x0D\x20\x22\x27\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x3E]*)?))?)*)[\x09\x0A\x0B\x0C\x0D\x20]*');
define(('SIMPLEPIE_PCRE_XML_ATTRIBUTE'),'((?:\s+(?:(?:[^\s:]+:)?[^\s:]+)\s*=\s*(?:"(?:[^"]*)"|\'(?:[^\']*)\'))*)\s*');
define(('SIMPLEPIE_NAMESPACE_XML'),'http://www.w3.org/XML/1998/namespace');
define(('SIMPLEPIE_NAMESPACE_ATOM_10'),'http://www.w3.org/2005/Atom');
define(('SIMPLEPIE_NAMESPACE_ATOM_03'),'http://purl.org/atom/ns#');
define(('SIMPLEPIE_NAMESPACE_RDF'),'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
define(('SIMPLEPIE_NAMESPACE_RSS_090'),'http://my.netscape.com/rdf/simple/0.9/');
define(('SIMPLEPIE_NAMESPACE_RSS_10'),'http://purl.org/rss/1.0/');
define(('SIMPLEPIE_NAMESPACE_RSS_10_MODULES_CONTENT'),'http://purl.org/rss/1.0/modules/content/');
define(('SIMPLEPIE_NAMESPACE_RSS_20'),'');
define(('SIMPLEPIE_NAMESPACE_DC_10'),'http://purl.org/dc/elements/1.0/');
define(('SIMPLEPIE_NAMESPACE_DC_11'),'http://purl.org/dc/elements/1.1/');
define(('SIMPLEPIE_NAMESPACE_W3C_BASIC_GEO'),'http://www.w3.org/2003/01/geo/wgs84_pos#');
define(('SIMPLEPIE_NAMESPACE_GEORSS'),'http://www.georss.org/georss');
define(('SIMPLEPIE_NAMESPACE_MEDIARSS'),'http://search.yahoo.com/mrss/');
define(('SIMPLEPIE_NAMESPACE_MEDIARSS_WRONG'),'http://search.yahoo.com/mrss');
define(('SIMPLEPIE_NAMESPACE_ITUNES'),'http://www.itunes.com/dtds/podcast-1.0.dtd');
define(('SIMPLEPIE_NAMESPACE_XHTML'),'http://www.w3.org/1999/xhtml');
define(('SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY'),'http://www.iana.org/assignments/relation/');
define(('SIMPLEPIE_PHP5'),deAspisRC(array(version_compare(PHP_VERSION,'5.0.0','>='),false)));
define(('SIMPLEPIE_FILE_SOURCE_NONE'),0);
define(('SIMPLEPIE_FILE_SOURCE_REMOTE'),1);
define(('SIMPLEPIE_FILE_SOURCE_LOCAL'),2);
define(('SIMPLEPIE_FILE_SOURCE_FSOCKOPEN'),4);
define(('SIMPLEPIE_FILE_SOURCE_CURL'),8);
define(('SIMPLEPIE_FILE_SOURCE_FILE_GET_CONTENTS'),16);
class SimplePie{var $data = array(array(),false);
var $error;
var $sanitize;
var $useragent = array(SIMPLEPIE_USERAGENT,false);
var $feed_url;
var $file;
var $raw_data;
var $timeout = array(10,false);
var $force_fsockopen = array(false,false);
var $force_feed = array(false,false);
var $xml_dump = array(false,false);
var $cache = array(true,false);
var $cache_duration = array(3600,false);
var $autodiscovery_cache_duration = array(604800,false);
var $cache_location = array('./cache',false);
var $cache_name_function = array('md5',false);
var $order_by_date = array(true,false);
var $input_encoding = array(false,false);
var $autodiscovery = array(SIMPLEPIE_LOCATOR_ALL,false);
var $cache_class = array('SimplePie_Cache',false);
var $locator_class = array('SimplePie_Locator',false);
var $parser_class = array('SimplePie_Parser',false);
var $file_class = array('SimplePie_File',false);
var $item_class = array('SimplePie_Item',false);
var $author_class = array('SimplePie_Author',false);
var $category_class = array('SimplePie_Category',false);
var $enclosure_class = array('SimplePie_Enclosure',false);
var $caption_class = array('SimplePie_Caption',false);
var $copyright_class = array('SimplePie_Copyright',false);
var $credit_class = array('SimplePie_Credit',false);
var $rating_class = array('SimplePie_Rating',false);
var $restriction_class = array('SimplePie_Restriction',false);
var $content_type_sniffer_class = array('SimplePie_Content_Type_Sniffer',false);
var $source_class = array('SimplePie_Source',false);
var $javascript = array('js',false);
var $max_checked_feeds = array(10,false);
var $all_discovered_feeds = array(array(),false);
var $favicon_handler = array('',false);
var $image_handler = array('',false);
var $multifeed_url = array(array(),false);
var $multifeed_objects = array(array(),false);
var $config_settings = array(null,false);
var $item_limit = array(0,false);
var $strip_attributes = array(array(array('bgsound',false),array('class',false),array('expr',false),array('id',false),array('style',false),array('onclick',false),array('onerror',false),array('onfinish',false),array('onmouseover',false),array('onmouseout',false),array('onfocus',false),array('onblur',false),array('lowsrc',false),array('dynsrc',false)),false);
var $strip_htmltags = array(array(array('base',false),array('blink',false),array('body',false),array('doctype',false),array('embed',false),array('font',false),array('form',false),array('frame',false),array('frameset',false),array('html',false),array('iframe',false),array('input',false),array('marquee',false),array('meta',false),array('noscript',false),array('object',false),array('param',false),array('script',false),array('style',false)),false);
function SimplePie ( $feed_url = array(null,false),$cache_location = array(null,false),$cache_duration = array(null,false) ) {
{$this->sanitize = array(new SimplePie_Sanitize,false);
if ( ($cache_location[0] !== null))
 {$this->set_cache_location($cache_location);
}if ( ($cache_duration[0] !== null))
 {$this->set_cache_duration($cache_duration);
}if ( ($feed_url[0] !== null))
 {$this->set_feed_url($feed_url);
$this->init();
}} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize($this->data))));
} }
function __destruct (  ) {
{if ( (((version_compare(PHP_VERSION,'5.3','<')) || (!(gc_enabled()))) && (!(ini_get('zend.ze1_compatibility_mode')))))
 {if ( (!((empty($this->data[0][('items')]) || Aspis_empty( $this ->data [0][('items')] )))))
 {foreach ( $this->data[0][('items')][0] as $item  )
{$item[0]->__destruct();
}unset($item,$this->data[0][('items')]);
}if ( (!((empty($this->data[0][('ordered_items')]) || Aspis_empty( $this ->data [0][('ordered_items')] )))))
 {foreach ( $this->data[0][('ordered_items')][0] as $item  )
{$item[0]->__destruct();
}unset($item,$this->data[0][('ordered_items')]);
}}} }
function force_feed ( $enable = array(false,false) ) {
{$this->force_feed = bool_cast($enable);
} }
function set_feed_url ( $url ) {
{if ( is_array($url[0]))
 {$this->multifeed_url = array(array(),false);
foreach ( $url[0] as $value  )
{arrayAssignAdd($this->multifeed_url[0][],addTaint(SimplePie_Misc::fix_protocol($value,array(1,false))));
}}else 
{{$this->feed_url = SimplePie_Misc::fix_protocol($url,array(1,false));
}}} }
function set_file ( &$file ) {
{if ( is_a(deAspisRC($file),('SimplePie_File')))
 {$this->feed_url = $file[0]->url;
$this->file = &$file;
return array(true,false);
}return array(false,false);
} }
function set_raw_data ( $data ) {
{$this->raw_data = $data;
} }
function set_timeout ( $timeout = array(10,false) ) {
{$this->timeout = int_cast($timeout);
} }
function force_fsockopen ( $enable = array(false,false) ) {
{$this->force_fsockopen = bool_cast($enable);
} }
function enable_xml_dump ( $enable = array(false,false) ) {
{$this->xml_dump = bool_cast($enable);
} }
function enable_cache ( $enable = array(true,false) ) {
{$this->cache = bool_cast($enable);
} }
function set_cache_duration ( $seconds = array(3600,false) ) {
{$this->cache_duration = int_cast($seconds);
} }
function set_autodiscovery_cache_duration ( $seconds = array(604800,false) ) {
{$this->autodiscovery_cache_duration = int_cast($seconds);
} }
function set_cache_location ( $location = array('./cache',false) ) {
{$this->cache_location = string_cast($location);
} }
function enable_order_by_date ( $enable = array(true,false) ) {
{$this->order_by_date = bool_cast($enable);
} }
function set_input_encoding ( $encoding = array(false,false) ) {
{if ( $encoding[0])
 {$this->input_encoding = string_cast($encoding);
}else 
{{$this->input_encoding = array(false,false);
}}} }
function set_autodiscovery_level ( $level = array(SIMPLEPIE_LOCATOR_ALL,false) ) {
{$this->autodiscovery = int_cast($level);
} }
function set_cache_class ( $class = array('SimplePie_Cache',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Cache',false))))
 {$this->cache_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_locator_class ( $class = array('SimplePie_Locator',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Locator',false))))
 {$this->locator_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_parser_class ( $class = array('SimplePie_Parser',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Parser',false))))
 {$this->parser_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_file_class ( $class = array('SimplePie_File',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_File',false))))
 {$this->file_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_sanitize_class ( $class = array('SimplePie_Sanitize',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Sanitize',false))))
 {$this->sanitize = array(new $class[0],false);
return array(true,false);
}return array(false,false);
} }
function set_item_class ( $class = array('SimplePie_Item',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Item',false))))
 {$this->item_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_author_class ( $class = array('SimplePie_Author',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Author',false))))
 {$this->author_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_category_class ( $class = array('SimplePie_Category',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Category',false))))
 {$this->category_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_enclosure_class ( $class = array('SimplePie_Enclosure',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Enclosure',false))))
 {$this->enclosure_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_caption_class ( $class = array('SimplePie_Caption',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Caption',false))))
 {$this->caption_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_copyright_class ( $class = array('SimplePie_Copyright',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Copyright',false))))
 {$this->copyright_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_credit_class ( $class = array('SimplePie_Credit',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Credit',false))))
 {$this->credit_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_rating_class ( $class = array('SimplePie_Rating',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Rating',false))))
 {$this->rating_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_restriction_class ( $class = array('SimplePie_Restriction',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Restriction',false))))
 {$this->restriction_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_content_type_sniffer_class ( $class = array('SimplePie_Content_Type_Sniffer',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Content_Type_Sniffer',false))))
 {$this->content_type_sniffer_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_source_class ( $class = array('SimplePie_Source',false) ) {
{if ( deAspis(SimplePie_Misc::is_subclass_of($class,array('SimplePie_Source',false))))
 {$this->source_class = $class;
return array(true,false);
}return array(false,false);
} }
function set_useragent ( $ua = array(SIMPLEPIE_USERAGENT,false) ) {
{$this->useragent = string_cast($ua);
} }
function set_cache_name_function ( $function = array('md5',false) ) {
{if ( is_callable(deAspisRC($function)))
 {$this->cache_name_function = $function;
}} }
function set_javascript ( $get = array('js',false) ) {
{if ( $get[0])
 {$this->javascript = string_cast($get);
}else 
{{$this->javascript = array(false,false);
}}} }
function set_stupidly_fast ( $set = array(false,false) ) {
{if ( $set[0])
 {$this->enable_order_by_date(array(false,false));
$this->remove_div(array(false,false));
$this->strip_comments(array(false,false));
$this->strip_htmltags(array(false,false));
$this->strip_attributes(array(false,false));
$this->set_image_handler(array(false,false));
}} }
function set_max_checked_feeds ( $max = array(10,false) ) {
{$this->max_checked_feeds = int_cast($max);
} }
function remove_div ( $enable = array(true,false) ) {
{$this->sanitize[0]->remove_div($enable);
} }
function strip_htmltags ( $tags = array('',false),$encode = array(null,false) ) {
{if ( ($tags[0] === ('')))
 {$tags = $this->strip_htmltags;
}$this->sanitize[0]->strip_htmltags($tags);
if ( ($encode[0] !== null))
 {$this->sanitize[0]->encode_instead_of_strip($tags);
}} }
function encode_instead_of_strip ( $enable = array(true,false) ) {
{$this->sanitize[0]->encode_instead_of_strip($enable);
} }
function strip_attributes ( $attribs = array('',false) ) {
{if ( ($attribs[0] === ('')))
 {$attribs = $this->strip_attributes;
}$this->sanitize[0]->strip_attributes($attribs);
} }
function set_output_encoding ( $encoding = array('UTF-8',false) ) {
{$this->sanitize[0]->set_output_encoding($encoding);
} }
function strip_comments ( $strip = array(false,false) ) {
{$this->sanitize[0]->strip_comments($strip);
} }
function set_url_replacements ( $element_attribute = array(array('a' => array('href',false),'area' => array('href',false),'blockquote' => array('cite',false),'del' => array('cite',false),'form' => array('action',false),'img' => array(array(array('longdesc',false),array('src',false)),false),'input' => array('src',false),'ins' => array('cite',false),'q' => array('cite',false)),false) ) {
{$this->sanitize[0]->set_url_replacements($element_attribute);
} }
function set_favicon_handler ( $page = array(false,false),$qs = array('i',false) ) {
{if ( ($page[0] !== false))
 {$this->favicon_handler = concat2(concat(concat2($page,'?'),$qs),'=');
}else 
{{$this->favicon_handler = array('',false);
}}} }
function set_image_handler ( $page = array(false,false),$qs = array('i',false) ) {
{if ( ($page[0] !== false))
 {$this->sanitize[0]->set_image_handler(concat2(concat(concat2($page,'?'),$qs),'='));
}else 
{{$this->image_handler = array('',false);
}}} }
function set_item_limit ( $limit = array(0,false) ) {
{$this->item_limit = int_cast($limit);
} }
function init (  ) {
{if ( (((function_exists(('version_compare')) && (version_compare(PHP_VERSION,'4.3.0','<'))) || (!(extension_loaded('xml')))) || (!(extension_loaded('pcre')))))
 {return array(false,false);
}elseif ( (!(extension_loaded('xmlreader'))))
 {static $xml_is_sane = array(null,false);
if ( ($xml_is_sane[0] === null))
 {$parser_check = array(xml_parser_create(),false);
AspisInternalFunctionCall("xml_parse_into_struct",$parser_check[0],('<foo>&amp;</foo>'),AspisPushRefParam($values),array(2));
xml_parser_free(deAspisRC($parser_check));
$xml_is_sane = array((isset($values[0][(0)][0][('value')]) && Aspis_isset( $values [0][(0)] [0][('value')])),false);
}if ( (denot_boolean($xml_is_sane)))
 {return array(false,false);
}}if ( ((isset($_GET[0][$this->javascript[0]]) && Aspis_isset( $_GET [0][$this ->javascript [0]]))))
 {SimplePie_Misc::output_javascript();
Aspis_exit();
}$this->sanitize[0]->pass_cache_data($this->cache,$this->cache_location,$this->cache_name_function,$this->cache_class);
$this->sanitize[0]->pass_file_data($this->file_class,$this->timeout,$this->useragent,$this->force_fsockopen);
if ( (($this->feed_url[0] !== null) || ($this->raw_data[0] !== null)))
 {$this->data = array(array(),false);
$this->multifeed_objects = array(array(),false);
$cache = array(false,false);
if ( ($this->feed_url[0] !== null))
 {$parsed_feed_url = SimplePie_Misc::parse_url($this->feed_url);
if ( ($this->cache[0] && (deAspis($parsed_feed_url[0]['scheme']) !== (''))))
 {$cache = Aspis_call_user_func(array(array($this->cache_class,array('create',false)),false),$this->cache_location,Aspis_call_user_func($this->cache_name_function,$this->feed_url),array('spc',false));
}if ( ($cache[0] && (denot_boolean($this->xml_dump))))
 {$this->data = $cache[0]->load();
if ( (!((empty($this->data) || Aspis_empty( $this ->data )))))
 {if ( ((!((isset($this->data[0][('build')]) && Aspis_isset( $this ->data [0][('build')] )))) || ($this->data[0][('build')][0] !== SIMPLEPIE_BUILD)))
 {$cache[0]->unlink();
$this->data = array(array(),false);
}elseif ( (((isset($this->data[0][('url')]) && Aspis_isset( $this ->data [0][('url')] ))) && ($this->data[0][('url')][0] !== $this->feed_url[0])))
 {$cache = array(false,false);
$this->data = array(array(),false);
}elseif ( ((isset($this->data[0][('feed_url')]) && Aspis_isset( $this ->data [0][('feed_url')] ))))
 {if ( ((deAspis($cache[0]->mtime()) + $this->autodiscovery_cache_duration[0]) > time()))
 {if ( ($this->data[0][('feed_url')][0] === $this->data[0][('url')][0]))
 {$cache[0]->unlink();
$this->data = array(array(),false);
}else 
{{$this->set_feed_url($this->data[0][('feed_url')]);
return $this->init();
}}}}elseif ( ((deAspis($cache[0]->mtime()) + $this->cache_duration[0]) < time()))
 {if ( (((isset($this->data[0][('headers')][0][('last-modified')]) && Aspis_isset( $this ->data [0][('headers')] [0][('last-modified')] ))) || ((isset($this->data[0][('headers')][0][('etag')]) && Aspis_isset( $this ->data [0][('headers')] [0][('etag')] )))))
 {$headers = array(array(),false);
if ( ((isset($this->data[0][('headers')][0][('last-modified')]) && Aspis_isset( $this ->data [0][('headers')] [0][('last-modified')] ))))
 {arrayAssign($headers[0],deAspis(registerTaint(array('if-modified-since',false))),addTaint($this->data[0][('headers')][0][('last-modified')]));
}if ( ((isset($this->data[0][('headers')][0][('etag')]) && Aspis_isset( $this ->data [0][('headers')] [0][('etag')] ))))
 {arrayAssign($headers[0],deAspis(registerTaint(array('if-none-match',false))),addTaint(concat2(concat1('"',$this->data[0][('headers')][0][('etag')]),'"')));
}$file = array(new $this->file_class[0]($this->feed_url,array($this->timeout[0] / (10),false),array(5,false),$headers,$this->useragent,$this->force_fsockopen),false);
if ( $file[0]->success[0])
 {if ( ($file[0]->status_code[0] === (304)))
 {$cache[0]->touch();
return array(true,false);
}else 
{{$headers = $file[0]->headers;
}}}else 
{{unset($file);
}}}}else 
{{return array(true,false);
}}}else 
{{$cache[0]->unlink();
$this->data = array(array(),false);
}}}if ( (!((isset($file) && Aspis_isset( $file)))))
 {if ( (is_a(deAspisRC($this->file),('SimplePie_File')) && ($this->file[0]->url[0] === $this->feed_url[0])))
 {$file = &$this->file;
}else 
{{$file = array(new $this->file_class[0]($this->feed_url,$this->timeout,array(5,false),array(null,false),$this->useragent,$this->force_fsockopen),false);
}}}if ( ((denot_boolean($file[0]->success)) && (!(($file[0]->method[0] & (SIMPLEPIE_FILE_SOURCE_REMOTE === (0))) || (($file[0]->status_code[0] === (200)) || (($file[0]->status_code[0] > (206)) && ($file[0]->status_code[0] < (300))))))))
 {$this->error = $file[0]->error;
if ( (!((empty($this->data) || Aspis_empty( $this ->data )))))
 {return array(true,false);
}else 
{{return array(false,false);
}}}if ( (denot_boolean($this->force_feed)))
 {$locate = array(new $this->locator_class[0]($file,$this->timeout,$this->useragent,$this->file_class,$this->max_checked_feeds,$this->content_type_sniffer_class),false);
if ( (denot_boolean($locate[0]->is_feed($file))))
 {unset($file);
if ( deAspis($file = $locate[0]->find($this->autodiscovery,$this->all_discovered_feeds)))
 {if ( $cache[0])
 {$this->data = array(array(deregisterTaint(array('url',false)) => addTaint($this->feed_url),deregisterTaint(array('feed_url',false)) => addTaint($file[0]->url),'build' => array(SIMPLEPIE_BUILD,false,false)),false);
if ( (denot_boolean($cache[0]->save(array($this,false)))))
 {trigger_error((deconcat2($this->cache_location," is not writeable")),E_USER_WARNING);
}$cache = Aspis_call_user_func(array(array($this->cache_class,array('create',false)),false),$this->cache_location,Aspis_call_user_func($this->cache_name_function,$file[0]->url),array('spc',false));
}$this->feed_url = $file[0]->url;
}else 
{{$this->error = concat1("A feed could not be found at ",$this->feed_url);
SimplePie_Misc::error($this->error,array(E_USER_NOTICE,false),array(__FILE__,false),array(__LINE__,false));
return array(false,false);
}}}$locate = array(null,false);
}$headers = $file[0]->headers;
$data = $file[0]->body;
$sniffer = array(new $this->content_type_sniffer_class[0]($file),false);
$sniffed = $sniffer[0]->get_type();
}else 
{{$data = $this->raw_data;
}}$encodings = array(array(),false);
if ( ($this->input_encoding[0] !== false))
 {arrayAssignAdd($encodings[0][],addTaint($this->input_encoding));
}$application_types = array(array(array('application/xml',false),array('application/xml-dtd',false),array('application/xml-external-parsed-entity',false)),false);
$text_types = array(array(array('text/xml',false),array('text/xml-external-parsed-entity',false)),false);
if ( ((isset($sniffed) && Aspis_isset( $sniffed))))
 {if ( (deAspis(Aspis_in_array($sniffed,$application_types)) || ((deAspis(Aspis_substr($sniffed,array(0,false),array(12,false))) === ('application/')) && (deAspis(Aspis_substr($sniffed,negate(array(4,false)))) === ('+xml')))))
 {if ( (((isset($headers[0][('content-type')]) && Aspis_isset( $headers [0][('content-type')]))) && deAspis(Aspis_preg_match(array('/;\x20?charset=([^;]*)/i',false),$headers[0]['content-type'],$charset))))
 {arrayAssignAdd($encodings[0][],addTaint(Aspis_strtoupper(attachAspis($charset,(1)))));
}$encodings = Aspis_array_merge($encodings,SimplePie_Misc::xml_encoding($data));
arrayAssignAdd($encodings[0][],addTaint(array('UTF-8',false)));
}elseif ( (deAspis(Aspis_in_array($sniffed,$text_types)) || ((deAspis(Aspis_substr($sniffed,array(0,false),array(5,false))) === ('text/')) && (deAspis(Aspis_substr($sniffed,negate(array(4,false)))) === ('+xml')))))
 {if ( (((isset($headers[0][('content-type')]) && Aspis_isset( $headers [0][('content-type')]))) && deAspis(Aspis_preg_match(array('/;\x20?charset=([^;]*)/i',false),$headers[0]['content-type'],$charset))))
 {arrayAssignAdd($encodings[0][],addTaint(attachAspis($charset,(1))));
}arrayAssignAdd($encodings[0][],addTaint(array('US-ASCII',false)));
}elseif ( (deAspis(Aspis_substr($sniffed,array(0,false),array(5,false))) === ('text/')))
 {arrayAssignAdd($encodings[0][],addTaint(array('US-ASCII',false)));
}}$encodings = Aspis_array_merge($encodings,SimplePie_Misc::xml_encoding($data));
arrayAssignAdd($encodings[0][],addTaint(array('UTF-8',false)));
arrayAssignAdd($encodings[0][],addTaint(array('ISO-8859-1',false)));
$encodings = attAspisRC(array_unique(deAspisRC($encodings)));
if ( $this->xml_dump[0])
 {header((deconcat1('Content-type: text/xml; charset=',attachAspis($encodings,(0)))));
echo AspisCheckPrint($data);
Aspis_exit();
}foreach ( $encodings[0] as $encoding  )
{if ( deAspis($utf8_data = SimplePie_Misc::change_encoding($data,$encoding,array('UTF-8',false))))
 {$parser = array(new $this->parser_class[0](),false);
if ( deAspis($parser[0]->parse($utf8_data,array('UTF-8',false))))
 {$this->data = $parser[0]->get_data();
if ( (deAspis($this->get_type()) & deAspis(not_bitwise(array(SIMPLEPIE_TYPE_NONE,false)))))
 {if ( ((isset($headers) && Aspis_isset( $headers))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('headers',false))),addTaint($headers));
}arrayAssign($this->data[0],deAspis(registerTaint(array('build',false))),addTaint(array(SIMPLEPIE_BUILD,false)));
if ( ($cache[0] && (denot_boolean($cache[0]->save(array($this,false))))))
 {trigger_error((deconcat2($cache[0]->name," is not writeable")),E_USER_WARNING);
}return array(true,false);
}else 
{{$this->error = concat1("A feed could not be found at ",$this->feed_url);
SimplePie_Misc::error($this->error,array(E_USER_NOTICE,false),array(__FILE__,false),array(__LINE__,false));
return array(false,false);
}}}}}if ( ((isset($parser) && Aspis_isset( $parser))))
 {$this->error = Aspis_sprintf(array('XML error: %s at line %d, column %d',false),$parser[0]->get_error_string(),$parser[0]->get_current_line(),$parser[0]->get_current_column());
}else 
{{$this->error = array('The data could not be converted to UTF-8',false);
}}SimplePie_Misc::error($this->error,array(E_USER_NOTICE,false),array(__FILE__,false),array(__LINE__,false));
return array(false,false);
}elseif ( (!((empty($this->multifeed_url) || Aspis_empty( $this ->multifeed_url )))))
 {$i = array(0,false);
$success = array(0,false);
$this->multifeed_objects = array(array(),false);
foreach ( $this->multifeed_url[0] as $url  )
{if ( SIMPLEPIE_PHP5)
 {arrayAssign($this->multifeed_objects[0],deAspis(registerTaint($i)),addTaint(array(clone (($this)),false)));
}else 
{{arrayAssign($this->multifeed_objects[0],deAspis(registerTaint($i)),addTaint(array($this,false)));
}}$this->multifeed_objects[0][$i[0]][0]->set_feed_url($url);
$success = array($success[0] | deAspis($this->multifeed_objects[0][$i[0]][0]->init()),false);
postincr($i);
}return bool_cast($success);
}else 
{{return array(false,false);
}}} }
function error (  ) {
{return $this->error;
} }
function get_encoding (  ) {
{return $this->sanitize[0]->output_encoding;
} }
function handle_content_type ( $mime = array('text/html',false) ) {
{if ( (!(headers_sent())))
 {$header = concat2(concat1("Content-type: ",$mime),";");
if ( deAspis($this->get_encoding()))
 {$header = concat($header,concat1(' charset=',$this->get_encoding()));
}else 
{{$header = concat2($header,' charset=UTF-8');
}}header($header[0]);
}} }
function get_type (  ) {
{if ( (!((isset($this->data[0][('type')]) && Aspis_isset( $this ->data [0][('type')] )))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array(SIMPLEPIE_TYPE_ALL,false)));
if ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('feed')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('feed')] ))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_ATOM_10,false)));
}elseif ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('feed')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('feed')] ))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_ATOM_03,false)));
}elseif ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] ))))
 {if ( (((((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_10][0][('channel')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_10] [0][('channel')] ))) || ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_10][0][('image')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_10] [0][('image')] )))) || ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_10][0][('item')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_10] [0][('item')] )))) || ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_10][0][('textinput')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_10] [0][('textinput')] )))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_RSS_10,false)));
}if ( (((((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_090][0][('channel')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_090] [0][('channel')] ))) || ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_090][0][('image')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_090] [0][('image')] )))) || ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_090][0][('item')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_090] [0][('item')] )))) || ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_090][0][('textinput')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_090] [0][('textinput')] )))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_RSS_090,false)));
}}elseif ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_20] [0][('rss')] ))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_RSS_ALL,false)));
if ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')][0][(0)][0][('attribs')][0][('')][0][('version')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_20] [0][('rss')] [0][(0)] [0][('attribs')] [0][('')] [0][('version')] ))))
 {switch ( deAspis(Aspis_trim($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')][0][(0)][0][('attribs')][0][('')][0][('version')])) ) {
case ('0.91'):arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_RSS_091,false)));
if ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('skiphours')][0][('hour')][0][(0)][0][('data')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_20] [0][('rss')] [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_20] [0][('skiphours')] [0][('hour')] [0][(0)] [0][('data')] ))))
 {switch ( deAspis(Aspis_trim($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('skiphours')][0][('hour')][0][(0)][0][('data')])) ) {
case ('0'):arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_RSS_091_NETSCAPE,false)));
break ;
case ('24'):arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_RSS_091_USERLAND,false)));
break ;
 }
}break ;
case ('0.92'):arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_RSS_092,false)));
break ;
case ('0.93'):arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_RSS_093,false)));
break ;
case ('0.94'):arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_RSS_094,false)));
break ;
case ('2.0'):arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array($this->data[0][('type')] [0] & SIMPLEPIE_TYPE_RSS_20,false)));
break ;
 }
}}else 
{{arrayAssign($this->data[0],deAspis(registerTaint(array('type',false))),addTaint(array(SIMPLEPIE_TYPE_NONE,false)));
}}}return $this->data[0][('type')];
} }
function get_favicon (  ) {
{if ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('icon',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}elseif ( ((deAspis(($url = $this->get_link())) !== null) && deAspis(Aspis_preg_match(array('/^http(s)?:\/\//i',false),$url))))
 {$favicon = SimplePie_Misc::absolutize_url(array('/favicon.ico',false),$url);
if ( ($this->cache[0] && $this->favicon_handler[0]))
 {$favicon_filename = Aspis_call_user_func($this->cache_name_function,$favicon);
$cache = Aspis_call_user_func(array(array($this->cache_class,array('create',false)),false),$this->cache_location,$favicon_filename,array('spi',false));
if ( deAspis($cache[0]->load()))
 {return $this->sanitize(concat($this->favicon_handler,$favicon_filename),array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{$file = array(new $this->file_class[0]($favicon,array($this->timeout[0] / (10),false),array(5,false),array(array(deregisterTaint(array('X-FORWARDED-FOR',false)) => addTaint($_SERVER[0][('REMOTE_ADDR')])),false),$this->useragent,$this->force_fsockopen),false);
if ( (($file[0]->success[0] && (($file[0]->method[0] & (SIMPLEPIE_FILE_SOURCE_REMOTE === (0))) || (($file[0]->status_code[0] === (200)) || (($file[0]->status_code[0] > (206)) && ($file[0]->status_code[0] < (300)))))) && (strlen($file[0]->body[0]) > (0))))
 {$sniffer = array(new $this->content_type_sniffer_class[0]($file),false);
if ( (deAspis(Aspis_substr($sniffer[0]->get_type(),array(0,false),array(6,false))) === ('image/')))
 {if ( deAspis($cache[0]->save(array(array(deregisterTaint(array('headers',false)) => addTaint($file[0]->headers),deregisterTaint(array('body',false)) => addTaint($file[0]->body)),false))))
 {return $this->sanitize(concat($this->favicon_handler,$favicon_filename),array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{trigger_error((deconcat2($cache[0]->name," is not writeable")),E_USER_WARNING);
return $this->sanitize($favicon,array(SIMPLEPIE_CONSTRUCT_IRI,false));
}}}else 
{{return array(false,false);
}}}}}}else 
{{return $this->sanitize($favicon,array(SIMPLEPIE_CONSTRUCT_IRI,false));
}}}return array(false,false);
} }
function subscribe_url (  ) {
{if ( ($this->feed_url[0] !== null))
 {return $this->sanitize($this->feed_url,array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{return array(null,false);
}}} }
function subscribe_feed (  ) {
{if ( ($this->feed_url[0] !== null))
 {return $this->sanitize(SimplePie_Misc::fix_protocol($this->feed_url,array(2,false)),array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{return array(null,false);
}}} }
function subscribe_outlook (  ) {
{if ( ($this->feed_url[0] !== null))
 {return $this->sanitize(concat1('outlook',SimplePie_Misc::fix_protocol($this->feed_url,array(2,false))),array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{return array(null,false);
}}} }
function subscribe_podcast (  ) {
{if ( ($this->feed_url[0] !== null))
 {return $this->sanitize(SimplePie_Misc::fix_protocol($this->feed_url,array(3,false)),array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{return array(null,false);
}}} }
function subscribe_itunes (  ) {
{if ( ($this->feed_url[0] !== null))
 {return $this->sanitize(SimplePie_Misc::fix_protocol($this->feed_url,array(4,false)),array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{return array(null,false);
}}} }
function subscribe_service ( $feed_url,$site_url = array(null,false) ) {
{if ( deAspis($this->subscribe_url()))
 {$return = concat($feed_url,Aspis_rawurlencode($this->feed_url));
if ( (($site_url[0] !== null) && (deAspis($this->get_link()) !== null)))
 {$return = concat($return,concat($site_url,Aspis_rawurlencode($this->get_link())));
}return $this->sanitize($return,array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{return array(null,false);
}}} }
function subscribe_aol (  ) {
{return $this->subscribe_service(array('http://feeds.my.aol.com/add.jsp?url=',false));
} }
function subscribe_bloglines (  ) {
{return $this->subscribe_service(array('http://www.bloglines.com/sub/',false));
} }
function subscribe_eskobo (  ) {
{return $this->subscribe_service(array('http://www.eskobo.com/?AddToMyPage=',false));
} }
function subscribe_feedfeeds (  ) {
{return $this->subscribe_service(array('http://www.feedfeeds.com/add?feed=',false));
} }
function subscribe_feedster (  ) {
{return $this->subscribe_service(array('http://www.feedster.com/myfeedster.php?action=addrss&confirm=no&rssurl=',false));
} }
function subscribe_google (  ) {
{return $this->subscribe_service(array('http://fusion.google.com/add?feedurl=',false));
} }
function subscribe_gritwire (  ) {
{return $this->subscribe_service(array('http://my.gritwire.com/feeds/addExternalFeed.aspx?FeedUrl=',false));
} }
function subscribe_msn (  ) {
{return $this->subscribe_service(array('http://my.msn.com/addtomymsn.armx?id=rss&ut=',false),array('&ru=',false));
} }
function subscribe_netvibes (  ) {
{return $this->subscribe_service(array('http://www.netvibes.com/subscribe.php?url=',false));
} }
function subscribe_newsburst (  ) {
{return $this->subscribe_service(array('http://www.newsburst.com/Source/?add=',false));
} }
function subscribe_newsgator (  ) {
{return $this->subscribe_service(array('http://www.newsgator.com/ngs/subscriber/subext.aspx?url=',false));
} }
function subscribe_odeo (  ) {
{return $this->subscribe_service(array('http://www.odeo.com/listen/subscribe?feed=',false));
} }
function subscribe_podnova (  ) {
{return $this->subscribe_service(array('http://www.podnova.com/index_your_podcasts.srf?action=add&url=',false));
} }
function subscribe_rojo (  ) {
{return $this->subscribe_service(array('http://www.rojo.com/add-subscription?resource=',false));
} }
function subscribe_yahoo (  ) {
{return $this->subscribe_service(array('http://add.my.yahoo.com/rss?url=',false));
} }
function get_feed_tags ( $namespace,$tag ) {
{$type = $this->get_type();
if ( ($type[0] & SIMPLEPIE_TYPE_ATOM_10))
 {if ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('feed')][0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('feed')] [0][(0)] [0][('child')] [0][$namespace[0]] [0][$tag[0]] ))))
 {return $this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('feed')][0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]];
}}if ( ($type[0] & SIMPLEPIE_TYPE_ATOM_03))
 {if ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('feed')][0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('feed')] [0][(0)] [0][('child')] [0][$namespace[0]] [0][$tag[0]] ))))
 {return $this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('feed')][0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]];
}}if ( ($type[0] & SIMPLEPIE_TYPE_RSS_RDF))
 {if ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] [0][('child')] [0][$namespace[0]] [0][$tag[0]] ))))
 {return $this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]];
}}if ( ($type[0] & SIMPLEPIE_TYPE_RSS_SYNDICATION))
 {if ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')][0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_20] [0][('rss')] [0][(0)] [0][('child')] [0][$namespace[0]] [0][$tag[0]] ))))
 {return $this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')][0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]];
}}return array(null,false);
} }
function get_channel_tags ( $namespace,$tag ) {
{$type = $this->get_type();
if ( ($type[0] & SIMPLEPIE_TYPE_ATOM_ALL))
 {if ( deAspis($return = $this->get_feed_tags($namespace,$tag)))
 {return $return;
}}if ( ($type[0] & SIMPLEPIE_TYPE_RSS_10))
 {if ( deAspis($channel = $this->get_feed_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('channel',false))))
 {if ( ((isset($channel[0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $channel [0][(0)] [0][('child')] [0][$namespace[0]] [0][$tag[0]]))))
 {return attachAspis($channel[0][(0)][0][('child')][0][$namespace[0]],$tag[0]);
}}}if ( ($type[0] & SIMPLEPIE_TYPE_RSS_090))
 {if ( deAspis($channel = $this->get_feed_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('channel',false))))
 {if ( ((isset($channel[0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $channel [0][(0)] [0][('child')] [0][$namespace[0]] [0][$tag[0]]))))
 {return attachAspis($channel[0][(0)][0][('child')][0][$namespace[0]],$tag[0]);
}}}if ( ($type[0] & SIMPLEPIE_TYPE_RSS_SYNDICATION))
 {if ( deAspis($channel = $this->get_feed_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('channel',false))))
 {if ( ((isset($channel[0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $channel [0][(0)] [0][('child')] [0][$namespace[0]] [0][$tag[0]]))))
 {return attachAspis($channel[0][(0)][0][('child')][0][$namespace[0]],$tag[0]);
}}}return array(null,false);
} }
function get_image_tags ( $namespace,$tag ) {
{$type = $this->get_type();
if ( ($type[0] & SIMPLEPIE_TYPE_RSS_10))
 {if ( deAspis($image = $this->get_feed_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('image',false))))
 {if ( ((isset($image[0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $image [0][(0)] [0][('child')] [0][$namespace[0]] [0][$tag[0]]))))
 {return attachAspis($image[0][(0)][0][('child')][0][$namespace[0]],$tag[0]);
}}}if ( ($type[0] & SIMPLEPIE_TYPE_RSS_090))
 {if ( deAspis($image = $this->get_feed_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('image',false))))
 {if ( ((isset($image[0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $image [0][(0)] [0][('child')] [0][$namespace[0]] [0][$tag[0]]))))
 {return attachAspis($image[0][(0)][0][('child')][0][$namespace[0]],$tag[0]);
}}}if ( ($type[0] & SIMPLEPIE_TYPE_RSS_SYNDICATION))
 {if ( deAspis($image = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('image',false))))
 {if ( ((isset($image[0][(0)][0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $image [0][(0)] [0][('child')] [0][$namespace[0]] [0][$tag[0]]))))
 {return attachAspis($image[0][(0)][0][('child')][0][$namespace[0]],$tag[0]);
}}}return array(null,false);
} }
function get_base ( $element = array(array(),false) ) {
{if ( (((!(deAspis($this->get_type()) & SIMPLEPIE_TYPE_RSS_SYNDICATION)) && (!((empty($element[0][('xml_base_explicit')]) || Aspis_empty( $element [0][('xml_base_explicit')]))))) && ((isset($element[0][('xml_base')]) && Aspis_isset( $element [0][('xml_base')])))))
 {return $element[0]['xml_base'];
}elseif ( (deAspis($this->get_link()) !== null))
 {return $this->get_link();
}else 
{{return $this->subscribe_url();
}}} }
function sanitize ( $data,$type,$base = array('',false) ) {
{return $this->sanitize[0]->sanitize($data,$type,$base);
} }
function get_title (  ) {
{if ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_10_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_03_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{return array(null,false);
}}} }
function get_category ( $key = array(0,false) ) {
{$categories = $this->get_categories();
if ( ((isset($categories[0][$key[0]]) && Aspis_isset( $categories [0][$key[0]]))))
 {return attachAspis($categories,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_categories (  ) {
{$categories = array(array(),false);
foreach ( deAspis(array_cast($this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('category',false)))) as $category  )
{$term = array(null,false);
$scheme = array(null,false);
$label = array(null,false);
if ( ((isset($category[0][('attribs')][0][('')][0][('term')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('term')]))))
 {$term = $this->sanitize($category[0][('attribs')][0][('')][0]['term'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('label')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('label')]))))
 {$label = $this->sanitize($category[0][('attribs')][0][('')][0]['label'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($categories[0][],addTaint(array(new $this->category_class[0]($term,$scheme,$label),false)));
}foreach ( deAspis(array_cast($this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('category',false)))) as $category  )
{$term = $this->sanitize($category[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
if ( ((isset($category[0][('attribs')][0][('')][0][('domain')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('domain')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['domain'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$scheme = array(null,false);
}}arrayAssignAdd($categories[0][],addTaint(array(new $this->category_class[0]($term,$scheme,array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('subject',false)))) as $category  )
{arrayAssignAdd($categories[0][],addTaint(array(new $this->category_class[0]($this->sanitize($category[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('subject',false)))) as $category  )
{arrayAssignAdd($categories[0][],addTaint(array(new $this->category_class[0]($this->sanitize($category[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}if ( (!((empty($categories) || Aspis_empty( $categories)))))
 {return SimplePie_Misc::array_unique($categories);
}else 
{{return array(null,false);
}}} }
function get_author ( $key = array(0,false) ) {
{$authors = $this->get_authors();
if ( ((isset($authors[0][$key[0]]) && Aspis_isset( $authors [0][$key[0]]))))
 {return attachAspis($authors,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_authors (  ) {
{$authors = array(array(),false);
foreach ( deAspis(array_cast($this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('author',false)))) as $author  )
{$name = array(null,false);
$uri = array(null,false);
$email = array(null,false);
if ( ((isset($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $author [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0][('data')]) && Aspis_isset( $author [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('uri')] [0][(0)] [0][('data')]))))
 {$uri = $this->sanitize($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')],(0))));
}if ( ((isset($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $author [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($uri[0] !== null)))
 {arrayAssignAdd($authors[0][],addTaint(array(new $this->author_class[0]($name,$uri,$email),false)));
}}if ( deAspis($author = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('author',false))))
 {$name = array(null,false);
$url = array(null,false);
$email = array(null,false);
if ( ((isset($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $author [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0][('data')]) && Aspis_isset( $author [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('url')] [0][(0)] [0][('data')]))))
 {$url = $this->sanitize($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')],(0))));
}if ( ((isset($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $author [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($url[0] !== null)))
 {arrayAssignAdd($authors[0][],addTaint(array(new $this->author_class[0]($name,$url,$email),false)));
}}foreach ( deAspis(array_cast($this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('creator',false)))) as $author  )
{arrayAssignAdd($authors[0][],addTaint(array(new $this->author_class[0]($this->sanitize($author[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('creator',false)))) as $author  )
{arrayAssignAdd($authors[0][],addTaint(array(new $this->author_class[0]($this->sanitize($author[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('author',false)))) as $author  )
{arrayAssignAdd($authors[0][],addTaint(array(new $this->author_class[0]($this->sanitize($author[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}if ( (!((empty($authors) || Aspis_empty( $authors)))))
 {return SimplePie_Misc::array_unique($authors);
}else 
{{return array(null,false);
}}} }
function get_contributor ( $key = array(0,false) ) {
{$contributors = $this->get_contributors();
if ( ((isset($contributors[0][$key[0]]) && Aspis_isset( $contributors [0][$key[0]]))))
 {return attachAspis($contributors,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_contributors (  ) {
{$contributors = array(array(),false);
foreach ( deAspis(array_cast($this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('contributor',false)))) as $contributor  )
{$name = array(null,false);
$uri = array(null,false);
$email = array(null,false);
if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('uri')] [0][(0)] [0][('data')]))))
 {$uri = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')],(0))));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($uri[0] !== null)))
 {arrayAssignAdd($contributors[0][],addTaint(array(new $this->author_class[0]($name,$uri,$email),false)));
}}foreach ( deAspis(array_cast($this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('contributor',false)))) as $contributor  )
{$name = array(null,false);
$url = array(null,false);
$email = array(null,false);
if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('url')] [0][(0)] [0][('data')]))))
 {$url = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')],(0))));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($url[0] !== null)))
 {arrayAssignAdd($contributors[0][],addTaint(array(new $this->author_class[0]($name,$url,$email),false)));
}}if ( (!((empty($contributors) || Aspis_empty( $contributors)))))
 {return SimplePie_Misc::array_unique($contributors);
}else 
{{return array(null,false);
}}} }
function get_link ( $key = array(0,false),$rel = array('alternate',false) ) {
{$links = $this->get_links($rel);
if ( ((isset($links[0][$key[0]]) && Aspis_isset( $links [0][$key[0]]))))
 {return attachAspis($links,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_permalink (  ) {
{return $this->get_link(array(0,false));
} }
function get_links ( $rel = array('alternate',false) ) {
{if ( (!((isset($this->data[0][('links')]) && Aspis_isset( $this ->data [0][('links')] )))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('links',false))),addTaint(array(array(),false)));
if ( deAspis($links = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('link',false))))
 {foreach ( $links[0] as $link  )
{if ( ((isset($link[0][('attribs')][0][('')][0][('href')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('href')]))))
 {$link_rel = ((isset($link[0][('attribs')][0][('')][0][('rel')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('rel')]))) ? $link[0][('attribs')][0][('')][0]['rel'] : array('alternate',false);
arrayAssignAdd($this->data[0][('links')][0][$link_rel[0]][0][],addTaint($this->sanitize($link[0][('attribs')][0][('')][0]['href'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base($link))));
}}}if ( deAspis($links = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('link',false))))
 {foreach ( $links[0] as $link  )
{if ( ((isset($link[0][('attribs')][0][('')][0][('href')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('href')]))))
 {$link_rel = ((isset($link[0][('attribs')][0][('')][0][('rel')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('rel')]))) ? $link[0][('attribs')][0][('')][0]['rel'] : array('alternate',false);
arrayAssignAdd($this->data[0][('links')][0][$link_rel[0]][0][],addTaint($this->sanitize($link[0][('attribs')][0][('')][0]['href'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base($link))));
}}}if ( deAspis($links = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('link',false))))
 {arrayAssignAdd($this->data[0][('links')][0][('alternate')][0][],addTaint($this->sanitize($links[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($links,(0))))));
}if ( deAspis($links = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('link',false))))
 {arrayAssignAdd($this->data[0][('links')][0][('alternate')][0][],addTaint($this->sanitize($links[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($links,(0))))));
}if ( deAspis($links = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('link',false))))
 {arrayAssignAdd($this->data[0][('links')][0][('alternate')][0][],addTaint($this->sanitize($links[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($links,(0))))));
}$keys = attAspisRC(array_keys(deAspisRC($this->data[0][('links')])));
foreach ( $keys[0] as $key  )
{if ( deAspis(SimplePie_Misc::is_isegment_nz_nc($key)))
 {if ( ((isset($this->data[0][('links')][0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))]) && Aspis_isset( $this ->data [0][('links')] [0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))] ))))
 {arrayAssign($this->data[0][('links')][0],deAspis(registerTaint(concat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))),addTaint(Aspis_array_merge($this->data[0][('links')][0][$key[0]],$this->data[0][('links')][0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))])));
$this->data[0][('links')][0][deAspis(registerTaint($key))] = &addTaintR($this->data[0][('links')][0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))]);
}else 
{{$this->data[0][('links')][0][deAspis(registerTaint(concat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key)))] = &addTaintR($this->data[0][('links')][0][$key[0]]);
}}}elseif ( (deAspis(Aspis_substr($key,array(0,false),array(41,false))) === SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY))
 {$this->data[0][('links')][0][deAspis(registerTaint(Aspis_substr($key,array(41,false))))] = &addTaintR($this->data[0][('links')][0][$key[0]]);
}arrayAssign($this->data[0][('links')][0],deAspis(registerTaint($key)),addTaint(attAspisRC(array_unique(deAspisRC($this->data[0][('links')][0][$key[0]])))));
}}if ( ((isset($this->data[0][('links')][0][$rel[0]]) && Aspis_isset( $this ->data [0][('links')] [0][$rel[0]] ))))
 {return $this->data[0][('links')][0][$rel[0]];
}else 
{{return array(null,false);
}}} }
function get_all_discovered_feeds (  ) {
{return $this->all_discovered_feeds;
} }
function get_description (  ) {
{if ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('subtitle',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_10_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('tagline',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_03_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('summary',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('subtitle',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_HTML,false),$this->get_base(attachAspis($return,(0))));
}else 
{{return array(null,false);
}}} }
function get_copyright (  ) {
{if ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('rights',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_10_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('copyright',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_03_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('copyright',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('rights',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('rights',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{return array(null,false);
}}} }
function get_language (  ) {
{if ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('language',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('language',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('language',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('feed')][0][(0)][0][('xml_lang')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('feed')] [0][(0)] [0][('xml_lang')] ))))
 {return $this->sanitize($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('feed')][0][(0)][0][('xml_lang')],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('feed')][0][(0)][0][('xml_lang')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('feed')] [0][(0)] [0][('xml_lang')] ))))
 {return $this->sanitize($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('feed')][0][(0)][0][('xml_lang')],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('xml_lang')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] [0][('xml_lang')] ))))
 {return $this->sanitize($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)][0][('xml_lang')],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( ((isset($this->data[0][('headers')][0][('content-language')]) && Aspis_isset( $this ->data [0][('headers')] [0][('content-language')] ))))
 {return $this->sanitize($this->data[0][('headers')][0][('content-language')],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{return array(null,false);
}}} }
function get_latitude (  ) {
{if ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_W3C_BASIC_GEO,false),array('lat',false))))
 {return float_cast($return[0][(0)][0]['data']);
}elseif ( (deAspis(($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_GEORSS,false),array('point',false)))) && deAspis(Aspis_preg_match(array('/^((?:-)?[0-9]+(?:\.[0-9]+)) ((?:-)?[0-9]+(?:\.[0-9]+))$/',false),$return[0][(0)][0]['data'],$match))))
 {return float_cast(attachAspis($match,(1)));
}else 
{{return array(null,false);
}}} }
function get_longitude (  ) {
{if ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_W3C_BASIC_GEO,false),array('long',false))))
 {return float_cast($return[0][(0)][0]['data']);
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_W3C_BASIC_GEO,false),array('lon',false))))
 {return float_cast($return[0][(0)][0]['data']);
}elseif ( (deAspis(($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_GEORSS,false),array('point',false)))) && deAspis(Aspis_preg_match(array('/^((?:-)?[0-9]+(?:\.[0-9]+)) ((?:-)?[0-9]+(?:\.[0-9]+))$/',false),$return[0][(0)][0]['data'],$match))))
 {return float_cast(attachAspis($match,(2)));
}else 
{{return array(null,false);
}}} }
function get_image_title (  ) {
{if ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{return array(null,false);
}}} }
function get_image_url (  ) {
{if ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('image',false))))
 {return $this->sanitize($return[0][(0)][0][('attribs')][0][('')][0]['href'],array(SIMPLEPIE_CONSTRUCT_IRI,false));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('logo',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('icon',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('url',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('url',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('url',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}else 
{{return array(null,false);
}}} }
function get_image_link (  ) {
{if ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('link',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('link',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('link',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}else 
{{return array(null,false);
}}} }
function get_image_width (  ) {
{if ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('width',false))))
 {return attAspis(round(deAspis($return[0][(0)][0]['data'])));
}elseif ( ((deAspis($this->get_type()) & SIMPLEPIE_TYPE_RSS_SYNDICATION) && deAspis($this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('url',false)))))
 {return array(88.0,false);
}else 
{{return array(null,false);
}}} }
function get_image_height (  ) {
{if ( deAspis($return = $this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('height',false))))
 {return attAspis(round(deAspis($return[0][(0)][0]['data'])));
}elseif ( ((deAspis($this->get_type()) & SIMPLEPIE_TYPE_RSS_SYNDICATION) && deAspis($this->get_image_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('url',false)))))
 {return array(31.0,false);
}else 
{{return array(null,false);
}}} }
function get_item_quantity ( $max = array(0,false) ) {
{$max = int_cast($max);
$qty = attAspis(count(deAspis($this->get_items())));
if ( ($max[0] === (0)))
 {return $qty;
}else 
{{return ($qty[0] > $max[0]) ? $max : $qty;
}}} }
function get_item ( $key = array(0,false) ) {
{$items = $this->get_items();
if ( ((isset($items[0][$key[0]]) && Aspis_isset( $items [0][$key[0]]))))
 {return attachAspis($items,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_items ( $start = array(0,false),$end = array(0,false) ) {
{if ( (!((isset($this->data[0][('items')]) && Aspis_isset( $this ->data [0][('items')] )))))
 {if ( (!((empty($this->multifeed_objects) || Aspis_empty( $this ->multifeed_objects )))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('items',false))),addTaint(SimplePie::merge_items($this->multifeed_objects,$start,$end,$this->item_limit)));
}else 
{{arrayAssign($this->data[0],deAspis(registerTaint(array('items',false))),addTaint(array(array(),false)));
if ( deAspis($items = $this->get_feed_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('entry',false))))
 {$keys = attAspisRC(array_keys(deAspisRC($items)));
foreach ( $keys[0] as $key  )
{arrayAssignAdd($this->data[0][('items')][0][],addTaint(array(new $this->item_class[0](array($this,false),$items[0][$key[0]]),false)));
}}if ( deAspis($items = $this->get_feed_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('entry',false))))
 {$keys = attAspisRC(array_keys(deAspisRC($items)));
foreach ( $keys[0] as $key  )
{arrayAssignAdd($this->data[0][('items')][0][],addTaint(array(new $this->item_class[0](array($this,false),$items[0][$key[0]]),false)));
}}if ( deAspis($items = $this->get_feed_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('item',false))))
 {$keys = attAspisRC(array_keys(deAspisRC($items)));
foreach ( $keys[0] as $key  )
{arrayAssignAdd($this->data[0][('items')][0][],addTaint(array(new $this->item_class[0](array($this,false),$items[0][$key[0]]),false)));
}}if ( deAspis($items = $this->get_feed_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('item',false))))
 {$keys = attAspisRC(array_keys(deAspisRC($items)));
foreach ( $keys[0] as $key  )
{arrayAssignAdd($this->data[0][('items')][0][],addTaint(array(new $this->item_class[0](array($this,false),$items[0][$key[0]]),false)));
}}if ( deAspis($items = $this->get_channel_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('item',false))))
 {$keys = attAspisRC(array_keys(deAspisRC($items)));
foreach ( $keys[0] as $key  )
{arrayAssignAdd($this->data[0][('items')][0][],addTaint(array(new $this->item_class[0](array($this,false),$items[0][$key[0]]),false)));
}}}}}if ( (!((empty($this->data[0][('items')]) || Aspis_empty( $this ->data [0][('items')] )))))
 {if ( ($this->order_by_date[0] && ((empty($this->multifeed_objects) || Aspis_empty( $this ->multifeed_objects )))))
 {if ( (!((isset($this->data[0][('ordered_items')]) && Aspis_isset( $this ->data [0][('ordered_items')] )))))
 {$do_sort = array(true,false);
foreach ( $this->data[0][('items')][0] as $item  )
{if ( (denot_boolean($item[0]->get_date(array('U',false)))))
 {$do_sort = array(false,false);
break ;
}}$item = array(null,false);
arrayAssign($this->data[0],deAspis(registerTaint(array('ordered_items',false))),addTaint($this->data[0][('items')]));
if ( $do_sort[0])
 {Aspis_usort($this->data[0][('ordered_items')],array(array(array($this,false),array('sort_items',false)),false));
}}$items = $this->data[0][('ordered_items')];
}else 
{{$items = $this->data[0][('items')];
}}if ( ($end[0] === (0)))
 {return Aspis_array_slice($items,$start);
}else 
{{return Aspis_array_slice($items,$start,$end);
}}}else 
{{return array(array(),false);
}}} }
function sort_items ( $a,$b ) {
{return array(deAspis($a[0]->get_date(array('U',false))) <= deAspis($b[0]->get_date(array('U',false))),false);
} }
function merge_items ( $urls,$start = array(0,false),$end = array(0,false),$limit = array(0,false) ) {
{if ( (is_array($urls[0]) && ((sizeof(deAspisRC($urls))) > (0))))
 {$items = array(array(),false);
foreach ( $urls[0] as $arg  )
{if ( is_a(deAspisRC($arg),('SimplePie')))
 {$items = Aspis_array_merge($items,$arg[0]->get_items(array(0,false),$limit));
}else 
{{trigger_error('Arguments must be SimplePie objects',E_USER_WARNING);
}}}$do_sort = array(true,false);
foreach ( $items[0] as $item  )
{if ( (denot_boolean($item[0]->get_date(array('U',false)))))
 {$do_sort = array(false,false);
break ;
}}$item = array(null,false);
if ( $do_sort[0])
 {Aspis_usort($items,array(array(array('SimplePie',false),array('sort_items',false)),false));
}if ( ($end[0] === (0)))
 {return Aspis_array_slice($items,$start);
}else 
{{return Aspis_array_slice($items,$start,$end);
}}}else 
{{trigger_error('Cannot merge zero SimplePie objects',E_USER_WARNING);
return array(array(),false);
}}} }
}class SimplePie_Item{var $feed;
var $data = array(array(),false);
function SimplePie_Item ( $feed,$data ) {
{$this->feed = $feed;
$this->data = $data;
} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize($this->data))));
} }
function __destruct (  ) {
{if ( (((version_compare(PHP_VERSION,'5.3','<')) || (!(gc_enabled()))) && (!(ini_get('zend.ze1_compatibility_mode')))))
 {unset($this->feed);
}} }
function get_item_tags ( $namespace,$tag ) {
{if ( ((isset($this->data[0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $this ->data [0][('child')] [0][$namespace[0]] [0][$tag[0]] ))))
 {return $this->data[0][('child')][0][$namespace[0]][0][$tag[0]];
}else 
{{return array(null,false);
}}} }
function get_base ( $element = array(array(),false) ) {
{return $this->feed[0]->get_base($element);
} }
function sanitize ( $data,$type,$base = array('',false) ) {
{return $this->feed[0]->sanitize($data,$type,$base);
} }
function get_feed (  ) {
{return $this->feed;
} }
function get_id ( $hash = array(false,false) ) {
{if ( (denot_boolean($hash)))
 {if ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('id',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('id',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('guid',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('identifier',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('identifier',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( (deAspis(($return = $this->get_permalink())) !== null))
 {return $return;
}elseif ( (deAspis(($return = $this->get_title())) !== null))
 {return $return;
}}if ( ((deAspis($this->get_permalink()) !== null) || (deAspis($this->get_title()) !== null)))
 {return attAspis(md5((deconcat($this->get_permalink(),$this->get_title()))));
}else 
{{return attAspis(md5(deAspis(Aspis_serialize($this->data))));
}}} }
function get_title (  ) {
{if ( (!((isset($this->data[0][('title')]) && Aspis_isset( $this ->data [0][('title')] )))))
 {if ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('title',false))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('title',false))),addTaint($this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_10_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('title',false))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('title',false))),addTaint($this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_03_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('title',false))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('title',false))),addTaint($this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('title',false))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('title',false))),addTaint($this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('title',false))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('title',false))),addTaint($this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('title',false))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('title',false))),addTaint($this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('title',false))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('title',false))),addTaint($this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false))));
}else 
{{arrayAssign($this->data[0],deAspis(registerTaint(array('title',false))),addTaint(array(null,false)));
}}}return $this->data[0][('title')];
} }
function get_description ( $description_only = array(false,false) ) {
{if ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('summary',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_10_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('summary',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_03_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('summary',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('subtitle',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( (denot_boolean($description_only)))
 {return $this->get_content(array(true,false));
}else 
{{return array(null,false);
}}} }
function get_content ( $content_only = array(false,false) ) {
{if ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('content',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_10_content_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('content',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_03_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_10_MODULES_CONTENT,false),array('encoded',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( (denot_boolean($content_only)))
 {return $this->get_description(array(true,false));
}else 
{{return array(null,false);
}}} }
function get_category ( $key = array(0,false) ) {
{$categories = $this->get_categories();
if ( ((isset($categories[0][$key[0]]) && Aspis_isset( $categories [0][$key[0]]))))
 {return attachAspis($categories,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_categories (  ) {
{$categories = array(array(),false);
foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('category',false)))) as $category  )
{$term = array(null,false);
$scheme = array(null,false);
$label = array(null,false);
if ( ((isset($category[0][('attribs')][0][('')][0][('term')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('term')]))))
 {$term = $this->sanitize($category[0][('attribs')][0][('')][0]['term'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('label')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('label')]))))
 {$label = $this->sanitize($category[0][('attribs')][0][('')][0]['label'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($categories[0][],addTaint(array(new $this->feed[0]->category_class[0]($term,$scheme,$label),false)));
}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('category',false)))) as $category  )
{$term = $this->sanitize($category[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
if ( ((isset($category[0][('attribs')][0][('')][0][('domain')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('domain')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['domain'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$scheme = array(null,false);
}}arrayAssignAdd($categories[0][],addTaint(array(new $this->feed[0]->category_class[0]($term,$scheme,array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('subject',false)))) as $category  )
{arrayAssignAdd($categories[0][],addTaint(array(new $this->feed[0]->category_class[0]($this->sanitize($category[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('subject',false)))) as $category  )
{arrayAssignAdd($categories[0][],addTaint(array(new $this->feed[0]->category_class[0]($this->sanitize($category[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}if ( (!((empty($categories) || Aspis_empty( $categories)))))
 {return SimplePie_Misc::array_unique($categories);
}else 
{{return array(null,false);
}}} }
function get_author ( $key = array(0,false) ) {
{$authors = $this->get_authors();
if ( ((isset($authors[0][$key[0]]) && Aspis_isset( $authors [0][$key[0]]))))
 {return attachAspis($authors,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_contributor ( $key = array(0,false) ) {
{$contributors = $this->get_contributors();
if ( ((isset($contributors[0][$key[0]]) && Aspis_isset( $contributors [0][$key[0]]))))
 {return attachAspis($contributors,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_contributors (  ) {
{$contributors = array(array(),false);
foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('contributor',false)))) as $contributor  )
{$name = array(null,false);
$uri = array(null,false);
$email = array(null,false);
if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('uri')] [0][(0)] [0][('data')]))))
 {$uri = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')],(0))));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($uri[0] !== null)))
 {arrayAssignAdd($contributors[0][],addTaint(array(new $this->feed[0]->author_class[0]($name,$uri,$email),false)));
}}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('contributor',false)))) as $contributor  )
{$name = array(null,false);
$url = array(null,false);
$email = array(null,false);
if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('url')] [0][(0)] [0][('data')]))))
 {$url = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')],(0))));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($url[0] !== null)))
 {arrayAssignAdd($contributors[0][],addTaint(array(new $this->feed[0]->author_class[0]($name,$url,$email),false)));
}}if ( (!((empty($contributors) || Aspis_empty( $contributors)))))
 {return SimplePie_Misc::array_unique($contributors);
}else 
{{return array(null,false);
}}} }
function get_authors (  ) {
{$authors = array(array(),false);
foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('author',false)))) as $author  )
{$name = array(null,false);
$uri = array(null,false);
$email = array(null,false);
if ( ((isset($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $author [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0][('data')]) && Aspis_isset( $author [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('uri')] [0][(0)] [0][('data')]))))
 {$uri = $this->sanitize($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')],(0))));
}if ( ((isset($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $author [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($uri[0] !== null)))
 {arrayAssignAdd($authors[0][],addTaint(array(new $this->feed[0]->author_class[0]($name,$uri,$email),false)));
}}if ( deAspis($author = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('author',false))))
 {$name = array(null,false);
$url = array(null,false);
$email = array(null,false);
if ( ((isset($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $author [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0][('data')]) && Aspis_isset( $author [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('url')] [0][(0)] [0][('data')]))))
 {$url = $this->sanitize($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')],(0))));
}if ( ((isset($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $author [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($url[0] !== null)))
 {arrayAssignAdd($authors[0][],addTaint(array(new $this->feed[0]->author_class[0]($name,$url,$email),false)));
}}if ( deAspis($author = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('author',false))))
 {arrayAssignAdd($authors[0][],addTaint(array(new $this->feed[0]->author_class[0](array(null,false),array(null,false),$this->sanitize($author[0][(0)][0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false))),false)));
}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('creator',false)))) as $author  )
{arrayAssignAdd($authors[0][],addTaint(array(new $this->feed[0]->author_class[0]($this->sanitize($author[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('creator',false)))) as $author  )
{arrayAssignAdd($authors[0][],addTaint(array(new $this->feed[0]->author_class[0]($this->sanitize($author[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('author',false)))) as $author  )
{arrayAssignAdd($authors[0][],addTaint(array(new $this->feed[0]->author_class[0]($this->sanitize($author[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}if ( (!((empty($authors) || Aspis_empty( $authors)))))
 {return SimplePie_Misc::array_unique($authors);
}elseif ( (deAspis(($source = $this->get_source())) && deAspis(($authors = $source[0]->get_authors()))))
 {return $authors;
}elseif ( deAspis($authors = $this->feed[0]->get_authors()))
 {return $authors;
}else 
{{return array(null,false);
}}} }
function get_copyright (  ) {
{if ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('rights',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_10_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('rights',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('rights',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{return array(null,false);
}}} }
function get_date ( $date_format = array('j F Y, g:i a',false) ) {
{if ( (!((isset($this->data[0][('date')]) && Aspis_isset( $this ->data [0][('date')] )))))
 {if ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('published',false))))
 {arrayAssign($this->data[0][('date')][0],deAspis(registerTaint(array('raw',false))),addTaint($return[0][(0)][0]['data']));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('updated',false))))
 {arrayAssign($this->data[0][('date')][0],deAspis(registerTaint(array('raw',false))),addTaint($return[0][(0)][0]['data']));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('issued',false))))
 {arrayAssign($this->data[0][('date')][0],deAspis(registerTaint(array('raw',false))),addTaint($return[0][(0)][0]['data']));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('created',false))))
 {arrayAssign($this->data[0][('date')][0],deAspis(registerTaint(array('raw',false))),addTaint($return[0][(0)][0]['data']));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('modified',false))))
 {arrayAssign($this->data[0][('date')][0],deAspis(registerTaint(array('raw',false))),addTaint($return[0][(0)][0]['data']));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('pubDate',false))))
 {arrayAssign($this->data[0][('date')][0],deAspis(registerTaint(array('raw',false))),addTaint($return[0][(0)][0]['data']));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('date',false))))
 {arrayAssign($this->data[0][('date')][0],deAspis(registerTaint(array('raw',false))),addTaint($return[0][(0)][0]['data']));
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('date',false))))
 {arrayAssign($this->data[0][('date')][0],deAspis(registerTaint(array('raw',false))),addTaint($return[0][(0)][0]['data']));
}if ( (!((empty($this->data[0][('date')][0][('raw')]) || Aspis_empty( $this ->data [0][('date')] [0][('raw')] )))))
 {$parser = SimplePie_Parse_Date::get();
arrayAssign($this->data[0][('date')][0],deAspis(registerTaint(array('parsed',false))),addTaint($parser[0]->parse($this->data[0][('date')][0][('raw')])));
}else 
{{arrayAssign($this->data[0],deAspis(registerTaint(array('date',false))),addTaint(array(null,false)));
}}}if ( $this->data[0][('date')][0])
 {$date_format = string_cast($date_format);
switch ( $date_format[0] ) {
case (''):return $this->sanitize($this->data[0][('date')][0][('raw')],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
case ('U'):return $this->data[0][('date')][0][('parsed')];
default :return attAspis(date($date_format[0],$this->data[0][('date')][0][('parsed')][0]));
 }
}else 
{{return array(null,false);
}}} }
function get_local_date ( $date_format = array('%c',false) ) {
{if ( (denot_boolean($date_format)))
 {return $this->sanitize($this->get_date(array('',false)),array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( (deAspis(($date = $this->get_date(array('U',false)))) !== null))
 {return attAspis(strftime($date_format[0],$date[0]));
}else 
{{return array(null,false);
}}} }
function get_permalink (  ) {
{$link = $this->get_link();
$enclosure = $this->get_enclosure(array(0,false));
if ( ($link[0] !== null))
 {return $link;
}elseif ( ($enclosure[0] !== null))
 {return $enclosure[0]->get_link();
}else 
{{return array(null,false);
}}} }
function get_link ( $key = array(0,false),$rel = array('alternate',false) ) {
{$links = $this->get_links($rel);
if ( (deAspis(attachAspis($links,$key[0])) !== null))
 {return attachAspis($links,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_links ( $rel = array('alternate',false) ) {
{if ( (!((isset($this->data[0][('links')]) && Aspis_isset( $this ->data [0][('links')] )))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('links',false))),addTaint(array(array(),false)));
foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('link',false)))) as $link  )
{if ( ((isset($link[0][('attribs')][0][('')][0][('href')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('href')]))))
 {$link_rel = ((isset($link[0][('attribs')][0][('')][0][('rel')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('rel')]))) ? $link[0][('attribs')][0][('')][0]['rel'] : array('alternate',false);
arrayAssignAdd($this->data[0][('links')][0][$link_rel[0]][0][],addTaint($this->sanitize($link[0][('attribs')][0][('')][0]['href'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base($link))));
}}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('link',false)))) as $link  )
{if ( ((isset($link[0][('attribs')][0][('')][0][('href')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('href')]))))
 {$link_rel = ((isset($link[0][('attribs')][0][('')][0][('rel')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('rel')]))) ? $link[0][('attribs')][0][('')][0]['rel'] : array('alternate',false);
arrayAssignAdd($this->data[0][('links')][0][$link_rel[0]][0][],addTaint($this->sanitize($link[0][('attribs')][0][('')][0]['href'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base($link))));
}}if ( deAspis($links = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('link',false))))
 {arrayAssignAdd($this->data[0][('links')][0][('alternate')][0][],addTaint($this->sanitize($links[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($links,(0))))));
}if ( deAspis($links = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('link',false))))
 {arrayAssignAdd($this->data[0][('links')][0][('alternate')][0][],addTaint($this->sanitize($links[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($links,(0))))));
}if ( deAspis($links = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('link',false))))
 {arrayAssignAdd($this->data[0][('links')][0][('alternate')][0][],addTaint($this->sanitize($links[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($links,(0))))));
}if ( deAspis($links = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('guid',false))))
 {if ( ((!((isset($links[0][(0)][0][('attribs')][0][('')][0][('isPermaLink')]) && Aspis_isset( $links [0][(0)] [0][('attribs')] [0][('')] [0][('isPermaLink')])))) || (deAspis(Aspis_strtolower(Aspis_trim($links[0][(0)][0][('attribs')][0][('')][0]['isPermaLink']))) === ('true'))))
 {arrayAssignAdd($this->data[0][('links')][0][('alternate')][0][],addTaint($this->sanitize($links[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($links,(0))))));
}}$keys = attAspisRC(array_keys(deAspisRC($this->data[0][('links')])));
foreach ( $keys[0] as $key  )
{if ( deAspis(SimplePie_Misc::is_isegment_nz_nc($key)))
 {if ( ((isset($this->data[0][('links')][0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))]) && Aspis_isset( $this ->data [0][('links')] [0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))] ))))
 {arrayAssign($this->data[0][('links')][0],deAspis(registerTaint(concat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))),addTaint(Aspis_array_merge($this->data[0][('links')][0][$key[0]],$this->data[0][('links')][0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))])));
$this->data[0][('links')][0][deAspis(registerTaint($key))] = &addTaintR($this->data[0][('links')][0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))]);
}else 
{{$this->data[0][('links')][0][deAspis(registerTaint(concat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key)))] = &addTaintR($this->data[0][('links')][0][$key[0]]);
}}}elseif ( (deAspis(Aspis_substr($key,array(0,false),array(41,false))) === SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY))
 {$this->data[0][('links')][0][deAspis(registerTaint(Aspis_substr($key,array(41,false))))] = &addTaintR($this->data[0][('links')][0][$key[0]]);
}arrayAssign($this->data[0][('links')][0],deAspis(registerTaint($key)),addTaint(attAspisRC(array_unique(deAspisRC($this->data[0][('links')][0][$key[0]])))));
}}if ( ((isset($this->data[0][('links')][0][$rel[0]]) && Aspis_isset( $this ->data [0][('links')] [0][$rel[0]] ))))
 {return $this->data[0][('links')][0][$rel[0]];
}else 
{{return array(null,false);
}}} }
function get_enclosure ( $key = array(0,false),$prefer = array(null,false) ) {
{$enclosures = $this->get_enclosures();
if ( ((isset($enclosures[0][$key[0]]) && Aspis_isset( $enclosures [0][$key[0]]))))
 {return attachAspis($enclosures,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_enclosures (  ) {
{if ( (!((isset($this->data[0][('enclosures')]) && Aspis_isset( $this ->data [0][('enclosures')] )))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('enclosures',false))),addTaint(array(array(),false)));
$captions_parent = array(null,false);
$categories_parent = array(null,false);
$copyrights_parent = array(null,false);
$credits_parent = array(null,false);
$description_parent = array(null,false);
$duration_parent = array(null,false);
$hashes_parent = array(null,false);
$keywords_parent = array(null,false);
$player_parent = array(null,false);
$ratings_parent = array(null,false);
$restrictions_parent = array(null,false);
$thumbnails_parent = array(null,false);
$title_parent = array(null,false);
$parent = $this->get_feed();
if ( deAspis($captions = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('text',false))))
 {foreach ( $captions[0] as $caption  )
{$caption_type = array(null,false);
$caption_lang = array(null,false);
$caption_startTime = array(null,false);
$caption_endTime = array(null,false);
$caption_text = array(null,false);
if ( ((isset($caption[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('type')]))))
 {$caption_type = $this->sanitize($caption[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('lang')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('lang')]))))
 {$caption_lang = $this->sanitize($caption[0][('attribs')][0][('')][0]['lang'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('start')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('start')]))))
 {$caption_startTime = $this->sanitize($caption[0][('attribs')][0][('')][0]['start'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('end')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('end')]))))
 {$caption_endTime = $this->sanitize($caption[0][('attribs')][0][('')][0]['end'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('data')]) && Aspis_isset( $caption [0][('data')]))))
 {$caption_text = $this->sanitize($caption[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($captions_parent[0][],addTaint(array(new $this->feed[0]->caption_class[0]($caption_type,$caption_lang,$caption_startTime,$caption_endTime,$caption_text),false)));
}}elseif ( deAspis($captions = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('text',false))))
 {foreach ( $captions[0] as $caption  )
{$caption_type = array(null,false);
$caption_lang = array(null,false);
$caption_startTime = array(null,false);
$caption_endTime = array(null,false);
$caption_text = array(null,false);
if ( ((isset($caption[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('type')]))))
 {$caption_type = $this->sanitize($caption[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('lang')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('lang')]))))
 {$caption_lang = $this->sanitize($caption[0][('attribs')][0][('')][0]['lang'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('start')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('start')]))))
 {$caption_startTime = $this->sanitize($caption[0][('attribs')][0][('')][0]['start'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('end')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('end')]))))
 {$caption_endTime = $this->sanitize($caption[0][('attribs')][0][('')][0]['end'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('data')]) && Aspis_isset( $caption [0][('data')]))))
 {$caption_text = $this->sanitize($caption[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($captions_parent[0][],addTaint(array(new $this->feed[0]->caption_class[0]($caption_type,$caption_lang,$caption_startTime,$caption_endTime,$caption_text),false)));
}}if ( is_array($captions_parent[0]))
 {$captions_parent = Aspis_array_values(SimplePie_Misc::array_unique($captions_parent));
}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('category',false)))) as $category  )
{$term = array(null,false);
$scheme = array(null,false);
$label = array(null,false);
if ( ((isset($category[0][('data')]) && Aspis_isset( $category [0][('data')]))))
 {$term = $this->sanitize($category[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$scheme = array('http://search.yahoo.com/mrss/category_schema',false);
}}if ( ((isset($category[0][('attribs')][0][('')][0][('label')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('label')]))))
 {$label = $this->sanitize($category[0][('attribs')][0][('')][0]['label'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($categories_parent[0][],addTaint(array(new $this->feed[0]->category_class[0]($term,$scheme,$label),false)));
}foreach ( deAspis(array_cast($parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('category',false)))) as $category  )
{$term = array(null,false);
$scheme = array(null,false);
$label = array(null,false);
if ( ((isset($category[0][('data')]) && Aspis_isset( $category [0][('data')]))))
 {$term = $this->sanitize($category[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$scheme = array('http://search.yahoo.com/mrss/category_schema',false);
}}if ( ((isset($category[0][('attribs')][0][('')][0][('label')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('label')]))))
 {$label = $this->sanitize($category[0][('attribs')][0][('')][0]['label'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($categories_parent[0][],addTaint(array(new $this->feed[0]->category_class[0]($term,$scheme,$label),false)));
}foreach ( deAspis(array_cast($parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('category',false)))) as $category  )
{$term = array(null,false);
$scheme = array('http://www.itunes.com/dtds/podcast-1.0.dtd',false);
$label = array(null,false);
if ( ((isset($category[0][('attribs')][0][('')][0][('text')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('text')]))))
 {$label = $this->sanitize($category[0][('attribs')][0][('')][0]['text'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($categories_parent[0][],addTaint(array(new $this->feed[0]->category_class[0]($term,$scheme,$label),false)));
if ( ((isset($category[0][('child')][0][SIMPLEPIE_NAMESPACE_ITUNES][0][('category')]) && Aspis_isset( $category [0][('child')] [0][SIMPLEPIE_NAMESPACE_ITUNES] [0][('category')]))))
 {foreach ( deAspis(array_cast($category[0][('child')][0][SIMPLEPIE_NAMESPACE_ITUNES][0]['category'])) as $subcategory  )
{if ( ((isset($subcategory[0][('attribs')][0][('')][0][('text')]) && Aspis_isset( $subcategory [0][('attribs')] [0][('')] [0][('text')]))))
 {$label = $this->sanitize($subcategory[0][('attribs')][0][('')][0]['text'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($categories_parent[0][],addTaint(array(new $this->feed[0]->category_class[0]($term,$scheme,$label),false)));
}}}if ( is_array($categories_parent[0]))
 {$categories_parent = Aspis_array_values(SimplePie_Misc::array_unique($categories_parent));
}if ( deAspis($copyright = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('copyright',false))))
 {$copyright_url = array(null,false);
$copyright_label = array(null,false);
if ( ((isset($copyright[0][(0)][0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $copyright [0][(0)] [0][('attribs')] [0][('')] [0][('url')]))))
 {$copyright_url = $this->sanitize($copyright[0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($copyright[0][(0)][0][('data')]) && Aspis_isset( $copyright [0][(0)] [0][('data')]))))
 {$copyright_label = $this->sanitize($copyright[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}$copyrights_parent = array(new $this->feed[0]->copyright_class[0]($copyright_url,$copyright_label),false);
}elseif ( deAspis($copyright = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('copyright',false))))
 {$copyright_url = array(null,false);
$copyright_label = array(null,false);
if ( ((isset($copyright[0][(0)][0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $copyright [0][(0)] [0][('attribs')] [0][('')] [0][('url')]))))
 {$copyright_url = $this->sanitize($copyright[0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($copyright[0][(0)][0][('data')]) && Aspis_isset( $copyright [0][(0)] [0][('data')]))))
 {$copyright_label = $this->sanitize($copyright[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}$copyrights_parent = array(new $this->feed[0]->copyright_class[0]($copyright_url,$copyright_label),false);
}if ( deAspis($credits = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('credit',false))))
 {foreach ( $credits[0] as $credit  )
{$credit_role = array(null,false);
$credit_scheme = array(null,false);
$credit_name = array(null,false);
if ( ((isset($credit[0][('attribs')][0][('')][0][('role')]) && Aspis_isset( $credit [0][('attribs')] [0][('')] [0][('role')]))))
 {$credit_role = $this->sanitize($credit[0][('attribs')][0][('')][0]['role'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($credit[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $credit [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$credit_scheme = $this->sanitize($credit[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$credit_scheme = array('urn:ebu',false);
}}if ( ((isset($credit[0][('data')]) && Aspis_isset( $credit [0][('data')]))))
 {$credit_name = $this->sanitize($credit[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($credits_parent[0][],addTaint(array(new $this->feed[0]->credit_class[0]($credit_role,$credit_scheme,$credit_name),false)));
}}elseif ( deAspis($credits = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('credit',false))))
 {foreach ( $credits[0] as $credit  )
{$credit_role = array(null,false);
$credit_scheme = array(null,false);
$credit_name = array(null,false);
if ( ((isset($credit[0][('attribs')][0][('')][0][('role')]) && Aspis_isset( $credit [0][('attribs')] [0][('')] [0][('role')]))))
 {$credit_role = $this->sanitize($credit[0][('attribs')][0][('')][0]['role'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($credit[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $credit [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$credit_scheme = $this->sanitize($credit[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$credit_scheme = array('urn:ebu',false);
}}if ( ((isset($credit[0][('data')]) && Aspis_isset( $credit [0][('data')]))))
 {$credit_name = $this->sanitize($credit[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($credits_parent[0][],addTaint(array(new $this->feed[0]->credit_class[0]($credit_role,$credit_scheme,$credit_name),false)));
}}if ( is_array($credits_parent[0]))
 {$credits_parent = Aspis_array_values(SimplePie_Misc::array_unique($credits_parent));
}if ( deAspis($description_parent = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('description',false))))
 {if ( ((isset($description_parent[0][(0)][0][('data')]) && Aspis_isset( $description_parent [0][(0)] [0][('data')]))))
 {$description_parent = $this->sanitize($description_parent[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}}elseif ( deAspis($description_parent = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('description',false))))
 {if ( ((isset($description_parent[0][(0)][0][('data')]) && Aspis_isset( $description_parent [0][(0)] [0][('data')]))))
 {$description_parent = $this->sanitize($description_parent[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}}if ( deAspis($duration_parent = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('duration',false))))
 {$seconds = array(null,false);
$minutes = array(null,false);
$hours = array(null,false);
if ( ((isset($duration_parent[0][(0)][0][('data')]) && Aspis_isset( $duration_parent [0][(0)] [0][('data')]))))
 {$temp = Aspis_explode(array(':',false),$this->sanitize($duration_parent[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false)));
if ( ((sizeof(deAspisRC($temp))) > (0)))
 {int_cast($seconds = Aspis_array_pop($temp));
}if ( ((sizeof(deAspisRC($temp))) > (0)))
 {int_cast($minutes = Aspis_array_pop($temp));
$seconds = array(($minutes[0] * (60)) + $seconds[0],false);
}if ( ((sizeof(deAspisRC($temp))) > (0)))
 {int_cast($hours = Aspis_array_pop($temp));
$seconds = array(($hours[0] * (3600)) + $seconds[0],false);
}unset($temp);
$duration_parent = $seconds;
}}if ( deAspis($hashes_iterator = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('hash',false))))
 {foreach ( $hashes_iterator[0] as $hash  )
{$value = array(null,false);
$algo = array(null,false);
if ( ((isset($hash[0][('data')]) && Aspis_isset( $hash [0][('data')]))))
 {$value = $this->sanitize($hash[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($hash[0][('attribs')][0][('')][0][('algo')]) && Aspis_isset( $hash [0][('attribs')] [0][('')] [0][('algo')]))))
 {$algo = $this->sanitize($hash[0][('attribs')][0][('')][0]['algo'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$algo = array('md5',false);
}}arrayAssignAdd($hashes_parent[0][],addTaint(concat(concat2($algo,':'),$value)));
}}elseif ( deAspis($hashes_iterator = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('hash',false))))
 {foreach ( $hashes_iterator[0] as $hash  )
{$value = array(null,false);
$algo = array(null,false);
if ( ((isset($hash[0][('data')]) && Aspis_isset( $hash [0][('data')]))))
 {$value = $this->sanitize($hash[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($hash[0][('attribs')][0][('')][0][('algo')]) && Aspis_isset( $hash [0][('attribs')] [0][('')] [0][('algo')]))))
 {$algo = $this->sanitize($hash[0][('attribs')][0][('')][0]['algo'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$algo = array('md5',false);
}}arrayAssignAdd($hashes_parent[0][],addTaint(concat(concat2($algo,':'),$value)));
}}if ( is_array($hashes_parent[0]))
 {$hashes_parent = Aspis_array_values(SimplePie_Misc::array_unique($hashes_parent));
}if ( deAspis($keywords = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('keywords',false))))
 {if ( ((isset($keywords[0][(0)][0][('data')]) && Aspis_isset( $keywords [0][(0)] [0][('data')]))))
 {$temp = Aspis_explode(array(',',false),$this->sanitize($keywords[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false)));
foreach ( $temp[0] as $word  )
{arrayAssignAdd($keywords_parent[0][],addTaint(Aspis_trim($word)));
}}unset($temp);
}elseif ( deAspis($keywords = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('keywords',false))))
 {if ( ((isset($keywords[0][(0)][0][('data')]) && Aspis_isset( $keywords [0][(0)] [0][('data')]))))
 {$temp = Aspis_explode(array(',',false),$this->sanitize($keywords[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false)));
foreach ( $temp[0] as $word  )
{arrayAssignAdd($keywords_parent[0][],addTaint(Aspis_trim($word)));
}}unset($temp);
}elseif ( deAspis($keywords = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('keywords',false))))
 {if ( ((isset($keywords[0][(0)][0][('data')]) && Aspis_isset( $keywords [0][(0)] [0][('data')]))))
 {$temp = Aspis_explode(array(',',false),$this->sanitize($keywords[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false)));
foreach ( $temp[0] as $word  )
{arrayAssignAdd($keywords_parent[0][],addTaint(Aspis_trim($word)));
}}unset($temp);
}elseif ( deAspis($keywords = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('keywords',false))))
 {if ( ((isset($keywords[0][(0)][0][('data')]) && Aspis_isset( $keywords [0][(0)] [0][('data')]))))
 {$temp = Aspis_explode(array(',',false),$this->sanitize($keywords[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false)));
foreach ( $temp[0] as $word  )
{arrayAssignAdd($keywords_parent[0][],addTaint(Aspis_trim($word)));
}}unset($temp);
}if ( is_array($keywords_parent[0]))
 {$keywords_parent = Aspis_array_values(SimplePie_Misc::array_unique($keywords_parent));
}if ( deAspis($player_parent = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('player',false))))
 {if ( ((isset($player_parent[0][(0)][0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $player_parent [0][(0)] [0][('attribs')] [0][('')] [0][('url')]))))
 {$player_parent = $this->sanitize($player_parent[0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false));
}}elseif ( deAspis($player_parent = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('player',false))))
 {if ( ((isset($player_parent[0][(0)][0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $player_parent [0][(0)] [0][('attribs')] [0][('')] [0][('url')]))))
 {$player_parent = $this->sanitize($player_parent[0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false));
}}if ( deAspis($ratings = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('rating',false))))
 {foreach ( $ratings[0] as $rating  )
{$rating_scheme = array(null,false);
$rating_value = array(null,false);
if ( ((isset($rating[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $rating [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$rating_scheme = $this->sanitize($rating[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$rating_scheme = array('urn:simple',false);
}}if ( ((isset($rating[0][('data')]) && Aspis_isset( $rating [0][('data')]))))
 {$rating_value = $this->sanitize($rating[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($ratings_parent[0][],addTaint(array(new $this->feed[0]->rating_class[0]($rating_scheme,$rating_value),false)));
}}elseif ( deAspis($ratings = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('explicit',false))))
 {foreach ( $ratings[0] as $rating  )
{$rating_scheme = array('urn:itunes',false);
$rating_value = array(null,false);
if ( ((isset($rating[0][('data')]) && Aspis_isset( $rating [0][('data')]))))
 {$rating_value = $this->sanitize($rating[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($ratings_parent[0][],addTaint(array(new $this->feed[0]->rating_class[0]($rating_scheme,$rating_value),false)));
}}elseif ( deAspis($ratings = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('rating',false))))
 {foreach ( $ratings[0] as $rating  )
{$rating_scheme = array(null,false);
$rating_value = array(null,false);
if ( ((isset($rating[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $rating [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$rating_scheme = $this->sanitize($rating[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$rating_scheme = array('urn:simple',false);
}}if ( ((isset($rating[0][('data')]) && Aspis_isset( $rating [0][('data')]))))
 {$rating_value = $this->sanitize($rating[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($ratings_parent[0][],addTaint(array(new $this->feed[0]->rating_class[0]($rating_scheme,$rating_value),false)));
}}elseif ( deAspis($ratings = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('explicit',false))))
 {foreach ( $ratings[0] as $rating  )
{$rating_scheme = array('urn:itunes',false);
$rating_value = array(null,false);
if ( ((isset($rating[0][('data')]) && Aspis_isset( $rating [0][('data')]))))
 {$rating_value = $this->sanitize($rating[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($ratings_parent[0][],addTaint(array(new $this->feed[0]->rating_class[0]($rating_scheme,$rating_value),false)));
}}if ( is_array($ratings_parent[0]))
 {$ratings_parent = Aspis_array_values(SimplePie_Misc::array_unique($ratings_parent));
}if ( deAspis($restrictions = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('restriction',false))))
 {foreach ( $restrictions[0] as $restriction  )
{$restriction_relationship = array(null,false);
$restriction_type = array(null,false);
$restriction_value = array(null,false);
if ( ((isset($restriction[0][('attribs')][0][('')][0][('relationship')]) && Aspis_isset( $restriction [0][('attribs')] [0][('')] [0][('relationship')]))))
 {$restriction_relationship = $this->sanitize($restriction[0][('attribs')][0][('')][0]['relationship'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($restriction[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $restriction [0][('attribs')] [0][('')] [0][('type')]))))
 {$restriction_type = $this->sanitize($restriction[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($restriction[0][('data')]) && Aspis_isset( $restriction [0][('data')]))))
 {$restriction_value = $this->sanitize($restriction[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($restrictions_parent[0][],addTaint(array(new $this->feed[0]->restriction_class[0]($restriction_relationship,$restriction_type,$restriction_value),false)));
}}elseif ( deAspis($restrictions = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('block',false))))
 {foreach ( $restrictions[0] as $restriction  )
{$restriction_relationship = array('allow',false);
$restriction_type = array(null,false);
$restriction_value = array('itunes',false);
if ( (((isset($restriction[0][('data')]) && Aspis_isset( $restriction [0][('data')]))) && (deAspis(Aspis_strtolower($restriction[0]['data'])) === ('yes'))))
 {$restriction_relationship = array('deny',false);
}arrayAssignAdd($restrictions_parent[0][],addTaint(array(new $this->feed[0]->restriction_class[0]($restriction_relationship,$restriction_type,$restriction_value),false)));
}}elseif ( deAspis($restrictions = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('restriction',false))))
 {foreach ( $restrictions[0] as $restriction  )
{$restriction_relationship = array(null,false);
$restriction_type = array(null,false);
$restriction_value = array(null,false);
if ( ((isset($restriction[0][('attribs')][0][('')][0][('relationship')]) && Aspis_isset( $restriction [0][('attribs')] [0][('')] [0][('relationship')]))))
 {$restriction_relationship = $this->sanitize($restriction[0][('attribs')][0][('')][0]['relationship'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($restriction[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $restriction [0][('attribs')] [0][('')] [0][('type')]))))
 {$restriction_type = $this->sanitize($restriction[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($restriction[0][('data')]) && Aspis_isset( $restriction [0][('data')]))))
 {$restriction_value = $this->sanitize($restriction[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($restrictions_parent[0][],addTaint(array(new $this->feed[0]->restriction_class[0]($restriction_relationship,$restriction_type,$restriction_value),false)));
}}elseif ( deAspis($restrictions = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('block',false))))
 {foreach ( $restrictions[0] as $restriction  )
{$restriction_relationship = array('allow',false);
$restriction_type = array(null,false);
$restriction_value = array('itunes',false);
if ( (((isset($restriction[0][('data')]) && Aspis_isset( $restriction [0][('data')]))) && (deAspis(Aspis_strtolower($restriction[0]['data'])) === ('yes'))))
 {$restriction_relationship = array('deny',false);
}arrayAssignAdd($restrictions_parent[0][],addTaint(array(new $this->feed[0]->restriction_class[0]($restriction_relationship,$restriction_type,$restriction_value),false)));
}}if ( is_array($restrictions_parent[0]))
 {$restrictions_parent = Aspis_array_values(SimplePie_Misc::array_unique($restrictions_parent));
}if ( deAspis($thumbnails = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('thumbnail',false))))
 {foreach ( $thumbnails[0] as $thumbnail  )
{if ( ((isset($thumbnail[0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $thumbnail [0][('attribs')] [0][('')] [0][('url')]))))
 {arrayAssignAdd($thumbnails_parent[0][],addTaint($this->sanitize($thumbnail[0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false))));
}}}elseif ( deAspis($thumbnails = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('thumbnail',false))))
 {foreach ( $thumbnails[0] as $thumbnail  )
{if ( ((isset($thumbnail[0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $thumbnail [0][('attribs')] [0][('')] [0][('url')]))))
 {arrayAssignAdd($thumbnails_parent[0][],addTaint($this->sanitize($thumbnail[0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false))));
}}}if ( deAspis($title_parent = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('title',false))))
 {if ( ((isset($title_parent[0][(0)][0][('data')]) && Aspis_isset( $title_parent [0][(0)] [0][('data')]))))
 {$title_parent = $this->sanitize($title_parent[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}}elseif ( deAspis($title_parent = $parent[0]->get_channel_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('title',false))))
 {if ( ((isset($title_parent[0][(0)][0][('data')]) && Aspis_isset( $title_parent [0][(0)] [0][('data')]))))
 {$title_parent = $this->sanitize($title_parent[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}}unset($parent);
$bitrate = array(null,false);
$channels = array(null,false);
$duration = array(null,false);
$expression = array(null,false);
$framerate = array(null,false);
$height = array(null,false);
$javascript = array(null,false);
$lang = array(null,false);
$length = array(null,false);
$medium = array(null,false);
$samplingrate = array(null,false);
$type = array(null,false);
$url = array(null,false);
$width = array(null,false);
$captions = array(null,false);
$categories = array(null,false);
$copyrights = array(null,false);
$credits = array(null,false);
$description = array(null,false);
$hashes = array(null,false);
$keywords = array(null,false);
$player = array(null,false);
$ratings = array(null,false);
$restrictions = array(null,false);
$thumbnails = array(null,false);
$title = array(null,false);
foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_MEDIARSS,false),array('group',false)))) as $group  )
{foreach ( deAspis(array_cast($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['content'])) as $content  )
{if ( ((isset($content[0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('url')]))))
 {$bitrate = array(null,false);
$channels = array(null,false);
$duration = array(null,false);
$expression = array(null,false);
$framerate = array(null,false);
$height = array(null,false);
$javascript = array(null,false);
$lang = array(null,false);
$length = array(null,false);
$medium = array(null,false);
$samplingrate = array(null,false);
$type = array(null,false);
$url = array(null,false);
$width = array(null,false);
$captions = array(null,false);
$categories = array(null,false);
$copyrights = array(null,false);
$credits = array(null,false);
$description = array(null,false);
$hashes = array(null,false);
$keywords = array(null,false);
$player = array(null,false);
$ratings = array(null,false);
$restrictions = array(null,false);
$thumbnails = array(null,false);
$title = array(null,false);
if ( ((isset($content[0][('attribs')][0][('')][0][('bitrate')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('bitrate')]))))
 {$bitrate = $this->sanitize($content[0][('attribs')][0][('')][0]['bitrate'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('channels')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('channels')]))))
 {$channels = $this->sanitize($content[0][('attribs')][0][('')][0]['channels'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('duration')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('duration')]))))
 {$duration = $this->sanitize($content[0][('attribs')][0][('')][0]['duration'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$duration = $duration_parent;
}}if ( ((isset($content[0][('attribs')][0][('')][0][('expression')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('expression')]))))
 {$expression = $this->sanitize($content[0][('attribs')][0][('')][0]['expression'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('framerate')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('framerate')]))))
 {$framerate = $this->sanitize($content[0][('attribs')][0][('')][0]['framerate'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('height')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('height')]))))
 {$height = $this->sanitize($content[0][('attribs')][0][('')][0]['height'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('lang')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('lang')]))))
 {$lang = $this->sanitize($content[0][('attribs')][0][('')][0]['lang'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('fileSize')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('fileSize')]))))
 {$length = attAspis(ceil(deAspis($content[0][('attribs')][0][('')][0]['fileSize'])));
}if ( ((isset($content[0][('attribs')][0][('')][0][('medium')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('medium')]))))
 {$medium = $this->sanitize($content[0][('attribs')][0][('')][0]['medium'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('samplingrate')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('samplingrate')]))))
 {$samplingrate = $this->sanitize($content[0][('attribs')][0][('')][0]['samplingrate'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('type')]))))
 {$type = $this->sanitize($content[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('width')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('width')]))))
 {$width = $this->sanitize($content[0][('attribs')][0][('')][0]['width'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}$url = $this->sanitize($content[0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false));
if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('text')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('text')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['text']) as $caption  )
{$caption_type = array(null,false);
$caption_lang = array(null,false);
$caption_startTime = array(null,false);
$caption_endTime = array(null,false);
$caption_text = array(null,false);
if ( ((isset($caption[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('type')]))))
 {$caption_type = $this->sanitize($caption[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('lang')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('lang')]))))
 {$caption_lang = $this->sanitize($caption[0][('attribs')][0][('')][0]['lang'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('start')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('start')]))))
 {$caption_startTime = $this->sanitize($caption[0][('attribs')][0][('')][0]['start'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('end')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('end')]))))
 {$caption_endTime = $this->sanitize($caption[0][('attribs')][0][('')][0]['end'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('data')]) && Aspis_isset( $caption [0][('data')]))))
 {$caption_text = $this->sanitize($caption[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($captions[0][],addTaint(array(new $this->feed[0]->caption_class[0]($caption_type,$caption_lang,$caption_startTime,$caption_endTime,$caption_text),false)));
}if ( is_array($captions[0]))
 {$captions = Aspis_array_values(SimplePie_Misc::array_unique($captions));
}}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('text')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('text')]))))
 {foreach ( deAspis($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['text']) as $caption  )
{$caption_type = array(null,false);
$caption_lang = array(null,false);
$caption_startTime = array(null,false);
$caption_endTime = array(null,false);
$caption_text = array(null,false);
if ( ((isset($caption[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('type')]))))
 {$caption_type = $this->sanitize($caption[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('lang')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('lang')]))))
 {$caption_lang = $this->sanitize($caption[0][('attribs')][0][('')][0]['lang'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('start')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('start')]))))
 {$caption_startTime = $this->sanitize($caption[0][('attribs')][0][('')][0]['start'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('end')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('end')]))))
 {$caption_endTime = $this->sanitize($caption[0][('attribs')][0][('')][0]['end'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('data')]) && Aspis_isset( $caption [0][('data')]))))
 {$caption_text = $this->sanitize($caption[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($captions[0][],addTaint(array(new $this->feed[0]->caption_class[0]($caption_type,$caption_lang,$caption_startTime,$caption_endTime,$caption_text),false)));
}if ( is_array($captions[0]))
 {$captions = Aspis_array_values(SimplePie_Misc::array_unique($captions));
}}else 
{{$captions = $captions_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('category')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('category')]))))
 {foreach ( deAspis(array_cast($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['category'])) as $category  )
{$term = array(null,false);
$scheme = array(null,false);
$label = array(null,false);
if ( ((isset($category[0][('data')]) && Aspis_isset( $category [0][('data')]))))
 {$term = $this->sanitize($category[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$scheme = array('http://search.yahoo.com/mrss/category_schema',false);
}}if ( ((isset($category[0][('attribs')][0][('')][0][('label')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('label')]))))
 {$label = $this->sanitize($category[0][('attribs')][0][('')][0]['label'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($categories[0][],addTaint(array(new $this->feed[0]->category_class[0]($term,$scheme,$label),false)));
}}if ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('category')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('category')]))))
 {foreach ( deAspis(array_cast($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['category'])) as $category  )
{$term = array(null,false);
$scheme = array(null,false);
$label = array(null,false);
if ( ((isset($category[0][('data')]) && Aspis_isset( $category [0][('data')]))))
 {$term = $this->sanitize($category[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$scheme = array('http://search.yahoo.com/mrss/category_schema',false);
}}if ( ((isset($category[0][('attribs')][0][('')][0][('label')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('label')]))))
 {$label = $this->sanitize($category[0][('attribs')][0][('')][0]['label'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($categories[0][],addTaint(array(new $this->feed[0]->category_class[0]($term,$scheme,$label),false)));
}}if ( (is_array($categories[0]) && is_array($categories_parent[0])))
 {$categories = Aspis_array_values(SimplePie_Misc::array_unique(Aspis_array_merge($categories,$categories_parent)));
}elseif ( is_array($categories[0]))
 {$categories = Aspis_array_values(SimplePie_Misc::array_unique($categories));
}elseif ( is_array($categories_parent[0]))
 {$categories = Aspis_array_values(SimplePie_Misc::array_unique($categories_parent));
}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('copyright')]))))
 {$copyright_url = array(null,false);
$copyright_label = array(null,false);
if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('copyright')] [0][(0)] [0][('attribs')] [0][('')] [0][('url')]))))
 {$copyright_url = $this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0][('data')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('copyright')] [0][(0)] [0][('data')]))))
 {$copyright_label = $this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}$copyrights = array(new $this->feed[0]->copyright_class[0]($copyright_url,$copyright_label),false);
}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('copyright')]))))
 {$copyright_url = array(null,false);
$copyright_label = array(null,false);
if ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('copyright')] [0][(0)] [0][('attribs')] [0][('')] [0][('url')]))))
 {$copyright_url = $this->sanitize($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0][('data')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('copyright')] [0][(0)] [0][('data')]))))
 {$copyright_label = $this->sanitize($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}$copyrights = array(new $this->feed[0]->copyright_class[0]($copyright_url,$copyright_label),false);
}else 
{{$copyrights = $copyrights_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('credit')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('credit')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['credit']) as $credit  )
{$credit_role = array(null,false);
$credit_scheme = array(null,false);
$credit_name = array(null,false);
if ( ((isset($credit[0][('attribs')][0][('')][0][('role')]) && Aspis_isset( $credit [0][('attribs')] [0][('')] [0][('role')]))))
 {$credit_role = $this->sanitize($credit[0][('attribs')][0][('')][0]['role'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($credit[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $credit [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$credit_scheme = $this->sanitize($credit[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$credit_scheme = array('urn:ebu',false);
}}if ( ((isset($credit[0][('data')]) && Aspis_isset( $credit [0][('data')]))))
 {$credit_name = $this->sanitize($credit[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($credits[0][],addTaint(array(new $this->feed[0]->credit_class[0]($credit_role,$credit_scheme,$credit_name),false)));
}if ( is_array($credits[0]))
 {$credits = Aspis_array_values(SimplePie_Misc::array_unique($credits));
}}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('credit')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('credit')]))))
 {foreach ( deAspis($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['credit']) as $credit  )
{$credit_role = array(null,false);
$credit_scheme = array(null,false);
$credit_name = array(null,false);
if ( ((isset($credit[0][('attribs')][0][('')][0][('role')]) && Aspis_isset( $credit [0][('attribs')] [0][('')] [0][('role')]))))
 {$credit_role = $this->sanitize($credit[0][('attribs')][0][('')][0]['role'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($credit[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $credit [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$credit_scheme = $this->sanitize($credit[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$credit_scheme = array('urn:ebu',false);
}}if ( ((isset($credit[0][('data')]) && Aspis_isset( $credit [0][('data')]))))
 {$credit_name = $this->sanitize($credit[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($credits[0][],addTaint(array(new $this->feed[0]->credit_class[0]($credit_role,$credit_scheme,$credit_name),false)));
}if ( is_array($credits[0]))
 {$credits = Aspis_array_values(SimplePie_Misc::array_unique($credits));
}}else 
{{$credits = $credits_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('description')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('description')]))))
 {$description = $this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('description')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('description')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('description')]))))
 {$description = $this->sanitize($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('description')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$description = $description_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('hash')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('hash')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['hash']) as $hash  )
{$value = array(null,false);
$algo = array(null,false);
if ( ((isset($hash[0][('data')]) && Aspis_isset( $hash [0][('data')]))))
 {$value = $this->sanitize($hash[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($hash[0][('attribs')][0][('')][0][('algo')]) && Aspis_isset( $hash [0][('attribs')] [0][('')] [0][('algo')]))))
 {$algo = $this->sanitize($hash[0][('attribs')][0][('')][0]['algo'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$algo = array('md5',false);
}}arrayAssignAdd($hashes[0][],addTaint(concat(concat2($algo,':'),$value)));
}if ( is_array($hashes[0]))
 {$hashes = Aspis_array_values(SimplePie_Misc::array_unique($hashes));
}}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('hash')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('hash')]))))
 {foreach ( deAspis($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['hash']) as $hash  )
{$value = array(null,false);
$algo = array(null,false);
if ( ((isset($hash[0][('data')]) && Aspis_isset( $hash [0][('data')]))))
 {$value = $this->sanitize($hash[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($hash[0][('attribs')][0][('')][0][('algo')]) && Aspis_isset( $hash [0][('attribs')] [0][('')] [0][('algo')]))))
 {$algo = $this->sanitize($hash[0][('attribs')][0][('')][0]['algo'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$algo = array('md5',false);
}}arrayAssignAdd($hashes[0][],addTaint(concat(concat2($algo,':'),$value)));
}if ( is_array($hashes[0]))
 {$hashes = Aspis_array_values(SimplePie_Misc::array_unique($hashes));
}}else 
{{$hashes = $hashes_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('keywords')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('keywords')]))))
 {if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('keywords')][0][(0)][0][('data')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('keywords')] [0][(0)] [0][('data')]))))
 {$temp = Aspis_explode(array(',',false),$this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('keywords')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false)));
foreach ( $temp[0] as $word  )
{arrayAssignAdd($keywords[0][],addTaint(Aspis_trim($word)));
}unset($temp);
}if ( is_array($keywords[0]))
 {$keywords = Aspis_array_values(SimplePie_Misc::array_unique($keywords));
}}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('keywords')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('keywords')]))))
 {if ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('keywords')][0][(0)][0][('data')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('keywords')] [0][(0)] [0][('data')]))))
 {$temp = Aspis_explode(array(',',false),$this->sanitize($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('keywords')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false)));
foreach ( $temp[0] as $word  )
{arrayAssignAdd($keywords[0][],addTaint(Aspis_trim($word)));
}unset($temp);
}if ( is_array($keywords[0]))
 {$keywords = Aspis_array_values(SimplePie_Misc::array_unique($keywords));
}}else 
{{$keywords = $keywords_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('player')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('player')]))))
 {$player = $this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('player')][0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false));
}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('player')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('player')]))))
 {$player = $this->sanitize($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('player')][0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{$player = $player_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('rating')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('rating')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['rating']) as $rating  )
{$rating_scheme = array(null,false);
$rating_value = array(null,false);
if ( ((isset($rating[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $rating [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$rating_scheme = $this->sanitize($rating[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$rating_scheme = array('urn:simple',false);
}}if ( ((isset($rating[0][('data')]) && Aspis_isset( $rating [0][('data')]))))
 {$rating_value = $this->sanitize($rating[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($ratings[0][],addTaint(array(new $this->feed[0]->rating_class[0]($rating_scheme,$rating_value),false)));
}if ( is_array($ratings[0]))
 {$ratings = Aspis_array_values(SimplePie_Misc::array_unique($ratings));
}}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('rating')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('rating')]))))
 {foreach ( deAspis($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['rating']) as $rating  )
{$rating_scheme = array(null,false);
$rating_value = array(null,false);
if ( ((isset($rating[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $rating [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$rating_scheme = $this->sanitize($rating[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$rating_scheme = array('urn:simple',false);
}}if ( ((isset($rating[0][('data')]) && Aspis_isset( $rating [0][('data')]))))
 {$rating_value = $this->sanitize($rating[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($ratings[0][],addTaint(array(new $this->feed[0]->rating_class[0]($rating_scheme,$rating_value),false)));
}if ( is_array($ratings[0]))
 {$ratings = Aspis_array_values(SimplePie_Misc::array_unique($ratings));
}}else 
{{$ratings = $ratings_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('restriction')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('restriction')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['restriction']) as $restriction  )
{$restriction_relationship = array(null,false);
$restriction_type = array(null,false);
$restriction_value = array(null,false);
if ( ((isset($restriction[0][('attribs')][0][('')][0][('relationship')]) && Aspis_isset( $restriction [0][('attribs')] [0][('')] [0][('relationship')]))))
 {$restriction_relationship = $this->sanitize($restriction[0][('attribs')][0][('')][0]['relationship'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($restriction[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $restriction [0][('attribs')] [0][('')] [0][('type')]))))
 {$restriction_type = $this->sanitize($restriction[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($restriction[0][('data')]) && Aspis_isset( $restriction [0][('data')]))))
 {$restriction_value = $this->sanitize($restriction[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($restrictions[0][],addTaint(array(new $this->feed[0]->restriction_class[0]($restriction_relationship,$restriction_type,$restriction_value),false)));
}if ( is_array($restrictions[0]))
 {$restrictions = Aspis_array_values(SimplePie_Misc::array_unique($restrictions));
}}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('restriction')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('restriction')]))))
 {foreach ( deAspis($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['restriction']) as $restriction  )
{$restriction_relationship = array(null,false);
$restriction_type = array(null,false);
$restriction_value = array(null,false);
if ( ((isset($restriction[0][('attribs')][0][('')][0][('relationship')]) && Aspis_isset( $restriction [0][('attribs')] [0][('')] [0][('relationship')]))))
 {$restriction_relationship = $this->sanitize($restriction[0][('attribs')][0][('')][0]['relationship'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($restriction[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $restriction [0][('attribs')] [0][('')] [0][('type')]))))
 {$restriction_type = $this->sanitize($restriction[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($restriction[0][('data')]) && Aspis_isset( $restriction [0][('data')]))))
 {$restriction_value = $this->sanitize($restriction[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($restrictions[0][],addTaint(array(new $this->feed[0]->restriction_class[0]($restriction_relationship,$restriction_type,$restriction_value),false)));
}if ( is_array($restrictions[0]))
 {$restrictions = Aspis_array_values(SimplePie_Misc::array_unique($restrictions));
}}else 
{{$restrictions = $restrictions_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('thumbnail')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('thumbnail')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['thumbnail']) as $thumbnail  )
{arrayAssignAdd($thumbnails[0][],addTaint($this->sanitize($thumbnail[0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false))));
}if ( is_array($thumbnails[0]))
 {$thumbnails = Aspis_array_values(SimplePie_Misc::array_unique($thumbnails));
}}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('thumbnail')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('thumbnail')]))))
 {foreach ( deAspis($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['thumbnail']) as $thumbnail  )
{arrayAssignAdd($thumbnails[0][],addTaint($this->sanitize($thumbnail[0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false))));
}if ( is_array($thumbnails[0]))
 {$thumbnails = Aspis_array_values(SimplePie_Misc::array_unique($thumbnails));
}}else 
{{$thumbnails = $thumbnails_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('title')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('title')]))))
 {$title = $this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('title')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( ((isset($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('title')]) && Aspis_isset( $group [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('title')]))))
 {$title = $this->sanitize($group[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('title')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$title = $title_parent;
}}arrayAssignAdd($this->data[0][('enclosures')][0][],addTaint(array(new $this->feed[0]->enclosure_class[0]($url,$type,$length,$this->feed[0]->javascript,$bitrate,$captions,$categories,$channels,$copyrights,$credits,$description,$duration,$expression,$framerate,$hashes,$height,$keywords,$lang,$medium,$player,$ratings,$restrictions,$samplingrate,$thumbnails,$title,$width),false)));
}}}if ( ((isset($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('content')]) && Aspis_isset( $this ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('content')] ))))
 {foreach ( deAspis(array_cast($this->data[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('content')])) as $content  )
{if ( ((isset($content[0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('url')]))))
 {$bitrate = array(null,false);
$channels = array(null,false);
$duration = array(null,false);
$expression = array(null,false);
$framerate = array(null,false);
$height = array(null,false);
$javascript = array(null,false);
$lang = array(null,false);
$length = array(null,false);
$medium = array(null,false);
$samplingrate = array(null,false);
$type = array(null,false);
$url = array(null,false);
$width = array(null,false);
$captions = array(null,false);
$categories = array(null,false);
$copyrights = array(null,false);
$credits = array(null,false);
$description = array(null,false);
$hashes = array(null,false);
$keywords = array(null,false);
$player = array(null,false);
$ratings = array(null,false);
$restrictions = array(null,false);
$thumbnails = array(null,false);
$title = array(null,false);
if ( ((isset($content[0][('attribs')][0][('')][0][('bitrate')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('bitrate')]))))
 {$bitrate = $this->sanitize($content[0][('attribs')][0][('')][0]['bitrate'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('channels')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('channels')]))))
 {$channels = $this->sanitize($content[0][('attribs')][0][('')][0]['channels'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('duration')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('duration')]))))
 {$duration = $this->sanitize($content[0][('attribs')][0][('')][0]['duration'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$duration = $duration_parent;
}}if ( ((isset($content[0][('attribs')][0][('')][0][('expression')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('expression')]))))
 {$expression = $this->sanitize($content[0][('attribs')][0][('')][0]['expression'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('framerate')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('framerate')]))))
 {$framerate = $this->sanitize($content[0][('attribs')][0][('')][0]['framerate'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('height')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('height')]))))
 {$height = $this->sanitize($content[0][('attribs')][0][('')][0]['height'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('lang')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('lang')]))))
 {$lang = $this->sanitize($content[0][('attribs')][0][('')][0]['lang'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('fileSize')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('fileSize')]))))
 {$length = attAspis(ceil(deAspis($content[0][('attribs')][0][('')][0]['fileSize'])));
}if ( ((isset($content[0][('attribs')][0][('')][0][('medium')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('medium')]))))
 {$medium = $this->sanitize($content[0][('attribs')][0][('')][0]['medium'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('samplingrate')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('samplingrate')]))))
 {$samplingrate = $this->sanitize($content[0][('attribs')][0][('')][0]['samplingrate'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('type')]))))
 {$type = $this->sanitize($content[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('attribs')][0][('')][0][('width')]) && Aspis_isset( $content [0][('attribs')] [0][('')] [0][('width')]))))
 {$width = $this->sanitize($content[0][('attribs')][0][('')][0]['width'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}$url = $this->sanitize($content[0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false));
if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('text')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('text')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['text']) as $caption  )
{$caption_type = array(null,false);
$caption_lang = array(null,false);
$caption_startTime = array(null,false);
$caption_endTime = array(null,false);
$caption_text = array(null,false);
if ( ((isset($caption[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('type')]))))
 {$caption_type = $this->sanitize($caption[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('lang')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('lang')]))))
 {$caption_lang = $this->sanitize($caption[0][('attribs')][0][('')][0]['lang'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('start')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('start')]))))
 {$caption_startTime = $this->sanitize($caption[0][('attribs')][0][('')][0]['start'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('attribs')][0][('')][0][('end')]) && Aspis_isset( $caption [0][('attribs')] [0][('')] [0][('end')]))))
 {$caption_endTime = $this->sanitize($caption[0][('attribs')][0][('')][0]['end'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($caption[0][('data')]) && Aspis_isset( $caption [0][('data')]))))
 {$caption_text = $this->sanitize($caption[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($captions[0][],addTaint(array(new $this->feed[0]->caption_class[0]($caption_type,$caption_lang,$caption_startTime,$caption_endTime,$caption_text),false)));
}if ( is_array($captions[0]))
 {$captions = Aspis_array_values(SimplePie_Misc::array_unique($captions));
}}else 
{{$captions = $captions_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('category')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('category')]))))
 {foreach ( deAspis(array_cast($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['category'])) as $category  )
{$term = array(null,false);
$scheme = array(null,false);
$label = array(null,false);
if ( ((isset($category[0][('data')]) && Aspis_isset( $category [0][('data')]))))
 {$term = $this->sanitize($category[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$scheme = array('http://search.yahoo.com/mrss/category_schema',false);
}}if ( ((isset($category[0][('attribs')][0][('')][0][('label')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('label')]))))
 {$label = $this->sanitize($category[0][('attribs')][0][('')][0]['label'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($categories[0][],addTaint(array(new $this->feed[0]->category_class[0]($term,$scheme,$label),false)));
}}if ( (is_array($categories[0]) && is_array($categories_parent[0])))
 {$categories = Aspis_array_values(SimplePie_Misc::array_unique(Aspis_array_merge($categories,$categories_parent)));
}elseif ( is_array($categories[0]))
 {$categories = Aspis_array_values(SimplePie_Misc::array_unique($categories));
}elseif ( is_array($categories_parent[0]))
 {$categories = Aspis_array_values(SimplePie_Misc::array_unique($categories_parent));
}else 
{{$categories = array(null,false);
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('copyright')]))))
 {$copyright_url = array(null,false);
$copyright_label = array(null,false);
if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('copyright')] [0][(0)] [0][('attribs')] [0][('')] [0][('url')]))))
 {$copyright_url = $this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0][('data')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('copyright')] [0][(0)] [0][('data')]))))
 {$copyright_label = $this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('copyright')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}$copyrights = array(new $this->feed[0]->copyright_class[0]($copyright_url,$copyright_label),false);
}else 
{{$copyrights = $copyrights_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('credit')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('credit')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['credit']) as $credit  )
{$credit_role = array(null,false);
$credit_scheme = array(null,false);
$credit_name = array(null,false);
if ( ((isset($credit[0][('attribs')][0][('')][0][('role')]) && Aspis_isset( $credit [0][('attribs')] [0][('')] [0][('role')]))))
 {$credit_role = $this->sanitize($credit[0][('attribs')][0][('')][0]['role'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($credit[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $credit [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$credit_scheme = $this->sanitize($credit[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$credit_scheme = array('urn:ebu',false);
}}if ( ((isset($credit[0][('data')]) && Aspis_isset( $credit [0][('data')]))))
 {$credit_name = $this->sanitize($credit[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($credits[0][],addTaint(array(new $this->feed[0]->credit_class[0]($credit_role,$credit_scheme,$credit_name),false)));
}if ( is_array($credits[0]))
 {$credits = Aspis_array_values(SimplePie_Misc::array_unique($credits));
}}else 
{{$credits = $credits_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('description')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('description')]))))
 {$description = $this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('description')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$description = $description_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('hash')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('hash')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['hash']) as $hash  )
{$value = array(null,false);
$algo = array(null,false);
if ( ((isset($hash[0][('data')]) && Aspis_isset( $hash [0][('data')]))))
 {$value = $this->sanitize($hash[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($hash[0][('attribs')][0][('')][0][('algo')]) && Aspis_isset( $hash [0][('attribs')] [0][('')] [0][('algo')]))))
 {$algo = $this->sanitize($hash[0][('attribs')][0][('')][0]['algo'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$algo = array('md5',false);
}}arrayAssignAdd($hashes[0][],addTaint(concat(concat2($algo,':'),$value)));
}if ( is_array($hashes[0]))
 {$hashes = Aspis_array_values(SimplePie_Misc::array_unique($hashes));
}}else 
{{$hashes = $hashes_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('keywords')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('keywords')]))))
 {if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('keywords')][0][(0)][0][('data')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('keywords')] [0][(0)] [0][('data')]))))
 {$temp = Aspis_explode(array(',',false),$this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('keywords')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false)));
foreach ( $temp[0] as $word  )
{arrayAssignAdd($keywords[0][],addTaint(Aspis_trim($word)));
}unset($temp);
}if ( is_array($keywords[0]))
 {$keywords = Aspis_array_values(SimplePie_Misc::array_unique($keywords));
}}else 
{{$keywords = $keywords_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('player')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('player')]))))
 {$player = $this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('player')][0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{$player = $player_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('rating')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('rating')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['rating']) as $rating  )
{$rating_scheme = array(null,false);
$rating_value = array(null,false);
if ( ((isset($rating[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $rating [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$rating_scheme = $this->sanitize($rating[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$rating_scheme = array('urn:simple',false);
}}if ( ((isset($rating[0][('data')]) && Aspis_isset( $rating [0][('data')]))))
 {$rating_value = $this->sanitize($rating[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($ratings[0][],addTaint(array(new $this->feed[0]->rating_class[0]($rating_scheme,$rating_value),false)));
}if ( is_array($ratings[0]))
 {$ratings = Aspis_array_values(SimplePie_Misc::array_unique($ratings));
}}else 
{{$ratings = $ratings_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('restriction')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('restriction')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['restriction']) as $restriction  )
{$restriction_relationship = array(null,false);
$restriction_type = array(null,false);
$restriction_value = array(null,false);
if ( ((isset($restriction[0][('attribs')][0][('')][0][('relationship')]) && Aspis_isset( $restriction [0][('attribs')] [0][('')] [0][('relationship')]))))
 {$restriction_relationship = $this->sanitize($restriction[0][('attribs')][0][('')][0]['relationship'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($restriction[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $restriction [0][('attribs')] [0][('')] [0][('type')]))))
 {$restriction_type = $this->sanitize($restriction[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($restriction[0][('data')]) && Aspis_isset( $restriction [0][('data')]))))
 {$restriction_value = $this->sanitize($restriction[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($restrictions[0][],addTaint(array(new $this->feed[0]->restriction_class[0]($restriction_relationship,$restriction_type,$restriction_value),false)));
}if ( is_array($restrictions[0]))
 {$restrictions = Aspis_array_values(SimplePie_Misc::array_unique($restrictions));
}}else 
{{$restrictions = $restrictions_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('thumbnail')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('thumbnail')]))))
 {foreach ( deAspis($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0]['thumbnail']) as $thumbnail  )
{arrayAssignAdd($thumbnails[0][],addTaint($this->sanitize($thumbnail[0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false))));
}if ( is_array($thumbnails[0]))
 {$thumbnails = Aspis_array_values(SimplePie_Misc::array_unique($thumbnails));
}}else 
{{$thumbnails = $thumbnails_parent;
}}if ( ((isset($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('title')]) && Aspis_isset( $content [0][('child')] [0][SIMPLEPIE_NAMESPACE_MEDIARSS] [0][('title')]))))
 {$title = $this->sanitize($content[0][('child')][0][SIMPLEPIE_NAMESPACE_MEDIARSS][0][('title')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$title = $title_parent;
}}arrayAssignAdd($this->data[0][('enclosures')][0][],addTaint(array(new $this->feed[0]->enclosure_class[0]($url,$type,$length,$this->feed[0]->javascript,$bitrate,$captions,$categories,$channels,$copyrights,$credits,$description,$duration,$expression,$framerate,$hashes,$height,$keywords,$lang,$medium,$player,$ratings,$restrictions,$samplingrate,$thumbnails,$title,$width),false)));
}}}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('link',false)))) as $link  )
{if ( ((((isset($link[0][('attribs')][0][('')][0][('href')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('href')]))) && (!((empty($link[0][('attribs')][0][('')][0][('rel')]) || Aspis_empty( $link [0][('attribs')] [0][('')] [0][('rel')]))))) && (deAspis($link[0][('attribs')][0][('')][0]['rel']) === ('enclosure'))))
 {$bitrate = array(null,false);
$channels = array(null,false);
$duration = array(null,false);
$expression = array(null,false);
$framerate = array(null,false);
$height = array(null,false);
$javascript = array(null,false);
$lang = array(null,false);
$length = array(null,false);
$medium = array(null,false);
$samplingrate = array(null,false);
$type = array(null,false);
$url = array(null,false);
$width = array(null,false);
$url = $this->sanitize($link[0][('attribs')][0][('')][0]['href'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base($link));
if ( ((isset($link[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('type')]))))
 {$type = $this->sanitize($link[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($link[0][('attribs')][0][('')][0][('length')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('length')]))))
 {$length = attAspis(ceil(deAspis($link[0][('attribs')][0][('')][0]['length'])));
}arrayAssignAdd($this->data[0][('enclosures')][0][],addTaint(array(new $this->feed[0]->enclosure_class[0]($url,$type,$length,$this->feed[0]->javascript,$bitrate,$captions_parent,$categories_parent,$channels,$copyrights_parent,$credits_parent,$description_parent,$duration_parent,$expression,$framerate,$hashes_parent,$height,$keywords_parent,$lang,$medium,$player_parent,$ratings_parent,$restrictions_parent,$samplingrate,$thumbnails_parent,$title_parent,$width),false)));
}}foreach ( deAspis(array_cast($this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('link',false)))) as $link  )
{if ( ((((isset($link[0][('attribs')][0][('')][0][('href')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('href')]))) && (!((empty($link[0][('attribs')][0][('')][0][('rel')]) || Aspis_empty( $link [0][('attribs')] [0][('')] [0][('rel')]))))) && (deAspis($link[0][('attribs')][0][('')][0]['rel']) === ('enclosure'))))
 {$bitrate = array(null,false);
$channels = array(null,false);
$duration = array(null,false);
$expression = array(null,false);
$framerate = array(null,false);
$height = array(null,false);
$javascript = array(null,false);
$lang = array(null,false);
$length = array(null,false);
$medium = array(null,false);
$samplingrate = array(null,false);
$type = array(null,false);
$url = array(null,false);
$width = array(null,false);
$url = $this->sanitize($link[0][('attribs')][0][('')][0]['href'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base($link));
if ( ((isset($link[0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('type')]))))
 {$type = $this->sanitize($link[0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($link[0][('attribs')][0][('')][0][('length')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('length')]))))
 {$length = attAspis(ceil(deAspis($link[0][('attribs')][0][('')][0]['length'])));
}arrayAssignAdd($this->data[0][('enclosures')][0][],addTaint(array(new $this->feed[0]->enclosure_class[0]($url,$type,$length,$this->feed[0]->javascript,$bitrate,$captions_parent,$categories_parent,$channels,$copyrights_parent,$credits_parent,$description_parent,$duration_parent,$expression,$framerate,$hashes_parent,$height,$keywords_parent,$lang,$medium,$player_parent,$ratings_parent,$restrictions_parent,$samplingrate,$thumbnails_parent,$title_parent,$width),false)));
}}if ( deAspis($enclosure = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('enclosure',false))))
 {if ( ((isset($enclosure[0][(0)][0][('attribs')][0][('')][0][('url')]) && Aspis_isset( $enclosure [0][(0)] [0][('attribs')] [0][('')] [0][('url')]))))
 {$bitrate = array(null,false);
$channels = array(null,false);
$duration = array(null,false);
$expression = array(null,false);
$framerate = array(null,false);
$height = array(null,false);
$javascript = array(null,false);
$lang = array(null,false);
$length = array(null,false);
$medium = array(null,false);
$samplingrate = array(null,false);
$type = array(null,false);
$url = array(null,false);
$width = array(null,false);
$url = $this->sanitize($enclosure[0][(0)][0][('attribs')][0][('')][0]['url'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($enclosure,(0))));
if ( ((isset($enclosure[0][(0)][0][('attribs')][0][('')][0][('type')]) && Aspis_isset( $enclosure [0][(0)] [0][('attribs')] [0][('')] [0][('type')]))))
 {$type = $this->sanitize($enclosure[0][(0)][0][('attribs')][0][('')][0]['type'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($enclosure[0][(0)][0][('attribs')][0][('')][0][('length')]) && Aspis_isset( $enclosure [0][(0)] [0][('attribs')] [0][('')] [0][('length')]))))
 {$length = attAspis(ceil(deAspis($enclosure[0][(0)][0][('attribs')][0][('')][0]['length'])));
}arrayAssignAdd($this->data[0][('enclosures')][0][],addTaint(array(new $this->feed[0]->enclosure_class[0]($url,$type,$length,$this->feed[0]->javascript,$bitrate,$captions_parent,$categories_parent,$channels,$copyrights_parent,$credits_parent,$description_parent,$duration_parent,$expression,$framerate,$hashes_parent,$height,$keywords_parent,$lang,$medium,$player_parent,$ratings_parent,$restrictions_parent,$samplingrate,$thumbnails_parent,$title_parent,$width),false)));
}}if ( (((sizeof(deAspisRC($this->data[0][('enclosures')]))) === (0)) && (((((((((((((((((((((((($url[0] || $type[0]) || $length[0]) || $bitrate[0]) || $captions_parent[0]) || $categories_parent[0]) || $channels[0]) || $copyrights_parent[0]) || $credits_parent[0]) || $description_parent[0]) || $duration_parent[0]) || $expression[0]) || $framerate[0]) || $hashes_parent[0]) || $height[0]) || $keywords_parent[0]) || $lang[0]) || $medium[0]) || $player_parent[0]) || $ratings_parent[0]) || $restrictions_parent[0]) || $samplingrate[0]) || $thumbnails_parent[0]) || $title_parent[0]) || $width[0])))
 {arrayAssignAdd($this->data[0][('enclosures')][0][],addTaint(array(new $this->feed[0]->enclosure_class[0]($url,$type,$length,$this->feed[0]->javascript,$bitrate,$captions_parent,$categories_parent,$channels,$copyrights_parent,$credits_parent,$description_parent,$duration_parent,$expression,$framerate,$hashes_parent,$height,$keywords_parent,$lang,$medium,$player_parent,$ratings_parent,$restrictions_parent,$samplingrate,$thumbnails_parent,$title_parent,$width),false)));
}arrayAssign($this->data[0],deAspis(registerTaint(array('enclosures',false))),addTaint(Aspis_array_values(SimplePie_Misc::array_unique($this->data[0][('enclosures')]))));
}if ( (!((empty($this->data[0][('enclosures')]) || Aspis_empty( $this ->data [0][('enclosures')] )))))
 {return $this->data[0][('enclosures')];
}else 
{{return array(null,false);
}}} }
function get_latitude (  ) {
{if ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_W3C_BASIC_GEO,false),array('lat',false))))
 {return float_cast($return[0][(0)][0]['data']);
}elseif ( (deAspis(($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_GEORSS,false),array('point',false)))) && deAspis(Aspis_preg_match(array('/^((?:-)?[0-9]+(?:\.[0-9]+)) ((?:-)?[0-9]+(?:\.[0-9]+))$/',false),$return[0][(0)][0]['data'],$match))))
 {return float_cast(attachAspis($match,(1)));
}else 
{{return array(null,false);
}}} }
function get_longitude (  ) {
{if ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_W3C_BASIC_GEO,false),array('long',false))))
 {return float_cast($return[0][(0)][0]['data']);
}elseif ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_W3C_BASIC_GEO,false),array('lon',false))))
 {return float_cast($return[0][(0)][0]['data']);
}elseif ( (deAspis(($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_GEORSS,false),array('point',false)))) && deAspis(Aspis_preg_match(array('/^((?:-)?[0-9]+(?:\.[0-9]+)) ((?:-)?[0-9]+(?:\.[0-9]+))$/',false),$return[0][(0)][0]['data'],$match))))
 {return float_cast(attachAspis($match,(2)));
}else 
{{return array(null,false);
}}} }
function get_source (  ) {
{if ( deAspis($return = $this->get_item_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('source',false))))
 {return array(new $this->feed[0]->source_class[0](array($this,false),attachAspis($return,(0))),false);
}else 
{{return array(null,false);
}}} }
function add_to_service ( $item_url,$title_url = array(null,false),$summary_url = array(null,false) ) {
{if ( (deAspis($this->get_permalink()) !== null))
 {$return = concat($item_url,Aspis_rawurlencode($this->get_permalink()));
if ( (($title_url[0] !== null) && (deAspis($this->get_title()) !== null)))
 {$return = concat($return,concat($title_url,Aspis_rawurlencode($this->get_title())));
}if ( (($summary_url[0] !== null) && (deAspis($this->get_description()) !== null)))
 {$return = concat($return,concat($summary_url,Aspis_rawurlencode($this->get_description())));
}return $this->sanitize($return,array(SIMPLEPIE_CONSTRUCT_IRI,false));
}else 
{{return array(null,false);
}}} }
function add_to_blinklist (  ) {
{return $this->add_to_service(array('http://www.blinklist.com/index.php?Action=Blink/addblink.php&Description=&Url=',false),array('&Title=',false));
} }
function add_to_blogmarks (  ) {
{return $this->add_to_service(array('http://blogmarks.net/my/new.php?mini=1&simple=1&url=',false),array('&title=',false));
} }
function add_to_delicious (  ) {
{return $this->add_to_service(array('http://del.icio.us/post/?v=4&url=',false),array('&title=',false));
} }
function add_to_digg (  ) {
{return $this->add_to_service(array('http://digg.com/submit?url=',false),array('&title=',false),array('&bodytext=',false));
} }
function add_to_furl (  ) {
{return $this->add_to_service(array('http://www.furl.net/storeIt.jsp?u=',false),array('&t=',false));
} }
function add_to_magnolia (  ) {
{return $this->add_to_service(array('http://ma.gnolia.com/bookmarklet/add?url=',false),array('&title=',false));
} }
function add_to_myweb20 (  ) {
{return $this->add_to_service(array('http://myweb2.search.yahoo.com/myresults/bookmarklet?u=',false),array('&t=',false));
} }
function add_to_newsvine (  ) {
{return $this->add_to_service(array('http://www.newsvine.com/_wine/save?u=',false),array('&h=',false));
} }
function add_to_reddit (  ) {
{return $this->add_to_service(array('http://reddit.com/submit?url=',false),array('&title=',false));
} }
function add_to_segnalo (  ) {
{return $this->add_to_service(array('http://segnalo.com/post.html.php?url=',false),array('&title=',false));
} }
function add_to_simpy (  ) {
{return $this->add_to_service(array('http://www.simpy.com/simpy/LinkAdd.do?href=',false),array('&title=',false));
} }
function add_to_spurl (  ) {
{return $this->add_to_service(array('http://www.spurl.net/spurl.php?v=3&url=',false),array('&title=',false));
} }
function add_to_wists (  ) {
{return $this->add_to_service(array('http://wists.com/r.php?c=&r=',false),array('&title=',false));
} }
function search_technorati (  ) {
{return $this->add_to_service(array('http://www.technorati.com/search/',false));
} }
}class SimplePie_Source{var $item;
var $data = array(array(),false);
function SimplePie_Source ( $item,$data ) {
{$this->item = $item;
$this->data = $data;
} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize($this->data))));
} }
function get_source_tags ( $namespace,$tag ) {
{if ( ((isset($this->data[0][('child')][0][$namespace[0]][0][$tag[0]]) && Aspis_isset( $this ->data [0][('child')] [0][$namespace[0]] [0][$tag[0]] ))))
 {return $this->data[0][('child')][0][$namespace[0]][0][$tag[0]];
}else 
{{return array(null,false);
}}} }
function get_base ( $element = array(array(),false) ) {
{return $this->item[0]->get_base($element);
} }
function sanitize ( $data,$type,$base = array('',false) ) {
{return $this->item[0]->sanitize($data,$type,$base);
} }
function get_item (  ) {
{return $this->item;
} }
function get_title (  ) {
{if ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_10_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_03_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('title',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{return array(null,false);
}}} }
function get_category ( $key = array(0,false) ) {
{$categories = $this->get_categories();
if ( ((isset($categories[0][$key[0]]) && Aspis_isset( $categories [0][$key[0]]))))
 {return attachAspis($categories,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_categories (  ) {
{$categories = array(array(),false);
foreach ( deAspis(array_cast($this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('category',false)))) as $category  )
{$term = array(null,false);
$scheme = array(null,false);
$label = array(null,false);
if ( ((isset($category[0][('attribs')][0][('')][0][('term')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('term')]))))
 {$term = $this->sanitize($category[0][('attribs')][0][('')][0]['term'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('scheme')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('scheme')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['scheme'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($category[0][('attribs')][0][('')][0][('label')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('label')]))))
 {$label = $this->sanitize($category[0][('attribs')][0][('')][0]['label'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}arrayAssignAdd($categories[0][],addTaint(array(new $this->item[0]->feed[0]->category_class[0]($term,$scheme,$label),false)));
}foreach ( deAspis(array_cast($this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('category',false)))) as $category  )
{$term = $this->sanitize($category[0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
if ( ((isset($category[0][('attribs')][0][('')][0][('domain')]) && Aspis_isset( $category [0][('attribs')] [0][('')] [0][('domain')]))))
 {$scheme = $this->sanitize($category[0][('attribs')][0][('')][0]['domain'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{$scheme = array(null,false);
}}arrayAssignAdd($categories[0][],addTaint(array(new $this->item[0]->feed[0]->category_class[0]($term,$scheme,array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('subject',false)))) as $category  )
{arrayAssignAdd($categories[0][],addTaint(array(new $this->item[0]->feed[0]->category_class[0]($this->sanitize($category[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('subject',false)))) as $category  )
{arrayAssignAdd($categories[0][],addTaint(array(new $this->item[0]->feed[0]->category_class[0]($this->sanitize($category[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}if ( (!((empty($categories) || Aspis_empty( $categories)))))
 {return SimplePie_Misc::array_unique($categories);
}else 
{{return array(null,false);
}}} }
function get_author ( $key = array(0,false) ) {
{$authors = $this->get_authors();
if ( ((isset($authors[0][$key[0]]) && Aspis_isset( $authors [0][$key[0]]))))
 {return attachAspis($authors,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_authors (  ) {
{$authors = array(array(),false);
foreach ( deAspis(array_cast($this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('author',false)))) as $author  )
{$name = array(null,false);
$uri = array(null,false);
$email = array(null,false);
if ( ((isset($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $author [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0][('data')]) && Aspis_isset( $author [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('uri')] [0][(0)] [0][('data')]))))
 {$uri = $this->sanitize($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')],(0))));
}if ( ((isset($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $author [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($author[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($uri[0] !== null)))
 {arrayAssignAdd($authors[0][],addTaint(array(new $this->item[0]->feed[0]->author_class[0]($name,$uri,$email),false)));
}}if ( deAspis($author = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('author',false))))
 {$name = array(null,false);
$url = array(null,false);
$email = array(null,false);
if ( ((isset($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $author [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0][('data')]) && Aspis_isset( $author [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('url')] [0][(0)] [0][('data')]))))
 {$url = $this->sanitize($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')],(0))));
}if ( ((isset($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $author [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($author[0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($url[0] !== null)))
 {arrayAssignAdd($authors[0][],addTaint(array(new $this->item[0]->feed[0]->author_class[0]($name,$url,$email),false)));
}}foreach ( deAspis(array_cast($this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('creator',false)))) as $author  )
{arrayAssignAdd($authors[0][],addTaint(array(new $this->item[0]->feed[0]->author_class[0]($this->sanitize($author[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('creator',false)))) as $author  )
{arrayAssignAdd($authors[0][],addTaint(array(new $this->item[0]->feed[0]->author_class[0]($this->sanitize($author[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}foreach ( deAspis(array_cast($this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('author',false)))) as $author  )
{arrayAssignAdd($authors[0][],addTaint(array(new $this->item[0]->feed[0]->author_class[0]($this->sanitize($author[0][('data')],array(SIMPLEPIE_CONSTRUCT_TEXT,false)),array(null,false),array(null,false)),false)));
}if ( (!((empty($authors) || Aspis_empty( $authors)))))
 {return SimplePie_Misc::array_unique($authors);
}else 
{{return array(null,false);
}}} }
function get_contributor ( $key = array(0,false) ) {
{$contributors = $this->get_contributors();
if ( ((isset($contributors[0][$key[0]]) && Aspis_isset( $contributors [0][$key[0]]))))
 {return attachAspis($contributors,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_contributors (  ) {
{$contributors = array(array(),false);
foreach ( deAspis(array_cast($this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('contributor',false)))) as $contributor  )
{$name = array(null,false);
$uri = array(null,false);
$email = array(null,false);
if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('uri')] [0][(0)] [0][('data')]))))
 {$uri = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('uri')],(0))));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($uri[0] !== null)))
 {arrayAssignAdd($contributors[0][],addTaint(array(new $this->item[0]->feed[0]->author_class[0]($name,$uri,$email),false)));
}}foreach ( deAspis(array_cast($this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('contributor',false)))) as $contributor  )
{$name = array(null,false);
$url = array(null,false);
$email = array(null,false);
if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('name')] [0][(0)] [0][('data')]))))
 {$name = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('name')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('url')] [0][(0)] [0][('data')]))))
 {$url = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('url')],(0))));
}if ( ((isset($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0][('data')]) && Aspis_isset( $contributor [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('email')] [0][(0)] [0][('data')]))))
 {$email = $this->sanitize($contributor[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('email')][0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}if ( ((($name[0] !== null) || ($email[0] !== null)) || ($url[0] !== null)))
 {arrayAssignAdd($contributors[0][],addTaint(array(new $this->item[0]->feed[0]->author_class[0]($name,$url,$email),false)));
}}if ( (!((empty($contributors) || Aspis_empty( $contributors)))))
 {return SimplePie_Misc::array_unique($contributors);
}else 
{{return array(null,false);
}}} }
function get_link ( $key = array(0,false),$rel = array('alternate',false) ) {
{$links = $this->get_links($rel);
if ( ((isset($links[0][$key[0]]) && Aspis_isset( $links [0][$key[0]]))))
 {return attachAspis($links,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_permalink (  ) {
{return $this->get_link(array(0,false));
} }
function get_links ( $rel = array('alternate',false) ) {
{if ( (!((isset($this->data[0][('links')]) && Aspis_isset( $this ->data [0][('links')] )))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('links',false))),addTaint(array(array(),false)));
if ( deAspis($links = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('link',false))))
 {foreach ( $links[0] as $link  )
{if ( ((isset($link[0][('attribs')][0][('')][0][('href')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('href')]))))
 {$link_rel = ((isset($link[0][('attribs')][0][('')][0][('rel')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('rel')]))) ? $link[0][('attribs')][0][('')][0]['rel'] : array('alternate',false);
arrayAssignAdd($this->data[0][('links')][0][$link_rel[0]][0][],addTaint($this->sanitize($link[0][('attribs')][0][('')][0]['href'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base($link))));
}}}if ( deAspis($links = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('link',false))))
 {foreach ( $links[0] as $link  )
{if ( ((isset($link[0][('attribs')][0][('')][0][('href')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('href')]))))
 {$link_rel = ((isset($link[0][('attribs')][0][('')][0][('rel')]) && Aspis_isset( $link [0][('attribs')] [0][('')] [0][('rel')]))) ? $link[0][('attribs')][0][('')][0]['rel'] : array('alternate',false);
arrayAssignAdd($this->data[0][('links')][0][$link_rel[0]][0][],addTaint($this->sanitize($link[0][('attribs')][0][('')][0]['href'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base($link))));
}}}if ( deAspis($links = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('link',false))))
 {arrayAssignAdd($this->data[0][('links')][0][('alternate')][0][],addTaint($this->sanitize($links[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($links,(0))))));
}if ( deAspis($links = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('link',false))))
 {arrayAssignAdd($this->data[0][('links')][0][('alternate')][0][],addTaint($this->sanitize($links[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($links,(0))))));
}if ( deAspis($links = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('link',false))))
 {arrayAssignAdd($this->data[0][('links')][0][('alternate')][0][],addTaint($this->sanitize($links[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($links,(0))))));
}$keys = attAspisRC(array_keys(deAspisRC($this->data[0][('links')])));
foreach ( $keys[0] as $key  )
{if ( deAspis(SimplePie_Misc::is_isegment_nz_nc($key)))
 {if ( ((isset($this->data[0][('links')][0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))]) && Aspis_isset( $this ->data [0][('links')] [0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))] ))))
 {arrayAssign($this->data[0][('links')][0],deAspis(registerTaint(concat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))),addTaint(Aspis_array_merge($this->data[0][('links')][0][$key[0]],$this->data[0][('links')][0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))])));
$this->data[0][('links')][0][deAspis(registerTaint($key))] = &addTaintR($this->data[0][('links')][0][(deconcat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key))]);
}else 
{{$this->data[0][('links')][0][deAspis(registerTaint(concat1(SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY,$key)))] = &addTaintR($this->data[0][('links')][0][$key[0]]);
}}}elseif ( (deAspis(Aspis_substr($key,array(0,false),array(41,false))) === SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY))
 {$this->data[0][('links')][0][deAspis(registerTaint(Aspis_substr($key,array(41,false))))] = &addTaintR($this->data[0][('links')][0][$key[0]]);
}arrayAssign($this->data[0][('links')][0],deAspis(registerTaint($key)),addTaint(attAspisRC(array_unique(deAspisRC($this->data[0][('links')][0][$key[0]])))));
}}if ( ((isset($this->data[0][('links')][0][$rel[0]]) && Aspis_isset( $this ->data [0][('links')] [0][$rel[0]] ))))
 {return $this->data[0][('links')][0][$rel[0]];
}else 
{{return array(null,false);
}}} }
function get_description (  ) {
{if ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('subtitle',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_10_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('tagline',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_03_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_10,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_090,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_MAYBE_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('description',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('summary',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_HTML,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('subtitle',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_HTML,false),$this->get_base(attachAspis($return,(0))));
}else 
{{return array(null,false);
}}} }
function get_copyright (  ) {
{if ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('rights',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_10_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_03,false),array('copyright',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],SimplePie_Misc::atom_03_construct_type($return[0][(0)][0]['attribs']),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('copyright',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('rights',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('rights',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{return array(null,false);
}}} }
function get_language (  ) {
{if ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_RSS_20,false),array('language',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_11,false),array('language',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_DC_10,false),array('language',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}elseif ( ((isset($this->data[0][('xml_lang')]) && Aspis_isset( $this ->data [0][('xml_lang')] ))))
 {return $this->sanitize($this->data[0][('xml_lang')],array(SIMPLEPIE_CONSTRUCT_TEXT,false));
}else 
{{return array(null,false);
}}} }
function get_latitude (  ) {
{if ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_W3C_BASIC_GEO,false),array('lat',false))))
 {return float_cast($return[0][(0)][0]['data']);
}elseif ( (deAspis(($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_GEORSS,false),array('point',false)))) && deAspis(Aspis_preg_match(array('/^((?:-)?[0-9]+(?:\.[0-9]+)) ((?:-)?[0-9]+(?:\.[0-9]+))$/',false),$return[0][(0)][0]['data'],$match))))
 {return float_cast(attachAspis($match,(1)));
}else 
{{return array(null,false);
}}} }
function get_longitude (  ) {
{if ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_W3C_BASIC_GEO,false),array('long',false))))
 {return float_cast($return[0][(0)][0]['data']);
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_W3C_BASIC_GEO,false),array('lon',false))))
 {return float_cast($return[0][(0)][0]['data']);
}elseif ( (deAspis(($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_GEORSS,false),array('point',false)))) && deAspis(Aspis_preg_match(array('/^((?:-)?[0-9]+(?:\.[0-9]+)) ((?:-)?[0-9]+(?:\.[0-9]+))$/',false),$return[0][(0)][0]['data'],$match))))
 {return float_cast(attachAspis($match,(2)));
}else 
{{return array(null,false);
}}} }
function get_image_url (  ) {
{if ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ITUNES,false),array('image',false))))
 {return $this->sanitize($return[0][(0)][0][('attribs')][0][('')][0]['href'],array(SIMPLEPIE_CONSTRUCT_IRI,false));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('logo',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}elseif ( deAspis($return = $this->get_source_tags(array(SIMPLEPIE_NAMESPACE_ATOM_10,false),array('icon',false))))
 {return $this->sanitize($return[0][(0)][0]['data'],array(SIMPLEPIE_CONSTRUCT_IRI,false),$this->get_base(attachAspis($return,(0))));
}else 
{{return array(null,false);
}}} }
}class SimplePie_Author{var $name;
var $link;
var $email;
function SimplePie_Author ( $name = array(null,false),$link = array(null,false),$email = array(null,false) ) {
{$this->name = $name;
$this->link = $link;
$this->email = $email;
} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize(array($this,false)))));
} }
function get_name (  ) {
{if ( ($this->name[0] !== null))
 {return $this->name;
}else 
{{return array(null,false);
}}} }
function get_link (  ) {
{if ( ($this->link[0] !== null))
 {return $this->link;
}else 
{{return array(null,false);
}}} }
function get_email (  ) {
{if ( ($this->email[0] !== null))
 {return $this->email;
}else 
{{return array(null,false);
}}} }
}class SimplePie_Category{var $term;
var $scheme;
var $label;
function SimplePie_Category ( $term = array(null,false),$scheme = array(null,false),$label = array(null,false) ) {
{$this->term = $term;
$this->scheme = $scheme;
$this->label = $label;
} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize(array($this,false)))));
} }
function get_term (  ) {
{if ( ($this->term[0] !== null))
 {return $this->term;
}else 
{{return array(null,false);
}}} }
function get_scheme (  ) {
{if ( ($this->scheme[0] !== null))
 {return $this->scheme;
}else 
{{return array(null,false);
}}} }
function get_label (  ) {
{if ( ($this->label[0] !== null))
 {return $this->label;
}else 
{{return $this->get_term();
}}} }
}class SimplePie_Enclosure{var $bitrate;
var $captions;
var $categories;
var $channels;
var $copyright;
var $credits;
var $description;
var $duration;
var $expression;
var $framerate;
var $handler;
var $hashes;
var $height;
var $javascript;
var $keywords;
var $lang;
var $length;
var $link;
var $medium;
var $player;
var $ratings;
var $restrictions;
var $samplingrate;
var $thumbnails;
var $title;
var $type;
var $width;
function SimplePie_Enclosure ( $link = array(null,false),$type = array(null,false),$length = array(null,false),$javascript = array(null,false),$bitrate = array(null,false),$captions = array(null,false),$categories = array(null,false),$channels = array(null,false),$copyright = array(null,false),$credits = array(null,false),$description = array(null,false),$duration = array(null,false),$expression = array(null,false),$framerate = array(null,false),$hashes = array(null,false),$height = array(null,false),$keywords = array(null,false),$lang = array(null,false),$medium = array(null,false),$player = array(null,false),$ratings = array(null,false),$restrictions = array(null,false),$samplingrate = array(null,false),$thumbnails = array(null,false),$title = array(null,false),$width = array(null,false) ) {
{$this->bitrate = $bitrate;
$this->captions = $captions;
$this->categories = $categories;
$this->channels = $channels;
$this->copyright = $copyright;
$this->credits = $credits;
$this->description = $description;
$this->duration = $duration;
$this->expression = $expression;
$this->framerate = $framerate;
$this->hashes = $hashes;
$this->height = $height;
$this->javascript = $javascript;
$this->keywords = $keywords;
$this->lang = $lang;
$this->length = $length;
$this->link = $link;
$this->medium = $medium;
$this->player = $player;
$this->ratings = $ratings;
$this->restrictions = $restrictions;
$this->samplingrate = $samplingrate;
$this->thumbnails = $thumbnails;
$this->title = $title;
$this->type = $type;
$this->width = $width;
if ( class_exists(('idna_convert')))
 {$idn = array(new idna_convert,false);
$parsed = SimplePie_Misc::parse_url($link);
$this->link = SimplePie_Misc::compress_parse_url($parsed[0]['scheme'],$idn[0]->encode($parsed[0]['authority']),$parsed[0]['path'],$parsed[0]['query'],$parsed[0]['fragment']);
}$this->handler = $this->get_handler();
} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize(array($this,false)))));
} }
function get_bitrate (  ) {
{if ( ($this->bitrate[0] !== null))
 {return $this->bitrate;
}else 
{{return array(null,false);
}}} }
function get_caption ( $key = array(0,false) ) {
{$captions = $this->get_captions();
if ( ((isset($captions[0][$key[0]]) && Aspis_isset( $captions [0][$key[0]]))))
 {return attachAspis($captions,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_captions (  ) {
{if ( ($this->captions[0] !== null))
 {return $this->captions;
}else 
{{return array(null,false);
}}} }
function get_category ( $key = array(0,false) ) {
{$categories = $this->get_categories();
if ( ((isset($categories[0][$key[0]]) && Aspis_isset( $categories [0][$key[0]]))))
 {return attachAspis($categories,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_categories (  ) {
{if ( ($this->categories[0] !== null))
 {return $this->categories;
}else 
{{return array(null,false);
}}} }
function get_channels (  ) {
{if ( ($this->channels[0] !== null))
 {return $this->channels;
}else 
{{return array(null,false);
}}} }
function get_copyright (  ) {
{if ( ($this->copyright[0] !== null))
 {return $this->copyright;
}else 
{{return array(null,false);
}}} }
function get_credit ( $key = array(0,false) ) {
{$credits = $this->get_credits();
if ( ((isset($credits[0][$key[0]]) && Aspis_isset( $credits [0][$key[0]]))))
 {return attachAspis($credits,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_credits (  ) {
{if ( ($this->credits[0] !== null))
 {return $this->credits;
}else 
{{return array(null,false);
}}} }
function get_description (  ) {
{if ( ($this->description[0] !== null))
 {return $this->description;
}else 
{{return array(null,false);
}}} }
function get_duration ( $convert = array(false,false) ) {
{if ( ($this->duration[0] !== null))
 {if ( $convert[0])
 {$time = SimplePie_Misc::time_hms($this->duration);
return $time;
}else 
{{return $this->duration;
}}}else 
{{return array(null,false);
}}} }
function get_expression (  ) {
{if ( ($this->expression[0] !== null))
 {return $this->expression;
}else 
{{return array('full',false);
}}} }
function get_extension (  ) {
{if ( ($this->link[0] !== null))
 {$url = SimplePie_Misc::parse_url($this->link);
if ( (deAspis($url[0]['path']) !== ('')))
 {return Aspis_pathinfo($url[0]['path'],array(PATHINFO_EXTENSION,false));
}}return array(null,false);
} }
function get_framerate (  ) {
{if ( ($this->framerate[0] !== null))
 {return $this->framerate;
}else 
{{return array(null,false);
}}} }
function get_handler (  ) {
{return $this->get_real_type(array(true,false));
} }
function get_hash ( $key = array(0,false) ) {
{$hashes = $this->get_hashes();
if ( ((isset($hashes[0][$key[0]]) && Aspis_isset( $hashes [0][$key[0]]))))
 {return attachAspis($hashes,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_hashes (  ) {
{if ( ($this->hashes[0] !== null))
 {return $this->hashes;
}else 
{{return array(null,false);
}}} }
function get_height (  ) {
{if ( ($this->height[0] !== null))
 {return $this->height;
}else 
{{return array(null,false);
}}} }
function get_language (  ) {
{if ( ($this->lang[0] !== null))
 {return $this->lang;
}else 
{{return array(null,false);
}}} }
function get_keyword ( $key = array(0,false) ) {
{$keywords = $this->get_keywords();
if ( ((isset($keywords[0][$key[0]]) && Aspis_isset( $keywords [0][$key[0]]))))
 {return attachAspis($keywords,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_keywords (  ) {
{if ( ($this->keywords[0] !== null))
 {return $this->keywords;
}else 
{{return array(null,false);
}}} }
function get_length (  ) {
{if ( ($this->length[0] !== null))
 {return $this->length;
}else 
{{return array(null,false);
}}} }
function get_link (  ) {
{if ( ($this->link[0] !== null))
 {return Aspis_urldecode($this->link);
}else 
{{return array(null,false);
}}} }
function get_medium (  ) {
{if ( ($this->medium[0] !== null))
 {return $this->medium;
}else 
{{return array(null,false);
}}} }
function get_player (  ) {
{if ( ($this->player[0] !== null))
 {return $this->player;
}else 
{{return array(null,false);
}}} }
function get_rating ( $key = array(0,false) ) {
{$ratings = $this->get_ratings();
if ( ((isset($ratings[0][$key[0]]) && Aspis_isset( $ratings [0][$key[0]]))))
 {return attachAspis($ratings,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_ratings (  ) {
{if ( ($this->ratings[0] !== null))
 {return $this->ratings;
}else 
{{return array(null,false);
}}} }
function get_restriction ( $key = array(0,false) ) {
{$restrictions = $this->get_restrictions();
if ( ((isset($restrictions[0][$key[0]]) && Aspis_isset( $restrictions [0][$key[0]]))))
 {return attachAspis($restrictions,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_restrictions (  ) {
{if ( ($this->restrictions[0] !== null))
 {return $this->restrictions;
}else 
{{return array(null,false);
}}} }
function get_sampling_rate (  ) {
{if ( ($this->samplingrate[0] !== null))
 {return $this->samplingrate;
}else 
{{return array(null,false);
}}} }
function get_size (  ) {
{$length = $this->get_length();
if ( ($length[0] !== null))
 {return attAspis(round(($length[0] / (1048576)),(2)));
}else 
{{return array(null,false);
}}} }
function get_thumbnail ( $key = array(0,false) ) {
{$thumbnails = $this->get_thumbnails();
if ( ((isset($thumbnails[0][$key[0]]) && Aspis_isset( $thumbnails [0][$key[0]]))))
 {return attachAspis($thumbnails,$key[0]);
}else 
{{return array(null,false);
}}} }
function get_thumbnails (  ) {
{if ( ($this->thumbnails[0] !== null))
 {return $this->thumbnails;
}else 
{{return array(null,false);
}}} }
function get_title (  ) {
{if ( ($this->title[0] !== null))
 {return $this->title;
}else 
{{return array(null,false);
}}} }
function get_type (  ) {
{if ( ($this->type[0] !== null))
 {return $this->type;
}else 
{{return array(null,false);
}}} }
function get_width (  ) {
{if ( ($this->width[0] !== null))
 {return $this->width;
}else 
{{return array(null,false);
}}} }
function native_embed ( $options = array('',false) ) {
{return $this->embed($options,array(true,false));
} }
function embed ( $options = array('',false),$native = array(false,false) ) {
{$audio = array('',false);
$video = array('',false);
$alt = array('',false);
$altclass = array('',false);
$loop = array('false',false);
$width = array('auto',false);
$height = array('auto',false);
$bgcolor = array('#ffffff',false);
$mediaplayer = array('',false);
$widescreen = array(false,false);
$handler = $this->get_handler();
$type = $this->get_real_type();
if ( is_array($options[0]))
 {extract(($options[0]));
}else 
{{$options = Aspis_explode(array(',',false),$options);
foreach ( $options[0] as $option  )
{$opt = Aspis_explode(array(':',false),$option,array(2,false));
if ( ((isset($opt[0][(0)],$opt[0][(1)]) && Aspis_isset( $opt [0][(0)],$opt [0][(1)]))))
 {arrayAssign($opt[0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_trim(attachAspis($opt,(0)))));
arrayAssign($opt[0],deAspis(registerTaint(array(1,false))),addTaint(Aspis_trim(attachAspis($opt,(1)))));
switch ( deAspis(attachAspis($opt,(0))) ) {
case ('audio'):$audio = attachAspis($opt,(1));
break ;
case ('video'):$video = attachAspis($opt,(1));
break ;
case ('alt'):$alt = attachAspis($opt,(1));
break ;
case ('altclass'):$altclass = attachAspis($opt,(1));
break ;
case ('loop'):$loop = attachAspis($opt,(1));
break ;
case ('width'):$width = attachAspis($opt,(1));
break ;
case ('height'):$height = attachAspis($opt,(1));
break ;
case ('bgcolor'):$bgcolor = attachAspis($opt,(1));
break ;
case ('mediaplayer'):$mediaplayer = attachAspis($opt,(1));
break ;
case ('widescreen'):$widescreen = attachAspis($opt,(1));
break ;
 }
}}}}$mime = Aspis_explode(array('/',false),$type,array(2,false));
$mime = attachAspis($mime,(0));
if ( ($width[0] === ('auto')))
 {if ( ($mime[0] === ('video')))
 {if ( ($height[0] === ('auto')))
 {$width = array(480,false);
}elseif ( $widescreen[0])
 {$width = attAspis(round(((deAspis(Aspis_intval($height)) / (9)) * (16))));
}else 
{{$width = attAspis(round(((deAspis(Aspis_intval($height)) / (3)) * (4))));
}}}else 
{{$width = array('100%',false);
}}}if ( ($height[0] === ('auto')))
 {if ( ($mime[0] === ('audio')))
 {$height = array(0,false);
}elseif ( ($mime[0] === ('video')))
 {if ( ($width[0] === ('auto')))
 {if ( $widescreen[0])
 {$height = array(270,false);
}else 
{{$height = array(360,false);
}}}elseif ( $widescreen[0])
 {$height = attAspis(round(((deAspis(Aspis_intval($width)) / (16)) * (9))));
}else 
{{$height = attAspis(round(((deAspis(Aspis_intval($width)) / (4)) * (3))));
}}}else 
{{$height = array(376,false);
}}}elseif ( ($mime[0] === ('audio')))
 {$height = array(0,false);
}if ( ($mime[0] === ('audio')))
 {$placeholder = $audio;
}elseif ( ($mime[0] === ('video')))
 {$placeholder = $video;
}$embed = array('',false);
if ( (denot_boolean($native)))
 {static $javascript_outputted = array(null,false);
if ( ((denot_boolean($javascript_outputted)) && $this->javascript[0]))
 {$embed = concat($embed,concat2(concat1('<script type="text/javascript" src="?',Aspis_htmlspecialchars($this->javascript)),'"></script>'));
$javascript_outputted = array(true,false);
}}if ( ($handler[0] === ('odeo')))
 {if ( $native[0])
 {$embed = concat($embed,concat2(concat1('<embed src="http://odeo.com/flash/audio_player_fullsize.swf" pluginspage="http://adobe.com/go/getflashplayer" type="application/x-shockwave-flash" quality="high" width="440" height="80" wmode="transparent" allowScriptAccess="any" flashvars="valid_sample_rate=true&external_url=',$this->get_link()),'"></embed>'));
}else 
{{$embed = concat($embed,concat2(concat1('<script type="text/javascript">embed_odeo("',$this->get_link()),'");</script>'));
}}}elseif ( ($handler[0] === ('flash')))
 {if ( $native[0])
 {$embed = concat($embed,concat(concat1("<embed src=\"",$this->get_link()),concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\" pluginspage=\"http://adobe.com/go/getflashplayer\" type=\"",$type),"\" quality=\"high\" width=\""),$width),"\" height=\""),$height),"\" bgcolor=\""),$bgcolor),"\" loop=\""),$loop),"\"></embed>")));
}else 
{{$embed = concat($embed,concat(concat(concat2(concat(concat2(concat(concat2(concat1("<script type='text/javascript'>embed_flash('",$bgcolor),"', '"),$width),"', '"),$height),"', '"),$this->get_link()),concat2(concat(concat2(concat1("', '",$loop),"', '"),$type),"');</script>")));
}}}elseif ( (($handler[0] === ('fmedia')) || (($handler[0] === ('mp3')) && ($mediaplayer[0] !== ('')))))
 {$height = array((20) + $height[0],false);
if ( $native[0])
 {$embed = concat($embed,concat(concat(concat2(concat(concat2(concat(concat2(concat1("<embed src=\"",$mediaplayer),"\" pluginspage=\"http://adobe.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" quality=\"high\" width=\""),$width),"\" height=\""),$height),"\" wmode=\"transparent\" flashvars=\"file="),Aspis_rawurlencode(concat(concat2($this->get_link(),'?file_extension=.'),$this->get_extension()))),concat2(concat1("&autostart=false&repeat=",$loop),"&showdigits=true&showfsbutton=false\"></embed>")));
}else 
{{$embed = concat($embed,concat(concat(concat2(concat(concat2(concat1("<script type='text/javascript'>embed_flv('",$width),"', '"),$height),"', '"),Aspis_rawurlencode(concat(concat2($this->get_link(),'?file_extension=.'),$this->get_extension()))),concat2(concat(concat2(concat(concat2(concat1("', '",$placeholder),"', '"),$loop),"', '"),$mediaplayer),"');</script>")));
}}}elseif ( (($handler[0] === ('quicktime')) || (($handler[0] === ('mp3')) && ($mediaplayer[0] === ('')))))
 {$height = array((16) + $height[0],false);
if ( $native[0])
 {if ( ($placeholder[0] !== ('')))
 {$embed = concat($embed,concat(concat(concat2(concat1("<embed type=\"",$type),"\" style=\"cursor:hand; cursor:pointer;\" href=\""),$this->get_link()),concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\" src=\"",$placeholder),"\" width=\""),$width),"\" height=\""),$height),"\" autoplay=\"false\" target=\"myself\" controller=\"false\" loop=\""),$loop),"\" scale=\"aspect\" bgcolor=\""),$bgcolor),"\" pluginspage=\"http://apple.com/quicktime/download/\"></embed>")));
}else 
{{$embed = concat($embed,concat(concat(concat2(concat1("<embed type=\"",$type),"\" style=\"cursor:hand; cursor:pointer;\" src=\""),$this->get_link()),concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\" width=\"",$width),"\" height=\""),$height),"\" autoplay=\"false\" target=\"myself\" controller=\"true\" loop=\""),$loop),"\" scale=\"aspect\" bgcolor=\""),$bgcolor),"\" pluginspage=\"http://apple.com/quicktime/download/\"></embed>")));
}}}else 
{{$embed = concat($embed,concat(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<script type='text/javascript'>embed_quicktime('",$type),"', '"),$bgcolor),"', '"),$width),"', '"),$height),"', '"),$this->get_link()),concat2(concat(concat2(concat1("', '",$placeholder),"', '"),$loop),"');</script>")));
}}}elseif ( ($handler[0] === ('wmedia')))
 {$height = array((45) + $height[0],false);
if ( $native[0])
 {$embed = concat($embed,concat(concat1("<embed type=\"application/x-mplayer2\" src=\"",$this->get_link()),concat2(concat(concat2(concat1("\" autosize=\"1\" width=\"",$width),"\" height=\""),$height),"\" showcontrols=\"1\" showstatusbar=\"0\" showdisplay=\"0\" autostart=\"0\"></embed>")));
}else 
{{$embed = concat($embed,concat2(concat(concat2(concat(concat2(concat1("<script type='text/javascript'>embed_wmedia('",$width),"', '"),$height),"', '"),$this->get_link()),"');</script>"));
}}}else 
{$embed = concat($embed,concat2(concat(concat2(concat(concat2(concat1('<a href="',$this->get_link()),'" class="'),$altclass),'">'),$alt),'</a>'));
}return $embed;
} }
function get_real_type ( $find_handler = array(false,false) ) {
{if ( (deAspis(Aspis_substr(Aspis_strtolower($this->get_link()),array(0,false),array(15,false))) === ('http://odeo.com')))
 {return array('odeo',false);
}$types_flash = array(array(array('application/x-shockwave-flash',false),array('application/futuresplash',false)),false);
$types_fmedia = array(array(array('video/flv',false),array('video/x-flv',false),array('flv-application/octet-stream',false)),false);
$types_quicktime = array(array(array('audio/3gpp',false),array('audio/3gpp2',false),array('audio/aac',false),array('audio/x-aac',false),array('audio/aiff',false),array('audio/x-aiff',false),array('audio/mid',false),array('audio/midi',false),array('audio/x-midi',false),array('audio/mp4',false),array('audio/m4a',false),array('audio/x-m4a',false),array('audio/wav',false),array('audio/x-wav',false),array('video/3gpp',false),array('video/3gpp2',false),array('video/m4v',false),array('video/x-m4v',false),array('video/mp4',false),array('video/mpeg',false),array('video/x-mpeg',false),array('video/quicktime',false),array('video/sd-video',false)),false);
$types_wmedia = array(array(array('application/asx',false),array('application/x-mplayer2',false),array('audio/x-ms-wma',false),array('audio/x-ms-wax',false),array('video/x-ms-asf-plugin',false),array('video/x-ms-asf',false),array('video/x-ms-wm',false),array('video/x-ms-wmv',false),array('video/x-ms-wvx',false)),false);
$types_mp3 = array(array(array('audio/mp3',false),array('audio/x-mp3',false),array('audio/mpeg',false),array('audio/x-mpeg',false)),false);
if ( (deAspis($this->get_type()) !== null))
 {$type = Aspis_strtolower($this->type);
}else 
{{$type = array(null,false);
}}if ( (denot_boolean(Aspis_in_array($type,Aspis_array_merge($types_flash,$types_fmedia,$types_quicktime,$types_wmedia,$types_mp3)))))
 {switch ( deAspis(Aspis_strtolower($this->get_extension())) ) {
case ('aac'):case ('adts'):$type = array('audio/acc',false);
break ;
case ('aif'):case ('aifc'):case ('aiff'):case ('cdda'):$type = array('audio/aiff',false);
break ;
case ('bwf'):$type = array('audio/wav',false);
break ;
case ('kar'):case ('mid'):case ('midi'):case ('smf'):$type = array('audio/midi',false);
break ;
case ('m4a'):$type = array('audio/x-m4a',false);
break ;
case ('mp3'):case ('swa'):$type = array('audio/mp3',false);
break ;
case ('wav'):$type = array('audio/wav',false);
break ;
case ('wax'):$type = array('audio/x-ms-wax',false);
break ;
case ('wma'):$type = array('audio/x-ms-wma',false);
break ;
case ('3gp'):case ('3gpp'):$type = array('video/3gpp',false);
break ;
case ('3g2'):case ('3gp2'):$type = array('video/3gpp2',false);
break ;
case ('asf'):$type = array('video/x-ms-asf',false);
break ;
case ('flv'):$type = array('video/x-flv',false);
break ;
case ('m1a'):case ('m1s'):case ('m1v'):case ('m15'):case ('m75'):case ('mp2'):case ('mpa'):case ('mpeg'):case ('mpg'):case ('mpm'):case ('mpv'):$type = array('video/mpeg',false);
break ;
case ('m4v'):$type = array('video/x-m4v',false);
break ;
case ('mov'):case ('qt'):$type = array('video/quicktime',false);
break ;
case ('mp4'):case ('mpg4'):$type = array('video/mp4',false);
break ;
case ('sdv'):$type = array('video/sd-video',false);
break ;
case ('wm'):$type = array('video/x-ms-wm',false);
break ;
case ('wmv'):$type = array('video/x-ms-wmv',false);
break ;
case ('wvx'):$type = array('video/x-ms-wvx',false);
break ;
case ('spl'):$type = array('application/futuresplash',false);
break ;
case ('swf'):$type = array('application/x-shockwave-flash',false);
break ;
 }
}if ( $find_handler[0])
 {if ( deAspis(Aspis_in_array($type,$types_flash)))
 {return array('flash',false);
}elseif ( deAspis(Aspis_in_array($type,$types_fmedia)))
 {return array('fmedia',false);
}elseif ( deAspis(Aspis_in_array($type,$types_quicktime)))
 {return array('quicktime',false);
}elseif ( deAspis(Aspis_in_array($type,$types_wmedia)))
 {return array('wmedia',false);
}elseif ( deAspis(Aspis_in_array($type,$types_mp3)))
 {return array('mp3',false);
}else 
{{return array(null,false);
}}}else 
{{return $type;
}}} }
}class SimplePie_Caption{var $type;
var $lang;
var $startTime;
var $endTime;
var $text;
function SimplePie_Caption ( $type = array(null,false),$lang = array(null,false),$startTime = array(null,false),$endTime = array(null,false),$text = array(null,false) ) {
{$this->type = $type;
$this->lang = $lang;
$this->startTime = $startTime;
$this->endTime = $endTime;
$this->text = $text;
} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize(array($this,false)))));
} }
function get_endtime (  ) {
{if ( ($this->endTime[0] !== null))
 {return $this->endTime;
}else 
{{return array(null,false);
}}} }
function get_language (  ) {
{if ( ($this->lang[0] !== null))
 {return $this->lang;
}else 
{{return array(null,false);
}}} }
function get_starttime (  ) {
{if ( ($this->startTime[0] !== null))
 {return $this->startTime;
}else 
{{return array(null,false);
}}} }
function get_text (  ) {
{if ( ($this->text[0] !== null))
 {return $this->text;
}else 
{{return array(null,false);
}}} }
function get_type (  ) {
{if ( ($this->type[0] !== null))
 {return $this->type;
}else 
{{return array(null,false);
}}} }
}class SimplePie_Credit{var $role;
var $scheme;
var $name;
function SimplePie_Credit ( $role = array(null,false),$scheme = array(null,false),$name = array(null,false) ) {
{$this->role = $role;
$this->scheme = $scheme;
$this->name = $name;
} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize(array($this,false)))));
} }
function get_role (  ) {
{if ( ($this->role[0] !== null))
 {return $this->role;
}else 
{{return array(null,false);
}}} }
function get_scheme (  ) {
{if ( ($this->scheme[0] !== null))
 {return $this->scheme;
}else 
{{return array(null,false);
}}} }
function get_name (  ) {
{if ( ($this->name[0] !== null))
 {return $this->name;
}else 
{{return array(null,false);
}}} }
}class SimplePie_Copyright{var $url;
var $label;
function SimplePie_Copyright ( $url = array(null,false),$label = array(null,false) ) {
{$this->url = $url;
$this->label = $label;
} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize(array($this,false)))));
} }
function get_url (  ) {
{if ( ($this->url[0] !== null))
 {return $this->url;
}else 
{{return array(null,false);
}}} }
function get_attribution (  ) {
{if ( ($this->label[0] !== null))
 {return $this->label;
}else 
{{return array(null,false);
}}} }
}class SimplePie_Rating{var $scheme;
var $value;
function SimplePie_Rating ( $scheme = array(null,false),$value = array(null,false) ) {
{$this->scheme = $scheme;
$this->value = $value;
} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize(array($this,false)))));
} }
function get_scheme (  ) {
{if ( ($this->scheme[0] !== null))
 {return $this->scheme;
}else 
{{return array(null,false);
}}} }
function get_value (  ) {
{if ( ($this->value[0] !== null))
 {return $this->value;
}else 
{{return array(null,false);
}}} }
}class SimplePie_Restriction{var $relationship;
var $type;
var $value;
function SimplePie_Restriction ( $relationship = array(null,false),$type = array(null,false),$value = array(null,false) ) {
{$this->relationship = $relationship;
$this->type = $type;
$this->value = $value;
} }
function __toString (  ) {
{return attAspis(md5(deAspis(Aspis_serialize(array($this,false)))));
} }
function get_relationship (  ) {
{if ( ($this->relationship[0] !== null))
 {return $this->relationship;
}else 
{{return array(null,false);
}}} }
function get_type (  ) {
{if ( ($this->type[0] !== null))
 {return $this->type;
}else 
{{return array(null,false);
}}} }
function get_value (  ) {
{if ( ($this->value[0] !== null))
 {return $this->value;
}else 
{{return array(null,false);
}}} }
}class SimplePie_File{var $url;
var $useragent;
var $success = array(true,false);
var $headers = array(array(),false);
var $body;
var $status_code;
var $redirects = array(0,false);
var $error;
var $method = array(SIMPLEPIE_FILE_SOURCE_NONE,false);
function SimplePie_File ( $url,$timeout = array(10,false),$redirects = array(5,false),$headers = array(null,false),$useragent = array(null,false),$force_fsockopen = array(false,false) ) {
{if ( class_exists(('idna_convert')))
 {$idn = array(new idna_convert,false);
$parsed = SimplePie_Misc::parse_url($url);
$url = SimplePie_Misc::compress_parse_url($parsed[0]['scheme'],$idn[0]->encode($parsed[0]['authority']),$parsed[0]['path'],$parsed[0]['query'],$parsed[0]['fragment']);
}$this->url = $url;
$this->useragent = $useragent;
if ( deAspis(Aspis_preg_match(array('/^http(s)?:\/\//i',false),$url)))
 {if ( ($useragent[0] === null))
 {$useragent = array(ini_get('user_agent'),false);
$this->useragent = $useragent;
}if ( (!(is_array($headers[0]))))
 {$headers = array(array(),false);
}if ( ((denot_boolean($force_fsockopen)) && function_exists(('curl_exec'))))
 {$this->method = array(SIMPLEPIE_FILE_SOURCE_REMOTE | SIMPLEPIE_FILE_SOURCE_CURL,false);
$fp = array(curl_init(),false);
$headers2 = array(array(),false);
foreach ( $headers[0] as $key =>$value )
{restoreTaint($key,$value);
{arrayAssignAdd($headers2[0][],addTaint(concat(concat2($key,": "),$value)));
}}if ( (version_compare(deAspisRC(SimplePie_Misc::get_curl_version()),'7.10.5','>=')))
 {curl_setopt(deAspisRC($fp),CURLOPT_ENCODING,'');
}curl_setopt(deAspisRC($fp),CURLOPT_URL,deAspisRC($url));
curl_setopt(deAspisRC($fp),CURLOPT_HEADER,1);
curl_setopt(deAspisRC($fp),CURLOPT_RETURNTRANSFER,1);
curl_setopt(deAspisRC($fp),CURLOPT_TIMEOUT,deAspisRC($timeout));
curl_setopt(deAspisRC($fp),CURLOPT_CONNECTTIMEOUT,deAspisRC($timeout));
curl_setopt(deAspisRC($fp),CURLOPT_REFERER,deAspisRC($url));
curl_setopt(deAspisRC($fp),CURLOPT_USERAGENT,deAspisRC($useragent));
curl_setopt(deAspisRC($fp),CURLOPT_HTTPHEADER,deAspisRC($headers2));
if ( (((!(ini_get('open_basedir'))) && (!(ini_get('safe_mode')))) && (version_compare(deAspisRC(SimplePie_Misc::get_curl_version()),'7.15.2','>='))))
 {curl_setopt(deAspisRC($fp),CURLOPT_FOLLOWLOCATION,1);
curl_setopt(deAspisRC($fp),CURLOPT_MAXREDIRS,deAspisRC($redirects));
}$this->headers = array(curl_exec(deAspisRC($fp)),false);
if ( (((curl_errno(deAspisRC($fp))) === (23)) || ((curl_errno(deAspisRC($fp))) === (61))))
 {curl_setopt(deAspisRC($fp),CURLOPT_ENCODING,'none');
$this->headers = array(curl_exec(deAspisRC($fp)),false);
}if ( (curl_errno(deAspisRC($fp))))
 {$this->error = concat2(concat2(concat12('cURL error ',curl_errno(deAspisRC($fp))),': '),curl_error(deAspisRC($fp)));
$this->success = array(false,false);
}else 
{{$info = array(curl_getinfo(deAspisRC($fp)),false);
curl_close(deAspisRC($fp));
$this->headers = Aspis_explode(array("\r\n\r\n",false),$this->headers,array(deAspis($info[0]['redirect_count']) + (1),false));
$this->headers = Aspis_array_pop($this->headers);
$parser = array(new SimplePie_HTTP_Parser($this->headers),false);
if ( deAspis($parser[0]->parse()))
 {$this->headers = $parser[0]->headers;
$this->body = $parser[0]->body;
$this->status_code = $parser[0]->status_code;
if ( (((deAspis(Aspis_in_array($this->status_code,array(array(array(300,false),array(301,false),array(302,false),array(303,false),array(307,false)),false))) || (($this->status_code[0] > (307)) && ($this->status_code[0] < (400)))) && ((isset($this->headers[0][('location')]) && Aspis_isset( $this ->headers [0][('location')] )))) && ($this->redirects[0] < $redirects[0])))
 {postincr($this->redirects);
$location = SimplePie_Misc::absolutize_url($this->headers[0][('location')],$url);
return $this->SimplePie_File($location,$timeout,$redirects,$headers,$useragent,$force_fsockopen);
}}}}}else 
{{$this->method = array(SIMPLEPIE_FILE_SOURCE_REMOTE | SIMPLEPIE_FILE_SOURCE_FSOCKOPEN,false);
$url_parts = Aspis_parse_url($url);
if ( (((isset($url_parts[0][('scheme')]) && Aspis_isset( $url_parts [0][('scheme')]))) && (deAspis(Aspis_strtolower($url_parts[0]['scheme'])) === ('https'))))
 {arrayAssign($url_parts[0],deAspis(registerTaint(array('host',false))),addTaint(concat1("ssl://",attachAspis($url_parts,host))));
arrayAssign($url_parts[0],deAspis(registerTaint(array('port',false))),addTaint(array(443,false)));
}if ( (!((isset($url_parts[0][('port')]) && Aspis_isset( $url_parts [0][('port')])))))
 {arrayAssign($url_parts[0],deAspis(registerTaint(array('port',false))),addTaint(array(80,false)));
}$fp = @AspisInternalFunctionCall("fsockopen",deAspis($url_parts[0]['host']),deAspis($url_parts[0]['port']),AspisPushRefParam($errno),AspisPushRefParam($errstr),$timeout[0],array(2,3));
if ( (denot_boolean($fp)))
 {$this->error = concat1('fsockopen error: ',$errstr);
$this->success = array(false,false);
}else 
{{stream_set_timeout(deAspisRC($fp),deAspisRC($timeout));
if ( ((isset($url_parts[0][('path')]) && Aspis_isset( $url_parts [0][('path')]))))
 {if ( ((isset($url_parts[0][('query')]) && Aspis_isset( $url_parts [0][('query')]))))
 {$get = concat(concat2(attachAspis($url_parts,path),"?"),attachAspis($url_parts,query));
}else 
{{$get = $url_parts[0]['path'];
}}}else 
{{$get = array('/',false);
}}$out = concat2(concat1("GET ",$get)," HTTP/1.0\r\n");
$out = concat($out,concat2(concat1("Host: ",attachAspis($url_parts,host)),"\r\n"));
$out = concat($out,concat2(concat1("User-Agent: ",$useragent),"\r\n"));
if ( (extension_loaded('zlib')))
 {$out = concat2($out,"Accept-Encoding: x-gzip,gzip,deflate\r\n");
}if ( (((isset($url_parts[0][('user')]) && Aspis_isset( $url_parts [0][('user')]))) && ((isset($url_parts[0][('pass')]) && Aspis_isset( $url_parts [0][('pass')])))))
 {$out = concat($out,concat2(concat1("Authorization: Basic ",Aspis_base64_encode(concat(concat2(attachAspis($url_parts,user),":"),attachAspis($url_parts,pass)))),"\r\n"));
}foreach ( $headers[0] as $key =>$value )
{restoreTaint($key,$value);
{$out = concat($out,concat2(concat(concat2($key,": "),$value),"\r\n"));
}}$out = concat2($out,"Connection: Close\r\n\r\n");
fwrite($fp[0],$out[0]);
$info = attAspisRC(stream_get_meta_data($fp[0]));
$this->headers = array('',false);
while ( ((denot_boolean($info[0]['eof'])) && (denot_boolean($info[0]['timed_out']))) )
{$this->headers = concat($this->headers ,attAspis(fread($fp[0],(1160))));
$info = attAspisRC(stream_get_meta_data($fp[0]));
}if ( (denot_boolean($info[0]['timed_out'])))
 {$parser = array(new SimplePie_HTTP_Parser($this->headers),false);
if ( deAspis($parser[0]->parse()))
 {$this->headers = $parser[0]->headers;
$this->body = $parser[0]->body;
$this->status_code = $parser[0]->status_code;
if ( (((deAspis(Aspis_in_array($this->status_code,array(array(array(300,false),array(301,false),array(302,false),array(303,false),array(307,false)),false))) || (($this->status_code[0] > (307)) && ($this->status_code[0] < (400)))) && ((isset($this->headers[0][('location')]) && Aspis_isset( $this ->headers [0][('location')] )))) && ($this->redirects[0] < $redirects[0])))
 {postincr($this->redirects);
$location = SimplePie_Misc::absolutize_url($this->headers[0][('location')],$url);
return $this->SimplePie_File($location,$timeout,$redirects,$headers,$useragent,$force_fsockopen);
}if ( ((isset($this->headers[0][('content-encoding')]) && Aspis_isset( $this ->headers [0][('content-encoding')] ))))
 {switch ( deAspis(Aspis_strtolower(Aspis_trim($this->headers[0][('content-encoding')],array("\x09\x0A\x0D\x20",false)))) ) {
case ('gzip'):case ('x-gzip'):$decoder = array(new SimplePie_gzdecode($this->body),false);
if ( (denot_boolean($decoder[0]->parse())))
 {$this->error = array('Unable to decode HTTP "gzip" stream',false);
$this->success = array(false,false);
}else 
{{$this->body = $decoder[0]->data;
}}break ;
case ('deflate'):if ( (deAspis(($body = array(gzuncompress(deAspisRC($this->body)),false))) === false))
 {if ( (deAspis(($body = array(gzinflate(deAspisRC($this->body)),false))) === false))
 {$this->error = array('Unable to decode HTTP "deflate" stream',false);
$this->success = array(false,false);
}}$this->body = $body;
break ;
default :$this->error = array('Unknown content coding',false);
$this->success = array(false,false);
 }
}}}else 
{{$this->error = array('fsocket timed out',false);
$this->success = array(false,false);
}}fclose($fp[0]);
}}}}}else 
{{$this->method = array(SIMPLEPIE_FILE_SOURCE_LOCAL | SIMPLEPIE_FILE_SOURCE_FILE_GET_CONTENTS,false);
if ( (denot_boolean($this->body = attAspis(file_get_contents($url[0])))))
 {$this->error = array('file_get_contents could not read the file',false);
$this->success = array(false,false);
}}}} }
}class SimplePie_HTTP_Parser{var $http_version = array(0.0,false);
var $status_code = array(0,false);
var $reason = array('',false);
var $headers = array(array(),false);
var $body = array('',false);
var $state = array('http_version',false);
var $data = array('',false);
var $data_length = array(0,false);
var $position = array(0,false);
var $name = array('',false);
var $value = array('',false);
function SimplePie_HTTP_Parser ( $data ) {
{$this->data = $data;
$this->data_length = attAspis(strlen($this->data[0]));
} }
function parse (  ) {
{while ( (($this->state[0] && ($this->state[0] !== ('emit'))) && deAspis($this->has_data())) )
{$state = $this->state;
AspisDynamicCall(array(array($this,$state),false));
}$this->data = array('',false);
if ( (($this->state[0] === ('emit')) || ($this->state[0] === ('body'))))
 {return array(true,false);
}else 
{{$this->http_version = array('',false);
$this->status_code = array('',false);
$this->reason = array('',false);
$this->headers = array(array(),false);
$this->body = array('',false);
return array(false,false);
}}} }
function has_data (  ) {
{return bool_cast((array($this->position[0] < $this->data_length[0],false)));
} }
function is_linear_whitespace (  ) {
{return bool_cast((array((($this->data[0][$this->position[0]][0] === ("\x09")) || ($this->data[0][$this->position[0]][0] === ("\x20"))) || ((($this->data[0][$this->position[0]][0] === ("\x0A")) && ((isset($this->data[0][($this->position[0] + (1))]) && Aspis_isset( $this ->data [0][($this ->position [0] + (1))] )))) && (($this->data[0][($this->position[0] + (1))][0] === ("\x09")) || ($this->data[0][($this->position[0] + (1))][0] === ("\x20")))),false)));
} }
function http_version (  ) {
{if ( ((strpos($this->data[0],"\x0A") !== false) && (deAspis(Aspis_strtoupper(Aspis_substr($this->data,array(0,false),array(5,false)))) === ('HTTP/'))))
 {$len = attAspis(strspn($this->data[0],('0123456789.'),(5)));
$this->http_version = Aspis_substr($this->data,array(5,false),$len);
$this->position = array(((5) + $len[0]) + $this->position [0],false);
if ( (substr_count($this->http_version[0],('.')) <= (1)))
 {$this->http_version = float_cast($this->http_version);
$this->position = array(strspn($this->data[0],("\x09\x20"),$this->position[0]) + $this->position [0],false);
$this->state = array('status',false);
}else 
{{$this->state = array(false,false);
}}}else 
{{$this->state = array(false,false);
}}} }
function status (  ) {
{if ( deAspis($len = attAspis(strspn($this->data[0],('0123456789'),$this->position[0]))))
 {$this->status_code = int_cast(Aspis_substr($this->data,$this->position,$len));
$this->position = array($len[0] + $this->position [0],false);
$this->state = array('reason',false);
}else 
{{$this->state = array(false,false);
}}} }
function reason (  ) {
{$len = attAspis(strcspn($this->data[0],("\x0A"),$this->position[0]));
$this->reason = Aspis_trim(Aspis_substr($this->data,$this->position,$len),array("\x09\x0D\x20",false));
$this->position = array(($len[0] + (1)) + $this->position [0],false);
$this->state = array('new_line',false);
} }
function new_line (  ) {
{$this->value = Aspis_trim($this->value,array("\x0D\x20",false));
if ( (($this->name[0] !== ('')) && ($this->value[0] !== (''))))
 {$this->name = Aspis_strtolower($this->name);
if ( ((isset($this->headers[0][$this->name[0]]) && Aspis_isset( $this ->headers [0][$this ->name [0]] ))))
 {arrayAssign($this->headers[0],deAspis(registerTaint($this->name)),addTaint(concat($this->headers[0][$this->name [0]] ,concat1(', ',$this->value))));
}else 
{{arrayAssign($this->headers[0],deAspis(registerTaint($this->name)),addTaint($this->value));
}}}$this->name = array('',false);
$this->value = array('',false);
if ( (deAspis(Aspis_substr($this->data[0][$this->position[0]],array(0,false),array(2,false))) === ("\x0D\x0A")))
 {$this->position = array((2) + $this->position [0],false);
$this->state = array('body',false);
}elseif ( ($this->data[0][$this->position[0]][0] === ("\x0A")))
 {postincr($this->position);
$this->state = array('body',false);
}else 
{{$this->state = array('name',false);
}}} }
function name (  ) {
{$len = attAspis(strcspn($this->data[0],("\x0A:"),$this->position[0]));
if ( ((isset($this->data[0][($this->position[0] + $len[0])]) && Aspis_isset( $this ->data [0][($this ->position [0] + $len[0])] ))))
 {if ( ($this->data[0][($this->position[0] + $len[0])][0] === ("\x0A")))
 {$this->position = array($len[0] + $this->position [0],false);
$this->state = array('new_line',false);
}else 
{{$this->name = Aspis_substr($this->data,$this->position,$len);
$this->position = array(($len[0] + (1)) + $this->position [0],false);
$this->state = array('value',false);
}}}else 
{{$this->state = array(false,false);
}}} }
function linear_whitespace (  ) {
{do {if ( (deAspis(Aspis_substr($this->data,$this->position,array(2,false))) === ("\x0D\x0A")))
 {$this->position = array((2) + $this->position [0],false);
}elseif ( ($this->data[0][$this->position[0]][0] === ("\x0A")))
 {postincr($this->position);
}$this->position = array(strspn($this->data[0],("\x09\x20"),$this->position[0]) + $this->position [0],false);
}while ((deAspis($this->has_data()) && deAspis($this->is_linear_whitespace())) )
;
$this->value = concat2($this->value ,"\x20");
} }
function value (  ) {
{if ( deAspis($this->is_linear_whitespace()))
 {$this->linear_whitespace();
}else 
{{switch ( $this->data[0][$this->position[0]][0] ) {
case ('"'):postincr($this->position);
$this->state = array('quote',false);
break ;
case ("\x0A"):postincr($this->position);
$this->state = array('new_line',false);
break ;
default :$this->state = array('value_char',false);
break ;
 }
}}} }
function value_char (  ) {
{$len = attAspis(strcspn($this->data[0],("\x09\x20\x0A\""),$this->position[0]));
$this->value = concat($this->value ,Aspis_substr($this->data,$this->position,$len));
$this->position = array($len[0] + $this->position [0],false);
$this->state = array('value',false);
} }
function quote (  ) {
{if ( deAspis($this->is_linear_whitespace()))
 {$this->linear_whitespace();
}else 
{{switch ( $this->data[0][$this->position[0]][0] ) {
case ('"'):postincr($this->position);
$this->state = array('value',false);
break ;
case ("\x0A"):postincr($this->position);
$this->state = array('new_line',false);
break ;
case ('\\'):postincr($this->position);
$this->state = array('quote_escaped',false);
break ;
default :$this->state = array('quote_char',false);
break ;
 }
}}} }
function quote_char (  ) {
{$len = attAspis(strcspn($this->data[0],("\x09\x20\x0A\"\\"),$this->position[0]));
$this->value = concat($this->value ,Aspis_substr($this->data,$this->position,$len));
$this->position = array($len[0] + $this->position [0],false);
$this->state = array('value',false);
} }
function quote_escaped (  ) {
{$this->value = concat($this->value ,$this->data[0][$this->position[0]]);
postincr($this->position);
$this->state = array('quote',false);
} }
function body (  ) {
{$this->body = Aspis_substr($this->data,$this->position);
$this->state = array('emit',false);
} }
}class SimplePie_gzdecode{var $compressed_data;
var $compressed_size;
var $min_compressed_size = array(18,false);
var $position = array(0,false);
var $flags;
var $data;
var $MTIME;
var $XFL;
var $OS;
var $SI1;
var $SI2;
var $extra_field;
var $filename;
var $comment;
function __set ( $name,$value ) {
{trigger_error((deconcat1("Cannot write property ",$name)),E_USER_ERROR);
} }
function SimplePie_gzdecode ( $data ) {
{$this->compressed_data = $data;
$this->compressed_size = attAspis(strlen($data[0]));
} }
function parse (  ) {
{if ( ($this->compressed_size[0] >= $this->min_compressed_size[0]))
 {if ( (deAspis(Aspis_substr($this->compressed_data,array(0,false),array(3,false))) !== ("\x1F\x8B\x08")))
 {return array(false,false);
}$this->flags = attAspis(ord($this->compressed_data[0][(3)][0]));
if ( ($this->flags[0] > (0x1F)))
 {return array(false,false);
}$this->position = array((4) + $this->position [0],false);
$mtime = Aspis_substr($this->compressed_data,$this->position,array(4,false));
if ( (deAspis(Aspis_current(attAspisRC(unpack(('S'),("\x00\x01"))))) === (1)))
 {$mtime = Aspis_strrev($mtime);
}$this->MTIME = Aspis_current(attAspisRC(unpack(('l'),$mtime[0])));
$this->position = array((4) + $this->position [0],false);
$this->XFL = attAspis(ord($this->compressed_data[0][deAspis(postincr($this->position))][0]));
$this->OS = attAspis(ord($this->compressed_data[0][deAspis(postincr($this->position))][0]));
if ( ($this->flags[0] & (4)))
 {$this->SI1 = $this->compressed_data[0][deAspis(postincr($this->position))];
$this->SI2 = $this->compressed_data[0][deAspis(postincr($this->position))];
if ( ($this->SI2[0] === ("\x00")))
 {return array(false,false);
}$len = Aspis_current(attAspisRC(unpack(('v'),deAspis(Aspis_substr($this->compressed_data,$this->position,array(2,false))))));
$position = array((2) + $position[0],false);
$this->min_compressed_size = array(($len[0] + (4)) + $this->min_compressed_size [0],false);
if ( ($this->compressed_size[0] >= $this->min_compressed_size[0]))
 {$this->extra_field = Aspis_substr($this->compressed_data,$this->position,$len);
$this->position = array($len[0] + $this->position [0],false);
}else 
{{return array(false,false);
}}}if ( ($this->flags[0] & (8)))
 {$len = attAspis(strcspn($this->compressed_data[0],("\x00"),$this->position[0]));
$this->min_compressed_size = array(($len[0] + (1)) + $this->min_compressed_size [0],false);
if ( ($this->compressed_size[0] >= $this->min_compressed_size[0]))
 {$this->filename = Aspis_substr($this->compressed_data,$this->position,$len);
$this->position = array(($len[0] + (1)) + $this->position [0],false);
}else 
{{return array(false,false);
}}}if ( ($this->flags[0] & (16)))
 {$len = attAspis(strcspn($this->compressed_data[0],("\x00"),$this->position[0]));
$this->min_compressed_size = array(($len[0] + (1)) + $this->min_compressed_size [0],false);
if ( ($this->compressed_size[0] >= $this->min_compressed_size[0]))
 {$this->comment = Aspis_substr($this->compressed_data,$this->position,$len);
$this->position = array(($len[0] + (1)) + $this->position [0],false);
}else 
{{return array(false,false);
}}}if ( ($this->flags[0] & (2)))
 {$this->min_compressed_size = array(($len[0] + (2)) + $this->min_compressed_size [0],false);
if ( ($this->compressed_size[0] >= $this->min_compressed_size[0]))
 {$crc = Aspis_current(attAspisRC(unpack(('v'),deAspis(Aspis_substr($this->compressed_data,$this->position,array(2,false))))));
if ( ((crc32(deAspis(Aspis_substr($this->compressed_data,array(0,false),$this->position))) & (0xFFFF)) === $crc[0]))
 {$this->position = array((2) + $this->position [0],false);
}else 
{{return array(false,false);
}}}else 
{{return array(false,false);
}}}if ( (deAspis(($this->data = array(gzinflate(deAspisRC(Aspis_substr($this->compressed_data,$this->position,negate(array(8,false))))),false))) === false))
 {return array(false,false);
}else 
{{$this->position = array($this->compressed_size[0] - (8),false);
}}$crc = Aspis_current(attAspisRC(unpack(('V'),deAspis(Aspis_substr($this->compressed_data,$this->position,array(4,false))))));
$this->position = array((4) + $this->position [0],false);
$isize = Aspis_current(attAspisRC(unpack(('V'),deAspis(Aspis_substr($this->compressed_data,$this->position,array(4,false))))));
$this->position = array((4) + $this->position [0],false);
if ( (deAspis(Aspis_sprintf(array('%u',false),array(strlen($this->data[0]) & (0xFFFFFFFF),false))) !== deAspis(Aspis_sprintf(array('%u',false),$isize))))
 {return array(false,false);
}return array(true,false);
}else 
{{return array(false,false);
}}} }
}class SimplePie_Cache{function SimplePie_Cache (  ) {
{trigger_error('Please call SimplePie_Cache::create() instead of the constructor',E_USER_ERROR);
} }
function create ( $location,$filename,$extension ) {
{$location_iri = array(new SimplePie_IRI($location),false);
switch ( deAspis($location_iri[0]->get_scheme()) ) {
case ('mysql'):if ( (extension_loaded('mysql')))
 {return array(new SimplePie_Cache_MySQL($location_iri,$filename,$extension),false);
}break ;
default :return array(new SimplePie_Cache_File($location,$filename,$extension),false);
 }
} }
}class SimplePie_Cache_File{var $location;
var $filename;
var $extension;
var $name;
function SimplePie_Cache_File ( $location,$filename,$extension ) {
{$this->location = $location;
$this->filename = $filename;
$this->extension = $extension;
$this->name = concat(concat2(concat(concat2($this->location,"/"),$this->filename),"."),$this->extension);
} }
function save ( $data ) {
{if ( ((file_exists($this->name[0]) && (is_writeable(deAspisRC($this->name)))) || (file_exists($this->location[0]) && (is_writeable(deAspisRC($this->location))))))
 {if ( is_a(deAspisRC($data),('SimplePie')))
 {$data = $data[0]->data;
}$data = Aspis_serialize($data);
if ( function_exists(('file_put_contents')))
 {return bool_cast(array(file_put_contents(deAspisRC($this->name),deAspisRC($data)),false));
}else 
{{$fp = attAspis(fopen($this->name[0],('wb')));
if ( $fp[0])
 {fwrite($fp[0],$data[0]);
fclose($fp[0]);
return array(true,false);
}}}}return array(false,false);
} }
function load (  ) {
{if ( (file_exists($this->name[0]) && is_readable($this->name[0])))
 {return Aspis_unserialize(attAspis(file_get_contents($this->name[0])));
}return array(false,false);
} }
function mtime (  ) {
{if ( file_exists($this->name[0]))
 {return attAspis(filemtime($this->name[0]));
}return array(false,false);
} }
function touch (  ) {
{if ( file_exists($this->name[0]))
 {return attAspis(touch($this->name[0]));
}return array(false,false);
} }
function unlink (  ) {
{if ( file_exists($this->name[0]))
 {return attAspis(unlink($this->name[0]));
}return array(false,false);
} }
}class SimplePie_Cache_DB{function prepare_simplepie_object_for_cache ( $data ) {
{$items = $data[0]->get_items();
$items_by_id = array(array(),false);
if ( (!((empty($items) || Aspis_empty( $items)))))
 {foreach ( $items[0] as $item  )
{arrayAssign($items_by_id[0],deAspis(registerTaint($item[0]->get_id())),addTaint($item));
}if ( (count($items_by_id[0]) !== count($items[0])))
 {$items_by_id = array(array(),false);
foreach ( $items[0] as $item  )
{arrayAssign($items_by_id[0],deAspis(registerTaint($item[0]->get_id(array(true,false)))),addTaint($item));
}}if ( ((isset($data[0]->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('feed')][0][(0)]) && Aspis_isset( $data[0] ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('feed')] [0][(0)] ))))
 {$channel = &$data[0]->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('feed')][0][(0)];
}elseif ( ((isset($data[0]->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('feed')][0][(0)]) && Aspis_isset( $data[0] ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('feed')] [0][(0)] ))))
 {$channel = &$data[0]->data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('feed')][0][(0)];
}elseif ( ((isset($data[0]->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)]) && Aspis_isset( $data[0] ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)] ))))
 {$channel = &$data[0]->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)];
}elseif ( ((isset($data[0]->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('channel')][0][(0)]) && Aspis_isset( $data[0] ->data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_20] [0][('rss')] [0][(0)] [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_20] [0][('channel')] [0][(0)] ))))
 {$channel = &$data[0]->data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')][0][(0)][0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('channel')][0][(0)];
}else 
{{$channel = array(null,false);
}}if ( ($channel[0] !== null))
 {if ( ((isset($channel[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('entry')]) && Aspis_isset( $channel [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('entry')]))))
 {unset($channel[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('entry')]);
}if ( ((isset($channel[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('entry')]) && Aspis_isset( $channel [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('entry')]))))
 {unset($channel[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('entry')]);
}if ( ((isset($channel[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_10][0][('item')]) && Aspis_isset( $channel [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_10] [0][('item')]))))
 {unset($channel[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_10][0][('item')]);
}if ( ((isset($channel[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_090][0][('item')]) && Aspis_isset( $channel [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_090] [0][('item')]))))
 {unset($channel[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_090][0][('item')]);
}if ( ((isset($channel[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('item')]) && Aspis_isset( $channel [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_20] [0][('item')]))))
 {unset($channel[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('item')]);
}}if ( ((isset($data[0]->data[0][('items')]) && Aspis_isset( $data[0] ->data [0][('items')] ))))
 {unset($data[0]->data[0][('items')]);
}if ( ((isset($data[0]->data[0][('ordered_items')]) && Aspis_isset( $data[0] ->data [0][('ordered_items')] ))))
 {unset($data[0]->data[0][('ordered_items')]);
}}return array(array(Aspis_serialize($data[0]->data),$items_by_id),false);
} }
}class SimplePie_Cache_MySQL extends SimplePie_Cache_DB{var $mysql;
var $options;
var $id;
function SimplePie_Cache_MySQL ( $mysql_location,$name,$extension ) {
{$host = $mysql_location[0]->get_host();
if ( ((deAspis(SimplePie_Misc::stripos($host,array('unix(',false))) === (0)) && (deAspis(Aspis_substr($host,negate(array(1,false)))) === (')'))))
 {$server = concat1(':',Aspis_substr($host,array(5,false),negate(array(1,false))));
}else 
{{$server = $host;
if ( (deAspis($mysql_location[0]->get_port()) !== null))
 {$server = concat($server,concat1(':',$mysql_location[0]->get_port()));
}}}if ( (strpos(deAspis($mysql_location[0]->get_userinfo()),':') !== false))
 {list($username,$password) = deAspisList(Aspis_explode(array(':',false),$mysql_location[0]->get_userinfo(),array(2,false)),array());
}else 
{{$username = $mysql_location[0]->get_userinfo();
$password = array(null,false);
}}if ( deAspis($this->mysql = attAspis(mysql_connect($server[0],$username[0],$password[0]))))
 {$this->id = concat($name,$extension);
$this->options = SimplePie_Misc::parse_str($mysql_location[0]->get_query());
if ( (!((isset($this->options[0][('prefix')][0][(0)]) && Aspis_isset( $this ->options [0][('prefix')] [0][(0)] )))))
 {arrayAssign($this->options[0][('prefix')][0],deAspis(registerTaint(array(0,false))),addTaint(array('',false)));
}if ( ((mysql_select_db(deAspis(Aspis_ltrim($mysql_location[0]->get_path(),array('/',false)))) && mysql_query(('SET NAMES utf8'))) && deAspis(($query = attAspis(mysql_unbuffered_query(('SHOW TABLES')))))))
 {$db = array(array(),false);
while ( deAspis($row = attAspisRC(mysql_fetch_row($query[0]))) )
{arrayAssignAdd($db[0][],addTaint(attachAspis($row,(0))));
}if ( (denot_boolean(Aspis_in_array(concat2($this->options[0][('prefix')][0][(0)],'cache_data'),$db))))
 {if ( (!(mysql_query((deconcat2(concat1('CREATE TABLE `',$this->options[0][('prefix')][0][(0)]),'cache_data` (`id` TEXT CHARACTER SET utf8 NOT NULL, `items` SMALLINT NOT NULL DEFAULT 0, `data` BLOB NOT NULL, `mtime` INT UNSIGNED NOT NULL, UNIQUE (`id`(125)))'))))))
 {$this->mysql = array(null,false);
}}if ( (denot_boolean(Aspis_in_array(concat2($this->options[0][('prefix')][0][(0)],'items'),$db))))
 {if ( (!(mysql_query((deconcat2(concat1('CREATE TABLE `',$this->options[0][('prefix')][0][(0)]),'items` (`feed_id` TEXT CHARACTER SET utf8 NOT NULL, `id` TEXT CHARACTER SET utf8 NOT NULL, `data` TEXT CHARACTER SET utf8 NOT NULL, `posted` INT UNSIGNED NOT NULL, INDEX `feed_id` (`feed_id`(125)))'))))))
 {$this->mysql = array(null,false);
}}}else 
{{$this->mysql = array(null,false);
}}}} }
function save ( $data ) {
{if ( $this->mysql[0])
 {$feed_id = concat2(concat1("'",Aspis_mysql_real_escape_string($this->id)),"'");
if ( is_a(deAspisRC($data),('SimplePie')))
 {if ( SIMPLEPIE_PHP5)
 {$data = array(clone ($data[0]),false);
}$prepared = $this->prepare_simplepie_object_for_cache($data);
if ( deAspis($query = attAspis(mysql_query((deconcat(concat2(concat1('SELECT `id` FROM `',$this->options[0][('prefix')][0][(0)]),'cache_data` WHERE `id` = '),$feed_id)),$this->mysql[0]))))
 {if ( mysql_num_rows($query[0]))
 {$items = attAspis(count(deAspis(attachAspis($prepared,(1)))));
if ( $items[0])
 {$sql = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('UPDATE `',$this->options[0][('prefix')][0][(0)]),'cache_data` SET `items` = '),$items),', `data` = \''),Aspis_mysql_real_escape_string(attachAspis($prepared,(0)))),'\', `mtime` = '),attAspis(time())),' WHERE `id` = '),$feed_id);
}else 
{{$sql = concat(concat2(concat(concat2(concat(concat2(concat1('UPDATE `',$this->options[0][('prefix')][0][(0)]),'cache_data` SET `data` = \''),Aspis_mysql_real_escape_string(attachAspis($prepared,(0)))),'\', `mtime` = '),attAspis(time())),' WHERE `id` = '),$feed_id);
}}if ( (!(mysql_query($sql[0],$this->mysql[0]))))
 {return array(false,false);
}}elseif ( (!(mysql_query((deconcat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('INSERT INTO `',$this->options[0][('prefix')][0][(0)]),'cache_data` (`id`, `items`, `data`, `mtime`) VALUES('),$feed_id),', '),attAspis(count(deAspis(attachAspis($prepared,(1)))))),', \''),Aspis_mysql_real_escape_string(attachAspis($prepared,(0)))),'\', '),attAspis(time())),')')),$this->mysql[0]))))
 {return array(false,false);
}$ids = attAspisRC(array_keys(deAspisRC(attachAspis($prepared,(1)))));
if ( (!((empty($ids) || Aspis_empty( $ids)))))
 {foreach ( $ids[0] as $id  )
{arrayAssignAdd($database_ids[0][],addTaint(Aspis_mysql_real_escape_string($id)));
}if ( deAspis($query = attAspis(mysql_unbuffered_query((deconcat(concat2(concat(concat2(concat1('SELECT `id` FROM `',$this->options[0][('prefix')][0][(0)]),'items` WHERE `id` = \''),Aspis_implode(array('\' OR `id` = \'',false),$database_ids)),'\' AND `feed_id` = '),$feed_id)),$this->mysql[0]))))
 {$existing_ids = array(array(),false);
while ( deAspis($row = attAspisRC(mysql_fetch_row($query[0]))) )
{arrayAssignAdd($existing_ids[0][],addTaint(attachAspis($row,(0))));
}$new_ids = Aspis_array_diff($ids,$existing_ids);
foreach ( $new_ids[0] as $new_id  )
{if ( (denot_boolean(($date = $prepared[0][(1)][0][$new_id[0]][0]->get_date(array('U',false))))))
 {$date = attAspis(time());
}if ( (!(mysql_query((deconcat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('INSERT INTO `',$this->options[0][('prefix')][0][(0)]),'items` (`feed_id`, `id`, `data`, `posted`) VALUES('),$feed_id),', \''),Aspis_mysql_real_escape_string($new_id)),'\', \''),Aspis_mysql_real_escape_string(Aspis_serialize($prepared[0][(1)][0][$new_id[0]][0]->data))),'\', '),$date),')')),$this->mysql[0]))))
 {return array(false,false);
}}return array(true,false);
}}else 
{{return array(true,false);
}}}}elseif ( deAspis($query = attAspis(mysql_query((deconcat(concat2(concat1('SELECT `id` FROM `',$this->options[0][('prefix')][0][(0)]),'cache_data` WHERE `id` = '),$feed_id)),$this->mysql[0]))))
 {if ( mysql_num_rows($query[0]))
 {if ( mysql_query((deconcat(concat2(concat(concat2(concat(concat2(concat1('UPDATE `',$this->options[0][('prefix')][0][(0)]),'cache_data` SET `items` = 0, `data` = \''),Aspis_mysql_real_escape_string(Aspis_serialize($data))),'\', `mtime` = '),attAspis(time())),' WHERE `id` = '),$feed_id)),$this->mysql[0]))
 {return array(true,false);
}}elseif ( mysql_query((deconcat2(concat(concat2(concat(concat2(concat(concat2(concat1('INSERT INTO `',$this->options[0][('prefix')][0][(0)]),'cache_data` (`id`, `items`, `data`, `mtime`) VALUES(\''),Aspis_mysql_real_escape_string($this->id)),'\', 0, \''),Aspis_mysql_real_escape_string(Aspis_serialize($data))),'\', '),attAspis(time())),')')),$this->mysql[0]))
 {return array(true,false);
}}}return array(false,false);
} }
function load (  ) {
{if ( (($this->mysql[0] && deAspis(($query = attAspis(mysql_query((deconcat2(concat(concat2(concat1('SELECT `items`, `data` FROM `',$this->options[0][('prefix')][0][(0)]),'cache_data` WHERE `id` = \''),Aspis_mysql_real_escape_string($this->id)),"'")),$this->mysql[0]))))) && deAspis(($row = attAspisRC(mysql_fetch_row($query[0]))))))
 {$data = Aspis_unserialize(attachAspis($row,(1)));
if ( ((isset($this->options[0][('items')][0][(0)]) && Aspis_isset( $this ->options [0][('items')] [0][(0)] ))))
 {$items = int_cast($this->options[0][('items')][0][(0)]);
}else 
{{$items = int_cast(attachAspis($row,(0)));
}}if ( ($items[0] !== (0)))
 {if ( ((isset($data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('feed')][0][(0)]) && Aspis_isset( $data [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_10] [0][('feed')] [0][(0)]))))
 {$feed = &$data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('feed')][0][(0)];
}elseif ( ((isset($data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('feed')][0][(0)]) && Aspis_isset( $data [0][('child')] [0][SIMPLEPIE_NAMESPACE_ATOM_03] [0][('feed')] [0][(0)]))))
 {$feed = &$data[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_03][0][('feed')][0][(0)];
}elseif ( ((isset($data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)]) && Aspis_isset( $data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RDF] [0][('RDF')] [0][(0)]))))
 {$feed = &$data[0][('child')][0][SIMPLEPIE_NAMESPACE_RDF][0][('RDF')][0][(0)];
}elseif ( ((isset($data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')][0][(0)]) && Aspis_isset( $data [0][('child')] [0][SIMPLEPIE_NAMESPACE_RSS_20] [0][('rss')] [0][(0)]))))
 {$feed = &$data[0][('child')][0][SIMPLEPIE_NAMESPACE_RSS_20][0][('rss')][0][(0)];
}else 
{{$feed = array(null,false);
}}if ( ($feed[0] !== null))
 {$sql = concat2(concat(concat2(concat1('SELECT `data` FROM `',$this->options[0][('prefix')][0][(0)]),'items` WHERE `feed_id` = \''),Aspis_mysql_real_escape_string($this->id)),'\' ORDER BY `posted` DESC');
if ( ($items[0] > (0)))
 {$sql = concat($sql,concat1(' LIMIT ',$items));
}if ( deAspis($query = attAspis(mysql_unbuffered_query($sql[0],$this->mysql[0]))))
 {while ( deAspis($row = attAspisRC(mysql_fetch_row($query[0]))) )
{arrayAssignAdd($feed[0][('child')][0][SIMPLEPIE_NAMESPACE_ATOM_10][0][('entry')][0][],addTaint(Aspis_unserialize(attachAspis($row,(0)))));
}}else 
{{return array(false,false);
}}}}return $data;
}return array(false,false);
} }
function mtime (  ) {
{if ( (($this->mysql[0] && deAspis(($query = attAspis(mysql_query((deconcat2(concat(concat2(concat1('SELECT `mtime` FROM `',$this->options[0][('prefix')][0][(0)]),'cache_data` WHERE `id` = \''),Aspis_mysql_real_escape_string($this->id)),"'")),$this->mysql[0]))))) && deAspis(($row = attAspisRC(mysql_fetch_row($query[0]))))))
 {return attachAspis($row,(0));
}else 
{{return array(false,false);
}}} }
function touch (  ) {
{if ( (($this->mysql[0] && deAspis(($query = attAspis(mysql_query((deconcat2(concat(concat2(concat(concat2(concat1('UPDATE `',$this->options[0][('prefix')][0][(0)]),'cache_data` SET `mtime` = '),attAspis(time())),' WHERE `id` = \''),Aspis_mysql_real_escape_string($this->id)),"'")),$this->mysql[0]))))) && mysql_affected_rows($this->mysql[0])))
 {return array(true,false);
}else 
{{return array(false,false);
}}} }
function unlink (  ) {
{if ( (($this->mysql[0] && deAspis(($query = attAspis(mysql_query((deconcat2(concat(concat2(concat1('DELETE FROM `',$this->options[0][('prefix')][0][(0)]),'cache_data` WHERE `id` = \''),Aspis_mysql_real_escape_string($this->id)),"'")),$this->mysql[0]))))) && deAspis(($query2 = attAspis(mysql_query((deconcat2(concat(concat2(concat1('DELETE FROM `',$this->options[0][('prefix')][0][(0)]),'items` WHERE `feed_id` = \''),Aspis_mysql_real_escape_string($this->id)),"'")),$this->mysql[0]))))))
 {return array(true,false);
}else 
{{return array(false,false);
}}} }
}class SimplePie_Misc{function time_hms ( $seconds ) {
{$time = array('',false);
$hours = attAspis(floor(($seconds[0] / (3600))));
$remainder = array($seconds[0] % (3600),false);
if ( ($hours[0] > (0)))
 {$time = concat($time,concat2($hours,':'));
}$minutes = attAspis(floor(($remainder[0] / (60))));
$seconds = array($remainder[0] % (60),false);
if ( (($minutes[0] < (10)) && ($hours[0] > (0))))
 {$minutes = concat1('0',$minutes);
}if ( ($seconds[0] < (10)))
 {$seconds = concat1('0',$seconds);
}$time = concat($time,concat2($minutes,':'));
$time = concat($time,$seconds);
return $time;
} }
function absolutize_url ( $relative,$base ) {
{$iri = SimplePie_IRI::absolutize(array(new SimplePie_IRI($base),false),$relative);
return $iri[0]->get_iri();
} }
function remove_dot_segments ( $input ) {
{$output = array('',false);
while ( ((((strpos($input[0],'./') !== false) || (strpos($input[0],'/.') !== false)) || ($input[0] === ('.'))) || ($input[0] === ('..'))) )
{if ( (strpos($input[0],'../') === (0)))
 {$input = Aspis_substr($input,array(3,false));
}elseif ( (strpos($input[0],'./') === (0)))
 {$input = Aspis_substr($input,array(2,false));
}elseif ( (strpos($input[0],'/./') === (0)))
 {$input = Aspis_substr_replace($input,array('/',false),array(0,false),array(3,false));
}elseif ( ($input[0] === ('/.')))
 {$input = array('/',false);
}elseif ( (strpos($input[0],'/../') === (0)))
 {$input = Aspis_substr_replace($input,array('/',false),array(0,false),array(4,false));
$output = Aspis_substr_replace($output,array('',false),attAspis(strrpos($output[0],('/'))));
}elseif ( ($input[0] === ('/..')))
 {$input = array('/',false);
$output = Aspis_substr_replace($output,array('',false),attAspis(strrpos($output[0],('/'))));
}elseif ( (($input[0] === ('.')) || ($input[0] === ('..'))))
 {$input = array('',false);
}elseif ( (deAspis(($pos = attAspis(strpos($input[0],'/',(1))))) !== false))
 {$output = concat($output,Aspis_substr($input,array(0,false),$pos));
$input = Aspis_substr_replace($input,array('',false),array(0,false),$pos);
}else 
{{$output = concat($output,$input);
$input = array('',false);
}}}return concat($output,$input);
} }
function get_element ( $realname,$string ) {
{$return = array(array(),false);
$name = Aspis_preg_quote($realname,array('/',false));
if ( deAspis(Aspis_preg_match_all(concat(concat2(concat2(concat1("/<(",$name),")"),SIMPLEPIE_PCRE_HTML_ATTRIBUTE),concat2(concat1("(>(.*)<\/",$name),">|(\/)?>)/siU")),$string,$matches,array(PREG_SET_ORDER | PREG_OFFSET_CAPTURE,false))))
 {for ( $i = array(0,false),$total_matches = attAspis(count($matches[0])) ; ($i[0] < $total_matches[0]) ; postincr($i) )
{arrayAssign($return[0][$i[0]][0],deAspis(registerTaint(array('tag',false))),addTaint($realname));
arrayAssign($return[0][$i[0]][0],deAspis(registerTaint(array('full',false))),addTaint(attachAspis($matches[0][$i[0]][0][(0)],(0))));
arrayAssign($return[0][$i[0]][0],deAspis(registerTaint(array('offset',false))),addTaint(attachAspis($matches[0][$i[0]][0][(0)],(1))));
if ( (strlen(deAspis(attachAspis($matches[0][$i[0]][0][(3)],(0)))) <= (2)))
 {arrayAssign($return[0][$i[0]][0],deAspis(registerTaint(array('self_closing',false))),addTaint(array(true,false)));
}else 
{{arrayAssign($return[0][$i[0]][0],deAspis(registerTaint(array('self_closing',false))),addTaint(array(false,false)));
arrayAssign($return[0][$i[0]][0],deAspis(registerTaint(array('content',false))),addTaint(attachAspis($matches[0][$i[0]][0][(4)],(0))));
}}arrayAssign($return[0][$i[0]][0],deAspis(registerTaint(array('attribs',false))),addTaint(array(array(),false)));
if ( (((isset($matches[0][$i[0]][0][(2)][0][(0)]) && Aspis_isset( $matches [0][$i[0]] [0][(2)] [0][(0)]))) && deAspis(Aspis_preg_match_all(array('/[\x09\x0A\x0B\x0C\x0D\x20]+([^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3D\x3E]*)(?:[\x09\x0A\x0B\x0C\x0D\x20]*=[\x09\x0A\x0B\x0C\x0D\x20]*(?:"([^"]*)"|\'([^\']*)\'|([^\x09\x0A\x0B\x0C\x0D\x20\x22\x27\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x3E]*)?))?/',false),concat2(concat1(' ',attachAspis($matches[0][$i[0]][0][(2)],(0))),' '),$attribs,array(PREG_SET_ORDER,false)))))
 {for ( $j = array(0,false),$total_attribs = attAspis(count($attribs[0])) ; ($j[0] < $total_attribs[0]) ; postincr($j) )
{if ( (count(deAspis(attachAspis($attribs,$j[0]))) === (2)))
 {arrayAssign($attribs[0][$j[0]][0],deAspis(registerTaint(array(2,false))),addTaint(attachAspis($attribs[0][$j[0]],(1))));
}arrayAssign($return[0][$i[0]][0][('attribs')][0][deAspis(Aspis_strtolower(attachAspis($attribs[0][$j[0]],(1))))][0],deAspis(registerTaint(array('data',false))),addTaint(SimplePie_Misc::entities_decode(Aspis_end(attachAspis($attribs,$j[0])),array('UTF-8',false))));
}}}}return $return;
} }
function element_implode ( $element ) {
{$full = concat1("<",attachAspis($element,tag));
foreach ( deAspis($element[0]['attribs']) as $key =>$value )
{restoreTaint($key,$value);
{$key = Aspis_strtolower($key);
$full = concat($full,concat2(concat(concat2(concat1(" ",$key),"=\""),Aspis_htmlspecialchars($value[0]['data'])),'"'));
}}if ( deAspis($element[0]['self_closing']))
 {$full = concat2($full,' />');
}else 
{{$full = concat($full,concat2(concat(concat2(concat1(">",attachAspis($element,content)),"</"),attachAspis($element,tag)),">"));
}}return $full;
} }
function error ( $message,$level,$file,$line ) {
{if ( (((ini_get('error_reporting')) & $level[0]) > (0)))
 {switch ( $level[0] ) {
case E_USER_ERROR:$note = array('PHP Error',false);
break ;
case E_USER_WARNING:$note = array('PHP Warning',false);
break ;
case E_USER_NOTICE:$note = array('PHP Notice',false);
break ;
default :$note = array('Unknown Error',false);
break ;
 }
error_log((deconcat(concat2(concat(concat2(concat(concat2($note,": "),$message)," in "),$file)," on line "),$line)),0);
}return $message;
} }
function display_cached_file ( $identifier_url,$cache_location = array('./cache',false),$cache_extension = array('spc',false),$cache_class = array('SimplePie_Cache',false),$cache_name_function = array('md5',false) ) {
{$cache = Aspis_call_user_func(array(array($cache_class,array('create',false)),false),$cache_location,$identifier_url,$cache_extension);
if ( deAspis($file = $cache[0]->load()))
 {if ( ((isset($file[0][('headers')][0][('content-type')]) && Aspis_isset( $file [0][('headers')] [0][('content-type')]))))
 {header((deconcat1('Content-type:',$file[0][('headers')][0]['content-type'])));
}else 
{{header(('Content-type: application/octet-stream'));
}}header((deconcat2(concat1('Expires: ',attAspis(gmdate(('D, d M Y H:i:s'),(time() + (604800))))),' GMT')));
echo AspisCheckPrint($file[0]['body']);
Aspis_exit();
}Aspis_exit(concat2(concat1('Cached file for ',$identifier_url),' cannot be found.'));
} }
function fix_protocol ( $url,$http = array(1,false) ) {
{$url = SimplePie_Misc::normalize_url($url);
$parsed = SimplePie_Misc::parse_url($url);
if ( (((deAspis($parsed[0]['scheme']) !== ('')) && (deAspis($parsed[0]['scheme']) !== ('http'))) && (deAspis($parsed[0]['scheme']) !== ('https'))))
 {return SimplePie_Misc::fix_protocol(SimplePie_Misc::compress_parse_url(array('http',false),$parsed[0]['authority'],$parsed[0]['path'],$parsed[0]['query'],$parsed[0]['fragment']),$http);
}if ( (((deAspis($parsed[0]['scheme']) === ('')) && (deAspis($parsed[0]['authority']) === (''))) && (!(file_exists($url[0])))))
 {return SimplePie_Misc::fix_protocol(SimplePie_Misc::compress_parse_url(array('http',false),$parsed[0]['path'],array('',false),$parsed[0]['query'],$parsed[0]['fragment']),$http);
}if ( (($http[0] === (2)) && (deAspis($parsed[0]['scheme']) !== (''))))
 {return concat1("feed:",$url);
}elseif ( (($http[0] === (3)) && (deAspis(Aspis_strtolower($parsed[0]['scheme'])) === ('http'))))
 {return Aspis_substr_replace($url,array('podcast',false),array(0,false),array(4,false));
}elseif ( (($http[0] === (4)) && (deAspis(Aspis_strtolower($parsed[0]['scheme'])) === ('http'))))
 {return Aspis_substr_replace($url,array('itpc',false),array(0,false),array(4,false));
}else 
{{return $url;
}}} }
function parse_url ( $url ) {
{$iri = array(new SimplePie_IRI($url),false);
return array(array(deregisterTaint(array('scheme',false)) => addTaint(string_cast($iri[0]->get_scheme())),deregisterTaint(array('authority',false)) => addTaint(string_cast($iri[0]->get_authority())),deregisterTaint(array('path',false)) => addTaint(string_cast($iri[0]->get_path())),deregisterTaint(array('query',false)) => addTaint(string_cast($iri[0]->get_query())),deregisterTaint(array('fragment',false)) => addTaint(string_cast($iri[0]->get_fragment()))),false);
} }
function compress_parse_url ( $scheme = array('',false),$authority = array('',false),$path = array('',false),$query = array('',false),$fragment = array('',false) ) {
{$iri = array(new SimplePie_IRI(array('',false)),false);
$iri[0]->set_scheme($scheme);
$iri[0]->set_authority($authority);
$iri[0]->set_path($path);
$iri[0]->set_query($query);
$iri[0]->set_fragment($fragment);
return $iri[0]->get_iri();
} }
function normalize_url ( $url ) {
{$iri = array(new SimplePie_IRI($url),false);
return $iri[0]->get_iri();
} }
function percent_encoding_normalization ( $match ) {
{$integer = Aspis_hexdec(attachAspis($match,(1)));
if ( (((((((($integer[0] >= (0x41)) && ($integer[0] <= (0x5A))) || (($integer[0] >= (0x61)) && ($integer[0] <= (0x7A)))) || (($integer[0] >= (0x30)) && ($integer[0] <= (0x39)))) || ($integer[0] === (0x2D))) || ($integer[0] === (0x2E))) || ($integer[0] === (0x5F))) || ($integer[0] === (0x7E))))
 {return attAspis(chr($integer[0]));
}else 
{{return Aspis_strtoupper(attachAspis($match,(0)));
}}} }
function utf8_bad_replace ( $str ) {
{if ( (function_exists(('iconv')) && deAspis(($return = @Aspis_iconv(array('UTF-8',false),array('UTF-8//IGNORE',false),$str)))))
 {return $return;
}elseif ( (function_exists(('mb_convert_encoding')) && deAspis(($return = @Aspis_mb_convert_encoding($str,array('UTF-8',false),array('UTF-8',false))))))
 {return $return;
}elseif ( deAspis(Aspis_preg_match_all(array('/(?:[\x00-\x7F]|[\xC2-\xDF][\x80-\xBF]|\xE0[\xA0-\xBF][\x80-\xBF]|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|\xED[\x80-\x9F][\x80-\xBF]|\xF0[\x90-\xBF][\x80-\xBF]{2}|[\xF1-\xF3][\x80-\xBF]{3}|\xF4[\x80-\x8F][\x80-\xBF]{2})+/',false),$str,$matches)))
 {return Aspis_implode(array("\xEF\xBF\xBD",false),attachAspis($matches,(0)));
}elseif ( ($str[0] !== ('')))
 {return array("\xEF\xBF\xBD",false);
}else 
{{return array('',false);
}}} }
function windows_1252_to_utf8 ( $string ) {
{static $convert_table = array(array("\x80" => array("\xE2\x82\xAC",false),"\x81" => array("\xEF\xBF\xBD",false),"\x82" => array("\xE2\x80\x9A",false),"\x83" => array("\xC6\x92",false),"\x84" => array("\xE2\x80\x9E",false),"\x85" => array("\xE2\x80\xA6",false),"\x86" => array("\xE2\x80\xA0",false),"\x87" => array("\xE2\x80\xA1",false),"\x88" => array("\xCB\x86",false),"\x89" => array("\xE2\x80\xB0",false),"\x8A" => array("\xC5\xA0",false),"\x8B" => array("\xE2\x80\xB9",false),"\x8C" => array("\xC5\x92",false),"\x8D" => array("\xEF\xBF\xBD",false),"\x8E" => array("\xC5\xBD",false),"\x8F" => array("\xEF\xBF\xBD",false),"\x90" => array("\xEF\xBF\xBD",false),"\x91" => array("\xE2\x80\x98",false),"\x92" => array("\xE2\x80\x99",false),"\x93" => array("\xE2\x80\x9C",false),"\x94" => array("\xE2\x80\x9D",false),"\x95" => array("\xE2\x80\xA2",false),"\x96" => array("\xE2\x80\x93",false),"\x97" => array("\xE2\x80\x94",false),"\x98" => array("\xCB\x9C",false),"\x99" => array("\xE2\x84\xA2",false),"\x9A" => array("\xC5\xA1",false),"\x9B" => array("\xE2\x80\xBA",false),"\x9C" => array("\xC5\x93",false),"\x9D" => array("\xEF\xBF\xBD",false),"\x9E" => array("\xC5\xBE",false),"\x9F" => array("\xC5\xB8",false),"\xA0" => array("\xC2\xA0",false),"\xA1" => array("\xC2\xA1",false),"\xA2" => array("\xC2\xA2",false),"\xA3" => array("\xC2\xA3",false),"\xA4" => array("\xC2\xA4",false),"\xA5" => array("\xC2\xA5",false),"\xA6" => array("\xC2\xA6",false),"\xA7" => array("\xC2\xA7",false),"\xA8" => array("\xC2\xA8",false),"\xA9" => array("\xC2\xA9",false),"\xAA" => array("\xC2\xAA",false),"\xAB" => array("\xC2\xAB",false),"\xAC" => array("\xC2\xAC",false),"\xAD" => array("\xC2\xAD",false),"\xAE" => array("\xC2\xAE",false),"\xAF" => array("\xC2\xAF",false),"\xB0" => array("\xC2\xB0",false),"\xB1" => array("\xC2\xB1",false),"\xB2" => array("\xC2\xB2",false),"\xB3" => array("\xC2\xB3",false),"\xB4" => array("\xC2\xB4",false),"\xB5" => array("\xC2\xB5",false),"\xB6" => array("\xC2\xB6",false),"\xB7" => array("\xC2\xB7",false),"\xB8" => array("\xC2\xB8",false),"\xB9" => array("\xC2\xB9",false),"\xBA" => array("\xC2\xBA",false),"\xBB" => array("\xC2\xBB",false),"\xBC" => array("\xC2\xBC",false),"\xBD" => array("\xC2\xBD",false),"\xBE" => array("\xC2\xBE",false),"\xBF" => array("\xC2\xBF",false),"\xC0" => array("\xC3\x80",false),"\xC1" => array("\xC3\x81",false),"\xC2" => array("\xC3\x82",false),"\xC3" => array("\xC3\x83",false),"\xC4" => array("\xC3\x84",false),"\xC5" => array("\xC3\x85",false),"\xC6" => array("\xC3\x86",false),"\xC7" => array("\xC3\x87",false),"\xC8" => array("\xC3\x88",false),"\xC9" => array("\xC3\x89",false),"\xCA" => array("\xC3\x8A",false),"\xCB" => array("\xC3\x8B",false),"\xCC" => array("\xC3\x8C",false),"\xCD" => array("\xC3\x8D",false),"\xCE" => array("\xC3\x8E",false),"\xCF" => array("\xC3\x8F",false),"\xD0" => array("\xC3\x90",false),"\xD1" => array("\xC3\x91",false),"\xD2" => array("\xC3\x92",false),"\xD3" => array("\xC3\x93",false),"\xD4" => array("\xC3\x94",false),"\xD5" => array("\xC3\x95",false),"\xD6" => array("\xC3\x96",false),"\xD7" => array("\xC3\x97",false),"\xD8" => array("\xC3\x98",false),"\xD9" => array("\xC3\x99",false),"\xDA" => array("\xC3\x9A",false),"\xDB" => array("\xC3\x9B",false),"\xDC" => array("\xC3\x9C",false),"\xDD" => array("\xC3\x9D",false),"\xDE" => array("\xC3\x9E",false),"\xDF" => array("\xC3\x9F",false),"\xE0" => array("\xC3\xA0",false),"\xE1" => array("\xC3\xA1",false),"\xE2" => array("\xC3\xA2",false),"\xE3" => array("\xC3\xA3",false),"\xE4" => array("\xC3\xA4",false),"\xE5" => array("\xC3\xA5",false),"\xE6" => array("\xC3\xA6",false),"\xE7" => array("\xC3\xA7",false),"\xE8" => array("\xC3\xA8",false),"\xE9" => array("\xC3\xA9",false),"\xEA" => array("\xC3\xAA",false),"\xEB" => array("\xC3\xAB",false),"\xEC" => array("\xC3\xAC",false),"\xED" => array("\xC3\xAD",false),"\xEE" => array("\xC3\xAE",false),"\xEF" => array("\xC3\xAF",false),"\xF0" => array("\xC3\xB0",false),"\xF1" => array("\xC3\xB1",false),"\xF2" => array("\xC3\xB2",false),"\xF3" => array("\xC3\xB3",false),"\xF4" => array("\xC3\xB4",false),"\xF5" => array("\xC3\xB5",false),"\xF6" => array("\xC3\xB6",false),"\xF7" => array("\xC3\xB7",false),"\xF8" => array("\xC3\xB8",false),"\xF9" => array("\xC3\xB9",false),"\xFA" => array("\xC3\xBA",false),"\xFB" => array("\xC3\xBB",false),"\xFC" => array("\xC3\xBC",false),"\xFD" => array("\xC3\xBD",false),"\xFE" => array("\xC3\xBE",false),"\xFF" => array("\xC3\xBF",false)),false);
return Aspis_strtr($string,$convert_table);
} }
function change_encoding ( $data,$input,$output ) {
{$input = SimplePie_Misc::encoding($input);
$output = SimplePie_Misc::encoding($output);
if ( ($input[0] === ('US-ASCII')))
 {static $non_ascii_octects = array('',false);
if ( (denot_boolean($non_ascii_octects)))
 {for ( $i = array(0x80,false) ; ($i[0] <= (0xFF)) ; postincr($i) )
{$non_ascii_octects = concat($non_ascii_octects,attAspis(chr($i[0])));
}}$data = Aspis_substr($data,array(0,false),attAspis(strcspn($data[0],$non_ascii_octects[0])));
}if ( (($input[0] === ('windows-1252')) && ($output[0] === ('UTF-8'))))
 {return SimplePie_Misc::windows_1252_to_utf8($data);
}elseif ( ((function_exists(('mb_convert_encoding')) && (deAspis(@Aspis_mb_convert_encoding(array("\x80",false),array('UTF-16BE',false),$input)) !== ("\x00\x80"))) && deAspis(($return = @Aspis_mb_convert_encoding($data,$output,$input)))))
 {return $return;
}elseif ( (function_exists(('iconv')) && deAspis(($return = @Aspis_iconv($input,$output,$data)))))
 {return $return;
}else 
{{return array(false,false);
}}} }
function encoding ( $charset ) {
{switch ( deAspis(Aspis_strtolower(Aspis_preg_replace(array('/(?:[^a-zA-Z0-9]+|([^0-9])0+)/',false),array('\1',false),$charset))) ) {
case ('adobestandardencoding'):case ('csadobestandardencoding'):return array('Adobe-Standard-Encoding',false);
case ('adobesymbolencoding'):case ('cshppsmath'):return array('Adobe-Symbol-Encoding',false);
case ('ami1251'):case ('amiga1251'):return array('Amiga-1251',false);
case ('ansix31101983'):case ('csat5001983'):case ('csiso99naplps'):case ('isoir99'):case ('naplps'):return array('ANSI_X3.110-1983',false);
case ('arabic7'):case ('asmo449'):case ('csiso89asmo449'):case ('iso9036'):case ('isoir89'):return array('ASMO_449',false);
case ('big5'):case ('csbig5'):case ('xxbig5'):return array('Big5',false);
case ('big5hkscs'):return array('Big5-HKSCS',false);
case ('bocu1'):case ('csbocu1'):return array('BOCU-1',false);
case ('brf'):case ('csbrf'):return array('BRF',false);
case ('bs4730'):case ('csiso4unitedkingdom'):case ('gb'):case ('iso646gb'):case ('isoir4'):case ('uk'):return array('BS_4730',false);
case ('bsviewdata'):case ('csiso47bsviewdata'):case ('isoir47'):return array('BS_viewdata',false);
case ('cesu8'):case ('cscesu8'):return array('CESU-8',false);
case ('ca'):case ('csa71'):case ('csaz243419851'):case ('csiso121canadian1'):case ('iso646ca'):case ('isoir121'):return array('CSA_Z243.4-1985-1',false);
case ('csa72'):case ('csaz243419852'):case ('csiso122canadian2'):case ('iso646ca2'):case ('isoir122'):return array('CSA_Z243.4-1985-2',false);
case ('csaz24341985gr'):case ('csiso123csaz24341985gr'):case ('isoir123'):return array('CSA_Z243.4-1985-gr',false);
case ('csiso139csn369103'):case ('csn369103'):case ('isoir139'):return array('CSN_369103',false);
case ('csdecmcs'):case ('dec'):case ('decmcs'):return array('DEC-MCS',false);
case ('csiso21german'):case ('de'):case ('din66003'):case ('iso646de'):case ('isoir21'):return array('DIN_66003',false);
case ('csdkus'):case ('dkus'):return array('dk-us',false);
case ('csiso646danish'):case ('dk'):case ('ds2089'):case ('iso646dk'):return array('DS_2089',false);
case ('csibmebcdicatde'):case ('ebcdicatde'):return array('EBCDIC-AT-DE',false);
case ('csebcdicatdea'):case ('ebcdicatdea'):return array('EBCDIC-AT-DE-A',false);
case ('csebcdiccafr'):case ('ebcdiccafr'):return array('EBCDIC-CA-FR',false);
case ('csebcdicdkno'):case ('ebcdicdkno'):return array('EBCDIC-DK-NO',false);
case ('csebcdicdknoa'):case ('ebcdicdknoa'):return array('EBCDIC-DK-NO-A',false);
case ('csebcdices'):case ('ebcdices'):return array('EBCDIC-ES',false);
case ('csebcdicesa'):case ('ebcdicesa'):return array('EBCDIC-ES-A',false);
case ('csebcdicess'):case ('ebcdicess'):return array('EBCDIC-ES-S',false);
case ('csebcdicfise'):case ('ebcdicfise'):return array('EBCDIC-FI-SE',false);
case ('csebcdicfisea'):case ('ebcdicfisea'):return array('EBCDIC-FI-SE-A',false);
case ('csebcdicfr'):case ('ebcdicfr'):return array('EBCDIC-FR',false);
case ('csebcdicit'):case ('ebcdicit'):return array('EBCDIC-IT',false);
case ('csebcdicpt'):case ('ebcdicpt'):return array('EBCDIC-PT',false);
case ('csebcdicuk'):case ('ebcdicuk'):return array('EBCDIC-UK',false);
case ('csebcdicus'):case ('ebcdicus'):return array('EBCDIC-US',false);
case ('csiso111ecmacyrillic'):case ('ecmacyrillic'):case ('isoir111'):case ('koi8e'):return array('ECMA-cyrillic',false);
case ('csiso17spanish'):case ('es'):case ('iso646es'):case ('isoir17'):return array('ES',false);
case ('csiso85spanish2'):case ('es2'):case ('iso646es2'):case ('isoir85'):return array('ES2',false);
case ('cseucfixwidjapanese'):case ('extendedunixcodefixedwidthforjapanese'):return array('Extended_UNIX_Code_Fixed_Width_for_Japanese',false);
case ('cseucpkdfmtjapanese'):case ('eucjp'):case ('extendedunixcodepackedformatforjapanese'):return array('Extended_UNIX_Code_Packed_Format_for_Japanese',false);
case ('gb18030'):return array('GB18030',false);
case ('chinese'):case ('cp936'):case ('csgb2312'):case ('csiso58gb231280'):case ('gb2312'):case ('gb231280'):case ('gbk'):case ('isoir58'):case ('ms936'):case ('windows936'):return array('GBK',false);
case ('cn'):case ('csiso57gb1988'):case ('gb198880'):case ('iso646cn'):case ('isoir57'):return array('GB_1988-80',false);
case ('csiso153gost1976874'):case ('gost1976874'):case ('isoir153'):case ('stsev35888'):return array('GOST_19768-74',false);
case ('csiso150'):case ('csiso150greekccitt'):case ('greekccitt'):case ('isoir150'):return array('greek-ccitt',false);
case ('csiso88greek7'):case ('greek7'):case ('isoir88'):return array('greek7',false);
case ('csiso18greek7old'):case ('greek7old'):case ('isoir18'):return array('greek7-old',false);
case ('cshpdesktop'):case ('hpdesktop'):return array('HP-DeskTop',false);
case ('cshplegal'):case ('hplegal'):return array('HP-Legal',false);
case ('cshpmath8'):case ('hpmath8'):return array('HP-Math8',false);
case ('cshppifont'):case ('hppifont'):return array('HP-Pi-font',false);
case ('cshproman8'):case ('hproman8'):case ('r8'):case ('roman8'):return array('hp-roman8',false);
case ('hzgb2312'):return array('HZ-GB-2312',false);
case ('csibmsymbols'):case ('ibmsymbols'):return array('IBM-Symbols',false);
case ('csibmthai'):case ('ibmthai'):return array('IBM-Thai',false);
case ('ccsid858'):case ('cp858'):case ('ibm858'):case ('pcmultilingual850euro'):return array('IBM00858',false);
case ('ccsid924'):case ('cp924'):case ('ebcdiclatin9euro'):case ('ibm924'):return array('IBM00924',false);
case ('ccsid1140'):case ('cp1140'):case ('ebcdicus37euro'):case ('ibm1140'):return array('IBM01140',false);
case ('ccsid1141'):case ('cp1141'):case ('ebcdicde273euro'):case ('ibm1141'):return array('IBM01141',false);
case ('ccsid1142'):case ('cp1142'):case ('ebcdicdk277euro'):case ('ebcdicno277euro'):case ('ibm1142'):return array('IBM01142',false);
case ('ccsid1143'):case ('cp1143'):case ('ebcdicfi278euro'):case ('ebcdicse278euro'):case ('ibm1143'):return array('IBM01143',false);
case ('ccsid1144'):case ('cp1144'):case ('ebcdicit280euro'):case ('ibm1144'):return array('IBM01144',false);
case ('ccsid1145'):case ('cp1145'):case ('ebcdices284euro'):case ('ibm1145'):return array('IBM01145',false);
case ('ccsid1146'):case ('cp1146'):case ('ebcdicgb285euro'):case ('ibm1146'):return array('IBM01146',false);
case ('ccsid1147'):case ('cp1147'):case ('ebcdicfr297euro'):case ('ibm1147'):return array('IBM01147',false);
case ('ccsid1148'):case ('cp1148'):case ('ebcdicinternational500euro'):case ('ibm1148'):return array('IBM01148',false);
case ('ccsid1149'):case ('cp1149'):case ('ebcdicis871euro'):case ('ibm1149'):return array('IBM01149',false);
case ('cp37'):case ('csibm37'):case ('ebcdiccpca'):case ('ebcdiccpnl'):case ('ebcdiccpus'):case ('ebcdiccpwt'):case ('ibm37'):return array('IBM037',false);
case ('cp38'):case ('csibm38'):case ('ebcdicint'):case ('ibm38'):return array('IBM038',false);
case ('cp273'):case ('csibm273'):case ('ibm273'):return array('IBM273',false);
case ('cp274'):case ('csibm274'):case ('ebcdicbe'):case ('ibm274'):return array('IBM274',false);
case ('cp275'):case ('csibm275'):case ('ebcdicbr'):case ('ibm275'):return array('IBM275',false);
case ('csibm277'):case ('ebcdiccpdk'):case ('ebcdiccpno'):case ('ibm277'):return array('IBM277',false);
case ('cp278'):case ('csibm278'):case ('ebcdiccpfi'):case ('ebcdiccpse'):case ('ibm278'):return array('IBM278',false);
case ('cp280'):case ('csibm280'):case ('ebcdiccpit'):case ('ibm280'):return array('IBM280',false);
case ('cp281'):case ('csibm281'):case ('ebcdicjpe'):case ('ibm281'):return array('IBM281',false);
case ('cp284'):case ('csibm284'):case ('ebcdiccpes'):case ('ibm284'):return array('IBM284',false);
case ('cp285'):case ('csibm285'):case ('ebcdiccpgb'):case ('ibm285'):return array('IBM285',false);
case ('cp290'):case ('csibm290'):case ('ebcdicjpkana'):case ('ibm290'):return array('IBM290',false);
case ('cp297'):case ('csibm297'):case ('ebcdiccpfr'):case ('ibm297'):return array('IBM297',false);
case ('cp420'):case ('csibm420'):case ('ebcdiccpar1'):case ('ibm420'):return array('IBM420',false);
case ('cp423'):case ('csibm423'):case ('ebcdiccpgr'):case ('ibm423'):return array('IBM423',false);
case ('cp424'):case ('csibm424'):case ('ebcdiccphe'):case ('ibm424'):return array('IBM424',false);
case ('437'):case ('cp437'):case ('cspc8codepage437'):case ('ibm437'):return array('IBM437',false);
case ('cp500'):case ('csibm500'):case ('ebcdiccpbe'):case ('ebcdiccpch'):case ('ibm500'):return array('IBM500',false);
case ('cp775'):case ('cspc775baltic'):case ('ibm775'):return array('IBM775',false);
case ('850'):case ('cp850'):case ('cspc850multilingual'):case ('ibm850'):return array('IBM850',false);
case ('851'):case ('cp851'):case ('csibm851'):case ('ibm851'):return array('IBM851',false);
case ('852'):case ('cp852'):case ('cspcp852'):case ('ibm852'):return array('IBM852',false);
case ('855'):case ('cp855'):case ('csibm855'):case ('ibm855'):return array('IBM855',false);
case ('857'):case ('cp857'):case ('csibm857'):case ('ibm857'):return array('IBM857',false);
case ('860'):case ('cp860'):case ('csibm860'):case ('ibm860'):return array('IBM860',false);
case ('861'):case ('cp861'):case ('cpis'):case ('csibm861'):case ('ibm861'):return array('IBM861',false);
case ('862'):case ('cp862'):case ('cspc862latinhebrew'):case ('ibm862'):return array('IBM862',false);
case ('863'):case ('cp863'):case ('csibm863'):case ('ibm863'):return array('IBM863',false);
case ('cp864'):case ('csibm864'):case ('ibm864'):return array('IBM864',false);
case ('865'):case ('cp865'):case ('csibm865'):case ('ibm865'):return array('IBM865',false);
case ('866'):case ('cp866'):case ('csibm866'):case ('ibm866'):return array('IBM866',false);
case ('cp868'):case ('cpar'):case ('csibm868'):case ('ibm868'):return array('IBM868',false);
case ('869'):case ('cp869'):case ('cpgr'):case ('csibm869'):case ('ibm869'):return array('IBM869',false);
case ('cp870'):case ('csibm870'):case ('ebcdiccproece'):case ('ebcdiccpyu'):case ('ibm870'):return array('IBM870',false);
case ('cp871'):case ('csibm871'):case ('ebcdiccpis'):case ('ibm871'):return array('IBM871',false);
case ('cp880'):case ('csibm880'):case ('ebcdiccyrillic'):case ('ibm880'):return array('IBM880',false);
case ('cp891'):case ('csibm891'):case ('ibm891'):return array('IBM891',false);
case ('cp903'):case ('csibm903'):case ('ibm903'):return array('IBM903',false);
case ('904'):case ('cp904'):case ('csibbm904'):case ('ibm904'):return array('IBM904',false);
case ('cp905'):case ('csibm905'):case ('ebcdiccptr'):case ('ibm905'):return array('IBM905',false);
case ('cp918'):case ('csibm918'):case ('ebcdiccpar2'):case ('ibm918'):return array('IBM918',false);
case ('cp1026'):case ('csibm1026'):case ('ibm1026'):return array('IBM1026',false);
case ('ibm1047'):return array('IBM1047',false);
case ('csiso143iecp271'):case ('iecp271'):case ('isoir143'):return array('IEC_P27-1',false);
case ('csiso49inis'):case ('inis'):case ('isoir49'):return array('INIS',false);
case ('csiso50inis8'):case ('inis8'):case ('isoir50'):return array('INIS-8',false);
case ('csiso51iniscyrillic'):case ('iniscyrillic'):case ('isoir51'):return array('INIS-cyrillic',false);
case ('csinvariant'):case ('invariant'):return array('INVARIANT',false);
case ('iso2022cn'):return array('ISO-2022-CN',false);
case ('iso2022cnext'):return array('ISO-2022-CN-EXT',false);
case ('csiso2022jp'):case ('iso2022jp'):return array('ISO-2022-JP',false);
case ('csiso2022jp2'):case ('iso2022jp2'):return array('ISO-2022-JP-2',false);
case ('csiso2022kr'):case ('iso2022kr'):return array('ISO-2022-KR',false);
case ('cswindows30latin1'):case ('iso88591windows30latin1'):return array('ISO-8859-1-Windows-3.0-Latin-1',false);
case ('cswindows31latin1'):case ('iso88591windows31latin1'):return array('ISO-8859-1-Windows-3.1-Latin-1',false);
case ('csisolatin2'):case ('iso88592'):case ('iso885921987'):case ('isoir101'):case ('l2'):case ('latin2'):return array('ISO-8859-2',false);
case ('cswindows31latin2'):case ('iso88592windowslatin2'):return array('ISO-8859-2-Windows-Latin-2',false);
case ('csisolatin3'):case ('iso88593'):case ('iso885931988'):case ('isoir109'):case ('l3'):case ('latin3'):return array('ISO-8859-3',false);
case ('csisolatin4'):case ('iso88594'):case ('iso885941988'):case ('isoir110'):case ('l4'):case ('latin4'):return array('ISO-8859-4',false);
case ('csisolatincyrillic'):case ('cyrillic'):case ('iso88595'):case ('iso885951988'):case ('isoir144'):return array('ISO-8859-5',false);
case ('arabic'):case ('asmo708'):case ('csisolatinarabic'):case ('ecma114'):case ('iso88596'):case ('iso885961987'):case ('isoir127'):return array('ISO-8859-6',false);
case ('csiso88596e'):case ('iso88596e'):return array('ISO-8859-6-E',false);
case ('csiso88596i'):case ('iso88596i'):return array('ISO-8859-6-I',false);
case ('csisolatingreek'):case ('ecma118'):case ('elot928'):case ('greek'):case ('greek8'):case ('iso88597'):case ('iso885971987'):case ('isoir126'):return array('ISO-8859-7',false);
case ('csisolatinhebrew'):case ('hebrew'):case ('iso88598'):case ('iso885981988'):case ('isoir138'):return array('ISO-8859-8',false);
case ('csiso88598e'):case ('iso88598e'):return array('ISO-8859-8-E',false);
case ('csiso88598i'):case ('iso88598i'):return array('ISO-8859-8-I',false);
case ('cswindows31latin5'):case ('iso88599windowslatin5'):return array('ISO-8859-9-Windows-Latin-5',false);
case ('csisolatin6'):case ('iso885910'):case ('iso8859101992'):case ('isoir157'):case ('l6'):case ('latin6'):return array('ISO-8859-10',false);
case ('iso885913'):return array('ISO-8859-13',false);
case ('iso885914'):case ('iso8859141998'):case ('isoceltic'):case ('isoir199'):case ('l8'):case ('latin8'):return array('ISO-8859-14',false);
case ('iso885915'):case ('latin9'):return array('ISO-8859-15',false);
case ('iso885916'):case ('iso8859162001'):case ('isoir226'):case ('l10'):case ('latin10'):return array('ISO-8859-16',false);
case ('iso10646j1'):return array('ISO-10646-J-1',false);
case ('csunicode'):case ('iso10646ucs2'):return array('ISO-10646-UCS-2',false);
case ('csucs4'):case ('iso10646ucs4'):return array('ISO-10646-UCS-4',false);
case ('csunicodeascii'):case ('iso10646ucsbasic'):return array('ISO-10646-UCS-Basic',false);
case ('csunicodelatin1'):case ('iso10646'):case ('iso10646unicodelatin1'):return array('ISO-10646-Unicode-Latin1',false);
case ('csiso10646utf1'):case ('iso10646utf1'):return array('ISO-10646-UTF-1',false);
case ('csiso115481'):case ('iso115481'):case ('isotr115481'):return array('ISO-11548-1',false);
case ('csiso90'):case ('isoir90'):return array('iso-ir-90',false);
case ('csunicodeibm1261'):case ('isounicodeibm1261'):return array('ISO-Unicode-IBM-1261',false);
case ('csunicodeibm1264'):case ('isounicodeibm1264'):return array('ISO-Unicode-IBM-1264',false);
case ('csunicodeibm1265'):case ('isounicodeibm1265'):return array('ISO-Unicode-IBM-1265',false);
case ('csunicodeibm1268'):case ('isounicodeibm1268'):return array('ISO-Unicode-IBM-1268',false);
case ('csunicodeibm1276'):case ('isounicodeibm1276'):return array('ISO-Unicode-IBM-1276',false);
case ('csiso646basic1983'):case ('iso646basic1983'):case ('ref'):return array('ISO_646.basic:1983',false);
case ('csiso2intlrefversion'):case ('irv'):case ('iso646irv1983'):case ('isoir2'):return array('ISO_646.irv:1983',false);
case ('csiso2033'):case ('e13b'):case ('iso20331983'):case ('isoir98'):return array('ISO_2033-1983',false);
case ('csiso5427cyrillic'):case ('iso5427'):case ('isoir37'):return array('ISO_5427',false);
case ('iso5427cyrillic1981'):case ('iso54271981'):case ('isoir54'):return array('ISO_5427:1981',false);
case ('csiso5428greek'):case ('iso54281980'):case ('isoir55'):return array('ISO_5428:1980',false);
case ('csiso6937add'):case ('iso6937225'):case ('isoir152'):return array('ISO_6937-2-25',false);
case ('csisotextcomm'):case ('iso69372add'):case ('isoir142'):return array('ISO_6937-2-add',false);
case ('csiso8859supp'):case ('iso8859supp'):case ('isoir154'):case ('latin125'):return array('ISO_8859-supp',false);
case ('csiso10367box'):case ('iso10367box'):case ('isoir155'):return array('ISO_10367-box',false);
case ('csiso15italian'):case ('iso646it'):case ('isoir15'):case ('it'):return array('IT',false);
case ('csiso13jisc6220jp'):case ('isoir13'):case ('jisc62201969'):case ('jisc62201969jp'):case ('katakana'):case ('x2017'):return array('JIS_C6220-1969-jp',false);
case ('csiso14jisc6220ro'):case ('iso646jp'):case ('isoir14'):case ('jisc62201969ro'):case ('jp'):return array('JIS_C6220-1969-ro',false);
case ('csiso42jisc62261978'):case ('isoir42'):case ('jisc62261978'):return array('JIS_C6226-1978',false);
case ('csiso87jisx208'):case ('isoir87'):case ('jisc62261983'):case ('jisx2081983'):case ('x208'):return array('JIS_C6226-1983',false);
case ('csiso91jisc62291984a'):case ('isoir91'):case ('jisc62291984a'):case ('jpocra'):return array('JIS_C6229-1984-a',false);
case ('csiso92jisc62991984b'):case ('iso646jpocrb'):case ('isoir92'):case ('jisc62291984b'):case ('jpocrb'):return array('JIS_C6229-1984-b',false);
case ('csiso93jis62291984badd'):case ('isoir93'):case ('jisc62291984badd'):case ('jpocrbadd'):return array('JIS_C6229-1984-b-add',false);
case ('csiso94jis62291984hand'):case ('isoir94'):case ('jisc62291984hand'):case ('jpocrhand'):return array('JIS_C6229-1984-hand',false);
case ('csiso95jis62291984handadd'):case ('isoir95'):case ('jisc62291984handadd'):case ('jpocrhandadd'):return array('JIS_C6229-1984-hand-add',false);
case ('csiso96jisc62291984kana'):case ('isoir96'):case ('jisc62291984kana'):return array('JIS_C6229-1984-kana',false);
case ('csjisencoding'):case ('jisencoding'):return array('JIS_Encoding',false);
case ('cshalfwidthkatakana'):case ('jisx201'):case ('x201'):return array('JIS_X0201',false);
case ('csiso159jisx2121990'):case ('isoir159'):case ('jisx2121990'):case ('x212'):return array('JIS_X0212-1990',false);
case ('csiso141jusib1002'):case ('iso646yu'):case ('isoir141'):case ('js'):case ('jusib1002'):case ('yu'):return array('JUS_I.B1.002',false);
case ('csiso147macedonian'):case ('isoir147'):case ('jusib1003mac'):case ('macedonian'):return array('JUS_I.B1.003-mac',false);
case ('csiso146serbian'):case ('isoir146'):case ('jusib1003serb'):case ('serbian'):return array('JUS_I.B1.003-serb',false);
case ('koi7switched'):return array('KOI7-switched',false);
case ('cskoi8r'):case ('koi8r'):return array('KOI8-R',false);
case ('koi8u'):return array('KOI8-U',false);
case ('csksc5636'):case ('iso646kr'):case ('ksc5636'):return array('KSC5636',false);
case ('cskz1048'):case ('kz1048'):case ('rk1048'):case ('strk10482002'):return array('KZ-1048',false);
case ('csiso19latingreek'):case ('isoir19'):case ('latingreek'):return array('latin-greek',false);
case ('csiso27latingreek1'):case ('isoir27'):case ('latingreek1'):return array('Latin-greek-1',false);
case ('csiso158lap'):case ('isoir158'):case ('lap'):case ('latinlap'):return array('latin-lap',false);
case ('csmacintosh'):case ('mac'):case ('macintosh'):return array('macintosh',false);
case ('csmicrosoftpublishing'):case ('microsoftpublishing'):return array('Microsoft-Publishing',false);
case ('csmnem'):case ('mnem'):return array('MNEM',false);
case ('csmnemonic'):case ('mnemonic'):return array('MNEMONIC',false);
case ('csiso86hungarian'):case ('hu'):case ('iso646hu'):case ('isoir86'):case ('msz77953'):return array('MSZ_7795.3',false);
case ('csnatsdano'):case ('isoir91'):case ('natsdano'):return array('NATS-DANO',false);
case ('csnatsdanoadd'):case ('isoir92'):case ('natsdanoadd'):return array('NATS-DANO-ADD',false);
case ('csnatssefi'):case ('isoir81'):case ('natssefi'):return array('NATS-SEFI',false);
case ('csnatssefiadd'):case ('isoir82'):case ('natssefiadd'):return array('NATS-SEFI-ADD',false);
case ('csiso151cuba'):case ('cuba'):case ('iso646cu'):case ('isoir151'):case ('ncnc1081'):return array('NC_NC00-10:81',false);
case ('csiso69french'):case ('fr'):case ('iso646fr'):case ('isoir69'):case ('nfz62010'):return array('NF_Z_62-010',false);
case ('csiso25french'):case ('iso646fr1'):case ('isoir25'):case ('nfz620101973'):return array('NF_Z_62-010_(1973)',false);
case ('csiso60danishnorwegian'):case ('csiso60norwegian1'):case ('iso646no'):case ('isoir60'):case ('no'):case ('ns45511'):return array('NS_4551-1',false);
case ('csiso61norwegian2'):case ('iso646no2'):case ('isoir61'):case ('no2'):case ('ns45512'):return array('NS_4551-2',false);
case ('osdebcdicdf3irv'):return array('OSD_EBCDIC_DF03_IRV',false);
case ('osdebcdicdf41'):return array('OSD_EBCDIC_DF04_1',false);
case ('osdebcdicdf415'):return array('OSD_EBCDIC_DF04_15',false);
case ('cspc8danishnorwegian'):case ('pc8danishnorwegian'):return array('PC8-Danish-Norwegian',false);
case ('cspc8turkish'):case ('pc8turkish'):return array('PC8-Turkish',false);
case ('csiso16portuguese'):case ('iso646pt'):case ('isoir16'):case ('pt'):return array('PT',false);
case ('csiso84portuguese2'):case ('iso646pt2'):case ('isoir84'):case ('pt2'):return array('PT2',false);
case ('cp154'):case ('csptcp154'):case ('cyrillicasian'):case ('pt154'):case ('ptcp154'):return array('PTCP154',false);
case ('scsu'):return array('SCSU',false);
case ('csiso10swedish'):case ('fi'):case ('iso646fi'):case ('iso646se'):case ('isoir10'):case ('se'):case ('sen850200b'):return array('SEN_850200_B',false);
case ('csiso11swedishfornames'):case ('iso646se2'):case ('isoir11'):case ('se2'):case ('sen850200c'):return array('SEN_850200_C',false);
case ('csshiftjis'):case ('mskanji'):case ('shiftjis'):return array('Shift_JIS',false);
case ('csiso102t617bit'):case ('isoir102'):case ('t617bit'):return array('T.61-7bit',false);
case ('csiso103t618bit'):case ('isoir103'):case ('t61'):case ('t618bit'):return array('T.61-8bit',false);
case ('csiso128t101g2'):case ('isoir128'):case ('t101g2'):return array('T.101-G2',false);
case ('cstscii'):case ('tscii'):return array('TSCII',false);
case ('csunicode11'):case ('unicode11'):return array('UNICODE-1-1',false);
case ('csunicode11utf7'):case ('unicode11utf7'):return array('UNICODE-1-1-UTF-7',false);
case ('csunknown8bit'):case ('unknown8bit'):return array('UNKNOWN-8BIT',false);
case ('ansix341968'):case ('ansix341986'):case ('ascii'):case ('cp367'):case ('csascii'):case ('ibm367'):case ('iso646irv1991'):case ('iso646us'):case ('isoir6'):case ('us'):case ('usascii'):return array('US-ASCII',false);
case ('csusdk'):case ('usdk'):return array('us-dk',false);
case ('utf7'):return array('UTF-7',false);
case ('utf8'):return array('UTF-8',false);
case ('utf16'):return array('UTF-16',false);
case ('utf16be'):return array('UTF-16BE',false);
case ('utf16le'):return array('UTF-16LE',false);
case ('utf32'):return array('UTF-32',false);
case ('utf32be'):return array('UTF-32BE',false);
case ('utf32le'):return array('UTF-32LE',false);
case ('csventurainternational'):case ('venturainternational'):return array('Ventura-International',false);
case ('csventuramath'):case ('venturamath'):return array('Ventura-Math',false);
case ('csventuraus'):case ('venturaus'):return array('Ventura-US',false);
case ('csiso70videotexsupp1'):case ('isoir70'):case ('videotexsuppl'):return array('videotex-suppl',false);
case ('csviqr'):case ('viqr'):return array('VIQR',false);
case ('csviscii'):case ('viscii'):return array('VISCII',false);
case ('cswindows31j'):case ('windows31j'):return array('Windows-31J',false);
case ('iso885911'):case ('tis620'):return array('windows-874',false);
case ('cseuckr'):case ('csksc56011987'):case ('euckr'):case ('isoir149'):case ('korean'):case ('ksc5601'):case ('ksc56011987'):case ('ksc56011989'):case ('windows949'):return array('windows-949',false);
case ('windows1250'):return array('windows-1250',false);
case ('windows1251'):return array('windows-1251',false);
case ('cp819'):case ('csisolatin1'):case ('ibm819'):case ('iso88591'):case ('iso885911987'):case ('isoir100'):case ('l1'):case ('latin1'):case ('windows1252'):return array('windows-1252',false);
case ('windows1253'):return array('windows-1253',false);
case ('csisolatin5'):case ('iso88599'):case ('iso885991989'):case ('isoir148'):case ('l5'):case ('latin5'):case ('windows1254'):return array('windows-1254',false);
case ('windows1255'):return array('windows-1255',false);
case ('windows1256'):return array('windows-1256',false);
case ('windows1257'):return array('windows-1257',false);
case ('windows1258'):return array('windows-1258',false);
default :return $charset;
 }
} }
function get_curl_version (  ) {
{if ( is_array(deAspis($curl = array(curl_version(),false))))
 {$curl = $curl[0]['version'];
}elseif ( (deAspis(Aspis_substr($curl,array(0,false),array(5,false))) === ('curl/')))
 {$curl = Aspis_substr($curl,array(5,false),attAspis(strcspn($curl[0],("\x09\x0A\x0B\x0C\x0D"),(5))));
}elseif ( (deAspis(Aspis_substr($curl,array(0,false),array(8,false))) === ('libcurl/')))
 {$curl = Aspis_substr($curl,array(8,false),attAspis(strcspn($curl[0],("\x09\x0A\x0B\x0C\x0D"),(8))));
}else 
{{$curl = array(0,false);
}}return $curl;
} }
function is_subclass_of ( $class1,$class2 ) {
{if ( (func_num_args() !== (2)))
 {trigger_error('Wrong parameter count for SimplePie_Misc::is_subclass_of()',E_USER_WARNING);
}elseif ( ((version_compare(PHP_VERSION,'5.0.3','>=')) || is_object($class1[0])))
 {return attAspis(is_subclass_of(deAspisRC($class1),$class2[0]));
}elseif ( (is_string(deAspisRC($class1)) && is_string(deAspisRC($class2))))
 {if ( class_exists($class1[0]))
 {if ( class_exists($class2[0]))
 {$class2 = Aspis_strtolower($class2);
while ( deAspis($class1 = Aspis_strtolower(attAspis(get_parent_class($class1[0])))) )
{if ( ($class1[0] === $class2[0]))
 {return array(true,false);
}}}}else 
{{trigger_error('Unknown class passed as parameter',E_USER_WARNNG);
}}}return array(false,false);
} }
function strip_comments ( $data ) {
{$output = array('',false);
while ( (deAspis(($start = attAspis(strpos($data[0],'<!--')))) !== false) )
{$output = concat($output,Aspis_substr($data,array(0,false),$start));
if ( (deAspis(($end = attAspis(strpos($data[0],'-->',$start[0])))) !== false))
 {$data = Aspis_substr_replace($data,array('',false),array(0,false),array($end[0] + (3),false));
}else 
{{$data = array('',false);
}}}return concat($output,$data);
} }
function parse_date ( $dt ) {
{$parser = SimplePie_Parse_Date::get();
return $parser[0]->parse($dt);
} }
function entities_decode ( $data ) {
{$decoder = array(new SimplePie_Decode_HTML_Entities($data),false);
return $decoder[0]->parse();
} }
function uncomment_rfc822 ( $string ) {
{$string = string_cast($string);
$position = array(0,false);
$length = attAspis(strlen($string[0]));
$depth = array(0,false);
$output = array('',false);
while ( (($position[0] < $length[0]) && (deAspis(($pos = attAspis(strpos($string[0],'(',$position[0])))) !== false)) )
{$output = concat($output,Aspis_substr($string,$position,array($pos[0] - $position[0],false)));
$position = array($pos[0] + (1),false);
if ( (deAspis(attachAspis($string,($pos[0] - (1)))) !== ('\\')))
 {postincr($depth);
while ( ($depth[0] && ($position[0] < $length[0])) )
{$position = array(strcspn($string[0],('()'),$position[0]) + $position[0],false);
if ( (deAspis(attachAspis($string,($position[0] - (1)))) === ('\\')))
 {postincr($position);
continue ;
}elseif ( ((isset($string[0][$position[0]]) && Aspis_isset( $string [0][$position[0]]))))
 {switch ( deAspis(attachAspis($string,$position[0])) ) {
case ('('):postincr($depth);
break ;
case (')'):postdecr($depth);
break ;
 }
postincr($position);
}else 
{{break ;
}}}}else 
{{$output = concat2($output,'(');
}}}$output = concat($output,Aspis_substr($string,$position));
return $output;
} }
function parse_mime ( $mime ) {
{if ( (deAspis(($pos = attAspis(strpos($mime[0],';')))) === false))
 {return Aspis_trim($mime);
}else 
{{return Aspis_trim(Aspis_substr($mime,array(0,false),$pos));
}}} }
function htmlspecialchars_decode ( $string,$quote_style ) {
{if ( function_exists(('htmlspecialchars_decode')))
 {return Aspis_htmlspecialchars_decode($string,$quote_style);
}else 
{{return Aspis_strtr($string,Aspis_array_flip(attAspisRC(get_html_translation_table(HTML_SPECIALCHARS,$quote_style[0]))));
}}} }
function atom_03_construct_type ( $attribs ) {
{if ( (((isset($attribs[0][('')][0][('mode')]) && Aspis_isset( $attribs [0][('')] [0][('mode')]))) && deAspis(Aspis_strtolower(array(deAspis(Aspis_trim($attribs[0][('')][0]['mode'])) === ('base64'),false)))))
 {$mode = array(SIMPLEPIE_CONSTRUCT_BASE64,false);
}else 
{{$mode = array(SIMPLEPIE_CONSTRUCT_NONE,false);
}}if ( ((isset($attribs[0][('')][0][('type')]) && Aspis_isset( $attribs [0][('')] [0][('type')]))))
 {switch ( deAspis(Aspis_strtolower(Aspis_trim($attribs[0][('')][0]['type']))) ) {
case ('text'):case ('text/plain'):return array(SIMPLEPIE_CONSTRUCT_TEXT | $mode[0],false);
case ('html'):case ('text/html'):return array(SIMPLEPIE_CONSTRUCT_HTML | $mode[0],false);
case ('xhtml'):case ('application/xhtml+xml'):return array(SIMPLEPIE_CONSTRUCT_XHTML | $mode[0],false);
default :return array(SIMPLEPIE_CONSTRUCT_NONE | $mode[0],false);
 }
}else 
{{return array(SIMPLEPIE_CONSTRUCT_TEXT | $mode[0],false);
}}} }
function atom_10_construct_type ( $attribs ) {
{if ( ((isset($attribs[0][('')][0][('type')]) && Aspis_isset( $attribs [0][('')] [0][('type')]))))
 {switch ( deAspis(Aspis_strtolower(Aspis_trim($attribs[0][('')][0]['type']))) ) {
case ('text'):return array(SIMPLEPIE_CONSTRUCT_TEXT,false);
case ('html'):return array(SIMPLEPIE_CONSTRUCT_HTML,false);
case ('xhtml'):return array(SIMPLEPIE_CONSTRUCT_XHTML,false);
default :return array(SIMPLEPIE_CONSTRUCT_NONE,false);
 }
}return array(SIMPLEPIE_CONSTRUCT_TEXT,false);
} }
function atom_10_content_construct_type ( $attribs ) {
{if ( ((isset($attribs[0][('')][0][('type')]) && Aspis_isset( $attribs [0][('')] [0][('type')]))))
 {$type = Aspis_strtolower(Aspis_trim($attribs[0][('')][0]['type']));
switch ( $type[0] ) {
case ('text'):return array(SIMPLEPIE_CONSTRUCT_TEXT,false);
case ('html'):return array(SIMPLEPIE_CONSTRUCT_HTML,false);
case ('xhtml'):return array(SIMPLEPIE_CONSTRUCT_XHTML,false);
 }
if ( (deAspis(Aspis_in_array(Aspis_substr($type,negate(array(4,false))),array(array(array('+xml',false),array('/xml',false)),false))) || (deAspis(Aspis_substr($type,array(0,false),array(5,false))) === ('text/'))))
 {return array(SIMPLEPIE_CONSTRUCT_NONE,false);
}else 
{{return array(SIMPLEPIE_CONSTRUCT_BASE64,false);
}}}else 
{{return array(SIMPLEPIE_CONSTRUCT_TEXT,false);
}}} }
function is_isegment_nz_nc ( $string ) {
{return bool_cast(Aspis_preg_match(array('/^([A-Za-z0-9\-._~\x{A0}-\x{D7FF}\x{F900}-\x{FDCF}\x{FDF0}-\x{FFEF}\x{10000}-\x{1FFFD}\x{20000}-\x{2FFFD}\x{30000}-\x{3FFFD}\x{40000}-\x{4FFFD}\x{50000}-\x{5FFFD}\x{60000}-\x{6FFFD}\x{70000}-\x{7FFFD}\x{80000}-\x{8FFFD}\x{90000}-\x{9FFFD}\x{A0000}-\x{AFFFD}\x{B0000}-\x{BFFFD}\x{C0000}-\x{CFFFD}\x{D0000}-\x{DFFFD}\x{E1000}-\x{EFFFD}!$&\'()*+,;=@]|(%[0-9ABCDEF]{2}))+$/u',false),$string));
} }
function space_seperated_tokens ( $string ) {
{$space_characters = array("\x20\x09\x0A\x0B\x0C\x0D",false);
$string_length = attAspis(strlen($string[0]));
$position = attAspis(strspn($string[0],$space_characters[0]));
$tokens = array(array(),false);
while ( ($position[0] < $string_length[0]) )
{$len = attAspis(strcspn($string[0],$space_characters[0],$position[0]));
arrayAssignAdd($tokens[0][],addTaint(Aspis_substr($string,$position,$len)));
$position = array($len[0] + $position[0],false);
$position = array(strspn($string[0],$space_characters[0],$position[0]) + $position[0],false);
}return $tokens;
} }
function array_unique ( $array ) {
{if ( (version_compare(PHP_VERSION,'5.2','>=')))
 {return attAspisRC(array_unique(deAspisRC($array)));
}else 
{{$array = array_cast($array);
$new_array = array(array(),false);
$new_array_strings = array(array(),false);
foreach ( $array[0] as $key =>$value )
{restoreTaint($key,$value);
{if ( is_object($value[0]))
 {if ( method_exists(deAspisRC($value),('__toString')))
 {$cmp = $value[0]->__toString();
}else 
{{trigger_error((deconcat2(concat1('Object of class ',attAspis(get_class(deAspisRC($value)))),' could not be converted to string')),E_USER_ERROR);
}}}elseif ( is_array($value[0]))
 {$cmp = string_cast(Aspis_reset($value));
}else 
{{$cmp = string_cast($value);
}}if ( (denot_boolean(Aspis_in_array($cmp,$new_array_strings))))
 {arrayAssign($new_array[0],deAspis(registerTaint($key)),addTaint($value));
arrayAssignAdd($new_array_strings[0][],addTaint($cmp));
}}}return $new_array;
}}} }
function codepoint_to_utf8 ( $codepoint ) {
{$codepoint = int_cast($codepoint);
if ( ($codepoint[0] < (0)))
 {return array(false,false);
}else 
{if ( ($codepoint[0] <= (0x7f)))
 {return attAspis(chr($codepoint[0]));
}else 
{if ( ($codepoint[0] <= (0x7ff)))
 {return concat(attAspis(chr(((0xc0) | ($codepoint[0] >> (6))))),attAspis(chr(((0x80) | ($codepoint[0] & (0x3f))))));
}else 
{if ( ($codepoint[0] <= (0xffff)))
 {return concat(concat(attAspis(chr(((0xe0) | ($codepoint[0] >> (12))))),attAspis(chr(((0x80) | (($codepoint[0] >> (6)) & (0x3f)))))),attAspis(chr(((0x80) | ($codepoint[0] & (0x3f))))));
}else 
{if ( ($codepoint[0] <= (0x10ffff)))
 {return concat(concat(concat(attAspis(chr(((0xf0) | ($codepoint[0] >> (18))))),attAspis(chr(((0x80) | (($codepoint[0] >> (12)) & (0x3f)))))),attAspis(chr(((0x80) | (($codepoint[0] >> (6)) & (0x3f)))))),attAspis(chr(((0x80) | ($codepoint[0] & (0x3f))))));
}else 
{{return array("\xEF\xBF\xBD",false);
}}}}}}} }
function stripos ( $haystack,$needle,$offset = array(0,false) ) {
{if ( function_exists(('stripos')))
 {return array(stripos(deAspisRC($haystack),deAspisRC($needle),deAspisRC($offset)),false);
}else 
{{if ( is_string(deAspisRC($needle)))
 {$needle = Aspis_strtolower($needle);
}elseif ( ((is_int(deAspisRC($needle)) || is_bool(deAspisRC($needle))) || (is_double(deAspisRC($needle)))))
 {$needle = Aspis_strtolower(attAspis(chr($needle[0])));
}else 
{{trigger_error('needle is not a string or an integer',E_USER_WARNING);
return array(false,false);
}}return attAspis(strpos(deAspis(Aspis_strtolower($haystack)),deAspisRC($needle),$offset[0]));
}}} }
function parse_str ( $str ) {
{$return = array(array(),false);
$str = Aspis_explode(array('&',false),$str);
foreach ( $str[0] as $section  )
{if ( (strpos($section[0],'=') !== false))
 {list($name,$value) = deAspisList(Aspis_explode(array('=',false),$section,array(2,false)),array());
arrayAssignAdd($return[0][deAspis(Aspis_urldecode($name))][0][],addTaint(Aspis_urldecode($value)));
}else 
{{arrayAssignAdd($return[0][deAspis(Aspis_urldecode($section))][0][],addTaint(array(null,false)));
}}}return $return;
} }
function xml_encoding ( $data ) {
{if ( (deAspis(Aspis_substr($data,array(0,false),array(4,false))) === ("\x00\x00\xFE\xFF")))
 {arrayAssignAdd($encoding[0][],addTaint(array('UTF-32BE',false)));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(4,false))) === ("\xFF\xFE\x00\x00")))
 {arrayAssignAdd($encoding[0][],addTaint(array('UTF-32LE',false)));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(2,false))) === ("\xFE\xFF")))
 {arrayAssignAdd($encoding[0][],addTaint(array('UTF-16BE',false)));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(2,false))) === ("\xFF\xFE")))
 {arrayAssignAdd($encoding[0][],addTaint(array('UTF-16LE',false)));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(3,false))) === ("\xEF\xBB\xBF")))
 {arrayAssignAdd($encoding[0][],addTaint(array('UTF-8',false)));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(20,false))) === ("\x00\x00\x00\x3C\x00\x00\x00\x3F\x00\x00\x00\x78\x00\x00\x00\x6D\x00\x00\x00\x6C")))
 {if ( deAspis($pos = attAspis(strpos($data[0],"\x00\x00\x00\x3F\x00\x00\x00\x3E"))))
 {$parser = array(new SimplePie_XML_Declaration_Parser(SimplePie_Misc::change_encoding(Aspis_substr($data,array(20,false),array($pos[0] - (20),false)),array('UTF-32BE',false),array('UTF-8',false))),false);
if ( deAspis($parser[0]->parse()))
 {arrayAssignAdd($encoding[0][],addTaint($parser[0]->encoding));
}}arrayAssignAdd($encoding[0][],addTaint(array('UTF-32BE',false)));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(20,false))) === ("\x3C\x00\x00\x00\x3F\x00\x00\x00\x78\x00\x00\x00\x6D\x00\x00\x00\x6C\x00\x00\x00")))
 {if ( deAspis($pos = attAspis(strpos($data[0],"\x3F\x00\x00\x00\x3E\x00\x00\x00"))))
 {$parser = array(new SimplePie_XML_Declaration_Parser(SimplePie_Misc::change_encoding(Aspis_substr($data,array(20,false),array($pos[0] - (20),false)),array('UTF-32LE',false),array('UTF-8',false))),false);
if ( deAspis($parser[0]->parse()))
 {arrayAssignAdd($encoding[0][],addTaint($parser[0]->encoding));
}}arrayAssignAdd($encoding[0][],addTaint(array('UTF-32LE',false)));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(10,false))) === ("\x00\x3C\x00\x3F\x00\x78\x00\x6D\x00\x6C")))
 {if ( deAspis($pos = attAspis(strpos($data[0],"\x00\x3F\x00\x3E"))))
 {$parser = array(new SimplePie_XML_Declaration_Parser(SimplePie_Misc::change_encoding(Aspis_substr($data,array(20,false),array($pos[0] - (10),false)),array('UTF-16BE',false),array('UTF-8',false))),false);
if ( deAspis($parser[0]->parse()))
 {arrayAssignAdd($encoding[0][],addTaint($parser[0]->encoding));
}}arrayAssignAdd($encoding[0][],addTaint(array('UTF-16BE',false)));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(10,false))) === ("\x3C\x00\x3F\x00\x78\x00\x6D\x00\x6C\x00")))
 {if ( deAspis($pos = attAspis(strpos($data[0],"\x3F\x00\x3E\x00"))))
 {$parser = array(new SimplePie_XML_Declaration_Parser(SimplePie_Misc::change_encoding(Aspis_substr($data,array(20,false),array($pos[0] - (10),false)),array('UTF-16LE',false),array('UTF-8',false))),false);
if ( deAspis($parser[0]->parse()))
 {arrayAssignAdd($encoding[0][],addTaint($parser[0]->encoding));
}}arrayAssignAdd($encoding[0][],addTaint(array('UTF-16LE',false)));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(5,false))) === ("\x3C\x3F\x78\x6D\x6C")))
 {if ( deAspis($pos = attAspis(strpos($data[0],"\x3F\x3E"))))
 {$parser = array(new SimplePie_XML_Declaration_Parser(Aspis_substr($data,array(5,false),array($pos[0] - (5),false))),false);
if ( deAspis($parser[0]->parse()))
 {arrayAssignAdd($encoding[0][],addTaint($parser[0]->encoding));
}}arrayAssignAdd($encoding[0][],addTaint(array('UTF-8',false)));
}else 
{{arrayAssignAdd($encoding[0][],addTaint(array('UTF-8',false)));
}}return $encoding;
} }
function output_javascript (  ) {
{if ( function_exists(('ob_gzhandler')))
 {ob_start(AspisInternalCallback(array('ob_gzhandler',false)));
}header(('Content-type: text/javascript; charset: UTF-8'));
header(('Cache-Control: must-revalidate'));
header((deconcat2(concat1('Expires: ',attAspis(gmdate(('D, d M Y H:i:s'),(time() + (604800))))),' GMT')));
;
?>
function embed_odeo(link) {
	document.writeln('<embed src="http://odeo.com/flash/audio_player_fullsize.swf" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" quality="high" width="440" height="80" wmode="transparent" allowScriptAccess="any" flashvars="valid_sample_rate=true&external_url='+link+'"></embed>');
}

function embed_quicktime(type, bgcolor, width, height, link, placeholder, loop) {
	if (placeholder != '') {
		document.writeln('<embed type="'+type+'" style="cursor:hand; cursor:pointer;" href="'+link+'" src="'+placeholder+'" width="'+width+'" height="'+height+'" autoplay="false" target="myself" controller="false" loop="'+loop+'" scale="aspect" bgcolor="'+bgcolor+'" pluginspage="http://www.apple.com/quicktime/download/"></embed>');
	}
	else {
		document.writeln('<embed type="'+type+'" style="cursor:hand; cursor:pointer;" src="'+link+'" width="'+width+'" height="'+height+'" autoplay="false" target="myself" controller="true" loop="'+loop+'" scale="aspect" bgcolor="'+bgcolor+'" pluginspage="http://www.apple.com/quicktime/download/"></embed>');
	}
}

function embed_flash(bgcolor, width, height, link, loop, type) {
	document.writeln('<embed src="'+link+'" pluginspage="http://www.macromedia.com/go/getflashplayer" type="'+type+'" quality="high" width="'+width+'" height="'+height+'" bgcolor="'+bgcolor+'" loop="'+loop+'"></embed>');
}

function embed_flv(width, height, link, placeholder, loop, player) {
	document.writeln('<embed src="'+player+'" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" quality="high" width="'+width+'" height="'+height+'" wmode="transparent" flashvars="file='+link+'&autostart=false&repeat='+loop+'&showdigits=true&showfsbutton=false"></embed>');
}

function embed_wmedia(width, height, link) {
	document.writeln('<embed type="application/x-mplayer2" src="'+link+'" autosize="1" width="'+width+'" height="'+height+'" showcontrols="1" showstatusbar="0" showdisplay="0" autostart="0"></embed>');
}
		<?php } }
}class SimplePie_Decode_HTML_Entities{var $data = array('',false);
var $consumed = array('',false);
var $position = array(0,false);
function SimplePie_Decode_HTML_Entities ( $data ) {
{$this->data = $data;
} }
function parse (  ) {
{while ( (deAspis(($this->position = attAspis(strpos($this->data[0],'&',$this->position[0])))) !== false) )
{$this->consume();
$this->entity();
$this->consumed = array('',false);
}return $this->data;
} }
function consume (  ) {
{if ( ((isset($this->data[0][$this->position[0]]) && Aspis_isset( $this ->data [0][$this ->position [0]] ))))
 {$this->consumed = concat($this->consumed ,$this->data[0][$this->position[0]]);
return $this->data[0][deAspis(postincr($this->position))];
}else 
{{return array(false,false);
}}} }
function consume_range ( $chars ) {
{if ( deAspis($len = attAspis(strspn($this->data[0],$chars[0],$this->position[0]))))
 {$data = Aspis_substr($this->data,$this->position,$len);
$this->consumed = concat($this->consumed ,$data);
$this->position = array($len[0] + $this->position [0],false);
return $data;
}else 
{{return array(false,false);
}}} }
function unconsume (  ) {
{$this->consumed = Aspis_substr($this->consumed,array(0,false),negate(array(1,false)));
postdecr($this->position);
} }
function entity (  ) {
{switch ( deAspis($this->consume()) ) {
case ("\x09"):case ("\x0A"):case ("\x0B"):case ("\x0B"):case ("\x0C"):case ("\x20"):case ("\x3C"):case ("\x26"):case false:break ;
case ("\x23"):switch ( deAspis($this->consume()) ) {
case ("\x78"):case ("\x58"):$range = array('0123456789ABCDEFabcdef',false);
$hex = array(true,false);
break ;
default :$range = array('0123456789',false);
$hex = array(false,false);
$this->unconsume();
break ;
 }
if ( deAspis($codepoint = $this->consume_range($range)))
 {static $windows_1252_specials = array(array(0x0D => array("\x0A",false),0x80 => array("\xE2\x82\xAC",false),0x81 => array("\xEF\xBF\xBD",false),0x82 => array("\xE2\x80\x9A",false),0x83 => array("\xC6\x92",false),0x84 => array("\xE2\x80\x9E",false),0x85 => array("\xE2\x80\xA6",false),0x86 => array("\xE2\x80\xA0",false),0x87 => array("\xE2\x80\xA1",false),0x88 => array("\xCB\x86",false),0x89 => array("\xE2\x80\xB0",false),0x8A => array("\xC5\xA0",false),0x8B => array("\xE2\x80\xB9",false),0x8C => array("\xC5\x92",false),0x8D => array("\xEF\xBF\xBD",false),0x8E => array("\xC5\xBD",false),0x8F => array("\xEF\xBF\xBD",false),0x90 => array("\xEF\xBF\xBD",false),0x91 => array("\xE2\x80\x98",false),0x92 => array("\xE2\x80\x99",false),0x93 => array("\xE2\x80\x9C",false),0x94 => array("\xE2\x80\x9D",false),0x95 => array("\xE2\x80\xA2",false),0x96 => array("\xE2\x80\x93",false),0x97 => array("\xE2\x80\x94",false),0x98 => array("\xCB\x9C",false),0x99 => array("\xE2\x84\xA2",false),0x9A => array("\xC5\xA1",false),0x9B => array("\xE2\x80\xBA",false),0x9C => array("\xC5\x93",false),0x9D => array("\xEF\xBF\xBD",false),0x9E => array("\xC5\xBE",false),0x9F => array("\xC5\xB8",false)),false);
if ( $hex[0])
 {$codepoint = Aspis_hexdec($codepoint);
}else 
{{$codepoint = Aspis_intval($codepoint);
}}if ( ((isset($windows_1252_specials[0][$codepoint[0]]) && Aspis_isset( $windows_1252_specials [0][$codepoint[0]]))))
 {$replacement = attachAspis($windows_1252_specials,$codepoint[0]);
}else 
{{$replacement = SimplePie_Misc::codepoint_to_utf8($codepoint);
}}if ( (denot_boolean(Aspis_in_array($this->consume(),array(array(array(';',false),array(false,false)),false),array(true,false)))))
 {$this->unconsume();
}$consumed_length = attAspis(strlen($this->consumed[0]));
$this->data = Aspis_substr_replace($this->data,$replacement,array($this->position[0] - $consumed_length[0],false),$consumed_length);
$this->position = array((strlen($replacement[0]) - $consumed_length[0]) + $this->position [0],false);
}break ;
default :static $entities = array(array('Aacute' => array("\xC3\x81",false),'aacute' => array("\xC3\xA1",false),'Aacute;' => array("\xC3\x81",false),'aacute;' => array("\xC3\xA1",false),'Acirc' => array("\xC3\x82",false),'acirc' => array("\xC3\xA2",false),'Acirc;' => array("\xC3\x82",false),'acirc;' => array("\xC3\xA2",false),'acute' => array("\xC2\xB4",false),'acute;' => array("\xC2\xB4",false),'AElig' => array("\xC3\x86",false),'aelig' => array("\xC3\xA6",false),'AElig;' => array("\xC3\x86",false),'aelig;' => array("\xC3\xA6",false),'Agrave' => array("\xC3\x80",false),'agrave' => array("\xC3\xA0",false),'Agrave;' => array("\xC3\x80",false),'agrave;' => array("\xC3\xA0",false),'alefsym;' => array("\xE2\x84\xB5",false),'Alpha;' => array("\xCE\x91",false),'alpha;' => array("\xCE\xB1",false),'AMP' => array("\x26",false),'amp' => array("\x26",false),'AMP;' => array("\x26",false),'amp;' => array("\x26",false),'and;' => array("\xE2\x88\xA7",false),'ang;' => array("\xE2\x88\xA0",false),'apos;' => array("\x27",false),'Aring' => array("\xC3\x85",false),'aring' => array("\xC3\xA5",false),'Aring;' => array("\xC3\x85",false),'aring;' => array("\xC3\xA5",false),'asymp;' => array("\xE2\x89\x88",false),'Atilde' => array("\xC3\x83",false),'atilde' => array("\xC3\xA3",false),'Atilde;' => array("\xC3\x83",false),'atilde;' => array("\xC3\xA3",false),'Auml' => array("\xC3\x84",false),'auml' => array("\xC3\xA4",false),'Auml;' => array("\xC3\x84",false),'auml;' => array("\xC3\xA4",false),'bdquo;' => array("\xE2\x80\x9E",false),'Beta;' => array("\xCE\x92",false),'beta;' => array("\xCE\xB2",false),'brvbar' => array("\xC2\xA6",false),'brvbar;' => array("\xC2\xA6",false),'bull;' => array("\xE2\x80\xA2",false),'cap;' => array("\xE2\x88\xA9",false),'Ccedil' => array("\xC3\x87",false),'ccedil' => array("\xC3\xA7",false),'Ccedil;' => array("\xC3\x87",false),'ccedil;' => array("\xC3\xA7",false),'cedil' => array("\xC2\xB8",false),'cedil;' => array("\xC2\xB8",false),'cent' => array("\xC2\xA2",false),'cent;' => array("\xC2\xA2",false),'Chi;' => array("\xCE\xA7",false),'chi;' => array("\xCF\x87",false),'circ;' => array("\xCB\x86",false),'clubs;' => array("\xE2\x99\xA3",false),'cong;' => array("\xE2\x89\x85",false),'COPY' => array("\xC2\xA9",false),'copy' => array("\xC2\xA9",false),'COPY;' => array("\xC2\xA9",false),'copy;' => array("\xC2\xA9",false),'crarr;' => array("\xE2\x86\xB5",false),'cup;' => array("\xE2\x88\xAA",false),'curren' => array("\xC2\xA4",false),'curren;' => array("\xC2\xA4",false),'Dagger;' => array("\xE2\x80\xA1",false),'dagger;' => array("\xE2\x80\xA0",false),'dArr;' => array("\xE2\x87\x93",false),'darr;' => array("\xE2\x86\x93",false),'deg' => array("\xC2\xB0",false),'deg;' => array("\xC2\xB0",false),'Delta;' => array("\xCE\x94",false),'delta;' => array("\xCE\xB4",false),'diams;' => array("\xE2\x99\xA6",false),'divide' => array("\xC3\xB7",false),'divide;' => array("\xC3\xB7",false),'Eacute' => array("\xC3\x89",false),'eacute' => array("\xC3\xA9",false),'Eacute;' => array("\xC3\x89",false),'eacute;' => array("\xC3\xA9",false),'Ecirc' => array("\xC3\x8A",false),'ecirc' => array("\xC3\xAA",false),'Ecirc;' => array("\xC3\x8A",false),'ecirc;' => array("\xC3\xAA",false),'Egrave' => array("\xC3\x88",false),'egrave' => array("\xC3\xA8",false),'Egrave;' => array("\xC3\x88",false),'egrave;' => array("\xC3\xA8",false),'empty;' => array("\xE2\x88\x85",false),'emsp;' => array("\xE2\x80\x83",false),'ensp;' => array("\xE2\x80\x82",false),'Epsilon;' => array("\xCE\x95",false),'epsilon;' => array("\xCE\xB5",false),'equiv;' => array("\xE2\x89\xA1",false),'Eta;' => array("\xCE\x97",false),'eta;' => array("\xCE\xB7",false),'ETH' => array("\xC3\x90",false),'eth' => array("\xC3\xB0",false),'ETH;' => array("\xC3\x90",false),'eth;' => array("\xC3\xB0",false),'Euml' => array("\xC3\x8B",false),'euml' => array("\xC3\xAB",false),'Euml;' => array("\xC3\x8B",false),'euml;' => array("\xC3\xAB",false),'euro;' => array("\xE2\x82\xAC",false),'exist;' => array("\xE2\x88\x83",false),'fnof;' => array("\xC6\x92",false),'forall;' => array("\xE2\x88\x80",false),'frac12' => array("\xC2\xBD",false),'frac12;' => array("\xC2\xBD",false),'frac14' => array("\xC2\xBC",false),'frac14;' => array("\xC2\xBC",false),'frac34' => array("\xC2\xBE",false),'frac34;' => array("\xC2\xBE",false),'frasl;' => array("\xE2\x81\x84",false),'Gamma;' => array("\xCE\x93",false),'gamma;' => array("\xCE\xB3",false),'ge;' => array("\xE2\x89\xA5",false),'GT' => array("\x3E",false),'gt' => array("\x3E",false),'GT;' => array("\x3E",false),'gt;' => array("\x3E",false),'hArr;' => array("\xE2\x87\x94",false),'harr;' => array("\xE2\x86\x94",false),'hearts;' => array("\xE2\x99\xA5",false),'hellip;' => array("\xE2\x80\xA6",false),'Iacute' => array("\xC3\x8D",false),'iacute' => array("\xC3\xAD",false),'Iacute;' => array("\xC3\x8D",false),'iacute;' => array("\xC3\xAD",false),'Icirc' => array("\xC3\x8E",false),'icirc' => array("\xC3\xAE",false),'Icirc;' => array("\xC3\x8E",false),'icirc;' => array("\xC3\xAE",false),'iexcl' => array("\xC2\xA1",false),'iexcl;' => array("\xC2\xA1",false),'Igrave' => array("\xC3\x8C",false),'igrave' => array("\xC3\xAC",false),'Igrave;' => array("\xC3\x8C",false),'igrave;' => array("\xC3\xAC",false),'image;' => array("\xE2\x84\x91",false),'infin;' => array("\xE2\x88\x9E",false),'int;' => array("\xE2\x88\xAB",false),'Iota;' => array("\xCE\x99",false),'iota;' => array("\xCE\xB9",false),'iquest' => array("\xC2\xBF",false),'iquest;' => array("\xC2\xBF",false),'isin;' => array("\xE2\x88\x88",false),'Iuml' => array("\xC3\x8F",false),'iuml' => array("\xC3\xAF",false),'Iuml;' => array("\xC3\x8F",false),'iuml;' => array("\xC3\xAF",false),'Kappa;' => array("\xCE\x9A",false),'kappa;' => array("\xCE\xBA",false),'Lambda;' => array("\xCE\x9B",false),'lambda;' => array("\xCE\xBB",false),'lang;' => array("\xE3\x80\x88",false),'laquo' => array("\xC2\xAB",false),'laquo;' => array("\xC2\xAB",false),'lArr;' => array("\xE2\x87\x90",false),'larr;' => array("\xE2\x86\x90",false),'lceil;' => array("\xE2\x8C\x88",false),'ldquo;' => array("\xE2\x80\x9C",false),'le;' => array("\xE2\x89\xA4",false),'lfloor;' => array("\xE2\x8C\x8A",false),'lowast;' => array("\xE2\x88\x97",false),'loz;' => array("\xE2\x97\x8A",false),'lrm;' => array("\xE2\x80\x8E",false),'lsaquo;' => array("\xE2\x80\xB9",false),'lsquo;' => array("\xE2\x80\x98",false),'LT' => array("\x3C",false),'lt' => array("\x3C",false),'LT;' => array("\x3C",false),'lt;' => array("\x3C",false),'macr' => array("\xC2\xAF",false),'macr;' => array("\xC2\xAF",false),'mdash;' => array("\xE2\x80\x94",false),'micro' => array("\xC2\xB5",false),'micro;' => array("\xC2\xB5",false),'middot' => array("\xC2\xB7",false),'middot;' => array("\xC2\xB7",false),'minus;' => array("\xE2\x88\x92",false),'Mu;' => array("\xCE\x9C",false),'mu;' => array("\xCE\xBC",false),'nabla;' => array("\xE2\x88\x87",false),'nbsp' => array("\xC2\xA0",false),'nbsp;' => array("\xC2\xA0",false),'ndash;' => array("\xE2\x80\x93",false),'ne;' => array("\xE2\x89\xA0",false),'ni;' => array("\xE2\x88\x8B",false),'not' => array("\xC2\xAC",false),'not;' => array("\xC2\xAC",false),'notin;' => array("\xE2\x88\x89",false),'nsub;' => array("\xE2\x8A\x84",false),'Ntilde' => array("\xC3\x91",false),'ntilde' => array("\xC3\xB1",false),'Ntilde;' => array("\xC3\x91",false),'ntilde;' => array("\xC3\xB1",false),'Nu;' => array("\xCE\x9D",false),'nu;' => array("\xCE\xBD",false),'Oacute' => array("\xC3\x93",false),'oacute' => array("\xC3\xB3",false),'Oacute;' => array("\xC3\x93",false),'oacute;' => array("\xC3\xB3",false),'Ocirc' => array("\xC3\x94",false),'ocirc' => array("\xC3\xB4",false),'Ocirc;' => array("\xC3\x94",false),'ocirc;' => array("\xC3\xB4",false),'OElig;' => array("\xC5\x92",false),'oelig;' => array("\xC5\x93",false),'Ograve' => array("\xC3\x92",false),'ograve' => array("\xC3\xB2",false),'Ograve;' => array("\xC3\x92",false),'ograve;' => array("\xC3\xB2",false),'oline;' => array("\xE2\x80\xBE",false),'Omega;' => array("\xCE\xA9",false),'omega;' => array("\xCF\x89",false),'Omicron;' => array("\xCE\x9F",false),'omicron;' => array("\xCE\xBF",false),'oplus;' => array("\xE2\x8A\x95",false),'or;' => array("\xE2\x88\xA8",false),'ordf' => array("\xC2\xAA",false),'ordf;' => array("\xC2\xAA",false),'ordm' => array("\xC2\xBA",false),'ordm;' => array("\xC2\xBA",false),'Oslash' => array("\xC3\x98",false),'oslash' => array("\xC3\xB8",false),'Oslash;' => array("\xC3\x98",false),'oslash;' => array("\xC3\xB8",false),'Otilde' => array("\xC3\x95",false),'otilde' => array("\xC3\xB5",false),'Otilde;' => array("\xC3\x95",false),'otilde;' => array("\xC3\xB5",false),'otimes;' => array("\xE2\x8A\x97",false),'Ouml' => array("\xC3\x96",false),'ouml' => array("\xC3\xB6",false),'Ouml;' => array("\xC3\x96",false),'ouml;' => array("\xC3\xB6",false),'para' => array("\xC2\xB6",false),'para;' => array("\xC2\xB6",false),'part;' => array("\xE2\x88\x82",false),'permil;' => array("\xE2\x80\xB0",false),'perp;' => array("\xE2\x8A\xA5",false),'Phi;' => array("\xCE\xA6",false),'phi;' => array("\xCF\x86",false),'Pi;' => array("\xCE\xA0",false),'pi;' => array("\xCF\x80",false),'piv;' => array("\xCF\x96",false),'plusmn' => array("\xC2\xB1",false),'plusmn;' => array("\xC2\xB1",false),'pound' => array("\xC2\xA3",false),'pound;' => array("\xC2\xA3",false),'Prime;' => array("\xE2\x80\xB3",false),'prime;' => array("\xE2\x80\xB2",false),'prod;' => array("\xE2\x88\x8F",false),'prop;' => array("\xE2\x88\x9D",false),'Psi;' => array("\xCE\xA8",false),'psi;' => array("\xCF\x88",false),'QUOT' => array("\x22",false),'quot' => array("\x22",false),'QUOT;' => array("\x22",false),'quot;' => array("\x22",false),'radic;' => array("\xE2\x88\x9A",false),'rang;' => array("\xE3\x80\x89",false),'raquo' => array("\xC2\xBB",false),'raquo;' => array("\xC2\xBB",false),'rArr;' => array("\xE2\x87\x92",false),'rarr;' => array("\xE2\x86\x92",false),'rceil;' => array("\xE2\x8C\x89",false),'rdquo;' => array("\xE2\x80\x9D",false),'real;' => array("\xE2\x84\x9C",false),'REG' => array("\xC2\xAE",false),'reg' => array("\xC2\xAE",false),'REG;' => array("\xC2\xAE",false),'reg;' => array("\xC2\xAE",false),'rfloor;' => array("\xE2\x8C\x8B",false),'Rho;' => array("\xCE\xA1",false),'rho;' => array("\xCF\x81",false),'rlm;' => array("\xE2\x80\x8F",false),'rsaquo;' => array("\xE2\x80\xBA",false),'rsquo;' => array("\xE2\x80\x99",false),'sbquo;' => array("\xE2\x80\x9A",false),'Scaron;' => array("\xC5\xA0",false),'scaron;' => array("\xC5\xA1",false),'sdot;' => array("\xE2\x8B\x85",false),'sect' => array("\xC2\xA7",false),'sect;' => array("\xC2\xA7",false),'shy' => array("\xC2\xAD",false),'shy;' => array("\xC2\xAD",false),'Sigma;' => array("\xCE\xA3",false),'sigma;' => array("\xCF\x83",false),'sigmaf;' => array("\xCF\x82",false),'sim;' => array("\xE2\x88\xBC",false),'spades;' => array("\xE2\x99\xA0",false),'sub;' => array("\xE2\x8A\x82",false),'sube;' => array("\xE2\x8A\x86",false),'sum;' => array("\xE2\x88\x91",false),'sup;' => array("\xE2\x8A\x83",false),'sup1' => array("\xC2\xB9",false),'sup1;' => array("\xC2\xB9",false),'sup2' => array("\xC2\xB2",false),'sup2;' => array("\xC2\xB2",false),'sup3' => array("\xC2\xB3",false),'sup3;' => array("\xC2\xB3",false),'supe;' => array("\xE2\x8A\x87",false),'szlig' => array("\xC3\x9F",false),'szlig;' => array("\xC3\x9F",false),'Tau;' => array("\xCE\xA4",false),'tau;' => array("\xCF\x84",false),'there4;' => array("\xE2\x88\xB4",false),'Theta;' => array("\xCE\x98",false),'theta;' => array("\xCE\xB8",false),'thetasym;' => array("\xCF\x91",false),'thinsp;' => array("\xE2\x80\x89",false),'THORN' => array("\xC3\x9E",false),'thorn' => array("\xC3\xBE",false),'THORN;' => array("\xC3\x9E",false),'thorn;' => array("\xC3\xBE",false),'tilde;' => array("\xCB\x9C",false),'times' => array("\xC3\x97",false),'times;' => array("\xC3\x97",false),'TRADE;' => array("\xE2\x84\xA2",false),'trade;' => array("\xE2\x84\xA2",false),'Uacute' => array("\xC3\x9A",false),'uacute' => array("\xC3\xBA",false),'Uacute;' => array("\xC3\x9A",false),'uacute;' => array("\xC3\xBA",false),'uArr;' => array("\xE2\x87\x91",false),'uarr;' => array("\xE2\x86\x91",false),'Ucirc' => array("\xC3\x9B",false),'ucirc' => array("\xC3\xBB",false),'Ucirc;' => array("\xC3\x9B",false),'ucirc;' => array("\xC3\xBB",false),'Ugrave' => array("\xC3\x99",false),'ugrave' => array("\xC3\xB9",false),'Ugrave;' => array("\xC3\x99",false),'ugrave;' => array("\xC3\xB9",false),'uml' => array("\xC2\xA8",false),'uml;' => array("\xC2\xA8",false),'upsih;' => array("\xCF\x92",false),'Upsilon;' => array("\xCE\xA5",false),'upsilon;' => array("\xCF\x85",false),'Uuml' => array("\xC3\x9C",false),'uuml' => array("\xC3\xBC",false),'Uuml;' => array("\xC3\x9C",false),'uuml;' => array("\xC3\xBC",false),'weierp;' => array("\xE2\x84\x98",false),'Xi;' => array("\xCE\x9E",false),'xi;' => array("\xCE\xBE",false),'Yacute' => array("\xC3\x9D",false),'yacute' => array("\xC3\xBD",false),'Yacute;' => array("\xC3\x9D",false),'yacute;' => array("\xC3\xBD",false),'yen' => array("\xC2\xA5",false),'yen;' => array("\xC2\xA5",false),'yuml' => array("\xC3\xBF",false),'Yuml;' => array("\xC5\xB8",false),'yuml;' => array("\xC3\xBF",false),'Zeta;' => array("\xCE\x96",false),'zeta;' => array("\xCE\xB6",false),'zwj;' => array("\xE2\x80\x8D",false),'zwnj;' => array("\xE2\x80\x8C",false)),false);
for ( $i = array(0,false),$match = array(null,false) ; (($i[0] < (9)) && (deAspis($this->consume()) !== false)) ; postincr($i) )
{$consumed = Aspis_substr($this->consumed,array(1,false));
if ( ((isset($entities[0][$consumed[0]]) && Aspis_isset( $entities [0][$consumed[0]]))))
 {$match = $consumed;
}}if ( ($match[0] !== null))
 {$this->data = Aspis_substr_replace($this->data,attachAspis($entities,$match[0]),array(($this->position[0] - strlen($consumed[0])) - (1),false),array(strlen($match[0]) + (1),false));
$this->position = array(((strlen(deAspis(attachAspis($entities,$match[0]))) - strlen($consumed[0])) - (1)) + $this->position [0],false);
}break ;
 }
} }
}class SimplePie_IRI{var $scheme;
var $userinfo;
var $host;
var $port;
var $path;
var $query;
var $fragment;
var $valid = array(array(),false);
function __toString (  ) {
{return $this->get_iri();
} }
function SimplePie_IRI ( $iri ) {
{$iri = string_cast($iri);
if ( ($iri[0] !== ('')))
 {$parsed = $this->parse_iri($iri);
$this->set_scheme($parsed[0]['scheme']);
$this->set_authority($parsed[0]['authority']);
$this->set_path($parsed[0]['path']);
$this->set_query($parsed[0]['query']);
$this->set_fragment($parsed[0]['fragment']);
}} }
function absolutize ( $base,$relative ) {
{$relative = string_cast($relative);
if ( ($relative[0] !== ('')))
 {$relative = array(new SimplePie_IRI($relative),false);
if ( (deAspis($relative[0]->get_scheme()) !== null))
 {$target = $relative;
}elseif ( (deAspis($base[0]->get_iri()) !== null))
 {if ( (deAspis($relative[0]->get_authority()) !== null))
 {$target = $relative;
$target[0]->set_scheme($base[0]->get_scheme());
}else 
{{$target = array(new SimplePie_IRI(array('',false)),false);
$target[0]->set_scheme($base[0]->get_scheme());
$target[0]->set_userinfo($base[0]->get_userinfo());
$target[0]->set_host($base[0]->get_host());
$target[0]->set_port($base[0]->get_port());
if ( (deAspis($relative[0]->get_path()) !== null))
 {if ( (strpos(deAspis($relative[0]->get_path()),'/') === (0)))
 {$target[0]->set_path($relative[0]->get_path());
}elseif ( ((((deAspis($base[0]->get_userinfo()) !== null) || (deAspis($base[0]->get_host()) !== null)) || (deAspis($base[0]->get_port()) !== null)) && (deAspis($base[0]->get_path()) === null)))
 {$target[0]->set_path(concat1('/',$relative[0]->get_path()));
}elseif ( (deAspis(($last_segment = attAspis(strrpos(deAspis($base[0]->get_path()),('/'))))) !== false))
 {$target[0]->set_path(concat(Aspis_substr($base[0]->get_path(),array(0,false),array($last_segment[0] + (1),false)),$relative[0]->get_path()));
}else 
{{$target[0]->set_path($relative[0]->get_path());
}}$target[0]->set_query($relative[0]->get_query());
}else 
{{$target[0]->set_path($base[0]->get_path());
if ( (deAspis($relative[0]->get_query()) !== null))
 {$target[0]->set_query($relative[0]->get_query());
}elseif ( (deAspis($base[0]->get_query()) !== null))
 {$target[0]->set_query($base[0]->get_query());
}}}}}$target[0]->set_fragment($relative[0]->get_fragment());
}else 
{{$target = $relative;
}}}else 
{{$target = $base;
}}return $target;
} }
function parse_iri ( $iri ) {
{Aspis_preg_match(array('/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?$/',false),$iri,$match);
for ( $i = attAspis(count($match[0])) ; ($i[0] <= (9)) ; postincr($i) )
{arrayAssign($match[0],deAspis(registerTaint($i)),addTaint(array('',false)));
}return array(array(deregisterTaint(array('scheme',false)) => addTaint(attachAspis($match,(2))),deregisterTaint(array('authority',false)) => addTaint(attachAspis($match,(4))),deregisterTaint(array('path',false)) => addTaint(attachAspis($match,(5))),deregisterTaint(array('query',false)) => addTaint(attachAspis($match,(7))),deregisterTaint(array('fragment',false)) => addTaint(attachAspis($match,(9)))),false);
} }
function remove_dot_segments ( $input ) {
{$output = array('',false);
while ( ((((strpos($input[0],'./') !== false) || (strpos($input[0],'/.') !== false)) || ($input[0] === ('.'))) || ($input[0] === ('..'))) )
{if ( (strpos($input[0],'../') === (0)))
 {$input = Aspis_substr($input,array(3,false));
}elseif ( (strpos($input[0],'./') === (0)))
 {$input = Aspis_substr($input,array(2,false));
}elseif ( (strpos($input[0],'/./') === (0)))
 {$input = Aspis_substr_replace($input,array('/',false),array(0,false),array(3,false));
}elseif ( ($input[0] === ('/.')))
 {$input = array('/',false);
}elseif ( (strpos($input[0],'/../') === (0)))
 {$input = Aspis_substr_replace($input,array('/',false),array(0,false),array(4,false));
$output = Aspis_substr_replace($output,array('',false),attAspis(strrpos($output[0],('/'))));
}elseif ( ($input[0] === ('/..')))
 {$input = array('/',false);
$output = Aspis_substr_replace($output,array('',false),attAspis(strrpos($output[0],('/'))));
}elseif ( (($input[0] === ('.')) || ($input[0] === ('..'))))
 {$input = array('',false);
}elseif ( (deAspis(($pos = attAspis(strpos($input[0],'/',(1))))) !== false))
 {$output = concat($output,Aspis_substr($input,array(0,false),$pos));
$input = Aspis_substr_replace($input,array('',false),array(0,false),$pos);
}else 
{{$output = concat($output,$input);
$input = array('',false);
}}}return concat($output,$input);
} }
function replace_invalid_with_pct_encoding ( $string,$valid_chars,$case = array(SIMPLEPIE_SAME_CASE,false) ) {
{if ( ($case[0] & SIMPLEPIE_LOWERCASE))
 {$string = Aspis_strtolower($string);
}elseif ( ($case[0] & SIMPLEPIE_UPPERCASE))
 {$string = Aspis_strtoupper($string);
}$position = array(0,false);
$strlen = attAspis(strlen($string[0]));
while ( (deAspis(($position = array(strspn($string[0],$valid_chars[0],$position[0]) + $position[0],false))) < $strlen[0]) )
{if ( (deAspis(attachAspis($string,$position[0])) === ('%')))
 {if ( ((($position[0] + (2)) < $strlen[0]) && (strspn($string[0],('0123456789ABCDEFabcdef'),($position[0] + (1)),(2)) === (2))))
 {$chr = attAspis(chr(deAspis(Aspis_hexdec(Aspis_substr($string,array($position[0] + (1),false),array(2,false))))));
if ( (strpos($valid_chars[0],deAspisRC($chr)) !== false))
 {if ( ($case[0] & SIMPLEPIE_LOWERCASE))
 {$chr = Aspis_strtolower($chr);
}elseif ( ($case[0] & SIMPLEPIE_UPPERCASE))
 {$chr = Aspis_strtoupper($chr);
}$string = Aspis_substr_replace($string,$chr,$position,array(3,false));
$strlen = array($strlen[0] - (2),false);
postincr($position);
}else 
{{$string = Aspis_substr_replace($string,Aspis_strtoupper(Aspis_substr($string,array($position[0] + (1),false),array(2,false))),array($position[0] + (1),false),array(2,false));
$position = array((3) + $position[0],false);
}}}else 
{{$string = Aspis_substr_replace($string,array('%25',false),$position,array(1,false));
$strlen = array((2) + $strlen[0],false);
$position = array((3) + $position[0],false);
}}}else 
{{$replacement = Aspis_sprintf(array("%%%02X",false),attAspis(ord(deAspis(attachAspis($string,$position[0])))));
$string = Aspis_str_replace(attachAspis($string,$position[0]),$replacement,$string);
$strlen = attAspis(strlen($string[0]));
}}}return $string;
} }
function is_valid (  ) {
{return array(deAspis(attAspisRC(array_sum(deAspisRC($this->valid)))) === count($this->valid[0]),false);
} }
function set_scheme ( $scheme ) {
{if ( (($scheme[0] === null) || ($scheme[0] === (''))))
 {$this->scheme = array(null,false);
}else 
{{$len = attAspis(strlen($scheme[0]));
switch ( true ) {
case ($len[0] > (1)):if ( (!(strspn($scheme[0],('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+-.'),(1)))))
 {$this->scheme = array(null,false);
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(false,false)));
return array(false,false);
}case ($len[0] > (0)):if ( (!(strspn($scheme[0],('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'),(0),(1)))))
 {$this->scheme = array(null,false);
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(false,false)));
return array(false,false);
} }
$this->scheme = Aspis_strtolower($scheme);
}}arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
} }
function set_authority ( $authority ) {
{if ( (deAspis(($userinfo_end = attAspis(strrpos($authority[0],('@'))))) !== false))
 {$userinfo = Aspis_substr($authority,array(0,false),$userinfo_end);
$authority = Aspis_substr($authority,array($userinfo_end[0] + (1),false));
}else 
{{$userinfo = array(null,false);
}}if ( (deAspis(($port_start = attAspis(strpos($authority[0],':')))) !== false))
 {$port = Aspis_substr($authority,array($port_start[0] + (1),false));
$authority = Aspis_substr($authority,array(0,false),$port_start);
}else 
{{$port = array(null,false);
}}return array((deAspis($this->set_userinfo($userinfo)) && deAspis($this->set_host($authority))) && deAspis($this->set_port($port)),false);
} }
function set_userinfo ( $userinfo ) {
{if ( (($userinfo[0] === null) || ($userinfo[0] === (''))))
 {$this->userinfo = array(null,false);
}else 
{{$this->userinfo = $this->replace_invalid_with_pct_encoding($userinfo,array('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$&\'()*+,;=:',false));
}}arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
} }
function set_host ( $host ) {
{if ( (($host[0] === null) || ($host[0] === (''))))
 {$this->host = array(null,false);
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
}elseif ( ((deAspis(attachAspis($host,(0))) === ('[')) && (deAspis(Aspis_substr($host,negate(array(1,false)))) === (']'))))
 {if ( deAspis(Net_IPv6::checkIPv6(Aspis_substr($host,array(1,false),negate(array(1,false))))))
 {$this->host = $host;
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
}else 
{{$this->host = array(null,false);
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(false,false)));
return array(false,false);
}}}else 
{{$this->host = $this->replace_invalid_with_pct_encoding($host,array('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$&\'()*+,;=',false),array(SIMPLEPIE_LOWERCASE,false));
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
}}} }
function set_port ( $port ) {
{if ( (($port[0] === null) || ($port[0] === (''))))
 {$this->port = array(null,false);
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
}elseif ( (strspn($port[0],('0123456789')) === strlen($port[0])))
 {$this->port = int_cast($port);
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
}else 
{{$this->port = array(null,false);
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(false,false)));
return array(false,false);
}}} }
function set_path ( $path ) {
{if ( (($path[0] === null) || ($path[0] === (''))))
 {$this->path = array(null,false);
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
}elseif ( ((((deAspis(Aspis_substr($path,array(0,false),array(2,false))) === ('//')) && ($this->userinfo[0] === null)) && ($this->host[0] === null)) && ($this->port[0] === null)))
 {$this->path = array(null,false);
arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(false,false)));
return array(false,false);
}else 
{{$this->path = $this->replace_invalid_with_pct_encoding($path,array('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$&\'()*+,;=@/',false));
if ( ($this->scheme[0] !== null))
 {$this->path = $this->remove_dot_segments($this->path);
}arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
}}} }
function set_query ( $query ) {
{if ( (($query[0] === null) || ($query[0] === (''))))
 {$this->query = array(null,false);
}else 
{{$this->query = $this->replace_invalid_with_pct_encoding($query,array('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$&\'()*+,;=:@/?',false));
}}arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
} }
function set_fragment ( $fragment ) {
{if ( (($fragment[0] === null) || ($fragment[0] === (''))))
 {$this->fragment = array(null,false);
}else 
{{$this->fragment = $this->replace_invalid_with_pct_encoding($fragment,array('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$&\'()*+,;=:@/?',false));
}}arrayAssign($this->valid[0],deAspis(registerTaint(array(__FUNCTION__,false))),addTaint(array(true,false)));
return array(true,false);
} }
function get_iri (  ) {
{$iri = array('',false);
if ( ($this->scheme[0] !== null))
 {$iri = concat($iri,concat2($this->scheme,':'));
}if ( (deAspis(($authority = $this->get_authority())) !== null))
 {$iri = concat($iri,concat1('//',$authority));
}if ( ($this->path[0] !== null))
 {$iri = concat($iri,$this->path);
}if ( ($this->query[0] !== null))
 {$iri = concat($iri,concat1('?',$this->query));
}if ( ($this->fragment[0] !== null))
 {$iri = concat($iri,concat1('#',$this->fragment));
}if ( ($iri[0] !== ('')))
 {return $iri;
}else 
{{return array(null,false);
}}} }
function get_scheme (  ) {
{return $this->scheme;
} }
function get_authority (  ) {
{$authority = array('',false);
if ( ($this->userinfo[0] !== null))
 {$authority = concat($authority,concat2($this->userinfo,'@'));
}if ( ($this->host[0] !== null))
 {$authority = concat($authority,$this->host);
}if ( ($this->port[0] !== null))
 {$authority = concat($authority,concat1(':',$this->port));
}if ( ($authority[0] !== ('')))
 {return $authority;
}else 
{{return array(null,false);
}}} }
function get_userinfo (  ) {
{return $this->userinfo;
} }
function get_host (  ) {
{return $this->host;
} }
function get_port (  ) {
{return $this->port;
} }
function get_path (  ) {
{return $this->path;
} }
function get_query (  ) {
{return $this->query;
} }
function get_fragment (  ) {
{return $this->fragment;
} }
}class SimplePie_Net_IPv6{function removeNetmaskSpec ( $ip ) {
{if ( (strpos($ip[0],'/') !== false))
 {list($addr,$nm) = deAspisList(Aspis_explode(array('/',false),$ip),array());
}else 
{{$addr = $ip;
}}return $addr;
} }
function Uncompress ( $ip ) {
{$uip = SimplePie_Net_IPv6::removeNetmaskSpec($ip);
$c1 = negate(array(1,false));
$c2 = negate(array(1,false));
if ( (strpos($ip[0],'::') !== false))
 {list($ip1,$ip2) = deAspisList(Aspis_explode(array('::',false),$ip),array());
if ( ($ip1[0] === ('')))
 {$c1 = negate(array(1,false));
}else 
{{$pos = array(0,false);
if ( (deAspis(($pos = attAspis(substr_count($ip1[0],(':'))))) > (0)))
 {$c1 = $pos;
}else 
{{$c1 = array(0,false);
}}}}if ( ($ip2[0] === ('')))
 {$c2 = negate(array(1,false));
}else 
{{$pos = array(0,false);
if ( (deAspis(($pos = attAspis(substr_count($ip2[0],(':'))))) > (0)))
 {$c2 = $pos;
}else 
{{$c2 = array(0,false);
}}}}if ( deAspis(Aspis_strstr($ip2,array('.',false))))
 {postincr($c2);
}if ( (($c1[0] === deAspis(negate(array(1,false)))) && ($c2[0] === deAspis(negate(array(1,false))))))
 {$uip = array('0:0:0:0:0:0:0:0',false);
}else 
{if ( ($c1[0] === deAspis(negate(array(1,false)))))
 {$fill = Aspis_str_repeat(array('0:',false),array((7) - $c2[0],false));
$uip = Aspis_str_replace(array('::',false),$fill,$uip);
}else 
{if ( ($c2[0] === deAspis(negate(array(1,false)))))
 {$fill = Aspis_str_repeat(array(':0',false),array((7) - $c1[0],false));
$uip = Aspis_str_replace(array('::',false),$fill,$uip);
}else 
{{$fill = Aspis_str_repeat(array(':0:',false),array(((6) - $c2[0]) - $c1[0],false));
$uip = Aspis_str_replace(array('::',false),$fill,$uip);
$uip = Aspis_str_replace(array('::',false),array(':',false),$uip);
}}}}}return $uip;
} }
function SplitV64 ( $ip ) {
{$ip = SimplePie_Net_IPv6::Uncompress($ip);
if ( deAspis(Aspis_strstr($ip,array('.',false))))
 {$pos = attAspis(strrpos($ip[0],(':')));
arrayAssign($ip[0],deAspis(registerTaint($pos)),addTaint(array('_',false)));
$ipPart = Aspis_explode(array('_',false),$ip);
return $ipPart;
}else 
{{return array(array($ip,array('',false)),false);
}}} }
function checkIPv6 ( $ip ) {
{$ipPart = SimplePie_Net_IPv6::SplitV64($ip);
$count = array(0,false);
if ( (!((empty($ipPart[0][(0)]) || Aspis_empty( $ipPart [0][(0)])))))
 {$ipv6 = Aspis_explode(array(':',false),attachAspis($ipPart,(0)));
for ( $i = array(0,false) ; ($i[0] < count($ipv6[0])) ; postincr($i) )
{$dec = Aspis_hexdec(attachAspis($ipv6,$i[0]));
$hex = Aspis_strtoupper(Aspis_preg_replace(array('/^[0]{1,3}(.*[0-9a-fA-F])$/',false),array('\\1',false),attachAspis($ipv6,$i[0])));
if ( (((deAspis(attachAspis($ipv6,$i[0])) >= (0)) && ($dec[0] <= (65535))) && ($hex[0] === deAspis(Aspis_strtoupper(Aspis_dechex($dec))))))
 {postincr($count);
}}if ( ($count[0] === (8)))
 {return array(true,false);
}elseif ( (($count[0] === (6)) && (!((empty($ipPart[0][(1)]) || Aspis_empty( $ipPart [0][(1)]))))))
 {$ipv4 = Aspis_explode(array('.',false),attachAspis($ipPart,(1)));
$count = array(0,false);
foreach ( $ipv4[0] as $ipv4_part  )
{if ( ((($ipv4_part[0] >= (0)) && ($ipv4_part[0] <= (255))) && deAspis(Aspis_preg_match(array('/^\d{1,3}$/',false),$ipv4_part))))
 {postincr($count);
}}if ( ($count[0] === (4)))
 {return array(true,false);
}}else 
{{return array(false,false);
}}}else 
{{return array(false,false);
}}} }
}class SimplePie_Parse_Date{var $date;
var $day = array(array('mon' => array(1,false),'monday' => array(1,false),'tue' => array(2,false),'tuesday' => array(2,false),'wed' => array(3,false),'wednesday' => array(3,false),'thu' => array(4,false),'thursday' => array(4,false),'fri' => array(5,false),'friday' => array(5,false),'sat' => array(6,false),'saturday' => array(6,false),'sun' => array(7,false),'sunday' => array(7,false),'maandag' => array(1,false),'dinsdag' => array(2,false),'woensdag' => array(3,false),'donderdag' => array(4,false),'vrijdag' => array(5,false),'zaterdag' => array(6,false),'zondag' => array(7,false),'lundi' => array(1,false),'mardi' => array(2,false),'mercredi' => array(3,false),'jeudi' => array(4,false),'vendredi' => array(5,false),'samedi' => array(6,false),'dimanche' => array(7,false),'montag' => array(1,false),'dienstag' => array(2,false),'mittwoch' => array(3,false),'donnerstag' => array(4,false),'freitag' => array(5,false),'samstag' => array(6,false),'sonnabend' => array(6,false),'sonntag' => array(7,false),'lunedì' => array(1,false),'martedì' => array(2,false),'mercoledì' => array(3,false),'giovedì' => array(4,false),'venerdì' => array(5,false),'sabato' => array(6,false),'domenica' => array(7,false),'lunes' => array(1,false),'martes' => array(2,false),'miércoles' => array(3,false),'jueves' => array(4,false),'viernes' => array(5,false),'sábado' => array(6,false),'domingo' => array(7,false),'maanantai' => array(1,false),'tiistai' => array(2,false),'keskiviikko' => array(3,false),'torstai' => array(4,false),'perjantai' => array(5,false),'lauantai' => array(6,false),'sunnuntai' => array(7,false),'hétfő' => array(1,false),'kedd' => array(2,false),'szerda' => array(3,false),'csütörtok' => array(4,false),'péntek' => array(5,false),'szombat' => array(6,false),'vasárnap' => array(7,false),'Δευ' => array(1,false),'Τρι' => array(2,false),'Τετ' => array(3,false),'Πεμ' => array(4,false),'Παρ' => array(5,false),'Σαβ' => array(6,false),'Κυρ' => array(7,false),),false);
var $month = array(array('jan' => array(1,false),'january' => array(1,false),'feb' => array(2,false),'february' => array(2,false),'mar' => array(3,false),'march' => array(3,false),'apr' => array(4,false),'april' => array(4,false),'may' => array(5,false),'jun' => array(6,false),'june' => array(6,false),'jul' => array(7,false),'july' => array(7,false),'aug' => array(8,false),'august' => array(8,false),'sep' => array(9,false),'september' => array(8,false),'oct' => array(10,false),'october' => array(10,false),'nov' => array(11,false),'november' => array(11,false),'dec' => array(12,false),'december' => array(12,false),'januari' => array(1,false),'februari' => array(2,false),'maart' => array(3,false),'april' => array(4,false),'mei' => array(5,false),'juni' => array(6,false),'juli' => array(7,false),'augustus' => array(8,false),'september' => array(9,false),'oktober' => array(10,false),'november' => array(11,false),'december' => array(12,false),'janvier' => array(1,false),'février' => array(2,false),'mars' => array(3,false),'avril' => array(4,false),'mai' => array(5,false),'juin' => array(6,false),'juillet' => array(7,false),'août' => array(8,false),'septembre' => array(9,false),'octobre' => array(10,false),'novembre' => array(11,false),'décembre' => array(12,false),'januar' => array(1,false),'februar' => array(2,false),'märz' => array(3,false),'april' => array(4,false),'mai' => array(5,false),'juni' => array(6,false),'juli' => array(7,false),'august' => array(8,false),'september' => array(9,false),'oktober' => array(10,false),'november' => array(11,false),'dezember' => array(12,false),'gennaio' => array(1,false),'febbraio' => array(2,false),'marzo' => array(3,false),'aprile' => array(4,false),'maggio' => array(5,false),'giugno' => array(6,false),'luglio' => array(7,false),'agosto' => array(8,false),'settembre' => array(9,false),'ottobre' => array(10,false),'novembre' => array(11,false),'dicembre' => array(12,false),'enero' => array(1,false),'febrero' => array(2,false),'marzo' => array(3,false),'abril' => array(4,false),'mayo' => array(5,false),'junio' => array(6,false),'julio' => array(7,false),'agosto' => array(8,false),'septiembre' => array(9,false),'setiembre' => array(9,false),'octubre' => array(10,false),'noviembre' => array(11,false),'diciembre' => array(12,false),'tammikuu' => array(1,false),'helmikuu' => array(2,false),'maaliskuu' => array(3,false),'huhtikuu' => array(4,false),'toukokuu' => array(5,false),'kesäkuu' => array(6,false),'heinäkuu' => array(7,false),'elokuu' => array(8,false),'suuskuu' => array(9,false),'lokakuu' => array(10,false),'marras' => array(11,false),'joulukuu' => array(12,false),'január' => array(1,false),'február' => array(2,false),'március' => array(3,false),'április' => array(4,false),'május' => array(5,false),'június' => array(6,false),'július' => array(7,false),'augusztus' => array(8,false),'szeptember' => array(9,false),'október' => array(10,false),'november' => array(11,false),'december' => array(12,false),'Ιαν' => array(1,false),'Φεβ' => array(2,false),'Μάώ' => array(3,false),'Μαώ' => array(3,false),'Απρ' => array(4,false),'Μάι' => array(5,false),'Μαϊ' => array(5,false),'Μαι' => array(5,false),'Ιούν' => array(6,false),'Ιον' => array(6,false),'Ιούλ' => array(7,false),'Ιολ' => array(7,false),'Αύγ' => array(8,false),'Αυγ' => array(8,false),'Σεπ' => array(9,false),'Οκτ' => array(10,false),'Νοέ' => array(11,false),'Δεκ' => array(12,false),),false);
var $timezone = array(array('ACDT' => array(37800,false),'ACIT' => array(28800,false),'ACST' => array(34200,false),'ACT' => array(-18000,false),'ACWDT' => array(35100,false),'ACWST' => array(31500,false),'AEDT' => array(39600,false),'AEST' => array(36000,false),'AFT' => array(16200,false),'AKDT' => array(-28800,false),'AKST' => array(-32400,false),'AMDT' => array(18000,false),'AMT' => array(-14400,false),'ANAST' => array(46800,false),'ANAT' => array(43200,false),'ART' => array(-10800,false),'AZOST' => array(-3600,false),'AZST' => array(18000,false),'AZT' => array(14400,false),'BIOT' => array(21600,false),'BIT' => array(-43200,false),'BOT' => array(-14400,false),'BRST' => array(-7200,false),'BRT' => array(-10800,false),'BST' => array(3600,false),'BTT' => array(21600,false),'CAST' => array(18000,false),'CAT' => array(7200,false),'CCT' => array(23400,false),'CDT' => array(-18000,false),'CEDT' => array(7200,false),'CET' => array(3600,false),'CGST' => array(-7200,false),'CGT' => array(-10800,false),'CHADT' => array(49500,false),'CHAST' => array(45900,false),'CIST' => array(-28800,false),'CKT' => array(-36000,false),'CLDT' => array(-10800,false),'CLST' => array(-14400,false),'COT' => array(-18000,false),'CST' => array(-21600,false),'CVT' => array(-3600,false),'CXT' => array(25200,false),'DAVT' => array(25200,false),'DTAT' => array(36000,false),'EADT' => array(-18000,false),'EAST' => array(-21600,false),'EAT' => array(10800,false),'ECT' => array(-18000,false),'EDT' => array(-14400,false),'EEST' => array(10800,false),'EET' => array(7200,false),'EGT' => array(-3600,false),'EKST' => array(21600,false),'EST' => array(-18000,false),'FJT' => array(43200,false),'FKDT' => array(-10800,false),'FKST' => array(-14400,false),'FNT' => array(-7200,false),'GALT' => array(-21600,false),'GEDT' => array(14400,false),'GEST' => array(10800,false),'GFT' => array(-10800,false),'GILT' => array(43200,false),'GIT' => array(-32400,false),'GST' => array(14400,false),'GST' => array(-7200,false),'GYT' => array(-14400,false),'HAA' => array(-10800,false),'HAC' => array(-18000,false),'HADT' => array(-32400,false),'HAE' => array(-14400,false),'HAP' => array(-25200,false),'HAR' => array(-21600,false),'HAST' => array(-36000,false),'HAT' => array(-9000,false),'HAY' => array(-28800,false),'HKST' => array(28800,false),'HMT' => array(18000,false),'HNA' => array(-14400,false),'HNC' => array(-21600,false),'HNE' => array(-18000,false),'HNP' => array(-28800,false),'HNR' => array(-25200,false),'HNT' => array(-12600,false),'HNY' => array(-32400,false),'IRDT' => array(16200,false),'IRKST' => array(32400,false),'IRKT' => array(28800,false),'IRST' => array(12600,false),'JFDT' => array(-10800,false),'JFST' => array(-14400,false),'JST' => array(32400,false),'KGST' => array(21600,false),'KGT' => array(18000,false),'KOST' => array(39600,false),'KOVST' => array(28800,false),'KOVT' => array(25200,false),'KRAST' => array(28800,false),'KRAT' => array(25200,false),'KST' => array(32400,false),'LHDT' => array(39600,false),'LHST' => array(37800,false),'LINT' => array(50400,false),'LKT' => array(21600,false),'MAGST' => array(43200,false),'MAGT' => array(39600,false),'MAWT' => array(21600,false),'MDT' => array(-21600,false),'MESZ' => array(7200,false),'MEZ' => array(3600,false),'MHT' => array(43200,false),'MIT' => array(-34200,false),'MNST' => array(32400,false),'MSDT' => array(14400,false),'MSST' => array(10800,false),'MST' => array(-25200,false),'MUT' => array(14400,false),'MVT' => array(18000,false),'MYT' => array(28800,false),'NCT' => array(39600,false),'NDT' => array(-9000,false),'NFT' => array(41400,false),'NMIT' => array(36000,false),'NOVST' => array(25200,false),'NOVT' => array(21600,false),'NPT' => array(20700,false),'NRT' => array(43200,false),'NST' => array(-12600,false),'NUT' => array(-39600,false),'NZDT' => array(46800,false),'NZST' => array(43200,false),'OMSST' => array(25200,false),'OMST' => array(21600,false),'PDT' => array(-25200,false),'PET' => array(-18000,false),'PETST' => array(46800,false),'PETT' => array(43200,false),'PGT' => array(36000,false),'PHOT' => array(46800,false),'PHT' => array(28800,false),'PKT' => array(18000,false),'PMDT' => array(-7200,false),'PMST' => array(-10800,false),'PONT' => array(39600,false),'PST' => array(-28800,false),'PWT' => array(32400,false),'PYST' => array(-10800,false),'PYT' => array(-14400,false),'RET' => array(14400,false),'ROTT' => array(-10800,false),'SAMST' => array(18000,false),'SAMT' => array(14400,false),'SAST' => array(7200,false),'SBT' => array(39600,false),'SCDT' => array(46800,false),'SCST' => array(43200,false),'SCT' => array(14400,false),'SEST' => array(3600,false),'SGT' => array(28800,false),'SIT' => array(28800,false),'SRT' => array(-10800,false),'SST' => array(-39600,false),'SYST' => array(10800,false),'SYT' => array(7200,false),'TFT' => array(18000,false),'THAT' => array(-36000,false),'TJT' => array(18000,false),'TKT' => array(-36000,false),'TMT' => array(18000,false),'TOT' => array(46800,false),'TPT' => array(32400,false),'TRUT' => array(36000,false),'TVT' => array(43200,false),'TWT' => array(28800,false),'UYST' => array(-7200,false),'UYT' => array(-10800,false),'UZT' => array(18000,false),'VET' => array(-14400,false),'VLAST' => array(39600,false),'VLAT' => array(36000,false),'VOST' => array(21600,false),'VUT' => array(39600,false),'WAST' => array(7200,false),'WAT' => array(3600,false),'WDT' => array(32400,false),'WEST' => array(3600,false),'WFT' => array(43200,false),'WIB' => array(25200,false),'WIT' => array(32400,false),'WITA' => array(28800,false),'WKST' => array(18000,false),'WST' => array(28800,false),'YAKST' => array(36000,false),'YAKT' => array(32400,false),'YAPT' => array(36000,false),'YEKST' => array(21600,false),'YEKT' => array(18000,false),),false);
var $day_pcre;
var $month_pcre;
var $built_in = array(array(),false);
var $user = array(array(),false);
function SimplePie_Parse_Date (  ) {
{$this->day_pcre = concat2(concat1('(',Aspis_implode(attAspisRC(array_keys(deAspisRC($this->day))),array('|',false))),')');
$this->month_pcre = concat2(concat1('(',Aspis_implode(attAspisRC(array_keys(deAspisRC($this->month))),array('|',false))),')');
static $cache;
if ( (!((isset($cache[0][get_class(deAspisRC(array($this,false)))]) && Aspis_isset( $cache [0][get_class( deAspisRC(array($this,false)))])))))
 {$all_methods = attAspisRC(get_class_methods(deAspisRC(array($this,false))));
foreach ( $all_methods[0] as $method  )
{if ( (deAspis(Aspis_strtolower(Aspis_substr($method,array(0,false),array(5,false)))) === ('date_')))
 {arrayAssignAdd($cache[0][get_class(deAspisRC(array($this,false)))][0][],addTaint($method));
}}}foreach ( deAspis(attachAspis($cache,get_class(deAspisRC(array($this,false))))) as $method  )
{arrayAssignAdd($this->built_in[0][],addTaint($method));
}} }
function get (  ) {
{static $object;
if ( (denot_boolean($object)))
 {$object = array(new SimplePie_Parse_Date,false);
}return $object;
} }
function parse ( $date ) {
{foreach ( $this->user[0] as $method  )
{if ( (deAspis(($returned = Aspis_call_user_func($method,$date))) !== false))
 {return $returned;
}}foreach ( $this->built_in[0] as $method  )
{if ( (deAspis(($returned = Aspis_call_user_func(array(array(array($this,false),$method),false),$date))) !== false))
 {return $returned;
}}return array(false,false);
} }
function add_callback ( $callback ) {
{if ( is_callable(deAspisRC($callback)))
 {arrayAssignAdd($this->user[0][],addTaint($callback));
}else 
{{trigger_error('User-supplied function must be a valid callback',E_USER_WARNING);
}}} }
function date_w3cdtf ( $date ) {
{static $pcre;
if ( (denot_boolean($pcre)))
 {$year = array('([0-9]{4})',false);
$month = $day = $hour = $minute = $second = array('([0-9]{2})',false);
$decimal = array('([0-9]*)',false);
$zone = array('(?:(Z)|([+\-])([0-9]{1,2}):?([0-9]{1,2}))',false);
$pcre = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('/^',$year),'(?:-?'),$month),'(?:-?'),$day),'(?:[Tt\x09\x20]+'),$hour),'(?::?'),$minute),'(?::?'),$second),'(?:.'),$decimal),')?)?)?'),$zone),')?)?)?$/');
}if ( deAspis(Aspis_preg_match($pcre,$date,$match)))
 {for ( $i = attAspis(count($match[0])) ; ($i[0] <= (3)) ; postincr($i) )
{arrayAssign($match[0],deAspis(registerTaint($i)),addTaint(array('1',false)));
}for ( $i = attAspis(count($match[0])) ; ($i[0] <= (7)) ; postincr($i) )
{arrayAssign($match[0],deAspis(registerTaint($i)),addTaint(array('0',false)));
}if ( (((isset($match[0][(9)]) && Aspis_isset( $match [0][(9)]))) && (deAspis(attachAspis($match,(9))) !== (''))))
 {$timezone = array(deAspis(attachAspis($match,(10))) * (3600),false);
$timezone = array((deAspis(attachAspis($match,(11))) * (60)) + $timezone[0],false);
if ( (deAspis(attachAspis($match,(9))) === ('-')))
 {$timezone = array((0) - $timezone[0],false);
}}else 
{{$timezone = array(0,false);
}}$second = attAspis(round((deAspis(attachAspis($match,(6))) + (deAspis(attachAspis($match,(7))) / deAspis(Aspis_pow(array(10,false),attAspis(strlen(deAspis(attachAspis($match,(7)))))))))));
return array(gmmktime(deAspis(attachAspis($match,(4))),deAspis(attachAspis($match,(5))),$second[0],deAspis(attachAspis($match,(2))),deAspis(attachAspis($match,(3))),deAspis(attachAspis($match,(1)))) - $timezone[0],false);
}else 
{{return array(false,false);
}}} }
function remove_rfc2822_comments ( $string ) {
{$string = string_cast($string);
$position = array(0,false);
$length = attAspis(strlen($string[0]));
$depth = array(0,false);
$output = array('',false);
while ( (($position[0] < $length[0]) && (deAspis(($pos = attAspis(strpos($string[0],'(',$position[0])))) !== false)) )
{$output = concat($output,Aspis_substr($string,$position,array($pos[0] - $position[0],false)));
$position = array($pos[0] + (1),false);
if ( (deAspis(attachAspis($string,($pos[0] - (1)))) !== ('\\')))
 {postincr($depth);
while ( ($depth[0] && ($position[0] < $length[0])) )
{$position = array(strcspn($string[0],('()'),$position[0]) + $position[0],false);
if ( (deAspis(attachAspis($string,($position[0] - (1)))) === ('\\')))
 {postincr($position);
continue ;
}elseif ( ((isset($string[0][$position[0]]) && Aspis_isset( $string [0][$position[0]]))))
 {switch ( deAspis(attachAspis($string,$position[0])) ) {
case ('('):postincr($depth);
break ;
case (')'):postdecr($depth);
break ;
 }
postincr($position);
}else 
{{break ;
}}}}else 
{{$output = concat2($output,'(');
}}}$output = concat($output,Aspis_substr($string,$position));
return $output;
} }
function date_rfc2822 ( $date ) {
{static $pcre;
if ( (denot_boolean($pcre)))
 {$wsp = array('[\x09\x20]',false);
$fws = concat2(concat(concat2(concat(concat2(concat1('(?:',$wsp),'+|'),$wsp),'*(?:\x0D\x0A'),$wsp),'+)+)');
$optional_fws = concat2($fws,'?');
$day_name = $this->day_pcre;
$month = $this->month_pcre;
$day = array('([0-9]{1,2})',false);
$hour = $minute = $second = array('([0-9]{2})',false);
$year = array('([0-9]{2,4})',false);
$num_zone = array('([+\-])([0-9]{2})([0-9]{2})',false);
$character_zone = array('([A-Z]{1,5})',false);
$zone = concat2(concat(concat2(concat1('(?:',$num_zone),'|'),$character_zone),')');
$pcre = concat2(concat(concat(concat2(concat(concat(concat2(concat(concat2(concat(concat(concat2(concat(concat(concat(concat(concat(concat(concat(concat(concat(concat2(concat(concat(concat1('/(?:',$optional_fws),$day_name),$optional_fws),',)?'),$optional_fws),$day),$fws),$month),$fws),$year),$fws),$hour),$optional_fws),':'),$optional_fws),$minute),'(?:'),$optional_fws),':'),$optional_fws),$second),')?'),$fws),$zone),'/i');
}if ( deAspis(Aspis_preg_match($pcre,$this->remove_rfc2822_comments($date),$match)))
 {$month = $this->month[0][deAspis(Aspis_strtolower(attachAspis($match,(3))))];
if ( (deAspis(attachAspis($match,(8))) !== ('')))
 {$timezone = array(deAspis(attachAspis($match,(9))) * (3600),false);
$timezone = array((deAspis(attachAspis($match,(10))) * (60)) + $timezone[0],false);
if ( (deAspis(attachAspis($match,(8))) === ('-')))
 {$timezone = array((0) - $timezone[0],false);
}}elseif ( ((isset($this->timezone[0][deAspis(Aspis_strtoupper(attachAspis($match,(11))))]) && Aspis_isset( $this ->timezone [0][deAspis(Aspis_strtoupper( attachAspis( $match ,(11))))] ))))
 {$timezone = $this->timezone[0][deAspis(Aspis_strtoupper(attachAspis($match,(11))))];
}else 
{{$timezone = array(0,false);
}}if ( (deAspis(attachAspis($match,(4))) < (50)))
 {arrayAssign($match[0],deAspis(registerTaint(array(4,false))),addTaint(array((2000) + deAspis(attachAspis($match,(4))),false)));
}elseif ( (deAspis(attachAspis($match,(4))) < (1000)))
 {arrayAssign($match[0],deAspis(registerTaint(array(4,false))),addTaint(array((1900) + deAspis(attachAspis($match,(4))),false)));
}if ( (deAspis(attachAspis($match,(7))) !== ('')))
 {$second = attachAspis($match,(7));
}else 
{{$second = array(0,false);
}}return array(gmmktime(deAspis(attachAspis($match,(5))),deAspis(attachAspis($match,(6))),$second[0],$month[0],deAspis(attachAspis($match,(2))),deAspis(attachAspis($match,(4)))) - $timezone[0],false);
}else 
{{return array(false,false);
}}} }
function date_rfc850 ( $date ) {
{static $pcre;
if ( (denot_boolean($pcre)))
 {$space = array('[\x09\x20]+',false);
$day_name = $this->day_pcre;
$month = $this->month_pcre;
$day = array('([0-9]{1,2})',false);
$year = $hour = $minute = $second = array('([0-9]{2})',false);
$zone = array('([A-Z]{1,5})',false);
$pcre = concat2(concat(concat(concat(concat2(concat(concat2(concat(concat(concat(concat2(concat(concat2(concat(concat(concat2(concat1('/^',$day_name),','),$space),$day),'-'),$month),'-'),$year),$space),$hour),':'),$minute),':'),$second),$space),$zone),'$/i');
}if ( deAspis(Aspis_preg_match($pcre,$date,$match)))
 {$month = $this->month[0][deAspis(Aspis_strtolower(attachAspis($match,(3))))];
if ( ((isset($this->timezone[0][deAspis(Aspis_strtoupper(attachAspis($match,(8))))]) && Aspis_isset( $this ->timezone [0][deAspis(Aspis_strtoupper( attachAspis( $match ,(8))))] ))))
 {$timezone = $this->timezone[0][deAspis(Aspis_strtoupper(attachAspis($match,(8))))];
}else 
{{$timezone = array(0,false);
}}if ( (deAspis(attachAspis($match,(4))) < (50)))
 {arrayAssign($match[0],deAspis(registerTaint(array(4,false))),addTaint(array((2000) + deAspis(attachAspis($match,(4))),false)));
}else 
{{arrayAssign($match[0],deAspis(registerTaint(array(4,false))),addTaint(array((1900) + deAspis(attachAspis($match,(4))),false)));
}}return array(gmmktime(deAspis(attachAspis($match,(5))),deAspis(attachAspis($match,(6))),deAspis(attachAspis($match,(7))),$month[0],deAspis(attachAspis($match,(2))),deAspis(attachAspis($match,(4)))) - $timezone[0],false);
}else 
{{return array(false,false);
}}} }
function date_asctime ( $date ) {
{static $pcre;
if ( (denot_boolean($pcre)))
 {$space = array('[\x09\x20]+',false);
$wday_name = $this->day_pcre;
$mon_name = $this->month_pcre;
$day = array('([0-9]{1,2})',false);
$hour = $sec = $min = array('([0-9]{2})',false);
$year = array('([0-9]{4})',false);
$terminator = array('\x0A?\x00?',false);
$pcre = concat2(concat(concat(concat(concat(concat2(concat(concat2(concat(concat(concat(concat(concat(concat(concat1('/^',$wday_name),$space),$mon_name),$space),$day),$space),$hour),':'),$min),':'),$sec),$space),$year),$terminator),'$/i');
}if ( deAspis(Aspis_preg_match($pcre,$date,$match)))
 {$month = $this->month[0][deAspis(Aspis_strtolower(attachAspis($match,(2))))];
return attAspis(gmmktime(deAspis(attachAspis($match,(4))),deAspis(attachAspis($match,(5))),deAspis(attachAspis($match,(6))),$month[0],deAspis(attachAspis($match,(3))),deAspis(attachAspis($match,(7)))));
}else 
{{return array(false,false);
}}} }
function date_strtotime ( $date ) {
{$strtotime = attAspis(strtotime($date[0]));
if ( (($strtotime[0] === deAspis(negate(array(1,false)))) || ($strtotime[0] === false)))
 {return array(false,false);
}else 
{{return $strtotime;
}}} }
}class SimplePie_Content_Type_Sniffer{var $file;
function SimplePie_Content_Type_Sniffer ( $file ) {
{$this->file = $file;
} }
function get_type (  ) {
{if ( ((isset($this->file[0]->headers[0][('content-type')]) && Aspis_isset( $this ->file[0] ->headers [0][('content-type')] ))))
 {if ( ((!((isset($this->file[0]->headers[0][('content-encoding')]) && Aspis_isset( $this ->file[0] ->headers [0][('content-encoding')] )))) && ((($this->file[0]->headers[0][('content-type')][0] === ('text/plain')) || ($this->file[0]->headers[0][('content-type')][0] === ('text/plain; charset=ISO-8859-1'))) || ($this->file[0]->headers[0][('content-type')][0] === ('text/plain; charset=iso-8859-1')))))
 {return $this->text_or_binary();
}if ( (deAspis(($pos = attAspis(strpos($this->file[0]->headers[0][('content-type')][0],';')))) !== false))
 {$official = Aspis_substr($this->file[0]->headers[0][('content-type')],array(0,false),$pos);
}else 
{{$official = $this->file[0]->headers[0][('content-type')];
}}$official = Aspis_strtolower($official);
if ( (($official[0] === ('unknown/unknown')) || ($official[0] === ('application/unknown'))))
 {return $this->unknown();
}elseif ( (((deAspis(Aspis_substr($official,negate(array(4,false)))) === ('+xml')) || ($official[0] === ('text/xml'))) || ($official[0] === ('application/xml'))))
 {return $official;
}elseif ( (deAspis(Aspis_substr($official,array(0,false),array(6,false))) === ('image/')))
 {if ( deAspis($return = $this->image()))
 {return $return;
}else 
{{return $official;
}}}elseif ( ($official[0] === ('text/html')))
 {return $this->feed_or_html();
}else 
{{return $official;
}}}else 
{{return $this->unknown();
}}} }
function text_or_binary (  ) {
{if ( ((((deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(2,false))) === ("\xFE\xFF")) || (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(2,false))) === ("\xFF\xFE"))) || (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(4,false))) === ("\x00\x00\xFE\xFF"))) || (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(3,false))) === ("\xEF\xBB\xBF"))))
 {return array('text/plain',false);
}elseif ( deAspis(Aspis_preg_match(array('/[\x00-\x08\x0E-\x1A\x1C-\x1F]/',false),$this->file[0]->body)))
 {return array('application/octect-stream',false);
}else 
{{return array('text/plain',false);
}}} }
function unknown (  ) {
{$ws = attAspis(strspn($this->file[0]->body[0],("\x09\x0A\x0B\x0C\x0D\x20")));
if ( (((deAspis(Aspis_strtolower(Aspis_substr($this->file[0]->body,$ws,array(14,false)))) === ('<!doctype html')) || (deAspis(Aspis_strtolower(Aspis_substr($this->file[0]->body,$ws,array(5,false)))) === ('<html'))) || (deAspis(Aspis_strtolower(Aspis_substr($this->file[0]->body,$ws,array(7,false)))) === ('<script'))))
 {return array('text/html',false);
}elseif ( (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(5,false))) === ('%PDF-')))
 {return array('application/pdf',false);
}elseif ( (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(11,false))) === ('%!PS-Adobe-')))
 {return array('application/postscript',false);
}elseif ( ((deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(6,false))) === ('GIF87a')) || (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(6,false))) === ('GIF89a'))))
 {return array('image/gif',false);
}elseif ( (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(8,false))) === ("\x89\x50\x4E\x47\x0D\x0A\x1A\x0A")))
 {return array('image/png',false);
}elseif ( (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(3,false))) === ("\xFF\xD8\xFF")))
 {return array('image/jpeg',false);
}elseif ( (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(2,false))) === ("\x42\x4D")))
 {return array('image/bmp',false);
}else 
{{return $this->text_or_binary();
}}} }
function image (  ) {
{if ( ((deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(6,false))) === ('GIF87a')) || (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(6,false))) === ('GIF89a'))))
 {return array('image/gif',false);
}elseif ( (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(8,false))) === ("\x89\x50\x4E\x47\x0D\x0A\x1A\x0A")))
 {return array('image/png',false);
}elseif ( (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(3,false))) === ("\xFF\xD8\xFF")))
 {return array('image/jpeg',false);
}elseif ( (deAspis(Aspis_substr($this->file[0]->body,array(0,false),array(2,false))) === ("\x42\x4D")))
 {return array('image/bmp',false);
}else 
{{return array(false,false);
}}} }
function feed_or_html (  ) {
{$len = attAspis(strlen($this->file[0]->body[0]));
$pos = attAspis(strspn($this->file[0]->body[0],("\x09\x0A\x0D\x20")));
while ( ($pos[0] < $len[0]) )
{switch ( $this->file[0]->body[0][$pos[0]][0] ) {
case ("\x09"):case ("\x0A"):case ("\x0D"):case ("\x20"):$pos = array(strspn($this->file[0]->body[0],("\x09\x0A\x0D\x20"),$pos[0]) + $pos[0],false);
continue (2);
case ('<'):postincr($pos);
break ;
default :return array('text/html',false);
 }
if ( (deAspis(Aspis_substr($this->file[0]->body,$pos,array(3,false))) === ('!--')))
 {$pos = array((3) + $pos[0],false);
if ( (($pos[0] < $len[0]) && (deAspis(($pos = attAspis(strpos($this->file[0]->body[0],'-->',$pos[0])))) !== false)))
 {$pos = array((3) + $pos[0],false);
}else 
{{return array('text/html',false);
}}}elseif ( (deAspis(Aspis_substr($this->file[0]->body,$pos,array(1,false))) === ('!')))
 {if ( (($pos[0] < $len[0]) && (deAspis(($pos = attAspis(strpos($this->file[0]->body[0],'>',$pos[0])))) !== false)))
 {postincr($pos);
}else 
{{return array('text/html',false);
}}}elseif ( (deAspis(Aspis_substr($this->file[0]->body,$pos,array(1,false))) === ('?')))
 {if ( (($pos[0] < $len[0]) && (deAspis(($pos = attAspis(strpos($this->file[0]->body[0],'?>',$pos[0])))) !== false)))
 {$pos = array((2) + $pos[0],false);
}else 
{{return array('text/html',false);
}}}elseif ( ((deAspis(Aspis_substr($this->file[0]->body,$pos,array(3,false))) === ('rss')) || (deAspis(Aspis_substr($this->file[0]->body,$pos,array(7,false))) === ('rdf:RDF'))))
 {return array('application/rss+xml',false);
}elseif ( (deAspis(Aspis_substr($this->file[0]->body,$pos,array(4,false))) === ('feed')))
 {return array('application/atom+xml',false);
}else 
{{return array('text/html',false);
}}}return array('text/html',false);
} }
}class SimplePie_XML_Declaration_Parser{var $version = array('1.0',false);
var $encoding = array('UTF-8',false);
var $standalone = array(false,false);
var $state = array('before_version_name',false);
var $data = array('',false);
var $data_length = array(0,false);
var $position = array(0,false);
function SimplePie_XML_Declaration_Parser ( $data ) {
{$this->data = $data;
$this->data_length = attAspis(strlen($this->data[0]));
} }
function parse (  ) {
{while ( (($this->state[0] && ($this->state[0] !== ('emit'))) && deAspis($this->has_data())) )
{$state = $this->state;
AspisDynamicCall(array(array($this,$state),false));
}$this->data = array('',false);
if ( ($this->state[0] === ('emit')))
 {return array(true,false);
}else 
{{$this->version = array('',false);
$this->encoding = array('',false);
$this->standalone = array('',false);
return array(false,false);
}}} }
function has_data (  ) {
{return bool_cast((array($this->position[0] < $this->data_length[0],false)));
} }
function skip_whitespace (  ) {
{$whitespace = attAspis(strspn($this->data[0],("\x09\x0A\x0D\x20"),$this->position[0]));
$this->position = array($whitespace[0] + $this->position [0],false);
return $whitespace;
} }
function get_value (  ) {
{$quote = Aspis_substr($this->data,$this->position,array(1,false));
if ( (($quote[0] === ('"')) || ($quote[0] === ("'"))))
 {postincr($this->position);
$len = attAspis(strcspn($this->data[0],$quote[0],$this->position[0]));
if ( deAspis($this->has_data()))
 {$value = Aspis_substr($this->data,$this->position,$len);
$this->position = array(($len[0] + (1)) + $this->position [0],false);
return $value;
}}return array(false,false);
} }
function before_version_name (  ) {
{if ( deAspis($this->skip_whitespace()))
 {$this->state = array('version_name',false);
}else 
{{$this->state = array(false,false);
}}} }
function version_name (  ) {
{if ( (deAspis(Aspis_substr($this->data,$this->position,array(7,false))) === ('version')))
 {$this->position = array((7) + $this->position [0],false);
$this->skip_whitespace();
$this->state = array('version_equals',false);
}else 
{{$this->state = array(false,false);
}}} }
function version_equals (  ) {
{if ( (deAspis(Aspis_substr($this->data,$this->position,array(1,false))) === ('=')))
 {postincr($this->position);
$this->skip_whitespace();
$this->state = array('version_value',false);
}else 
{{$this->state = array(false,false);
}}} }
function version_value (  ) {
{if ( deAspis($this->version = $this->get_value()))
 {$this->skip_whitespace();
if ( deAspis($this->has_data()))
 {$this->state = array('encoding_name',false);
}else 
{{$this->state = array('emit',false);
}}}else 
{{$this->state = array('standalone_name',false);
}}} }
function encoding_name (  ) {
{if ( (deAspis(Aspis_substr($this->data,$this->position,array(8,false))) === ('encoding')))
 {$this->position = array((8) + $this->position [0],false);
$this->skip_whitespace();
$this->state = array('encoding_equals',false);
}else 
{{$this->state = array(false,false);
}}} }
function encoding_equals (  ) {
{if ( (deAspis(Aspis_substr($this->data,$this->position,array(1,false))) === ('=')))
 {postincr($this->position);
$this->skip_whitespace();
$this->state = array('encoding_value',false);
}else 
{{$this->state = array(false,false);
}}} }
function encoding_value (  ) {
{if ( deAspis($this->encoding = $this->get_value()))
 {$this->skip_whitespace();
if ( deAspis($this->has_data()))
 {$this->state = array('standalone_name',false);
}else 
{{$this->state = array('emit',false);
}}}else 
{{$this->state = array(false,false);
}}} }
function standalone_name (  ) {
{if ( (deAspis(Aspis_substr($this->data,$this->position,array(10,false))) === ('standalone')))
 {$this->position = array((10) + $this->position [0],false);
$this->skip_whitespace();
$this->state = array('standalone_equals',false);
}else 
{{$this->state = array(false,false);
}}} }
function standalone_equals (  ) {
{if ( (deAspis(Aspis_substr($this->data,$this->position,array(1,false))) === ('=')))
 {postincr($this->position);
$this->skip_whitespace();
$this->state = array('standalone_value',false);
}else 
{{$this->state = array(false,false);
}}} }
function standalone_value (  ) {
{if ( deAspis($standalone = $this->get_value()))
 {switch ( $standalone[0] ) {
case ('yes'):$this->standalone = array(true,false);
break ;
case ('no'):$this->standalone = array(false,false);
break ;
default :$this->state = array(false,false);
return ;
 }
$this->skip_whitespace();
if ( deAspis($this->has_data()))
 {$this->state = array(false,false);
}else 
{{$this->state = array('emit',false);
}}}else 
{{$this->state = array(false,false);
}}} }
}class SimplePie_Locator{var $useragent;
var $timeout;
var $file;
var $local = array(array(),false);
var $elsewhere = array(array(),false);
var $file_class = array('SimplePie_File',false);
var $cached_entities = array(array(),false);
var $http_base;
var $base;
var $base_location = array(0,false);
var $checked_feeds = array(0,false);
var $max_checked_feeds = array(10,false);
var $content_type_sniffer_class = array('SimplePie_Content_Type_Sniffer',false);
function SimplePie_Locator ( &$file,$timeout = array(10,false),$useragent = array(null,false),$file_class = array('SimplePie_File',false),$max_checked_feeds = array(10,false),$content_type_sniffer_class = array('SimplePie_Content_Type_Sniffer',false) ) {
{$this->file = &$file;
$this->file_class = $file_class;
$this->useragent = $useragent;
$this->timeout = $timeout;
$this->max_checked_feeds = $max_checked_feeds;
$this->content_type_sniffer_class = $content_type_sniffer_class;
} }
function find ( $type = array(SIMPLEPIE_LOCATOR_ALL,false),&$working ) {
{if ( deAspis($this->is_feed($this->file)))
 {return $this->file;
}if ( ($this->file[0]->method[0] & SIMPLEPIE_FILE_SOURCE_REMOTE))
 {$sniffer = array(new $this->content_type_sniffer_class[0]($this->file),false);
if ( (deAspis($sniffer[0]->get_type()) !== ('text/html')))
 {return array(null,false);
}}if ( ($type[0] & deAspis(not_bitwise(array(SIMPLEPIE_LOCATOR_NONE,false)))))
 {$this->get_base();
}if ( (($type[0] & SIMPLEPIE_LOCATOR_AUTODISCOVERY) && deAspis($working = $this->autodiscovery())))
 {return attachAspis($working,(0));
}if ( (($type[0] & (((SIMPLEPIE_LOCATOR_LOCAL_EXTENSION | SIMPLEPIE_LOCATOR_LOCAL_BODY) | SIMPLEPIE_LOCATOR_REMOTE_EXTENSION) | SIMPLEPIE_LOCATOR_REMOTE_BODY)) && deAspis($this->get_links())))
 {if ( (($type[0] & SIMPLEPIE_LOCATOR_LOCAL_EXTENSION) && deAspis($working = $this->extension($this->local))))
 {return $working;
}if ( (($type[0] & SIMPLEPIE_LOCATOR_LOCAL_BODY) && deAspis($working = $this->body($this->local))))
 {return $working;
}if ( (($type[0] & SIMPLEPIE_LOCATOR_REMOTE_EXTENSION) && deAspis($working = $this->extension($this->elsewhere))))
 {return $working;
}if ( (($type[0] & SIMPLEPIE_LOCATOR_REMOTE_BODY) && deAspis($working = $this->body($this->elsewhere))))
 {return $working;
}}return array(null,false);
} }
function is_feed ( &$file ) {
{if ( ($file[0]->method[0] & SIMPLEPIE_FILE_SOURCE_REMOTE))
 {$sniffer = array(new $this->content_type_sniffer_class[0]($file),false);
$sniffed = $sniffer[0]->get_type();
if ( deAspis(Aspis_in_array($sniffed,array(array(array('application/rss+xml',false),array('application/rdf+xml',false),array('text/rdf',false),array('application/atom+xml',false),array('text/xml',false),array('application/xml',false)),false))))
 {return array(true,false);
}else 
{{return array(false,false);
}}}elseif ( ($file[0]->method[0] & SIMPLEPIE_FILE_SOURCE_LOCAL))
 {return array(true,false);
}else 
{{return array(false,false);
}}} }
function get_base (  ) {
{$this->http_base = $this->file[0]->url;
$this->base = $this->http_base;
$elements = SimplePie_Misc::get_element(array('base',false),$this->file[0]->body);
foreach ( $elements[0] as $element  )
{if ( (deAspis($element[0][('attribs')][0][('href')][0]['data']) !== ('')))
 {$this->base = SimplePie_Misc::absolutize_url(Aspis_trim($element[0][('attribs')][0][('href')][0]['data']),$this->http_base);
$this->base_location = $element[0]['offset'];
break ;
}}} }
function autodiscovery (  ) {
{$links = Aspis_array_merge(SimplePie_Misc::get_element(array('link',false),$this->file[0]->body),SimplePie_Misc::get_element(array('a',false),$this->file[0]->body),SimplePie_Misc::get_element(array('area',false),$this->file[0]->body));
$done = array(array(),false);
$feeds = array(array(),false);
foreach ( $links[0] as $link  )
{if ( ($this->checked_feeds[0] === $this->max_checked_feeds[0]))
 {break ;
}if ( (((isset($link[0][('attribs')][0][('href')][0][('data')]) && Aspis_isset( $link [0][('attribs')] [0][('href')] [0][('data')]))) && ((isset($link[0][('attribs')][0][('rel')][0][('data')]) && Aspis_isset( $link [0][('attribs')] [0][('rel')] [0][('data')])))))
 {$rel = attAspisRC(array_unique(deAspisRC(SimplePie_Misc::space_seperated_tokens(Aspis_strtolower($link[0][('attribs')][0][('rel')][0]['data'])))));
if ( ($this->base_location[0] < deAspis($link[0]['offset'])))
 {$href = SimplePie_Misc::absolutize_url(Aspis_trim($link[0][('attribs')][0][('href')][0]['data']),$this->base);
}else 
{{$href = SimplePie_Misc::absolutize_url(Aspis_trim($link[0][('attribs')][0][('href')][0]['data']),$this->http_base);
}}if ( (((denot_boolean(Aspis_in_array($href,$done))) && deAspis(Aspis_in_array(array('feed',false),$rel))) || (((deAspis(Aspis_in_array(array('alternate',false),$rel)) && (!((empty($link[0][('attribs')][0][('type')][0][('data')]) || Aspis_empty( $link [0][('attribs')] [0][('type')] [0][('data')]))))) && deAspis(Aspis_in_array(Aspis_strtolower(SimplePie_Misc::parse_mime($link[0][('attribs')][0][('type')][0]['data'])),array(array(array('application/rss+xml',false),array('application/atom+xml',false)),false)))) && (!((isset($feeds[0][$href[0]]) && Aspis_isset( $feeds [0][$href[0]])))))))
 {postincr($this->checked_feeds);
$feed = array(new $this->file_class[0]($href,$this->timeout,array(5,false),array(null,false),$this->useragent),false);
if ( (($feed[0]->success[0] && (($feed[0]->method[0] & (SIMPLEPIE_FILE_SOURCE_REMOTE === (0))) || (($feed[0]->status_code[0] === (200)) || (($feed[0]->status_code[0] > (206)) && ($feed[0]->status_code[0] < (300)))))) && deAspis($this->is_feed($feed))))
 {arrayAssign($feeds[0],deAspis(registerTaint($href)),addTaint($feed));
}}arrayAssignAdd($done[0][],addTaint($href));
}}if ( (!((empty($feeds) || Aspis_empty( $feeds)))))
 {return Aspis_array_values($feeds);
}else 
{{return array(null,false);
}}} }
function get_links (  ) {
{$links = SimplePie_Misc::get_element(array('a',false),$this->file[0]->body);
foreach ( $links[0] as $link  )
{if ( ((isset($link[0][('attribs')][0][('href')][0][('data')]) && Aspis_isset( $link [0][('attribs')] [0][('href')] [0][('data')]))))
 {$href = Aspis_trim($link[0][('attribs')][0][('href')][0]['data']);
$parsed = SimplePie_Misc::parse_url($href);
if ( ((deAspis($parsed[0]['scheme']) === ('')) || deAspis(Aspis_preg_match(array('/^(http(s)|feed)?$/i',false),$parsed[0]['scheme']))))
 {if ( ($this->base_location[0] < deAspis($link[0]['offset'])))
 {$href = SimplePie_Misc::absolutize_url(Aspis_trim($link[0][('attribs')][0][('href')][0]['data']),$this->base);
}else 
{{$href = SimplePie_Misc::absolutize_url(Aspis_trim($link[0][('attribs')][0][('href')][0]['data']),$this->http_base);
}}$current = SimplePie_Misc::parse_url($this->file[0]->url);
if ( ((deAspis($parsed[0]['authority']) === ('')) || (deAspis($parsed[0]['authority']) === deAspis($current[0]['authority']))))
 {arrayAssignAdd($this->local[0][],addTaint($href));
}else 
{{arrayAssignAdd($this->elsewhere[0][],addTaint($href));
}}}}}$this->local = attAspisRC(array_unique(deAspisRC($this->local)));
$this->elsewhere = attAspisRC(array_unique(deAspisRC($this->elsewhere)));
if ( ((!((empty($this->local) || Aspis_empty( $this ->local )))) || (!((empty($this->elsewhere) || Aspis_empty( $this ->elsewhere ))))))
 {return array(true,false);
}return array(null,false);
} }
function extension ( &$array ) {
{foreach ( $array[0] as $key =>$value )
{restoreTaint($key,$value);
{if ( ($this->checked_feeds[0] === $this->max_checked_feeds[0]))
 {break ;
}if ( deAspis(Aspis_in_array(Aspis_strtolower(attAspis(strrchr($value[0],('.')))),array(array(array('.rss',false),array('.rdf',false),array('.atom',false),array('.xml',false)),false))))
 {postincr($this->checked_feeds);
$feed = array(new $this->file_class[0]($value,$this->timeout,array(5,false),array(null,false),$this->useragent),false);
if ( (($feed[0]->success[0] && (($feed[0]->method[0] & (SIMPLEPIE_FILE_SOURCE_REMOTE === (0))) || (($feed[0]->status_code[0] === (200)) || (($feed[0]->status_code[0] > (206)) && ($feed[0]->status_code[0] < (300)))))) && deAspis($this->is_feed($feed))))
 {return $feed;
}else 
{{unset($array[0][$key[0]]);
}}}}}return array(null,false);
} }
function body ( &$array ) {
{foreach ( $array[0] as $key =>$value )
{restoreTaint($key,$value);
{if ( ($this->checked_feeds[0] === $this->max_checked_feeds[0]))
 {break ;
}if ( deAspis(Aspis_preg_match(array('/(rss|rdf|atom|xml)/i',false),$value)))
 {postincr($this->checked_feeds);
$feed = array(new $this->file_class[0]($value,$this->timeout,array(5,false),array(null,false),$this->useragent),false);
if ( (($feed[0]->success[0] && (($feed[0]->method[0] & (SIMPLEPIE_FILE_SOURCE_REMOTE === (0))) || (($feed[0]->status_code[0] === (200)) || (($feed[0]->status_code[0] > (206)) && ($feed[0]->status_code[0] < (300)))))) && deAspis($this->is_feed($feed))))
 {return $feed;
}else 
{{unset($array[0][$key[0]]);
}}}}}return array(null,false);
} }
}class SimplePie_Parser{var $error_code;
var $error_string;
var $current_line;
var $current_column;
var $current_byte;
var $separator = array(' ',false);
var $namespace = array(array(array('',false)),false);
var $element = array(array(array('',false)),false);
var $xml_base = array(array(array('',false)),false);
var $xml_base_explicit = array(array(array(false,false)),false);
var $xml_lang = array(array(array('',false)),false);
var $data = array(array(),false);
var $datas = array(array(array(array(),false)),false);
var $current_xhtml_construct = array(-1,false);
var $encoding;
function parse ( &$data,$encoding ) {
{if ( (deAspis(Aspis_strtoupper($encoding)) === ('US-ASCII')))
 {$this->encoding = array('UTF-8',false);
}else 
{{$this->encoding = $encoding;
}}if ( (deAspis(Aspis_substr($data,array(0,false),array(4,false))) === ("\x00\x00\xFE\xFF")))
 {$data = Aspis_substr($data,array(4,false));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(4,false))) === ("\xFF\xFE\x00\x00")))
 {$data = Aspis_substr($data,array(4,false));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(2,false))) === ("\xFE\xFF")))
 {$data = Aspis_substr($data,array(2,false));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(2,false))) === ("\xFF\xFE")))
 {$data = Aspis_substr($data,array(2,false));
}elseif ( (deAspis(Aspis_substr($data,array(0,false),array(3,false))) === ("\xEF\xBB\xBF")))
 {$data = Aspis_substr($data,array(3,false));
}if ( (((deAspis(Aspis_substr($data,array(0,false),array(5,false))) === ('<?xml')) && strspn(deAspis(Aspis_substr($data,array(5,false),array(1,false))),("\x09\x0A\x0D\x20"))) && (deAspis(($pos = attAspis(strpos($data[0],'?>')))) !== false)))
 {$declaration = array(new SimplePie_XML_Declaration_Parser(Aspis_substr($data,array(5,false),array($pos[0] - (5),false))),false);
if ( deAspis($declaration[0]->parse()))
 {$data = Aspis_substr($data,array($pos[0] + (2),false));
$data = concat(concat2(concat(concat2(concat(concat2(concat1('<?xml version="',$declaration[0]->version),'" encoding="'),$encoding),'" standalone="'),(deAspis(($declaration[0]->standalone)) ? array('yes',false) : array('no',false))),'"?>'),$data);
}else 
{{$this->error_string = array('SimplePie bug! Please report this!',false);
return array(false,false);
}}}$return = array(true,false);
static $xml_is_sane = array(null,false);
if ( ($xml_is_sane[0] === null))
 {$parser_check = array(xml_parser_create(),false);
AspisInternalFunctionCall("xml_parse_into_struct",$parser_check[0],('<foo>&amp;</foo>'),AspisPushRefParam($values),array(2));
xml_parser_free(deAspisRC($parser_check));
$xml_is_sane = array((isset($values[0][(0)][0][('value')]) && Aspis_isset( $values [0][(0)] [0][('value')])),false);
}if ( $xml_is_sane[0])
 {$xml = array(xml_parser_create_ns(deAspisRC($this->encoding),deAspisRC($this->separator)),false);
xml_parser_set_option($xml[0],XML_OPTION_SKIP_WHITE,1);
xml_parser_set_option($xml[0],XML_OPTION_CASE_FOLDING,0);
Aspis_xml_set_object($xml,array($this,false));
Aspis_xml_set_character_data_handler($xml,array('cdata',false));
Aspis_xml_set_element_handler($xml,array('tag_open',false),array('tag_close',false));
if ( (!(xml_parse($xml[0],$data[0],true))))
 {$this->error_code = array(xml_get_error_code(deAspisRC($xml)),false);
$this->error_string = array(xml_error_string(deAspisRC($this->error_code)),false);
$return = array(false,false);
}$this->current_line = array(xml_get_current_line_number(deAspisRC($xml)),false);
$this->current_column = array(xml_get_current_column_number(deAspisRC($xml)),false);
$this->current_byte = array(xml_get_current_byte_index(deAspisRC($xml)),false);
xml_parser_free(deAspisRC($xml));
return $return;
}else 
{{libxml_clear_errors();
$xml = array(new XMLReader(),false);
$xml[0]->xml($data);
while ( deAspis(@$xml[0]->read()) )
{switch ( $xml[0]->nodeType[0] ) {
case deAspis(attAspisRC(constant(('XMLReader::END_ELEMENT')))):if ( ($xml[0]->namespaceURI[0] !== ('')))
 {$tagName = $xml[0]->namespaceURI;
}else 
{{$tagName = $xml[0]->localName;
}}$this->tag_close(array(null,false),$tagName);
break ;
case deAspis(attAspisRC(constant(('XMLReader::ELEMENT')))):$empty = $xml[0]->isEmptyElement;
if ( ($xml[0]->namespaceURI[0] !== ('')))
 {$tagName = $xml[0]->namespaceURI;
}else 
{{$tagName = $xml[0]->localName;
}}$attributes = array(array(),false);
while ( deAspis($xml[0]->moveToNextAttribute()) )
{if ( ($xml[0]->namespaceURI[0] !== ('')))
 {$attrName = $xml[0]->namespaceURI;
}else 
{{$attrName = $xml[0]->localName;
}}arrayAssign($attributes[0],deAspis(registerTaint($attrName)),addTaint($xml[0]->value));
}$this->tag_open(array(null,false),$tagName,$attributes);
if ( $empty[0])
 {$this->tag_close(array(null,false),$tagName);
}break ;
case deAspis(attAspisRC(constant(('XMLReader::TEXT')))):case deAspis(attAspisRC(constant(('XMLReader::CDATA')))):$this->cdata(array(null,false),$xml[0]->value);
break ;
 }
}if ( deAspis($error = array(libxml_get_last_error(),false)))
 {$this->error_code = $error[0]->code;
$this->error_string = $error[0]->message;
$this->current_line = $error[0]->line;
$this->current_column = $error[0]->column;
return array(false,false);
}else 
{{return array(true,false);
}}}}} }
function get_error_code (  ) {
{return $this->error_code;
} }
function get_error_string (  ) {
{return $this->error_string;
} }
function get_current_line (  ) {
{return $this->current_line;
} }
function get_current_column (  ) {
{return $this->current_column;
} }
function get_current_byte (  ) {
{return $this->current_byte;
} }
function get_data (  ) {
{return $this->data;
} }
function tag_open ( $parser,$tag,$attributes ) {
{list($this->namespace[0][],$this->element[0][]) = deAspisList($this->split_ns($tag),array());
$attribs = array(array(),false);
foreach ( $attributes[0] as $name =>$value )
{restoreTaint($name,$value);
{list($attrib_namespace,$attribute) = deAspisList($this->split_ns($name),array());
arrayAssign($attribs[0][$attrib_namespace[0]][0],deAspis(registerTaint($attribute)),addTaint($value));
}}if ( ((isset($attribs[0][SIMPLEPIE_NAMESPACE_XML][0][('base')]) && Aspis_isset( $attribs [0][SIMPLEPIE_NAMESPACE_XML] [0][('base')]))))
 {arrayAssignAdd($this->xml_base[0][],addTaint(SimplePie_Misc::absolutize_url($attribs[0][SIMPLEPIE_NAMESPACE_XML][0]['base'],Aspis_end($this->xml_base))));
arrayAssignAdd($this->xml_base_explicit[0][],addTaint(array(true,false)));
}else 
{{arrayAssignAdd($this->xml_base[0][],addTaint(Aspis_end($this->xml_base)));
arrayAssignAdd($this->xml_base_explicit[0][],addTaint(Aspis_end($this->xml_base_explicit)));
}}if ( ((isset($attribs[0][SIMPLEPIE_NAMESPACE_XML][0][('lang')]) && Aspis_isset( $attribs [0][SIMPLEPIE_NAMESPACE_XML] [0][('lang')]))))
 {arrayAssignAdd($this->xml_lang[0][],addTaint($attribs[0][SIMPLEPIE_NAMESPACE_XML][0]['lang']));
}else 
{{arrayAssignAdd($this->xml_lang[0][],addTaint(Aspis_end($this->xml_lang)));
}}if ( ($this->current_xhtml_construct[0] >= (0)))
 {postincr($this->current_xhtml_construct);
if ( (deAspis(Aspis_end($this->namespace)) === SIMPLEPIE_NAMESPACE_XHTML))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('data',false))),addTaint(concat($this->data[0][('data')] ,concat1('<',Aspis_end($this->element)))));
if ( ((isset($attribs[0][('')]) && Aspis_isset( $attribs [0][('')]))))
 {foreach ( deAspis($attribs[0]['']) as $name =>$value )
{restoreTaint($name,$value);
{arrayAssign($this->data[0],deAspis(registerTaint(array('data',false))),addTaint(concat($this->data[0][('data')] ,concat2(concat(concat2(concat1(' ',$name),'="'),Aspis_htmlspecialchars($value,array(ENT_COMPAT,false),$this->encoding)),'"'))));
}}}arrayAssign($this->data[0],deAspis(registerTaint(array('data',false))),addTaint(concat2($this->data[0][('data')] ,'>')));
}}else 
{{$this->datas[0][] = &addTaintR($this->data);
$this->data = &$this->data[0][('child')][0][deAspis(Aspis_end($this->namespace))][0][deAspis(Aspis_end($this->element))][0][];
$this->data = array(array('data' => array('',false,false),deregisterTaint(array('attribs',false)) => addTaint($attribs),deregisterTaint(array('xml_base',false)) => addTaint(Aspis_end($this->xml_base)),deregisterTaint(array('xml_base_explicit',false)) => addTaint(Aspis_end($this->xml_base_explicit)),deregisterTaint(array('xml_lang',false)) => addTaint(Aspis_end($this->xml_lang))),false);
if ( (((((deAspis(Aspis_end($this->namespace)) === SIMPLEPIE_NAMESPACE_ATOM_03) && deAspis(Aspis_in_array(Aspis_end($this->element),array(array(array('title',false),array('tagline',false),array('copyright',false),array('info',false),array('summary',false),array('content',false)),false)))) && ((isset($attribs[0][('')][0][('mode')]) && Aspis_isset( $attribs [0][('')] [0][('mode')])))) && (deAspis($attribs[0][('')][0]['mode']) === ('xml'))) || ((((deAspis(Aspis_end($this->namespace)) === SIMPLEPIE_NAMESPACE_ATOM_10) && deAspis(Aspis_in_array(Aspis_end($this->element),array(array(array('rights',false),array('subtitle',false),array('summary',false),array('info',false),array('title',false),array('content',false)),false)))) && ((isset($attribs[0][('')][0][('type')]) && Aspis_isset( $attribs [0][('')] [0][('type')])))) && (deAspis($attribs[0][('')][0]['type']) === ('xhtml')))))
 {$this->current_xhtml_construct = array(0,false);
}}}} }
function cdata ( $parser,$cdata ) {
{if ( ($this->current_xhtml_construct[0] >= (0)))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('data',false))),addTaint(concat($this->data[0][('data')] ,Aspis_htmlspecialchars($cdata,array(ENT_QUOTES,false),$this->encoding))));
}else 
{{arrayAssign($this->data[0],deAspis(registerTaint(array('data',false))),addTaint(concat($this->data[0][('data')] ,$cdata)));
}}} }
function tag_close ( $parser,$tag ) {
{if ( ($this->current_xhtml_construct[0] >= (0)))
 {postdecr($this->current_xhtml_construct);
if ( ((deAspis(Aspis_end($this->namespace)) === SIMPLEPIE_NAMESPACE_XHTML) && (denot_boolean(Aspis_in_array(Aspis_end($this->element),array(array(array('area',false),array('base',false),array('basefont',false),array('br',false),array('col',false),array('frame',false),array('hr',false),array('img',false),array('input',false),array('isindex',false),array('link',false),array('meta',false),array('param',false)),false))))))
 {arrayAssign($this->data[0],deAspis(registerTaint(array('data',false))),addTaint(concat($this->data[0][('data')] ,concat2(concat1('</',Aspis_end($this->element)),'>'))));
}}if ( ($this->current_xhtml_construct[0] === deAspis(negate(array(1,false)))))
 {$this->data = &$this->datas[0][(count($this->datas[0]) - (1))];
Aspis_array_pop($this->datas);
}Aspis_array_pop($this->element);
Aspis_array_pop($this->namespace);
Aspis_array_pop($this->xml_base);
Aspis_array_pop($this->xml_base_explicit);
Aspis_array_pop($this->xml_lang);
} }
function split_ns ( $string ) {
{static $cache = array(array(),false);
if ( (!((isset($cache[0][$string[0]]) && Aspis_isset( $cache [0][$string[0]])))))
 {if ( deAspis($pos = attAspis(strpos($string[0],deAspisRC($this->separator)))))
 {static $separator_length;
if ( (denot_boolean($separator_length)))
 {$separator_length = attAspis(strlen($this->separator[0]));
}$namespace = Aspis_substr($string,array(0,false),$pos);
$local_name = Aspis_substr($string,array($pos[0] + $separator_length[0],false));
if ( (deAspis(Aspis_strtolower($namespace)) === SIMPLEPIE_NAMESPACE_ITUNES))
 {$namespace = array(SIMPLEPIE_NAMESPACE_ITUNES,false);
}if ( ($namespace[0] === SIMPLEPIE_NAMESPACE_MEDIARSS_WRONG))
 {$namespace = array(SIMPLEPIE_NAMESPACE_MEDIARSS,false);
}arrayAssign($cache[0],deAspis(registerTaint($string)),addTaint(array(array($namespace,$local_name),false)));
}else 
{{arrayAssign($cache[0],deAspis(registerTaint($string)),addTaint(array(array(array('',false),$string),false)));
}}}return attachAspis($cache,$string[0]);
} }
}class SimplePie_Sanitize{var $base;
var $remove_div = array(true,false);
var $image_handler = array('',false);
var $strip_htmltags = array(array(array('base',false),array('blink',false),array('body',false),array('doctype',false),array('embed',false),array('font',false),array('form',false),array('frame',false),array('frameset',false),array('html',false),array('iframe',false),array('input',false),array('marquee',false),array('meta',false),array('noscript',false),array('object',false),array('param',false),array('script',false),array('style',false)),false);
var $encode_instead_of_strip = array(false,false);
var $strip_attributes = array(array(array('bgsound',false),array('class',false),array('expr',false),array('id',false),array('style',false),array('onclick',false),array('onerror',false),array('onfinish',false),array('onmouseover',false),array('onmouseout',false),array('onfocus',false),array('onblur',false),array('lowsrc',false),array('dynsrc',false)),false);
var $strip_comments = array(false,false);
var $output_encoding = array('UTF-8',false);
var $enable_cache = array(true,false);
var $cache_location = array('./cache',false);
var $cache_name_function = array('md5',false);
var $cache_class = array('SimplePie_Cache',false);
var $file_class = array('SimplePie_File',false);
var $timeout = array(10,false);
var $useragent = array('',false);
var $force_fsockopen = array(false,false);
var $replace_url_attributes = array(array('a' => array('href',false),'area' => array('href',false),'blockquote' => array('cite',false),'del' => array('cite',false),'form' => array('action',false),'img' => array(array(array('longdesc',false),array('src',false)),false),'input' => array('src',false),'ins' => array('cite',false),'q' => array('cite',false)),false);
function remove_div ( $enable = array(true,false) ) {
{$this->remove_div = bool_cast($enable);
} }
function set_image_handler ( $page = array(false,false) ) {
{if ( $page[0])
 {$this->image_handler = string_cast($page);
}else 
{{$this->image_handler = array(false,false);
}}} }
function pass_cache_data ( $enable_cache = array(true,false),$cache_location = array('./cache',false),$cache_name_function = array('md5',false),$cache_class = array('SimplePie_Cache',false) ) {
{if ( ((isset($enable_cache) && Aspis_isset( $enable_cache))))
 {$this->enable_cache = bool_cast($enable_cache);
}if ( $cache_location[0])
 {$this->cache_location = string_cast($cache_location);
}if ( $cache_name_function[0])
 {$this->cache_name_function = string_cast($cache_name_function);
}if ( $cache_class[0])
 {$this->cache_class = string_cast($cache_class);
}} }
function pass_file_data ( $file_class = array('SimplePie_File',false),$timeout = array(10,false),$useragent = array('',false),$force_fsockopen = array(false,false) ) {
{if ( $file_class[0])
 {$this->file_class = string_cast($file_class);
}if ( $timeout[0])
 {$this->timeout = string_cast($timeout);
}if ( $useragent[0])
 {$this->useragent = string_cast($useragent);
}if ( $force_fsockopen[0])
 {$this->force_fsockopen = string_cast($force_fsockopen);
}} }
function strip_htmltags ( $tags = array(array(array('base',false),array('blink',false),array('body',false),array('doctype',false),array('embed',false),array('font',false),array('form',false),array('frame',false),array('frameset',false),array('html',false),array('iframe',false),array('input',false),array('marquee',false),array('meta',false),array('noscript',false),array('object',false),array('param',false),array('script',false),array('style',false)),false) ) {
{if ( $tags[0])
 {if ( is_array($tags[0]))
 {$this->strip_htmltags = $tags;
}else 
{{$this->strip_htmltags = Aspis_explode(array(',',false),$tags);
}}}else 
{{$this->strip_htmltags = array(false,false);
}}} }
function encode_instead_of_strip ( $encode = array(false,false) ) {
{$this->encode_instead_of_strip = bool_cast($encode);
} }
function strip_attributes ( $attribs = array(array(array('bgsound',false),array('class',false),array('expr',false),array('id',false),array('style',false),array('onclick',false),array('onerror',false),array('onfinish',false),array('onmouseover',false),array('onmouseout',false),array('onfocus',false),array('onblur',false),array('lowsrc',false),array('dynsrc',false)),false) ) {
{if ( $attribs[0])
 {if ( is_array($attribs[0]))
 {$this->strip_attributes = $attribs;
}else 
{{$this->strip_attributes = Aspis_explode(array(',',false),$attribs);
}}}else 
{{$this->strip_attributes = array(false,false);
}}} }
function strip_comments ( $strip = array(false,false) ) {
{$this->strip_comments = bool_cast($strip);
} }
function set_output_encoding ( $encoding = array('UTF-8',false) ) {
{$this->output_encoding = string_cast($encoding);
} }
function set_url_replacements ( $element_attribute = array(array('a' => array('href',false),'area' => array('href',false),'blockquote' => array('cite',false),'del' => array('cite',false),'form' => array('action',false),'img' => array(array(array('longdesc',false),array('src',false)),false),'input' => array('src',false),'ins' => array('cite',false),'q' => array('cite',false)),false) ) {
{$this->replace_url_attributes = array_cast($element_attribute);
} }
function sanitize ( $data,$type,$base = array('',false) ) {
{$data = Aspis_trim($data);
if ( (($data[0] !== ('')) || ($type[0] & SIMPLEPIE_CONSTRUCT_IRI)))
 {if ( ($type[0] & SIMPLEPIE_CONSTRUCT_MAYBE_HTML))
 {if ( deAspis(Aspis_preg_match(concat2(concat12('/(&(#(x[0-9a-fA-F]+|[0-9]+)|[a-zA-Z0-9]+)|<\/[A-Za-z][^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3E]*',SIMPLEPIE_PCRE_HTML_ATTRIBUTE),'>)/'),$data)))
 {$type = array($type[0] | SIMPLEPIE_CONSTRUCT_HTML,false);
}else 
{{$type = array($type[0] | SIMPLEPIE_CONSTRUCT_TEXT,false);
}}}if ( ($type[0] & SIMPLEPIE_CONSTRUCT_BASE64))
 {$data = Aspis_base64_decode($data);
}if ( ($type[0] & SIMPLEPIE_CONSTRUCT_XHTML))
 {if ( $this->remove_div[0])
 {$data = Aspis_preg_replace(concat2(concat12('/^<div',SIMPLEPIE_PCRE_XML_ATTRIBUTE),'>/'),array('',false),$data);
$data = Aspis_preg_replace(array('/<\/div>$/',false),array('',false),$data);
}else 
{{$data = Aspis_preg_replace(concat2(concat12('/^<div',SIMPLEPIE_PCRE_XML_ATTRIBUTE),'>/'),array('<div>',false),$data);
}}}if ( ($type[0] & (SIMPLEPIE_CONSTRUCT_HTML | SIMPLEPIE_CONSTRUCT_XHTML)))
 {if ( $this->strip_comments[0])
 {$data = SimplePie_Misc::strip_comments($data);
}if ( $this->strip_htmltags[0])
 {foreach ( $this->strip_htmltags[0] as $tag  )
{$pcre = concat2(concat2(concat(concat2(concat2(concat1("/<(",$tag),")"),SIMPLEPIE_PCRE_HTML_ATTRIBUTE),concat1("(>(.*)<\/",$tag)),SIMPLEPIE_PCRE_HTML_ATTRIBUTE),'>|(\/)?>)/siU');
while ( deAspis(Aspis_preg_match($pcre,$data)) )
{$data = Aspis_preg_replace_callback($pcre,array(array(array($this,false),array('do_strip_htmltags',false)),false),$data);
}}}if ( $this->strip_attributes[0])
 {foreach ( $this->strip_attributes[0] as $attrib  )
{$data = Aspis_preg_replace(concat2(concat2(concat2(concat(concat12('/(<[A-Za-z][^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3E]*)',SIMPLEPIE_PCRE_HTML_ATTRIBUTE),Aspis_trim($attrib)),'(?:\s*=\s*(?:"(?:[^"]*)"|\'(?:[^\']*)\'|(?:[^\x09\x0A\x0B\x0C\x0D\x20\x22\x27\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x3E]*)?))?'),SIMPLEPIE_PCRE_HTML_ATTRIBUTE),'>/'),array('\1\2\3>',false),$data);
}}$this->base = $base;
foreach ( $this->replace_url_attributes[0] as $element =>$attributes )
{restoreTaint($element,$attributes);
{$data = $this->replace_urls($data,$element,$attributes);
}}if ( ((((isset($this->image_handler) && Aspis_isset( $this ->image_handler ))) && (deAspis((string_cast($this->image_handler))) !== (''))) && $this->enable_cache[0]))
 {$images = SimplePie_Misc::get_element(array('img',false),$data);
foreach ( $images[0] as $img  )
{if ( ((isset($img[0][('attribs')][0][('src')][0][('data')]) && Aspis_isset( $img [0][('attribs')] [0][('src')] [0][('data')]))))
 {$image_url = Aspis_call_user_func($this->cache_name_function,$img[0][('attribs')][0][('src')][0]['data']);
$cache = Aspis_call_user_func(array(array($this->cache_class,array('create',false)),false),$this->cache_location,$image_url,array('spi',false));
if ( deAspis($cache[0]->load()))
 {arrayAssign($img[0][('attribs')][0][('src')][0],deAspis(registerTaint(array('data',false))),addTaint(concat($this->image_handler,$image_url)));
$data = Aspis_str_replace($img[0]['full'],SimplePie_Misc::element_implode($img),$data);
}else 
{{$file = array(new $this->file_class[0]($img[0][('attribs')][0][('src')][0][('data')],$this->timeout,array(5,false),array(array(deregisterTaint(array('X-FORWARDED-FOR',false)) => addTaint($_SERVER[0][('REMOTE_ADDR')])),false),$this->useragent,$this->force_fsockopen),false);
$headers = $file[0]->headers;
if ( ($file[0]->success[0] && (($file[0]->method[0] & (SIMPLEPIE_FILE_SOURCE_REMOTE === (0))) || (($file[0]->status_code[0] === (200)) || (($file[0]->status_code[0] > (206)) && ($file[0]->status_code[0] < (300)))))))
 {if ( deAspis($cache[0]->save(array(array(deregisterTaint(array('headers',false)) => addTaint($file[0]->headers),deregisterTaint(array('body',false)) => addTaint($file[0]->body)),false))))
 {arrayAssign($img[0][('attribs')][0][('src')][0],deAspis(registerTaint(array('data',false))),addTaint(concat($this->image_handler,$image_url)));
$data = Aspis_str_replace($img[0]['full'],SimplePie_Misc::element_implode($img),$data);
}else 
{{trigger_error((deconcat2($this->cache_location," is not writeable")),E_USER_WARNING);
}}}}}}}}$data = Aspis_trim($data);
}if ( ($type[0] & SIMPLEPIE_CONSTRUCT_IRI))
 {$data = SimplePie_Misc::absolutize_url($data,$base);
}if ( ($type[0] & (SIMPLEPIE_CONSTRUCT_TEXT | SIMPLEPIE_CONSTRUCT_IRI)))
 {$data = Aspis_htmlspecialchars($data,array(ENT_COMPAT,false),array('UTF-8',false));
}if ( ($this->output_encoding[0] !== ('UTF-8')))
 {$data = SimplePie_Misc::change_encoding($data,array('UTF-8',false),$this->output_encoding);
}}return $data;
} }
function replace_urls ( $data,$tag,$attributes ) {
{if ( ((!(is_array($this->strip_htmltags[0]))) || (denot_boolean(Aspis_in_array($tag,$this->strip_htmltags)))))
 {$elements = SimplePie_Misc::get_element($tag,$data);
foreach ( $elements[0] as $element  )
{if ( is_array($attributes[0]))
 {foreach ( $attributes[0] as $attribute  )
{if ( ((isset($element[0][('attribs')][0][$attribute[0]][0][('data')]) && Aspis_isset( $element [0][('attribs')] [0][$attribute[0]] [0][('data')]))))
 {arrayAssign($element[0][('attribs')][0][$attribute[0]][0],deAspis(registerTaint(array('data',false))),addTaint(SimplePie_Misc::absolutize_url($element[0][('attribs')][0][$attribute[0]][0]['data'],$this->base)));
$new_element = SimplePie_Misc::element_implode($element);
$data = Aspis_str_replace($element[0]['full'],$new_element,$data);
arrayAssign($element[0],deAspis(registerTaint(array('full',false))),addTaint($new_element));
}}}elseif ( ((isset($element[0][('attribs')][0][$attributes[0]][0][('data')]) && Aspis_isset( $element [0][('attribs')] [0][$attributes[0]] [0][('data')]))))
 {arrayAssign($element[0][('attribs')][0][$attributes[0]][0],deAspis(registerTaint(array('data',false))),addTaint(SimplePie_Misc::absolutize_url($element[0][('attribs')][0][$attributes[0]][0]['data'],$this->base)));
$data = Aspis_str_replace($element[0]['full'],SimplePie_Misc::element_implode($element),$data);
}}}return $data;
} }
function do_strip_htmltags ( $match ) {
{if ( $this->encode_instead_of_strip[0])
 {if ( (((isset($match[0][(4)]) && Aspis_isset( $match [0][(4)]))) && (denot_boolean(Aspis_in_array(Aspis_strtolower(attachAspis($match,(1))),array(array(array('script',false),array('style',false)),false))))))
 {arrayAssign($match[0],deAspis(registerTaint(array(1,false))),addTaint(Aspis_htmlspecialchars(attachAspis($match,(1)),array(ENT_COMPAT,false),array('UTF-8',false))));
arrayAssign($match[0],deAspis(registerTaint(array(2,false))),addTaint(Aspis_htmlspecialchars(attachAspis($match,(2)),array(ENT_COMPAT,false),array('UTF-8',false))));
return concat2(concat(concat2(concat(concat2(concat(concat1("&lt;",attachAspis($match,(1))),attachAspis($match,(2))),"&gt;"),attachAspis($match,(3))),"&lt;/"),attachAspis($match,(1))),"&gt;");
}else 
{{return Aspis_htmlspecialchars(attachAspis($match,(0)),array(ENT_COMPAT,false),array('UTF-8',false));
}}}elseif ( (((isset($match[0][(4)]) && Aspis_isset( $match [0][(4)]))) && (denot_boolean(Aspis_in_array(Aspis_strtolower(attachAspis($match,(1))),array(array(array('script',false),array('style',false)),false))))))
 {return attachAspis($match,(4));
}else 
{{return array('',false);
}}} }
};
?>
<?php 