<?php require_once('AspisMain.php'); ?><?php
class RSS_Import{var $posts = array(array(),false);
var $file;
function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Import RSS',false))),'</h2>'));
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
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Howdy! This importer allows you to extract posts from an RSS 2.0 file into your blog. This is useful if you want to import your posts from a system that is not handled by a custom import tool. Pick an RSS file to upload and click Import.',false))),'</p>'));
wp_import_upload_form(array("admin.php?import=rss&amp;step=1",false));
echo AspisCheckPrint(array('</div>',false));
} }
function _normalize_tag ( $matches ) {
{return concat1('<',Aspis_strtolower(attachAspis($matches,(1))));
} }
function get_posts (  ) {
{global $wpdb;
set_magic_quotes_runtime(0);
$datalines = Aspis_file($this->file);
$importdata = Aspis_implode(array('',false),$datalines);
$importdata = Aspis_str_replace(array(array(array("\r\n",false),array("\r",false)),false),array("\n",false),$importdata);
Aspis_preg_match_all(array('|<item>(.*?)</item>|is',false),$importdata,$this->posts);
$this->posts = $this->posts[0][(1)];
$index = array(0,false);
foreach ( $this->posts[0] as $post  )
{Aspis_preg_match(array('|<title>(.*?)</title>|is',false),$post,$post_title);
$post_title = Aspis_str_replace(array(array(array('<![CDATA[',false),array(']]>',false)),false),array('',false),$wpdb[0]->escape(Aspis_trim(attachAspis($post_title,(1)))));
Aspis_preg_match(array('|<pubdate>(.*?)</pubdate>|is',false),$post,$post_date_gmt);
if ( $post_date_gmt[0])
 {$post_date_gmt = attAspis(strtotime(deAspis(attachAspis($post_date_gmt,(1)))));
}else 
{{Aspis_preg_match(array('|<dc:date>(.*?)</dc:date>|is',false),$post,$post_date_gmt);
$post_date_gmt = Aspis_preg_replace(array('|([-+])([0-9]+):([0-9]+)$|',false),array('\1\2\3',false),attachAspis($post_date_gmt,(1)));
$post_date_gmt = Aspis_str_replace(array('T',false),array(' ',false),$post_date_gmt);
$post_date_gmt = attAspis(strtotime($post_date_gmt[0]));
}}$post_date_gmt = attAspis(gmdate(('Y-m-d H:i:s'),$post_date_gmt[0]));
$post_date = get_date_from_gmt($post_date_gmt);
Aspis_preg_match_all(array('|<category>(.*?)</category>|is',false),$post,$categories);
$categories = attachAspis($categories,(1));
if ( (denot_boolean($categories)))
 {Aspis_preg_match_all(array('|<dc:subject>(.*?)</dc:subject>|is',false),$post,$categories);
$categories = attachAspis($categories,(1));
}$cat_index = array(0,false);
foreach ( $categories[0] as $category  )
{arrayAssign($categories[0],deAspis(registerTaint($cat_index)),addTaint($wpdb[0]->escape($this->unhtmlentities($category))));
postincr($cat_index);
}Aspis_preg_match(array('|<guid.*?>(.*?)</guid>|is',false),$post,$guid);
if ( $guid[0])
 $guid = $wpdb[0]->escape(Aspis_trim(attachAspis($guid,(1))));
else 
{$guid = array('',false);
}Aspis_preg_match(array('|<content:encoded>(.*?)</content:encoded>|is',false),$post,$post_content);
$post_content = Aspis_str_replace(array(array(array('<![CDATA[',false),array(']]>',false)),false),array('',false),$wpdb[0]->escape(Aspis_trim(attachAspis($post_content,(1)))));
if ( (denot_boolean($post_content)))
 {Aspis_preg_match(array('|<description>(.*?)</description>|is',false),$post,$post_content);
$post_content = $wpdb[0]->escape($this->unhtmlentities(Aspis_trim(attachAspis($post_content,(1)))));
}$post_content = Aspis_preg_replace_callback(array('|<(/?[A-Z]+)|',false),array(array(array($this,false),array('_normalize_tag',false)),false),$post_content);
$post_content = Aspis_str_replace(array('<br>',false),array('<br />',false),$post_content);
$post_content = Aspis_str_replace(array('<hr>',false),array('<hr />',false),$post_content);
$post_author = array(1,false);
$post_status = array('publish',false);
arrayAssign($this->posts[0],deAspis(registerTaint($index)),addTaint(array(compact('post_author','post_date','post_date_gmt','post_content','post_title','post_status','guid','categories'),false)));
postincr($index);
}} }
function import_posts (  ) {
{echo AspisCheckPrint(array('<ol>',false));
foreach ( $this->posts[0] as $post  )
{echo AspisCheckPrint(concat1("<li>",__(array('Importing post...',false))));
extract(($post[0]));
if ( deAspis($post_id = post_exists($post_title,$post_content,$post_date)))
 {_e(array('Post already imported',false));
}else 
{{$post_id = wp_insert_post($post);
if ( deAspis(is_wp_error($post_id)))
 return $post_id;
if ( (denot_boolean($post_id)))
 {_e(array('Couldn&#8217;t get post ID',false));
return ;
}if ( ((0) != count($categories[0])))
 wp_create_categories($categories,$post_id);
_e(array('Done !',false));
}}echo AspisCheckPrint(array('</li>',false));
}echo AspisCheckPrint(array('</ol>',false));
} }
function import (  ) {
{$file = wp_import_handle_upload();
if ( ((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))))
 {echo AspisCheckPrint($file[0]['error']);
return ;
}$this->file = $file[0]['file'];
$this->get_posts();
$result = $this->import_posts();
if ( deAspis(is_wp_error($result)))
 return $result;
wp_import_cleanup($file[0]['id']);
do_action(array('import_done',false),array('rss',false));
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
case (1):check_admin_referer(array('import-upload',false));
$result = $this->import();
if ( deAspis(is_wp_error($result)))
 echo AspisCheckPrint($result[0]->get_error_message());
break ;
 }
$this->footer();
} }
function RSS_Import (  ) {
{} }
}$rss_import = array(new RSS_Import(),false);
register_importer(array('rss',false),__(array('RSS',false)),__(array('Import posts from an RSS feed.',false)),array(array($rss_import,array('dispatch',false)),false));
;
?>
<?php 