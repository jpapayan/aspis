<?php require_once('AspisMain.php'); ?><?php
function add_filter ( $tag,$function_to_add,$priority = 10,$accepted_args = 1 ) {
{global $wp_filter,$merged_filters;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filter,"\$wp_filter",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($merged_filters,"\$merged_filters",$AspisChangesCache);
}$idx = _wp_filter_build_unique_id($tag,$function_to_add,$priority);
$wp_filter[$tag][$priority][$idx] = array('function' => $function_to_add,'accepted_args' => $accepted_args);
unset($merged_filters[$tag]);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$merged_filters",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$merged_filters",$AspisChangesCache);
 }
function has_filter ( $tag,$function_to_check = false ) {
{global $wp_filter;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filter,"\$wp_filter",$AspisChangesCache);
}$has = !empty($wp_filter[$tag]);
if ( false === $function_to_check || false == $has)
 {$AspisRetTemp = $has;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
return $AspisRetTemp;
}if ( !$idx = _wp_filter_build_unique_id($tag,$function_to_check,false))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
return $AspisRetTemp;
}foreach ( (array)array_keys($wp_filter[$tag]) as $priority  )
{if ( isset($wp_filter[$tag][$priority][$idx]))
 {$AspisRetTemp = $priority;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
 }
function apply_filters ( $tag,$value ) {
{global $wp_filter,$merged_filters,$wp_current_filter;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filter,"\$wp_filter",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($merged_filters,"\$merged_filters",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_current_filter,"\$wp_current_filter",$AspisChangesCache);
}$args = array();
$wp_current_filter[] = $tag;
if ( isset($wp_filter['all']))
 {$args = func_get_args();
_wp_call_all_hook($args);
}if ( !isset($wp_filter[$tag]))
 {array_pop($wp_current_filter);
{$AspisRetTemp = $value;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$merged_filters",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_current_filter",$AspisChangesCache);
return $AspisRetTemp;
}}if ( !isset($merged_filters[$tag]))
 {ksort($wp_filter[$tag]);
$merged_filters[$tag] = true;
}reset($wp_filter[$tag]);
if ( empty($args))
 $args = func_get_args();
do {foreach ( (array)current($wp_filter[$tag]) as $the_  )
if ( !is_null($the_['function']))
 {$args[1] = $value;
$value = AspisUntainted_call_user_func_array($the_['function'],array_slice($args,1,(int)$the_['accepted_args']));
}}while (next($wp_filter[$tag]) !== false )
;
array_pop($wp_current_filter);
{$AspisRetTemp = $value;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$merged_filters",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_current_filter",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$merged_filters",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_current_filter",$AspisChangesCache);
 }
function apply_filters2 ( $tag,$value ) {
{global $wp_filter,$merged_filters,$wp_current_filter;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filter,"\$wp_filter",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($merged_filters,"\$merged_filters",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_current_filter,"\$wp_current_filter",$AspisChangesCache);
}$args = array();
$wp_current_filter[] = $tag;
if ( isset($wp_filter['all']))
 {$args = func_get_args();
_wp_call_all_hook($args);
}if ( !isset($wp_filter[$tag]))
 {array_pop($wp_current_filter);
{$AspisRetTemp = $value;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$merged_filters",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_current_filter",$AspisChangesCache);
return $AspisRetTemp;
}}if ( !isset($merged_filters[$tag]))
 {ksort($wp_filter[$tag]);
$merged_filters[$tag] = true;
}reset($wp_filter[$tag]);
if ( empty($args))
 $args = func_get_args();
do {foreach ( (array)current($wp_filter[$tag]) as $the_  )
if ( !is_null($the_['function']))
 {$args[1] = $value;
$value = AspisUntainted_call_user_func_array($the_['function'],array_slice($args,1,(int)$the_['accepted_args']));
}}while (next($wp_filter[$tag]) !== false )
;
array_pop($wp_current_filter);
{$AspisRetTemp = $value;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$merged_filters",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_current_filter",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$merged_filters",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_current_filter",$AspisChangesCache);
 }
function remove_filter ( $tag,$function_to_remove,$priority = 10,$accepted_args = 1 ) {
$function_to_remove = _wp_filter_build_unique_id($tag,$function_to_remove,$priority);
$r = isset($GLOBALS[0]['wp_filter'][$tag][$priority][$function_to_remove]);
if ( true === $r)
 {unset($GLOBALS[0]['wp_filter'][$tag][$priority][$function_to_remove]);
if ( empty($GLOBALS[0]['wp_filter'][$tag][$priority]))
 unset($GLOBALS[0]['wp_filter'][$tag][$priority]);
unset($GLOBALS[0]['merged_filters'][$tag]);
}{$AspisRetTemp = $r;
return $AspisRetTemp;
} }
function remove_all_filters ( $tag,$priority = false ) {
{global $wp_filter,$merged_filters;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filter,"\$wp_filter",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($merged_filters,"\$merged_filters",$AspisChangesCache);
}if ( isset($wp_filter[$tag]))
 {if ( false !== $priority && isset($$wp_filter[$tag][$priority]))
 unset($wp_filter[$tag][$priority]);
else 
{unset($wp_filter[$tag]);
}}if ( isset($merged_filters[$tag]))
 unset($merged_filters[$tag]);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$merged_filters",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$merged_filters",$AspisChangesCache);
 }
function current_filter (  ) {
{global $wp_current_filter;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_current_filter,"\$wp_current_filter",$AspisChangesCache);
}{$AspisRetTemp = end($wp_current_filter);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_filter",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_filter",$AspisChangesCache);
 }
function add_action ( $tag,$function_to_add,$priority = 10,$accepted_args = 1 ) {
{$AspisRetTemp = add_filter($tag,$function_to_add,$priority,$accepted_args);
return $AspisRetTemp;
} }
function do_action ( $tag,$arg = '' ) {
{global $wp_filter,$wp_actions,$merged_filters,$wp_current_filter;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filter,"\$wp_filter",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_actions,"\$wp_actions",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($merged_filters,"\$merged_filters",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($wp_current_filter,"\$wp_current_filter",$AspisChangesCache);
}if ( is_array($wp_actions))
 $wp_actions[] = $tag;
else 
{$wp_actions = array($tag);
}$wp_current_filter[] = $tag;
if ( isset($wp_filter['all']))
 {$all_args = func_get_args();
_wp_call_all_hook($all_args);
}if ( !isset($wp_filter[$tag]))
 {array_pop($wp_current_filter);
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_actions",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$merged_filters",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wp_current_filter",$AspisChangesCache);
return ;
}}$args = array();
if ( is_array($arg) && 1 == count($arg) && is_object($arg[0]))
 $args[] = &$arg[0];
else 
{$args[] = $arg;
}for ( $a = 2 ; $a < func_num_args() ; $a++ )
$args[] = func_get_arg($a);
if ( !isset($merged_filters[$tag]))
 {ksort($wp_filter[$tag]);
$merged_filters[$tag] = true;
}reset($wp_filter[$tag]);
do {foreach ( (array)current($wp_filter[$tag]) as $the_  )
if ( !is_null($the_['function']))
 AspisUntainted_call_user_func_array($the_['function'],array_slice($args,0,(int)$the_['accepted_args']));
}while (next($wp_filter[$tag]) !== false )
;
array_pop($wp_current_filter);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_actions",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$merged_filters",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wp_current_filter",$AspisChangesCache);
 }
function did_action ( $tag ) {
{global $wp_actions;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_actions,"\$wp_actions",$AspisChangesCache);
}if ( empty($wp_actions))
 {$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_actions",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = count(array_keys($wp_actions,$tag));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_actions",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_actions",$AspisChangesCache);
 }
function do_action_ref_array ( $tag,$args ) {
{global $wp_filter,$wp_actions,$merged_filters,$wp_current_filter;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filter,"\$wp_filter",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_actions,"\$wp_actions",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($merged_filters,"\$merged_filters",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($wp_current_filter,"\$wp_current_filter",$AspisChangesCache);
}if ( !is_array($wp_actions))
 $wp_actions = array($tag);
else 
{$wp_actions[] = $tag;
}$wp_current_filter[] = $tag;
if ( isset($wp_filter['all']))
 {$all_args = func_get_args();
_wp_call_all_hook($all_args);
}if ( !isset($wp_filter[$tag]))
 {array_pop($wp_current_filter);
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_actions",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$merged_filters",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wp_current_filter",$AspisChangesCache);
return ;
}}if ( !isset($merged_filters[$tag]))
 {ksort($wp_filter[$tag]);
$merged_filters[$tag] = true;
}reset($wp_filter[$tag]);
do {foreach ( (array)current($wp_filter[$tag]) as $the_  )
if ( !is_null($the_['function']))
 AspisUntainted_call_user_func_array($the_['function'],array_slice($args,0,(int)$the_['accepted_args']));
}while (next($wp_filter[$tag]) !== false )
;
array_pop($wp_current_filter);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_actions",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$merged_filters",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wp_current_filter",$AspisChangesCache);
 }
function has_action ( $tag,$function_to_check = false ) {
{$AspisRetTemp = has_filter($tag,$function_to_check);
return $AspisRetTemp;
} }
function remove_action ( $tag,$function_to_remove,$priority = 10,$accepted_args = 1 ) {
{$AspisRetTemp = remove_filter($tag,$function_to_remove,$priority,$accepted_args);
return $AspisRetTemp;
} }
function remove_all_actions ( $tag,$priority = false ) {
{$AspisRetTemp = remove_all_filters($tag,$priority);
return $AspisRetTemp;
} }
function plugin_basename ( $file ) {
$file = str_replace('\\','/',$file);
$file = preg_replace('|/+|','/',$file);
$plugin_dir = str_replace('\\','/',WP_PLUGIN_DIR);
$plugin_dir = preg_replace('|/+|','/',$plugin_dir);
$mu_plugin_dir = str_replace('\\','/',WPMU_PLUGIN_DIR);
$mu_plugin_dir = preg_replace('|/+|','/',$mu_plugin_dir);
$file = preg_replace('#^' . preg_quote($plugin_dir,'#') . '/|^' . preg_quote($mu_plugin_dir,'#') . '/#','',$file);
$file = trim($file,'/');
{$AspisRetTemp = $file;
return $AspisRetTemp;
} }
function plugin_dir_path ( $file ) {
{$AspisRetTemp = trailingslashit(dirname($file));
return $AspisRetTemp;
} }
function plugin_dir_url ( $file ) {
{$AspisRetTemp = trailingslashit(plugins_url('',$file));
return $AspisRetTemp;
} }
function register_activation_hook ( $file,$function ) {
$file = plugin_basename($file);
add_action('activate_' . $file,$function);
 }
function register_deactivation_hook ( $file,$function ) {
$file = plugin_basename($file);
add_action('deactivate_' . $file,$function);
 }
function register_uninstall_hook ( $file,$callback ) {
$uninstallable_plugins = (array)get_option('uninstall_plugins');
$uninstallable_plugins[plugin_basename($file)] = $callback;
update_option('uninstall_plugins',$uninstallable_plugins);
 }
function _wp_call_all_hook ( $args ) {
{global $wp_filter;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filter,"\$wp_filter",$AspisChangesCache);
}reset($wp_filter['all']);
do {foreach ( (array)current($wp_filter['all']) as $the_  )
if ( !is_null($the_['function']))
 AspisUntainted_call_user_func_array($the_['function'],$args);
}while (next($wp_filter['all']) !== false )
;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
 }
function _wp_filter_build_unique_id ( $tag,$function,$priority ) {
{global $wp_filter;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filter,"\$wp_filter",$AspisChangesCache);
}static $filter_id_count = 0;
if ( is_string($function))
 {{$AspisRetTemp = $function;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{if ( is_object($function[0]))
 {if ( function_exists('spl_object_hash'))
 {{$AspisRetTemp = spl_object_hash($function[0]) . $function[1];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{$obj_idx = get_class($function[0]) . $function[1];
if ( !isset($function[0]->wp_filter_id))
 {if ( false === $priority)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
return $AspisRetTemp;
}$obj_idx .= isset($wp_filter[$tag][$priority]) ? count((array)$wp_filter[$tag][$priority]) : $filter_id_count;
$function[0]->wp_filter_id = $filter_id_count;
++$filter_id_count;
}else 
{{$obj_idx .= $function[0]->wp_filter_id;
}}{$AspisRetTemp = $obj_idx;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
return $AspisRetTemp;
}}}}else 
{if ( is_string($function[0]))
 {{$AspisRetTemp = $function[0] . $function[1];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
return $AspisRetTemp;
}}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filter",$AspisChangesCache);
 }
;
?>
<?php 