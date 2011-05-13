<?php
function fsource() {
    return "<script> attack!";
}

$v=fsource();
echo $v;

?>