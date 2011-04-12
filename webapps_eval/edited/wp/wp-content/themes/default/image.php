<?php require_once('AspisMain.php'); ?><?php
get_header();
;
?>

	<div id="content" class="widecolumn">

  <?php if ( deAspis(have_posts()))
 {while ( deAspis(have_posts()) )
{the_post();
;
?>

		<div class="post" id="post-<?php the_ID();
;
?>">
			<h2><a href="<?php echo AspisCheckPrint(get_permalink($post[0]->post_parent));
;
?>" rev="attachment"><?php echo AspisCheckPrint(get_the_title($post[0]->post_parent));
;
?></a> &raquo; <?php the_title();
;
?></h2>
			<div class="entry">
				<p class="attachment"><a href="<?php echo AspisCheckPrint(wp_get_attachment_url($post[0]->ID));
;
?>"><?php echo AspisCheckPrint(wp_get_attachment_image($post[0]->ID,array('medium',false)));
;
?></a></p>
				<div class="caption"><?php if ( (!((empty($post[0]->post_excerpt) || Aspis_empty( $post[0] ->post_excerpt )))))
 the_excerpt();
;
?></div>

				<?php the_content(array('<p class="serif">Read the rest of this entry &raquo;</p>',false));
;
?>

				<div class="navigation">
					<div class="alignleft"><?php previous_image_link();
;
?></div>
					<div class="alignright"><?php next_image_link();
;
?></div>
				</div>
				<br class="clear" />

				<p class="postmetadata alt">
					<small>
						This entry was posted on <?php the_time(array('l, F jS, Y',false));
;
?> at <?php the_time();
;
?>
						and is filed under <?php the_category(array(', ',false));
;
?>.
						<?php the_taxonomies();
;
?>
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

						<?php }edit_post_link(array('Edit this entry.',false),array('',false),array('',false));
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

		<p>Sorry, no attachments matched your criteria.</p>

<?php };
?>

	</div>

<?php get_footer();
;
?>
<?php 