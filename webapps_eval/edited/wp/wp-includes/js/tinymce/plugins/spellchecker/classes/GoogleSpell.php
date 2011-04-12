<?php require_once('AspisMain.php'); ?><?php
class GoogleSpell extends SpellChecker{function &checkWords ( $lang,$words ) {
{$wordstr = Aspis_implode(array(' ',false),$words);
$matches = $this->_getMatches($lang,$wordstr);
$words = array(array(),false);
for ( $i = array(0,false) ; ($i[0] < count($matches[0])) ; postincr($i) )
arrayAssignAdd($words[0][],addTaint($this->_unhtmlentities(array(mb_substr(deAspisRC($wordstr),deAspisRC(attachAspis($matches[0][$i[0]],(1))),deAspisRC(attachAspis($matches[0][$i[0]],(2))),"UTF-8"),false))));
return $words;
} }
function &getSuggestions ( $lang,$word ) {
{$sug = array(array(),false);
$osug = array(array(),false);
$matches = $this->_getMatches($lang,$word);
if ( (count($matches[0]) > (0)))
 $sug = Aspis_explode(array("\t",false),Aspis_utf8_encode($this->_unhtmlentities(attachAspis($matches[0][(0)],(4)))));
foreach ( $sug[0] as $item  )
{if ( $item[0])
 arrayAssignAdd($osug[0][],addTaint($item));
}return $osug;
} }
function &_getMatches ( $lang,$str ) {
{$server = array("www.google.com",false);
$port = array(443,false);
$path = concat2(concat1("/tbproxy/spell?lang=",$lang),"&hl=en");
$host = array("www.google.com",false);
$url = concat1("https://",$server);
$xml = concat2(concat1('<?xml version="1.0" encoding="utf-8" ?><spellrequest textalreadyclipped="0" ignoredups="0" ignoredigits="1" ignoreallcaps="1"><text>',$str),'</text></spellrequest>');
$header = concat2(concat1("POST ",$path)," HTTP/1.0 \r\n");
$header = concat2($header,"MIME-Version: 1.0 \r\n");
$header = concat2($header,"Content-type: application/PTI26 \r\n");
$header = concat($header,concat2(concat1("Content-length: ",attAspis(strlen($xml[0])))," \r\n"));
$header = concat2($header,"Content-transfer-encoding: text \r\n");
$header = concat2($header,"Request-number: 1 \r\n");
$header = concat2($header,"Document-type: Request \r\n");
$header = concat2($header,"Interface-Version: Test 1.4 \r\n");
$header = concat2($header,"Connection: close \r\n\r\n");
$header = concat($header,$xml);
if ( function_exists(('curl_init')))
 {$ch = array(curl_init(),false);
curl_setopt(deAspisRC($ch),CURLOPT_URL,deAspisRC($url));
curl_setopt(deAspisRC($ch),CURLOPT_RETURNTRANSFER,1);
curl_setopt(deAspisRC($ch),CURLOPT_CUSTOMREQUEST,deAspisRC($header));
curl_setopt(deAspisRC($ch),CURLOPT_SSL_VERIFYPEER,FALSE);
$xml = array(curl_exec(deAspisRC($ch)),false);
curl_close(deAspisRC($ch));
}else 
{{$fp = AspisInternalFunctionCall("fsockopen",(deconcat1("ssl://",$server)),$port[0],AspisPushRefParam($errno),AspisPushRefParam($errstr),(30),array(2,3));
if ( $fp[0])
 {fwrite($fp[0],$header[0]);
$xml = array("",false);
while ( (!(feof($fp[0]))) )
$xml = concat($xml,attAspis(fgets($fp[0],(128))));
fclose($fp[0]);
}else 
{echo AspisCheckPrint(array("Could not open SSL connection to google.",false));
}}}$matches = array(array(),false);
Aspis_preg_match_all(array('/<c o="([^"]*)" l="([^"]*)" s="([^"]*)">([^<]*)<\/c>/',false),$xml,$matches,array(PREG_SET_ORDER,false));
return $matches;
} }
function _unhtmlentities ( $string ) {
{$string = Aspis_preg_replace(array('~&#x([0-9a-f]+);~ei',false),array('chr(hexdec("\\1"))',false),$string);
$string = Aspis_preg_replace(array('~&#([0-9]+);~e',false),array('chr(\\1)',false),$string);
$trans_tbl = attAspisRC(get_html_translation_table(HTML_ENTITIES));
$trans_tbl = Aspis_array_flip($trans_tbl);
return Aspis_strtr($string,$trans_tbl);
} }
}if ( (!(function_exists(('mb_substr')))))
 {function mb_substr ( $str,$start,$len = array('',false),$encoding = array("UTF-8",false) ) {
$limit = attAspis(strlen($str[0]));
for ( $s = array(0,false) ; ($start[0] > (0)) ; predecr($start) )
{if ( ($s[0] >= $limit[0]))
 break ;
if ( (deAspis(attachAspis($str,$s[0])) <= ("\x7F")))
 preincr($s);
else 
{{preincr($s);
while ( ((deAspis(attachAspis($str,$s[0])) >= ("\x80")) && (deAspis(attachAspis($str,$s[0])) <= ("\xBF"))) )
preincr($s);
}}}if ( ($len[0] == ('')))
 return Aspis_substr($str,$s);
else 
{for ( $e = $s ; ($len[0] > (0)) ; predecr($len) )
{if ( ($e[0] >= $limit[0]))
 break ;
if ( (deAspis(attachAspis($str,$e[0])) <= ("\x7F")))
 preincr($e);
else 
{{preincr($e);
while ( (((deAspis(attachAspis($str,$e[0])) >= ("\x80")) && (deAspis(attachAspis($str,$e[0])) <= ("\xBF"))) && ($e[0] < $limit[0])) )
preincr($e);
}}}}return Aspis_substr($str,$s,array($e[0] - $s[0],false));
 }
};
