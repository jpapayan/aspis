<?php

$x1=8;
$x2=$x1;
$x1++;
echo "  x1=$x1\n";
echo "  x2=$x2\n";
echo "-------------\n";
$x1=8;
$x2=&$x1;
$x1++;
echo "  x1=$x1\n";
echo "  x2=$x2\n";
echo "-------------\n";
$x1="hello";
$x2=$x1;
$x1.=" world!";
echo "  x1=$x1\n";
echo "  x2=$x2\n";
echo "-------------\n";
$xa="hello";
$xb=$xa;
$xa.=" world!";
echo "  xa=$xa\n";
echo "  xb=$xb\n";
echo "-------------\n";

/* This is not valid php, ie a ref in an array element means the array is NOT a string!
$str="hello\n";
$c=&$str[0];
$c='p';
echo $str;
*/

$a=array("\nnick\n");
$p=&$a[0];
$p2=array(&$a[0]);
echo $a[0];
$p="\npapa\n";
echo $a[0];
echo $p2[0];

//Doesn't work, involves classes, look bleow for a possible transformation
/*
$ca=new StdClass();
$ca->field=1;
$cb=$ca;
$cb->field++;
echo "  ca=$ca->field\n";
echo "  cb=$cb->field\n";

$ca = newPHPAspisObject(new StdClass())->copy();
$ca->object->field = newPHPAspisObject(1)->copy();
$cb = $ca->copy();
$cb->object->field->postincr();
echo newPHPAspisObject("  ca=")->concat($ca->object->field)->concat(newPHPAspisObject("\n"));
echo newPHPAspisObject("  cb=")->concat($cb->object->field)->concat(newPHPAspisObject("\n"));
*/

$a="123";
$b="a";
${$b}="789";
echo "$a\n";

class cla {
    var $data=array("data"=>"aaa");
    function f($cdata) {
        $this->data['data'] .= $cdata;
//rewritten: arrayAssign($this->data[0],deAspis(registerTaint(array('data',false))),addTaint(concat($this->data[0]["data"],$cdata)));
        echo $this->data["data"]." \n";
    }
}
$c=new cla();
$c->f(" from papaaa");
$a=array("k"=>"hello");
$a["k"].=" world!\n";
echo $a["k"];
?>