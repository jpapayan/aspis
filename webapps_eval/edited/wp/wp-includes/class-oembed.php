<?php require_once('AspisMain.php'); ?><?php
class WP_oEmbed{var $providers = array(array(),false);
function WP_oEmbed (  ) {
{return $this->__construct();
} }
function __construct (  ) {
{$this->providers = apply_filters(array('oembed_providers',false),array(array('#http://(www\.)?youtube.com/watch.*#i' => array(array(array('http://www.youtube.com/oembed',false),array(true,false)),false,false),'http://blip.tv/file/*' => array(array(array('http://blip.tv/oembed/',false),array(false,false)),false,false),'#http://(www\.)?vimeo\.com/.*#i' => array(array(array('http://www.vimeo.com/api/oembed.{format}',false),array(true,false)),false,false),'#http://(www\.)?dailymotion\.com/.*#i' => array(array(array('http://www.dailymotion.com/api/oembed',false),array(true,false)),false,false),'#http://(www\.)?flickr\.com/.*#i' => array(array(array('http://www.flickr.com/services/oembed/',false),array(true,false)),false,false),'#http://(www\.)?hulu\.com/watch/.*#i' => array(array(array('http://www.hulu.com/api/oembed.{format}',false),array(true,false)),false,false),'#http://(www\.)?viddler\.com/.*#i' => array(array(array('http://lab.viddler.com/services/oembed/',false),array(true,false)),false,false),'http://qik.com/*' => array(array(array('http://qik.com/api/oembed.{format}',false),array(false,false)),false,false),'http://revision3.com/*' => array(array(array('http://revision3.com/api/oembed/',false),array(false,false)),false,false),'http://i*.photobucket.com/albums/*' => array(array(array('http://photobucket.com/oembed',false),array(false,false)),false,false),'http://gi*.photobucket.com/groups/*' => array(array(array('http://photobucket.com/oembed',false),array(false,false)),false,false),'#http://(www\.)?scribd\.com/.*#i' => array(array(array('http://www.scribd.com/services/oembed',false),array(true,false)),false,false),'http://wordpress.tv/*' => array(array(array('http://wordpress.tv/oembed/',false),array(false,false)),false,false),),false));
add_filter(array('oembed_dataparse',false),array(array(array($this,false),array('strip_scribd_newlines',false)),false),array(10,false),array(3,false));
} }
function get_html ( $url,$args = array('',false) ) {
{$provider = array(false,false);
if ( (!((isset($args[0][('discover')]) && Aspis_isset( $args [0][('discover')])))))
 arrayAssign($args[0],deAspis(registerTaint(array('discover',false))),addTaint(array(true,false)));
foreach ( $this->providers[0] as $matchmask =>$data )
{restoreTaint($matchmask,$data);
{list($providerurl,$regex) = deAspisList($data,array());
if ( (denot_boolean($regex)))
 $matchmask = concat2(concat1('#',Aspis_str_replace(array('___wildcard___',false),array('(.+)',false),Aspis_preg_quote(Aspis_str_replace(array('*',false),array('___wildcard___',false),$matchmask),array('#',false)))),'#i');
if ( deAspis(Aspis_preg_match($matchmask,$url)))
 {$provider = Aspis_str_replace(array('{format}',false),array('json',false),$providerurl);
break ;
}}}if ( ((denot_boolean($provider)) && deAspis($args[0]['discover'])))
 $provider = $this->discover($url);
if ( ((denot_boolean($provider)) || (false === deAspis($data = $this->fetch($provider,$url,$args)))))
 return array(false,false);
return apply_filters(array('oembed_result',false),$this->data2html($data,$url),$url,$args);
} }
function discover ( $url ) {
{$providers = array(array(),false);
if ( deAspis($html = wp_remote_retrieve_body(wp_remote_get($url))))
 {$linktypes = apply_filters(array('oembed_linktypes',false),array(array('application/json+oembed' => array('json',false,false),'text/xml+oembed' => array('xml',false,false),'application/xml+oembed' => array('xml',false,false),),false));
$html = Aspis_substr($html,array(0,false),array(stripos(deAspisRC($html),'</head>'),false));
$tagfound = array(false,false);
foreach ( $linktypes[0] as $linktype =>$format )
{restoreTaint($linktype,$format);
{if ( (stripos(deAspisRC($html),deAspisRC($linktype))))
 {$tagfound = array(true,false);
break ;
}}}if ( ($tagfound[0] && deAspis(Aspis_preg_match_all(array('/<link([^<>]+)>/i',false),$html,$links))))
 {foreach ( deAspis(attachAspis($links,(1))) as $link  )
{$atts = shortcode_parse_atts($link);
if ( (((!((empty($atts[0][('type')]) || Aspis_empty( $atts [0][('type')])))) && (!((empty($linktypes[0][deAspis($atts[0]['type'])]) || Aspis_empty( $linktypes [0][deAspis($atts [0]['type'])]))))) && (!((empty($atts[0][('href')]) || Aspis_empty( $atts [0][('href')]))))))
 {arrayAssign($providers[0],deAspis(registerTaint(attachAspis($linktypes,deAspis($atts[0]['type'])))),addTaint($atts[0]['href']));
if ( (('json') == deAspis(attachAspis($linktypes,deAspis($atts[0]['type'])))))
 break ;
}}}}if ( (!((empty($providers[0][('json')]) || Aspis_empty( $providers [0][('json')])))))
 return $providers[0]['json'];
elseif ( (!((empty($providers[0][('xml')]) || Aspis_empty( $providers [0][('xml')])))))
 return $providers[0]['xml'];
else 
{return array(false,false);
}} }
function fetch ( $provider,$url,$args = array('',false) ) {
{$args = wp_parse_args($args,wp_embed_defaults());
$provider = add_query_arg(array('format',false),array('json',false),$provider);
$provider = add_query_arg(array('maxwidth',false),$args[0]['width'],$provider);
$provider = add_query_arg(array('maxheight',false),$args[0]['height'],$provider);
$provider = add_query_arg(array('url',false),Aspis_urlencode($url),$provider);
if ( (denot_boolean($result = wp_remote_retrieve_body(wp_remote_get($provider)))))
 return array(false,false);
$result = Aspis_trim($result);
if ( deAspis($data = array(json_decode(deAspisRC($result)),false)))
 {return $data;
}elseif ( function_exists(('simplexml_load_string')))
 {$errors = array(libxml_use_internal_errors('true'),false);
$data = array(simplexml_load_string(deAspisRC($result)),false);
libxml_use_internal_errors(deAspisRC($errors));
if ( is_object($data[0]))
 return $data;
}return array(false,false);
} }
function data2html ( $data,$url ) {
{if ( ((!(is_object($data[0]))) || ((empty($data[0]->type) || Aspis_empty( $data[0] ->type )))))
 return array(false,false);
switch ( $data[0]->type[0] ) {
case ('photo'):if ( ((((empty($data[0]->url) || Aspis_empty( $data[0] ->url ))) || ((empty($data[0]->width) || Aspis_empty( $data[0] ->width )))) || ((empty($data[0]->height) || Aspis_empty( $data[0] ->height )))))
 return array(false,false);
$title = (!((empty($data[0]->title) || Aspis_empty( $data[0] ->title )))) ? $data[0]->title : array('',false);
$return = concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<img src="',esc_attr(clean_url($data[0]->url))),'" alt="'),esc_attr($title)),'" width="'),esc_attr($data[0]->width)),'" height="'),esc_attr($data[0]->height)),'" />');
break ;
case ('video'):case ('rich'):$return = (!((empty($data[0]->html) || Aspis_empty( $data[0] ->html )))) ? $data[0]->html : array(false,false);
break ;
case ('link'):$return = (!((empty($data[0]->title) || Aspis_empty( $data[0] ->title )))) ? concat2(concat(concat2(concat1('<a href="',clean_url($url)),'">'),esc_html($data[0]->title)),'</a>') : array(false,false);
break ;
default :$return = array(false,false);
 }
return apply_filters(array('oembed_dataparse',false),$return,$data,$url);
} }
function strip_scribd_newlines ( $html,$data,$url ) {
{if ( deAspis(Aspis_preg_match(array('#http://(www\.)?scribd.com/.*#i',false),$url)))
 $html = Aspis_str_replace(array(array(array("\r\n",false),array("\n",false)),false),array('',false),$html);
return $html;
} }
}function &_wp_oembed_get_object (  ) {
static $wp_oembed;
if ( is_null(deAspisRC($wp_oembed)))
 $wp_oembed = array(new WP_oEmbed(),false);
return $wp_oembed;
 }
;
