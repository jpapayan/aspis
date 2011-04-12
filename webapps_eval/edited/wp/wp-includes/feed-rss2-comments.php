<?php require_once('AspisMain.php'); ?><?php
header((deconcat(concat2(concat1('Content-Type: ',feed_content_type(array('rss-http',false))),'; charset='),get_option(array('blog_charset',false)))),true);
echo AspisCheckPrint(concat2(concat2(concat1('<?xml version="1.0" encoding="',get_option(array('blog_charset',false))),'"?'),'>'));
;
?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	<?php do_action(array('rss2_ns',false));
do_action(array('rss2_comments_ns',false));
;
?>
	>
<channel>
	<title><?php if ( deAspis(is_singular()))
 printf(deAspis(ent2ncr(__(array('Comments on: %s',false)))),deAspisRC(get_the_title_rss()));
elseif ( deAspis(is_search()))
 printf(deAspis(ent2ncr(__(array('Comments for %s searching on %s',false)))),deAspisRC(get_bloginfo_rss(array('name',false))),deAspisRC(esc_attr($wp_query[0]->query_vars[0][('s')])));
else 
{printf(deAspis(ent2ncr(__(array('Comments for %s',false)))),(deconcat(get_bloginfo_rss(array('name',false)),get_wp_title_rss())));
};
?></title>
	<atom:link href="<?php self_link();
;
?>" rel="self" type="application/rss+xml" />
	<link><?php deAspis((is_single())) ? the_permalink_rss() : bloginfo_rss(array("url",false));
;
?></link>
	<description><?php bloginfo_rss(array("description",false));
;
?></description>
	<lastBuildDate><?php echo AspisCheckPrint(mysql2date(array('r',false),get_lastcommentmodified(array('GMT',false))));
;
?></lastBuildDate>
	<?php the_generator(array('rss2',false));
;
?>
	<sy:updatePeriod><?php echo AspisCheckPrint(apply_filters(array('rss_update_period',false),array('hourly',false)));
;
?></sy:updatePeriod>
	<sy:updateFrequency><?php echo AspisCheckPrint(apply_filters(array('rss_update_frequency',false),array('1',false)));
;
?></sy:updateFrequency>
	<?php do_action(array('commentsrss2_head',false));
;
?>
<?php if ( deAspis(have_comments()))
 {while ( deAspis(have_comments()) )
{the_comment();
$comment_post = get_post($comment[0]->comment_post_ID);
get_post_custom($comment_post[0]->ID);
;
?>
	<item>
		<title><?php if ( (denot_boolean(is_singular())))
 {$title = get_the_title($comment_post[0]->ID);
$title = apply_filters(array('the_title_rss',false),$title);
printf(deAspis(ent2ncr(__(array('Comment on %1$s by %2$s',false)))),deAspisRC($title),deAspisRC(get_comment_author_rss()));
}else 
{{printf(deAspis(ent2ncr(__(array('By: %s',false)))),deAspisRC(get_comment_author_rss()));
}};
?></title>
		<link><?php comment_link();
;
?></link>
		<dc:creator><?php echo AspisCheckPrint(get_comment_author_rss());
;
?></dc:creator>
		<pubDate><?php echo AspisCheckPrint(mysql2date(array('D, d M Y H:i:s +0000',false),get_comment_time(array('Y-m-d H:i:s',false),array(true,false),array(false,false)),array(false,false)));
;
?></pubDate>
		<guid isPermaLink="false"><?php comment_guid();
;
?></guid>
<?php if ( deAspis(post_password_required($comment_post)))
 {;
?>
		<description><?php echo AspisCheckPrint(ent2ncr(__(array('Protected Comments: Please enter your password to view comments.',false))));
;
?></description>
		<content:encoded><![CDATA[<?php echo AspisCheckPrint(get_the_password_form());
;
?>]]></content:encoded>
<?php }else 
{;
?>
		<description><?php comment_text_rss();
;
?></description>
		<content:encoded><![CDATA[<?php comment_text();
;
?>]]></content:encoded>
<?php }do_action(array('commentrss2_item',false),$comment[0]->comment_ID,$comment_post[0]->ID);
;
?>
	</item>
<?php }};
?>
</channel>
</rss>
<?php 