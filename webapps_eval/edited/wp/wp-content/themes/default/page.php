<?php require_once('AspisMain.php'); ?><?php
get_header();
;
?>

	<div id="content" class="narrowcolumn" role="main">

		<?php if ( deAspis(have_posts()))
 {while ( deAspis(have_posts()) )
{the_post();
;
?>
		<div class="post" id="post-<?php the_ID();
;
?>">
		<h2><?php the_title();
;
?></h2>
			<div class="entry">
				<?php the_content(array('<p class="serif">Read the rest of this page &raquo;</p>',false));
;
?>

				<?php wp_link_pages(array(array('before' => array('<p><strong>Pages:</strong> ',false,false),'after' => array('</p>',false,false),'next_or_number' => array('number',false,false)),false));
;
?>

			</div>
		</div>
		<?php }};
?>
	<?php edit_post_link(array('Edit this entry.',false),array('<p>',false),array('</p>',false));
;
?>
	
	<?php comments_template();
;
?>
	
	</div>

<?php get_sidebar();
;
?>

<?php get_footer();
;
?>
<?php 