<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$title = __(array('Add New Post',false));
$parent_file = array('edit.php',false);
$editing = array(true,false);
wp_enqueue_script(array('autosave',false));
wp_enqueue_script(array('post',false));
if ( deAspis(user_can_richedit()))
 wp_enqueue_script(array('editor',false));
add_thickbox();
wp_enqueue_script(array('media-upload',false));
wp_enqueue_script(array('word-count',false));
if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 {require_once ('./admin-header.php');
;
?>
<div class="wrap">
<p><?php printf(deAspis(__(array('Since you&#8217;re a newcomer, you&#8217;ll have to wait for an admin to add the <code>edit_posts</code> capability to your user, in order to be authorized to post.<br />
You can also <a href="mailto:%s?subject=Promotion?">e-mail the admin</a> to ask for a promotion.<br />
When you&#8217;re promoted, just reload this page and you&#8217;ll be able to blog. :)',false))),deAspisRC(get_option(array('admin_email',false))));
;
?>
</p>
</div>
<?php include ('admin-footer.php');
Aspis_exit();
}$post = get_default_post_to_edit();
include ('edit-form-advanced.php');
include ('admin-footer.php');
;
?>
<?php 