<?php
if( isset( $ASPIS_DEF_OBJ ) ) return;
$ASPIS_DEF_OBJ = 1;

/*
 * Used by full taint tracking and library calls. (maybe not anymore)
 */
class AspisObject {
    public $obj;

    //this is called directly on the object (the obj is not inside an aspis)
    function __construct($classname,$params=dummy) {
        if (empty($classname)) return $classname;
        else if (is_object($classname)) {
            $this->obj=$classname;
        }
        else {
            $class = new ReflectionClass($classname);
            if ($params!=dummy) $this->obj = $class->newInstance($params[0]);
            else $this->obj = $class->newInstance();
        }
    }

    public function getObject() {
        return $this->obj;
    }
    public function __set($name, $value) {
        //TODO: I should keep track of the taint
        $this->obj->$name=$value[0];
    }
    public function __get($name) {
        //TODO: I should keep track of the taint
        return array($this->obj->$name,false);
    }
    public function __isset($name) {
        return array(isset($this->obj->$name),false);
    }
    public function __unset($name) {
        unset($this->obj->$name[0]);
    }
    public function __call($name, $arguments) {
        if (empty($arguments[0])) return array(call_user_func(array($this->obj, $name)),false);
        else return array(call_user_func_array(array($this->obj, $name),$arguments[0]),false);
    }

    /**  As of PHP 5.3.0  */
    public static function __callStatic($name, $arguments) {
    }
}

/*
 * Used by partial taint tracking
 */
class AspisProxy implements Iterator {
    public $obj;
    private $taintedToUntainted;
    //this is called directly on the object (the obj is not inside an aspis)
    function __construct($obj,$taintedToUntainted=true) {
        $this->obj=$obj;
        $this->taintedToUntainted=$taintedToUntainted;
    }
    public function __set($name, $value) {
        if ($this->taintedToUntainted) $this->obj->$name=deAspisWarningRC($value);
        else $this->obj->$name=attAspisRCO($value);
    }
    public function __get($name) {
        //TODO: I should keep track of the taint
        $res;
        if ($this->taintedToUntainted) $res= attAspisRCO($this->obj->$name);
        else $res= deAspisWarningRC($this->obj->$name);
        return $res;
    }
    public function __isset($name) {
        if ($this->taintedToUntainted) return array(isset($this->obj->$name),false);
        else return isset($this->obj->$name);
    }
    public function __unset($name) {
        unset($this->obj->$name);
    }
    public function __call($name, $arguments) {
        if (empty($arguments)) {
            if ($this->taintedToUntainted) {
                $res=call_user_func(array($this->obj, $name));
                $res=attAspisRCO($res);
            }
            else {
                $res=call_user_func(array($this->obj, $name));
                $res=deAspisWarningRC($res);
            }
        }
        else {
            if ($this->taintedToUntainted) {
               foreach ($arguments as &$v) $v=deAspisWarningRC($v);
               $res=call_user_func_array(array($this->obj, $name),$arguments);
               $res=attAspisRCO($res);
            }
            else {
               foreach ($arguments as &$v) $v=attAspisRCO($v);
               $res=call_user_func_array(array($this->obj, $name),$arguments);
               $res=deAspisWarningRC($res);
            }
        }
        return $res;
    }
    public function addsTaint() {
        return !$this->taintedToUntainted;
    }
    /**  As of PHP 5.3.0  */
    public static function __callStatic($name, $arguments) {
    }

    public function __clone()
    {
        $this->obj = clone $this->obj;
        if ($this->it!=NULL) $this->it = clone $this->it;
    }

    /* Iterator Methods */
    private $it;
    public function rewind() {
        $this->it = new ArrayIterator($this->obj);
    }
    public function current() {
        if ($this->taintedToUntainted) return attAspisRCO($this->it->current());
        else return deAspisRCO($this->it->current());
    }
    public function key() {
        return $this->it->key();
    }
    public function next() {
        return $this->it->next();
    }
    public function valid() {
        return $this->it->valid();
    }
}

?>
