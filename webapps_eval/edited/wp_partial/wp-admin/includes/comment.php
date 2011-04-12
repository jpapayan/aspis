<?php require_once('AspisMain.php'); ?><?php
function comment_exists ( $comment_author,$comment_date ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$comment_author = stripslashes($comment_author);
$comment_date = stripslashes($comment_date);
{$AspisRetTemp = $wpdb->get_var($wpdb->prepare("SELECT comment_post_ID FROM $wpdb->comments
			WHERE comment_author = %s AND comment_date = %s",$comment_author,$comment_date));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function edit_comment (  ) {
$comment_post_ID = (int)deAspisWarningRC($_POST[0]['comment_post_ID']);
if ( !current_user_can('edit_post',$comment_post_ID))
 wp_die(__('You are not allowed to edit comments on this post, so you cannot edit this comment.'));
$_POST[0]['comment_author'] = attAspisRCO(deAspisWarningRC($_POST[0]['newcomment_author']));
$_POST[0]['comment_author_email'] = attAspisRCO(deAspisWarningRC($_POST[0]['newcomment_author_email']));
$_POST[0]['comment_author_url'] = attAspisRCO(deAspisWarningRC($_POST[0]['newcomment_author_url']));
$_POST[0]['comment_approved'] = attAspisRCO(deAspisWarningRC($_POST[0]['comment_status']));
$_POST[0]['comment_content'] = attAspisRCO(deAspisWarningRC($_POST[0]['content']));
$_POST[0]['comment_ID'] = attAspisRCO((int)deAspisWarningRC($_POST[0]['comment_ID']));
foreach ( array('aa','mm','jj','hh','mn') as $timeunit  )
{if ( !(empty($_POST[0]['hidden_' . $timeunit]) || Aspis_empty($_POST[0]['hidden_' . $timeunit])) && deAspisWarningRC($_POST[0]['hidden_' . $timeunit]) != deAspisWarningRC($_POST[0][$timeunit]))
 {$_POST[0]['edit_date'] = attAspisRCO('1');
break ;
}}if ( !(empty($_POST[0]['edit_date']) || Aspis_empty($_POST[0]['edit_date'])))
 {$aa = deAspisWarningRC($_POST[0]['aa']);
$mm = deAspisWarningRC($_POST[0]['mm']);
$jj = deAspisWarningRC($_POST[0]['jj']);
$hh = deAspisWarningRC($_POST[0]['hh']);
$mn = deAspisWarningRC($_POST[0]['mn']);
$ss = deAspisWarningRC($_POST[0]['ss']);
$jj = ($jj > 31) ? 31 : $jj;
$hh = ($hh > 23) ? $hh - 24 : $hh;
$mn = ($mn > 59) ? $mn - 60 : $mn;
$ss = ($ss > 59) ? $ss - 60 : $ss;
$_POST[0]['comment_date'] = attAspisRCO("$aa-$mm-$jj $hh:$mn:$ss");
}wp_update_comment(deAspisWarningRC($_POST));
 }
function get_comment_to_edit ( $id ) {
if ( !$comment = get_comment($id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$comment->comment_ID = (int)$comment->comment_ID;
$comment->comment_post_ID = (int)$comment->comment_post_ID;
$comment->comment_content = format_to_edit($comment->comment_content);
$comment->comment_content = apply_filters('comment_edit_pre',$comment->comment_content);
$comment->comment_author = format_to_edit($comment->comment_author);
$comment->comment_author_email = format_to_edit($comment->comment_author_email);
$comment->comment_author_url = format_to_edit($comment->comment_author_url);
$comment->comment_author_url = esc_url($comment->comment_author_url);
{$AspisRetTemp = $comment;
return $AspisRetTemp;
} }
function get_pending_comments_num ( $post_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$single = false;
if ( !is_array($post_id))
 {$post_id = (array)$post_id;
$single = true;
}$post_id = array_map('intval',$post_id);
$post_id = "'" . implode("', '",$post_id) . "'";
$pending = $wpdb->get_results("SELECT comment_post_ID, COUNT(comment_ID) as num_comments FROM $wpdb->comments WHERE comment_post_ID IN ( $post_id ) AND comment_approved = '0' GROUP BY comment_post_ID",ARRAY_N);
if ( empty($pending))
 {$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( $single)
 {$AspisRetTemp = $pending[0][1];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$pending_keyed = array();
foreach ( $pending as $pend  )
$pending_keyed[$pend[0]] = $pend[1];
{$AspisRetTemp = $pending_keyed;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function floated_admin_avatar ( $name ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}$id = $avatar = false;
if ( $comment->comment_author_email)
 $id = $comment->comment_author_email;
if ( $comment->user_id)
 $id = $comment->user_id;
if ( $id)
 $avatar = get_avatar($id,32);
{$AspisRetTemp = "$avatar $name";
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function enqueue_comment_hotkeys_js (  ) {
if ( 'true' == get_user_option('comment_shortcuts'))
 wp_enqueue_script('jquery-table-hotkeys');
 }
if ( is_admin() && isset($pagenow) && ('edit-comments.php' == $pagenow || 'edit.php' == $pagenow))
 {if ( get_option('show_avatars'))
 add_filter('comment_author','floated_admin_avatar');
};
?>
<?php 