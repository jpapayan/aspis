<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
wp_reset_vars(array(array(array('action',false),array('cat_id',false),array('linkurl',false),array('name',false),array('image',false),array('description',false),array('visible',false),array('target',false),array('category',false),array('link_id',false),array('submit',false),array('order_by',false),array('links_show_cat_id',false),array('rating',false),array('rel',false),array('notes',false),array('linkcheck[]',false)),false));
if ( (denot_boolean(current_user_can(array('manage_links',false)))))
 wp_die(__(array('You do not have sufficient permissions to edit the links for this blog.',false)));
if ( (!((empty($_POST[0][('deletebookmarks')]) || Aspis_empty( $_POST [0][('deletebookmarks')])))))
 $action = array('deletebookmarks',false);
if ( (!((empty($_POST[0][('move')]) || Aspis_empty( $_POST [0][('move')])))))
 $action = array('move',false);
if ( (!((empty($_POST[0][('linkcheck')]) || Aspis_empty( $_POST [0][('linkcheck')])))))
 $linkcheck = $_POST[0]['linkcheck'];
$this_file = array('link-manager.php',false);
switch ( $action[0] ) {
case ('deletebookmarks'):check_admin_referer(array('bulk-bookmarks',false));
if ( (count($linkcheck[0]) == (0)))
 {wp_redirect($this_file);
Aspis_exit();
}$deleted = array(0,false);
foreach ( $linkcheck[0] as $link_id  )
{$link_id = int_cast($link_id);
if ( deAspis(wp_delete_link($link_id)))
 postincr($deleted);
}wp_redirect(concat(concat2($this_file,"?deleted="),$deleted));
Aspis_exit();
break ;
case ('move'):check_admin_referer(array('bulk-bookmarks',false));
if ( (count($linkcheck[0]) == (0)))
 {wp_redirect($this_file);
Aspis_exit();
}$all_links = Aspis_join(array(',',false),$linkcheck);
wp_redirect($this_file);
Aspis_exit();
break ;
case ('add'):check_admin_referer(array('add-bookmark',false));
add_link();
wp_redirect(concat2(wp_get_referer(),'?added=true'));
Aspis_exit();
break ;
case ('save'):$link_id = int_cast($_POST[0]['link_id']);
check_admin_referer(concat1('update-bookmark_',$link_id));
edit_link($link_id);
wp_redirect($this_file);
Aspis_exit();
break ;
case ('delete'):$link_id = int_cast($_GET[0]['link_id']);
check_admin_referer(concat1('delete-bookmark_',$link_id));
wp_delete_link($link_id);
wp_redirect($this_file);
Aspis_exit();
break ;
case ('edit'):wp_enqueue_script(array('link',false));
wp_enqueue_script(array('xfn',false));
$parent_file = array('link-manager.php',false);
$submenu_file = array('link-manager.php',false);
$title = __(array('Edit Link',false));
$link_id = int_cast($_GET[0]['link_id']);
if ( (denot_boolean($link = get_link_to_edit($link_id))))
 wp_die(__(array('Link not found.',false)));
include ('edit-link-form.php');
include ('admin-footer.php');
break ;
default :break ;
 }
;
?>
<?php 