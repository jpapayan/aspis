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

$f="msink";
$s="msanitiser";
$c->$f($c->a,2,3);
//TODO: the handling of nested variable method calls is broken
$ret=$c->$f(1,2,3)->$f(1,2,3)->$s("sanitised 12");
?>

