<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             simple bar chart
| category:         html and code
|
| last modified:    Mon, 20 Jun 2005 16:40:51 GMT
| downloaded:       Fri, 17 Sep 2010 17:16:02 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/html-and-code/simple-bar-chart/
|
| description:
| this simple bar chart doesn't require any image manipulation software on the
| server. it's done only in html and uses percentages in tables to show the chart.
|
------------------------------------------------------------------------------*/


// total width
$total_width = 600;
// base color
$base_color = 'silver';
// add an array per field to show
$graphs = array(
array('label'=>'whatever', 'color'=>'red', 'amount'=>'30'),
array('label'=>'more here', 'color'=>'green', 'amount'=>'36'),
array('label'=>'just an example', 'color'=>'blue', 'amount'=>'82'),
array('label'=>'even more', 'color'=>'orange', 'amount'=>'4'),
);
for($x = 0; $x < count($graphs); $x++)
{
	echo '
<table width="'.$total_width.'">
	<tr>
		<td colspan="2">
			'.$graphs[$x]['label'].'
		</td>
	</tr>
	<tr>
		<td width="'.$graphs[$x]['amount'].'%" bgcolor="'.$graphs[$x]['color'].'">
			'.$graphs[$x]['amount'].'%
		</td>
		<td width="'.(100-$graphs[$x]['amount']).'%" bgcolor="'.$base_color.'">
			&nbsp;
		</td>
	</tr>
</table>';
}
?>