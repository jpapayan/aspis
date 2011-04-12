<?php require_once('AspisMain.php'); ?><?php
class SMTP{var $SMTP_PORT = array(25,false);
var $CRLF = array("\r\n",false);
var $do_debug;
var $do_verp = array(false,false);
var $smtp_conn;
var $error;
var $helo_rply;
function SMTP (  ) {
{$this->smtp_conn = array(0,false);
$this->error = array(null,false);
$this->helo_rply = array(null,false);
$this->do_debug = array(0,false);
} }
function Connect ( $host,$port = array(0,false),$tval = array(30,false) ) {
{$this->error = array(null,false);
if ( deAspis($this->connected()))
 {$this->error = array(array("error" => array("Already connected to a server",false,false)),false);
return array(false,false);
}if ( ((empty($port) || Aspis_empty( $port))))
 {$port = $this->SMTP_PORT;
}$this->smtp_conn = AspisInternalFunctionCall("fsockopen",$host[0],$port[0],AspisPushRefParam($errno),AspisPushRefParam($errstr),$tval[0],array(2,3));
if ( ((empty($this->smtp_conn) || Aspis_empty( $this ->smtp_conn ))))
 {$this->error = array(array("error" => array("Failed to connect to server",false,false),deregisterTaint(array("errno",false)) => addTaint($errno),deregisterTaint(array("errstr",false)) => addTaint($errstr)),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),concat2(concat(concat2(concat1(": ",$errstr)," ("),$errno),")")),$this->CRLF));
}return array(false,false);
}if ( (deAspis(Aspis_substr(array(PHP_OS,false),array(0,false),array(3,false))) != ("WIN")))
 socket_set_timeout(deAspisRC($this->smtp_conn),deAspisRC($tval),0);
$announce = $this->get_lines();
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$announce));
}return array(true,false);
} }
function Authenticate ( $username,$password ) {
{fputs($this->smtp_conn[0],(deconcat1("AUTH LOGIN",$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($code[0] != (334)))
 {$this->error = array(array("error" => array("AUTH not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}fputs($this->smtp_conn[0],(deconcat(Aspis_base64_encode($username),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($code[0] != (334)))
 {$this->error = array(array("error" => array("Username not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}fputs($this->smtp_conn[0],(deconcat(Aspis_base64_encode($password),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($code[0] != (235)))
 {$this->error = array(array("error" => array("Password not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return array(true,false);
} }
function Connected (  ) {
{if ( (!((empty($this->smtp_conn) || Aspis_empty( $this ->smtp_conn )))))
 {$sock_status = array(socket_get_status(deAspisRC($this->smtp_conn)),false);
if ( deAspis($sock_status[0]["eof"]))
 {if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat2(concat1("SMTP -> NOTICE:",$this->CRLF),"EOF caught while checking if connected"));
}$this->Close();
return array(false,false);
}return array(true,false);
}return array(false,false);
} }
function Close (  ) {
{$this->error = array(null,false);
$this->helo_rply = array(null,false);
if ( (!((empty($this->smtp_conn) || Aspis_empty( $this ->smtp_conn )))))
 {fclose($this->smtp_conn[0]);
$this->smtp_conn = array(0,false);
}} }
function Data ( $msg_data ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Data() without being connected",false,false)),false);
return array(false,false);
}fputs($this->smtp_conn[0],(deconcat1("DATA",$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( ($code[0] != (354)))
 {$this->error = array(array("error" => array("DATA command not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}$msg_data = Aspis_str_replace(array("\r\n",false),array("\n",false),$msg_data);
$msg_data = Aspis_str_replace(array("\r",false),array("\n",false),$msg_data);
$lines = Aspis_explode(array("\n",false),$msg_data);
$field = Aspis_substr(attachAspis($lines,(0)),array(0,false),attAspis(strpos(deAspis(attachAspis($lines,(0))),":")));
$in_headers = array(false,false);
if ( ((!((empty($field) || Aspis_empty( $field)))) && (denot_boolean(Aspis_strstr($field,array(" ",false))))))
 {$in_headers = array(true,false);
}$max_line_length = array(998,false);
while ( deAspis(list(,$line) = deAspisList(@Aspis_each($lines),array())) )
{$lines_out = array(null,false);
if ( (($line[0] == ("")) && $in_headers[0]))
 {$in_headers = array(false,false);
}while ( (strlen($line[0]) > $max_line_length[0]) )
{$pos = attAspis(strrpos(deAspis(Aspis_substr($line,array(0,false),$max_line_length)),(" ")));
if ( (denot_boolean($pos)))
 {$pos = array($max_line_length[0] - (1),false);
}arrayAssignAdd($lines_out[0][],addTaint(Aspis_substr($line,array(0,false),$pos)));
$line = Aspis_substr($line,array($pos[0] + (1),false));
if ( $in_headers[0])
 {$line = concat1("\t",$line);
}}arrayAssignAdd($lines_out[0][],addTaint($line));
while ( deAspis(list(,$line_out) = deAspisList(@Aspis_each($lines_out),array())) )
{if ( (strlen($line_out[0]) > (0)))
 {if ( (deAspis(Aspis_substr($line_out,array(0,false),array(1,false))) == (".")))
 {$line_out = concat1(".",$line_out);
}}fputs($this->smtp_conn[0],(deconcat($line_out,$this->CRLF)));
}}fputs($this->smtp_conn[0],(deconcat(concat2($this->CRLF,"."),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( ($code[0] != (250)))
 {$this->error = array(array("error" => array("DATA not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return array(true,false);
} }
function Expand ( $name ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Expand() without being connected",false,false)),false);
return array(false,false);
}fputs($this->smtp_conn[0],(deconcat(concat1("EXPN ",$name),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( ($code[0] != (250)))
 {$this->error = array(array("error" => array("EXPN not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}$entries = Aspis_explode($this->CRLF,$rply);
while ( deAspis(list(,$l) = deAspisList(@Aspis_each($entries),array())) )
{arrayAssignAdd($list[0][],addTaint(Aspis_substr($l,array(4,false))));
}return $list;
} }
function Hello ( $host = array("",false) ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Hello() without being connected",false,false)),false);
return array(false,false);
}if ( ((empty($host) || Aspis_empty( $host))))
 {$host = array("localhost",false);
}if ( (denot_boolean($this->SendHello(array("EHLO",false),$host))))
 {if ( (denot_boolean($this->SendHello(array("HELO",false),$host))))
 return array(false,false);
}return array(true,false);
} }
function SendHello ( $hello,$host ) {
{fputs($this->smtp_conn[0],(deconcat(concat(concat2($hello," "),$host),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER: ",$this->CRLF),$rply));
}if ( ($code[0] != (250)))
 {$this->error = array(array(deregisterTaint(array("error",false)) => addTaint(concat2($hello," not accepted from server")),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}$this->helo_rply = $rply;
return array(true,false);
} }
function Help ( $keyword = array("",false) ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Help() without being connected",false,false)),false);
return array(false,false);
}$extra = array("",false);
if ( (!((empty($keyword) || Aspis_empty( $keyword)))))
 {$extra = concat1(" ",$keyword);
}fputs($this->smtp_conn[0],(deconcat(concat1("HELP",$extra),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( (($code[0] != (211)) && ($code[0] != (214))))
 {$this->error = array(array("error" => array("HELP not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return $rply;
} }
function Mail ( $from ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Mail() without being connected",false,false)),false);
return array(false,false);
}$useVerp = ($this->do_verp[0] ? array("XVERP",false) : array("",false));
fputs($this->smtp_conn[0],(deconcat(concat(concat2(concat1("MAIL FROM:<",$from),">"),$useVerp),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( ($code[0] != (250)))
 {$this->error = array(array("error" => array("MAIL not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return array(true,false);
} }
function Noop (  ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Noop() without being connected",false,false)),false);
return array(false,false);
}fputs($this->smtp_conn[0],(deconcat1("NOOP",$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( ($code[0] != (250)))
 {$this->error = array(array("error" => array("NOOP not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return array(true,false);
} }
function Quit ( $close_on_error = array(true,false) ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Quit() without being connected",false,false)),false);
return array(false,false);
}fputs($this->smtp_conn[0],(deconcat1("quit",$this->CRLF)));
$byemsg = $this->get_lines();
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$byemsg));
}$rval = array(true,false);
$e = array(null,false);
$code = Aspis_substr($byemsg,array(0,false),array(3,false));
if ( ($code[0] != (221)))
 {$e = array(array("error" => array("SMTP server rejected quit command",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_rply",false)) => addTaint(Aspis_substr($byemsg,array(4,false)))),false);
$rval = array(false,false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$e[0]["error"]),": "),$byemsg),$this->CRLF));
}}if ( (((empty($e) || Aspis_empty( $e))) || $close_on_error[0]))
 {$this->Close();
}return $rval;
} }
function Recipient ( $to ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Recipient() without being connected",false,false)),false);
return array(false,false);
}fputs($this->smtp_conn[0],(deconcat(concat2(concat1("RCPT TO:<",$to),">"),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( (($code[0] != (250)) && ($code[0] != (251))))
 {$this->error = array(array("error" => array("RCPT not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return array(true,false);
} }
function Reset (  ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Reset() without being connected",false,false)),false);
return array(false,false);
}fputs($this->smtp_conn[0],(deconcat1("RSET",$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( ($code[0] != (250)))
 {$this->error = array(array("error" => array("RSET failed",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return array(true,false);
} }
function Send ( $from ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Send() without being connected",false,false)),false);
return array(false,false);
}fputs($this->smtp_conn[0],(deconcat(concat1("SEND FROM:",$from),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( ($code[0] != (250)))
 {$this->error = array(array("error" => array("SEND not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return array(true,false);
} }
function SendAndMail ( $from ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called SendAndMail() without being connected",false,false)),false);
return array(false,false);
}fputs($this->smtp_conn[0],(deconcat(concat1("SAML FROM:",$from),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( ($code[0] != (250)))
 {$this->error = array(array("error" => array("SAML not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return array(true,false);
} }
function SendOrMail ( $from ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called SendOrMail() without being connected",false,false)),false);
return array(false,false);
}fputs($this->smtp_conn[0],(deconcat(concat1("SOML FROM:",$from),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( ($code[0] != (250)))
 {$this->error = array(array("error" => array("SOML not accepted from server",false,false),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return array(true,false);
} }
function Turn (  ) {
{$this->error = array(array(deregisterTaint(array("error",false)) => addTaint(concat12("This method, TURN, of the SMTP ","is not implemented"))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> NOTICE: ",$this->error[0][("error")]),$this->CRLF));
}return array(false,false);
} }
function Verify ( $name ) {
{$this->error = array(null,false);
if ( (denot_boolean($this->connected())))
 {$this->error = array(array("error" => array("Called Verify() without being connected",false,false)),false);
return array(false,false);
}fputs($this->smtp_conn[0],(deconcat(concat1("VRFY ",$name),$this->CRLF)));
$rply = $this->get_lines();
$code = Aspis_substr($rply,array(0,false),array(3,false));
if ( ($this->do_debug[0] >= (2)))
 {echo AspisCheckPrint(concat(concat1("SMTP -> FROM SERVER:",$this->CRLF),$rply));
}if ( (($code[0] != (250)) && ($code[0] != (251))))
 {$this->error = array(array(deregisterTaint(array("error",false)) => addTaint(concat2(concat1("VRFY failed on name '",$name),"'")),deregisterTaint(array("smtp_code",false)) => addTaint($code),deregisterTaint(array("smtp_msg",false)) => addTaint(Aspis_substr($rply,array(4,false)))),false);
if ( ($this->do_debug[0] >= (1)))
 {echo AspisCheckPrint(concat(concat(concat2(concat1("SMTP -> ERROR: ",$this->error[0][("error")]),": "),$rply),$this->CRLF));
}return array(false,false);
}return $rply;
} }
function get_lines (  ) {
{$data = array("",false);
while ( deAspis($str = @attAspis(fgets($this->smtp_conn[0],(515)))) )
{if ( ($this->do_debug[0] >= (4)))
 {echo AspisCheckPrint(concat(concat2(concat1("SMTP -> get_lines(): \$data was \"",$data),"\""),$this->CRLF));
echo AspisCheckPrint(concat(concat2(concat1("SMTP -> get_lines(): \$str is \"",$str),"\""),$this->CRLF));
}$data = concat($data,$str);
if ( ($this->do_debug[0] >= (4)))
 {echo AspisCheckPrint(concat(concat2(concat1("SMTP -> get_lines(): \$data is \"",$data),"\""),$this->CRLF));
}if ( (deAspis(Aspis_substr($str,array(3,false),array(1,false))) == (" ")))
 {break ;
}}return $data;
} }
};
?>
<?php 