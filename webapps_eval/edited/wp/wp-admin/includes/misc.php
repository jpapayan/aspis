<?php require_once('AspisMain.php'); ?><?php
function got_mod_rewrite (  ) {
$got_rewrite = apache_mod_loaded(array('mod_rewrite',false),array(true,false));
return apply_filters(array('got_rewrite',false),$got_rewrite);
 }
function extract_from_markers ( $filename,$marker ) {
$result = array(array(),false);
if ( (!(file_exists($filename[0]))))
 {return $result;
}if ( deAspis($markerdata = Aspis_explode(array("\n",false),Aspis_implode(array('',false),Aspis_file($filename)))))
 ;
{$state = array(false,false);
foreach ( $markerdata[0] as $markerline  )
{if ( (strpos($markerline[0],(deconcat1('# END ',$marker))) !== false))
 $state = array(false,false);
if ( $state[0])
 arrayAssignAdd($result[0][],addTaint($markerline));
if ( (strpos($markerline[0],(deconcat1('# BEGIN ',$marker))) !== false))
 $state = array(true,false);
}}return $result;
 }
function insert_with_markers ( $filename,$marker,$insertion ) {
if ( ((!(file_exists($filename[0]))) || (is_writeable(deAspisRC($filename)))))
 {if ( (!(file_exists($filename[0]))))
 {$markerdata = array('',false);
}else 
{{$markerdata = Aspis_explode(array("\n",false),Aspis_implode(array('',false),Aspis_file($filename)));
}}if ( (denot_boolean($f = @attAspis(fopen($filename[0],('w'))))))
 return array(false,false);
$foundit = array(false,false);
if ( $markerdata[0])
 {$state = array(true,false);
foreach ( $markerdata[0] as $n =>$markerline )
{restoreTaint($n,$markerline);
{if ( (strpos($markerline[0],(deconcat1('# BEGIN ',$marker))) !== false))
 $state = array(false,false);
if ( $state[0])
 {if ( (($n[0] + (1)) < count($markerdata[0])))
 fwrite($f[0],(deconcat2($markerline,"\n")));
else 
{fwrite($f[0],$markerline[0]);
}}if ( (strpos($markerline[0],(deconcat1('# END ',$marker))) !== false))
 {fwrite($f[0],(deconcat2(concat1("# BEGIN ",$marker),"\n")));
if ( is_array($insertion[0]))
 foreach ( $insertion[0] as $insertline  )
fwrite($f[0],(deconcat2($insertline,"\n")));
fwrite($f[0],(deconcat2(concat1("# END ",$marker),"\n")));
$state = array(true,false);
$foundit = array(true,false);
}}}}if ( (denot_boolean($foundit)))
 {fwrite($f[0],(deconcat2(concat1("\n# BEGIN ",$marker),"\n")));
foreach ( $insertion[0] as $insertline  )
fwrite($f[0],(deconcat2($insertline,"\n")));
fwrite($f[0],(deconcat2(concat1("# END ",$marker),"\n")));
}fclose($f[0]);
return array(true,false);
}else 
{{return array(false,false);
}} }
function save_mod_rewrite_rules (  ) {
global $wp_rewrite;
$home_path = get_home_path();
$htaccess_file = concat2($home_path,'.htaccess');
if ( ((((!(file_exists($htaccess_file[0]))) && is_writable($home_path[0])) && deAspis($wp_rewrite[0]->using_mod_rewrite_permalinks())) || is_writable($htaccess_file[0])))
 {if ( deAspis(got_mod_rewrite()))
 {$rules = Aspis_explode(array("\n",false),$wp_rewrite[0]->mod_rewrite_rules());
return insert_with_markers($htaccess_file,array('WordPress',false),$rules);
}}return array(false,false);
 }
function iis7_save_url_rewrite_rules (  ) {
global $wp_rewrite;
$home_path = get_home_path();
$web_config_file = concat2($home_path,'web.config');
if ( ((((!(file_exists($web_config_file[0]))) && deAspis(win_is_writable($home_path))) && deAspis($wp_rewrite[0]->using_mod_rewrite_permalinks())) || deAspis(win_is_writable($web_config_file))))
 {if ( deAspis(iis7_supports_permalinks()))
 {$rule = $wp_rewrite[0]->iis7_url_rewrite_rules(array(false,false),array('',false),array('',false));
if ( (!((empty($rule) || Aspis_empty( $rule)))))
 {return iis7_add_rewrite_rule($web_config_file,$rule);
}else 
{{return iis7_delete_rewrite_rule($web_config_file);
}}}}return array(false,false);
 }
function update_recently_edited ( $file ) {
$oldfiles = array_cast(get_option(array('recently_edited',false)));
if ( $oldfiles[0])
 {$oldfiles = Aspis_array_reverse($oldfiles);
arrayAssignAdd($oldfiles[0][],addTaint($file));
$oldfiles = Aspis_array_reverse($oldfiles);
$oldfiles = attAspisRC(array_unique(deAspisRC($oldfiles)));
if ( ((5) < count($oldfiles[0])))
 Aspis_array_pop($oldfiles);
}else 
{{arrayAssignAdd($oldfiles[0][],addTaint($file));
}}update_option(array('recently_edited',false),$oldfiles);
 }
function update_home_siteurl ( $old_value,$value ) {
global $wp_rewrite;
if ( defined(("WP_INSTALLING")))
 return ;
$wp_rewrite[0]->flush_rules();
 }
add_action(array('update_option_home',false),array('update_home_siteurl',false),array(10,false),array(2,false));
add_action(array('update_option_siteurl',false),array('update_home_siteurl',false),array(10,false),array(2,false));
function url_shorten ( $url ) {
$short_url = Aspis_str_replace(array('http://',false),array('',false),Aspis_stripslashes($url));
$short_url = Aspis_str_replace(array('www.',false),array('',false),$short_url);
if ( (('/') == deAspis(Aspis_substr($short_url,negate(array(1,false))))))
 $short_url = Aspis_substr($short_url,array(0,false),negate(array(1,false)));
if ( (strlen($short_url[0]) > (35)))
 $short_url = concat2(Aspis_substr($short_url,array(0,false),array(32,false)),'...');
return $short_url;
 }
function wp_reset_vars ( $vars ) {
for ( $i = array(0,false) ; ($i[0] < count($vars[0])) ; $i = array((1) + $i[0],false) )
{$var = attachAspis($vars,$i[0]);
global ${$var[0]};
if ( (!((isset(${$var[0]}) && Aspis_isset( ${$var[0]})))))
 {if ( ((empty($_POST[0][$var[0]]) || Aspis_empty( $_POST [0][ $var[0]]))))
 {if ( ((empty($_GET[0][$var[0]]) || Aspis_empty( $_GET [0][ $var[0]]))))
 ${$var[0]} = array('',false);
else 
{${$var[0]} = attachAspis($_GET,$var[0]);
}}else 
{{${$var[0]} = attachAspis($_POST,$var[0]);
}}}} }
function show_message ( $message ) {
if ( deAspis(is_wp_error($message)))
 {if ( deAspis($message[0]->get_error_data()))
 $message = concat(concat2($message[0]->get_error_message(),': '),$message[0]->get_error_data());
else 
{$message = $message[0]->get_error_message();
}}echo AspisCheckPrint(concat2(concat1("<p>",$message),"</p>\n"));
 }
function wp_doc_link_parse ( $content ) {
if ( ((!(is_string(deAspisRC($content)))) || ((empty($content) || Aspis_empty( $content)))))
 return array(array(),false);
if ( (!(function_exists(('token_get_all')))))
 return array(array(),false);
$tokens = array(token_get_all(deAspisRC($content)),false);
$functions = array(array(),false);
$ignore_functions = array(array(),false);
for ( $t = array(0,false),$count = attAspis(count($tokens[0])) ; ($t[0] < $count[0]) ; postincr($t) )
{if ( (!(is_array(deAspis(attachAspis($tokens,$t[0]))))))
 continue ;
if ( ((T_STRING == deAspis(attachAspis($tokens[0][$t[0]],(0)))) && ((('(') == deAspis(attachAspis($tokens,($t[0] + (1))))) || (('(') == deAspis(attachAspis($tokens,($t[0] + (2))))))))
 {if ( ((((isset($tokens[0][($t[0] - (2))][0][(1)]) && Aspis_isset( $tokens [0][($t[0] - (2))] [0][(1)]))) && deAspis(Aspis_in_array(attachAspis($tokens[0][($t[0] - (2))],(1)),array(array(array('function',false),array('class',false)),false)))) || (((isset($tokens[0][($t[0] - (2))][0][(0)]) && Aspis_isset( $tokens [0][($t[0] - (2))] [0][(0)]))) && (T_OBJECT_OPERATOR == deAspis(attachAspis($tokens[0][($t[0] - (1))],(0)))))))
 {arrayAssignAdd($ignore_functions[0][],addTaint(attachAspis($tokens[0][$t[0]],(1))));
}arrayAssignAdd($functions[0][],addTaint(attachAspis($tokens[0][$t[0]],(1))));
}}$functions = attAspisRC(array_unique(deAspisRC($functions)));
AspisInternalFunctionCall("sort",AspisPushRefParam($functions),array(0));
$ignore_functions = apply_filters(array('documentation_ignore_functions',false),$ignore_functions);
$ignore_functions = attAspisRC(array_unique(deAspisRC($ignore_functions)));
$out = array(array(),false);
foreach ( $functions[0] as $function  )
{if ( deAspis(Aspis_in_array($function,$ignore_functions)))
 continue ;
arrayAssignAdd($out[0][],addTaint($function));
}return $out;
 }
function codepress_get_lang ( $filename ) {
$codepress_supported_langs = apply_filters(array('codepress_supported_langs',false),array(array('.css' => array('css',false,false),'.js' => array('javascript',false,false),'.php' => array('php',false,false),'.html' => array('html',false,false),'.htm' => array('html',false,false),'.txt' => array('text',false,false)),false));
$extension = Aspis_substr($filename,attAspis(strrpos($filename[0],('.'))));
if ( ($extension[0] && array_key_exists(deAspisRC($extension),deAspisRC($codepress_supported_langs))))
 return attachAspis($codepress_supported_langs,$extension[0]);
return array('generic',false);
 }
function codepress_footer_js (  ) {
;
?><script type="text/javascript">
/* <![CDATA[ */
var codepress_path = '<?php echo AspisCheckPrint(includes_url(array('js/codepress/',false)));
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
if ( ((isset($_GET[0][('codepress')]) && Aspis_isset( $_GET [0][('codepress')]))))
 {$on = (('on') == deAspis($_GET[0]['codepress'])) ? array('on',false) : array('off',false);
set_user_setting(array('codepress',false),$on);
}else 
{{$on = get_user_setting(array('codepress',false),array('on',false));
}}if ( (('on') == $on[0]))
 {add_action(array('admin_print_footer_scripts',false),array('codepress_footer_js',false));
return array(true,false);
}return array(false,false);
 }
function set_screen_options (  ) {
if ( (((isset($_POST[0][('wp_screen_options')]) && Aspis_isset( $_POST [0][('wp_screen_options')]))) && is_array(deAspis($_POST[0]['wp_screen_options']))))
 {check_admin_referer(array('screen-options-nonce',false),array('screenoptionnonce',false));
if ( (denot_boolean($user = wp_get_current_user())))
 return ;
$option = $_POST[0][('wp_screen_options')][0]['option'];
$value = $_POST[0][('wp_screen_options')][0]['value'];
if ( (denot_boolean(Aspis_preg_match(array('/^[a-z_-]+$/',false),$option))))
 return ;
$option = Aspis_str_replace(array('-',false),array('_',false),$option);
switch ( $option[0] ) {
case ('edit_per_page'):case ('edit_pages_per_page'):case ('edit_comments_per_page'):case ('upload_per_page'):case ('categories_per_page'):case ('edit_tags_per_page'):case ('plugins_per_page'):$value = int_cast($value);
if ( (($value[0] < (1)) || ($value[0] > (999))))
 return ;
break ;
default :$value = apply_filters(array('set-screen-option',false),array(false,false),$option,$value);
if ( (false === $value[0]))
 return ;
break ;
 }
update_usermeta($user[0]->ID,$option,$value);
wp_redirect(remove_query_arg(array(array(array('pagenum',false),array('apage',false),array('paged',false)),false),wp_get_referer()));
Aspis_exit();
} }
function wp_menu_unfold (  ) {
if ( ((isset($_GET[0][('unfoldmenu')]) && Aspis_isset( $_GET [0][('unfoldmenu')]))))
 {delete_user_setting(array('mfold',false));
wp_redirect(remove_query_arg(array('unfoldmenu',false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
Aspis_exit();
} }
function iis7_supports_permalinks (  ) {
global $is_iis7;
$supports_permalinks = array(false,false);
if ( $is_iis7[0])
 {$supports_permalinks = array((class_exists(('DOMDocument')) && ((isset($_SERVER[0][('IIS_UrlRewriteModule')]) && Aspis_isset( $_SERVER [0][('IIS_UrlRewriteModule')])))) && ((php_sapi_name()) == ('cgi-fcgi')),false);
}return apply_filters(array('iis7_supports_permalinks',false),$supports_permalinks);
 }
function iis7_rewrite_rule_exists ( $filename ) {
if ( (!(file_exists($filename[0]))))
 return array(false,false);
if ( (!(class_exists(('DOMDocument')))))
 return array(false,false);
$doc = array(new DOMDocument(),false);
if ( (deAspis($doc[0]->load($filename)) === false))
 return array(false,false);
$xpath = array(new DOMXPath($doc),false);
$rules = $xpath[0]->query(array('/configuration/system.webServer/rewrite/rules/rule[@name=\'wordpress\']',false));
if ( ($rules[0]->length[0] == (0)))
 return array(false,false);
else 
{return array(true,false);
} }
function iis7_delete_rewrite_rule ( $filename ) {
if ( (!(file_exists($filename[0]))))
 return array(true,false);
if ( (!(class_exists(('DOMDocument')))))
 return array(false,false);
$doc = array(new DOMDocument(),false);
$doc[0]->preserveWhiteSpace = array(false,false);
if ( (deAspis($doc[0]->load($filename)) === false))
 return array(false,false);
$xpath = array(new DOMXPath($doc),false);
$rules = $xpath[0]->query(array('/configuration/system.webServer/rewrite/rules/rule[@name=\'wordpress\']',false));
if ( ($rules[0]->length[0] > (0)))
 {$child = $rules[0]->item(array(0,false));
$parent = $child[0]->parentNode;
$parent[0]->removeChild($child);
$doc[0]->formatOutput = array(true,false);
saveDomDocument($doc,$filename);
}return array(true,false);
 }
function iis7_add_rewrite_rule ( $filename,$rewrite_rule ) {
if ( (!(class_exists(('DOMDocument')))))
 return array(false,false);
if ( (!(file_exists($filename[0]))))
 {$fp = attAspis(fopen($filename[0],('w')));
fwrite($fp[0],('<configuration/>'));
fclose($fp[0]);
}$doc = array(new DOMDocument(),false);
$doc[0]->preserveWhiteSpace = array(false,false);
if ( (deAspis($doc[0]->load($filename)) === false))
 return array(false,false);
$xpath = array(new DOMXPath($doc),false);
$wordpress_rules = $xpath[0]->query(array('/configuration/system.webServer/rewrite/rules/rule[@name=\'wordpress\']',false));
if ( ($wordpress_rules[0]->length[0] > (0)))
 return array(true,false);
$xmlnodes = $xpath[0]->query(array('/configuration/system.webServer/rewrite/rules',false));
if ( ($xmlnodes[0]->length[0] > (0)))
 {$rules_node = $xmlnodes[0]->item(array(0,false));
}else 
{{$rules_node = $doc[0]->createElement(array('rules',false));
$xmlnodes = $xpath[0]->query(array('/configuration/system.webServer/rewrite',false));
if ( ($xmlnodes[0]->length[0] > (0)))
 {$rewrite_node = $xmlnodes[0]->item(array(0,false));
$rewrite_node[0]->appendChild($rules_node);
}else 
{{$rewrite_node = $doc[0]->createElement(array('rewrite',false));
$rewrite_node[0]->appendChild($rules_node);
$xmlnodes = $xpath[0]->query(array('/configuration/system.webServer',false));
if ( ($xmlnodes[0]->length[0] > (0)))
 {$system_webServer_node = $xmlnodes[0]->item(array(0,false));
$system_webServer_node[0]->appendChild($rewrite_node);
}else 
{{$system_webServer_node = $doc[0]->createElement(array('system.webServer',false));
$system_webServer_node[0]->appendChild($rewrite_node);
$xmlnodes = $xpath[0]->query(array('/configuration',false));
if ( ($xmlnodes[0]->length[0] > (0)))
 {$config_node = $xmlnodes[0]->item(array(0,false));
$config_node[0]->appendChild($system_webServer_node);
}else 
{{$config_node = $doc[0]->createElement(array('configuration',false));
$doc[0]->appendChild($config_node);
$config_node[0]->appendChild($system_webServer_node);
}}}}}}}}$rule_fragment = $doc[0]->createDocumentFragment();
$rule_fragment[0]->appendXML($rewrite_rule);
$rules_node[0]->appendChild($rule_fragment);
$doc[0]->encoding = array("UTF-8",false);
$doc[0]->formatOutput = array(true,false);
saveDomDocument($doc,$filename);
return array(true,false);
 }
function saveDomDocument ( $doc,$filename ) {
$config = $doc[0]->saveXML();
$config = Aspis_preg_replace(array("/([^\r])\n/",false),array("$1\r\n",false),$config);
$fp = attAspis(fopen($filename[0],('w')));
fwrite($fp[0],$config[0]);
fclose($fp[0]);
 }
function win_is_writable ( $path ) {
if ( (deAspis(attachAspis($path,(strlen($path[0]) - (1)))) == ('/')))
 return win_is_writable(concat2(concat($path,attAspis(uniqid(deAspisRC(attAspis(mt_rand()))))),'.tmp'));
else 
{if ( is_dir($path[0]))
 return win_is_writable(concat2(concat(concat2($path,'/'),attAspis(uniqid(deAspisRC(attAspis(mt_rand()))))),'.tmp'));
}$rm = attAspis(file_exists($path[0]));
$f = @attAspis(fopen($path[0],('a')));
if ( ($f[0] === false))
 return array(false,false);
fclose($f[0]);
if ( (denot_boolean($rm)))
 unlink($path[0]);
return array(true,false);
 }
;
?>
<?php 