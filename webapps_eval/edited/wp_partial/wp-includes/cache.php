<?php require_once('AspisMain.php'); ?><?php
function wp_cache_add ( $key,$data,$flag = '',$expire = 0 ) {
{global $wp_object_cache;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_object_cache,"\$wp_object_cache",$AspisChangesCache);
}{$AspisRetTemp = $wp_object_cache->add($key,$data,$flag,$expire);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
 }
function wp_cache_close (  ) {
{$AspisRetTemp = true;
return $AspisRetTemp;
} }
function wp_cache_delete ( $id,$flag = '' ) {
{global $wp_object_cache;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_object_cache,"\$wp_object_cache",$AspisChangesCache);
}{$AspisRetTemp = $wp_object_cache->delete($id,$flag);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
 }
function wp_cache_flush (  ) {
{global $wp_object_cache;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_object_cache,"\$wp_object_cache",$AspisChangesCache);
}{$AspisRetTemp = $wp_object_cache->flush();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
 }
function wp_cache_get ( $id,$flag = '' ) {
{global $wp_object_cache;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_object_cache,"\$wp_object_cache",$AspisChangesCache);
}{$AspisRetTemp = $wp_object_cache->get($id,$flag);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
 }
function wp_cache_init (  ) {
$GLOBALS[0]['wp_object_cache'] = &new WP_Object_Cache();
 }
function wp_cache_replace ( $key,$data,$flag = '',$expire = 0 ) {
{global $wp_object_cache;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_object_cache,"\$wp_object_cache",$AspisChangesCache);
}{$AspisRetTemp = $wp_object_cache->replace($key,$data,$flag,$expire);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
 }
function wp_cache_set ( $key,$data,$flag = '',$expire = 0 ) {
{global $wp_object_cache;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_object_cache,"\$wp_object_cache",$AspisChangesCache);
}{$AspisRetTemp = $wp_object_cache->set($key,$data,$flag,$expire);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_object_cache",$AspisChangesCache);
 }
function wp_cache_add_global_groups ( $groups ) {
{return ;
} }
function wp_cache_add_non_persistent_groups ( $groups ) {
{return ;
} }
class WP_Object_Cache{var $cache = array();
var $non_existant_objects = array();
var $cache_hits = 0;
var $cache_misses = 0;
function add ( $id,$data,$group = 'default',$expire = '' ) {
{if ( empty($group))
 $group = 'default';
if ( false !== $this->get($id,$group,false))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $this->set($id,$data,$group,$expire);
return $AspisRetTemp;
}} }
function delete ( $id,$group = 'default',$force = false ) {
{if ( empty($group))
 $group = 'default';
if ( !$force && false === $this->get($id,$group,false))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}unset($this->cache[$group][$id]);
$this->non_existant_objects[$group][$id] = true;
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function flush (  ) {
{$this->cache = array();
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function get ( $id,$group = 'default' ) {
{if ( empty($group))
 $group = 'default';
if ( isset($this->cache[$group][$id]))
 {$this->cache_hits += 1;
if ( is_object($this->cache[$group][$id]))
 {$AspisRetTemp = wp_clone($this->cache[$group][$id]);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = $this->cache[$group][$id];
return $AspisRetTemp;
}}}if ( isset($this->non_existant_objects[$group][$id]))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$this->non_existant_objects[$group][$id] = true;
$this->cache_misses += 1;
{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function replace ( $id,$data,$group = 'default',$expire = '' ) {
{if ( empty($group))
 $group = 'default';
if ( false === $this->get($id,$group,false))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $this->set($id,$data,$group,$expire);
return $AspisRetTemp;
}} }
function set ( $id,$data,$group = 'default',$expire = '' ) {
{if ( empty($group))
 $group = 'default';
if ( NULL === $data)
 $data = '';
if ( is_object($data))
 $data = wp_clone($data);
$this->cache[$group][$id] = $data;
if ( isset($this->non_existant_objects[$group][$id]))
 unset($this->non_existant_objects[$group][$id]);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function stats (  ) {
{echo "<p>";
echo "<strong>Cache Hits:</strong> {$this->cache_hits}<br />";
echo "<strong>Cache Misses:</strong> {$this->cache_misses}<br />";
echo "</p>";
foreach ( $this->cache as $group =>$cache )
{echo "<p>";
echo "<strong>Group:</strong> $group<br />";
echo "<strong>Cache:</strong>";
echo "<pre>";
print_r($cache);
echo "</pre>";
}} }
function WP_Object_Cache (  ) {
{{$AspisRetTemp = $this->__construct();
return $AspisRetTemp;
}} }
function __construct (  ) {
{register_shutdown_function(array(&$this,"__destruct"));
} }
function __destruct (  ) {
{{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
};
?>
<?php 