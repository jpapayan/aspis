<?php require_once('AspisMain.php'); ?><?php
require_once ('./admin.php');
if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 wp_die(__(array('You do not have sufficient permissions to manage options for this blog.',false)));
$title = __(array('Privacy Settings',false));
$parent_file = array('options-general.php',false);
include ('./admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<form method="post" action="options.php">
<?php settings_fields(array('privacy',false));
;
?>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e(array('Blog Visibility',false));
?> </th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Blog Visibility',false));
?> </span></legend>
<p><input id="blog-public" type="radio" name="blog_public" value="1" <?php checked(array('1',false),get_option(array('blog_public',false)));
;
?> />
<label for="blog-public"><?php _e(array('I would like my blog to be visible to everyone, including search engines (like Google, Bing, Technorati) and archivers',false));
;
?></label></p>
<p><input id="blog-norobots" type="radio" name="blog_public" value="0" <?php checked(array('0',false),get_option(array('blog_public',false)));
;
?> />
<label for="blog-norobots"><?php _e(array('I would like to block search engines, but allow normal visitors',false));
;
?></label></p>
<?php do_action(array('blog_privacy_selector',false));
;
?>
</fieldset></td>
</tr>
<?php do_settings_fields(array('privacy',false),array('default',false));
;
?>
</table>

<?php do_settings_sections(array('privacy',false));
;
?>

<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e(array('Save Changes',false));
?>" />
</p>
</form>

</div>

<?php include ('./admin-footer.php');
?>
<?php 