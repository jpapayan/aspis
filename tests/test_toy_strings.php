<?php

$x1='abc';
$x2=$x1;
$x3="(Repeat {$x1} and $x2) "; //strtoupper($x2);
$x4=<<<DEMO
$x1 _Hello from a {$x2} Heredoc_ $x3
DEMO;
$x5="CDE".<<<DEMO2
Hello!
DEMO2;
$res="Start ".$x1.$x2.$x3.$x4.$x5."hello "."again!".(string)12;
echo "res=$res\n","\ndone!\n";

$post_type="papajohn";
echo "hello {$post_type}_status {$post_type}\n";
echo "{$post_type}_status {$post_type}\n";

$tag="TAG";
define("SIMPLEPIE_PCRE_HTML_ATTRIBUTE","CONSTANT");
$str="/<($tag)" . SIMPLEPIE_PCRE_HTML_ATTRIBUTE . "(>(.*)<\/$tag" . SIMPLEPIE_PCRE_HTML_ATTRIBUTE . '>|(\/)?>)/siU';
echo $str."\n";
?>