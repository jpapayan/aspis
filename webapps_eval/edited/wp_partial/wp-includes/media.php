<?php require_once('AspisMain.php'); ?><?php
function image_constrain_size_for_editor ( $width,$height,$size = 'medium' ) {
{global $content_width,$_wp_additional_image_sizes;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $content_width,"\$content_width",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($_wp_additional_image_sizes,"\$_wp_additional_image_sizes",$AspisChangesCache);
}if ( is_array($size))
 {$max_width = $size[0];
$max_height = $size[1];
}elseif ( $size == 'thumb' || $size == 'thumbnail')
 {$max_width = intval(get_option('thumbnail_size_w'));
$max_height = intval(get_option('thumbnail_size_h'));
if ( !$max_width && !$max_height)
 {$max_width = 128;
$max_height = 96;
}}elseif ( $size == 'medium')
 {$max_width = intval(get_option('medium_size_w'));
$max_height = intval(get_option('medium_size_h'));
}elseif ( $size == 'large')
 {$max_width = intval(get_option('large_size_w'));
$max_height = intval(get_option('large_size_h'));
if ( intval($content_width) > 0)
 $max_width = min(intval($content_width),$max_width);
}elseif ( isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes) && in_array($size,array_keys($_wp_additional_image_sizes)))
 {$max_width = intval($_wp_additional_image_sizes[$size]['width']);
$max_height = intval($_wp_additional_image_sizes[$size]['height']);
if ( intval($content_width) > 0)
 $max_width = min(intval($content_width),$max_width);
}else 
{{$max_width = $width;
$max_height = $height;
}}list($max_width,$max_height) = apply_filters('editor_max_image_size',array($max_width,$max_height),$size);
{$AspisRetTemp = wp_constrain_dimensions($width,$height,$max_width,$max_height);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$content_width",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$_wp_additional_image_sizes",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$content_width",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$_wp_additional_image_sizes",$AspisChangesCache);
 }
function image_hwstring ( $width,$height ) {
$out = '';
if ( $width)
 $out .= 'width="' . intval($width) . '" ';
if ( $height)
 $out .= 'height="' . intval($height) . '" ';
{$AspisRetTemp = $out;
return $AspisRetTemp;
} }
function image_downsize ( $id,$size = 'medium' ) {
if ( !wp_attachment_is_image($id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$img_url = wp_get_attachment_url($id);
$meta = wp_get_attachment_metadata($id);
$width = $height = 0;
$is_intermediate = false;
if ( $out = apply_filters('image_downsize',false,$id,$size))
 {$AspisRetTemp = $out;
return $AspisRetTemp;
}if ( $intermediate = image_get_intermediate_size($id,$size))
 {$img_url = str_replace(basename($img_url),$intermediate['file'],$img_url);
$width = $intermediate['width'];
$height = $intermediate['height'];
$is_intermediate = true;
}elseif ( $size == 'thumbnail')
 {if ( ($thumb_file = wp_get_attachment_thumb_file($id)) && $info = getimagesize($thumb_file))
 {$img_url = str_replace(basename($img_url),basename($thumb_file),$img_url);
$width = $info[0];
$height = $info[1];
$is_intermediate = true;
}}if ( !$width && !$height && isset($meta['width'],$meta['height']))
 {$width = $meta['width'];
$height = $meta['height'];
}if ( $img_url)
 {list($width,$height) = image_constrain_size_for_editor($width,$height,$size);
{$AspisRetTemp = array($img_url,$width,$height,$is_intermediate);
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function add_image_size ( $name,$width = 0,$height = 0,$crop = FALSE ) {
{global $_wp_additional_image_sizes;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_additional_image_sizes,"\$_wp_additional_image_sizes",$AspisChangesCache);
}$_wp_additional_image_sizes[$name] = array('width' => absint($width),'height' => absint($height),'crop' => !!$crop);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_additional_image_sizes",$AspisChangesCache);
 }
function set_post_thumbnail_size ( $width = 0,$height = 0,$crop = FALSE ) {
add_image_size('post-thumbnail',$width,$height,$crop);
 }
function get_image_tag ( $id,$alt,$title,$align,$size = 'medium' ) {
list($img_src,$width,$height) = image_downsize($id,$size);
$hwstring = image_hwstring($width,$height);
$class = 'align' . esc_attr($align) . ' size-' . esc_attr($size) . ' wp-image-' . $id;
$class = apply_filters('get_image_tag_class',$class,$id,$align,$size);
$html = '<img src="' . esc_attr($img_src) . '" alt="' . esc_attr($alt) . '" title="' . esc_attr($title) . '" ' . $hwstring . 'class="' . $class . '" />';
$html = apply_filters('get_image_tag',$html,$id,$alt,$title,$align,$size);
{$AspisRetTemp = $html;
return $AspisRetTemp;
} }
function wp_constrain_dimensions ( $current_width,$current_height,$max_width = 0,$max_height = 0 ) {
if ( !$max_width and !$max_height)
 {$AspisRetTemp = array($current_width,$current_height);
return $AspisRetTemp;
}$width_ratio = $height_ratio = 1.0;
if ( $max_width > 0 && $current_width > 0 && $current_width > $max_width)
 $width_ratio = $max_width / $current_width;
if ( $max_height > 0 && $current_height > 0 && $current_height > $max_height)
 $height_ratio = $max_height / $current_height;
$ratio = min($width_ratio,$height_ratio);
{$AspisRetTemp = array(intval($current_width * $ratio),intval($current_height * $ratio));
return $AspisRetTemp;
} }
function image_resize_dimensions ( $orig_w,$orig_h,$dest_w,$dest_h,$crop = false ) {
if ( $orig_w <= 0 || $orig_h <= 0)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( $dest_w <= 0 && $dest_h <= 0)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( $crop)
 {$aspect_ratio = $orig_w / $orig_h;
$new_w = min($dest_w,$orig_w);
$new_h = min($dest_h,$orig_h);
if ( !$new_w)
 {$new_w = intval($new_h * $aspect_ratio);
}if ( !$new_h)
 {$new_h = intval($new_w / $aspect_ratio);
}$size_ratio = max($new_w / $orig_w,$new_h / $orig_h);
$crop_w = round($new_w / $size_ratio);
$crop_h = round($new_h / $size_ratio);
$s_x = floor(($orig_w - $crop_w) / 2);
$s_y = floor(($orig_h - $crop_h) / 2);
}else 
{{$crop_w = $orig_w;
$crop_h = $orig_h;
$s_x = 0;
$s_y = 0;
list($new_w,$new_h) = wp_constrain_dimensions($orig_w,$orig_h,$dest_w,$dest_h);
}}if ( $new_w >= $orig_w && $new_h >= $orig_h)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = array(0,0,(int)$s_x,(int)$s_y,(int)$new_w,(int)$new_h,(int)$crop_w,(int)$crop_h);
return $AspisRetTemp;
} }
function image_resize ( $file,$max_w,$max_h,$crop = false,$suffix = null,$dest_path = null,$jpeg_quality = 90 ) {
$image = wp_load_image($file);
if ( !is_resource($image))
 {$AspisRetTemp = new WP_Error('error_loading_image',$image);
return $AspisRetTemp;
}$size = @getimagesize($file);
if ( !$size)
 {$AspisRetTemp = new WP_Error('invalid_image',__('Could not read image size'),$file);
return $AspisRetTemp;
}list($orig_w,$orig_h,$orig_type) = $size;
$dims = image_resize_dimensions($orig_w,$orig_h,$max_w,$max_h,$crop);
if ( !$dims)
 {$AspisRetTemp = $dims;
return $AspisRetTemp;
}list($dst_x,$dst_y,$src_x,$src_y,$dst_w,$dst_h,$src_w,$src_h) = $dims;
$newimage = wp_imagecreatetruecolor($dst_w,$dst_h);
imagecopyresampled($newimage,$image,$dst_x,$dst_y,$src_x,$src_y,$dst_w,$dst_h,$src_w,$src_h);
if ( IMAGETYPE_PNG == $orig_type && !imageistruecolor($image))
 imagetruecolortopalette($newimage,false,imagecolorstotal($image));
imagedestroy($image);
if ( !$suffix)
 $suffix = "{$dst_w}x{$dst_h}";
$info = pathinfo($file);
$dir = $info['dirname'];
$ext = $info['extension'];
$name = basename($file,".{$ext}");
if ( !is_null($dest_path) and $_dest_path = realpath($dest_path))
 $dir = $_dest_path;
$destfilename = "{$dir}/{$name}-{$suffix}.{$ext}";
if ( IMAGETYPE_GIF == $orig_type)
 {if ( !imagegif($newimage,$destfilename))
 {$AspisRetTemp = new WP_Error('resize_path_invalid',__('Resize path invalid'));
return $AspisRetTemp;
}}elseif ( IMAGETYPE_PNG == $orig_type)
 {if ( !imagepng($newimage,$destfilename))
 {$AspisRetTemp = new WP_Error('resize_path_invalid',__('Resize path invalid'));
return $AspisRetTemp;
}}else 
{{$destfilename = "{$dir}/{$name}-{$suffix}.jpg";
if ( !imagejpeg($newimage,$destfilename,apply_filters('jpeg_quality',$jpeg_quality,'image_resize')))
 {$AspisRetTemp = new WP_Error('resize_path_invalid',__('Resize path invalid'));
return $AspisRetTemp;
}}}imagedestroy($newimage);
$stat = stat(dirname($destfilename));
$perms = $stat['mode'] & 0000666;
@chmod($destfilename,$perms);
{$AspisRetTemp = $destfilename;
return $AspisRetTemp;
} }
function image_make_intermediate_size ( $file,$width,$height,$crop = false ) {
if ( $width || $height)
 {$resized_file = image_resize($file,$width,$height,$crop);
if ( !is_wp_error($resized_file) && $resized_file && $info = getimagesize($resized_file))
 {$resized_file = apply_filters('image_make_intermediate_size',$resized_file);
{$AspisRetTemp = array('file' => basename($resized_file),'width' => $info[0],'height' => $info[1],);
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function image_get_intermediate_size ( $post_id,$size = 'thumbnail' ) {
if ( !is_array($imagedata = wp_get_attachment_metadata($post_id)))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( is_array($size) && !empty($imagedata['sizes']))
 {foreach ( $imagedata['sizes'] as $_size =>$data )
{if ( ($data['width'] == $size[0] && $data['height'] <= $size[1]) || ($data['height'] == $size[1] && $data['width'] <= $size[0]))
 {$file = $data['file'];
list($width,$height) = image_constrain_size_for_editor($data['width'],$data['height'],$size);
{$AspisRetTemp = compact('file','width','height');
return $AspisRetTemp;
}}$areas[$data['width'] * $data['height']] = $_size;
}if ( !$size || !empty($areas))
 {ksort($areas);
foreach ( $areas as $_size  )
{$data = $imagedata['sizes'][$_size];
if ( $data['width'] >= $size[0] || $data['height'] >= $size[1])
 {$file = $data['file'];
list($width,$height) = image_constrain_size_for_editor($data['width'],$data['height'],$size);
{$AspisRetTemp = compact('file','width','height');
return $AspisRetTemp;
}}}}}if ( is_array($size) || empty($size) || empty($imagedata['sizes'][$size]))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$data = $imagedata['sizes'][$size];
if ( empty($data['path']) && !empty($data['file']))
 {$file_url = wp_get_attachment_url($post_id);
$data['path'] = path_join(dirname($imagedata['file']),$data['file']);
$data['url'] = path_join(dirname($file_url),$data['file']);
}{$AspisRetTemp = $data;
return $AspisRetTemp;
} }
function wp_get_attachment_image_src ( $attachment_id,$size = 'thumbnail',$icon = false ) {
if ( $image = image_downsize($attachment_id,$size))
 {$AspisRetTemp = $image;
return $AspisRetTemp;
}$src = false;
if ( $icon && $src = wp_mime_type_icon($attachment_id))
 {$icon_dir = apply_filters('icon_dir',ABSPATH . WPINC . '/images/crystal');
$src_file = $icon_dir . '/' . basename($src);
@list($width,$height) = getimagesize($src_file);
}if ( $src && $width && $height)
 {$AspisRetTemp = array($src,$width,$height);
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_get_attachment_image ( $attachment_id,$size = 'thumbnail',$icon = false,$attr = '' ) {
$html = '';
$image = wp_get_attachment_image_src($attachment_id,$size,$icon);
if ( $image)
 {list($src,$width,$height) = $image;
$hwstring = image_hwstring($width,$height);
if ( is_array($size))
 $size = join('x',$size);
$attachment = &get_post($attachment_id);
$default_attr = array('src' => $src,'class' => "attachment-$size",'alt' => trim(strip_tags($attachment->post_excerpt)),'title' => trim(strip_tags($attachment->post_title)),);
$attr = wp_parse_args($attr,$default_attr);
$attr = apply_filters('wp_get_attachment_image_attributes',$attr,$attachment);
$attr = array_map('esc_attr',$attr);
$html = rtrim("<img $hwstring");
foreach ( $attr as $name =>$value )
{$html .= " $name=" . '"' . $value . '"';
}$html .= ' />';
}{$AspisRetTemp = $html;
return $AspisRetTemp;
} }
function _wp_post_thumbnail_class_filter ( $attr ) {
$attr['class'] .= ' wp-post-image';
{$AspisRetTemp = $attr;
return $AspisRetTemp;
} }
function _wp_post_thumbnail_class_filter_add ( $attr ) {
add_filter('wp_get_attachment_image_attributes','_wp_post_thumbnail_class_filter');
 }
function _wp_post_thumbnail_class_filter_remove ( $attr ) {
remove_filter('wp_get_attachment_image_attributes','_wp_post_thumbnail_class_filter');
 }
add_shortcode('wp_caption','img_caption_shortcode');
add_shortcode('caption','img_caption_shortcode');
function img_caption_shortcode ( $attr,$content = null ) {
$output = apply_filters('img_caption_shortcode','',$attr,$content);
if ( $output != '')
 {$AspisRetTemp = $output;
return $AspisRetTemp;
}extract((shortcode_atts(array('id' => '','align' => 'alignnone','width' => '','caption' => ''),$attr)));
if ( 1 > (int)$width || empty($caption))
 {$AspisRetTemp = $content;
return $AspisRetTemp;
}if ( $id)
 $id = 'id="' . esc_attr($id) . '" ';
{$AspisRetTemp = '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . (10 + (int)$width) . 'px">' . do_shortcode($content) . '<p class="wp-caption-text">' . $caption . '</p></div>';
return $AspisRetTemp;
} }
add_shortcode('gallery','gallery_shortcode');
function gallery_shortcode ( $attr ) {
{global $post,$wp_locale;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_locale,"\$wp_locale",$AspisChangesCache);
}static $instance = 0;
$instance++;
$output = apply_filters('post_gallery','',$attr);
if ( $output != '')
 {$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}if ( isset($attr['orderby']))
 {$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
if ( !$attr['orderby'])
 unset($attr['orderby']);
}extract((shortcode_atts(array('order' => 'ASC','orderby' => 'menu_order ID','id' => $post->ID,'itemtag' => 'dl','icontag' => 'dt','captiontag' => 'dd','columns' => 3,'size' => 'thumbnail','include' => '','exclude' => ''),$attr)));
$id = intval($id);
if ( 'RAND' == $order)
 $orderby = 'none';
if ( !empty($include))
 {$include = preg_replace('/[^0-9,]+/','',$include);
$_attachments = get_posts(array('include' => $include,'post_status' => 'inherit','post_type' => 'attachment','post_mime_type' => 'image','order' => $order,'orderby' => $orderby));
$attachments = array();
foreach ( $_attachments as $key =>$val )
{$attachments[$val->ID] = $_attachments[$key];
}}elseif ( !empty($exclude))
 {$exclude = preg_replace('/[^0-9,]+/','',$exclude);
$attachments = get_children(array('post_parent' => $id,'exclude' => $exclude,'post_status' => 'inherit','post_type' => 'attachment','post_mime_type' => 'image','order' => $order,'orderby' => $orderby));
}else 
{{$attachments = get_children(array('post_parent' => $id,'post_status' => 'inherit','post_type' => 'attachment','post_mime_type' => 'image','order' => $order,'orderby' => $orderby));
}}if ( empty($attachments))
 {$AspisRetTemp = '';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}if ( is_feed())
 {$output = "\n";
foreach ( $attachments as $att_id =>$attachment )
$output .= wp_get_attachment_link($att_id,$size,true) . "\n";
{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}}$itemtag = tag_escape($itemtag);
$captiontag = tag_escape($captiontag);
$columns = intval($columns);
$itemwidth = $columns > 0 ? floor(100 / $columns) : 100;
$float = $wp_locale->text_direction == 'rtl' ? 'right' : 'left';
$selector = "gallery-{$instance}";
$output = apply_filters('gallery_style',"
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->
		<div id='$selector' class='gallery galleryid-{$id}'>");
$i = 0;
foreach ( $attachments as $id =>$attachment )
{$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id,$size,false,false) : wp_get_attachment_link($id,$size,true,false);
$output .= "<{$itemtag} class='gallery-item'>";
$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
if ( $captiontag && trim($attachment->post_excerpt))
 {$output .= "
				<{$captiontag} class='gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
}$output .= "</{$itemtag}>";
if ( $columns > 0 && ++$i % $columns == 0)
 $output .= '<br style="clear: both" />';
}$output .= "
			<br style='clear: both;' />
		</div>\n";
{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
 }
function previous_image_link ( $size = 'thumbnail',$text = false ) {
adjacent_image_link(true,$size,$text);
 }
function next_image_link ( $size = 'thumbnail',$text = false ) {
adjacent_image_link(false,$size,$text);
 }
function adjacent_image_link ( $prev = true,$size = 'thumbnail',$text = false ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$post = get_post($post);
$attachments = array_values(get_children(array('post_parent' => $post->post_parent,'post_status' => 'inherit','post_type' => 'attachment','post_mime_type' => 'image','order' => 'ASC','orderby' => 'menu_order ID')));
foreach ( $attachments as $k =>$attachment )
if ( $attachment->ID == $post->ID)
 break ;
$k = $prev ? $k - 1 : $k + 1;
if ( isset($attachments[$k]))
 echo wp_get_attachment_link($attachments[$k]->ID,$size,true,false,$text);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function get_attachment_taxonomies ( $attachment ) {
if ( is_int($attachment))
 $attachment = get_post($attachment);
else 
{if ( is_array($attachment))
 $attachment = (object)$attachment;
}if ( !is_object($attachment))
 {$AspisRetTemp = array();
return $AspisRetTemp;
}$filename = basename($attachment->guid);
$objects = array('attachment');
if ( false !== strpos($filename,'.'))
 $objects[] = 'attachment:' . substr($filename,strrpos($filename,'.') + 1);
if ( !empty($attachment->post_mime_type))
 {$objects[] = 'attachment:' . $attachment->post_mime_type;
if ( false !== strpos($attachment->post_mime_type,'/'))
 foreach ( explode('/',$attachment->post_mime_type) as $token  )
if ( !empty($token))
 $objects[] = "attachment:$token";
}$taxonomies = array();
foreach ( $objects as $object  )
if ( $taxes = get_object_taxonomies($object))
 $taxonomies = array_merge($taxonomies,$taxes);
{$AspisRetTemp = array_unique($taxonomies);
return $AspisRetTemp;
} }
function gd_edit_image_support ( $mime_type ) {
if ( function_exists('imagetypes'))
 {switch ( $mime_type ) {
case 'image/jpeg':{$AspisRetTemp = (imagetypes() & IMG_JPG) != 0;
return $AspisRetTemp;
}case 'image/png':{$AspisRetTemp = (imagetypes() & IMG_PNG) != 0;
return $AspisRetTemp;
}case 'image/gif':{$AspisRetTemp = (imagetypes() & IMG_GIF) != 0;
return $AspisRetTemp;
} }
}else 
{{switch ( $mime_type ) {
case 'image/jpeg':{$AspisRetTemp = function_exists('imagecreatefromjpeg');
return $AspisRetTemp;
}case 'image/png':{$AspisRetTemp = function_exists('imagecreatefrompng');
return $AspisRetTemp;
}case 'image/gif':{$AspisRetTemp = function_exists('imagecreatefromgif');
return $AspisRetTemp;
} }
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_imagecreatetruecolor ( $width,$height ) {
$img = imagecreatetruecolor($width,$height);
if ( is_resource($img) && function_exists('imagealphablending') && function_exists('imagesavealpha'))
 {imagealphablending($img,false);
imagesavealpha($img,true);
}{$AspisRetTemp = $img;
return $AspisRetTemp;
} }
class WP_Embed{var $handlers = array();
var $post_ID;
var $usecache = true;
var $linkifunknown = true;
function WP_Embed (  ) {
{{$AspisRetTemp = $this->__construct();
return $AspisRetTemp;
}} }
function __construct (  ) {
{add_filter('the_content',array($this,'run_shortcode'),8);
if ( get_option('embed_autourls'))
 add_filter('the_content',array($this,'autoembed'),8);
add_action('save_post',array($this,'delete_oembed_caches'));
add_action('edit_form_advanced',array($this,'maybe_run_ajax_cache'));
} }
function run_shortcode ( $content ) {
{{global $shortcode_tags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $shortcode_tags,"\$shortcode_tags",$AspisChangesCache);
}$orig_shortcode_tags = $shortcode_tags;
remove_all_shortcodes();
add_shortcode('embed',array($this,'shortcode'));
$content = do_shortcode($content);
$shortcode_tags = $orig_shortcode_tags;
{$AspisRetTemp = $content;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$shortcode_tags",$AspisChangesCache);
 }
function maybe_run_ajax_cache (  ) {
{{global $post_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post_ID,"\$post_ID",$AspisChangesCache);
}if ( empty($post_ID) || (empty($_GET[0]['message']) || Aspis_empty($_GET[0]['message'])) || 1 != deAspisWarningRC($_GET[0]['message']))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post_ID",$AspisChangesCache);
return ;
};
?>
<script type="text/javascript">
/* <![CDATA[ */
	jQuery(document).ready(function($){
		$.get("<?php echo admin_url('admin-ajax.php?action=oembed-cache&post=' . $post_ID);
;
?>");
	});
/* ]]> */
</script>
<?php }AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post_ID",$AspisChangesCache);
 }
function register_handler ( $id,$regex,$callback,$priority = 10 ) {
{$this->handlers[$priority][$id] = array('regex' => $regex,'callback' => $callback,);
} }
function unregister_handler ( $id,$priority = 10 ) {
{if ( isset($this->handlers[$priority][$id]))
 unset($this->handlers[$priority][$id]);
} }
function shortcode ( $attr,$url = '' ) {
{{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}if ( empty($url))
 {$AspisRetTemp = '';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}$rawattr = $attr;
$attr = wp_parse_args($attr,wp_embed_defaults());
ksort($this->handlers);
foreach ( $this->handlers as $priority =>$handlers )
{foreach ( $handlers as $id =>$handler )
{if ( preg_match($handler['regex'],$url,$matches) && is_callable($handler['callback']))
 {if ( false !== $return = AspisUntainted_call_user_func($handler['callback'],$matches,$attr,$url,$rawattr))
 {$AspisRetTemp = apply_filters('embed_handler_html',$return,$url,$attr);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}}}}$post_ID = (!empty($post->ID)) ? $post->ID : null;
if ( !empty($this->post_ID))
 $post_ID = $this->post_ID;
if ( $post_ID)
 {$cachekey = '_oembed_' . md5($url . serialize($attr));
if ( $this->usecache)
 {$cache = get_post_meta($post_ID,$cachekey,true);
if ( '{{unknown}}' === $cache)
 {$AspisRetTemp = $this->maybe_make_link($url);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}if ( !empty($cache))
 {$AspisRetTemp = apply_filters('embed_oembed_html',$cache,$url,$attr);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}}$attr['discover'] = (apply_filters('embed_oembed_discover',false) && author_can($post_ID,'unfiltered_html')) ? true : false;
$html = wp_oembed_get($url,$attr);
$cache = ($html) ? $html : '{{unknown}}';
update_post_meta($post_ID,$cachekey,$cache);
if ( $html)
 {$AspisRetTemp = apply_filters('embed_oembed_html',$html,$url,$attr);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = $this->maybe_make_link($url);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function delete_oembed_caches ( $post_ID ) {
{$post_metas = get_post_custom_keys($post_ID);
if ( empty($post_metas))
 {return ;
}foreach ( $post_metas as $post_meta_key  )
{if ( '_oembed_' == substr($post_meta_key,0,8))
 delete_post_meta($post_ID,$post_meta_key);
}} }
function cache_oembed ( $post_ID ) {
{$post = get_post($post_ID);
if ( empty($post->ID) || !in_array($post->post_type,apply_filters('embed_cache_oembed_types',array('post','page'))))
 {return ;
}if ( !empty($post->post_content))
 {$this->post_ID = $post->ID;
$this->usecache = false;
$content = $this->run_shortcode($post->post_content);
if ( get_option('embed_autourls'))
 $this->autoembed($content);
$this->usecache = true;
}} }
function autoembed ( $content ) {
{{$AspisRetTemp = preg_replace_callback('|^\s*(https?://[^\s"]+)\s*$|im',array(&$this,'autoembed_callback'),$content);
return $AspisRetTemp;
}} }
function autoembed_callback ( $match ) {
{$oldval = $this->linkifunknown;
$this->linkifunknown = false;
$return = $this->shortcode(array(),$match[1]);
$this->linkifunknown = $oldval;
{$AspisRetTemp = "\n$return\n";
return $AspisRetTemp;
}} }
function maybe_make_link ( $url ) {
{$output = ($this->linkifunknown) ? '<a href="' . esc_attr($url) . '">' . esc_html($url) . '</a>' : $url;
{$AspisRetTemp = apply_filters('embed_maybe_make_link',$output,$url);
return $AspisRetTemp;
}} }
}$wp_embed = new WP_Embed();
function wp_embed_register_handler ( $id,$regex,$callback,$priority = 10 ) {
{global $wp_embed;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_embed,"\$wp_embed",$AspisChangesCache);
}$wp_embed->register_handler($id,$regex,$callback,$priority);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_embed",$AspisChangesCache);
 }
function wp_embed_unregister_handler ( $id,$priority = 10 ) {
{global $wp_embed;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_embed,"\$wp_embed",$AspisChangesCache);
}$wp_embed->unregister_handler($id,$priority);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_embed",$AspisChangesCache);
 }
function wp_embed_defaults (  ) {
if ( !empty($GLOBALS[0]['content_width']))
 $theme_width = (int)$GLOBALS[0]['content_width'];
$width = get_option('embed_size_w');
if ( !$width && !empty($theme_width))
 $width = $theme_width;
if ( !$width)
 $width = 500;
{$AspisRetTemp = apply_filters('embed_defaults',array('width' => $width,'height' => 700,));
return $AspisRetTemp;
} }
function wp_expand_dimensions ( $example_width,$example_height,$max_width,$max_height ) {
$example_width = (int)$example_width;
$example_height = (int)$example_height;
$max_width = (int)$max_width;
$max_height = (int)$max_height;
{$AspisRetTemp = wp_constrain_dimensions($example_width * 1000000,$example_height * 1000000,$max_width,$max_height);
return $AspisRetTemp;
} }
function wp_oembed_get ( $url,$args = '' ) {
require_once ('class-oembed.php');
$oembed = _wp_oembed_get_object();
{$AspisRetTemp = $oembed->get_html($url,$args);
return $AspisRetTemp;
} }
function wp_oembed_add_provider ( $format,$provider,$regex = false ) {
require_once ('class-oembed.php');
$oembed = _wp_oembed_get_object();
$oembed->providers[$format] = array($provider,$regex);
 }
