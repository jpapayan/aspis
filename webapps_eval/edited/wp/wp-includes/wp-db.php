<?php require_once('AspisMain.php'); ?><?php
define(('EZSQL_VERSION'),'WP1.25');
define(('OBJECT'),'OBJECT',true);
define(('OBJECT_K'),'OBJECT_K',false);
define(('ARRAY_A'),'ARRAY_A',false);
define(('ARRAY_N'),'ARRAY_N',false);
class wpdb{var $show_errors = array(false,false);
var $suppress_errors = array(false,false);
var $last_error = array('',false);
var $num_queries = array(0,false);
var $last_query;
var $col_info;
var $queries;
var $prefix = array('',false);
var $ready = array(false,false);
var $posts;
var $users;
var $categories;
var $post2cat;
var $comments;
var $links;
var $options;
var $postmeta;
var $commentmeta;
var $usermeta;
var $terms;
var $term_taxonomy;
var $term_relationships;
var $tables = array(array(array('users',false),array('usermeta',false),array('posts',false),array('categories',false),array('post2cat',false),array('comments',false),array('links',false),array('link2cat',false),array('options',false),array('postmeta',false),array('terms',false),array('term_taxonomy',false),array('term_relationships',false),array('commentmeta',false)),false);
var $old_tables = array(array(array('categories',false),array('post2cat',false),array('link2cat',false)),false);
var $field_types = array(array(),false);
var $charset;
var $collate;
var $real_escape = array(false,false);
var $dbuser;
function wpdb ( $dbuser,$dbpassword,$dbname,$dbhost ) {
{return $this->__construct($dbuser,$dbpassword,$dbname,$dbhost);
} }
function __construct ( $dbuser,$dbpassword,$dbname,$dbhost ) {
{register_shutdown_function(AspisInternalCallback(array(array(array($this,false),array("__destruct",false)),false)));
if ( WP_DEBUG)
 $this->show_errors();
if ( defined(('DB_CHARSET')))
 $this->charset = array(DB_CHARSET,false);
if ( defined(('DB_COLLATE')))
 $this->collate = array(DB_COLLATE,false);
$this->dbuser = $dbuser;
$this->dbh = @attAspis(mysql_connect($dbhost[0],$dbuser[0],$dbpassword[0],true));
if ( (denot_boolean($this->dbh)))
 {$this->bail(Aspis_sprintf(array("
<h1>Error establishing a database connection</h1>
<p>This either means that the username and password information in your <code>wp-config.php</code> file is incorrect or we can't contact the database server at <code>%s</code>. This could mean your host's database server is down.</p>
<ul>
	<li>Are you sure you have the correct username and password?</li>
	<li>Are you sure that you have typed the correct hostname?</li>
	<li>Are you sure that the database server is running?</li>
</ul>
<p>If you're unsure what these terms mean you should probably contact your host. If you still need help you can always visit the <a href='http://wordpress.org/support/'>WordPress Support Forums</a>.</p>
",false),$dbhost),array('db_connect_fail',false));
return ;
}$this->ready = array(true,false);
if ( (deAspis($this->has_cap(array('collation',false))) && (!((empty($this->charset) || Aspis_empty( $this ->charset ))))))
 {if ( function_exists(('mysql_set_charset')))
 {mysql_set_charset(deAspisRC($this->charset),deAspisRC($this->dbh));
$this->real_escape = array(true,false);
}else 
{{$collation_query = concat2(concat1("SET NAMES '",$this->charset),"'");
if ( (!((empty($this->collate) || Aspis_empty( $this ->collate )))))
 $collation_query = concat($collation_query,concat2(concat1(" COLLATE '",$this->collate),"'"));
$this->query($collation_query);
}}}$this->select($dbname);
} }
function __destruct (  ) {
{return array(true,false);
} }
function set_prefix ( $prefix ) {
{if ( deAspis(Aspis_preg_match(array('|[^a-z0-9_]|i',false),$prefix)))
 return array(new WP_Error(array('invalid_db_prefix',false),array('Invalid database prefix',false)),false);
$old_prefix = $this->prefix;
$this->prefix = $prefix;
foreach ( deAspis(array_cast($this->tables)) as $table  )
{$this->$table[0] = concat($this->prefix,$table);
}if ( defined(('CUSTOM_USER_TABLE')))
 $this->users = array(CUSTOM_USER_TABLE,false);
if ( defined(('CUSTOM_USER_META_TABLE')))
 $this->usermeta = array(CUSTOM_USER_META_TABLE,false);
return $old_prefix;
} }
function select ( $db ) {
{if ( (denot_boolean(@attAspis(mysql_select_db($db[0],$this->dbh[0])))))
 {$this->ready = array(false,false);
$this->bail(Aspis_sprintf(array('
<h1>Can&#8217;t select database</h1>
<p>We were able to connect to the database server (which means your username and password is okay) but not able to select the <code>%1$s</code> database.</p>
<ul>
<li>Are you sure it exists?</li>
<li>Does the user <code>%2$s</code> have permission to use the <code>%1$s</code> database?</li>
<li>On some systems the name of your database is prefixed with your username, so it would be like <code>username_%1$s</code>. Could that be the problem?</li>
</ul>
<p>If you don\'t know how to setup a database you should <strong>contact your host</strong>. If all else fails you may find help at the <a href="http://wordpress.org/support/">WordPress Support Forums</a>.</p>',false),$db,$this->dbuser),array('db_select_fail',false));
return ;
}} }
function _weak_escape ( $string ) {
{return Aspis_addslashes($string);
} }
function _real_escape ( $string ) {
{if ( ($this->dbh[0] && $this->real_escape[0]))
 return Aspis_mysql_real_escape_string($string,$this->dbh);
else 
{return Aspis_addslashes($string);
}} }
function _escape ( $data ) {
{if ( is_array($data[0]))
 {foreach ( deAspis(array_cast($data)) as $k =>$v )
{restoreTaint($k,$v);
{if ( is_array($v[0]))
 arrayAssign($data[0],deAspis(registerTaint($k)),addTaint($this->_escape($v)));
else 
{arrayAssign($data[0],deAspis(registerTaint($k)),addTaint($this->_real_escape($v)));
}}}}else 
{{$data = $this->_real_escape($data);
}}return $data;
} }
function escape ( $data ) {
{if ( is_array($data[0]))
 {foreach ( deAspis(array_cast($data)) as $k =>$v )
{restoreTaint($k,$v);
{if ( is_array($v[0]))
 arrayAssign($data[0],deAspis(registerTaint($k)),addTaint($this->escape($v)));
else 
{arrayAssign($data[0],deAspis(registerTaint($k)),addTaint($this->_weak_escape($v)));
}}}}else 
{{$data = $this->_weak_escape($data);
}}return $data;
} }
function escape_by_ref ( &$string ) {
{$string = $this->_real_escape($string);
} }
function prepare ( $query = array(null,false) ) {
{if ( is_null(deAspisRC($query)))
 return ;
$args = array(func_get_args(),false);
Aspis_array_shift($args);
if ( (((isset($args[0][(0)]) && Aspis_isset( $args [0][(0)]))) && is_array(deAspis(attachAspis($args,(0))))))
 $args = attachAspis($args,(0));
$query = Aspis_str_replace(array("'%s'",false),array('%s',false),$query);
$query = Aspis_str_replace(array('"%s"',false),array('%s',false),$query);
$query = Aspis_str_replace(array('%s',false),array("'%s'",false),$query);
Aspis_array_walk($args,array(array(array($this,false),array('escape_by_ref',false)),false));
return @Aspis_vsprintf($query,$args);
} }
function print_error ( $str = array('',false) ) {
{global $EZSQL_ERROR;
if ( (denot_boolean($str)))
 $str = attAspis(mysql_error($this->dbh[0]));
arrayAssignAdd($EZSQL_ERROR[0][],addTaint(array(array(deregisterTaint(array('query',false)) => addTaint($this->last_query),deregisterTaint(array('error_str',false)) => addTaint($str)),false)));
if ( $this->suppress_errors[0])
 return array(false,false);
if ( deAspis($caller = $this->get_caller()))
 $error_str = Aspis_sprintf(array('WordPress database error %1$s for query %2$s made by %3$s',false),$str,$this->last_query,$caller);
else 
{$error_str = Aspis_sprintf(array('WordPress database error %1$s for query %2$s',false),$str,$this->last_query);
}$log_error = array(true,false);
if ( (!(function_exists(('error_log')))))
 $log_error = array(false,false);
$log_file = @array(ini_get('error_log'),false);
if ( (((!((empty($log_file) || Aspis_empty( $log_file)))) && (('syslog') != $log_file[0])) && (denot_boolean(@attAspis(is_writable($log_file[0]))))))
 $log_error = array(false,false);
if ( $log_error[0])
 @array(error_log(deAspisRC($error_str),0),false);
if ( (denot_boolean($this->show_errors)))
 return array(false,false);
$str = Aspis_htmlspecialchars($str,array(ENT_QUOTES,false));
$query = Aspis_htmlspecialchars($this->last_query,array(ENT_QUOTES,false));
print AspisCheckPrint(concat2(concat(concat2(concat1("<div id='error'>
		<p class='wpdberror'><strong>WordPress database error:</strong> [",$str),"]<br />
		<code>"),$query),"</code></p>
		</div>"));
} }
function show_errors ( $show = array(true,false) ) {
{$errors = $this->show_errors;
$this->show_errors = $show;
return $errors;
} }
function hide_errors (  ) {
{$show = $this->show_errors;
$this->show_errors = array(false,false);
return $show;
} }
function suppress_errors ( $suppress = array(true,false) ) {
{$errors = $this->suppress_errors;
$this->suppress_errors = $suppress;
return $errors;
} }
function flush (  ) {
{$this->last_result = array(array(),false);
$this->col_info = array(null,false);
$this->last_query = array(null,false);
} }
function query ( $query ) {
{if ( (denot_boolean($this->ready)))
 return array(false,false);
if ( function_exists(('apply_filters')))
 $query = apply_filters(array('query',false),$query);
$return_val = array(0,false);
$this->flush();
$this->func_call = concat1("\$db-",concat2(concat1(">query(\"",$query),"\")"));
$this->last_query = $query;
if ( (defined(('SAVEQUERIES')) && SAVEQUERIES))
 $this->timer_start();
$this->result = @attAspis(mysql_query($query[0],$this->dbh[0]));
preincr($this->num_queries);
if ( (defined(('SAVEQUERIES')) && SAVEQUERIES))
 arrayAssignAdd($this->queries[0][],addTaint(array(array($query,$this->timer_stop(),$this->get_caller()),false)));
if ( deAspis($this->last_error = attAspis(mysql_error($this->dbh[0]))))
 {$this->print_error();
return array(false,false);
}if ( deAspis(Aspis_preg_match(array("/^\\s*(insert|delete|update|replace|alter) /i",false),$query)))
 {$this->rows_affected = attAspis(mysql_affected_rows($this->dbh[0]));
if ( deAspis(Aspis_preg_match(array("/^\\s*(insert|replace) /i",false),$query)))
 {$this->insert_id = attAspis(mysql_insert_id($this->dbh[0]));
}$return_val = $this->rows_affected;
}else 
{{$i = array(0,false);
while ( ($i[0] < deAspis(@attAspis(mysql_num_fields($this->result[0])))) )
{arrayAssign($this->col_info[0],deAspis(registerTaint($i)),addTaint(@attAspisRC(mysql_fetch_field($this->result[0]),"mysql_fetch_field")));
postincr($i);
}$num_rows = array(0,false);
while ( deAspis($row = @attAspisRC(mysql_fetch_object($this->result[0]),"mysql_fetch_object")) )
{arrayAssign($this->last_result[0],deAspis(registerTaint($num_rows)),addTaint($row));
postincr($num_rows);
}@attAspis(mysql_free_result($this->result[0]));
$this->num_rows = $num_rows;
$return_val = $this->num_rows;
}}return $return_val;
} }
function insert ( $table,$data,$format = array(null,false) ) {
{$formats = $format = array_cast($format);
$fields = attAspisRC(array_keys(deAspisRC($data)));
$formatted_fields = array(array(),false);
foreach ( $fields[0] as $field  )
{if ( (!((empty($format) || Aspis_empty( $format)))))
 $form = deAspis(($form = Aspis_array_shift($formats))) ? $form : attachAspis($format,(0));
elseif ( ((isset($this->field_types[0][$field[0]]) && Aspis_isset( $this ->field_types [0][$field[0]] ))))
 $form = $this->field_types[0][$field[0]];
else 
{$form = array('%s',false);
}arrayAssignAdd($formatted_fields[0][],addTaint($form));
}$sql = concat2(concat(concat2(concat(concat2(concat1("INSERT INTO `",$table),"` (`"),Aspis_implode(array('`,`',false),$fields)),"`) VALUES ('"),Aspis_implode(array("','",false),$formatted_fields)),"')");
return $this->query($this->prepare($sql,$data));
} }
function update ( $table,$data,$where,$format = array(null,false),$where_format = array(null,false) ) {
{if ( (!(is_array($where[0]))))
 return array(false,false);
$formats = $format = array_cast($format);
$bits = $wheres = array(array(),false);
foreach ( deAspis(array_cast(attAspisRC(array_keys(deAspisRC($data))))) as $field  )
{if ( (!((empty($format) || Aspis_empty( $format)))))
 $form = deAspis(($form = Aspis_array_shift($formats))) ? $form : attachAspis($format,(0));
elseif ( ((isset($this->field_types[0][$field[0]]) && Aspis_isset( $this ->field_types [0][$field[0]] ))))
 $form = $this->field_types[0][$field[0]];
else 
{$form = array('%s',false);
}arrayAssignAdd($bits[0][],addTaint(concat(concat2(concat1("`",$field),"` = "),$form)));
}$where_formats = $where_format = array_cast($where_format);
foreach ( deAspis(array_cast(attAspisRC(array_keys(deAspisRC($where))))) as $field  )
{if ( (!((empty($where_format) || Aspis_empty( $where_format)))))
 $form = deAspis(($form = Aspis_array_shift($where_formats))) ? $form : attachAspis($where_format,(0));
elseif ( ((isset($this->field_types[0][$field[0]]) && Aspis_isset( $this ->field_types [0][$field[0]] ))))
 $form = $this->field_types[0][$field[0]];
else 
{$form = array('%s',false);
}arrayAssignAdd($wheres[0][],addTaint(concat(concat2(concat1("`",$field),"` = "),$form)));
}$sql = concat(concat2(concat(concat2(concat1("UPDATE `",$table),"` SET "),Aspis_implode(array(', ',false),$bits)),' WHERE '),Aspis_implode(array(' AND ',false),$wheres));
return $this->query($this->prepare($sql,Aspis_array_merge(Aspis_array_values($data),Aspis_array_values($where))));
} }
function get_var ( $query = array(null,false),$x = array(0,false),$y = array(0,false) ) {
{$this->func_call = concat1("\$db-",concat2(concat(concat2(concat(concat2(concat1(">get_var(\"",$query),"\","),$x),","),$y),")"));
if ( $query[0])
 $this->query($query);
if ( (!((empty($this->last_result[0][$y[0]]) || Aspis_empty( $this ->last_result [0][$y[0]] )))))
 {$values = Aspis_array_values(attAspis(get_object_vars(deAspisRC($this->last_result[0][$y[0]]))));
}return (((isset($values[0][$x[0]]) && Aspis_isset( $values [0][$x[0]]))) && (deAspis(attachAspis($values,$x[0])) !== (''))) ? attachAspis($values,$x[0]) : array(null,false);
} }
function get_row ( $query = array(null,false),$output = array(OBJECT,false),$y = array(0,false) ) {
{$this->func_call = concat1("\$db-",concat2(concat(concat2(concat(concat2(concat1(">get_row(\"",$query),"\","),$output),","),$y),")"));
if ( $query[0])
 $this->query($query);
else 
{return array(null,false);
}if ( (!((isset($this->last_result[0][$y[0]]) && Aspis_isset( $this ->last_result [0][$y[0]] )))))
 return array(null,false);
if ( ($output[0] == OBJECT))
 {return $this->last_result[0][$y[0]][0] ? $this->last_result[0][$y[0]] : array(null,false);
}elseif ( ($output[0] == ARRAY_A))
 {return $this->last_result[0][$y[0]][0] ? attAspis(get_object_vars(deAspisRC($this->last_result[0][$y[0]]))) : array(null,false);
}elseif ( ($output[0] == ARRAY_N))
 {return $this->last_result[0][$y[0]][0] ? Aspis_array_values(attAspis(get_object_vars(deAspisRC($this->last_result[0][$y[0]])))) : array(null,false);
}else 
{{$this->print_error(array(" \$db->get_row(string query, output type, int offset) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N",false));
}}} }
function get_col ( $query = array(null,false),$x = array(0,false) ) {
{if ( $query[0])
 $this->query($query);
$new_array = array(array(),false);
for ( $i = array(0,false) ; ($i[0] < count($this->last_result[0])) ; postincr($i) )
{arrayAssign($new_array[0],deAspis(registerTaint($i)),addTaint($this->get_var(array(null,false),$x,$i)));
}return $new_array;
} }
function get_results ( $query = array(null,false),$output = array(OBJECT,false) ) {
{$this->func_call = concat1("\$db-",concat2(concat(concat2(concat1(">get_results(\"",$query),"\", "),$output),")"));
if ( $query[0])
 $this->query($query);
else 
{return array(null,false);
}if ( ($output[0] == OBJECT))
 {return $this->last_result;
}elseif ( ($output[0] == OBJECT_K))
 {foreach ( $this->last_result[0] as $row  )
{$key = Aspis_array_shift(attAspis(get_object_vars(deAspisRC($row))));
if ( (!((isset($new_array[0][$key[0]]) && Aspis_isset( $new_array [0][$key[0]])))))
 arrayAssign($new_array[0],deAspis(registerTaint($key)),addTaint($row));
}return $new_array;
}elseif ( (($output[0] == ARRAY_A) || ($output[0] == ARRAY_N)))
 {if ( $this->last_result[0])
 {$i = array(0,false);
foreach ( deAspis(array_cast($this->last_result)) as $row  )
{if ( ($output[0] == ARRAY_N))
 {arrayAssign($new_array[0],deAspis(registerTaint($i)),addTaint(Aspis_array_values(attAspis(get_object_vars(deAspisRC($row))))));
}else 
{{arrayAssign($new_array[0],deAspis(registerTaint($i)),addTaint(attAspis(get_object_vars(deAspisRC($row)))));
}}preincr($i);
}return $new_array;
}}} }
function get_col_info ( $info_type = array('name',false),$col_offset = array(-1,false) ) {
{if ( $this->col_info[0])
 {if ( ($col_offset[0] == deAspis(negate(array(1,false)))))
 {$i = array(0,false);
foreach ( deAspis(array_cast($this->col_info)) as $col  )
{arrayAssign($new_array[0],deAspis(registerTaint($i)),addTaint($col[0]->{$info_type[0]}));
postincr($i);
}return $new_array;
}else 
{{return $this->col_info[0][$col_offset[0]][0]->{$info_type[0]};
}}}} }
function timer_start (  ) {
{$mtime = attAspisRC(microtime());
$mtime = Aspis_explode(array(' ',false),$mtime);
$this->time_start = array(deAspis(attachAspis($mtime,(1))) + deAspis(attachAspis($mtime,(0))),false);
return array(true,false);
} }
function timer_stop (  ) {
{$mtime = attAspisRC(microtime());
$mtime = Aspis_explode(array(' ',false),$mtime);
$time_end = array(deAspis(attachAspis($mtime,(1))) + deAspis(attachAspis($mtime,(0))),false);
$time_total = array($time_end[0] - $this->time_start[0],false);
return $time_total;
} }
function bail ( $message,$error_code = array('500',false) ) {
{if ( (denot_boolean($this->show_errors)))
 {if ( class_exists(('WP_Error')))
 $this->error = array(new WP_Error($error_code,$message),false);
else 
{$this->error = $message;
}return array(false,false);
}wp_die($message);
} }
function check_database_version (  ) {
{global $wp_version;
if ( (version_compare(deAspisRC($this->db_version()),'4.1.2','<')))
 return array(new WP_Error(array('database_version',false),Aspis_sprintf(__(array('<strong>ERROR</strong>: WordPress %s requires MySQL 4.1.2 or higher',false)),$wp_version)),false);
} }
function supports_collation (  ) {
{return $this->has_cap(array('collation',false));
} }
function has_cap ( $db_cap ) {
{$version = $this->db_version();
switch ( deAspis(Aspis_strtolower($db_cap)) ) {
case ('collation'):;
case ('group_concat'):case ('subqueries'):return array(version_compare(deAspisRC($version),'4.1','>='),false);
break ;
 }
return array(false,false);
} }
function get_caller (  ) {
{if ( (!(is_callable('debug_backtrace'))))
 return array('',false);
$bt = array(debug_backtrace(),false);
$caller = array(array(),false);
$bt = Aspis_array_reverse($bt);
foreach ( deAspis(array_cast($bt)) as $call  )
{if ( (deAspis(@$call[0]['class']) == (__CLASS__)))
 continue ;
$function = $call[0]['function'];
if ( ((isset($call[0][('class')]) && Aspis_isset( $call [0][('class')]))))
 $function = concat(concat2($call[0]['class'],"-"),concat1(">",$function));
arrayAssignAdd($caller[0][],addTaint($function));
}$caller = Aspis_join(array(', ',false),$caller);
return $caller;
} }
function db_version (  ) {
{return Aspis_preg_replace(array('/[^0-9.].*/',false),array('',false),attAspis(mysql_get_server_info($this->dbh[0])));
} }
}if ( (!((isset($wpdb) && Aspis_isset( $wpdb)))))
 {$wpdb = array(new wpdb(array(DB_USER,false),array(DB_PASSWORD,false),array(DB_NAME,false),array(DB_HOST,false)),false);
};
?>
<?php 