<?php
$f=@file_get_contents("all_results.txt");
if ($f==false) $all_results=array();
else $all_results=unserialize($f);

$a=unserialize(file_get_contents($argv[1]));
if ($a[1]==-123456789) {
    require("phplib/AspisMain.php");
    $a=deAspisRC($a);
}
sort($a);
$total=count($a);
echo "$argv[1] (90% $total): ".$a[(int) 0.9*$total]."ms\n";

$all_results[]="$argv[1] (90% $total): ".$a[(int) 0.9*$total]."ms\n";

echo "=======>Summing up<============\n";
foreach ($all_results as $s) echo $s;
file_put_contents("all_results.txt",serialize($all_results));

?>
