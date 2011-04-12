<?php
$i=0;
if ($i%2==0): ?> hello html world!
<?php
else: ?> hello non html world
<?php
endif;

for ($i=0;$i<3;$i++):
   echo "for $i";
   echo "\n";
endfor;

$ar=array(1,2,3);
foreach ($ar as $a):
    echo "foreach $a";
    echo "\n";
endforeach;

$i=0;
while ($i<3):
    echo "while $i\n";
    $i++;
endwhile;


$s="papajohn";
switch ($s):
    case "papajohn":
        echo $s;
        echo "\n";
        break;
    case "nick":
        echo"$s$s";
        echo "\n";
        break;
endswitch;
?>

