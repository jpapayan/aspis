<?php require_once('AspisMain.php'); ?><?php
$shortcode_tags = array();
function add_shortcode ( $tag,$func ) {
{global $shortcode_tags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $shortcode_tags,"\$shortcode_tags",$AspisChangesCache);
}if ( is_callable($func))
 $shortcode_tags[$tag] = $func;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
 }
function remove_shortcode ( $tag ) {
{global $shortcode_tags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $shortcode_tags,"\$shortcode_tags",$AspisChangesCache);
}unset($shortcode_tags[$tag]);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
 }
function remove_all_shortcodes (  ) {
{global $shortcode_tags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $shortcode_tags,"\$shortcode_tags",$AspisChangesCache);
}$shortcode_tags = array();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
 }
function do_shortcode ( $content ) {
{global $shortcode_tags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $shortcode_tags,"\$shortcode_tags",$AspisChangesCache);
}if ( empty($shortcode_tags) || !is_array($shortcode_tags))
 {$AspisRetTemp = $content;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
return $AspisRetTemp;
}$pattern = get_shortcode_regex();
{$AspisRetTemp = preg_replace_callback('/' . $pattern . '/s','do_shortcode_tag',$content);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
 }
function get_shortcode_regex (  ) {
{global $shortcode_tags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $shortcode_tags,"\$shortcode_tags",$AspisChangesCache);
}$tagnames = array_keys($shortcode_tags);
$tagregexp = join('|',array_map('preg_quote',$tagnames));
{$AspisRetTemp = '(.?)\[(' . $tagregexp . ')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
 }
function do_shortcode_tag ( $m ) {
{global $shortcode_tags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $shortcode_tags,"\$shortcode_tags",$AspisChangesCache);
}if ( $m[1] == '[' && $m[6] == ']')
 {{$AspisRetTemp = substr($m[0],1,-1);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
return $AspisRetTemp;
}}$tag = $m[2];
$attr = shortcode_parse_atts($m[3]);
if ( isset($m[5]))
 {{$AspisRetTemp = $m[1] . AspisUntainted_call_user_func($shortcode_tags[$tag],$attr,$m[5],$m[2]) . $m[6];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = $m[1] . AspisUntainted_call_user_func($shortcode_tags[$tag],$attr,NULL,$m[2]) . $m[6];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
 }
function shortcode_parse_atts ( $text ) {
$atts = array();
$pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
$text = preg_replace("/[\x{00a0}\x{200b}]+/u"," ",$text);
if ( preg_match_all($pattern,$text,$match,PREG_SET_ORDER))
 {foreach ( $match as $m  )
{if ( !empty($m[1]))
 $atts[strtolower($m[1])] = stripcslashes($m[2]);
elseif ( !empty($m[3]))
 $atts[strtolower($m[3])] = stripcslashes($m[4]);
elseif ( !empty($m[5]))
 $atts[strtolower($m[5])] = stripcslashes($m[6]);
elseif ( isset($m[7]) and strlen($m[7]))
 $atts[] = stripcslashes($m[7]);
elseif ( isset($m[8]))
 $atts[] = stripcslashes($m[8]);
}}else 
{{$atts = ltrim($text);
}}{$AspisRetTemp = $atts;
return $AspisRetTemp;
} }
function shortcode_atts ( $pairs,$atts ) {
$atts = (array)$atts;
$out = array();
foreach ( $pairs as $name =>$default )
{if ( array_key_exists($name,$atts))
 $out[$name] = $atts[$name];
else 
{$out[$name] = $default;
}}{$AspisRetTemp = $out;
return $AspisRetTemp;
} }
function strip_shortcodes ( $content ) {
{global $shortcode_tags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $shortcode_tags,"\$shortcode_tags",$AspisChangesCache);
}if ( empty($shortcode_tags) || !is_array($shortcode_tags))
 {$AspisRetTemp = $content;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
return $AspisRetTemp;
}$pattern = get_shortcode_regex();
{$AspisRetTemp = preg_replace('/' . $pattern . '/s','$1$6',$content);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
 }
add_filter('the_content','do_shortcode',11);
;
