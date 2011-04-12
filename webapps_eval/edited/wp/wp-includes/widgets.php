<?php require_once('AspisMain.php'); ?><?php
class WP_Widget{var $id_base;
var $name;
var $widget_options;
var $control_options;
var $number = array(false,false);
var $id = array(false,false);
var $updated = array(false,false);
function widget ( $args,$instance ) {
{Aspis_exit(array('function WP_Widget::widget() must be over-ridden in a sub-class.',false));
} }
function update ( $new_instance,$old_instance ) {
{return $new_instance;
} }
function form ( $instance ) {
{echo AspisCheckPrint(concat2(concat1('<p class="no-options-widget">',__(array('There are no options for this widget.',false))),'</p>'));
return array('noform',false);
} }
function WP_Widget ( $id_base = array(false,false),$name,$widget_options = array(array(),false),$control_options = array(array(),false) ) {
{$this->__construct($id_base,$name,$widget_options,$control_options);
} }
function __construct ( $id_base = array(false,false),$name,$widget_options = array(array(),false),$control_options = array(array(),false) ) {
{$this->id_base = ((empty($id_base) || Aspis_empty( $id_base))) ? Aspis_preg_replace(array('/(wp_)?widget_/',false),array('',false),Aspis_strtolower(attAspis(get_class(deAspisRC(array($this,false)))))) : Aspis_strtolower($id_base);
$this->name = $name;
$this->option_name = concat1('widget_',$this->id_base);
$this->widget_options = wp_parse_args($widget_options,array(array(deregisterTaint(array('classname',false)) => addTaint($this->option_name)),false));
$this->control_options = wp_parse_args($control_options,array(array(deregisterTaint(array('id_base',false)) => addTaint($this->id_base)),false));
} }
function get_field_name ( $field_name ) {
{return concat2(concat(concat2(concat(concat2(concat1('widget-',$this->id_base),'['),$this->number),']['),$field_name),']');
} }
function get_field_id ( $field_name ) {
{return concat(concat2(concat(concat2(concat1('widget-',$this->id_base),'-'),$this->number),'-'),$field_name);
} }
function _register (  ) {
{$settings = $this->get_settings();
$empty = array(true,false);
if ( is_array($settings[0]))
 {foreach ( deAspis(attAspisRC(array_keys(deAspisRC($settings)))) as $number  )
{if ( is_numeric(deAspisRC($number)))
 {$this->_set($number);
$this->_register_one($number);
$empty = array(false,false);
}}}if ( $empty[0])
 {$this->_set(array(1,false));
$this->_register_one();
}} }
function _set ( $number ) {
{$this->number = $number;
$this->id = concat(concat2($this->id_base,'-'),$number);
} }
function _get_display_callback (  ) {
{return array(array(array($this,false),array('display_callback',false)),false);
} }
function _get_update_callback (  ) {
{return array(array(array($this,false),array('update_callback',false)),false);
} }
function _get_form_callback (  ) {
{return array(array(array($this,false),array('form_callback',false)),false);
} }
function display_callback ( $args,$widget_args = array(1,false) ) {
{if ( is_numeric(deAspisRC($widget_args)))
 $widget_args = array(array(deregisterTaint(array('number',false)) => addTaint($widget_args)),false);
$widget_args = wp_parse_args($widget_args,array(array(deregisterTaint(array('number',false)) => addTaint(negate(array(1,false)))),false));
$this->_set($widget_args[0]['number']);
$instance = $this->get_settings();
if ( array_key_exists(deAspisRC($this->number),deAspisRC($instance)))
 {$instance = attachAspis($instance,$this->number[0]);
$instance = apply_filters(array('widget_display_callback',false),$instance,array($this,false),$args);
if ( (false !== $instance[0]))
 $this->widget($args,$instance);
}} }
function update_callback ( $widget_args = array(1,false) ) {
{global $wp_registered_widgets;
if ( is_numeric(deAspisRC($widget_args)))
 $widget_args = array(array(deregisterTaint(array('number',false)) => addTaint($widget_args)),false);
$widget_args = wp_parse_args($widget_args,array(array(deregisterTaint(array('number',false)) => addTaint(negate(array(1,false)))),false));
$all_instances = $this->get_settings();
if ( $this->updated[0])
 return ;
$sidebars_widgets = wp_get_sidebars_widgets();
if ( (((isset($_POST[0][('delete_widget')]) && Aspis_isset( $_POST [0][('delete_widget')]))) && deAspis($_POST[0]['delete_widget'])))
 {if ( ((isset($_POST[0][('the-widget-id')]) && Aspis_isset( $_POST [0][('the-widget-id')]))))
 $del_id = $_POST[0]['the-widget-id'];
else 
{return ;
}if ( ((isset($wp_registered_widgets[0][$del_id[0]][0][('params')][0][(0)][0][('number')]) && Aspis_isset( $wp_registered_widgets [0][$del_id[0]] [0][('params')] [0][(0)] [0][('number')]))))
 {$number = $wp_registered_widgets[0][$del_id[0]][0][('params')][0][(0)][0]['number'];
if ( ((deconcat(concat2($this->id_base,'-'),$number)) == $del_id[0]))
 unset($all_instances[0][$number[0]]);
}}else 
{{if ( (((isset($_POST[0][(deconcat1('widget-',$this->id_base))]) && Aspis_isset( $_POST [0][(deconcat1('widget-',$this ->id_base ))]))) && is_array(deAspis(attachAspis($_POST,(deconcat1('widget-',$this->id_base)))))))
 {$settings = attachAspis($_POST,(deconcat1('widget-',$this->id_base)));
}elseif ( (((isset($_POST[0][('id_base')]) && Aspis_isset( $_POST [0][('id_base')]))) && (deAspis($_POST[0]['id_base']) == $this->id_base[0])))
 {$num = deAspis($_POST[0]['multi_number']) ? int_cast($_POST[0]['multi_number']) : int_cast($_POST[0]['widget_number']);
$settings = array(array(deregisterTaint($num) => addTaint(array(array(),false))),false);
}else 
{{return ;
}}foreach ( $settings[0] as $number =>$new_instance )
{restoreTaint($number,$new_instance);
{$new_instance = stripslashes_deep($new_instance);
$this->_set($number);
$old_instance = ((isset($all_instances[0][$number[0]]) && Aspis_isset( $all_instances [0][$number[0]]))) ? attachAspis($all_instances,$number[0]) : array(array(),false);
$instance = $this->update($new_instance,$old_instance);
$instance = apply_filters(array('widget_update_callback',false),$instance,$new_instance,$old_instance,array($this,false));
if ( (false !== $instance[0]))
 arrayAssign($all_instances[0],deAspis(registerTaint($number)),addTaint($instance));
break ;
}}}}$this->save_settings($all_instances);
$this->updated = array(true,false);
} }
function form_callback ( $widget_args = array(1,false) ) {
{if ( is_numeric(deAspisRC($widget_args)))
 $widget_args = array(array(deregisterTaint(array('number',false)) => addTaint($widget_args)),false);
$widget_args = wp_parse_args($widget_args,array(array(deregisterTaint(array('number',false)) => addTaint(negate(array(1,false)))),false));
$all_instances = $this->get_settings();
if ( (deAspis(negate(array(1,false))) == deAspis($widget_args[0]['number'])))
 {$this->_set(array('__i__',false));
$instance = array(array(),false);
}else 
{{$this->_set($widget_args[0]['number']);
$instance = attachAspis($all_instances,deAspis($widget_args[0]['number']));
}}$instance = apply_filters(array('widget_form_callback',false),$instance,array($this,false));
$return = array(null,false);
if ( (false !== $instance[0]))
 {$return = $this->form($instance);
do_action_ref_array(array('in_widget_form',false),array(array(array($this,false),&$return,$instance),false));
}return $return;
} }
function _register_one ( $number = array(-1,false) ) {
{wp_register_sidebar_widget($this->id,$this->name,$this->_get_display_callback(),$this->widget_options,array(array(deregisterTaint(array('number',false)) => addTaint($number)),false));
_register_widget_update_callback($this->id_base,$this->_get_update_callback(),$this->control_options,array(array(deregisterTaint(array('number',false)) => addTaint(negate(array(1,false)))),false));
_register_widget_form_callback($this->id,$this->name,$this->_get_form_callback(),$this->control_options,array(array(deregisterTaint(array('number',false)) => addTaint($number)),false));
} }
function save_settings ( $settings ) {
{arrayAssign($settings[0],deAspis(registerTaint(array('_multiwidget',false))),addTaint(array(1,false)));
update_option($this->option_name,$settings);
} }
function get_settings (  ) {
{$settings = get_option($this->option_name);
if ( ((false === $settings[0]) && ((isset($this->alt_option_name) && Aspis_isset( $this ->alt_option_name )))))
 $settings = get_option($this->alt_option_name);
if ( (!(is_array($settings[0]))))
 $settings = array(array(),false);
if ( (!(array_key_exists('_multiwidget',deAspisRC($settings)))))
 {$settings = wp_convert_widget_settings($this->id_base,$this->option_name,$settings);
}unset($settings[0][('_multiwidget')],$settings[0][('__i__')]);
return $settings;
} }
}class WP_Widget_Factory{var $widgets = array(array(),false);
function WP_Widget_Factory (  ) {
{add_action(array('widgets_init',false),array(array(array($this,false),array('_register_widgets',false)),false),array(100,false));
} }
function register ( $widget_class ) {
{arrayAssign($this->widgets[0],deAspis(registerTaint($widget_class)),addTaint(array(new $widget_class[0](),false)));
} }
function unregister ( $widget_class ) {
{if ( ((isset($this->widgets[0][$widget_class[0]]) && Aspis_isset( $this ->widgets [0][$widget_class[0]] ))))
 unset($this->widgets[0][$widget_class[0]]);
} }
function _register_widgets (  ) {
{global $wp_registered_widgets;
$keys = attAspisRC(array_keys(deAspisRC($this->widgets)));
$registered = attAspisRC(array_keys(deAspisRC($wp_registered_widgets)));
$registered = attAspisRC(array_map(AspisInternalCallback(array('_get_widget_id_base',false)),deAspisRC($registered)));
foreach ( $keys[0] as $key  )
{if ( deAspis(Aspis_in_array($this->widgets[0][$key[0]][0]->id_base,$registered,array(true,false))))
 {unset($this->widgets[0][$key[0]]);
continue ;
}$this->widgets[0][$key[0]][0]->_register();
}} }
}global $wp_registered_sidebars,$wp_registered_widgets,$wp_registered_widget_controls,$wp_registered_widget_updates;
$wp_registered_sidebars = array(array(),false);
$wp_registered_widgets = array(array(),false);
$wp_registered_widget_controls = array(array(),false);
$wp_registered_widget_updates = array(array(),false);
$_wp_sidebars_widgets = array(array(),false);
$_wp_deprecated_widgets_callbacks = array(array(array('wp_widget_pages',false),array('wp_widget_pages_control',false),array('wp_widget_calendar',false),array('wp_widget_calendar_control',false),array('wp_widget_archives',false),array('wp_widget_archives_control',false),array('wp_widget_links',false),array('wp_widget_meta',false),array('wp_widget_meta_control',false),array('wp_widget_search',false),array('wp_widget_recent_entries',false),array('wp_widget_recent_entries_control',false),array('wp_widget_tag_cloud',false),array('wp_widget_tag_cloud_control',false),array('wp_widget_categories',false),array('wp_widget_categories_control',false),array('wp_widget_text',false),array('wp_widget_text_control',false),array('wp_widget_rss',false),array('wp_widget_rss_control',false),array('wp_widget_recent_comments',false),array('wp_widget_recent_comments_control',false)),false);
function register_widget ( $widget_class ) {
global $wp_widget_factory;
$wp_widget_factory[0]->register($widget_class);
 }
function unregister_widget ( $widget_class ) {
global $wp_widget_factory;
$wp_widget_factory[0]->unregister($widget_class);
 }
function register_sidebars ( $number = array(1,false),$args = array(array(),false) ) {
global $wp_registered_sidebars;
$number = int_cast($number);
if ( is_string(deAspisRC($args)))
 AspisInternalFunctionCall("parse_str",$args[0],AspisPushRefParam($args),array(1));
for ( $i = array(1,false) ; ($i[0] <= $number[0]) ; postincr($i) )
{$_args = $args;
if ( ($number[0] > (1)))
 {arrayAssign($_args[0],deAspis(registerTaint(array('name',false))),addTaint(((isset($args[0][('name')]) && Aspis_isset( $args [0][('name')]))) ? Aspis_sprintf($args[0]['name'],$i) : Aspis_sprintf(__(array('Sidebar %d',false)),$i)));
}else 
{{arrayAssign($_args[0],deAspis(registerTaint(array('name',false))),addTaint(((isset($args[0][('name')]) && Aspis_isset( $args [0][('name')]))) ? $args[0]['name'] : __(array('Sidebar',false))));
}}if ( ((isset($args[0][('id')]) && Aspis_isset( $args [0][('id')]))))
 {arrayAssign($_args[0],deAspis(registerTaint(array('id',false))),addTaint($args[0]['id']));
}else 
{{$n = attAspis(count($wp_registered_sidebars[0]));
do {postincr($n);
arrayAssign($_args[0],deAspis(registerTaint(array('id',false))),addTaint(concat1("sidebar-",$n)));
}while (((isset($wp_registered_sidebars[0][deAspis($_args[0]['id'])]) && Aspis_isset( $wp_registered_sidebars [0][deAspis($_args [0]['id'])]))) )
;
}}register_sidebar($_args);
} }
function register_sidebar ( $args = array(array(),false) ) {
global $wp_registered_sidebars;
if ( is_string(deAspisRC($args)))
 AspisInternalFunctionCall("parse_str",$args[0],AspisPushRefParam($args),array(1));
$i = array(count($wp_registered_sidebars[0]) + (1),false);
$defaults = array(array(deregisterTaint(array('name',false)) => addTaint(Aspis_sprintf(__(array('Sidebar %d',false)),$i)),deregisterTaint(array('id',false)) => addTaint(concat1("sidebar-",$i)),'description' => array('',false,false),'before_widget' => array('<li id="%1$s" class="widget %2$s">',false,false),'after_widget' => array("</li>\n",false,false),'before_title' => array('<h2 class="widgettitle">',false,false),'after_title' => array("</h2>\n",false,false),),false);
$sidebar = Aspis_array_merge($defaults,array_cast($args));
arrayAssign($wp_registered_sidebars[0],deAspis(registerTaint($sidebar[0]['id'])),addTaint($sidebar));
return $sidebar[0]['id'];
 }
function unregister_sidebar ( $name ) {
global $wp_registered_sidebars;
if ( ((isset($wp_registered_sidebars[0][$name[0]]) && Aspis_isset( $wp_registered_sidebars [0][$name[0]]))))
 unset($wp_registered_sidebars[0][$name[0]]);
 }
function wp_register_sidebar_widget ( $id,$name,$output_callback,$options = array(array(),false) ) {
global $wp_registered_widgets,$wp_registered_widget_controls,$wp_registered_widget_updates,$_wp_deprecated_widgets_callbacks;
$id = Aspis_strtolower($id);
if ( ((empty($output_callback) || Aspis_empty( $output_callback))))
 {unset($wp_registered_widgets[0][$id[0]]);
return ;
}$id_base = _get_widget_id_base($id);
if ( (deAspis(Aspis_in_array($output_callback,$_wp_deprecated_widgets_callbacks,array(true,false))) && (!(is_callable(deAspisRC($output_callback))))))
 {if ( ((isset($wp_registered_widget_controls[0][$id[0]]) && Aspis_isset( $wp_registered_widget_controls [0][$id[0]]))))
 unset($wp_registered_widget_controls[0][$id[0]]);
if ( ((isset($wp_registered_widget_updates[0][$id_base[0]]) && Aspis_isset( $wp_registered_widget_updates [0][$id_base[0]]))))
 unset($wp_registered_widget_updates[0][$id_base[0]]);
return ;
}$defaults = array(array(deregisterTaint(array('classname',false)) => addTaint($output_callback)),false);
$options = wp_parse_args($options,$defaults);
$widget = array(array(deregisterTaint(array('name',false)) => addTaint($name),deregisterTaint(array('id',false)) => addTaint($id),deregisterTaint(array('callback',false)) => addTaint($output_callback),deregisterTaint(array('params',false)) => addTaint(Aspis_array_slice(array(func_get_args(),false),array(4,false)))),false);
$widget = Aspis_array_merge($widget,$options);
if ( (is_callable(deAspisRC($output_callback)) && ((!((isset($wp_registered_widgets[0][$id[0]]) && Aspis_isset( $wp_registered_widgets [0][$id[0]])))) || deAspis(did_action(array('widgets_init',false))))))
 arrayAssign($wp_registered_widgets[0],deAspis(registerTaint($id)),addTaint($widget));
 }
function wp_widget_description ( $id ) {
if ( (!(is_scalar(deAspisRC($id)))))
 return ;
global $wp_registered_widgets;
if ( ((isset($wp_registered_widgets[0][$id[0]][0][('description')]) && Aspis_isset( $wp_registered_widgets [0][$id[0]] [0][('description')]))))
 return esc_html($wp_registered_widgets[0][$id[0]][0]['description']);
 }
function wp_sidebar_description ( $id ) {
if ( (!(is_scalar(deAspisRC($id)))))
 return ;
global $wp_registered_sidebars;
if ( ((isset($wp_registered_sidebars[0][$id[0]][0][('description')]) && Aspis_isset( $wp_registered_sidebars [0][$id[0]] [0][('description')]))))
 return esc_html($wp_registered_sidebars[0][$id[0]][0]['description']);
 }
function wp_unregister_sidebar_widget ( $id ) {
wp_register_sidebar_widget($id,array('',false),array('',false));
wp_unregister_widget_control($id);
 }
function wp_register_widget_control ( $id,$name,$control_callback,$options = array(array(),false) ) {
global $wp_registered_widget_controls,$wp_registered_widget_updates,$wp_registered_widgets,$_wp_deprecated_widgets_callbacks;
$id = Aspis_strtolower($id);
$id_base = _get_widget_id_base($id);
if ( ((empty($control_callback) || Aspis_empty( $control_callback))))
 {unset($wp_registered_widget_controls[0][$id[0]]);
unset($wp_registered_widget_updates[0][$id_base[0]]);
return ;
}if ( (deAspis(Aspis_in_array($control_callback,$_wp_deprecated_widgets_callbacks,array(true,false))) && (!(is_callable(deAspisRC($control_callback))))))
 {if ( ((isset($wp_registered_widgets[0][$id[0]]) && Aspis_isset( $wp_registered_widgets [0][$id[0]]))))
 unset($wp_registered_widgets[0][$id[0]]);
return ;
}if ( (((isset($wp_registered_widget_controls[0][$id[0]]) && Aspis_isset( $wp_registered_widget_controls [0][$id[0]]))) && (denot_boolean(did_action(array('widgets_init',false))))))
 return ;
$defaults = array(array('width' => array(250,false,false),'height' => array(200,false,false)),false);
$options = wp_parse_args($options,$defaults);
arrayAssign($options[0],deAspis(registerTaint(array('width',false))),addTaint(int_cast($options[0]['width'])));
arrayAssign($options[0],deAspis(registerTaint(array('height',false))),addTaint(int_cast($options[0]['height'])));
$widget = array(array(deregisterTaint(array('name',false)) => addTaint($name),deregisterTaint(array('id',false)) => addTaint($id),deregisterTaint(array('callback',false)) => addTaint($control_callback),deregisterTaint(array('params',false)) => addTaint(Aspis_array_slice(array(func_get_args(),false),array(4,false)))),false);
$widget = Aspis_array_merge($widget,$options);
arrayAssign($wp_registered_widget_controls[0],deAspis(registerTaint($id)),addTaint($widget));
if ( ((isset($wp_registered_widget_updates[0][$id_base[0]]) && Aspis_isset( $wp_registered_widget_updates [0][$id_base[0]]))))
 return ;
if ( ((isset($widget[0][('params')][0][(0)][0][('number')]) && Aspis_isset( $widget [0][('params')] [0][(0)] [0][('number')]))))
 arrayAssign($widget[0][('params')][0][(0)][0],deAspis(registerTaint(array('number',false))),addTaint(negate(array(1,false))));
unset($widget[0][('width')],$widget[0][('height')],$widget[0][('name')],$widget[0][('id')]);
arrayAssign($wp_registered_widget_updates[0],deAspis(registerTaint($id_base)),addTaint($widget));
 }
function _register_widget_update_callback ( $id_base,$update_callback,$options = array(array(),false) ) {
global $wp_registered_widget_updates;
if ( ((isset($wp_registered_widget_updates[0][$id_base[0]]) && Aspis_isset( $wp_registered_widget_updates [0][$id_base[0]]))))
 {if ( ((empty($update_callback) || Aspis_empty( $update_callback))))
 unset($wp_registered_widget_updates[0][$id_base[0]]);
return ;
}$widget = array(array(deregisterTaint(array('callback',false)) => addTaint($update_callback),deregisterTaint(array('params',false)) => addTaint(Aspis_array_slice(array(func_get_args(),false),array(3,false)))),false);
$widget = Aspis_array_merge($widget,$options);
arrayAssign($wp_registered_widget_updates[0],deAspis(registerTaint($id_base)),addTaint($widget));
 }
function _register_widget_form_callback ( $id,$name,$form_callback,$options = array(array(),false) ) {
global $wp_registered_widget_controls;
$id = Aspis_strtolower($id);
if ( ((empty($form_callback) || Aspis_empty( $form_callback))))
 {unset($wp_registered_widget_controls[0][$id[0]]);
return ;
}if ( (((isset($wp_registered_widget_controls[0][$id[0]]) && Aspis_isset( $wp_registered_widget_controls [0][$id[0]]))) && (denot_boolean(did_action(array('widgets_init',false))))))
 return ;
$defaults = array(array('width' => array(250,false,false),'height' => array(200,false,false)),false);
$options = wp_parse_args($options,$defaults);
arrayAssign($options[0],deAspis(registerTaint(array('width',false))),addTaint(int_cast($options[0]['width'])));
arrayAssign($options[0],deAspis(registerTaint(array('height',false))),addTaint(int_cast($options[0]['height'])));
$widget = array(array(deregisterTaint(array('name',false)) => addTaint($name),deregisterTaint(array('id',false)) => addTaint($id),deregisterTaint(array('callback',false)) => addTaint($form_callback),deregisterTaint(array('params',false)) => addTaint(Aspis_array_slice(array(func_get_args(),false),array(4,false)))),false);
$widget = Aspis_array_merge($widget,$options);
arrayAssign($wp_registered_widget_controls[0],deAspis(registerTaint($id)),addTaint($widget));
 }
function wp_unregister_widget_control ( $id ) {
return wp_register_widget_control($id,array('',false),array('',false));
 }
function dynamic_sidebar ( $index = array(1,false) ) {
global $wp_registered_sidebars,$wp_registered_widgets;
if ( is_int(deAspisRC($index)))
 {$index = concat1("sidebar-",$index);
}else 
{{$index = sanitize_title($index);
foreach ( deAspis(array_cast($wp_registered_sidebars)) as $key =>$value )
{restoreTaint($key,$value);
{if ( (deAspis(sanitize_title($value[0]['name'])) == $index[0]))
 {$index = $key;
break ;
}}}}}$sidebars_widgets = wp_get_sidebars_widgets();
if ( (((((empty($wp_registered_sidebars[0][$index[0]]) || Aspis_empty( $wp_registered_sidebars [0][$index[0]]))) || (!(array_key_exists(deAspisRC($index),deAspisRC($sidebars_widgets))))) || (!(is_array(deAspis(attachAspis($sidebars_widgets,$index[0])))))) || ((empty($sidebars_widgets[0][$index[0]]) || Aspis_empty( $sidebars_widgets [0][$index[0]])))))
 return array(false,false);
$sidebar = attachAspis($wp_registered_sidebars,$index[0]);
$did_one = array(false,false);
foreach ( deAspis(array_cast(attachAspis($sidebars_widgets,$index[0]))) as $id  )
{if ( (!((isset($wp_registered_widgets[0][$id[0]]) && Aspis_isset( $wp_registered_widgets [0][$id[0]])))))
 continue ;
$params = Aspis_array_merge(array(array(Aspis_array_merge($sidebar,array(array(deregisterTaint(array('widget_id',false)) => addTaint($id),deregisterTaint(array('widget_name',false)) => addTaint($wp_registered_widgets[0][$id[0]][0]['name'])),false))),false),array_cast($wp_registered_widgets[0][$id[0]][0]['params']));
$classname_ = array('',false);
foreach ( deAspis(array_cast($wp_registered_widgets[0][$id[0]][0]['classname'])) as $cn  )
{if ( is_string(deAspisRC($cn)))
 $classname_ = concat($classname_,concat1('_',$cn));
elseif ( is_object($cn[0]))
 $classname_ = concat($classname_,concat1('_',attAspis(get_class(deAspisRC($cn)))));
}$classname_ = Aspis_ltrim($classname_,array('_',false));
arrayAssign($params[0][(0)][0],deAspis(registerTaint(array('before_widget',false))),addTaint(Aspis_sprintf($params[0][(0)][0]['before_widget'],$id,$classname_)));
$params = apply_filters(array('dynamic_sidebar_params',false),$params);
$callback = $wp_registered_widgets[0][$id[0]][0]['callback'];
if ( is_callable(deAspisRC($callback)))
 {Aspis_call_user_func_array($callback,$params);
$did_one = array(true,false);
}}return $did_one;
 }
function is_active_widget ( $callback = array(false,false),$widget_id = array(false,false),$id_base = array(false,false),$skip_inactive = array(true,false) ) {
global $wp_registered_widgets;
$sidebars_widgets = wp_get_sidebars_widgets();
if ( is_array($sidebars_widgets[0]))
 {foreach ( $sidebars_widgets[0] as $sidebar =>$widgets )
{restoreTaint($sidebar,$widgets);
{if ( ($skip_inactive[0] && (('wp_inactive_widgets') == $sidebar[0])))
 continue ;
if ( is_array($widgets[0]))
 {foreach ( $widgets[0] as $widget  )
{if ( ((($callback[0] && ((isset($wp_registered_widgets[0][$widget[0]][0][('callback')]) && Aspis_isset( $wp_registered_widgets [0][$widget[0]] [0][('callback')])))) && (deAspis($wp_registered_widgets[0][$widget[0]][0]['callback']) == $callback[0])) || ($id_base[0] && (deAspis(_get_widget_id_base($widget)) == $id_base[0]))))
 {if ( ((denot_boolean($widget_id)) || ($widget_id[0] == deAspis($wp_registered_widgets[0][$widget[0]][0]['id']))))
 return $sidebar;
}}}}}}return array(false,false);
 }
function is_dynamic_sidebar (  ) {
global $wp_registered_widgets,$wp_registered_sidebars;
$sidebars_widgets = get_option(array('sidebars_widgets',false));
foreach ( deAspis(array_cast($wp_registered_sidebars)) as $index =>$sidebar )
{restoreTaint($index,$sidebar);
{if ( count(deAspis(attachAspis($sidebars_widgets,$index[0]))))
 {foreach ( deAspis(array_cast(attachAspis($sidebars_widgets,$index[0]))) as $widget  )
if ( array_key_exists(deAspisRC($widget),deAspisRC($wp_registered_widgets)))
 return array(true,false);
}}}return array(false,false);
 }
function is_active_sidebar ( $index ) {
$index = is_int(deAspisRC($index)) ? concat1("sidebar-",$index) : sanitize_title($index);
$sidebars_widgets = wp_get_sidebars_widgets();
if ( (((isset($sidebars_widgets[0][$index[0]]) && Aspis_isset( $sidebars_widgets [0][$index[0]]))) && (!((empty($sidebars_widgets[0][$index[0]]) || Aspis_empty( $sidebars_widgets [0][$index[0]]))))))
 return array(true,false);
return array(false,false);
 }
function wp_get_sidebars_widgets ( $deprecated = array(true,false) ) {
global $wp_registered_widgets,$wp_registered_sidebars,$_wp_sidebars_widgets;
if ( (denot_boolean(is_admin())))
 {if ( ((empty($_wp_sidebars_widgets) || Aspis_empty( $_wp_sidebars_widgets))))
 $_wp_sidebars_widgets = get_option(array('sidebars_widgets',false),array(array(),false));
$sidebars_widgets = $_wp_sidebars_widgets;
}else 
{{$sidebars_widgets = get_option(array('sidebars_widgets',false),array(array(),false));
$_sidebars_widgets = array(array(),false);
if ( (((isset($sidebars_widgets[0][('wp_inactive_widgets')]) && Aspis_isset( $sidebars_widgets [0][('wp_inactive_widgets')]))) || ((empty($sidebars_widgets) || Aspis_empty( $sidebars_widgets)))))
 arrayAssign($sidebars_widgets[0],deAspis(registerTaint(array('array_version',false))),addTaint(array(3,false)));
elseif ( (!((isset($sidebars_widgets[0][('array_version')]) && Aspis_isset( $sidebars_widgets [0][('array_version')])))))
 arrayAssign($sidebars_widgets[0],deAspis(registerTaint(array('array_version',false))),addTaint(array(1,false)));
switch ( deAspis($sidebars_widgets[0]['array_version']) ) {
case (1):foreach ( deAspis(array_cast($sidebars_widgets)) as $index =>$sidebar )
{restoreTaint($index,$sidebar);
if ( is_array($sidebar[0]))
 foreach ( deAspis(array_cast($sidebar)) as $i =>$name )
{restoreTaint($i,$name);
{$id = Aspis_strtolower($name);
if ( ((isset($wp_registered_widgets[0][$id[0]]) && Aspis_isset( $wp_registered_widgets [0][$id[0]]))))
 {arrayAssign($_sidebars_widgets[0][$index[0]][0],deAspis(registerTaint($i)),addTaint($id));
continue ;
}$id = sanitize_title($name);
if ( ((isset($wp_registered_widgets[0][$id[0]]) && Aspis_isset( $wp_registered_widgets [0][$id[0]]))))
 {arrayAssign($_sidebars_widgets[0][$index[0]][0],deAspis(registerTaint($i)),addTaint($id));
continue ;
}$found = array(false,false);
foreach ( $wp_registered_widgets[0] as $widget_id =>$widget )
{restoreTaint($widget_id,$widget);
{if ( (deAspis(Aspis_strtolower($widget[0]['name'])) == deAspis(Aspis_strtolower($name))))
 {arrayAssign($_sidebars_widgets[0][$index[0]][0],deAspis(registerTaint($i)),addTaint($widget[0]['id']));
$found = array(true,false);
break ;
}elseif ( (deAspis(sanitize_title($widget[0]['name'])) == deAspis(sanitize_title($name))))
 {arrayAssign($_sidebars_widgets[0][$index[0]][0],deAspis(registerTaint($i)),addTaint($widget[0]['id']));
$found = array(true,false);
break ;
}}}if ( $found[0])
 continue ;
unset($_sidebars_widgets[0][$index[0]][0][$i[0]]);
}}}arrayAssign($_sidebars_widgets[0],deAspis(registerTaint(array('array_version',false))),addTaint(array(2,false)));
$sidebars_widgets = $_sidebars_widgets;
unset($_sidebars_widgets);
case (2):$sidebars = attAspisRC(array_keys(deAspisRC($wp_registered_sidebars)));
if ( (!((empty($sidebars) || Aspis_empty( $sidebars)))))
 {foreach ( deAspis(array_cast($sidebars)) as $id  )
{if ( array_key_exists(deAspisRC($id),deAspisRC($sidebars_widgets)))
 {arrayAssign($_sidebars_widgets[0],deAspis(registerTaint($id)),addTaint(attachAspis($sidebars_widgets,$id[0])));
unset($sidebars_widgets[0][$id[0]],$sidebars[0][$id[0]]);
}}if ( (!((isset($_sidebars_widgets[0][('wp_inactive_widgets')]) && Aspis_isset( $_sidebars_widgets [0][('wp_inactive_widgets')])))))
 arrayAssign($_sidebars_widgets[0],deAspis(registerTaint(array('wp_inactive_widgets',false))),addTaint(array(array(),false)));
if ( (!((empty($sidebars_widgets) || Aspis_empty( $sidebars_widgets)))))
 {foreach ( $sidebars_widgets[0] as $lost =>$val )
{restoreTaint($lost,$val);
{if ( is_array($val[0]))
 arrayAssign($_sidebars_widgets[0],deAspis(registerTaint(array('wp_inactive_widgets',false))),addTaint(Aspis_array_merge(array_cast($_sidebars_widgets[0]['wp_inactive_widgets']),$val)));
}}}$sidebars_widgets = $_sidebars_widgets;
unset($_sidebars_widgets);
} }
}}if ( ((isset($sidebars_widgets[0][('array_version')]) && Aspis_isset( $sidebars_widgets [0][('array_version')]))))
 unset($sidebars_widgets[0][('array_version')]);
$sidebars_widgets = apply_filters(array('sidebars_widgets',false),$sidebars_widgets);
return $sidebars_widgets;
 }
function wp_set_sidebars_widgets ( $sidebars_widgets ) {
if ( (!((isset($sidebars_widgets[0][('array_version')]) && Aspis_isset( $sidebars_widgets [0][('array_version')])))))
 arrayAssign($sidebars_widgets[0],deAspis(registerTaint(array('array_version',false))),addTaint(array(3,false)));
update_option(array('sidebars_widgets',false),$sidebars_widgets);
 }
function wp_get_widget_defaults (  ) {
global $wp_registered_sidebars;
$defaults = array(array(),false);
foreach ( deAspis(array_cast($wp_registered_sidebars)) as $index =>$sidebar )
{restoreTaint($index,$sidebar);
arrayAssign($defaults[0],deAspis(registerTaint($index)),addTaint(array(array(),false)));
}return $defaults;
 }
function wp_convert_widget_settings ( $base_name,$option_name,$settings ) {
$single = $changed = array(false,false);
if ( ((empty($settings) || Aspis_empty( $settings))))
 {$single = array(true,false);
}else 
{{foreach ( deAspis(attAspisRC(array_keys(deAspisRC($settings)))) as $number  )
{if ( (('number') == $number[0]))
 continue ;
if ( (!(is_numeric(deAspisRC($number)))))
 {$single = array(true,false);
break ;
}}}}if ( $single[0])
 {$settings = array(array(deregisterTaint(array(2,false)) => addTaint($settings)),false);
if ( deAspis(is_admin()))
 {$sidebars_widgets = get_option(array('sidebars_widgets',false));
}else 
{{if ( ((empty($GLOBALS[0][('_wp_sidebars_widgets')]) || Aspis_empty( $GLOBALS [0][('_wp_sidebars_widgets')]))))
 arrayAssign($GLOBALS[0],deAspis(registerTaint(array('_wp_sidebars_widgets',false))),addTaint(get_option(array('sidebars_widgets',false),array(array(),false))));
$sidebars_widgets = &$GLOBALS[0][('_wp_sidebars_widgets')];
}}foreach ( deAspis(array_cast($sidebars_widgets)) as $index =>$sidebar )
{restoreTaint($index,$sidebar);
{if ( is_array($sidebar[0]))
 {foreach ( $sidebar[0] as $i =>$name )
{restoreTaint($i,$name);
{if ( ($base_name[0] == $name[0]))
 {arrayAssign($sidebars_widgets[0][$index[0]][0],deAspis(registerTaint($i)),addTaint(concat2($name,"-2")));
$changed = array(true,false);
break (2);
}}}}}}if ( (deAspis(is_admin()) && $changed[0]))
 update_option(array('sidebars_widgets',false),$sidebars_widgets);
}arrayAssign($settings[0],deAspis(registerTaint(array('_multiwidget',false))),addTaint(array(1,false)));
if ( deAspis(is_admin()))
 update_option($option_name,$settings);
return $settings;
 }
function register_sidebar_widget ( $name,$output_callback,$classname = array('',false) ) {
if ( is_array($name[0]))
 {if ( (count($name[0]) == (3)))
 $name = Aspis_sprintf(attachAspis($name,(0)),attachAspis($name,(2)));
else 
{$name = attachAspis($name,(0));
}}$id = sanitize_title($name);
$options = array(array(),false);
if ( ((!((empty($classname) || Aspis_empty( $classname)))) && is_string(deAspisRC($classname))))
 arrayAssign($options[0],deAspis(registerTaint(array('classname',false))),addTaint($classname));
$params = Aspis_array_slice(array(func_get_args(),false),array(2,false));
$args = array(array($id,$name,$output_callback,$options),false);
if ( (!((empty($params) || Aspis_empty( $params)))))
 $args = Aspis_array_merge($args,$params);
Aspis_call_user_func_array(array('wp_register_sidebar_widget',false),$args);
 }
function unregister_sidebar_widget ( $id ) {
return wp_unregister_sidebar_widget($id);
 }
function register_widget_control ( $name,$control_callback,$width = array('',false),$height = array('',false) ) {
if ( is_array($name[0]))
 {if ( (count($name[0]) == (3)))
 $name = Aspis_sprintf(attachAspis($name,(0)),attachAspis($name,(2)));
else 
{$name = attachAspis($name,(0));
}}$id = sanitize_title($name);
$options = array(array(),false);
if ( (!((empty($width) || Aspis_empty( $width)))))
 arrayAssign($options[0],deAspis(registerTaint(array('width',false))),addTaint($width));
if ( (!((empty($height) || Aspis_empty( $height)))))
 arrayAssign($options[0],deAspis(registerTaint(array('height',false))),addTaint($height));
$params = Aspis_array_slice(array(func_get_args(),false),array(4,false));
$args = array(array($id,$name,$control_callback,$options),false);
if ( (!((empty($params) || Aspis_empty( $params)))))
 $args = Aspis_array_merge($args,$params);
Aspis_call_user_func_array(array('wp_register_widget_control',false),$args);
 }
function unregister_widget_control ( $id ) {
return wp_unregister_widget_control($id);
 }
function the_widget ( $widget,$instance = array(array(),false),$args = array(array(),false) ) {
global $wp_widget_factory;
$widget_obj = $wp_widget_factory[0]->widgets[0][$widget[0]];
if ( (!(is_a(deAspisRC($widget_obj),('WP_Widget')))))
 return ;
$before_widget = Aspis_sprintf(array('<div class="widget %s">',false),$widget_obj[0]->widget_options[0][('classname')]);
$default_args = array(array(deregisterTaint(array('before_widget',false)) => addTaint($before_widget),'after_widget' => array("</div>",false,false),'before_title' => array('<h2 class="widgettitle">',false,false),'after_title' => array('</h2>',false,false)),false);
$args = wp_parse_args($args,$default_args);
$instance = wp_parse_args($instance);
$widget_obj[0]->_set(negate(array(1,false)));
$widget_obj[0]->widget($args,$instance);
 }
function _get_widget_id_base ( $id ) {
return Aspis_preg_replace(array('/-[0-9]+$/',false),array('',false),$id);
 }
