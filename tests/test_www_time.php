<?php

// reads like: Fri Jan 03, 2003 12:01:21
echo '<p>'.date('D M d, Y H:i:s').'</p>';

/*
 where
 
 Y = Year eg. 2003 
 y = Year eg. 03 
 M = Month eg. Jan 
 m = Month eg. 01 
 D = Day eg. Fri 
 d = Day eg. 03 
 z = Day of the year eg. 002 
 H = Hours in 24 hour format eg. 07 
 h = Hours in 12 hour format eg. 7 
 i = Minutes eg. 29 
 s = Seconds eg. 28 
 U = Seconds since epoch eg. 1041604168

if you want some letters in the output, which are NOT to parse, escape them with a backslash like
*/

// reads like: Fri Jan 03, 2003 12 hours 01 minutes 21 seconds
echo '<p>'.date('D M d, Y H \h\o\u\r\s i \m\i\n\u\te\s s \s\e\c\o\n\d\s').'</p>';

?>