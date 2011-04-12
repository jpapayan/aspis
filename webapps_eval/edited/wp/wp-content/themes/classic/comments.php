<?php require_once('AspisMain.php'); ?><?php
if ( deAspis(post_password_required()))
 {;
?>
<p><?php _e(array('Enter your password to view comments.',false));
;
?></p>
<?php return ;
};
?>

<h2 id="comments"><?php comments_number(__(array('No Comments',false)),__(array('1 Comment',false)),__(array('% Comments',false)));
;
?>
<?php if ( deAspis(comments_open()))
 {;
?>
	<a href="#postcomment" title="<?php _e(array("Leave a comment",false));
;
?>">&raquo;</a>
<?php };
?>
</h2>

<?php if ( deAspis(have_comments()))
 {;
?>
<ol id="commentlist">

<?php foreach ( $comments[0] as $comment  )
{;
?>
	<li <?php comment_class();
;
?> id="comment-<?php comment_ID();
?>">
	<?php echo AspisCheckPrint(get_avatar($comment,array(32,false)));
;
?>
	<?php comment_text();
?>
	<p><cite><?php comment_type(_x(array('Comment',false),array('noun',false)),__(array('Trackback',false)),__(array('Pingback',false)));
;
?> <?php _e(array('by',false));
;
?> <?php comment_author_link();
?> &#8212; <?php comment_date();
?> @ <a href="#comment-<?php comment_ID();
?>"><?php comment_time();
?></a></cite> <?php edit_comment_link(__(array("Edit This",false)),array(' |',false));
;
?></p>
	</li>

<?php };
?>

</ol>

<?php }else 
{;
?>
	<p><?php _e(array('No comments yet.',false));
;
?></p>
<?php };
?>

<p><?php post_comments_feed_link(__(array('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.',false)));
;
?>
<?php if ( deAspis(pings_open()))
 {;
?>
	<a href="<?php trackback_url();
?>" rel="trackback"><?php _e(array('TrackBack <abbr title="Universal Resource Locator">URL</abbr>',false));
;
?></a>
<?php };
?>
</p>

<?php if ( deAspis(comments_open()))
 {;
?>
<h2 id="postcomment"><?php _e(array('Leave a comment',false));
;
?></h2>

<?php if ( (deAspis(get_option(array('comment_registration',false))) && (denot_boolean(is_user_logged_in()))))
 {;
?>
<p><?php printf(deAspis(__(array('You must be <a href="%s">logged in</a> to post a comment.',false))),deAspisRC(wp_login_url(get_permalink())));
;
?></p>
<?php }else 
{;
?>

<form action="<?php echo AspisCheckPrint(get_option(array('siteurl',false)));
;
?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( deAspis(is_user_logged_in()))
 {;
?>

<p><?php printf(deAspis(__(array('Logged in as %s.',false))),(deconcat2(concat(concat2(concat1('<a href="',get_option(array('siteurl',false))),'/wp-admin/profile.php">'),$user_identity),'</a>')));
;
?> <a href="<?php echo AspisCheckPrint(wp_logout_url(get_permalink()));
;
?>" title="<?php _e(array('Log out of this account',false));
?>"><?php _e(array('Log out &raquo;',false));
;
?></a></p>

<?php }else 
{;
?>

<p><input type="text" name="author" id="author" value="<?php echo AspisCheckPrint(esc_attr($comment_author));
;
?>" size="22" tabindex="1" />
<label for="author"><small><?php _e(array('Name',false));
;
?> <?php if ( $req[0])
 _e(array('(required)',false));
;
?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo AspisCheckPrint(esc_attr($comment_author_email));
;
?>" size="22" tabindex="2" />
<label for="email"><small><?php _e(array('Mail (will not be published)',false));
;
?> <?php if ( $req[0])
 _e(array('(required)',false));
;
?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo AspisCheckPrint(esc_attr($comment_author_url));
;
?>" size="22" tabindex="3" />
<label for="url"><small><?php _e(array('Website',false));
;
?></small></label></p>

<?php };
?>

<!--<p><small><strong>XHTML:</strong> <?php printf(deAspis(__(array('You can use these tags: %s',false))),deAspisRC(allowed_tags()));
;
?></small></p>-->

<p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php esc_attr_e(array('Submit Comment',false));
;
?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo AspisCheckPrint($id);
;
?>" />
</p>
<?php do_action(array('comment_form',false),$post[0]->ID);
;
?>

</form>

<?php };
?>

<?php }else 
{;
?>
<p><?php _e(array('Sorry, the comment form is closed at this time.',false));
;
?></p>
<?php };
?>
<?php 