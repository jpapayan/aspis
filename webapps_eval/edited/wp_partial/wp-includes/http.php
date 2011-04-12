<?php require_once('AspisMain.php'); ?><?php
class WP_Http{function WP_Http (  ) {
{$this->__construct();
} }
function __construct (  ) {
{WP_Http::_getTransport();
WP_Http::_postTransport();
} }
function &_getTransport ( $args = array() ) {
{static $working_transport,$blocking_transport,$nonblocking_transport;
if ( is_null($working_transport))
 {if ( true === WP_Http_ExtHttp::test($args))
 {$working_transport['exthttp'] = new WP_Http_ExtHttp();
$blocking_transport[] = &$working_transport['exthttp'];
}else 
{if ( true === WP_Http_Curl::test($args))
 {$working_transport['curl'] = new WP_Http_Curl();
$blocking_transport[] = &$working_transport['curl'];
}else 
{if ( true === WP_Http_Streams::test($args))
 {$working_transport['streams'] = new WP_Http_Streams();
$blocking_transport[] = &$working_transport['streams'];
}else 
{if ( true === WP_Http_Fopen::test($args))
 {$working_transport['fopen'] = new WP_Http_Fopen();
$blocking_transport[] = &$working_transport['fopen'];
}else 
{if ( true === WP_Http_Fsockopen::test($args))
 {$working_transport['fsockopen'] = new WP_Http_Fsockopen();
$blocking_transport[] = &$working_transport['fsockopen'];
}}}}}foreach ( array('curl','streams','fopen','fsockopen','exthttp') as $transport  )
{if ( isset($working_transport[$transport]))
 $nonblocking_transport[] = &$working_transport[$transport];
}}do_action('http_transport_get_debug',$working_transport,$blocking_transport,$nonblocking_transport);
if ( isset($args['blocking']) && !$args['blocking'])
 {$AspisRetTemp = &$nonblocking_transport;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = &$blocking_transport;
return $AspisRetTemp;
}}} }
function &_postTransport ( $args = array() ) {
{static $working_transport,$blocking_transport,$nonblocking_transport;
if ( is_null($working_transport))
 {if ( true === WP_Http_ExtHttp::test($args))
 {$working_transport['exthttp'] = new WP_Http_ExtHttp();
$blocking_transport[] = &$working_transport['exthttp'];
}else 
{if ( true === WP_Http_Curl::test($args))
 {$working_transport['curl'] = new WP_Http_Curl();
$blocking_transport[] = &$working_transport['curl'];
}else 
{if ( true === WP_Http_Streams::test($args))
 {$working_transport['streams'] = new WP_Http_Streams();
$blocking_transport[] = &$working_transport['streams'];
}else 
{if ( true === WP_Http_Fsockopen::test($args))
 {$working_transport['fsockopen'] = new WP_Http_Fsockopen();
$blocking_transport[] = &$working_transport['fsockopen'];
}}}}foreach ( array('curl','streams','fsockopen','exthttp') as $transport  )
{if ( isset($working_transport[$transport]))
 $nonblocking_transport[] = &$working_transport[$transport];
}}do_action('http_transport_post_debug',$working_transport,$blocking_transport,$nonblocking_transport);
if ( isset($args['blocking']) && !$args['blocking'])
 {$AspisRetTemp = &$nonblocking_transport;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = &$blocking_transport;
return $AspisRetTemp;
}}} }
function request ( $url,$args = array() ) {
{{global $wp_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_version,"\$wp_version",$AspisChangesCache);
}$defaults = array('method' => 'GET','timeout' => apply_filters('http_request_timeout',5),'redirection' => apply_filters('http_request_redirection_count',5),'httpversion' => apply_filters('http_request_version','1.0'),'user-agent' => apply_filters('http_headers_useragent','WordPress/' . $wp_version . '; ' . get_bloginfo('url')),'blocking' => true,'headers' => array(),'cookies' => array(),'body' => null,'compress' => false,'decompress' => true,'sslverify' => true);
$r = wp_parse_args($args,$defaults);
$r = apply_filters('http_request_args',$r,$url);
$pre = apply_filters('pre_http_request',false,$r,$url);
if ( false !== $pre)
 {$AspisRetTemp = $pre;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}$arrURL = parse_url($url);
if ( $this->block_request($url))
 {$AspisRetTemp = new WP_Error('http_request_failed',__('User has blocked requests through HTTP.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}$r['ssl'] = $arrURL['scheme'] == 'https' || $arrURL['scheme'] == 'ssl';
$homeURL = parse_url(get_bloginfo('url'));
$r['local'] = $homeURL['host'] == $arrURL['host'] || 'localhost' == $arrURL['host'];
unset($homeURL);
if ( is_null($r['headers']))
 $r['headers'] = array();
if ( !is_array($r['headers']))
 {$processedHeaders = WP_Http::processHeaders($r['headers']);
$r['headers'] = $processedHeaders['headers'];
}if ( isset($r['headers']['User-Agent']))
 {$r['user-agent'] = $r['headers']['User-Agent'];
unset($r['headers']['User-Agent']);
}if ( isset($r['headers']['user-agent']))
 {$r['user-agent'] = $r['headers']['user-agent'];
unset($r['headers']['user-agent']);
}WP_Http::buildCookieHeader($r);
if ( WP_Http_Encoding::is_available())
 $r['headers']['Accept-Encoding'] = WP_Http_Encoding::accept_encoding();
if ( empty($r['body']))
 {if ( ($r['method'] == 'POST' || $r['method'] == 'PUT') && !isset($r['headers']['Content-Length']))
 $r['headers']['Content-Length'] = 0;
$transports = WP_Http::_getTransport($r);
}else 
{{if ( is_array($r['body']) || is_object($r['body']))
 {if ( !version_compare(phpversion(),'5.1.2','>='))
 $r['body'] = _http_build_query($r['body'],null,'&');
else 
{$r['body'] = http_build_query($r['body'],null,'&');
}$r['headers']['Content-Type'] = 'application/x-www-form-urlencoded; charset=' . get_option('blog_charset');
$r['headers']['Content-Length'] = strlen($r['body']);
}if ( !isset($r['headers']['Content-Length']) && !isset($r['headers']['content-length']))
 $r['headers']['Content-Length'] = strlen($r['body']);
$transports = WP_Http::_postTransport($r);
}}do_action('http_api_debug',$transports,'transports_list');
$response = array('headers' => array(),'body' => '','response' => array('code' => false,'message' => false),'cookies' => array());
foreach ( (array)$transports as $transport  )
{$response = $transport->request($url,$r);
do_action('http_api_debug',$response,'response',get_class($transport));
if ( !is_wp_error($response))
 {$AspisRetTemp = apply_filters('http_response',$response,$r,$url);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = $response;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
 }
function post ( $url,$args = array() ) {
{$defaults = array('method' => 'POST');
$r = wp_parse_args($args,$defaults);
{$AspisRetTemp = $this->request($url,$r);
return $AspisRetTemp;
}} }
function get ( $url,$args = array() ) {
{$defaults = array('method' => 'GET');
$r = wp_parse_args($args,$defaults);
{$AspisRetTemp = $this->request($url,$r);
return $AspisRetTemp;
}} }
function head ( $url,$args = array() ) {
{$defaults = array('method' => 'HEAD');
$r = wp_parse_args($args,$defaults);
{$AspisRetTemp = $this->request($url,$r);
return $AspisRetTemp;
}} }
function processResponse ( $strResponse ) {
{list($theHeaders,$theBody) = explode("\r\n\r\n",$strResponse,2);
{$AspisRetTemp = array('headers' => $theHeaders,'body' => $theBody);
return $AspisRetTemp;
}} }
function processHeaders ( $headers ) {
{if ( is_string($headers))
 {$headers = str_replace("\r\n","\n",$headers);
$headers = preg_replace('/\n[ \t]/',' ',$headers);
$headers = explode("\n",$headers);
}$response = array('code' => 0,'message' => '');
$cookies = array();
$newheaders = array();
foreach ( $headers as $tempheader  )
{if ( empty($tempheader))
 continue ;
if ( false === strpos($tempheader,':'))
 {list(,$iResponseCode,$strResponseMsg) = explode(' ',$tempheader,3);
$response['code'] = $iResponseCode;
$response['message'] = $strResponseMsg;
continue ;
}list($key,$value) = explode(':',$tempheader,2);
if ( !empty($value))
 {$key = strtolower($key);
if ( isset($newheaders[$key]))
 {$newheaders[$key] = array($newheaders[$key],trim($value));
}else 
{{$newheaders[$key] = trim($value);
}}if ( 'set-cookie' == strtolower($key))
 $cookies[] = new WP_Http_Cookie($value);
}}{$AspisRetTemp = array('response' => $response,'headers' => $newheaders,'cookies' => $cookies);
return $AspisRetTemp;
}} }
function buildCookieHeader ( &$r ) {
{if ( !empty($r['cookies']))
 {$cookies_header = '';
foreach ( (array)$r['cookies'] as $cookie  )
{$cookies_header .= $cookie->getHeaderValue() . '; ';
}$cookies_header = substr($cookies_header,0,-2);
$r['headers']['cookie'] = $cookies_header;
}} }
function chunkTransferDecode ( $body ) {
{$body = str_replace(array("\r\n","\r"),"\n",$body);
if ( !preg_match('/^[0-9a-f]+(\s|\n)+/mi',trim($body)))
 {$AspisRetTemp = $body;
return $AspisRetTemp;
}$parsedBody = '';
while ( true )
{$hasChunk = (bool)preg_match('/^([0-9a-f]+)(\s|\n)+/mi',$body,$match);
if ( $hasChunk)
 {if ( empty($match[1]))
 {$AspisRetTemp = $body;
return $AspisRetTemp;
}$length = hexdec($match[1]);
$chunkLength = strlen($match[0]);
$strBody = substr($body,$chunkLength,$length);
$parsedBody .= $strBody;
$body = ltrim(str_replace(array($match[0],$strBody),'',$body),"\n");
if ( "0" == trim($body))
 {$AspisRetTemp = $parsedBody;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = $body;
return $AspisRetTemp;
}}}}} }
function block_request ( $uri ) {
{if ( !defined('WP_HTTP_BLOCK_EXTERNAL') || (defined('WP_HTTP_BLOCK_EXTERNAL') && WP_HTTP_BLOCK_EXTERNAL == false))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$check = @parse_url($uri);
if ( $check === false)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$home = parse_url(get_option('siteurl'));
if ( $check['host'] == 'localhost' || $check['host'] == $home['host'])
 {$AspisRetTemp = apply_filters('block_local_requests',false);
return $AspisRetTemp;
}if ( !defined('WP_ACCESSIBLE_HOSTS'))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}static $accessible_hosts;
if ( null == $accessible_hosts)
 $accessible_hosts = preg_split('|,\s*|',WP_ACCESSIBLE_HOSTS);
{$AspisRetTemp = !in_array($check['host'],$accessible_hosts);
return $AspisRetTemp;
}} }
}class WP_Http_Fsockopen{function request ( $url,$args = array() ) {
{$defaults = array('method' => 'GET','timeout' => 5,'redirection' => 5,'httpversion' => '1.0','blocking' => true,'headers' => array(),'body' => null,'cookies' => array());
$r = wp_parse_args($args,$defaults);
if ( isset($r['headers']['User-Agent']))
 {$r['user-agent'] = $r['headers']['User-Agent'];
unset($r['headers']['User-Agent']);
}else 
{if ( isset($r['headers']['user-agent']))
 {$r['user-agent'] = $r['headers']['user-agent'];
unset($r['headers']['user-agent']);
}}WP_Http::buildCookieHeader($r);
$iError = null;
$strError = null;
$arrURL = parse_url($url);
$fsockopen_host = $arrURL['host'];
$secure_transport = false;
if ( !isset($arrURL['port']))
 {if ( ($arrURL['scheme'] == 'ssl' || $arrURL['scheme'] == 'https') && extension_loaded('openssl'))
 {$fsockopen_host = "ssl://$fsockopen_host";
$arrURL['port'] = 443;
$secure_transport = true;
}else 
{{$arrURL['port'] = 80;
}}}if ( 'localhost' == strtolower($fsockopen_host))
 $fsockopen_host = '127.0.0.1';
if ( true === $secure_transport)
 $error_reporting = error_reporting(0);
$startDelay = time();
$proxy = new WP_HTTP_Proxy();
if ( !WP_DEBUG)
 {if ( $proxy->is_enabled() && $proxy->send_through_proxy($url))
 $handle = @fsockopen($proxy->host(),$proxy->port(),$iError,$strError,$r['timeout']);
else 
{$handle = @fsockopen($fsockopen_host,$arrURL['port'],$iError,$strError,$r['timeout']);
}}else 
{{if ( $proxy->is_enabled() && $proxy->send_through_proxy($url))
 $handle = fsockopen($proxy->host(),$proxy->port(),$iError,$strError,$r['timeout']);
else 
{$handle = fsockopen($fsockopen_host,$arrURL['port'],$iError,$strError,$r['timeout']);
}}}$endDelay = time();
$elapseDelay = ($endDelay - $startDelay) > $r['timeout'];
if ( true === $elapseDelay)
 add_option('disable_fsockopen',$endDelay,null,true);
if ( false === $handle)
 {$AspisRetTemp = new WP_Error('http_request_failed',$iError . ': ' . $strError);
return $AspisRetTemp;
}$timeout = (int)floor($r['timeout']);
$utimeout = $timeout == $r['timeout'] ? 0 : 1000000 * $r['timeout'] % 1000000;
stream_set_timeout($handle,$timeout,$utimeout);
if ( $proxy->is_enabled() && $proxy->send_through_proxy($url))
 $requestPath = $url;
else 
{$requestPath = $arrURL['path'] . (isset($arrURL['query']) ? '?' . $arrURL['query'] : '');
}if ( empty($requestPath))
 $requestPath .= '/';
$strHeaders = strtoupper($r['method']) . ' ' . $requestPath . ' HTTP/' . $r['httpversion'] . "\r\n";
if ( $proxy->is_enabled() && $proxy->send_through_proxy($url))
 $strHeaders .= 'Host: ' . $arrURL['host'] . ':' . $arrURL['port'] . "\r\n";
else 
{$strHeaders .= 'Host: ' . $arrURL['host'] . "\r\n";
}if ( isset($r['user-agent']))
 $strHeaders .= 'User-agent: ' . $r['user-agent'] . "\r\n";
if ( is_array($r['headers']))
 {foreach ( (array)$r['headers'] as $header =>$headerValue )
$strHeaders .= $header . ': ' . $headerValue . "\r\n";
}else 
{{$strHeaders .= $r['headers'];
}}if ( $proxy->use_authentication())
 $strHeaders .= $proxy->authentication_header() . "\r\n";
$strHeaders .= "\r\n";
if ( !is_null($r['body']))
 $strHeaders .= $r['body'];
fwrite($handle,$strHeaders);
if ( !$r['blocking'])
 {fclose($handle);
{$AspisRetTemp = array('headers' => array(),'body' => '','response' => array('code' => false,'message' => false),'cookies' => array());
return $AspisRetTemp;
}}$strResponse = '';
while ( !feof($handle) )
$strResponse .= fread($handle,4096);
fclose($handle);
if ( true === $secure_transport)
 error_reporting($error_reporting);
$process = WP_Http::processResponse($strResponse);
$arrHeaders = WP_Http::processHeaders($process['headers']);
if ( (int)$arrHeaders['response']['code'] >= 400 && (int)$arrHeaders['response']['code'] < 500)
 {$AspisRetTemp = new WP_Error('http_request_failed',$arrHeaders['response']['code'] . ': ' . $arrHeaders['response']['message']);
return $AspisRetTemp;
}if ( isset($arrHeaders['headers']['location']))
 {if ( $r['redirection']-- > 0)
 {{$AspisRetTemp = $this->request($arrHeaders['headers']['location'],$r);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = new WP_Error('http_request_failed',__('Too many redirects.'));
return $AspisRetTemp;
}}}}if ( !empty($process['body']) && isset($arrHeaders['headers']['transfer-encoding']) && 'chunked' == $arrHeaders['headers']['transfer-encoding'])
 $process['body'] = WP_Http::chunkTransferDecode($process['body']);
if ( true === $r['decompress'] && true === WP_Http_Encoding::should_decode($arrHeaders['headers']))
 $process['body'] = WP_Http_Encoding::decompress($process['body']);
{$AspisRetTemp = array('headers' => $arrHeaders['headers'],'body' => $process['body'],'response' => $arrHeaders['response'],'cookies' => $arrHeaders['cookies']);
return $AspisRetTemp;
}} }
function test ( $args = array() ) {
{if ( false !== ($option = get_option('disable_fsockopen')) && time() - $option < 43200)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$is_ssl = isset($args['ssl']) && $args['ssl'];
if ( !$is_ssl && function_exists('fsockopen'))
 $use = true;
elseif ( $is_ssl && extension_loaded('openssl') && function_exists('fsockopen'))
 $use = true;
else 
{$use = false;
}{$AspisRetTemp = apply_filters('use_fsockopen_transport',$use,$args);
return $AspisRetTemp;
}} }
}class WP_Http_Fopen{function request ( $url,$args = array() ) {
{$defaults = array('method' => 'GET','timeout' => 5,'redirection' => 5,'httpversion' => '1.0','blocking' => true,'headers' => array(),'body' => null,'cookies' => array());
$r = wp_parse_args($args,$defaults);
$arrURL = parse_url($url);
if ( false === $arrURL)
 {$AspisRetTemp = new WP_Error('http_request_failed',sprintf(__('Malformed URL: %s'),$url));
return $AspisRetTemp;
}if ( 'http' != $arrURL['scheme'] && 'https' != $arrURL['scheme'])
 $url = str_replace($arrURL['scheme'],'http',$url);
if ( !WP_DEBUG)
 $handle = @fopen($url,'r');
else 
{$handle = fopen($url,'r');
}if ( !$handle)
 {$AspisRetTemp = new WP_Error('http_request_failed',sprintf(__('Could not open handle for fopen() to %s'),$url));
return $AspisRetTemp;
}$timeout = (int)floor($r['timeout']);
$utimeout = $timeout == $r['timeout'] ? 0 : 1000000 * $r['timeout'] % 1000000;
stream_set_timeout($handle,$timeout,$utimeout);
if ( !$r['blocking'])
 {fclose($handle);
{$AspisRetTemp = array('headers' => array(),'body' => '','response' => array('code' => false,'message' => false),'cookies' => array());
return $AspisRetTemp;
}}$strResponse = '';
while ( !feof($handle) )
$strResponse .= fread($handle,4096);
if ( function_exists('stream_get_meta_data'))
 {$meta = stream_get_meta_data($handle);
$theHeaders = $meta['wrapper_data'];
if ( isset($meta['wrapper_data']['headers']))
 $theHeaders = $meta['wrapper_data']['headers'];
}else 
{{$theHeaders = $http_response_header;
}}fclose($handle);
$processedHeaders = WP_Http::processHeaders($theHeaders);
if ( !empty($strResponse) && isset($processedHeaders['headers']['transfer-encoding']) && 'chunked' == $processedHeaders['headers']['transfer-encoding'])
 $strResponse = WP_Http::chunkTransferDecode($strResponse);
if ( true === $r['decompress'] && true === WP_Http_Encoding::should_decode($processedHeaders['headers']))
 $strResponse = WP_Http_Encoding::decompress($strResponse);
{$AspisRetTemp = array('headers' => $processedHeaders['headers'],'body' => $strResponse,'response' => $processedHeaders['response'],'cookies' => $processedHeaders['cookies']);
return $AspisRetTemp;
}} }
function test ( $args = array() ) {
{if ( !function_exists('fopen') || (function_exists('ini_get') && true != ini_get('allow_url_fopen')))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$use = true;
$is_ssl = isset($args['ssl']) && $args['ssl'];
if ( $is_ssl)
 {$is_local = isset($args['local']) && $args['local'];
$ssl_verify = isset($args['sslverify']) && $args['sslverify'];
if ( $is_local && true != apply_filters('https_local_ssl_verify',true))
 $use = true;
elseif ( !$is_local && true != apply_filters('https_ssl_verify',true))
 $use = true;
elseif ( !$ssl_verify)
 $use = true;
else 
{$use = false;
}}{$AspisRetTemp = apply_filters('use_fopen_transport',$use,$args);
return $AspisRetTemp;
}} }
}class WP_Http_Streams{function request ( $url,$args = array() ) {
{$defaults = array('method' => 'GET','timeout' => 5,'redirection' => 5,'httpversion' => '1.0','blocking' => true,'headers' => array(),'body' => null,'cookies' => array());
$r = wp_parse_args($args,$defaults);
if ( isset($r['headers']['User-Agent']))
 {$r['user-agent'] = $r['headers']['User-Agent'];
unset($r['headers']['User-Agent']);
}else 
{if ( isset($r['headers']['user-agent']))
 {$r['user-agent'] = $r['headers']['user-agent'];
unset($r['headers']['user-agent']);
}}WP_Http::buildCookieHeader($r);
$arrURL = parse_url($url);
if ( false === $arrURL)
 {$AspisRetTemp = new WP_Error('http_request_failed',sprintf(__('Malformed URL: %s'),$url));
return $AspisRetTemp;
}if ( 'http' != $arrURL['scheme'] && 'https' != $arrURL['scheme'])
 $url = preg_replace('|^' . preg_quote($arrURL['scheme'],'|') . '|','http',$url);
$strHeaders = '';
if ( is_array($r['headers']))
 foreach ( $r['headers'] as $name =>$value )
$strHeaders .= "{$name}: $value\r\n";
else 
{if ( is_string($r['headers']))
 $strHeaders = $r['headers'];
}$is_local = isset($args['local']) && $args['local'];
$ssl_verify = isset($args['sslverify']) && $args['sslverify'];
if ( $is_local)
 $ssl_verify = apply_filters('https_local_ssl_verify',$ssl_verify);
elseif ( !$is_local)
 $ssl_verify = apply_filters('https_ssl_verify',$ssl_verify);
$arrContext = array('http' => array('method' => strtoupper($r['method']),'user_agent' => $r['user-agent'],'max_redirects' => $r['redirection'],'protocol_version' => (double)$r['httpversion'],'header' => $strHeaders,'timeout' => $r['timeout'],'ssl' => array('verify_peer' => $ssl_verify,'verify_host' => $ssl_verify)));
$proxy = new WP_HTTP_Proxy();
if ( $proxy->is_enabled() && $proxy->send_through_proxy($url))
 {$arrContext['http']['proxy'] = 'tcp://' . $proxy->host() . ':' . $proxy->port();
$arrContext['http']['request_fulluri'] = true;
if ( $proxy->use_authentication())
 $arrContext['http']['header'] .= $proxy->authentication_header() . "\r\n";
}if ( !is_null($r['body']) && !empty($r['body']))
 $arrContext['http']['content'] = $r['body'];
$context = stream_context_create($arrContext);
if ( !WP_DEBUG)
 $handle = @fopen($url,'r',false,$context);
else 
{$handle = fopen($url,'r',false,$context);
}if ( !$handle)
 {$AspisRetTemp = new WP_Error('http_request_failed',sprintf(__('Could not open handle for fopen() to %s'),$url));
return $AspisRetTemp;
}$timeout = (int)floor($r['timeout']);
$utimeout = $timeout == $r['timeout'] ? 0 : 1000000 * $r['timeout'] % 1000000;
stream_set_timeout($handle,$timeout,$utimeout);
if ( !$r['blocking'])
 {stream_set_blocking($handle,0);
fclose($handle);
{$AspisRetTemp = array('headers' => array(),'body' => '','response' => array('code' => false,'message' => false),'cookies' => array());
return $AspisRetTemp;
}}$strResponse = stream_get_contents($handle);
$meta = stream_get_meta_data($handle);
fclose($handle);
$processedHeaders = array();
if ( isset($meta['wrapper_data']['headers']))
 $processedHeaders = WP_Http::processHeaders($meta['wrapper_data']['headers']);
else 
{$processedHeaders = WP_Http::processHeaders($meta['wrapper_data']);
}if ( !empty($strResponse) && isset($processedHeaders['headers']['transfer-encoding']) && 'chunked' == $processedHeaders['headers']['transfer-encoding'])
 $strResponse = WP_Http::chunkTransferDecode($strResponse);
if ( true === $r['decompress'] && true === WP_Http_Encoding::should_decode($processedHeaders['headers']))
 $strResponse = WP_Http_Encoding::decompress($strResponse);
{$AspisRetTemp = array('headers' => $processedHeaders['headers'],'body' => $strResponse,'response' => $processedHeaders['response'],'cookies' => $processedHeaders['cookies']);
return $AspisRetTemp;
}} }
function test ( $args = array() ) {
{if ( !function_exists('fopen') || (function_exists('ini_get') && true != ini_get('allow_url_fopen')))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( version_compare(PHP_VERSION,'5.0','<'))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$is_ssl = isset($args['ssl']) && $args['ssl'];
if ( $is_ssl && version_compare(PHP_VERSION,'5.1.0','<'))
 {$proxy = new WP_HTTP_Proxy();
if ( $proxy->is_enabled())
 {$AspisRetTemp = false;
return $AspisRetTemp;
}}{$AspisRetTemp = apply_filters('use_streams_transport',true,$args);
return $AspisRetTemp;
}} }
}class WP_Http_ExtHTTP{function request ( $url,$args = array() ) {
{$defaults = array('method' => 'GET','timeout' => 5,'redirection' => 5,'httpversion' => '1.0','blocking' => true,'headers' => array(),'body' => null,'cookies' => array());
$r = wp_parse_args($args,$defaults);
if ( isset($r['headers']['User-Agent']))
 {$r['user-agent'] = $r['headers']['User-Agent'];
unset($r['headers']['User-Agent']);
}else 
{if ( isset($r['headers']['user-agent']))
 {$r['user-agent'] = $r['headers']['user-agent'];
unset($r['headers']['user-agent']);
}}WP_Http::buildCookieHeader($r);
switch ( $r['method'] ) {
case 'POST':$r['method'] = HTTP_METH_POST;
break ;
case 'HEAD':$r['method'] = HTTP_METH_HEAD;
break ;
case 'PUT':$r['method'] = HTTP_METH_PUT;
break ;
case 'GET':default :$r['method'] = HTTP_METH_GET;
 }
$arrURL = parse_url($url);
if ( 'http' != $arrURL['scheme'] || 'https' != $arrURL['scheme'])
 $url = preg_replace('|^' . preg_quote($arrURL['scheme'],'|') . '|','http',$url);
$is_local = isset($args['local']) && $args['local'];
$ssl_verify = isset($args['sslverify']) && $args['sslverify'];
if ( $is_local)
 $ssl_verify = apply_filters('https_local_ssl_verify',$ssl_verify);
elseif ( !$is_local)
 $ssl_verify = apply_filters('https_ssl_verify',$ssl_verify);
$r['timeout'] = (int)ceil($r['timeout']);
$options = array('timeout' => $r['timeout'],'connecttimeout' => $r['timeout'],'redirect' => $r['redirection'],'useragent' => $r['user-agent'],'headers' => $r['headers'],'ssl' => array('verifypeer' => $ssl_verify,'verifyhost' => $ssl_verify));
$proxy = new WP_HTTP_Proxy();
if ( $proxy->is_enabled() && $proxy->send_through_proxy($url))
 {$options['proxyhost'] = $proxy->host();
$options['proxyport'] = $proxy->port();
$options['proxytype'] = HTTP_PROXY_HTTP;
if ( $proxy->use_authentication())
 {$options['proxyauth'] = $proxy->authentication();
$options['proxyauthtype'] = HTTP_AUTH_BASIC;
}}if ( !WP_DEBUG)
 $strResponse = @http_request($r['method'],$url,$r['body'],$options,$info);
else 
{$strResponse = http_request($r['method'],$url,$r['body'],$options,$info);
}if ( false === $strResponse || !empty($info['error']))
 {$AspisRetTemp = new WP_Error('http_request_failed',$info['response_code'] . ': ' . $info['error']);
return $AspisRetTemp;
}if ( !$r['blocking'])
 {$AspisRetTemp = array('headers' => array(),'body' => '','response' => array('code' => false,'message' => false),'cookies' => array());
return $AspisRetTemp;
}list($theHeaders,$theBody) = explode("\r\n\r\n",$strResponse,2);
$theHeaders = WP_Http::processHeaders($theHeaders);
if ( !empty($theBody) && isset($theHeaders['headers']['transfer-encoding']) && 'chunked' == $theHeaders['headers']['transfer-encoding'])
 {if ( !WP_DEBUG)
 $theBody = @http_chunked_decode($theBody);
else 
{$theBody = http_chunked_decode($theBody);
}}if ( true === $r['decompress'] && true === WP_Http_Encoding::should_decode($theHeaders['headers']))
 $theBody = http_inflate($theBody);
$theResponse = array();
$theResponse['code'] = $info['response_code'];
$theResponse['message'] = get_status_header_desc($info['response_code']);
{$AspisRetTemp = array('headers' => $theHeaders['headers'],'body' => $theBody,'response' => $theResponse,'cookies' => $theHeaders['cookies']);
return $AspisRetTemp;
}} }
function test ( $args = array() ) {
{{$AspisRetTemp = apply_filters('use_http_extension_transport',function_exists('http_request'),$args);
return $AspisRetTemp;
}} }
}class WP_Http_Curl{function request ( $url,$args = array() ) {
{$defaults = array('method' => 'GET','timeout' => 5,'redirection' => 5,'httpversion' => '1.0','blocking' => true,'headers' => array(),'body' => null,'cookies' => array());
$r = wp_parse_args($args,$defaults);
if ( isset($r['headers']['User-Agent']))
 {$r['user-agent'] = $r['headers']['User-Agent'];
unset($r['headers']['User-Agent']);
}else 
{if ( isset($r['headers']['user-agent']))
 {$r['user-agent'] = $r['headers']['user-agent'];
unset($r['headers']['user-agent']);
}}WP_Http::buildCookieHeader($r);
$handle = curl_init();
$proxy = new WP_HTTP_Proxy();
if ( $proxy->is_enabled() && $proxy->send_through_proxy($url))
 {$isPHP5 = version_compare(PHP_VERSION,'5.0.0','>=');
if ( $isPHP5)
 {curl_setopt($handle,CURLOPT_PROXYTYPE,CURLPROXY_HTTP);
curl_setopt($handle,CURLOPT_PROXY,$proxy->host());
curl_setopt($handle,CURLOPT_PROXYPORT,$proxy->port());
}else 
{{curl_setopt($handle,CURLOPT_PROXY,$proxy->host() . ':' . $proxy->port());
}}if ( $proxy->use_authentication())
 {if ( $isPHP5)
 curl_setopt($handle,CURLOPT_PROXYAUTH,CURLAUTH_BASIC);
curl_setopt($handle,CURLOPT_PROXYUSERPWD,$proxy->authentication());
}}$is_local = isset($args['local']) && $args['local'];
$ssl_verify = isset($args['sslverify']) && $args['sslverify'];
if ( $is_local)
 $ssl_verify = apply_filters('https_local_ssl_verify',$ssl_verify);
elseif ( !$is_local)
 $ssl_verify = apply_filters('https_ssl_verify',$ssl_verify);
$timeout = (int)ceil($r['timeout']);
curl_setopt($handle,CURLOPT_CONNECTTIMEOUT,$timeout);
curl_setopt($handle,CURLOPT_TIMEOUT,$timeout);
curl_setopt($handle,CURLOPT_URL,$url);
curl_setopt($handle,CURLOPT_RETURNTRANSFER,true);
curl_setopt($handle,CURLOPT_SSL_VERIFYHOST,$ssl_verify);
curl_setopt($handle,CURLOPT_SSL_VERIFYPEER,$ssl_verify);
curl_setopt($handle,CURLOPT_USERAGENT,$r['user-agent']);
curl_setopt($handle,CURLOPT_MAXREDIRS,$r['redirection']);
switch ( $r['method'] ) {
case 'HEAD':curl_setopt($handle,CURLOPT_NOBODY,true);
break ;
case 'POST':curl_setopt($handle,CURLOPT_POST,true);
curl_setopt($handle,CURLOPT_POSTFIELDS,$r['body']);
break ;
case 'PUT':curl_setopt($handle,CURLOPT_CUSTOMREQUEST,'PUT');
curl_setopt($handle,CURLOPT_POSTFIELDS,$r['body']);
break ;
 }
if ( true === $r['blocking'])
 curl_setopt($handle,CURLOPT_HEADER,true);
else 
{curl_setopt($handle,CURLOPT_HEADER,false);
}if ( !ini_get('safe_mode') && !ini_get('open_basedir'))
 curl_setopt($handle,CURLOPT_FOLLOWLOCATION,true);
if ( !empty($r['headers']))
 {$headers = array();
foreach ( $r['headers'] as $name =>$value )
{$headers[] = "{$name}: $value";
}curl_setopt($handle,CURLOPT_HTTPHEADER,$headers);
}if ( $r['httpversion'] == '1.0')
 curl_setopt($handle,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_0);
else 
{curl_setopt($handle,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
}do_action_ref_array('http_api_curl',array($handle));
if ( !$r['blocking'])
 {curl_exec($handle);
curl_close($handle);
{$AspisRetTemp = array('headers' => array(),'body' => '','response' => array('code' => false,'message' => false),'cookies' => array());
return $AspisRetTemp;
}}$theResponse = curl_exec($handle);
if ( !empty($theResponse))
 {$headerLength = curl_getinfo($handle,CURLINFO_HEADER_SIZE);
$theHeaders = trim(substr($theResponse,0,$headerLength));
$theBody = substr($theResponse,$headerLength);
if ( false !== strrpos($theHeaders,"\r\n\r\n"))
 {$headerParts = explode("\r\n\r\n",$theHeaders);
$theHeaders = $headerParts[count($headerParts) - 1];
}$theHeaders = WP_Http::processHeaders($theHeaders);
}else 
{{if ( $curl_error = curl_error($handle))
 {$AspisRetTemp = new WP_Error('http_request_failed',$curl_error);
return $AspisRetTemp;
}if ( in_array(curl_getinfo($handle,CURLINFO_HTTP_CODE),array(301,302)))
 {$AspisRetTemp = new WP_Error('http_request_failed',__('Too many redirects.'));
return $AspisRetTemp;
}$theHeaders = array('headers' => array(),'cookies' => array());
$theBody = '';
}}$response = array();
$response['code'] = curl_getinfo($handle,CURLINFO_HTTP_CODE);
$response['message'] = get_status_header_desc($response['code']);
curl_close($handle);
if ( true === $r['decompress'] && true === WP_Http_Encoding::should_decode($theHeaders['headers']))
 $theBody = WP_Http_Encoding::decompress($theBody);
{$AspisRetTemp = array('headers' => $theHeaders['headers'],'body' => $theBody,'response' => $response,'cookies' => $theHeaders['cookies']);
return $AspisRetTemp;
}} }
function test ( $args = array() ) {
{if ( function_exists('curl_init') && function_exists('curl_exec'))
 {$AspisRetTemp = apply_filters('use_curl_transport',true,$args);
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
}class WP_HTTP_Proxy{function is_enabled (  ) {
{{$AspisRetTemp = defined('WP_PROXY_HOST') && defined('WP_PROXY_PORT');
return $AspisRetTemp;
}} }
function use_authentication (  ) {
{{$AspisRetTemp = defined('WP_PROXY_USERNAME') && defined('WP_PROXY_PASSWORD');
return $AspisRetTemp;
}} }
function host (  ) {
{if ( defined('WP_PROXY_HOST'))
 {$AspisRetTemp = WP_PROXY_HOST;
return $AspisRetTemp;
}{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function port (  ) {
{if ( defined('WP_PROXY_PORT'))
 {$AspisRetTemp = WP_PROXY_PORT;
return $AspisRetTemp;
}{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function username (  ) {
{if ( defined('WP_PROXY_USERNAME'))
 {$AspisRetTemp = WP_PROXY_USERNAME;
return $AspisRetTemp;
}{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function password (  ) {
{if ( defined('WP_PROXY_PASSWORD'))
 {$AspisRetTemp = WP_PROXY_PASSWORD;
return $AspisRetTemp;
}{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function authentication (  ) {
{{$AspisRetTemp = $this->username() . ':' . $this->password();
return $AspisRetTemp;
}} }
function authentication_header (  ) {
{{$AspisRetTemp = 'Proxy-Authentication: Basic ' . base64_encode($this->authentication());
return $AspisRetTemp;
}} }
function send_through_proxy ( $uri ) {
{$check = @parse_url($uri);
if ( $check === false)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}$home = parse_url(get_option('siteurl'));
if ( $check['host'] == 'localhost' || $check['host'] == $home['host'])
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !defined('WP_PROXY_BYPASS_HOSTS'))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}static $bypass_hosts;
if ( null == $bypass_hosts)
 $bypass_hosts = preg_split('|,\s*|',WP_PROXY_BYPASS_HOSTS);
{$AspisRetTemp = !in_array($check['host'],$bypass_hosts);
return $AspisRetTemp;
}} }
}class WP_Http_Cookie{var $name;
var $value;
var $expires;
var $path;
var $domain;
function WP_Http_Cookie ( $data ) {
{$this->__construct($data);
} }
function __construct ( $data ) {
{if ( is_string($data))
 {$pairs = explode(';',$data);
$name = trim(substr($pairs[0],0,strpos($pairs[0],'=')));
$value = substr($pairs[0],strpos($pairs[0],'=') + 1);
$this->name = $name;
$this->value = urldecode($value);
array_shift($pairs);
foreach ( $pairs as $pair  )
{if ( empty($pair))
 continue ;
list($key,$val) = explode('=',$pair);
$key = strtolower(trim($key));
if ( 'expires' == $key)
 $val = strtotime($val);
$this->$key = $val;
}}else 
{{if ( !isset($data['name']))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$this->name = $data['name'];
$this->value = isset($data['value']) ? $data['value'] : '';
$this->path = isset($data['path']) ? $data['path'] : '';
$this->domain = isset($data['domain']) ? $data['domain'] : '';
if ( isset($data['expires']))
 $this->expires = is_int($data['expires']) ? $data['expires'] : strtotime($data['expires']);
else 
{$this->expires = null;
}}}} }
function test ( $url ) {
{if ( time() > $this->expires)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$url = parse_url($url);
$url['port'] = isset($url['port']) ? $url['port'] : 80;
$url['path'] = isset($url['path']) ? $url['path'] : '/';
$path = isset($this->path) ? $this->path : '/';
$port = isset($this->port) ? $this->port : 80;
$domain = isset($this->domain) ? strtolower($this->domain) : strtolower($url['host']);
if ( false === stripos($domain,'.'))
 $domain .= '.local';
$domain = substr($domain,0,1) == '.' ? substr($domain,1) : $domain;
if ( substr($url['host'],-strlen($domain)) != $domain)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !in_array($url['port'],explode(',',$port)))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( substr($url['path'],0,strlen($path)) != $path)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function getHeaderValue (  ) {
{if ( empty($this->name) || empty($this->value))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = $this->name . '=' . urlencode($this->value);
return $AspisRetTemp;
}} }
function getFullHeader (  ) {
{{$AspisRetTemp = 'Cookie: ' . $this->getHeaderValue();
return $AspisRetTemp;
}} }
}class WP_Http_Encoding{function compress ( $raw,$level = 9,$supports = null ) {
{{$AspisRetTemp = gzdeflate($raw,$level);
return $AspisRetTemp;
}} }
function decompress ( $compressed,$length = null ) {
{if ( false !== ($decompressed = @gzinflate($compressed)))
 {$AspisRetTemp = $decompressed;
return $AspisRetTemp;
}if ( false !== ($decompressed = WP_Http_Encoding::compatible_gzinflate($compressed)))
 {$AspisRetTemp = $decompressed;
return $AspisRetTemp;
}if ( false !== ($decompressed = @gzuncompress($compressed)))
 {$AspisRetTemp = $decompressed;
return $AspisRetTemp;
}if ( function_exists('gzdecode'))
 {$decompressed = @gzdecode($compressed);
if ( false !== $decompressed)
 {$AspisRetTemp = $decompressed;
return $AspisRetTemp;
}}{$AspisRetTemp = $compressed;
return $AspisRetTemp;
}} }
function compatible_gzinflate ( $gzData ) {
{if ( substr($gzData,0,3) == "\x1f\x8b\x08")
 {$i = 10;
$flg = ord(substr($gzData,3,1));
if ( $flg > 0)
 {if ( $flg & 4)
 {list($xlen) = unpack('v',substr($gzData,$i,2));
$i = $i + 2 + $xlen;
}if ( $flg & 8)
 $i = strpos($gzData,"\0",$i) + 1;
if ( $flg & 16)
 $i = strpos($gzData,"\0",$i) + 1;
if ( $flg & 2)
 $i = $i + 2;
}{$AspisRetTemp = gzinflate(substr($gzData,$i,-8));
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = false;
return $AspisRetTemp;
}}}} }
function accept_encoding (  ) {
{$type = array();
if ( function_exists('gzinflate'))
 $type[] = 'deflate;q=1.0';
if ( function_exists('gzuncompress'))
 $type[] = 'compress;q=0.5';
if ( function_exists('gzdecode'))
 $type[] = 'gzip;q=0.5';
{$AspisRetTemp = implode(', ',$type);
return $AspisRetTemp;
}} }
function content_encoding (  ) {
{{$AspisRetTemp = 'deflate';
return $AspisRetTemp;
}} }
function should_decode ( $headers ) {
{if ( is_array($headers))
 {if ( array_key_exists('content-encoding',$headers) && !empty($headers['content-encoding']))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}}else 
{if ( is_string($headers))
 {{$AspisRetTemp = (stripos($headers,'content-encoding:') !== false);
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function is_available (  ) {
{{$AspisRetTemp = (function_exists('gzuncompress') || function_exists('gzdeflate') || function_exists('gzinflate'));
return $AspisRetTemp;
}} }
}function &_wp_http_get_object (  ) {
static $http;
if ( is_null($http))
 $http = new WP_Http();
{$AspisRetTemp = &$http;
return $AspisRetTemp;
} }
function wp_remote_request ( $url,$args = array() ) {
$objFetchSite = _wp_http_get_object();
{$AspisRetTemp = $objFetchSite->request($url,$args);
return $AspisRetTemp;
} }
function wp_remote_get ( $url,$args = array() ) {
$objFetchSite = _wp_http_get_object();
{$AspisRetTemp = $objFetchSite->get($url,$args);
return $AspisRetTemp;
} }
function wp_remote_post ( $url,$args = array() ) {
$objFetchSite = _wp_http_get_object();
{$AspisRetTemp = $objFetchSite->post($url,$args);
return $AspisRetTemp;
} }
function wp_remote_head ( $url,$args = array() ) {
$objFetchSite = _wp_http_get_object();
{$AspisRetTemp = $objFetchSite->head($url,$args);
return $AspisRetTemp;
} }
function wp_remote_retrieve_headers ( &$response ) {
if ( is_wp_error($response) || !isset($response['headers']) || !is_array($response['headers']))
 {$AspisRetTemp = array();
return $AspisRetTemp;
}{$AspisRetTemp = $response['headers'];
return $AspisRetTemp;
} }
function wp_remote_retrieve_header ( &$response,$header ) {
if ( is_wp_error($response) || !isset($response['headers']) || !is_array($response['headers']))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}if ( array_key_exists($header,$response['headers']))
 {$AspisRetTemp = $response['headers'][$header];
return $AspisRetTemp;
}{$AspisRetTemp = '';
return $AspisRetTemp;
} }
function wp_remote_retrieve_response_code ( &$response ) {
if ( is_wp_error($response) || !isset($response['response']) || !is_array($response['response']))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = $response['response']['code'];
return $AspisRetTemp;
} }
function wp_remote_retrieve_response_message ( &$response ) {
if ( is_wp_error($response) || !isset($response['response']) || !is_array($response['response']))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = $response['response']['message'];
return $AspisRetTemp;
} }
function wp_remote_retrieve_body ( &$response ) {
if ( is_wp_error($response) || !isset($response['body']))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = $response['body'];
return $AspisRetTemp;
} }
;
?>
<?php 