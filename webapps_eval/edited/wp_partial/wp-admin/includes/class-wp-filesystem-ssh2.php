<?php require_once('AspisMain.php'); ?><?php
class WP_Filesystem_SSH2 extends WP_Filesystem_Base{var $link = false;
var $sftp_link = false;
var $keys = false;
var $errors = array();
var $options = array();
function WP_Filesystem_SSH2 ( $opt = '' ) {
{$this->method = 'ssh2';
$this->errors = new WP_Error();
if ( !extension_loaded('ssh2'))
 {$this->errors->add('no_ssh2_ext',__('The ssh2 PHP extension is not available'));
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( !function_exists('stream_get_contents'))
 {$this->errors->add('ssh2_php_requirement',__('The ssh2 PHP extension is available, however, we require the PHP5 function <code>stream_get_contents()</code>'));
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( empty($opt['port']))
 $this->options['port'] = 22;
else 
{$this->options['port'] = $opt['port'];
}if ( empty($opt['hostname']))
 $this->errors->add('empty_hostname',__('SSH2 hostname is required'));
else 
{$this->options['hostname'] = $opt['hostname'];
}if ( isset($opt['base']) && !empty($opt['base']))
 $this->wp_base = $opt['base'];
if ( !empty($opt['public_key']) && !empty($opt['private_key']))
 {$this->options['public_key'] = $opt['public_key'];
$this->options['private_key'] = $opt['private_key'];
$this->options['hostkey'] = array('hostkey' => 'ssh-rsa');
$this->keys = true;
}elseif ( empty($opt['username']))
 {$this->errors->add('empty_username',__('SSH2 username is required'));
}if ( !empty($opt['username']))
 $this->options['username'] = $opt['username'];
if ( empty($opt['password']))
 {if ( !$this->keys)
 $this->errors->add('empty_password',__('SSH2 password is required'));
}else 
{{$this->options['password'] = $opt['password'];
}}} }
function connect (  ) {
{if ( !$this->keys)
 {$this->link = @ssh2_connect($this->options['hostname'],$this->options['port']);
}else 
{{$this->link = @ssh2_connect($this->options['hostname'],$this->options['port'],$this->options['hostkey']);
}}if ( !$this->link)
 {$this->errors->add('connect',sprintf(__('Failed to connect to SSH2 Server %1$s:%2$s'),$this->options['hostname'],$this->options['port']));
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( !$this->keys)
 {if ( !@ssh2_auth_password($this->link,$this->options['username'],$this->options['password']))
 {$this->errors->add('auth',sprintf(__('Username/Password incorrect for %s'),$this->options['username']));
{$AspisRetTemp = false;
return $AspisRetTemp;
}}}else 
{{if ( !@ssh2_auth_pubkey_file($this->link,$this->options['username'],$this->options['public_key'],$this->options['private_key'],$this->options['password']))
 {$this->errors->add('auth',sprintf(__('Public and Private keys incorrect for %s'),$this->options['username']));
{$AspisRetTemp = false;
return $AspisRetTemp;
}}}}$this->sftp_link = ssh2_sftp($this->link);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function run_command ( $command,$returnbool = false ) {
{if ( !$this->link)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !($stream = ssh2_exec($this->link,$command)))
 {$this->errors->add('command',sprintf(__('Unable to perform command: %s'),$command));
}else 
{{stream_set_blocking($stream,true);
stream_set_timeout($stream,FS_TIMEOUT);
$data = stream_get_contents($stream);
fclose($stream);
if ( $returnbool)
 {$AspisRetTemp = ($data === false) ? false : '' != trim($data);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = $data;
return $AspisRetTemp;
}}}}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function get_contents ( $file,$type = '',$resumepos = 0 ) {
{$file = ltrim($file,'/');
{$AspisRetTemp = file_get_contents('ssh2.sftp://' . $this->sftp_link . '/' . $file);
return $AspisRetTemp;
}} }
function get_contents_array ( $file ) {
{$file = ltrim($file,'/');
{$AspisRetTemp = file('ssh2.sftp://' . $this->sftp_link . '/' . $file);
return $AspisRetTemp;
}} }
function put_contents ( $file,$contents,$type = '' ) {
{$file = ltrim($file,'/');
{$AspisRetTemp = false !== file_put_contents('ssh2.sftp://' . $this->sftp_link . '/' . $file,$contents);
return $AspisRetTemp;
}} }
function cwd (  ) {
{$cwd = $this->run_command('pwd');
if ( $cwd)
 $cwd = trailingslashit($cwd);
{$AspisRetTemp = $cwd;
return $AspisRetTemp;
}} }
function chdir ( $dir ) {
{{$AspisRetTemp = $this->run_command('cd ' . $dir,true);
return $AspisRetTemp;
}} }
function chgrp ( $file,$group,$recursive = false ) {
{if ( !$this->exists($file))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$recursive || !$this->is_dir($file))
 {$AspisRetTemp = $this->run_command(sprintf('chgrp %o %s',$mode,escapeshellarg($file)),true);
return $AspisRetTemp;
}{$AspisRetTemp = $this->run_command(sprintf('chgrp -R %o %s',$mode,escapeshellarg($file)),true);
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
}}}if ( !$recursive || !$this->is_dir($file))
 {$AspisRetTemp = $this->run_command(sprintf('chmod %o %s',$mode,escapeshellarg($file)),true);
return $AspisRetTemp;
}{$AspisRetTemp = $this->run_command(sprintf('chmod -R %o %s',$mode,escapeshellarg($file)),true);
return $AspisRetTemp;
}} }
function chown ( $file,$owner,$recursive = false ) {
{if ( !$this->exists($file))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$recursive || !$this->is_dir($file))
 {$AspisRetTemp = $this->run_command(sprintf('chown %o %s',$mode,escapeshellarg($file)),true);
return $AspisRetTemp;
}{$AspisRetTemp = $this->run_command(sprintf('chown -R %o %s',$mode,escapeshellarg($file)),true);
return $AspisRetTemp;
}} }
function owner ( $file ) {
{$owneruid = @fileowner('ssh2.sftp://' . $this->sftp_link . '/' . ltrim($file,'/'));
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
{{$AspisRetTemp = substr(decoct(@fileperms('ssh2.sftp://' . $this->sftp_link . '/' . ltrim($file,'/'))),3);
return $AspisRetTemp;
}} }
function group ( $file ) {
{$gid = @filegroup('ssh2.sftp://' . $this->sftp_link . '/' . ltrim($file,'/'));
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
}$content = $this->get_contents($source);
if ( false === $content)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $this->put_contents($destination,$content);
return $AspisRetTemp;
}} }
function move ( $source,$destination,$overwrite = false ) {
{{$AspisRetTemp = @ssh2_sftp_rename($this->link,$source,$destination);
return $AspisRetTemp;
}} }
function delete ( $file,$recursive = false ) {
{if ( $this->is_file($file))
 {$AspisRetTemp = ssh2_sftp_unlink($this->sftp_link,$file);
return $AspisRetTemp;
}if ( !$recursive)
 {$AspisRetTemp = ssh2_sftp_rmdir($this->sftp_link,$file);
return $AspisRetTemp;
}$filelist = $this->dirlist($file);
if ( is_array($filelist))
 {foreach ( $filelist as $filename =>$fileinfo )
{$this->delete($file . '/' . $filename,$recursive);
}}{$AspisRetTemp = ssh2_sftp_rmdir($this->sftp_link,$file);
return $AspisRetTemp;
}} }
function exists ( $file ) {
{$file = ltrim($file,'/');
{$AspisRetTemp = file_exists('ssh2.sftp://' . $this->sftp_link . '/' . $file);
return $AspisRetTemp;
}} }
function is_file ( $file ) {
{$file = ltrim($file,'/');
{$AspisRetTemp = is_file('ssh2.sftp://' . $this->sftp_link . '/' . $file);
return $AspisRetTemp;
}} }
function is_dir ( $path ) {
{$path = ltrim($path,'/');
{$AspisRetTemp = is_dir('ssh2.sftp://' . $this->sftp_link . '/' . $path);
return $AspisRetTemp;
}} }
function is_readable ( $file ) {
{$file = ltrim($file,'/');
{$AspisRetTemp = is_readable('ssh2.sftp://' . $this->sftp_link . '/' . $file);
return $AspisRetTemp;
}} }
function is_writable ( $file ) {
{$file = ltrim($file,'/');
{$AspisRetTemp = is_writable('ssh2.sftp://' . $this->sftp_link . '/' . $file);
return $AspisRetTemp;
}} }
function atime ( $file ) {
{$file = ltrim($file,'/');
{$AspisRetTemp = fileatime('ssh2.sftp://' . $this->sftp_link . '/' . $file);
return $AspisRetTemp;
}} }
function mtime ( $file ) {
{$file = ltrim($file,'/');
{$AspisRetTemp = filemtime('ssh2.sftp://' . $this->sftp_link . '/' . $file);
return $AspisRetTemp;
}} }
function size ( $file ) {
{$file = ltrim($file,'/');
{$AspisRetTemp = filesize('ssh2.sftp://' . $this->sftp_link . '/' . $file);
return $AspisRetTemp;
}} }
function touch ( $file,$time = 0,$atime = 0 ) {
{} }
function mkdir ( $path,$chmod = false,$chown = false,$chgrp = false ) {
{$path = untrailingslashit($path);
if ( !$chmod)
 $chmod = FS_CHMOD_DIR;
if ( !ssh2_sftp_mkdir($this->sftp_link,$path,$chmod,true))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( $chown)
 $this->chown($path,$chown);
if ( $chgrp)
 $this->chgrp($path,$chgrp);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function rmdir ( $path,$recursive = false ) {
{{$AspisRetTemp = $this->delete($path,$recursive);
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
}$ret = array();
$dir = @dir('ssh2.sftp://' . $this->sftp_link . '/' . ltrim($path,'/'));
if ( !$dir)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}while ( false !== ($entry = $dir->read()) )
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
}