<?php require_once('AspisMain.php'); ?><?php
if ( (!(class_exists(('POMO_Reader')))))
 {class POMO_Reader{var $endian = array('little',false);
var $_post = array('',false);
function POMO_Reader (  ) {
{$this->is_overloaded = array((((ini_get("mbstring.func_overload")) & (2)) != (0)) && function_exists(('mb_substr')),false);
$this->_pos = array(0,false);
} }
function setEndian ( $endian ) {
{$this->endian = $endian;
} }
function readint32 (  ) {
{$bytes = $this->read(array(4,false));
if ( ((4) != deAspis($this->strlen($bytes))))
 return array(false,false);
$endian_letter = (('big') == $this->endian[0]) ? array('N',false) : array('V',false);
$int = attAspisRC(unpack($endian_letter[0],$bytes[0]));
return Aspis_array_shift($int);
} }
function readint32array ( $count ) {
{$bytes = $this->read(array((4) * $count[0],false));
if ( (((4) * $count[0]) != deAspis($this->strlen($bytes))))
 return array(false,false);
$endian_letter = (('big') == $this->endian[0]) ? array('N',false) : array('V',false);
return attAspisRC(unpack((deconcat($endian_letter,$count)),$bytes[0]));
} }
function substr ( $string,$start,$length ) {
{if ( $this->is_overloaded[0])
 {return array(mb_substr(deAspisRC($string),deAspisRC($start),deAspisRC($length),'ascii'),false);
}else 
{{return Aspis_substr($string,$start,$length);
}}} }
function strlen ( $string ) {
{if ( $this->is_overloaded[0])
 {return array(mb_strlen(deAspisRC($string),'ascii'),false);
}else 
{{return attAspis(strlen($string[0]));
}}} }
function str_split ( $string,$chunk_size ) {
{if ( (!(function_exists(('str_split')))))
 {$length = $this->strlen($string);
$out = array(array(),false);
for ( $i = array(0,false) ; ($i[0] < $length[0]) ; $i = array($chunk_size[0] + $i[0],false) )
arrayAssignAdd($out[0][],addTaint($this->substr($string,$i,$chunk_size)));
return $out;
}else 
{{return Aspis_str_split($string,$chunk_size);
}}} }
function pos (  ) {
{return $this->_pos;
} }
function is_resource (  ) {
{return array(true,false);
} }
function close (  ) {
{return array(true,false);
} }
}}if ( (!(class_exists(('POMO_FileReader')))))
 {class POMO_FileReader extends POMO_Reader{function POMO_FileReader ( $filename ) {
{parent::POMO_Reader();
$this->_f = attAspis(fopen($filename[0],('r')));
} }
function read ( $bytes ) {
{return attAspis(fread($this->_f[0],$bytes[0]));
} }
function seekto ( $pos ) {
{if ( (deAspis(negate(array(1,false))) == fseek($this->_f[0],$pos[0],SEEK_SET)))
 {return array(false,false);
}$this->_pos = $pos;
return array(true,false);
} }
function is_resource (  ) {
{return attAspis(is_resource(deAspisRC($this->_f)));
} }
function feof (  ) {
{return attAspis(feof($this->_f[0]));
} }
function close (  ) {
{return attAspis(fclose($this->_f[0]));
} }
function read_all (  ) {
{$all = array('',false);
while ( (denot_boolean($this->feof())) )
$all = concat($all,$this->read(array(4096,false)));
return $all;
} }
}}if ( (!(class_exists(('POMO_StringReader')))))
 {class POMO_StringReader extends POMO_Reader{var $_str = array('',false);
function POMO_StringReader ( $str = array('',false) ) {
{parent::POMO_Reader();
$this->_str = $str;
$this->_pos = array(0,false);
} }
function read ( $bytes ) {
{$data = $this->substr($this->_str,$this->_pos,$bytes);
$this->_pos = array($bytes[0] + $this->_pos [0],false);
if ( (deAspis($this->strlen($this->_str)) < $this->_pos[0]))
 $this->_pos = $this->strlen($this->_str);
return $data;
} }
function seekto ( $pos ) {
{$this->_pos = $pos;
if ( (deAspis($this->strlen($this->_str)) < $this->_pos[0]))
 $this->_pos = $this->strlen($this->_str);
return $this->_pos;
} }
function length (  ) {
{return $this->strlen($this->_str);
} }
function read_all (  ) {
{return $this->substr($this->_str,$this->_pos,$this->strlen($this->_str));
} }
}}if ( (!(class_exists(('POMO_CachedFileReader')))))
 {class POMO_CachedFileReader extends POMO_StringReader{function POMO_CachedFileReader ( $filename ) {
{parent::POMO_StringReader();
$this->_str = attAspis(file_get_contents($filename[0]));
if ( (false === $this->_str[0]))
 return array(false,false);
$this->_pos = array(0,false);
} }
}}if ( (!(class_exists(('POMO_CachedIntFileReader')))))
 {class POMO_CachedIntFileReader extends POMO_CachedFileReader{function POMO_CachedIntFileReader ( $filename ) {
{parent::POMO_CachedFileReader($filename);
} }
}}