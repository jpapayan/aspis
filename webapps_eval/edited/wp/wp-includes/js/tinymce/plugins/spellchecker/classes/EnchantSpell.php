<?php require_once('AspisMain.php'); ?><?php
class EnchantSpell extends SpellChecker{function &checkWords ( $lang,$words ) {
{$r = array(enchant_broker_init(),false);
if ( (enchant_broker_dict_exists(deAspisRC($r),deAspisRC($lang))))
 {$d = array(enchant_broker_request_dict(deAspisRC($r),deAspisRC($lang)),false);
$returnData = array(array(),false);
foreach ( $words[0] as $key =>$value )
{restoreTaint($key,$value);
{$correct = array(enchant_dict_check(deAspisRC($d),deAspisRC($value)),false);
if ( (denot_boolean($correct)))
 {arrayAssignAdd($returnData[0][],addTaint(Aspis_trim($value)));
}}}return $returnData;
enchant_broker_free_dict(deAspisRC($d));
}else 
{{}}enchant_broker_free(deAspisRC($r));
} }
function &getSuggestions ( $lang,$word ) {
{$r = array(enchant_broker_init(),false);
$suggs = array(array(),false);
if ( (enchant_broker_dict_exists(deAspisRC($r),deAspisRC($lang))))
 {$d = array(enchant_broker_request_dict(deAspisRC($r),deAspisRC($lang)),false);
$suggs = array(enchant_dict_suggest(deAspisRC($d),deAspisRC($word)),false);
enchant_broker_free_dict(deAspisRC($d));
}else 
{{}}enchant_broker_free(deAspisRC($r));
return $suggs;
} }
};
