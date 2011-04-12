<?php

class MyClassInternal {
    public $myobject;
    public $myarr=array("1,2,3","2");
    public function __construct($obj) {
      $this->myobject=$obj;
    }
    public function id() {
        echo $this->myobject->id();
        $this->myarr[]=12;
        echo count($this->myarr);
    }
}

class MyClassExternal {
    public $myobject;
    public function __construct() {
    }
    public function get() {
        $this->myobject=new MyClassInternal($this);
        return $this->myobject;
    }
    public function id() {
        return "this is external!\n";
    }
}
$x1=new MyClassExternal();
$x2=$x1->get();
$x2->id();

class v {
    var $v="hello2";
}
class c {
    var $c="hello";
    var $v;
}
$vv="v";
$cc="c";
$c=new c();
$c->v=new v();
echo $c->c."\n";
echo $c->v->v."\n";
echo $c->$cc."\n";
echo $c->$vv->$vv."\n";

$a=clone $c;
echo $c->$vv->$vv."\n";

$a=new v();
$b=new c();
$arr=array("v"=>$b,"k"=>$a, "key"=>$a);
//echo $arr["key"]->v."\n";
foreach ($arr as $k=>$v) {
    echo "$k=>$v->v\n";
}

?>