<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             string compare
| category:         string handling
|
| last modified:    Mon, 20 Jun 2005 16:41:16 GMT
| downloaded:       Mon, 20 Sep 2010 13:00:22 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/string-handling/string-compare/
|
| description:
| snippet to check username / password against a text file compares fields
| seperated by a pipe "|" to strings sent via POST variables
|
------------------------------------------------------------------------------*/

?>
<?php
  
  // lets say you have a file where there's on each line something like
  // username|password

$_POST['name']="papa";
$_POST['password']="123";
$data = file('/home/papajohn/public_html/phpparser/dummy dir 1/passwords.txt'); // read the file
  
  for($x = 0; $x < count($data); $x++)
  {
      $parts = explode('|',$data[$x]);
      $name_check = strpos($parts[0],$_POST['name']);
      if($name_check !== false) // important are the ===
      {
           $name = 1;
      }else{
           $name = 0;
      }
      echo "1:$name_check";
      $pass_check = strpos($parts[1],$_POST['password']);
      if($pass_check !== false) // important are the ===
      {
           $pass = 1;
      }else{
           $pass = 0;
      }
      echo "2.$pass_check";
      if($name == 1 && $pass == 1)
      {
          echo 'hello '.$_POST['name'];
          // do whatever
      }
      else echo "...who are you btw?";
  }
  
  
?>