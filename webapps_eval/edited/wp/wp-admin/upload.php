<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
wp_enqueue_script(array('wp-ajax-response',false));
wp_enqueue_script(array('jquery-ui-draggable',false));
if ( (denot_boolean(current_user_can(array('upload_files',false)))))
 wp_die(__(array('You do not have permission to upload files.',false)));
if ( ((isset($_GET[0][('find_detached')]) && Aspis_isset( $_GET [0][('find_detached')]))))
 {check_admin_referer(array('bulk-media',false));
if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 wp_die(__(array('You are not allowed to scan for lost attachments.',false)));
$all_posts = $wpdb[0]->get_col(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_type = 'post' OR post_type = 'page'"));
$all_att = $wpdb[0]->get_results(concat2(concat1("SELECT ID, post_parent FROM ",$wpdb[0]->posts)," WHERE post_type = 'attachment'"));
$lost = array(array(),false);
foreach ( deAspis(array_cast($all_att)) as $att  )
{if ( (($att[0]->post_parent[0] > (0)) && (denot_boolean(Aspis_in_array($att[0]->post_parent,$all_posts)))))
 arrayAssignAdd($lost[0][],addTaint($att[0]->ID));
}arrayAssign($_GET[0],deAspis(registerTaint(array('detached',false))),addTaint(array(1,false)));
}elseif ( (((isset($_GET[0][('found_post_id')]) && Aspis_isset( $_GET [0][('found_post_id')]))) && ((isset($_GET[0][('media')]) && Aspis_isset( $_GET [0][('media')])))))
 {check_admin_referer(array('bulk-media',false));
if ( (denot_boolean(($parent_id = int_cast($_GET[0]['found_post_id'])))))
 return ;
$parent = &get_post($parent_id);
if ( (denot_boolean(current_user_can(array('edit_post',false),$parent_id))))
 wp_die(__(array('You are not allowed to edit this post.',false)));
$attach = array(array(),false);
foreach ( deAspis(array_cast($_GET[0]['media'])) as $att_id  )
{$att_id = int_cast($att_id);
if ( (denot_boolean(current_user_can(array('edit_post',false),$att_id))))
 continue ;
arrayAssignAdd($attach[0][],addTaint($att_id));
}if ( (!((empty($attach) || Aspis_empty( $attach)))))
 {$attach = Aspis_implode(array(',',false),$attach);
$attached = $wpdb[0]->query($wpdb[0]->prepare(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_parent = %d WHERE post_type = 'attachment' AND ID IN ("),$attach),")"),$parent_id));
}if ( ((isset($attached) && Aspis_isset( $attached))))
 {$location = array('upload.php',false);
if ( deAspis($referer = wp_get_referer()))
 {if ( (false !== strpos($referer[0],'upload.php')))
 $location = $referer;
}$location = add_query_arg(array(array(deregisterTaint(array('attached',false)) => addTaint($attached)),false),$location);
wp_redirect($location);
Aspis_exit();
}}elseif ( (((((isset($_GET[0][('doaction')]) && Aspis_isset( $_GET [0][('doaction')]))) || ((isset($_GET[0][('doaction2')]) && Aspis_isset( $_GET [0][('doaction2')])))) || ((isset($_GET[0][('delete_all')]) && Aspis_isset( $_GET [0][('delete_all')])))) || ((isset($_GET[0][('delete_all2')]) && Aspis_isset( $_GET [0][('delete_all2')])))))
 {check_admin_referer(array('bulk-media',false));
if ( (((isset($_GET[0][('delete_all')]) && Aspis_isset( $_GET [0][('delete_all')]))) || ((isset($_GET[0][('delete_all2')]) && Aspis_isset( $_GET [0][('delete_all2')])))))
 {$post_ids = $wpdb[0]->get_col(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_type='attachment' AND post_status = 'trash'"));
$doaction = array('delete',false);
}elseif ( (((deAspis($_GET[0]['action']) != deAspis(negate(array(1,false)))) || (deAspis($_GET[0]['action2']) != deAspis(negate(array(1,false))))) && (((isset($_GET[0][('media')]) && Aspis_isset( $_GET [0][('media')]))) || ((isset($_GET[0][('ids')]) && Aspis_isset( $_GET [0][('ids')]))))))
 {$post_ids = ((isset($_GET[0][('media')]) && Aspis_isset( $_GET [0][('media')]))) ? $_GET[0]['media'] : Aspis_explode(array(',',false),$_GET[0]['ids']);
$doaction = (deAspis($_GET[0]['action']) != deAspis(negate(array(1,false)))) ? $_GET[0]['action'] : $_GET[0]['action2'];
}else 
{{wp_redirect($_SERVER[0]['HTTP_REFERER']);
}}$location = array('upload.php',false);
if ( deAspis($referer = wp_get_referer()))
 {if ( (false !== strpos($referer[0],'upload.php')))
 $location = remove_query_arg(array(array(array('trashed',false),array('untrashed',false),array('deleted',false),array('message',false),array('ids',false),array('posted',false)),false),$referer);
}switch ( $doaction[0] ) {
case ('trash'):foreach ( deAspis(array_cast($post_ids)) as $post_id  )
{if ( (denot_boolean(current_user_can(array('delete_post',false),$post_id))))
 wp_die(__(array('You are not allowed to move this post to the trash.',false)));
if ( (denot_boolean(wp_trash_post($post_id))))
 wp_die(__(array('Error in moving to trash...',false)));
}$location = add_query_arg(array(array('message' => array(4,false,false),deregisterTaint(array('ids',false)) => addTaint(Aspis_join(array(',',false),$post_ids))),false),$location);
break ;
case ('untrash'):foreach ( deAspis(array_cast($post_ids)) as $post_id  )
{if ( (denot_boolean(current_user_can(array('delete_post',false),$post_id))))
 wp_die(__(array('You are not allowed to move this post out of the trash.',false)));
if ( (denot_boolean(wp_untrash_post($post_id))))
 wp_die(__(array('Error in restoring from trash...',false)));
}$location = add_query_arg(array('message',false),array(5,false),$location);
break ;
case ('delete'):foreach ( deAspis(array_cast($post_ids)) as $post_id_del  )
{if ( (denot_boolean(current_user_can(array('delete_post',false),$post_id_del))))
 wp_die(__(array('You are not allowed to delete this post.',false)));
if ( (denot_boolean(wp_delete_attachment($post_id_del))))
 wp_die(__(array('Error in deleting...',false)));
}$location = add_query_arg(array('message',false),array(2,false),$location);
break ;
 }
wp_redirect($location);
Aspis_exit();
}elseif ( (((isset($_GET[0][('_wp_http_referer')]) && Aspis_isset( $_GET [0][('_wp_http_referer')]))) && (!((empty($_GET[0][('_wp_http_referer')]) || Aspis_empty( $_GET [0][('_wp_http_referer')]))))))
 {wp_redirect(remove_query_arg(array(array(array('_wp_http_referer',false),array('_wpnonce',false)),false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
Aspis_exit();
}$title = __(array('Media Library',false));
$parent_file = array('upload.php',false);
if ( ((!((isset($_GET[0][('paged')]) && Aspis_isset( $_GET [0][('paged')])))) || (deAspis($_GET[0]['paged']) < (1))))
 arrayAssign($_GET[0],deAspis(registerTaint(array('paged',false))),addTaint(array(1,false)));
if ( ((isset($_GET[0][('detached')]) && Aspis_isset( $_GET [0][('detached')]))))
 {$media_per_page = int_cast(get_user_option(array('upload_per_page',false),array(0,false),array(false,false)));
if ( (((empty($media_per_page) || Aspis_empty( $media_per_page))) || ($media_per_page[0] < (1))))
 $media_per_page = array(20,false);
$media_per_page = apply_filters(array('upload_per_page',false),$media_per_page);
if ( (!((empty($lost) || Aspis_empty( $lost)))))
 {$start = array((deAspis(int_cast($_GET[0]['paged'])) - (1)) * $media_per_page[0],false);
$page_links_total = attAspis(ceil((count($lost[0]) / $media_per_page[0])));
$lost = Aspis_implode(array(',',false),$lost);
$orphans = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," WHERE post_type = 'attachment' AND ID IN (%s) LIMIT %d, %d"),$lost,$start,$media_per_page));
}else 
{{$start = array((deAspis(int_cast($_GET[0]['paged'])) - (1)) * $media_per_page[0],false);
$orphans = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT SQL_CALC_FOUND_ROWS * FROM ",$wpdb[0]->posts)," WHERE post_type = 'attachment' AND post_status != 'trash' AND post_parent < 1 LIMIT %d, %d"),$start,$media_per_page));
$page_links_total = attAspis(ceil((deAspis($wpdb[0]->get_var(array("SELECT FOUND_ROWS()",false))) / $media_per_page[0])));
}}$post_mime_types = get_post_mime_types();
$avail_post_mime_types = get_available_post_mime_types(array('attachment',false));
if ( (((isset($_GET[0][('post_mime_type')]) && Aspis_isset( $_GET [0][('post_mime_type')]))) && (denot_boolean(Aspis_array_intersect(array_cast($_GET[0]['post_mime_type']),attAspisRC(array_keys(deAspisRC($post_mime_types))))))))
 unset($_GET[0][('post_mime_type')]);
}else 
{{list($post_mime_types,$avail_post_mime_types) = deAspisList(wp_edit_attachments_query(),array());
}}$is_trash = (array(((isset($_GET[0][('status')]) && Aspis_isset( $_GET [0][('status')]))) && (deAspis($_GET[0]['status']) == ('trash')),false));
wp_enqueue_script(array('media',false));
require_once ('admin-header.php');
do_action(array('restrict_manage_posts',false));
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?> <a href="media-new.php" class="button add-new-h2"><?php echo AspisCheckPrint(esc_html_x(array('Add New',false),array('file',false)));
;
?></a> <?php if ( (((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))) && deAspis($_GET[0]['s'])))
 printf((deconcat2(concat1('<span class="subtitle">',__(array('Search results for &#8220;%s&#8221;',false))),'</span>')),deAspisRC(esc_html(get_search_query())));
;
?>
</h2>

<?php $message = array('',false);
if ( (((isset($_GET[0][('posted')]) && Aspis_isset( $_GET [0][('posted')]))) && deAspis(int_cast($_GET[0]['posted']))))
 {arrayAssign($_GET[0],deAspis(registerTaint(array('message',false))),addTaint(array('1',false)));
arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('posted',false)),false),$_SERVER[0]['REQUEST_URI'])));
}if ( (((isset($_GET[0][('attached')]) && Aspis_isset( $_GET [0][('attached')]))) && deAspis(int_cast($_GET[0]['attached']))))
 {$attached = int_cast($_GET[0]['attached']);
$message = Aspis_sprintf(_n(array('Reattached %d attachment',false),array('Reattached %d attachments',false),$attached),$attached);
arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('attached',false)),false),$_SERVER[0]['REQUEST_URI'])));
}if ( (((isset($_GET[0][('deleted')]) && Aspis_isset( $_GET [0][('deleted')]))) && deAspis(int_cast($_GET[0]['deleted']))))
 {arrayAssign($_GET[0],deAspis(registerTaint(array('message',false))),addTaint(array('2',false)));
arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('deleted',false)),false),$_SERVER[0]['REQUEST_URI'])));
}if ( (((isset($_GET[0][('trashed')]) && Aspis_isset( $_GET [0][('trashed')]))) && deAspis(int_cast($_GET[0]['trashed']))))
 {arrayAssign($_GET[0],deAspis(registerTaint(array('message',false))),addTaint(array('4',false)));
arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('trashed',false)),false),$_SERVER[0]['REQUEST_URI'])));
}if ( (((isset($_GET[0][('untrashed')]) && Aspis_isset( $_GET [0][('untrashed')]))) && deAspis(int_cast($_GET[0]['untrashed']))))
 {arrayAssign($_GET[0],deAspis(registerTaint(array('message',false))),addTaint(array('5',false)));
arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('untrashed',false)),false),$_SERVER[0]['REQUEST_URI'])));
}arrayAssign($messages[0],deAspis(registerTaint(array(1,false))),addTaint(__(array('Media attachment updated.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(2,false))),addTaint(__(array('Media permanently deleted.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(3,false))),addTaint(__(array('Error saving media attachment.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(4,false))),addTaint(concat2(concat(concat2(concat(concat2(__(array('Media moved to the trash.',false)),' <a href="'),esc_url(wp_nonce_url(concat1('upload.php?doaction=undo&action=untrash&ids=',(((isset($_GET[0][('ids')]) && Aspis_isset( $_GET [0][('ids')]))) ? $_GET[0]['ids'] : array('',false))),array("bulk-media",false)))),'">'),__(array('Undo',false))),'</a>')));
arrayAssign($messages[0],deAspis(registerTaint(array(5,false))),addTaint(__(array('Media restored from the trash.',false))));
if ( (((isset($_GET[0][('message')]) && Aspis_isset( $_GET [0][('message')]))) && deAspis(int_cast($_GET[0]['message']))))
 {$message = attachAspis($messages,deAspis($_GET[0]['message']));
arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('message',false)),false),$_SERVER[0]['REQUEST_URI'])));
}if ( (!((empty($message) || Aspis_empty( $message)))))
 {;
?>
<div id="message" class="updated fade"><p><?php echo AspisCheckPrint($message);
;
?></p></div>
<?php };
?>

<ul class="subsubsub">
<?php $type_links = array(array(),false);
$_num_posts = array_cast(wp_count_attachments());
$_total_posts = array(deAspis(attAspisRC(array_sum(deAspisRC($_num_posts)))) - deAspis($_num_posts[0]['trash']),false);
$matches = wp_match_mime_types(attAspisRC(array_keys(deAspisRC($post_mime_types))),attAspisRC(array_keys(deAspisRC($_num_posts))));
foreach ( $matches[0] as $type =>$reals )
{restoreTaint($type,$reals);
foreach ( $reals[0] as $real  )
arrayAssign($num_posts[0],deAspis(registerTaint($type)),addTaint(((isset($num_posts[0][$type[0]]) && Aspis_isset( $num_posts [0][$type[0]]))) ? array(deAspis(attachAspis($num_posts,$type[0])) + deAspis(attachAspis($_num_posts,$real[0])),false) : attachAspis($_num_posts,$real[0])));
}$class = ((((empty($_GET[0][('post_mime_type')]) || Aspis_empty( $_GET [0][('post_mime_type')]))) && (!((isset($_GET[0][('detached')]) && Aspis_isset( $_GET [0][('detached')]))))) && (!((isset($_GET[0][('status')]) && Aspis_isset( $_GET [0][('status')]))))) ? array(' class="current"',false) : array('',false);
arrayAssignAdd($type_links[0][],addTaint(concat2(concat(concat2(concat1("<li><a href='upload.php'",$class),">"),Aspis_sprintf(_nx(array('All <span class="count">(%s)</span>',false),array('All <span class="count">(%s)</span>',false),$_total_posts,array('uploaded files',false)),number_format_i18n($_total_posts))),'</a>')));
foreach ( $post_mime_types[0] as $mime_type =>$label )
{restoreTaint($mime_type,$label);
{$class = array('',false);
if ( (denot_boolean(wp_match_mime_types($mime_type,$avail_post_mime_types))))
 continue ;
if ( ((!((empty($_GET[0][('post_mime_type')]) || Aspis_empty( $_GET [0][('post_mime_type')])))) && deAspis(wp_match_mime_types($mime_type,$_GET[0]['post_mime_type']))))
 $class = array(' class="current"',false);
arrayAssignAdd($type_links[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1("<li><a href='upload.php?post_mime_type=",$mime_type),"'"),$class),">"),Aspis_sprintf(_n(attachAspis($label[0][(2)],(0)),attachAspis($label[0][(2)],(1)),attachAspis($num_posts,$mime_type[0])),number_format_i18n(attachAspis($num_posts,$mime_type[0])))),'</a>')));
}}arrayAssignAdd($type_links[0][],addTaint(concat2(concat(concat2(concat1('<li><a href="upload.php?detached=1"',(((isset($_GET[0][('detached')]) && Aspis_isset( $_GET [0][('detached')]))) ? array(' class="current"',false) : array('',false))),'>'),__(array('Unattached',false))),'</a>')));
if ( (EMPTY_TRASH_DAYS && (MEDIA_TRASH || (!((empty($_num_posts[0][('trash')]) || Aspis_empty( $_num_posts [0][('trash')])))))))
 arrayAssignAdd($type_links[0][],addTaint(concat2(concat(concat2(concat1('<li><a href="upload.php?status=trash"',((((isset($_GET[0][('status')]) && Aspis_isset( $_GET [0][('status')]))) && (deAspis($_GET[0]['status']) == ('trash'))) ? array(' class="current"',false) : array('',false))),'>'),Aspis_sprintf(_nx(array('Trash <span class="count">(%s)</span>',false),array('Trash <span class="count">(%s)</span>',false),$_num_posts[0]['trash'],array('uploaded files',false)),number_format_i18n($_num_posts[0]['trash']))),'</a>')));
echo AspisCheckPrint(concat2(Aspis_implode(array(" |</li>\n",false),$type_links),'</li>'));
unset($type_links);
;
?>
</ul>

<form class="search-form" action="" method="get">
<p class="search-box">
	<label class="screen-reader-text" for="media-search-input"><?php _e(array('Search Media',false));
;
?>:</label>
	<input type="text" id="media-search-input" name="s" value="<?php the_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e(array('Search Media',false));
;
?>" class="button" />
</p>
</form>

<form id="posts-filter" action="" method="get">
<div class="tablenav">
<?php if ( (!((isset($page_links_total) && Aspis_isset( $page_links_total)))))
 $page_links_total = $wp_query[0]->max_num_pages;
$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('paged',false),array('%#%',false))),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint($page_links_total),deregisterTaint(array('current',false)) => addTaint($_GET[0]['paged'])),false));
if ( $page_links[0])
 {;
?>
<div class="tablenav-pages"><?php $page_links_text = Aspis_sprintf(concat2(concat1('<span class="displaying-num">',__(array('Displaying %s&#8211;%s of %s',false))),'</span>%s'),number_format_i18n(array(((deAspis($_GET[0]['paged']) - (1)) * $wp_query[0]->query_vars[0][('posts_per_page')][0]) + (1),false)),number_format_i18n(attAspisRC(min(deAspisRC(array(deAspis($_GET[0]['paged']) * $wp_query[0]->query_vars[0][('posts_per_page')][0],false)),deAspisRC($wp_query[0]->found_posts)))),number_format_i18n($wp_query[0]->found_posts),$page_links);
echo AspisCheckPrint($page_links_text);
;
?></div>
<?php };
?>

<div class="alignleft actions">
<select name="action" class="select-action">
<option value="-1" selected="selected"><?php _e(array('Bulk Actions',false));
;
?></option>
<?php if ( $is_trash[0])
 {;
?>
<option value="untrash"><?php _e(array('Restore',false));
;
?></option>
<?php }if ( (($is_trash[0] || (!(EMPTY_TRASH_DAYS))) || (!(MEDIA_TRASH))))
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
<?php }}if ( ((isset($orphans) && Aspis_isset( $orphans))))
 {;
?>
<option value="attach"><?php _e(array('Attach to a post',false));
;
?></option>
<?php };
?>
</select>
<input type="submit" value="<?php esc_attr_e(array('Apply',false));
;
?>" name="doaction" id="doaction" class="button-secondary action" />
<?php wp_nonce_field(array('bulk-media',false));
;
?>

<?php if ( (((denot_boolean(is_singular())) && (!((isset($_GET[0][('detached')]) && Aspis_isset( $_GET [0][('detached')]))))) && (denot_boolean($is_trash))))
 {$arc_query = concat2(concat1("SELECT DISTINCT YEAR(post_date) AS yyear, MONTH(post_date) AS mmonth FROM ",$wpdb[0]->posts)," WHERE post_type = 'attachment' ORDER BY post_date DESC");
$arc_result = $wpdb[0]->get_results($arc_query);
$month_count = attAspis(count($arc_result[0]));
if ( ($month_count[0] && (!(((1) == $month_count[0]) && ((0) == $arc_result[0][(0)][0]->mmonth[0])))))
 {;
?>
<select name='m'>
<option value='0'><?php _e(array('Show all dates',false));
;
?></option>
<?php foreach ( $arc_result[0] as $arc_row  )
{if ( ($arc_row[0]->yyear[0] == (0)))
 continue ;
$arc_row[0]->mmonth = zeroise($arc_row[0]->mmonth,array(2,false));
if ( (((isset($_GET[0][('m')]) && Aspis_isset( $_GET [0][('m')]))) && ((deconcat($arc_row[0]->yyear,$arc_row[0]->mmonth)) == deAspis($_GET[0]['m']))))
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

<input type="submit" id="post-query-submit" value="<?php esc_attr_e(array('Filter',false));
;
?>" class="button-secondary" />

<?php };
?>

<?php if ( ((isset($_GET[0][('detached')]) && Aspis_isset( $_GET [0][('detached')]))))
 {;
?>
	<input type="submit" id="find_detached" name="find_detached" value="<?php esc_attr_e(array('Scan for lost attachments',false));
;
?>" class="button-secondary" />
<?php }elseif ( ((((isset($_GET[0][('status')]) && Aspis_isset( $_GET [0][('status')]))) && (deAspis($_GET[0]['status']) == ('trash'))) && deAspis(current_user_can(array('edit_others_posts',false)))))
 {;
?>
	<input type="submit" id="delete_all" name="delete_all" value="<?php esc_attr_e(array('Empty Trash',false));
;
?>" class="button-secondary apply" />
<?php };
?>

</div>

<br class="clear" />
</div>

<div class="clear"></div>

<?php if ( ((isset($orphans) && Aspis_isset( $orphans))))
 {;
?>
<table class="widefat" cellspacing="0">
<thead>
<tr>
	<th scope="col" class="check-column"><input type="checkbox" /></th>
	<th scope="col"></th>
	<th scope="col"><?php echo AspisCheckPrint(_x(array('Media',false),array('media column name',false)));
;
?></th>
	<th scope="col"><?php echo AspisCheckPrint(_x(array('Author',false),array('media column name',false)));
;
?></th>
	<th scope="col"><?php echo AspisCheckPrint(_x(array('Date Added',false),array('media column name',false)));
;
?></th>
</tr>
</thead>

<tfoot>
<tr>
	<th scope="col" class="check-column"><input type="checkbox" /></th>
	<th scope="col"></th>
	<th scope="col"><?php echo AspisCheckPrint(_x(array('Media',false),array('media column name',false)));
;
?></th>
	<th scope="col"><?php echo AspisCheckPrint(_x(array('Author',false),array('media column name',false)));
;
?></th>
	<th scope="col"><?php echo AspisCheckPrint(_x(array('Date Added',false),array('media column name',false)));
;
?></th>
</tr>
</tfoot>

<tbody id="the-list" class="list:post">
<?php if ( $orphans[0])
 {foreach ( $orphans[0] as $post  )
{$class = (('alternate') == $class[0]) ? array('',false) : array('alternate',false);
$att_title = esc_html(_draft_or_post_title($post[0]->ID));
;
?>
	<tr id='post-<?php echo AspisCheckPrint($post[0]->ID);
;
?>' class='<?php echo AspisCheckPrint($class);
;
?>' valign="top">
		<th scope="row" class="check-column"><?php if ( deAspis(current_user_can(array('edit_post',false),$post[0]->ID)))
 {;
?><input type="checkbox" name="media[]" value="<?php echo AspisCheckPrint(esc_attr($post[0]->ID));
;
?>" /><?php };
?></th>

		<td class="media-icon"><?php if ( deAspis($thumb = wp_get_attachment_image($post[0]->ID,array(array(array(80,false),array(60,false)),false),array(true,false))))
 {;
?>
			<a href="media.php?action=edit&amp;attachment_id=<?php echo AspisCheckPrint($post[0]->ID);
;
?>" title="<?php echo AspisCheckPrint(esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$att_title)));
;
?>"><?php echo AspisCheckPrint($thumb);
;
?></a>
<?php };
?></td>

		<td class="media column-media"><strong><a href="<?php echo AspisCheckPrint(get_edit_post_link($post[0]->ID));
;
?>" title="<?php echo AspisCheckPrint(esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$att_title)));
;
?>"><?php echo AspisCheckPrint($att_title);
;
?></a></strong><br />
		<?php echo AspisCheckPrint(Aspis_strtoupper(Aspis_preg_replace(array('/^.*?\.(\w+)$/',false),array('$1',false),get_attached_file($post[0]->ID))));
;
?>

		<div class="row-actions">
		<?php $actions = array(array(),false);
if ( deAspis(current_user_can(array('edit_post',false),$post[0]->ID)))
 arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat1('<a href="',get_edit_post_link($post[0]->ID,array(true,false))),'">'),__(array('Edit',false))),'</a>')));
if ( deAspis(current_user_can(array('delete_post',false),$post[0]->ID)))
 if ( (EMPTY_TRASH_DAYS && MEDIA_TRASH))
 {arrayAssign($actions[0],deAspis(registerTaint(array('trash',false))),addTaint(concat2(concat(concat2(concat1("<a class='submitdelete' href='",wp_nonce_url(concat1("post.php?action=trash&amp;post=",$post[0]->ID),concat1('trash-post_',$post[0]->ID))),"'>"),__(array('Trash',false))),"</a>")));
}else 
{{$delete_ays = (!(MEDIA_TRASH)) ? array(" onclick='return showNotice.warn();'",false) : array('',false);
arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a class='submitdelete'",$delete_ays)," href='"),wp_nonce_url(concat1("post.php?action=delete&amp;post=",$post[0]->ID),concat1('delete-post_',$post[0]->ID))),"'>"),__(array('Delete Permanently',false))),"</a>")));
}}arrayAssign($actions[0],deAspis(registerTaint(array('view',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_permalink($post[0]->ID)),'" title="'),esc_attr(Aspis_sprintf(__(array('View &#8220;%s&#8221;',false)),$title))),'" rel="permalink">'),__(array('View',false))),'</a>')));
if ( deAspis(current_user_can(array('edit_post',false),$post[0]->ID)))
 arrayAssign($actions[0],deAspis(registerTaint(array('attach',false))),addTaint(concat2(concat(concat2(concat1('<a href="#the-list" onclick="findPosts.open(\'media[]\',\'',$post[0]->ID),'\');return false;" class="hide-if-no-js">'),__(array('Attach',false))),'</a>')));
$actions = apply_filters(array('media_row_actions',false),$actions,$post);
$action_count = attAspis(count($actions[0]));
$i = array(0,false);
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{preincr($i);
($i[0] == $action_count[0]) ? $sep = array('',false) : $sep = array(' | ',false);
echo AspisCheckPrint(concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$link),$sep),"</span>"));
}};
?>
		</div></td>
		<td class="author column-author"><?php $author = get_userdata($post[0]->post_author);
echo AspisCheckPrint($author[0]->display_name);
;
?></td>
<?php if ( ((('0000-00-00 00:00:00') == $post[0]->post_date[0]) && (('date') == $column_name[0])))
 {$t_time = $h_time = __(array('Unpublished',false));
}else 
{{$t_time = get_the_time(__(array('Y/m/d g:i:s A',false)));
$m_time = $post[0]->post_date;
$time = get_post_time(array('G',false),array(true,false));
if ( (deAspis((Aspis_abs($t_diff = array(time() - $time[0],false)))) < (86400)))
 {if ( ($t_diff[0] < (0)))
 $h_time = Aspis_sprintf(__(array('%s from now',false)),human_time_diff($time));
else 
{$h_time = Aspis_sprintf(__(array('%s ago',false)),human_time_diff($time));
}}else 
{{$h_time = mysql2date(__(array('Y/m/d',false)),$m_time);
}}}};
?>
		<td class="date column-date"><?php echo AspisCheckPrint($h_time);
?></td>
	</tr>
<?php }}else 
{{;
?>
	<tr><td colspan="5"><?php _e(array('No media attachments found.',false));
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

<?php if ( $page_links[0])
 echo AspisCheckPrint(concat2(concat1("<div class='tablenav-pages'>",$page_links_text),"</div>"));
;
?>

<div class="alignleft actions">
<select name="action2" class="select-action">
<option value="-1" selected="selected"><?php _e(array('Bulk Actions',false));
;
?></option>
<?php if ( $is_trash[0])
 {;
?>
<option value="untrash"><?php _e(array('Restore',false));
;
?></option>
<?php }if ( (($is_trash[0] || (!(EMPTY_TRASH_DAYS))) || (!(MEDIA_TRASH))))
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
<?php }}if ( ((isset($orphans) && Aspis_isset( $orphans))))
 {;
?>
<option value="attach"><?php _e(array('Attach to a post',false));
;
?></option>
<?php };
?>
</select>
<input type="submit" value="<?php esc_attr_e(array('Apply',false));
;
?>" name="doaction2" id="doaction2" class="button-secondary action" />

<?php if ( ((((isset($_GET[0][('status')]) && Aspis_isset( $_GET [0][('status')]))) && (deAspis($_GET[0]['status']) == ('trash'))) && deAspis(current_user_can(array('edit_others_posts',false)))))
 {;
?>
	<input type="submit" id="delete_all2" name="delete_all2" value="<?php esc_attr_e(array('Empty Trash',false));
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
