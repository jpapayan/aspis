<?php
//print_r(get_declared_classes());

function myprint($obj) {
    echo $obj->myobject;
}

class MyClassInternal {
    public $myobject;
//    private $priv="private property";
    public function __construct($obj) {
      $this->myobject=$obj;
    }
}

class MyClassExternal {
    public $myobject;
    public function __construct($obj) {
      $this->myobject=$obj;
    }
    public function get($a) {
        return $this->myobject;
    }
}
$x2=&new MyClassExternal(new MyClassInternal("Hello"));
print_r($x2);
echo $x2->get(0)->myobject."\n";
echo $x2->myobject->myobject."\n";
echo "x2's class name is ".get_class($x2)."\n";

class_alias('MyClassInternal','foo');
$a = new foo("Hello");
var_dump($a == $x2->myobject->myobject, $a === $x2->myobject->myobject);
var_dump($a instanceof $x2->myobject);
//var_dump($b instanceof bar);

class myclass {
    var $var1; // this has no default value...
    var $var2 = "xyz";
    var $var3 = 100;
    private $var4; // PHP 5
    // constructor
    function myclass() {
        // change some properties
        $this->var1 = "foo";
        $this->var2 = "bar";
        return true;
    }

}
$my_class = new myclass();
$class_vars = get_class_vars(get_class($my_class));
foreach ($class_vars as $name => $value) {
    echo "$name : $value\n";
}

function format($array)
{
    return implode('|', array_keys($array)) . "\r\n";
}
class TestCase
{
    public $a    = 1;
    protected $b = 2;
    private $c   = 3;
    public static function expose()
    {
        echo format(get_class_vars(__CLASS__));
    }
}
TestCase::expose();
echo format(get_class_vars('TestCase'));

//print_r(get_declared_interfaces());


class foo2 {
    private $a;
    public $b = -1;
    public $c;
    private $d;
    static $e;
    public function test() {
        print_r(get_object_vars($this));
    }
}
$test = new foo2;
print_r(get_object_vars($test));
echo $test->b;
$test->test();

class dad {
    function dad()
    {
    // implements some logic
    }
}
class child extends dad {
    function child()
    {
        echo "I'm " , get_parent_class($this) , "'s son\n";
    }
}
class child2 extends dad {
    function child2()
    {
        echo "I'm " , get_parent_class('child2') , "'s son too\n";
    }
}
$foo = new child();
$bar = new child2();

class WidgetFactory
{
  var $oink = 'moo';
}
class WidgetFactory_Child extends WidgetFactory
{
  var $oink = 'oink';
}
$WF = new WidgetFactory();
$WFC = new WidgetFactory_Child();
if (is_subclass_of($WFC, 'WidgetFactory')) {
  echo "yes, \$WFC is a subclass of WidgetFactory\n";
} else {
  echo "no, \$WFC is not a subclass of WidgetFactory\n";
}
if (is_subclass_of($WF, 'WidgetFactory')) {
  echo "yes, \$WF is a subclass of WidgetFactory\n";
} else {
  echo "no, \$WF is not a subclass of WidgetFactory\n";
}
// usable only since PHP 5.0.3
if (is_subclass_of('WidgetFactory_Child', 'WidgetFactory')) {
  echo "yes, WidgetFactory_Child is a subclass of WidgetFactory\n";
} else {
  echo "no, WidgetFactory_Child is not a subclass of WidgetFactory\n";
}
if (is_a($WF, 'WidgetFactory')) {
  echo "yes, \$WF is still a WidgetFactory\n";
}

$directory = new Directory('.');
print_r(method_exists($directory,'read'));

class MmyClass {
    public $mine;
    private $xpto;
    static protected $test;

    static function test() {
        print_r(property_exists('MmyClass', 'xpto')); //true
    }
}
print_r(property_exists('MmyClass', 'mine'));   //true
print_r(property_exists(new MmyClass, 'mine')); //true
print_r(property_exists('MmyClass', 'xpto'));   //true, as of PHP 5.3.0
print_r(property_exists('MmyClass', 'bar'));    //false
print_r(property_exists('MmyClass', 'test'));   //true, as of PHP 5.3.0
MmyClass::test();

class Dum
{
  var $a = -1;
  var $a2=array(-8,2);
  //TODO: this fails, got to fix
  //var $a3=array(-8,2,array(2=>3));
  function serialize ( $param ) {

  }
}
$a555=array(-8,2);
$d=new Dum();
print_r($d->a2);
print_r($a555);
//print_r($d->a3);

class Walker  {
	var $db = array ('parent' => 'child');
}
$walker=new Walker();
echo $walker->db['parent']."\n";
foreach ($walker->db as $key=>$value) {
  echo "$key=>$value\n";
}


class Classs {
    var $prop="prop";
}
class Classy {
    var $a="a";
    var $b="b";
    var $c;
    public function __construct() {
        $this->c=new Classs();
    }

}


//Playing with variables after ->
$c=new Classy();
$i="b";
$c->$i="c"; //variable property in the end
$i="c";
$prop="prop";
$c->c->$prop="nothing"; //variable property in the end
echo "$c->a and $c->b and ". $c->c->$prop ."\n";
$c->$i->prop="nothing MORE"; //variable property in the MIDDLE
echo "$c->a and $c->b and ". $c->$i->$prop ."\n";
$c->c=new Classs();
$c->c->$prop="nothing MORE2";
echo "$c->a and $c->b and ". $c->$i->$prop ."\n";


class Cl {
   var $v="12";
}
$c="Cl";
$d=new $c();
echo "$d->v\n";

class MyCloneable
{
    public $object1;
    public $object2;

}
$obj = new MyCloneable();
$obj->object1 = "object2";
$obj->{$obj->object1} = "hidden message!\n";
echo "$obj->object2";

class ClA {
    var $var1="hello";
}
class ClB {
    var $var1="hello1";
}
$o1=new ClA();
$o2=new ClB();
$v="var1";
if ($o1->$v===$o2->$v) echo "success!\n";
else echo "failed\n";

?>