<?php require_once('AspisMain.php'); ?><?php
class ftp extends ftp_base{function ftp ( $verb = FALSE,$le = FALSE ) {
{$this->__construct($verb,$le);
} }
function __construct ( $verb = FALSE,$le = FALSE ) {
{parent::__construct(false,$verb,$le);
} }
function _settimeout ( $sock ) {
{if ( !@stream_set_timeout($sock,$this->_timeout))
 {$this->PushError('_settimeout','socket set send timeout');
$this->_quit();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}{$AspisRetTemp = TRUE;
return $AspisRetTemp;
}} }
function _connect ( $host,$port ) {
{$this->SendMSG("Creating socket");
$sock = @fsockopen($host,$port,$errno,$errstr,$this->_timeout);
if ( !$sock)
 {$this->PushError('_connect','socket connect failed',$errstr . " (" . $errno . ")");
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}$this->_connected = true;
{$AspisRetTemp = $sock;
return $AspisRetTemp;
}} }
function _readmsg ( $fnction = "_readmsg" ) {
{if ( !$this->_connected)
 {$this->PushError($fnction,'Connect first');
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}$result = true;
$this->_message = "";
$this->_code = 0;
$go = true;
do {$tmp = @fgets($this->_ftp_control_sock,512);
if ( $tmp === false)
 {$go = $result = false;
$this->PushError($fnction,'Read failed');
}else 
{{$this->_message .= $tmp;
if ( preg_match("/^([0-9]{3})(-(.*[" . CRLF . "]{1,2})+\\1)? [^" . CRLF . "]+[" . CRLF . "]{1,2}$/",$this->_message,$regs))
 $go = false;
}}}while ($go )
;
if ( $this->LocalEcho)
 echo "GET < " . rtrim($this->_message,CRLF) . CRLF;
$this->_code = (int)$regs[1];
{$AspisRetTemp = $result;
return $AspisRetTemp;
}} }
function _exec ( $cmd,$fnction = "_exec" ) {
{if ( !$this->_ready)
 {$this->PushError($fnction,'Connect first');
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( $this->LocalEcho)
 echo "PUT > ",$cmd,CRLF;
$status = @fputs($this->_ftp_control_sock,$cmd . CRLF);
if ( $status === false)
 {$this->PushError($fnction,'socket write failed');
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}$this->_lastaction = time();
if ( !$this->_readmsg($fnction))
 {$AspisRetTemp = FALSE;
return $AspisRetTemp;
}{$AspisRetTemp = TRUE;
return $AspisRetTemp;
}} }
function _data_prepare ( $mode = FTP_ASCII ) {
{if ( !$this->_settype($mode))
 {$AspisRetTemp = FALSE;
return $AspisRetTemp;
}if ( $this->_passive)
 {if ( !$this->_exec("PASV","pasv"))
 {$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( !$this->_checkCode())
 {$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}$ip_port = explode(",",ereg_replace("^.+ \\(?([0-9]{1,3},[0-9]{1,3},[0-9]{1,3},[0-9]{1,3},[0-9]+,[0-9]+)\\)?.*" . CRLF . "$","\\1",$this->_message));
$this->_datahost = $ip_port[0] . "." . $ip_port[1] . "." . $ip_port[2] . "." . $ip_port[3];
$this->_dataport = (((int)$ip_port[4]) << 8) + ((int)$ip_port[5]);
$this->SendMSG("Connecting to " . $this->_datahost . ":" . $this->_dataport);
$this->_ftp_data_sock = @fsockopen($this->_datahost,$this->_dataport,$errno,$errstr,$this->_timeout);
if ( !$this->_ftp_data_sock)
 {$this->PushError("_data_prepare","fsockopen fails",$errstr . " (" . $errno . ")");
$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}else 
{$this->_ftp_data_sock;
}}else 
{{$this->SendMSG("Only passive connections available!");
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}}{$AspisRetTemp = TRUE;
return $AspisRetTemp;
}} }
function _data_read ( $mode = FTP_ASCII,$fp = NULL ) {
{if ( is_resource($fp))
 $out = 0;
else 
{$out = "";
}if ( !$this->_passive)
 {$this->SendMSG("Only passive connections available!");
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}while ( !feof($this->_ftp_data_sock) )
{$block = fread($this->_ftp_data_sock,$this->_ftp_buff_size);
if ( $mode != FTP_BINARY)
 $block = preg_replace("/\r\n|\r|\n/",$this->_eol_code[$this->OS_local],$block);
if ( is_resource($fp))
 $out += fwrite($fp,$block,strlen($block));
else 
{$out .= $block;
}}{$AspisRetTemp = $out;
return $AspisRetTemp;
}} }
function _data_write ( $mode = FTP_ASCII,$fp = NULL ) {
{if ( is_resource($fp))
 $out = 0;
else 
{$out = "";
}if ( !$this->_passive)
 {$this->SendMSG("Only passive connections available!");
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( is_resource($fp))
 {while ( !feof($fp) )
{$block = fread($fp,$this->_ftp_buff_size);
if ( !$this->_data_write_block($mode,$block))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}}}elseif ( !$this->_data_write_block($mode,$fp))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = TRUE;
return $AspisRetTemp;
}} }
function _data_write_block ( $mode,$block ) {
{if ( $mode != FTP_BINARY)
 $block = preg_replace("/\r\n|\r|\n/",$this->_eol_code[$this->OS_remote],$block);
do {if ( ($t = @fwrite($this->_ftp_data_sock,$block)) === FALSE)
 {$this->PushError("_data_write","Can't write to socket");
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}$block = substr($block,$t);
}while (!empty($block) )
;
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function _data_close (  ) {
{@fclose($this->_ftp_data_sock);
$this->SendMSG("Disconnected data from remote host");
{$AspisRetTemp = TRUE;
return $AspisRetTemp;
}} }
function _quit ( $force = FALSE ) {
{if ( $this->_connected or $force)
 {@fclose($this->_ftp_control_sock);
$this->_connected = false;
$this->SendMSG("Socket closed");
}} }
};
?>
<?php 