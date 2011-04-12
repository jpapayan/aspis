<?php require_once('AspisMain.php'); ?><?php
function add_filter ( $tag,$function_to_add,$priority = array(10,false),$accepted_args = array(1,false) ) {
global $wp_filter,$merged_filters;
$idx = _wp_filter_build_unique_id($tag,$function_to_add,$priority);
arrayAssign($wp_filter[0][$tag[0]][0][$priority[0]][0],deAspis(registerTaint($idx)),addTaint(array(array(deregisterTaint(array('function',false)) => addTaint($function_to_add),deregisterTaint(array('accepted_args',false)) => addTaint($accepted_args)),false)));
unset($merged_filters[0][$tag[0]]);
return array(true,false);
 }
function has_filter ( $tag,$function_to_check = array(false,false) ) {
global $wp_filter;
$has = not_boolean(array((empty($wp_filter[0][$tag[0]]) || Aspis_empty( $wp_filter [0][$tag[0]])),false));
if ( ((false === $function_to_check[0]) || (false == $has[0])))
 return $has;
if ( (denot_boolean($idx = _wp_filter_build_unique_id($tag,$function_to_check,array(false,false)))))
 return array(false,false);
foreach ( deAspis(array_cast(attAspisRC(array_keys(deAspisRC(attachAspis($wp_filter,$tag[0])))))) as $priority  )
{if ( ((isset($wp_filter[0][$tag[0]][0][$priority[0]][0][$idx[0]]) && Aspis_isset( $wp_filter [0][$tag[0]] [0][$priority[0]] [0][$idx[0]]))))
 return $priority;
}return array(false,false);
 }
function apply_filters ( $tag,$value ) {
global $wp_filter,$merged_filters,$wp_current_filter;
$args = array(array(),false);
arrayAssignAdd($wp_current_filter[0][],addTaint($tag));
if ( ((isset($wp_filter[0][('all')]) && Aspis_isset( $wp_filter [0][('all')]))))
 {$args = array(func_get_args(),false);
_wp_call_all_hook($args);
}if ( (!((isset($wp_filter[0][$tag[0]]) && Aspis_isset( $wp_filter [0][$tag[0]])))))
 {Aspis_array_pop($wp_current_filter);
return $value;
}if ( (!((isset($merged_filters[0][$tag[0]]) && Aspis_isset( $merged_filters [0][$tag[0]])))))
 {Aspis_ksort(attachAspis($wp_filter,$tag[0]));
arrayAssign($merged_filters[0],deAspis(registerTaint($tag)),addTaint(array(true,false)));
}Aspis_reset(attachAspis($wp_filter,$tag[0]));
if ( ((empty($args) || Aspis_empty( $args))))
 $args = array(func_get_args(),false);
do {foreach ( deAspis(array_cast(Aspis_current(attachAspis($wp_filter,$tag[0])))) as $the_  )
if ( (!(is_null(deAspisRC($the_[0]['function'])))))
 {arrayAssign($args[0],deAspis(registerTaint(array(1,false))),addTaint($value));
$value = Aspis_call_user_func_array($the_[0]['function'],Aspis_array_slice($args,array(1,false),int_cast($the_[0]['accepted_args'])));
}}while ((deAspis(Aspis_next(attachAspis($wp_filter,$tag[0]))) !== false) )
;
Aspis_array_pop($wp_current_filter);
return $value;
 }
function apply_filters2 ( $tag,$value ) {
global $wp_filter,$merged_filters,$wp_current_filter;
$args = array(array(),false);
arrayAssignAdd($wp_current_filter[0][],addTaint($tag));
if ( ((isset($wp_filter[0][('all')]) && Aspis_isset( $wp_filter [0][('all')]))))
 {$args = array(func_get_args(),false);
_wp_call_all_hook($args);
}if ( (!((isset($wp_filter[0][$tag[0]]) && Aspis_isset( $wp_filter [0][$tag[0]])))))
 {Aspis_array_pop($wp_current_filter);
return $value;
}if ( (!((isset($merged_filters[0][$tag[0]]) && Aspis_isset( $merged_filters [0][$tag[0]])))))
 {Aspis_ksort(attachAspis($wp_filter,$tag[0]));
arrayAssign($merged_filters[0],deAspis(registerTaint($tag)),addTaint(array(true,false)));
}Aspis_reset(attachAspis($wp_filter,$tag[0]));
if ( ((empty($args) || Aspis_empty( $args))))
 $args = array(func_get_args(),false);
do {foreach ( deAspis(array_cast(Aspis_current(attachAspis($wp_filter,$tag[0])))) as $the_  )
if ( (!(is_null(deAspisRC($the_[0]['function'])))))
 {arrayAssign($args[0],deAspis(registerTaint(array(1,false))),addTaint($value));
$value = Aspis_call_user_func_array($the_[0]['function'],Aspis_array_slice($args,array(1,false),int_cast($the_[0]['accepted_args'])));
}}while ((deAspis(Aspis_next(attachAspis($wp_filter,$tag[0]))) !== false) )
;
Aspis_array_pop($wp_current_filter);
return $value;
 }
function remove_filter ( $tag,$function_to_remove,$priority = array(10,false),$accepted_args = array(1,false) ) {
$function_to_remove = _wp_filter_build_unique_id($tag,$function_to_remove,$priority);
$r = array((isset($GLOBALS[0][('wp_filter')][0][$tag[0]][0][$priority[0]][0][$function_to_remove[0]]) && Aspis_isset( $GLOBALS [0][('wp_filter')] [0][$tag[0]] [0][$priority[0]] [0][$function_to_remove[0]])),false);
if ( (true === $r[0]))
 {unset($GLOBALS[0][('wp_filter')][0][$tag[0]][0][$priority[0]][0][$function_to_remove[0]]);
if ( ((empty($GLOBALS[0][('wp_filter')][0][$tag[0]][0][$priority[0]]) || Aspis_empty( $GLOBALS [0][('wp_filter')] [0][$tag[0]] [0][$priority[0]]))))
 unset($GLOBALS[0][('wp_filter')][0][$tag[0]][0][$priority[0]]);
unset($GLOBALS[0][('merged_filters')][0][$tag[0]]);
}return $r;
 }
function remove_all_filters ( $tag,$priority = array(false,false) ) {
global $wp_filter,$merged_filters;
if ( ((isset($wp_filter[0][$tag[0]]) && Aspis_isset( $wp_filter [0][$tag[0]]))))
 {if ( ((false !== $priority[0]) && ((isset(${$wp_filter[0][$tag[0]][0][$priority[0]][0]}) && Aspis_isset( ${$wp_filter [0][$tag[0]] [0][$priority[0]][0]})))))
 unset($wp_filter[0][$tag[0]][0][$priority[0]]);
else 
{unset($wp_filter[0][$tag[0]]);
}}if ( ((isset($merged_filters[0][$tag[0]]) && Aspis_isset( $merged_filters [0][$tag[0]]))))
 unset($merged_filters[0][$tag[0]]);
return array(true,false);
 }
function current_filter (  ) {
global $wp_current_filter;
return Aspis_end($wp_current_filter);
 }
function add_action ( $tag,$function_to_add,$priority = array(10,false),$accepted_args = array(1,false) ) {
return add_filter($tag,$function_to_add,$priority,$accepted_args);
 }
function do_action ( $tag,$arg = array('',false) ) {
global $wp_filter,$wp_actions,$merged_filters,$wp_current_filter;
if ( is_array($wp_actions[0]))
 arrayAssignAdd($wp_actions[0][],addTaint($tag));
else 
{$wp_actions = array(array($tag),false);
}arrayAssignAdd($wp_current_filter[0][],addTaint($tag));
if ( ((isset($wp_filter[0][('all')]) && Aspis_isset( $wp_filter [0][('all')]))))
 {$all_args = array(func_get_args(),false);
_wp_call_all_hook($all_args);
}if ( (!((isset($wp_filter[0][$tag[0]]) && Aspis_isset( $wp_filter [0][$tag[0]])))))
 {Aspis_array_pop($wp_current_filter);
return ;
}$args = array(array(),false);
if ( ((is_array($arg[0]) && ((1) == count($arg[0]))) && is_object(deAspis(attachAspis($arg,(0))))))
 $args[0][] = &addTaintR($arg[0][(0)]);
else 
{arrayAssignAdd($args[0][],addTaint($arg));
}for ( $a = array(2,false) ; ($a[0] < func_num_args()) ; postincr($a) )
arrayAssignAdd($args[0][],addTaint(func_get_arg($a[0])));
if ( (!((isset($merged_filters[0][$tag[0]]) && Aspis_isset( $merged_filters [0][$tag[0]])))))
 {Aspis_ksort(attachAspis($wp_filter,$tag[0]));
arrayAssign($merged_filters[0],deAspis(registerTaint($tag)),addTaint(array(true,false)));
}Aspis_reset(attachAspis($wp_filter,$tag[0]));
do {foreach ( deAspis(array_cast(Aspis_current(attachAspis($wp_filter,$tag[0])))) as $the_  )
if ( (!(is_null(deAspisRC($the_[0]['function'])))))
 Aspis_call_user_func_array($the_[0]['function'],Aspis_array_slice($args,array(0,false),int_cast($the_[0]['accepted_args'])));
}while ((deAspis(Aspis_next(attachAspis($wp_filter,$tag[0]))) !== false) )
;
Aspis_array_pop($wp_current_filter);
 }
function did_action ( $tag ) {
global $wp_actions;
if ( ((empty($wp_actions) || Aspis_empty( $wp_actions))))
 return array(0,false);
return attAspis(count(deAspis(attAspisRC(array_keys(deAspisRC($wp_actions),deAspisRC($tag))))));
 }
function do_action_ref_array ( $tag,$args ) {
global $wp_filter,$wp_actions,$merged_filters,$wp_current_filter;
if ( (!(is_array($wp_actions[0]))))
 $wp_actions = array(array($tag),false);
else 
{arrayAssignAdd($wp_actions[0][],addTaint($tag));
}arrayAssignAdd($wp_current_filter[0][],addTaint($tag));
if ( ((isset($wp_filter[0][('all')]) && Aspis_isset( $wp_filter [0][('all')]))))
 {$all_args = array(func_get_args(),false);
_wp_call_all_hook($all_args);
}if ( (!((isset($wp_filter[0][$tag[0]]) && Aspis_isset( $wp_filter [0][$tag[0]])))))
 {Aspis_array_pop($wp_current_filter);
return ;
}if ( (!((isset($merged_filters[0][$tag[0]]) && Aspis_isset( $merged_filters [0][$tag[0]])))))
 {Aspis_ksort(attachAspis($wp_filter,$tag[0]));
arrayAssign($merged_filters[0],deAspis(registerTaint($tag)),addTaint(array(true,false)));
}Aspis_reset(attachAspis($wp_filter,$tag[0]));
do {foreach ( deAspis(array_cast(Aspis_current(attachAspis($wp_filter,$tag[0])))) as $the_  )
if ( (!(is_null(deAspisRC($the_[0]['function'])))))
 Aspis_call_user_func_array($the_[0]['function'],Aspis_array_slice($args,array(0,false),int_cast($the_[0]['accepted_args'])));
}while ((deAspis(Aspis_next(attachAspis($wp_filter,$tag[0]))) !== false) )
;
Aspis_array_pop($wp_current_filter);
 }
function has_action ( $tag,$function_to_check = array(false,false) ) {
return has_filter($tag,$function_to_check);
 }
function remove_action ( $tag,$function_to_remove,$priority = array(10,false),$accepted_args = array(1,false) ) {
return remove_filter($tag,$function_to_remove,$priority,$accepted_args);
 }
function remove_all_actions ( $tag,$priority = array(false,false) ) {
return remove_all_filters($tag,$priority);
 }
function plugin_basename ( $file ) {
$file = Aspis_str_replace(array('\\',false),array('/',false),$file);
$file = Aspis_preg_replace(array('|/+|',false),array('/',false),$file);
$plugin_dir = Aspis_str_replace(array('\\',false),array('/',false),array(WP_PLUGIN_DIR,false));
$plugin_dir = Aspis_preg_replace(array('|/+|',false),array('/',false),$plugin_dir);
$mu_plugin_dir = Aspis_str_replace(array('\\',false),array('/',false),array(WPMU_PLUGIN_DIR,false));
$mu_plugin_dir = Aspis_preg_replace(array('|/+|',false),array('/',false),$mu_plugin_dir);
$file = Aspis_preg_replace(concat2(concat(concat2(concat1('#^',Aspis_preg_quote($plugin_dir,array('#',false))),'/|^'),Aspis_preg_quote($mu_plugin_dir,array('#',false))),'/#'),array('',false),$file);
$file = Aspis_trim($file,array('/',false));
return $file;
 }
function plugin_dir_path ( $file ) {
return trailingslashit(Aspis_dirname($file));
 }
function plugin_dir_url ( $file ) {
return trailingslashit(plugins_url(array('',false),$file));
 }
function register_activation_hook ( $file,$function ) {
$file = plugin_basename($file);
add_action(concat1('activate_',$file),$function);
 }
function register_deactivation_hook ( $file,$function ) {
$file = plugin_basename($file);
add_action(concat1('deactivate_',$file),$function);
 }
function register_uninstall_hook ( $file,$callback ) {
$uninstallable_plugins = array_cast(get_option(array('uninstall_plugins',false)));
arrayAssign($uninstallable_plugins[0],deAspis(registerTaint(plugin_basename($file))),addTaint($callback));
update_option(array('uninstall_plugins',false),$uninstallable_plugins);
 }
function _wp_call_all_hook ( $args ) {
global $wp_filter;
Aspis_reset($wp_filter[0]['all']);
do {foreach ( deAspis(array_cast(Aspis_current($wp_filter[0]['all']))) as $the_  )
if ( (!(is_null(deAspisRC($the_[0]['function'])))))
 Aspis_call_user_func_array($the_[0]['function'],$args);
}while ((deAspis(Aspis_next($wp_filter[0]['all'])) !== false) )
;
 }
function _wp_filter_build_unique_id ( $tag,$function,$priority ) {
global $wp_filter;
static $filter_id_count = array(0,false);
if ( is_string(deAspisRC($function)))
 {return $function;
}else 
{if ( is_object(deAspis(attachAspis($function,(0)))))
 {if ( function_exists(('spl_object_hash')))
 {return concat1(spl_object_hash(deAspisRC(attachAspis($function,(0)))),attachAspis($function,(1)));
}else 
{{$obj_idx = concat(attAspis(get_class(deAspisRC(attachAspis($function,(0))))),attachAspis($function,(1)));
if ( (!((isset($function[0][(0)][0]->wp_filter_id) && Aspis_isset( $function [0][(0)][0] ->wp_filter_id )))))
 {if ( (false === $priority[0]))
 return array(false,false);
$obj_idx = concat($obj_idx,((isset($wp_filter[0][$tag[0]][0][$priority[0]]) && Aspis_isset( $wp_filter [0][$tag[0]] [0][$priority[0]]))) ? attAspis(count(deAspis(array_cast(attachAspis($wp_filter[0][$tag[0]],$priority[0]))))) : $filter_id_count);
$function[0][(0)][0]->wp_filter_id = $filter_id_count;
preincr($filter_id_count);
}else 
{{$obj_idx = concat($obj_idx,$function[0][(0)][0]->wp_filter_id);
}}return $obj_idx;
}}}else 
{if ( is_string(deAspisRC(attachAspis($function,(0)))))
 {return concat(attachAspis($function,(0)),attachAspis($function,(1)));
}}} }
;
?>
<?php 