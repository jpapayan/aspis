<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
wp_reset_vars(array('action','cat_id','linkurl','name','image','description','visible','target','category','link_id','submit','order_by','links_show_cat_id','rating','rel','notes','linkcheck[]'));
if ( !current_user_can('manage_links'))
 wp_die(__('You do not have sufficient permissions to edit the links for this blog.'));
if ( !(empty($_POST[0]['deletebookmarks']) || Aspis_empty($_POST[0]['deletebookmarks'])))
 $action = 'deletebookmarks';
if ( !(empty($_POST[0]['move']) || Aspis_empty($_POST[0]['move'])))
 $action = 'move';
if ( !(empty($_POST[0]['linkcheck']) || Aspis_empty($_POST[0]['linkcheck'])))
 $linkcheck = deAspisWarningRC($_POST[0]['linkcheck']);
$this_file = 'link-manager.php';
switch ( $action ) {
case 'deletebookmarks':check_admin_referer('bulk-bookmarks');
if ( count($linkcheck) == 0)
 {wp_redirect($this_file);
exit();
}$deleted = 0;
foreach ( $linkcheck as $link_id  )
{$link_id = (int)$link_id;
if ( wp_delete_link($link_id))
 $deleted++;
}wp_redirect("$this_file?deleted=$deleted");
exit();
break ;
case 'move':check_admin_referer('bulk-bookmarks');
if ( count($linkcheck) == 0)
 {wp_redirect($this_file);
exit();
}$all_links = join(',',$linkcheck);
wp_redirect($this_file);
exit();
break ;
case 'add':check_admin_referer('add-bookmark');
add_link();
wp_redirect(wp_get_referer() . '?added=true');
exit();
break ;
case 'save':$link_id = (int)deAspisWarningRC($_POST[0]['link_id']);
check_admin_referer('update-bookmark_' . $link_id);
edit_link($link_id);
wp_redirect($this_file);
exit();
break ;
case 'delete':$link_id = (int)deAspisWarningRC($_GET[0]['link_id']);
check_admin_referer('delete-bookmark_' . $link_id);
wp_delete_link($link_id);
wp_redirect($this_file);
exit();
break ;
case 'edit':wp_enqueue_script('link');
wp_enqueue_script('xfn');
$parent_file = 'link-manager.php';
$submenu_file = 'link-manager.php';
$title = __('Edit Link');
$link_id = (int)deAspisWarningRC($_GET[0]['link_id']);
if ( !$link = get_link_to_edit($link_id))
 wp_die(__('Link not found.'));
include ('edit-link-form.php');
include ('admin-footer.php');
break ;
default :break ;
 }
;
?>
<?php 