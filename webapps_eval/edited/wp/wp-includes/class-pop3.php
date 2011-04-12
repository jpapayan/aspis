<?php require_once('AspisMain.php'); ?><?php
class POP3{var $ERROR = array('',false);
var $TIMEOUT = array(60,false);
var $COUNT = array(-1,false);
var $BUFFER = array(512,false);
var $FP = array('',false);
var $MAILSERVER = array('',false);
var $DEBUG = array(FALSE,false);
var $BANNER = array('',false);
var $ALLOWAPOP = array(FALSE,false);
function POP3 ( $server = array('',false),$timeout = array('',false) ) {
{AspisInternalFunctionCall("settype",AspisPushRefParam($this->BUFFER),("integer"),array(0));
if ( (!((empty($server) || Aspis_empty( $server)))))
 {if ( ((empty($this->MAILSERVER) || Aspis_empty( $this ->MAILSERVER ))))
 $this->MAILSERVER = $server;
}if ( (!((empty($timeout) || Aspis_empty( $timeout)))))
 {AspisInternalFunctionCall("settype",AspisPushRefParam($timeout),("integer"),array(0));
$this->TIMEOUT = $timeout;
if ( (!(ini_get('safe_mode'))))
 set_time_limit(deAspisRC($timeout));
}return array(true,false);
} }
function update_timer (  ) {
{if ( (!(ini_get('safe_mode'))))
 set_time_limit(deAspisRC($this->TIMEOUT));
return array(true,false);
} }
function connect ( $server,$port = array(110,false) ) {
{if ( ((!((isset($port) && Aspis_isset( $port)))) || (denot_boolean($port))))
 {$port = array(110,false);
}if ( (!((empty($this->MAILSERVER) || Aspis_empty( $this ->MAILSERVER )))))
 $server = $this->MAILSERVER;
if ( ((empty($server) || Aspis_empty( $server))))
 {$this->ERROR = concat1("POP3 connect: ",_(array("No server specified",false)));
unset($this->FP);
return array(false,false);
}$fp = @AspisInternalFunctionCall("fsockopen",$server[0],$port[0],AspisPushRefParam($errno),AspisPushRefParam($errstr),array(2,3));
if ( (denot_boolean($fp)))
 {$this->ERROR = concat(concat1("POP3 connect: ",_(array("Error ",false))),concat2(concat(concat2(concat1("[",$errno),"] ["),$errstr),"]"));
unset($this->FP);
return array(false,false);
}socket_set_blocking(deAspisRC($fp),deAspisRC(negate(array(1,false))));
$this->update_timer();
$reply = attAspis(fgets($fp[0],$this->BUFFER[0]));
$reply = $this->strip_clf($reply);
if ( $this->DEBUG[0])
 error_log((deconcat2(concat(concat2(concat1("POP3 SEND [connect: ",$server),"] GOT ["),$reply),"]")),0);
if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 connect: ",_(array("Error ",false))),concat2(concat1("[",$reply),"]"));
unset($this->FP);
return array(false,false);
}$this->FP = $fp;
$this->BANNER = $this->parse_banner($reply);
return array(true,false);
} }
function user ( $user = array("",false) ) {
{if ( ((empty($user) || Aspis_empty( $user))))
 {$this->ERROR = concat1("POP3 user: ",_(array("no login ID submitted",false)));
return array(false,false);
}elseif ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 user: ",_(array("connection not established",false)));
return array(false,false);
}else 
{{$reply = $this->send_cmd(concat1("USER ",$user));
if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 user: ",_(array("Error ",false))),concat2(concat1("[",$reply),"]"));
return array(false,false);
}else 
{return array(true,false);
}}}} }
function pass ( $pass = array("",false) ) {
{if ( ((empty($pass) || Aspis_empty( $pass))))
 {$this->ERROR = concat1("POP3 pass: ",_(array("No password submitted",false)));
return array(false,false);
}elseif ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 pass: ",_(array("connection not established",false)));
return array(false,false);
}else 
{{$reply = $this->send_cmd(concat1("PASS ",$pass));
if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 pass: ",_(array("Authentication failed",false))),concat2(concat1(" [",$reply),"]"));
$this->quit();
return array(false,false);
}else 
{{$count = $this->last(array("count",false));
$this->COUNT = $count;
return $count;
}}}}} }
function apop ( $login,$pass ) {
{if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 apop: ",_(array("No connection to server",false)));
return array(false,false);
}elseif ( (denot_boolean($this->ALLOWAPOP)))
 {$retVal = $this->login($login,$pass);
return $retVal;
}elseif ( ((empty($login) || Aspis_empty( $login))))
 {$this->ERROR = concat1("POP3 apop: ",_(array("No login ID submitted",false)));
return array(false,false);
}elseif ( ((empty($pass) || Aspis_empty( $pass))))
 {$this->ERROR = concat1("POP3 apop: ",_(array("No password submitted",false)));
return array(false,false);
}else 
{{$banner = $this->BANNER;
if ( ((denot_boolean($banner)) or ((empty($banner) || Aspis_empty( $banner)))))
 {$this->ERROR = concat(concat2(concat1("POP3 apop: ",_(array("No server banner",false))),' - '),_(array("abort",false)));
$retVal = $this->login($login,$pass);
return $retVal;
}else 
{{$AuthString = $banner;
$AuthString = concat($AuthString,$pass);
$APOPString = attAspis(md5($AuthString[0]));
$cmd = concat(concat2(concat1("APOP ",$login)," "),$APOPString);
$reply = $this->send_cmd($cmd);
if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat2(concat1("POP3 apop: ",_(array("apop authentication failed",false))),' - '),_(array("abort",false)));
$retVal = $this->login($login,$pass);
return $retVal;
}else 
{{$count = $this->last(array("count",false));
$this->COUNT = $count;
return $count;
}}}}}}} }
function login ( $login = array("",false),$pass = array("",false) ) {
{if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 login: ",_(array("No connection to server",false)));
return array(false,false);
}else 
{{$fp = $this->FP;
if ( (denot_boolean($this->user($login))))
 {return array(false,false);
}else 
{{$count = $this->pass($pass);
if ( ((denot_boolean($count)) || ($count[0] == deAspis(negate(array(1,false))))))
 {return array(false,false);
}else 
{return $count;
}}}}}} }
function top ( $msgNum,$numLines = array("0",false) ) {
{if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 top: ",_(array("No connection to server",false)));
return array(false,false);
}$this->update_timer();
$fp = $this->FP;
$buffer = $this->BUFFER;
$cmd = concat(concat2(concat1("TOP ",$msgNum)," "),$numLines);
fwrite($fp[0],(deconcat2(concat(concat2(concat1("TOP ",$msgNum)," "),$numLines),"\r\n")));
$reply = attAspis(fgets($fp[0],$buffer[0]));
$reply = $this->strip_clf($reply);
if ( $this->DEBUG[0])
 {@array(error_log((deconcat2(concat(concat2(concat1("POP3 SEND [",$cmd),"] GOT ["),$reply),"]")),0),false);
}if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 top: ",_(array("Error ",false))),concat2(concat1("[",$reply),"]"));
return array(false,false);
}$count = array(0,false);
$MsgArray = array(array(),false);
$line = attAspis(fgets($fp[0],$buffer[0]));
while ( (!(ereg(("^\.\r\n"),$line[0]))) )
{arrayAssign($MsgArray[0],deAspis(registerTaint($count)),addTaint($line));
postincr($count);
$line = attAspis(fgets($fp[0],$buffer[0]));
if ( ((empty($line) || Aspis_empty( $line))))
 {break ;
}}return $MsgArray;
} }
function pop_list ( $msgNum = array("",false) ) {
{if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 pop_list: ",_(array("No connection to server",false)));
return array(false,false);
}$fp = $this->FP;
$Total = $this->COUNT;
if ( ((denot_boolean($Total)) or ($Total[0] == deAspis(negate(array(1,false))))))
 {return array(false,false);
}if ( ($Total[0] == (0)))
 {return array(array(array("0",false),array("0",false)),false);
}$this->update_timer();
if ( (!((empty($msgNum) || Aspis_empty( $msgNum)))))
 {$cmd = concat1("LIST ",$msgNum);
fwrite($fp[0],(deconcat2($cmd,"\r\n")));
$reply = attAspis(fgets($fp[0],$this->BUFFER[0]));
$reply = $this->strip_clf($reply);
if ( $this->DEBUG[0])
 {@array(error_log((deconcat2(concat(concat2(concat1("POP3 SEND [",$cmd),"] GOT ["),$reply),"]")),0),false);
}if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 pop_list: ",_(array("Error ",false))),concat2(concat1("[",$reply),"]"));
return array(false,false);
}list($junk,$num,$size) = deAspisList(Aspis_preg_split(array('/\s+/',false),$reply),array());
return $size;
}$cmd = array("LIST",false);
$reply = $this->send_cmd($cmd);
if ( (denot_boolean($this->is_ok($reply))))
 {$reply = $this->strip_clf($reply);
$this->ERROR = concat(concat1("POP3 pop_list: ",_(array("Error ",false))),concat2(concat1("[",$reply),"]"));
return array(false,false);
}$MsgArray = array(array(),false);
arrayAssign($MsgArray[0],deAspis(registerTaint(array(0,false))),addTaint($Total));
for ( $msgC = array(1,false) ; ($msgC[0] <= $Total[0]) ; postincr($msgC) )
{if ( ($msgC[0] > $Total[0]))
 {break ;
}$line = attAspis(fgets($fp[0],$this->BUFFER[0]));
$line = $this->strip_clf($line);
if ( ereg(("^\."),$line[0]))
 {$this->ERROR = concat1("POP3 pop_list: ",_(array("Premature end of list",false)));
return array(false,false);
}list($thisMsg,$msgSize) = deAspisList(Aspis_preg_split(array('/\s+/',false),$line),array());
AspisInternalFunctionCall("settype",AspisPushRefParam($thisMsg),("integer"),array(0));
if ( ($thisMsg[0] != $msgC[0]))
 {arrayAssign($MsgArray[0],deAspis(registerTaint($msgC)),addTaint(array("deleted",false)));
}else 
{{arrayAssign($MsgArray[0],deAspis(registerTaint($msgC)),addTaint($msgSize));
}}}return $MsgArray;
} }
function get ( $msgNum ) {
{if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 get: ",_(array("No connection to server",false)));
return array(false,false);
}$this->update_timer();
$fp = $this->FP;
$buffer = $this->BUFFER;
$cmd = concat1("RETR ",$msgNum);
$reply = $this->send_cmd($cmd);
if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 get: ",_(array("Error ",false))),concat2(concat1("[",$reply),"]"));
return array(false,false);
}$count = array(0,false);
$MsgArray = array(array(),false);
$line = attAspis(fgets($fp[0],$buffer[0]));
while ( (!(ereg(("^\.\r\n"),$line[0]))) )
{if ( (deAspis(attachAspis($line,(0))) == ('.')))
 {$line = Aspis_substr($line,array(1,false));
}arrayAssign($MsgArray[0],deAspis(registerTaint($count)),addTaint($line));
postincr($count);
$line = attAspis(fgets($fp[0],$buffer[0]));
if ( ((empty($line) || Aspis_empty( $line))))
 {break ;
}}return $MsgArray;
} }
function last ( $type = array("count",false) ) {
{$last = negate(array(1,false));
if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 last: ",_(array("No connection to server",false)));
return $last;
}$reply = $this->send_cmd(array("STAT",false));
if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 last: ",_(array("Error ",false))),concat2(concat1("[",$reply),"]"));
return $last;
}$Vars = Aspis_preg_split(array('/\s+/',false),$reply);
$count = attachAspis($Vars,(1));
$size = attachAspis($Vars,(2));
AspisInternalFunctionCall("settype",AspisPushRefParam($count),("integer"),array(0));
AspisInternalFunctionCall("settype",AspisPushRefParam($size),("integer"),array(0));
if ( ($type[0] != ("count")))
 {return array(array($count,$size),false);
}return $count;
} }
function reset (  ) {
{if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 reset: ",_(array("No connection to server",false)));
return array(false,false);
}$reply = $this->send_cmd(array("RSET",false));
if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 reset: ",_(array("Error ",false))),concat2(concat1("[",$reply),"]"));
@array(error_log((deconcat2(concat1("POP3 reset: ERROR [",$reply),"]")),0),false);
}$this->quit();
return array(true,false);
} }
function send_cmd ( $cmd = array("",false) ) {
{if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 send_cmd: ",_(array("No connection to server",false)));
return array(false,false);
}if ( ((empty($cmd) || Aspis_empty( $cmd))))
 {$this->ERROR = concat1("POP3 send_cmd: ",_(array("Empty command string",false)));
return array("",false);
}$fp = $this->FP;
$buffer = $this->BUFFER;
$this->update_timer();
fwrite($fp[0],(deconcat2($cmd,"\r\n")));
$reply = attAspis(fgets($fp[0],$buffer[0]));
$reply = $this->strip_clf($reply);
if ( $this->DEBUG[0])
 {@array(error_log((deconcat2(concat(concat2(concat1("POP3 SEND [",$cmd),"] GOT ["),$reply),"]")),0),false);
}return $reply;
} }
function quit (  ) {
{if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 quit: ",_(array("connection does not exist",false)));
return array(false,false);
}$fp = $this->FP;
$cmd = array("QUIT",false);
fwrite($fp[0],(deconcat2($cmd,"\r\n")));
$reply = attAspis(fgets($fp[0],$this->BUFFER[0]));
$reply = $this->strip_clf($reply);
if ( $this->DEBUG[0])
 {@array(error_log((deconcat2(concat(concat2(concat1("POP3 SEND [",$cmd),"] GOT ["),$reply),"]")),0),false);
}fclose($fp[0]);
unset($this->FP);
return array(true,false);
} }
function popstat (  ) {
{$PopArray = $this->last(array("array",false));
if ( ($PopArray[0] == deAspis(negate(array(1,false)))))
 {return array(false,false);
}if ( ((denot_boolean($PopArray)) or ((empty($PopArray) || Aspis_empty( $PopArray)))))
 {return array(false,false);
}return $PopArray;
} }
function uidl ( $msgNum = array("",false) ) {
{if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 uidl: ",_(array("No connection to server",false)));
return array(false,false);
}$fp = $this->FP;
$buffer = $this->BUFFER;
if ( (!((empty($msgNum) || Aspis_empty( $msgNum)))))
 {$cmd = concat1("UIDL ",$msgNum);
$reply = $this->send_cmd($cmd);
if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 uidl: ",_(array("Error ",false))),concat2(concat1("[",$reply),"]"));
return array(false,false);
}list($ok,$num,$myUidl) = deAspisList(Aspis_preg_split(array('/\s+/',false),$reply),array());
return $myUidl;
}else 
{{$this->update_timer();
$UIDLArray = array(array(),false);
$Total = $this->COUNT;
arrayAssign($UIDLArray[0],deAspis(registerTaint(array(0,false))),addTaint($Total));
if ( ($Total[0] < (1)))
 {return $UIDLArray;
}$cmd = array("UIDL",false);
fwrite($fp[0],("UIDL\r\n"));
$reply = attAspis(fgets($fp[0],$buffer[0]));
$reply = $this->strip_clf($reply);
if ( $this->DEBUG[0])
 {@array(error_log((deconcat2(concat(concat2(concat1("POP3 SEND [",$cmd),"] GOT ["),$reply),"]")),0),false);
}if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 uidl: ",_(array("Error ",false))),concat2(concat1("[",$reply),"]"));
return array(false,false);
}$line = array("",false);
$count = array(1,false);
$line = attAspis(fgets($fp[0],$buffer[0]));
while ( (!(ereg(("^\.\r\n"),$line[0]))) )
{if ( ereg(("^\.\r\n"),$line[0]))
 {break ;
}list($msg,$msgUidl) = deAspisList(Aspis_preg_split(array('/\s+/',false),$line),array());
$msgUidl = $this->strip_clf($msgUidl);
if ( ($count[0] == $msg[0]))
 {arrayAssign($UIDLArray[0],deAspis(registerTaint($msg)),addTaint($msgUidl));
}else 
{{arrayAssign($UIDLArray[0],deAspis(registerTaint($count)),addTaint(array('deleted',false)));
}}postincr($count);
$line = attAspis(fgets($fp[0],$buffer[0]));
}}}return $UIDLArray;
} }
function delete ( $msgNum = array("",false) ) {
{if ( (!((isset($this->FP) && Aspis_isset( $this ->FP )))))
 {$this->ERROR = concat1("POP3 delete: ",_(array("No connection to server",false)));
return array(false,false);
}if ( ((empty($msgNum) || Aspis_empty( $msgNum))))
 {$this->ERROR = concat1("POP3 delete: ",_(array("No msg number submitted",false)));
return array(false,false);
}$reply = $this->send_cmd(concat1("DELE ",$msgNum));
if ( (denot_boolean($this->is_ok($reply))))
 {$this->ERROR = concat(concat1("POP3 delete: ",_(array("Command failed ",false))),concat2(concat1("[",$reply),"]"));
return array(false,false);
}return array(true,false);
} }
function is_ok ( $cmd = array("",false) ) {
{if ( ((empty($cmd) || Aspis_empty( $cmd))))
 return array(false,false);
else 
{return (attAspis(ereg(("^\+OK"),$cmd[0])));
}} }
function strip_clf ( $text = array("",false) ) {
{if ( ((empty($text) || Aspis_empty( $text))))
 return $text;
else 
{{$stripped = Aspis_str_replace(array("\r",false),array('',false),$text);
$stripped = Aspis_str_replace(array("\n",false),array('',false),$stripped);
return $stripped;
}}} }
function parse_banner ( $server_text ) {
{$outside = array(true,false);
$banner = array("",false);
$length = attAspis(strlen($server_text[0]));
for ( $count = array(0,false) ; ($count[0] < $length[0]) ; postincr($count) )
{$digit = Aspis_substr($server_text,$count,array(1,false));
if ( (!((empty($digit) || Aspis_empty( $digit)))))
 {if ( (((denot_boolean($outside)) && ($digit[0] != ('<'))) && ($digit[0] != ('>'))))
 {$banner = concat($banner,$digit);
}if ( ($digit[0] == ('<')))
 {$outside = array(false,false);
}if ( ($digit[0] == ('>')))
 {$outside = array(true,false);
}}}$banner = $this->strip_clf($banner);
return concat2(concat1("<",$banner),">");
} }
};
?>
<?php 