<?php require_once('AspisMain.php'); ?><?php
function has_post_thumbnail ( $post_id = array(NULL,false) ) {
global $id;
$post_id = (NULL === $post_id[0]) ? $id : $post_id;
return not_boolean(not_boolean(get_post_thumbnail_id($post_id)));
 }
function get_post_thumbnail_id ( $post_id = array(NULL,false) ) {
global $id;
$post_id = (NULL === $post_id[0]) ? $id : $post_id;
return get_post_meta($post_id,array('_thumbnail_id',false),array(true,false));
 }
function the_post_thumbnail ( $size = array('post-thumbnail',false),$attr = array('',false) ) {
echo AspisCheckPrint(get_the_post_thumbnail(array(NULL,false),$size,$attr));
 }
function get_the_post_thumbnail ( $post_id = array(NULL,false),$size = array('post-thumbnail',false),$attr = array('',false) ) {
global $id;
$post_id = (NULL === $post_id[0]) ? $id : $post_id;
$post_thumbnail_id = get_post_thumbnail_id($post_id);
$size = apply_filters(array('post_thumbnail_size',false),$size);
if ( $post_thumbnail_id[0])
 {do_action(array('begin_fetch_post_thumbnail_html',false),$post_id,$post_thumbnail_id,$size);
$html = wp_get_attachment_image($post_thumbnail_id,$size,array(false,false),$attr);
do_action(array('end_fetch_post_thumbnail_html',false),$post_id,$post_thumbnail_id,$size);
}else 
{{$html = array('',false);
}}return apply_filters(array('post_thumbnail_html',false),$html,$post_id,$post_thumbnail_id,$size,$attr);
 }
;
