<?php require_once('AspisMain.php'); ?><?php
if ( !class_exists('Translation_Entry'))
 {class Translation_Entry{var $is_plural = false;
var $context = null;
var $singular = null;
var $plural = null;
var $translations = array();
var $translator_comments = '';
var $extracted_comments = '';
var $references = array();
var $flags = array();
function Translation_Entry ( $args = array() ) {
{if ( !isset($args['singular']))
 {{return ;
}}$object_varnames = array_keys(get_object_vars($this));
foreach ( $args as $varname =>$value )
{$this->$varname = $value;
}if ( isset($args['plural']))
 $this->is_plural = true;
if ( !is_array($this->translations))
 $this->translations = array();
if ( !is_array($this->references))
 $this->references = array();
if ( !is_array($this->flags))
 $this->flags = array();
} }
function key (  ) {
{if ( is_null($this->singular))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = is_null($this->context) ? $this->singular : $this->context . chr(4) . $this->singular;
return $AspisRetTemp;
}} }
}}