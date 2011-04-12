<?php require_once('AspisMain.php'); ?><?php
class Text_Diff_Renderer{var $_leading_context_lines = 0;
var $_trailing_context_lines = 0;
function Text_Diff_Renderer ( $params = array() ) {
{foreach ( $params as $param =>$value )
{$v = '_' . $param;
if ( isset($this->$v))
 {$this->$v = $value;
}}} }
function getParams (  ) {
{$params = array();
foreach ( get_object_vars($this) as $k =>$v )
{if ( $k[0] == '_')
 {$params[substr($k,1)] = $v;
}}{$AspisRetTemp = $params;
return $AspisRetTemp;
}} }
function render ( $diff ) {
{$xi = $yi = 1;
$block = false;
$context = array();
$nlead = $this->_leading_context_lines;
$ntrail = $this->_trailing_context_lines;
$output = $this->_startDiff();
$diffs = $diff->getDiff();
foreach ( $diffs as $i =>$edit )
{if ( is_a($edit,'Text_Diff_Op_copy'))
 {if ( is_array($block))
 {$keep = $i == count($diffs) - 1 ? $ntrail : $nlead + $ntrail;
if ( count($edit->orig) <= $keep)
 {$block[] = $edit;
}else 
{{if ( $ntrail)
 {$context = array_slice($edit->orig,0,$ntrail);
$block[] = &new Text_Diff_Op_copy($context);
}$output .= $this->_block($x0,$ntrail + $xi - $x0,$y0,$ntrail + $yi - $y0,$block);
$block = false;
}}}$context = $edit->orig;
}else 
{{if ( !is_array($block))
 {$context = array_slice($context,count($context) - $nlead);
$x0 = $xi - count($context);
$y0 = $yi - count($context);
$block = array();
if ( $context)
 {$block[] = &new Text_Diff_Op_copy($context);
}}$block[] = $edit;
}}if ( $edit->orig)
 {$xi += count($edit->orig);
}if ( $edit->final)
 {$yi += count($edit->final);
}}if ( is_array($block))
 {$output .= $this->_block($x0,$xi - $x0,$y0,$yi - $y0,$block);
}{$AspisRetTemp = $output . $this->_endDiff();
return $AspisRetTemp;
}} }
function _block ( $xbeg,$xlen,$ybeg,$ylen,&$edits ) {
{$output = $this->_startBlock($this->_blockHeader($xbeg,$xlen,$ybeg,$ylen));
foreach ( $edits as $edit  )
{switch ( strtolower(get_class($edit)) ) {
case 'text_diff_op_copy':$output .= $this->_context($edit->orig);
break ;
case 'text_diff_op_add':$output .= $this->_added($edit->final);
break ;
case 'text_diff_op_delete':$output .= $this->_deleted($edit->orig);
break ;
case 'text_diff_op_change':$output .= $this->_changed($edit->orig,$edit->final);
break ;
 }
}{$AspisRetTemp = $output . $this->_endBlock();
return $AspisRetTemp;
}} }
function _startDiff (  ) {
{{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function _endDiff (  ) {
{{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function _blockHeader ( $xbeg,$xlen,$ybeg,$ylen ) {
{if ( $xlen > 1)
 {$xbeg .= ',' . ($xbeg + $xlen - 1);
}if ( $ylen > 1)
 {$ybeg .= ',' . ($ybeg + $ylen - 1);
}if ( $xlen && !$ylen)
 {$ybeg--;
}elseif ( !$xlen)
 {$xbeg--;
}{$AspisRetTemp = $xbeg . ($xlen ? ($ylen ? 'c' : 'd') : 'a') . $ybeg;
return $AspisRetTemp;
}} }
function _startBlock ( $header ) {
{{$AspisRetTemp = $header . "\n";
return $AspisRetTemp;
}} }
function _endBlock (  ) {
{{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function _lines ( $lines,$prefix = ' ' ) {
{{$AspisRetTemp = $prefix . implode("\n$prefix",$lines) . "\n";
return $AspisRetTemp;
}} }
function _context ( $lines ) {
{{$AspisRetTemp = $this->_lines($lines,'  ');
return $AspisRetTemp;
}} }
function _added ( $lines ) {
{{$AspisRetTemp = $this->_lines($lines,'> ');
return $AspisRetTemp;
}} }
function _deleted ( $lines ) {
{{$AspisRetTemp = $this->_lines($lines,'< ');
return $AspisRetTemp;
}} }
function _changed ( $orig,$final ) {
{{$AspisRetTemp = $this->_deleted($orig) . "---\n" . $this->_added($final);
return $AspisRetTemp;
}} }
}