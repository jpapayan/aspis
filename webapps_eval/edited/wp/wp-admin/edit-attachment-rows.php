<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit(array('-1',false));
if ( deAspis(have_posts()))
 {;
?>
<table class="widefat fixed" cellspacing="0">
	<thead>
	<tr>
<?php print_column_headers(array('upload',false));
;
?>
	</tr>
	</thead>

	<tfoot>
	<tr>
<?php print_column_headers(array('upload',false),array(false,false));
;
?>
	</tr>
	</tfoot>

	<tbody id="the-list" class="list:post">
<?php add_filter(array('the_title',false),array('esc_html',false));
$alt = array('',false);
$posts_columns = get_column_headers(array('upload',false));
$hidden = get_hidden_columns(array('upload',false));
while ( deAspis(have_posts()) )
{the_post();
if ( ($is_trash[0] && ($post[0]->post_status[0] != ('trash'))))
 continue ;
elseif ( ((denot_boolean($is_trash)) && ($post[0]->post_status[0] == ('trash'))))
 continue ;
$alt = (('alternate') == $alt[0]) ? array('',false) : array('alternate',false);
global $current_user;
$post_owner = (($current_user[0]->ID[0] == $post[0]->post_author[0]) ? array('self',false) : array('other',false));
$att_title = _draft_or_post_title();
;
?>
	<tr id='post-<?php echo AspisCheckPrint($id);
;
?>' class='<?php echo AspisCheckPrint(Aspis_trim(concat(concat2(concat(concat2($alt,' author-'),$post_owner),' status-'),$post[0]->post_status)));
;
?>' valign="top">

<?php foreach ( $posts_columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{$class = concat2(concat(concat2(concat1("class=\"",$column_name)," column-"),$column_name),"\"");
$style = array('',false);
if ( deAspis(Aspis_in_array($column_name,$hidden)))
 $style = array(' style="display:none;"',false);
$attributes = concat($class,$style);
switch ( $column_name[0] ) {
case ('cb'):;
?>
		<th scope="row" class="check-column"><?php if ( deAspis(current_user_can(array('edit_post',false),$post[0]->ID)))
 {;
?><input type="checkbox" name="media[]" value="<?php the_ID();
;
?>" /><?php };
?></th>
		<?php break ;
case ('icon'):$attributes = concat1('class="column-icon media-icon"',$style);
;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><?php if ( deAspis($thumb = wp_get_attachment_image($post[0]->ID,array(array(array(80,false),array(60,false)),false),array(true,false))))
 {if ( $is_trash[0])
 echo AspisCheckPrint($thumb);
else 
{{;
?>
				<a href="media.php?action=edit&amp;attachment_id=<?php the_ID();
;
?>" title="<?php echo AspisCheckPrint(esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$att_title)));
;
?>">
					<?php echo AspisCheckPrint($thumb);
;
?>
				</a>

<?php }}};
?></td>
		<?php break ;
case ('media'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><strong><?php if ( $is_trash[0])
 echo AspisCheckPrint($att_title);
else 
{{;
?><a href="<?php echo AspisCheckPrint(get_edit_post_link($post[0]->ID));
;
?>" title="<?php echo AspisCheckPrint(esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$att_title)));
;
?>"><?php echo AspisCheckPrint($att_title);
;
?></a><?php }};
?></strong><br />
		<?php echo AspisCheckPrint(Aspis_strtoupper(Aspis_preg_replace(array('/^.*?\.(\w+)$/',false),array('$1',false),get_attached_file($post[0]->ID))));
;
?>
		<p>
		<?php $actions = array(array(),false);
if ( (deAspis(current_user_can(array('edit_post',false),$post[0]->ID)) && (denot_boolean($is_trash))))
 arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat1('<a href="',get_edit_post_link($post[0]->ID,array(true,false))),'">'),__(array('Edit',false))),'</a>')));
if ( deAspis(current_user_can(array('delete_post',false),$post[0]->ID)))
 {if ( $is_trash[0])
 arrayAssign($actions[0],deAspis(registerTaint(array('untrash',false))),addTaint(concat2(concat(concat2(concat1("<a class='submitdelete' href='",wp_nonce_url(concat1("post.php?action=untrash&amp;post=",$post[0]->ID),concat1('untrash-post_',$post[0]->ID))),"'>"),__(array('Restore',false))),"</a>")));
elseif ( (EMPTY_TRASH_DAYS && MEDIA_TRASH))
 arrayAssign($actions[0],deAspis(registerTaint(array('trash',false))),addTaint(concat2(concat(concat2(concat1("<a class='submitdelete' href='",wp_nonce_url(concat1("post.php?action=trash&amp;post=",$post[0]->ID),concat1('trash-post_',$post[0]->ID))),"'>"),__(array('Trash',false))),"</a>")));
if ( (($is_trash[0] || (!(EMPTY_TRASH_DAYS))) || (!(MEDIA_TRASH))))
 {$delete_ays = ((denot_boolean($is_trash)) && (!(MEDIA_TRASH))) ? array(" onclick='return showNotice.warn();'",false) : array('',false);
arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a class='submitdelete'",$delete_ays)," href='"),wp_nonce_url(concat1("post.php?action=delete&amp;post=",$post[0]->ID),concat1('delete-post_',$post[0]->ID))),"'>"),__(array('Delete Permanently',false))),"</a>")));
}}if ( (denot_boolean($is_trash)))
 arrayAssign($actions[0],deAspis(registerTaint(array('view',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_permalink($post[0]->ID)),'" title="'),esc_attr(Aspis_sprintf(__(array('View &#8220;%s&#8221;',false)),$title))),'" rel="permalink">'),__(array('View',false))),'</a>')));
$actions = apply_filters(array('media_row_actions',false),$actions,$post);
$action_count = attAspis(count($actions[0]));
$i = array(0,false);
echo AspisCheckPrint(array('<div class="row-actions">',false));
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{preincr($i);
($i[0] == $action_count[0]) ? $sep = array('',false) : $sep = array(' | ',false);
echo AspisCheckPrint(concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$link),$sep),"</span>"));
}}echo AspisCheckPrint(array('</div>',false));
;
?></p></td>
		<?php break ;
case ('author'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><?php the_author();
?></td>
		<?php break ;
case ('tags'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><?php $tags = get_the_tags();
if ( (!((empty($tags) || Aspis_empty( $tags)))))
 {$out = array(array(),false);
foreach ( $tags[0] as $c  )
arrayAssignAdd($out[0][],addTaint(concat2(concat(concat2(concat1("<a href='edit.php?tag=",$c[0]->slug),"'> "),esc_html(sanitize_term_field(array('name',false),$c[0]->name,$c[0]->term_id,array('post_tag',false),array('display',false)))),"</a>")));
echo AspisCheckPrint(Aspis_join(array(', ',false),$out));
}else 
{{_e(array('No Tags',false));
}};
?></td>
		<?php break ;
case ('desc'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><?php echo AspisCheckPrint(deAspis(has_excerpt()) ? $post[0]->post_excerpt : array('',false));
;
?></td>
		<?php break ;
case ('date'):if ( ((('0000-00-00 00:00:00') == $post[0]->post_date[0]) && (('date') == $column_name[0])))
 {$t_time = $h_time = __(array('Unpublished',false));
}else 
{{$t_time = get_the_time(__(array('Y/m/d g:i:s A',false)));
$m_time = $post[0]->post_date;
$time = get_post_time(array('G',false),array(true,false),$post,array(false,false));
if ( (deAspis((Aspis_abs($t_diff = array(time() - $time[0],false)))) < (86400)))
 {if ( ($t_diff[0] < (0)))
 $h_time = Aspis_sprintf(__(array('%s from now',false)),human_time_diff($time));
else 
{$h_time = Aspis_sprintf(__(array('%s ago',false)),human_time_diff($time));
}}else 
{{$h_time = mysql2date(__(array('Y/m/d',false)),$m_time);
}}}};
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><?php echo AspisCheckPrint($h_time);
?></td>
		<?php break ;
case ('parent'):if ( ($post[0]->post_parent[0] > (0)))
 {if ( deAspis(get_post($post[0]->post_parent)))
 {$title = _draft_or_post_title($post[0]->post_parent);
};
?>
			<td <?php echo AspisCheckPrint($attributes);
?>><strong><a href="<?php echo AspisCheckPrint(get_edit_post_link($post[0]->post_parent));
;
?>"><?php echo AspisCheckPrint($title);
?></a></strong>, <?php echo AspisCheckPrint(get_the_time(__(array('Y/m/d',false))));
;
?></td>
			<?php }else 
{{;
?>
			<td <?php echo AspisCheckPrint($attributes);
?>><?php _e(array('(Unattached)',false));
;
?><br />
			<a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo AspisCheckPrint($post[0]->ID);
?>');return false;" href="#the-list"><?php _e(array('Attach',false));
;
?></a></td>
			<?php }}break ;
case ('comments'):$attributes = concat1('class="comments column-comments num"',$style);
;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><div class="post-com-count-wrapper">
		<?php $left = get_pending_comments_num($post[0]->ID);
$pending_phrase = Aspis_sprintf(__(array('%s pending',false)),attAspis(number_format($left[0])));
if ( $left[0])
 echo AspisCheckPrint(array('<strong>',false));
comments_number(concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$id),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('0',false),array('comment count',false))),'</span></a>'),concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$id),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('1',false),array('comment count',false))),'</span></a>'),concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$id),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('%',false),array('comment count',false))),'</span></a>'));
if ( $left[0])
 echo AspisCheckPrint(array('</strong>',false));
;
?>
		</div></td>
		<?php break ;
case ('actions'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>>
		<a href="media.php?action=edit&amp;attachment_id=<?php the_ID();
;
?>" title="<?php echo AspisCheckPrint(esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$att_title)));
;
?>"><?php _e(array('Edit',false));
;
?></a> |
		<a href="<?php the_permalink();
;
?>"><?php _e(array('Get permalink',false));
;
?></a>
		</td>
		<?php break ;
default :;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><?php do_action(array('manage_media_custom_column',false),$column_name,$id);
;
?></td>
		<?php break ;
 }
}};
?>
	</tr>
<?php };
?>
	</tbody>
</table>
<?php }else 
{{;
?>

<p><?php _e(array('No media attachments found.',false));
?></p>

<?php }};
?>

<?php 