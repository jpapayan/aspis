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
    function msink($s, $aa,$ab) {
        echo $s, " from class world!\n";
        print $s."\n";
        return $this;
    }
    function msanitiser($s) {
        return $s;
    }
}

$c=new fclass();
$c->msink($c->a,2,3);
$ret=$c->msink(1,2,3)->msink(1,2,3)->msanitiser("sanitised 12");
echo "$ret\n";

?>

<?php exit($v."\n"); ?>

