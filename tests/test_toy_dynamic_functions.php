<?php
$f=create_function("","echo \"hello world!\n\";");
$f();
$a="nick";
echo "hello $a\n";
$f=create_function("\$a","echo \"hello \$a!\n\";");
$f("papajohn");
?>

