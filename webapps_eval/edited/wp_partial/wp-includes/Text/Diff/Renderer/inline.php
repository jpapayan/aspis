<?php require_once('AspisMain.php'); ?><?php
require_once dirname(dirname(__FILE__)) . '/Renderer.php';
class Text_Diff_Renderer_inline extends Text_Diff_Renderer{var $_leading_context_lines = 10000;
var $_trailing_context_lines = 10000;
var $_ins_prefix = '<ins>';
var $_ins_suffix = '</ins>';
var $_del_prefix = '<del>';
var $_del_suffix = '</del>';
var $_block_header = '';
var $_split_level = 'lines';
function _blockHeader ( $xbeg,$xlen,$ybeg,$ylen ) {
{{$AspisRetTemp = $this->_block_header;
return $AspisRetTemp;
}} }
function _startBlock ( $header ) {
{{$AspisRetTemp = $header;
return $AspisRetTemp;
}} }
function _lines ( $lines,$prefix = ' ',$encode = true ) {
{if ( $encode)
 {AspisUntainted_array_walk($lines,array(&$this,'_encode'));
}if ( $this->_split_level == 'words')
 {{$AspisRetTemp = implode('',$lines);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = implode("\n",$lines) . "\n";
return $AspisRetTemp;
}}}} }
function _added ( $lines ) {
{AspisUntainted_array_walk($lines,array(&$this,'_encode'));
$lines[0] = $this->_ins_prefix . $lines[0];
$lines[count($lines) - 1] .= $this->_ins_suffix;
{$AspisRetTemp = $this->_lines($lines,' ',false);
return $AspisRetTemp;
}} }
function _deleted ( $lines,$words = false ) {
{AspisUntainted_array_walk($lines,array(&$this,'_encode'));
$lines[0] = $this->_del_prefix . $lines[0];
$lines[count($lines) - 1] .= $this->_del_suffix;
{$AspisRetTemp = $this->_lines($lines,' ',false);
return $AspisRetTemp;
}} }
function _changed ( $orig,$final ) {
{if ( $this->_split_level == 'words')
 {$prefix = '';
while ( $orig[0] !== false && $final[0] !== false && substr($orig[0],0,1) == ' ' && substr($final[0],0,1) == ' ' )
{$prefix .= substr($orig[0],0,1);
$orig[0] = substr($orig[0],1);
$final[0] = substr($final[0],1);
}{$AspisRetTemp = $prefix . $this->_deleted($orig) . $this->_added($final);
return $AspisRetTemp;
}}$text1 = implode("\n",$orig);
$text2 = implode("\n",$final);
$nl = "\0";
$diff = new Text_Diff($this->_splitOnWords($text1,$nl),$this->_splitOnWords($text2,$nl));
$renderer = new Text_Diff_Renderer_inline(array_merge($this->getParams(),array('split_level' => 'words')));
{$AspisRetTemp = str_replace($nl,"\n",$renderer->render($diff)) . "\n";
return $AspisRetTemp;
}} }
function _splitOnWords ( $string,$newlineEscape = "\n" ) {
{$string = str_replace("\0",'',$string);
$words = array();
$length = strlen($string);
$pos = 0;
while ( $pos < $length )
{$spaces = strspn(substr($string,$pos)," \n");
$nextpos = strcspn(substr($string,$pos + $spaces)," \n");
$words[] = str_replace("\n",$newlineEscape,substr($string,$pos,$spaces + $nextpos));
$pos += $spaces + $nextpos;
}{$AspisRetTemp = $words;
return $AspisRetTemp;
}} }
function _encode ( &$string ) {
{$string = htmlspecialchars($string);
} }
}