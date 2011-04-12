<?php require_once('AspisMain.php'); ?><?php
get_header();
;
?>

<?php if ( deAspis(have_posts()))
 {while ( deAspis(have_posts()) )
{the_post();
;
?>

<?php the_date(array('',false),array('<h2>',false),array('</h2>',false));
;
?>

<div <?php post_class();
?> id="post-<?php the_ID();
;
?>">
	 <h3 class="storytitle"><a href="<?php the_permalink();
?>" rel="bookmark"><?php the_title();
;
?></a></h3>
	<div class="meta"><?php _e(array("Filed under:",false));
;
?> <?php the_category(array(',',false));
?> &#8212; <?php the_tags(__(array('Tags: ',false)),array(', ',false),array(' &#8212; ',false));
;
?> <?php the_author();
?> @ <?php the_time();
?> <?php edit_post_link(__(array('Edit This',false)));
;
?></div>

	<div class="storycontent">
		<?php the_content(__(array('(more...)',false)));
;
?>
	</div>

	<div class="feedback">
		<?php wp_link_pages();
;
?>
		<?php comments_popup_link(__(array('Comments (0)',false)),__(array('Comments (1)',false)),__(array('Comments (%)',false)));
;
?>
	</div>

</div>

<?php comments_template();
;
?>

<?php }}else 
{;
?>
<p><?php _e(array('Sorry, no posts matched your criteria.',false));
;
?></p>
<?php };
?>

<?php posts_nav_link(array(' &#8212; ',false),__(array('&laquo; Newer Posts',false)),__(array('Older Posts &raquo;',false)));
;
?>

<?php get_footer();
;
?>
<?php 