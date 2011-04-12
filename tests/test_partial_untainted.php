<?php
function funtainted(){
    echo "# argc is: ";
    //echo $GLOBALS["argc"];
    $GLOBALS["argc"]=33;
    echo $GLOBALS["argc"];
    $_POST["argc"]["you"]=12;
    echo $_POST["argc"]["you"];
    echo "\n";
    global $gl;
    echo "global \$gl is:".($gl*22)."\n";
    ftainted();
    echo "global \$gl is:".($gl*33)."\n";
}
function ftainted() {
    global $gl;
    echo "global \$gl is:".($gl*33)."\n";
    $gl=13;
    echo "new global \$gl is:".($gl*33)."\n";
    echo "inside post:". $_POST["argc"]["you"]."\n";
}
//echo "# argc is: ";
//echo $GLOBALS["argc"];
//echo "\n";
$gl=11;
funtainted();

class cltainted {
    var $var1="hello!";
    var $var2="hello again!";
    function hi() {
        global $gl;
        echo "global \$gl from cltainted is:".($gl*33)."\n";
        $gl=14;
    }
}
$o=new cltainted();
$o->hi();
funtainted();

$vars=get_object_vars($o);
foreach ($vars as $k=>$v) {
    echo "$k=>$v\n";
}

class cluntainted {
    var $var1="hello!";
    var $var2="hello again!";
    function hi() {
        global $gl;
        echo "global \$gl from cluntainted is:".($gl*33)."\n";
        $gl=15;
    }
}
$o=new cluntainted();
$o->hi();
funtainted();

$vars=get_object_vars($o);
foreach ($vars as $k=>$v) {
    echo "$k=>$v\n";
}

if (isset($GLOBALS["argc"])) echo "globals isset works\n";
else echo "globals isset doesn't work\n";
if (isset($_POST["argc"]["you"])) echo "post isset works\n";
else echo "post isset doesn't work\n";

$_POST["argc"]["you"].="aaa";
if (empty($GLOBALS["argc"])) echo "globals empty not work\n";
else echo "globals empty works\n";
if (empty($_POST["argc"]["you"])) echo "post empty doesn't work\n";
else echo "post empty works\n";
unset($_POST["argc"]["you"]);

$a=array(1,2,3,4,5);
$b=array(1,2,3,4,5);
foreach ($a as $e1) {
    foreach ($b as $e2) {
        echo "($e1,$e2)";
        if ($e2==4) break 2;
    }
}

?>