<?php
function ftainted($i,$j=12) {
    $i=$i*100;
    echo "hello from tainted: $i $j\n";
    return 2;
}
function funtainted($i,$j=12) {
    $i=$i*100;
    echo "hello from untainted: $i $j\n";
    $f="ftainted";
    $x=5;
    $x=$f($x,24);
    return $x+8;
}

$f="funtainted";
$i=5;
$x=$f($i,4);
echo "all done with code: $x\n";

class cluntainted {
    var $var;
    var $o;
    function set($var) {
        $this->var=$var+100+$this->var;
    }
    function hi(){
        $m="set";
        $this->$m(28);
        echo "hi from ".$this->var."\n";
    }
}

$o=new cluntainted();
$o->var=1999;
$o->o=new cluntainted();
$m="set";
$o->$m(28);
echo "hi from ".$o->var."\n";
$o->o=new cluntainted();
$m="hi";
$o->hi();
$o->$m();

?>