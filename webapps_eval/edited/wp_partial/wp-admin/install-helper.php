<?php require_once('AspisMain.php'); ?><?php
$wp_only_load_config = true;
require_once (dirname(dirname(__FILE__)) . '/wp-load.php');
$debug = 0;
if ( !function_exists('maybe_create_table'))
 {function maybe_create_table ( $table_name,$create_ddl ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}foreach ( $wpdb->get_col("SHOW TABLES",0) as $table  )
{if ( $table == $table_name)
 {{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}$wpdb->query($create_ddl);
foreach ( $wpdb->get_col("SHOW TABLES",0) as $table  )
{if ( $table == $table_name)
 {{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
}if ( !function_exists('maybe_add_column'))
 {function maybe_add_column ( $table_name,$column_name,$create_ddl ) {
{global $wpdb,$debug;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($debug,"\$debug",$AspisChangesCache);
}foreach ( $wpdb->get_col("DESC $table_name",0) as $column  )
{if ( $debug)
 echo ("checking $column == $column_name<br />");
if ( $column == $column_name)
 {{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}}}$wpdb->query($create_ddl);
foreach ( $wpdb->get_col("DESC $table_name",0) as $column  )
{if ( $column == $column_name)
 {{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
 }
}function maybe_drop_column ( $table_name,$column_name,$drop_ddl ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}foreach ( $wpdb->get_col("DESC $table_name",0) as $column  )
{if ( $column == $column_name)
 {$wpdb->query($drop_ddl);
foreach ( $wpdb->get_col("DESC $table_name",0) as $column  )
{if ( $column == $column_name)
 {{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}}}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function check_column ( $table_name,$col_name,$col_type,$is_null = null,$key = null,$default = null,$extra = null ) {
{global $wpdb,$debug;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($debug,"\$debug",$AspisChangesCache);
}$diffs = 0;
$results = $wpdb->get_results("DESC $table_name");
foreach ( $results as $row  )
{if ( $debug > 1)
 print_r($row);
if ( $row->Field == $col_name)
 {if ( $debug)
 echo ("checking $row->Type against $col_type\n");
if ( ($col_type != null) && ($row->Type != $col_type))
 {++$diffs;
}if ( ($is_null != null) && ($row->Null != $is_null))
 {++$diffs;
}if ( ($key != null) && ($row->Key != $key))
 {++$diffs;
}if ( ($default != null) && ($row->Default != $default))
 {++$diffs;
}if ( ($extra != null) && ($row->Extra != $extra))
 {++$diffs;
}if ( $diffs > 0)
 {if ( $debug)
 echo ("diffs = $diffs returning false\n");
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
 }
;
?>
<?php 