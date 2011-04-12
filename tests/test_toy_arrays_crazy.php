<?php
$a=array( );
$a[] = "a";
$a[] = "b";
print_r($a);
$r =& $a[];
print_r($a);
$r = "c";
print_r($a);
//$v_result = $this->privFileDescrParseAtt($v_filedescr_list[], $v_supported_attributes);
?>
