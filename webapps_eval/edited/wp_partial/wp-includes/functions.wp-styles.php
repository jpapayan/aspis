<?php require_once('AspisMain.php'); ?><?php
function wp_print_styles ( $handles = false ) {
do_action('wp_print_styles');
if ( '' === $handles)
 $handles = false;
{global $wp_styles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_styles,"\$wp_styles",$AspisChangesCache);
}if ( !is_a($wp_styles,'WP_Styles'))
 {if ( !$handles)
 {$AspisRetTemp = array();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
return $AspisRetTemp;
}else 
{$wp_styles = new WP_Styles();
}}{$AspisRetTemp = $wp_styles->do_items($handles);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
 }
function wp_register_style ( $handle,$src,$deps = array(),$ver = false,$media = 'all' ) {
{global $wp_styles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_styles,"\$wp_styles",$AspisChangesCache);
}if ( !is_a($wp_styles,'WP_Styles'))
 $wp_styles = new WP_Styles();
$wp_styles->add($handle,$src,$deps,$ver,$media);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
 }
function wp_deregister_style ( $handle ) {
{global $wp_styles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_styles,"\$wp_styles",$AspisChangesCache);
}if ( !is_a($wp_styles,'WP_Styles'))
 $wp_styles = new WP_Styles();
$wp_styles->remove($handle);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
 }
function wp_enqueue_style ( $handle,$src = false,$deps = array(),$ver = false,$media = false ) {
{global $wp_styles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_styles,"\$wp_styles",$AspisChangesCache);
}if ( !is_a($wp_styles,'WP_Styles'))
 $wp_styles = new WP_Styles();
if ( $src)
 {$_handle = explode('?',$handle);
$wp_styles->add($_handle[0],$src,$deps,$ver,$media);
}$wp_styles->enqueue($handle);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
 }
function wp_style_is ( $handle,$list = 'queue' ) {
{global $wp_styles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_styles,"\$wp_styles",$AspisChangesCache);
}if ( !is_a($wp_styles,'WP_Styles'))
 $wp_styles = new WP_Styles();
$query = $wp_styles->query($handle,$list);
if ( is_object($query))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $query;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
 }
