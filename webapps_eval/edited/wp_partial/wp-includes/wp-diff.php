<?php require_once('AspisMain.php'); ?><?php
if ( !class_exists('Text_Diff'))
 {require (dirname(__FILE__) . '/Text/Diff.php');
require (dirname(__FILE__) . '/Text/Diff/Renderer.php');
require (dirname(__FILE__) . '/Text/Diff/Renderer/inline.php');
}class WP_Text_Diff_Renderer_Table extends Text_Diff_Renderer{var $_leading_context_lines = 10000;
var $_trailing_context_lines = 10000;
var $_diff_threshold = 0.6;
var $inline_diff_renderer = 'WP_Text_Diff_Renderer_inline';
function Text_Diff_Renderer_Table ( $params = array() ) {
{$parent = get_parent_class($this);
AspisUntaintedDynamicCall(array($this,$parent),$params);
} }
function _startBlock ( $header ) {
{{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function _lines ( $lines,$prefix = ' ' ) {
{} }
function addedLine ( $line ) {
{{$AspisRetTemp = "<td>+</td><td class='diff-addedline'>{$line}</td>";
return $AspisRetTemp;
}} }
function deletedLine ( $line ) {
{{$AspisRetTemp = "<td>-</td><td class='diff-deletedline'>{$line}</td>";
return $AspisRetTemp;
}} }
function contextLine ( $line ) {
{{$AspisRetTemp = "<td> </td><td class='diff-context'>{$line}</td>";
return $AspisRetTemp;
}} }
function emptyLine (  ) {
{{$AspisRetTemp = '<td colspan="2">&nbsp;</td>';
return $AspisRetTemp;
}} }
function _added ( $lines,$encode = true ) {
{$r = '';
foreach ( $lines as $line  )
{if ( $encode)
 $line = htmlspecialchars($line);
$r .= '<tr>' . $this->emptyLine() . $this->addedLine($line) . "</tr>\n";
}{$AspisRetTemp = $r;
return $AspisRetTemp;
}} }
function _deleted ( $lines,$encode = true ) {
{$r = '';
foreach ( $lines as $line  )
{if ( $encode)
 $line = htmlspecialchars($line);
$r .= '<tr>' . $this->deletedLine($line) . $this->emptyLine() . "</tr>\n";
}{$AspisRetTemp = $r;
return $AspisRetTemp;
}} }
function _context ( $lines,$encode = true ) {
{$r = '';
foreach ( $lines as $line  )
{if ( $encode)
 $line = htmlspecialchars($line);
$r .= '<tr>' . $this->contextLine($line) . $this->contextLine($line) . "</tr>\n";
}{$AspisRetTemp = $r;
return $AspisRetTemp;
}} }
function _changed ( $orig,$final ) {
{$r = '';
list($orig_matches,$final_matches,$orig_rows,$final_rows) = $this->interleave_changed_lines($orig,$final);
$orig_diffs = array();
$final_diffs = array();
foreach ( $orig_matches as $o =>$f )
{if ( is_numeric($o) && is_numeric($f))
 {$text_diff = new Text_Diff('auto',array(array($orig[$o]),array($final[$f])));
$renderer = AspisNewUnknownProxy($this ->inline_diff_renderer,array ,false);
$diff = $renderer->render($text_diff);
if ( $diff_count = preg_match_all('!(<ins>.*?</ins>|<del>.*?</del>)!',$diff,$diff_matches))
 {$stripped_matches = strlen(strip_tags(join(' ',$diff_matches[0])));
$stripped_diff = strlen(strip_tags($diff)) * 2 - $stripped_matches;
$diff_ratio = $stripped_matches / $stripped_diff;
if ( $diff_ratio > $this->_diff_threshold)
 continue ;
}$orig_diffs[$o] = preg_replace('|<ins>.*?</ins>|','',$diff);
$final_diffs[$f] = preg_replace('|<del>.*?</del>|','',$diff);
}}foreach ( array_keys($orig_rows) as $row  )
{if ( $orig_rows[$row] < 0 && $final_rows[$row] < 0)
 continue ;
$orig_line = isset($orig_diffs[$orig_rows[$row]]) ? $orig_diffs[$orig_rows[$row]] : htmlspecialchars($orig[$orig_rows[$row]]);
$final_line = isset($final_diffs[$final_rows[$row]]) ? $final_diffs[$final_rows[$row]] : htmlspecialchars($final[$final_rows[$row]]);
if ( $orig_rows[$row] < 0)
 {$r .= $this->_added(array($final_line),false);
}elseif ( $final_rows[$row] < 0)
 {$r .= $this->_deleted(array($orig_line),false);
}else 
{{$r .= '<tr>' . $this->deletedLine($orig_line) . $this->addedLine($final_line) . "</tr>\n";
}}}{$AspisRetTemp = $r;
return $AspisRetTemp;
}} }
function interleave_changed_lines ( $orig,$final ) {
{$matches = array();
foreach ( array_keys($orig) as $o  )
{foreach ( array_keys($final) as $f  )
{$matches["$o,$f"] = $this->compute_string_distance($orig[$o],$final[$f]);
}}asort($matches);
$orig_matches = array();
$final_matches = array();
foreach ( $matches as $keys =>$difference )
{list($o,$f) = explode(',',$keys);
$o = (int)$o;
$f = (int)$f;
if ( isset($orig_matches[$o]) && isset($final_matches[$f]))
 continue ;
if ( !isset($orig_matches[$o]) && !isset($final_matches[$f]))
 {$orig_matches[$o] = $f;
$final_matches[$f] = $o;
continue ;
}if ( isset($orig_matches[$o]))
 $final_matches[$f] = 'x';
elseif ( isset($final_matches[$f]))
 $orig_matches[$o] = 'x';
}ksort($orig_matches);
ksort($final_matches);
$orig_rows = $orig_rows_copy = array_keys($orig_matches);
$final_rows = array_keys($final_matches);
foreach ( $orig_rows_copy as $orig_row  )
{$final_pos = array_search($orig_matches[$orig_row],$final_rows,true);
$orig_pos = (int)array_search($orig_row,$orig_rows,true);
if ( false === $final_pos)
 {array_splice($final_rows,$orig_pos,0,-1);
}elseif ( $final_pos < $orig_pos)
 {$diff_pos = $final_pos - $orig_pos;
while ( $diff_pos < 0 )
array_splice($final_rows,$orig_pos,0,$diff_pos++);
}elseif ( $final_pos > $orig_pos)
 {$diff_pos = $orig_pos - $final_pos;
while ( $diff_pos < 0 )
array_splice($orig_rows,$orig_pos,0,$diff_pos++);
}}$diff_count = count($orig_rows) - count($final_rows);
if ( $diff_count < 0)
 {while ( $diff_count < 0 )
array_push($orig_rows,$diff_count++);
}elseif ( $diff_count > 0)
 {$diff_count = -1 * $diff_count;
while ( $diff_count < 0 )
array_push($final_rows,$diff_count++);
}{$AspisRetTemp = array($orig_matches,$final_matches,$orig_rows,$final_rows);
return $AspisRetTemp;
}} }
function compute_string_distance ( $string1,$string2 ) {
{$chars1 = count_chars($string1);
$chars2 = count_chars($string2);
$difference = array_sum(array_map(array(&$this,'difference'),$chars1,$chars2));
if ( !$string1)
 {$AspisRetTemp = $difference;
return $AspisRetTemp;
}{$AspisRetTemp = $difference / strlen($string1);
return $AspisRetTemp;
}} }
function difference ( $a,$b ) {
{{$AspisRetTemp = abs($a - $b);
return $AspisRetTemp;
}} }
}class WP_Text_Diff_Renderer_inline extends Text_Diff_Renderer_inline{function _splitOnWords ( $string,$newlineEscape = "\n" ) {
{$string = str_replace("\0",'',$string);
$words = preg_split('/([^\w])/u',$string,-1,PREG_SPLIT_DELIM_CAPTURE);
$words = str_replace("\n",$newlineEscape,$words);
{$AspisRetTemp = $words;
return $AspisRetTemp;
}} }
};
?>
<?php 