<?php require_once('AspisMain.php'); ?><?php
if ( ((!((empty($_SERVER[0][('SCRIPT_FILENAME')]) || Aspis_empty( $_SERVER [0][('SCRIPT_FILENAME')])))) && (('comments.php') == deAspis(Aspis_basename($_SERVER[0]['SCRIPT_FILENAME'])))))
 Aspis_exit(array('Please do not load this page directly. Thanks!',false));
if ( deAspis(post_password_required()))
 {;
?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php return ;
};
?>

<!-- You can start editing here. -->

<?php if ( deAspis(have_comments()))
 {;
?>
	<h3 id="comments"><?php comments_number(array('No Responses',false),array('One Response',false),array('% Responses',false));
;
?> to &#8220;<?php the_title();
;
?>&#8221;</h3>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link();
?></div>
		<div class="alignright"><?php next_comments_link();
?></div>
	</div>

	<ol class="commentlist">
	<?php wp_list_comments();
;
?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link();
?></div>
		<div class="alignright"><?php next_comments_link();
?></div>
	</div>
 <?php }else 
{;
?>

	<?php if ( deAspis(comments_open()))
 {;
?>
		<!-- If comments are open, but there are no comments. -->

	 <?php }else 
{;
?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php };
?>
<?php };
?>


<?php if ( deAspis(comments_open()))
 {;
?>

<div id="respond">

<h3><?php comment_form_title(array('Leave a Reply',false),array('Leave a Reply to %s',false));
;
?></h3>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link();
;
?></small>
</div>

<?php if ( (deAspis(get_option(array('comment_registration',false))) && (denot_boolean(is_user_logged_in()))))
 {;
?>
<p>You must be <a href="<?php echo AspisCheckPrint(wp_login_url(get_permalink()));
;
?>">logged in</a> to post a comment.</p>
<?php }else 
{;
?>

<form action="<?php echo AspisCheckPrint(get_option(array('siteurl',false)));
;
?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( deAspis(is_user_logged_in()))
 {;
?>

<p>Logged in as <a href="<?php echo AspisCheckPrint(get_option(array('siteurl',false)));
;
?>/wp-admin/profile.php"><?php echo AspisCheckPrint($user_identity);
;
?></a>. <a href="<?php echo AspisCheckPrint(wp_logout_url(get_permalink()));
;
?>" title="Log out of this account">Log out &raquo;</a></p>

<?php }else 
{;
?>

<p><input type="text" name="author" id="author" value="<?php echo AspisCheckPrint(esc_attr($comment_author));
;
?>" size="22" tabindex="1" <?php if ( $req[0])
 echo AspisCheckPrint(array("aria-required='true'",false));
;
?> />
<label for="author"><small>Name <?php if ( $req[0])
 echo AspisCheckPrint(array("(required)",false));
;
?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo AspisCheckPrint(esc_attr($comment_author_email));
;
?>" size="22" tabindex="2" <?php if ( $req[0])
 echo AspisCheckPrint(array("aria-required='true'",false));
;
?> />
<label for="email"><small>Mail (will not be published) <?php if ( $req[0])
 echo AspisCheckPrint(array("(required)",false));
;
?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo AspisCheckPrint(esc_attr($comment_author_url));
;
?>" size="22" tabindex="3" />
<label for="url"><small>Website</small></label></p>

<?php };
?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo AspisCheckPrint(allowed_tags());
;
?></code></small></p>-->

<p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
<?php comment_id_fields();
;
?>
</p>
<?php do_action(array('comment_form',false),$post[0]->ID);
;
?>

</form>

<?php };
?>
</div>

<?php };
?>
<?php 