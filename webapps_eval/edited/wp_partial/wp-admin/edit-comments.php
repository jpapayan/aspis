<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( !current_user_can('edit_posts'))
 wp_die(__('Cheatin&#8217; uh?'));
wp_enqueue_script('admin-comments');
enqueue_comment_hotkeys_js();
$post_id = (isset($_REQUEST[0]['p']) && Aspis_isset($_REQUEST[0]['p'])) ? (int)deAspisWarningRC($_REQUEST[0]['p']) : 0;
if ( (isset($_REQUEST[0]['doaction']) && Aspis_isset($_REQUEST[0]['doaction'])) || (isset($_REQUEST[0]['doaction2']) && Aspis_isset($_REQUEST[0]['doaction2'])) || (isset($_REQUEST[0]['delete_all']) && Aspis_isset($_REQUEST[0]['delete_all'])) || (isset($_REQUEST[0]['delete_all2']) && Aspis_isset($_REQUEST[0]['delete_all2'])))
 {check_admin_referer('bulk-comments');
if ( ((isset($_REQUEST[0]['delete_all']) && Aspis_isset($_REQUEST[0]['delete_all'])) || (isset($_REQUEST[0]['delete_all2']) && Aspis_isset($_REQUEST[0]['delete_all2']))) && !(empty($_REQUEST[0]['pagegen_timestamp']) || Aspis_empty($_REQUEST[0]['pagegen_timestamp'])))
 {$comment_status = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(deAspisWarningRC($_REQUEST[0]['comment_status']))),array(0));
$delete_time = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(deAspisWarningRC($_REQUEST[0]['pagegen_timestamp']))),array(0));
$comment_ids = $wpdb->get_col("SELECT comment_ID FROM $wpdb->comments WHERE comment_approved = '$comment_status' AND '$delete_time' > comment_date_gmt");
$doaction = 'delete';
}elseif ( (deAspisWarningRC($_REQUEST[0]['action']) != -1 || deAspisWarningRC($_REQUEST[0]['action2']) != -1) && (isset($_REQUEST[0]['delete_comments']) && Aspis_isset($_REQUEST[0]['delete_comments'])))
 {$comment_ids = deAspisWarningRC($_REQUEST[0]['delete_comments']);
$doaction = (deAspisWarningRC($_REQUEST[0]['action']) != -1) ? deAspisWarningRC($_REQUEST[0]['action']) : deAspisWarningRC($_REQUEST[0]['action2']);
}elseif ( deAspisWarningRC($_REQUEST[0]['doaction']) == 'undo' && (isset($_REQUEST[0]['ids']) && Aspis_isset($_REQUEST[0]['ids'])))
 {$comment_ids = array_map('absint',explode(',',deAspisWarningRC($_REQUEST[0]['ids'])));
$doaction = deAspisWarningRC($_REQUEST[0]['action']);
}else 
{{wp_redirect(deAspisWarningRC($_SERVER[0]['HTTP_REFERER']));
}}$approved = $unapproved = $spammed = $unspammed = $trashed = $untrashed = $deleted = 0;
foreach ( $comment_ids as $comment_id  )
{$_post_id = (int)$wpdb->get_var($wpdb->prepare("SELECT comment_post_ID FROM $wpdb->comments WHERE comment_ID = %d",$comment_id));
if ( !current_user_can('edit_post',$_post_id))
 continue ;
switch ( $doaction ) {
case 'approve':wp_set_comment_status($comment_id,'approve');
$approved++;
break ;
case 'unapprove':wp_set_comment_status($comment_id,'hold');
$unapproved++;
break ;
case 'spam':wp_spam_comment($comment_id);
$spammed++;
break ;
case 'unspam':wp_unspam_comment($comment_id);
$unspammed++;
break ;
case 'trash':wp_trash_comment($comment_id);
$trashed++;
break ;
case 'untrash':wp_untrash_comment($comment_id);
$untrashed++;
break ;
case 'delete':wp_delete_comment($comment_id);
$deleted++;
break ;
 }
}$redirect_to = 'edit-comments.php';
if ( $approved)
 $redirect_to = add_query_arg('approved',$approved,$redirect_to);
if ( $unapproved)
 $redirect_to = add_query_arg('unapproved',$unapproved,$redirect_to);
if ( $spammed)
 $redirect_to = add_query_arg('spammed',$spammed,$redirect_to);
if ( $unspammed)
 $redirect_to = add_query_arg('unspammed',$unspammed,$redirect_to);
if ( $trashed)
 $redirect_to = add_query_arg('trashed',$trashed,$redirect_to);
if ( $untrashed)
 $redirect_to = add_query_arg('untrashed',$untrashed,$redirect_to);
if ( $deleted)
 $redirect_to = add_query_arg('deleted',$deleted,$redirect_to);
if ( $trashed || $spammed)
 $redirect_to = add_query_arg('ids',join(',',$comment_ids),$redirect_to);
if ( $post_id)
 $redirect_to = add_query_arg('p',absint($post_id),$redirect_to);
if ( (isset($_REQUEST[0]['apage']) && Aspis_isset($_REQUEST[0]['apage'])))
 $redirect_to = add_query_arg('apage',absint(deAspisWarningRC($_REQUEST[0]['apage'])),$redirect_to);
if ( !(empty($_REQUEST[0]['mode']) || Aspis_empty($_REQUEST[0]['mode'])))
 $redirect_to = add_query_arg('mode',deAspisWarningRC($_REQUEST[0]['mode']),$redirect_to);
if ( !(empty($_REQUEST[0]['comment_status']) || Aspis_empty($_REQUEST[0]['comment_status'])))
 $redirect_to = add_query_arg('comment_status',deAspisWarningRC($_REQUEST[0]['comment_status']),$redirect_to);
if ( !(empty($_REQUEST[0]['s']) || Aspis_empty($_REQUEST[0]['s'])))
 $redirect_to = add_query_arg('s',deAspisWarningRC($_REQUEST[0]['s']),$redirect_to);
wp_redirect($redirect_to);
}elseif ( (isset($_GET[0]['_wp_http_referer']) && Aspis_isset($_GET[0]['_wp_http_referer'])) && !(empty($_GET[0]['_wp_http_referer']) || Aspis_empty($_GET[0]['_wp_http_referer'])))
 {wp_redirect(remove_query_arg(array('_wp_http_referer','_wpnonce'),stripslashes(deAspisWarningRC($_SERVER[0]['REQUEST_URI']))));
exit();
}if ( $post_id)
 $title = sprintf(__('Edit Comments on &#8220;%s&#8221;'),wp_html_excerpt(_draft_or_post_title($post_id),50));
else 
{$title = __('Edit Comments');
}require_once ('admin-header.php');
$mode = (!(isset($_GET[0]['mode']) && Aspis_isset($_GET[0]['mode'])) || (empty($_GET[0]['mode']) || Aspis_empty($_GET[0]['mode']))) ? 'detail' : esc_attr(deAspisWarningRC($_GET[0]['mode']));
$comment_status = (isset($_REQUEST[0]['comment_status']) && Aspis_isset($_REQUEST[0]['comment_status'])) ? deAspisWarningRC($_REQUEST[0]['comment_status']) : 'all';
if ( !in_array($comment_status,array('all','moderated','approved','spam','trash')))
 $comment_status = 'all';
$comment_type = !(empty($_GET[0]['comment_type']) || Aspis_empty($_GET[0]['comment_type'])) ? esc_attr(deAspisWarningRC($_GET[0]['comment_type'])) : '';
$search_dirty = ((isset($_GET[0]['s']) && Aspis_isset($_GET[0]['s']))) ? deAspisWarningRC($_GET[0]['s']) : '';
$search = esc_attr($search_dirty);
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo esc_html($title);
if ( (isset($_GET[0]['s']) && Aspis_isset($_GET[0]['s'])) && deAspisWarningRC($_GET[0]['s']))
 printf('<span class="subtitle">' . sprintf(__('Search results for &#8220;%s&#8221;'),wp_html_excerpt(esc_html(stripslashes(deAspisWarningRC($_GET[0]['s']))),50)) . '</span>');
;
?>
</h2>

<?php if ( (isset($_GET[0]['approved']) && Aspis_isset($_GET[0]['approved'])) || (isset($_GET[0]['deleted']) && Aspis_isset($_GET[0]['deleted'])) || (isset($_GET[0]['trashed']) && Aspis_isset($_GET[0]['trashed'])) || (isset($_GET[0]['untrashed']) && Aspis_isset($_GET[0]['untrashed'])) || (isset($_GET[0]['spammed']) && Aspis_isset($_GET[0]['spammed'])) || (isset($_GET[0]['unspammed']) && Aspis_isset($_GET[0]['unspammed'])))
 {$approved = (isset($_GET[0]['approved']) && Aspis_isset($_GET[0]['approved'])) ? (int)deAspisWarningRC($_GET[0]['approved']) : 0;
$deleted = (isset($_GET[0]['deleted']) && Aspis_isset($_GET[0]['deleted'])) ? (int)deAspisWarningRC($_GET[0]['deleted']) : 0;
$trashed = (isset($_GET[0]['trashed']) && Aspis_isset($_GET[0]['trashed'])) ? (int)deAspisWarningRC($_GET[0]['trashed']) : 0;
$untrashed = (isset($_GET[0]['untrashed']) && Aspis_isset($_GET[0]['untrashed'])) ? (int)deAspisWarningRC($_GET[0]['untrashed']) : 0;
$spammed = (isset($_GET[0]['spammed']) && Aspis_isset($_GET[0]['spammed'])) ? (int)deAspisWarningRC($_GET[0]['spammed']) : 0;
$unspammed = (isset($_GET[0]['unspammed']) && Aspis_isset($_GET[0]['unspammed'])) ? (int)deAspisWarningRC($_GET[0]['unspammed']) : 0;
if ( $approved > 0 || $deleted > 0 || $trashed > 0 || $untrashed > 0 || $spammed > 0 || $unspammed > 0)
 {echo '<div id="moderated" class="updated fade"><p>';
if ( $approved > 0)
 {printf(_n('%s comment approved','%s comments approved',$approved),$approved);
echo '<br />';
}if ( $spammed > 0)
 {printf(_n('%s comment marked as spam.','%s comments marked as spam.',$spammed),$spammed);
$ids = (isset($_GET[0]['ids']) && Aspis_isset($_GET[0]['ids'])) ? deAspisWarningRC($_GET[0]['ids']) : 0;
echo ' <a href="' . esc_url(wp_nonce_url("edit-comments.php?doaction=undo&action=unspam&ids=$ids","bulk-comments")) . '">' . __('Undo') . '</a><br />';
}if ( $unspammed > 0)
 {printf(_n('%s comment restored from the spam','%s comments restored from the spam',$unspammed),$unspammed);
echo '<br />';
}if ( $trashed > 0)
 {printf(_n('%s comment moved to the trash.','%s comments moved to the trash.',$trashed),$trashed);
$ids = (isset($_GET[0]['ids']) && Aspis_isset($_GET[0]['ids'])) ? deAspisWarningRC($_GET[0]['ids']) : 0;
echo ' <a href="' . esc_url(wp_nonce_url("edit-comments.php?doaction=undo&action=untrash&ids=$ids","bulk-comments")) . '">' . __('Undo') . '</a><br />';
}if ( $untrashed > 0)
 {printf(_n('%s comment restored from the trash','%s comments restored from the trash',$untrashed),$untrashed);
echo '<br />';
}if ( $deleted > 0)
 {printf(_n('%s comment permanently deleted','%s comments permanently deleted',$deleted),$deleted);
echo '<br />';
}echo '</p></div>';
}};
?>

<form id="comments-form" action="" method="get">
<ul class="subsubsub">
<?php $status_links = array();
$num_comments = ($post_id) ? wp_count_comments($post_id) : wp_count_comments();
$stati = array('all' => _n_noop('All','All'),'moderated' => _n_noop('Pending <span class="count">(<span class="pending-count">%s</span>)</span>','Pending <span class="count">(<span class="pending-count">%s</span>)</span>'),'approved' => _n_noop('Approved','Approved'),'spam' => _n_noop('Spam <span class="count">(<span class="spam-count">%s</span>)</span>','Spam <span class="count">(<span class="spam-count">%s</span>)</span>'),'trash' => _n_noop('Trash <span class="count">(<span class="trash-count">%s</span>)</span>','Trash <span class="count">(<span class="trash-count">%s</span>)</span>'));
if ( !EMPTY_TRASH_DAYS)
 unset($stati['trash']);
$link = 'edit-comments.php';
if ( !empty($comment_type) && 'all' != $comment_type)
 $link = add_query_arg('comment_type',$comment_type,$link);
foreach ( $stati as $status =>$label )
{$class = '';
if ( $status == $comment_status)
 $class = ' class="current"';
if ( !isset($num_comments->$status))
 $num_comments->$status = 10;
$link = add_query_arg('comment_status',$status,$link);
if ( $post_id)
 $link = add_query_arg('p',absint($post_id),$link);
$status_links[] = "<li class='$status'><a href='$link'$class>" . sprintf(_n($label[0],$label[1],$num_comments->$status),number_format_i18n($num_comments->$status)) . '</a>';
}$status_links = apply_filters('comment_status_links',$status_links);
echo implode(" |</li>\n",$status_links) . '</li>';
unset($status_links);
;
?>
</ul>

<p class="search-box">
	<label class="screen-reader-text" for="comment-search-input"><?php _e('Search Comments');
;
?>:</label>
	<input type="text" id="comment-search-input" name="s" value="<?php _admin_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e('Search Comments');
;
?>" class="button" />
</p>

<?php $comments_per_page = (int)get_user_option('edit_comments_per_page',0,false);
if ( empty($comments_per_page) || $comments_per_page < 1)
 $comments_per_page = 20;
$comments_per_page = apply_filters('comments_per_page',$comments_per_page,$comment_status);
if ( (isset($_GET[0]['apage']) && Aspis_isset($_GET[0]['apage'])))
 $page = abs((int)deAspisWarningRC($_GET[0]['apage']));
else 
{$page = 1;
}$start = $offset = ($page - 1) * $comments_per_page;
list($_comments,$total) = _wp_get_comment_list($comment_status,$search_dirty,$start,$comments_per_page + 8,$post_id,$comment_type);
$_comment_post_ids = array();
foreach ( $_comments as $_c  )
{$_comment_post_ids[] = $_c->comment_post_ID;
}$_comment_pending_count_temp = (array)get_pending_comments_num($_comment_post_ids);
foreach ( (array)$_comment_post_ids as $_cpid  )
$_comment_pending_count[$_cpid] = isset($_comment_pending_count_temp[$_cpid]) ? $_comment_pending_count_temp[$_cpid] : 0;
if ( empty($_comment_pending_count))
 $_comment_pending_count = array();
$comments = array_slice($_comments,0,$comments_per_page);
$extra_comments = array_slice($_comments,$comments_per_page);
$page_links = paginate_links(array('base' => add_query_arg('apage','%#%'),'format' => '','prev_text' => __('&laquo;'),'next_text' => __('&raquo;'),'total' => ceil($total / $comments_per_page),'current' => $page));
;
?>

<input type="hidden" name="mode" value="<?php echo esc_attr($mode);
;
?>" />
<?php if ( $post_id)
 {;
?>
<input type="hidden" name="p" value="<?php echo esc_attr(intval($post_id));
;
?>" />
<?php };
?>
<input type="hidden" name="comment_status" value="<?php echo esc_attr($comment_status);
;
?>" />
<input type="hidden" name="pagegen_timestamp" value="<?php echo esc_attr(current_time('mysql',1));
;
?>" />

<div class="tablenav">

<?php if ( $page_links)
 {;
?>
<div class="tablenav-pages"><?php $page_links_text = sprintf('<span class="displaying-num">' . __('Displaying %s&#8211;%s of %s') . '</span>%s',number_format_i18n($start + 1),number_format_i18n(min($page * $comments_per_page,$total)),'<span class="total-type-count">' . number_format_i18n($total) . '</span>',$page_links);
echo $page_links_text;
;
?></div>
<input type="hidden" name="_total" value="<?php echo esc_attr($total);
;
?>" />
<input type="hidden" name="_per_page" value="<?php echo esc_attr($comments_per_page);
;
?>" />
<input type="hidden" name="_page" value="<?php echo esc_attr($page);
;
?>" />
<?php };
?>

<div class="alignleft actions">
<select name="action">
<option value="-1" selected="selected"><?php _e('Bulk Actions');
?></option>
<?php if ( 'all' == $comment_status || 'approved' == $comment_status)
 {;
?>
<option value="unapprove"><?php _e('Unapprove');
;
?></option>
<?php };
?>
<?php if ( 'all' == $comment_status || 'moderated' == $comment_status || 'spam' == $comment_status)
 {;
?>
<option value="approve"><?php _e('Approve');
;
?></option>
<?php };
?>
<?php if ( 'all' == $comment_status || 'approved' == $comment_status || 'moderated' == $comment_status)
 {;
?>
<option value="spam"><?php _e('Mark as Spam');
;
?></option>
<?php };
?>
<?php if ( 'trash' == $comment_status)
 {;
?>
<option value="untrash"><?php _e('Restore');
;
?></option>
<?php }elseif ( 'spam' == $comment_status)
 {;
?>
<option value="unspam"><?php _e('Not Spam');
;
?></option>
<?php };
?>
<?php if ( 'trash' == $comment_status || 'spam' == $comment_status || !EMPTY_TRASH_DAYS)
 {;
?>
<option value="delete"><?php _e('Delete Permanently');
;
?></option>
<?php }else 
{;
?>
<option value="trash"><?php _e('Move to Trash');
;
?></option>
<?php };
?>
</select>
<input type="submit" name="doaction" id="doaction" value="<?php esc_attr_e('Apply');
;
?>" class="button-secondary apply" />
<?php wp_nonce_field('bulk-comments');
;
?>

<select name="comment_type">
	<option value="all"><?php _e('Show all comment types');
;
?></option>
<?php $comment_types = apply_filters('admin_comment_types_dropdown',array('comment' => __('Comments'),'pings' => __('Pings'),));
foreach ( $comment_types as $type =>$label )
{echo "	<option value='" . esc_attr($type) . "'";
selected($comment_type,$type);
echo ">$label</option>\n";
};
?>
</select>
<input type="submit" id="post-query-submit" value="<?php esc_attr_e('Filter');
;
?>" class="button-secondary" />

<?php if ( (isset($_GET[0]['apage']) && Aspis_isset($_GET[0]['apage'])))
 {;
?>
	<input type="hidden" name="apage" value="<?php echo esc_attr(absint(deAspisWarningRC($_GET[0]['apage'])));
;
?>" />
<?php }if ( ('spam' == $comment_status || 'trash' == $comment_status) && current_user_can('moderate_comments'))
 {wp_nonce_field('bulk-destroy','_destroy_nonce');
if ( 'spam' == $comment_status && current_user_can('moderate_comments'))
 {;
?>
		<input type="submit" name="delete_all" id="delete_all" value="<?php esc_attr_e('Empty Spam');
;
?>" class="button-secondary apply" />
<?php }elseif ( 'trash' == $comment_status && current_user_can('moderate_comments'))
 {;
?>
		<input type="submit" name="delete_all" id="delete_all" value="<?php esc_attr_e('Empty Trash');
;
?>" class="button-secondary apply" />
<?php }};
?>
<?php do_action('manage_comments_nav',$comment_status);
;
?>
</div>

<br class="clear" />

</div>

<div class="clear"></div>

<?php if ( $comments)
 {;
?>
<table class="widefat comments fixed" cellspacing="0">
<thead>
	<tr>
<?php print_column_headers('edit-comments');
;
?>
	</tr>
</thead>

<tfoot>
	<tr>
<?php print_column_headers('edit-comments',false);
;
?>
	</tr>
</tfoot>

<tbody id="the-comment-list" class="list:comment">
<?php foreach ( $comments as $comment  )
_wp_comment_row($comment->comment_ID,$mode,$comment_status);
;
?>
</tbody>
<tbody id="the-extra-comment-list" class="list:comment" style="display: none;">
<?php foreach ( $extra_comments as $comment  )
_wp_comment_row($comment->comment_ID,$mode,$comment_status);
;
?>
</tbody>
</table>

<div class="tablenav">
<?php if ( $page_links)
 echo "<div class='tablenav-pages'>$page_links_text</div>";
;
?>

<div class="alignleft actions">
<select name="action2">
<option value="-1" selected="selected"><?php _e('Bulk Actions');
?></option>
<?php if ( 'all' == $comment_status || 'approved' == $comment_status)
 {;
?>
<option value="unapprove"><?php _e('Unapprove');
;
?></option>
<?php };
?>
<?php if ( 'all' == $comment_status || 'moderated' == $comment_status || 'spam' == $comment_status)
 {;
?>
<option value="approve"><?php _e('Approve');
;
?></option>
<?php };
?>
<?php if ( 'all' == $comment_status || 'approved' == $comment_status || 'moderated' == $comment_status)
 {;
?>
<option value="spam"><?php _e('Mark as Spam');
;
?></option>
<?php };
?>
<?php if ( 'trash' == $comment_status)
 {;
?>
<option value="untrash"><?php _e('Restore');
;
?></option>
<?php };
?>
<?php if ( 'trash' == $comment_status || 'spam' == $comment_status || !EMPTY_TRASH_DAYS)
 {;
?>
<option value="delete"><?php _e('Delete Permanently');
;
?></option>
<?php }elseif ( 'spam' == $comment_status)
 {;
?>
<option value="unspam"><?php _e('Not Spam');
;
?></option>
<?php }else 
{;
?>
<option value="trash"><?php _e('Move to Trash');
;
?></option>
<?php };
?>
</select>
<input type="submit" name="doaction2" id="doaction2" value="<?php esc_attr_e('Apply');
;
?>" class="button-secondary apply" />

<?php if ( 'spam' == $comment_status && current_user_can('moderate_comments'))
 {;
?>
<input type="submit" name="delete_all2" id="delete_all2" value="<?php esc_attr_e('Empty Spam');
;
?>" class="button-secondary apply" />
<?php }elseif ( 'trash' == $comment_status && current_user_can('moderate_comments'))
 {;
?>
<input type="submit" name="delete_all2" id="delete_all2" value="<?php esc_attr_e('Empty Trash');
;
?>" class="button-secondary apply" />
<?php };
?>
<?php do_action('manage_comments_nav',$comment_status);
;
?>
</div>

<br class="clear" />
</div>

</form>

<form id="get-extra-comments" method="post" action="" class="add:the-extra-comment-list:" style="display: none;">
	<input type="hidden" name="s" value="<?php echo esc_attr($search);
;
?>" />
	<input type="hidden" name="mode" value="<?php echo esc_attr($mode);
;
?>" />
	<input type="hidden" name="comment_status" value="<?php echo esc_attr($comment_status);
;
?>" />
	<input type="hidden" name="page" value="<?php echo esc_attr($page);
;
?>" />
	<input type="hidden" name="per_page" value="<?php echo esc_attr($comments_per_page);
;
?>" />
	<input type="hidden" name="p" value="<?php echo esc_attr($post_id);
;
?>" />
	<input type="hidden" name="comment_type" value="<?php echo esc_attr($comment_type);
;
?>" />
	<?php wp_nonce_field('add-comment','_ajax_nonce',false);
;
?>
</form>

<div id="ajax-response"></div>

<?php }elseif ( 'moderated' == $comment_status)
 {;
?>
<p><?php _e('No comments awaiting moderation&hellip; yet.');
?></p>
</form>

<?php }else 
{{;
?>
<p><?php _e('No results found.');
?></p>
</form>

<?php }};
?>
</div>

<?php wp_comment_reply('-1',true,'detail');
wp_comment_trashnotice();
include ('admin-footer.php');
;
?>
<?php 