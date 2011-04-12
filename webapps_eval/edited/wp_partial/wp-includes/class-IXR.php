<?php require_once('AspisMain.php'); ?><?php
class IXR_Value{var $data;
var $type;
function IXR_Value ( $data,$type = false ) {
{$this->data = $data;
if ( !$type)
 {$type = $this->calculateType();
}$this->type = $type;
if ( $type == 'struct')
 {foreach ( $this->data as $key =>$value )
{$this->data[$key] = new IXR_Value($value);
}}if ( $type == 'array')
 {for ( $i = 0,$j = count($this->data) ; $i < $j ; $i++ )
{$this->data[$i] = new IXR_Value($this->data[$i]);
}}} }
function calculateType (  ) {
{if ( $this->data === true || $this->data === false)
 {{$AspisRetTemp = 'boolean';
return $AspisRetTemp;
}}if ( is_integer($this->data))
 {{$AspisRetTemp = 'int';
return $AspisRetTemp;
}}if ( is_double($this->data))
 {{$AspisRetTemp = 'double';
return $AspisRetTemp;
}}if ( is_object($this->data) && is_a($this->data,'IXR_Date'))
 {{$AspisRetTemp = 'date';
return $AspisRetTemp;
}}if ( is_object($this->data) && is_a($this->data,'IXR_Base64'))
 {{$AspisRetTemp = 'base64';
return $AspisRetTemp;
}}if ( is_object($this->data))
 {$this->data = get_object_vars($this->data);
{$AspisRetTemp = 'struct';
return $AspisRetTemp;
}}if ( !is_array($this->data))
 {{$AspisRetTemp = 'string';
return $AspisRetTemp;
}}if ( $this->isStruct($this->data))
 {{$AspisRetTemp = 'struct';
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = 'array';
return $AspisRetTemp;
}}}} }
function getXml (  ) {
{switch ( $this->type ) {
case 'boolean':{$AspisRetTemp = '<boolean>' . (($this->data) ? '1' : '0') . '</boolean>';
return $AspisRetTemp;
}break ;
case 'int':{$AspisRetTemp = '<int>' . $this->data . '</int>';
return $AspisRetTemp;
}break ;
case 'double':{$AspisRetTemp = '<double>' . $this->data . '</double>';
return $AspisRetTemp;
}break ;
case 'string':{$AspisRetTemp = '<string>' . htmlspecialchars($this->data) . '</string>';
return $AspisRetTemp;
}break ;
case 'array':$return = '<array><data>' . "\n";
foreach ( $this->data as $item  )
{$return .= '  <value>' . $item->getXml() . "</value>\n";
}$return .= '</data></array>';
{$AspisRetTemp = $return;
return $AspisRetTemp;
}break ;
case 'struct':$return = '<struct>' . "\n";
foreach ( $this->data as $name =>$value )
{$name = htmlspecialchars($name);
$return .= "  <member><name>$name</name><value>";
$return .= $value->getXml() . "</value></member>\n";
}$return .= '</struct>';
{$AspisRetTemp = $return;
return $AspisRetTemp;
}break ;
case 'date':case 'base64':{$AspisRetTemp = $this->data->getXml();
return $AspisRetTemp;
}break ;
 }
{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function isStruct ( $array ) {
{$expected = 0;
foreach ( $array as $key =>$value )
{if ( (string)$key != (string)$expected)
 {{$AspisRetTemp = true;
return $AspisRetTemp;
}}$expected++;
}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
}class IXR_Message{var $message;
var $messageType;
var $faultCode;
var $faultString;
var $methodName;
var $params;
var $_arraystructs = array();
var $_arraystructstypes = array();
var $_currentStructName = array();
var $_param;
var $_value;
var $_currentTag;
var $_currentTagContents;
var $_parser;
function IXR_Message ( &$message ) {
{$this->message = &$message;
} }
function parse (  ) {
{$header = preg_replace('/<\?xml.*?\?' . '>/','',substr($this->message,0,100),1);
$this->message = substr_replace($this->message,$header,0,100);
if ( trim($this->message) == '')
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->_parser = xml_parser_create();
xml_parser_set_option($this->_parser,XML_OPTION_CASE_FOLDING,false);
xml_set_object($this->_parser,$this);
xml_set_element_handler($this->_parser,'tag_open','tag_close');
xml_set_character_data_handler($this->_parser,'cdata');
$chunk_size = 262144;
do {if ( strlen($this->message) <= $chunk_size)
 $final = true;
$part = substr($this->message,0,$chunk_size);
$this->message = substr($this->message,$chunk_size);
if ( !xml_parse($this->_parser,$part,$final))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( $final)
 break ;
}while (true )
;
xml_parser_free($this->_parser);
if ( $this->messageType == 'fault')
 {$this->faultCode = $this->params[0]['faultCode'];
$this->faultString = $this->params[0]['faultString'];
}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function tag_open ( $parser,$tag,$attr ) {
{$this->_currentTagContents = '';
$this->currentTag = $tag;
switch ( $tag ) {
case 'methodCall':case 'methodResponse':case 'fault':$this->messageType = $tag;
break ;
case 'data':$this->_arraystructstypes[] = 'array';
$this->_arraystructs[] = array();
break ;
case 'struct':$this->_arraystructstypes[] = 'struct';
$this->_arraystructs[] = array();
break ;
 }
} }
function cdata ( $parser,$cdata ) {
{$this->_currentTagContents .= $cdata;
} }
function tag_close ( $parser,$tag ) {
{$valueFlag = false;
switch ( $tag ) {
case 'int':case 'i4':$value = (int)trim($this->_currentTagContents);
$valueFlag = true;
break ;
case 'double':$value = (double)trim($this->_currentTagContents);
$valueFlag = true;
break ;
case 'string':$value = $this->_currentTagContents;
$valueFlag = true;
break ;
case 'dateTime.iso8601':$value = new IXR_Date(trim($this->_currentTagContents));
$valueFlag = true;
break ;
case 'value':if ( trim($this->_currentTagContents) != '')
 {$value = (string)$this->_currentTagContents;
$valueFlag = true;
}break ;
case 'boolean':$value = (bool)trim($this->_currentTagContents);
$valueFlag = true;
break ;
case 'base64':$value = base64_decode(trim($this->_currentTagContents));
$valueFlag = true;
break ;
case 'data':case 'struct':$value = array_pop($this->_arraystructs);
array_pop($this->_arraystructstypes);
$valueFlag = true;
break ;
case 'member':array_pop($this->_currentStructName);
break ;
case 'name':$this->_currentStructName[] = trim($this->_currentTagContents);
break ;
case 'methodName':$this->methodName = trim($this->_currentTagContents);
break ;
 }
if ( $valueFlag)
 {if ( count($this->_arraystructs) > 0)
 {if ( $this->_arraystructstypes[count($this->_arraystructstypes) - 1] == 'struct')
 {$this->_arraystructs[count($this->_arraystructs) - 1][$this->_currentStructName[count($this->_currentStructName) - 1]] = $value;
}else 
{{$this->_arraystructs[count($this->_arraystructs) - 1][] = $value;
}}}else 
{{$this->params[] = $value;
}}}$this->_currentTagContents = '';
} }
}class IXR_Server{var $data;
var $callbacks = array();
var $message;
var $capabilities;
function IXR_Server ( $callbacks = false,$data = false ) {
{$this->setCapabilities();
if ( $callbacks)
 {$this->callbacks = $callbacks;
}$this->setCallbacks();
$this->serve($data);
} }
function serve ( $data = false ) {
{if ( !$data)
 {{global $HTTP_RAW_POST_DATA;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $HTTP_RAW_POST_DATA,"\$HTTP_RAW_POST_DATA",$AspisChangesCache);
}if ( !$HTTP_RAW_POST_DATA)
 {header('Content-Type: text/plain');
exit('XML-RPC server accepts POST requests only.');
}$data = &$HTTP_RAW_POST_DATA;
}$this->message = new IXR_Message($data);
if ( !$this->message->parse())
 {$this->error(-32700,'parse error. not well formed');
}if ( $this->message->messageType != 'methodCall')
 {$this->error(-32600,'server error. invalid xml-rpc. not conforming to spec. Request must be a methodCall');
}$result = $this->call($this->message->methodName,$this->message->params);
if ( is_a($result,'IXR_Error'))
 {$this->error($result);
}$r = new IXR_Value($result);
$resultxml = $r->getXml();
$xml = <<<EOD
<methodResponse>
  <params>
    <param>
      <value>
        $resultxml
      </value>
    </param>
  </params>
</methodResponse>

EOD
;
$this->output($xml);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$HTTP_RAW_POST_DATA",$AspisChangesCache);
 }
function call ( $methodname,$args ) {
{if ( !$this->hasMethod($methodname))
 {{$AspisRetTemp = new IXR_Error(-32601,'server error. requested method ' . $methodname . ' does not exist.');
return $AspisRetTemp;
}}$method = $this->callbacks[$methodname];
if ( count($args) == 1)
 {$args = $args[0];
}if ( substr($method,0,5) == 'this:')
 {$method = substr($method,5);
if ( !method_exists($this,$method))
 {{$AspisRetTemp = new IXR_Error(-32601,'server error. requested class method "' . $method . '" does not exist.');
return $AspisRetTemp;
}}$result = AspisUntaintedDynamicCall(array($this,$method),$args);
}else 
{{if ( is_array($method))
 {if ( !method_exists($method[0],$method[1]))
 {{$AspisRetTemp = new IXR_Error(-32601,'server error. requested object method "' . $method[1] . '" does not exist.');
return $AspisRetTemp;
}}}else 
{if ( !function_exists($method))
 {{$AspisRetTemp = new IXR_Error(-32601,'server error. requested function "' . $method . '" does not exist.');
return $AspisRetTemp;
}}}$result = AspisUntainted_call_user_func($method,$args);
}}{$AspisRetTemp = $result;
return $AspisRetTemp;
}} }
function error ( $error,$message = false ) {
{if ( $message && !is_object($error))
 {$error = new IXR_Error($error,$message);
}$this->output($error->getXml());
} }
function output ( $xml ) {
{$xml = '<?xml version="1.0"?>' . "\n" . $xml;
$length = strlen($xml);
header('Connection: close');
header('Content-Length: ' . $length);
header('Content-Type: text/xml');
header('Date: ' . date('r'));
echo $xml;
exit();
} }
function hasMethod ( $method ) {
{{$AspisRetTemp = in_array($method,array_keys($this->callbacks));
return $AspisRetTemp;
}} }
function setCapabilities (  ) {
{$this->capabilities = array('xmlrpc' => array('specUrl' => 'http://www.xmlrpc.com/spec','specVersion' => 1),'faults_interop' => array('specUrl' => 'http://xmlrpc-epi.sourceforge.net/specs/rfc.fault_codes.php','specVersion' => 20010516),'system.multicall' => array('specUrl' => 'http://www.xmlrpc.com/discuss/msgReader$1208','specVersion' => 1),);
} }
function getCapabilities ( $args ) {
{{$AspisRetTemp = $this->capabilities;
return $AspisRetTemp;
}} }
function setCallbacks (  ) {
{$this->callbacks['system.getCapabilities'] = 'this:getCapabilities';
$this->callbacks['system.listMethods'] = 'this:listMethods';
$this->callbacks['system.multicall'] = 'this:multiCall';
} }
function listMethods ( $args ) {
{{$AspisRetTemp = array_reverse(array_keys($this->callbacks));
return $AspisRetTemp;
}} }
function multiCall ( $methodcalls ) {
{$return = array();
foreach ( $methodcalls as $call  )
{$method = $call['methodName'];
$params = $call['params'];
if ( $method == 'system.multicall')
 {$result = new IXR_Error(-32600,'Recursive calls to system.multicall are forbidden');
}else 
{{$result = $this->call($method,$params);
}}if ( is_a($result,'IXR_Error'))
 {$return[] = array('faultCode' => $result->code,'faultString' => $result->message);
}else 
{{$return[] = array($result);
}}}{$AspisRetTemp = $return;
return $AspisRetTemp;
}} }
}class IXR_Request{var $method;
var $args;
var $xml;
function IXR_Request ( $method,$args ) {
{$this->method = $method;
$this->args = $args;
$this->xml = <<<EOD
<?xml version="1.0"?>
<methodCall>
<methodName>{$this->method}</methodName>
<params>

EOD
;
foreach ( $this->args as $arg  )
{$this->xml .= '<param><value>';
$v = new IXR_Value($arg);
$this->xml .= $v->getXml();
$this->xml .= "</value></param>\n";
}$this->xml .= '</params></methodCall>';
} }
function getLength (  ) {
{{$AspisRetTemp = strlen($this->xml);
return $AspisRetTemp;
}} }
function getXml (  ) {
{{$AspisRetTemp = $this->xml;
return $AspisRetTemp;
}} }
}class IXR_Client{var $server;
var $port;
var $path;
var $useragent;
var $headers;
var $response;
var $message = false;
var $debug = false;
var $timeout;
var $error = false;
function IXR_Client ( $server,$path = false,$port = 80,$timeout = false ) {
{if ( !$path)
 {$bits = parse_url($server);
$this->server = $bits['host'];
$this->port = isset($bits['port']) ? $bits['port'] : 80;
$this->path = isset($bits['path']) ? $bits['path'] : '/';
if ( !$this->path)
 {$this->path = '/';
}}else 
{{$this->server = $server;
$this->path = $path;
$this->port = $port;
}}$this->useragent = 'The Incutio XML-RPC PHP Library';
$this->timeout = $timeout;
} }
function query (  ) {
{$args = func_get_args();
$method = array_shift($args);
$request = new IXR_Request($method,$args);
$length = $request->getLength();
$xml = $request->getXml();
$r = "\r\n";
$request = "POST {$this->path} HTTP/1.0$r";
$this->headers['Host'] = $this->server;
$this->headers['Content-Type'] = 'text/xml';
$this->headers['User-Agent'] = $this->useragent;
$this->headers['Content-Length'] = $length;
foreach ( $this->headers as $header =>$value )
{$request .= "{$header}: {$value}{$r}";
}$request .= $r;
$request .= $xml;
if ( $this->debug)
 {echo '<pre class="ixr_request">' . htmlspecialchars($request) . "\n</pre>\n\n";
}if ( $this->timeout)
 {$fp = @fsockopen($this->server,$this->port,$errno,$errstr,$this->timeout);
}else 
{{$fp = @fsockopen($this->server,$this->port,$errno,$errstr);
}}if ( !$fp)
 {$this->error = new IXR_Error(-32300,"transport error - could not open socket: $errno $errstr");
{$AspisRetTemp = false;
return $AspisRetTemp;
}}fputs($fp,$request);
$contents = '';
$debug_contents = '';
$gotFirstLine = false;
$gettingHeaders = true;
while ( !feof($fp) )
{$line = fgets($fp,4096);
if ( !$gotFirstLine)
 {if ( strstr($line,'200') === false)
 {$this->error = new IXR_Error(-32301,'transport error - HTTP status code was not 200');
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$gotFirstLine = true;
}if ( trim($line) == '')
 {$gettingHeaders = false;
}if ( !$gettingHeaders)
 {$contents .= trim($line);
}if ( $this->debug)
 {$debug_contents .= $line;
}}if ( $this->debug)
 {echo '<pre class="ixr_response">' . htmlspecialchars($debug_contents) . "\n</pre>\n\n";
}$this->message = new IXR_Message($contents);
if ( !$this->message->parse())
 {$this->error = new IXR_Error(-32700,'parse error. not well formed');
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( $this->message->messageType == 'fault')
 {$this->error = new IXR_Error($this->message->faultCode,$this->message->faultString);
{$AspisRetTemp = false;
return $AspisRetTemp;
}}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function getResponse (  ) {
{{$AspisRetTemp = $this->message->params[0];
return $AspisRetTemp;
}} }
function isError (  ) {
{{$AspisRetTemp = (is_object($this->error));
return $AspisRetTemp;
}} }
function getErrorCode (  ) {
{{$AspisRetTemp = $this->error->code;
return $AspisRetTemp;
}} }
function getErrorMessage (  ) {
{{$AspisRetTemp = $this->error->message;
return $AspisRetTemp;
}} }
}class IXR_Error{var $code;
var $message;
function IXR_Error ( $code,$message ) {
{$this->code = $code;
$this->message = htmlspecialchars($message);
} }
function getXml (  ) {
{$xml = <<<EOD
<methodResponse>
  <fault>
    <value>
      <struct>
        <member>
          <name>faultCode</name>
          <value><int>{$this->code}</int></value>
        </member>
        <member>
          <name>faultString</name>
          <value><string>{$this->message}</string></value>
        </member>
      </struct>
    </value>
  </fault>
</methodResponse>

EOD
;
{$AspisRetTemp = $xml;
return $AspisRetTemp;
}} }
}class IXR_Date{var $year;
var $month;
var $day;
var $hour;
var $minute;
var $second;
var $timezone;
function IXR_Date ( $time ) {
{if ( is_numeric($time))
 {$this->parseTimestamp($time);
}else 
{{$this->parseIso($time);
}}} }
function parseTimestamp ( $timestamp ) {
{$this->year = date('Y',$timestamp);
$this->month = date('m',$timestamp);
$this->day = date('d',$timestamp);
$this->hour = date('H',$timestamp);
$this->minute = date('i',$timestamp);
$this->second = date('s',$timestamp);
$this->timezone = '';
} }
function parseIso ( $iso ) {
{$this->year = substr($iso,0,4);
$this->month = substr($iso,4,2);
$this->day = substr($iso,6,2);
$this->hour = substr($iso,9,2);
$this->minute = substr($iso,12,2);
$this->second = substr($iso,15,2);
$this->timezone = substr($iso,17);
} }
function getIso (  ) {
{{$AspisRetTemp = $this->year . $this->month . $this->day . 'T' . $this->hour . ':' . $this->minute . ':' . $this->second . $this->timezone;
return $AspisRetTemp;
}} }
function getXml (  ) {
{{$AspisRetTemp = '<dateTime.iso8601>' . $this->getIso() . '</dateTime.iso8601>';
return $AspisRetTemp;
}} }
function getTimestamp (  ) {
{{$AspisRetTemp = mktime($this->hour,$this->minute,$this->second,$this->month,$this->day,$this->year);
return $AspisRetTemp;
}} }
}class IXR_Base64{var $data;
function IXR_Base64 ( $data ) {
{$this->data = $data;
} }
function getXml (  ) {
{{$AspisRetTemp = '<base64>' . base64_encode($this->data) . '</base64>';
return $AspisRetTemp;
}} }
}class IXR_IntrospectionServer extends IXR_Server{var $signatures;
var $help;
function IXR_IntrospectionServer (  ) {
{$this->setCallbacks();
$this->setCapabilities();
$this->capabilities['introspection'] = array('specUrl' => 'http://xmlrpc.usefulinc.com/doc/reserved.html','specVersion' => 1);
$this->addCallback('system.methodSignature','this:methodSignature',array('array','string'),'Returns an array describing the return type and required parameters of a method');
$this->addCallback('system.getCapabilities','this:getCapabilities',array('struct'),'Returns a struct describing the XML-RPC specifications supported by this server');
$this->addCallback('system.listMethods','this:listMethods',array('array'),'Returns an array of available methods on this server');
$this->addCallback('system.methodHelp','this:methodHelp',array('string','string'),'Returns a documentation string for the specified method');
} }
function addCallback ( $method,$callback,$args,$help ) {
{$this->callbacks[$method] = $callback;
$this->signatures[$method] = $args;
$this->help[$method] = $help;
} }
function call ( $methodname,$args ) {
{if ( $args && !is_array($args))
 {$args = array($args);
}if ( !$this->hasMethod($methodname))
 {{$AspisRetTemp = new IXR_Error(-32601,'server error. requested method "' . $this->message->methodName . '" not specified.');
return $AspisRetTemp;
}}$method = $this->callbacks[$methodname];
$signature = $this->signatures[$methodname];
$returnType = array_shift($signature);
if ( count($args) != count($signature))
 {{$AspisRetTemp = new IXR_Error(-32602,'server error. wrong number of method parameters');
return $AspisRetTemp;
}}$ok = true;
$argsbackup = $args;
for ( $i = 0,$j = count($args) ; $i < $j ; $i++ )
{$arg = array_shift($args);
$type = array_shift($signature);
switch ( $type ) {
case 'int':case 'i4':if ( is_array($arg) || !is_int($arg))
 {$ok = false;
}break ;
case 'base64':case 'string':if ( !is_string($arg))
 {$ok = false;
}break ;
case 'boolean':if ( $arg !== false && $arg !== true)
 {$ok = false;
}break ;
case 'float':case 'double':if ( !is_float($arg))
 {$ok = false;
}break ;
case 'date':case 'dateTime.iso8601':if ( !is_a($arg,'IXR_Date'))
 {$ok = false;
}break ;
 }
if ( !$ok)
 {{$AspisRetTemp = new IXR_Error(-32602,'server error. invalid method parameters');
return $AspisRetTemp;
}}}{$AspisRetTemp = parent::call($methodname,$argsbackup);
return $AspisRetTemp;
}} }
function methodSignature ( $method ) {
{if ( !$this->hasMethod($method))
 {{$AspisRetTemp = new IXR_Error(-32601,'server error. requested method "' . $method . '" not specified.');
return $AspisRetTemp;
}}$types = $this->signatures[$method];
$return = array();
foreach ( $types as $type  )
{switch ( $type ) {
case 'string':$return[] = 'string';
break ;
case 'int':case 'i4':$return[] = 42;
break ;
case 'double':$return[] = 3.1415;
break ;
case 'dateTime.iso8601':$return[] = new IXR_Date(time());
break ;
case 'boolean':$return[] = true;
break ;
case 'base64':$return[] = new IXR_Base64('base64');
break ;
case 'array':$return[] = array('array');
break ;
case 'struct':$return[] = array('struct' => 'struct');
break ;
 }
}{$AspisRetTemp = $return;
return $AspisRetTemp;
}} }
function methodHelp ( $method ) {
{{$AspisRetTemp = $this->help[$method];
return $AspisRetTemp;
}} }
}class IXR_ClientMulticall extends IXR_Client{var $calls = array();
function IXR_ClientMulticall ( $server,$path = false,$port = 80 ) {
{parent::IXR_Client($server,$path,$port);
$this->useragent = 'The Incutio XML-RPC PHP Library (multicall client)';
} }
function addCall (  ) {
{$args = func_get_args();
$methodName = array_shift($args);
$struct = array('methodName' => $methodName,'params' => $args);
$this->calls[] = $struct;
} }
function query (  ) {
{{$AspisRetTemp = parent::query('system.multicall',$this->calls);
return $AspisRetTemp;
}} }
};
?>
<?php 