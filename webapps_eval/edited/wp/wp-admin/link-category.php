<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
wp_reset_vars(array(array(array('action',false),array('cat',false)),false));
switch ( $action[0] ) {
case ('addcat'):check_admin_referer(array('add-link-category',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
if ( deAspis(wp_insert_term($_POST[0]['name'],array('link_category',false),$_POST)))
 {wp_redirect(array('edit-link-categories.php?message=1#addcat',false));
}else 
{{wp_redirect(array('edit-link-categories.php?message=4#addcat',false));
}}Aspis_exit();
break ;
case ('delete'):$cat_ID = int_cast($_GET[0]['cat_ID']);
check_admin_referer(concat1('delete-link-category_',$cat_ID));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
$cat_name = get_term_field(array('name',false),$cat_ID,array('link_category',false));
$default_cat_id = get_option(array('default_link_category',false));
if ( ($cat_ID[0] == $default_cat_id[0]))
 wp_die(Aspis_sprintf(__(array("Can&#8217;t delete the <strong>%s</strong> category: this is the default one",false)),$cat_name));
wp_delete_term($cat_ID,array('link_category',false),array(array(deregisterTaint(array('default',false)) => addTaint($default_cat_id)),false));
$location = array('edit-link-categories.php',false);
if ( deAspis($referer = wp_get_original_referer()))
 {if ( (false !== strpos($referer[0],'edit-link-categories.php')))
 $location = $referer;
}$location = add_query_arg(array('message',false),array(2,false),$location);
wp_redirect($location);
Aspis_exit();
break ;
case ('edit'):$title = __(array('Edit Category',false));
$parent_file = array('link-manager.php',false);
$submenu_file = array('edit-link-categories.php',false);
require_once ('admin-header.php');
$cat_ID = int_cast($_GET[0]['cat_ID']);
$category = get_term_to_edit($cat_ID,array('link_category',false));
include ('edit-link-category-form.php');
include ('admin-footer.php');
Aspis_exit();
break ;
case ('editedcat'):$cat_ID = int_cast($_POST[0]['cat_ID']);
check_admin_referer(concat1('update-link-category_',$cat_ID));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
$location = array('edit-link-categories.php',false);
if ( deAspis($referer = wp_get_original_referer()))
 {if ( (false !== strpos($referer[0],'edit-link-categories.php')))
 $location = $referer;
}$update = wp_update_term($cat_ID,array('link_category',false),$_POST);
if ( ($update[0] && (denot_boolean(is_wp_error($update)))))
 $location = add_query_arg(array('message',false),array(3,false),$location);
else 
{$location = add_query_arg(array('message',false),array(5,false),$location);
}wp_redirect($location);
Aspis_exit();
break ;
 }
;
?>
<?php 