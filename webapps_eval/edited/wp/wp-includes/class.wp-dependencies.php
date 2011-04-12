<?php require_once('AspisMain.php'); ?><?php
class WP_Dependencies{var $registered = array(array(),false);
var $queue = array(array(),false);
var $to_do = array(array(),false);
var $done = array(array(),false);
var $args = array(array(),false);
var $groups = array(array(),false);
var $group = array(0,false);
function WP_Dependencies (  ) {
{$args = array(func_get_args(),false);
Aspis_call_user_func_array(array(array(array($this,false),array('__construct',false)),false),$args);
} }
function __construct (  ) {
{} }
function do_items ( $handles = array(false,false),$group = array(false,false) ) {
{$handles = (false === $handles[0]) ? $this->queue : array_cast($handles);
$this->all_deps($handles);
foreach ( $this->to_do[0] as $key =>$handle )
{restoreTaint($key,$handle);
{if ( ((denot_boolean(Aspis_in_array($handle,$this->done))) && ((isset($this->registered[0][$handle[0]]) && Aspis_isset( $this ->registered [0][$handle[0]] )))))
 {if ( (denot_boolean($this->registered[0][$handle[0]][0]->src)))
 {arrayAssignAdd($this->done[0][],addTaint($handle));
continue ;
}if ( deAspis($this->do_item($handle,$group)))
 arrayAssignAdd($this->done[0][],addTaint($handle));
unset($this->to_do[0][$key[0]]);
}}}return $this->done;
} }
function do_item ( $handle ) {
{return array((isset($this->registered[0][$handle[0]]) && Aspis_isset( $this ->registered [0][$handle[0]] )),false);
} }
function all_deps ( $handles,$recursion = array(false,false),$group = array(false,false) ) {
{if ( (denot_boolean($handles = array_cast($handles))))
 return array(false,false);
foreach ( $handles[0] as $handle  )
{$handle_parts = Aspis_explode(array('?',false),$handle);
$handle = attachAspis($handle_parts,(0));
$queued = Aspis_in_array($handle,$this->to_do,array(true,false));
if ( deAspis(Aspis_in_array($handle,$this->done,array(true,false))))
 continue ;
$moved = $this->set_group($handle,$recursion,$group);
if ( ($queued[0] && (denot_boolean($moved))))
 continue ;
$keep_going = array(true,false);
if ( (!((isset($this->registered[0][$handle[0]]) && Aspis_isset( $this ->registered [0][$handle[0]] )))))
 $keep_going = array(false,false);
elseif ( ($this->registered[0][$handle[0]][0]->deps[0] && deAspis(Aspis_array_diff($this->registered[0][$handle[0]][0]->deps,attAspisRC(array_keys(deAspisRC($this->registered)))))))
 $keep_going = array(false,false);
elseif ( ($this->registered[0][$handle[0]][0]->deps[0] && (denot_boolean($this->all_deps($this->registered[0][$handle[0]][0]->deps,array(true,false),$group)))))
 $keep_going = array(false,false);
if ( (denot_boolean($keep_going)))
 {if ( $recursion[0])
 return array(false,false);
else 
{continue ;
}}if ( $queued[0])
 continue ;
if ( ((isset($handle_parts[0][(1)]) && Aspis_isset( $handle_parts [0][(1)]))))
 arrayAssign($this->args[0],deAspis(registerTaint($handle)),addTaint(attachAspis($handle_parts,(1))));
arrayAssignAdd($this->to_do[0][],addTaint($handle));
}return array(true,false);
} }
function add ( $handle,$src,$deps = array(array(),false),$ver = array(false,false),$args = array(null,false) ) {
{if ( ((isset($this->registered[0][$handle[0]]) && Aspis_isset( $this ->registered [0][$handle[0]] ))))
 return array(false,false);
arrayAssign($this->registered[0],deAspis(registerTaint($handle)),addTaint(array(new _WP_Dependency($handle,$src,$deps,$ver,$args),false)));
return array(true,false);
} }
function add_data ( $handle,$data_name,$data ) {
{if ( (!((isset($this->registered[0][$handle[0]]) && Aspis_isset( $this ->registered [0][$handle[0]] )))))
 return array(false,false);
return $this->registered[0][$handle[0]][0]->add_data($data_name,$data);
} }
function remove ( $handles ) {
{foreach ( deAspis(array_cast($handles)) as $handle  )
unset($this->registered[0][$handle[0]]);
} }
function enqueue ( $handles ) {
{foreach ( deAspis(array_cast($handles)) as $handle  )
{$handle = Aspis_explode(array('?',false),$handle);
if ( ((denot_boolean(Aspis_in_array(attachAspis($handle,(0)),$this->queue))) && ((isset($this->registered[0][deAspis(attachAspis($handle,(0)))]) && Aspis_isset( $this ->registered [0][deAspis(attachAspis( $handle ,(0)))] )))))
 {arrayAssignAdd($this->queue[0][],addTaint(attachAspis($handle,(0))));
if ( ((isset($handle[0][(1)]) && Aspis_isset( $handle [0][(1)]))))
 arrayAssign($this->args[0],deAspis(registerTaint(attachAspis($handle,(0)))),addTaint(attachAspis($handle,(1))));
}}} }
function dequeue ( $handles ) {
{foreach ( deAspis(array_cast($handles)) as $handle  )
{$handle = Aspis_explode(array('?',false),$handle);
$key = Aspis_array_search(attachAspis($handle,(0)),$this->queue);
if ( (false !== $key[0]))
 {unset($this->queue[0][$key[0]]);
unset($this->args[0][deAspis(attachAspis($handle,(0)))]);
}}} }
function query ( $handle,$list = array('registered',false) ) {
{switch ( $list[0] ) {
case ('registered'):;
case ('scripts'):if ( ((isset($this->registered[0][$handle[0]]) && Aspis_isset( $this ->registered [0][$handle[0]] ))))
 return $this->registered[0][$handle[0]];
break ;
case ('to_print'):case ('printed'):if ( (('to_print') == $list[0]))
 $list = array('to_do',false);
else 
{$list = array('printed',false);
}default :if ( deAspis(Aspis_in_array($handle,$this->$list[0])))
 return array(true,false);
break ;
 }
return array(false,false);
} }
function set_group ( $handle,$recursion,$group ) {
{$group = int_cast($group);
if ( $recursion[0])
 $group = attAspisRC(min(deAspisRC($this->group),deAspisRC($group)));
else 
{$this->group = $group;
}if ( (((isset($this->groups[0][$handle[0]]) && Aspis_isset( $this ->groups [0][$handle[0]] ))) && ($this->groups[0][$handle[0]][0] <= $group[0])))
 return array(false,false);
arrayAssign($this->groups[0],deAspis(registerTaint($handle)),addTaint($group));
return array(true,false);
} }
}class _WP_Dependency{var $handle;
var $src;
var $deps = array(array(),false);
var $ver = array(false,false);
var $args = array(null,false);
var $extra = array(array(),false);
function _WP_Dependency (  ) {
{@list($this->handle,$this->src,$this->deps,$this->ver,$this->args) = deAspisList(array(func_get_args(),false),array());
if ( (!(is_array($this->deps[0]))))
 $this->deps = array(array(),false);
if ( (denot_boolean($this->ver)))
 $this->ver = array(false,false);
} }
function add_data ( $name,$data ) {
{if ( (!(is_scalar(deAspisRC($name)))))
 return array(false,false);
arrayAssign($this->extra[0],deAspis(registerTaint($name)),addTaint($data));
return array(true,false);
} }
}