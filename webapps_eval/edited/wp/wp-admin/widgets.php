<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
require_once (deconcat12(ABSPATH,'wp-admin/includes/widgets.php'));
if ( (denot_boolean(current_user_can(array('switch_themes',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
wp_admin_css(array('widgets',false));
$widgets_access = get_user_setting(array('widgets_access',false));
if ( ((isset($_GET[0][('widgets-access')]) && Aspis_isset( $_GET [0][('widgets-access')]))))
 {$widgets_access = (('on') == deAspis($_GET[0]['widgets-access'])) ? array('on',false) : array('off',false);
set_user_setting(array('widgets_access',false),$widgets_access);
}if ( (('on') == $widgets_access[0]))
 add_filter(array('admin_body_class',false),Aspis_create_function(array('',false),array('{return " widgets_access ";}',false)));
else 
{wp_enqueue_script(array('admin-widgets',false));
}do_action(array('sidebar_admin_setup',false));
$title = __(array('Widgets',false));
$parent_file = array('themes.php',false);
register_sidebar(array(array(deregisterTaint(array('name',false)) => addTaint(__(array('Inactive Widgets',false))),'id' => array('wp_inactive_widgets',false,false),'description' => array('',false,false),'before_widget' => array('',false,false),'after_widget' => array('',false,false),'before_title' => array('',false,false),'after_title' => array('',false,false),),false));
$sidebars_widgets = wp_get_sidebars_widgets();
if ( ((empty($sidebars_widgets) || Aspis_empty( $sidebars_widgets))))
 $sidebars_widgets = wp_get_widget_defaults();
function retrieve_widgets (  ) {
global $wp_registered_widget_updates,$wp_registered_sidebars,$sidebars_widgets,$wp_registered_widgets;
$_sidebars_widgets = array(array(),false);
$sidebars = attAspisRC(array_keys(deAspisRC($wp_registered_sidebars)));
unset($sidebars_widgets[0][('array_version')]);
$old = attAspisRC(array_keys(deAspisRC($sidebars_widgets)));
AspisInternalFunctionCall("sort",AspisPushRefParam($old),array(0));
AspisInternalFunctionCall("sort",AspisPushRefParam($sidebars),array(0));
if ( ($old[0] == $sidebars[0]))
 return ;
foreach ( $sidebars[0] as $id  )
{if ( array_key_exists(deAspisRC($id),deAspisRC($sidebars_widgets)))
 {arrayAssign($_sidebars_widgets[0],deAspis(registerTaint($id)),addTaint(attachAspis($sidebars_widgets,$id[0])));
unset($sidebars_widgets[0][$id[0]],$sidebars[0][$id[0]]);
}}if ( (!((empty($sidebars_widgets) || Aspis_empty( $sidebars_widgets)))))
 {foreach ( $sidebars_widgets[0] as $lost =>$val )
{restoreTaint($lost,$val);
{if ( is_array($val[0]))
 arrayAssign($_sidebars_widgets[0],deAspis(registerTaint(array('wp_inactive_widgets',false))),addTaint(Aspis_array_merge(array_cast($_sidebars_widgets[0]['wp_inactive_widgets']),$val)));
}}}$shown_widgets = array(array(),false);
foreach ( $_sidebars_widgets[0] as $sidebar =>$widgets )
{restoreTaint($sidebar,$widgets);
{if ( (!(is_array($widgets[0]))))
 continue ;
$_widgets = array(array(),false);
foreach ( $widgets[0] as $widget  )
{if ( ((isset($wp_registered_widgets[0][$widget[0]]) && Aspis_isset( $wp_registered_widgets [0][$widget[0]]))))
 arrayAssignAdd($_widgets[0][],addTaint($widget));
}arrayAssign($_sidebars_widgets[0],deAspis(registerTaint($sidebar)),addTaint($_widgets));
$shown_widgets = Aspis_array_merge($shown_widgets,$_widgets);
}}$sidebars_widgets = $_sidebars_widgets;
unset($_sidebars_widgets,$_widgets);
$lost_widgets = array(array(),false);
foreach ( $wp_registered_widgets[0] as $key =>$val )
{restoreTaint($key,$val);
{if ( deAspis(Aspis_in_array($key,$shown_widgets,array(true,false))))
 continue ;
$number = Aspis_preg_replace(array('/.+?-([0-9]+)$/',false),array('$1',false),$key);
if ( ((2) > deAspis(int_cast($number))))
 continue ;
arrayAssignAdd($lost_widgets[0][],addTaint($key));
}}arrayAssign($sidebars_widgets[0],deAspis(registerTaint(array('wp_inactive_widgets',false))),addTaint(Aspis_array_merge($lost_widgets,array_cast($sidebars_widgets[0]['wp_inactive_widgets']))));
wp_set_sidebars_widgets($sidebars_widgets);
 }
retrieve_widgets();
if ( (count($wp_registered_sidebars[0]) == (1)))
 {require_once ('admin-header.php');
;
?>

	<div class="wrap">
	<?php screen_icon();
;
?>
	<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>
		<div class="error">
			<p><?php _e(array('No Sidebars Defined',false));
;
?></p>
		</div>
		<p><?php _e(array('The theme you are currently using isn&#8217;t widget-aware, meaning that it has no sidebars that you are able to change. For information on making your theme widget-aware, please <a href="http://codex.wordpress.org/Widgetizing_Themes">follow these instructions</a>.',false));
;
?></p>
	</div>

<?php require_once ('admin-footer.php');
Aspis_exit();
}if ( (((isset($_POST[0][('savewidget')]) && Aspis_isset( $_POST [0][('savewidget')]))) || ((isset($_POST[0][('removewidget')]) && Aspis_isset( $_POST [0][('removewidget')])))))
 {$widget_id = $_POST[0]['widget-id'];
check_admin_referer(concat1("save-delete-widget-",$widget_id));
$number = ((isset($_POST[0][('multi_number')]) && Aspis_isset( $_POST [0][('multi_number')]))) ? int_cast($_POST[0]['multi_number']) : array('',false);
if ( $number[0])
 {foreach ( $_POST[0] as $key =>$val )
{restoreTaint($key,$val);
{if ( (is_array($val[0]) && deAspis(Aspis_preg_match(array('/__i__|%i%/',false),Aspis_key($val)))))
 {arrayAssign($_POST[0],deAspis(registerTaint($key)),addTaint(array(array(deregisterTaint($number) => addTaint(Aspis_array_shift($val))),false)));
break ;
}}}}$sidebar_id = $_POST[0]['sidebar'];
$position = ((isset($_POST[0][(deconcat2($sidebar_id,'_position'))]) && Aspis_isset( $_POST [0][(deconcat2($sidebar_id,'_position'))]))) ? array(deAspis(int_cast(attachAspis($_POST,(deconcat2($sidebar_id,'_position'))))) - (1),false) : array(0,false);
$id_base = $_POST[0]['id_base'];
$sidebar = ((isset($sidebars_widgets[0][$sidebar_id[0]]) && Aspis_isset( $sidebars_widgets [0][$sidebar_id[0]]))) ? attachAspis($sidebars_widgets,$sidebar_id[0]) : array(array(),false);
if ( (((isset($_POST[0][('removewidget')]) && Aspis_isset( $_POST [0][('removewidget')]))) && deAspis($_POST[0]['removewidget'])))
 {if ( (denot_boolean(Aspis_in_array($widget_id,$sidebar,array(true,false)))))
 {wp_redirect(array('widgets.php?error=0',false));
Aspis_exit();
}$sidebar = Aspis_array_diff($sidebar,array(array($widget_id),false));
$_POST = array(array(deregisterTaint(array('sidebar',false)) => addTaint($sidebar_id),deregisterTaint(concat1('widget-',$id_base)) => addTaint(array(array(),false)),deregisterTaint(array('the-widget-id',false)) => addTaint($widget_id),'delete_widget' => array('1',false,false)),false);
}arrayAssign($_POST[0],deAspis(registerTaint(array('widget-id',false))),addTaint($sidebar));
foreach ( deAspis(array_cast($wp_registered_widget_updates)) as $name =>$control )
{restoreTaint($name,$control);
{if ( (($name[0] != $id_base[0]) || (!(is_callable(deAspisRC($control[0]['callback']))))))
 continue ;
ob_start();
Aspis_call_user_func_array($control[0]['callback'],$control[0]['params']);
ob_end_clean();
break ;
}}arrayAssign($sidebars_widgets[0],deAspis(registerTaint($sidebar_id)),addTaint($sidebar));
if ( (!((isset($_POST[0][('delete_widget')]) && Aspis_isset( $_POST [0][('delete_widget')])))))
 {foreach ( $sidebars_widgets[0] as $key =>$sb )
{restoreTaint($key,$sb);
{if ( is_array($sb[0]))
 arrayAssign($sidebars_widgets[0],deAspis(registerTaint($key)),addTaint(Aspis_array_diff($sb,array(array($widget_id),false))));
}}Aspis_array_splice(attachAspis($sidebars_widgets,$sidebar_id[0]),$position,array(0,false),$widget_id);
}wp_set_sidebars_widgets($sidebars_widgets);
wp_redirect(array('widgets.php?message=0',false));
Aspis_exit();
}if ( (((isset($_GET[0][('editwidget')]) && Aspis_isset( $_GET [0][('editwidget')]))) && deAspis($_GET[0]['editwidget'])))
 {$widget_id = $_GET[0]['editwidget'];
if ( ((isset($_GET[0][('addnew')]) && Aspis_isset( $_GET [0][('addnew')]))))
 {$sidebar = Aspis_array_shift($keys = attAspisRC(array_keys(deAspisRC($wp_registered_sidebars))));
if ( (((isset($_GET[0][('base')]) && Aspis_isset( $_GET [0][('base')]))) && ((isset($_GET[0][('num')]) && Aspis_isset( $_GET [0][('num')])))))
 {foreach ( $wp_registered_widget_controls[0] as $control  )
{if ( (deAspis($_GET[0]['base']) === deAspis($control[0]['id_base'])))
 {$control_callback = $control[0]['callback'];
$multi_number = int_cast($_GET[0]['num']);
arrayAssign($control[0][('params')][0][(0)][0],deAspis(registerTaint(array('number',false))),addTaint(negate(array(1,false))));
$widget_id = arrayAssign($control[0],deAspis(registerTaint(array('id',false))),addTaint(concat(concat2($control[0]['id_base'],'-'),$multi_number)));
arrayAssign($wp_registered_widget_controls[0],deAspis(registerTaint($control[0]['id'])),addTaint($control));
break ;
}}}}if ( (((isset($wp_registered_widget_controls[0][$widget_id[0]]) && Aspis_isset( $wp_registered_widget_controls [0][$widget_id[0]]))) && (!((isset($control) && Aspis_isset( $control))))))
 {$control = attachAspis($wp_registered_widget_controls,$widget_id[0]);
$control_callback = $control[0]['callback'];
}elseif ( ((!((isset($wp_registered_widget_controls[0][$widget_id[0]]) && Aspis_isset( $wp_registered_widget_controls [0][$widget_id[0]])))) && ((isset($wp_registered_widgets[0][$widget_id[0]]) && Aspis_isset( $wp_registered_widgets [0][$widget_id[0]])))))
 {$name = esc_html(Aspis_strip_tags($wp_registered_widgets[0][$widget_id[0]][0]['name']));
}if ( (!((isset($name) && Aspis_isset( $name)))))
 $name = esc_html(Aspis_strip_tags($control[0]['name']));
if ( (!((isset($sidebar) && Aspis_isset( $sidebar)))))
 $sidebar = ((isset($_GET[0][('sidebar')]) && Aspis_isset( $_GET [0][('sidebar')]))) ? $_GET[0]['sidebar'] : array('wp_inactive_widgets',false);
if ( (!((isset($multi_number) && Aspis_isset( $multi_number)))))
 $multi_number = ((isset($control[0][('params')][0][(0)][0][('number')]) && Aspis_isset( $control [0][('params')] [0][(0)] [0][('number')]))) ? $control[0][('params')][0][(0)][0]['number'] : array('',false);
$id_base = ((isset($control[0][('id_base')]) && Aspis_isset( $control [0][('id_base')]))) ? $control[0]['id_base'] : $control[0]['id'];
$width = concat2(concat1(' style="width:',attAspisRC(max(deAspisRC($control[0]['width']),350))),'px"');
$key = ((isset($_GET[0][('key')]) && Aspis_isset( $_GET [0][('key')]))) ? int_cast($_GET[0]['key']) : array(0,false);
require_once ('admin-header.php');
;
?>
	<div class="wrap">
	<?php screen_icon();
;
?>
	<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>
	<div class="editwidget"<?php echo AspisCheckPrint($width);
;
?>>
	<h3><?php printf(deAspis(__(array('Widget %s',false))),deAspisRC($name));
;
?></h3>

	<form action="widgets.php" method="post">
	<div class="widget-inside">
<?php if ( is_callable(deAspisRC($control_callback)))
 Aspis_call_user_func_array($control_callback,$control[0]['params']);
else 
{echo AspisCheckPrint(concat2(concat1('<p>',__(array('There are no options for this widget.',false))),"</p>\n"));
};
?>
	</div>

	<p class="describe"><?php _e(array('Select both the sidebar for this widget and the position of the widget in that sidebar.',false));
;
?></p>
	<div class="widget-position">
	<table class="widefat"><thead><tr><th><?php _e(array('Sidebar',false));
;
?></th><th><?php _e(array('Position',false));
;
?></th></tr></thead><tbody>
<?php foreach ( $wp_registered_sidebars[0] as $sbname =>$sbvalue )
{restoreTaint($sbname,$sbvalue);
{echo AspisCheckPrint(concat(concat(concat2(concat1("\t\t<tr><td><label><input type='radio' name='sidebar' value='",esc_attr($sbname)),"'"),checked($sbname,$sidebar,array(false,false))),concat2(concat1(" /> ",attachAspis($sbvalue,name)),"</label></td><td>")));
if ( (('wp_inactive_widgets') == $sbname[0]))
 {echo AspisCheckPrint(array('&nbsp;',false));
}else 
{{if ( ((!((isset($sidebars_widgets[0][$sbname[0]]) && Aspis_isset( $sidebars_widgets [0][$sbname[0]])))) || (!(is_array(deAspis(attachAspis($sidebars_widgets,$sbname[0])))))))
 {$j = array(1,false);
arrayAssign($sidebars_widgets[0],deAspis(registerTaint($sbname)),addTaint(array(array(),false)));
}else 
{{$j = attAspis(count(deAspis(attachAspis($sidebars_widgets,$sbname[0]))));
if ( (((isset($_GET[0][('addnew')]) && Aspis_isset( $_GET [0][('addnew')]))) || (denot_boolean(Aspis_in_array($widget_id,attachAspis($sidebars_widgets,$sbname[0]),array(true,false))))))
 postincr($j);
}}$selected = array('',false);
echo AspisCheckPrint(concat2(concat1("\t\t<select name='",$sbname),"_position'>\n"));
echo AspisCheckPrint(concat2(concat1("\t\t<option value=''>",__(array('-- select --',false))),"</option>\n"));
for ( $i = array(1,false) ; ($i[0] <= $j[0]) ; postincr($i) )
{if ( deAspis(Aspis_in_array($widget_id,attachAspis($sidebars_widgets,$sbname[0]),array(true,false))))
 $selected = selected($i,array($key[0] + (1),false),array(false,false));
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1("\t\t<option value='",$i),"'"),$selected),"> "),$i)," </option>\n"));
}echo AspisCheckPrint(array("\t\t</select>\n",false));
}}echo AspisCheckPrint(array("</td></tr>\n",false));
}};
?>
	</tbody></table>
	</div>

	<div class="widget-control-actions">
<?php if ( ((isset($_GET[0][('addnew')]) && Aspis_isset( $_GET [0][('addnew')]))))
 {;
?>
	<a href="widgets.php" class="button alignleft"><?php _e(array('Cancel',false));
;
?></a>
<?php }else 
{{;
?>
	<input type="submit" name="removewidget" class="button alignleft" value="<?php esc_attr_e(array('Delete',false));
;
?>" />
<?php }};
?>
	<input type="submit" name="savewidget" class="button-primary alignright" value="<?php esc_attr_e(array('Save Widget',false));
;
?>" />
	<input type="hidden" name="widget-id" class="widget-id" value="<?php echo AspisCheckPrint(esc_attr($widget_id));
;
?>" />
	<input type="hidden" name="id_base" class="id_base" value="<?php echo AspisCheckPrint(esc_attr($id_base));
;
?>" />
	<input type="hidden" name="multi_number" class="multi_number" value="<?php echo AspisCheckPrint(esc_attr($multi_number));
;
?>" />
<?php wp_nonce_field(concat1("save-delete-widget-",$widget_id));
;
?>
	<br class="clear" />
	</div>
	</form>
	</div>
	</div>
<?php require_once ('admin-footer.php');
Aspis_exit();
}$messages = array(array(__(array('Changes saved.',false))),false);
$errors = array(array(__(array('Error while saving.',false)),__(array('Error in displaying the widget settings form.',false))),false);
require_once ('admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<?php if ( (((isset($_GET[0][('message')]) && Aspis_isset( $_GET [0][('message')]))) && ((isset($messages[0][deAspis($_GET[0]['message'])]) && Aspis_isset( $messages [0][deAspis($_GET [0]['message'])])))))
 {;
?>
<div id="message" class="updated fade"><p><?php echo AspisCheckPrint(attachAspis($messages,deAspis($_GET[0]['message'])));
;
?></p></div>
<?php };
?>
<?php if ( (((isset($_GET[0][('error')]) && Aspis_isset( $_GET [0][('error')]))) && ((isset($errors[0][deAspis($_GET[0]['error'])]) && Aspis_isset( $errors [0][deAspis($_GET [0]['error'])])))))
 {;
?>
<div id="message" class="error"><p><?php echo AspisCheckPrint(attachAspis($errors,deAspis($_GET[0]['error'])));
;
?></p></div>
<?php };
?>

<div class="widget-liquid-left">
<div id="widgets-left">
	<div id="available-widgets" class="widgets-holder-wrap">
		<div class="sidebar-name">
		<div class="sidebar-name-arrow"><br /></div>
		<h3><?php _e(array('Available Widgets',false));
;
?> <span id="removing-widget"><?php _e(array('Deactivate',false));
;
?> <span></span></span></h3></div>
		<div class="widget-holder">
		<p class="description"><?php _e(array('Drag widgets from here to a sidebar on the right to activate them. Drag widgets back here to deactivate them and delete their settings.',false));
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
		<h3><?php _e(array('Inactive Widgets',false));
;
?>
		<span><img src="images/wpspin_light.gif" class="ajax-feedback" title="" alt="" /></span></h3></div>
		<div class="widget-holder inactive">
		<p class="description"><?php _e(array('Drag widgets here to remove them from the sidebar but keep their settings.',false));
;
?></p>
		<?php wp_list_widget_controls(array('wp_inactive_widgets',false));
;
?>
		<br class="clear" />
		</div>
	</div>
</div>
</div>

<div class="widget-liquid-right">
<div id="widgets-right">
<?php $i = array(0,false);
foreach ( $wp_registered_sidebars[0] as $sidebar =>$registered_sidebar )
{restoreTaint($sidebar,$registered_sidebar);
{if ( (('wp_inactive_widgets') == $sidebar[0]))
 continue ;
$closed = $i[0] ? array(' closed',false) : array('',false);
;
?>
	<div class="widgets-holder-wrap<?php echo AspisCheckPrint($closed);
;
?>">
	<div class="sidebar-name">
	<div class="sidebar-name-arrow"><br /></div>
	<h3><?php echo AspisCheckPrint(esc_html($registered_sidebar[0]['name']));
;
?>
	<span><img src="images/wpspin_dark.gif" class="ajax-feedback" title="" alt="" /></span></h3></div>
	<?php wp_list_widget_controls($sidebar);
;
?>
	</div>
<?php postincr($i);
}};
?>
</div>
</div>
<form action="" method="post">
<?php wp_nonce_field(array('save-sidebar-widgets',false),array('_wpnonce_widgets',false),array(false,false));
;
?>
</form>
<br class="clear" />
</div>

<?php do_action(array('sidebar_admin_page',false));
require_once ('admin-footer.php');
