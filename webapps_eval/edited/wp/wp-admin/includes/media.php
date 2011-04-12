<?php require_once('AspisMain.php'); ?><?php
function media_upload_tabs (  ) {
$_default_tabs = array(array(deregisterTaint(array('type',false)) => addTaint(__(array('From Computer',false))),deregisterTaint(array('type_url',false)) => addTaint(__(array('From URL',false))),deregisterTaint(array('gallery',false)) => addTaint(__(array('Gallery',false))),deregisterTaint(array('library',false)) => addTaint(__(array('Media Library',false)))),false);
return apply_filters(array('media_upload_tabs',false),$_default_tabs);
 }
function update_gallery_tab ( $tabs ) {
global $wpdb;
if ( (!((isset($_REQUEST[0][('post_id')]) && Aspis_isset( $_REQUEST [0][('post_id')])))))
 {unset($tabs[0][('gallery')]);
return $tabs;
}$post_id = Aspis_intval($_REQUEST[0]['post_id']);
if ( $post_id[0])
 $attachments = Aspis_intval($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT count(*) FROM ",$wpdb[0]->posts)," WHERE post_type = 'attachment' AND post_status != 'trash' AND post_parent = %d"),$post_id)));
if ( ((empty($attachments) || Aspis_empty( $attachments))))
 {unset($tabs[0][('gallery')]);
return $tabs;
}arrayAssign($tabs[0],deAspis(registerTaint(array('gallery',false))),addTaint(Aspis_sprintf(__(array('Gallery (%s)',false)),concat2(concat1("<span id='attachments-count'>",$attachments),"</span>"))));
return $tabs;
 }
add_filter(array('media_upload_tabs',false),array('update_gallery_tab',false));
function the_media_upload_tabs (  ) {
global $redir_tab;
$tabs = media_upload_tabs();
if ( (!((empty($tabs) || Aspis_empty( $tabs)))))
 {echo AspisCheckPrint(array("<ul id='sidemenu'>\n",false));
if ( (((isset($redir_tab) && Aspis_isset( $redir_tab))) && array_key_exists(deAspisRC($redir_tab),deAspisRC($tabs))))
 $current = $redir_tab;
elseif ( (((isset($_GET[0][('tab')]) && Aspis_isset( $_GET [0][('tab')]))) && array_key_exists(deAspisRC($_GET[0]['tab']),deAspisRC($tabs))))
 $current = $_GET[0]['tab'];
else 
{$current = apply_filters(array('media_upload_default_tab',false),array('type',false));
}foreach ( $tabs[0] as $callback =>$text )
{restoreTaint($callback,$text);
{$class = array('',false);
if ( ($current[0] == $callback[0]))
 $class = array(" class='current'",false);
$href = add_query_arg(array(array(deregisterTaint(array('tab',false)) => addTaint($callback),'s' => array(false,false,false),'paged' => array(false,false,false),'post_mime_type' => array(false,false,false),'m' => array(false,false,false)),false));
$link = concat(concat1("<a href='",esc_url($href)),concat2(concat(concat2(concat1("'",$class),">"),$text),"</a>"));
echo AspisCheckPrint(concat(concat1("\t<li id='",esc_attr(concat1("tab-",$callback))),concat2(concat1("'>",$link),"</li>\n")));
}}echo AspisCheckPrint(array("</ul>\n",false));
} }
function get_image_send_to_editor ( $id,$caption,$title,$align,$url = array('',false),$rel = array(false,false),$size = array('medium',false),$alt = array('',false) ) {
$html = get_image_tag($id,$alt,$title,$align,$size);
$rel = $rel[0] ? concat2(concat1(' rel="attachment wp-att-',esc_attr($id)),'"') : array('',false);
if ( $url[0])
 $html = concat(concat1('<a href="',esc_attr($url)),concat2(concat(concat2(concat1("\"",$rel),">"),$html),"</a>"));
$html = apply_filters(array('image_send_to_editor',false),$html,$id,$caption,$title,$align,$url,$size,$alt);
return $html;
 }
function image_add_caption ( $html,$id,$caption,$title,$align,$url,$size,$alt = array('',false) ) {
if ( (((empty($caption) || Aspis_empty( $caption))) || deAspis(apply_filters(array('disable_captions',false),array('',false)))))
 return $html;
$id = ((0) < deAspis(int_cast($id))) ? concat1('attachment_',$id) : array('',false);
if ( (denot_boolean(Aspis_preg_match(array('/width="([0-9]+)/',false),$html,$matches))))
 return $html;
$width = attachAspis($matches,(1));
$html = Aspis_preg_replace(array('/(class=["\'][^\'"]*)align(none|left|right|center)\s?/',false),array('$1',false),$html);
if ( ((empty($align) || Aspis_empty( $align))))
 $align = array('none',false);
$shcode = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('[caption id="',$id),'" align="align'),$align),'" width="'),$width),'" caption="'),Aspis_addslashes($caption)),'"]'),$html),'[/caption]');
return apply_filters(array('image_add_caption_shortcode',false),$shcode,$html);
 }
add_filter(array('image_send_to_editor',false),array('image_add_caption',false),array(20,false),array(8,false));
function media_send_to_editor ( $html ) {
;
?>
<script type="text/javascript">
/* <![CDATA[ */
var win = window.dialogArguments || opener || parent || top;
win.send_to_editor('<?php echo AspisCheckPrint(Aspis_addslashes($html));
;
?>');
/* ]]> */
</script>
<?php Aspis_exit();
 }
function media_handle_upload ( $file_id,$post_id,$post_data = array(array(),false) ) {
$overrides = array(array('test_form' => array(false,false,false)),false);
$time = current_time(array('mysql',false));
if ( deAspis($post = get_post($post_id)))
 {if ( (deAspis(Aspis_substr($post[0]->post_date,array(0,false),array(4,false))) > (0)))
 $time = $post[0]->post_date;
}$name = $_FILES[0][$file_id[0]][0]['name'];
$file = wp_handle_upload(attachAspis($_FILES,$file_id[0]),$overrides,$time);
if ( ((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))))
 return array(new WP_Error(array('upload_error',false),$file[0]['error']),false);
$name_parts = Aspis_pathinfo($name);
$name = Aspis_trim(Aspis_substr($name,array(0,false),negate((array((1) + strlen(deAspis($name_parts[0]['extension'])),false)))));
$url = $file[0]['url'];
$type = $file[0]['type'];
$file = $file[0]['file'];
$title = $name;
$content = array('',false);
if ( deAspis($image_meta = @wp_read_image_metadata($file)))
 {if ( deAspis(Aspis_trim($image_meta[0]['title'])))
 $title = $image_meta[0]['title'];
if ( deAspis(Aspis_trim($image_meta[0]['caption'])))
 $content = $image_meta[0]['caption'];
}$attachment = Aspis_array_merge(array(array(deregisterTaint(array('post_mime_type',false)) => addTaint($type),deregisterTaint(array('guid',false)) => addTaint($url),deregisterTaint(array('post_parent',false)) => addTaint($post_id),deregisterTaint(array('post_title',false)) => addTaint($title),deregisterTaint(array('post_content',false)) => addTaint($content),),false),$post_data);
$id = wp_insert_attachment($attachment,$file,$post_id);
if ( (denot_boolean(is_wp_error($id))))
 {wp_update_attachment_metadata($id,wp_generate_attachment_metadata($id,$file));
}return $id;
 }
function media_handle_sideload ( $file_array,$post_id,$desc = array(null,false),$post_data = array(array(),false) ) {
$overrides = array(array('test_form' => array(false,false,false)),false);
$file = wp_handle_sideload($file_array,$overrides);
if ( ((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))))
 return array(new WP_Error(array('upload_error',false),$file[0]['error']),false);
$url = $file[0]['url'];
$type = $file[0]['type'];
$file = $file[0]['file'];
$title = Aspis_preg_replace(array('/\.[^.]+$/',false),array('',false),Aspis_basename($file));
$content = array('',false);
if ( deAspis($image_meta = @wp_read_image_metadata($file)))
 {if ( deAspis(Aspis_trim($image_meta[0]['title'])))
 $title = $image_meta[0]['title'];
if ( deAspis(Aspis_trim($image_meta[0]['caption'])))
 $content = $image_meta[0]['caption'];
}$title = @$desc;
$attachment = Aspis_array_merge(array(array(deregisterTaint(array('post_mime_type',false)) => addTaint($type),deregisterTaint(array('guid',false)) => addTaint($url),deregisterTaint(array('post_parent',false)) => addTaint($post_id),deregisterTaint(array('post_title',false)) => addTaint($title),deregisterTaint(array('post_content',false)) => addTaint($content),),false),$post_data);
$id = wp_insert_attachment($attachment,$file,$post_id);
if ( (denot_boolean(is_wp_error($id))))
 {wp_update_attachment_metadata($id,wp_generate_attachment_metadata($id,$file));
return $url;
}return $id;
 }
function wp_iframe ( $content_func ) {
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php do_action(array('admin_xml_ns',false));
;
?> <?php language_attributes();
;
?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo(array('html_type',false));
;
?>; charset=<?php echo AspisCheckPrint(get_option(array('blog_charset',false)));
;
?>" />
<title><?php bloginfo(array('name',false));
?> &rsaquo; <?php _e(array('Uploads',false));
;
?> &#8212; <?php _e(array('WordPress',false));
;
?></title>
<?php wp_enqueue_style(array('global',false));
wp_enqueue_style(array('wp-admin',false));
wp_enqueue_style(array('colors',false));
if ( ((0) === strpos($content_func[0],'media')))
 wp_enqueue_style(array('media',false));
wp_enqueue_style(array('ie',false));
;
?>
<script type="text/javascript">
//<![CDATA[
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
var userSettings = {'url':'<?php echo AspisCheckPrint(array(SITECOOKIEPATH,false));
;
?>','uid':'<?php if ( (!((isset($current_user) && Aspis_isset( $current_user)))))
 $current_user = wp_get_current_user();
echo AspisCheckPrint($current_user[0]->ID);
;
?>','time':'<?php echo AspisCheckPrint(attAspis(time()));
;
?>'};
var ajaxurl = '<?php echo AspisCheckPrint(admin_url(array('admin-ajax.php',false)));
;
?>', pagenow = 'media-upload-popup', adminpage = 'media-upload-popup';
//]]>
</script>
<?php do_action(array('admin_enqueue_scripts',false),array('media-upload-popup',false));
do_action(array('admin_print_styles-media-upload-popup',false));
do_action(array('admin_print_styles',false));
do_action(array('admin_print_scripts-media-upload-popup',false));
do_action(array('admin_print_scripts',false));
do_action(array('admin_head-media-upload-popup',false));
do_action(array('admin_head',false));
if ( is_string(deAspisRC($content_func)))
 do_action(concat1("admin_head_",$content_func));
;
?>
</head>
<body<?php if ( ((isset($GLOBALS[0][('body_id')]) && Aspis_isset( $GLOBALS [0][('body_id')]))))
 echo AspisCheckPrint(concat2(concat1(' id="',$GLOBALS[0]['body_id']),'"'));
;
?>>
<?php $args = array(func_get_args(),false);
$args = Aspis_array_slice($args,array(1,false));
Aspis_call_user_func_array($content_func,$args);
do_action(array('admin_print_footer_scripts',false));
;
?>
<script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>
</body>
</html>
<?php  }
function media_buttons (  ) {
global $post_ID,$temp_ID;
$uploading_iframe_ID = int_cast((((0) == $post_ID[0]) ? $temp_ID : $post_ID));
$context = apply_filters(array('media_buttons_context',false),__(array('Upload/Insert %s',false)));
$media_upload_iframe_src = concat1("media-upload.php?post_id=",$uploading_iframe_ID);
$media_title = __(array('Add Media',false));
$image_upload_iframe_src = apply_filters(array('image_upload_iframe_src',false),concat2($media_upload_iframe_src,"&amp;type=image"));
$image_title = __(array('Add an Image',false));
$video_upload_iframe_src = apply_filters(array('video_upload_iframe_src',false),concat2($media_upload_iframe_src,"&amp;type=video"));
$video_title = __(array('Add Video',false));
$audio_upload_iframe_src = apply_filters(array('audio_upload_iframe_src',false),concat2($media_upload_iframe_src,"&amp;type=audio"));
$audio_title = __(array('Add Audio',false));
$out = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1(<<<EOF_PHPAspis_Part0

	<a href="
EOF_PHPAspis_Part0
,$image_upload_iframe_src),<<<EOF_PHPAspis_Part1
&amp;TB_iframe=true" id="add_image" class="thickbox" title='
EOF_PHPAspis_Part1
),$image_title),<<<EOF_PHPAspis_Part2
' onclick="return false;"><img src='images/media-button-image.gif' alt='
EOF_PHPAspis_Part2
),$image_title),<<<EOF_PHPAspis_Part3
' /></a>
	<a href="
EOF_PHPAspis_Part3
),$video_upload_iframe_src),<<<EOF_PHPAspis_Part4
&amp;TB_iframe=true" id="add_video" class="thickbox" title='
EOF_PHPAspis_Part4
),$video_title),<<<EOF_PHPAspis_Part5
' onclick="return false;"><img src='images/media-button-video.gif' alt='
EOF_PHPAspis_Part5
),$video_title),<<<EOF_PHPAspis_Part6
' /></a>
	<a href="
EOF_PHPAspis_Part6
),$audio_upload_iframe_src),<<<EOF_PHPAspis_Part7
&amp;TB_iframe=true" id="add_audio" class="thickbox" title='
EOF_PHPAspis_Part7
),$audio_title),<<<EOF_PHPAspis_Part8
' onclick="return false;"><img src='images/media-button-music.gif' alt='
EOF_PHPAspis_Part8
),$audio_title),<<<EOF_PHPAspis_Part9
' /></a>
	<a href="
EOF_PHPAspis_Part9
),$media_upload_iframe_src),<<<EOF_PHPAspis_Part10
&amp;TB_iframe=true" id="add_media" class="thickbox" title='
EOF_PHPAspis_Part10
),$media_title),<<<EOF_PHPAspis_Part11
' onclick="return false;"><img src='images/media-button-other.gif' alt='
EOF_PHPAspis_Part11
),$media_title),<<<EOF_PHPAspis_Part12
' /></a>

EOF_PHPAspis_Part12
);
printf($context[0],deAspisRC($out));
 }
add_action(array('media_buttons',false),array('media_buttons',false));
function media_upload_form_handler (  ) {
check_admin_referer(array('media-form',false));
$errors = array(null,false);
if ( ((isset($_POST[0][('send')]) && Aspis_isset( $_POST [0][('send')]))))
 {$keys = attAspisRC(array_keys(deAspisRC($_POST[0]['send'])));
$send_id = int_cast(Aspis_array_shift($keys));
}if ( (!((empty($_POST[0][('attachments')]) || Aspis_empty( $_POST [0][('attachments')])))))
 foreach ( deAspis($_POST[0]['attachments']) as $attachment_id =>$attachment )
{restoreTaint($attachment_id,$attachment);
{$post = $_post = get_post($attachment_id,array(ARRAY_A,false));
if ( ((isset($attachment[0][('post_content')]) && Aspis_isset( $attachment [0][('post_content')]))))
 arrayAssign($post[0],deAspis(registerTaint(array('post_content',false))),addTaint($attachment[0]['post_content']));
if ( ((isset($attachment[0][('post_title')]) && Aspis_isset( $attachment [0][('post_title')]))))
 arrayAssign($post[0],deAspis(registerTaint(array('post_title',false))),addTaint($attachment[0]['post_title']));
if ( ((isset($attachment[0][('post_excerpt')]) && Aspis_isset( $attachment [0][('post_excerpt')]))))
 arrayAssign($post[0],deAspis(registerTaint(array('post_excerpt',false))),addTaint($attachment[0]['post_excerpt']));
if ( ((isset($attachment[0][('menu_order')]) && Aspis_isset( $attachment [0][('menu_order')]))))
 arrayAssign($post[0],deAspis(registerTaint(array('menu_order',false))),addTaint($attachment[0]['menu_order']));
if ( (((isset($send_id) && Aspis_isset( $send_id))) && ($attachment_id[0] == $send_id[0])))
 {if ( ((isset($attachment[0][('post_parent')]) && Aspis_isset( $attachment [0][('post_parent')]))))
 arrayAssign($post[0],deAspis(registerTaint(array('post_parent',false))),addTaint($attachment[0]['post_parent']));
}$post = apply_filters(array('attachment_fields_to_save',false),$post,$attachment);
if ( (((isset($attachment[0][('image_alt')]) && Aspis_isset( $attachment [0][('image_alt')]))) && (!((empty($attachment[0][('image_alt')]) || Aspis_empty( $attachment [0][('image_alt')]))))))
 {$image_alt = get_post_meta($attachment_id,array('_wp_attachment_image_alt',false),array(true,false));
if ( ($image_alt[0] != deAspis(Aspis_stripslashes($attachment[0]['image_alt']))))
 {$image_alt = wp_strip_all_tags(Aspis_stripslashes($attachment[0]['image_alt']),array(true,false));
update_post_meta($attachment_id,array('_wp_attachment_image_alt',false),Aspis_addslashes($image_alt));
}}if ( ((isset($post[0][('errors')]) && Aspis_isset( $post [0][('errors')]))))
 {arrayAssign($errors[0],deAspis(registerTaint($attachment_id)),addTaint($post[0]['errors']));
unset($post[0][('errors')]);
}if ( ($post[0] != $_post[0]))
 wp_update_post($post);
foreach ( deAspis(get_attachment_taxonomies($post)) as $t  )
{if ( ((isset($attachment[0][$t[0]]) && Aspis_isset( $attachment [0][$t[0]]))))
 wp_set_object_terms($attachment_id,attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC(Aspis_preg_split(array('/,+/',false),attachAspis($attachment,$t[0]))))),$t,array(false,false));
}}}if ( (((isset($_POST[0][('insert-gallery')]) && Aspis_isset( $_POST [0][('insert-gallery')]))) || ((isset($_POST[0][('update-gallery')]) && Aspis_isset( $_POST [0][('update-gallery')])))))
 {;
?>
		<script type="text/javascript">
		/* <![CDATA[ */
		var win = window.dialogArguments || opener || parent || top;
		win.tb_remove();
		/* ]]> */
		</script>
		<?php Aspis_exit();
}if ( ((isset($send_id) && Aspis_isset( $send_id))))
 {$attachment = stripslashes_deep(attachAspis($_POST[0][('attachments')],$send_id[0]));
$html = $attachment[0]['post_title'];
if ( (!((empty($attachment[0][('url')]) || Aspis_empty( $attachment [0][('url')])))))
 {if ( (strpos(deAspis($attachment[0]['url']),'attachment_id') || (false !== strpos(deAspis($attachment[0]['url']),deAspisRC(get_permalink($_POST[0]['post_id']))))))
 $rel = concat2(concat1(" rel='attachment wp-att-",esc_attr($send_id)),"'");
$html = concat2(concat(concat2(concat(concat2(concat1("<a href='",$attachment[0]['url']),"'"),$rel),">"),$html),"</a>");
}$html = apply_filters(array('media_send_to_editor',false),$html,$send_id,$attachment);
return media_send_to_editor($html);
}return $errors;
 }
function media_upload_image (  ) {
$errors = array(array(),false);
$id = array(0,false);
if ( (((isset($_POST[0][('html-upload')]) && Aspis_isset( $_POST [0][('html-upload')]))) && (!((empty($_FILES) || Aspis_empty( $_FILES))))))
 {$id = media_handle_upload(array('async-upload',false),$_REQUEST[0]['post_id']);
unset($_FILES);
if ( deAspis(is_wp_error($id)))
 {arrayAssign($errors[0],deAspis(registerTaint(array('upload_error',false))),addTaint($id));
$id = array(false,false);
}}if ( (!((empty($_POST[0][('insertonlybutton')]) || Aspis_empty( $_POST [0][('insertonlybutton')])))))
 {$alt = $align = array('',false);
$src = $_POST[0][('insertonly')][0]['src'];
if ( ((!((empty($src) || Aspis_empty( $src)))) && (!(strpos($src[0],'://')))))
 $src = concat1("http://",$src);
$alt = esc_attr($_POST[0][('insertonly')][0]['alt']);
if ( ((isset($_POST[0][('insertonly')][0][('align')]) && Aspis_isset( $_POST [0][('insertonly')] [0][('align')]))))
 {$align = esc_attr($_POST[0][('insertonly')][0]['align']);
$class = concat2(concat1(" class='align",$align),"'");
}if ( (!((empty($src) || Aspis_empty( $src)))))
 $html = concat(concat1("<img src='",esc_url($src)),concat2(concat(concat2(concat1("' alt='",$alt),"'"),$class)," />"));
$html = apply_filters(array('image_send_to_editor_url',false),$html,esc_url_raw($src),$alt,$align);
return media_send_to_editor($html);
}if ( (!((empty($_POST) || Aspis_empty( $_POST)))))
 {$return = media_upload_form_handler();
if ( is_string(deAspisRC($return)))
 return $return;
if ( is_array($return[0]))
 $errors = $return;
}if ( ((isset($_POST[0][('save')]) && Aspis_isset( $_POST [0][('save')]))))
 {arrayAssign($errors[0],deAspis(registerTaint(array('upload_notice',false))),addTaint(__(array('Saved.',false))));
return media_upload_gallery();
}if ( (((isset($_GET[0][('tab')]) && Aspis_isset( $_GET [0][('tab')]))) && (deAspis($_GET[0]['tab']) == ('type_url'))))
 return wp_iframe(array('media_upload_type_url_form',false),array('image',false),$errors,$id);
return wp_iframe(array('media_upload_type_form',false),array('image',false),$errors,$id);
 }
function media_sideload_image ( $file,$post_id,$desc = array(null,false) ) {
if ( (!((empty($file) || Aspis_empty( $file)))))
 {$tmp = download_url($file);
Aspis_preg_match(array('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/',false),$file,$matches);
arrayAssign($file_array[0],deAspis(registerTaint(array('name',false))),addTaint(Aspis_basename(attachAspis($matches,(0)))));
arrayAssign($file_array[0],deAspis(registerTaint(array('tmp_name',false))),addTaint($tmp));
if ( deAspis(is_wp_error($tmp)))
 {@attAspis(unlink(deAspis($file_array[0]['tmp_name'])));
arrayAssign($file_array[0],deAspis(registerTaint(array('tmp_name',false))),addTaint(array('',false)));
}$id = media_handle_sideload($file_array,$post_id,@$desc);
$src = $id;
if ( deAspis(is_wp_error($id)))
 {@attAspis(unlink(deAspis($file_array[0]['tmp_name'])));
return $id;
}}if ( (!((empty($src) || Aspis_empty( $src)))))
 {$alt = @$desc;
$html = concat2(concat(concat2(concat1("<img src='",$src),"' alt='"),$alt),"' />");
return $html;
} }
function media_upload_audio (  ) {
$errors = array(array(),false);
$id = array(0,false);
if ( (((isset($_POST[0][('html-upload')]) && Aspis_isset( $_POST [0][('html-upload')]))) && (!((empty($_FILES) || Aspis_empty( $_FILES))))))
 {$id = media_handle_upload(array('async-upload',false),$_REQUEST[0]['post_id']);
unset($_FILES);
if ( deAspis(is_wp_error($id)))
 {arrayAssign($errors[0],deAspis(registerTaint(array('upload_error',false))),addTaint($id));
$id = array(false,false);
}}if ( (!((empty($_POST[0][('insertonlybutton')]) || Aspis_empty( $_POST [0][('insertonlybutton')])))))
 {$href = $_POST[0][('insertonly')][0]['href'];
if ( ((!((empty($href) || Aspis_empty( $href)))) && (!(strpos($href[0],'://')))))
 $href = concat1("http://",$href);
$title = esc_attr($_POST[0][('insertonly')][0]['title']);
if ( ((empty($title) || Aspis_empty( $title))))
 $title = esc_attr(Aspis_basename($href));
if ( ((!((empty($title) || Aspis_empty( $title)))) && (!((empty($href) || Aspis_empty( $href))))))
 $html = concat(concat1("<a href='",esc_url($href)),concat2(concat1("' >",$title),"</a>"));
$html = apply_filters(array('audio_send_to_editor_url',false),$html,$href,$title);
return media_send_to_editor($html);
}if ( (!((empty($_POST) || Aspis_empty( $_POST)))))
 {$return = media_upload_form_handler();
if ( is_string(deAspisRC($return)))
 return $return;
if ( is_array($return[0]))
 $errors = $return;
}if ( ((isset($_POST[0][('save')]) && Aspis_isset( $_POST [0][('save')]))))
 {arrayAssign($errors[0],deAspis(registerTaint(array('upload_notice',false))),addTaint(__(array('Saved.',false))));
return media_upload_gallery();
}if ( (((isset($_GET[0][('tab')]) && Aspis_isset( $_GET [0][('tab')]))) && (deAspis($_GET[0]['tab']) == ('type_url'))))
 return wp_iframe(array('media_upload_type_url_form',false),array('audio',false),$errors,$id);
return wp_iframe(array('media_upload_type_form',false),array('audio',false),$errors,$id);
 }
function media_upload_video (  ) {
$errors = array(array(),false);
$id = array(0,false);
if ( (((isset($_POST[0][('html-upload')]) && Aspis_isset( $_POST [0][('html-upload')]))) && (!((empty($_FILES) || Aspis_empty( $_FILES))))))
 {$id = media_handle_upload(array('async-upload',false),$_REQUEST[0]['post_id']);
unset($_FILES);
if ( deAspis(is_wp_error($id)))
 {arrayAssign($errors[0],deAspis(registerTaint(array('upload_error',false))),addTaint($id));
$id = array(false,false);
}}if ( (!((empty($_POST[0][('insertonlybutton')]) || Aspis_empty( $_POST [0][('insertonlybutton')])))))
 {$href = $_POST[0][('insertonly')][0]['href'];
if ( ((!((empty($href) || Aspis_empty( $href)))) && (!(strpos($href[0],'://')))))
 $href = concat1("http://",$href);
$title = esc_attr($_POST[0][('insertonly')][0]['title']);
if ( ((empty($title) || Aspis_empty( $title))))
 $title = esc_attr(Aspis_basename($href));
if ( ((!((empty($title) || Aspis_empty( $title)))) && (!((empty($href) || Aspis_empty( $href))))))
 $html = concat(concat1("<a href='",esc_url($href)),concat2(concat1("' >",$title),"</a>"));
$html = apply_filters(array('video_send_to_editor_url',false),$html,$href,$title);
return media_send_to_editor($html);
}if ( (!((empty($_POST) || Aspis_empty( $_POST)))))
 {$return = media_upload_form_handler();
if ( is_string(deAspisRC($return)))
 return $return;
if ( is_array($return[0]))
 $errors = $return;
}if ( ((isset($_POST[0][('save')]) && Aspis_isset( $_POST [0][('save')]))))
 {arrayAssign($errors[0],deAspis(registerTaint(array('upload_notice',false))),addTaint(__(array('Saved.',false))));
return media_upload_gallery();
}if ( (((isset($_GET[0][('tab')]) && Aspis_isset( $_GET [0][('tab')]))) && (deAspis($_GET[0]['tab']) == ('type_url'))))
 return wp_iframe(array('media_upload_type_url_form',false),array('video',false),$errors,$id);
return wp_iframe(array('media_upload_type_form',false),array('video',false),$errors,$id);
 }
function media_upload_file (  ) {
$errors = array(array(),false);
$id = array(0,false);
if ( (((isset($_POST[0][('html-upload')]) && Aspis_isset( $_POST [0][('html-upload')]))) && (!((empty($_FILES) || Aspis_empty( $_FILES))))))
 {$id = media_handle_upload(array('async-upload',false),$_REQUEST[0]['post_id']);
unset($_FILES);
if ( deAspis(is_wp_error($id)))
 {arrayAssign($errors[0],deAspis(registerTaint(array('upload_error',false))),addTaint($id));
$id = array(false,false);
}}if ( (!((empty($_POST[0][('insertonlybutton')]) || Aspis_empty( $_POST [0][('insertonlybutton')])))))
 {$href = $_POST[0][('insertonly')][0]['href'];
if ( ((!((empty($href) || Aspis_empty( $href)))) && (!(strpos($href[0],'://')))))
 $href = concat1("http://",$href);
$title = esc_attr($_POST[0][('insertonly')][0]['title']);
if ( ((empty($title) || Aspis_empty( $title))))
 $title = Aspis_basename($href);
if ( ((!((empty($title) || Aspis_empty( $title)))) && (!((empty($href) || Aspis_empty( $href))))))
 $html = concat(concat1("<a href='",esc_url($href)),concat2(concat1("' >",$title),"</a>"));
$html = apply_filters(array('file_send_to_editor_url',false),$html,esc_url_raw($href),$title);
return media_send_to_editor($html);
}if ( (!((empty($_POST) || Aspis_empty( $_POST)))))
 {$return = media_upload_form_handler();
if ( is_string(deAspisRC($return)))
 return $return;
if ( is_array($return[0]))
 $errors = $return;
}if ( ((isset($_POST[0][('save')]) && Aspis_isset( $_POST [0][('save')]))))
 {arrayAssign($errors[0],deAspis(registerTaint(array('upload_notice',false))),addTaint(__(array('Saved.',false))));
return media_upload_gallery();
}if ( (((isset($_GET[0][('tab')]) && Aspis_isset( $_GET [0][('tab')]))) && (deAspis($_GET[0]['tab']) == ('type_url'))))
 return wp_iframe(array('media_upload_type_url_form',false),array('file',false),$errors,$id);
return wp_iframe(array('media_upload_type_form',false),array('file',false),$errors,$id);
 }
function media_upload_gallery (  ) {
$errors = array(array(),false);
if ( (!((empty($_POST) || Aspis_empty( $_POST)))))
 {$return = media_upload_form_handler();
if ( is_string(deAspisRC($return)))
 return $return;
if ( is_array($return[0]))
 $errors = $return;
}wp_enqueue_script(array('admin-gallery',false));
return wp_iframe(array('media_upload_gallery_form',false),$errors);
 }
function media_upload_library (  ) {
$errors = array(array(),false);
if ( (!((empty($_POST) || Aspis_empty( $_POST)))))
 {$return = media_upload_form_handler();
if ( is_string(deAspisRC($return)))
 return $return;
if ( is_array($return[0]))
 $errors = $return;
}return wp_iframe(array('media_upload_library_form',false),$errors);
 }
function image_align_input_fields ( $post,$checked = array('',false) ) {
if ( ((empty($checked) || Aspis_empty( $checked))))
 $checked = get_user_setting(array('align',false),array('none',false));
$alignments = array(array(deregisterTaint(array('none',false)) => addTaint(__(array('None',false))),deregisterTaint(array('left',false)) => addTaint(__(array('Left',false))),deregisterTaint(array('center',false)) => addTaint(__(array('Center',false))),deregisterTaint(array('right',false)) => addTaint(__(array('Right',false)))),false);
if ( (!(array_key_exists(deAspisRC(string_cast($checked)),deAspisRC($alignments)))))
 $checked = array('none',false);
$out = array(array(),false);
foreach ( $alignments[0] as $name =>$label )
{restoreTaint($name,$label);
{$name = esc_attr($name);
arrayAssignAdd($out[0][],addTaint(concat(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<input type='radio' name='attachments[",$post[0]->ID),"][align]' id='image-align-"),$name),"-"),$post[0]->ID),"' value='"),$name),"'"),(($checked[0] == $name[0]) ? array(" checked='checked'",false) : array("",false))),concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" /><label for='image-align-",$name),"-"),$post[0]->ID),"' class='align image-align-"),$name),"-label'>"),$label),"</label>"))));
}}return Aspis_join(array("\n",false),$out);
 }
function image_size_input_fields ( $post,$check = array('',false) ) {
$size_names = array(array(deregisterTaint(array('thumbnail',false)) => addTaint(__(array('Thumbnail',false))),deregisterTaint(array('medium',false)) => addTaint(__(array('Medium',false))),deregisterTaint(array('large',false)) => addTaint(__(array('Large',false))),deregisterTaint(array('full',false)) => addTaint(__(array('Full size',false)))),false);
if ( ((empty($check) || Aspis_empty( $check))))
 $check = get_user_setting(array('imgsize',false),array('medium',false));
foreach ( $size_names[0] as $size =>$label )
{restoreTaint($size,$label);
{$downsize = image_downsize($post[0]->ID,$size);
$checked = array('',false);
$enabled = (array(deAspis(attachAspis($downsize,(3))) || (('full') == $size[0]),false));
$css_id = concat(concat2(concat1("image-size-",$size),"-"),$post[0]->ID);
if ( ($size[0] == $check[0]))
 {if ( $enabled[0])
 $checked = array(" checked='checked'",false);
else 
{$check = array('',false);
}}elseif ( (((denot_boolean($check)) && $enabled[0]) && (('thumbnail') != $size[0])))
 {$check = $size;
$checked = array(" checked='checked'",false);
}$html = concat(concat1("<div class='image-size-item'><input type='radio' ",($enabled[0] ? array('',false) : array("disabled='disabled' ",false))),concat2(concat(concat2(concat(concat2(concat(concat2(concat1("name='attachments[",$post[0]->ID),"][image-size]' id='"),$css_id),"' value='"),$size),"'"),$checked)," />"));
$html = concat($html,concat2(concat(concat2(concat1("<label for='",$css_id),"'>"),$label),"</label>"));
if ( $enabled[0])
 $html = concat($html,concat2(concat(concat2(concat1(" <label for='",$css_id),"' class='help'>"),Aspis_sprintf(__(array("(%d&nbsp;&times;&nbsp;%d)",false)),attachAspis($downsize,(1)),attachAspis($downsize,(2)))),"</label>"));
$html = concat2($html,'</div>');
arrayAssignAdd($out[0][],addTaint($html));
}}return array(array(deregisterTaint(array('label',false)) => addTaint(__(array('Size',false))),'input' => array('html',false,false),deregisterTaint(array('html',false)) => addTaint(Aspis_join(array("\n",false),$out)),),false);
 }
function image_link_input_fields ( $post,$url_type = array('',false) ) {
$file = wp_get_attachment_url($post[0]->ID);
$link = get_attachment_link($post[0]->ID);
if ( ((empty($url_type) || Aspis_empty( $url_type))))
 $url_type = get_user_setting(array('urlbutton',false),array('post',false));
$url = array('',false);
if ( ($url_type[0] == ('file')))
 $url = $file;
elseif ( ($url_type[0] == ('post')))
 $url = $link;
return concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("
	<input type='text' class='text urlfield' name='attachments[",$post[0]->ID),"][url]' value='"),esc_attr($url)),"' /><br />
	<button type='button' class='button urlnone' title=''>"),__(array('None',false))),"</button>
	<button type='button' class='button urlfile' title='"),esc_attr($file)),"'>"),__(array('File URL',false))),"</button>
	<button type='button' class='button urlpost' title='"),esc_attr($link)),"'>"),__(array('Post URL',false))),"</button>
");
 }
function image_attachment_fields_to_edit ( $form_fields,$post ) {
if ( (deAspis(Aspis_substr($post[0]->post_mime_type,array(0,false),array(5,false))) == ('image')))
 {$alt = get_post_meta($post[0]->ID,array('_wp_attachment_image_alt',false),array(true,false));
if ( ((empty($alt) || Aspis_empty( $alt))))
 $alt = array('',false);
arrayAssign($form_fields[0][('post_title')][0],deAspis(registerTaint(array('required',false))),addTaint(array(true,false)));
arrayAssign($form_fields[0],deAspis(registerTaint(array('image_alt',false))),addTaint(array(array(deregisterTaint(array('value',false)) => addTaint($alt),deregisterTaint(array('label',false)) => addTaint(__(array('Alternate text',false))),deregisterTaint(array('helps',false)) => addTaint(__(array('Alt text for the image, e.g. &#8220;The Mona Lisa&#8221;',false)))),false)));
arrayAssign($form_fields[0],deAspis(registerTaint(array('align',false))),addTaint(array(array(deregisterTaint(array('label',false)) => addTaint(__(array('Alignment',false))),'input' => array('html',false,false),deregisterTaint(array('html',false)) => addTaint(image_align_input_fields($post,get_option(array('image_default_align',false)))),),false)));
arrayAssign($form_fields[0],deAspis(registerTaint(array('image-size',false))),addTaint(image_size_input_fields($post,get_option(array('image_default_size',false),array('medium',false)))));
}else 
{{unset($form_fields[0][('image_alt')]);
}}return $form_fields;
 }
add_filter(array('attachment_fields_to_edit',false),array('image_attachment_fields_to_edit',false),array(10,false),array(2,false));
function media_single_attachment_fields_to_edit ( $form_fields,$post ) {
unset($form_fields[0][('url')],$form_fields[0][('align')],$form_fields[0][('image-size')]);
return $form_fields;
 }
function media_post_single_attachment_fields_to_edit ( $form_fields,$post ) {
unset($form_fields[0][('image_url')]);
return $form_fields;
 }
function image_attachment_fields_to_save ( $post,$attachment ) {
if ( (deAspis(Aspis_substr($post[0]['post_mime_type'],array(0,false),array(5,false))) == ('image')))
 {if ( (strlen(deAspis(Aspis_trim($post[0]['post_title']))) == (0)))
 {arrayAssign($post[0],deAspis(registerTaint(array('post_title',false))),addTaint(Aspis_preg_replace(array('/\.\w+$/',false),array('',false),Aspis_basename($post[0]['guid']))));
arrayAssignAdd($post[0][('errors')][0][('post_title')][0][('errors')][0][],addTaint(__(array('Empty Title filled from filename.',false))));
}}return $post;
 }
add_filter(array('attachment_fields_to_save',false),array('image_attachment_fields_to_save',false),array(10,false),array(2,false));
function image_media_send_to_editor ( $html,$attachment_id,$attachment ) {
$post = &get_post($attachment_id);
if ( (deAspis(Aspis_substr($post[0]->post_mime_type,array(0,false),array(5,false))) == ('image')))
 {$url = $attachment[0]['url'];
$align = (!((empty($attachment[0][('align')]) || Aspis_empty( $attachment [0][('align')])))) ? $attachment[0]['align'] : array('none',false);
$size = (!((empty($attachment[0][('image-size')]) || Aspis_empty( $attachment [0][('image-size')])))) ? $attachment[0]['image-size'] : array('medium',false);
$alt = (!((empty($attachment[0][('image_alt')]) || Aspis_empty( $attachment [0][('image_alt')])))) ? $attachment[0]['image_alt'] : array('',false);
$rel = (array($url[0] == deAspis(get_attachment_link($attachment_id)),false));
return get_image_send_to_editor($attachment_id,$attachment[0]['post_excerpt'],$attachment[0]['post_title'],$align,$url,$rel,$size,$alt);
}return $html;
 }
add_filter(array('media_send_to_editor',false),array('image_media_send_to_editor',false),array(10,false),array(3,false));
function get_attachment_fields_to_edit ( $post,$errors = array(null,false) ) {
if ( is_int(deAspisRC($post)))
 $post = &get_post($post);
if ( is_array($post[0]))
 $post = object_cast($post);
$image_url = wp_get_attachment_url($post[0]->ID);
$edit_post = sanitize_post($post,array('edit',false));
$form_fields = array(array('post_title' => array(array(deregisterTaint(array('label',false)) => addTaint(__(array('Title',false))),deregisterTaint(array('value',false)) => addTaint($edit_post[0]->post_title)),false,false),'image_alt' => array(array(),false,false),'post_excerpt' => array(array(deregisterTaint(array('label',false)) => addTaint(__(array('Caption',false))),deregisterTaint(array('value',false)) => addTaint($edit_post[0]->post_excerpt)),false,false),'post_content' => array(array(deregisterTaint(array('label',false)) => addTaint(__(array('Description',false))),deregisterTaint(array('value',false)) => addTaint($edit_post[0]->post_content),'input' => array('textarea',false,false)),false,false),'url' => array(array(deregisterTaint(array('label',false)) => addTaint(__(array('Link URL',false))),'input' => array('html',false,false),deregisterTaint(array('html',false)) => addTaint(image_link_input_fields($post,get_option(array('image_default_link_type',false)))),deregisterTaint(array('helps',false)) => addTaint(__(array('Enter a link URL or click above for presets.',false)))),false,false),'menu_order' => array(array(deregisterTaint(array('label',false)) => addTaint(__(array('Order',false))),deregisterTaint(array('value',false)) => addTaint($edit_post[0]->menu_order)),false,false),'image_url' => array(array(deregisterTaint(array('label',false)) => addTaint(__(array('File URL',false))),'input' => array('html',false,false),deregisterTaint(array('html',false)) => addTaint(concat2(concat(concat2(concat1("<input type='text' class='text urlfield' readonly='readonly' name='attachments[",$post[0]->ID),"][url]' value='"),esc_attr($image_url)),"' /><br />")),deregisterTaint(array('value',false)) => addTaint(wp_get_attachment_url($post[0]->ID)),deregisterTaint(array('helps',false)) => addTaint(__(array('Location of the uploaded file.',false)))),false,false)),false);
foreach ( deAspis(get_attachment_taxonomies($post)) as $taxonomy  )
{$t = array_cast(get_taxonomy($taxonomy));
if ( ((empty($t[0][('label')]) || Aspis_empty( $t [0][('label')]))))
 arrayAssign($t[0],deAspis(registerTaint(array('label',false))),addTaint($taxonomy));
if ( ((empty($t[0][('args')]) || Aspis_empty( $t [0][('args')]))))
 arrayAssign($t[0],deAspis(registerTaint(array('args',false))),addTaint(array(array(),false)));
$terms = get_object_term_cache($post[0]->ID,$taxonomy);
if ( ((empty($terms) || Aspis_empty( $terms))))
 $terms = wp_get_object_terms($post[0]->ID,$taxonomy,$t[0]['args']);
$values = array(array(),false);
foreach ( $terms[0] as $term  )
arrayAssignAdd($values[0][],addTaint($term[0]->name));
arrayAssign($t[0],deAspis(registerTaint(array('value',false))),addTaint(Aspis_join(array(', ',false),$values)));
arrayAssign($form_fields[0],deAspis(registerTaint($taxonomy)),addTaint($t));
}$form_fields = attAspisRC(array_merge_recursive(deAspisRC($form_fields),deAspisRC(array_cast($errors))));
$form_fields = apply_filters(array('attachment_fields_to_edit',false),$form_fields,$post);
return $form_fields;
 }
function get_media_items ( $post_id,$errors ) {
if ( $post_id[0])
 {$post = get_post($post_id);
if ( ($post[0] && ($post[0]->post_type[0] == ('attachment'))))
 $attachments = array(array(deregisterTaint($post[0]->ID) => addTaint($post)),false);
else 
{$attachments = get_children(array(array(deregisterTaint(array('post_parent',false)) => addTaint($post_id),'post_type' => array('attachment',false,false),'orderby' => array('menu_order ASC, ID',false,false),'order' => array('DESC',false,false)),false));
}}else 
{{if ( is_array($GLOBALS[0][('wp_the_query')][0]->posts[0]))
 foreach ( $GLOBALS[0][('wp_the_query')][0]->posts[0] as $attachment  )
arrayAssign($attachments[0],deAspis(registerTaint($attachment[0]->ID)),addTaint($attachment));
}}$output = array('',false);
foreach ( deAspis(array_cast($attachments)) as $id =>$attachment )
{restoreTaint($id,$attachment);
{if ( ($attachment[0]->post_status[0] == ('trash')))
 continue ;
if ( deAspis($item = get_media_item($id,array(array(deregisterTaint(array('errors',false)) => addTaint(((isset($errors[0][$id[0]]) && Aspis_isset( $errors [0][$id[0]]))) ? attachAspis($errors,$id[0]) : array(null,false))),false))))
 $output = concat($output,concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\n<div id='media-item-",$id),"' class='media-item child-of-"),$attachment[0]->post_parent)," preloaded'><div class='progress'><div class='bar'></div></div><div id='media-upload-error-"),$id),"'></div><div class='filename'></div>"),$item),"\n</div>"));
}}return $output;
 }
function get_media_item ( $attachment_id,$args = array(null,false) ) {
global $redir_tab;
if ( (deAspis(($attachment_id = Aspis_intval($attachment_id))) && deAspis($thumb_url = get_attachment_icon_src($attachment_id))))
 $thumb_url = attachAspis($thumb_url,(0));
else 
{return array(false,false);
}$default_args = array(array('errors' => array(null,false,false),'send' => array(true,false,false),'delete' => array(true,false,false),'toggle' => array(true,false,false),'show_title' => array(true,false,false)),false);
$args = wp_parse_args($args,$default_args);
extract(($args[0]),EXTR_SKIP);
$toggle_on = __(array('Show',false));
$toggle_off = __(array('Hide',false));
$post = get_post($attachment_id);
$filename = Aspis_basename($post[0]->guid);
$title = esc_attr($post[0]->post_title);
if ( deAspis($_tags = get_the_tags($attachment_id)))
 {foreach ( $_tags[0] as $tag  )
arrayAssignAdd($tags[0][],addTaint($tag[0]->name));
$tags = esc_attr(Aspis_join(array(', ',false),$tags));
}$post_mime_types = get_post_mime_types();
$keys = attAspisRC(array_keys(deAspisRC(wp_match_mime_types(attAspisRC(array_keys(deAspisRC($post_mime_types))),$post[0]->post_mime_type))));
$type = Aspis_array_shift($keys);
$type_html = concat2(concat(concat2(concat1("<input type='hidden' id='type-of-",$attachment_id),"' value='"),esc_attr($type)),"' />");
$form_fields = get_attachment_fields_to_edit($post,$errors);
if ( $toggle[0])
 {$class = ((empty($errors) || Aspis_empty( $errors))) ? array('startclosed',false) : array('startopen',false);
$toggle_links = concat2(concat(concat2(concat1("
	<a class='toggle describe-toggle-on' href='#'>",$toggle_on),"</a>
	<a class='toggle describe-toggle-off' href='#'>"),$toggle_off),"</a>");
}else 
{{$class = array('form-table',false);
$toggle_links = array('',false);
}}$display_title = (!((empty($title) || Aspis_empty( $title)))) ? $title : $filename;
$display_title = $show_title[0] ? concat2(concat1("<div class='filename new'><span class='title'>",wp_html_excerpt($display_title,array(60,false))),"</span></div>") : array('',false);
$gallery = ((((isset($_REQUEST[0][('tab')]) && Aspis_isset( $_REQUEST [0][('tab')]))) && (('gallery') == deAspis($_REQUEST[0]['tab']))) || (((isset($redir_tab) && Aspis_isset( $redir_tab))) && (('gallery') == $redir_tab[0]))) ? array(true,false) : array(false,false);
$order = array('',false);
foreach ( $form_fields[0] as $key =>$val )
{restoreTaint($key,$val);
{if ( (('menu_order') == $key[0]))
 {if ( $gallery[0])
 $order = concat2(concat(concat2(concat(concat2(concat1('<div class="menu_order"> <input class="menu_order_input" type="text" id="attachments[',$attachment_id),'][menu_order]" name="attachments['),$attachment_id),'][menu_order]" value="'),$val[0]['value']),'" /></div>');
else 
{$order = concat2(concat(concat2(concat1('<input type="hidden" name="attachments[',$attachment_id),'][menu_order]" value="'),$val[0]['value']),'" />');
}unset($form_fields[0][('menu_order')]);
break ;
}}}$media_dims = array('',false);
$meta = wp_get_attachment_metadata($post[0]->ID);
if ( ((is_array($meta[0]) && array_key_exists('width',deAspisRC($meta))) && array_key_exists('height',deAspisRC($meta))))
 $media_dims = concat($media_dims,concat2(concat(concat2(concat(concat2(concat1("<span id='media-dims-",$post[0]->ID),"'>"),$meta[0]['width']),"&nbsp;&times;&nbsp;"),$meta[0]['height']),"</span> "));
$media_dims = apply_filters(array('media_meta',false),$media_dims,$post);
$image_edit_button = array('',false);
if ( deAspis(gd_edit_image_support($post[0]->post_mime_type)))
 {$nonce = wp_create_nonce(concat1("image_editor-",$post[0]->ID));
$image_edit_button = concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<input type='button' id='imgedit-open-btn-",$post[0]->ID),"' onclick='imageEdit.open("),$post[0]->ID),", \""),$nonce),"\")' class='button' value='"),esc_attr__(array('Edit image',false))),"' /> <img src='images/wpspin_light.gif' class='imgedit-wait-spin' alt='' />");
}$item = concat2(concat(concat2(concat(concat(concat(concat(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("
	",$type_html),"
	"),$toggle_links),"
	"),$order),"
	"),$display_title),"
	<table class='slidetoggle describe "),$class),"'>
		<thead class='media-item-info' id='media-head-"),$post[0]->ID),"'>
		<tr>
			<td class='A1B1' id='thumbnail-head-"),$post[0]->ID),"' rowspan='5'><img class='thumbnail' src='"),$thumb_url),"' alt='' /></td>
			<td><strong>"),__(array('File name:',false))),concat2(concat1("</strong> ",$filename),"</td>
		</tr>
		<tr><td><strong>")),__(array('File type:',false))),concat2(concat1("</strong> ",$post[0]->post_mime_type),"</td></tr>
		<tr><td><strong>")),__(array('Upload date:',false))),"</strong> "),mysql2date(get_option(array('date_format',false)),$post[0]->post_date)),"</td></tr>\n");
if ( (!((empty($media_dims) || Aspis_empty( $media_dims)))))
 $item = concat($item,concat(concat1("<tr><td><strong>",__(array('Dimensions:',false))),concat2(concat1("</strong> ",$media_dims),"</td></tr>\n")));
$item = concat($item,concat2(concat(concat2(concat(concat2(concat1("
		<tr><td class='A1B1'>",$image_edit_button),"</td></tr>
		</thead>
		<tbody>
		<tr><td colspan='2' class='imgedit-response' id='imgedit-response-"),$post[0]->ID),"'></td></tr>
		<tr><td style='display:none' colspan='2' class='image-editor' id='image-editor-"),$post[0]->ID),"'></td></tr>\n"));
$defaults = array(array('input' => array('text',false,false),'required' => array(false,false,false),'value' => array('',false,false),'extra_rows' => array(array(),false,false),),false);
if ( $send[0])
 $send = concat2(concat(concat2(concat1("<input type='submit' class='button' name='send[",$attachment_id),"]' value='"),esc_attr__(array('Insert into Post',false))),"' />");
if ( ($delete[0] && deAspis(current_user_can(array('delete_post',false),$attachment_id))))
 {if ( (!(EMPTY_TRASH_DAYS)))
 {$delete = concat2(concat(concat(concat1("<a href=\"",wp_nonce_url(concat1("post.php?action=delete&amp;post=",$attachment_id),concat1('delete-post_',$attachment_id))),concat2(concat1("\" id=\"del[",$attachment_id),"]\" class=\"delete\">")),__(array('Delete Permanently',false))),"</a>");
}elseif ( (!(MEDIA_TRASH)))
 {$delete = concat2(concat(concat2(concat(concat(concat(concat2(concat(concat(concat(concat2(concat1("<a href=\"#\" class=\"del-link\" onclick=\"document.getElementById('del_attachment_",$attachment_id),"').style.display='block';return false;\">"),__(array('Delete',false))),concat2(concat1("</a> <div id=\"del_attachment_",$attachment_id),"\" class=\"del-attachment\" style=\"display:none;\">")),Aspis_sprintf(__(array("You are about to delete <strong>%s</strong>.",false)),$filename))," <a href=\""),wp_nonce_url(concat1("post.php?action=delete&amp;post=",$attachment_id),concat1('delete-post_',$attachment_id))),concat2(concat1("\" id=\"del[",$attachment_id),"]\" class=\"button\">")),__(array('Continue',false))),"</a> <a href=\"#\" class=\"button\" onclick=\"this.parentNode.style.display='none';return false;\">"),__(array('Cancel',false))),"</a></div>");
}else 
{{$delete = concat2(concat(concat(concat(concat2(concat(concat(concat1("<a href=\"",wp_nonce_url(concat1("post.php?action=trash&amp;post=",$attachment_id),concat1('trash-post_',$attachment_id))),concat2(concat1("\" id=\"del[",$attachment_id),"]\" class=\"delete\">")),__(array('Move to Trash',false))),"</a> <a href=\""),wp_nonce_url(concat1("post.php?action=untrash&amp;post=",$attachment_id),concat1('untrash-post_',$attachment_id))),concat2(concat1("\" id=\"undo[",$attachment_id),"]\" class=\"undo hidden\">")),__(array('Undo',false))),"</a>");
}}}else 
{{$delete = array('',false);
}}$thumbnail = array('',false);
$calling_post_id = array(0,false);
if ( ((isset($_GET[0][('post_id')]) && Aspis_isset( $_GET [0][('post_id')]))))
 $calling_post_id = $_GET[0]['post_id'];
elseif ( (((isset($_POST) && Aspis_isset( $_POST))) && count($_POST[0])))
 $calling_post_id = $post[0]->post_parent;
if ( ((((('image') == $type[0]) && $calling_post_id[0]) && deAspis(current_theme_supports(array('post-thumbnails',false),get_post_type($calling_post_id)))) && (deAspis(get_post_thumbnail_id($calling_post_id)) != $attachment_id[0])))
 $thumbnail = concat2(concat(concat(concat1("<a class='wp-post-thumbnail' id='wp-post-thumbnail-",$attachment_id),concat2(concat1("' href='#' onclick='WPSetAsThumbnail(\"",$attachment_id),"\");return false;'>")),esc_html__(array("Use as thumbnail",false))),"</a>");
if ( ((($send[0] || $thumbnail[0]) || $delete[0]) && (!((isset($form_fields[0][('buttons')]) && Aspis_isset( $form_fields [0][('buttons')]))))))
 arrayAssign($form_fields[0],deAspis(registerTaint(array('buttons',false))),addTaint(array(array(deregisterTaint(array('tr',false)) => addTaint(concat2(concat(concat2(concat(concat2(concat1("\t\t<tr class='submit'><td></td><td class='savesend'>",$send)," "),$thumbnail)," "),$delete),"</td></tr>\n"))),false)));
$hidden_fields = array(array(),false);
foreach ( $form_fields[0] as $id =>$field )
{restoreTaint($id,$field);
{if ( (deAspis(attachAspis($id,(0))) == ('_')))
 continue ;
if ( (!((empty($field[0][('tr')]) || Aspis_empty( $field [0][('tr')])))))
 {$item = concat($item,$field[0]['tr']);
continue ;
}$field = Aspis_array_merge($defaults,$field);
$name = concat2(concat(concat2(concat1("attachments[",$attachment_id),"]["),$id),"]");
if ( (deAspis($field[0]['input']) == ('hidden')))
 {arrayAssign($hidden_fields[0],deAspis(registerTaint($name)),addTaint($field[0]['value']));
continue ;
}$required = deAspis($field[0]['required']) ? array('<abbr title="required" class="required">*</abbr>',false) : array('',false);
$aria_required = deAspis($field[0]['required']) ? array(" aria-required='true' ",false) : array('',false);
$class = $id;
$class = concat($class,deAspis($field[0]['required']) ? array(' form-required',false) : array('',false));
$item = concat($item,concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\t\t<tr class='",$class),"'>\n\t\t\t<th valign='top' scope='row' class='label'><label for='"),$name),"'><span class='alignleft'>"),$field[0]['label']),"</span><span class='alignright'>"),$required),"</span><br class='clear' /></label></th>\n\t\t\t<td class='field'>"));
if ( (!((empty($field[0][deAspis($field[0]['input'])]) || Aspis_empty( $field [0][deAspis($field [0]['input'])])))))
 $item = concat($item,attachAspis($field,deAspis($field[0]['input'])));
elseif ( (deAspis($field[0]['input']) == ('textarea')))
 {$item = concat($item,concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<textarea type='text' id='",$name),"' name='"),$name),"'"),$aria_required),">"),esc_html($field[0]['value'])),"</textarea>"));
}else 
{{$item = concat($item,concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<input type='text' class='text' id='",$name),"' name='"),$name),"' value='"),esc_attr($field[0]['value'])),"'"),$aria_required),"/>"));
}}if ( (!((empty($field[0][('helps')]) || Aspis_empty( $field [0][('helps')])))))
 $item = concat($item,concat2(concat1("<p class='help'>",Aspis_join(array("</p>\n<p class='help'>",false),attAspisRC(array_unique(deAspisRC(array_cast($field[0]['helps'])))))),'</p>'));
$item = concat2($item,"</td>\n\t\t</tr>\n");
$extra_rows = array(array(),false);
if ( (!((empty($field[0][('errors')]) || Aspis_empty( $field [0][('errors')])))))
 foreach ( deAspis(attAspisRC(array_unique(deAspisRC(array_cast($field[0]['errors']))))) as $error  )
arrayAssignAdd($extra_rows[0][('error')][0][],addTaint($error));
if ( (!((empty($field[0][('extra_rows')]) || Aspis_empty( $field [0][('extra_rows')])))))
 foreach ( deAspis($field[0]['extra_rows']) as $class =>$rows )
{restoreTaint($class,$rows);
foreach ( deAspis(array_cast($rows)) as $html  )
arrayAssignAdd($extra_rows[0][$class[0]][0][],addTaint($html));
}foreach ( $extra_rows[0] as $class =>$rows )
{restoreTaint($class,$rows);
foreach ( $rows[0] as $html  )
$item = concat($item,concat2(concat(concat2(concat1("\t\t<tr><td></td><td class='",$class),"'>"),$html),"</td></tr>\n"));
}}}if ( (!((empty($form_fields[0][('_final')]) || Aspis_empty( $form_fields [0][('_final')])))))
 $item = concat($item,concat2(concat1("\t\t<tr class='final'><td colspan='2'>",$form_fields[0]['_final']),"</td></tr>\n"));
$item = concat2($item,"\t</tbody>\n");
$item = concat2($item,"\t</table>\n");
foreach ( $hidden_fields[0] as $name =>$value )
{restoreTaint($name,$value);
$item = concat($item,concat2(concat(concat2(concat(concat2(concat1("\t<input type='hidden' name='",$name),"' id='"),$name),"' value='"),esc_attr($value)),"' />\n"));
}if ( (($post[0]->post_parent[0] < (1)) && ((isset($_REQUEST[0][('post_id')]) && Aspis_isset( $_REQUEST [0][('post_id')])))))
 {$parent = int_cast($_REQUEST[0]['post_id']);
$parent_name = concat2(concat1("attachments[",$attachment_id),"][post_parent]");
$item = concat($item,concat2(concat(concat2(concat(concat2(concat1("\t<input type='hidden' name='",$parent_name),"' id='"),$parent_name),"' value='"),$parent),"' />\n"));
}return $item;
 }
function media_upload_header (  ) {
;
?>
	<script type="text/javascript">post_id = <?php echo AspisCheckPrint(Aspis_intval($_REQUEST[0]['post_id']));
;
?>;</script>
	<div id="media-upload-header">
	<?php the_media_upload_tabs();
;
?>
	</div>
	<?php  }
function media_upload_form ( $errors = array(null,false) ) {
global $type,$tab;
$flash_action_url = admin_url(array('async-upload.php',false));
$flash = array(true,false);
if ( ((false !== strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_USER_AGENT'])),'mac')) && deAspis(apache_mod_loaded(array('mod_security',false)))))
 $flash = array(false,false);
$flash = apply_filters(array('flash_uploader',false),$flash);
$post_id = ((isset($_REQUEST[0][('post_id')]) && Aspis_isset( $_REQUEST [0][('post_id')]))) ? Aspis_intval($_REQUEST[0]['post_id']) : array(0,false);
;
?>
<script type="text/javascript">
//<![CDATA[
var uploaderMode = 0;
jQuery(document).ready(function($){
	uploaderMode = getUserSetting('uploader');
	$('.upload-html-bypass a').click(function(){deleteUserSetting('uploader');uploaderMode=0;swfuploadPreLoad();return false;});
	$('.upload-flash-bypass a').click(function(){setUserSetting('uploader', '1');uploaderMode=1;swfuploadPreLoad();return false;});
});
//]]>
</script>
<div id="media-upload-notice">
<?php if ( ((isset($errors[0][('upload_notice')]) && Aspis_isset( $errors [0][('upload_notice')]))))
 {;
?>
	<?php echo AspisCheckPrint($errors[0]['upload_notice']);
;
?>
<?php };
?>
</div>
<div id="media-upload-error">
<?php if ( (((isset($errors[0][('upload_error')]) && Aspis_isset( $errors [0][('upload_error')]))) && deAspis(is_wp_error($errors[0]['upload_error']))))
 {;
?>
	<?php echo AspisCheckPrint($errors[0][('upload_error')][0]->get_error_message());
;
?>
<?php };
?>
</div>

<?php do_action(array('pre-upload-ui',false));
;
?>

<?php if ( $flash[0])
 {;
?>
<script type="text/javascript">
//<![CDATA[
var swfu;
SWFUpload.onload = function() {
	var settings = {
			button_text: '<span class="button"><?php _e(array('Select Files',false));
;
?></span>',
			button_text_style: '.button { text-align: center; font-weight: bold; font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif; }',
			button_height: "24",
			button_width: "132",
			button_text_top_padding: 2,
			button_image_url: '<?php echo AspisCheckPrint(includes_url(array('images/upload.png',false)));
;
?>',
			button_placeholder_id: "flash-browse-button",
			upload_url : "<?php echo AspisCheckPrint(esc_attr($flash_action_url));
;
?>",
			flash_url : "<?php echo AspisCheckPrint(includes_url(array('js/swfupload/swfupload.swf',false)));
;
?>",
			file_post_name: "async-upload",
			file_types: "<?php echo AspisCheckPrint(apply_filters(array('upload_file_glob',false),array('*.*',false)));
;
?>",
			post_params : {
				"post_id" : "<?php echo AspisCheckPrint($post_id);
;
?>",
				"auth_cookie" : "<?php if ( deAspis(is_ssl()))
 echo AspisCheckPrint(attachAspis($_COOKIE,SECURE_AUTH_COOKIE));
else 
{echo AspisCheckPrint(attachAspis($_COOKIE,AUTH_COOKIE));
};
?>",
				"logged_in_cookie": "<?php echo AspisCheckPrint(attachAspis($_COOKIE,LOGGED_IN_COOKIE));
;
?>",
				"_wpnonce" : "<?php echo AspisCheckPrint(wp_create_nonce(array('media-form',false)));
;
?>",
				"type" : "<?php echo AspisCheckPrint($type);
;
?>",
				"tab" : "<?php echo AspisCheckPrint($tab);
;
?>",
				"short" : "1"
			},
			file_size_limit : "<?php echo AspisCheckPrint(wp_max_upload_size());
;
?>b",
			file_dialog_start_handler : fileDialogStart,
			file_queued_handler : fileQueued,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			swfupload_pre_load_handler: swfuploadPreLoad,
			swfupload_load_failed_handler: swfuploadLoadFailed,
			custom_settings : {
				degraded_element_id : "html-upload-ui", // id of the element displayed when swfupload is unavailable
				swfupload_element_id : "flash-upload-ui" // id of the element displayed when swfupload is available
			},
			debug: false
		};
		swfu = new SWFUpload(settings);
};
//]]>
</script>

<div id="flash-upload-ui">
<?php do_action(array('pre-flash-upload-ui',false));
;
?>

	<div>
	<?php _e(array('Choose files to upload',false));
;
?>
	<div id="flash-browse-button"></div>
	<span><input id="cancel-upload" disabled="disabled" onclick="cancelUpload()" type="button" value="<?php esc_attr_e(array('Cancel Upload',false));
;
?>" class="button" /></span>
	</div>
<?php do_action(array('post-flash-upload-ui',false));
;
?>
	<p class="howto"><?php _e(array('After a file has been uploaded, you can add titles and descriptions.',false));
;
?></p>
</div>
<?php };
?>

<div id="html-upload-ui">
<?php do_action(array('pre-html-upload-ui',false));
;
?>
	<p id="async-upload-wrap">
	<label class="screen-reader-text" for="async-upload"><?php _e(array('Upload',false));
;
?></label>
	<input type="file" name="async-upload" id="async-upload" /> <input type="submit" class="button" name="html-upload" value="<?php esc_attr_e(array('Upload',false));
;
?>" /> <a href="#" onclick="try{top.tb_remove();}catch(e){}; return false;"><?php _e(array('Cancel',false));
;
?></a>
	</p>
	<div class="clear"></div>
	<?php if ( deAspis(is_lighttpd_before_150()))
 {;
?>
	<p><?php _e(array('If you want to use all capabilities of the uploader, like uploading multiple files at once, please upgrade to lighttpd 1.5.',false));
;
?></p>
	<?php };
?>
<?php do_action(array('post-html-upload-ui',false),$flash);
;
?>
</div>
<?php do_action(array('post-upload-ui',false));
;
?>
<?php  }
function media_upload_type_form ( $type = array('file',false),$errors = array(null,false),$id = array(null,false) ) {
media_upload_header();
$post_id = Aspis_intval($_REQUEST[0]['post_id']);
$form_action_url = admin_url(concat(concat2(concat1("media-upload.php?type=",$type),"&tab=type&post_id="),$post_id));
$form_action_url = apply_filters(array('media_upload_form_url',false),$form_action_url,$type);
;
?>

<form enctype="multipart/form-data" method="post" action="<?php echo AspisCheckPrint(esc_attr($form_action_url));
;
?>" class="media-upload-form type-form validate" id="<?php echo AspisCheckPrint($type);
;
?>-form">
<input type="submit" class="hidden" name="save" value="" />
<input type="hidden" name="post_id" id="post_id" value="<?php echo AspisCheckPrint(int_cast($post_id));
;
?>" />
<?php wp_nonce_field(array('media-form',false));
;
?>

<h3 class="media-title"><?php _e(array('Add media files from your computer',false));
;
?></h3>

<?php media_upload_form($errors);
;
?>

<script type="text/javascript">
//<![CDATA[
jQuery(function($){
	var preloaded = $(".media-item.preloaded");
	if ( preloaded.length > 0 ) {
		preloaded.each(function(){prepareMediaItem({id:this.id.replace(/[^0-9]/g, '')},'');});
	}
	updateMediaForm();
});
//]]>
</script>
<div id="media-items">
<?php if ( $id[0])
 {if ( (denot_boolean(is_wp_error($id))))
 {add_filter(array('attachment_fields_to_edit',false),array('media_post_single_attachment_fields_to_edit',false),array(10,false),array(2,false));
echo AspisCheckPrint(get_media_items($id,$errors));
}else 
{{echo AspisCheckPrint(concat2(concat1('<div id="media-upload-error">',esc_html($id[0]->get_error_message())),'</div>'));
Aspis_exit();
}}};
?>
</div>
<p class="savebutton ml-submit">
<input type="submit" class="button" name="save" value="<?php esc_attr_e(array('Save all changes',false));
;
?>" />
</p>
<?php  }
function media_upload_type_url_form ( $type = array('file',false),$errors = array(null,false),$id = array(null,false) ) {
media_upload_header();
$post_id = Aspis_intval($_REQUEST[0]['post_id']);
$form_action_url = admin_url(concat(concat2(concat1("media-upload.php?type=",$type),"&tab=type&post_id="),$post_id));
$form_action_url = apply_filters(array('media_upload_form_url',false),$form_action_url,$type);
$callback = concat1("type_url_form_",$type);
;
?>

<form enctype="multipart/form-data" method="post" action="<?php echo AspisCheckPrint(esc_attr($form_action_url));
;
?>" class="media-upload-form type-form validate" id="<?php echo AspisCheckPrint($type);
;
?>-form">
<input type="hidden" name="post_id" id="post_id" value="<?php echo AspisCheckPrint(int_cast($post_id));
;
?>" />
<?php wp_nonce_field(array('media-form',false));
;
?>

<?php if ( is_callable(deAspisRC($callback)))
 {;
?>

<h3 class="media-title"><?php _e(array('Add media file from URL',false));
;
?></h3>

<script type="text/javascript">
//<![CDATA[
var addExtImage = {

	width : '',
	height : '',
	align : 'alignnone',

	insert : function() {
		var t = this, html, f = document.forms[0], cls, title = '', alt = '', caption = '';

		if ( '' == f.src.value || '' == t.width )
			return false;

		if ( f.title.value ) {
			title = f.title.value.replace(/'/g, '&#039;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
			title = ' title="'+title+'"';
		}

		if ( f.alt.value )
			alt = f.alt.value.replace(/'/g, '&#039;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

<?php if ( (denot_boolean(apply_filters(array('disable_captions',false),array('',false)))))
 {;
?>
		if ( f.caption.value )
			caption = f.caption.value.replace(/'/g, '&#039;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
<?php };
?>

		cls = caption ? '' : ' class="'+t.align+'"';

		html = '<img alt="'+alt+'" src="'+f.src.value+'"'+title+cls+' width="'+t.width+'" height="'+t.height+'" />';

		if ( f.url.value )
			html = '<a href="'+f.url.value+'">'+html+'</a>';

		if ( caption )
			html = '[caption id="" align="'+t.align+'" width="'+t.width+'" caption="'+caption+'"]'+html+'[/caption]';

		var win = window.dialogArguments || opener || parent || top;
		win.send_to_editor(html);
		return false;
	},

	resetImageData : function() {
		var t = addExtImage;

		t.width = t.height = '';
		document.getElementById('go_button').style.color = '#bbb';
		if ( ! document.forms[0].src.value )
			document.getElementById('status_img').innerHTML = '*';
		else document.getElementById('status_img').innerHTML = '<img src="images/no.png" alt="" />';
	},

	updateImageData : function() {
		var t = addExtImage;

		t.width = t.preloadImg.width;
		t.height = t.preloadImg.height;
		document.getElementById('go_button').style.color = '#333';
		document.getElementById('status_img').innerHTML = '<img src="images/yes.png" alt="" />';
	},

	getImageData : function() {
		var t = addExtImage, src = document.forms[0].src.value;

		if ( ! src ) {
			t.resetImageData();
			return false;
		}
		document.getElementById('status_img').innerHTML = '<img src="images/wpspin_light.gif" alt="" />';
		t.preloadImg = new Image();
		t.preloadImg.onload = t.updateImageData;
		t.preloadImg.onerror = t.resetImageData;
		t.preloadImg.src = src;
	}
}
//]]>
</script>

<div id="media-items">
<div class="media-item media-blank">
<?php echo AspisCheckPrint(apply_filters($callback,Aspis_call_user_func($callback)));
;
?>
</div>
</div>
</form>
<?php }else 
{{wp_die(__(array('Unknown action.',false)));
}} }
function media_upload_gallery_form ( $errors ) {
global $redir_tab,$type;
$redir_tab = array('gallery',false);
media_upload_header();
$post_id = Aspis_intval($_REQUEST[0]['post_id']);
$form_action_url = admin_url(concat(concat2(concat1("media-upload.php?type=",$type),"&tab=gallery&post_id="),$post_id));
$form_action_url = apply_filters(array('media_upload_form_url',false),$form_action_url,$type);
;
?>

<script type="text/javascript">
<!--
jQuery(function($){
	var preloaded = $(".media-item.preloaded");
	if ( preloaded.length > 0 ) {
		preloaded.each(function(){prepareMediaItem({id:this.id.replace(/[^0-9]/g, '')},'');});
		updateMediaForm();
	}
});
-->
</script>
<div id="sort-buttons" class="hide-if-no-js">
<span>
<?php _e(array('All Tabs:',false));
;
?>
<a href="#" id="showall"><?php _e(array('Show',false));
;
?></a>
<a href="#" id="hideall" style="display:none;"><?php _e(array('Hide',false));
;
?></a>
</span>
<?php _e(array('Sort Order:',false));
;
?>
<a href="#" id="asc"><?php _e(array('Ascending',false));
;
?></a> |
<a href="#" id="desc"><?php _e(array('Descending',false));
;
?></a> |
<a href="#" id="clear"><?php echo AspisCheckPrint(_x(array('Clear',false),array('verb',false)));
;
?></a>
</div>
<form enctype="multipart/form-data" method="post" action="<?php echo AspisCheckPrint(esc_attr($form_action_url));
;
?>" class="media-upload-form validate" id="gallery-form">
<?php wp_nonce_field(array('media-form',false));
;
?>
<?php ;
?>
<table class="widefat" cellspacing="0">
<thead><tr>
<th><?php _e(array('Media',false));
;
?></th>
<th class="order-head"><?php _e(array('Order',false));
;
?></th>
<th class="actions-head"><?php _e(array('Actions',false));
;
?></th>
</tr></thead>
</table>
<div id="media-items">
<?php add_filter(array('attachment_fields_to_edit',false),array('media_post_single_attachment_fields_to_edit',false),array(10,false),array(2,false));
;
?>
<?php echo AspisCheckPrint(get_media_items($post_id,$errors));
;
?>
</div>

<p class="ml-submit">
<input type="submit" class="button savebutton" style="display:none;" name="save" id="save-all" value="<?php esc_attr_e(array('Save all changes',false));
;
?>" />
<input type="hidden" name="post_id" id="post_id" value="<?php echo AspisCheckPrint(int_cast($post_id));
;
?>" />
<input type="hidden" name="type" value="<?php echo AspisCheckPrint(esc_attr($GLOBALS[0]['type']));
;
?>" />
<input type="hidden" name="tab" value="<?php echo AspisCheckPrint(esc_attr($GLOBALS[0]['tab']));
;
?>" />
</p>

<div id="gallery-settings" style="display:none;">
<div class="title"><?php _e(array('Gallery Settings',false));
;
?></div>
<table id="basic" class="describe"><tbody>
	<tr>
	<th scope="row" class="label">
		<label>
		<span class="alignleft"><?php _e(array('Link thumbnails to:',false));
;
?></span>
		</label>
	</th>
	<td class="field">
		<input type="radio" name="linkto" id="linkto-file" value="file" />
		<label for="linkto-file" class="radio"><?php _e(array('Image File',false));
;
?></label>

		<input type="radio" checked="checked" name="linkto" id="linkto-post" value="post" />
		<label for="linkto-post" class="radio"><?php _e(array('Attachment Page',false));
;
?></label>
	</td>
	</tr>

	<tr>
	<th scope="row" class="label">
		<label>
		<span class="alignleft"><?php _e(array('Order images by:',false));
;
?></span>
		</label>
	</th>
	<td class="field">
		<select id="orderby" name="orderby">
			<option value="menu_order" selected="selected"><?php _e(array('Menu order',false));
;
?></option>
			<option value="title"><?php _e(array('Title',false));
;
?></option>
			<option value="ID"><?php _e(array('Date/Time',false));
;
?></option>
			<option value="rand"><?php _e(array('Random',false));
;
?></option>
		</select>
	</td>
	</tr>

	<tr>
	<th scope="row" class="label">
		<label>
		<span class="alignleft"><?php _e(array('Order:',false));
;
?></span>
		</label>
	</th>
	<td class="field">
		<input type="radio" checked="checked" name="order" id="order-asc" value="asc" />
		<label for="order-asc" class="radio"><?php _e(array('Ascending',false));
;
?></label>

		<input type="radio" name="order" id="order-desc" value="desc" />
		<label for="order-desc" class="radio"><?php _e(array('Descending',false));
;
?></label>
	</td>
	</tr>

	<tr>
	<th scope="row" class="label">
		<label>
		<span class="alignleft"><?php _e(array('Gallery columns:',false));
;
?></span>
		</label>
	</th>
	<td class="field">
		<select id="columns" name="columns">
			<option value="2"><?php _e(array('2',false));
;
?></option>
			<option value="3" selected="selected"><?php _e(array('3',false));
;
?></option>
			<option value="4"><?php _e(array('4',false));
;
?></option>
			<option value="5"><?php _e(array('5',false));
;
?></option>
			<option value="6"><?php _e(array('6',false));
;
?></option>
			<option value="7"><?php _e(array('7',false));
;
?></option>
			<option value="8"><?php _e(array('8',false));
;
?></option>
			<option value="9"><?php _e(array('9',false));
;
?></option>
		</select>
	</td>
	</tr>
</tbody></table>

<p class="ml-submit">
<input type="button" class="button" style="display:none;" onmousedown="wpgallery.update();" name="insert-gallery" id="insert-gallery" value="<?php esc_attr_e(array('Insert gallery',false));
;
?>" />
<input type="button" class="button" style="display:none;" onmousedown="wpgallery.update();" name="update-gallery" id="update-gallery" value="<?php esc_attr_e(array('Update gallery settings',false));
;
?>" />
</p>
</div>
</form>
<?php  }
function media_upload_library_form ( $errors ) {
global $wpdb,$wp_query,$wp_locale,$type,$tab,$post_mime_types;
media_upload_header();
$post_id = Aspis_intval($_REQUEST[0]['post_id']);
$form_action_url = admin_url(concat(concat2(concat1("media-upload.php?type=",$type),"&tab=library&post_id="),$post_id));
$form_action_url = apply_filters(array('media_upload_form_url',false),$form_action_url,$type);
arrayAssign($_GET[0],deAspis(registerTaint(array('paged',false))),addTaint(((isset($_GET[0][('paged')]) && Aspis_isset( $_GET [0][('paged')]))) ? Aspis_intval($_GET[0]['paged']) : array(0,false)));
if ( (deAspis($_GET[0]['paged']) < (1)))
 arrayAssign($_GET[0],deAspis(registerTaint(array('paged',false))),addTaint(array(1,false)));
$start = array((deAspis($_GET[0]['paged']) - (1)) * (10),false);
if ( ($start[0] < (1)))
 $start = array(0,false);
add_filter(array('post_limits',false),$limit_filter = Aspis_create_function(array('$a',false),concat2(concat1("return 'LIMIT ",$start),", 10';")));
list($post_mime_types,$avail_post_mime_types) = deAspisList(wp_edit_attachments_query(),array());
;
?>

<form id="filter" action="" method="get">
<input type="hidden" name="type" value="<?php echo AspisCheckPrint(esc_attr($type));
;
?>" />
<input type="hidden" name="tab" value="<?php echo AspisCheckPrint(esc_attr($tab));
;
?>" />
<input type="hidden" name="post_id" value="<?php echo AspisCheckPrint(int_cast($post_id));
;
?>" />
<input type="hidden" name="post_mime_type" value="<?php echo AspisCheckPrint(((isset($_GET[0][('post_mime_type')]) && Aspis_isset( $_GET [0][('post_mime_type')]))) ? esc_attr($_GET[0]['post_mime_type']) : array('',false));
;
?>" />

<p id="media-search" class="search-box">
	<label class="screen-reader-text" for="media-search-input"><?php _e(array('Search Media',false));
;
?>:</label>
	<input type="text" id="media-search-input" name="s" value="<?php the_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e(array('Search Media',false));
;
?>" class="button" />
</p>

<ul class="subsubsub">
<?php $type_links = array(array(),false);
$_num_posts = array_cast(wp_count_attachments());
$matches = wp_match_mime_types(attAspisRC(array_keys(deAspisRC($post_mime_types))),attAspisRC(array_keys(deAspisRC($_num_posts))));
foreach ( $matches[0] as $_type =>$reals )
{restoreTaint($_type,$reals);
foreach ( $reals[0] as $real  )
if ( ((isset($num_posts[0][$_type[0]]) && Aspis_isset( $num_posts [0][$_type[0]]))))
 arrayAssign($num_posts[0],deAspis(registerTaint($_type)),addTaint(array(deAspis(attachAspis($_num_posts,$real[0])) + deAspis(attachAspis($num_posts,$_type[0])),false)));
else 
{arrayAssign($num_posts[0],deAspis(registerTaint($_type)),addTaint(attachAspis($_num_posts,$real[0])));
}}if ( (((empty($_GET[0][('post_mime_type')]) || Aspis_empty( $_GET [0][('post_mime_type')]))) && (!((empty($num_posts[0][$type[0]]) || Aspis_empty( $num_posts [0][$type[0]]))))))
 {arrayAssign($_GET[0],deAspis(registerTaint(array('post_mime_type',false))),addTaint($type));
list($post_mime_types,$avail_post_mime_types) = deAspisList(wp_edit_attachments_query(),array());
}if ( (((empty($_GET[0][('post_mime_type')]) || Aspis_empty( $_GET [0][('post_mime_type')]))) || (deAspis($_GET[0]['post_mime_type']) == ('all'))))
 $class = array(' class="current"',false);
else 
{$class = array('',false);
}arrayAssignAdd($type_links[0][],addTaint(concat2(concat(concat(concat1("<li><a href='",esc_url(add_query_arg(array(array('post_mime_type' => array('all',false,false),'paged' => array(false,false,false),'m' => array(false,false,false)),false)))),concat2(concat1("'",$class),">")),__(array('All Types',false))),"</a>")));
foreach ( $post_mime_types[0] as $mime_type =>$label )
{restoreTaint($mime_type,$label);
{$class = array('',false);
if ( (denot_boolean(wp_match_mime_types($mime_type,$avail_post_mime_types))))
 continue ;
if ( (((isset($_GET[0][('post_mime_type')]) && Aspis_isset( $_GET [0][('post_mime_type')]))) && deAspis(wp_match_mime_types($mime_type,$_GET[0]['post_mime_type']))))
 $class = array(' class="current"',false);
arrayAssignAdd($type_links[0][],addTaint(concat2(concat(concat(concat1("<li><a href='",esc_url(add_query_arg(array(array(deregisterTaint(array('post_mime_type',false)) => addTaint($mime_type),'paged' => array(false,false,false)),false)))),concat2(concat1("'",$class),">")),Aspis_sprintf(_n(attachAspis($label[0][(2)],(0)),attachAspis($label[0][(2)],(1)),attachAspis($num_posts,$mime_type[0])),concat2(concat(concat2(concat1("<span id='",$mime_type),"-counter'>"),number_format_i18n(attachAspis($num_posts,$mime_type[0]))),'</span>'))),'</a>')));
}}echo AspisCheckPrint(concat2(Aspis_implode(array(' | </li>',false),$type_links),'</li>'));
unset($type_links);
;
?>
</ul>

<div class="tablenav">

<?php $page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('paged',false),array('%#%',false))),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint(attAspis(ceil(($wp_query[0]->found_posts[0] / (10))))),deregisterTaint(array('current',false)) => addTaint($_GET[0]['paged'])),false));
if ( $page_links[0])
 echo AspisCheckPrint(concat2(concat1("<div class='tablenav-pages'>",$page_links),"</div>"));
;
?>

<div class="alignleft actions">
<?php $arc_query = concat2(concat1("SELECT DISTINCT YEAR(post_date) AS yyear, MONTH(post_date) AS mmonth FROM ",$wpdb[0]->posts)," WHERE post_type = 'attachment' ORDER BY post_date DESC");
$arc_result = $wpdb[0]->get_results($arc_query);
$month_count = attAspis(count($arc_result[0]));
if ( ($month_count[0] && (!(((1) == $month_count[0]) && ((0) == $arc_result[0][(0)][0]->mmonth[0])))))
 {;
?>
<select name='m'>
<option<?php selected(@$_GET[0]['m'],array(0,false));
;
?> value='0'><?php _e(array('Show all dates',false));
;
?></option>
<?php foreach ( $arc_result[0] as $arc_row  )
{if ( ($arc_row[0]->yyear[0] == (0)))
 continue ;
$arc_row[0]->mmonth = zeroise($arc_row[0]->mmonth,array(2,false));
if ( (((isset($_GET[0][('m')]) && Aspis_isset( $_GET [0][('m')]))) && ((deconcat($arc_row[0]->yyear,$arc_row[0]->mmonth)) == deAspis($_GET[0]['m']))))
 $default = array(' selected="selected"',false);
else 
{$default = array('',false);
}echo AspisCheckPrint(concat2(concat(concat2(concat1("<option",$default)," value='"),esc_attr(concat($arc_row[0]->yyear,$arc_row[0]->mmonth))),"'>"));
echo AspisCheckPrint(esc_html(concat($wp_locale[0]->get_month($arc_row[0]->mmonth),concat1(" ",$arc_row[0]->yyear))));
echo AspisCheckPrint(array("</option>\n",false));
};
?>
</select>
<?php };
?>

<input type="submit" id="post-query-submit" value="<?php echo AspisCheckPrint(esc_attr(__(array('Filter &#187;',false))));
;
?>" class="button-secondary" />

</div>

<br class="clear" />
</div>
</form>

<form enctype="multipart/form-data" method="post" action="<?php echo AspisCheckPrint(esc_attr($form_action_url));
;
?>" class="media-upload-form validate" id="library-form">

<?php wp_nonce_field(array('media-form',false));
;
?>
<?php ;
?>

<script type="text/javascript">
<!--
jQuery(function($){
	var preloaded = $(".media-item.preloaded");
	if ( preloaded.length > 0 ) {
		preloaded.each(function(){prepareMediaItem({id:this.id.replace(/[^0-9]/g, '')},'');});
		updateMediaForm();
	}
});
-->
</script>

<div id="media-items">
<?php add_filter(array('attachment_fields_to_edit',false),array('media_post_single_attachment_fields_to_edit',false),array(10,false),array(2,false));
;
?>
<?php echo AspisCheckPrint(get_media_items(array(null,false),$errors));
;
?>
</div>
<p class="ml-submit">
<input type="submit" class="button savebutton" name="save" value="<?php esc_attr_e(array('Save all changes',false));
;
?>" />
<input type="hidden" name="post_id" id="post_id" value="<?php echo AspisCheckPrint(int_cast($post_id));
;
?>" />
</p>
</form>
<?php  }
function type_url_form_image (  ) {
if ( (denot_boolean(apply_filters(array('disable_captions',false),array('',false)))))
 {$caption = concat2(concat1('
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="caption">',__(array('Image Caption',false))),'</label></span>
			</th>
			<td class="field"><input id="caption" name="caption" value="" type="text" /></td>
		</tr>
');
}else 
{{$caption = array('',false);
}}$default_align = get_option(array('image_default_align',false));
if ( ((empty($default_align) || Aspis_empty( $default_align))))
 $default_align = array('none',false);
return concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('
	<h4 class="media-sub-title">',__(array('Insert an image from another web site',false))),'</h4>
	<table class="describe"><tbody>
		<tr>
			<th valign="top" scope="row" class="label" style="width:130px;">
				<span class="alignleft"><label for="src">'),__(array('Image URL',false))),'</label></span>
				<span class="alignright"><abbr id="status_img" title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="src" name="src" value="" type="text" aria-required="true" onblur="addExtImage.getImageData()" /></td>
		</tr>

		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="title">'),__(array('Image Title',false))),'</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="title" name="title" value="" type="text" aria-required="true" /></td>
		</tr>

		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="alt">'),__(array('Alternate Text',false))),'</label></span>
			</th>
			<td class="field"><input id="alt" name="alt" value="" type="text" aria-required="true" />
			<p class="help">'),__(array('Alt text for the image, e.g. &#8220;The Mona Lisa&#8221;',false))),'</p></td>
		</tr>
		'),$caption),'
		<tr class="align">
			<th valign="top" scope="row" class="label"><p><label for="align">'),__(array('Alignment',false))),'</label></p></th>
			<td class="field">
				<input name="align" id="align-none" value="none" onclick="addExtImage.align=\'align\'+this.value" type="radio"'),(($default_align[0] == ('none')) ? array(' checked="checked"',false) : array('',false))),' />
				<label for="align-none" class="align image-align-none-label">'),__(array('None',false))),'</label>
				<input name="align" id="align-left" value="left" onclick="addExtImage.align=\'align\'+this.value" type="radio"'),(($default_align[0] == ('left')) ? array(' checked="checked"',false) : array('',false))),' />
				<label for="align-left" class="align image-align-left-label">'),__(array('Left',false))),'</label>
				<input name="align" id="align-center" value="center" onclick="addExtImage.align=\'align\'+this.value" type="radio"'),(($default_align[0] == ('center')) ? array(' checked="checked"',false) : array('',false))),' />
				<label for="align-center" class="align image-align-center-label">'),__(array('Center',false))),'</label>
				<input name="align" id="align-right" value="right" onclick="addExtImage.align=\'align\'+this.value" type="radio"'),(($default_align[0] == ('right')) ? array(' checked="checked"',false) : array('',false))),' />
				<label for="align-right" class="align image-align-right-label">'),__(array('Right',false))),'</label>
			</td>
		</tr>

		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="url">'),__(array('Link Image To:',false))),'</label></span>
			</th>
			<td class="field"><input id="url" name="url" value="" type="text" /><br />

			<button type="button" class="button" value="" onclick="document.forms[0].url.value=null">'),__(array('None',false))),'</button>
			<button type="button" class="button" value="" onclick="document.forms[0].url.value=document.forms[0].src.value">'),__(array('Link to image',false))),'</button>
			<p class="help">'),__(array('Enter a link URL or click above for presets.',false))),'</p></td>
		</tr>

		<tr>
			<td></td>
			<td>
				<input type="button" class="button" id="go_button" style="color:#bbb;" onclick="addExtImage.insert()" value="'),esc_attr__(array('Insert into Post',false))),'" />
			</td>
		</tr>
	</tbody></table>
');
 }
function type_url_form_audio (  ) {
return concat2(concat(concat2(concat(concat2(concat(concat2(concat1('
	<table class="describe"><tbody>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="insertonly[href]">',__(array('Audio File URL',false))),'</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="insertonly[href]" name="insertonly[href]" value="" type="text" aria-required="true"></td>
		</tr>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="insertonly[title]">'),__(array('Title',false))),'</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="insertonly[title]" name="insertonly[title]" value="" type="text" aria-required="true"></td>
		</tr>
		<tr><td></td><td class="help">'),__(array('Link text, e.g. &#8220;Still Alive by Jonathan Coulton&#8221;',false))),'</td></tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" class="button" name="insertonlybutton" value="'),esc_attr__(array('Insert into Post',false))),'" />
			</td>
		</tr>
	</tbody></table>
');
 }
function type_url_form_video (  ) {
return concat2(concat(concat2(concat(concat2(concat(concat2(concat1('
	<table class="describe"><tbody>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="insertonly[href]">',__(array('Video URL',false))),'</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="insertonly[href]" name="insertonly[href]" value="" type="text" aria-required="true"></td>
		</tr>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="insertonly[title]">'),__(array('Title',false))),'</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="insertonly[title]" name="insertonly[title]" value="" type="text" aria-required="true"></td>
		</tr>
		<tr><td></td><td class="help">'),__(array('Link text, e.g. &#8220;Lucy on YouTube&#8220;',false))),'</td></tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" class="button" name="insertonlybutton" value="'),esc_attr__(array('Insert into Post',false))),'" />
			</td>
		</tr>
	</tbody></table>
');
 }
function type_url_form_file (  ) {
return concat2(concat(concat2(concat(concat2(concat(concat2(concat1('
	<table class="describe"><tbody>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="insertonly[href]">',__(array('URL',false))),'</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="insertonly[href]" name="insertonly[href]" value="" type="text" aria-required="true"></td>
		</tr>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="insertonly[title]">'),__(array('Title',false))),'</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="insertonly[title]" name="insertonly[title]" value="" type="text" aria-required="true"></td>
		</tr>
		<tr><td></td><td class="help">'),__(array('Link text, e.g. &#8220;Ransom Demands (PDF)&#8221;',false))),'</td></tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" class="button" name="insertonlybutton" value="'),esc_attr__(array('Insert into Post',false))),'" />
			</td>
		</tr>
	</tbody></table>
');
 }
function media_upload_use_flash ( $flash ) {
if ( array_key_exists('flash',deAspisRC($_REQUEST)))
 $flash = not_boolean(array((empty($_REQUEST[0][('flash')]) || Aspis_empty( $_REQUEST [0][('flash')])),false));
return $flash;
 }
add_filter(array('flash_uploader',false),array('media_upload_use_flash',false));
function media_upload_flash_bypass (  ) {
echo AspisCheckPrint(array('<p class="upload-flash-bypass">',false));
printf(deAspis(__(array('You are using the Flash uploader.  Problems?  Try the <a href="%s">Browser uploader</a> instead.',false))),deAspisRC(esc_url(add_query_arg(array('flash',false),array(0,false)))));
echo AspisCheckPrint(array('</p>',false));
 }
function media_upload_html_bypass ( $flash = array(true,false) ) {
echo AspisCheckPrint(array('<p class="upload-html-bypass">',false));
_e(array('You are using the Browser uploader.',false));
if ( $flash[0])
 {echo AspisCheckPrint(array(' ',false));
printf(deAspis(__(array('Try the <a href="%s">Flash uploader</a> instead.',false))),deAspisRC(esc_url(add_query_arg(array('flash',false),array(1,false)))));
}echo AspisCheckPrint(array("</p>\n",false));
 }
add_action(array('post-flash-upload-ui',false),array('media_upload_flash_bypass',false));
add_action(array('post-html-upload-ui',false),array('media_upload_html_bypass',false));
function media_upload_bypass_url ( $url ) {
if ( array_key_exists('flash',deAspisRC($_REQUEST)))
 $url = add_query_arg(array('flash',false),Aspis_intval($_REQUEST[0]['flash']));
return $url;
 }
add_filter(array('media_upload_form_url',false),array('media_upload_bypass_url',false));
add_filter(array('async_upload_image',false),array('get_media_item',false),array(10,false),array(2,false));
add_filter(array('async_upload_audio',false),array('get_media_item',false),array(10,false),array(2,false));
add_filter(array('async_upload_video',false),array('get_media_item',false),array(10,false),array(2,false));
add_filter(array('async_upload_file',false),array('get_media_item',false),array(10,false),array(2,false));
add_action(array('media_upload_image',false),array('media_upload_image',false));
add_action(array('media_upload_audio',false),array('media_upload_audio',false));
add_action(array('media_upload_video',false),array('media_upload_video',false));
add_action(array('media_upload_file',false),array('media_upload_file',false));
add_filter(array('media_upload_gallery',false),array('media_upload_gallery',false));
add_filter(array('media_upload_library',false),array('media_upload_library',false));
