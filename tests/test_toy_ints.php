<?php
$a1=1;
$a2=$a1 + 2;
echo $a2,5;
$x1 = 0;
$x1++;
$x1+=12;
$x1=$x1+3;
echo "hi $x1 world";
echo <<<DEMO
hello demo $x1 hello
DEMO;
echo "Result:".$x1;

$result=0;
for ($i=0 ; $i<"10 hello" ; ++$i) {
    $result= ++$i +$i;
   $result+=$i +(2+$x1);
   echo "$result\n";
}
echo "Result:".($result+$x1)."\n";
?>