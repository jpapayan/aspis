<?php
//superglobals
$var=12;
$var2=33;
$var3=44;
echo "1.",$GLOBALS["var"],"\n";
//echo "2.",$GLOBALS['argv'][0],"\n";
$_POST["hello"]="world";
echo $GLOBALS["var"];
echo $GLOBALS["argc"];
echo $_POST["hello"]."\n";
//echo $_SERVER["argv"][0];

echo "\n\nGLOBALS:\n";

//TODO:problematic, some extra entries for a weird reason
foreach ($_GET as $key=>$value) {
    echo "$key=>$value\n";
}
?>