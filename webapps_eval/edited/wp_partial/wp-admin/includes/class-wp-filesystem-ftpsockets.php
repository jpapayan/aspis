<?php require_once('AspisMain.php'); ?><?php
class WP_Filesystem_ftpsockets extends WP_Filesystem_Base{var $ftp = false;
var $errors = null;
var $options = array();
function WP_Filesystem_ftpsockets ( $opt = '' ) {
{$this->method = 'ftpsockets';
$this->errors = new WP_Error();
if ( !@include_once ABSPATH . 'wp-admin/includes/class-ftp.php')
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$this->ftp = new ftp();
if ( empty($opt['port']))
 $this->options['port'] = 21;
else 
{$this->options['port'] = $opt['port'];
}if ( empty($opt['hostname']))
 $this->errors->add('empty_hostname',__('FTP hostname is required'));
else 
{$this->options['hostname'] = $opt['hostname'];
}if ( isset($opt['base']) && !empty($opt['base']))
 $this->wp_base = $opt['base'];
if ( empty($opt['username']))
 $this->errors->add('empty_username',__('FTP username is required'));
else 
{$this->options['username'] = $opt['username'];
}if ( empty($opt['password']))
 $this->errors->add('empty_password',__('FTP password is required'));
else 
{$this->options['password'] = $opt['password'];
}} }
function connect (  ) {
{if ( !$this->ftp)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$this->ftp->setTimeout(FS_CONNECT_TIMEOUT);
if ( !$this->ftp->SetServer($this->options['hostname'],$this->options['port']))
 {$this->errors->add('connect',sprintf(__('Failed to connect to FTP Server %1$s:%2$s'),$this->options['hostname'],$this->options['port']));
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( !$this->ftp->connect())
 {$this->errors->add('connect',sprintf(__('Failed to connect to FTP Server %1$s:%2$s'),$this->options['hostname'],$this->options['port']));
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( !$this->ftp->login($this->options['username'],$this->options['password']))
 {$this->errors->add('auth',sprintf(__('Username/Password incorrect for %s'),$this->options['username']));
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->ftp->SetType(FTP_AUTOASCII);
$this->ftp->Passive(true);
$this->ftp->setTimeout(FS_TIMEOUT);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function get_contents ( $file,$type = '',$resumepos = 0 ) {
{if ( !$this->exists($file))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( empty($type))
 $type = FTP_AUTOASCII;
$this->ftp->SetType($type);
$temp = wp_tempnam($file);
if ( !$temphandle = fopen($temp,'w+'))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$this->ftp->fget($temphandle,$file))
 {fclose($temphandle);
unlink($temp);
{$AspisRetTemp = '';
return $AspisRetTemp;
}}fseek($temphandle,0);
$contents = '';
while ( !feof($temphandle) )
$contents .= fread($temphandle,8192);
fclose($temphandle);
unlink($temp);
{$AspisRetTemp = $contents;
return $AspisRetTemp;
}} }
function get_contents_array ( $file ) {
{{$AspisRetTemp = explode("\n",$this->get_contents($file));
return $AspisRetTemp;
}} }
function put_contents ( $file,$contents,$type = '' ) {
{if ( empty($type))
 $type = $this->is_binary($contents) ? FTP_BINARY : FTP_ASCII;
$this->ftp->SetType($type);
$temp = wp_tempnam($file);
if ( !$temphandle = fopen($temp,'w+'))
 {unlink($temp);
{$AspisRetTemp = false;
return $AspisRetTemp;
}}fwrite($temphandle,$contents);
fseek($temphandle,0);
$ret = $this->ftp->fput($file,$temphandle);
fclose($temphandle);
unlink($temp);
{$AspisRetTemp = $ret;
return $AspisRetTemp;
}} }
function cwd (  ) {
{$cwd = $this->ftp->pwd();
if ( $cwd)
 $cwd = trailingslashit($cwd);
{$AspisRetTemp = $cwd;
return $AspisRetTemp;
}} }
function chdir ( $file ) {
{{$AspisRetTemp = $this->ftp->chdir($file);
return $AspisRetTemp;
}} }
function chgrp ( $file,$group,$recursive = false ) {
{{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function chmod ( $file,$mode = false,$recursive = false ) {
{if ( !$mode)
 {if ( $this->is_file($file))
 $mode = FS_CHMOD_FILE;
elseif ( $this->is_dir($file))
 $mode = FS_CHMOD_DIR;
else 
{{$AspisRetTemp = false;
return $AspisRetTemp;
}}}if ( !$recursive || !$this->is_dir($file))
 {{$AspisRetTemp = $this->ftp->chmod($file,$mode);
return $AspisRetTemp;
}}$filelist = $this->dirlist($file);
foreach ( $filelist as $filename  )
$this->chmod($file . '/' . $filename,$mode,$recursive);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function chown ( $file,$owner,$recursive = false ) {
{{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function owner ( $file ) {
{$dir = $this->dirlist($file);
{$AspisRetTemp = $dir[$file]['owner'];
return $AspisRetTemp;
}} }
function getchmod ( $file ) {
{$dir = $this->dirlist($file);
{$AspisRetTemp = $dir[$file]['permsn'];
return $AspisRetTemp;
}} }
function group ( $file ) {
{$dir = $this->dirlist($file);
{$AspisRetTemp = $dir[$file]['group'];
return $AspisRetTemp;
}} }
function copy ( $source,$destination,$overwrite = false ) {
{if ( !$overwrite && $this->exists($destination))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$content = $this->get_contents($source);
if ( false === $content)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $this->put_contents($destination,$content);
return $AspisRetTemp;
}} }
function move ( $source,$destination,$overwrite = false ) {
{{$AspisRetTemp = $this->ftp->rename($source,$destination);
return $AspisRetTemp;
}} }
function delete ( $file,$recursive = false ) {
{if ( empty($file))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( $this->is_file($file))
 {$AspisRetTemp = $this->ftp->delete($file);
return $AspisRetTemp;
}if ( !$recursive)
 {$AspisRetTemp = $this->ftp->rmdir($file);
return $AspisRetTemp;
}{$AspisRetTemp = $this->ftp->mdel($file);
return $AspisRetTemp;
}} }
function exists ( $file ) {
{{$AspisRetTemp = $this->ftp->is_exists($file);
return $AspisRetTemp;
}} }
function is_file ( $file ) {
{{$AspisRetTemp = $this->is_dir($file) ? false : true;
return $AspisRetTemp;
}} }
function is_dir ( $path ) {
{$cwd = $this->cwd();
if ( $this->chdir($path))
 {$this->chdir($cwd);
{$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function is_readable ( $file ) {
{{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function is_writable ( $file ) {
{{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function atime ( $file ) {
{{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function mtime ( $file ) {
{{$AspisRetTemp = $this->ftp->mdtm($file);
return $AspisRetTemp;
}} }
function size ( $file ) {
{{$AspisRetTemp = $this->ftp->filesize($file);
return $AspisRetTemp;
}} }
function touch ( $file,$time = 0,$atime = 0 ) {
{{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function mkdir ( $path,$chmod = false,$chown = false,$chgrp = false ) {
{if ( !$this->ftp->mkdir($path))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$chmod)
 $chmod = FS_CHMOD_DIR;
$this->chmod($path,$chmod);
if ( $chown)
 $this->chown($path,$chown);
if ( $chgrp)
 $this->chgrp($path,$chgrp);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function rmdir ( $path,$recursive = false ) {
{if ( !$recursive)
 {$AspisRetTemp = $this->ftp->rmdir($path);
return $AspisRetTemp;
}{$AspisRetTemp = $this->ftp->mdel($path);
return $AspisRetTemp;
}} }
function dirlist ( $path = '.',$include_hidden = true,$recursive = false ) {
{if ( $this->is_file($path))
 {$limit_file = basename($path);
$path = dirname($path) . '/';
}else 
{{$limit_file = false;
}}$list = $this->ftp->dirlist($path);
if ( !$list)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$ret = array();
foreach ( $list as $struc  )
{if ( '.' == $struc['name'] || '..' == $struc['name'])
 continue ;
if ( !$include_hidden && '.' == $struc['name'][0])
 continue ;
if ( $limit_file && $struc['name'] != $limit_file)
 continue ;
if ( 'd' == $struc['type'])
 {if ( $recursive)
 $struc['files'] = $this->dirlist($path . '/' . $struc['name'],$include_hidden,$recursive);
else 
{$struc['files'] = array();
}}$ret[$struc['name']] = $struc;
}{$AspisRetTemp = $ret;
return $AspisRetTemp;
}} }
function __destruct (  ) {
{$this->ftp->quit();
} }
};
?>
<?php 