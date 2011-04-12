<?php require_once('AspisMain.php'); ?><?php
get_header();
;
?>

	<div id="content" class="widecolumn" role="main">

	<?php if ( deAspis(have_posts()))
 {while ( deAspis(have_posts()) )
{the_post();
;
?>

		<div class="navigation">
			<div class="alignleft"><?php previous_post_link(array('&laquo; %link',false));
;
?></div>
			<div class="alignright"><?php next_post_link(array('%link &raquo;',false));
;
?></div>
		</div>

		<div <?php post_class();
;
?> id="post-<?php the_ID();
;
?>">
			<h2><?php the_title();
;
?></h2>

			<div class="entry">
				<?php the_content(array('<p class="serif">Read the rest of this entry &raquo;</p>',false));
;
?>

				<?php wp_link_pages(array(array('before' => array('<p><strong>Pages:</strong> ',false,false),'after' => array('</p>',false,false),'next_or_number' => array('number',false,false)),false));
;
?>
				<?php the_tags(array('<p>Tags: ',false),array(', ',false),array('</p>',false));
;
?>

				<p class="postmetadata alt">
					<small>
						This entry was posted
						<?php ;
?>
						on <?php the_time(array('l, F jS, Y',false));
;
?> at <?php the_time();
;
?>
						and is filed under <?php the_category(array(', ',false));
;
?>.
						You can follow any responses to this entry through the <?php post_comments_feed_link(array('RSS 2.0',false));
;
?> feed.

						<?php if ( (deAspis(comments_open()) && deAspis(pings_open())))
 {;
?>
							You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url();
;
?>" rel="trackback">trackback</a> from your own site.

						<?php }elseif ( ((denot_boolean(comments_open())) && deAspis(pings_open())))
 {;
?>
							Responses are currently closed, but you can <a href="<?php trackback_url();
;
?> " rel="trackback">trackback</a> from your own site.

						<?php }elseif ( (deAspis(comments_open()) && (denot_boolean(pings_open()))))
 {;
?>
							You can skip to the end and leave a response. Pinging is currently not allowed.

						<?php }elseif ( ((denot_boolean(comments_open())) && (denot_boolean(pings_open()))))
 {;
?>
							Both comments and pings are currently closed.

						<?php }edit_post_link(array('Edit this entry',false),array('',false),array('.',false));
;
?>

					</small>
				</p>

			</div>
		</div>

	<?php comments_template();
;
?>

	<?php }}else 
{;
?>

		<p>Sorry, no posts matched your criteria.</p>

<?php };
?>

	</div>

<?php get_footer();
;
?>
<?php 