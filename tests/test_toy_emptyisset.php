 <?php
if ( !isset($p) ) $p="hello!\n";
echo $p;
isset($p);
$v=isset($p);
echo $v."\n";

$a="";
if ( empty($a) ) $a="hello!\n";
echo "papa ".$a;
empty($a);
$v=empty($a);
echo $v."\n";
?>
