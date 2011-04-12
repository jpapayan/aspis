<?php require_once('AspisMain.php'); ?><?php
class Text_Diff_Engine_shell{var $_diffCommand = 'diff';
function diff ( $from_lines,$to_lines ) {
{AspisUntainted_array_walk($from_lines,array('Text_Diff','trimNewlines'));
AspisUntainted_array_walk($to_lines,array('Text_Diff','trimNewlines'));
$temp_dir = Text_Diff::_getTempDir();
$from_file = tempnam($temp_dir,'Text_Diff');
$to_file = tempnam($temp_dir,'Text_Diff');
$fp = fopen($from_file,'w');
fwrite($fp,implode("\n",$from_lines));
fclose($fp);
$fp = fopen($to_file,'w');
fwrite($fp,implode("\n",$to_lines));
fclose($fp);
$diff = shell_exec($this->_diffCommand . ' ' . $from_file . ' ' . $to_file);
unlink($from_file);
unlink($to_file);
if ( is_null($diff))
 {{$AspisRetTemp = array(new Text_Diff_Op_copy($from_lines));
return $AspisRetTemp;
}}$from_line_no = 1;
$to_line_no = 1;
$edits = array();
preg_match_all('#^(\d+)(?:,(\d+))?([adc])(\d+)(?:,(\d+))?$#m',$diff,$matches,PREG_SET_ORDER);
foreach ( $matches as $match  )
{if ( !isset($match[5]))
 {$match[5] = false;
}if ( $match[3] == 'a')
 {$from_line_no--;
}if ( $match[3] == 'd')
 {$to_line_no--;
}if ( $from_line_no < $match[1] || $to_line_no < $match[4])
 {assert('$match[1] - $from_line_no == $match[4] - $to_line_no');
array_push($edits,new Text_Diff_Op_copy($this->_getLines($from_lines,$from_line_no,$match[1] - 1),$this->_getLines($to_lines,$to_line_no,$match[4] - 1)));
}switch ( $match[3] ) {
case 'd':array_push($edits,new Text_Diff_Op_delete($this->_getLines($from_lines,$from_line_no,$match[2])));
$to_line_no++;
break ;
case 'c':array_push($edits,new Text_Diff_Op_change($this->_getLines($from_lines,$from_line_no,$match[2]),$this->_getLines($to_lines,$to_line_no,$match[5])));
break ;
case 'a':array_push($edits,new Text_Diff_Op_add($this->_getLines($to_lines,$to_line_no,$match[5])));
$from_line_no++;
break ;
 }
}if ( !empty($from_lines))
 {array_push($edits,new Text_Diff_Op_copy($this->_getLines($from_lines,$from_line_no,$from_line_no + count($from_lines) - 1),$this->_getLines($to_lines,$to_line_no,$to_line_no + count($to_lines) - 1)));
}{$AspisRetTemp = $edits;
return $AspisRetTemp;
}} }
function _getLines ( &$text_lines,&$line_no,$end = false ) {
{if ( !empty($end))
 {$lines = array();
while ( $line_no <= $end )
{array_push($lines,array_shift($text_lines));
$line_no++;
}}else 
{{$lines = array(array_shift($text_lines));
$line_no++;
}}{$AspisRetTemp = $lines;
return $AspisRetTemp;
}} }
}