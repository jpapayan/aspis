<?php require_once('AspisMain.php'); ?><?php
$shortcode_tags = array(array(),false);
function add_shortcode ( $tag,$func ) {
global $shortcode_tags;
if ( is_callable(deAspisRC($func)))
 arrayAssign($shortcode_tags[0],deAspis(registerTaint($tag)),addTaint($func));
 }
function remove_shortcode ( $tag ) {
global $shortcode_tags;
unset($shortcode_tags[0][$tag[0]]);
 }
function remove_all_shortcodes (  ) {
global $shortcode_tags;
$shortcode_tags = array(array(),false);
 }
function do_shortcode ( $content ) {
global $shortcode_tags;
if ( (((empty($shortcode_tags) || Aspis_empty( $shortcode_tags))) || (!(is_array($shortcode_tags[0])))))
 return $content;
$pattern = get_shortcode_regex();
return Aspis_preg_replace_callback(concat2(concat1('/',$pattern),'/s'),array('do_shortcode_tag',false),$content);
 }
function get_shortcode_regex (  ) {
global $shortcode_tags;
$tagnames = attAspisRC(array_keys(deAspisRC($shortcode_tags)));
$tagregexp = Aspis_join(array('|',false),attAspisRC(array_map(AspisInternalCallback(array('preg_quote',false)),deAspisRC($tagnames))));
return concat2(concat1('(.?)\[(',$tagregexp),')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)');
 }
function do_shortcode_tag ( $m ) {
global $shortcode_tags;
if ( ((deAspis(attachAspis($m,(1))) == ('[')) && (deAspis(attachAspis($m,(6))) == (']'))))
 {return Aspis_substr(attachAspis($m,(0)),array(1,false),negate(array(1,false)));
}$tag = attachAspis($m,(2));
$attr = shortcode_parse_atts(attachAspis($m,(3)));
if ( ((isset($m[0][(5)]) && Aspis_isset( $m [0][(5)]))))
 {return concat(concat(attachAspis($m,(1)),Aspis_call_user_func(attachAspis($shortcode_tags,$tag[0]),$attr,attachAspis($m,(5)),attachAspis($m,(2)))),attachAspis($m,(6)));
}else 
{{return concat(concat(attachAspis($m,(1)),Aspis_call_user_func(attachAspis($shortcode_tags,$tag[0]),$attr,array(NULL,false),attachAspis($m,(2)))),attachAspis($m,(6)));
}} }
function shortcode_parse_atts ( $text ) {
$atts = array(array(),false);
$pattern = array('/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/',false);
$text = Aspis_preg_replace(array("/[\x{00a0}\x{200b}]+/u",false),array(" ",false),$text);
if ( deAspis(Aspis_preg_match_all($pattern,$text,$match,array(PREG_SET_ORDER,false))))
 {foreach ( $match[0] as $m  )
{if ( (!((empty($m[0][(1)]) || Aspis_empty( $m [0][(1)])))))
 arrayAssign($atts[0],deAspis(registerTaint(Aspis_strtolower(attachAspis($m,(1))))),addTaint(Aspis_stripcslashes(attachAspis($m,(2)))));
elseif ( (!((empty($m[0][(3)]) || Aspis_empty( $m [0][(3)])))))
 arrayAssign($atts[0],deAspis(registerTaint(Aspis_strtolower(attachAspis($m,(3))))),addTaint(Aspis_stripcslashes(attachAspis($m,(4)))));
elseif ( (!((empty($m[0][(5)]) || Aspis_empty( $m [0][(5)])))))
 arrayAssign($atts[0],deAspis(registerTaint(Aspis_strtolower(attachAspis($m,(5))))),addTaint(Aspis_stripcslashes(attachAspis($m,(6)))));
elseif ( (((isset($m[0][(7)]) && Aspis_isset( $m [0][(7)]))) and strlen(deAspis(attachAspis($m,(7))))))
 arrayAssignAdd($atts[0][],addTaint(Aspis_stripcslashes(attachAspis($m,(7)))));
elseif ( ((isset($m[0][(8)]) && Aspis_isset( $m [0][(8)]))))
 arrayAssignAdd($atts[0][],addTaint(Aspis_stripcslashes(attachAspis($m,(8)))));
}}else 
{{$atts = Aspis_ltrim($text);
}}return $atts;
 }
function shortcode_atts ( $pairs,$atts ) {
$atts = array_cast($atts);
$out = array(array(),false);
foreach ( $pairs[0] as $name =>$default )
{restoreTaint($name,$default);
{if ( array_key_exists(deAspisRC($name),deAspisRC($atts)))
 arrayAssign($out[0],deAspis(registerTaint($name)),addTaint(attachAspis($atts,$name[0])));
else 
{arrayAssign($out[0],deAspis(registerTaint($name)),addTaint($default));
}}}return $out;
 }
function strip_shortcodes ( $content ) {
global $shortcode_tags;
if ( (((empty($shortcode_tags) || Aspis_empty( $shortcode_tags))) || (!(is_array($shortcode_tags[0])))))
 return $content;
$pattern = get_shortcode_regex();
return Aspis_preg_replace(concat2(concat1('/',$pattern),'/s'),array('$1$6',false),$content);
 }
add_filter(array('the_content',false),array('do_shortcode',false),array(11,false));
;
