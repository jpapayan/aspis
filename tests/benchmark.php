<?php
$iterations = 8;
$PHP_SELF = "MyFakeServer";
$string1 = 'abcdefghij';

echo "----------------\n";
$j=0;
for ($j=0;$j<$iterations;$j++) {
    $starttime = explode(' ', microtime());
    $a=5;
    $b=5;
    for($i = 1; $i <= 2000000; $i++) {
        $x=2;
//        $x=$i * 5;
//        $x=$x + $x;
//        $x=$x/10;
//        $string3 = $string1 . strrev($string1);
//        $string2 = substr($string1, 9, 1) . substr($string1, 0, 9);
//        $string1 = $string2;
    }
    $endtime = explode(' ', microtime());
    $total_time = $endtime[0] + $endtime[1] - ($starttime[1] + $starttime[0]);
    $total_time = round($total_time * 1000);
    $results[$j]=$total_time;
    echo  'Test #' . $j . ' completed in ' . $results[$j] . " ms.\n";
    sleep(2);
}

###################################################


echo "----------------\n";

$lowest=min($results);
$highest=max($results);
$AverageAll=array_sum($results) / count($results);

echo "Lowest time: $lowest ms\nHighest time : $highest ms\n";
echo "Average of all $j times: $AverageAll ms\n";

?>
