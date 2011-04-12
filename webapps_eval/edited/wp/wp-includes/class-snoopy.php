<?php require_once('AspisMain.php'); ?><?php
if ( (denot_boolean(Aspis_in_array(array('Snoopy',false),attAspisRC(get_declared_classes())))))
 {class Snoopy{var $host = array("www.php.net",false);
var $port = array(80,false);
var $proxy_host = array("",false);
var $proxy_port = array("",false);
var $proxy_user = array("",false);
var $proxy_pass = array("",false);
var $agent = array("Snoopy v1.2.4",false);
var $referer = array("",false);
var $cookies = array(array(),false);
var $rawheaders = array(array(),false);
var $maxredirs = array(5,false);
var $lastredirectaddr = array("",false);
var $offsiteok = array(true,false);
var $maxframes = array(0,false);
var $expandlinks = array(true,false);
var $passcookies = array(true,false);
var $user = array("",false);
var $pass = array("",false);
var $accept = array("image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*",false);
var $results = array("",false);
var $error = array("",false);
var $response_code = array("",false);
var $headers = array(array(),false);
var $maxlength = array(500000,false);
var $read_timeout = array(0,false);
var $timed_out = array(false,false);
var $status = array(0,false);
var $temp_dir = array("/tmp",false);
var $curl_path = array("/usr/local/bin/curl",false);
var $_maxlinelen = array(4096,false);
var $_httpmethod = array("GET",false);
var $_httpversion = array("HTTP/1.0",false);
var $_submit_method = array("POST",false);
var $_submit_type = array("application/x-www-form-urlencoded",false);
var $_mime_boundary = array("",false);
var $_redirectaddr = array(false,false);
var $_redirectdepth = array(0,false);
var $_frameurls = array(array(),false);
var $_framedepth = array(0,false);
var $_isproxy = array(false,false);
var $_fp_timeout = array(30,false);
function fetch ( $URI ) {
{$URI_PARTS = Aspis_parse_url($URI);
if ( (!((empty($URI_PARTS[0][("user")]) || Aspis_empty( $URI_PARTS [0][("user")])))))
 $this->user = $URI_PARTS[0]["user"];
if ( (!((empty($URI_PARTS[0][("pass")]) || Aspis_empty( $URI_PARTS [0][("pass")])))))
 $this->pass = $URI_PARTS[0]["pass"];
if ( ((empty($URI_PARTS[0][("query")]) || Aspis_empty( $URI_PARTS [0][("query")]))))
 arrayAssign($URI_PARTS[0],deAspis(registerTaint(array("query",false))),addTaint(array('',false)));
if ( ((empty($URI_PARTS[0][("path")]) || Aspis_empty( $URI_PARTS [0][("path")]))))
 arrayAssign($URI_PARTS[0],deAspis(registerTaint(array("path",false))),addTaint(array('',false)));
switch ( deAspis(Aspis_strtolower($URI_PARTS[0]["scheme"])) ) {
case ("http"):$this->host = $URI_PARTS[0]["host"];
if ( (!((empty($URI_PARTS[0][("port")]) || Aspis_empty( $URI_PARTS [0][("port")])))))
 $this->port = $URI_PARTS[0]["port"];
if ( deAspis($this->_connect($fp)))
 {if ( $this->_isproxy[0])
 {$this->_httprequest($URI,$fp,$URI,$this->_httpmethod);
}else 
{{$path = concat($URI_PARTS[0]["path"],(deAspis($URI_PARTS[0]["query"]) ? concat1("?",$URI_PARTS[0]["query"]) : array("",false)));
$this->_httprequest($path,$fp,$URI,$this->_httpmethod);
}}$this->_disconnect($fp);
if ( $this->_redirectaddr[0])
 {if ( ($this->maxredirs[0] > $this->_redirectdepth[0]))
 {if ( (deAspis(Aspis_preg_match(concat2(concat1("|^http://",Aspis_preg_quote($this->host)),"|i"),$this->_redirectaddr)) || $this->offsiteok[0]))
 {postincr($this->_redirectdepth);
$this->lastredirectaddr = $this->_redirectaddr;
$this->fetch($this->_redirectaddr);
}}}if ( (($this->_framedepth[0] < $this->maxframes[0]) && (count($this->_frameurls[0]) > (0))))
 {$frameurls = $this->_frameurls;
$this->_frameurls = array(array(),false);
while ( deAspis(list(,$frameurl) = deAspisList(Aspis_each($frameurls),array())) )
{if ( ($this->_framedepth[0] < $this->maxframes[0]))
 {$this->fetch($frameurl);
postincr($this->_framedepth);
}else 
{break ;
}}}}else 
{{return array(false,false);
}}return array(true,false);
break ;
case ("https"):if ( (denot_boolean($this->curl_path)))
 return array(false,false);
if ( function_exists(("is_executable")))
 if ( (!(is_executable($this->curl_path[0]))))
 return array(false,false);
$this->host = $URI_PARTS[0]["host"];
if ( (!((empty($URI_PARTS[0][("port")]) || Aspis_empty( $URI_PARTS [0][("port")])))))
 $this->port = $URI_PARTS[0]["port"];
if ( $this->_isproxy[0])
 {$this->_httpsrequest($URI,$URI,$this->_httpmethod);
}else 
{{$path = concat($URI_PARTS[0]["path"],(deAspis($URI_PARTS[0]["query"]) ? concat1("?",$URI_PARTS[0]["query"]) : array("",false)));
$this->_httpsrequest($path,$URI,$this->_httpmethod);
}}if ( $this->_redirectaddr[0])
 {if ( ($this->maxredirs[0] > $this->_redirectdepth[0]))
 {if ( (deAspis(Aspis_preg_match(concat2(concat1("|^http://",Aspis_preg_quote($this->host)),"|i"),$this->_redirectaddr)) || $this->offsiteok[0]))
 {postincr($this->_redirectdepth);
$this->lastredirectaddr = $this->_redirectaddr;
$this->fetch($this->_redirectaddr);
}}}if ( (($this->_framedepth[0] < $this->maxframes[0]) && (count($this->_frameurls[0]) > (0))))
 {$frameurls = $this->_frameurls;
$this->_frameurls = array(array(),false);
while ( deAspis(list(,$frameurl) = deAspisList(Aspis_each($frameurls),array())) )
{if ( ($this->_framedepth[0] < $this->maxframes[0]))
 {$this->fetch($frameurl);
postincr($this->_framedepth);
}else 
{break ;
}}}return array(true,false);
break ;
default :$this->error = concat2(concat1('Invalid protocol "',$URI_PARTS[0]["scheme"]),'"\n');
return array(false,false);
break ;
 }
return array(true,false);
} }
function submit ( $URI,$formvars = array("",false),$formfiles = array("",false) ) {
{unset($postdata);
$postdata = $this->_prepare_post_body($formvars,$formfiles);
$URI_PARTS = Aspis_parse_url($URI);
if ( (!((empty($URI_PARTS[0][("user")]) || Aspis_empty( $URI_PARTS [0][("user")])))))
 $this->user = $URI_PARTS[0]["user"];
if ( (!((empty($URI_PARTS[0][("pass")]) || Aspis_empty( $URI_PARTS [0][("pass")])))))
 $this->pass = $URI_PARTS[0]["pass"];
if ( ((empty($URI_PARTS[0][("query")]) || Aspis_empty( $URI_PARTS [0][("query")]))))
 arrayAssign($URI_PARTS[0],deAspis(registerTaint(array("query",false))),addTaint(array('',false)));
if ( ((empty($URI_PARTS[0][("path")]) || Aspis_empty( $URI_PARTS [0][("path")]))))
 arrayAssign($URI_PARTS[0],deAspis(registerTaint(array("path",false))),addTaint(array('',false)));
switch ( deAspis(Aspis_strtolower($URI_PARTS[0]["scheme"])) ) {
case ("http"):$this->host = $URI_PARTS[0]["host"];
if ( (!((empty($URI_PARTS[0][("port")]) || Aspis_empty( $URI_PARTS [0][("port")])))))
 $this->port = $URI_PARTS[0]["port"];
if ( deAspis($this->_connect($fp)))
 {if ( $this->_isproxy[0])
 {$this->_httprequest($URI,$fp,$URI,$this->_submit_method,$this->_submit_type,$postdata);
}else 
{{$path = concat($URI_PARTS[0]["path"],(deAspis($URI_PARTS[0]["query"]) ? concat1("?",$URI_PARTS[0]["query"]) : array("",false)));
$this->_httprequest($path,$fp,$URI,$this->_submit_method,$this->_submit_type,$postdata);
}}$this->_disconnect($fp);
if ( $this->_redirectaddr[0])
 {if ( ($this->maxredirs[0] > $this->_redirectdepth[0]))
 {if ( (denot_boolean(Aspis_preg_match(concat2(concat1("|^",$URI_PARTS[0]["scheme"]),"://|"),$this->_redirectaddr))))
 $this->_redirectaddr = $this->_expandlinks($this->_redirectaddr,concat(concat2($URI_PARTS[0]["scheme"],"://"),$URI_PARTS[0]["host"]));
if ( (deAspis(Aspis_preg_match(concat2(concat1("|^http://",Aspis_preg_quote($this->host)),"|i"),$this->_redirectaddr)) || $this->offsiteok[0]))
 {postincr($this->_redirectdepth);
$this->lastredirectaddr = $this->_redirectaddr;
if ( (strpos($this->_redirectaddr[0],"?") > (0)))
 $this->fetch($this->_redirectaddr);
else 
{$this->submit($this->_redirectaddr,$formvars,$formfiles);
}}}}if ( (($this->_framedepth[0] < $this->maxframes[0]) && (count($this->_frameurls[0]) > (0))))
 {$frameurls = $this->_frameurls;
$this->_frameurls = array(array(),false);
while ( deAspis(list(,$frameurl) = deAspisList(Aspis_each($frameurls),array())) )
{if ( ($this->_framedepth[0] < $this->maxframes[0]))
 {$this->fetch($frameurl);
postincr($this->_framedepth);
}else 
{break ;
}}}}else 
{{return array(false,false);
}}return array(true,false);
break ;
case ("https"):if ( (denot_boolean($this->curl_path)))
 return array(false,false);
if ( function_exists(("is_executable")))
 if ( (!(is_executable($this->curl_path[0]))))
 return array(false,false);
$this->host = $URI_PARTS[0]["host"];
if ( (!((empty($URI_PARTS[0][("port")]) || Aspis_empty( $URI_PARTS [0][("port")])))))
 $this->port = $URI_PARTS[0]["port"];
if ( $this->_isproxy[0])
 {$this->_httpsrequest($URI,$URI,$this->_submit_method,$this->_submit_type,$postdata);
}else 
{{$path = concat($URI_PARTS[0]["path"],(deAspis($URI_PARTS[0]["query"]) ? concat1("?",$URI_PARTS[0]["query"]) : array("",false)));
$this->_httpsrequest($path,$URI,$this->_submit_method,$this->_submit_type,$postdata);
}}if ( $this->_redirectaddr[0])
 {if ( ($this->maxredirs[0] > $this->_redirectdepth[0]))
 {if ( (denot_boolean(Aspis_preg_match(concat2(concat1("|^",$URI_PARTS[0]["scheme"]),"://|"),$this->_redirectaddr))))
 $this->_redirectaddr = $this->_expandlinks($this->_redirectaddr,concat(concat2($URI_PARTS[0]["scheme"],"://"),$URI_PARTS[0]["host"]));
if ( (deAspis(Aspis_preg_match(concat2(concat1("|^http://",Aspis_preg_quote($this->host)),"|i"),$this->_redirectaddr)) || $this->offsiteok[0]))
 {postincr($this->_redirectdepth);
$this->lastredirectaddr = $this->_redirectaddr;
if ( (strpos($this->_redirectaddr[0],"?") > (0)))
 $this->fetch($this->_redirectaddr);
else 
{$this->submit($this->_redirectaddr,$formvars,$formfiles);
}}}}if ( (($this->_framedepth[0] < $this->maxframes[0]) && (count($this->_frameurls[0]) > (0))))
 {$frameurls = $this->_frameurls;
$this->_frameurls = array(array(),false);
while ( deAspis(list(,$frameurl) = deAspisList(Aspis_each($frameurls),array())) )
{if ( ($this->_framedepth[0] < $this->maxframes[0]))
 {$this->fetch($frameurl);
postincr($this->_framedepth);
}else 
{break ;
}}}return array(true,false);
break ;
default :$this->error = concat2(concat1('Invalid protocol "',$URI_PARTS[0]["scheme"]),'"\n');
return array(false,false);
break ;
 }
return array(true,false);
} }
function fetchlinks ( $URI ) {
{if ( deAspis($this->fetch($URI)))
 {if ( $this->lastredirectaddr[0])
 $URI = $this->lastredirectaddr;
if ( is_array($this->results[0]))
 {for ( $x = array(0,false) ; ($x[0] < count($this->results[0])) ; postincr($x) )
arrayAssign($this->results[0],deAspis(registerTaint($x)),addTaint($this->_striplinks($this->results[0][$x[0]])));
}else 
{$this->results = $this->_striplinks($this->results);
}if ( $this->expandlinks[0])
 $this->results = $this->_expandlinks($this->results,$URI);
return array(true,false);
}else 
{return array(false,false);
}} }
function fetchform ( $URI ) {
{if ( deAspis($this->fetch($URI)))
 {if ( is_array($this->results[0]))
 {for ( $x = array(0,false) ; ($x[0] < count($this->results[0])) ; postincr($x) )
arrayAssign($this->results[0],deAspis(registerTaint($x)),addTaint($this->_stripform($this->results[0][$x[0]])));
}else 
{$this->results = $this->_stripform($this->results);
}return array(true,false);
}else 
{return array(false,false);
}} }
function fetchtext ( $URI ) {
{if ( deAspis($this->fetch($URI)))
 {if ( is_array($this->results[0]))
 {for ( $x = array(0,false) ; ($x[0] < count($this->results[0])) ; postincr($x) )
arrayAssign($this->results[0],deAspis(registerTaint($x)),addTaint($this->_striptext($this->results[0][$x[0]])));
}else 
{$this->results = $this->_striptext($this->results);
}return array(true,false);
}else 
{return array(false,false);
}} }
function submitlinks ( $URI,$formvars = array("",false),$formfiles = array("",false) ) {
{if ( deAspis($this->submit($URI,$formvars,$formfiles)))
 {if ( $this->lastredirectaddr[0])
 $URI = $this->lastredirectaddr;
if ( is_array($this->results[0]))
 {for ( $x = array(0,false) ; ($x[0] < count($this->results[0])) ; postincr($x) )
{arrayAssign($this->results[0],deAspis(registerTaint($x)),addTaint($this->_striplinks($this->results[0][$x[0]])));
if ( $this->expandlinks[0])
 arrayAssign($this->results[0],deAspis(registerTaint($x)),addTaint($this->_expandlinks($this->results[0][$x[0]],$URI)));
}}else 
{{$this->results = $this->_striplinks($this->results);
if ( $this->expandlinks[0])
 $this->results = $this->_expandlinks($this->results,$URI);
}}return array(true,false);
}else 
{return array(false,false);
}} }
function submittext ( $URI,$formvars = array("",false),$formfiles = array("",false) ) {
{if ( deAspis($this->submit($URI,$formvars,$formfiles)))
 {if ( $this->lastredirectaddr[0])
 $URI = $this->lastredirectaddr;
if ( is_array($this->results[0]))
 {for ( $x = array(0,false) ; ($x[0] < count($this->results[0])) ; postincr($x) )
{arrayAssign($this->results[0],deAspis(registerTaint($x)),addTaint($this->_striptext($this->results[0][$x[0]])));
if ( $this->expandlinks[0])
 arrayAssign($this->results[0],deAspis(registerTaint($x)),addTaint($this->_expandlinks($this->results[0][$x[0]],$URI)));
}}else 
{{$this->results = $this->_striptext($this->results);
if ( $this->expandlinks[0])
 $this->results = $this->_expandlinks($this->results,$URI);
}}return array(true,false);
}else 
{return array(false,false);
}} }
function set_submit_multipart (  ) {
{$this->_submit_type = array("multipart/form-data",false);
} }
function set_submit_normal (  ) {
{$this->_submit_type = array("application/x-www-form-urlencoded",false);
} }
function _striplinks ( $document ) {
{Aspis_preg_match_all(array("'<\s*a\s.*?href\s*=\s*			# find <a href=
						([\"\'])?					# find single or double quote
						(?(1) (.*?)\\1 | ([^\s\>]+))		# if quote found, match up to next matching
													# quote, otherwise match up to next space
						'isx",false),$document,$links);
while ( deAspis(list($key,$val) = deAspisList(Aspis_each(attachAspis($links,(2))),array())) )
{if ( (!((empty($val) || Aspis_empty( $val)))))
 arrayAssignAdd($match[0][],addTaint($val));
}while ( deAspis(list($key,$val) = deAspisList(Aspis_each(attachAspis($links,(3))),array())) )
{if ( (!((empty($val) || Aspis_empty( $val)))))
 arrayAssignAdd($match[0][],addTaint($val));
}return $match;
} }
function _stripform ( $document ) {
{Aspis_preg_match_all(array("'<\/?(FORM|INPUT|SELECT|TEXTAREA|(OPTION))[^<>]*>(?(2)(.*(?=<\/?(option|select)[^<>]*>[\r\n]*)|(?=[\r\n]*))|(?=[\r\n]*))'Usi",false),$document,$elements);
$match = Aspis_implode(array("\r\n",false),attachAspis($elements,(0)));
return $match;
} }
function _striptext ( $document ) {
{$search = array(array(array("'<script[^>]*?>.*?</script>'si",false),array("'<[\/\!]*?[^<>]*?>'si",false),array("'([\r\n])[\s]+'",false),array("'&(quot|#34|#034|#x22);'i",false),array("'&(amp|#38|#038|#x26);'i",false),array("'&(lt|#60|#060|#x3c);'i",false),array("'&(gt|#62|#062|#x3e);'i",false),array("'&(nbsp|#160|#xa0);'i",false),array("'&(iexcl|#161);'i",false),array("'&(cent|#162);'i",false),array("'&(pound|#163);'i",false),array("'&(copy|#169);'i",false),array("'&(reg|#174);'i",false),array("'&(deg|#176);'i",false),array("'&(#39|#039|#x27);'",false),array("'&(euro|#8364);'i",false),array("'&a(uml|UML);'",false),array("'&o(uml|UML);'",false),array("'&u(uml|UML);'",false),array("'&A(uml|UML);'",false),array("'&O(uml|UML);'",false),array("'&U(uml|UML);'",false),array("'&szlig;'i",false),),false);
$replace = array(array(array("",false),array("",false),array("\\1",false),array("\"",false),array("&",false),array("<",false),array(">",false),array(" ",false),attAspis(chr((161))),attAspis(chr((162))),attAspis(chr((163))),attAspis(chr((169))),attAspis(chr((174))),attAspis(chr((176))),attAspis(chr((39))),attAspis(chr((128))),array("ä",false),array("ö",false),array("ü",false),array("Ä",false),array("Ö",false),array("Ü",false),array("ß",false),),false);
$text = Aspis_preg_replace($search,$replace,$document);
return $text;
} }
function _expandlinks ( $links,$URI ) {
{Aspis_preg_match(array("/^[^\?]+/",false),$URI,$match);
$match = Aspis_preg_replace(array("|/[^\/\.]+\.[^\/\.]+$|",false),array("",false),attachAspis($match,(0)));
$match = Aspis_preg_replace(array("|/$|",false),array("",false),$match);
$match_part = Aspis_parse_url($match);
$match_root = concat(concat2($match_part[0]["scheme"],"://"),$match_part[0]["host"]);
$search = array(array(concat2(concat1("|^http://",Aspis_preg_quote($this->host)),"|i"),array("|^(\/)|i",false),array("|^(?!http://)(?!mailto:)|i",false),array("|/\./|",false),array("|/[^\/]+/\.\./|",false)),false);
$replace = array(array(array("",false),concat2($match_root,"/"),concat2($match,"/"),array("/",false),array("/",false)),false);
$expandedLinks = Aspis_preg_replace($search,$replace,$links);
return $expandedLinks;
} }
function _httprequest ( $url,$fp,$URI,$http_method,$content_type = array("",false),$body = array("",false) ) {
{$cookie_headers = array('',false);
if ( ($this->passcookies[0] && $this->_redirectaddr[0]))
 $this->setcookies();
$URI_PARTS = Aspis_parse_url($URI);
if ( ((empty($url) || Aspis_empty( $url))))
 $url = array("/",false);
$headers = concat2(concat(concat2(concat(concat2($http_method," "),$url)," "),$this->_httpversion),"\r\n");
if ( (!((empty($this->agent) || Aspis_empty( $this ->agent )))))
 $headers = concat($headers,concat2(concat1("User-Agent: ",$this->agent),"\r\n"));
if ( ((!((empty($this->host) || Aspis_empty( $this ->host )))) && (!((isset($this->rawheaders[0][('Host')]) && Aspis_isset( $this ->rawheaders [0][('Host')] ))))))
 {$headers = concat($headers,concat1("Host: ",$this->host));
if ( ((!((empty($this->port) || Aspis_empty( $this ->port )))) && ($this->port[0] != (80))))
 $headers = concat($headers,concat1(":",$this->port));
$headers = concat2($headers,"\r\n");
}if ( (!((empty($this->accept) || Aspis_empty( $this ->accept )))))
 $headers = concat($headers,concat2(concat1("Accept: ",$this->accept),"\r\n"));
if ( (!((empty($this->referer) || Aspis_empty( $this ->referer )))))
 $headers = concat($headers,concat2(concat1("Referer: ",$this->referer),"\r\n"));
if ( (!((empty($this->cookies) || Aspis_empty( $this ->cookies )))))
 {if ( (!(is_array($this->cookies[0]))))
 $this->cookies = array_cast($this->cookies);
Aspis_reset($this->cookies);
if ( (count($this->cookies[0]) > (0)))
 {$cookie_headers = concat2($cookie_headers,'Cookie: ');
foreach ( $this->cookies[0] as $cookieKey =>$cookieVal )
{restoreTaint($cookieKey,$cookieVal);
{$cookie_headers = concat($cookie_headers,concat2(concat(concat2($cookieKey,"="),Aspis_urlencode($cookieVal)),"; "));
}}$headers = concat($headers,concat2(Aspis_substr($cookie_headers,array(0,false),negate(array(2,false))),"\r\n"));
}}if ( (!((empty($this->rawheaders) || Aspis_empty( $this ->rawheaders )))))
 {if ( (!(is_array($this->rawheaders[0]))))
 $this->rawheaders = array_cast($this->rawheaders);
while ( deAspis(list($headerKey,$headerVal) = deAspisList(Aspis_each($this->rawheaders),array())) )
$headers = concat($headers,concat2(concat(concat2($headerKey,": "),$headerVal),"\r\n"));
}if ( (!((empty($content_type) || Aspis_empty( $content_type)))))
 {$headers = concat($headers,concat1("Content-type: ",$content_type));
if ( ($content_type[0] == ("multipart/form-data")))
 $headers = concat($headers,concat1("; boundary=",$this->_mime_boundary));
$headers = concat2($headers,"\r\n");
}if ( (!((empty($body) || Aspis_empty( $body)))))
 $headers = concat($headers,concat2(concat1("Content-length: ",attAspis(strlen($body[0]))),"\r\n"));
if ( ((!((empty($this->user) || Aspis_empty( $this ->user )))) || (!((empty($this->pass) || Aspis_empty( $this ->pass ))))))
 $headers = concat($headers,concat2(concat1("Authorization: Basic ",Aspis_base64_encode(concat(concat2($this->user,":"),$this->pass))),"\r\n"));
if ( (!((empty($this->proxy_user) || Aspis_empty( $this ->proxy_user )))))
 $headers = concat($headers,concat2(concat(concat12('Proxy-Authorization: ','Basic '),Aspis_base64_encode(concat(concat2($this->proxy_user,':'),$this->proxy_pass))),"\r\n"));
$headers = concat2($headers,"\r\n");
if ( ($this->read_timeout[0] > (0)))
 socket_set_timeout(deAspisRC($fp),deAspisRC($this->read_timeout));
$this->timed_out = array(false,false);
fwrite($fp[0],(deconcat($headers,$body)),strlen((deconcat($headers,$body))));
$this->_redirectaddr = array(false,false);
unset($this->headers);
while ( deAspis($currentHeader = attAspis(fgets($fp[0],$this->_maxlinelen[0]))) )
{if ( (($this->read_timeout[0] > (0)) && deAspis($this->_check_timeout($fp))))
 {$this->status = negate(array(100,false));
return array(false,false);
}if ( ($currentHeader[0] == ("\r\n")))
 break ;
if ( deAspis(Aspis_preg_match(array("/^(Location:|URI:)/i",false),$currentHeader)))
 {Aspis_preg_match(array("/^(Location:|URI:)[ ]+(.*)/i",false),array(chop(deAspisRC($currentHeader)),false),$matches);
if ( (denot_boolean(Aspis_preg_match(array("|\:\/\/|",false),attachAspis($matches,(2))))))
 {$this->_redirectaddr = concat(concat2(concat(concat2($URI_PARTS[0]["scheme"],"://"),$this->host),":"),$this->port);
if ( (denot_boolean(Aspis_preg_match(array("|^/|",false),attachAspis($matches,(2))))))
 $this->_redirectaddr = concat($this->_redirectaddr ,concat1("/",attachAspis($matches,(2))));
else 
{$this->_redirectaddr = concat($this->_redirectaddr ,attachAspis($matches,(2)));
}}else 
{$this->_redirectaddr = attachAspis($matches,(2));
}}if ( deAspis(Aspis_preg_match(array("|^HTTP/|",false),$currentHeader)))
 {if ( deAspis(Aspis_preg_match(array("|^HTTP/[^\s]*\s(.*?)\s|",false),$currentHeader,$status)))
 {$this->status = attachAspis($status,(1));
}$this->response_code = $currentHeader;
}arrayAssignAdd($this->headers[0][],addTaint($currentHeader));
}$results = array('',false);
do {$_data = attAspis(fread($fp[0],$this->maxlength[0]));
if ( (strlen($_data[0]) == (0)))
 {break ;
}$results = concat($results,$_data);
}while (true )
;
if ( (($this->read_timeout[0] > (0)) && deAspis($this->_check_timeout($fp))))
 {$this->status = negate(array(100,false));
return array(false,false);
}if ( deAspis(Aspis_preg_match(array("'<meta[\s]*http-equiv[^>]*?content[\s]*=[\s]*[\"\']?\d+;[\s]*URL[\s]*=[\s]*([^\"\']*?)[\"\']?>'i",false),$results,$match)))
 {$this->_redirectaddr = $this->_expandlinks(attachAspis($match,(1)),$URI);
}if ( (($this->_framedepth[0] < $this->maxframes[0]) && deAspis(Aspis_preg_match_all(array("'<frame\s+.*src[\s]*=[\'\"]?([^\'\"\>]+)'i",false),$results,$match))))
 {arrayAssignAdd($this->results[0][],addTaint($results));
for ( $x = array(0,false) ; ($x[0] < count(deAspis(attachAspis($match,(1))))) ; postincr($x) )
arrayAssignAdd($this->_frameurls[0][],addTaint($this->_expandlinks(attachAspis($match[0][(1)],$x[0]),concat(concat2($URI_PARTS[0]["scheme"],"://"),$this->host))));
}elseif ( is_array($this->results[0]))
 arrayAssignAdd($this->results[0][],addTaint($results));
else 
{$this->results = $results;
}return array(true,false);
} }
function _httpsrequest ( $url,$URI,$http_method,$content_type = array("",false),$body = array("",false) ) {
{if ( ($this->passcookies[0] && $this->_redirectaddr[0]))
 $this->setcookies();
$headers = array(array(),false);
$URI_PARTS = Aspis_parse_url($URI);
if ( ((empty($url) || Aspis_empty( $url))))
 $url = array("/",false);
if ( (!((empty($this->agent) || Aspis_empty( $this ->agent )))))
 arrayAssignAdd($headers[0][],addTaint(concat1("User-Agent: ",$this->agent)));
if ( (!((empty($this->host) || Aspis_empty( $this ->host )))))
 if ( (!((empty($this->port) || Aspis_empty( $this ->port )))))
 arrayAssignAdd($headers[0][],addTaint(concat(concat2(concat1("Host: ",$this->host),":"),$this->port)));
else 
{arrayAssignAdd($headers[0][],addTaint(concat1("Host: ",$this->host)));
}if ( (!((empty($this->accept) || Aspis_empty( $this ->accept )))))
 arrayAssignAdd($headers[0][],addTaint(concat1("Accept: ",$this->accept)));
if ( (!((empty($this->referer) || Aspis_empty( $this ->referer )))))
 arrayAssignAdd($headers[0][],addTaint(concat1("Referer: ",$this->referer)));
if ( (!((empty($this->cookies) || Aspis_empty( $this ->cookies )))))
 {if ( (!(is_array($this->cookies[0]))))
 $this->cookies = array_cast($this->cookies);
Aspis_reset($this->cookies);
if ( (count($this->cookies[0]) > (0)))
 {$cookie_str = array('Cookie: ',false);
foreach ( $this->cookies[0] as $cookieKey =>$cookieVal )
{restoreTaint($cookieKey,$cookieVal);
{$cookie_str = concat($cookie_str,concat2(concat(concat2($cookieKey,"="),Aspis_urlencode($cookieVal)),"; "));
}}arrayAssignAdd($headers[0][],addTaint(Aspis_substr($cookie_str,array(0,false),negate(array(2,false)))));
}}if ( (!((empty($this->rawheaders) || Aspis_empty( $this ->rawheaders )))))
 {if ( (!(is_array($this->rawheaders[0]))))
 $this->rawheaders = array_cast($this->rawheaders);
while ( deAspis(list($headerKey,$headerVal) = deAspisList(Aspis_each($this->rawheaders),array())) )
arrayAssignAdd($headers[0][],addTaint(concat(concat2($headerKey,": "),$headerVal)));
}if ( (!((empty($content_type) || Aspis_empty( $content_type)))))
 {if ( ($content_type[0] == ("multipart/form-data")))
 arrayAssignAdd($headers[0][],addTaint(concat(concat2(concat1("Content-type: ",$content_type),"; boundary="),$this->_mime_boundary)));
else 
{arrayAssignAdd($headers[0][],addTaint(concat1("Content-type: ",$content_type)));
}}if ( (!((empty($body) || Aspis_empty( $body)))))
 arrayAssignAdd($headers[0][],addTaint(concat1("Content-length: ",attAspis(strlen($body[0])))));
if ( ((!((empty($this->user) || Aspis_empty( $this ->user )))) || (!((empty($this->pass) || Aspis_empty( $this ->pass ))))))
 arrayAssignAdd($headers[0][],addTaint(concat1("Authorization: BASIC ",Aspis_base64_encode(concat(concat2($this->user,":"),$this->pass)))));
for ( $curr_header = array(0,false) ; ($curr_header[0] < count($headers[0])) ; postincr($curr_header) )
{$safer_header = Aspis_strtr(attachAspis($headers,$curr_header[0]),array("\"",false),array(" ",false));
$cmdline_params = concat($cmdline_params,concat2(concat1(" -H \"",$safer_header),"\""));
}if ( (!((empty($body) || Aspis_empty( $body)))))
 $cmdline_params = concat($cmdline_params,concat2(concat1(" -d \"",$body),"\""));
if ( ($this->read_timeout[0] > (0)))
 $cmdline_params = concat($cmdline_params,concat1(" -m ",$this->read_timeout));
$headerfile = attAspis(tempnam($temp_dir[0],("sno")));
Aspis_exec(concat2(concat(concat2(concat(concat($this->curl_path,concat2(concat1(" -k -D \"",$headerfile),"\"")),$cmdline_params)," \""),Aspis_escapeshellcmd($URI)),"\""),$results,$return);
if ( $return[0])
 {$this->error = concat2(concat1("Error: cURL could not retrieve the document, error ",$return),".");
return array(false,false);
}$results = Aspis_implode(array("\r\n",false),$results);
$result_headers = Aspis_file($headerfile);
$this->_redirectaddr = array(false,false);
unset($this->headers);
for ( $currentHeader = array(0,false) ; ($currentHeader[0] < count($result_headers[0])) ; postincr($currentHeader) )
{if ( deAspis(Aspis_preg_match(array("/^(Location: |URI: )/i",false),attachAspis($result_headers,$currentHeader[0]))))
 {Aspis_preg_match(array("/^(Location: |URI:)\s+(.*)/",false),array(chop(deAspisRC(attachAspis($result_headers,$currentHeader[0]))),false),$matches);
if ( (denot_boolean(Aspis_preg_match(array("|\:\/\/|",false),attachAspis($matches,(2))))))
 {$this->_redirectaddr = concat(concat2(concat(concat2($URI_PARTS[0]["scheme"],"://"),$this->host),":"),$this->port);
if ( (denot_boolean(Aspis_preg_match(array("|^/|",false),attachAspis($matches,(2))))))
 $this->_redirectaddr = concat($this->_redirectaddr ,concat1("/",attachAspis($matches,(2))));
else 
{$this->_redirectaddr = concat($this->_redirectaddr ,attachAspis($matches,(2)));
}}else 
{$this->_redirectaddr = attachAspis($matches,(2));
}}if ( deAspis(Aspis_preg_match(array("|^HTTP/|",false),attachAspis($result_headers,$currentHeader[0]))))
 $this->response_code = attachAspis($result_headers,$currentHeader[0]);
arrayAssignAdd($this->headers[0][],addTaint(attachAspis($result_headers,$currentHeader[0])));
}if ( deAspis(Aspis_preg_match(array("'<meta[\s]*http-equiv[^>]*?content[\s]*=[\s]*[\"\']?\d+;[\s]*URL[\s]*=[\s]*([^\"\']*?)[\"\']?>'i",false),$results,$match)))
 {$this->_redirectaddr = $this->_expandlinks(attachAspis($match,(1)),$URI);
}if ( (($this->_framedepth[0] < $this->maxframes[0]) && deAspis(Aspis_preg_match_all(array("'<frame\s+.*src[\s]*=[\'\"]?([^\'\"\>]+)'i",false),$results,$match))))
 {arrayAssignAdd($this->results[0][],addTaint($results));
for ( $x = array(0,false) ; ($x[0] < count(deAspis(attachAspis($match,(1))))) ; postincr($x) )
arrayAssignAdd($this->_frameurls[0][],addTaint($this->_expandlinks(attachAspis($match[0][(1)],$x[0]),concat(concat2($URI_PARTS[0]["scheme"],"://"),$this->host))));
}elseif ( is_array($this->results[0]))
 arrayAssignAdd($this->results[0][],addTaint($results));
else 
{$this->results = $results;
}unlink($headerfile[0]);
return array(true,false);
} }
function setcookies (  ) {
{for ( $x = array(0,false) ; ($x[0] < count($this->headers[0])) ; postincr($x) )
{if ( deAspis(Aspis_preg_match(array('/^set-cookie:[\s]+([^=]+)=([^;]+)/i',false),$this->headers[0][$x[0]],$match)))
 arrayAssign($this->cookies[0],deAspis(registerTaint(attachAspis($match,(1)))),addTaint(Aspis_urldecode(attachAspis($match,(2)))));
}} }
function _check_timeout ( $fp ) {
{if ( ($this->read_timeout[0] > (0)))
 {$fp_status = array(socket_get_status(deAspisRC($fp)),false);
if ( deAspis($fp_status[0]["timed_out"]))
 {$this->timed_out = array(true,false);
return array(true,false);
}}return array(false,false);
} }
function _connect ( &$fp ) {
{if ( ((!((empty($this->proxy_host) || Aspis_empty( $this ->proxy_host )))) && (!((empty($this->proxy_port) || Aspis_empty( $this ->proxy_port ))))))
 {$this->_isproxy = array(true,false);
$host = $this->proxy_host;
$port = $this->proxy_port;
}else 
{{$host = $this->host;
$port = $this->port;
}}$this->status = array(0,false);
if ( deAspis($fp = AspisInternalFunctionCall("fsockopen",$host[0],$port[0],AspisPushRefParam($errno),AspisPushRefParam($errstr),$this->_fp_timeout[0],array(2,3))))
 {return array(true,false);
}else 
{{$this->status = $errno;
switch ( $errno[0] ) {
case deAspis(negate(array(3,false))):$this->error = array("socket creation failed (-3)",false);
case deAspis(negate(array(4,false))):$this->error = array("dns lookup failure (-4)",false);
case deAspis(negate(array(5,false))):$this->error = array("connection refused or timed out (-5)",false);
default :$this->error = concat2(concat1("connection failed (",$errno),")");
 }
return array(false,false);
}}} }
function _disconnect ( $fp ) {
{return (attAspis(fclose($fp[0])));
} }
function _prepare_post_body ( $formvars,$formfiles ) {
{AspisInternalFunctionCall("settype",AspisPushRefParam($formvars),("array"),array(0));
AspisInternalFunctionCall("settype",AspisPushRefParam($formfiles),("array"),array(0));
$postdata = array('',false);
if ( ((count($formvars[0]) == (0)) && (count($formfiles[0]) == (0))))
 return ;
switch ( $this->_submit_type[0] ) {
case ("application/x-www-form-urlencoded"):Aspis_reset($formvars);
while ( deAspis(list($key,$val) = deAspisList(Aspis_each($formvars),array())) )
{if ( (is_array($val[0]) || is_object($val[0])))
 {while ( deAspis(list($cur_key,$cur_val) = deAspisList(Aspis_each($val),array())) )
{$postdata = concat($postdata,concat2(concat(concat2(Aspis_urlencode($key),"[]="),Aspis_urlencode($cur_val)),"&"));
}}else 
{$postdata = concat($postdata,concat2(concat(concat2(Aspis_urlencode($key),"="),Aspis_urlencode($val)),"&"));
}}break ;
case ("multipart/form-data"):$this->_mime_boundary = concat1("Snoopy",attAspis(md5(uniqid(deAspisRC(attAspisRC(microtime()))))));
Aspis_reset($formvars);
while ( deAspis(list($key,$val) = deAspisList(Aspis_each($formvars),array())) )
{if ( (is_array($val[0]) || is_object($val[0])))
 {while ( deAspis(list($cur_key,$cur_val) = deAspisList(Aspis_each($val),array())) )
{$postdata = concat($postdata,concat2(concat1("--",$this->_mime_boundary),"\r\n"));
$postdata = concat($postdata,concat2(concat1("Content-Disposition: form-data; name=\"",$key),"\[\]\"\r\n\r\n"));
$postdata = concat($postdata,concat2($cur_val,"\r\n"));
}}else 
{{$postdata = concat($postdata,concat2(concat1("--",$this->_mime_boundary),"\r\n"));
$postdata = concat($postdata,concat2(concat1("Content-Disposition: form-data; name=\"",$key),"\"\r\n\r\n"));
$postdata = concat($postdata,concat2($val,"\r\n"));
}}}Aspis_reset($formfiles);
while ( deAspis(list($field_name,$file_names) = deAspisList(Aspis_each($formfiles),array())) )
{AspisInternalFunctionCall("settype",AspisPushRefParam($file_names),("array"),array(0));
while ( deAspis(list(,$file_name) = deAspisList(Aspis_each($file_names),array())) )
{if ( (!(is_readable($file_name[0]))))
 continue ;
$fp = attAspis(fopen($file_name[0],("r")));
$file_content = attAspis(fread($fp[0],filesize($file_name[0])));
fclose($fp[0]);
$base_name = Aspis_basename($file_name);
$postdata = concat($postdata,concat2(concat1("--",$this->_mime_boundary),"\r\n"));
$postdata = concat($postdata,concat2(concat(concat2(concat1("Content-Disposition: form-data; name=\"",$field_name),"\"; filename=\""),$base_name),"\"\r\n\r\n"));
$postdata = concat($postdata,concat2($file_content,"\r\n"));
}}$postdata = concat($postdata,concat2(concat1("--",$this->_mime_boundary),"--\r\n"));
break ;
 }
return $postdata;
} }
}};
?>
<?php 