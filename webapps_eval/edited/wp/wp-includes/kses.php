<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('CUSTOM_TAGS')))))
 define(('CUSTOM_TAGS'),false);
if ( (!(CUSTOM_TAGS)))
 {$allowedposttags = array(array('address' => array(array(),false,false),'a' => array(array('class' => array(array(),false,false),'href' => array(array(),false,false),'id' => array(array(),false,false),'title' => array(array(),false,false),'rel' => array(array(),false,false),'rev' => array(array(),false,false),'name' => array(array(),false,false),'target' => array(array(),false,false)),false,false),'abbr' => array(array('class' => array(array(),false,false),'title' => array(array(),false,false)),false,false),'acronym' => array(array('title' => array(array(),false,false)),false,false),'b' => array(array(),false,false),'big' => array(array(),false,false),'blockquote' => array(array('id' => array(array(),false,false),'cite' => array(array(),false,false),'class' => array(array(),false,false),'lang' => array(array(),false,false),'xml:lang' => array(array(),false,false)),false,false),'br' => array(array('class' => array(array(),false,false)),false,false),'button' => array(array('disabled' => array(array(),false,false),'name' => array(array(),false,false),'type' => array(array(),false,false),'value' => array(array(),false,false)),false,false),'caption' => array(array('align' => array(array(),false,false),'class' => array(array(),false,false)),false,false),'cite' => array(array('class' => array(array(),false,false),'dir' => array(array(),false,false),'lang' => array(array(),false,false),'title' => array(array(),false,false)),false,false),'code' => array(array('style' => array(array(),false,false)),false,false),'col' => array(array('align' => array(array(),false,false),'char' => array(array(),false,false),'charoff' => array(array(),false,false),'span' => array(array(),false,false),'dir' => array(array(),false,false),'style' => array(array(),false,false),'valign' => array(array(),false,false),'width' => array(array(),false,false)),false,false),'del' => array(array('datetime' => array(array(),false,false)),false,false),'dd' => array(array(),false,false),'div' => array(array('align' => array(array(),false,false),'class' => array(array(),false,false),'dir' => array(array(),false,false),'lang' => array(array(),false,false),'style' => array(array(),false,false),'xml:lang' => array(array(),false,false)),false,false),'dl' => array(array(),false,false),'dt' => array(array(),false,false),'em' => array(array(),false,false),'fieldset' => array(array(),false,false),'font' => array(array('color' => array(array(),false,false),'face' => array(array(),false,false),'size' => array(array(),false,false)),false,false),'form' => array(array('action' => array(array(),false,false),'accept' => array(array(),false,false),'accept-charset' => array(array(),false,false),'enctype' => array(array(),false,false),'method' => array(array(),false,false),'name' => array(array(),false,false),'target' => array(array(),false,false)),false,false),'h1' => array(array('align' => array(array(),false,false),'class' => array(array(),false,false),'id' => array(array(),false,false),'style' => array(array(),false,false)),false,false),'h2' => array(array('align' => array(array(),false,false),'class' => array(array(),false,false),'id' => array(array(),false,false),'style' => array(array(),false,false)),false,false),'h3' => array(array('align' => array(array(),false,false),'class' => array(array(),false,false),'id' => array(array(),false,false),'style' => array(array(),false,false)),false,false),'h4' => array(array('align' => array(array(),false,false),'class' => array(array(),false,false),'id' => array(array(),false,false),'style' => array(array(),false,false)),false,false),'h5' => array(array('align' => array(array(),false,false),'class' => array(array(),false,false),'id' => array(array(),false,false),'style' => array(array(),false,false)),false,false),'h6' => array(array('align' => array(array(),false,false),'class' => array(array(),false,false),'id' => array(array(),false,false),'style' => array(array(),false,false)),false,false),'hr' => array(array('align' => array(array(),false,false),'class' => array(array(),false,false),'noshade' => array(array(),false,false),'size' => array(array(),false,false),'width' => array(array(),false,false)),false,false),'i' => array(array(),false,false),'img' => array(array('alt' => array(array(),false,false),'align' => array(array(),false,false),'border' => array(array(),false,false),'class' => array(array(),false,false),'height' => array(array(),false,false),'hspace' => array(array(),false,false),'longdesc' => array(array(),false,false),'vspace' => array(array(),false,false),'src' => array(array(),false,false),'style' => array(array(),false,false),'width' => array(array(),false,false)),false,false),'ins' => array(array('datetime' => array(array(),false,false),'cite' => array(array(),false,false)),false,false),'kbd' => array(array(),false,false),'label' => array(array('for' => array(array(),false,false)),false,false),'legend' => array(array('align' => array(array(),false,false)),false,false),'li' => array(array('align' => array(array(),false,false),'class' => array(array(),false,false)),false,false),'p' => array(array('class' => array(array(),false,false),'align' => array(array(),false,false),'dir' => array(array(),false,false),'lang' => array(array(),false,false),'style' => array(array(),false,false),'xml:lang' => array(array(),false,false)),false,false),'pre' => array(array('style' => array(array(),false,false),'width' => array(array(),false,false)),false,false),'q' => array(array('cite' => array(array(),false,false)),false,false),'s' => array(array(),false,false),'span' => array(array('class' => array(array(),false,false),'dir' => array(array(),false,false),'align' => array(array(),false,false),'lang' => array(array(),false,false),'style' => array(array(),false,false),'title' => array(array(),false,false),'xml:lang' => array(array(),false,false)),false,false),'strike' => array(array(),false,false),'strong' => array(array(),false,false),'sub' => array(array(),false,false),'sup' => array(array(),false,false),'table' => array(array('align' => array(array(),false,false),'bgcolor' => array(array(),false,false),'border' => array(array(),false,false),'cellpadding' => array(array(),false,false),'cellspacing' => array(array(),false,false),'class' => array(array(),false,false),'dir' => array(array(),false,false),'id' => array(array(),false,false),'rules' => array(array(),false,false),'style' => array(array(),false,false),'summary' => array(array(),false,false),'width' => array(array(),false,false)),false,false),'tbody' => array(array('align' => array(array(),false,false),'char' => array(array(),false,false),'charoff' => array(array(),false,false),'valign' => array(array(),false,false)),false,false),'td' => array(array('abbr' => array(array(),false,false),'align' => array(array(),false,false),'axis' => array(array(),false,false),'bgcolor' => array(array(),false,false),'char' => array(array(),false,false),'charoff' => array(array(),false,false),'class' => array(array(),false,false),'colspan' => array(array(),false,false),'dir' => array(array(),false,false),'headers' => array(array(),false,false),'height' => array(array(),false,false),'nowrap' => array(array(),false,false),'rowspan' => array(array(),false,false),'scope' => array(array(),false,false),'style' => array(array(),false,false),'valign' => array(array(),false,false),'width' => array(array(),false,false)),false,false),'textarea' => array(array('cols' => array(array(),false,false),'rows' => array(array(),false,false),'disabled' => array(array(),false,false),'name' => array(array(),false,false),'readonly' => array(array(),false,false)),false,false),'tfoot' => array(array('align' => array(array(),false,false),'char' => array(array(),false,false),'class' => array(array(),false,false),'charoff' => array(array(),false,false),'valign' => array(array(),false,false)),false,false),'th' => array(array('abbr' => array(array(),false,false),'align' => array(array(),false,false),'axis' => array(array(),false,false),'bgcolor' => array(array(),false,false),'char' => array(array(),false,false),'charoff' => array(array(),false,false),'class' => array(array(),false,false),'colspan' => array(array(),false,false),'headers' => array(array(),false,false),'height' => array(array(),false,false),'nowrap' => array(array(),false,false),'rowspan' => array(array(),false,false),'scope' => array(array(),false,false),'valign' => array(array(),false,false),'width' => array(array(),false,false)),false,false),'thead' => array(array('align' => array(array(),false,false),'char' => array(array(),false,false),'charoff' => array(array(),false,false),'class' => array(array(),false,false),'valign' => array(array(),false,false)),false,false),'title' => array(array(),false,false),'tr' => array(array('align' => array(array(),false,false),'bgcolor' => array(array(),false,false),'char' => array(array(),false,false),'charoff' => array(array(),false,false),'class' => array(array(),false,false),'style' => array(array(),false,false),'valign' => array(array(),false,false)),false,false),'tt' => array(array(),false,false),'u' => array(array(),false,false),'ul' => array(array('class' => array(array(),false,false),'style' => array(array(),false,false),'type' => array(array(),false,false)),false,false),'ol' => array(array('class' => array(array(),false,false),'start' => array(array(),false,false),'style' => array(array(),false,false),'type' => array(array(),false,false)),false,false),'var' => array(array(),false,false)),false);
$allowedtags = array(array('a' => array(array('href' => array(array(),false,false),'title' => array(array(),false,false)),false,false),'abbr' => array(array('title' => array(array(),false,false)),false,false),'acronym' => array(array('title' => array(array(),false,false)),false,false),'b' => array(array(),false,false),'blockquote' => array(array('cite' => array(array(),false,false)),false,false),'cite' => array(array(),false,false),'code' => array(array(),false,false),'del' => array(array('datetime' => array(array(),false,false)),false,false),'em' => array(array(),false,false),'i' => array(array(),false,false),'q' => array(array('cite' => array(array(),false,false)),false,false),'strike' => array(array(),false,false),'strong' => array(array(),false,false),),false);
}function wp_kses ( $string,$allowed_html,$allowed_protocols = array(array(array('http',false),array('https',false),array('ftp',false),array('ftps',false),array('mailto',false),array('news',false),array('irc',false),array('gopher',false),array('nntp',false),array('feed',false),array('telnet',false)),false) ) {
$string = wp_kses_no_null($string);
$string = wp_kses_js_entities($string);
$string = wp_kses_normalize_entities($string);
$allowed_html_fixed = wp_kses_array_lc($allowed_html);
$string = wp_kses_hook($string,$allowed_html_fixed,$allowed_protocols);
return wp_kses_split($string,$allowed_html_fixed,$allowed_protocols);
 }
function wp_kses_hook ( $string,$allowed_html,$allowed_protocols ) {
$string = apply_filters(array('pre_kses',false),$string,$allowed_html,$allowed_protocols);
return $string;
 }
function wp_kses_version (  ) {
return array('0.2.2',false);
 }
function wp_kses_split ( $string,$allowed_html,$allowed_protocols ) {
global $pass_allowed_html,$pass_allowed_protocols;
$pass_allowed_html = $allowed_html;
$pass_allowed_protocols = $allowed_protocols;
return Aspis_preg_replace_callback(array('%((<!--.*?(-->|$))|(<[^>]*(>|$)|>))%',false),Aspis_create_function(array('$match',false),array('global $pass_allowed_html, $pass_allowed_protocols; return wp_kses_split2($match[1], $pass_allowed_html, $pass_allowed_protocols);',false)),$string);
 }
function wp_kses_split2 ( $string,$allowed_html,$allowed_protocols ) {
$string = wp_kses_stripslashes($string);
if ( (deAspis(Aspis_substr($string,array(0,false),array(1,false))) != ('<')))
 return array('&gt;',false);
if ( deAspis(Aspis_preg_match(array('%^<!--(.*?)(-->)?$%',false),$string,$matches)))
 {$string = Aspis_str_replace(array(array(array('<!--',false),array('-->',false)),false),array('',false),attachAspis($matches,(1)));
while ( ($string[0] != deAspis($newstring = wp_kses($string,$allowed_html,$allowed_protocols))) )
$string = $newstring;
if ( ($string[0] == ('')))
 return array('',false);
$string = Aspis_preg_replace(array('/--+/',false),array('-',false),$string);
$string = Aspis_preg_replace(array('/-$/',false),array('',false),$string);
return concat2(concat1("<!--",$string),"-->");
}if ( (denot_boolean(Aspis_preg_match(array('%^<\s*(/\s*)?([a-zA-Z0-9]+)([^>]*)>?$%',false),$string,$matches))))
 return array('',false);
$slash = Aspis_trim(attachAspis($matches,(1)));
$elem = attachAspis($matches,(2));
$attrlist = attachAspis($matches,(3));
if ( (denot_boolean(@array((isset($allowed_html[0][deAspis(Aspis_strtolower($elem))]) && Aspis_isset( $allowed_html [0][deAspis(Aspis_strtolower( $elem))])),false))))
 return array('',false);
if ( ($slash[0] != ('')))
 return concat2(concat(concat1("<",$slash),$elem),">");
return wp_kses_attr(concat($slash,$elem),$attrlist,$allowed_html,$allowed_protocols);
 }
function wp_kses_attr ( $element,$attr,$allowed_html,$allowed_protocols ) {
$xhtml_slash = array('',false);
if ( deAspis(Aspis_preg_match(array('%\s/\s*$%',false),$attr)))
 $xhtml_slash = array(' /',false);
if ( (deAspis(@attAspis(count(deAspis(attachAspis($allowed_html,deAspis(Aspis_strtolower($element))))))) == (0)))
 return concat2(concat(concat1("<",$element),$xhtml_slash),">");
$attrarr = wp_kses_hair($attr,$allowed_protocols);
$attr2 = array('',false);
foreach ( $attrarr[0] as $arreach  )
{if ( (denot_boolean(@array((isset($allowed_html[0][deAspis(Aspis_strtolower($element))][0][deAspis(Aspis_strtolower($arreach[0]['name']))]) && Aspis_isset( $allowed_html [0][deAspis(Aspis_strtolower( $element))] [0][deAspis(Aspis_strtolower( $arreach [0]['name']))])),false))))
 continue ;
$current = attachAspis($allowed_html[0][deAspis(Aspis_strtolower($element))],deAspis(Aspis_strtolower($arreach[0]['name'])));
if ( ($current[0] == ('')))
 continue ;
if ( (!(is_array($current[0]))))
 $attr2 = concat($attr2,concat1(' ',$arreach[0]['whole']));
else 
{{$ok = array(true,false);
foreach ( $current[0] as $currkey =>$currval )
{restoreTaint($currkey,$currval);
if ( (denot_boolean(wp_kses_check_attr_val($arreach[0]['value'],$arreach[0]['vless'],$currkey,$currval))))
 {$ok = array(false,false);
break ;
}}if ( (deAspis($arreach[0]['name']) == ('style')))
 {$orig_value = $arreach[0]['value'];
$value = safecss_filter_attr($orig_value);
if ( ((empty($value) || Aspis_empty( $value))))
 continue ;
arrayAssign($arreach[0],deAspis(registerTaint(array('value',false))),addTaint($value));
arrayAssign($arreach[0],deAspis(registerTaint(array('whole',false))),addTaint(Aspis_str_replace($orig_value,$value,$arreach[0]['whole'])));
}if ( $ok[0])
 $attr2 = concat($attr2,concat1(' ',$arreach[0]['whole']));
}}}$attr2 = Aspis_preg_replace(array('/[<>]/',false),array('',false),$attr2);
return concat2(concat(concat(concat1("<",$element),$attr2),$xhtml_slash),">");
 }
function wp_kses_hair ( $attr,$allowed_protocols ) {
$attrarr = array(array(),false);
$mode = array(0,false);
$attrname = array('',false);
$uris = array(array(array('xmlns',false),array('profile',false),array('href',false),array('src',false),array('cite',false),array('classid',false),array('codebase',false),array('data',false),array('usemap',false),array('longdesc',false),array('action',false)),false);
while ( (strlen($attr[0]) != (0)) )
{$working = array(0,false);
switch ( $mode[0] ) {
case (0):if ( deAspis(Aspis_preg_match(array('/^([-a-zA-Z]+)/',false),$attr,$match)))
 {$attrname = attachAspis($match,(1));
$working = $mode = array(1,false);
$attr = Aspis_preg_replace(array('/^[-a-zA-Z]+/',false),array('',false),$attr);
}break ;
case (1):if ( deAspis(Aspis_preg_match(array('/^\s*=\s*/',false),$attr)))
 {$working = array(1,false);
$mode = array(2,false);
$attr = Aspis_preg_replace(array('/^\s*=\s*/',false),array('',false),$attr);
break ;
}if ( deAspis(Aspis_preg_match(array('/^\s+/',false),$attr)))
 {$working = array(1,false);
$mode = array(0,false);
if ( (FALSE === array_key_exists(deAspisRC($attrname),deAspisRC($attrarr))))
 {arrayAssign($attrarr[0],deAspis(registerTaint($attrname)),addTaint(array(array(deregisterTaint(array('name',false)) => addTaint($attrname),'value' => array('',false,false),deregisterTaint(array('whole',false)) => addTaint($attrname),'vless' => array('y',false,false)),false)));
}$attr = Aspis_preg_replace(array('/^\s+/',false),array('',false),$attr);
}break ;
case (2):if ( deAspis(Aspis_preg_match(array('/^"([^"]*)"(\s+|$)/',false),$attr,$match)))
 {$thisval = attachAspis($match,(1));
if ( deAspis(Aspis_in_array($attrname,$uris)))
 $thisval = wp_kses_bad_protocol($thisval,$allowed_protocols);
if ( (FALSE === array_key_exists(deAspisRC($attrname),deAspisRC($attrarr))))
 {arrayAssign($attrarr[0],deAspis(registerTaint($attrname)),addTaint(array(array(deregisterTaint(array('name',false)) => addTaint($attrname),deregisterTaint(array('value',false)) => addTaint($thisval),deregisterTaint(array('whole',false)) => addTaint(concat2(concat(concat2($attrname,"=\""),$thisval),"\"")),'vless' => array('n',false,false)),false)));
}$working = array(1,false);
$mode = array(0,false);
$attr = Aspis_preg_replace(array('/^"[^"]*"(\s+|$)/',false),array('',false),$attr);
break ;
}if ( deAspis(Aspis_preg_match(array("/^'([^']*)'(\s+|$)/",false),$attr,$match)))
 {$thisval = attachAspis($match,(1));
if ( deAspis(Aspis_in_array($attrname,$uris)))
 $thisval = wp_kses_bad_protocol($thisval,$allowed_protocols);
if ( (FALSE === array_key_exists(deAspisRC($attrname),deAspisRC($attrarr))))
 {arrayAssign($attrarr[0],deAspis(registerTaint($attrname)),addTaint(array(array(deregisterTaint(array('name',false)) => addTaint($attrname),deregisterTaint(array('value',false)) => addTaint($thisval),deregisterTaint(array('whole',false)) => addTaint(concat2(concat(concat2($attrname,"='"),$thisval),"'")),'vless' => array('n',false,false)),false)));
}$working = array(1,false);
$mode = array(0,false);
$attr = Aspis_preg_replace(array("/^'[^']*'(\s+|$)/",false),array('',false),$attr);
break ;
}if ( deAspis(Aspis_preg_match(array("%^([^\s\"']+)(\s+|$)%",false),$attr,$match)))
 {$thisval = attachAspis($match,(1));
if ( deAspis(Aspis_in_array($attrname,$uris)))
 $thisval = wp_kses_bad_protocol($thisval,$allowed_protocols);
if ( (FALSE === array_key_exists(deAspisRC($attrname),deAspisRC($attrarr))))
 {arrayAssign($attrarr[0],deAspis(registerTaint($attrname)),addTaint(array(array(deregisterTaint(array('name',false)) => addTaint($attrname),deregisterTaint(array('value',false)) => addTaint($thisval),deregisterTaint(array('whole',false)) => addTaint(concat2(concat(concat2($attrname,"=\""),$thisval),"\"")),'vless' => array('n',false,false)),false)));
}$working = array(1,false);
$mode = array(0,false);
$attr = Aspis_preg_replace(array("%^[^\s\"']+(\s+|$)%",false),array('',false),$attr);
}break ;
 }
if ( ($working[0] == (0)))
 {$attr = wp_kses_html_error($attr);
$mode = array(0,false);
}}if ( (($mode[0] == (1)) && (FALSE === array_key_exists(deAspisRC($attrname),deAspisRC($attrarr)))))
 arrayAssign($attrarr[0],deAspis(registerTaint($attrname)),addTaint(array(array(deregisterTaint(array('name',false)) => addTaint($attrname),'value' => array('',false,false),deregisterTaint(array('whole',false)) => addTaint($attrname),'vless' => array('y',false,false)),false)));
return $attrarr;
 }
function wp_kses_check_attr_val ( $value,$vless,$checkname,$checkvalue ) {
$ok = array(true,false);
switch ( deAspis(Aspis_strtolower($checkname)) ) {
case ('maxlen'):if ( (strlen($value[0]) > $checkvalue[0]))
 $ok = array(false,false);
break ;
case ('minlen'):if ( (strlen($value[0]) < $checkvalue[0]))
 $ok = array(false,false);
break ;
case ('maxval'):if ( (denot_boolean(Aspis_preg_match(array('/^\s{0,6}[0-9]{1,6}\s{0,6}$/',false),$value))))
 $ok = array(false,false);
if ( ($value[0] > $checkvalue[0]))
 $ok = array(false,false);
break ;
case ('minval'):if ( (denot_boolean(Aspis_preg_match(array('/^\s{0,6}[0-9]{1,6}\s{0,6}$/',false),$value))))
 $ok = array(false,false);
if ( ($value[0] < $checkvalue[0]))
 $ok = array(false,false);
break ;
case ('valueless'):if ( (deAspis(Aspis_strtolower($checkvalue)) != $vless[0]))
 $ok = array(false,false);
break ;
 }
return $ok;
 }
function wp_kses_bad_protocol ( $string,$allowed_protocols ) {
$string = wp_kses_no_null($string);
$string2 = concat2($string,'a');
while ( ($string[0] != $string2[0]) )
{$string2 = $string;
$string = wp_kses_bad_protocol_once($string,$allowed_protocols);
}return $string;
 }
function wp_kses_no_null ( $string ) {
$string = Aspis_preg_replace(array('/\0+/',false),array('',false),$string);
$string = Aspis_preg_replace(array('/(\\\\0)+/',false),array('',false),$string);
return $string;
 }
function wp_kses_stripslashes ( $string ) {
return Aspis_preg_replace(array('%\\\\"%',false),array('"',false),$string);
 }
function wp_kses_array_lc ( $inarray ) {
$outarray = array(array(),false);
foreach ( deAspis(array_cast($inarray)) as $inkey =>$inval )
{restoreTaint($inkey,$inval);
{$outkey = Aspis_strtolower($inkey);
arrayAssign($outarray[0],deAspis(registerTaint($outkey)),addTaint(array(array(),false)));
foreach ( deAspis(array_cast($inval)) as $inkey2 =>$inval2 )
{restoreTaint($inkey2,$inval2);
{$outkey2 = Aspis_strtolower($inkey2);
arrayAssign($outarray[0][$outkey[0]][0],deAspis(registerTaint($outkey2)),addTaint($inval2));
}}}}return $outarray;
 }
function wp_kses_js_entities ( $string ) {
return Aspis_preg_replace(array('%&\s*\{[^}]*(\}\s*;?|$)%',false),array('',false),$string);
 }
function wp_kses_html_error ( $string ) {
return Aspis_preg_replace(array('/^("[^"]*("|$)|\'[^\']*(\'|$)|\S)*\s*/',false),array('',false),$string);
 }
function wp_kses_bad_protocol_once ( $string,$allowed_protocols ) {
global $_kses_allowed_protocols;
$_kses_allowed_protocols = $allowed_protocols;
$string2 = Aspis_preg_split(array('/:|&#58;|&#x3a;/i',false),$string,array(2,false));
if ( (((isset($string2[0][(1)]) && Aspis_isset( $string2 [0][(1)]))) && (denot_boolean(Aspis_preg_match(array('%/\?%',false),attachAspis($string2,(0)))))))
 $string = concat(wp_kses_bad_protocol_once2(attachAspis($string2,(0))),Aspis_trim(attachAspis($string2,(1))));
else 
{$string = Aspis_preg_replace_callback(concat12('/^((&[^;]*;|[\sA-Za-z0-9])*)','(:|&#58;|&#[Xx]3[Aa];)\s*/'),array('wp_kses_bad_protocol_once2',false),$string);
}return $string;
 }
function wp_kses_bad_protocol_once2 ( $matches ) {
global $_kses_allowed_protocols;
if ( is_array($matches[0]))
 {if ( ((!((isset($matches[0][(1)]) && Aspis_isset( $matches [0][(1)])))) || ((empty($matches[0][(1)]) || Aspis_empty( $matches [0][(1)])))))
 return array('',false);
$string = attachAspis($matches,(1));
}else 
{{$string = $matches;
}}$string2 = wp_kses_decode_entities($string);
$string2 = Aspis_preg_replace(array('/\s/',false),array('',false),$string2);
$string2 = wp_kses_no_null($string2);
$string2 = Aspis_strtolower($string2);
$allowed = array(false,false);
foreach ( deAspis(array_cast($_kses_allowed_protocols)) as $one_protocol  )
if ( (deAspis(Aspis_strtolower($one_protocol)) == $string2[0]))
 {$allowed = array(true,false);
break ;
}if ( $allowed[0])
 return concat2($string2,":");
else 
{return array('',false);
} }
function wp_kses_normalize_entities ( $string ) {
$string = Aspis_str_replace(array('&',false),array('&amp;',false),$string);
$string = Aspis_preg_replace(array('/&amp;([A-Za-z][A-Za-z0-9]{0,19});/',false),array('&\\1;',false),$string);
$string = Aspis_preg_replace_callback(array('/&amp;#0*([0-9]{1,5});/',false),array('wp_kses_normalize_entities2',false),$string);
$string = Aspis_preg_replace_callback(array('/&amp;#([Xx])0*(([0-9A-Fa-f]{2}){1,2});/',false),array('wp_kses_normalize_entities3',false),$string);
return $string;
 }
function wp_kses_normalize_entities2 ( $matches ) {
if ( ((!((isset($matches[0][(1)]) && Aspis_isset( $matches [0][(1)])))) || ((empty($matches[0][(1)]) || Aspis_empty( $matches [0][(1)])))))
 return array('',false);
$i = attachAspis($matches,(1));
return (((denot_boolean(valid_unicode($i))) || ($i[0] > (65535))) ? concat2(concat1("&amp;#",$i),";") : concat2(concat1("&#",$i),";"));
 }
function wp_kses_normalize_entities3 ( $matches ) {
if ( ((!((isset($matches[0][(2)]) && Aspis_isset( $matches [0][(2)])))) || ((empty($matches[0][(2)]) || Aspis_empty( $matches [0][(2)])))))
 return array('',false);
$hexchars = attachAspis($matches,(2));
return ((denot_boolean(valid_unicode(Aspis_hexdec($hexchars)))) ? concat2(concat1("&amp;#x",$hexchars),";") : concat2(concat1("&#x",$hexchars),";"));
 }
function valid_unicode ( $i ) {
return (array(((((($i[0] == (0x9)) || ($i[0] == (0xa))) || ($i[0] == (0xd))) || (($i[0] >= (0x20)) && ($i[0] <= (0xd7ff)))) || (($i[0] >= (0xe000)) && ($i[0] <= (0xfffd)))) || (($i[0] >= (0x10000)) && ($i[0] <= (0x10ffff))),false));
 }
function wp_kses_decode_entities ( $string ) {
$string = Aspis_preg_replace_callback(array('/&#([0-9]+);/',false),array('_wp_kses_decode_entities_chr',false),$string);
$string = Aspis_preg_replace_callback(array('/&#[Xx]([0-9A-Fa-f]+);/',false),array('_wp_kses_decode_entities_chr_hexdec',false),$string);
return $string;
 }
function _wp_kses_decode_entities_chr ( $match ) {
return attAspis(chr(deAspis(attachAspis($match,(1)))));
 }
function _wp_kses_decode_entities_chr_hexdec ( $match ) {
return attAspis(chr(deAspis(Aspis_hexdec(attachAspis($match,(1))))));
 }
function wp_filter_kses ( $data ) {
global $allowedtags;
return Aspis_addslashes(wp_kses(Aspis_stripslashes($data),$allowedtags));
 }
function wp_kses_data ( $data ) {
global $allowedtags;
return wp_kses($data,$allowedtags);
 }
function wp_filter_post_kses ( $data ) {
global $allowedposttags;
return Aspis_addslashes(wp_kses(Aspis_stripslashes($data),$allowedposttags));
 }
function wp_kses_post ( $data ) {
global $allowedposttags;
return wp_kses($data,$allowedposttags);
 }
function wp_filter_nohtml_kses ( $data ) {
return Aspis_addslashes(wp_kses(Aspis_stripslashes($data),array(array(),false)));
 }
function kses_init_filters (  ) {
add_filter(array('pre_comment_content',false),array('wp_filter_kses',false));
add_filter(array('title_save_pre',false),array('wp_filter_kses',false));
add_filter(array('content_save_pre',false),array('wp_filter_post_kses',false));
add_filter(array('excerpt_save_pre',false),array('wp_filter_post_kses',false));
add_filter(array('content_filtered_save_pre',false),array('wp_filter_post_kses',false));
 }
function kses_remove_filters (  ) {
remove_filter(array('pre_comment_content',false),array('wp_filter_kses',false));
remove_filter(array('title_save_pre',false),array('wp_filter_kses',false));
remove_filter(array('content_save_pre',false),array('wp_filter_post_kses',false));
remove_filter(array('excerpt_save_pre',false),array('wp_filter_post_kses',false));
remove_filter(array('content_filtered_save_pre',false),array('wp_filter_post_kses',false));
 }
function kses_init (  ) {
kses_remove_filters();
if ( (deAspis(current_user_can(array('unfiltered_html',false))) == false))
 kses_init_filters();
 }
add_action(array('init',false),array('kses_init',false));
add_action(array('set_current_user',false),array('kses_init',false));
function safecss_filter_attr ( $css,$deprecated = array('',false) ) {
$css = wp_kses_no_null($css);
$css = Aspis_str_replace(array(array(array("\n",false),array("\r",false),array("\t",false)),false),array('',false),$css);
if ( deAspis(Aspis_preg_match(array('%[\\(&]|/\*%',false),$css)))
 return array('',false);
$css_array = Aspis_split(array(';',false),Aspis_trim($css));
$allowed_attr = apply_filters(array('safe_style_css',false),array(array(array('text-align',false),array('margin',false),array('color',false),array('float',false),array('border',false),array('background',false),array('background-color',false),array('border-bottom',false),array('border-bottom-color',false),array('border-bottom-style',false),array('border-bottom-width',false),array('border-collapse',false),array('border-color',false),array('border-left',false),array('border-left-color',false),array('border-left-style',false),array('border-left-width',false),array('border-right',false),array('border-right-color',false),array('border-right-style',false),array('border-right-width',false),array('border-spacing',false),array('border-style',false),array('border-top',false),array('border-top-color',false),array('border-top-style',false),array('border-top-width',false),array('border-width',false),array('caption-side',false),array('clear',false),array('cursor',false),array('direction',false),array('font',false),array('font-family',false),array('font-size',false),array('font-style',false),array('font-variant',false),array('font-weight',false),array('height',false),array('letter-spacing',false),array('line-height',false),array('margin-bottom',false),array('margin-left',false),array('margin-right',false),array('margin-top',false),array('overflow',false),array('padding',false),array('padding-bottom',false),array('padding-left',false),array('padding-right',false),array('padding-top',false),array('text-decoration',false),array('text-indent',false),array('vertical-align',false),array('width',false)),false));
if ( ((empty($allowed_attr) || Aspis_empty( $allowed_attr))))
 return $css;
$css = array('',false);
foreach ( $css_array[0] as $css_item  )
{if ( ($css_item[0] == ('')))
 continue ;
$css_item = Aspis_trim($css_item);
$found = array(false,false);
if ( (strpos($css_item[0],':') === false))
 {$found = array(true,false);
}else 
{{$parts = Aspis_split(array(':',false),$css_item);
if ( deAspis(Aspis_in_array(Aspis_trim(attachAspis($parts,(0))),$allowed_attr)))
 $found = array(true,false);
}}if ( $found[0])
 {if ( ($css[0] != ('')))
 $css = concat2($css,';');
$css = concat($css,$css_item);
}}return $css;
 }
