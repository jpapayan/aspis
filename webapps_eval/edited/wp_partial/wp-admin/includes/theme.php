<?php require_once('AspisMain.php'); ?><?php
function current_theme_info (  ) {
$themes = get_themes();
$current_theme = get_current_theme();
$ct->name = $current_theme;
$ct->title = $themes[$current_theme]['Title'];
$ct->version = $themes[$current_theme]['Version'];
$ct->parent_theme = $themes[$current_theme]['Parent Theme'];
$ct->template_dir = $themes[$current_theme]['Template Dir'];
$ct->stylesheet_dir = $themes[$current_theme]['Stylesheet Dir'];
$ct->template = $themes[$current_theme]['Template'];
$ct->stylesheet = $themes[$current_theme]['Stylesheet'];
$ct->screenshot = $themes[$current_theme]['Screenshot'];
$ct->description = $themes[$current_theme]['Description'];
$ct->author = $themes[$current_theme]['Author'];
$ct->tags = $themes[$current_theme]['Tags'];
$ct->theme_root = $themes[$current_theme]['Theme Root'];
$ct->theme_root_uri = $themes[$current_theme]['Theme Root URI'];
{$AspisRetTemp = $ct;
return $AspisRetTemp;
} }
function delete_theme ( $template ) {
{global $wp_filesystem;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
}if ( empty($template))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}ob_start();
$url = wp_nonce_url('themes.php?action=delete&template=' . $template,'delete-theme_' . $template);
if ( false === ($credentials = request_filesystem_credentials($url)))
 {$data = ob_get_contents();
ob_end_clean();
if ( !empty($data))
 {include_once (ABSPATH . 'wp-admin/admin-header.php');
echo $data;
include (ABSPATH . 'wp-admin/admin-footer.php');
exit();
}{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return ;
}}if ( !WP_Filesystem($credentials))
 {request_filesystem_credentials($url,'',true);
$data = ob_get_contents();
ob_end_clean();
if ( !empty($data))
 {include_once (ABSPATH . 'wp-admin/admin-header.php');
echo $data;
include (ABSPATH . 'wp-admin/admin-footer.php');
exit();
}{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return ;
}}if ( !is_object($wp_filesystem))
 {$AspisRetTemp = new WP_Error('fs_unavailable',__('Could not access filesystem.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}if ( is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->get_error_code())
 {$AspisRetTemp = new WP_Error('fs_error',__('Filesystem error'),$wp_filesystem->errors);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$themes_dir = $wp_filesystem->wp_themes_dir();
if ( empty($themes_dir))
 {$AspisRetTemp = new WP_Error('fs_no_themes_dir',__('Unable to locate WordPress theme directory.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}$themes_dir = trailingslashit($themes_dir);
$errors = array();
$theme_dir = trailingslashit($themes_dir . $template);
$deleted = $wp_filesystem->delete($theme_dir,true);
if ( !$deleted)
 {$AspisRetTemp = new WP_Error('could_not_remove_theme',sprintf(__('Could not fully remove the theme %s'),$template));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}delete_transient('update_themes');
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
 }
function get_broken_themes (  ) {
{global $wp_broken_themes;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_broken_themes,"\$wp_broken_themes",$AspisChangesCache);
}get_themes();
{$AspisRetTemp = $wp_broken_themes;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_broken_themes",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_broken_themes",$AspisChangesCache);
 }
function get_page_templates (  ) {
$themes = get_themes();
$theme = get_current_theme();
$templates = $themes[$theme]['Template Files'];
$page_templates = array();
if ( is_array($templates))
 {$base = array(trailingslashit(get_template_directory()),trailingslashit(get_stylesheet_directory()));
foreach ( $templates as $template  )
{$basename = str_replace($base,'',$template);
if ( false !== strpos($basename,'/'))
 continue ;
$template_data = implode('',file($template));
$name = '';
if ( preg_match('|Template Name:(.*)$|mi',$template_data,$name))
 $name = _cleanup_header_comment($name[1]);
if ( !empty($name))
 {$page_templates[trim($name)] = $basename;
}}}{$AspisRetTemp = $page_templates;
return $AspisRetTemp;
} }
function _get_template_edit_filename ( $fullpath,$containingfolder ) {
{$AspisRetTemp = str_replace(dirname(dirname($containingfolder)),'',$fullpath);
return $AspisRetTemp;
} }
;
?>
<?php 