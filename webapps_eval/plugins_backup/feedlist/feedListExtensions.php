<?php

/* adds support for user defined functions.. */


 
	/* if you want to do something to the URL associated with the feed items before I use it in feedList then you can put that logic in here.  Just keep in mind that logic will
	apply to all links so use with care */
	function transfromLinkURL($url){
		return $url;
	}

?>