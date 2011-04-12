<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             view php source
| category:         html and code
|
| last modified:    Sat, 02 Jul 2005 00:51:32 GMT
| downloaded:       Fri, 17 Sep 2010 17:16:43 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/html-and-code/view-php-source/
|
| description:
| this will show you the source of any PHP file with syntax-highlighting
|
------------------------------------------------------------------------------*/

$_POST['selected_file']="/home/papajohn/public_html/phpparser/doTests.py";

echo '
<form name="form1" method="POST" action="">
	<input type="text" name="selected_file" />
	<input type="submit" value="view highlighted code" />
</form>
<hr />';

if(!empty($_POST['selected_file']))
{

	$userfile = $_POST['selected_file'];
	echo '
<p><b>full path:</b> '.$userfile.'</p>';

	$myArray = explode('/',$userfile);
	$selected_file_name = end($myArray);
	echo '
<p><b>filename:</b> ' . $selected_file_name . '</p>
<hr />';

	$strFile = file($selected_file_name);
	$newStr = join(' ',$strFile);

	echo '
<div style="background: whitesmoke; width: 600px;">';

	highlight_string($newStr);

	echo '
</div>';
 
	echo '
<hr />
<p><i>End Of File</i></p>';

}else{

	echo '
<p>Please select a file.</p>';

}

?>
