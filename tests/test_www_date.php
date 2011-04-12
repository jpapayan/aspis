<?php


 
$today[] = 'F j, Y, g:i a';
$today[] = 'm.d.y';
$today[] = 'j, n, Y';
$today[] = 'Ymd';
$today[] = 'h-i-s, j-m-y, it is w Day z';
$today[] = '\i\t \i\s \t\h\e jS \d\a\y.';
$today[] = 'D M j G:i:s T Y';

// this is logical BUT wrong
$today[] = 'H:m \m \i\s\ \m\o\n\t\h';

// this is right
$today[] = 'H:i';

echo '
<ul style="list-style: none; padding: 1em;">';

foreach($today as $date)
	echo '
	<li>date(\''.$date.'\') = '.date($date).'</li>';

echo '
</ul>';
 
?>