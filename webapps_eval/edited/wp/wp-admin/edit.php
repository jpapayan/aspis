<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
if ( deAspis($_redirect = Aspis_intval(attAspisRC(max(deAspisRC(@$_GET[0]['p']),deAspisRC(@$_GET[0]['attachment_id']),deAspisRC(@$_GET[0]['page_id']))))))
 {wp_redirect(admin_url(concat1('edit-comments.php?p=',$_redirect)));
Aspis_exit();
}else 
{{unset($_redirect);
}}if ( ((((((isset($_GET[0][('doaction')]) && Aspis_isset( $_GET [0][('doaction')]))) || ((isset($_GET[0][('doaction2')]) && Aspis_isset( $_GET [0][('doaction2')])))) || ((isset($_GET[0][('delete_all')]) && Aspis_isset( $_GET [0][('delete_all')])))) || ((isset($_GET[0][('delete_all2')]) && Aspis_isset( $_GET [0][('delete_all2')])))) || ((isset($_GET[0][('bulk_edit')]) && Aspis_isset( $_GET [0][('bulk_edit')])))))
 {check_admin_referer(array('bulk-posts',false));
$sendback = remove_query_arg(array(array(array('trashed',false),array('untrashed',false),array('deleted',false),array('ids',false)),false),wp_get_referer());
if ( (strpos($sendback[0],'post.php') !== false))
 $sendback = admin_url(array('post-new.php',false));
if ( (((isset($_GET[0][('delete_all')]) && Aspis_isset( $_GET [0][('delete_all')]))) || ((isset($_GET[0][('delete_all2')]) && Aspis_isset( $_GET [0][('delete_all2')])))))
 {$post_status = Aspis_preg_replace(array('/[^a-z0-9_-]+/i',false),array('',false),$_GET[0]['post_status']);
$post_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_type='post' AND post_status = %s"),$post_status));
$doaction = array('delete',false);
}elseif ( (((deAspis($_GET[0]['action']) != deAspis(negate(array(1,false)))) || (deAspis($_GET[0]['action2']) != deAspis(negate(array(1,false))))) && (((isset($_GET[0][('post')]) && Aspis_isset( $_GET [0][('post')]))) || ((isset($_GET[0][('ids')]) && Aspis_isset( $_GET [0][('ids')]))))))
 {$post_ids = ((isset($_GET[0][('post')]) && Aspis_isset( $_GET [0][('post')]))) ? attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC(array_cast($_GET[0]['post'])))) : Aspis_explode(array(',',false),$_GET[0]['ids']);
$doaction = (deAspis($_GET[0]['action']) != deAspis(negate(array(1,false)))) ? $_GET[0]['action'] : $_GET[0]['action2'];
}else 
{{wp_redirect(admin_url(array('edit.php',false)));
}}switch ( $doaction[0] ) {
case ('trash'):$trashed = array(0,false);
foreach ( deAspis(array_cast($post_ids)) as $post_id  )
{if ( (denot_boolean(current_user_can(array('delete_post',false),$post_id))))
 wp_die(__(array('You are not allowed to move this post to the trash.',false)));
if ( (denot_boolean(wp_trash_post($post_id))))
 wp_die(__(array('Error in moving to trash...',false)));
postincr($trashed);
}$sendback = add_query_arg(array(array(deregisterTaint(array('trashed',false)) => addTaint($trashed),deregisterTaint(array('ids',false)) => addTaint(Aspis_join(array(',',false),$post_ids))),false),$sendback);
break ;
case ('untrash'):$untrashed = array(0,false);
foreach ( deAspis(array_cast($post_ids)) as $post_id  )
{if ( (denot_boolean(current_user_can(array('delete_post',false),$post_id))))
 wp_die(__(array('You are not allowed to restore this post from the trash.',false)));
if ( (denot_boolean(wp_untrash_post($post_id))))
 wp_die(__(array('Error in restoring from trash...',false)));
postincr($untrashed);
}$sendback = add_query_arg(array('untrashed',false),$untrashed,$sendback);
break ;
case ('delete'):$deleted = array(0,false);
foreach ( deAspis(array_cast($post_ids)) as $post_id  )
{$post_del = &get_post($post_id);
if ( (denot_boolean(current_user_can(array('delete_post',false),$post_id))))
 wp_die(__(array('You are not allowed to delete this post.',false)));
if ( ($post_del[0]->post_type[0] == ('attachment')))
 {if ( (denot_boolean(wp_delete_attachment($post_id))))
 wp_die(__(array('Error in deleting...',false)));
}else 
{{if ( (denot_boolean(wp_delete_post($post_id))))
 wp_die(__(array('Error in deleting...',false)));
}}postincr($deleted);
}$sendback = add_query_arg(array('deleted',false),$deleted,$sendback);
break ;
case ('edit'):$done = bulk_edit_posts($_GET);
if ( is_array($done[0]))
 {arrayAssign($done[0],deAspis(registerTaint(array('updated',false))),addTaint(attAspis(count(deAspis($done[0]['updated'])))));
arrayAssign($done[0],deAspis(registerTaint(array('skipped',false))),addTaint(attAspis(count(deAspis($done[0]['skipped'])))));
arrayAssign($done[0],deAspis(registerTaint(array('locked',false))),addTaint(attAspis(count(deAspis($done[0]['locked'])))));
$sendback = add_query_arg($done,$sendback);
}break ;
 }
if ( ((isset($_GET[0][('action')]) && Aspis_isset( $_GET [0][('action')]))))
 $sendback = remove_query_arg(array(array(array('action',false),array('action2',false),array('cat',false),array('tags_input',false),array('post_author',false),array('comment_status',false),array('ping_status',false),array('_status',false),array('post',false),array('bulk_edit',false),array('post_view',false),array('post_type',false)),false),$sendback);
wp_redirect($sendback);
Aspis_exit();
}elseif ( (((isset($_GET[0][('_wp_http_referer')]) && Aspis_isset( $_GET [0][('_wp_http_referer')]))) && (!((empty($_GET[0][('_wp_http_referer')]) || Aspis_empty( $_GET [0][('_wp_http_referer')]))))))
 {wp_redirect(remove_query_arg(array(array(array('_wp_http_referer',false),array('_wpnonce',false)),false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
Aspis_exit();
}if ( ((empty($title) || Aspis_empty( $title))))
 $title = __(array('Edit Posts',false));
$parent_file = array('edit.php',false);
wp_enqueue_script(array('inline-edit-post',false));
$user_posts = array(false,false);
if ( (denot_boolean(current_user_can(array('edit_others_posts',false)))))
 {$user_posts_count = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT COUNT(1) FROM ",$wpdb[0]->posts)," WHERE post_type = 'post' AND post_status != 'trash' AND post_author = %d"),$current_user[0]->ID));
$user_posts = array(true,false);
if ( ((($user_posts_count[0] && ((empty($_GET[0][('post_status')]) || Aspis_empty( $_GET [0][('post_status')])))) && ((empty($_GET[0][('all_posts')]) || Aspis_empty( $_GET [0][('all_posts')])))) && ((empty($_GET[0][('author')]) || Aspis_empty( $_GET [0][('author')])))))
 arrayAssign($_GET[0],deAspis(registerTaint(array('author',false))),addTaint($current_user[0]->ID));
}list($post_stati,$avail_post_stati) = deAspisList(wp_edit_posts_query(),array());
require_once ('admin-header.php');
if ( (!((isset($_GET[0][('paged')]) && Aspis_isset( $_GET [0][('paged')])))))
 arrayAssign($_GET[0],deAspis(registerTaint(array('paged',false))),addTaint(array(1,false)));
if ( ((empty($_GET[0][('mode')]) || Aspis_empty( $_GET [0][('mode')]))))
 $mode = array('list',false);
else 
{$mode = esc_attr($_GET[0]['mode']);
};
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?> <a href="post-new.php" class="button add-new-h2"><?php echo AspisCheckPrint(esc_html_x(array('Add New',false),array('post',false)));
;
?></a> <?php if ( (((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))) && deAspis($_GET[0]['s'])))
 printf((deconcat2(concat1('<span class="subtitle">',__(array('Search results for &#8220;%s&#8221;',false))),'</span>')),deAspisRC(esc_html(get_search_query())));
;
?>
</h2>

<?php if ( (((isset($_GET[0][('posted')]) && Aspis_isset( $_GET [0][('posted')]))) && deAspis($_GET[0]['posted'])))
 {arrayAssign($_GET[0],deAspis(registerTaint(array('posted',false))),addTaint(int_cast($_GET[0]['posted'])));
;
?>
<div id="message" class="updated fade"><p><strong><?php _e(array('Your post has been saved.',false));
;
?></strong> <a href="<?php echo AspisCheckPrint(get_permalink($_GET[0]['posted']));
;
?>"><?php _e(array('View post',false));
;
?></a> | <a href="<?php echo AspisCheckPrint(get_edit_post_link($_GET[0]['posted']));
;
?>"><?php _e(array('Edit post',false));
;
?></a></p></div>
<?php arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('posted',false)),false),$_SERVER[0]['REQUEST_URI'])));
};
?>

<?php if ( (((((((isset($_GET[0][('locked')]) && Aspis_isset( $_GET [0][('locked')]))) || ((isset($_GET[0][('skipped')]) && Aspis_isset( $_GET [0][('skipped')])))) || ((isset($_GET[0][('updated')]) && Aspis_isset( $_GET [0][('updated')])))) || ((isset($_GET[0][('deleted')]) && Aspis_isset( $_GET [0][('deleted')])))) || ((isset($_GET[0][('trashed')]) && Aspis_isset( $_GET [0][('trashed')])))) || ((isset($_GET[0][('untrashed')]) && Aspis_isset( $_GET [0][('untrashed')])))))
 {;
?>
<div id="message" class="updated fade"><p>
<?php if ( (((isset($_GET[0][('updated')]) && Aspis_isset( $_GET [0][('updated')]))) && deAspis(int_cast($_GET[0]['updated']))))
 {printf(deAspis(_n(array('%s post updated.',false),array('%s posts updated.',false),$_GET[0]['updated'])),deAspisRC(number_format_i18n($_GET[0]['updated'])));
unset($_GET[0][('updated')]);
}if ( (((isset($_GET[0][('skipped')]) && Aspis_isset( $_GET [0][('skipped')]))) && deAspis(int_cast($_GET[0]['skipped']))))
 unset($_GET[0][('skipped')]);
if ( (((isset($_GET[0][('locked')]) && Aspis_isset( $_GET [0][('locked')]))) && deAspis(int_cast($_GET[0]['locked']))))
 {printf(deAspis(_n(array('%s post not updated, somebody is editing it.',false),array('%s posts not updated, somebody is editing them.',false),$_GET[0]['locked'])),deAspisRC(number_format_i18n($_GET[0]['locked'])));
unset($_GET[0][('locked')]);
}if ( (((isset($_GET[0][('deleted')]) && Aspis_isset( $_GET [0][('deleted')]))) && deAspis(int_cast($_GET[0]['deleted']))))
 {printf(deAspis(_n(array('Post permanently deleted.',false),array('%s posts permanently deleted.',false),$_GET[0]['deleted'])),deAspisRC(number_format_i18n($_GET[0]['deleted'])));
unset($_GET[0][('deleted')]);
}if ( (((isset($_GET[0][('trashed')]) && Aspis_isset( $_GET [0][('trashed')]))) && deAspis(int_cast($_GET[0]['trashed']))))
 {printf(deAspis(_n(array('Post moved to the trash.',false),array('%s posts moved to the trash.',false),$_GET[0]['trashed'])),deAspisRC(number_format_i18n($_GET[0]['trashed'])));
$ids = ((isset($_GET[0][('ids')]) && Aspis_isset( $_GET [0][('ids')]))) ? $_GET[0]['ids'] : array(0,false);
echo AspisCheckPrint(concat2(concat(concat2(concat1(' <a href="',esc_url(wp_nonce_url(concat1("edit.php?doaction=undo&action=untrash&ids=",$ids),array("bulk-posts",false)))),'">'),__(array('Undo',false))),'</a><br />'));
unset($_GET[0][('trashed')]);
}if ( (((isset($_GET[0][('untrashed')]) && Aspis_isset( $_GET [0][('untrashed')]))) && deAspis(int_cast($_GET[0]['untrashed']))))
 {printf(deAspis(_n(array('Post restored from the trash.',false),array('%s posts restored from the trash.',false),$_GET[0]['untrashed'])),deAspisRC(number_format_i18n($_GET[0]['untrashed'])));
unset($_GET[0][('undeleted')]);
}arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('locked',false),array('skipped',false),array('updated',false),array('deleted',false),array('trashed',false),array('untrashed',false)),false),$_SERVER[0]['REQUEST_URI'])));
;
?>
</p></div>
<?php };
?>

<form id="posts-filter" action="<?php echo AspisCheckPrint(admin_url(array('edit.php',false)));
;
?>" method="get">

<ul class="subsubsub">
<?php if ( ((empty($locked_post_status) || Aspis_empty( $locked_post_status))))
 {$status_links = array(array(),false);
$num_posts = wp_count_posts(array('post',false),array('readable',false));
$class = array('',false);
$allposts = array('',false);
if ( $user_posts[0])
 {if ( (((isset($_GET[0][('author')]) && Aspis_isset( $_GET [0][('author')]))) && (deAspis($_GET[0]['author']) == $current_user[0]->ID[0])))
 $class = array(' class="current"',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1("<li><a href='edit.php?author=",$current_user[0]->ID),"'"),$class),">"),Aspis_sprintf(_nx(array('My Posts <span class="count">(%s)</span>',false),array('My Posts <span class="count">(%s)</span>',false),$user_posts_count,array('posts',false)),number_format_i18n($user_posts_count))),'</a>')));
$allposts = array('?all_posts=1',false);
}$total_posts = array(deAspis(attAspisRC(array_sum(deAspisRC(array_cast($num_posts))))) - $num_posts[0]->trash[0],false);
$class = (((empty($class) || Aspis_empty( $class))) && ((empty($_GET[0][('post_status')]) || Aspis_empty( $_GET [0][('post_status')])))) ? array(' class="current"',false) : array('',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1("<li><a href='edit.php",$allposts),"'"),$class),">"),Aspis_sprintf(_nx(array('All <span class="count">(%s)</span>',false),array('All <span class="count">(%s)</span>',false),$total_posts,array('posts',false)),number_format_i18n($total_posts))),'</a>')));
foreach ( $post_stati[0] as $status =>$label )
{restoreTaint($status,$label);
{$class = array('',false);
if ( (denot_boolean(Aspis_in_array($status,$avail_post_stati))))
 continue ;
if ( ((empty($num_posts[0]->$status[0]) || Aspis_empty( $num_posts[0] ->$status[0] ))))
 continue ;
if ( (((isset($_GET[0][('post_status')]) && Aspis_isset( $_GET [0][('post_status')]))) && ($status[0] == deAspis($_GET[0]['post_status']))))
 $class = array(' class="current"',false);
arrayAssignAdd($status_links[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1("<li><a href='edit.php?post_status=",$status),"'"),$class),">"),Aspis_sprintf(_n(attachAspis($label[0][(2)],(0)),attachAspis($label[0][(2)],(1)),$num_posts[0]->$status[0]),number_format_i18n($num_posts[0]->$status[0]))),'</a>')));
}}echo AspisCheckPrint(concat2(Aspis_implode(array(" |</li>\n",false),$status_links),'</li>'));
unset($status_links);
};
?>
</ul>

<p class="search-box">
	<label class="screen-reader-text" for="post-search-input"><?php _e(array('Search Posts',false));
;
?>:</label>
	<input type="text" id="post-search-input" name="s" value="<?php the_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e(array('Search Posts',false));
;
?>" class="button" />
</p>

<input type="hidden" name="post_status" class="post_status_page" value="<?php echo AspisCheckPrint((!((empty($_GET[0][('post_status')]) || Aspis_empty( $_GET [0][('post_status')])))) ? esc_attr($_GET[0]['post_status']) : array('all',false));
;
?>" />
<input type="hidden" name="mode" value="<?php echo AspisCheckPrint(esc_attr($mode));
;
?>" />

<?php if ( deAspis(have_posts()))
 {;
?>

<div class="tablenav">
<?php $page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('paged',false),array('%#%',false))),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint($wp_query[0]->max_num_pages),deregisterTaint(array('current',false)) => addTaint($_GET[0]['paged'])),false));
$is_trash = array(((isset($_GET[0][('post_status')]) && Aspis_isset( $_GET [0][('post_status')]))) && (deAspis($_GET[0]['post_status']) == ('trash')),false);
;
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
<?php wp_nonce_field(array('bulk-posts',false));
;
?>

<?php if ( (denot_boolean(is_singular())))
 {$arc_query = concat2(concat1("SELECT DISTINCT YEAR(post_date) AS yyear, MONTH(post_date) AS mmonth FROM ",$wpdb[0]->posts)," WHERE post_type = 'post' ORDER BY post_date DESC");
$arc_result = $wpdb[0]->get_results($arc_query);
$month_count = attAspis(count($arc_result[0]));
if ( ($month_count[0] && (!(((1) == $month_count[0]) && ((0) == $arc_result[0][(0)][0]->mmonth[0])))))
 {$m = ((isset($_GET[0][('m')]) && Aspis_isset( $_GET [0][('m')]))) ? int_cast($_GET[0]['m']) : array(0,false);
;
?>
<select name='m'>
<option<?php selected($m,array(0,false));
;
?> value='0'><?php _e(array('Show all dates',false));
;
?></option>
<?php foreach ( $arc_result[0] as $arc_row  )
{if ( ($arc_row[0]->yyear[0] == (0)))
 continue ;
$arc_row[0]->mmonth = zeroise($arc_row[0]->mmonth,array(2,false));
if ( ((deconcat($arc_row[0]->yyear,$arc_row[0]->mmonth)) == $m[0]))
 $default = array(' selected="selected"',false);
else 
{$default = array('',false);
}echo AspisCheckPrint(concat2(concat(concat2(concat1("<option",$default)," value='"),esc_attr(concat($arc_row[0]->yyear,$arc_row[0]->mmonth))),"'>"));
echo AspisCheckPrint(concat($wp_locale[0]->get_month($arc_row[0]->mmonth),concat1(" ",$arc_row[0]->yyear)));
echo AspisCheckPrint(array("</option>\n",false));
};
?>
</select>
<?php };
?>

<?php $dropdown_options = array(array(deregisterTaint(array('show_option_all',false)) => addTaint(__(array('View all categories',false))),'hide_empty' => array(0,false,false),'hierarchical' => array(1,false,false),'show_count' => array(0,false,false),'orderby' => array('name',false,false),deregisterTaint(array('selected',false)) => addTaint($cat)),false);
wp_dropdown_categories($dropdown_options);
do_action(array('restrict_manage_posts',false));
;
?>
<input type="submit" id="post-query-submit" value="<?php esc_attr_e(array('Filter',false));
;
?>" class="button-secondary" />
<?php }if ( ($is_trash[0] && deAspis(current_user_can(array('edit_others_posts',false)))))
 {;
?>
<input type="submit" name="delete_all" id="delete_all" value="<?php esc_attr_e(array('Empty Trash',false));
;
?>" class="button-secondary apply" />
<?php };
?>
</div>

<?php if ( $page_links[0])
 {;
?>
<div class="tablenav-pages"><?php $page_links_text = Aspis_sprintf(concat2(concat1('<span class="displaying-num">',__(array('Displaying %s&#8211;%s of %s',false))),'</span>%s'),number_format_i18n(array(((deAspis($_GET[0]['paged']) - (1)) * $wp_query[0]->query_vars[0][('posts_per_page')][0]) + (1),false)),number_format_i18n(attAspisRC(min(deAspisRC(array(deAspis($_GET[0]['paged']) * $wp_query[0]->query_vars[0][('posts_per_page')][0],false)),deAspisRC($wp_query[0]->found_posts)))),number_format_i18n($wp_query[0]->found_posts),$page_links);
echo AspisCheckPrint($page_links_text);
;
?></div>
<?php };
?>

<div class="view-switch">
	<a href="<?php echo AspisCheckPrint(esc_url(add_query_arg(array('mode',false),array('list',false),$_SERVER[0]['REQUEST_URI'])));
?>"><img <?php if ( (('list') == $mode[0]))
 echo AspisCheckPrint(array('class="current"',false));
;
?> id="view-switch-list" src="../wp-includes/images/blank.gif" width="20" height="20" title="<?php _e(array('List View',false));
?>" alt="<?php _e(array('List View',false));
?>" /></a>
	<a href="<?php echo AspisCheckPrint(esc_url(add_query_arg(array('mode',false),array('excerpt',false),$_SERVER[0]['REQUEST_URI'])));
?>"><img <?php if ( (('excerpt') == $mode[0]))
 echo AspisCheckPrint(array('class="current"',false));
;
?> id="view-switch-excerpt" src="../wp-includes/images/blank.gif" width="20" height="20" title="<?php _e(array('Excerpt View',false));
?>" alt="<?php _e(array('Excerpt View',false));
?>" /></a>
</div>

<div class="clear"></div>
</div>

<div class="clear"></div>

<?php include ('edit-post-rows.php');
;
?>

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
<?php if ( ($is_trash[0] && deAspis(current_user_can(array('edit_others_posts',false)))))
 {;
?>
<input type="submit" name="delete_all2" id="delete_all2" value="<?php esc_attr_e(array('Empty Trash',false));
;
?>" class="button-secondary apply" />
<?php };
?>
<br class="clear" />
</div>
<br class="clear" />
</div>

<?php }else 
{{;
?>
<div class="clear"></div>
<p><?php if ( (((isset($_GET[0][('post_status')]) && Aspis_isset( $_GET [0][('post_status')]))) && (('trash') == deAspis($_GET[0]['post_status']))))
 _e(array('No posts found in the trash',false));
else 
{_e(array('No posts found',false));
};
?></p>
<?php }};
?>

</form>

<?php inline_edit_row(array('post',false));
;
?>

<div id="ajax-response"></div>
<br class="clear" />
</div>

<?php include ('admin-footer.php');
