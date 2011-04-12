<?php require_once('AspisMain.php'); ?><?php
header((deconcat(concat2(concat1('Content-Type: ',feed_content_type(array('rss-http',false))),'; charset='),get_option(array('blog_charset',false)))),true);
$more = array(1,false);
echo AspisCheckPrint(concat2(concat2(concat1('<?xml version="1.0" encoding="',get_option(array('blog_charset',false))),'"?'),'>'));
;
?>
<?php the_generator(array('comment',false));
;
?>
<rss version="0.92">
<channel>
	<title><?php bloginfo_rss(array('name',false));
wp_title_rss();
;
?></title>
	<link><?php bloginfo_rss(array('url',false));
;
?></link>
	<description><?php bloginfo_rss(array('description',false));
;
?></description>
	<lastBuildDate><?php echo AspisCheckPrint(mysql2date(array('D, d M Y H:i:s +0000',false),get_lastpostmodified(array('GMT',false)),array(false,false)));
;
?></lastBuildDate>
	<docs>http://backend.userland.com/rss092</docs>
	<language><?php echo AspisCheckPrint(get_option(array('rss_language',false)));
;
?></language>
	<?php do_action(array('rss_head',false));
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
		<description><![CDATA[<?php the_excerpt_rss();
;
?>]]></description>
		<link><?php the_permalink_rss();
;
?></link>
		<?php do_action(array('rss_item',false));
;
?>
	</item>
<?php };
?>
</channel>
</rss>
<?php 