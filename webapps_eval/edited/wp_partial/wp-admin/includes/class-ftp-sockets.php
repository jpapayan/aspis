<?php require_once('AspisMain.php'); ?><?php
class ftp extends ftp_base{function ftp ( $verb = FALSE,$le = FALSE ) {
{$this->__construct($verb,$le);
} }
function __construct ( $verb = FALSE,$le = FALSE ) {
{parent::__construct(true,$verb,$le);
} }
function _settimeout ( $sock ) {
{if ( !@socket_set_option($sock,SOL_SOCKET,SO_RCVTIMEO,array("sec" => $this->_timeout,"usec" => 0)))
 {$this->PushError('_connect','socket set receive timeout',socket_strerror(socket_last_error($sock)));
@socket_close($sock);
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( !@socket_set_option($sock,SOL_SOCKET,SO_SNDTIMEO,array("sec" => $this->_timeout,"usec" => 0)))
 {$this->PushError('_connect','socket set send timeout',socket_strerror(socket_last_error($sock)));
@socket_close($sock);
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function _connect ( $host,$port ) {
{$this->SendMSG("Creating socket");
if ( !($sock = @socket_create(AF_INET,SOCK_STREAM,SOL_TCP)))
 {$this->PushError('_connect','socket create failed',socket_strerror(socket_last_error($sock)));
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( !$this->_settimeout($sock))
 {$AspisRetTemp = FALSE;
return $AspisRetTemp;
}$this->SendMSG("Connecting to \"" . $host . ":" . $port . "\"");
if ( !($res = @socket_connect($sock,$host,$port)))
 {$this->PushError('_connect','socket connect failed',socket_strerror(socket_last_error($sock)));
@socket_close($sock);
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
do {$tmp = @socket_read($this->_ftp_control_sock,4096,PHP_BINARY_READ);
if ( $tmp === false)
 {$go = $result = false;
$this->PushError($fnction,'Read failed',socket_strerror(socket_last_error($this->_ftp_control_sock)));
}else 
{{$this->_message .= $tmp;
$go = !preg_match("/^([0-9]{3})(-.+\\1)? [^" . CRLF . "]+" . CRLF . "$/Us",$this->_message,$regs);
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
$status = @socket_write($this->_ftp_control_sock,$cmd . CRLF);
if ( $status === false)
 {$this->PushError($fnction,'socket write failed',socket_strerror(socket_last_error($this->stream)));
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
}$this->SendMSG("Creating data socket");
$this->_ftp_data_sock = @socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
if ( $this->_ftp_data_sock < 0)
 {$this->PushError('_data_prepare','socket create failed',socket_strerror(socket_last_error($this->_ftp_data_sock)));
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( !$this->_settimeout($this->_ftp_data_sock))
 {$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( $this->_passive)
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
if ( !@socket_connect($this->_ftp_data_sock,$this->_datahost,$this->_dataport))
 {$this->PushError("_data_prepare","socket_connect",socket_strerror(socket_last_error($this->_ftp_data_sock)));
$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}else 
{$this->_ftp_temp_sock = $this->_ftp_data_sock;
}}else 
{{if ( !@socket_getsockname($this->_ftp_control_sock,$addr,$port))
 {$this->PushError("_data_prepare","can't get control socket information",socket_strerror(socket_last_error($this->_ftp_control_sock)));
$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( !@socket_bind($this->_ftp_data_sock,$addr))
 {$this->PushError("_data_prepare","can't bind data socket",socket_strerror(socket_last_error($this->_ftp_data_sock)));
$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( !@socket_listen($this->_ftp_data_sock))
 {$this->PushError("_data_prepare","can't listen data socket",socket_strerror(socket_last_error($this->_ftp_data_sock)));
$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( !@socket_getsockname($this->_ftp_data_sock,$this->_datahost,$this->_dataport))
 {$this->PushError("_data_prepare","can't get data socket information",socket_strerror(socket_last_error($this->_ftp_data_sock)));
$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( !$this->_exec('PORT ' . str_replace('.',',',$this->_datahost . '.' . ($this->_dataport >> 8) . '.' . ($this->_dataport & 0x00FF)),"_port"))
 {$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}if ( !$this->_checkCode())
 {$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}}}{$AspisRetTemp = TRUE;
return $AspisRetTemp;
}} }
function _data_read ( $mode = FTP_ASCII,$fp = NULL ) {
{$NewLine = $this->_eol_code[$this->OS_local];
if ( is_resource($fp))
 $out = 0;
else 
{$out = "";
}if ( !$this->_passive)
 {$this->SendMSG("Connecting to " . $this->_datahost . ":" . $this->_dataport);
$this->_ftp_temp_sock = socket_accept($this->_ftp_data_sock);
if ( $this->_ftp_temp_sock === FALSE)
 {$this->PushError("_data_read","socket_accept",socket_strerror(socket_last_error($this->_ftp_temp_sock)));
$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}}while ( ($block = @socket_read($this->_ftp_temp_sock,$this->_ftp_buff_size,PHP_BINARY_READ)) !== false )
{if ( $block === "")
 break ;
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
{$NewLine = $this->_eol_code[$this->OS_local];
if ( is_resource($fp))
 $out = 0;
else 
{$out = "";
}if ( !$this->_passive)
 {$this->SendMSG("Connecting to " . $this->_datahost . ":" . $this->_dataport);
$this->_ftp_temp_sock = socket_accept($this->_ftp_data_sock);
if ( $this->_ftp_temp_sock === FALSE)
 {$this->PushError("_data_write","socket_accept",socket_strerror(socket_last_error($this->_ftp_temp_sock)));
$this->_data_close();
{$AspisRetTemp = false;
return $AspisRetTemp;
}}}if ( is_resource($fp))
 {while ( !feof($fp) )
{$block = fread($fp,$this->_ftp_buff_size);
if ( !$this->_data_write_block($mode,$block))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}}}elseif ( !$this->_data_write_block($mode,$fp))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function _data_write_block ( $mode,$block ) {
{if ( $mode != FTP_BINARY)
 $block = preg_replace("/\r\n|\r|\n/",$this->_eol_code[$this->OS_remote],$block);
do {if ( ($t = @socket_write($this->_ftp_temp_sock,$block)) === FALSE)
 {$this->PushError("_data_write","socket_write",socket_strerror(socket_last_error($this->_ftp_temp_sock)));
$this->_data_close();
{$AspisRetTemp = FALSE;
return $AspisRetTemp;
}}$block = substr($block,$t);
}while (!empty($block) )
;
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function _data_close (  ) {
{@socket_close($this->_ftp_temp_sock);
@socket_close($this->_ftp_data_sock);
$this->SendMSG("Disconnected data from remote host");
{$AspisRetTemp = TRUE;
return $AspisRetTemp;
}} }
function _quit (  ) {
{if ( $this->_connected)
 {@socket_close($this->_ftp_control_sock);
$this->_connected = false;
$this->SendMSG("Socket closed");
}} }
};
?>
<?php 