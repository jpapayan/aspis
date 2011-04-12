<?php require_once('AspisMain.php'); ?><?php
function add_metadata ( $meta_type,$object_id,$meta_key,$meta_value,$unique = false ) {
if ( !$meta_type || !$meta_key)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$table = _get_meta_table($meta_type))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$column = deAspisWarningRC(esc_sql(array($meta_type . '_id',false)));
$meta_key = stripslashes($meta_key);
if ( $unique && $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE meta_key = %s AND $column = %d",$meta_key,$object_id)))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$meta_value = maybe_serialize(stripslashes_deep($meta_value));
$wpdb->insert($table,array($column => $object_id,'meta_key' => $meta_key,'meta_value' => $meta_value));
wp_cache_delete($object_id,$meta_type . '_meta');
do_action("added_{$meta_type}_meta",$wpdb->insert_id,$object_id,$meta_key,$meta_value);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function update_metadata ( $meta_type,$object_id,$meta_key,$meta_value,$prev_value = '' ) {
if ( !$meta_type || !$meta_key)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$table = _get_meta_table($meta_type))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$column = deAspisWarningRC(esc_sql(array($meta_type . '_id',false)));
$id_column = 'user' == $meta_type ? 'umeta_id' : 'meta_id';
$meta_key = stripslashes($meta_key);
if ( !$meta_id = $wpdb->get_var($wpdb->prepare("SELECT $id_column FROM $table WHERE meta_key = %s AND $column = %d",$meta_key,$object_id)))
 {$AspisRetTemp = add_metadata($meta_type,$object_id,$meta_key,$meta_value);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$meta_value = maybe_serialize(stripslashes_deep($meta_value));
$data = compact('meta_value');
$where = array($column => $object_id,'meta_key' => $meta_key);
if ( !empty($prev_value))
 {$prev_value = maybe_serialize($prev_value);
$where['meta_value'] = $prev_value;
}do_action("update_{$meta_type}_meta",$meta_id,$object_id,$meta_key,$meta_value);
$wpdb->update($table,$data,$where);
wp_cache_delete($object_id,$meta_type . '_meta');
do_action("updated_{$meta_type}_meta",$meta_id,$object_id,$meta_key,$meta_value);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function delete_metadata ( $meta_type,$object_id,$meta_key,$meta_value = '',$delete_all = false ) {
if ( !$meta_type || !$meta_key || (!$delete_all && !(int)$object_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$table = _get_meta_table($meta_type))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$type_column = deAspisWarningRC(esc_sql(array($meta_type . '_id',false)));
$id_column = 'user' == $meta_type ? 'umeta_id' : 'meta_id';
$meta_key = stripslashes($meta_key);
$meta_value = maybe_serialize(stripslashes_deep($meta_value));
$query = $wpdb->prepare("SELECT $id_column FROM $table WHERE meta_key = %s",$meta_key);
if ( !$delete_all)
 $query .= $wpdb->prepare(" AND $type_column = %d",$object_id);
if ( $meta_value)
 $query .= $wpdb->prepare(" AND meta_value = %s",$meta_value);
$meta_ids = $wpdb->get_col($query);
if ( !count($meta_ids))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$query = "DELETE FROM $table WHERE $id_column IN( " . implode(',',$meta_ids) . " )";
$count = $wpdb->query($query);
if ( !$count)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}wp_cache_delete($object_id,$meta_type . '_meta');
do_action("deleted_{$meta_type}_meta",$meta_ids,$object_id,$meta_key,$meta_value);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_metadata ( $meta_type,$object_id,$meta_key = '',$single = false ) {
if ( !$meta_type)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$meta_cache = wp_cache_get($object_id,$meta_type . '_meta');
if ( !$meta_cache)
 {update_meta_cache($meta_type,$object_id);
$meta_cache = wp_cache_get($object_id,$meta_type . '_meta');
}if ( !$meta_key)
 {$AspisRetTemp = $meta_cache;
return $AspisRetTemp;
}if ( isset($meta_cache[$meta_key]))
 {if ( $single)
 {{$AspisRetTemp = maybe_unserialize($meta_cache[$meta_key][0]);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = array_map('maybe_unserialize',$meta_cache[$meta_key]);
return $AspisRetTemp;
}}}}if ( $single)
 {$AspisRetTemp = '';
return $AspisRetTemp;
}else 
{{$AspisRetTemp = array();
return $AspisRetTemp;
}} }
function update_meta_cache ( $meta_type,$object_ids ) {
if ( empty($meta_type) || empty($object_ids))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$table = _get_meta_table($meta_type))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$column = deAspisWarningRC(esc_sql(array($meta_type . '_id',false)));
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !is_array($object_ids))
 {$object_ids = preg_replace('|[^0-9,]|','',$object_ids);
$object_ids = explode(',',$object_ids);
}$object_ids = array_map('intval',$object_ids);
$cache_key = $meta_type . '_meta';
$ids = array();
foreach ( $object_ids as $id  )
{if ( false === wp_cache_get($id,$cache_key))
 $ids[] = $id;
}if ( empty($ids))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$id_list = join(',',$ids);
$cache = array();
$meta_list = $wpdb->get_results($wpdb->prepare("SELECT $column, meta_key, meta_value FROM $table WHERE $column IN ($id_list)",$meta_type),ARRAY_A);
if ( !empty($meta_list))
 {foreach ( $meta_list as $metarow  )
{$mpid = intval($metarow[$column]);
$mkey = $metarow['meta_key'];
$mval = $metarow['meta_value'];
if ( !isset($cache[$mpid]) || !is_array($cache[$mpid]))
 $cache[$mpid] = array();
if ( !isset($cache[$mpid][$mkey]) || !is_array($cache[$mpid][$mkey]))
 $cache[$mpid][$mkey] = array();
$cache[$mpid][$mkey][] = $mval;
}}foreach ( $ids as $id  )
{if ( !isset($cache[$id]))
 $cache[$id] = array();
}foreach ( array_keys($cache) as $object  )
wp_cache_set($object,$cache[$object],$cache_key);
{$AspisRetTemp = $cache;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function _get_meta_table ( $type ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$table_name = $type . 'meta';
if ( empty($wpdb->$table_name))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $wpdb->$table_name;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
;
?>
<?php 