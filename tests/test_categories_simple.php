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

$f="fsink";
$f($v);
$f="fsanitizer";
$f($v);
?>
And In another block:
<?= $v?>

<?php 
class fclass {
    var $a="stpid";
    function fsink($s, $aa,$ab) {
        echo $s, " from class world!\n";
        print $s."\n";
    }
}

$c=new fclass();
$c->fsink($c->a,2,3);
$c->fsink(1,2,3);

?>

<?php exit($v."\n"); ?>

