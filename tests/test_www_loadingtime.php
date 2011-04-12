<?php


// put this in the top of your script
function get_microtime()
{
	list($usec, $sec) = explode(' ',microtime());
	return ((float)$usec + (float)$sec);
}

$time_start = get_microtime();

// start page content here

// this is dummy - content to spend some time
for ($i=0; $i < 1000; $i++)
{ 
} 

// end page content here

// compute and output load-time in milliseconds
$time_end = get_microtime(); 
$time = $time_end - $time_start; 
$time = round($time,6);
$time = round($time,1);
//echo '<p>this page loaded in '.$time.' seconds.</p>';

?>
