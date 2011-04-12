<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             download counter
| category:         file handling
|
| last modified:    Mon, 20 Jun 2005 16:40:35 GMT
| downloaded:       Fri, 17 Sep 2010 13:14:25 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/file-handling/download-counter/
|
| description:
| this downloader snippet will count downloads of files and helps to cloak the
| real address of the file downloaded. call like
| "thisscript.php?get=thefile_to_download"
|
------------------------------------------------------------------------------*/

$_GET['get']="php_functions_overriden.txt";
$get=$_GET['get'];

// the folder where the files are stored ('.' if this script is in the same folder)
$download_dir = '/home/papajohn/public_html/phpparser';
// the folder where your counter files are stored
$counter_dir = '/home/papajohn/public_html/phpparser/dummy dir 1';
// Save this script as download.php
// each file to download must have a .txt-file called
// like "filename.ext.txt" in the 'counters' folder.
// display the counter like this: include('counters/filename.pdf.txt');
// download the file [download.php?get=name_of_file]
$path = $download_dir.'/'.$_GET['get'];
if(file_exists($path))
{
	$file = fopen($counter_dir.'/'.$_GET['get'],'r+');
	$count = fread($file,100);
	fclose($file); // closes file
	$count=(int)$count+1;
	// opens file again with 'w'-parameter
	$file = fopen($counter_dir.'/'.$_GET['get'],'w');
	fwrite($file, $count);
	fclose($file);
	$size = filesize($path);
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$_GET['get']);
	header('Content-Length: '.$size);
	readfile($path);
	
}else{
	echo '
	<p class="error">
		The file [<strong>'.$get.$extension.'</strong>] is not available for download.<br />
		Please contact the web administrator <a href="http://www.yoursite.com">here</a>
	</p>';
}

?>