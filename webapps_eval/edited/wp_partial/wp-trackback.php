<?php require_once('AspisMain.php'); ?><?php
if ( empty($wp))
 {require_once ('./wp-load.php');
wp('tb=1');
}function trackback_response ( $error = 0,$error_message = '' ) {
header('Content-Type: text/xml; charset=' . get_option('blog_charset'));
if ( $error)
 {echo '<?xml version="1.0" encoding="utf-8"?' . ">\n";
echo "<response>\n";
echo "<error>1</error>\n";
echo "<message>$error_message</message>\n";
echo "</response>";
exit();
}else 
{{echo '<?xml version="1.0" encoding="utf-8"?' . ">\n";
echo "<response>\n";
echo "<error>0</error>\n";
echo "</response>";
}} }
$request_array = 'HTTP_POST_VARS';
if ( !(isset($_GET[0]['tb_id']) && Aspis_isset($_GET[0]['tb_id'])) || !deAspisWarningRC($_GET[0]['tb_id']))
 {$tb_id = explode('/',deAspisWarningRC($_SERVER[0]['REQUEST_URI']));
$tb_id = intval($tb_id[count($tb_id) - 1]);
}$tb_url = (isset($_POST[0]['url']) && Aspis_isset($_POST[0]['url'])) ? deAspisWarningRC($_POST[0]['url']) : '';
$charset = (isset($_POST[0]['charset']) && Aspis_isset($_POST[0]['charset'])) ? deAspisWarningRC($_POST[0]['charset']) : '';
$title = (isset($_POST[0]['title']) && Aspis_isset($_POST[0]['title'])) ? stripslashes(deAspisWarningRC($_POST[0]['title'])) : '';
$excerpt = (isset($_POST[0]['excerpt']) && Aspis_isset($_POST[0]['excerpt'])) ? stripslashes(deAspisWarningRC($_POST[0]['excerpt'])) : '';
$blog_name = (isset($_POST[0]['blog_name']) && Aspis_isset($_POST[0]['blog_name'])) ? stripslashes(deAspisWarningRC($_POST[0]['blog_name'])) : '';
if ( $charset)
 $charset = str_replace(array(',',' '),'',strtoupper(trim($charset)));
else 
{$charset = 'ASCII, UTF-8, ISO-8859-1, JIS, EUC-JP, SJIS';
}if ( false !== strpos($charset,'UTF-7'))
 exit();
if ( function_exists('mb_convert_encoding'))
 {$title = mb_convert_encoding($title,get_option('blog_charset'),$charset);
$excerpt = mb_convert_encoding($excerpt,get_option('blog_charset'),$charset);
$blog_name = mb_convert_encoding($blog_name,get_option('blog_charset'),$charset);
}$title = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($title)),array(0));
$excerpt = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($excerpt)),array(0));
$blog_name = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($blog_name)),array(0));
if ( is_single() || is_page())
 $tb_id = $posts[0]->ID;
if ( !isset($tb_id) || !intval($tb_id))
 trackback_response(1,'I really need an ID for this to work.');
if ( empty($title) && empty($tb_url) && empty($blog_name))
 {wp_redirect(get_permalink($tb_id));
exit();
}if ( !empty($tb_url) && !empty($title))
 {header('Content-Type: text/xml; charset=' . get_option('blog_charset'));
if ( !pings_open($tb_id))
 trackback_response(1,'Sorry, trackbacks are closed for this item.');
$title = wp_html_excerpt($title,250) . '...';
$excerpt = wp_html_excerpt($excerpt,252) . '...';
$comment_post_ID = (int)$tb_id;
$comment_author = $blog_name;
$comment_author_email = '';
$comment_author_url = $tb_url;
$comment_content = "<strong>$title</strong>\n\n$excerpt";
$comment_type = 'trackback';
$dupe = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_author_url = %s",$comment_post_ID,$comment_author_url));
if ( $dupe)
 trackback_response(1,'We already have a ping from that URL for this post.');
$commentdata = compact('comment_post_ID','comment_author','comment_author_email','comment_author_url','comment_content','comment_type');
wp_new_comment($commentdata);
do_action('trackback_post',$wpdb->insert_id);
trackback_response(0);
};
