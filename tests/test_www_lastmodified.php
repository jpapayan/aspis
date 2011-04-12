<?php
function get_raw_header($host,$doc)
{
	$httpheader = '';
	$fp = fsockopen ($host, 80, $errno, $errstr, 30);
	if (!$fp)
	{
		echo $errstr.' ('.$errno.')';
	}else{
		fputs($fp, 'GET '.$doc.' HTTP/1.0'."\r\n".'Host: '.$host."\r\n\r\n");
		while(!feof($fp))
		{
			$httpresult = fgets ($fp,1024);
			$httpheader = $httpheader.$httpresult;
			if (ereg("^\r\n",$httpresult))
			break;
		}
		fclose ($fp);
	}
	return $httpheader;
}
function get_header_array($url)
{
	$url = ereg_replace('http://','',$url);
	$endHostPos = strpos($url,'/');
	if(!$endHostPos) $endHostPos = strlen($url);
	$host = substr($url,0,$endHostPos);
	$doc = substr($url,$endHostPos,strlen($url)-$endHostPos);
	if($doc == '') $doc = '/';
	$raw = get_raw_header($host,$doc);
	$tmpArray = explode("\n",$raw);
//        print_r($tmpArray);
	for ($i=0;$i<sizeof($tmpArray); $i++)
	{
		@list($name, $value) = explode(':', $tmpArray[$i], 2);
		$array[trim($name)]=trim($value);
	}
//        print_r($array);
	return $array;
}
// use like this to find out when a file on a server was last modified
// should be a static file like a .zip archive for example
$remote_file = 'http://fundisom.com/MakeNewFolderNamed.dmg';
$array = get_header_array($remote_file);
echo '
<p>
	'.$remote_file.' was last modified on '.date('j F Y',strtotime($array['Last-Modified'])).'
</p>';
?>