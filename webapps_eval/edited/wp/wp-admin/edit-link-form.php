<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit(array('-1',false));
if ( (!((empty($link_id) || Aspis_empty( $link_id)))))
 {$heading = Aspis_sprintf(__(array('<a href="%s">Links</a> / Edit Link',false)),array('link-manager.php',false));
$submit_text = __(array('Update Link',false));
$form = array('<form name="editlink" id="editlink" method="post" action="link.php">',false);
$nonce_action = concat1('update-bookmark_',$link_id);
}else 
{{$heading = Aspis_sprintf(__(array('<a href="%s">Links</a> / Add New Link',false)),array('link-manager.php',false));
$submit_text = __(array('Add Link',false));
$form = array('<form name="addlink" id="addlink" method="post" action="link.php">',false);
$nonce_action = array('add-bookmark',false);
}}require_once ('includes/meta-boxes.php');
add_meta_box(array('linksubmitdiv',false),__(array('Save',false)),array('link_submit_meta_box',false),array('link',false),array('side',false),array('core',false));
add_meta_box(array('linkcategorydiv',false),__(array('Categories',false)),array('link_categories_meta_box',false),array('link',false),array('normal',false),array('core',false));
add_meta_box(array('linktargetdiv',false),__(array('Target',false)),array('link_target_meta_box',false),array('link',false),array('normal',false),array('core',false));
add_meta_box(array('linkxfndiv',false),__(array('Link Relationship (XFN)',false)),array('link_xfn_meta_box',false),array('link',false),array('normal',false),array('core',false));
add_meta_box(array('linkadvanceddiv',false),__(array('Advanced',false)),array('link_advanced_meta_box',false),array('link',false),array('normal',false),array('core',false));
do_action(array('do_meta_boxes',false),array('link',false),array('normal',false),$link);
do_action(array('do_meta_boxes',false),array('link',false),array('advanced',false),$link);
do_action(array('do_meta_boxes',false),array('link',false),array('side',false),$link);
require_once ('admin-header.php');
;
?>
<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<?php if ( ((isset($_GET[0][('added')]) && Aspis_isset( $_GET [0][('added')]))))
 {;
?>
<div id="message" class="updated fade"><p><?php _e(array('Link added.',false));
;
?></p></div>
<?php };
?>

<?php if ( (!((empty($form) || Aspis_empty( $form)))))
 echo AspisCheckPrint($form);
if ( (!((empty($link_added) || Aspis_empty( $link_added)))))
 echo AspisCheckPrint($link_added);
wp_nonce_field($nonce_action);
wp_nonce_field(array('closedpostboxes',false),array('closedpostboxesnonce',false),array(false,false));
wp_nonce_field(array('meta-box-order',false),array('meta-box-order-nonce',false),array(false,false));
;
?>

<div id="poststuff" class="metabox-holder<?php echo AspisCheckPrint(((2) == $screen_layout_columns[0]) ? array(' has-right-sidebar',false) : array('',false));
;
?>">

<div id="side-info-column" class="inner-sidebar">
<?php do_action(array('submitlink_box',false));
$side_meta_boxes = do_meta_boxes(array('link',false),array('side',false),$link);
;
?>
</div>

<div id="post-body">
<div id="post-body-content">
<div id="namediv" class="stuffbox">
<h3><label for="link_name"><?php _e(array('Name',false));
?></label></h3>
<div class="inside">
	<input type="text" name="link_name" size="30" tabindex="1" value="<?php echo AspisCheckPrint(esc_attr($link[0]->link_name));
;
?>" id="link_name" />
    <p><?php _e(array('Example: Nifty blogging software',false));
;
?></p>
</div>
</div>

<div id="addressdiv" class="stuffbox">
<h3><label for="link_url"><?php _e(array('Web Address',false));
?></label></h3>
<div class="inside">
	<input type="text" name="link_url" size="30" class="code" tabindex="1" value="<?php echo AspisCheckPrint(esc_attr($link[0]->link_url));
;
?>" id="link_url" />
    <p><?php _e(array('Example: <code>http://wordpress.org/</code> &#8212; don&#8217;t forget the <code>http://</code>',false));
;
?></p>
</div>
</div>

<div id="descriptiondiv" class="stuffbox">
<h3><label for="link_description"><?php _e(array('Description',false));
?></label></h3>
<div class="inside">
	<input type="text" name="link_description" size="30" tabindex="1" value="<?php echo AspisCheckPrint(((isset($link[0]->link_description) && Aspis_isset( $link[0] ->link_description ))) ? esc_attr($link[0]->link_description) : array('',false));
;
?>" id="link_description" />
    <p><?php _e(array('This will be shown when someone hovers over the link in the blogroll, or optionally below the link.',false));
;
?></p>
</div>
</div>

<?php do_meta_boxes(array('link',false),array('normal',false),$link);
do_meta_boxes(array('link',false),array('advanced',false),$link);
if ( $link_id[0])
 {;
?>
<input type="hidden" name="action" value="save" />
<input type="hidden" name="link_id" value="<?php echo AspisCheckPrint(int_cast($link_id));
;
?>" />
<input type="hidden" name="order_by" value="<?php echo AspisCheckPrint(esc_attr($order_by));
;
?>" />
<input type="hidden" name="cat_id" value="<?php echo AspisCheckPrint(int_cast($cat_id));
?>" />
<?php }else 
{;
?>
<input type="hidden" name="action" value="add" />
<?php };
?>

</div>
</div>
</div>

</form>
</div>
<?php 