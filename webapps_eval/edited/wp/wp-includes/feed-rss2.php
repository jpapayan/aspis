<?php require_once('AspisMain.php'); ?><?php
header((deconcat(concat2(concat1('Content-Type: ',feed_content_type(array('rss-http',false))),'; charset='),get_option(array('blog_charset',false)))),true);
$more = array(1,false);
echo AspisCheckPrint(concat2(concat2(concat1('<?xml version="1.0" encoding="',get_option(array('blog_charset',false))),'"?'),'>'));
;
?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	<?php do_action(array('rss2_ns',false));
;
?>
>

<channel>
	<title><?php bloginfo_rss(array('name',false));
wp_title_rss();
;
?></title>
	<atom:link href="<?php self_link();
;
?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss(array('url',false));
;
?></link>
	<description><?php bloginfo_rss(array("description",false));
;
?></description>
	<lastBuildDate><?php echo AspisCheckPrint(mysql2date(array('D, d M Y H:i:s +0000',false),get_lastpostmodified(array('GMT',false)),array(false,false)));
;
?></lastBuildDate>
	<?php the_generator(array('rss2',false));
;
?>
	<language><?php echo AspisCheckPrint(get_option(array('rss_language',false)));
;
?></language>
	<sy:updatePeriod><?php echo AspisCheckPrint(apply_filters(array('rss_update_period',false),array('hourly',false)));
;
?></sy:updatePeriod>
	<sy:updateFrequency><?php echo AspisCheckPrint(apply_filters(array('rss_update_frequency',false),array('1',false)));
;
?></sy:updateFrequency>
	<?php do_action(array('rss2_head',false));
;
?>
	<?php while ( deAspis(have_posts()) )
{the_post();
;
?>
	<item>
		<title><?php the_title_rss();
;
?></title>
		<link><?php the_permalink_rss();
;
?></link>
		<comments><?php comments_link();
;
?></comments>
		<pubDate><?php echo AspisCheckPrint(mysql2date(array('D, d M Y H:i:s +0000',false),get_post_time(array('Y-m-d H:i:s',false),array(true,false)),array(false,false)));
;
?></pubDate>
		<dc:creator><?php the_author();
;
?></dc:creator>
		<?php the_category_rss();
;
?>

		<guid isPermaLink="false"><?php the_guid();
;
?></guid>
<?php if ( deAspis(get_option(array('rss_use_excerpt',false))))
 {;
?>
		<description><![CDATA[<?php the_excerpt_rss();
;
?>]]></description>
<?php }else 
{;
?>
		<description><![CDATA[<?php the_excerpt_rss();
;
?>]]></description>
	<?php if ( (strlen($post[0]->post_content[0]) > (0)))
 {;
?>
		<content:encoded><![CDATA[<?php the_content_feed(array('rss2',false));
;
?>]]></content:encoded>
	<?php }else 
{;
?>
		<content:encoded><![CDATA[<?php the_excerpt_rss();
;
?>]]></content:encoded>
	<?php };
?>
<?php };
?>
		<wfw:commentRss><?php echo AspisCheckPrint(get_post_comments_feed_link(array(null,false),array('rss2',false)));
;
?></wfw:commentRss>
		<slash:comments><?php echo AspisCheckPrint(get_comments_number());
;
?></slash:comments>
<?php rss_enclosure();
;
?>
	<?php do_action(array('rss2_item',false));
;
?>
	</item>
	<?php };
?>
</channel>
</rss>
<?php 