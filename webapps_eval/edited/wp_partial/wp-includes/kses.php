<?php require_once('AspisMain.php'); ?><?php
if ( !defined('CUSTOM_TAGS'))
 define('CUSTOM_TAGS',false);
if ( !CUSTOM_TAGS)
 {$allowedposttags = array('address' => array(),'a' => array('class' => array(),'href' => array(),'id' => array(),'title' => array(),'rel' => array(),'rev' => array(),'name' => array(),'target' => array()),'abbr' => array('class' => array(),'title' => array()),'acronym' => array('title' => array()),'b' => array(),'big' => array(),'blockquote' => array('id' => array(),'cite' => array(),'class' => array(),'lang' => array(),'xml:lang' => array()),'br' => array('class' => array()),'button' => array('disabled' => array(),'name' => array(),'type' => array(),'value' => array()),'caption' => array('align' => array(),'class' => array()),'cite' => array('class' => array(),'dir' => array(),'lang' => array(),'title' => array()),'code' => array('style' => array()),'col' => array('align' => array(),'char' => array(),'charoff' => array(),'span' => array(),'dir' => array(),'style' => array(),'valign' => array(),'width' => array()),'del' => array('datetime' => array()),'dd' => array(),'div' => array('align' => array(),'class' => array(),'dir' => array(),'lang' => array(),'style' => array(),'xml:lang' => array()),'dl' => array(),'dt' => array(),'em' => array(),'fieldset' => array(),'font' => array('color' => array(),'face' => array(),'size' => array()),'form' => array('action' => array(),'accept' => array(),'accept-charset' => array(),'enctype' => array(),'method' => array(),'name' => array(),'target' => array()),'h1' => array('align' => array(),'class' => array(),'id' => array(),'style' => array()),'h2' => array('align' => array(),'class' => array(),'id' => array(),'style' => array()),'h3' => array('align' => array(),'class' => array(),'id' => array(),'style' => array()),'h4' => array('align' => array(),'class' => array(),'id' => array(),'style' => array()),'h5' => array('align' => array(),'class' => array(),'id' => array(),'style' => array()),'h6' => array('align' => array(),'class' => array(),'id' => array(),'style' => array()),'hr' => array('align' => array(),'class' => array(),'noshade' => array(),'size' => array(),'width' => array()),'i' => array(),'img' => array('alt' => array(),'align' => array(),'border' => array(),'class' => array(),'height' => array(),'hspace' => array(),'longdesc' => array(),'vspace' => array(),'src' => array(),'style' => array(),'width' => array()),'ins' => array('datetime' => array(),'cite' => array()),'kbd' => array(),'label' => array('for' => array()),'legend' => array('align' => array()),'li' => array('align' => array(),'class' => array()),'p' => array('class' => array(),'align' => array(),'dir' => array(),'lang' => array(),'style' => array(),'xml:lang' => array()),'pre' => array('style' => array(),'width' => array()),'q' => array('cite' => array()),'s' => array(),'span' => array('class' => array(),'dir' => array(),'align' => array(),'lang' => array(),'style' => array(),'title' => array(),'xml:lang' => array()),'strike' => array(),'strong' => array(),'sub' => array(),'sup' => array(),'table' => array('align' => array(),'bgcolor' => array(),'border' => array(),'cellpadding' => array(),'cellspacing' => array(),'class' => array(),'dir' => array(),'id' => array(),'rules' => array(),'style' => array(),'summary' => array(),'width' => array()),'tbody' => array('align' => array(),'char' => array(),'charoff' => array(),'valign' => array()),'td' => array('abbr' => array(),'align' => array(),'axis' => array(),'bgcolor' => array(),'char' => array(),'charoff' => array(),'class' => array(),'colspan' => array(),'dir' => array(),'headers' => array(),'height' => array(),'nowrap' => array(),'rowspan' => array(),'scope' => array(),'style' => array(),'valign' => array(),'width' => array()),'textarea' => array('cols' => array(),'rows' => array(),'disabled' => array(),'name' => array(),'readonly' => array()),'tfoot' => array('align' => array(),'char' => array(),'class' => array(),'charoff' => array(),'valign' => array()),'th' => array('abbr' => array(),'align' => array(),'axis' => array(),'bgcolor' => array(),'char' => array(),'charoff' => array(),'class' => array(),'colspan' => array(),'headers' => array(),'height' => array(),'nowrap' => array(),'rowspan' => array(),'scope' => array(),'valign' => array(),'width' => array()),'thead' => array('align' => array(),'char' => array(),'charoff' => array(),'class' => array(),'valign' => array()),'title' => array(),'tr' => array('align' => array(),'bgcolor' => array(),'char' => array(),'charoff' => array(),'class' => array(),'style' => array(),'valign' => array()),'tt' => array(),'u' => array(),'ul' => array('class' => array(),'style' => array(),'type' => array()),'ol' => array('class' => array(),'start' => array(),'style' => array(),'type' => array()),'var' => array());
$allowedtags = array('a' => array('href' => array(),'title' => array()),'abbr' => array('title' => array()),'acronym' => array('title' => array()),'b' => array(),'blockquote' => array('cite' => array()),'cite' => array(),'code' => array(),'del' => array('datetime' => array()),'em' => array(),'i' => array(),'q' => array('cite' => array()),'strike' => array(),'strong' => array(),);
}function wp_kses ( $string,$allowed_html,$allowed_protocols = array('http','https','ftp','ftps','mailto','news','irc','gopher','nntp','feed','telnet') ) {
$string = wp_kses_no_null($string);
$string = wp_kses_js_entities($string);
$string = wp_kses_normalize_entities($string);
$allowed_html_fixed = wp_kses_array_lc($allowed_html);
$string = wp_kses_hook($string,$allowed_html_fixed,$allowed_protocols);
{$AspisRetTemp = wp_kses_split($string,$allowed_html_fixed,$allowed_protocols);
return $AspisRetTemp;
} }
function wp_kses_hook ( $string,$allowed_html,$allowed_protocols ) {
$string = apply_filters('pre_kses',$string,$allowed_html,$allowed_protocols);
{$AspisRetTemp = $string;
return $AspisRetTemp;
} }
function wp_kses_version (  ) {
{$AspisRetTemp = '0.2.2';
return $AspisRetTemp;
} }
function wp_kses_split ( $string,$allowed_html,$allowed_protocols ) {
{global $pass_allowed_html,$pass_allowed_protocols;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $pass_allowed_html,"\$pass_allowed_html",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($pass_allowed_protocols,"\$pass_allowed_protocols",$AspisChangesCache);
}$pass_allowed_html = $allowed_html;
$pass_allowed_protocols = $allowed_protocols;
{$AspisRetTemp = preg_replace_callback('%((<!--.*?(-->|$))|(<[^>]*(>|$)|>))%',create_function('$match','global $pass_allowed_html, $pass_allowed_protocols; return wp_kses_split2($match[1], $pass_allowed_html, $pass_allowed_protocols);'),$string);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pass_allowed_html",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$pass_allowed_protocols",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$pass_allowed_html",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$pass_allowed_protocols",$AspisChangesCache);
 }
function wp_kses_split2 ( $string,$allowed_html,$allowed_protocols ) {
$string = wp_kses_stripslashes($string);
if ( substr($string,0,1) != '<')
 {$AspisRetTemp = '&gt;';
return $AspisRetTemp;
}if ( preg_match('%^<!--(.*?)(-->)?$%',$string,$matches))
 {$string = str_replace(array('<!--','-->'),'',$matches[1]);
while ( $string != $newstring = wp_kses($string,$allowed_html,$allowed_protocols) )
$string = $newstring;
if ( $string == '')
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$string = preg_replace('/--+/','-',$string);
$string = preg_replace('/-$/','',$string);
{$AspisRetTemp = "<!--{$string}-->";
return $AspisRetTemp;
}}if ( !preg_match('%^<\s*(/\s*)?([a-zA-Z0-9]+)([^>]*)>?$%',$string,$matches))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$slash = trim($matches[1]);
$elem = $matches[2];
$attrlist = $matches[3];
if ( !@isset($allowed_html[strtolower($elem)]))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}if ( $slash != '')
 {$AspisRetTemp = "<$slash$elem>";
return $AspisRetTemp;
}{$AspisRetTemp = wp_kses_attr("$slash$elem",$attrlist,$allowed_html,$allowed_protocols);
return $AspisRetTemp;
} }
function wp_kses_attr ( $element,$attr,$allowed_html,$allowed_protocols ) {
$xhtml_slash = '';
if ( preg_match('%\s/\s*$%',$attr))
 $xhtml_slash = ' /';
if ( @count($allowed_html[strtolower($element)]) == 0)
 {$AspisRetTemp = "<$element$xhtml_slash>";
return $AspisRetTemp;
}$attrarr = wp_kses_hair($attr,$allowed_protocols);
$attr2 = '';
foreach ( $attrarr as $arreach  )
{if ( !@isset($allowed_html[strtolower($element)][strtolower($arreach['name'])]))
 continue ;
$current = $allowed_html[strtolower($element)][strtolower($arreach['name'])];
if ( $current == '')
 continue ;
if ( !is_array($current))
 $attr2 .= ' ' . $arreach['whole'];
else 
{{$ok = true;
foreach ( $current as $currkey =>$currval )
if ( !wp_kses_check_attr_val($arreach['value'],$arreach['vless'],$currkey,$currval))
 {$ok = false;
break ;
}if ( $arreach['name'] == 'style')
 {$orig_value = $arreach['value'];
$value = safecss_filter_attr($orig_value);
if ( empty($value))
 continue ;
$arreach['value'] = $value;
$arreach['whole'] = str_replace($orig_value,$value,$arreach['whole']);
}if ( $ok)
 $attr2 .= ' ' . $arreach['whole'];
}}}$attr2 = preg_replace('/[<>]/','',$attr2);
{$AspisRetTemp = "<$element$attr2$xhtml_slash>";
return $AspisRetTemp;
} }
function wp_kses_hair ( $attr,$allowed_protocols ) {
$attrarr = array();
$mode = 0;
$attrname = '';
$uris = array('xmlns','profile','href','src','cite','classid','codebase','data','usemap','longdesc','action');
while ( strlen($attr) != 0 )
{$working = 0;
switch ( $mode ) {
case 0:if ( preg_match('/^([-a-zA-Z]+)/',$attr,$match))
 {$attrname = $match[1];
$working = $mode = 1;
$attr = preg_replace('/^[-a-zA-Z]+/','',$attr);
}break ;
case 1:if ( preg_match('/^\s*=\s*/',$attr))
 {$working = 1;
$mode = 2;
$attr = preg_replace('/^\s*=\s*/','',$attr);
break ;
}if ( preg_match('/^\s+/',$attr))
 {$working = 1;
$mode = 0;
if ( FALSE === array_key_exists($attrname,$attrarr))
 {$attrarr[$attrname] = array('name' => $attrname,'value' => '','whole' => $attrname,'vless' => 'y');
}$attr = preg_replace('/^\s+/','',$attr);
}break ;
case 2:if ( preg_match('/^"([^"]*)"(\s+|$)/',$attr,$match))
 {$thisval = $match[1];
if ( in_array($attrname,$uris))
 $thisval = wp_kses_bad_protocol($thisval,$allowed_protocols);
if ( FALSE === array_key_exists($attrname,$attrarr))
 {$attrarr[$attrname] = array('name' => $attrname,'value' => $thisval,'whole' => "$attrname=\"$thisval\"",'vless' => 'n');
}$working = 1;
$mode = 0;
$attr = preg_replace('/^"[^"]*"(\s+|$)/','',$attr);
break ;
}if ( preg_match("/^'([^']*)'(\s+|$)/",$attr,$match))
 {$thisval = $match[1];
if ( in_array($attrname,$uris))
 $thisval = wp_kses_bad_protocol($thisval,$allowed_protocols);
if ( FALSE === array_key_exists($attrname,$attrarr))
 {$attrarr[$attrname] = array('name' => $attrname,'value' => $thisval,'whole' => "$attrname='$thisval'",'vless' => 'n');
}$working = 1;
$mode = 0;
$attr = preg_replace("/^'[^']*'(\s+|$)/",'',$attr);
break ;
}if ( preg_match("%^([^\s\"']+)(\s+|$)%",$attr,$match))
 {$thisval = $match[1];
if ( in_array($attrname,$uris))
 $thisval = wp_kses_bad_protocol($thisval,$allowed_protocols);
if ( FALSE === array_key_exists($attrname,$attrarr))
 {$attrarr[$attrname] = array('name' => $attrname,'value' => $thisval,'whole' => "$attrname=\"$thisval\"",'vless' => 'n');
}$working = 1;
$mode = 0;
$attr = preg_replace("%^[^\s\"']+(\s+|$)%",'',$attr);
}break ;
 }
if ( $working == 0)
 {$attr = wp_kses_html_error($attr);
$mode = 0;
}}if ( $mode == 1 && FALSE === array_key_exists($attrname,$attrarr))
 $attrarr[$attrname] = array('name' => $attrname,'value' => '','whole' => $attrname,'vless' => 'y');
{$AspisRetTemp = $attrarr;
return $AspisRetTemp;
} }
function wp_kses_check_attr_val ( $value,$vless,$checkname,$checkvalue ) {
$ok = true;
switch ( strtolower($checkname) ) {
case 'maxlen':if ( strlen($value) > $checkvalue)
 $ok = false;
break ;
case 'minlen':if ( strlen($value) < $checkvalue)
 $ok = false;
break ;
case 'maxval':if ( !preg_match('/^\s{0,6}[0-9]{1,6}\s{0,6}$/',$value))
 $ok = false;
if ( $value > $checkvalue)
 $ok = false;
break ;
case 'minval':if ( !preg_match('/^\s{0,6}[0-9]{1,6}\s{0,6}$/',$value))
 $ok = false;
if ( $value < $checkvalue)
 $ok = false;
break ;
case 'valueless':if ( strtolower($checkvalue) != $vless)
 $ok = false;
break ;
 }
{$AspisRetTemp = $ok;
return $AspisRetTemp;
} }
function wp_kses_bad_protocol ( $string,$allowed_protocols ) {
$string = wp_kses_no_null($string);
$string2 = $string . 'a';
while ( $string != $string2 )
{$string2 = $string;
$string = wp_kses_bad_protocol_once($string,$allowed_protocols);
}{$AspisRetTemp = $string;
return $AspisRetTemp;
} }
function wp_kses_no_null ( $string ) {
$string = preg_replace('/\0+/','',$string);
$string = preg_replace('/(\\\\0)+/','',$string);
{$AspisRetTemp = $string;
return $AspisRetTemp;
} }
function wp_kses_stripslashes ( $string ) {
{$AspisRetTemp = preg_replace('%\\\\"%','"',$string);
return $AspisRetTemp;
} }
function wp_kses_array_lc ( $inarray ) {
$outarray = array();
foreach ( (array)$inarray as $inkey =>$inval )
{$outkey = strtolower($inkey);
$outarray[$outkey] = array();
foreach ( (array)$inval as $inkey2 =>$inval2 )
{$outkey2 = strtolower($inkey2);
$outarray[$outkey][$outkey2] = $inval2;
}}{$AspisRetTemp = $outarray;
return $AspisRetTemp;
} }
function wp_kses_js_entities ( $string ) {
{$AspisRetTemp = preg_replace('%&\s*\{[^}]*(\}\s*;?|$)%','',$string);
return $AspisRetTemp;
} }
function wp_kses_html_error ( $string ) {
{$AspisRetTemp = preg_replace('/^("[^"]*("|$)|\'[^\']*(\'|$)|\S)*\s*/','',$string);
return $AspisRetTemp;
} }
function wp_kses_bad_protocol_once ( $string,$allowed_protocols ) {
{global $_kses_allowed_protocols;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_kses_allowed_protocols,"\$_kses_allowed_protocols",$AspisChangesCache);
}$_kses_allowed_protocols = $allowed_protocols;
$string2 = preg_split('/:|&#58;|&#x3a;/i',$string,2);
if ( isset($string2[1]) && !preg_match('%/\?%',$string2[0]))
 $string = wp_kses_bad_protocol_once2($string2[0]) . trim($string2[1]);
else 
{$string = preg_replace_callback('/^((&[^;]*;|[\sA-Za-z0-9])*)' . '(:|&#58;|&#[Xx]3[Aa];)\s*/','wp_kses_bad_protocol_once2',$string);
}{$AspisRetTemp = $string;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_kses_allowed_protocols",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_kses_allowed_protocols",$AspisChangesCache);
 }
function wp_kses_bad_protocol_once2 ( $matches ) {
{global $_kses_allowed_protocols;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_kses_allowed_protocols,"\$_kses_allowed_protocols",$AspisChangesCache);
}if ( is_array($matches))
 {if ( !isset($matches[1]) || empty($matches[1]))
 {$AspisRetTemp = '';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_kses_allowed_protocols",$AspisChangesCache);
return $AspisRetTemp;
}$string = $matches[1];
}else 
{{$string = $matches;
}}$string2 = wp_kses_decode_entities($string);
$string2 = preg_replace('/\s/','',$string2);
$string2 = wp_kses_no_null($string2);
$string2 = strtolower($string2);
$allowed = false;
foreach ( (array)$_kses_allowed_protocols as $one_protocol  )
if ( strtolower($one_protocol) == $string2)
 {$allowed = true;
break ;
}if ( $allowed)
 {$AspisRetTemp = "$string2:";
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_kses_allowed_protocols",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = '';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_kses_allowed_protocols",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_kses_allowed_protocols",$AspisChangesCache);
 }
function wp_kses_normalize_entities ( $string ) {
$string = str_replace('&','&amp;',$string);
$string = preg_replace('/&amp;([A-Za-z][A-Za-z0-9]{0,19});/','&\\1;',$string);
$string = preg_replace_callback('/&amp;#0*([0-9]{1,5});/','wp_kses_normalize_entities2',$string);
$string = preg_replace_callback('/&amp;#([Xx])0*(([0-9A-Fa-f]{2}){1,2});/','wp_kses_normalize_entities3',$string);
{$AspisRetTemp = $string;
return $AspisRetTemp;
} }
function wp_kses_normalize_entities2 ( $matches ) {
if ( !isset($matches[1]) || empty($matches[1]))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$i = $matches[1];
{$AspisRetTemp = ((!valid_unicode($i)) || ($i > 65535) ? "&amp;#$i;
" : "&#$i;
");
return $AspisRetTemp;
} }
function wp_kses_normalize_entities3 ( $matches ) {
if ( !isset($matches[2]) || empty($matches[2]))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$hexchars = $matches[2];
{$AspisRetTemp = ((!valid_unicode(hexdec($hexchars))) ? "&amp;#x$hexchars;
" : "&#x$hexchars;
");
return $AspisRetTemp;
} }
function valid_unicode ( $i ) {
{$AspisRetTemp = ($i == 0x9 || $i == 0xa || $i == 0xd || ($i >= 0x20 && $i <= 0xd7ff) || ($i >= 0xe000 && $i <= 0xfffd) || ($i >= 0x10000 && $i <= 0x10ffff));
return $AspisRetTemp;
} }
function wp_kses_decode_entities ( $string ) {
$string = preg_replace_callback('/&#([0-9]+);/','_wp_kses_decode_entities_chr',$string);
$string = preg_replace_callback('/&#[Xx]([0-9A-Fa-f]+);/','_wp_kses_decode_entities_chr_hexdec',$string);
{$AspisRetTemp = $string;
return $AspisRetTemp;
} }
function _wp_kses_decode_entities_chr ( $match ) {
{$AspisRetTemp = chr($match[1]);
return $AspisRetTemp;
} }
function _wp_kses_decode_entities_chr_hexdec ( $match ) {
{$AspisRetTemp = chr(hexdec($match[1]));
return $AspisRetTemp;
} }
function wp_filter_kses ( $data ) {
{global $allowedtags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $allowedtags,"\$allowedtags",$AspisChangesCache);
}{$AspisRetTemp = addslashes(wp_kses(stripslashes($data),$allowedtags));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$allowedtags",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$allowedtags",$AspisChangesCache);
 }
function wp_kses_data ( $data ) {
{global $allowedtags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $allowedtags,"\$allowedtags",$AspisChangesCache);
}{$AspisRetTemp = wp_kses($data,$allowedtags);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$allowedtags",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$allowedtags",$AspisChangesCache);
 }
function wp_filter_post_kses ( $data ) {
{global $allowedposttags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $allowedposttags,"\$allowedposttags",$AspisChangesCache);
}{$AspisRetTemp = addslashes(wp_kses(stripslashes($data),$allowedposttags));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$allowedposttags",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$allowedposttags",$AspisChangesCache);
 }
function wp_kses_post ( $data ) {
{global $allowedposttags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $allowedposttags,"\$allowedposttags",$AspisChangesCache);
}{$AspisRetTemp = wp_kses($data,$allowedposttags);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$allowedposttags",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$allowedposttags",$AspisChangesCache);
 }
function wp_filter_nohtml_kses ( $data ) {
{$AspisRetTemp = addslashes(wp_kses(stripslashes($data),array()));
return $AspisRetTemp;
} }
function kses_init_filters (  ) {
add_filter('pre_comment_content','wp_filter_kses');
add_filter('title_save_pre','wp_filter_kses');
add_filter('content_save_pre','wp_filter_post_kses');
add_filter('excerpt_save_pre','wp_filter_post_kses');
add_filter('content_filtered_save_pre','wp_filter_post_kses');
 }
function kses_remove_filters (  ) {
remove_filter('pre_comment_content','wp_filter_kses');
remove_filter('title_save_pre','wp_filter_kses');
remove_filter('content_save_pre','wp_filter_post_kses');
remove_filter('excerpt_save_pre','wp_filter_post_kses');
remove_filter('content_filtered_save_pre','wp_filter_post_kses');
 }
function kses_init (  ) {
kses_remove_filters();
if ( current_user_can('unfiltered_html') == false)
 kses_init_filters();
 }
add_action('init','kses_init');
add_action('set_current_user','kses_init');
function safecss_filter_attr ( $css,$deprecated = '' ) {
$css = wp_kses_no_null($css);
$css = str_replace(array("\n","\r","\t"),'',$css);
if ( preg_match('%[\\(&]|/\*%',$css))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$css_array = split(';',trim($css));
$allowed_attr = apply_filters('safe_style_css',array('text-align','margin','color','float','border','background','background-color','border-bottom','border-bottom-color','border-bottom-style','border-bottom-width','border-collapse','border-color','border-left','border-left-color','border-left-style','border-left-width','border-right','border-right-color','border-right-style','border-right-width','border-spacing','border-style','border-top','border-top-color','border-top-style','border-top-width','border-width','caption-side','clear','cursor','direction','font','font-family','font-size','font-style','font-variant','font-weight','height','letter-spacing','line-height','margin-bottom','margin-left','margin-right','margin-top','overflow','padding','padding-bottom','padding-left','padding-right','padding-top','text-decoration','text-indent','vertical-align','width'));
if ( empty($allowed_attr))
 {$AspisRetTemp = $css;
return $AspisRetTemp;
}$css = '';
foreach ( $css_array as $css_item  )
{if ( $css_item == '')
 continue ;
$css_item = trim($css_item);
$found = false;
if ( strpos($css_item,':') === false)
 {$found = true;
}else 
{{$parts = split(':',$css_item);
if ( in_array(trim($parts[0]),$allowed_attr))
 $found = true;
}}if ( $found)
 {if ( $css != '')
 $css .= ';';
$css .= $css_item;
}}{$AspisRetTemp = $css;
return $AspisRetTemp;
} }
