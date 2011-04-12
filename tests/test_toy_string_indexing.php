<?php
$s="123";
$s[1]="...";
$i=0;
$s[$i]="...";
echo $s[0].$s[1].$s[2];
if (isset ($s[1])) echo "set\n";
else echo "not set\n";

if (is_array($s[1])) echo "array\n";
else echo "not array\n";

unset($s);

if (isset ($s[1])) echo "set\n";
else echo "not set\n";

//Note: this fails when unset() is commented out. rewritting for T_EMPTY
if (empty ($s[1])) echo "empty\n";
else echo "not empty\n";

?>
