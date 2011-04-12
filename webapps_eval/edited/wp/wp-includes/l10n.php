<?php require_once('AspisMain.php'); ?><?php
function get_locale (  ) {
global $locale;
if ( ((isset($locale) && Aspis_isset( $locale))))
 return apply_filters(array('locale',false),$locale);
if ( defined(('WPLANG')))
 $locale = array(WPLANG,false);
if ( ((empty($locale) || Aspis_empty( $locale))))
 $locale = array('en_US',false);
return apply_filters(array('locale',false),$locale);
 }
function translate ( $text,$domain = array('default',false) ) {
$translations = &get_translations_for_domain($domain);
return apply_filters(array('gettext',false),$translations[0]->translate($text),$text,$domain);
 }
function before_last_bar ( $string ) {
$last_bar = attAspis(strrpos($string[0],('|')));
if ( (false == $last_bar[0]))
 return $string;
else 
{return Aspis_substr($string,array(0,false),$last_bar);
} }
function translate_with_context ( $text,$domain = array('default',false) ) {
return before_last_bar(translate($text,$domain));
 }
function translate_with_gettext_context ( $text,$context,$domain = array('default',false) ) {
$translations = &get_translations_for_domain($domain);
return apply_filters(array('gettext_with_context',false),$translations[0]->translate($text,$context),$text,$context,$domain);
 }
function __ ( $text,$domain = array('default',false) ) {
return translate($text,$domain);
 }
function esc_attr__ ( $text,$domain = array('default',false) ) {
return esc_attr(translate($text,$domain));
 }
function esc_html__ ( $text,$domain = array('default',false) ) {
return esc_html(translate($text,$domain));
 }
function _e ( $text,$domain = array('default',false) ) {
echo AspisCheckPrint(translate($text,$domain));
 }
function esc_attr_e ( $text,$domain = array('default',false) ) {
echo AspisCheckPrint(esc_attr(translate($text,$domain)));
 }
function esc_html_e ( $text,$domain = array('default',false) ) {
echo AspisCheckPrint(esc_html(translate($text,$domain)));
 }
function _x ( $single,$context,$domain = array('default',false) ) {
return translate_with_gettext_context($single,$context,$domain);
 }
function esc_attr_x ( $single,$context,$domain = array('default',false) ) {
return esc_attr(translate_with_gettext_context($single,$context,$domain));
 }
function esc_html_x ( $single,$context,$domain = array('default',false) ) {
return esc_html(translate_with_gettext_context($single,$context,$domain));
 }
function __ngettext (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('_n()',false));
$args = array(func_get_args(),false);
return Aspis_call_user_func_array(array('_n',false),$args);
 }
function _n ( $single,$plural,$number,$domain = array('default',false) ) {
$translations = &get_translations_for_domain($domain);
$translation = $translations[0]->translate_plural($single,$plural,$number);
return apply_filters(array('ngettext',false),$translation,$single,$plural,$number,$domain);
 }
function _nc ( $single,$plural,$number,$domain = array('default',false) ) {
return before_last_bar(_n($single,$plural,$number,$domain));
 }
function _nx ( $single,$plural,$number,$context,$domain = array('default',false) ) {
$translations = &get_translations_for_domain($domain);
$translation = $translations[0]->translate_plural($single,$plural,$number,$context);
return apply_filters(array('ngettext_with_context',false),$translation,$single,$plural,$number,$context,$domain);
 }
function __ngettext_noop (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('_n_noop()',false));
$args = array(func_get_args(),false);
return Aspis_call_user_func_array(array('_n_noop',false),$args);
 }
function _n_noop ( $single,$plural ) {
return array(array($single,$plural),false);
 }
function _nx_noop ( $single,$plural,$context ) {
return array(array($single,$plural,$context),false);
 }
function load_textdomain ( $domain,$mofile ) {
global $l10n;
$plugin_override = apply_filters(array('override_load_textdomain',false),array(false,false),$domain,$mofile);
if ( (true == $plugin_override[0]))
 {return array(true,false);
}do_action(array('load_textdomain',false),$domain,$mofile);
$mofile = apply_filters(array('load_textdomain_mofile',false),$mofile,$domain);
if ( (!(is_readable($mofile[0]))))
 return array(false,false);
$mo = array(new MO(),false);
if ( (denot_boolean($mo[0]->import_from_file($mofile))))
 return array(false,false);
if ( ((isset($l10n[0][$domain[0]]) && Aspis_isset( $l10n [0][$domain[0]]))))
 $mo[0]->merge_with(attachAspis($l10n,$domain[0]));
$l10n[0][deAspis(registerTaint($domain))] = &addTaintR($mo);
return array(true,false);
 }
function load_default_textdomain (  ) {
$locale = get_locale();
$mofile = concat1(WP_LANG_DIR,concat2(concat1("/",$locale),".mo"));
return load_textdomain(array('default',false),$mofile);
 }
function load_plugin_textdomain ( $domain,$abs_rel_path = array(false,false),$plugin_rel_path = array(false,false) ) {
$locale = get_locale();
if ( (false !== $plugin_rel_path[0]))
 $path = concat(concat12(WP_PLUGIN_DIR,'/'),Aspis_trim($plugin_rel_path,array('/',false)));
else 
{if ( (false !== $abs_rel_path[0]))
 $path = concat1(ABSPATH,Aspis_trim($abs_rel_path,array('/',false)));
else 
{$path = array(WP_PLUGIN_DIR,false);
}}$mofile = concat2(concat(concat2(concat(concat2($path,'/'),$domain),'-'),$locale),'.mo');
return load_textdomain($domain,$mofile);
 }
function load_theme_textdomain ( $domain,$path = array(false,false) ) {
$locale = get_locale();
$path = ((empty($path) || Aspis_empty( $path))) ? get_template_directory() : $path;
$mofile = concat2(concat(concat2($path,"/"),$locale),".mo");
return load_textdomain($domain,$mofile);
 }
function load_child_theme_textdomain ( $domain,$path = array(false,false) ) {
$locale = get_locale();
$path = ((empty($path) || Aspis_empty( $path))) ? get_stylesheet_directory() : $path;
$mofile = concat2(concat(concat2($path,"/"),$locale),".mo");
return load_textdomain($domain,$mofile);
 }
function &get_translations_for_domain ( $domain ) {
global $l10n;
if ( (!((isset($l10n[0][$domain[0]]) && Aspis_isset( $l10n [0][$domain[0]])))))
 {arrayAssign($l10n[0],deAspis(registerTaint($domain)),addTaint(array(new NOOP_Translations,false)));
}return attachAspis($l10n,$domain[0]);
 }
function translate_user_role ( $name ) {
return translate_with_gettext_context(before_last_bar($name),array('User role',false));
 }
;
?>
<?php 