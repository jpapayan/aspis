<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('edit_themes',false)))))
 wp_die(concat2(concat1('<p>',__(array('You do not have sufficient permissions to edit templates for this blog.',false))),'</p>'));
$title = __(array("Edit Themes",false));
$parent_file = array('themes.php',false);
wp_reset_vars(array(array(array('action',false),array('redirect',false),array('profile',false),array('error',false),array('warning',false),array('a',false),array('file',false),array('theme',false),array('dir',false)),false));
wp_admin_css(array('theme-editor',false));
$themes = get_themes();
if ( ((empty($theme) || Aspis_empty( $theme))))
 {$theme = get_current_theme();
}else 
{{$theme = Aspis_stripslashes($theme);
}}if ( (!((isset($themes[0][$theme[0]]) && Aspis_isset( $themes [0][$theme[0]])))))
 wp_die(__(array('The requested theme does not exist.',false)));
$allowed_files = Aspis_array_merge($themes[0][$theme[0]][0]['Stylesheet Files'],$themes[0][$theme[0]][0]['Template Files']);
if ( ((empty($file) || Aspis_empty( $file))))
 {$file = attachAspis($allowed_files,(0));
}else 
{{$file = Aspis_stripslashes($file);
if ( (('theme') == $dir[0]))
 {$file = concat(Aspis_dirname(Aspis_dirname($themes[0][$theme[0]][0]['Template Dir'])),$file);
}else 
{if ( (('style') == $dir[0]))
 {$file = concat(Aspis_dirname(Aspis_dirname($themes[0][$theme[0]][0]['Stylesheet Dir'])),$file);
}}}}validate_file_to_edit($file,$allowed_files);
$scrollto = ((isset($_REQUEST[0][('scrollto')]) && Aspis_isset( $_REQUEST [0][('scrollto')]))) ? int_cast($_REQUEST[0]['scrollto']) : array(0,false);
$file_show = Aspis_basename($file);
switch ( $action[0] ) {
case ('update'):check_admin_referer(concat(concat1('edit-theme_',$file),$theme));
$newcontent = Aspis_stripslashes($_POST[0]['newcontent']);
$theme = Aspis_urlencode($theme);
if ( (is_writeable(deAspisRC($file))))
 {$f = attAspis(fopen($file[0],('w+')));
if ( ($f[0] !== FALSE))
 {fwrite($f[0],$newcontent[0]);
fclose($f[0]);
$location = concat(concat2(concat(concat2(concat1("theme-editor.php?file=",$file),"&theme="),$theme),"&a=te&scrollto="),$scrollto);
}else 
{{$location = concat(concat2(concat(concat2(concat1("theme-editor.php?file=",$file),"&theme="),$theme),"&scrollto="),$scrollto);
}}}else 
{{$location = concat(concat2(concat(concat2(concat1("theme-editor.php?file=",$file),"&theme="),$theme),"&scrollto="),$scrollto);
}}$location = wp_kses_no_null($location);
$strip = array(array(array('%0d',false),array('%0a',false),array('%0D',false),array('%0A',false)),false);
$location = _deep_replace($strip,$location);
header((deconcat1("Location: ",$location)));
Aspis_exit();
break ;
default :require_once ('admin-header.php');
update_recently_edited($file);
if ( (!(is_file($file[0]))))
 $error = array(1,false);
if ( ((denot_boolean($error)) && (filesize($file[0]) > (0))))
 {$f = attAspis(fopen($file[0],('r')));
$content = attAspis(fread($f[0],filesize($file[0])));
if ( (('.php') == deAspis(Aspis_substr($file,attAspis(strrpos($file[0],('.')))))))
 {$functions = wp_doc_link_parse($content);
$docs_select = array('<select name="docs-list" id="docs-list">',false);
$docs_select = concat($docs_select,concat2(concat1('<option value="">',esc_attr__(array('Function Name...',false))),'</option>'));
foreach ( $functions[0] as $function  )
{$docs_select = concat($docs_select,concat2(concat(concat2(concat1('<option value="',esc_attr(Aspis_urlencode($function))),'">'),Aspis_htmlspecialchars($function)),'()</option>'));
}$docs_select = concat2($docs_select,'</select>');
}$content = Aspis_htmlspecialchars($content);
$codepress_lang = codepress_get_lang($file);
};
?>
<?php if ( ((isset($_GET[0][('a')]) && Aspis_isset( $_GET [0][('a')]))))
 {;
?>
 <div id="message" class="updated fade"><p><?php _e(array('File edited successfully.',false));
?></p></div>
<?php }$description = get_file_description($file);
$desc_header = ($description[0] != $file_show[0]) ? concat2(concat1("<strong>",$description),"</strong> (%s)") : array("%s",false);
;
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
<big><?php echo AspisCheckPrint(Aspis_sprintf($desc_header,$file_show));
;
?></big>
</div>
<div class="alignright">
	<form action="theme-editor.php" method="post">
		<strong><label for="theme"><?php _e(array('Select theme to edit:',false));
;
?> </label></strong>
		<select name="theme" id="theme">
<?php foreach ( $themes[0] as $a_theme  )
{$theme_name = $a_theme[0]['Name'];
if ( ($theme_name[0] == $theme[0]))
 $selected = array(" selected='selected'",false);
else 
{$selected = array('',false);
}$theme_name = esc_attr($theme_name);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1("\n\t<option value=\"",$theme_name),"\" "),$selected),">"),$theme_name),"</option>"));
};
?>
		</select>
		<input type="submit" name="Submit" value="<?php esc_attr_e(array('Select',false));
?>" class="button" />
	</form>
</div>
<br class="clear" />
</div>
	<div id="templateside">
	<h3><?php _e(array("Theme Files",false));
;
?></h3>

<?php if ( $allowed_files[0])
 {;
?>
	<h4><?php _e(array('Templates',false));
;
?></h4>
	<ul>
<?php $template_mapping = array(array(),false);
$template_dir = $themes[0][$theme[0]][0]['Template Dir'];
foreach ( deAspis($themes[0][$theme[0]][0]['Template Files']) as $template_file  )
{$description = Aspis_trim(get_file_description($template_file));
$template_show = Aspis_basename($template_file);
$filedesc = ($description[0] != $template_file[0]) ? concat2(concat(concat2($description," <span class='nonessential'>("),$template_show),")</span>") : $description;
$filedesc = ($template_file[0] == $file[0]) ? concat2(concat(concat2(concat1("<span class='highlight'>",$description)," <span class='nonessential'>("),$template_show),")</span></span>") : $filedesc;
if ( array_key_exists(deAspisRC($description),deAspisRC($template_mapping)))
 {if ( (false !== strpos($template_file[0],deAspisRC($template_dir))))
 {arrayAssign($template_mapping[0],deAspis(registerTaint($description)),addTaint(array(array(_get_template_edit_filename($template_file,$template_dir),$filedesc),false)));
}}else 
{{arrayAssign($template_mapping[0],deAspis(registerTaint($description)),addTaint(array(array(_get_template_edit_filename($template_file,$template_dir),$filedesc),false)));
}}}Aspis_ksort($template_mapping);
while ( deAspis(list($template_sorted_key,list($template_file,$filedesc)) = deAspisList(Aspis_each($template_mapping),array(1=>array()))) )
{;
?>
		<li><a href="theme-editor.php?file=<?php echo AspisCheckPrint($template_file);
;
?>&amp;theme=<?php echo AspisCheckPrint(Aspis_urlencode($theme));
?>&amp;dir=theme"><?php echo AspisCheckPrint($filedesc);
?></a></li>
<?php };
?>
	</ul>
	<h4><?php echo AspisCheckPrint(_x(array('Styles',false),array('Theme stylesheets in theme editor',false)));
;
?></h4>
	<ul>
<?php $template_mapping = array(array(),false);
$stylesheet_dir = $themes[0][$theme[0]][0]['Stylesheet Dir'];
foreach ( deAspis($themes[0][$theme[0]][0]['Stylesheet Files']) as $style_file  )
{$description = Aspis_trim(get_file_description($style_file));
$style_show = Aspis_basename($style_file);
$filedesc = ($description[0] != $style_file[0]) ? concat2(concat(concat2($description," <span class='nonessential'>("),$style_show),")</span>") : $description;
$filedesc = ($style_file[0] == $file[0]) ? concat2(concat(concat2(concat1("<span class='highlight'>",$description)," <span class='nonessential'>("),$style_show),")</span></span>") : $filedesc;
arrayAssign($template_mapping[0],deAspis(registerTaint($description)),addTaint(array(array(_get_template_edit_filename($style_file,$stylesheet_dir),$filedesc),false)));
}Aspis_ksort($template_mapping);
while ( deAspis(list($template_sorted_key,list($style_file,$filedesc)) = deAspisList(Aspis_each($template_mapping),array(1=>array()))) )
{;
?>
		<li><a href="theme-editor.php?file=<?php echo AspisCheckPrint($style_file);
;
?>&amp;theme=<?php echo AspisCheckPrint(Aspis_urlencode($theme));
?>&amp;dir=style"><?php echo AspisCheckPrint($filedesc);
?></a></li>
<?php };
?>
	</ul>
<?php };
?>
</div>
<?php if ( (denot_boolean($error)))
 {;
?>
	<form name="template" id="template" action="theme-editor.php" method="post">
	<?php wp_nonce_field(concat(concat1('edit-theme_',$file),$theme));
?>
		 <div><textarea cols="70" rows="25" name="newcontent" id="newcontent" tabindex="1" class="codepress <?php echo AspisCheckPrint($codepress_lang);
?>"><?php echo AspisCheckPrint($content);
?></textarea>
		 <input type="hidden" name="action" value="update" />
		 <input type="hidden" name="file" value="<?php echo AspisCheckPrint(esc_attr($file));
?>" />
		 <input type="hidden" name="theme" value="<?php echo AspisCheckPrint(esc_attr($theme));
?>" />
		 <input type="hidden" name="scrollto" id="scrollto" value="<?php echo AspisCheckPrint($scrollto);
;
?>" />
		 </div>
	<?php if ( (((isset($functions) && Aspis_isset( $functions))) && count($functions[0])))
 {;
?>
		<div id="documentation">
		<label for="docs-list"><?php _e(array('Documentation:',false));
?></label>
		<?php echo AspisCheckPrint($docs_select);
;
?>
		<input type="button" class="button" value=" <?php esc_attr_e(array('Lookup',false));
;
?> " onclick="if ( '' != jQuery('#docs-list').val() ) { window.open( 'http://api.wordpress.org/core/handbook/1.0/?function=' + escape( jQuery( '#docs-list' ).val() ) + '&locale=<?php echo AspisCheckPrint(Aspis_urlencode(get_locale()));
?>&version=<?php echo AspisCheckPrint(Aspis_urlencode($wp_version));
?>&redirect=true'); }" />
		</div>
	<?php };
?>

		<div>
<?php if ( (is_writeable(deAspisRC($file))))
 {;
?>
			<p class="submit">
<?php echo AspisCheckPrint(concat2(concat1("<input type='submit' name='submit' class='button-primary' value='",esc_attr__(array('Update File',false))),"' tabindex='2' />"));
;
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
		</div>
	</form>
<?php }else 
{{echo AspisCheckPrint(concat2(concat1('<div class="error"><p>',__(array('Oops, no such file exists! Double check the name and try again, merci.',false))),'</p></div>'));
}};
?>
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
