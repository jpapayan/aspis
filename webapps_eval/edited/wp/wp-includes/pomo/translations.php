<?php require_once('AspisMain.php'); ?><?php
require_once (deconcat2(Aspis_dirname(array(__FILE__,false)),'/entry.php'));
if ( (!(class_exists(('Translations')))))
 {class Translations{var $entries = array(array(),false);
var $headers = array(array(),false);
function add_entry ( $entry ) {
{if ( is_array($entry[0]))
 {$entry = array(new Translation_Entry($entry),false);
}$key = $entry[0]->key();
if ( (false === $key[0]))
 return array(false,false);
$this->entries[0][deAspis(registerTaint($key))] = &addTaintR($entry);
return array(true,false);
} }
function set_header ( $header,$value ) {
{arrayAssign($this->headers[0],deAspis(registerTaint($header)),addTaint($value));
} }
function set_headers ( &$headers ) {
{foreach ( $headers[0] as $header =>$value )
{restoreTaint($header,$value);
{$this->set_header($header,$value);
}}} }
function get_header ( $header ) {
{return ((isset($this->headers[0][$header[0]]) && Aspis_isset( $this ->headers [0][$header[0]] ))) ? $this->headers[0][$header[0]] : array(false,false);
} }
function translate_entry ( &$entry ) {
{$key = $entry[0]->key();
return ((isset($this->entries[0][$key[0]]) && Aspis_isset( $this ->entries [0][$key[0]] ))) ? $this->entries[0][$key[0]] : array(false,false);
} }
function translate ( $singular,$context = array(null,false) ) {
{$entry = array(new Translation_Entry(array(array(deregisterTaint(array('singular',false)) => addTaint($singular),deregisterTaint(array('context',false)) => addTaint($context)),false)),false);
$translated = $this->translate_entry($entry);
return ($translated[0] && (!((empty($translated[0]->translations) || Aspis_empty( $translated[0] ->translations ))))) ? $translated[0]->translations[0][(0)] : $singular;
} }
function select_plural_form ( $count ) {
{return ((1) == $count[0]) ? array(0,false) : array(1,false);
} }
function get_plural_forms_count (  ) {
{return array(2,false);
} }
function translate_plural ( $singular,$plural,$count,$context = array(null,false) ) {
{$entry = array(new Translation_Entry(array(array(deregisterTaint(array('singular',false)) => addTaint($singular),deregisterTaint(array('plural',false)) => addTaint($plural),deregisterTaint(array('context',false)) => addTaint($context)),false)),false);
$translated = $this->translate_entry($entry);
$index = $this->select_plural_form($count);
$total_plural_forms = $this->get_plural_forms_count();
if ( (((($translated[0] && ((0) <= $index[0])) && ($index[0] < $total_plural_forms[0])) && is_array($translated[0]->translations[0])) && ((isset($translated[0]->translations[0][$index[0]]) && Aspis_isset( $translated[0] ->translations [0][$index[0]] )))))
 return $translated[0]->translations[0][$index[0]];
else 
{return ((1) == $count[0]) ? $singular : $plural;
}} }
function merge_with ( &$other ) {
{$this->entries = Aspis_array_merge($this->entries,$other[0]->entries);
} }
}class Gettext_Translations extends Translations{function gettext_select_plural_form ( $count ) {
{if ( ((!((isset($this->_gettext_select_plural_form) && Aspis_isset( $this ->_gettext_select_plural_form )))) || is_null(deAspisRC($this->_gettext_select_plural_form))))
 {list($nplurals,$expression) = deAspisList($this->nplurals_and_expression_from_header($this->get_header(array('Plural-Forms',false))),array());
$this->_nplurals = $nplurals;
$this->_gettext_select_plural_form = $this->make_plural_form_function($nplurals,$expression);
}return Aspis_call_user_func($this->_gettext_select_plural_form,$count);
} }
function nplurals_and_expression_from_header ( $header ) {
{if ( deAspis(Aspis_preg_match(array('/^\s*nplurals\s*=\s*(\d+)\s*;\s+plural\s*=\s*(.+)$/',false),$header,$matches)))
 {$nplurals = int_cast(attachAspis($matches,(1)));
$expression = Aspis_trim($this->parenthesize_plural_exression(attachAspis($matches,(2))));
return array(array($nplurals,$expression),false);
}else 
{{return array(array(array(2,false),array('n != 1',false)),false);
}}} }
function make_plural_form_function ( $nplurals,$expression ) {
{$expression = Aspis_str_replace(array('n',false),array('$n',false),$expression);
$func_body = concat2(concat(concat2(concat(concat2(concat1("
			\$index = (int)(",$expression),");
			return (\$index < "),$nplurals),")? \$index : "),$nplurals)," - 1;");
return Aspis_create_function(array('$n',false),$func_body);
} }
function parenthesize_plural_exression ( $expression ) {
{$expression = concat2($expression,';');
$res = array('',false);
$depth = array(0,false);
for ( $i = array(0,false) ; ($i[0] < strlen($expression[0])) ; preincr($i) )
{$char = attachAspis($expression,$i[0]);
switch ( $char[0] ) {
case ('?'):$res = concat2($res,' ? (');
postincr($depth);
break ;
case (':'):$res = concat2($res,') : (');
break ;
case (';'):$res = concat($res,concat2(Aspis_str_repeat(array(')',false),$depth),';'));
$depth = array(0,false);
break ;
default :$res = concat($res,$char);
 }
}return Aspis_rtrim($res,array(';',false));
} }
function make_headers ( $translation ) {
{$headers = array(array(),false);
$translation = Aspis_str_replace(array('\n',false),array("\n",false),$translation);
$lines = Aspis_explode(array("\n",false),$translation);
foreach ( $lines[0] as $line  )
{$parts = Aspis_explode(array(':',false),$line,array(2,false));
if ( (!((isset($parts[0][(1)]) && Aspis_isset( $parts [0][(1)])))))
 continue ;
arrayAssign($headers[0],deAspis(registerTaint(Aspis_trim(attachAspis($parts,(0))))),addTaint(Aspis_trim(attachAspis($parts,(1)))));
}return $headers;
} }
function set_header ( $header,$value ) {
{parent::set_header($header,$value);
if ( (('Plural-Forms') == $header[0]))
 {list($nplurals,$expression) = deAspisList($this->nplurals_and_expression_from_header($this->get_header(array('Plural-Forms',false))),array());
$this->_nplurals = $nplurals;
$this->_gettext_select_plural_form = $this->make_plural_form_function($nplurals,$expression);
}} }
}}if ( (!(class_exists(('NOOP_Translations')))))
 {class NOOP_Translations{var $entries = array(array(),false);
var $headers = array(array(),false);
function add_entry ( $entry ) {
{return array(true,false);
} }
function set_header ( $header,$value ) {
{} }
function set_headers ( &$headers ) {
{} }
function get_header ( $header ) {
{return array(false,false);
} }
function translate_entry ( &$entry ) {
{return array(false,false);
} }
function translate ( $singular,$context = array(null,false) ) {
{return $singular;
} }
function select_plural_form ( $count ) {
{return ((1) == $count[0]) ? array(0,false) : array(1,false);
} }
function get_plural_forms_count (  ) {
{return array(2,false);
} }
function translate_plural ( $singular,$plural,$count,$context = array(null,false) ) {
{return ((1) == $count[0]) ? $singular : $plural;
} }
function merge_with ( &$other ) {
{} }
}}