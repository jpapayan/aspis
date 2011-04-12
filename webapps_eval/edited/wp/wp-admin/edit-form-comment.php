<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit(array('-1',false));
$submitbutton_text = __(array('Edit Comment',false));
$toprow_title = Aspis_sprintf(__(array('Editing Comment # %s',false)),$comment[0]->comment_ID);
$form_action = array('editedcomment',false);
$form_extra = concat(concat2(concat1("' />\n<input type='hidden' name='comment_ID' value='",esc_attr($comment[0]->comment_ID)),"' />\n<input type='hidden' name='comment_post_ID' value='"),esc_attr($comment[0]->comment_post_ID));
$comment[0]->comment_author_email = esc_attr($comment[0]->comment_author_email);
;
?>

<form name="post" action="comment.php" method="post" id="post">
<?php wp_nonce_field(concat1('update-comment_',$comment[0]->comment_ID));
?>
<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e(array('Edit Comment',false));
;
?></h2>

<div id="poststuff" class="metabox-holder has-right-sidebar">
<input type="hidden" name="user_ID" value="<?php echo AspisCheckPrint(int_cast($user_ID));
?>" />
<input type="hidden" name="action" value='<?php echo AspisCheckPrint(concat($form_action,$form_extra));
?>' />

<div id="side-info-column" class="inner-sidebar">
<div id="submitdiv" class="stuffbox" >
<h3><span class='hndle'><?php _e(array('Status',false));
?></span></h3>
<div class="inside">
<div class="submitbox" id="submitcomment">
<div id="minor-publishing">

<div id="minor-publishing-actions">
<div id="preview-action">
<a class="preview button" href="<?php echo AspisCheckPrint(get_comment_link());
;
?>" target="_blank"><?php _e(array('View Comment',false));
;
?></a>
</div>
<div class="clear"></div>
</div>

<div id="misc-publishing-actions">

<div class="misc-pub-section" id="comment-status-radio">
<label class="approved"><input type="radio"<?php checked($comment[0]->comment_approved,array('1',false));
;
?> name="comment_status" value="1" /><?php echo AspisCheckPrint(_x(array('Approved',false),array('adjective',false)));
?></label><br />
<label class="waiting"><input type="radio"<?php checked($comment[0]->comment_approved,array('0',false));
;
?> name="comment_status" value="0" /><?php echo AspisCheckPrint(_x(array('Pending',false),array('adjective',false)));
?></label><br />
<label class="spam"><input type="radio"<?php checked($comment[0]->comment_approved,array('spam',false));
;
?> name="comment_status" value="spam" /><?php echo AspisCheckPrint(_x(array('Spam',false),array('adjective',false)));
;
?></label>
</div>

<div class="misc-pub-section curtime misc-pub-section-last">
<?php $datef = __(array('M j, Y @ G:i',false));
$stamp = __(array('Submitted on: <b>%1$s</b>',false));
$date = date_i18n($datef,attAspis(strtotime($comment[0]->comment_date[0])));
;
?>
<span id="timestamp"><?php printf($stamp[0],deAspisRC($date));
;
?></span>&nbsp;<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js" tabindex='4'><?php _e(array('Edit',false));
?></a>
<div id='timestampdiv' class='hide-if-js'><?php touch_time((array(('editcomment') == $action[0],false)),array(0,false),array(5,false));
;
?></div>
</div>
</div> <!-- misc actions -->
<div class="clear"></div>
</div>

<div id="major-publishing-actions">
<div id="delete-action">
<?php echo AspisCheckPrint(concat2(concat(concat2(concat1("<a class='submitdelete deletion' href='",wp_nonce_url(concat(concat(concat1("comment.php?action=",((!(EMPTY_TRASH_DAYS)) ? array('deletecomment',false) : array('trashcomment',false))),concat2(concat1("&amp;c=",$comment[0]->comment_ID),"&amp;_wp_original_http_referer=")),Aspis_urlencode(wp_get_referer())),concat1('delete-comment_',$comment[0]->comment_ID))),"'>"),((!(EMPTY_TRASH_DAYS)) ? __(array('Delete Permanently',false)) : __(array('Move to Trash',false)))),"</a>\n"));
;
?>
</div>
<div id="publishing-action">
<input type="submit" name="save" value="<?php esc_attr_e(array('Update Comment',false));
;
?>" tabindex="4" class="button-primary" />
</div>
<div class="clear"></div>
</div>
</div>
</div>
</div>
</div>

<div id="post-body">
<div id="post-body-content">
<div id="namediv" class="stuffbox">
<h3><label for="name"><?php _e(array('Author',false));
?></label></h3>
<div class="inside">
<table class="form-table editcomment">
<tbody>
<tr valign="top">
	<td class="first"><?php _e(array('Name:',false));
;
?></td>
	<td><input type="text" name="newcomment_author" size="30" value="<?php echo AspisCheckPrint(esc_attr($comment[0]->comment_author));
;
?>" tabindex="1" id="name" /></td>
</tr>
<tr valign="top">
	<td class="first">
	<?php if ( $comment[0]->comment_author_email[0])
 {printf(deAspis(__(array('E-mail (%s):',false))),deAspisRC(get_comment_author_email_link(__(array('send e-mail',false)),array('',false),array('',false))));
}else 
{{_e(array('E-mail:',false));
}};
?></td>
	<td><input type="text" name="newcomment_author_email" size="30" value="<?php echo AspisCheckPrint($comment[0]->comment_author_email);
;
?>" tabindex="2" id="email" /></td>
</tr>
<tr valign="top">
	<td class="first">
	<?php if ( ((!((empty($comment[0]->comment_author_url) || Aspis_empty( $comment[0] ->comment_author_url )))) && (('http://') != $comment[0]->comment_author_url[0])))
 {$link = concat2(concat(concat2(concat1('<a href="',$comment[0]->comment_author_url),'" rel="external nofollow" target="_blank">'),__(array('visit site',false))),'</a>');
printf(deAspis(__(array('URL (%s):',false))),deAspisRC(apply_filters(array('get_comment_author_link',false),$link)));
}else 
{{_e(array('URL:',false));
}};
?></td>
	<td><input type="text" id="newcomment_author_url" name="newcomment_author_url" size="30" class="code" value="<?php echo AspisCheckPrint(esc_attr($comment[0]->comment_author_url));
;
?>" tabindex="3" /></td>
</tr>
</tbody>
</table>
<br />
</div>
</div>

<div id="postdiv" class="postarea">
<?php the_editor($comment[0]->comment_content,array('content',false),array('newcomment_author_url',false),array(false,false),array(4,false));
;
?>
<?php wp_nonce_field(array('closedpostboxes',false),array('closedpostboxesnonce',false),array(false,false));
;
?>
</div>

<?php do_meta_boxes(array('comment',false),array('normal',false),$comment);
;
?>

<input type="hidden" name="c" value="<?php echo AspisCheckPrint(esc_attr($comment[0]->comment_ID));
?>" />
<input type="hidden" name="p" value="<?php echo AspisCheckPrint(esc_attr($comment[0]->comment_post_ID));
?>" />
<input name="referredby" type="hidden" id="referredby" value="<?php echo AspisCheckPrint(esc_url(Aspis_stripslashes(wp_get_referer())));
;
?>" />
<?php wp_original_referer_field(array(true,false),array('previous',false));
;
?>
<input type="hidden" name="noredir" value="1" />

</div>
</div>
</div>
</div>
</form>

<script type="text/javascript">
try{document.post.name.focus();}catch(e){}
</script>
<?php 