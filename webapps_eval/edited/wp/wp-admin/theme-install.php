<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('install_themes',false)))))
 wp_die(__(array('You do not have sufficient permissions to install themes on this blog.',false)));
include (deconcat12(ABSPATH,'wp-admin/includes/theme-install.php'));
$title = __(array('Install Themes',false));
$parent_file = array('themes.php',false);
wp_reset_vars(array(array(array('tab',false),array('paged',false)),false));
wp_enqueue_style(array('theme-install',false));
wp_enqueue_script(array('theme-install',false));
add_thickbox();
wp_enqueue_script(array('theme-preview',false));
$tabs = array(array(),false);
arrayAssign($tabs[0],deAspis(registerTaint(array('dashboard',false))),addTaint(__(array('Search',false))));
if ( (('search') == $tab[0]))
 arrayAssign($tabs[0],deAspis(registerTaint(array('search',false))),addTaint(__(array('Search Results',false))));
arrayAssign($tabs[0],deAspis(registerTaint(array('upload',false))),addTaint(__(array('Upload',false))));
arrayAssign($tabs[0],deAspis(registerTaint(array('featured',false))),addTaint(_x(array('Featured',false),array('Theme Installer',false))));
arrayAssign($tabs[0],deAspis(registerTaint(array('new',false))),addTaint(_x(array('Newest',false),array('Theme Installer',false))));
arrayAssign($tabs[0],deAspis(registerTaint(array('updated',false))),addTaint(_x(array('Recently Updated',false),array('Theme Installer',false))));
$nonmenu_tabs = array(array(array('theme-information',false)),false);
$tabs = apply_filters(array('install_themes_tabs',false),$tabs);
$nonmenu_tabs = apply_filters(array('install_themes_nonmenu_tabs',false),$nonmenu_tabs);
if ( (((empty($tab) || Aspis_empty( $tab))) || ((!((isset($tabs[0][$tab[0]]) && Aspis_isset( $tabs [0][$tab[0]])))) && (denot_boolean(Aspis_in_array($tab,array_cast($nonmenu_tabs)))))))
 {$tab_actions = attAspisRC(array_keys(deAspisRC($tabs)));
$tab = attachAspis($tab_actions,(0));
}if ( ((empty($paged) || Aspis_empty( $paged))))
 $paged = array(1,false);
$body_id = $tab;
do_action(concat1('install_themes_pre_',$tab));
include ('admin-header.php');
;
?>
<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

	<ul class="subsubsub">
<?php $display_tabs = array(array(),false);
foreach ( deAspis(array_cast($tabs)) as $action =>$text )
{restoreTaint($action,$text);
{$sep = (deAspis(Aspis_end($tabs)) != $text[0]) ? array(' | ',false) : array('',false);
$class = ($action[0] == $tab[0]) ? array(' class="current"',false) : array('',false);
$href = admin_url(concat1('theme-install.php?tab=',$action));
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\t\t<li><a href='",$href),"'"),$class),">"),$text),"</a>"),$sep),"</li>\n"));
}};
?>
	</ul>
	<br class="clear" />
	<?php do_action(concat1('install_themes_',$tab),$paged);
;
?>
</div>
<?php include ('admin-footer.php');
