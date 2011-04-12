<?php require_once('AspisMain.php'); ?><?php
function wp_image_editor ( $post_id,$msg = array(false,false) ) {
$nonce = wp_create_nonce(concat1("image_editor-",$post_id));
$meta = wp_get_attachment_metadata($post_id);
$thumb = image_get_intermediate_size($post_id,array('thumbnail',false));
$sub_sizes = array(((isset($meta[0][('sizes')]) && Aspis_isset( $meta [0][('sizes')]))) && is_array(deAspis($meta[0]['sizes'])),false);
$note = array('',false);
if ( (is_array($meta[0]) && ((isset($meta[0][('width')]) && Aspis_isset( $meta [0][('width')])))))
 $big = attAspisRC(max(deAspisRC($meta[0]['width']),deAspisRC($meta[0]['height'])));
else 
{Aspis_exit(__(array('Image data does not exist. Please re-upload the image.',false)));
}$sizer = ($big[0] > (400)) ? array((400) / $big[0],false) : array(1,false);
$backup_sizes = get_post_meta($post_id,array('_wp_attachment_backup_sizes',false),array(true,false));
$can_restore = array(((!((empty($backup_sizes) || Aspis_empty( $backup_sizes)))) && ((isset($backup_sizes[0][('full-orig')]) && Aspis_isset( $backup_sizes [0][('full-orig')])))) && (deAspis($backup_sizes[0][('full-orig')][0]['file']) != deAspis(Aspis_basename($meta[0]['file']))),false);
if ( $msg[0])
 {if ( ((isset($msg[0]->error) && Aspis_isset( $msg[0] ->error ))))
 $note = concat2(concat1("<div class='error'><p>",$msg[0]->error),"</p></div>");
elseif ( ((isset($msg[0]->msg) && Aspis_isset( $msg[0] ->msg ))))
 $note = concat2(concat1("<div class='updated'><p>",$msg[0]->msg),"</p></div>");
};
?>
	<div class="imgedit-wrap">
	<?php echo AspisCheckPrint($note);
;
?>
	<table id="imgedit-panel-<?php echo AspisCheckPrint($post_id);
;
?>"><tbody>
	<tr><td>
	<div class="imgedit-menu">
		<div onclick="imageEdit.crop(<?php echo AspisCheckPrint(concat2(concat(concat2($post_id,", '"),$nonce),"'"));
;
?>, this)" class="imgedit-crop disabled" title="<?php esc_attr_e(array('Crop',false));
;
?>"></div><?php if ( function_exists(('imagerotate')))
 {;
?>
		<div class="imgedit-rleft"  onclick="imageEdit.rotate( 90, <?php echo AspisCheckPrint(concat2(concat(concat2($post_id,", '"),$nonce),"'"));
;
?>, this)" title="<?php esc_attr_e(array('Rotate counter-clockwise',false));
;
?>"></div>
		<div class="imgedit-rright" onclick="imageEdit.rotate(-90, <?php echo AspisCheckPrint(concat2(concat(concat2($post_id,", '"),$nonce),"'"));
;
?>, this)" title="<?php esc_attr_e(array('Rotate clockwise',false));
;
?>"></div>
<?php }else 
{{$note_gdlib = esc_attr__(array('Image rotation is not supported by your web host (function imagerotate() is missing)',false));
;
?>
	    <div class="imgedit-rleft disabled"  title="<?php echo AspisCheckPrint($note_gdlib);
;
?>"></div>
	    <div class="imgedit-rright disabled" title="<?php echo AspisCheckPrint($note_gdlib);
;
?>"></div>
<?php }};
?>

		<div onclick="imageEdit.flip(1, <?php echo AspisCheckPrint(concat2(concat(concat2($post_id,", '"),$nonce),"'"));
;
?>, this)" class="imgedit-flipv" title="<?php esc_attr_e(array('Flip vertically',false));
;
?>"></div>
		<div onclick="imageEdit.flip(2, <?php echo AspisCheckPrint(concat2(concat(concat2($post_id,", '"),$nonce),"'"));
;
?>, this)" class="imgedit-fliph" title="<?php esc_attr_e(array('Flip horizontally',false));
;
?>"></div>

		<div id="image-undo-<?php echo AspisCheckPrint($post_id);
;
?>" onclick="imageEdit.undo(<?php echo AspisCheckPrint(concat2(concat(concat2($post_id,", '"),$nonce),"'"));
;
?>, this)" class="imgedit-undo disabled" title="<?php esc_attr_e(array('Undo',false));
;
?>"></div>
		<div id="image-redo-<?php echo AspisCheckPrint($post_id);
;
?>" onclick="imageEdit.redo(<?php echo AspisCheckPrint(concat2(concat(concat2($post_id,", '"),$nonce),"'"));
;
?>, this)" class="imgedit-redo disabled" title="<?php esc_attr_e(array('Redo',false));
;
?>"></div>
		<br class="clear" />
	</div>

	<input type="hidden" id="imgedit-sizer-<?php echo AspisCheckPrint($post_id);
;
?>" value="<?php echo AspisCheckPrint($sizer);
;
?>" />
	<input type="hidden" id="imgedit-minthumb-<?php echo AspisCheckPrint($post_id);
;
?>" value="<?php echo AspisCheckPrint((concat(concat2(get_option(array('thumbnail_size_w',false)),':'),get_option(array('thumbnail_size_h',false)))));
;
?>" />
	<input type="hidden" id="imgedit-history-<?php echo AspisCheckPrint($post_id);
;
?>" value="" />
	<input type="hidden" id="imgedit-undone-<?php echo AspisCheckPrint($post_id);
;
?>" value="0" />
	<input type="hidden" id="imgedit-selection-<?php echo AspisCheckPrint($post_id);
;
?>" value="" />
	<input type="hidden" id="imgedit-x-<?php echo AspisCheckPrint($post_id);
;
?>" value="<?php echo AspisCheckPrint($meta[0]['width']);
;
?>" />
	<input type="hidden" id="imgedit-y-<?php echo AspisCheckPrint($post_id);
;
?>" value="<?php echo AspisCheckPrint($meta[0]['height']);
;
?>" />

	<div id="imgedit-crop-<?php echo AspisCheckPrint($post_id);
;
?>" class="imgedit-crop-wrap">
	<img id="image-preview-<?php echo AspisCheckPrint($post_id);
;
?>" onload="imageEdit.imgLoaded('<?php echo AspisCheckPrint($post_id);
;
?>')" src="<?php echo AspisCheckPrint(admin_url(array('admin-ajax.php',false)));
;
?>?action=imgedit-preview&amp;_ajax_nonce=<?php echo AspisCheckPrint($nonce);
;
?>&amp;postid=<?php echo AspisCheckPrint($post_id);
;
?>&amp;rand=<?php echo AspisCheckPrint(attAspis(rand((1),(99999))));
;
?>" />
	</div>

	<div class="imgedit-submit">
		<input type="button" onclick="imageEdit.close(<?php echo AspisCheckPrint($post_id);
;
?>, 1)" class="button" value="<?php esc_attr_e(array('Cancel',false));
;
?>" />
		<input type="button" onclick="imageEdit.save(<?php echo AspisCheckPrint(concat2(concat(concat2($post_id,", '"),$nonce),"'"));
;
?>)" disabled="disabled" class="button-primary imgedit-submit-btn" value="<?php esc_attr_e(array('Save',false));
;
?>" />
	</div>
	</td>

	<td class="imgedit-settings">
	<div class="imgedit-group">
	<div class="imgedit-group-top">
		<a class="imgedit-help-toggle" onclick="imageEdit.toggleHelp(this);return false;" href="#"><strong><?php _e(array('Scale Image',false));
;
?></strong></a>
		<div class="imgedit-help">
		<p><?php _e(array('You can proportionally scale the original image. For best results the scaling should be done before performing any other operations on it like crop, rotate, etc. Note that if you make the image larger it may become fuzzy.',false));
;
?></p>
		<p><?php printf(deAspis(__(array('Original dimensions %s',false))),(deconcat(concat2($meta[0]['width'],'&times;'),$meta[0]['height'])));
;
?></p>
		<div class="imgedit-submit">
		<span class="nowrap"><input type="text" id="imgedit-scale-width-<?php echo AspisCheckPrint($post_id);
;
?>" onkeyup="imageEdit.scaleChanged(<?php echo AspisCheckPrint($post_id);
;
?>, 1)" onblur="imageEdit.scaleChanged(<?php echo AspisCheckPrint($post_id);
;
?>, 1)" style="width:4em;" value="<?php echo AspisCheckPrint($meta[0]['width']);
;
?>" />&times;<input type="text" id="imgedit-scale-height-<?php echo AspisCheckPrint($post_id);
;
?>" onkeyup="imageEdit.scaleChanged(<?php echo AspisCheckPrint($post_id);
;
?>, 0)" onblur="imageEdit.scaleChanged(<?php echo AspisCheckPrint($post_id);
;
?>, 0)" style="width:4em;" value="<?php echo AspisCheckPrint($meta[0]['height']);
;
?>" />
		<span class="imgedit-scale-warn" id="imgedit-scale-warn-<?php echo AspisCheckPrint($post_id);
;
?>">!</span></span>
		<input type="button" onclick="imageEdit.action(<?php echo AspisCheckPrint(concat2(concat(concat2($post_id,", '"),$nonce),"'"));
;
?>, 'scale')" class="button-primary" value="<?php esc_attr_e(array('Scale',false));
;
?>" />
		</div>
		</div>
	</div>

<?php if ( $can_restore[0])
 {;
?>

	<div class="imgedit-group-top">
		<a class="imgedit-help-toggle" onclick="imageEdit.toggleHelp(this);return false;" href="#"><strong><?php _e(array('Restore Original Image',false));
;
?></strong></a>
		<div class="imgedit-help">
		<p><?php _e(array('Discard any changes and restore the original image.',false));
if ( ((!(defined(('IMAGE_EDIT_OVERWRITE')))) || (!(IMAGE_EDIT_OVERWRITE))))
 _e(array(' Previously edited copies of the image will not be deleted.',false));
;
?></p>
		<div class="imgedit-submit">
		<input type="button" onclick="imageEdit.action(<?php echo AspisCheckPrint(concat2(concat(concat2($post_id,", '"),$nonce),"'"));
;
?>, 'restore')" class="button-primary" value="<?php esc_attr_e(array('Restore image',false));
;
?>" <?php echo AspisCheckPrint($can_restore);
;
?> />
		</div>
		</div>
	</div>

<?php };
?>

	</div>

	<div class="imgedit-group">
	<div class="imgedit-group-top">
		<strong><?php _e(array('Image Crop',false));
;
?></strong>
		<a class="imgedit-help-toggle" onclick="imageEdit.toggleHelp(this);return false;" href="#"><?php _e(array('(help)',false));
;
?></a>
		<div class="imgedit-help">
		<p><?php _e(array('The image can be cropped by clicking on it and dragging to select the desired part. While dragging the dimensions of the selection are displayed below.',false));
;
?></p>
		<strong><?php _e(array('Keyboard shortcuts',false));
;
?></strong>
		<ul>
		<li><?php _e(array('Arrow: move by 10px',false));
;
?></li>
		<li><?php _e(array('Shift + arrow: move by 1px',false));
;
?></li>
		<li><?php _e(array('Ctrl + arrow: resize by 10px',false));
;
?></li>
		<li><?php _e(array('Ctrl + Shift + arrow: resize by 1px',false));
;
?></li>
		<li><?php _e(array('Shift + drag: lock aspect ratio',false));
;
?></li>
		</ul>

		<p><strong><?php _e(array('Crop Aspect Ratio',false));
;
?></strong><br />
		<?php _e(array('You can specify the crop selection aspect ratio then hold down the Shift key while dragging to lock it. The values can be 1:1 (square), 4:3, 16:9, etc. If there is a selection, specifying aspect ratio will set it immediately.',false));
;
?></p>

		<p><strong><?php _e(array('Crop Selection',false));
;
?></strong><br />
		<?php _e(array('Once started, the selection can be adjusted by entering new values (in pixels). Note that these values are scaled to approximately match the original image dimensions. The minimum selection size equals the thumbnail size as set in the Media settings.',false));
;
?></p>
		</div>
	</div>

	<p>
		<?php _e(array('Aspect ratio:',false));
;
?>
		<span  class="nowrap">
		<input type="text" id="imgedit-crop-width-<?php echo AspisCheckPrint($post_id);
;
?>" onkeyup="imageEdit.setRatioSelection(<?php echo AspisCheckPrint($post_id);
;
?>, 0, this)" style="width:3em;" />
		:
		<input type="text" id="imgedit-crop-height-<?php echo AspisCheckPrint($post_id);
;
?>" onkeyup="imageEdit.setRatioSelection(<?php echo AspisCheckPrint($post_id);
;
?>, 1, this)" style="width:3em;" />
		</span>
	</p>

	<p id="imgedit-crop-sel-<?php echo AspisCheckPrint($post_id);
;
?>">
		<?php _e(array('Selection:',false));
;
?>
		<span  class="nowrap">
		<input type="text" id="imgedit-sel-width-<?php echo AspisCheckPrint($post_id);
;
?>" onkeyup="imageEdit.setNumSelection(<?php echo AspisCheckPrint($post_id);
;
?>)" style="width:4em;" />
		:
		<input type="text" id="imgedit-sel-height-<?php echo AspisCheckPrint($post_id);
;
?>" onkeyup="imageEdit.setNumSelection(<?php echo AspisCheckPrint($post_id);
;
?>)" style="width:4em;" />
		</span>
	</p>
	</div>

	<?php if ( ($thumb[0] && $sub_sizes[0]))
 {$thumb_img = wp_constrain_dimensions($thumb[0]['width'],$thumb[0]['height'],array(160,false),array(120,false));
;
?>

	<div class="imgedit-group imgedit-applyto">
	<div class="imgedit-group-top">
		<strong><?php _e(array('Thumbnail Settings',false));
;
?></strong>
		<a class="imgedit-help-toggle" onclick="imageEdit.toggleHelp(this);return false;" href="#"><?php _e(array('(help)',false));
;
?></a>
		<p class="imgedit-help"><?php _e(array('The thumbnail image can be cropped differently. For example it can be square or contain only a portion of the original image to showcase it better. Here you can select whether to apply changes to all image sizes or make the thumbnail different.',false));
;
?></p>
	</div>

	<p>
		<img src="<?php echo AspisCheckPrint($thumb[0]['url']);
;
?>" width="<?php echo AspisCheckPrint(attachAspis($thumb_img,(0)));
;
?>" height="<?php echo AspisCheckPrint(attachAspis($thumb_img,(1)));
;
?>" class="imgedit-size-preview" alt="" /><br /><?php _e(array('Current thumbnail',false));
;
?>
	</p>

	<p id="imgedit-save-target-<?php echo AspisCheckPrint($post_id);
;
?>">
		<strong><?php _e(array('Apply changes to:',false));
;
?></strong><br />

		<label class="imgedit-label">
		<input type="radio" name="imgedit-target-<?php echo AspisCheckPrint($post_id);
;
?>" value="all" checked="checked" />
		<?php _e(array('All image sizes',false));
;
?></label>

		<label class="imgedit-label">
		<input type="radio" name="imgedit-target-<?php echo AspisCheckPrint($post_id);
;
?>" value="thumbnail" />
		<?php _e(array('Thumbnail',false));
;
?></label>

		<label class="imgedit-label">
		<input type="radio" name="imgedit-target-<?php echo AspisCheckPrint($post_id);
;
?>" value="nothumb" />
		<?php _e(array('All sizes except thumbnail',false));
;
?></label>
	</p>
	</div>

	<?php };
?>

	</td></tr>
	</tbody></table>
	<div class="imgedit-wait" id="imgedit-wait-<?php echo AspisCheckPrint($post_id);
;
?>"></div>
	<script type="text/javascript">imageEdit.init(<?php echo AspisCheckPrint($post_id);
;
?>);</script>
	<div class="hidden" id="imgedit-leaving-<?php echo AspisCheckPrint($post_id);
;
?>"><?php _e(array("There are unsaved changes that will be lost.  'OK' to continue, 'Cancel' to return to the Image Editor.",false));
;
?></div>
	</div>
<?php  }
function load_image_to_edit ( $post_id,$mime_type,$size = array('full',false) ) {
$filepath = get_attached_file($post_id);
if ( ($filepath[0] && file_exists($filepath[0])))
 {if ( ((('full') != $size[0]) && deAspis(($data = image_get_intermediate_size($post_id,$size)))))
 $filepath = path_join(Aspis_dirname($filepath),$data[0]['file']);
}elseif ( deAspis(WP_Http_Fopen::test()))
 {$filepath = wp_get_attachment_url($post_id);
}$filepath = apply_filters(array('load_image_to_edit_path',false),$filepath,$post_id,$size);
if ( ((empty($filepath) || Aspis_empty( $filepath))))
 return array(false,false);
switch ( $mime_type[0] ) {
case ('image/jpeg'):$image = attAspis(imagecreatefromjpeg($filepath[0]));
break ;
case ('image/png'):$image = attAspis(imagecreatefrompng($filepath[0]));
break ;
case ('image/gif'):$image = attAspis(imagecreatefromgif($filepath[0]));
break ;
default :$image = array(false,false);
break ;
 }
if ( is_resource(deAspisRC($image)))
 {$image = apply_filters(array('load_image_to_edit',false),$image,$post_id,$size);
if ( (function_exists(('imagealphablending')) && function_exists(('imagesavealpha'))))
 {imagealphablending($image[0],false);
imagesavealpha($image[0],true);
}}return $image;
 }
function wp_stream_image ( $image,$mime_type,$post_id ) {
$image = apply_filters(array('image_save_pre',false),$image,$post_id);
switch ( $mime_type[0] ) {
case ('image/jpeg'):header(('Content-Type: image/jpeg'));
return attAspis(imagejpeg($image[0],null,(90)));
case ('image/png'):header(('Content-Type: image/png'));
return attAspis(imagepng($image[0]));
case ('image/gif'):header(('Content-Type: image/gif'));
return attAspis(imagegif($image[0]));
default :return array(false,false);
 }
 }
function wp_save_image_file ( $filename,$image,$mime_type,$post_id ) {
$image = apply_filters(array('image_save_pre',false),$image,$post_id);
$saved = apply_filters(array('wp_save_image_file',false),array(null,false),$filename,$image,$mime_type,$post_id);
if ( (null !== $saved[0]))
 return $saved;
switch ( $mime_type[0] ) {
case ('image/jpeg'):return attAspis(imagejpeg($image[0],$filename[0],deAspis(apply_filters(array('jpeg_quality',false),array(90,false),array('edit_image',false)))));
case ('image/png'):return attAspis(imagepng($image[0],$filename[0]));
case ('image/gif'):return attAspis(imagegif($image[0],$filename[0]));
default :return array(false,false);
 }
 }
function _image_get_preview_ratio ( $w,$h ) {
$max = attAspisRC(max(deAspisRC($w),deAspisRC($h)));
return ($max[0] > (400)) ? (array((400) / $max[0],false)) : array(1,false);
 }
function _rotate_image_resource ( $img,$angle ) {
if ( function_exists(('imagerotate')))
 {$rotated = attAspis(imagerotate($img[0],$angle[0],(0)));
if ( is_resource(deAspisRC($rotated)))
 {imagedestroy($img[0]);
$img = $rotated;
}}return $img;
 }
function _flip_image_resource ( $img,$horz,$vert ) {
$w = attAspis(imagesx($img[0]));
$h = attAspis(imagesy($img[0]));
$dst = wp_imagecreatetruecolor($w,$h);
if ( is_resource(deAspisRC($dst)))
 {$sx = $vert[0] ? (array($w[0] - (1),false)) : array(0,false);
$sy = $horz[0] ? (array($h[0] - (1),false)) : array(0,false);
$sw = $vert[0] ? negate($w) : $w;
$sh = $horz[0] ? negate($h) : $h;
if ( imagecopyresampled($dst[0],$img[0],(0),(0),$sx[0],$sy[0],$w[0],$h[0],$sw[0],$sh[0]))
 {imagedestroy($img[0]);
$img = $dst;
}}return $img;
 }
function _crop_image_resource ( $img,$x,$y,$w,$h ) {
$dst = wp_imagecreatetruecolor($w,$h);
if ( is_resource(deAspisRC($dst)))
 {if ( imagecopy($dst[0],$img[0],(0),(0),$x[0],$y[0],$w[0],$h[0]))
 {imagedestroy($img[0]);
$img = $dst;
}}return $img;
 }
function image_edit_apply_changes ( $img,$changes ) {
if ( (!(is_array($changes[0]))))
 return $img;
foreach ( $changes[0] as $key =>$obj )
{restoreTaint($key,$obj);
{if ( ((isset($obj[0]->r) && Aspis_isset( $obj[0] ->r ))))
 {$obj[0]->type = array('rotate',false);
$obj[0]->angle = $obj[0]->r;
unset($obj[0]->r);
}elseif ( ((isset($obj[0]->f) && Aspis_isset( $obj[0] ->f ))))
 {$obj[0]->type = array('flip',false);
$obj[0]->axis = $obj[0]->f;
unset($obj[0]->f);
}elseif ( ((isset($obj[0]->c) && Aspis_isset( $obj[0] ->c ))))
 {$obj[0]->type = array('crop',false);
$obj[0]->sel = $obj[0]->c;
unset($obj[0]->c);
}arrayAssign($changes[0],deAspis(registerTaint($key)),addTaint($obj));
}}if ( (count($changes[0]) > (1)))
 {$filtered = array(array(attachAspis($changes,(0))),false);
for ( $i = array(0,false),$j = array(1,false) ; ($j[0] < count($changes[0])) ; postincr($j) )
{$combined = array(false,false);
if ( ($filtered[0][$i[0]][0]->type[0] == $changes[0][$j[0]][0]->type[0]))
 {switch ( $filtered[0][$i[0]][0]->type[0] ) {
case ('rotate'):$filtered[0][$i[0]][0]->angle = array($changes[0][$j[0]][0]->angle[0] + $filtered[0][$i[0]][0]->angle [0],false);
$combined = array(true,false);
break ;
case ('flip'):$filtered[0][$i[0]][0]->axis = array($filtered[0][$i[0]][0]->axis [0] ^ $changes[0][$j[0]][0]->axis[0],false);
$combined = array(true,false);
break ;
 }
}if ( (denot_boolean($combined)))
 arrayAssign($filtered[0],deAspis(registerTaint(preincr($i))),addTaint(attachAspis($changes,$j[0])));
}$changes = $filtered;
unset($filtered);
}$img = apply_filters(array('image_edit_before_change',false),$img,$changes);
foreach ( $changes[0] as $operation  )
{switch ( $operation[0]->type[0] ) {
case ('rotate'):if ( ($operation[0]->angle[0] != (0)))
 $img = _rotate_image_resource($img,$operation[0]->angle);
break ;
case ('flip'):if ( ($operation[0]->axis[0] != (0)))
 $img = _flip_image_resource($img,array(($operation[0]->axis[0] & (1)) != (0),false),array(($operation[0]->axis[0] & (2)) != (0),false));
break ;
case ('crop'):$sel = $operation[0]->sel;
$scale = array((1) / deAspis(_image_get_preview_ratio(attAspis(imagesx($img[0])),attAspis(imagesy($img[0])))),false);
$img = _crop_image_resource($img,array($sel[0]->x[0] * $scale[0],false),array($sel[0]->y[0] * $scale[0],false),array($sel[0]->w[0] * $scale[0],false),array($sel[0]->h[0] * $scale[0],false));
break ;
 }
}return $img;
 }
function stream_preview_image ( $post_id ) {
$post = get_post($post_id);
@array(ini_set('memory_limit','256M'),false);
$img = load_image_to_edit($post_id,$post[0]->post_mime_type,array(array(array(400,false),array(400,false)),false));
if ( (!(is_resource(deAspisRC($img)))))
 return array(false,false);
$changes = (!((empty($_REQUEST[0][('history')]) || Aspis_empty( $_REQUEST [0][('history')])))) ? array(json_decode(deAspisRC(Aspis_stripslashes($_REQUEST[0]['history']))),false) : array(null,false);
if ( $changes[0])
 $img = image_edit_apply_changes($img,$changes);
$w = attAspis(imagesx($img[0]));
$h = attAspis(imagesy($img[0]));
$ratio = _image_get_preview_ratio($w,$h);
$w2 = array($w[0] * $ratio[0],false);
$h2 = array($h[0] * $ratio[0],false);
$preview = wp_imagecreatetruecolor($w2,$h2);
imagecopyresampled($preview[0],$img[0],(0),(0),(0),(0),$w2[0],$h2[0],$w[0],$h[0]);
wp_stream_image($preview,$post[0]->post_mime_type,$post_id);
imagedestroy($preview[0]);
imagedestroy($img[0]);
return array(true,false);
 }
function wp_restore_image ( $post_id ) {
$meta = wp_get_attachment_metadata($post_id);
$file = get_attached_file($post_id);
$backup_sizes = get_post_meta($post_id,array('_wp_attachment_backup_sizes',false),array(true,false));
$restored = array(false,false);
$msg = array('',false);
if ( (!(is_array($backup_sizes[0]))))
 {$msg[0]->error = __(array('Cannot load image metadata.',false));
return $msg;
}$parts = Aspis_pathinfo($file);
$suffix = concat(attAspis(time()),attAspis(rand((100),(999))));
$default_sizes = apply_filters(array('intermediate_image_sizes',false),array(array(array('large',false),array('medium',false),array('thumbnail',false)),false));
if ( (((isset($backup_sizes[0][('full-orig')]) && Aspis_isset( $backup_sizes [0][('full-orig')]))) && is_array(deAspis($backup_sizes[0]['full-orig']))))
 {$data = $backup_sizes[0]['full-orig'];
if ( (deAspis($parts[0]['basename']) != deAspis($data[0]['file'])))
 {if ( (defined(('IMAGE_EDIT_OVERWRITE')) && IMAGE_EDIT_OVERWRITE))
 {if ( deAspis(Aspis_preg_match(array('/-e[0-9]{13}\./',false),$parts[0]['basename'])))
 {$delpath = apply_filters(array('wp_delete_file',false),$file);
@attAspis(unlink($delpath[0]));
}}else 
{{arrayAssign($backup_sizes[0],deAspis(registerTaint(concat1("full-",$suffix))),addTaint(array(array(deregisterTaint(array('width',false)) => addTaint($meta[0]['width']),deregisterTaint(array('height',false)) => addTaint($meta[0]['height']),deregisterTaint(array('file',false)) => addTaint($parts[0]['basename'])),false)));
}}}$restored_file = path_join($parts[0]['dirname'],$data[0]['file']);
$restored = update_attached_file($post_id,$restored_file);
arrayAssign($meta[0],deAspis(registerTaint(array('file',false))),addTaint(_wp_relative_upload_path($restored_file)));
arrayAssign($meta[0],deAspis(registerTaint(array('width',false))),addTaint($data[0]['width']));
arrayAssign($meta[0],deAspis(registerTaint(array('height',false))),addTaint($data[0]['height']));
list($uwidth,$uheight) = deAspisList(wp_shrink_dimensions($meta[0]['width'],$meta[0]['height']),array());
arrayAssign($meta[0],deAspis(registerTaint(array('hwstring_small',false))),addTaint(concat2(concat(concat2(concat1("height='",$uheight),"' width='"),$uwidth),"'")));
}foreach ( $default_sizes[0] as $default_size  )
{if ( ((isset($backup_sizes[0][(deconcat2($default_size,"-orig"))]) && Aspis_isset( $backup_sizes [0][(deconcat2( $default_size,"-orig"))]))))
 {$data = attachAspis($backup_sizes,(deconcat2($default_size,"-orig")));
if ( (((isset($meta[0][('sizes')][0][$default_size[0]]) && Aspis_isset( $meta [0][('sizes')] [0][$default_size[0]]))) && (deAspis($meta[0][('sizes')][0][$default_size[0]][0]['file']) != deAspis($data[0]['file']))))
 {if ( (defined(('IMAGE_EDIT_OVERWRITE')) && IMAGE_EDIT_OVERWRITE))
 {if ( deAspis(Aspis_preg_match(array('/-e[0-9]{13}-/',false),$meta[0][('sizes')][0][$default_size[0]][0]['file'])))
 {$delpath = apply_filters(array('wp_delete_file',false),path_join($parts[0]['dirname'],$meta[0][('sizes')][0][$default_size[0]][0]['file']));
@attAspis(unlink($delpath[0]));
}}else 
{{arrayAssign($backup_sizes[0],deAspis(registerTaint(concat(concat2($default_size,"-"),$suffix))),addTaint(attachAspis($meta[0][('sizes')],$default_size[0])));
}}}arrayAssign($meta[0][('sizes')][0],deAspis(registerTaint($default_size)),addTaint($data));
}else 
{{unset($meta[0][('sizes')][0][$default_size[0]]);
}}}if ( ((denot_boolean(wp_update_attachment_metadata($post_id,$meta))) || (denot_boolean(update_post_meta($post_id,array('_wp_attachment_backup_sizes',false),$backup_sizes)))))
 {$msg[0]->error = __(array('Cannot save image metadata.',false));
return $msg;
}if ( (denot_boolean($restored)))
 $msg[0]->error = __(array('Image metadata is inconsistent.',false));
else 
{$msg[0]->msg = __(array('Image restored successfully.',false));
}return $msg;
 }
function wp_save_image ( $post_id ) {
$return = array('',false);
$success = $delete = $scaled = $nocrop = array(false,false);
$post = get_post($post_id);
@array(ini_set('memory_limit','256M'),false);
$img = load_image_to_edit($post_id,$post[0]->post_mime_type);
if ( (!(is_resource(deAspisRC($img)))))
 {$return[0]->error = esc_js(__(array('Unable to create new image.',false)));
return $return;
}$fwidth = (!((empty($_REQUEST[0][('fwidth')]) || Aspis_empty( $_REQUEST [0][('fwidth')])))) ? Aspis_intval($_REQUEST[0]['fwidth']) : array(0,false);
$fheight = (!((empty($_REQUEST[0][('fheight')]) || Aspis_empty( $_REQUEST [0][('fheight')])))) ? Aspis_intval($_REQUEST[0]['fheight']) : array(0,false);
$target = (!((empty($_REQUEST[0][('target')]) || Aspis_empty( $_REQUEST [0][('target')])))) ? Aspis_preg_replace(array('/[^a-z0-9_-]+/i',false),array('',false),$_REQUEST[0]['target']) : array('',false);
$scale = array((!((empty($_REQUEST[0][('do')]) || Aspis_empty( $_REQUEST [0][('do')])))) && (('scale') == deAspis($_REQUEST[0]['do'])),false);
if ( (($scale[0] && ($fwidth[0] > (0))) && ($fheight[0] > (0))))
 {$sX = attAspis(imagesx($img[0]));
$sY = attAspis(imagesy($img[0]));
$diff = array(round(($sX[0] / $sY[0]),(2)) - round(($fwidth[0] / $fheight[0]),(2)),false);
if ( ((deAspis(negate(array(0.1,false))) < $diff[0]) && ($diff[0] < (0.1))))
 {$dst = wp_imagecreatetruecolor($fwidth,$fheight);
if ( imagecopyresampled($dst[0],$img[0],(0),(0),(0),(0),$fwidth[0],$fheight[0],$sX[0],$sY[0]))
 {imagedestroy($img[0]);
$img = $dst;
$scaled = array(true,false);
}}if ( (denot_boolean($scaled)))
 {$return[0]->error = esc_js(__(array('Error while saving the scaled image. Please reload the page and try again.',false)));
return $return;
}}elseif ( (!((empty($_REQUEST[0][('history')]) || Aspis_empty( $_REQUEST [0][('history')])))))
 {$changes = array(json_decode(deAspisRC(Aspis_stripslashes($_REQUEST[0]['history']))),false);
if ( $changes[0])
 $img = image_edit_apply_changes($img,$changes);
}else 
{{$return[0]->error = esc_js(__(array('Nothing to save, the image has not changed.',false)));
return $return;
}}$meta = wp_get_attachment_metadata($post_id);
$backup_sizes = get_post_meta($post[0]->ID,array('_wp_attachment_backup_sizes',false),array(true,false));
if ( (!(is_array($meta[0]))))
 {$return[0]->error = esc_js(__(array('Image data does not exist. Please re-upload the image.',false)));
return $return;
}if ( (!(is_array($backup_sizes[0]))))
 $backup_sizes = array(array(),false);
$path = get_attached_file($post_id);
$path_parts = pathinfo52($path);
$filename = $path_parts[0]['filename'];
$suffix = concat(attAspis(time()),attAspis(rand((100),(999))));
if ( (((defined(('IMAGE_EDIT_OVERWRITE')) && IMAGE_EDIT_OVERWRITE) && ((isset($backup_sizes[0][('full-orig')]) && Aspis_isset( $backup_sizes [0][('full-orig')])))) && (deAspis($backup_sizes[0][('full-orig')][0]['file']) != deAspis($path_parts[0]['basename']))))
 {if ( (('thumbnail') == $target[0]))
 $new_path = concat(concat2(concat(concat2($path_parts[0]['dirname'],"/"),$filename),"-temp."),$path_parts[0]['extension']);
else 
{$new_path = $path;
}}else 
{{while ( true )
{$filename = Aspis_preg_replace(array('/-e([0-9]+)$/',false),array('',false),$filename);
$filename = concat($filename,concat1("-e",$suffix));
$new_filename = concat(concat2($filename,"."),$path_parts[0]['extension']);
$new_path = concat(concat2($path_parts[0]['dirname'],"/"),$new_filename);
if ( file_exists($new_path[0]))
 postincr($suffix);
else 
{break ;
}}}}if ( (denot_boolean(wp_save_image_file($new_path,$img,$post[0]->post_mime_type,$post_id))))
 {$return[0]->error = esc_js(__(array('Unable to save the image.',false)));
return $return;
}if ( ((((('nothumb') == $target[0]) || (('all') == $target[0])) || (('full') == $target[0])) || $scaled[0]))
 {$tag = array(false,false);
if ( ((isset($backup_sizes[0][('full-orig')]) && Aspis_isset( $backup_sizes [0][('full-orig')]))))
 {if ( (((!(defined(('IMAGE_EDIT_OVERWRITE')))) || (!(IMAGE_EDIT_OVERWRITE))) && (deAspis($backup_sizes[0][('full-orig')][0]['file']) != deAspis($path_parts[0]['basename']))))
 $tag = concat1("full-",$suffix);
}else 
{{$tag = array('full-orig',false);
}}if ( $tag[0])
 arrayAssign($backup_sizes[0],deAspis(registerTaint($tag)),addTaint(array(array(deregisterTaint(array('width',false)) => addTaint($meta[0]['width']),deregisterTaint(array('height',false)) => addTaint($meta[0]['height']),deregisterTaint(array('file',false)) => addTaint($path_parts[0]['basename'])),false)));
$success = update_attached_file($post_id,$new_path);
arrayAssign($meta[0],deAspis(registerTaint(array('file',false))),addTaint(_wp_relative_upload_path($new_path)));
arrayAssign($meta[0],deAspis(registerTaint(array('width',false))),addTaint(attAspis(imagesx($img[0]))));
arrayAssign($meta[0],deAspis(registerTaint(array('height',false))),addTaint(attAspis(imagesy($img[0]))));
list($uwidth,$uheight) = deAspisList(wp_shrink_dimensions($meta[0]['width'],$meta[0]['height']),array());
arrayAssign($meta[0],deAspis(registerTaint(array('hwstring_small',false))),addTaint(concat2(concat(concat2(concat1("height='",$uheight),"' width='"),$uwidth),"'")));
if ( ($success[0] && ((('nothumb') == $target[0]) || (('all') == $target[0]))))
 {$sizes = apply_filters(array('intermediate_image_sizes',false),array(array(array('large',false),array('medium',false),array('thumbnail',false)),false));
if ( (('nothumb') == $target[0]))
 $sizes = Aspis_array_diff($sizes,array(array(array('thumbnail',false)),false));
}$return[0]->fw = $meta[0]['width'];
$return[0]->fh = $meta[0]['height'];
}elseif ( (('thumbnail') == $target[0]))
 {$sizes = array(array(array('thumbnail',false)),false);
$success = $delete = $nocrop = array(true,false);
}if ( ((isset($sizes) && Aspis_isset( $sizes))))
 {foreach ( $sizes[0] as $size  )
{$tag = array(false,false);
if ( ((isset($meta[0][('sizes')][0][$size[0]]) && Aspis_isset( $meta [0][('sizes')] [0][$size[0]]))))
 {if ( ((isset($backup_sizes[0][(deconcat2($size,"-orig"))]) && Aspis_isset( $backup_sizes [0][(deconcat2( $size,"-orig"))]))))
 {if ( (((!(defined(('IMAGE_EDIT_OVERWRITE')))) || (!(IMAGE_EDIT_OVERWRITE))) && (deAspis($backup_sizes[0][(deconcat2($size,"-orig"))][0]['file']) != deAspis($meta[0][('sizes')][0][$size[0]][0]['file']))))
 $tag = concat(concat2($size,"-"),$suffix);
}else 
{{$tag = concat2($size,"-orig");
}}if ( $tag[0])
 arrayAssign($backup_sizes[0],deAspis(registerTaint($tag)),addTaint(attachAspis($meta[0][('sizes')],$size[0])));
}$crop = $nocrop[0] ? array(false,false) : get_option(concat2($size,"_crop"));
$resized = image_make_intermediate_size($new_path,get_option(concat2($size,"_size_w")),get_option(concat2($size,"_size_h")),$crop);
if ( $resized[0])
 arrayAssign($meta[0][('sizes')][0],deAspis(registerTaint($size)),addTaint($resized));
else 
{unset($meta[0][('sizes')][0][$size[0]]);
}}}if ( $success[0])
 {wp_update_attachment_metadata($post_id,$meta);
update_post_meta($post_id,array('_wp_attachment_backup_sizes',false),$backup_sizes);
if ( ((($target[0] == ('thumbnail')) || ($target[0] == ('all'))) || ($target[0] == ('full'))))
 {$file_url = wp_get_attachment_url($post_id);
if ( deAspis($thumb = $meta[0][('sizes')][0]['thumbnail']))
 $return[0]->thumbnail = path_join(Aspis_dirname($file_url),$thumb[0]['file']);
else 
{$return[0]->thumbnail = concat2($file_url,"?w=128&h=128");
}}}else 
{{$delete = array(true,false);
}}if ( $delete[0])
 {$delpath = apply_filters(array('wp_delete_file',false),$new_path);
@attAspis(unlink($delpath[0]));
}imagedestroy($img[0]);
$return[0]->msg = esc_js(__(array('Image saved',false)));
return $return;
 }
