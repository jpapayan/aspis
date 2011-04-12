<?php require_once('AspisMain.php'); ?><?php
class WP_Filesystem_Base{var $verbose = false;
var $cache = array();
var $method = '';
function abspath (  ) {
{$folder = $this->find_folder(ABSPATH);
if ( !$folder && $this->is_dir('/wp-includes'))
 $folder = '/';
{$AspisRetTemp = $folder;
return $AspisRetTemp;
}} }
function wp_content_dir (  ) {
{{$AspisRetTemp = $this->find_folder(WP_CONTENT_DIR);
return $AspisRetTemp;
}} }
function wp_plugins_dir (  ) {
{{$AspisRetTemp = $this->find_folder(WP_PLUGIN_DIR);
return $AspisRetTemp;
}} }
function wp_themes_dir (  ) {
{{$AspisRetTemp = $this->wp_content_dir() . '/themes';
return $AspisRetTemp;
}} }
function find_base_dir ( $base = '.',$echo = false ) {
{_deprecated_function(__FUNCTION__,'2.7','WP_Filesystem::abspath() or WP_Filesystem::wp_*_dir()');
$this->verbose = $echo;
{$AspisRetTemp = $this->abspath();
return $AspisRetTemp;
}} }
function get_base_dir ( $base = '.',$echo = false ) {
{_deprecated_function(__FUNCTION__,'2.7','WP_Filesystem::abspath() or WP_Filesystem::wp_*_dir()');
$this->verbose = $echo;
{$AspisRetTemp = $this->abspath();
return $AspisRetTemp;
}} }
function find_folder ( $folder ) {
{if ( strpos($this->method,'ftp') !== false)
 {$constant_overrides = array('FTP_BASE' => ABSPATH,'FTP_CONTENT_DIR' => WP_CONTENT_DIR,'FTP_PLUGIN_DIR' => WP_PLUGIN_DIR);
foreach ( $constant_overrides as $constant =>$dir )
if ( defined($constant) && $folder === $dir)
 {$AspisRetTemp = trailingslashit(constant($constant));
return $AspisRetTemp;
}}elseif ( 'direct' == $this->method)
 {{$AspisRetTemp = trailingslashit($folder);
return $AspisRetTemp;
}}$folder = preg_replace('|^([a-z]{1}):|i','',$folder);
$folder = str_replace('\\','/',$folder);
if ( isset($this->cache[$folder]))
 {$AspisRetTemp = $this->cache[$folder];
return $AspisRetTemp;
}if ( $this->exists($folder))
 {$folder = trailingslashit($folder);
$this->cache[$folder] = $folder;
{$AspisRetTemp = $folder;
return $AspisRetTemp;
}}if ( $return = $this->search_for_folder($folder))
 $this->cache[$folder] = $return;
{$AspisRetTemp = $return;
return $AspisRetTemp;
}} }
function search_for_folder ( $folder,$base = '.',$loop = false ) {
{if ( empty($base) || '.' == $base)
 $base = trailingslashit($this->cwd());
$folder = untrailingslashit($folder);
$folder_parts = explode('/',$folder);
$last_path = $folder_parts[count($folder_parts) - 1];
$files = $this->dirlist($base);
foreach ( $folder_parts as $key  )
{if ( $key == $last_path)
 continue ;
if ( isset($files[$key]))
 {$newdir = trailingslashit(path_join($base,$key));
if ( $this->verbose)
 printf(__('Changing to %s') . '<br/>',$newdir);
if ( $ret = $this->search_for_folder($folder,$newdir,$loop))
 {$AspisRetTemp = $ret;
return $AspisRetTemp;
}}}if ( isset($files[$last_path]))
 {if ( $this->verbose)
 printf(__('Found %s') . '<br/>',$base . $last_path);
{$AspisRetTemp = trailingslashit($base . $last_path);
return $AspisRetTemp;
}}if ( $loop)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $this->search_for_folder($folder,'/',true);
return $AspisRetTemp;
}} }
function gethchmod ( $file ) {
{$perms = $this->getchmod($file);
if ( ($perms & 0xC000) == 0xC000)
 $info = 's';
elseif ( ($perms & 0xA000) == 0xA000)
 $info = 'l';
elseif ( ($perms & 0x8000) == 0x8000)
 $info = '-';
elseif ( ($perms & 0x6000) == 0x6000)
 $info = 'b';
elseif ( ($perms & 0x4000) == 0x4000)
 $info = 'd';
elseif ( ($perms & 0x2000) == 0x2000)
 $info = 'c';
elseif ( ($perms & 0x1000) == 0x1000)
 $info = 'p';
else 
{$info = 'u';
}$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));
{$AspisRetTemp = $info;
return $AspisRetTemp;
}} }
function getnumchmodfromh ( $mode ) {
{$realmode = '';
$legal = array('','w','r','x','-');
$attarray = preg_split('//',$mode);
for ( $i = 0 ; $i < count($attarray) ; $i++ )
if ( $key = array_search($attarray[$i],$legal))
 $realmode .= $legal[$key];
$mode = str_pad($realmode,9,'-');
$trans = array('-' => '0','r' => '4','w' => '2','x' => '1');
$mode = strtr($mode,$trans);
$newmode = '';
$newmode .= $mode[0] + $mode[1] + $mode[2];
$newmode .= $mode[3] + $mode[4] + $mode[5];
$newmode .= $mode[6] + $mode[7] + $mode[8];
{$AspisRetTemp = $newmode;
return $AspisRetTemp;
}} }
function is_binary ( $text ) {
{{$AspisRetTemp = (bool)preg_match('|[^\x20-\x7E]|',$text);
return $AspisRetTemp;
}} }
};
?>
<?php 