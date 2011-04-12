<?php

$x1=8.13;
$x2="8.11 is the result";
$r=(integer)$x1/((integer)$x2);
echo "  r=$r\n";

$x1=8.13;
$x2=8.11;
$r=(integer)$x1/(integer)$x2;
echo "  r=$r\n";

$b=8;
$b|=(2>(2<1?1:0)?0:1);
echo "  b=$b\n";

$b= true;
$b=$b&&true||false||false&&true;
echo "  b=$b\n";

$n= 12;
$n-=1*2+3-4/99;
echo "  n=$n\n";

$n= 12;
$n-=(1*(2+3)-4)/99;
echo "  n=$n\n";

$n= 12;
$n=(1*(2+$n)-4)/99;
echo "  n=$n\n";

$x1= 12;
$x1-=1;
echo " x1=$x1\n";

$x1= -12;
$x1-=$x1-12;
echo " x1=$x1\n";

$x1= -12;
$x1*=-$x1;
echo " x1=$x1\n";

$i = 2;
$ip=$i++ + $i;
echo " ip=$ip\n";

$a=1;
$a  +=  $a++   +   ++$a;
echo "  a=$a\n";

/*
//KNOWN ERRORS
$a=1;
$a  -=  $a++   +   ++$a;
echo "  a=$a\n";

//non left to right evaluation from php unfortunately...
$i = 2;
$ip2=$i + $i++;
echo "ip2=$ip2\n";

//non left to right evaluation from php unfortunately...
$i = 2;
$ip3=$i + $i++ + $i;
echo "ip3=$ip3\n";

//non left to right evaluation from php unfortunately...
$i = 2;
$ip4=$i + $i++ + ++$i;
echo "ip4=$ip4\n";

//is it first the post/pre increments left to right and then the normal?
$i = 2;
$ip5=$i + ++$i+ $i++ + ++$i   ; //no...
echo "ip5=$ip5\n";

//hmmm maybe first post, the no, the pre
$i = 0;
$ip6=$i + --$i + --$i + $i++ + $i++  ;
echo "ip6=$ip6\n";
*/
?>