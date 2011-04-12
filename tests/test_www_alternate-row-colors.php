<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             alternate row colors
| category:         html and code
|
| last modified:    Mon, 20 Jun 2005 16:40:45 GMT
| downloaded:       Fri, 17 Sep 2010 17:12:51 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/html-and-code/alternate-row-colors/
|
| description:
| this will output a table with alternating row backround colors. with this the
| user can read the entries much easier
|
------------------------------------------------------------------------------*/


      
// just some random data in an array
$data = array('this','is','just','an','example','to','show','the','alternating','row','colors');
$rows = count($data);

// the two colors to switch between
$rowcolor1 = '#F0F0F2';
$rowcolor2 = '#FFFFFF';

// the background colors on mouseover
$hovercolor1 = '#BAD4EB';
$hovercolor2 = '#DCE9F4';

echo '
<table style="caption-side: top; 
	border: 0.1em solid #eee;
	border-collapse: collapse; 
	margin: 1em; 
	width: 30em;">
	<caption style="font-weight: bold;">Demonstration of alternate row colors</caption>';

for($n = 0; $n < $rows; $n++)
{
	// this is where the magic happens
	if($n % 2 == 1)
	{
		// add more things to swop with each cycle
		$style = $rowcolor1;
		$hoverstyle = $hovercolor1;
	}else{
		$style = $rowcolor2; 
		$hoverstyle = $hovercolor2;
	}

	echo '
	<tr id="row'.$n.'" style="background:'.$style.';"
		onmouseover="this.style.background=\''.$hoverstyle.'\'"
		onmouseout="this.style.background=\''.$style.'\'">
		<td style="padding: 0.3em 1em;">'.$data[$n].'</td>
	</tr>';
}

echo '
</table>';
      
?>