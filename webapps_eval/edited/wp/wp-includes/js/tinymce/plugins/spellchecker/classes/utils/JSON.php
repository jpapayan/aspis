<?php require_once('AspisMain.php'); ?><?php
define(('JSON_BOOL'),1);
define(('JSON_INT'),2);
define(('JSON_STR'),3);
define(('JSON_FLOAT'),4);
define(('JSON_NULL'),5);
define(('JSON_START_OBJ'),6);
define(('JSON_END_OBJ'),7);
define(('JSON_START_ARRAY'),8);
define(('JSON_END_ARRAY'),9);
define(('JSON_KEY'),10);
define(('JSON_SKIP'),11);
define(('JSON_IN_ARRAY'),30);
define(('JSON_IN_OBJECT'),40);
define(('JSON_IN_BETWEEN'),50);
class Moxiecode_JSONReader{var $_data,$_len,$_pos;
var $_value,$_token;
var $_location,$_lastLocations;
var $_needProp;
function Moxiecode_JSONReader ( $data ) {
{$this->_data = $data;
$this->_len = attAspis(strlen($data[0]));
$this->_pos = negate(array(1,false));
$this->_location = array(JSON_IN_BETWEEN,false);
$this->_lastLocations = array(array(),false);
$this->_needProp = array(false,false);
} }
function getToken (  ) {
{return $this->_token;
} }
function getLocation (  ) {
{return $this->_location;
} }
function getTokenName (  ) {
{switch ( $this->_token[0] ) {
case JSON_BOOL:return array('JSON_BOOL',false);
case JSON_INT:return array('JSON_INT',false);
case JSON_STR:return array('JSON_STR',false);
case JSON_FLOAT:return array('JSON_FLOAT',false);
case JSON_NULL:return array('JSON_NULL',false);
case JSON_START_OBJ:return array('JSON_START_OBJ',false);
case JSON_END_OBJ:return array('JSON_END_OBJ',false);
case JSON_START_ARRAY:return array('JSON_START_ARRAY',false);
case JSON_END_ARRAY:return array('JSON_END_ARRAY',false);
case JSON_KEY:return array('JSON_KEY',false);
 }
return array('UNKNOWN',false);
} }
function getValue (  ) {
{return $this->_value;
} }
function readToken (  ) {
{$chr = $this->read();
if ( ($chr[0] != null))
 {switch ( $chr[0] ) {
case ('['):arrayAssignAdd($this->_lastLocation[0][],addTaint($this->_location));
$this->_location = array(JSON_IN_ARRAY,false);
$this->_token = array(JSON_START_ARRAY,false);
$this->_value = array(null,false);
$this->readAway();
return array(true,false);
case (']'):$this->_location = Aspis_array_pop($this->_lastLocation);
$this->_token = array(JSON_END_ARRAY,false);
$this->_value = array(null,false);
$this->readAway();
if ( ($this->_location[0] == JSON_IN_OBJECT))
 $this->_needProp = array(true,false);
return array(true,false);
case ('{'):arrayAssignAdd($this->_lastLocation[0][],addTaint($this->_location));
$this->_location = array(JSON_IN_OBJECT,false);
$this->_needProp = array(true,false);
$this->_token = array(JSON_START_OBJ,false);
$this->_value = array(null,false);
$this->readAway();
return array(true,false);
case ('}'):$this->_location = Aspis_array_pop($this->_lastLocation);
$this->_token = array(JSON_END_OBJ,false);
$this->_value = array(null,false);
$this->readAway();
if ( ($this->_location[0] == JSON_IN_OBJECT))
 $this->_needProp = array(true,false);
return array(true,false);
case ('"'):case ('\''):return $this->_readString($chr);
case ('n'):return $this->_readNull();
case ('t'):case ('f'):return $this->_readBool($chr);
default :if ( ((is_numeric(deAspisRC($chr)) || ($chr[0] == ('-'))) || ($chr[0] == ('.'))))
 return $this->_readNumber($chr);
return array(true,false);
 }
}return array(false,false);
} }
function _readBool ( $chr ) {
{$this->_token = array(JSON_BOOL,false);
$this->_value = array($chr[0] == ('t'),false);
if ( ($chr[0] == ('t')))
 $this->skip(array(3,false));
else 
{$this->skip(array(4,false));
}$this->readAway();
if ( (($this->_location[0] == JSON_IN_OBJECT) && (denot_boolean($this->_needProp))))
 $this->_needProp = array(true,false);
return array(true,false);
} }
function _readNull (  ) {
{$this->_token = array(JSON_NULL,false);
$this->_value = array(null,false);
$this->skip(array(3,false));
$this->readAway();
if ( (($this->_location[0] == JSON_IN_OBJECT) && (denot_boolean($this->_needProp))))
 $this->_needProp = array(true,false);
return array(true,false);
} }
function _readString ( $quote ) {
{$output = array("",false);
$this->_token = array(JSON_STR,false);
$endString = array(false,false);
while ( (deAspis(($chr = $this->peek())) != deAspis(negate(array(1,false)))) )
{switch ( $chr[0] ) {
case ('\\'):$this->read();
$chr = $this->read();
switch ( $chr[0] ) {
case ('t'):$output = concat2($output,"\t");
break ;
case ('b'):$output = concat2($output,"\b");
break ;
case ('f'):$output = concat2($output,"\f");
break ;
case ('r'):$output = concat2($output,"\r");
break ;
case ('n'):$output = concat2($output,"\n");
break ;
case ('u'):$output = concat($output,$this->_int2utf8(Aspis_hexdec($this->read(array(4,false)))));
break ;
default :$output = concat($output,$chr);
break ;
 }
break ;
case ('\''):case ('"'):if ( ($chr[0] == $quote[0]))
 $endString = array(true,false);
$chr = $this->read();
if ( (($chr[0] != deAspis(negate(array(1,false)))) && ($chr[0] != $quote[0])))
 $output = concat($output,$chr);
break ;
default :$output = concat($output,$this->read());
 }
if ( $endString[0])
 break ;
}$this->readAway();
$this->_value = $output;
if ( $this->_needProp[0])
 {$this->_token = array(JSON_KEY,false);
$this->_needProp = array(false,false);
return array(true,false);
}if ( (($this->_location[0] == JSON_IN_OBJECT) && (denot_boolean($this->_needProp))))
 $this->_needProp = array(true,false);
return array(true,false);
} }
function _int2utf8 ( $int ) {
{$int = Aspis_intval($int);
switch ( $int[0] ) {
case (0):return attAspis(chr((0)));
case ($int[0] & (0x7F)):return attAspis(chr($int[0]));
case ($int[0] & (0x7FF)):return concat(attAspis(chr(((0xC0) | (($int[0] >> (6)) & (0x1F))))),attAspis(chr(((0x80) | ($int[0] & (0x3F))))));
case ($int[0] & (0xFFFF)):return concat(concat(attAspis(chr(((0xE0) | (($int[0] >> (12)) & (0x0F))))),attAspis(chr(((0x80) | (($int[0] >> (6)) & (0x3F)))))),attAspis(chr(((0x80) | ($int[0] & (0x3F))))));
case ($int[0] & (0x1FFFFF)):return concat(concat(concat(attAspis(chr(((0xF0) | ($int[0] >> (18))))),attAspis(chr(((0x80) | (($int[0] >> (12)) & (0x3F)))))),attAspis(chr(((0x80) | (($int[0] >> (6)) & (0x3F)))))),attAspis(chr(((0x80) | ($int[0] & (0x3F))))));
 }
} }
function _readNumber ( $start ) {
{$value = array("",false);
$isFloat = array(false,false);
$this->_token = array(JSON_INT,false);
$value = concat($value,$start);
while ( (deAspis(($chr = $this->peek())) != deAspis(negate(array(1,false)))) )
{if ( ((is_numeric(deAspisRC($chr)) || ($chr[0] == ('-'))) || ($chr[0] == ('.'))))
 {if ( ($chr[0] == ('.')))
 $isFloat = array(true,false);
$value = concat($value,$this->read());
}else 
{break ;
}}$this->readAway();
if ( $isFloat[0])
 {$this->_token = array(JSON_FLOAT,false);
$this->_value = Aspis_floatval($value);
}else 
{$this->_value = Aspis_intval($value);
}if ( (($this->_location[0] == JSON_IN_OBJECT) && (denot_boolean($this->_needProp))))
 $this->_needProp = array(true,false);
return array(true,false);
} }
function readAway (  ) {
{while ( (deAspis(($chr = $this->peek())) != null) )
{if ( ((($chr[0] != (':')) && ($chr[0] != (','))) && ($chr[0] != (' '))))
 return ;
$this->read();
}} }
function read ( $len = array(1,false) ) {
{if ( ($this->_pos[0] < $this->_len[0]))
 {if ( ($len[0] > (1)))
 {$str = Aspis_substr($this->_data,array($this->_pos[0] + (1),false),$len);
$this->_pos = array($len[0] + $this->_pos [0],false);
return $str;
}else 
{return $this->_data[0][deAspis(preincr($this->_pos))];
}}return array(null,false);
} }
function skip ( $len ) {
{$this->_pos = array($len[0] + $this->_pos [0],false);
} }
function peek (  ) {
{if ( ($this->_pos[0] < $this->_len[0]))
 return $this->_data[0][($this->_pos[0] + (1))];
return array(null,false);
} }
}class Moxiecode_JSON{function Moxiecode_JSON (  ) {
{} }
function decode ( $input ) {
{$reader = array(new Moxiecode_JSONReader($input),false);
return $this->readValue($reader);
} }
function readValue ( &$reader ) {
{$this->data = array(array(),false);
$this->parents = array(array(),false);
$this->cur = &$this->data;
$key = array(null,false);
$loc = array(JSON_IN_ARRAY,false);
while ( deAspis($reader[0]->readToken()) )
{switch ( deAspis($reader[0]->getToken()) ) {
case JSON_STR:case JSON_INT:case JSON_BOOL:case JSON_FLOAT:case JSON_NULL:switch ( deAspis($reader[0]->getLocation()) ) {
case JSON_IN_OBJECT:arrayAssign($this->cur[0],deAspis(registerTaint($key)),addTaint($reader[0]->getValue()));
break ;
case JSON_IN_ARRAY:arrayAssignAdd($this->cur[0][],addTaint($reader[0]->getValue()));
break ;
default :return $reader[0]->getValue();
 }
break ;
case JSON_KEY:$key = $reader[0]->getValue();
break ;
case JSON_START_OBJ:case JSON_START_ARRAY:if ( ($loc[0] == JSON_IN_OBJECT))
 $this->addArray($key);
else 
{$this->addArray(array(null,false));
}$cur = &$obj;
$loc = $reader[0]->getLocation();
break ;
case JSON_END_OBJ:case JSON_END_ARRAY:$loc = $reader[0]->getLocation();
if ( (count($this->parents[0]) > (0)))
 {$this->cur = &$this->parents[0][(count($this->parents[0]) - (1))];
Aspis_array_pop($this->parents);
}break ;
 }
}return $this->data[0][(0)];
} }
function addArray ( $key ) {
{$this->parents[0][] = &addTaintR($this->cur);
$ar = array(array(),false);
if ( $key[0])
 $this->cur[0][deAspis(registerTaint($key))] = &addTaintR($ar);
else 
{$this->cur[0][] = &addTaintR($ar);
}$this->cur = &$ar;
} }
function getDelim ( $index,&$reader ) {
{switch ( deAspis($reader[0]->getLocation()) ) {
case JSON_IN_ARRAY:case JSON_IN_OBJECT:if ( ($index[0] > (0)))
 return array(",",false);
break ;
 }
return array("",false);
} }
function encode ( $input ) {
{switch ( gettype(deAspisRC($input)) ) {
case ('boolean'):return $input[0] ? array('true',false) : array('false',false);
case ('integer'):return int_cast($input);
case ('float'):case ('double'):return float_cast($input);
case ('NULL'):return array('null',false);
case ('string'):return $this->encodeString($input);
case ('array'):return $this->_encodeArray($input);
case ('object'):return $this->_encodeArray(attAspis(get_object_vars(deAspisRC($input))));
 }
return array('',false);
} }
function encodeString ( $input ) {
{if ( deAspis(Aspis_preg_match(array('/[^a-zA-Z0-9]/',false),$input)))
 {$output = array('',false);
for ( $i = array(0,false) ; ($i[0] < strlen($input[0])) ; postincr($i) )
{switch ( deAspis(attachAspis($input,$i[0])) ) {
case ("\b"):$output = concat2($output,"\\b");
break ;
case ("\t"):$output = concat2($output,"\\t");
break ;
case ("\f"):$output = concat2($output,"\\f");
break ;
case ("\r"):$output = concat2($output,"\\r");
break ;
case ("\n"):$output = concat2($output,"\\n");
break ;
case ('\\'):$output = concat2($output,"\\\\");
break ;
case ('\''):$output = concat2($output,"\\'");
break ;
case ('"'):$output = concat2($output,'\"');
break ;
default :$byte = attAspis(ord(deAspis(attachAspis($input,$i[0]))));
if ( (($byte[0] & (0xE0)) == (0xC0)))
 {$char = attAspis(pack(('C*'),deAspisRC($byte),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (1)))))))));
$i = array((1) + $i[0],false);
$output = concat($output,Aspis_sprintf(array('\u%04s',false),Aspis_bin2hex($this->_utf82utf16($char))));
}if ( (($byte[0] & (0xF0)) == (0xE0)))
 {$char = attAspis(pack(('C*'),deAspisRC($byte),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (1))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (2)))))))));
$i = array((2) + $i[0],false);
$output = concat($output,Aspis_sprintf(array('\u%04s',false),Aspis_bin2hex($this->_utf82utf16($char))));
}if ( (($byte[0] & (0xF8)) == (0xF0)))
 {$char = attAspis(pack(('C*'),deAspisRC($byte),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (1))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (2)))),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (3))))))))))));
$i = array((3) + $i[0],false);
$output = concat($output,Aspis_sprintf(array('\u%04s',false),Aspis_bin2hex($this->_utf82utf16($char))));
}if ( (($byte[0] & (0xFC)) == (0xF8)))
 {$char = attAspis(pack(('C*'),deAspisRC($byte),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (1))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (2)))),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (3))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (4))))))))))));
$i = array((4) + $i[0],false);
$output = concat($output,Aspis_sprintf(array('\u%04s',false),Aspis_bin2hex($this->_utf82utf16($char))));
}if ( (($byte[0] & (0xFE)) == (0xFC)))
 {$char = attAspis(pack(('C*'),deAspisRC($byte),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (1))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (2)))),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (3))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (4))))))),deAspisRC(attAspis(ord(deAspis(attachAspis($input,($i[0] + (5))))))))))));
$i = array((5) + $i[0],false);
$output = concat($output,Aspis_sprintf(array('\u%04s',false),Aspis_bin2hex($this->_utf82utf16($char))));
}else 
{if ( ($byte[0] < (128)))
 $output = concat($output,attachAspis($input,$i[0]));
} }
}return concat2(concat1('"',$output),'"');
}return concat2(concat1('"',$input),'"');
} }
function _utf82utf16 ( $utf8 ) {
{if ( function_exists(('mb_convert_encoding')))
 return Aspis_mb_convert_encoding($utf8,array('UTF-16',false),array('UTF-8',false));
switch ( strlen($utf8[0]) ) {
case (1):return $utf8;
case (2):return concat(attAspis(chr(((0x07) & (ord(deAspis(attachAspis($utf8,(0)))) >> (2))))),attAspis(chr((((0xC0) & (ord(deAspis(attachAspis($utf8,(0)))) << (6))) | ((0x3F) & ord(deAspis(attachAspis($utf8,(1)))))))));
case (3):return concat(attAspis(chr((((0xF0) & (ord(deAspis(attachAspis($utf8,(0)))) << (4))) | ((0x0F) & (ord(deAspis(attachAspis($utf8,(1)))) >> (2)))))),attAspis(chr((((0xC0) & (ord(deAspis(attachAspis($utf8,(1)))) << (6))) | ((0x7F) & ord(deAspis(attachAspis($utf8,(2)))))))));
 }
return array('',false);
} }
function _encodeArray ( $input ) {
{$output = array('',false);
$isIndexed = array(true,false);
$keys = attAspisRC(array_keys(deAspisRC($input)));
for ( $i = array(0,false) ; ($i[0] < count($keys[0])) ; postincr($i) )
{if ( (!(is_int(deAspisRC(attachAspis($keys,$i[0]))))))
 {$output = concat($output,concat(concat2($this->encodeString(attachAspis($keys,$i[0])),':'),$this->encode(attachAspis($input,deAspis(attachAspis($keys,$i[0]))))));
$isIndexed = array(false,false);
}else 
{$output = concat($output,$this->encode(attachAspis($input,deAspis(attachAspis($keys,$i[0])))));
}if ( ($i[0] != (count($keys[0]) - (1))))
 $output = concat2($output,',');
}return $isIndexed[0] ? concat2(concat1('[',$output),']') : concat2(concat1('{',$output),'}');
} }
};
?>
<?php 