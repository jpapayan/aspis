<?php require_once('AspisMain.php'); ?><?php
require_once ("./includes/general.php");
header(('Content-Type: text/plain'));
header(('Content-Encoding: UTF-8'));
header(("Expires: Mon, 26 Jul 1997 05:00:00 GMT"));
header((deconcat2(concat1("Last-Modified: ",attAspis(gmdate(("D, d M Y H:i:s"))))," GMT")));
header(("Cache-Control: no-store, no-cache, must-revalidate"));
header(("Cache-Control: post-check=0, pre-check=0"),false);
header(("Pragma: no-cache"));
$raw = array("",false);
if ( ((isset($_POST[0][("json_data")]) && Aspis_isset( $_POST [0][("json_data")]))))
 $raw = getRequestParam(array("json_data",false));
if ( (((denot_boolean($raw)) && ((isset($_GLOBALS) && Aspis_isset( $_GLOBALS)))) && ((isset($_GLOBALS[0][("HTTP_RAW_POST_DATA")]) && Aspis_isset( $_GLOBALS [0][("HTTP_RAW_POST_DATA")])))))
 $raw = $_GLOBALS[0]["HTTP_RAW_POST_DATA"];
if ( ((denot_boolean($raw)) && ((isset($HTTP_RAW_POST_DATA) && Aspis_isset( $HTTP_RAW_POST_DATA)))))
 $raw = $HTTP_RAW_POST_DATA;
if ( (denot_boolean($raw)))
 {if ( (!(function_exists(('file_get_contents')))))
 {$fp = attAspis(fopen(("php://input"),("r")));
if ( $fp[0])
 {$raw = array("",false);
while ( (!(feof($fp[0]))) )
$raw = attAspis(fread($fp[0],(1024)));
fclose($fp[0]);
}}else 
{$raw = concat1("",attAspis(file_get_contents(("php://input"))));
}}if ( (denot_boolean($raw)))
 Aspis_exit(array('{"result":null,"id":null,"error":{"errstr":"Could not get raw post data.","errfile":"","errline":null,"errcontext":"","level":"FATAL"}}',false));
if ( ((isset($config[0][('general.remote_rpc_url')]) && Aspis_isset( $config [0][('general.remote_rpc_url')]))))
 {$url = Aspis_parse_url($config[0]['general.remote_rpc_url']);
$req = concat2(concat1("POST ",$url[0]["path"])," HTTP/1.0\r\n");
$req = concat2($req,"Connection: close\r\n");
$req = concat($req,concat2(concat1("Host: ",$url[0]['host']),"\r\n"));
$req = concat($req,concat2(concat1("Content-Length: ",attAspis(strlen($raw[0]))),"\r\n"));
$req = concat($req,concat1("\r\n",$raw));
if ( ((!((isset($url[0][('port')]) && Aspis_isset( $url [0][('port')])))) || (denot_boolean($url[0]['port']))))
 arrayAssign($url[0],deAspis(registerTaint(array('port',false))),addTaint(array(80,false)));
$errno = $errstr = array("",false);
$socket = AspisInternalFunctionCall("fsockopen",deAspis($url[0]['host']),deAspis(Aspis_intval($url[0]['port'])),AspisPushRefParam($errno),AspisPushRefParam($errstr),(30),array(2,3));
if ( $socket[0])
 {fputs($socket[0],$req[0]);
$resp = array("",false);
while ( (!(feof($socket[0]))) )
$resp = concat($resp,attAspis(fgets($socket[0],(4096))));
fclose($socket[0]);
$resp = Aspis_explode(array("\r\n\r\n",false),$resp);
echo AspisCheckPrint(attachAspis($resp,(1)));
}Aspis_exit();
}$json = array(new Moxiecode_JSON(),false);
$input = $json[0]->decode($raw);
if ( ((isset($config[0][('general.engine')]) && Aspis_isset( $config [0][('general.engine')]))))
 {$spellchecker = array(new deAspis($config[0]['general.engine'])($config),false);
$result = Aspis_call_user_func_array(array(array($spellchecker,$input[0]['method']),false),$input[0]['params']);
}else 
{Aspis_exit(array('{"result":null,"id":null,"error":{"errstr":"You must choose an spellchecker engine in the config.php file.","errfile":"","errline":null,"errcontext":"","level":"FATAL"}}',false));
}$output = array(array(deregisterTaint(array("id",false)) => addTaint($input[0]->id),deregisterTaint(array("result",false)) => addTaint($result),"error" => array(null,false,false)),false);
echo AspisCheckPrint($json[0]->encode($output));
;
