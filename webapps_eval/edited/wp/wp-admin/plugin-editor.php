<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('edit_plugins',false)))))
 wp_die(concat2(concat1('<p>',__(array('You do not have sufficient permissions to edit plugins for this blog.',false))),'</p>'));
$title = __(array("Edit Plugins",false));
$parent_file = array('plugins.php',false);
wp_reset_vars(array(array(array('action',false),array('redirect',false),array('profile',false),array('error',false),array('warning',false),array('a',false),array('file',false),array('plugin',false)),false));
wp_admin_css(array('theme-editor',false));
$plugins = get_plugins();
if ( ((isset($_REQUEST[0][('file')]) && Aspis_isset( $_REQUEST [0][('file')]))))
 $plugin = Aspis_stripslashes($_REQUEST[0]['file']);
if ( ((empty($plugin) || Aspis_empty( $plugin))))
 {$plugin = attAspisRC(array_keys(deAspisRC($plugins)));
$plugin = attachAspis($plugin,(0));
}$plugin_files = get_plugin_files($plugin);
if ( ((empty($file) || Aspis_empty( $file))))
 $file = attachAspis($plugin_files,(0));
else 
{$file = Aspis_stripslashes($file);
}$file = validate_file_to_edit($file,$plugin_files);
$real_file = concat(concat12(WP_PLUGIN_DIR,'/'),$file);
$scrollto = ((isset($_REQUEST[0][('scrollto')]) && Aspis_isset( $_REQUEST [0][('scrollto')]))) ? int_cast($_REQUEST[0]['scrollto']) : array(0,false);
switch ( $action[0] ) {
case ('update'):check_admin_referer(concat1('edit-plugin_',$file));
$newcontent = Aspis_stripslashes($_POST[0]['newcontent']);
if ( (is_writeable(deAspisRC($real_file))))
 {$f = attAspis(fopen($real_file[0],('w+')));
fwrite($f[0],$newcontent[0]);
fclose($f[0]);
if ( (deAspis(is_plugin_active($file)) || ((isset($_POST[0][('phperror')]) && Aspis_isset( $_POST [0][('phperror')])))))
 {if ( deAspis(is_plugin_active($file)))
 deactivate_plugins($file,array(true,false));
wp_redirect(add_query_arg(array('_wpnonce',false),wp_create_nonce(concat1('edit-plugin-test_',$file)),concat(concat2(concat1("plugin-editor.php?file=",$file),"&liveupdate=1&scrollto="),$scrollto)));
Aspis_exit();
}wp_redirect(concat(concat2(concat1("plugin-editor.php?file=",$file),"&a=te&scrollto="),$scrollto));
}else 
{{wp_redirect(concat(concat2(concat1("plugin-editor.php?file=",$file),"&scrollto="),$scrollto));
}}Aspis_exit();
break ;
default :if ( ((isset($_GET[0][('liveupdate')]) && Aspis_isset( $_GET [0][('liveupdate')]))))
 {check_admin_referer(concat1('edit-plugin-test_',$file));
$error = validate_plugin($file);
if ( deAspis(is_wp_error($error)))
 wp_die($error);
if ( (denot_boolean(is_plugin_active($file))))
 activate_plugin($file,concat2(concat1("plugin-editor.php?file=",$file),"&phperror=1"));
wp_redirect(concat(concat2(concat1("plugin-editor.php?file=",$file),"&a=te&scrollto="),$scrollto));
Aspis_exit();
}$editable_extensions = array(array(array('php',false),array('txt',false),array('text',false),array('js',false),array('css',false),array('html',false),array('htm',false),array('xml',false),array('inc',false),array('include',false)),false);
$editable_extensions = array_cast(apply_filters(array('editable_extensions',false),$editable_extensions));
if ( (!(is_file($real_file[0]))))
 {wp_die(Aspis_sprintf(array('<p>%s</p>',false),__(array('No such file exists! Double check the name and try again.',false))));
}else 
{{if ( deAspis(Aspis_preg_match(array('/\.([^.]+)$/',false),$real_file,$matches)))
 {$ext = Aspis_strtolower(attachAspis($matches,(1)));
if ( (denot_boolean(Aspis_in_array($ext,$editable_extensions))))
 wp_die(Aspis_sprintf(array('<p>%s</p>',false),__(array('Files of this type are not editable.',false))));
}}}require_once ('admin-header.php');
update_recently_edited(concat(concat12(WP_PLUGIN_DIR,'/'),$file));
$content = attAspis(file_get_contents($real_file[0]));
if ( (('.php') == deAspis(Aspis_substr($real_file,attAspis(strrpos($real_file[0],('.')))))))
 {$functions = wp_doc_link_parse($content);
if ( (!((empty($functions) || Aspis_empty( $functions)))))
 {$docs_select = array('<select name="docs-list" id="docs-list">',false);
$docs_select = concat($docs_select,concat2(concat1('<option value="">',__(array('Function Name...',false))),'</option>'));
foreach ( $functions[0] as $function  )
{$docs_select = concat($docs_select,concat2(concat(concat2(concat1('<option value="',esc_attr($function)),'">'),Aspis_htmlspecialchars($function)),'()</option>'));
}$docs_select = concat2($docs_select,'</select>');
}}$content = Aspis_htmlspecialchars($content);
$codepress_lang = codepress_get_lang($real_file);
;
?>
<?php if ( ((isset($_GET[0][('a')]) && Aspis_isset( $_GET [0][('a')]))))
 {;
?>
 <div id="message" class="updated fade"><p><?php _e(array('File edited successfully.',false));
?></p></div>
<?php }elseif ( ((isset($_GET[0][('phperror')]) && Aspis_isset( $_GET [0][('phperror')]))))
 {;
?>
 <div id="message" class="updated fade"><p><?php _e(array('This plugin has been deactivated because your changes resulted in a <strong>fatal error</strong>.',false));
?></p>
	<?php if ( deAspis(wp_verify_nonce($_GET[0]['_error_nonce'],concat1('plugin-activation-error_',$file))))
 {;
?>
	<iframe style="border:0" width="100%" height="70px" src="<?php bloginfo(array('wpurl',false));
;
?>/wp-admin/plugins.php?action=error_scrape&amp;plugin=<?php echo AspisCheckPrint(esc_attr($file));
;
?>&amp;_wpnonce=<?php echo AspisCheckPrint(esc_attr($_GET[0]['_error_nonce']));
;
?>"></iframe>
	<?php };
?>
</div>
<?php };
?>
<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<div class="fileedit-sub">
<div class="alignleft">
<big><?php if ( deAspis(is_plugin_active($plugin)))
 {if ( (is_writeable(deAspisRC($real_file))))
 echo AspisCheckPrint(Aspis_sprintf(__(array('Editing <strong>%s</strong> (active)',false)),$file));
else 
{echo AspisCheckPrint(Aspis_sprintf(__(array('Browsing <strong>%s</strong> (active)',false)),$file));
}}else 
{{if ( (is_writeable(deAspisRC($real_file))))
 echo AspisCheckPrint(Aspis_sprintf(__(array('Editing <strong>%s</strong> (inactive)',false)),$file));
else 
{echo AspisCheckPrint(Aspis_sprintf(__(array('Browsing <strong>%s</strong> (inactive)',false)),$file));
}}};
?></big>
</div>
<div class="alignright">
	<form action="plugin-editor.php" method="post">
		<strong><label for="plugin"><?php _e(array('Select plugin to edit:',false));
;
?> </label></strong>
		<select name="plugin" id="plugin">
<?php foreach ( $plugins[0] as $plugin_key =>$a_plugin )
{restoreTaint($plugin_key,$a_plugin);
{$plugin_name = $a_plugin[0]['Name'];
if ( ($plugin_key[0] == $plugin[0]))
 $selected = array(" selected='selected'",false);
else 
{$selected = array('',false);
}$plugin_name = esc_attr($plugin_name);
$plugin_key = esc_attr($plugin_key);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1("\n\t<option value=\"",$plugin_key),"\" "),$selected),">"),$plugin_name),"</option>"));
}};
?>
		</select>
		<input type="submit" name="Submit" value="<?php esc_attr_e(array('Select',false));
?>" class="button" />
	</form>
</div>
<br class="clear" />
</div>

<div id="templateside">
	<h3><?php _e(array('Plugin Files',false));
;
?></h3>

	<ul>
<?php foreach ( $plugin_files[0] as $plugin_file  )
{if ( deAspis(Aspis_preg_match(array('/\.([^.]+)$/',false),$plugin_file,$matches)))
 {$ext = Aspis_strtolower(attachAspis($matches,(1)));
if ( (denot_boolean(Aspis_in_array($ext,$editable_extensions))))
 continue ;
}else 
{{continue ;
}};
?>
		<li<?php echo AspisCheckPrint(($file[0] == $plugin_file[0]) ? array(' class="highlight"',false) : array('',false));
;
?>><a href="plugin-editor.php?file=<?php echo AspisCheckPrint($plugin_file);
;
?>&amp;plugin=<?php echo AspisCheckPrint($plugin);
;
?>"><?php echo AspisCheckPrint($plugin_file);
?></a></li>
<?php };
?>
	</ul>
</div>
<form name="template" id="template" action="plugin-editor.php" method="post">
	<?php wp_nonce_field(concat1('edit-plugin_',$file));
?>
		<div><textarea cols="70" rows="25" name="newcontent" id="newcontent" tabindex="1" class="codepress <?php echo AspisCheckPrint($codepress_lang);
?>"><?php echo AspisCheckPrint($content);
?></textarea>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="file" value="<?php echo AspisCheckPrint(esc_attr($file));
?>" />
		<input type="hidden" name="plugin" value="<?php echo AspisCheckPrint(esc_attr($plugin));
?>" />
		<input type="hidden" name="scrollto" id="scrollto" value="<?php echo AspisCheckPrint($scrollto);
;
?>" />
		</div>
		<?php if ( (!((empty($docs_select) || Aspis_empty( $docs_select)))))
 {;
?>
		<div id="documentation"><label for="docs-list"><?php _e(array('Documentation:',false));
?></label> <?php echo AspisCheckPrint($docs_select);
?> <input type="button" class="button" value="<?php esc_attr_e(array('Lookup',false));
?> " onclick="if ( '' != jQuery('#docs-list').val() ) { window.open( 'http://api.wordpress.org/core/handbook/1.0/?function=' + escape( jQuery( '#docs-list' ).val() ) + '&amp;locale=<?php echo AspisCheckPrint(Aspis_urlencode(get_locale()));
?>&amp;version=<?php echo AspisCheckPrint(Aspis_urlencode($wp_version));
?>&amp;redirect=true'); }" /></div>
		<?php };
?>
<?php if ( (is_writeable(deAspisRC($real_file))))
 {;
?>
	<?php if ( deAspis(Aspis_in_array($file,array_cast(get_option(array('active_plugins',false))))))
 {;
?>
		<p><?php _e(array('<strong>Warning:</strong> Making changes to active plugins is not recommended.  If your changes cause a fatal error, the plugin will be automatically deactivated.',false));
;
?></p>
	<?php };
?>
	<p class="submit">
	<?php if ( ((isset($_GET[0][('phperror')]) && Aspis_isset( $_GET [0][('phperror')]))))
 echo AspisCheckPrint(concat2(concat1("<input type='hidden' name='phperror' value='1' /><input type='submit' name='submit' class='button-primary' value='",esc_attr__(array('Update File and Attempt to Reactivate',false))),"' tabindex='2' />"));
else 
{echo AspisCheckPrint(concat2(concat1("<input type='submit' name='submit' class='button-primary' value='",esc_attr__(array('Update File',false))),"' tabindex='2' />"));
};
?>
	</p>
<?php }else 
{;
?>
	<p><em><?php _e(array('You need to make this file writable before you can save your changes. See <a href="http://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information.',false));
;
?></em></p>
<?php };
?>
</form>
<br class="clear" />
</div>
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function($){
	$('#template').submit(function(){ $('#scrollto').val( $('#newcontent').scrollTop() ); });
	$('#newcontent').scrollTop( $('#scrollto').val() );
});
/* ]]> */
</script>
<?php break ;
 }
include ("admin-footer.php");
