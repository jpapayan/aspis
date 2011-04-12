<?php
/**

Custom thumbnail for NGG
Author : Simone Fumagalli | simone@iliveinperego.com
More info and update : http://www.iliveinperego.com/rotate_for_ngg/

Credits:
 NextGen Gallery : Alex Rabe | http://alexrabe.boelinger.com/wordpress-plugins/nextgen-gallery/
 
**/

require_once( dirname( dirname(__FILE__) ) . '/ngg-config.php');
require_once( NGGALLERY_ABSPATH . '/lib/image.php' );

if ( !is_user_logged_in() )
	die(__('Cheatin&#8217; uh?'));
	
if ( !current_user_can('NextGEN Manage gallery') ) 
	die(__('Cheatin&#8217; uh?'));

global $wpdb;

$id = (int) $_GET['id'];

// let's get the image data
$picture = nggdb::find_image($id);

include_once( nggGallery::graphic_library() );
$ngg_options = get_option('ngg_options');

$thumb = new ngg_Thumbnail($picture->imagePath, TRUE);
$thumb->resize(350,350);

// we need the new dimension
$resizedPreviewInfo = $thumb->newDimensions;
$thumb->destruct();

$preview_image		= get_option ('siteurl') . '/' . 'index.php?callback=image&amp;pid=' . $picture->pid . '&amp;width=350&amp;height=350';

?>

<script language="JavaScript">
<!--
	
	function rotateImage() {
		
		var rotate_angle = jQuery('input[name=ra]:checked').val();
		
		jQuery.ajax({
		  url: "admin-ajax.php",
		  type : "POST",
		  data:  {action: 'rotateImage', id: <?php echo $id ?>, ra: rotate_angle},
		  cache: false,
		  success: function (msg) { showMessage('<?php _e('Image rotated', 'nggallery'); ?>') },
		  error: function (msg, status, errorThrown) { showMessage('<?php _e('Error rotating thumbnail', 'nggallery'); ?>') }
		});

	}
	
	function showMessage(message) {
		jQuery('#thumbMsg').html(message);
		jQuery('#thumbMsg').css({'display':'block'});
		setTimeout(function(){ jQuery('#thumbMsg').fadeOut('slow'); }, 1500);
		
		var d = new Date();
		newUrl = jQuery("#imageToEdit").attr("src") + "?" + d.getTime();
		jQuery("#imageToEdit").attr("src" , newUrl);
							
	}
	
-->
</script>

<table width="98%" align="center" style="border:1px solid #DADADA">
	<tr style="height : 360px;">
		<td valign="middle" align="center" style="background-color:#DADADA; width : 370px;">
			<img src="<?php echo $preview_image ?>" alt="" id="imageToEdit" />	
		</td>
		<td>
			<input type="radio" name="ra" value="cw" /><?php _e('90&deg; clockwise', 'nggallery'); ?><br />
			<input type="radio" name="ra" value="ccw" /><?php _e('90&deg; anticlockwise', 'nggallery'); ?><br />
			<input type="radio" name="ra" value="fv" /><?php _e('Flip vertically', 'nggallery'); ?><br />
			<input type="radio" name="ra" value="fh" /><?php _e('Flip horizontally', 'nggallery'); ?>
		</td>		
	</tr>
	<tr style="background-color:#DADADA;">

		<td colspan="2">
			<input type="button" name="update" value="<?php _e('Update', 'nggallery'); ?>" onclick="rotateImage()" class="button-secondary" style="float:right; margin-left:4px;"/>
			<div id="thumbMsg" style="color:#FF0000; display : none;font-size:11px; float:right; width:60%; height:2em; line-height:2em;"></div>
			
		</td>
	</tr>
</table>