<?php require_once('AspisMain.php'); ?><?php
define(('WXR_VERSION'),'1.0');
function export_wp ( $author = array('',false) ) {
global $wpdb,$post_ids,$post,$wp_taxonomies;
do_action(array('export_wp',false));
$filename = concat2(concat1('wordpress.',attAspis(date(('Y-m-d')))),'.xml');
header(('Content-Description: File Transfer'));
header((deconcat1("Content-Disposition: attachment; filename=",$filename)));
header((deconcat1('Content-Type: text/xml; charset=',get_option(array('blog_charset',false)))),true);
$where = array('',false);
if ( ($author[0] and ($author[0] != ('all'))))
 {$author_id = int_cast($author);
$where = $wpdb[0]->prepare(array(" WHERE post_author = %d ",false),$author_id);
}$post_ids = $wpdb[0]->get_col(concat2(concat(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," "),$where)," ORDER BY post_date_gmt ASC"));
$categories = array_cast(get_categories(array('get=all',false)));
$tags = array_cast(get_tags(array('get=all',false)));
$custom_taxonomies = $wp_taxonomies;
unset($custom_taxonomies[0][('category')]);
unset($custom_taxonomies[0][('post_tag')]);
unset($custom_taxonomies[0][('link_category')]);
$custom_taxonomies = attAspisRC(array_keys(deAspisRC($custom_taxonomies)));
$terms = array_cast(get_terms($custom_taxonomies,array('get=all',false)));
function wxr_missing_parents ( $categories ) {
if ( ((!(is_array($categories[0]))) || ((empty($categories) || Aspis_empty( $categories)))))
 return array(array(),false);
foreach ( $categories[0] as $category  )
arrayAssign($parents[0],deAspis(registerTaint($category[0]->term_id)),addTaint($category[0]->parent));
$parents = attAspisRC(array_unique(deAspisRC(Aspis_array_diff($parents,attAspisRC(array_keys(deAspisRC($parents)))))));
if ( deAspis($zero = Aspis_array_search(array('0',false),$parents)))
 unset($parents[0][$zero[0]]);
return $parents;
 }
while ( deAspis($parents = wxr_missing_parents($categories)) )
{$found_parents = get_categories(concat1("include=",Aspis_join(array(', ',false),$parents)));
if ( (is_array($found_parents[0]) && count($found_parents[0])))
 $categories = Aspis_array_merge($categories,$found_parents);
else 
{break ;
}}$pass = array(0,false);
$passes = array((1000) + count($categories[0]),false);
while ( (deAspis(($cat = Aspis_array_shift($categories))) && (deAspis(preincr($pass)) < $passes[0])) )
{if ( (($cat[0]->parent[0] == (0)) || ((isset($cats[0][$cat[0]->parent[0]]) && Aspis_isset( $cats [0][$cat[0] ->parent [0]])))))
 {arrayAssign($cats[0],deAspis(registerTaint($cat[0]->term_id)),addTaint($cat));
}else 
{{arrayAssignAdd($categories[0][],addTaint($cat));
}}}unset($categories);
function wxr_cdata ( $str ) {
if ( (deAspis(seems_utf8($str)) == false))
 $str = Aspis_utf8_encode($str);
$str = concat2(concat(concat1("<![CDATA[",$str),((deAspis(Aspis_substr($str,negate(array(1,false)))) == (']')) ? array(' ',false) : array('',false))),"]]>");
return $str;
 }
function wxr_site_url (  ) {
global $current_site;
if ( ((isset($current_site[0]->domain) && Aspis_isset( $current_site[0] ->domain ))))
 {return concat(concat1('http://',$current_site[0]->domain),$current_site[0]->path);
}else 
{{return get_bloginfo_rss(array('url',false));
}} }
function wxr_cat_name ( $c ) {
if ( ((empty($c[0]->name) || Aspis_empty( $c[0] ->name ))))
 return ;
echo AspisCheckPrint(concat2(concat1('<wp:cat_name>',wxr_cdata($c[0]->name)),'</wp:cat_name>'));
 }
function wxr_category_description ( $c ) {
if ( ((empty($c[0]->description) || Aspis_empty( $c[0] ->description ))))
 return ;
echo AspisCheckPrint(concat2(concat1('<wp:category_description>',wxr_cdata($c[0]->description)),'</wp:category_description>'));
 }
function wxr_tag_name ( $t ) {
if ( ((empty($t[0]->name) || Aspis_empty( $t[0] ->name ))))
 return ;
echo AspisCheckPrint(concat2(concat1('<wp:tag_name>',wxr_cdata($t[0]->name)),'</wp:tag_name>'));
 }
function wxr_tag_description ( $t ) {
if ( ((empty($t[0]->description) || Aspis_empty( $t[0] ->description ))))
 return ;
echo AspisCheckPrint(concat2(concat1('<wp:tag_description>',wxr_cdata($t[0]->description)),'</wp:tag_description>'));
 }
function wxr_term_name ( $t ) {
if ( ((empty($t[0]->name) || Aspis_empty( $t[0] ->name ))))
 return ;
echo AspisCheckPrint(concat2(concat1('<wp:term_name>',wxr_cdata($t[0]->name)),'</wp:term_name>'));
 }
function wxr_term_description ( $t ) {
if ( ((empty($t[0]->description) || Aspis_empty( $t[0] ->description ))))
 return ;
echo AspisCheckPrint(concat2(concat1('<wp:term_description>',wxr_cdata($t[0]->description)),'</wp:term_description>'));
 }
function wxr_post_taxonomy (  ) {
$categories = get_the_category();
$tags = get_the_tags();
$the_list = array('',false);
$filter = array('rss',false);
if ( (!((empty($categories) || Aspis_empty( $categories)))))
 foreach ( deAspis(array_cast($categories)) as $category  )
{$cat_name = sanitize_term_field(array('name',false),$category[0]->name,$category[0]->term_id,array('category',false),$filter);
$the_list = concat($the_list,concat2(concat1("\n\t\t<category><![CDATA[",$cat_name),"]]></category>\n"));
$the_list = concat($the_list,concat2(concat(concat2(concat1("\n\t\t<category domain=\"category\" nicename=\"",$category[0]->slug),"\"><![CDATA["),$cat_name),"]]></category>\n"));
}if ( (!((empty($tags) || Aspis_empty( $tags)))))
 foreach ( deAspis(array_cast($tags)) as $tag  )
{$tag_name = sanitize_term_field(array('name',false),$tag[0]->name,$tag[0]->term_id,array('post_tag',false),$filter);
$the_list = concat($the_list,concat2(concat1("\n\t\t<category domain=\"tag\"><![CDATA[",$tag_name),"]]></category>\n"));
$the_list = concat($the_list,concat2(concat(concat2(concat1("\n\t\t<category domain=\"tag\" nicename=\"",$tag[0]->slug),"\"><![CDATA["),$tag_name),"]]></category>\n"));
}echo AspisCheckPrint($the_list);
 }
echo AspisCheckPrint(concat2(concat2(concat1('<?xml version="1.0" encoding="',get_bloginfo(array('charset',false))),'"?'),">\n"));
;
?>
<!-- This is a WordPress eXtended RSS file generated by WordPress as an export of your blog. -->
<!-- It contains information about your blog's posts, comments, and categories. -->
<!-- You may use this file to transfer that content from one site to another. -->
<!-- This file is not intended to serve as a complete backup of your blog. -->

<!-- To import this information into a WordPress blog follow these steps. -->
<!-- 1. Log in to that blog as an administrator. -->
<!-- 2. Go to Tools: Import in the blog's admin panels (or Manage: Import in older versions of WordPress). -->
<!-- 3. Choose "WordPress" from the list. -->
<!-- 4. Upload this file using the form provided on that page. -->
<!-- 5. You will first be asked to map the authors in this export file to users -->
<!--    on the blog.  For each author, you may choose to map to an -->
<!--    existing user on the blog or to create a new user -->
<!-- 6. WordPress will then import each of the posts, comments, and categories -->
<!--    contained in this file into your blog -->

<?php the_generator(array('export',false));
;
?>
<rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/<?php echo AspisCheckPrint(array(WXR_VERSION,false));
;
?>/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/<?php echo AspisCheckPrint(array(WXR_VERSION,false));
;
?>/"
>

<channel>
	<title><?php bloginfo_rss(array('name',false));
;
?></title>
	<link><?php bloginfo_rss(array('url',false));
?></link>
	<description><?php bloginfo_rss(array("description",false));
?></description>
	<pubDate><?php echo AspisCheckPrint(mysql2date(array('D, d M Y H:i:s +0000',false),get_lastpostmodified(array('GMT',false)),array(false,false)));
;
?></pubDate>
	<generator>http://wordpress.org/?v=<?php bloginfo_rss(array('version',false));
;
?></generator>
	<language><?php echo AspisCheckPrint(get_option(array('rss_language',false)));
;
?></language>
	<wp:wxr_version><?php echo AspisCheckPrint(array(WXR_VERSION,false));
;
?></wp:wxr_version>
	<wp:base_site_url><?php echo AspisCheckPrint(wxr_site_url());
;
?></wp:base_site_url>
	<wp:base_blog_url><?php bloginfo_rss(array('url',false));
;
?></wp:base_blog_url>
<?php if ( $cats[0])
 {foreach ( $cats[0] as $c  )
{;
?>
	<wp:category><wp:category_nicename><?php echo AspisCheckPrint($c[0]->slug);
;
?></wp:category_nicename><wp:category_parent><?php echo AspisCheckPrint($c[0]->parent[0] ? $cats[0][$c[0]->parent[0]][0]->name : array('',false));
;
?></wp:category_parent><?php wxr_cat_name($c);
;
wxr_category_description($c);
;
?></wp:category>
<?php }};
?>
<?php if ( $tags[0])
 {foreach ( $tags[0] as $t  )
{;
?>
	<wp:tag><wp:tag_slug><?php echo AspisCheckPrint($t[0]->slug);
;
?></wp:tag_slug><?php wxr_tag_name($t);
;
wxr_tag_description($t);
;
?></wp:tag>
<?php }};
?>
<?php if ( $terms[0])
 {foreach ( $terms[0] as $t  )
{;
?>
	<wp:term><wp:term_taxonomy><?php echo AspisCheckPrint($t[0]->taxonomy);
;
?></wp:term_taxonomy><wp:term_slug><?php echo AspisCheckPrint($t[0]->slug);
;
?></wp:term_slug><wp:term_parent><?php echo AspisCheckPrint($t[0]->parent[0] ? $custom_taxonomies[0][$t[0]->parent[0]][0]->name : array('',false));
;
?></wp:term_parent><?php wxr_term_name($t);
;
wxr_term_description($t);
;
?></wp:term>
<?php }};
?>
	<?php do_action(array('rss2_head',false));
;
?>
	<?php if ( $post_ids[0])
 {global $wp_query;
$wp_query[0]->in_the_loop = array(true,false);
while ( deAspis($next_posts = Aspis_array_splice($post_ids,array(0,false),array(20,false))) )
{$where = concat2(concat1("WHERE ID IN (",Aspis_join(array(',',false),$next_posts)),")");
$posts = $wpdb[0]->get_results(concat2(concat(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," "),$where)," ORDER BY post_date_gmt ASC"));
foreach ( $posts[0] as $post  )
{if ( (('revision') == $post[0]->post_type[0]))
 continue ;
setup_postdata($post);
$is_sticky = array(0,false);
if ( deAspis(is_sticky($post[0]->ID)))
 $is_sticky = array(1,false);
;
?>
<item>
<title><?php echo AspisCheckPrint(apply_filters(array('the_title_rss',false),$post[0]->post_title));
;
?></title>
<link><?php the_permalink_rss();
?></link>
<pubDate><?php echo AspisCheckPrint(mysql2date(array('D, d M Y H:i:s +0000',false),get_post_time(array('Y-m-d H:i:s',false),array(true,false)),array(false,false)));
;
?></pubDate>
<dc:creator><?php echo AspisCheckPrint(wxr_cdata(get_the_author()));
;
?></dc:creator>
<?php wxr_post_taxonomy();
?>

<guid isPermaLink="false"><?php the_guid();
;
?></guid>
<description></description>
<content:encoded><?php echo AspisCheckPrint(wxr_cdata(apply_filters(array('the_content_export',false),$post[0]->post_content)));
;
?></content:encoded>
<excerpt:encoded><?php echo AspisCheckPrint(wxr_cdata(apply_filters(array('the_excerpt_export',false),$post[0]->post_excerpt)));
;
?></excerpt:encoded>
<wp:post_id><?php echo AspisCheckPrint($post[0]->ID);
;
?></wp:post_id>
<wp:post_date><?php echo AspisCheckPrint($post[0]->post_date);
;
?></wp:post_date>
<wp:post_date_gmt><?php echo AspisCheckPrint($post[0]->post_date_gmt);
;
?></wp:post_date_gmt>
<wp:comment_status><?php echo AspisCheckPrint($post[0]->comment_status);
;
?></wp:comment_status>
<wp:ping_status><?php echo AspisCheckPrint($post[0]->ping_status);
;
?></wp:ping_status>
<wp:post_name><?php echo AspisCheckPrint($post[0]->post_name);
;
?></wp:post_name>
<wp:status><?php echo AspisCheckPrint($post[0]->post_status);
;
?></wp:status>
<wp:post_parent><?php echo AspisCheckPrint($post[0]->post_parent);
;
?></wp:post_parent>
<wp:menu_order><?php echo AspisCheckPrint($post[0]->menu_order);
;
?></wp:menu_order>
<wp:post_type><?php echo AspisCheckPrint($post[0]->post_type);
;
?></wp:post_type>
<wp:post_password><?php echo AspisCheckPrint($post[0]->post_password);
;
?></wp:post_password>
<wp:is_sticky><?php echo AspisCheckPrint($is_sticky);
;
?></wp:is_sticky>
<?php if ( ($post[0]->post_type[0] == ('attachment')))
 {;
?>
<wp:attachment_url><?php echo AspisCheckPrint(wp_get_attachment_url($post[0]->ID));
;
?></wp:attachment_url>
<?php };
?>
<?php $postmeta = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->postmeta)," WHERE post_id = %d"),$post[0]->ID));
if ( $postmeta[0])
 {;
?>
<?php foreach ( $postmeta[0] as $meta  )
{;
?>
<wp:postmeta>
<wp:meta_key><?php echo AspisCheckPrint($meta[0]->meta_key);
;
?></wp:meta_key>
<wp:meta_value><?php echo AspisCheckPrint($meta[0]->meta_value);
;
?></wp:meta_value>
</wp:postmeta>
<?php };
?>
<?php };
?>
<?php $comments = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d"),$post[0]->ID));
if ( $comments[0])
 {foreach ( $comments[0] as $c  )
{;
?>
<wp:comment>
<wp:comment_id><?php echo AspisCheckPrint($c[0]->comment_ID);
;
?></wp:comment_id>
<wp:comment_author><?php echo AspisCheckPrint(wxr_cdata($c[0]->comment_author));
;
?></wp:comment_author>
<wp:comment_author_email><?php echo AspisCheckPrint($c[0]->comment_author_email);
;
?></wp:comment_author_email>
<wp:comment_author_url><?php echo AspisCheckPrint(esc_url_raw($c[0]->comment_author_url));
;
?></wp:comment_author_url>
<wp:comment_author_IP><?php echo AspisCheckPrint($c[0]->comment_author_IP);
;
?></wp:comment_author_IP>
<wp:comment_date><?php echo AspisCheckPrint($c[0]->comment_date);
;
?></wp:comment_date>
<wp:comment_date_gmt><?php echo AspisCheckPrint($c[0]->comment_date_gmt);
;
?></wp:comment_date_gmt>
<wp:comment_content><?php echo AspisCheckPrint(wxr_cdata($c[0]->comment_content));
?></wp:comment_content>
<wp:comment_approved><?php echo AspisCheckPrint($c[0]->comment_approved);
;
?></wp:comment_approved>
<wp:comment_type><?php echo AspisCheckPrint($c[0]->comment_type);
;
?></wp:comment_type>
<wp:comment_parent><?php echo AspisCheckPrint($c[0]->comment_parent);
;
?></wp:comment_parent>
<wp:comment_user_id><?php echo AspisCheckPrint($c[0]->user_id);
;
?></wp:comment_user_id>
</wp:comment>
<?php }};
?>
	</item>
<?php }}};
?>
</channel>
</rss>
<?php  }
;
?>
<?php 