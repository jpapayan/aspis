<?php require_once('AspisMain.php'); ?><?php
require_once (deconcat2(Aspis_dirname(array(__FILE__,false)),'/translations.php'));
require_once (deconcat2(Aspis_dirname(array(__FILE__,false)),'/streams.php'));
if ( (!(class_exists(('MO')))))
 {class MO extends Gettext_Translations{var $_nplurals = array(2,false);
function import_from_file ( $filename ) {
{$reader = array(new POMO_FileReader($filename),false);
if ( (denot_boolean($reader[0]->is_resource())))
 return array(false,false);
return $this->import_from_reader($reader);
} }
function export_to_file ( $filename ) {
{$fh = attAspis(fopen($filename[0],('wb')));
if ( (denot_boolean($fh)))
 return array(false,false);
$entries = attAspisRC(array_filter(deAspisRC($this->entries),AspisInternalCallback(Aspis_create_function(array('$e',false),array('return !empty($e->translations);',false)))));
Aspis_ksort($entries);
$magic = array(0x950412de,false);
$revision = array(0,false);
$total = array(count($entries[0]) + (1),false);
$originals_lenghts_addr = array(28,false);
$translations_lenghts_addr = array($originals_lenghts_addr[0] + ((8) * $total[0]),false);
$size_of_hash = array(0,false);
$hash_addr = array($translations_lenghts_addr[0] + ((8) * $total[0]),false);
$current_addr = $hash_addr;
fwrite($fh[0],pack(('V*'),deAspisRC($magic),deAspisRC($revision),deAspisRC($total),deAspisRC($originals_lenghts_addr),deAspisRC($translations_lenghts_addr),deAspisRC($size_of_hash),deAspisRC($hash_addr)));
fseek($fh[0],$originals_lenghts_addr[0]);
fwrite($fh[0],pack(('VV'),0,deAspisRC($current_addr)));
postincr($current_addr);
$originals_table = attAspis(chr((0)));
foreach ( $entries[0] as $entry  )
{$originals_table = concat($originals_table,concat($this->export_original($entry),attAspis(chr((0)))));
$length = attAspis(strlen(deAspis($this->export_original($entry))));
fwrite($fh[0],pack(('VV'),deAspisRC($length),deAspisRC($current_addr)));
$current_addr = array(($length[0] + (1)) + $current_addr[0],false);
}$exported_headers = $this->export_headers();
fwrite($fh[0],pack(('VV'),deAspisRC(attAspis(strlen($exported_headers[0]))),deAspisRC($current_addr)));
$current_addr = array((strlen($exported_headers[0]) + (1)) + $current_addr[0],false);
$translations_table = concat($exported_headers,attAspis(chr((0))));
foreach ( $entries[0] as $entry  )
{$translations_table = concat($translations_table,concat($this->export_translations($entry),attAspis(chr((0)))));
$length = attAspis(strlen(deAspis($this->export_translations($entry))));
fwrite($fh[0],pack(('VV'),deAspisRC($length),deAspisRC($current_addr)));
$current_addr = array(($length[0] + (1)) + $current_addr[0],false);
}fwrite($fh[0],$originals_table[0]);
fwrite($fh[0],$translations_table[0]);
fclose($fh[0]);
} }
function export_original ( $entry ) {
{$exported = $entry[0]->singular;
if ( $entry[0]->is_plural[0])
 $exported = concat($exported,concat(attAspis(chr((0))),$entry[0]->plural));
if ( (!(is_null(deAspisRC($entry[0]->context)))))
 $exported = concat(concat($entry[0]->context,attAspis(chr((4)))),$exported);
return $exported;
} }
function export_translations ( $entry ) {
{return Aspis_implode(attAspis(chr((0))),$entry[0]->translations);
} }
function export_headers (  ) {
{$exported = array('',false);
foreach ( $this->headers[0] as $header =>$value )
{restoreTaint($header,$value);
{$exported = concat($exported,concat2(concat(concat2($header,": "),$value),"\n"));
}}return $exported;
} }
function get_byteorder ( $magic ) {
{$magic_little = int_cast(negate(array(1794895138,false)));
$magic_little_64 = int_cast(array(2500072158,false));
$magic_big = array(deAspis((int_cast(negate(array(569244523,false))))) & (0xFFFFFFFF),false);
if ( (($magic_little[0] == $magic[0]) || ($magic_little_64[0] == $magic[0])))
 {return array('little',false);
}else 
{if ( ($magic_big[0] == $magic[0]))
 {return array('big',false);
}else 
{{return array(false,false);
}}}} }
function import_from_reader ( $reader ) {
{$endian_string = MO::get_byteorder($reader[0]->readint32());
if ( (false === $endian_string[0]))
 {return array(false,false);
}$reader[0]->setEndian($endian_string);
$endian = (('big') == $endian_string[0]) ? array('N',false) : array('V',false);
$header = $reader[0]->read(array(24,false));
if ( (deAspis($reader[0]->strlen($header)) != (24)))
 return array(false,false);
$header = attAspisRC(unpack((deconcat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2($endian,"revision/"),$endian),"total/"),$endian),"originals_lenghts_addr/"),$endian),"translations_lenghts_addr/"),$endian),"hash_length/"),$endian),"hash_addr")),$header[0]));
if ( (!(is_array($header[0]))))
 return array(false,false);
extract(($header[0]));
if ( ($revision[0] != (0)))
 return array(false,false);
$reader[0]->seekto($originals_lenghts_addr);
$originals_lengths_length = array($translations_lenghts_addr[0] - $originals_lenghts_addr[0],false);
if ( ($originals_lengths_length[0] != ($total[0] * (8))))
 return array(false,false);
$originals = $reader[0]->read($originals_lengths_length);
if ( (deAspis($reader[0]->strlen($originals)) != $originals_lengths_length[0]))
 return array(false,false);
$translations_lenghts_length = array($hash_addr[0] - $translations_lenghts_addr[0],false);
if ( ($translations_lenghts_length[0] != ($total[0] * (8))))
 return array(false,false);
$translations = $reader[0]->read($translations_lenghts_length);
if ( (deAspis($reader[0]->strlen($translations)) != $translations_lenghts_length[0]))
 return array(false,false);
$originals = $reader[0]->str_split($originals,array(8,false));
$translations = $reader[0]->str_split($translations,array(8,false));
$strings_addr = array($hash_addr[0] + ($hash_length[0] * (4)),false);
$reader[0]->seekto($strings_addr);
$strings = $reader[0]->read_all();
$reader[0]->close();
for ( $i = array(0,false) ; ($i[0] < $total[0]) ; postincr($i) )
{$o = attAspisRC(unpack((deconcat2(concat(concat2($endian,"length/"),$endian),"pos")),deAspis(attachAspis($originals,$i[0]))));
$t = attAspisRC(unpack((deconcat2(concat(concat2($endian,"length/"),$endian),"pos")),deAspis(attachAspis($translations,$i[0]))));
if ( ((denot_boolean($o)) || (denot_boolean($t))))
 return array(false,false);
arrayAssign($o[0],deAspis(registerTaint(array('pos',false))),addTaint(array(deAspis($o[0]['pos']) - $strings_addr[0],false)));
arrayAssign($t[0],deAspis(registerTaint(array('pos',false))),addTaint(array(deAspis($t[0]['pos']) - $strings_addr[0],false)));
$original = $reader[0]->substr($strings,$o[0]['pos'],$o[0]['length']);
$translation = $reader[0]->substr($strings,$t[0]['pos'],$t[0]['length']);
if ( (('') === $original[0]))
 {$this->set_headers($this->make_headers($translation));
}else 
{{$entry = &$this->make_entry($original,$translation);
$this->entries[0][deAspis(registerTaint($entry[0]->key()))] = &addTaintR($entry);
}}}return array(true,false);
} }
function &make_entry ( $original,$translation ) {
{$entry = array(new Translation_Entry(),false);
$parts = Aspis_explode(attAspis(chr((4))),$original);
if ( ((isset($parts[0][(1)]) && Aspis_isset( $parts [0][(1)]))))
 {$original = attachAspis($parts,(1));
$entry[0]->context = attachAspis($parts,(0));
}$parts = Aspis_explode(attAspis(chr((0))),$original);
$entry[0]->singular = attachAspis($parts,(0));
if ( ((isset($parts[0][(1)]) && Aspis_isset( $parts [0][(1)]))))
 {$entry[0]->is_plural = array(true,false);
$entry[0]->plural = attachAspis($parts,(1));
}$entry[0]->translations = Aspis_explode(attAspis(chr((0))),$translation);
return $entry;
} }
function select_plural_form ( $count ) {
{return $this->gettext_select_plural_form($count);
} }
function get_plural_forms_count (  ) {
{return $this->_nplurals;
} }
}}