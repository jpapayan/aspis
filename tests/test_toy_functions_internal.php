<?php

function myprint($name="",$surname="") {
    echo "hello! $name $surname\n";
    #printf("Hello %s\r\n",$name);
}

$greet = function($name="",$surname="")
{
    echo "hello! $name $surname\n";
    #printf("Hello %d\r\n",$name);
};
$greet('Ioannis',"Papagiannis");
$greet="myprint";
$greet('Matteo %s');
$greet="printf";
$greet('Matteo %s\n',"rocks");

$c='cello';
$c=$c[0];
if ($c=='c') echo "\nIt is c!\n";

myprint("Nick","Carter");
printf("Hello World\n");
printf("from %s\n","yiannis");
$x=rand(0,0);
printf("random number=%d\n",$x);

if (isset ($x)) {
    echo "x is actually set\n";
}
else echo "x is NOT set\n";
if (empty ($x)) {
    echo "x is actually empty\n";
}
else echo "x is NOT empty\n";

die('-5');

class SubObject
{
    static $instances = 0;
    public $instance;

    public function __construct() {
        $this->instance = ++self::$instances;
    }

    public function __clone() {
        $this->instance = ++self::$instances;
    }
}
class MyCloneable
{
    public $object1;
    public $object2;

    function __clone()
    {
        // Force a copy of this->object, otherwise
        // it will point to same object.
        $this->object1 = clone $this->object1;
    }
}
$obj = new MyCloneable();
$obj->object1 = new SubObject();
$obj->object2 = new SubObject();
$obj2 = clone $obj;
print("Original Object:\n");
print_r($obj);
print("Cloned Object:\n");
print_r($obj2);

$datefunc = 'date';
$tmptmp=$datefunc( 'm', 5 );
echo $tmptmp."\n";

function f() {
    $v=func_get_args();
    echo "$v[0]\n";
    $v=func_get_arg(0);
    echo "$v\n";
    $v=func_num_args();
    echo "$v\n";
}
f("papa");

$city  = "San Francisco";
$state = "CA";
$event = "SIGGRAPH";
$location_vars = array("city", "state");
$result = compact("event", "nothing_here", $location_vars);
print_r($result);

class cla {
    function  __construct() {
    }
    function f() {
        $a=array("cla"=>"found!");
        if (isset($a[get_class($this)])) echo $a[get_class($this)]."\n";
    }
}
$cc=new cla();
if (get_class($cc)==="cla") echo "class found!\n";
else echo "class not found\n";
$cc->f();
$name="cc";
$$name->f();

$a=array();
$a[13]=4;
$a[12]=4;
if (!(isset($a[12]) && isset($a[15]))) echo "error";
else echo "correct";
?>
