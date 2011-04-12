<?php require_once('AspisMain.php'); ?><?php
class WP_Scripts extends WP_Dependencies{var $base_url;
var $content_url;
var $default_version;
var $in_footer = array(array(),false);
var $concat = array('',false);
var $concat_version = array('',false);
var $do_concat = array(false,false);
var $print_html = array('',false);
var $print_code = array('',false);
var $ext_handles = array('',false);
var $ext_version = array('',false);
var $default_dirs;
function __construct (  ) {
{do_action_ref_array(array('wp_default_scripts',false),array(array(array($this,false)),false));
} }
function print_scripts ( $handles = array(false,false),$group = array(false,false) ) {
{return $this->do_items($handles,$group);
} }
function print_scripts_l10n ( $handle,$echo = array(true,false) ) {
{if ( ((((empty($this->registered[0][$handle[0]][0]->extra[0][('l10n')]) || Aspis_empty( $this ->registered [0][$handle[0]][0] ->extra [0][('l10n')] ))) || ((empty($this->registered[0][$handle[0]][0]->extra[0][('l10n')][0][(0)]) || Aspis_empty( $this ->registered [0][$handle[0]][0] ->extra [0][('l10n')] [0][(0)] )))) || (!(is_array($this->registered[0][$handle[0]][0]->extra[0][('l10n')][0][(1)][0])))))
 return array(false,false);
$object_name = $this->registered[0][$handle[0]][0]->extra[0][('l10n')][0][(0)];
$data = concat2(concat1("var ",$object_name)," = {\n");
$eol = array('',false);
foreach ( $this->registered[0][$handle[0]][0]->extra[0][('l10n')][0][(1)][0] as $var =>$val )
{restoreTaint($var,$val);
{if ( (('l10n_print_after') == $var[0]))
 {$after = $val;
continue ;
}$data = concat($data,concat2(concat(concat2(concat(concat2($eol,"\t"),$var),": \""),esc_js($val)),'"'));
$eol = array(",\n",false);
}}$data = concat2($data,"\n};\n");
$data = concat($data,((isset($after) && Aspis_isset( $after))) ? concat2($after,"\n") : array('',false));
if ( $echo[0])
 {echo AspisCheckPrint(array("<script type='text/javascript'>\n",false));
echo AspisCheckPrint(array("/* <![CDATA[ */\n",false));
echo AspisCheckPrint($data);
echo AspisCheckPrint(array("/* ]]> */\n",false));
echo AspisCheckPrint(array("</script>\n",false));
return array(true,false);
}else 
{{return $data;
}}} }
function do_item ( $handle,$group = array(false,false) ) {
{if ( (denot_boolean(parent::do_item($handle))))
 return array(false,false);
if ( (((0) === $group[0]) && ($this->groups[0][$handle[0]][0] > (0))))
 {arrayAssignAdd($this->in_footer[0][],addTaint($handle));
return array(false,false);
}if ( ((false === $group[0]) && deAspis(Aspis_in_array($handle,$this->in_footer,array(true,false)))))
 $this->in_footer = Aspis_array_diff($this->in_footer,array_cast($handle));
$ver = $this->registered[0][$handle[0]][0]->ver[0] ? $this->registered[0][$handle[0]][0]->ver : $this->default_version;
if ( ((isset($this->args[0][$handle[0]]) && Aspis_isset( $this ->args [0][$handle[0]] ))))
 $ver = concat($ver,concat1('&amp;',$this->args[0][$handle[0]]));
$src = $this->registered[0][$handle[0]][0]->src;
if ( $this->do_concat[0])
 {$srce = apply_filters(array('script_loader_src',false),$src,$handle);
if ( deAspis($this->in_default_dir($srce)))
 {$this->print_code = concat($this->print_code ,$this->print_scripts_l10n($handle,array(false,false)));
$this->concat = concat($this->concat ,concat2($handle,","));
$this->concat_version = concat($this->concat_version ,concat($handle,$ver));
return array(true,false);
}else 
{{$this->ext_handles = concat($this->ext_handles ,concat2($handle,","));
$this->ext_version = concat($this->ext_version ,concat($handle,$ver));
}}}$this->print_scripts_l10n($handle);
if ( ((denot_boolean(Aspis_preg_match(array('|^https?://|',false),$src))) && (!($this->content_url[0] && ((0) === strpos($src[0],deAspisRC($this->content_url)))))))
 {$src = concat($this->base_url,$src);
}$src = add_query_arg(array('ver',false),$ver,$src);
$src = esc_url(apply_filters(array('script_loader_src',false),$src,$handle));
if ( $this->do_concat[0])
 $this->print_html = concat($this->print_html ,concat2(concat1("<script type='text/javascript' src='",$src),"'></script>\n"));
else 
{echo AspisCheckPrint(concat2(concat1("<script type='text/javascript' src='",$src),"'></script>\n"));
}return array(true,false);
} }
function localize ( $handle,$object_name,$l10n ) {
{if ( ((denot_boolean($object_name)) || (denot_boolean($l10n))))
 return array(false,false);
return $this->add_data($handle,array('l10n',false),array(array($object_name,$l10n),false));
} }
function set_group ( $handle,$recursion,$group = array(false,false) ) {
{$grp = ((isset($this->registered[0][$handle[0]][0]->extra[0][('group')]) && Aspis_isset( $this ->registered [0][$handle[0]][0] ->extra [0][('group')] ))) ? int_cast($this->registered[0][$handle[0]][0]->extra[0][('group')]) : array(0,false);
if ( ((false !== $group[0]) && ($grp[0] > $group[0])))
 $grp = $group;
return parent::set_group($handle,$recursion,$grp);
} }
function all_deps ( $handles,$recursion = array(false,false),$group = array(false,false) ) {
{$r = parent::all_deps($handles,$recursion);
if ( (denot_boolean($recursion)))
 $this->to_do = apply_filters(array('print_scripts_array',false),$this->to_do);
return $r;
} }
function do_head_items (  ) {
{$this->do_items(array(false,false),array(0,false));
return $this->done;
} }
function do_footer_items (  ) {
{if ( (!((empty($this->in_footer) || Aspis_empty( $this ->in_footer )))))
 {foreach ( $this->in_footer[0] as $key =>$handle )
{restoreTaint($key,$handle);
{if ( ((denot_boolean(Aspis_in_array($handle,$this->done,array(true,false)))) && ((isset($this->registered[0][$handle[0]]) && Aspis_isset( $this ->registered [0][$handle[0]] )))))
 {$this->do_item($handle);
arrayAssignAdd($this->done[0][],addTaint($handle));
unset($this->in_footer[0][$key[0]]);
}}}}return $this->done;
} }
function in_default_dir ( $src ) {
{if ( (denot_boolean($this->default_dirs)))
 return array(true,false);
foreach ( deAspis(array_cast($this->default_dirs)) as $test  )
{if ( ((0) === strpos($src[0],deAspisRC($test))))
 return array(true,false);
}return array(false,false);
} }
function reset (  ) {
{$this->do_concat = array(false,false);
$this->print_code = array('',false);
$this->concat = array('',false);
$this->concat_version = array('',false);
$this->print_html = array('',false);
$this->ext_version = array('',false);
$this->ext_handles = array('',false);
} }
}