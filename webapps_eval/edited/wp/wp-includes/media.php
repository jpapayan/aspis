<?php require_once('AspisMain.php'); ?><?php
function image_constrain_size_for_editor ( $width,$height,$size = array('medium',false) ) {
global $content_width,$_wp_additional_image_sizes;
if ( is_array($size[0]))
 {$max_width = attachAspis($size,(0));
$max_height = attachAspis($size,(1));
}elseif ( (($size[0] == ('thumb')) || ($size[0] == ('thumbnail'))))
 {$max_width = Aspis_intval(get_option(array('thumbnail_size_w',false)));
$max_height = Aspis_intval(get_option(array('thumbnail_size_h',false)));
if ( ((denot_boolean($max_width)) && (denot_boolean($max_height))))
 {$max_width = array(128,false);
$max_height = array(96,false);
}}elseif ( ($size[0] == ('medium')))
 {$max_width = Aspis_intval(get_option(array('medium_size_w',false)));
$max_height = Aspis_intval(get_option(array('medium_size_h',false)));
}elseif ( ($size[0] == ('large')))
 {$max_width = Aspis_intval(get_option(array('large_size_w',false)));
$max_height = Aspis_intval(get_option(array('large_size_h',false)));
if ( (deAspis(Aspis_intval($content_width)) > (0)))
 $max_width = attAspisRC(min(deAspisRC(Aspis_intval($content_width)),deAspisRC($max_width)));
}elseif ( ((((isset($_wp_additional_image_sizes) && Aspis_isset( $_wp_additional_image_sizes))) && count($_wp_additional_image_sizes[0])) && deAspis(Aspis_in_array($size,attAspisRC(array_keys(deAspisRC($_wp_additional_image_sizes)))))))
 {$max_width = Aspis_intval($_wp_additional_image_sizes[0][$size[0]][0]['width']);
$max_height = Aspis_intval($_wp_additional_image_sizes[0][$size[0]][0]['height']);
if ( (deAspis(Aspis_intval($content_width)) > (0)))
 $max_width = attAspisRC(min(deAspisRC(Aspis_intval($content_width)),deAspisRC($max_width)));
}else 
{{$max_width = $width;
$max_height = $height;
}}list($max_width,$max_height) = deAspisList(apply_filters(array('editor_max_image_size',false),array(array($max_width,$max_height),false),$size),array());
return wp_constrain_dimensions($width,$height,$max_width,$max_height);
 }
function image_hwstring ( $width,$height ) {
$out = array('',false);
if ( $width[0])
 $out = concat($out,concat2(concat1('width="',Aspis_intval($width)),'" '));
if ( $height[0])
 $out = concat($out,concat2(concat1('height="',Aspis_intval($height)),'" '));
return $out;
 }
function image_downsize ( $id,$size = array('medium',false) ) {
if ( (denot_boolean(wp_attachment_is_image($id))))
 return array(false,false);
$img_url = wp_get_attachment_url($id);
$meta = wp_get_attachment_metadata($id);
$width = $height = array(0,false);
$is_intermediate = array(false,false);
if ( deAspis($out = apply_filters(array('image_downsize',false),array(false,false),$id,$size)))
 return $out;
if ( deAspis($intermediate = image_get_intermediate_size($id,$size)))
 {$img_url = Aspis_str_replace(Aspis_basename($img_url),$intermediate[0]['file'],$img_url);
$width = $intermediate[0]['width'];
$height = $intermediate[0]['height'];
$is_intermediate = array(true,false);
}elseif ( ($size[0] == ('thumbnail')))
 {if ( (deAspis(($thumb_file = wp_get_attachment_thumb_file($id))) && deAspis($info = attAspisRC(getimagesize($thumb_file[0])))))
 {$img_url = Aspis_str_replace(Aspis_basename($img_url),Aspis_basename($thumb_file),$img_url);
$width = attachAspis($info,(0));
$height = attachAspis($info,(1));
$is_intermediate = array(true,false);
}}if ( (((denot_boolean($width)) && (denot_boolean($height))) && ((isset($meta[0][('width')],$meta[0][('height')]) && Aspis_isset( $meta [0][('width')],$meta [0][('height')])))))
 {$width = $meta[0]['width'];
$height = $meta[0]['height'];
}if ( $img_url[0])
 {list($width,$height) = deAspisList(image_constrain_size_for_editor($width,$height,$size),array());
return array(array($img_url,$width,$height,$is_intermediate),false);
}return array(false,false);
 }
function add_image_size ( $name,$width = array(0,false),$height = array(0,false),$crop = array(FALSE,false) ) {
global $_wp_additional_image_sizes;
arrayAssign($_wp_additional_image_sizes[0],deAspis(registerTaint($name)),addTaint(array(array(deregisterTaint(array('width',false)) => addTaint(absint($width)),deregisterTaint(array('height',false)) => addTaint(absint($height)),deregisterTaint(array('crop',false)) => addTaint(not_boolean(not_boolean($crop)))),false)));
 }
function set_post_thumbnail_size ( $width = array(0,false),$height = array(0,false),$crop = array(FALSE,false) ) {
add_image_size(array('post-thumbnail',false),$width,$height,$crop);
 }
function get_image_tag ( $id,$alt,$title,$align,$size = array('medium',false) ) {
list($img_src,$width,$height) = deAspisList(image_downsize($id,$size),array());
$hwstring = image_hwstring($width,$height);
$class = concat(concat2(concat(concat2(concat1('align',esc_attr($align)),' size-'),esc_attr($size)),' wp-image-'),$id);
$class = apply_filters(array('get_image_tag_class',false),$class,$id,$align,$size);
$html = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<img src="',esc_attr($img_src)),'" alt="'),esc_attr($alt)),'" title="'),esc_attr($title)),'" '),$hwstring),'class="'),$class),'" />');
$html = apply_filters(array('get_image_tag',false),$html,$id,$alt,$title,$align,$size);
return $html;
 }
function wp_constrain_dimensions ( $current_width,$current_height,$max_width = array(0,false),$max_height = array(0,false) ) {
if ( ((denot_boolean($max_width)) and (denot_boolean($max_height))))
 return array(array($current_width,$current_height),false);
$width_ratio = $height_ratio = array(1.0,false);
if ( ((($max_width[0] > (0)) && ($current_width[0] > (0))) && ($current_width[0] > $max_width[0])))
 $width_ratio = array($max_width[0] / $current_width[0],false);
if ( ((($max_height[0] > (0)) && ($current_height[0] > (0))) && ($current_height[0] > $max_height[0])))
 $height_ratio = array($max_height[0] / $current_height[0],false);
$ratio = attAspisRC(min(deAspisRC($width_ratio),deAspisRC($height_ratio)));
return array(array(Aspis_intval(array($current_width[0] * $ratio[0],false)),Aspis_intval(array($current_height[0] * $ratio[0],false))),false);
 }
function image_resize_dimensions ( $orig_w,$orig_h,$dest_w,$dest_h,$crop = array(false,false) ) {
if ( (($orig_w[0] <= (0)) || ($orig_h[0] <= (0))))
 return array(false,false);
if ( (($dest_w[0] <= (0)) && ($dest_h[0] <= (0))))
 return array(false,false);
if ( $crop[0])
 {$aspect_ratio = array($orig_w[0] / $orig_h[0],false);
$new_w = attAspisRC(min(deAspisRC($dest_w),deAspisRC($orig_w)));
$new_h = attAspisRC(min(deAspisRC($dest_h),deAspisRC($orig_h)));
if ( (denot_boolean($new_w)))
 {$new_w = Aspis_intval(array($new_h[0] * $aspect_ratio[0],false));
}if ( (denot_boolean($new_h)))
 {$new_h = Aspis_intval(array($new_w[0] / $aspect_ratio[0],false));
}$size_ratio = attAspisRC(max(deAspisRC(array($new_w[0] / $orig_w[0],false)),deAspisRC(array($new_h[0] / $orig_h[0],false))));
$crop_w = attAspis(round(($new_w[0] / $size_ratio[0])));
$crop_h = attAspis(round(($new_h[0] / $size_ratio[0])));
$s_x = attAspis(floor((($orig_w[0] - $crop_w[0]) / (2))));
$s_y = attAspis(floor((($orig_h[0] - $crop_h[0]) / (2))));
}else 
{{$crop_w = $orig_w;
$crop_h = $orig_h;
$s_x = array(0,false);
$s_y = array(0,false);
list($new_w,$new_h) = deAspisList(wp_constrain_dimensions($orig_w,$orig_h,$dest_w,$dest_h),array());
}}if ( (($new_w[0] >= $orig_w[0]) && ($new_h[0] >= $orig_h[0])))
 return array(false,false);
return array(array(array(0,false),array(0,false),int_cast($s_x),int_cast($s_y),int_cast($new_w),int_cast($new_h),int_cast($crop_w),int_cast($crop_h)),false);
 }
function image_resize ( $file,$max_w,$max_h,$crop = array(false,false),$suffix = array(null,false),$dest_path = array(null,false),$jpeg_quality = array(90,false) ) {
$image = wp_load_image($file);
if ( (!(is_resource(deAspisRC($image)))))
 return array(new WP_Error(array('error_loading_image',false),$image),false);
$size = @attAspisRC(getimagesize($file[0]));
if ( (denot_boolean($size)))
 return array(new WP_Error(array('invalid_image',false),__(array('Could not read image size',false)),$file),false);
list($orig_w,$orig_h,$orig_type) = deAspisList($size,array());
$dims = image_resize_dimensions($orig_w,$orig_h,$max_w,$max_h,$crop);
if ( (denot_boolean($dims)))
 return $dims;
list($dst_x,$dst_y,$src_x,$src_y,$dst_w,$dst_h,$src_w,$src_h) = deAspisList($dims,array());
$newimage = wp_imagecreatetruecolor($dst_w,$dst_h);
imagecopyresampled($newimage[0],$image[0],$dst_x[0],$dst_y[0],$src_x[0],$src_y[0],$dst_w[0],$dst_h[0],$src_w[0],$src_h[0]);
if ( ((IMAGETYPE_PNG == $orig_type[0]) && (!(imageistruecolor($image[0])))))
 imagetruecolortopalette($newimage[0],false,imagecolorstotal($image[0]));
imagedestroy($image[0]);
if ( (denot_boolean($suffix)))
 $suffix = concat(concat2($dst_w,"x"),$dst_h);
$info = Aspis_pathinfo($file);
$dir = $info[0]['dirname'];
$ext = $info[0]['extension'];
$name = Aspis_basename($file,concat1(".",$ext));
if ( ((!(is_null(deAspisRC($dest_path)))) and deAspis($_dest_path = Aspis_realpath($dest_path))))
 $dir = $_dest_path;
$destfilename = concat(concat2(concat(concat2(concat(concat2($dir,"/"),$name),"-"),$suffix),"."),$ext);
if ( (IMAGETYPE_GIF == $orig_type[0]))
 {if ( (!(imagegif($newimage[0],$destfilename[0]))))
 return array(new WP_Error(array('resize_path_invalid',false),__(array('Resize path invalid',false))),false);
}elseif ( (IMAGETYPE_PNG == $orig_type[0]))
 {if ( (!(imagepng($newimage[0],$destfilename[0]))))
 return array(new WP_Error(array('resize_path_invalid',false),__(array('Resize path invalid',false))),false);
}else 
{{$destfilename = concat2(concat(concat2(concat(concat2($dir,"/"),$name),"-"),$suffix),".jpg");
if ( (!(imagejpeg($newimage[0],$destfilename[0],deAspis(apply_filters(array('jpeg_quality',false),$jpeg_quality,array('image_resize',false)))))))
 return array(new WP_Error(array('resize_path_invalid',false),__(array('Resize path invalid',false))),false);
}}imagedestroy($newimage[0]);
$stat = Aspis_stat(Aspis_dirname($destfilename));
$perms = array(deAspis($stat[0]['mode']) & (0000666),false);
@attAspis(chmod($destfilename[0],$perms[0]));
return $destfilename;
 }
function image_make_intermediate_size ( $file,$width,$height,$crop = array(false,false) ) {
if ( ($width[0] || $height[0]))
 {$resized_file = image_resize($file,$width,$height,$crop);
if ( (((denot_boolean(is_wp_error($resized_file))) && $resized_file[0]) && deAspis($info = attAspisRC(getimagesize($resized_file[0])))))
 {$resized_file = apply_filters(array('image_make_intermediate_size',false),$resized_file);
return array(array(deregisterTaint(array('file',false)) => addTaint(Aspis_basename($resized_file)),deregisterTaint(array('width',false)) => addTaint(attachAspis($info,(0))),deregisterTaint(array('height',false)) => addTaint(attachAspis($info,(1))),),false);
}}return array(false,false);
 }
function image_get_intermediate_size ( $post_id,$size = array('thumbnail',false) ) {
if ( (!(is_array(deAspis($imagedata = wp_get_attachment_metadata($post_id))))))
 return array(false,false);
if ( (is_array($size[0]) && (!((empty($imagedata[0][('sizes')]) || Aspis_empty( $imagedata [0][('sizes')]))))))
 {foreach ( deAspis($imagedata[0]['sizes']) as $_size =>$data )
{restoreTaint($_size,$data);
{if ( (((deAspis($data[0]['width']) == deAspis(attachAspis($size,(0)))) && (deAspis($data[0]['height']) <= deAspis(attachAspis($size,(1))))) || ((deAspis($data[0]['height']) == deAspis(attachAspis($size,(1)))) && (deAspis($data[0]['width']) <= deAspis(attachAspis($size,(0)))))))
 {$file = $data[0]['file'];
list($width,$height) = deAspisList(image_constrain_size_for_editor($data[0]['width'],$data[0]['height'],$size),array());
return array(compact('file','width','height'),false);
}arrayAssign($areas[0],deAspis(registerTaint(array(deAspis($data[0]['width']) * deAspis($data[0]['height']),false))),addTaint($_size));
}}if ( ((denot_boolean($size)) || (!((empty($areas) || Aspis_empty( $areas))))))
 {Aspis_ksort($areas);
foreach ( $areas[0] as $_size  )
{$data = attachAspis($imagedata[0][('sizes')],$_size[0]);
if ( ((deAspis($data[0]['width']) >= deAspis(attachAspis($size,(0)))) || (deAspis($data[0]['height']) >= deAspis(attachAspis($size,(1))))))
 {$file = $data[0]['file'];
list($width,$height) = deAspisList(image_constrain_size_for_editor($data[0]['width'],$data[0]['height'],$size),array());
return array(compact('file','width','height'),false);
}}}}if ( ((is_array($size[0]) || ((empty($size) || Aspis_empty( $size)))) || ((empty($imagedata[0][('sizes')][0][$size[0]]) || Aspis_empty( $imagedata [0][('sizes')] [0][$size[0]])))))
 return array(false,false);
$data = attachAspis($imagedata[0][('sizes')],$size[0]);
if ( (((empty($data[0][('path')]) || Aspis_empty( $data [0][('path')]))) && (!((empty($data[0][('file')]) || Aspis_empty( $data [0][('file')]))))))
 {$file_url = wp_get_attachment_url($post_id);
arrayAssign($data[0],deAspis(registerTaint(array('path',false))),addTaint(path_join(Aspis_dirname($imagedata[0]['file']),$data[0]['file'])));
arrayAssign($data[0],deAspis(registerTaint(array('url',false))),addTaint(path_join(Aspis_dirname($file_url),$data[0]['file'])));
}return $data;
 }
function wp_get_attachment_image_src ( $attachment_id,$size = array('thumbnail',false),$icon = array(false,false) ) {
if ( deAspis($image = image_downsize($attachment_id,$size)))
 return $image;
$src = array(false,false);
if ( ($icon[0] && deAspis($src = wp_mime_type_icon($attachment_id))))
 {$icon_dir = apply_filters(array('icon_dir',false),concat2(concat12(ABSPATH,WPINC),'/images/crystal'));
$src_file = concat(concat2($icon_dir,'/'),Aspis_basename($src));
@list($width,$height) = deAspisList(attAspisRC(getimagesize($src_file[0])),array());
}if ( (($src[0] && $width[0]) && $height[0]))
 return array(array($src,$width,$height),false);
return array(false,false);
 }
function wp_get_attachment_image ( $attachment_id,$size = array('thumbnail',false),$icon = array(false,false),$attr = array('',false) ) {
$html = array('',false);
$image = wp_get_attachment_image_src($attachment_id,$size,$icon);
if ( $image[0])
 {list($src,$width,$height) = deAspisList($image,array());
$hwstring = image_hwstring($width,$height);
if ( is_array($size[0]))
 $size = Aspis_join(array('x',false),$size);
$attachment = &get_post($attachment_id);
$default_attr = array(array(deregisterTaint(array('src',false)) => addTaint($src),deregisterTaint(array('class',false)) => addTaint(concat1("attachment-",$size)),deregisterTaint(array('alt',false)) => addTaint(Aspis_trim(Aspis_strip_tags($attachment[0]->post_excerpt))),deregisterTaint(array('title',false)) => addTaint(Aspis_trim(Aspis_strip_tags($attachment[0]->post_title))),),false);
$attr = wp_parse_args($attr,$default_attr);
$attr = apply_filters(array('wp_get_attachment_image_attributes',false),$attr,$attachment);
$attr = attAspisRC(array_map(AspisInternalCallback(array('esc_attr',false)),deAspisRC($attr)));
$html = Aspis_rtrim(concat1("<img ",$hwstring));
foreach ( $attr[0] as $name =>$value )
{restoreTaint($name,$value);
{$html = concat($html,concat2(concat(concat2(concat2(concat1(" ",$name),"="),'"'),$value),'"'));
}}$html = concat2($html,' />');
}return $html;
 }
function _wp_post_thumbnail_class_filter ( $attr ) {
arrayAssign($attr[0],deAspis(registerTaint(array('class',false))),addTaint(concat2($attr[0]['class'],' wp-post-image')));
return $attr;
 }
function _wp_post_thumbnail_class_filter_add ( $attr ) {
add_filter(array('wp_get_attachment_image_attributes',false),array('_wp_post_thumbnail_class_filter',false));
 }
function _wp_post_thumbnail_class_filter_remove ( $attr ) {
remove_filter(array('wp_get_attachment_image_attributes',false),array('_wp_post_thumbnail_class_filter',false));
 }
add_shortcode(array('wp_caption',false),array('img_caption_shortcode',false));
add_shortcode(array('caption',false),array('img_caption_shortcode',false));
function img_caption_shortcode ( $attr,$content = array(null,false) ) {
$output = apply_filters(array('img_caption_shortcode',false),array('',false),$attr,$content);
if ( ($output[0] != ('')))
 return $output;
extract((deAspis(shortcode_atts(array(array('id' => array('',false,false),'align' => array('alignnone',false,false),'width' => array('',false,false),'caption' => array('',false,false)),false),$attr))));
if ( (((1) > deAspis(int_cast($width))) || ((empty($caption) || Aspis_empty( $caption)))))
 return $content;
if ( $id[0])
 $id = concat2(concat1('id="',esc_attr($id)),'" ');
return concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<div ',$id),'class="wp-caption '),esc_attr($align)),'" style="width: '),(array((10) + deAspis(int_cast($width)),false))),'px">'),do_shortcode($content)),'<p class="wp-caption-text">'),$caption),'</p></div>');
 }
add_shortcode(array('gallery',false),array('gallery_shortcode',false));
function gallery_shortcode ( $attr ) {
global $post,$wp_locale;
static $instance = array(0,false);
postincr($instance);
$output = apply_filters(array('post_gallery',false),array('',false),$attr);
if ( ($output[0] != ('')))
 return $output;
if ( ((isset($attr[0][('orderby')]) && Aspis_isset( $attr [0][('orderby')]))))
 {arrayAssign($attr[0],deAspis(registerTaint(array('orderby',false))),addTaint(sanitize_sql_orderby($attr[0]['orderby'])));
if ( (denot_boolean($attr[0]['orderby'])))
 unset($attr[0][('orderby')]);
}extract((deAspis(shortcode_atts(array(array('order' => array('ASC',false,false),'orderby' => array('menu_order ID',false,false),deregisterTaint(array('id',false)) => addTaint($post[0]->ID),'itemtag' => array('dl',false,false),'icontag' => array('dt',false,false),'captiontag' => array('dd',false,false),'columns' => array(3,false,false),'size' => array('thumbnail',false,false),'include' => array('',false,false),'exclude' => array('',false,false)),false),$attr))));
$id = Aspis_intval($id);
if ( (('RAND') == $order[0]))
 $orderby = array('none',false);
if ( (!((empty($include) || Aspis_empty( $include)))))
 {$include = Aspis_preg_replace(array('/[^0-9,]+/',false),array('',false),$include);
$_attachments = get_posts(array(array(deregisterTaint(array('include',false)) => addTaint($include),'post_status' => array('inherit',false,false),'post_type' => array('attachment',false,false),'post_mime_type' => array('image',false,false),deregisterTaint(array('order',false)) => addTaint($order),deregisterTaint(array('orderby',false)) => addTaint($orderby)),false));
$attachments = array(array(),false);
foreach ( $_attachments[0] as $key =>$val )
{restoreTaint($key,$val);
{arrayAssign($attachments[0],deAspis(registerTaint($val[0]->ID)),addTaint(attachAspis($_attachments,$key[0])));
}}}elseif ( (!((empty($exclude) || Aspis_empty( $exclude)))))
 {$exclude = Aspis_preg_replace(array('/[^0-9,]+/',false),array('',false),$exclude);
$attachments = get_children(array(array(deregisterTaint(array('post_parent',false)) => addTaint($id),deregisterTaint(array('exclude',false)) => addTaint($exclude),'post_status' => array('inherit',false,false),'post_type' => array('attachment',false,false),'post_mime_type' => array('image',false,false),deregisterTaint(array('order',false)) => addTaint($order),deregisterTaint(array('orderby',false)) => addTaint($orderby)),false));
}else 
{{$attachments = get_children(array(array(deregisterTaint(array('post_parent',false)) => addTaint($id),'post_status' => array('inherit',false,false),'post_type' => array('attachment',false,false),'post_mime_type' => array('image',false,false),deregisterTaint(array('order',false)) => addTaint($order),deregisterTaint(array('orderby',false)) => addTaint($orderby)),false));
}}if ( ((empty($attachments) || Aspis_empty( $attachments))))
 return array('',false);
if ( deAspis(is_feed()))
 {$output = array("\n",false);
foreach ( $attachments[0] as $att_id =>$attachment )
{restoreTaint($att_id,$attachment);
$output = concat($output,concat2(wp_get_attachment_link($att_id,$size,array(true,false)),"\n"));
}return $output;
}$itemtag = tag_escape($itemtag);
$captiontag = tag_escape($captiontag);
$columns = Aspis_intval($columns);
$itemwidth = ($columns[0] > (0)) ? attAspis(floor(((100) / $columns[0]))) : array(100,false);
$float = ($wp_locale[0]->text_direction[0] == ('rtl')) ? array('right',false) : array('left',false);
$selector = concat1("gallery-",$instance);
$output = apply_filters(array('gallery_style',false),concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("
		<style type='text/css'>
			#",$selector)," {
				margin: auto;
			}
			#"),$selector)," .gallery-item {
				float: "),$float),";
				margin-top: 10px;
				text-align: center;
				width: "),$itemwidth),"%;			}
			#"),$selector)," img {
				border: 2px solid #cfcfcf;
			}
			#"),$selector)," .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->
		<div id='"),$selector),"' class='gallery galleryid-"),$id),"'>"));
$i = array(0,false);
foreach ( $attachments[0] as $id =>$attachment )
{restoreTaint($id,$attachment);
{$link = (((isset($attr[0][('link')]) && Aspis_isset( $attr [0][('link')]))) && (('file') == deAspis($attr[0]['link']))) ? wp_get_attachment_link($id,$size,array(false,false),array(false,false)) : wp_get_attachment_link($id,$size,array(true,false),array(false,false));
$output = concat($output,concat2(concat1("<",$itemtag)," class='gallery-item'>"));
$output = concat($output,concat2(concat(concat2(concat(concat2(concat1("
			<",$icontag)," class='gallery-icon'>
				"),$link),"
			</"),$icontag),">"));
if ( ($captiontag[0] && deAspis(Aspis_trim($attachment[0]->post_excerpt))))
 {$output = concat($output,concat(concat(concat2(concat1("
				<",$captiontag)," class='gallery-caption'>
				"),wptexturize($attachment[0]->post_excerpt)),concat2(concat1("
				</",$captiontag),">")));
}$output = concat($output,concat2(concat1("</",$itemtag),">"));
if ( (($columns[0] > (0)) && ((deAspis(preincr($i)) % $columns[0]) == (0))))
 $output = concat2($output,'<br style="clear: both" />');
}}$output = concat2($output,"
			<br style='clear: both;' />
		</div>\n");
return $output;
 }
function previous_image_link ( $size = array('thumbnail',false),$text = array(false,false) ) {
adjacent_image_link(array(true,false),$size,$text);
 }
function next_image_link ( $size = array('thumbnail',false),$text = array(false,false) ) {
adjacent_image_link(array(false,false),$size,$text);
 }
function adjacent_image_link ( $prev = array(true,false),$size = array('thumbnail',false),$text = array(false,false) ) {
global $post;
$post = get_post($post);
$attachments = Aspis_array_values(get_children(array(array(deregisterTaint(array('post_parent',false)) => addTaint($post[0]->post_parent),'post_status' => array('inherit',false,false),'post_type' => array('attachment',false,false),'post_mime_type' => array('image',false,false),'order' => array('ASC',false,false),'orderby' => array('menu_order ID',false,false)),false)));
foreach ( $attachments[0] as $k =>$attachment )
{restoreTaint($k,$attachment);
if ( ($attachment[0]->ID[0] == $post[0]->ID[0]))
 break ;
}$k = $prev[0] ? array($k[0] - (1),false) : array($k[0] + (1),false);
if ( ((isset($attachments[0][$k[0]]) && Aspis_isset( $attachments [0][$k[0]]))))
 echo AspisCheckPrint(wp_get_attachment_link($attachments[0][$k[0]][0]->ID,$size,array(true,false),array(false,false),$text));
 }
function get_attachment_taxonomies ( $attachment ) {
if ( is_int(deAspisRC($attachment)))
 $attachment = get_post($attachment);
else 
{if ( is_array($attachment[0]))
 $attachment = object_cast($attachment);
}if ( (!(is_object($attachment[0]))))
 return array(array(),false);
$filename = Aspis_basename($attachment[0]->guid);
$objects = array(array(array('attachment',false)),false);
if ( (false !== strpos($filename[0],'.')))
 arrayAssignAdd($objects[0][],addTaint(concat1('attachment:',Aspis_substr($filename,array(strrpos($filename[0],('.')) + (1),false)))));
if ( (!((empty($attachment[0]->post_mime_type) || Aspis_empty( $attachment[0] ->post_mime_type )))))
 {arrayAssignAdd($objects[0][],addTaint(concat1('attachment:',$attachment[0]->post_mime_type)));
if ( (false !== strpos($attachment[0]->post_mime_type[0],'/')))
 foreach ( deAspis(Aspis_explode(array('/',false),$attachment[0]->post_mime_type)) as $token  )
if ( (!((empty($token) || Aspis_empty( $token)))))
 arrayAssignAdd($objects[0][],addTaint(concat1("attachment:",$token)));
}$taxonomies = array(array(),false);
foreach ( $objects[0] as $object  )
if ( deAspis($taxes = get_object_taxonomies($object)))
 $taxonomies = Aspis_array_merge($taxonomies,$taxes);
return attAspisRC(array_unique(deAspisRC($taxonomies)));
 }
function gd_edit_image_support ( $mime_type ) {
if ( function_exists(('imagetypes')))
 {switch ( $mime_type[0] ) {
case ('image/jpeg'):return array((imagetypes() & IMG_JPG) != (0),false);
case ('image/png'):return array((imagetypes() & IMG_PNG) != (0),false);
case ('image/gif'):return array((imagetypes() & IMG_GIF) != (0),false);
 }
}else 
{{switch ( $mime_type[0] ) {
case ('image/jpeg'):return attAspis(function_exists(('imagecreatefromjpeg')));
case ('image/png'):return attAspis(function_exists(('imagecreatefrompng')));
case ('image/gif'):return attAspis(function_exists(('imagecreatefromgif')));
 }
}}return array(false,false);
 }
function wp_imagecreatetruecolor ( $width,$height ) {
$img = attAspis(imagecreatetruecolor($width[0],$height[0]));
if ( ((is_resource(deAspisRC($img)) && function_exists(('imagealphablending'))) && function_exists(('imagesavealpha'))))
 {imagealphablending($img[0],false);
imagesavealpha($img[0],true);
}return $img;
 }
class WP_Embed{var $handlers = array(array(),false);
var $post_ID;
var $usecache = array(true,false);
var $linkifunknown = array(true,false);
function WP_Embed (  ) {
{return $this->__construct();
} }
function __construct (  ) {
{add_filter(array('the_content',false),array(array(array($this,false),array('run_shortcode',false)),false),array(8,false));
if ( deAspis(get_option(array('embed_autourls',false))))
 add_filter(array('the_content',false),array(array(array($this,false),array('autoembed',false)),false),array(8,false));
add_action(array('save_post',false),array(array(array($this,false),array('delete_oembed_caches',false)),false));
add_action(array('edit_form_advanced',false),array(array(array($this,false),array('maybe_run_ajax_cache',false)),false));
} }
function run_shortcode ( $content ) {
{global $shortcode_tags;
$orig_shortcode_tags = $shortcode_tags;
remove_all_shortcodes();
add_shortcode(array('embed',false),array(array(array($this,false),array('shortcode',false)),false));
$content = do_shortcode($content);
$shortcode_tags = $orig_shortcode_tags;
return $content;
} }
function maybe_run_ajax_cache (  ) {
{global $post_ID;
if ( ((((empty($post_ID) || Aspis_empty( $post_ID))) || ((empty($_GET[0][('message')]) || Aspis_empty( $_GET [0][('message')])))) || ((1) != deAspis($_GET[0]['message']))))
 return ;
;
?>
<script type="text/javascript">
/* <![CDATA[ */
	jQuery(document).ready(function($){
		$.get("<?php echo AspisCheckPrint(admin_url(concat1('admin-ajax.php?action=oembed-cache&post=',$post_ID)));
;
?>");
	});
/* ]]> */
</script>
<?php } }
function register_handler ( $id,$regex,$callback,$priority = array(10,false) ) {
{arrayAssign($this->handlers[0][$priority[0]][0],deAspis(registerTaint($id)),addTaint(array(array(deregisterTaint(array('regex',false)) => addTaint($regex),deregisterTaint(array('callback',false)) => addTaint($callback),),false)));
} }
function unregister_handler ( $id,$priority = array(10,false) ) {
{if ( ((isset($this->handlers[0][$priority[0]][0][$id[0]]) && Aspis_isset( $this ->handlers [0][$priority[0]] [0][$id[0]] ))))
 unset($this->handlers[0][$priority[0]][0][$id[0]]);
} }
function shortcode ( $attr,$url = array('',false) ) {
{global $post;
if ( ((empty($url) || Aspis_empty( $url))))
 return array('',false);
$rawattr = $attr;
$attr = wp_parse_args($attr,wp_embed_defaults());
Aspis_ksort($this->handlers);
foreach ( $this->handlers[0] as $priority =>$handlers )
{restoreTaint($priority,$handlers);
{foreach ( $handlers[0] as $id =>$handler )
{restoreTaint($id,$handler);
{if ( (deAspis(Aspis_preg_match($handler[0]['regex'],$url,$matches)) && is_callable(deAspisRC($handler[0]['callback']))))
 {if ( (false !== deAspis($return = Aspis_call_user_func($handler[0]['callback'],$matches,$attr,$url,$rawattr))))
 return apply_filters(array('embed_handler_html',false),$return,$url,$attr);
}}}}}$post_ID = (!((empty($post[0]->ID) || Aspis_empty( $post[0] ->ID )))) ? $post[0]->ID : array(null,false);
if ( (!((empty($this->post_ID) || Aspis_empty( $this ->post_ID )))))
 $post_ID = $this->post_ID;
if ( $post_ID[0])
 {$cachekey = concat1('_oembed_',attAspis(md5((deconcat($url,Aspis_serialize($attr))))));
if ( $this->usecache[0])
 {$cache = get_post_meta($post_ID,$cachekey,array(true,false));
if ( (('{{unknown}}') === $cache[0]))
 return $this->maybe_make_link($url);
if ( (!((empty($cache) || Aspis_empty( $cache)))))
 return apply_filters(array('embed_oembed_html',false),$cache,$url,$attr);
}arrayAssign($attr[0],deAspis(registerTaint(array('discover',false))),addTaint((deAspis(apply_filters(array('embed_oembed_discover',false),array(false,false))) && deAspis(author_can($post_ID,array('unfiltered_html',false)))) ? array(true,false) : array(false,false)));
$html = wp_oembed_get($url,$attr);
$cache = deAspis(($html)) ? $html : array('{{unknown}}',false);
update_post_meta($post_ID,$cachekey,$cache);
if ( $html[0])
 return apply_filters(array('embed_oembed_html',false),$html,$url,$attr);
}return $this->maybe_make_link($url);
} }
function delete_oembed_caches ( $post_ID ) {
{$post_metas = get_post_custom_keys($post_ID);
if ( ((empty($post_metas) || Aspis_empty( $post_metas))))
 return ;
foreach ( $post_metas[0] as $post_meta_key  )
{if ( (('_oembed_') == deAspis(Aspis_substr($post_meta_key,array(0,false),array(8,false)))))
 delete_post_meta($post_ID,$post_meta_key);
}} }
function cache_oembed ( $post_ID ) {
{$post = get_post($post_ID);
if ( (((empty($post[0]->ID) || Aspis_empty( $post[0] ->ID ))) || (denot_boolean(Aspis_in_array($post[0]->post_type,apply_filters(array('embed_cache_oembed_types',false),array(array(array('post',false),array('page',false)),false)))))))
 return ;
if ( (!((empty($post[0]->post_content) || Aspis_empty( $post[0] ->post_content )))))
 {$this->post_ID = $post[0]->ID;
$this->usecache = array(false,false);
$content = $this->run_shortcode($post[0]->post_content);
if ( deAspis(get_option(array('embed_autourls',false))))
 $this->autoembed($content);
$this->usecache = array(true,false);
}} }
function autoembed ( $content ) {
{return Aspis_preg_replace_callback(array('|^\s*(https?://[^\s"]+)\s*$|im',false),array(array(array($this,false),array('autoembed_callback',false)),false),$content);
} }
function autoembed_callback ( $match ) {
{$oldval = $this->linkifunknown;
$this->linkifunknown = array(false,false);
$return = $this->shortcode(array(array(),false),attachAspis($match,(1)));
$this->linkifunknown = $oldval;
return concat2(concat1("\n",$return),"\n");
} }
function maybe_make_link ( $url ) {
{$output = deAspis(($this->linkifunknown)) ? concat2(concat(concat2(concat1('<a href="',esc_attr($url)),'">'),esc_html($url)),'</a>') : $url;
return apply_filters(array('embed_maybe_make_link',false),$output,$url);
} }
}$wp_embed = array(new WP_Embed(),false);
function wp_embed_register_handler ( $id,$regex,$callback,$priority = array(10,false) ) {
global $wp_embed;
$wp_embed[0]->register_handler($id,$regex,$callback,$priority);
 }
function wp_embed_unregister_handler ( $id,$priority = array(10,false) ) {
global $wp_embed;
$wp_embed[0]->unregister_handler($id,$priority);
 }
function wp_embed_defaults (  ) {
if ( (!((empty($GLOBALS[0][('content_width')]) || Aspis_empty( $GLOBALS [0][('content_width')])))))
 $theme_width = int_cast($GLOBALS[0]['content_width']);
$width = get_option(array('embed_size_w',false));
if ( ((denot_boolean($width)) && (!((empty($theme_width) || Aspis_empty( $theme_width))))))
 $width = $theme_width;
if ( (denot_boolean($width)))
 $width = array(500,false);
return apply_filters(array('embed_defaults',false),array(array(deregisterTaint(array('width',false)) => addTaint($width),'height' => array(700,false,false),),false));
 }
function wp_expand_dimensions ( $example_width,$example_height,$max_width,$max_height ) {
$example_width = int_cast($example_width);
$example_height = int_cast($example_height);
$max_width = int_cast($max_width);
$max_height = int_cast($max_height);
return wp_constrain_dimensions(array($example_width[0] * (1000000),false),array($example_height[0] * (1000000),false),$max_width,$max_height);
 }
function wp_oembed_get ( $url,$args = array('',false) ) {
require_once ('class-oembed.php');
$oembed = _wp_oembed_get_object();
return $oembed[0]->get_html($url,$args);
 }
function wp_oembed_add_provider ( $format,$provider,$regex = array(false,false) ) {
require_once ('class-oembed.php');
$oembed = _wp_oembed_get_object();
arrayAssign($oembed[0]->providers[0],deAspis(registerTaint($format)),addTaint(array(array($provider,$regex),false)));
 }
