<?php require_once('AspisMain.php'); ?><?php
if ( (!(class_exists(('Text_Diff')))))
 {require (deconcat2(Aspis_dirname(array(__FILE__,false)),'/Text/Diff.php'));
require (deconcat2(Aspis_dirname(array(__FILE__,false)),'/Text/Diff/Renderer.php'));
require (deconcat2(Aspis_dirname(array(__FILE__,false)),'/Text/Diff/Renderer/inline.php'));
}class WP_Text_Diff_Renderer_Table extends Text_Diff_Renderer{var $_leading_context_lines = array(10000,false);
var $_trailing_context_lines = array(10000,false);
var $_diff_threshold = array(0.6,false);
var $inline_diff_renderer = array('WP_Text_Diff_Renderer_inline',false);
function Text_Diff_Renderer_Table ( $params = array(array(),false) ) {
{$parent = attAspis(get_parent_class(($this)));
AspisDynamicCall(array(array($this,$parent),false),$params);
} }
function _startBlock ( $header ) {
{return array('',false);
} }
function _lines ( $lines,$prefix = array(' ',false) ) {
{} }
function addedLine ( $line ) {
{return concat2(concat1("<td>+</td><td class='diff-addedline'>",$line),"</td>");
} }
function deletedLine ( $line ) {
{return concat2(concat1("<td>-</td><td class='diff-deletedline'>",$line),"</td>");
} }
function contextLine ( $line ) {
{return concat2(concat1("<td> </td><td class='diff-context'>",$line),"</td>");
} }
function emptyLine (  ) {
{return array('<td colspan="2">&nbsp;</td>',false);
} }
function _added ( $lines,$encode = array(true,false) ) {
{$r = array('',false);
foreach ( $lines[0] as $line  )
{if ( $encode[0])
 $line = Aspis_htmlspecialchars($line);
$r = concat($r,concat2(concat(concat1('<tr>',$this->emptyLine()),$this->addedLine($line)),"</tr>\n"));
}return $r;
} }
function _deleted ( $lines,$encode = array(true,false) ) {
{$r = array('',false);
foreach ( $lines[0] as $line  )
{if ( $encode[0])
 $line = Aspis_htmlspecialchars($line);
$r = concat($r,concat2(concat(concat1('<tr>',$this->deletedLine($line)),$this->emptyLine()),"</tr>\n"));
}return $r;
} }
function _context ( $lines,$encode = array(true,false) ) {
{$r = array('',false);
foreach ( $lines[0] as $line  )
{if ( $encode[0])
 $line = Aspis_htmlspecialchars($line);
$r = concat($r,concat2(concat(concat1('<tr>',$this->contextLine($line)),$this->contextLine($line)),"</tr>\n"));
}return $r;
} }
function _changed ( $orig,$final ) {
{$r = array('',false);
list($orig_matches,$final_matches,$orig_rows,$final_rows) = deAspisList($this->interleave_changed_lines($orig,$final),array());
$orig_diffs = array(array(),false);
$final_diffs = array(array(),false);
foreach ( $orig_matches[0] as $o =>$f )
{restoreTaint($o,$f);
{if ( (is_numeric(deAspisRC($o)) && is_numeric(deAspisRC($f))))
 {$text_diff = array(new Text_Diff(array('auto',false),array(array(array(array(attachAspis($orig,$o[0])),false),array(array(attachAspis($final,$f[0])),false)),false)),false);
$renderer = array(new $this->inline_diff_renderer[0],false);
$diff = $renderer[0]->render($text_diff);
if ( deAspis($diff_count = Aspis_preg_match_all(array('!(<ins>.*?</ins>|<del>.*?</del>)!',false),$diff,$diff_matches)))
 {$stripped_matches = attAspis(strlen(deAspis(Aspis_strip_tags(Aspis_join(array(' ',false),attachAspis($diff_matches,(0)))))));
$stripped_diff = array((strlen(deAspis(Aspis_strip_tags($diff))) * (2)) - $stripped_matches[0],false);
$diff_ratio = array($stripped_matches[0] / $stripped_diff[0],false);
if ( ($diff_ratio[0] > $this->_diff_threshold[0]))
 continue ;
}arrayAssign($orig_diffs[0],deAspis(registerTaint($o)),addTaint(Aspis_preg_replace(array('|<ins>.*?</ins>|',false),array('',false),$diff)));
arrayAssign($final_diffs[0],deAspis(registerTaint($f)),addTaint(Aspis_preg_replace(array('|<del>.*?</del>|',false),array('',false),$diff)));
}}}foreach ( deAspis(attAspisRC(array_keys(deAspisRC($orig_rows)))) as $row  )
{if ( ((deAspis(attachAspis($orig_rows,$row[0])) < (0)) && (deAspis(attachAspis($final_rows,$row[0])) < (0))))
 continue ;
$orig_line = ((isset($orig_diffs[0][deAspis(attachAspis($orig_rows,$row[0]))]) && Aspis_isset( $orig_diffs [0][deAspis(attachAspis( $orig_rows ,$row[0]))]))) ? attachAspis($orig_diffs,deAspis(attachAspis($orig_rows,$row[0]))) : Aspis_htmlspecialchars(attachAspis($orig,deAspis(attachAspis($orig_rows,$row[0]))));
$final_line = ((isset($final_diffs[0][deAspis(attachAspis($final_rows,$row[0]))]) && Aspis_isset( $final_diffs [0][deAspis(attachAspis( $final_rows ,$row[0]))]))) ? attachAspis($final_diffs,deAspis(attachAspis($final_rows,$row[0]))) : Aspis_htmlspecialchars(attachAspis($final,deAspis(attachAspis($final_rows,$row[0]))));
if ( (deAspis(attachAspis($orig_rows,$row[0])) < (0)))
 {$r = concat($r,$this->_added(array(array($final_line),false),array(false,false)));
}elseif ( (deAspis(attachAspis($final_rows,$row[0])) < (0)))
 {$r = concat($r,$this->_deleted(array(array($orig_line),false),array(false,false)));
}else 
{{$r = concat($r,concat2(concat(concat1('<tr>',$this->deletedLine($orig_line)),$this->addedLine($final_line)),"</tr>\n"));
}}}return $r;
} }
function interleave_changed_lines ( $orig,$final ) {
{$matches = array(array(),false);
foreach ( deAspis(attAspisRC(array_keys(deAspisRC($orig)))) as $o  )
{foreach ( deAspis(attAspisRC(array_keys(deAspisRC($final)))) as $f  )
{arrayAssign($matches[0],deAspis(registerTaint(concat(concat2($o,","),$f))),addTaint($this->compute_string_distance(attachAspis($orig,$o[0]),attachAspis($final,$f[0]))));
}}AspisInternalFunctionCall("asort",AspisPushRefParam($matches),array(0));
$orig_matches = array(array(),false);
$final_matches = array(array(),false);
foreach ( $matches[0] as $keys =>$difference )
{restoreTaint($keys,$difference);
{list($o,$f) = deAspisList(Aspis_explode(array(',',false),$keys),array());
$o = int_cast($o);
$f = int_cast($f);
if ( (((isset($orig_matches[0][$o[0]]) && Aspis_isset( $orig_matches [0][$o[0]]))) && ((isset($final_matches[0][$f[0]]) && Aspis_isset( $final_matches [0][$f[0]])))))
 continue ;
if ( ((!((isset($orig_matches[0][$o[0]]) && Aspis_isset( $orig_matches [0][$o[0]])))) && (!((isset($final_matches[0][$f[0]]) && Aspis_isset( $final_matches [0][$f[0]]))))))
 {arrayAssign($orig_matches[0],deAspis(registerTaint($o)),addTaint($f));
arrayAssign($final_matches[0],deAspis(registerTaint($f)),addTaint($o));
continue ;
}if ( ((isset($orig_matches[0][$o[0]]) && Aspis_isset( $orig_matches [0][$o[0]]))))
 arrayAssign($final_matches[0],deAspis(registerTaint($f)),addTaint(array('x',false)));
elseif ( ((isset($final_matches[0][$f[0]]) && Aspis_isset( $final_matches [0][$f[0]]))))
 arrayAssign($orig_matches[0],deAspis(registerTaint($o)),addTaint(array('x',false)));
}}Aspis_ksort($orig_matches);
Aspis_ksort($final_matches);
$orig_rows = $orig_rows_copy = attAspisRC(array_keys(deAspisRC($orig_matches)));
$final_rows = attAspisRC(array_keys(deAspisRC($final_matches)));
foreach ( $orig_rows_copy[0] as $orig_row  )
{$final_pos = Aspis_array_search(attachAspis($orig_matches,$orig_row[0]),$final_rows,array(true,false));
$orig_pos = int_cast(Aspis_array_search($orig_row,$orig_rows,array(true,false)));
if ( (false === $final_pos[0]))
 {Aspis_array_splice($final_rows,$orig_pos,array(0,false),negate(array(1,false)));
}elseif ( ($final_pos[0] < $orig_pos[0]))
 {$diff_pos = array($final_pos[0] - $orig_pos[0],false);
while ( ($diff_pos[0] < (0)) )
Aspis_array_splice($final_rows,$orig_pos,array(0,false),postincr($diff_pos));
}elseif ( ($final_pos[0] > $orig_pos[0]))
 {$diff_pos = array($orig_pos[0] - $final_pos[0],false);
while ( ($diff_pos[0] < (0)) )
Aspis_array_splice($orig_rows,$orig_pos,array(0,false),postincr($diff_pos));
}}$diff_count = array(count($orig_rows[0]) - count($final_rows[0]),false);
if ( ($diff_count[0] < (0)))
 {while ( ($diff_count[0] < (0)) )
Aspis_array_push($orig_rows,postincr($diff_count));
}elseif ( ($diff_count[0] > (0)))
 {$diff_count = array(deAspis(negate(array(1,false))) * $diff_count[0],false);
while ( ($diff_count[0] < (0)) )
Aspis_array_push($final_rows,postincr($diff_count));
}return array(array($orig_matches,$final_matches,$orig_rows,$final_rows),false);
} }
function compute_string_distance ( $string1,$string2 ) {
{$chars1 = attAspisRC(count_chars($string1[0]));
$chars2 = attAspisRC(count_chars($string2[0]));
$difference = attAspisRC(array_sum(deAspisRC(attAspisRC(array_map(AspisInternalCallback(array(array(array($this,false),array('difference',false)),false)),deAspisRC($chars1),deAspisRC($chars2))))));
if ( (denot_boolean($string1)))
 return $difference;
return array($difference[0] / strlen($string1[0]),false);
} }
function difference ( $a,$b ) {
{return Aspis_abs(array($a[0] - $b[0],false));
} }
}class WP_Text_Diff_Renderer_inline extends Text_Diff_Renderer_inline{function _splitOnWords ( $string,$newlineEscape = array("\n",false) ) {
{$string = Aspis_str_replace(array("\0",false),array('',false),$string);
$words = Aspis_preg_split(array('/([^\w])/u',false),$string,negate(array(1,false)),array(PREG_SPLIT_DELIM_CAPTURE,false));
$words = Aspis_str_replace(array("\n",false),$newlineEscape,$words);
return $words;
} }
};
?>
<?php 