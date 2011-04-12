<?php

function array_multi_sort($array, $index, $order='desc', $natural_sort=FALSE, $case_sensitive=FALSE)
{
//        $temp=array();
	if(is_array($array) && count($array)>0)
	{
		foreach(array_keys($array) as $key) $temp[$key]=$array[$key][$index];
		if(!$natural_sort) ($order=='asc')? asort($temp) : arsort($temp);
		else
		{
			($case_sensitive)? natural_sort($temp) : natcasesort($temp);
			if($order!='asc') $temp=array_reverse($temp,TRUE);
		}
		foreach(array_keys($temp) as $key)
			(is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key];
		return $sorted;
	}
	return $array;
}
// demo of complex array sorting
$demoarray = array(
	'whatever'=>array(
		'first'=>25,
		'second'=>'fred'
	),
	'whatever2'=>array(
		'first'=>36,
		'second'=>'simone'
	),
	'whatever3'=>array(
		'first'=>12,
		'second'=>'tom'
	),
	'whatever4'=>array(
		'first'=>3,
		'second'=>'peter'
	),
	'whatever5'=>array(
		'first'=>56,
		'second'=>'maria'
	)
);
$sortorder = 'desc';
$index = 'first';
$demoarray = array_multi_sort($demoarray, $index,$sortorder);
echo '
	<p>
		array sorted by fieldname &quot;'.$index.'&quot; in '.$sortorder.'ending order
	</p>
	<p>';
foreach($demoarray as $row)
{
	echo '
		'.print_r($row["first"].$row["second"],true).'<br />';
}
echo '
	</p>';
$sortorder = 'asc';
$index = 'second';
$demoarray = array_multi_sort($demoarray, $index,$sortorder);
echo '
	<p>
		array sorted by fieldname &quot;'.$index.'&quot; in '.$sortorder.'ending order
	</p>
	<p>';
foreach($demoarray as $row)
{
	echo '
		'.print_r($row["first"].$row["second"],true).'<br />';
}
echo '
	</p>';

?>