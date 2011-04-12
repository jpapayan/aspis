<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('edit_pages',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
if ( ((((((isset($_GET[0][('doaction')]) && Aspis_isset( $_GET [0][('doaction')]))) || ((isset($_GET[0][('doaction2')]) && Aspis_isset( $_GET [0][('doaction2')])))) || ((isset($_GET[0][('delete_all')]) && Aspis_isset( $_GET [0][('delete_all')])))) || ((isset($_GET[0][('delete_all2')]) && Aspis_isset( $_GET [0][('delete_all2')])))) || ((isset($_GET[0][('bulk_edit')]) && Aspis_isset( $_GET [0][('bulk_edit')])))))
 {check_admin_referer(array('bulk-pages',false));
$sendback = remove_query_arg(array(array(array('trashed',false),array('untrashed',false),array('deleted',false),array('ids',false)),false),wp_get_referer());
if ( (strpos($sendback[0],'page.php') !== false))
 $sendback = admin_url(array('page-new.php',false));
if ( (((isset($_GET[0][('delete_all')]) && Aspis_isset( $_GET [0][('delete_all')]))) || ((isset($_GET[0][('delete_all2')]) && Aspis_isset( $_GET [0][('delete_all2')])))))
 {$post_status = Aspis_preg_replace(array('/[^a-z0-9_-]+/i',false),array('',false),$_GET[0]['post_status']);
$post_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_type='page' AND post_status = %s"),$post_status));
$doaction = array('delete',false);
}elseif ( (((deAspis($_GET[0]['action']) != deAspis(negate(array(1,false)))) || (deAspis($_GET[0]['action2']) != deAspis(negate(array(1,false))))) && (((isset($_GET[0][('post')]) && Aspis_isset( $_GET [0][('post')]))) || ((isset($_GET[0][('ids')]) && Aspis_isset( $_GET [0][('ids')]))))))
 {$post_ids = ((isset($_GET[0][('post')]) && Aspis_isset( $_GET [0][('post')]))) ? attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC(array_cast($_GET[0]['post'])))) : Aspis_explode(array(',',false),$_GET[0]['ids']);
$doaction = (deAspis($_GET[0]['action']) != deAspis(negate(array(1,false)))) ? $_GET[0]['action'] : $_GET[0]['action2'];
}else 
{{wp_redirect(admin_url(array('edit-pages.php',false)));
}}switch ( $doaction[0] ) {
case ('trash'):$trashed = array(0,false);
foreach ( deAspis(array_cast($post_ids)) as $post_id  )
{if ( (denot_boolean(current_user_can(array('delete_page',false),$post_id))))
 wp_die(__(array('You are not allowed to move this page to the trash.',false)));
if ( (denot_boolean(wp_trash_post($post_id))))
 wp_die(__(array('Error in moving to trash...',false)));
postincr($trashed);
}$sendback = add_query_arg(array(array(deregisterTaint(array('trashed',false)) => addTaint($trashed),deregisterTaint(array('ids',false)) => addTaint(Aspis_join(array(',',false),$post_ids))),false),$sendback);
break ;
case ('untrash'):$untrashed = array(0,false);
foreach ( deAspis(array_cast($post_ids)) as $post_id  )
{if ( (denot_boolean(current_user_can(array('delete_page',false),$post_id))))
 wp_die(__(array('You are not allowed to restore this page from the trash.',false)));
if ( (denot_boolean(wp_untrash_post($post_id))))
 wp_die(__(array('Error in restoring from trash...',false)));
postincr($untrashed);
}$sendback = add_query_arg(array('untrashed',false),$untrashed,$sendback);
break ;
case ('delete'):$deleted = array(0,false);
foreach ( deAspis(array_cast($post_ids)) as $post_id  )
{$post_del = &get_post($post_id);
if ( (denot_boolean(current_user_can(array('delete_page',false),$post_id))))
 wp_die(__(array('You are not allowed to delete this page.',false)));
if ( ($post_del[0]->post_type[0] == ('attachment')))
 {if ( (denot_boolean(wp_delete_attachment($post_id))))
 wp_die(__(array('Error in deleting...',false)));
}else 
{{if ( (denot_boolean(wp_delete_post($post_id))))
 wp_die(__(array('Error in deleting...',false)));
}}postincr($deleted);
}$sendback = add_query_arg(array('deleted',false),$deleted,$sendback);
break ;
case ('edit'):arrayAssign($_GET[0],deAspis(registerTaint(array('post_type',false))),addTaint(array('page',false)));
$done = bulk_edit_posts($_GET);
if ( is_array($done[0]))
 {arrayAssign($done[0],deAspis(registerTaint(array('updated',false))),addTaint(attAspis(count(deAspis($done[0]['updated'])))));
arrayAssign($done[0],deAspis(registerTaint(array('skipped',false))),addTaint(attAspis(count(deAspis($done[0]['skipped'])))));
arrayAssign($done[0],deAspis(registerTaint(array('locked',false))),addTaint(attAspis(count(deAspis($done[0]['locked'])))));
$sendback = add_query_arg($done,$sendback);
}break ;
 }
if ( ((isset($_GET[0][('action')]) && Aspis_isset( $_GET [0][('action')]))))
 $sendback = remove_query_arg(array(array(array('action',false),array('action2',false),array('post_parent',false),array('page_template',false),array('post_author',false),array('comment_status',false),array('ping_status',false),array('_status',false),array('post',false),array('bulk_edit',false),array('post_view',false),array('post_type',false)),false),$sendback);
wp_redirect($sendback);
Aspis_exit();
}elseif ( (((isset($_GET[0][('_wp_http_referer')]) && Aspis_isset( $_GET [0][('_wp_http_referer')]))) && (!((empty($_GET[0][('_wp_http_referer')]) || Aspis_empty( $_GET [0][('_wp_http_referer')]))))))
 {wp_redirect(remove_query_arg(array(array(array('_wp_http_referer',false),array('_wpnonce',false)),false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
Aspis_exit();
}if ( ((empty($title) || Aspis_empty( $title))))
 $title = __(array('Edit Pages',false));
$parent_file = array('edit-pages.php',false);
wp_enqueue_script(array('inline-edit-post',false));
$post_stati = array(array('publish' => array(array(_x(array('Published',false),array('page',false)),__(array('Published pages',false)),_nx_noop(array('Published <span class="count">(%s)</span>',false),array('Published <span class="count">(%s)</span>',false),array('page',false))),false,false),'future' => array(array(_x(array('Scheduled',false),array('page',false)),__(array('Scheduled pages',false)),_nx_noop(array('Scheduled <span class="count">(%s)</span>',false),array('Scheduled <span class="count">(%s)</span>',false),array('page',false))),false,false),'pending' => array(array(_x(array('Pending Review',false),array('page',false)),__(array('Pending pages',false)),_nx_noop(array('Pending Review <span class="count">(%s)</span>',false),array('Pending Review <span class="count">(%s)</span>',false),array('page',false))),false,false),'draft' => array(array(_x(array('Draft',false),array('page',false)),_x(array('Drafts',false),array('manage posts header',false)),_nx_noop(array('Draft <span class="count">(%s)</span>',false),array('Drafts <span class="count">(%s)</span>',false),array('page',false))),false,false),'private' => array(array(_x(array('Private',false),array('page',false)),__(array('Private pages',false)),_nx_noop(array('Private <span class="count">(%s)</span>',false),array('Private <span class="count">(%s)</span>',false),array('page',false))),false,false),'trash' => array(array(_x(array('Trash',false),array('page',false)),__(array('Trash pages',false)),_nx_noop(array('Trash <span class="count">(%s)</span>',false),array('Trash <span class="count">(%s)</span>',false),array('page',false))),false,false)),false);
if ( (!(EMPTY_TRASH_DAYS)))
 unset($post_stati[0][('trash')]);
$post_stati = apply_filters(array('page_stati',false),$post_stati);
$query = array(array('post_type' => array('page',false,false),'orderby' => array('menu_order title',false,false),deregisterTaint(array('posts_per_page',false)) => addTaint(negate(array(1,false))),deregisterTaint(array('posts_per_archive_page',false)) => addTaint(negate(array(1,false))),'order' => array('asc',false,false)),false);
$post_status_label = __(array('Pages',false));
if ( (((isset($_GET[0][('post_status')]) && Aspis_isset( $_GET [0][('post_status')]))) && deAspis(Aspis_in_array($_GET[0]['post_status'],attAspisRC(array_keys(deAspisRC($post_stati)))))))
 {$post_status_label = attachAspis($post_stati[0][deAspis($_GET[0]['post_status'])],(1));
arrayAssign($query[0],deAspis(registerTaint(array('post_status',false))),addTaint($_GET[0]['post_status']));
arrayAssign($query[0],deAspis(registerTaint(array('perm',false))),addTaint(array('readable',false)));
}$query = apply_filters(array('manage_pages_query',false),$query);
wp($query);
if ( deAspis(is_singular()))
 {wp_enqueue_script(array('admin-comments',false));
enqueue_comment_hotkeys_js();
}require_once ('admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?> <a href="page-new.php" class="button add-new-h2"><?php echo AspisCheckPrint(esc_html_x(array('Add New',false),array('page',false)));
;
?></a> <?php if ( (((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))) && deAspis($_GET[0]['s'])))
 printf((deconcat2(concat1('<span class="subtitle">',__(array('Search results for &#8220;%s&#8221;',false))),'</span>')),deAspisRC(esc_html(get_search_query())));
;
?>
</h2>

<?php if ( (((((((isset($_GET[0][('locked')]) && Aspis_isset( $_GET [0][('locked')]))) || ((isset($_GET[0][('skipped')]) && Aspis_isset( $_GET [0][('skipped')])))) || ((isset($_GET[0][('updated')]) && Aspis_isset( $_GET [0][('updated')])))) || ((isset($_GET[0][('deleted')]) && Aspis_isset( $_GET [0][('deleted')])))) || ((isset($_GET[0][('trashed')]) && Aspis_isset( $_GET [0][('trashed')])))) || ((isset($_GET[0][('untrashed')]) && Aspis_isset( $_GET [0][('untrashed')])))))
 {;
?>
<div id="message" class="updated fade"><p>
<?php if ( (((isset($_GET[0][('updated')]) && Aspis_isset( $_GET [0][('updated')]))) && deAspis(int_cast($_GET[0]['updated']))))
 {printf(deAspis(_n(array('%s page updated.',false),array('%s pages updated.',false),$_GET[0]['updated'])),deAspisRC(number_format_i18n($_GET[0]['updated'])));
unset($_GET[0][('updated')]);
}if ( (((isset($_GET[0][('skipped')]) && Aspis_isset( $_GET [0][('skipped')]))) && deAspis(int_cast($_GET[0]['skipped']))))
 {printf(deAspis(_n(array('%s page not updated, invalid parent page specified.',false),array('%s pages not updated, invalid parent page specified.',false),$_GET[0]['skipped'])),deAspisRC(number_format_i18n($_GET[0]['skipped'])));
unset($_GET[0][('skipped')]);
}if ( (((isset($_GET[0][('locked')]) && Aspis_isset( $_GET [0][('locked')]))) && deAspis(int_cast($_GET[0]['locked']))))
 {printf(deAspis(_n(array('%s page not updated, somebody is editing it.',false),array('%s pages not updated, somebody is editing them.',false),$_GET[0]['locked'])),deAspisRC(number_format_i18n($_GET[0]['skipped'])));
unset($_GET[0][('locked')]);
}if ( (((isset($_GET[0][('deleted')]) && Aspis_isset( $_GET [0][('deleted')]))) && deAspis(int_cast($_GET[0]['deleted']))))
 {printf(deAspis(_n(array('Page permanently deleted.',false),array('%s pages permanently deleted.',false),$_GET[0]['deleted'])),deAspisRC(number_format_i18n($_GET[0]['deleted'])));
unset($_GET[0][('deleted')]);
}if ( (((isset($_GET[0][('trashed')]) && Aspis_isset( $_GET [0][('trashed')]))) && deAspis(int_cast($_GET[0]['trashed']))))
 {printf(deAspis(_n(array('Page moved to the trash.',false),array('%s pages moved to the trash.',false),$_GET[0]['trashed'])),deAspisRC(number_format_i18n($_GET[0]['trashed'])));
$ids = ((isset($_GET[0][('ids')]) && Aspis_isset( $_GET [0][('ids')]))) ? $_GET[0]['ids'] : array(0,false);
echo AspisCheckPrint(concat2(concat(concat2(concat1(' <a href="',esc_url(wp_nonce_url(concat1("edit-pages.php?doaction=undo&action=untrash&ids=",$ids),array("bulk-pages",false)))),'">'),__(array('Undo',false))),'</a><br />'));
unset($_GET[0][('trashed')]);
}if ( (((isset($_GET[0][('untrashed')]) && Aspis_isset( $_GET [0][('untrashed')]))) && deAspis(int_cast($_GET[0]['untrashed']))))
 {printf(deAspis(_n(array('Page restored from the trash.',false),array('%s pages restored from the trash.',false),$_GET[0]['untrashed'])),deAspisRC(number_format_i18n($_GET[0]['untrashed'])));
unset($_GET[0][('untrashed')]);
}arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('locked',false),array('skipped',false),array('updated',false),array('deleted',false),array('trashed',false),array('untrashed',false)),false),$_SERVER[0]['REQUEST_URI'])));
;
?>
</p></div>
<?php };
?>

<?php if ( (((isset($_GET[0][('posted')]) && Aspis_isset( $_GET [0][('posted')]))) && deAspis($_GET[0]['posted'])))
 {arrayAssign($_GET[0],deAspis(registerTaint(array('posted',false))),addTaint(int_cast($_GET[0]['posted'])));
;
?>
<div id="message" class="updated fade"><p><strong><?php _e(array('Your page has been saved.',false));
;
?></strong> <a href="<?php echo AspisCheckPrint(get_permalink($_GET[0]['posted']));
;
?>"><?php _e(array('View page',false));
;
?></a> | <a href="<?php echo AspisCheckPrint(get_edit_post_link($_GET[0]['posted']));
;
?>"><?php _e(array('Edit page',false));
;
?></a></p></div>
<?php arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('posted',false)),false),$_SERVER[0]['REQUEST_URI'])));
};
?>

<form id="posts-filter" action="<?php echo AspisCheckPrint(admin_url(array('edit-pages.php',false)));
;
?>" method="get">
<ul class="subsubsub">
<?php $avail_post_stati = get_available_post_statuses(array('page',false));
if ( ((empty($locked_post_status) || Aspis_empty( $locked_post_status))))
 {$status_links = array(array(),false);
$num_posts = wp_count_posts(array('page',false),array('readable',false));
$total_posts = array(deAspis(attAspisRC(array_sum(deAspisRC(array_cast($num_posts))))) - $num_posts[0]->trash[0],false);
$class = ((empty($_GET[0][('post_status')]) || Aspis_empty( $_GET [0][('post_status')]))) ? array(' class="current"',false) : array('',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat1("<li><a href='edit-pages.php'",$class),">"),Aspis_sprintf(_nx(array('All <span class="count">(%s)</span>',false),array('All <span class="count">(%s)</span>',false),$total_posts,array('pages',false)),number_format_i18n($total_posts))),'</a>')));
foreach ( $post_stati[0] as $status =>$label )
{restoreTaint($status,$label);
{$class = array('',false);
if ( ((denot_boolean(Aspis_in_array($status,$avail_post_stati))) || (deAspis($num_posts[0]->$status[0]) <= (0))))
 continue ;
if ( (((isset($_GET[0][('post_status')]) && Aspis_isset( $_GET [0][('post_status')]))) && ($status[0] == deAspis($_GET[0]['post_status']))))
 $class = array(' class="current"',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1("<li><a href='edit-pages.php?post_status=",$status),"'"),$class),">"),Aspis_sprintf(_nx(attachAspis($label[0][(2)],(0)),attachAspis($label[0][(2)],(1)),$num_posts[0]->$status[0],attachAspis($label[0][(2)],(2))),number_format_i18n($num_posts[0]->$status[0]))),'</a>')));
}}echo AspisCheckPrint(concat2(Aspis_implode(array(" |</li>\n",false),$status_links),'</li>'));
unset($status_links);
};
?>
</ul>

<p class="search-box">
	<label class="screen-reader-text" for="page-search-input"><?php _e(array('Search Pages',false));
;
?>:</label>
	<input type="text" id="page-search-input" name="s" value="<?php _admin_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e(array('Search Pages',false));
;
?>" class="button" />
</p>

<input type="hidden" name="post_status" class="post_status_page" value="<?php echo AspisCheckPrint((!((empty($_GET[0][('post_status')]) || Aspis_empty( $_GET [0][('post_status')])))) ? esc_attr($_GET[0]['post_status']) : array('all',false));
;
?>" />

<?php if ( $posts[0])
 {;
?>

<div class="tablenav">

<?php $pagenum = ((isset($_GET[0][('pagenum')]) && Aspis_isset( $_GET [0][('pagenum')]))) ? absint($_GET[0]['pagenum']) : array(0,false);
if ( ((empty($pagenum) || Aspis_empty( $pagenum))))
 $pagenum = array(1,false);
$per_page = int_cast(get_user_option(array('edit_pages_per_page',false),array(0,false),array(false,false)));
if ( (((empty($per_page) || Aspis_empty( $per_page))) || ($per_page[0] < (1))))
 $per_page = array(20,false);
$per_page = apply_filters(array('edit_pages_per_page',false),$per_page);
$num_pages = attAspis(ceil(($wp_query[0]->post_count[0] / $per_page[0])));
$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('pagenum',false),array('%#%',false))),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint($num_pages),deregisterTaint(array('current',false)) => addTaint($pagenum)),false));
$is_trash = array(((isset($_GET[0][('post_status')]) && Aspis_isset( $_GET [0][('post_status')]))) && (deAspis($_GET[0]['post_status']) == ('trash')),false);
if ( $page_links[0])
 {;
?>
<div class="tablenav-pages"><?php $page_links_text = Aspis_sprintf(concat2(concat1('<span class="displaying-num">',__(array('Displaying %s&#8211;%s of %s',false))),'</span>%s'),number_format_i18n(array((($pagenum[0] - (1)) * $per_page[0]) + (1),false)),number_format_i18n(attAspisRC(min(deAspisRC(array($pagenum[0] * $per_page[0],false)),deAspisRC($wp_query[0]->post_count)))),number_format_i18n($wp_query[0]->post_count),$page_links);
echo AspisCheckPrint($page_links_text);
;
?></div>
<?php };
?>

<div class="alignleft actions">
<select name="action">
<option value="-1" selected="selected"><?php _e(array('Bulk Actions',false));
;
?></option>
<?php if ( $is_trash[0])
 {;
?>
<option value="untrash"><?php _e(array('Restore',false));
;
?></option>
<?php }else 
{{;
?>
<option value="edit"><?php _e(array('Edit',false));
;
?></option>
<?php }}if ( ($is_trash[0] || (!(EMPTY_TRASH_DAYS))))
 {;
?>
<option value="delete"><?php _e(array('Delete Permanently',false));
;
?></option>
<?php }else 
{{;
?>
<option value="trash"><?php _e(array('Move to Trash',false));
;
?></option>
<?php }};
?>
</select>
<input type="submit" value="<?php esc_attr_e(array('Apply',false));
;
?>" name="doaction" id="doaction" class="button-secondary action" />
<?php wp_nonce_field(array('bulk-pages',false));
;
?>
<?php if ( $is_trash[0])
 {;
?>
<input type="submit" name="delete_all" id="delete_all" value="<?php esc_attr_e(array('Empty Trash',false));
;
?>" class="button-secondary apply" />
<?php };
?>
</div>

<br class="clear" />
</div>

<div class="clear"></div>

<table class="widefat page fixed" cellspacing="0">
  <thead>
  <tr>
<?php print_column_headers(array('edit-pages',false));
;
?>
  </tr>
  </thead>

  <tfoot>
  <tr>
<?php print_column_headers(array('edit-pages',false),array(false,false));
;
?>
  </tr>
  </tfoot>

  <tbody>
  <?php page_rows($posts,$pagenum,$per_page);
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
;
?></option>
<?php if ( $is_trash[0])
 {;
?>
<option value="untrash"><?php _e(array('Restore',false));
;
?></option>
<?php }else 
{{;
?>
<option value="edit"><?php _e(array('Edit',false));
;
?></option>
<?php }}if ( ($is_trash[0] || (!(EMPTY_TRASH_DAYS))))
 {;
?>
<option value="delete"><?php _e(array('Delete Permanently',false));
;
?></option>
<?php }else 
{{;
?>
<option value="trash"><?php _e(array('Move to Trash',false));
;
?></option>
<?php }};
?>
</select>
<input type="submit" value="<?php esc_attr_e(array('Apply',false));
;
?>" name="doaction2" id="doaction2" class="button-secondary action" />
<?php if ( $is_trash[0])
 {;
?>
<input type="submit" name="delete_all2" id="delete_all2" value="<?php esc_attr_e(array('Empty Trash',false));
;
?>" class="button-secondary apply" />
<?php };
?>
</div>

<br class="clear" />
</div>

<?php }else 
{{;
?>
<div class="clear"></div>
<p><?php _e(array('No pages found.',false));
?></p>
<?php }};
?>

</form>

<?php inline_edit_row(array('page',false));
?>

<div id="ajax-response"></div>


<?php if ( (((1) == count($posts[0])) && deAspis(is_singular())))
 {$comments = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d AND comment_approved != 'spam' ORDER BY comment_date"),$id));
if ( $comments[0])
 {update_comment_cache($comments);
$post = get_post($id);
$authordata = get_userdata($post[0]->post_author);
;
?>

<br class="clear" />

<table class="widefat" cellspacing="0">
<thead>
  <tr>
    <th scope="col" class="column-comment">
		<?php echo AspisCheckPrint(_x(array('Comment',false),array('column name',false)));
?>
	</th>
    <th scope="col" class="column-author"><?php _e(array('Author',false));
?></th>
    <th scope="col" class="column-date"><?php _e(array('Submitted',false));
?></th>
  </tr>
</thead>
<tbody id="the-comment-list" class="list:comment">
<?php foreach ( $comments[0] as $comment  )
_wp_comment_row($comment[0]->comment_ID,array('single',false),array(false,false),array(false,false));
;
?>
</tbody>
</table>

<?php wp_comment_reply();
}};
?>

</div>

<?php include ('admin-footer.php');
