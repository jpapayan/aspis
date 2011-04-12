<?php

$greet = function($name)
{
    echo "Hello $name\r\n";
};

$greet('World');
$greet('PHP');

function hello2($var="papajohn", $var2="panagiota") {
    echo "hello $var + $var2!";
    echo "\n";
}
$v=array("me","you");
hello2($v[0],$v[1]);

function hello($var="papajohn", $n=NULL) {
    echo "hello $var!";
    echo "\n";
    return array(true);
}

$r1=hello("yiannis");
$r2=hello();
if ($r1[0] && $r2[0]) echo "Success!\n";

##variable functions
function foo() {
    echo "In foo()<br />\n";
}
function bar($arg = '')
{
    echo "In bar(); argument was '$arg'.<br />\n";
}
// This is a wrapper function around echo
function echoit($string="default")
{
    echo $string;
}
$func = 'foo';
$func();        // This calls foo()
$func = 'bar';
$func('test');  // This calls bar()
$func = 'echoit';
$func('test');  // This calls echoit()
$a=array("foo","bar","echoit");
foreach ($a as $s) $s();


function p($a,$b,$c="abc") {
    echo "$a $b $c";
}
p("123", "456");


$r=empty($v);
echo $r."d\n";
$v=12;
$r=empty($v);
echo $r."d\n";

$v=33;
$r=isset ($v);
echo $r."d\n";
unset ($v);
$r=isset ($v);
echo $r."d\n";

$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
function test_alter(&$item1, $key, $prefix)
{
    $item1 = "$prefix: $item1";
}
function test_print($item2, $key)
{
    echo "$key. $item2<br />\n";
    $item2="null";
}
echo "Before ...:\n";
array_walk($fruits, 'test_print');
array_walk($fruits, 'test_alter', 'fruit');
echo "... and after:\n";
array_walk($fruits, 'test_print');

$defaults = array(
		'child_of' => 0, 'sort_order' => 'ASC',
		'sort_column' => 'post_title', 'hierarchical' => 1,
		'exclude' => '', 'include' => '',
		'meta_key' => '', 'meta_value' => '',
		'authors' => '', 'parent' => -1, 'exclude_tree' => '',
		'number' => '', 'offset' => 0
	);
extract( $defaults, EXTR_SKIP );
$number=(int)$number;
echo $number.$child_of.$sort_order."\n";

function faf() {
        echo "hello world from function!\n";
    }
class cac {
    function f($p="") {
        echo "hello world from method f $p!\n";
    }
    function g($v) {
        echo "hello world from method g! $v\n";
        $v="f";
        $this->$v("with parameter");
    }
}
$c=new cac();
$v="f";
$c->$v();
$v="faf";
$v();
$v="g";
$c->$v(12);
//must become AspisDynamicCall(array(array($c,$v),false));

class cla {
    var $data=array("data"=>"aaa");
    var $var;
    function  __construct() {
        $this->var=$this;
    }
}
$cc=new cla();
$s=serialize($cc);
$c=unserialize($s);
echo $c->data["data"]."\n";
?>
