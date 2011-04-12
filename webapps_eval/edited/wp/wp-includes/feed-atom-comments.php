<?php require_once('AspisMain.php'); ?><?php
header((deconcat(concat2(concat1('Content-Type: ',feed_content_type(array('atom',false))),'; charset='),get_option(array('blog_charset',false)))),true);
echo AspisCheckPrint(concat2(concat2(concat1('<?xml version="1.0" encoding="',get_option(array('blog_charset',false))),'" ?'),'>'));
;
?>
<feed
	xmlns="http://www.w3.org/2005/Atom"
	xml:lang="<?php echo AspisCheckPrint(get_option(array('rss_language',false)));
;
?>"
	xmlns:thr="http://purl.org/syndication/thread/1.0"
	<?php do_action(array('atom_ns',false));
do_action(array('atom_comments_ns',false));
;
?>
>
	<title type="text"><?php if ( deAspis(is_singular()))
 printf(deAspis(ent2ncr(__(array('Comments on: %s',false)))),deAspisRC(get_the_title_rss()));
elseif ( deAspis(is_search()))
 printf(deAspis(ent2ncr(__(array('Comments for %1$s searching on %2$s',false)))),deAspisRC(get_bloginfo_rss(array('name',false))),deAspisRC(esc_attr(get_search_query())));
else 
{printf(deAspis(ent2ncr(__(array('Comments for %s',false)))),(deconcat(get_bloginfo_rss(array('name',false)),get_wp_title_rss())));
};
?></title>
	<subtitle type="text"><?php bloginfo_rss(array('description',false));
;
?></subtitle>

	<updated><?php echo AspisCheckPrint(mysql2date(array('Y-m-d\TH:i:s\Z',false),get_lastcommentmodified(array('GMT',false)),array(false,false)));
;
?></updated>
	<?php the_generator(array('atom',false));
;
?>

<?php if ( deAspis(is_singular()))
 {;
?>
	<link rel="alternate" type="<?php bloginfo_rss(array('html_type',false));
;
?>" href="<?php echo AspisCheckPrint(get_comments_link());
;
?>" />
	<link rel="self" type="application/atom+xml" href="<?php echo AspisCheckPrint(get_post_comments_feed_link(array('',false),array('atom',false)));
;
?>" />
	<id><?php echo AspisCheckPrint(get_post_comments_feed_link(array('',false),array('atom',false)));
;
?></id>
<?php }elseif ( deAspis(is_search()))
 {;
?>
	<link rel="alternate" type="<?php bloginfo_rss(array('html_type',false));
;
?>" href="<?php echo AspisCheckPrint(concat(concat2(get_option(array('home',false)),'?s='),esc_attr(get_search_query())));
;
?>" />
	<link rel="self" type="application/atom+xml" href="<?php echo AspisCheckPrint(get_search_comments_feed_link(array('',false),array('atom',false)));
;
?>" />
	<id><?php echo AspisCheckPrint(get_search_comments_feed_link(array('',false),array('atom',false)));
;
?></id>
<?php }else 
{{;
?>
	<link rel="alternate" type="<?php bloginfo_rss(array('html_type',false));
;
?>" href="<?php bloginfo_rss(array('home',false));
;
?>" />
	<link rel="self" type="application/atom+xml" href="<?php bloginfo_rss(array('comments_atom_url',false));
;
?>" />
	<id><?php bloginfo_rss(array('comments_atom_url',false));
;
?></id>
<?php }};
?>
<?php do_action(array('comments_atom_head',false));
;
?>
<?php if ( deAspis(have_comments()))
 {while ( deAspis(have_comments()) )
{the_comment();
$comment_post = get_post($comment[0]->comment_post_ID);
get_post_custom($comment_post[0]->ID);
;
?>
	<entry>
		<title><?php if ( (denot_boolean(is_singular())))
 {$title = get_the_title($comment_post[0]->ID);
$title = apply_filters(array('the_title_rss',false),$title);
printf(deAspis(ent2ncr(__(array('Comment on %1$s by %2$s',false)))),deAspisRC($title),deAspisRC(get_comment_author_rss()));
}else 
{{printf(deAspis(ent2ncr(__(array('By: %s',false)))),deAspisRC(get_comment_author_rss()));
}};
?></title>
		<link rel="alternate" href="<?php comment_link();
;
?>" type="<?php bloginfo_rss(array('html_type',false));
;
?>" />

		<author>
			<name><?php comment_author_rss();
;
?></name>
			<?php if ( deAspis(get_comment_author_url()))
 echo AspisCheckPrint(concat2(concat1('<uri>',get_comment_author_url()),'</uri>'));
;
?>

		</author>

		<id><?php comment_guid();
;
?></id>
		<updated><?php echo AspisCheckPrint(mysql2date(array('Y-m-d\TH:i:s\Z',false),get_comment_time(array('Y-m-d H:i:s',false),array(true,false),array(false,false)),array(false,false)));
;
?></updated>
		<published><?php echo AspisCheckPrint(mysql2date(array('Y-m-d\TH:i:s\Z',false),get_comment_time(array('Y-m-d H:i:s',false),array(true,false),array(false,false)),array(false,false)));
;
?></published>
<?php if ( deAspis(post_password_required($comment_post)))
 {;
?>
		<content type="html" xml:base="<?php comment_link();
;
?>"><![CDATA[<?php echo AspisCheckPrint(get_the_password_form());
;
?>]]></content>
<?php }else 
{;
?>
		<content type="html" xml:base="<?php comment_link();
;
?>"><![CDATA[<?php comment_text();
;
?>]]></content>
<?php }if ( ($comment[0]->comment_parent[0] == (0)))
 {;
?>
		<thr:in-reply-to ref="<?php the_guid();
;
?>" href="<?php the_permalink_rss();
;
?>" type="<?php bloginfo_rss(array('html_type',false));
;
?>" />
<?php }else 
{$parent_comment = get_comment($comment[0]->comment_parent);
;
?>
		<thr:in-reply-to ref="<?php comment_guid($parent_comment);
?>" href="<?php echo AspisCheckPrint(get_comment_link($parent_comment));
?>" type="<?php bloginfo_rss(array('html_type',false));
;
?>" />
<?php }do_action(array('comment_atom_entry',false),$comment[0]->comment_ID,$comment_post[0]->ID);
;
?>
	</entry>
<?php }};
?>
</feed>
<?php 