<?php require_once('AspisMain.php'); ?><?php
$wp_file_descriptions = array('index.php' => __('Main Index Template'),'style.css' => __('Stylesheet'),'rtl.css' => __('RTL Stylesheet'),'comments.php' => __('Comments'),'comments-popup.php' => __('Popup Comments'),'footer.php' => __('Footer'),'header.php' => __('Header'),'sidebar.php' => __('Sidebar'),'archive.php' => __('Archives'),'category.php' => __('Category Template'),'page.php' => __('Page Template'),'search.php' => __('Search Results'),'searchform.php' => __('Search Form'),'single.php' => __('Single Post'),'404.php' => __('404 Template'),'link.php' => __('Links Template'),'functions.php' => __('Theme Functions'),'attachment.php' => __('Attachment Template'),'image.php' => __('Image Attachment Template'),'video.php' => __('Video Attachment Template'),'audio.php' => __('Audio Attachment Template'),'application.php' => __('Application Attachment Template'),'my-hacks.php' => __('my-hacks.php (legacy hacks support)'),'.htaccess' => __('.htaccess (for rewrite rules )'),'wp-layout.css' => __('Stylesheet'),'wp-comments.php' => __('Comments Template'),'wp-comments-popup.php' => __('Popup Comments Template'));
function get_file_description ( $file ) {
{global $wp_file_descriptions;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_file_descriptions,"\$wp_file_descriptions",$AspisChangesCache);
}if ( isset($wp_file_descriptions[basename($file)]))
 {{$AspisRetTemp = $wp_file_descriptions[basename($file)];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_file_descriptions",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( file_exists(WP_CONTENT_DIR . $file) && is_file(WP_CONTENT_DIR . $file))
 {$template_data = implode('',file(WP_CONTENT_DIR . $file));
if ( preg_match('|Template Name:(.*)$|mi',$template_data,$name))
 {$AspisRetTemp = _cleanup_header_comment($name[1]) . ' Page Template';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_file_descriptions",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = basename($file);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_file_descriptions",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_file_descriptions",$AspisChangesCache);
 }
function get_home_path (  ) {
$home = get_option('home');
$siteurl = get_option('siteurl');
if ( $home != '' && $home != $siteurl)
 {$wp_path_rel_to_home = str_replace($home,'',$siteurl);
$pos = strpos(deAspisWarningRC($_SERVER[0]["SCRIPT_FILENAME"]),$wp_path_rel_to_home);
$home_path = substr(deAspisWarningRC($_SERVER[0]["SCRIPT_FILENAME"]),0,$pos);
$home_path = trailingslashit($home_path);
}else 
{{$home_path = ABSPATH;
}}{$AspisRetTemp = $home_path;
return $AspisRetTemp;
} }
function get_real_file_to_edit ( $file ) {
if ( 'index.php' == $file || '.htaccess' == $file)
 {$real_file = get_home_path() . $file;
}else 
{{$real_file = WP_CONTENT_DIR . $file;
}}{$AspisRetTemp = $real_file;
return $AspisRetTemp;
} }
function list_files ( $folder = '',$levels = 100 ) {
if ( empty($folder))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$levels)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$files = array();
if ( $dir = @opendir($folder))
 {while ( ($file = readdir($dir)) !== false )
{if ( in_array($file,array('.','..')))
 continue ;
if ( is_dir($folder . '/' . $file))
 {$files2 = list_files($folder . '/' . $file,$levels - 1);
if ( $files2)
 $files = array_merge($files,$files2);
else 
{$files[] = $folder . '/' . $file . '/';
}}else 
{{$files[] = $folder . '/' . $file;
}}}}@closedir($dir);
{$AspisRetTemp = $files;
return $AspisRetTemp;
} }
function get_temp_dir (  ) {
if ( defined('WP_TEMP_DIR'))
 {$AspisRetTemp = trailingslashit(WP_TEMP_DIR);
return $AspisRetTemp;
}$temp = WP_CONTENT_DIR . '/';
if ( is_dir($temp) && is_writable($temp))
 {$AspisRetTemp = $temp;
return $AspisRetTemp;
}if ( function_exists('sys_get_temp_dir'))
 {$AspisRetTemp = trailingslashit(sys_get_temp_dir());
return $AspisRetTemp;
}{$AspisRetTemp = '/tmp/';
return $AspisRetTemp;
} }
function wp_tempnam ( $filename = '',$dir = '' ) {
if ( empty($dir))
 $dir = get_temp_dir();
$filename = basename($filename);
if ( empty($filename))
 $filename = time();
$filename = preg_replace('|\..*$|','.tmp',$filename);
$filename = $dir . wp_unique_filename($dir,$filename);
touch($filename);
{$AspisRetTemp = $filename;
return $AspisRetTemp;
} }
function validate_file_to_edit ( $file,$allowed_files = '' ) {
$code = validate_file($file,$allowed_files);
if ( !$code)
 {$AspisRetTemp = $file;
return $AspisRetTemp;
}switch ( $code ) {
case 1:wp_die(__('Sorry, can&#8217;t edit files with &#8220;..&#8221; in the name. If you are trying to edit a file in your WordPress home directory, you can just type the name of the file in.'));
case 3:wp_die(__('Sorry, that file cannot be edited.'));
 }
 }
function wp_handle_upload ( &$file,$overrides = false,$time = null ) {
if ( !function_exists('wp_handle_upload_error'))
 {function wp_handle_upload_error ( &$file,$message ) {
{$AspisRetTemp = array('error' => $message);
return $AspisRetTemp;
} }
}$file = apply_filters('wp_handle_upload_prefilter',$file);
$upload_error_handler = 'wp_handle_upload_error';
if ( isset($file['error']) && !is_numeric($file['error']) && $file['error'])
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,$file['error']);
return $AspisRetTemp;
}$unique_filename_callback = null;
$action = 'wp_handle_upload';
$upload_error_strings = array(false,__("The uploaded file exceeds the <code>upload_max_filesize</code> directive in <code>php.ini</code>."),__("The uploaded file exceeds the <em>MAX_FILE_SIZE</em> directive that was specified in the HTML form."),__("The uploaded file was only partially uploaded."),__("No file was uploaded."),'',__("Missing a temporary folder."),__("Failed to write file to disk."),__("File upload stopped by extension."));
$test_form = true;
$test_size = true;
$test_type = true;
$mimes = false;
if ( is_array($overrides))
 extract(($overrides),EXTR_OVERWRITE);
if ( $test_form && (!(isset($_POST[0]['action']) && Aspis_isset($_POST[0]['action'])) || (deAspisWarningRC($_POST[0]['action']) != $action)))
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,__('Invalid form submission.'));
return $AspisRetTemp;
}if ( $file['error'] > 0)
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,$upload_error_strings[$file['error']]);
return $AspisRetTemp;
}if ( $test_size && !($file['size'] > 0))
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,__('File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.'));
return $AspisRetTemp;
}if ( !@is_uploaded_file($file['tmp_name']))
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,__('Specified file failed upload test.'));
return $AspisRetTemp;
}if ( $test_type)
 {$wp_filetype = wp_check_filetype($file['name'],$mimes);
extract(($wp_filetype));
if ( (!$type || !$ext) && !current_user_can('unfiltered_upload'))
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,__('File type does not meet security guidelines. Try another.'));
return $AspisRetTemp;
}if ( !$ext)
 $ext = ltrim(strrchr($file['name'],'.'),'.');
if ( !$type)
 $type = $file['type'];
}else 
{{$type = '';
}}if ( !(($uploads = wp_upload_dir($time)) && false === $uploads['error']))
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,$uploads['error']);
return $AspisRetTemp;
}$filename = wp_unique_filename($uploads['path'],$file['name'],$unique_filename_callback);
$new_file = $uploads['path'] . "/$filename";
if ( false === @move_uploaded_file($file['tmp_name'],$new_file))
 {{$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,sprintf(__('The uploaded file could not be moved to %s.'),$uploads['path']));
return $AspisRetTemp;
}}$stat = stat(dirname($new_file));
$perms = $stat['mode'] & 0000666;
@chmod($new_file,$perms);
$url = $uploads['url'] . "/$filename";
{$AspisRetTemp = apply_filters('wp_handle_upload',array('file' => $new_file,'url' => $url,'type' => $type));
return $AspisRetTemp;
} }
function wp_handle_sideload ( &$file,$overrides = false ) {
if ( !function_exists('wp_handle_upload_error'))
 {function wp_handle_upload_error ( &$file,$message ) {
{$AspisRetTemp = array('error' => $message);
return $AspisRetTemp;
} }
}$upload_error_handler = 'wp_handle_upload_error';
$unique_filename_callback = null;
$action = 'wp_handle_sideload';
$upload_error_strings = array(false,__("The uploaded file exceeds the <code>upload_max_filesize</code> directive in <code>php.ini</code>."),__("The uploaded file exceeds the <em>MAX_FILE_SIZE</em> directive that was specified in the HTML form."),__("The uploaded file was only partially uploaded."),__("No file was uploaded."),'',__("Missing a temporary folder."),__("Failed to write file to disk."),__("File upload stopped by extension."));
$test_form = true;
$test_size = true;
$test_type = true;
$mimes = false;
if ( is_array($overrides))
 extract(($overrides),EXTR_OVERWRITE);
if ( $test_form && (!(isset($_POST[0]['action']) && Aspis_isset($_POST[0]['action'])) || (deAspisWarningRC($_POST[0]['action']) != $action)))
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,__('Invalid form submission.'));
return $AspisRetTemp;
}if ( $file['error'] > 0)
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,$upload_error_strings[$file['error']]);
return $AspisRetTemp;
}if ( $test_size && !(filesize($file['tmp_name']) > 0))
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,__('File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini.'));
return $AspisRetTemp;
}if ( !@is_file($file['tmp_name']))
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,__('Specified file does not exist.'));
return $AspisRetTemp;
}if ( $test_type)
 {$wp_filetype = wp_check_filetype($file['name'],$mimes);
extract(($wp_filetype));
if ( (!$type || !$ext) && !current_user_can('unfiltered_upload'))
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,__('File type does not meet security guidelines. Try another.'));
return $AspisRetTemp;
}if ( !$ext)
 $ext = ltrim(strrchr($file['name'],'.'),'.');
if ( !$type)
 $type = $file['type'];
}if ( !(($uploads = wp_upload_dir()) && false === $uploads['error']))
 {$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,$uploads['error']);
return $AspisRetTemp;
}$filename = wp_unique_filename($uploads['path'],$file['name'],$unique_filename_callback);
$filename = str_replace('?','-',$filename);
$filename = str_replace('&','-',$filename);
$new_file = $uploads['path'] . "/$filename";
if ( false === @rename($file['tmp_name'],$new_file))
 {{$AspisRetTemp = AspisUntaintedDynamicCall($upload_error_handler,$file,sprintf(__('The uploaded file could not be moved to %s.'),$uploads['path']));
return $AspisRetTemp;
}}$stat = stat(dirname($new_file));
$perms = $stat['mode'] & 0000666;
@chmod($new_file,$perms);
$url = $uploads['url'] . "/$filename";
$return = apply_filters('wp_handle_upload',array('file' => $new_file,'url' => $url,'type' => $type));
{$AspisRetTemp = $return;
return $AspisRetTemp;
} }
function download_url ( $url ) {
if ( !$url)
 {$AspisRetTemp = new WP_Error('http_no_url',__('Invalid URL Provided'));
return $AspisRetTemp;
}$tmpfname = wp_tempnam($url);
if ( !$tmpfname)
 {$AspisRetTemp = new WP_Error('http_no_file',__('Could not create Temporary file'));
return $AspisRetTemp;
}$handle = @fopen($tmpfname,'wb');
if ( !$handle)
 {$AspisRetTemp = new WP_Error('http_no_file',__('Could not create Temporary file'));
return $AspisRetTemp;
}$response = wp_remote_get($url,array('timeout' => 300));
if ( is_wp_error($response))
 {fclose($handle);
unlink($tmpfname);
{$AspisRetTemp = $response;
return $AspisRetTemp;
}}if ( $response['response']['code'] != '200')
 {fclose($handle);
unlink($tmpfname);
{$AspisRetTemp = new WP_Error('http_404',trim($response['response']['message']));
return $AspisRetTemp;
}}fwrite($handle,$response['body']);
fclose($handle);
{$AspisRetTemp = $tmpfname;
return $AspisRetTemp;
} }
function unzip_file ( $file,$to ) {
{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}if ( !$wp_filesystem || !is_object($wp_filesystem))
 {$AspisRetTemp = new WP_Error('fs_unavailable',__('Could not access filesystem.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}@ini_set('memory_limit','256M');
$fs = &$wp_filesystem;
require_once (ABSPATH . 'wp-admin/includes/class-pclzip.php');
$archive = new PclZip($file);
if ( false == ($archive_files = $archive->extract(PCLZIP_OPT_EXTRACT_AS_STRING)))
 {$AspisRetTemp = new WP_Error('incompatible_archive',__('Incompatible archive'),$archive->errorInfo(true));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( 0 == count($archive_files))
 {$AspisRetTemp = new WP_Error('empty_archive',__('Empty archive'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$path = explode('/',untrailingslashit($to));
for ( $i = count($path) ; $i > 0 ; $i-- )
{$tmppath = implode('/',array_slice($path,0,$i));
if ( $fs->is_dir($tmppath))
 {for ( $i = $i + 1 ; $i <= count($path) ; $i++ )
{$tmppath = implode('/',array_slice($path,0,$i));
if ( !$fs->mkdir($tmppath,FS_CHMOD_DIR))
 {$AspisRetTemp = new WP_Error('mkdir_failed',__('Could not create directory'),$tmppath);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}break ;
}}$to = trailingslashit($to);
foreach ( $archive_files as $file  )
{$path = $file['folder'] ? $file['filename'] : dirname($file['filename']);
$path = explode('/',$path);
for ( $i = count($path) ; $i >= 0 ; $i-- )
{if ( empty($path[$i]))
 continue ;
$tmppath = $to . implode('/',array_slice($path,0,$i));
if ( $fs->is_dir($tmppath))
 {for ( $i = $i + 1 ; $i <= count($path) ; $i++ )
{$tmppath = $to . implode('/',array_slice($path,0,$i));
if ( !$fs->is_dir($tmppath) && !$fs->mkdir($tmppath,FS_CHMOD_DIR))
 {$AspisRetTemp = new WP_Error('mkdir_failed',__('Could not create directory'),$tmppath);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}break ;
}}if ( !$file['folder'])
 {if ( !$fs->put_contents($to . $file['filename'],$file['content']))
 {$AspisRetTemp = new WP_Error('copy_failed',__('Could not copy file'),$to . $file['filename']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$fs->chmod($to . $file['filename'],FS_CHMOD_FILE);
}}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
function copy_dir ( $from,$to ) {
{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}$dirlist = $wp_filesystem->dirlist($from);
$from = trailingslashit($from);
$to = trailingslashit($to);
foreach ( (array)$dirlist as $filename =>$fileinfo )
{if ( 'f' == $fileinfo['type'])
 {if ( !$wp_filesystem->copy($from . $filename,$to . $filename,true))
 {$wp_filesystem->chmod($to . $filename,0644);
if ( !$wp_filesystem->copy($from . $filename,$to . $filename,true))
 {$AspisRetTemp = new WP_Error('copy_failed',__('Could not copy file'),$to . $filename);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}$wp_filesystem->chmod($to . $filename,FS_CHMOD_FILE);
}elseif ( 'd' == $fileinfo['type'])
 {if ( !$wp_filesystem->is_dir($to . $filename))
 {if ( !$wp_filesystem->mkdir($to . $filename,FS_CHMOD_DIR))
 {$AspisRetTemp = new WP_Error('mkdir_failed',__('Could not create directory'),$to . $filename);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}$result = copy_dir($from . $filename,$to . $filename);
if ( is_wp_error($result))
 {$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}}}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
function WP_Filesystem ( $args = false,$context = false ) {
{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}require_once (ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
$method = get_filesystem_method($args,$context);
if ( !$method)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( !class_exists("WP_Filesystem_$method"))
 {$abstraction_file = apply_filters('filesystem_method_file',ABSPATH . 'wp-admin/includes/class-wp-filesystem-' . $method . '.php',$method);
if ( !file_exists($abstraction_file))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return ;
}require_once ($abstraction_file);
}$method = "WP_Filesystem_$method";
$wp_filesystem = AspisNewUnknownProxy($method,array( $args),false);
if ( !defined('FS_CONNECT_TIMEOUT'))
 define('FS_CONNECT_TIMEOUT',30);
if ( !defined('FS_TIMEOUT'))
 define('FS_TIMEOUT',30);
if ( is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->get_error_code())
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( !$wp_filesystem->connect())
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( !defined('FS_CHMOD_DIR'))
 define('FS_CHMOD_DIR',0755);
if ( !defined('FS_CHMOD_FILE'))
 define('FS_CHMOD_FILE',0644);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
function get_filesystem_method ( $args = array(),$context = false ) {
$method = defined('FS_METHOD') ? FS_METHOD : false;
if ( !$method && function_exists('getmyuid') && function_exists('fileowner'))
 {if ( !$context)
 $context = WP_CONTENT_DIR;
$context = trailingslashit($context);
$temp_file_name = $context . 'temp-write-test-' . time();
$temp_handle = @fopen($temp_file_name,'w');
if ( $temp_handle)
 {if ( getmyuid() == @fileowner($temp_file_name))
 $method = 'direct';
@fclose($temp_handle);
@unlink($temp_file_name);
}}if ( !$method && isset($args['connection_type']) && 'ssh' == $args['connection_type'] && extension_loaded('ssh2') && function_exists('stream_get_contents'))
 $method = 'ssh2';
if ( !$method && extension_loaded('ftp'))
 $method = 'ftpext';
if ( !$method && (extension_loaded('sockets') || function_exists('fsockopen')))
 $method = 'ftpsockets';
{$AspisRetTemp = apply_filters('filesystem_method',$method,$args);
return $AspisRetTemp;
} }
function request_filesystem_credentials ( $form_post,$type = '',$error = false,$context = false ) {
$req_cred = apply_filters('request_filesystem_credentials','',$form_post,$type,$error,$context);
if ( '' !== $req_cred)
 {$AspisRetTemp = $req_cred;
return $AspisRetTemp;
}if ( empty($type))
 $type = get_filesystem_method(array(),$context);
if ( 'direct' == $type)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}$credentials = get_option('ftp_credentials',array('hostname' => '','username' => ''));
$credentials['hostname'] = defined('FTP_HOST') ? FTP_HOST : (!(empty($_POST[0]['hostname']) || Aspis_empty($_POST[0]['hostname'])) ? stripslashes(deAspisWarningRC($_POST[0]['hostname'])) : $credentials['hostname']);
$credentials['username'] = defined('FTP_USER') ? FTP_USER : (!(empty($_POST[0]['username']) || Aspis_empty($_POST[0]['username'])) ? stripslashes(deAspisWarningRC($_POST[0]['username'])) : $credentials['username']);
$credentials['password'] = defined('FTP_PASS') ? FTP_PASS : (!(empty($_POST[0]['password']) || Aspis_empty($_POST[0]['password'])) ? stripslashes(deAspisWarningRC($_POST[0]['password'])) : '');
$credentials['public_key'] = defined('FTP_PUBKEY') ? FTP_PUBKEY : (!(empty($_POST[0]['public_key']) || Aspis_empty($_POST[0]['public_key'])) ? stripslashes(deAspisWarningRC($_POST[0]['public_key'])) : '');
$credentials['private_key'] = defined('FTP_PRIKEY') ? FTP_PRIKEY : (!(empty($_POST[0]['private_key']) || Aspis_empty($_POST[0]['private_key'])) ? stripslashes(deAspisWarningRC($_POST[0]['private_key'])) : '');
$credentials['hostname'] = preg_replace('|\w+://|','',$credentials['hostname']);
if ( strpos($credentials['hostname'],':'))
 {list($credentials['hostname'],$credentials['port']) = explode(':',$credentials['hostname'],2);
if ( !is_numeric($credentials['port']))
 unset($credentials['port']);
}else 
{{unset($credentials['port']);
}}if ( (defined('FTP_SSH') && FTP_SSH) || (defined('FS_METHOD') && 'ssh' == FS_METHOD))
 $credentials['connection_type'] = 'ssh';
else 
{if ( (defined('FTP_SSL') && FTP_SSL) && 'ftpext' == $type)
 $credentials['connection_type'] = 'ftps';
else 
{if ( !(empty($_POST[0]['connection_type']) || Aspis_empty($_POST[0]['connection_type'])))
 $credentials['connection_type'] = stripslashes(deAspisWarningRC($_POST[0]['connection_type']));
else 
{if ( !isset($credentials['connection_type']))
 $credentials['connection_type'] = 'ftp';
}}}if ( !$error && ((!empty($credentials['password']) && !empty($credentials['username']) && !empty($credentials['hostname'])) || ('ssh' == $credentials['connection_type'] && !empty($credentials['public_key']) && !empty($credentials['private_key']))))
 {$stored_credentials = $credentials;
if ( !empty($stored_credentials['port']))
 $stored_credentials['hostname'] .= ':' . $stored_credentials['port'];
unset($stored_credentials['password'],$stored_credentials['port'],$stored_credentials['private_key'],$stored_credentials['public_key']);
update_option('ftp_credentials',$stored_credentials);
{$AspisRetTemp = $credentials;
return $AspisRetTemp;
}}$hostname = '';
$username = '';
$password = '';
$connection_type = '';
if ( !empty($credentials))
 extract(($credentials),EXTR_OVERWRITE);
if ( $error)
 {$error_string = __('<strong>Error:</strong> There was an error connecting to the server, Please verify the settings are correct.');
if ( is_wp_error($error))
 $error_string = $error->get_error_message();
echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
}$types = array();
if ( extension_loaded('ftp') || extension_loaded('sockets') || function_exists('fsockopen'))
 $types['ftp'] = __('FTP');
if ( extension_loaded('ftp'))
 $types['ftps'] = __('FTPS (SSL)');
if ( extension_loaded('ssh2') && function_exists('stream_get_contents'))
 $types['ssh'] = __('SSH2');
$types = apply_filters('fs_ftp_connection_types',$types,$credentials,$type,$error,$context);
;
?>
<script type="text/javascript">
<!--
jQuery(function($){
	jQuery("#ssh").click(function () {
		jQuery("#ssh_keys").show();
	});
	jQuery("#ftp, #ftps").click(function () {
		jQuery("#ssh_keys").hide();
	});
	jQuery('form input[value=""]:first').focus();
});
-->
</script>
<form action="<?php echo $form_post;
?>" method="post">
<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e('Connection Information');
?></h2>
<p><?php _e('To perform the requested action, connection information is required.');
?></p>

<table class="form-table">
<tr valign="top">
<th scope="row"><label for="hostname"><?php _e('Hostname');
?></label></th>
<td><input name="hostname" type="text" id="hostname" value="<?php echo esc_attr($hostname);
if ( !empty($port))
 echo ":$port";
;
?>"<?php if ( defined('FTP_HOST'))
 echo ' disabled="disabled"';
?> size="40" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="username"><?php _e('Username');
?></label></th>
<td><input name="username" type="text" id="username" value="<?php echo esc_attr($username);
?>"<?php if ( defined('FTP_USER'))
 echo ' disabled="disabled"';
?> size="40" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="password"><?php _e('Password');
?></label></th>
<td><input name="password" type="password" id="password" value="<?php if ( defined('FTP_PASS'))
 echo '*****';
;
?>"<?php if ( defined('FTP_PASS'))
 echo ' disabled="disabled"';
?> size="40" /></td>
</tr>

<?php if ( isset($types['ssh']))
 {;
?>
<tr id="ssh_keys" valign="top" style="<?php if ( 'ssh' != $connection_type)
 echo 'display:none';
?>">
<th scope="row"><?php _e('Authentication Keys');
?>
<div class="key-labels textright">
<label for="public_key"><?php _e('Public Key:');
?></label ><br />
<label for="private_key"><?php _e('Private Key:');
?></label>
</div></th>
<td><br /><input name="public_key" type="text" id="public_key" value="<?php echo esc_attr($public_key);
?>"<?php if ( defined('FTP_PUBKEY'))
 echo ' disabled="disabled"';
?> size="40" /><br /><input name="private_key" type="text" id="private_key" value="<?php echo esc_attr($private_key);
?>"<?php if ( defined('FTP_PRIKEY'))
 echo ' disabled="disabled"';
?> size="40" />
<div><?php _e('Enter the location on the server where the keys are located. If a passphrase is needed, enter that in the password field above.');
?></div></td>
</tr>
<?php };
?>

<tr valign="top">
<th scope="row"><?php _e('Connection Type');
?></th>
<td>
<fieldset><legend class="screen-reader-text"><span><?php _e('Connection Type');
?></span></legend>
<?php $disabled = (defined('FTP_SSL') && FTP_SSL) || (defined('FTP_SSH') && FTP_SSH) ? ' disabled="disabled"' : '';
foreach ( $types as $name =>$text )
{;
?>
	<label for="<?php echo esc_attr($name);
?>">
		<input type="radio" name="connection_type" id="<?php echo esc_attr($name);
?>" value="<?php echo esc_attr($name);
?>" <?php checked($name,$connection_type);
echo $disabled;
;
?>/>
		<?php echo $text;
?>
	</label>
	<?php };
?>
</fieldset>
</td>
</tr>
</table>

<?php if ( (isset($_POST[0]['version']) && Aspis_isset($_POST[0]['version'])))
 {;
?>
<input type="hidden" name="version" value="<?php echo esc_attr(stripslashes(deAspisWarningRC($_POST[0]['version'])));
?>" />
<?php };
?>
<?php if ( (isset($_POST[0]['locale']) && Aspis_isset($_POST[0]['locale'])))
 {;
?>
<input type="hidden" name="locale" value="<?php echo esc_attr(stripslashes(deAspisWarningRC($_POST[0]['locale'])));
?>" />
<?php };
?>
<p class="submit">
<input id="upgrade" name="upgrade" type="submit" class="button" value="<?php esc_attr_e('Proceed');
;
?>" />
</p>
</div>
</form>
<?php {$AspisRetTemp = false;
return $AspisRetTemp;
} }
;
?>
<?php 