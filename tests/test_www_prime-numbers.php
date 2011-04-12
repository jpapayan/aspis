<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             prime numbers
| category:         html and code
|
| last modified:    Tue, 21 Jun 2005 01:06:05 GMT
| downloaded:       Fri, 17 Sep 2010 17:15:53 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/html-and-code/prime-numbers/
|
| description:
| function to check wether a number is a prime number or not. returns TRUE if
| number given is a prime number and FALSE if not.
|
------------------------------------------------------------------------------*/
// put this in the top of your script
function get_microtime()
{
	list($usec, $sec) = explode(' ',microtime());
	return ((float)$usec + (float)$sec);
}

$time_start = get_microtime();

// is_prime(number) checks if a number is a prime number or not
function is_prime($i)
{
	if($i % 2 != 1) return false;
	$d = 3;
	$x = sqrt($i);
	while ($i % $d != 0 && $d < $x) $d += 2;
	return (($i % $d == 0 && $i != $d) * 1) == 0 ? true : false;
}
// example: show all prime numbers between $start and $end

$start = 0;
$end = 1000;
echo '
<p>
	all prime numbers between '.$start.' and '.$end.'
</p>
<p>';
for($i = $start; $i <= $end; $i++)
{
	if(is_prime($i))
	{
		echo '
'.$i.' ';
	}
}
echo '
</p>';
$time_end = get_microtime();
$time = $time_end - $time_start;
$time = round($time,6);
//echo '<p>this page loaded in '.$time.' seconds.</p>';
?>