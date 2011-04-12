<?php

///////////////clone and printr/////////////
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

//////array functions/////////
/////////usort///////////////
class cuntainted {
    function cmp($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a > $b) ? -1 : 1;
    }
}
class ctainted {
    function cmp($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a > $b) ? -1 : 1;
    }
}
function cmp($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}
function cmpt($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}

function funtainted() {
    $ar1=array(1,2,3,4);
    $ar2=array(5,6,7,8);
    $ar=array_merge($ar1,$ar2);
    print_r($ar);
    usort($ar,"cmp");
    $ar=array_merge($ar1,$ar2);
    print_r($ar);
    usort($ar,"cmpt");
    print_r($ar);
    $ar=array_merge($ar1,$ar2);
    $o=new ctainted();
    usort($ar,array($o,"cmp"));
    print_r($ar);
    $ar=array_merge($ar1,$ar2);
    $o=new cuntainted();
    usort($ar,array($o,"cmp"));
    print_r($ar);
}
function ftainted() {
    $ar1=array(1,2,3,4);
    $ar2=array(5,6,7,8);
    $ar=array_merge($ar1,$ar2);
    print_r($ar);
    usort($ar,"cmp");
    print_r($ar);
    $ar=array_merge($ar1,$ar2);
    $o=new cuntainted();
    usort($ar,array($o,"cmp"));
    print_r($ar);
    $ar=array_merge($ar1,$ar2);
    $o=new ctainted();
    usort($ar,array($o,"cmp"));
    print_r($ar);
}

ftainted();
funtainted();

/////////////array walk/call_user_func/call_user_func_array//////////////
function funtaa($v,$i,$d) {
    $r=$i*$v+$d;
    echo "value:$r\n";
}
function ftaa($v,$i,$d) {
    $r=$i*$v+$d;
    echo "value:$r\n";
}
function funtaw() {
    $array=array (1,2,3,4,5);
    array_walk($array,"funtaa",1);
    call_user_func("ftaa",222,333,3);
    $o=new ctainted();
    call_user_func("funtaa",222,333,4);
    $o=new ctainted();
    $res=call_user_func(array($o,"cmp"),222,333);
    echo "comparison returned: $res\n";
    $o=new cuntainted();
    $res=call_user_func(array($o,"cmp"),444,333);
    echo "comparison returned: $res\n";
    $o=new cuntainted();
    $res=call_user_func_array(array($o,"cmp"),array(444,333));
    echo "comparison returned: $res\n";
    $res=call_user_func_array("cmp",array(11,333));
    echo "comparison returned: $res\n";
    $o=new ctainted();
    $res=call_user_func_array(array($o,"cmp"),array(444,333));
    echo "comparison returned: $res\n";
    $res=call_user_func_array("cmpt",array(11,333));
    echo "comparison returned: $res\n";
}
function ftaw() {
    $array=array (1,2,3,4,5);
    array_walk($array,"ftaa",1);
    call_user_func("funtaa",222,333,3);
    call_user_func("ftaa",222,333,111);
    $o=new cuntainted();
    $res=call_user_func(array($o,"cmp"),222,333);
    echo "comparison returned: $res\n";
    $o=new ctainted();
    $res=call_user_func(array($o,"cmp"),444,333);
    echo "comparison returned: $res\n";
    $o=new cuntainted();
    $res=call_user_func_array(array($o,"cmp"),array(444,333));
    echo "comparison returned: $res\n";
    $res=call_user_func_array("cmp",array(11,333));
    echo "comparison returned: $res\n";
    $o=new ctainted();
    $res=call_user_func_array(array($o,"cmp"),array(444,333));
    echo "comparison returned: $res\n";
    $res=call_user_func_array("cmpt",array(11,333));
    echo "comparison returned: $res\n";
}
funtaw();
ftaw();

?>