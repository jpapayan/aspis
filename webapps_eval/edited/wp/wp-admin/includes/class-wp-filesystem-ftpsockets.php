<?php require_once('AspisMain.php'); ?><?php
class WP_Filesystem_ftpsockets extends WP_Filesystem_Base{var $ftp = array(false,false);
var $errors = array(null,false);
var $options = array(array(),false);
function WP_Filesystem_ftpsockets ( $opt = array('',false) ) {
{$this->method = array('ftpsockets',false);
$this->errors = array(new WP_Error(),false);
if ( (denot_boolean(@include_once (deconcat12(ABSPATH,'wp-admin/includes/class-ftp.php')))))
 return array(false,false);
$this->ftp = array(new ftp(),false);
if ( ((empty($opt[0][('port')]) || Aspis_empty( $opt [0][('port')]))))
 arrayAssign($this->options[0],deAspis(registerTaint(array('port',false))),addTaint(array(21,false)));
else 
{arrayAssign($this->options[0],deAspis(registerTaint(array('port',false))),addTaint($opt[0]['port']));
}if ( ((empty($opt[0][('hostname')]) || Aspis_empty( $opt [0][('hostname')]))))
 $this->errors[0]->add(array('empty_hostname',false),__(array('FTP hostname is required',false)));
else 
{arrayAssign($this->options[0],deAspis(registerTaint(array('hostname',false))),addTaint($opt[0]['hostname']));
}if ( (((isset($opt[0][('base')]) && Aspis_isset( $opt [0][('base')]))) && (!((empty($opt[0][('base')]) || Aspis_empty( $opt [0][('base')]))))))
 $this->wp_base = $opt[0]['base'];
if ( ((empty($opt[0][('username')]) || Aspis_empty( $opt [0][('username')]))))
 $this->errors[0]->add(array('empty_username',false),__(array('FTP username is required',false)));
else 
{arrayAssign($this->options[0],deAspis(registerTaint(array('username',false))),addTaint($opt[0]['username']));
}if ( ((empty($opt[0][('password')]) || Aspis_empty( $opt [0][('password')]))))
 $this->errors[0]->add(array('empty_password',false),__(array('FTP password is required',false)));
else 
{arrayAssign($this->options[0],deAspis(registerTaint(array('password',false))),addTaint($opt[0]['password']));
}} }
function connect (  ) {
{if ( (denot_boolean($this->ftp)))
 return array(false,false);
$this->ftp[0]->setTimeout(array(FS_CONNECT_TIMEOUT,false));
if ( (denot_boolean($this->ftp[0]->SetServer($this->options[0][('hostname')],$this->options[0][('port')]))))
 {$this->errors[0]->add(array('connect',false),Aspis_sprintf(__(array('Failed to connect to FTP Server %1$s:%2$s',false)),$this->options[0][('hostname')],$this->options[0][('port')]));
return array(false,false);
}if ( (denot_boolean($this->ftp[0]->connect())))
 {$this->errors[0]->add(array('connect',false),Aspis_sprintf(__(array('Failed to connect to FTP Server %1$s:%2$s',false)),$this->options[0][('hostname')],$this->options[0][('port')]));
return array(false,false);
}if ( (denot_boolean($this->ftp[0]->login($this->options[0][('username')],$this->options[0][('password')]))))
 {$this->errors[0]->add(array('auth',false),Aspis_sprintf(__(array('Username/Password incorrect for %s',false)),$this->options[0][('username')]));
return array(false,false);
}$this->ftp[0]->SetType(array(FTP_AUTOASCII,false));
$this->ftp[0]->Passive(array(true,false));
$this->ftp[0]->setTimeout(array(FS_TIMEOUT,false));
return array(true,false);
} }
function get_contents ( $file,$type = array('',false),$resumepos = array(0,false) ) {
{if ( (denot_boolean($this->exists($file))))
 return array(false,false);
if ( ((empty($type) || Aspis_empty( $type))))
 $type = array(FTP_AUTOASCII,false);
$this->ftp[0]->SetType($type);
$temp = wp_tempnam($file);
if ( (denot_boolean($temphandle = attAspis(fopen($temp[0],('w+'))))))
 return array(false,false);
if ( (denot_boolean($this->ftp[0]->fget($temphandle,$file))))
 {fclose($temphandle[0]);
unlink($temp[0]);
return array('',false);
}fseek($temphandle[0],(0));
$contents = array('',false);
while ( (!(feof($temphandle[0]))) )
$contents = concat($contents,attAspis(fread($temphandle[0],(8192))));
fclose($temphandle[0]);
unlink($temp[0]);
return $contents;
} }
function get_contents_array ( $file ) {
{return Aspis_explode(array("\n",false),$this->get_contents($file));
} }
function put_contents ( $file,$contents,$type = array('',false) ) {
{if ( ((empty($type) || Aspis_empty( $type))))
 $type = deAspis($this->is_binary($contents)) ? array(FTP_BINARY,false) : array(FTP_ASCII,false);
$this->ftp[0]->SetType($type);
$temp = wp_tempnam($file);
if ( (denot_boolean($temphandle = attAspis(fopen($temp[0],('w+'))))))
 {unlink($temp[0]);
return array(false,false);
}fwrite($temphandle[0],$contents[0]);
fseek($temphandle[0],(0));
$ret = $this->ftp[0]->fput($file,$temphandle);
fclose($temphandle[0]);
unlink($temp[0]);
return $ret;
} }
function cwd (  ) {
{$cwd = $this->ftp[0]->pwd();
if ( $cwd[0])
 $cwd = trailingslashit($cwd);
return $cwd;
} }
function chdir ( $file ) {
{return $this->ftp[0]->chdir($file);
} }
function chgrp ( $file,$group,$recursive = array(false,false) ) {
{return array(false,false);
} }
function chmod ( $file,$mode = array(false,false),$recursive = array(false,false) ) {
{if ( (denot_boolean($mode)))
 {if ( deAspis($this->is_file($file)))
 $mode = array(FS_CHMOD_FILE,false);
elseif ( deAspis($this->is_dir($file)))
 $mode = array(FS_CHMOD_DIR,false);
else 
{return array(false,false);
}}if ( ((denot_boolean($recursive)) || (denot_boolean($this->is_dir($file)))))
 {return $this->ftp[0]->chmod($file,$mode);
}$filelist = $this->dirlist($file);
foreach ( $filelist[0] as $filename  )
$this->chmod(concat(concat2($file,'/'),$filename),$mode,$recursive);
return array(true,false);
} }
function chown ( $file,$owner,$recursive = array(false,false) ) {
{return array(false,false);
} }
function owner ( $file ) {
{$dir = $this->dirlist($file);
return $dir[0][$file[0]][0]['owner'];
} }
function getchmod ( $file ) {
{$dir = $this->dirlist($file);
return $dir[0][$file[0]][0]['permsn'];
} }
function group ( $file ) {
{$dir = $this->dirlist($file);
return $dir[0][$file[0]][0]['group'];
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
{return $this->ftp[0]->rename($source,$destination);
} }
function delete ( $file,$recursive = array(false,false) ) {
{if ( ((empty($file) || Aspis_empty( $file))))
 return array(false,false);
if ( deAspis($this->is_file($file)))
 return $this->ftp[0]->delete($file);
if ( (denot_boolean($recursive)))
 return $this->ftp[0]->rmdir($file);
return $this->ftp[0]->mdel($file);
} }
function exists ( $file ) {
{return $this->ftp[0]->is_exists($file);
} }
function is_file ( $file ) {
{return deAspis($this->is_dir($file)) ? array(false,false) : array(true,false);
} }
function is_dir ( $path ) {
{$cwd = $this->cwd();
if ( deAspis($this->chdir($path)))
 {$this->chdir($cwd);
return array(true,false);
}return array(false,false);
} }
function is_readable ( $file ) {
{return array(true,false);
} }
function is_writable ( $file ) {
{return array(true,false);
} }
function atime ( $file ) {
{return array(false,false);
} }
function mtime ( $file ) {
{return $this->ftp[0]->mdtm($file);
} }
function size ( $file ) {
{return $this->ftp[0]->filesize($file);
} }
function touch ( $file,$time = array(0,false),$atime = array(0,false) ) {
{return array(false,false);
} }
function mkdir ( $path,$chmod = array(false,false),$chown = array(false,false),$chgrp = array(false,false) ) {
{if ( (denot_boolean($this->ftp[0]->mkdir($path))))
 return array(false,false);
if ( (denot_boolean($chmod)))
 $chmod = array(FS_CHMOD_DIR,false);
$this->chmod($path,$chmod);
if ( $chown[0])
 $this->chown($path,$chown);
if ( $chgrp[0])
 $this->chgrp($path,$chgrp);
return array(true,false);
} }
function rmdir ( $path,$recursive = array(false,false) ) {
{if ( (denot_boolean($recursive)))
 return $this->ftp[0]->rmdir($path);
return $this->ftp[0]->mdel($path);
} }
function dirlist ( $path = array('.',false),$include_hidden = array(true,false),$recursive = array(false,false) ) {
{if ( deAspis($this->is_file($path)))
 {$limit_file = Aspis_basename($path);
$path = concat2(Aspis_dirname($path),'/');
}else 
{{$limit_file = array(false,false);
}}$list = $this->ftp[0]->dirlist($path);
if ( (denot_boolean($list)))
 return array(false,false);
$ret = array(array(),false);
foreach ( $list[0] as $struc  )
{if ( ((('.') == deAspis($struc[0]['name'])) || (('..') == deAspis($struc[0]['name']))))
 continue ;
if ( ((denot_boolean($include_hidden)) && (('.') == deAspis(attachAspis($struc[0][('name')],(0))))))
 continue ;
if ( ($limit_file[0] && (deAspis($struc[0]['name']) != $limit_file[0])))
 continue ;
if ( (('d') == deAspis($struc[0]['type'])))
 {if ( $recursive[0])
 arrayAssign($struc[0],deAspis(registerTaint(array('files',false))),addTaint($this->dirlist(concat(concat2($path,'/'),$struc[0]['name']),$include_hidden,$recursive)));
else 
{arrayAssign($struc[0],deAspis(registerTaint(array('files',false))),addTaint(array(array(),false)));
}}arrayAssign($ret[0],deAspis(registerTaint($struc[0]['name'])),addTaint($struc));
}return $ret;
} }
function __destruct (  ) {
{$this->ftp[0]->quit();
} }
};
?>
<?php 