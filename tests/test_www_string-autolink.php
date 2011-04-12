<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             autolink
| category:         string handling
|
| last modified:    Tue, 21 Jun 2005 14:31:51 GMT
| downloaded:       Mon, 20 Sep 2010 12:58:54 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/string-handling/autolink/
|
| description:
| this script will detect URLs in a string and automatically create a link to this
| URL. it removes the query-string and shows only the top-level of the site linked
| to as text.
|
------------------------------------------------------------------------------*/



$txt = '
<p>
	this is a string with 
	an url in it http://fundisom.com/g5/ and 
	its enough to be like that
</p>';

$txt = preg_replace('/(http|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', '<a href="\0">\4</a>', $txt);

echo $txt;

?>