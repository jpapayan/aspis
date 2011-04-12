<?php require_once('AspisMain.php'); ?><?php
define(('MC_LOGGER_DEBUG'),0);
define(('MC_LOGGER_INFO'),10);
define(('MC_LOGGER_WARN'),20);
define(('MC_LOGGER_ERROR'),30);
define(('MC_LOGGER_FATAL'),40);
class Moxiecode_Logger{var $_path;
var $_filename;
var $_maxSize;
var $_maxFiles;
var $_maxSizeBytes;
var $_level;
var $_format;
function Moxiecode_Logger (  ) {
{$this->_path = array("",false);
$this->_filename = array("{level}.log",false);
$this->setMaxSize(array("100k",false));
$this->_maxFiles = array(10,false);
$this->_level = array(MC_LOGGER_DEBUG,false);
$this->_format = array("[{time}] [{level}] {message}",false);
} }
function setLevel ( $level ) {
{if ( is_string(deAspisRC($level)))
 {switch ( deAspis(Aspis_strtolower($level)) ) {
case ("debug"):$level = array(MC_LOGGER_DEBUG,false);
break ;
case ("info"):$level = array(MC_LOGGER_INFO,false);
break ;
case ("warn"):case ("warning"):$level = array(MC_LOGGER_WARN,false);
break ;
case ("error"):$level = array(MC_LOGGER_ERROR,false);
break ;
case ("fatal"):$level = array(MC_LOGGER_FATAL,false);
break ;
default :$level = array(MC_LOGGER_FATAL,false);
 }
}$this->_level = $level;
} }
function getLevel (  ) {
{return $this->_level;
} }
function setPath ( $path ) {
{$this->_path = $path;
} }
function getPath (  ) {
{return $this->_path;
} }
function setFileName ( $file_name ) {
{$this->_filename = $file_name;
} }
function getFileName (  ) {
{return $this->_filename;
} }
function setFormat ( $format ) {
{$this->_format = $format;
} }
function getFormat (  ) {
{return $this->_format;
} }
function setMaxSize ( $size ) {
{$logMaxSizeBytes = Aspis_intval(Aspis_preg_replace(array("/[^0-9]/",false),array("",false),$size));
if ( (strpos(deAspis((Aspis_strtolower($size))),"k") > (0)))
 $logMaxSizeBytes = array((1024) * $logMaxSizeBytes[0],false);
if ( (strpos(deAspis((Aspis_strtolower($size))),"m") > (0)))
 $logMaxSizeBytes = array(((1024) * (1024)) * $logMaxSizeBytes[0],false);
$this->_maxSizeBytes = $logMaxSizeBytes;
$this->_maxSize = $size;
} }
function getMaxSize (  ) {
{return $this->_maxSize;
} }
function setMaxFiles ( $max_files ) {
{$this->_maxFiles = $max_files;
} }
function getMaxFiles (  ) {
{return $this->_maxFiles;
} }
function debug ( $msg ) {
{$args = array(func_get_args(),false);
$this->_logMsg(array(MC_LOGGER_DEBUG,false),Aspis_implode(array(', ',false),$args));
} }
function info ( $msg ) {
{$args = array(func_get_args(),false);
$this->_logMsg(array(MC_LOGGER_INFO,false),Aspis_implode(array(', ',false),$args));
} }
function warn ( $msg ) {
{$args = array(func_get_args(),false);
$this->_logMsg(array(MC_LOGGER_WARN,false),Aspis_implode(array(', ',false),$args));
} }
function error ( $msg ) {
{$args = array(func_get_args(),false);
$this->_logMsg(array(MC_LOGGER_ERROR,false),Aspis_implode(array(', ',false),$args));
} }
function fatal ( $msg ) {
{$args = array(func_get_args(),false);
$this->_logMsg(array(MC_LOGGER_FATAL,false),Aspis_implode(array(', ',false),$args));
} }
function isDebugEnabled (  ) {
{return array($this->_level[0] >= MC_LOGGER_DEBUG,false);
} }
function isInfoEnabled (  ) {
{return array($this->_level[0] >= MC_LOGGER_INFO,false);
} }
function isWarnEnabled (  ) {
{return array($this->_level[0] >= MC_LOGGER_WARN,false);
} }
function isErrorEnabled (  ) {
{return array($this->_level[0] >= MC_LOGGER_ERROR,false);
} }
function isFatalEnabled (  ) {
{return array($this->_level[0] >= MC_LOGGER_FATAL,false);
} }
function _logMsg ( $level,$message ) {
{$roll = array(false,false);
if ( ($level[0] < $this->_level[0]))
 return ;
$logFile = $this->toOSPath(concat(concat2($this->_path,"/"),$this->_filename));
switch ( $level[0] ) {
case MC_LOGGER_DEBUG:$levelName = array("DEBUG",false);
break ;
case MC_LOGGER_INFO:$levelName = array("INFO",false);
break ;
case MC_LOGGER_WARN:$levelName = array("WARN",false);
break ;
case MC_LOGGER_ERROR:$levelName = array("ERROR",false);
break ;
case MC_LOGGER_FATAL:$levelName = array("FATAL",false);
break ;
 }
$logFile = Aspis_str_replace(array('{level}',false),Aspis_strtolower($levelName),$logFile);
$text = $this->_format;
$text = Aspis_str_replace(array('{time}',false),attAspis(date(("Y-m-d H:i:s"))),$text);
$text = Aspis_str_replace(array('{level}',false),Aspis_strtolower($levelName),$text);
$text = Aspis_str_replace(array('{message}',false),$message,$text);
$message = concat2($text,"\r\n");
if ( file_exists($logFile[0]))
 {$size = @attAspis(filesize($logFile[0]));
if ( (($size[0] + strlen($message[0])) > $this->_maxSizeBytes[0]))
 $roll = array(true,false);
}if ( $roll[0])
 {for ( $i = array($this->_maxFiles[0] - (1),false) ; ($i[0] >= (1)) ; postdecr($i) )
{$rfile = $this->toOSPath(concat(concat2($logFile,"."),$i));
$nfile = $this->toOSPath(concat(concat2($logFile,"."),(array($i[0] + (1),false))));
if ( deAspis(@attAspis(file_exists($rfile[0]))))
 @attAspis(rename($rfile[0],$nfile[0]));
}@attAspis(rename($logFile[0],deAspis($this->toOSPath(concat2($logFile,".1")))));
$delfile = $this->toOSPath(concat(concat2($logFile,"."),(array($this->_maxFiles[0] + (1),false))));
if ( deAspis(@attAspis(file_exists($delfile[0]))))
 @attAspis(unlink($delfile[0]));
}if ( (deAspis(($fp = @attAspis(fopen($logFile[0],("a"))))) != null))
 {@attAspis(fputs($fp[0],$message[0]));
@attAspis(fflush($fp[0]));
@attAspis(fclose($fp[0]));
}} }
function toOSPath ( $path ) {
{return Aspis_str_replace(array("/",false),array(DIRECTORY_SEPARATOR,false),$path);
} }
};
