<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( !current_user_can('edit_pages'))
 wp_die(__('Cheatin&#8217; uh?'));
if ( (isset($_GET[0]['doaction']) && Aspis_isset($_GET[0]['doaction'])) || (isset($_GET[0]['doaction2']) && Aspis_isset($_GET[0]['doaction2'])) || (isset($_GET[0]['delete_all']) && Aspis_isset($_GET[0]['delete_all'])) || (isset($_GET[0]['delete_all2']) && Aspis_isset($_GET[0]['delete_all2'])) || (isset($_GET[0]['bulk_edit']) && Aspis_isset($_GET[0]['bulk_edit'])))
 {check_admin_referer('bulk-pages');
$sendback = remove_query_arg(array('trashed','untrashed','deleted','ids'),wp_get_referer());
if ( strpos($sendback,'page.php') !== false)
 $sendback = admin_url('page-new.php');
if ( (isset($_GET[0]['delete_all']) && Aspis_isset($_GET[0]['delete_all'])) || (isset($_GET[0]['delete_all2']) && Aspis_isset($_GET[0]['delete_all2'])))
 {$post_status = preg_replace('/[^a-z0-9_-]+/i','',deAspisWarningRC($_GET[0]['post_status']));
$post_ids = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = %s",$post_status));
$doaction = 'delete';
}elseif ( (deAspisWarningRC($_GET[0]['action']) != -1 || deAspisWarningRC($_GET[0]['action2']) != -1) && ((isset($_GET[0]['post']) && Aspis_isset($_GET[0]['post'])) || (isset($_GET[0]['ids']) && Aspis_isset($_GET[0]['ids']))))
 {$post_ids = (isset($_GET[0]['post']) && Aspis_isset($_GET[0]['post'])) ? array_map('intval',(array)deAspisWarningRC($_GET[0]['post'])) : explode(',',deAspisWarningRC($_GET[0]['ids']));
$doaction = (deAspisWarningRC($_GET[0]['action']) != -1) ? deAspisWarningRC($_GET[0]['action']) : deAspisWarningRC($_GET[0]['action2']);
}else 
{{wp_redirect(admin_url('edit-pages.php'));
}}switch ( $doaction ) {
case 'trash':$trashed = 0;
foreach ( (array)$post_ids as $post_id  )
{if ( !current_user_can('delete_page',$post_id))
 wp_die(__('You are not allowed to move this page to the trash.'));
if ( !wp_trash_post($post_id))
 wp_die(__('Error in moving to trash...'));
$trashed++;
}$sendback = add_query_arg(array('trashed' => $trashed,'ids' => join(',',$post_ids)),$sendback);
break ;
case 'untrash':$untrashed = 0;
foreach ( (array)$post_ids as $post_id  )
{if ( !current_user_can('delete_page',$post_id))
 wp_die(__('You are not allowed to restore this page from the trash.'));
if ( !wp_untrash_post($post_id))
 wp_die(__('Error in restoring from trash...'));
$untrashed++;
}$sendback = add_query_arg('untrashed',$untrashed,$sendback);
break ;
case 'delete':$deleted = 0;
foreach ( (array)$post_ids as $post_id  )
{$post_del = &get_post($post_id);
if ( !current_user_can('delete_page',$post_id))
 wp_die(__('You are not allowed to delete this page.'));
if ( $post_del->post_type == 'attachment')
 {if ( !wp_delete_attachment($post_id))
 wp_die(__('Error in deleting...'));
}else 
{{if ( !wp_delete_post($post_id))
 wp_die(__('Error in deleting...'));
}}$deleted++;
}$sendback = add_query_arg('deleted',$deleted,$sendback);
break ;
case 'edit':$_GET[0]['post_type'] = attAspisRCO('page');
$done = bulk_edit_posts(deAspisWarningRC($_GET));
if ( is_array($done))
 {$done['updated'] = count($done['updated']);
$done['skipped'] = count($done['skipped']);
$done['locked'] = count($done['locked']);
$sendback = add_query_arg($done,$sendback);
}break ;
 }
if ( (isset($_GET[0]['action']) && Aspis_isset($_GET[0]['action'])))
 $sendback = remove_query_arg(array('action','action2','post_parent','page_template','post_author','comment_status','ping_status','_status','post','bulk_edit','post_view','post_type'),$sendback);
wp_redirect($sendback);
exit();
}elseif ( (isset($_GET[0]['_wp_http_referer']) && Aspis_isset($_GET[0]['_wp_http_referer'])) && !(empty($_GET[0]['_wp_http_referer']) || Aspis_empty($_GET[0]['_wp_http_referer'])))
 {wp_redirect(remove_query_arg(array('_wp_http_referer','_wpnonce'),stripslashes(deAspisWarningRC($_SERVER[0]['REQUEST_URI']))));
exit();
}if ( empty($title))
 $title = __('Edit Pages');
$parent_file = 'edit-pages.php';
wp_enqueue_script('inline-edit-post');
$post_stati = array('publish' => array(_x('Published','page'),__('Published pages'),_nx_noop('Published <span class="count">(%s)</span>','Published <span class="count">(%s)</span>','page')),'future' => array(_x('Scheduled','page'),__('Scheduled pages'),_nx_noop('Scheduled <span class="count">(%s)</span>','Scheduled <span class="count">(%s)</span>','page')),'pending' => array(_x('Pending Review','page'),__('Pending pages'),_nx_noop('Pending Review <span class="count">(%s)</span>','Pending Review <span class="count">(%s)</span>','page')),'draft' => array(_x('Draft','page'),_x('Drafts','manage posts header'),_nx_noop('Draft <span class="count">(%s)</span>','Drafts <span class="count">(%s)</span>','page')),'private' => array(_x('Private','page'),__('Private pages'),_nx_noop('Private <span class="count">(%s)</span>','Private <span class="count">(%s)</span>','page')),'trash' => array(_x('Trash','page'),__('Trash pages'),_nx_noop('Trash <span class="count">(%s)</span>','Trash <span class="count">(%s)</span>','page')));
if ( !EMPTY_TRASH_DAYS)
 unset($post_stati['trash']);
$post_stati = apply_filters('page_stati',$post_stati);
$query = array('post_type' => 'page','orderby' => 'menu_order title','posts_per_page' => -1,'posts_per_archive_page' => -1,'order' => 'asc');
$post_status_label = __('Pages');
if ( (isset($_GET[0]['post_status']) && Aspis_isset($_GET[0]['post_status'])) && in_array(deAspisWarningRC($_GET[0]['post_status']),array_keys($post_stati)))
 {$post_status_label = $post_stati[deAspisWarningRC($_GET[0]['post_status'])][1];
$query['post_status'] = deAspisWarningRC($_GET[0]['post_status']);
$query['perm'] = 'readable';
}$query = apply_filters('manage_pages_query',$query);
wp($query);
if ( is_singular())
 {wp_enqueue_script('admin-comments');
enqueue_comment_hotkeys_js();
}require_once ('admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo esc_html($title);
;
?> <a href="page-new.php" class="button add-new-h2"><?php echo esc_html_x('Add New','page');
;
?></a> <?php if ( (isset($_GET[0]['s']) && Aspis_isset($_GET[0]['s'])) && deAspisWarningRC($_GET[0]['s']))
 printf('<span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>',esc_html(get_search_query()));
;
?>
</h2>

<?php if ( (isset($_GET[0]['locked']) && Aspis_isset($_GET[0]['locked'])) || (isset($_GET[0]['skipped']) && Aspis_isset($_GET[0]['skipped'])) || (isset($_GET[0]['updated']) && Aspis_isset($_GET[0]['updated'])) || (isset($_GET[0]['deleted']) && Aspis_isset($_GET[0]['deleted'])) || (isset($_GET[0]['trashed']) && Aspis_isset($_GET[0]['trashed'])) || (isset($_GET[0]['untrashed']) && Aspis_isset($_GET[0]['untrashed'])))
 {;
?>
<div id="message" class="updated fade"><p>
<?php if ( (isset($_GET[0]['updated']) && Aspis_isset($_GET[0]['updated'])) && (int)deAspisWarningRC($_GET[0]['updated']))
 {printf(_n('%s page updated.','%s pages updated.',deAspisWarningRC($_GET[0]['updated'])),number_format_i18n(deAspisWarningRC($_GET[0]['updated'])));
unset($_GET[0]['updated']);
}if ( (isset($_GET[0]['skipped']) && Aspis_isset($_GET[0]['skipped'])) && (int)deAspisWarningRC($_GET[0]['skipped']))
 {printf(_n('%s page not updated, invalid parent page specified.','%s pages not updated, invalid parent page specified.',deAspisWarningRC($_GET[0]['skipped'])),number_format_i18n(deAspisWarningRC($_GET[0]['skipped'])));
unset($_GET[0]['skipped']);
}if ( (isset($_GET[0]['locked']) && Aspis_isset($_GET[0]['locked'])) && (int)deAspisWarningRC($_GET[0]['locked']))
 {printf(_n('%s page not updated, somebody is editing it.','%s pages not updated, somebody is editing them.',deAspisWarningRC($_GET[0]['locked'])),number_format_i18n(deAspisWarningRC($_GET[0]['skipped'])));
unset($_GET[0]['locked']);
}if ( (isset($_GET[0]['deleted']) && Aspis_isset($_GET[0]['deleted'])) && (int)deAspisWarningRC($_GET[0]['deleted']))
 {printf(_n('Page permanently deleted.','%s pages permanently deleted.',deAspisWarningRC($_GET[0]['deleted'])),number_format_i18n(deAspisWarningRC($_GET[0]['deleted'])));
unset($_GET[0]['deleted']);
}if ( (isset($_GET[0]['trashed']) && Aspis_isset($_GET[0]['trashed'])) && (int)deAspisWarningRC($_GET[0]['trashed']))
 {printf(_n('Page moved to the trash.','%s pages moved to the trash.',deAspisWarningRC($_GET[0]['trashed'])),number_format_i18n(deAspisWarningRC($_GET[0]['trashed'])));
$ids = (isset($_GET[0]['ids']) && Aspis_isset($_GET[0]['ids'])) ? deAspisWarningRC($_GET[0]['ids']) : 0;
echo ' <a href="' . esc_url(wp_nonce_url("edit-pages.php?doaction=undo&action=untrash&ids=$ids","bulk-pages")) . '">' . __('Undo') . '</a><br />';
unset($_GET[0]['trashed']);
}if ( (isset($_GET[0]['untrashed']) && Aspis_isset($_GET[0]['untrashed'])) && (int)deAspisWarningRC($_GET[0]['untrashed']))
 {printf(_n('Page restored from the trash.','%s pages restored from the trash.',deAspisWarningRC($_GET[0]['untrashed'])),number_format_i18n(deAspisWarningRC($_GET[0]['untrashed'])));
unset($_GET[0]['untrashed']);
}$_SERVER[0]['REQUEST_URI'] = attAspisRCO(remove_query_arg(array('locked','skipped','updated','deleted','trashed','untrashed'),deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
;
?>
</p></div>
<?php };
?>

<?php if ( (isset($_GET[0]['posted']) && Aspis_isset($_GET[0]['posted'])) && deAspisWarningRC($_GET[0]['posted']))
 {$_GET[0]['posted'] = attAspisRCO((int)deAspisWarningRC($_GET[0]['posted']));
;
?>
<div id="message" class="updated fade"><p><strong><?php _e('Your page has been saved.');
;
?></strong> <a href="<?php echo get_permalink(deAspisWarningRC($_GET[0]['posted']));
;
?>"><?php _e('View page');
;
?></a> | <a href="<?php echo get_edit_post_link(deAspisWarningRC($_GET[0]['posted']));
;
?>"><?php _e('Edit page');
;
?></a></p></div>
<?php $_SERVER[0]['REQUEST_URI'] = attAspisRCO(remove_query_arg(array('posted'),deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
};
?>

<form id="posts-filter" action="<?php echo admin_url('edit-pages.php');
;
?>" method="get">
<ul class="subsubsub">
<?php $avail_post_stati = get_available_post_statuses('page');
if ( empty($locked_post_status))
 {$status_links = array();
$num_posts = wp_count_posts('page','readable');
$total_posts = array_sum((array)$num_posts) - $num_posts->trash;
$class = (empty($_GET[0]['post_status']) || Aspis_empty($_GET[0]['post_status'])) ? ' class="current"' : '';
$status_links[] = "<li><a href='edit-pages.php'$class>" . sprintf(_nx('All <span class="count">(%s)</span>','All <span class="count">(%s)</span>',$total_posts,'pages'),number_format_i18n($total_posts)) . '</a>';
foreach ( $post_stati as $status =>$label )
{$class = '';
if ( !in_array($status,$avail_post_stati) || $num_posts->$status <= 0)
 continue ;
if ( (isset($_GET[0]['post_status']) && Aspis_isset($_GET[0]['post_status'])) && $status == deAspisWarningRC($_GET[0]['post_status']))
 $class = ' class="current"';
$status_links[] = "<li><a href='edit-pages.php?post_status=$status'$class>" . sprintf(_nx($label[2][0],$label[2][1],$num_posts->$status,$label[2][2]),number_format_i18n($num_posts->$status)) . '</a>';
}echo implode(" |</li>\n",$status_links) . '</li>';
unset($status_links);
};
?>
</ul>

<p class="search-box">
	<label class="screen-reader-text" for="page-search-input"><?php _e('Search Pages');
;
?>:</label>
	<input type="text" id="page-search-input" name="s" value="<?php _admin_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e('Search Pages');
;
?>" class="button" />
</p>

<input type="hidden" name="post_status" class="post_status_page" value="<?php echo !(empty($_GET[0]['post_status']) || Aspis_empty($_GET[0]['post_status'])) ? esc_attr(deAspisWarningRC($_GET[0]['post_status'])) : 'all';
;
?>" />

<?php if ( $posts)
 {;
?>

<div class="tablenav">

<?php $pagenum = (isset($_GET[0]['pagenum']) && Aspis_isset($_GET[0]['pagenum'])) ? absint(deAspisWarningRC($_GET[0]['pagenum'])) : 0;
if ( empty($pagenum))
 $pagenum = 1;
$per_page = (int)get_user_option('edit_pages_per_page',0,false);
if ( empty($per_page) || $per_page < 1)
 $per_page = 20;
$per_page = apply_filters('edit_pages_per_page',$per_page);
$num_pages = ceil($wp_query->post_count / $per_page);
$page_links = paginate_links(array('base' => add_query_arg('pagenum','%#%'),'format' => '','prev_text' => __('&laquo;'),'next_text' => __('&raquo;'),'total' => $num_pages,'current' => $pagenum));
$is_trash = (isset($_GET[0]['post_status']) && Aspis_isset($_GET[0]['post_status'])) && deAspisWarningRC($_GET[0]['post_status']) == 'trash';
if ( $page_links)
 {;
?>
<div class="tablenav-pages"><?php $page_links_text = sprintf('<span class="displaying-num">' . __('Displaying %s&#8211;%s of %s') . '</span>%s',number_format_i18n(($pagenum - 1) * $per_page + 1),number_format_i18n(min($pagenum * $per_page,$wp_query->post_count)),number_format_i18n($wp_query->post_count),$page_links);
echo $page_links_text;
;
?></div>
<?php };
?>

<div class="alignleft actions">
<select name="action">
<option value="-1" selected="selected"><?php _e('Bulk Actions');
;
?></option>
<?php if ( $is_trash)
 {;
?>
<option value="untrash"><?php _e('Restore');
;
?></option>
<?php }else 
{{;
?>
<option value="edit"><?php _e('Edit');
;
?></option>
<?php }}if ( $is_trash || !EMPTY_TRASH_DAYS)
 {;
?>
<option value="delete"><?php _e('Delete Permanently');
;
?></option>
<?php }else 
{{;
?>
<option value="trash"><?php _e('Move to Trash');
;
?></option>
<?php }};
?>
</select>
<input type="submit" value="<?php esc_attr_e('Apply');
;
?>" name="doaction" id="doaction" class="button-secondary action" />
<?php wp_nonce_field('bulk-pages');
;
?>
<?php if ( $is_trash)
 {;
?>
<input type="submit" name="delete_all" id="delete_all" value="<?php esc_attr_e('Empty Trash');
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
<?php print_column_headers('edit-pages');
;
?>
  </tr>
  </thead>

  <tfoot>
  <tr>
<?php print_column_headers('edit-pages',false);
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
<?php if ( $page_links)
 echo "<div class='tablenav-pages'>$page_links_text</div>";
;
?>

<div class="alignleft actions">
<select name="action2">
<option value="-1" selected="selected"><?php _e('Bulk Actions');
;
?></option>
<?php if ( $is_trash)
 {;
?>
<option value="untrash"><?php _e('Restore');
;
?></option>
<?php }else 
{{;
?>
<option value="edit"><?php _e('Edit');
;
?></option>
<?php }}if ( $is_trash || !EMPTY_TRASH_DAYS)
 {;
?>
<option value="delete"><?php _e('Delete Permanently');
;
?></option>
<?php }else 
{{;
?>
<option value="trash"><?php _e('Move to Trash');
;
?></option>
<?php }};
?>
</select>
<input type="submit" value="<?php esc_attr_e('Apply');
;
?>" name="doaction2" id="doaction2" class="button-secondary action" />
<?php if ( $is_trash)
 {;
?>
<input type="submit" name="delete_all2" id="delete_all2" value="<?php esc_attr_e('Empty Trash');
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
<p><?php _e('No pages found.');
?></p>
<?php }};
?>

</form>

<?php inline_edit_row('page');
?>

<div id="ajax-response"></div>


<?php if ( 1 == count($posts) && is_singular())
 {$comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved != 'spam' ORDER BY comment_date",$id));
if ( $comments)
 {update_comment_cache($comments);
$post = get_post($id);
$authordata = get_userdata($post->post_author);
;
?>

<br class="clear" />

<table class="widefat" cellspacing="0">
<thead>
  <tr>
    <th scope="col" class="column-comment">
		<?php echo _x('Comment','column name');
?>
	</th>
    <th scope="col" class="column-author"><?php _e('Author');
?></th>
    <th scope="col" class="column-date"><?php _e('Submitted');
?></th>
  </tr>
</thead>
<tbody id="the-comment-list" class="list:comment">
<?php foreach ( $comments as $comment  )
_wp_comment_row($comment->comment_ID,'single',false,false);
;
?>
</tbody>
</table>

<?php wp_comment_reply();
}};
?>

</div>

<?php include ('admin-footer.php');
