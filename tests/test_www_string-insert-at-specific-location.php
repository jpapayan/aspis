<?php

/*
| lets say you have a file where you want to insert a string into an existing file
| at a specific location. put a key into the file where you want the new text
| appear, i.e.: ###INSERTHERE### then use this function to insert the new data at
| this keypoint
|
------------------------------------------------------------------------------*/


/*------------------------------------
| function insert_string_in_file
| 
| expects: $file          - required [path] to the file you want to work with
|          $insert_point  - required [string] which should be acted on
|          $string        - required [string] which should be inserted
|          $return        - optional [bool] returns message if true, true|false if not
|          $position      - optional [string] before|after - default is replace
|
| returns: [string] with status message
|
|-----------------------------------*/
function insert_string_in_file($file,$insert_point,$string,$return=FALSE,$position='')
{
	// check if file exists
	if(!file_exists($file))
	{
		return($return === TRUE ? 'ERROR - file ('.$file.') does not exist' : FALSE);
	}
	// check if file is writeable
	if(!is_writeable($file))
	{
		return($return === TRUE ? 'ERROR - file ('.$file.') is not writeable' : FALSE);
	}
	// contruct insertion scheme
	if(empty($position))
	{
		// if nothing specified, replace the insertion point with string
		$replacement[$insert_point] = $string;
	}else{
		if($position == 'before')
		{
			// insert the string before the insertion point
			$replacement[$insert_point] = $string.$insert_point;
		}elseif($position == 'after')
		{
			// insert the string after the insertion point
			$replacement[$insert_point] = $insert_point.$string;
		}else{
			return($return === TRUE ? 'ERROR - position ('.$position.') is invalid - 
					use &quot;before&quot; or &quot;after&quot;' : FALSE);
		}
	}
	// check filelenght
	$filesize = filesize($file);
	clearstatcache();
	if($filesize == 0)
	{
		return ($return === TRUE ? 'ERROR - file ('.$file.') is empty' : FALSE);	
	}
	// open file for read and write access
	if(!$handle = fopen($file, 'r+'))
	{
		return($return === TRUE ? 'ERROR - cannot open file ('.$file.')' : FALSE);
	}else{
		$old_contents = fread($handle, $filesize);
	}
	// insert string at the insertion point
	if(!strpos($old_contents,$insert_point))
	{
		fclose($handle);
		return($return === TRUE ? 'ERROR - insertion point ('.$insert_point.') not found' : FALSE);
	}else{
		//ftruncate($handle,0);
		$new_contents = strtr($old_contents,$replacement);
	}
	// write new content to file
//	if(fwrite($handle, $new_contents) === FALSE)
//	{
//		fclose($handle);
//		return ($return === TRUE ? 'ERROR - cannot write to file ('.$file.')' : FALSE);
//	}
        echo "CONTENTS:\n$new_contents\n";
	fclose($handle);
	return($return === TRUE ? 'SUCCESS - your string was inserted' : TRUE);
}
// use like
$the_file = '/home/papajohn/public_html/phpparser/dummy dir 1/php_functions_overriden.txt';
$insert_key = '###INSERTHERE###';
$new_data = ' THIS IS MY NEW TEXT';
// insert string before insertion point and get verbose messages
echo insert_string_in_file($the_file,$insert_key,$new_data,TRUE,'before').'<br />';
$new_data = ' should be here';
// simply replace insertion point
if(insert_string_in_file($the_file,$insert_key,$new_data))
{
	echo $insert_key.' was replaced by '.$new_data.' in the file '.$the_file.'.';
}else{
	echo 'insertion failed<br />';
}
?>