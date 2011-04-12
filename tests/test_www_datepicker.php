<?php
//ip108
$_POST['day']=12;
$_POST['month']=12;
$_POST['year']=2012;

echo '
<p>date picker</p>';

// create the form
echo '
<form method="post" action="./">
	<select name="month">
		<option>please choose a month</option>';

// create the month pull-down menu
$month = 1;
while($month <= 12)
{
	$monthname = date('F', mktime(0,0,0,$month));
	echo '
		<option value="'.$month.'">'.$monthname.'</option>';
	$month++;
}

echo '
	</select>
	<select name="day">
		<option>please choose the day</option>';

// create the day pull-down menu.
$day = 1;
while($day <= 31)
{
	echo '
		<option value="'.$day.'">'.$day.'</option>';
	$day++;
}

echo '
	</select>
	<select name="year">
		<option>please choose a year</option>';

// create the year pull-down menu.
$year = date('Y');
$last_year = $year + 10;
while($year <= $last_year)
{
	echo '
		<option value="'.$year.'">'.$year.'</option>';
	$year++;
}

echo '
	</select>
	<input type="submit" value="submit" />
</form>';

// example output
if(isset($_POST['month'])
	&& is_numeric($_POST['month'])
	&& isset($_POST['day'])
	&& is_numeric($_POST['day'])
	&& isset($_POST['year'])
	&& is_numeric($_POST['year']))
{
	$day = $_POST['day'];
	$month = $_POST['month'];
	$year = $_POST['year'];

	echo '
<p>you selected '.date('l, F \t\he jS Y', mktime(0,0,1,$month,$day,$year)).'.</p>';
}

?>