<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('CRLF')))))
 define(('CRLF'),"\r\n");
if ( (!(defined(("FTP_AUTOASCII")))))
 define(("FTP_AUTOASCII"),deAspisRC(negate(array(1,false))));
if ( (!(defined(("FTP_BINARY")))))
 define(("FTP_BINARY"),1);
if ( (!(defined(("FTP_ASCII")))))
 define(("FTP_ASCII"),0);
if ( (!(defined(('FTP_FORCE')))))
 define(('FTP_FORCE'),true);
define(('FTP_OS_Unix'),'u');
define(('FTP_OS_Windows'),'w');
define(('FTP_OS_Mac'),'m');
class ftp_base{var $LocalEcho;
var $Verbose;
var $OS_local;
var $OS_remote;
var $_lastaction;
var $_errors;
var $_type;
var $_umask;
var $_timeout;
var $_passive;
var $_host;
var $_fullhost;
var $_port;
var $_datahost;
var $_dataport;
var $_ftp_control_sock;
var $_ftp_data_sock;
var $_ftp_temp_sock;
var $_ftp_buff_size;
var $_login;
var $_password;
var $_connected;
var $_ready;
var $_code;
var $_message;
var $_can_restore;
var $_port_available;
var $_curtype;
var $_features;
var $_error_array;
var $AuthorizedTransferMode;
var $OS_FullName;
var $_eol_code;
var $AutoAsciiExt;
function ftp_base ( $port_mode = array(FALSE,false) ) {
{$this->__construct($port_mode);
} }
function __construct ( $port_mode = array(FALSE,false),$verb = array(FALSE,false),$le = array(FALSE,false) ) {
{$this->LocalEcho = $le;
$this->Verbose = $verb;
$this->_lastaction = array(NULL,false);
$this->_error_array = array(array(),false);
$this->_eol_code = array(array(FTP_OS_Unix => array("\n",false,false),FTP_OS_Mac => array("\r",false,false),FTP_OS_Windows => array("\r\n",false,false)),false);
$this->AuthorizedTransferMode = array(array(array(FTP_AUTOASCII,false),array(FTP_ASCII,false),array(FTP_BINARY,false)),false);
$this->OS_FullName = array(array(FTP_OS_Unix => array('UNIX',false,false),FTP_OS_Windows => array('WINDOWS',false,false),FTP_OS_Mac => array('MACOS',false,false)),false);
$this->AutoAsciiExt = array(array(array("ASP",false),array("BAT",false),array("C",false),array("CPP",false),array("CSS",false),array("CSV",false),array("JS",false),array("H",false),array("HTM",false),array("HTML",false),array("SHTML",false),array("INI",false),array("LOG",false),array("PHP3",false),array("PHTML",false),array("PL",false),array("PERL",false),array("SH",false),array("SQL",false),array("TXT",false)),false);
$this->_port_available = (array($port_mode[0] == TRUE,false));
$this->SendMSG(concat1("Staring FTP client class",($this->_port_available[0] ? array("",false) : array(" without PORT mode support",false))));
$this->_connected = array(FALSE,false);
$this->_ready = array(FALSE,false);
$this->_can_restore = array(FALSE,false);
$this->_code = array(0,false);
$this->_message = array("",false);
$this->_ftp_buff_size = array(4096,false);
$this->_curtype = array(NULL,false);
$this->SetUmask(array(0022,false));
$this->SetType(array(FTP_AUTOASCII,false));
$this->SetTimeout(array(30,false));
$this->Passive(not_boolean($this->_port_available));
$this->_login = array("anonymous",false);
$this->_password = array("anon@ftp.com",false);
$this->_features = array(array(),false);
$this->OS_local = array(FTP_OS_Unix,false);
$this->OS_remote = array(FTP_OS_Unix,false);
$this->features = array(array(),false);
if ( (deAspis(Aspis_strtoupper(Aspis_substr(array(PHP_OS,false),array(0,false),array(3,false)))) === ('WIN')))
 $this->OS_local = array(FTP_OS_Windows,false);
elseif ( (deAspis(Aspis_strtoupper(Aspis_substr(array(PHP_OS,false),array(0,false),array(3,false)))) === ('MAC')))
 $this->OS_local = array(FTP_OS_Mac,false);
} }
function parselisting ( $line ) {
{$is_windows = (array($this->OS_remote[0] == FTP_OS_Windows,false));
if ( ($is_windows[0] && deAspis(Aspis_preg_match(array("/([0-9]{2})-([0-9]{2})-([0-9]{2}) +([0-9]{2}):([0-9]{2})(AM|PM) +([0-9]+|<DIR>) +(.+)/",false),$line,$lucifer))))
 {$b = array(array(),false);
if ( (deAspis(attachAspis($lucifer,(3))) < (70)))
 {arrayAssign($lucifer[0],deAspis(registerTaint(array(3,false))),addTaint(array((2000) + deAspis(attachAspis($lucifer,(3))),false)));
}else 
{{arrayAssign($lucifer[0],deAspis(registerTaint(array(3,false))),addTaint(array((1900) + deAspis(attachAspis($lucifer,(3))),false)));
}}arrayAssign($b[0],deAspis(registerTaint(array('isdir',false))),addTaint((array(deAspis(attachAspis($lucifer,(7))) == ("<DIR>"),false))));
if ( deAspis($b[0]['isdir']))
 arrayAssign($b[0],deAspis(registerTaint(array('type',false))),addTaint(array('d',false)));
else 
{arrayAssign($b[0],deAspis(registerTaint(array('type',false))),addTaint(array('f',false)));
}arrayAssign($b[0],deAspis(registerTaint(array('size',false))),addTaint(attachAspis($lucifer,(7))));
arrayAssign($b[0],deAspis(registerTaint(array('month',false))),addTaint(attachAspis($lucifer,(1))));
arrayAssign($b[0],deAspis(registerTaint(array('day',false))),addTaint(attachAspis($lucifer,(2))));
arrayAssign($b[0],deAspis(registerTaint(array('year',false))),addTaint(attachAspis($lucifer,(3))));
arrayAssign($b[0],deAspis(registerTaint(array('hour',false))),addTaint(attachAspis($lucifer,(4))));
arrayAssign($b[0],deAspis(registerTaint(array('minute',false))),addTaint(attachAspis($lucifer,(5))));
arrayAssign($b[0],deAspis(registerTaint(array('time',false))),addTaint(@attAspis(mktime((deAspis(attachAspis($lucifer,(4))) + ((strcasecmp(deAspis(attachAspis($lucifer,(6))),("PM")) == (0)) ? (12) : (0))),deAspis(attachAspis($lucifer,(5))),(0),deAspis(attachAspis($lucifer,(1))),deAspis(attachAspis($lucifer,(2))),deAspis(attachAspis($lucifer,(3)))))));
arrayAssign($b[0],deAspis(registerTaint(array('am/pm',false))),addTaint(attachAspis($lucifer,(6))));
arrayAssign($b[0],deAspis(registerTaint(array('name',false))),addTaint(attachAspis($lucifer,(8))));
}else 
{if ( ((denot_boolean($is_windows)) && deAspis($lucifer = Aspis_preg_split(array("/[ ]/",false),$line,array(9,false),array(PREG_SPLIT_NO_EMPTY,false)))))
 {$lcount = attAspis(count($lucifer[0]));
if ( ($lcount[0] < (8)))
 return array('',false);
$b = array(array(),false);
arrayAssign($b[0],deAspis(registerTaint(array('isdir',false))),addTaint(array(deAspis(attachAspis($lucifer[0][(0)],(0))) === ("d"),false)));
arrayAssign($b[0],deAspis(registerTaint(array('islink',false))),addTaint(array(deAspis(attachAspis($lucifer[0][(0)],(0))) === ("l"),false)));
if ( deAspis($b[0]['isdir']))
 arrayAssign($b[0],deAspis(registerTaint(array('type',false))),addTaint(array('d',false)));
elseif ( deAspis($b[0]['islink']))
 arrayAssign($b[0],deAspis(registerTaint(array('type',false))),addTaint(array('l',false)));
else 
{arrayAssign($b[0],deAspis(registerTaint(array('type',false))),addTaint(array('f',false)));
}arrayAssign($b[0],deAspis(registerTaint(array('perms',false))),addTaint(attachAspis($lucifer,(0))));
arrayAssign($b[0],deAspis(registerTaint(array('number',false))),addTaint(attachAspis($lucifer,(1))));
arrayAssign($b[0],deAspis(registerTaint(array('owner',false))),addTaint(attachAspis($lucifer,(2))));
arrayAssign($b[0],deAspis(registerTaint(array('group',false))),addTaint(attachAspis($lucifer,(3))));
arrayAssign($b[0],deAspis(registerTaint(array('size',false))),addTaint(attachAspis($lucifer,(4))));
if ( ($lcount[0] == (8)))
 {AspisInternalFunctionCall("sscanf",deAspis(attachAspis($lucifer,(5))),("%d-%d-%d"),AspisPushRefParam($b[0]['year']),AspisPushRefParam($b[0]['month']),AspisPushRefParam($b[0]['day']),array(2,3,4));
AspisInternalFunctionCall("sscanf",deAspis(attachAspis($lucifer,(6))),("%d:%d"),AspisPushRefParam($b[0]['hour']),AspisPushRefParam($b[0]['minute']),array(2,3));
arrayAssign($b[0],deAspis(registerTaint(array('time',false))),addTaint(@attAspis(mktime(deAspis($b[0]['hour']),deAspis($b[0]['minute']),(0),deAspis($b[0]['month']),deAspis($b[0]['day']),deAspis($b[0]['year'])))));
arrayAssign($b[0],deAspis(registerTaint(array('name',false))),addTaint(attachAspis($lucifer,(7))));
}else 
{{arrayAssign($b[0],deAspis(registerTaint(array('month',false))),addTaint(attachAspis($lucifer,(5))));
arrayAssign($b[0],deAspis(registerTaint(array('day',false))),addTaint(attachAspis($lucifer,(6))));
if ( deAspis(Aspis_preg_match(array("/([0-9]{2}):([0-9]{2})/",false),attachAspis($lucifer,(7)),$l2)))
 {arrayAssign($b[0],deAspis(registerTaint(array('year',false))),addTaint(attAspis(date(("Y")))));
arrayAssign($b[0],deAspis(registerTaint(array('hour',false))),addTaint(attachAspis($l2,(1))));
arrayAssign($b[0],deAspis(registerTaint(array('minute',false))),addTaint(attachAspis($l2,(2))));
}else 
{{arrayAssign($b[0],deAspis(registerTaint(array('year',false))),addTaint(attachAspis($lucifer,(7))));
arrayAssign($b[0],deAspis(registerTaint(array('hour',false))),addTaint(array(0,false)));
arrayAssign($b[0],deAspis(registerTaint(array('minute',false))),addTaint(array(0,false)));
}}arrayAssign($b[0],deAspis(registerTaint(array('time',false))),addTaint(attAspis(strtotime(deAspis(Aspis_sprintf(array("%d %s %d %02d:%02d",false),$b[0]['day'],$b[0]['month'],$b[0]['year'],$b[0]['hour'],$b[0]['minute']))))));
arrayAssign($b[0],deAspis(registerTaint(array('name',false))),addTaint(attachAspis($lucifer,(8))));
}}}}return $b;
} }
function SendMSG ( $message = array("",false),$crlf = array(true,false) ) {
{if ( $this->Verbose[0])
 {echo AspisCheckPrint(concat($message,($crlf[0] ? array(CRLF,false) : array("",false))));
flush();
}return array(TRUE,false);
} }
function SetType ( $mode = array(FTP_AUTOASCII,false) ) {
{if ( (denot_boolean(Aspis_in_array($mode,$this->AuthorizedTransferMode))))
 {$this->SendMSG(array("Wrong type",false));
return array(FALSE,false);
}$this->_type = $mode;
$this->SendMSG(concat1("Transfer type: ",(($this->_type[0] == FTP_BINARY) ? array("binary",false) : (($this->_type[0] == FTP_ASCII) ? array("ASCII",false) : array("auto ASCII",false)))));
return array(TRUE,false);
} }
function _settype ( $mode = array(FTP_ASCII,false) ) {
{if ( $this->_ready[0])
 {if ( ($mode[0] == FTP_BINARY))
 {if ( ($this->_curtype[0] != FTP_BINARY))
 {if ( (denot_boolean($this->_exec(array("TYPE I",false),array("SetType",false)))))
 return array(FALSE,false);
$this->_curtype = array(FTP_BINARY,false);
}}elseif ( ($this->_curtype[0] != FTP_ASCII))
 {if ( (denot_boolean($this->_exec(array("TYPE A",false),array("SetType",false)))))
 return array(FALSE,false);
$this->_curtype = array(FTP_ASCII,false);
}}else 
{return array(FALSE,false);
}return array(TRUE,false);
} }
function Passive ( $pasv = array(NULL,false) ) {
{if ( is_null(deAspisRC($pasv)))
 $this->_passive = not_boolean($this->_passive);
else 
{$this->_passive = $pasv;
}if ( ((denot_boolean($this->_port_available)) and (denot_boolean($this->_passive))))
 {$this->SendMSG(array("Only passive connections available!",false));
$this->_passive = array(TRUE,false);
return array(FALSE,false);
}$this->SendMSG(concat1("Passive mode ",($this->_passive[0] ? array("on",false) : array("off",false))));
return array(TRUE,false);
} }
function SetServer ( $host,$port = array(21,false),$reconnect = array(true,false) ) {
{if ( (!(is_long(deAspisRC($port)))))
 {$this->verbose = array(true,false);
$this->SendMSG(array("Incorrect port syntax",false));
return array(FALSE,false);
}else 
{{$ip = @attAspis(gethostbyname($host[0]));
$dns = @attAspis(gethostbyaddr($host[0]));
if ( (denot_boolean($ip)))
 $ip = $host;
if ( (denot_boolean($dns)))
 $dns = $host;
$ipaslong = attAspis(ip2long($ip[0]));
if ( (($ipaslong[0] == false) || ($ipaslong[0] === deAspis(negate(array(1,false))))))
 {$this->SendMSG(concat2(concat1("Wrong host name/address \"",$host),"\""));
return array(FALSE,false);
}$this->_host = $ip;
$this->_fullhost = $dns;
$this->_port = $port;
$this->_dataport = array($port[0] - (1),false);
}}$this->SendMSG(concat2(concat(concat2(concat(concat2(concat1("Host \"",$this->_fullhost),"("),$this->_host),"):"),$this->_port),"\""));
if ( $reconnect[0])
 {if ( $this->_connected[0])
 {$this->SendMSG(array("Reconnecting",false));
if ( (denot_boolean($this->quit(array(FTP_FORCE,false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->connect())))
 return array(FALSE,false);
}}return array(TRUE,false);
} }
function SetUmask ( $umask = array(0022,false) ) {
{$this->_umask = $umask;
umask($this->_umask[0]);
$this->SendMSG(concat1("UMASK 0",Aspis_decoct($this->_umask)));
return array(TRUE,false);
} }
function SetTimeout ( $timeout = array(30,false) ) {
{$this->_timeout = $timeout;
$this->SendMSG(concat1("Timeout ",$this->_timeout));
if ( $this->_connected[0])
 if ( (denot_boolean($this->_settimeout($this->_ftp_control_sock))))
 return array(FALSE,false);
return array(TRUE,false);
} }
function connect ( $server = array(NULL,false) ) {
{if ( (!((empty($server) || Aspis_empty( $server)))))
 {if ( (denot_boolean($this->SetServer($server))))
 return array(false,false);
}if ( $this->_ready[0])
 return array(true,false);
$this->SendMsg(concat1('Local OS : ',$this->OS_FullName[0][$this->OS_local[0]]));
if ( (denot_boolean(($this->_ftp_control_sock = $this->_connect($this->_host,$this->_port)))))
 {$this->SendMSG(concat2(concat(concat2(concat1("Error : Cannot connect to remote host \"",$this->_fullhost)," :"),$this->_port),"\""));
return array(FALSE,false);
}$this->SendMSG(concat2(concat(concat2(concat1("Connected to remote host \"",$this->_fullhost),":"),$this->_port),"\". Waiting for greeting."));
do {if ( (denot_boolean($this->_readmsg())))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
$this->_lastaction = attAspis(time());
}while (($this->_code[0] < (200)) )
;
$this->_ready = array(true,false);
$syst = $this->systype();
if ( (denot_boolean($syst)))
 $this->SendMSG(array("Can't detect remote OS",false));
else 
{{if ( deAspis(Aspis_preg_match(array("/win|dos|novell/i",false),attachAspis($syst,(0)))))
 $this->OS_remote = array(FTP_OS_Windows,false);
elseif ( deAspis(Aspis_preg_match(array("/os/i",false),attachAspis($syst,(0)))))
 $this->OS_remote = array(FTP_OS_Mac,false);
elseif ( deAspis(Aspis_preg_match(array("/(li|u)nix/i",false),attachAspis($syst,(0)))))
 $this->OS_remote = array(FTP_OS_Unix,false);
else 
{$this->OS_remote = array(FTP_OS_Mac,false);
}$this->SendMSG(concat1("Remote OS: ",$this->OS_FullName[0][$this->OS_remote[0]]));
}}if ( (denot_boolean($this->features())))
 $this->SendMSG(array("Can't get features list. All supported - disabled",false));
else 
{$this->SendMSG(concat1("Supported features: ",Aspis_implode(array(", ",false),attAspisRC(array_keys(deAspisRC($this->_features))))));
}return array(TRUE,false);
} }
function quit ( $force = array(false,false) ) {
{if ( $this->_ready[0])
 {if ( ((denot_boolean($this->_exec(array("QUIT",false)))) and (denot_boolean($force))))
 return array(FALSE,false);
if ( ((denot_boolean($this->_checkCode())) and (denot_boolean($force))))
 return array(FALSE,false);
$this->_ready = array(false,false);
$this->SendMSG(array("Session finished",false));
}$this->_quit();
return array(TRUE,false);
} }
function login ( $user = array(NULL,false),$pass = array(NULL,false) ) {
{if ( (!(is_null(deAspisRC($user)))))
 $this->_login = $user;
else 
{$this->_login = array("anonymous",false);
}if ( (!(is_null(deAspisRC($pass)))))
 $this->_password = $pass;
else 
{$this->_password = array("anon@anon.com",false);
}if ( (denot_boolean($this->_exec(concat1("USER ",$this->_login),array("login",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
if ( ($this->_code[0] != (230)))
 {if ( (denot_boolean($this->_exec(concat((($this->_code[0] == (331)) ? array("PASS ",false) : array("ACCT ",false)),$this->_password),array("login",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
}$this->SendMSG(array("Authentication succeeded",false));
if ( ((empty($this->_features) || Aspis_empty( $this ->_features ))))
 {if ( (denot_boolean($this->features())))
 $this->SendMSG(array("Can't get features list. All supported - disabled",false));
else 
{$this->SendMSG(concat1("Supported features: ",Aspis_implode(array(", ",false),attAspisRC(array_keys(deAspisRC($this->_features))))));
}}return array(TRUE,false);
} }
function pwd (  ) {
{if ( (denot_boolean($this->_exec(array("PWD",false),array("pwd",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return Aspis_ereg_replace(array("^[0-9]{3} \"(.+)\".+",false),array("\\1",false),$this->_message);
} }
function cdup (  ) {
{if ( (denot_boolean($this->_exec(array("CDUP",false),array("cdup",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return array(true,false);
} }
function chdir ( $pathname ) {
{if ( (denot_boolean($this->_exec(concat1("CWD ",$pathname),array("chdir",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return array(TRUE,false);
} }
function rmdir ( $pathname ) {
{if ( (denot_boolean($this->_exec(concat1("RMD ",$pathname),array("rmdir",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return array(TRUE,false);
} }
function mkdir ( $pathname ) {
{if ( (denot_boolean($this->_exec(concat1("MKD ",$pathname),array("mkdir",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return array(TRUE,false);
} }
function rename ( $from,$to ) {
{if ( (denot_boolean($this->_exec(concat1("RNFR ",$from),array("rename",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
if ( ($this->_code[0] == (350)))
 {if ( (denot_boolean($this->_exec(concat1("RNTO ",$to),array("rename",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
}else 
{return array(FALSE,false);
}return array(TRUE,false);
} }
function filesize ( $pathname ) {
{if ( (!((isset($this->_features[0][("SIZE")]) && Aspis_isset( $this ->_features [0][("SIZE")] )))))
 {$this->PushError(array("filesize",false),array("not supported by server",false));
return array(FALSE,false);
}if ( (denot_boolean($this->_exec(concat1("SIZE ",$pathname),array("filesize",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return Aspis_ereg_replace(concat12("^[0-9]{3} ([0-9]+)",CRLF),array("\\1",false),$this->_message);
} }
function abort (  ) {
{if ( (denot_boolean($this->_exec(array("ABOR",false),array("abort",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 {if ( ($this->_code[0] != (426)))
 return array(FALSE,false);
if ( (denot_boolean($this->_readmsg(array("abort",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
}return array(true,false);
} }
function mdtm ( $pathname ) {
{if ( (!((isset($this->_features[0][("MDTM")]) && Aspis_isset( $this ->_features [0][("MDTM")] )))))
 {$this->PushError(array("mdtm",false),array("not supported by server",false));
return array(FALSE,false);
}if ( (denot_boolean($this->_exec(concat1("MDTM ",$pathname),array("mdtm",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
$mdtm = Aspis_ereg_replace(concat12("^[0-9]{3} ([0-9]+)",CRLF),array("\\1",false),$this->_message);
$date = attAspisRC(sscanf($mdtm[0],("%4d%2d%2d%2d%2d%2d")));
$timestamp = attAspis(mktime(deAspis(attachAspis($date,(3))),deAspis(attachAspis($date,(4))),deAspis(attachAspis($date,(5))),deAspis(attachAspis($date,(1))),deAspis(attachAspis($date,(2))),deAspis(attachAspis($date,(0)))));
return $timestamp;
} }
function systype (  ) {
{if ( (denot_boolean($this->_exec(array("SYST",false),array("systype",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
$DATA = Aspis_explode(array(" ",false),$this->_message);
return array(array(attachAspis($DATA,(1)),attachAspis($DATA,(3))),false);
} }
function delete ( $pathname ) {
{if ( (denot_boolean($this->_exec(concat1("DELE ",$pathname),array("delete",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return array(TRUE,false);
} }
function site ( $command,$fnction = array("site",false) ) {
{if ( (denot_boolean($this->_exec(concat1("SITE ",$command),$fnction))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return array(TRUE,false);
} }
function chmod ( $pathname,$mode ) {
{if ( (denot_boolean($this->site(Aspis_sprintf(array('CHMOD %o %s',false),$mode,$pathname),array("chmod",false)))))
 return array(FALSE,false);
return array(TRUE,false);
} }
function restore ( $from ) {
{if ( (!((isset($this->_features[0][("REST")]) && Aspis_isset( $this ->_features [0][("REST")] )))))
 {$this->PushError(array("restore",false),array("not supported by server",false));
return array(FALSE,false);
}if ( ($this->_curtype[0] != FTP_BINARY))
 {$this->PushError(array("restore",false),array("can't restore in ASCII mode",false));
return array(FALSE,false);
}if ( (denot_boolean($this->_exec(concat1("REST ",$from),array("resore",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return array(TRUE,false);
} }
function features (  ) {
{if ( (denot_boolean($this->_exec(array("FEAT",false),array("features",false)))))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
$f = Aspis_preg_split(concat2(concat12("/[",CRLF),"]+/"),Aspis_preg_replace(concat2(concat12("/[0-9]{3}[ -].*[",CRLF),"]+/"),array("",false),$this->_message),negate(array(1,false)),array(PREG_SPLIT_NO_EMPTY,false));
$this->_features = array(array(),false);
foreach ( $f[0] as $k =>$v )
{restoreTaint($k,$v);
{$v = Aspis_explode(array(" ",false),Aspis_trim($v));
arrayAssign($this->_features[0],deAspis(registerTaint(Aspis_array_shift($v))),addTaint($v));
;
}}return array(true,false);
} }
function rawlist ( $pathname = array("",false),$arg = array("",false) ) {
{return $this->_list(concat(($arg[0] ? concat1(" ",$arg) : array("",false)),($pathname[0] ? concat1(" ",$pathname) : array("",false))),array("LIST",false),array("rawlist",false));
} }
function nlist ( $pathname = array("",false) ) {
{return $this->_list(concat(($arg[0] ? concat1(" ",$arg) : array("",false)),($pathname[0] ? concat1(" ",$pathname) : array("",false))),array("NLST",false),array("nlist",false));
} }
function is_exists ( $pathname ) {
{return $this->file_exists($pathname);
} }
function file_exists ( $pathname ) {
{$exists = array(true,false);
if ( (denot_boolean($this->_exec(concat1("RNFR ",$pathname),array("rename",false)))))
 $exists = array(FALSE,false);
else 
{{if ( (denot_boolean($this->_checkCode())))
 $exists = array(FALSE,false);
$this->abort();
}}if ( $exists[0])
 $this->SendMSG(concat2(concat1("Remote file ",$pathname)," exists"));
else 
{$this->SendMSG(concat2(concat1("Remote file ",$pathname)," does not exist"));
}return $exists;
} }
function fget ( $fp,$remotefile,$rest = array(0,false) ) {
{if ( ($this->_can_restore[0] and ($rest[0] != (0))))
 fseek($fp[0],$rest[0]);
$pi = Aspis_pathinfo($remotefile);
if ( (($this->_type[0] == FTP_ASCII) or (($this->_type[0] == FTP_AUTOASCII) and deAspis(Aspis_in_array(Aspis_strtoupper($pi[0]["extension"]),$this->AutoAsciiExt)))))
 $mode = array(FTP_ASCII,false);
else 
{$mode = array(FTP_BINARY,false);
}if ( (denot_boolean($this->_data_prepare($mode))))
 {return array(FALSE,false);
}if ( ($this->_can_restore[0] and ($rest[0] != (0))))
 $this->restore($rest);
if ( (denot_boolean($this->_exec(concat1("RETR ",$remotefile),array("get",false)))))
 {$this->_data_close();
return array(FALSE,false);
}if ( (denot_boolean($this->_checkCode())))
 {$this->_data_close();
return array(FALSE,false);
}$out = $this->_data_read($mode,$fp);
$this->_data_close();
if ( (denot_boolean($this->_readmsg())))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return $out;
} }
function get ( $remotefile,$localfile = array(NULL,false),$rest = array(0,false) ) {
{if ( is_null(deAspisRC($localfile)))
 $localfile = $remotefile;
if ( deAspis(@attAspis(file_exists($localfile[0]))))
 $this->SendMSG(array("Warning : local file will be overwritten",false));
$fp = @attAspis(fopen($localfile[0],("w")));
if ( (denot_boolean($fp)))
 {$this->PushError(array("get",false),array("can't open local file",false),concat2(concat1("Cannot create \"",$localfile),"\""));
return array(FALSE,false);
}if ( ($this->_can_restore[0] and ($rest[0] != (0))))
 fseek($fp[0],$rest[0]);
$pi = Aspis_pathinfo($remotefile);
if ( (($this->_type[0] == FTP_ASCII) or (($this->_type[0] == FTP_AUTOASCII) and deAspis(Aspis_in_array(Aspis_strtoupper($pi[0]["extension"]),$this->AutoAsciiExt)))))
 $mode = array(FTP_ASCII,false);
else 
{$mode = array(FTP_BINARY,false);
}if ( (denot_boolean($this->_data_prepare($mode))))
 {fclose($fp[0]);
return array(FALSE,false);
}if ( ($this->_can_restore[0] and ($rest[0] != (0))))
 $this->restore($rest);
if ( (denot_boolean($this->_exec(concat1("RETR ",$remotefile),array("get",false)))))
 {$this->_data_close();
fclose($fp[0]);
return array(FALSE,false);
}if ( (denot_boolean($this->_checkCode())))
 {$this->_data_close();
fclose($fp[0]);
return array(FALSE,false);
}$out = $this->_data_read($mode,$fp);
fclose($fp[0]);
$this->_data_close();
if ( (denot_boolean($this->_readmsg())))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return $out;
} }
function fput ( $remotefile,$fp ) {
{if ( ($this->_can_restore[0] and ($rest[0] != (0))))
 fseek($fp[0],$rest[0]);
$pi = Aspis_pathinfo($remotefile);
if ( (($this->_type[0] == FTP_ASCII) or (($this->_type[0] == FTP_AUTOASCII) and deAspis(Aspis_in_array(Aspis_strtoupper($pi[0]["extension"]),$this->AutoAsciiExt)))))
 $mode = array(FTP_ASCII,false);
else 
{$mode = array(FTP_BINARY,false);
}if ( (denot_boolean($this->_data_prepare($mode))))
 {return array(FALSE,false);
}if ( ($this->_can_restore[0] and ($rest[0] != (0))))
 $this->restore($rest);
if ( (denot_boolean($this->_exec(concat1("STOR ",$remotefile),array("put",false)))))
 {$this->_data_close();
return array(FALSE,false);
}if ( (denot_boolean($this->_checkCode())))
 {$this->_data_close();
return array(FALSE,false);
}$ret = $this->_data_write($mode,$fp);
$this->_data_close();
if ( (denot_boolean($this->_readmsg())))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return $ret;
} }
function put ( $localfile,$remotefile = array(NULL,false),$rest = array(0,false) ) {
{if ( is_null(deAspisRC($remotefile)))
 $remotefile = $localfile;
if ( (!(file_exists($localfile[0]))))
 {$this->PushError(array("put",false),array("can't open local file",false),concat2(concat1("No such file or directory \"",$localfile),"\""));
return array(FALSE,false);
}$fp = @attAspis(fopen($localfile[0],("r")));
if ( (denot_boolean($fp)))
 {$this->PushError(array("put",false),array("can't open local file",false),concat2(concat1("Cannot read file \"",$localfile),"\""));
return array(FALSE,false);
}if ( ($this->_can_restore[0] and ($rest[0] != (0))))
 fseek($fp[0],$rest[0]);
$pi = Aspis_pathinfo($localfile);
if ( (($this->_type[0] == FTP_ASCII) or (($this->_type[0] == FTP_AUTOASCII) and deAspis(Aspis_in_array(Aspis_strtoupper($pi[0]["extension"]),$this->AutoAsciiExt)))))
 $mode = array(FTP_ASCII,false);
else 
{$mode = array(FTP_BINARY,false);
}if ( (denot_boolean($this->_data_prepare($mode))))
 {fclose($fp[0]);
return array(FALSE,false);
}if ( ($this->_can_restore[0] and ($rest[0] != (0))))
 $this->restore($rest);
if ( (denot_boolean($this->_exec(concat1("STOR ",$remotefile),array("put",false)))))
 {$this->_data_close();
fclose($fp[0]);
return array(FALSE,false);
}if ( (denot_boolean($this->_checkCode())))
 {$this->_data_close();
fclose($fp[0]);
return array(FALSE,false);
}$ret = $this->_data_write($mode,$fp);
fclose($fp[0]);
$this->_data_close();
if ( (denot_boolean($this->_readmsg())))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
return $ret;
} }
function mput ( $local = array(".",false),$remote = array(NULL,false),$continious = array(false,false) ) {
{$local = Aspis_realpath($local);
if ( (denot_boolean(@attAspis(file_exists($local[0])))))
 {$this->PushError(array("mput",false),array("can't open local folder",false),concat2(concat1("Cannot stat folder \"",$local),"\""));
return array(FALSE,false);
}if ( (!(is_dir($local[0]))))
 return $this->put($local,$remote);
if ( ((empty($remote) || Aspis_empty( $remote))))
 $remote = array(".",false);
elseif ( ((denot_boolean($this->file_exists($remote))) and (denot_boolean($this->mkdir($remote)))))
 return array(FALSE,false);
if ( deAspis($handle = attAspis(opendir($local[0]))))
 {$list = array(array(),false);
while ( (false !== deAspis(($file = attAspis(readdir($handle[0]))))) )
{if ( (($file[0] != (".")) && ($file[0] != (".."))))
 arrayAssignAdd($list[0][],addTaint($file));
}closedir($handle[0]);
}else 
{{$this->PushError(array("mput",false),array("can't open local folder",false),concat2(concat1("Cannot read folder \"",$local),"\""));
return array(FALSE,false);
}}if ( ((empty($list) || Aspis_empty( $list))))
 return array(TRUE,false);
$ret = array(true,false);
foreach ( $list[0] as $el  )
{if ( is_dir((deconcat(concat2($local,"/"),$el))))
 $t = $this->mput(concat(concat2($local,"/"),$el),concat(concat2($remote,"/"),$el));
else 
{$t = $this->put(concat(concat2($local,"/"),$el),concat(concat2($remote,"/"),$el));
}if ( (denot_boolean($t)))
 {$ret = array(FALSE,false);
if ( (denot_boolean($continious)))
 break ;
}}return $ret;
} }
function mget ( $remote,$local = array(".",false),$continious = array(false,false) ) {
{$list = $this->rawlist($remote,array("-lA",false));
if ( ($list[0] === false))
 {$this->PushError(array("mget",false),array("can't read remote folder list",false),concat2(concat1("Can't read remote folder \"",$remote),"\" contents"));
return array(FALSE,false);
}if ( ((empty($list) || Aspis_empty( $list))))
 return array(true,false);
if ( (denot_boolean(@attAspis(file_exists($local[0])))))
 {if ( (denot_boolean(@attAspis(mkdir($local[0])))))
 {$this->PushError(array("mget",false),array("can't create local folder",false),concat2(concat1("Cannot create folder \"",$local),"\""));
return array(FALSE,false);
}}foreach ( $list[0] as $k =>$v )
{restoreTaint($k,$v);
{arrayAssign($list[0],deAspis(registerTaint($k)),addTaint($this->parselisting($v)));
if ( ((deAspis($list[0][$k[0]][0]["name"]) == (".")) or (deAspis($list[0][$k[0]][0]["name"]) == (".."))))
 unset($list[0][$k[0]]);
}}$ret = array(true,false);
foreach ( $list[0] as $el  )
{if ( (deAspis($el[0]["type"]) == ("d")))
 {if ( (denot_boolean($this->mget(concat(concat2($remote,"/"),$el[0]["name"]),concat(concat2($local,"/"),$el[0]["name"]),$continious))))
 {$this->PushError(array("mget",false),array("can't copy folder",false),concat2(concat(concat2(concat(concat2(concat(concat2(concat1("Can't copy remote folder \"",$remote),"/"),$el[0]["name"]),"\" to local \""),$local),"/"),$el[0]["name"]),"\""));
$ret = array(false,false);
if ( (denot_boolean($continious)))
 break ;
}}else 
{{if ( (denot_boolean($this->get(concat(concat2($remote,"/"),$el[0]["name"]),concat(concat2($local,"/"),$el[0]["name"])))))
 {$this->PushError(array("mget",false),array("can't copy file",false),concat2(concat(concat2(concat(concat2(concat(concat2(concat1("Can't copy remote file \"",$remote),"/"),$el[0]["name"]),"\" to local \""),$local),"/"),$el[0]["name"]),"\""));
$ret = array(false,false);
if ( (denot_boolean($continious)))
 break ;
}}}@attAspis(chmod((deconcat(concat2($local,"/"),$el[0]["name"])),deAspis($el[0]["perms"])));
$t = attAspis(strtotime(deAspis($el[0]["date"])));
if ( (($t[0] !== deAspis(negate(array(1,false)))) and ($t[0] !== false)))
 @attAspis(touch((deconcat(concat2($local,"/"),$el[0]["name"])),$t[0]));
}return $ret;
} }
function mdel ( $remote,$continious = array(false,false) ) {
{$list = $this->rawlist($remote,array("-la",false));
if ( ($list[0] === false))
 {$this->PushError(array("mdel",false),array("can't read remote folder list",false),concat2(concat1("Can't read remote folder \"",$remote),"\" contents"));
return array(false,false);
}foreach ( $list[0] as $k =>$v )
{restoreTaint($k,$v);
{arrayAssign($list[0],deAspis(registerTaint($k)),addTaint($this->parselisting($v)));
if ( ((deAspis($list[0][$k[0]][0]["name"]) == (".")) or (deAspis($list[0][$k[0]][0]["name"]) == (".."))))
 unset($list[0][$k[0]]);
}}$ret = array(true,false);
foreach ( $list[0] as $el  )
{if ( ((empty($el) || Aspis_empty( $el))))
 continue ;
if ( (deAspis($el[0]["type"]) == ("d")))
 {if ( (denot_boolean($this->mdel(concat(concat2($remote,"/"),$el[0]["name"]),$continious))))
 {$ret = array(false,false);
if ( (denot_boolean($continious)))
 break ;
}}else 
{{if ( (denot_boolean($this->delete(concat(concat2($remote,"/"),$el[0]["name"])))))
 {$this->PushError(array("mdel",false),array("can't delete file",false),concat2(concat(concat2(concat1("Can't delete remote file \"",$remote),"/"),$el[0]["name"]),"\""));
$ret = array(false,false);
if ( (denot_boolean($continious)))
 break ;
}}}}if ( (denot_boolean($this->rmdir($remote))))
 {$this->PushError(array("mdel",false),array("can't delete folder",false),concat2(concat(concat2(concat1("Can't delete remote folder \"",$remote),"/"),$el[0]["name"]),"\""));
$ret = array(false,false);
}return $ret;
} }
function mmkdir ( $dir,$mode = array(0777,false) ) {
{if ( ((empty($dir) || Aspis_empty( $dir))))
 return array(FALSE,false);
if ( (deAspis($this->is_exists($dir)) or ($dir[0] == ("/"))))
 return array(TRUE,false);
if ( (denot_boolean($this->mmkdir(Aspis_dirname($dir),$mode))))
 return array(false,false);
$r = $this->mkdir($dir,$mode);
$this->chmod($dir,$mode);
return $r;
} }
function glob ( $pattern,$handle = array(NULL,false) ) {
{$path = $output = array(null,false);
if ( (PHP_OS == ('WIN32')))
 $slash = array('\\',false);
else 
{$slash = array('/',false);
}$lastpos = attAspis(strrpos($pattern[0],$slash[0]));
if ( (!($lastpos[0] === false)))
 {$path = Aspis_substr($pattern,array(0,false),array(deAspis(negate($lastpos)) - (1),false));
$pattern = Aspis_substr($pattern,$lastpos);
}else 
{$path = attAspis(getcwd());
}if ( (is_array($handle[0]) and (!((empty($handle) || Aspis_empty( $handle))))))
 {while ( deAspis($dir = Aspis_each($handle)) )
{if ( deAspis($this->glob_pattern_match($pattern,$dir)))
 arrayAssignAdd($output[0][],addTaint($dir));
}}else 
{{$handle = @attAspis(opendir($path[0]));
if ( ($handle[0] === false))
 return array(false,false);
while ( deAspis($dir = attAspis(readdir($handle[0]))) )
{if ( deAspis($this->glob_pattern_match($pattern,$dir)))
 arrayAssignAdd($output[0][],addTaint($dir));
}closedir($handle[0]);
}}if ( is_array($output[0]))
 return $output;
return array(false,false);
} }
function glob_pattern_match ( $pattern,$string ) {
{$out = array(null,false);
$chunks = Aspis_explode(array(';',false),$pattern);
foreach ( $chunks[0] as $pattern  )
{$escape = array(array(array('$',false),array('^',false),array('.',false),array('{',false),array('}',false),array('(',false),array(')',false),array('[',false),array(']',false),array('|',false)),false);
while ( (strpos($pattern[0],'**') !== false) )
$pattern = Aspis_str_replace(array('**',false),array('*',false),$pattern);
foreach ( $escape[0] as $probe  )
$pattern = Aspis_str_replace($probe,concat1("\\",$probe),$pattern);
$pattern = Aspis_str_replace(array('?*',false),array('*',false),Aspis_str_replace(array('*?',false),array('*',false),Aspis_str_replace(array('*',false),array(".*",false),Aspis_str_replace(array('?',false),array('.{1,1}',false),$pattern))));
arrayAssignAdd($out[0][],addTaint($pattern));
}if ( (count($out[0]) == (1)))
 return ($this->glob_regexp(concat2(concat1("^",attachAspis($out,(0))),"$"),$string));
else 
{{foreach ( $out[0] as $tester  )
if ( deAspis($this->my_regexp(concat2(concat1("^",$tester),"$"),$string)))
 return array(true,false);
}}return array(false,false);
} }
function glob_regexp ( $pattern,$probe ) {
{$sensitive = (array(PHP_OS != ('WIN32'),false));
return ($sensitive[0] ? attAspis(ereg($pattern[0],$probe[0])) : attAspis(eregi($pattern[0],$probe[0])));
} }
function dirlist ( $remote ) {
{$list = $this->rawlist($remote,array("-la",false));
if ( ($list[0] === false))
 {$this->PushError(array("dirlist",false),array("can't read remote folder list",false),concat2(concat1("Can't read remote folder \"",$remote),"\" contents"));
return array(false,false);
}$dirlist = array(array(),false);
foreach ( $list[0] as $k =>$v )
{restoreTaint($k,$v);
{$entry = $this->parselisting($v);
if ( ((empty($entry) || Aspis_empty( $entry))))
 continue ;
if ( ((deAspis($entry[0]["name"]) == (".")) or (deAspis($entry[0]["name"]) == (".."))))
 continue ;
arrayAssign($dirlist[0],deAspis(registerTaint($entry[0]['name'])),addTaint($entry));
}}return $dirlist;
} }
function _checkCode (  ) {
{return (array(($this->_code[0] < (400)) and ($this->_code[0] > (0)),false));
} }
function _list ( $arg = array("",false),$cmd = array("LIST",false),$fnction = array("_list",false) ) {
{if ( (denot_boolean($this->_data_prepare())))
 return array(false,false);
if ( (denot_boolean($this->_exec(concat($cmd,$arg),$fnction))))
 {$this->_data_close();
return array(FALSE,false);
}if ( (denot_boolean($this->_checkCode())))
 {$this->_data_close();
return array(FALSE,false);
}$out = array("",false);
if ( ($this->_code[0] < (200)))
 {$out = $this->_data_read();
$this->_data_close();
if ( (denot_boolean($this->_readmsg())))
 return array(FALSE,false);
if ( (denot_boolean($this->_checkCode())))
 return array(FALSE,false);
if ( ($out[0] === FALSE))
 return array(FALSE,false);
$out = Aspis_preg_split(concat2(concat12("/[",CRLF),"]+/"),$out,negate(array(1,false)),array(PREG_SPLIT_NO_EMPTY,false));
}return $out;
} }
function PushError ( $fctname,$msg,$desc = array(false,false) ) {
{$error = array(array(),false);
arrayAssign($error[0],deAspis(registerTaint(array('time',false))),addTaint(attAspis(time())));
arrayAssign($error[0],deAspis(registerTaint(array('fctname',false))),addTaint($fctname));
arrayAssign($error[0],deAspis(registerTaint(array('msg',false))),addTaint($msg));
arrayAssign($error[0],deAspis(registerTaint(array('desc',false))),addTaint($desc));
if ( $desc[0])
 $tmp = concat2(concat1(' (',$desc),')');
else 
{$tmp = array('',false);
}$this->SendMSG(concat(concat(concat2($fctname,': '),$msg),$tmp));
return (Aspis_array_push($this->_error_array,$error));
} }
function PopError (  ) {
{if ( count($this->_error_array[0]))
 return (Aspis_array_pop($this->_error_array));
else 
{return (array(false,false));
}} }
}$mod_sockets = array(TRUE,false);
if ( (!(extension_loaded('sockets'))))
 {$prefix = (PHP_SHLIB_SUFFIX == ('dll')) ? array('php_',false) : array('',false);
if ( (denot_boolean(@array(dl((deconcat2(concat2($prefix,'sockets.'),PHP_SHLIB_SUFFIX))),false))))
 $mod_sockets = array(FALSE,false);
}require_once (deconcat2(concat1("class-ftp-",($mod_sockets[0] ? array("sockets",false) : array("pure",false))),".php"));
;
?>
<?php 