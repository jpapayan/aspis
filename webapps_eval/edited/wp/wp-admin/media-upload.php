<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('upload_files',false)))))
 wp_die(__(array('You do not have permission to upload files.',false)));
wp_enqueue_script(array('swfupload-all',false));
wp_enqueue_script(array('swfupload-handlers',false));
wp_enqueue_script(array('image-edit',false));
wp_enqueue_script(array('set-post-thumbnail',false));
wp_enqueue_style(array('imgareaselect',false));
@header((deconcat(concat2(concat1('Content-Type: ',get_option(array('html_type',false))),'; charset='),get_option(array('blog_charset',false)))));
$ID = ((isset($ID) && Aspis_isset( $ID))) ? int_cast($ID) : array(0,false);
$post_id = ((isset($post_id) && Aspis_isset( $post_id))) ? int_cast($post_id) : array(0,false);
if ( ((((isset($action) && Aspis_isset( $action))) && ($action[0] == ('edit'))) && (denot_boolean($ID))))
 wp_die(__(array("You are not allowed to be here",false)));
if ( ((isset($_GET[0][('inline')]) && Aspis_isset( $_GET [0][('inline')]))))
 {$errors = array(array(),false);
if ( (((isset($_POST[0][('html-upload')]) && Aspis_isset( $_POST [0][('html-upload')]))) && (!((empty($_FILES) || Aspis_empty( $_FILES))))))
 {$id = media_handle_upload(array('async-upload',false),$_REQUEST[0]['post_id']);
unset($_FILES);
if ( deAspis(is_wp_error($id)))
 {arrayAssign($errors[0],deAspis(registerTaint(array('upload_error',false))),addTaint($id));
$id = array(false,false);
}}if ( ((isset($_GET[0][('upload-page-form')]) && Aspis_isset( $_GET [0][('upload-page-form')]))))
 {$errors = Aspis_array_merge($errors,array_cast(media_upload_form_handler()));
$location = array('upload.php',false);
if ( $errors[0])
 $location = concat2($location,'?message=3');
wp_redirect(admin_url($location));
}$title = __(array('Upload New Media',false));
$parent_file = array('upload.php',false);
require_once ('admin-header.php');
;
?>
	<div class="wrap">
	<?php screen_icon();
;
?>
	<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

	<form enctype="multipart/form-data" method="post" action="media-upload.php?inline=&amp;upload-page-form=" class="media-upload-form type-form validate" id="file-form">

	<?php media_upload_form();
;
?>

	<script type="text/javascript">
	jQuery(function($){
		var preloaded = $(".media-item.preloaded");
		if ( preloaded.length > 0 ) {
			preloaded.each(function(){prepareMediaItem({id:this.id.replace(/[^0-9]/g, '')},'');});
		}
		updateMediaForm();
		post_id = 0;
		shortform = 1;
	});
	</script>
	<input type="hidden" name="post_id" id="post_id" value="0" />
	<?php wp_nonce_field(array('media-form',false));
;
?>
	<div id="media-items"> </div>
	<p>
	<input type="submit" class="button savebutton" name="save" value="<?php esc_attr_e(array('Save all changes',false));
;
?>" />
	</p>
	</form>
	</div>

<?php include ('admin-footer.php');
}else 
{{if ( ((isset($_GET[0][('type')]) && Aspis_isset( $_GET [0][('type')]))))
 $type = Aspis_strval($_GET[0]['type']);
else 
{$type = apply_filters(array('media_upload_default_type',false),array('file',false));
}if ( ((isset($_GET[0][('tab')]) && Aspis_isset( $_GET [0][('tab')]))))
 $tab = Aspis_strval($_GET[0]['tab']);
else 
{$tab = apply_filters(array('media_upload_default_tab',false),array('type',false));
}$body_id = array('media-upload',false);
if ( (($tab[0] == ('type')) || ($tab[0] == ('type_url'))))
 do_action(concat1("media_upload_",$type));
else 
{do_action(concat1("media_upload_",$tab));
}}};
?>
<?php 