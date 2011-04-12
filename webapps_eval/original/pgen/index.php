<?php
/*
 * This file print a list of the first N prime numbers. It tests them all
 * by dividing it with all smaller naturals. Very stupid, CPU bound test
 * Gets N as a GET param, or just used a default.
 */
$time = round(microtime(true), 6);

$n=2000;
if (isset($_GET['n'])) $n=(int) $_GET['n'];
if ($n<1 || $n>2000) die("Cannot use the n number you selected, please try another one");

$results=array();
for ($c=1 ; $c<$n ; $c++) {
    $is_prime=true;
    for ($i=2 ; $i <= ($c / 2) ; $i++) {
        if ($c % $i ==0) {
            $is_prime=false;
            break;
        }
    }
    if ($is_prime) $results[]=$c;
}

echo "The primes generated are: <br>\n";
foreach ($results as $res) echo "$res<br>\n";
echo "please try again, byebye!<br>\n";

$time2 = round(microtime(true), 6);
$generation = round(($time2 - $time)*1000,3);
$f=@file_get_contents("stats.txt");
if ($f==false) $all_results=array();
else $all_results=unserialize($f);
$all_results[]=$generation;
file_put_contents("stats.txt",serialize($all_results));

echo "This page took $generation ms to render";

?>
