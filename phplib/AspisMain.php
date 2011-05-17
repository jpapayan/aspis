<?php
//benchmarking code
$Aspismtime = microtime();
$Aspismtime = explode(" ",$Aspismtime);
$Aspismtime = $Aspismtime[1] + $Aspismtime[0];
$Aspisstarttime = $Aspismtime;

//real code starts here
if(isset($ASPIS_DEF_MAIN)) return;
$ASPIS_DEF_MAIN = 0;
require_once 'AspisLibrary.php';
require_once 'AspisObject.php';
require_once 'AspisTaints.php';
$ASPIS_INFO_COLLECT=false;
$ASPIS_INFO_OUTPUT=array();
$ASPIS_INFO_FILENAME="/data/Dropbox/php/svn_local/php/PhpParserC/taint_propagation/current";
if ($ASPIS_INFO_COLLECT) {
    $ASPIS_INFO_FD = fopen($ASPIS_INFO_FILENAME, 'w') or die("Cannot write to file $ASPIS_INFO_FILENAME\n");
    fclose($ASPIS_INFO_FD);
}
function AspisIsTaintedR($obj) {
    if (isset ($obj[1]) && $obj[1]!=false && is_array($obj[1])) {
        foreach ($obj[1] as $t) {
            if (AspisLibIsTainted($t)) return true;
        }
    }
    $arr=array();
    if (is_object($obj[0])) {
        $class=get_class($obj[0]);
        if ($class=="AspisProxy") return false;
        global $aspis_taint_details;
        if (empty ($aspis_taint_details)) loadTaintDetails();
        if (!isset($aspis_taint_details[1][$class])) return false;
        $arr=get_object_vars($obj[0]);
    }
    else if (is_array($obj[0])) {
        $arr=$obj[0];
    }
    foreach ($arr as $v) {
        $ret=AspisIsTaintedR($v);
        if ($ret) return true;
    }
    return false;
}
function AspisGetTrace() {
    $r=debug_backtrace();
    foreach ($r as &$e) {
        unset($e["object"]);
        unset($e["type"]);
        unset($e["args"]);
    }
    unset($e);
    return $r;
}
function AspisLogExamine($obj) {
    global $ASPIS_INFO_FILENAME;
    if (isset ($obj[1]) && $obj[1]!=false && is_array($obj[1])) {
        foreach ($obj[1] as $v) {
            if (AspisLibIsTainted($v)) {
                $ASPIS_INFO_FD = fopen($ASPIS_INFO_FILENAME, 'a') or die("Cannot write to file $ASPIS_INFO_FILENAME\n");
                fwrite($ASPIS_INFO_FD,"examine\t".serialize(AspisGetTrace())."\n");
                fclose($ASPIS_INFO_FD);
            }
        }
    }
}
function AspisLogEdit($obj) {
    global $ASPIS_INFO_FILENAME;
    if (isset ($obj[1]) && $obj[1]!=false && is_array($obj[1])) {
        foreach ($obj[1] as $v) {
            if (AspisLibIsTainted($v)) {
                $ASPIS_INFO_FD = fopen($ASPIS_INFO_FILENAME, 'a') or die("Cannot write to file $ASPIS_INFO_FILENAME\n");
                fwrite($ASPIS_INFO_FD,"edit\t".serialize(AspisGetTrace())."\n");
                fclose($ASPIS_INFO_FD);
            }
        }
    }
}
function AspisLogIntroduce() {
    global $ASPIS_INFO_FILENAME;
    $ASPIS_INFO_FD = fopen($ASPIS_INFO_FILENAME, 'a') or die("Cannot write to file $ASPIS_INFO_FILENAME\n");
    fwrite($ASPIS_INFO_FD,"introduce\t".serialize(AspisGetTrace())."\n");
    fclose($ASPIS_INFO_FD);
}
function AspisLogParameter($obj) {
    global $ASPIS_INFO_FILENAME;
    if (AspisIsTaintedR($obj)) {
        $ASPIS_INFO_FD = fopen($ASPIS_INFO_FILENAME, 'a') or die("Cannot write to file $ASPIS_INFO_FILENAME\n");
        fwrite($ASPIS_INFO_FD,"parameter\t".serialize(AspisGetTrace())."\n");
        fclose($ASPIS_INFO_FD);
    }
}
function AspisLogGlobals() {
    global $ASPIS_INFO_FILENAME;
    foreach (func_get_args() as $obj) {
        if (AspisIsTaintedR($obj)) {
            $ASPIS_INFO_FD = fopen($ASPIS_INFO_FILENAME, 'a') or die("Cannot write to file $ASPIS_INFO_FILENAME\n");
            fwrite($ASPIS_INFO_FD,"global\t".serialize(AspisGetTrace())."\n");
            fclose($ASPIS_INFO_FD);
        }
    }
}

function concat($obj1, $obj2) {
    if ($obj1===NULL) {
        if ($obj2===NULL) return array(NULL,false);
        else return array($obj2[0],AspisTaintBareCopy($obj2[1]));
    }
    else if ($obj2===NULL) {
       return array($obj1[0],AspisTaintBareCopy($obj1[1]));
    }
    if (is_string($obj1)) $obj1=array($obj1,false); //ugly hack, this should never happen
    if (is_string($obj2)) $obj2=array($obj2,false); //but array accesses on objects are not protected
    $ret=array();
    if ($obj1[1]===false && $obj2[1]===false) {
        //if all objects are untainted, do not create any taints
        $ret[1]=false;
    }
    else if (is_array($obj1[1])) {
        //the first object is tainted (maybe the second is too, should be handled by merge())
        $ret[1]=array ();
        $c=count($obj1[1]);
        $isArray=is_array($obj2[1]);
        if ($isArray) {
            for ($i=0; $i<$c; $i++) {
                 $ret[1][]=AspisLibMerge($obj1[0], $obj1[1][$i],$obj2[1][$i]);
            }
        }
        else {
            for ($i=0; $i<$c; $i++) {
                $ret[1][]=AspisLibMerge($obj1[0], $obj1[1][$i] ,false);
            }
        }
    }
    else if (is_array($obj2[1])) {
        //Only the right object is tainted
        //I have to create (empty) taint placeholders for the left object
        $ret[1]=array();
        $newTaints=AspisEmptyTaints(false);
        $c=count($newTaints);
        for ($i=0; $i<$c; $i++) {
            $ret[1][]=AspisLibMerge($obj1[0], $newTaints[$i], $obj2[1][$i]);
        }
    }

    //the actual concat
    $ret[0]=$obj1[0];
    $ret[0].=$obj2[0];

//    echo "taint (concat) is:";
//    var_dump($ret);

    return $ret;
}
function concat12($str1, $str2) {
    return array($str1.$str2,false);
}
function concat1($str1, $obj2) {
    if ($obj2===NULL || !is_array($obj2)) {
        return array($str1,false);
    }
    if (is_string($obj2)) $obj2=array($obj2,false); //ugly hack, this should never happen
    $ret=array();
    if ($obj2[1]===false) {
        //if all objects are untainted, do not create any taints
        $ret[1]=false;

    }
    else if (is_array($obj2[1])) {
        //Only the right object is tainted
        //I have to create (empty) taint placeholders for the left object
        $ret[1]=array();
        $newTaints=AspisEmptyTaints(false);
        $c=count($newTaints);
        for ($i=0; $i<$c; $i++) {
            $ret[1][]=AspisLibMerge($str1, $newTaints[$i], $obj2[1][$i]);
        }
    }

    //the actual concat
    $ret[0]=$str1.$obj2[0];

    return $ret;

}
function concat2($obj1, $str2) {
    if ($obj1===NULL || !is_array($obj1)) return array($str2,false);
    $ret=array();
    if (is_string($obj1)) $obj1=array($obj1,false); //ugly hack, this should never happen
    if ($obj1[1]===false) {
        //if all objects are untainted, do not create any taints
        $ret[1]=false;
    }
    else if (is_array($obj1[1])) {
        //the first object is tainted (maybe the second is too, should be handled by merge())
        $ret[1]=array ();
        $c=count($obj1[1]);
        for ($i=0; $i<$c; $i++) {
            $ret[1][]=AspisLibMerge($obj1[0],$obj1[1][$i],false);
        }
    }

    $ret[0]=$obj1[0].$str2;

    return $ret;
}
function deconcat($obj1, $obj2) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogExamine($obj1);
        AspisLogExamine($obj2);
    }
    if (is_string($obj1)) $obj1=array($obj1,false); //ugly hack, this should never happen
    if (is_string($obj2)) $obj2=array($obj2,false); //but array accesses on objects are not protected
    
    if ($obj1===NULL) {
        if ($obj2===NULL) return NULL;
        else  return $obj2[0];
    }
    else if ($obj2===NULL) {
        if ($obj1===NULL) return NULL;
        else return $obj1[0];
    }
    else return $obj1[0].$obj2[0];
}
function deconcat12($str1, $str2) {
    return $str1.$str2;
}
function deconcat1($str1, $obj2) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogExamine($obj2);
    }
    if (is_string($obj2)) $obj2=array($obj2,false); //but array accesses on objects are not protected
    if ($obj2===NULL) return $str1;
    else return $str1.$obj2[0];
}
function deconcat2($obj1, $str2) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogExamine($obj1);
    }
    if (is_string($obj1)) $obj1=array($obj1,false); //ugly hack, this should never happen
    if ($obj1===NULL) return $str2;
    return $obj1[0].$str2;
}

function &preincr(&$obj) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogEdit($obj);
    }
    ++$obj[0];
    return $obj;
}
function &predecr(&$obj) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogEdit($obj);
    }
    --$obj[0];
    return $obj;
}
function &postincr(&$obj) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogEdit($obj);
    }
    $clone=array($obj[0],$obj[1]);
    $obj[0]++;
    return $clone;
}
function &postdecr(&$obj) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogEdit($obj);
    }
    $clone=array($obj[0],$obj[1]);
    $obj[0]--;
    return $clone;
}
function negate($obj) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogEdit($obj);
    }
    return array(-$obj[0],AspisTaintBareCopy($obj[1]));
}
function not_boolean($obj) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogEdit($obj);
    }
    return array(!$obj[0],AspisTaintBareCopy($obj[1]));
}
function denot_boolean($obj) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogExamine($obj);
    }
    return !$obj[0];
}
function not_bitwise($obj) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogEdit($obj);
    }
    return array(~$obj[0],AspisTaintBareCopy($obj[1]));
}
function e($obj) {return $obj;}
function string_cast($obj) {
    //TODO: fix taints
    return array((string)($obj[0]),AspisTaintBareCopy($obj[1]));
}
function int_cast($obj) {
    //TODO: fix taints
    if ($obj===NULL) return array(0,false);
    else return array((int)$obj[0],$obj[1]);
}
function bool_cast($obj) {
    //TODO: fix taints
    return array((bool)$obj[0],AspisTaintBareCopy($obj[1]));
}
function float_cast($obj) {
    //TODO: fix taints
    return array((float)$obj[0],AspisTaintBareCopy($obj[1]));
}
function array_cast($obj) {
    //TODO: fix taints ? Maybe they are ok (see arrays manual entry on "converting to an array"
    //print_r($obj);
    if (is_scalar($obj[0])) {
        return array(array($obj),AspisTaintBareCopy($obj[1]));
    }
    else if (is_object($obj[0])) {
        return array((array)$obj[0],AspisTaintBareCopy($obj[1]));
    }
    else if (is_array($obj[0])) {
        return $obj;
    }
    else if (is_null($obj[0])) {
        return array(array(),false);
    }
}
function unset_cast($obj) {
    //TODO: fix taints
    //return new PHPAspisObject((unset)$this->object,$this->taint);
}
function object_cast($obj) {
    //TODO: fix taints
    return array((object)$obj[0],false);
}
function unwrapException($e) {
    if (is_array($e)) {
        //TODO: Normally, this should ALWAYS be the case, but new is not rewritten yet
       $GLOBALS["PHPAspisException"]=$e;
       return $e[0];
    }
    else return $e;
}
/*
 * If the excecption was thrown by the program, we have to reattach
 * the taint. If it was an internal one, it is not tainted.
 */
function wrapException($e) {
    if (isset ($GLOBALS["PHPAspisException"])) {
        $aspis=$GLOBALS["PHPAspisException"];
        unset($GLOBALS["PHPAspisException"]);
        return $aspis;
    }
    else return array($e,false);
}
/*
 * This is called in array definitions, to attach to the $value
 * the taint of the $key. Stored temporarily there
 */
function addTaint($obj) {
    global $registered_taint;
    $obj[2]=$registered_taint;
    return $obj;
}
function &addTaintR(&$obj) {
    global $registered_taint;
    $obj[2]=$registered_taint;
    return $obj;
}
function registerTaint($obj) {
    global $registered_taint;
    $registered_taint=$obj[1];
    return $obj;
}
function deregisterTaint($obj) {
    global $registered_taint;
    $registered_taint=$obj[1];
    return $obj[0];
}
/*
 * Called after foreach(x as key=>value) to make key an Aspis again. Taint should
 * be found in the third element of $taint
 */
function restoreTaint(&$obj,&$taint) {
    $ret=array($obj);
    if (isset ($taint[2])) {
        $ret[1]=$taint[2];
    }
    else $ret[1]=false;
    $obj=$ret;
}

//These functions read lists of functions, useful in dynamic function calls
$built_in_functions;
function load_functions() {
    global $built_in_functions;
    if (!isset($_SERVER[0]['HTTP_USER_AGENT'])) {
        $built_in_functions=file("php_functions.txt",FILE_USE_INCLUDE_PATH | FILE_IGNORE_NEW_LINES);
        $ar=array();
        foreach ($built_in_functions as $f) $ar[$f]=1;
        $built_in_functions=$ar;
        return;
    }
    else {
        $built_in_functions=zend_shm_cache_fetch('php_functions');
        if ($built_in_functions===false) {
            echo "Cache was empty<br>";
            $built_in_functions=file("php_functions.txt",FILE_USE_INCLUDE_PATH | FILE_IGNORE_NEW_LINES);
            $ar=array();
            foreach ($built_in_functions as $f) $ar[$f]=1;
            $built_in_functions=$ar;
            zend_shm_cache_store('php_functions',$built_in_functions,24*3600);
        }
        else echo "Cache was here!<br>";
    }

}
$taint_categories=array();
function load_taint_categories() {
    global $taint_categories;
    $read_file=true;
    if (isset($_SERVER[0]['HTTP_USER_AGENT'])) {
        $taint_categories = zend_shm_cache_fetch('taint_categories');
        if ($taint_categories !== false) {
            $read_file=false;
        }
    }
    if ($read_file) {
        global $ASPIS_CATEGORIES_FILE;
        $file=file($ASPIS_CATEGORIES_FILE,FILE_USE_INCLUDE_PATH | FILE_IGNORE_NEW_LINES);
        for ($i=0 ; $i< count($file); $i++ ) {
            $line=$file[$i];
            if ($line=="begin") {
                $tc=array(array(),array());
                $reading_sanitisation=0;
                $reading_sinks=0;
                $reading_sources=0;
                while (1) {
                    $line=$file[++$i];
                    if ($line=="end") break;
                    else if ($line == ">sanitisation") {
                        $reading_sanitisation=1;
                        continue;
                    } else if ($line == ">sinks") {
                        $reading_sanitisation=0;
                        $reading_sinks=1;
                        continue;
                    } else if ($line == ">sources") {
                        $reading_sanitisation=0;
                        $reading_sinks=0;
                        $reading_sources=1;
                        continue;
                    }
                    if ($reading_sanitisation) {
                        $tc[0][$line]=1;
                    } else if ($reading_sinks || $reading_sources) {
                        $tok1=strtok($line, "->");
                        $tok2=strtok("->");
                        if ($tok1 != "" && $tok2 != "") {
                            if ($reading_sinks) $tc[1][$tok1]=$tok2;
                            else if ($reading_sources) $tc[2][$tok1]=$tok2;
                        }
                        else
                            die("Invalid guard in the category file");
                    }
                }
                $taint_categories[]=$tc;
            }
        }
        if (isset($_SERVER[0]['HTTP_USER_AGENT'])) {
            zend_shm_cache_store('taint_categories', $taint_categories, 24 * 3600);
        }
    }
}
function AspisIsSanitiser($function) {
    global $taint_categories;
    if (empty($taint_categories)) {
        load_taint_categories();
    }
    
    if (is_array($function)) $function=$function[1]; //ignore the class
    for ($i = 0; $i < count($taint_categories); $i++) {
        if (isset($taint_categories[$i][0][$function])) return $i;
    }
    return -1;
}
function AspisFindGuard($function,$category_index=1) {
    global $taint_categories;
    if (empty($taint_categories)) {
        load_taint_categories();
    }
    
    if (is_array($function)) $function=$function[1]; //ignore the class
    for ($i=0; $i<count($taint_categories); $i++) {
        if (isset($taint_categories[$i][$category_index][$function])) {
            return $taint_categories[$i][$category_index][$function];
        }
    }
    return "";
}
function AspisFindSinkGuard($function) {
   return AspisFindGuard($function,1);
}
function AspisFindSourceGuard($function) {
   return AspisFindGuard($function,2);
}

/*
 * All calls of type $var($param...) will be translated to AspisDynamicCall($var,$param)
 * This will lookup $var in the list of built in functions and decide how to call it.
 * This will also look for a potential sanitisation/sink call and act accordingly.
 */
function AspisDynamicCall() {
   global $built_in_functions;
   if (empty($built_in_functions)) {
       load_functions();
   }
   $f_params=func_get_args();
   $f_name=array_shift($f_params);
   $f_name=deAspisCallback($f_name);
   
   if (is_string($f_name) && isset($built_in_functions[$f_name])) {
       //TODO: this doesn't work with ref parameters. If so, I need to replicate
       //what I do statically (pushRefParameters and call AspisInternalFunctionCall)
       foreach ($f_params as &$value) {
           $value=deAspisRC($value);
       }
       return attAspisRC(call_user_func_array($f_name,$f_params));
   }
   else {
        $guard = AspisFindSinkGuard($f_name);
//        echo "Guard: $guard\n";
        if ($guard != "") {
            if (isset($f_params[0])) {
                $f_params[0]=$guard($f_params[0]);
            }
            return call_user_func_array($f_name, $f_params);
        } else {
            $ret = call_user_func_array($f_name, $f_params);
            $i = AspisIsSanitiser($f_name);
//            echo "IsSanitiser: $i\n";
            if ($i != -1) {
                $ret = AspisKillTaint($ret, $i);
            }
            return $ret;
        }
    }
}
function AspisTaintedDynamicCall() {
   $f_params=func_get_args();
   $f_name=array_shift($f_params);
   $f_name=deAspisCallback($f_name);
   
    //the caller is tainted
   global $built_in_functions;
   if (empty($built_in_functions)) load_functions();
   global $aspis_taint_details;
   if (empty ($aspis_taint_details)) loadTaintDetails();

   $is_function=is_string($f_name);
   if ($is_function && isset($built_in_functions[$f_name])) {
       //TODO: this doesn't and rather can't work with ref parameters.
       //That's because no matter what, I cannot get my hands in refs of the incoming params 
       foreach ($f_params as &$value) {
           $value=deAspisRC($value);
       }
       return attAspisRC(call_user_func_array($f_name,$f_params));
   }
   else if ($is_function && !isset($aspis_taint_details[0][$f_name])) {
       foreach ($f_params as &$value) {
           $value=deAspisRCO($value);
       }
       return attAspisRCO(call_user_func_array($f_name,$f_params));
   }
   else {
        $guard = AspisFindSinkGuard($f_name);
        if ($guard != "") {
            if (isset($f_params[0])) {
                $f_params[0]=$guard($f_params[0]);
            }
            return call_user_func_array($f_name, $f_params);
        } else {
            $ret = call_user_func_array($f_name, $f_params);
            $i = AspisIsSanitiser($f_name);
            if ($i != -1) {
                $ret = AspisKillTaint($ret, $i);
            }
            return $ret;
        }
    }
}
function AspisUntaintedDynamicCall() {
   $f_params=func_get_args();
   $f_name=array_shift($f_params);

    //the caller is tainted
   global $built_in_functions;
   if (empty($built_in_functions)) load_functions();
   global $aspis_taint_details;
   if (empty ($aspis_taint_details)) loadTaintDetails();

   $is_function=is_string($f_name);
   if ($is_function && isset($built_in_functions[$f_name])) {
       //TODO: this doesn't and rather can't work with ref parameters.
       //That's because no matter what, I cannot get my hands in refs of the incoming params
       return call_user_func_array($f_name,$f_params);
   }
   else if ($is_function && isset($aspis_taint_details[0][$f_name])) {
       foreach ($f_params as &$value) {
           $value=attAspisRCO($value);
       }
       $ret=call_user_func_array($f_name,$f_params);
       $guard=AspisFindSourceGuard($f_name);
       if ($guard!="") $ret=$guard($ret);
       return deAspisRCO($ret);
   }
   $ret=call_user_func_array($f_name,$f_params);
   $guard=AspisFindSourceGuard($f_name);
   if ($guard!="") $ret=$guard($ret);
   return $ret;
}

//these are needed to store REFERENCES to the function's ref parameters
$aspisInternalFunctionParams=array();
function AspisPushRefParam(&$param){
    global $aspisInternalFunctionParams;
    $aspisInternalFunctionParams[]=&$param;
    return $param;
}
function AspisInternalFunctionCall() {
    global $aspisInternalFunctionParams;
    $params=func_get_args();
    $name=array_shift($params);
    $references=array_pop($params);
    $i=0;
    foreach ($references as $ref) {
        $params[$ref]=&deAspisR($aspisInternalFunctionParams[$i++]);
    }
    $aspisInternalFunctionParams=array();
    $ret=&call_user_func_array($name,$params);
    $ret=attAspisRC($ret,$name);
    foreach ($references as $ref) {
        $params[$ref]=&attAspisR($params[$ref],$name);
    }
    return $ret;
}
function &AspisUntaintedFunctionCall() {
    /*
     * This is used in tainted context when calling an untainted context
     */
    global $aspisInternalFunctionParams;
    $params=func_get_args();
    $name=array_shift($params);
    $references=array_pop($params);
    $i=0;
    //this keeps a redundant reference for the by_ref param. For some weird reson
    //a ref param with no other refs pointing to it must be automatically transformed to a regular param
    $dumm=array();
    foreach ($references as $ref) {
        $dumm[$i]=& deAspisWarningR($aspisInternalFunctionParams[$i++]);
        $params[$ref] =& $dumm[$i];
    }
    $aspisInternalFunctionParams=array();
    $ret=&call_user_func_array($name,$params);
    foreach ($references as $ref) {
        $params[$ref]=&attAspisRO($params[$ref]);
    }
    $ret=attAspisRCO($ret);
    return $ret;
}
function &AspisTaintedFunctionCall() {
    /*
     * This is used in untainted context when calling a tainted context
     */
    global $aspisInternalFunctionParams;
    $params=func_get_args();
    $name=array_shift($params);
    $references=array_pop($params);
    $i=0;
    $dumm=array();
    foreach ($references as $ref) {
        $dumm[$i]=&attAspisRO($aspisInternalFunctionParams[$i++]);
        $params[$ref] =& $dumm[$i];
    }
    $ret=&call_user_func_array($name,$params);
    foreach ($references as $ref) {
        $params[$ref]=&deAspisWarningR($params[$ref]);
    }
    $aspisInternalFunctionParams=array();
    $ret=deAspisWarningRC($ret);
    return $ret;
}
function AspisReferenceMethodCall($object,$fname,$params,$references) {
    global $aspisInternalFunctionParams;
    $class=get_class($object);
    if ($class!="AspisProxy") {
        $handle=array($object,$fname);
        //this means I can directly call the method on the object: same tainted params
        $i=0;
        foreach ($references as $ref) {
            $params[$ref]=&$aspisInternalFunctionParams[$i++];
        }
        $aspisInternalFunctionParams=array();
        $ret=&call_user_func_array($handle,$params);
        return $ret;
    }
    $handle=array($object->obj,$fname);
    $addsTaint=$object->addsTaint();
    $i=0;
    $i_internal=0;
    reset($references);
    $r=current($references);
    $dumm=array();
    foreach ($params as $param) {
        if ($r===$i) {
            if ($addsTaint) {
                $dumm[$i_internal]=&attAspisRO($aspisInternalFunctionParams[$i_internal++]);
                $params[$i]=&$dumm[$i_internal];
            }
            else {
                $dumm[$i_internal]=&deAspisRO($aspisInternalFunctionParams[$i_internal++]);
                $params[$i]=&$dumm[$i_internal];
            }
            $r=next($references);
        }
        else {
            if ($addsTaint) $params[$i]=attAspisRCO($param);
            else $params[$i]=deAspisRCO($param);
        }
        $i++;
    }
    unset($param);
    $aspisInternalFunctionParams=array();
    $ret=&call_user_func_array($handle,$params);

    if ($addsTaint) $ret=deAspisRCO($ret); //for methods that return by value
    else $ret=attAspisRCO($ret); //for methods that return by value
    foreach ($references as $ref) {
        if ($addsTaint) $params[$ref]=deAspisRO($params[$ref]);
        else $params[$ref]=attAspisRO($params[$ref]);
    }
    
    return $ret;
}
function AspisInternalCallback($name) {
   global $built_in_functions;
   if (empty($built_in_functions)) {
       load_functions();
   }
   if (is_string($name[0]) && isset($built_in_functions[$name[0]])) {
       return $name[0];
   }
   $name=deAspisRC($name);
   $nfunction=function () use ($name) {
               $args=func_get_args();
               foreach ($args as &$arg) { //only on params! If the function uses
                   $arg=attAspisR($arg);  //global vars, they they should be protected! :-)
               }
               $ret = call_user_func_array($name,$args);
               $ret=deAspisRC($ret);
               return $ret;
           };
   return $nfunction;
}

function &attachAspis(&$array,$index) {
    if (is_array($array[0])) {
        return $array[0][$index];
    }
    else {
        if ($array[1]===false) $var=array($array[0][$index],false);
        else {
            $var=array($array[0][$index],array());
            $allFalse=true;
            foreach ($array[1] as $taint) {
                $t=AspisLibGetTaintOf($taint, $index);
                $var[1][]=$t;
                $allFalse &=($t===false);
            }
            if ($allFalse) $var[1]=false;
        }
        return $var;
    }
}
function arrayAssign(&$array,&$index,&$value) {
    if (is_string($array) && !is_string($index) ) {
        //here it's an assignment to a char of the string-TODO taint tracking
        return $array[$index]=$value[0];
    }
    else {
        return $array[$index]=$value;
    }
}
function arrayAssignAdd(&$array,&$value) {
    //the [] operator is not supported for strings: can't do $str[]="world";
    /*if (is_string($array)) {
        //here it's an assignment to a char of the string-TODO taint tracking
        return $array=$value[0];
    }
    else*/ return $array=$value;
}
function deAspis($array) {
    //use by reference, to avoid a warning when called with non existing variable.
    if (is_string($array)) {
        echo "deAspis was called on a string ($array), error!<br>";
        var_dump(debug_backtrace());
    }
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogExamine($array);
    }
    return $array[0];
}
/*
 * This version also attaches proxies to objects. Used for partial taint tracking
 */
function deAspisRCO($var) {
    //fromTained is false when the caller is an untainted function
    $ret=$var[0];
    //no object handling, see the R version
    if (is_array($ret)) {
        $retn=array();
        foreach ($ret as $key=>$value) {
            $retn[$key]=deAspisRCO($value);
        }
        return $retn;
    }
    else if (is_object($ret)) {
        $class=get_class($ret);
        if ($class=="AspisProxy") return $ret->obj;
        else return new AspisProxy($ret,false);
    }
    else return $ret;
}
function &deAspisRO(&$haystack) {
    if ( is_array($haystack[0])) {
        $haystack=$haystack[0];
        $currentkey=key($haystack);
        foreach ($haystack as $key=>&$value) {
            $haystack[$key]=&deAspisRO($value);
        }
        unset($value);
        if ($currentkey!==NULL) {
            reset($haystack);
            while (key($haystack)!==$currentkey) next($haystack);
        }
        $currentkey=key($haystack);
        return $haystack;
    }
    else if (is_object($haystack[0])) {
        //DO NOT CHANGE THE OBJECT IN PLACE
        //that is because when the object is passed using a ref, the original ref will also change
        //and unfortunately, in PHP4 code (WP) all objects are passed using direct references.
        //Note this is different from pass by ref of objects in PHP5: there the object is the same
        //but the "pointers" to the object can change independetely.
        $o=$haystack[0];
        $class=get_class($o);
        if ($class=="AspisProxy") $no=$o->obj;
        else {
            //if ($class==="stdClass" && isset($o->ID) && isset($o->ID[0]) && $o->ID[0]=3) trigger_error("ITS HERE");
            $no=new AspisProxy($o,false);
        }
        return $no;
    }
    else {
        $haystack=$haystack[0];
        return $haystack;
    }
}
function &deAspisWarningR(&$haystack) {
//    if (AspisIsTaintedR($haystack)) {
//        die("Tainted function calls untainted with (partially) tainted data:\n<br>".debug_backtrace());
//    }
    return deAspisRO($haystack);
}
function deAspisWarningRC($var) {
//    if (AspisIsTaintedR($var)) {
//        die("Tainted function calls untainted with (partially) tainted data:\n<br>".debug_backtrace());
//    }
    return deAspisRCO($var);
}
function &deAspisR(&$haystack) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogExamine($haystack);
    }
    $haystack=$haystack[0];
    /*
     * Input objects are used only in get_object_vars(). There, just remove the global aspis
     */
    if ( is_array($haystack) /*|| is_object($haystack) */) {
        $currentkey=key($haystack);
        foreach ($haystack as &$value) {
            deAspisR($value);
        }
        unset($value);
        if ($currentkey!==NULL) {
            reset($haystack);
            while (key($haystack)!==$currentkey) next($haystack);
        }
        $currentkey=key($haystack);
    }
    return $haystack;
}
function deAspisRC($var) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogExamine($var);
    }
    $ret=$var[0];
    //no object handling, see the R version
    if (is_array($ret)/* || is_object($ret)*/) {
        $retn=array();
        foreach ($ret as $key=>$value) {
            $retn[$key]=deAspisRC($value);
        }
        return $retn;
    }
    else return $ret;
}
function deAspisList($var,$hints) {
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogExamine($var);
    }
    $var=$var[0];
    foreach ($hints as $key=>$value) {
        $var[$key]=deAspisList($var[$key],$value);
    }
    return $var;
    
}
function deAspisCallback($var) {
    /*
     * used by the Library to remove the aspis from a callback. I.e.
     * if an object is referenced, I must not removes all Aspides recursively
     */
    global $ASPIS_INFO_COLLECT;
    if ($ASPIS_INFO_COLLECT) {
        AspisLogExamine($var);
    }
    $res=$var[0];
    if (is_array($res)) {
        //if the callback is on a method on $this, $this would not be protected
        if (is_array($res[0])) $res[0]=$res[0][0];
        $res[1]=$res[1][0];
    }
    return $res;
}
function attAspis($ret) {
    $result=array($ret,false);
    return $result;
}
function &attAspisR(&$ret,$function=NULL) {
    if (is_array($ret)) {
        $currentkey=key($ret);
        foreach ($ret as $key=>&$value) {
            $value=attAspisR($value,$function);
            $value[]=false; //the key's taint
        }
        unset($value);
        if ($currentkey!==NULL) {
            reset($ret);
            while (key($ret)!==$currentkey) next($ret);
        }
    }
    else if (is_object($ret) && ($function==="mysql_fetch_field" || $function==="mysql_fetch_object")) {
        $currentkey=key($ret);
        foreach ($ret as $key=>&$value) {
            if (is_object($value)) continue;;
            $value=attAspisR($value,$function);
            $value[]=false; //the key's taint
        }
        unset($value);
        if ($currentkey!==NULL) {
            reset($ret);
            while (key($ret)!==$currentkey) next($ret);
        }
//        $ret=new AspisProxy($ret,true);
    }
    $ret=array($ret,false);
    return $ret;
}
function &attAspisRO(&$ret) {
    if (is_array($ret)) {
        $currentkey=key($ret);
        foreach ($ret as $key=>&$value) {
            $ret[$key]=&attAspisRO($value);
            //$ret[$key]=false; //the key's taint
        }
        if ($currentkey!==NULL) {
            reset($ret);
            while (key($ret)!==$currentkey) next($ret);
        }
        $ret=array($ret,false);
        return $ret;
    }
    else if (is_object($ret)) {
        //DOES NOT CHANGE $RET, see deAspisRO for the reason why
        $class=get_class($ret);
        if ($class=="AspisProxy") $no=$ret->obj;
        else $no=new AspisProxy($ret,true);
        $no=array($no,false);
        return $no;
    }
    else {
        $ret=array($ret,false);
        return $ret;
    }
}
function attAspisRC(&$ret,$function=NULL) {
    if (is_array($ret) /*|| is_object($ret)*/) {
        foreach ($ret as $key=>&$value) {
            $value=attAspisRC($value,$function);
            $value[]=false; //the key's taint
        }
        unset($value);
    }
    else if (is_object($ret) && ($function==="mysql_fetch_field" || $function==="mysql_fetch_object")) {
        foreach ($ret as $key=>&$value) {
            if (is_object($value)) continue;
            $value=attAspisRC($value,$function);
            $value[]=false; //the key's taint
        }
        unset($value);
//        $ret=new AspisProxy($ret,true);
    }
    return array($ret,false);
}
function attAspisRCO($ret) {
    $res;
    if (is_array($ret)) {
        $res=array();
        foreach ($ret as $key=>$value) {
            $res[$key]=attAspisRCO($value);
            $res[$key][]=false; //the key's taint
        }
    }
    else if (is_object($ret)) {
        $class=get_class($ret);
        if ($class=="AspisProxy") {
            $res=$ret->obj;
        }
        else $res=new AspisProxy($ret,true);
    }
    else $res=$ret;
    return array($res,false);
}

//these functions are used when the global context is TAINTED
function &AspisCleanTaintedGlobal(&$var,$var_name,&$actions) {
    global $AspisGlobalsUntainted;
    if (isset($AspisGlobalsUntainted[$var_name])) return $dummy; //I can use it as it is
    $AspisGlobalsUntainted[$var_name]=1; //$var_name global variable is now untainted
    if (!is_array($actions)) $actions=array(); //and I was the one to untaint it
    $actions[$var_name]=true;
    $var=deAspisWarningR($var);
    return $var;
}
function AspisRestoreTaintedGlobal(&$var,$var_name,&$actions) {
    if (isset($actions[$var_name]) && $actions[$var_name]==true) { //I was the one to untaint it
        global $AspisGlobalsUntainted;
        unset($AspisGlobalsUntainted[$var_name]);
        $var=attAspisRO($var);
    }
}
function &AspisTaintUntaintedGlobal(&$var,$var_name,&$actions) {
    global $AspisGlobalsUntainted;
    if (!isset($AspisGlobalsUntainted[$var_name])) return $dummy; //I can use it as it is
    unset($AspisGlobalsUntainted[$var_name]); //$var_name global variable is now tainted
    if (!is_array($actions)) $actions=array(); //and I was the one to untaint it
    $actions[$var_name]=true;
    $var=attAspisRO($var);
    return $var;
}
function AspisRestoreUntaintedGlobal(&$var,$var_name,&$actions) {
    if (isset($actions[$var_name])) { //I was the one to untaint it
        global $AspisGlobalsUntainted;
        $AspisGlobalsUntainted[$var_name]=1;
        $var=deAspisWarningR($var);
    }
}
//these functions are used when the global context is UNTAINTED
function &AspisCleanTaintedGlobalUntainted(&$var,$var_name,&$actions) {
    //echo "cleaning:$var_name<br>";
    global $AspisGlobalsTainted;
    if (!isset($AspisGlobalsTainted[$var_name])) return $dummy; //I can use it as it is
    unset($AspisGlobalsTainted[$var_name]);    //$var_name global variable is now untainted
    if (!is_array($actions)) $actions=array($var_name=>true); //and I was the one to untaint it
    else $actions[$var_name]=true;
    $var=deAspisWarningR($var);
    return $var;
}
function AspisRestoreTaintedGlobalUntainted(&$var,$var_name,&$actions) {
    if (isset($actions[$var_name])) { //I was the one to untaint it
        global $AspisGlobalsTainted;
        $AspisGlobalsTainted[$var_name]=1;
        $var=attAspisRO($var);
    }
}
function &AspisTaintUntaintedGlobalUntainted(&$var,$var_name,&$actions) {
    global $AspisGlobalsTainted;
    if (isset($AspisGlobalsTainted[$var_name])) return $dummy; //I can use it as it is
    $AspisGlobalsTainted[$var_name]=1; //$var_name global variable is now tainted
    if (!is_array($actions)) $actions=array($var_name=>true); //and I was the one to untaint it
    else $actions[$var_name]=true;
    $var=attAspisRO($var);
    return $var;
}
function AspisRestoreUntaintedGlobalUntainted(&$var,$var_name,&$actions) {
    if (isset($actions[$var_name])) { //I was the one to untaint it
        global $AspisGlobalsTainted;
        unset($AspisGlobalsTainted[$var_name]);
        $var=deAspisWarningR($var);
    }
}

function AspisReflect($i,$d1=null,$d2=null,$d3=null,$d4=null,$d5=null,$d6=null,$d7=null
        ,$d8=null,$d9=null,$d10=null,$d11=null,$d12=null,$d13=null,$d14=null,$d15=null) {
    return ${"d$i"};
}
$aspis_taint_details;
function loadTaintDetails() {
    global $aspis_taint_details;
    global $aspis_taint_details_path;
    $file=file($aspis_taint_details_path,FILE_USE_INCLUDE_PATH | FILE_IGNORE_NEW_LINES);
    $arf=array();
    $arc=array();
    $inFunctions=true;
    foreach ($file as $f) {
        if ($f===">functions") $inFunctions=true;
        else if ($f===">classes") $inFunctions=false;
        else {
            if ($inFunctions) $arf[$f]=1;
            else $arc[$f]=1;
        }
    }
    $aspis_taint_details=array($arf,$arc);
    return;
}
function AspisNewUnknownProxy($classname,$params,$isTaintedContext=true) {
    //the taint of the created object was unknown statically
    $class = new ReflectionClass($classname);
    global $aspis_taint_details;
    if (empty ($aspis_taint_details)) loadTaintDetails();
    //attach a proxy object only when the object is created in an environment of different taint
    //attach an aspis to the resuly only when called from a taintex context
    if (isset($aspis_taint_details[1][$classname])) {
        if (!$isTaintedContext) {
            if (!empty($params)) {
                foreach ($params as &$v) $v=attAspisRCO($v);
                $obj = $class->newInstanceArgs($params);
            }
            else $obj = $class->newInstance();
            return new AspisProxy($obj,false);
        }
    }
    else if ($isTaintedContext) {
        if (!empty($params)) {
                foreach ($params as &$v) $v=deAspisWarningRC($v);
                $obj = $class->newInstanceArgs($params);
            }
        else $obj = $class->newInstance();
        return array(new AspisProxy($obj,true),false);
    }
    if (!empty($params))  {
        $obj = $class->newInstanceArgs($params);
    }
    else $obj = $class->newInstance();
    if ($isTaintedContext) return array($obj,false);
    else return $obj;
}
function AspisNewKnownProxy($obj,$taintedToUntainted) {
    //the taint of the created ibject was unknown statically
    return new AspisProxy($obj,$taintedToUntainted);
}
function AspisEmptyTaints($isTainted) {
    global $ASPIS_CATEGORIES_TOTAL;
    $res=array();
    if ($isTainted==="" || $isTainted===false) {
        for ($i=0;$i<$ASPIS_CATEGORIES_TOTAL;$i++) $res[]=false; 
    }
    else {
        for ($i=0;$i<$ASPIS_CATEGORIES_TOTAL;$i++) $res[]=array(true); 
    }
    return $res;
}

/*
 * Make all supeglobals behave like Aspis Arrays.
 * Note that "behind the back" changes by PHP to them will only affect the enclosed
 * arrays, ie the 'real' $GLOBALS for PHP is still the enclosed one.
 */
function initialize_superglobal_values() {
    //This is not needed as GLOBALS containts all the other superglobals.
//    var_dump($GLOBALS);
//    foreach ($GLOBALS as &$value) {
//        $value=array($value,false);
//    }
    if (isset($GLOBALS['argv'])) {
        foreach ($GLOBALS['argv'] as &$value) {
            $value=array($value,AspisEmptyTaints(true));
        }
        $GLOBALS["argv"]=array($GLOBALS["argv"],AspisEmptyTaints(true));
        $GLOBALS["argc"]=array($GLOBALS["argc"],AspisEmptyTaints(true));
        foreach ($_SERVER['argv'] as &$value) {
            $value=array($value,AspisEmptyTaints(true));
        }
    }

    foreach ($_SERVER as $k=>&$value) {
        $value=array($value,AspisEmptyTaints(true));
    }
    foreach ($_GET as &$value) {
        $value=array($value,AspisEmptyTaints(true));
    }
    foreach ($_POST as &$value) {
        $value=array($value,AspisEmptyTaints(true));
    }
    foreach ($_FILES as &$value) {
        $value=array($value,AspisEmptyTaints(true));
    }
    if (isset ($_REQUEST)) foreach ($_REQUEST as &$value) {
        $value=array($value,AspisEmptyTaints(true));
    }
    //turn this on in a web server
    if (isset ($_SESSION)) foreach ($_SESSION as &$value) {
        $value=array($value,AspisEmptyTaints(true));
    }
    if (isset ($_ENV)) foreach ($_ENV as &$value) {
        $value=array($value,AspisEmptyTaints(true));
    }
    foreach ($_COOKIE as &$value) {
        $value=array($value,AspisEmptyTaints(true));
    }
}
initialize_superglobal_values();
$registered_taint=false; //this will unfortunately appear in $GLOBALS
$GLOBALS=array(0=>$GLOBALS,false);
$_SERVER=array(0=>$_SERVER,false);
$_GET=array(0=>$_GET,false);
$_POST=array(0=>$_POST,false);
$_FILES=array(0=>$_FILES,false);
if (isset ($_REQUEST)) $_REQUEST=array(0=>$_REQUEST,false);
if (isset ($_ENV)) $_ENV=array(0=>$_ENV,false);
$_COOKIE=array(0=>$_COOKIE,false);
$AspisGlobalsUntainted=array();
$AspisGlobalsTainted=array();
