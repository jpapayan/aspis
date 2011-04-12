<?php require_once('AspisMain.php'); ?><?php
function get_bloginfo_rss ( $show = '' ) {
$info = strip_tags(get_bloginfo($show));
{$AspisRetTemp = apply_filters('get_bloginfo_rss',convert_chars($info),$show);
return $AspisRetTemp;
} }
function bloginfo_rss ( $show = '' ) {
echo apply_filters('bloginfo_rss',get_bloginfo_rss($show),$show);
 }
function get_default_feed (  ) {
{$AspisRetTemp = apply_filters('default_feed','rss2');
return $AspisRetTemp;
} }
function get_wp_title_rss ( $sep = '&#187;' ) {
$title = wp_title($sep,false);
if ( is_wp_error($title))
 {$AspisRetTemp = $title->get_error_message();
return $AspisRetTemp;
}$title = apply_filters('get_wp_title_rss',$title);
{$AspisRetTemp = $title;
return $AspisRetTemp;
} }
function wp_title_rss ( $sep = '&#187;' ) {
echo apply_filters('wp_title_rss',get_wp_title_rss($sep));
 }
function get_the_title_rss (  ) {
$title = get_the_title();
$title = apply_filters('the_title_rss',$title);
{$AspisRetTemp = $title;
return $AspisRetTemp;
} }
function the_title_rss (  ) {
echo get_the_title_rss();
 }
function get_the_content_feed ( $feed_type = null ) {
if ( !$feed_type)
 $feed_type = get_default_feed();
$content = apply_filters('the_content',get_the_content());
$content = str_replace(']]>',']]&gt;',$content);
{$AspisRetTemp = apply_filters('the_content_feed',$content,$feed_type);
return $AspisRetTemp;
} }
function the_content_feed ( $feed_type = null ) {
echo get_the_content_feed();
 }
function the_excerpt_rss (  ) {
$output = get_the_excerpt();
echo apply_filters('the_excerpt_rss',$output);
 }
function the_permalink_rss (  ) {
echo apply_filters('the_permalink_rss',get_permalink());
 }
function comment_guid ( $comment_id = null ) {
echo get_comment_guid($comment_id);
 }
function get_comment_guid ( $comment_id = null ) {
$comment = get_comment($comment_id);
if ( !is_object($comment))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = get_the_guid($comment->comment_post_ID) . '#comment-' . $comment->comment_ID;
return $AspisRetTemp;
} }
function comment_link (  ) {
echo esc_url(get_comment_link());
 }
function get_comment_author_rss (  ) {
{$AspisRetTemp = apply_filters('comment_author_rss',get_comment_author());
return $AspisRetTemp;
} }
function comment_author_rss (  ) {
echo get_comment_author_rss();
 }
function comment_text_rss (  ) {
$comment_text = get_comment_text();
$comment_text = apply_filters('comment_text_rss',$comment_text);
echo $comment_text;
 }
function get_the_category_rss ( $type = null ) {
if ( empty($type))
 $type = get_default_feed();
$categories = get_the_category();
$tags = get_the_tags();
$the_list = '';
$cat_names = array();
$filter = 'rss';
if ( 'atom' == $type)
 $filter = 'raw';
if ( !empty($categories))
 foreach ( (array)$categories as $category  )
{$cat_names[] = sanitize_term_field('name',$category->name,$category->term_id,'category',$filter);
}if ( !empty($tags))
 foreach ( (array)$tags as $tag  )
{$cat_names[] = sanitize_term_field('name',$tag->name,$tag->term_id,'post_tag',$filter);
}$cat_names = array_unique($cat_names);
foreach ( $cat_names as $cat_name  )
{if ( 'rdf' == $type)
 $the_list .= "\t\t<dc:subject><![CDATA[$cat_name]]></dc:subject>\n";
elseif ( 'atom' == $type)
 $the_list .= sprintf('<category scheme="%1$s" term="%2$s" />',esc_attr(apply_filters('get_bloginfo_rss',get_bloginfo('url'))),esc_attr($cat_name));
else 
{$the_list .= "\t\t<category><![CDATA[" . @html_entity_decode($cat_name,ENT_COMPAT,get_option('blog_charset')) . "]]></category>\n";
}}{$AspisRetTemp = apply_filters('the_category_rss',$the_list,$type);
return $AspisRetTemp;
} }
function the_category_rss ( $type = null ) {
echo get_the_category_rss($type);
 }
function html_type_rss (  ) {
$type = get_bloginfo('html_type');
if ( strpos($type,'xhtml') !== false)
 $type = 'xhtml';
else 
{$type = 'html';
}echo $type;
 }
function rss_enclosure (  ) {
if ( post_password_required())
 {return ;
}foreach ( (array)get_post_custom() as $key =>$val )
{if ( $key == 'enclosure')
 {foreach ( (array)$val as $enc  )
{$enclosure = explode("\n",$enc);
$t = preg_split('/[ \t]/',trim($enclosure[2]));
$type = $t[0];
echo apply_filters('rss_enclosure','<enclosure url="' . trim(htmlspecialchars($enclosure[0])) . '" length="' . trim($enclosure[1]) . '" type="' . $type . '" />' . "\n");
}}} }
function atom_enclosure (  ) {
if ( post_password_required())
 {return ;
}foreach ( (array)get_post_custom() as $key =>$val )
{if ( $key == 'enclosure')
 {foreach ( (array)$val as $enc  )
{$enclosure = split("\n",$enc);
echo apply_filters('atom_enclosure','<link href="' . trim(htmlspecialchars($enclosure[0])) . '" rel="enclosure" length="' . trim($enclosure[1]) . '" type="' . trim($enclosure[2]) . '" />' . "\n");
}}} }
function prep_atom_text_construct ( $data ) {
if ( strpos($data,'<') === false && strpos($data,'&') === false)
 {{$AspisRetTemp = array('text',$data);
return $AspisRetTemp;
}}$parser = xml_parser_create();
xml_parse($parser,'<div>' . $data . '</div>',true);
$code = xml_get_error_code($parser);
xml_parser_free($parser);
if ( !$code)
 {if ( strpos($data,'<') === false)
 {{$AspisRetTemp = array('text',$data);
return $AspisRetTemp;
}}else 
{{$data = "<div xmlns='http://www.w3.org/1999/xhtml'>$data</div>";
{$AspisRetTemp = array('xhtml',$data);
return $AspisRetTemp;
}}}}if ( strpos($data,']]>') == false)
 {{$AspisRetTemp = array('html',"<![CDATA[$data]]>");
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = array('html',htmlspecialchars($data));
return $AspisRetTemp;
}}} }
function self_link (  ) {
$host = @parse_url(get_option('home'));
$host = $host['host'];
echo esc_url('http' . (((isset($_SERVER[0]['https']) && Aspis_isset($_SERVER[0]['https'])) && deAspisWarningRC($_SERVER[0]['https']) == 'on') ? 's' : '') . '://' . $host . stripslashes(deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
 }
function feed_content_type ( $type = '' ) {
if ( empty($type))
 $type = get_default_feed();
$types = array('rss' => 'application/rss+xml','rss2' => 'application/rss+xml','rss-http' => 'text/xml','atom' => 'application/atom+xml','rdf' => 'application/rdf+xml');
$content_type = (!empty($types[$type])) ? $types[$type] : 'application/octet-stream';
{$AspisRetTemp = apply_filters('feed_content_type',$content_type,$type);
return $AspisRetTemp;
} }
function fetch_feed ( $url ) {
require_once (ABSPATH . WPINC . '/class-feed.php');
$feed = new SimplePie();
$feed->set_feed_url($url);
$feed->set_cache_class('WP_Feed_Cache');
$feed->set_file_class('WP_SimplePie_File');
$feed->set_cache_duration(apply_filters('wp_feed_cache_transient_lifetime',43200));
$feed->init();
$feed->handle_content_type();
if ( $feed->error())
 {$AspisRetTemp = new WP_Error('simplepie-error',$feed->error());
return $AspisRetTemp;
}{$AspisRetTemp = $feed;
return $AspisRetTemp;
} }
