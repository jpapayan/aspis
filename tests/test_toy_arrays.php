<?php
$a="1";
$a=array("hello"=>2);
$a=array($a=>8,"hello"=>2,5);
$a["hello"]=3;
echo $a["hello"];
echo $a[0];
echo $a[2];
$b=$a;
$b["1"]=12;
$x1=1;
echo "\na[1]=$a[$x1] b[1]=$b[1]\n";

$arr = array("somearray" => array(6 => 5, 13 => 9, "a" => 42));
//$arr[]=1;
echo $arr["somearray"][6]."\n";    // 5
echo $arr["somearray"][13]."\n";   // 9
echo $arr["somearray"]["a"]."\n";  // 42
echo "Foreach:";
foreach ($arr["somearray"] as $value) echo $value;
echo "\n";
$a=0;
foreach ($arr["somearray"] as $value) $a+=$value;
echo "Sum:$a\n";

class Aaa {
    private $A; // This will become '\0A\0A'
}

class Baa extends Aaa {
    private $A; // This will become '\0B\0A'
    public $AA; // This will become 'AA'
}

var_dump((array) new Baa());


$var="12";
$arr1=array(&$var,"13");
$arr2=array("13","14");
$res=array_merge($arr1,$arr2);
$var="0";
print_r($res);
echo "\n";

$v=array("hello"=>"papajohn");
$i="hello";
echo "$i";
echo "$i\n";
echo $v["$i"]."\n";
echo $v[$i]."\n";

$v=null;
$a=(array)$v;
if (is_array($a)) echo "is empty!";
?>
