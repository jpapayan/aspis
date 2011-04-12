<?php require_once('AspisMain.php'); ?><?php
class WP_oEmbed{var $providers = array();
function WP_oEmbed (  ) {
{{$AspisRetTemp = $this->__construct();
return $AspisRetTemp;
}} }
function __construct (  ) {
{$this->providers = apply_filters('oembed_providers',array('#http://(www\.)?youtube.com/watch.*#i' => array('http://www.youtube.com/oembed',true),'http://blip.tv/file/*' => array('http://blip.tv/oembed/',false),'#http://(www\.)?vimeo\.com/.*#i' => array('http://www.vimeo.com/api/oembed.{format}',true),'#http://(www\.)?dailymotion\.com/.*#i' => array('http://www.dailymotion.com/api/oembed',true),'#http://(www\.)?flickr\.com/.*#i' => array('http://www.flickr.com/services/oembed/',true),'#http://(www\.)?hulu\.com/watch/.*#i' => array('http://www.hulu.com/api/oembed.{format}',true),'#http://(www\.)?viddler\.com/.*#i' => array('http://lab.viddler.com/services/oembed/',true),'http://qik.com/*' => array('http://qik.com/api/oembed.{format}',false),'http://revision3.com/*' => array('http://revision3.com/api/oembed/',false),'http://i*.photobucket.com/albums/*' => array('http://photobucket.com/oembed',false),'http://gi*.photobucket.com/groups/*' => array('http://photobucket.com/oembed',false),'#http://(www\.)?scribd\.com/.*#i' => array('http://www.scribd.com/services/oembed',true),'http://wordpress.tv/*' => array('http://wordpress.tv/oembed/',false),));
add_filter('oembed_dataparse',array($this,'strip_scribd_newlines'),10,3);
} }
function get_html ( $url,$args = '' ) {
{$provider = false;
if ( !isset($args['discover']))
 $args['discover'] = true;
foreach ( $this->providers as $matchmask =>$data )
{list($providerurl,$regex) = $data;
if ( !$regex)
 $matchmask = '#' . str_replace('___wildcard___','(.+)',preg_quote(str_replace('*','___wildcard___',$matchmask),'#')) . '#i';
if ( preg_match($matchmask,$url))
 {$provider = str_replace('{format}','json',$providerurl);
break ;
}}if ( !$provider && $args['discover'])
 $provider = $this->discover($url);
if ( !$provider || false === $data = $this->fetch($provider,$url,$args))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = apply_filters('oembed_result',$this->data2html($data,$url),$url,$args);
return $AspisRetTemp;
}} }
function discover ( $url ) {
{$providers = array();
if ( $html = wp_remote_retrieve_body(wp_remote_get($url)))
 {$linktypes = apply_filters('oembed_linktypes',array('application/json+oembed' => 'json','text/xml+oembed' => 'xml','application/xml+oembed' => 'xml',));
$html = substr($html,0,stripos($html,'</head>'));
$tagfound = false;
foreach ( $linktypes as $linktype =>$format )
{if ( stripos($html,$linktype))
 {$tagfound = true;
break ;
}}if ( $tagfound && preg_match_all('/<link([^<>]+)>/i',$html,$links))
 {foreach ( $links[1] as $link  )
{$atts = shortcode_parse_atts($link);
if ( !empty($atts['type']) && !empty($linktypes[$atts['type']]) && !empty($atts['href']))
 {$providers[$linktypes[$atts['type']]] = $atts['href'];
if ( 'json' == $linktypes[$atts['type']])
 break ;
}}}}if ( !empty($providers['json']))
 {$AspisRetTemp = $providers['json'];
return $AspisRetTemp;
}elseif ( !empty($providers['xml']))
 {$AspisRetTemp = $providers['xml'];
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
return $AspisRetTemp;
}}} }
function fetch ( $provider,$url,$args = '' ) {
{$args = wp_parse_args($args,wp_embed_defaults());
$provider = add_query_arg('format','json',$provider);
$provider = add_query_arg('maxwidth',$args['width'],$provider);
$provider = add_query_arg('maxheight',$args['height'],$provider);
$provider = add_query_arg('url',urlencode($url),$provider);
if ( !$result = wp_remote_retrieve_body(wp_remote_get($provider)))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$result = trim($result);
if ( $data = json_decode($result))
 {{$AspisRetTemp = $data;
return $AspisRetTemp;
}}elseif ( function_exists('simplexml_load_string'))
 {$errors = libxml_use_internal_errors('true');
$data = simplexml_load_string($result);
libxml_use_internal_errors($errors);
if ( is_object($data))
 {$AspisRetTemp = $data;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function data2html ( $data,$url ) {
{if ( !is_object($data) || empty($data->type))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}switch ( $data->type ) {
case 'photo':if ( empty($data->url) || empty($data->width) || empty($data->height))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$title = (!empty($data->title)) ? $data->title : '';
$return = '<img src="' . esc_attr(clean_url($data->url)) . '" alt="' . esc_attr($title) . '" width="' . esc_attr($data->width) . '" height="' . esc_attr($data->height) . '" />';
break ;
case 'video':case 'rich':$return = (!empty($data->html)) ? $data->html : false;
break ;
case 'link':$return = (!empty($data->title)) ? '<a href="' . clean_url($url) . '">' . esc_html($data->title) . '</a>' : false;
break ;
default :$return = false;
 }
{$AspisRetTemp = apply_filters('oembed_dataparse',$return,$data,$url);
return $AspisRetTemp;
}} }
function strip_scribd_newlines ( $html,$data,$url ) {
{if ( preg_match('#http://(www\.)?scribd.com/.*#i',$url))
 $html = str_replace(array("\r\n","\n"),'',$html);
{$AspisRetTemp = $html;
return $AspisRetTemp;
}} }
}function &_wp_oembed_get_object (  ) {
static $wp_oembed;
if ( is_null($wp_oembed))
 $wp_oembed = new WP_oEmbed();
{$AspisRetTemp = &$wp_oembed;
return $AspisRetTemp;
} }
;
