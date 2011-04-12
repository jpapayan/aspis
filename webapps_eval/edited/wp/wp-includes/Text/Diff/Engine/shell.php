<?php require_once('AspisMain.php'); ?><?php
class Text_Diff_Engine_shell{var $_diffCommand = array('diff',false);
function diff ( $from_lines,$to_lines ) {
{Aspis_array_walk($from_lines,array(array(array('Text_Diff',false),array('trimNewlines',false)),false));
Aspis_array_walk($to_lines,array(array(array('Text_Diff',false),array('trimNewlines',false)),false));
$temp_dir = Text_Diff::_getTempDir();
$from_file = attAspis(tempnam($temp_dir[0],('Text_Diff')));
$to_file = attAspis(tempnam($temp_dir[0],('Text_Diff')));
$fp = attAspis(fopen($from_file[0],('w')));
fwrite($fp[0],deAspis(Aspis_implode(array("\n",false),$from_lines)));
fclose($fp[0]);
$fp = attAspis(fopen($to_file[0],('w')));
fwrite($fp[0],deAspis(Aspis_implode(array("\n",false),$to_lines)));
fclose($fp[0]);
$diff = attAspis(shell_exec((deconcat(concat2(concat(concat2($this->_diffCommand,' '),$from_file),' '),$to_file))));
unlink($from_file[0]);
unlink($to_file[0]);
if ( is_null(deAspisRC($diff)))
 {return array(array(array(new Text_Diff_Op_copy($from_lines),false)),false);
}$from_line_no = array(1,false);
$to_line_no = array(1,false);
$edits = array(array(),false);
Aspis_preg_match_all(array('#^(\d+)(?:,(\d+))?([adc])(\d+)(?:,(\d+))?$#m',false),$diff,$matches,array(PREG_SET_ORDER,false));
foreach ( $matches[0] as $match  )
{if ( (!((isset($match[0][(5)]) && Aspis_isset( $match [0][(5)])))))
 {arrayAssign($match[0],deAspis(registerTaint(array(5,false))),addTaint(array(false,false)));
}if ( (deAspis(attachAspis($match,(3))) == ('a')))
 {postdecr($from_line_no);
}if ( (deAspis(attachAspis($match,(3))) == ('d')))
 {postdecr($to_line_no);
}if ( (($from_line_no[0] < deAspis(attachAspis($match,(1)))) || ($to_line_no[0] < deAspis(attachAspis($match,(4))))))
 {assert('$match[1] - $from_line_no == $match[4] - $to_line_no');
Aspis_array_push($edits,array(new Text_Diff_Op_copy($this->_getLines($from_lines,$from_line_no,array(deAspis(attachAspis($match,(1))) - (1),false)),$this->_getLines($to_lines,$to_line_no,array(deAspis(attachAspis($match,(4))) - (1),false))),false));
}switch ( deAspis(attachAspis($match,(3))) ) {
case ('d'):Aspis_array_push($edits,array(new Text_Diff_Op_delete($this->_getLines($from_lines,$from_line_no,attachAspis($match,(2)))),false));
postincr($to_line_no);
break ;
case ('c'):Aspis_array_push($edits,array(new Text_Diff_Op_change($this->_getLines($from_lines,$from_line_no,attachAspis($match,(2))),$this->_getLines($to_lines,$to_line_no,attachAspis($match,(5)))),false));
break ;
case ('a'):Aspis_array_push($edits,array(new Text_Diff_Op_add($this->_getLines($to_lines,$to_line_no,attachAspis($match,(5)))),false));
postincr($from_line_no);
break ;
 }
}if ( (!((empty($from_lines) || Aspis_empty( $from_lines)))))
 {Aspis_array_push($edits,array(new Text_Diff_Op_copy($this->_getLines($from_lines,$from_line_no,array(($from_line_no[0] + count($from_lines[0])) - (1),false)),$this->_getLines($to_lines,$to_line_no,array(($to_line_no[0] + count($to_lines[0])) - (1),false))),false));
}return $edits;
} }
function _getLines ( &$text_lines,&$line_no,$end = array(false,false) ) {
{if ( (!((empty($end) || Aspis_empty( $end)))))
 {$lines = array(array(),false);
while ( ($line_no[0] <= $end[0]) )
{Aspis_array_push($lines,Aspis_array_shift($text_lines));
postincr($line_no);
}}else 
{{$lines = array(array(Aspis_array_shift($text_lines)),false);
postincr($line_no);
}}return $lines;
} }
}