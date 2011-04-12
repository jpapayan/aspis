<?php require_once('AspisMain.php'); ?><?php
class ftp extends ftp_base{function ftp ( $verb = array(FALSE,false),$le = array(FALSE,false) ) {
{$this->__construct($verb,$le);
} }
function __construct ( $verb = array(FALSE,false),$le = array(FALSE,false) ) {
{parent::__construct(array(false,false),$verb,$le);
} }
function _settimeout ( $sock ) {
{if ( (denot_boolean(@array(stream_set_timeout(deAspisRC($sock),deAspisRC($this->_timeout)),false))))
 {$this->PushError(array('_settimeout',false),array('socket set send timeout',false));
$this->_quit();
return array(FALSE,false);
}return array(TRUE,false);
} }
function _connect ( $host,$port ) {
{$this->SendMSG(array("Creating socket",false));
$sock = @AspisInternalFunctionCall("fsockopen",$host[0],$port[0],AspisPushRefParam($errno),AspisPushRefParam($errstr),$this->_timeout[0],array(2,3));
if ( (denot_boolean($sock)))
 {$this->PushError(array('_connect',false),array('socket connect failed',false),concat2(concat(concat2($errstr," ("),$errno),")"));
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
do {$tmp = @attAspis(fgets($this->_ftp_control_sock[0],(512)));
if ( ($tmp[0] === false))
 {$go = $result = array(false,false);
$this->PushError($fnction,array('Read failed',false));
}else 
{{$this->_message = concat($this->_message ,$tmp);
if ( deAspis(Aspis_preg_match(concat2(concat2(concat2(concat2(concat2(concat12("/^([0-9]{3})(-(.*[",CRLF),"]{1,2})+\\1)? [^"),CRLF),"]+["),CRLF),"]{1,2}$/"),$this->_message,$regs)))
 $go = array(false,false);
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
$status = @attAspis(fputs($this->_ftp_control_sock[0],(deconcat2($cmd,CRLF))));
if ( ($status[0] === false))
 {$this->PushError($fnction,array('socket write failed',false));
return array(FALSE,false);
}$this->_lastaction = attAspis(time());
if ( (denot_boolean($this->_readmsg($fnction))))
 return array(FALSE,false);
return array(TRUE,false);
} }
function _data_prepare ( $mode = array(FTP_ASCII,false) ) {
{if ( (denot_boolean($this->_settype($mode))))
 return array(FALSE,false);
if ( $this->_passive[0])
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
$this->_ftp_data_sock = @AspisInternalFunctionCall("fsockopen",$this->_datahost[0],$this->_dataport[0],AspisPushRefParam($errno),AspisPushRefParam($errstr),$this->_timeout[0],array(2,3));
if ( (denot_boolean($this->_ftp_data_sock)))
 {$this->PushError(array("_data_prepare",false),array("fsockopen fails",false),concat2(concat(concat2($errstr," ("),$errno),")"));
$this->_data_close();
return array(FALSE,false);
}else 
{$this->_ftp_data_sock;
}}else 
{{$this->SendMSG(array("Only passive connections available!",false));
return array(FALSE,false);
}}return array(TRUE,false);
} }
function _data_read ( $mode = array(FTP_ASCII,false),$fp = array(NULL,false) ) {
{if ( is_resource(deAspisRC($fp)))
 $out = array(0,false);
else 
{$out = array("",false);
}if ( (denot_boolean($this->_passive)))
 {$this->SendMSG(array("Only passive connections available!",false));
return array(FALSE,false);
}while ( (!(feof($this->_ftp_data_sock[0]))) )
{$block = attAspis(fread($this->_ftp_data_sock[0],$this->_ftp_buff_size[0]));
if ( ($mode[0] != FTP_BINARY))
 $block = Aspis_preg_replace(array("/\r\n|\r|\n/",false),$this->_eol_code[0][$this->OS_local[0]],$block);
if ( is_resource(deAspisRC($fp)))
 $out = array(fwrite($fp[0],$block[0],strlen($block[0])) + $out[0],false);
else 
{$out = concat($out,$block);
}}return $out;
} }
function _data_write ( $mode = array(FTP_ASCII,false),$fp = array(NULL,false) ) {
{if ( is_resource(deAspisRC($fp)))
 $out = array(0,false);
else 
{$out = array("",false);
}if ( (denot_boolean($this->_passive)))
 {$this->SendMSG(array("Only passive connections available!",false));
return array(FALSE,false);
}if ( is_resource(deAspisRC($fp)))
 {while ( (!(feof($fp[0]))) )
{$block = attAspis(fread($fp[0],$this->_ftp_buff_size[0]));
if ( (denot_boolean($this->_data_write_block($mode,$block))))
 return array(false,false);
}}elseif ( (denot_boolean($this->_data_write_block($mode,$fp))))
 return array(false,false);
return array(TRUE,false);
} }
function _data_write_block ( $mode,$block ) {
{if ( ($mode[0] != FTP_BINARY))
 $block = Aspis_preg_replace(array("/\r\n|\r|\n/",false),$this->_eol_code[0][$this->OS_remote[0]],$block);
do {if ( (deAspis(($t = @attAspis(fwrite($this->_ftp_data_sock[0],$block[0])))) === FALSE))
 {$this->PushError(array("_data_write",false),array("Can't write to socket",false));
return array(FALSE,false);
}$block = Aspis_substr($block,$t);
}while ((!((empty($block) || Aspis_empty( $block)))) )
;
return array(true,false);
} }
function _data_close (  ) {
{@attAspis(fclose($this->_ftp_data_sock[0]));
$this->SendMSG(array("Disconnected data from remote host",false));
return array(TRUE,false);
} }
function _quit ( $force = array(FALSE,false) ) {
{if ( ($this->_connected[0] or $force[0]))
 {@attAspis(fclose($this->_ftp_control_sock[0]));
$this->_connected = array(false,false);
$this->SendMSG(array("Socket closed",false));
}} }
};
?>
<?php 