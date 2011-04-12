<?php require_once('AspisMain.php'); ?><?php
class Text_Diff_Engine_string{function diff ( $diff,$mode = 'autodetect' ) {
{if ( $mode != 'autodetect' && $mode != 'context' && $mode != 'unified')
 {{$AspisRetTemp = PEAR::raiseError('Type of diff is unsupported');
return $AspisRetTemp;
}}if ( $mode == 'autodetect')
 {$context = strpos($diff,'***');
$unified = strpos($diff,'---');
if ( $context === $unified)
 {{$AspisRetTemp = PEAR::raiseError('Type of diff could not be detected');
return $AspisRetTemp;
}}elseif ( $context === false || $context === false)
 {$mode = $context !== false ? 'context' : 'unified';
}else 
{{$mode = $context < $unified ? 'context' : 'unified';
}}}$diff = explode("\n",$diff);
array_shift($diff);
array_shift($diff);
if ( $mode == 'context')
 {{$AspisRetTemp = $this->parseContextDiff($diff);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = $this->parseUnifiedDiff($diff);
return $AspisRetTemp;
}}}} }
function parseUnifiedDiff ( $diff ) {
{$edits = array();
$end = count($diff) - 1;
for ( $i = 0 ; $i < $end ;  )
{$diff1 = array();
switch ( substr($diff[$i],0,1) ) {
case ' ':do {$diff1[] = substr($diff[$i],1);
}while (++$i < $end && substr($diff[$i],0,1) == ' ' )
;
$edits[] = &new Text_Diff_Op_copy($diff1);
break ;
case '+':do {$diff1[] = substr($diff[$i],1);
}while (++$i < $end && substr($diff[$i],0,1) == '+' )
;
$edits[] = &new Text_Diff_Op_add($diff1);
break ;
case '-':$diff2 = array();
do {$diff1[] = substr($diff[$i],1);
}while (++$i < $end && substr($diff[$i],0,1) == '-' )
;
while ( $i < $end && substr($diff[$i],0,1) == '+' )
{$diff2[] = substr($diff[$i++],1);
}if ( count($diff2) == 0)
 {$edits[] = &new Text_Diff_Op_delete($diff1);
}else 
{{$edits[] = &new Text_Diff_Op_change($diff1,$diff2);
}}break ;
default :$i++;
break ;
 }
}{$AspisRetTemp = $edits;
return $AspisRetTemp;
}} }
function parseContextDiff ( &$diff ) {
{$edits = array();
$i = $max_i = $j = $max_j = 0;
$end = count($diff) - 1;
while ( $i < $end && $j < $end )
{while ( $i >= $max_i && $j >= $max_j )
{for ( $i = $j ; $i < $end && substr($diff[$i],0,3) == '***' ; $i++ )
;
for ( $max_i = $i ; $max_i < $end && substr($diff[$max_i],0,3) != '---' ; $max_i++ )
;
for ( $j = $max_i ; $j < $end && substr($diff[$j],0,3) == '---' ; $j++ )
;
for ( $max_j = $j ; $max_j < $end && substr($diff[$max_j],0,3) != '***' ; $max_j++ )
;
}$array = array();
while ( $i < $max_i && $j < $max_j && strcmp($diff[$i],$diff[$j]) == 0 )
{$array[] = substr($diff[$i],2);
$i++;
$j++;
}while ( $i < $max_i && ($max_j - $j) <= 1 )
{if ( $diff[$i] != '' && substr($diff[$i],0,1) != ' ')
 {break ;
}$array[] = substr($diff[$i++],2);
}while ( $j < $max_j && ($max_i - $i) <= 1 )
{if ( $diff[$j] != '' && substr($diff[$j],0,1) != ' ')
 {break ;
}$array[] = substr($diff[$j++],2);
}if ( count($array) > 0)
 {$edits[] = &new Text_Diff_Op_copy($array);
}if ( $i < $max_i)
 {$diff1 = array();
switch ( substr($diff[$i],0,1) ) {
case '!':$diff2 = array();
do {$diff1[] = substr($diff[$i],2);
if ( $j < $max_j && substr($diff[$j],0,1) == '!')
 {$diff2[] = substr($diff[$j++],2);
}}while (++$i < $max_i && substr($diff[$i],0,1) == '!' )
;
$edits[] = &new Text_Diff_Op_change($diff1,$diff2);
break ;
case '+':do {$diff1[] = substr($diff[$i],2);
}while (++$i < $max_i && substr($diff[$i],0,1) == '+' )
;
$edits[] = &new Text_Diff_Op_add($diff1);
break ;
case '-':do {$diff1[] = substr($diff[$i],2);
}while (++$i < $max_i && substr($diff[$i],0,1) == '-' )
;
$edits[] = &new Text_Diff_Op_delete($diff1);
break ;
 }
}if ( $j < $max_j)
 {$diff2 = array();
switch ( substr($diff[$j],0,1) ) {
case '+':do {$diff2[] = substr($diff[$j++],2);
}while ($j < $max_j && substr($diff[$j],0,1) == '+' )
;
$edits[] = &new Text_Diff_Op_add($diff2);
break ;
case '-':do {$diff2[] = substr($diff[$j++],2);
}while ($j < $max_j && substr($diff[$j],0,1) == '-' )
;
$edits[] = &new Text_Diff_Op_delete($diff2);
break ;
 }
}}{$AspisRetTemp = $edits;
return $AspisRetTemp;
}} }
}