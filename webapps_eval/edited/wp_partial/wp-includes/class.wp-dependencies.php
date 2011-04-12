<?php require_once('AspisMain.php'); ?><?php
class WP_Dependencies{var $registered = array();
var $queue = array();
var $to_do = array();
var $done = array();
var $args = array();
var $groups = array();
var $group = 0;
function WP_Dependencies (  ) {
{$args = func_get_args();
AspisUntainted_call_user_func_array(array(&$this,'__construct'),$args);
} }
function __construct (  ) {
{} }
function do_items ( $handles = false,$group = false ) {
{$handles = false === $handles ? $this->queue : (array)$handles;
$this->all_deps($handles);
foreach ( $this->to_do as $key =>$handle )
{if ( !in_array($handle,$this->done) && isset($this->registered[$handle]))
 {if ( !$this->registered[$handle]->src)
 {$this->done[] = $handle;
continue ;
}if ( $this->do_item($handle,$group))
 $this->done[] = $handle;
unset($this->to_do[$key]);
}}{$AspisRetTemp = $this->done;
return $AspisRetTemp;
}} }
function do_item ( $handle ) {
{{$AspisRetTemp = isset($this->registered[$handle]);
return $AspisRetTemp;
}} }
function all_deps ( $handles,$recursion = false,$group = false ) {
{if ( !$handles = (array)$handles)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}foreach ( $handles as $handle  )
{$handle_parts = explode('?',$handle);
$handle = $handle_parts[0];
$queued = in_array($handle,$this->to_do,true);
if ( in_array($handle,$this->done,true))
 continue ;
$moved = $this->set_group($handle,$recursion,$group);
if ( $queued && !$moved)
 continue ;
$keep_going = true;
if ( !isset($this->registered[$handle]))
 $keep_going = false;
elseif ( $this->registered[$handle]->deps && array_diff($this->registered[$handle]->deps,array_keys($this->registered)))
 $keep_going = false;
elseif ( $this->registered[$handle]->deps && !$this->all_deps($this->registered[$handle]->deps,true,$group))
 $keep_going = false;
if ( !$keep_going)
 {if ( $recursion)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}else 
{continue ;
}}if ( $queued)
 continue ;
if ( isset($handle_parts[1]))
 $this->args[$handle] = $handle_parts[1];
$this->to_do[] = $handle;
}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function add ( $handle,$src,$deps = array(),$ver = false,$args = null ) {
{if ( isset($this->registered[$handle]))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$this->registered[$handle] = new _WP_Dependency($handle,$src,$deps,$ver,$args);
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function add_data ( $handle,$data_name,$data ) {
{if ( !isset($this->registered[$handle]))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $this->registered[$handle]->add_data($data_name,$data);
return $AspisRetTemp;
}} }
function remove ( $handles ) {
{foreach ( (array)$handles as $handle  )
unset($this->registered[$handle]);
} }
function enqueue ( $handles ) {
{foreach ( (array)$handles as $handle  )
{$handle = explode('?',$handle);
if ( !in_array($handle[0],$this->queue) && isset($this->registered[$handle[0]]))
 {$this->queue[] = $handle[0];
if ( isset($handle[1]))
 $this->args[$handle[0]] = $handle[1];
}}} }
function dequeue ( $handles ) {
{foreach ( (array)$handles as $handle  )
{$handle = explode('?',$handle);
$key = array_search($handle[0],$this->queue);
if ( false !== $key)
 {unset($this->queue[$key]);
unset($this->args[$handle[0]]);
}}} }
function query ( $handle,$list = 'registered' ) {
{switch ( $list ) {
case 'registered':;
case 'scripts':if ( isset($this->registered[$handle]))
 {$AspisRetTemp = $this->registered[$handle];
return $AspisRetTemp;
}break ;
case 'to_print':case 'printed':if ( 'to_print' == $list)
 $list = 'to_do';
else 
{$list = 'printed';
}default :if ( in_array($handle,$this->$list))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}break ;
 }
{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function set_group ( $handle,$recursion,$group ) {
{$group = (int)$group;
if ( $recursion)
 $group = min($this->group,$group);
else 
{$this->group = $group;
}if ( isset($this->groups[$handle]) && $this->groups[$handle] <= $group)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$this->groups[$handle] = $group;
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
}class _WP_Dependency{var $handle;
var $src;
var $deps = array();
var $ver = false;
var $args = null;
var $extra = array();
function _WP_Dependency (  ) {
{@list($this->handle,$this->src,$this->deps,$this->ver,$this->args) = func_get_args();
if ( !is_array($this->deps))
 $this->deps = array();
if ( !$this->ver)
 $this->ver = false;
} }
function add_data ( $name,$data ) {
{if ( !is_scalar($name))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$this->extra[$name] = $data;
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
}