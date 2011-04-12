<?php require_once('AspisMain.php'); ?><?php
@array(error_reporting(deAspisRC(array(E_ALL ^ E_NOTICE,false))),false);
$config = array(array(),false);
require_once (deconcat2(Aspis_dirname(array(__FILE__,false)),"/../classes/utils/Logger.php"));
require_once (deconcat2(Aspis_dirname(array(__FILE__,false)),"/../classes/utils/JSON.php"));
require_once (deconcat2(Aspis_dirname(array(__FILE__,false)),"/../config.php"));
require_once (deconcat2(Aspis_dirname(array(__FILE__,false)),"/../classes/SpellChecker.php"));
if ( ((isset($config[0][('general.engine')]) && Aspis_isset( $config [0][('general.engine')]))))
 require_once (deconcat2(concat(concat2(Aspis_dirname(array(__FILE__,false)),"/../classes/"),$config[0]["general.engine"]),".php"));
function getRequestParam ( $name,$default_value = array(false,false),$sanitize = array(false,false) ) {
if ( (!((isset($_REQUEST[0][$name[0]]) && Aspis_isset( $_REQUEST [0][$name[0]])))))
 return $default_value;
if ( is_array(deAspis(attachAspis($_REQUEST,$name[0]))))
 {$newarray = array(array(),false);
foreach ( deAspis(attachAspis($_REQUEST,$name[0])) as $name =>$value )
{restoreTaint($name,$value);
arrayAssign($newarray[0],deAspis(registerTaint(formatParam($name,$sanitize))),addTaint(formatParam($value,$sanitize)));
}return $newarray;
}return formatParam(attachAspis($_REQUEST,$name[0]),$sanitize);
 }
function &getLogger (  ) {
global $mcLogger,$man;
if ( ((isset($man) && Aspis_isset( $man))))
 $mcLogger = $man[0]->getLogger();
if ( (denot_boolean($mcLogger)))
 {$mcLogger = array(new Moxiecode_Logger(),false);
$mcLogger[0]->setPath(concat2(Aspis_dirname(array(__FILE__,false)),"/../logs"));
$mcLogger[0]->setMaxSize(array("100kb",false));
$mcLogger[0]->setMaxFiles(array("10",false));
$mcLogger[0]->setFormat(array("{time} - {message}",false));
}return $mcLogger;
 }
function debug ( $msg ) {
$args = array(func_get_args(),false);
$log = getLogger();
$log[0]->debug(Aspis_implode(array(', ',false),$args));
 }
function info ( $msg ) {
$args = array(func_get_args(),false);
$log = getLogger();
$log[0]->info(Aspis_implode(array(', ',false),$args));
 }
function error ( $msg ) {
$args = array(func_get_args(),false);
$log = getLogger();
$log[0]->error(Aspis_implode(array(', ',false),$args));
 }
function warn ( $msg ) {
$args = array(func_get_args(),false);
$log = getLogger();
$log[0]->warn(Aspis_implode(array(', ',false),$args));
 }
function fatal ( $msg ) {
$args = array(func_get_args(),false);
$log = getLogger();
$log[0]->fatal(Aspis_implode(array(', ',false),$args));
 }
;
