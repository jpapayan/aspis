<?php require_once('AspisMain.php'); ?><?php
class WP_Filesystem_FTPext extends WP_Filesystem_Base{var $link;
var $errors = array(null,false);
var $options = array(array(),false);
function WP_Filesystem_FTPext ( $opt = array('',false) ) {
{$this->method = array('ftpext',false);
$this->errors = array(new WP_Error(),false);
if ( (!(extension_loaded('ftp'))))
 {$this->errors[0]->add(array('no_ftp_ext',false),__(array('The ftp PHP extension is not available',false)));
return array(false,false);
}if ( (!(defined(('FS_TIMEOUT')))))
 define(('FS_TIMEOUT'),240);
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
}arrayAssign($this->options[0],deAspis(registerTaint(array('ssl',false))),addTaint(array(false,false)));
if ( (((isset($opt[0][('connection_type')]) && Aspis_isset( $opt [0][('connection_type')]))) && (('ftps') == deAspis($opt[0]['connection_type']))))
 arrayAssign($this->options[0],deAspis(registerTaint(array('ssl',false))),addTaint(array(true,false)));
} }
function connect (  ) {
{if ( ((((isset($this->options[0][('ssl')]) && Aspis_isset( $this ->options [0][('ssl')] ))) && $this->options[0][('ssl')][0]) && function_exists(('ftp_ssl_connect'))))
 $this->link = @attAspis(ftp_ssl_connect($this->options[0][('hostname')][0],$this->options[0][('port')][0],FS_CONNECT_TIMEOUT));
else 
{$this->link = @attAspis(ftp_connect($this->options[0][('hostname')][0],$this->options[0][('port')][0],FS_CONNECT_TIMEOUT));
}if ( (denot_boolean($this->link)))
 {$this->errors[0]->add(array('connect',false),Aspis_sprintf(__(array('Failed to connect to FTP Server %1$s:%2$s',false)),$this->options[0][('hostname')],$this->options[0][('port')]));
return array(false,false);
}if ( (denot_boolean(@attAspis(ftp_login($this->link[0],$this->options[0][('username')][0],$this->options[0][('password')][0])))))
 {$this->errors[0]->add(array('auth',false),Aspis_sprintf(__(array('Username/Password incorrect for %s',false)),$this->options[0][('username')]));
return array(false,false);
}@attAspis(ftp_pasv($this->link[0],true));
if ( (deAspis(@attAspisRC(ftp_get_option($this->link[0],FTP_TIMEOUT_SEC))) < FS_TIMEOUT))
 @attAspis(ftp_set_option($this->link[0],FTP_TIMEOUT_SEC,FS_TIMEOUT));
return array(true,false);
} }
function get_contents ( $file,$type = array('',false),$resumepos = array(0,false) ) {
{if ( ((empty($type) || Aspis_empty( $type))))
 $type = array(FTP_BINARY,false);
$temp = attAspis(tmpfile());
if ( (denot_boolean($temp)))
 return array(false,false);
if ( (denot_boolean(@attAspis(ftp_fget($this->link[0],$temp[0],$file[0],$type[0],$resumepos[0])))))
 return array(false,false);
fseek($temp[0],(0));
$contents = array('',false);
while ( (!(feof($temp[0]))) )
$contents = concat($contents,attAspis(fread($temp[0],(8192))));
fclose($temp[0]);
return $contents;
} }
function get_contents_array ( $file ) {
{return Aspis_explode(array("\n",false),$this->get_contents($file));
} }
function put_contents ( $file,$contents,$type = array('',false) ) {
{if ( ((empty($type) || Aspis_empty( $type))))
 $type = deAspis($this->is_binary($contents)) ? array(FTP_BINARY,false) : array(FTP_ASCII,false);
$temp = attAspis(tmpfile());
if ( (denot_boolean($temp)))
 return array(false,false);
fwrite($temp[0],$contents[0]);
fseek($temp[0],(0));
$ret = @attAspis(ftp_fput($this->link[0],$file[0],$temp[0],$type[0]));
fclose($temp[0]);
return $ret;
} }
function cwd (  ) {
{$cwd = @attAspis(ftp_pwd($this->link[0]));
if ( $cwd[0])
 $cwd = trailingslashit($cwd);
return $cwd;
} }
function chdir ( $dir ) {
{return @attAspis(ftp_chdir($this->link[0],$dir[0]));
} }
function chgrp ( $file,$group,$recursive = array(false,false) ) {
{return array(false,false);
} }
function chmod ( $file,$mode = array(false,false),$recursive = array(false,false) ) {
{if ( ((denot_boolean($this->exists($file))) && (denot_boolean($this->is_dir($file)))))
 return array(false,false);
if ( (denot_boolean($mode)))
 {if ( deAspis($this->is_file($file)))
 $mode = array(FS_CHMOD_FILE,false);
elseif ( deAspis($this->is_dir($file)))
 $mode = array(FS_CHMOD_DIR,false);
else 
{return array(false,false);
}}if ( ((denot_boolean($recursive)) || (denot_boolean($this->is_dir($file)))))
 {if ( (!(function_exists(('ftp_chmod')))))
 return @attAspis(ftp_site($this->link[0],deAspis(Aspis_sprintf(array('CHMOD %o %s',false),$mode,$file))));
return @array(ftp_chmod(deAspisRC($this->link),deAspisRC($mode),deAspisRC($file)),false);
}$filelist = $this->dirlist($file);
foreach ( $filelist[0] as $filename  )
{$this->chmod(concat(concat2($file,'/'),$filename),$mode,$recursive);
}return array(true,false);
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
{return attAspis(ftp_rename($this->link[0],$source[0],$destination[0]));
} }
function delete ( $file,$recursive = array(false,false) ) {
{if ( ((empty($file) || Aspis_empty( $file))))
 return array(false,false);
if ( deAspis($this->is_file($file)))
 return @attAspis(ftp_delete($this->link[0],$file[0]));
if ( (denot_boolean($recursive)))
 return @attAspis(ftp_rmdir($this->link[0],$file[0]));
$filelist = $this->dirlist(trailingslashit($file));
if ( (!((empty($filelist) || Aspis_empty( $filelist)))))
 foreach ( $filelist[0] as $delete_file  )
$this->delete(concat(trailingslashit($file),$delete_file[0]['name']),$recursive);
return @attAspis(ftp_rmdir($this->link[0],$file[0]));
} }
function exists ( $file ) {
{$list = @attAspisRC(ftp_nlist($this->link[0],$file[0]));
return not_boolean(array((empty($list) || Aspis_empty( $list)),false));
} }
function is_file ( $file ) {
{return array(deAspis($this->exists($file)) && (denot_boolean($this->is_dir($file))),false);
} }
function is_dir ( $path ) {
{$cwd = $this->cwd();
$result = @attAspis(ftp_chdir($this->link[0],deAspis(trailingslashit($path))));
if ( (($result[0] && ($path[0] == deAspis($this->cwd()))) || (deAspis($this->cwd()) != $cwd[0])))
 {@attAspis(ftp_chdir($this->link[0],$cwd[0]));
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
{return attAspis(ftp_mdtm($this->link[0],$file[0]));
} }
function size ( $file ) {
{return attAspis(ftp_size($this->link[0],$file[0]));
} }
function touch ( $file,$time = array(0,false),$atime = array(0,false) ) {
{return array(false,false);
} }
function mkdir ( $path,$chmod = array(false,false),$chown = array(false,false),$chgrp = array(false,false) ) {
{if ( (!(ftp_mkdir($this->link[0],$path[0]))))
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
{return $this->delete($path,$recursive);
} }
function parselisting ( $line ) {
{static $is_windows;
if ( is_null(deAspisRC($is_windows)))
 $is_windows = array(strpos(deAspis(Aspis_strtolower(attAspis(ftp_systype($this->link[0])))),'win') !== false,false);
if ( ($is_windows[0] && deAspis(Aspis_preg_match(array("/([0-9]{2})-([0-9]{2})-([0-9]{2}) +([0-9]{2}):([0-9]{2})(AM|PM) +([0-9]+|<DIR>) +(.+)/",false),$line,$lucifer))))
 {$b = array(array(),false);
if ( (deAspis(attachAspis($lucifer,(3))) < (70)))
 {arrayAssign($lucifer[0],deAspis(registerTaint(array(3,false))),addTaint(array((2000) + deAspis(attachAspis($lucifer,(3))),false)));
}else 
{{arrayAssign($lucifer[0],deAspis(registerTaint(array(3,false))),addTaint(array((1900) + deAspis(attachAspis($lucifer,(3))),false)));
}}arrayAssign($b[0],deAspis(registerTaint(array('isdir',false))),addTaint((array(deAspis(attachAspis($lucifer,(7))) == ("<DIR>"),false))));
if ( deAspis($b[0]['isdir']))
 arrayAssign($b[0],deAspis(registerTaint(array('type',false))),addTaint(array('d',false)));
else 
{arrayAssign($b[0],deAspis(registerTaint(array('type',false))),addTaint(array('f',false)));
}arrayAssign($b[0],deAspis(registerTaint(array('size',false))),addTaint(attachAspis($lucifer,(7))));
arrayAssign($b[0],deAspis(registerTaint(array('month',false))),addTaint(attachAspis($lucifer,(1))));
arrayAssign($b[0],deAspis(registerTaint(array('day',false))),addTaint(attachAspis($lucifer,(2))));
arrayAssign($b[0],deAspis(registerTaint(array('year',false))),addTaint(attachAspis($lucifer,(3))));
arrayAssign($b[0],deAspis(registerTaint(array('hour',false))),addTaint(attachAspis($lucifer,(4))));
arrayAssign($b[0],deAspis(registerTaint(array('minute',false))),addTaint(attachAspis($lucifer,(5))));
arrayAssign($b[0],deAspis(registerTaint(array('time',false))),addTaint(@attAspis(mktime((deAspis(attachAspis($lucifer,(4))) + ((strcasecmp(deAspis(attachAspis($lucifer,(6))),("PM")) == (0)) ? (12) : (0))),deAspis(attachAspis($lucifer,(5))),(0),deAspis(attachAspis($lucifer,(1))),deAspis(attachAspis($lucifer,(2))),deAspis(attachAspis($lucifer,(3)))))));
arrayAssign($b[0],deAspis(registerTaint(array('am/pm',false))),addTaint(attachAspis($lucifer,(6))));
arrayAssign($b[0],deAspis(registerTaint(array('name',false))),addTaint(attachAspis($lucifer,(8))));
}else 
{if ( ((denot_boolean($is_windows)) && deAspis($lucifer = Aspis_preg_split(array("/[ ]/",false),$line,array(9,false),array(PREG_SPLIT_NO_EMPTY,false)))))
 {$lcount = attAspis(count($lucifer[0]));
if ( ($lcount[0] < (8)))
 return array('',false);
$b = array(array(),false);
arrayAssign($b[0],deAspis(registerTaint(array('isdir',false))),addTaint(array(deAspis(attachAspis($lucifer[0][(0)],(0))) === ("d"),false)));
arrayAssign($b[0],deAspis(registerTaint(array('islink',false))),addTaint(array(deAspis(attachAspis($lucifer[0][(0)],(0))) === ("l"),false)));
if ( deAspis($b[0]['isdir']))
 arrayAssign($b[0],deAspis(registerTaint(array('type',false))),addTaint(array('d',false)));
elseif ( deAspis($b[0]['islink']))
 arrayAssign($b[0],deAspis(registerTaint(array('type',false))),addTaint(array('l',false)));
else 
{arrayAssign($b[0],deAspis(registerTaint(array('type',false))),addTaint(array('f',false)));
}arrayAssign($b[0],deAspis(registerTaint(array('perms',false))),addTaint(attachAspis($lucifer,(0))));
arrayAssign($b[0],deAspis(registerTaint(array('number',false))),addTaint(attachAspis($lucifer,(1))));
arrayAssign($b[0],deAspis(registerTaint(array('owner',false))),addTaint(attachAspis($lucifer,(2))));
arrayAssign($b[0],deAspis(registerTaint(array('group',false))),addTaint(attachAspis($lucifer,(3))));
arrayAssign($b[0],deAspis(registerTaint(array('size',false))),addTaint(attachAspis($lucifer,(4))));
if ( ($lcount[0] == (8)))
 {AspisInternalFunctionCall("sscanf",deAspis(attachAspis($lucifer,(5))),("%d-%d-%d"),AspisPushRefParam($b[0]['year']),AspisPushRefParam($b[0]['month']),AspisPushRefParam($b[0]['day']),array(2,3,4));
AspisInternalFunctionCall("sscanf",deAspis(attachAspis($lucifer,(6))),("%d:%d"),AspisPushRefParam($b[0]['hour']),AspisPushRefParam($b[0]['minute']),array(2,3));
arrayAssign($b[0],deAspis(registerTaint(array('time',false))),addTaint(@attAspis(mktime(deAspis($b[0]['hour']),deAspis($b[0]['minute']),(0),deAspis($b[0]['month']),deAspis($b[0]['day']),deAspis($b[0]['year'])))));
arrayAssign($b[0],deAspis(registerTaint(array('name',false))),addTaint(attachAspis($lucifer,(7))));
}else 
{{arrayAssign($b[0],deAspis(registerTaint(array('month',false))),addTaint(attachAspis($lucifer,(5))));
arrayAssign($b[0],deAspis(registerTaint(array('day',false))),addTaint(attachAspis($lucifer,(6))));
if ( deAspis(Aspis_preg_match(array("/([0-9]{2}):([0-9]{2})/",false),attachAspis($lucifer,(7)),$l2)))
 {arrayAssign($b[0],deAspis(registerTaint(array('year',false))),addTaint(attAspis(date(("Y")))));
arrayAssign($b[0],deAspis(registerTaint(array('hour',false))),addTaint(attachAspis($l2,(1))));
arrayAssign($b[0],deAspis(registerTaint(array('minute',false))),addTaint(attachAspis($l2,(2))));
}else 
{{arrayAssign($b[0],deAspis(registerTaint(array('year',false))),addTaint(attachAspis($lucifer,(7))));
arrayAssign($b[0],deAspis(registerTaint(array('hour',false))),addTaint(array(0,false)));
arrayAssign($b[0],deAspis(registerTaint(array('minute',false))),addTaint(array(0,false)));
}}arrayAssign($b[0],deAspis(registerTaint(array('time',false))),addTaint(attAspis(strtotime(deAspis(Aspis_sprintf(array("%d %s %d %02d:%02d",false),$b[0]['day'],$b[0]['month'],$b[0]['year'],$b[0]['hour'],$b[0]['minute']))))));
arrayAssign($b[0],deAspis(registerTaint(array('name',false))),addTaint(attachAspis($lucifer,(8))));
}}}}return $b;
} }
function dirlist ( $path = array('.',false),$include_hidden = array(true,false),$recursive = array(false,false) ) {
{if ( deAspis($this->is_file($path)))
 {$limit_file = Aspis_basename($path);
$path = concat2(Aspis_dirname($path),'/');
}else 
{{$limit_file = array(false,false);
}}$list = @attAspisRC(ftp_rawlist($this->link[0],(deconcat1('-a ',$path)),false));
if ( ($list[0] === false))
 return array(false,false);
$dirlist = array(array(),false);
foreach ( $list[0] as $k =>$v )
{restoreTaint($k,$v);
{$entry = $this->parselisting($v);
if ( ((empty($entry) || Aspis_empty( $entry))))
 continue ;
if ( ((('.') == deAspis($entry[0]['name'])) || (('..') == deAspis($entry[0]['name']))))
 continue ;
if ( ((denot_boolean($include_hidden)) && (('.') == deAspis(attachAspis($entry[0][('name')],(0))))))
 continue ;
if ( ($limit_file[0] && (deAspis($entry[0]['name']) != $limit_file[0])))
 continue ;
arrayAssign($dirlist[0],deAspis(registerTaint($entry[0]['name'])),addTaint($entry));
}}if ( (denot_boolean($dirlist)))
 return array(false,false);
$ret = array(array(),false);
foreach ( deAspis(array_cast($dirlist)) as $struc  )
{if ( (('d') == deAspis($struc[0]['type'])))
 {if ( $recursive[0])
 arrayAssign($struc[0],deAspis(registerTaint(array('files',false))),addTaint($this->dirlist(concat(concat2($path,'/'),$struc[0]['name']),$include_hidden,$recursive)));
else 
{arrayAssign($struc[0],deAspis(registerTaint(array('files',false))),addTaint(array(array(),false)));
}}arrayAssign($ret[0],deAspis(registerTaint($struc[0]['name'])),addTaint($struc));
}return $ret;
} }
function __destruct (  ) {
{if ( $this->link[0])
 ftp_close($this->link[0]);
} }
};
?>
<?php 