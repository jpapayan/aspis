<?php
class cluntainted {
    var $var;
    function set($var) {
        $this->var=$var+100+$this->var;
    }
    function hi(){
        $v=$this->var-100;
        echo "$v.\n";
    }
}
class cltainted {
    var $var;
    function set($var) {
        $this->var=$var+100+$this->var;
    }
    function hi(){
        $v=$this->var-100;
        echo "$v.\n";
    }
}
function funtainted(&$o,&$s,$i) {
    $o->set($s);
    $o->hi();
    echo "funtainted: $s\n";
    $s.="done";
    return $o;
}
function funtainted2() {
    $o=new cluntainted();
    $s="started";
    $i=12;
    ftainted($o,$s,$i);
    ftainted($o,$s,$i);
    return $o;
}
function ftainted(&$o,&$s,$i) {
    $o->set($s);
    $o->hi();
    echo "tainted: $s\n";
    $s.="done";
}

$o=new cltainted();
$s="started";
$i=12;
$o=funtainted($o,$s,$i);

//return;

funtainted($o,$s,$i);
$o=funtainted2();
funtainted($o,$s,$i);


////////returning by reference///////////

$opt1=100;
$opt2=200;
function &chooser($i) {
    global $opt1;
    global $opt2;
    if ($i<$opt1) return $opt1;
    else return $opt2;
}
$var=&chooser(150);
$opt2=300;
echo "\nReturn from chooser by reference: $var\n";
$var=&chooser(50);
$opt1=120;
echo "\nReturn from chooser by reference: $var\n";

//////testing object methods and reference parameters/////
class cuntainted {
    var $v1=100;
    var $v2=200;
    function fref(&$s,$a="") {
        echo "f received \$s as: $s\n";
        $s.=$this->finternal().$a;
        echo "f has left \$s as: $s\n";
        return $this;
    }
    function &gref($v) {
        if ($v<($this->v1)) return $this->v1;
        else return $this->v2;
    }
    function finternal() {
        return " world!";
    }
}
class ctainted {
    var $v1=100;
    var $v2=200;
    function fref(&$s,$a="") {
        echo "f received \$s as: $s\n";
        $s.=$this->finternal().$a;
        echo "f has left \$s as: $s\n";
        return $this;
    }
    function &gref($v) {
        if ($v<($this->v1)) return $this->v1;
        else return $this->v2;
    }
    function finternal() {
        return " world!";
    }
}
function ffftainted(){
    $o=new cuntainted();
    $s="hello";
    $o->fref($s)->fref($s)->fref($s);
    $o->fref($s)->fref($s);
    $o->fref($s);
    $o->fref($s," from nick");
    echo "Call-by-ref in an object method: $s\n";
    $o=new ctainted();
    $s="hello";
    $o->fref($s)->fref($s)->fref($s);
    $o->fref($s)->fref($s);
    $o->fref($s);
    $o->fref($s," from nick");
    echo "Call-by-ref in an object method: $s\n";
}
function fffuntainted(){
    $o=new ctainted();
    $s="hello";
    $o->fref($s)->fref($s)->fref($s);
    $o->fref($s)->fref($s);
    $o->fref($s);
    $o->fref($s," from nick");
    echo "Call-by-ref in an object method: $s\n";
    $o=new cuntainted();
    $s="hello";
    $o->fref($s)->fref($s)->fref($s);
    $o->fref($s)->fref($s);
    $o->fref($s);
    $o->fref($s," from nick");
    echo "Call-by-ref in an object method: $s\n";
}

ffftainted();
fffuntainted();

//Returning a reference of a method prototype does not work,
//returns by value. This is due to call_user_func_array().
//$v=&$o->gref(77);
//$o->v1=99;
//echo "return-by-ref in an object method: $v\n";

?>