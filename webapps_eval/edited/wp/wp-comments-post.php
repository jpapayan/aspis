<?php require_once('AspisMain.php'); ?><?php
if ( (('POST') != deAspis($_SERVER[0]['REQUEST_METHOD'])))
 {header(('Allow: POST'));
header(('HTTP/1.1 405 Method Not Allowed'));
header(('Content-Type: text/plain'));
Aspis_exit();
}require (deconcat2(Aspis_dirname(array(__FILE__,false)),'/wp-load.php'));
nocache_headers();
$comment_post_ID = ((isset($_POST[0][('comment_post_ID')]) && Aspis_isset( $_POST [0][('comment_post_ID')]))) ? int_cast($_POST[0]['comment_post_ID']) : array(0,false);
$status = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT post_status, comment_status FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$comment_post_ID));
if ( ((empty($status[0]->comment_status) || Aspis_empty( $status[0] ->comment_status ))))
 {do_action(array('comment_id_not_found',false),$comment_post_ID);
Aspis_exit();
}elseif ( (denot_boolean(comments_open($comment_post_ID))))
 {do_action(array('comment_closed',false),$comment_post_ID);
wp_die(__(array('Sorry, comments are closed for this item.',false)));
}elseif ( deAspis(Aspis_in_array($status[0]->post_status,array(array(array('draft',false),array('future',false),array('pending',false)),false))))
 {do_action(array('comment_on_draft',false),$comment_post_ID);
Aspis_exit();
}elseif ( (('trash') == $status[0]->post_status[0]))
 {do_action(array('comment_on_trash',false),$comment_post_ID);
Aspis_exit();
}elseif ( deAspis(post_password_required($comment_post_ID)))
 {do_action(array('comment_on_password_protected',false),$comment_post_ID);
Aspis_exit();
}else 
{{do_action(array('pre_comment_on_post',false),$comment_post_ID);
}}$comment_author = ((isset($_POST[0][('author')]) && Aspis_isset( $_POST [0][('author')]))) ? Aspis_trim(Aspis_strip_tags($_POST[0]['author'])) : array(null,false);
$comment_author_email = ((isset($_POST[0][('email')]) && Aspis_isset( $_POST [0][('email')]))) ? Aspis_trim($_POST[0]['email']) : array(null,false);
$comment_author_url = ((isset($_POST[0][('url')]) && Aspis_isset( $_POST [0][('url')]))) ? Aspis_trim($_POST[0]['url']) : array(null,false);
$comment_content = ((isset($_POST[0][('comment')]) && Aspis_isset( $_POST [0][('comment')]))) ? Aspis_trim($_POST[0]['comment']) : array(null,false);
$user = wp_get_current_user();
if ( $user[0]->ID[0])
 {if ( ((empty($user[0]->display_name) || Aspis_empty( $user[0] ->display_name ))))
 $user[0]->display_name = $user[0]->user_login;
$comment_author = $wpdb[0]->escape($user[0]->display_name);
$comment_author_email = $wpdb[0]->escape($user[0]->user_email);
$comment_author_url = $wpdb[0]->escape($user[0]->user_url);
if ( deAspis(current_user_can(array('unfiltered_html',false))))
 {if ( (deAspis(wp_create_nonce(concat1('unfiltered-html-comment_',$comment_post_ID))) != deAspis($_POST[0]['_wp_unfiltered_html_comment'])))
 {kses_remove_filters();
kses_init_filters();
}}}else 
{{if ( (deAspis(get_option(array('comment_registration',false))) || (('private') == $status[0]->post_status[0])))
 wp_die(__(array('Sorry, you must be logged in to post a comment.',false)));
}}$comment_type = array('',false);
if ( (deAspis(get_option(array('require_name_email',false))) && (denot_boolean($user[0]->ID))))
 {if ( (((6) > strlen($comment_author_email[0])) || (('') == $comment_author[0])))
 wp_die(__(array('Error: please fill the required fields (name, email).',false)));
elseif ( (denot_boolean(is_email($comment_author_email))))
 wp_die(__(array('Error: please enter a valid email address.',false)));
}if ( (('') == $comment_content[0]))
 wp_die(__(array('Error: please type a comment.',false)));
$comment_parent = ((isset($_POST[0][('comment_parent')]) && Aspis_isset( $_POST [0][('comment_parent')]))) ? absint($_POST[0]['comment_parent']) : array(0,false);
$commentdata = array(compact('comment_post_ID','comment_author','comment_author_email','comment_author_url','comment_content','comment_type','comment_parent','user_ID'),false);
$comment_id = wp_new_comment($commentdata);
$comment = get_comment($comment_id);
if ( (denot_boolean($user[0]->ID)))
 {$comment_cookie_lifetime = apply_filters(array('comment_cookie_lifetime',false),array(30000000,false));
setcookie((deconcat12('comment_author_',COOKIEHASH)),$comment[0]->comment_author[0],(time() + $comment_cookie_lifetime[0]),COOKIEPATH,COOKIE_DOMAIN);
setcookie((deconcat12('comment_author_email_',COOKIEHASH)),$comment[0]->comment_author_email[0],(time() + $comment_cookie_lifetime[0]),COOKIEPATH,COOKIE_DOMAIN);
setcookie((deconcat12('comment_author_url_',COOKIEHASH)),deAspis(esc_url($comment[0]->comment_author_url)),(time() + $comment_cookie_lifetime[0]),COOKIEPATH,COOKIE_DOMAIN);
}$location = ((empty($_POST[0][('redirect_to')]) || Aspis_empty( $_POST [0][('redirect_to')]))) ? get_comment_link($comment_id) : concat(concat2($_POST[0]['redirect_to'],'#comment-'),$comment_id);
$location = apply_filters(array('comment_post_redirect',false),$location,$comment);
wp_redirect($location);
;
?>
<?php 