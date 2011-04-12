 <?php
function fff() {
    $var="variable";
    global $$var;
    echo $variable."\n";
}
$variable="hello world";
fff();
?>

