<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 wp_die(__(array('You do not have sufficient permissions to manage options for this blog.',false)));
$title = __(array('Miscellaneous Settings',false));
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

<form method="post" action="options.php">
<?php settings_fields(array('misc',false));
;
?>

<h3><?php _e(array('Uploading Files',false));
;
?></h3>
<table class="form-table">
<tr valign="top">
<th scope="row"><label for="upload_path"><?php _e(array('Store uploads in this folder',false));
;
?></label></th>
<td><input name="upload_path" type="text" id="upload_path" value="<?php echo AspisCheckPrint(esc_attr(get_option(array('upload_path',false))));
;
?>" class="regular-text code" />
<span class="description"><?php _e(array('Default is <code>wp-content/uploads</code>',false));
;
?></span>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="upload_url_path"><?php _e(array('Full URL path to files',false));
;
?></label></th>
<td><input name="upload_url_path" type="text" id="upload_url_path" value="<?php echo AspisCheckPrint(esc_attr(get_option(array('upload_url_path',false))));
;
?>" class="regular-text code" />
<span class="description"><?php _e(array('Configuring this is optional. By default, it should be blank.',false));
;
?></span>
</td>
</tr>

<tr>
<th scope="row" colspan="2" class="th-full">
<label for="uploads_use_yearmonth_folders">
<input name="uploads_use_yearmonth_folders" type="checkbox" id="uploads_use_yearmonth_folders" value="1"<?php checked(array('1',false),get_option(array('uploads_use_yearmonth_folders',false)));
;
?> />
<?php _e(array('Organize my uploads into month- and year-based folders',false));
;
?>
</label>
</th>
</tr>
<?php do_settings_fields(array('misc',false),array('default',false));
;
?>
</table>

<table class="form-table">

<tr>
<th scope="row" class="th-full">
<label for="use_linksupdate">
<input name="use_linksupdate" type="checkbox" id="use_linksupdate" value="1"<?php checked(array('1',false),get_option(array('use_linksupdate',false)));
;
?> />
<?php _e(array('Track Links&#8217; Update Times',false));
?>
</label>
</th>
</tr>

</table>

<?php do_settings_sections(array('misc',false));
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