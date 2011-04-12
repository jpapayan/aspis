<?php

$key="hello";
$a=array();
$a=array("hello"=>2,4,"hi"=>"mom");
//echo $a["hello"];
foreach ($a as $value) echo $value;
foreach ($a as $key=>$value) echo $key.$value;

$a=array("world"=>"Super Mario World");
$b=array("hello"=>"world");
echo "\n".$a[$b["hello"]]."\n";
$b=array("hello"=>$a);
//echo $b["hello"][world]."\n";

$a=array(1,2,3,4,5);
foreach ($a as $value) echo $value++;
echo "\n";
foreach ($a as &$value) echo $value++;
echo "\n";
foreach ($a as &$value) echo $value;
echo "\n";
$var="hi";
$var2="yo";
$a=array("hello"=>"john","bye"=>"nick");
$a["hey"]="mark";
$a[$var]="joe";
$a[$var]=array($var2);
$a[$var][$var2]=array("third stage");

echo $a[$var][$var2][0]."\n";
foreach ($a as $key=>$value) {
    $key=$key."morning";
    $value.="papa";
    echo "$key=>$value";
}
echo "\n";
foreach ($a as $key=>&$value) {
    $key=$key."morning";
    $value.="papa";
    echo "$key=>$value";
}
echo "\n";
foreach ($a as $key=>$value) {
    $key=$key."morning";
    $value.="papa";
    echo "$key=>$value";
}
echo "\n";

$array=array();
$array["yiannis"]=array("papagiannis","papadimoulis");
$array["nickos"]=array("georgiou","papakos");
$temp=array();
$index=0;
foreach(array_keys($array) as $key) {
    $temp[1]=12;
    $temp[$key]=$array[$key][$index];
    echo $key."=".$temp[$key];
}

$array=array("hello"=>"wordl","hi"=>"nick");
foreach ($array as $name=>$value) {
   $array[trim($name)]=trim($value)." for ever!\n";
   $array[$name]=trim($value)." for ever!\n";
   echo $array[trim($name)];
}

function unsetf (&$var) {
    unset ($var);
}
$b="a";
$a=array("a"=>array("c"=>"hello"),"b"=>"world");
print_r($a);
unset ($a["a"]["c"]);
print_r($a);
unset ($a[$b[0]]);
print_r($a);
unsetf($a);
print_r($a);


$a=array("hello");
$b=array();
$b[0]=&$a;
$a[0]=" world!\n";
print_r($b);
$c=array("hello");
$d=array();
$d[0]=$c;
$c[0]=" world!\n";
print_r($d);

$wp_filter=array();
$tag="hello";
$wp_filter[$tag]=array ("123","456","789");
echo current($wp_filter[ $tag ])."\n1.";


foreach ( $wp_filter[$tag] as $the_ ) {
        print_r($the_);
    }
echo "\n";
reset( $wp_filter[ $tag ] );
echo current($wp_filter[ $tag ])."\n2.";
do {
    foreach ( (array) current($wp_filter[$tag]) as $the_ ) {
        echo $the_;
    }
} while ( next($wp_filter[$tag]) !== false );

$i=1;
$variable1=array("hello","everybody");
$variable2="hello";
$v1="variable1";
$v2="variable2";
echo ${$v2}."\n";
echo ${$v1}[$i]."\n";

?>
