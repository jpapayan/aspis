<?php
$x1=8;
if ($x1>15) echo "Doesn't Work: $x1<15\n";
else echo "Does Work: $x1<15\n";

echo ($x1==8)?"condif working\n":"condif not working\n";


$i=1;
while ($i<5) {
    echo "i=$i\n";
    $i++;
}
$i=-1;
do {
    echo "i=$i\n";
    $i--;
}
while ($i>-5);


for ($i=1 ; $i<5 ; $i++) {
    echo "i=$i\n";
}
$x1=1;
switch ($x1){
    case 0:
        echo "Doesn't Work: 0\n";
        break;
    case 1:
        echo "Does Work: 1\n";
        break;
}

goto AFTER;
echo "ERROR!\n";
AFTER:
echo "Goto is fine\n";


if (@"true") echo "true\n";
else echo "false\n";

?>