<?php
define("EXAMINE","examine");
define("EDIT","edit");
define("INTRODUCE","introduce");
define("PARAMETER","parameter");
define("GLOBALV","global");

function load_functions() {
    $overriden_functions=file("../phplib/php_functions_overriden.txt",FILE_USE_INCLUDE_PATH | FILE_IGNORE_NEW_LINES) or die ("Failed to locate overriden functions file.");
    echo "read in total ".count($overriden_functions)." lines\n";
    $ar=array();
    foreach ($overriden_functions as $f) $ar[$f]=1;
    return $ar;
}
function isAspisFunction($f) {
    return (strpos($f,"Aspis")!==FALSE || strpos($f,"aspis")!==FALSE);
}
function isRequireFunction($f) {
    return $f==="require" || $f==="require_once" || $f==="include" || $f==="include_once";
}

function compareFunctions($arg1,$arg2) {
    return strcmp(getStringRepresentation($arg1),getStringRepresentation($arg2));
}

function getStringRepresentation($f) {
    return $f[0]."/".$f[1];
}

function arrayUnique($array, $preserveKeys = false)
{
    // Unique Array for return
    $arrayRewrite = array();
    // Array with the md5 hashes
    $arrayHashes = array();
    foreach($array as $key => $item) {
        // Serialize the current element and create a md5 hash
        $hash = md5(serialize($item));
        // If the md5 didn't come up yet, add the element to
        // to arrayRewrite, otherwise drop it
        if (!isset($arrayHashes[$hash])) {
            // Save the current element hash
            $arrayHashes[$hash] = $hash;
            // Add element to the unique Array
            if ($preserveKeys) {
                $arrayRewrite[$key] = $item;
            } else {
                $arrayRewrite[] = $item;
            }
        }
    }
    return $arrayRewrite;
} 

function storeTrace($function,$trace) {
    //the key is fname/classname
    global $traces_functions;
    if (!isset($traces_functions[$function[0]."/".$function[1]])) $traces_functions[$function[0]."/".$function[1]]=array();
    $traces_functions[$function[0]."/".$function[1]][]=$trace;
}
function containsCall($trace,$f) {
    foreach($trace as $e) { //up->down the stack trace, most recent calls first.
        if (strpos($f,".php")!==false) {
            if ($e["file"]===$f) return true;
        }
        else if ($e["function"]===$f) return true;
    }
    return false;
}

function filter($ar,$folder) {
    global $overriden_functions;
    $len=strlen($folder);
    $c=0;
    $todel=array();
    foreach ($ar as &$e) {
        if (!isset($ar[$c+1]["function"]) || !isRequireFunction($ar[$c+1]["function"])) {
            if (isAspisFunction($e["function"])) {
                $todel[]=$c;
            }
            else if (isset($overriden_functions[$e["function"]])) {
                $todel[]=$c;
            }
        }
        if (isset ($e["file"]) && strpos($e["file"],$folder)===0) $e["file"]=substr($e["file"],$len);
        $c++;
    }
    unset($e);
    $c=count($ar);
    $j=0;
    foreach ($todel as $i) {
        if (++$j!=$c) unset($ar[$i]); //dont erase the last
    }
    return $ar;
}
function logTrace($trace) {
   global $source_functions;
   global $sink_functions;
   global $parameter_functions;
   global $global_functions;
   $functions;
   switch ($trace[0]) {
       case EXAMINE:
       case EDIT:
           $functions=&$sink_functions;
           break;
       case INTRODUCE:
           $functions=&$source_functions;
           break;
       case PARAMETER:
           $functions=&$parameter_functions;
           break;
       case GLOBALV:
           $functions=&$global_functions;
           break;
   }
   $first=true;
   foreach ($trace[1] as $t) {
       if (count($trace[1])==1) {
          if (isset($t["function"])) {
               if (isAspisFunction($t["function"])) {
                   $fun=array($t["file"],NULL);
               }
               else {
                   $fun=array($t["function"],isset($t["class"])?$t["class"]:NULL);
               }
           }
           else $fun=array($t["file"],NULL);
           storeTrace($fun,$trace);
           $functions[]=$fun;
           if ($fun[0]=="" || isRequireFunction($fun[0]) || isAspisFunction($fun[0])) {
               echo "This made me die (1): \n";
               print_r($t);
               print_r($trace);
               die();
           }
           break;
       }

       if ($first) {
           if (isset ($t["file"])) {
               $filename=array($t["file"],NULL);
           }
           else $filename=array("unknown",NULL);
           if (isset ($t["function"])) {
               $function=array($t["function"],isset($t["class"])?$t["class"]:NULL);
           }
           else $function=array("unknown",NULL);
           $first=false;
           continue;
       }
       $fun=array($t["function"],isset($t["class"])?$t["class"]:NULL);
       if (!isRequireFunction($fun[0]) || ($function[0]!=="unknown") && !isAspisFunction($function[0]) ) {
           storeTrace($function,$trace); //the previous one
           $functions[]=$function;
           if ($function[0]=="" || isRequireFunction($function[0]) || isAspisFunction($function[0])) {
               echo "This made me die (2): \n";
               print_r($t);
               print_r($trace);
               die();
           }
       }
       else {
           storeTrace($filename,$trace);
           $functions[]=$filename;
           if ($filename[0]=="" || isRequireFunction($filename[0]) || isAspisFunction($filename[0])) {
               echo "This made me die (3): \n";
               print_r($filename[0]);
               echo  "1->".($filename[0]=="");
               echo "/2->".(isRequireFunction($filename[0]));
               echo "/3->".(isAspisFunction($filename[0])). "\n";
               print_r($t);
               print_r($trace);
               die();
           }
       }
       break;
   }
}

echo "============================\n";
if ($argc!=3) {
    die("Usage: php calc_taint_graph.php trace_filename www_folder_root\n");
}
echo "Using file: {$argv[$argc-2]}\n";
$folder=$argv[$argc-1];
$overriden_functions=load_functions();
//**************************
$file=file($argv[$argc-2],FILE_IGNORE_NEW_LINES) or die("Failed to open file, exiting...\n");
$traces=array();
$c=0;
$traces=array();
foreach ($file as $t) {
    $parts=explode("\t",$t);
    $parts[1]=filter(unserialize($parts[1]),$folder);
    $traces[]=$parts;
}

//Now, let's do the actual logging of what treats tainted data.
$source_functions=array(); //these 4 keep just the name of the functions
$sink_functions=array();
$global_functions=array();
$parameter_functions=array();
$traces_functions=array(); //this one stores arrays of traces, indexed per function name

foreach ($traces as $trace) {
//    print_r($trace);
    logTrace($trace);
}

$source_functions=arrayUnique($source_functions);
$sink_functions=arrayUnique($sink_functions);
$global_functions=arrayUnique($global_functions);
$parameter_functions=arrayUnique($parameter_functions);

echo "\n=================\n";
echo "Sources of taint:\n";
usort($source_functions,"compareFunctions");
foreach ($source_functions as $f) printf("%s\n",$f[0]."/".$f[1]) ;
echo "\n===============\n";
echo "Sinks of taint:\n";
usort($sink_functions,"compareFunctions");
foreach ($sink_functions as $f) printf("%s\n",$f[0]."/".$f[1]);
echo "\n===============\n";
echo "Received tainted params:\n";
usort($parameter_functions,"compareFunctions");
foreach ($parameter_functions as $f) printf("%s\n",$f[0]."/".$f[1]);
echo "\n===============\n";
echo "Accessed tainted globals:\n";
usort($global_functions,"compareFunctions");
foreach ($global_functions as $f) printf("%s\n",$f[0]."/".$f[1]);

//now calculate the set of functions where I must enable taint tracking
$tainted_functions=arrayUnique(array_merge($sink_functions,$source_functions,$global_functions));
foreach ($sink_functions as $f) {
    if (!in_array($f,$parameter_functions)) continue; //the function is not receiving tainted params
    $ftraces=arrayUnique($traces_functions[getStringRepresentation($f)]);
    foreach ($ftraces as $t) {
        $first=true;
        foreach ($t[1] as $e) {
            if ($first && strpos($f[0],".php")!==FALSE) {
                $first=false;
                continue;
            }
            if (isset($e["function"])) {
                $fc=array($e["function"],isset($e["class"])?$e["class"]:NULL);
                if ($fc==$f) continue;
                if (!in_array($fc,$tainted_functions)) {
                    echo "Recursively added [".getStringRepresentation($fc)."]\n";
                    $tainted_functions[]=$fc;
                }
                if (!in_array($fc,$parameter_functions)) break;
            }
            else {
                print_r($e);
            }
        }
    }
}

echo "\n===============\n";
echo "Enable Taint Tracking:\n";
usort($tainted_functions,"compareFunctions");
$fout = $argv[$argc-2].".tainted";
$fh = fopen($fout, 'w') or die("can't open output file\n");
printf(">functions\n");
fprintf($fh,">functions\n");
$classes=array();
foreach ($tainted_functions as $f) {
    if ($f[1]!=NULL) {
        $classes[]=$f[1];
        continue; //skip methods
    }
    printf("%s\n",$f[0]);
    fprintf($fh,"%s\n",$f[0]);
}
$classes=array_unique($classes);
sort($classes);
printf(">classes\n");
fprintf($fh,">classes\n");
foreach ($classes as $c) {
    printf("%s\n",$c);
    fprintf($fh,"%s\n",$c);
}

fclose($fh);

?>