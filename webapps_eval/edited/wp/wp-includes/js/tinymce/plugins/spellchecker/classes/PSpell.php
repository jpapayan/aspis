<?php require_once('AspisMain.php'); ?><?php
class PSpell extends SpellChecker{function &checkWords ( $lang,$words ) {
{$plink = $this->_getPLink($lang);
$outWords = array(array(),false);
foreach ( $words[0] as $word  )
{if ( (!(pspell_check(deAspisRC($plink),deAspisRC(Aspis_trim($word))))))
 arrayAssignAdd($outWords[0][],addTaint(Aspis_utf8_encode($word)));
}return $outWords;
} }
function &getSuggestions ( $lang,$word ) {
{$words = array(pspell_suggest(deAspisRC($this->_getPLink($lang)),deAspisRC($word)),false);
for ( $i = array(0,false) ; ($i[0] < count($words[0])) ; postincr($i) )
arrayAssign($words[0],deAspis(registerTaint($i)),addTaint(Aspis_utf8_encode(attachAspis($words,$i[0]))));
return $words;
} }
function &_getPLink ( $lang ) {
{if ( (!(function_exists(("pspell_new")))))
 $this->throwError(array("PSpell support not found in PHP installation.",false));
$plink = array(pspell_new(deAspisRC($lang),deAspisRC($this->_config[0][('PSpell.spelling')]),deAspisRC($this->_config[0][('PSpell.jargon')]),deAspisRC($this->_config[0][('PSpell.encoding')]),deAspisRC($this->_config[0][('PSpell.mode')])),false);
if ( (denot_boolean($plink)))
 $this->throwError(array("No PSpell link found opened.",false));
return $plink;
} }
};
?>
<?php 