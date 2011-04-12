<?php require_once('AspisMain.php'); ?><?php
class WP_Styles extends WP_Dependencies{var $base_url;
var $content_url;
var $default_version;
var $text_direction = array('ltr',false);
var $concat = array('',false);
var $concat_version = array('',false);
var $do_concat = array(false,false);
var $print_html = array('',false);
var $default_dirs;
function __construct (  ) {
{do_action_ref_array(array('wp_default_styles',false),array(array(array($this,false)),false));
} }
function do_item ( $handle ) {
{if ( (denot_boolean(parent::do_item($handle))))
 return array(false,false);
$ver = $this->registered[0][$handle[0]][0]->ver[0] ? $this->registered[0][$handle[0]][0]->ver : $this->default_version;
if ( ((isset($this->args[0][$handle[0]]) && Aspis_isset( $this ->args [0][$handle[0]] ))))
 $ver = concat($ver,concat1('&amp;',$this->args[0][$handle[0]]));
if ( $this->do_concat[0])
 {if ( ((deAspis($this->in_default_dir($this->registered[0][$handle[0]][0]->src)) && (!((isset($this->registered[0][$handle[0]][0]->extra[0][('conditional')]) && Aspis_isset( $this ->registered [0][$handle[0]][0] ->extra [0][('conditional')] ))))) && (!((isset($this->registered[0][$handle[0]][0]->extra[0][('alt')]) && Aspis_isset( $this ->registered [0][$handle[0]][0] ->extra [0][('alt')] ))))))
 {$this->concat = concat($this->concat ,concat2($handle,","));
$this->concat_version = concat($this->concat_version ,concat($handle,$ver));
return array(true,false);
}}if ( ((isset($this->registered[0][$handle[0]][0]->args) && Aspis_isset( $this ->registered [0][$handle[0]][0] ->args ))))
 $media = esc_attr($this->registered[0][$handle[0]][0]->args);
else 
{$media = array('all',false);
}$href = $this->_css_href($this->registered[0][$handle[0]][0]->src,$ver,$handle);
$rel = (((isset($this->registered[0][$handle[0]][0]->extra[0][('alt')]) && Aspis_isset( $this ->registered [0][$handle[0]][0] ->extra [0][('alt')] ))) && $this->registered[0][$handle[0]][0]->extra[0][('alt')][0]) ? array('alternate stylesheet',false) : array('stylesheet',false);
$title = ((isset($this->registered[0][$handle[0]][0]->extra[0][('title')]) && Aspis_isset( $this ->registered [0][$handle[0]][0] ->extra [0][('title')] ))) ? concat2(concat1("title='",esc_attr($this->registered[0][$handle[0]][0]->extra[0][('title')])),"'") : array('',false);
$end_cond = $tag = array('',false);
if ( (((isset($this->registered[0][$handle[0]][0]->extra[0][('conditional')]) && Aspis_isset( $this ->registered [0][$handle[0]][0] ->extra [0][('conditional')] ))) && $this->registered[0][$handle[0]][0]->extra[0][('conditional')][0]))
 {$tag = concat($tag,concat2(concat1("<!--[if ",$this->registered[0][$handle[0]][0]->extra[0][('conditional')]),"]>\n"));
$end_cond = array("<![endif]-->\n",false);
}$tag = concat($tag,apply_filters(array('style_loader_tag',false),concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<link rel='",$rel),"' id='"),$handle),"-css' "),$title)," href='"),$href),"' type='text/css' media='"),$media),"' />\n"),$handle));
if ( (((('rtl') === $this->text_direction[0]) && ((isset($this->registered[0][$handle[0]][0]->extra[0][('rtl')]) && Aspis_isset( $this ->registered [0][$handle[0]][0] ->extra [0][('rtl')] )))) && $this->registered[0][$handle[0]][0]->extra[0][('rtl')][0]))
 {if ( is_bool(deAspisRC($this->registered[0][$handle[0]][0]->extra[0][('rtl')])))
 $rtl_href = Aspis_str_replace(array('.css',false),array('-rtl.css',false),$this->_css_href($this->registered[0][$handle[0]][0]->src,$ver,concat2($handle,"-rtl")));
else 
{$rtl_href = $this->_css_href($this->registered[0][$handle[0]][0]->extra[0][('rtl')],$ver,concat2($handle,"-rtl"));
}$tag = concat($tag,apply_filters(array('style_loader_tag',false),concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<link rel='",$rel),"' id='"),$handle),"-rtl-css' "),$title)," href='"),$rtl_href),"' type='text/css' media='"),$media),"' />\n"),$handle));
}$tag = concat($tag,$end_cond);
if ( $this->do_concat[0])
 $this->print_html = concat($this->print_html ,$tag);
else 
{echo AspisCheckPrint($tag);
}return array(true,false);
} }
function all_deps ( $handles,$recursion = array(false,false),$group = array(false,false) ) {
{$r = parent::all_deps($handles,$recursion);
if ( (denot_boolean($recursion)))
 $this->to_do = apply_filters(array('print_styles_array',false),$this->to_do);
return $r;
} }
function _css_href ( $src,$ver,$handle ) {
{if ( ((denot_boolean(Aspis_preg_match(array('|^https?://|',false),$src))) && (!($this->content_url[0] && ((0) === strpos($src[0],deAspisRC($this->content_url)))))))
 {$src = concat($this->base_url,$src);
}$src = add_query_arg(array('ver',false),$ver,$src);
$src = apply_filters(array('style_loader_src',false),$src,$handle);
return esc_url($src);
} }
function in_default_dir ( $src ) {
{if ( (denot_boolean($this->default_dirs)))
 return array(true,false);
foreach ( deAspis(array_cast($this->default_dirs)) as $test  )
{if ( ((0) === strpos($src[0],deAspisRC($test))))
 return array(true,false);
}return array(false,false);
} }
}