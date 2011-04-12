<?php require_once('AspisMain.php'); ?><?php
;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <title><?php echo AspisCheckPrint(get_option(array('blogname',false)));
;
?> - Comments on <?php the_title();
;
?></title>

	<meta http-equiv="Content-Type" content="<?php bloginfo(array('html_type',false));
;
?>; charset=<?php echo AspisCheckPrint(get_option(array('blog_charset',false)));
;
?>" />
	<style type="text/css" media="screen">
		@import url( <?php bloginfo(array('stylesheet_url',false));
;
?> );
		body { margin: 3px; }
	</style>

</head>
<body id="commentspopup">

<h1 id="header"><a href="" title="<?php echo AspisCheckPrint(get_option(array('blogname',false)));
;
?>"><?php echo AspisCheckPrint(get_option(array('blogname',false)));
;
?></a></h1>

<?php add_filter(array('comment_text',false),array('popuplinks',false));
if ( deAspis(have_posts()))
 {while ( deAspis(have_posts()) )
{the_post();
;
?>
<h2 id="comments">Comments</h2>

<p><a href="<?php echo AspisCheckPrint(get_post_comments_feed_link($post[0]->ID));
;
?>"><abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.</a></p>

<?php if ( deAspis(pings_open()))
 {;
?>
<p>The <abbr title="Universal Resource Locator">URL</abbr> to TrackBack this entry is: <em><?php trackback_url();
;
?></em></p>
<?php };
?>

<?php $commenter = wp_get_current_commenter();
extract(($commenter[0]));
$comments = get_approved_comments($id);
$post = get_post($id);
if ( deAspis(post_password_required($post)))
 {echo AspisCheckPrint((get_the_password_form()));
}else 
{{;
?>

<?php if ( $comments[0])
 {;
?>
<ol id="commentlist">
<?php foreach ( $comments[0] as $comment  )
{;
?>
	<li id="comment-<?php comment_ID();
;
?>">
	<?php comment_text();
;
?>
	<p><cite><?php comment_type(array('Comment',false),array('Trackback',false),array('Pingback',false));
;
?> by <?php comment_author_link();
;
?> &#8212; <?php comment_date();
;
?> @ <a href="#comment-<?php comment_ID();
;
?>"><?php comment_time();
;
?></a></cite></p>
	</li>

<?php };
?>
</ol>
<?php }else 
{{;
?>
	<p>No comments yet.</p>
<?php }};
?>

<?php if ( deAspis(comments_open()))
 {;
?>
<h2>Leave a comment</h2>
<p>Line and paragraph breaks automatic, e-mail address never displayed, <acronym title="Hypertext Markup Language">HTML</acronym> allowed: <code><?php echo AspisCheckPrint(allowed_tags());
;
?></code></p>

<form action="<?php echo AspisCheckPrint(get_option(array('siteurl',false)));
;
?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( $user_ID[0])
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
	<p>
	  <input type="text" name="author" id="author" class="textarea" value="<?php echo AspisCheckPrint(esc_attr($comment_author));
;
?>" size="28" tabindex="1" />
	   <label for="author">Name</label>
	</p>

	<p>
	  <input type="text" name="email" id="email" value="<?php echo AspisCheckPrint(esc_attr($comment_author_email));
;
?>" size="28" tabindex="2" />
	   <label for="email">E-mail</label>
	</p>

	<p>
	  <input type="text" name="url" id="url" value="<?php echo AspisCheckPrint(esc_attr($comment_author_url));
;
?>" size="28" tabindex="3" />
	   <label for="url"><abbr title="Universal Resource Locator">URL</abbr></label>
	</p>
<?php };
?>

	<p>
	  <label for="comment">Your Comment</label>
	<br />
	  <textarea name="comment" id="comment" cols="70" rows="4" tabindex="4"></textarea>
	</p>

	<p>
      <input type="hidden" name="comment_post_ID" value="<?php echo AspisCheckPrint($id);
;
?>" />
	  <input type="hidden" name="redirect_to" value="<?php echo AspisCheckPrint(esc_attr($_SERVER[0]["REQUEST_URI"]));
;
?>" />
	  <input name="submit" type="submit" tabindex="5" value="Say It!" />
	</p>
	<?php do_action(array('comment_form',false),$post[0]->ID);
;
?>
</form>
<?php }else 
{{;
?>
<p>Sorry, the comment form is closed at this time.</p>
<?php }}}};
?>

<div><strong><a href="javascript:window.close()">Close this window.</a></strong></div>

<?php }}else 
{;
?>
<p>Sorry, no posts matched your criteria.</p>
<?php };
?>
<!-- // this is just the end of the motor - don't touch that line either :) -->
<?php ;
?>
<p class="credit"><?php timer_stop(array(1,false));
;
?> <cite>Powered by <a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform"><strong>WordPress</strong></a></cite></p>
<?php ;
?>
<script type="text/javascript">
<!--
document.onkeypress = function esc(e) {
	if(typeof(e) == "undefined") { e=event; }
	if (e.keyCode == 27) { self.close(); }
}
// -->
</script>
</body>
</html>
<?php 