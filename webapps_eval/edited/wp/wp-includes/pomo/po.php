<?php require_once('AspisMain.php'); ?><?php
require_once (deconcat2(Aspis_dirname(array(__FILE__,false)),'/translations.php'));
define(('PO_MAX_LINE_LEN'),79);
ini_set('auto_detect_line_endings',1);
if ( (!(class_exists(('PO')))))
 {class PO extends Gettext_Translations{function export_headers (  ) {
{$header_string = array('',false);
foreach ( $this->headers[0] as $header =>$value )
{restoreTaint($header,$value);
{$header_string = concat($header_string,concat2(concat(concat2($header,": "),$value),"\n"));
}}$poified = PO::poify($header_string);
return Aspis_rtrim(concat1("msgid \"\"\nmsgstr ",$poified));
} }
function export_entries (  ) {
{return Aspis_implode(array("\n\n",false),attAspisRC(array_map(AspisInternalCallback(array(array(array('PO',false),array('export_entry',false)),false)),deAspisRC($this->entries))));
} }
function export ( $include_headers = array(true,false) ) {
{$res = array('',false);
if ( $include_headers[0])
 {$res = concat($res,$this->export_headers());
$res = concat2($res,"\n\n");
}$res = concat($res,$this->export_entries());
return $res;
} }
function export_to_file ( $filename,$include_headers = array(true,false) ) {
{$fh = attAspis(fopen($filename[0],('w')));
if ( (false === $fh[0]))
 return array(false,false);
$export = $this->export($include_headers);
$res = attAspis(fwrite($fh[0],$export[0]));
if ( (false === $res[0]))
 return array(false,false);
return attAspis(fclose($fh[0]));
} }
function poify ( $string ) {
{$quote = array('"',false);
$slash = array('\\',false);
$newline = array("\n",false);
$replaces = array(array(deregisterTaint($slash) => addTaint(concat($slash,$slash)),deregisterTaint($quote) => addTaint(concat($slash,$quote)),"\t" => array('\t',false,false),),false);
$string = Aspis_str_replace(attAspisRC(array_keys(deAspisRC($replaces))),Aspis_array_values($replaces),$string);
$po = concat(concat($quote,Aspis_implode(concat(concat(concat(concat2($slash,"n"),$quote),$newline),$quote),Aspis_explode($newline,$string))),$quote);
if ( ((false !== strpos($string[0],deAspisRC($newline))) && ((substr_count($string[0],$newline[0]) > (1)) || (!($newline[0] === deAspis(Aspis_substr($string,negate(attAspis(strlen($newline[0]))))))))))
 {$po = concat(concat(concat($quote,$quote),$newline),$po);
}$po = Aspis_str_replace(concat(concat($newline,$quote),$quote),array('',false),$po);
return $po;
} }
function unpoify ( $string ) {
{$escapes = array(array('t' => array("\t",false,false),'n' => array("\n",false,false),'\\' => array('\\',false,false)),false);
$lines = attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC(Aspis_explode(array("\n",false),$string))));
$lines = attAspisRC(array_map(AspisInternalCallback(array(array(array('PO',false),array('trim_quotes',false)),false)),deAspisRC($lines)));
$unpoified = array('',false);
$previous_is_backslash = array(false,false);
foreach ( $lines[0] as $line  )
{Aspis_preg_match_all(array('/./u',false),$line,$chars);
$chars = attachAspis($chars,(0));
foreach ( $chars[0] as $char  )
{if ( (denot_boolean($previous_is_backslash)))
 {if ( (('\\') == $char[0]))
 $previous_is_backslash = array(true,false);
else 
{$unpoified = concat($unpoified,$char);
}}else 
{{$previous_is_backslash = array(false,false);
$unpoified = concat($unpoified,((isset($escapes[0][$char[0]]) && Aspis_isset( $escapes [0][$char[0]]))) ? attachAspis($escapes,$char[0]) : $char);
}}}}return $unpoified;
} }
function prepend_each_line ( $string,$with ) {
{$php_with = Aspis_var_export($with,array(true,false));
$lines = Aspis_explode(array("\n",false),$string);
if ( (("\n") == deAspis(Aspis_substr($string,negate(array(1,false))))))
 unset($lines[0][(count($lines[0]) - (1))]);
$res = Aspis_implode(array("\n",false),attAspisRC(array_map(AspisInternalCallback(Aspis_create_function(array('$x',false),concat2(concat1("return ",$php_with),".\$x;"))),deAspisRC($lines))));
if ( (("\n") == deAspis(Aspis_substr($string,negate(array(1,false))))))
 $res = concat2($res,"\n");
return $res;
} }
function comment_block ( $text,$char = array(' ',false) ) {
{$text = Aspis_wordwrap($text,array(PO_MAX_LINE_LEN - (3),false));
return PO::prepend_each_line($text,concat2(concat1("#",$char)," "));
} }
function export_entry ( &$entry ) {
{if ( is_null(deAspisRC($entry[0]->singular)))
 return array(false,false);
$po = array(array(),false);
if ( (!((empty($entry[0]->translator_comments) || Aspis_empty( $entry[0] ->translator_comments )))))
 arrayAssignAdd($po[0][],addTaint(PO::comment_block($entry[0]->translator_comments)));
if ( (!((empty($entry[0]->extracted_comments) || Aspis_empty( $entry[0] ->extracted_comments )))))
 arrayAssignAdd($po[0][],addTaint(PO::comment_block($entry[0]->extracted_comments,array('.',false))));
if ( (!((empty($entry[0]->references) || Aspis_empty( $entry[0] ->references )))))
 arrayAssignAdd($po[0][],addTaint(PO::comment_block(Aspis_implode(array(' ',false),$entry[0]->references),array(':',false))));
if ( (!((empty($entry[0]->flags) || Aspis_empty( $entry[0] ->flags )))))
 arrayAssignAdd($po[0][],addTaint(PO::comment_block(Aspis_implode(array(", ",false),$entry[0]->flags),array(',',false))));
if ( (!(is_null(deAspisRC($entry[0]->context)))))
 arrayAssignAdd($po[0][],addTaint(concat1('msgctxt ',PO::poify($entry[0]->context))));
arrayAssignAdd($po[0][],addTaint(concat1('msgid ',PO::poify($entry[0]->singular))));
if ( (denot_boolean($entry[0]->is_plural)))
 {$translation = ((empty($entry[0]->translations) || Aspis_empty( $entry[0] ->translations ))) ? array('',false) : $entry[0]->translations[0][(0)];
arrayAssignAdd($po[0][],addTaint(concat1('msgstr ',PO::poify($translation))));
}else 
{{arrayAssignAdd($po[0][],addTaint(concat1('msgid_plural ',PO::poify($entry[0]->plural))));
$translations = ((empty($entry[0]->translations) || Aspis_empty( $entry[0] ->translations ))) ? array(array(array('',false),array('',false)),false) : $entry[0]->translations;
foreach ( $translations[0] as $i =>$translation )
{restoreTaint($i,$translation);
{arrayAssignAdd($po[0][],addTaint(concat(concat2(concat1("msgstr[",$i),"] "),PO::poify($translation))));
}}}}return Aspis_implode(array("\n",false),$po);
} }
function import_from_file ( $filename ) {
{$f = attAspis(fopen($filename[0],('r')));
if ( (denot_boolean($f)))
 return array(false,false);
$lineno = array(0,false);
while ( true )
{$res = $this->read_entry($f,$lineno);
if ( (denot_boolean($res)))
 break ;
if ( ($res[0][('entry')][0]->singular[0] == ('')))
 {$this->set_headers($this->make_headers($res[0][('entry')][0]->translations[0][(0)]));
}else 
{{$this->add_entry($res[0]['entry']);
}}}PO::read_line($f,array('clear',false));
return array($res[0] !== false,false);
} }
function read_entry ( $f,$lineno = array(0,false) ) {
{$entry = array(new Translation_Entry(),false);
$context = array('',false);
$msgstr_index = array(0,false);
$is_final = Aspis_create_function(array('$context',false),array('return $context == "msgstr" || $context == "msgstr_plural";',false));
while ( true )
{postincr($lineno);
$line = PO::read_line($f);
if ( (denot_boolean($line)))
 {if ( feof($f[0]))
 {if ( deAspis(AspisDynamicCall($is_final,$context)))
 break ;
elseif ( (denot_boolean($context)))
 return array(null,false);
else 
{return array(false,false);
}}else 
{{return array(false,false);
}}}if ( ($line[0] == ("\n")))
 continue ;
$line = Aspis_trim($line);
if ( deAspis(Aspis_preg_match(array('/^#/',false),$line,$m)))
 {if ( deAspis(AspisDynamicCall($is_final,$context)))
 {PO::read_line($f,array('put-back',false));
postdecr($lineno);
break ;
}if ( ($context[0] && ($context[0] != ('comment'))))
 {return array(false,false);
}$this->add_comment_to_entry($entry,$line);
;
}elseif ( deAspis(Aspis_preg_match(array('/^msgctxt\s+(".*")/',false),$line,$m)))
 {if ( deAspis(AspisDynamicCall($is_final,$context)))
 {PO::read_line($f,array('put-back',false));
postdecr($lineno);
break ;
}if ( ($context[0] && ($context[0] != ('comment'))))
 {return array(false,false);
}$context = array('msgctxt',false);
$entry[0]->context = concat($entry[0]->context ,PO::unpoify(attachAspis($m,(1))));
}elseif ( deAspis(Aspis_preg_match(array('/^msgid\s+(".*")/',false),$line,$m)))
 {if ( deAspis(AspisDynamicCall($is_final,$context)))
 {PO::read_line($f,array('put-back',false));
postdecr($lineno);
break ;
}if ( (($context[0] && ($context[0] != ('msgctxt'))) && ($context[0] != ('comment'))))
 {return array(false,false);
}$context = array('msgid',false);
$entry[0]->singular = concat($entry[0]->singular ,PO::unpoify(attachAspis($m,(1))));
}elseif ( deAspis(Aspis_preg_match(array('/^msgid_plural\s+(".*")/',false),$line,$m)))
 {if ( ($context[0] != ('msgid')))
 {return array(false,false);
}$context = array('msgid_plural',false);
$entry[0]->is_plural = array(true,false);
$entry[0]->plural = concat($entry[0]->plural ,PO::unpoify(attachAspis($m,(1))));
}elseif ( deAspis(Aspis_preg_match(array('/^msgstr\s+(".*")/',false),$line,$m)))
 {if ( ($context[0] != ('msgid')))
 {return array(false,false);
}$context = array('msgstr',false);
$entry[0]->translations = array(array(PO::unpoify(attachAspis($m,(1)))),false);
}elseif ( deAspis(Aspis_preg_match(array('/^msgstr\[(\d+)\]\s+(".*")/',false),$line,$m)))
 {if ( (($context[0] != ('msgid_plural')) && ($context[0] != ('msgstr_plural'))))
 {return array(false,false);
}$context = array('msgstr_plural',false);
$msgstr_index = attachAspis($m,(1));
arrayAssign($entry[0]->translations[0],deAspis(registerTaint(attachAspis($m,(1)))),addTaint(PO::unpoify(attachAspis($m,(2)))));
}elseif ( deAspis(Aspis_preg_match(array('/^".*"$/',false),$line)))
 {$unpoified = PO::unpoify($line);
switch ( $context[0] ) {
case ('msgid'):$entry[0]->singular = concat($entry[0]->singular ,$unpoified);
break ;
case ('msgctxt'):$entry[0]->context = concat($entry[0]->context ,$unpoified);
break ;
case ('msgid_plural'):$entry[0]->plural = concat($entry[0]->plural ,$unpoified);
break ;
case ('msgstr'):arrayAssign($entry[0]->translations[0],deAspis(registerTaint(array(0,false))),addTaint(concat($entry[0]->translations[0][(0)] ,$unpoified)));
break ;
case ('msgstr_plural'):arrayAssign($entry[0]->translations[0],deAspis(registerTaint($msgstr_index)),addTaint(concat($entry[0]->translations[0][$msgstr_index[0]] ,$unpoified)));
break ;
default :return array(false,false);
 }
}else 
{{return array(false,false);
}}}if ( ((array()) == deAspis(attAspisRC(array_filter(deAspisRC($entry[0]->translations),AspisInternalCallback(Aspis_create_function(array('$t',false),array('return $t || "0" === $t;',false))))))))
 {$entry[0]->translations = array(array(),false);
}return array(array(deregisterTaint(array('entry',false)) => addTaint($entry),deregisterTaint(array('lineno',false)) => addTaint($lineno)),false);
} }
function read_line ( $f,$action = array('read',false) ) {
{static $last_line = array('',false);
static $use_last_line = array(false,false);
if ( (('clear') == $action[0]))
 {$last_line = array('',false);
return array(true,false);
}if ( (('put-back') == $action[0]))
 {$use_last_line = array(true,false);
return array(true,false);
}$line = $use_last_line[0] ? $last_line : attAspis(fgets($f[0]));
$last_line = $line;
$use_last_line = array(false,false);
return $line;
} }
function add_comment_to_entry ( &$entry,$po_comment_line ) {
{$first_two = Aspis_substr($po_comment_line,array(0,false),array(2,false));
$comment = Aspis_trim(Aspis_substr($po_comment_line,array(2,false)));
if ( (('#:') == $first_two[0]))
 {$entry[0]->references = Aspis_array_merge($entry[0]->references,Aspis_preg_split(array('/\s+/',false),$comment));
}elseif ( (('#.') == $first_two[0]))
 {$entry[0]->extracted_comments = Aspis_trim(concat(concat2($entry[0]->extracted_comments,"\n"),$comment));
}elseif ( (('#,') == $first_two[0]))
 {$entry[0]->flags = Aspis_array_merge($entry[0]->flags,Aspis_preg_split(array('/,\s*/',false),$comment));
}else 
{{$entry[0]->translator_comments = Aspis_trim(concat(concat2($entry[0]->translator_comments,"\n"),$comment));
}}} }
function trim_quotes ( $s ) {
{if ( (deAspis(Aspis_substr($s,array(0,false),array(1,false))) == ('"')))
 $s = Aspis_substr($s,array(1,false));
if ( (deAspis(Aspis_substr($s,negate(array(1,false)),array(1,false))) == ('"')))
 $s = Aspis_substr($s,array(0,false),negate(array(1,false)));
return $s;
} }
}}