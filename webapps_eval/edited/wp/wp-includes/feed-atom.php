<?php require_once('AspisMain.php'); ?><?php
header((deconcat(concat2(concat1('Content-Type: ',feed_content_type(array('atom',false))),'; charset='),get_option(array('blog_charset',false)))),true);
$more = array(1,false);
echo AspisCheckPrint(concat2(concat2(concat1('<?xml version="1.0" encoding="',get_option(array('blog_charset',false))),'"?'),'>'));
;
?>
<feed
  xmlns="http://www.w3.org/2005/Atom"
  xmlns:thr="http://purl.org/syndication/thread/1.0"
  xml:lang="<?php echo AspisCheckPrint(get_option(array('rss_language',false)));
;
?>"
  xml:base="<?php bloginfo_rss(array('home',false));
;
?>/wp-atom.php"
  <?php do_action(array('atom_ns',false));
;
?>
 >
	<title type="text"><?php bloginfo_rss(array('name',false));
wp_title_rss();
;
?></title>
	<subtitle type="text"><?php bloginfo_rss(array("description",false));
;
?></subtitle>

	<updated><?php echo AspisCheckPrint(mysql2date(array('Y-m-d\TH:i:s\Z',false),get_lastpostmodified(array('GMT',false)),array(false,false)));
;
?></updated>
	<?php the_generator(array('atom',false));
;
?>

	<link rel="alternate" type="text/html" href="<?php bloginfo_rss(array('home',false));
;
?>" />
	<id><?php bloginfo(array('atom_url',false));
;
?></id>
	<link rel="self" type="application/atom+xml" href="<?php self_link();
;
?>" />

	<?php do_action(array('atom_head',false));
;
?>
	<?php while ( deAspis(have_posts()) )
{the_post();
;
?>
	<entry>
		<author>
			<name><?php the_author();
;
?></name>
			<?php $author_url = get_the_author_meta(array('url',false));
if ( (!((empty($author_url) || Aspis_empty( $author_url)))))
 {;
?>
			<uri><?php the_author_meta(array('url',false));
;
?></uri>
			<?php };
?>
		</author>
		<title type="<?php html_type_rss();
;
?>"><![CDATA[<?php the_title_rss();
;
?>]]></title>
		<link rel="alternate" type="text/html" href="<?php the_permalink_rss();
;
?>" />
		<id><?php the_guid();
;
?></id>
		<updated><?php echo AspisCheckPrint(get_post_modified_time(array('Y-m-d\TH:i:s\Z',false),array(true,false)));
;
?></updated>
		<published><?php echo AspisCheckPrint(get_post_time(array('Y-m-d\TH:i:s\Z',false),array(true,false)));
;
?></published>
		<?php the_category_rss(array('atom',false));
;
?>
		<summary type="<?php html_type_rss();
;
?>"><![CDATA[<?php the_excerpt_rss();
;
?>]]></summary>
<?php if ( (denot_boolean(get_option(array('rss_use_excerpt',false)))))
 {;
?>
		<content type="<?php html_type_rss();
;
?>" xml:base="<?php the_permalink_rss();
;
?>"><![CDATA[<?php the_content_feed(array('atom',false));
;
?>]]></content>
<?php };
?>
<?php atom_enclosure();
;
?>
<?php do_action(array('atom_entry',false));
;
?>
		<link rel="replies" type="text/html" href="<?php the_permalink_rss();
;
?>#comments" thr:count="<?php echo AspisCheckPrint(get_comments_number());
;
?>"/>
		<link rel="replies" type="application/atom+xml" href="<?php echo AspisCheckPrint(get_post_comments_feed_link(array(0,false),array('atom',false)));
;
?>" thr:count="<?php echo AspisCheckPrint(get_comments_number());
;
?>"/>
		<thr:total><?php echo AspisCheckPrint(get_comments_number());
;
?></thr:total>
	</entry>
	<?php };
?>
</feed>
<?php 