<?php require_once('AspisMain.php'); ?><?php
class PSpellShell extends SpellChecker{function &checkWords ( $lang,$words ) {
{$cmd = $this->_getCMD($lang);
if ( $fh = fopen($this->_tmpfile,"w"))
 {fwrite($fh,"!\n");
foreach ( $words as $key =>$value )
fwrite($fh,"^" . $value . "\n");
fclose($fh);
}else 
{$this->throwError("PSpell support was not found.");
}$data = shell_exec($cmd);
@unlink($this->_tmpfile);
$returnData = array();
$dataArr = preg_split("/[\r\n]/",$data,-1,PREG_SPLIT_NO_EMPTY);
foreach ( $dataArr as $dstr  )
{$matches = array();
if ( strpos($dstr,"@") === 0)
 continue ;
preg_match("/\& ([^ ]+) .*/i",$dstr,$matches);
if ( !empty($matches[1]))
 $returnData[] = utf8_encode(trim($matches[1]));
}{$AspisRetTemp = &$returnData;
return $AspisRetTemp;
}} }
function &getSuggestions ( $lang,$word ) {
{$cmd = $this->_getCMD($lang);
if ( function_exists("mb_convert_encoding"))
 $word = mb_convert_encoding($word,"ISO-8859-1",mb_detect_encoding($word,"UTF-8"));
else 
{$word = utf8_encode($word);
}if ( $fh = fopen($this->_tmpfile,"w"))
 {fwrite($fh,"!\n");
fwrite($fh,"^$word\n");
fclose($fh);
}else 
{$this->throwError("Error opening tmp file.");
}$data = shell_exec($cmd);
@unlink($this->_tmpfile);
$returnData = array();
$dataArr = preg_split("/\n/",$data,-1,PREG_SPLIT_NO_EMPTY);
foreach ( $dataArr as $dstr  )
{$matches = array();
if ( strpos($dstr,"@") === 0)
 continue ;
preg_match("/\&[^:]+:(.*)/i",$dstr,$matches);
if ( !empty($matches[1]))
 {$words = array_slice(explode(',',$matches[1]),0,10);
for ( $i = 0 ; $i < count($words) ; $i++ )
$words[$i] = trim($words[$i]);
{$AspisRetTemp = &$words;
return $AspisRetTemp;
}}}{$AspisRetTemp = array();
return $AspisRetTemp;
}} }
function _getCMD ( $lang ) {
{$this->_tmpfile = tempnam($this->_config['PSpellShell.tmp'],"tinyspell");
if ( preg_match("#win#i",php_uname()))
 {$AspisRetTemp = $this->_config['PSpellShell.aspell'] . " -a --lang=" . escapeshellarg($lang) . " --encoding=utf-8 -H < " . $this->_tmpfile . " 2>&1";
return $AspisRetTemp;
}{$AspisRetTemp = "cat " . $this->_tmpfile . " | " . $this->_config['PSpellShell.aspell'] . " -a --encoding=utf-8 -H --lang=" . escapeshellarg($lang);
return $AspisRetTemp;
}} }
};
