<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('update_plugins',false)))))
 wp_die(__(array('You do not have sufficient permissions to update plugins for this blog.',false)));
function list_core_update ( $update ) {
global $wp_local_package;
$version_string = ((('en_US') == $update[0]->locale[0]) && (('en_US') == deAspis(get_locale()))) ? $update[0]->current : Aspis_sprintf(array("%s&ndash;<strong>%s</strong>",false),$update[0]->current,$update[0]->locale);
$current = array(false,false);
if ( ((!((isset($update[0]->response) && Aspis_isset( $update[0] ->response )))) || (('latest') == $update[0]->response[0])))
 $current = array(true,false);
$submit = __(array('Upgrade Automatically',false));
$form_action = array('update-core.php?action=do-core-upgrade',false);
if ( (('development') == $update[0]->response[0]))
 {$message = __(array('You are using a development version of WordPress.  You can upgrade to the latest nightly build automatically or download the nightly build and install it manually:',false));
$download = __(array('Download nightly build',false));
}else 
{{if ( $current[0])
 {$message = Aspis_sprintf(__(array('You have the latest version of WordPress. You do not need to upgrade. However, if you want to re-install version %s, you can do so automatically or download the package and re-install manually:',false)),$version_string);
$submit = __(array('Re-install Automatically',false));
$form_action = array('update-core.php?action=do-core-reinstall',false);
}else 
{{$message = Aspis_sprintf(__(array('You can upgrade to version %s automatically or download the package and install it manually:',false)),$version_string);
}}$download = Aspis_sprintf(__(array('Download %s',false)),$version_string);
}}echo AspisCheckPrint(array('<p>',false));
echo AspisCheckPrint($message);
echo AspisCheckPrint(array('</p>',false));
echo AspisCheckPrint(concat2(concat1('<form method="post" action="',$form_action),'" name="upgrade" class="upgrade">'));
wp_nonce_field(array('upgrade-core',false));
echo AspisCheckPrint(array('<p>',false));
echo AspisCheckPrint(concat2(concat1('<input id="upgrade" class="button" type="submit" value="',esc_attr($submit)),'" name="upgrade" />&nbsp;'));
echo AspisCheckPrint(concat2(concat1('<input name="version" value="',esc_attr($update[0]->current)),'" type="hidden"/>'));
echo AspisCheckPrint(concat2(concat1('<input name="locale" value="',esc_attr($update[0]->locale)),'" type="hidden"/>'));
echo AspisCheckPrint(concat2(concat(concat2(concat1('<a href="',esc_url($update[0]->package)),'" class="button">'),$download),'</a>&nbsp;'));
if ( (('en_US') != $update[0]->locale[0]))
 if ( ((!((isset($update[0]->dismissed) && Aspis_isset( $update[0] ->dismissed )))) || (denot_boolean($update[0]->dismissed))))
 echo AspisCheckPrint(concat2(concat1('<input id="dismiss" class="button" type="submit" value="',esc_attr__(array('Hide this update',false))),'" name="dismiss" />'));
else 
{echo AspisCheckPrint(concat2(concat1('<input id="undismiss" class="button" type="submit" value="',esc_attr__(array('Bring back this update',false))),'" name="undismiss" />'));
}echo AspisCheckPrint(array('</p>',false));
if ( ((('en_US') != $update[0]->locale[0]) && ((!((isset($wp_local_package) && Aspis_isset( $wp_local_package)))) || ($wp_local_package[0] != $update[0]->locale[0]))))
 echo AspisCheckPrint(concat2(concat1('<p class="hint">',__(array('This localized version contains both the translation and various other localization fixes. You can skip upgrading if you want to keep your current translation.',false))),'</p>'));
else 
{if ( ((('en_US') == $update[0]->locale[0]) && (deAspis(get_locale()) != ('en_US'))))
 {echo AspisCheckPrint(concat2(concat1('<p class="hint">',Aspis_sprintf(__(array('You are about to install WordPress %s <strong>in English.</strong> There is a chance this upgrade will break your translation. You may prefer to wait for the localized version to be released.',false)),$update[0]->current)),'</p>'));
}}echo AspisCheckPrint(array('</form>',false));
 }
function dismissed_updates (  ) {
$dismissed = get_core_updates(array(array('dismissed' => array(true,false,false),'available' => array(false,false,false)),false));
if ( $dismissed[0])
 {$show_text = esc_js(__(array('Show hidden updates',false)));
$hide_text = esc_js(__(array('Hide hidden updates',false)));
;
?>
	<script type="text/javascript">

		jQuery(function($) {
			$('dismissed-updates').show();
			$('#show-dismissed').toggle(function(){$(this).text('<?php echo AspisCheckPrint($hide_text);
;
?>');}, function() {$(this).text('<?php echo AspisCheckPrint($show_text);
;
?>')});
			$('#show-dismissed').click(function() { $('#dismissed-updates').toggle('slow');});
		});
	</script>
	<?php echo AspisCheckPrint(concat2(concat1('<p class="hide-if-no-js"><a id="show-dismissed" href="#">',__(array('Show hidden updates',false))),'</a></p>'));
echo AspisCheckPrint(array('<ul id="dismissed-updates" class="core-updates dismissed">',false));
foreach ( deAspis(array_cast($dismissed)) as $update  )
{echo AspisCheckPrint(array('<li>',false));
list_core_update($update);
echo AspisCheckPrint(array('</li>',false));
}echo AspisCheckPrint(array('</ul>',false));
} }
function core_upgrade_preamble (  ) {
global $upgrade_error;
$updates = get_core_updates();
;
?>
	<div class="wrap">
	<?php screen_icon();
;
?>
	<h2><?php _e(array('Upgrade WordPress',false));
;
?></h2>
<?php if ( $upgrade_error[0])
 {echo AspisCheckPrint(array('<div class="error"><p>',false));
_e(array('Please select one or more plugins to upgrade.',false));
echo AspisCheckPrint(array('</p></div>',false));
}if ( ((!((isset($updates[0][(0)][0]->response) && Aspis_isset( $updates [0][(0)][0] ->response )))) || (('latest') == $updates[0][(0)][0]->response[0])))
 {echo AspisCheckPrint(array('<h3>',false));
_e(array('You have the latest version of WordPress. You do not need to upgrade',false));
echo AspisCheckPrint(array('</h3>',false));
}else 
{{echo AspisCheckPrint(array('<div class="updated fade"><p>',false));
_e(array('<strong>Important:</strong> before upgrading, please <a href="http://codex.wordpress.org/WordPress_Backups">backup your database and files</a>.',false));
echo AspisCheckPrint(array('</p></div>',false));
echo AspisCheckPrint(array('<h3 class="response">',false));
_e(array('There is a new version of WordPress available for upgrade',false));
echo AspisCheckPrint(array('</h3>',false));
}}echo AspisCheckPrint(array('<ul class="core-updates">',false));
$alternate = array(true,false);
foreach ( deAspis(array_cast($updates)) as $update  )
{$class = $alternate[0] ? array(' class="alternate"',false) : array('',false);
$alternate = not_boolean($alternate);
echo AspisCheckPrint(concat2(concat1("<li ",$class),">"));
list_core_update($update);
echo AspisCheckPrint(array('</li>',false));
}echo AspisCheckPrint(array('</ul>',false));
dismissed_updates();
list_plugin_updates();
do_action(array('core_upgrade_preamble',false));
echo AspisCheckPrint(array('</div>',false));
 }
function list_plugin_updates (  ) {
global $wp_version;
$cur_wp_version = Aspis_preg_replace(array('/-.*$/',false),array('',false),$wp_version);
require_once (deconcat12(ABSPATH,'wp-admin/includes/plugin-install.php'));
$plugins = get_plugin_updates();
if ( ((empty($plugins) || Aspis_empty( $plugins))))
 return ;
$form_action = array('update-core.php?action=do-plugin-upgrade',false);
$core_updates = get_core_updates();
if ( ((((!((isset($core_updates[0][(0)][0]->response) && Aspis_isset( $core_updates [0][(0)][0] ->response )))) || (('latest') == $core_updates[0][(0)][0]->response[0])) || (('development') == $core_updates[0][(0)][0]->response[0])) || (version_compare(deAspisRC($core_updates[0][(0)][0]->current),deAspisRC($cur_wp_version),'='))))
 $core_update_version = array(false,false);
else 
{$core_update_version = $core_updates[0][(0)][0]->current;
};
?>
<h3><?php _e(array('Plugins',false));
;
?></h3>
<p><?php _e(array('The following plugins have new versions available.  Check the ones you want to upgrade and then click "Upgrade Plugins".',false));
;
?></p>
<form method="post" action="<?php echo AspisCheckPrint($form_action);
;
?>" name="upgrade-plugins" class="upgrade">
<?php wp_nonce_field(array('upgrade-core',false));
;
?>
<p><input id="upgrade-plugins" class="button" type="submit" value="<?php esc_attr_e(array('Upgrade Plugins',false));
;
?>" name="upgrade" /></p>
<table class="widefat" cellspacing="0" id="update-plugins-table">
	<thead>
	<tr>
		<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
		<th scope="col" class="manage-column"><?php _e(array('Select All',false));
;
?></th>
	</tr>
	</thead>

	<tfoot>
	<tr>
		<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
		<th scope="col" class="manage-column"><?php _e(array('Select All',false));
;
?></th>
	</tr>
	</tfoot>
	<tbody class="plugins">
<?php foreach ( deAspis(array_cast($plugins)) as $plugin_file =>$plugin_data )
{restoreTaint($plugin_file,$plugin_data);
{$info = plugins_api(array('plugin_information',false),array(array(deregisterTaint(array('slug',false)) => addTaint($plugin_data[0]->update[0]->slug)),false));
if ( (((isset($info[0]->tested) && Aspis_isset( $info[0] ->tested ))) && (version_compare(deAspisRC($info[0]->tested),deAspisRC($cur_wp_version),'>='))))
 {$compat = concat1('<br />',Aspis_sprintf(__(array('Compatibility with WordPress %1$s: 100%% (according to its author)',false)),$cur_wp_version));
}elseif ( ((isset($info[0]->compatibility[0][$cur_wp_version[0]][0][$plugin_data[0]->update[0]->new_version[0]]) && Aspis_isset( $info[0] ->compatibility [0][$cur_wp_version[0]] [0][$plugin_data[0] ->update[0] ->new_version [0]] ))))
 {$compat = $info[0]->compatibility[0][$cur_wp_version[0]][0][$plugin_data[0]->update[0]->new_version[0]];
$compat = concat1('<br />',Aspis_sprintf(__(array('Compatibility with WordPress %1$s: %2$d%% (%3$d "works" votes out of %4$d total)',false)),$cur_wp_version,attachAspis($compat,(0)),attachAspis($compat,(2)),attachAspis($compat,(1))));
}else 
{{$compat = concat1('<br />',Aspis_sprintf(__(array('Compatibility with WordPress %1$s: Unknown',false)),$cur_wp_version));
}}if ( $core_update_version[0])
 {if ( ((isset($info[0]->compatibility[0][$core_update_version[0]][0][$plugin_data[0]->update[0]->new_version[0]]) && Aspis_isset( $info[0] ->compatibility [0][$core_update_version[0]] [0][$plugin_data[0] ->update[0] ->new_version [0]] ))))
 {$update_compat = $info[0]->compatibility[0][$core_update_version[0]][0][$plugin_data[0]->update[0]->new_version[0]];
$compat = concat($compat,concat1('<br />',Aspis_sprintf(__(array('Compatibility with WordPress %1$s: %2$d%% (%3$d "works" votes out of %4$d total)',false)),$core_update_version,attachAspis($update_compat,(0)),attachAspis($update_compat,(2)),attachAspis($update_compat,(1)))));
}else 
{{$compat = concat($compat,concat1('<br />',Aspis_sprintf(__(array('Compatibility with WordPress %1$s: Unknown',false)),$core_update_version)));
}}}if ( ((isset($plugin_data[0]->update[0]->upgrade_notice) && Aspis_isset( $plugin_data[0] ->update[0] ->upgrade_notice ))))
 {$upgrade_notice = concat1('<br />',Aspis_strip_tags($plugin_data[0]->update[0]->upgrade_notice));
}else 
{{$upgrade_notice = array('',false);
}}echo AspisCheckPrint(concat2(concat(concat(concat(concat(concat1("
	<tr class='active'>
		<th scope='row' class='check-column'><input type='checkbox' name='checked[]' value='",esc_attr($plugin_file)),concat2(concat1("' /></th>
		<td class='plugin-title'><strong>",$plugin_data[0]->Name),"</strong>")),Aspis_sprintf(__(array('You are running version %1$s. Upgrade to %2$s.',false)),$plugin_data[0]->Version,$plugin_data[0]->update[0]->new_version)),$compat),$upgrade_notice),"</td>
	</tr>"));
}};
?>
	</tbody>
</table>
<p><input id="upgrade-plugins-2" class="button" type="submit" value="<?php esc_attr_e(array('Upgrade Plugins',false));
;
?>" name="upgrade" /></p>
</form>
<?php  }
function list_theme_updates (  ) {
$themes = get_theme_updates();
if ( ((empty($themes) || Aspis_empty( $themes))))
 return ;
;
?>
<h3><?php _e(array('Themes',false));
;
?></h3>
<table class="widefat" cellspacing="0" id="update-themes-table">
	<thead>
	<tr>
		<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
		<th scope="col" class="manage-column"><?php _e(array('Name',false));
;
?></th>
	</tr>
	</thead>

	<tfoot>
	<tr>
		<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
		<th scope="col" class="manage-column"><?php _e(array('Name',false));
;
?></th>
	</tr>
	</tfoot>
	<tbody class="plugins">
<?php foreach ( deAspis(array_cast($themes)) as $stylesheet =>$theme_data )
{restoreTaint($stylesheet,$theme_data);
{echo AspisCheckPrint(concat(concat1("
	<tr class='active'>
		<th scope='row' class='check-column'><input type='checkbox' name='checked[]' value='",esc_attr($stylesheet)),concat2(concat1("' /></th>
		<td class='plugin-title'><strong>",$theme_data[0]->Name),"</strong></td>
	</tr>")));
}};
?>
	</tbody>
</table>
<?php  }
function do_core_upgrade ( $reinstall = array(false,false) ) {
global $wp_filesystem;
if ( $reinstall[0])
 $url = array('update-core.php?action=do-core-reinstall',false);
else 
{$url = array('update-core.php?action=do-core-upgrade',false);
}$url = wp_nonce_url($url,array('upgrade-core',false));
if ( (false === deAspis(($credentials = request_filesystem_credentials($url,array('',false),array(false,false),array(ABSPATH,false))))))
 return ;
$version = ((isset($_POST[0][('version')]) && Aspis_isset( $_POST [0][('version')]))) ? $_POST[0]['version'] : array(false,false);
$locale = ((isset($_POST[0][('locale')]) && Aspis_isset( $_POST [0][('locale')]))) ? $_POST[0]['locale'] : array('en_US',false);
$update = find_core_update($version,$locale);
if ( (denot_boolean($update)))
 return ;
if ( (denot_boolean(WP_Filesystem($credentials,array(ABSPATH,false)))))
 {request_filesystem_credentials($url,array('',false),array(true,false),array(ABSPATH,false));
return ;
};
?>
	<div class="wrap">
	<?php screen_icon();
;
?>
	<h2><?php _e(array('Upgrade WordPress',false));
;
?></h2>
<?php if ( deAspis($wp_filesystem[0]->errors[0]->get_error_code()))
 {foreach ( deAspis($wp_filesystem[0]->errors[0]->get_error_messages()) as $message  )
show_message($message);
echo AspisCheckPrint(array('</div>',false));
return ;
}if ( $reinstall[0])
 $update[0]->response = array('reinstall',false);
$result = wp_update_core($update,array('show_message',false));
if ( deAspis(is_wp_error($result)))
 {show_message($result);
if ( (('up_to_date') != deAspis($result[0]->get_error_code())))
 show_message(__(array('Installation Failed',false)));
}else 
{{show_message(__(array('WordPress upgraded successfully',false)));
}}echo AspisCheckPrint(array('</div>',false));
 }
function do_dismiss_core_update (  ) {
$version = ((isset($_POST[0][('version')]) && Aspis_isset( $_POST [0][('version')]))) ? $_POST[0]['version'] : array(false,false);
$locale = ((isset($_POST[0][('locale')]) && Aspis_isset( $_POST [0][('locale')]))) ? $_POST[0]['locale'] : array('en_US',false);
$update = find_core_update($version,$locale);
if ( (denot_boolean($update)))
 return ;
dismiss_core_update($update);
wp_redirect(wp_nonce_url(array('update-core.php?action=upgrade-core',false),array('upgrade-core',false)));
 }
function do_undismiss_core_update (  ) {
$version = ((isset($_POST[0][('version')]) && Aspis_isset( $_POST [0][('version')]))) ? $_POST[0]['version'] : array(false,false);
$locale = ((isset($_POST[0][('locale')]) && Aspis_isset( $_POST [0][('locale')]))) ? $_POST[0]['locale'] : array('en_US',false);
$update = find_core_update($version,$locale);
if ( (denot_boolean($update)))
 return ;
undismiss_core_update($version,$locale);
wp_redirect(wp_nonce_url(array('update-core.php?action=upgrade-core',false),array('upgrade-core',false)));
 }
function no_update_actions ( $actions ) {
return array('',false);
 }
function do_plugin_upgrade (  ) {
include_once (deconcat12(ABSPATH,'wp-admin/includes/class-wp-upgrader.php'));
if ( ((isset($_GET[0][('plugins')]) && Aspis_isset( $_GET [0][('plugins')]))))
 {$plugins = Aspis_explode(array(',',false),$_GET[0]['plugins']);
}elseif ( ((isset($_POST[0][('checked')]) && Aspis_isset( $_POST [0][('checked')]))))
 {$plugins = array_cast($_POST[0]['checked']);
}else 
{{return ;
}}$url = concat1('update-core.php?action=do-plugin-upgrade&amp;plugins=',Aspis_urlencode(Aspis_join(array(',',false),$plugins)));
$title = __(array('Upgrade Plugins',false));
$nonce = array('upgrade-core',false);
$upgrader = array(new Plugin_Upgrader(array(new Plugin_Upgrader_Skin(array(compact('title','nonce','url','plugin'),false)),false)),false);
$upgrader[0]->bulk_upgrade($plugins);
 }
$action = ((isset($_GET[0][('action')]) && Aspis_isset( $_GET [0][('action')]))) ? $_GET[0]['action'] : array('upgrade-core',false);
$upgrade_error = array(false,false);
if ( (((('do-plugin-upgrade') == $action[0]) && (!((isset($_GET[0][('plugins')]) && Aspis_isset( $_GET [0][('plugins')]))))) && (!((isset($_POST[0][('checked')]) && Aspis_isset( $_POST [0][('checked')]))))))
 {$upgrade_error = array(true,false);
$action = array('upgrade-core',false);
}$title = __(array('Upgrade WordPress',false));
$parent_file = array('tools.php',false);
if ( (('upgrade-core') == $action[0]))
 {wp_version_check();
require_once ('admin-header.php');
core_upgrade_preamble();
}elseif ( ((('do-core-upgrade') == $action[0]) || (('do-core-reinstall') == $action[0])))
 {check_admin_referer(array('upgrade-core',false));
if ( ((isset($_POST[0][('dismiss')]) && Aspis_isset( $_POST [0][('dismiss')]))))
 do_dismiss_core_update();
elseif ( ((isset($_POST[0][('undismiss')]) && Aspis_isset( $_POST [0][('undismiss')]))))
 do_undismiss_core_update();
require_once ('admin-header.php');
if ( (('do-core-reinstall') == $action[0]))
 $reinstall = array(true,false);
else 
{$reinstall = array(false,false);
}if ( ((isset($_POST[0][('upgrade')]) && Aspis_isset( $_POST [0][('upgrade')]))))
 do_core_upgrade($reinstall);
}elseif ( (('do-plugin-upgrade') == $action[0]))
 {check_admin_referer(array('upgrade-core',false));
require_once ('admin-header.php');
do_plugin_upgrade();
}include ('admin-footer.php');
