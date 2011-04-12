<?php require_once('AspisMain.php'); ?><?php
class PSpellShell extends SpellChecker{function &checkWords ( $lang,$words ) {
{$cmd = $this->_getCMD($lang);
if ( deAspis($fh = attAspis(fopen($this->_tmpfile[0],("w")))))
 {fwrite($fh[0],("!\n"));
foreach ( $words[0] as $key =>$value )
{restoreTaint($key,$value);
fwrite($fh[0],(deconcat2(concat1("^",$value),"\n")));
}fclose($fh[0]);
}else 
{$this->throwError(array("PSpell support was not found.",false));
}$data = attAspis(shell_exec($cmd[0]));
@attAspis(unlink($this->_tmpfile[0]));
$returnData = array(array(),false);
$dataArr = Aspis_preg_split(array("/[\r\n]/",false),$data,negate(array(1,false)),array(PREG_SPLIT_NO_EMPTY,false));
foreach ( $dataArr[0] as $dstr  )
{$matches = array(array(),false);
if ( (strpos($dstr[0],"@") === (0)))
 continue ;
Aspis_preg_match(array("/\& ([^ ]+) .*/i",false),$dstr,$matches);
if ( (!((empty($matches[0][(1)]) || Aspis_empty( $matches [0][(1)])))))
 arrayAssignAdd($returnData[0][],addTaint(Aspis_utf8_encode(Aspis_trim(attachAspis($matches,(1))))));
}return $returnData;
} }
function &getSuggestions ( $lang,$word ) {
{$cmd = $this->_getCMD($lang);
if ( function_exists(("mb_convert_encoding")))
 $word = Aspis_mb_convert_encoding($word,array("ISO-8859-1",false),array(mb_detect_encoding(deAspisRC($word),"UTF-8"),false));
else 
{$word = Aspis_utf8_encode($word);
}if ( deAspis($fh = attAspis(fopen($this->_tmpfile[0],("w")))))
 {fwrite($fh[0],("!\n"));
fwrite($fh[0],(deconcat2(concat1("^",$word),"\n")));
fclose($fh[0]);
}else 
{$this->throwError(array("Error opening tmp file.",false));
}$data = attAspis(shell_exec($cmd[0]));
@attAspis(unlink($this->_tmpfile[0]));
$returnData = array(array(),false);
$dataArr = Aspis_preg_split(array("/\n/",false),$data,negate(array(1,false)),array(PREG_SPLIT_NO_EMPTY,false));
foreach ( $dataArr[0] as $dstr  )
{$matches = array(array(),false);
if ( (strpos($dstr[0],"@") === (0)))
 continue ;
Aspis_preg_match(array("/\&[^:]+:(.*)/i",false),$dstr,$matches);
if ( (!((empty($matches[0][(1)]) || Aspis_empty( $matches [0][(1)])))))
 {$words = Aspis_array_slice(Aspis_explode(array(',',false),attachAspis($matches,(1))),array(0,false),array(10,false));
for ( $i = array(0,false) ; ($i[0] < count($words[0])) ; postincr($i) )
arrayAssign($words[0],deAspis(registerTaint($i)),addTaint(Aspis_trim(attachAspis($words,$i[0]))));
return $words;
}}return array(array(),false);
} }
function _getCMD ( $lang ) {
{$this->_tmpfile = attAspis(tempnam($this->_config[0][('PSpellShell.tmp')][0],("tinyspell")));
if ( deAspis(Aspis_preg_match(array("#win#i",false),array(php_uname(),false))))
 return concat2(concat(concat2(concat(concat2($this->_config[0][('PSpellShell.aspell')]," -a --lang="),Aspis_escapeshellarg($lang))," --encoding=utf-8 -H < "),$this->_tmpfile)," 2>&1");
return concat(concat2(concat(concat2(concat1("cat ",$this->_tmpfile)," | "),$this->_config[0][('PSpellShell.aspell')])," -a --encoding=utf-8 -H --lang="),Aspis_escapeshellarg($lang));
} }
};
