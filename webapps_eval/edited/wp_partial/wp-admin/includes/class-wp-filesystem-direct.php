<?php require_once('AspisMain.php'); ?><?php
class WP_Filesystem_Direct extends WP_Filesystem_Base{var $errors = null;
function WP_Filesystem_Direct ( $arg ) {
{$this->method = 'direct';
$this->errors = new WP_Error();
} }
function connect (  ) {
{{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function get_contents ( $file ) {
{{$AspisRetTemp = @file_get_contents($file);
return $AspisRetTemp;
}} }
function get_contents_array ( $file ) {
{{$AspisRetTemp = @file($file);
return $AspisRetTemp;
}} }
function put_contents ( $file,$contents,$mode = false,$type = '' ) {
{if ( !($fp = @fopen($file,'w' . $type)))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}@fwrite($fp,$contents);
@fclose($fp);
$this->chmod($file,$mode);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function cwd (  ) {
{{$AspisRetTemp = @getcwd();
return $AspisRetTemp;
}} }
function chdir ( $dir ) {
{{$AspisRetTemp = @chdir($dir);
return $AspisRetTemp;
}} }
function chgrp ( $file,$group,$recursive = false ) {
{if ( !$this->exists($file))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$recursive)
 {$AspisRetTemp = @chgrp($file,$group);
return $AspisRetTemp;
}if ( !$this->is_dir($file))
 {$AspisRetTemp = @chgrp($file,$group);
return $AspisRetTemp;
}$file = trailingslashit($file);
$filelist = $this->dirlist($file);
foreach ( $filelist as $filename  )
$this->chgrp($file . $filename,$group,$recursive);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function chmod ( $file,$mode = false,$recursive = false ) {
{if ( !$this->exists($file))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$mode)
 {if ( $this->is_file($file))
 $mode = FS_CHMOD_FILE;
elseif ( $this->is_dir($file))
 $mode = FS_CHMOD_DIR;
else 
{{$AspisRetTemp = false;
return $AspisRetTemp;
}}}if ( !$recursive)
 {$AspisRetTemp = @chmod($file,$mode);
return $AspisRetTemp;
}if ( !$this->is_dir($file))
 {$AspisRetTemp = @chmod($file,$mode);
return $AspisRetTemp;
}$file = trailingslashit($file);
$filelist = $this->dirlist($file);
foreach ( $filelist as $filename  )
$this->chmod($file . $filename,$mode,$recursive);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function chown ( $file,$owner,$recursive = false ) {
{if ( !$this->exists($file))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$recursive)
 {$AspisRetTemp = @chown($file,$owner);
return $AspisRetTemp;
}if ( !$this->is_dir($file))
 {$AspisRetTemp = @chown($file,$owner);
return $AspisRetTemp;
}$filelist = $this->dirlist($file);
foreach ( $filelist as $filename  )
{$this->chown($file . '/' . $filename,$owner,$recursive);
}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function owner ( $file ) {
{$owneruid = @fileowner($file);
if ( !$owneruid)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !function_exists('posix_getpwuid'))
 {$AspisRetTemp = $owneruid;
return $AspisRetTemp;
}$ownerarray = posix_getpwuid($owneruid);
{$AspisRetTemp = $ownerarray['name'];
return $AspisRetTemp;
}} }
function getchmod ( $file ) {
{{$AspisRetTemp = substr(decoct(@fileperms($file)),3);
return $AspisRetTemp;
}} }
function group ( $file ) {
{$gid = @filegroup($file);
if ( !$gid)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !function_exists('posix_getgrgid'))
 {$AspisRetTemp = $gid;
return $AspisRetTemp;
}$grouparray = posix_getgrgid($gid);
{$AspisRetTemp = $grouparray['name'];
return $AspisRetTemp;
}} }
function copy ( $source,$destination,$overwrite = false ) {
{if ( !$overwrite && $this->exists($destination))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = copy($source,$destination);
return $AspisRetTemp;
}} }
function move ( $source,$destination,$overwrite = false ) {
{if ( $this->copy($source,$destination,$overwrite) && $this->exists($destination))
 {$this->delete($source);
{$AspisRetTemp = true;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = false;
return $AspisRetTemp;
}}}} }
function delete ( $file,$recursive = false ) {
{if ( empty($file))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$file = str_replace('\\','/',$file);
if ( $this->is_file($file))
 {$AspisRetTemp = @unlink($file);
return $AspisRetTemp;
}if ( !$recursive && $this->is_dir($file))
 {$AspisRetTemp = @rmdir($file);
return $AspisRetTemp;
}$file = trailingslashit($file);
$filelist = $this->dirlist($file,true);
$retval = true;
if ( is_array($filelist))
 foreach ( $filelist as $filename =>$fileinfo )
if ( !$this->delete($file . $filename,$recursive))
 $retval = false;
if ( file_exists($file) && !@rmdir($file))
 $retval = false;
{$AspisRetTemp = $retval;
return $AspisRetTemp;
}} }
function exists ( $file ) {
{{$AspisRetTemp = @file_exists($file);
return $AspisRetTemp;
}} }
function is_file ( $file ) {
{{$AspisRetTemp = @is_file($file);
return $AspisRetTemp;
}} }
function is_dir ( $path ) {
{{$AspisRetTemp = @is_dir($path);
return $AspisRetTemp;
}} }
function is_readable ( $file ) {
{{$AspisRetTemp = @is_readable($file);
return $AspisRetTemp;
}} }
function is_writable ( $file ) {
{{$AspisRetTemp = @is_writable($file);
return $AspisRetTemp;
}} }
function atime ( $file ) {
{{$AspisRetTemp = @fileatime($file);
return $AspisRetTemp;
}} }
function mtime ( $file ) {
{{$AspisRetTemp = @filemtime($file);
return $AspisRetTemp;
}} }
function size ( $file ) {
{{$AspisRetTemp = @filesize($file);
return $AspisRetTemp;
}} }
function touch ( $file,$time = 0,$atime = 0 ) {
{if ( $time == 0)
 $time = time();
if ( $atime == 0)
 $atime = time();
{$AspisRetTemp = @touch($file,$time,$atime);
return $AspisRetTemp;
}} }
function mkdir ( $path,$chmod = false,$chown = false,$chgrp = false ) {
{if ( !$chmod)
 $chmod = FS_CHMOD_DIR;
if ( !@mkdir($path))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$this->chmod($path,$chmod);
if ( $chown)
 $this->chown($path,$chown);
if ( $chgrp)
 $this->chgrp($path,$chgrp);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function rmdir ( $path,$recursive = false ) {
{if ( !$recursive)
 {$AspisRetTemp = @rmdir($path);
return $AspisRetTemp;
}$filelist = $this->dirlist($path);
foreach ( $filelist as $filename =>$det )
{if ( '/' == substr($filename,-1,1))
 $this->rmdir($path . '/' . $filename,$recursive);
@rmdir($filename);
}{$AspisRetTemp = @rmdir($path);
return $AspisRetTemp;
}} }
function dirlist ( $path,$include_hidden = true,$recursive = false ) {
{if ( $this->is_file($path))
 {$limit_file = basename($path);
$path = dirname($path);
}else 
{{$limit_file = false;
}}if ( !$this->is_dir($path))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$dir = @dir($path);
if ( !$dir)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$ret = array();
while ( false !== ($entry = $dir->read()) )
{$struc = array();
$struc['name'] = $entry;
if ( '.' == $struc['name'] || '..' == $struc['name'])
 continue ;
if ( !$include_hidden && '.' == $struc['name'][0])
 continue ;
if ( $limit_file && $struc['name'] != $limit_file)
 continue ;
$struc['perms'] = $this->gethchmod($path . '/' . $entry);
$struc['permsn'] = $this->getnumchmodfromh($struc['perms']);
$struc['number'] = false;
$struc['owner'] = $this->owner($path . '/' . $entry);
$struc['group'] = $this->group($path . '/' . $entry);
$struc['size'] = $this->size($path . '/' . $entry);
$struc['lastmodunix'] = $this->mtime($path . '/' . $entry);
$struc['lastmod'] = date('M j',$struc['lastmodunix']);
$struc['time'] = date('h:i:s',$struc['lastmodunix']);
$struc['type'] = $this->is_dir($path . '/' . $entry) ? 'd' : 'f';
if ( 'd' == $struc['type'])
 {if ( $recursive)
 $struc['files'] = $this->dirlist($path . '/' . $struc['name'],$include_hidden,$recursive);
else 
{$struc['files'] = array();
}}$ret[$struc['name']] = $struc;
}$dir->close();
unset($dir);
{$AspisRetTemp = $ret;
return $AspisRetTemp;
}} }
};
?>
<?php 