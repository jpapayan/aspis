<?php require_once('AspisMain.php'); ?><?php
class Custom_Image_Header{var $admin_header_callback;
function Custom_Image_Header ( $admin_header_callback ) {
{$this->admin_header_callback = $admin_header_callback;
} }
function init (  ) {
{$page = add_theme_page(__('Custom Header'),__('Custom Header'),'edit_themes','custom-header',array($this,'admin_page'));
add_action("admin_print_scripts-$page",array($this,'js_includes'));
add_action("admin_print_styles-$page",array($this,'css_includes'));
add_action("admin_head-$page",array($this,'take_action'),50);
add_action("admin_head-$page",array($this,'js'),50);
add_action("admin_head-$page",$this->admin_header_callback,51);
} }
function step (  ) {
{if ( !(isset($_GET[0]['step']) && Aspis_isset($_GET[0]['step'])))
 {$AspisRetTemp = 1;
return $AspisRetTemp;
}$step = (int)deAspisWarningRC($_GET[0]['step']);
if ( $step < 1 || 3 < $step)
 $step = 1;
{$AspisRetTemp = $step;
return $AspisRetTemp;
}} }
function js_includes (  ) {
{$step = $this->step();
if ( 1 == $step)
 wp_enqueue_script('farbtastic');
elseif ( 2 == $step)
 wp_enqueue_script('jcrop');
} }
function css_includes (  ) {
{$step = $this->step();
if ( 1 == $step)
 wp_enqueue_style('farbtastic');
elseif ( 2 == $step)
 wp_enqueue_style('jcrop');
} }
function take_action (  ) {
{if ( (isset($_POST[0]['textcolor']) && Aspis_isset($_POST[0]['textcolor'])))
 {check_admin_referer('custom-header');
if ( 'blank' == deAspisWarningRC($_POST[0]['textcolor']))
 {set_theme_mod('header_textcolor','blank');
}else 
{{$color = preg_replace('/[^0-9a-fA-F]/','',deAspisWarningRC($_POST[0]['textcolor']));
if ( strlen($color) == 6 || strlen($color) == 3)
 set_theme_mod('header_textcolor',$color);
}}}if ( (isset($_POST[0]['resetheader']) && Aspis_isset($_POST[0]['resetheader'])))
 {check_admin_referer('custom-header');
remove_theme_mods();
}} }
function js (  ) {
{$step = $this->step();
if ( 1 == $step)
 $this->js_1();
elseif ( 2 == $step)
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
		pickColor('#<?php echo get_theme_mod('header_textcolor',HEADER_TEXTCOLOR);
;
?>');

		<?php if ( 'blank' == get_theme_mod('header_textcolor',HEADER_TEXTCOLOR))
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
		pickColor('#<?php echo HEADER_TEXTCOLOR;
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
			jQuery('#textcolor').val('<?php echo HEADER_TEXTCOLOR;
;
?>');
			jQuery('#hidetext').val('<?php _e('Hide Text');
;
?>');
		}
		else {
			//Hide text
			jQuery( buttons.toString() ).hide();
			jQuery('#textcolor').val('blank');
			jQuery('#hidetext').val('<?php _e('Show Text');
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
		var xinit = <?php echo HEADER_IMAGE_WIDTH;
;
?>;
		var yinit = <?php echo HEADER_IMAGE_HEIGHT;
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
{if ( deAspisWarningRC($_GET[0]['updated']))
 {;
?>
<div id="message" class="updated fade">
<p><?php _e('Header updated.');
?></p>
</div>
		<?php };
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e('Your Header Image');
;
?></h2>
<p><?php _e('This is your header image. You can change the text color or upload and crop a new image.');
;
?></p>

<div id="headimg" style="background-image: url(<?php esc_url(header_image());
?>);">
<h1><a onclick="return false;" href="<?php bloginfo('url');
;
?>" title="<?php bloginfo('name');
;
?>" id="name"><?php bloginfo('name');
;
?></a></h1>
<div id="desc"><?php bloginfo('description');
;
?></div>
</div>
<?php if ( !defined('NO_HEADER_TEXT'))
 {;
?>
<form method="post" action="<?php echo admin_url('themes.php?page=custom-header&amp;updated=true');
?>">
<input type="button" class="button" value="<?php esc_attr_e('Hide Text');
;
?>" onclick="hide_text()" id="hidetext" />
<input type="button" class="button" value="<?php esc_attr_e('Select a Text Color');
;
?>" id="pickcolor" /><input type="button" class="button" value="<?php esc_attr_e('Use Original Color');
;
?>" onclick="colorDefault()" id="defaultcolor" />
<?php wp_nonce_field('custom-header');
?>
<input type="hidden" name="textcolor" id="textcolor" value="#<?php esc_attr(header_textcolor());
?>" /><input name="submit" type="submit" class="button" value="<?php esc_attr_e('Save Changes');
;
?>" /></form>
<?php };
?>

<div id="colorPickerDiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"> </div>
</div>
<div class="wrap">
<h2><?php _e('Upload New Header Image');
;
?></h2><p><?php _e('Here you can upload a custom header image to be shown at the top of your blog instead of the default one. On the next screen you will be able to crop the image.');
;
?></p>
<p><?php printf(__('Images of exactly <strong>%1$d x %2$d pixels</strong> will be used as-is.'),HEADER_IMAGE_WIDTH,HEADER_IMAGE_HEIGHT);
;
?></p>

<form enctype="multipart/form-data" id="uploadForm" method="POST" action="<?php echo esc_attr(add_query_arg('step',2));
?>" style="margin: auto; width: 50%;">
<label for="upload"><?php _e('Choose an image from your computer:');
;
?></label><br /><input type="file" id="upload" name="import" />
<input type="hidden" name="action" value="save" />
<?php wp_nonce_field('custom-header');
?>
<p class="submit">
<input type="submit" value="<?php esc_attr_e('Upload');
;
?>" />
</p>
</form>

</div>

		<?php if ( get_theme_mod('header_image') || get_theme_mod('header_textcolor'))
 {;
?>
<div class="wrap">
<h2><?php _e('Reset Header Image and Color');
;
?></h2>
<p><?php _e('This will restore the original header image and color. You will not be able to retrieve any customizations.');
?></p>
<form method="post" action="<?php echo esc_attr(add_query_arg('step',1));
?>">
<?php wp_nonce_field('custom-header');
;
?>
<input type="submit" class="button" name="resetheader" value="<?php esc_attr_e('Restore Original Header');
;
?>" />
</form>
</div>
		<?php }} }
function step_2 (  ) {
{check_admin_referer('custom-header');
$overrides = array('test_form' => false);
$file = wp_handle_upload(deAspisWarningRC($_FILES[0]['import']),$overrides);
if ( isset($file['error']))
 exit($file['error']);
$url = $file['url'];
$type = $file['type'];
$file = $file['file'];
$filename = basename($file);
$object = array('post_title' => $filename,'post_content' => $url,'post_mime_type' => $type,'guid' => $url);
$id = wp_insert_attachment($object,$file);
list($width,$height,$type,$attr) = getimagesize($file);
if ( $width == HEADER_IMAGE_WIDTH && $height == HEADER_IMAGE_HEIGHT)
 {wp_update_attachment_metadata($id,wp_generate_attachment_metadata($id,$file));
set_theme_mod('header_image',esc_url($url));
do_action('wp_create_file_in_uploads',$file,$id);
{$AspisRetTemp = $this->finished();
return $AspisRetTemp;
}}elseif ( $width > HEADER_IMAGE_WIDTH)
 {$oitar = $width / HEADER_IMAGE_WIDTH;
$image = wp_crop_image($file,0,0,$width,$height,HEADER_IMAGE_WIDTH,$height / $oitar,false,str_replace(basename($file),'midsize-' . basename($file),$file));
$image = apply_filters('wp_create_file_in_uploads',$image,$id);
$url = str_replace(basename($url),basename($image),$url);
$width = $width / $oitar;
$height = $height / $oitar;
}else 
{{$oitar = 1;
}};
?>

<div class="wrap">

<form method="POST" action="<?php echo esc_attr(add_query_arg('step',3));
?>">

<p><?php _e('Choose the part of the image you want to use as your header.');
;
?></p>
<div id="testWrap" style="position: relative">
<img src="<?php echo $url;
;
?>" id="upload" width="<?php echo $width;
;
?>" height="<?php echo $height;
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
<input type="hidden" name="attachment_id" id="attachment_id" value="<?php echo esc_attr($id);
;
?>" />
<input type="hidden" name="oitar" id="oitar" value="<?php echo esc_attr($oitar);
;
?>" />
<?php wp_nonce_field('custom-header');
?>
<input type="submit" value="<?php esc_attr_e('Crop Header');
;
?>" />
</p>

</form>
</div>
		<?php } }
function step_3 (  ) {
{check_admin_referer('custom-header');
if ( deAspisWarningRC($_POST[0]['oitar']) > 1)
 {$_POST[0]['x1'] = attAspisRCO(deAspisWarningRC($_POST[0]['x1']) * deAspisWarningRC($_POST[0]['oitar']));
$_POST[0]['y1'] = attAspisRCO(deAspisWarningRC($_POST[0]['y1']) * deAspisWarningRC($_POST[0]['oitar']));
$_POST[0]['width'] = attAspisRCO(deAspisWarningRC($_POST[0]['width']) * deAspisWarningRC($_POST[0]['oitar']));
$_POST[0]['height'] = attAspisRCO(deAspisWarningRC($_POST[0]['height']) * deAspisWarningRC($_POST[0]['oitar']));
}$original = get_attached_file(deAspisWarningRC($_POST[0]['attachment_id']));
$cropped = wp_crop_image(deAspisWarningRC($_POST[0]['attachment_id']),deAspisWarningRC($_POST[0]['x1']),deAspisWarningRC($_POST[0]['y1']),deAspisWarningRC($_POST[0]['width']),deAspisWarningRC($_POST[0]['height']),HEADER_IMAGE_WIDTH,HEADER_IMAGE_HEIGHT);
$cropped = apply_filters('wp_create_file_in_uploads',$cropped,deAspisWarningRC($_POST[0]['attachment_id']));
$parent = get_post(deAspisWarningRC($_POST[0]['attachment_id']));
$parent_url = $parent->guid;
$url = str_replace(basename($parent_url),basename($cropped),$parent_url);
$object = array('ID' => deAspisWarningRC($_POST[0]['attachment_id']),'post_title' => basename($cropped),'post_content' => $url,'post_mime_type' => 'image/jpeg','guid' => $url);
wp_insert_attachment($object,$cropped);
wp_update_attachment_metadata(deAspisWarningRC($_POST[0]['attachment_id']),wp_generate_attachment_metadata(deAspisWarningRC($_POST[0]['attachment_id']),$cropped));
set_theme_mod('header_image',$url);
$medium = str_replace(basename($original),'midsize-' . basename($original),$original);
@unlink(apply_filters('wp_delete_file',$medium));
@unlink(apply_filters('wp_delete_file',$original));
{$AspisRetTemp = $this->finished();
return $AspisRetTemp;
}} }
function finished (  ) {
{;
?>
<div class="wrap">
<h2><?php _e('Header complete!');
;
?></h2>

<p><?php _e('Visit your site and you should see the new header now.');
;
?></p>

</div>
		<?php } }
function admin_page (  ) {
{$step = $this->step();
if ( 1 == $step)
 $this->step_1();
elseif ( 2 == $step)
 $this->step_2();
elseif ( 3 == $step)
 $this->step_3();
} }
};
?>
<?php 