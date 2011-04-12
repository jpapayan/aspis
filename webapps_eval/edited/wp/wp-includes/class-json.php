<?php require_once('AspisMain.php'); ?><?php
define(('SERVICES_JSON_SLICE'),1);
define(('SERVICES_JSON_IN_STR'),2);
define(('SERVICES_JSON_IN_ARR'),3);
define(('SERVICES_JSON_IN_OBJ'),4);
define(('SERVICES_JSON_IN_CMT'),5);
define(('SERVICES_JSON_LOOSE_TYPE'),16);
define(('SERVICES_JSON_SUPPRESS_ERRORS'),32);
class Services_JSON{function Services_JSON ( $use = array(0,false) ) {
{$this->use = $use;
} }
function utf162utf8 ( $utf16 ) {
{if ( function_exists(('mb_convert_encoding')))
 {return Aspis_mb_convert_encoding($utf16,array('UTF-8',false),array('UTF-16',false));
}$bytes = array((ord(deAspis(attachAspis($utf16,(0)))) << (8)) | ord(deAspis(attachAspis($utf16,(1)))),false);
switch ( true ) {
case (((0x7F) & $bytes[0]) == $bytes[0]):return attAspis(chr(((0x7F) & $bytes[0])));
case (((0x07FF) & $bytes[0]) == $bytes[0]):return concat(attAspis(chr(((0xC0) | (($bytes[0] >> (6)) & (0x1F))))),attAspis(chr(((0x80) | ($bytes[0] & (0x3F))))));
case (((0xFFFF) & $bytes[0]) == $bytes[0]):return concat(concat(attAspis(chr(((0xE0) | (($bytes[0] >> (12)) & (0x0F))))),attAspis(chr(((0x80) | (($bytes[0] >> (6)) & (0x3F)))))),attAspis(chr(((0x80) | ($bytes[0] & (0x3F))))));
 }
return array('',false);
} }
function utf82utf16 ( $utf8 ) {
{if ( function_exists(('mb_convert_encoding')))
 {return Aspis_mb_convert_encoding($utf8,array('UTF-16',false),array('UTF-8',false));
}switch ( strlen($utf8[0]) ) {
case (1):return $utf8;
case (2):return concat(attAspis(chr(((0x07) & (ord(deAspis(attachAspis($utf8,(0)))) >> (2))))),attAspis(chr((((0xC0) & (ord(deAspis(attachAspis($utf8,(0)))) << (6))) | ((0x3F) & ord(deAspis(attachAspis($utf8,(1)))))))));
case (3):return concat(attAspis(chr((((0xF0) & (ord(deAspis(attachAspis($utf8,(0)))) << (4))) | ((0x0F) & (ord(deAspis(attachAspis($utf8,(1)))) >> (2)))))),attAspis(chr((((0xC0) & (ord(deAspis(attachAspis($utf8,(1)))) << (6))) | ((0x7F) & ord(deAspis(attachAspis($utf8,(2)))))))));
 }
return array('',false);
} }
function encode ( $var ) {
{header(('Content-type: application/json'));
return $this->_encode($var);
} }
function encodeUnsafe ( $var ) {
{return $this->_encode($var);
} }
function _encode ( $var ) {
{switch ( gettype(deAspisRC($var)) ) {
case ('boolean'):return $var[0] ? array('true',false) : array('false',false);
case ('NULL'):return array('null',false);
case ('integer'):return int_cast($var);
case ('double'):case ('float'):return float_cast($var);
case ('string'):$ascii = array('',false);
$strlen_var = attAspis(strlen($var[0]));
for ( $c = array(0,false) ; ($c[0] < $strlen_var[0]) ; preincr($c) )
{$ord_var_c = attAspis(ord(deAspis(attachAspis($var,$c[0]))));
switch ( true ) {
case ($ord_var_c[0] == (0x08)):$ascii = concat2($ascii,'\b');
break ;
case ($ord_var_c[0] == (0x09)):$ascii = concat2($ascii,'\t');
break ;
case ($ord_var_c[0] == (0x0A)):$ascii = concat2($ascii,'\n');
break ;
case ($ord_var_c[0] == (0x0C)):$ascii = concat2($ascii,'\f');
break ;
case ($ord_var_c[0] == (0x0D)):$ascii = concat2($ascii,'\r');
break ;
case ($ord_var_c[0] == (0x22)):case ($ord_var_c[0] == (0x2F)):case ($ord_var_c[0] == (0x5C)):$ascii = concat($ascii,concat1('\\',attachAspis($var,$c[0])));
break ;
case (($ord_var_c[0] >= (0x20)) && ($ord_var_c[0] <= (0x7F))):$ascii = concat($ascii,attachAspis($var,$c[0]));
break ;
case (($ord_var_c[0] & (0xE0)) == (0xC0)):if ( (($c[0] + (1)) >= $strlen_var[0]))
 {$c = array((1) + $c[0],false);
$ascii = concat2($ascii,'?');
break ;
}$char = attAspis(pack(('C*'),deAspisRC($ord_var_c),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (1)))))))));
$c = array((1) + $c[0],false);
$utf16 = $this->utf82utf16($char);
$ascii = concat($ascii,Aspis_sprintf(array('\u%04s',false),Aspis_bin2hex($utf16)));
break ;
case (($ord_var_c[0] & (0xF0)) == (0xE0)):if ( (($c[0] + (2)) >= $strlen_var[0]))
 {$c = array((2) + $c[0],false);
$ascii = concat2($ascii,'?');
break ;
}$char = attAspis(pack(('C*'),deAspisRC($ord_var_c),deAspisRC(@attAspis(ord(deAspis(attachAspis($var,($c[0] + (1))))))),deAspisRC(@attAspis(ord(deAspis(attachAspis($var,($c[0] + (2)))))))));
$c = array((2) + $c[0],false);
$utf16 = $this->utf82utf16($char);
$ascii = concat($ascii,Aspis_sprintf(array('\u%04s',false),Aspis_bin2hex($utf16)));
break ;
case (($ord_var_c[0] & (0xF8)) == (0xF0)):if ( (($c[0] + (3)) >= $strlen_var[0]))
 {$c = array((3) + $c[0],false);
$ascii = concat2($ascii,'?');
break ;
}$char = attAspis(pack(('C*'),deAspisRC($ord_var_c),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (1))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (2))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (3)))))))));
$c = array((3) + $c[0],false);
$utf16 = $this->utf82utf16($char);
$ascii = concat($ascii,Aspis_sprintf(array('\u%04s',false),Aspis_bin2hex($utf16)));
break ;
case (($ord_var_c[0] & (0xFC)) == (0xF8)):if ( (($c[0] + (4)) >= $strlen_var[0]))
 {$c = array((4) + $c[0],false);
$ascii = concat2($ascii,'?');
break ;
}$char = attAspis(pack(('C*'),deAspisRC($ord_var_c),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (1))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (2))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (3))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (4)))))))));
$c = array((4) + $c[0],false);
$utf16 = $this->utf82utf16($char);
$ascii = concat($ascii,Aspis_sprintf(array('\u%04s',false),Aspis_bin2hex($utf16)));
break ;
case (($ord_var_c[0] & (0xFE)) == (0xFC)):if ( (($c[0] + (5)) >= $strlen_var[0]))
 {$c = array((5) + $c[0],false);
$ascii = concat2($ascii,'?');
break ;
}$char = attAspis(pack(('C*'),deAspisRC($ord_var_c),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (1))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (2))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (3))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (4))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($var,($c[0] + (5)))))))));
$c = array((5) + $c[0],false);
$utf16 = $this->utf82utf16($char);
$ascii = concat($ascii,Aspis_sprintf(array('\u%04s',false),Aspis_bin2hex($utf16)));
break ;
 }
}return concat2(concat1('"',$ascii),'"');
case ('array'):if ( ((is_array($var[0]) && count($var[0])) && (deAspis(attAspisRC(array_keys(deAspisRC($var)))) !== deAspis(attAspisRC(range(0,deAspisRC(array((sizeof(deAspisRC($var))) - (1),false))))))))
 {$properties = attAspisRC(array_map(AspisInternalCallback(array(array(array($this,false),array('name_value',false)),false)),deAspisRC(attAspisRC(array_keys(deAspisRC($var)))),deAspisRC(Aspis_array_values($var))));
foreach ( $properties[0] as $property  )
{if ( deAspis(Services_JSON::isError($property)))
 {return $property;
}}return concat2(concat1('{',Aspis_join(array(',',false),$properties)),'}');
}$elements = attAspisRC(array_map(AspisInternalCallback(array(array(array($this,false),array('_encode',false)),false)),deAspisRC($var)));
foreach ( $elements[0] as $element  )
{if ( deAspis(Services_JSON::isError($element)))
 {return $element;
}}return concat2(concat1('[',Aspis_join(array(',',false),$elements)),']');
case ('object'):$vars = attAspis(get_object_vars(deAspisRC($var)));
$properties = attAspisRC(array_map(AspisInternalCallback(array(array(array($this,false),array('name_value',false)),false)),deAspisRC(attAspisRC(array_keys(deAspisRC($vars)))),deAspisRC(Aspis_array_values($vars))));
foreach ( $properties[0] as $property  )
{if ( deAspis(Services_JSON::isError($property)))
 {return $property;
}}return concat2(concat1('{',Aspis_join(array(',',false),$properties)),'}');
default :return ($this->use[0] & SERVICES_JSON_SUPPRESS_ERRORS) ? array('null',false) : array(new Services_JSON_Error(concat2(attAspis(gettype(deAspisRC($var)))," can not be encoded as JSON string")),false);
 }
} }
function name_value ( $name,$value ) {
{$encoded_value = $this->_encode($value);
if ( deAspis(Services_JSON::isError($encoded_value)))
 {return $encoded_value;
}return concat(concat2($this->_encode(Aspis_strval($name)),':'),$encoded_value);
} }
function reduce_string ( $str ) {
{$str = Aspis_preg_replace(array(array(array('#^\s*//(.+)$#m',false),array('#^\s*/\*(.+)\*/#Us',false),array('#/\*(.+)\*/\s*$#Us',false)),false),array('',false),$str);
return Aspis_trim($str);
} }
function decode ( $str ) {
{$str = $this->reduce_string($str);
switch ( deAspis(Aspis_strtolower($str)) ) {
case ('true'):return array(true,false);
case ('false'):return array(false,false);
case ('null'):return array(null,false);
default :$m = array(array(),false);
if ( is_numeric(deAspisRC($str)))
 {return (deAspis(float_cast($str)) == deAspis(int_cast($str))) ? int_cast($str) : float_cast($str);
}elseif ( (deAspis(Aspis_preg_match(array('/^("|\').*(\1)$/s',false),$str,$m)) && (deAspis(attachAspis($m,(1))) == deAspis(attachAspis($m,(2))))))
 {$delim = Aspis_substr($str,array(0,false),array(1,false));
$chrs = Aspis_substr($str,array(1,false),negate(array(1,false)));
$utf8 = array('',false);
$strlen_chrs = attAspis(strlen($chrs[0]));
for ( $c = array(0,false) ; ($c[0] < $strlen_chrs[0]) ; preincr($c) )
{$substr_chrs_c_2 = Aspis_substr($chrs,$c,array(2,false));
$ord_chrs_c = attAspis(ord(deAspis(attachAspis($chrs,$c[0]))));
switch ( true ) {
case ($substr_chrs_c_2[0] == ('\b')):$utf8 = concat($utf8,attAspis(chr((0x08))));
preincr($c);
break ;
case ($substr_chrs_c_2[0] == ('\t')):$utf8 = concat($utf8,attAspis(chr((0x09))));
preincr($c);
break ;
case ($substr_chrs_c_2[0] == ('\n')):$utf8 = concat($utf8,attAspis(chr((0x0A))));
preincr($c);
break ;
case ($substr_chrs_c_2[0] == ('\f')):$utf8 = concat($utf8,attAspis(chr((0x0C))));
preincr($c);
break ;
case ($substr_chrs_c_2[0] == ('\r')):$utf8 = concat($utf8,attAspis(chr((0x0D))));
preincr($c);
break ;
case ($substr_chrs_c_2[0] == ('\\"')):case ($substr_chrs_c_2[0] == ('\\\'')):case ($substr_chrs_c_2[0] == ('\\\\')):case ($substr_chrs_c_2[0] == ('\\/')):if ( ((($delim[0] == ('"')) && ($substr_chrs_c_2[0] != ('\\\''))) || (($delim[0] == ("'")) && ($substr_chrs_c_2[0] != ('\\"')))))
 {$utf8 = concat($utf8,attachAspis($chrs,deAspis(preincr($c))));
}break ;
case deAspis(Aspis_preg_match(array('/\\\u[0-9A-F]{4}/i',false),Aspis_substr($chrs,$c,array(6,false)))):$utf16 = concat(attAspis(chr(deAspis(Aspis_hexdec(Aspis_substr($chrs,(array($c[0] + (2),false)),array(2,false)))))),attAspis(chr(deAspis(Aspis_hexdec(Aspis_substr($chrs,(array($c[0] + (4),false)),array(2,false)))))));
$utf8 = concat($utf8,$this->utf162utf8($utf16));
$c = array((5) + $c[0],false);
break ;
case (($ord_chrs_c[0] >= (0x20)) && ($ord_chrs_c[0] <= (0x7F))):$utf8 = concat($utf8,attachAspis($chrs,$c[0]));
break ;
case (($ord_chrs_c[0] & (0xE0)) == (0xC0)):$utf8 = concat($utf8,Aspis_substr($chrs,$c,array(2,false)));
preincr($c);
break ;
case (($ord_chrs_c[0] & (0xF0)) == (0xE0)):$utf8 = concat($utf8,Aspis_substr($chrs,$c,array(3,false)));
$c = array((2) + $c[0],false);
break ;
case (($ord_chrs_c[0] & (0xF8)) == (0xF0)):$utf8 = concat($utf8,Aspis_substr($chrs,$c,array(4,false)));
$c = array((3) + $c[0],false);
break ;
case (($ord_chrs_c[0] & (0xFC)) == (0xF8)):$utf8 = concat($utf8,Aspis_substr($chrs,$c,array(5,false)));
$c = array((4) + $c[0],false);
break ;
case (($ord_chrs_c[0] & (0xFE)) == (0xFC)):$utf8 = concat($utf8,Aspis_substr($chrs,$c,array(6,false)));
$c = array((5) + $c[0],false);
break ;
 }
}return $utf8;
}elseif ( (deAspis(Aspis_preg_match(array('/^\[.*\]$/s',false),$str)) || deAspis(Aspis_preg_match(array('/^\{.*\}$/s',false),$str))))
 {if ( (deAspis(attachAspis($str,(0))) == ('[')))
 {$stk = array(array(array(SERVICES_JSON_IN_ARR,false)),false);
$arr = array(array(),false);
}else 
{{if ( ($this->use[0] & SERVICES_JSON_LOOSE_TYPE))
 {$stk = array(array(array(SERVICES_JSON_IN_OBJ,false)),false);
$obj = array(array(),false);
}else 
{{$stk = array(array(array(SERVICES_JSON_IN_OBJ,false)),false);
$obj = array(new stdClass(),false);
}}}}Aspis_array_push($stk,array(array('what' => array(SERVICES_JSON_SLICE,false,false),'where' => array(0,false,false),'delim' => array(false,false,false)),false));
$chrs = Aspis_substr($str,array(1,false),negate(array(1,false)));
$chrs = $this->reduce_string($chrs);
if ( ($chrs[0] == ('')))
 {if ( (deAspis(Aspis_reset($stk)) == SERVICES_JSON_IN_ARR))
 {return $arr;
}else 
{{return $obj;
}}}$strlen_chrs = attAspis(strlen($chrs[0]));
for ( $c = array(0,false) ; ($c[0] <= $strlen_chrs[0]) ; preincr($c) )
{$top = Aspis_end($stk);
$substr_chrs_c_2 = Aspis_substr($chrs,$c,array(2,false));
if ( (($c[0] == $strlen_chrs[0]) || ((deAspis(attachAspis($chrs,$c[0])) == (',')) && (deAspis($top[0]['what']) == SERVICES_JSON_SLICE))))
 {$slice = Aspis_substr($chrs,$top[0]['where'],(array($c[0] - deAspis($top[0]['where']),false)));
Aspis_array_push($stk,array(array('what' => array(SERVICES_JSON_SLICE,false,false),deregisterTaint(array('where',false)) => addTaint((array($c[0] + (1),false))),'delim' => array(false,false,false)),false));
if ( (deAspis(Aspis_reset($stk)) == SERVICES_JSON_IN_ARR))
 {Aspis_array_push($arr,$this->decode($slice));
}elseif ( (deAspis(Aspis_reset($stk)) == SERVICES_JSON_IN_OBJ))
 {$parts = array(array(),false);
if ( deAspis(Aspis_preg_match(array('/^\s*(["\'].*[^\\\]["\'])\s*:\s*(\S.*),?$/Uis',false),$slice,$parts)))
 {$key = $this->decode(attachAspis($parts,(1)));
$val = $this->decode(attachAspis($parts,(2)));
if ( ($this->use[0] & SERVICES_JSON_LOOSE_TYPE))
 {arrayAssign($obj[0],deAspis(registerTaint($key)),addTaint($val));
}else 
{{$obj[0]->$key[0] = $val;
}}}elseif ( deAspis(Aspis_preg_match(array('/^\s*(\w+)\s*:\s*(\S.*),?$/Uis',false),$slice,$parts)))
 {$key = attachAspis($parts,(1));
$val = $this->decode(attachAspis($parts,(2)));
if ( ($this->use[0] & SERVICES_JSON_LOOSE_TYPE))
 {arrayAssign($obj[0],deAspis(registerTaint($key)),addTaint($val));
}else 
{{$obj[0]->$key[0] = $val;
}}}}}elseif ( (((deAspis(attachAspis($chrs,$c[0])) == ('"')) || (deAspis(attachAspis($chrs,$c[0])) == ("'"))) && (deAspis($top[0]['what']) != SERVICES_JSON_IN_STR)))
 {Aspis_array_push($stk,array(array('what' => array(SERVICES_JSON_IN_STR,false,false),deregisterTaint(array('where',false)) => addTaint($c),deregisterTaint(array('delim',false)) => addTaint(attachAspis($chrs,$c[0]))),false));
}elseif ( (((deAspis(attachAspis($chrs,$c[0])) == deAspis($top[0]['delim'])) && (deAspis($top[0]['what']) == SERVICES_JSON_IN_STR)) && (((strlen(deAspis(Aspis_substr($chrs,array(0,false),$c))) - strlen(deAspis(Aspis_rtrim(Aspis_substr($chrs,array(0,false),$c),array('\\',false))))) % (2)) != (1))))
 {Aspis_array_pop($stk);
}elseif ( ((deAspis(attachAspis($chrs,$c[0])) == ('[')) && deAspis(Aspis_in_array($top[0]['what'],array(array(array(SERVICES_JSON_SLICE,false),array(SERVICES_JSON_IN_ARR,false),array(SERVICES_JSON_IN_OBJ,false)),false)))))
 {Aspis_array_push($stk,array(array('what' => array(SERVICES_JSON_IN_ARR,false,false),deregisterTaint(array('where',false)) => addTaint($c),'delim' => array(false,false,false)),false));
}elseif ( ((deAspis(attachAspis($chrs,$c[0])) == (']')) && (deAspis($top[0]['what']) == SERVICES_JSON_IN_ARR)))
 {Aspis_array_pop($stk);
}elseif ( ((deAspis(attachAspis($chrs,$c[0])) == ('{')) && deAspis(Aspis_in_array($top[0]['what'],array(array(array(SERVICES_JSON_SLICE,false),array(SERVICES_JSON_IN_ARR,false),array(SERVICES_JSON_IN_OBJ,false)),false)))))
 {Aspis_array_push($stk,array(array('what' => array(SERVICES_JSON_IN_OBJ,false,false),deregisterTaint(array('where',false)) => addTaint($c),'delim' => array(false,false,false)),false));
}elseif ( ((deAspis(attachAspis($chrs,$c[0])) == ('}')) && (deAspis($top[0]['what']) == SERVICES_JSON_IN_OBJ)))
 {Aspis_array_pop($stk);
}elseif ( (($substr_chrs_c_2[0] == ('/*')) && deAspis(Aspis_in_array($top[0]['what'],array(array(array(SERVICES_JSON_SLICE,false),array(SERVICES_JSON_IN_ARR,false),array(SERVICES_JSON_IN_OBJ,false)),false)))))
 {Aspis_array_push($stk,array(array('what' => array(SERVICES_JSON_IN_CMT,false,false),deregisterTaint(array('where',false)) => addTaint($c),'delim' => array(false,false,false)),false));
postincr($c);
}elseif ( (($substr_chrs_c_2[0] == ('*/')) && (deAspis($top[0]['what']) == SERVICES_JSON_IN_CMT)))
 {Aspis_array_pop($stk);
postincr($c);
for ( $i = $top[0]['where'] ; ($i[0] <= $c[0]) ; preincr($i) )
$chrs = Aspis_substr_replace($chrs,array(' ',false),$i,array(1,false));
}}if ( (deAspis(Aspis_reset($stk)) == SERVICES_JSON_IN_ARR))
 {return $arr;
}elseif ( (deAspis(Aspis_reset($stk)) == SERVICES_JSON_IN_OBJ))
 {return $obj;
}} }
} }
function isError ( $data,$code = array(null,false) ) {
{if ( class_exists(('pear')))
 {return PEAR::isError($data,$code);
}elseif ( (is_object($data[0]) && ((get_class(deAspisRC($data)) == ('services_json_error')) || is_subclass_of(deAspisRC($data),('services_json_error')))))
 {return array(true,false);
}return array(false,false);
} }
}if ( class_exists(('PEAR_Error')))
 {class Services_JSON_Error extends PEAR_Error{function Services_JSON_Error ( $message = array('unknown error',false),$code = array(null,false),$mode = array(null,false),$options = array(null,false),$userinfo = array(null,false) ) {
{parent::PEAR_Error($message,$code,$mode,$options,$userinfo);
} }
}}else 
{{class Services_JSON_Error{function Services_JSON_Error ( $message = array('unknown error',false),$code = array(null,false),$mode = array(null,false),$options = array(null,false),$userinfo = array(null,false) ) {
{} }
}}}