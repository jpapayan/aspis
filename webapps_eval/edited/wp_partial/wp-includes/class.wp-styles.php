<?php require_once('AspisMain.php'); ?><?php
class WP_Styles extends WP_Dependencies{var $base_url;
var $content_url;
var $default_version;
var $text_direction = 'ltr';
var $concat = '';
var $concat_version = '';
var $do_concat = false;
var $print_html = '';
var $default_dirs;
function __construct (  ) {
{do_action_ref_array('wp_default_styles',array($this));
} }
function do_item ( $handle ) {
{if ( !parent::do_item($handle))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$ver = $this->registered[$handle]->ver ? $this->registered[$handle]->ver : $this->default_version;
if ( isset($this->args[$handle]))
 $ver .= '&amp;' . $this->args[$handle];
if ( $this->do_concat)
 {if ( $this->in_default_dir($this->registered[$handle]->src) && !isset($this->registered[$handle]->extra['conditional']) && !isset($this->registered[$handle]->extra['alt']))
 {$this->concat .= "$handle,";
$this->concat_version .= "$handle$ver";
{$AspisRetTemp = true;
return $AspisRetTemp;
}}}if ( isset($this->registered[$handle]->args))
 $media = esc_attr($this->registered[$handle]->args);
else 
{$media = 'all';
}$href = $this->_css_href($this->registered[$handle]->src,$ver,$handle);
$rel = isset($this->registered[$handle]->extra['alt']) && $this->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
$title = isset($this->registered[$handle]->extra['title']) ? "title='" . esc_attr($this->registered[$handle]->extra['title']) . "'" : '';
$end_cond = $tag = '';
if ( isset($this->registered[$handle]->extra['conditional']) && $this->registered[$handle]->extra['conditional'])
 {$tag .= "<!--[if {$this->registered[$handle]->extra['conditional']}]>\n";
$end_cond = "<![endif]-->\n";
}$tag .= apply_filters('style_loader_tag',"<link rel='$rel' id='$handle-css' $title href='$href' type='text/css' media='$media' />\n",$handle);
if ( 'rtl' === $this->text_direction && isset($this->registered[$handle]->extra['rtl']) && $this->registered[$handle]->extra['rtl'])
 {if ( is_bool($this->registered[$handle]->extra['rtl']))
 $rtl_href = str_replace('.css','-rtl.css',$this->_css_href($this->registered[$handle]->src,$ver,"$handle-rtl"));
else 
{$rtl_href = $this->_css_href($this->registered[$handle]->extra['rtl'],$ver,"$handle-rtl");
}$tag .= apply_filters('style_loader_tag',"<link rel='$rel' id='$handle-rtl-css' $title href='$rtl_href' type='text/css' media='$media' />\n",$handle);
}$tag .= $end_cond;
if ( $this->do_concat)
 $this->print_html .= $tag;
else 
{echo $tag;
}{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function all_deps ( $handles,$recursion = false,$group = false ) {
{$r = parent::all_deps($handles,$recursion);
if ( !$recursion)
 $this->to_do = apply_filters('print_styles_array',$this->to_do);
{$AspisRetTemp = $r;
return $AspisRetTemp;
}} }
function _css_href ( $src,$ver,$handle ) {
{if ( !preg_match('|^https?://|',$src) && !($this->content_url && 0 === strpos($src,$this->content_url)))
 {$src = $this->base_url . $src;
}$src = add_query_arg('ver',$ver,$src);
$src = apply_filters('style_loader_src',$src,$handle);
{$AspisRetTemp = esc_url($src);
return $AspisRetTemp;
}} }
function in_default_dir ( $src ) {
{if ( !$this->default_dirs)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}foreach ( (array)$this->default_dirs as $test  )
{if ( 0 === strpos($src,$test))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
}