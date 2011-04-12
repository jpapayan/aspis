<?php require_once('AspisMain.php'); ?><?php
class PHPMailer{var $Priority = array(3,false);
var $CharSet = array('iso-8859-1',false);
var $ContentType = array('text/plain',false);
var $Encoding = array('8bit',false);
var $ErrorInfo = array('',false);
var $From = array('root@localhost',false);
var $FromName = array('Root User',false);
var $Sender = array('',false);
var $Subject = array('',false);
var $Body = array('',false);
var $AltBody = array('',false);
var $WordWrap = array(0,false);
var $Mailer = array('mail',false);
var $Sendmail = array('/usr/sbin/sendmail',false);
var $PluginDir = array('',false);
var $Version = array("2.0.4",false);
var $ConfirmReadingTo = array('',false);
var $Hostname = array('',false);
var $MessageID = array('',false);
var $Host = array('localhost',false);
var $Port = array(25,false);
var $Helo = array('',false);
var $SMTPSecure = array("",false);
var $SMTPAuth = array(false,false);
var $Username = array('',false);
var $Password = array('',false);
var $Timeout = array(10,false);
var $SMTPDebug = array(false,false);
var $SMTPKeepAlive = array(false,false);
var $SingleTo = array(false,false);
var $smtp = array(NULL,false);
var $to = array(array(),false);
var $cc = array(array(),false);
var $bcc = array(array(),false);
var $ReplyTo = array(array(),false);
var $attachment = array(array(),false);
var $CustomHeader = array(array(),false);
var $message_type = array('',false);
var $boundary = array(array(),false);
var $language = array(array(),false);
var $error_count = array(0,false);
var $LE = array("\n",false);
var $sign_cert_file = array("",false);
var $sign_key_file = array("",false);
var $sign_key_pass = array("",false);
function IsHTML ( $bool ) {
{if ( ($bool[0] == true))
 {$this->ContentType = array('text/html',false);
}else 
{{$this->ContentType = array('text/plain',false);
}}} }
function IsSMTP (  ) {
{$this->Mailer = array('smtp',false);
} }
function IsMail (  ) {
{$this->Mailer = array('mail',false);
} }
function IsSendmail (  ) {
{$this->Mailer = array('sendmail',false);
} }
function IsQmail (  ) {
{$this->Sendmail = array('/var/qmail/bin/sendmail',false);
$this->Mailer = array('sendmail',false);
} }
function AddAddress ( $address,$name = array('',false) ) {
{$cur = attAspis(count($this->to[0]));
arrayAssign($this->to[0][$cur[0]][0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_trim($address)));
arrayAssign($this->to[0][$cur[0]][0],deAspis(registerTaint(array(1,false))),addTaint($name));
} }
function AddCC ( $address,$name = array('',false) ) {
{$cur = attAspis(count($this->cc[0]));
arrayAssign($this->cc[0][$cur[0]][0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_trim($address)));
arrayAssign($this->cc[0][$cur[0]][0],deAspis(registerTaint(array(1,false))),addTaint($name));
} }
function AddBCC ( $address,$name = array('',false) ) {
{$cur = attAspis(count($this->bcc[0]));
arrayAssign($this->bcc[0][$cur[0]][0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_trim($address)));
arrayAssign($this->bcc[0][$cur[0]][0],deAspis(registerTaint(array(1,false))),addTaint($name));
} }
function AddReplyTo ( $address,$name = array('',false) ) {
{$cur = attAspis(count($this->ReplyTo[0]));
arrayAssign($this->ReplyTo[0][$cur[0]][0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_trim($address)));
arrayAssign($this->ReplyTo[0][$cur[0]][0],deAspis(registerTaint(array(1,false))),addTaint($name));
} }
function Send (  ) {
{$header = array('',false);
$body = array('',false);
$result = array(true,false);
if ( (((count($this->to[0]) + count($this->cc[0])) + count($this->bcc[0])) < (1)))
 {$this->SetError($this->Lang(array('provide_address',false)));
return array(false,false);
}if ( (!((empty($this->AltBody) || Aspis_empty( $this ->AltBody )))))
 {$this->ContentType = array('multipart/alternative',false);
}$this->error_count = array(0,false);
$this->SetMessageType();
$header = concat($header,$this->CreateHeader());
$body = $this->CreateBody();
if ( ($body[0] == ('')))
 {return array(false,false);
}switch ( $this->Mailer[0] ) {
case ('sendmail'):$result = $this->SendmailSend($header,$body);
break ;
case ('smtp'):$result = $this->SmtpSend($header,$body);
break ;
case ('mail'):$result = $this->MailSend($header,$body);
break ;
default :$result = $this->MailSend($header,$body);
break ;
 }
return $result;
} }
function SendmailSend ( $header,$body ) {
{if ( ($this->Sender[0] != ('')))
 {$sendmail = Aspis_sprintf(array("%s -oi -f %s -t",false),Aspis_escapeshellcmd($this->Sendmail),Aspis_escapeshellarg($this->Sender));
}else 
{{$sendmail = Aspis_sprintf(array("%s -oi -t",false),Aspis_escapeshellcmd($this->Sendmail));
}}if ( (denot_boolean(@$mail = attAspis(popen($sendmail[0],('w'))))))
 {$this->SetError(concat($this->Lang(array('execute',false)),$this->Sendmail));
return array(false,false);
}fputs($mail[0],$header[0]);
fputs($mail[0],$body[0]);
$result = attAspis(pclose($mail[0]));
if ( ((version_compare(deAspisRC(array(phpversion(),false)),'4.2.3')) == deAspis(negate(array(1,false)))))
 {$result = array(($result[0] >> (8)) & (0xFF),false);
}if ( ($result[0] != (0)))
 {$this->SetError(concat($this->Lang(array('execute',false)),$this->Sendmail));
return array(false,false);
}return array(true,false);
} }
function MailSend ( $header,$body ) {
{$to = array('',false);
for ( $i = array(0,false) ; ($i[0] < count($this->to[0])) ; postincr($i) )
{if ( ($i[0] != (0)))
 {$to = concat2($to,', ');
}$to = concat($to,$this->AddrFormat($this->to[0][$i[0]]));
}$toArr = Aspis_split(array(',',false),$to);
$params = Aspis_sprintf(array("-oi -f %s",false),$this->Sender);
if ( (($this->Sender[0] != ('')) && (strlen((ini_get('safe_mode'))) < (1))))
 {$old_from = array(ini_get('sendmail_from'),false);
ini_set('sendmail_from',deAspisRC($this->Sender));
if ( (($this->SingleTo[0] === true) && (count($toArr[0]) > (1))))
 {foreach ( $toArr[0] as $key =>$val )
{restoreTaint($key,$val);
{$rt = @attAspis(mail($val[0],deAspis($this->EncodeHeader($this->SecureHeader($this->Subject))),$body[0],$header[0],$params[0]));
}}}else 
{{$rt = @attAspis(mail($to[0],deAspis($this->EncodeHeader($this->SecureHeader($this->Subject))),$body[0],$header[0],$params[0]));
}}}else 
{{if ( (($this->SingleTo[0] === true) && (count($toArr[0]) > (1))))
 {foreach ( $toArr[0] as $key =>$val )
{restoreTaint($key,$val);
{$rt = @attAspis(mail($val[0],deAspis($this->EncodeHeader($this->SecureHeader($this->Subject))),$body[0],$header[0],$params[0]));
}}}else 
{{$rt = @attAspis(mail($to[0],deAspis($this->EncodeHeader($this->SecureHeader($this->Subject))),$body[0],$header[0]));
}}}}if ( ((isset($old_from) && Aspis_isset( $old_from))))
 {ini_set('sendmail_from',deAspisRC($old_from));
}if ( (denot_boolean($rt)))
 {$this->SetError($this->Lang(array('instantiate',false)));
return array(false,false);
}return array(true,false);
} }
function SmtpSend ( $header,$body ) {
{include_once (deconcat2($this->PluginDir,'class-smtp.php'));
$error = array('',false);
$bad_rcpt = array(array(),false);
if ( (denot_boolean($this->SmtpConnect())))
 {return array(false,false);
}$smtp_from = ($this->Sender[0] == ('')) ? $this->From : $this->Sender;
if ( (denot_boolean($this->smtp[0]->Mail($smtp_from))))
 {$error = concat($this->Lang(array('from_failed',false)),$smtp_from);
$this->SetError($error);
$this->smtp[0]->Reset();
return array(false,false);
}for ( $i = array(0,false) ; ($i[0] < count($this->to[0])) ; postincr($i) )
{if ( (denot_boolean($this->smtp[0]->Recipient($this->to[0][$i[0]][0][(0)]))))
 {arrayAssignAdd($bad_rcpt[0][],addTaint($this->to[0][$i[0]][0][(0)]));
}}for ( $i = array(0,false) ; ($i[0] < count($this->cc[0])) ; postincr($i) )
{if ( (denot_boolean($this->smtp[0]->Recipient($this->cc[0][$i[0]][0][(0)]))))
 {arrayAssignAdd($bad_rcpt[0][],addTaint($this->cc[0][$i[0]][0][(0)]));
}}for ( $i = array(0,false) ; ($i[0] < count($this->bcc[0])) ; postincr($i) )
{if ( (denot_boolean($this->smtp[0]->Recipient($this->bcc[0][$i[0]][0][(0)]))))
 {arrayAssignAdd($bad_rcpt[0][],addTaint($this->bcc[0][$i[0]][0][(0)]));
}}if ( (count($bad_rcpt[0]) > (0)))
 {for ( $i = array(0,false) ; ($i[0] < count($bad_rcpt[0])) ; postincr($i) )
{if ( ($i[0] != (0)))
 {$error = concat2($error,', ');
}$error = concat($error,attachAspis($bad_rcpt,$i[0]));
}$error = concat($this->Lang(array('recipients_failed',false)),$error);
$this->SetError($error);
$this->smtp[0]->Reset();
return array(false,false);
}if ( (denot_boolean($this->smtp[0]->Data(concat($header,$body)))))
 {$this->SetError($this->Lang(array('data_not_accepted',false)));
$this->smtp[0]->Reset();
return array(false,false);
}if ( ($this->SMTPKeepAlive[0] == true))
 {$this->smtp[0]->Reset();
}else 
{{$this->SmtpClose();
}}return array(true,false);
} }
function SmtpConnect (  ) {
{if ( ($this->smtp[0] == NULL))
 {$this->smtp = array(new SMTP(),false);
}$this->smtp[0]->do_debug = $this->SMTPDebug;
$hosts = Aspis_explode(array(';',false),$this->Host);
$index = array(0,false);
$connection = ($this->smtp[0]->Connected());
while ( (($index[0] < count($hosts[0])) && ($connection[0] == false)) )
{$hostinfo = array(array(),false);
if ( deAspis(AspisInternalFunctionCall("eregi",('^(.+):([0-9]+)$'),deAspis(attachAspis($hosts,$index[0])),AspisPushRefParam($hostinfo),array(2))))
 {$host = attachAspis($hostinfo,(1));
$port = attachAspis($hostinfo,(2));
}else 
{{$host = attachAspis($hosts,$index[0]);
$port = $this->Port;
}}if ( deAspis($this->smtp[0]->Connect(concat(((!((empty($this->SMTPSecure) || Aspis_empty( $this ->SMTPSecure )))) ? concat2($this->SMTPSecure,'://') : array('',false)),$host),$port,$this->Timeout)))
 {if ( ($this->Helo[0] != ('')))
 {$this->smtp[0]->Hello($this->Helo);
}else 
{{$this->smtp[0]->Hello($this->ServerHostname());
}}$connection = array(true,false);
if ( $this->SMTPAuth[0])
 {if ( (denot_boolean($this->smtp[0]->Authenticate($this->Username,$this->Password))))
 {$this->SetError($this->Lang(array('authenticate',false)));
$this->smtp[0]->Reset();
$connection = array(false,false);
}}}postincr($index);
}if ( (denot_boolean($connection)))
 {$this->SetError($this->Lang(array('connect_host',false)));
}return $connection;
} }
function SmtpClose (  ) {
{if ( ($this->smtp[0] != NULL))
 {if ( deAspis($this->smtp[0]->Connected()))
 {$this->smtp[0]->Quit();
$this->smtp[0]->Close();
}}} }
function SetLanguage ( $lang_type,$lang_path = array('language/',false) ) {
{if ( file_exists((deconcat2(concat(concat2($lang_path,'phpmailer.lang-'),$lang_type),'.php'))))
 {include (deconcat2(concat(concat2($lang_path,'phpmailer.lang-'),$lang_type),'.php'));
}elseif ( file_exists((deconcat2($lang_path,'phpmailer.lang-en.php'))))
 {include (deconcat2($lang_path,'phpmailer.lang-en.php'));
}else 
{{$PHPMAILER_LANG = array(array(),false);
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("provide_address",false))),addTaint(concat1('You must provide at least one ',arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("mailer_not_supported",false))),addTaint(array(' mailer is not supported.',false))))));
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("execute",false))),addTaint(array('Could not execute: ',false)));
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("instantiate",false))),addTaint(array('Could not instantiate mail function.',false)));
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("authenticate",false))),addTaint(array('SMTP Error: Could not authenticate.',false)));
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("from_failed",false))),addTaint(array('The following From address failed: ',false)));
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("recipients_failed",false))),addTaint(concat1('SMTP Error: The following ',arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("data_not_accepted",false))),addTaint(array('SMTP Error: Data not accepted.',false))))));
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("connect_host",false))),addTaint(array('SMTP Error: Could not connect to SMTP host.',false)));
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("file_access",false))),addTaint(array('Could not access file: ',false)));
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("file_open",false))),addTaint(array('File Error: Could not open file: ',false)));
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("encoding",false))),addTaint(array('Unknown encoding: ',false)));
arrayAssign($PHPMAILER_LANG[0],deAspis(registerTaint(array("signing",false))),addTaint(array('Signing Error: ',false)));
}}$this->language = $PHPMAILER_LANG;
return array(true,false);
} }
function AddrAppend ( $type,$addr ) {
{$addr_str = concat2($type,': ');
$addr_str = concat($addr_str,$this->AddrFormat(attachAspis($addr,(0))));
if ( (count($addr[0]) > (1)))
 {for ( $i = array(1,false) ; ($i[0] < count($addr[0])) ; postincr($i) )
{$addr_str = concat($addr_str,concat1(', ',$this->AddrFormat(attachAspis($addr,$i[0]))));
}}$addr_str = concat($addr_str,$this->LE);
return $addr_str;
} }
function AddrFormat ( $addr ) {
{if ( ((empty($addr[0][(1)]) || Aspis_empty( $addr [0][(1)]))))
 {$formatted = $this->SecureHeader(attachAspis($addr,(0)));
}else 
{{$formatted = concat2(concat(concat2($this->EncodeHeader($this->SecureHeader(attachAspis($addr,(1))),array('phrase',false))," <"),$this->SecureHeader(attachAspis($addr,(0)))),">");
}}return $formatted;
} }
function WrapText ( $message,$length,$qp_mode = array(false,false) ) {
{$soft_break = deAspis(($qp_mode)) ? Aspis_sprintf(array(" =%s",false),$this->LE) : $this->LE;
$is_utf8 = (array(deAspis(Aspis_strtolower($this->CharSet)) == ("utf-8"),false));
$message = $this->FixEOL($message);
if ( (deAspis(Aspis_substr($message,negate(array(1,false)))) == $this->LE[0]))
 {$message = Aspis_substr($message,array(0,false),negate(array(1,false)));
}$line = Aspis_explode($this->LE,$message);
$message = array('',false);
for ( $i = array(0,false) ; ($i[0] < count($line[0])) ; postincr($i) )
{$line_part = Aspis_explode(array(' ',false),attachAspis($line,$i[0]));
$buf = array('',false);
for ( $e = array(0,false) ; ($e[0] < count($line_part[0])) ; postincr($e) )
{$word = attachAspis($line_part,$e[0]);
if ( ($qp_mode[0] and (strlen($word[0]) > $length[0])))
 {$space_left = array(($length[0] - strlen($buf[0])) - (1),false);
if ( ($e[0] != (0)))
 {if ( ($space_left[0] > (20)))
 {$len = $space_left;
if ( $is_utf8[0])
 {$len = $this->UTF8CharBoundary($word,$len);
}elseif ( (deAspis(Aspis_substr($word,array($len[0] - (1),false),array(1,false))) == ("=")))
 {postdecr($len);
}elseif ( (deAspis(Aspis_substr($word,array($len[0] - (2),false),array(1,false))) == ("=")))
 {$len = array($len[0] - (2),false);
}$part = Aspis_substr($word,array(0,false),$len);
$word = Aspis_substr($word,$len);
$buf = concat($buf,concat1(' ',$part));
$message = concat($message,concat($buf,Aspis_sprintf(array("=%s",false),$this->LE)));
}else 
{{$message = concat($message,concat($buf,$soft_break));
}}$buf = array('',false);
}while ( (strlen($word[0]) > (0)) )
{$len = $length;
if ( $is_utf8[0])
 {$len = $this->UTF8CharBoundary($word,$len);
}elseif ( (deAspis(Aspis_substr($word,array($len[0] - (1),false),array(1,false))) == ("=")))
 {postdecr($len);
}elseif ( (deAspis(Aspis_substr($word,array($len[0] - (2),false),array(1,false))) == ("=")))
 {$len = array($len[0] - (2),false);
}$part = Aspis_substr($word,array(0,false),$len);
$word = Aspis_substr($word,$len);
if ( (strlen($word[0]) > (0)))
 {$message = concat($message,concat($part,Aspis_sprintf(array("=%s",false),$this->LE)));
}else 
{{$buf = $part;
}}}}else 
{{$buf_o = $buf;
$buf = concat($buf,($e[0] == (0)) ? $word : (concat1(' ',$word)));
if ( ((strlen($buf[0]) > $length[0]) and ($buf_o[0] != (''))))
 {$message = concat($message,concat($buf_o,$soft_break));
$buf = $word;
}}}}$message = concat($message,concat($buf,$this->LE));
}return $message;
} }
function UTF8CharBoundary ( $encodedText,$maxLength ) {
{$foundSplitPos = array(false,false);
$lookBack = array(3,false);
while ( (denot_boolean($foundSplitPos)) )
{$lastChunk = Aspis_substr($encodedText,array($maxLength[0] - $lookBack[0],false),$lookBack);
$encodedCharPos = attAspis(strpos($lastChunk[0],"="));
if ( ($encodedCharPos[0] !== false))
 {$hex = Aspis_substr($encodedText,array((($maxLength[0] - $lookBack[0]) + $encodedCharPos[0]) + (1),false),array(2,false));
$dec = Aspis_hexdec($hex);
if ( ($dec[0] < (128)))
 {$maxLength = ($encodedCharPos[0] == (0)) ? $maxLength : array($maxLength[0] - ($lookBack[0] - $encodedCharPos[0]),false);
$foundSplitPos = array(true,false);
}elseif ( ($dec[0] >= (192)))
 {$maxLength = array($maxLength[0] - ($lookBack[0] - $encodedCharPos[0]),false);
$foundSplitPos = array(true,false);
}elseif ( ($dec[0] < (192)))
 {$lookBack = array((3) + $lookBack[0],false);
}}else 
{{$foundSplitPos = array(true,false);
}}}return $maxLength;
} }
function SetWordWrap (  ) {
{if ( ($this->WordWrap[0] < (1)))
 {return ;
}switch ( $this->message_type[0] ) {
case ('alt'):case ('alt_attachments'):$this->AltBody = $this->WrapText($this->AltBody,$this->WordWrap);
break ;
default :$this->Body = $this->WrapText($this->Body,$this->WordWrap);
break ;
 }
} }
function CreateHeader (  ) {
{$result = array('',false);
$uniq_id = attAspis(md5(uniqid(deAspisRC(attAspis(time())))));
arrayAssign($this->boundary[0],deAspis(registerTaint(array(1,false))),addTaint(concat1('b1_',$uniq_id)));
arrayAssign($this->boundary[0],deAspis(registerTaint(array(2,false))),addTaint(concat1('b2_',$uniq_id)));
$result = concat($result,$this->HeaderLine(array('Date',false),$this->RFCDate()));
if ( ($this->Sender[0] == ('')))
 {$result = concat($result,$this->HeaderLine(array('Return-Path',false),Aspis_trim($this->From)));
}else 
{{$result = concat($result,$this->HeaderLine(array('Return-Path',false),Aspis_trim($this->Sender)));
}}if ( ($this->Mailer[0] != ('mail')))
 {if ( (count($this->to[0]) > (0)))
 {$result = concat($result,$this->AddrAppend(array('To',false),$this->to));
}elseif ( (count($this->cc[0]) == (0)))
 {$result = concat($result,$this->HeaderLine(array('To',false),array('undisclosed-recipients:;',false)));
}}$from = array(array(),false);
arrayAssign($from[0][(0)][0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_trim($this->From)));
arrayAssign($from[0][(0)][0],deAspis(registerTaint(array(1,false))),addTaint($this->FromName));
$result = concat($result,$this->AddrAppend(array('From',false),$from));
if ( ((($this->Mailer[0] == ('sendmail')) || ($this->Mailer[0] == ('mail'))) && (count($this->cc[0]) > (0))))
 {$result = concat($result,$this->AddrAppend(array('Cc',false),$this->cc));
}if ( ((($this->Mailer[0] == ('sendmail')) || ($this->Mailer[0] == ('mail'))) && (count($this->bcc[0]) > (0))))
 {$result = concat($result,$this->AddrAppend(array('Bcc',false),$this->bcc));
}if ( (count($this->ReplyTo[0]) > (0)))
 {$result = concat($result,$this->AddrAppend(array('Reply-To',false),$this->ReplyTo));
}if ( ($this->Mailer[0] != ('mail')))
 {$result = concat($result,$this->HeaderLine(array('Subject',false),$this->EncodeHeader($this->SecureHeader($this->Subject))));
}if ( ($this->MessageID[0] != ('')))
 {$result = concat($result,$this->HeaderLine(array('Message-ID',false),$this->MessageID));
}else 
{{$result = concat($result,Aspis_sprintf(array("Message-ID: <%s@%s>%s",false),$uniq_id,$this->ServerHostname(),$this->LE));
}}$result = concat($result,$this->HeaderLine(array('X-Priority',false),$this->Priority));
$result = concat($result,$this->HeaderLine(array('X-Mailer',false),concat2(concat1('PHPMailer (phpmailer.sourceforge.net) [version ',$this->Version),']')));
if ( ($this->ConfirmReadingTo[0] != ('')))
 {$result = concat($result,$this->HeaderLine(array('Disposition-Notification-To',false),concat2(concat1('<',Aspis_trim($this->ConfirmReadingTo)),'>')));
}for ( $index = array(0,false) ; ($index[0] < count($this->CustomHeader[0])) ; postincr($index) )
{$result = concat($result,$this->HeaderLine(Aspis_trim($this->CustomHeader[0][$index[0]][0][(0)]),$this->EncodeHeader(Aspis_trim($this->CustomHeader[0][$index[0]][0][(1)]))));
}if ( (denot_boolean($this->sign_key_file)))
 {$result = concat($result,$this->HeaderLine(array('MIME-Version',false),array('1.0',false)));
$result = concat($result,$this->GetMailMIME());
}return $result;
} }
function GetMailMIME (  ) {
{$result = array('',false);
switch ( $this->message_type[0] ) {
case ('plain'):$result = concat($result,$this->HeaderLine(array('Content-Transfer-Encoding',false),$this->Encoding));
$result = concat($result,Aspis_sprintf(array("Content-Type: %s; charset=\"%s\"",false),$this->ContentType,$this->CharSet));
break ;
case ('attachments'):case ('alt_attachments'):if ( deAspis($this->InlineImageExists()))
 {$result = concat($result,Aspis_sprintf(array("Content-Type: %s;%s\ttype=\"text/html\";%s\tboundary=\"%s\"%s",false),array('multipart/related',false),$this->LE,$this->LE,$this->boundary[0][(1)],$this->LE));
}else 
{{$result = concat($result,$this->HeaderLine(array('Content-Type',false),array('multipart/mixed;',false)));
$result = concat($result,$this->TextLine(concat2(concat1("\tboundary=\"",$this->boundary[0][(1)]),'"')));
}}break ;
case ('alt'):$result = concat($result,$this->HeaderLine(array('Content-Type',false),array('multipart/alternative;',false)));
$result = concat($result,$this->TextLine(concat2(concat1("\tboundary=\"",$this->boundary[0][(1)]),'"')));
break ;
 }
if ( ($this->Mailer[0] != ('mail')))
 {$result = concat($result,concat($this->LE,$this->LE));
}return $result;
} }
function CreateBody (  ) {
{$result = array('',false);
if ( $this->sign_key_file[0])
 {$result = concat($result,$this->GetMailMIME());
}$this->SetWordWrap();
switch ( $this->message_type[0] ) {
case ('alt'):$result = concat($result,$this->GetBoundary($this->boundary[0][(1)],array('',false),array('text/plain',false),array('',false)));
$result = concat($result,$this->EncodeString($this->AltBody,$this->Encoding));
$result = concat($result,concat($this->LE,$this->LE));
$result = concat($result,$this->GetBoundary($this->boundary[0][(1)],array('',false),array('text/html',false),array('',false)));
$result = concat($result,$this->EncodeString($this->Body,$this->Encoding));
$result = concat($result,concat($this->LE,$this->LE));
$result = concat($result,$this->EndBoundary($this->boundary[0][(1)]));
break ;
case ('plain'):$result = concat($result,$this->EncodeString($this->Body,$this->Encoding));
break ;
case ('attachments'):$result = concat($result,$this->GetBoundary($this->boundary[0][(1)],array('',false),array('',false),array('',false)));
$result = concat($result,$this->EncodeString($this->Body,$this->Encoding));
$result = concat($result,$this->LE);
$result = concat($result,$this->AttachAll());
break ;
case ('alt_attachments'):$result = concat($result,Aspis_sprintf(array("--%s%s",false),$this->boundary[0][(1)],$this->LE));
$result = concat($result,Aspis_sprintf(concat12("Content-Type: %s;%s","\tboundary=\"%s\"%s"),array('multipart/alternative',false),$this->LE,$this->boundary[0][(2)],concat($this->LE,$this->LE)));
$result = concat($result,concat($this->GetBoundary($this->boundary[0][(2)],array('',false),array('text/plain',false),array('',false)),$this->LE));
$result = concat($result,$this->EncodeString($this->AltBody,$this->Encoding));
$result = concat($result,concat($this->LE,$this->LE));
$result = concat($result,concat($this->GetBoundary($this->boundary[0][(2)],array('',false),array('text/html',false),array('',false)),$this->LE));
$result = concat($result,$this->EncodeString($this->Body,$this->Encoding));
$result = concat($result,concat($this->LE,$this->LE));
$result = concat($result,$this->EndBoundary($this->boundary[0][(2)]));
$result = concat($result,$this->AttachAll());
break ;
 }
if ( deAspis($this->IsError()))
 {$result = array('',false);
}else 
{if ( $this->sign_key_file[0])
 {$file = attAspis(tempnam((""),("mail")));
$fp = attAspis(fopen($file[0],("w")));
fwrite($fp[0],$result[0]);
fclose($fp[0]);
$signed = attAspis(tempnam((""),("signed")));
if ( (@openssl_pkcs7_sign(deAspisRC($file),deAspisRC($signed),(deconcat1("file://",$this->sign_cert_file)),deAspisRC(array(array(concat1("file://",$this->sign_key_file),$this->sign_key_pass),false)),null)))
 {$fp = attAspis(fopen($signed[0],("r")));
$result = attAspis(fread($fp[0],filesize($this->sign_key_file[0])));
$result = array('',false);
while ( (!(feof($fp[0]))) )
{$result = concat($result,attAspis(fread($fp[0],(1024))));
}fclose($fp[0]);
}else 
{{$this->SetError(concat2($this->Lang(array("signing",false)),openssl_error_string()));
$result = array('',false);
}}unlink($file[0]);
unlink($signed[0]);
}}return $result;
} }
function GetBoundary ( $boundary,$charSet,$contentType,$encoding ) {
{$result = array('',false);
if ( ($charSet[0] == ('')))
 {$charSet = $this->CharSet;
}if ( ($contentType[0] == ('')))
 {$contentType = $this->ContentType;
}if ( ($encoding[0] == ('')))
 {$encoding = $this->Encoding;
}$result = concat($result,$this->TextLine(concat1('--',$boundary)));
$result = concat($result,Aspis_sprintf(array("Content-Type: %s; charset = \"%s\"",false),$contentType,$charSet));
$result = concat($result,$this->LE);
$result = concat($result,$this->HeaderLine(array('Content-Transfer-Encoding',false),$encoding));
$result = concat($result,$this->LE);
return $result;
} }
function EndBoundary ( $boundary ) {
{return concat(concat2(concat(concat2($this->LE,'--'),$boundary),'--'),$this->LE);
} }
function SetMessageType (  ) {
{if ( ((count($this->attachment[0]) < (1)) && (strlen($this->AltBody[0]) < (1))))
 {$this->message_type = array('plain',false);
}else 
{{if ( (count($this->attachment[0]) > (0)))
 {$this->message_type = array('attachments',false);
}if ( ((strlen($this->AltBody[0]) > (0)) && (count($this->attachment[0]) < (1))))
 {$this->message_type = array('alt',false);
}if ( ((strlen($this->AltBody[0]) > (0)) && (count($this->attachment[0]) > (0))))
 {$this->message_type = array('alt_attachments',false);
}}}} }
function HeaderLine ( $name,$value ) {
{return concat(concat(concat2($name,': '),$value),$this->LE);
} }
function TextLine ( $value ) {
{return concat($value,$this->LE);
} }
function AddAttachment ( $path,$name = array('',false),$encoding = array('base64',false),$type = array('application/octet-stream',false) ) {
{if ( (denot_boolean(@attAspis(is_file($path[0])))))
 {$this->SetError(concat($this->Lang(array('file_access',false)),$path));
return array(false,false);
}$filename = Aspis_basename($path);
if ( ($name[0] == ('')))
 {$name = $filename;
}$cur = attAspis(count($this->attachment[0]));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(0,false))),addTaint($path));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(1,false))),addTaint($filename));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(2,false))),addTaint($name));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(3,false))),addTaint($encoding));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(4,false))),addTaint($type));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(5,false))),addTaint(array(false,false)));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(6,false))),addTaint(array('attachment',false)));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(7,false))),addTaint(array(0,false)));
return array(true,false);
} }
function AttachAll (  ) {
{$mime = array(array(),false);
for ( $i = array(0,false) ; ($i[0] < count($this->attachment[0])) ; postincr($i) )
{$bString = $this->attachment[0][$i[0]][0][(5)];
if ( $bString[0])
 {$string = $this->attachment[0][$i[0]][0][(0)];
}else 
{{$path = $this->attachment[0][$i[0]][0][(0)];
}}$filename = $this->attachment[0][$i[0]][0][(1)];
$name = $this->attachment[0][$i[0]][0][(2)];
$encoding = $this->attachment[0][$i[0]][0][(3)];
$type = $this->attachment[0][$i[0]][0][(4)];
$disposition = $this->attachment[0][$i[0]][0][(6)];
$cid = $this->attachment[0][$i[0]][0][(7)];
arrayAssignAdd($mime[0][],addTaint(Aspis_sprintf(array("--%s%s",false),$this->boundary[0][(1)],$this->LE)));
arrayAssignAdd($mime[0][],addTaint(Aspis_sprintf(array("Content-Type: %s; name=\"%s\"%s",false),$type,$this->EncodeHeader($this->SecureHeader($name)),$this->LE)));
arrayAssignAdd($mime[0][],addTaint(Aspis_sprintf(array("Content-Transfer-Encoding: %s%s",false),$encoding,$this->LE)));
if ( ($disposition[0] == ('inline')))
 {arrayAssignAdd($mime[0][],addTaint(Aspis_sprintf(array("Content-ID: <%s>%s",false),$cid,$this->LE)));
}arrayAssignAdd($mime[0][],addTaint(Aspis_sprintf(array("Content-Disposition: %s; filename=\"%s\"%s",false),$disposition,$this->EncodeHeader($this->SecureHeader($name)),concat($this->LE,$this->LE))));
if ( $bString[0])
 {arrayAssignAdd($mime[0][],addTaint($this->EncodeString($string,$encoding)));
if ( deAspis($this->IsError()))
 {return array('',false);
}arrayAssignAdd($mime[0][],addTaint(concat($this->LE,$this->LE)));
}else 
{{arrayAssignAdd($mime[0][],addTaint($this->EncodeFile($path,$encoding)));
if ( deAspis($this->IsError()))
 {return array('',false);
}arrayAssignAdd($mime[0][],addTaint(concat($this->LE,$this->LE)));
}}}arrayAssignAdd($mime[0][],addTaint(Aspis_sprintf(array("--%s--%s",false),$this->boundary[0][(1)],$this->LE)));
return Aspis_join(array('',false),$mime);
} }
function EncodeFile ( $path,$encoding = array('base64',false) ) {
{if ( (denot_boolean(@$fd = attAspis(fopen($path[0],('rb'))))))
 {$this->SetError(concat($this->Lang(array('file_open',false)),$path));
return array('',false);
}$magic_quotes = array(get_magic_quotes_runtime(),false);
set_magic_quotes_runtime(0);
$file_buffer = attAspis(fread($fd[0],filesize($path[0])));
$file_buffer = $this->EncodeString($file_buffer,$encoding);
fclose($fd[0]);
set_magic_quotes_runtime(deAspisRC($magic_quotes));
return $file_buffer;
} }
function EncodeString ( $str,$encoding = array('base64',false) ) {
{$encoded = array('',false);
switch ( deAspis(Aspis_strtolower($encoding)) ) {
case ('base64'):$encoded = attAspis(chunk_split(deAspis(Aspis_base64_encode($str)),(76),$this->LE[0]));
break ;
case ('7bit'):case ('8bit'):$encoded = $this->FixEOL($str);
if ( (deAspis(Aspis_substr($encoded,negate((attAspis(strlen($this->LE[0])))))) != $this->LE[0]))
 $encoded = concat($encoded,$this->LE);
break ;
case ('binary'):$encoded = $str;
break ;
case ('quoted-printable'):$encoded = $this->EncodeQP($str);
break ;
default :$this->SetError(concat($this->Lang(array('encoding',false)),$encoding));
break ;
 }
return $encoded;
} }
function EncodeHeader ( $str,$position = array('text',false) ) {
{$x = array(0,false);
switch ( deAspis(Aspis_strtolower($position)) ) {
case ('phrase'):if ( (denot_boolean(Aspis_preg_match(array('/[\200-\377]/',false),$str))))
 {$encoded = Aspis_addcslashes($str,array("\0..\37\177\\\"",false));
if ( (($str[0] == $encoded[0]) && (denot_boolean(Aspis_preg_match(array('/[^A-Za-z0-9!#$%&\'*+\/=?^_`{|}~ -]/',false),$str)))))
 {return ($encoded);
}else 
{{return (concat2(concat1("\"",$encoded),"\""));
}}}$x = Aspis_preg_match_all(array('/[^\040\041\043-\133\135-\176]/',false),$str,$matches);
break ;
case ('comment'):$x = Aspis_preg_match_all(array('/[()"]/',false),$str,$matches);
case ('text'):default :$x = array(deAspis(Aspis_preg_match_all(array('/[\000-\010\013\014\016-\037\177-\377]/',false),$str,$matches)) + $x[0],false);
break ;
 }
if ( ($x[0] == (0)))
 {return ($str);
}$maxlen = array(((75) - (7)) - strlen($this->CharSet[0]),false);
if ( ((strlen($str[0]) / (3)) < $x[0]))
 {$encoding = array('B',false);
if ( (function_exists(('mb_strlen')) && deAspis($this->HasMultiBytes($str))))
 {$encoded = $this->Base64EncodeWrapMB($str);
}else 
{{$encoded = Aspis_base64_encode($str);
$maxlen = array($maxlen[0] - ($maxlen[0] % (4)),false);
$encoded = Aspis_trim(attAspis(chunk_split($encoded[0],$maxlen[0],("\n"))));
}}}else 
{{$encoding = array('Q',false);
$encoded = $this->EncodeQ($str,$position);
$encoded = $this->WrapText($encoded,$maxlen,array(true,false));
$encoded = Aspis_str_replace(concat1('=',$this->LE),array("\n",false),Aspis_trim($encoded));
}}$encoded = Aspis_preg_replace(array('/^(.*)$/m',false),concat(concat1(" =?",$this->CharSet),concat2(concat1("?",$encoding),"?\\1?=")),$encoded);
$encoded = Aspis_trim(Aspis_str_replace(array("\n",false),$this->LE,$encoded));
return $encoded;
} }
function HasMultiBytes ( $str ) {
{if ( function_exists(('mb_strlen')))
 {return (array(strlen($str[0]) > (mb_strlen(deAspisRC($str),deAspisRC($this->CharSet))),false));
}else 
{{return array(False,false);
}}} }
function Base64EncodeWrapMB ( $str ) {
{$start = concat2(concat1("=?",$this->CharSet),"?B?");
$end = array("?=",false);
$encoded = array("",false);
$mb_length = array(mb_strlen(deAspisRC($str),deAspisRC($this->CharSet)),false);
$length = array(((75) - strlen($start[0])) - strlen($end[0]),false);
$ratio = array($mb_length[0] / strlen($str[0]),false);
$offset = $avgLength = attAspis(floor((($length[0] * $ratio[0]) * (.75))));
for ( $i = array(0,false) ; ($i[0] < $mb_length[0]) ; $i = array($offset[0] + $i[0],false) )
{$lookBack = array(0,false);
do {$offset = array($avgLength[0] - $lookBack[0],false);
$chunk = array(mb_substr(deAspisRC($str),deAspisRC($i),deAspisRC($offset),deAspisRC($this->CharSet)),false);
$chunk = Aspis_base64_encode($chunk);
postincr($lookBack);
}while ((strlen($chunk[0]) > $length[0]) )
;
$encoded = concat($encoded,concat($chunk,$this->LE));
}$encoded = Aspis_substr($encoded,array(0,false),negate(attAspis(strlen($this->LE[0]))));
return $encoded;
} }
function EncodeQP ( $input = array('',false),$line_max = array(76,false),$space_conv = array(false,false) ) {
{$hex = array(array(array('0',false),array('1',false),array('2',false),array('3',false),array('4',false),array('5',false),array('6',false),array('7',false),array('8',false),array('9',false),array('A',false),array('B',false),array('C',false),array('D',false),array('E',false),array('F',false)),false);
$lines = Aspis_preg_split(array('/(?:\r\n|\r|\n)/',false),$input);
$eol = array("\r\n",false);
$escape = array('=',false);
$output = array('',false);
while ( deAspis(list(,$line) = deAspisList(Aspis_each($lines),array())) )
{$linlen = attAspis(strlen($line[0]));
$newline = array('',false);
for ( $i = array(0,false) ; ($i[0] < $linlen[0]) ; postincr($i) )
{$c = Aspis_substr($line,$i,array(1,false));
$dec = attAspis(ord($c[0]));
if ( (($i[0] == (0)) && ($dec[0] == (46))))
 {$c = array('=2E',false);
}if ( ($dec[0] == (32)))
 {if ( ($i[0] == ($linlen[0] - (1))))
 {$c = array('=20',false);
}else 
{if ( $space_conv[0])
 {$c = array('=20',false);
}}}elseif ( ((($dec[0] == (61)) || ($dec[0] < (32))) || ($dec[0] > (126))))
 {$h2 = attAspis(floor(($dec[0] / (16))));
$h1 = attAspis(floor(($dec[0] % (16))));
$c = concat(concat($escape,attachAspis($hex,$h2[0])),attachAspis($hex,$h1[0]));
}if ( ((strlen($newline[0]) + strlen($c[0])) >= $line_max[0]))
 {$output = concat($output,concat(concat($newline,$escape),$eol));
$newline = array('',false);
if ( ($dec[0] == (46)))
 {$c = array('=2E',false);
}}$newline = concat($newline,$c);
}$output = concat($output,concat($newline,$eol));
}return $output;
} }
function EncodeQ_callback ( $matches ) {
{return Aspis_sprintf(array('=%02X',false),attAspis(ord(deAspis(attachAspis($matches,(1))))));
} }
function EncodeQ ( $str,$position = array('text',false) ) {
{$encoded = Aspis_preg_replace(array("/[\r\n]/",false),array('',false),$str);
switch ( deAspis(Aspis_strtolower($position)) ) {
case ('phrase'):$encoded = Aspis_preg_replace_callback(array("/([^A-Za-z0-9!*+\/ -])/",false),array(array(array('PHPMailer',false),array('EncodeQ_callback',false)),false),$encoded);
break ;
case ('comment'):$encoded = Aspis_preg_replace_callback(array("/([\(\)\"])/",false),array(array(array('PHPMailer',false),array('EncodeQ_callback',false)),false),$encoded);
break ;
case ('text'):default :$encoded = Aspis_preg_replace_callback(array('/([\000-\011\013\014\016-\037\075\077\137\177-\377])/',false),array(array(array('PHPMailer',false),array('EncodeQ_callback',false)),false),$encoded);
break ;
 }
$encoded = Aspis_str_replace(array(' ',false),array('_',false),$encoded);
return $encoded;
} }
function AddStringAttachment ( $string,$filename,$encoding = array('base64',false),$type = array('application/octet-stream',false) ) {
{$cur = attAspis(count($this->attachment[0]));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(0,false))),addTaint($string));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(1,false))),addTaint($filename));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(2,false))),addTaint($filename));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(3,false))),addTaint($encoding));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(4,false))),addTaint($type));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(5,false))),addTaint(array(true,false)));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(6,false))),addTaint(array('attachment',false)));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(7,false))),addTaint(array(0,false)));
} }
function AddEmbeddedImage ( $path,$cid,$name = array('',false),$encoding = array('base64',false),$type = array('application/octet-stream',false) ) {
{if ( (denot_boolean(@attAspis(is_file($path[0])))))
 {$this->SetError(concat($this->Lang(array('file_access',false)),$path));
return array(false,false);
}$filename = Aspis_basename($path);
if ( ($name[0] == ('')))
 {$name = $filename;
}$cur = attAspis(count($this->attachment[0]));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(0,false))),addTaint($path));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(1,false))),addTaint($filename));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(2,false))),addTaint($name));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(3,false))),addTaint($encoding));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(4,false))),addTaint($type));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(5,false))),addTaint(array(false,false)));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(6,false))),addTaint(array('inline',false)));
arrayAssign($this->attachment[0][$cur[0]][0],deAspis(registerTaint(array(7,false))),addTaint($cid));
return array(true,false);
} }
function InlineImageExists (  ) {
{$result = array(false,false);
for ( $i = array(0,false) ; ($i[0] < count($this->attachment[0])) ; postincr($i) )
{if ( ($this->attachment[0][$i[0]][0][(6)][0] == ('inline')))
 {$result = array(true,false);
break ;
}}return $result;
} }
function ClearAddresses (  ) {
{$this->to = array(array(),false);
} }
function ClearCCs (  ) {
{$this->cc = array(array(),false);
} }
function ClearBCCs (  ) {
{$this->bcc = array(array(),false);
} }
function ClearReplyTos (  ) {
{$this->ReplyTo = array(array(),false);
} }
function ClearAllRecipients (  ) {
{$this->to = array(array(),false);
$this->cc = array(array(),false);
$this->bcc = array(array(),false);
} }
function ClearAttachments (  ) {
{$this->attachment = array(array(),false);
} }
function ClearCustomHeaders (  ) {
{$this->CustomHeader = array(array(),false);
} }
function SetError ( $msg ) {
{postincr($this->error_count);
$this->ErrorInfo = $msg;
} }
function RFCDate (  ) {
{$tz = attAspis(date(('Z')));
$tzs = ($tz[0] < (0)) ? array('-',false) : array('+',false);
$tz = Aspis_abs($tz);
$tz = array((deAspis(int_cast((array($tz[0] / (3600),false)))) * (100)) + (($tz[0] % (3600)) / (60)),false);
$result = Aspis_sprintf(array("%s %s%04d",false),attAspis(date(('D, j M Y H:i:s'))),$tzs,$tz);
return $result;
} }
function ServerVar ( $varName ) {
{global $HTTP_SERVER_VARS;
global $HTTP_ENV_VARS;
if ( (!((isset($_SERVER) && Aspis_isset( $_SERVER)))))
 {$_SERVER = $HTTP_SERVER_VARS;
if ( (!((isset($_SERVER[0][('REMOTE_ADDR')]) && Aspis_isset( $_SERVER [0][('REMOTE_ADDR')])))))
 {$_SERVER = $HTTP_ENV_VARS;
}}if ( ((isset($_SERVER[0][$varName[0]]) && Aspis_isset( $_SERVER [0][$varName[0]]))))
 {return attachAspis($_SERVER,$varName[0]);
}else 
{{return array('',false);
}}} }
function ServerHostname (  ) {
{if ( ($this->Hostname[0] != ('')))
 {$result = $this->Hostname;
}elseif ( (deAspis($this->ServerVar(array('SERVER_NAME',false))) != ('')))
 {$result = $this->ServerVar(array('SERVER_NAME',false));
}else 
{{$result = array('localhost.localdomain',false);
}}return $result;
} }
function Lang ( $key ) {
{if ( (count($this->language[0]) < (1)))
 {$this->SetLanguage(array('en',false));
}if ( ((isset($this->language[0][$key[0]]) && Aspis_isset( $this ->language [0][$key[0]] ))))
 {return $this->language[0][$key[0]];
}else 
{{return concat1('Language string failed to load: ',$key);
}}} }
function IsError (  ) {
{return (array($this->error_count[0] > (0),false));
} }
function FixEOL ( $str ) {
{$str = Aspis_str_replace(array("\r\n",false),array("\n",false),$str);
$str = Aspis_str_replace(array("\r",false),array("\n",false),$str);
$str = Aspis_str_replace(array("\n",false),$this->LE,$str);
return $str;
} }
function AddCustomHeader ( $custom_header ) {
{arrayAssignAdd($this->CustomHeader[0][],addTaint(Aspis_explode(array(':',false),$custom_header,array(2,false))));
} }
function MsgHTML ( $message,$basedir = array('',false) ) {
{Aspis_preg_match_all(array("/(src|background)=\"(.*)\"/Ui",false),$message,$images);
if ( ((isset($images[0][(2)]) && Aspis_isset( $images [0][(2)]))))
 {foreach ( deAspis(attachAspis($images,(2))) as $i =>$url )
{restoreTaint($i,$url);
{if ( (denot_boolean(Aspis_preg_match(array('/^[A-z][A-z]*:\/\//',false),$url))))
 {$filename = Aspis_basename($url);
$directory = Aspis_dirname($url);
($directory[0] == ('.')) ? $directory = array('',false) : array('',false);
$cid = concat1('cid:',attAspis(md5($filename[0])));
$fileParts = Aspis_split(array("\.",false),$filename);
$ext = attachAspis($fileParts,(1));
$mimeType = $this->_mime_types($ext);
if ( ((strlen($basedir[0]) > (1)) && (deAspis(Aspis_substr($basedir,negate(array(1,false)))) != ('/'))))
 {$basedir = concat2($basedir,'/');
}if ( ((strlen($directory[0]) > (1)) && (deAspis(Aspis_substr($directory,negate(array(1,false)))) != ('/'))))
 {$directory = concat2($directory,'/');
}if ( deAspis($this->AddEmbeddedImage(concat(concat($basedir,$directory),$filename),attAspis(md5($filename[0])),$filename,array('base64',false),$mimeType)))
 {$message = Aspis_preg_replace(concat2(concat(concat2(concat1("/",attachAspis($images[0][(1)],$i[0])),"=\""),Aspis_preg_quote($url,array('/',false))),"\"/Ui"),concat2(concat(concat2(attachAspis($images[0][(1)],$i[0]),"=\""),$cid),"\""),$message);
}}}}}$this->IsHTML(array(true,false));
$this->Body = $message;
$textMsg = Aspis_trim(Aspis_strip_tags(Aspis_preg_replace(array('/<(head|title|style|script)[^>]*>.*?<\/\\1>/s',false),array('',false),$message)));
if ( ((!((empty($textMsg) || Aspis_empty( $textMsg)))) && ((empty($this->AltBody) || Aspis_empty( $this ->AltBody )))))
 {$this->AltBody = Aspis_html_entity_decode($textMsg);
}if ( ((empty($this->AltBody) || Aspis_empty( $this ->AltBody ))))
 {$this->AltBody = concat12('To view this email message, open the email in with HTML compatibility!',"\n\n");
}} }
function _mime_types ( $ext = array('',false) ) {
{$mimes = array(array('ai' => array('application/postscript',false,false),'aif' => array('audio/x-aiff',false,false),'aifc' => array('audio/x-aiff',false,false),'aiff' => array('audio/x-aiff',false,false),'avi' => array('video/x-msvideo',false,false),'bin' => array('application/macbinary',false,false),'bmp' => array('image/bmp',false,false),'class' => array('application/octet-stream',false,false),'cpt' => array('application/mac-compactpro',false,false),'css' => array('text/css',false,false),'dcr' => array('application/x-director',false,false),'dir' => array('application/x-director',false,false),'dll' => array('application/octet-stream',false,false),'dms' => array('application/octet-stream',false,false),'doc' => array('application/msword',false,false),'dvi' => array('application/x-dvi',false,false),'dxr' => array('application/x-director',false,false),'eml' => array('message/rfc822',false,false),'eps' => array('application/postscript',false,false),'exe' => array('application/octet-stream',false,false),'gif' => array('image/gif',false,false),'gtar' => array('application/x-gtar',false,false),'htm' => array('text/html',false,false),'html' => array('text/html',false,false),'jpe' => array('image/jpeg',false,false),'jpeg' => array('image/jpeg',false,false),'jpg' => array('image/jpeg',false,false),'hqx' => array('application/mac-binhex40',false,false),'js' => array('application/x-javascript',false,false),'lha' => array('application/octet-stream',false,false),'log' => array('text/plain',false,false),'lzh' => array('application/octet-stream',false,false),'mid' => array('audio/midi',false,false),'midi' => array('audio/midi',false,false),'mif' => array('application/vnd.mif',false,false),'mov' => array('video/quicktime',false,false),'movie' => array('video/x-sgi-movie',false,false),'mp2' => array('audio/mpeg',false,false),'mp3' => array('audio/mpeg',false,false),'mpe' => array('video/mpeg',false,false),'mpeg' => array('video/mpeg',false,false),'mpg' => array('video/mpeg',false,false),'mpga' => array('audio/mpeg',false,false),'oda' => array('application/oda',false,false),'pdf' => array('application/pdf',false,false),'php' => array('application/x-httpd-php',false,false),'php3' => array('application/x-httpd-php',false,false),'php4' => array('application/x-httpd-php',false,false),'phps' => array('application/x-httpd-php-source',false,false),'phtml' => array('application/x-httpd-php',false,false),'png' => array('image/png',false,false),'ppt' => array('application/vnd.ms-powerpoint',false,false),'ps' => array('application/postscript',false,false),'psd' => array('application/octet-stream',false,false),'qt' => array('video/quicktime',false,false),'ra' => array('audio/x-realaudio',false,false),'ram' => array('audio/x-pn-realaudio',false,false),'rm' => array('audio/x-pn-realaudio',false,false),'rpm' => array('audio/x-pn-realaudio-plugin',false,false),'rtf' => array('text/rtf',false,false),'rtx' => array('text/richtext',false,false),'rv' => array('video/vnd.rn-realvideo',false,false),'sea' => array('application/octet-stream',false,false),'shtml' => array('text/html',false,false),'sit' => array('application/x-stuffit',false,false),'so' => array('application/octet-stream',false,false),'smi' => array('application/smil',false,false),'smil' => array('application/smil',false,false),'swf' => array('application/x-shockwave-flash',false,false),'tar' => array('application/x-tar',false,false),'text' => array('text/plain',false,false),'txt' => array('text/plain',false,false),'tgz' => array('application/x-tar',false,false),'tif' => array('image/tiff',false,false),'tiff' => array('image/tiff',false,false),'wav' => array('audio/x-wav',false,false),'wbxml' => array('application/vnd.wap.wbxml',false,false),'wmlc' => array('application/vnd.wap.wmlc',false,false),'word' => array('application/msword',false,false),'xht' => array('application/xhtml+xml',false,false),'xhtml' => array('application/xhtml+xml',false,false),'xl' => array('application/excel',false,false),'xls' => array('application/vnd.ms-excel',false,false),'xml' => array('text/xml',false,false),'xsl' => array('text/xml',false,false),'zip' => array('application/zip',false,false)),false);
return (!((isset($mimes[0][deAspis(Aspis_strtolower($ext))]) && Aspis_isset( $mimes [0][deAspis(Aspis_strtolower( $ext))])))) ? array('application/octet-stream',false) : attachAspis($mimes,deAspis(Aspis_strtolower($ext)));
} }
function set ( $name,$value = array('',false) ) {
{if ( ((isset($this->$name[0]) && Aspis_isset( $this ->$name[0] ))))
 {$this->$name[0] = $value;
}else 
{{$this->SetError(concat1('Cannot set or reset variable ',$name));
return array(false,false);
}}} }
function getFile ( $filename ) {
{$return = array('',false);
if ( deAspis($fp = attAspis(fopen($filename[0],('rb')))))
 {while ( (!(feof($fp[0]))) )
{$return = concat($return,attAspis(fread($fp[0],(1024))));
}fclose($fp[0]);
return $return;
}else 
{{return array(false,false);
}}} }
function SecureHeader ( $str ) {
{$str = Aspis_trim($str);
$str = Aspis_str_replace(array("\r",false),array("",false),$str);
$str = Aspis_str_replace(array("\n",false),array("",false),$str);
return $str;
} }
function Sign ( $cert_filename,$key_filename,$key_pass ) {
{$this->sign_cert_file = $cert_filename;
$this->sign_key_file = $key_filename;
$this->sign_key_pass = $key_pass;
} }
};
?>
<?php 