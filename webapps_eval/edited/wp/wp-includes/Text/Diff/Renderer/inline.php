<?php require_once('AspisMain.php'); ?><?php
require_once (deconcat2(Aspis_dirname(Aspis_dirname(array(__FILE__,false))),'/Renderer.php'));
class Text_Diff_Renderer_inline extends Text_Diff_Renderer{var $_leading_context_lines = array(10000,false);
var $_trailing_context_lines = array(10000,false);
var $_ins_prefix = array('<ins>',false);
var $_ins_suffix = array('</ins>',false);
var $_del_prefix = array('<del>',false);
var $_del_suffix = array('</del>',false);
var $_block_header = array('',false);
var $_split_level = array('lines',false);
function _blockHeader ( $xbeg,$xlen,$ybeg,$ylen ) {
{return $this->_block_header;
} }
function _startBlock ( $header ) {
{return $header;
} }
function _lines ( $lines,$prefix = array(' ',false),$encode = array(true,false) ) {
{if ( $encode[0])
 {Aspis_array_walk($lines,array(array(array($this,false),array('_encode',false)),false));
}if ( ($this->_split_level[0] == ('words')))
 {return Aspis_implode(array('',false),$lines);
}else 
{{return concat2(Aspis_implode(array("\n",false),$lines),"\n");
}}} }
function _added ( $lines ) {
{Aspis_array_walk($lines,array(array(array($this,false),array('_encode',false)),false));
arrayAssign($lines[0],deAspis(registerTaint(array(0,false))),addTaint(concat($this->_ins_prefix,attachAspis($lines,(0)))));
arrayAssign($lines[0],deAspis(registerTaint(array(count($lines[0]) - (1),false))),addTaint(concat(attachAspis($lines,(count( $lines[0]) - (1))),$this->_ins_suffix)));
return $this->_lines($lines,array(' ',false),array(false,false));
} }
function _deleted ( $lines,$words = array(false,false) ) {
{Aspis_array_walk($lines,array(array(array($this,false),array('_encode',false)),false));
arrayAssign($lines[0],deAspis(registerTaint(array(0,false))),addTaint(concat($this->_del_prefix,attachAspis($lines,(0)))));
arrayAssign($lines[0],deAspis(registerTaint(array(count($lines[0]) - (1),false))),addTaint(concat(attachAspis($lines,(count( $lines[0]) - (1))),$this->_del_suffix)));
return $this->_lines($lines,array(' ',false),array(false,false));
} }
function _changed ( $orig,$final ) {
{if ( ($this->_split_level[0] == ('words')))
 {$prefix = array('',false);
while ( ((((deAspis(attachAspis($orig,(0))) !== false) && (deAspis(attachAspis($final,(0))) !== false)) && (deAspis(Aspis_substr(attachAspis($orig,(0)),array(0,false),array(1,false))) == (' '))) && (deAspis(Aspis_substr(attachAspis($final,(0)),array(0,false),array(1,false))) == (' '))) )
{$prefix = concat($prefix,Aspis_substr(attachAspis($orig,(0)),array(0,false),array(1,false)));
arrayAssign($orig[0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_substr(attachAspis($orig,(0)),array(1,false))));
arrayAssign($final[0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_substr(attachAspis($final,(0)),array(1,false))));
}return concat(concat($prefix,$this->_deleted($orig)),$this->_added($final));
}$text1 = Aspis_implode(array("\n",false),$orig);
$text2 = Aspis_implode(array("\n",false),$final);
$nl = array("\0",false);
$diff = array(new Text_Diff($this->_splitOnWords($text1,$nl),$this->_splitOnWords($text2,$nl)),false);
$renderer = array(new Text_Diff_Renderer_inline(Aspis_array_merge($this->getParams(),array(array('split_level' => array('words',false,false)),false))),false);
return concat2(Aspis_str_replace($nl,array("\n",false),$renderer[0]->render($diff)),"\n");
} }
function _splitOnWords ( $string,$newlineEscape = array("\n",false) ) {
{$string = Aspis_str_replace(array("\0",false),array('',false),$string);
$words = array(array(),false);
$length = attAspis(strlen($string[0]));
$pos = array(0,false);
while ( ($pos[0] < $length[0]) )
{$spaces = attAspis(strspn(deAspis(Aspis_substr($string,$pos)),(" \n")));
$nextpos = attAspis(strcspn(deAspis(Aspis_substr($string,array($pos[0] + $spaces[0],false))),(" \n")));
arrayAssignAdd($words[0][],addTaint(Aspis_str_replace(array("\n",false),$newlineEscape,Aspis_substr($string,$pos,array($spaces[0] + $nextpos[0],false)))));
$pos = array(($spaces[0] + $nextpos[0]) + $pos[0],false);
}return $words;
} }
function _encode ( &$string ) {
{$string = Aspis_htmlspecialchars($string);
} }
}