<?php require_once('AspisMain.php'); ?><?php
function wp_list_widgets (  ) {
global $wp_registered_widgets,$sidebars_widgets,$wp_registered_widget_controls;
$sort = $wp_registered_widgets;
Aspis_usort($sort,Aspis_create_function(array('$a, $b',false),array('return strnatcasecmp( $a["name"], $b["name"] );',false)));
$done = array(array(),false);
foreach ( $sort[0] as $widget  )
{if ( deAspis(Aspis_in_array($widget[0]['callback'],$done,array(true,false))))
 continue ;
$sidebar = is_active_widget($widget[0]['callback'],$widget[0]['id'],array(false,false),array(false,false));
arrayAssignAdd($done[0][],addTaint($widget[0]['callback']));
if ( (!((isset($widget[0][('params')][0][(0)]) && Aspis_isset( $widget [0][('params')] [0][(0)])))))
 arrayAssign($widget[0][('params')][0],deAspis(registerTaint(array(0,false))),addTaint(array(array(),false)));
$args = array(array(deregisterTaint(array('widget_id',false)) => addTaint($widget[0]['id']),deregisterTaint(array('widget_name',false)) => addTaint($widget[0]['name']),'_display' => array('template',false,false)),false);
if ( (((isset($wp_registered_widget_controls[0][deAspis($widget[0]['id'])][0][('id_base')]) && Aspis_isset( $wp_registered_widget_controls [0][deAspis($widget [0]['id'])] [0][('id_base')]))) && ((isset($widget[0][('params')][0][(0)][0][('number')]) && Aspis_isset( $widget [0][('params')] [0][(0)] [0][('number')])))))
 {$id_base = $wp_registered_widget_controls[0][deAspis($widget[0]['id'])][0]['id_base'];
arrayAssign($args[0],deAspis(registerTaint(array('_temp_id',false))),addTaint(concat2($id_base,"-__i__")));
arrayAssign($args[0],deAspis(registerTaint(array('_multi_num',false))),addTaint(next_widget_id_number($id_base)));
arrayAssign($args[0],deAspis(registerTaint(array('_add',false))),addTaint(array('multi',false)));
}else 
{{arrayAssign($args[0],deAspis(registerTaint(array('_add',false))),addTaint(array('single',false)));
if ( $sidebar[0])
 arrayAssign($args[0],deAspis(registerTaint(array('_hide',false))),addTaint(array('1',false)));
}}$args = wp_list_widget_controls_dynamic_sidebar(array(array(deregisterTaint(array(0,false)) => addTaint($args),deregisterTaint(array(1,false)) => addTaint(attachAspis($widget[0][('params')],(0)))),false));
Aspis_call_user_func_array(array('wp_widget_control',false),$args);
} }
function wp_list_widget_controls ( $sidebar ) {
add_filter(array('dynamic_sidebar_params',false),array('wp_list_widget_controls_dynamic_sidebar',false));
echo AspisCheckPrint(concat2(concat1("<div id='",$sidebar),"' class='widgets-sortables'>\n"));
$description = wp_sidebar_description($sidebar);
if ( (!((empty($description) || Aspis_empty( $description)))))
 {echo AspisCheckPrint(array("<div class='sidebar-description'>\n",false));
echo AspisCheckPrint(concat2(concat1("\t<p class='description'>",$description),"</p>"));
echo AspisCheckPrint(array("</div>\n",false));
}dynamic_sidebar($sidebar);
echo AspisCheckPrint(array("</div>\n",false));
 }
function wp_list_widget_controls_dynamic_sidebar ( $params ) {
global $wp_registered_widgets;
static $i = array(0,false);
postincr($i);
$widget_id = $params[0][(0)][0]['widget_id'];
$id = ((isset($params[0][(0)][0][('_temp_id')]) && Aspis_isset( $params [0][(0)] [0][('_temp_id')]))) ? $params[0][(0)][0]['_temp_id'] : $widget_id;
$hidden = ((isset($params[0][(0)][0][('_hide')]) && Aspis_isset( $params [0][(0)] [0][('_hide')]))) ? array(' style="display:none;"',false) : array('',false);
arrayAssign($params[0][(0)][0],deAspis(registerTaint(array('before_widget',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<div id='widget-",$i),"_"),$id),"' class='widget'"),$hidden),">")));
arrayAssign($params[0][(0)][0],deAspis(registerTaint(array('after_widget',false))),addTaint(array("</div>",false)));
arrayAssign($params[0][(0)][0],deAspis(registerTaint(array('before_title',false))),addTaint(array("%BEG_OF_TITLE%",false)));
arrayAssign($params[0][(0)][0],deAspis(registerTaint(array('after_title',false))),addTaint(array("%END_OF_TITLE%",false)));
if ( is_callable(deAspisRC($wp_registered_widgets[0][$widget_id[0]][0]['callback'])))
 {arrayAssign($wp_registered_widgets[0][$widget_id[0]][0],deAspis(registerTaint(array('_callback',false))),addTaint($wp_registered_widgets[0][$widget_id[0]][0]['callback']));
arrayAssign($wp_registered_widgets[0][$widget_id[0]][0],deAspis(registerTaint(array('callback',false))),addTaint(array('wp_widget_control',false)));
}return $params;
 }
function next_widget_id_number ( $id_base ) {
global $wp_registered_widgets;
$number = array(1,false);
foreach ( $wp_registered_widgets[0] as $widget_id =>$widget )
{restoreTaint($widget_id,$widget);
{if ( deAspis(Aspis_preg_match(concat2(concat1('/',$id_base),'-([0-9]+)$/'),$widget_id,$matches)))
 $number = attAspisRC(max(deAspisRC($number),deAspisRC(attachAspis($matches,(1)))));
}}postincr($number);
return $number;
 }
function wp_widget_control ( $sidebar_args ) {
global $wp_registered_widgets,$wp_registered_widget_controls,$sidebars_widgets;
$widget_id = $sidebar_args[0]['widget_id'];
$sidebar_id = ((isset($sidebar_args[0][('id')]) && Aspis_isset( $sidebar_args [0][('id')]))) ? $sidebar_args[0]['id'] : array(false,false);
$key = $sidebar_id[0] ? Aspis_array_search($widget_id,attachAspis($sidebars_widgets,$sidebar_id[0])) : array('-1',false);
$control = ((isset($wp_registered_widget_controls[0][$widget_id[0]]) && Aspis_isset( $wp_registered_widget_controls [0][$widget_id[0]]))) ? attachAspis($wp_registered_widget_controls,$widget_id[0]) : array(array(),false);
$widget = attachAspis($wp_registered_widgets,$widget_id[0]);
$id_format = $widget[0]['id'];
$widget_number = ((isset($control[0][('params')][0][(0)][0][('number')]) && Aspis_isset( $control [0][('params')] [0][(0)] [0][('number')]))) ? $control[0][('params')][0][(0)][0]['number'] : array('',false);
$id_base = ((isset($control[0][('id_base')]) && Aspis_isset( $control [0][('id_base')]))) ? $control[0]['id_base'] : $widget_id;
$multi_number = ((isset($sidebar_args[0][('_multi_num')]) && Aspis_isset( $sidebar_args [0][('_multi_num')]))) ? $sidebar_args[0]['_multi_num'] : array('',false);
$add_new = ((isset($sidebar_args[0][('_add')]) && Aspis_isset( $sidebar_args [0][('_add')]))) ? $sidebar_args[0]['_add'] : array('',false);
$query_arg = array(array(deregisterTaint(array('editwidget',false)) => addTaint($widget[0]['id'])),false);
if ( $add_new[0])
 {arrayAssign($query_arg[0],deAspis(registerTaint(array('addnew',false))),addTaint(array(1,false)));
if ( $multi_number[0])
 {arrayAssign($query_arg[0],deAspis(registerTaint(array('num',false))),addTaint($multi_number));
arrayAssign($query_arg[0],deAspis(registerTaint(array('base',false))),addTaint($id_base));
}}else 
{{arrayAssign($query_arg[0],deAspis(registerTaint(array('sidebar',false))),addTaint($sidebar_id));
arrayAssign($query_arg[0],deAspis(registerTaint(array('key',false))),addTaint($key));
}}if ( ((((isset($sidebar_args[0][('_display')]) && Aspis_isset( $sidebar_args [0][('_display')]))) && (('template') == deAspis($sidebar_args[0]['_display']))) && $widget_number[0]))
 {arrayAssign($control[0][('params')][0][(0)][0],deAspis(registerTaint(array('number',false))),addTaint(negate(array(1,false))));
if ( ((isset($control[0][('id_base')]) && Aspis_isset( $control [0][('id_base')]))))
 $id_format = concat2($control[0]['id_base'],'-__i__');
}arrayAssign($wp_registered_widgets[0][$widget_id[0]][0],deAspis(registerTaint(array('callback',false))),addTaint($wp_registered_widgets[0][$widget_id[0]][0]['_callback']));
unset($wp_registered_widgets[0][$widget_id[0]][0][('_callback')]);
$widget_title = esc_html(Aspis_strip_tags($sidebar_args[0]['widget_name']));
$has_form = array('noform',false);
echo AspisCheckPrint($sidebar_args[0]['before_widget']);
;
?>
	<div class="widget-top">
	<div class="widget-title-action">
		<a class="widget-action hide-if-no-js" href="#available-widgets"></a>
		<a class="widget-control-edit hide-if-js" href="<?php echo AspisCheckPrint(esc_url(add_query_arg($query_arg)));
;
?>"><span class="edit"><?php _e(array('Edit',false));
;
?></span><span class="add"><?php _e(array('Add',false));
;
?></span></a>
	</div>
	<div class="widget-title"><h4><?php echo AspisCheckPrint($widget_title);
?><span class="in-widget-title"></span></h4></div>
	</div>

	<div class="widget-inside">
	<form action="" method="post">
	<div class="widget-content">
<?php if ( ((isset($control[0][('callback')]) && Aspis_isset( $control [0][('callback')]))))
 $has_form = Aspis_call_user_func_array($control[0]['callback'],$control[0]['params']);
else 
{echo AspisCheckPrint(concat2(concat1("\t\t<p>",__(array('There are no options for this widget.',false))),"</p>\n"));
};
?>
	</div>
	<input type="hidden" name="widget-id" class="widget-id" value="<?php echo AspisCheckPrint(esc_attr($id_format));
;
?>" />
	<input type="hidden" name="id_base" class="id_base" value="<?php echo AspisCheckPrint(esc_attr($id_base));
;
?>" />
	<input type="hidden" name="widget-width" class="widget-width" value="<?php if ( ((isset($control[0][('width')]) && Aspis_isset( $control [0][('width')]))))
 echo AspisCheckPrint(esc_attr($control[0]['width']));
;
?>" />
	<input type="hidden" name="widget-height" class="widget-height" value="<?php if ( ((isset($control[0][('height')]) && Aspis_isset( $control [0][('height')]))))
 echo AspisCheckPrint(esc_attr($control[0]['height']));
;
?>" />
	<input type="hidden" name="widget_number" class="widget_number" value="<?php echo AspisCheckPrint(esc_attr($widget_number));
;
?>" />
	<input type="hidden" name="multi_number" class="multi_number" value="<?php echo AspisCheckPrint(esc_attr($multi_number));
;
?>" />
	<input type="hidden" name="add_new" class="add_new" value="<?php echo AspisCheckPrint(esc_attr($add_new));
;
?>" />

	<div class="widget-control-actions">
		<div class="alignleft">
		<a class="widget-control-remove" href="#remove"><?php _e(array('Delete',false));
;
?></a> |
		<a class="widget-control-close" href="#close"><?php _e(array('Close',false));
;
?></a>
		</div>
		<div class="alignright<?php if ( (('noform') === $has_form[0]))
 echo AspisCheckPrint(array(' widget-control-noform',false));
;
?>">
		<img src="images/wpspin_light.gif" class="ajax-feedback " title="" alt="" />
		<input type="submit" name="savewidget" class="button-primary widget-control-save" value="<?php esc_attr_e(array('Save',false));
;
?>" />
		</div>
		<br class="clear" />
	</div>
	</form>
	</div>

	<div class="widget-description">
<?php echo AspisCheckPrint(deAspis(($widget_description = wp_widget_description($widget_id))) ? concat2($widget_description,"\n") : concat2($widget_title,"\n"));
;
?>
	</div>
<?php echo AspisCheckPrint($sidebar_args[0]['after_widget']);
return $sidebar_args;
 }
