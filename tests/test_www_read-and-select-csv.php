<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             read and select csv
| category:         file handling
|
| last modified:    Mon, 20 Jun 2005 16:40:39 GMT
| downloaded:       Fri, 17 Sep 2010 13:17:53 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/file-handling/read-and-select-csv/
|
| description:
| this functions read csv (comma seperated values) files and return the content as
| an array. the first one returns the whole file, the second acts like a select
| statement perfect for file-based databases
|
------------------------------------------------------------------------------*/



// reads a csv file and returns a two-dimensional array of lines/fields
function read_csv($file,$delimiter)
{
 $data_array = file($file);
 for ( $i = 0; $i < count($data_array); $i++ )
 {
  $parts_array[$i] = explode($delimiter,$data_array[$i]);
 }
 return $parts_array;
}

// reads a csv file and returns an two-dimensional array of lines/fields
function select_csv($file,$delimiter,$field,$query)
{
 $data_array = file($file);
 for ( $i = 0; $i < count($data_array); $i++ )
 {
  $parts_array[$i] = explode($delimiter,$data_array[$i]);
  if(trim(strtolower($parts_array[$i][$field])) == trim(strtolower($query)))
  {
   $result_array[] = $parts_array[$i];
  }
 }
 return $result_array;
}


// ------------------- demonstration below --------------------


// this willl display all records in the csv file
$data = read_csv('/home/papajohn/public_html/phpparser/dummy.txt','|');
for ( $i = 0; $i < count($data); $i++ )
{
 for ( $u = 0; $u < count($data[$i]); $u++ )
 {
  echo $data[$i][$u].' ';
  if($data[$i][$u] == end($data[$i]))
  {
   echo '<br>';  
  }
 }
}


echo '<p>';  


// this willl display all records where the value
// of the selected field matches the query
$data = select_csv('/home/papajohn/public_html/phpparser/dummy.txt','|','1','1069167712');
for ( $i = 0; $i < count($data); $i++ )
{
 for ( $u = 0; $u < count($data[$i]); $u++ )
 {
  echo $data[$i][$u].' ';
 }
 echo '<br>';  
}


?>
