<?php require_once('AspisMain.php'); ?><?php
function get_locale (  ) {
{global $locale;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $locale,"\$locale",$AspisChangesCache);
}if ( isset($locale))
 {$AspisRetTemp = apply_filters('locale',$locale);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$locale",$AspisChangesCache);
return $AspisRetTemp;
}if ( defined('WPLANG'))
 $locale = WPLANG;
if ( empty($locale))
 $locale = 'en_US';
{$AspisRetTemp = apply_filters('locale',$locale);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$locale",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$locale",$AspisChangesCache);
 }
function translate ( $text,$domain = 'default' ) {
$translations = &get_translations_for_domain($domain);
{$AspisRetTemp = apply_filters('gettext',$translations->translate($text),$text,$domain);
return $AspisRetTemp;
} }
function before_last_bar ( $string ) {
$last_bar = strrpos($string,'|');
if ( false == $last_bar)
 {$AspisRetTemp = $string;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = substr($string,0,$last_bar);
return $AspisRetTemp;
}} }
function translate_with_context ( $text,$domain = 'default' ) {
{$AspisRetTemp = before_last_bar(translate($text,$domain));
return $AspisRetTemp;
} }
function translate_with_gettext_context ( $text,$context,$domain = 'default' ) {
$translations = &get_translations_for_domain($domain);
{$AspisRetTemp = apply_filters('gettext_with_context',$translations->translate($text,$context),$text,$context,$domain);
return $AspisRetTemp;
} }
function __ ( $text,$domain = 'default' ) {
{$AspisRetTemp = translate($text,$domain);
return $AspisRetTemp;
} }
function esc_attr__ ( $text,$domain = 'default' ) {
{$AspisRetTemp = esc_attr(translate($text,$domain));
return $AspisRetTemp;
} }
function esc_html__ ( $text,$domain = 'default' ) {
{$AspisRetTemp = esc_html(translate($text,$domain));
return $AspisRetTemp;
} }
function _e ( $text,$domain = 'default' ) {
echo translate($text,$domain);
 }
function esc_attr_e ( $text,$domain = 'default' ) {
echo esc_attr(translate($text,$domain));
 }
function esc_html_e ( $text,$domain = 'default' ) {
echo esc_html(translate($text,$domain));
 }
function _x ( $single,$context,$domain = 'default' ) {
{$AspisRetTemp = translate_with_gettext_context($single,$context,$domain);
return $AspisRetTemp;
} }
function esc_attr_x ( $single,$context,$domain = 'default' ) {
{$AspisRetTemp = esc_attr(translate_with_gettext_context($single,$context,$domain));
return $AspisRetTemp;
} }
function esc_html_x ( $single,$context,$domain = 'default' ) {
{$AspisRetTemp = esc_html(translate_with_gettext_context($single,$context,$domain));
return $AspisRetTemp;
} }
function __ngettext (  ) {
_deprecated_function(__FUNCTION__,'2.8','_n()');
$args = func_get_args();
{$AspisRetTemp = AspisUntainted_call_user_func_array('_n',$args);
return $AspisRetTemp;
} }
function _n ( $single,$plural,$number,$domain = 'default' ) {
$translations = &get_translations_for_domain($domain);
$translation = $translations->translate_plural($single,$plural,$number);
{$AspisRetTemp = apply_filters('ngettext',$translation,$single,$plural,$number,$domain);
return $AspisRetTemp;
} }
function _nc ( $single,$plural,$number,$domain = 'default' ) {
{$AspisRetTemp = before_last_bar(_n($single,$plural,$number,$domain));
return $AspisRetTemp;
} }
function _nx ( $single,$plural,$number,$context,$domain = 'default' ) {
$translations = &get_translations_for_domain($domain);
$translation = $translations->translate_plural($single,$plural,$number,$context);
{$AspisRetTemp = apply_filters('ngettext_with_context',$translation,$single,$plural,$number,$context,$domain);
return $AspisRetTemp;
} }
function __ngettext_noop (  ) {
_deprecated_function(__FUNCTION__,'2.8','_n_noop()');
$args = func_get_args();
{$AspisRetTemp = AspisUntainted_call_user_func_array('_n_noop',$args);
return $AspisRetTemp;
} }
function _n_noop ( $single,$plural ) {
{$AspisRetTemp = array($single,$plural);
return $AspisRetTemp;
} }
function _nx_noop ( $single,$plural,$context ) {
{$AspisRetTemp = array($single,$plural,$context);
return $AspisRetTemp;
} }
function load_textdomain ( $domain,$mofile ) {
{global $l10n;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $l10n,"\$l10n",$AspisChangesCache);
}$plugin_override = apply_filters('override_load_textdomain',false,$domain,$mofile);
if ( true == $plugin_override)
 {{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$l10n",$AspisChangesCache);
return $AspisRetTemp;
}}do_action('load_textdomain',$domain,$mofile);
$mofile = apply_filters('load_textdomain_mofile',$mofile,$domain);
if ( !is_readable($mofile))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$l10n",$AspisChangesCache);
return $AspisRetTemp;
}$mo = new MO();
if ( !$mo->import_from_file($mofile))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$l10n",$AspisChangesCache);
return $AspisRetTemp;
}if ( isset($l10n[$domain]))
 AspisReferenceMethodCall($mo,"merge_with",array(AspisPushRefParam($l10n[$domain])),array(0));
$l10n[$domain] = &$mo;
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$l10n",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$l10n",$AspisChangesCache);
 }
function load_default_textdomain (  ) {
$locale = get_locale();
$mofile = WP_LANG_DIR . "/$locale.mo";
{$AspisRetTemp = load_textdomain('default',$mofile);
return $AspisRetTemp;
} }
function load_plugin_textdomain ( $domain,$abs_rel_path = false,$plugin_rel_path = false ) {
$locale = get_locale();
if ( false !== $plugin_rel_path)
 $path = WP_PLUGIN_DIR . '/' . trim($plugin_rel_path,'/');
else 
{if ( false !== $abs_rel_path)
 $path = ABSPATH . trim($abs_rel_path,'/');
else 
{$path = WP_PLUGIN_DIR;
}}$mofile = $path . '/' . $domain . '-' . $locale . '.mo';
{$AspisRetTemp = load_textdomain($domain,$mofile);
return $AspisRetTemp;
} }
function load_theme_textdomain ( $domain,$path = false ) {
$locale = get_locale();
$path = (empty($path)) ? get_template_directory() : $path;
$mofile = "$path/$locale.mo";
{$AspisRetTemp = load_textdomain($domain,$mofile);
return $AspisRetTemp;
} }
function load_child_theme_textdomain ( $domain,$path = false ) {
$locale = get_locale();
$path = (empty($path)) ? get_stylesheet_directory() : $path;
$mofile = "$path/$locale.mo";
{$AspisRetTemp = load_textdomain($domain,$mofile);
return $AspisRetTemp;
} }
function &get_translations_for_domain ( $domain ) {
{global $l10n;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $l10n,"\$l10n",$AspisChangesCache);
}if ( !isset($l10n[$domain]))
 {$l10n[$domain] = &new NOOP_Translations;
}{$AspisRetTemp = &$l10n[$domain];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$l10n",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$l10n",$AspisChangesCache);
 }
function translate_user_role ( $name ) {
{$AspisRetTemp = translate_with_gettext_context(before_last_bar($name),'User role');
return $AspisRetTemp;
} }
;
?>
<?php 