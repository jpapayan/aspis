<?php require_once('AspisMain.php'); ?><?php
function wp_create_thumbnail ( $file,$max_side,$deprecated = '' ) {
$thumbpath = image_resize($file,$max_side,$max_side);
{$AspisRetTemp = apply_filters('wp_create_thumbnail',$thumbpath);
return $AspisRetTemp;
} }
function wp_crop_image ( $src_file,$src_x,$src_y,$src_w,$src_h,$dst_w,$dst_h,$src_abs = false,$dst_file = false ) {
if ( is_numeric($src_file))
 $src_file = get_attached_file($src_file);
$src = wp_load_image($src_file);
if ( !is_resource($src))
 {$AspisRetTemp = $src;
return $AspisRetTemp;
}$dst = wp_imagecreatetruecolor($dst_w,$dst_h);
if ( $src_abs)
 {$src_w -= $src_x;
$src_h -= $src_y;
}if ( function_exists('imageantialias'))
 imageantialias($dst,true);
imagecopyresampled($dst,$src,0,0,$src_x,$src_y,$dst_w,$dst_h,$src_w,$src_h);
imagedestroy($src);
if ( !$dst_file)
 $dst_file = str_replace(basename($src_file),'cropped-' . basename($src_file),$src_file);
$dst_file = preg_replace('/\\.[^\\.]+$/','.jpg',$dst_file);
if ( imagejpeg($dst,$dst_file,apply_filters('jpeg_quality',90,'wp_crop_image')))
 {$AspisRetTemp = $dst_file;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function wp_generate_attachment_metadata ( $attachment_id,$file ) {
$attachment = get_post($attachment_id);
$metadata = array();
if ( preg_match('!^image/!',get_post_mime_type($attachment)) && file_is_displayable_image($file))
 {$imagesize = getimagesize($file);
$metadata['width'] = $imagesize[0];
$metadata['height'] = $imagesize[1];
list($uwidth,$uheight) = wp_shrink_dimensions($metadata['width'],$metadata['height']);
$metadata['hwstring_small'] = "height='$uheight' width='$uwidth'";
$metadata['file'] = _wp_relative_upload_path($file);
{global $_wp_additional_image_sizes;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_additional_image_sizes,"\$_wp_additional_image_sizes",$AspisChangesCache);
}$temp_sizes = array('thumbnail','medium','large');
if ( isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes))
 $temp_sizes = array_merge($temp_sizes,array_keys($_wp_additional_image_sizes));
$temp_sizes = apply_filters('intermediate_image_sizes',$temp_sizes);
foreach ( $temp_sizes as $s  )
{$sizes[$s] = array('width' => '','height' => '','crop' => FALSE);
if ( isset($_wp_additional_image_sizes[$s]['width']))
 $sizes[$s]['width'] = intval($_wp_additional_image_sizes[$s]['width']);
else 
{$sizes[$s]['width'] = get_option("{$s}_size_w");
}if ( isset($_wp_additional_image_sizes[$s]['height']))
 $sizes[$s]['height'] = intval($_wp_additional_image_sizes[$s]['height']);
else 
{$sizes[$s]['height'] = get_option("{$s}_size_h");
}if ( isset($_wp_additional_image_sizes[$s]['crop']))
 $sizes[$s]['crop'] = intval($_wp_additional_image_sizes[$s]['crop']);
else 
{$sizes[$s]['crop'] = get_option("{$s}_crop");
}}$sizes = apply_filters('intermediate_image_sizes_advanced',$sizes);
foreach ( $sizes as $size =>$size_data )
{$resized = image_make_intermediate_size($file,$size_data['width'],$size_data['height'],$size_data['crop']);
if ( $resized)
 $metadata['sizes'][$size] = $resized;
}$image_meta = wp_read_image_metadata($file);
if ( $image_meta)
 $metadata['image_meta'] = $image_meta;
}{$AspisRetTemp = apply_filters('wp_generate_attachment_metadata',$metadata,$attachment_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_additional_image_sizes",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_additional_image_sizes",$AspisChangesCache);
 }
function wp_load_image ( $file ) {
if ( is_numeric($file))
 $file = get_attached_file($file);
if ( !file_exists($file))
 {$AspisRetTemp = sprintf(__('File &#8220;%s&#8221; doesn&#8217;t exist?'),$file);
return $AspisRetTemp;
}if ( !function_exists('imagecreatefromstring'))
 {$AspisRetTemp = __('The GD image library is not installed.');
return $AspisRetTemp;
}@ini_set('memory_limit','256M');
$image = imagecreatefromstring(file_get_contents($file));
if ( !is_resource($image))
 {$AspisRetTemp = sprintf(__('File &#8220;%s&#8221; is not an image.'),$file);
return $AspisRetTemp;
}{$AspisRetTemp = $image;
return $AspisRetTemp;
} }
function get_udims ( $width,$height ) {
{$AspisRetTemp = wp_shrink_dimensions($width,$height);
return $AspisRetTemp;
} }
function wp_shrink_dimensions ( $width,$height,$wmax = 128,$hmax = 96 ) {
{$AspisRetTemp = wp_constrain_dimensions($width,$height,$wmax,$hmax);
return $AspisRetTemp;
} }
function wp_exif_frac2dec ( $str ) {
@list($n,$d) = explode('/',$str);
if ( !empty($d))
 {$AspisRetTemp = $n / $d;
return $AspisRetTemp;
}{$AspisRetTemp = $str;
return $AspisRetTemp;
} }
function wp_exif_date2ts ( $str ) {
@list($date,$time) = explode(' ',trim($str));
@list($y,$m,$d) = explode(':',$date);
{$AspisRetTemp = strtotime("{$y}-{$m}-{$d} {$time}");
return $AspisRetTemp;
} }
function wp_read_image_metadata ( $file ) {
if ( !file_exists($file))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}list(,,$sourceImageType) = getimagesize($file);
$meta = array('aperture' => 0,'credit' => '','camera' => '','caption' => '','created_timestamp' => 0,'copyright' => '','focal_length' => 0,'iso' => 0,'shutter_speed' => 0,'title' => '',);
if ( is_callable('iptcparse'))
 {getimagesize($file,$info);
if ( !empty($info['APP13']))
 {$iptc = iptcparse($info['APP13']);
if ( !empty($iptc['2#110'][0]))
 $meta['credit'] = utf8_encode(trim($iptc['2#110'][0]));
elseif ( !empty($iptc['2#080'][0]))
 $meta['credit'] = utf8_encode(trim($iptc['2#080'][0]));
if ( !empty($iptc['2#055'][0]) and !empty($iptc['2#060'][0]))
 $meta['created_timestamp'] = strtotime($iptc['2#055'][0] . ' ' . $iptc['2#060'][0]);
if ( !empty($iptc['2#120'][0]))
 $meta['caption'] = utf8_encode(trim($iptc['2#120'][0]));
if ( !empty($iptc['2#116'][0]))
 $meta['copyright'] = utf8_encode(trim($iptc['2#116'][0]));
if ( !empty($iptc['2#005'][0]))
 $meta['title'] = utf8_encode(trim($iptc['2#005'][0]));
}}if ( is_callable('exif_read_data') && in_array($sourceImageType,apply_filters('wp_read_image_metadata_types',array(IMAGETYPE_JPEG,IMAGETYPE_TIFF_II,IMAGETYPE_TIFF_MM))))
 {$exif = @exif_read_data($file);
if ( !empty($exif['FNumber']))
 $meta['aperture'] = round(wp_exif_frac2dec($exif['FNumber']),2);
if ( !empty($exif['Model']))
 $meta['camera'] = trim($exif['Model']);
if ( !empty($exif['DateTimeDigitized']))
 $meta['created_timestamp'] = wp_exif_date2ts($exif['DateTimeDigitized']);
if ( !empty($exif['FocalLength']))
 $meta['focal_length'] = wp_exif_frac2dec($exif['FocalLength']);
if ( !empty($exif['ISOSpeedRatings']))
 $meta['iso'] = $exif['ISOSpeedRatings'];
if ( !empty($exif['ExposureTime']))
 $meta['shutter_speed'] = wp_exif_frac2dec($exif['ExposureTime']);
}{$AspisRetTemp = apply_filters('wp_read_image_metadata',$meta,$file,$sourceImageType);
return $AspisRetTemp;
} }
function file_is_valid_image ( $path ) {
$size = @getimagesize($path);
{$AspisRetTemp = !empty($size);
return $AspisRetTemp;
} }
function file_is_displayable_image ( $path ) {
$info = @getimagesize($path);
if ( empty($info))
 $result = false;
elseif ( !in_array($info[2],array(IMAGETYPE_GIF,IMAGETYPE_JPEG,IMAGETYPE_PNG)))
 $result = false;
else 
{$result = true;
}{$AspisRetTemp = apply_filters('file_is_displayable_image',$result,$path);
return $AspisRetTemp;
} }
