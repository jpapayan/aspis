<?php
//// Provides: <body text='black'>
$bodytag = str_replace("%body%", "black", "<body text='%body%'>");
echo $bodytag."\n";
$bodytag = str_replace("%body%", "black", "<body text='%body%' and '%body%' >");
echo $bodytag."\n";

//Provides: Hll Wrld f PHP
$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
$onlyconsonants = str_replace($vowels, "", "Hello World of PHP");
echo $onlyconsonants."\n";

// Provides: You should eat pizza, beer, and ice cream every day
$phrase  = "You should eat fruits, vegetables, and fiber every day.";
$healthy = array("fruits", "vegetables", "fiber");
$yummy   = array("pizza", "beer", "ice cream");
$newphrase = str_replace($healthy, $yummy, $phrase);
echo $newphrase."\n";

// Provides: 2
$str = str_replace("ll", "", "good golly miss molly!");
echo $str."\n";


// Order of replacement
$str     = "Line 1\nLine 2\rLine 3\r\nLine 4\n";
$order   = array("\r\n", "\n", "\r");
$replace = '<br />';
// Processes \r\n's first so they aren't converted twice.
$newstr = str_replace($order, $replace, $str);
echo $newstr."\n";

// Outputs F because A is replaced with B, then B is replaced with C, and so on...
// Finally E is replaced with F, because of left to right replacements.
$search  = array('A', 'B', 'C', 'D', 'E');
$replace = array('B', 'C', 'D', 'E', 'F');
$subject = 'A';
echo str_replace($search, $replace, $subject)."\n";

// Outputs: apearpearle pear
// For the same reason mentioned above
$letters = array('a', 'p');
$fruit   = array('apple', 'pear');
$text    = 'a p';
$output  = str_replace($letters, $fruit, $text);
echo $output."\n";

//taint replacing
$bodytag = str_replace("%body%", $argv[1], "<body & text='%body%'> and % more %body% everywhere ");
echo $bodytag."\n";

?>