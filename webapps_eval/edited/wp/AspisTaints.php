<?php
if( isset( $ASPIS_DEF_TAINTS ) ) return;
$ASPIS_DEF_TAINTS = 1;

//New style taint-as arrays
function AspisLibCollapseTaint(&$taint) { //by ref
    if ( $taint===false || $taint===true) {
        return; //no need to change anything
    }
    else {
        //the result here is tainted iff there is one single tainted element
        $isTainted=false;
        foreach ($taint as $v) {
            if ($v) {
                $isTainted=true;
                break;
            }
        }
        $taint=$isTainted;
    }
}
function AspisLibClearTaint(&$taint) {
    $taint=false;
}
function AspisLibMerge($me, $taint1, $taint2) {
    if ($taint2===false) {
        if (is_array($taint1)) $taint1[strlen($me)]=$taint2;
        //else leave it as it is, untainted str attached to untainted str.
        return $taint1;
    }

    //optimize for the common case
    if ( ($taint1===false && $taint2===false) ||
            ($taint1===true && $taint2===true) ) {
        return $taint1; //no need to change anything
    }
    else {
        //the result here must be an array
        if (!is_array($taint1)) {
            $taint=array($taint1);
        }
        else {
            $taint=$taint1; //copy of the taint array
        }
        if (!is_array($taint2)) {
            $mylen=strlen($me);
            $taint[$mylen]=$taint2;
        }
        else {
            $mylen=strlen($me);
            foreach ($taint2 as $k=>$v) $taint[$k+$mylen]=$v;
        }
        return $taint;
    }
}
function AspisLibGetTaintOf($taint,$i) {
    if (!is_array($taint)) {
        return $taint;
    }
    else {
        $keys=array_keys($taint);
        foreach ($taint as $k=>$v) { //let's hope this is ordered...
            //this array must have at least one element
            if ($i<$k) break;
            $prev=$v;
        }
        return $prev;
    }
}
function AspisLibIsTainted($taint) {
    if ($taint===false) return false;
    if ($taint===true) return true;
    foreach ($taint as $t) {
        if ($t===true) return true;
    }
    return false;
}
function AspisLibMakeUseXSS($taint,$data) {
    //calls htmletities() in all tainted substrings
    $res="";
    if ($taint===false) $res=$data;
    else if ($taint===true) {
        $res=htmlentities($data);
//        $res=($data);
    }
    else {
        $temp_taint=false;
        $temp_str="";
        $temp_index=0;
        foreach ($taint as $i=>$t) {
            if ($i>0) {
                $temp_str=substr($data,$temp_index,$i-$temp_index);
                if ($temp_taint) {
                    $res.=htmlentities($temp_str);
//                    $res.=($temp_str);
                }
                else $res.=$temp_str;
            }
            $temp_taint=$t;
            $temp_index=$i;
        }
        $temp_str=substr($data,$temp_index); //the last element
        if ($temp_taint) {
            $res.=htmlentities($temp_str);
//            $res.=($temp_str);
        }
        else $res.=$temp_str;
    }
    return $res;
}
function AspisLibMakeUseSQLI($taint,$data) {
    //calls mysql_real_escape_string() in all tainted substrings
    $res;
    if ($taint===false) $res=$data;
    else if ($taint===true) {
        $res=mysql_real_escape_string($data);
//        $res=($data);
    }
    else {
        $temp_taint=false;
        $temp_str="";
        $temp_index=0;
        foreach ($taint as $i=>$t) {
            if ($i>0) {
                $temp_str=substr($data,$temp_index,$i-$temp_index);
                if ($temp_taint) {
                    $res.=mysql_real_escape_string($temp_str);
//                    $res.=($temp_str);
                }
                else $res.=$temp_str;
            }
            $temp_taint=$t;
            $temp_index=$i;
        }
        $temp_str=substr($data,$temp_index); //the last element
        if ($temp_taint) {
            $res.=mysql_real_escape_string($temp_str);
//            $res.=($temp_str);
        }
        else $res.=$temp_str;
    }
    return $res;
}

//Old style taint-as-objects
$XSSTaintClass="AspisXSSCharacterTaint";
$SQLTaintClass="AspisSQLCharacterTaint";
abstract class AspisTaint {
    public abstract function getTaintOf($index); 
    public abstract function merge($me,$that); //myself with that taint
    public abstract function makeUse($data);
    public abstract function clear(); //I am not tainted any more
    public abstract function collapse(); //I have been transformed
    public abstract function copy();
    public abstract function isTainted(); //used in logging, return true if there is sth tainted
}
abstract class AspisCharacterTaint extends AspisTaint {
    public $taint;
    public function  __construct($isTainted="") {
        if ($isTainted==="" || $isTainted===false) $this->taint=$isTainted;
        else $this->taint=array(true);
    }
    public function getTaintOf($i) {
        if (!is_array($this->taint)) {
            if ($this->taint) {
                $class=get_class($this);
                return new $class(true);
            }
            else return false;
        }
        else {
            $keys=array_keys($this->taint);
            foreach ($this->taint as $k=>$v) { //let's hope this is ordered...
                //this array must have at least one element
                if ($i<$k) break;
                $prev=$v;
            }
            if ($prev) {
                $class=get_class($this);
                return new $class(true);
            }
            else return false;
        }
    }
    public function merge($me,$that) {
        if ($that===false) {
            if (is_array($this->taint)) $this->taint[strlen($me)]=$that;
            //else leave it as it is, untainted str attached to untainted str.
            return $this;
        }
        if (!($this instanceof $that)) die("merge() must be called with the same type of Taint Objects");

        //optimize for the common case
        if ( ($this->taint===false && $that->taint===false) ||
             ($this->taint===true && $that->taint===true) ) {
            return $this; //no need to change anything
        }
        else {
            //the result here must be an array
            if (!is_array($this->taint)) {
                $taint=array($this->taint);
            }
            else {
                $taint=$this->taint; //copy of the taint array
            }
            if (!is_array($that->taint)) {
                $mylen=strlen($me);
                $taint[$mylen]=$that->taint;
            }
            else {
                $mylen=strlen($me);
                foreach ($that->taint as $k=>$v) $taint[$k+$mylen]=$v;
            }
            $this->taint=$taint;
        }
        return $this;
        
    }
    public function clear() {
        $this->taint=false;
        return $this;
    }
    public function collapse() {
        if ( $this->taint===false || $this->taint===true) {
            return; //no need to change anything
        }
        else {
            //the result here is tainted iff there is one single tainted element
            $isTainted=false;
            foreach ($this->taint as $v) {
                if ($v) {
                    $isTainted=true;
                    break;
                }
            }
            $this->taint=$isTainted;
        }
        return $this;
    }
    public function copy() {
        $cl=get_class($this);
        $ret=new $cl;
        $ret->taint=$this->taint; //array is copied by value
        return $ret;
    }
    public function isTainted() {
        if ($this->taint===false) return false;
        if ($this->taint===true) return true;
        foreach ($this->taint as $t) {
            if ($t===true) return true;
        }
        return false;
    }
}

class AspisXSSCharacterTaint extends AspisCharacterTaint {
    public function makeUse($data) {
        //calls htmletities() in all tainted substrings
        $res="";
        if ($this->taint===false) $res=$data; 
        else if ($this->taint===true) {
            //$res=htmlentities($data);
            $res=($data);
        }
        else {
            $temp_taint=false;
            $temp_str="";
            $temp_index=0;
            foreach ($this->taint as $i=>$t) {
               if ($i>0) {
                   $temp_str=substr($data,$temp_index,$i-$temp_index);
                   if ($temp_taint) {
                       //$res.=htmlentities($temp_str);
                       $res.=($temp_str);
                   }
                   else $res.=$temp_str;
               }
               $temp_taint=$t;
               $temp_index=$i;
            }
            $temp_str=substr($data,$temp_index); //the last element
            if ($temp_taint) {
                //$res.=htmlentities($temp_str);
                $res.=($temp_str);
            }
            else $res.=$temp_str;
        }
        return $res;
    }

}
class AspisSQLCharacterTaint extends AspisCharacterTaint {
    public function makeUse($data) {
        //calls mysql_real_escape_string() in all tainted substrings
        $res;
        if ($this->taint===false) $res=$data;
        else if ($this->taint===true) {
            //$res=mysql_real_escape_string($data);
            $res=($data);
        }
        else {
            $temp_taint=false;
            $temp_str="";
            $temp_index=0;
            foreach ($this->taint as $i=>$t) {
               if ($i>0) {
                   $temp_str=substr($data,$temp_index,$i-$temp_index);
                   if ($temp_taint) {
                       //$res.=mysql_real_escape_string($temp_str);
                       $res.=($temp_str);
                   }
                   else $res.=$temp_str;
               }
               $temp_taint=$t;
               $temp_index=$i;
            }
            $temp_str=substr($data,$temp_index); //the last element
            if ($temp_taint) {
                //$res.=mysql_real_escape_string($temp_str);
                $res.=($temp_str);
            }
            else $res.=$temp_str;
        }
        return $res;
    }
}

?>