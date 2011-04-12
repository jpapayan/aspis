<?php require_once('AspisMain.php'); ?><?php
function wp_create_thumbnail ( $file,$max_side,$deprecated = array('',false) ) {
$thumbpath = image_resize($file,$max_side,$max_side);
return apply_filters(array('wp_create_thumbnail',false),$thumbpath);
 }
function wp_crop_image ( $src_file,$src_x,$src_y,$src_w,$src_h,$dst_w,$dst_h,$src_abs = array(false,false),$dst_file = array(false,false) ) {
if ( is_numeric(deAspisRC($src_file)))
 $src_file = get_attached_file($src_file);
$src = wp_load_image($src_file);
if ( (!(is_resource(deAspisRC($src)))))
 return $src;
$dst = wp_imagecreatetruecolor($dst_w,$dst_h);
if ( $src_abs[0])
 {$src_w = array($src_w[0] - $src_x[0],false);
$src_h = array($src_h[0] - $src_y[0],false);
}if ( function_exists(('imageantialias')))
 imageantialias($dst[0],true);
imagecopyresampled($dst[0],$src[0],(0),(0),$src_x[0],$src_y[0],$dst_w[0],$dst_h[0],$src_w[0],$src_h[0]);
imagedestroy($src[0]);
if ( (denot_boolean($dst_file)))
 $dst_file = Aspis_str_replace(Aspis_basename($src_file),concat1('cropped-',Aspis_basename($src_file)),$src_file);
$dst_file = Aspis_preg_replace(array('/\\.[^\\.]+$/',false),array('.jpg',false),$dst_file);
if ( imagejpeg($dst[0],$dst_file[0],deAspis(apply_filters(array('jpeg_quality',false),array(90,false),array('wp_crop_image',false)))))
 return $dst_file;
else 
{return array(false,false);
} }
function wp_generate_attachment_metadata ( $attachment_id,$file ) {
$attachment = get_post($attachment_id);
$metadata = array(array(),false);
if ( (deAspis(Aspis_preg_match(array('!^image/!',false),get_post_mime_type($attachment))) && deAspis(file_is_displayable_image($file))))
 {$imagesize = attAspisRC(getimagesize($file[0]));
arrayAssign($metadata[0],deAspis(registerTaint(array('width',false))),addTaint(attachAspis($imagesize,(0))));
arrayAssign($metadata[0],deAspis(registerTaint(array('height',false))),addTaint(attachAspis($imagesize,(1))));
list($uwidth,$uheight) = deAspisList(wp_shrink_dimensions($metadata[0]['width'],$metadata[0]['height']),array());
arrayAssign($metadata[0],deAspis(registerTaint(array('hwstring_small',false))),addTaint(concat2(concat(concat2(concat1("height='",$uheight),"' width='"),$uwidth),"'")));
arrayAssign($metadata[0],deAspis(registerTaint(array('file',false))),addTaint(_wp_relative_upload_path($file)));
global $_wp_additional_image_sizes;
$temp_sizes = array(array(array('thumbnail',false),array('medium',false),array('large',false)),false);
if ( (((isset($_wp_additional_image_sizes) && Aspis_isset( $_wp_additional_image_sizes))) && count($_wp_additional_image_sizes[0])))
 $temp_sizes = Aspis_array_merge($temp_sizes,attAspisRC(array_keys(deAspisRC($_wp_additional_image_sizes))));
$temp_sizes = apply_filters(array('intermediate_image_sizes',false),$temp_sizes);
foreach ( $temp_sizes[0] as $s  )
{arrayAssign($sizes[0],deAspis(registerTaint($s)),addTaint(array(array('width' => array('',false,false),'height' => array('',false,false),'crop' => array(FALSE,false,false)),false)));
if ( ((isset($_wp_additional_image_sizes[0][$s[0]][0][('width')]) && Aspis_isset( $_wp_additional_image_sizes [0][$s[0]] [0][('width')]))))
 arrayAssign($sizes[0][$s[0]][0],deAspis(registerTaint(array('width',false))),addTaint(Aspis_intval($_wp_additional_image_sizes[0][$s[0]][0]['width'])));
else 
{arrayAssign($sizes[0][$s[0]][0],deAspis(registerTaint(array('width',false))),addTaint(get_option(concat2($s,"_size_w"))));
}if ( ((isset($_wp_additional_image_sizes[0][$s[0]][0][('height')]) && Aspis_isset( $_wp_additional_image_sizes [0][$s[0]] [0][('height')]))))
 arrayAssign($sizes[0][$s[0]][0],deAspis(registerTaint(array('height',false))),addTaint(Aspis_intval($_wp_additional_image_sizes[0][$s[0]][0]['height'])));
else 
{arrayAssign($sizes[0][$s[0]][0],deAspis(registerTaint(array('height',false))),addTaint(get_option(concat2($s,"_size_h"))));
}if ( ((isset($_wp_additional_image_sizes[0][$s[0]][0][('crop')]) && Aspis_isset( $_wp_additional_image_sizes [0][$s[0]] [0][('crop')]))))
 arrayAssign($sizes[0][$s[0]][0],deAspis(registerTaint(array('crop',false))),addTaint(Aspis_intval($_wp_additional_image_sizes[0][$s[0]][0]['crop'])));
else 
{arrayAssign($sizes[0][$s[0]][0],deAspis(registerTaint(array('crop',false))),addTaint(get_option(concat2($s,"_crop"))));
}}$sizes = apply_filters(array('intermediate_image_sizes_advanced',false),$sizes);
foreach ( $sizes[0] as $size =>$size_data )
{restoreTaint($size,$size_data);
{$resized = image_make_intermediate_size($file,$size_data[0]['width'],$size_data[0]['height'],$size_data[0]['crop']);
if ( $resized[0])
 arrayAssign($metadata[0][('sizes')][0],deAspis(registerTaint($size)),addTaint($resized));
}}$image_meta = wp_read_image_metadata($file);
if ( $image_meta[0])
 arrayAssign($metadata[0],deAspis(registerTaint(array('image_meta',false))),addTaint($image_meta));
}return apply_filters(array('wp_generate_attachment_metadata',false),$metadata,$attachment_id);
 }
function wp_load_image ( $file ) {
if ( is_numeric(deAspisRC($file)))
 $file = get_attached_file($file);
if ( (!(file_exists($file[0]))))
 return Aspis_sprintf(__(array('File &#8220;%s&#8221; doesn&#8217;t exist?',false)),$file);
if ( (!(function_exists(('imagecreatefromstring')))))
 return __(array('The GD image library is not installed.',false));
@array(ini_set('memory_limit','256M'),false);
$image = attAspis(imagecreatefromstring(file_get_contents($file[0])));
if ( (!(is_resource(deAspisRC($image)))))
 return Aspis_sprintf(__(array('File &#8220;%s&#8221; is not an image.',false)),$file);
return $image;
 }
function get_udims ( $width,$height ) {
return wp_shrink_dimensions($width,$height);
 }
function wp_shrink_dimensions ( $width,$height,$wmax = array(128,false),$hmax = array(96,false) ) {
return wp_constrain_dimensions($width,$height,$wmax,$hmax);
 }
function wp_exif_frac2dec ( $str ) {
@list($n,$d) = deAspisList(Aspis_explode(array('/',false),$str),array());
if ( (!((empty($d) || Aspis_empty( $d)))))
 return array($n[0] / $d[0],false);
return $str;
 }
function wp_exif_date2ts ( $str ) {
@list($date,$time) = deAspisList(Aspis_explode(array(' ',false),Aspis_trim($str)),array());
@list($y,$m,$d) = deAspisList(Aspis_explode(array(':',false),$date),array());
return attAspis(strtotime((deconcat(concat2(concat(concat2(concat(concat2($y,"-"),$m),"-"),$d)," "),$time))));
 }
function wp_read_image_metadata ( $file ) {
if ( (!(file_exists($file[0]))))
 return array(false,false);
list(,,$sourceImageType) = deAspisList(attAspisRC(getimagesize($file[0])),array());
$meta = array(array('aperture' => array(0,false,false),'credit' => array('',false,false),'camera' => array('',false,false),'caption' => array('',false,false),'created_timestamp' => array(0,false,false),'copyright' => array('',false,false),'focal_length' => array(0,false,false),'iso' => array(0,false,false),'shutter_speed' => array(0,false,false),'title' => array('',false,false),),false);
if ( is_callable('iptcparse'))
 {AspisInternalFunctionCall("getimagesize",$file[0],AspisPushRefParam($info),array(1));
if ( (!((empty($info[0][('APP13')]) || Aspis_empty( $info [0][('APP13')])))))
 {$iptc = attAspisRC(iptcparse(deAspis($info[0]['APP13'])));
if ( (!((empty($iptc[0][('2#110')][0][(0)]) || Aspis_empty( $iptc [0][('2#110')] [0][(0)])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('credit',false))),addTaint(Aspis_utf8_encode(Aspis_trim(attachAspis($iptc[0][('2#110')],(0))))));
elseif ( (!((empty($iptc[0][('2#080')][0][(0)]) || Aspis_empty( $iptc [0][('2#080')] [0][(0)])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('credit',false))),addTaint(Aspis_utf8_encode(Aspis_trim(attachAspis($iptc[0][('2#080')],(0))))));
if ( ((!((empty($iptc[0][('2#055')][0][(0)]) || Aspis_empty( $iptc [0][('2#055')] [0][(0)])))) and (!((empty($iptc[0][('2#060')][0][(0)]) || Aspis_empty( $iptc [0][('2#060')] [0][(0)]))))))
 arrayAssign($meta[0],deAspis(registerTaint(array('created_timestamp',false))),addTaint(attAspis(strtotime((deconcat(concat2(attachAspis($iptc[0][('2#055')],(0)),' '),attachAspis($iptc[0][('2#060')],(0))))))));
if ( (!((empty($iptc[0][('2#120')][0][(0)]) || Aspis_empty( $iptc [0][('2#120')] [0][(0)])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('caption',false))),addTaint(Aspis_utf8_encode(Aspis_trim(attachAspis($iptc[0][('2#120')],(0))))));
if ( (!((empty($iptc[0][('2#116')][0][(0)]) || Aspis_empty( $iptc [0][('2#116')] [0][(0)])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('copyright',false))),addTaint(Aspis_utf8_encode(Aspis_trim(attachAspis($iptc[0][('2#116')],(0))))));
if ( (!((empty($iptc[0][('2#005')][0][(0)]) || Aspis_empty( $iptc [0][('2#005')] [0][(0)])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_utf8_encode(Aspis_trim(attachAspis($iptc[0][('2#005')],(0))))));
}}if ( (is_callable('exif_read_data') && deAspis(Aspis_in_array($sourceImageType,apply_filters(array('wp_read_image_metadata_types',false),array(array(array(IMAGETYPE_JPEG,false),array(IMAGETYPE_TIFF_II,false),array(IMAGETYPE_TIFF_MM,false)),false))))))
 {$exif = @array(exif_read_data(deAspisRC($file)),false);
if ( (!((empty($exif[0][('FNumber')]) || Aspis_empty( $exif [0][('FNumber')])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('aperture',false))),addTaint(attAspis(round(deAspis(wp_exif_frac2dec($exif[0]['FNumber'])),(2)))));
if ( (!((empty($exif[0][('Model')]) || Aspis_empty( $exif [0][('Model')])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('camera',false))),addTaint(Aspis_trim($exif[0]['Model'])));
if ( (!((empty($exif[0][('DateTimeDigitized')]) || Aspis_empty( $exif [0][('DateTimeDigitized')])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('created_timestamp',false))),addTaint(wp_exif_date2ts($exif[0]['DateTimeDigitized'])));
if ( (!((empty($exif[0][('FocalLength')]) || Aspis_empty( $exif [0][('FocalLength')])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('focal_length',false))),addTaint(wp_exif_frac2dec($exif[0]['FocalLength'])));
if ( (!((empty($exif[0][('ISOSpeedRatings')]) || Aspis_empty( $exif [0][('ISOSpeedRatings')])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('iso',false))),addTaint($exif[0]['ISOSpeedRatings']));
if ( (!((empty($exif[0][('ExposureTime')]) || Aspis_empty( $exif [0][('ExposureTime')])))))
 arrayAssign($meta[0],deAspis(registerTaint(array('shutter_speed',false))),addTaint(wp_exif_frac2dec($exif[0]['ExposureTime'])));
}return apply_filters(array('wp_read_image_metadata',false),$meta,$file,$sourceImageType);
 }
function file_is_valid_image ( $path ) {
$size = @attAspisRC(getimagesize($path[0]));
return not_boolean(array((empty($size) || Aspis_empty( $size)),false));
 }
function file_is_displayable_image ( $path ) {
$info = @attAspisRC(getimagesize($path[0]));
if ( ((empty($info) || Aspis_empty( $info))))
 $result = array(false,false);
elseif ( (denot_boolean(Aspis_in_array(attachAspis($info,(2)),array(array(array(IMAGETYPE_GIF,false),array(IMAGETYPE_JPEG,false),array(IMAGETYPE_PNG,false)),false)))))
 $result = array(false,false);
else 
{$result = array(true,false);
}return apply_filters(array('file_is_displayable_image',false),$result,$path);
 }
