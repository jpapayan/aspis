<?php require_once('AspisMain.php'); ?><?php
$wp_file_descriptions = array(array(deregisterTaint(array('index.php',false)) => addTaint(__(array('Main Index Template',false))),deregisterTaint(array('style.css',false)) => addTaint(__(array('Stylesheet',false))),deregisterTaint(array('rtl.css',false)) => addTaint(__(array('RTL Stylesheet',false))),deregisterTaint(array('comments.php',false)) => addTaint(__(array('Comments',false))),deregisterTaint(array('comments-popup.php',false)) => addTaint(__(array('Popup Comments',false))),deregisterTaint(array('footer.php',false)) => addTaint(__(array('Footer',false))),deregisterTaint(array('header.php',false)) => addTaint(__(array('Header',false))),deregisterTaint(array('sidebar.php',false)) => addTaint(__(array('Sidebar',false))),deregisterTaint(array('archive.php',false)) => addTaint(__(array('Archives',false))),deregisterTaint(array('category.php',false)) => addTaint(__(array('Category Template',false))),deregisterTaint(array('page.php',false)) => addTaint(__(array('Page Template',false))),deregisterTaint(array('search.php',false)) => addTaint(__(array('Search Results',false))),deregisterTaint(array('searchform.php',false)) => addTaint(__(array('Search Form',false))),deregisterTaint(array('single.php',false)) => addTaint(__(array('Single Post',false))),deregisterTaint(array('404.php',false)) => addTaint(__(array('404 Template',false))),deregisterTaint(array('link.php',false)) => addTaint(__(array('Links Template',false))),deregisterTaint(array('functions.php',false)) => addTaint(__(array('Theme Functions',false))),deregisterTaint(array('attachment.php',false)) => addTaint(__(array('Attachment Template',false))),deregisterTaint(array('image.php',false)) => addTaint(__(array('Image Attachment Template',false))),deregisterTaint(array('video.php',false)) => addTaint(__(array('Video Attachment Template',false))),deregisterTaint(array('audio.php',false)) => addTaint(__(array('Audio Attachment Template',false))),deregisterTaint(array('application.php',false)) => addTaint(__(array('Application Attachment Template',false))),deregisterTaint(array('my-hacks.php',false)) => addTaint(__(array('my-hacks.php (legacy hacks support)',false))),deregisterTaint(array('.htaccess',false)) => addTaint(__(array('.htaccess (for rewrite rules )',false))),deregisterTaint(array('wp-layout.css',false)) => addTaint(__(array('Stylesheet',false))),deregisterTaint(array('wp-comments.php',false)) => addTaint(__(array('Comments Template',false))),deregisterTaint(array('wp-comments-popup.php',false)) => addTaint(__(array('Popup Comments Template',false)))),false);
function get_file_description ( $file ) {
global $wp_file_descriptions;
if ( ((isset($wp_file_descriptions[0][deAspis(Aspis_basename($file))]) && Aspis_isset( $wp_file_descriptions [0][deAspis(Aspis_basename( $file))]))))
 {return attachAspis($wp_file_descriptions,deAspis(Aspis_basename($file)));
}elseif ( (file_exists((deconcat1(WP_CONTENT_DIR,$file))) && is_file((deconcat1(WP_CONTENT_DIR,$file)))))
 {$template_data = Aspis_implode(array('',false),Aspis_file(concat1(WP_CONTENT_DIR,$file)));
if ( deAspis(Aspis_preg_match(array('|Template Name:(.*)$|mi',false),$template_data,$name)))
 return concat2(_cleanup_header_comment(attachAspis($name,(1))),' Page Template');
}return Aspis_basename($file);
 }
function get_home_path (  ) {
$home = get_option(array('home',false));
$siteurl = get_option(array('siteurl',false));
if ( (($home[0] != ('')) && ($home[0] != $siteurl[0])))
 {$wp_path_rel_to_home = Aspis_str_replace($home,array('',false),$siteurl);
$pos = attAspis(strpos(deAspis($_SERVER[0]["SCRIPT_FILENAME"]),deAspisRC($wp_path_rel_to_home)));
$home_path = Aspis_substr($_SERVER[0]["SCRIPT_FILENAME"],array(0,false),$pos);
$home_path = trailingslashit($home_path);
}else 
{{$home_path = array(ABSPATH,false);
}}return $home_path;
 }
function get_real_file_to_edit ( $file ) {
if ( ((('index.php') == $file[0]) || (('.htaccess') == $file[0])))
 {$real_file = concat(get_home_path(),$file);
}else 
{{$real_file = concat1(WP_CONTENT_DIR,$file);
}}return $real_file;
 }
function list_files ( $folder = array('',false),$levels = array(100,false) ) {
if ( ((empty($folder) || Aspis_empty( $folder))))
 return array(false,false);
if ( (denot_boolean($levels)))
 return array(false,false);
$files = array(array(),false);
if ( deAspis($dir = @attAspis(opendir($folder[0]))))
 {while ( (deAspis(($file = attAspis(readdir($dir[0])))) !== false) )
{if ( deAspis(Aspis_in_array($file,array(array(array('.',false),array('..',false)),false))))
 continue ;
if ( is_dir((deconcat(concat2($folder,'/'),$file))))
 {$files2 = list_files(concat(concat2($folder,'/'),$file),array($levels[0] - (1),false));
if ( $files2[0])
 $files = Aspis_array_merge($files,$files2);
else 
{arrayAssignAdd($files[0][],addTaint(concat2(concat(concat2($folder,'/'),$file),'/')));
}}else 
{{arrayAssignAdd($files[0][],addTaint(concat(concat2($folder,'/'),$file)));
}}}}@closedir($dir[0]);
return $files;
 }
function get_temp_dir (  ) {
if ( defined(('WP_TEMP_DIR')))
 return trailingslashit(array(WP_TEMP_DIR,false));
$temp = concat12(WP_CONTENT_DIR,'/');
if ( (is_dir($temp[0]) && is_writable($temp[0])))
 return $temp;
if ( function_exists(('sys_get_temp_dir')))
 return trailingslashit(array(sys_get_temp_dir(),false));
return array('/tmp/',false);
 }
function wp_tempnam ( $filename = array('',false),$dir = array('',false) ) {
if ( ((empty($dir) || Aspis_empty( $dir))))
 $dir = get_temp_dir();
$filename = Aspis_basename($filename);
if ( ((empty($filename) || Aspis_empty( $filename))))
 $filename = attAspis(time());
$filename = Aspis_preg_replace(array('|\..*$|',false),array('.tmp',false),$filename);
$filename = concat($dir,wp_unique_filename($dir,$filename));
touch($filename[0]);
return $filename;
 }
function validate_file_to_edit ( $file,$allowed_files = array('',false) ) {
$code = validate_file($file,$allowed_files);
if ( (denot_boolean($code)))
 return $file;
switch ( $code[0] ) {
case (1):wp_die(__(array('Sorry, can&#8217;t edit files with &#8220;..&#8221; in the name. If you are trying to edit a file in your WordPress home directory, you can just type the name of the file in.',false)));
case (3):wp_die(__(array('Sorry, that file cannot be edited.',false)));
 }
 }
function wp_handle_upload ( &$file,$overrides = array(false,false),$time = array(null,false) ) {
if ( (!(function_exists(('wp_handle_upload_error')))))
 {function wp_handle_upload_error ( &$file,$message ) {
return array(array(deregisterTaint(array('error',false)) => addTaint($message)),false);
 }
}$file = apply_filters(array('wp_handle_upload_prefilter',false),$file);
$upload_error_handler = array('wp_handle_upload_error',false);
if ( ((((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))) && (!(is_numeric(deAspisRC($file[0]['error']))))) && deAspis($file[0]['error'])))
 return AspisDynamicCall($upload_error_handler,$file,$file[0]['error']);
$unique_filename_callback = array(null,false);
$action = array('wp_handle_upload',false);
$upload_error_strings = array(array(array(false,false),__(array("The uploaded file exceeds the <code>upload_max_filesize</code> directive in <code>php.ini</code>.",false)),__(array("The uploaded file exceeds the <em>MAX_FILE_SIZE</em> directive that was specified in the HTML form.",false)),__(array("The uploaded file was only partially uploaded.",false)),__(array("No file was uploaded.",false)),array('',false),__(array("Missing a temporary folder.",false)),__(array("Failed to write file to disk.",false)),__(array("File upload stopped by extension.",false))),false);
$test_form = array(true,false);
$test_size = array(true,false);
$test_type = array(true,false);
$mimes = array(false,false);
if ( is_array($overrides[0]))
 extract(($overrides[0]),EXTR_OVERWRITE);
if ( ($test_form[0] && ((!((isset($_POST[0][('action')]) && Aspis_isset( $_POST [0][('action')])))) || (deAspis($_POST[0]['action']) != $action[0]))))
 return AspisDynamicCall($upload_error_handler,$file,__(array('Invalid form submission.',false)));
if ( (deAspis($file[0]['error']) > (0)))
 return AspisDynamicCall($upload_error_handler,$file,attachAspis($upload_error_strings,deAspis($file[0]['error'])));
if ( ($test_size[0] && (!(deAspis($file[0]['size']) > (0)))))
 return AspisDynamicCall($upload_error_handler,$file,__(array('File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.',false)));
if ( (denot_boolean(@attAspis(is_uploaded_file(deAspis($file[0]['tmp_name']))))))
 return AspisDynamicCall($upload_error_handler,$file,__(array('Specified file failed upload test.',false)));
if ( $test_type[0])
 {$wp_filetype = wp_check_filetype($file[0]['name'],$mimes);
extract(($wp_filetype[0]));
if ( (((denot_boolean($type)) || (denot_boolean($ext))) && (denot_boolean(current_user_can(array('unfiltered_upload',false))))))
 return AspisDynamicCall($upload_error_handler,$file,__(array('File type does not meet security guidelines. Try another.',false)));
if ( (denot_boolean($ext)))
 $ext = Aspis_ltrim(attAspis(strrchr(deAspis($file[0]['name']),('.'))),array('.',false));
if ( (denot_boolean($type)))
 $type = $file[0]['type'];
}else 
{{$type = array('',false);
}}if ( (!(deAspis(($uploads = wp_upload_dir($time))) && (false === deAspis($uploads[0]['error'])))))
 return AspisDynamicCall($upload_error_handler,$file,$uploads[0]['error']);
$filename = wp_unique_filename($uploads[0]['path'],$file[0]['name'],$unique_filename_callback);
$new_file = concat($uploads[0]['path'],concat1("/",$filename));
if ( (false === deAspis(@attAspis(move_uploaded_file(deAspis($file[0]['tmp_name']),$new_file[0])))))
 {return AspisDynamicCall($upload_error_handler,$file,Aspis_sprintf(__(array('The uploaded file could not be moved to %s.',false)),$uploads[0]['path']));
}$stat = Aspis_stat(Aspis_dirname($new_file));
$perms = array(deAspis($stat[0]['mode']) & (0000666),false);
@attAspis(chmod($new_file[0],$perms[0]));
$url = concat($uploads[0]['url'],concat1("/",$filename));
return apply_filters(array('wp_handle_upload',false),array(array(deregisterTaint(array('file',false)) => addTaint($new_file),deregisterTaint(array('url',false)) => addTaint($url),deregisterTaint(array('type',false)) => addTaint($type)),false));
 }
function wp_handle_sideload ( &$file,$overrides = array(false,false) ) {
if ( (!(function_exists(('wp_handle_upload_error')))))
 {function wp_handle_upload_error ( &$file,$message ) {
return array(array(deregisterTaint(array('error',false)) => addTaint($message)),false);
 }
}$upload_error_handler = array('wp_handle_upload_error',false);
$unique_filename_callback = array(null,false);
$action = array('wp_handle_sideload',false);
$upload_error_strings = array(array(array(false,false),__(array("The uploaded file exceeds the <code>upload_max_filesize</code> directive in <code>php.ini</code>.",false)),__(array("The uploaded file exceeds the <em>MAX_FILE_SIZE</em> directive that was specified in the HTML form.",false)),__(array("The uploaded file was only partially uploaded.",false)),__(array("No file was uploaded.",false)),array('',false),__(array("Missing a temporary folder.",false)),__(array("Failed to write file to disk.",false)),__(array("File upload stopped by extension.",false))),false);
$test_form = array(true,false);
$test_size = array(true,false);
$test_type = array(true,false);
$mimes = array(false,false);
if ( is_array($overrides[0]))
 extract(($overrides[0]),EXTR_OVERWRITE);
if ( ($test_form[0] && ((!((isset($_POST[0][('action')]) && Aspis_isset( $_POST [0][('action')])))) || (deAspis($_POST[0]['action']) != $action[0]))))
 return AspisDynamicCall($upload_error_handler,$file,__(array('Invalid form submission.',false)));
if ( (deAspis($file[0]['error']) > (0)))
 return AspisDynamicCall($upload_error_handler,$file,attachAspis($upload_error_strings,deAspis($file[0]['error'])));
if ( ($test_size[0] && (!(filesize(deAspis($file[0]['tmp_name'])) > (0)))))
 return AspisDynamicCall($upload_error_handler,$file,__(array('File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini.',false)));
if ( (denot_boolean(@attAspis(is_file(deAspis($file[0]['tmp_name']))))))
 return AspisDynamicCall($upload_error_handler,$file,__(array('Specified file does not exist.',false)));
if ( $test_type[0])
 {$wp_filetype = wp_check_filetype($file[0]['name'],$mimes);
extract(($wp_filetype[0]));
if ( (((denot_boolean($type)) || (denot_boolean($ext))) && (denot_boolean(current_user_can(array('unfiltered_upload',false))))))
 return AspisDynamicCall($upload_error_handler,$file,__(array('File type does not meet security guidelines. Try another.',false)));
if ( (denot_boolean($ext)))
 $ext = Aspis_ltrim(attAspis(strrchr(deAspis($file[0]['name']),('.'))),array('.',false));
if ( (denot_boolean($type)))
 $type = $file[0]['type'];
}if ( (!(deAspis(($uploads = wp_upload_dir())) && (false === deAspis($uploads[0]['error'])))))
 return AspisDynamicCall($upload_error_handler,$file,$uploads[0]['error']);
$filename = wp_unique_filename($uploads[0]['path'],$file[0]['name'],$unique_filename_callback);
$filename = Aspis_str_replace(array('?',false),array('-',false),$filename);
$filename = Aspis_str_replace(array('&',false),array('-',false),$filename);
$new_file = concat($uploads[0]['path'],concat1("/",$filename));
if ( (false === deAspis(@attAspis(rename(deAspis($file[0]['tmp_name']),$new_file[0])))))
 {return AspisDynamicCall($upload_error_handler,$file,Aspis_sprintf(__(array('The uploaded file could not be moved to %s.',false)),$uploads[0]['path']));
}$stat = Aspis_stat(Aspis_dirname($new_file));
$perms = array(deAspis($stat[0]['mode']) & (0000666),false);
@attAspis(chmod($new_file[0],$perms[0]));
$url = concat($uploads[0]['url'],concat1("/",$filename));
$return = apply_filters(array('wp_handle_upload',false),array(array(deregisterTaint(array('file',false)) => addTaint($new_file),deregisterTaint(array('url',false)) => addTaint($url),deregisterTaint(array('type',false)) => addTaint($type)),false));
return $return;
 }
function download_url ( $url ) {
if ( (denot_boolean($url)))
 return array(new WP_Error(array('http_no_url',false),__(array('Invalid URL Provided',false))),false);
$tmpfname = wp_tempnam($url);
if ( (denot_boolean($tmpfname)))
 return array(new WP_Error(array('http_no_file',false),__(array('Could not create Temporary file',false))),false);
$handle = @attAspis(fopen($tmpfname[0],('wb')));
if ( (denot_boolean($handle)))
 return array(new WP_Error(array('http_no_file',false),__(array('Could not create Temporary file',false))),false);
$response = wp_remote_get($url,array(array('timeout' => array(300,false,false)),false));
if ( deAspis(is_wp_error($response)))
 {fclose($handle[0]);
unlink($tmpfname[0]);
return $response;
}if ( (deAspis($response[0][('response')][0]['code']) != ('200')))
 {fclose($handle[0]);
unlink($tmpfname[0]);
return array(new WP_Error(array('http_404',false),Aspis_trim($response[0][('response')][0]['message'])),false);
}fwrite($handle[0],deAspis($response[0]['body']));
fclose($handle[0]);
return $tmpfname;
 }
function unzip_file ( $file,$to ) {
global $wp_filesystem;
if ( ((denot_boolean($wp_filesystem)) || (!(is_object($wp_filesystem[0])))))
 return array(new WP_Error(array('fs_unavailable',false),__(array('Could not access filesystem.',false))),false);
@array(ini_set('memory_limit','256M'),false);
$fs = &$wp_filesystem;
require_once (deconcat12(ABSPATH,'wp-admin/includes/class-pclzip.php'));
$archive = array(new PclZip($file),false);
if ( (false == deAspis(($archive_files = $archive[0]->extract(array(PCLZIP_OPT_EXTRACT_AS_STRING,false))))))
 return array(new WP_Error(array('incompatible_archive',false),__(array('Incompatible archive',false)),$archive[0]->errorInfo(array(true,false))),false);
if ( ((0) == count($archive_files[0])))
 return array(new WP_Error(array('empty_archive',false),__(array('Empty archive',false))),false);
$path = Aspis_explode(array('/',false),untrailingslashit($to));
for ( $i = attAspis(count($path[0])) ; ($i[0] > (0)) ; postdecr($i) )
{$tmppath = Aspis_implode(array('/',false),Aspis_array_slice($path,array(0,false),$i));
if ( deAspis($fs[0]->is_dir($tmppath)))
 {for ( $i = array($i[0] + (1),false) ; ($i[0] <= count($path[0])) ; postincr($i) )
{$tmppath = Aspis_implode(array('/',false),Aspis_array_slice($path,array(0,false),$i));
if ( (denot_boolean($fs[0]->mkdir($tmppath,array(FS_CHMOD_DIR,false)))))
 return array(new WP_Error(array('mkdir_failed',false),__(array('Could not create directory',false)),$tmppath),false);
}break ;
}}$to = trailingslashit($to);
foreach ( $archive_files[0] as $file  )
{$path = deAspis($file[0]['folder']) ? $file[0]['filename'] : Aspis_dirname($file[0]['filename']);
$path = Aspis_explode(array('/',false),$path);
for ( $i = attAspis(count($path[0])) ; ($i[0] >= (0)) ; postdecr($i) )
{if ( ((empty($path[0][$i[0]]) || Aspis_empty( $path [0][$i[0]]))))
 continue ;
$tmppath = concat($to,Aspis_implode(array('/',false),Aspis_array_slice($path,array(0,false),$i)));
if ( deAspis($fs[0]->is_dir($tmppath)))
 {for ( $i = array($i[0] + (1),false) ; ($i[0] <= count($path[0])) ; postincr($i) )
{$tmppath = concat($to,Aspis_implode(array('/',false),Aspis_array_slice($path,array(0,false),$i)));
if ( ((denot_boolean($fs[0]->is_dir($tmppath))) && (denot_boolean($fs[0]->mkdir($tmppath,array(FS_CHMOD_DIR,false))))))
 return array(new WP_Error(array('mkdir_failed',false),__(array('Could not create directory',false)),$tmppath),false);
}break ;
}}if ( (denot_boolean($file[0]['folder'])))
 {if ( (denot_boolean($fs[0]->put_contents(concat($to,$file[0]['filename']),$file[0]['content']))))
 return array(new WP_Error(array('copy_failed',false),__(array('Could not copy file',false)),concat($to,$file[0]['filename'])),false);
$fs[0]->chmod(concat($to,$file[0]['filename']),array(FS_CHMOD_FILE,false));
}}return array(true,false);
 }
function copy_dir ( $from,$to ) {
global $wp_filesystem;
$dirlist = $wp_filesystem[0]->dirlist($from);
$from = trailingslashit($from);
$to = trailingslashit($to);
foreach ( deAspis(array_cast($dirlist)) as $filename =>$fileinfo )
{restoreTaint($filename,$fileinfo);
{if ( (('f') == deAspis($fileinfo[0]['type'])))
 {if ( (denot_boolean($wp_filesystem[0]->copy(concat($from,$filename),concat($to,$filename),array(true,false)))))
 {$wp_filesystem[0]->chmod(concat($to,$filename),array(0644,false));
if ( (denot_boolean($wp_filesystem[0]->copy(concat($from,$filename),concat($to,$filename),array(true,false)))))
 return array(new WP_Error(array('copy_failed',false),__(array('Could not copy file',false)),concat($to,$filename)),false);
}$wp_filesystem[0]->chmod(concat($to,$filename),array(FS_CHMOD_FILE,false));
}elseif ( (('d') == deAspis($fileinfo[0]['type'])))
 {if ( (denot_boolean($wp_filesystem[0]->is_dir(concat($to,$filename)))))
 {if ( (denot_boolean($wp_filesystem[0]->mkdir(concat($to,$filename),array(FS_CHMOD_DIR,false)))))
 return array(new WP_Error(array('mkdir_failed',false),__(array('Could not create directory',false)),concat($to,$filename)),false);
}$result = copy_dir(concat($from,$filename),concat($to,$filename));
if ( deAspis(is_wp_error($result)))
 return $result;
}}}return array(true,false);
 }
function WP_Filesystem ( $args = array(false,false),$context = array(false,false) ) {
global $wp_filesystem;
require_once (deconcat12(ABSPATH,'wp-admin/includes/class-wp-filesystem-base.php'));
$method = get_filesystem_method($args,$context);
if ( (denot_boolean($method)))
 return array(false,false);
if ( (!(class_exists((deconcat1("WP_Filesystem_",$method))))))
 {$abstraction_file = apply_filters(array('filesystem_method_file',false),concat2(concat(concat12(ABSPATH,'wp-admin/includes/class-wp-filesystem-'),$method),'.php'),$method);
if ( (!(file_exists($abstraction_file[0]))))
 return ;
require_once deAspis(($abstraction_file));
}$method = concat1("WP_Filesystem_",$method);
$wp_filesystem = array(new $method[0]($args),false);
if ( (!(defined(('FS_CONNECT_TIMEOUT')))))
 define(('FS_CONNECT_TIMEOUT'),30);
if ( (!(defined(('FS_TIMEOUT')))))
 define(('FS_TIMEOUT'),30);
if ( (deAspis(is_wp_error($wp_filesystem[0]->errors)) && deAspis($wp_filesystem[0]->errors[0]->get_error_code())))
 return array(false,false);
if ( (denot_boolean($wp_filesystem[0]->connect())))
 return array(false,false);
if ( (!(defined(('FS_CHMOD_DIR')))))
 define(('FS_CHMOD_DIR'),0755);
if ( (!(defined(('FS_CHMOD_FILE')))))
 define(('FS_CHMOD_FILE'),0644);
return array(true,false);
 }
function get_filesystem_method ( $args = array(array(),false),$context = array(false,false) ) {
$method = defined(('FS_METHOD')) ? array(FS_METHOD,false) : array(false,false);
if ( (((denot_boolean($method)) && function_exists(('getmyuid'))) && function_exists(('fileowner'))))
 {if ( (denot_boolean($context)))
 $context = array(WP_CONTENT_DIR,false);
$context = trailingslashit($context);
$temp_file_name = concat(concat2($context,'temp-write-test-'),attAspis(time()));
$temp_handle = @attAspis(fopen($temp_file_name[0],('w')));
if ( $temp_handle[0])
 {if ( ((getmyuid()) == deAspis(@attAspis(fileowner($temp_file_name[0])))))
 $method = array('direct',false);
@attAspis(fclose($temp_handle[0]));
@attAspis(unlink($temp_file_name[0]));
}}if ( (((((denot_boolean($method)) && ((isset($args[0][('connection_type')]) && Aspis_isset( $args [0][('connection_type')])))) && (('ssh') == deAspis($args[0]['connection_type']))) && (extension_loaded('ssh2'))) && function_exists(('stream_get_contents'))))
 $method = array('ssh2',false);
if ( ((denot_boolean($method)) && (extension_loaded('ftp'))))
 $method = array('ftpext',false);
if ( ((denot_boolean($method)) && ((extension_loaded('sockets')) || function_exists(('fsockopen')))))
 $method = array('ftpsockets',false);
return apply_filters(array('filesystem_method',false),$method,$args);
 }
function request_filesystem_credentials ( $form_post,$type = array('',false),$error = array(false,false),$context = array(false,false) ) {
$req_cred = apply_filters(array('request_filesystem_credentials',false),array('',false),$form_post,$type,$error,$context);
if ( (('') !== $req_cred[0]))
 return $req_cred;
if ( ((empty($type) || Aspis_empty( $type))))
 $type = get_filesystem_method(array(array(),false),$context);
if ( (('direct') == $type[0]))
 return array(true,false);
$credentials = get_option(array('ftp_credentials',false),array(array('hostname' => array('',false,false),'username' => array('',false,false)),false));
arrayAssign($credentials[0],deAspis(registerTaint(array('hostname',false))),addTaint(defined(('FTP_HOST')) ? array(FTP_HOST,false) : ((!((empty($_POST[0][('hostname')]) || Aspis_empty( $_POST [0][('hostname')])))) ? Aspis_stripslashes($_POST[0]['hostname']) : $credentials[0]['hostname'])));
arrayAssign($credentials[0],deAspis(registerTaint(array('username',false))),addTaint(defined(('FTP_USER')) ? array(FTP_USER,false) : ((!((empty($_POST[0][('username')]) || Aspis_empty( $_POST [0][('username')])))) ? Aspis_stripslashes($_POST[0]['username']) : $credentials[0]['username'])));
arrayAssign($credentials[0],deAspis(registerTaint(array('password',false))),addTaint(defined(('FTP_PASS')) ? array(FTP_PASS,false) : ((!((empty($_POST[0][('password')]) || Aspis_empty( $_POST [0][('password')])))) ? Aspis_stripslashes($_POST[0]['password']) : array('',false))));
arrayAssign($credentials[0],deAspis(registerTaint(array('public_key',false))),addTaint(defined(('FTP_PUBKEY')) ? array(FTP_PUBKEY,false) : ((!((empty($_POST[0][('public_key')]) || Aspis_empty( $_POST [0][('public_key')])))) ? Aspis_stripslashes($_POST[0]['public_key']) : array('',false))));
arrayAssign($credentials[0],deAspis(registerTaint(array('private_key',false))),addTaint(defined(('FTP_PRIKEY')) ? array(FTP_PRIKEY,false) : ((!((empty($_POST[0][('private_key')]) || Aspis_empty( $_POST [0][('private_key')])))) ? Aspis_stripslashes($_POST[0]['private_key']) : array('',false))));
arrayAssign($credentials[0],deAspis(registerTaint(array('hostname',false))),addTaint(Aspis_preg_replace(array('|\w+://|',false),array('',false),$credentials[0]['hostname'])));
if ( strpos(deAspis($credentials[0]['hostname']),':'))
 {list($credentials[0][('hostname')],$credentials[0][('port')]) = deAspisList(Aspis_explode(array(':',false),$credentials[0]['hostname'],array(2,false)),array());
if ( (!(is_numeric(deAspisRC($credentials[0]['port'])))))
 unset($credentials[0][('port')]);
}else 
{{unset($credentials[0][('port')]);
}}if ( ((defined(('FTP_SSH')) && FTP_SSH) || (defined(('FS_METHOD')) && (('ssh') == FS_METHOD))))
 arrayAssign($credentials[0],deAspis(registerTaint(array('connection_type',false))),addTaint(array('ssh',false)));
else 
{if ( ((defined(('FTP_SSL')) && FTP_SSL) && (('ftpext') == $type[0])))
 arrayAssign($credentials[0],deAspis(registerTaint(array('connection_type',false))),addTaint(array('ftps',false)));
else 
{if ( (!((empty($_POST[0][('connection_type')]) || Aspis_empty( $_POST [0][('connection_type')])))))
 arrayAssign($credentials[0],deAspis(registerTaint(array('connection_type',false))),addTaint(Aspis_stripslashes($_POST[0]['connection_type'])));
else 
{if ( (!((isset($credentials[0][('connection_type')]) && Aspis_isset( $credentials [0][('connection_type')])))))
 arrayAssign($credentials[0],deAspis(registerTaint(array('connection_type',false))),addTaint(array('ftp',false)));
}}}if ( ((denot_boolean($error)) && ((((!((empty($credentials[0][('password')]) || Aspis_empty( $credentials [0][('password')])))) && (!((empty($credentials[0][('username')]) || Aspis_empty( $credentials [0][('username')]))))) && (!((empty($credentials[0][('hostname')]) || Aspis_empty( $credentials [0][('hostname')]))))) || (((('ssh') == deAspis($credentials[0]['connection_type'])) && (!((empty($credentials[0][('public_key')]) || Aspis_empty( $credentials [0][('public_key')]))))) && (!((empty($credentials[0][('private_key')]) || Aspis_empty( $credentials [0][('private_key')]))))))))
 {$stored_credentials = $credentials;
if ( (!((empty($stored_credentials[0][('port')]) || Aspis_empty( $stored_credentials [0][('port')])))))
 arrayAssign($stored_credentials[0],deAspis(registerTaint(array('hostname',false))),addTaint(concat($stored_credentials[0]['hostname'],concat1(':',$stored_credentials[0]['port']))));
unset($stored_credentials[0][('password')],$stored_credentials[0][('port')],$stored_credentials[0][('private_key')],$stored_credentials[0][('public_key')]);
update_option(array('ftp_credentials',false),$stored_credentials);
return $credentials;
}$hostname = array('',false);
$username = array('',false);
$password = array('',false);
$connection_type = array('',false);
if ( (!((empty($credentials) || Aspis_empty( $credentials)))))
 extract(($credentials[0]),EXTR_OVERWRITE);
if ( $error[0])
 {$error_string = __(array('<strong>Error:</strong> There was an error connecting to the server, Please verify the settings are correct.',false));
if ( deAspis(is_wp_error($error)))
 $error_string = $error[0]->get_error_message();
echo AspisCheckPrint(concat2(concat1('<div id="message" class="error"><p>',$error_string),'</p></div>'));
}$types = array(array(),false);
if ( (((extension_loaded('ftp')) || (extension_loaded('sockets'))) || function_exists(('fsockopen'))))
 arrayAssign($types[0],deAspis(registerTaint(array('ftp',false))),addTaint(__(array('FTP',false))));
if ( (extension_loaded('ftp')))
 arrayAssign($types[0],deAspis(registerTaint(array('ftps',false))),addTaint(__(array('FTPS (SSL)',false))));
if ( ((extension_loaded('ssh2')) && function_exists(('stream_get_contents'))))
 arrayAssign($types[0],deAspis(registerTaint(array('ssh',false))),addTaint(__(array('SSH2',false))));
$types = apply_filters(array('fs_ftp_connection_types',false),$types,$credentials,$type,$error,$context);
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
<form action="<?php echo AspisCheckPrint($form_post);
?>" method="post">
<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e(array('Connection Information',false));
?></h2>
<p><?php _e(array('To perform the requested action, connection information is required.',false));
?></p>

<table class="form-table">
<tr valign="top">
<th scope="row"><label for="hostname"><?php _e(array('Hostname',false));
?></label></th>
<td><input name="hostname" type="text" id="hostname" value="<?php echo AspisCheckPrint(esc_attr($hostname));
if ( (!((empty($port) || Aspis_empty( $port)))))
 echo AspisCheckPrint(concat1(":",$port));
;
?>"<?php if ( defined(('FTP_HOST')))
 echo AspisCheckPrint(array(' disabled="disabled"',false));
?> size="40" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="username"><?php _e(array('Username',false));
?></label></th>
<td><input name="username" type="text" id="username" value="<?php echo AspisCheckPrint(esc_attr($username));
?>"<?php if ( defined(('FTP_USER')))
 echo AspisCheckPrint(array(' disabled="disabled"',false));
?> size="40" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="password"><?php _e(array('Password',false));
?></label></th>
<td><input name="password" type="password" id="password" value="<?php if ( defined(('FTP_PASS')))
 echo AspisCheckPrint(array('*****',false));
;
?>"<?php if ( defined(('FTP_PASS')))
 echo AspisCheckPrint(array(' disabled="disabled"',false));
?> size="40" /></td>
</tr>

<?php if ( ((isset($types[0][('ssh')]) && Aspis_isset( $types [0][('ssh')]))))
 {;
?>
<tr id="ssh_keys" valign="top" style="<?php if ( (('ssh') != $connection_type[0]))
 echo AspisCheckPrint(array('display:none',false));
?>">
<th scope="row"><?php _e(array('Authentication Keys',false));
?>
<div class="key-labels textright">
<label for="public_key"><?php _e(array('Public Key:',false));
?></label ><br />
<label for="private_key"><?php _e(array('Private Key:',false));
?></label>
</div></th>
<td><br /><input name="public_key" type="text" id="public_key" value="<?php echo AspisCheckPrint(esc_attr($public_key));
?>"<?php if ( defined(('FTP_PUBKEY')))
 echo AspisCheckPrint(array(' disabled="disabled"',false));
?> size="40" /><br /><input name="private_key" type="text" id="private_key" value="<?php echo AspisCheckPrint(esc_attr($private_key));
?>"<?php if ( defined(('FTP_PRIKEY')))
 echo AspisCheckPrint(array(' disabled="disabled"',false));
?> size="40" />
<div><?php _e(array('Enter the location on the server where the keys are located. If a passphrase is needed, enter that in the password field above.',false));
?></div></td>
</tr>
<?php };
?>

<tr valign="top">
<th scope="row"><?php _e(array('Connection Type',false));
?></th>
<td>
<fieldset><legend class="screen-reader-text"><span><?php _e(array('Connection Type',false));
?></span></legend>
<?php $disabled = ((defined(('FTP_SSL')) && FTP_SSL) || (defined(('FTP_SSH')) && FTP_SSH)) ? array(' disabled="disabled"',false) : array('',false);
foreach ( $types[0] as $name =>$text )
{restoreTaint($name,$text);
{;
?>
	<label for="<?php echo AspisCheckPrint(esc_attr($name));
?>">
		<input type="radio" name="connection_type" id="<?php echo AspisCheckPrint(esc_attr($name));
?>" value="<?php echo AspisCheckPrint(esc_attr($name));
?>" <?php checked($name,$connection_type);
echo AspisCheckPrint($disabled);
;
?>/>
		<?php echo AspisCheckPrint($text);
?>
	</label>
	<?php }};
?>
</fieldset>
</td>
</tr>
</table>

<?php if ( ((isset($_POST[0][('version')]) && Aspis_isset( $_POST [0][('version')]))))
 {;
?>
<input type="hidden" name="version" value="<?php echo AspisCheckPrint(esc_attr(Aspis_stripslashes($_POST[0]['version'])));
?>" />
<?php };
?>
<?php if ( ((isset($_POST[0][('locale')]) && Aspis_isset( $_POST [0][('locale')]))))
 {;
?>
<input type="hidden" name="locale" value="<?php echo AspisCheckPrint(esc_attr(Aspis_stripslashes($_POST[0]['locale'])));
?>" />
<?php };
?>
<p class="submit">
<input id="upgrade" name="upgrade" type="submit" class="button" value="<?php esc_attr_e(array('Proceed',false));
;
?>" />
</p>
</div>
</form>
<?php return array(false,false);
 }
;
?>
<?php 