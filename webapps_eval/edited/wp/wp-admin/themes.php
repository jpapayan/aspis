<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('switch_themes',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
if ( ((isset($_GET[0][('action')]) && Aspis_isset( $_GET [0][('action')]))))
 {if ( (('activate') == deAspis($_GET[0]['action'])))
 {check_admin_referer(concat1('switch-theme_',$_GET[0]['template']));
switch_theme($_GET[0]['template'],$_GET[0]['stylesheet']);
wp_redirect(array('themes.php?activated=true',false));
Aspis_exit();
}else 
{if ( (('delete') == deAspis($_GET[0]['action'])))
 {check_admin_referer(concat1('delete-theme_',$_GET[0]['template']));
if ( (denot_boolean(current_user_can(array('update_themes',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
delete_theme($_GET[0]['template']);
wp_redirect(array('themes.php?deleted=true',false));
Aspis_exit();
}}}$title = __(array('Manage Themes',false));
$parent_file = array('themes.php',false);
$help = concat2(concat1('<p>',__(array('Themes give your WordPress style. Once a theme is installed, you may preview it, activate it or deactivate it here.',false))),'</p>');
if ( deAspis(current_user_can(array('install_themes',false))))
 {$help = concat($help,concat2(concat1('<p>',Aspis_sprintf(__(array('You can find additional themes for your site by using the new <a href="%1$s">Theme Browser/Installer</a> functionality or by browsing the <a href="http://wordpress.org/extend/themes/">WordPress Theme Directory</a> directly and installing manually.  To install a theme <em>manually</em>, <a href="%2$s">upload its ZIP archive with the new uploader</a> or copy its folder via FTP into your <code>wp-content/themes</code> directory.',false)),array('theme-install.php',false),array('theme-install.php?tab=upload',false))),'</p>'));
$help = concat($help,concat2(concat1('<p>',__(array('Once a theme is uploaded, you should see it on this page.',false))),'</p>'));
}add_contextual_help(array('themes',false),$help);
add_thickbox();
wp_enqueue_script(array('theme-preview',false));
require_once ('admin-header.php');
;
?>

<?php if ( (denot_boolean(validate_current_theme())))
 {;
?>
<div id="message1" class="updated fade"><p><?php _e(array('The active theme is broken.  Reverting to the default theme.',false));
;
?></p></div>
<?php }elseif ( ((isset($_GET[0][('activated')]) && Aspis_isset( $_GET [0][('activated')]))))
 {if ( (((isset($wp_registered_sidebars) && Aspis_isset( $wp_registered_sidebars))) && count(deAspis(array_cast($wp_registered_sidebars)))))
 {;
?>
<div id="message2" class="updated fade"><p><?php printf(deAspis(__(array('New theme activated. This theme supports widgets, please visit the <a href="%s">widgets settings page</a> to configure them.',false))),deAspisRC(admin_url(array('widgets.php',false))));
;
?></p></div><?php }else 
{{;
?>
<div id="message2" class="updated fade"><p><?php printf(deAspis(__(array('New theme activated. <a href="%s">Visit site</a>',false))),(deconcat2(get_bloginfo(array('url',false)),'/')));
;
?></p></div><?php }}}elseif ( ((isset($_GET[0][('deleted')]) && Aspis_isset( $_GET [0][('deleted')]))))
 {;
?>
<div id="message3" class="updated fade"><p><?php _e(array('Theme deleted.',false));
?></p></div>
<?php };
?>

<?php $themes = get_themes();
$ct = current_theme_info();
unset($themes[0][$ct[0]->name[0]]);
AspisInternalFunctionCall("uksort",AspisPushRefParam($themes),AspisInternalCallback(array("strnatcasecmp",false)),array(0));
$theme_total = attAspis(count($themes[0]));
$per_page = array(15,false);
if ( ((isset($_GET[0][('pagenum')]) && Aspis_isset( $_GET [0][('pagenum')]))))
 $page = absint($_GET[0]['pagenum']);
if ( ((empty($page) || Aspis_empty( $page))))
 $page = array(1,false);
$start = $offset = array(($page[0] - (1)) * $per_page[0],false);
$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(concat2(add_query_arg(array('pagenum',false),array('%#%',false)),'#themenav')),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint(attAspis(ceil(($theme_total[0] / $per_page[0])))),deregisterTaint(array('current',false)) => addTaint($page)),false));
$themes = Aspis_array_slice($themes,$start,$per_page);
function theme_update_available ( $theme ) {
static $themes_update;
if ( (!((isset($themes_update) && Aspis_isset( $themes_update)))))
 $themes_update = get_transient(array('update_themes',false));
if ( (is_object($theme[0]) && ((isset($theme[0]->stylesheet) && Aspis_isset( $theme[0] ->stylesheet )))))
 $stylesheet = $theme[0]->stylesheet;
elseif ( (is_array($theme[0]) && ((isset($theme[0][('Stylesheet')]) && Aspis_isset( $theme [0][('Stylesheet')])))))
 $stylesheet = $theme[0]['Stylesheet'];
else 
{return array(false,false);
}if ( ((isset($themes_update[0]->response[0][$stylesheet[0]]) && Aspis_isset( $themes_update[0] ->response [0][$stylesheet[0]] ))))
 {$update = $themes_update[0]->response[0][$stylesheet[0]];
$theme_name = is_object($theme[0]) ? $theme[0]->name : (is_array($theme[0]) ? $theme[0]['Name'] : array('',false));
$details_url = add_query_arg(array(array('TB_iframe' => array('true',false,false),'width' => array(1024,false,false),'height' => array(800,false,false)),false),$update[0]['url']);
$update_url = wp_nonce_url(concat1('update.php?action=upgrade-theme&amp;theme=',Aspis_urlencode($stylesheet)),concat1('upgrade-theme_',$stylesheet));
$update_onclick = concat2(concat1('onclick="if ( confirm(\'',esc_js(__(array("Upgrading this theme will lose any customizations you have made.  'Cancel' to stop, 'OK' to upgrade.",false)))),'\') ) {return true;}return false;"');
if ( (denot_boolean(current_user_can(array('update_themes',false)))))
 printf((deconcat2(concat1('<p><strong>',__(array('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%1$s">View version %3$s Details</a>.',false))),'</strong></p>')),deAspisRC($theme_name),deAspisRC($details_url),deAspisRC($update[0]['new_version']));
else 
{if ( ((empty($update[0]->package) || Aspis_empty( $update[0] ->package ))))
 printf((deconcat2(concat1('<p><strong>',__(array('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%1$s">View version %3$s Details</a> <em>automatic upgrade unavailable for this theme</em>.',false))),'</strong></p>')),deAspisRC($theme_name),deAspisRC($details_url),deAspisRC($update[0]['new_version']));
else 
{printf((deconcat2(concat1('<p><strong>',__(array('There is a new version of %1$s available. <a href="%2$s" class="thickbox" title="%1$s">View version %3$s Details</a> or <a href="%4$s" %5$s >upgrade automatically</a>.',false))),'</strong></p>')),deAspisRC($theme_name),deAspisRC($details_url),deAspisRC($update[0]['new_version']),deAspisRC($update_url),deAspisRC($update_onclick));
}}} }
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?> <a href="theme-install.php" class="button add-new-h2"><?php echo AspisCheckPrint(esc_html_x(array('Add New',false),array('theme',false)));
;
?></a></h2>

<h3><?php _e(array('Current Theme',false));
;
?></h3>
<div id="current-theme">
<?php if ( $ct[0]->screenshot[0])
 {;
?>
<img src="<?php echo AspisCheckPrint(concat(concat2(concat(concat2($ct[0]->theme_root_uri,'/'),$ct[0]->stylesheet),'/'),$ct[0]->screenshot));
;
?>" alt="<?php _e(array('Current theme preview',false));
;
?>" />
<?php };
?>
<h4><?php printf(deAspis(__(array('%1$s %2$s by %3$s',false))),deAspisRC($ct[0]->title),deAspisRC($ct[0]->version),deAspisRC($ct[0]->author));
;
?></h4>
<p class="theme-description"><?php echo AspisCheckPrint($ct[0]->description);
;
?></p>
<?php if ( $ct[0]->parent_theme[0])
 {;
?>
	<p><?php printf(deAspis(__(array('The template files are located in <code>%2$s</code>.  The stylesheet files are located in <code>%3$s</code>.  <strong>%4$s</strong> uses templates from <strong>%5$s</strong>.  Changes made to the templates will affect both themes.',false))),deAspisRC($ct[0]->title),deAspisRC(Aspis_str_replace(array(WP_CONTENT_DIR,false),array('',false),$ct[0]->template_dir)),deAspisRC(Aspis_str_replace(array(WP_CONTENT_DIR,false),array('',false),$ct[0]->stylesheet_dir)),deAspisRC($ct[0]->title),deAspisRC($ct[0]->parent_theme));
;
?></p>
<?php }else 
{{;
?>
	<p><?php printf(deAspis(__(array('All of this theme&#8217;s files are located in <code>%2$s</code>.',false))),deAspisRC($ct[0]->title),deAspisRC(Aspis_str_replace(array(WP_CONTENT_DIR,false),array('',false),$ct[0]->template_dir)),deAspisRC(Aspis_str_replace(array(WP_CONTENT_DIR,false),array('',false),$ct[0]->stylesheet_dir)));
;
?></p>
<?php }};
?>
<?php if ( $ct[0]->tags[0])
 {;
?>
<p><?php _e(array('Tags:',false));
;
?> <?php echo AspisCheckPrint(Aspis_join(array(', ',false),$ct[0]->tags));
;
?></p>
<?php };
?>
<?php theme_update_available($ct);
;
?>

</div>

<div class="clear"></div>
<h3><?php _e(array('Available Themes',false));
;
?></h3>
<div class="clear"></div>

<?php if ( $theme_total[0])
 {;
?>

<?php if ( $page_links[0])
 {;
?>
<div class="tablenav">
<div class="tablenav-pages"><?php $page_links_text = Aspis_sprintf(concat2(concat1('<span class="displaying-num">',__(array('Displaying %s&#8211;%s of %s',false))),'</span>%s'),number_format_i18n(array($start[0] + (1),false)),number_format_i18n(attAspisRC(min(deAspisRC(array($page[0] * $per_page[0],false)),deAspisRC($theme_total)))),number_format_i18n($theme_total),$page_links);
echo AspisCheckPrint($page_links_text);
;
?></div>
</div>
<?php };
?>

<table id="availablethemes" cellspacing="0" cellpadding="0">
<?php $style = array('',false);
$theme_names = attAspisRC(array_keys(deAspisRC($themes)));
Aspis_natcasesort($theme_names);
$table = array(array(),false);
$rows = attAspis(ceil((count($theme_names[0]) / (3))));
for ( $row = array(1,false) ; ($row[0] <= $rows[0]) ; postincr($row) )
for ( $col = array(1,false) ; ($col[0] <= (3)) ; postincr($col) )
arrayAssign($table[0][$row[0]][0],deAspis(registerTaint($col)),addTaint(Aspis_array_shift($theme_names)));
foreach ( $table[0] as $row =>$cols )
{restoreTaint($row,$cols);
{;
?>
<tr>
<?php foreach ( $cols[0] as $col =>$theme_name )
{restoreTaint($col,$theme_name);
{$class = array(array(array('available-theme',false)),false);
if ( ($row[0] == (1)))
 arrayAssignAdd($class[0][],addTaint(array('top',false)));
if ( ($col[0] == (1)))
 arrayAssignAdd($class[0][],addTaint(array('left',false)));
if ( ($row[0] == $rows[0]))
 arrayAssignAdd($class[0][],addTaint(array('bottom',false)));
if ( ($col[0] == (3)))
 arrayAssignAdd($class[0][],addTaint(array('right',false)));
;
?>
	<td class="<?php echo AspisCheckPrint(Aspis_join(array(' ',false),$class));
;
?>">
<?php if ( (!((empty($theme_name) || Aspis_empty( $theme_name)))))
 {$template = $themes[0][$theme_name[0]][0]['Template'];
$stylesheet = $themes[0][$theme_name[0]][0]['Stylesheet'];
$title = $themes[0][$theme_name[0]][0]['Title'];
$version = $themes[0][$theme_name[0]][0]['Version'];
$description = $themes[0][$theme_name[0]][0]['Description'];
$author = $themes[0][$theme_name[0]][0]['Author'];
$screenshot = $themes[0][$theme_name[0]][0]['Screenshot'];
$stylesheet_dir = $themes[0][$theme_name[0]][0]['Stylesheet Dir'];
$template_dir = $themes[0][$theme_name[0]][0]['Template Dir'];
$parent_theme = $themes[0][$theme_name[0]][0]['Parent Theme'];
$theme_root = $themes[0][$theme_name[0]][0]['Theme Root'];
$theme_root_uri = $themes[0][$theme_name[0]][0]['Theme Root URI'];
$preview_link = esc_url(concat2(get_option(array('home',false)),'/'));
if ( deAspis(is_ssl()))
 $preview_link = Aspis_str_replace(array('http://',false),array('https://',false),$preview_link);
$preview_link = Aspis_htmlspecialchars(add_query_arg(array(array('preview' => array(1,false,false),deregisterTaint(array('template',false)) => addTaint($template),deregisterTaint(array('stylesheet',false)) => addTaint($stylesheet),'TB_iframe' => array('true',false,false)),false),$preview_link));
$preview_text = esc_attr(Aspis_sprintf(__(array('Preview of &#8220;%s&#8221;',false)),$title));
$tags = $themes[0][$theme_name[0]][0]['Tags'];
$thickbox_class = array('thickbox thickbox-preview',false);
$activate_link = wp_nonce_url(concat(concat2(concat1("themes.php?action=activate&amp;template=",Aspis_urlencode($template)),"&amp;stylesheet="),Aspis_urlencode($stylesheet)),concat1('switch-theme_',$template));
$activate_text = esc_attr(Aspis_sprintf(__(array('Activate &#8220;%s&#8221;',false)),$title));
$actions = array(array(),false);
arrayAssignAdd($actions[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$activate_link),'" class="activatelink" title="'),$activate_text),'">'),__(array('Activate',false))),'</a>')));
arrayAssignAdd($actions[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$preview_link),'" class="thickbox thickbox-preview" title="'),esc_attr(Aspis_sprintf(__(array('Preview &#8220;%s&#8221;',false)),$theme_name))),'">'),__(array('Preview',false))),'</a>')));
if ( deAspis(current_user_can(array('update_themes',false))))
 arrayAssignAdd($actions[0][],addTaint(concat2(concat(concat2(concat2(concat(concat2(concat2(concat1('<a class="submitdelete deletion" href="',wp_nonce_url(concat1("themes.php?action=delete&amp;template=",$stylesheet),concat1('delete-theme_',$stylesheet))),'" onclick="'),"if ( confirm('"),esc_js(Aspis_sprintf(__(array("You are about to delete this theme '%s'\n  'Cancel' to stop, 'OK' to delete.",false)),$theme_name))),"') ) {return true;}return false;"),'">'),__(array('Delete',false))),'</a>')));
$actions = apply_filters(array('theme_action_links',false),$actions,attachAspis($themes,$theme_name[0]));
$actions = Aspis_implode(array(' | ',false),$actions);
;
?>
		<a href="<?php echo AspisCheckPrint($preview_link);
;
?>" class="<?php echo AspisCheckPrint($thickbox_class);
;
?> screenshot">
<?php if ( $screenshot[0])
 {;
?>
			<img src="<?php echo AspisCheckPrint(concat(concat2(concat(concat2($theme_root_uri,'/'),$stylesheet),'/'),$screenshot));
;
?>" alt="" />
<?php };
?>
		</a>
<h3><?php printf(deAspis(__(array('%1$s %2$s by %3$s',false))),deAspisRC($title),deAspisRC($version),deAspisRC($author));
;
?></h3>
<p class="description"><?php echo AspisCheckPrint($description);
;
?></p>
<span class='action-links'><?php echo AspisCheckPrint($actions);
?></span>
	<?php if ( $parent_theme[0])
 {;
?>
	<p><?php printf(deAspis(__(array('The template files are located in <code>%2$s</code>.  The stylesheet files are located in <code>%3$s</code>.  <strong>%4$s</strong> uses templates from <strong>%5$s</strong>.  Changes made to the templates will affect both themes.',false))),deAspisRC($title),deAspisRC(Aspis_str_replace(array(WP_CONTENT_DIR,false),array('',false),$template_dir)),deAspisRC(Aspis_str_replace(array(WP_CONTENT_DIR,false),array('',false),$stylesheet_dir)),deAspisRC($title),deAspisRC($parent_theme));
;
?></p>
<?php }else 
{{;
?>
	<p><?php printf(deAspis(__(array('All of this theme&#8217;s files are located in <code>%2$s</code>.',false))),deAspisRC($title),deAspisRC(Aspis_str_replace(array(WP_CONTENT_DIR,false),array('',false),$template_dir)),deAspisRC(Aspis_str_replace(array(WP_CONTENT_DIR,false),array('',false),$stylesheet_dir)));
;
?></p>
<?php }};
?>
<?php if ( $tags[0])
 {;
?>
<p><?php _e(array('Tags:',false));
;
?> <?php echo AspisCheckPrint(Aspis_join(array(', ',false),$tags));
;
?></p>
<?php };
?>
		<?php theme_update_available(attachAspis($themes,$theme_name[0]));
;
?>
<?php };
?>
	</td>
<?php }};
?>
</tr>
<?php }};
?>
</table>
<?php }else 
{{;
?>
<p><?php _e(array('You only have one theme installed at the moment so there is nothing to show you here.  Maybe you should download some more to try out.',false));
;
?></p>
<?php }};
?>
<br class="clear" />

<?php if ( $page_links[0])
 {;
?>
<div class="tablenav">
<?php echo AspisCheckPrint(concat2(concat1("<div class='tablenav-pages'>",$page_links_text),"</div>"));
;
?>
<br class="clear" />
</div>
<?php };
?>

<br class="clear" />

<?php $broken_themes = get_broken_themes();
if ( count($broken_themes[0]))
 {;
?>

<h2><?php _e(array('Broken Themes',false));
;
?></h2>
<p><?php _e(array('The following themes are installed but incomplete.  Themes must have a stylesheet and a template.',false));
;
?></p>

<table id="broken-themes">
	<tr>
		<th><?php _e(array('Name',false));
;
?></th>
		<th><?php _e(array('Description',false));
;
?></th>
	</tr>
<?php $theme = array('',false);
$theme_names = attAspisRC(array_keys(deAspisRC($broken_themes)));
Aspis_natcasesort($theme_names);
foreach ( $theme_names[0] as $theme_name  )
{$title = $broken_themes[0][$theme_name[0]][0]['Title'];
$description = $broken_themes[0][$theme_name[0]][0]['Description'];
$theme = (('class="alternate"') == $theme[0]) ? array('',false) : array('class="alternate"',false);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1("
		<tr ",$theme),">
			 <td>"),$title),"</td>
			 <td>"),$description),"</td>
		</tr>"));
};
?>
</table>
<?php };
?>
</div>

<?php require ('admin-footer.php');
;
?>
<?php 