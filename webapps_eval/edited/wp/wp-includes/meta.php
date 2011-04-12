<?php require_once('AspisMain.php'); ?><?php
function add_metadata ( $meta_type,$object_id,$meta_key,$meta_value,$unique = array(false,false) ) {
if ( ((denot_boolean($meta_type)) || (denot_boolean($meta_key))))
 return array(false,false);
if ( (denot_boolean($table = _get_meta_table($meta_type))))
 return array(false,false);
global $wpdb;
$column = esc_sql(concat2($meta_type,'_id'));
$meta_key = Aspis_stripslashes($meta_key);
if ( ($unique[0] && deAspis($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat(concat2(concat1("SELECT COUNT(*) FROM ",$table)," WHERE meta_key = %s AND "),$column)," = %d"),$meta_key,$object_id)))))
 return array(false,false);
$meta_value = maybe_serialize(stripslashes_deep($meta_value));
$wpdb[0]->insert($table,array(array(deregisterTaint($column) => addTaint($object_id),deregisterTaint(array('meta_key',false)) => addTaint($meta_key),deregisterTaint(array('meta_value',false)) => addTaint($meta_value)),false));
wp_cache_delete($object_id,concat2($meta_type,'_meta'));
do_action(concat2(concat1("added_",$meta_type),"_meta"),$wpdb[0]->insert_id,$object_id,$meta_key,$meta_value);
return array(true,false);
 }
function update_metadata ( $meta_type,$object_id,$meta_key,$meta_value,$prev_value = array('',false) ) {
if ( ((denot_boolean($meta_type)) || (denot_boolean($meta_key))))
 return array(false,false);
if ( (denot_boolean($table = _get_meta_table($meta_type))))
 return array(false,false);
global $wpdb;
$column = esc_sql(concat2($meta_type,'_id'));
$id_column = (('user') == $meta_type[0]) ? array('umeta_id',false) : array('meta_id',false);
$meta_key = Aspis_stripslashes($meta_key);
if ( (denot_boolean($meta_id = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat(concat2(concat(concat2(concat1("SELECT ",$id_column)," FROM "),$table)," WHERE meta_key = %s AND "),$column)," = %d"),$meta_key,$object_id)))))
 return add_metadata($meta_type,$object_id,$meta_key,$meta_value);
$meta_value = maybe_serialize(stripslashes_deep($meta_value));
$data = array(compact('meta_value'),false);
$where = array(array(deregisterTaint($column) => addTaint($object_id),deregisterTaint(array('meta_key',false)) => addTaint($meta_key)),false);
if ( (!((empty($prev_value) || Aspis_empty( $prev_value)))))
 {$prev_value = maybe_serialize($prev_value);
arrayAssign($where[0],deAspis(registerTaint(array('meta_value',false))),addTaint($prev_value));
}do_action(concat2(concat1("update_",$meta_type),"_meta"),$meta_id,$object_id,$meta_key,$meta_value);
$wpdb[0]->update($table,$data,$where);
wp_cache_delete($object_id,concat2($meta_type,'_meta'));
do_action(concat2(concat1("updated_",$meta_type),"_meta"),$meta_id,$object_id,$meta_key,$meta_value);
return array(true,false);
 }
function delete_metadata ( $meta_type,$object_id,$meta_key,$meta_value = array('',false),$delete_all = array(false,false) ) {
if ( (((denot_boolean($meta_type)) || (denot_boolean($meta_key))) || ((denot_boolean($delete_all)) && (denot_boolean(int_cast($object_id))))))
 return array(false,false);
if ( (denot_boolean($table = _get_meta_table($meta_type))))
 return array(false,false);
global $wpdb;
$type_column = esc_sql(concat2($meta_type,'_id'));
$id_column = (('user') == $meta_type[0]) ? array('umeta_id',false) : array('meta_id',false);
$meta_key = Aspis_stripslashes($meta_key);
$meta_value = maybe_serialize(stripslashes_deep($meta_value));
$query = $wpdb[0]->prepare(concat2(concat(concat2(concat1("SELECT ",$id_column)," FROM "),$table)," WHERE meta_key = %s"),$meta_key);
if ( (denot_boolean($delete_all)))
 $query = concat($query,$wpdb[0]->prepare(concat2(concat1(" AND ",$type_column)," = %d"),$object_id));
if ( $meta_value[0])
 $query = concat($query,$wpdb[0]->prepare(array(" AND meta_value = %s",false),$meta_value));
$meta_ids = $wpdb[0]->get_col($query);
if ( (!(count($meta_ids[0]))))
 return array(false,false);
$query = concat2(concat(concat2(concat(concat2(concat1("DELETE FROM ",$table)," WHERE "),$id_column)," IN( "),Aspis_implode(array(',',false),$meta_ids))," )");
$count = $wpdb[0]->query($query);
if ( (denot_boolean($count)))
 return array(false,false);
wp_cache_delete($object_id,concat2($meta_type,'_meta'));
do_action(concat2(concat1("deleted_",$meta_type),"_meta"),$meta_ids,$object_id,$meta_key,$meta_value);
return array(true,false);
 }
function get_metadata ( $meta_type,$object_id,$meta_key = array('',false),$single = array(false,false) ) {
if ( (denot_boolean($meta_type)))
 return array(false,false);
$meta_cache = wp_cache_get($object_id,concat2($meta_type,'_meta'));
if ( (denot_boolean($meta_cache)))
 {update_meta_cache($meta_type,$object_id);
$meta_cache = wp_cache_get($object_id,concat2($meta_type,'_meta'));
}if ( (denot_boolean($meta_key)))
 return $meta_cache;
if ( ((isset($meta_cache[0][$meta_key[0]]) && Aspis_isset( $meta_cache [0][$meta_key[0]]))))
 {if ( $single[0])
 {return maybe_unserialize(attachAspis($meta_cache[0][$meta_key[0]],(0)));
}else 
{{return attAspisRC(array_map(AspisInternalCallback(array('maybe_unserialize',false)),deAspisRC(attachAspis($meta_cache,$meta_key[0]))));
}}}if ( $single[0])
 return array('',false);
else 
{return array(array(),false);
} }
function update_meta_cache ( $meta_type,$object_ids ) {
if ( (((empty($meta_type) || Aspis_empty( $meta_type))) || ((empty($object_ids) || Aspis_empty( $object_ids)))))
 return array(false,false);
if ( (denot_boolean($table = _get_meta_table($meta_type))))
 return array(false,false);
$column = esc_sql(concat2($meta_type,'_id'));
global $wpdb;
if ( (!(is_array($object_ids[0]))))
 {$object_ids = Aspis_preg_replace(array('|[^0-9,]|',false),array('',false),$object_ids);
$object_ids = Aspis_explode(array(',',false),$object_ids);
}$object_ids = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC($object_ids)));
$cache_key = concat2($meta_type,'_meta');
$ids = array(array(),false);
foreach ( $object_ids[0] as $id  )
{if ( (false === deAspis(wp_cache_get($id,$cache_key))))
 arrayAssignAdd($ids[0][],addTaint($id));
}if ( ((empty($ids) || Aspis_empty( $ids))))
 return array(false,false);
$id_list = Aspis_join(array(',',false),$ids);
$cache = array(array(),false);
$meta_list = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT ",$column),", meta_key, meta_value FROM "),$table)," WHERE "),$column)," IN ("),$id_list),")"),$meta_type),array(ARRAY_A,false));
if ( (!((empty($meta_list) || Aspis_empty( $meta_list)))))
 {foreach ( $meta_list[0] as $metarow  )
{$mpid = Aspis_intval(attachAspis($metarow,$column[0]));
$mkey = $metarow[0]['meta_key'];
$mval = $metarow[0]['meta_value'];
if ( ((!((isset($cache[0][$mpid[0]]) && Aspis_isset( $cache [0][$mpid[0]])))) || (!(is_array(deAspis(attachAspis($cache,$mpid[0])))))))
 arrayAssign($cache[0],deAspis(registerTaint($mpid)),addTaint(array(array(),false)));
if ( ((!((isset($cache[0][$mpid[0]][0][$mkey[0]]) && Aspis_isset( $cache [0][$mpid[0]] [0][$mkey[0]])))) || (!(is_array(deAspis(attachAspis($cache[0][$mpid[0]],$mkey[0])))))))
 arrayAssign($cache[0][$mpid[0]][0],deAspis(registerTaint($mkey)),addTaint(array(array(),false)));
arrayAssignAdd($cache[0][$mpid[0]][0][$mkey[0]][0][],addTaint($mval));
}}foreach ( $ids[0] as $id  )
{if ( (!((isset($cache[0][$id[0]]) && Aspis_isset( $cache [0][$id[0]])))))
 arrayAssign($cache[0],deAspis(registerTaint($id)),addTaint(array(array(),false)));
}foreach ( deAspis(attAspisRC(array_keys(deAspisRC($cache)))) as $object  )
wp_cache_set($object,attachAspis($cache,$object[0]),$cache_key);
return $cache;
 }
function _get_meta_table ( $type ) {
global $wpdb;
$table_name = concat2($type,'meta');
if ( ((empty($wpdb[0]->$table_name[0]) || Aspis_empty( $wpdb[0] ->$table_name[0] ))))
 return array(false,false);
return $wpdb[0]->$table_name[0];
 }
;
?>
<?php 