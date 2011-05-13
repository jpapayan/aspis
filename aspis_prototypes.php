#!/usr/bin/php
<?php 
if (!isset($argv[1]) || !file_exists($argv[1])) die("Please supply an IN file\n");
if (!isset($argv[2])) die("Please supply an OUT file\n");
$file=file($argv[1]);
$couples=array();
$couples_methods=array();
$i=0;
$header="";
foreach ($file as $line) {
   if ($i++%2==1) {
       if (strpos($header,"method ")!==0) $couples[$header]=trim($line);
       else $couples_methods[$header]=trim($line);
   }
   else {
       $header=trim($line);
   }
}

//sorted output
ksort($couples);
ksort($couples_methods);
//$out = fopen('current_sorted.prototypes', 'w');
//foreach ($couples as $key=>$value) {
////    echo $key."\n";
//    fwrite($out,$key);
//    fwrite($out,$value."\n");
//}
//fclose($out);

function print_array($header,$out,$couples) {
    fwrite($out,$header);
    foreach ($couples as $key=>$value) {
//    echo $key;
        $i=strpos($key,' ');
        if (substr($key,0,$i)=="method") { //ingore any "method" prefix
            $key=substr($key,$i+1);
            $i=strpos($key,' ');
        }
        $name=substr($key,0,$i);
        $key=substr($key,$i+1);
        $params=array();
        $param="";
        $ignore=false;
        $i=strpos($key,' ');
        $key=substr($key,$i+1);
        $try=0;
        $mod=2;
        $kind="";
        $pcount=0;
        while (strlen($key)>0) {
            $i=strpos($key,' ');
            if ($i>0) {
                if (strpos(substr($key,0,$i),"[")>-1) {
                    $try=0;
                    $kind="p";
                    $pcount++;
                    $key=substr($key,$i+1);
                    continue;
                }
                if ($try%$mod==0) {
                    $s=substr($key,0,$i);
                    if (strpos($s,"...")>-1) {
                        $kind="r".$kind;
                        $s=substr($s,strpos($s,"..."));
                    }
                    if ($s!=")" && $s!="]") {
                        if ($kind=="") $params[]=$s;
                        else {
                            $params[]="$kind $s";
                        }
                    }
                    else if ($s=="]") {
                        if (--$pcount==0) $kind="";
                    }
                }
                else if ($try%$mod==1) {
                    if ($key[0]=='&') {
                        $params[count($params)-1]=$params[count($params)-1]." &";
                    }
                    $s=substr($key,0,$i);
                    if (strpos($s,"...")>-1) {
                        $params[count($params)-1]="r".$params[count($params)-1];
                    } else if ($s=="]") {
                        if (--$pcount==0) $kind="";
                    }
                }
                $try++;
                $key=substr($key,$i+1);
            }
            else break;
        }

        $returns="";
        $reversed=trim(strrev($value));
        $reversed = preg_split('//', $reversed, -1, PREG_SPLIT_NO_EMPTY);
        foreach($reversed as $c) {
            if ($c==')') continue;
            else if ($c=='(') break;
            else $returns=$c.$returns;
        }
//    echo $returns."\n";

        //write to file
        fwrite($out,$name."\n");
//    echo "$name\n";
        foreach ($params as $p) {
            fwrite($out,"\t".$p."\n");
        }
//    echo "\n";
        fwrite($out,"\t\t".$returns."\n");

    }
}

//processed output
$out = fopen($argv[2], 'w');
print_array(">functions\n",$out,$couples);
print_array(">methods\n",$out,$couples_methods);
fclose($out);
?> 
