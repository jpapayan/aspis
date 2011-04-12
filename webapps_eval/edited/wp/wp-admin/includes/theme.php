<?php require_once('AspisMain.php'); ?><?php
function current_theme_info (  ) {
$themes = get_themes();
$current_theme = get_current_theme();
$ct[0]->name = $current_theme;
$ct[0]->title = $themes[0][$current_theme[0]][0]['Title'];
$ct[0]->version = $themes[0][$current_theme[0]][0]['Version'];
$ct[0]->parent_theme = $themes[0][$current_theme[0]][0]['Parent Theme'];
$ct[0]->template_dir = $themes[0][$current_theme[0]][0]['Template Dir'];
$ct[0]->stylesheet_dir = $themes[0][$current_theme[0]][0]['Stylesheet Dir'];
$ct[0]->template = $themes[0][$current_theme[0]][0]['Template'];
$ct[0]->stylesheet = $themes[0][$current_theme[0]][0]['Stylesheet'];
$ct[0]->screenshot = $themes[0][$current_theme[0]][0]['Screenshot'];
$ct[0]->description = $themes[0][$current_theme[0]][0]['Description'];
$ct[0]->author = $themes[0][$current_theme[0]][0]['Author'];
$ct[0]->tags = $themes[0][$current_theme[0]][0]['Tags'];
$ct[0]->theme_root = $themes[0][$current_theme[0]][0]['Theme Root'];
$ct[0]->theme_root_uri = $themes[0][$current_theme[0]][0]['Theme Root URI'];
return $ct;
 }
function delete_theme ( $template ) {
global $wp_filesystem;
if ( ((empty($template) || Aspis_empty( $template))))
 return array(false,false);
ob_start();
$url = wp_nonce_url(concat1('themes.php?action=delete&template=',$template),concat1('delete-theme_',$template));
if ( (false === deAspis(($credentials = request_filesystem_credentials($url)))))
 {$data = attAspis(ob_get_contents());
ob_end_clean();
if ( (!((empty($data) || Aspis_empty( $data)))))
 {include_once (deconcat12(ABSPATH,'wp-admin/admin-header.php'));
echo AspisCheckPrint($data);
include (deconcat12(ABSPATH,'wp-admin/admin-footer.php'));
Aspis_exit();
}return ;
}if ( (denot_boolean(WP_Filesystem($credentials))))
 {request_filesystem_credentials($url,array('',false),array(true,false));
$data = attAspis(ob_get_contents());
ob_end_clean();
if ( (!((empty($data) || Aspis_empty( $data)))))
 {include_once (deconcat12(ABSPATH,'wp-admin/admin-header.php'));
echo AspisCheckPrint($data);
include (deconcat12(ABSPATH,'wp-admin/admin-footer.php'));
Aspis_exit();
}return ;
}if ( (!(is_object($wp_filesystem[0]))))
 return array(new WP_Error(array('fs_unavailable',false),__(array('Could not access filesystem.',false))),false);
if ( (deAspis(is_wp_error($wp_filesystem[0]->errors)) && deAspis($wp_filesystem[0]->errors[0]->get_error_code())))
 return array(new WP_Error(array('fs_error',false),__(array('Filesystem error',false)),$wp_filesystem[0]->errors),false);
$themes_dir = $wp_filesystem[0]->wp_themes_dir();
if ( ((empty($themes_dir) || Aspis_empty( $themes_dir))))
 return array(new WP_Error(array('fs_no_themes_dir',false),__(array('Unable to locate WordPress theme directory.',false))),false);
$themes_dir = trailingslashit($themes_dir);
$errors = array(array(),false);
$theme_dir = trailingslashit(concat($themes_dir,$template));
$deleted = $wp_filesystem[0]->delete($theme_dir,array(true,false));
if ( (denot_boolean($deleted)))
 return array(new WP_Error(array('could_not_remove_theme',false),Aspis_sprintf(__(array('Could not fully remove the theme %s',false)),$template)),false);
delete_transient(array('update_themes',false));
return array(true,false);
 }
function get_broken_themes (  ) {
global $wp_broken_themes;
get_themes();
return $wp_broken_themes;
 }
function get_page_templates (  ) {
$themes = get_themes();
$theme = get_current_theme();
$templates = $themes[0][$theme[0]][0]['Template Files'];
$page_templates = array(array(),false);
if ( is_array($templates[0]))
 {$base = array(array(trailingslashit(get_template_directory()),trailingslashit(get_stylesheet_directory())),false);
foreach ( $templates[0] as $template  )
{$basename = Aspis_str_replace($base,array('',false),$template);
if ( (false !== strpos($basename[0],'/')))
 continue ;
$template_data = Aspis_implode(array('',false),Aspis_file($template));
$name = array('',false);
if ( deAspis(Aspis_preg_match(array('|Template Name:(.*)$|mi',false),$template_data,$name)))
 $name = _cleanup_header_comment(attachAspis($name,(1)));
if ( (!((empty($name) || Aspis_empty( $name)))))
 {arrayAssign($page_templates[0],deAspis(registerTaint(Aspis_trim($name))),addTaint($basename));
}}}return $page_templates;
 }
function _get_template_edit_filename ( $fullpath,$containingfolder ) {
return Aspis_str_replace(Aspis_dirname(Aspis_dirname($containingfolder)),array('',false),$fullpath);
 }
;
?>
<?php 