<?php require_once('AspisMain.php'); ?><?php
class Text_Diff_Engine_xdiff{function diff ( $from_lines,$to_lines ) {
{Aspis_array_walk($from_lines,array(array(array('Text_Diff',false),array('trimNewlines',false)),false));
Aspis_array_walk($to_lines,array(array(array('Text_Diff',false),array('trimNewlines',false)),false));
$from_string = Aspis_implode(array("\n",false),$from_lines);
$to_string = Aspis_implode(array("\n",false),$to_lines);
$diff = array(xdiff_string_diff(deAspisRC($from_string),deAspisRC($to_string),deAspisRC(attAspis(count($to_lines[0])))),false);
$diff = Aspis_explode(array("\n",false),$diff);
$edits = array(array(),false);
foreach ( $diff[0] as $line  )
{switch ( deAspis(attachAspis($line,(0))) ) {
case (' '):arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_copy(array(array(Aspis_substr($line,array(1,false))),false)),false)));
break ;
case ('+'):arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_add(array(array(Aspis_substr($line,array(1,false))),false)),false)));
break ;
case ('-'):arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_delete(array(array(Aspis_substr($line,array(1,false))),false)),false)));
break ;
 }
}return $edits;
} }
}