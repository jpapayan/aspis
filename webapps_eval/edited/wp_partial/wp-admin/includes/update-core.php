<?php require_once('AspisMain.php'); ?><?php
global $_old_files;
$_old_files = array('wp-admin/bookmarklet.php','wp-admin/css/upload.css','wp-admin/css/upload-rtl.css','wp-admin/css/press-this-ie.css','wp-admin/css/press-this-ie-rtl.css','wp-admin/edit-form.php','wp-admin/link-import.php','wp-admin/images/box-bg-left.gif','wp-admin/images/box-bg-right.gif','wp-admin/images/box-bg.gif','wp-admin/images/box-butt-left.gif','wp-admin/images/box-butt-right.gif','wp-admin/images/box-butt.gif','wp-admin/images/box-head-left.gif','wp-admin/images/box-head-right.gif','wp-admin/images/box-head.gif','wp-admin/images/heading-bg.gif','wp-admin/images/login-bkg-bottom.gif','wp-admin/images/login-bkg-tile.gif','wp-admin/images/notice.gif','wp-admin/images/toggle.gif','wp-admin/images/comment-stalk-classic.gif','wp-admin/images/comment-stalk-fresh.gif','wp-admin/images/comment-stalk-rtl.gif','wp-admin/images/comment-pill.gif','wp-admin/images/del.png','wp-admin/images/media-button-gallery.gif','wp-admin/images/media-buttons.gif','wp-admin/images/tail.gif','wp-admin/images/gear.png','wp-admin/images/tab.png','wp-admin/images/postbox-bg.gif','wp-admin/includes/upload.php','wp-admin/js/dbx-admin-key.js','wp-admin/js/link-cat.js','wp-admin/js/forms.js','wp-admin/js/upload.js','wp-admin/js/set-post-thumbnail-handler.js','wp-admin/js/set-post-thumbnail-handler.dev.js','wp-admin/js/page.js','wp-admin/js/page.dev.js','wp-admin/js/slug.js','wp-admin/js/slug.dev.js','wp-admin/profile-update.php','wp-admin/templates.php','wp-includes/images/audio.png','wp-includes/images/css.png','wp-includes/images/default.png','wp-includes/images/doc.png','wp-includes/images/exe.png','wp-includes/images/html.png','wp-includes/images/js.png','wp-includes/images/pdf.png','wp-includes/images/swf.png','wp-includes/images/tar.png','wp-includes/images/text.png','wp-includes/images/video.png','wp-includes/images/zip.png','wp-includes/js/dbx.js','wp-includes/js/fat.js','wp-includes/js/list-manipulation.js','wp-includes/js/jquery/jquery.dimensions.min.js','wp-includes/js/tinymce/langs/en.js','wp-includes/js/tinymce/plugins/autosave/editor_plugin_src.js','wp-includes/js/tinymce/plugins/autosave/langs','wp-includes/js/tinymce/plugins/directionality/images','wp-includes/js/tinymce/plugins/directionality/langs','wp-includes/js/tinymce/plugins/inlinepopups/css','wp-includes/js/tinymce/plugins/inlinepopups/images','wp-includes/js/tinymce/plugins/inlinepopups/jscripts','wp-includes/js/tinymce/plugins/paste/images','wp-includes/js/tinymce/plugins/paste/jscripts','wp-includes/js/tinymce/plugins/paste/langs','wp-includes/js/tinymce/plugins/spellchecker/classes/HttpClient.class.php','wp-includes/js/tinymce/plugins/spellchecker/classes/TinyGoogleSpell.class.php','wp-includes/js/tinymce/plugins/spellchecker/classes/TinyPspell.class.php','wp-includes/js/tinymce/plugins/spellchecker/classes/TinyPspellShell.class.php','wp-includes/js/tinymce/plugins/spellchecker/css/spellchecker.css','wp-includes/js/tinymce/plugins/spellchecker/images','wp-includes/js/tinymce/plugins/spellchecker/langs','wp-includes/js/tinymce/plugins/spellchecker/tinyspell.php','wp-includes/js/tinymce/plugins/wordpress/images','wp-includes/js/tinymce/plugins/wordpress/langs','wp-includes/js/tinymce/plugins/wordpress/popups.css','wp-includes/js/tinymce/plugins/wordpress/wordpress.css','wp-includes/js/tinymce/plugins/wphelp','wp-includes/js/tinymce/themes/advanced/css','wp-includes/js/tinymce/themes/advanced/images','wp-includes/js/tinymce/themes/advanced/jscripts','wp-includes/js/tinymce/themes/advanced/langs','wp-includes/js/tinymce/tiny_mce_gzip.php','wp-includes/js/wp-ajax.js','wp-admin/admin-db.php','wp-admin/cat.js','wp-admin/categories.js','wp-admin/custom-fields.js','wp-admin/dbx-admin-key.js','wp-admin/edit-comments.js','wp-admin/install-rtl.css','wp-admin/install.css','wp-admin/upgrade-schema.php','wp-admin/upload-functions.php','wp-admin/upload-rtl.css','wp-admin/upload.css','wp-admin/upload.js','wp-admin/users.js','wp-admin/widgets-rtl.css','wp-admin/widgets.css','wp-admin/xfn.js','wp-includes/js/tinymce/license.html','wp-admin/cat-js.php','wp-admin/edit-form-ajax-cat.php','wp-admin/execute-pings.php','wp-admin/import/b2.php','wp-admin/import/btt.php','wp-admin/import/jkw.php','wp-admin/inline-uploading.php','wp-admin/link-categories.php','wp-admin/list-manipulation.js','wp-admin/list-manipulation.php','wp-includes/comment-functions.php','wp-includes/feed-functions.php','wp-includes/functions-compat.php','wp-includes/functions-formatting.php','wp-includes/functions-post.php','wp-includes/js/dbx-key.js','wp-includes/js/tinymce/plugins/autosave/langs/cs.js','wp-includes/js/tinymce/plugins/autosave/langs/sv.js','wp-includes/js/tinymce/themes/advanced/editor_template_src.js','wp-includes/links.php','wp-includes/pluggable-functions.php','wp-includes/template-functions-author.php','wp-includes/template-functions-category.php','wp-includes/template-functions-general.php','wp-includes/template-functions-links.php','wp-includes/template-functions-post.php','wp-includes/wp-l10n.php','wp-admin/import-b2.php','wp-admin/import-blogger.php','wp-admin/import-greymatter.php','wp-admin/import-livejournal.php','wp-admin/import-mt.php','wp-admin/import-rss.php','wp-admin/import-textpattern.php','wp-admin/quicktags.js','wp-images/fade-butt.png','wp-images/get-firefox.png','wp-images/header-shadow.png','wp-images/smilies','wp-images/wp-small.png','wp-images/wpminilogo.png','wp.php','wp-includes/gettext.php','wp-includes/streams.php');
function update_core ( $from,$to ) {
{global $wp_filesystem,$_old_files,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_filesystem,"\$wp_filesystem",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($_old_files,"\$_old_files",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}@set_time_limit(300);
$php_version = phpversion();
$mysql_version = $wpdb->db_version();
$required_php_version = '4.3';
$required_mysql_version = '4.1.2';
$wp_version = '2.9.2';
$php_compat = version_compare($php_version,$required_php_version,'>=');
$mysql_compat = version_compare($mysql_version,$required_mysql_version,'>=') || file_exists(WP_CONTENT_DIR . '/db.php');
if ( !$mysql_compat || !$php_compat)
 $wp_filesystem->delete($from,true);
if ( !$mysql_compat && !$php_compat)
 {$AspisRetTemp = new WP_Error('php_mysql_not_compatible',sprintf(__('The update cannot be installed because WordPress %1$s requires PHP version %2$s or higher and MySQL version %3$s or higher. You are running PHP version %4$s and MySQL version %5$s.'),$wp_version,$required_php_version,$required_mysql_version,$php_version,$mysql_version));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$_old_files",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}elseif ( !$php_compat)
 {$AspisRetTemp = new WP_Error('php_not_compatible',sprintf(__('The update cannot be installed because WordPress %1$s requires PHP version %2$s or higher. You are running version %3$s.'),$wp_version,$required_php_version,$php_version));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$_old_files",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}elseif ( !$mysql_compat)
 {$AspisRetTemp = new WP_Error('mysql_not_compatible',sprintf(__('The update cannot be installed because WordPress %1$s requires MySQL version %2$s or higher. You are running version %3$s.'),$wp_version,$required_mysql_version,$mysql_version));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$_old_files",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}apply_filters('update_feedback',__('Verifying the unpacked files'));
if ( !$wp_filesystem->exists($from . '/wordpress/wp-settings.php') || !$wp_filesystem->exists($from . '/wordpress/wp-admin/admin.php') || !$wp_filesystem->exists($from . '/wordpress/wp-includes/functions.php'))
 {$wp_filesystem->delete($from,true);
{$AspisRetTemp = new WP_Error('insane_distro',__('The update could not be unpacked'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$_old_files",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}apply_filters('update_feedback',__('Installing the latest version'));
$maintenance_string = '<?php $upgrading = ' . time() . '; ?>';
$maintenance_file = $to . '.maintenance';
$wp_filesystem->delete($maintenance_file);
$wp_filesystem->put_contents($maintenance_file,$maintenance_string,FS_CHMOD_FILE);
$result = copy_dir($from . '/wordpress',$to);
if ( is_wp_error($result))
 {$wp_filesystem->delete($maintenance_file);
$wp_filesystem->delete($from,true);
{$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$_old_files",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}foreach ( $_old_files as $old_file  )
{$old_file = $to . $old_file;
if ( !$wp_filesystem->exists($old_file))
 continue ;
$wp_filesystem->delete($old_file,true);
}apply_filters('update_feedback',__('Upgrading database'));
$db_upgrade_url = admin_url('upgrade.php?step=upgrade_db');
wp_remote_post($db_upgrade_url,array('timeout' => 60));
$wp_filesystem->delete($from,true);
if ( function_exists('delete_transient'))
 delete_transient('update_core');
else 
{delete_option('update_core');
}$wp_filesystem->delete($maintenance_file);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_filesystem",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$_old_files",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpdb",$AspisChangesCache);
 }
;
?>
<?php 