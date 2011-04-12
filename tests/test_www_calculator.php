<?php

if(isset($_POST['act']) 
	&& !empty($_POST['z1'])
	&& !empty($_POST['z2'])
	&& is_numeric($_POST['z1'])
	&& is_numeric($_POST['z2']))
{
        echo '<p><a href="test_toy_calculator.php">try again</a></p>';
	if($_POST['act'] == 'add')
	{
		$calc = ($_POST['z1']+$_POST['z2']);
		$op = '+';
	}
	if($_POST['act'] == 'sub')
	{
		$calc = ($_POST['z1']-$_POST['z2']);
		$op = '-';
	}
	if($_POST['act'] == 'div')
	{
		$calc = ($_POST['z1']/$_POST['z2']);
		$op = '/';
	}
	if($_POST['act'] == 'mul')
	{
		$calc = ($_POST['z1']*$_POST['z2']);
		$op = '*';
	}
	if($_POST['act'] == 'pro')
	{
		$calc = (($_POST['z2']*$_POST['z1'])/100);
		$op = '% of';
	}
	echo '
	<p>'.$_POST['z1'].' '.$op.' '.$_POST['z2'].' = '.$calc.'</p>
	<p><a href="test_toy_calculator.php">try again</a></p>';

}else{
	echo '
	<form method="post" action="test_toy_calculator.php">
		<input type="text" name="z1" size="5" /> 
		<select name="act">
			<option value="add">[ + ]</option>
			<option value="sub">[ - ]</option>
			<option value="div">[ / ]</option>
			<option value="mul">[ * ]</option>
			<option value="pro">[ % ]</option>
		</select>
		<input type="text" name="z2" size="5" /> 
		<input type="submit" name="doit" value="calculate" />
	</form>';
}
	
?>