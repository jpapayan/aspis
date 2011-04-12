<?php require_once('AspisMain.php'); ?><?php
class SpellChecker{function SpellChecker ( &$config ) {
{$this->_config = $config;
} }
function &loopback (  ) {
{{$AspisRetTemp = func_get_args();
return $AspisRetTemp;
}} }
function &checkWords ( $lang,$words ) {
{{$AspisRetTemp = &$words;
return $AspisRetTemp;
}} }
function &getSuggestions ( $lang,$word ) {
{{$AspisRetTemp = array();
return $AspisRetTemp;
}} }
function throwError ( $str ) {
{exit('{"result":null,"id":null,"error":{"errstr":"' . addslashes($str) . '","errfile":"","errline":null,"errcontext":"","level":"FATAL"}}');
} }
};
?>
<?php 