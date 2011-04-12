<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             directory list with exec
| category:         directories
|
| last modified:    Mon, 20 Jun 2005 16:40:30 GMT
| downloaded:       Fri, 17 Sep 2010 10:45:03 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/directories/directory-list-with-exec/
|
| description:
| using exec() to produce a directory listing. probably the shortest code to
| produce a full file-list without resorting to the servers built in directory
| display
|
------------------------------------------------------------------------------*/



/*

this function takes advantage of the servers operating system an therefore only 
works on a "real server", means *nix based machines

the following options are available 
(i stripped a few which do not make sense for use with PHP):

-A      List all entries except for . and ...  Always set for the super-
        user.

-F      Display a slash (`/') immediately after each pathname that is a
        directory, an asterisk (`*') after each that is executable, an at
        sign (`@') after each symbolic link, an equals sign (`=') after
        each socket, a percent sign (`%') after each whiteout, and a ver-
        tical bar (`|') after each that is a FIFO.

-L      If argument is a symbolic link, list the file or directory the
        link references rather than the link itself.  This option cancels
        the -P option.

-P      If argument is a symbolic link, list the link itself rather than
        the object the link references.  This option cancels the -H and
        -L options.

-R      Recursively list subdirectories encountered.

-S      Sort files by size

-T      When used with the -l (lowercase letter ``ell'') option, display
        complete time information for the file, including month, day,
        hour, minute, second, and year.

-a      Include directory entries whose names begin with a dot (.).

-c      Use time when file status was last changed for sorting or printing.

*/

// we use "." - means the current directory
$directory = '/home/papajohn/public_html/phpparser';

exec('ls -al '.$directory, $directory_list);

/*

when you use the -l flag w/ ls, there will be a string of characters on the left
for each file, which may look something like -rwxr-xr-x 

the first character describes what the item is: 
- = regular file 
d = directory 
b = special block file 
c = special character file 
l = symbolic link 
p = named pipe special file 

example: lrwxr-xr-x would be a symbolic link 

the next 9 characters are 3 groups of 3 characters each, which tell the 
read/write/execute permissions for user, group, and other respectively: 

r = read 
w = write 
x = execute 

using the above example of lrwxr-xr-x, you would have symbolic link file, where 
the user can read, write and execute (rwx), and the group and others 
can read and execute (r-x) 

*/

echo '
<p>content of &quot;'.$directory.'/&quot;</p>
<ul>';
foreach($directory_list as $file)
{
   echo '
   <li>'.$file.'</li>';
}
echo '
</ul>';

?>