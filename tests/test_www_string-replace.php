<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             string replace
| category:         string handling
|
| last modified:    Mon, 20 Jun 2005 16:41:17 GMT
| downloaded:       Mon, 20 Sep 2010 13:00:35 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/string-handling/string-replace/
|
| description:
| some useful functions to replace strings in strings
|
------------------------------------------------------------------------------*/


// Multiple string replace
// expects an array with $string => $replacement
$old_string = 'file_example.txt<br>another_file.txt<br>phpexample.php<br>';
$replacements = array('_'=>' ','<br>'=>' ,','.txt'=>' (Text)','.php'=>' (PHP)');
$new_string = strtr($old_string,$replacements);
echo '<p>'.$new_string.'</p>';
// Number Padding, PHP
// Doesn't have to be zeros or numberic but handy for making sure you keep leading zeros on
// day and month values when receiving such values as POST or GET variables.
$no_a = 3;
$no_a = str_pad($no_a, 2, '0', STR_PAD_LEFT);
echo '<p>'.$no_a.'</p>';
//// String replacing, PHP
$old_string = 'the qick brown fox jumped over the lazy dog.';
$new_string = str_replace('qick brown fox', 'slow black bear', $old_string);
echo '<p>'.$new_string.'</p>';
// Remove tags using preg_replace, PHP
// This should remove anything and everything everything between
// 'less than' and 'greater than' characters
$source_string = '<b>bold</b> <a href="blank.php">link</a>';
$replacement = '(tag removed)';
$replaced_string = preg_replace('[<.*?.>]', $replacement, $source_string);
echo '<p>'.$replaced_string.'</p>';
//// preg_replace can be used with arrays as well
$string = 'The quick brown fox jumped over the lazy dog.';
$patterns = array('/quick/','/brown/','/fox/');
$replacements = array('slow','black','bear');
echo '<p>'.preg_replace($patterns, $replacements, $string).'</p>';
?>