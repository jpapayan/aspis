Hello HTML WORLD!
<?php 
##KNOWN ERRORS
#$str = <<<DEMO
#This is a demo message with heredoc.
#DEMO;
#$str="ss $a";

#statements
$srt="hello";
$obj = (object) array('foo' => 'bar', 'property' => 'value');
#use hello;
declare(ticks=1);
#include 'vars.php';
#require 'vars.php';
#eval("echo hello!");
empty($as);
const c="a",d="hello!";
global $d,$aa;
print("Hello World");
print "print() also works without parentheses.";
static $e="hello!",$ccc="aaa";
$no1=1;
if ($no1==1) echo "hi";
elseif ($no1==2) echo "hi again";
else { echo "not done"; echo "cool";}
return 3;
testlabel:
$ww="12";
test::StaticMethod();
goto testlabel;
$a=$a instanceof MyClass;
$obj2 = clone $obj;
exit;
exit();
exit(0);
unset($GLOBALS['bar']);
list($drink, $color, $power) = $info;
list($drink, , $power) = $info;
#operators
$a = (false && foo()) || false;
$b = (true  || foo());
$c = (false and foo());
$d = (true  or  foo());
$d+=100;
$d/=100;
$s>>=$a2<<4;
#for
for ($i=1;$i<100;--$i) {
  $i=$i+2;
}
#while
while ($res<=10) {
echo "Please enter a number:";
$no1 = (int)getInput();
} 
#do-while
do {
echo "Please enter a number:";
$no1 = (int)getInput();
} while ($res<=10);
#foreach
$arr = array(1, 2, 3, 4);
foreach ($arr as &$value) {
    $value = $value * 2;
}
#switch
switch ($i) {
    case 0:
        echo "i equals 0";
        break;
    case 1:
        echo "i equals 1";
        break;
    default:
        echo "i equals 2";
        break;
}
#try-cacthes
try {
    echo inverse(5) . "\n";
    echo inverse(0) . "\n";
    throw $e;
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
catch (Exception $s) {}
catch (Exception $e) {
    echo '1 ',  '2', '3','4';
}
#functions
function a($n){ 
  b($n); 
  return ($n * $n); 
} 
#classes!
class MySqlDriver extends SqlDriver implements XXXClass,XC {
   private $_Link;
   private $a,$b="a",$c,$d="b";
   public function &  __construct( $fas ) {
      $this->_Link = mysql_connect(  );
      return 3;
   }
  // this will be called automatically at the end of scope
   public function  __destruct() {
      mysql_close( $this->_Link );
      second();
   }
   public static $s;
}
print MySqlDriver::$s;
?> 
bye html world