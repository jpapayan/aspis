<?php require_once('AspisMain.php'); ?><?php
require_once dirname(__FILE__) . '/translations.php';
define('PO_MAX_LINE_LEN',79);
ini_set('auto_detect_line_endings',1);
if ( !class_exists('PO'))
 {class PO extends Gettext_Translations{function export_headers (  ) {
{$header_string = '';
foreach ( $this->headers as $header =>$value )
{$header_string .= "$header: $value\n";
}$poified = PO::poify($header_string);
{$AspisRetTemp = rtrim("msgid \"\"\nmsgstr $poified");
return $AspisRetTemp;
}} }
function export_entries (  ) {
{{$AspisRetTemp = implode("\n\n",array_map(array('PO','export_entry'),$this->entries));
return $AspisRetTemp;
}} }
function export ( $include_headers = true ) {
{$res = '';
if ( $include_headers)
 {$res .= $this->export_headers();
$res .= "\n\n";
}$res .= $this->export_entries();
{$AspisRetTemp = $res;
return $AspisRetTemp;
}} }
function export_to_file ( $filename,$include_headers = true ) {
{$fh = fopen($filename,'w');
if ( false === $fh)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$export = $this->export($include_headers);
$res = fwrite($fh,$export);
if ( false === $res)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = fclose($fh);
return $AspisRetTemp;
}} }
function poify ( $string ) {
{$quote = '"';
$slash = '\\';
$newline = "\n";
$replaces = array("$slash" => "$slash$slash","$quote" => "$slash$quote","\t" => '\t',);
$string = str_replace(array_keys($replaces),array_values($replaces),$string);
$po = $quote . implode("${slash}n$quote$newline$quote",explode($newline,$string)) . $quote;
if ( false !== strpos($string,$newline) && (substr_count($string,$newline) > 1 || !($newline === substr($string,-strlen($newline)))))
 {$po = "$quote$quote$newline$po";
}$po = str_replace("$newline$quote$quote",'',$po);
{$AspisRetTemp = $po;
return $AspisRetTemp;
}} }
function unpoify ( $string ) {
{$escapes = array('t' => "\t",'n' => "\n",'\\' => '\\');
$lines = array_map('trim',explode("\n",$string));
$lines = array_map(array('PO','trim_quotes'),$lines);
$unpoified = '';
$previous_is_backslash = false;
foreach ( $lines as $line  )
{preg_match_all('/./u',$line,$chars);
$chars = $chars[0];
foreach ( $chars as $char  )
{if ( !$previous_is_backslash)
 {if ( '\\' == $char)
 $previous_is_backslash = true;
else 
{$unpoified .= $char;
}}else 
{{$previous_is_backslash = false;
$unpoified .= isset($escapes[$char]) ? $escapes[$char] : $char;
}}}}{$AspisRetTemp = $unpoified;
return $AspisRetTemp;
}} }
function prepend_each_line ( $string,$with ) {
{$php_with = var_export($with,true);
$lines = explode("\n",$string);
if ( "\n" == substr($string,-1))
 unset($lines[count($lines) - 1]);
$res = implode("\n",array_map(create_function('$x',"return $php_with.\$x;
"),$lines));
if ( "\n" == substr($string,-1))
 $res .= "\n";
{$AspisRetTemp = $res;
return $AspisRetTemp;
}} }
function comment_block ( $text,$char = ' ' ) {
{$text = wordwrap($text,PO_MAX_LINE_LEN - 3);
{$AspisRetTemp = PO::prepend_each_line($text,"#$char ");
return $AspisRetTemp;
}} }
function export_entry ( &$entry ) {
{if ( is_null($entry->singular))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$po = array();
if ( !empty($entry->translator_comments))
 $po[] = PO::comment_block($entry->translator_comments);
if ( !empty($entry->extracted_comments))
 $po[] = PO::comment_block($entry->extracted_comments,'.');
if ( !empty($entry->references))
 $po[] = PO::comment_block(implode(' ',$entry->references),':');
if ( !empty($entry->flags))
 $po[] = PO::comment_block(implode(", ",$entry->flags),',');
if ( !is_null($entry->context))
 $po[] = 'msgctxt ' . PO::poify($entry->context);
$po[] = 'msgid ' . PO::poify($entry->singular);
if ( !$entry->is_plural)
 {$translation = empty($entry->translations) ? '' : $entry->translations[0];
$po[] = 'msgstr ' . PO::poify($translation);
}else 
{{$po[] = 'msgid_plural ' . PO::poify($entry->plural);
$translations = empty($entry->translations) ? array('','') : $entry->translations;
foreach ( $translations as $i =>$translation )
{$po[] = "msgstr[$i] " . PO::poify($translation);
}}}{$AspisRetTemp = implode("\n",$po);
return $AspisRetTemp;
}} }
function import_from_file ( $filename ) {
{$f = fopen($filename,'r');
if ( !$f)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$lineno = 0;
while ( true )
{$res = $this->read_entry($f,$lineno);
if ( !$res)
 break ;
if ( $res['entry']->singular == '')
 {$this->set_headers($this->make_headers($res['entry']->translations[0]));
}else 
{{$this->add_entry($res['entry']);
}}}PO::read_line($f,'clear');
{$AspisRetTemp = $res !== false;
return $AspisRetTemp;
}} }
function read_entry ( $f,$lineno = 0 ) {
{$entry = new Translation_Entry();
$context = '';
$msgstr_index = 0;
$is_final = create_function('$context','return $context == "msgstr" || $context == "msgstr_plural";');
while ( true )
{$lineno++;
$line = PO::read_line($f);
if ( !$line)
 {if ( feof($f))
 {if ( AspisUntaintedDynamicCall($is_final,$context))
 break ;
elseif ( !$context)
 {$AspisRetTemp = null;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
return $AspisRetTemp;
}}}else 
{{{$AspisRetTemp = false;
return $AspisRetTemp;
}}}}if ( $line == "\n")
 continue ;
$line = trim($line);
if ( preg_match('/^#/',$line,$m))
 {if ( AspisUntaintedDynamicCall($is_final,$context))
 {PO::read_line($f,'put-back');
$lineno--;
break ;
}if ( $context && $context != 'comment')
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->add_comment_to_entry($entry,$line);
;
}elseif ( preg_match('/^msgctxt\s+(".*")/',$line,$m))
 {if ( AspisUntaintedDynamicCall($is_final,$context))
 {PO::read_line($f,'put-back');
$lineno--;
break ;
}if ( $context && $context != 'comment')
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$context = 'msgctxt';
$entry->context .= PO::unpoify($m[1]);
}elseif ( preg_match('/^msgid\s+(".*")/',$line,$m))
 {if ( AspisUntaintedDynamicCall($is_final,$context))
 {PO::read_line($f,'put-back');
$lineno--;
break ;
}if ( $context && $context != 'msgctxt' && $context != 'comment')
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$context = 'msgid';
$entry->singular .= PO::unpoify($m[1]);
}elseif ( preg_match('/^msgid_plural\s+(".*")/',$line,$m))
 {if ( $context != 'msgid')
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$context = 'msgid_plural';
$entry->is_plural = true;
$entry->plural .= PO::unpoify($m[1]);
}elseif ( preg_match('/^msgstr\s+(".*")/',$line,$m))
 {if ( $context != 'msgid')
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$context = 'msgstr';
$entry->translations = array(PO::unpoify($m[1]));
}elseif ( preg_match('/^msgstr\[(\d+)\]\s+(".*")/',$line,$m))
 {if ( $context != 'msgid_plural' && $context != 'msgstr_plural')
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$context = 'msgstr_plural';
$msgstr_index = $m[1];
$entry->translations[$m[1]] = PO::unpoify($m[2]);
}elseif ( preg_match('/^".*"$/',$line))
 {$unpoified = PO::unpoify($line);
switch ( $context ) {
case 'msgid':$entry->singular .= $unpoified;
break ;
case 'msgctxt':$entry->context .= $unpoified;
break ;
case 'msgid_plural':$entry->plural .= $unpoified;
break ;
case 'msgstr':$entry->translations[0] .= $unpoified;
break ;
case 'msgstr_plural':$entry->translations[$msgstr_index] .= $unpoified;
break ;
default :{$AspisRetTemp = false;
return $AspisRetTemp;
} }
}else 
{{{$AspisRetTemp = false;
return $AspisRetTemp;
}}}}if ( array() == array_filter($entry->translations,create_function('$t','return $t || "0" === $t;')))
 {$entry->translations = array();
}{$AspisRetTemp = array('entry' => $entry,'lineno' => $lineno);
return $AspisRetTemp;
}} }
function read_line ( $f,$action = 'read' ) {
{static $last_line = '';
static $use_last_line = false;
if ( 'clear' == $action)
 {$last_line = '';
{$AspisRetTemp = true;
return $AspisRetTemp;
}}if ( 'put-back' == $action)
 {$use_last_line = true;
{$AspisRetTemp = true;
return $AspisRetTemp;
}}$line = $use_last_line ? $last_line : fgets($f);
$last_line = $line;
$use_last_line = false;
{$AspisRetTemp = $line;
return $AspisRetTemp;
}} }
function add_comment_to_entry ( &$entry,$po_comment_line ) {
{$first_two = substr($po_comment_line,0,2);
$comment = trim(substr($po_comment_line,2));
if ( '#:' == $first_two)
 {$entry->references = array_merge($entry->references,preg_split('/\s+/',$comment));
}elseif ( '#.' == $first_two)
 {$entry->extracted_comments = trim($entry->extracted_comments . "\n" . $comment);
}elseif ( '#,' == $first_two)
 {$entry->flags = array_merge($entry->flags,preg_split('/,\s*/',$comment));
}else 
{{$entry->translator_comments = trim($entry->translator_comments . "\n" . $comment);
}}} }
function trim_quotes ( $s ) {
{if ( substr($s,0,1) == '"')
 $s = substr($s,1);
if ( substr($s,-1,1) == '"')
 $s = substr($s,0,-1);
{$AspisRetTemp = $s;
return $AspisRetTemp;
}} }
}}