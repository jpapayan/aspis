<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             write to first line of file
| category:         file handling
|
| last modified:    Mon, 20 Jun 2005 16:40:41 GMT
| downloaded:       Fri, 17 Sep 2010 13:18:50 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/file-handling/write-to-first-line-of-file/
|
| description:
| this snippet let's you insert data at the beginning of a file. it reads the
| contents and adds new data to the first line of the file. after this it joins
| the lines and writes them back to the file again.
|
------------------------------------------------------------------------------*/


// your new data + newline
$new_line = 'comma ; vallues'."\n";
// the filepath
$file = '/home/papajohn/public_html/phpparser/dummy.txt';
// the old data as array
$old_lines = file($file);

//print_r($new_line);
//print_r($old_lines);

// add new line to beginning of array
//array_unshift($old_lines,$new_line);
array_unshift($old_lines,$new_line);

// make string out of array
$new_content = join('',$old_lines);
$fp = fopen($file,'w');
//// write string to file
$write = fwrite($fp, $new_content);
fclose($fp);

echo $old_lines[1]."\n";
?>
