<?php require_once('AspisMain.php'); ?><?php
class ftp extends ftp_base{function ftp ( $verb = array(FALSE,false),$le = array(FALSE,false) ) {
{$this->__construct($verb,$le);
} }
function __construct ( $verb = array(FALSE,false),$le = array(FALSE,false) ) {
{parent::__construct(array(true,false),$verb,$le);
} }
function _settimeout ( $sock ) {
{if ( (denot_boolean(@array(socket_set_option(deAspisRC($sock),SOL_SOCKET,SO_RCVTIMEO,deAspisRC(array(array(deregisterTaint(array("sec",false)) => addTaint($this->_timeout),"usec" => array(0,false,false)),false))),false))))
 {$this->PushError(array('_connect',false),array('socket set receive timeout',false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($sock)),false))),false));
@array(socket_close(deAspisRC($sock)),false);
return array(FALSE,false);
}if ( (denot_boolean(@array(socket_set_option(deAspisRC($sock),SOL_SOCKET,SO_SNDTIMEO,deAspisRC(array(array(deregisterTaint(array("sec",false)) => addTaint($this->_timeout),"usec" => array(0,false,false)),false))),false))))
 {$this->PushError(array('_connect',false),array('socket set send timeout',false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($sock)),false))),false));
@array(socket_close(deAspisRC($sock)),false);
return array(FALSE,false);
}return array(true,false);
} }
function _connect ( $host,$port ) {
{$this->SendMSG(array("Creating socket",false));
if ( (denot_boolean(($sock = @array(socket_create(AF_INET,SOCK_STREAM,SOL_TCP),false)))))
 {$this->PushError(array('_connect',false),array('socket create failed',false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($sock)),false))),false));
return array(FALSE,false);
}if ( (denot_boolean($this->_settimeout($sock))))
 return array(FALSE,false);
$this->SendMSG(concat2(concat(concat2(concat1("Connecting to \"",$host),":"),$port),"\""));
if ( (denot_boolean(($res = @array(socket_connect(deAspisRC($sock),deAspisRC($host),deAspisRC($port)),false)))))
 {$this->PushError(array('_connect',false),array('socket connect failed',false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($sock)),false))),false));
@array(socket_close(deAspisRC($sock)),false);
return array(FALSE,false);
}$this->_connected = array(true,false);
return $sock;
} }
function _readmsg ( $fnction = array("_readmsg",false) ) {
{if ( (denot_boolean($this->_connected)))
 {$this->PushError($fnction,array('Connect first',false));
return array(FALSE,false);
}$result = array(true,false);
$this->_message = array("",false);
$this->_code = array(0,false);
$go = array(true,false);
do {$tmp = @array(socket_read(deAspisRC($this->_ftp_control_sock),4096,PHP_BINARY_READ),false);
if ( ($tmp[0] === false))
 {$go = $result = array(false,false);
$this->PushError($fnction,array('Read failed',false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->_ftp_control_sock)),false))),false));
}else 
{{$this->_message = concat($this->_message ,$tmp);
$go = not_boolean(Aspis_preg_match(concat2(concat2(concat2(concat12("/^([0-9]{3})(-.+\\1)? [^",CRLF),"]+"),CRLF),"$/Us"),$this->_message,$regs));
}}}while ($go[0] )
;
if ( $this->LocalEcho[0])
 echo AspisCheckPrint(concat2(concat1("GET < ",Aspis_rtrim($this->_message,array(CRLF,false))),CRLF));
$this->_code = int_cast(attachAspis($regs,(1)));
return $result;
} }
function _exec ( $cmd,$fnction = array("_exec",false) ) {
{if ( (denot_boolean($this->_ready)))
 {$this->PushError($fnction,array('Connect first',false));
return array(FALSE,false);
}if ( $this->LocalEcho[0])
 echo AspisCheckPrint(array("PUT > ",false)),AspisCheckPrint($cmd),AspisCheckPrint(array(CRLF,false));
$status = @array(socket_write(deAspisRC($this->_ftp_control_sock),(deconcat2($cmd,CRLF))),false);
if ( ($status[0] === false))
 {$this->PushError($fnction,array('socket write failed',false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->stream)),false))),false));
return array(FALSE,false);
}$this->_lastaction = attAspis(time());
if ( (denot_boolean($this->_readmsg($fnction))))
 return array(FALSE,false);
return array(TRUE,false);
} }
function _data_prepare ( $mode = array(FTP_ASCII,false) ) {
{if ( (denot_boolean($this->_settype($mode))))
 return array(FALSE,false);
$this->SendMSG(array("Creating data socket",false));
$this->_ftp_data_sock = @array(socket_create(AF_INET,SOCK_STREAM,SOL_TCP),false);
if ( ($this->_ftp_data_sock[0] < (0)))
 {$this->PushError(array('_data_prepare',false),array('socket create failed',false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->_ftp_data_sock)),false))),false));
return array(FALSE,false);
}if ( (denot_boolean($this->_settimeout($this->_ftp_data_sock))))
 {$this->_data_close();
return array(FALSE,false);
}if ( $this->_passive[0])
 {if ( (denot_boolean($this->_exec(array("PASV",false),array("pasv",false)))))
 {$this->_data_close();
return array(FALSE,false);
}if ( (denot_boolean($this->_checkCode())))
 {$this->_data_close();
return array(FALSE,false);
}$ip_port = Aspis_explode(array(",",false),Aspis_ereg_replace(concat2(concat12("^.+ \\(?([0-9]{1,3},[0-9]{1,3},[0-9]{1,3},[0-9]{1,3},[0-9]+,[0-9]+)\\)?.*",CRLF),"$"),array("\\1",false),$this->_message));
$this->_datahost = concat(concat2(concat(concat2(concat(concat2(attachAspis($ip_port,(0)),"."),attachAspis($ip_port,(1))),"."),attachAspis($ip_port,(2))),"."),attachAspis($ip_port,(3)));
$this->_dataport = array((deAspis((int_cast(attachAspis($ip_port,(4))))) << (8)) + deAspis((int_cast(attachAspis($ip_port,(5))))),false);
$this->SendMSG(concat(concat2(concat1("Connecting to ",$this->_datahost),":"),$this->_dataport));
if ( (denot_boolean(@array(socket_connect(deAspisRC($this->_ftp_data_sock),deAspisRC($this->_datahost),deAspisRC($this->_dataport)),false))))
 {$this->PushError(array("_data_prepare",false),array("socket_connect",false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->_ftp_data_sock)),false))),false));
$this->_data_close();
return array(FALSE,false);
}else 
{$this->_ftp_temp_sock = $this->_ftp_data_sock;
}}else 
{{if ( (denot_boolean(@array(socket_getsockname(deAspisRC($this->_ftp_control_sock),deAspisRC($addr),deAspisRC($port)),false))))
 {$this->PushError(array("_data_prepare",false),array("can't get control socket information",false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->_ftp_control_sock)),false))),false));
$this->_data_close();
return array(FALSE,false);
}if ( (denot_boolean(@array(socket_bind(deAspisRC($this->_ftp_data_sock),deAspisRC($addr)),false))))
 {$this->PushError(array("_data_prepare",false),array("can't bind data socket",false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->_ftp_data_sock)),false))),false));
$this->_data_close();
return array(FALSE,false);
}if ( (denot_boolean(@array(socket_listen(deAspisRC($this->_ftp_data_sock)),false))))
 {$this->PushError(array("_data_prepare",false),array("can't listen data socket",false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->_ftp_data_sock)),false))),false));
$this->_data_close();
return array(FALSE,false);
}if ( (denot_boolean(@array(socket_getsockname(deAspisRC($this->_ftp_data_sock),deAspisRC($this->_datahost),deAspisRC($this->_dataport)),false))))
 {$this->PushError(array("_data_prepare",false),array("can't get data socket information",false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->_ftp_data_sock)),false))),false));
$this->_data_close();
return array(FALSE,false);
}if ( (denot_boolean($this->_exec(concat1('PORT ',Aspis_str_replace(array('.',false),array(',',false),concat(concat2(concat(concat2($this->_datahost,'.'),(array($this->_dataport[0] >> (8),false))),'.'),(array($this->_dataport[0] & (0x00FF),false))))),array("_port",false)))))
 {$this->_data_close();
return array(FALSE,false);
}if ( (denot_boolean($this->_checkCode())))
 {$this->_data_close();
return array(FALSE,false);
}}}return array(TRUE,false);
} }
function _data_read ( $mode = array(FTP_ASCII,false),$fp = array(NULL,false) ) {
{$NewLine = $this->_eol_code[0][$this->OS_local[0]];
if ( is_resource(deAspisRC($fp)))
 $out = array(0,false);
else 
{$out = array("",false);
}if ( (denot_boolean($this->_passive)))
 {$this->SendMSG(concat(concat2(concat1("Connecting to ",$this->_datahost),":"),$this->_dataport));
$this->_ftp_temp_sock = array(socket_accept(deAspisRC($this->_ftp_data_sock)),false);
if ( ($this->_ftp_temp_sock[0] === FALSE))
 {$this->PushError(array("_data_read",false),array("socket_accept",false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->_ftp_temp_sock)),false))),false));
$this->_data_close();
return array(FALSE,false);
}}while ( (deAspis(($block = @array(socket_read(deAspisRC($this->_ftp_temp_sock),deAspisRC($this->_ftp_buff_size),PHP_BINARY_READ),false))) !== false) )
{if ( ($block[0] === ("")))
 break ;
if ( ($mode[0] != FTP_BINARY))
 $block = Aspis_preg_replace(array("/\r\n|\r|\n/",false),$this->_eol_code[0][$this->OS_local[0]],$block);
if ( is_resource(deAspisRC($fp)))
 $out = array(fwrite($fp[0],$block[0],strlen($block[0])) + $out[0],false);
else 
{$out = concat($out,$block);
}}return $out;
} }
function _data_write ( $mode = array(FTP_ASCII,false),$fp = array(NULL,false) ) {
{$NewLine = $this->_eol_code[0][$this->OS_local[0]];
if ( is_resource(deAspisRC($fp)))
 $out = array(0,false);
else 
{$out = array("",false);
}if ( (denot_boolean($this->_passive)))
 {$this->SendMSG(concat(concat2(concat1("Connecting to ",$this->_datahost),":"),$this->_dataport));
$this->_ftp_temp_sock = array(socket_accept(deAspisRC($this->_ftp_data_sock)),false);
if ( ($this->_ftp_temp_sock[0] === FALSE))
 {$this->PushError(array("_data_write",false),array("socket_accept",false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->_ftp_temp_sock)),false))),false));
$this->_data_close();
return array(false,false);
}}if ( is_resource(deAspisRC($fp)))
 {while ( (!(feof($fp[0]))) )
{$block = attAspis(fread($fp[0],$this->_ftp_buff_size[0]));
if ( (denot_boolean($this->_data_write_block($mode,$block))))
 return array(false,false);
}}elseif ( (denot_boolean($this->_data_write_block($mode,$fp))))
 return array(false,false);
return array(true,false);
} }
function _data_write_block ( $mode,$block ) {
{if ( ($mode[0] != FTP_BINARY))
 $block = Aspis_preg_replace(array("/\r\n|\r|\n/",false),$this->_eol_code[0][$this->OS_remote[0]],$block);
do {if ( (deAspis(($t = @array(socket_write(deAspisRC($this->_ftp_temp_sock),deAspisRC($block)),false))) === FALSE))
 {$this->PushError(array("_data_write",false),array("socket_write",false),array(socket_strerror(deAspisRC(array(socket_last_error(deAspisRC($this->_ftp_temp_sock)),false))),false));
$this->_data_close();
return array(FALSE,false);
}$block = Aspis_substr($block,$t);
}while ((!((empty($block) || Aspis_empty( $block)))) )
;
return array(true,false);
} }
function _data_close (  ) {
{@array(socket_close(deAspisRC($this->_ftp_temp_sock)),false);
@array(socket_close(deAspisRC($this->_ftp_data_sock)),false);
$this->SendMSG(array("Disconnected data from remote host",false));
return array(TRUE,false);
} }
function _quit (  ) {
{if ( $this->_connected[0])
 {@array(socket_close(deAspisRC($this->_ftp_control_sock)),false);
$this->_connected = array(false,false);
$this->SendMSG(array("Socket closed",false));
}} }
};
?>
<?php 