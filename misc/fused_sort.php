<?php
$a=file("fused.txt");
sort($a);
$a=array_unique($a);
file_put_contents("fused.txt",implode($a));
?> 
