<?php

function ss(){
    $v=ii();
    ff($v);
    $z="zz";
    //z();
    $z();
}
function ii() {
    global $var;
    $var=$_SERVER["argv"][1];
    return $_SERVER["argv"][1];
}
function ff($v) {
    $m="you rock!";
    $n="michael";
    $a=hh2($m,$n);
    hh2($m,$n);
    echo "hh2 return a value: $a\n";
    $a=hh($m,$n);
    echo "hh return a value: $a\n";
    gg($v,$m);
}
function &hh(&$m,$n) {
    echo "Printing hidden message: $m from $n\n";
    global $untainted;
    echo "Printing \$untainted : $untainted\n";
    $m="you suck!";
    $untainted="NEW untainted message";
    $aa=12;
    return $aa;
}
function hh2($m,$n) {
    $r=zz("tainted call from untainted context1");
    echo "hh2: $r\n";
    $a="tainted call from untainted context2";
    $b="tainted call from untainted context3";
    $r=zz2($a,$b);
    echo "hh2: $r\n";
    return hh($m,$n);
}
function gg($v,$m) {
    echo $v."from $m\n";
}
function zz($set=null) {
    global $var;
    if (isset($set)) echo "passed variable: $set\n";
    echo "Done printing (global: $var), bye!\n";
    return "zz done.";
}
function zz2(&$set,$set2=null) {
    global $var;
    if (isset($set)) echo "passed variable: $set\n";
    if (isset($set2)) echo "passed variable: $set2\n";
    $set="i am donw with it";
    echo "Done printing (global: $var), bye!\n";
    return "zz done.";
}

$untainted="THIS HAS UNTAINTED CONTENTS!";
$m="aaa";
$n="bbb";
hh($m,$n);
hh($m,$n);
$var="none";
ss();
echo "\$untainted has now the value: $untainted\n";
require("test_partial_basic_p2.php");
echo "lets taint myself: $var\n";
gg("This is another untainted call","main");

///////////////////////////////////////////////////
echo "Passing Objects Around:\n";
class clA {
    var $v;
    var $vu;
    function clA($vu=""){
        $this->vu=$vu;
    }
    function finternal($p) {
        $p=2+$p;
        echo "clA finternal: ".$this->vu." and $p\n";
    }
    function finternalobject($o) {
        $p=2+$o->v;
        echo "clA: finternaobject: ".$this->vu." and $p\n";
    }
    function fexternal() {
        $clB=new clB();
        $clB->finternal(11);
        $ret=$clB->freceiver($this,999);
        $clB->finternal(12);
        return $ret;
    }
    function freceiver($o,$i) {
        $clA=new clA();
        $clA->finternal(13+$i);
        $clA->finternal($o->v);
        return $this;
    }
    function setvalues($v) {
        $this->v=$v;
        $this->vu="hi";
        echo ("Class clA  was given a value: $v\n");
    }
}

class clB {
    var $v=12;
    var $vu;
    function clB($vu=""){
        $this->vu=$vu;
    }
    function finternal($p) {
        $p=2+$p;
        echo "clB finternal: ".$this->vu." and $p\n";
    }
    function finternalobject($o) {
        $p=2+$o->v;
        echo "clB: finternaobject: ".$this->vu." and $p\n";
    }
    function fexternal() {
        $clA=new clA();
        $clA->finternal(11);
        $ret=$clA->freceiver($this,8);
        $clA->finternal(12);
        return $ret;
    }
    function freceiver($o,$i) {
        $clB=new clA();
        $clB->finternal(13+$i);
        $clB->finternal($o->v);
        return $this;
    }
    function setvalues($v) {
        $this->v=$v;
        $this->vu="hi";
        echo ("Class clB  was given a value: $v\n");
    }
}

//tainted from tainted
$cla=new clA();
$cla->setvalues("dummy");
$cla->finternal(1);

//untainted from tainted
$clb=new clB();
$clb->setvalues(28);
$clb->finternal(1);

$cla->finternalobject($clb);
$clb->finternalobject($cla);

$cla->fexternal();
$clb->fexternal();

echo "returning objcets:\n";
$clb=$cla->fexternal();
$clb->fexternal();


$cla="clA";
$cla=new $cla("dynamically created");
$cla->finternal(12);
$clb="clb";
$clb=new $clb();
$cla->finternalobject($clb);
function funtainted() {
    $cla="clA";
    $cla=new $cla("dynamically created");
    $cla->finternal(12);
    $clb="clb";
    $clb=new $clb();
    $cla->finternalobject($clb);
}
funtainted();

?>
