<?php

/**

Custom thumbnail for NGG
Author : Simone Fumagalli | simone@iliveinperego.com
More info and update : http://www.iliveinperego.com/custom_thumbnail_for_ngg/

Credits:
 NextGen Gallery : Alex Rabe | http://alexrabe.boelinger.com/wordpress-plugins/nextgen-gallery/
 jCrop : Kelly Hallman <khallman@wrack.org> | http://deepliquid.com/content/Jcrop.html
 
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
$ngg_options=get_option('ngg_options');

$thumb = new ngg_Thumbnail($picture->imagePath, TRUE);
$thumb->resize(350,350);
// we need the new dimension
$resizedPreviewInfo = $thumb->newDimensions;
$thumb->destruct();

$preview_image		= NGGALLERY_URLPATH . 'nggshow.php?pid=' . $picture->pid . '&amp;width=350&amp;height=350';
$imageInfo			= @getimagesize($picture->imagePath);
$rr = round($imageInfo[0] / $resizedPreviewInfo['newWidth'], 2);

if ( ($ngg_options['thumbfix'] == 1) ) {
	
	$WidthHtmlPrev  = $ngg_options['thumbwidth'];
	$HeightHtmlPrev = $ngg_options['thumbheight'];
	
} else {
	// H > W
	if ($imageInfo[1] > $imageInfo[0]) {

		$HeightHtmlPrev =  $ngg_options['thumbheight'];
		$WidthHtmlPrev  = round($imageInfo[0] / ($imageInfo[1] / $ngg_options['thumbheight']),0);
		
	} else {
		
		$WidthHtmlPrev  =  $ngg_options['thumbwidth'];
		$HeightHtmlPrev = round($imageInfo[1] / ($imageInfo[0] / $ngg_options['thumbwidth']),0);
		
	}
}

?>
<script src="<?php echo NGGALLERY_URLPATH; ?>/admin/js/Jcrop/js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="<?php echo NGGALLERY_URLPATH; ?>/admin/js/Jcrop/css/jquery.Jcrop.css" type="text/css" />

<script language="JavaScript">
<!--
	
	var status = 'start';
	var xT, yT, wT, hT, selectedCoords;
	var selectedImage = "thumb<?php echo $id ?>";

	function showPreview(coords)
	{
		
		if (status != 'edit') {
			jQuery('#actualThumb').hide();
			jQuery('#previewNewThumb').show();
			status = 'edit';	
		}
		
		var rx = <?php echo $WidthHtmlPrev; ?> / coords.w;
		var ry = <?php echo $HeightHtmlPrev; ?> / coords.h;
		
		jQuery('#imageToEditPreview').css({
			width: Math.round(rx * <?php echo $resizedPreviewInfo['newWidth']; ?>) + 'px',
			height: Math.round(ry * <?php echo $resizedPreviewInfo['newHeight']; ?>) + 'px',
			marginLeft: '-' + Math.round(rx * coords.x) + 'px',
			marginTop: '-' + Math.round(ry * coords.y) + 'px'
		});
		
		xT = coords.x;
		yT = coords.y;
		wT = coords.w;
		hT = coords.h;
		
		jQuery("#sizeThumb").html(xT+" "+yT+" "+wT+" "+hT);
		
	};
	
	function updateThumb() {
		
		if ( (wT == 0) || (hT == 0) || (wT == undefined) || (hT == undefined) ) {
			alert("<?php _e('Select with the mouse the area for the new thumbnail', 'nggallery'); ?>");
			return false;			
		}
				
		jQuery.ajax({
		  url: "admin-ajax.php",
		  type : "POST",
		  data:  {x: xT, y: yT, w: wT, h: hT, action: 'createNewThumb', id: <?php echo $id; ?>, rr: <?php echo $rr; ?>},
		  cache: false,
		  success: function(data){
					var d = new Date();
					newUrl = jQuery("#"+selectedImage).attr("src") + "?" + d.getTime();
					jQuery("#"+selectedImage).attr("src" , newUrl);
					
					jQuery('#thumbMsg').html("<?php _e('Thumbnail updated', 'nggallery') ?>");
					jQuery('#thumbMsg').css({'display':'block'});
					setTimeout(function(){ jQuery('#thumbMsg').fadeOut('slow'); }, 1500);
			},
		  error: function() {
		  			jQuery('#thumbMsg').html("<?php _e('Error updating thumbnail', 'nggallery') ?>");
					jQuery('#thumbMsg').css({'display':'block'});
					setTimeout(function(){ jQuery('#thumbMsg').fadeOut('slow'); }, 1500);
		    }
		});

	}
	
-->
</script>

<table width="98%" align="center" style="border:1px solid #DADADA">
	<tr>
		<td rowspan="3" valign="middle" align="center" width="350" style="background-color:#DADADA;">
			<img src="<?php echo $preview_image; ?>" alt="" id="imageToEdit" />	
		</td>
		<td width="300" style="background-color : #DADADA;">
			<small style="margin-left:6px; display:block;"><?php _e('Select the area for the thumbnail from the picture on the left.', 'nggallery'); ?></small>
		</td>		
	</tr>
	<tr>
		<td align="center" width="300" height="320">
			<div id="previewNewThumb" style="display:none;width:<?php echo $WidthHtmlPrev; ?>px;height:<?php echo $HeightHtmlPrev; ?>px;overflow:hidden; margin-left:5px;">
				<img src="<?php echo $preview_image; ?>" id="imageToEditPreview" />
			</div>
			<div id="actualThumb">
				<img src="<?php echo $picture->thumbURL; ?>?<?php echo time()?>" />
			</div>
		</td>
	</tr>
	<tr style="background-color:#DADADA;">
		<td>
			<input type="button" name="update" value="<?php _e('Update', 'nggallery'); ?>" onclick="updateThumb()" class="button-secondary" style="float:left; margin-left:4px;"/>
			<div id="thumbMsg" style="color:#FF0000; display : none;font-size:11px; float:right; width:60%; height:2em; line-height:2em;"></div>
		</td>
	</tr>
</table>

<script type="text/javascript">
<!--
	jQuery(document).ready(function(){
		jQuery('#imageToEdit').Jcrop({
			onChange: showPreview,
			onSelect: showPreview,
			aspectRatio: <?php echo round($WidthHtmlPrev/$HeightHtmlPrev, 3) ?>
		});
	});
-->
</script>
