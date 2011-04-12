<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             file informations
| category:         file handling
|
| last modified:    Thu, 13 Oct 2005 16:35:22 GMT
| downloaded:       Fri, 17 Sep 2010 13:14:59 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/file-handling/file-informations/
|
| description:
| this snippet will give you informations about a file like size, last modified
| date and more
|
------------------------------------------------------------------------------*/

 
  
function nice_size($fs)
{
	if ($fs >= 1073741824) 
		$fs = round(($fs / 1073741824 * 100) / 100).' Gb'; 
	elseif ($fs >= 1048576) 
		$fs = round(($fs / 1048576 * 100) / 100).' Mb'; 
	elseif ($fs >= 1024) 
		$fs = round(($fs / 1024 * 100) / 100).' Kb';
	else 
		$fs = $fs .' b';
	return $fs;
}
   
$file_stats = stat('/home/papajohn/public_html/phpparser/dummy.txt');
//$file_stats = stat(__file__); // demo
   
echo '
<p>
	filesize: '.nice_size($file_stats[7]).'<br />
	last access: '.date('l, F dS 20y - H:i:s',$file_stats[8]).'<br />
	last modified: '.date('l, F dS 20y - H:i:s',$file_stats[9]).'
</p>';
  
?>
