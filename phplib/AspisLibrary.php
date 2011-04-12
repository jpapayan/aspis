<?php
if( isset( $ASPIS_DEF_LIB ) ) return;
$ASPIS_DEF_LIB = 1;
$ASPIS_PIPE_SEND="/tmp/aspis_pipe_from_php";
$ASPIS_PIPE_RECEIVE="/tmp/aspis_pipe_from_parser";
define("dummy","dummy");
/*
 * Helper function, used to collapse all taints when a string is altered by an internal function
 */
function AspisCollapsedTaintCopy($string,$removeIndex=-1) {
    $ret=array ($string[0]);
    if ($string[1]===false) $ret[1]=false;
    else {
        $ret[1]=array();
        $c=0;
        foreach ($string[1] as $taint) {
            $ret[1][$c] = $taint;
            if ($c!==$removeIndex) AspisLibCollapseTaint($ret[1][$c]);
            else AspisLibClearTaint($ret[1][$c]);
            $c++;
        }
    }
    return $ret;
}
function AspisTaintCopy($string) {
    return $string;
}
function AspisCollapsedTaintBareCopy($taint,$removeIndex=-1) {
    if ($taint===false) $ret=false;
    else {
        $ret=array();
        $c=0;
        foreach ($taint as $t) {
            $ret[$c] = $t;
            if ($c!==$removeIndex) AspisLibCollapseTaint($ret[$c]);
            else AspisLibClearTaint($ret[$c]);
            $c++;
        }
    }
    return $ret;
}
function AspisTaintBareCopy($taint) {
    return $taint;
}
/*
 * Rreturns the taint at a given positition that spans len characters.
 */
function AspisTaintAt($taint,$pos,$len=-1) {
    if (is_array($taint)) {
        $res=array();
        foreach ($taint as $t) { //foreach taint category
            if (!is_array($t)) {
                $res[]=$t;
                continue;
            }
            $category=array();
            $started=false;
            foreach ($t as $k=>$v) {
                if (!$started) {
                    if ($pos>$k) {
                        $last=$v;
                        continue;
                    }
                    else if ($pos==$k) {
                        $started=true;
                        $category[0]=$v;
                    }
                    else {
                        $started=true;
                        $category[0]=$last;
                        if ($len==-1 || $k-$pos<$len) $category[$k-$pos]=$v;
                    }
                }
                else {
                    if ($len!=-1 && $k-$pos>$len) break;
                    else $category[$k-$pos]=$v;
                }
            }
            $res[]=$category;
        }
        return $res;
    }
    else return $taint;
}
function AspisCollapsedTaintMerge($taint1,$taint2) {
    $result=array();
    for ($c=0 ; $c<count($taint1) ; $c++) {
       if (is_array($taint1[$c])) AspisLibCollapseTaint($taint1[$c]);
       if (is_array($taint2[$c])) AspisLibCollapseTaint($taint2[$c]);
       $result[]= ($taint1[$c]==true || $taint2[$c]==true);
    }
    return $result;
}
function AspisTaintMerge($o1,$o2) {
    return false;
}
function AspisTaintReverse($o1) {
    return false;
}

function Aspis_abs($a) {
    $a[0]=abs($a[0]);
    $a[1]=AspisTaintBareCopy($a[1]);
    return $a;
}
function Aspis_addcslashes($str, $charlist) {
   $str[0]=addcslashes($str[0],$charlist[0]);
   return AspisCollapsedTaintCopy($str);

}
function Aspis_array_change_key_case($a, $case=dummy) {
    if ($case===dummy) $a[0]=array_change_key_case($a[0]);
    else $a[0]=array_change_key_case($a[0],$case[0]);
    return AspisTaintCopy($a);
}
function Aspis_array_diff($base) {
    $arrays=func_get_args();
    $args=array();
    foreach ($arrays as $a) {
        $args[]=deAspisRC($a);
    }
    $res=call_user_func_array("array_diff",$args);
    foreach ($res as &$e) {
        foreach($base as $b) {
            if (deAspisRC($b)===$e) {
                $e=$b;
                break;
            }
        }
    }
    unset($e);
    return array($res,false);
}
function Aspis_array_fill($start_index ,$num ,$value) {
    if ($value[1]===false) {
        $value[]=false;
        return array(array_fill($start_index[0],$num[0],$value),false);
    }
    else {
        $res=array(array_fill($start_index[0],$num[0],$value),false);
        foreach ($res[0] as &$v) {
            $v=AspisTaintCopy($v);
        }
        unset($v);
        return $res;
    }
}
function Aspis_array_flip($ar) {
    $res=array();
    foreach ($ar[0] as $k=>$v) {
        if (isset($v[2])) $res[$v[0]]=array($k,$v[2],$v[1]);
        else $res[$v[0]]=array($k,false,$v[1]);
    }
    return array($res,false);
}
function Aspis_array_intersect($base) {
    $arrays=func_get_args();
    $args=array();
    foreach ($arrays as $a) {
        $args[]=deAspisRC($a);
    }
    $res=call_user_func_array("array_intersect",$args);
    foreach ($res as $k=>&$e) {
        $e=$base[0][$k];
    }
    unset($e);
    return array($res,false);
}
function Aspis_array_intersect_assoc($base) {
    $arrays=func_get_args();
    $args=array();
    foreach ($arrays as $a) {
        $args[]=deAspisRC($a);
    }
    $res=call_user_func_array("array_intersect_assoc",$args);
    foreach ($res as $k=>&$e) {
        $e=AspisTaintCopy($base[0][$k]);
        if (isset($base[0][$k][2])) {
            $e[]=AspisTaintBareCopy($base[0][$k][2]);
        }
    }
    unset($e);
    return array($res,false);
}
function Aspis_array_keys($array) {
    $result=array();
    foreach ($array[0] as $key=>$value) {
        if (isset($value[2])) $result[]=array($key,AspisTaintBareCopy($value[2]));
        else $result[]=array($key,false);
    }
    return array($result,false);
}
function Aspis_array_map() {
    $args=func_get_args();
    $f=array_shift($args);
    
}
function Aspis_array_merge() {
    $params=func_get_args();
    foreach ($params as &$param) {
        $param=$param[0]; //remove the external aspides
    }
    return array(call_user_func_array("array_merge",$params),false);
}
function Aspis_array_merge_recursive() {
    $params=func_get_args();
    foreach ($params as &$param) {
        $param=$param[0]; //remove the external aspides
    }
    return array(call_user_func_array("array_merge",$params),false);
}
function Aspis_array_push(&$ar) {
    $args=func_get_args();
    $c=count($args);
    for ($i=1;$i<$c;$i++) $ar[0][]=$args[$i];
    return array(count($ar[0]),false);
}
function Aspis_array_pop(&$a) {
    return array_pop($a[0]);
}
function Aspis_array_rand($a,$in=dummy) {
    if ($in===dummy) {
        $ret=array_rand($a[0]);
    }
    else {
        $ret=array_dummy($a[0],$in[0]);
    }
    foreach ($ret as &$k) {
        if (isset($a[0][$k][2])) $k=array($k,AspisTaintBareCopy($a[0][$k][2]));
        else $k=array($k,false);
    }
    unset ($k);
    return array($ret,false);
}
function Aspis_array_reverse($a,$pk=dummy) {
    if ($pk===dummy) $ret=array_reverse($a[0]);
    else $ret=array_reverse($a[0],$pk[0]);
    return array($ret,false);
}
function Aspis_array_search($needle,$haystack,$strick=dummy) {
    $needle=deAspisRC($needle);
    $haystack_original=$haystack;
    $haystack=deAspisRC($haystack);
    if ($strick===dummy) {
        $ret=array_search($needle,$haystack);
    }
    else {
        $ret=array_search($needle,$haystack,$strick[0]);
    }
    if ($ret===false) return array($ret,false);
    else if (isset($haystack_original[0][$ret][2])) return array($ret,AspisTaintBareCopy($haystack_original[0][$ret][2]));
    else return array($ret,false);
}
function Aspis_array_shift(&$a) {
    return array_shift($a[0]);
}
function Aspis_array_slice($arr,$offset,$length=dummy,$preserve_keys=dummy) {
    $result=null;
    if ($length==dummy) {
        $result=array_slice($arr[0],$offset[0]);
    }
    else if ($preserve_keys==dummy) {
        $result=array_slice($arr[0],$offset[0],$length[0]);
    }
    else $result=array_slice($arr[0],$offset[0],$length[0],$preserve_keys[0]);
    foreach ($result as $k=>&$v) {
        $v[1]=AspisTaintBareCopy($v[1]);
        if (isset($v[2])) $v[2]=AspisTaintBareCopy($v[2]);
    }
    return array($result,false);

}
function Aspis_array_splice(&$input , $offset , $length = dummy , $replacement=dummy ) {
    if ($length===dummy) return array(array_splice($input[0], $offset[0]),false);
    else if ($replacement===dummy) return array(array_splice($input[0], $offset[0],$length[0]),false);
    else {
        foreach ($replacement[0] as &$r) {
            $r[1]=AspisTaintBareCopy($r[1]);
            if (isset($r[2])) $r[2]=AspisTaintBareCopy($r[2]);
        }
        unset($r);
        return array(array_splice($input[0], $offset[0],$length[0], $replacement[0]),false);
    }
}
function Aspis_array_unique($ar,$flags=dummy) {
    $ar_original=$ar;
    $ar=deAspisRC($ar);
}
function Aspis_array_unshift(&$array,$var) {
    for ($i = func_num_args()-1 ; $i > 0 ; $i--) {
       $e=func_get_arg($i);
       $e[1]=AspisTaintBareCopy($e[1]);
       $res=array_unshift($array[0],$e);
    }
    return $res;
}
function Aspis_array_values($a) {
    $ret=array();
    foreach ($a[0] as $v) {
        $ret[]=array($v[0],AspisTaintBareCopy($v[1]));
    }
    return array($ret,false);
}
function Aspis_array_walk(&$arr, $cb, $data=NULL) {
   global $built_in_functions;
   if (empty($built_in_functions)) {
       load_functions();
   }
   if (is_string($cb[0]) && isset($built_in_functions[$cb[0]])) {
       die("Aspis_array_walk does not support calls with built in functions (yet): ".$cb[0]."\n");
   }
   else {
       $cb=deAspisCallback($cb);
       $nfunction=function (&$value,$key,$data=NULL) use ($cb) {
          //TODO: it only works when $cb is a string, not a class method.
               if (isset($value[2])) {
                   $tmp=$value[2];
                   $key=array($key,AspisTaintBareCopy($tmp)); //use the taint of the key
               }
               else {
                   $tmp=false;
                   $key=array($key,false); //use the taint of the key
               }
               if ($data!==NULL) {
                   if (is_string($cb)) $ret=$cb($value,$key,$data);
                   else if (is_object($cb[0])) $ret=$cb[0]->$cb[1]($value,$key,$data);
                   else die("Aspis_array_walk does not support this type of callback");
               }
               else {
                   if (is_string($cb)) $ret=$cb($value,$key);
                   else if (is_object($cb[0])) $ret=$cb[0]->$cb[1]($value,$key);
                   else die("Aspis_array_walk does not support this type of callback");
               }
               $value[2]=$tmp; //restore the taint of the key, as it may have changed
           };
       if ($data===NULL) return array(array_walk($arr[0],$nfunction),false);
       else return array(array_walk($arr[0],$nfunction,$data),false);
   }
}
function AspisTainted_array_walk(&$arr, $cb, $data=NULL) {
   global $built_in_functions;
   if (empty($built_in_functions))  load_functions();
   global $aspis_taint_details;
   if (empty ($aspis_taint_details)) loadTaintDetails();
   
   if (is_string($cb[0]) && (isset($built_in_functions[$cb[0]]) || !isset($aspis_taint_details[0][$cb[0]]) )) {
       die("AspisTainted_array_walk does not support calls with built/untainted functions (yet): ".$cb[0]."\n");
   }
   else {
       $cb=deAspisCallback($cb);
       //the function is tainted
       $nfunction=function (&$value,$key,$data=NULL) use ($cb) {
                   //TODO: it only works when $cb is a string, not a class method.
                   if (isset($value[2])) {
                       $tmp=$value[2];
                       $key=array($key,AspisTaintBareCopy($tmp)); //use the taint of the key
                   }
                   else {
                       $tmp=false;
                       $key=array($key,false); //use the taint of the key
                   }
                   if ($data!==NULL) {
                       if (is_string($cb)) $ret=$cb($value,$key,$data);
                       else if (is_object($cb[0])) $ret=$cb[0]->$cb[1]($value,$key,$data);
                       else die("AspisTainted_array_walk does not support this type of callback");
                   }
                   else {
                       if (is_string($cb)) $ret=$cb($value,$key);
                       else if (is_object($cb[0])) $ret=$cb[0]->$cb[1]($value,$key);
                       else die("AspisTainted_array_walk does not support this type of callback");
                   }
                   $value[2]=$tmp; //restore the taint of the key, as it may have changed
               };
       if ($data===NULL) return array(array_walk($arr[0],$nfunction),false);
       else return array(array_walk($arr[0],$nfunction,$data),false);

   }
}
function AspisUntainted_array_walk(&$arr, $cb, $data=NULL) {
   global $built_in_functions;
   if (empty($built_in_functions))  load_functions();
   global $aspis_taint_details;
   if (empty ($aspis_taint_details)) loadTaintDetails();

   if (is_string($cb) && (!isset($built_in_functions[$cb]) && isset($aspis_taint_details[0][$cb]) )) {
       die("AspisUntainted_array_walk does not support calls with tainted functions (yet): ".$cb."\n");
   }
   else {
       //the function is untainted (or appears as so, ie object methods)
       if ($data===NULL) return array_walk($arr,$cb);
       else return array_walk($arr,$cb,$data);
   }
}
//The glory of PHP library syntax...
function Aspis_array_multisort1(&$array) {
   $array=&deAspisR($array);
   $res=array_multisort($array);
   $array=&attAspisR($array);
   return array($res,0);
}
function Aspis_array_multisort2(&$array,$p1) {
    $array=&deAspisR($array);
   $res=array_multisort($array,$p1[0]);
   $array=&attAspisR($array);
   return array($res,0);
}
function Aspis_array_multisort3(&$array,$p1,$p2) {
   $array=&deAspisR($array);
   $res=array_multisort($array,$p1[0],$p2[0]);
   $array=&attAspisR($array);
   return array($res,0);
}
function Aspis_array_multisort4(&$array,$p1,$p2,$p3) {
   $array=&deAspisR($array);
   $res=array_multisort($array,$p1[0],$p2[0],$p3[0]);
   $array=&attAspisR($array);
   return array($res,0);
}
function Aspis_array_multisort5(&$array,$p1,$p2,$p3,$p4) {
   $array=&deAspisR($array);
   $res=array_multisort($array,$p1[0],$p2[0],$p3[0],$p4[0]);
   $array=&attAspisR($array);
   return array($res,0);
}
function Aspis_array_multisort6(&$array,$p1,$p2,$p3,$p4,$p5) {
   $array=&deAspisR($array);
   $res=array_multisort($array,$p1[0],$p2[0],$p3[0],$p4[0],$p5[0]);
   $array=&attAspisR($array);
   return array($res,0);
}
function Aspis_asort(&$a,$flags=dummy) {
    $a_original=$a;
    $an=deAspisRC($a);
    if ($flags===dummy) $res=asort($an);
    else $res=asort($an,$flags[0]);
    foreach ($an as $k=>&$v) {
        if (isset($a_original[0][$k][2])) $v=array($v,$a_original[0][$k][1],$a_original[0][$k][2]);
        else $v=array($v,$a_original[0][$k][1]);
    }
    $a=array($an,false);
    return array($res,false);
}
function Aspis_base64_decode($data,$strict=dummy) {
    if ($strict===dummy) return array(base64_decode($data[0]),AspisTaintBareCopy($data[1]));
    else return array(base64_decode($data[0],$strict[0]),AspisCollapsedTaintBareCopy($data[1]));
}
function Aspis_base64_encode($data) {
    return array(base64_encode($data[0]),AspisCollapsedTaintBareCopy($data[1]));
}
function Aspis_base_convert($number,$from,$to) {
    return array(base_convert($number[0],$from[0],$to[0]),AspisCollapsedTaintBareCopy($number[1]));

}
function Aspis_basename($path,$suffix=dummy) {
    if ($suffix===dummy) $ret=basename($path[0]);
    else $ret=basename($path[0],$suffix[0]);
    if (strlen($ret)>0) {
        $pos=strpos($path[0],$ret);
        return array($ret,AspisTaintAt($path[1],$pos,strlen($ret)));
    }
    else return array($ret,false);
}
function Aspis_bin2hex($str) {
    return array(bin2hex($str[0],AspisCollapsedTaintBareCopy($str[1])));
}
function Aspis_call_user_func() {
   global $built_in_functions;
   if (empty($built_in_functions)) {
       load_functions();
   }
   $params=func_get_args();
   $name=$params[0];
   if (is_string($name[0]) && isset($built_in_functions[$name[0]])) {
       //TODO: Doesn't handle cases where the built in function uses callback
       //TODO: I have to read all function definitions and call AspisInternalCallback
       foreach ($params as &$param) {
           $param=deAspisRC($param);
       }
       $params[]=array(); //no ref parameters
       $ret=call_user_func_array("AspisInternalFunctionCall",$params);
       if ($ret===FALSE) $ret=array($ret,false);
       return $ret;
   }
   else {
       array_shift($params);
       $ret=call_user_func_array(deAspisCallback($name),$params);
       if ($ret===FALSE) $ret=array($ret,false);
       return $ret;
   }
}
function AspisTainted_call_user_func() {
   global $built_in_functions;
   if (empty($built_in_functions)) {
       load_functions();
   }
   global $aspis_taint_details;
   if (empty ($aspis_taint_details)) loadTaintDetails();
   
   $params=func_get_args();
   $name=deAspisCallback($params[0]);
   if (is_string($name) && (isset($built_in_functions[$name]) || !isset($aspis_taint_details[0][$name])) ) {
       //TODO: Doesn't handle cases where the built in function uses callback
       //TODO: I have to read all function definitions and call AspisInternalCallback
       foreach ($params as &$param) {
           $param=deAspisRCO($param);
       }
       $params[]=array(); //no ref parameters
       $ret=call_user_func_array("AspisUntaintedFunctionCall",$params);
       if ($ret===FALSE) $ret=array($ret,false);
       return $ret;
   }
   $class="AspisFakeClass";
   if (is_array($name)) {
       if (is_object($name[0])) $class=get_class($name[0]);
       else $class=$name[0];
   }
   if ($class==="AspisProxy") {
       foreach ($params as &$param) {
           $param=deAspisRCO($param);
       }
       $params[]=array(); //no ref parameters
       $params[0]=array($name[0]->obj,$name[1]);
       $ret=call_user_func_array("AspisUntaintedFunctionCall",$params);
       if ($ret===FALSE) $ret=array($ret,false);
       return $ret;
   }
   else {
       array_shift($params);
       $ret=call_user_func_array($name,$params);
       if ($ret===FALSE) $ret=array($ret,false);
       return $ret;
   }
}
function AspisUntainted_call_user_func() {
   global $built_in_functions;
   if (empty($built_in_functions)) {
       load_functions();
   }
   global $aspis_taint_details;
   if (empty ($aspis_taint_details)) loadTaintDetails();

   $params=func_get_args();
   $name=array_shift($params);
   if (is_string($name) && (!isset($built_in_functions[$name]) && isset($aspis_taint_details[0][$name])) ) {
       //TODO: Doesn't handle cases where the built in function uses callback
       //TODO: I have to read all function definitions and call AspisInternalCallback
       foreach ($params as &$param) {
           $param=attAspisRCO($param);
       }
       array_unshift($params,$name);
       $params[]=array(); //no ref parameters
       $total_params=count($params);
       switch ($total_params) {
           case 0:
               $ret=AspisTaintedFunctionCall();
               break;
           case 1:
               $ret=AspisTaintedFunctionCall($params[0]);
               break;
           case 2:
               $ret=AspisTaintedFunctionCall($params[0],$params[1]);
               break;
           case 3:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2]);
               break;
           case 4:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]);
               break;
           case 5:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4]);
               break;
           case 6:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5]);
               break;
           case 7:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6]);
               break;
           case 8:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7]);
               break;
           case 9:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7],$params[8]);
               break;
           case 10:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7],$params[8]
                       ,$params[9]);
               break;
           default:
               $ret=call_user_func_array("AspisTaintedFunctionCall",$params);
               break;
       }
       return $ret;
   }
   $class="AspisFakeClass";
   $is_array_name=is_array($name);
   $is_object=false;
   if ($is_array_name) {
       if (!is_string($name[0])) {
           $is_object=true;
           $class=get_class($name[0]);
       }
   }
   if ($is_object && $class==="AspisProxy") {
       foreach ($params as &$param) {
           $param=attAspisRCO($param);
       }
       array_unshift($params,$name);
       $params[]=array(); //no ref parameters
       $params[0]=array($name[0]->obj,$name[1]);
       $total_params=count($params);
       switch ($total_params) {
           case 0:
               $ret=AspisTaintedFunctionCall();
               break;
           case 1:
               $ret=AspisTaintedFunctionCall($params[0]);
               break;
           case 2:
               $ret=AspisTaintedFunctionCall($params[0],$params[1]);
               break;
           case 3:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2]);
               break;
           case 4:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]);
               break;
           case 5:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4]);
               break;
           case 6:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5]);
               break;
           case 7:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6]);
               break;
           case 8:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7]);
               break;
           case 9:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7],$params[8]);
               break;
           case 10:
               $ret=AspisTaintedFunctionCall($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7],$params[8]
                       ,$params[9]);
               break;
           default:
               $ret=call_user_func_array("AspisTaintedFunctionCall",$params);
               break;
       }
       return $ret;
   }
   else if ($is_object) {
       $total_params=count($params);
       switch ($total_params) {
           case 0:
               if ($is_array_name) $ret=$name[0]->$name[1]();
               else $ret=$name();
               break;
           case 1:
               if ($is_array_name) $ret=$name[0]->$name[1]($params[0]);
               else $ret=$name($params[0]);
               break;
           case 2:
               if ($is_array_name) $ret=$name[0]->$name[1]($params[0],$params[1]);
               else $ret=$name($params[0],$params[1]);
               break;
           case 3:
               if ($is_array_name) $ret=$name[0]->$name[1]($params[0],$params[1],$params[2]);
               else $ret=$name($params[0],$params[1],$params[2]);
               break;
           case 4:
               if ($is_array_name) $ret=$name[0]->$name[1]($params[0],$params[1],$params[2],$params[3]);
               else $ret=$name($params[0],$params[1],$params[2],$params[3]);
               break;
           case 5:
               if ($is_array_name) $ret=$name[0]->$name[1]($params[0],$params[1],$params[2],$params[3]
                       ,$params[4]);
               else $ret=$name($params[0],$params[1],$params[2],$params[3],$params[4]);
               break;
           case 6:
               if ($is_array_name) $ret=$name[0]->$name[1]($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5]);
               else $ret=$name($params[0],$params[1],$params[2],$params[3],$params[4],$params[5]);
               break;
           case 7:
               if ($is_array_name) $ret=$name[0]->$name[1]($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6]);
               else $ret=$name($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6]);
               break;
           case 8:
               if ($is_array_name) $ret=$name[0]->$name[1]($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7]);
               else $ret=$name($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7]);
               break;
           case 9:
               if ($is_array_name) $ret=$name[0]->$name[1]($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7],$params[8]);
               else $ret=$name($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7],$params[8]);
               break;
           case 10:
               if ($is_array_name) $ret=$name[0]->$name[1]($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7],$params[8]
                       ,$params[9]);
               else $ret=$name($params[0],$params[1],$params[2],$params[3]
                       ,$params[4],$params[5],$params[6],$params[7],$params[8]
                       ,$params[9]);
               break;
           default:
               $ret=call_user_func_array($name,$params);
               break;
       }
       return $ret;
   }
   else {
       return call_user_func_array($name,$params);
   }
}
function Aspis_call_user_func_array($name,$params) {
   global $built_in_functions;
   if (empty($built_in_functions)) {
       load_functions();
   }
   if (is_string($name[0]) && isset($built_in_functions[$name[0]])) {
       //TODO: Doesn't handle cases where the built in function uses callback
       //TODO: I have to read all function definitions and call AspisInternalCallback
       $params=func_get_args();
       $name=$params[0];
       
       foreach ($params as &$param) { //actually, just the name and the arg array
           $param=deAspisRC($param);
       }
       
       $params[]=array(); //no ref parameters
       $params[1]=$params[1][0];
       $ret=call_user_func_array("AspisInternalFunctionCall",$params);
       if ($ret===FALSE) $ret=array($ret,false);
       return $ret;
   }
   else {
       /*
        * If the called function expects objects, then an explicit refernce is not required by PHP.
        * But, if, insted, I pass an array that contains the object, then the reference is required.
        * To solve this, I always try to pass references. If I got references as input,
        * then everything is ok. If I got copies, then I pass references to these copies: no harm done.
        */
       $params_ref=array();
       foreach ($params[0] as &$p) {
           $params_ref[]=&$p;
       }
       $ret=call_user_func_array(deAspisCallback($name),$params_ref);
       if ($ret===FALSE) $ret=array($ret,false);
       return $ret;
   }
}
function AspisTainted_call_user_func_array($name,$params) {
   global $built_in_functions;
   if (empty($built_in_functions)) load_functions();
   global $aspis_taint_details;
   if (empty ($aspis_taint_details)) loadTaintDetails();

   $name=deAspisCallback($name);

   $class="AspisFakeClass";
   if (is_array($name)) {
       
       $class=get_class($name[0]);
   }
   
   //untainted case
   if ( (is_string($name) && (isset($built_in_functions[$name]) || !isset($aspis_taint_details[0][$name])  ) )
           || $class==="AspisProxy") {
       //TODO: Doesn't handle cases where the built in function uses callback
       //I have to read all function definitions and call AspisInternalCallback
       //TODO: This does not work with reference params (the else case does though)
       $params=$params[0];
       foreach ($params as &$param) { //actually, just the name and the arg array
           $param=deAspisRCO($param);
       }
       unset($param);
       if ($class=="AspisProxy") $name[0]=$name[0]->obj;
       array_unshift($params,$name);
       $params[]=array(); //no ref parameters
       $ret=call_user_func_array("AspisUntaintedFunctionCall",$params);
       if ($ret===FALSE) $ret=array($ret,false);
       return $ret;
   }
   //tainted case
   else {
       /*
        * If the called function expects objects, then an explicit refernce is not required by PHP.
        * But, if, insted, I pass an array that contains the object, then the reference is required.
        * To solve this, I always try to pass references. If I got references as input,
        * then everything is ok. If I got copies, then I pass references to these copies: no harm done.
        */
       $params_ref=array();
       foreach ($params[0] as &$p) {
           $params_ref[]=&$p;
       }
       $ret=call_user_func_array($name,$params_ref);
       if ($ret===FALSE) $ret=array($ret,false);
       return $ret;
   }
}
function AspisUntainted_call_user_func_array($name,$params) {
   global $built_in_functions;
   if (empty($built_in_functions)) load_functions();
   global $aspis_taint_details;
   if (empty ($aspis_taint_details)) loadTaintDetails();

   $class="AspisFakeClass";
   if (is_array($name)) $class=get_class($name[0]);

   //tainted case
   if ( (is_string($name) && (!isset($built_in_functions[$name]) && isset($aspis_taint_details[0][$name])  ) )
           || $class==="AspisProxy") {
       //TODO: Doesn't handle cases where the built in function uses callback
       //I have to read all function definitions and call AspisInternalCallback
       //TODO: This does not work with reference params (the else case does though)
       foreach ($params as &$param) { //actually, just the name and the arg array
           $param=attAspisRCO($param);
       }
       unset($param);
       if ($class=="AspisProxy") $name[0]=$name[0]->obj;
       array_unshift($params,$name);
       $params[]=array(); //no ref parameters
       return call_user_func_array("AspisTaintedFunctionCall",$params);
   }
   //untainted case
   else {
       /*
        * If the called function expects objects, then an explicit refernce is not required by PHP.
        * But, if, insted, I pass an array that contains the object, then the reference is required.
        * To solve this, I always try to pass references. If I got references as input,
        * then everything is ok. If I got copies, then I pass references to these copies: no harm done.
        */
       $params_ref=array();
       foreach ($params as &$p) {
           $params_ref[]=&$p;
       }
       return call_user_func_array($name,$params_ref);
   }
}
function Aspis_chop($str,$charlist){
    return Aspis_rtrim($str,$charlist);

}
function Aspis_chr($i) {
    return array(chr($i[0],AspisCollapsedTaintBareCopy($i[1])));
}
function Aspis_create_function($params,$code) {
    global $ASPIS_PIPE_SEND;
    global $ASPIS_PIPE_RECEIVE;

    //is it there in the cache?
    if (isset($_SERVER[0]['HTTP_USER_AGENT'])) {
        $dynamic_functions=zend_shm_cache_fetch('wp_dynamic_functions');
        if ($dynamic_functions!==false )  {
            if (isset ($dynamic_functions[$code[0]]) && !empty($dynamic_functions[$code[0]])) {
//                echo "Dynamic function <br>$code[0]<br> is in cache!<br>";
                return create_function($params[0],$dynamic_functions[$code[0]]);
            }
        }
    }

    $r=posix_mkfifo($ASPIS_PIPE_SEND,0777);
    if (!$r) {
        unlink($ASPIS_PIPE_SEND);
        $r=posix_mkfifo($ASPIS_PIPE_SEND,0777);
        if (!$r) die("Could not create pipe $ASPIS_PIPE_SEND\n");
    }
    $r=posix_mkfifo($ASPIS_PIPE_RECEIVE,0777);
    if (!$r) {
        unlink($ASPIS_PIPE_RECEIVE);
        $r=posix_mkfifo($ASPIS_PIPE_RECEIVE,0777);
        if (!$r) die("Could not create pipe $ASPIS_PIPE_RECEIVE\n");
    }
    if (!$r) die("Could not create pipe $ASPIS_PIPE\n");
    exec("phpaspis -in $ASPIS_PIPE_SEND -out $ASPIS_PIPE_RECEIVE -mode online >/dev/null &",$a);
    $handle_send = fopen($ASPIS_PIPE_SEND, 'w');
    fwrite($handle_send, "<?php ".$code[0]);
    fclose($handle_send);
    $a=file($ASPIS_PIPE_RECEIVE);
    array_shift($a);
    unlink($ASPIS_PIPE_SEND);
    unlink($ASPIS_PIPE_RECEIVE);

    $rewritten=implode($a);
    //store it to the cache
    if (isset($_SERVER[0]['HTTP_USER_AGENT'])) {
        $dynamic_functions=zend_shm_cache_fetch('wp_dynamic_functions');
//        echo "Storing rewritten version: $rewritten<br>";
        if ($dynamic_functions!==false )  {
            $dynamic_functions[$code[0]]=$rewritten;
            zend_shm_cache_store('wp_dynamic_functions',$dynamic_functions,24*3600);
        }
        else {
            $dynamic_functions=array($code[0]=>$rewritten);
            zend_shm_cache_store('wp_dynamic_functions',$dynamic_functions,24*3600);
        }
    }

    return array(create_function($params[0],$rewritten),false);
}
function Aspis_crypt($string,$salt) {
    return array(crypt($string[0],$salt[0]),AspisCollapsedTaintBareCopy($string[1]));
}
function Aspis_current($var){
    $ret=current($var[0]);
    if ($ret===false) $ret=array(false,false);
    else if (isset($ret[1])) $ret[1]=AspisTaintBareCopy($ret[1]);
    else $ret[1]=false;
    return $ret;
}
function Aspis_dechex($i) {
    return array(dechex($i[0]),AspisCollapsedTaintBareCopy($i[1]));
}
function Aspis_decoct($i) {
    return array(decoct($i[0]),AspisCollapsedTaintBareCopy($i[1]));
}
function Aspis_dirname($path) {
    $ret=dirname($path[0]);
    $len=strlen($ret);
    if ($len>0) return array($ret,AspisTaintAt($path[1],0,$len));
    else return array($ret,false);
}
function Aspis_doubleval($i) {
    return array(doubleval($i[0]),AspisCollapsedTaintBareCopy($i[1]));
}
function Aspis_each(&$arr) {
    $ret=each($arr[0]);
    $ret[0]=array($ret[0],$ret[1][2],false);
    $ret["key"]=$ret[0];
    $ret[1][2]=false;
    $ret["key"][2]=false;
    return array($ret,false);
}
function Aspis_end(&$array) {
    //end works fine, so fine that the result does not need the default Aspis
    //attached to all built-in function results. This only avoid this.
    return end($array[0]);
}
function Aspis_ereg_replace ( $pattern , $replacement , $string ) {
    return array(ereg_replace($pattern[0],$replacement[0],$string[0]),AspisCollapsedTaintBareCopy($string[1]));
}
function Aspis_escapeshellarg($i) {
    return array(escapeshellarg($i[0]),AspisCollapsedTaintBareCopy($i[1],2));
}
function Aspis_escapeshellcmd($i) {
    return array(escapeshellcmd($i[0]),AspisCollapsedTaintBareCopy($i[1],2));
}
function Aspis_explode($delimiter , $string , $limit=dummy) {
    $res;
    if ($limit==dummy) $res=explode($delimiter[0],$string[0]);
    else $res=explode($delimiter[0],$string[0],$limit[0]);
    foreach ($res as &$s) $s=array($s,false);
    return array($res,false);
}
function Aspis_floatval($i) {
    return array(floatval($i[0]),AspisCollapsedTaintBareCopy($i[1]));
}
function AspisTainted_get_object_vars($o) {
    if ($o[0] instanceof AspisProxy) {
        $vars=get_object_vars($o[0]->obj);
        foreach ($vars as $k=>&$v) $v=attAspisRCO($v);
        return array($vars,false);
    }
    else  {
        return array(get_object_vars($o[0]),false);
    }
}
function AspisUntainted_get_object_vars($o) {
    if ($o instanceof AspisProxy) {
        $vars=get_object_vars($o->obj);
        foreach ($vars as $k=>&$v) $v=deAspisRCO($v);
        return $vars;
    }
    else  {
        return get_object_vars($o);
    }
}
function Aspis_hexdec($i) {
    return array(hexdec($i[0]),AspisCollapsedTaintBareCopy($i[1]));
}
function Aspis_html_entity_decode ($s ,$qs = dummy, $chs=dummy ) {
    if ($qs===dummy) $ret=html_entity_decode($s[0]);
    else if ($chs===dummy) $ret=html_entity_decode($s[0].$qs[0]);
    else $ret=html_entity_decode($s[0].$qs[0],$chs);
    return array($ret,AspisCollapsedBareTaintCopy($s[1]));
}
function Aspis_htmlspecialchars_decode ($s ,$qs = dummy) {
    if ($qs===dummy) $ret=htmlspecialchars_decode($s[0]);
    else $ret=htmlspecialchars_decode($s[0].$qs[0]);
    return array($ret,AspisCollapsedBareTaintCopy($s[1]));
}
function Aspis_iconv($in,$out,$str) {
    return array(iconv($in[0],$out[0],$str[0]),AspisCollapsedBareTaintCopy($str[1]));
}
function Aspis_implode($glue , $piecies=dummy ) {
    //TODO Taint Tracking
    $res;
    if ($piecies==dummy) $res=implode(deAspisRC($glue));
    else {
        //historical reasons: implode can accept parameters in either order...
        if (is_string($glue[0])) $res=implode($glue[0],deAspisRC($piecies));
        else $res=implode($piecies[0],deAspisRC($glue));
    }
    return array($res,false);
}
function Aspis_intval($var,$base=dummy) {
    if ($base===dummy) $ret=intval($var[0]);
    else $ret=intval($var[0].$base[0]);
    return array($ret,AspisCollapsedTaintBareCopy($var[1]));
}
function Aspis_join($glue, $pieces) {
    //TODO Taint Tracking
    $deref=$pieces[0];
    foreach ($deref as &$value) {
        $value=$value[0];
    }
    return array(join($glue[0],$deref),false);
}
function Aspis_key(&$a) {
    $ret=current($a[0]);
    if ($ret==false) $ret=array(null,false);
    else {
        return array($ret[0],AspisTaintBareCopy($ret[1][2]));
    }
}
function Aspis_krsort(&$a,$flags=dummy) {
    if ($flags===dummy) $ret=krsort($a[0]);
    else $ret=krsort($a[0],deAspisRC($flags));
    return array($ret,false);
}
function Aspis_ksort(&$a,$flags=dummy) {
    if ($flags===dummy) $ret=ksort($a[0]);
    else $ret=ksort($a[0],deAspisRC($flags));
    return array($ret,false);
}
function Aspis_ltrim($str,$chars=dummy) {
    if ($chars===dummy) $ret=ltrim($str[0]);
    else $ret=ltrim($str[0],$chars[0]);
    $before=strlen($str[0]);
    $after=strlen($ret);
    if ($after>0) return array($ret,AspisTaintAt($str[1],$before-$after,$after));
    else return array($ret,false);
}
function Aspis_mb_convert_encoding($str,$to,$from=dummy) {
    if ($from===dummy) $ret=mb_convert_encoding($str[0],$to[0]);
    else mb_convert_encoding($str[0],$to[0],$from[0]);
    return array($ret,AspisCollapsedTaintBareCopy($str[1]));
}
function Aspis_mb_strtolower($str,$from=dummy) {
    if ($from===dummy) $ret=mb_strtolower($str[0]);
    else $ret=mb_strtolower($str[0],$from[0]);
    return array($ret,AspisTaintBareCopy($str[1]));
}
function Aspis_natcasesort(&$a) {
    $a_original=$a;
    $an=deAspisRC($a);
    $res=natcasesort($an);
    foreach ($an as $k=>&$v) {
        if (isset($a_original[0][$k][2])) $v=array($v,$a_original[0][$k][1],$a_original[0][$k][2]);
        else $v=array($v,$a_original[0][$k][1]);
    }
    $a=array($an,false);
    return array($res,false);
}
function Aspis_next(&$var) {
    $ret=next($var[0]);
    if ($ret===false) $ret=array(false,false);
    return $ret;
}
function Aspis_nl2br($str,$on=dummy) {
    if ($on===dummy) $ret=nl2br($str[0]);
    else $ret=nl2br($str[0],$on[0]);
    return array($ret,AspisCollapsedTaintBareCopy($str[0]));
}
function Aspis_parse_url($url,$flag=dummy) {
    if ($flag===dummy)  $res=parse_url($url[0]);
    else $res=parse_url($url[0],$flag[0]);
    if ($res===FALSE) return array(false,false);
    else if (is_array($res)) {
        foreach ($res as &$v) {
            $v=array($v,AspisCollapsedTaintBareCopy($url[1]));
        }
        unset($v);
        return array($res,false);
    }
    else return array($res,AspisCollapsedTaintBareCopy($url[1])); //a string is returned
}
function Aspis_pathinfo($url,$flag=dummy) {
    if ($flag===dummy)  $res=pathinfo($url[0]);
    else $res=pathinfo($url[0],$flag[0]);
    if (!is_string($res)) {
        foreach ($res as &$v) {
            $v=array($v,AspisCollapsedTaintBareCopy($url[1]));
        }
        unset($v);
        return array($ret,false);
    }
    else return array($ret,AspisCollapsedTaintBareCopy($url[1])); 
}
function Aspis_pow($a,$b) {
    return array(pow($a[0],$b[0]),AspisTaintBareCopy($a[1]));
}
//Regular expressions
function Aspis_preg_match ( $pattern , $subject , &$matches=dummy , $flags=dummy , $offset=dummy ) {
    $ret;
    if ($matches===dummy) return array(preg_match($pattern[0],$subject[0]),false);
    else if ($flags===dummy) $ret=array(preg_match($pattern[0],$subject[0],$matches[0]),false);
    else if ($offset===dummy) $ret=array(preg_match($pattern[0],$subject[0],$matches[0],$flags[0]),false);
    else $ret=array(preg_match($pattern[0],$subject[0],$matches[0],$flags[0],$offset[0]),false);
    foreach ($matches[0] as &$str) {
        $str=array($str,AspisCollapsedTaintBareCopy($subject[1]),false);
    }
    unset($str);
    return $ret;
}
function Aspis_preg_match_all ( $pattern , $subject , &$matches=dummy , $flags=dummy , $offset=dummy ) {
    $ret;
    if ($matches===dummy) return array(preg_match_all($pattern[0],$subject[0]),false);
    else if ($flags===dummy) $ret=array(preg_match_all($pattern[0],$subject[0],$matches[0]),false);
    else if ($offset===dummy) $ret=array(preg_match_all($pattern[0],$subject[0],$matches[0],$flags[0]),false);
    else $ret=array(preg_match_all($pattern[0],$subject[0],$matches[0],$flags[0],$offset[0]),false);
    //TODO fix taint tracking
    if ($offset[0]===PREG_OFFSET_CAPTURE) die("Aspis_preg_match_all does not support PREG_OFFSET_CAPTURE");
    foreach ($matches[0] as &$block) {
        foreach ($block as &$str) $str=array($str,AspisCollapsedTaintBareCopy($subject[1]),false);
        $block=array($block,false,false);
    }
    return $ret;
}
function Aspis_preg_replace($pattern ,$replacement ,$subject , $limit = dummy , &$count=dummy) {
    //this should not be needed, dirty way to avoid an irrelevant warning.
    if ($subject===NULL) return array(NULL,false);
    if (is_array($pattern[0])) {
        $pattern[0]=deAspisRC($pattern);
    }
    if (is_array($replacement[0])) {
        $replacement[0]=deAspisRC($replacement);
    }
    if (is_array($subject[0])) {
        $subject[0]=deAspisRC($subject);
    }
    //this is merely collapsing the input taint
    if ($limit==dummy) return array(preg_replace($pattern[0] ,$replacement[0] ,$subject[0]),AspisCollapsedTaintBareCopy($subject[1]));
    else if ($count==dummy) return array(preg_replace($pattern[0] ,$replacement[0] ,$subject[0],$limit[0]),AspisCollapsedTaintBareCopy($subject[1]));
    else return array(preg_replace($pattern[0] ,$replacement[0] ,$subject[0],$limit[0],$count[0]),AspisCollapsedTaintBareCopy($subject[1]));
}
function Aspis_preg_replace_callback($pattern ,$callback ,$subject , $limit = dummy , &$count=dummy) {
    //this must be altered to propagate taint precicely.
    if (is_array($pattern[0])) {
        $pattern[0]=deAspisRC($pattern);
    }
    $callback=AspisInternalCallback($callback);
    if (is_array($subject[0])) {
        $subject[0]=deAspisRC($subject);
    }
    //this is merely collapsing the input taint
    if ($limit==dummy) return array(preg_replace_callback($pattern[0] ,$callback ,$subject[0]),AspisCollapsedTaintBareCopy($subject[1]));
    else if ($count==dummy) return array(preg_replace_callback($pattern[0] ,$callback ,$subject[0],$limit[0]),AspisCollapsedTaintBareCopy($subject[1]));
    else return array(preg_replace_callback($pattern[0] ,$callback ,$subject[0],$limit[0],$count[0]),AspisCollapsedTaintBareCopy($subject[1]));
}
function Aspis_preg_quote($str,$delim=dummy) {
    if ($delim===dummy) $ret=preg_quote($str[0]);
    else $ret=preg_quote($str[0],$delim[0]);
    return array($ret,AspisCollapsedTaintBareCopy($str[1]));
}
function Aspis_preg_split($pat,$sub,$lim=dummy,$flags=dummy) {
    if ($lim===dummy) $ret=preg_split($pat[0],$sub[0]);
    else if ($flags===dummy) $ret=preg_split($pat[0],$sub[0],$lim[0]);
    else $ret=preg_split($pat[0],$sub[0],$lim[0],$flags[0]);
    $len=0;
    $nlen=0;
    foreach ($ret as &$v) {
        $nlen=strlen($v);
        $v=array($v,AspisTaintAt($sub[1],$len,$nlen));
        $len+=$nlen;
    }
    unset($v);
    return array($ret,false);
}
function Aspis_print_r_internal($var,$depth) {
    $ret;
    if (is_array($var[0])) {
        $i=0;
        $tabs="";
        $max=$depth;
        if ($depth!=0) $max++;
        for ($i=0;$i<$max;$i++) $tabs="$tabs    ";
        $ret="Array\n".$tabs."(\n";
        foreach ($var[0] as $key=>$value) {
            $ret=$ret."$tabs    [$key] => ".Aspis_print_r_internal($value,$depth+1)."\n";
        }
        $ret=$ret."$tabs)\n";
    }
    else if (is_object($var[0])) {
        $i=0;
        $tabs="";
        $max=$depth;
        if ($depth!=0) $max++;
        for ($i=0;$i<$max;$i++) $tabs="$tabs    ";
        $class=get_class($var[0]);
        if ($class=="AspisProxy") $class=get_class($var[0]->obj);
        $ret=$class." Object\n".$tabs."(\n";
        foreach ($var[0] as $key=>$value) {
            $ret=$ret."$tabs    [$key] => ".Aspis_print_r_internal($value,$depth+1)."\n";
        }
        $ret=$ret."$tabs)\n";
    }
    else {
        $ret=print_r( AspisCheckPrint($var) ,true);
    }
    return $ret;
}
function Aspis_print_r($var,$return=array(false,false)) {
    $ret=Aspis_print_r_internal($var,0);
    if ($return[0]) return array($ret,false);
    else echo $ret;
}
function Aspis_rawurldecode($str) {
    return array(rawurldecode($str[0]),AspisCollapsedTaintBareCopy($str[1]));
}
function Aspis_rawurlencode($str) {
    return array(rawurlencode($str[0]),AspisCollapsedTaintBareCopy($str[1]));
}
function Aspis_realpath($str) {
    return array(realpath($str[0]),AspisCollapsedTaintBareCopy($str[1]));
}
function Aspis_reset(&$arr) {
    $ret = reset($arr[0]);
    if ($ret===FALSE) return array(false,false);
    if (isset($ret[1])) $ret[1]=AspisTaintBareCopy($ret[1]);
    else $ret[1]=false;
    return $ret;
}
function Aspis_rtrim($str,$chars=dummy) {
    if ($chars===dummy) $ret=rtrim($str[0]);
    else $ret=rtrim($str[0],$chars[0]);
    $len=strlen($ret);
    if ($len>0) return array($ret,AspisTaintAt($str[1],0,$len));
    else return array($ret,false);
}
function Aspis_serialize($v) {
    $v[1]=-123456789; //just to verify that I was the one who serialized it
    return array(serialize($v),false);
}
function Aspis_shuffle(&$ar) {
    $ret=shuffle($ar[1]);
    foreach ($ret as &$v) $v[2]=false; //the key accociacations are random, no taint
    unset($v);
    return array($ret,false);
}
function Aspis_sort(&$a,$flags=dummy) {
    $a_original=$a;
    $an=&deAspisR($a);
    if ($flags===dummy) $res=sort($an);
    else $res=sort($an,$flags[0]);
}
function Aspis_split($pat,$sub,$lim=dummy) {
    if ($lim===dummy) $ret=split($pat[0],$sub[0]);
    else $ret=split($pat[0],$sub[0],$lim[0]);
    $len=0;
    $nlen=0;
    foreach ($ret as &$v) {
        $nlen=strlen($v);
        $v=AspisTaintAt($sub[1],$len,$nlen);
        $len+=$nlen;
    }
    unset($v);
    return array($ret,false);
}
function Aspis_sprintf() {
    //TODO: add taint tracking
    $args=func_get_args();
    foreach ($args as &$arg){
        $arg=deAspisR($arg);
    }
    unset($arg);
    $res=call_user_func_array("sprintf",$args);
    return array($res,false);
}
function Aspis_str_pad($input, $pad_length , $pad_string=dummy , $pad_type=dummy ) {
    if ($pad_string===dummy) {
        $res=str_pad($input[0],$pad_length[0]);
    }
    else if ($pad_type===dummy) {
        $res=str_pad($input[0],$pad_length[0],$pad_string[0]);
    }
    else $res=str_pad($input[0],$pad_length[0],$pad_string[0],$pad_type[0]);
    if ($pad_type===dummy || $pad_type[0]===STR_PAD_RIGHT) {
        if ($pad_string===dummy) $taint=AspisTaintMerge($input,array("",false));
        else $taint=AspisTaintMerge($input,$pad_string);
    }
    else {
        $taint=AspisCollapsedTaintMerge($input[0],$pad_string[0]);
    }
    return array($res,$taint);

}
function Aspis_str_repeat($input, $mult){
    return array(str_repeat($input[0],$mult[0]),AspisCollapsedTaintBareCopy($input[1]));
}
function Aspis_str_replace_single($search, $replace, $subject) {
    $subj=$subject[0];
    $ndl=$search[0];

    $ndl_len=strlen($ndl);
    $indexes=array();
    $offset=0;
    while (strlen($subj)>0 && ($i=strpos($subj,$ndl))!==FALSE) {
        $indexes[]=$i+$offset;
        $subj=substr($subj,$i+$ndl_len);
        $offset += $i + $ndl_len;
    }
    $i=0;
    if (count($indexes)>0) {
        $res=array("",false);
        foreach ($indexes as $j) {
            $res=concat( $res, array(substr($subject[0],$i,$j-$i),AspisTaintAt($subject[1],$i,$j-$i)) );
            if ($replace!=="") $res=concat( $res, $replace);
            $i=$j+$ndl_len;
        }
        $res=concat( $res, array(substr($subject[0],$i),AspisTaintAt($subject[1],$i)) );
    }
    else $res=$subject;
    return $res;
    
}
function Aspis_str_replace($search, $replace, $subject , &$count=dummy) {
    //screw count, it was added in PHP5
    if (is_array($subject[0])) {
        $res=array();
        foreach ($subject[0] as $s) {
            $res[]=Aspis_str_replace($search,$replace,$s);
        }
        $res=array($res,false);
    }
    else {
        if (is_array($search[0])) {
            $res=$subject;
            for ($i=0;$i<count($search[0]);$i++) {
                if (is_array($replace[0]) && isset($replace[0][$i])) {
                    $res=Aspis_str_replace_single($search[0][$i],$replace[0][$i],$res);
                }
                else if ($replace[0]!=="") {
                   $res=Aspis_str_replace_single($search[0][$i],$replace,$res);
                }
                else $res=Aspis_str_replace_single($search[0][$i],"",$res);
            }
        }
        else {
            $res=Aspis_str_replace_single($search,$replace,$subject);
        }
    }
    return $res;
}
function Aspis_str_split($str,$len=dummy) {
    if ($len===dummy) {
        $split_len=1;
        $ret=str_split($str[0]);
    }
    else {
        $split_len=$len[0];
        if ($split_len<1) return array(false,false);
        $ret=str_split($str[0],$split_len);
    }
    $count=0;
    foreach ($ret as &$v) {
        $v=array($v,AspisTaintAt($str[0],$count,$split_len));
        $count+=$split_len;
    }
    unset($v);
    return array($ret,false);
}
function Aspis_strip_tags($str,$allowable=dummy) {
    if ($allowable===dummy) $res=strip_tags($str[0]);
    else $res=strip_tags($str[0],$allowable[0]);
    return array($res,AspisCollapsedTaintBareCopy($str[1],0)); //kills XSS taint
}
function Aspis_stripcslashes($str) {
    return array(stripcslashes($str[0]),AspisCollapsedTaintBareCopy($str[1]));
}
function Aspis_stripslashes($str) {
    return array(stripslashes($str[0]),AspisCollapsedTaintBareCopy($str[1]));
}
function Aspis_stristr($haystack , $needle, $before_neddle=dummy) {
    if ($before_neddle===dummy || $before_neddle[0]==false) {
        $ret=stristr($haystack[0],$needle[0]);
        $leno=strlen($haystack[0]);
        $lenn=strlen($ret);
        return array($ret,AspisTaintAt($haystack[0],$leno-$lenn,$lenn));
    }
    else {
        $ret=stristr($haystack[0],$needle[0],true);
        return array($ret,AspisTaintAt($haystack[0],0,strlen($ret)));
    }
}
function Aspis_strchr($haystack , $needle) {
    $ret=strchr($haystack[0],$needle[0]);
    $leno=strlen($haystack[0]);
    $lenn=strlen($ret);
    return array($ret,AspisTaintAt($haystack[0],$leno-$lenn,$lenn));
}
function Aspis_strrev($str){
    return array(strrev($str[0]),AspisTaintReverse($str));
}
function Aspis_strstr($haystack , $needle, $before_neddle=dummy) {
    if ($before_neddle===dummy || $before_neddle[0]==false) {
        $ret=strstr($haystack[0],$needle[0]);
        $leno=strlen($haystack[0]);
        $lenn=strlen($ret);
        return array($ret,AspisTaintAt($haystack[0],$leno-$lenn,$lenn));
    }
    else {
        $ret=strstr($haystack[0],$needle[0],true);
        return array($ret,AspisTaintAt($haystack[0],0,strlen($ret)));
    }
}
function Aspis_strtolower($str) {
    return array(strtolower($str[0]),AspisTaintBareCopy($str[1]));
}
function Aspis_strtoupper($str) {
    return array(strtoupper($str[0]),AspisTaintBareCopy($str[1]));
}
function Aspis_strtr($str , $replace_pairs ) {
    if (func_num_args()==3) {
        $arg3=func_get_arg(2);
        return array(strtr($str[0],$replace_pairs[0],$arg3[0]),AspisTaintBareCopy($str[1]));
    }
    else {
        $pairs=deAspisRC($replace_pairs);
        return array(strtr($str[0],$pairs),AspisTaintBareCopy($str[1]));
    }
}
function Aspis_strval($val) {
    return array(strval($val[0]),AspisCollapsedTaintBareCopy($val[1]));
}
function Aspis_substr($str,$i,$l=dummy) {
    if ($l===dummy) {
        $ret=substr($str[0],$i[0]);
        return array($ret,AspisTaintAt($str[1],$i[0],strlen($ret)));
    }
    else {
        $a=substr($str[0],$i[0],$l[0]);
        return array(substr($str[0],$i[0],$l[0]),AspisTaintAt($str[1],$i[0],$l[0]));
    }
}
function Aspis_substr_replace($str, $repl, $start ,$len=dummy ) {
    if ($len===dummy) {
        $ret=substr_replace($str[0],$repl[0],$star[0]);
    }
    else $ret=substr_replace($str[0],$repl[0],$star[0],$len[0]);
    return array($ret,AspisCollapsedTaintMerge($str[1],$repl[1]));
}
function Aspis_trim($str,$chars=dummy) {
    $ret=Aspis_rtrim($str,$chars);
    return Aspis_ltrim($ret,$chars);
}
function Aspis_ucwords($str) {
    return array(ucwords($str),AspisTaintBareCopy($str[1]));
}
function Aspis_unserialize($v) {
    $r=unserialize($v[0]);
    if (!is_array($r) || count($r)<2 || $r[1]!=-123456789) $r=attAspisRC($r);
    else $r[1]=false;
    return $r;
}
function AspisUntainted_unserialize($v) {
    $r=unserialize($v);
    if (is_array($r) && count($r)==2 && $r[1]==-123456789) $r=deAspisWarningR($r);
    return $r;
}
function Aspis_urldecode($str) {
    return array(urldecode($str[0]),AspisCollapsedTaintBareCopy($str[1]));
}
function Aspis_urlencode($str) {
    return array(urlencode($str[0]),AspisCollapsedTaintBareCopy($str[1]));
}
function Aspis_usort(&$array, $cmp_function) {
   global $built_in_functions;
   if (empty($built_in_functions)) {
       load_functions();
   }
   $cmp_function=deAspisCallback($cmp_function);
   if (is_string($cmp_function) && isset($built_in_functions[$cmp_function])) {
       $n_cmp_function=function ($op1,$op2) use ($cmp_function) {
           return call_user_func($cmp_function,$op1[0],$op2[0]);
       };
       usort($array[0],$n_cmp_function);
   }
   else {
       $n_cmp_function=function ($op1,$op2) use ($cmp_function) {
           $res=call_user_func($cmp_function,$op1,$op2);
           return $res[0];
       };
       usort($array[0],$n_cmp_function);
   }
}
function AspisTainted_usort(&$array, $cmp_function) {
   global $aspis_taint_details;
   if (empty ($aspis_taint_details)) loadTaintDetails();
   global $built_in_functions;
   if (empty($built_in_functions)) load_functions();
   $cmp_function=deAspisCallback($cmp_function);

   //these cases need dereferencing of the arguments
   if ( is_string($cmp_function) ) {
       if (isset($built_in_functions[$cmp_function]) || !isset($aspis_taint_details[0][$cmp_function])) {
           $n_cmp_function=function ($op1,$op2) use ($cmp_function) {
              return call_user_func($cmp_function,$op1[0],$op2[0]);
           };
           return array(usort($array[0],$n_cmp_function),false);
       }
   }
   else {
       $class=get_class($cmp_function[0]);
       if ($class=="AspisProxy") { //the enclosed obj is untainted
           $f=array($cmp_function[0]->obj,$cmp_function[1]);
           $n_cmp_function=function ($op1,$op2) use ($f) {
              return call_user_func($f,$op1[0],$op2[0]);
           };
           return array(usort($array[0],$n_cmp_function),false);
       }
   }

   //in al other cases, no dereferecning required
   $n_cmp_function=function ($op1,$op2) use ($cmp_function) {
               $res=call_user_func($cmp_function,$op1,$op2);
               return $res[0];
           };
   return array(usort($array[0],$n_cmp_function),false);
}
function AspisUntainted_usort(&$array, $cmp_function) {
   //these cases need attaching aspides to the arguments
   if ( is_string($cmp_function) ) {
       
       global $aspis_taint_details;
       if (empty ($aspis_taint_details)) loadTaintDetails();
       global $built_in_functions;
       if (empty($built_in_functions)) load_functions();

       if (!isset($built_in_functions[$cmp_function]) && isset($aspis_taint_details[0][$cmp_function])) {
           $n_cmp_function=function ($op1,$op2) use ($cmp_function) {
              $ret=call_user_func($cmp_function,attAspisRCO($op1),attAspisRCO($op2));
              return $ret[0];
           };
           return usort($array,$n_cmp_function);
       }
   }
   else {
       $class=get_class($cmp_function[0]);
       if ($class=="AspisProxy") { //the enclosed obj is untainted
           $f=array($cmp_function[0]->obj,$cmp_function[1]);
           $n_cmp_function=function ($op1,$op2) use ($f) {
              $ret=call_user_func($f,attAspisRCO($op1),attAspisRCO($op2));
              return $ret[0];
           };
           return usort($array,$n_cmp_function);
       }
   }

   //in al other cases, the comparison function can be called directly
   $n_cmp_function=function ($op1,$op2) use ($cmp_function) {
               return call_user_func($cmp_function,$op1,$op2);
           };
   return array(usort($array,$n_cmp_function),false);
}
function Aspis_utf8_encode($str) {
    return array(utf8_encode($str[0]),AspisTaintBareCopy($str[1]));
}
function Aspis_var_export($var,$return=dummy) {
    $ret=var_export($var[0],true);
    if ($return==dummy || $return[0]==false) {
        echo AspisCheckPrint(array($ret,AspisCollapsedTaintBareCopy($var[1])));
        return array(NULL,false);
    }
    else {
        return array($ret,AspisCollapsedTaintBareCopy($var[1]));
    }
}
function Aspis_vsprintf($format,$args) {
    //TODO: propagate taint correctly
    if (count($args[0])===0) return $format;
    $args=deAspisR($args);
    $res=vsprintf($format[0],$args);
    return array($res,false);
}
function Aspis_wordwrap($str , $width = dummy , $break = dummy ,$cut = dummy ) {
    if ($width===dummy) $ret=wordwrap($str[0]);
    else if ($break===dummy) $ret=wordwrap($str[0],$width[0]);
    else if ($cut===dummy) $ret=wordwrap($str[0],$width[0],$break[0]);
    else $ret=wordwrap($str[0],$width[0],$break[0],$cut[0]);
    return array($ret,AspisCollapsedTaintBareCopy($str[1]));
}

function Aspis_exec ($command ,  &$output=dummy , &$return_var=dummy  ) {
    if ($output==dummy) {
       return array(exec($command[0]),false);
    }
    else if ($return_var==dummy) {
        $c=count($output);
        $ret=array(exec($command[0],$output[0]),false);
        $i=0;
        foreach ($output[0] as &$value) {
            if ($i++<$c) continue;
            $value=array($value,false);
        }
        return $ret;
    }
    else {
        $c=count($output);
        $ret=array(exec($command[0],$output[0],$return_var[0]),false);
        $i=0;
        foreach ($output[0] as &$value) {
            if ($i++<$c) continue;
            $value=array($value,false);
        }
        return $ret;
    }
}
function Aspis_stat($filename) {
    $res=stat($filename[0]);
    foreach ($res as &$value) $value=array($value,false,false); //for the keys taint
    return array($res,false);
}
function Aspis_in_array( $needle , $haystack , $strict =dummy) {
    $needle=$needle[0];
    deAspisR($haystack);
    if ($strict==dummy) return array(in_array($needle,$haystack),false);
    else return array(in_array($needle,$haystack,$strict[0]),false);

}
function Aspis_file($str,$flags=dummy,$context=dummy) {
    if ($flags==dummy) {
        $ret=file($str[0]);
    }
    else if ($context==dummy) {
        $ret=file($str[0],$flags[0]);
    }
    else $ret=file($str[2],$flags[0],$context[0]);
    
    foreach ($ret as &$value) {
        $value=array($value,false,false);
    }
    return array($ret,false);
}
/*
 * if the passed variable is empty it generates a notice.
 * Both this and issse are used in a special way by the rewritting, and that's why
 * they don't have to return Aspides.
 */
function Aspis_empty($var) {
    return empty($var[0]);
}
function Aspis_isset($var) {
    return isset($var[0]);
}

//XML functions
$Aspis_xml_objects;
function Aspis_xml_set_object($parser, $object) {
    global $Aspis_xml_objects;
    if (!isset ($Aspis_xml_objects)) $Aspis_xml_objects=array();
    $Aspis_xml_objects[]=array($parser[0],$object[0]);
    return array(xml_set_object($parser[0],$object[0]));
}
function Aspis_xml_set_element_handler($parser, $start_handler ,$end_handler) {
    global $Aspis_xml_objects;
    if (!empty ($Aspis_xml_objects) ) {
        $c=count($Aspis_xml_objects);
        for ($i=$c-1;$i>=0;$i--) {
            $e=$Aspis_xml_objects[$i];
            if ($e[0]===$parser[0]) {
                $start_handler[0]=AspisInternalCallback(array(array(array($e[1],false),array($start_handler[0],false)),false));
                $end_handler[0]=AspisInternalCallback(array(array(array($e[1],false),array($end_handler[0],false)),false));
                break;
            }
        }
    }
    return array(xml_set_element_handler($parser[0],$start_handler[0],$end_handler[0]),false);
}
function Aspis_xml_set_character_data_handler($parser, $handler) {
    global $Aspis_xml_objects;
    if (!empty ($Aspis_xml_objects) ) {
        $c=count($Aspis_xml_objects);
        for ($i=$c-1;$i>=0;$i--) {
            $e=$Aspis_xml_objects[$i];
            if ($e[0]===$parser[0]) {
                $handler[0]=AspisInternalCallback(array(array(array($e[1],false),array($handler[0],false)),false));
                break;
            }
        }
    }
    return array(xml_set_character_data_handler($parser[0],$handler[0]),false);
}
function Aspis_xml_set_default_handler($parser, $handler) {
    global $Aspis_xml_objects;
    if (!empty ($Aspis_xml_objects) ) {
        $c=count($Aspis_xml_objects);
        for ($i=$c-1;$i>=0;$i--) {
            $e=$Aspis_xml_objects[$i];
            if ($e[0]===$parser[0]) {
                $handler[0]=AspisInternalCallback(array(array(array($e[1],false),array($handler[0],false)),false));
                break;
            }
        }
    }
    return array(xml_set_default_handler($parser[0],$handler[0]),false);
}
function Aspis_xml_set_end_namespace_decl_handler($parser, $handler) {
    global $Aspis_xml_objects;
    if (!empty ($Aspis_xml_objects) ) {
        $c=count($Aspis_xml_objects);
        for ($i=$c-1;$i>=0;$i--) {
            $e=$Aspis_xml_objects[$i];
            if ($e[0]===$parser[0]) {
                $handler[0]=AspisInternalCallback(array(array(array($e[1],false),array($handler[0],false)),false));
                break;
            }
        }
    }
    return array(xml_set_end_namespace_decl_handler($parser[0],$handler[0]),false);
}
function Aspis_xml_set_external_entity_ref_handler($parser, $handler) {
    global $Aspis_xml_objects;
    if (!empty ($Aspis_xml_objects) ) {
        $c=count($Aspis_xml_objects);
        for ($i=$c-1;$i>=0;$i--) {
            $e=$Aspis_xml_objects[$i];
            if ($e[0]===$parser[0]) {
                $handler[0]=AspisInternalCallback(array(array(array($e[1],false),array($handler[0],false)),false));
                break;
            }
        }
    }
    return array(xml_set_external_entity_ref_handler($parser[0],$handler[0]),false);
}
function Aspis_xml_set_notation_decl_handler($parser, $handler) {
    global $Aspis_xml_objects;
    if (!empty ($Aspis_xml_objects) ) {
        $c=count($Aspis_xml_objects);
        for ($i=$c-1;$i>=0;$i--) {
            $e=$Aspis_xml_objects[$i];
            if ($e[0]===$parser[0]) {
                $handler[0]=AspisInternalCallback(array(array(array($e[1],false),array($handler[0],false)),false));
                break;
            }
        }
    }
    return array(xml_set_notation_decl_handler($parser[0],$handler[0]),false);
}
function Aspis_xml_set_processing_instruction_handler($parser, $handler) {
    global $Aspis_xml_objects;
    if (!empty ($Aspis_xml_objects) ) {
        $c=count($Aspis_xml_objects);
        for ($i=$c-1;$i>=0;$i--) {
            $e=$Aspis_xml_objects[$i];
            if ($e[0]===$parser[0]) {
                $handler[0]=AspisInternalCallback(array(array(array($e[1],false),array($handler[0],false)),false));
                break;
            }
        }
    }
    return array(xml_set_processing_instruction_handler($parser[0],$handler[0]),false);
}
function Aspis_xml_set_start_namespace_decl_handler($parser, $handler) {
    global $Aspis_xml_objects;
    if (!empty ($Aspis_xml_objects) ) {
        $c=count($Aspis_xml_objects);
        for ($i=$c-1;$i>=0;$i--) {
            $e=$Aspis_xml_objects[$i];
            if ($e[0]===$parser[0]) {
                $handler[0]=AspisInternalCallback(array(array(array($e[1],false),array($handler[0],false)),false));
                break;
            }
        }
    }
    return array(xml_set_start_namespace_decl_handler($parser[0],$handler[0]),false);
}
function Aspis_xml_set_unparsed_entity_decl_handler($parser, $handler) {
    global $Aspis_xml_objects;
    if (!empty ($Aspis_xml_objects) ) {
        $c=count($Aspis_xml_objects);
        for ($i=$c-1;$i>=0;$i--) {
            $e=$Aspis_xml_objects[$i];
            if ($e[0]===$parser[0]) {
                $handler[0]=AspisInternalCallback(array(array(array($e[1],false),array($handler[0],false)),false));
                break;
            }
        }
    }
    return array(xml_set_unparsed_entity_decl_handler($parser[0],$handler[0]),false);
}

//taint altering functions
function Aspis_htmlentities ( $string , $flags = dummy , $charset =dummy, $double_encode =dummy ) {
    if ($flags===dummy) $s=htmlentities($string[0]);
    else if ($charset===dummy) $s=htmlentities($string[0],$flags[0]);
    else if ($double_encode===dummy) $s=htmlentities($string[0],$flags[0],$charset[0]);
    else $s=htmlentities($string[0],$flags[0],$charset[0],$double_encode[0]);
    $ret=array ($s);
    if ($string[1]===false) $ret[1]=false;
    else {
        $ret[1]=array();
        $c=0;
        foreach ($string[1] as $taint) {
            $ret[1][$c] = $taint;
            if ($c==0) AspisLibClearTaint($ret[1][$c]);
            else AspisLibCollapseTaint($ret[1][$c]);
            $c++;
        }
    }
    return $ret;
}
function Aspis_htmlspecialchars( $string , $flags = dummy , $charset =dummy, $double_encode =dummy ) {
    if ($flags===dummy) $s=htmlspecialchars($string[0]);
    else if ($charset===dummy) $s=htmlspecialchars($string[0],$flags[0]);
    else if ($double_encode===dummy) $s=htmlspecialchars($string[0],$flags[0],$charset[0]);
    else $s=htmlspecialchars($string[0],$flags[0],$charset[0],$double_encode[0]);
    return array ($s,AspisCollapsedTaintBareCopy($string[1],0));
}
function Aspis_mysql_real_escape_string ( $unescaped_string , $link_identifier=dummy) {
    $ret=array();
    if ($link_identifier==dummy) {
        $ret[0]=mysql_real_escape_string($unescaped_string[0]);
    }
    else $ret[0]=mysql_real_escape_string($unescaped_string[0],$link_identifier[0]);
    if ($unescaped_string[1]===false) $ret[1]=false;
    else {
        $ret[1]=array();
        $c=0;
        foreach ($unescaped_string[1] as $taint) {
            $ret[1][$c] = $taint;
            if ($c==1) AspisLibClearTaint($ret[1][$c]);
            else AspisLibCollapseTaint($ret[1][$c]);
            $c++;
        }
    }
    return $ret;
}
function Aspis_addslashes($str) {
   $str[0]=addslashes($str[0]);
   //return AspisCollapsedTaintCopy($str,1);
   return $str;
}
function Aspis_exit($str=dummy) {
    if ($str!==dummy) {
        echo AspisCheckPrint($str);
    }
    exit();
}

//taint checking functions
function Aspis_mysql_query ($query , $link_identifier =dummy) {
    $q;
    if ($query[1]===false) $q=$query[0];
    else {
        $q=AspisLibMakeUseSQLI($query[1][1],$query[0]);
    }
    if ($link_identifier==dummy) {
        return array(mysql_query($q),false);
    }
    else {
        return array(mysql_query($q,$link_identifier[0]),false);
    }

}
?>