<?php require_once('AspisMain.php'); ?><?php
function mysql2date ( $dateformatstring,$mysqlstring,$translate = true ) {
{global $wp_locale;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_locale,"\$wp_locale",$AspisChangesCache);
}$m = $mysqlstring;
if ( empty($m))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}if ( 'G' == $dateformatstring)
 {{$AspisRetTemp = strtotime($m . ' +0000');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}}$i = strtotime($m);
if ( 'U' == $dateformatstring)
 {$AspisRetTemp = $i;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}if ( $translate)
 {$AspisRetTemp = date_i18n($dateformatstring,$i);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = date($dateformatstring,$i);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
 }
function current_time ( $type,$gmt = 0 ) {
switch ( $type ) {
case 'mysql':{$AspisRetTemp = ($gmt) ? gmdate('Y-m-d H:i:s') : gmdate('Y-m-d H:i:s',(time() + (get_option('gmt_offset') * 3600)));
return $AspisRetTemp;
}break ;
case 'timestamp':{$AspisRetTemp = ($gmt) ? time() : time() + (get_option('gmt_offset') * 3600);
return $AspisRetTemp;
}break ;
 }
 }
function date_i18n ( $dateformatstring,$unixtimestamp = false,$gmt = false ) {
{global $wp_locale;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_locale,"\$wp_locale",$AspisChangesCache);
}$i = $unixtimestamp;
if ( false === $i || intval($i) < 0)
 {if ( !$gmt)
 $i = current_time('timestamp');
else 
{$i = time();
}$gmt = true;
}$req_format = $dateformatstring;
$datefunc = $gmt ? 'gmdate' : 'date';
if ( (!empty($wp_locale->month)) && (!empty($wp_locale->weekday)))
 {$datemonth = $wp_locale->get_month(AspisUntaintedDynamicCall($datefunc,'m',$i));
$datemonth_abbrev = $wp_locale->get_month_abbrev($datemonth);
$dateweekday = $wp_locale->get_weekday(AspisUntaintedDynamicCall($datefunc,'w',$i));
$dateweekday_abbrev = $wp_locale->get_weekday_abbrev($dateweekday);
$datemeridiem = $wp_locale->get_meridiem(AspisUntaintedDynamicCall($datefunc,'a',$i));
$datemeridiem_capital = $wp_locale->get_meridiem(AspisUntaintedDynamicCall($datefunc,'A',$i));
$dateformatstring = ' ' . $dateformatstring;
$dateformatstring = preg_replace("/([^\\\])D/","\\1" . backslashit($dateweekday_abbrev),$dateformatstring);
$dateformatstring = preg_replace("/([^\\\])F/","\\1" . backslashit($datemonth),$dateformatstring);
$dateformatstring = preg_replace("/([^\\\])l/","\\1" . backslashit($dateweekday),$dateformatstring);
$dateformatstring = preg_replace("/([^\\\])M/","\\1" . backslashit($datemonth_abbrev),$dateformatstring);
$dateformatstring = preg_replace("/([^\\\])a/","\\1" . backslashit($datemeridiem),$dateformatstring);
$dateformatstring = preg_replace("/([^\\\])A/","\\1" . backslashit($datemeridiem_capital),$dateformatstring);
$dateformatstring = substr($dateformatstring,1,strlen($dateformatstring) - 1);
}$j = @AspisUntaintedDynamicCall($datefunc,$dateformatstring,$i);
$j = apply_filters('date_i18n',$j,$req_format,$i,$gmt);
{$AspisRetTemp = $j;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
 }
function number_format_i18n ( $number,$decimals = null ) {
{global $wp_locale;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_locale,"\$wp_locale",$AspisChangesCache);
}$decimals = (is_null($decimals)) ? $wp_locale->number_format['decimals'] : intval($decimals);
$num = number_format($number,$decimals,$wp_locale->number_format['decimal_point'],$wp_locale->number_format['thousands_sep']);
{$AspisRetTemp = apply_filters('number_format_i18n',$num);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
 }
function size_format ( $bytes,$decimals = null ) {
$quant = array('TB' => 1099511627776,'GB' => 1073741824,'MB' => 1048576,'kB' => 1024,'B ' => 1,);
foreach ( $quant as $unit =>$mag )
if ( doubleval($bytes) >= $mag)
 {$AspisRetTemp = number_format_i18n($bytes / $mag,$decimals) . ' ' . $unit;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function get_weekstartend ( $mysqlstring,$start_of_week = '' ) {
$my = substr($mysqlstring,0,4);
$mm = substr($mysqlstring,8,2);
$md = substr($mysqlstring,5,2);
$day = mktime(0,0,0,$md,$mm,$my);
$weekday = date('w',$day);
$i = 86400;
if ( !is_numeric($start_of_week))
 $start_of_week = get_option('start_of_week');
if ( $weekday < $start_of_week)
 $weekday = 7 - $start_of_week - $weekday;
while ( $weekday > $start_of_week )
{$weekday = date('w',$day);
if ( $weekday < $start_of_week)
 $weekday = 7 - $start_of_week - $weekday;
$day -= 86400;
$i = 0;
}$week['start'] = $day + 86400 - $i;
$week['end'] = $week['start'] + 604799;
{$AspisRetTemp = $week;
return $AspisRetTemp;
} }
function maybe_unserialize ( $original ) {
if ( is_serialized($original))
 {$AspisRetTemp = @AspisUntainted_unserialize($original);
return $AspisRetTemp;
}{$AspisRetTemp = $original;
return $AspisRetTemp;
} }
function is_serialized ( $data ) {
if ( !is_string($data))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$data = trim($data);
if ( 'N;' == $data)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}if ( !preg_match('/^([adObis]):/',$data,$badions))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}switch ( $badions[1] ) {
case 'a':case 'O':case 's':if ( preg_match("/^{$badions[1]}:[0-9]+:.*[;
}]\$/s",$data))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}break ;
case 'b':case 'i':case 'd':if ( preg_match("/^{$badions[1]}:[0-9.E-]+;\$/",$data))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}break ;
 }
{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function is_serialized_string ( $data ) {
if ( !is_string($data))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$data = trim($data);
if ( preg_match('/^s:[0-9]+:.*;$/s',$data))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function get_option ( $setting,$default = false ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$pre = apply_filters('pre_option_' . $setting,false);
if ( false !== $pre)
 {$AspisRetTemp = $pre;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$notoptions = wp_cache_get('notoptions','options');
if ( isset($notoptions[$setting]))
 {$AspisRetTemp = $default;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$alloptions = wp_load_alloptions();
if ( isset($alloptions[$setting]))
 {$value = $alloptions[$setting];
}else 
{{$value = wp_cache_get($setting,'options');
if ( false === $value)
 {if ( defined('WP_INSTALLING'))
 $suppress = $wpdb->suppress_errors();
$row = $wpdb->get_row("SELECT option_value FROM $wpdb->options WHERE option_name = '$setting' LIMIT 1");
if ( defined('WP_INSTALLING'))
 $wpdb->suppress_errors($suppress);
if ( is_object($row))
 {$value = $row->option_value;
wp_cache_add($setting,$value,'options');
}else 
{{$notoptions[$setting] = true;
wp_cache_set('notoptions',$notoptions,'options');
{$AspisRetTemp = $default;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}}}}if ( 'home' == $setting && '' == $value)
 {$AspisRetTemp = get_option('siteurl');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( in_array($setting,array('siteurl','home','category_base','tag_base')))
 $value = untrailingslashit($value);
{$AspisRetTemp = apply_filters('option_' . $setting,maybe_unserialize($value));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_protect_special_option ( $option ) {
$protected = array('alloptions','notoptions');
if ( in_array($option,$protected))
 exit(sprintf(__('%s is a protected WP option and may not be modified'),esc_html($option)));
 }
function form_option ( $option ) {
echo esc_attr(get_option($option));
 }
function get_alloptions (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$show = $wpdb->hide_errors();
if ( !$options = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE autoload = 'yes'"))
 $options = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options");
$wpdb->show_errors($show);
foreach ( (array)$options as $option  )
{if ( in_array($option->option_name,array('siteurl','home','category_base','tag_base')))
 $option->option_value = untrailingslashit($option->option_value);
$value = maybe_unserialize($option->option_value);
$all_options->{$option->option_name} = apply_filters('pre_option_' . $option->option_name,$value);
}{$AspisRetTemp = apply_filters('all_options',$all_options);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_load_alloptions (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$alloptions = wp_cache_get('alloptions','options');
if ( !$alloptions)
 {$suppress = $wpdb->suppress_errors();
if ( !$alloptions_db = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE autoload = 'yes'"))
 $alloptions_db = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options");
$wpdb->suppress_errors($suppress);
$alloptions = array();
foreach ( (array)$alloptions_db as $o  )
$alloptions[$o->option_name] = $o->option_value;
wp_cache_add('alloptions',$alloptions,'options');
}{$AspisRetTemp = $alloptions;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function update_option ( $option_name,$newvalue ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}wp_protect_special_option($option_name);
$safe_option_name = deAspisWarningRC(esc_sql(attAspisRCO($option_name)));
$newvalue = sanitize_option($option_name,$newvalue);
$oldvalue = get_option($safe_option_name);
$newvalue = apply_filters('pre_update_option_' . $option_name,$newvalue,$oldvalue);
if ( $newvalue === $oldvalue)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( false === $oldvalue)
 {add_option($option_name,$newvalue);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}$notoptions = wp_cache_get('notoptions','options');
if ( is_array($notoptions) && isset($notoptions[$option_name]))
 {unset($notoptions[$option_name]);
wp_cache_set('notoptions',$notoptions,'options');
}$_newvalue = $newvalue;
$newvalue = maybe_serialize($newvalue);
do_action('update_option',$option_name,$oldvalue,$newvalue);
$alloptions = wp_load_alloptions();
if ( isset($alloptions[$option_name]))
 {$alloptions[$option_name] = $newvalue;
wp_cache_set('alloptions',$alloptions,'options');
}else 
{{wp_cache_set($option_name,$newvalue,'options');
}}$wpdb->update($wpdb->options,array('option_value' => $newvalue),array('option_name' => $option_name));
if ( $wpdb->rows_affected == 1)
 {do_action("update_option_{$option_name}",$oldvalue,$_newvalue);
do_action('updated_option',$option_name,$oldvalue,$_newvalue);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function add_option ( $name,$value = '',$deprecated = '',$autoload = 'yes' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}wp_protect_special_option($name);
$safe_name = deAspisWarningRC(esc_sql(attAspisRCO($name)));
$value = sanitize_option($name,$value);
$notoptions = wp_cache_get('notoptions','options');
if ( !is_array($notoptions) || !isset($notoptions[$name]))
 if ( false !== get_option($safe_name))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$value = maybe_serialize($value);
$autoload = ('no' === $autoload) ? 'no' : 'yes';
do_action('add_option',$name,$value);
if ( 'yes' == $autoload)
 {$alloptions = wp_load_alloptions();
$alloptions[$name] = $value;
wp_cache_set('alloptions',$alloptions,'options');
}else 
{{wp_cache_set($name,$value,'options');
}}$notoptions = wp_cache_get('notoptions','options');
if ( is_array($notoptions) && isset($notoptions[$name]))
 {unset($notoptions[$name]);
wp_cache_set('notoptions',$notoptions,'options');
}$wpdb->query($wpdb->prepare("INSERT INTO `$wpdb->options` (`option_name`, `option_value`, `autoload`) VALUES (%s, %s, %s) ON DUPLICATE KEY UPDATE `option_name` = VALUES(`option_name`), `option_value` = VALUES(`option_value`), `autoload` = VALUES(`autoload`)",$name,$value,$autoload));
do_action("add_option_{$name}",$name,$value);
do_action('added_option',$name,$value);
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function delete_option ( $name ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}wp_protect_special_option($name);
$option = $wpdb->get_row("SELECT autoload FROM $wpdb->options WHERE option_name = '$name'");
if ( is_null($option))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}do_action('delete_option',$name);
$wpdb->query("DELETE FROM $wpdb->options WHERE option_name = '$name'");
if ( 'yes' == $option->autoload)
 {$alloptions = wp_load_alloptions();
if ( isset($alloptions[$name]))
 {unset($alloptions[$name]);
wp_cache_set('alloptions',$alloptions,'options');
}}else 
{{wp_cache_delete($name,'options');
}}do_action('deleted_option',$name);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function delete_transient ( $transient ) {
{global $_wp_using_ext_object_cache,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_using_ext_object_cache,"\$_wp_using_ext_object_cache",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( $_wp_using_ext_object_cache)
 {{$AspisRetTemp = wp_cache_delete($transient,'transient');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{$transient = '_transient_' . deAspisWarningRC(esc_sql(attAspisRCO($transient)));
{$AspisRetTemp = delete_option($transient);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function get_transient ( $transient ) {
{global $_wp_using_ext_object_cache,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_using_ext_object_cache,"\$_wp_using_ext_object_cache",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}$pre = apply_filters('pre_transient_' . $transient,false);
if ( false !== $pre)
 {$AspisRetTemp = $pre;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( $_wp_using_ext_object_cache)
 {$value = wp_cache_get($transient,'transient');
}else 
{{$transient_option = '_transient_' . deAspisWarningRC(esc_sql(attAspisRCO($transient)));
$alloptions = wp_load_alloptions();
if ( !isset($alloptions[$transient_option]))
 {$transient_timeout = '_transient_timeout_' . deAspisWarningRC(esc_sql(attAspisRCO($transient)));
if ( get_option($transient_timeout) < time())
 {delete_option($transient_option);
delete_option($transient_timeout);
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}$value = get_option($transient_option);
}}{$AspisRetTemp = apply_filters('transient_' . $transient,$value);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function set_transient ( $transient,$value,$expiration = 0 ) {
{global $_wp_using_ext_object_cache,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_using_ext_object_cache,"\$_wp_using_ext_object_cache",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( $_wp_using_ext_object_cache)
 {{$AspisRetTemp = wp_cache_set($transient,$value,'transient',$expiration);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{$transient_timeout = '_transient_timeout_' . $transient;
$transient = '_transient_' . $transient;
$safe_transient = deAspisWarningRC(esc_sql(attAspisRCO($transient)));
if ( false === get_option($safe_transient))
 {$autoload = 'yes';
if ( 0 != $expiration)
 {$autoload = 'no';
add_option($transient_timeout,time() + $expiration,'','no');
}{$AspisRetTemp = add_option($transient,$value,'',$autoload);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{if ( 0 != $expiration)
 update_option($transient_timeout,time() + $expiration);
{$AspisRetTemp = update_option($transient,$value);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function wp_user_settings (  ) {
if ( !is_admin())
 {return ;
}if ( defined('DOING_AJAX'))
 {return ;
}if ( !$user = wp_get_current_user())
 {return ;
}$settings = get_user_option('user-settings',$user->ID,false);
if ( (isset($_COOKIE[0]['wp-settings-' . $user->ID]) && Aspis_isset($_COOKIE[0]['wp-settings-' . $user ->ID ])))
 {$cookie = preg_replace('/[^A-Za-z0-9=&_]/','',deAspisWarningRC($_COOKIE[0]['wp-settings-' . $user->ID]));
if ( !empty($cookie) && strpos($cookie,'='))
 {if ( $cookie == $settings)
 {return ;
}$last_time = (int)get_user_option('user-settings-time',$user->ID,false);
$saved = (isset($_COOKIE[0]['wp-settings-time-' . $user->ID]) && Aspis_isset($_COOKIE[0]['wp-settings-time-' . $user ->ID ])) ? preg_replace('/[^0-9]/','',deAspisWarningRC($_COOKIE[0]['wp-settings-time-' . $user->ID])) : 0;
if ( $saved > $last_time)
 {update_user_option($user->ID,'user-settings',$cookie,false);
update_user_option($user->ID,'user-settings-time',time() - 5,false);
{return ;
}}}}setcookie('wp-settings-' . $user->ID,$settings,time() + 31536000,SITECOOKIEPATH);
setcookie('wp-settings-time-' . $user->ID,time(),time() + 31536000,SITECOOKIEPATH);
$_COOKIE[0]['wp-settings-' . $user->ID] = attAspisRCO($settings);
 }
function get_user_setting ( $name,$default = false ) {
$all = get_all_user_settings();
{$AspisRetTemp = isset($all[$name]) ? $all[$name] : $default;
return $AspisRetTemp;
} }
function set_user_setting ( $name,$value ) {
if ( headers_sent())
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$all = get_all_user_settings();
$name = preg_replace('/[^A-Za-z0-9_]+/','',$name);
if ( empty($name))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$all[$name] = $value;
{$AspisRetTemp = wp_set_all_user_settings($all);
return $AspisRetTemp;
} }
function delete_user_setting ( $names ) {
if ( headers_sent())
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$all = get_all_user_settings();
$names = (array)$names;
foreach ( $names as $name  )
{if ( isset($all[$name]))
 {unset($all[$name]);
$deleted = true;
}}if ( isset($deleted))
 {$AspisRetTemp = wp_set_all_user_settings($all);
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function get_all_user_settings (  ) {
{global $_updated_user_settings;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_updated_user_settings,"\$_updated_user_settings",$AspisChangesCache);
}if ( !$user = wp_get_current_user())
 {$AspisRetTemp = array();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_updated_user_settings",$AspisChangesCache);
return $AspisRetTemp;
}if ( isset($_updated_user_settings) && is_array($_updated_user_settings))
 {$AspisRetTemp = $_updated_user_settings;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_updated_user_settings",$AspisChangesCache);
return $AspisRetTemp;
}$all = array();
if ( (isset($_COOKIE[0]['wp-settings-' . $user->ID]) && Aspis_isset($_COOKIE[0]['wp-settings-' . $user ->ID ])))
 {$cookie = preg_replace('/[^A-Za-z0-9=&_]/','',deAspisWarningRC($_COOKIE[0]['wp-settings-' . $user->ID]));
if ( $cookie && strpos($cookie,'='))
 parse_str($cookie,$all);
}else 
{{$option = get_user_option('user-settings',$user->ID);
if ( $option && is_string($option))
 parse_str($option,$all);
}}{$AspisRetTemp = $all;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_updated_user_settings",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_updated_user_settings",$AspisChangesCache);
 }
function wp_set_all_user_settings ( $all ) {
{global $_updated_user_settings;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_updated_user_settings,"\$_updated_user_settings",$AspisChangesCache);
}if ( !$user = wp_get_current_user())
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_updated_user_settings",$AspisChangesCache);
return $AspisRetTemp;
}$_updated_user_settings = $all;
$settings = '';
foreach ( $all as $k =>$v )
{$v = preg_replace('/[^A-Za-z0-9_]+/','',$v);
$settings .= $k . '=' . $v . '&';
}$settings = rtrim($settings,'&');
update_user_option($user->ID,'user-settings',$settings,false);
update_user_option($user->ID,'user-settings-time',time(),false);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_updated_user_settings",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_updated_user_settings",$AspisChangesCache);
 }
function delete_all_user_settings (  ) {
if ( !$user = wp_get_current_user())
 {return ;
}update_user_option($user->ID,'user-settings','',false);
setcookie('wp-settings-' . $user->ID,' ',time() - 31536000,SITECOOKIEPATH);
 }
function maybe_serialize ( $data ) {
if ( is_array($data) || is_object($data))
 {$AspisRetTemp = serialize($data);
return $AspisRetTemp;
}if ( is_serialized($data))
 {$AspisRetTemp = serialize($data);
return $AspisRetTemp;
}{$AspisRetTemp = $data;
return $AspisRetTemp;
} }
function xmlrpc_getposttitle ( $content ) {
{global $post_default_title;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post_default_title,"\$post_default_title",$AspisChangesCache);
}if ( preg_match('/<title>(.+?)<\/title>/is',$content,$matchtitle))
 {$post_title = $matchtitle[1];
}else 
{{$post_title = $post_default_title;
}}{$AspisRetTemp = $post_title;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post_default_title",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post_default_title",$AspisChangesCache);
 }
function xmlrpc_getpostcategory ( $content ) {
{global $post_default_category;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post_default_category,"\$post_default_category",$AspisChangesCache);
}if ( preg_match('/<category>(.+?)<\/category>/is',$content,$matchcat))
 {$post_category = trim($matchcat[1],',');
$post_category = explode(',',$post_category);
}else 
{{$post_category = $post_default_category;
}}{$AspisRetTemp = $post_category;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post_default_category",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post_default_category",$AspisChangesCache);
 }
function xmlrpc_removepostdata ( $content ) {
$content = preg_replace('/<title>(.+?)<\/title>/si','',$content);
$content = preg_replace('/<category>(.+?)<\/category>/si','',$content);
$content = trim($content);
{$AspisRetTemp = $content;
return $AspisRetTemp;
} }
function debug_fopen ( $filename,$mode ) {
{global $debug;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $debug,"\$debug",$AspisChangesCache);
}if ( 1 == $debug)
 {$fp = fopen($filename,$mode);
{$AspisRetTemp = $fp;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$debug",$AspisChangesCache);
 }
function debug_fwrite ( $fp,$string ) {
{global $debug;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $debug,"\$debug",$AspisChangesCache);
}if ( 1 == $debug)
 fwrite($fp,$string);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$debug",$AspisChangesCache);
 }
function debug_fclose ( $fp ) {
{global $debug;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $debug,"\$debug",$AspisChangesCache);
}if ( 1 == $debug)
 fclose($fp);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$debug",$AspisChangesCache);
 }
function do_enclose ( $content,$post_ID ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}include_once (ABSPATH . WPINC . '/class-IXR.php');
$log = debug_fopen(ABSPATH . 'enclosures.log','a');
$post_links = array();
debug_fwrite($log,'BEGIN ' . date('YmdHis',time()) . "\n");
$pung = get_enclosed($post_ID);
$ltrs = '\w';
$gunk = '/#~:.?+=&%@!\-';
$punc = '.:?\-';
$any = $ltrs . $gunk . $punc;
preg_match_all("{\b http : [$any] +? (?= [$punc] * [^$any] | $)}x",$content,$post_links_temp);
debug_fwrite($log,'Post contents:');
debug_fwrite($log,$content . "\n");
foreach ( $pung as $link_test  )
{if ( !in_array($link_test,$post_links_temp[0]))
 {$mid = $wpdb->get_col($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = 'enclosure' AND meta_value LIKE (%s)",$post_ID,$link_test . '%'));
do_action('delete_postmeta',$mid);
$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE post_id IN(%s)",implode(',',$mid)));
do_action('deleted_postmeta',$mid);
}}foreach ( (array)$post_links_temp[0] as $link_test  )
{if ( !in_array($link_test,$pung))
 {$test = parse_url($link_test);
if ( isset($test['query']))
 $post_links[] = $link_test;
elseif ( $test['path'] != '/' && $test['path'] != '')
 $post_links[] = $link_test;
}}foreach ( (array)$post_links as $url  )
{if ( $url != '' && !$wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = 'enclosure' AND meta_value LIKE (%s)",$post_ID,$url . '%')))
 {if ( $headers = wp_get_http_headers($url))
 {$len = (int)$headers['content-length'];
$type = $headers['content-type'];
$allowed_types = array('video','audio');
if ( in_array(substr($type,0,strpos($type,"/")),$allowed_types))
 {$meta_value = "$url\n$len\n$type\n";
$wpdb->insert($wpdb->postmeta,array('post_id' => $post_ID,'meta_key' => 'enclosure','meta_value' => $meta_value));
do_action('added_postmeta',$wpdb->insert_id,$post_ID,'enclosure',$meta_value);
}}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_get_http ( $url,$file_path = false,$deprecated = false ) {
@set_time_limit(60);
$options = array();
$options['redirection'] = 5;
if ( false == $file_path)
 $options['method'] = 'HEAD';
else 
{$options['method'] = 'GET';
}$response = wp_remote_request($url,$options);
if ( is_wp_error($response))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$headers = wp_remote_retrieve_headers($response);
$headers['response'] = $response['response']['code'];
if ( false == $file_path)
 {$AspisRetTemp = $headers;
return $AspisRetTemp;
}$out_fp = fopen($file_path,'w');
if ( !$out_fp)
 {$AspisRetTemp = $headers;
return $AspisRetTemp;
}fwrite($out_fp,$response['body']);
fclose($out_fp);
{$AspisRetTemp = $headers;
return $AspisRetTemp;
} }
function wp_get_http_headers ( $url,$deprecated = false ) {
$response = wp_remote_head($url);
if ( is_wp_error($response))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = wp_remote_retrieve_headers($response);
return $AspisRetTemp;
} }
function is_new_day (  ) {
{global $day,$previousday;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $day,"\$day",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($previousday,"\$previousday",$AspisChangesCache);
}if ( $day != $previousday)
 {$AspisRetTemp = 1;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$day",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$previousday",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$day",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$previousday",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$day",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$previousday",$AspisChangesCache);
 }
function build_query ( $data ) {
{$AspisRetTemp = _http_build_query($data,null,'&','',false);
return $AspisRetTemp;
} }
function add_query_arg (  ) {
$ret = '';
if ( is_array(func_get_arg(0)))
 {if ( @func_num_args() < 2 || false === @func_get_arg(1))
 $uri = deAspisWarningRC($_SERVER[0]['REQUEST_URI']);
else 
{$uri = @func_get_arg(1);
}}else 
{{if ( @func_num_args() < 3 || false === @func_get_arg(2))
 $uri = deAspisWarningRC($_SERVER[0]['REQUEST_URI']);
else 
{$uri = @func_get_arg(2);
}}}if ( $frag = strstr($uri,'#'))
 $uri = substr($uri,0,-strlen($frag));
else 
{$frag = '';
}if ( preg_match('|^https?://|i',$uri,$matches))
 {$protocol = $matches[0];
$uri = substr($uri,strlen($protocol));
}else 
{{$protocol = '';
}}if ( strpos($uri,'?') !== false)
 {$parts = explode('?',$uri,2);
if ( 1 == count($parts))
 {$base = '?';
$query = $parts[0];
}else 
{{$base = $parts[0] . '?';
$query = $parts[1];
}}}elseif ( !empty($protocol) || strpos($uri,'=') === false)
 {$base = $uri . '?';
$query = '';
}else 
{{$base = '';
$query = $uri;
}}wp_parse_str($query,$qs);
$qs = urlencode_deep($qs);
if ( is_array(func_get_arg(0)))
 {$kayvees = func_get_arg(0);
$qs = array_merge($qs,$kayvees);
}else 
{{$qs[func_get_arg(0)] = func_get_arg(1);
}}foreach ( (array)$qs as $k =>$v )
{if ( $v === false)
 unset($qs[$k]);
}$ret = build_query($qs);
$ret = trim($ret,'?');
$ret = preg_replace('#=(&|$)#','$1',$ret);
$ret = $protocol . $base . $ret . $frag;
$ret = rtrim($ret,'?');
{$AspisRetTemp = $ret;
return $AspisRetTemp;
} }
function remove_query_arg ( $key,$query = false ) {
if ( is_array($key))
 {foreach ( $key as $k  )
$query = add_query_arg($k,false,$query);
{$AspisRetTemp = $query;
return $AspisRetTemp;
}}{$AspisRetTemp = add_query_arg($key,false,$query);
return $AspisRetTemp;
} }
function  add_magic_quotes ( $array ) {
{global  $wpdb;
$AspisVar0 = &AspisTaintUntaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}foreach ( deAspis(array_cast($array)) as $k =>$v )
{restoreTaint($k,$v);
{if ( is_array( $v[0]))
 {arrayAssign($array[0],deAspis(registerTaint($k)),addTaint(add_magic_quotes( $v)));
} else 
{{arrayAssign($array[0],deAspis(registerTaint($k)),addTaint(esc_sql( $v)));
}}}}{$AspisRetTemp = $array;
AspisRestoreUntaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreUntaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_remote_fopen ( $uri ) {
$parsed_url = @parse_url($uri);
if ( !$parsed_url || !is_array($parsed_url))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$options = array();
$options['timeout'] = 10;
$response = wp_remote_get($uri,$options);
if ( is_wp_error($response))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $response['body'];
return $AspisRetTemp;
} }
function wp ( $query_vars = '' ) {
{global $wp,$wp_query,$wp_the_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp,"\$wp",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_query,"\$wp_query",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_the_query,"\$wp_the_query",$AspisChangesCache);
}$wp->main($query_vars);
if ( !isset($wp_the_query))
 $wp_the_query = $wp_query;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_the_query",$AspisChangesCache);
 }
function get_status_header_desc ( $code ) {
{global $wp_header_to_desc;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_header_to_desc,"\$wp_header_to_desc",$AspisChangesCache);
}$code = absint($code);
if ( !isset($wp_header_to_desc))
 {$wp_header_to_desc = array(100 => 'Continue',101 => 'Switching Protocols',102 => 'Processing',200 => 'OK',201 => 'Created',202 => 'Accepted',203 => 'Non-Authoritative Information',204 => 'No Content',205 => 'Reset Content',206 => 'Partial Content',207 => 'Multi-Status',226 => 'IM Used',300 => 'Multiple Choices',301 => 'Moved Permanently',302 => 'Found',303 => 'See Other',304 => 'Not Modified',305 => 'Use Proxy',306 => 'Reserved',307 => 'Temporary Redirect',400 => 'Bad Request',401 => 'Unauthorized',402 => 'Payment Required',403 => 'Forbidden',404 => 'Not Found',405 => 'Method Not Allowed',406 => 'Not Acceptable',407 => 'Proxy Authentication Required',408 => 'Request Timeout',409 => 'Conflict',410 => 'Gone',411 => 'Length Required',412 => 'Precondition Failed',413 => 'Request Entity Too Large',414 => 'Request-URI Too Long',415 => 'Unsupported Media Type',416 => 'Requested Range Not Satisfiable',417 => 'Expectation Failed',422 => 'Unprocessable Entity',423 => 'Locked',424 => 'Failed Dependency',426 => 'Upgrade Required',500 => 'Internal Server Error',501 => 'Not Implemented',502 => 'Bad Gateway',503 => 'Service Unavailable',504 => 'Gateway Timeout',505 => 'HTTP Version Not Supported',506 => 'Variant Also Negotiates',507 => 'Insufficient Storage',510 => 'Not Extended');
}if ( isset($wp_header_to_desc[$code]))
 {$AspisRetTemp = $wp_header_to_desc[$code];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_header_to_desc",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = '';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_header_to_desc",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_header_to_desc",$AspisChangesCache);
 }
function status_header ( $header ) {
$text = get_status_header_desc($header);
if ( empty($text))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$protocol = deAspisWarningRC($_SERVER[0]["SERVER_PROTOCOL"]);
if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol)
 $protocol = 'HTTP/1.0';
$status_header = "$protocol $header $text";
if ( function_exists('apply_filters'))
 $status_header = apply_filters('status_header',$status_header,$header,$text,$protocol);
{$AspisRetTemp = @header($status_header,true,$header);
return $AspisRetTemp;
} }
function wp_get_nocache_headers (  ) {
$headers = array('Expires' => 'Wed, 11 Jan 1984 05:00:00 GMT','Last-Modified' => gmdate('D, d M Y H:i:s') . ' GMT','Cache-Control' => 'no-cache, must-revalidate, max-age=0','Pragma' => 'no-cache',);
if ( function_exists('apply_filters'))
 {$headers = apply_filters('nocache_headers',$headers);
}{$AspisRetTemp = $headers;
return $AspisRetTemp;
} }
function nocache_headers (  ) {
$headers = wp_get_nocache_headers();
foreach ( (array)$headers as $name =>$field_value )
@header("{$name}: {$field_value}");
 }
function cache_javascript_headers (  ) {
$expiresOffset = 864000;
header("Content-Type: text/javascript; charset=" . get_bloginfo('charset'));
header("Vary: Accept-Encoding");
header("Expires: " . gmdate("D, d M Y H:i:s",time() + $expiresOffset) . " GMT");
 }
function get_num_queries (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}{$AspisRetTemp = $wpdb->num_queries;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function bool_from_yn ( $yn ) {
{$AspisRetTemp = (strtolower($yn) == 'y');
return $AspisRetTemp;
} }
function do_feed (  ) {
{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}$feed = get_query_var('feed');
$feed = preg_replace('/^_+/','',$feed);
if ( $feed == '' || $feed == 'feed')
 $feed = get_default_feed();
$hook = 'do_feed_' . $feed;
if ( !has_action($hook))
 {$message = sprintf(__('ERROR: %s is not a valid feed template'),esc_html($feed));
wp_die($message);
}do_action($hook,$wp_query->is_comment_feed);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function do_feed_rdf (  ) {
load_template(ABSPATH . WPINC . '/feed-rdf.php');
 }
function do_feed_rss (  ) {
load_template(ABSPATH . WPINC . '/feed-rss.php');
 }
function do_feed_rss2 ( $for_comments ) {
if ( $for_comments)
 load_template(ABSPATH . WPINC . '/feed-rss2-comments.php');
else 
{load_template(ABSPATH . WPINC . '/feed-rss2.php');
} }
function do_feed_atom ( $for_comments ) {
if ( $for_comments)
 load_template(ABSPATH . WPINC . '/feed-atom-comments.php');
else 
{load_template(ABSPATH . WPINC . '/feed-atom.php');
} }
function do_robots (  ) {
header('Content-Type: text/plain; charset=utf-8');
do_action('do_robotstxt');
if ( '0' == get_option('blog_public'))
 {echo "User-agent: *\n";
echo "Disallow: /\n";
}else 
{{echo "User-agent: *\n";
echo "Disallow:\n";
}} }
function is_blog_installed (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( wp_cache_get('is_blog_installed'))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$suppress = $wpdb->suppress_errors();
$alloptions = wp_load_alloptions();
if ( !isset($alloptions['siteurl']))
 $installed = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = 'siteurl'");
else 
{$installed = $alloptions['siteurl'];
}$wpdb->suppress_errors($suppress);
$installed = !empty($installed);
wp_cache_set('is_blog_installed',$installed);
if ( $installed)
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$suppress = $wpdb->suppress_errors();
$tables = $wpdb->get_col('SHOW TABLES');
$wpdb->suppress_errors($suppress);
foreach ( $wpdb->tables as $table  )
{if ( in_array($wpdb->prefix . $table,$tables))
 {if ( defined('WP_REPAIRING'))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$wpdb->error = __('One or more database tables are unavailable.  The database may need to be <a href="maint/repair.php?referrer=is_blog_installed">repaired</a>.');
dead_db();
}}wp_cache_set('is_blog_installed',false);
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_nonce_url ( $actionurl,$action = -1 ) {
$actionurl = str_replace('&amp;','&',$actionurl);
{$AspisRetTemp = esc_html(add_query_arg('_wpnonce',wp_create_nonce($action),$actionurl));
return $AspisRetTemp;
} }
function wp_nonce_field ( $action = -1,$name = "_wpnonce",$referer = true,$echo = true ) {
$name = esc_attr($name);
$nonce_field = '<input type="hidden" id="' . $name . '" name="' . $name . '" value="' . wp_create_nonce($action) . '" />';
if ( $echo)
 echo $nonce_field;
if ( $referer)
 wp_referer_field($echo,'previous');
{$AspisRetTemp = $nonce_field;
return $AspisRetTemp;
} }
function wp_referer_field ( $echo = true ) {
$ref = esc_attr(deAspisWarningRC($_SERVER[0]['REQUEST_URI']));
$referer_field = '<input type="hidden" name="_wp_http_referer" value="' . $ref . '" />';
if ( $echo)
 echo $referer_field;
{$AspisRetTemp = $referer_field;
return $AspisRetTemp;
} }
function wp_original_referer_field ( $echo = true,$jump_back_to = 'current' ) {
$jump_back_to = ('previous' == $jump_back_to) ? wp_get_referer() : deAspisWarningRC($_SERVER[0]['REQUEST_URI']);
$ref = (wp_get_original_referer()) ? wp_get_original_referer() : $jump_back_to;
$orig_referer_field = '<input type="hidden" name="_wp_original_http_referer" value="' . esc_attr(stripslashes($ref)) . '" />';
if ( $echo)
 echo $orig_referer_field;
{$AspisRetTemp = $orig_referer_field;
return $AspisRetTemp;
} }
function wp_get_referer (  ) {
$ref = '';
if ( !(empty($_REQUEST[0]['_wp_http_referer']) || Aspis_empty($_REQUEST[0]['_wp_http_referer'])))
 $ref = deAspisWarningRC($_REQUEST[0]['_wp_http_referer']);
else 
{if ( !(empty($_SERVER[0]['HTTP_REFERER']) || Aspis_empty($_SERVER[0]['HTTP_REFERER'])))
 $ref = deAspisWarningRC($_SERVER[0]['HTTP_REFERER']);
}if ( $ref !== deAspisWarningRC($_SERVER[0]['REQUEST_URI']))
 {$AspisRetTemp = $ref;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_get_original_referer (  ) {
if ( !(empty($_REQUEST[0]['_wp_original_http_referer']) || Aspis_empty($_REQUEST[0]['_wp_original_http_referer'])))
 {$AspisRetTemp = deAspisWarningRC($_REQUEST[0]['_wp_original_http_referer']);
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_mkdir_p ( $target ) {
$target = str_replace('//','/',$target);
if ( file_exists($target))
 {$AspisRetTemp = @is_dir($target);
return $AspisRetTemp;
}if ( @mkdir($target))
 {$stat = @stat(dirname($target));
$dir_perms = $stat['mode'] & 0007777;
@chmod($target,$dir_perms);
{$AspisRetTemp = true;
return $AspisRetTemp;
}}elseif ( is_dir(dirname($target)))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( ($target != '/') && (wp_mkdir_p(dirname($target))))
 {$AspisRetTemp = wp_mkdir_p($target);
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function path_is_absolute ( $path ) {
if ( realpath($path) == $path)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}if ( strlen($path) == 0 || $path[0] == '.')
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( preg_match('#^[a-zA-Z]:\\\\#',$path))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = (bool)preg_match('#^[/\\\\]#',$path);
return $AspisRetTemp;
} }
function path_join ( $base,$path ) {
if ( path_is_absolute($path))
 {$AspisRetTemp = $path;
return $AspisRetTemp;
}{$AspisRetTemp = rtrim($base,'/') . '/' . ltrim($path,'/');
return $AspisRetTemp;
} }
function wp_upload_dir ( $time = null ) {
$siteurl = get_option('siteurl');
$upload_path = get_option('upload_path');
$upload_path = trim($upload_path);
if ( empty($upload_path))
 {$dir = WP_CONTENT_DIR . '/uploads';
}else 
{{$dir = $upload_path;
if ( 'wp-content/uploads' == $upload_path)
 {$dir = WP_CONTENT_DIR . '/uploads';
}elseif ( 0 !== strpos($dir,ABSPATH))
 {$dir = path_join(ABSPATH,$dir);
}}}if ( !$url = get_option('upload_url_path'))
 {if ( empty($upload_path) || ('wp-content/uploads' == $upload_path) || ($upload_path == $dir))
 $url = WP_CONTENT_URL . '/uploads';
else 
{$url = trailingslashit($siteurl) . $upload_path;
}}if ( defined('UPLOADS'))
 {$dir = ABSPATH . UPLOADS;
$url = trailingslashit($siteurl) . UPLOADS;
}$bdir = $dir;
$burl = $url;
$subdir = '';
if ( get_option('uploads_use_yearmonth_folders'))
 {if ( !$time)
 $time = current_time('mysql');
$y = substr($time,0,4);
$m = substr($time,5,2);
$subdir = "/$y/$m";
}$dir .= $subdir;
$url .= $subdir;
$uploads = apply_filters('upload_dir',array('path' => $dir,'url' => $url,'subdir' => $subdir,'basedir' => $bdir,'baseurl' => $burl,'error' => false));
if ( !wp_mkdir_p($uploads['path']))
 {$message = sprintf(__('Unable to create directory %s. Is its parent directory writable by the server?'),$uploads['path']);
{$AspisRetTemp = array('error' => $message);
return $AspisRetTemp;
}}{$AspisRetTemp = $uploads;
return $AspisRetTemp;
} }
function wp_unique_filename ( $dir,$filename,$unique_filename_callback = null ) {
$filename = sanitize_file_name($filename);
$info = pathinfo($filename);
$ext = !empty($info['extension']) ? '.' . $info['extension'] : '';
$name = basename($filename,$ext);
if ( $name === $ext)
 $name = '';
if ( $unique_filename_callback && function_exists($unique_filename_callback))
 {$filename = AspisUntaintedDynamicCall($unique_filename_callback,$dir,$name);
}else 
{{$number = '';
if ( $ext && strtolower($ext) != $ext)
 {$ext2 = strtolower($ext);
$filename2 = preg_replace('|' . preg_quote($ext) . '$|',$ext2,$filename);
while ( file_exists($dir . "/$filename") || file_exists($dir . "/$filename2") )
{$new_number = $number + 1;
$filename = str_replace("$number$ext","$new_number$ext",$filename);
$filename2 = str_replace("$number$ext2","$new_number$ext2",$filename2);
$number = $new_number;
}{$AspisRetTemp = $filename2;
return $AspisRetTemp;
}}while ( file_exists($dir . "/$filename") )
{if ( '' == "$number$ext")
 $filename = $filename . ++$number . $ext;
else 
{$filename = str_replace("$number$ext",++$number . $ext,$filename);
}}}}{$AspisRetTemp = $filename;
return $AspisRetTemp;
} }
function wp_upload_bits ( $name,$deprecated,$bits,$time = null ) {
if ( empty($name))
 {$AspisRetTemp = array('error' => __('Empty filename'));
return $AspisRetTemp;
}$wp_filetype = wp_check_filetype($name);
if ( !$wp_filetype['ext'])
 {$AspisRetTemp = array('error' => __('Invalid file type'));
return $AspisRetTemp;
}$upload = wp_upload_dir($time);
if ( $upload['error'] !== false)
 {$AspisRetTemp = $upload;
return $AspisRetTemp;
}$filename = wp_unique_filename($upload['path'],$name);
$new_file = $upload['path'] . "/$filename";
if ( !wp_mkdir_p(dirname($new_file)))
 {$message = sprintf(__('Unable to create directory %s. Is its parent directory writable by the server?'),dirname($new_file));
{$AspisRetTemp = array('error' => $message);
return $AspisRetTemp;
}}$ifp = @fopen($new_file,'wb');
if ( !$ifp)
 {$AspisRetTemp = array('error' => sprintf(__('Could not write file %s'),$new_file));
return $AspisRetTemp;
}@fwrite($ifp,$bits);
fclose($ifp);
$stat = @stat(dirname($new_file));
$perms = $stat['mode'] & 0007777;
$perms = $perms & 0000666;
@chmod($new_file,$perms);
$url = $upload['url'] . "/$filename";
{$AspisRetTemp = array('file' => $new_file,'url' => $url,'error' => false);
return $AspisRetTemp;
} }
function wp_ext2type ( $ext ) {
$ext2type = apply_filters('ext2type',array('audio' => array('aac','ac3','aif','aiff','mp1','mp2','mp3','m3a','m4a','m4b','ogg','ram','wav','wma'),'video' => array('asf','avi','divx','dv','mov','mpg','mpeg','mp4','mpv','ogm','qt','rm','vob','wmv','m4v'),'document' => array('doc','docx','pages','odt','rtf','pdf'),'spreadsheet' => array('xls','xlsx','numbers','ods'),'interactive' => array('ppt','pptx','key','odp','swf'),'text' => array('txt'),'archive' => array('tar','bz2','gz','cab','dmg','rar','sea','sit','sqx','zip'),'code' => array('css','html','php','js'),));
foreach ( $ext2type as $type =>$exts )
if ( in_array($ext,$exts))
 {$AspisRetTemp = $type;
return $AspisRetTemp;
} }
function wp_check_filetype ( $filename,$mimes = null ) {
if ( empty($mimes))
 $mimes = get_allowed_mime_types();
$type = false;
$ext = false;
foreach ( $mimes as $ext_preg =>$mime_match )
{$ext_preg = '!\.(' . $ext_preg . ')$!i';
if ( preg_match($ext_preg,$filename,$ext_matches))
 {$type = $mime_match;
$ext = $ext_matches[1];
break ;
}}{$AspisRetTemp = compact('ext','type');
return $AspisRetTemp;
} }
function get_allowed_mime_types (  ) {
static $mimes = false;
if ( !$mimes)
 {$mimes = apply_filters('upload_mimes',array('jpg|jpeg|jpe' => 'image/jpeg','gif' => 'image/gif','png' => 'image/png','bmp' => 'image/bmp','tif|tiff' => 'image/tiff','ico' => 'image/x-icon','asf|asx|wax|wmv|wmx' => 'video/asf','avi' => 'video/avi','divx' => 'video/divx','flv' => 'video/x-flv','mov|qt' => 'video/quicktime','mpeg|mpg|mpe' => 'video/mpeg','txt|c|cc|h' => 'text/plain','rtx' => 'text/richtext','css' => 'text/css','htm|html' => 'text/html','mp3|m4a' => 'audio/mpeg','mp4|m4v' => 'video/mp4','ra|ram' => 'audio/x-realaudio','wav' => 'audio/wav','ogg' => 'audio/ogg','mid|midi' => 'audio/midi','wma' => 'audio/wma','rtf' => 'application/rtf','js' => 'application/javascript','pdf' => 'application/pdf','doc|docx' => 'application/msword','pot|pps|ppt|pptx' => 'application/vnd.ms-powerpoint','wri' => 'application/vnd.ms-write','xla|xls|xlsx|xlt|xlw' => 'application/vnd.ms-excel','mdb' => 'application/vnd.ms-access','mpp' => 'application/vnd.ms-project','swf' => 'application/x-shockwave-flash','class' => 'application/java','tar' => 'application/x-tar','zip' => 'application/zip','gz|gzip' => 'application/x-gzip','exe' => 'application/x-msdownload','odt' => 'application/vnd.oasis.opendocument.text','odp' => 'application/vnd.oasis.opendocument.presentation','ods' => 'application/vnd.oasis.opendocument.spreadsheet','odg' => 'application/vnd.oasis.opendocument.graphics','odc' => 'application/vnd.oasis.opendocument.chart','odb' => 'application/vnd.oasis.opendocument.database','odf' => 'application/vnd.oasis.opendocument.formula',));
}{$AspisRetTemp = $mimes;
return $AspisRetTemp;
} }
function wp_explain_nonce ( $action ) {
if ( $action !== -1 && preg_match('/([a-z]+)-([a-z]+)(_(.+))?/',$action,$matches))
 {$verb = $matches[1];
$noun = $matches[2];
$trans = array();
$trans['update']['attachment'] = array(__('Your attempt to edit this attachment: &#8220;%s&#8221; has failed.'),'get_the_title');
$trans['add']['category'] = array(__('Your attempt to add this category has failed.'),false);
$trans['delete']['category'] = array(__('Your attempt to delete this category: &#8220;%s&#8221; has failed.'),'get_cat_name');
$trans['update']['category'] = array(__('Your attempt to edit this category: &#8220;%s&#8221; has failed.'),'get_cat_name');
$trans['delete']['comment'] = array(__('Your attempt to delete this comment: &#8220;%s&#8221; has failed.'),'use_id');
$trans['unapprove']['comment'] = array(__('Your attempt to unapprove this comment: &#8220;%s&#8221; has failed.'),'use_id');
$trans['approve']['comment'] = array(__('Your attempt to approve this comment: &#8220;%s&#8221; has failed.'),'use_id');
$trans['update']['comment'] = array(__('Your attempt to edit this comment: &#8220;%s&#8221; has failed.'),'use_id');
$trans['bulk']['comments'] = array(__('Your attempt to bulk modify comments has failed.'),false);
$trans['moderate']['comments'] = array(__('Your attempt to moderate comments has failed.'),false);
$trans['add']['bookmark'] = array(__('Your attempt to add this link has failed.'),false);
$trans['delete']['bookmark'] = array(__('Your attempt to delete this link: &#8220;%s&#8221; has failed.'),'use_id');
$trans['update']['bookmark'] = array(__('Your attempt to edit this link: &#8220;%s&#8221; has failed.'),'use_id');
$trans['bulk']['bookmarks'] = array(__('Your attempt to bulk modify links has failed.'),false);
$trans['add']['page'] = array(__('Your attempt to add this page has failed.'),false);
$trans['delete']['page'] = array(__('Your attempt to delete this page: &#8220;%s&#8221; has failed.'),'get_the_title');
$trans['update']['page'] = array(__('Your attempt to edit this page: &#8220;%s&#8221; has failed.'),'get_the_title');
$trans['edit']['plugin'] = array(__('Your attempt to edit this plugin file: &#8220;%s&#8221; has failed.'),'use_id');
$trans['activate']['plugin'] = array(__('Your attempt to activate this plugin: &#8220;%s&#8221; has failed.'),'use_id');
$trans['deactivate']['plugin'] = array(__('Your attempt to deactivate this plugin: &#8220;%s&#8221; has failed.'),'use_id');
$trans['upgrade']['plugin'] = array(__('Your attempt to upgrade this plugin: &#8220;%s&#8221; has failed.'),'use_id');
$trans['add']['post'] = array(__('Your attempt to add this post has failed.'),false);
$trans['delete']['post'] = array(__('Your attempt to delete this post: &#8220;%s&#8221; has failed.'),'get_the_title');
$trans['update']['post'] = array(__('Your attempt to edit this post: &#8220;%s&#8221; has failed.'),'get_the_title');
$trans['add']['user'] = array(__('Your attempt to add this user has failed.'),false);
$trans['delete']['users'] = array(__('Your attempt to delete users has failed.'),false);
$trans['bulk']['users'] = array(__('Your attempt to bulk modify users has failed.'),false);
$trans['update']['user'] = array(__('Your attempt to edit this user: &#8220;%s&#8221; has failed.'),'get_the_author_meta','display_name');
$trans['update']['profile'] = array(__('Your attempt to modify the profile for: &#8220;%s&#8221; has failed.'),'get_the_author_meta','display_name');
$trans['update']['options'] = array(__('Your attempt to edit your settings has failed.'),false);
$trans['update']['permalink'] = array(__('Your attempt to change your permalink structure to: %s has failed.'),'use_id');
$trans['edit']['file'] = array(__('Your attempt to edit this file: &#8220;%s&#8221; has failed.'),'use_id');
$trans['edit']['theme'] = array(__('Your attempt to edit this theme file: &#8220;%s&#8221; has failed.'),'use_id');
$trans['switch']['theme'] = array(__('Your attempt to switch to this theme: &#8220;%s&#8221; has failed.'),'use_id');
$trans['log']['out'] = array(sprintf(__('You are attempting to log out of %s'),get_bloginfo('sitename')),false);
if ( isset($trans[$verb][$noun]))
 {if ( !empty($trans[$verb][$noun][1]))
 {$lookup = $trans[$verb][$noun][1];
if ( isset($trans[$verb][$noun][2]))
 $lookup_value = $trans[$verb][$noun][2];
$object = $matches[4];
if ( 'use_id' != $lookup)
 {if ( isset($lookup_value))
 $object = AspisUntainted_call_user_func($lookup,$lookup_value,$object);
else 
{$object = AspisUntainted_call_user_func($lookup,$object);
}}{$AspisRetTemp = sprintf($trans[$verb][$noun][0],esc_html($object));
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = $trans[$verb][$noun][0];
return $AspisRetTemp;
}}}}{$AspisRetTemp = apply_filters('explain_nonce_' . $verb . '-' . $noun,__('Are you sure you want to do this?'),isset($matches[4]) ? $matches[4] : '');
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = apply_filters('explain_nonce_' . $action,__('Are you sure you want to do this?'));
return $AspisRetTemp;
}}} }
function wp_nonce_ays ( $action ) {
$title = __('WordPress Failure Notice');
$html = esc_html(wp_explain_nonce($action));
if ( 'log-out' == $action)
 $html .= "</p><p>" . sprintf(__("Do you really want to <a href='%s'>log out</a>?"),wp_logout_url());
elseif ( wp_get_referer())
 $html .= "</p><p><a href='" . esc_url(remove_query_arg('updated',wp_get_referer())) . "'>" . __('Please try again.') . "</a>";
wp_die($html,$title,array('response' => 403));
 }
function wp_die ( $message,$title = '',$args = array() ) {
{global $wp_locale;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_locale,"\$wp_locale",$AspisChangesCache);
}$defaults = array('response' => 500);
$r = wp_parse_args($args,$defaults);
$have_gettext = function_exists('__');
if ( function_exists('is_wp_error') && is_wp_error($message))
 {if ( empty($title))
 {$error_data = $message->get_error_data();
if ( is_array($error_data) && isset($error_data['title']))
 $title = $error_data['title'];
}$errors = $message->get_error_messages();
switch ( count($errors) ) {
case 0:$message = '';
break ;
;
case 1:$message = "<p>{$errors[0]}</p>";
break ;
default :$message = "<ul>\n\t\t<li>" . join("</li>\n\t\t<li>",$errors) . "</li>\n\t</ul>";
break ;
 }
}elseif ( is_string($message))
 {$message = "<p>$message</p>";
}if ( isset($r['back_link']) && $r['back_link'])
 {$back_text = $have_gettext ? __('&laquo; Back') : '&laquo; Back';
$message .= "\n<p><a href='javascript:history.back()'>$back_text</p>";
}if ( defined('WP_SITEURL') && '' != WP_SITEURL)
 $admin_dir = WP_SITEURL . '/wp-admin/';
elseif ( function_exists('get_bloginfo') && '' != get_bloginfo('wpurl'))
 $admin_dir = get_bloginfo('wpurl') . '/wp-admin/';
elseif ( strpos(deAspisWarningRC($_SERVER[0]['PHP_SELF']),'wp-admin') !== false)
 $admin_dir = '';
else 
{$admin_dir = 'wp-admin/';
}if ( !function_exists('did_action') || !did_action('admin_head'))
 {if ( !headers_sent())
 {status_header($r['response']);
nocache_headers();
header('Content-Type: text/html; charset=utf-8');
}if ( empty($title))
 {$title = $have_gettext ? __('WordPress &rsaquo; Error') : 'WordPress &rsaquo; Error';
}$text_direction = 'ltr';
if ( isset($r['text_direction']) && $r['text_direction'] == 'rtl')
 $text_direction = 'rtl';
if ( ($wp_locale) && ('rtl' == $wp_locale->text_direction))
 $text_direction = 'rtl';
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Ticket #11289, IE bug fix: always pad the error page with enough characters such that it is greater than 512 bytes, even after gzip compression abcdefghijklmnopqrstuvwxyz1234567890aabbccddeeffgghhiijjkkllmmnnooppqqrrssttuuvvwwxxyyzz11223344556677889900abacbcbdcdcededfefegfgfhghgihihjijikjkjlklkmlmlnmnmononpopoqpqprqrqsrsrtstsubcbcdcdedefefgfabcadefbghicjkldmnoepqrfstugvwxhyz1i234j567k890laabmbccnddeoeffpgghqhiirjjksklltmmnunoovppqwqrrxsstytuuzvvw0wxx1yyz2z113223434455666777889890091abc2def3ghi4jkl5mno6pqr7stu8vwx9yz11aab2bcc3dd4ee5ff6gg7hh8ii9j0jk1kl2lmm3nnoo4p5pq6qrr7ss8tt9uuvv0wwx1x2yyzz13aba4cbcb5dcdc6dedfef8egf9gfh0ghg1ihi2hji3jik4jkj5lkl6kml7mln8mnm9ono -->
<html xmlns="http://www.w3.org/1999/xhtml" <?php if ( function_exists('language_attributes'))
 language_attributes();
;
?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title;
;
?></title>
	<link rel="stylesheet" href="<?php echo $admin_dir;
;
?>css/install.css" type="text/css" />
<?php if ( 'rtl' == $text_direction)
 {;
?>
	<link rel="stylesheet" href="<?php echo $admin_dir;
;
?>css/install-rtl.css" type="text/css" />
<?php };
?>
</head>
<body id="error-page">
<?php };
?>
	<?php echo $message;
;
?>
</body>
</html>
<?php exit();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
 }
function _config_wp_home ( $url = '' ) {
if ( defined('WP_HOME'))
 {$AspisRetTemp = WP_HOME;
return $AspisRetTemp;
}{$AspisRetTemp = $url;
return $AspisRetTemp;
} }
function _config_wp_siteurl ( $url = '' ) {
if ( defined('WP_SITEURL'))
 {$AspisRetTemp = WP_SITEURL;
return $AspisRetTemp;
}{$AspisRetTemp = $url;
return $AspisRetTemp;
} }
function _mce_set_direction ( $input ) {
{global $wp_locale;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_locale,"\$wp_locale",$AspisChangesCache);
}if ( 'rtl' == $wp_locale->text_direction)
 {$input['directionality'] = 'rtl';
$input['plugins'] .= ',directionality';
$input['theme_advanced_buttons1'] .= ',ltr';
}{$AspisRetTemp = $input;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
 }
function smilies_init (  ) {
{global $wpsmiliestrans,$wp_smiliessearch;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpsmiliestrans,"\$wpsmiliestrans",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_smiliessearch,"\$wp_smiliessearch",$AspisChangesCache);
}if ( !get_option('use_smilies'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpsmiliestrans",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_smiliessearch",$AspisChangesCache);
return ;
}if ( !isset($wpsmiliestrans))
 {$wpsmiliestrans = array(':mrgreen:' => 'icon_mrgreen.gif',':neutral:' => 'icon_neutral.gif',':twisted:' => 'icon_twisted.gif',':arrow:' => 'icon_arrow.gif',':shock:' => 'icon_eek.gif',':smile:' => 'icon_smile.gif',':???:' => 'icon_confused.gif',':cool:' => 'icon_cool.gif',':evil:' => 'icon_evil.gif',':grin:' => 'icon_biggrin.gif',':idea:' => 'icon_idea.gif',':oops:' => 'icon_redface.gif',':razz:' => 'icon_razz.gif',':roll:' => 'icon_rolleyes.gif',':wink:' => 'icon_wink.gif',':cry:' => 'icon_cry.gif',':eek:' => 'icon_surprised.gif',':lol:' => 'icon_lol.gif',':mad:' => 'icon_mad.gif',':sad:' => 'icon_sad.gif','8-)' => 'icon_cool.gif','8-O' => 'icon_eek.gif',':-(' => 'icon_sad.gif',':-)' => 'icon_smile.gif',':-?' => 'icon_confused.gif',':-D' => 'icon_biggrin.gif',':-P' => 'icon_razz.gif',':-o' => 'icon_surprised.gif',':-x' => 'icon_mad.gif',':-|' => 'icon_neutral.gif',';-)' => 'icon_wink.gif','8)' => 'icon_cool.gif','8O' => 'icon_eek.gif',':(' => 'icon_sad.gif',':)' => 'icon_smile.gif',':?' => 'icon_confused.gif',':D' => 'icon_biggrin.gif',':P' => 'icon_razz.gif',':o' => 'icon_surprised.gif',':x' => 'icon_mad.gif',':|' => 'icon_neutral.gif',';)' => 'icon_wink.gif',':!:' => 'icon_exclaim.gif',':?:' => 'icon_question.gif',);
}if ( count($wpsmiliestrans) == 0)
 {{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpsmiliestrans",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_smiliessearch",$AspisChangesCache);
return ;
}}krsort($wpsmiliestrans);
$wp_smiliessearch = '/(?:\s|^)';
$subchar = '';
foreach ( (array)$wpsmiliestrans as $smiley =>$img )
{$firstchar = substr($smiley,0,1);
$rest = substr($smiley,1);
if ( $firstchar != $subchar)
 {if ( $subchar != '')
 {$wp_smiliessearch .= ')|(?:\s|^)';
}$subchar = $firstchar;
$wp_smiliessearch .= preg_quote($firstchar,'/') . '(?:';
}else 
{{$wp_smiliessearch .= '|';
}}$wp_smiliessearch .= preg_quote($rest,'/');
}$wp_smiliessearch .= ')(?:\s|$)/m';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpsmiliestrans",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_smiliessearch",$AspisChangesCache);
 }
function wp_parse_args ( $args,$defaults = '' ) {
if ( is_object($args))
 $r = get_object_vars($args);
elseif ( is_array($args))
 $r = &$args;
else 
{wp_parse_str($args,$r);
}if ( is_array($defaults))
 {$AspisRetTemp = array_merge($defaults,$r);
return $AspisRetTemp;
}{$AspisRetTemp = $r;
return $AspisRetTemp;
} }
function wp_maybe_load_embeds (  ) {
if ( !apply_filters('load_default_embeds',true))
 {return ;
}require_once (ABSPATH . WPINC . '/default-embeds.php');
 }
function wp_maybe_load_widgets (  ) {
if ( !apply_filters('load_default_widgets',true))
 {return ;
}require_once (ABSPATH . WPINC . '/default-widgets.php');
add_action('_admin_menu','wp_widgets_add_menu');
 }
function wp_widgets_add_menu (  ) {
{global $submenu;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $submenu,"\$submenu",$AspisChangesCache);
}$submenu['themes.php'][7] = array(__('Widgets'),'switch_themes','widgets.php');
ksort($submenu['themes.php'],SORT_NUMERIC);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$submenu",$AspisChangesCache);
 }
function wp_ob_end_flush_all (  ) {
$levels = ob_get_level();
for ( $i = 0 ; $i < $levels ; $i++ )
ob_end_flush();
 }
function require_wp_db (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( file_exists(WP_CONTENT_DIR . '/db.php'))
 require_once (WP_CONTENT_DIR . '/db.php');
else 
{require_once (ABSPATH . WPINC . '/wp-db.php');
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function dead_db (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( file_exists(WP_CONTENT_DIR . '/db-error.php'))
 {require_once (WP_CONTENT_DIR . '/db-error.php');
exit();
}if ( defined('WP_INSTALLING') || defined('WP_ADMIN'))
 wp_die($wpdb->error);
status_header(500);
nocache_headers();
header('Content-Type: text/html; charset=utf-8');
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php if ( function_exists('language_attributes'))
 language_attributes();
;
?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Database Error</title>

</head>
<body>
	<h1>Error establishing a database connection</h1>
</body>
</html>
<?php exit();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function absint ( $maybeint ) {
{$AspisRetTemp = abs(intval($maybeint));
return $AspisRetTemp;
} }
function url_is_accessable_via_ssl ( $url ) {
if ( in_array('curl',get_loaded_extensions()))
 {$ssl = preg_replace('/^http:\/\//','https://',$url);
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$ssl);
curl_setopt($ch,CURLOPT_FAILONERROR,true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
curl_exec($ch);
$status = curl_getinfo($ch,CURLINFO_HTTP_CODE);
curl_close($ch);
if ( $status == 200 || $status == 401)
 {{$AspisRetTemp = true;
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function atom_service_url_filter ( $url ) {
if ( url_is_accessable_via_ssl($url))
 {$AspisRetTemp = preg_replace('/^http:\/\//','https://',$url);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = $url;
return $AspisRetTemp;
}} }
function _deprecated_function ( $function,$version,$replacement = null ) {
do_action('deprecated_function_run',$function,$replacement);
if ( WP_DEBUG && apply_filters('deprecated_function_trigger_error',true))
 {if ( !is_null($replacement))
 trigger_error(sprintf(__('%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.'),$function,$version,$replacement));
else 
{trigger_error(sprintf(__('%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.'),$function,$version));
}} }
function _deprecated_file ( $file,$version,$replacement = null ) {
do_action('deprecated_file_included',$file,$replacement);
if ( WP_DEBUG && apply_filters('deprecated_file_trigger_error',true))
 {if ( !is_null($replacement))
 trigger_error(sprintf(__('%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.'),$file,$version,$replacement));
else 
{trigger_error(sprintf(__('%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.'),$file,$version));
}} }
function is_lighttpd_before_150 (  ) {
$server_parts = explode('/',(isset($_SERVER[0]['SERVER_SOFTWARE']) && Aspis_isset($_SERVER[0]['SERVER_SOFTWARE'])) ? deAspisWarningRC($_SERVER[0]['SERVER_SOFTWARE']) : '');
$server_parts[1] = isset($server_parts[1]) ? $server_parts[1] : '';
{$AspisRetTemp = 'lighttpd' == $server_parts[0] && -1 == version_compare($server_parts[1],'1.5.0');
return $AspisRetTemp;
} }
function apache_mod_loaded ( $mod,$default = false ) {
{global $is_apache;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $is_apache,"\$is_apache",$AspisChangesCache);
}if ( !$is_apache)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_apache",$AspisChangesCache);
return $AspisRetTemp;
}if ( function_exists('apache_get_modules'))
 {$mods = apache_get_modules();
if ( in_array($mod,$mods))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_apache",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( function_exists('phpinfo'))
 {ob_start();
phpinfo(8);
$phpinfo = ob_get_clean();
if ( false !== strpos($phpinfo,$mod))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_apache",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = $default;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_apache",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_apache",$AspisChangesCache);
 }
function validate_file ( $file,$allowed_files = '' ) {
if ( false !== strpos($file,'..'))
 {$AspisRetTemp = 1;
return $AspisRetTemp;
}if ( false !== strpos($file,'./'))
 {$AspisRetTemp = 1;
return $AspisRetTemp;
}if ( !empty($allowed_files) && (!in_array($file,$allowed_files)))
 {$AspisRetTemp = 3;
return $AspisRetTemp;
}if ( ':' == substr($file,1,1))
 {$AspisRetTemp = 2;
return $AspisRetTemp;
}{$AspisRetTemp = 0;
return $AspisRetTemp;
} }
function is_ssl (  ) {
if ( (isset($_SERVER[0]['HTTPS']) && Aspis_isset($_SERVER[0]['HTTPS'])))
 {if ( 'on' == strtolower(deAspisWarningRC($_SERVER[0]['HTTPS'])))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}if ( '1' == deAspisWarningRC($_SERVER[0]['HTTPS']))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}}elseif ( (isset($_SERVER[0]['SERVER_PORT']) && Aspis_isset($_SERVER[0]['SERVER_PORT'])) && ('443' == deAspisWarningRC($_SERVER[0]['SERVER_PORT'])))
 {{$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function force_ssl_login ( $force = null ) {
static $forced = false;
if ( !is_null($force))
 {$old_forced = $forced;
$forced = $force;
{$AspisRetTemp = $old_forced;
return $AspisRetTemp;
}}{$AspisRetTemp = $forced;
return $AspisRetTemp;
} }
function force_ssl_admin ( $force = null ) {
static $forced = false;
if ( !is_null($force))
 {$old_forced = $forced;
$forced = $force;
{$AspisRetTemp = $old_forced;
return $AspisRetTemp;
}}{$AspisRetTemp = $forced;
return $AspisRetTemp;
} }
function wp_guess_url (  ) {
if ( defined('WP_SITEURL') && '' != WP_SITEURL)
 {$url = WP_SITEURL;
}else 
{{$schema = ((isset($_SERVER[0]['HTTPS']) && Aspis_isset($_SERVER[0]['HTTPS'])) && strtolower(deAspisWarningRC($_SERVER[0]['HTTPS'])) == 'on') ? 'https://' : 'http://';
$url = preg_replace('|/wp-admin/.*|i','',$schema . deAspisWarningRC($_SERVER[0]['HTTP_HOST']) . deAspisWarningRC($_SERVER[0]['REQUEST_URI']));
}}{$AspisRetTemp = $url;
return $AspisRetTemp;
} }
function wp_suspend_cache_invalidation ( $suspend = true ) {
{global $_wp_suspend_cache_invalidation;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_suspend_cache_invalidation,"\$_wp_suspend_cache_invalidation",$AspisChangesCache);
}$current_suspend = $_wp_suspend_cache_invalidation;
$_wp_suspend_cache_invalidation = $suspend;
{$AspisRetTemp = $current_suspend;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_suspend_cache_invalidation",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_suspend_cache_invalidation",$AspisChangesCache);
 }
function get_site_option ( $key,$default = false,$use_cache = true ) {
$pre = apply_filters('pre_site_option_' . $key,false);
if ( false !== $pre)
 {$AspisRetTemp = $pre;
return $AspisRetTemp;
}$value = get_option($key,$default);
{$AspisRetTemp = apply_filters('site_option_' . $key,$value);
return $AspisRetTemp;
} }
function add_site_option ( $key,$value ) {
$value = apply_filters('pre_add_site_option_' . $key,$value);
$result = add_option($key,$value);
do_action("add_site_option_{$key}",$key,$value);
{$AspisRetTemp = $result;
return $AspisRetTemp;
} }
function delete_site_option ( $key ) {
$result = delete_option($key);
do_action("delete_site_option_{$key}",$key);
{$AspisRetTemp = $result;
return $AspisRetTemp;
} }
function update_site_option ( $key,$value ) {
$oldvalue = get_site_option($key);
$value = apply_filters('pre_update_site_option_' . $key,$value,$oldvalue);
$result = update_option($key,$value);
do_action("update_site_option_{$key}",$key,$value);
{$AspisRetTemp = $result;
return $AspisRetTemp;
} }
function delete_site_transient ( $transient ) {
{global $_wp_using_ext_object_cache,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_using_ext_object_cache,"\$_wp_using_ext_object_cache",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( $_wp_using_ext_object_cache)
 {{$AspisRetTemp = wp_cache_delete($transient,'site-transient');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{$transient = '_site_transient_' . deAspisWarningRC(esc_sql(attAspisRCO($transient)));
{$AspisRetTemp = delete_site_option($transient);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function get_site_transient ( $transient ) {
{global $_wp_using_ext_object_cache,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_using_ext_object_cache,"\$_wp_using_ext_object_cache",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}$pre = apply_filters('pre_site_transient_' . $transient,false);
if ( false !== $pre)
 {$AspisRetTemp = $pre;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( $_wp_using_ext_object_cache)
 {$value = wp_cache_get($transient,'site-transient');
}else 
{{$transient_option = '_site_transient_' . deAspisWarningRC(esc_sql(attAspisRCO($transient)));
$transient_timeout = '_site_transient_timeout_' . deAspisWarningRC(esc_sql(attAspisRCO($transient)));
if ( get_site_option($transient_timeout) < time())
 {delete_site_option($transient_option);
delete_site_option($transient_timeout);
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}$value = get_site_option($transient_option);
}}{$AspisRetTemp = apply_filters('site_transient_' . $transient,$value);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function set_site_transient ( $transient,$value,$expiration = 0 ) {
{global $_wp_using_ext_object_cache,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_using_ext_object_cache,"\$_wp_using_ext_object_cache",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( $_wp_using_ext_object_cache)
 {{$AspisRetTemp = wp_cache_set($transient,$value,'site-transient',$expiration);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{$transient_timeout = '_site_transient_timeout_' . $transient;
$transient = '_site_transient_' . $transient;
$safe_transient = deAspisWarningRC(esc_sql(attAspisRCO($transient)));
if ( false === get_site_option($safe_transient))
 {if ( 0 != $expiration)
 add_site_option($transient_timeout,time() + $expiration);
{$AspisRetTemp = add_site_option($transient,$value);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{if ( 0 != $expiration)
 update_site_option($transient_timeout,time() + $expiration);
{$AspisRetTemp = update_site_option($transient,$value);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_using_ext_object_cache",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function wp_timezone_override_offset (  ) {
if ( !wp_timezone_supported())
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( !$timezone_string = get_option('timezone_string'))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}@date_default_timezone_set($timezone_string);
$timezone_object = timezone_open($timezone_string);
$datetime_object = date_create();
if ( false === $timezone_object || false === $datetime_object)
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}{$AspisRetTemp = round(timezone_offset_get($timezone_object,$datetime_object) / 3600,2);
return $AspisRetTemp;
} }
function wp_timezone_supported (  ) {
$support = false;
if ( function_exists('date_default_timezone_set') && function_exists('timezone_identifiers_list') && function_exists('timezone_open') && function_exists('timezone_offset_get'))
 {$support = true;
}{$AspisRetTemp = apply_filters('timezone_support',$support);
return $AspisRetTemp;
} }
function _wp_timezone_choice_usort_callback ( $a,$b ) {
if ( 'Etc' === $a['continent'] && 'Etc' === $b['continent'])
 {if ( 'GMT+' === substr($a['city'],0,4) && 'GMT+' === substr($b['city'],0,4))
 {{$AspisRetTemp = -1 * (strnatcasecmp($a['city'],$b['city']));
return $AspisRetTemp;
}}if ( 'UTC' === $a['city'])
 {if ( 'GMT+' === substr($b['city'],0,4))
 {{$AspisRetTemp = 1;
return $AspisRetTemp;
}}{$AspisRetTemp = -1;
return $AspisRetTemp;
}}if ( 'UTC' === $b['city'])
 {if ( 'GMT+' === substr($a['city'],0,4))
 {{$AspisRetTemp = -1;
return $AspisRetTemp;
}}{$AspisRetTemp = 1;
return $AspisRetTemp;
}}{$AspisRetTemp = strnatcasecmp($a['city'],$b['city']);
return $AspisRetTemp;
}}if ( $a['t_continent'] == $b['t_continent'])
 {if ( $a['t_city'] == $b['t_city'])
 {{$AspisRetTemp = strnatcasecmp($a['t_subcity'],$b['t_subcity']);
return $AspisRetTemp;
}}{$AspisRetTemp = strnatcasecmp($a['t_city'],$b['t_city']);
return $AspisRetTemp;
}}else 
{{if ( 'Etc' === $a['continent'])
 {{$AspisRetTemp = 1;
return $AspisRetTemp;
}}if ( 'Etc' === $b['continent'])
 {{$AspisRetTemp = -1;
return $AspisRetTemp;
}}{$AspisRetTemp = strnatcasecmp($a['t_continent'],$b['t_continent']);
return $AspisRetTemp;
}}} }
function wp_timezone_choice ( $selected_zone ) {
static $mo_loaded = false;
$continents = array('Africa','America','Antarctica','Arctic','Asia','Atlantic','Australia','Europe','Indian','Pacific');
if ( !$mo_loaded)
 {$locale = get_locale();
$mofile = WP_LANG_DIR . '/continents-cities-' . $locale . '.mo';
load_textdomain('continents-cities',$mofile);
$mo_loaded = true;
}$zonen = array();
foreach ( timezone_identifiers_list() as $zone  )
{$zone = explode('/',$zone);
if ( !in_array($zone[0],$continents))
 {continue ;
}$exists = array(0 => (isset($zone[0]) && $zone[0]) ? true : false,1 => (isset($zone[1]) && $zone[1]) ? true : false,2 => (isset($zone[2]) && $zone[2]) ? true : false);
$exists[3] = ($exists[0] && 'Etc' !== $zone[0]) ? true : false;
$exists[4] = ($exists[1] && $exists[3]) ? true : false;
$exists[5] = ($exists[2] && $exists[3]) ? true : false;
$zonen[] = array('continent' => ($exists[0] ? $zone[0] : ''),'city' => ($exists[1] ? $zone[1] : ''),'subcity' => ($exists[2] ? $zone[2] : ''),'t_continent' => ($exists[3] ? translate(str_replace('_',' ',$zone[0]),'continents-cities') : ''),'t_city' => ($exists[4] ? translate(str_replace('_',' ',$zone[1]),'continents-cities') : ''),'t_subcity' => ($exists[5] ? translate(str_replace('_',' ',$zone[2]),'continents-cities') : ''));
}AspisUntainted_usort($zonen,'_wp_timezone_choice_usort_callback');
$structure = array();
if ( empty($selected_zone))
 {$structure[] = '<option selected="selected" value="">' . __('Select a city') . '</option>';
}foreach ( $zonen as $key =>$zone )
{$value = array($zone['continent']);
if ( empty($zone['city']))
 {$display = $zone['t_continent'];
}else 
{{if ( !isset($zonen[$key - 1]) || $zonen[$key - 1]['continent'] !== $zone['continent'])
 {$label = $zone['t_continent'];
$structure[] = '<optgroup label="' . esc_attr($label) . '">';
}$value[] = $zone['city'];
$display = $zone['t_city'];
if ( !empty($zone['subcity']))
 {$value[] = $zone['subcity'];
$display .= ' - ' . $zone['t_subcity'];
}}}$value = join('/',$value);
$selected = '';
if ( $value === $selected_zone)
 {$selected = 'selected="selected" ';
}$structure[] = '<option ' . $selected . 'value="' . esc_attr($value) . '">' . esc_html($display) . "</option>";
if ( !empty($zone['city']) && (!isset($zonen[$key + 1]) || (isset($zonen[$key + 1]) && $zonen[$key + 1]['continent'] !== $zone['continent'])))
 {$structure[] = '</optgroup>';
}}$structure[] = '<optgroup label="' . esc_attr__('UTC') . '">';
$selected = '';
if ( 'UTC' === $selected_zone)
 $selected = 'selected="selected" ';
$structure[] = '<option ' . $selected . 'value="' . esc_attr('UTC') . '">' . __('UTC') . '</option>';
$structure[] = '</optgroup>';
$structure[] = '<optgroup label="' . esc_attr__('Manual Offsets') . '">';
$offset_range = array(-12,-11.5,-11,-10.5,-10,-9.5,-9,-8.5,-8,-7.5,-7,-6.5,-6,-5.5,-5,-4.5,-4,-3.5,-3,-2.5,-2,-1.5,-1,-0.5,0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5,5.5,5.75,6,6.5,7,7.5,8,8.5,8.75,9,9.5,10,10.5,11,11.5,12,12.75,13,13.75,14);
foreach ( $offset_range as $offset  )
{if ( 0 <= $offset)
 $offset_name = '+' . $offset;
else 
{$offset_name = (string)$offset;
}$offset_value = $offset_name;
$offset_name = str_replace(array('.25','.5','.75'),array(':15',':30',':45'),$offset_name);
$offset_name = 'UTC' . $offset_name;
$offset_value = 'UTC' . $offset_value;
$selected = '';
if ( $offset_value === $selected_zone)
 $selected = 'selected="selected" ';
$structure[] = '<option ' . $selected . 'value="' . esc_attr($offset_value) . '">' . esc_html($offset_name) . "</option>";
}$structure[] = '</optgroup>';
{$AspisRetTemp = join("\n",$structure);
return $AspisRetTemp;
} }
function _cleanup_header_comment ( $str ) {
{$AspisRetTemp = trim(preg_replace("/\s*(?:\*\/|\?>).*/",'',$str));
return $AspisRetTemp;
} }
function wp_scheduled_delete (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$delete_timestamp = time() - (60 * 60 * 24 * EMPTY_TRASH_DAYS);
$posts_to_delete = $wpdb->get_results($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_trash_meta_time' AND meta_value < '%d'",$delete_timestamp),ARRAY_A);
foreach ( (array)$posts_to_delete as $post  )
{$post_id = (int)$post['post_id'];
if ( !$post_id)
 continue ;
$del_post = get_post($post_id);
if ( !$del_post || 'trash' != $del_post->post_status)
 {delete_post_meta($post_id,'_wp_trash_meta_status');
delete_post_meta($post_id,'_wp_trash_meta_time');
}else 
{{wp_delete_post($post_id);
}}}$comments_to_delete = $wpdb->get_results($wpdb->prepare("SELECT comment_id FROM $wpdb->commentmeta WHERE meta_key = '_wp_trash_meta_time' AND meta_value < '%d'",$delete_timestamp),ARRAY_A);
foreach ( (array)$comments_to_delete as $comment  )
{$comment_id = (int)$comment['comment_id'];
if ( !$comment_id)
 continue ;
$del_comment = get_comment($comment_id);
if ( !$del_comment || 'trash' != $del_comment->comment_approved)
 {delete_comment_meta($comment_id,'_wp_trash_meta_time');
delete_comment_meta($comment_id,'_wp_trash_meta_status');
}else 
{{wp_delete_comment($comment_id);
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_file_data ( $file,$default_headers,$context = '' ) {
$fp = fopen($file,'r');
$file_data = fread($fp,8192);
fclose($fp);
if ( $context != '')
 {$extra_headers = apply_filters("extra_$context" . '_headers',array());
$extra_headers = array_flip($extra_headers);
foreach ( $extra_headers as $key =>$value )
{$extra_headers[$key] = $key;
}$all_headers = array_merge($extra_headers,$default_headers);
}else 
{{$all_headers = $default_headers;
}}foreach ( $all_headers as $field =>$regex )
{preg_match('/' . preg_quote($regex,'/') . ':(.*)$/mi',$file_data,${$field});
if ( !empty(${$field}))
 ${$field} = _cleanup_header_comment(${$field}[1]);
else 
{${$field} = '';
}}$file_data = compact(array_keys($all_headers));
{$AspisRetTemp = $file_data;
return $AspisRetTemp;
} }
function _search_terms_tidy ( $t ) {
{$AspisRetTemp = trim($t,"\"'\n\r ");
return $AspisRetTemp;
} }
;
?>
<?php 