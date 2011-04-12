<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 wp_die(__(array('You do not have sufficient permissions to manage options for this blog.',false)));
$title = __(array('Discussion Settings',false));
$parent_file = array('options-general.php',false);
include ('admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<form method="post" action="options.php">
<?php settings_fields(array('discussion',false));
;
?>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e(array('Default article settings',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Default article settings',false));
?></span></legend>
<label for="default_pingback_flag">
<input name="default_pingback_flag" type="checkbox" id="default_pingback_flag" value="1" <?php checked(array('1',false),get_option(array('default_pingback_flag',false)));
;
?> />
<?php _e(array('Attempt to notify any blogs linked to from the article (slows down posting.)',false));
?></label>
<br />
<label for="default_ping_status">
<input name="default_ping_status" type="checkbox" id="default_ping_status" value="open" <?php checked(array('open',false),get_option(array('default_ping_status',false)));
;
?> />
<?php _e(array('Allow link notifications from other blogs (pingbacks and trackbacks.)',false));
?></label>
<br />
<label for="default_comment_status">
<input name="default_comment_status" type="checkbox" id="default_comment_status" value="open" <?php checked(array('open',false),get_option(array('default_comment_status',false)));
;
?> />
<?php _e(array('Allow people to post comments on new articles',false));
?></label>
<br />
<small><em><?php echo AspisCheckPrint(concat2(concat1('(',__(array('These settings may be overridden for individual articles.',false))),')'));
;
?></em></small>
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('Other comment settings',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Other comment settings',false));
?></span></legend>
<label for="require_name_email"><input type="checkbox" name="require_name_email" id="require_name_email" value="1" <?php checked(array('1',false),get_option(array('require_name_email',false)));
;
?> /> <?php _e(array('Comment author must fill out name and e-mail',false));
?></label>
<br />
<label for="comment_registration">
<input name="comment_registration" type="checkbox" id="comment_registration" value="1" <?php checked(array('1',false),get_option(array('comment_registration',false)));
;
?> />
<?php _e(array('Users must be registered and logged in to comment',false));
?>
</label>
<br />

<label for="close_comments_for_old_posts">
<input name="close_comments_for_old_posts" type="checkbox" id="close_comments_for_old_posts" value="1" <?php checked(array('1',false),get_option(array('close_comments_for_old_posts',false)));
;
?> />
<?php printf(deAspis(__(array('Automatically close comments on articles older than %s days',false))),(deconcat2(concat1('</label><input name="close_comments_days_old" type="text" id="close_comments_days_old" value="',esc_attr(get_option(array('close_comments_days_old',false)))),'" class="small-text" />')));
?>
<br />
<label for="thread_comments">
<input name="thread_comments" type="checkbox" id="thread_comments" value="1" <?php checked(array('1',false),get_option(array('thread_comments',false)));
;
?> />
<?php $maxdeep = int_cast(apply_filters(array('thread_comments_depth_max',false),array(10,false)));
$thread_comments_depth = array('</label><select name="thread_comments_depth" id="thread_comments_depth">',false);
for ( $i = array(2,false) ; ($i[0] <= $maxdeep[0]) ; postincr($i) )
{$thread_comments_depth = concat($thread_comments_depth,concat2(concat1("<option value='",esc_attr($i)),"'"));
if ( (deAspis(get_option(array('thread_comments_depth',false))) == $i[0]))
 $thread_comments_depth = concat2($thread_comments_depth," selected='selected'");
$thread_comments_depth = concat($thread_comments_depth,concat2(concat1(">",$i),"</option>"));
}$thread_comments_depth = concat2($thread_comments_depth,'</select>');
printf(deAspis(__(array('Enable threaded (nested) comments %s levels deep',false))),deAspisRC($thread_comments_depth));
;
?><br />
<label for="page_comments">
<input name="page_comments" type="checkbox" id="page_comments" value="1" <?php checked(array('1',false),get_option(array('page_comments',false)));
;
?> />
<?php $default_comments_page = array('</label><label for="default_comments_page"><select name="default_comments_page" id="default_comments_page"><option value="newest"',false);
if ( (('newest') == deAspis(get_option(array('default_comments_page',false)))))
 $default_comments_page = concat2($default_comments_page,' selected="selected"');
$default_comments_page = concat($default_comments_page,concat2(concat1('>',__(array('last',false))),'</option><option value="oldest"'));
if ( (('oldest') == deAspis(get_option(array('default_comments_page',false)))))
 $default_comments_page = concat2($default_comments_page,' selected="selected"');
$default_comments_page = concat($default_comments_page,concat2(concat1('>',__(array('first',false))),'</option></select>'));
printf(deAspis(__(array('Break comments into pages with %1$s top level comments per page and the %2$s page displayed by default',false))),(deconcat2(concat1('</label><label for="comments_per_page"><input name="comments_per_page" type="text" id="comments_per_page" value="',esc_attr(get_option(array('comments_per_page',false)))),'" class="small-text" />')),deAspisRC($default_comments_page));
;
?></label>
<br />
<label for="comment_order"><?php $comment_order = array('<select name="comment_order" id="comment_order"><option value="asc"',false);
if ( (('asc') == deAspis(get_option(array('comment_order',false)))))
 $comment_order = concat2($comment_order,' selected="selected"');
$comment_order = concat($comment_order,concat2(concat1('>',__(array('older',false))),'</option><option value="desc"'));
if ( (('desc') == deAspis(get_option(array('comment_order',false)))))
 $comment_order = concat2($comment_order,' selected="selected"');
$comment_order = concat($comment_order,concat2(concat1('>',__(array('newer',false))),'</option></select>'));
printf(deAspis(__(array('Comments should be displayed with the %s comments at the top of each page',false))),deAspisRC($comment_order));
;
?></label>
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('E-mail me whenever',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('E-mail me whenever',false));
?></span></legend>
<label for="comments_notify">
<input name="comments_notify" type="checkbox" id="comments_notify" value="1" <?php checked(array('1',false),get_option(array('comments_notify',false)));
;
?> />
<?php _e(array('Anyone posts a comment',false));
?> </label>
<br />
<label for="moderation_notify">
<input name="moderation_notify" type="checkbox" id="moderation_notify" value="1" <?php checked(array('1',false),get_option(array('moderation_notify',false)));
;
?> />
<?php _e(array('A comment is held for moderation',false));
?> </label>
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('Before a comment appears',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Before a comment appears',false));
?></span></legend>
<label for="comment_moderation">
<input name="comment_moderation" type="checkbox" id="comment_moderation" value="1" <?php checked(array('1',false),get_option(array('comment_moderation',false)));
;
?> />
<?php _e(array('An administrator must always approve the comment',false));
?> </label>
<br />
<label for="comment_whitelist"><input type="checkbox" name="comment_whitelist" id="comment_whitelist" value="1" <?php checked(array('1',false),get_option(array('comment_whitelist',false)));
;
?> /> <?php _e(array('Comment author must have a previously approved comment',false));
?></label>
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('Comment Moderation',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Comment Moderation',false));
?></span></legend>
<p><label for="comment_max_links"><?php printf(deAspis(__(array('Hold a comment in the queue if it contains %s or more links. (A common characteristic of comment spam is a large number of hyperlinks.)',false))),(deconcat2(concat1('<input name="comment_max_links" type="text" id="comment_max_links" value="',esc_attr(get_option(array('comment_max_links',false)))),'" class="small-text" />')));
?></label></p>

<p><label for="moderation_keys"><?php _e(array('When a comment contains any of these words in its content, name, URL, e-mail, or IP, it will be held in the <a href="edit-comments.php?comment_status=moderated">moderation queue</a>. One word or IP per line. It will match inside words, so &#8220;press&#8221; will match &#8220;WordPress&#8221;.',false));
?></label></p>
<p>
<textarea name="moderation_keys" rows="10" cols="50" id="moderation_keys" class="large-text code"><?php form_option(array('moderation_keys',false));
;
?></textarea>
</p>
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('Comment Blacklist',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Comment Blacklist',false));
?></span></legend>
<p><label for="blacklist_keys"><?php _e(array('When a comment contains any of these words in its content, name, URL, e-mail, or IP, it will be marked as spam. One word or IP per line. It will match inside words, so &#8220;press&#8221; will match &#8220;WordPress&#8221;.',false));
?></label></p>
<p>
<textarea name="blacklist_keys" rows="10" cols="50" id="blacklist_keys" class="large-text code"><?php form_option(array('blacklist_keys',false));
;
?></textarea>
</p>
</fieldset></td>
</tr>
<?php do_settings_fields(array('discussion',false),array('default',false));
;
?>
</table>

<h3><?php _e(array('Avatars',false));
?></h3>

<p><?php _e(array('An avatar is an image that follows you from weblog to weblog appearing beside your name when you comment on avatar enabled sites.  Here you can enable the display of avatars for people who comment on your blog.',false));
;
?></p>

<?php ;
?>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e(array('Avatar Display',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Avatar display',false));
?></span></legend>
<?php $yesorno = array(array(deregisterTaint(array(0,false)) => addTaint(__(array("Don&#8217;t show Avatars",false))),deregisterTaint(array(1,false)) => addTaint(__(array('Show Avatars',false)))),false);
foreach ( $yesorno[0] as $key =>$value )
{restoreTaint($key,$value);
{$selected = (deAspis(get_option(array('show_avatars',false))) == $key[0]) ? array('checked="checked"',false) : array('',false);
echo AspisCheckPrint(concat(concat1("\n\t<label><input type='radio' name='show_avatars' value='",esc_attr($key)),concat2(concat(concat2(concat1("' ",$selected),"/> "),$value),"</label><br />")));
}};
?>
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('Maximum Rating',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Maximum Rating',false));
?></span></legend>

<?php $ratings = array(array(deregisterTaint(array('G',false)) => addTaint(__(array('G &#8212; Suitable for all audiences',false))),deregisterTaint(array('PG',false)) => addTaint(__(array('PG &#8212; Possibly offensive, usually for audiences 13 and above',false))),deregisterTaint(array('R',false)) => addTaint(__(array('R &#8212; Intended for adult audiences above 17',false))),deregisterTaint(array('X',false)) => addTaint(__(array('X &#8212; Even more mature than above',false)))),false);
foreach ( $ratings[0] as $key =>$rating )
{restoreTaint($key,$rating);
{$selected = (deAspis(get_option(array('avatar_rating',false))) == $key[0]) ? array('checked="checked"',false) : array('',false);
echo AspisCheckPrint(concat(concat1("\n\t<label><input type='radio' name='avatar_rating' value='",esc_attr($key)),concat2(concat(concat2(concat1("' ",$selected),"/> "),$rating),"</label><br />")));
}};
?>

</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('Default Avatar',false));
?></th>
<td class="defaultavatarpicker"><fieldset><legend class="screen-reader-text"><span><?php _e(array('Default Avatar',false));
?></span></legend>

<?php _e(array('For users without a custom avatar of their own, you can either display a generic logo or a generated one based on their e-mail address.',false));
;
?><br />

<?php $avatar_defaults = array(array(deregisterTaint(array('mystery',false)) => addTaint(__(array('Mystery Man',false))),deregisterTaint(array('blank',false)) => addTaint(__(array('Blank',false))),deregisterTaint(array('gravatar_default',false)) => addTaint(__(array('Gravatar Logo',false))),deregisterTaint(array('identicon',false)) => addTaint(__(array('Identicon (Generated)',false))),deregisterTaint(array('wavatar',false)) => addTaint(__(array('Wavatar (Generated)',false))),deregisterTaint(array('monsterid',false)) => addTaint(__(array('MonsterID (Generated)',false)))),false);
$avatar_defaults = apply_filters(array('avatar_defaults',false),$avatar_defaults);
$default = get_option(array('avatar_default',false));
if ( ((empty($default) || Aspis_empty( $default))))
 $default = array('mystery',false);
$size = array(32,false);
$avatar_list = array('',false);
foreach ( $avatar_defaults[0] as $default_key =>$default_name )
{restoreTaint($default_key,$default_name);
{$selected = ($default[0] == $default_key[0]) ? array('checked="checked" ',false) : array('',false);
$avatar_list = concat($avatar_list,concat(concat(concat2(concat1("\n\t<label><input type='radio' name='avatar_default' id='avatar_",$default_key),"' value='"),esc_attr($default_key)),concat2(concat1("' ",$selected),"/> ")));
$avatar = get_avatar($user_email,$size,$default_key);
$avatar_list = concat($avatar_list,Aspis_preg_replace(array("/src='(.+?)'/",false),array("src='\$1&amp;forcedefault=1'",false),$avatar));
$avatar_list = concat($avatar_list,concat2(concat1(' ',$default_name),'</label>'));
$avatar_list = concat2($avatar_list,'<br />');
}}echo AspisCheckPrint(apply_filters(array('default_avatar_select',false),$avatar_list));
;
?>

</fieldset></td>
</tr>
<?php do_settings_fields(array('discussion',false),array('avatars',false));
;
?>
</table>

<?php do_settings_sections(array('discussion',false));
;
?>

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e(array('Save Changes',false));
?>" />
</p>
</form>
</div>

<?php include ('./admin-footer.php');
;
?>
<?php 