<?php require_once('AspisMain.php'); ?><?php
class WP_Upgrader{var $strings = array(array(),false);
var $skin = array(null,false);
var $result = array(array(),false);
function WP_Upgrader ( $skin = array(null,false) ) {
{return $this->__construct($skin);
} }
function __construct ( $skin = array(null,false) ) {
{if ( (null == $skin[0]))
 $this->skin = array(new WP_Upgrader_Skin(),false);
else 
{$this->skin = $skin;
}} }
function init (  ) {
{$this->skin[0]->set_upgrader(array($this,false));
$this->generic_strings();
} }
function generic_strings (  ) {
{arrayAssign($this->strings[0],deAspis(registerTaint(array('bad_request',false))),addTaint(__(array('Invalid Data provided.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('fs_unavailable',false))),addTaint(__(array('Could not access filesystem.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('fs_error',false))),addTaint(__(array('Filesystem error',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('fs_no_root_dir',false))),addTaint(__(array('Unable to locate WordPress Root directory.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('fs_no_content_dir',false))),addTaint(__(array('Unable to locate WordPress Content directory (wp-content).',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('fs_no_plugins_dir',false))),addTaint(__(array('Unable to locate WordPress Plugin directory.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('fs_no_themes_dir',false))),addTaint(__(array('Unable to locate WordPress Theme directory.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('fs_no_folder',false))),addTaint(__(array('Unable to locate needed folder (%s).',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('download_failed',false))),addTaint(__(array('Download failed.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('installing_package',false))),addTaint(__(array('Installing the latest version.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('folder_exists',false))),addTaint(__(array('Destination folder already exists.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('mkdir_failed',false))),addTaint(__(array('Could not create directory.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('bad_package',false))),addTaint(__(array('Incompatible Archive',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('maintenance_start',false))),addTaint(__(array('Enabling Maintenance mode.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('maintenance_end',false))),addTaint(__(array('Disabling Maintenance mode.',false))));
} }
function fs_connect ( $directories = array(array(),false) ) {
{global $wp_filesystem;
if ( (false === deAspis(($credentials = $this->skin[0]->request_filesystem_credentials()))))
 return array(false,false);
if ( (denot_boolean(WP_Filesystem($credentials))))
 {$error = array(true,false);
if ( (is_object($wp_filesystem[0]) && deAspis($wp_filesystem[0]->errors[0]->get_error_code())))
 $error = $wp_filesystem[0]->errors;
$this->skin[0]->request_filesystem_credentials($error);
return array(false,false);
}if ( (!(is_object($wp_filesystem[0]))))
 return array(new WP_Error(array('fs_unavailable',false),$this->strings[0][('fs_unavailable')]),false);
if ( (deAspis(is_wp_error($wp_filesystem[0]->errors)) && deAspis($wp_filesystem[0]->errors[0]->get_error_code())))
 return array(new WP_Error(array('fs_error',false),$this->strings[0][('fs_error')],$wp_filesystem[0]->errors),false);
foreach ( deAspis(array_cast($directories)) as $dir  )
{switch ( $dir[0] ) {
case ABSPATH:if ( (denot_boolean($wp_filesystem[0]->abspath())))
 return array(new WP_Error(array('fs_no_root_dir',false),$this->strings[0][('fs_no_root_dir')]),false);
break ;
case WP_CONTENT_DIR:if ( (denot_boolean($wp_filesystem[0]->wp_content_dir())))
 return array(new WP_Error(array('fs_no_content_dir',false),$this->strings[0][('fs_no_content_dir')]),false);
break ;
case WP_PLUGIN_DIR:if ( (denot_boolean($wp_filesystem[0]->wp_plugins_dir())))
 return array(new WP_Error(array('fs_no_plugins_dir',false),$this->strings[0][('fs_no_plugins_dir')]),false);
break ;
case (deconcat12(WP_CONTENT_DIR,'/themes')):if ( (denot_boolean($wp_filesystem[0]->find_folder(concat12(WP_CONTENT_DIR,'/themes')))))
 return array(new WP_Error(array('fs_no_themes_dir',false),$this->strings[0][('fs_no_themes_dir')]),false);
break ;
default :if ( (denot_boolean($wp_filesystem[0]->find_folder($dir))))
 return array(new WP_Error(array('fs_no_folder',false),Aspis_sprintf($this->strings[0][('fs_no_folder')],$dir)),false);
break ;
 }
}return array(true,false);
} }
function download_package ( $package ) {
{if ( ((denot_boolean(Aspis_preg_match(array('!^(http|https|ftp)://!i',false),$package))) && file_exists($package[0])))
 return $package;
if ( ((empty($package) || Aspis_empty( $package))))
 return array(new WP_Error(array('no_package',false),$this->strings[0][('no_package')]),false);
$this->skin[0]->feedback(array('downloading_package',false),$package);
$download_file = download_url($package);
if ( deAspis(is_wp_error($download_file)))
 return array(new WP_Error(array('download_failed',false),$this->strings[0][('download_failed')],$download_file[0]->get_error_message()),false);
return $download_file;
} }
function unpack_package ( $package,$delete_package = array(true,false) ) {
{global $wp_filesystem;
$this->skin[0]->feedback(array('unpack_package',false));
$upgrade_folder = concat2($wp_filesystem[0]->wp_content_dir(),'upgrade/');
$upgrade_files = $wp_filesystem[0]->dirlist($upgrade_folder);
if ( (!((empty($upgrade_files) || Aspis_empty( $upgrade_files)))))
 {foreach ( $upgrade_files[0] as $file  )
$wp_filesystem[0]->delete(concat($upgrade_folder,$file[0]['name']),array(true,false));
}$working_dir = concat($upgrade_folder,Aspis_basename($package,array('.zip',false)));
if ( deAspis($wp_filesystem[0]->is_dir($working_dir)))
 $wp_filesystem[0]->delete($working_dir,array(true,false));
$result = unzip_file($package,$working_dir);
if ( $delete_package[0])
 unlink($package[0]);
if ( deAspis(is_wp_error($result)))
 {$wp_filesystem[0]->delete($working_dir,array(true,false));
return $result;
}return $working_dir;
} }
function install_package ( $args = array(array(),false) ) {
{global $wp_filesystem;
$defaults = array(array('source' => array('',false,false),'destination' => array('',false,false),'clear_destination' => array(false,false,false),'clear_working' => array(false,false,false),'hook_extra' => array(array(),false,false)),false);
$args = wp_parse_args($args,$defaults);
extract(($args[0]));
@array(set_time_limit(300),false);
if ( (((empty($source) || Aspis_empty( $source))) || ((empty($destination) || Aspis_empty( $destination)))))
 return array(new WP_Error(array('bad_request',false),$this->strings[0][('bad_request')]),false);
$this->skin[0]->feedback(array('installing_package',false));
$res = apply_filters(array('upgrader_pre_install',false),array(true,false),$hook_extra);
if ( deAspis(is_wp_error($res)))
 return $res;
$remote_source = $source;
$local_destination = $destination;
$source_files = attAspisRC(array_keys(deAspisRC($wp_filesystem[0]->dirlist($remote_source))));
$remote_destination = $wp_filesystem[0]->find_folder($local_destination);
if ( (((1) == count($source_files[0])) && deAspis($wp_filesystem[0]->is_dir(concat2(concat(trailingslashit($source),attachAspis($source_files,(0))),'/')))))
 $source = concat(trailingslashit($source),trailingslashit(attachAspis($source_files,(0))));
elseif ( (count($source_files[0]) == (0)))
 return array(new WP_Error(array('bad_package',false),$this->strings[0][('bad_package')]),false);
$source = apply_filters(array('upgrader_source_selection',false),$source,$remote_source,array($this,false));
if ( deAspis(is_wp_error($source)))
 return $source;
if ( ($source[0] !== $remote_source[0]))
 $source_files = attAspisRC(array_keys(deAspisRC($wp_filesystem[0]->dirlist($source))));
if ( deAspis(Aspis_in_array($destination,array(array(array(ABSPATH,false),array(WP_CONTENT_DIR,false),array(WP_PLUGIN_DIR,false),concat12(WP_CONTENT_DIR,'/themes')),false))))
 {$remote_destination = concat(trailingslashit($remote_destination),trailingslashit(Aspis_basename($source)));
$destination = concat(trailingslashit($destination),trailingslashit(Aspis_basename($source)));
}if ( deAspis($wp_filesystem[0]->exists($remote_destination)))
 {if ( $clear_destination[0])
 {$this->skin[0]->feedback(array('remove_old',false));
$removed = $wp_filesystem[0]->delete($remote_destination,array(true,false));
$removed = apply_filters(array('upgrader_clear_destination',false),$removed,$local_destination,$remote_destination,$hook_extra);
if ( deAspis(is_wp_error($removed)))
 return $removed;
else 
{if ( (denot_boolean($removed)))
 return array(new WP_Error(array('remove_old_failed',false),$this->strings[0][('remove_old_failed')]),false);
}}else 
{{$_files = $wp_filesystem[0]->dirlist($remote_destination);
if ( (!((empty($_files) || Aspis_empty( $_files)))))
 {$wp_filesystem[0]->delete($remote_source,array(true,false));
return array(new WP_Error(array('folder_exists',false),$this->strings[0][('folder_exists')],$remote_destination),false);
}}}}if ( (denot_boolean($wp_filesystem[0]->exists($remote_destination))))
 if ( (denot_boolean($wp_filesystem[0]->mkdir($remote_destination,array(FS_CHMOD_DIR,false)))))
 return array(new WP_Error(array('mkdir_failed',false),$this->strings[0][('mkdir_failed')],$remote_destination),false);
$result = copy_dir($source,$remote_destination);
if ( deAspis(is_wp_error($result)))
 {if ( $clear_working[0])
 $wp_filesystem[0]->delete($remote_source,array(true,false));
return $result;
}if ( $clear_working[0])
 $wp_filesystem[0]->delete($remote_source,array(true,false));
$destination_name = Aspis_basename(Aspis_str_replace($local_destination,array('',false),$destination));
if ( (('.') == $destination_name[0]))
 $destination_name = array('',false);
$this->result = array(compact('local_source','source','source_name','source_files','destination','destination_name','local_destination','remote_destination','clear_destination','delete_source_dir'),false);
$res = apply_filters(array('upgrader_post_install',false),array(true,false),$hook_extra,$this->result);
if ( deAspis(is_wp_error($res)))
 {$this->result = $res;
return $res;
}return $this->result;
} }
function run ( $options ) {
{$defaults = array(array('package' => array('',false,false),'destination' => array('',false,false),'clear_destination' => array(false,false,false),'clear_working' => array(true,false,false),'is_multi' => array(false,false,false),'hook_extra' => array(array(),false,false)),false);
$options = wp_parse_args($options,$defaults);
extract(($options[0]));
$res = $this->fs_connect(array(array(array(WP_CONTENT_DIR,false),$destination),false));
if ( (denot_boolean($res)))
 return array(false,false);
if ( deAspis(is_wp_error($res)))
 {$this->skin[0]->error($res);
return $res;
}if ( (denot_boolean($is_multi)))
 $this->skin[0]->header();
$this->skin[0]->before();
$download = $this->download_package($package);
if ( deAspis(is_wp_error($download)))
 {$this->skin[0]->error($download);
return $download;
}$working_dir = $this->unpack_package($download);
if ( deAspis(is_wp_error($working_dir)))
 {$this->skin[0]->error($working_dir);
return $working_dir;
}$result = $this->install_package(array(array(deregisterTaint(array('source',false)) => addTaint($working_dir),deregisterTaint(array('destination',false)) => addTaint($destination),deregisterTaint(array('clear_destination',false)) => addTaint($clear_destination),deregisterTaint(array('clear_working',false)) => addTaint($clear_working),deregisterTaint(array('hook_extra',false)) => addTaint($hook_extra)),false));
$this->skin[0]->set_result($result);
if ( deAspis(is_wp_error($result)))
 {$this->skin[0]->error($result);
$this->skin[0]->feedback(array('process_failed',false));
}else 
{{$this->skin[0]->feedback(array('process_success',false));
}}$this->skin[0]->after();
if ( (denot_boolean($is_multi)))
 $this->skin[0]->footer();
return $result;
} }
function maintenance_mode ( $enable = array(false,false) ) {
{global $wp_filesystem;
$file = concat2($wp_filesystem[0]->abspath(),'.maintenance');
if ( $enable[0])
 {$this->skin[0]->feedback(array('maintenance_start',false));
$maintenance_string = concat2(concat1('<?php $upgrading = ',attAspis(time())),'; ?>');
$wp_filesystem[0]->delete($file);
$wp_filesystem[0]->put_contents($file,$maintenance_string,array(FS_CHMOD_FILE,false));
}else 
{if ( ((denot_boolean($enable)) && deAspis($wp_filesystem[0]->exists($file))))
 {$this->skin[0]->feedback(array('maintenance_end',false));
$wp_filesystem[0]->delete($file);
}}} }
}class Plugin_Upgrader extends WP_Upgrader{var $result;
var $bulk = array(false,false);
var $show_before = array('',false);
function upgrade_strings (  ) {
{arrayAssign($this->strings[0],deAspis(registerTaint(array('up_to_date',false))),addTaint(__(array('The plugin is at the latest version.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('no_package',false))),addTaint(__(array('Upgrade package not available.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('downloading_package',false))),addTaint(__(array('Downloading update from <span class="code">%s</span>.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('unpack_package',false))),addTaint(__(array('Unpacking the update.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('deactivate_plugin',false))),addTaint(__(array('Deactivating the plugin.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('remove_old',false))),addTaint(__(array('Removing the old version of the plugin.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('remove_old_failed',false))),addTaint(__(array('Could not remove the old plugin.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('process_failed',false))),addTaint(__(array('Plugin upgrade Failed.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('process_success',false))),addTaint(__(array('Plugin upgraded successfully.',false))));
} }
function install_strings (  ) {
{arrayAssign($this->strings[0],deAspis(registerTaint(array('no_package',false))),addTaint(__(array('Install package not available.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('downloading_package',false))),addTaint(__(array('Downloading install package from <span class="code">%s</span>.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('unpack_package',false))),addTaint(__(array('Unpacking the package.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('installing_package',false))),addTaint(__(array('Installing the plugin.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('process_failed',false))),addTaint(__(array('Plugin Install Failed.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('process_success',false))),addTaint(__(array('Plugin Installed successfully.',false))));
} }
function install ( $package ) {
{$this->init();
$this->install_strings();
$this->run(array(array(deregisterTaint(array('package',false)) => addTaint($package),'destination' => array(WP_PLUGIN_DIR,false,false),'clear_destination' => array(false,false,false),'clear_working' => array(true,false,false),'hook_extra' => array(array(),false,false)),false));
delete_transient(array('update_plugins',false));
} }
function upgrade ( $plugin ) {
{$this->init();
$this->upgrade_strings();
$current = get_transient(array('update_plugins',false));
if ( (!((isset($current[0]->response[0][$plugin[0]]) && Aspis_isset( $current[0] ->response [0][$plugin[0]] )))))
 {$this->skin[0]->set_result(array(false,false));
$this->skin[0]->error(array('up_to_date',false));
$this->skin[0]->after();
return array(false,false);
}$r = $current[0]->response[0][$plugin[0]];
add_filter(array('upgrader_pre_install',false),array(array(array($this,false),array('deactivate_plugin_before_upgrade',false)),false),array(10,false),array(2,false));
add_filter(array('upgrader_clear_destination',false),array(array(array($this,false),array('delete_old_plugin',false)),false),array(10,false),array(4,false));
$this->run(array(array(deregisterTaint(array('package',false)) => addTaint($r[0]->package),'destination' => array(WP_PLUGIN_DIR,false,false),'clear_destination' => array(true,false,false),'clear_working' => array(true,false,false),'hook_extra' => array(array(deregisterTaint(array('plugin',false)) => addTaint($plugin)),false,false)),false));
remove_filter(array('upgrader_pre_install',false),array(array(array($this,false),array('deactivate_plugin_before_upgrade',false)),false));
remove_filter(array('upgrader_clear_destination',false),array(array(array($this,false),array('delete_old_plugin',false)),false));
if ( ((denot_boolean($this->result)) || deAspis(is_wp_error($this->result))))
 return $this->result;
delete_transient(array('update_plugins',false));
} }
function bulk_upgrade ( $plugins ) {
{$this->init();
$this->bulk = array(true,false);
$this->upgrade_strings();
$current = get_transient(array('update_plugins',false));
add_filter(array('upgrader_clear_destination',false),array(array(array($this,false),array('delete_old_plugin',false)),false),array(10,false),array(4,false));
$this->skin[0]->header();
$res = $this->fs_connect(array(array(array(WP_CONTENT_DIR,false),array(WP_PLUGIN_DIR,false)),false));
if ( (denot_boolean($res)))
 {$this->skin[0]->footer();
return array(false,false);
}$this->maintenance_mode(array(true,false));
$all = attAspis(count($plugins[0]));
$i = array(1,false);
foreach ( $plugins[0] as $plugin  )
{$this->show_before = Aspis_sprintf(concat2(concat1('<h4>',__(array('Updating plugin %1$d of %2$d...',false))),'</h4>'),$i,$all);
postincr($i);
if ( (!((isset($current[0]->response[0][$plugin[0]]) && Aspis_isset( $current[0] ->response [0][$plugin[0]] )))))
 {$this->skin[0]->set_result(array(false,false));
$this->skin[0]->error(array('up_to_date',false));
$this->skin[0]->after();
arrayAssign($results[0],deAspis(registerTaint($plugin)),addTaint(array(false,false)));
continue ;
}$r = $current[0]->response[0][$plugin[0]];
$this->skin[0]->plugin_active = is_plugin_active($plugin);
$result = $this->run(array(array(deregisterTaint(array('package',false)) => addTaint($r[0]->package),'destination' => array(WP_PLUGIN_DIR,false,false),'clear_destination' => array(true,false,false),'clear_working' => array(true,false,false),'is_multi' => array(true,false,false),'hook_extra' => array(array(deregisterTaint(array('plugin',false)) => addTaint($plugin)),false,false)),false));
arrayAssign($results[0],deAspis(registerTaint($plugin)),addTaint($this->result));
if ( (false === $result[0]))
 break ;
}$this->maintenance_mode(array(false,false));
$this->skin[0]->footer();
remove_filter(array('upgrader_clear_destination',false),array(array(array($this,false),array('delete_old_plugin',false)),false));
delete_transient(array('update_plugins',false));
return $results;
} }
function plugin_info (  ) {
{if ( (!(is_array($this->result[0]))))
 return array(false,false);
if ( ((empty($this->result[0][('destination_name')]) || Aspis_empty( $this ->result [0][('destination_name')] ))))
 return array(false,false);
$plugin = get_plugins(concat1('/',$this->result[0][('destination_name')]));
if ( ((empty($plugin) || Aspis_empty( $plugin))))
 return array(false,false);
$pluginfiles = attAspisRC(array_keys(deAspisRC($plugin)));
return concat(concat2($this->result[0][('destination_name')],'/'),attachAspis($pluginfiles,(0)));
} }
function deactivate_plugin_before_upgrade ( $return,$plugin ) {
{if ( deAspis(is_wp_error($return)))
 return $return;
$plugin = ((isset($plugin[0][('plugin')]) && Aspis_isset( $plugin [0][('plugin')]))) ? $plugin[0]['plugin'] : array('',false);
if ( ((empty($plugin) || Aspis_empty( $plugin))))
 return array(new WP_Error(array('bad_request',false),$this->strings[0][('bad_request')]),false);
if ( deAspis(is_plugin_active($plugin)))
 {$this->skin[0]->feedback(array('deactivate_plugin',false));
deactivate_plugins($plugin,array(true,false));
}} }
function delete_old_plugin ( $removed,$local_destination,$remote_destination,$plugin ) {
{global $wp_filesystem;
if ( deAspis(is_wp_error($removed)))
 return $removed;
$plugin = ((isset($plugin[0][('plugin')]) && Aspis_isset( $plugin [0][('plugin')]))) ? $plugin[0]['plugin'] : array('',false);
if ( ((empty($plugin) || Aspis_empty( $plugin))))
 return array(new WP_Error(array('bad_request',false),$this->strings[0][('bad_request')]),false);
$plugins_dir = $wp_filesystem[0]->wp_plugins_dir();
$this_plugin_dir = trailingslashit(Aspis_dirname(concat($plugins_dir,$plugin)));
if ( (denot_boolean($wp_filesystem[0]->exists($this_plugin_dir))))
 return $removed;
if ( (strpos($plugin[0],'/') && ($this_plugin_dir[0] != $plugins_dir[0])))
 $deleted = $wp_filesystem[0]->delete($this_plugin_dir,array(true,false));
else 
{$deleted = $wp_filesystem[0]->delete(concat($plugins_dir,$plugin));
}if ( (denot_boolean($deleted)))
 return array(new WP_Error(array('remove_old_failed',false),$this->strings[0][('remove_old_failed')]),false);
return $removed;
} }
}class Theme_Upgrader extends WP_Upgrader{var $result;
function upgrade_strings (  ) {
{arrayAssign($this->strings[0],deAspis(registerTaint(array('up_to_date',false))),addTaint(__(array('The theme is at the latest version.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('no_package',false))),addTaint(__(array('Upgrade package not available.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('downloading_package',false))),addTaint(__(array('Downloading update from <span class="code">%s</span>.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('unpack_package',false))),addTaint(__(array('Unpacking the update.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('remove_old',false))),addTaint(__(array('Removing the old version of the theme.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('remove_old_failed',false))),addTaint(__(array('Could not remove the old theme.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('process_failed',false))),addTaint(__(array('Theme upgrade Failed.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('process_success',false))),addTaint(__(array('Theme upgraded successfully.',false))));
} }
function install_strings (  ) {
{arrayAssign($this->strings[0],deAspis(registerTaint(array('no_package',false))),addTaint(__(array('Install package not available.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('downloading_package',false))),addTaint(__(array('Downloading install package from <span class="code">%s</span>.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('unpack_package',false))),addTaint(__(array('Unpacking the package.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('installing_package',false))),addTaint(__(array('Installing the theme.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('process_failed',false))),addTaint(__(array('Theme Install Failed.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('process_success',false))),addTaint(__(array('Theme Installed successfully.',false))));
} }
function install ( $package ) {
{$this->init();
$this->install_strings();
$options = array(array(deregisterTaint(array('package',false)) => addTaint($package),deregisterTaint(array('destination',false)) => addTaint(concat12(WP_CONTENT_DIR,'/themes')),'clear_destination' => array(false,false,false),'clear_working' => array(true,false,false)),false);
$this->run($options);
if ( ((denot_boolean($this->result)) || deAspis(is_wp_error($this->result))))
 return $this->result;
delete_transient(array('update_themes',false));
if ( ((empty($result[0][('destination_name')]) || Aspis_empty( $result [0][('destination_name')]))))
 return array(false,false);
else 
{return $result[0]['destination_name'];
}} }
function upgrade ( $theme ) {
{$this->init();
$this->upgrade_strings();
$current = get_transient(array('update_themes',false));
if ( (!((isset($current[0]->response[0][$theme[0]]) && Aspis_isset( $current[0] ->response [0][$theme[0]] )))))
 {$this->skin[0]->set_result(array(false,false));
$this->skin[0]->error(array('up_to_date',false));
$this->skin[0]->after();
return array(false,false);
}$r = $current[0]->response[0][$theme[0]];
add_filter(array('upgrader_pre_install',false),array(array(array($this,false),array('current_before',false)),false),array(10,false),array(2,false));
add_filter(array('upgrader_post_install',false),array(array(array($this,false),array('current_after',false)),false),array(10,false),array(2,false));
add_filter(array('upgrader_clear_destination',false),array(array(array($this,false),array('delete_old_theme',false)),false),array(10,false),array(4,false));
$options = array(array(deregisterTaint(array('package',false)) => addTaint($r[0]['package']),deregisterTaint(array('destination',false)) => addTaint(concat12(WP_CONTENT_DIR,'/themes')),'clear_destination' => array(true,false,false),'clear_working' => array(true,false,false),'hook_extra' => array(array(deregisterTaint(array('theme',false)) => addTaint($theme)),false,false)),false);
$this->run($options);
if ( ((denot_boolean($this->result)) || deAspis(is_wp_error($this->result))))
 return $this->result;
delete_transient(array('update_themes',false));
return array(true,false);
} }
function current_before ( $return,$theme ) {
{if ( deAspis(is_wp_error($return)))
 return $return;
$theme = ((isset($theme[0][('theme')]) && Aspis_isset( $theme [0][('theme')]))) ? $theme[0]['theme'] : array('',false);
if ( ($theme[0] != deAspis(get_stylesheet())))
 return $return;
$this->maintenance_mode(array(true,false));
return $return;
} }
function current_after ( $return,$theme ) {
{if ( deAspis(is_wp_error($return)))
 return $return;
$theme = ((isset($theme[0][('theme')]) && Aspis_isset( $theme [0][('theme')]))) ? $theme[0]['theme'] : array('',false);
if ( ($theme[0] != deAspis(get_stylesheet())))
 return $return;
if ( (($theme[0] == deAspis(get_stylesheet())) && ($theme[0] != $this->result[0][('destination_name')][0])))
 {$theme_info = $this->theme_info();
$stylesheet = $this->result[0][('destination_name')];
$template = (!((empty($theme_info[0][('Template')]) || Aspis_empty( $theme_info [0][('Template')])))) ? $theme_info[0]['Template'] : $stylesheet;
switch_theme($template,$stylesheet,array(true,false));
}$this->maintenance_mode(array(false,false));
return $return;
} }
function delete_old_theme ( $removed,$local_destination,$remote_destination,$theme ) {
{global $wp_filesystem;
$theme = ((isset($theme[0][('theme')]) && Aspis_isset( $theme [0][('theme')]))) ? $theme[0]['theme'] : array('',false);
if ( (deAspis(is_wp_error($removed)) || ((empty($theme) || Aspis_empty( $theme)))))
 return $removed;
$themes_dir = $wp_filesystem[0]->wp_themes_dir();
if ( deAspis($wp_filesystem[0]->exists(concat(trailingslashit($themes_dir),$theme))))
 if ( (denot_boolean($wp_filesystem[0]->delete(concat(trailingslashit($themes_dir),$theme),array(true,false)))))
 return array(false,false);
return array(true,false);
} }
function theme_info (  ) {
{if ( ((empty($this->result[0][('destination_name')]) || Aspis_empty( $this ->result [0][('destination_name')] ))))
 return array(false,false);
return get_theme_data(concat2(concat(concat12(WP_CONTENT_DIR,'/themes/'),$this->result[0][('destination_name')]),'/style.css'));
} }
}class Core_Upgrader extends WP_Upgrader{function upgrade_strings (  ) {
{arrayAssign($this->strings[0],deAspis(registerTaint(array('up_to_date',false))),addTaint(__(array('WordPress is at the latest version.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('no_package',false))),addTaint(__(array('Upgrade package not available.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('downloading_package',false))),addTaint(__(array('Downloading update from <span class="code">%s</span>.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('unpack_package',false))),addTaint(__(array('Unpacking the update.',false))));
arrayAssign($this->strings[0],deAspis(registerTaint(array('copy_failed',false))),addTaint(__(array('Could not copy files.',false))));
} }
function upgrade ( $current ) {
{global $wp_filesystem;
$this->init();
$this->upgrade_strings();
if ( (!((empty($feedback) || Aspis_empty( $feedback)))))
 add_filter(array('update_feedback',false),$feedback);
if ( ((!((isset($current[0]->response) && Aspis_isset( $current[0] ->response )))) || ($current[0]->response[0] == ('latest'))))
 return array(new WP_Error(array('up_to_date',false),$this->strings[0][('up_to_date')]),false);
$res = $this->fs_connect(array(array(array(ABSPATH,false),array(WP_CONTENT_DIR,false)),false));
if ( deAspis(is_wp_error($res)))
 return $res;
$wp_dir = trailingslashit($wp_filesystem[0]->abspath());
$download = $this->download_package($current[0]->package);
if ( deAspis(is_wp_error($download)))
 return $download;
$working_dir = $this->unpack_package($download);
if ( deAspis(is_wp_error($working_dir)))
 return $working_dir;
if ( (denot_boolean($wp_filesystem[0]->copy(concat2($working_dir,'/wordpress/wp-admin/includes/update-core.php'),concat2($wp_dir,'wp-admin/includes/update-core.php'),array(true,false)))))
 {$wp_filesystem[0]->delete($working_dir,array(true,false));
return array(new WP_Error(array('copy_failed',false),$this->strings[0][('copy_failed')]),false);
}$wp_filesystem[0]->chmod(concat2($wp_dir,'wp-admin/includes/update-core.php'),array(FS_CHMOD_FILE,false));
require (deconcat12(ABSPATH,'wp-admin/includes/update-core.php'));
return update_core($working_dir,$wp_dir);
} }
}class WP_Upgrader_Skin{var $upgrader;
var $done_header = array(false,false);
function WP_Upgrader_Skin ( $args = array(array(),false) ) {
{return $this->__construct($args);
} }
function __construct ( $args = array(array(),false) ) {
{$defaults = array(array('url' => array('',false,false),'nonce' => array('',false,false),'title' => array('',false,false),'context' => array(false,false,false)),false);
$this->options = wp_parse_args($args,$defaults);
} }
function set_upgrader ( &$upgrader ) {
{if ( is_object($upgrader[0]))
 $this->upgrader = &$upgrader;
} }
function set_result ( $result ) {
{$this->result = $result;
} }
function request_filesystem_credentials ( $error = array(false,false) ) {
{$url = $this->options[0][('url')];
$context = $this->options[0][('context')];
if ( (!((empty($this->options[0][('nonce')]) || Aspis_empty( $this ->options [0][('nonce')] )))))
 $url = wp_nonce_url($url,$this->options[0][('nonce')]);
return request_filesystem_credentials($url,array('',false),$error,$context);
} }
function header (  ) {
{if ( $this->done_header[0])
 return ;
$this->done_header = array(true,false);
echo AspisCheckPrint(array('<div class="wrap">',false));
echo AspisCheckPrint(screen_icon());
echo AspisCheckPrint(concat2(concat1('<h2>',$this->options[0][('title')]),'</h2>'));
} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function error ( $errors ) {
{if ( (denot_boolean($this->done_header)))
 $this->header();
if ( is_string(deAspisRC($errors)))
 {$this->feedback($errors);
}elseif ( (deAspis(is_wp_error($errors)) && deAspis($errors[0]->get_error_code())))
 {foreach ( deAspis($errors[0]->get_error_messages()) as $message  )
{if ( deAspis($errors[0]->get_error_data()))
 $this->feedback(concat(concat2($message,' '),$errors[0]->get_error_data()));
else 
{$this->feedback($message);
}}}} }
function feedback ( $string ) {
{if ( ((isset($this->upgrader[0]->strings[0][$string[0]]) && Aspis_isset( $this ->upgrader[0] ->strings [0][$string[0]] ))))
 $string = $this->upgrader[0]->strings[0][$string[0]];
if ( (strpos($string[0],'%') !== false))
 {$args = array(func_get_args(),false);
$args = Aspis_array_splice($args,array(1,false));
if ( (!((empty($args) || Aspis_empty( $args)))))
 $string = Aspis_vsprintf($string,$args);
}if ( ((empty($string) || Aspis_empty( $string))))
 return ;
show_message($string);
} }
function before (  ) {
{} }
function after (  ) {
{} }
}class Plugin_Upgrader_Skin extends WP_Upgrader_Skin{var $plugin = array('',false);
var $plugin_active = array(false,false);
function Plugin_Upgrader_Skin ( $args = array(array(),false) ) {
{return $this->__construct($args);
} }
function __construct ( $args = array(array(),false) ) {
{$defaults = array(array('url' => array('',false,false),'plugin' => array('',false,false),'nonce' => array('',false,false),deregisterTaint(array('title',false)) => addTaint(__(array('Upgrade Plugin',false)))),false);
$args = wp_parse_args($args,$defaults);
$this->plugin = $args[0]['plugin'];
$this->plugin_active = is_plugin_active($this->plugin);
parent::__construct($args);
} }
function after (  ) {
{if ( $this->upgrader[0]->bulk[0])
 return ;
$this->plugin = $this->upgrader[0]->plugin_info();
if ( (((!((empty($this->plugin) || Aspis_empty( $this ->plugin )))) && (denot_boolean(is_wp_error($this->result)))) && $this->plugin_active[0]))
 {show_message(__(array('Attempting reactivation of the plugin',false)));
echo AspisCheckPrint(concat2(concat1('<iframe style="border:0;overflow:hidden" width="100%" height="170px" src="',wp_nonce_url(concat1('update.php?action=activate-plugin&plugin=',$this->plugin),concat1('activate-plugin_',$this->plugin))),'"></iframe>'));
}$update_actions = array(array(deregisterTaint(array('activate_plugin',false)) => addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',wp_nonce_url(concat1('plugins.php?action=activate&amp;plugin=',$this->plugin),concat1('activate-plugin_',$this->plugin))),'" title="'),esc_attr__(array('Activate this plugin',false))),'" target="_parent">'),__(array('Activate Plugin',false))),'</a>')),deregisterTaint(array('plugins_page',false)) => addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',admin_url(array('plugins.php',false))),'" title="'),esc_attr__(array('Goto plugins page',false))),'" target="_parent">'),__(array('Return to Plugins page',false))),'</a>'))),false);
if ( $this->plugin_active[0])
 unset($update_actions[0][('activate_plugin')]);
if ( ((denot_boolean($this->result)) || deAspis(is_wp_error($this->result))))
 unset($update_actions[0][('activate_plugin')]);
$update_actions = apply_filters(array('update_plugin_complete_actions',false),$update_actions,$this->plugin);
if ( (!((empty($update_actions) || Aspis_empty( $update_actions)))))
 $this->feedback(concat(concat2(concat1('<strong>',__(array('Actions:',false))),'</strong> '),Aspis_implode(array(' | ',false),array_cast($update_actions))));
} }
function before (  ) {
{if ( $this->upgrader[0]->show_before[0])
 {echo AspisCheckPrint($this->upgrader[0]->show_before);
$this->upgrader[0]->show_before = array('',false);
}} }
}class Plugin_Installer_Skin extends WP_Upgrader_Skin{var $api;
var $type;
function Plugin_Installer_Skin ( $args = array(array(),false) ) {
{return $this->__construct($args);
} }
function __construct ( $args = array(array(),false) ) {
{$defaults = array(array('type' => array('web',false,false),'url' => array('',false,false),'plugin' => array('',false,false),'nonce' => array('',false,false),'title' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
$this->type = $args[0]['type'];
$this->api = ((isset($args[0][('api')]) && Aspis_isset( $args [0][('api')]))) ? $args[0]['api'] : array(array(),false);
parent::__construct($args);
} }
function before (  ) {
{if ( (!((empty($this->api) || Aspis_empty( $this ->api )))))
 $this->upgrader[0]->strings[0][('process_success')] = Aspis_sprintf(__(array('Successfully installed the plugin <strong>%s %s</strong>.',false)),$this->api[0]->name,$this->api[0]->version);
} }
function after (  ) {
{$plugin_file = $this->upgrader[0]->plugin_info();
$install_actions = array(array(deregisterTaint(array('activate_plugin',false)) => addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',wp_nonce_url(concat1('plugins.php?action=activate&amp;plugin=',$plugin_file),concat1('activate-plugin_',$plugin_file))),'" title="'),esc_attr__(array('Activate this plugin',false))),'" target="_parent">'),__(array('Activate Plugin',false))),'</a>')),),false);
if ( ($this->type[0] == ('web')))
 arrayAssign($install_actions[0],deAspis(registerTaint(array('plugins_page',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',admin_url(array('plugin-install.php',false))),'" title="'),esc_attr__(array('Return to Plugin Installer',false))),'" target="_parent">'),__(array('Return to Plugin Installer',false))),'</a>')));
else 
{arrayAssign($install_actions[0],deAspis(registerTaint(array('plugins_page',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',admin_url(array('plugins.php',false))),'" title="'),esc_attr__(array('Return to Plugins page',false))),'" target="_parent">'),__(array('Return to Plugins page',false))),'</a>')));
}if ( ((denot_boolean($this->result)) || deAspis(is_wp_error($this->result))))
 unset($install_actions[0][('activate_plugin')]);
$install_actions = apply_filters(array('install_plugin_complete_actions',false),$install_actions,$this->api,$plugin_file);
if ( (!((empty($install_actions) || Aspis_empty( $install_actions)))))
 $this->feedback(concat(concat2(concat1('<strong>',__(array('Actions:',false))),'</strong> '),Aspis_implode(array(' | ',false),array_cast($install_actions))));
} }
}class Theme_Installer_Skin extends WP_Upgrader_Skin{var $api;
var $type;
function Theme_Installer_Skin ( $args = array(array(),false) ) {
{return $this->__construct($args);
} }
function __construct ( $args = array(array(),false) ) {
{$defaults = array(array('type' => array('web',false,false),'url' => array('',false,false),'theme' => array('',false,false),'nonce' => array('',false,false),'title' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
$this->type = $args[0]['type'];
$this->api = ((isset($args[0][('api')]) && Aspis_isset( $args [0][('api')]))) ? $args[0]['api'] : array(array(),false);
parent::__construct($args);
} }
function before (  ) {
{if ( (!((empty($this->api) || Aspis_empty( $this ->api )))))
 {$this->upgrader[0]->strings[0][('process_success')] = Aspis_sprintf(__(array('Successfully installed the theme <strong>%1$s %2$s</strong>.',false)),$this->api[0]->name,$this->api[0]->version);
}} }
function after (  ) {
{if ( ((empty($this->upgrader[0]->result[0][('destination_name')]) || Aspis_empty( $this ->upgrader[0] ->result [0][('destination_name')] ))))
 return ;
$theme_info = $this->upgrader[0]->theme_info();
if ( ((empty($theme_info) || Aspis_empty( $theme_info))))
 return ;
$name = $theme_info[0]['Name'];
$stylesheet = $this->upgrader[0]->result[0][('destination_name')];
$template = (!((empty($theme_info[0][('Template')]) || Aspis_empty( $theme_info [0][('Template')])))) ? $theme_info[0]['Template'] : $stylesheet;
$preview_link = Aspis_htmlspecialchars(add_query_arg(array(array('preview' => array(1,false,false),deregisterTaint(array('template',false)) => addTaint($template),deregisterTaint(array('stylesheet',false)) => addTaint($stylesheet),'TB_iframe' => array('true',false,false)),false),trailingslashit(esc_url(get_option(array('home',false))))));
$activate_link = wp_nonce_url(concat(concat2(concat1("themes.php?action=activate&amp;template=",Aspis_urlencode($template)),"&amp;stylesheet="),Aspis_urlencode($stylesheet)),concat1('switch-theme_',$template));
$install_actions = array(array(deregisterTaint(array('preview',false)) => addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$preview_link),'" class="thickbox thickbox-preview" title="'),esc_attr(Aspis_sprintf(__(array('Preview &#8220;%s&#8221;',false)),$name))),'">'),__(array('Preview',false))),'</a>')),deregisterTaint(array('activate',false)) => addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$activate_link),'" class="activatelink" title="'),esc_attr(Aspis_sprintf(__(array('Activate &#8220;%s&#8221;',false)),$name))),'">'),__(array('Activate',false))),'</a>'))),false);
if ( ($this->type[0] == ('web')))
 arrayAssign($install_actions[0],deAspis(registerTaint(array('themes_page',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',admin_url(array('theme-install.php',false))),'" title="'),esc_attr__(array('Return to Theme Installer',false))),'" target="_parent">'),__(array('Return to Theme Installer',false))),'</a>')));
else 
{arrayAssign($install_actions[0],deAspis(registerTaint(array('themes_page',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',admin_url(array('themes.php',false))),'" title="'),esc_attr__(array('Themes page',false))),'" target="_parent">'),__(array('Return to Themes page',false))),'</a>')));
}if ( ((denot_boolean($this->result)) || deAspis(is_wp_error($this->result))))
 unset($install_actions[0][('activate')],$install_actions[0][('preview')]);
$install_actions = apply_filters(array('install_theme_complete_actions',false),$install_actions,$this->api,$stylesheet,$theme_info);
if ( (!((empty($install_actions) || Aspis_empty( $install_actions)))))
 $this->feedback(concat(concat2(concat1('<strong>',__(array('Actions:',false))),'</strong> '),Aspis_implode(array(' | ',false),array_cast($install_actions))));
} }
}class Theme_Upgrader_Skin extends WP_Upgrader_Skin{var $theme = array('',false);
function Theme_Upgrader_Skin ( $args = array(array(),false) ) {
{return $this->__construct($args);
} }
function __construct ( $args = array(array(),false) ) {
{$defaults = array(array('url' => array('',false,false),'theme' => array('',false,false),'nonce' => array('',false,false),deregisterTaint(array('title',false)) => addTaint(__(array('Upgrade Theme',false)))),false);
$args = wp_parse_args($args,$defaults);
$this->theme = $args[0]['theme'];
parent::__construct($args);
} }
function after (  ) {
{if ( (((!((empty($this->upgrader[0]->result[0][('destination_name')]) || Aspis_empty( $this ->upgrader[0] ->result [0][('destination_name')] )))) && deAspis(($theme_info = $this->upgrader[0]->theme_info()))) && (!((empty($theme_info) || Aspis_empty( $theme_info))))))
 {$name = $theme_info[0]['Name'];
$stylesheet = $this->upgrader[0]->result[0][('destination_name')];
$template = (!((empty($theme_info[0][('Template')]) || Aspis_empty( $theme_info [0][('Template')])))) ? $theme_info[0]['Template'] : $stylesheet;
$preview_link = Aspis_htmlspecialchars(add_query_arg(array(array('preview' => array(1,false,false),deregisterTaint(array('template',false)) => addTaint($template),deregisterTaint(array('stylesheet',false)) => addTaint($stylesheet),'TB_iframe' => array('true',false,false)),false),trailingslashit(esc_url(get_option(array('home',false))))));
$activate_link = wp_nonce_url(concat(concat2(concat1("themes.php?action=activate&amp;template=",Aspis_urlencode($template)),"&amp;stylesheet="),Aspis_urlencode($stylesheet)),concat1('switch-theme_',$template));
$update_actions = array(array(deregisterTaint(array('preview',false)) => addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$preview_link),'" class="thickbox thickbox-preview" title="'),esc_attr(Aspis_sprintf(__(array('Preview &#8220;%s&#8221;',false)),$name))),'">'),__(array('Preview',false))),'</a>')),deregisterTaint(array('activate',false)) => addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$activate_link),'" class="activatelink" title="'),esc_attr(Aspis_sprintf(__(array('Activate &#8220;%s&#8221;',false)),$name))),'">'),__(array('Activate',false))),'</a>')),),false);
if ( (((denot_boolean($this->result)) || deAspis(is_wp_error($this->result))) || ($stylesheet[0] == deAspis(get_stylesheet()))))
 unset($update_actions[0][('preview')],$update_actions[0][('activate')]);
}arrayAssign($update_actions[0],deAspis(registerTaint(array('themes_page',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',admin_url(array('themes.php',false))),'" title="'),esc_attr__(array('Return to Themes page',false))),'" target="_parent">'),__(array('Return to Themes page',false))),'</a>')));
$update_actions = apply_filters(array('update_theme_complete_actions',false),$update_actions,$this->theme);
if ( (!((empty($update_actions) || Aspis_empty( $update_actions)))))
 $this->feedback(concat(concat2(concat1('<strong>',__(array('Actions:',false))),'</strong> '),Aspis_implode(array(' | ',false),array_cast($update_actions))));
} }
}class File_Upload_Upgrader{var $package;
var $filename;
function File_Upload_Upgrader ( $form,$urlholder ) {
{return $this->__construct($form,$urlholder);
} }
function __construct ( $form,$urlholder ) {
{if ( (!(deAspis(($uploads = wp_upload_dir())) && (false === deAspis($uploads[0]['error'])))))
 wp_die($uploads[0]['error']);
if ( (((empty($_FILES[0][$form[0]][0][('name')]) || Aspis_empty( $_FILES [0][$form[0]] [0][('name')]))) && ((empty($_GET[0][$urlholder[0]]) || Aspis_empty( $_GET [0][$urlholder[0]])))))
 wp_die(__(array('Please select a file',false)));
if ( (!((empty($_FILES) || Aspis_empty( $_FILES)))))
 $this->filename = $_FILES[0][$form[0]][0]['name'];
else 
{if ( ((isset($_GET[0][$urlholder[0]]) && Aspis_isset( $_GET [0][$urlholder[0]]))))
 $this->filename = attachAspis($_GET,$urlholder[0]);
}if ( (!((empty($_FILES) || Aspis_empty( $_FILES)))))
 {$this->filename = wp_unique_filename($uploads[0]['basedir'],$this->filename);
$this->package = concat(concat2($uploads[0]['basedir'],'/'),$this->filename);
if ( (false === deAspis(@attAspis(move_uploaded_file(deAspis($_FILES[0][$form[0]][0]['tmp_name']),$this->package[0])))))
 wp_die(Aspis_sprintf(__(array('The uploaded file could not be moved to %s.',false)),$uploads[0]['path']));
}else 
{{$this->package = concat(concat2($uploads[0]['basedir'],'/'),$this->filename);
}}} }
}