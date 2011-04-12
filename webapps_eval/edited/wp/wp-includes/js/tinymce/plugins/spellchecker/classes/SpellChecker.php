<?php require_once('AspisMain.php'); ?><?php
class SpellChecker{function SpellChecker ( &$config ) {
{$this->_config = $config;
} }
function &loopback (  ) {
{return array(func_get_args(),false);
} }
function &checkWords ( $lang,$words ) {
{return $words;
} }
function &getSuggestions ( $lang,$word ) {
{return array(array(),false);
} }
function throwError ( $str ) {
{Aspis_exit(concat2(concat1('{"result":null,"id":null,"error":{"errstr":"',Aspis_addslashes($str)),'","errfile":"","errline":null,"errcontext":"","level":"FATAL"}}'));
} }
};
?>
<?php 