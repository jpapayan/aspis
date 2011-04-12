<?php require_once('AspisMain.php'); ?><?php
class PSpell extends SpellChecker{function &checkWords ( $lang,$words ) {
{$plink = $this->_getPLink($lang);
$outWords = array();
foreach ( $words as $word  )
{if ( !pspell_check($plink,trim($word)))
 $outWords[] = utf8_encode($word);
}{$AspisRetTemp = &$outWords;
return $AspisRetTemp;
}} }
function &getSuggestions ( $lang,$word ) {
{$words = pspell_suggest($this->_getPLink($lang),$word);
for ( $i = 0 ; $i < count($words) ; $i++ )
$words[$i] = utf8_encode($words[$i]);
{$AspisRetTemp = &$words;
return $AspisRetTemp;
}} }
function &_getPLink ( $lang ) {
{if ( !function_exists("pspell_new"))
 $this->throwError("PSpell support not found in PHP installation.");
$plink = pspell_new($lang,$this->_config['PSpell.spelling'],$this->_config['PSpell.jargon'],$this->_config['PSpell.encoding'],$this->_config['PSpell.mode']);
if ( !$plink)
 $this->throwError("No PSpell link found opened.");
{$AspisRetTemp = &$plink;
return $AspisRetTemp;
}} }
};
?>
<?php 