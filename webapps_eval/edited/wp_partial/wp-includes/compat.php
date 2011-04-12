<?php require_once('AspisMain.php'); ?><?php
if ( !function_exists('http_build_query'))
 {function http_build_query ( $data,$prefix = null,$sep = null ) {
{$AspisRetTemp = _http_build_query($data,$prefix,$sep);
return $AspisRetTemp;
} }
}function _http_build_query ( $data,$prefix = null,$sep = null,$key = '',$urlencode = true ) {
$ret = array();
foreach ( (array)$data as $k =>$v )
{if ( $urlencode)
 $k = urlencode($k);
if ( is_int($k) && $prefix != null)
 $k = $prefix . $k;
if ( !empty($key))
 $k = $key . '%5B' . $k . '%5D';
if ( $v === NULL)
 continue ;
elseif ( $v === FALSE)
 $v = '0';
if ( is_array($v) || is_object($v))
 array_push($ret,_http_build_query($v,'',$sep,$k,$urlencode));
elseif ( $urlencode)
 array_push($ret,$k . '=' . urlencode($v));
else 
{array_push($ret,$k . '=' . $v);
}}if ( NULL === $sep)
 $sep = ini_get('arg_separator.output');
{$AspisRetTemp = implode($sep,$ret);
return $AspisRetTemp;
} }
if ( !function_exists('_'))
 {function _ ( $string ) {
{$AspisRetTemp = $string;
return $AspisRetTemp;
} }
}if ( !function_exists('stripos'))
 {function stripos ( $haystack,$needle,$offset = 0 ) {
{$AspisRetTemp = strpos(strtolower($haystack),strtolower($needle),$offset);
return $AspisRetTemp;
} }
}if ( !function_exists('hash_hmac'))
 {function hash_hmac ( $algo,$data,$key,$raw_output = false ) {
{$AspisRetTemp = _hash_hmac($algo,$data,$key,$raw_output);
return $AspisRetTemp;
} }
}function _hash_hmac ( $algo,$data,$key,$raw_output = false ) {
$packs = array('md5' => 'H32','sha1' => 'H40');
if ( !isset($packs[$algo]))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$pack = $packs[$algo];
if ( strlen($key) > 64)
 $key = pack($pack,AspisUntaintedDynamicCall($algo,$key));
$key = str_pad($key,64,chr(0));
$ipad = (substr($key,0,64) ^ str_repeat(chr(0x36),64));
$opad = (substr($key,0,64) ^ str_repeat(chr(0x5C),64));
$hmac = AspisUntaintedDynamicCall($algo,$opad . pack($pack,AspisUntaintedDynamicCall($algo,$ipad . $data)));
if ( $raw_output)
 {$AspisRetTemp = pack($pack,$hmac);
return $AspisRetTemp;
}{$AspisRetTemp = $hmac;
return $AspisRetTemp;
} }
if ( !function_exists('mb_substr'))
 {function mb_substr ( $str,$start,$length = null,$encoding = null ) {
{$AspisRetTemp = _mb_substr($str,$start,$length,$encoding);
return $AspisRetTemp;
} }
}function _mb_substr ( $str,$start,$length = null,$encoding = null ) {
$charset = get_option('blog_charset');
if ( !in_array($charset,array('utf8','utf-8','UTF8','UTF-8')))
 {{$AspisRetTemp = is_null($length) ? substr($str,$start) : substr($str,$start,$length);
return $AspisRetTemp;
}}preg_match_all('/./us',$str,$match);
$chars = is_null($length) ? array_slice($match[0],$start) : array_slice($match[0],$start,$length);
{$AspisRetTemp = implode('',$chars);
return $AspisRetTemp;
} }
if ( !function_exists('htmlspecialchars_decode'))
 {function htmlspecialchars_decode ( $string,$quote_style = ENT_COMPAT ) {
if ( !is_scalar($string))
 {trigger_error('htmlspecialchars_decode() expects parameter 1 to be string, ' . gettype($string) . ' given',E_USER_WARNING);
{return ;
}}if ( !is_int($quote_style) && $quote_style !== null)
 {trigger_error('htmlspecialchars_decode() expects parameter 2 to be integer, ' . gettype($quote_style) . ' given',E_USER_WARNING);
{return ;
}}{$AspisRetTemp = wp_specialchars_decode($string,$quote_style);
return $AspisRetTemp;
} }
}if ( !function_exists('json_encode'))
 {function json_encode ( $string ) {
{global $wp_json;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_json,"\$wp_json",$AspisChangesCache);
}if ( !is_a($wp_json,'Services_JSON'))
 {require_once ('class-json.php');
$wp_json = new Services_JSON();
}{$AspisRetTemp = $wp_json->encodeUnsafe($string);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_json",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_json",$AspisChangesCache);
 }
}if ( !function_exists('json_decode'))
 {function json_decode ( $string ) {
{global $wp_json;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_json,"\$wp_json",$AspisChangesCache);
}if ( !is_a($wp_json,'Services_JSON'))
 {require_once ('class-json.php');
$wp_json = new Services_JSON();
}{$AspisRetTemp = $wp_json->decode($string);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_json",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_json",$AspisChangesCache);
 }
}function pathinfo52 ( $path ) {
$parts = pathinfo($path);
if ( !isset($parts['filename']))
 {$parts['filename'] = substr($parts['basename'],0,strrpos($parts['basename'],'.'));
if ( empty($parts['filename']))
 $parts['filename'] = $parts['basename'];
}{$AspisRetTemp = $parts;
return $AspisRetTemp;
} }
