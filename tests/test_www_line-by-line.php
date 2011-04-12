<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             line by line
| category:         file handling
|
| last modified:    Mon, 20 Jun 2005 16:40:38 GMT
| downloaded:       Fri, 17 Sep 2010 13:17:21 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/file-handling/line-by-line/
|
| description:
| a rather lenghty solution for reading a file into an array
|
------------------------------------------------------------------------------*/


  
$file=fopen('/home/papajohn/public_html/phpparser/dummy.txt','r');
?>
  
but well, here you go ...

<?php
 
// GetLine
// Obtain the next line in a given file by reading each character until a \r or \n is reached.
 
// @param    file    a handle returned from fopen for our file.
// @return    string    the next line in the file.
 
function getLine($file)
{

   // iterate over each character in line.
   while (!feof($file))
   {

       // append the character to the buffer.
       $character = fgetc($file);
       $buffer .= $character;

       // check for end of line.
       if (($character == "\n") or ($character == "\r"))
       {

           // checks if the next character is part of the line ending, as in
           // the case of windows '\r\n' files, or not as in the case of
           // mac classic '\r', and unix/os x '\n' files.
           $character = fgetc($file);
           if ($character == "\n")
           {

               // part of line ending, append to buffer.
               $buffer .= $character;

           } else {

               // not part of line ending, roll back file pointer.
               fseek($file, -1, SEEK_CUR);
           }

           // end of line, so stop reading.
           break;
       }
   }
   // return the line buffer.
   return $buffer;
}

echo getLine($file)."\n";
echo getLine($file)."\n";
fclose($file);

?>
