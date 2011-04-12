<?php require_once('AspisMain.php'); ?><?php
class Text_Diff{var $_edits;
function Text_Diff ( $engine,$params ) {
{if ( !is_string($engine))
 {$params = array($engine,$params);
$engine = 'auto';
}if ( $engine == 'auto')
 {$engine = extension_loaded('xdiff') ? 'xdiff' : 'native';
}else 
{{$engine = basename($engine);
}}require_once dirname(__FILE__) . '/Diff/Engine/' . $engine . '.php';
$class = 'Text_Diff_Engine_' . $engine;
$diff_engine = AspisNewUnknownProxy($class,array( ),false);
$this->_edits = AspisUntainted_call_user_func_array(array($diff_engine,'diff'),$params);
} }
function getDiff (  ) {
{{$AspisRetTemp = $this->_edits;
return $AspisRetTemp;
}} }
function reverse (  ) {
{if ( version_compare(zend_version(),'2','>'))
 {$rev = clone ($this);
}else 
{{$rev = $this;
}}$rev->_edits = array();
foreach ( $this->_edits as $edit  )
{$rev->_edits[] = AspisReferenceMethodCall($edit,"reverse",array(),array());
}{$AspisRetTemp = $rev;
return $AspisRetTemp;
}} }
function isEmpty (  ) {
{foreach ( $this->_edits as $edit  )
{if ( !is_a($edit,'Text_Diff_Op_copy'))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function lcs (  ) {
{$lcs = 0;
foreach ( $this->_edits as $edit  )
{if ( is_a($edit,'Text_Diff_Op_copy'))
 {$lcs += count($edit->orig);
}}{$AspisRetTemp = $lcs;
return $AspisRetTemp;
}} }
function getOriginal (  ) {
{$lines = array();
foreach ( $this->_edits as $edit  )
{if ( $edit->orig)
 {array_splice($lines,count($lines),0,$edit->orig);
}}{$AspisRetTemp = $lines;
return $AspisRetTemp;
}} }
function getFinal (  ) {
{$lines = array();
foreach ( $this->_edits as $edit  )
{if ( $edit->final)
 {array_splice($lines,count($lines),0,$edit->final);
}}{$AspisRetTemp = $lines;
return $AspisRetTemp;
}} }
function trimNewlines ( &$line,$key ) {
{$line = str_replace(array("\n","\r"),'',$line);
} }
function _getTempDir (  ) {
{$tmp_locations = array('/tmp','/var/tmp','c:\WUTemp','c:\temp','c:\windows\temp','c:\winnt\temp');
$tmp = ini_get('upload_tmp_dir');
if ( !strlen($tmp))
 {$tmp = getenv('TMPDIR');
}while ( !strlen($tmp) && count($tmp_locations) )
{$tmp_check = array_shift($tmp_locations);
if ( @is_dir($tmp_check))
 {$tmp = $tmp_check;
}}{$AspisRetTemp = strlen($tmp) ? $tmp : false;
return $AspisRetTemp;
}} }
function _check ( $from_lines,$to_lines ) {
{if ( serialize($from_lines) != serialize($this->getOriginal()))
 {trigger_error("Reconstructed original doesn't match",E_USER_ERROR);
}if ( serialize($to_lines) != serialize($this->getFinal()))
 {trigger_error("Reconstructed final doesn't match",E_USER_ERROR);
}$rev = $this->reverse();
if ( serialize($to_lines) != serialize($rev->getOriginal()))
 {trigger_error("Reversed original doesn't match",E_USER_ERROR);
}if ( serialize($from_lines) != serialize($rev->getFinal()))
 {trigger_error("Reversed final doesn't match",E_USER_ERROR);
}$prevtype = null;
foreach ( $this->_edits as $edit  )
{if ( $prevtype == get_class($edit))
 {trigger_error("Edit sequence is non-optimal",E_USER_ERROR);
}$prevtype = get_class($edit);
}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
}class Text_MappedDiff extends Text_Diff{function Text_MappedDiff ( $from_lines,$to_lines,$mapped_from_lines,$mapped_to_lines ) {
{assert(count($from_lines) == count($mapped_from_lines));
assert(count($to_lines) == count($mapped_to_lines));
parent::Text_Diff($mapped_from_lines,$mapped_to_lines);
$xi = $yi = 0;
for ( $i = 0 ; $i < count($this->_edits) ; $i++ )
{$orig = &$this->_edits[$i]->orig;
if ( is_array($orig))
 {$orig = array_slice($from_lines,$xi,count($orig));
$xi += count($orig);
}$final = &$this->_edits[$i]->final;
if ( is_array($final))
 {$final = array_slice($to_lines,$yi,count($final));
$yi += count($final);
}}} }
}class Text_Diff_Op{var $orig;
var $final;
function &reverse (  ) {
{trigger_error('Abstract method',E_USER_ERROR);
} }
function norig (  ) {
{{$AspisRetTemp = $this->orig ? count($this->orig) : 0;
return $AspisRetTemp;
}} }
function nfinal (  ) {
{{$AspisRetTemp = $this->final ? count($this->final) : 0;
return $AspisRetTemp;
}} }
}class Text_Diff_Op_copy extends Text_Diff_Op{function Text_Diff_Op_copy ( $orig,$final = false ) {
{if ( !is_array($final))
 {$final = $orig;
}$this->orig = $orig;
$this->final = $final;
} }
function &reverse (  ) {
{$reverse = &new Text_Diff_Op_copy($this->final,$this->orig);
{$AspisRetTemp = &$reverse;
return $AspisRetTemp;
}} }
}class Text_Diff_Op_delete extends Text_Diff_Op{function Text_Diff_Op_delete ( $lines ) {
{$this->orig = $lines;
$this->final = false;
} }
function &reverse (  ) {
{$reverse = &new Text_Diff_Op_add($this->orig);
{$AspisRetTemp = &$reverse;
return $AspisRetTemp;
}} }
}class Text_Diff_Op_add extends Text_Diff_Op{function Text_Diff_Op_add ( $lines ) {
{$this->final = $lines;
$this->orig = false;
} }
function &reverse (  ) {
{$reverse = &new Text_Diff_Op_delete($this->final);
{$AspisRetTemp = &$reverse;
return $AspisRetTemp;
}} }
}class Text_Diff_Op_change extends Text_Diff_Op{function Text_Diff_Op_change ( $orig,$final ) {
{$this->orig = $orig;
$this->final = $final;
} }
function &reverse (  ) {
{$reverse = &new Text_Diff_Op_change($this->final,$this->orig);
{$AspisRetTemp = &$reverse;
return $AspisRetTemp;
}} }
}