<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$title = __(array('Add New Page',false));
$parent_file = array('edit-pages.php',false);
$editing = array(true,false);
wp_enqueue_script(array('autosave',false));
wp_enqueue_script(array('post',false));
if ( deAspis(user_can_richedit()))
 wp_enqueue_script(array('editor',false));
add_thickbox();
wp_enqueue_script(array('media-upload',false));
wp_enqueue_script(array('word-count',false));
if ( deAspis(current_user_can(array('edit_pages',false))))
 {$action = array('post',false);
$post = get_default_page_to_edit();
include ('edit-page-form.php');
}include ('admin-footer.php');
;
?>
<?php 