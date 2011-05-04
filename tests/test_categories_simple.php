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

function fsink($s) {
    echo $s."\n", " from amazing world!\n";
    print $s."\n";
}
function eee($s) {
    return $s;
}

$v="Hello dear: ".$argv[1];
fsink($v);
fclose(eee($v));
exit($v."\n");
?>
