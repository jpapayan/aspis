<?php require_once('AspisMain.php'); ?><?php
function wp_cache_add ( $key,$data,$flag = array('',false),$expire = array(0,false) ) {
global $wp_object_cache;
return $wp_object_cache[0]->add($key,$data,$flag,$expire);
 }
function wp_cache_close (  ) {
return array(true,false);
 }
function wp_cache_delete ( $id,$flag = array('',false) ) {
global $wp_object_cache;
return $wp_object_cache[0]->delete($id,$flag);
 }
function wp_cache_flush (  ) {
global $wp_object_cache;
return $wp_object_cache[0]->flush();
 }
function wp_cache_get ( $id,$flag = array('',false) ) {
global $wp_object_cache;
return $wp_object_cache[0]->get($id,$flag);
 }
function wp_cache_init (  ) {
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('wp_object_cache',false))),addTaint(array(new WP_Object_Cache(),false)));
 }
function wp_cache_replace ( $key,$data,$flag = array('',false),$expire = array(0,false) ) {
global $wp_object_cache;
return $wp_object_cache[0]->replace($key,$data,$flag,$expire);
 }
function wp_cache_set ( $key,$data,$flag = array('',false),$expire = array(0,false) ) {
global $wp_object_cache;
return $wp_object_cache[0]->set($key,$data,$flag,$expire);
 }
function wp_cache_add_global_groups ( $groups ) {
return ;
 }
function wp_cache_add_non_persistent_groups ( $groups ) {
return ;
 }
class WP_Object_Cache{var $cache = array(array(),false);
var $non_existant_objects = array(array(),false);
var $cache_hits = array(0,false);
var $cache_misses = array(0,false);
function add ( $id,$data,$group = array('default',false),$expire = array('',false) ) {
{if ( ((empty($group) || Aspis_empty( $group))))
 $group = array('default',false);
if ( (false !== deAspis($this->get($id,$group,array(false,false)))))
 return array(false,false);
return $this->set($id,$data,$group,$expire);
} }
function delete ( $id,$group = array('default',false),$force = array(false,false) ) {
{if ( ((empty($group) || Aspis_empty( $group))))
 $group = array('default',false);
if ( ((denot_boolean($force)) && (false === deAspis($this->get($id,$group,array(false,false))))))
 return array(false,false);
unset($this->cache[0][$group[0]][0][$id[0]]);
arrayAssign($this->non_existant_objects[0][$group[0]][0],deAspis(registerTaint($id)),addTaint(array(true,false)));
return array(true,false);
} }
function flush (  ) {
{$this->cache = array(array(),false);
return array(true,false);
} }
function get ( $id,$group = array('default',false) ) {
{if ( ((empty($group) || Aspis_empty( $group))))
 $group = array('default',false);
if ( ((isset($this->cache[0][$group[0]][0][$id[0]]) && Aspis_isset( $this ->cache [0][$group[0]] [0][$id[0]] ))))
 {$this->cache_hits = array((1) + $this->cache_hits [0],false);
if ( is_object($this->cache[0][$group[0]][0][$id[0]][0]))
 return wp_clone($this->cache[0][$group[0]][0][$id[0]]);
else 
{return $this->cache[0][$group[0]][0][$id[0]];
}}if ( ((isset($this->non_existant_objects[0][$group[0]][0][$id[0]]) && Aspis_isset( $this ->non_existant_objects [0][$group[0]] [0][$id[0]] ))))
 return array(false,false);
arrayAssign($this->non_existant_objects[0][$group[0]][0],deAspis(registerTaint($id)),addTaint(array(true,false)));
$this->cache_misses = array((1) + $this->cache_misses [0],false);
return array(false,false);
} }
function replace ( $id,$data,$group = array('default',false),$expire = array('',false) ) {
{if ( ((empty($group) || Aspis_empty( $group))))
 $group = array('default',false);
if ( (false === deAspis($this->get($id,$group,array(false,false)))))
 return array(false,false);
return $this->set($id,$data,$group,$expire);
} }
function set ( $id,$data,$group = array('default',false),$expire = array('',false) ) {
{if ( ((empty($group) || Aspis_empty( $group))))
 $group = array('default',false);
if ( (NULL === $data[0]))
 $data = array('',false);
if ( is_object($data[0]))
 $data = wp_clone($data);
arrayAssign($this->cache[0][$group[0]][0],deAspis(registerTaint($id)),addTaint($data));
if ( ((isset($this->non_existant_objects[0][$group[0]][0][$id[0]]) && Aspis_isset( $this ->non_existant_objects [0][$group[0]] [0][$id[0]] ))))
 unset($this->non_existant_objects[0][$group[0]][0][$id[0]]);
return array(true,false);
} }
function stats (  ) {
{echo AspisCheckPrint(array("<p>",false));
echo AspisCheckPrint(concat2(concat1("<strong>Cache Hits:</strong> ",$this->cache_hits),"<br />"));
echo AspisCheckPrint(concat2(concat1("<strong>Cache Misses:</strong> ",$this->cache_misses),"<br />"));
echo AspisCheckPrint(array("</p>",false));
foreach ( $this->cache[0] as $group =>$cache )
{restoreTaint($group,$cache);
{echo AspisCheckPrint(array("<p>",false));
echo AspisCheckPrint(concat2(concat1("<strong>Group:</strong> ",$group),"<br />"));
echo AspisCheckPrint(array("<strong>Cache:</strong>",false));
echo AspisCheckPrint(array("<pre>",false));
Aspis_print_r($cache);
echo AspisCheckPrint(array("</pre>",false));
}}} }
function WP_Object_Cache (  ) {
{return $this->__construct();
} }
function __construct (  ) {
{register_shutdown_function(AspisInternalCallback(array(array(array($this,false),array("__destruct",false)),false)));
} }
function __destruct (  ) {
{return array(true,false);
} }
};
?>
<?php 