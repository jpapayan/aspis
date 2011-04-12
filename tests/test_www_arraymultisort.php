<?php
$start=microtime(true);
// demo array to sort
$array_to_sort = array(
					array('Paul','Allan','25','user'),
					array('Fred','Kruger','13','moderator'),
					array('Anna','Sweet','58','user'),
					array('John','Doe','69','user'),
					array('Cindy','Heller','29','moderator'),
				);
// specify the default field to sort
$sort_field = 1;
// compare function
function cmpi($a, $b)
{
	global $sort_field;
	return strcmp($a[$sort_field], $b[$sort_field]);
}
// display sorting options
$sort_num = count($array_to_sort[0]);
$array_num = count($array_to_sort);
if(isset($_GET['sort']) 
	&& is_numeric($_GET['sort'])
	&& in_array($_GET['sort'],range(0,$sort_num)))
{
	$sort_field = $_GET['sort'];
}
echo "<p> Selection is: $sort_field </p>";
echo '
<ul style="list-style: none; padding: 0.5em;">';
for($i = 0; $i < $sort_num; $i++)
{
	echo ($i != $sort_field ? '
	<li><a href="test_www_arraymultisort.php?sort='.$i.'">sort by '.($i+1).'. field</a></li>' : '
	<li><strong>currently sorted by '.($i+1).'. field</strong></li>');
}
echo '
</ul>';
// do the array sorting
echo "<p>1Malakia $array_num</p>";
usort($array_to_sort, 'cmpi');
echo "<p>2Malakia $array_num</p>";
// demo output
echo '
<table style="width: 30em; 
	border: 0.1em solid #eee; 
	border-collapse: collapse; 
	margin: 1em 0;
	padding: 0.2em;">';
for($i = 0; $i < $array_num; $i++)
{
	echo '
	<tr>';
	for($x = 0; $x < $sort_num; $x++)
	{
		echo '
		<td>'.$array_to_sort[$i][$x].'</td>';
	}
	echo '
	</tr>';
}
echo '
</table>';
$end=microtime(true);
$diff=($end-$start)*1000;
#echo "<p>Took $diff ms</p>";
?>