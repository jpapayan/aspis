<?php require_once('AspisMain.php'); ?><?php
@error_reporting(E_ALL ^ E_NOTICE);
$config = array();
require_once (dirname(__FILE__) . "/../classes/utils/Logger.php");
require_once (dirname(__FILE__) . "/../classes/utils/JSON.php");
require_once (dirname(__FILE__) . "/../config.php");
require_once (dirname(__FILE__) . "/../classes/SpellChecker.php");
if ( isset($config['general.engine']))
 require_once (dirname(__FILE__) . "/../classes/" . $config["general.engine"] . ".php");
function getRequestParam ( $name,$default_value = false,$sanitize = false ) {
if ( !(isset($_REQUEST[0][$name]) && Aspis_isset($_REQUEST[0][$name])))
 {$AspisRetTemp = $default_value;
return $AspisRetTemp;
}if ( is_array(deAspisWarningRC($_REQUEST[0][$name])))
 {$newarray = array();
foreach ( deAspisWarningRC($_REQUEST[0][$name]) as $name =>$value )
$newarray[formatParam($name,$sanitize)] = formatParam($value,$sanitize);
{$AspisRetTemp = $newarray;
return $AspisRetTemp;
}}{$AspisRetTemp = formatParam(deAspisWarningRC($_REQUEST[0][$name]),$sanitize);
return $AspisRetTemp;
} }
function &getLogger (  ) {
{global $mcLogger,$man;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $mcLogger,"\$mcLogger",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($man,"\$man",$AspisChangesCache);
}if ( isset($man))
 $mcLogger = $man->getLogger();
if ( !$mcLogger)
 {$mcLogger = new Moxiecode_Logger();
$mcLogger->setPath(dirname(__FILE__) . "/../logs");
$mcLogger->setMaxSize("100kb");
$mcLogger->setMaxFiles("10");
$mcLogger->setFormat("{time} - {message}");
}{$AspisRetTemp = &$mcLogger;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$mcLogger",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$man",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$mcLogger",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$man",$AspisChangesCache);
 }
function debug ( $msg ) {
$args = func_get_args();
$log = getLogger();
$log->debug(implode(', ',$args));
 }
function info ( $msg ) {
$args = func_get_args();
$log = getLogger();
$log->info(implode(', ',$args));
 }
function error ( $msg ) {
$args = func_get_args();
$log = getLogger();
$log->error(implode(', ',$args));
 }
function warn ( $msg ) {
$args = func_get_args();
$log = getLogger();
$log->warn(implode(', ',$args));
 }
function fatal ( $msg ) {
$args = func_get_args();
$log = getLogger();
$log->fatal(implode(', ',$args));
 }
;
