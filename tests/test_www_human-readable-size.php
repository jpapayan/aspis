<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             human readable size
| category:         directories
|
| last modified:    Wed, 03 May 2006 02:05:47 GMT
| downloaded:       Fri, 17 Sep 2010 10:45:30 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/directories/human-readable-size/
|
| description:
| to give a user the size of his account (or the admin the size of the users
| folder) in a more human readable format, you can use this PHP function. it will
| scan the directory recursively and return the value in kilobytes, megabytes so
| its easier to read.
|
------------------------------------------------------------------------------*/



// get filesize recursively
function dirsize($directory) 
{
	if (!is_dir($directory)) return -1;
	$size = 0;
	if ($DIR = opendir($directory)) 
	{
		while (($dirfile = readdir($DIR)) !== false) 
		{
			if (is_link($directory . '/' . $dirfile) || $dirfile == '.' || $dirfile == '..') 
				continue;
			if (is_file($directory . '/' . $dirfile)) 
				$size += filesize($directory . '/' . $dirfile);
			else if (is_dir($directory . '/' . $dirfile)) 
			{
				$dirSize = dirsize($directory . '/' . $dirfile); 
				if ($dirSize >= 0) $size += $dirSize; 
				else return -1;
			}
		}
		closedir($DIR);
	}
	return $size;
}

// format size to human readable values
function format_size($rawSize) 
{
	if ($rawSize / 1048576 > 1) 
		return round($rawSize/1048576, 1) . 'MB'; 
	else if ($rawSize / 1024 > 1) 
		return round($rawSize/1024, 1) . 'KB'; 
	else 
		return round($rawSize, 1) . 'bytes';
}

// specify the folder to scan
$dir = '.';
$size = dirsize($dir);
if ($size < 0)
{
	echo '<p>ERROR - bad path ('.$dir.')</p>'; 
}else{
	echo '<p>the &quot;'.$dir.'&quot; folder is '.format_size($size).'</p>';
}

?>