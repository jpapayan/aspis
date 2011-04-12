<?php require_once('AspisMain.php'); ?><?php
class Text_Diff_Engine_string{function diff ( $diff,$mode = array('autodetect',false) ) {
{if ( ((($mode[0] != ('autodetect')) && ($mode[0] != ('context'))) && ($mode[0] != ('unified'))))
 {return PEAR::raiseError(array('Type of diff is unsupported',false));
}if ( ($mode[0] == ('autodetect')))
 {$context = attAspis(strpos($diff[0],'***'));
$unified = attAspis(strpos($diff[0],'---'));
if ( ($context[0] === $unified[0]))
 {return PEAR::raiseError(array('Type of diff could not be detected',false));
}elseif ( (($context[0] === false) || ($context[0] === false)))
 {$mode = ($context[0] !== false) ? array('context',false) : array('unified',false);
}else 
{{$mode = ($context[0] < $unified[0]) ? array('context',false) : array('unified',false);
}}}$diff = Aspis_explode(array("\n",false),$diff);
Aspis_array_shift($diff);
Aspis_array_shift($diff);
if ( ($mode[0] == ('context')))
 {return $this->parseContextDiff($diff);
}else 
{{return $this->parseUnifiedDiff($diff);
}}} }
function parseUnifiedDiff ( $diff ) {
{$edits = array(array(),false);
$end = array(count($diff[0]) - (1),false);
for ( $i = array(0,false) ; ($i[0] < $end[0]) ;  )
{$diff1 = array(array(),false);
switch ( deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(1,false))) ) {
case (' '):do {arrayAssignAdd($diff1[0][],addTaint(Aspis_substr(attachAspis($diff,$i[0]),array(1,false))));
}while (((deAspis(preincr($i)) < $end[0]) && (deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(1,false))) == (' '))) )
;
arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_copy($diff1),false)));
break ;
case ('+'):do {arrayAssignAdd($diff1[0][],addTaint(Aspis_substr(attachAspis($diff,$i[0]),array(1,false))));
}while (((deAspis(preincr($i)) < $end[0]) && (deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(1,false))) == ('+'))) )
;
arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_add($diff1),false)));
break ;
case ('-'):$diff2 = array(array(),false);
do {arrayAssignAdd($diff1[0][],addTaint(Aspis_substr(attachAspis($diff,$i[0]),array(1,false))));
}while (((deAspis(preincr($i)) < $end[0]) && (deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(1,false))) == ('-'))) )
;
while ( (($i[0] < $end[0]) && (deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(1,false))) == ('+'))) )
{arrayAssignAdd($diff2[0][],addTaint(Aspis_substr(attachAspis($diff,deAspis(postincr($i))),array(1,false))));
}if ( (count($diff2[0]) == (0)))
 {arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_delete($diff1),false)));
}else 
{{arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_change($diff1,$diff2),false)));
}}break ;
default :postincr($i);
break ;
 }
}return $edits;
} }
function parseContextDiff ( &$diff ) {
{$edits = array(array(),false);
$i = $max_i = $j = $max_j = array(0,false);
$end = array(count($diff[0]) - (1),false);
while ( (($i[0] < $end[0]) && ($j[0] < $end[0])) )
{while ( (($i[0] >= $max_i[0]) && ($j[0] >= $max_j[0])) )
{for ( $i = $j ; (($i[0] < $end[0]) && (deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(3,false))) == ('***'))) ; postincr($i) )
;
for ( $max_i = $i ; (($max_i[0] < $end[0]) && (deAspis(Aspis_substr(attachAspis($diff,$max_i[0]),array(0,false),array(3,false))) != ('---'))) ; postincr($max_i) )
;
for ( $j = $max_i ; (($j[0] < $end[0]) && (deAspis(Aspis_substr(attachAspis($diff,$j[0]),array(0,false),array(3,false))) == ('---'))) ; postincr($j) )
;
for ( $max_j = $j ; (($max_j[0] < $end[0]) && (deAspis(Aspis_substr(attachAspis($diff,$max_j[0]),array(0,false),array(3,false))) != ('***'))) ; postincr($max_j) )
;
}$array = array(array(),false);
while ( ((($i[0] < $max_i[0]) && ($j[0] < $max_j[0])) && (strcmp(deAspis(attachAspis($diff,$i[0])),deAspis(attachAspis($diff,$j[0]))) == (0))) )
{arrayAssignAdd($array[0][],addTaint(Aspis_substr(attachAspis($diff,$i[0]),array(2,false))));
postincr($i);
postincr($j);
}while ( (($i[0] < $max_i[0]) && (($max_j[0] - $j[0]) <= (1))) )
{if ( ((deAspis(attachAspis($diff,$i[0])) != ('')) && (deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(1,false))) != (' '))))
 {break ;
}arrayAssignAdd($array[0][],addTaint(Aspis_substr(attachAspis($diff,deAspis(postincr($i))),array(2,false))));
}while ( (($j[0] < $max_j[0]) && (($max_i[0] - $i[0]) <= (1))) )
{if ( ((deAspis(attachAspis($diff,$j[0])) != ('')) && (deAspis(Aspis_substr(attachAspis($diff,$j[0]),array(0,false),array(1,false))) != (' '))))
 {break ;
}arrayAssignAdd($array[0][],addTaint(Aspis_substr(attachAspis($diff,deAspis(postincr($j))),array(2,false))));
}if ( (count($array[0]) > (0)))
 {arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_copy($array),false)));
}if ( ($i[0] < $max_i[0]))
 {$diff1 = array(array(),false);
switch ( deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(1,false))) ) {
case ('!'):$diff2 = array(array(),false);
do {arrayAssignAdd($diff1[0][],addTaint(Aspis_substr(attachAspis($diff,$i[0]),array(2,false))));
if ( (($j[0] < $max_j[0]) && (deAspis(Aspis_substr(attachAspis($diff,$j[0]),array(0,false),array(1,false))) == ('!'))))
 {arrayAssignAdd($diff2[0][],addTaint(Aspis_substr(attachAspis($diff,deAspis(postincr($j))),array(2,false))));
}}while (((deAspis(preincr($i)) < $max_i[0]) && (deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(1,false))) == ('!'))) )
;
arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_change($diff1,$diff2),false)));
break ;
case ('+'):do {arrayAssignAdd($diff1[0][],addTaint(Aspis_substr(attachAspis($diff,$i[0]),array(2,false))));
}while (((deAspis(preincr($i)) < $max_i[0]) && (deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(1,false))) == ('+'))) )
;
arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_add($diff1),false)));
break ;
case ('-'):do {arrayAssignAdd($diff1[0][],addTaint(Aspis_substr(attachAspis($diff,$i[0]),array(2,false))));
}while (((deAspis(preincr($i)) < $max_i[0]) && (deAspis(Aspis_substr(attachAspis($diff,$i[0]),array(0,false),array(1,false))) == ('-'))) )
;
arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_delete($diff1),false)));
break ;
 }
}if ( ($j[0] < $max_j[0]))
 {$diff2 = array(array(),false);
switch ( deAspis(Aspis_substr(attachAspis($diff,$j[0]),array(0,false),array(1,false))) ) {
case ('+'):do {arrayAssignAdd($diff2[0][],addTaint(Aspis_substr(attachAspis($diff,deAspis(postincr($j))),array(2,false))));
}while ((($j[0] < $max_j[0]) && (deAspis(Aspis_substr(attachAspis($diff,$j[0]),array(0,false),array(1,false))) == ('+'))) )
;
arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_add($diff2),false)));
break ;
case ('-'):do {arrayAssignAdd($diff2[0][],addTaint(Aspis_substr(attachAspis($diff,deAspis(postincr($j))),array(2,false))));
}while ((($j[0] < $max_j[0]) && (deAspis(Aspis_substr(attachAspis($diff,$j[0]),array(0,false),array(1,false))) == ('-'))) )
;
arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_delete($diff2),false)));
break ;
 }
}}return $edits;
} }
}