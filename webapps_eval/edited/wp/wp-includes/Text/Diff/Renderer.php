<?php require_once('AspisMain.php'); ?><?php
class Text_Diff_Renderer{var $_leading_context_lines = array(0,false);
var $_trailing_context_lines = array(0,false);
function Text_Diff_Renderer ( $params = array(array(),false) ) {
{foreach ( $params[0] as $param =>$value )
{restoreTaint($param,$value);
{$v = concat1('_',$param);
if ( ((isset($this->$v[0]) && Aspis_isset( $this ->$v[0] ))))
 {$this->$v[0] = $value;
}}}} }
function getParams (  ) {
{$params = array(array(),false);
foreach ( get_object_vars(deAspisRC(array($this,false))) as $k =>$v )
{restoreTaint($k,$v);
{if ( (deAspis(attachAspis($k,(0))) == ('_')))
 {arrayAssign($params[0],deAspis(registerTaint(Aspis_substr($k,array(1,false)))),addTaint($v));
}}}return $params;
} }
function render ( $diff ) {
{$xi = $yi = array(1,false);
$block = array(false,false);
$context = array(array(),false);
$nlead = $this->_leading_context_lines;
$ntrail = $this->_trailing_context_lines;
$output = $this->_startDiff();
$diffs = $diff[0]->getDiff();
foreach ( $diffs[0] as $i =>$edit )
{restoreTaint($i,$edit);
{if ( is_a(deAspisRC($edit),('Text_Diff_Op_copy')))
 {if ( is_array($block[0]))
 {$keep = ($i[0] == (count($diffs[0]) - (1))) ? $ntrail : array($nlead[0] + $ntrail[0],false);
if ( (count($edit[0]->orig[0]) <= $keep[0]))
 {arrayAssignAdd($block[0][],addTaint($edit));
}else 
{{if ( $ntrail[0])
 {$context = Aspis_array_slice($edit[0]->orig,array(0,false),$ntrail);
arrayAssignAdd($block[0][],addTaint(array(new Text_Diff_Op_copy($context),false)));
}$output = concat($output,$this->_block($x0,array(($ntrail[0] + $xi[0]) - $x0[0],false),$y0,array(($ntrail[0] + $yi[0]) - $y0[0],false),$block));
$block = array(false,false);
}}}$context = $edit[0]->orig;
}else 
{{if ( (!(is_array($block[0]))))
 {$context = Aspis_array_slice($context,array(count($context[0]) - $nlead[0],false));
$x0 = array($xi[0] - count($context[0]),false);
$y0 = array($yi[0] - count($context[0]),false);
$block = array(array(),false);
if ( $context[0])
 {arrayAssignAdd($block[0][],addTaint(array(new Text_Diff_Op_copy($context),false)));
}}arrayAssignAdd($block[0][],addTaint($edit));
}}if ( $edit[0]->orig[0])
 {$xi = array(count($edit[0]->orig[0]) + $xi[0],false);
}if ( $edit[0]->final[0])
 {$yi = array(count($edit[0]->final[0]) + $yi[0],false);
}}}if ( is_array($block[0]))
 {$output = concat($output,$this->_block($x0,array($xi[0] - $x0[0],false),$y0,array($yi[0] - $y0[0],false),$block));
}return concat($output,$this->_endDiff());
} }
function _block ( $xbeg,$xlen,$ybeg,$ylen,&$edits ) {
{$output = $this->_startBlock($this->_blockHeader($xbeg,$xlen,$ybeg,$ylen));
foreach ( $edits[0] as $edit  )
{switch ( deAspis(Aspis_strtolower(attAspis(get_class(deAspisRC($edit))))) ) {
case ('text_diff_op_copy'):$output = concat($output,$this->_context($edit[0]->orig));
break ;
case ('text_diff_op_add'):$output = concat($output,$this->_added($edit[0]->final));
break ;
case ('text_diff_op_delete'):$output = concat($output,$this->_deleted($edit[0]->orig));
break ;
case ('text_diff_op_change'):$output = concat($output,$this->_changed($edit[0]->orig,$edit[0]->final));
break ;
 }
}return concat($output,$this->_endBlock());
} }
function _startDiff (  ) {
{return array('',false);
} }
function _endDiff (  ) {
{return array('',false);
} }
function _blockHeader ( $xbeg,$xlen,$ybeg,$ylen ) {
{if ( ($xlen[0] > (1)))
 {$xbeg = concat($xbeg,concat1(',',(array(($xbeg[0] + $xlen[0]) - (1),false))));
}if ( ($ylen[0] > (1)))
 {$ybeg = concat($ybeg,concat1(',',(array(($ybeg[0] + $ylen[0]) - (1),false))));
}if ( ($xlen[0] && (denot_boolean($ylen))))
 {postdecr($ybeg);
}elseif ( (denot_boolean($xlen)))
 {postdecr($xbeg);
}return concat(concat($xbeg,($xlen[0] ? ($ylen[0] ? array('c',false) : array('d',false)) : array('a',false))),$ybeg);
} }
function _startBlock ( $header ) {
{return concat2($header,"\n");
} }
function _endBlock (  ) {
{return array('',false);
} }
function _lines ( $lines,$prefix = array(' ',false) ) {
{return concat2(concat($prefix,Aspis_implode(concat1("\n",$prefix),$lines)),"\n");
} }
function _context ( $lines ) {
{return $this->_lines($lines,array('  ',false));
} }
function _added ( $lines ) {
{return $this->_lines($lines,array('> ',false));
} }
function _deleted ( $lines ) {
{return $this->_lines($lines,array('< ',false));
} }
function _changed ( $orig,$final ) {
{return concat(concat2($this->_deleted($orig),"---\n"),$this->_added($final));
} }
}