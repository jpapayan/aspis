<?php
$v="Hello dear: ".$argv[1];
$v= strtoupper($v);
$v= htmlentities($v);
echo $v."\n";

function fsanitizer($s) {
    return $s;
}

$v="Hello dear: ".$argv[1];
$v= fsanitizer($v);
echo $v."\n";

?>
