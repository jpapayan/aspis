<?php require_once('AspisMain.php'); ?><?php
class Custom_Image_Header{var $admin_header_callback;
function Custom_Image_Header ( $admin_header_callback ) {
{$this->admin_header_callback = $admin_header_callback;
} }
function init (  ) {
{$page = add_theme_page(__(array('Custom Header',false)),__(array('Custom Header',false)),array('edit_themes',false),array('custom-header',false),array(array(array($this,false),array('admin_page',false)),false));
add_action(concat1("admin_print_scripts-",$page),array(array(array($this,false),array('js_includes',false)),false));
add_action(concat1("admin_print_styles-",$page),array(array(array($this,false),array('css_includes',false)),false));
add_action(concat1("admin_head-",$page),array(array(array($this,false),array('take_action',false)),false),array(50,false));
add_action(concat1("admin_head-",$page),array(array(array($this,false),array('js',false)),false),array(50,false));
add_action(concat1("admin_head-",$page),$this->admin_header_callback,array(51,false));
} }
function step (  ) {
{if ( (!((isset($_GET[0][('step')]) && Aspis_isset( $_GET [0][('step')])))))
 return array(1,false);
$step = int_cast($_GET[0]['step']);
if ( (($step[0] < (1)) || ((3) < $step[0])))
 $step = array(1,false);
return $step;
} }
function js_includes (  ) {
{$step = $this->step();
if ( ((1) == $step[0]))
 wp_enqueue_script(array('farbtastic',false));
elseif ( ((2) == $step[0]))
 wp_enqueue_script(array('jcrop',false));
} }
function css_includes (  ) {
{$step = $this->step();
if ( ((1) == $step[0]))
 wp_enqueue_style(array('farbtastic',false));
elseif ( ((2) == $step[0]))
 wp_enqueue_style(array('jcrop',false));
} }
function take_action (  ) {
{if ( ((isset($_POST[0][('textcolor')]) && Aspis_isset( $_POST [0][('textcolor')]))))
 {check_admin_referer(array('custom-header',false));
if ( (('blank') == deAspis($_POST[0]['textcolor'])))
 {set_theme_mod(array('header_textcolor',false),array('blank',false));
}else 
{{$color = Aspis_preg_replace(array('/[^0-9a-fA-F]/',false),array('',false),$_POST[0]['textcolor']);
if ( ((strlen($color[0]) == (6)) || (strlen($color[0]) == (3))))
 set_theme_mod(array('header_textcolor',false),$color);
}}}if ( ((isset($_POST[0][('resetheader')]) && Aspis_isset( $_POST [0][('resetheader')]))))
 {check_admin_referer(array('custom-header',false));
remove_theme_mods();
}} }
function js (  ) {
{$step = $this->step();
if ( ((1) == $step[0]))
 $this->js_1();
elseif ( ((2) == $step[0]))
 $this->js_2();
} }
function js_1 (  ) {
{;
?>
<script type="text/javascript">
	var buttons = ['#name', '#desc', '#pickcolor', '#defaultcolor'];
	var farbtastic;

	function pickColor(color) {
		jQuery('#name').css('color', color);
		jQuery('#desc').css('color', color);
		jQuery('#textcolor').val(color);
		farbtastic.setColor(color);
	}

	jQuery(document).ready(function() {
		jQuery('#pickcolor').click(function() {
			jQuery('#colorPickerDiv').show();
		});

		jQuery('#hidetext').click(function() {
			toggle_text();
		});

		farbtastic = jQuery.farbtastic('#colorPickerDiv', function(color) { pickColor(color); });
		pickColor('#<?php echo AspisCheckPrint(get_theme_mod(array('header_textcolor',false),array(HEADER_TEXTCOLOR,false)));
;
?>');

		<?php if ( (('blank') == deAspis(get_theme_mod(array('header_textcolor',false),array(HEADER_TEXTCOLOR,false)))))
 {;
?>
		toggle_text();
		<?php };
?>
	});

	jQuery(document).mousedown(function(){
		// Make the picker disappear, since we're using it in an independant div
		hide_picker();
	});

	function colorDefault() {
		pickColor('#<?php echo AspisCheckPrint(array(HEADER_TEXTCOLOR,false));
;
?>');
	}

	function hide_picker(what) {
		var update = false;
		jQuery('#colorPickerDiv').each(function(){
			var id = jQuery(this).attr('id');
			if (id == what) {
				return;
			}
			var display = jQuery(this).css('display');
			if (display == 'block') {
				jQuery(this).fadeOut(2);
			}
		});
	}

	function toggle_text(force) {
		if(jQuery('#textcolor').val() == 'blank') {
			//Show text
			jQuery( buttons.toString() ).show();
			jQuery('#textcolor').val('<?php echo AspisCheckPrint(array(HEADER_TEXTCOLOR,false));
;
?>');
			jQuery('#hidetext').val('<?php _e(array('Hide Text',false));
;
?>');
		}
		else {
			//Hide text
			jQuery( buttons.toString() ).hide();
			jQuery('#textcolor').val('blank');
			jQuery('#hidetext').val('<?php _e(array('Show Text',false));
;
?>');
		}
	}



</script>
<?php } }
function js_2 (  ) {
{;
?>
<script type="text/javascript">
	function onEndCrop( coords ) {
		jQuery( '#x1' ).val(coords.x);
		jQuery( '#y1' ).val(coords.y);
		jQuery( '#x2' ).val(coords.x2);
		jQuery( '#y2' ).val(coords.y2);
		jQuery( '#width' ).val(coords.w);
		jQuery( '#height' ).val(coords.h);
	}

	// with a supplied ratio
	jQuery(document).ready(function() {
		var xinit = <?php echo AspisCheckPrint(array(HEADER_IMAGE_WIDTH,false));
;
?>;
		var yinit = <?php echo AspisCheckPrint(array(HEADER_IMAGE_HEIGHT,false));
;
?>;
		var ratio = xinit / yinit;
		var ximg = jQuery('#upload').width();
		var yimg = jQuery('#upload').height();

		//set up default values
		jQuery( '#x1' ).val(0);
		jQuery( '#y1' ).val(0);
		jQuery( '#x2' ).val(xinit);
		jQuery( '#y2' ).val(yinit);
		jQuery( '#width' ).val(xinit);
		jQuery( '#height' ).val(yinit);

		if ( yimg < yinit || ximg < xinit ) {
			if ( ximg / yimg > ratio ) {
				yinit = yimg;
				xinit = yinit * ratio;
			} else {
				xinit = ximg;
				yinit = xinit / ratio;
			}
		}

		jQuery('#upload').Jcrop({
			aspectRatio: ratio,
			setSelect: [ 0, 0, xinit, yinit ],
			onSelect: onEndCrop
		});
	});
</script>
<?php } }
function step_1 (  ) {
{if ( deAspis($_GET[0]['updated']))
 {;
?>
<div id="message" class="updated fade">
<p><?php _e(array('Header updated.',false));
?></p>
</div>
		<?php };
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e(array('Your Header Image',false));
;
?></h2>
<p><?php _e(array('This is your header image. You can change the text color or upload and crop a new image.',false));
;
?></p>

<div id="headimg" style="background-image: url(<?php esc_url(header_image());
?>);">
<h1><a onclick="return false;" href="<?php bloginfo(array('url',false));
;
?>" title="<?php bloginfo(array('name',false));
;
?>" id="name"><?php bloginfo(array('name',false));
;
?></a></h1>
<div id="desc"><?php bloginfo(array('description',false));
;
?></div>
</div>
<?php if ( (!(defined(('NO_HEADER_TEXT')))))
 {;
?>
<form method="post" action="<?php echo AspisCheckPrint(admin_url(array('themes.php?page=custom-header&amp;updated=true',false)));
?>">
<input type="button" class="button" value="<?php esc_attr_e(array('Hide Text',false));
;
?>" onclick="hide_text()" id="hidetext" />
<input type="button" class="button" value="<?php esc_attr_e(array('Select a Text Color',false));
;
?>" id="pickcolor" /><input type="button" class="button" value="<?php esc_attr_e(array('Use Original Color',false));
;
?>" onclick="colorDefault()" id="defaultcolor" />
<?php wp_nonce_field(array('custom-header',false));
?>
<input type="hidden" name="textcolor" id="textcolor" value="#<?php esc_attr(header_textcolor());
?>" /><input name="submit" type="submit" class="button" value="<?php esc_attr_e(array('Save Changes',false));
;
?>" /></form>
<?php };
?>

<div id="colorPickerDiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"> </div>
</div>
<div class="wrap">
<h2><?php _e(array('Upload New Header Image',false));
;
?></h2><p><?php _e(array('Here you can upload a custom header image to be shown at the top of your blog instead of the default one. On the next screen you will be able to crop the image.',false));
;
?></p>
<p><?php printf(deAspis(__(array('Images of exactly <strong>%1$d x %2$d pixels</strong> will be used as-is.',false))),HEADER_IMAGE_WIDTH,HEADER_IMAGE_HEIGHT);
;
?></p>

<form enctype="multipart/form-data" id="uploadForm" method="POST" action="<?php echo AspisCheckPrint(esc_attr(add_query_arg(array('step',false),array(2,false))));
?>" style="margin: auto; width: 50%;">
<label for="upload"><?php _e(array('Choose an image from your computer:',false));
;
?></label><br /><input type="file" id="upload" name="import" />
<input type="hidden" name="action" value="save" />
<?php wp_nonce_field(array('custom-header',false));
?>
<p class="submit">
<input type="submit" value="<?php esc_attr_e(array('Upload',false));
;
?>" />
</p>
</form>

</div>

		<?php if ( (deAspis(get_theme_mod(array('header_image',false))) || deAspis(get_theme_mod(array('header_textcolor',false)))))
 {;
?>
<div class="wrap">
<h2><?php _e(array('Reset Header Image and Color',false));
;
?></h2>
<p><?php _e(array('This will restore the original header image and color. You will not be able to retrieve any customizations.',false));
?></p>
<form method="post" action="<?php echo AspisCheckPrint(esc_attr(add_query_arg(array('step',false),array(1,false))));
?>">
<?php wp_nonce_field(array('custom-header',false));
;
?>
<input type="submit" class="button" name="resetheader" value="<?php esc_attr_e(array('Restore Original Header',false));
;
?>" />
</form>
</div>
		<?php }} }
function step_2 (  ) {
{check_admin_referer(array('custom-header',false));
$overrides = array(array('test_form' => array(false,false,false)),false);
$file = wp_handle_upload($_FILES[0]['import'],$overrides);
if ( ((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))))
 Aspis_exit($file[0]['error']);
$url = $file[0]['url'];
$type = $file[0]['type'];
$file = $file[0]['file'];
$filename = Aspis_basename($file);
$object = array(array(deregisterTaint(array('post_title',false)) => addTaint($filename),deregisterTaint(array('post_content',false)) => addTaint($url),deregisterTaint(array('post_mime_type',false)) => addTaint($type),deregisterTaint(array('guid',false)) => addTaint($url)),false);
$id = wp_insert_attachment($object,$file);
list($width,$height,$type,$attr) = deAspisList(attAspisRC(getimagesize($file[0])),array());
if ( (($width[0] == HEADER_IMAGE_WIDTH) && ($height[0] == HEADER_IMAGE_HEIGHT)))
 {wp_update_attachment_metadata($id,wp_generate_attachment_metadata($id,$file));
set_theme_mod(array('header_image',false),esc_url($url));
do_action(array('wp_create_file_in_uploads',false),$file,$id);
return $this->finished();
}elseif ( ($width[0] > HEADER_IMAGE_WIDTH))
 {$oitar = array($width[0] / HEADER_IMAGE_WIDTH,false);
$image = wp_crop_image($file,array(0,false),array(0,false),$width,$height,array(HEADER_IMAGE_WIDTH,false),array($height[0] / $oitar[0],false),array(false,false),Aspis_str_replace(Aspis_basename($file),concat1('midsize-',Aspis_basename($file)),$file));
$image = apply_filters(array('wp_create_file_in_uploads',false),$image,$id);
$url = Aspis_str_replace(Aspis_basename($url),Aspis_basename($image),$url);
$width = array($width[0] / $oitar[0],false);
$height = array($height[0] / $oitar[0],false);
}else 
{{$oitar = array(1,false);
}};
?>

<div class="wrap">

<form method="POST" action="<?php echo AspisCheckPrint(esc_attr(add_query_arg(array('step',false),array(3,false))));
?>">

<p><?php _e(array('Choose the part of the image you want to use as your header.',false));
;
?></p>
<div id="testWrap" style="position: relative">
<img src="<?php echo AspisCheckPrint($url);
;
?>" id="upload" width="<?php echo AspisCheckPrint($width);
;
?>" height="<?php echo AspisCheckPrint($height);
;
?>" />
</div>

<p class="submit">
<input type="hidden" name="x1" id="x1" />
<input type="hidden" name="y1" id="y1" />
<input type="hidden" name="x2" id="x2" />
<input type="hidden" name="y2" id="y2" />
<input type="hidden" name="width" id="width" />
<input type="hidden" name="height" id="height" />
<input type="hidden" name="attachment_id" id="attachment_id" value="<?php echo AspisCheckPrint(esc_attr($id));
;
?>" />
<input type="hidden" name="oitar" id="oitar" value="<?php echo AspisCheckPrint(esc_attr($oitar));
;
?>" />
<?php wp_nonce_field(array('custom-header',false));
?>
<input type="submit" value="<?php esc_attr_e(array('Crop Header',false));
;
?>" />
</p>

</form>
</div>
		<?php } }
function step_3 (  ) {
{check_admin_referer(array('custom-header',false));
if ( (deAspis($_POST[0]['oitar']) > (1)))
 {arrayAssign($_POST[0],deAspis(registerTaint(array('x1',false))),addTaint(array(deAspis($_POST[0]['x1']) * deAspis($_POST[0]['oitar']),false)));
arrayAssign($_POST[0],deAspis(registerTaint(array('y1',false))),addTaint(array(deAspis($_POST[0]['y1']) * deAspis($_POST[0]['oitar']),false)));
arrayAssign($_POST[0],deAspis(registerTaint(array('width',false))),addTaint(array(deAspis($_POST[0]['width']) * deAspis($_POST[0]['oitar']),false)));
arrayAssign($_POST[0],deAspis(registerTaint(array('height',false))),addTaint(array(deAspis($_POST[0]['height']) * deAspis($_POST[0]['oitar']),false)));
}$original = get_attached_file($_POST[0]['attachment_id']);
$cropped = wp_crop_image($_POST[0]['attachment_id'],$_POST[0]['x1'],$_POST[0]['y1'],$_POST[0]['width'],$_POST[0]['height'],array(HEADER_IMAGE_WIDTH,false),array(HEADER_IMAGE_HEIGHT,false));
$cropped = apply_filters(array('wp_create_file_in_uploads',false),$cropped,$_POST[0]['attachment_id']);
$parent = get_post($_POST[0]['attachment_id']);
$parent_url = $parent[0]->guid;
$url = Aspis_str_replace(Aspis_basename($parent_url),Aspis_basename($cropped),$parent_url);
$object = array(array(deregisterTaint(array('ID',false)) => addTaint($_POST[0]['attachment_id']),deregisterTaint(array('post_title',false)) => addTaint(Aspis_basename($cropped)),deregisterTaint(array('post_content',false)) => addTaint($url),'post_mime_type' => array('image/jpeg',false,false),deregisterTaint(array('guid',false)) => addTaint($url)),false);
wp_insert_attachment($object,$cropped);
wp_update_attachment_metadata($_POST[0]['attachment_id'],wp_generate_attachment_metadata($_POST[0]['attachment_id'],$cropped));
set_theme_mod(array('header_image',false),$url);
$medium = Aspis_str_replace(Aspis_basename($original),concat1('midsize-',Aspis_basename($original)),$original);
@attAspis(unlink(deAspis(apply_filters(array('wp_delete_file',false),$medium))));
@attAspis(unlink(deAspis(apply_filters(array('wp_delete_file',false),$original))));
return $this->finished();
} }
function finished (  ) {
{;
?>
<div class="wrap">
<h2><?php _e(array('Header complete!',false));
;
?></h2>

<p><?php _e(array('Visit your site and you should see the new header now.',false));
;
?></p>

</div>
		<?php } }
function admin_page (  ) {
{$step = $this->step();
if ( ((1) == $step[0]))
 $this->step_1();
elseif ( ((2) == $step[0]))
 $this->step_2();
elseif ( ((3) == $step[0]))
 $this->step_3();
} }
};
?>
<?php 