<?php require_once('AspisMain.php'); ?><?php
class WP_Filesystem_Base{var $verbose = array(false,false);
var $cache = array(array(),false);
var $method = array('',false);
function abspath (  ) {
{$folder = $this->find_folder(array(ABSPATH,false));
if ( ((denot_boolean($folder)) && deAspis($this->is_dir(array('/wp-includes',false)))))
 $folder = array('/',false);
return $folder;
} }
function wp_content_dir (  ) {
{return $this->find_folder(array(WP_CONTENT_DIR,false));
} }
function wp_plugins_dir (  ) {
{return $this->find_folder(array(WP_PLUGIN_DIR,false));
} }
function wp_themes_dir (  ) {
{return concat2($this->wp_content_dir(),'/themes');
} }
function find_base_dir ( $base = array('.',false),$echo = array(false,false) ) {
{_deprecated_function(array(__FUNCTION__,false),array('2.7',false),array('WP_Filesystem::abspath() or WP_Filesystem::wp_*_dir()',false));
$this->verbose = $echo;
return $this->abspath();
} }
function get_base_dir ( $base = array('.',false),$echo = array(false,false) ) {
{_deprecated_function(array(__FUNCTION__,false),array('2.7',false),array('WP_Filesystem::abspath() or WP_Filesystem::wp_*_dir()',false));
$this->verbose = $echo;
return $this->abspath();
} }
function find_folder ( $folder ) {
{if ( (strpos($this->method[0],'ftp') !== false))
 {$constant_overrides = array(array('FTP_BASE' => array(ABSPATH,false,false),'FTP_CONTENT_DIR' => array(WP_CONTENT_DIR,false,false),'FTP_PLUGIN_DIR' => array(WP_PLUGIN_DIR,false,false)),false);
foreach ( $constant_overrides[0] as $constant =>$dir )
{restoreTaint($constant,$dir);
if ( (defined($constant[0]) && ($folder[0] === $dir[0])))
 return trailingslashit(attAspisRC(constant($constant[0])));
}}elseif ( (('direct') == $this->method[0]))
 {return trailingslashit($folder);
}$folder = Aspis_preg_replace(array('|^([a-z]{1}):|i',false),array('',false),$folder);
$folder = Aspis_str_replace(array('\\',false),array('/',false),$folder);
if ( ((isset($this->cache[0][$folder[0]]) && Aspis_isset( $this ->cache [0][$folder[0]] ))))
 return $this->cache[0][$folder[0]];
if ( deAspis($this->exists($folder)))
 {$folder = trailingslashit($folder);
arrayAssign($this->cache[0],deAspis(registerTaint($folder)),addTaint($folder));
return $folder;
}if ( deAspis($return = $this->search_for_folder($folder)))
 arrayAssign($this->cache[0],deAspis(registerTaint($folder)),addTaint($return));
return $return;
} }
function search_for_folder ( $folder,$base = array('.',false),$loop = array(false,false) ) {
{if ( (((empty($base) || Aspis_empty( $base))) || (('.') == $base[0])))
 $base = trailingslashit($this->cwd());
$folder = untrailingslashit($folder);
$folder_parts = Aspis_explode(array('/',false),$folder);
$last_path = attachAspis($folder_parts,(count($folder_parts[0]) - (1)));
$files = $this->dirlist($base);
foreach ( $folder_parts[0] as $key  )
{if ( ($key[0] == $last_path[0]))
 continue ;
if ( ((isset($files[0][$key[0]]) && Aspis_isset( $files [0][$key[0]]))))
 {$newdir = trailingslashit(path_join($base,$key));
if ( $this->verbose[0])
 printf((deconcat2(__(array('Changing to %s',false)),'<br/>')),deAspisRC($newdir));
if ( deAspis($ret = $this->search_for_folder($folder,$newdir,$loop)))
 return $ret;
}}if ( ((isset($files[0][$last_path[0]]) && Aspis_isset( $files [0][$last_path[0]]))))
 {if ( $this->verbose[0])
 printf((deconcat2(__(array('Found %s',false)),'<br/>')),(deconcat($base,$last_path)));
return trailingslashit(concat($base,$last_path));
}if ( $loop[0])
 return array(false,false);
return $this->search_for_folder($folder,array('/',false),array(true,false));
} }
function gethchmod ( $file ) {
{$perms = $this->getchmod($file);
if ( (($perms[0] & (0xC000)) == (0xC000)))
 $info = array('s',false);
elseif ( (($perms[0] & (0xA000)) == (0xA000)))
 $info = array('l',false);
elseif ( (($perms[0] & (0x8000)) == (0x8000)))
 $info = array('-',false);
elseif ( (($perms[0] & (0x6000)) == (0x6000)))
 $info = array('b',false);
elseif ( (($perms[0] & (0x4000)) == (0x4000)))
 $info = array('d',false);
elseif ( (($perms[0] & (0x2000)) == (0x2000)))
 $info = array('c',false);
elseif ( (($perms[0] & (0x1000)) == (0x1000)))
 $info = array('p',false);
else 
{$info = array('u',false);
}$info = concat($info,(($perms[0] & (0x0100)) ? array('r',false) : array('-',false)));
$info = concat($info,(($perms[0] & (0x0080)) ? array('w',false) : array('-',false)));
$info = concat($info,(($perms[0] & (0x0040)) ? (($perms[0] & (0x0800)) ? array('s',false) : array('x',false)) : (($perms[0] & (0x0800)) ? array('S',false) : array('-',false))));
$info = concat($info,(($perms[0] & (0x0020)) ? array('r',false) : array('-',false)));
$info = concat($info,(($perms[0] & (0x0010)) ? array('w',false) : array('-',false)));
$info = concat($info,(($perms[0] & (0x0008)) ? (($perms[0] & (0x0400)) ? array('s',false) : array('x',false)) : (($perms[0] & (0x0400)) ? array('S',false) : array('-',false))));
$info = concat($info,(($perms[0] & (0x0004)) ? array('r',false) : array('-',false)));
$info = concat($info,(($perms[0] & (0x0002)) ? array('w',false) : array('-',false)));
$info = concat($info,(($perms[0] & (0x0001)) ? (($perms[0] & (0x0200)) ? array('t',false) : array('x',false)) : (($perms[0] & (0x0200)) ? array('T',false) : array('-',false))));
return $info;
} }
function getnumchmodfromh ( $mode ) {
{$realmode = array('',false);
$legal = array(array(array('',false),array('w',false),array('r',false),array('x',false),array('-',false)),false);
$attarray = Aspis_preg_split(array('//',false),$mode);
for ( $i = array(0,false) ; ($i[0] < count($attarray[0])) ; postincr($i) )
if ( deAspis($key = Aspis_array_search(attachAspis($attarray,$i[0]),$legal)))
 $realmode = concat($realmode,attachAspis($legal,$key[0]));
$mode = Aspis_str_pad($realmode,array(9,false),array('-',false));
$trans = array(array('-' => array('0',false,false),'r' => array('4',false,false),'w' => array('2',false,false),'x' => array('1',false,false)),false);
$mode = Aspis_strtr($mode,$trans);
$newmode = array('',false);
$newmode = concat2($newmode,(deAspis(attachAspis($mode,(0))) + deAspis(attachAspis($mode,(1)))) + deAspis(attachAspis($mode,(2))));
$newmode = concat2($newmode,(deAspis(attachAspis($mode,(3))) + deAspis(attachAspis($mode,(4)))) + deAspis(attachAspis($mode,(5))));
$newmode = concat2($newmode,(deAspis(attachAspis($mode,(6))) + deAspis(attachAspis($mode,(7)))) + deAspis(attachAspis($mode,(8))));
return $newmode;
} }
function is_binary ( $text ) {
{return bool_cast(Aspis_preg_match(array('|[^\x20-\x7E]|',false),$text));
} }
};
?>
<?php 