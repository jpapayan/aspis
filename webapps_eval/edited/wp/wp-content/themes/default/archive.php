<?php require_once('AspisMain.php'); ?><?php
get_header();
;
?>

	<div id="content" class="narrowcolumn" role="main">

		<?php if ( deAspis(have_posts()))
 {;
?>

 	  <?php $post = attachAspis($posts,(0));
;
?>
 	  <?php if ( deAspis(is_category()))
 {;
?>
		<h2 class="pagetitle">Archive for the &#8216;<?php single_cat_title();
;
?>&#8217; Category</h2>
 	  <?php }elseif ( deAspis(is_tag()))
 {;
?>
		<h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title();
;
?>&#8217;</h2>
 	  <?php }elseif ( deAspis(is_day()))
 {;
?>
		<h2 class="pagetitle">Archive for <?php the_time(array('F jS, Y',false));
;
?></h2>
 	  <?php }elseif ( deAspis(is_month()))
 {;
?>
		<h2 class="pagetitle">Archive for <?php the_time(array('F, Y',false));
;
?></h2>
 	  <?php }elseif ( deAspis(is_year()))
 {;
?>
		<h2 class="pagetitle">Archive for <?php the_time(array('Y',false));
;
?></h2>
	  <?php }elseif ( deAspis(is_author()))
 {;
?>
		<h2 class="pagetitle">Author Archive</h2>
 	  <?php }elseif ( (((isset($_GET[0][('paged')]) && Aspis_isset( $_GET [0][('paged')]))) && (!((empty($_GET[0][('paged')]) || Aspis_empty( $_GET [0][('paged')]))))))
 {;
?>
		<h2 class="pagetitle">Blog Archives</h2>
 	  <?php };
?>


		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(array('&laquo; Older Entries',false));
;
?></div>
			<div class="alignright"><?php previous_posts_link(array('Newer Entries &raquo;',false));
;
?></div>
		</div>

		<?php while ( deAspis(have_posts()) )
{the_post();
;
?>
		<div <?php post_class();
;
?>>
				<h3 id="post-<?php the_ID();
;
?>"><a href="<?php the_permalink();
;
?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute();
;
?>"><?php the_title();
;
?></a></h3>
				<small><?php the_time(array('l, F jS, Y',false));
;
?></small>

				<div class="entry">
					<?php the_content();
;
?>
				</div>

				<p class="postmetadata"><?php the_tags(array('Tags: ',false),array(', ',false),array('<br />',false));
;
?> Posted in <?php the_category(array(', ',false));
;
?> | <?php edit_post_link(array('Edit',false),array('',false),array(' | ',false));
;
?>  <?php comments_popup_link(array('No Comments &#187;',false),array('1 Comment &#187;',false),array('% Comments &#187;',false));
;
?></p>

			</div>

		<?php };
?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(array('&laquo; Older Entries',false));
;
?></div>
			<div class="alignright"><?php previous_posts_link(array('Newer Entries &raquo;',false));
;
?></div>
		</div>
	<?php }else 
{if ( deAspis(is_category()))
 {printf(("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>"),deAspisRC(single_cat_title(array('',false),array(false,false))));
}else 
{if ( deAspis(is_date()))
 {echo AspisCheckPrint((array("<h2>Sorry, but there aren't any posts with this date.</h2>",false)));
}else 
{if ( deAspis(is_author()))
 {$userdata = get_userdatabylogin(get_query_var(array('author_name',false)));
printf(("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>"),deAspisRC($userdata[0]->display_name));
}else 
{{echo AspisCheckPrint((array("<h2 class='center'>No posts found.</h2>",false)));
}}}}get_search_form();
};
?>

	</div>

<?php get_sidebar();
;
?>

<?php get_footer();
;
?>
<?php 