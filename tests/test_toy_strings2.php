Hello HTML WORLD!
<?php
$str = <<<DEMO
This is a demo message with heredoc.
and is great and i <br> like <html> a lot
DEMO;
$str2="12";
$str1="12";
$str= "A $str2 B $str1";
$str= "A $str2 B {$str1}";
$str= "A $str2 B ${str2}";


$ssd="aaa";
echo <<<MINE
Hello [] {$ssd}
MINE;
$a=$ssd;
echo "test brackets: [ ] $a";

//PHP Manual - New Single Quoted
echo 'this is a simple string';
echo 'You can also have embedded newlines in
strings this way as it is
okay to do';
// Outputs: Arnold once said: "I'll be back"
echo 'Arnold once said: "I\'ll be back"';
// Outputs: You deleted C:\*.*?
echo 'You deleted C:\\*.*?';
// Outputs: You deleted C:\*.*?
echo 'You deleted C:\*.*?';
// Outputs: This will not expand: \n a newline
echo 'This will not expand: \n a newline';
// Outputs: Variables do not $expand $either
echo 'Variables do not $expand $either';

$name="papajohn";
//PHP Manual - Heredoc
echo <<<EOT
My name is "$name". I am printing some $name
Now, I am printing some {$name}.
This should print a capital 'A': \x41
EOT;
//TODO: these do not work on the tranformer (YET!)
#var_dump(array(<<<EOD
#foobar!
#EOD
#));
// Static variables
#function foo()
#{
#    static $bar = <<<LABEL
#Nothing in here...
#LABEL;
#}

// Class properties/constants
#class foo
#{
#    const BAR = <<<FOOBAR1
#Constant example
#FOOBAR1;

    #public $baz = <<<FOOBAR2
#Property example
#FOOBAR2;
#}

echo "test brackets: [ ] { $a }";
$beer="Amstel";
echo "$beer's taste is great"; // works; "'" is an invalid character for variable names
#echo "He drank some $beers";   // won't work; 's' is a valid character for variable names but the variable is "$beer"
echo "He drank some ${beer}s"; // works
echo "He drank some {$beer}s"; // works
$fruits = array('strawberry' => 'red', 'banana' => 'yellow');
// Works, but note that this works differently outside a string
#echo "A banana is $fruits[banana].";
// Works
echo "A banana is {$fruits['banana']}.";
// Works, but PHP looks for a constant named banana first, as described below.
#echo "A banana is {$fruits[banana]}.";
// Won't work, use braces.  This results in a parse error.
//echo "A banana is $fruits['banana'].";
// Works
echo "A banana is " . $fruits['banana'] . ".";
// Works
#echo "This square is $square->width meters broad.";
// Won't work. For a solution, see the complex syntax.
#echo "This square is $square->width00 centimeters broad.";


$great="great";
print ("COMPLEX SYNTAX"."hi$great");
print "COMPLEX SYNTAX"."hi$great";
// Won't work, outputs: This is { fantastic}
echo "{    This is $great ";
echo "    This is $great {";

// Works, outputs: This is fantastic
echo "This is {$great}";
echo "This is ${great}";
// Works
//echo "This square is {$square->width}00 centimeters broad.";
// Works
#echo "This works: {$arr[4][3]}";
// This is wrong for the same reason as $foo[bar] is wrong  outside a string.
// In other words, it will still work, but only because PHP first looks for a
// constant named foo; an error of level E_NOTICE (undefined constant) will be
// thrown.
#echo "This is wrong: {$arr[foo][3]}";
// Works. When using multi-dimensional arrays, always use braces around arrays
// when inside of strings
#echo "This works: {$arr['foo'][3]}";
// Works.
#echo "This works: " . $arr['foo'][3];
#echo "This works too: {$obj->values[3]->name}";
//echo "This is the value of the var named by the return value of \$object->getName(): {${$object->getName()}}";

#$foo = new foo();
$bar = 'bar';
$baz = array('foo', 'bar', 'baz', 'quux');
#echo "{$foo->$bar}\n";
#echo "{$foo->$baz[1]}\n";


#echo ${${${$name->play}->again}};
#echo "var named $name: {${$name}}";
#echo "getName(): {${getName()}}";

class MyClaaas {
    var $aa;
}
$s=new MyClaaas();
$s->aa="mine";
echo("Content-Type : $s->aa");
echo("Content-Type : $s->aa hello");
echo("Content-Type : $s->aa hello $s->aa");
echo("Content-Type : $s->aa$s->aa");
echo(" $s->aa hi!");
echo("$s->aa hi!");
echo("$s->aa$s->aa");

////consequtive vars
$a1="hello ";
$a2="again ";
$a3="world!\n";
echo "$a1$a2$a3";
echo "$a1 $a2$a3$s->aa$a3";
echo <<<EOT
$a1 $a2$a3$s->aa$a3
EOT;

$cat_path =  ( "hello" ) . ( " world!\n" );
echo $cat_path;

$match=array("a","b","c","a");
echo "&lt;$match[1]$match[2]&gt;$match[3]&lt;/$match[1]&gt;";

?> 
Bye HTML world