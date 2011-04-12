<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             summarize article
| category:         string handling
|
| last modified:    Thu, 23 Jun 2005 16:06:51 GMT
| downloaded:       Mon, 20 Sep 2010 13:00:59 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/string-handling/summarize-article/
|
| description:
| this function takes the first x words or paragraphs from a long text and
| displays it as teaser with a "read more" link underneath.
|
------------------------------------------------------------------------------*/


function summarize($paragraph, $limit,$link)
{
	$text = '';
	$words = 0;
	$tok = strtok($paragraph, ' ');
	while($tok)
	{
		$text .= " $tok";
		$words++;
		if(($words >= $limit) && ((substr($tok, -1) == '!') || (substr($tok, -1) == '.')))
			break;
		$tok = strtok(' ');
	}
	$text .= ' '.$link;
	return ltrim($text);
}
// use like this
$example = 'Heres some code to extract the first part of a long paragraph, e.g. to use as a summary. 
Starting at the beginning of the paragraph it gets as many complete sentences 
as are necessary to contain $limit words. 
For example, with $limit at 20 it would return the first two sentences 
of the paragraph e reading right now 
(the first 20 words plus the rest of the sentence in which the limit was hit)';
$link = '<a href="#">read more</a>';
echo '<p>'.summarize($example,5,$link).'</p>';
?>