<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             keep selected combobox
| category:         forms
|
| last modified:    Tue, 21 Jun 2005 00:22:32 GMT
| downloaded:       Fri, 17 Sep 2010 15:22:22 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/forms/keep-selected-combobox/
|
| description:
| often you need to "remember" what a user inputs in a form. that's not a problem
| with textfields, but with selectboxes it's a bit harder...
|
------------------------------------------------------------------------------*/
//ip108
$_POST['country']='uk';
  
// you need the values of your combobox in an array
$country_values = array('us','de','uk','fr','gb');
if(isset($_POST['country']) && in_array($_POST['country'], $country_values))
{
	$selected_country = $_POST['country'];
	$country_output = 'you selected &quot;'.$_POST['country'].'&quot;';
}else{
	// input default value, if empty the first variable will be shown
	$selected_country = '';
	$country_output = 'please select an option';
}
$option_num = count($country_values);
echo '
	<form method="post" action="./">
		<label>'.$country_output.'</label>
		<select name="country">';
  
for($x = 0; $x < $option_num; $x++)
{
	// print the options
	echo '
			<option value="'.$country_values[$x].'"'.($country_values[$x] == $selected_country ? 
				' selected="selected"' : '').'>'.$country_values[$x].'</option>';
}
  
echo '
		</select>
		<input type="submit" value="check it out" />
	</form>';
echo "Is the array ok? country:$country_values[3]";
?>