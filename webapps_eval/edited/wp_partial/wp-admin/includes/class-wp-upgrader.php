<?php require_once('AspisMain.php'); ?><?php
class WP_Upgrader{var $strings = array();
var $skin = null;
var $result = array();
function WP_Upgrader ( $skin = null ) {
{{$AspisRetTemp = $this->__construct($skin);
return $AspisRetTemp;
}} }
function __construct ( $skin = null ) {
{if ( null == $skin)
 $this->skin = new WP_Upgrader_Skin();
else 
{$this->skin = $skin;
}} }
function init (  ) {
{$this->skin->set_upgrader($this);
$this->generic_strings();
} }
function generic_strings (  ) {
{$this->strings['bad_request'] = __('Invalid Data provided.');
$this->strings['fs_unavailable'] = __('Could not access filesystem.');
$this->strings['fs_error'] = __('Filesystem error');
$this->strings['fs_no_root_dir'] = __('Unable to locate WordPress Root directory.');
$this->strings['fs_no_content_dir'] = __('Unable to locate WordPress Content directory (wp-content).');
$this->strings['fs_no_plugins_dir'] = __('Unable to locate WordPress Plugin directory.');
$this->strings['fs_no_themes_dir'] = __('Unable to locate WordPress Theme directory.');
$this->strings['fs_no_folder'] = __('Unable to locate needed folder (%s).');
$this->strings['download_failed'] = __('Download failed.');
$this->strings['installing_package'] = __('Installing the latest version.');
$this->strings['folder_exists'] = __('Destination folder already exists.');
$this->strings['mkdir_failed'] = __('Could not create directory.');
$this->strings['bad_package'] = __('Incompatible Archive');
$this->strings['maintenance_start'] = __('Enabling Maintenance mode.');
$this->strings['maintenance_end'] = __('Disabling Maintenance mode.');
} }
function fs_connect ( $directories = array() ) {
{{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}if ( false === ($credentials = $this->skin->request_filesystem_credentials()))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( !WP_Filesystem($credentials))
 {$error = true;
if ( is_object($wp_filesystem) && $wp_filesystem->errors->get_error_code())
 $error = $wp_filesystem->errors;
$this->skin->request_filesystem_credentials($error);
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}if ( !is_object($wp_filesystem))
 {$AspisRetTemp = new WP_Error('fs_unavailable',$this->strings['fs_unavailable']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->get_error_code())
 {$AspisRetTemp = new WP_Error('fs_error',$this->strings['fs_error'],$wp_filesystem->errors);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}foreach ( (array)$directories as $dir  )
{switch ( $dir ) {
case ABSPATH:if ( !$wp_filesystem->abspath())
 {$AspisRetTemp = new WP_Error('fs_no_root_dir',$this->strings['fs_no_root_dir']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}break ;
case WP_CONTENT_DIR:if ( !$wp_filesystem->wp_content_dir())
 {$AspisRetTemp = new WP_Error('fs_no_content_dir',$this->strings['fs_no_content_dir']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}break ;
case WP_PLUGIN_DIR:if ( !$wp_filesystem->wp_plugins_dir())
 {$AspisRetTemp = new WP_Error('fs_no_plugins_dir',$this->strings['fs_no_plugins_dir']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}break ;
case WP_CONTENT_DIR . '/themes':if ( !$wp_filesystem->find_folder(WP_CONTENT_DIR . '/themes'))
 {$AspisRetTemp = new WP_Error('fs_no_themes_dir',$this->strings['fs_no_themes_dir']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}break ;
default :if ( !$wp_filesystem->find_folder($dir))
 {$AspisRetTemp = new WP_Error('fs_no_folder',sprintf($this->strings['fs_no_folder'],$dir));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}break ;
 }
}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
function download_package ( $package ) {
{if ( !preg_match('!^(http|https|ftp)://!i',$package) && file_exists($package))
 {$AspisRetTemp = $package;
return $AspisRetTemp;
}if ( empty($package))
 {$AspisRetTemp = new WP_Error('no_package',$this->strings['no_package']);
return $AspisRetTemp;
}$this->skin->feedback('downloading_package',$package);
$download_file = download_url($package);
if ( is_wp_error($download_file))
 {$AspisRetTemp = new WP_Error('download_failed',$this->strings['download_failed'],$download_file->get_error_message());
return $AspisRetTemp;
}{$AspisRetTemp = $download_file;
return $AspisRetTemp;
}} }
function unpack_package ( $package,$delete_package = true ) {
{{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}$this->skin->feedback('unpack_package');
$upgrade_folder = $wp_filesystem->wp_content_dir() . 'upgrade/';
$upgrade_files = $wp_filesystem->dirlist($upgrade_folder);
if ( !empty($upgrade_files))
 {foreach ( $upgrade_files as $file  )
$wp_filesystem->delete($upgrade_folder . $file['name'],true);
}$working_dir = $upgrade_folder . basename($package,'.zip');
if ( $wp_filesystem->is_dir($working_dir))
 $wp_filesystem->delete($working_dir,true);
$result = unzip_file($package,$working_dir);
if ( $delete_package)
 unlink($package);
if ( is_wp_error($result))
 {$wp_filesystem->delete($working_dir,true);
{$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = $working_dir;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
function install_package ( $args = array() ) {
{{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}$defaults = array('source' => '','destination' => '','clear_destination' => false,'clear_working' => false,'hook_extra' => array());
$args = wp_parse_args($args,$defaults);
extract(($args));
@set_time_limit(300);
if ( empty($source) || empty($destination))
 {$AspisRetTemp = new WP_Error('bad_request',$this->strings['bad_request']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$this->skin->feedback('installing_package');
$res = apply_filters('upgrader_pre_install',true,$hook_extra);
if ( is_wp_error($res))
 {$AspisRetTemp = $res;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$remote_source = $source;
$local_destination = $destination;
$source_files = array_keys($wp_filesystem->dirlist($remote_source));
$remote_destination = $wp_filesystem->find_folder($local_destination);
if ( 1 == count($source_files) && $wp_filesystem->is_dir(trailingslashit($source) . $source_files[0] . '/'))
 $source = trailingslashit($source) . trailingslashit($source_files[0]);
elseif ( count($source_files) == 0)
 {$AspisRetTemp = new WP_Error('bad_package',$this->strings['bad_package']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$source = apply_filters('upgrader_source_selection',$source,$remote_source,$this);
if ( is_wp_error($source))
 {$AspisRetTemp = $source;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( $source !== $remote_source)
 $source_files = array_keys($wp_filesystem->dirlist($source));
if ( in_array($destination,array(ABSPATH,WP_CONTENT_DIR,WP_PLUGIN_DIR,WP_CONTENT_DIR . '/themes')))
 {$remote_destination = trailingslashit($remote_destination) . trailingslashit(basename($source));
$destination = trailingslashit($destination) . trailingslashit(basename($source));
}if ( $wp_filesystem->exists($remote_destination))
 {if ( $clear_destination)
 {$this->skin->feedback('remove_old');
$removed = $wp_filesystem->delete($remote_destination,true);
$removed = apply_filters('upgrader_clear_destination',$removed,$local_destination,$remote_destination,$hook_extra);
if ( is_wp_error($removed))
 {$AspisRetTemp = $removed;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}else 
{if ( !$removed)
 {$AspisRetTemp = new WP_Error('remove_old_failed',$this->strings['remove_old_failed']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}}else 
{{$_files = $wp_filesystem->dirlist($remote_destination);
if ( !empty($_files))
 {$wp_filesystem->delete($remote_source,true);
{$AspisRetTemp = new WP_Error('folder_exists',$this->strings['folder_exists'],$remote_destination);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}}}}if ( !$wp_filesystem->exists($remote_destination))
 if ( !$wp_filesystem->mkdir($remote_destination,FS_CHMOD_DIR))
 {$AspisRetTemp = new WP_Error('mkdir_failed',$this->strings['mkdir_failed'],$remote_destination);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$result = copy_dir($source,$remote_destination);
if ( is_wp_error($result))
 {if ( $clear_working)
 $wp_filesystem->delete($remote_source,true);
{$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}if ( $clear_working)
 $wp_filesystem->delete($remote_source,true);
$destination_name = basename(str_replace($local_destination,'',$destination));
if ( '.' == $destination_name)
 $destination_name = '';
$this->result = compact('local_source','source','source_name','source_files','destination','destination_name','local_destination','remote_destination','clear_destination','delete_source_dir');
$res = apply_filters('upgrader_post_install',true,$hook_extra,$this->result);
if ( is_wp_error($res))
 {$this->result = $res;
{$AspisRetTemp = $res;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = $this->result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
function run ( $options ) {
{$defaults = array('package' => '','destination' => '','clear_destination' => false,'clear_working' => true,'is_multi' => false,'hook_extra' => array());
$options = wp_parse_args($options,$defaults);
extract(($options));
$res = $this->fs_connect(array(WP_CONTENT_DIR,$destination));
if ( !$res)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( is_wp_error($res))
 {$this->skin->error($res);
{$AspisRetTemp = $res;
return $AspisRetTemp;
}}if ( !$is_multi)
 $this->skin->header();
$this->skin->before();
$download = $this->download_package($package);
if ( is_wp_error($download))
 {$this->skin->error($download);
{$AspisRetTemp = $download;
return $AspisRetTemp;
}}$working_dir = $this->unpack_package($download);
if ( is_wp_error($working_dir))
 {$this->skin->error($working_dir);
{$AspisRetTemp = $working_dir;
return $AspisRetTemp;
}}$result = $this->install_package(array('source' => $working_dir,'destination' => $destination,'clear_destination' => $clear_destination,'clear_working' => $clear_working,'hook_extra' => $hook_extra));
$this->skin->set_result($result);
if ( is_wp_error($result))
 {$this->skin->error($result);
$this->skin->feedback('process_failed');
}else 
{{$this->skin->feedback('process_success');
}}$this->skin->after();
if ( !$is_multi)
 $this->skin->footer();
{$AspisRetTemp = $result;
return $AspisRetTemp;
}} }
function maintenance_mode ( $enable = false ) {
{{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}$file = $wp_filesystem->abspath() . '.maintenance';
if ( $enable)
 {$this->skin->feedback('maintenance_start');
$maintenance_string = '<?php $upgrading = ' . time() . '; ?>';
$wp_filesystem->delete($file);
$wp_filesystem->put_contents($file,$maintenance_string,FS_CHMOD_FILE);
}else 
{if ( !$enable && $wp_filesystem->exists($file))
 {$this->skin->feedback('maintenance_end');
$wp_filesystem->delete($file);
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
}class Plugin_Upgrader extends WP_Upgrader{var $result;
var $bulk = false;
var $show_before = '';
function upgrade_strings (  ) {
{$this->strings['up_to_date'] = __('The plugin is at the latest version.');
$this->strings['no_package'] = __('Upgrade package not available.');
$this->strings['downloading_package'] = __('Downloading update from <span class="code">%s</span>.');
$this->strings['unpack_package'] = __('Unpacking the update.');
$this->strings['deactivate_plugin'] = __('Deactivating the plugin.');
$this->strings['remove_old'] = __('Removing the old version of the plugin.');
$this->strings['remove_old_failed'] = __('Could not remove the old plugin.');
$this->strings['process_failed'] = __('Plugin upgrade Failed.');
$this->strings['process_success'] = __('Plugin upgraded successfully.');
} }
function install_strings (  ) {
{$this->strings['no_package'] = __('Install package not available.');
$this->strings['downloading_package'] = __('Downloading install package from <span class="code">%s</span>.');
$this->strings['unpack_package'] = __('Unpacking the package.');
$this->strings['installing_package'] = __('Installing the plugin.');
$this->strings['process_failed'] = __('Plugin Install Failed.');
$this->strings['process_success'] = __('Plugin Installed successfully.');
} }
function install ( $package ) {
{$this->init();
$this->install_strings();
$this->run(array('package' => $package,'destination' => WP_PLUGIN_DIR,'clear_destination' => false,'clear_working' => true,'hook_extra' => array()));
delete_transient('update_plugins');
} }
function upgrade ( $plugin ) {
{$this->init();
$this->upgrade_strings();
$current = get_transient('update_plugins');
if ( !isset($current->response[$plugin]))
 {$this->skin->set_result(false);
$this->skin->error('up_to_date');
$this->skin->after();
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$r = $current->response[$plugin];
add_filter('upgrader_pre_install',array($this,'deactivate_plugin_before_upgrade'),10,2);
add_filter('upgrader_clear_destination',array($this,'delete_old_plugin'),10,4);
$this->run(array('package' => $r->package,'destination' => WP_PLUGIN_DIR,'clear_destination' => true,'clear_working' => true,'hook_extra' => array('plugin' => $plugin)));
remove_filter('upgrader_pre_install',array($this,'deactivate_plugin_before_upgrade'));
remove_filter('upgrader_clear_destination',array($this,'delete_old_plugin'));
if ( !$this->result || is_wp_error($this->result))
 {$AspisRetTemp = $this->result;
return $AspisRetTemp;
}delete_transient('update_plugins');
} }
function bulk_upgrade ( $plugins ) {
{$this->init();
$this->bulk = true;
$this->upgrade_strings();
$current = get_transient('update_plugins');
add_filter('upgrader_clear_destination',array($this,'delete_old_plugin'),10,4);
$this->skin->header();
$res = $this->fs_connect(array(WP_CONTENT_DIR,WP_PLUGIN_DIR));
if ( !$res)
 {$this->skin->footer();
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->maintenance_mode(true);
$all = count($plugins);
$i = 1;
foreach ( $plugins as $plugin  )
{$this->show_before = sprintf('<h4>' . __('Updating plugin %1$d of %2$d...') . '</h4>',$i,$all);
$i++;
if ( !isset($current->response[$plugin]))
 {$this->skin->set_result(false);
$this->skin->error('up_to_date');
$this->skin->after();
$results[$plugin] = false;
continue ;
}$r = $current->response[$plugin];
$this->skin->plugin_active = is_plugin_active($plugin);
$result = $this->run(array('package' => $r->package,'destination' => WP_PLUGIN_DIR,'clear_destination' => true,'clear_working' => true,'is_multi' => true,'hook_extra' => array('plugin' => $plugin)));
$results[$plugin] = $this->result;
if ( false === $result)
 break ;
}$this->maintenance_mode(false);
$this->skin->footer();
remove_filter('upgrader_clear_destination',array($this,'delete_old_plugin'));
delete_transient('update_plugins');
{$AspisRetTemp = $results;
return $AspisRetTemp;
}} }
function plugin_info (  ) {
{if ( !is_array($this->result))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( empty($this->result['destination_name']))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$plugin = get_plugins('/' . $this->result['destination_name']);
if ( empty($plugin))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$pluginfiles = array_keys($plugin);
{$AspisRetTemp = $this->result['destination_name'] . '/' . $pluginfiles[0];
return $AspisRetTemp;
}} }
function deactivate_plugin_before_upgrade ( $return,$plugin ) {
{if ( is_wp_error($return))
 {$AspisRetTemp = $return;
return $AspisRetTemp;
}$plugin = isset($plugin['plugin']) ? $plugin['plugin'] : '';
if ( empty($plugin))
 {$AspisRetTemp = new WP_Error('bad_request',$this->strings['bad_request']);
return $AspisRetTemp;
}if ( is_plugin_active($plugin))
 {$this->skin->feedback('deactivate_plugin');
deactivate_plugins($plugin,true);
}} }
function delete_old_plugin ( $removed,$local_destination,$remote_destination,$plugin ) {
{{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}if ( is_wp_error($removed))
 {$AspisRetTemp = $removed;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$plugin = isset($plugin['plugin']) ? $plugin['plugin'] : '';
if ( empty($plugin))
 {$AspisRetTemp = new WP_Error('bad_request',$this->strings['bad_request']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$plugins_dir = $wp_filesystem->wp_plugins_dir();
$this_plugin_dir = trailingslashit(dirname($plugins_dir . $plugin));
if ( !$wp_filesystem->exists($this_plugin_dir))
 {$AspisRetTemp = $removed;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( strpos($plugin,'/') && $this_plugin_dir != $plugins_dir)
 $deleted = $wp_filesystem->delete($this_plugin_dir,true);
else 
{$deleted = $wp_filesystem->delete($plugins_dir . $plugin);
}if ( !$deleted)
 {$AspisRetTemp = new WP_Error('remove_old_failed',$this->strings['remove_old_failed']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $removed;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
}class Theme_Upgrader extends WP_Upgrader{var $result;
function upgrade_strings (  ) {
{$this->strings['up_to_date'] = __('The theme is at the latest version.');
$this->strings['no_package'] = __('Upgrade package not available.');
$this->strings['downloading_package'] = __('Downloading update from <span class="code">%s</span>.');
$this->strings['unpack_package'] = __('Unpacking the update.');
$this->strings['remove_old'] = __('Removing the old version of the theme.');
$this->strings['remove_old_failed'] = __('Could not remove the old theme.');
$this->strings['process_failed'] = __('Theme upgrade Failed.');
$this->strings['process_success'] = __('Theme upgraded successfully.');
} }
function install_strings (  ) {
{$this->strings['no_package'] = __('Install package not available.');
$this->strings['downloading_package'] = __('Downloading install package from <span class="code">%s</span>.');
$this->strings['unpack_package'] = __('Unpacking the package.');
$this->strings['installing_package'] = __('Installing the theme.');
$this->strings['process_failed'] = __('Theme Install Failed.');
$this->strings['process_success'] = __('Theme Installed successfully.');
} }
function install ( $package ) {
{$this->init();
$this->install_strings();
$options = array('package' => $package,'destination' => WP_CONTENT_DIR . '/themes','clear_destination' => false,'clear_working' => true);
$this->run($options);
if ( !$this->result || is_wp_error($this->result))
 {$AspisRetTemp = $this->result;
return $AspisRetTemp;
}delete_transient('update_themes');
if ( empty($result['destination_name']))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = $result['destination_name'];
return $AspisRetTemp;
}}} }
function upgrade ( $theme ) {
{$this->init();
$this->upgrade_strings();
$current = get_transient('update_themes');
if ( !isset($current->response[$theme]))
 {$this->skin->set_result(false);
$this->skin->error('up_to_date');
$this->skin->after();
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$r = $current->response[$theme];
add_filter('upgrader_pre_install',array($this,'current_before'),10,2);
add_filter('upgrader_post_install',array($this,'current_after'),10,2);
add_filter('upgrader_clear_destination',array($this,'delete_old_theme'),10,4);
$options = array('package' => $r['package'],'destination' => WP_CONTENT_DIR . '/themes','clear_destination' => true,'clear_working' => true,'hook_extra' => array('theme' => $theme));
$this->run($options);
if ( !$this->result || is_wp_error($this->result))
 {$AspisRetTemp = $this->result;
return $AspisRetTemp;
}delete_transient('update_themes');
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function current_before ( $return,$theme ) {
{if ( is_wp_error($return))
 {$AspisRetTemp = $return;
return $AspisRetTemp;
}$theme = isset($theme['theme']) ? $theme['theme'] : '';
if ( $theme != get_stylesheet())
 {$AspisRetTemp = $return;
return $AspisRetTemp;
}$this->maintenance_mode(true);
{$AspisRetTemp = $return;
return $AspisRetTemp;
}} }
function current_after ( $return,$theme ) {
{if ( is_wp_error($return))
 {$AspisRetTemp = $return;
return $AspisRetTemp;
}$theme = isset($theme['theme']) ? $theme['theme'] : '';
if ( $theme != get_stylesheet())
 {$AspisRetTemp = $return;
return $AspisRetTemp;
}if ( $theme == get_stylesheet() && $theme != $this->result['destination_name'])
 {$theme_info = $this->theme_info();
$stylesheet = $this->result['destination_name'];
$template = !empty($theme_info['Template']) ? $theme_info['Template'] : $stylesheet;
switch_theme($template,$stylesheet,true);
}$this->maintenance_mode(false);
{$AspisRetTemp = $return;
return $AspisRetTemp;
}} }
function delete_old_theme ( $removed,$local_destination,$remote_destination,$theme ) {
{{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}$theme = isset($theme['theme']) ? $theme['theme'] : '';
if ( is_wp_error($removed) || empty($theme))
 {$AspisRetTemp = $removed;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$themes_dir = $wp_filesystem->wp_themes_dir();
if ( $wp_filesystem->exists(trailingslashit($themes_dir) . $theme))
 if ( !$wp_filesystem->delete(trailingslashit($themes_dir) . $theme,true))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
function theme_info (  ) {
{if ( empty($this->result['destination_name']))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = get_theme_data(WP_CONTENT_DIR . '/themes/' . $this->result['destination_name'] . '/style.css');
return $AspisRetTemp;
}} }
}class Core_Upgrader extends WP_Upgrader{function upgrade_strings (  ) {
{$this->strings['up_to_date'] = __('WordPress is at the latest version.');
$this->strings['no_package'] = __('Upgrade package not available.');
$this->strings['downloading_package'] = __('Downloading update from <span class="code">%s</span>.');
$this->strings['unpack_package'] = __('Unpacking the update.');
$this->strings['copy_failed'] = __('Could not copy files.');
} }
function upgrade ( $current ) {
{{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}$this->init();
$this->upgrade_strings();
if ( !empty($feedback))
 add_filter('update_feedback',$feedback);
if ( !isset($current->response) || $current->response == 'latest')
 {$AspisRetTemp = new WP_Error('up_to_date',$this->strings['up_to_date']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$res = $this->fs_connect(array(ABSPATH,WP_CONTENT_DIR));
if ( is_wp_error($res))
 {$AspisRetTemp = $res;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$wp_dir = trailingslashit($wp_filesystem->abspath());
$download = $this->download_package($current->package);
if ( is_wp_error($download))
 {$AspisRetTemp = $download;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$working_dir = $this->unpack_package($download);
if ( is_wp_error($working_dir))
 {$AspisRetTemp = $working_dir;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( !$wp_filesystem->copy($working_dir . '/wordpress/wp-admin/includes/update-core.php',$wp_dir . 'wp-admin/includes/update-core.php',true))
 {$wp_filesystem->delete($working_dir,true);
{$AspisRetTemp = new WP_Error('copy_failed',$this->strings['copy_failed']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}$wp_filesystem->chmod($wp_dir . 'wp-admin/includes/update-core.php',FS_CHMOD_FILE);
require (ABSPATH . 'wp-admin/includes/update-core.php');
{$AspisRetTemp = update_core($working_dir,$wp_dir);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
}class WP_Upgrader_Skin{var $upgrader;
var $done_header = false;
function WP_Upgrader_Skin ( $args = array() ) {
{{$AspisRetTemp = $this->__construct($args);
return $AspisRetTemp;
}} }
function __construct ( $args = array() ) {
{$defaults = array('url' => '','nonce' => '','title' => '','context' => false);
$this->options = wp_parse_args($args,$defaults);
} }
function set_upgrader ( &$upgrader ) {
{if ( is_object($upgrader))
 $this->upgrader = &$upgrader;
} }
function set_result ( $result ) {
{$this->result = $result;
} }
function request_filesystem_credentials ( $error = false ) {
{$url = $this->options['url'];
$context = $this->options['context'];
if ( !empty($this->options['nonce']))
 $url = wp_nonce_url($url,$this->options['nonce']);
{$AspisRetTemp = request_filesystem_credentials($url,'',$error,$context);
return $AspisRetTemp;
}} }
function header (  ) {
{if ( $this->done_header)
 {return ;
}$this->done_header = true;
echo '<div class="wrap">';
echo screen_icon();
echo '<h2>' . $this->options['title'] . '</h2>';
} }
function footer (  ) {
{echo '</div>';
} }
function error ( $errors ) {
{if ( !$this->done_header)
 $this->header();
if ( is_string($errors))
 {$this->feedback($errors);
}elseif ( is_wp_error($errors) && $errors->get_error_code())
 {foreach ( $errors->get_error_messages() as $message  )
{if ( $errors->get_error_data())
 $this->feedback($message . ' ' . $errors->get_error_data());
else 
{$this->feedback($message);
}}}} }
function feedback ( $string ) {
{if ( isset($this->upgrader->strings[$string]))
 $string = $this->upgrader->strings[$string];
if ( strpos($string,'%') !== false)
 {$args = func_get_args();
$args = array_splice($args,1);
if ( !empty($args))
 $string = vsprintf($string,$args);
}if ( empty($string))
 {return ;
}show_message($string);
} }
function before (  ) {
{} }
function after (  ) {
{} }
}class Plugin_Upgrader_Skin extends WP_Upgrader_Skin{var $plugin = '';
var $plugin_active = false;
function Plugin_Upgrader_Skin ( $args = array() ) {
{{$AspisRetTemp = $this->__construct($args);
return $AspisRetTemp;
}} }
function __construct ( $args = array() ) {
{$defaults = array('url' => '','plugin' => '','nonce' => '','title' => __('Upgrade Plugin'));
$args = wp_parse_args($args,$defaults);
$this->plugin = $args['plugin'];
$this->plugin_active = is_plugin_active($this->plugin);
parent::__construct($args);
} }
function after (  ) {
{if ( $this->upgrader->bulk)
 {return ;
}$this->plugin = $this->upgrader->plugin_info();
if ( !empty($this->plugin) && !is_wp_error($this->result) && $this->plugin_active)
 {show_message(__('Attempting reactivation of the plugin'));
echo '<iframe style="border:0;overflow:hidden" width="100%" height="170px" src="' . wp_nonce_url('update.php?action=activate-plugin&plugin=' . $this->plugin,'activate-plugin_' . $this->plugin) . '"></iframe>';
}$update_actions = array('activate_plugin' => '<a href="' . wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $this->plugin,'activate-plugin_' . $this->plugin) . '" title="' . esc_attr__('Activate this plugin') . '" target="_parent">' . __('Activate Plugin') . '</a>','plugins_page' => '<a href="' . admin_url('plugins.php') . '" title="' . esc_attr__('Goto plugins page') . '" target="_parent">' . __('Return to Plugins page') . '</a>');
if ( $this->plugin_active)
 unset($update_actions['activate_plugin']);
if ( !$this->result || is_wp_error($this->result))
 unset($update_actions['activate_plugin']);
$update_actions = apply_filters('update_plugin_complete_actions',$update_actions,$this->plugin);
if ( !empty($update_actions))
 $this->feedback('<strong>' . __('Actions:') . '</strong> ' . implode(' | ',(array)$update_actions));
} }
function before (  ) {
{if ( $this->upgrader->show_before)
 {echo $this->upgrader->show_before;
$this->upgrader->show_before = '';
}} }
}class Plugin_Installer_Skin extends WP_Upgrader_Skin{var $api;
var $type;
function Plugin_Installer_Skin ( $args = array() ) {
{{$AspisRetTemp = $this->__construct($args);
return $AspisRetTemp;
}} }
function __construct ( $args = array() ) {
{$defaults = array('type' => 'web','url' => '','plugin' => '','nonce' => '','title' => '');
$args = wp_parse_args($args,$defaults);
$this->type = $args['type'];
$this->api = isset($args['api']) ? $args['api'] : array();
parent::__construct($args);
} }
function before (  ) {
{if ( !empty($this->api))
 $this->upgrader->strings['process_success'] = sprintf(__('Successfully installed the plugin <strong>%s %s</strong>.'),$this->api->name,$this->api->version);
} }
function after (  ) {
{$plugin_file = $this->upgrader->plugin_info();
$install_actions = array('activate_plugin' => '<a href="' . wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin_file,'activate-plugin_' . $plugin_file) . '" title="' . esc_attr__('Activate this plugin') . '" target="_parent">' . __('Activate Plugin') . '</a>',);
if ( $this->type == 'web')
 $install_actions['plugins_page'] = '<a href="' . admin_url('plugin-install.php') . '" title="' . esc_attr__('Return to Plugin Installer') . '" target="_parent">' . __('Return to Plugin Installer') . '</a>';
else 
{$install_actions['plugins_page'] = '<a href="' . admin_url('plugins.php') . '" title="' . esc_attr__('Return to Plugins page') . '" target="_parent">' . __('Return to Plugins page') . '</a>';
}if ( !$this->result || is_wp_error($this->result))
 unset($install_actions['activate_plugin']);
$install_actions = apply_filters('install_plugin_complete_actions',$install_actions,$this->api,$plugin_file);
if ( !empty($install_actions))
 $this->feedback('<strong>' . __('Actions:') . '</strong> ' . implode(' | ',(array)$install_actions));
} }
}class Theme_Installer_Skin extends WP_Upgrader_Skin{var $api;
var $type;
function Theme_Installer_Skin ( $args = array() ) {
{{$AspisRetTemp = $this->__construct($args);
return $AspisRetTemp;
}} }
function __construct ( $args = array() ) {
{$defaults = array('type' => 'web','url' => '','theme' => '','nonce' => '','title' => '');
$args = wp_parse_args($args,$defaults);
$this->type = $args['type'];
$this->api = isset($args['api']) ? $args['api'] : array();
parent::__construct($args);
} }
function before (  ) {
{if ( !empty($this->api))
 {$this->upgrader->strings['process_success'] = sprintf(__('Successfully installed the theme <strong>%1$s %2$s</strong>.'),$this->api->name,$this->api->version);
}} }
function after (  ) {
{if ( empty($this->upgrader->result['destination_name']))
 {return ;
}$theme_info = $this->upgrader->theme_info();
if ( empty($theme_info))
 {return ;
}$name = $theme_info['Name'];
$stylesheet = $this->upgrader->result['destination_name'];
$template = !empty($theme_info['Template']) ? $theme_info['Template'] : $stylesheet;
$preview_link = htmlspecialchars(add_query_arg(array('preview' => 1,'template' => $template,'stylesheet' => $stylesheet,'TB_iframe' => 'true'),trailingslashit(esc_url(get_option('home')))));
$activate_link = wp_nonce_url("themes.php?action=activate&amp;template=" . urlencode($template) . "&amp;stylesheet=" . urlencode($stylesheet),'switch-theme_' . $template);
$install_actions = array('preview' => '<a href="' . $preview_link . '" class="thickbox thickbox-preview" title="' . esc_attr(sprintf(__('Preview &#8220;%s&#8221;'),$name)) . '">' . __('Preview') . '</a>','activate' => '<a href="' . $activate_link . '" class="activatelink" title="' . esc_attr(sprintf(__('Activate &#8220;%s&#8221;'),$name)) . '">' . __('Activate') . '</a>');
if ( $this->type == 'web')
 $install_actions['themes_page'] = '<a href="' . admin_url('theme-install.php') . '" title="' . esc_attr__('Return to Theme Installer') . '" target="_parent">' . __('Return to Theme Installer') . '</a>';
else 
{$install_actions['themes_page'] = '<a href="' . admin_url('themes.php') . '" title="' . esc_attr__('Themes page') . '" target="_parent">' . __('Return to Themes page') . '</a>';
}if ( !$this->result || is_wp_error($this->result))
 unset($install_actions['activate'],$install_actions['preview']);
$install_actions = apply_filters('install_theme_complete_actions',$install_actions,$this->api,$stylesheet,$theme_info);
if ( !empty($install_actions))
 $this->feedback('<strong>' . __('Actions:') . '</strong> ' . implode(' | ',(array)$install_actions));
} }
}class Theme_Upgrader_Skin extends WP_Upgrader_Skin{var $theme = '';
function Theme_Upgrader_Skin ( $args = array() ) {
{{$AspisRetTemp = $this->__construct($args);
return $AspisRetTemp;
}} }
function __construct ( $args = array() ) {
{$defaults = array('url' => '','theme' => '','nonce' => '','title' => __('Upgrade Theme'));
$args = wp_parse_args($args,$defaults);
$this->theme = $args['theme'];
parent::__construct($args);
} }
function after (  ) {
{if ( !empty($this->upgrader->result['destination_name']) && ($theme_info = $this->upgrader->theme_info()) && !empty($theme_info))
 {$name = $theme_info['Name'];
$stylesheet = $this->upgrader->result['destination_name'];
$template = !empty($theme_info['Template']) ? $theme_info['Template'] : $stylesheet;
$preview_link = htmlspecialchars(add_query_arg(array('preview' => 1,'template' => $template,'stylesheet' => $stylesheet,'TB_iframe' => 'true'),trailingslashit(esc_url(get_option('home')))));
$activate_link = wp_nonce_url("themes.php?action=activate&amp;template=" . urlencode($template) . "&amp;stylesheet=" . urlencode($stylesheet),'switch-theme_' . $template);
$update_actions = array('preview' => '<a href="' . $preview_link . '" class="thickbox thickbox-preview" title="' . esc_attr(sprintf(__('Preview &#8220;%s&#8221;'),$name)) . '">' . __('Preview') . '</a>','activate' => '<a href="' . $activate_link . '" class="activatelink" title="' . esc_attr(sprintf(__('Activate &#8220;%s&#8221;'),$name)) . '">' . __('Activate') . '</a>',);
if ( (!$this->result || is_wp_error($this->result)) || $stylesheet == get_stylesheet())
 unset($update_actions['preview'],$update_actions['activate']);
}$update_actions['themes_page'] = '<a href="' . admin_url('themes.php') . '" title="' . esc_attr__('Return to Themes page') . '" target="_parent">' . __('Return to Themes page') . '</a>';
$update_actions = apply_filters('update_theme_complete_actions',$update_actions,$this->theme);
if ( !empty($update_actions))
 $this->feedback('<strong>' . __('Actions:') . '</strong> ' . implode(' | ',(array)$update_actions));
} }
}class File_Upload_Upgrader{var $package;
var $filename;
function File_Upload_Upgrader ( $form,$urlholder ) {
{{$AspisRetTemp = $this->__construct($form,$urlholder);
return $AspisRetTemp;
}} }
function __construct ( $form,$urlholder ) {
{if ( !(($uploads = wp_upload_dir()) && false === $uploads['error']))
 wp_die($uploads['error']);
if ( (empty($_FILES[0][$form][0]['name']) || Aspis_empty($_FILES[0][$form][0]['name'])) && (empty($_GET[0][$urlholder]) || Aspis_empty($_GET[0][$urlholder])))
 wp_die(__('Please select a file'));
if ( !(empty($_FILES) || Aspis_empty($_FILES)))
 $this->filename = deAspisWarningRC($_FILES[0][$form][0]['name']);
else 
{if ( (isset($_GET[0][$urlholder]) && Aspis_isset($_GET[0][$urlholder])))
 $this->filename = deAspisWarningRC($_GET[0][$urlholder]);
}if ( !(empty($_FILES) || Aspis_empty($_FILES)))
 {$this->filename = wp_unique_filename($uploads['basedir'],$this->filename);
$this->package = $uploads['basedir'] . '/' . $this->filename;
if ( false === @move_uploaded_file(deAspisWarningRC($_FILES[0][$form][0]['tmp_name']),$this->package))
 wp_die(sprintf(__('The uploaded file could not be moved to %s.'),$uploads['path']));
}else 
{{$this->package = $uploads['basedir'] . '/' . $this->filename;
}}} }
}