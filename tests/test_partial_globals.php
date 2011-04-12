<?php

function funtainted() {
    $f=$GLOBALS["f"];
    echo "Global f is: $f\n";
}

function ftainted() {
    $f=$GLOBALS["f"];
    echo "Global f is: $f\n";
}

$f=123;
//ftainted();  //DIRECT AcCESSES TO $GLOBALS DO NOT WORK
funtainted();

function funtb() {
    global $v1;
    global $v2;
    if ($v1>10) {
        global $v3;
        echo "v3 is $v3\n";
        return $v3;
    }
    echo "v1 is $v1\n";
    return $v1;
}
$v1=50;
$v2=25;
$v3=35;
funtb();

$gl1=100;
$gl2=200;
function &fchooser($p){
    global $gl1;
    global $gl2;
    if ($p<$gl1) return $gl1;
    else return $gl2;
}
//This is the real test
class wpdb {
    var $v=12;
    function print_me() {
        $a=$this->v+12;
        echo "my value is: $a\n";
    }
}
function fffuntainted() {
    //ERROR: this just doesnt work, refs to globals are returned with ref semantics
//    $r=&fchooser(33);
//    $r=$r+33;
//    echo "local \$r is $r\n";

    global $wpdb,$dummy;
    $v=12;
    ffftainted($v); //error 1-solved
    echo "reference var: $v\n";
    $wpdb->print_me();
    $wpdb=new wpdb();
    $wpdb->v=122;
    return $wpdb->v; //error 2 -solved
}
function ffftainted(&$v) {
    global $wpdb;
    $v=33;
    $wpdb->print_me();
    $wpdb=new wpdb();
    $wpdb->v=1122;
}
$wpdb=new wpdb();
$ret=fffuntainted();
echo "value returned: ".($ret*33)."\n";
ffftainted($a);
$wpdb->print_me();
fffuntainted();

function add_shortcode($tag, $func) {
	global $gl1;
        global $stupid;
        global $stupid_in;
        $stupid_in=33;
//        require_once("test_partial_basic_p2".".php");
//        require "test_partial_basic_p2.php";
        echo "\$stupid that was defined externally: ".($stupid*3)."\n";
	if ( is_string($func) ) {
		$gl1=array($tag=>$func);
                return;
        }
}

add_shortcode("me","add_shortcode");
echo "in global under me:".$gl1["me"]."\n";

class cluntainted {
    function hi() {
        global $global;
        echo "in global under cltainted:hi:".($global*(-1))."\n";
        return $this;
    }
}
function funtainted2() {
    global $global;
    echo "in global under funtb:".($global*(-1))."\n";
    $o=new cluntainted();
    $m="hi";
    $o->hi();
    $o->hi()->hi()->hi();
    global $fake;
    $fake="created internally";
    global $toser;
    $toser=unserialize($toser);
    print_r($toser);
}
$global=122;
$toser=array("a"=>"b","c"=>"d");
$toser=serialize($toser);
funtainted2();
global $fake;
echo "\$fake is: $fake\n";

class cldummy {
    var $a;
    function cldummy() {
        $this->a=array("aa"=>1,"bb"=>2);
    }
    function hi() {
        echo $this->a["aa"]."\n";
    }
}
$a=new cldummy();
extract($a->a,EXTR_SKIP);
echo "aa is: $aa\n";
echo "bb is: $bb\n";

class cldummytainted {
    var $a;
    var $object;
    function cldummytainted() {
        $this->a=array("aa"=>1,"bb"=>2);
        $this->object=(object)array("wow","from object");
    }
    function hi() {
        echo $this->a["aa"]."\n";
    }
}
function fffff() {
    $a=new cldummytainted();
    extract($a->a,EXTR_SKIP);
    echo "aa is: $aa\n";
    echo "bb is: $bb\n";
    $o=$a->object;
    otainted($o);
    foreach ($o as $e) print ("$e\n");
    return $o;
}
function otainted($o) {
    foreach ($o as $e) print ("$e\n");
}
fffff();


function futttt($o) {
    global $objects;
    $objects[]=array($o,"hi");
}

function fut() {
    $o=new cldummy();
    futttt(array(&$o));
    futttt(array(&$o));
}


$objects=array();
fut();
foreach ($objects as $to) {
    $to[0][0]->$to[1]();
}

function &gtainted() {
    $o=&$GLOBALS["post"];
    echo "from gtainted:";
    $o->hi();
    return $GLOBALS["post"];
}
function guntainted() {
    //global $post;
    $o=&gtainted();
    echo "from guntainted:";
    $o->hi();
    gtainted();
}
$GLOBALS["post"]=& new cldummytainted();
//guntainted(); //DIRECT AcCESSES TO $GLOBALS DO NOT WORK


?>