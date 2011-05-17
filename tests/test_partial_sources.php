<?php
function fsource() {
    return "<script> attack!\n";
}

class ctainted {
    function msource() {
        $a="aa"+"bb";
        return "<script> attack!\n";
    }
}

$v=fsource();
echo $v;

$o=new ctainted();
$v=$o->msource();
echo $v;

$n="fsource";
$v=$n();
echo $v;

?>