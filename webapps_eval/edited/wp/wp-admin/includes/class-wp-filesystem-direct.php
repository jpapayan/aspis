<?php require_once('AspisMain.php'); ?><?php
class WP_Filesystem_Direct extends WP_Filesystem_Base{var $errors = array(null,false);
function WP_Filesystem_Direct ( $arg ) {
{$this->method = array('direct',false);
$this->errors = array(new WP_Error(),false);
} }
function connect (  ) {
{return array(true,false);
} }
function get_contents ( $file ) {
{return @attAspis(file_get_contents($file[0]));
} }
function get_contents_array ( $file ) {
{return @Aspis_file($file);
} }
function put_contents ( $file,$contents,$mode = array(false,false),$type = array('',false) ) {
{if ( (denot_boolean(($fp = @attAspis(fopen($file[0],(deconcat1('w',$type))))))))
 return array(false,false);
@attAspis(fwrite($fp[0],$contents[0]));
@attAspis(fclose($fp[0]));
$this->chmod($file,$mode);
return array(true,false);
} }
function cwd (  ) {
{return @attAspis(getcwd());
} }
function chdir ( $dir ) {
{return @attAspis(chdir($dir[0]));
} }
function chgrp ( $file,$group,$recursive = array(false,false) ) {
{if ( (denot_boolean($this->exists($file))))
 return array(false,false);
if ( (denot_boolean($recursive)))
 return @attAspis(chgrp($file[0],deAspisRC($group)));
if ( (denot_boolean($this->is_dir($file))))
 return @attAspis(chgrp($file[0],deAspisRC($group)));
$file = trailingslashit($file);
$filelist = $this->dirlist($file);
foreach ( $filelist[0] as $filename  )
$this->chgrp(concat($file,$filename),$group,$recursive);
return array(true,false);
} }
function chmod ( $file,$mode = array(false,false),$recursive = array(false,false) ) {
{if ( (denot_boolean($this->exists($file))))
 return array(false,false);
if ( (denot_boolean($mode)))
 {if ( deAspis($this->is_file($file)))
 $mode = array(FS_CHMOD_FILE,false);
elseif ( deAspis($this->is_dir($file)))
 $mode = array(FS_CHMOD_DIR,false);
else 
{return array(false,false);
}}if ( (denot_boolean($recursive)))
 return @attAspis(chmod($file[0],$mode[0]));
if ( (denot_boolean($this->is_dir($file))))
 return @attAspis(chmod($file[0],$mode[0]));
$file = trailingslashit($file);
$filelist = $this->dirlist($file);
foreach ( $filelist[0] as $filename  )
$this->chmod(concat($file,$filename),$mode,$recursive);
return array(true,false);
} }
function chown ( $file,$owner,$recursive = array(false,false) ) {
{if ( (denot_boolean($this->exists($file))))
 return array(false,false);
if ( (denot_boolean($recursive)))
 return @attAspis(chown($file[0],deAspisRC($owner)));
if ( (denot_boolean($this->is_dir($file))))
 return @attAspis(chown($file[0],deAspisRC($owner)));
$filelist = $this->dirlist($file);
foreach ( $filelist[0] as $filename  )
{$this->chown(concat(concat2($file,'/'),$filename),$owner,$recursive);
}return array(true,false);
} }
function owner ( $file ) {
{$owneruid = @attAspis(fileowner($file[0]));
if ( (denot_boolean($owneruid)))
 return array(false,false);
if ( (!(function_exists(('posix_getpwuid')))))
 return $owneruid;
$ownerarray = attAspisRC(posix_getpwuid($owneruid[0]));
return $ownerarray[0]['name'];
} }
function getchmod ( $file ) {
{return Aspis_substr(Aspis_decoct(@attAspis(fileperms($file[0]))),array(3,false));
} }
function group ( $file ) {
{$gid = @attAspis(filegroup($file[0]));
if ( (denot_boolean($gid)))
 return array(false,false);
if ( (!(function_exists(('posix_getgrgid')))))
 return $gid;
$grouparray = attAspisRC(posix_getgrgid($gid[0]));
return $grouparray[0]['name'];
} }
function copy ( $source,$destination,$overwrite = array(false,false) ) {
{if ( ((denot_boolean($overwrite)) && deAspis($this->exists($destination))))
 return array(false,false);
return attAspis(copy($source[0],$destination[0]));
} }
function move ( $source,$destination,$overwrite = array(false,false) ) {
{if ( (deAspis($this->copy($source,$destination,$overwrite)) && deAspis($this->exists($destination))))
 {$this->delete($source);
return array(true,false);
}else 
{{return array(false,false);
}}} }
function delete ( $file,$recursive = array(false,false) ) {
{if ( ((empty($file) || Aspis_empty( $file))))
 return array(false,false);
$file = Aspis_str_replace(array('\\',false),array('/',false),$file);
if ( deAspis($this->is_file($file)))
 return @attAspis(unlink($file[0]));
if ( ((denot_boolean($recursive)) && deAspis($this->is_dir($file))))
 return @attAspis(rmdir($file[0]));
$file = trailingslashit($file);
$filelist = $this->dirlist($file,array(true,false));
$retval = array(true,false);
if ( is_array($filelist[0]))
 foreach ( $filelist[0] as $filename =>$fileinfo )
{restoreTaint($filename,$fileinfo);
if ( (denot_boolean($this->delete(concat($file,$filename),$recursive))))
 $retval = array(false,false);
}if ( (file_exists($file[0]) && (denot_boolean(@attAspis(rmdir($file[0]))))))
 $retval = array(false,false);
return $retval;
} }
function exists ( $file ) {
{return @attAspis(file_exists($file[0]));
} }
function is_file ( $file ) {
{return @attAspis(is_file($file[0]));
} }
function is_dir ( $path ) {
{return @attAspis(is_dir($path[0]));
} }
function is_readable ( $file ) {
{return @attAspis(is_readable($file[0]));
} }
function is_writable ( $file ) {
{return @attAspis(is_writable($file[0]));
} }
function atime ( $file ) {
{return @attAspis(fileatime($file[0]));
} }
function mtime ( $file ) {
{return @attAspis(filemtime($file[0]));
} }
function size ( $file ) {
{return @attAspis(filesize($file[0]));
} }
function touch ( $file,$time = array(0,false),$atime = array(0,false) ) {
{if ( ($time[0] == (0)))
 $time = attAspis(time());
if ( ($atime[0] == (0)))
 $atime = attAspis(time());
return @attAspis(touch($file[0],$time[0],$atime[0]));
} }
function mkdir ( $path,$chmod = array(false,false),$chown = array(false,false),$chgrp = array(false,false) ) {
{if ( (denot_boolean($chmod)))
 $chmod = array(FS_CHMOD_DIR,false);
if ( (denot_boolean(@attAspis(mkdir($path[0])))))
 return array(false,false);
$this->chmod($path,$chmod);
if ( $chown[0])
 $this->chown($path,$chown);
if ( $chgrp[0])
 $this->chgrp($path,$chgrp);
return array(true,false);
} }
function rmdir ( $path,$recursive = array(false,false) ) {
{if ( (denot_boolean($recursive)))
 return @attAspis(rmdir($path[0]));
$filelist = $this->dirlist($path);
foreach ( $filelist[0] as $filename =>$det )
{restoreTaint($filename,$det);
{if ( (('/') == deAspis(Aspis_substr($filename,negate(array(1,false)),array(1,false)))))
 $this->rmdir(concat(concat2($path,'/'),$filename),$recursive);
@attAspis(rmdir($filename[0]));
}}return @attAspis(rmdir($path[0]));
} }
function dirlist ( $path,$include_hidden = array(true,false),$recursive = array(false,false) ) {
{if ( deAspis($this->is_file($path)))
 {$limit_file = Aspis_basename($path);
$path = Aspis_dirname($path);
}else 
{{$limit_file = array(false,false);
}}if ( (denot_boolean($this->is_dir($path))))
 return array(false,false);
$dir = @array(new AspisObject(dir($path[0])),false);
if ( (denot_boolean($dir)))
 return array(false,false);
$ret = array(array(),false);
while ( (false !== deAspis(($entry = $dir[0]->read()))) )
{$struc = array(array(),false);
arrayAssign($struc[0],deAspis(registerTaint(array('name',false))),addTaint($entry));
if ( ((('.') == deAspis($struc[0]['name'])) || (('..') == deAspis($struc[0]['name']))))
 continue ;
if ( ((denot_boolean($include_hidden)) && (('.') == deAspis(attachAspis($struc[0][('name')],(0))))))
 continue ;
if ( ($limit_file[0] && (deAspis($struc[0]['name']) != $limit_file[0])))
 continue ;
arrayAssign($struc[0],deAspis(registerTaint(array('perms',false))),addTaint($this->gethchmod(concat(concat2($path,'/'),$entry))));
arrayAssign($struc[0],deAspis(registerTaint(array('permsn',false))),addTaint($this->getnumchmodfromh($struc[0]['perms'])));
arrayAssign($struc[0],deAspis(registerTaint(array('number',false))),addTaint(array(false,false)));
arrayAssign($struc[0],deAspis(registerTaint(array('owner',false))),addTaint($this->owner(concat(concat2($path,'/'),$entry))));
arrayAssign($struc[0],deAspis(registerTaint(array('group',false))),addTaint($this->group(concat(concat2($path,'/'),$entry))));
arrayAssign($struc[0],deAspis(registerTaint(array('size',false))),addTaint($this->size(concat(concat2($path,'/'),$entry))));
arrayAssign($struc[0],deAspis(registerTaint(array('lastmodunix',false))),addTaint($this->mtime(concat(concat2($path,'/'),$entry))));
arrayAssign($struc[0],deAspis(registerTaint(array('lastmod',false))),addTaint(attAspis(date(('M j'),deAspis($struc[0]['lastmodunix'])))));
arrayAssign($struc[0],deAspis(registerTaint(array('time',false))),addTaint(attAspis(date(('h:i:s'),deAspis($struc[0]['lastmodunix'])))));
arrayAssign($struc[0],deAspis(registerTaint(array('type',false))),addTaint(deAspis($this->is_dir(concat(concat2($path,'/'),$entry))) ? array('d',false) : array('f',false)));
if ( (('d') == deAspis($struc[0]['type'])))
 {if ( $recursive[0])
 arrayAssign($struc[0],deAspis(registerTaint(array('files',false))),addTaint($this->dirlist(concat(concat2($path,'/'),$struc[0]['name']),$include_hidden,$recursive)));
else 
{arrayAssign($struc[0],deAspis(registerTaint(array('files',false))),addTaint(array(array(),false)));
}}arrayAssign($ret[0],deAspis(registerTaint($struc[0]['name'])),addTaint($struc));
}$dir[0]->close();
unset($dir);
return $ret;
} }
};
?>
<?php 