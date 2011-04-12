<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             substring examples
| category:         string handling
|
| last modified:    Mon, 20 Jun 2005 16:41:18 GMT
| downloaded:       Mon, 20 Sep 2010 13:00:48 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/string-handling/substring-examples/
|
| description:
| some examples using substr(), extracting the first, last, n chars of a string.
| reverse a string or see how many times a char is used in a string.
|
------------------------------------------------------------------------------*/

$s="hello";
echo $s[0];
echo "\n";

$aa=array();
$aa[0]=array();
$aa[0][0]="string";
$aa[0][1]=1;
$b=$aa;
$aa[0][0]="string in a";
$aa[0][1]++;
echo $b[0][0];
echo $aa[0][1];

echo '
<form method="post" action="./">
	<input type="text" name="word" />
	<input type="submit" value="see" />
</form>';
$_POST['word']="Papajohn is the greatest guy ever!";
if(!empty($_POST['word']))
{
	$str = $_POST['word'];

	$char['original'] = $str;

	$char['words'] = explode(' ',$str);

	$char['word_count'] = count($char['words']);

	$char['first_char'] = substr($str,0,1);

	$char['last_char'] = substr($str,-1);

	$char['all_but_first_char'] = substr($str,1);

	$char['all_but_last_char'] = substr($str,0,-1);

	$char['char_repeat'] = array();

	for($x = 0; $x < strlen($str); $x++)
	{
		$char['chars'][] = substr($str,$x,1);

                $a=$str{$x};
                $b=$char['char_repeat'];
		if(!array_key_exists($a,$b))
                        $char['char_repeat'][$str[$x]] = 0;

		$char['char_repeat'][$str{$x}]++;
	}

	$char['char_count'] = strlen($str);
	ksort($char['char_repeat']);
	$char['reverse'] = join('',array_reverse($char['chars']));

	echo '<pre>';
	print_r($char);
	echo '</pre>';
}
?>
