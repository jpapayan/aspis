<?php require_once('AspisMain.php'); ?><?php
if ( (!(class_exists(('Translation_Entry')))))
 {class Translation_Entry{var $is_plural = array(false,false);
var $context = array(null,false);
var $singular = array(null,false);
var $plural = array(null,false);
var $translations = array(array(),false);
var $translator_comments = array('',false);
var $extracted_comments = array('',false);
var $references = array(array(),false);
var $flags = array(array(),false);
function Translation_Entry ( $args = array(array(),false) ) {
{if ( (!((isset($args[0][('singular')]) && Aspis_isset( $args [0][('singular')])))))
 {return ;
}$object_varnames = attAspisRC(array_keys(deAspisRC(attAspis(get_object_vars(deAspisRC(array($this,false)))))));
foreach ( $args[0] as $varname =>$value )
{restoreTaint($varname,$value);
{$this->$varname[0] = $value;
}}if ( ((isset($args[0][('plural')]) && Aspis_isset( $args [0][('plural')]))))
 $this->is_plural = array(true,false);
if ( (!(is_array($this->translations[0]))))
 $this->translations = array(array(),false);
if ( (!(is_array($this->references[0]))))
 $this->references = array(array(),false);
if ( (!(is_array($this->flags[0]))))
 $this->flags = array(array(),false);
} }
function key (  ) {
{if ( is_null(deAspisRC($this->singular)))
 return array(false,false);
return is_null(deAspisRC($this->context)) ? $this->singular : concat(concat($this->context,attAspis(chr((4)))),$this->singular);
} }
}}