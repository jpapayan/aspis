<?php require_once('AspisMain.php'); ?><?php
;
?>
<!-- begin sidebar -->
<div id="menu">

<ul>
<?php if ( ((!(function_exists(('dynamic_sidebar')))) || (denot_boolean(dynamic_sidebar()))))
 {;
?>
	<?php wp_list_pages(concat1('title_li=',__(array('Pages:',false))));
;
?>
	<?php wp_list_bookmarks(array('title_after=&title_before=',false));
;
?>
	<?php wp_list_categories(concat1('title_li=',__(array('Categories:',false))));
;
?>
 <li id="search">
   <label for="s"><?php _e(array('Search:',false));
;
?></label>
   <form id="searchform" method="get" action="<?php bloginfo(array('home',false));
;
?>">
	<div>
		<input type="text" name="s" id="s" size="15" /><br />
		<input type="submit" value="<?php esc_attr_e(array('Search',false));
;
?>" />
	</div>
	</form>
 </li>
 <li id="archives"><?php _e(array('Archives:',false));
;
?>
	<ul>
	 <?php wp_get_archives(array('type=monthly',false));
;
?>
	</ul>
 </li>
 <li id="meta"><?php _e(array('Meta:',false));
;
?>
	<ul>
		<?php wp_register();
;
?>
		<li><?php wp_loginout();
;
?></li>
		<li><a href="<?php bloginfo(array('rss2_url',false));
;
?>" title="<?php _e(array('Syndicate this site using RSS',false));
;
?>"><?php _e(array('<abbr title="Really Simple Syndication">RSS</abbr>',false));
;
?></a></li>
		<li><a href="<?php bloginfo(array('comments_rss2_url',false));
;
?>" title="<?php _e(array('The latest comments to all posts in RSS',false));
;
?>"><?php _e(array('Comments <abbr title="Really Simple Syndication">RSS</abbr>',false));
;
?></a></li>
		<li><a href="http://validator.w3.org/check/referer" title="<?php _e(array('This page validates as XHTML 1.0 Transitional',false));
;
?>"><?php _e(array('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>',false));
;
?></a></li>
		<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
		<li><a href="http://wordpress.org/" title="<?php _e(array('Powered by WordPress, state-of-the-art semantic personal publishing platform.',false));
;
?>"><abbr title="WordPress">WP</abbr></a></li>
		<?php wp_meta();
;
?>
	</ul>
 </li>
<?php };
?>

</ul>

</div>
<!-- end sidebar -->
<?php 