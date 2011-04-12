<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             open file
| category:         file handling
|
| last modified:    Mon, 20 Jun 2005 16:40:39 GMT
| downloaded:       Fri, 17 Sep 2010 13:17:33 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/file-handling/open-file/
|
| description:
| opens a file and returns the content as a string
|
------------------------------------------------------------------------------*/

?>
<?php
function file_open($filename)
{ 
	if($fp = @fopen($filename, "r"))
	{ 
		$fp = @fopen($filename, "r"); 
		$contents = fread($fp, filesize($filename)); 
		fclose($fp); 
		return $contents; 
	}else{ 
		return false; 
	} 
} 

// use like
$text = file_open('/home/papajohn/public_html/phpparser/dummy.txt');
echo "$text\n";

?>
