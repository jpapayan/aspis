<?php

$info = array('coffee', 'brown', 'caffeine');

list($drink, $color, $power) = $info;
echo "$drink is $color and $power makes it special.\n";
//
list($drink, , $power) = $info;
echo "$drink has $power.\n";
list( , , $power) = $info;
echo "I need $power!\n";
$s="absde";
list($bar) = $s; //well, only when the string is given directly
//list($bar)="aaaaa"; //ip: <-this doest work
var_dump($bar); // NULL
list($a, list($b, $c)) = array(1, array(2, 3));
echo $a, $b ,$c ,"\n";

$arr=array(1, 3,2);
list($a, $b ,$c) = $arr;
echo $a, $b ,$c ,"\n";

list($a, list($b, $c),list($d, list($e,$f))) = array(1, array(2, 3),array(2, array(2, 3)));
echo $a, $b ,$c ,$d,$e,$f,"\n";
?>