<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 wp_die(__(array('You do not have sufficient permissions to manage options for this blog.',false)));
$title = __(array('Media Settings',false));
$parent_file = array('options-general.php',false);
include ('admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<form action="options.php" method="post">
<?php settings_fields(array('media',false));
;
?>

<h3><?php _e(array('Image sizes',false));
?></h3>
<p><?php _e(array('The sizes listed below determine the maximum dimensions in pixels to use when inserting an image into the body of a post.',false));
;
?></p>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e(array('Thumbnail size',false));
?></th>
<td>
<label for="thumbnail_size_w"><?php _e(array('Width',false));
;
?></label>
<input name="thumbnail_size_w" type="text" id="thumbnail_size_w" value="<?php form_option(array('thumbnail_size_w',false));
;
?>" class="small-text" />
<label for="thumbnail_size_h"><?php _e(array('Height',false));
;
?></label>
<input name="thumbnail_size_h" type="text" id="thumbnail_size_h" value="<?php form_option(array('thumbnail_size_h',false));
;
?>" class="small-text" /><br />
<input name="thumbnail_crop" type="checkbox" id="thumbnail_crop" value="1" <?php checked(array('1',false),get_option(array('thumbnail_crop',false)));
;
?>/>
<label for="thumbnail_crop"><?php _e(array('Crop thumbnail to exact dimensions (normally thumbnails are proportional)',false));
;
?></label>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e(array('Medium size',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Medium size',false));
;
?></span></legend>
<label for="medium_size_w"><?php _e(array('Max Width',false));
;
?></label>
<input name="medium_size_w" type="text" id="medium_size_w" value="<?php form_option(array('medium_size_w',false));
;
?>" class="small-text" />
<label for="medium_size_h"><?php _e(array('Max Height',false));
;
?></label>
<input name="medium_size_h" type="text" id="medium_size_h" value="<?php form_option(array('medium_size_h',false));
;
?>" class="small-text" />
</fieldset></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e(array('Large size',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Large size',false));
;
?></span></legend>
<label for="large_size_w"><?php _e(array('Max Width',false));
;
?></label>
<input name="large_size_w" type="text" id="large_size_w" value="<?php form_option(array('large_size_w',false));
;
?>" class="small-text" />
<label for="large_size_h"><?php _e(array('Max Height',false));
;
?></label>
<input name="large_size_h" type="text" id="large_size_h" value="<?php form_option(array('large_size_h',false));
;
?>" class="small-text" />
</fieldset></td>
</tr>

<?php do_settings_fields(array('media',false),array('default',false));
;
?>
</table>

<h3><?php _e(array('Embeds',false));
?></h3>

<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e(array('Auto-embeds',false));
;
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Attempt to automatically embed all plain text URLs',false));
;
?></span></legend>
<label for="embed_autourls"><input name="embed_autourls" type="checkbox" id="embed_autourls" value="1" <?php checked(array('1',false),get_option(array('embed_autourls',false)));
;
?>/> <?php _e(array('Attempt to automatically embed all plain text URLs',false));
;
?></label>
</fieldset></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e(array('Maximum embed size',false));
?></th>
<td>
<label for="embed_size_w"><?php _e(array('Width',false));
;
?></label>
<input name="embed_size_w" type="text" id="embed_size_w" value="<?php form_option(array('embed_size_w',false));
;
?>" class="small-text" />
<label for="embed_size_h"><?php _e(array('Height',false));
;
?></label>
<input name="embed_size_h" type="text" id="embed_size_h" value="<?php form_option(array('embed_size_h',false));
;
?>" class="small-text" />
<?php if ( (!((empty($content_width) || Aspis_empty( $content_width)))))
 echo AspisCheckPrint(concat1('<br />',__(array("If the width value is left blank, embeds will default to the max width of your theme.",false))));
;
?>
</td>
</tr>

<?php do_settings_fields(array('media',false),array('embeds',false));
;
?>
</table>

<?php do_settings_sections(array('media',false));
;
?>

<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e(array('Save Changes',false));
?>" />
</p>

</form>

</div>

<?php include ('./admin-footer.php');
;
?>
<?php 