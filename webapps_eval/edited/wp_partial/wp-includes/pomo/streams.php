<?php require_once('AspisMain.php'); ?><?php
if ( !class_exists('POMO_Reader'))
 {class POMO_Reader{var $endian = 'little';
var $_post = '';
function POMO_Reader (  ) {
{$this->is_overloaded = ((ini_get("mbstring.func_overload") & 2) != 0) && function_exists('mb_substr');
$this->_pos = 0;
} }
function setEndian ( $endian ) {
{$this->endian = $endian;
} }
function readint32 (  ) {
{$bytes = $this->read(4);
if ( 4 != $this->strlen($bytes))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$endian_letter = ('big' == $this->endian) ? 'N' : 'V';
$int = unpack($endian_letter,$bytes);
{$AspisRetTemp = array_shift($int);
return $AspisRetTemp;
}} }
function readint32array ( $count ) {
{$bytes = $this->read(4 * $count);
if ( 4 * $count != $this->strlen($bytes))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$endian_letter = ('big' == $this->endian) ? 'N' : 'V';
{$AspisRetTemp = unpack($endian_letter . $count,$bytes);
return $AspisRetTemp;
}} }
function substr ( $string,$start,$length ) {
{if ( $this->is_overloaded)
 {{$AspisRetTemp = mb_substr($string,$start,$length,'ascii');
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = substr($string,$start,$length);
return $AspisRetTemp;
}}}} }
function strlen ( $string ) {
{if ( $this->is_overloaded)
 {{$AspisRetTemp = mb_strlen($string,'ascii');
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = strlen($string);
return $AspisRetTemp;
}}}} }
function str_split ( $string,$chunk_size ) {
{if ( !function_exists('str_split'))
 {$length = $this->strlen($string);
$out = array();
for ( $i = 0 ; $i < $length ; $i += $chunk_size )
$out[] = $this->substr($string,$i,$chunk_size);
{$AspisRetTemp = $out;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = str_split($string,$chunk_size);
return $AspisRetTemp;
}}}} }
function pos (  ) {
{{$AspisRetTemp = $this->_pos;
return $AspisRetTemp;
}} }
function is_resource (  ) {
{{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function close (  ) {
{{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
}}if ( !class_exists('POMO_FileReader'))
 {class POMO_FileReader extends POMO_Reader{function POMO_FileReader ( $filename ) {
{parent::POMO_Reader();
$this->_f = fopen($filename,'r');
} }
function read ( $bytes ) {
{{$AspisRetTemp = fread($this->_f,$bytes);
return $AspisRetTemp;
}} }
function seekto ( $pos ) {
{if ( -1 == fseek($this->_f,$pos,SEEK_SET))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->_pos = $pos;
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function is_resource (  ) {
{{$AspisRetTemp = is_resource($this->_f);
return $AspisRetTemp;
}} }
function feof (  ) {
{{$AspisRetTemp = feof($this->_f);
return $AspisRetTemp;
}} }
function close (  ) {
{{$AspisRetTemp = fclose($this->_f);
return $AspisRetTemp;
}} }
function read_all (  ) {
{$all = '';
while ( !$this->feof() )
$all .= $this->read(4096);
{$AspisRetTemp = $all;
return $AspisRetTemp;
}} }
}}if ( !class_exists('POMO_StringReader'))
 {class POMO_StringReader extends POMO_Reader{var $_str = '';
function POMO_StringReader ( $str = '' ) {
{parent::POMO_Reader();
$this->_str = $str;
$this->_pos = 0;
} }
function read ( $bytes ) {
{$data = $this->substr($this->_str,$this->_pos,$bytes);
$this->_pos += $bytes;
if ( $this->strlen($this->_str) < $this->_pos)
 $this->_pos = $this->strlen($this->_str);
{$AspisRetTemp = $data;
return $AspisRetTemp;
}} }
function seekto ( $pos ) {
{$this->_pos = $pos;
if ( $this->strlen($this->_str) < $this->_pos)
 $this->_pos = $this->strlen($this->_str);
{$AspisRetTemp = $this->_pos;
return $AspisRetTemp;
}} }
function length (  ) {
{{$AspisRetTemp = $this->strlen($this->_str);
return $AspisRetTemp;
}} }
function read_all (  ) {
{{$AspisRetTemp = $this->substr($this->_str,$this->_pos,$this->strlen($this->_str));
return $AspisRetTemp;
}} }
}}if ( !class_exists('POMO_CachedFileReader'))
 {class POMO_CachedFileReader extends POMO_StringReader{function POMO_CachedFileReader ( $filename ) {
{parent::POMO_StringReader();
$this->_str = file_get_contents($filename);
if ( false === $this->_str)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$this->_pos = 0;
} }
}}if ( !class_exists('POMO_CachedIntFileReader'))
 {class POMO_CachedIntFileReader extends POMO_CachedFileReader{function POMO_CachedIntFileReader ( $filename ) {
{parent::POMO_CachedFileReader($filename);
} }
}}