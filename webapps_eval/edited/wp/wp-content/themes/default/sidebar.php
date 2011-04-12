<?php require_once('AspisMain.php'); ?><?php
;
?>
	<div id="sidebar" role="complementary">
		<ul>
			<?php if ( ((!(function_exists(('dynamic_sidebar')))) || (denot_boolean(dynamic_sidebar()))))
 {;
?>
			<li>
				<?php get_search_form();
;
?>
			</li>

			<!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h2>Author</h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->

			<?php if ( ((((((deAspis(is_404()) || deAspis(is_category())) || deAspis(is_day())) || deAspis(is_month())) || deAspis(is_year())) || deAspis(is_search())) || deAspis(is_paged())))
 {;
?> <li>

			<?php if ( deAspis(is_404()))
 {;
?>
			<?php }elseif ( deAspis(is_category()))
 {;
?>
			<p>You are currently browsing the archives for the <?php single_cat_title(array('',false));
;
?> category.</p>

			<?php }elseif ( deAspis(is_day()))
 {;
?>
			<p>You are currently browsing the <a href="<?php bloginfo(array('url',false));
;
?>/"><?php bloginfo(array('name',false));
;
?></a> blog archives
			for the day <?php the_time(array('l, F jS, Y',false));
;
?>.</p>

			<?php }elseif ( deAspis(is_month()))
 {;
?>
			<p>You are currently browsing the <a href="<?php bloginfo(array('url',false));
;
?>/"><?php bloginfo(array('name',false));
;
?></a> blog archives
			for <?php the_time(array('F, Y',false));
;
?>.</p>

			<?php }elseif ( deAspis(is_year()))
 {;
?>
			<p>You are currently browsing the <a href="<?php bloginfo(array('url',false));
;
?>/"><?php bloginfo(array('name',false));
;
?></a> blog archives
			for the year <?php the_time(array('Y',false));
;
?>.</p>

			<?php }elseif ( deAspis(is_search()))
 {;
?>
			<p>You have searched the <a href="<?php bloginfo(array('url',false));
;
?>/"><?php bloginfo(array('name',false));
;
?></a> blog archives
			for <strong>'<?php the_search_query();
;
?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>

			<?php }elseif ( (((isset($_GET[0][('paged')]) && Aspis_isset( $_GET [0][('paged')]))) && (!((empty($_GET[0][('paged')]) || Aspis_empty( $_GET [0][('paged')]))))))
 {;
?>
			<p>You are currently browsing the <a href="<?php bloginfo(array('url',false));
;
?>/"><?php bloginfo(array('name',false));
;
?></a> blog archives.</p>

			<?php };
?>

			</li>
		<?php };
?>
		</ul>
		<ul role="navigation">
			<?php wp_list_pages(array('title_li=<h2>Pages</h2>',false));
;
?>

			<li><h2>Archives</h2>
				<ul>
				<?php wp_get_archives(array('type=monthly',false));
;
?>
				</ul>
			</li>

			<?php wp_list_categories(array('show_count=1&title_li=<h2>Categories</h2>',false));
;
?>
		</ul>
		<ul>
			<?php if ( (deAspis(is_home()) || deAspis(is_page())))
 {;
?>
				<?php wp_list_bookmarks();
;
?>

				<li><h2>Meta</h2>
				<ul>
					<?php wp_register();
;
?>
					<li><?php wp_loginout();
;
?></li>
					<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
					<?php wp_meta();
;
?>
				</ul>
				</li>
			<?php };
?>

			<?php };
?>
		</ul>
	</div>

<?php 