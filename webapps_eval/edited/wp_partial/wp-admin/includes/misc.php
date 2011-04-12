<?php require_once('AspisMain.php'); ?><?php
function got_mod_rewrite (  ) {
$got_rewrite = apache_mod_loaded('mod_rewrite',true);
{$AspisRetTemp = apply_filters('got_rewrite',$got_rewrite);
return $AspisRetTemp;
} }
function extract_from_markers ( $filename,$marker ) {
$result = array();
if ( !file_exists($filename))
 {{$AspisRetTemp = $result;
return $AspisRetTemp;
}}if ( $markerdata = explode("\n",implode('',file($filename))))
 ;
{$state = false;
foreach ( $markerdata as $markerline  )
{if ( strpos($markerline,'# END ' . $marker) !== false)
 $state = false;
if ( $state)
 $result[] = $markerline;
if ( strpos($markerline,'# BEGIN ' . $marker) !== false)
 $state = true;
}}{$AspisRetTemp = $result;
return $AspisRetTemp;
} }
function insert_with_markers ( $filename,$marker,$insertion ) {
if ( !file_exists($filename) || is_writeable($filename))
 {if ( !file_exists($filename))
 {$markerdata = '';
}else 
{{$markerdata = explode("\n",implode('',file($filename)));
}}if ( !$f = @fopen($filename,'w'))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$foundit = false;
if ( $markerdata)
 {$state = true;
foreach ( $markerdata as $n =>$markerline )
{if ( strpos($markerline,'# BEGIN ' . $marker) !== false)
 $state = false;
if ( $state)
 {if ( $n + 1 < count($markerdata))
 fwrite($f,"{$markerline}\n");
else 
{fwrite($f,"{$markerline}");
}}if ( strpos($markerline,'# END ' . $marker) !== false)
 {fwrite($f,"# BEGIN {$marker}\n");
if ( is_array($insertion))
 foreach ( $insertion as $insertline  )
fwrite($f,"{$insertline}\n");
fwrite($f,"# END {$marker}\n");
$state = true;
$foundit = true;
}}}if ( !$foundit)
 {fwrite($f,"\n# BEGIN {$marker}\n");
foreach ( $insertion as $insertline  )
fwrite($f,"{$insertline}\n");
fwrite($f,"# END {$marker}\n");
}fclose($f);
{$AspisRetTemp = true;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = false;
return $AspisRetTemp;
}}} }
function save_mod_rewrite_rules (  ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$home_path = get_home_path();
$htaccess_file = $home_path . '.htaccess';
if ( (!file_exists($htaccess_file) && is_writable($home_path) && $wp_rewrite->using_mod_rewrite_permalinks()) || is_writable($htaccess_file))
 {if ( got_mod_rewrite())
 {$rules = explode("\n",$wp_rewrite->mod_rewrite_rules());
{$AspisRetTemp = insert_with_markers($htaccess_file,'WordPress',$rules);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function iis7_save_url_rewrite_rules (  ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$home_path = get_home_path();
$web_config_file = $home_path . 'web.config';
if ( (!file_exists($web_config_file) && win_is_writable($home_path) && $wp_rewrite->using_mod_rewrite_permalinks()) || win_is_writable($web_config_file))
 {if ( iis7_supports_permalinks())
 {$rule = $wp_rewrite->iis7_url_rewrite_rules(false,'','');
if ( !empty($rule))
 {{$AspisRetTemp = iis7_add_rewrite_rule($web_config_file,$rule);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = iis7_delete_rewrite_rule($web_config_file);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}}}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function update_recently_edited ( $file ) {
$oldfiles = (array)get_option('recently_edited');
if ( $oldfiles)
 {$oldfiles = array_reverse($oldfiles);
$oldfiles[] = $file;
$oldfiles = array_reverse($oldfiles);
$oldfiles = array_unique($oldfiles);
if ( 5 < count($oldfiles))
 array_pop($oldfiles);
}else 
{{$oldfiles[] = $file;
}}update_option('recently_edited',$oldfiles);
 }
function update_home_siteurl ( $old_value,$value ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}if ( defined("WP_INSTALLING"))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return ;
}$wp_rewrite->flush_rules();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
add_action('update_option_home','update_home_siteurl',10,2);
add_action('update_option_siteurl','update_home_siteurl',10,2);
function url_shorten ( $url ) {
$short_url = str_replace('http://','',stripslashes($url));
$short_url = str_replace('www.','',$short_url);
if ( '/' == substr($short_url,-1))
 $short_url = substr($short_url,0,-1);
if ( strlen($short_url) > 35)
 $short_url = substr($short_url,0,32) . '...';
{$AspisRetTemp = $short_url;
return $AspisRetTemp;
} }
function wp_reset_vars ( $vars ) {
for ( $i = 0 ; $i < count($vars) ; $i += 1 )
{$var = $vars[$i];
{global $$var;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $$var,"\$",$AspisChangesCache);
}if ( !isset($$var))
 {if ( (empty($_POST[0]["$var"]) || Aspis_empty($_POST[0]["$var"])))
 {if ( (empty($_GET[0]["$var"]) || Aspis_empty($_GET[0]["$var"])))
 $$var = '';
else 
{$$var = deAspisWarningRC($_GET[0]["$var"]);
}}else 
{{$$var = deAspisWarningRC($_POST[0]["$var"]);
}}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$",$AspisChangesCache);
 }
function show_message ( $message ) {
if ( is_wp_error($message))
 {if ( $message->get_error_data())
 $message = $message->get_error_message() . ': ' . $message->get_error_data();
else 
{$message = $message->get_error_message();
}}echo "<p>$message</p>\n";
 }
function wp_doc_link_parse ( $content ) {
if ( !is_string($content) || empty($content))
 {$AspisRetTemp = array();
return $AspisRetTemp;
}if ( !function_exists('token_get_all'))
 {$AspisRetTemp = array();
return $AspisRetTemp;
}$tokens = token_get_all($content);
$functions = array();
$ignore_functions = array();
for ( $t = 0,$count = count($tokens) ; $t < $count ; $t++ )
{if ( !is_array($tokens[$t]))
 continue ;
if ( T_STRING == $tokens[$t][0] && ('(' == $tokens[$t + 1] || '(' == $tokens[$t + 2]))
 {if ( (isset($tokens[$t - 2][1]) && in_array($tokens[$t - 2][1],array('function','class'))) || (isset($tokens[$t - 2][0]) && T_OBJECT_OPERATOR == $tokens[$t - 1][0]))
 {$ignore_functions[] = $tokens[$t][1];
}$functions[] = $tokens[$t][1];
}}$functions = array_unique($functions);
sort($functions);
$ignore_functions = apply_filters('documentation_ignore_functions',$ignore_functions);
$ignore_functions = array_unique($ignore_functions);
$out = array();
foreach ( $functions as $function  )
{if ( in_array($function,$ignore_functions))
 continue ;
$out[] = $function;
}{$AspisRetTemp = $out;
return $AspisRetTemp;
} }
function codepress_get_lang ( $filename ) {
$codepress_supported_langs = apply_filters('codepress_supported_langs',array('.css' => 'css','.js' => 'javascript','.php' => 'php','.html' => 'html','.htm' => 'html','.txt' => 'text'));
$extension = substr($filename,strrpos($filename,'.'));
if ( $extension && array_key_exists($extension,$codepress_supported_langs))
 {$AspisRetTemp = $codepress_supported_langs[$extension];
return $AspisRetTemp;
}{$AspisRetTemp = 'generic';
return $AspisRetTemp;
} }
function codepress_footer_js (  ) {
;
?><script type="text/javascript">
/* <![CDATA[ */
var codepress_path = '<?php echo includes_url('js/codepress/');
;
?>';
jQuery('#template').submit(function(){
	if (jQuery('#newcontent_cp').length)
		jQuery('#newcontent_cp').val(newcontent.getCode()).removeAttr('disabled');
});
jQuery('#codepress-on').hide();
jQuery('#codepress-off').show();
/* ]]> */
</script>
<?php  }
function use_codepress (  ) {
if ( (isset($_GET[0]['codepress']) && Aspis_isset($_GET[0]['codepress'])))
 {$on = 'on' == deAspisWarningRC($_GET[0]['codepress']) ? 'on' : 'off';
set_user_setting('codepress',$on);
}else 
{{$on = get_user_setting('codepress','on');
}}if ( 'on' == $on)
 {add_action('admin_print_footer_scripts','codepress_footer_js');
{$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function set_screen_options (  ) {
if ( (isset($_POST[0]['wp_screen_options']) && Aspis_isset($_POST[0]['wp_screen_options'])) && is_array(deAspisWarningRC($_POST[0]['wp_screen_options'])))
 {check_admin_referer('screen-options-nonce','screenoptionnonce');
if ( !$user = wp_get_current_user())
 {return ;
}$option = deAspisWarningRC($_POST[0]['wp_screen_options'][0]['option']);
$value = deAspisWarningRC($_POST[0]['wp_screen_options'][0]['value']);
if ( !preg_match('/^[a-z_-]+$/',$option))
 {return ;
}$option = str_replace('-','_',$option);
switch ( $option ) {
case 'edit_per_page':case 'edit_pages_per_page':case 'edit_comments_per_page':case 'upload_per_page':case 'categories_per_page':case 'edit_tags_per_page':case 'plugins_per_page':$value = (int)$value;
if ( $value < 1 || $value > 999)
 {return ;
}break ;
default :$value = apply_filters('set-screen-option',false,$option,$value);
if ( false === $value)
 {return ;
}break ;
 }
update_usermeta($user->ID,$option,$value);
wp_redirect(remove_query_arg(array('pagenum','apage','paged'),wp_get_referer()));
exit();
} }
function wp_menu_unfold (  ) {
if ( (isset($_GET[0]['unfoldmenu']) && Aspis_isset($_GET[0]['unfoldmenu'])))
 {delete_user_setting('mfold');
wp_redirect(remove_query_arg('unfoldmenu',stripslashes(deAspisWarningRC($_SERVER[0]['REQUEST_URI']))));
exit();
} }
function iis7_supports_permalinks (  ) {
{global $is_iis7;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $is_iis7,"\$is_iis7",$AspisChangesCache);
}$supports_permalinks = false;
if ( $is_iis7)
 {$supports_permalinks = class_exists('DOMDocument') && (isset($_SERVER[0]['IIS_UrlRewriteModule']) && Aspis_isset($_SERVER[0]['IIS_UrlRewriteModule'])) && (php_sapi_name() == 'cgi-fcgi');
}{$AspisRetTemp = apply_filters('iis7_supports_permalinks',$supports_permalinks);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_iis7",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_iis7",$AspisChangesCache);
 }
function iis7_rewrite_rule_exists ( $filename ) {
if ( !file_exists($filename))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !class_exists('DOMDocument'))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$doc = new DOMDocument();
if ( $doc->load($filename) === false)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$xpath = new DOMXPath($doc);
$rules = $xpath->query('/configuration/system.webServer/rewrite/rules/rule[@name=\'wordpress\']');
if ( $rules->length == 0)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function iis7_delete_rewrite_rule ( $filename ) {
if ( !file_exists($filename))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}if ( !class_exists('DOMDocument'))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
if ( $doc->load($filename) === false)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$xpath = new DOMXPath($doc);
$rules = $xpath->query('/configuration/system.webServer/rewrite/rules/rule[@name=\'wordpress\']');
if ( $rules->length > 0)
 {$child = $rules->item(0);
$parent = $child->parentNode;
$parent->removeChild($child);
$doc->formatOutput = true;
saveDomDocument($doc,$filename);
}{$AspisRetTemp = true;
return $AspisRetTemp;
} }
function iis7_add_rewrite_rule ( $filename,$rewrite_rule ) {
if ( !class_exists('DOMDocument'))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !file_exists($filename))
 {$fp = fopen($filename,'w');
fwrite($fp,'<configuration/>');
fclose($fp);
}$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
if ( $doc->load($filename) === false)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$xpath = new DOMXPath($doc);
$wordpress_rules = $xpath->query('/configuration/system.webServer/rewrite/rules/rule[@name=\'wordpress\']');
if ( $wordpress_rules->length > 0)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}$xmlnodes = $xpath->query('/configuration/system.webServer/rewrite/rules');
if ( $xmlnodes->length > 0)
 {$rules_node = $xmlnodes->item(0);
}else 
{{$rules_node = $doc->createElement('rules');
$xmlnodes = $xpath->query('/configuration/system.webServer/rewrite');
if ( $xmlnodes->length > 0)
 {$rewrite_node = $xmlnodes->item(0);
$rewrite_node->appendChild($rules_node);
}else 
{{$rewrite_node = $doc->createElement('rewrite');
$rewrite_node->appendChild($rules_node);
$xmlnodes = $xpath->query('/configuration/system.webServer');
if ( $xmlnodes->length > 0)
 {$system_webServer_node = $xmlnodes->item(0);
$system_webServer_node->appendChild($rewrite_node);
}else 
{{$system_webServer_node = $doc->createElement('system.webServer');
$system_webServer_node->appendChild($rewrite_node);
$xmlnodes = $xpath->query('/configuration');
if ( $xmlnodes->length > 0)
 {$config_node = $xmlnodes->item(0);
$config_node->appendChild($system_webServer_node);
}else 
{{$config_node = $doc->createElement('configuration');
$doc->appendChild($config_node);
$config_node->appendChild($system_webServer_node);
}}}}}}}}$rule_fragment = $doc->createDocumentFragment();
$rule_fragment->appendXML($rewrite_rule);
$rules_node->appendChild($rule_fragment);
$doc->encoding = "UTF-8";
$doc->formatOutput = true;
saveDomDocument($doc,$filename);
{$AspisRetTemp = true;
return $AspisRetTemp;
} }
function saveDomDocument ( $doc,$filename ) {
$config = $doc->saveXML();
$config = preg_replace("/([^\r])\n/","$1\r\n",$config);
$fp = fopen($filename,'w');
fwrite($fp,$config);
fclose($fp);
 }
function win_is_writable ( $path ) {
if ( $path[strlen($path) - 1] == '/')
 {$AspisRetTemp = win_is_writable($path . uniqid(mt_rand()) . '.tmp');
return $AspisRetTemp;
}else 
{if ( is_dir($path))
 {$AspisRetTemp = win_is_writable($path . '/' . uniqid(mt_rand()) . '.tmp');
return $AspisRetTemp;
}}$rm = file_exists($path);
$f = @fopen($path,'a');
if ( $f === false)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}fclose($f);
if ( !$rm)
 unlink($path);
{$AspisRetTemp = true;
return $AspisRetTemp;
} }
;
?>
<?php 