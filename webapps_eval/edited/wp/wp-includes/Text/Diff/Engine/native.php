<?php require_once('AspisMain.php'); ?><?php
class Text_Diff_Engine_native{function diff ( $from_lines,$to_lines ) {
{Aspis_array_walk($from_lines,array(array(array('Text_Diff',false),array('trimNewlines',false)),false));
Aspis_array_walk($to_lines,array(array(array('Text_Diff',false),array('trimNewlines',false)),false));
$n_from = attAspis(count($from_lines[0]));
$n_to = attAspis(count($to_lines[0]));
$this->xchanged = $this->ychanged = array(array(),false);
$this->xv = $this->yv = array(array(),false);
$this->xind = $this->yind = array(array(),false);
unset($this->seq);
unset($this->in_seq);
unset($this->lcs);
for ( $skip = array(0,false) ; (($skip[0] < $n_from[0]) && ($skip[0] < $n_to[0])) ; postincr($skip) )
{if ( (deAspis(attachAspis($from_lines,$skip[0])) !== deAspis(attachAspis($to_lines,$skip[0]))))
 {break ;
}arrayAssign($this->xchanged[0],deAspis(registerTaint($skip)),addTaint(arrayAssign($this->ychanged[0],deAspis(registerTaint($skip)),addTaint(array(false,false)))));
}$xi = $n_from;
$yi = $n_to;
for ( $endskip = array(0,false) ; ((deAspis(predecr($xi)) > $skip[0]) && (deAspis(predecr($yi)) > $skip[0])) ; postincr($endskip) )
{if ( (deAspis(attachAspis($from_lines,$xi[0])) !== deAspis(attachAspis($to_lines,$yi[0]))))
 {break ;
}arrayAssign($this->xchanged[0],deAspis(registerTaint($xi)),addTaint(arrayAssign($this->ychanged[0],deAspis(registerTaint($yi)),addTaint(array(false,false)))));
}for ( $xi = $skip ; ($xi[0] < ($n_from[0] - $endskip[0])) ; postincr($xi) )
{arrayAssign($xhash[0],deAspis(registerTaint(attachAspis($from_lines,$xi[0]))),addTaint(array(1,false)));
}for ( $yi = $skip ; ($yi[0] < ($n_to[0] - $endskip[0])) ; postincr($yi) )
{$line = attachAspis($to_lines,$yi[0]);
if ( deAspis((arrayAssign($this->ychanged[0],deAspis(registerTaint($yi)),addTaint(array((empty($xhash[0][$line[0]]) || Aspis_empty( $xhash [0][$line[0]])),false))))))
 {continue ;
}arrayAssign($yhash[0],deAspis(registerTaint($line)),addTaint(array(1,false)));
arrayAssignAdd($this->yv[0][],addTaint($line));
arrayAssignAdd($this->yind[0][],addTaint($yi));
}for ( $xi = $skip ; ($xi[0] < ($n_from[0] - $endskip[0])) ; postincr($xi) )
{$line = attachAspis($from_lines,$xi[0]);
if ( deAspis((arrayAssign($this->xchanged[0],deAspis(registerTaint($xi)),addTaint(array((empty($yhash[0][$line[0]]) || Aspis_empty( $yhash [0][$line[0]])),false))))))
 {continue ;
}arrayAssignAdd($this->xv[0][],addTaint($line));
arrayAssignAdd($this->xind[0][],addTaint($xi));
}$this->_compareseq(array(0,false),attAspis(count($this->xv[0])),array(0,false),attAspis(count($this->yv[0])));
$this->_shiftBoundaries($from_lines,$this->xchanged,$this->ychanged);
$this->_shiftBoundaries($to_lines,$this->ychanged,$this->xchanged);
$edits = array(array(),false);
$xi = $yi = array(0,false);
while ( (($xi[0] < $n_from[0]) || ($yi[0] < $n_to[0])) )
{assert(deAspisRC(array(($yi[0] < $n_to[0]) || $this->xchanged[0][$xi[0]][0],false)));
assert(deAspisRC(array(($xi[0] < $n_from[0]) || $this->ychanged[0][$yi[0]][0],false)));
$copy = array(array(),false);
while ( (((($xi[0] < $n_from[0]) && ($yi[0] < $n_to[0])) && (denot_boolean($this->xchanged[0][$xi[0]]))) && (denot_boolean($this->ychanged[0][$yi[0]]))) )
{arrayAssignAdd($copy[0][],addTaint(attachAspis($from_lines,deAspis(postincr($xi)))));
preincr($yi);
}if ( $copy[0])
 {arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_copy($copy),false)));
}$delete = array(array(),false);
while ( (($xi[0] < $n_from[0]) && $this->xchanged[0][$xi[0]][0]) )
{arrayAssignAdd($delete[0][],addTaint(attachAspis($from_lines,deAspis(postincr($xi)))));
}$add = array(array(),false);
while ( (($yi[0] < $n_to[0]) && $this->ychanged[0][$yi[0]][0]) )
{arrayAssignAdd($add[0][],addTaint(attachAspis($to_lines,deAspis(postincr($yi)))));
}if ( ($delete[0] && $add[0]))
 {arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_change($delete,$add),false)));
}elseif ( $delete[0])
 {arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_delete($delete),false)));
}elseif ( $add[0])
 {arrayAssignAdd($edits[0][],addTaint(array(new Text_Diff_Op_add($add),false)));
}}return $edits;
} }
function _diag ( $xoff,$xlim,$yoff,$ylim,$nchunks ) {
{$flip = array(false,false);
if ( (($xlim[0] - $xoff[0]) > ($ylim[0] - $yoff[0])))
 {$flip = array(true,false);
list($xoff,$xlim,$yoff,$ylim) = deAspisList(array(array($yoff,$ylim,$xoff,$xlim),false),array());
}if ( $flip[0])
 {for ( $i = array($ylim[0] - (1),false) ; ($i[0] >= $yoff[0]) ; postdecr($i) )
{arrayAssignAdd($ymatches[0][$this->xv[0][$i[0]][0]][0][],addTaint($i));
}}else 
{{for ( $i = array($ylim[0] - (1),false) ; ($i[0] >= $yoff[0]) ; postdecr($i) )
{arrayAssignAdd($ymatches[0][$this->yv[0][$i[0]][0]][0][],addTaint($i));
}}}$this->lcs = array(0,false);
arrayAssign($this->seq[0],deAspis(registerTaint(array(0,false))),addTaint(array($yoff[0] - (1),false)));
$this->in_seq = array(array(),false);
arrayAssign($ymids[0],deAspis(registerTaint(array(0,false))),addTaint(array(array(),false)));
$numer = array((($xlim[0] - $xoff[0]) + $nchunks[0]) - (1),false);
$x = $xoff;
for ( $chunk = array(0,false) ; ($chunk[0] < $nchunks[0]) ; postincr($chunk) )
{if ( ($chunk[0] > (0)))
 {for ( $i = array(0,false) ; ($i[0] <= $this->lcs[0]) ; postincr($i) )
{arrayAssign($ymids[0][$i[0]][0],deAspis(registerTaint(array($chunk[0] - (1),false))),addTaint($this->seq[0][$i[0]]));
}}$x1 = array($xoff[0] + deAspis(int_cast((array(($numer[0] + (($xlim[0] - $xoff[0]) * $chunk[0])) / $nchunks[0],false)))),false);
for (  ; ($x[0] < $x1[0]) ; postincr($x) )
{$line = $flip[0] ? $this->yv[0][$x[0]] : $this->xv[0][$x[0]];
if ( ((empty($ymatches[0][$line[0]]) || Aspis_empty( $ymatches [0][$line[0]]))))
 {continue ;
}$matches = attachAspis($ymatches,$line[0]);
Aspis_reset($matches);
while ( deAspis(list(,$y) = deAspisList(Aspis_each($matches),array())) )
{if ( ((empty($this->in_seq[0][$y[0]]) || Aspis_empty( $this ->in_seq [0][$y[0]] ))))
 {$k = $this->_lcsPos($y);
assert(deAspisRC(array($k[0] > (0),false)));
arrayAssign($ymids[0],deAspis(registerTaint($k)),addTaint(attachAspis($ymids,($k[0] - (1)))));
break ;
}}while ( deAspis(list(,$y) = deAspisList(Aspis_each($matches),array())) )
{if ( ($y[0] > $this->seq[0][($k[0] - (1))][0]))
 {assert(deAspisRC(array($y[0] <= $this->seq[0][$k[0]][0],false)));
arrayAssign($this->in_seq[0],deAspis(registerTaint($this->seq[0][$k[0]])),addTaint(array(false,false)));
arrayAssign($this->seq[0],deAspis(registerTaint($k)),addTaint($y));
arrayAssign($this->in_seq[0],deAspis(registerTaint($y)),addTaint(array(1,false)));
}elseif ( ((empty($this->in_seq[0][$y[0]]) || Aspis_empty( $this ->in_seq [0][$y[0]] ))))
 {$k = $this->_lcsPos($y);
assert(deAspisRC(array($k[0] > (0),false)));
arrayAssign($ymids[0],deAspis(registerTaint($k)),addTaint(attachAspis($ymids,($k[0] - (1)))));
}}}}arrayAssignAdd($seps[0][],addTaint($flip[0] ? array(array($yoff,$xoff),false) : array(array($xoff,$yoff),false)));
$ymid = attachAspis($ymids,$this->lcs[0]);
for ( $n = array(0,false) ; ($n[0] < ($nchunks[0] - (1))) ; postincr($n) )
{$x1 = array($xoff[0] + deAspis(int_cast((array(($numer[0] + (($xlim[0] - $xoff[0]) * $n[0])) / $nchunks[0],false)))),false);
$y1 = array(deAspis(attachAspis($ymid,$n[0])) + (1),false);
arrayAssignAdd($seps[0][],addTaint($flip[0] ? array(array($y1,$x1),false) : array(array($x1,$y1),false)));
}arrayAssignAdd($seps[0][],addTaint($flip[0] ? array(array($ylim,$xlim),false) : array(array($xlim,$ylim),false)));
return array(array($this->lcs,$seps),false);
} }
function _lcsPos ( $ypos ) {
{$end = $this->lcs;
if ( (($end[0] == (0)) || ($ypos[0] > $this->seq[0][$end[0]][0])))
 {arrayAssign($this->seq[0],deAspis(registerTaint(preincr($this->lcs))),addTaint($ypos));
arrayAssign($this->in_seq[0],deAspis(registerTaint($ypos)),addTaint(array(1,false)));
return $this->lcs;
}$beg = array(1,false);
while ( ($beg[0] < $end[0]) )
{$mid = int_cast((array(($beg[0] + $end[0]) / (2),false)));
if ( ($ypos[0] > $this->seq[0][$mid[0]][0]))
 {$beg = array($mid[0] + (1),false);
}else 
{{$end = $mid;
}}}assert(deAspisRC(array($ypos[0] != $this->seq[0][$end[0]][0],false)));
arrayAssign($this->in_seq[0],deAspis(registerTaint($this->seq[0][$end[0]])),addTaint(array(false,false)));
arrayAssign($this->seq[0],deAspis(registerTaint($end)),addTaint($ypos));
arrayAssign($this->in_seq[0],deAspis(registerTaint($ypos)),addTaint(array(1,false)));
return $end;
} }
function _compareseq ( $xoff,$xlim,$yoff,$ylim ) {
{while ( ((($xoff[0] < $xlim[0]) && ($yoff[0] < $ylim[0])) && ($this->xv[0][$xoff[0]][0] == $this->yv[0][$yoff[0]][0])) )
{preincr($xoff);
preincr($yoff);
}while ( ((($xlim[0] > $xoff[0]) && ($ylim[0] > $yoff[0])) && ($this->xv[0][($xlim[0] - (1))][0] == $this->yv[0][($ylim[0] - (1))][0])) )
{predecr($xlim);
predecr($ylim);
}if ( (($xoff[0] == $xlim[0]) || ($yoff[0] == $ylim[0])))
 {$lcs = array(0,false);
}else 
{{$nchunks = array(deAspis(attAspisRC(min(7,deAspisRC(array($xlim[0] - $xoff[0],false)),deAspisRC(array($ylim[0] - $yoff[0],false))))) + (1),false);
list($lcs,$seps) = deAspisList($this->_diag($xoff,$xlim,$yoff,$ylim,$nchunks),array());
}}if ( ($lcs[0] == (0)))
 {while ( ($yoff[0] < $ylim[0]) )
{arrayAssign($this->ychanged[0][deAspis(registerTaint($this->yind[0]))],deAspis(postincr($yoff)),addTaint(array(1,false)));
}while ( ($xoff[0] < $xlim[0]) )
{arrayAssign($this->xchanged[0][deAspis(registerTaint($this->xind[0]))],deAspis(postincr($xoff)),addTaint(array(1,false)));
}}else 
{{Aspis_reset($seps);
$pt1 = attachAspis($seps,(0));
while ( deAspis($pt2 = Aspis_next($seps)) )
{$this->_compareseq(attachAspis($pt1,(0)),attachAspis($pt2,(0)),attachAspis($pt1,(1)),attachAspis($pt2,(1)));
$pt1 = $pt2;
}}}} }
function _shiftBoundaries ( $lines,&$changed,$other_changed ) {
{$i = array(0,false);
$j = array(0,false);
assert('count($lines) == count($changed)');
$len = attAspis(count($lines[0]));
$other_len = attAspis(count($other_changed[0]));
while ( (1) )
{while ( (($j[0] < $other_len[0]) && deAspis(attachAspis($other_changed,$j[0]))) )
{postincr($j);
}while ( (($i[0] < $len[0]) && (denot_boolean(attachAspis($changed,$i[0])))) )
{assert('$j < $other_len && ! $other_changed[$j]');
postincr($i);
postincr($j);
while ( (($j[0] < $other_len[0]) && deAspis(attachAspis($other_changed,$j[0]))) )
{postincr($j);
}}if ( ($i[0] == $len[0]))
 {break ;
}$start = $i;
while ( ((deAspis(preincr($i)) < $len[0]) && deAspis(attachAspis($changed,$i[0]))) )
{continue ;
}do {$runlength = array($i[0] - $start[0],false);
while ( (($start[0] > (0)) && (deAspis(attachAspis($lines,($start[0] - (1)))) == deAspis(attachAspis($lines,($i[0] - (1)))))) )
{arrayAssign($changed[0],deAspis(registerTaint(predecr($start))),addTaint(array(1,false)));
arrayAssign($changed[0],deAspis(registerTaint(predecr($i))),addTaint(array(false,false)));
while ( (($start[0] > (0)) && deAspis(attachAspis($changed,($start[0] - (1))))) )
{postdecr($start);
}assert('$j > 0');
while ( deAspis(attachAspis($other_changed,deAspis(predecr($j)))) )
{continue ;
}assert('$j >= 0 && !$other_changed[$j]');
}$corresponding = ($j[0] < $other_len[0]) ? $i : $len;
while ( (($i[0] < $len[0]) && (deAspis(attachAspis($lines,$start[0])) == deAspis(attachAspis($lines,$i[0])))) )
{arrayAssign($changed[0],deAspis(registerTaint(postincr($start))),addTaint(array(false,false)));
arrayAssign($changed[0],deAspis(registerTaint(postincr($i))),addTaint(array(1,false)));
while ( (($i[0] < $len[0]) && deAspis(attachAspis($changed,$i[0]))) )
{postincr($i);
}assert('$j < $other_len && ! $other_changed[$j]');
postincr($j);
if ( (($j[0] < $other_len[0]) && deAspis(attachAspis($other_changed,$j[0]))))
 {$corresponding = $i;
while ( (($j[0] < $other_len[0]) && deAspis(attachAspis($other_changed,$j[0]))) )
{postincr($j);
}}}}while (($runlength[0] != ($i[0] - $start[0])) )
;
while ( ($corresponding[0] < $i[0]) )
{arrayAssign($changed[0],deAspis(registerTaint(predecr($start))),addTaint(array(1,false)));
arrayAssign($changed[0],deAspis(registerTaint(predecr($i))),addTaint(array(0,false)));
assert('$j > 0');
while ( deAspis(attachAspis($other_changed,deAspis(predecr($j)))) )
{continue ;
}assert('$j >= 0 && !$other_changed[$j]');
}}} }
}