<?php require_once('AspisMain.php'); ?><?php
if ( ((empty($wp) || Aspis_empty( $wp))))
 {require_once ('./wp-load.php');
wp();
}header((deconcat1('Content-Type: text/xml; charset=',get_option(array('blog_charset',false)))),true);
$link_cat = $_GET[0]['link_cat'];
if ( ((((empty($link_cat) || Aspis_empty( $link_cat))) || ($link_cat[0] == ('all'))) || ($link_cat[0] == ('0'))))
 {$link_cat = array('',false);
}else 
{{$link_cat = concat2(concat1('',Aspis_urldecode($link_cat)),'');
$link_cat = Aspis_intval($link_cat);
}};
echo AspisCheckPrint(concat12('<?xml version="1.0"?',">\n"));
;
?>
<?php the_generator(array('comment',false));
;
?>
<opml version="1.0">
	<head>
		<title>Links for <?php echo AspisCheckPrint(esc_attr(concat(get_bloginfo(array('name',false),array('display',false)),$cat_name)));
;
?></title>
		<dateCreated><?php echo AspisCheckPrint(attAspis(gmdate(("D, d M Y H:i:s"))));
;
?> GMT</dateCreated>
	</head>
	<body>
<?php if ( ((empty($link_cat) || Aspis_empty( $link_cat))))
 $cats = get_categories(array("type=link&hierarchical=0",false));
else 
{$cats = get_categories(concat1('type=link&hierarchical=0&include=',$link_cat));
}foreach ( deAspis(array_cast($cats)) as $cat  )
{$catname = apply_filters(array('link_category',false),$cat[0]->name);
;
?>
<outline type="category" title="<?php echo AspisCheckPrint(esc_attr($catname));
;
?>">
<?php $bookmarks = get_bookmarks(concat1("category=",$cat[0]->term_id));
foreach ( deAspis(array_cast($bookmarks)) as $bookmark  )
{$title = esc_attr(apply_filters(array('link_title',false),$bookmark[0]->link_name));
;
?>
	<outline text="<?php echo AspisCheckPrint($title);
;
?>" type="link" xmlUrl="<?php echo AspisCheckPrint(esc_attr($bookmark[0]->link_rss));
;
?>" htmlUrl="<?php echo AspisCheckPrint(esc_attr($bookmark[0]->link_url));
;
?>" updated="<?php if ( (('0000-00-00 00:00:00') != $bookmark[0]->link_updated[0]))
 echo AspisCheckPrint($bookmark[0]->link_updated);
;
?>" />
<?php };
?>
</outline>
<?php };
?>
</body>
</opml>
<?php 