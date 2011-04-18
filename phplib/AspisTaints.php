<?php
$ACTIVATE_GUARDS=false;
if( isset( $ASPIS_DEF_TAINTS ) ) return;
$ASPIS_DEF_TAINTS = 1;

//New style taint-as arrays
function AspisKillTaint( $string, $i ) {
    $ret=$string;
    if (is_array($string[1])) {
        $c=0;
        foreach ($string[1] as $taint) {
            if ($c==$i) AspisLibClearTaint($ret[1][$c]);
            $c++;
        }
    }
    return $ret;
    
}
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
    global $ACTIVATE_GUARDS;
    $res="";
    if ($taint===false) $res=$data;
    else if ($taint===true) {
        if ($ACTIVATE_GUARDS) $res=htmlentities($data);
        else $res=($data);
    }
    else {
        $temp_taint=false;
        $temp_str="";
        $temp_index=0;
        foreach ($taint as $i=>$t) {
            if ($i>0) {
                $temp_str=substr($data,$temp_index,$i-$temp_index);
                if ($temp_taint) {
                    if ($ACTIVATE_GUARDS) $res.=htmlentities($temp_str);
                    else $res.=($temp_str);
                }
                else $res.=$temp_str;
            }
            $temp_taint=$t;
            $temp_index=$i;
        }
        $temp_str=substr($data,$temp_index); //the last element
        if ($temp_taint) {
            if ($ACTIVATE_GUARDS) $res.=htmlentities($temp_str);
            else $res.=($temp_str);
        }
        else $res.=$temp_str;
    }
    return $res;
}
function AspisLibMakeUseSQLI($taint,$data) {
    global $ACTIVATE_GUARDS;
    //calls mysql_real_escape_string() in all tainted substrings
    $res;
    if ($taint===false) $res=$data;
    else if ($taint===true) {
        if ($ACTIVATE_GUARDS) $res=mysql_real_escape_string($data);
        else $res=($data);
    }
    else {
        $temp_taint=false;
        $temp_str="";
        $temp_index=0;
        foreach ($taint as $i=>$t) {
            if ($i>0) {
                $temp_str=substr($data,$temp_index,$i-$temp_index);
                if ($temp_taint) {
                    if ($ACTIVATE_GUARDS) $res.=mysql_real_escape_string($temp_str);
                    else $res.=($temp_str);
                }
                else $res.=$temp_str;
            }
            $temp_taint=$t;
            $temp_index=$i;
        }
        $temp_str=substr($data,$temp_index); //the last element
        if ($temp_taint) {
            if ($ACTIVATE_GUARDS) $res.=mysql_real_escape_string($temp_str);
            else $res.=($temp_str);
        }
        else $res.=$temp_str;
    }
    return $res;
}


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
            AspisLibCollapseTaint($ret[1][$c]);
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
            AspisLibCollapseTaint($ret[$c]);
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


?>