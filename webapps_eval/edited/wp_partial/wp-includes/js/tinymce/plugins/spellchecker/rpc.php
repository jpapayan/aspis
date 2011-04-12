<?php require_once('AspisMain.php'); ?><?php
require_once ("./includes/general.php");
header('Content-Type: text/plain');
header('Content-Encoding: UTF-8');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0",false);
header("Pragma: no-cache");
$raw = "";
if ( (isset($_POST[0]["json_data"]) && Aspis_isset($_POST[0]["json_data"])))
 $raw = getRequestParam("json_data");
if ( !$raw && isset($_GLOBALS) && isset($_GLOBALS["HTTP_RAW_POST_DATA"]))
 $raw = $_GLOBALS["HTTP_RAW_POST_DATA"];
if ( !$raw && isset($HTTP_RAW_POST_DATA))
 $raw = $HTTP_RAW_POST_DATA;
if ( !$raw)
 {if ( !function_exists('file_get_contents'))
 {$fp = fopen("php://input","r");
if ( $fp)
 {$raw = "";
while ( !feof($fp) )
$raw = fread($fp,1024);
fclose($fp);
}}else 
{$raw = "" . file_get_contents("php://input");
}}if ( !$raw)
 exit('{"result":null,"id":null,"error":{"errstr":"Could not get raw post data.","errfile":"","errline":null,"errcontext":"","level":"FATAL"}}');
if ( isset($config['general.remote_rpc_url']))
 {$url = parse_url($config['general.remote_rpc_url']);
$req = "POST " . $url["path"] . " HTTP/1.0\r\n";
$req .= "Connection: close\r\n";
$req .= "Host: " . $url['host'] . "\r\n";
$req .= "Content-Length: " . strlen($raw) . "\r\n";
$req .= "\r\n" . $raw;
if ( !isset($url['port']) || !$url['port'])
 $url['port'] = 80;
$errno = $errstr = "";
$socket = fsockopen($url['host'],intval($url['port']),$errno,$errstr,30);
if ( $socket)
 {fputs($socket,$req);
$resp = "";
while ( !feof($socket) )
$resp .= fgets($socket,4096);
fclose($socket);
$resp = explode("\r\n\r\n",$resp);
echo $resp[1];
}exit();
}$json = new Moxiecode_JSON();
$input = $json->decode($raw);
if ( isset($config['general.engine']))
 {$spellchecker = AspisNewUnknownProxy($config['general.engine'],array( $config),false);
$result = AspisUntainted_call_user_func_array(array($spellchecker,$input['method']),$input['params']);
}else 
{exit('{"result":null,"id":null,"error":{"errstr":"You must choose an spellchecker engine in the config.php file.","errfile":"","errline":null,"errcontext":"","level":"FATAL"}}');
}$output = array("id" => $input->id,"result" => $result,"error" => null);
echo $json->encode($output);
;
