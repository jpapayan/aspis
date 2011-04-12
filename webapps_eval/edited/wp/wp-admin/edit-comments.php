<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
wp_enqueue_script(array('admin-comments',false));
enqueue_comment_hotkeys_js();
$post_id = ((isset($_REQUEST[0][('p')]) && Aspis_isset( $_REQUEST [0][('p')]))) ? int_cast($_REQUEST[0]['p']) : array(0,false);
if ( (((((isset($_REQUEST[0][('doaction')]) && Aspis_isset( $_REQUEST [0][('doaction')]))) || ((isset($_REQUEST[0][('doaction2')]) && Aspis_isset( $_REQUEST [0][('doaction2')])))) || ((isset($_REQUEST[0][('delete_all')]) && Aspis_isset( $_REQUEST [0][('delete_all')])))) || ((isset($_REQUEST[0][('delete_all2')]) && Aspis_isset( $_REQUEST [0][('delete_all2')])))))
 {check_admin_referer(array('bulk-comments',false));
if ( ((((isset($_REQUEST[0][('delete_all')]) && Aspis_isset( $_REQUEST [0][('delete_all')]))) || ((isset($_REQUEST[0][('delete_all2')]) && Aspis_isset( $_REQUEST [0][('delete_all2')])))) && (!((empty($_REQUEST[0][('pagegen_timestamp')]) || Aspis_empty( $_REQUEST [0][('pagegen_timestamp')]))))))
 {$comment_status = $wpdb[0]->escape($_REQUEST[0]['comment_status']);
$delete_time = $wpdb[0]->escape($_REQUEST[0]['pagegen_timestamp']);
$comment_ids = $wpdb[0]->get_col(concat2(concat(concat2(concat(concat2(concat1("SELECT comment_ID FROM ",$wpdb[0]->comments)," WHERE comment_approved = '"),$comment_status),"' AND '"),$delete_time),"' > comment_date_gmt"));
$doaction = array('delete',false);
}elseif ( (((deAspis($_REQUEST[0]['action']) != deAspis(negate(array(1,false)))) || (deAspis($_REQUEST[0]['action2']) != deAspis(negate(array(1,false))))) && ((isset($_REQUEST[0][('delete_comments')]) && Aspis_isset( $_REQUEST [0][('delete_comments')])))))
 {$comment_ids = $_REQUEST[0]['delete_comments'];
$doaction = (deAspis($_REQUEST[0]['action']) != deAspis(negate(array(1,false)))) ? $_REQUEST[0]['action'] : $_REQUEST[0]['action2'];
}elseif ( ((deAspis($_REQUEST[0]['doaction']) == ('undo')) && ((isset($_REQUEST[0][('ids')]) && Aspis_isset( $_REQUEST [0][('ids')])))))
 {$comment_ids = attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC(Aspis_explode(array(',',false),$_REQUEST[0]['ids']))));
$doaction = $_REQUEST[0]['action'];
}else 
{{wp_redirect($_SERVER[0]['HTTP_REFERER']);
}}$approved = $unapproved = $spammed = $unspammed = $trashed = $untrashed = $deleted = array(0,false);
foreach ( $comment_ids[0] as $comment_id  )
{$_post_id = int_cast($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT comment_post_ID FROM ",$wpdb[0]->comments)," WHERE comment_ID = %d"),$comment_id)));
if ( (denot_boolean(current_user_can(array('edit_post',false),$_post_id))))
 continue ;
switch ( $doaction[0] ) {
case ('approve'):wp_set_comment_status($comment_id,array('approve',false));
postincr($approved);
break ;
case ('unapprove'):wp_set_comment_status($comment_id,array('hold',false));
postincr($unapproved);
break ;
case ('spam'):wp_spam_comment($comment_id);
postincr($spammed);
break ;
case ('unspam'):wp_unspam_comment($comment_id);
postincr($unspammed);
break ;
case ('trash'):wp_trash_comment($comment_id);
postincr($trashed);
break ;
case ('untrash'):wp_untrash_comment($comment_id);
postincr($untrashed);
break ;
case ('delete'):wp_delete_comment($comment_id);
postincr($deleted);
break ;
 }
}$redirect_to = array('edit-comments.php',false);
if ( $approved[0])
 $redirect_to = add_query_arg(array('approved',false),$approved,$redirect_to);
if ( $unapproved[0])
 $redirect_to = add_query_arg(array('unapproved',false),$unapproved,$redirect_to);
if ( $spammed[0])
 $redirect_to = add_query_arg(array('spammed',false),$spammed,$redirect_to);
if ( $unspammed[0])
 $redirect_to = add_query_arg(array('unspammed',false),$unspammed,$redirect_to);
if ( $trashed[0])
 $redirect_to = add_query_arg(array('trashed',false),$trashed,$redirect_to);
if ( $untrashed[0])
 $redirect_to = add_query_arg(array('untrashed',false),$untrashed,$redirect_to);
if ( $deleted[0])
 $redirect_to = add_query_arg(array('deleted',false),$deleted,$redirect_to);
if ( ($trashed[0] || $spammed[0]))
 $redirect_to = add_query_arg(array('ids',false),Aspis_join(array(',',false),$comment_ids),$redirect_to);
if ( $post_id[0])
 $redirect_to = add_query_arg(array('p',false),absint($post_id),$redirect_to);
if ( ((isset($_REQUEST[0][('apage')]) && Aspis_isset( $_REQUEST [0][('apage')]))))
 $redirect_to = add_query_arg(array('apage',false),absint($_REQUEST[0]['apage']),$redirect_to);
if ( (!((empty($_REQUEST[0][('mode')]) || Aspis_empty( $_REQUEST [0][('mode')])))))
 $redirect_to = add_query_arg(array('mode',false),$_REQUEST[0]['mode'],$redirect_to);
if ( (!((empty($_REQUEST[0][('comment_status')]) || Aspis_empty( $_REQUEST [0][('comment_status')])))))
 $redirect_to = add_query_arg(array('comment_status',false),$_REQUEST[0]['comment_status'],$redirect_to);
if ( (!((empty($_REQUEST[0][('s')]) || Aspis_empty( $_REQUEST [0][('s')])))))
 $redirect_to = add_query_arg(array('s',false),$_REQUEST[0]['s'],$redirect_to);
wp_redirect($redirect_to);
}elseif ( (((isset($_GET[0][('_wp_http_referer')]) && Aspis_isset( $_GET [0][('_wp_http_referer')]))) && (!((empty($_GET[0][('_wp_http_referer')]) || Aspis_empty( $_GET [0][('_wp_http_referer')]))))))
 {wp_redirect(remove_query_arg(array(array(array('_wp_http_referer',false),array('_wpnonce',false)),false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
Aspis_exit();
}if ( $post_id[0])
 $title = Aspis_sprintf(__(array('Edit Comments on &#8220;%s&#8221;',false)),wp_html_excerpt(_draft_or_post_title($post_id),array(50,false)));
else 
{$title = __(array('Edit Comments',false));
}require_once ('admin-header.php');
$mode = ((!((isset($_GET[0][('mode')]) && Aspis_isset( $_GET [0][('mode')])))) || ((empty($_GET[0][('mode')]) || Aspis_empty( $_GET [0][('mode')])))) ? array('detail',false) : esc_attr($_GET[0]['mode']);
$comment_status = ((isset($_REQUEST[0][('comment_status')]) && Aspis_isset( $_REQUEST [0][('comment_status')]))) ? $_REQUEST[0]['comment_status'] : array('all',false);
if ( (denot_boolean(Aspis_in_array($comment_status,array(array(array('all',false),array('moderated',false),array('approved',false),array('spam',false),array('trash',false)),false)))))
 $comment_status = array('all',false);
$comment_type = (!((empty($_GET[0][('comment_type')]) || Aspis_empty( $_GET [0][('comment_type')])))) ? esc_attr($_GET[0]['comment_type']) : array('',false);
$search_dirty = ((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))) ? $_GET[0]['s'] : array('',false);
$search = esc_attr($search_dirty);
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
if ( (((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))) && deAspis($_GET[0]['s'])))
 printf((deconcat2(concat1('<span class="subtitle">',Aspis_sprintf(__(array('Search results for &#8220;%s&#8221;',false)),wp_html_excerpt(esc_html(Aspis_stripslashes($_GET[0]['s'])),array(50,false)))),'</span>')));
;
?>
</h2>

<?php if ( (((((((isset($_GET[0][('approved')]) && Aspis_isset( $_GET [0][('approved')]))) || ((isset($_GET[0][('deleted')]) && Aspis_isset( $_GET [0][('deleted')])))) || ((isset($_GET[0][('trashed')]) && Aspis_isset( $_GET [0][('trashed')])))) || ((isset($_GET[0][('untrashed')]) && Aspis_isset( $_GET [0][('untrashed')])))) || ((isset($_GET[0][('spammed')]) && Aspis_isset( $_GET [0][('spammed')])))) || ((isset($_GET[0][('unspammed')]) && Aspis_isset( $_GET [0][('unspammed')])))))
 {$approved = ((isset($_GET[0][('approved')]) && Aspis_isset( $_GET [0][('approved')]))) ? int_cast($_GET[0]['approved']) : array(0,false);
$deleted = ((isset($_GET[0][('deleted')]) && Aspis_isset( $_GET [0][('deleted')]))) ? int_cast($_GET[0]['deleted']) : array(0,false);
$trashed = ((isset($_GET[0][('trashed')]) && Aspis_isset( $_GET [0][('trashed')]))) ? int_cast($_GET[0]['trashed']) : array(0,false);
$untrashed = ((isset($_GET[0][('untrashed')]) && Aspis_isset( $_GET [0][('untrashed')]))) ? int_cast($_GET[0]['untrashed']) : array(0,false);
$spammed = ((isset($_GET[0][('spammed')]) && Aspis_isset( $_GET [0][('spammed')]))) ? int_cast($_GET[0]['spammed']) : array(0,false);
$unspammed = ((isset($_GET[0][('unspammed')]) && Aspis_isset( $_GET [0][('unspammed')]))) ? int_cast($_GET[0]['unspammed']) : array(0,false);
if ( (((((($approved[0] > (0)) || ($deleted[0] > (0))) || ($trashed[0] > (0))) || ($untrashed[0] > (0))) || ($spammed[0] > (0))) || ($unspammed[0] > (0))))
 {echo AspisCheckPrint(array('<div id="moderated" class="updated fade"><p>',false));
if ( ($approved[0] > (0)))
 {printf(deAspis(_n(array('%s comment approved',false),array('%s comments approved',false),$approved)),deAspisRC($approved));
echo AspisCheckPrint(array('<br />',false));
}if ( ($spammed[0] > (0)))
 {printf(deAspis(_n(array('%s comment marked as spam.',false),array('%s comments marked as spam.',false),$spammed)),deAspisRC($spammed));
$ids = ((isset($_GET[0][('ids')]) && Aspis_isset( $_GET [0][('ids')]))) ? $_GET[0]['ids'] : array(0,false);
echo AspisCheckPrint(concat2(concat(concat2(concat1(' <a href="',esc_url(wp_nonce_url(concat1("edit-comments.php?doaction=undo&action=unspam&ids=",$ids),array("bulk-comments",false)))),'">'),__(array('Undo',false))),'</a><br />'));
}if ( ($unspammed[0] > (0)))
 {printf(deAspis(_n(array('%s comment restored from the spam',false),array('%s comments restored from the spam',false),$unspammed)),deAspisRC($unspammed));
echo AspisCheckPrint(array('<br />',false));
}if ( ($trashed[0] > (0)))
 {printf(deAspis(_n(array('%s comment moved to the trash.',false),array('%s comments moved to the trash.',false),$trashed)),deAspisRC($trashed));
$ids = ((isset($_GET[0][('ids')]) && Aspis_isset( $_GET [0][('ids')]))) ? $_GET[0]['ids'] : array(0,false);
echo AspisCheckPrint(concat2(concat(concat2(concat1(' <a href="',esc_url(wp_nonce_url(concat1("edit-comments.php?doaction=undo&action=untrash&ids=",$ids),array("bulk-comments",false)))),'">'),__(array('Undo',false))),'</a><br />'));
}if ( ($untrashed[0] > (0)))
 {printf(deAspis(_n(array('%s comment restored from the trash',false),array('%s comments restored from the trash',false),$untrashed)),deAspisRC($untrashed));
echo AspisCheckPrint(array('<br />',false));
}if ( ($deleted[0] > (0)))
 {printf(deAspis(_n(array('%s comment permanently deleted',false),array('%s comments permanently deleted',false),$deleted)),deAspisRC($deleted));
echo AspisCheckPrint(array('<br />',false));
}echo AspisCheckPrint(array('</p></div>',false));
}};
?>

<form id="comments-form" action="" method="get">
<ul class="subsubsub">
<?php $status_links = array(array(),false);
$num_comments = deAspis(($post_id)) ? wp_count_comments($post_id) : wp_count_comments();
$stati = array(array(deregisterTaint(array('all',false)) => addTaint(_n_noop(array('All',false),array('All',false))),deregisterTaint(array('moderated',false)) => addTaint(_n_noop(array('Pending <span class="count">(<span class="pending-count">%s</span>)</span>',false),array('Pending <span class="count">(<span class="pending-count">%s</span>)</span>',false))),deregisterTaint(array('approved',false)) => addTaint(_n_noop(array('Approved',false),array('Approved',false))),deregisterTaint(array('spam',false)) => addTaint(_n_noop(array('Spam <span class="count">(<span class="spam-count">%s</span>)</span>',false),array('Spam <span class="count">(<span class="spam-count">%s</span>)</span>',false))),deregisterTaint(array('trash',false)) => addTaint(_n_noop(array('Trash <span class="count">(<span class="trash-count">%s</span>)</span>',false),array('Trash <span class="count">(<span class="trash-count">%s</span>)</span>',false)))),false);
if ( (!(EMPTY_TRASH_DAYS)))
 unset($stati[0][('trash')]);
$link = array('edit-comments.php',false);
if ( ((!((empty($comment_type) || Aspis_empty( $comment_type)))) && (('all') != $comment_type[0])))
 $link = add_query_arg(array('comment_type',false),$comment_type,$link);
foreach ( $stati[0] as $status =>$label )
{restoreTaint($status,$label);
{$class = array('',false);
if ( ($status[0] == $comment_status[0]))
 $class = array(' class="current"',false);
if ( (!((isset($num_comments[0]->$status[0]) && Aspis_isset( $num_comments[0] ->$status[0] )))))
 $num_comments[0]->$status[0] = array(10,false);
$link = add_query_arg(array('comment_status',false),$status,$link);
if ( $post_id[0])
 $link = add_query_arg(array('p',false),absint($post_id),$link);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<li class='",$status),"'><a href='"),$link),"'"),$class),">"),Aspis_sprintf(_n(attachAspis($label,(0)),attachAspis($label,(1)),$num_comments[0]->$status[0]),number_format_i18n($num_comments[0]->$status[0]))),'</a>')));
}}$status_links = apply_filters(array('comment_status_links',false),$status_links);
echo AspisCheckPrint(concat2(Aspis_implode(array(" |</li>\n",false),$status_links),'</li>'));
unset($status_links);
;
?>
</ul>

<p class="search-box">
	<label class="screen-reader-text" for="comment-search-input"><?php _e(array('Search Comments',false));
;
?>:</label>
	<input type="text" id="comment-search-input" name="s" value="<?php _admin_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e(array('Search Comments',false));
;
?>" class="button" />
</p>

<?php $comments_per_page = int_cast(get_user_option(array('edit_comments_per_page',false),array(0,false),array(false,false)));
if ( (((empty($comments_per_page) || Aspis_empty( $comments_per_page))) || ($comments_per_page[0] < (1))))
 $comments_per_page = array(20,false);
$comments_per_page = apply_filters(array('comments_per_page',false),$comments_per_page,$comment_status);
if ( ((isset($_GET[0][('apage')]) && Aspis_isset( $_GET [0][('apage')]))))
 $page = Aspis_abs(int_cast($_GET[0]['apage']));
else 
{$page = array(1,false);
}$start = $offset = array(($page[0] - (1)) * $comments_per_page[0],false);
list($_comments,$total) = deAspisList(_wp_get_comment_list($comment_status,$search_dirty,$start,array($comments_per_page[0] + (8),false),$post_id,$comment_type),array());
$_comment_post_ids = array(array(),false);
foreach ( $_comments[0] as $_c  )
{arrayAssignAdd($_comment_post_ids[0][],addTaint($_c[0]->comment_post_ID));
}$_comment_pending_count_temp = array_cast(get_pending_comments_num($_comment_post_ids));
foreach ( deAspis(array_cast($_comment_post_ids)) as $_cpid  )
arrayAssign($_comment_pending_count[0],deAspis(registerTaint($_cpid)),addTaint(((isset($_comment_pending_count_temp[0][$_cpid[0]]) && Aspis_isset( $_comment_pending_count_temp [0][$_cpid[0]]))) ? attachAspis($_comment_pending_count_temp,$_cpid[0]) : array(0,false)));
if ( ((empty($_comment_pending_count) || Aspis_empty( $_comment_pending_count))))
 $_comment_pending_count = array(array(),false);
$comments = Aspis_array_slice($_comments,array(0,false),$comments_per_page);
$extra_comments = Aspis_array_slice($_comments,$comments_per_page);
$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('apage',false),array('%#%',false))),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint(attAspis(ceil(($total[0] / $comments_per_page[0])))),deregisterTaint(array('current',false)) => addTaint($page)),false));
;
?>

<input type="hidden" name="mode" value="<?php echo AspisCheckPrint(esc_attr($mode));
;
?>" />
<?php if ( $post_id[0])
 {;
?>
<input type="hidden" name="p" value="<?php echo AspisCheckPrint(esc_attr(Aspis_intval($post_id)));
;
?>" />
<?php };
?>
<input type="hidden" name="comment_status" value="<?php echo AspisCheckPrint(esc_attr($comment_status));
;
?>" />
<input type="hidden" name="pagegen_timestamp" value="<?php echo AspisCheckPrint(esc_attr(current_time(array('mysql',false),array(1,false))));
;
?>" />

<div class="tablenav">

<?php if ( $page_links[0])
 {;
?>
<div class="tablenav-pages"><?php $page_links_text = Aspis_sprintf(concat2(concat1('<span class="displaying-num">',__(array('Displaying %s&#8211;%s of %s',false))),'</span>%s'),number_format_i18n(array($start[0] + (1),false)),number_format_i18n(attAspisRC(min(deAspisRC(array($page[0] * $comments_per_page[0],false)),deAspisRC($total)))),concat2(concat1('<span class="total-type-count">',number_format_i18n($total)),'</span>'),$page_links);
echo AspisCheckPrint($page_links_text);
;
?></div>
<input type="hidden" name="_total" value="<?php echo AspisCheckPrint(esc_attr($total));
;
?>" />
<input type="hidden" name="_per_page" value="<?php echo AspisCheckPrint(esc_attr($comments_per_page));
;
?>" />
<input type="hidden" name="_page" value="<?php echo AspisCheckPrint(esc_attr($page));
;
?>" />
<?php };
?>

<div class="alignleft actions">
<select name="action">
<option value="-1" selected="selected"><?php _e(array('Bulk Actions',false));
?></option>
<?php if ( ((('all') == $comment_status[0]) || (('approved') == $comment_status[0])))
 {;
?>
<option value="unapprove"><?php _e(array('Unapprove',false));
;
?></option>
<?php };
?>
<?php if ( (((('all') == $comment_status[0]) || (('moderated') == $comment_status[0])) || (('spam') == $comment_status[0])))
 {;
?>
<option value="approve"><?php _e(array('Approve',false));
;
?></option>
<?php };
?>
<?php if ( (((('all') == $comment_status[0]) || (('approved') == $comment_status[0])) || (('moderated') == $comment_status[0])))
 {;
?>
<option value="spam"><?php _e(array('Mark as Spam',false));
;
?></option>
<?php };
?>
<?php if ( (('trash') == $comment_status[0]))
 {;
?>
<option value="untrash"><?php _e(array('Restore',false));
;
?></option>
<?php }elseif ( (('spam') == $comment_status[0]))
 {;
?>
<option value="unspam"><?php _e(array('Not Spam',false));
;
?></option>
<?php };
?>
<?php if ( (((('trash') == $comment_status[0]) || (('spam') == $comment_status[0])) || (!(EMPTY_TRASH_DAYS))))
 {;
?>
<option value="delete"><?php _e(array('Delete Permanently',false));
;
?></option>
<?php }else 
{;
?>
<option value="trash"><?php _e(array('Move to Trash',false));
;
?></option>
<?php };
?>
</select>
<input type="submit" name="doaction" id="doaction" value="<?php esc_attr_e(array('Apply',false));
;
?>" class="button-secondary apply" />
<?php wp_nonce_field(array('bulk-comments',false));
;
?>

<select name="comment_type">
	<option value="all"><?php _e(array('Show all comment types',false));
;
?></option>
<?php $comment_types = apply_filters(array('admin_comment_types_dropdown',false),array(array(deregisterTaint(array('comment',false)) => addTaint(__(array('Comments',false))),deregisterTaint(array('pings',false)) => addTaint(__(array('Pings',false))),),false));
foreach ( $comment_types[0] as $type =>$label )
{restoreTaint($type,$label);
{echo AspisCheckPrint(concat2(concat1("	<option value='",esc_attr($type)),"'"));
selected($comment_type,$type);
echo AspisCheckPrint(concat2(concat1(">",$label),"</option>\n"));
}};
?>
</select>
<input type="submit" id="post-query-submit" value="<?php esc_attr_e(array('Filter',false));
;
?>" class="button-secondary" />

<?php if ( ((isset($_GET[0][('apage')]) && Aspis_isset( $_GET [0][('apage')]))))
 {;
?>
	<input type="hidden" name="apage" value="<?php echo AspisCheckPrint(esc_attr(absint($_GET[0]['apage'])));
;
?>" />
<?php }if ( (((('spam') == $comment_status[0]) || (('trash') == $comment_status[0])) && deAspis(current_user_can(array('moderate_comments',false)))))
 {wp_nonce_field(array('bulk-destroy',false),array('_destroy_nonce',false));
if ( ((('spam') == $comment_status[0]) && deAspis(current_user_can(array('moderate_comments',false)))))
 {;
?>
		<input type="submit" name="delete_all" id="delete_all" value="<?php esc_attr_e(array('Empty Spam',false));
;
?>" class="button-secondary apply" />
<?php }elseif ( ((('trash') == $comment_status[0]) && deAspis(current_user_can(array('moderate_comments',false)))))
 {;
?>
		<input type="submit" name="delete_all" id="delete_all" value="<?php esc_attr_e(array('Empty Trash',false));
;
?>" class="button-secondary apply" />
<?php }};
?>
<?php do_action(array('manage_comments_nav',false),$comment_status);
;
?>
</div>

<br class="clear" />

</div>

<div class="clear"></div>

<?php if ( $comments[0])
 {;
?>
<table class="widefat comments fixed" cellspacing="0">
<thead>
	<tr>
<?php print_column_headers(array('edit-comments',false));
;
?>
	</tr>
</thead>

<tfoot>
	<tr>
<?php print_column_headers(array('edit-comments',false),array(false,false));
;
?>
	</tr>
</tfoot>

<tbody id="the-comment-list" class="list:comment">
<?php foreach ( $comments[0] as $comment  )
_wp_comment_row($comment[0]->comment_ID,$mode,$comment_status);
;
?>
</tbody>
<tbody id="the-extra-comment-list" class="list:comment" style="display: none;">
<?php foreach ( $extra_comments[0] as $comment  )
_wp_comment_row($comment[0]->comment_ID,$mode,$comment_status);
;
?>
</tbody>
</table>

<div class="tablenav">
<?php if ( $page_links[0])
 echo AspisCheckPrint(concat2(concat1("<div class='tablenav-pages'>",$page_links_text),"</div>"));
;
?>

<div class="alignleft actions">
<select name="action2">
<option value="-1" selected="selected"><?php _e(array('Bulk Actions',false));
?></option>
<?php if ( ((('all') == $comment_status[0]) || (('approved') == $comment_status[0])))
 {;
?>
<option value="unapprove"><?php _e(array('Unapprove',false));
;
?></option>
<?php };
?>
<?php if ( (((('all') == $comment_status[0]) || (('moderated') == $comment_status[0])) || (('spam') == $comment_status[0])))
 {;
?>
<option value="approve"><?php _e(array('Approve',false));
;
?></option>
<?php };
?>
<?php if ( (((('all') == $comment_status[0]) || (('approved') == $comment_status[0])) || (('moderated') == $comment_status[0])))
 {;
?>
<option value="spam"><?php _e(array('Mark as Spam',false));
;
?></option>
<?php };
?>
<?php if ( (('trash') == $comment_status[0]))
 {;
?>
<option value="untrash"><?php _e(array('Restore',false));
;
?></option>
<?php };
?>
<?php if ( (((('trash') == $comment_status[0]) || (('spam') == $comment_status[0])) || (!(EMPTY_TRASH_DAYS))))
 {;
?>
<option value="delete"><?php _e(array('Delete Permanently',false));
;
?></option>
<?php }elseif ( (('spam') == $comment_status[0]))
 {;
?>
<option value="unspam"><?php _e(array('Not Spam',false));
;
?></option>
<?php }else 
{;
?>
<option value="trash"><?php _e(array('Move to Trash',false));
;
?></option>
<?php };
?>
</select>
<input type="submit" name="doaction2" id="doaction2" value="<?php esc_attr_e(array('Apply',false));
;
?>" class="button-secondary apply" />

<?php if ( ((('spam') == $comment_status[0]) && deAspis(current_user_can(array('moderate_comments',false)))))
 {;
?>
<input type="submit" name="delete_all2" id="delete_all2" value="<?php esc_attr_e(array('Empty Spam',false));
;
?>" class="button-secondary apply" />
<?php }elseif ( ((('trash') == $comment_status[0]) && deAspis(current_user_can(array('moderate_comments',false)))))
 {;
?>
<input type="submit" name="delete_all2" id="delete_all2" value="<?php esc_attr_e(array('Empty Trash',false));
;
?>" class="button-secondary apply" />
<?php };
?>
<?php do_action(array('manage_comments_nav',false),$comment_status);
;
?>
</div>

<br class="clear" />
</div>

</form>

<form id="get-extra-comments" method="post" action="" class="add:the-extra-comment-list:" style="display: none;">
	<input type="hidden" name="s" value="<?php echo AspisCheckPrint(esc_attr($search));
;
?>" />
	<input type="hidden" name="mode" value="<?php echo AspisCheckPrint(esc_attr($mode));
;
?>" />
	<input type="hidden" name="comment_status" value="<?php echo AspisCheckPrint(esc_attr($comment_status));
;
?>" />
	<input type="hidden" name="page" value="<?php echo AspisCheckPrint(esc_attr($page));
;
?>" />
	<input type="hidden" name="per_page" value="<?php echo AspisCheckPrint(esc_attr($comments_per_page));
;
?>" />
	<input type="hidden" name="p" value="<?php echo AspisCheckPrint(esc_attr($post_id));
;
?>" />
	<input type="hidden" name="comment_type" value="<?php echo AspisCheckPrint(esc_attr($comment_type));
;
?>" />
	<?php wp_nonce_field(array('add-comment',false),array('_ajax_nonce',false),array(false,false));
;
?>
</form>

<div id="ajax-response"></div>

<?php }elseif ( (('moderated') == $comment_status[0]))
 {;
?>
<p><?php _e(array('No comments awaiting moderation&hellip; yet.',false));
?></p>
</form>

<?php }else 
{{;
?>
<p><?php _e(array('No results found.',false));
?></p>
</form>

<?php }};
?>
</div>

<?php wp_comment_reply(array('-1',false),array(true,false),array('detail',false));
wp_comment_trashnotice();
include ('admin-footer.php');
;
?>
<?php 