<?php require_once('AspisMain.php'); ?><?php
function wptexturize ( $text ) {
{global $wp_cockneyreplace;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_cockneyreplace,"\$wp_cockneyreplace",$AspisChangesCache);
}static $static_setup = false,$opening_quote,$closing_quote,$default_no_texturize_tags,$default_no_texturize_shortcodes,$static_characters,$static_replacements,$dynamic_characters,$dynamic_replacements;
$output = '';
$curl = '';
$textarr = preg_split('/(<.*>|\[.*\])/Us',$text,-1,PREG_SPLIT_DELIM_CAPTURE);
$stop = count($textarr);
if ( !$static_setup)
 {$opening_quote = _x('&#8220;','opening curly quote');
$closing_quote = _x('&#8221;','closing curly quote');
$default_no_texturize_tags = array('pre','code','kbd','style','script','tt');
$default_no_texturize_shortcodes = array('code');
if ( isset($wp_cockneyreplace))
 {$cockney = array_keys($wp_cockneyreplace);
$cockneyreplace = array_values($wp_cockneyreplace);
}else 
{{$cockney = array("'tain't","'twere","'twas","'tis","'twill","'til","'bout","'nuff","'round","'cause");
$cockneyreplace = array("&#8217;tain&#8217;t","&#8217;twere","&#8217;twas","&#8217;tis","&#8217;twill","&#8217;til","&#8217;bout","&#8217;nuff","&#8217;round","&#8217;cause");
}}$static_characters = array_merge(array('---',' -- ','--',' - ','xn&#8211;','...','``','\'s','\'\'',' (tm)'),$cockney);
$static_replacements = array_merge(array('&#8212;',' &#8212; ','&#8211;',' &#8211; ','xn--','&#8230;',$opening_quote,'&#8217;s',$closing_quote,' &#8482;'),$cockneyreplace);
$dynamic_characters = array('/\'(\d\d(?:&#8217;|\')?s)/','/(\s|\A|[([{<]|")\'/','/(\d+)"/','/(\d+)\'/','/(\S)\'([^\'\s])/','/(\s|\A|[([{<])"(?!\s)/','/"(\s|\S|\Z)/','/\'([\s.]|\Z)/','/(\d+)x(\d+)/');
$dynamic_replacements = array('&#8217;$1','$1&#8216;','$1&#8243;','$1&#8242;','$1&#8217;$2','$1' . $opening_quote . '$2',$closing_quote . '$1','&#8217;$1','$1&#215;$2');
$static_setup = true;
}$no_texturize_tags = '(' . implode('|',apply_filters('no_texturize_tags',$default_no_texturize_tags)) . ')';
$no_texturize_shortcodes = '(' . implode('|',apply_filters('no_texturize_shortcodes',$default_no_texturize_shortcodes)) . ')';
$no_texturize_tags_stack = array();
$no_texturize_shortcodes_stack = array();
for ( $i = 0 ; $i < $stop ; $i++ )
{$curl = $textarr[$i];
if ( !empty($curl) && '<' != $curl[0] && '[' != $curl[0] && empty($no_texturize_shortcodes_stack) && empty($no_texturize_tags_stack))
 {$curl = str_replace($static_characters,$static_replacements,$curl);
$curl = preg_replace($dynamic_characters,$dynamic_replacements,$curl);
}elseif ( !empty($curl))
 {if ( '<' == $curl[0])
 _wptexturize_pushpop_element($curl,$no_texturize_tags_stack,$no_texturize_tags,'<','>');
elseif ( '[' == $curl[0])
 _wptexturize_pushpop_element($curl,$no_texturize_shortcodes_stack,$no_texturize_shortcodes,'[',']');
}$curl = preg_replace('/&([^#])(?![a-zA-Z1-4]{1,8};)/','&#038;$1',$curl);
$output .= $curl;
}{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_cockneyreplace",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_cockneyreplace",$AspisChangesCache);
 }
function _wptexturize_pushpop_element ( $text,&$stack,$disabled_elements,$opening = '<',$closing = '>' ) {
if ( strncmp($opening . '/',$text,2))
 {if ( preg_match('/^' . $disabled_elements . '\b/',substr($text,1),$matches))
 {array_push($stack,$matches[1]);
}}else 
{{$c = preg_quote($closing,'/');
if ( preg_match('/^' . $disabled_elements . $c . '/',substr($text,2),$matches))
 {$last = array_pop($stack);
if ( $last != $matches[1])
 array_push($stack,$last);
}}} }
function clean_pre ( $matches ) {
if ( is_array($matches))
 $text = $matches[1] . $matches[2] . "</pre>";
else 
{$text = $matches;
}$text = str_replace('<br />','',$text);
$text = str_replace('<p>',"\n",$text);
$text = str_replace('</p>','',$text);
{$AspisRetTemp = $text;
return $AspisRetTemp;
} }
function wpautop ( $pee,$br = 1 ) {
if ( trim($pee) === '')
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$pee = $pee . "\n";
$pee = preg_replace('|<br />\s*<br />|',"\n\n",$pee);
$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|fieldset|legend)';
$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!',"\n$1",$pee);
$pee = preg_replace('!(</' . $allblocks . '>)!',"$1\n\n",$pee);
$pee = str_replace(array("\r\n","\r"),"\n",$pee);
if ( strpos($pee,'<object') !== false)
 {$pee = preg_replace('|\s*<param([^>]*)>\s*|',"<param$1>",$pee);
$pee = preg_replace('|\s*</embed>\s*|','</embed>',$pee);
}$pee = preg_replace("/\n\n+/","\n\n",$pee);
$pees = preg_split('/\n\s*\n/',$pee,-1,PREG_SPLIT_NO_EMPTY);
$pee = '';
foreach ( $pees as $tinkle  )
$pee .= '<p>' . trim($tinkle,"\n") . "</p>\n";
$pee = preg_replace('|<p>\s*</p>|','',$pee);
$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!',"<p>$1</p></$2>",$pee);
$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!',"$1",$pee);
$pee = preg_replace("|<p>(<li.+?)</p>|","$1",$pee);
$pee = preg_replace('|<p><blockquote([^>]*)>|i',"<blockquote$1><p>",$pee);
$pee = str_replace('</blockquote></p>','</p></blockquote>',$pee);
$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!',"$1",$pee);
$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!',"$1",$pee);
if ( $br)
 {$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s',create_function('$matches','return str_replace("\n", "<WPPreserveNewline />", $matches[0]);'),$pee);
$pee = preg_replace('|(?<!<br />)\s*\n|',"<br />\n",$pee);
$pee = str_replace('<WPPreserveNewline />',"\n",$pee);
}$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!',"$1",$pee);
$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!','$1',$pee);
if ( strpos($pee,'<pre') !== false)
 $pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is','clean_pre',$pee);
$pee = preg_replace("|\n</p>$|",'</p>',$pee);
{$AspisRetTemp = $pee;
return $AspisRetTemp;
} }
function shortcode_unautop ( $pee ) {
{global $shortcode_tags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $shortcode_tags,"\$shortcode_tags",$AspisChangesCache);
}if ( !empty($shortcode_tags) && is_array($shortcode_tags))
 {$tagnames = array_keys($shortcode_tags);
$tagregexp = join('|',array_map('preg_quote',$tagnames));
$pee = preg_replace('/<p>\\s*?(\\[(' . $tagregexp . ')\\b.*?\\/?\\](?:.+?\\[\\/\\2\\])?)\\s*<\\/p>/s','$1',$pee);
}{$AspisRetTemp = $pee;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
 }
function seems_utf8 ( $str ) {
$length = strlen($str);
for ( $i = 0 ; $i < $length ; $i++ )
{$c = ord($str[$i]);
if ( $c < 0x80)
 $n = 0;
elseif ( ($c & 0xE0) == 0xC0)
 $n = 1;
elseif ( ($c & 0xF0) == 0xE0)
 $n = 2;
elseif ( ($c & 0xF8) == 0xF0)
 $n = 3;
elseif ( ($c & 0xFC) == 0xF8)
 $n = 4;
elseif ( ($c & 0xFE) == 0xFC)
 $n = 5;
else 
{{$AspisRetTemp = false;
return $AspisRetTemp;
}}for ( $j = 0 ; $j < $n ; $j++ )
{if ( (++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}}}{$AspisRetTemp = true;
return $AspisRetTemp;
} }
function _wp_specialchars ( $string,$quote_style = ENT_NOQUOTES,$charset = false,$double_encode = false ) {
$string = (string)$string;
if ( 0 === strlen($string))
 {{$AspisRetTemp = '';
return $AspisRetTemp;
}}if ( !preg_match('/[&<>"\']/',$string))
 {{$AspisRetTemp = $string;
return $AspisRetTemp;
}}if ( empty($quote_style))
 {$quote_style = ENT_NOQUOTES;
}elseif ( !in_array($quote_style,array(0,2,3,'single','double'),true))
 {$quote_style = ENT_QUOTES;
}if ( !$charset)
 {static $_charset;
if ( !isset($_charset))
 {$alloptions = wp_load_alloptions();
$_charset = isset($alloptions['blog_charset']) ? $alloptions['blog_charset'] : '';
}$charset = $_charset;
}if ( in_array($charset,array('utf8','utf-8','UTF8')))
 {$charset = 'UTF-8';
}$_quote_style = $quote_style;
if ( $quote_style === 'double')
 {$quote_style = ENT_COMPAT;
$_quote_style = ENT_COMPAT;
}elseif ( $quote_style === 'single')
 {$quote_style = ENT_NOQUOTES;
}if ( !$double_encode)
 {$string = wp_specialchars_decode($string,$_quote_style);
$string = preg_replace('/&(#?x?[0-9a-z]+);/i','|wp_entity|$1|/wp_entity|',$string);
}$string = @htmlspecialchars($string,$quote_style,$charset);
if ( !$double_encode)
 {$string = str_replace(array('|wp_entity|','|/wp_entity|'),array('&',';'),$string);
}if ( 'single' === $_quote_style)
 {$string = str_replace("'",'&#039;',$string);
}{$AspisRetTemp = $string;
return $AspisRetTemp;
} }
function wp_specialchars_decode ( $string,$quote_style = ENT_NOQUOTES ) {
$string = (string)$string;
if ( 0 === strlen($string))
 {{$AspisRetTemp = '';
return $AspisRetTemp;
}}if ( strpos($string,'&') === false)
 {{$AspisRetTemp = $string;
return $AspisRetTemp;
}}if ( empty($quote_style))
 {$quote_style = ENT_NOQUOTES;
}elseif ( !in_array($quote_style,array(0,2,3,'single','double'),true))
 {$quote_style = ENT_QUOTES;
}$single = array('&#039;' => '\'','&#x27;' => '\'');
$single_preg = array('/&#0*39;/' => '&#039;','/&#x0*27;/i' => '&#x27;');
$double = array('&quot;' => '"','&#034;' => '"','&#x22;' => '"');
$double_preg = array('/&#0*34;/' => '&#034;','/&#x0*22;/i' => '&#x22;');
$others = array('&lt;' => '<','&#060;' => '<','&gt;' => '>','&#062;' => '>','&amp;' => '&','&#038;' => '&','&#x26;' => '&');
$others_preg = array('/&#0*60;/' => '&#060;','/&#0*62;/' => '&#062;','/&#0*38;/' => '&#038;','/&#x0*26;/i' => '&#x26;');
if ( $quote_style === ENT_QUOTES)
 {$translation = array_merge($single,$double,$others);
$translation_preg = array_merge($single_preg,$double_preg,$others_preg);
}elseif ( $quote_style === ENT_COMPAT || $quote_style === 'double')
 {$translation = array_merge($double,$others);
$translation_preg = array_merge($double_preg,$others_preg);
}elseif ( $quote_style === 'single')
 {$translation = array_merge($single,$others);
$translation_preg = array_merge($single_preg,$others_preg);
}elseif ( $quote_style === ENT_NOQUOTES)
 {$translation = $others;
$translation_preg = $others_preg;
}$string = preg_replace(array_keys($translation_preg),array_values($translation_preg),$string);
{$AspisRetTemp = strtr($string,$translation);
return $AspisRetTemp;
} }
function wp_check_invalid_utf8 ( $string,$strip = false ) {
$string = (string)$string;
if ( 0 === strlen($string))
 {{$AspisRetTemp = '';
return $AspisRetTemp;
}}static $is_utf8;
if ( !isset($is_utf8))
 {$is_utf8 = in_array(get_option('blog_charset'),array('utf8','utf-8','UTF8','UTF-8'));
}if ( !$is_utf8)
 {{$AspisRetTemp = $string;
return $AspisRetTemp;
}}static $utf8_pcre;
if ( !isset($utf8_pcre))
 {$utf8_pcre = @preg_match('/^./u','a');
}if ( !$utf8_pcre)
 {{$AspisRetTemp = $string;
return $AspisRetTemp;
}}if ( 1 === @preg_match('/^./us',$string))
 {{$AspisRetTemp = $string;
return $AspisRetTemp;
}}if ( $strip && function_exists('iconv'))
 {{$AspisRetTemp = iconv('utf-8','utf-8',$string);
return $AspisRetTemp;
}}{$AspisRetTemp = '';
return $AspisRetTemp;
} }
function utf8_uri_encode ( $utf8_string,$length = 0 ) {
$unicode = '';
$values = array();
$num_octets = 1;
$unicode_length = 0;
$string_length = strlen($utf8_string);
for ( $i = 0 ; $i < $string_length ; $i++ )
{$value = ord($utf8_string[$i]);
if ( $value < 128)
 {if ( $length && ($unicode_length >= $length))
 break ;
$unicode .= chr($value);
$unicode_length++;
}else 
{{if ( count($values) == 0)
 $num_octets = ($value < 224) ? 2 : 3;
$values[] = $value;
if ( $length && ($unicode_length + ($num_octets * 3)) > $length)
 break ;
if ( count($values) == $num_octets)
 {if ( $num_octets == 3)
 {$unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
$unicode_length += 9;
}else 
{{$unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
$unicode_length += 6;
}}$values = array();
$num_octets = 1;
}}}}{$AspisRetTemp = $unicode;
return $AspisRetTemp;
} }
function remove_accents ( $string ) {
if ( !preg_match('/[\x80-\xff]/',$string))
 {$AspisRetTemp = $string;
return $AspisRetTemp;
}if ( seems_utf8($string))
 {$chars = array(chr(195) . chr(128) => 'A',chr(195) . chr(129) => 'A',chr(195) . chr(130) => 'A',chr(195) . chr(131) => 'A',chr(195) . chr(132) => 'A',chr(195) . chr(133) => 'A',chr(195) . chr(135) => 'C',chr(195) . chr(136) => 'E',chr(195) . chr(137) => 'E',chr(195) . chr(138) => 'E',chr(195) . chr(139) => 'E',chr(195) . chr(140) => 'I',chr(195) . chr(141) => 'I',chr(195) . chr(142) => 'I',chr(195) . chr(143) => 'I',chr(195) . chr(145) => 'N',chr(195) . chr(146) => 'O',chr(195) . chr(147) => 'O',chr(195) . chr(148) => 'O',chr(195) . chr(149) => 'O',chr(195) . chr(150) => 'O',chr(195) . chr(153) => 'U',chr(195) . chr(154) => 'U',chr(195) . chr(155) => 'U',chr(195) . chr(156) => 'U',chr(195) . chr(157) => 'Y',chr(195) . chr(159) => 's',chr(195) . chr(160) => 'a',chr(195) . chr(161) => 'a',chr(195) . chr(162) => 'a',chr(195) . chr(163) => 'a',chr(195) . chr(164) => 'a',chr(195) . chr(165) => 'a',chr(195) . chr(167) => 'c',chr(195) . chr(168) => 'e',chr(195) . chr(169) => 'e',chr(195) . chr(170) => 'e',chr(195) . chr(171) => 'e',chr(195) . chr(172) => 'i',chr(195) . chr(173) => 'i',chr(195) . chr(174) => 'i',chr(195) . chr(175) => 'i',chr(195) . chr(177) => 'n',chr(195) . chr(178) => 'o',chr(195) . chr(179) => 'o',chr(195) . chr(180) => 'o',chr(195) . chr(181) => 'o',chr(195) . chr(182) => 'o',chr(195) . chr(182) => 'o',chr(195) . chr(185) => 'u',chr(195) . chr(186) => 'u',chr(195) . chr(187) => 'u',chr(195) . chr(188) => 'u',chr(195) . chr(189) => 'y',chr(195) . chr(191) => 'y',chr(196) . chr(128) => 'A',chr(196) . chr(129) => 'a',chr(196) . chr(130) => 'A',chr(196) . chr(131) => 'a',chr(196) . chr(132) => 'A',chr(196) . chr(133) => 'a',chr(196) . chr(134) => 'C',chr(196) . chr(135) => 'c',chr(196) . chr(136) => 'C',chr(196) . chr(137) => 'c',chr(196) . chr(138) => 'C',chr(196) . chr(139) => 'c',chr(196) . chr(140) => 'C',chr(196) . chr(141) => 'c',chr(196) . chr(142) => 'D',chr(196) . chr(143) => 'd',chr(196) . chr(144) => 'D',chr(196) . chr(145) => 'd',chr(196) . chr(146) => 'E',chr(196) . chr(147) => 'e',chr(196) . chr(148) => 'E',chr(196) . chr(149) => 'e',chr(196) . chr(150) => 'E',chr(196) . chr(151) => 'e',chr(196) . chr(152) => 'E',chr(196) . chr(153) => 'e',chr(196) . chr(154) => 'E',chr(196) . chr(155) => 'e',chr(196) . chr(156) => 'G',chr(196) . chr(157) => 'g',chr(196) . chr(158) => 'G',chr(196) . chr(159) => 'g',chr(196) . chr(160) => 'G',chr(196) . chr(161) => 'g',chr(196) . chr(162) => 'G',chr(196) . chr(163) => 'g',chr(196) . chr(164) => 'H',chr(196) . chr(165) => 'h',chr(196) . chr(166) => 'H',chr(196) . chr(167) => 'h',chr(196) . chr(168) => 'I',chr(196) . chr(169) => 'i',chr(196) . chr(170) => 'I',chr(196) . chr(171) => 'i',chr(196) . chr(172) => 'I',chr(196) . chr(173) => 'i',chr(196) . chr(174) => 'I',chr(196) . chr(175) => 'i',chr(196) . chr(176) => 'I',chr(196) . chr(177) => 'i',chr(196) . chr(178) => 'IJ',chr(196) . chr(179) => 'ij',chr(196) . chr(180) => 'J',chr(196) . chr(181) => 'j',chr(196) . chr(182) => 'K',chr(196) . chr(183) => 'k',chr(196) . chr(184) => 'k',chr(196) . chr(185) => 'L',chr(196) . chr(186) => 'l',chr(196) . chr(187) => 'L',chr(196) . chr(188) => 'l',chr(196) . chr(189) => 'L',chr(196) . chr(190) => 'l',chr(196) . chr(191) => 'L',chr(197) . chr(128) => 'l',chr(197) . chr(129) => 'L',chr(197) . chr(130) => 'l',chr(197) . chr(131) => 'N',chr(197) . chr(132) => 'n',chr(197) . chr(133) => 'N',chr(197) . chr(134) => 'n',chr(197) . chr(135) => 'N',chr(197) . chr(136) => 'n',chr(197) . chr(137) => 'N',chr(197) . chr(138) => 'n',chr(197) . chr(139) => 'N',chr(197) . chr(140) => 'O',chr(197) . chr(141) => 'o',chr(197) . chr(142) => 'O',chr(197) . chr(143) => 'o',chr(197) . chr(144) => 'O',chr(197) . chr(145) => 'o',chr(197) . chr(146) => 'OE',chr(197) . chr(147) => 'oe',chr(197) . chr(148) => 'R',chr(197) . chr(149) => 'r',chr(197) . chr(150) => 'R',chr(197) . chr(151) => 'r',chr(197) . chr(152) => 'R',chr(197) . chr(153) => 'r',chr(197) . chr(154) => 'S',chr(197) . chr(155) => 's',chr(197) . chr(156) => 'S',chr(197) . chr(157) => 's',chr(197) . chr(158) => 'S',chr(197) . chr(159) => 's',chr(197) . chr(160) => 'S',chr(197) . chr(161) => 's',chr(197) . chr(162) => 'T',chr(197) . chr(163) => 't',chr(197) . chr(164) => 'T',chr(197) . chr(165) => 't',chr(197) . chr(166) => 'T',chr(197) . chr(167) => 't',chr(197) . chr(168) => 'U',chr(197) . chr(169) => 'u',chr(197) . chr(170) => 'U',chr(197) . chr(171) => 'u',chr(197) . chr(172) => 'U',chr(197) . chr(173) => 'u',chr(197) . chr(174) => 'U',chr(197) . chr(175) => 'u',chr(197) . chr(176) => 'U',chr(197) . chr(177) => 'u',chr(197) . chr(178) => 'U',chr(197) . chr(179) => 'u',chr(197) . chr(180) => 'W',chr(197) . chr(181) => 'w',chr(197) . chr(182) => 'Y',chr(197) . chr(183) => 'y',chr(197) . chr(184) => 'Y',chr(197) . chr(185) => 'Z',chr(197) . chr(186) => 'z',chr(197) . chr(187) => 'Z',chr(197) . chr(188) => 'z',chr(197) . chr(189) => 'Z',chr(197) . chr(190) => 'z',chr(197) . chr(191) => 's',chr(226) . chr(130) . chr(172) => 'E',chr(194) . chr(163) => '');
$string = strtr($string,$chars);
}else 
{{$chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158) . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194) . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202) . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210) . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218) . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227) . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235) . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243) . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251) . chr(252) . chr(253) . chr(255);
$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
$string = strtr($string,$chars['in'],$chars['out']);
$double_chars['in'] = array(chr(140),chr(156),chr(198),chr(208),chr(222),chr(223),chr(230),chr(240),chr(254));
$double_chars['out'] = array('OE','oe','AE','DH','TH','ss','ae','dh','th');
$string = str_replace($double_chars['in'],$double_chars['out'],$string);
}}{$AspisRetTemp = $string;
return $AspisRetTemp;
} }
function sanitize_file_name ( $filename ) {
$filename_raw = $filename;
$special_chars = array("?","[","]","/","\\","=","<",">",":",";",",","'","\"","&","$","#","*","(",")","|","~","`","!","{","}",chr(0));
$special_chars = apply_filters('sanitize_file_name_chars',$special_chars,$filename_raw);
$filename = str_replace($special_chars,'',$filename);
$filename = preg_replace('/[\s-]+/','-',$filename);
$filename = trim($filename,'.-_');
$parts = explode('.',$filename);
if ( count($parts) <= 2)
 {$AspisRetTemp = apply_filters('sanitize_file_name',$filename,$filename_raw);
return $AspisRetTemp;
}$filename = array_shift($parts);
$extension = array_pop($parts);
$mimes = get_allowed_mime_types();
foreach ( (array)$parts as $part  )
{$filename .= '.' . $part;
if ( preg_match("/^[a-zA-Z]{2,5}\d?$/",$part))
 {$allowed = false;
foreach ( $mimes as $ext_preg =>$mime_match )
{$ext_preg = '!(^' . $ext_preg . ')$!i';
if ( preg_match($ext_preg,$part))
 {$allowed = true;
break ;
}}if ( !$allowed)
 $filename .= '_';
}}$filename .= '.' . $extension;
{$AspisRetTemp = apply_filters('sanitize_file_name',$filename,$filename_raw);
return $AspisRetTemp;
} }
function sanitize_user ( $username,$strict = false ) {
$raw_username = $username;
$username = wp_strip_all_tags($username);
$username = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|','',$username);
$username = preg_replace('/&.+?;/','',$username);
if ( $strict)
 $username = preg_replace('|[^a-z0-9 _.\-@]|i','',$username);
$username = preg_replace('|\s+|',' ',$username);
{$AspisRetTemp = apply_filters('sanitize_user',$username,$raw_username,$strict);
return $AspisRetTemp;
} }
function sanitize_title ( $title,$fallback_title = '' ) {
$raw_title = $title;
$title = strip_tags($title);
$title = apply_filters('sanitize_title',$title,$raw_title);
if ( '' === $title || false === $title)
 $title = $fallback_title;
{$AspisRetTemp = $title;
return $AspisRetTemp;
} }
function sanitize_title_with_dashes ( $title ) {
$title = strip_tags($title);
$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|','---$1---',$title);
$title = str_replace('%','',$title);
$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|','%$1',$title);
$title = remove_accents($title);
if ( seems_utf8($title))
 {if ( function_exists('mb_strtolower'))
 {$title = mb_strtolower($title,'UTF-8');
}$title = utf8_uri_encode($title,200);
}$title = strtolower($title);
$title = preg_replace('/&.+?;/','',$title);
$title = str_replace('.','-',$title);
$title = preg_replace('/[^%a-z0-9 _-]/','',$title);
$title = preg_replace('/\s+/','-',$title);
$title = preg_replace('|-+|','-',$title);
$title = trim($title,'-');
{$AspisRetTemp = $title;
return $AspisRetTemp;
} }
function sanitize_sql_orderby ( $orderby ) {
preg_match('/^\s*([a-z0-9_]+(\s+(ASC|DESC))?(\s*,\s*|\s*$))+|^\s*RAND\(\s*\)\s*$/i',$orderby,$obmatches);
if ( !$obmatches)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $orderby;
return $AspisRetTemp;
} }
function sanitize_html_class ( $class,$fallback ) {
$sanitized = preg_replace('|%[a-fA-F0-9][a-fA-F0-9]|','',$class);
$sanitized = preg_replace('/[^A-Za-z0-9-]/','',$sanitized);
if ( '' == $sanitized)
 $sanitized = $fallback;
{$AspisRetTemp = apply_filters('sanitize_html_class',$sanitized,$class,$fallback);
return $AspisRetTemp;
} }
function convert_chars ( $content,$deprecated = '' ) {
$wp_htmltranswinuni = array('&#128;' => '&#8364;','&#129;' => '','&#130;' => '&#8218;','&#131;' => '&#402;','&#132;' => '&#8222;','&#133;' => '&#8230;','&#134;' => '&#8224;','&#135;' => '&#8225;','&#136;' => '&#710;','&#137;' => '&#8240;','&#138;' => '&#352;','&#139;' => '&#8249;','&#140;' => '&#338;','&#141;' => '','&#142;' => '&#382;','&#143;' => '','&#144;' => '','&#145;' => '&#8216;','&#146;' => '&#8217;','&#147;' => '&#8220;','&#148;' => '&#8221;','&#149;' => '&#8226;','&#150;' => '&#8211;','&#151;' => '&#8212;','&#152;' => '&#732;','&#153;' => '&#8482;','&#154;' => '&#353;','&#155;' => '&#8250;','&#156;' => '&#339;','&#157;' => '','&#158;' => '','&#159;' => '&#376;');
$content = preg_replace('/<title>(.+?)<\/title>/','',$content);
$content = preg_replace('/<category>(.+?)<\/category>/','',$content);
$content = preg_replace('/&([^#])(?![a-z1-4]{1,8};)/i','&#038;$1',$content);
$content = strtr($content,$wp_htmltranswinuni);
$content = str_replace('<br>','<br />',$content);
$content = str_replace('<hr>','<hr />',$content);
{$AspisRetTemp = $content;
return $AspisRetTemp;
} }
function funky_javascript_callback ( $matches ) {
{$AspisRetTemp = "&#" . base_convert($matches[1],16,10) . ";";
return $AspisRetTemp;
} }
function funky_javascript_fix ( $text ) {
{global $is_macIE,$is_winIE;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $is_macIE,"\$is_macIE",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($is_winIE,"\$is_winIE",$AspisChangesCache);
}if ( $is_winIE || $is_macIE)
 $text = preg_replace_callback("/\%u([0-9A-F]{4,4})/","funky_javascript_callback",$text);
{$AspisRetTemp = $text;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_macIE",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$is_winIE",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_macIE",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$is_winIE",$AspisChangesCache);
 }
function balanceTags ( $text,$force = false ) {
if ( !$force && get_option('use_balanceTags') == 0)
 {$AspisRetTemp = $text;
return $AspisRetTemp;
}{$AspisRetTemp = force_balance_tags($text);
return $AspisRetTemp;
} }
function force_balance_tags ( $text ) {
$tagstack = array();
$stacksize = 0;
$tagqueue = '';
$newtext = '';
$single_tags = array('br','hr','img','input');
$nestable_tags = array('blockquote','div','span');
$text = str_replace('< !--','<    !--',$text);
$text = preg_replace('#<([0-9]{1})#','&lt;$1',$text);
while ( preg_match("/<(\/?\w*)\s*([^>]*)>/",$text,$regex) )
{$newtext .= $tagqueue;
$i = strpos($text,$regex[0]);
$l = strlen($regex[0]);
$tagqueue = '';
if ( isset($regex[1][0]) && '/' == $regex[1][0])
 {$tag = strtolower(substr($regex[1],1));
if ( $stacksize <= 0)
 {$tag = '';
}else 
{if ( $tagstack[$stacksize - 1] == $tag)
 {$tag = '</' . $tag . '>';
array_pop($tagstack);
$stacksize--;
}else 
{{for ( $j = $stacksize - 1 ; $j >= 0 ; $j-- )
{if ( $tagstack[$j] == $tag)
 {for ( $k = $stacksize - 1 ; $k >= $j ; $k-- )
{$tagqueue .= '</' . array_pop($tagstack) . '>';
$stacksize--;
}break ;
}}$tag = '';
}}}}else 
{{$tag = strtolower($regex[1]);
if ( (substr($regex[2],-1) == '/') || ($tag == ''))
 {}elseif ( in_array($tag,$single_tags))
 {$regex[2] .= '/';
}else 
{{if ( ($stacksize > 0) && !in_array($tag,$nestable_tags) && ($tagstack[$stacksize - 1] == $tag))
 {$tagqueue = '</' . array_pop($tagstack) . '>';
$stacksize--;
}$stacksize = array_push($tagstack,$tag);
}}$attributes = $regex[2];
if ( $attributes)
 {$attributes = ' ' . $attributes;
}$tag = '<' . $tag . $attributes . '>';
if ( $tagqueue)
 {$tagqueue .= $tag;
$tag = '';
}}}$newtext .= substr($text,0,$i) . $tag;
$text = substr($text,$i + $l);
}$newtext .= $tagqueue;
$newtext .= $text;
while ( $x = array_pop($tagstack) )
{$newtext .= '</' . $x . '>';
}$newtext = str_replace("< !--","<!--",$newtext);
$newtext = str_replace("<    !--","< !--",$newtext);
{$AspisRetTemp = $newtext;
return $AspisRetTemp;
} }
function format_to_edit ( $content,$richedit = false ) {
$content = apply_filters('format_to_edit',$content);
if ( !$richedit)
 $content = htmlspecialchars($content);
{$AspisRetTemp = $content;
return $AspisRetTemp;
} }
function format_to_post ( $content ) {
$content = apply_filters('format_to_post',$content);
{$AspisRetTemp = $content;
return $AspisRetTemp;
} }
function zeroise ( $number,$threshold ) {
{$AspisRetTemp = sprintf('%0' . $threshold . 's',$number);
return $AspisRetTemp;
} }
function backslashit ( $string ) {
$string = preg_replace('/^([0-9])/','\\\\\\\\\1',$string);
$string = preg_replace('/([a-z])/i','\\\\\1',$string);
{$AspisRetTemp = $string;
return $AspisRetTemp;
} }
function trailingslashit ( $string ) {
{$AspisRetTemp = untrailingslashit($string) . '/';
return $AspisRetTemp;
} }
function untrailingslashit ( $string ) {
{$AspisRetTemp = rtrim($string,'/');
return $AspisRetTemp;
} }
function addslashes_gpc ( $gpc ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( get_magic_quotes_gpc())
 {$gpc = stripslashes($gpc);
}{$AspisRetTemp = deAspisWarningRC(esc_sql(attAspisRCO($gpc)));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function stripslashes_deep ( $value ) {
$value = is_array($value) ? array_map('stripslashes_deep',$value) : stripslashes($value);
{$AspisRetTemp = $value;
return $AspisRetTemp;
} }
function urlencode_deep ( $value ) {
$value = is_array($value) ? array_map('urlencode_deep',$value) : urlencode($value);
{$AspisRetTemp = $value;
return $AspisRetTemp;
} }
function antispambot ( $emailaddy,$mailto = 0 ) {
$emailNOSPAMaddy = '';
srand((double)microtime() * 1000000);
for ( $i = 0 ; $i < strlen($emailaddy) ; $i = $i + 1 )
{$j = floor(rand(0,1 + $mailto));
if ( $j == 0)
 {$emailNOSPAMaddy .= '&#' . ord(substr($emailaddy,$i,1)) . ';';
}elseif ( $j == 1)
 {$emailNOSPAMaddy .= substr($emailaddy,$i,1);
}elseif ( $j == 2)
 {$emailNOSPAMaddy .= '%' . zeroise(dechex(ord(substr($emailaddy,$i,1))),2);
}}$emailNOSPAMaddy = str_replace('@','&#64;',$emailNOSPAMaddy);
{$AspisRetTemp = $emailNOSPAMaddy;
return $AspisRetTemp;
} }
function _make_url_clickable_cb ( $matches ) {
$url = $matches[2];
$url = esc_url($url);
if ( empty($url))
 {$AspisRetTemp = $matches[0];
return $AspisRetTemp;
}{$AspisRetTemp = $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>";
return $AspisRetTemp;
} }
function _make_web_ftp_clickable_cb ( $matches ) {
$ret = '';
$dest = $matches[2];
$dest = 'http://' . $dest;
$dest = esc_url($dest);
if ( empty($dest))
 {$AspisRetTemp = $matches[0];
return $AspisRetTemp;
}if ( in_array(substr($dest,-1),array('.',',',';',':',')')) === true)
 {$ret = substr($dest,-1);
$dest = substr($dest,0,strlen($dest) - 1);
}{$AspisRetTemp = $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>$ret";
return $AspisRetTemp;
} }
function _make_email_clickable_cb ( $matches ) {
$email = $matches[2] . '@' . $matches[3];
{$AspisRetTemp = $matches[1] . "<a href=\"mailto:$email\">$email</a>";
return $AspisRetTemp;
} }
function make_clickable ( $ret ) {
$ret = ' ' . $ret;
$ret = preg_replace_callback('#(?<=[\s>])(\()?([\w]+?://(?:[\w\\x80-\\xff\#$%&~/=?@\[\](+-]|[.,;:](?![\s<]|(\))?([\s]|$))|(?(1)\)(?![\s<.,;:]|$)|\)))+)#is','_make_url_clickable_cb',$ret);
$ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]+)#is','_make_web_ftp_clickable_cb',$ret);
$ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i','_make_email_clickable_cb',$ret);
$ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i","$1$3</a>",$ret);
$ret = trim($ret);
{$AspisRetTemp = $ret;
return $AspisRetTemp;
} }
function wp_rel_nofollow ( $text ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$text = stripslashes($text);
$text = preg_replace_callback('|<a (.+?)>|i','wp_rel_nofollow_callback',$text);
$text = deAspisWarningRC(esc_sql(attAspisRCO($text)));
{$AspisRetTemp = $text;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_rel_nofollow_callback ( $matches ) {
$text = $matches[1];
$text = str_replace(array(' rel="nofollow"'," rel='nofollow'"),'',$text);
{$AspisRetTemp = "<a $text rel=\"nofollow\">";
return $AspisRetTemp;
} }
function translate_smiley ( $smiley ) {
{global $wpsmiliestrans;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpsmiliestrans,"\$wpsmiliestrans",$AspisChangesCache);
}if ( count($smiley) == 0)
 {{$AspisRetTemp = '';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpsmiliestrans",$AspisChangesCache);
return $AspisRetTemp;
}}$siteurl = get_option('siteurl');
$smiley = trim(reset($smiley));
$img = $wpsmiliestrans[$smiley];
$smiley_masked = esc_attr($smiley);
$srcurl = apply_filters('smilies_src',"$siteurl/wp-includes/images/smilies/$img",$img,$siteurl);
{$AspisRetTemp = " <img src='$srcurl' alt='$smiley_masked' class='wp-smiley' /> ";
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpsmiliestrans",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpsmiliestrans",$AspisChangesCache);
 }
function convert_smilies ( $text ) {
{global $wp_smiliessearch;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_smiliessearch,"\$wp_smiliessearch",$AspisChangesCache);
}$output = '';
if ( get_option('use_smilies') && !empty($wp_smiliessearch))
 {$textarr = preg_split("/(<.*>)/U",$text,-1,PREG_SPLIT_DELIM_CAPTURE);
$stop = count($textarr);
for ( $i = 0 ; $i < $stop ; $i++ )
{$content = $textarr[$i];
if ( (strlen($content) > 0) && ('<' != $content[0]))
 {$content = preg_replace_callback($wp_smiliessearch,'translate_smiley',$content);
}$output .= $content;
}}else 
{{$output = $text;
}}{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_smiliessearch",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_smiliessearch",$AspisChangesCache);
 }
function is_email ( $email,$check_dns = false ) {
if ( strlen($email) < 3)
 {{$AspisRetTemp = apply_filters('is_email',false,$email,'email_too_short');
return $AspisRetTemp;
}}if ( strpos($email,'@',1) === false)
 {{$AspisRetTemp = apply_filters('is_email',false,$email,'email_no_at');
return $AspisRetTemp;
}}list($local,$domain) = explode('@',$email,2);
if ( !preg_match('/^[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~\.-]+$/',$local))
 {{$AspisRetTemp = apply_filters('is_email',false,$email,'local_invalid_chars');
return $AspisRetTemp;
}}if ( preg_match('/\.{2,}/',$domain))
 {{$AspisRetTemp = apply_filters('is_email',false,$email,'domain_period_sequence');
return $AspisRetTemp;
}}if ( trim($domain," \t\n\r\0\x0B.") !== $domain)
 {{$AspisRetTemp = apply_filters('is_email',false,$email,'domain_period_limits');
return $AspisRetTemp;
}}$subs = explode('.',$domain);
if ( 2 > count($subs))
 {{$AspisRetTemp = apply_filters('is_email',false,$email,'domain_no_periods');
return $AspisRetTemp;
}}foreach ( $subs as $sub  )
{if ( trim($sub," \t\n\r\0\x0B-") !== $sub)
 {{$AspisRetTemp = apply_filters('is_email',false,$email,'sub_hyphen_limits');
return $AspisRetTemp;
}}if ( !preg_match('/^[a-z0-9-]+$/i',$sub))
 {{$AspisRetTemp = apply_filters('is_email',false,$email,'sub_invalid_chars');
return $AspisRetTemp;
}}}if ( $check_dns && function_exists('checkdnsrr') && !(checkdnsrr($domain . '.','MX') || checkdnsrr($domain . '.','A')))
 {{$AspisRetTemp = apply_filters('is_email',false,$email,'dns_no_rr');
return $AspisRetTemp;
}}{$AspisRetTemp = apply_filters('is_email',$email,$email,null);
return $AspisRetTemp;
} }
function wp_iso_descrambler ( $string ) {
if ( !preg_match('#\=\?(.+)\?Q\?(.+)\?\=#i',$string,$matches))
 {{$AspisRetTemp = $string;
return $AspisRetTemp;
}}else 
{{$subject = str_replace('_',' ',$matches[2]);
$subject = preg_replace_callback('#\=([0-9a-f]{2})#i',create_function('$match','return chr(hexdec(strtolower($match[1])));'),$subject);
{$AspisRetTemp = $subject;
return $AspisRetTemp;
}}} }
function get_gmt_from_date ( $string,$format = 'Y-m-d H:i:s' ) {
preg_match('#([0-9]{1,4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#',$string,$matches);
$string_time = gmmktime($matches[4],$matches[5],$matches[6],$matches[2],$matches[3],$matches[1]);
$string_gmt = gmdate($format,$string_time - get_option('gmt_offset') * 3600);
{$AspisRetTemp = $string_gmt;
return $AspisRetTemp;
} }
function get_date_from_gmt ( $string,$format = 'Y-m-d H:i:s' ) {
preg_match('#([0-9]{1,4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#',$string,$matches);
$string_time = gmmktime($matches[4],$matches[5],$matches[6],$matches[2],$matches[3],$matches[1]);
$string_localtime = gmdate($format,$string_time + get_option('gmt_offset') * 3600);
{$AspisRetTemp = $string_localtime;
return $AspisRetTemp;
} }
function iso8601_timezone_to_offset ( $timezone ) {
if ( $timezone == 'Z')
 {$offset = 0;
}else 
{{$sign = (substr($timezone,0,1) == '+') ? 1 : -1;
$hours = intval(substr($timezone,1,2));
$minutes = intval(substr($timezone,3,4)) / 60;
$offset = $sign * 3600 * ($hours + $minutes);
}}{$AspisRetTemp = $offset;
return $AspisRetTemp;
} }
function iso8601_to_datetime ( $date_string,$timezone = 'user' ) {
$timezone = strtolower($timezone);
if ( $timezone == 'gmt')
 {preg_match('#([0-9]{4})([0-9]{2})([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(Z|[\+|\-][0-9]{2,4}){0,1}#',$date_string,$date_bits);
if ( !empty($date_bits[7]))
 {$offset = iso8601_timezone_to_offset($date_bits[7]);
}else 
{{$offset = 3600 * get_option('gmt_offset');
}}$timestamp = gmmktime($date_bits[4],$date_bits[5],$date_bits[6],$date_bits[2],$date_bits[3],$date_bits[1]);
$timestamp -= $offset;
{$AspisRetTemp = gmdate('Y-m-d H:i:s',$timestamp);
return $AspisRetTemp;
}}else 
{if ( $timezone == 'user')
 {{$AspisRetTemp = preg_replace('#([0-9]{4})([0-9]{2})([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(Z|[\+|\-][0-9]{2,4}){0,1}#','$1-$2-$3 $4:$5:$6',$date_string);
return $AspisRetTemp;
}}} }
function popuplinks ( $text ) {
$text = preg_replace('/<a (.+?)>/i',"<a $1 target='_blank' rel='external'>",$text);
{$AspisRetTemp = $text;
return $AspisRetTemp;
} }
function sanitize_email ( $email ) {
if ( strlen($email) < 3)
 {{$AspisRetTemp = apply_filters('sanitize_email','',$email,'email_too_short');
return $AspisRetTemp;
}}if ( strpos($email,'@',1) === false)
 {{$AspisRetTemp = apply_filters('sanitize_email','',$email,'email_no_at');
return $AspisRetTemp;
}}list($local,$domain) = explode('@',$email,2);
$local = preg_replace('/[^a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~\.-]/','',$local);
if ( '' === $local)
 {{$AspisRetTemp = apply_filters('sanitize_email','',$email,'local_invalid_chars');
return $AspisRetTemp;
}}$domain = preg_replace('/\.{2,}/','',$domain);
if ( '' === $domain)
 {{$AspisRetTemp = apply_filters('sanitize_email','',$email,'domain_period_sequence');
return $AspisRetTemp;
}}$domain = trim($domain," \t\n\r\0\x0B.");
if ( '' === $domain)
 {{$AspisRetTemp = apply_filters('sanitize_email','',$email,'domain_period_limits');
return $AspisRetTemp;
}}$subs = explode('.',$domain);
if ( 2 > count($subs))
 {{$AspisRetTemp = apply_filters('sanitize_email','',$email,'domain_no_periods');
return $AspisRetTemp;
}}$new_subs = array();
foreach ( $subs as $sub  )
{$sub = trim($sub," \t\n\r\0\x0B-");
$sub = preg_replace('/^[^a-z0-9-]+$/i','',$sub);
if ( '' !== $sub)
 {$new_subs[] = $sub;
}}if ( 2 > count($new_subs))
 {{$AspisRetTemp = apply_filters('sanitize_email','',$email,'domain_no_valid_subs');
return $AspisRetTemp;
}}$domain = join('.',$new_subs);
$email = $local . '@' . $domain;
{$AspisRetTemp = apply_filters('sanitize_email',$email,$email,null);
return $AspisRetTemp;
} }
function human_time_diff ( $from,$to = '' ) {
if ( empty($to))
 $to = time();
$diff = (int)abs($to - $from);
if ( $diff <= 3600)
 {$mins = round($diff / 60);
if ( $mins <= 1)
 {$mins = 1;
}$since = sprintf(_n('%s min','%s mins',$mins),$mins);
}else 
{if ( ($diff <= 86400) && ($diff > 3600))
 {$hours = round($diff / 3600);
if ( $hours <= 1)
 {$hours = 1;
}$since = sprintf(_n('%s hour','%s hours',$hours),$hours);
}elseif ( $diff >= 86400)
 {$days = round($diff / 86400);
if ( $days <= 1)
 {$days = 1;
}$since = sprintf(_n('%s day','%s days',$days),$days);
}}{$AspisRetTemp = $since;
return $AspisRetTemp;
} }
function wp_trim_excerpt ( $text ) {
$raw_excerpt = $text;
if ( '' == $text)
 {$text = get_the_content('');
$text = strip_shortcodes($text);
$text = apply_filters('the_content',$text);
$text = str_replace(']]>',']]&gt;',$text);
$text = strip_tags($text);
$excerpt_length = apply_filters('excerpt_length',55);
$excerpt_more = apply_filters('excerpt_more',' ' . '[...]');
$words = explode(' ',$text,$excerpt_length + 1);
if ( count($words) > $excerpt_length)
 {array_pop($words);
$text = implode(' ',$words);
$text = $text . $excerpt_more;
}}{$AspisRetTemp = apply_filters('wp_trim_excerpt',$text,$raw_excerpt);
return $AspisRetTemp;
} }
function ent2ncr ( $text ) {
$to_ncr = array('&quot;' => '&#34;','&amp;' => '&#38;','&frasl;' => '&#47;','&lt;' => '&#60;','&gt;' => '&#62;','|' => '&#124;','&nbsp;' => '&#160;','&iexcl;' => '&#161;','&cent;' => '&#162;','&pound;' => '&#163;','&curren;' => '&#164;','&yen;' => '&#165;','&brvbar;' => '&#166;','&brkbar;' => '&#166;','&sect;' => '&#167;','&uml;' => '&#168;','&die;' => '&#168;','&copy;' => '&#169;','&ordf;' => '&#170;','&laquo;' => '&#171;','&not;' => '&#172;','&shy;' => '&#173;','&reg;' => '&#174;','&macr;' => '&#175;','&hibar;' => '&#175;','&deg;' => '&#176;','&plusmn;' => '&#177;','&sup2;' => '&#178;','&sup3;' => '&#179;','&acute;' => '&#180;','&micro;' => '&#181;','&para;' => '&#182;','&middot;' => '&#183;','&cedil;' => '&#184;','&sup1;' => '&#185;','&ordm;' => '&#186;','&raquo;' => '&#187;','&frac14;' => '&#188;','&frac12;' => '&#189;','&frac34;' => '&#190;','&iquest;' => '&#191;','&Agrave;' => '&#192;','&Aacute;' => '&#193;','&Acirc;' => '&#194;','&Atilde;' => '&#195;','&Auml;' => '&#196;','&Aring;' => '&#197;','&AElig;' => '&#198;','&Ccedil;' => '&#199;','&Egrave;' => '&#200;','&Eacute;' => '&#201;','&Ecirc;' => '&#202;','&Euml;' => '&#203;','&Igrave;' => '&#204;','&Iacute;' => '&#205;','&Icirc;' => '&#206;','&Iuml;' => '&#207;','&ETH;' => '&#208;','&Ntilde;' => '&#209;','&Ograve;' => '&#210;','&Oacute;' => '&#211;','&Ocirc;' => '&#212;','&Otilde;' => '&#213;','&Ouml;' => '&#214;','&times;' => '&#215;','&Oslash;' => '&#216;','&Ugrave;' => '&#217;','&Uacute;' => '&#218;','&Ucirc;' => '&#219;','&Uuml;' => '&#220;','&Yacute;' => '&#221;','&THORN;' => '&#222;','&szlig;' => '&#223;','&agrave;' => '&#224;','&aacute;' => '&#225;','&acirc;' => '&#226;','&atilde;' => '&#227;','&auml;' => '&#228;','&aring;' => '&#229;','&aelig;' => '&#230;','&ccedil;' => '&#231;','&egrave;' => '&#232;','&eacute;' => '&#233;','&ecirc;' => '&#234;','&euml;' => '&#235;','&igrave;' => '&#236;','&iacute;' => '&#237;','&icirc;' => '&#238;','&iuml;' => '&#239;','&eth;' => '&#240;','&ntilde;' => '&#241;','&ograve;' => '&#242;','&oacute;' => '&#243;','&ocirc;' => '&#244;','&otilde;' => '&#245;','&ouml;' => '&#246;','&divide;' => '&#247;','&oslash;' => '&#248;','&ugrave;' => '&#249;','&uacute;' => '&#250;','&ucirc;' => '&#251;','&uuml;' => '&#252;','&yacute;' => '&#253;','&thorn;' => '&#254;','&yuml;' => '&#255;','&OElig;' => '&#338;','&oelig;' => '&#339;','&Scaron;' => '&#352;','&scaron;' => '&#353;','&Yuml;' => '&#376;','&fnof;' => '&#402;','&circ;' => '&#710;','&tilde;' => '&#732;','&Alpha;' => '&#913;','&Beta;' => '&#914;','&Gamma;' => '&#915;','&Delta;' => '&#916;','&Epsilon;' => '&#917;','&Zeta;' => '&#918;','&Eta;' => '&#919;','&Theta;' => '&#920;','&Iota;' => '&#921;','&Kappa;' => '&#922;','&Lambda;' => '&#923;','&Mu;' => '&#924;','&Nu;' => '&#925;','&Xi;' => '&#926;','&Omicron;' => '&#927;','&Pi;' => '&#928;','&Rho;' => '&#929;','&Sigma;' => '&#931;','&Tau;' => '&#932;','&Upsilon;' => '&#933;','&Phi;' => '&#934;','&Chi;' => '&#935;','&Psi;' => '&#936;','&Omega;' => '&#937;','&alpha;' => '&#945;','&beta;' => '&#946;','&gamma;' => '&#947;','&delta;' => '&#948;','&epsilon;' => '&#949;','&zeta;' => '&#950;','&eta;' => '&#951;','&theta;' => '&#952;','&iota;' => '&#953;','&kappa;' => '&#954;','&lambda;' => '&#955;','&mu;' => '&#956;','&nu;' => '&#957;','&xi;' => '&#958;','&omicron;' => '&#959;','&pi;' => '&#960;','&rho;' => '&#961;','&sigmaf;' => '&#962;','&sigma;' => '&#963;','&tau;' => '&#964;','&upsilon;' => '&#965;','&phi;' => '&#966;','&chi;' => '&#967;','&psi;' => '&#968;','&omega;' => '&#969;','&thetasym;' => '&#977;','&upsih;' => '&#978;','&piv;' => '&#982;','&ensp;' => '&#8194;','&emsp;' => '&#8195;','&thinsp;' => '&#8201;','&zwnj;' => '&#8204;','&zwj;' => '&#8205;','&lrm;' => '&#8206;','&rlm;' => '&#8207;','&ndash;' => '&#8211;','&mdash;' => '&#8212;','&lsquo;' => '&#8216;','&rsquo;' => '&#8217;','&sbquo;' => '&#8218;','&ldquo;' => '&#8220;','&rdquo;' => '&#8221;','&bdquo;' => '&#8222;','&dagger;' => '&#8224;','&Dagger;' => '&#8225;','&bull;' => '&#8226;','&hellip;' => '&#8230;','&permil;' => '&#8240;','&prime;' => '&#8242;','&Prime;' => '&#8243;','&lsaquo;' => '&#8249;','&rsaquo;' => '&#8250;','&oline;' => '&#8254;','&frasl;' => '&#8260;','&euro;' => '&#8364;','&image;' => '&#8465;','&weierp;' => '&#8472;','&real;' => '&#8476;','&trade;' => '&#8482;','&alefsym;' => '&#8501;','&crarr;' => '&#8629;','&lArr;' => '&#8656;','&uArr;' => '&#8657;','&rArr;' => '&#8658;','&dArr;' => '&#8659;','&hArr;' => '&#8660;','&forall;' => '&#8704;','&part;' => '&#8706;','&exist;' => '&#8707;','&empty;' => '&#8709;','&nabla;' => '&#8711;','&isin;' => '&#8712;','&notin;' => '&#8713;','&ni;' => '&#8715;','&prod;' => '&#8719;','&sum;' => '&#8721;','&minus;' => '&#8722;','&lowast;' => '&#8727;','&radic;' => '&#8730;','&prop;' => '&#8733;','&infin;' => '&#8734;','&ang;' => '&#8736;','&and;' => '&#8743;','&or;' => '&#8744;','&cap;' => '&#8745;','&cup;' => '&#8746;','&int;' => '&#8747;','&there4;' => '&#8756;','&sim;' => '&#8764;','&cong;' => '&#8773;','&asymp;' => '&#8776;','&ne;' => '&#8800;','&equiv;' => '&#8801;','&le;' => '&#8804;','&ge;' => '&#8805;','&sub;' => '&#8834;','&sup;' => '&#8835;','&nsub;' => '&#8836;','&sube;' => '&#8838;','&supe;' => '&#8839;','&oplus;' => '&#8853;','&otimes;' => '&#8855;','&perp;' => '&#8869;','&sdot;' => '&#8901;','&lceil;' => '&#8968;','&rceil;' => '&#8969;','&lfloor;' => '&#8970;','&rfloor;' => '&#8971;','&lang;' => '&#9001;','&rang;' => '&#9002;','&larr;' => '&#8592;','&uarr;' => '&#8593;','&rarr;' => '&#8594;','&darr;' => '&#8595;','&harr;' => '&#8596;','&loz;' => '&#9674;','&spades;' => '&#9824;','&clubs;' => '&#9827;','&hearts;' => '&#9829;','&diams;' => '&#9830;');
{$AspisRetTemp = str_replace(array_keys($to_ncr),array_values($to_ncr),$text);
return $AspisRetTemp;
} }
function wp_richedit_pre ( $text ) {
if ( empty($text))
 {$AspisRetTemp = apply_filters('richedit_pre','');
return $AspisRetTemp;
}$output = convert_chars($text);
$output = wpautop($output);
$output = htmlspecialchars($output,ENT_NOQUOTES);
{$AspisRetTemp = apply_filters('richedit_pre',$output);
return $AspisRetTemp;
} }
function wp_htmledit_pre ( $output ) {
if ( !empty($output))
 $output = htmlspecialchars($output,ENT_NOQUOTES);
{$AspisRetTemp = apply_filters('htmledit_pre',$output);
return $AspisRetTemp;
} }
function clean_url ( $url,$protocols = null,$context = 'display' ) {
$original_url = $url;
if ( '' == $url)
 {$AspisRetTemp = $url;
return $AspisRetTemp;
}$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i','',$url);
$strip = array('%0d','%0a','%0D','%0A');
$url = _deep_replace($strip,$url);
$url = str_replace(';//','://',$url);
if ( strpos($url,':') === false && substr($url,0,1) != '/' && substr($url,0,1) != '#' && !preg_match('/^[a-z0-9-]+?\.php/i',$url))
 $url = 'http://' . $url;
if ( 'display' == $context)
 {$url = preg_replace('/&([^#])(?![a-z]{2,8};)/','&#038;$1',$url);
$url = str_replace("'",'&#039;',$url);
}if ( !is_array($protocols))
 $protocols = array('http','https','ftp','ftps','mailto','news','irc','gopher','nntp','feed','telnet');
if ( wp_kses_bad_protocol($url,$protocols) != $url)
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = apply_filters('clean_url',$url,$original_url,$context);
return $AspisRetTemp;
} }
function _deep_replace ( $search,$subject ) {
$found = true;
while ( $found )
{$found = false;
foreach ( (array)$search as $val  )
{while ( strpos($subject,$val) !== false )
{$found = true;
$subject = str_replace($val,'',$subject);
}}}{$AspisRetTemp = $subject;
return $AspisRetTemp;
} }
function  esc_sql ( $sql ) {
{global  $wpdb;
$AspisVar0 = &AspisTaintUntaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}{$AspisRetTemp = AspisReferenceMethodCall($wpdb[0],"escape",array( AspisPushRefParam($sql)),array(0));
AspisRestoreUntaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreUntaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function esc_url ( $url,$protocols = null ) {
{$AspisRetTemp = clean_url($url,$protocols,'display');
return $AspisRetTemp;
} }
function esc_url_raw ( $url,$protocols = null ) {
{$AspisRetTemp = clean_url($url,$protocols,'db');
return $AspisRetTemp;
} }
function sanitize_url ( $url,$protocols = null ) {
{$AspisRetTemp = clean_url($url,$protocols,'db');
return $AspisRetTemp;
} }
function htmlentities2 ( $myHTML ) {
$translation_table = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
$translation_table[chr(38)] = '&';
{$AspisRetTemp = preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/","&amp;",strtr($myHTML,$translation_table));
return $AspisRetTemp;
} }
function esc_js ( $text ) {
$safe_text = wp_check_invalid_utf8($text);
$safe_text = _wp_specialchars($safe_text,ENT_COMPAT);
$safe_text = preg_replace('/&#(x)?0*(?(1)27|39);?/i',"'",stripslashes($safe_text));
$safe_text = str_replace("\r",'',$safe_text);
$safe_text = str_replace("\n",'\\n',addslashes($safe_text));
{$AspisRetTemp = apply_filters('js_escape',$safe_text,$text);
return $AspisRetTemp;
} }
function js_escape ( $text ) {
{$AspisRetTemp = esc_js($text);
return $AspisRetTemp;
} }
function esc_html ( $text ) {
$safe_text = wp_check_invalid_utf8($text);
$safe_text = _wp_specialchars($safe_text,ENT_QUOTES);
{$AspisRetTemp = apply_filters('esc_html',$safe_text,$text);
return $AspisRetTemp;
} }
function wp_specialchars ( $string,$quote_style = ENT_NOQUOTES,$charset = false,$double_encode = false ) {
if ( func_num_args() > 1)
 {$args = func_get_args();
{$AspisRetTemp = AspisUntainted_call_user_func_array('_wp_specialchars',$args);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = esc_html($string);
return $AspisRetTemp;
}}} }
function esc_attr ( $text ) {
$safe_text = wp_check_invalid_utf8($text);
$safe_text = _wp_specialchars($safe_text,ENT_QUOTES);
{$AspisRetTemp = apply_filters('attribute_escape',$safe_text,$text);
return $AspisRetTemp;
} }
function attribute_escape ( $text ) {
{$AspisRetTemp = esc_attr($text);
return $AspisRetTemp;
} }
function tag_escape ( $tag_name ) {
$safe_tag = strtolower(preg_replace('/[^a-zA-Z_:]/','',$tag_name));
{$AspisRetTemp = apply_filters('tag_escape',$safe_tag,$tag_name);
return $AspisRetTemp;
} }
function like_escape ( $text ) {
{$AspisRetTemp = str_replace(array("%","_"),array("\\%","\\_"),$text);
return $AspisRetTemp;
} }
function wp_make_link_relative ( $link ) {
{$AspisRetTemp = preg_replace('|https?://[^/]+(/.*)|i','$1',$link);
return $AspisRetTemp;
} }
function sanitize_option ( $option,$value ) {
switch ( $option ) {
case 'admin_email':$value = sanitize_email($value);
break ;
case 'thumbnail_size_w':case 'thumbnail_size_h':case 'medium_size_w':case 'medium_size_h':case 'large_size_w':case 'large_size_h':case 'embed_size_h':case 'default_post_edit_rows':case 'mailserver_port':case 'comment_max_links':case 'page_on_front':case 'rss_excerpt_length':case 'default_category':case 'default_email_category':case 'default_link_category':case 'close_comments_days_old':case 'comments_per_page':case 'thread_comments_depth':case 'users_can_register':$value = absint($value);
break ;
case 'embed_size_w':if ( '' !== $value)
 $value = absint($value);
break ;
case 'posts_per_page':case 'posts_per_rss':$value = (int)$value;
if ( empty($value))
 $value = 1;
if ( $value < -1)
 $value = abs($value);
break ;
case 'default_ping_status':case 'default_comment_status':if ( $value == '0' || $value == '')
 $value = 'closed';
break ;
case 'blogdescription':case 'blogname':$value = addslashes($value);
$value = wp_filter_post_kses($value);
$value = stripslashes($value);
$value = esc_html($value);
break ;
case 'blog_charset':$value = preg_replace('/[^a-zA-Z0-9_-]/','',$value);
break ;
case 'date_format':case 'time_format':case 'mailserver_url':case 'mailserver_login':case 'mailserver_pass':case 'ping_sites':case 'upload_path':$value = strip_tags($value);
$value = addslashes($value);
$value = wp_filter_kses($value);
$value = stripslashes($value);
break ;
case 'gmt_offset':$value = preg_replace('/[^0-9:.-]/','',$value);
break ;
case 'siteurl':case 'home':$value = stripslashes($value);
$value = esc_url($value);
break ;
default :$value = apply_filters("sanitize_option_{$option}",$value,$option);
break ;
 }
{$AspisRetTemp = $value;
return $AspisRetTemp;
} }
function wp_parse_str ( $string,&$array ) {
parse_str($string,$array);
if ( get_magic_quotes_gpc())
 $array = stripslashes_deep($array);
$array = apply_filters('wp_parse_str',$array);
 }
function wp_pre_kses_less_than ( $text ) {
{$AspisRetTemp = preg_replace_callback('%<[^>]*?((?=<)|>|$)%','wp_pre_kses_less_than_callback',$text);
return $AspisRetTemp;
} }
function wp_pre_kses_less_than_callback ( $matches ) {
if ( false === strpos($matches[0],'>'))
 {$AspisRetTemp = esc_html($matches[0]);
return $AspisRetTemp;
}{$AspisRetTemp = $matches[0];
return $AspisRetTemp;
} }
function wp_sprintf ( $pattern ) {
$args = func_get_args();
$len = strlen($pattern);
$start = 0;
$result = '';
$arg_index = 0;
while ( $len > $start )
{if ( strlen($pattern) - 1 == $start)
 {$result .= substr($pattern,-1);
break ;
}if ( substr($pattern,$start,2) == '%%')
 {$start += 2;
$result .= '%';
continue ;
}$end = strpos($pattern,'%',$start + 1);
if ( false === $end)
 $end = $len;
$fragment = substr($pattern,$start,$end - $start);
if ( $pattern[$start] == '%')
 {if ( preg_match('/^%(\d+)\$/',$fragment,$matches))
 {$arg = isset($args[$matches[1]]) ? $args[$matches[1]] : '';
$fragment = str_replace("%{$matches[1]}$",'%',$fragment);
}else 
{{++$arg_index;
$arg = isset($args[$arg_index]) ? $args[$arg_index] : '';
}}$_fragment = apply_filters('wp_sprintf',$fragment,$arg);
if ( $_fragment != $fragment)
 $fragment = $_fragment;
else 
{$fragment = sprintf($fragment,strval($arg));
}}$result .= $fragment;
$start = $end;
}{$AspisRetTemp = $result;
return $AspisRetTemp;
} }
function wp_sprintf_l ( $pattern,$args ) {
if ( substr($pattern,0,2) != '%l')
 {$AspisRetTemp = $pattern;
return $AspisRetTemp;
}if ( empty($args))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$l = apply_filters('wp_sprintf_l',array('between' => __(', '),'between_last_two' => __(', and '),'between_only_two' => __(' and '),));
$args = (array)$args;
$result = array_shift($args);
if ( count($args) == 1)
 $result .= $l['between_only_two'] . array_shift($args);
$i = count($args);
while ( $i )
{$arg = array_shift($args);
$i--;
if ( 0 == $i)
 $result .= $l['between_last_two'] . $arg;
else 
{$result .= $l['between'] . $arg;
}}{$AspisRetTemp = $result . substr($pattern,2);
return $AspisRetTemp;
} }
function wp_html_excerpt ( $str,$count ) {
$str = wp_strip_all_tags($str,true);
$str = mb_substr($str,0,$count);
$str = preg_replace('/&[^;\s]{0,6}$/','',$str);
{$AspisRetTemp = $str;
return $AspisRetTemp;
} }
function links_add_base_url ( $content,$base,$attrs = array('src','href') ) {
$attrs = implode('|',(array)$attrs);
{$AspisRetTemp = preg_replace_callback("!($attrs)=(['\"])(.+?)\\2!i",create_function('$m','return _links_add_base($m, "' . $base . '");'),$content);
return $AspisRetTemp;
} }
function _links_add_base ( $m,$base ) {
{$AspisRetTemp = $m[1] . '=' . $m[2] . (strpos($m[3],'http://') === false ? path_join($base,$m[3]) : $m[3]) . $m[2];
return $AspisRetTemp;
} }
function links_add_target ( $content,$target = '_blank',$tags = array('a') ) {
$tags = implode('|',(array)$tags);
{$AspisRetTemp = preg_replace_callback("!<($tags)(.+?)>!i",create_function('$m','return _links_add_target($m, "' . $target . '");'),$content);
return $AspisRetTemp;
} }
function _links_add_target ( $m,$target ) {
$tag = $m[1];
$link = preg_replace('|(target=[\'"](.*?)[\'"])|i','',$m[2]);
{$AspisRetTemp = '<' . $tag . $link . ' target="' . $target . '">';
return $AspisRetTemp;
} }
function normalize_whitespace ( $str ) {
$str = trim($str);
$str = str_replace("\r","\n",$str);
$str = preg_replace(array('/\n+/','/[ \t]+/'),array("\n",' '),$str);
{$AspisRetTemp = $str;
return $AspisRetTemp;
} }
function wp_strip_all_tags ( $string,$remove_breaks = false ) {
$string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si','',$string);
$string = strip_tags($string);
if ( $remove_breaks)
 $string = preg_replace('/[\r\n\t ]+/',' ',$string);
{$AspisRetTemp = trim($string);
return $AspisRetTemp;
} }
function sanitize_text_field ( $str ) {
$filtered = wp_check_invalid_utf8($str);
if ( strpos($filtered,'<') !== false)
 {$filtered = wp_pre_kses_less_than($filtered);
$filtered = wp_strip_all_tags($filtered,true);
}else 
{{$filtered = trim(preg_replace('/[\r\n\t ]+/',' ',$filtered));
}}$match = array();
while ( preg_match('/%[a-f0-9]{2}/i',$filtered,$match) )
$filtered = str_replace($match[0],'',$filtered);
{$AspisRetTemp = apply_filters('sanitize_text_field',$filtered,$str);
return $AspisRetTemp;
} }
;
?>
<?php 