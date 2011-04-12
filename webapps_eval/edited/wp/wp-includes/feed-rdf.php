<?php require_once('AspisMain.php'); ?><?php
header((deconcat(concat2(concat1('Content-Type: ',feed_content_type(array('rdf',false))),'; charset='),get_option(array('blog_charset',false)))),true);
$more = array(1,false);
echo AspisCheckPrint(concat2(concat2(concat1('<?xml version="1.0" encoding="',get_option(array('blog_charset',false))),'"?'),'>'));
;
?>
<rdf:RDF
	xmlns="http://purl.org/rss/1.0/"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:admin="http://webns.net/mvcb/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	<?php do_action(array('rdf_ns',false));
;
?>
>
<channel rdf:about="<?php bloginfo_rss(array("url",false));
;
?>">
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
	<dc:date><?php echo AspisCheckPrint(mysql2date(array('Y-m-d\TH:i:s\Z',false),get_lastpostmodified(array('GMT',false)),array(false,false)));
;
?></dc:date>
	<?php the_generator(array('rdf',false));
;
?>
	<sy:updatePeriod><?php echo AspisCheckPrint(apply_filters(array('rss_update_period',false),array('hourly',false)));
;
?></sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<sy:updateBase>2000-01-01T12:00+00:00</sy:updateBase>
	<?php do_action(array('rdf_header',false));
;
?>
	<items>
		<rdf:Seq>
		<?php while ( deAspis(have_posts()) )
{the_post();
;
?>
			<rdf:li rdf:resource="<?php the_permalink_rss();
;
?>"/>
		<?php };
?>
		</rdf:Seq>
	</items>
</channel>
<?php rewind_posts();
while ( deAspis(have_posts()) )
{the_post();
;
?>
<item rdf:about="<?php the_permalink_rss();
;
?>">
	<title><?php the_title_rss();
;
?></title>
	<link><?php the_permalink_rss();
;
?></link>
	 <dc:date><?php echo AspisCheckPrint(mysql2date(array('Y-m-d\TH:i:s\Z',false),$post[0]->post_date_gmt,array(false,false)));
;
?></dc:date>
	<dc:creator><?php the_author();
;
?></dc:creator>
	<?php the_category_rss(array('rdf',false));
;
?>
<?php if ( deAspis(get_option(array('rss_use_excerpt',false))))
 {;
?>
	<description><?php the_excerpt_rss();
;
?></description>
<?php }else 
{;
?>
	<description><?php the_excerpt_rss();
;
?></description>
	<content:encoded><![CDATA[<?php the_content_feed(array('rdf',false));
;
?>]]></content:encoded>
<?php };
?>
	<?php do_action(array('rdf_item',false));
;
?>
</item>
<?php };
?>
</rdf:RDF>
<?php 