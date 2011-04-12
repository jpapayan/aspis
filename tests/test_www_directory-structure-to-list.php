<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             directory structure to list
| category:         directories
|
| last modified:    Mon, 14 Nov 2005 19:33:15 GMT
| downloaded:       Fri, 17 Sep 2010 10:47:34 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/directories/directory-structure-to-list/
|
| description:
| this PHP function displays any given directory structure as recursive list. it
| even outputs nice HTML markup code with indenting.
|
------------------------------------------------------------------------------*/


function entab($num)
{
	return "\n".str_repeat("\t",$num);
}
function directory_to_list($dir,$onlydirs=FALSE,$sub=FALSE)
{
	$levels = explode('/',$dir);
	$subtab = (count($levels) > 2 ? count($levels)-2 : 0);
	$t = count($levels)+($sub !== false ? 1+$subtab : 0);
	$output = entab($t).'<ul>';
	$dirlist = opendir($dir);
	while ($file = readdir ($dirlist))
	{
		if ($file != '.' && $file != '..' && $file != '.DS_Store')
		{
			$newpath = $dir.'/'.$file;
			$level = explode('/',$newpath);
			$tabs = count($level)+($sub !== false ? 1+$subtab : 0);
			$output .= (($onlydirs == TRUE && is_dir($newpath)) || $onlydirs == FALSE ? 
				entab($tabs).'<li><a href="'.$newpath.'">'.$file.'</a>'.(is_dir($newpath) ? 
					directory_to_list($newpath,$onlydirs,TRUE).entab($tabs) : 
					'').'</li>' : 
				'');
		}
	}
	closedir($dirlist); 
	$output .= entab($t).'</ul>';
	if($onlydirs == TRUE)
		$output = preg_replace('/\n([\t]+)<ul>\n([\t]+)<\/ul>\n([\t]+)/','',$output);
	return $output;
}
// demo of directory to list
echo directory_to_list('.',TRUE);
// if you want to list directories only, use
//echo directory_to_list('.',TRUE);
?>