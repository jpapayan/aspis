<?php require_once('AspisMain.php'); ?><?php
class IXR_Value{var $data;
var $type;
function IXR_Value ( $data,$type = array(false,false) ) {
{$this->data = $data;
if ( (denot_boolean($type)))
 {$type = $this->calculateType();
}$this->type = $type;
if ( ($type[0] == ('struct')))
 {foreach ( $this->data[0] as $key =>$value )
{restoreTaint($key,$value);
{arrayAssign($this->data[0],deAspis(registerTaint($key)),addTaint(array(new IXR_Value($value),false)));
}}}if ( ($type[0] == ('array')))
 {for ( $i = array(0,false),$j = attAspis(count($this->data[0])) ; ($i[0] < $j[0]) ; postincr($i) )
{arrayAssign($this->data[0],deAspis(registerTaint($i)),addTaint(array(new IXR_Value($this->data[0][$i[0]]),false)));
}}} }
function calculateType (  ) {
{if ( (($this->data[0] === true) || ($this->data[0] === false)))
 {return array('boolean',false);
}if ( (is_integer(deAspisRC($this->data))))
 {return array('int',false);
}if ( (is_double(deAspisRC($this->data))))
 {return array('double',false);
}if ( (is_object($this->data[0]) && is_a(deAspisRC($this->data),('IXR_Date'))))
 {return array('date',false);
}if ( (is_object($this->data[0]) && is_a(deAspisRC($this->data),('IXR_Base64'))))
 {return array('base64',false);
}if ( is_object($this->data[0]))
 {$this->data = attAspis(get_object_vars(deAspisRC($this->data)));
return array('struct',false);
}if ( (!(is_array($this->data[0]))))
 {return array('string',false);
}if ( deAspis($this->isStruct($this->data)))
 {return array('struct',false);
}else 
{{return array('array',false);
}}} }
function getXml (  ) {
{switch ( $this->type[0] ) {
case ('boolean'):return concat2(concat1('<boolean>',(deAspis(($this->data)) ? array('1',false) : array('0',false))),'</boolean>');
break ;
case ('int'):return concat2(concat1('<int>',$this->data),'</int>');
break ;
case ('double'):return concat2(concat1('<double>',$this->data),'</double>');
break ;
case ('string'):return concat2(concat1('<string>',Aspis_htmlspecialchars($this->data)),'</string>');
break ;
case ('array'):$return = concat12('<array><data>',"\n");
foreach ( $this->data[0] as $item  )
{$return = concat($return,concat2(concat1('  <value>',$item[0]->getXml()),"</value>\n"));
}$return = concat2($return,'</data></array>');
return $return;
break ;
case ('struct'):$return = concat12('<struct>',"\n");
foreach ( $this->data[0] as $name =>$value )
{restoreTaint($name,$value);
{$name = Aspis_htmlspecialchars($name);
$return = concat($return,concat2(concat1("  <member><name>",$name),"</name><value>"));
$return = concat($return,concat2($value[0]->getXml(),"</value></member>\n"));
}}$return = concat2($return,'</struct>');
return $return;
break ;
case ('date'):case ('base64'):return $this->data[0]->getXml();
break ;
 }
return array(false,false);
} }
function isStruct ( $array ) {
{$expected = array(0,false);
foreach ( $array[0] as $key =>$value )
{restoreTaint($key,$value);
{if ( (deAspis(string_cast($key)) != deAspis(string_cast($expected))))
 {return array(true,false);
}postincr($expected);
}}return array(false,false);
} }
}class IXR_Message{var $message;
var $messageType;
var $faultCode;
var $faultString;
var $methodName;
var $params;
var $_arraystructs = array(array(),false);
var $_arraystructstypes = array(array(),false);
var $_currentStructName = array(array(),false);
var $_param;
var $_value;
var $_currentTag;
var $_currentTagContents;
var $_parser;
function IXR_Message ( &$message ) {
{$this->message = &$message;
} }
function parse (  ) {
{$header = Aspis_preg_replace(concat12('/<\?xml.*?\?','>/'),array('',false),Aspis_substr($this->message,array(0,false),array(100,false)),array(1,false));
$this->message = Aspis_substr_replace($this->message,$header,array(0,false),array(100,false));
if ( (deAspis(Aspis_trim($this->message)) == ('')))
 {return array(false,false);
}$this->_parser = array(xml_parser_create(),false);
xml_parser_set_option($this->_parser[0],XML_OPTION_CASE_FOLDING,false);
Aspis_xml_set_object($this->_parser,array($this,false));
Aspis_xml_set_element_handler($this->_parser,array('tag_open',false),array('tag_close',false));
Aspis_xml_set_character_data_handler($this->_parser,array('cdata',false));
$chunk_size = array(262144,false);
do {if ( (strlen($this->message[0]) <= $chunk_size[0]))
 $final = array(true,false);
$part = Aspis_substr($this->message,array(0,false),$chunk_size);
$this->message = Aspis_substr($this->message,$chunk_size);
if ( (!(xml_parse($this->_parser[0],$part[0],$final[0]))))
 return array(false,false);
if ( $final[0])
 break ;
}while (true )
;
xml_parser_free(deAspisRC($this->_parser));
if ( ($this->messageType[0] == ('fault')))
 {$this->faultCode = $this->params[0][(0)][0][('faultCode')];
$this->faultString = $this->params[0][(0)][0][('faultString')];
}return array(true,false);
} }
function tag_open ( $parser,$tag,$attr ) {
{$this->_currentTagContents = array('',false);
$this->currentTag = $tag;
switch ( $tag[0] ) {
case ('methodCall'):case ('methodResponse'):case ('fault'):$this->messageType = $tag;
break ;
case ('data'):arrayAssignAdd($this->_arraystructstypes[0][],addTaint(array('array',false)));
arrayAssignAdd($this->_arraystructs[0][],addTaint(array(array(),false)));
break ;
case ('struct'):arrayAssignAdd($this->_arraystructstypes[0][],addTaint(array('struct',false)));
arrayAssignAdd($this->_arraystructs[0][],addTaint(array(array(),false)));
break ;
 }
} }
function cdata ( $parser,$cdata ) {
{$this->_currentTagContents = concat($this->_currentTagContents ,$cdata);
} }
function tag_close ( $parser,$tag ) {
{$valueFlag = array(false,false);
switch ( $tag[0] ) {
case ('int'):case ('i4'):$value = int_cast(Aspis_trim($this->_currentTagContents));
$valueFlag = array(true,false);
break ;
case ('double'):$value = float_cast(Aspis_trim($this->_currentTagContents));
$valueFlag = array(true,false);
break ;
case ('string'):$value = $this->_currentTagContents;
$valueFlag = array(true,false);
break ;
case ('dateTime.iso8601'):$value = array(new IXR_Date(Aspis_trim($this->_currentTagContents)),false);
$valueFlag = array(true,false);
break ;
case ('value'):if ( (deAspis(Aspis_trim($this->_currentTagContents)) != ('')))
 {$value = string_cast($this->_currentTagContents);
$valueFlag = array(true,false);
}break ;
case ('boolean'):$value = bool_cast(Aspis_trim($this->_currentTagContents));
$valueFlag = array(true,false);
break ;
case ('base64'):$value = Aspis_base64_decode(Aspis_trim($this->_currentTagContents));
$valueFlag = array(true,false);
break ;
case ('data'):case ('struct'):$value = Aspis_array_pop($this->_arraystructs);
Aspis_array_pop($this->_arraystructstypes);
$valueFlag = array(true,false);
break ;
case ('member'):Aspis_array_pop($this->_currentStructName);
break ;
case ('name'):arrayAssignAdd($this->_currentStructName[0][],addTaint(Aspis_trim($this->_currentTagContents)));
break ;
case ('methodName'):$this->methodName = Aspis_trim($this->_currentTagContents);
break ;
 }
if ( $valueFlag[0])
 {if ( (count($this->_arraystructs[0]) > (0)))
 {if ( ($this->_arraystructstypes[0][(count($this->_arraystructstypes[0]) - (1))][0] == ('struct')))
 {arrayAssign($this->_arraystructs[0][(count($this->_arraystructs[0]) - (1))][0],deAspis(registerTaint($this->_currentStructName[0][(count($this->_currentStructName[0]) - (1))])),addTaint($value));
}else 
{{arrayAssignAdd($this->_arraystructs[0][(count($this->_arraystructs[0]) - (1))][0][],addTaint($value));
}}}else 
{{arrayAssignAdd($this->params[0][],addTaint($value));
}}}$this->_currentTagContents = array('',false);
} }
}class IXR_Server{var $data;
var $callbacks = array(array(),false);
var $message;
var $capabilities;
function IXR_Server ( $callbacks = array(false,false),$data = array(false,false) ) {
{$this->setCapabilities();
if ( $callbacks[0])
 {$this->callbacks = $callbacks;
}$this->setCallbacks();
$this->serve($data);
} }
function serve ( $data = array(false,false) ) {
{if ( (denot_boolean($data)))
 {global $HTTP_RAW_POST_DATA;
if ( (denot_boolean($HTTP_RAW_POST_DATA)))
 {header(('Content-Type: text/plain'));
Aspis_exit(array('XML-RPC server accepts POST requests only.',false));
}$data = &$HTTP_RAW_POST_DATA;
}$this->message = array(new IXR_Message($data),false);
if ( (denot_boolean($this->message[0]->parse())))
 {$this->error(negate(array(32700,false)),array('parse error. not well formed',false));
}if ( ($this->message[0]->messageType[0] != ('methodCall')))
 {$this->error(negate(array(32600,false)),array('server error. invalid xml-rpc. not conforming to spec. Request must be a methodCall',false));
}$result = $this->call($this->message[0]->methodName,$this->message[0]->params);
if ( is_a(deAspisRC($result),('IXR_Error')))
 {$this->error($result);
}$r = array(new IXR_Value($result),false);
$resultxml = $r[0]->getXml();
$xml = concat2(concat1(<<<EOD_PHPAspis_Part0
<methodResponse>
  <params>
    <param>
      <value>
        
EOD_PHPAspis_Part0
,$resultxml),<<<EOD_PHPAspis_Part1

      </value>
    </param>
  </params>
</methodResponse>

EOD_PHPAspis_Part1
);
$this->output($xml);
} }
function call ( $methodname,$args ) {
{if ( (denot_boolean($this->hasMethod($methodname))))
 {return array(new IXR_Error(negate(array(32601,false)),concat2(concat1('server error. requested method ',$methodname),' does not exist.')),false);
}$method = $this->callbacks[0][$methodname[0]];
if ( (count($args[0]) == (1)))
 {$args = attachAspis($args,(0));
}if ( (deAspis(Aspis_substr($method,array(0,false),array(5,false))) == ('this:')))
 {$method = Aspis_substr($method,array(5,false));
if ( (!(method_exists(deAspisRC(array($this,false)),$method[0]))))
 {return array(new IXR_Error(negate(array(32601,false)),concat2(concat1('server error. requested class method "',$method),'" does not exist.')),false);
}$result = AspisDynamicCall(array(array($this,$method),false),$args);
}else 
{{if ( is_array($method[0]))
 {if ( (!(method_exists(deAspisRC(attachAspis($method,(0))),deAspis(attachAspis($method,(1)))))))
 {return array(new IXR_Error(negate(array(32601,false)),concat2(concat1('server error. requested object method "',attachAspis($method,(1))),'" does not exist.')),false);
}}else 
{if ( (!(function_exists($method[0]))))
 {return array(new IXR_Error(negate(array(32601,false)),concat2(concat1('server error. requested function "',$method),'" does not exist.')),false);
}}$result = Aspis_call_user_func($method,$args);
}}return $result;
} }
function error ( $error,$message = array(false,false) ) {
{if ( ($message[0] && (!(is_object($error[0])))))
 {$error = array(new IXR_Error($error,$message),false);
}$this->output($error[0]->getXml());
} }
function output ( $xml ) {
{$xml = concat(concat12('<?xml version="1.0"?>',"\n"),$xml);
$length = attAspis(strlen($xml[0]));
header(('Connection: close'));
header((deconcat1('Content-Length: ',$length)));
header(('Content-Type: text/xml'));
header((deconcat1('Date: ',attAspis(date(('r'))))));
echo AspisCheckPrint($xml);
Aspis_exit();
} }
function hasMethod ( $method ) {
{return Aspis_in_array($method,attAspisRC(array_keys(deAspisRC($this->callbacks))));
} }
function setCapabilities (  ) {
{$this->capabilities = array(array('xmlrpc' => array(array('specUrl' => array('http://www.xmlrpc.com/spec',false,false),'specVersion' => array(1,false,false)),false,false),'faults_interop' => array(array('specUrl' => array('http://xmlrpc-epi.sourceforge.net/specs/rfc.fault_codes.php',false,false),'specVersion' => array(20010516,false,false)),false,false),'system.multicall' => array(array('specUrl' => array('http://www.xmlrpc.com/discuss/msgReader$1208',false,false),'specVersion' => array(1,false,false)),false,false),),false);
} }
function getCapabilities ( $args ) {
{return $this->capabilities;
} }
function setCallbacks (  ) {
{arrayAssign($this->callbacks[0],deAspis(registerTaint(array('system.getCapabilities',false))),addTaint(array('this:getCapabilities',false)));
arrayAssign($this->callbacks[0],deAspis(registerTaint(array('system.listMethods',false))),addTaint(array('this:listMethods',false)));
arrayAssign($this->callbacks[0],deAspis(registerTaint(array('system.multicall',false))),addTaint(array('this:multiCall',false)));
} }
function listMethods ( $args ) {
{return Aspis_array_reverse(attAspisRC(array_keys(deAspisRC($this->callbacks))));
} }
function multiCall ( $methodcalls ) {
{$return = array(array(),false);
foreach ( $methodcalls[0] as $call  )
{$method = $call[0]['methodName'];
$params = $call[0]['params'];
if ( ($method[0] == ('system.multicall')))
 {$result = array(new IXR_Error(negate(array(32600,false)),array('Recursive calls to system.multicall are forbidden',false)),false);
}else 
{{$result = $this->call($method,$params);
}}if ( is_a(deAspisRC($result),('IXR_Error')))
 {arrayAssignAdd($return[0][],addTaint(array(array(deregisterTaint(array('faultCode',false)) => addTaint($result[0]->code),deregisterTaint(array('faultString',false)) => addTaint($result[0]->message)),false)));
}else 
{{arrayAssignAdd($return[0][],addTaint(array(array($result),false)));
}}}return $return;
} }
}class IXR_Request{var $method;
var $args;
var $xml;
function IXR_Request ( $method,$args ) {
{$this->method = $method;
$this->args = $args;
$this->xml = concat2(concat1(<<<EOD_PHPAspis_Part0
<?xml version="1.0"?>
<methodCall>
<methodName>
EOD_PHPAspis_Part0
,$this->method),<<<EOD_PHPAspis_Part1
</methodName>
<params>

EOD_PHPAspis_Part1
);
foreach ( $this->args[0] as $arg  )
{$this->xml = concat2($this->xml ,'<param><value>');
$v = array(new IXR_Value($arg),false);
$this->xml = concat($this->xml ,$v[0]->getXml());
$this->xml = concat2($this->xml ,"</value></param>\n");
}$this->xml = concat2($this->xml ,'</params></methodCall>');
} }
function getLength (  ) {
{return attAspis(strlen($this->xml[0]));
} }
function getXml (  ) {
{return $this->xml;
} }
}class IXR_Client{var $server;
var $port;
var $path;
var $useragent;
var $headers;
var $response;
var $message = array(false,false);
var $debug = array(false,false);
var $timeout;
var $error = array(false,false);
function IXR_Client ( $server,$path = array(false,false),$port = array(80,false),$timeout = array(false,false) ) {
{if ( (denot_boolean($path)))
 {$bits = Aspis_parse_url($server);
$this->server = $bits[0]['host'];
$this->port = ((isset($bits[0][('port')]) && Aspis_isset( $bits [0][('port')]))) ? $bits[0]['port'] : array(80,false);
$this->path = ((isset($bits[0][('path')]) && Aspis_isset( $bits [0][('path')]))) ? $bits[0]['path'] : array('/',false);
if ( (denot_boolean($this->path)))
 {$this->path = array('/',false);
}}else 
{{$this->server = $server;
$this->path = $path;
$this->port = $port;
}}$this->useragent = array('The Incutio XML-RPC PHP Library',false);
$this->timeout = $timeout;
} }
function query (  ) {
{$args = array(func_get_args(),false);
$method = Aspis_array_shift($args);
$request = array(new IXR_Request($method,$args),false);
$length = $request[0]->getLength();
$xml = $request[0]->getXml();
$r = array("\r\n",false);
$request = concat(concat2(concat1("POST ",$this->path)," HTTP/1.0"),$r);
arrayAssign($this->headers[0],deAspis(registerTaint(array('Host',false))),addTaint($this->server));
arrayAssign($this->headers[0],deAspis(registerTaint(array('Content-Type',false))),addTaint(array('text/xml',false)));
arrayAssign($this->headers[0],deAspis(registerTaint(array('User-Agent',false))),addTaint($this->useragent));
arrayAssign($this->headers[0],deAspis(registerTaint(array('Content-Length',false))),addTaint($length));
foreach ( $this->headers[0] as $header =>$value )
{restoreTaint($header,$value);
{$request = concat($request,concat(concat2($header,": "),$value));
}}$request = concat($request,$r);
$request = concat($request,$xml);
if ( $this->debug[0])
 {echo AspisCheckPrint(concat2(concat1('<pre class="ixr_request">',Aspis_htmlspecialchars($request)),"\n</pre>\n\n"));
}if ( $this->timeout[0])
 {$fp = @AspisInternalFunctionCall("fsockopen",$this->server[0],$this->port[0],AspisPushRefParam($errno),AspisPushRefParam($errstr),$this->timeout[0],array(2,3));
}else 
{{$fp = @AspisInternalFunctionCall("fsockopen",$this->server[0],$this->port[0],AspisPushRefParam($errno),AspisPushRefParam($errstr),array(2,3));
}}if ( (denot_boolean($fp)))
 {$this->error = array(new IXR_Error(negate(array(32300,false)),concat(concat2(concat1("transport error - could not open socket: ",$errno)," "),$errstr)),false);
return array(false,false);
}fputs($fp[0],$request[0]);
$contents = array('',false);
$debug_contents = array('',false);
$gotFirstLine = array(false,false);
$gettingHeaders = array(true,false);
while ( (!(feof($fp[0]))) )
{$line = attAspis(fgets($fp[0],(4096)));
if ( (denot_boolean($gotFirstLine)))
 {if ( (deAspis(Aspis_strstr($line,array('200',false))) === false))
 {$this->error = array(new IXR_Error(negate(array(32301,false)),array('transport error - HTTP status code was not 200',false)),false);
return array(false,false);
}$gotFirstLine = array(true,false);
}if ( (deAspis(Aspis_trim($line)) == ('')))
 {$gettingHeaders = array(false,false);
}if ( (denot_boolean($gettingHeaders)))
 {$contents = concat($contents,Aspis_trim($line));
}if ( $this->debug[0])
 {$debug_contents = concat($debug_contents,$line);
}}if ( $this->debug[0])
 {echo AspisCheckPrint(concat2(concat1('<pre class="ixr_response">',Aspis_htmlspecialchars($debug_contents)),"\n</pre>\n\n"));
}$this->message = array(new IXR_Message($contents),false);
if ( (denot_boolean($this->message[0]->parse())))
 {$this->error = array(new IXR_Error(negate(array(32700,false)),array('parse error. not well formed',false)),false);
return array(false,false);
}if ( ($this->message[0]->messageType[0] == ('fault')))
 {$this->error = array(new IXR_Error($this->message[0]->faultCode,$this->message[0]->faultString),false);
return array(false,false);
}return array(true,false);
} }
function getResponse (  ) {
{return $this->message[0]->params[0][(0)];
} }
function isError (  ) {
{return (attAspis(is_object($this->error[0])));
} }
function getErrorCode (  ) {
{return $this->error[0]->code;
} }
function getErrorMessage (  ) {
{return $this->error[0]->message;
} }
}class IXR_Error{var $code;
var $message;
function IXR_Error ( $code,$message ) {
{$this->code = $code;
$this->message = Aspis_htmlspecialchars($message);
} }
function getXml (  ) {
{$xml = concat2(concat(concat2(concat1(<<<EOD_PHPAspis_Part0
<methodResponse>
  <fault>
    <value>
      <struct>
        <member>
          <name>faultCode</name>
          <value><int>
EOD_PHPAspis_Part0
,$this->code),<<<EOD_PHPAspis_Part1
</int></value>
        </member>
        <member>
          <name>faultString</name>
          <value><string>
EOD_PHPAspis_Part1
),$this->message),<<<EOD_PHPAspis_Part2
</string></value>
        </member>
      </struct>
    </value>
  </fault>
</methodResponse>

EOD_PHPAspis_Part2
);
return $xml;
} }
}class IXR_Date{var $year;
var $month;
var $day;
var $hour;
var $minute;
var $second;
var $timezone;
function IXR_Date ( $time ) {
{if ( is_numeric(deAspisRC($time)))
 {$this->parseTimestamp($time);
}else 
{{$this->parseIso($time);
}}} }
function parseTimestamp ( $timestamp ) {
{$this->year = attAspis(date(('Y'),$timestamp[0]));
$this->month = attAspis(date(('m'),$timestamp[0]));
$this->day = attAspis(date(('d'),$timestamp[0]));
$this->hour = attAspis(date(('H'),$timestamp[0]));
$this->minute = attAspis(date(('i'),$timestamp[0]));
$this->second = attAspis(date(('s'),$timestamp[0]));
$this->timezone = array('',false);
} }
function parseIso ( $iso ) {
{$this->year = Aspis_substr($iso,array(0,false),array(4,false));
$this->month = Aspis_substr($iso,array(4,false),array(2,false));
$this->day = Aspis_substr($iso,array(6,false),array(2,false));
$this->hour = Aspis_substr($iso,array(9,false),array(2,false));
$this->minute = Aspis_substr($iso,array(12,false),array(2,false));
$this->second = Aspis_substr($iso,array(15,false),array(2,false));
$this->timezone = Aspis_substr($iso,array(17,false));
} }
function getIso (  ) {
{return concat(concat(concat2(concat(concat2(concat(concat2(concat(concat($this->year,$this->month),$this->day),'T'),$this->hour),':'),$this->minute),':'),$this->second),$this->timezone);
} }
function getXml (  ) {
{return concat2(concat1('<dateTime.iso8601>',$this->getIso()),'</dateTime.iso8601>');
} }
function getTimestamp (  ) {
{return attAspis(mktime($this->hour[0],$this->minute[0],$this->second[0],$this->month[0],$this->day[0],$this->year[0]));
} }
}class IXR_Base64{var $data;
function IXR_Base64 ( $data ) {
{$this->data = $data;
} }
function getXml (  ) {
{return concat2(concat1('<base64>',Aspis_base64_encode($this->data)),'</base64>');
} }
}class IXR_IntrospectionServer extends IXR_Server{var $signatures;
var $help;
function IXR_IntrospectionServer (  ) {
{$this->setCallbacks();
$this->setCapabilities();
arrayAssign($this->capabilities[0],deAspis(registerTaint(array('introspection',false))),addTaint(array(array('specUrl' => array('http://xmlrpc.usefulinc.com/doc/reserved.html',false,false),'specVersion' => array(1,false,false)),false)));
$this->addCallback(array('system.methodSignature',false),array('this:methodSignature',false),array(array(array('array',false),array('string',false)),false),array('Returns an array describing the return type and required parameters of a method',false));
$this->addCallback(array('system.getCapabilities',false),array('this:getCapabilities',false),array(array(array('struct',false)),false),array('Returns a struct describing the XML-RPC specifications supported by this server',false));
$this->addCallback(array('system.listMethods',false),array('this:listMethods',false),array(array(array('array',false)),false),array('Returns an array of available methods on this server',false));
$this->addCallback(array('system.methodHelp',false),array('this:methodHelp',false),array(array(array('string',false),array('string',false)),false),array('Returns a documentation string for the specified method',false));
} }
function addCallback ( $method,$callback,$args,$help ) {
{arrayAssign($this->callbacks[0],deAspis(registerTaint($method)),addTaint($callback));
arrayAssign($this->signatures[0],deAspis(registerTaint($method)),addTaint($args));
arrayAssign($this->help[0],deAspis(registerTaint($method)),addTaint($help));
} }
function call ( $methodname,$args ) {
{if ( ($args[0] && (!(is_array($args[0])))))
 {$args = array(array($args),false);
}if ( (denot_boolean($this->hasMethod($methodname))))
 {return array(new IXR_Error(negate(array(32601,false)),concat2(concat1('server error. requested method "',$this->message[0]->methodName),'" not specified.')),false);
}$method = $this->callbacks[0][$methodname[0]];
$signature = $this->signatures[0][$methodname[0]];
$returnType = Aspis_array_shift($signature);
if ( (count($args[0]) != count($signature[0])))
 {return array(new IXR_Error(negate(array(32602,false)),array('server error. wrong number of method parameters',false)),false);
}$ok = array(true,false);
$argsbackup = $args;
for ( $i = array(0,false),$j = attAspis(count($args[0])) ; ($i[0] < $j[0]) ; postincr($i) )
{$arg = Aspis_array_shift($args);
$type = Aspis_array_shift($signature);
switch ( $type[0] ) {
case ('int'):case ('i4'):if ( (is_array($arg[0]) || (!(is_int(deAspisRC($arg))))))
 {$ok = array(false,false);
}break ;
case ('base64'):case ('string'):if ( (!(is_string(deAspisRC($arg)))))
 {$ok = array(false,false);
}break ;
case ('boolean'):if ( (($arg[0] !== false) && ($arg[0] !== true)))
 {$ok = array(false,false);
}break ;
case ('float'):case ('double'):if ( (!(is_float(deAspisRC($arg)))))
 {$ok = array(false,false);
}break ;
case ('date'):case ('dateTime.iso8601'):if ( (!(is_a(deAspisRC($arg),('IXR_Date')))))
 {$ok = array(false,false);
}break ;
 }
if ( (denot_boolean($ok)))
 {return array(new IXR_Error(negate(array(32602,false)),array('server error. invalid method parameters',false)),false);
}}return parent::call($methodname,$argsbackup);
} }
function methodSignature ( $method ) {
{if ( (denot_boolean($this->hasMethod($method))))
 {return array(new IXR_Error(negate(array(32601,false)),concat2(concat1('server error. requested method "',$method),'" not specified.')),false);
}$types = $this->signatures[0][$method[0]];
$return = array(array(),false);
foreach ( $types[0] as $type  )
{switch ( $type[0] ) {
case ('string'):arrayAssignAdd($return[0][],addTaint(array('string',false)));
break ;
case ('int'):case ('i4'):arrayAssignAdd($return[0][],addTaint(array(42,false)));
break ;
case ('double'):arrayAssignAdd($return[0][],addTaint(array(3.1415,false)));
break ;
case ('dateTime.iso8601'):arrayAssignAdd($return[0][],addTaint(array(new IXR_Date(attAspis(time())),false)));
break ;
case ('boolean'):arrayAssignAdd($return[0][],addTaint(array(true,false)));
break ;
case ('base64'):arrayAssignAdd($return[0][],addTaint(array(new IXR_Base64(array('base64',false)),false)));
break ;
case ('array'):arrayAssignAdd($return[0][],addTaint(array(array(array('array',false)),false)));
break ;
case ('struct'):arrayAssignAdd($return[0][],addTaint(array(array('struct' => array('struct',false,false)),false)));
break ;
 }
}return $return;
} }
function methodHelp ( $method ) {
{return $this->help[0][$method[0]];
} }
}class IXR_ClientMulticall extends IXR_Client{var $calls = array(array(),false);
function IXR_ClientMulticall ( $server,$path = array(false,false),$port = array(80,false) ) {
{parent::IXR_Client($server,$path,$port);
$this->useragent = array('The Incutio XML-RPC PHP Library (multicall client)',false);
} }
function addCall (  ) {
{$args = array(func_get_args(),false);
$methodName = Aspis_array_shift($args);
$struct = array(array(deregisterTaint(array('methodName',false)) => addTaint($methodName),deregisterTaint(array('params',false)) => addTaint($args)),false);
arrayAssignAdd($this->calls[0][],addTaint($struct));
} }
function query (  ) {
{return parent::query(array('system.multicall',false),$this->calls);
} }
};
?>
<?php 