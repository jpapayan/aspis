<?php require_once('AspisMain.php'); ?><?php
if ( ((empty($wp) || Aspis_empty( $wp))))
 {require_once ('./wp-load.php');
wp(array('tb=1',false));
}function trackback_response ( $error = array(0,false),$error_message = array('',false) ) {
header((deconcat1('Content-Type: text/xml; charset=',get_option(array('blog_charset',false)))));
if ( $error[0])
 {echo AspisCheckPrint(concat12('<?xml version="1.0" encoding="utf-8"?',">\n"));
echo AspisCheckPrint(array("<response>\n",false));
echo AspisCheckPrint(array("<error>1</error>\n",false));
echo AspisCheckPrint(concat2(concat1("<message>",$error_message),"</message>\n"));
echo AspisCheckPrint(array("</response>",false));
Aspis_exit();
}else 
{{echo AspisCheckPrint(concat12('<?xml version="1.0" encoding="utf-8"?',">\n"));
echo AspisCheckPrint(array("<response>\n",false));
echo AspisCheckPrint(array("<error>0</error>\n",false));
echo AspisCheckPrint(array("</response>",false));
}} }
$request_array = array('HTTP_POST_VARS',false);
if ( ((!((isset($_GET[0][('tb_id')]) && Aspis_isset( $_GET [0][('tb_id')])))) || (denot_boolean($_GET[0]['tb_id']))))
 {$tb_id = Aspis_explode(array('/',false),$_SERVER[0]['REQUEST_URI']);
$tb_id = Aspis_intval(attachAspis($tb_id,(count($tb_id[0]) - (1))));
}$tb_url = ((isset($_POST[0][('url')]) && Aspis_isset( $_POST [0][('url')]))) ? $_POST[0]['url'] : array('',false);
$charset = ((isset($_POST[0][('charset')]) && Aspis_isset( $_POST [0][('charset')]))) ? $_POST[0]['charset'] : array('',false);
$title = ((isset($_POST[0][('title')]) && Aspis_isset( $_POST [0][('title')]))) ? Aspis_stripslashes($_POST[0]['title']) : array('',false);
$excerpt = ((isset($_POST[0][('excerpt')]) && Aspis_isset( $_POST [0][('excerpt')]))) ? Aspis_stripslashes($_POST[0]['excerpt']) : array('',false);
$blog_name = ((isset($_POST[0][('blog_name')]) && Aspis_isset( $_POST [0][('blog_name')]))) ? Aspis_stripslashes($_POST[0]['blog_name']) : array('',false);
if ( $charset[0])
 $charset = Aspis_str_replace(array(array(array(',',false),array(' ',false)),false),array('',false),Aspis_strtoupper(Aspis_trim($charset)));
else 
{$charset = array('ASCII, UTF-8, ISO-8859-1, JIS, EUC-JP, SJIS',false);
}if ( (false !== strpos($charset[0],'UTF-7')))
 Aspis_exit();
if ( function_exists(('mb_convert_encoding')))
 {$title = Aspis_mb_convert_encoding($title,get_option(array('blog_charset',false)),$charset);
$excerpt = Aspis_mb_convert_encoding($excerpt,get_option(array('blog_charset',false)),$charset);
$blog_name = Aspis_mb_convert_encoding($blog_name,get_option(array('blog_charset',false)),$charset);
}$title = $wpdb[0]->escape($title);
$excerpt = $wpdb[0]->escape($excerpt);
$blog_name = $wpdb[0]->escape($blog_name);
if ( (deAspis(is_single()) || deAspis(is_page())))
 $tb_id = $posts[0][(0)][0]->ID;
if ( ((!((isset($tb_id) && Aspis_isset( $tb_id)))) || (denot_boolean(Aspis_intval($tb_id)))))
 trackback_response(array(1,false),array('I really need an ID for this to work.',false));
if ( ((((empty($title) || Aspis_empty( $title))) && ((empty($tb_url) || Aspis_empty( $tb_url)))) && ((empty($blog_name) || Aspis_empty( $blog_name)))))
 {wp_redirect(get_permalink($tb_id));
Aspis_exit();
}if ( ((!((empty($tb_url) || Aspis_empty( $tb_url)))) && (!((empty($title) || Aspis_empty( $title))))))
 {header((deconcat1('Content-Type: text/xml; charset=',get_option(array('blog_charset',false)))));
if ( (denot_boolean(pings_open($tb_id))))
 trackback_response(array(1,false),array('Sorry, trackbacks are closed for this item.',false));
$title = concat2(wp_html_excerpt($title,array(250,false)),'...');
$excerpt = concat2(wp_html_excerpt($excerpt,array(252,false)),'...');
$comment_post_ID = int_cast($tb_id);
$comment_author = $blog_name;
$comment_author_email = array('',false);
$comment_author_url = $tb_url;
$comment_content = concat(concat2(concat1("<strong>",$title),"</strong>\n\n"),$excerpt);
$comment_type = array('trackback',false);
$dupe = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d AND comment_author_url = %s"),$comment_post_ID,$comment_author_url));
if ( $dupe[0])
 trackback_response(array(1,false),array('We already have a ping from that URL for this post.',false));
$commentdata = array(compact('comment_post_ID','comment_author','comment_author_email','comment_author_url','comment_content','comment_type'),false);
wp_new_comment($commentdata);
do_action(array('trackback_post',false),$wpdb[0]->insert_id);
trackback_response(array(0,false));
};
