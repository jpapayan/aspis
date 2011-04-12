<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             strip file extension
| category:         file handling
|
| last modified:    Mon, 20 Jun 2005 16:40:40 GMT
| downloaded:       Fri, 17 Sep 2010 13:18:17 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/file-handling/strip-file-extension/
|
| description:
| this php code will strip the extension from a filename. to remove the extension
| just call the function with the name of the file
|
------------------------------------------------------------------------------*/

 
function strip_ext($name)
{
	$ext = strrchr($name, '.');
	if($ext !== false)
	{
		$name = substr($name, 0, -strlen($ext));
	}
	return $name;
}
// demonstration
$filename = 'file_name.txt';
echo '
<p>
	the filename without extension:<br />
	'.strip_ext($filename).'
</p>';
// to get the file extension, do
echo '
<p>
	the file extension:<br />
	'.end(explode('.',$filename)).'
</p>';
 
?>