<?php require_once('AspisMain.php'); ?><?php
define('JSON_BOOL',1);
define('JSON_INT',2);
define('JSON_STR',3);
define('JSON_FLOAT',4);
define('JSON_NULL',5);
define('JSON_START_OBJ',6);
define('JSON_END_OBJ',7);
define('JSON_START_ARRAY',8);
define('JSON_END_ARRAY',9);
define('JSON_KEY',10);
define('JSON_SKIP',11);
define('JSON_IN_ARRAY',30);
define('JSON_IN_OBJECT',40);
define('JSON_IN_BETWEEN',50);
class Moxiecode_JSONReader{var $_data,$_len,$_pos;
var $_value,$_token;
var $_location,$_lastLocations;
var $_needProp;
function Moxiecode_JSONReader ( $data ) {
{$this->_data = $data;
$this->_len = strlen($data);
$this->_pos = -1;
$this->_location = JSON_IN_BETWEEN;
$this->_lastLocations = array();
$this->_needProp = false;
} }
function getToken (  ) {
{{$AspisRetTemp = $this->_token;
return $AspisRetTemp;
}} }
function getLocation (  ) {
{{$AspisRetTemp = $this->_location;
return $AspisRetTemp;
}} }
function getTokenName (  ) {
{switch ( $this->_token ) {
case JSON_BOOL:{$AspisRetTemp = 'JSON_BOOL';
return $AspisRetTemp;
}case JSON_INT:{$AspisRetTemp = 'JSON_INT';
return $AspisRetTemp;
}case JSON_STR:{$AspisRetTemp = 'JSON_STR';
return $AspisRetTemp;
}case JSON_FLOAT:{$AspisRetTemp = 'JSON_FLOAT';
return $AspisRetTemp;
}case JSON_NULL:{$AspisRetTemp = 'JSON_NULL';
return $AspisRetTemp;
}case JSON_START_OBJ:{$AspisRetTemp = 'JSON_START_OBJ';
return $AspisRetTemp;
}case JSON_END_OBJ:{$AspisRetTemp = 'JSON_END_OBJ';
return $AspisRetTemp;
}case JSON_START_ARRAY:{$AspisRetTemp = 'JSON_START_ARRAY';
return $AspisRetTemp;
}case JSON_END_ARRAY:{$AspisRetTemp = 'JSON_END_ARRAY';
return $AspisRetTemp;
}case JSON_KEY:{$AspisRetTemp = 'JSON_KEY';
return $AspisRetTemp;
} }
{$AspisRetTemp = 'UNKNOWN';
return $AspisRetTemp;
}} }
function getValue (  ) {
{{$AspisRetTemp = $this->_value;
return $AspisRetTemp;
}} }
function readToken (  ) {
{$chr = $this->read();
if ( $chr != null)
 {switch ( $chr ) {
case '[':$this->_lastLocation[] = $this->_location;
$this->_location = JSON_IN_ARRAY;
$this->_token = JSON_START_ARRAY;
$this->_value = null;
$this->readAway();
{$AspisRetTemp = true;
return $AspisRetTemp;
}case ']':$this->_location = array_pop($this->_lastLocation);
$this->_token = JSON_END_ARRAY;
$this->_value = null;
$this->readAway();
if ( $this->_location == JSON_IN_OBJECT)
 $this->_needProp = true;
{$AspisRetTemp = true;
return $AspisRetTemp;
}case '{':$this->_lastLocation[] = $this->_location;
$this->_location = JSON_IN_OBJECT;
$this->_needProp = true;
$this->_token = JSON_START_OBJ;
$this->_value = null;
$this->readAway();
{$AspisRetTemp = true;
return $AspisRetTemp;
}case '}':$this->_location = array_pop($this->_lastLocation);
$this->_token = JSON_END_OBJ;
$this->_value = null;
$this->readAway();
if ( $this->_location == JSON_IN_OBJECT)
 $this->_needProp = true;
{$AspisRetTemp = true;
return $AspisRetTemp;
}case '"':case '\'':{$AspisRetTemp = $this->_readString($chr);
return $AspisRetTemp;
}case 'n':{$AspisRetTemp = $this->_readNull();
return $AspisRetTemp;
}case 't':case 'f':{$AspisRetTemp = $this->_readBool($chr);
return $AspisRetTemp;
}default :if ( is_numeric($chr) || $chr == '-' || $chr == '.')
 {$AspisRetTemp = $this->_readNumber($chr);
return $AspisRetTemp;
}{$AspisRetTemp = true;
return $AspisRetTemp;
} }
}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function _readBool ( $chr ) {
{$this->_token = JSON_BOOL;
$this->_value = $chr == 't';
if ( $chr == 't')
 $this->skip(3);
else 
{$this->skip(4);
}$this->readAway();
if ( $this->_location == JSON_IN_OBJECT && !$this->_needProp)
 $this->_needProp = true;
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function _readNull (  ) {
{$this->_token = JSON_NULL;
$this->_value = null;
$this->skip(3);
$this->readAway();
if ( $this->_location == JSON_IN_OBJECT && !$this->_needProp)
 $this->_needProp = true;
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function _readString ( $quote ) {
{$output = "";
$this->_token = JSON_STR;
$endString = false;
while ( ($chr = $this->peek()) != -1 )
{switch ( $chr ) {
case '\\':$this->read();
$chr = $this->read();
switch ( $chr ) {
case 't':$output .= "\t";
break ;
case 'b':$output .= "\b";
break ;
case 'f':$output .= "\f";
break ;
case 'r':$output .= "\r";
break ;
case 'n':$output .= "\n";
break ;
case 'u':$output .= $this->_int2utf8(hexdec($this->read(4)));
break ;
default :$output .= $chr;
break ;
 }
break ;
case '\'':case '"':if ( $chr == $quote)
 $endString = true;
$chr = $this->read();
if ( $chr != -1 && $chr != $quote)
 $output .= $chr;
break ;
default :$output .= $this->read();
 }
if ( $endString)
 break ;
}$this->readAway();
$this->_value = $output;
if ( $this->_needProp)
 {$this->_token = JSON_KEY;
$this->_needProp = false;
{$AspisRetTemp = true;
return $AspisRetTemp;
}}if ( $this->_location == JSON_IN_OBJECT && !$this->_needProp)
 $this->_needProp = true;
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function _int2utf8 ( $int ) {
{$int = intval($int);
switch ( $int ) {
case 0:{$AspisRetTemp = chr(0);
return $AspisRetTemp;
}case ($int & 0x7F):{$AspisRetTemp = chr($int);
return $AspisRetTemp;
}case ($int & 0x7FF):{$AspisRetTemp = chr(0xC0 | (($int >> 6) & 0x1F)) . chr(0x80 | ($int & 0x3F));
return $AspisRetTemp;
}case ($int & 0xFFFF):{$AspisRetTemp = chr(0xE0 | (($int >> 12) & 0x0F)) . chr(0x80 | (($int >> 6) & 0x3F)) . chr(0x80 | ($int & 0x3F));
return $AspisRetTemp;
}case ($int & 0x1FFFFF):{$AspisRetTemp = chr(0xF0 | ($int >> 18)) . chr(0x80 | (($int >> 12) & 0x3F)) . chr(0x80 | (($int >> 6) & 0x3F)) . chr(0x80 | ($int & 0x3F));
return $AspisRetTemp;
} }
} }
function _readNumber ( $start ) {
{$value = "";
$isFloat = false;
$this->_token = JSON_INT;
$value .= $start;
while ( ($chr = $this->peek()) != -1 )
{if ( is_numeric($chr) || $chr == '-' || $chr == '.')
 {if ( $chr == '.')
 $isFloat = true;
$value .= $this->read();
}else 
{break ;
}}$this->readAway();
if ( $isFloat)
 {$this->_token = JSON_FLOAT;
$this->_value = floatval($value);
}else 
{$this->_value = intval($value);
}if ( $this->_location == JSON_IN_OBJECT && !$this->_needProp)
 $this->_needProp = true;
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function readAway (  ) {
{while ( ($chr = $this->peek()) != null )
{if ( $chr != ':' && $chr != ',' && $chr != ' ')
 {return ;
}$this->read();
}} }
function read ( $len = 1 ) {
{if ( $this->_pos < $this->_len)
 {if ( $len > 1)
 {$str = substr($this->_data,$this->_pos + 1,$len);
$this->_pos += $len;
{$AspisRetTemp = $str;
return $AspisRetTemp;
}}else 
{{$AspisRetTemp = $this->_data[++$this->_pos];
return $AspisRetTemp;
}}}{$AspisRetTemp = null;
return $AspisRetTemp;
}} }
function skip ( $len ) {
{$this->_pos += $len;
} }
function peek (  ) {
{if ( $this->_pos < $this->_len)
 {$AspisRetTemp = $this->_data[$this->_pos + 1];
return $AspisRetTemp;
}{$AspisRetTemp = null;
return $AspisRetTemp;
}} }
}class Moxiecode_JSON{function Moxiecode_JSON (  ) {
{} }
function decode ( $input ) {
{$reader = new Moxiecode_JSONReader($input);
{$AspisRetTemp = $this->readValue($reader);
return $AspisRetTemp;
}} }
function readValue ( &$reader ) {
{$this->data = array();
$this->parents = array();
$this->cur = &$this->data;
$key = null;
$loc = JSON_IN_ARRAY;
while ( $reader->readToken() )
{switch ( $reader->getToken() ) {
case JSON_STR:case JSON_INT:case JSON_BOOL:case JSON_FLOAT:case JSON_NULL:switch ( $reader->getLocation() ) {
case JSON_IN_OBJECT:$this->cur[$key] = $reader->getValue();
break ;
case JSON_IN_ARRAY:$this->cur[] = $reader->getValue();
break ;
default :{$AspisRetTemp = $reader->getValue();
return $AspisRetTemp;
} }
break ;
case JSON_KEY:$key = $reader->getValue();
break ;
case JSON_START_OBJ:case JSON_START_ARRAY:if ( $loc == JSON_IN_OBJECT)
 $this->addArray($key);
else 
{$this->addArray(null);
}$cur = &$obj;
$loc = $reader->getLocation();
break ;
case JSON_END_OBJ:case JSON_END_ARRAY:$loc = $reader->getLocation();
if ( count($this->parents) > 0)
 {$this->cur = &$this->parents[count($this->parents) - 1];
array_pop($this->parents);
}break ;
 }
}{$AspisRetTemp = $this->data[0];
return $AspisRetTemp;
}} }
function addArray ( $key ) {
{$this->parents[] = &$this->cur;
$ar = array();
if ( $key)
 $this->cur[$key] = &$ar;
else 
{$this->cur[] = &$ar;
}$this->cur = &$ar;
} }
function getDelim ( $index,&$reader ) {
{switch ( $reader->getLocation() ) {
case JSON_IN_ARRAY:case JSON_IN_OBJECT:if ( $index > 0)
 {$AspisRetTemp = ",";
return $AspisRetTemp;
}break ;
 }
{$AspisRetTemp = "";
return $AspisRetTemp;
}} }
function encode ( $input ) {
{switch ( gettype($input) ) {
case 'boolean':{$AspisRetTemp = $input ? 'true' : 'false';
return $AspisRetTemp;
}case 'integer':{$AspisRetTemp = (int)$input;
return $AspisRetTemp;
}case 'float':case 'double':{$AspisRetTemp = (double)$input;
return $AspisRetTemp;
}case 'NULL':{$AspisRetTemp = 'null';
return $AspisRetTemp;
}case 'string':{$AspisRetTemp = $this->encodeString($input);
return $AspisRetTemp;
}case 'array':{$AspisRetTemp = $this->_encodeArray($input);
return $AspisRetTemp;
}case 'object':{$AspisRetTemp = $this->_encodeArray(get_object_vars($input));
return $AspisRetTemp;
} }
{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function encodeString ( $input ) {
{if ( preg_match('/[^a-zA-Z0-9]/',$input))
 {$output = '';
for ( $i = 0 ; $i < strlen($input) ; $i++ )
{switch ( $input[$i] ) {
case "\b":$output .= "\\b";
break ;
case "\t":$output .= "\\t";
break ;
case "\f":$output .= "\\f";
break ;
case "\r":$output .= "\\r";
break ;
case "\n":$output .= "\\n";
break ;
case '\\':$output .= "\\\\";
break ;
case '\'':$output .= "\\'";
break ;
case '"':$output .= '\"';
break ;
default :$byte = ord($input[$i]);
if ( ($byte & 0xE0) == 0xC0)
 {$char = pack('C*',$byte,ord($input[$i + 1]));
$i += 1;
$output .= sprintf('\u%04s',bin2hex($this->_utf82utf16($char)));
}if ( ($byte & 0xF0) == 0xE0)
 {$char = pack('C*',$byte,ord($input[$i + 1]),ord($input[$i + 2]));
$i += 2;
$output .= sprintf('\u%04s',bin2hex($this->_utf82utf16($char)));
}if ( ($byte & 0xF8) == 0xF0)
 {$char = pack('C*',$byte,ord($input[$i + 1]),ord($input[$i + 2],ord($input[$i + 3])));
$i += 3;
$output .= sprintf('\u%04s',bin2hex($this->_utf82utf16($char)));
}if ( ($byte & 0xFC) == 0xF8)
 {$char = pack('C*',$byte,ord($input[$i + 1]),ord($input[$i + 2],ord($input[$i + 3]),ord($input[$i + 4])));
$i += 4;
$output .= sprintf('\u%04s',bin2hex($this->_utf82utf16($char)));
}if ( ($byte & 0xFE) == 0xFC)
 {$char = pack('C*',$byte,ord($input[$i + 1]),ord($input[$i + 2],ord($input[$i + 3]),ord($input[$i + 4]),ord($input[$i + 5])));
$i += 5;
$output .= sprintf('\u%04s',bin2hex($this->_utf82utf16($char)));
}else 
{if ( $byte < 128)
 $output .= $input[$i];
} }
}{$AspisRetTemp = '"' . $output . '"';
return $AspisRetTemp;
}}{$AspisRetTemp = '"' . $input . '"';
return $AspisRetTemp;
}} }
function _utf82utf16 ( $utf8 ) {
{if ( function_exists('mb_convert_encoding'))
 {$AspisRetTemp = mb_convert_encoding($utf8,'UTF-16','UTF-8');
return $AspisRetTemp;
}switch ( strlen($utf8) ) {
case 1:{$AspisRetTemp = $utf8;
return $AspisRetTemp;
}case 2:{$AspisRetTemp = chr(0x07 & (ord($utf8[0]) >> 2)) . chr((0xC0 & (ord($utf8[0]) << 6)) | (0x3F & ord($utf8[1])));
return $AspisRetTemp;
}case 3:{$AspisRetTemp = chr((0xF0 & (ord($utf8[0]) << 4)) | (0x0F & (ord($utf8[1]) >> 2))) . chr((0xC0 & (ord($utf8[1]) << 6)) | (0x7F & ord($utf8[2])));
return $AspisRetTemp;
} }
{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function _encodeArray ( $input ) {
{$output = '';
$isIndexed = true;
$keys = array_keys($input);
for ( $i = 0 ; $i < count($keys) ; $i++ )
{if ( !is_int($keys[$i]))
 {$output .= $this->encodeString($keys[$i]) . ':' . $this->encode($input[$keys[$i]]);
$isIndexed = false;
}else 
{$output .= $this->encode($input[$keys[$i]]);
}if ( $i != count($keys) - 1)
 $output .= ',';
}{$AspisRetTemp = $isIndexed ? '[' . $output . ']' : '{' . $output . '}';
return $AspisRetTemp;
}} }
};
?>
<?php 