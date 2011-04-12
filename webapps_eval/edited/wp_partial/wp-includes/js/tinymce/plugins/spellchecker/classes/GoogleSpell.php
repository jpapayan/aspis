<?php require_once('AspisMain.php'); ?><?php
class GoogleSpell extends SpellChecker{function &checkWords ( $lang,$words ) {
{$wordstr = implode(' ',$words);
$matches = $this->_getMatches($lang,$wordstr);
$words = array();
for ( $i = 0 ; $i < count($matches) ; $i++ )
$words[] = $this->_unhtmlentities(mb_substr($wordstr,$matches[$i][1],$matches[$i][2],"UTF-8"));
{$AspisRetTemp = &$words;
return $AspisRetTemp;
}} }
function &getSuggestions ( $lang,$word ) {
{$sug = array();
$osug = array();
$matches = $this->_getMatches($lang,$word);
if ( count($matches) > 0)
 $sug = explode("\t",utf8_encode($this->_unhtmlentities($matches[0][4])));
foreach ( $sug as $item  )
{if ( $item)
 $osug[] = $item;
}{$AspisRetTemp = &$osug;
return $AspisRetTemp;
}} }
function &_getMatches ( $lang,$str ) {
{$server = "www.google.com";
$port = 443;
$path = "/tbproxy/spell?lang=" . $lang . "&hl=en";
$host = "www.google.com";
$url = "https://" . $server;
$xml = '<?xml version="1.0" encoding="utf-8" ?><spellrequest textalreadyclipped="0" ignoredups="0" ignoredigits="1" ignoreallcaps="1"><text>' . $str . '</text></spellrequest>';
$header = "POST " . $path . " HTTP/1.0 \r\n";
$header .= "MIME-Version: 1.0 \r\n";
$header .= "Content-type: application/PTI26 \r\n";
$header .= "Content-length: " . strlen($xml) . " \r\n";
$header .= "Content-transfer-encoding: text \r\n";
$header .= "Request-number: 1 \r\n";
$header .= "Document-type: Request \r\n";
$header .= "Interface-Version: Test 1.4 \r\n";
$header .= "Connection: close \r\n\r\n";
$header .= $xml;
if ( function_exists('curl_init'))
 {$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$header);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
$xml = curl_exec($ch);
curl_close($ch);
}else 
{{$fp = fsockopen("ssl://" . $server,$port,$errno,$errstr,30);
if ( $fp)
 {fwrite($fp,$header);
$xml = "";
while ( !feof($fp) )
$xml .= fgets($fp,128);
fclose($fp);
}else 
{echo "Could not open SSL connection to google.";
}}}$matches = array();
preg_match_all('/<c o="([^"]*)" l="([^"]*)" s="([^"]*)">([^<]*)<\/c>/',$xml,$matches,PREG_SET_ORDER);
{$AspisRetTemp = &$matches;
return $AspisRetTemp;
}} }
function _unhtmlentities ( $string ) {
{$string = preg_replace('~&#x([0-9a-f]+);~ei','chr(hexdec("\\1"))',$string);
$string = preg_replace('~&#([0-9]+);~e','chr(\\1)',$string);
$trans_tbl = get_html_translation_table(HTML_ENTITIES);
$trans_tbl = array_flip($trans_tbl);
{$AspisRetTemp = strtr($string,$trans_tbl);
return $AspisRetTemp;
}} }
}if ( !function_exists('mb_substr'))
 {function mb_substr ( $str,$start,$len = '',$encoding = "UTF-8" ) {
$limit = strlen($str);
for ( $s = 0 ; $start > 0 ; --$start )
{if ( $s >= $limit)
 break ;
if ( $str[$s] <= "\x7F")
 ++$s;
else 
{{++$s;
while ( $str[$s] >= "\x80" && $str[$s] <= "\xBF" )
++$s;
}}}if ( $len == '')
 {$AspisRetTemp = substr($str,$s);
return $AspisRetTemp;
}else 
{for ( $e = $s ; $len > 0 ; --$len )
{if ( $e >= $limit)
 break ;
if ( $str[$e] <= "\x7F")
 ++$e;
else 
{{++$e;
while ( $str[$e] >= "\x80" && $str[$e] <= "\xBF" && $e < $limit )
++$e;
}}}}{$AspisRetTemp = substr($str,$s,$e - $s);
return $AspisRetTemp;
} }
};
