<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             read file
| category:         file handling
|
| last modified:    Mon, 20 Jun 2005 16:40:40 GMT
| downloaded:       Fri, 17 Sep 2010 13:18:05 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/file-handling/read-file/
|
| description:
| this will read a remote file and return the content as an array where each line
| is one item in the array.
|
------------------------------------------------------------------------------*/

?>
<?php

$lines = file('/home/papajohn/public_html/phpparser/dummy.txt');
$l_count = count($lines);

for($x = 0; $x< $l_count; $x++)
{
 echo $lines[$x];
}

?>
