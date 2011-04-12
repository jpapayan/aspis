<?php
//TODO:
//1.Rewrite define to store internally the full AspisObject
//of the provided parameter.
//2.Rewrite accesses to constants and enclose them to a function that
//returns the full AspsisObject

$a="hello";
define("CONSTANT_NAME", "value $a");
define("STATE", "Ohio");
//const STATE="Ohio"; //TODO: Modern consts are not supported
echo STATE;
echo CONSTANT_NAME;
$STATE=12;
echo STATE;
echo $STATE;

#is there a way to automagically make this constant an object?
#How can u invoke that this is the first use, thus it is a string
#(note that proper constants with define() are always Objects.)
#actually see "Why is $foo[bar] wrong?" on the manual.
#this should not happen
$c=yiannis;
echo "constant:$c\n";
$a=array("yiannis"=>"papagiannis",matteo=>"migliavacca");
print $a[yiannis];
print $a["yiannis"];
print $a['yiannis'];
print "\n";
foreach ($a as $name) print "$name\n";

$output="test";
if ( $output == OBJECT ) {
    echo $output." failed\n";
} elseif ( $output == ARRAY_A ) {
    echo $output." failed again\n";
}
else echo $output." succeded!\n";

/* TODO: does not work
class ClassX {
    const CONST_VALUE = 'A constant value';
}
$classname = 'ClassX';
echo $classname::CONST_VALUE; // As of PHP 5.3.0
echo ClassX::CONST_VALUE;
*/

?>