<?php require_once('AspisMain.php'); ?><?php
function has_post_thumbnail ( $post_id = NULL ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}$post_id = (NULL === $post_id) ? $id : $post_id;
{$AspisRetTemp = !!get_post_thumbnail_id($post_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function get_post_thumbnail_id ( $post_id = NULL ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}$post_id = (NULL === $post_id) ? $id : $post_id;
{$AspisRetTemp = get_post_meta($post_id,'_thumbnail_id',true);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function the_post_thumbnail ( $size = 'post-thumbnail',$attr = '' ) {
echo get_the_post_thumbnail(NULL,$size,$attr);
 }
function get_the_post_thumbnail ( $post_id = NULL,$size = 'post-thumbnail',$attr = '' ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}$post_id = (NULL === $post_id) ? $id : $post_id;
$post_thumbnail_id = get_post_thumbnail_id($post_id);
$size = apply_filters('post_thumbnail_size',$size);
if ( $post_thumbnail_id)
 {do_action('begin_fetch_post_thumbnail_html',$post_id,$post_thumbnail_id,$size);
$html = wp_get_attachment_image($post_thumbnail_id,$size,false,$attr);
do_action('end_fetch_post_thumbnail_html',$post_id,$post_thumbnail_id,$size);
}else 
{{$html = '';
}}{$AspisRetTemp = apply_filters('post_thumbnail_html',$html,$post_id,$post_thumbnail_id,$size,$attr);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
;
