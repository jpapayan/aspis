<?php require_once('AspisMain.php'); ?><?php
class WP_Http{function WP_Http (  ) {
{$this->__construct();
} }
function __construct (  ) {
{WP_Http::_getTransport();
WP_Http::_postTransport();
} }
function &_getTransport ( $args = array(array(),false) ) {
{static $working_transport,$blocking_transport,$nonblocking_transport;
if ( is_null(deAspisRC($working_transport)))
 {if ( (true === deAspis(WP_Http_ExtHttp::test($args))))
 {arrayAssign($working_transport[0],deAspis(registerTaint(array('exthttp',false))),addTaint(array(new WP_Http_ExtHttp(),false)));
$blocking_transport[0][] = &addTaintR($working_transport[0][('exthttp')]);
}else 
{if ( (true === deAspis(WP_Http_Curl::test($args))))
 {arrayAssign($working_transport[0],deAspis(registerTaint(array('curl',false))),addTaint(array(new WP_Http_Curl(),false)));
$blocking_transport[0][] = &addTaintR($working_transport[0][('curl')]);
}else 
{if ( (true === deAspis(WP_Http_Streams::test($args))))
 {arrayAssign($working_transport[0],deAspis(registerTaint(array('streams',false))),addTaint(array(new WP_Http_Streams(),false)));
$blocking_transport[0][] = &addTaintR($working_transport[0][('streams')]);
}else 
{if ( (true === deAspis(WP_Http_Fopen::test($args))))
 {arrayAssign($working_transport[0],deAspis(registerTaint(array('fopen',false))),addTaint(array(new WP_Http_Fopen(),false)));
$blocking_transport[0][] = &addTaintR($working_transport[0][('fopen')]);
}else 
{if ( (true === deAspis(WP_Http_Fsockopen::test($args))))
 {arrayAssign($working_transport[0],deAspis(registerTaint(array('fsockopen',false))),addTaint(array(new WP_Http_Fsockopen(),false)));
$blocking_transport[0][] = &addTaintR($working_transport[0][('fsockopen')]);
}}}}}foreach ( (array(array('curl',false),array('streams',false),array('fopen',false),array('fsockopen',false),array('exthttp',false))) as $transport  )
{if ( ((isset($working_transport[0][$transport[0]]) && Aspis_isset( $working_transport [0][$transport[0]]))))
 $nonblocking_transport[0][] = &addTaintR($working_transport[0][$transport[0]]);
}}do_action(array('http_transport_get_debug',false),$working_transport,$blocking_transport,$nonblocking_transport);
if ( (((isset($args[0][('blocking')]) && Aspis_isset( $args [0][('blocking')]))) && (denot_boolean($args[0]['blocking']))))
 return $nonblocking_transport;
else 
{return $blocking_transport;
}} }
function &_postTransport ( $args = array(array(),false) ) {
{static $working_transport,$blocking_transport,$nonblocking_transport;
if ( is_null(deAspisRC($working_transport)))
 {if ( (true === deAspis(WP_Http_ExtHttp::test($args))))
 {arrayAssign($working_transport[0],deAspis(registerTaint(array('exthttp',false))),addTaint(array(new WP_Http_ExtHttp(),false)));
$blocking_transport[0][] = &addTaintR($working_transport[0][('exthttp')]);
}else 
{if ( (true === deAspis(WP_Http_Curl::test($args))))
 {arrayAssign($working_transport[0],deAspis(registerTaint(array('curl',false))),addTaint(array(new WP_Http_Curl(),false)));
$blocking_transport[0][] = &addTaintR($working_transport[0][('curl')]);
}else 
{if ( (true === deAspis(WP_Http_Streams::test($args))))
 {arrayAssign($working_transport[0],deAspis(registerTaint(array('streams',false))),addTaint(array(new WP_Http_Streams(),false)));
$blocking_transport[0][] = &addTaintR($working_transport[0][('streams')]);
}else 
{if ( (true === deAspis(WP_Http_Fsockopen::test($args))))
 {arrayAssign($working_transport[0],deAspis(registerTaint(array('fsockopen',false))),addTaint(array(new WP_Http_Fsockopen(),false)));
$blocking_transport[0][] = &addTaintR($working_transport[0][('fsockopen')]);
}}}}foreach ( (array(array('curl',false),array('streams',false),array('fsockopen',false),array('exthttp',false))) as $transport  )
{if ( ((isset($working_transport[0][$transport[0]]) && Aspis_isset( $working_transport [0][$transport[0]]))))
 $nonblocking_transport[0][] = &addTaintR($working_transport[0][$transport[0]]);
}}do_action(array('http_transport_post_debug',false),$working_transport,$blocking_transport,$nonblocking_transport);
if ( (((isset($args[0][('blocking')]) && Aspis_isset( $args [0][('blocking')]))) && (denot_boolean($args[0]['blocking']))))
 return $nonblocking_transport;
else 
{return $blocking_transport;
}} }
function request ( $url,$args = array(array(),false) ) {
{global $wp_version;
$defaults = array(array('method' => array('GET',false,false),deregisterTaint(array('timeout',false)) => addTaint(apply_filters(array('http_request_timeout',false),array(5,false))),deregisterTaint(array('redirection',false)) => addTaint(apply_filters(array('http_request_redirection_count',false),array(5,false))),deregisterTaint(array('httpversion',false)) => addTaint(apply_filters(array('http_request_version',false),array('1.0',false))),deregisterTaint(array('user-agent',false)) => addTaint(apply_filters(array('http_headers_useragent',false),concat(concat2(concat1('WordPress/',$wp_version),'; '),get_bloginfo(array('url',false))))),'blocking' => array(true,false,false),'headers' => array(array(),false,false),'cookies' => array(array(),false,false),'body' => array(null,false,false),'compress' => array(false,false,false),'decompress' => array(true,false,false),'sslverify' => array(true,false,false)),false);
$r = wp_parse_args($args,$defaults);
$r = apply_filters(array('http_request_args',false),$r,$url);
$pre = apply_filters(array('pre_http_request',false),array(false,false),$r,$url);
if ( (false !== $pre[0]))
 return $pre;
$arrURL = Aspis_parse_url($url);
if ( deAspis($this->block_request($url)))
 return array(new WP_Error(array('http_request_failed',false),__(array('User has blocked requests through HTTP.',false))),false);
arrayAssign($r[0],deAspis(registerTaint(array('ssl',false))),addTaint(array((deAspis($arrURL[0]['scheme']) == ('https')) || (deAspis($arrURL[0]['scheme']) == ('ssl')),false)));
$homeURL = Aspis_parse_url(get_bloginfo(array('url',false)));
arrayAssign($r[0],deAspis(registerTaint(array('local',false))),addTaint(array((deAspis($homeURL[0]['host']) == deAspis($arrURL[0]['host'])) || (('localhost') == deAspis($arrURL[0]['host'])),false)));
unset($homeURL);
if ( is_null(deAspisRC($r[0]['headers'])))
 arrayAssign($r[0],deAspis(registerTaint(array('headers',false))),addTaint(array(array(),false)));
if ( (!(is_array(deAspis($r[0]['headers'])))))
 {$processedHeaders = WP_Http::processHeaders($r[0]['headers']);
arrayAssign($r[0],deAspis(registerTaint(array('headers',false))),addTaint($processedHeaders[0]['headers']));
}if ( ((isset($r[0][('headers')][0][('User-Agent')]) && Aspis_isset( $r [0][('headers')] [0][('User-Agent')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('user-agent',false))),addTaint($r[0][('headers')][0]['User-Agent']));
unset($r[0][('headers')][0][('User-Agent')]);
}if ( ((isset($r[0][('headers')][0][('user-agent')]) && Aspis_isset( $r [0][('headers')] [0][('user-agent')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('user-agent',false))),addTaint($r[0][('headers')][0]['user-agent']));
unset($r[0][('headers')][0][('user-agent')]);
}WP_Http::buildCookieHeader($r);
if ( deAspis(WP_Http_Encoding::is_available()))
 arrayAssign($r[0][('headers')][0],deAspis(registerTaint(array('Accept-Encoding',false))),addTaint(WP_Http_Encoding::accept_encoding()));
if ( ((empty($r[0][('body')]) || Aspis_empty( $r [0][('body')]))))
 {if ( (((deAspis($r[0]['method']) == ('POST')) || (deAspis($r[0]['method']) == ('PUT'))) && (!((isset($r[0][('headers')][0][('Content-Length')]) && Aspis_isset( $r [0][('headers')] [0][('Content-Length')]))))))
 arrayAssign($r[0][('headers')][0],deAspis(registerTaint(array('Content-Length',false))),addTaint(array(0,false)));
$transports = WP_Http::_getTransport($r);
}else 
{{if ( (is_array(deAspis($r[0]['body'])) || is_object(deAspis($r[0]['body']))))
 {if ( (!(version_compare(deAspisRC(array(phpversion(),false)),'5.1.2','>='))))
 arrayAssign($r[0],deAspis(registerTaint(array('body',false))),addTaint(_http_build_query($r[0]['body'],array(null,false),array('&',false))));
else 
{arrayAssign($r[0],deAspis(registerTaint(array('body',false))),addTaint(array(http_build_query(deAspisRC($r[0]['body']),null,'&'),false)));
}arrayAssign($r[0][('headers')][0],deAspis(registerTaint(array('Content-Type',false))),addTaint(concat1('application/x-www-form-urlencoded; charset=',get_option(array('blog_charset',false)))));
arrayAssign($r[0][('headers')][0],deAspis(registerTaint(array('Content-Length',false))),addTaint(attAspis(strlen(deAspis($r[0]['body'])))));
}if ( ((!((isset($r[0][('headers')][0][('Content-Length')]) && Aspis_isset( $r [0][('headers')] [0][('Content-Length')])))) && (!((isset($r[0][('headers')][0][('content-length')]) && Aspis_isset( $r [0][('headers')] [0][('content-length')]))))))
 arrayAssign($r[0][('headers')][0],deAspis(registerTaint(array('Content-Length',false))),addTaint(attAspis(strlen(deAspis($r[0]['body'])))));
$transports = WP_Http::_postTransport($r);
}}do_action(array('http_api_debug',false),$transports,array('transports_list',false));
$response = array(array('headers' => array(array(),false,false),'body' => array('',false,false),'response' => array(array('code' => array(false,false,false),'message' => array(false,false,false)),false,false),'cookies' => array(array(),false,false)),false);
foreach ( deAspis(array_cast($transports)) as $transport  )
{$response = $transport[0]->request($url,$r);
do_action(array('http_api_debug',false),$response,array('response',false),attAspis(get_class(deAspisRC($transport))));
if ( (denot_boolean(is_wp_error($response))))
 return apply_filters(array('http_response',false),$response,$r,$url);
}return $response;
} }
function post ( $url,$args = array(array(),false) ) {
{$defaults = array(array('method' => array('POST',false,false)),false);
$r = wp_parse_args($args,$defaults);
return $this->request($url,$r);
} }
function get ( $url,$args = array(array(),false) ) {
{$defaults = array(array('method' => array('GET',false,false)),false);
$r = wp_parse_args($args,$defaults);
return $this->request($url,$r);
} }
function head ( $url,$args = array(array(),false) ) {
{$defaults = array(array('method' => array('HEAD',false,false)),false);
$r = wp_parse_args($args,$defaults);
return $this->request($url,$r);
} }
function processResponse ( $strResponse ) {
{list($theHeaders,$theBody) = deAspisList(Aspis_explode(array("\r\n\r\n",false),$strResponse,array(2,false)),array());
return array(array(deregisterTaint(array('headers',false)) => addTaint($theHeaders),deregisterTaint(array('body',false)) => addTaint($theBody)),false);
} }
function processHeaders ( $headers ) {
{if ( is_string(deAspisRC($headers)))
 {$headers = Aspis_str_replace(array("\r\n",false),array("\n",false),$headers);
$headers = Aspis_preg_replace(array('/\n[ \t]/',false),array(' ',false),$headers);
$headers = Aspis_explode(array("\n",false),$headers);
}$response = array(array('code' => array(0,false,false),'message' => array('',false,false)),false);
$cookies = array(array(),false);
$newheaders = array(array(),false);
foreach ( $headers[0] as $tempheader  )
{if ( ((empty($tempheader) || Aspis_empty( $tempheader))))
 continue ;
if ( (false === strpos($tempheader[0],':')))
 {list(,$iResponseCode,$strResponseMsg) = deAspisList(Aspis_explode(array(' ',false),$tempheader,array(3,false)),array());
arrayAssign($response[0],deAspis(registerTaint(array('code',false))),addTaint($iResponseCode));
arrayAssign($response[0],deAspis(registerTaint(array('message',false))),addTaint($strResponseMsg));
continue ;
}list($key,$value) = deAspisList(Aspis_explode(array(':',false),$tempheader,array(2,false)),array());
if ( (!((empty($value) || Aspis_empty( $value)))))
 {$key = Aspis_strtolower($key);
if ( ((isset($newheaders[0][$key[0]]) && Aspis_isset( $newheaders [0][$key[0]]))))
 {arrayAssign($newheaders[0],deAspis(registerTaint($key)),addTaint(array(array(attachAspis($newheaders,$key[0]),Aspis_trim($value)),false)));
}else 
{{arrayAssign($newheaders[0],deAspis(registerTaint($key)),addTaint(Aspis_trim($value)));
}}if ( (('set-cookie') == deAspis(Aspis_strtolower($key))))
 arrayAssignAdd($cookies[0][],addTaint(array(new WP_Http_Cookie($value),false)));
}}return array(array(deregisterTaint(array('response',false)) => addTaint($response),deregisterTaint(array('headers',false)) => addTaint($newheaders),deregisterTaint(array('cookies',false)) => addTaint($cookies)),false);
} }
function buildCookieHeader ( &$r ) {
{if ( (!((empty($r[0][('cookies')]) || Aspis_empty( $r [0][('cookies')])))))
 {$cookies_header = array('',false);
foreach ( deAspis(array_cast($r[0]['cookies'])) as $cookie  )
{$cookies_header = concat($cookies_header,concat2($cookie[0]->getHeaderValue(),'; '));
}$cookies_header = Aspis_substr($cookies_header,array(0,false),negate(array(2,false)));
arrayAssign($r[0][('headers')][0],deAspis(registerTaint(array('cookie',false))),addTaint($cookies_header));
}} }
function chunkTransferDecode ( $body ) {
{$body = Aspis_str_replace(array(array(array("\r\n",false),array("\r",false)),false),array("\n",false),$body);
if ( (denot_boolean(Aspis_preg_match(array('/^[0-9a-f]+(\s|\n)+/mi',false),Aspis_trim($body)))))
 return $body;
$parsedBody = array('',false);
while ( true )
{$hasChunk = bool_cast(Aspis_preg_match(array('/^([0-9a-f]+)(\s|\n)+/mi',false),$body,$match));
if ( $hasChunk[0])
 {if ( ((empty($match[0][(1)]) || Aspis_empty( $match [0][(1)]))))
 return $body;
$length = Aspis_hexdec(attachAspis($match,(1)));
$chunkLength = attAspis(strlen(deAspis(attachAspis($match,(0)))));
$strBody = Aspis_substr($body,$chunkLength,$length);
$parsedBody = concat($parsedBody,$strBody);
$body = Aspis_ltrim(Aspis_str_replace(array(array(attachAspis($match,(0)),$strBody),false),array('',false),$body),array("\n",false));
if ( (("0") == deAspis(Aspis_trim($body))))
 return $parsedBody;
}else 
{{return $body;
}}}} }
function block_request ( $uri ) {
{if ( ((!(defined(('WP_HTTP_BLOCK_EXTERNAL')))) || (defined(('WP_HTTP_BLOCK_EXTERNAL')) && (WP_HTTP_BLOCK_EXTERNAL == false))))
 return array(false,false);
$check = @Aspis_parse_url($uri);
if ( ($check[0] === false))
 return array(false,false);
$home = Aspis_parse_url(get_option(array('siteurl',false)));
if ( ((deAspis($check[0]['host']) == ('localhost')) || (deAspis($check[0]['host']) == deAspis($home[0]['host']))))
 return apply_filters(array('block_local_requests',false),array(false,false));
if ( (!(defined(('WP_ACCESSIBLE_HOSTS')))))
 return array(true,false);
static $accessible_hosts;
if ( (null == $accessible_hosts[0]))
 $accessible_hosts = Aspis_preg_split(array('|,\s*|',false),array(WP_ACCESSIBLE_HOSTS,false));
return not_boolean(Aspis_in_array($check[0]['host'],$accessible_hosts));
} }
}class WP_Http_Fsockopen{function request ( $url,$args = array(array(),false) ) {
{$defaults = array(array('method' => array('GET',false,false),'timeout' => array(5,false,false),'redirection' => array(5,false,false),'httpversion' => array('1.0',false,false),'blocking' => array(true,false,false),'headers' => array(array(),false,false),'body' => array(null,false,false),'cookies' => array(array(),false,false)),false);
$r = wp_parse_args($args,$defaults);
if ( ((isset($r[0][('headers')][0][('User-Agent')]) && Aspis_isset( $r [0][('headers')] [0][('User-Agent')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('user-agent',false))),addTaint($r[0][('headers')][0]['User-Agent']));
unset($r[0][('headers')][0][('User-Agent')]);
}else 
{if ( ((isset($r[0][('headers')][0][('user-agent')]) && Aspis_isset( $r [0][('headers')] [0][('user-agent')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('user-agent',false))),addTaint($r[0][('headers')][0]['user-agent']));
unset($r[0][('headers')][0][('user-agent')]);
}}WP_Http::buildCookieHeader($r);
$iError = array(null,false);
$strError = array(null,false);
$arrURL = Aspis_parse_url($url);
$fsockopen_host = $arrURL[0]['host'];
$secure_transport = array(false,false);
if ( (!((isset($arrURL[0][('port')]) && Aspis_isset( $arrURL [0][('port')])))))
 {if ( (((deAspis($arrURL[0]['scheme']) == ('ssl')) || (deAspis($arrURL[0]['scheme']) == ('https'))) && (extension_loaded('openssl'))))
 {$fsockopen_host = concat1("ssl://",$fsockopen_host);
arrayAssign($arrURL[0],deAspis(registerTaint(array('port',false))),addTaint(array(443,false)));
$secure_transport = array(true,false);
}else 
{{arrayAssign($arrURL[0],deAspis(registerTaint(array('port',false))),addTaint(array(80,false)));
}}}if ( (('localhost') == deAspis(Aspis_strtolower($fsockopen_host))))
 $fsockopen_host = array('127.0.0.1',false);
if ( (true === $secure_transport[0]))
 $error_reporting = array(error_reporting(0),false);
$startDelay = attAspis(time());
$proxy = array(new WP_HTTP_Proxy(),false);
if ( (!(WP_DEBUG)))
 {if ( (deAspis($proxy[0]->is_enabled()) && deAspis($proxy[0]->send_through_proxy($url))))
 $handle = @AspisInternalFunctionCall("fsockopen",deAspis($proxy[0]->host()),deAspis($proxy[0]->port()),AspisPushRefParam($iError),AspisPushRefParam($strError),deAspis($r[0]['timeout']),array(2,3));
else 
{$handle = @AspisInternalFunctionCall("fsockopen",$fsockopen_host[0],deAspis($arrURL[0]['port']),AspisPushRefParam($iError),AspisPushRefParam($strError),deAspis($r[0]['timeout']),array(2,3));
}}else 
{{if ( (deAspis($proxy[0]->is_enabled()) && deAspis($proxy[0]->send_through_proxy($url))))
 $handle = AspisInternalFunctionCall("fsockopen",deAspis($proxy[0]->host()),deAspis($proxy[0]->port()),AspisPushRefParam($iError),AspisPushRefParam($strError),deAspis($r[0]['timeout']),array(2,3));
else 
{$handle = AspisInternalFunctionCall("fsockopen",$fsockopen_host[0],deAspis($arrURL[0]['port']),AspisPushRefParam($iError),AspisPushRefParam($strError),deAspis($r[0]['timeout']),array(2,3));
}}}$endDelay = attAspis(time());
$elapseDelay = array(($endDelay[0] - $startDelay[0]) > deAspis($r[0]['timeout']),false);
if ( (true === $elapseDelay[0]))
 add_option(array('disable_fsockopen',false),$endDelay,array(null,false),array(true,false));
if ( (false === $handle[0]))
 return array(new WP_Error(array('http_request_failed',false),concat(concat2($iError,': '),$strError)),false);
$timeout = int_cast(attAspis(floor(deAspis($r[0]['timeout']))));
$utimeout = ($timeout[0] == deAspis($r[0]['timeout'])) ? array(0,false) : array(((1000000) * deAspis($r[0]['timeout'])) % (1000000),false);
stream_set_timeout(deAspisRC($handle),deAspisRC($timeout),deAspisRC($utimeout));
if ( (deAspis($proxy[0]->is_enabled()) && deAspis($proxy[0]->send_through_proxy($url))))
 $requestPath = $url;
else 
{$requestPath = concat($arrURL[0]['path'],(((isset($arrURL[0][('query')]) && Aspis_isset( $arrURL [0][('query')]))) ? concat1('?',$arrURL[0]['query']) : array('',false)));
}if ( ((empty($requestPath) || Aspis_empty( $requestPath))))
 $requestPath = concat2($requestPath,'/');
$strHeaders = concat2(concat(concat2(concat(concat2(Aspis_strtoupper($r[0]['method']),' '),$requestPath),' HTTP/'),$r[0]['httpversion']),"\r\n");
if ( (deAspis($proxy[0]->is_enabled()) && deAspis($proxy[0]->send_through_proxy($url))))
 $strHeaders = concat($strHeaders,concat2(concat(concat2(concat1('Host: ',$arrURL[0]['host']),':'),$arrURL[0]['port']),"\r\n"));
else 
{$strHeaders = concat($strHeaders,concat2(concat1('Host: ',$arrURL[0]['host']),"\r\n"));
}if ( ((isset($r[0][('user-agent')]) && Aspis_isset( $r [0][('user-agent')]))))
 $strHeaders = concat($strHeaders,concat2(concat1('User-agent: ',$r[0]['user-agent']),"\r\n"));
if ( is_array(deAspis($r[0]['headers'])))
 {foreach ( deAspis(array_cast($r[0]['headers'])) as $header =>$headerValue )
{restoreTaint($header,$headerValue);
$strHeaders = concat($strHeaders,concat2(concat(concat2($header,': '),$headerValue),"\r\n"));
}}else 
{{$strHeaders = concat($strHeaders,$r[0]['headers']);
}}if ( deAspis($proxy[0]->use_authentication()))
 $strHeaders = concat($strHeaders,concat2($proxy[0]->authentication_header(),"\r\n"));
$strHeaders = concat2($strHeaders,"\r\n");
if ( (!(is_null(deAspisRC($r[0]['body'])))))
 $strHeaders = concat($strHeaders,$r[0]['body']);
fwrite($handle[0],$strHeaders[0]);
if ( (denot_boolean($r[0]['blocking'])))
 {fclose($handle[0]);
return array(array('headers' => array(array(),false,false),'body' => array('',false,false),'response' => array(array('code' => array(false,false,false),'message' => array(false,false,false)),false,false),'cookies' => array(array(),false,false)),false);
}$strResponse = array('',false);
while ( (!(feof($handle[0]))) )
$strResponse = concat($strResponse,attAspis(fread($handle[0],(4096))));
fclose($handle[0]);
if ( (true === $secure_transport[0]))
 error_reporting(deAspisRC($error_reporting));
$process = WP_Http::processResponse($strResponse);
$arrHeaders = WP_Http::processHeaders($process[0]['headers']);
if ( ((deAspis(int_cast($arrHeaders[0][('response')][0]['code'])) >= (400)) && (deAspis(int_cast($arrHeaders[0][('response')][0]['code'])) < (500))))
 return array(new WP_Error(array('http_request_failed',false),concat(concat2($arrHeaders[0][('response')][0]['code'],': '),$arrHeaders[0][('response')][0]['message'])),false);
if ( ((isset($arrHeaders[0][('headers')][0][('location')]) && Aspis_isset( $arrHeaders [0][('headers')] [0][('location')]))))
 {if ( (deAspis(postdecr($r[0]['redirection'])) > (0)))
 {return $this->request($arrHeaders[0][('headers')][0]['location'],$r);
}else 
{{return array(new WP_Error(array('http_request_failed',false),__(array('Too many redirects.',false))),false);
}}}if ( (((!((empty($process[0][('body')]) || Aspis_empty( $process [0][('body')])))) && ((isset($arrHeaders[0][('headers')][0][('transfer-encoding')]) && Aspis_isset( $arrHeaders [0][('headers')] [0][('transfer-encoding')])))) && (('chunked') == deAspis($arrHeaders[0][('headers')][0]['transfer-encoding']))))
 arrayAssign($process[0],deAspis(registerTaint(array('body',false))),addTaint(WP_Http::chunkTransferDecode($process[0]['body'])));
if ( ((true === deAspis($r[0]['decompress'])) && (true === deAspis(WP_Http_Encoding::should_decode($arrHeaders[0]['headers'])))))
 arrayAssign($process[0],deAspis(registerTaint(array('body',false))),addTaint(WP_Http_Encoding::decompress($process[0]['body'])));
return array(array(deregisterTaint(array('headers',false)) => addTaint($arrHeaders[0]['headers']),deregisterTaint(array('body',false)) => addTaint($process[0]['body']),deregisterTaint(array('response',false)) => addTaint($arrHeaders[0]['response']),deregisterTaint(array('cookies',false)) => addTaint($arrHeaders[0]['cookies'])),false);
} }
function test ( $args = array(array(),false) ) {
{if ( ((false !== deAspis(($option = get_option(array('disable_fsockopen',false))))) && ((time() - $option[0]) < (43200))))
 return array(false,false);
$is_ssl = array(((isset($args[0][('ssl')]) && Aspis_isset( $args [0][('ssl')]))) && deAspis($args[0]['ssl']),false);
if ( ((denot_boolean($is_ssl)) && function_exists(('fsockopen'))))
 $use = array(true,false);
elseif ( (($is_ssl[0] && (extension_loaded('openssl'))) && function_exists(('fsockopen'))))
 $use = array(true,false);
else 
{$use = array(false,false);
}return apply_filters(array('use_fsockopen_transport',false),$use,$args);
} }
}class WP_Http_Fopen{function request ( $url,$args = array(array(),false) ) {
{$defaults = array(array('method' => array('GET',false,false),'timeout' => array(5,false,false),'redirection' => array(5,false,false),'httpversion' => array('1.0',false,false),'blocking' => array(true,false,false),'headers' => array(array(),false,false),'body' => array(null,false,false),'cookies' => array(array(),false,false)),false);
$r = wp_parse_args($args,$defaults);
$arrURL = Aspis_parse_url($url);
if ( (false === $arrURL[0]))
 return array(new WP_Error(array('http_request_failed',false),Aspis_sprintf(__(array('Malformed URL: %s',false)),$url)),false);
if ( ((('http') != deAspis($arrURL[0]['scheme'])) && (('https') != deAspis($arrURL[0]['scheme']))))
 $url = Aspis_str_replace($arrURL[0]['scheme'],array('http',false),$url);
if ( (!(WP_DEBUG)))
 $handle = @attAspis(fopen($url[0],('r')));
else 
{$handle = attAspis(fopen($url[0],('r')));
}if ( (denot_boolean($handle)))
 return array(new WP_Error(array('http_request_failed',false),Aspis_sprintf(__(array('Could not open handle for fopen() to %s',false)),$url)),false);
$timeout = int_cast(attAspis(floor(deAspis($r[0]['timeout']))));
$utimeout = ($timeout[0] == deAspis($r[0]['timeout'])) ? array(0,false) : array(((1000000) * deAspis($r[0]['timeout'])) % (1000000),false);
stream_set_timeout(deAspisRC($handle),deAspisRC($timeout),deAspisRC($utimeout));
if ( (denot_boolean($r[0]['blocking'])))
 {fclose($handle[0]);
return array(array('headers' => array(array(),false,false),'body' => array('',false,false),'response' => array(array('code' => array(false,false,false),'message' => array(false,false,false)),false,false),'cookies' => array(array(),false,false)),false);
}$strResponse = array('',false);
while ( (!(feof($handle[0]))) )
$strResponse = concat($strResponse,attAspis(fread($handle[0],(4096))));
if ( function_exists(('stream_get_meta_data')))
 {$meta = attAspisRC(stream_get_meta_data($handle[0]));
$theHeaders = $meta[0]['wrapper_data'];
if ( ((isset($meta[0][('wrapper_data')][0][('headers')]) && Aspis_isset( $meta [0][('wrapper_data')] [0][('headers')]))))
 $theHeaders = $meta[0][('wrapper_data')][0]['headers'];
}else 
{{$theHeaders = $http_response_header;
}}fclose($handle[0]);
$processedHeaders = WP_Http::processHeaders($theHeaders);
if ( (((!((empty($strResponse) || Aspis_empty( $strResponse)))) && ((isset($processedHeaders[0][('headers')][0][('transfer-encoding')]) && Aspis_isset( $processedHeaders [0][('headers')] [0][('transfer-encoding')])))) && (('chunked') == deAspis($processedHeaders[0][('headers')][0]['transfer-encoding']))))
 $strResponse = WP_Http::chunkTransferDecode($strResponse);
if ( ((true === deAspis($r[0]['decompress'])) && (true === deAspis(WP_Http_Encoding::should_decode($processedHeaders[0]['headers'])))))
 $strResponse = WP_Http_Encoding::decompress($strResponse);
return array(array(deregisterTaint(array('headers',false)) => addTaint($processedHeaders[0]['headers']),deregisterTaint(array('body',false)) => addTaint($strResponse),deregisterTaint(array('response',false)) => addTaint($processedHeaders[0]['response']),deregisterTaint(array('cookies',false)) => addTaint($processedHeaders[0]['cookies'])),false);
} }
function test ( $args = array(array(),false) ) {
{if ( ((!(function_exists(('fopen')))) || (function_exists(('ini_get')) && (true != (ini_get('allow_url_fopen'))))))
 return array(false,false);
$use = array(true,false);
$is_ssl = array(((isset($args[0][('ssl')]) && Aspis_isset( $args [0][('ssl')]))) && deAspis($args[0]['ssl']),false);
if ( $is_ssl[0])
 {$is_local = array(((isset($args[0][('local')]) && Aspis_isset( $args [0][('local')]))) && deAspis($args[0]['local']),false);
$ssl_verify = array(((isset($args[0][('sslverify')]) && Aspis_isset( $args [0][('sslverify')]))) && deAspis($args[0]['sslverify']),false);
if ( ($is_local[0] && (true != deAspis(apply_filters(array('https_local_ssl_verify',false),array(true,false))))))
 $use = array(true,false);
elseif ( ((denot_boolean($is_local)) && (true != deAspis(apply_filters(array('https_ssl_verify',false),array(true,false))))))
 $use = array(true,false);
elseif ( (denot_boolean($ssl_verify)))
 $use = array(true,false);
else 
{$use = array(false,false);
}}return apply_filters(array('use_fopen_transport',false),$use,$args);
} }
}class WP_Http_Streams{function request ( $url,$args = array(array(),false) ) {
{$defaults = array(array('method' => array('GET',false,false),'timeout' => array(5,false,false),'redirection' => array(5,false,false),'httpversion' => array('1.0',false,false),'blocking' => array(true,false,false),'headers' => array(array(),false,false),'body' => array(null,false,false),'cookies' => array(array(),false,false)),false);
$r = wp_parse_args($args,$defaults);
if ( ((isset($r[0][('headers')][0][('User-Agent')]) && Aspis_isset( $r [0][('headers')] [0][('User-Agent')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('user-agent',false))),addTaint($r[0][('headers')][0]['User-Agent']));
unset($r[0][('headers')][0][('User-Agent')]);
}else 
{if ( ((isset($r[0][('headers')][0][('user-agent')]) && Aspis_isset( $r [0][('headers')] [0][('user-agent')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('user-agent',false))),addTaint($r[0][('headers')][0]['user-agent']));
unset($r[0][('headers')][0][('user-agent')]);
}}WP_Http::buildCookieHeader($r);
$arrURL = Aspis_parse_url($url);
if ( (false === $arrURL[0]))
 return array(new WP_Error(array('http_request_failed',false),Aspis_sprintf(__(array('Malformed URL: %s',false)),$url)),false);
if ( ((('http') != deAspis($arrURL[0]['scheme'])) && (('https') != deAspis($arrURL[0]['scheme']))))
 $url = Aspis_preg_replace(concat2(concat1('|^',Aspis_preg_quote($arrURL[0]['scheme'],array('|',false))),'|'),array('http',false),$url);
$strHeaders = array('',false);
if ( is_array(deAspis($r[0]['headers'])))
 foreach ( deAspis($r[0]['headers']) as $name =>$value )
{restoreTaint($name,$value);
$strHeaders = concat($strHeaders,concat2(concat(concat2($name,": "),$value),"\r\n"));
}else 
{if ( is_string(deAspisRC($r[0]['headers'])))
 $strHeaders = $r[0]['headers'];
}$is_local = array(((isset($args[0][('local')]) && Aspis_isset( $args [0][('local')]))) && deAspis($args[0]['local']),false);
$ssl_verify = array(((isset($args[0][('sslverify')]) && Aspis_isset( $args [0][('sslverify')]))) && deAspis($args[0]['sslverify']),false);
if ( $is_local[0])
 $ssl_verify = apply_filters(array('https_local_ssl_verify',false),$ssl_verify);
elseif ( (denot_boolean($is_local)))
 $ssl_verify = apply_filters(array('https_ssl_verify',false),$ssl_verify);
$arrContext = array(array('http' => array(array(deregisterTaint(array('method',false)) => addTaint(Aspis_strtoupper($r[0]['method'])),deregisterTaint(array('user_agent',false)) => addTaint($r[0]['user-agent']),deregisterTaint(array('max_redirects',false)) => addTaint($r[0]['redirection']),deregisterTaint(array('protocol_version',false)) => addTaint(float_cast($r[0]['httpversion'])),deregisterTaint(array('header',false)) => addTaint($strHeaders),deregisterTaint(array('timeout',false)) => addTaint($r[0]['timeout']),'ssl' => array(array(deregisterTaint(array('verify_peer',false)) => addTaint($ssl_verify),deregisterTaint(array('verify_host',false)) => addTaint($ssl_verify)),false,false)),false,false)),false);
$proxy = array(new WP_HTTP_Proxy(),false);
if ( (deAspis($proxy[0]->is_enabled()) && deAspis($proxy[0]->send_through_proxy($url))))
 {arrayAssign($arrContext[0][('http')][0],deAspis(registerTaint(array('proxy',false))),addTaint(concat(concat2(concat1('tcp://',$proxy[0]->host()),':'),$proxy[0]->port())));
arrayAssign($arrContext[0][('http')][0],deAspis(registerTaint(array('request_fulluri',false))),addTaint(array(true,false)));
if ( deAspis($proxy[0]->use_authentication()))
 arrayAssign($arrContext[0][('http')][0],deAspis(registerTaint(array('header',false))),addTaint(concat($arrContext[0][('http')][0]['header'],concat2($proxy[0]->authentication_header(),"\r\n"))));
}if ( ((!(is_null(deAspisRC($r[0]['body'])))) && (!((empty($r[0][('body')]) || Aspis_empty( $r [0][('body')]))))))
 arrayAssign($arrContext[0][('http')][0],deAspis(registerTaint(array('content',false))),addTaint($r[0]['body']));
$context = array(stream_context_create(deAspisRC($arrContext)),false);
if ( (!(WP_DEBUG)))
 $handle = @attAspis(fopen($url[0],('r'),false,$context[0]));
else 
{$handle = attAspis(fopen($url[0],('r'),false,$context[0]));
}if ( (denot_boolean($handle)))
 return array(new WP_Error(array('http_request_failed',false),Aspis_sprintf(__(array('Could not open handle for fopen() to %s',false)),$url)),false);
$timeout = int_cast(attAspis(floor(deAspis($r[0]['timeout']))));
$utimeout = ($timeout[0] == deAspis($r[0]['timeout'])) ? array(0,false) : array(((1000000) * deAspis($r[0]['timeout'])) % (1000000),false);
stream_set_timeout(deAspisRC($handle),deAspisRC($timeout),deAspisRC($utimeout));
if ( (denot_boolean($r[0]['blocking'])))
 {stream_set_blocking(deAspisRC($handle),0);
fclose($handle[0]);
return array(array('headers' => array(array(),false,false),'body' => array('',false,false),'response' => array(array('code' => array(false,false,false),'message' => array(false,false,false)),false,false),'cookies' => array(array(),false,false)),false);
}$strResponse = array(stream_get_contents(deAspisRC($handle)),false);
$meta = attAspisRC(stream_get_meta_data($handle[0]));
fclose($handle[0]);
$processedHeaders = array(array(),false);
if ( ((isset($meta[0][('wrapper_data')][0][('headers')]) && Aspis_isset( $meta [0][('wrapper_data')] [0][('headers')]))))
 $processedHeaders = WP_Http::processHeaders($meta[0][('wrapper_data')][0]['headers']);
else 
{$processedHeaders = WP_Http::processHeaders($meta[0]['wrapper_data']);
}if ( (((!((empty($strResponse) || Aspis_empty( $strResponse)))) && ((isset($processedHeaders[0][('headers')][0][('transfer-encoding')]) && Aspis_isset( $processedHeaders [0][('headers')] [0][('transfer-encoding')])))) && (('chunked') == deAspis($processedHeaders[0][('headers')][0]['transfer-encoding']))))
 $strResponse = WP_Http::chunkTransferDecode($strResponse);
if ( ((true === deAspis($r[0]['decompress'])) && (true === deAspis(WP_Http_Encoding::should_decode($processedHeaders[0]['headers'])))))
 $strResponse = WP_Http_Encoding::decompress($strResponse);
return array(array(deregisterTaint(array('headers',false)) => addTaint($processedHeaders[0]['headers']),deregisterTaint(array('body',false)) => addTaint($strResponse),deregisterTaint(array('response',false)) => addTaint($processedHeaders[0]['response']),deregisterTaint(array('cookies',false)) => addTaint($processedHeaders[0]['cookies'])),false);
} }
function test ( $args = array(array(),false) ) {
{if ( ((!(function_exists(('fopen')))) || (function_exists(('ini_get')) && (true != (ini_get('allow_url_fopen'))))))
 return array(false,false);
if ( (version_compare(PHP_VERSION,'5.0','<')))
 return array(false,false);
$is_ssl = array(((isset($args[0][('ssl')]) && Aspis_isset( $args [0][('ssl')]))) && deAspis($args[0]['ssl']),false);
if ( ($is_ssl[0] && (version_compare(PHP_VERSION,'5.1.0','<'))))
 {$proxy = array(new WP_HTTP_Proxy(),false);
if ( deAspis($proxy[0]->is_enabled()))
 return array(false,false);
}return apply_filters(array('use_streams_transport',false),array(true,false),$args);
} }
}class WP_Http_ExtHTTP{function request ( $url,$args = array(array(),false) ) {
{$defaults = array(array('method' => array('GET',false,false),'timeout' => array(5,false,false),'redirection' => array(5,false,false),'httpversion' => array('1.0',false,false),'blocking' => array(true,false,false),'headers' => array(array(),false,false),'body' => array(null,false,false),'cookies' => array(array(),false,false)),false);
$r = wp_parse_args($args,$defaults);
if ( ((isset($r[0][('headers')][0][('User-Agent')]) && Aspis_isset( $r [0][('headers')] [0][('User-Agent')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('user-agent',false))),addTaint($r[0][('headers')][0]['User-Agent']));
unset($r[0][('headers')][0][('User-Agent')]);
}else 
{if ( ((isset($r[0][('headers')][0][('user-agent')]) && Aspis_isset( $r [0][('headers')] [0][('user-agent')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('user-agent',false))),addTaint($r[0][('headers')][0]['user-agent']));
unset($r[0][('headers')][0][('user-agent')]);
}}WP_Http::buildCookieHeader($r);
switch ( deAspis($r[0]['method']) ) {
case ('POST'):arrayAssign($r[0],deAspis(registerTaint(array('method',false))),addTaint(array(HTTP_METH_POST,false)));
break ;
case ('HEAD'):arrayAssign($r[0],deAspis(registerTaint(array('method',false))),addTaint(array(HTTP_METH_HEAD,false)));
break ;
case ('PUT'):arrayAssign($r[0],deAspis(registerTaint(array('method',false))),addTaint(array(HTTP_METH_PUT,false)));
break ;
case ('GET'):default :arrayAssign($r[0],deAspis(registerTaint(array('method',false))),addTaint(array(HTTP_METH_GET,false)));
 }
$arrURL = Aspis_parse_url($url);
if ( ((('http') != deAspis($arrURL[0]['scheme'])) || (('https') != deAspis($arrURL[0]['scheme']))))
 $url = Aspis_preg_replace(concat2(concat1('|^',Aspis_preg_quote($arrURL[0]['scheme'],array('|',false))),'|'),array('http',false),$url);
$is_local = array(((isset($args[0][('local')]) && Aspis_isset( $args [0][('local')]))) && deAspis($args[0]['local']),false);
$ssl_verify = array(((isset($args[0][('sslverify')]) && Aspis_isset( $args [0][('sslverify')]))) && deAspis($args[0]['sslverify']),false);
if ( $is_local[0])
 $ssl_verify = apply_filters(array('https_local_ssl_verify',false),$ssl_verify);
elseif ( (denot_boolean($is_local)))
 $ssl_verify = apply_filters(array('https_ssl_verify',false),$ssl_verify);
arrayAssign($r[0],deAspis(registerTaint(array('timeout',false))),addTaint(int_cast(attAspis(ceil(deAspis($r[0]['timeout']))))));
$options = array(array(deregisterTaint(array('timeout',false)) => addTaint($r[0]['timeout']),deregisterTaint(array('connecttimeout',false)) => addTaint($r[0]['timeout']),deregisterTaint(array('redirect',false)) => addTaint($r[0]['redirection']),deregisterTaint(array('useragent',false)) => addTaint($r[0]['user-agent']),deregisterTaint(array('headers',false)) => addTaint($r[0]['headers']),'ssl' => array(array(deregisterTaint(array('verifypeer',false)) => addTaint($ssl_verify),deregisterTaint(array('verifyhost',false)) => addTaint($ssl_verify)),false,false)),false);
$proxy = array(new WP_HTTP_Proxy(),false);
if ( (deAspis($proxy[0]->is_enabled()) && deAspis($proxy[0]->send_through_proxy($url))))
 {arrayAssign($options[0],deAspis(registerTaint(array('proxyhost',false))),addTaint($proxy[0]->host()));
arrayAssign($options[0],deAspis(registerTaint(array('proxyport',false))),addTaint($proxy[0]->port()));
arrayAssign($options[0],deAspis(registerTaint(array('proxytype',false))),addTaint(array(HTTP_PROXY_HTTP,false)));
if ( deAspis($proxy[0]->use_authentication()))
 {arrayAssign($options[0],deAspis(registerTaint(array('proxyauth',false))),addTaint($proxy[0]->authentication()));
arrayAssign($options[0],deAspis(registerTaint(array('proxyauthtype',false))),addTaint(array(HTTP_AUTH_BASIC,false)));
}}if ( (!(WP_DEBUG)))
 $strResponse = @array(http_request(deAspisRC($r[0]['method']),deAspisRC($url),deAspisRC($r[0]['body']),deAspisRC($options),deAspisRC($info)),false);
else 
{$strResponse = array(http_request(deAspisRC($r[0]['method']),deAspisRC($url),deAspisRC($r[0]['body']),deAspisRC($options),deAspisRC($info)),false);
}if ( ((false === $strResponse[0]) || (!((empty($info[0][('error')]) || Aspis_empty( $info [0][('error')]))))))
 return array(new WP_Error(array('http_request_failed',false),concat(concat2($info[0]['response_code'],': '),$info[0]['error'])),false);
if ( (denot_boolean($r[0]['blocking'])))
 return array(array('headers' => array(array(),false,false),'body' => array('',false,false),'response' => array(array('code' => array(false,false,false),'message' => array(false,false,false)),false,false),'cookies' => array(array(),false,false)),false);
list($theHeaders,$theBody) = deAspisList(Aspis_explode(array("\r\n\r\n",false),$strResponse,array(2,false)),array());
$theHeaders = WP_Http::processHeaders($theHeaders);
if ( (((!((empty($theBody) || Aspis_empty( $theBody)))) && ((isset($theHeaders[0][('headers')][0][('transfer-encoding')]) && Aspis_isset( $theHeaders [0][('headers')] [0][('transfer-encoding')])))) && (('chunked') == deAspis($theHeaders[0][('headers')][0]['transfer-encoding']))))
 {if ( (!(WP_DEBUG)))
 $theBody = @array(http_chunked_decode(deAspisRC($theBody)),false);
else 
{$theBody = array(http_chunked_decode(deAspisRC($theBody)),false);
}}if ( ((true === deAspis($r[0]['decompress'])) && (true === deAspis(WP_Http_Encoding::should_decode($theHeaders[0]['headers'])))))
 $theBody = array(http_inflate(deAspisRC($theBody)),false);
$theResponse = array(array(),false);
arrayAssign($theResponse[0],deAspis(registerTaint(array('code',false))),addTaint($info[0]['response_code']));
arrayAssign($theResponse[0],deAspis(registerTaint(array('message',false))),addTaint(get_status_header_desc($info[0]['response_code'])));
return array(array(deregisterTaint(array('headers',false)) => addTaint($theHeaders[0]['headers']),deregisterTaint(array('body',false)) => addTaint($theBody),deregisterTaint(array('response',false)) => addTaint($theResponse),deregisterTaint(array('cookies',false)) => addTaint($theHeaders[0]['cookies'])),false);
} }
function test ( $args = array(array(),false) ) {
{return apply_filters(array('use_http_extension_transport',false),attAspis(function_exists(('http_request'))),$args);
} }
}class WP_Http_Curl{function request ( $url,$args = array(array(),false) ) {
{$defaults = array(array('method' => array('GET',false,false),'timeout' => array(5,false,false),'redirection' => array(5,false,false),'httpversion' => array('1.0',false,false),'blocking' => array(true,false,false),'headers' => array(array(),false,false),'body' => array(null,false,false),'cookies' => array(array(),false,false)),false);
$r = wp_parse_args($args,$defaults);
if ( ((isset($r[0][('headers')][0][('User-Agent')]) && Aspis_isset( $r [0][('headers')] [0][('User-Agent')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('user-agent',false))),addTaint($r[0][('headers')][0]['User-Agent']));
unset($r[0][('headers')][0][('User-Agent')]);
}else 
{if ( ((isset($r[0][('headers')][0][('user-agent')]) && Aspis_isset( $r [0][('headers')] [0][('user-agent')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('user-agent',false))),addTaint($r[0][('headers')][0]['user-agent']));
unset($r[0][('headers')][0][('user-agent')]);
}}WP_Http::buildCookieHeader($r);
$handle = array(curl_init(),false);
$proxy = array(new WP_HTTP_Proxy(),false);
if ( (deAspis($proxy[0]->is_enabled()) && deAspis($proxy[0]->send_through_proxy($url))))
 {$isPHP5 = array(version_compare(PHP_VERSION,'5.0.0','>='),false);
if ( $isPHP5[0])
 {curl_setopt(deAspisRC($handle),CURLOPT_PROXYTYPE,CURLPROXY_HTTP);
curl_setopt(deAspisRC($handle),CURLOPT_PROXY,deAspisRC($proxy[0]->host()));
curl_setopt(deAspisRC($handle),CURLOPT_PROXYPORT,deAspisRC($proxy[0]->port()));
}else 
{{curl_setopt(deAspisRC($handle),CURLOPT_PROXY,(deconcat(concat2($proxy[0]->host(),':'),$proxy[0]->port())));
}}if ( deAspis($proxy[0]->use_authentication()))
 {if ( $isPHP5[0])
 curl_setopt(deAspisRC($handle),CURLOPT_PROXYAUTH,CURLAUTH_BASIC);
curl_setopt(deAspisRC($handle),CURLOPT_PROXYUSERPWD,deAspisRC($proxy[0]->authentication()));
}}$is_local = array(((isset($args[0][('local')]) && Aspis_isset( $args [0][('local')]))) && deAspis($args[0]['local']),false);
$ssl_verify = array(((isset($args[0][('sslverify')]) && Aspis_isset( $args [0][('sslverify')]))) && deAspis($args[0]['sslverify']),false);
if ( $is_local[0])
 $ssl_verify = apply_filters(array('https_local_ssl_verify',false),$ssl_verify);
elseif ( (denot_boolean($is_local)))
 $ssl_verify = apply_filters(array('https_ssl_verify',false),$ssl_verify);
$timeout = int_cast(attAspis(ceil(deAspis($r[0]['timeout']))));
curl_setopt(deAspisRC($handle),CURLOPT_CONNECTTIMEOUT,deAspisRC($timeout));
curl_setopt(deAspisRC($handle),CURLOPT_TIMEOUT,deAspisRC($timeout));
curl_setopt(deAspisRC($handle),CURLOPT_URL,deAspisRC($url));
curl_setopt(deAspisRC($handle),CURLOPT_RETURNTRANSFER,true);
curl_setopt(deAspisRC($handle),CURLOPT_SSL_VERIFYHOST,deAspisRC($ssl_verify));
curl_setopt(deAspisRC($handle),CURLOPT_SSL_VERIFYPEER,deAspisRC($ssl_verify));
curl_setopt(deAspisRC($handle),CURLOPT_USERAGENT,deAspisRC($r[0]['user-agent']));
curl_setopt(deAspisRC($handle),CURLOPT_MAXREDIRS,deAspisRC($r[0]['redirection']));
switch ( deAspis($r[0]['method']) ) {
case ('HEAD'):curl_setopt(deAspisRC($handle),CURLOPT_NOBODY,true);
break ;
case ('POST'):curl_setopt(deAspisRC($handle),CURLOPT_POST,true);
curl_setopt(deAspisRC($handle),CURLOPT_POSTFIELDS,deAspisRC($r[0]['body']));
break ;
case ('PUT'):curl_setopt(deAspisRC($handle),CURLOPT_CUSTOMREQUEST,'PUT');
curl_setopt(deAspisRC($handle),CURLOPT_POSTFIELDS,deAspisRC($r[0]['body']));
break ;
 }
if ( (true === deAspis($r[0]['blocking'])))
 curl_setopt(deAspisRC($handle),CURLOPT_HEADER,true);
else 
{curl_setopt(deAspisRC($handle),CURLOPT_HEADER,false);
}if ( ((!(ini_get('safe_mode'))) && (!(ini_get('open_basedir')))))
 curl_setopt(deAspisRC($handle),CURLOPT_FOLLOWLOCATION,true);
if ( (!((empty($r[0][('headers')]) || Aspis_empty( $r [0][('headers')])))))
 {$headers = array(array(),false);
foreach ( deAspis($r[0]['headers']) as $name =>$value )
{restoreTaint($name,$value);
{arrayAssignAdd($headers[0][],addTaint(concat(concat2($name,": "),$value)));
}}curl_setopt(deAspisRC($handle),CURLOPT_HTTPHEADER,deAspisRC($headers));
}if ( (deAspis($r[0]['httpversion']) == ('1.0')))
 curl_setopt(deAspisRC($handle),CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_0);
else 
{curl_setopt(deAspisRC($handle),CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
}do_action_ref_array(array('http_api_curl',false),array(array(&$handle),false));
if ( (denot_boolean($r[0]['blocking'])))
 {curl_exec(deAspisRC($handle));
curl_close(deAspisRC($handle));
return array(array('headers' => array(array(),false,false),'body' => array('',false,false),'response' => array(array('code' => array(false,false,false),'message' => array(false,false,false)),false,false),'cookies' => array(array(),false,false)),false);
}$theResponse = array(curl_exec(deAspisRC($handle)),false);
if ( (!((empty($theResponse) || Aspis_empty( $theResponse)))))
 {$headerLength = array(curl_getinfo(deAspisRC($handle),CURLINFO_HEADER_SIZE),false);
$theHeaders = Aspis_trim(Aspis_substr($theResponse,array(0,false),$headerLength));
$theBody = Aspis_substr($theResponse,$headerLength);
if ( (false !== strrpos($theHeaders[0],("\r\n\r\n"))))
 {$headerParts = Aspis_explode(array("\r\n\r\n",false),$theHeaders);
$theHeaders = attachAspis($headerParts,(count($headerParts[0]) - (1)));
}$theHeaders = WP_Http::processHeaders($theHeaders);
}else 
{{if ( deAspis($curl_error = array(curl_error(deAspisRC($handle)),false)))
 return array(new WP_Error(array('http_request_failed',false),$curl_error),false);
if ( deAspis(Aspis_in_array(array(curl_getinfo(deAspisRC($handle),CURLINFO_HTTP_CODE),false),array(array(array(301,false),array(302,false)),false))))
 return array(new WP_Error(array('http_request_failed',false),__(array('Too many redirects.',false))),false);
$theHeaders = array(array('headers' => array(array(),false,false),'cookies' => array(array(),false,false)),false);
$theBody = array('',false);
}}$response = array(array(),false);
arrayAssign($response[0],deAspis(registerTaint(array('code',false))),addTaint(array(curl_getinfo(deAspisRC($handle),CURLINFO_HTTP_CODE),false)));
arrayAssign($response[0],deAspis(registerTaint(array('message',false))),addTaint(get_status_header_desc($response[0]['code'])));
curl_close(deAspisRC($handle));
if ( ((true === deAspis($r[0]['decompress'])) && (true === deAspis(WP_Http_Encoding::should_decode($theHeaders[0]['headers'])))))
 $theBody = WP_Http_Encoding::decompress($theBody);
return array(array(deregisterTaint(array('headers',false)) => addTaint($theHeaders[0]['headers']),deregisterTaint(array('body',false)) => addTaint($theBody),deregisterTaint(array('response',false)) => addTaint($response),deregisterTaint(array('cookies',false)) => addTaint($theHeaders[0]['cookies'])),false);
} }
function test ( $args = array(array(),false) ) {
{if ( (function_exists(('curl_init')) && function_exists(('curl_exec'))))
 return apply_filters(array('use_curl_transport',false),array(true,false),$args);
return array(false,false);
} }
}class WP_HTTP_Proxy{function is_enabled (  ) {
{return array(defined(('WP_PROXY_HOST')) && defined(('WP_PROXY_PORT')),false);
} }
function use_authentication (  ) {
{return array(defined(('WP_PROXY_USERNAME')) && defined(('WP_PROXY_PASSWORD')),false);
} }
function host (  ) {
{if ( defined(('WP_PROXY_HOST')))
 return array(WP_PROXY_HOST,false);
return array('',false);
} }
function port (  ) {
{if ( defined(('WP_PROXY_PORT')))
 return array(WP_PROXY_PORT,false);
return array('',false);
} }
function username (  ) {
{if ( defined(('WP_PROXY_USERNAME')))
 return array(WP_PROXY_USERNAME,false);
return array('',false);
} }
function password (  ) {
{if ( defined(('WP_PROXY_PASSWORD')))
 return array(WP_PROXY_PASSWORD,false);
return array('',false);
} }
function authentication (  ) {
{return concat(concat2($this->username(),':'),$this->password());
} }
function authentication_header (  ) {
{return concat1('Proxy-Authentication: Basic ',Aspis_base64_encode($this->authentication()));
} }
function send_through_proxy ( $uri ) {
{$check = @Aspis_parse_url($uri);
if ( ($check[0] === false))
 return array(true,false);
$home = Aspis_parse_url(get_option(array('siteurl',false)));
if ( ((deAspis($check[0]['host']) == ('localhost')) || (deAspis($check[0]['host']) == deAspis($home[0]['host']))))
 return array(false,false);
if ( (!(defined(('WP_PROXY_BYPASS_HOSTS')))))
 return array(true,false);
static $bypass_hosts;
if ( (null == $bypass_hosts[0]))
 $bypass_hosts = Aspis_preg_split(array('|,\s*|',false),array(WP_PROXY_BYPASS_HOSTS,false));
return not_boolean(Aspis_in_array($check[0]['host'],$bypass_hosts));
} }
}class WP_Http_Cookie{var $name;
var $value;
var $expires;
var $path;
var $domain;
function WP_Http_Cookie ( $data ) {
{$this->__construct($data);
} }
function __construct ( $data ) {
{if ( is_string(deAspisRC($data)))
 {$pairs = Aspis_explode(array(';',false),$data);
$name = Aspis_trim(Aspis_substr(attachAspis($pairs,(0)),array(0,false),attAspis(strpos(deAspis(attachAspis($pairs,(0))),'='))));
$value = Aspis_substr(attachAspis($pairs,(0)),array(strpos(deAspis(attachAspis($pairs,(0))),'=') + (1),false));
$this->name = $name;
$this->value = Aspis_urldecode($value);
Aspis_array_shift($pairs);
foreach ( $pairs[0] as $pair  )
{if ( ((empty($pair) || Aspis_empty( $pair))))
 continue ;
list($key,$val) = deAspisList(Aspis_explode(array('=',false),$pair),array());
$key = Aspis_strtolower(Aspis_trim($key));
if ( (('expires') == $key[0]))
 $val = attAspis(strtotime($val[0]));
$this->$key[0] = $val;
}}else 
{{if ( (!((isset($data[0][('name')]) && Aspis_isset( $data [0][('name')])))))
 return array(false,false);
$this->name = $data[0]['name'];
$this->value = ((isset($data[0][('value')]) && Aspis_isset( $data [0][('value')]))) ? $data[0]['value'] : array('',false);
$this->path = ((isset($data[0][('path')]) && Aspis_isset( $data [0][('path')]))) ? $data[0]['path'] : array('',false);
$this->domain = ((isset($data[0][('domain')]) && Aspis_isset( $data [0][('domain')]))) ? $data[0]['domain'] : array('',false);
if ( ((isset($data[0][('expires')]) && Aspis_isset( $data [0][('expires')]))))
 $this->expires = is_int(deAspisRC($data[0]['expires'])) ? $data[0]['expires'] : attAspis(strtotime(deAspis($data[0]['expires'])));
else 
{$this->expires = array(null,false);
}}}} }
function test ( $url ) {
{if ( (time() > $this->expires[0]))
 return array(false,false);
$url = Aspis_parse_url($url);
arrayAssign($url[0],deAspis(registerTaint(array('port',false))),addTaint(((isset($url[0][('port')]) && Aspis_isset( $url [0][('port')]))) ? $url[0]['port'] : array(80,false)));
arrayAssign($url[0],deAspis(registerTaint(array('path',false))),addTaint(((isset($url[0][('path')]) && Aspis_isset( $url [0][('path')]))) ? $url[0]['path'] : array('/',false)));
$path = ((isset($this->path) && Aspis_isset( $this ->path ))) ? $this->path : array('/',false);
$port = ((isset($this->port) && Aspis_isset( $this ->port ))) ? $this->port : array(80,false);
$domain = ((isset($this->domain) && Aspis_isset( $this ->domain ))) ? Aspis_strtolower($this->domain) : Aspis_strtolower($url[0]['host']);
if ( (false === (stripos(deAspisRC($domain),'.'))))
 $domain = concat2($domain,'.local');
$domain = (deAspis(Aspis_substr($domain,array(0,false),array(1,false))) == ('.')) ? Aspis_substr($domain,array(1,false)) : $domain;
if ( (deAspis(Aspis_substr($url[0]['host'],negate(attAspis(strlen($domain[0]))))) != $domain[0]))
 return array(false,false);
if ( (denot_boolean(Aspis_in_array($url[0]['port'],Aspis_explode(array(',',false),$port)))))
 return array(false,false);
if ( (deAspis(Aspis_substr($url[0]['path'],array(0,false),attAspis(strlen($path[0])))) != $path[0]))
 return array(false,false);
return array(true,false);
} }
function getHeaderValue (  ) {
{if ( (((empty($this->name) || Aspis_empty( $this ->name ))) || ((empty($this->value) || Aspis_empty( $this ->value )))))
 return array('',false);
return concat(concat2($this->name,'='),Aspis_urlencode($this->value));
} }
function getFullHeader (  ) {
{return concat1('Cookie: ',$this->getHeaderValue());
} }
}class WP_Http_Encoding{function compress ( $raw,$level = array(9,false),$supports = array(null,false) ) {
{return array(gzdeflate(deAspisRC($raw),deAspisRC($level)),false);
} }
function decompress ( $compressed,$length = array(null,false) ) {
{if ( (false !== deAspis(($decompressed = @array(gzinflate(deAspisRC($compressed)),false)))))
 return $decompressed;
if ( (false !== deAspis(($decompressed = WP_Http_Encoding::compatible_gzinflate($compressed)))))
 return $decompressed;
if ( (false !== deAspis(($decompressed = @array(gzuncompress(deAspisRC($compressed)),false)))))
 return $decompressed;
if ( function_exists(('gzdecode')))
 {$decompressed = @array(gzdecode(deAspisRC($compressed)),false);
if ( (false !== $decompressed[0]))
 return $decompressed;
}return $compressed;
} }
function compatible_gzinflate ( $gzData ) {
{if ( (deAspis(Aspis_substr($gzData,array(0,false),array(3,false))) == ("\x1f\x8b\x08")))
 {$i = array(10,false);
$flg = attAspis(ord(deAspis(Aspis_substr($gzData,array(3,false),array(1,false)))));
if ( ($flg[0] > (0)))
 {if ( ($flg[0] & (4)))
 {list($xlen) = deAspisList(attAspisRC(unpack(('v'),deAspis(Aspis_substr($gzData,$i,array(2,false))))),array());
$i = array(($i[0] + (2)) + $xlen[0],false);
}if ( ($flg[0] & (8)))
 $i = array(strpos($gzData[0],"\0",$i[0]) + (1),false);
if ( ($flg[0] & (16)))
 $i = array(strpos($gzData[0],"\0",$i[0]) + (1),false);
if ( ($flg[0] & (2)))
 $i = array($i[0] + (2),false);
}return array(gzinflate(deAspisRC(Aspis_substr($gzData,$i,negate(array(8,false))))),false);
}else 
{{return array(false,false);
}}} }
function accept_encoding (  ) {
{$type = array(array(),false);
if ( function_exists(('gzinflate')))
 arrayAssignAdd($type[0][],addTaint(array('deflate;q=1.0',false)));
if ( function_exists(('gzuncompress')))
 arrayAssignAdd($type[0][],addTaint(array('compress;q=0.5',false)));
if ( function_exists(('gzdecode')))
 arrayAssignAdd($type[0][],addTaint(array('gzip;q=0.5',false)));
return Aspis_implode(array(', ',false),$type);
} }
function content_encoding (  ) {
{return array('deflate',false);
} }
function should_decode ( $headers ) {
{if ( is_array($headers[0]))
 {if ( (array_key_exists('content-encoding',deAspisRC($headers)) && (!((empty($headers[0][('content-encoding')]) || Aspis_empty( $headers [0][('content-encoding')]))))))
 return array(true,false);
}else 
{if ( is_string(deAspisRC($headers)))
 {return (array((stripos(deAspisRC($headers),'content-encoding:')) !== false,false));
}}return array(false,false);
} }
function is_available (  ) {
{return (array((function_exists(('gzuncompress')) || function_exists(('gzdeflate'))) || function_exists(('gzinflate')),false));
} }
}function &_wp_http_get_object (  ) {
static $http;
if ( is_null(deAspisRC($http)))
 $http = array(new WP_Http(),false);
return $http;
 }
function wp_remote_request ( $url,$args = array(array(),false) ) {
$objFetchSite = _wp_http_get_object();
return $objFetchSite[0]->request($url,$args);
 }
function wp_remote_get ( $url,$args = array(array(),false) ) {
$objFetchSite = _wp_http_get_object();
return $objFetchSite[0]->get($url,$args);
 }
function wp_remote_post ( $url,$args = array(array(),false) ) {
$objFetchSite = _wp_http_get_object();
return $objFetchSite[0]->post($url,$args);
 }
function wp_remote_head ( $url,$args = array(array(),false) ) {
$objFetchSite = _wp_http_get_object();
return $objFetchSite[0]->head($url,$args);
 }
function wp_remote_retrieve_headers ( &$response ) {
if ( ((deAspis(is_wp_error($response)) || (!((isset($response[0][('headers')]) && Aspis_isset( $response [0][('headers')]))))) || (!(is_array(deAspis($response[0]['headers']))))))
 return array(array(),false);
return $response[0]['headers'];
 }
function wp_remote_retrieve_header ( &$response,$header ) {
if ( ((deAspis(is_wp_error($response)) || (!((isset($response[0][('headers')]) && Aspis_isset( $response [0][('headers')]))))) || (!(is_array(deAspis($response[0]['headers']))))))
 return array('',false);
if ( array_key_exists(deAspisRC($header),deAspisRC($response[0]['headers'])))
 return attachAspis($response[0][('headers')],$header[0]);
return array('',false);
 }
function wp_remote_retrieve_response_code ( &$response ) {
if ( ((deAspis(is_wp_error($response)) || (!((isset($response[0][('response')]) && Aspis_isset( $response [0][('response')]))))) || (!(is_array(deAspis($response[0]['response']))))))
 return array('',false);
return $response[0][('response')][0]['code'];
 }
function wp_remote_retrieve_response_message ( &$response ) {
if ( ((deAspis(is_wp_error($response)) || (!((isset($response[0][('response')]) && Aspis_isset( $response [0][('response')]))))) || (!(is_array(deAspis($response[0]['response']))))))
 return array('',false);
return $response[0][('response')][0]['message'];
 }
function wp_remote_retrieve_body ( &$response ) {
if ( (deAspis(is_wp_error($response)) || (!((isset($response[0][('body')]) && Aspis_isset( $response [0][('body')]))))))
 return array('',false);
return $response[0]['body'];
 }
;
?>
<?php 