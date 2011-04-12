<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
require_once (ABSPATH . 'wp-admin/includes/widgets.php');
if ( !current_user_can('switch_themes'))
 wp_die(__('Cheatin&#8217; uh?'));
wp_admin_css('widgets');
$widgets_access = get_user_setting('widgets_access');
if ( (isset($_GET[0]['widgets-access']) && Aspis_isset($_GET[0]['widgets-access'])))
 {$widgets_access = 'on' == deAspisWarningRC($_GET[0]['widgets-access']) ? 'on' : 'off';
set_user_setting('widgets_access',$widgets_access);
}if ( 'on' == $widgets_access)
 add_filter('admin_body_class',create_function('','{return " widgets_access ";}'));
else 
{wp_enqueue_script('admin-widgets');
}do_action('sidebar_admin_setup');
$title = __('Widgets');
$parent_file = 'themes.php';
register_sidebar(array('name' => __('Inactive Widgets'),'id' => 'wp_inactive_widgets','description' => '','before_widget' => '','after_widget' => '','before_title' => '','after_title' => '',));
$sidebars_widgets = wp_get_sidebars_widgets();
if ( empty($sidebars_widgets))
 $sidebars_widgets = wp_get_widget_defaults();
function retrieve_widgets (  ) {
{global $wp_registered_widget_updates,$wp_registered_sidebars,$sidebars_widgets,$wp_registered_widgets;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widget_updates,"\$wp_registered_widget_updates",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_registered_sidebars,"\$wp_registered_sidebars",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($sidebars_widgets,"\$sidebars_widgets",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($wp_registered_widgets,"\$wp_registered_widgets",$AspisChangesCache);
}$_sidebars_widgets = array();
$sidebars = array_keys($wp_registered_sidebars);
unset($sidebars_widgets['array_version']);
$old = array_keys($sidebars_widgets);
sort($old);
sort($sidebars);
if ( $old == $sidebars)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_updates",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_sidebars",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$sidebars_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wp_registered_widgets",$AspisChangesCache);
return ;
}foreach ( $sidebars as $id  )
{if ( array_key_exists($id,$sidebars_widgets))
 {$_sidebars_widgets[$id] = $sidebars_widgets[$id];
unset($sidebars_widgets[$id],$sidebars[$id]);
}}if ( !empty($sidebars_widgets))
 {foreach ( $sidebars_widgets as $lost =>$val )
{if ( is_array($val))
 $_sidebars_widgets['wp_inactive_widgets'] = array_merge((array)$_sidebars_widgets['wp_inactive_widgets'],$val);
}}$shown_widgets = array();
foreach ( $_sidebars_widgets as $sidebar =>$widgets )
{if ( !is_array($widgets))
 continue ;
$_widgets = array();
foreach ( $widgets as $widget  )
{if ( isset($wp_registered_widgets[$widget]))
 $_widgets[] = $widget;
}$_sidebars_widgets[$sidebar] = $_widgets;
$shown_widgets = array_merge($shown_widgets,$_widgets);
}$sidebars_widgets = $_sidebars_widgets;
unset($_sidebars_widgets,$_widgets);
$lost_widgets = array();
foreach ( $wp_registered_widgets as $key =>$val )
{if ( in_array($key,$shown_widgets,true))
 continue ;
$number = preg_replace('/.+?-([0-9]+)$/','$1',$key);
if ( 2 > (int)$number)
 continue ;
$lost_widgets[] = $key;
}$sidebars_widgets['wp_inactive_widgets'] = array_merge($lost_widgets,(array)$sidebars_widgets['wp_inactive_widgets']);
wp_set_sidebars_widgets($sidebars_widgets);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_updates",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_sidebars",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$sidebars_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wp_registered_widgets",$AspisChangesCache);
 }
retrieve_widgets();
if ( count($wp_registered_sidebars) == 1)
 {require_once ('admin-header.php');
;
?>

	<div class="wrap">
	<?php screen_icon();
;
?>
	<h2><?php echo esc_html($title);
;
?></h2>
		<div class="error">
			<p><?php _e('No Sidebars Defined');
;
?></p>
		</div>
		<p><?php _e('The theme you are currently using isn&#8217;t widget-aware, meaning that it has no sidebars that you are able to change. For information on making your theme widget-aware, please <a href="http://codex.wordpress.org/Widgetizing_Themes">follow these instructions</a>.');
;
?></p>
	</div>

<?php require_once ('admin-footer.php');
exit();
}if ( (isset($_POST[0]['savewidget']) && Aspis_isset($_POST[0]['savewidget'])) || (isset($_POST[0]['removewidget']) && Aspis_isset($_POST[0]['removewidget'])))
 {$widget_id = deAspisWarningRC($_POST[0]['widget-id']);
check_admin_referer("save-delete-widget-$widget_id");
$number = (isset($_POST[0]['multi_number']) && Aspis_isset($_POST[0]['multi_number'])) ? (int)deAspisWarningRC($_POST[0]['multi_number']) : '';
if ( $number)
 {foreach ( deAspisWarningRC($_POST) as $key =>$val )
{if ( is_array($val) && preg_match('/__i__|%i%/',key($val)))
 {$_POST[0][$key] = attAspisRCO(array($number => array_shift($val)));
break ;
}}}$sidebar_id = deAspisWarningRC($_POST[0]['sidebar']);
$position = (isset($_POST[0][$sidebar_id . '_position']) && Aspis_isset($_POST[0][$sidebar_id . '_position'])) ? (int)deAspisWarningRC($_POST[0][$sidebar_id . '_position']) - 1 : 0;
$id_base = deAspisWarningRC($_POST[0]['id_base']);
$sidebar = isset($sidebars_widgets[$sidebar_id]) ? $sidebars_widgets[$sidebar_id] : array();
if ( (isset($_POST[0]['removewidget']) && Aspis_isset($_POST[0]['removewidget'])) && deAspisWarningRC($_POST[0]['removewidget']))
 {if ( !in_array($widget_id,$sidebar,true))
 {wp_redirect('widgets.php?error=0');
exit();
}$sidebar = array_diff($sidebar,array($widget_id));
$_POST = attAspisRCO(array('sidebar' => $sidebar_id,'widget-' . $id_base => array(),'the-widget-id' => $widget_id,'delete_widget' => '1'));
}$_POST[0]['widget-id'] = attAspisRCO($sidebar);
foreach ( (array)$wp_registered_widget_updates as $name =>$control )
{if ( $name != $id_base || !is_callable($control['callback']))
 continue ;
ob_start();
AspisUntainted_call_user_func_array($control['callback'],$control['params']);
ob_end_clean();
break ;
}$sidebars_widgets[$sidebar_id] = $sidebar;
if ( !(isset($_POST[0]['delete_widget']) && Aspis_isset($_POST[0]['delete_widget'])))
 {foreach ( $sidebars_widgets as $key =>$sb )
{if ( is_array($sb))
 $sidebars_widgets[$key] = array_diff($sb,array($widget_id));
}array_splice($sidebars_widgets[$sidebar_id],$position,0,$widget_id);
}wp_set_sidebars_widgets($sidebars_widgets);
wp_redirect('widgets.php?message=0');
exit();
}if ( (isset($_GET[0]['editwidget']) && Aspis_isset($_GET[0]['editwidget'])) && deAspisWarningRC($_GET[0]['editwidget']))
 {$widget_id = deAspisWarningRC($_GET[0]['editwidget']);
if ( (isset($_GET[0]['addnew']) && Aspis_isset($_GET[0]['addnew'])))
 {$sidebar = array_shift($keys = array_keys($wp_registered_sidebars));
if ( (isset($_GET[0]['base']) && Aspis_isset($_GET[0]['base'])) && (isset($_GET[0]['num']) && Aspis_isset($_GET[0]['num'])))
 {foreach ( $wp_registered_widget_controls as $control  )
{if ( deAspisWarningRC($_GET[0]['base']) === $control['id_base'])
 {$control_callback = $control['callback'];
$multi_number = (int)deAspisWarningRC($_GET[0]['num']);
$control['params'][0]['number'] = -1;
$widget_id = $control['id'] = $control['id_base'] . '-' . $multi_number;
$wp_registered_widget_controls[$control['id']] = $control;
break ;
}}}}if ( isset($wp_registered_widget_controls[$widget_id]) && !isset($control))
 {$control = $wp_registered_widget_controls[$widget_id];
$control_callback = $control['callback'];
}elseif ( !isset($wp_registered_widget_controls[$widget_id]) && isset($wp_registered_widgets[$widget_id]))
 {$name = esc_html(strip_tags($wp_registered_widgets[$widget_id]['name']));
}if ( !isset($name))
 $name = esc_html(strip_tags($control['name']));
if ( !isset($sidebar))
 $sidebar = (isset($_GET[0]['sidebar']) && Aspis_isset($_GET[0]['sidebar'])) ? deAspisWarningRC($_GET[0]['sidebar']) : 'wp_inactive_widgets';
if ( !isset($multi_number))
 $multi_number = isset($control['params'][0]['number']) ? $control['params'][0]['number'] : '';
$id_base = isset($control['id_base']) ? $control['id_base'] : $control['id'];
$width = ' style="width:' . max($control['width'],350) . 'px"';
$key = (isset($_GET[0]['key']) && Aspis_isset($_GET[0]['key'])) ? (int)deAspisWarningRC($_GET[0]['key']) : 0;
require_once ('admin-header.php');
;
?>
	<div class="wrap">
	<?php screen_icon();
;
?>
	<h2><?php echo esc_html($title);
;
?></h2>
	<div class="editwidget"<?php echo $width;
;
?>>
	<h3><?php printf(__('Widget %s'),$name);
;
?></h3>

	<form action="widgets.php" method="post">
	<div class="widget-inside">
<?php if ( is_callable($control_callback))
 AspisUntainted_call_user_func_array($control_callback,$control['params']);
else 
{echo '<p>' . __('There are no options for this widget.') . "</p>\n";
};
?>
	</div>

	<p class="describe"><?php _e('Select both the sidebar for this widget and the position of the widget in that sidebar.');
;
?></p>
	<div class="widget-position">
	<table class="widefat"><thead><tr><th><?php _e('Sidebar');
;
?></th><th><?php _e('Position');
;
?></th></tr></thead><tbody>
<?php foreach ( $wp_registered_sidebars as $sbname =>$sbvalue )
{echo "\t\t<tr><td><label><input type='radio' name='sidebar' value='" . esc_attr($sbname) . "'" . checked($sbname,$sidebar,false) . " /> $sbvalue[name]</label></td><td>";
if ( 'wp_inactive_widgets' == $sbname)
 {echo '&nbsp;';
}else 
{{if ( !isset($sidebars_widgets[$sbname]) || !is_array($sidebars_widgets[$sbname]))
 {$j = 1;
$sidebars_widgets[$sbname] = array();
}else 
{{$j = count($sidebars_widgets[$sbname]);
if ( (isset($_GET[0]['addnew']) && Aspis_isset($_GET[0]['addnew'])) || !in_array($widget_id,$sidebars_widgets[$sbname],true))
 $j++;
}}$selected = '';
echo "\t\t<select name='{$sbname}_position'>\n";
echo "\t\t<option value=''>" . __('-- select --') . "</option>\n";
for ( $i = 1 ; $i <= $j ; $i++ )
{if ( in_array($widget_id,$sidebars_widgets[$sbname],true))
 $selected = selected($i,$key + 1,false);
echo "\t\t<option value='$i'$selected> $i </option>\n";
}echo "\t\t</select>\n";
}}echo "</td></tr>\n";
};
?>
	</tbody></table>
	</div>

	<div class="widget-control-actions">
<?php if ( (isset($_GET[0]['addnew']) && Aspis_isset($_GET[0]['addnew'])))
 {;
?>
	<a href="widgets.php" class="button alignleft"><?php _e('Cancel');
;
?></a>
<?php }else 
{{;
?>
	<input type="submit" name="removewidget" class="button alignleft" value="<?php esc_attr_e('Delete');
;
?>" />
<?php }};
?>
	<input type="submit" name="savewidget" class="button-primary alignright" value="<?php esc_attr_e('Save Widget');
;
?>" />
	<input type="hidden" name="widget-id" class="widget-id" value="<?php echo esc_attr($widget_id);
;
?>" />
	<input type="hidden" name="id_base" class="id_base" value="<?php echo esc_attr($id_base);
;
?>" />
	<input type="hidden" name="multi_number" class="multi_number" value="<?php echo esc_attr($multi_number);
;
?>" />
<?php wp_nonce_field("save-delete-widget-$widget_id");
;
?>
	<br class="clear" />
	</div>
	</form>
	</div>
	</div>
<?php require_once ('admin-footer.php');
exit();
}$messages = array(__('Changes saved.'));
$errors = array(__('Error while saving.'),__('Error in displaying the widget settings form.'));
require_once ('admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo esc_html($title);
;
?></h2>

<?php if ( (isset($_GET[0]['message']) && Aspis_isset($_GET[0]['message'])) && isset($messages[deAspisWarningRC($_GET[0]['message'])]))
 {;
?>
<div id="message" class="updated fade"><p><?php echo $messages[deAspisWarningRC($_GET[0]['message'])];
;
?></p></div>
<?php };
?>
<?php if ( (isset($_GET[0]['error']) && Aspis_isset($_GET[0]['error'])) && isset($errors[deAspisWarningRC($_GET[0]['error'])]))
 {;
?>
<div id="message" class="error"><p><?php echo $errors[deAspisWarningRC($_GET[0]['error'])];
;
?></p></div>
<?php };
?>

<div class="widget-liquid-left">
<div id="widgets-left">
	<div id="available-widgets" class="widgets-holder-wrap">
		<div class="sidebar-name">
		<div class="sidebar-name-arrow"><br /></div>
		<h3><?php _e('Available Widgets');
;
?> <span id="removing-widget"><?php _e('Deactivate');
;
?> <span></span></span></h3></div>
		<div class="widget-holder">
		<p class="description"><?php _e('Drag widgets from here to a sidebar on the right to activate them. Drag widgets back here to deactivate them and delete their settings.');
;
?></p>
		<div id="widget-list">
		<?php wp_list_widgets();
;
?>
		</div>
		<br class='clear' />
		</div>
		<br class="clear" />
	</div>

	<div class="widgets-holder-wrap">
		<div class="sidebar-name">
		<div class="sidebar-name-arrow"><br /></div>
		<h3><?php _e('Inactive Widgets');
;
?>
		<span><img src="images/wpspin_light.gif" class="ajax-feedback" title="" alt="" /></span></h3></div>
		<div class="widget-holder inactive">
		<p class="description"><?php _e('Drag widgets here to remove them from the sidebar but keep their settings.');
;
?></p>
		<?php wp_list_widget_controls('wp_inactive_widgets');
;
?>
		<br class="clear" />
		</div>
	</div>
</div>
</div>

<div class="widget-liquid-right">
<div id="widgets-right">
<?php $i = 0;
foreach ( $wp_registered_sidebars as $sidebar =>$registered_sidebar )
{if ( 'wp_inactive_widgets' == $sidebar)
 continue ;
$closed = $i ? ' closed' : '';
;
?>
	<div class="widgets-holder-wrap<?php echo $closed;
;
?>">
	<div class="sidebar-name">
	<div class="sidebar-name-arrow"><br /></div>
	<h3><?php echo esc_html($registered_sidebar['name']);
;
?>
	<span><img src="images/wpspin_dark.gif" class="ajax-feedback" title="" alt="" /></span></h3></div>
	<?php wp_list_widget_controls($sidebar);
;
?>
	</div>
<?php $i++;
};
?>
</div>
</div>
<form action="" method="post">
<?php wp_nonce_field('save-sidebar-widgets','_wpnonce_widgets',false);
;
?>
</form>
<br class="clear" />
</div>

<?php do_action('sidebar_admin_page');
require_once ('admin-footer.php');
