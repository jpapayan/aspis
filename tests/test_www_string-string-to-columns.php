<?php

/*------------------------------------------------------------------------------
|
|                             PHParadise source code
|
|-------------------------------------------------------------------------------
|
| file:             string to columns
| category:         string handling
|
| last modified:    Fri, 01 Jul 2005 23:38:18 GMT
| downloaded:       Mon, 20 Sep 2010 13:00:43 GMT as PHP file
|
| code URL:
| http://phparadise.de/php-code/string-handling/string-to-columns/
|
| description:
| this will "columnize" your long text. long text, especially on large screens is
| really hard to read. thats why in the "real world" newspapers use columns to
| layout text. with this script you just paste the text and specify the numbers of
| columns. it will split the text into more reader-friendly chunks.
|
------------------------------------------------------------------------------*/

$_POST['string']="fgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg fgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg asfga sgasfg asf asfasfg asfg asfgasfgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg asfga sgasfg asf asfasfg asfg asfgasfgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg asfga sgasfg asf asfasfg asfg asfgasfgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg asfga sgasfg asf asfasfg asfg asfgasfgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg asfga sgasfg asf asfasfg asfg asfgasfgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg asfga sgasfg asf asfasfg asfg asfgasfgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg asfga sgasfg asf asfasfg asfg asfgasfgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg asfga sgasfg asf asfasfg asfg asfgasfgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg asfga sgasfg asf asfasfg asfg asfgasfgasdfgas dfg adfg afg afg asfg asfg asfg afga sfgas gas gasfg afg asfga sgasfg asf asfasfg asfg asfgasasfga sgasfg asf asfasfg asfg asfgas";

$marginpercent = 3;
$topmarginpx = 200;
$bgcolor = 'whitesmoke';
$paddingpx = 5;
$seperators = array(' ' => 'words', '. ' => 'sentences', '<p>' => 'paragraphs');
if($_POST['string'])
{
    if($_POST['column']) $columns = $_POST['column'];
    else $columns = 3;
    if($_POST['seperator']) $seperator = $_POST['seperator'];
    else $seperator = ' ';
    $widthpercent = ceil(((100-(2*$marginpercent))/$columns)-2);
    $stringlen = strlen($_POST['string']);
    $percolumn = ceil($stringlen/$columns);
    for($x = 0; $x < $columns; $x++)
    {
        $leftpx = (($x*ceil((100-(2*$marginpercent))/$columns))+$marginpercent);
        $string = stripcslashes(substr($_POST['string'],($percolumn*$x),$percolumn));
        $nextstring = stripcslashes(substr($_POST['string'],($percolumn*($x+1)),$percolumn));
        $nextpos = strpos(strtolower($nextstring),strtolower($seperator));
        $nextword = substr($nextstring,0,($nextpos+strlen($seperator)));
        $string = substr($string,$oldpos,$percolumn);
        $string = $string.$nextword;
        $oldpos = $nextpos+strlen($seperator);
        echo '
    <div style="position:absolute; left:'.$leftpx.'%; 
    			top:'.$topmarginpx.'px; padding:'.$paddingpx.'px; 
    			width:'.$widthpercent.'%; background-color:'.$bgcolor.';">
        ';
        if($x > 0 && $_POST['heightpx']) echo '
        <div style="height:'.$_POST['heightpx'].'px; width:'.$widthpercent.'%;">&nbsp;</div>';
        echo $string;
        echo '
    </div>
';
    }
}else{
    echo '
    <div style="position:absolute; left:'.$marginpercent.'%; 
    			top:'.$topmarginpx.'px; padding:'.$paddingpx.'px; 
    			width:'.(100-(2*$marginpercent)).'%; background-color:'.$bgcolor.';">
        <form method="post" action="">
        <textarea name="string" cols="70" rows="20"></textarea><br>
        <input type="text" name="column" value="3" size="3"> columns | text split at 
        <input type="text" name="seperator" size="3">
        <select name="preset" onchange="seperator.value=this.value">';
     foreach($seperators as $k => $v)
    {
        echo '
            <option value="'.$k.'">'.$v.'</option>';
    }        
    echo '
        </select> | 
        <input type="text" name="heightpx" value="" size="3"> topmargin on column 1+ | 
        <input type="submit" value="columnize">
        </form>
    </div>
';
}

?>