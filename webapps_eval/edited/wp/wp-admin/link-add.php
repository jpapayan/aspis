<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('manage_links',false)))))
 wp_die(__(array('You do not have sufficient permissions to add links to this blog.',false)));
$title = __(array('Add New Link',false));
$parent_file = array('link-manager.php',false);
wp_reset_vars(array(array(array('action',false),array('cat_id',false),array('linkurl',false),array('name',false),array('image',false),array('description',false),array('visible',false),array('target',false),array('category',false),array('link_id',false),array('submit',false),array('order_by',false),array('links_show_cat_id',false),array('rating',false),array('rel',false),array('notes',false),array('linkcheck[]',false)),false));
wp_enqueue_script(array('link',false));
wp_enqueue_script(array('xfn',false));
$link = get_default_link_to_edit();
include ('edit-link-form.php');
require ('admin-footer.php');
;
