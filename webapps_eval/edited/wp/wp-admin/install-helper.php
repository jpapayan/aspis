<?php require_once('AspisMain.php'); ?><?php
$wp_only_load_config = array(true,false);
require_once (deconcat2(Aspis_dirname(Aspis_dirname(array(__FILE__,false))),'/wp-load.php'));
$debug = array(0,false);
if ( (!(function_exists(('maybe_create_table')))))
 {function maybe_create_table ( $table_name,$create_ddl ) {
global $wpdb;
foreach ( deAspis($wpdb[0]->get_col(array("SHOW TABLES",false),array(0,false))) as $table  )
{if ( ($table[0] == $table_name[0]))
 {return array(true,false);
}}$wpdb[0]->query($create_ddl);
foreach ( deAspis($wpdb[0]->get_col(array("SHOW TABLES",false),array(0,false))) as $table  )
{if ( ($table[0] == $table_name[0]))
 {return array(true,false);
}}return array(false,false);
 }
}if ( (!(function_exists(('maybe_add_column')))))
 {function maybe_add_column ( $table_name,$column_name,$create_ddl ) {
global $wpdb,$debug;
foreach ( deAspis($wpdb[0]->get_col(concat1("DESC ",$table_name),array(0,false))) as $column  )
{if ( $debug[0])
 echo AspisCheckPrint((concat2(concat(concat2(concat1("checking ",$column)," == "),$column_name),"<br />")));
if ( ($column[0] == $column_name[0]))
 {return array(true,false);
}}$wpdb[0]->query($create_ddl);
foreach ( deAspis($wpdb[0]->get_col(concat1("DESC ",$table_name),array(0,false))) as $column  )
{if ( ($column[0] == $column_name[0]))
 {return array(true,false);
}}return array(false,false);
 }
}function maybe_drop_column ( $table_name,$column_name,$drop_ddl ) {
global $wpdb;
foreach ( deAspis($wpdb[0]->get_col(concat1("DESC ",$table_name),array(0,false))) as $column  )
{if ( ($column[0] == $column_name[0]))
 {$wpdb[0]->query($drop_ddl);
foreach ( deAspis($wpdb[0]->get_col(concat1("DESC ",$table_name),array(0,false))) as $column  )
{if ( ($column[0] == $column_name[0]))
 {return array(false,false);
}}}}return array(true,false);
 }
function check_column ( $table_name,$col_name,$col_type,$is_null = array(null,false),$key = array(null,false),$default = array(null,false),$extra = array(null,false) ) {
global $wpdb,$debug;
$diffs = array(0,false);
$results = $wpdb[0]->get_results(concat1("DESC ",$table_name));
foreach ( $results[0] as $row  )
{if ( ($debug[0] > (1)))
 Aspis_print_r($row);
if ( ($row[0]->Field[0] == $col_name[0]))
 {if ( $debug[0])
 echo AspisCheckPrint((concat2(concat(concat2(concat1("checking ",$row[0]->Type)," against "),$col_type),"\n")));
if ( (($col_type[0] != null) && ($row[0]->Type[0] != $col_type[0])))
 {preincr($diffs);
}if ( (($is_null[0] != null) && ($row[0]->Null[0] != $is_null[0])))
 {preincr($diffs);
}if ( (($key[0] != null) && ($row[0]->Key[0] != $key[0])))
 {preincr($diffs);
}if ( (($default[0] != null) && ($row[0]->Default[0] != $default[0])))
 {preincr($diffs);
}if ( (($extra[0] != null) && ($row[0]->Extra[0] != $extra[0])))
 {preincr($diffs);
}if ( ($diffs[0] > (0)))
 {if ( $debug[0])
 echo AspisCheckPrint((concat2(concat1("diffs = ",$diffs)," returning false\n")));
return array(false,false);
}return array(true,false);
}}return array(false,false);
 }
;
?>
<?php 