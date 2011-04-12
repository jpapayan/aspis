<?php require_once('AspisMain.php'); ?><?php
class POP3{var $ERROR = '';
var $TIMEOUT = 60;
var $COUNT = -1;
var $BUFFER = 512;
var $FP = '';
var $MAILSERVER = '';
var $DEBUG = FALSE;
var $BANNER = '';
var $ALLOWAPOP = FALSE;
function POP3 ( $server = '',$timeout = '' ) {
{settype($this->BUFFER,"integer");
if ( !empty($server))
 {if ( empty($this->MAILSERVER))
 $this->MAILSERVER = $server;
}if ( !empty($timeout))
 {settype($timeout,"integer");
$this->TIMEOUT = $timeout;
if ( !ini_get('safe_mode'))
 set_time_limit($timeout);
}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function update_timer (  ) {
{if ( !ini_get('safe_mode'))
 set_time_limit($this->TIMEOUT);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function connect ( $server,$port = 110 ) {
{if ( !isset($port) || !$port)
 {$port = 110;
}if ( !empty($this->MAILSERVER))
 $server = $this->MAILSERVER;
if ( empty($server))
 {$this->ERROR = "POP3 connect: " . _("No server specified");
unset($this->FP);
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$fp = @fsockopen("$server",$port,$errno,$errstr);
if ( !$fp)
 {$this->ERROR = "POP3 connect: " . _("Error ") . "[$errno] [$errstr]";
unset($this->FP);
{$AspisRetTemp = false;
return $AspisRetTemp;
}}socket_set_blocking($fp,-1);
$this->update_timer();
$reply = fgets($fp,$this->BUFFER);
$reply = $this->strip_clf($reply);
if ( $this->DEBUG)
 error_log("POP3 SEND [connect: $server] GOT [$reply]",0);
if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 connect: " . _("Error ") . "[$reply]";
unset($this->FP);
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->FP = $fp;
$this->BANNER = $this->parse_banner($reply);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function user ( $user = "" ) {
{if ( empty($user))
 {$this->ERROR = "POP3 user: " . _("no login ID submitted");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}elseif ( !isset($this->FP))
 {$this->ERROR = "POP3 user: " . _("connection not established");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}else 
{{$reply = $this->send_cmd("USER $user");
if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 user: " . _("Error ") . "[$reply]";
{$AspisRetTemp = false;
return $AspisRetTemp;
}}else 
{{$AspisRetTemp = true;
return $AspisRetTemp;
}}}}} }
function pass ( $pass = "" ) {
{if ( empty($pass))
 {$this->ERROR = "POP3 pass: " . _("No password submitted");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}elseif ( !isset($this->FP))
 {$this->ERROR = "POP3 pass: " . _("connection not established");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}else 
{{$reply = $this->send_cmd("PASS $pass");
if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 pass: " . _("Authentication failed") . " [$reply]";
$this->quit();
{$AspisRetTemp = false;
return $AspisRetTemp;
}}else 
{{$count = $this->last("count");
$this->COUNT = $count;
{$AspisRetTemp = $count;
return $AspisRetTemp;
}}}}}} }
function apop ( $login,$pass ) {
{if ( !isset($this->FP))
 {$this->ERROR = "POP3 apop: " . _("No connection to server");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}elseif ( !$this->ALLOWAPOP)
 {$retVal = $this->login($login,$pass);
{$AspisRetTemp = $retVal;
return $AspisRetTemp;
}}elseif ( empty($login))
 {$this->ERROR = "POP3 apop: " . _("No login ID submitted");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}elseif ( empty($pass))
 {$this->ERROR = "POP3 apop: " . _("No password submitted");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}else 
{{$banner = $this->BANNER;
if ( (!$banner) or (empty($banner)))
 {$this->ERROR = "POP3 apop: " . _("No server banner") . ' - ' . _("abort");
$retVal = $this->login($login,$pass);
{$AspisRetTemp = $retVal;
return $AspisRetTemp;
}}else 
{{$AuthString = $banner;
$AuthString .= $pass;
$APOPString = md5($AuthString);
$cmd = "APOP $login $APOPString";
$reply = $this->send_cmd($cmd);
if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 apop: " . _("apop authentication failed") . ' - ' . _("abort");
$retVal = $this->login($login,$pass);
{$AspisRetTemp = $retVal;
return $AspisRetTemp;
}}else 
{{$count = $this->last("count");
$this->COUNT = $count;
{$AspisRetTemp = $count;
return $AspisRetTemp;
}}}}}}}} }
function login ( $login = "",$pass = "" ) {
{if ( !isset($this->FP))
 {$this->ERROR = "POP3 login: " . _("No connection to server");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}else 
{{$fp = $this->FP;
if ( !$this->user($login))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}else 
{{$count = $this->pass($pass);
if ( (!$count) || ($count == -1))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}else 
{{$AspisRetTemp = $count;
return $AspisRetTemp;
}}}}}}} }
function top ( $msgNum,$numLines = "0" ) {
{if ( !isset($this->FP))
 {$this->ERROR = "POP3 top: " . _("No connection to server");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->update_timer();
$fp = $this->FP;
$buffer = $this->BUFFER;
$cmd = "TOP $msgNum $numLines";
fwrite($fp,"TOP $msgNum $numLines\r\n");
$reply = fgets($fp,$buffer);
$reply = $this->strip_clf($reply);
if ( $this->DEBUG)
 {@error_log("POP3 SEND [$cmd] GOT [$reply]",0);
}if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 top: " . _("Error ") . "[$reply]";
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$count = 0;
$MsgArray = array();
$line = fgets($fp,$buffer);
while ( !ereg("^\.\r\n",$line) )
{$MsgArray[$count] = $line;
$count++;
$line = fgets($fp,$buffer);
if ( empty($line))
 {break ;
}}{$AspisRetTemp = $MsgArray;
return $AspisRetTemp;
}} }
function pop_list ( $msgNum = "" ) {
{if ( !isset($this->FP))
 {$this->ERROR = "POP3 pop_list: " . _("No connection to server");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$fp = $this->FP;
$Total = $this->COUNT;
if ( (!$Total) or ($Total == -1))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( $Total == 0)
 {{$AspisRetTemp = array("0","0");
return $AspisRetTemp;
}}$this->update_timer();
if ( !empty($msgNum))
 {$cmd = "LIST $msgNum";
fwrite($fp,"$cmd\r\n");
$reply = fgets($fp,$this->BUFFER);
$reply = $this->strip_clf($reply);
if ( $this->DEBUG)
 {@error_log("POP3 SEND [$cmd] GOT [$reply]",0);
}if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 pop_list: " . _("Error ") . "[$reply]";
{$AspisRetTemp = false;
return $AspisRetTemp;
}}list($junk,$num,$size) = preg_split('/\s+/',$reply);
{$AspisRetTemp = $size;
return $AspisRetTemp;
}}$cmd = "LIST";
$reply = $this->send_cmd($cmd);
if ( !$this->is_ok($reply))
 {$reply = $this->strip_clf($reply);
$this->ERROR = "POP3 pop_list: " . _("Error ") . "[$reply]";
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$MsgArray = array();
$MsgArray[0] = $Total;
for ( $msgC = 1 ; $msgC <= $Total ; $msgC++ )
{if ( $msgC > $Total)
 {break ;
}$line = fgets($fp,$this->BUFFER);
$line = $this->strip_clf($line);
if ( ereg("^\.",$line))
 {$this->ERROR = "POP3 pop_list: " . _("Premature end of list");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}list($thisMsg,$msgSize) = preg_split('/\s+/',$line);
settype($thisMsg,"integer");
if ( $thisMsg != $msgC)
 {$MsgArray[$msgC] = "deleted";
}else 
{{$MsgArray[$msgC] = $msgSize;
}}}{$AspisRetTemp = $MsgArray;
return $AspisRetTemp;
}} }
function get ( $msgNum ) {
{if ( !isset($this->FP))
 {$this->ERROR = "POP3 get: " . _("No connection to server");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->update_timer();
$fp = $this->FP;
$buffer = $this->BUFFER;
$cmd = "RETR $msgNum";
$reply = $this->send_cmd($cmd);
if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 get: " . _("Error ") . "[$reply]";
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$count = 0;
$MsgArray = array();
$line = fgets($fp,$buffer);
while ( !ereg("^\.\r\n",$line) )
{if ( $line[0] == '.')
 {$line = substr($line,1);
}$MsgArray[$count] = $line;
$count++;
$line = fgets($fp,$buffer);
if ( empty($line))
 {break ;
}}{$AspisRetTemp = $MsgArray;
return $AspisRetTemp;
}} }
function last ( $type = "count" ) {
{$last = -1;
if ( !isset($this->FP))
 {$this->ERROR = "POP3 last: " . _("No connection to server");
{$AspisRetTemp = $last;
return $AspisRetTemp;
}}$reply = $this->send_cmd("STAT");
if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 last: " . _("Error ") . "[$reply]";
{$AspisRetTemp = $last;
return $AspisRetTemp;
}}$Vars = preg_split('/\s+/',$reply);
$count = $Vars[1];
$size = $Vars[2];
settype($count,"integer");
settype($size,"integer");
if ( $type != "count")
 {{$AspisRetTemp = array($count,$size);
return $AspisRetTemp;
}}{$AspisRetTemp = $count;
return $AspisRetTemp;
}} }
function reset (  ) {
{if ( !isset($this->FP))
 {$this->ERROR = "POP3 reset: " . _("No connection to server");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$reply = $this->send_cmd("RSET");
if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 reset: " . _("Error ") . "[$reply]";
@error_log("POP3 reset: ERROR [$reply]",0);
}$this->quit();
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function send_cmd ( $cmd = "" ) {
{if ( !isset($this->FP))
 {$this->ERROR = "POP3 send_cmd: " . _("No connection to server");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( empty($cmd))
 {$this->ERROR = "POP3 send_cmd: " . _("Empty command string");
{$AspisRetTemp = "";
return $AspisRetTemp;
}}$fp = $this->FP;
$buffer = $this->BUFFER;
$this->update_timer();
fwrite($fp,"$cmd\r\n");
$reply = fgets($fp,$buffer);
$reply = $this->strip_clf($reply);
if ( $this->DEBUG)
 {@error_log("POP3 SEND [$cmd] GOT [$reply]",0);
}{$AspisRetTemp = $reply;
return $AspisRetTemp;
}} }
function quit (  ) {
{if ( !isset($this->FP))
 {$this->ERROR = "POP3 quit: " . _("connection does not exist");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$fp = $this->FP;
$cmd = "QUIT";
fwrite($fp,"$cmd\r\n");
$reply = fgets($fp,$this->BUFFER);
$reply = $this->strip_clf($reply);
if ( $this->DEBUG)
 {@error_log("POP3 SEND [$cmd] GOT [$reply]",0);
}fclose($fp);
unset($this->FP);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function popstat (  ) {
{$PopArray = $this->last("array");
if ( $PopArray == -1)
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( (!$PopArray) or (empty($PopArray)))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}{$AspisRetTemp = $PopArray;
return $AspisRetTemp;
}} }
function uidl ( $msgNum = "" ) {
{if ( !isset($this->FP))
 {$this->ERROR = "POP3 uidl: " . _("No connection to server");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$fp = $this->FP;
$buffer = $this->BUFFER;
if ( !empty($msgNum))
 {$cmd = "UIDL $msgNum";
$reply = $this->send_cmd($cmd);
if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 uidl: " . _("Error ") . "[$reply]";
{$AspisRetTemp = false;
return $AspisRetTemp;
}}list($ok,$num,$myUidl) = preg_split('/\s+/',$reply);
{$AspisRetTemp = $myUidl;
return $AspisRetTemp;
}}else 
{{$this->update_timer();
$UIDLArray = array();
$Total = $this->COUNT;
$UIDLArray[0] = $Total;
if ( $Total < 1)
 {{$AspisRetTemp = $UIDLArray;
return $AspisRetTemp;
}}$cmd = "UIDL";
fwrite($fp,"UIDL\r\n");
$reply = fgets($fp,$buffer);
$reply = $this->strip_clf($reply);
if ( $this->DEBUG)
 {@error_log("POP3 SEND [$cmd] GOT [$reply]",0);
}if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 uidl: " . _("Error ") . "[$reply]";
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$line = "";
$count = 1;
$line = fgets($fp,$buffer);
while ( !ereg("^\.\r\n",$line) )
{if ( ereg("^\.\r\n",$line))
 {break ;
}list($msg,$msgUidl) = preg_split('/\s+/',$line);
$msgUidl = $this->strip_clf($msgUidl);
if ( $count == $msg)
 {$UIDLArray[$msg] = $msgUidl;
}else 
{{$UIDLArray[$count] = 'deleted';
}}$count++;
$line = fgets($fp,$buffer);
}}}{$AspisRetTemp = $UIDLArray;
return $AspisRetTemp;
}} }
function delete ( $msgNum = "" ) {
{if ( !isset($this->FP))
 {$this->ERROR = "POP3 delete: " . _("No connection to server");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( empty($msgNum))
 {$this->ERROR = "POP3 delete: " . _("No msg number submitted");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$reply = $this->send_cmd("DELE $msgNum");
if ( !$this->is_ok($reply))
 {$this->ERROR = "POP3 delete: " . _("Command failed ") . "[$reply]";
{$AspisRetTemp = false;
return $AspisRetTemp;
}}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function is_ok ( $cmd = "" ) {
{if ( empty($cmd))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = (ereg("^\+OK",$cmd));
return $AspisRetTemp;
}}} }
function strip_clf ( $text = "" ) {
{if ( empty($text))
 {$AspisRetTemp = $text;
return $AspisRetTemp;
}else 
{{$stripped = str_replace("\r",'',$text);
$stripped = str_replace("\n",'',$stripped);
{$AspisRetTemp = $stripped;
return $AspisRetTemp;
}}}} }
function parse_banner ( $server_text ) {
{$outside = true;
$banner = "";
$length = strlen($server_text);
for ( $count = 0 ; $count < $length ; $count++ )
{$digit = substr($server_text,$count,1);
if ( !empty($digit))
 {if ( (!$outside) && ($digit != '<') && ($digit != '>'))
 {$banner .= $digit;
}if ( $digit == '<')
 {$outside = false;
}if ( $digit == '>')
 {$outside = true;
}}}$banner = $this->strip_clf($banner);
{$AspisRetTemp = "<$banner>";
return $AspisRetTemp;
}} }
};
?>
<?php 