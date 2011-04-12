<?php


function time_passed($time)
{
	$timestring = '';
	$time = time()-$time;
	$weeks = $time/604800;
        $days = ($time%604800)/86400;
	$hours = (($time%604800)%86400)/3600;
	$minutes = ((($time%604800)%86400)%3600)/60;
	$seconds = (((($time%604800)%86400)%3600)%60);
	if(floor($weeks)) $timestring .= floor($weeks)." weeks ";
	if(floor($days)) $timestring .= floor($days)." days ";
	if(floor($hours)) $timestring .= floor($hours)." hours ";
	if(floor($minutes)) $timestring .= floor($minutes)." minutes ";
	if(!floor($minutes)&&!floor($hours)&&!floor($days)) $timestring .= floor($seconds)." seconds ";
	return $timestring;
}

echo '
<p>';

// path to file - last update
// echo 'file example last updated '.time_passed(filectime('folder/folder/file')).' ago';

// this file - last update
$diff=time_passed(filectime(__file__));
$max=$diff<10000000;
if ($max) echo 'this file last updated less than 10ksec ago ago';
else echo 'this file last updated more than 10ksec ago ago';

// any timestamp - time passed
//echo time_passed(time()-(2*3600));

echo '
</p>';

?>