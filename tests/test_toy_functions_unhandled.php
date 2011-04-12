<?php
//cannt support that ARRAY_MULTISORT
//$data[] = array('volume' => 67, 'edition' => 2);
//$data[] = array('volume' => 86, 'edition' => 1);
//$data[] = array('volume' => 85, 'edition' => 6);
//$data[] = array('volume' => 98, 'edition' => 2);
//$data[] = array('volume' => 86, 'edition' => 6);
//$data[] = array('volume' => 67, 'edition' => 7);
//foreach ($data as $key => $row) {
//    $volume[$key]  = $row['volume'];
//    $edition[$key] = $row['edition'];
//}
//array_multisort($volume, SORT_DESC, $edition, SORT_ASC, $data);
//print_r($data);


$a=array();
$i=array("yiannis"=>"papagiannis");
$j=array("matteo"=>"migliavaca");
array_push($a,$i);
array_push($a,$j);
foreach ($a as $key=>$value) {
    echo "$key: ";
    foreach ($value as $kk=>$vv) {
        echo "$kk=>$vv\n";
    }
}
echo "done!\n";

array_shift($a);
print_r($a);
array_pop($a);
print_r($a);
$fruits = array("d"=>"lemon", "a"=>"orange", "b"=>"banana", "c"=>"apple");
krsort($fruits);
foreach ($fruits as $key => $val) {
    echo "$key = $val\n";
}

function someFunction()
{
}
$functionVariable = 'someFunction';
print_r(is_callable($functionVariable, false, $callable_name));  // bool(true)
echo $callable_name, "\n";  // someFunction
class someClass {
  function someMethod()
  {
  }
}
//
//strreplace
$anObject = new someClass();
$methodVariable = array($anObject, 'someMethod');
print_r(is_callable($methodVariable, true, $callable_name));  //  bool(true)
echo $callable_name, "\n";  //  someClass::someMethod
$bodytag = str_replace("%body%", "black", "<body text='%body%'>");
$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
$onlyconsonants = str_replace($vowels, "", "Hello World of PHP");
$phrase  = "You should eat fruits, vegetables, and fiber every day.";
$healthy = array("fruits", "vegetables", "fiber");
$yummy   = array("pizza", "beer", "ice cream");
$newphrase = str_replace($healthy, $yummy, $phrase);
$str = str_replace("ll", "", "good golly miss molly!", $count);
//echo $count; //cpunt doesn work in my library now
$str     = "Line 1\nLine 2\rLine 3\r\nLine 4\n";
$order   = array("\r\n", "\n", "\r");
$replace = '<br />';
$newstr = str_replace($order, $replace, $str);
$search  = array('A', 'B', 'C', 'D', 'E');
$replace = array('B', 'C', 'D', 'E', 'F');
$subject = 'A';
echo str_replace($search, $replace, $subject);
$letters = array('a', 'p');
$fruit   = array('apple', 'pear');
$text    = 'a p';
$output  = str_replace($letters, $fruit, $text);
echo $output;

//array_splice
$input = array("red", "green", "blue", "yellow");
array_splice($input, -1, 1, array("black", "maroon"));
print_r($input);
//
function cmp($a, $b)
{
    $a = preg_replace('@^(a|an|the) @', '', $a);
    $b = preg_replace('@^(a|an|the) @', '', $b);

    return strcasecmp($a, $b);
}
$a = array("John" => 1, "the Earth" => 2, "an apple" => 3, "a banana" => 4);
uksort($a, "cmp");
foreach ($a as $key => $value) {
    echo "$key: $value\n";
}

function cmp2($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}
$array = array('a' => 4, 'b' => 8, 'c' => -1, 'd' => -9, 'e' => 2, 'f' => 5, 'g' => 3, 'h' => -4);
//print_r($array);
uasort($array, 'cmp2');
print_r($array);
//
//
//
function cube($n)
{
    return($n * $n * $n);
}
$a = array(1, 2, 3, 4, 5);
$b = array_map("cube", $a);
print_r($b);

$str="byebye..!\n";
function shutdown()
{
    global $str;
    echo $str;
    echo 'Script executed with success', PHP_EOL;
}
register_shutdown_function('shutdown');


function increment(&$var)
{
    $var++;
}
$a = 0;
call_user_func('increment', $a);
echo $a."\n";

//problem with the prototypes
function key_compare_func($key1, $key2)
{
    if ($key1 == $key2) {
        return 0;
    }
    else if ($key1 > $key2) {
        return 1;
    }
    else {
        return -1;
    }
}
$array1 = array('blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4);
$array2 = array('green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8);
print_r(array_diff_ukey($array1, $array2, 'key_compare_func'));

$ar1 = array(10, 100, 100, 0);
$ar2 = array(1, 3, 2, 4);
array_multisort($ar1);
array_multisort($ar2);
print_r($ar1);
print_r($ar2);
$ar = array(
       array("101","10", 11, 100, 100, "a"),
       array(   1,  2, "2",   3,   1)
      );
array_multisort($ar[0], SORT_ASC, SORT_STRING);
array_multisort($ar[1], SORT_NUMERIC, SORT_DESC);
print_r($ar[0]);
print_r($ar[1]);



$stack = array("orange", "banana");
array_push($stack, "apple", "raspberry");
print_r($stack);
$queue = array("orange", "banana");
array_unshift($queue, "apple", "raspberry");
print_r($queue);

list($serial) = sscanf("SN/2350001", "SN/%d");
$mandate = "January 01 2000";
list($month, $day, $year) = sscanf($mandate, "%s %d %d");
echo "Item $serial was manufactured on: $year-" . substr($month, 0, 3) . "-$day\n";
$auth = "24\tLewis Carroll";
$n = sscanf($auth, "%d\t%s %s", $id, $first, $last);
echo "<author id='$id'>
    <firstname>$first</firstname>
    <surname>$last</surname>
</author>\n";

echo max(1, 3, 5, 6, 7);  // 7
echo max(array(2, 4, 5)); // 5
echo max(0, 'hello');     // 0
echo max('hello', 0);     // hello
echo max('42', 3); // '42'
echo max(-1, 'hello');    // hello
$val = max(array(2, 2, 2), array(1, 1, 1, 1)); // array(1, 1, 1, 1)
print_r($val);
$val = max(array(2, 4, 8), array(2, 5, 7)); // array(2, 5, 7)
print_r($val);
$val = max('string', array(2, 5, 7), 42);   // array(2, 5,
print_r($val);

print_r(pack("nvc*", 0x1234, 0x5678, 65, 66));

setlocale(LC_ALL, 'nl_NL');

echo strftime("%A %e %B %Y", mktime(0, 0, 0, 12, 22, 1978));
$loc_de = setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
echo "Preferred locale for german on this system is '$loc_de'";

list($serial) = sscanf("SN/2350001", "SN/%d");
$mandate = "January 01 2000";
list($month, $day, $year) = sscanf($mandate, "%s %d %d");
echo "Item $serial was manufactured on: $year-" . substr($month, 0, 3) . "-$day\n";

function fooA()
{
    static $bar;
    $bar=0;
    $bar++;
    echo "Before unset: $bar, ";
    unset($bar);
    $bar = 23;
    echo "after unset: $bar\n";
}
fooA();
fooA();
fooA();


function barber($type)
{
    echo "You wanted a $type haircut, no problem\n";
}
barber("classic");
call_user_func('barber', "mushroom");
call_user_func('barber', "shave");
call_user_func('print_r', "hello internal functions!\n");

function foobar($arg, $arg2) {
    echo __FUNCTION__, " got $arg and $arg2\n";
}
class foo {
    function bar($arg, $arg2) {
        echo __METHOD__, " got $arg and $arg2\n";
    }
}
call_user_func_array("foobar", array("one", "two"));
$foo = new foo;
call_user_func_array(array($foo, "bar"), array("three", "four"));

$arr=array("1","3","3");
echo count($arr);


class Cl {
   var $v="12";
   function  __construct($var) {
       $this->v=$var;
   }
   function printme($add) {
       echo ($this->v)."\n";
       return $this;
   }
}

echo "\nuser_func_array\n";
$c=new Cl(33);
$c=call_user_func_array(array($c,"printme"),array(17));
call_user_func_array(array($c,"printme"),array(17));

echo "\nuser_func\n";
$c=new Cl(33);
$c=call_user_func(array($c,"printme"),17);
call_user_func(array($c,"printme"),17);


echo "\nuser_func_array\n";
$c=call_user_func_array("array_sum",array(array(12,3,4,6,7)));
$c+=call_user_func_array("array_sum",array(array(12,3,4,6,9)));
echo $c;

echo "\nuser_func\n";
$c=call_user_func("array_sum",array(12,3,4,6,7));
$c+=call_user_func("array_sum",array(12,3,4,6,9));
echo $c;


function play(&$arr,$element) {
    foreach ($arr as &$el) {
        $el.=$element;
    }
}
$a=array("yiannis", "matteo");
$args=array(&$a," hello!");
call_user_func_array("play",$args);
print_r($a);
?>
