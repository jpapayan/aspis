<?php require_once('AspisMain.php'); ?><?php
class BW_Import{var $file;
function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Import Blogware',false))),'</h2>'));
} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function unhtmlentities ( $string ) {
{$trans_tbl = attAspisRC(get_html_translation_table(HTML_ENTITIES));
$trans_tbl = Aspis_array_flip($trans_tbl);
return Aspis_strtr($string,$trans_tbl);
} }
function greet (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Howdy! This importer allows you to extract posts from Blogware XML export file into your blog.  Pick a Blogware file to upload and click Import.',false))),'</p>'));
wp_import_upload_form(array("admin.php?import=blogware&amp;step=1",false));
echo AspisCheckPrint(array('</div>',false));
} }
function _normalize_tag ( $matches ) {
{return concat1('<',Aspis_strtolower(attachAspis($matches,(1))));
} }
function import_posts (  ) {
{global $wpdb,$current_user;
set_magic_quotes_runtime(0);
$importdata = Aspis_file($this->file);
$importdata = Aspis_implode(array('',false),$importdata);
$importdata = Aspis_str_replace(array(array(array("\r\n",false),array("\r",false)),false),array("\n",false),$importdata);
Aspis_preg_match_all(array('|(<item[^>]+>(.*?)</item>)|is',false),$importdata,$posts);
$posts = attachAspis($posts,(1));
unset($importdata);
echo AspisCheckPrint(array('<ol>',false));
foreach ( $posts[0] as $post  )
{flush();
Aspis_preg_match(array('|<item type=\"(.*?)\">|is',false),$post,$post_type);
$post_type = attachAspis($post_type,(1));
if ( ($post_type[0] == ("photo")))
 {Aspis_preg_match(array('|<photoFilename>(.*?)</photoFilename>|is',false),$post,$post_title);
}else 
{{Aspis_preg_match(array('|<title>(.*?)</title>|is',false),$post,$post_title);
}}$post_title = $wpdb[0]->escape(Aspis_trim(attachAspis($post_title,(1))));
Aspis_preg_match(array('|<pubDate>(.*?)</pubDate>|is',false),$post,$post_date);
$post_date = attAspis(strtotime(deAspis(attachAspis($post_date,(1)))));
$post_date = attAspis(gmdate(('Y-m-d H:i:s'),$post_date[0]));
Aspis_preg_match_all(array('|<category>(.*?)</category>|is',false),$post,$categories);
$categories = attachAspis($categories,(1));
$cat_index = array(0,false);
foreach ( $categories[0] as $category  )
{arrayAssign($categories[0],deAspis(registerTaint($cat_index)),addTaint($wpdb[0]->escape($this->unhtmlentities($category))));
postincr($cat_index);
}if ( (strcasecmp($post_type[0],("photo")) === (0)))
 {Aspis_preg_match(array('|<sizedPhotoUrl>(.*?)</sizedPhotoUrl>|is',false),$post,$post_content);
$post_content = concat2(concat1('<img src="',Aspis_trim(attachAspis($post_content,(1)))),'" />');
$post_content = $this->unhtmlentities($post_content);
}else 
{{Aspis_preg_match(array('|<body>(.*?)</body>|is',false),$post,$post_content);
$post_content = Aspis_str_replace(array(array(array('<![CDATA[',false),array(']]>',false)),false),array('',false),Aspis_trim(attachAspis($post_content,(1))));
$post_content = $this->unhtmlentities($post_content);
}}$post_content = Aspis_preg_replace_callback(array('|<(/?[A-Z]+)|',false),array(array(array($this,false),array('_normalize_tag',false)),false),$post_content);
$post_content = Aspis_str_replace(array('<br>',false),array('<br />',false),$post_content);
$post_content = Aspis_str_replace(array('<hr>',false),array('<hr />',false),$post_content);
$post_content = $wpdb[0]->escape($post_content);
$post_author = $current_user[0]->ID;
Aspis_preg_match(array('|<postStatus>(.*?)</postStatus>|is',false),$post,$post_status);
$post_status = Aspis_trim(attachAspis($post_status,(1)));
echo AspisCheckPrint(array('<li>',false));
if ( deAspis($post_id = post_exists($post_title,$post_content,$post_date)))
 {printf(deAspis(__(array('Post <em>%s</em> already exists.',false))),deAspisRC(Aspis_stripslashes($post_title)));
}else 
{{printf(deAspis(__(array('Importing post <em>%s</em>...',false))),deAspisRC(Aspis_stripslashes($post_title)));
$postdata = array(compact('post_author','post_date','post_content','post_title','post_status'),false);
$post_id = wp_insert_post($postdata);
if ( deAspis(is_wp_error($post_id)))
 {return $post_id;
}if ( (denot_boolean($post_id)))
 {_e(array('Couldn&#8217;t get post ID',false));
echo AspisCheckPrint(array('</li>',false));
break ;
}if ( ((0) != count($categories[0])))
 wp_create_categories($categories,$post_id);
}}Aspis_preg_match_all(array('|<comment>(.*?)</comment>|is',false),$post,$comments);
$comments = attachAspis($comments,(1));
if ( $comments[0])
 {$comment_post_ID = int_cast($post_id);
$num_comments = array(0,false);
foreach ( $comments[0] as $comment  )
{Aspis_preg_match(array('|<body>(.*?)</body>|is',false),$comment,$comment_content);
$comment_content = Aspis_str_replace(array(array(array('<![CDATA[',false),array(']]>',false)),false),array('',false),Aspis_trim(attachAspis($comment_content,(1))));
$comment_content = $this->unhtmlentities($comment_content);
$comment_content = Aspis_preg_replace_callback(array('|<(/?[A-Z]+)|',false),array(array(array($this,false),array('_normalize_tag',false)),false),$comment_content);
$comment_content = Aspis_str_replace(array('<br>',false),array('<br />',false),$comment_content);
$comment_content = Aspis_str_replace(array('<hr>',false),array('<hr />',false),$comment_content);
$comment_content = $wpdb[0]->escape($comment_content);
Aspis_preg_match(array('|<pubDate>(.*?)</pubDate>|is',false),$comment,$comment_date);
$comment_date = Aspis_trim(attachAspis($comment_date,(1)));
$comment_date = attAspis(date(('Y-m-d H:i:s'),strtotime($comment_date[0])));
Aspis_preg_match(array('|<author>(.*?)</author>|is',false),$comment,$comment_author);
$comment_author = $wpdb[0]->escape(Aspis_trim(attachAspis($comment_author,(1))));
$comment_author_email = array(NULL,false);
$comment_approved = array(1,false);
if ( (denot_boolean(comment_exists($comment_author,$comment_date))))
 {$commentdata = array(compact('comment_post_ID','comment_author','comment_author_email','comment_date','comment_content','comment_approved'),false);
$commentdata = wp_filter_comment($commentdata);
wp_insert_comment($commentdata);
postincr($num_comments);
}}}if ( $num_comments[0])
 {echo AspisCheckPrint(array(' ',false));
printf(deAspis(_n(array('%s comment',false),array('%s comments',false),$num_comments)),deAspisRC($num_comments));
}echo AspisCheckPrint(array('</li>',false));
flush();
ob_flush();
}echo AspisCheckPrint(array('</ol>',false));
} }
function import (  ) {
{$file = wp_import_handle_upload();
if ( ((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))))
 {echo AspisCheckPrint($file[0]['error']);
return ;
}$this->file = $file[0]['file'];
$result = $this->import_posts();
if ( deAspis(is_wp_error($result)))
 return $result;
wp_import_cleanup($file[0]['id']);
do_action(array('import_done',false),array('blogware',false));
echo AspisCheckPrint(array('<h3>',false));
printf(deAspis(__(array('All done. <a href="%s">Have fun!</a>',false))),deAspisRC(get_option(array('home',false))));
echo AspisCheckPrint(array('</h3>',false));
} }
function dispatch (  ) {
{if ( ((empty($_GET[0][('step')]) || Aspis_empty( $_GET [0][('step')]))))
 $step = array(0,false);
else 
{$step = int_cast($_GET[0]['step']);
}$this->header();
switch ( $step[0] ) {
case (0):$this->greet();
break ;
case (1):$result = $this->import();
if ( deAspis(is_wp_error($result)))
 $result[0]->get_error_message();
break ;
 }
$this->footer();
} }
function BW_Import (  ) {
{} }
}$blogware_import = array(new BW_Import(),false);
register_importer(array('blogware',false),__(array('Blogware',false)),__(array('Import posts from Blogware.',false)),array(array($blogware_import,array('dispatch',false)),false));
;
?>
<?php 