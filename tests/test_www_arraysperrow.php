<?php

// your data in an array
$images = array(
			'here\'s',
			'some',
			'data',
			'or',
			'images',
			'you',
			'want',
			'to',
			'show',
			'with',
			'as',
			'many',
			'entries',
			'per',
			'row',
			'as',
			'you',
			'specify');

// how many entries per row to display
$per_row = 3;

// display the table
echo '
<table style="width: 30em; margin: 1em; border: 0.1em solid #eee;">';

$count = 0;
$total = count($images);
for($x = 0; $x < $total; $x++)
{
	// if we start a line
	if($count == 0)
	{
		echo '
	<tr>';
	}

	// display the entry - change this to i.e. display image etc
	echo '
		<td>'.$images[$x].'</td>';

	// increase the count
	$count++;

	// if the max number per row is reached or it's the last entry
	if(($count == $per_row) || ($images[$x] == end($images)))
	{
		echo '
	</tr>';
		// reset the count
		$count = 0;
	}
}

echo '
</table>';

?>