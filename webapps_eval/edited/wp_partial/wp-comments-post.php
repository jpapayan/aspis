<?php require_once('AspisMain.php'); ?><?php
if ( 'POST' != deAspisWarningRC($_SERVER[0]['REQUEST_METHOD']))
 {header('Allow: POST');
header('HTTP/1.1 405 Method Not Allowed');
header('Content-Type: text/plain');
exit();
}require (dirname(__FILE__) . '/wp-load.php');
nocache_headers();
$comment_post_ID = (isset($_POST[0]['comment_post_ID']) && Aspis_isset($_POST[0]['comment_post_ID'])) ? (int)deAspisWarningRC($_POST[0]['comment_post_ID']) : 0;
$status = $wpdb->get_row($wpdb->prepare("SELECT post_status, comment_status FROM $wpdb->posts WHERE ID = %d",$comment_post_ID));
if ( empty($status->comment_status))
 {do_action('comment_id_not_found',$comment_post_ID);
exit();
}elseif ( !comments_open($comment_post_ID))
 {do_action('comment_closed',$comment_post_ID);
wp_die(__('Sorry, comments are closed for this item.'));
}elseif ( in_array($status->post_status,array('draft','future','pending')))
 {do_action('comment_on_draft',$comment_post_ID);
exit();
}elseif ( 'trash' == $status->post_status)
 {do_action('comment_on_trash',$comment_post_ID);
exit();
}elseif ( post_password_required($comment_post_ID))
 {do_action('comment_on_password_protected',$comment_post_ID);
exit();
}else 
{{do_action('pre_comment_on_post',$comment_post_ID);
}}$comment_author = ((isset($_POST[0]['author']) && Aspis_isset($_POST[0]['author']))) ? trim(strip_tags(deAspisWarningRC($_POST[0]['author']))) : null;
$comment_author_email = ((isset($_POST[0]['email']) && Aspis_isset($_POST[0]['email']))) ? trim(deAspisWarningRC($_POST[0]['email'])) : null;
$comment_author_url = ((isset($_POST[0]['url']) && Aspis_isset($_POST[0]['url']))) ? trim(deAspisWarningRC($_POST[0]['url'])) : null;
$comment_content = ((isset($_POST[0]['comment']) && Aspis_isset($_POST[0]['comment']))) ? trim(deAspisWarningRC($_POST[0]['comment'])) : null;
$user = wp_get_current_user();
if ( $user->ID)
 {if ( empty($user->display_name))
 $user->display_name = $user->user_login;
$comment_author = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->display_name)),array(0));
$comment_author_email = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_email)),array(0));
$comment_author_url = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_url)),array(0));
if ( current_user_can('unfiltered_html'))
 {if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != deAspisWarningRC($_POST[0]['_wp_unfiltered_html_comment']))
 {kses_remove_filters();
kses_init_filters();
}}}else 
{{if ( get_option('comment_registration') || 'private' == $status->post_status)
 wp_die(__('Sorry, you must be logged in to post a comment.'));
}}$comment_type = '';
if ( get_option('require_name_email') && !$user->ID)
 {if ( 6 > strlen($comment_author_email) || '' == $comment_author)
 wp_die(__('Error: please fill the required fields (name, email).'));
elseif ( !is_email($comment_author_email))
 wp_die(__('Error: please enter a valid email address.'));
}if ( '' == $comment_content)
 wp_die(__('Error: please type a comment.'));
$comment_parent = (isset($_POST[0]['comment_parent']) && Aspis_isset($_POST[0]['comment_parent'])) ? absint(deAspisWarningRC($_POST[0]['comment_parent'])) : 0;
$commentdata = compact('comment_post_ID','comment_author','comment_author_email','comment_author_url','comment_content','comment_type','comment_parent','user_ID');
$comment_id = wp_new_comment($commentdata);
$comment = get_comment($comment_id);
if ( !$user->ID)
 {$comment_cookie_lifetime = apply_filters('comment_cookie_lifetime',30000000);
setcookie('comment_author_' . COOKIEHASH,$comment->comment_author,time() + $comment_cookie_lifetime,COOKIEPATH,COOKIE_DOMAIN);
setcookie('comment_author_email_' . COOKIEHASH,$comment->comment_author_email,time() + $comment_cookie_lifetime,COOKIEPATH,COOKIE_DOMAIN);
setcookie('comment_author_url_' . COOKIEHASH,esc_url($comment->comment_author_url),time() + $comment_cookie_lifetime,COOKIEPATH,COOKIE_DOMAIN);
}$location = (empty($_POST[0]['redirect_to']) || Aspis_empty($_POST[0]['redirect_to'])) ? get_comment_link($comment_id) : deAspisWarningRC($_POST[0]['redirect_to']) . '#comment-' . $comment_id;
$location = apply_filters('comment_post_redirect',$location,$comment);
wp_redirect($location);
;
?>
<?php 