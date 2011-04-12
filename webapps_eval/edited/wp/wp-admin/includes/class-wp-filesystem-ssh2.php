<?php require_once('AspisMain.php'); ?><?php
class WP_Filesystem_SSH2 extends WP_Filesystem_Base{var $link = array(false,false);
var $sftp_link = array(false,false);
var $keys = array(false,false);
var $errors = array(array(),false);
var $options = array(array(),false);
function WP_Filesystem_SSH2 ( $opt = array('',false) ) {
{$this->method = array('ssh2',false);
$this->errors = array(new WP_Error(),false);
if ( (!(extension_loaded('ssh2'))))
 {$this->errors[0]->add(array('no_ssh2_ext',false),__(array('The ssh2 PHP extension is not available',false)));
return array(false,false);
}if ( (!(function_exists(('stream_get_contents')))))
 {$this->errors[0]->add(array('ssh2_php_requirement',false),__(array('The ssh2 PHP extension is available, however, we require the PHP5 function <code>stream_get_contents()</code>',false)));
return array(false,false);
}if ( ((empty($opt[0][('port')]) || Aspis_empty( $opt [0][('port')]))))
 arrayAssign($this->options[0],deAspis(registerTaint(array('port',false))),addTaint(array(22,false)));
else 
{arrayAssign($this->options[0],deAspis(registerTaint(array('port',false))),addTaint($opt[0]['port']));
}if ( ((empty($opt[0][('hostname')]) || Aspis_empty( $opt [0][('hostname')]))))
 $this->errors[0]->add(array('empty_hostname',false),__(array('SSH2 hostname is required',false)));
else 
{arrayAssign($this->options[0],deAspis(registerTaint(array('hostname',false))),addTaint($opt[0]['hostname']));
}if ( (((isset($opt[0][('base')]) && Aspis_isset( $opt [0][('base')]))) && (!((empty($opt[0][('base')]) || Aspis_empty( $opt [0][('base')]))))))
 $this->wp_base = $opt[0]['base'];
if ( ((!((empty($opt[0][('public_key')]) || Aspis_empty( $opt [0][('public_key')])))) && (!((empty($opt[0][('private_key')]) || Aspis_empty( $opt [0][('private_key')]))))))
 {arrayAssign($this->options[0],deAspis(registerTaint(array('public_key',false))),addTaint($opt[0]['public_key']));
arrayAssign($this->options[0],deAspis(registerTaint(array('private_key',false))),addTaint($opt[0]['private_key']));
arrayAssign($this->options[0],deAspis(registerTaint(array('hostkey',false))),addTaint(array(array('hostkey' => array('ssh-rsa',false,false)),false)));
$this->keys = array(true,false);
}elseif ( ((empty($opt[0][('username')]) || Aspis_empty( $opt [0][('username')]))))
 {$this->errors[0]->add(array('empty_username',false),__(array('SSH2 username is required',false)));
}if ( (!((empty($opt[0][('username')]) || Aspis_empty( $opt [0][('username')])))))
 arrayAssign($this->options[0],deAspis(registerTaint(array('username',false))),addTaint($opt[0]['username']));
if ( ((empty($opt[0][('password')]) || Aspis_empty( $opt [0][('password')]))))
 {if ( (denot_boolean($this->keys)))
 $this->errors[0]->add(array('empty_password',false),__(array('SSH2 password is required',false)));
}else 
{{arrayAssign($this->options[0],deAspis(registerTaint(array('password',false))),addTaint($opt[0]['password']));
}}} }
function connect (  ) {
{if ( (denot_boolean($this->keys)))
 {$this->link = @array(ssh2_connect(deAspisRC($this->options[0][('hostname')]),deAspisRC($this->options[0][('port')])),false);
}else 
{{$this->link = @array(ssh2_connect(deAspisRC($this->options[0][('hostname')]),deAspisRC($this->options[0][('port')]),deAspisRC($this->options[0][('hostkey')])),false);
}}if ( (denot_boolean($this->link)))
 {$this->errors[0]->add(array('connect',false),Aspis_sprintf(__(array('Failed to connect to SSH2 Server %1$s:%2$s',false)),$this->options[0][('hostname')],$this->options[0][('port')]));
return array(false,false);
}if ( (denot_boolean($this->keys)))
 {if ( (denot_boolean(@array(ssh2_auth_password(deAspisRC($this->link),deAspisRC($this->options[0][('username')]),deAspisRC($this->options[0][('password')])),false))))
 {$this->errors[0]->add(array('auth',false),Aspis_sprintf(__(array('Username/Password incorrect for %s',false)),$this->options[0][('username')]));
return array(false,false);
}}else 
{{if ( (denot_boolean(@array(ssh2_auth_pubkey_file(deAspisRC($this->link),deAspisRC($this->options[0][('username')]),deAspisRC($this->options[0][('public_key')]),deAspisRC($this->options[0][('private_key')]),deAspisRC($this->options[0][('password')])),false))))
 {$this->errors[0]->add(array('auth',false),Aspis_sprintf(__(array('Public and Private keys incorrect for %s',false)),$this->options[0][('username')]));
return array(false,false);
}}}$this->sftp_link = array(ssh2_sftp(deAspisRC($this->link)),false);
return array(true,false);
} }
function run_command ( $command,$returnbool = array(false,false) ) {
{if ( (denot_boolean($this->link)))
 return array(false,false);
if ( (denot_boolean(($stream = array(ssh2_exec(deAspisRC($this->link),deAspisRC($command)),false)))))
 {$this->errors[0]->add(array('command',false),Aspis_sprintf(__(array('Unable to perform command: %s',false)),$command));
}else 
{{stream_set_blocking(deAspisRC($stream),true);
stream_set_timeout(deAspisRC($stream),FS_TIMEOUT);
$data = array(stream_get_contents(deAspisRC($stream)),false);
fclose($stream[0]);
if ( $returnbool[0])
 return ($data[0] === false) ? array(false,false) : array(('') != deAspis(Aspis_trim($data)),false);
else 
{return $data;
}}}return array(false,false);
} }
function get_contents ( $file,$type = array('',false),$resumepos = array(0,false) ) {
{$file = Aspis_ltrim($file,array('/',false));
return attAspis(file_get_contents((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$file))));
} }
function get_contents_array ( $file ) {
{$file = Aspis_ltrim($file,array('/',false));
return Aspis_file(concat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$file));
} }
function put_contents ( $file,$contents,$type = array('',false) ) {
{$file = Aspis_ltrim($file,array('/',false));
return array(false !== (file_put_contents((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$file)),deAspisRC($contents))),false);
} }
function cwd (  ) {
{$cwd = $this->run_command(array('pwd',false));
if ( $cwd[0])
 $cwd = trailingslashit($cwd);
return $cwd;
} }
function chdir ( $dir ) {
{return $this->run_command(concat1('cd ',$dir),array(true,false));
} }
function chgrp ( $file,$group,$recursive = array(false,false) ) {
{if ( (denot_boolean($this->exists($file))))
 return array(false,false);
if ( ((denot_boolean($recursive)) || (denot_boolean($this->is_dir($file)))))
 return $this->run_command(Aspis_sprintf(array('chgrp %o %s',false),$mode,Aspis_escapeshellarg($file)),array(true,false));
return $this->run_command(Aspis_sprintf(array('chgrp -R %o %s',false),$mode,Aspis_escapeshellarg($file)),array(true,false));
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
}}if ( ((denot_boolean($recursive)) || (denot_boolean($this->is_dir($file)))))
 return $this->run_command(Aspis_sprintf(array('chmod %o %s',false),$mode,Aspis_escapeshellarg($file)),array(true,false));
return $this->run_command(Aspis_sprintf(array('chmod -R %o %s',false),$mode,Aspis_escapeshellarg($file)),array(true,false));
} }
function chown ( $file,$owner,$recursive = array(false,false) ) {
{if ( (denot_boolean($this->exists($file))))
 return array(false,false);
if ( ((denot_boolean($recursive)) || (denot_boolean($this->is_dir($file)))))
 return $this->run_command(Aspis_sprintf(array('chown %o %s',false),$mode,Aspis_escapeshellarg($file)),array(true,false));
return $this->run_command(Aspis_sprintf(array('chown -R %o %s',false),$mode,Aspis_escapeshellarg($file)),array(true,false));
} }
function owner ( $file ) {
{$owneruid = @attAspis(fileowner((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),Aspis_ltrim($file,array('/',false))))));
if ( (denot_boolean($owneruid)))
 return array(false,false);
if ( (!(function_exists(('posix_getpwuid')))))
 return $owneruid;
$ownerarray = attAspisRC(posix_getpwuid($owneruid[0]));
return $ownerarray[0]['name'];
} }
function getchmod ( $file ) {
{return Aspis_substr(Aspis_decoct(@attAspis(fileperms((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),Aspis_ltrim($file,array('/',false))))))),array(3,false));
} }
function group ( $file ) {
{$gid = @attAspis(filegroup((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),Aspis_ltrim($file,array('/',false))))));
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
$content = $this->get_contents($source);
if ( (false === $content[0]))
 return array(false,false);
return $this->put_contents($destination,$content);
} }
function move ( $source,$destination,$overwrite = array(false,false) ) {
{return @array(ssh2_sftp_rename(deAspisRC($this->link),deAspisRC($source),deAspisRC($destination)),false);
} }
function delete ( $file,$recursive = array(false,false) ) {
{if ( deAspis($this->is_file($file)))
 return array(ssh2_sftp_unlink(deAspisRC($this->sftp_link),deAspisRC($file)),false);
if ( (denot_boolean($recursive)))
 return array(ssh2_sftp_rmdir(deAspisRC($this->sftp_link),deAspisRC($file)),false);
$filelist = $this->dirlist($file);
if ( is_array($filelist[0]))
 {foreach ( $filelist[0] as $filename =>$fileinfo )
{restoreTaint($filename,$fileinfo);
{$this->delete(concat(concat2($file,'/'),$filename),$recursive);
}}}return array(ssh2_sftp_rmdir(deAspisRC($this->sftp_link),deAspisRC($file)),false);
} }
function exists ( $file ) {
{$file = Aspis_ltrim($file,array('/',false));
return attAspis(file_exists((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$file))));
} }
function is_file ( $file ) {
{$file = Aspis_ltrim($file,array('/',false));
return attAspis(is_file((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$file))));
} }
function is_dir ( $path ) {
{$path = Aspis_ltrim($path,array('/',false));
return attAspis(is_dir((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$path))));
} }
function is_readable ( $file ) {
{$file = Aspis_ltrim($file,array('/',false));
return attAspis(is_readable((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$file))));
} }
function is_writable ( $file ) {
{$file = Aspis_ltrim($file,array('/',false));
return attAspis(is_writable((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$file))));
} }
function atime ( $file ) {
{$file = Aspis_ltrim($file,array('/',false));
return attAspis(fileatime((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$file))));
} }
function mtime ( $file ) {
{$file = Aspis_ltrim($file,array('/',false));
return attAspis(filemtime((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$file))));
} }
function size ( $file ) {
{$file = Aspis_ltrim($file,array('/',false));
return attAspis(filesize((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),$file))));
} }
function touch ( $file,$time = array(0,false),$atime = array(0,false) ) {
{} }
function mkdir ( $path,$chmod = array(false,false),$chown = array(false,false),$chgrp = array(false,false) ) {
{$path = untrailingslashit($path);
if ( (denot_boolean($chmod)))
 $chmod = array(FS_CHMOD_DIR,false);
if ( (!(ssh2_sftp_mkdir(deAspisRC($this->sftp_link),deAspisRC($path),deAspisRC($chmod),true))))
 return array(false,false);
if ( $chown[0])
 $this->chown($path,$chown);
if ( $chgrp[0])
 $this->chgrp($path,$chgrp);
return array(true,false);
} }
function rmdir ( $path,$recursive = array(false,false) ) {
{return $this->delete($path,$recursive);
} }
function dirlist ( $path,$include_hidden = array(true,false),$recursive = array(false,false) ) {
{if ( deAspis($this->is_file($path)))
 {$limit_file = Aspis_basename($path);
$path = Aspis_dirname($path);
}else 
{{$limit_file = array(false,false);
}}if ( (denot_boolean($this->is_dir($path))))
 return array(false,false);
$ret = array(array(),false);
$dir = @array(new AspisObject(dir((deconcat(concat2(concat1('ssh2.sftp://',$this->sftp_link),'/'),Aspis_ltrim($path,array('/',false)))))),false);
if ( (denot_boolean($dir)))
 return array(false,false);
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
}