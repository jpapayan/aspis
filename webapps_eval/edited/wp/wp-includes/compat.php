<?php require_once('AspisMain.php'); ?><?php
if ( (!(function_exists(('http_build_query')))))
 {function http_build_query ( $data,$prefix = array(null,false),$sep = array(null,false) ) {
return _http_build_query($data,$prefix,$sep);
 }
}function _http_build_query ( $data,$prefix = array(null,false),$sep = array(null,false),$key = array('',false),$urlencode = array(true,false) ) {
$ret = array(array(),false);
foreach ( deAspis(array_cast($data)) as $k =>$v )
{restoreTaint($k,$v);
{if ( $urlencode[0])
 $k = Aspis_urlencode($k);
if ( (is_int(deAspisRC($k)) && ($prefix[0] != null)))
 $k = concat($prefix,$k);
if ( (!((empty($key) || Aspis_empty( $key)))))
 $k = concat2(concat(concat2($key,'%5B'),$k),'%5D');
if ( ($v[0] === NULL))
 continue ;
elseif ( ($v[0] === FALSE))
 $v = array('0',false);
if ( (is_array($v[0]) || is_object($v[0])))
 Aspis_array_push($ret,_http_build_query($v,array('',false),$sep,$k,$urlencode));
elseif ( $urlencode[0])
 Aspis_array_push($ret,concat(concat2($k,'='),Aspis_urlencode($v)));
else 
{Aspis_array_push($ret,concat(concat2($k,'='),$v));
}}}if ( (NULL === $sep[0]))
 $sep = array(ini_get('arg_separator.output'),false);
return Aspis_implode($sep,$ret);
 }
if ( (!(function_exists(('_')))))
 {function _ ( $string ) {
return $string;
 }
}if ( (!(function_exists(('stripos')))))
 {function stripos ( $haystack,$needle,$offset = array(0,false) ) {
return attAspis(strpos(deAspis(Aspis_strtolower($haystack)),deAspisRC(Aspis_strtolower($needle)),$offset[0]));
 }
}if ( (!(function_exists(('hash_hmac')))))
 {function hash_hmac ( $algo,$data,$key,$raw_output = array(false,false) ) {
return _hash_hmac($algo,$data,$key,$raw_output);
 }
}function _hash_hmac ( $algo,$data,$key,$raw_output = array(false,false) ) {
$packs = array(array('md5' => array('H32',false,false),'sha1' => array('H40',false,false)),false);
if ( (!((isset($packs[0][$algo[0]]) && Aspis_isset( $packs [0][$algo[0]])))))
 return array(false,false);
$pack = attachAspis($packs,$algo[0]);
if ( (strlen($key[0]) > (64)))
 $key = attAspis(pack($pack[0],deAspisRC(AspisDynamicCall($algo,$key))));
$key = Aspis_str_pad($key,array(64,false),attAspis(chr((0))));
$ipad = (array(deAspis(Aspis_substr($key,array(0,false),array(64,false))) ^ deAspis(Aspis_str_repeat(attAspis(chr((0x36))),array(64,false))),false));
$opad = (array(deAspis(Aspis_substr($key,array(0,false),array(64,false))) ^ deAspis(Aspis_str_repeat(attAspis(chr((0x5C))),array(64,false))),false));
$hmac = AspisDynamicCall($algo,concat($opad,attAspis(pack($pack[0],deAspisRC(AspisDynamicCall($algo,concat($ipad,$data)))))));
if ( $raw_output[0])
 return attAspis(pack($pack[0],deAspisRC($hmac)));
return $hmac;
 }
if ( (!(function_exists(('mb_substr')))))
 {function mb_substr ( $str,$start,$length = array(null,false),$encoding = array(null,false) ) {
return _mb_substr($str,$start,$length,$encoding);
 }
}function _mb_substr ( $str,$start,$length = array(null,false),$encoding = array(null,false) ) {
$charset = get_option(array('blog_charset',false));
if ( (denot_boolean(Aspis_in_array($charset,array(array(array('utf8',false),array('utf-8',false),array('UTF8',false),array('UTF-8',false)),false)))))
 {return is_null(deAspisRC($length)) ? Aspis_substr($str,$start) : Aspis_substr($str,$start,$length);
}Aspis_preg_match_all(array('/./us',false),$str,$match);
$chars = is_null(deAspisRC($length)) ? Aspis_array_slice(attachAspis($match,(0)),$start) : Aspis_array_slice(attachAspis($match,(0)),$start,$length);
return Aspis_implode(array('',false),$chars);
 }
if ( (!(function_exists(('htmlspecialchars_decode')))))
 {function htmlspecialchars_decode ( $string,$quote_style = array(ENT_COMPAT,false) ) {
if ( (!(is_scalar(deAspisRC($string)))))
 {trigger_error((deconcat2(concat1('htmlspecialchars_decode() expects parameter 1 to be string, ',attAspis(gettype(deAspisRC($string)))),' given')),E_USER_WARNING);
return ;
}if ( ((!(is_int(deAspisRC($quote_style)))) && ($quote_style[0] !== null)))
 {trigger_error((deconcat2(concat1('htmlspecialchars_decode() expects parameter 2 to be integer, ',attAspis(gettype(deAspisRC($quote_style)))),' given')),E_USER_WARNING);
return ;
}return wp_specialchars_decode($string,$quote_style);
 }
}if ( (!(function_exists(('json_encode')))))
 {function json_encode ( $string ) {
global $wp_json;
if ( (!(is_a(deAspisRC($wp_json),('Services_JSON')))))
 {require_once ('class-json.php');
$wp_json = array(new Services_JSON(),false);
}return $wp_json[0]->encodeUnsafe($string);
 }
}if ( (!(function_exists(('json_decode')))))
 {function json_decode ( $string ) {
global $wp_json;
if ( (!(is_a(deAspisRC($wp_json),('Services_JSON')))))
 {require_once ('class-json.php');
$wp_json = array(new Services_JSON(),false);
}return $wp_json[0]->decode($string);
 }
}function pathinfo52 ( $path ) {
$parts = Aspis_pathinfo($path);
if ( (!((isset($parts[0][('filename')]) && Aspis_isset( $parts [0][('filename')])))))
 {arrayAssign($parts[0],deAspis(registerTaint(array('filename',false))),addTaint(Aspis_substr($parts[0]['basename'],array(0,false),attAspis(strrpos(deAspis($parts[0]['basename']),('.'))))));
if ( ((empty($parts[0][('filename')]) || Aspis_empty( $parts [0][('filename')]))))
 arrayAssign($parts[0],deAspis(registerTaint(array('filename',false))),addTaint($parts[0]['basename']));
}return $parts;
 }
