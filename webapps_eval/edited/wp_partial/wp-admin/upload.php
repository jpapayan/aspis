<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
wp_enqueue_script('wp-ajax-response');
wp_enqueue_script('jquery-ui-draggable');
if ( !current_user_can('upload_files'))
 wp_die(__('You do not have permission to upload files.'));
if ( (isset($_GET[0]['find_detached']) && Aspis_isset($_GET[0]['find_detached'])))
 {check_admin_referer('bulk-media');
if ( !current_user_can('edit_posts'))
 wp_die(__('You are not allowed to scan for lost attachments.'));
$all_posts = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_type = 'post' OR post_type = 'page'");
$all_att = $wpdb->get_results("SELECT ID, post_parent FROM $wpdb->posts WHERE post_type = 'attachment'");
$lost = array();
foreach ( (array)$all_att as $att  )
{if ( $att->post_parent > 0 && !in_array($att->post_parent,$all_posts))
 $lost[] = $att->ID;
}$_GET[0]['detached'] = attAspisRCO(1);
}elseif ( (isset($_GET[0]['found_post_id']) && Aspis_isset($_GET[0]['found_post_id'])) && (isset($_GET[0]['media']) && Aspis_isset($_GET[0]['media'])))
 {check_admin_referer('bulk-media');
if ( !($parent_id = (int)deAspisWarningRC($_GET[0]['found_post_id'])))
 {return ;
}$parent = &get_post($parent_id);
if ( !current_user_can('edit_post',$parent_id))
 wp_die(__('You are not allowed to edit this post.'));
$attach = array();
foreach ( (array)deAspisWarningRC($_GET[0]['media']) as $att_id  )
{$att_id = (int)$att_id;
if ( !current_user_can('edit_post',$att_id))
 continue ;
$attach[] = $att_id;
}if ( !empty($attach))
 {$attach = implode(',',$attach);
$attached = $wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET post_parent = %d WHERE post_type = 'attachment' AND ID IN ($attach)",$parent_id));
}if ( isset($attached))
 {$location = 'upload.php';
if ( $referer = wp_get_referer())
 {if ( false !== strpos($referer,'upload.php'))
 $location = $referer;
}$location = add_query_arg(array('attached' => $attached),$location);
wp_redirect($location);
exit();
}}elseif ( (isset($_GET[0]['doaction']) && Aspis_isset($_GET[0]['doaction'])) || (isset($_GET[0]['doaction2']) && Aspis_isset($_GET[0]['doaction2'])) || (isset($_GET[0]['delete_all']) && Aspis_isset($_GET[0]['delete_all'])) || (isset($_GET[0]['delete_all2']) && Aspis_isset($_GET[0]['delete_all2'])))
 {check_admin_referer('bulk-media');
if ( (isset($_GET[0]['delete_all']) && Aspis_isset($_GET[0]['delete_all'])) || (isset($_GET[0]['delete_all2']) && Aspis_isset($_GET[0]['delete_all2'])))
 {$post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_type='attachment' AND post_status = 'trash'");
$doaction = 'delete';
}elseif ( (deAspisWarningRC($_GET[0]['action']) != -1 || deAspisWarningRC($_GET[0]['action2']) != -1) && ((isset($_GET[0]['media']) && Aspis_isset($_GET[0]['media'])) || (isset($_GET[0]['ids']) && Aspis_isset($_GET[0]['ids']))))
 {$post_ids = (isset($_GET[0]['media']) && Aspis_isset($_GET[0]['media'])) ? deAspisWarningRC($_GET[0]['media']) : explode(',',deAspisWarningRC($_GET[0]['ids']));
$doaction = (deAspisWarningRC($_GET[0]['action']) != -1) ? deAspisWarningRC($_GET[0]['action']) : deAspisWarningRC($_GET[0]['action2']);
}else 
{{wp_redirect(deAspisWarningRC($_SERVER[0]['HTTP_REFERER']));
}}$location = 'upload.php';
if ( $referer = wp_get_referer())
 {if ( false !== strpos($referer,'upload.php'))
 $location = remove_query_arg(array('trashed','untrashed','deleted','message','ids','posted'),$referer);
}switch ( $doaction ) {
case 'trash':foreach ( (array)$post_ids as $post_id  )
{if ( !current_user_can('delete_post',$post_id))
 wp_die(__('You are not allowed to move this post to the trash.'));
if ( !wp_trash_post($post_id))
 wp_die(__('Error in moving to trash...'));
}$location = add_query_arg(array('message' => 4,'ids' => join(',',$post_ids)),$location);
break ;
case 'untrash':foreach ( (array)$post_ids as $post_id  )
{if ( !current_user_can('delete_post',$post_id))
 wp_die(__('You are not allowed to move this post out of the trash.'));
if ( !wp_untrash_post($post_id))
 wp_die(__('Error in restoring from trash...'));
}$location = add_query_arg('message',5,$location);
break ;
case 'delete':foreach ( (array)$post_ids as $post_id_del  )
{if ( !current_user_can('delete_post',$post_id_del))
 wp_die(__('You are not allowed to delete this post.'));
if ( !wp_delete_attachment($post_id_del))
 wp_die(__('Error in deleting...'));
}$location = add_query_arg('message',2,$location);
break ;
 }
wp_redirect($location);
exit();
}elseif ( (isset($_GET[0]['_wp_http_referer']) && Aspis_isset($_GET[0]['_wp_http_referer'])) && !(empty($_GET[0]['_wp_http_referer']) || Aspis_empty($_GET[0]['_wp_http_referer'])))
 {wp_redirect(remove_query_arg(array('_wp_http_referer','_wpnonce'),stripslashes(deAspisWarningRC($_SERVER[0]['REQUEST_URI']))));
exit();
}$title = __('Media Library');
$parent_file = 'upload.php';
if ( !(isset($_GET[0]['paged']) && Aspis_isset($_GET[0]['paged'])) || deAspisWarningRC($_GET[0]['paged']) < 1)
 $_GET[0]['paged'] = attAspisRCO(1);
if ( (isset($_GET[0]['detached']) && Aspis_isset($_GET[0]['detached'])))
 {$media_per_page = (int)get_user_option('upload_per_page',0,false);
if ( empty($media_per_page) || $media_per_page < 1)
 $media_per_page = 20;
$media_per_page = apply_filters('upload_per_page',$media_per_page);
if ( !empty($lost))
 {$start = ((int)deAspisWarningRC($_GET[0]['paged']) - 1) * $media_per_page;
$page_links_total = ceil(count($lost) / $media_per_page);
$lost = implode(',',$lost);
$orphans = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' AND ID IN (%s) LIMIT %d, %d",$lost,$start,$media_per_page));
}else 
{{$start = ((int)deAspisWarningRC($_GET[0]['paged']) - 1) * $media_per_page;
$orphans = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status != 'trash' AND post_parent < 1 LIMIT %d, %d",$start,$media_per_page));
$page_links_total = ceil($wpdb->get_var("SELECT FOUND_ROWS()") / $media_per_page);
}}$post_mime_types = get_post_mime_types();
$avail_post_mime_types = get_available_post_mime_types('attachment');
if ( (isset($_GET[0]['post_mime_type']) && Aspis_isset($_GET[0]['post_mime_type'])) && !array_intersect((array)deAspisWarningRC($_GET[0]['post_mime_type']),array_keys($post_mime_types)))
 unset($_GET[0]['post_mime_type']);
}else 
{{list($post_mime_types,$avail_post_mime_types) = wp_edit_attachments_query();
}}$is_trash = ((isset($_GET[0]['status']) && Aspis_isset($_GET[0]['status'])) && deAspisWarningRC($_GET[0]['status']) == 'trash');
wp_enqueue_script('media');
require_once ('admin-header.php');
do_action('restrict_manage_posts');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo esc_html($title);
;
?> <a href="media-new.php" class="button add-new-h2"><?php echo esc_html_x('Add New','file');
;
?></a> <?php if ( (isset($_GET[0]['s']) && Aspis_isset($_GET[0]['s'])) && deAspisWarningRC($_GET[0]['s']))
 printf('<span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>',esc_html(get_search_query()));
;
?>
</h2>

<?php $message = '';
if ( (isset($_GET[0]['posted']) && Aspis_isset($_GET[0]['posted'])) && (int)deAspisWarningRC($_GET[0]['posted']))
 {$_GET[0]['message'] = attAspisRCO('1');
$_SERVER[0]['REQUEST_URI'] = attAspisRCO(remove_query_arg(array('posted'),deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
}if ( (isset($_GET[0]['attached']) && Aspis_isset($_GET[0]['attached'])) && (int)deAspisWarningRC($_GET[0]['attached']))
 {$attached = (int)deAspisWarningRC($_GET[0]['attached']);
$message = sprintf(_n('Reattached %d attachment','Reattached %d attachments',$attached),$attached);
$_SERVER[0]['REQUEST_URI'] = attAspisRCO(remove_query_arg(array('attached'),deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
}if ( (isset($_GET[0]['deleted']) && Aspis_isset($_GET[0]['deleted'])) && (int)deAspisWarningRC($_GET[0]['deleted']))
 {$_GET[0]['message'] = attAspisRCO('2');
$_SERVER[0]['REQUEST_URI'] = attAspisRCO(remove_query_arg(array('deleted'),deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
}if ( (isset($_GET[0]['trashed']) && Aspis_isset($_GET[0]['trashed'])) && (int)deAspisWarningRC($_GET[0]['trashed']))
 {$_GET[0]['message'] = attAspisRCO('4');
$_SERVER[0]['REQUEST_URI'] = attAspisRCO(remove_query_arg(array('trashed'),deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
}if ( (isset($_GET[0]['untrashed']) && Aspis_isset($_GET[0]['untrashed'])) && (int)deAspisWarningRC($_GET[0]['untrashed']))
 {$_GET[0]['message'] = attAspisRCO('5');
$_SERVER[0]['REQUEST_URI'] = attAspisRCO(remove_query_arg(array('untrashed'),deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
}$messages[1] = __('Media attachment updated.');
$messages[2] = __('Media permanently deleted.');
$messages[3] = __('Error saving media attachment.');
$messages[4] = __('Media moved to the trash.') . ' <a href="' . esc_url(wp_nonce_url('upload.php?doaction=undo&action=untrash&ids=' . ((isset($_GET[0]['ids']) && Aspis_isset($_GET[0]['ids'])) ? deAspisWarningRC($_GET[0]['ids']) : ''),"bulk-media")) . '">' . __('Undo') . '</a>';
$messages[5] = __('Media restored from the trash.');
if ( (isset($_GET[0]['message']) && Aspis_isset($_GET[0]['message'])) && (int)deAspisWarningRC($_GET[0]['message']))
 {$message = $messages[deAspisWarningRC($_GET[0]['message'])];
$_SERVER[0]['REQUEST_URI'] = attAspisRCO(remove_query_arg(array('message'),deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
}if ( !empty($message))
 {;
?>
<div id="message" class="updated fade"><p><?php echo $message;
;
?></p></div>
<?php };
?>

<ul class="subsubsub">
<?php $type_links = array();
$_num_posts = (array)wp_count_attachments();
$_total_posts = array_sum($_num_posts) - $_num_posts['trash'];
$matches = wp_match_mime_types(array_keys($post_mime_types),array_keys($_num_posts));
foreach ( $matches as $type =>$reals )
foreach ( $reals as $real  )
$num_posts[$type] = (isset($num_posts[$type])) ? $num_posts[$type] + $_num_posts[$real] : $_num_posts[$real];
$class = ((empty($_GET[0]['post_mime_type']) || Aspis_empty($_GET[0]['post_mime_type'])) && !(isset($_GET[0]['detached']) && Aspis_isset($_GET[0]['detached'])) && !(isset($_GET[0]['status']) && Aspis_isset($_GET[0]['status']))) ? ' class="current"' : '';
$type_links[] = "<li><a href='upload.php'$class>" . sprintf(_nx('All <span class="count">(%s)</span>','All <span class="count">(%s)</span>',$_total_posts,'uploaded files'),number_format_i18n($_total_posts)) . '</a>';
foreach ( $post_mime_types as $mime_type =>$label )
{$class = '';
if ( !wp_match_mime_types($mime_type,$avail_post_mime_types))
 continue ;
if ( !(empty($_GET[0]['post_mime_type']) || Aspis_empty($_GET[0]['post_mime_type'])) && wp_match_mime_types($mime_type,deAspisWarningRC($_GET[0]['post_mime_type'])))
 $class = ' class="current"';
$type_links[] = "<li><a href='upload.php?post_mime_type=$mime_type'$class>" . sprintf(_n($label[2][0],$label[2][1],$num_posts[$mime_type]),number_format_i18n($num_posts[$mime_type])) . '</a>';
}$type_links[] = '<li><a href="upload.php?detached=1"' . ((isset($_GET[0]['detached']) && Aspis_isset($_GET[0]['detached'])) ? ' class="current"' : '') . '>' . __('Unattached') . '</a>';
if ( EMPTY_TRASH_DAYS && (MEDIA_TRASH || !empty($_num_posts['trash'])))
 $type_links[] = '<li><a href="upload.php?status=trash"' . (((isset($_GET[0]['status']) && Aspis_isset($_GET[0]['status'])) && deAspisWarningRC($_GET[0]['status']) == 'trash') ? ' class="current"' : '') . '>' . sprintf(_nx('Trash <span class="count">(%s)</span>','Trash <span class="count">(%s)</span>',$_num_posts['trash'],'uploaded files'),number_format_i18n($_num_posts['trash'])) . '</a>';
echo implode(" |</li>\n",$type_links) . '</li>';
unset($type_links);
;
?>
</ul>

<form class="search-form" action="" method="get">
<p class="search-box">
	<label class="screen-reader-text" for="media-search-input"><?php _e('Search Media');
;
?>:</label>
	<input type="text" id="media-search-input" name="s" value="<?php the_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e('Search Media');
;
?>" class="button" />
</p>
</form>

<form id="posts-filter" action="" method="get">
<div class="tablenav">
<?php if ( !isset($page_links_total))
 $page_links_total = $wp_query->max_num_pages;
$page_links = paginate_links(array('base' => add_query_arg('paged','%#%'),'format' => '','prev_text' => __('&laquo;'),'next_text' => __('&raquo;'),'total' => $page_links_total,'current' => deAspisWarningRC($_GET[0]['paged'])));
if ( $page_links)
 {;
?>
<div class="tablenav-pages"><?php $page_links_text = sprintf('<span class="displaying-num">' . __('Displaying %s&#8211;%s of %s') . '</span>%s',number_format_i18n((deAspisWarningRC($_GET[0]['paged']) - 1) * $wp_query->query_vars['posts_per_page'] + 1),number_format_i18n(min(deAspisWarningRC($_GET[0]['paged']) * $wp_query->query_vars['posts_per_page'],$wp_query->found_posts)),number_format_i18n($wp_query->found_posts),$page_links);
echo $page_links_text;
;
?></div>
<?php };
?>

<div class="alignleft actions">
<select name="action" class="select-action">
<option value="-1" selected="selected"><?php _e('Bulk Actions');
;
?></option>
<?php if ( $is_trash)
 {;
?>
<option value="untrash"><?php _e('Restore');
;
?></option>
<?php }if ( $is_trash || !EMPTY_TRASH_DAYS || !MEDIA_TRASH)
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
<?php }}if ( isset($orphans))
 {;
?>
<option value="attach"><?php _e('Attach to a post');
;
?></option>
<?php };
?>
</select>
<input type="submit" value="<?php esc_attr_e('Apply');
;
?>" name="doaction" id="doaction" class="button-secondary action" />
<?php wp_nonce_field('bulk-media');
;
?>

<?php if ( !is_singular() && !(isset($_GET[0]['detached']) && Aspis_isset($_GET[0]['detached'])) && !$is_trash)
 {$arc_query = "SELECT DISTINCT YEAR(post_date) AS yyear, MONTH(post_date) AS mmonth FROM $wpdb->posts WHERE post_type = 'attachment' ORDER BY post_date DESC";
$arc_result = $wpdb->get_results($arc_query);
$month_count = count($arc_result);
if ( $month_count && !(1 == $month_count && 0 == $arc_result[0]->mmonth))
 {;
?>
<select name='m'>
<option value='0'><?php _e('Show all dates');
;
?></option>
<?php foreach ( $arc_result as $arc_row  )
{if ( $arc_row->yyear == 0)
 continue ;
$arc_row->mmonth = zeroise($arc_row->mmonth,2);
if ( (isset($_GET[0]['m']) && Aspis_isset($_GET[0]['m'])) && ($arc_row->yyear . $arc_row->mmonth == deAspisWarningRC($_GET[0]['m'])))
 $default = ' selected="selected"';
else 
{$default = '';
}echo "<option$default value='" . esc_attr("$arc_row->yyear$arc_row->mmonth") . "'>";
echo $wp_locale->get_month($arc_row->mmonth) . " $arc_row->yyear";
echo "</option>\n";
};
?>
</select>
<?php };
?>

<input type="submit" id="post-query-submit" value="<?php esc_attr_e('Filter');
;
?>" class="button-secondary" />

<?php };
?>

<?php if ( (isset($_GET[0]['detached']) && Aspis_isset($_GET[0]['detached'])))
 {;
?>
	<input type="submit" id="find_detached" name="find_detached" value="<?php esc_attr_e('Scan for lost attachments');
;
?>" class="button-secondary" />
<?php }elseif ( (isset($_GET[0]['status']) && Aspis_isset($_GET[0]['status'])) && deAspisWarningRC($_GET[0]['status']) == 'trash' && current_user_can('edit_others_posts'))
 {;
?>
	<input type="submit" id="delete_all" name="delete_all" value="<?php esc_attr_e('Empty Trash');
;
?>" class="button-secondary apply" />
<?php };
?>

</div>

<br class="clear" />
</div>

<div class="clear"></div>

<?php if ( isset($orphans))
 {;
?>
<table class="widefat" cellspacing="0">
<thead>
<tr>
	<th scope="col" class="check-column"><input type="checkbox" /></th>
	<th scope="col"></th>
	<th scope="col"><?php echo _x('Media','media column name');
;
?></th>
	<th scope="col"><?php echo _x('Author','media column name');
;
?></th>
	<th scope="col"><?php echo _x('Date Added','media column name');
;
?></th>
</tr>
</thead>

<tfoot>
<tr>
	<th scope="col" class="check-column"><input type="checkbox" /></th>
	<th scope="col"></th>
	<th scope="col"><?php echo _x('Media','media column name');
;
?></th>
	<th scope="col"><?php echo _x('Author','media column name');
;
?></th>
	<th scope="col"><?php echo _x('Date Added','media column name');
;
?></th>
</tr>
</tfoot>

<tbody id="the-list" class="list:post">
<?php if ( $orphans)
 {foreach ( $orphans as $post  )
{$class = 'alternate' == $class ? '' : 'alternate';
$att_title = esc_html(_draft_or_post_title($post->ID));
;
?>
	<tr id='post-<?php echo $post->ID;
;
?>' class='<?php echo $class;
;
?>' valign="top">
		<th scope="row" class="check-column"><?php if ( current_user_can('edit_post',$post->ID))
 {;
?><input type="checkbox" name="media[]" value="<?php echo esc_attr($post->ID);
;
?>" /><?php };
?></th>

		<td class="media-icon"><?php if ( $thumb = wp_get_attachment_image($post->ID,array(80,60),true))
 {;
?>
			<a href="media.php?action=edit&amp;attachment_id=<?php echo $post->ID;
;
?>" title="<?php echo esc_attr(sprintf(__('Edit &#8220;%s&#8221;'),$att_title));
;
?>"><?php echo $thumb;
;
?></a>
<?php };
?></td>

		<td class="media column-media"><strong><a href="<?php echo get_edit_post_link($post->ID);
;
?>" title="<?php echo esc_attr(sprintf(__('Edit &#8220;%s&#8221;'),$att_title));
;
?>"><?php echo $att_title;
;
?></a></strong><br />
		<?php echo strtoupper(preg_replace('/^.*?\.(\w+)$/','$1',get_attached_file($post->ID)));
;
?>

		<div class="row-actions">
		<?php $actions = array();
if ( current_user_can('edit_post',$post->ID))
 $actions['edit'] = '<a href="' . get_edit_post_link($post->ID,true) . '">' . __('Edit') . '</a>';
if ( current_user_can('delete_post',$post->ID))
 if ( EMPTY_TRASH_DAYS && MEDIA_TRASH)
 {$actions['trash'] = "<a class='submitdelete' href='" . wp_nonce_url("post.php?action=trash&amp;
post=$post->ID",'trash-post_' . $post->ID) . "'>" . __('Trash') . "</a>";
}else 
{{$delete_ays = !MEDIA_TRASH ? " onclick='return showNotice.warn();'" : '';
$actions['delete'] = "<a class='submitdelete'$delete_ays href='" . wp_nonce_url("post.php?action=delete&amp;
post=$post->ID",'delete-post_' . $post->ID) . "'>" . __('Delete Permanently') . "</a>";
}}$actions['view'] = '<a href="' . get_permalink($post->ID) . '" title="' . esc_attr(sprintf(__('View &#8220;%s&#8221;'),$title)) . '" rel="permalink">' . __('View') . '</a>';
if ( current_user_can('edit_post',$post->ID))
 $actions['attach'] = '<a href="#the-list" onclick="findPosts.open(\'media[]\',\'' . $post->ID . '\');return false;" class="hide-if-no-js">' . __('Attach') . '</a>';
$actions = apply_filters('media_row_actions',$actions,$post);
$action_count = count($actions);
$i = 0;
foreach ( $actions as $action =>$link )
{++$i;
($i == $action_count) ? $sep = '' : $sep = ' | ';
echo "<span class='$action'>$link$sep</span>";
};
?>
		</div></td>
		<td class="author column-author"><?php $author = get_userdata($post->post_author);
echo $author->display_name;
;
?></td>
<?php if ( '0000-00-00 00:00:00' == $post->post_date && 'date' == $column_name)
 {$t_time = $h_time = __('Unpublished');
}else 
{{$t_time = get_the_time(__('Y/m/d g:i:s A'));
$m_time = $post->post_date;
$time = get_post_time('G',true);
if ( (abs($t_diff = time() - $time)) < 86400)
 {if ( $t_diff < 0)
 $h_time = sprintf(__('%s from now'),human_time_diff($time));
else 
{$h_time = sprintf(__('%s ago'),human_time_diff($time));
}}else 
{{$h_time = mysql2date(__('Y/m/d'),$m_time);
}}}};
?>
		<td class="date column-date"><?php echo $h_time;
?></td>
	</tr>
<?php }}else 
{{;
?>
	<tr><td colspan="5"><?php _e('No media attachments found.');
?></td></tr>
<?php }};
?>
</tbody>
</table>

<?php }else 
{{include ('edit-attachment-rows.php');
}};
?>

<div id="ajax-response"></div>

<div class="tablenav">

<?php if ( $page_links)
 echo "<div class='tablenav-pages'>$page_links_text</div>";
;
?>

<div class="alignleft actions">
<select name="action2" class="select-action">
<option value="-1" selected="selected"><?php _e('Bulk Actions');
;
?></option>
<?php if ( $is_trash)
 {;
?>
<option value="untrash"><?php _e('Restore');
;
?></option>
<?php }if ( $is_trash || !EMPTY_TRASH_DAYS || !MEDIA_TRASH)
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
<?php }}if ( isset($orphans))
 {;
?>
<option value="attach"><?php _e('Attach to a post');
;
?></option>
<?php };
?>
</select>
<input type="submit" value="<?php esc_attr_e('Apply');
;
?>" name="doaction2" id="doaction2" class="button-secondary action" />

<?php if ( (isset($_GET[0]['status']) && Aspis_isset($_GET[0]['status'])) && deAspisWarningRC($_GET[0]['status']) == 'trash' && current_user_can('edit_others_posts'))
 {;
?>
	<input type="submit" id="delete_all2" name="delete_all2" value="<?php esc_attr_e('Empty Trash');
;
?>" class="button-secondary apply" />
<?php };
?>
</div>

<br class="clear" />
</div>
<?php find_posts_div();
;
?>
</form>
<br class="clear" />

</div>

<?php include ('admin-footer.php');