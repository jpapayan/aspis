<?php require_once('AspisMain.php'); ?><?php
class WP_Widget{var $id_base;
var $name;
var $widget_options;
var $control_options;
var $number = false;
var $id = false;
var $updated = false;
function widget ( $args,$instance ) {
{exit('function WP_Widget::widget() must be over-ridden in a sub-class.');
} }
function update ( $new_instance,$old_instance ) {
{{$AspisRetTemp = $new_instance;
return $AspisRetTemp;
}} }
function form ( $instance ) {
{echo '<p class="no-options-widget">' . __('There are no options for this widget.') . '</p>';
{$AspisRetTemp = 'noform';
return $AspisRetTemp;
}} }
function WP_Widget ( $id_base = false,$name,$widget_options = array(),$control_options = array() ) {
{$this->__construct($id_base,$name,$widget_options,$control_options);
} }
function __construct ( $id_base = false,$name,$widget_options = array(),$control_options = array() ) {
{$this->id_base = empty($id_base) ? preg_replace('/(wp_)?widget_/','',strtolower(get_class($this))) : strtolower($id_base);
$this->name = $name;
$this->option_name = 'widget_' . $this->id_base;
$this->widget_options = wp_parse_args($widget_options,array('classname' => $this->option_name));
$this->control_options = wp_parse_args($control_options,array('id_base' => $this->id_base));
} }
function get_field_name ( $field_name ) {
{{$AspisRetTemp = 'widget-' . $this->id_base . '[' . $this->number . '][' . $field_name . ']';
return $AspisRetTemp;
}} }
function get_field_id ( $field_name ) {
{{$AspisRetTemp = 'widget-' . $this->id_base . '-' . $this->number . '-' . $field_name;
return $AspisRetTemp;
}} }
function _register (  ) {
{$settings = $this->get_settings();
$empty = true;
if ( is_array($settings))
 {foreach ( array_keys($settings) as $number  )
{if ( is_numeric($number))
 {$this->_set($number);
$this->_register_one($number);
$empty = false;
}}}if ( $empty)
 {$this->_set(1);
$this->_register_one();
}} }
function _set ( $number ) {
{$this->number = $number;
$this->id = $this->id_base . '-' . $number;
} }
function _get_display_callback (  ) {
{{$AspisRetTemp = array(&$this,'display_callback');
return $AspisRetTemp;
}} }
function _get_update_callback (  ) {
{{$AspisRetTemp = array(&$this,'update_callback');
return $AspisRetTemp;
}} }
function _get_form_callback (  ) {
{{$AspisRetTemp = array(&$this,'form_callback');
return $AspisRetTemp;
}} }
function display_callback ( $args,$widget_args = 1 ) {
{if ( is_numeric($widget_args))
 $widget_args = array('number' => $widget_args);
$widget_args = wp_parse_args($widget_args,array('number' => -1));
$this->_set($widget_args['number']);
$instance = $this->get_settings();
if ( array_key_exists($this->number,$instance))
 {$instance = $instance[$this->number];
$instance = apply_filters('widget_display_callback',$instance,$this,$args);
if ( false !== $instance)
 $this->widget($args,$instance);
}} }
function update_callback ( $widget_args = 1 ) {
{{global $wp_registered_widgets;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widgets,"\$wp_registered_widgets",$AspisChangesCache);
}if ( is_numeric($widget_args))
 $widget_args = array('number' => $widget_args);
$widget_args = wp_parse_args($widget_args,array('number' => -1));
$all_instances = $this->get_settings();
if ( $this->updated)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
return ;
}$sidebars_widgets = wp_get_sidebars_widgets();
if ( (isset($_POST[0]['delete_widget']) && Aspis_isset($_POST[0]['delete_widget'])) && deAspisWarningRC($_POST[0]['delete_widget']))
 {if ( (isset($_POST[0]['the-widget-id']) && Aspis_isset($_POST[0]['the-widget-id'])))
 $del_id = deAspisWarningRC($_POST[0]['the-widget-id']);
else 
{{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
return ;
}}if ( isset($wp_registered_widgets[$del_id]['params'][0]['number']))
 {$number = $wp_registered_widgets[$del_id]['params'][0]['number'];
if ( $this->id_base . '-' . $number == $del_id)
 unset($all_instances[$number]);
}}else 
{{if ( (isset($_POST[0]['widget-' . $this->id_base]) && Aspis_isset($_POST[0]['widget-' . $this ->id_base ])) && is_array(deAspisWarningRC($_POST[0]['widget-' . $this->id_base])))
 {$settings = deAspisWarningRC($_POST[0]['widget-' . $this->id_base]);
}elseif ( (isset($_POST[0]['id_base']) && Aspis_isset($_POST[0]['id_base'])) && deAspisWarningRC($_POST[0]['id_base']) == $this->id_base)
 {$num = deAspisWarningRC($_POST[0]['multi_number']) ? (int)deAspisWarningRC($_POST[0]['multi_number']) : (int)deAspisWarningRC($_POST[0]['widget_number']);
$settings = array($num => array());
}else 
{{{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
return ;
}}}foreach ( $settings as $number =>$new_instance )
{$new_instance = stripslashes_deep($new_instance);
$this->_set($number);
$old_instance = isset($all_instances[$number]) ? $all_instances[$number] : array();
$instance = $this->update($new_instance,$old_instance);
$instance = apply_filters('widget_update_callback',$instance,$new_instance,$old_instance,$this);
if ( false !== $instance)
 $all_instances[$number] = $instance;
break ;
}}}$this->save_settings($all_instances);
$this->updated = true;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
 }
function form_callback ( $widget_args = 1 ) {
{if ( is_numeric($widget_args))
 $widget_args = array('number' => $widget_args);
$widget_args = wp_parse_args($widget_args,array('number' => -1));
$all_instances = $this->get_settings();
if ( -1 == $widget_args['number'])
 {$this->_set('__i__');
$instance = array();
}else 
{{$this->_set($widget_args['number']);
$instance = $all_instances[$widget_args['number']];
}}$instance = apply_filters('widget_form_callback',$instance,$this);
$return = null;
if ( false !== $instance)
 {$return = $this->form($instance);
do_action_ref_array('in_widget_form',array($this,$return,$instance));
}{$AspisRetTemp = $return;
return $AspisRetTemp;
}} }
function _register_one ( $number = -1 ) {
{wp_register_sidebar_widget($this->id,$this->name,$this->_get_display_callback(),$this->widget_options,array('number' => $number));
_register_widget_update_callback($this->id_base,$this->_get_update_callback(),$this->control_options,array('number' => -1));
_register_widget_form_callback($this->id,$this->name,$this->_get_form_callback(),$this->control_options,array('number' => $number));
} }
function save_settings ( $settings ) {
{$settings['_multiwidget'] = 1;
update_option($this->option_name,$settings);
} }
function get_settings (  ) {
{$settings = get_option($this->option_name);
if ( false === $settings && isset($this->alt_option_name))
 $settings = get_option($this->alt_option_name);
if ( !is_array($settings))
 $settings = array();
if ( !array_key_exists('_multiwidget',$settings))
 {$settings = wp_convert_widget_settings($this->id_base,$this->option_name,$settings);
}unset($settings['_multiwidget'],$settings['__i__']);
{$AspisRetTemp = $settings;
return $AspisRetTemp;
}} }
}class WP_Widget_Factory{var $widgets = array();
function WP_Widget_Factory (  ) {
{add_action('widgets_init',array($this,'_register_widgets'),100);
} }
function register ( $widget_class ) {
{$this->widgets[$widget_class] = &AspisNewUnknownProxy($widget_class,array( ),false);
} }
function unregister ( $widget_class ) {
{if ( isset($this->widgets[$widget_class]))
 unset($this->widgets[$widget_class]);
} }
function _register_widgets (  ) {
{{global $wp_registered_widgets;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widgets,"\$wp_registered_widgets",$AspisChangesCache);
}$keys = array_keys($this->widgets);
$registered = array_keys($wp_registered_widgets);
$registered = array_map('_get_widget_id_base',$registered);
foreach ( $keys as $key  )
{if ( in_array($this->widgets[$key]->id_base,$registered,true))
 {unset($this->widgets[$key]);
continue ;
}$this->widgets[$key]->_register();
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
 }
}global $wp_registered_sidebars,$wp_registered_widgets,$wp_registered_widget_controls,$wp_registered_widget_updates;
$wp_registered_sidebars = array();
$wp_registered_widgets = array();
$wp_registered_widget_controls = array();
$wp_registered_widget_updates = array();
$_wp_sidebars_widgets = array();
$_wp_deprecated_widgets_callbacks = array('wp_widget_pages','wp_widget_pages_control','wp_widget_calendar','wp_widget_calendar_control','wp_widget_archives','wp_widget_archives_control','wp_widget_links','wp_widget_meta','wp_widget_meta_control','wp_widget_search','wp_widget_recent_entries','wp_widget_recent_entries_control','wp_widget_tag_cloud','wp_widget_tag_cloud_control','wp_widget_categories','wp_widget_categories_control','wp_widget_text','wp_widget_text_control','wp_widget_rss','wp_widget_rss_control','wp_widget_recent_comments','wp_widget_recent_comments_control');
function register_widget ( $widget_class ) {
{global $wp_widget_factory;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_widget_factory,"\$wp_widget_factory",$AspisChangesCache);
}$wp_widget_factory->register($widget_class);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_widget_factory",$AspisChangesCache);
 }
function unregister_widget ( $widget_class ) {
{global $wp_widget_factory;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_widget_factory,"\$wp_widget_factory",$AspisChangesCache);
}$wp_widget_factory->unregister($widget_class);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_widget_factory",$AspisChangesCache);
 }
function register_sidebars ( $number = 1,$args = array() ) {
{global $wp_registered_sidebars;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_sidebars,"\$wp_registered_sidebars",$AspisChangesCache);
}$number = (int)$number;
if ( is_string($args))
 parse_str($args,$args);
for ( $i = 1 ; $i <= $number ; $i++ )
{$_args = $args;
if ( $number > 1)
 {$_args['name'] = isset($args['name']) ? sprintf($args['name'],$i) : sprintf(__('Sidebar %d'),$i);
}else 
{{$_args['name'] = isset($args['name']) ? $args['name'] : __('Sidebar');
}}if ( isset($args['id']))
 {$_args['id'] = $args['id'];
}else 
{{$n = count($wp_registered_sidebars);
do {$n++;
$_args['id'] = "sidebar-$n";
}while (isset($wp_registered_sidebars[$_args['id']]) )
;
}}register_sidebar($_args);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
 }
function register_sidebar ( $args = array() ) {
{global $wp_registered_sidebars;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_sidebars,"\$wp_registered_sidebars",$AspisChangesCache);
}if ( is_string($args))
 parse_str($args,$args);
$i = count($wp_registered_sidebars) + 1;
$defaults = array('name' => sprintf(__('Sidebar %d'),$i),'id' => "sidebar-$i",'description' => '','before_widget' => '<li id="%1$s" class="widget %2$s">','after_widget' => "</li>\n",'before_title' => '<h2 class="widgettitle">','after_title' => "</h2>\n",);
$sidebar = array_merge($defaults,(array)$args);
$wp_registered_sidebars[$sidebar['id']] = $sidebar;
{$AspisRetTemp = $sidebar['id'];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
 }
function unregister_sidebar ( $name ) {
{global $wp_registered_sidebars;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_sidebars,"\$wp_registered_sidebars",$AspisChangesCache);
}if ( isset($wp_registered_sidebars[$name]))
 unset($wp_registered_sidebars[$name]);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
 }
function wp_register_sidebar_widget ( $id,$name,$output_callback,$options = array() ) {
{global $wp_registered_widgets,$wp_registered_widget_controls,$wp_registered_widget_updates,$_wp_deprecated_widgets_callbacks;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widgets,"\$wp_registered_widgets",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_registered_widget_controls,"\$wp_registered_widget_controls",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_registered_widget_updates,"\$wp_registered_widget_updates",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($_wp_deprecated_widgets_callbacks,"\$_wp_deprecated_widgets_callbacks",$AspisChangesCache);
}$id = strtolower($id);
if ( empty($output_callback))
 {unset($wp_registered_widgets[$id]);
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widget_controls",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_registered_widget_updates",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_deprecated_widgets_callbacks",$AspisChangesCache);
return ;
}}$id_base = _get_widget_id_base($id);
if ( in_array($output_callback,$_wp_deprecated_widgets_callbacks,true) && !is_callable($output_callback))
 {if ( isset($wp_registered_widget_controls[$id]))
 unset($wp_registered_widget_controls[$id]);
if ( isset($wp_registered_widget_updates[$id_base]))
 unset($wp_registered_widget_updates[$id_base]);
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widget_controls",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_registered_widget_updates",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_deprecated_widgets_callbacks",$AspisChangesCache);
return ;
}}$defaults = array('classname' => $output_callback);
$options = wp_parse_args($options,$defaults);
$widget = array('name' => $name,'id' => $id,'callback' => $output_callback,'params' => array_slice(func_get_args(),4));
$widget = array_merge($widget,$options);
if ( is_callable($output_callback) && (!isset($wp_registered_widgets[$id]) || did_action('widgets_init')))
 $wp_registered_widgets[$id] = $widget;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widget_controls",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_registered_widget_updates",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_deprecated_widgets_callbacks",$AspisChangesCache);
 }
function wp_widget_description ( $id ) {
if ( !is_scalar($id))
 {return ;
}{global $wp_registered_widgets;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widgets,"\$wp_registered_widgets",$AspisChangesCache);
}if ( isset($wp_registered_widgets[$id]['description']))
 {$AspisRetTemp = esc_html($wp_registered_widgets[$id]['description']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
 }
function wp_sidebar_description ( $id ) {
if ( !is_scalar($id))
 {return ;
}{global $wp_registered_sidebars;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_sidebars,"\$wp_registered_sidebars",$AspisChangesCache);
}if ( isset($wp_registered_sidebars[$id]['description']))
 {$AspisRetTemp = esc_html($wp_registered_sidebars[$id]['description']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
 }
function wp_unregister_sidebar_widget ( $id ) {
wp_register_sidebar_widget($id,'','');
wp_unregister_widget_control($id);
 }
function wp_register_widget_control ( $id,$name,$control_callback,$options = array() ) {
{global $wp_registered_widget_controls,$wp_registered_widget_updates,$wp_registered_widgets,$_wp_deprecated_widgets_callbacks;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widget_controls,"\$wp_registered_widget_controls",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_registered_widget_updates,"\$wp_registered_widget_updates",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_registered_widgets,"\$wp_registered_widgets",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($_wp_deprecated_widgets_callbacks,"\$_wp_deprecated_widgets_callbacks",$AspisChangesCache);
}$id = strtolower($id);
$id_base = _get_widget_id_base($id);
if ( empty($control_callback))
 {unset($wp_registered_widget_controls[$id]);
unset($wp_registered_widget_updates[$id_base]);
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_controls",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widget_updates",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_deprecated_widgets_callbacks",$AspisChangesCache);
return ;
}}if ( in_array($control_callback,$_wp_deprecated_widgets_callbacks,true) && !is_callable($control_callback))
 {if ( isset($wp_registered_widgets[$id]))
 unset($wp_registered_widgets[$id]);
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_controls",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widget_updates",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_deprecated_widgets_callbacks",$AspisChangesCache);
return ;
}}if ( isset($wp_registered_widget_controls[$id]) && !did_action('widgets_init'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_controls",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widget_updates",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_deprecated_widgets_callbacks",$AspisChangesCache);
return ;
}$defaults = array('width' => 250,'height' => 200);
$options = wp_parse_args($options,$defaults);
$options['width'] = (int)$options['width'];
$options['height'] = (int)$options['height'];
$widget = array('name' => $name,'id' => $id,'callback' => $control_callback,'params' => array_slice(func_get_args(),4));
$widget = array_merge($widget,$options);
$wp_registered_widget_controls[$id] = $widget;
if ( isset($wp_registered_widget_updates[$id_base]))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_controls",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widget_updates",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_deprecated_widgets_callbacks",$AspisChangesCache);
return ;
}if ( isset($widget['params'][0]['number']))
 $widget['params'][0]['number'] = -1;
unset($widget['width'],$widget['height'],$widget['name'],$widget['id']);
$wp_registered_widget_updates[$id_base] = $widget;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_controls",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widget_updates",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$_wp_deprecated_widgets_callbacks",$AspisChangesCache);
 }
function _register_widget_update_callback ( $id_base,$update_callback,$options = array() ) {
{global $wp_registered_widget_updates;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widget_updates,"\$wp_registered_widget_updates",$AspisChangesCache);
}if ( isset($wp_registered_widget_updates[$id_base]))
 {if ( empty($update_callback))
 unset($wp_registered_widget_updates[$id_base]);
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_updates",$AspisChangesCache);
return ;
}}$widget = array('callback' => $update_callback,'params' => array_slice(func_get_args(),3));
$widget = array_merge($widget,$options);
$wp_registered_widget_updates[$id_base] = $widget;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_updates",$AspisChangesCache);
 }
function _register_widget_form_callback ( $id,$name,$form_callback,$options = array() ) {
{global $wp_registered_widget_controls;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widget_controls,"\$wp_registered_widget_controls",$AspisChangesCache);
}$id = strtolower($id);
if ( empty($form_callback))
 {unset($wp_registered_widget_controls[$id]);
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_controls",$AspisChangesCache);
return ;
}}if ( isset($wp_registered_widget_controls[$id]) && !did_action('widgets_init'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_controls",$AspisChangesCache);
return ;
}$defaults = array('width' => 250,'height' => 200);
$options = wp_parse_args($options,$defaults);
$options['width'] = (int)$options['width'];
$options['height'] = (int)$options['height'];
$widget = array('name' => $name,'id' => $id,'callback' => $form_callback,'params' => array_slice(func_get_args(),4));
$widget = array_merge($widget,$options);
$wp_registered_widget_controls[$id] = $widget;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widget_controls",$AspisChangesCache);
 }
function wp_unregister_widget_control ( $id ) {
{$AspisRetTemp = wp_register_widget_control($id,'','');
return $AspisRetTemp;
} }
function dynamic_sidebar ( $index = 1 ) {
{global $wp_registered_sidebars,$wp_registered_widgets;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_sidebars,"\$wp_registered_sidebars",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_registered_widgets,"\$wp_registered_widgets",$AspisChangesCache);
}if ( is_int($index))
 {$index = "sidebar-$index";
}else 
{{$index = sanitize_title($index);
foreach ( (array)$wp_registered_sidebars as $key =>$value )
{if ( sanitize_title($value['name']) == $index)
 {$index = $key;
break ;
}}}}$sidebars_widgets = wp_get_sidebars_widgets();
if ( empty($wp_registered_sidebars[$index]) || !array_key_exists($index,$sidebars_widgets) || !is_array($sidebars_widgets[$index]) || empty($sidebars_widgets[$index]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widgets",$AspisChangesCache);
return $AspisRetTemp;
}$sidebar = $wp_registered_sidebars[$index];
$did_one = false;
foreach ( (array)$sidebars_widgets[$index] as $id  )
{if ( !isset($wp_registered_widgets[$id]))
 continue ;
$params = array_merge(array(array_merge($sidebar,array('widget_id' => $id,'widget_name' => $wp_registered_widgets[$id]['name']))),(array)$wp_registered_widgets[$id]['params']);
$classname_ = '';
foreach ( (array)$wp_registered_widgets[$id]['classname'] as $cn  )
{if ( is_string($cn))
 $classname_ .= '_' . $cn;
elseif ( is_object($cn))
 $classname_ .= '_' . get_class($cn);
}$classname_ = ltrim($classname_,'_');
$params[0]['before_widget'] = sprintf($params[0]['before_widget'],$id,$classname_);
$params = apply_filters('dynamic_sidebar_params',$params);
$callback = $wp_registered_widgets[$id]['callback'];
if ( is_callable($callback))
 {AspisUntainted_call_user_func_array($callback,$params);
$did_one = true;
}}{$AspisRetTemp = $did_one;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widgets",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_widgets",$AspisChangesCache);
 }
function is_active_widget ( $callback = false,$widget_id = false,$id_base = false,$skip_inactive = true ) {
{global $wp_registered_widgets;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widgets,"\$wp_registered_widgets",$AspisChangesCache);
}$sidebars_widgets = wp_get_sidebars_widgets();
if ( is_array($sidebars_widgets))
 {foreach ( $sidebars_widgets as $sidebar =>$widgets )
{if ( $skip_inactive && 'wp_inactive_widgets' == $sidebar)
 continue ;
if ( is_array($widgets))
 {foreach ( $widgets as $widget  )
{if ( ($callback && isset($wp_registered_widgets[$widget]['callback']) && $wp_registered_widgets[$widget]['callback'] == $callback) || ($id_base && _get_widget_id_base($widget) == $id_base))
 {if ( !$widget_id || $widget_id == $wp_registered_widgets[$widget]['id'])
 {$AspisRetTemp = $sidebar;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
return $AspisRetTemp;
}}}}}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
 }
function is_dynamic_sidebar (  ) {
{global $wp_registered_widgets,$wp_registered_sidebars;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widgets,"\$wp_registered_widgets",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_registered_sidebars,"\$wp_registered_sidebars",$AspisChangesCache);
}$sidebars_widgets = get_option('sidebars_widgets');
foreach ( (array)$wp_registered_sidebars as $index =>$sidebar )
{if ( count($sidebars_widgets[$index]))
 {foreach ( (array)$sidebars_widgets[$index] as $widget  )
if ( array_key_exists($widget,$wp_registered_widgets))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_sidebars",$AspisChangesCache);
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_sidebars",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_sidebars",$AspisChangesCache);
 }
function is_active_sidebar ( $index ) {
$index = (is_int($index)) ? "sidebar-$index" : sanitize_title($index);
$sidebars_widgets = wp_get_sidebars_widgets();
if ( isset($sidebars_widgets[$index]) && !empty($sidebars_widgets[$index]))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_get_sidebars_widgets ( $deprecated = true ) {
{global $wp_registered_widgets,$wp_registered_sidebars,$_wp_sidebars_widgets;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_widgets,"\$wp_registered_widgets",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_registered_sidebars,"\$wp_registered_sidebars",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($_wp_sidebars_widgets,"\$_wp_sidebars_widgets",$AspisChangesCache);
}if ( !is_admin())
 {if ( empty($_wp_sidebars_widgets))
 $_wp_sidebars_widgets = get_option('sidebars_widgets',array());
$sidebars_widgets = $_wp_sidebars_widgets;
}else 
{{$sidebars_widgets = get_option('sidebars_widgets',array());
$_sidebars_widgets = array();
if ( isset($sidebars_widgets['wp_inactive_widgets']) || empty($sidebars_widgets))
 $sidebars_widgets['array_version'] = 3;
elseif ( !isset($sidebars_widgets['array_version']))
 $sidebars_widgets['array_version'] = 1;
switch ( $sidebars_widgets['array_version'] ) {
case 1:foreach ( (array)$sidebars_widgets as $index =>$sidebar )
if ( is_array($sidebar))
 foreach ( (array)$sidebar as $i =>$name )
{$id = strtolower($name);
if ( isset($wp_registered_widgets[$id]))
 {$_sidebars_widgets[$index][$i] = $id;
continue ;
}$id = sanitize_title($name);
if ( isset($wp_registered_widgets[$id]))
 {$_sidebars_widgets[$index][$i] = $id;
continue ;
}$found = false;
foreach ( $wp_registered_widgets as $widget_id =>$widget )
{if ( strtolower($widget['name']) == strtolower($name))
 {$_sidebars_widgets[$index][$i] = $widget['id'];
$found = true;
break ;
}elseif ( sanitize_title($widget['name']) == sanitize_title($name))
 {$_sidebars_widgets[$index][$i] = $widget['id'];
$found = true;
break ;
}}if ( $found)
 continue ;
unset($_sidebars_widgets[$index][$i]);
}$_sidebars_widgets['array_version'] = 2;
$sidebars_widgets = $_sidebars_widgets;
unset($_sidebars_widgets);
case 2:$sidebars = array_keys($wp_registered_sidebars);
if ( !empty($sidebars))
 {foreach ( (array)$sidebars as $id  )
{if ( array_key_exists($id,$sidebars_widgets))
 {$_sidebars_widgets[$id] = $sidebars_widgets[$id];
unset($sidebars_widgets[$id],$sidebars[$id]);
}}if ( !isset($_sidebars_widgets['wp_inactive_widgets']))
 $_sidebars_widgets['wp_inactive_widgets'] = array();
if ( !empty($sidebars_widgets))
 {foreach ( $sidebars_widgets as $lost =>$val )
{if ( is_array($val))
 $_sidebars_widgets['wp_inactive_widgets'] = array_merge((array)$_sidebars_widgets['wp_inactive_widgets'],$val);
}}$sidebars_widgets = $_sidebars_widgets;
unset($_sidebars_widgets);
} }
}}if ( isset($sidebars_widgets['array_version']))
 unset($sidebars_widgets['array_version']);
$sidebars_widgets = apply_filters('sidebars_widgets',$sidebars_widgets);
{$AspisRetTemp = $sidebars_widgets;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_sidebars",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$_wp_sidebars_widgets",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_widgets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_registered_sidebars",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$_wp_sidebars_widgets",$AspisChangesCache);
 }
function wp_set_sidebars_widgets ( $sidebars_widgets ) {
if ( !isset($sidebars_widgets['array_version']))
 $sidebars_widgets['array_version'] = 3;
update_option('sidebars_widgets',$sidebars_widgets);
 }
function wp_get_widget_defaults (  ) {
{global $wp_registered_sidebars;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_registered_sidebars,"\$wp_registered_sidebars",$AspisChangesCache);
}$defaults = array();
foreach ( (array)$wp_registered_sidebars as $index =>$sidebar )
$defaults[$index] = array();
{$AspisRetTemp = $defaults;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_registered_sidebars",$AspisChangesCache);
 }
function wp_convert_widget_settings ( $base_name,$option_name,$settings ) {
$single = $changed = false;
if ( empty($settings))
 {$single = true;
}else 
{{foreach ( array_keys($settings) as $number  )
{if ( 'number' == $number)
 continue ;
if ( !is_numeric($number))
 {$single = true;
break ;
}}}}if ( $single)
 {$settings = array(2 => $settings);
if ( is_admin())
 {$sidebars_widgets = get_option('sidebars_widgets');
}else 
{{if ( empty($GLOBALS[0]['_wp_sidebars_widgets']))
 $GLOBALS[0]['_wp_sidebars_widgets'] = get_option('sidebars_widgets',array());
$sidebars_widgets = &$GLOBALS[0]['_wp_sidebars_widgets'];
}}foreach ( (array)$sidebars_widgets as $index =>$sidebar )
{if ( is_array($sidebar))
 {foreach ( $sidebar as $i =>$name )
{if ( $base_name == $name)
 {$sidebars_widgets[$index][$i] = "$name-2";
$changed = true;
break 2;
}}}}if ( is_admin() && $changed)
 update_option('sidebars_widgets',$sidebars_widgets);
}$settings['_multiwidget'] = 1;
if ( is_admin())
 update_option($option_name,$settings);
{$AspisRetTemp = $settings;
return $AspisRetTemp;
} }
function register_sidebar_widget ( $name,$output_callback,$classname = '' ) {
if ( is_array($name))
 {if ( count($name) == 3)
 $name = sprintf($name[0],$name[2]);
else 
{$name = $name[0];
}}$id = sanitize_title($name);
$options = array();
if ( !empty($classname) && is_string($classname))
 $options['classname'] = $classname;
$params = array_slice(func_get_args(),2);
$args = array($id,$name,$output_callback,$options);
if ( !empty($params))
 $args = array_merge($args,$params);
AspisUntainted_call_user_func_array('wp_register_sidebar_widget',$args);
 }
function unregister_sidebar_widget ( $id ) {
{$AspisRetTemp = wp_unregister_sidebar_widget($id);
return $AspisRetTemp;
} }
function register_widget_control ( $name,$control_callback,$width = '',$height = '' ) {
if ( is_array($name))
 {if ( count($name) == 3)
 $name = sprintf($name[0],$name[2]);
else 
{$name = $name[0];
}}$id = sanitize_title($name);
$options = array();
if ( !empty($width))
 $options['width'] = $width;
if ( !empty($height))
 $options['height'] = $height;
$params = array_slice(func_get_args(),4);
$args = array($id,$name,$control_callback,$options);
if ( !empty($params))
 $args = array_merge($args,$params);
AspisUntainted_call_user_func_array('wp_register_widget_control',$args);
 }
function unregister_widget_control ( $id ) {
{$AspisRetTemp = wp_unregister_widget_control($id);
return $AspisRetTemp;
} }
function the_widget ( $widget,$instance = array(),$args = array() ) {
{global $wp_widget_factory;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_widget_factory,"\$wp_widget_factory",$AspisChangesCache);
}$widget_obj = $wp_widget_factory->widgets[$widget];
if ( !is_a($widget_obj,'WP_Widget'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_widget_factory",$AspisChangesCache);
return ;
}$before_widget = sprintf('<div class="widget %s">',$widget_obj->widget_options['classname']);
$default_args = array('before_widget' => $before_widget,'after_widget' => "</div>",'before_title' => '<h2 class="widgettitle">','after_title' => '</h2>');
$args = wp_parse_args($args,$default_args);
$instance = wp_parse_args($instance);
$widget_obj->_set(-1);
$widget_obj->widget($args,$instance);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_widget_factory",$AspisChangesCache);
 }
function _get_widget_id_base ( $id ) {
{$AspisRetTemp = preg_replace('/-[0-9]+$/','',$id);
return $AspisRetTemp;
} }
