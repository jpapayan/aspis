<?php require_once('AspisMain.php'); ?><?php
function get_bloginfo_rss ( $show = array('',false) ) {
$info = Aspis_strip_tags(get_bloginfo($show));
return apply_filters(array('get_bloginfo_rss',false),convert_chars($info),$show);
 }
function bloginfo_rss ( $show = array('',false) ) {
echo AspisCheckPrint(apply_filters(array('bloginfo_rss',false),get_bloginfo_rss($show),$show));
 }
function get_default_feed (  ) {
return apply_filters(array('default_feed',false),array('rss2',false));
 }
function get_wp_title_rss ( $sep = array('&#187;',false) ) {
$title = wp_title($sep,array(false,false));
if ( deAspis(is_wp_error($title)))
 return $title[0]->get_error_message();
$title = apply_filters(array('get_wp_title_rss',false),$title);
return $title;
 }
function wp_title_rss ( $sep = array('&#187;',false) ) {
echo AspisCheckPrint(apply_filters(array('wp_title_rss',false),get_wp_title_rss($sep)));
 }
function get_the_title_rss (  ) {
$title = get_the_title();
$title = apply_filters(array('the_title_rss',false),$title);
return $title;
 }
function the_title_rss (  ) {
echo AspisCheckPrint(get_the_title_rss());
 }
function get_the_content_feed ( $feed_type = array(null,false) ) {
if ( (denot_boolean($feed_type)))
 $feed_type = get_default_feed();
$content = apply_filters(array('the_content',false),get_the_content());
$content = Aspis_str_replace(array(']]>',false),array(']]&gt;',false),$content);
return apply_filters(array('the_content_feed',false),$content,$feed_type);
 }
function the_content_feed ( $feed_type = array(null,false) ) {
echo AspisCheckPrint(get_the_content_feed());
 }
function the_excerpt_rss (  ) {
$output = get_the_excerpt();
echo AspisCheckPrint(apply_filters(array('the_excerpt_rss',false),$output));
 }
function the_permalink_rss (  ) {
echo AspisCheckPrint(apply_filters(array('the_permalink_rss',false),get_permalink()));
 }
function comment_guid ( $comment_id = array(null,false) ) {
echo AspisCheckPrint(get_comment_guid($comment_id));
 }
function get_comment_guid ( $comment_id = array(null,false) ) {
$comment = get_comment($comment_id);
if ( (!(is_object($comment[0]))))
 return array(false,false);
return concat(concat2(get_the_guid($comment[0]->comment_post_ID),'#comment-'),$comment[0]->comment_ID);
 }
function comment_link (  ) {
echo AspisCheckPrint(esc_url(get_comment_link()));
 }
function get_comment_author_rss (  ) {
return apply_filters(array('comment_author_rss',false),get_comment_author());
 }
function comment_author_rss (  ) {
echo AspisCheckPrint(get_comment_author_rss());
 }
function comment_text_rss (  ) {
$comment_text = get_comment_text();
$comment_text = apply_filters(array('comment_text_rss',false),$comment_text);
echo AspisCheckPrint($comment_text);
 }
function get_the_category_rss ( $type = array(null,false) ) {
if ( ((empty($type) || Aspis_empty( $type))))
 $type = get_default_feed();
$categories = get_the_category();
$tags = get_the_tags();
$the_list = array('',false);
$cat_names = array(array(),false);
$filter = array('rss',false);
if ( (('atom') == $type[0]))
 $filter = array('raw',false);
if ( (!((empty($categories) || Aspis_empty( $categories)))))
 foreach ( deAspis(array_cast($categories)) as $category  )
{arrayAssignAdd($cat_names[0][],addTaint(sanitize_term_field(array('name',false),$category[0]->name,$category[0]->term_id,array('category',false),$filter)));
}if ( (!((empty($tags) || Aspis_empty( $tags)))))
 foreach ( deAspis(array_cast($tags)) as $tag  )
{arrayAssignAdd($cat_names[0][],addTaint(sanitize_term_field(array('name',false),$tag[0]->name,$tag[0]->term_id,array('post_tag',false),$filter)));
}$cat_names = attAspisRC(array_unique(deAspisRC($cat_names)));
foreach ( $cat_names[0] as $cat_name  )
{if ( (('rdf') == $type[0]))
 $the_list = concat($the_list,concat2(concat1("\t\t<dc:subject><![CDATA[",$cat_name),"]]></dc:subject>\n"));
elseif ( (('atom') == $type[0]))
 $the_list = concat($the_list,Aspis_sprintf(array('<category scheme="%1$s" term="%2$s" />',false),esc_attr(apply_filters(array('get_bloginfo_rss',false),get_bloginfo(array('url',false)))),esc_attr($cat_name)));
else 
{$the_list = concat($the_list,concat2(concat1("\t\t<category><![CDATA[",@Aspis_html_entity_decode($cat_name,array(ENT_COMPAT,false),get_option(array('blog_charset',false)))),"]]></category>\n"));
}}return apply_filters(array('the_category_rss',false),$the_list,$type);
 }
function the_category_rss ( $type = array(null,false) ) {
echo AspisCheckPrint(get_the_category_rss($type));
 }
function html_type_rss (  ) {
$type = get_bloginfo(array('html_type',false));
if ( (strpos($type[0],'xhtml') !== false))
 $type = array('xhtml',false);
else 
{$type = array('html',false);
}echo AspisCheckPrint($type);
 }
function rss_enclosure (  ) {
if ( deAspis(post_password_required()))
 return ;
foreach ( deAspis(array_cast(get_post_custom())) as $key =>$val )
{restoreTaint($key,$val);
{if ( ($key[0] == ('enclosure')))
 {foreach ( deAspis(array_cast($val)) as $enc  )
{$enclosure = Aspis_explode(array("\n",false),$enc);
$t = Aspis_preg_split(array('/[ \t]/',false),Aspis_trim(attachAspis($enclosure,(2))));
$type = attachAspis($t,(0));
echo AspisCheckPrint(apply_filters(array('rss_enclosure',false),concat2(concat2(concat(concat2(concat(concat2(concat1('<enclosure url="',Aspis_trim(Aspis_htmlspecialchars(attachAspis($enclosure,(0))))),'" length="'),Aspis_trim(attachAspis($enclosure,(1)))),'" type="'),$type),'" />'),"\n")));
}}}} }
function atom_enclosure (  ) {
if ( deAspis(post_password_required()))
 return ;
foreach ( deAspis(array_cast(get_post_custom())) as $key =>$val )
{restoreTaint($key,$val);
{if ( ($key[0] == ('enclosure')))
 {foreach ( deAspis(array_cast($val)) as $enc  )
{$enclosure = Aspis_split(array("\n",false),$enc);
echo AspisCheckPrint(apply_filters(array('atom_enclosure',false),concat2(concat2(concat(concat2(concat(concat2(concat1('<link href="',Aspis_trim(Aspis_htmlspecialchars(attachAspis($enclosure,(0))))),'" rel="enclosure" length="'),Aspis_trim(attachAspis($enclosure,(1)))),'" type="'),Aspis_trim(attachAspis($enclosure,(2)))),'" />'),"\n")));
}}}} }
function prep_atom_text_construct ( $data ) {
if ( ((strpos($data[0],'<') === false) && (strpos($data[0],'&') === false)))
 {return array(array(array('text',false),$data),false);
}$parser = array(xml_parser_create(),false);
xml_parse($parser[0],(deconcat2(concat1('<div>',$data),'</div>')),true);
$code = array(xml_get_error_code(deAspisRC($parser)),false);
xml_parser_free(deAspisRC($parser));
if ( (denot_boolean($code)))
 {if ( (strpos($data[0],'<') === false))
 {return array(array(array('text',false),$data),false);
}else 
{{$data = concat2(concat1("<div xmlns='http://www.w3.org/1999/xhtml'>",$data),"</div>");
return array(array(array('xhtml',false),$data),false);
}}}if ( (strpos($data[0],']]>') == false))
 {return array(array(array('html',false),concat2(concat1("<![CDATA[",$data),"]]>")),false);
}else 
{{return array(array(array('html',false),Aspis_htmlspecialchars($data)),false);
}} }
function self_link (  ) {
$host = @Aspis_parse_url(get_option(array('home',false)));
$host = $host[0]['host'];
echo AspisCheckPrint(esc_url(concat(concat(concat2(concat1('http',((((isset($_SERVER[0][('https')]) && Aspis_isset( $_SERVER [0][('https')]))) && (deAspis($_SERVER[0]['https']) == ('on'))) ? array('s',false) : array('',false))),'://'),$host),Aspis_stripslashes($_SERVER[0]['REQUEST_URI']))));
 }
function feed_content_type ( $type = array('',false) ) {
if ( ((empty($type) || Aspis_empty( $type))))
 $type = get_default_feed();
$types = array(array('rss' => array('application/rss+xml',false,false),'rss2' => array('application/rss+xml',false,false),'rss-http' => array('text/xml',false,false),'atom' => array('application/atom+xml',false,false),'rdf' => array('application/rdf+xml',false,false)),false);
$content_type = (!((empty($types[0][$type[0]]) || Aspis_empty( $types [0][$type[0]])))) ? attachAspis($types,$type[0]) : array('application/octet-stream',false);
return apply_filters(array('feed_content_type',false),$content_type,$type);
 }
function fetch_feed ( $url ) {
require_once (deconcat2(concat12(ABSPATH,WPINC),'/class-feed.php'));
$feed = array(new SimplePie(),false);
$feed[0]->set_feed_url($url);
$feed[0]->set_cache_class(array('WP_Feed_Cache',false));
$feed[0]->set_file_class(array('WP_SimplePie_File',false));
$feed[0]->set_cache_duration(apply_filters(array('wp_feed_cache_transient_lifetime',false),array(43200,false)));
$feed[0]->init();
$feed[0]->handle_content_type();
if ( deAspis($feed[0]->error()))
 return array(new WP_Error(array('simplepie-error',false),$feed[0]->error()),false);
return $feed;
 }
