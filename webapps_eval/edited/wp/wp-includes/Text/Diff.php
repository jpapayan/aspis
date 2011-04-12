<?php require_once('AspisMain.php'); ?><?php
class Text_Diff{var $_edits;
function Text_Diff ( $engine,$params ) {
{if ( (!(is_string(deAspisRC($engine)))))
 {$params = array(array($engine,$params),false);
$engine = array('auto',false);
}if ( ($engine[0] == ('auto')))
 {$engine = (extension_loaded('xdiff')) ? array('xdiff',false) : array('native',false);
}else 
{{$engine = Aspis_basename($engine);
}}require_once (deconcat2(concat(concat2(Aspis_dirname(array(__FILE__,false)),'/Diff/Engine/'),$engine),'.php'));
$class = concat1('Text_Diff_Engine_',$engine);
$diff_engine = array(new $class[0](),false);
$this->_edits = Aspis_call_user_func_array(array(array($diff_engine,array('diff',false)),false),$params);
} }
function getDiff (  ) {
{return $this->_edits;
} }
function reverse (  ) {
{if ( (version_compare(deAspisRC(array(zend_version(),false)),'2','>')))
 {$rev = array(clone (($this)),false);
}else 
{{$rev = array($this,false);
}}$rev[0]->_edits = array(array(),false);
foreach ( $this->_edits[0] as $edit  )
{arrayAssignAdd($rev[0]->_edits[0][],addTaint($edit[0]->reverse()));
}return $rev;
} }
function isEmpty (  ) {
{foreach ( $this->_edits[0] as $edit  )
{if ( (!(is_a(deAspisRC($edit),('Text_Diff_Op_copy')))))
 {return array(false,false);
}}return array(true,false);
} }
function lcs (  ) {
{$lcs = array(0,false);
foreach ( $this->_edits[0] as $edit  )
{if ( is_a(deAspisRC($edit),('Text_Diff_Op_copy')))
 {$lcs = array(count($edit[0]->orig[0]) + $lcs[0],false);
}}return $lcs;
} }
function getOriginal (  ) {
{$lines = array(array(),false);
foreach ( $this->_edits[0] as $edit  )
{if ( $edit[0]->orig[0])
 {Aspis_array_splice($lines,attAspis(count($lines[0])),array(0,false),$edit[0]->orig);
}}return $lines;
} }
function getFinal (  ) {
{$lines = array(array(),false);
foreach ( $this->_edits[0] as $edit  )
{if ( $edit[0]->final[0])
 {Aspis_array_splice($lines,attAspis(count($lines[0])),array(0,false),$edit[0]->final);
}}return $lines;
} }
function trimNewlines ( &$line,$key ) {
{$line = Aspis_str_replace(array(array(array("\n",false),array("\r",false)),false),array('',false),$line);
} }
function _getTempDir (  ) {
{$tmp_locations = array(array(array('/tmp',false),array('/var/tmp',false),array('c:\WUTemp',false),array('c:\temp',false),array('c:\windows\temp',false),array('c:\winnt\temp',false)),false);
$tmp = array(ini_get('upload_tmp_dir'),false);
if ( (!(strlen($tmp[0]))))
 {$tmp = array(getenv('TMPDIR'),false);
}while ( ((!(strlen($tmp[0]))) && count($tmp_locations[0])) )
{$tmp_check = Aspis_array_shift($tmp_locations);
if ( deAspis(@attAspis(is_dir($tmp_check[0]))))
 {$tmp = $tmp_check;
}}return strlen($tmp[0]) ? $tmp : array(false,false);
} }
function _check ( $from_lines,$to_lines ) {
{if ( (deAspis(Aspis_serialize($from_lines)) != deAspis(Aspis_serialize($this->getOriginal()))))
 {trigger_error("Reconstructed original doesn't match",E_USER_ERROR);
}if ( (deAspis(Aspis_serialize($to_lines)) != deAspis(Aspis_serialize($this->getFinal()))))
 {trigger_error("Reconstructed final doesn't match",E_USER_ERROR);
}$rev = $this->reverse();
if ( (deAspis(Aspis_serialize($to_lines)) != deAspis(Aspis_serialize($rev[0]->getOriginal()))))
 {trigger_error("Reversed original doesn't match",E_USER_ERROR);
}if ( (deAspis(Aspis_serialize($from_lines)) != deAspis(Aspis_serialize($rev[0]->getFinal()))))
 {trigger_error("Reversed final doesn't match",E_USER_ERROR);
}$prevtype = array(null,false);
foreach ( $this->_edits[0] as $edit  )
{if ( ($prevtype[0] == get_class(deAspisRC($edit))))
 {trigger_error("Edit sequence is non-optimal",E_USER_ERROR);
}$prevtype = attAspis(get_class(deAspisRC($edit)));
}return array(true,false);
} }
}class Text_MappedDiff extends Text_Diff{function Text_MappedDiff ( $from_lines,$to_lines,$mapped_from_lines,$mapped_to_lines ) {
{assert(deAspisRC(array(count($from_lines[0]) == count($mapped_from_lines[0]),false)));
assert(deAspisRC(array(count($to_lines[0]) == count($mapped_to_lines[0]),false)));
parent::Text_Diff($mapped_from_lines,$mapped_to_lines);
$xi = $yi = array(0,false);
for ( $i = array(0,false) ; ($i[0] < count($this->_edits[0])) ; postincr($i) )
{$orig = &$this->_edits[0][$i[0]][0]->orig;
if ( is_array($orig[0]))
 {$orig = Aspis_array_slice($from_lines,$xi,attAspis(count($orig[0])));
$xi = array(count($orig[0]) + $xi[0],false);
}$final = &$this->_edits[0][$i[0]][0]->final;
if ( is_array($final[0]))
 {$final = Aspis_array_slice($to_lines,$yi,attAspis(count($final[0])));
$yi = array(count($final[0]) + $yi[0],false);
}}} }
}class Text_Diff_Op{var $orig;
var $final;
function &reverse (  ) {
{trigger_error('Abstract method',E_USER_ERROR);
} }
function norig (  ) {
{return $this->orig[0] ? attAspis(count($this->orig[0])) : array(0,false);
} }
function nfinal (  ) {
{return $this->final[0] ? attAspis(count($this->final[0])) : array(0,false);
} }
}class Text_Diff_Op_copy extends Text_Diff_Op{function Text_Diff_Op_copy ( $orig,$final = array(false,false) ) {
{if ( (!(is_array($final[0]))))
 {$final = $orig;
}$this->orig = $orig;
$this->final = $final;
} }
function &reverse (  ) {
{$reverse = array(new Text_Diff_Op_copy($this->final,$this->orig),false);
return $reverse;
} }
}class Text_Diff_Op_delete extends Text_Diff_Op{function Text_Diff_Op_delete ( $lines ) {
{$this->orig = $lines;
$this->final = array(false,false);
} }
function &reverse (  ) {
{$reverse = array(new Text_Diff_Op_add($this->orig),false);
return $reverse;
} }
}class Text_Diff_Op_add extends Text_Diff_Op{function Text_Diff_Op_add ( $lines ) {
{$this->final = $lines;
$this->orig = array(false,false);
} }
function &reverse (  ) {
{$reverse = array(new Text_Diff_Op_delete($this->final),false);
return $reverse;
} }
}class Text_Diff_Op_change extends Text_Diff_Op{function Text_Diff_Op_change ( $orig,$final ) {
{$this->orig = $orig;
$this->final = $final;
} }
function &reverse (  ) {
{$reverse = array(new Text_Diff_Op_change($this->final,$this->orig),false);
return $reverse;
} }
}