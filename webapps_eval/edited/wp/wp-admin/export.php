<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('edit_files',false)))))
 wp_die(__(array('You do not have sufficient permissions to export the content of this blog.',false)));
require_once ('includes/export.php');
$title = __(array('Export',false));
if ( ((isset($_GET[0][('download')]) && Aspis_isset( $_GET [0][('download')]))))
 {$author = ((isset($_GET[0][('author')]) && Aspis_isset( $_GET [0][('author')]))) ? $_GET[0]['author'] : array('all',false);
export_wp($author);
Aspis_exit();
}require_once ('admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<p><?php _e(array('When you click the button below WordPress will create an XML file for you to save to your computer.',false));
;
?></p>
<p><?php _e(array('This format, which we call WordPress eXtended RSS or WXR, will contain your posts, pages, comments, custom fields, categories, and tags.',false));
;
?></p>
<p><?php _e(array('Once you&#8217;ve saved the download file, you can use the Import function on another WordPress blog to import this blog.',false));
;
?></p>
<form action="" method="get">
<h3><?php _e(array('Options',false));
;
?></h3>

<table class="form-table">
<tr>
<th><label for="author"><?php _e(array('Restrict Author',false));
;
?></label></th>
<td>
<select name="author" id="author">
<option value="all" selected="selected"><?php _e(array('All Authors',false));
;
?></option>
<?php $authors = $wpdb[0]->get_col(concat2(concat1("SELECT post_author FROM ",$wpdb[0]->posts)," GROUP BY post_author"));
foreach ( $authors[0] as $id  )
{$o = get_userdata($id);
echo AspisCheckPrint(concat(concat1("<option value='",esc_attr($o[0]->ID)),concat2(concat1("'>",$o[0]->display_name),"</option>")));
};
?>
</select>
</td>
</tr>
</table>
<p class="submit"><input type="submit" name="submit" class="button" value="<?php esc_attr_e(array('Download Export File',false));
;
?>" />
<input type="hidden" name="download" value="true" />
</p>
</form>
</div>

<?php include ('admin-footer.php');
;
?>
<?php 