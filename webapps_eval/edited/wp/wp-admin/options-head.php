<?php require_once('AspisMain.php'); ?><?php
wp_reset_vars(array(array(array('action',false),array('standalone',false),array('option_group_id',false)),false));
;
?>

<?php if ( ((isset($_GET[0][('updated')]) && Aspis_isset( $_GET [0][('updated')]))))
 {;
?>
<div id="message" class="updated fade"><p><strong><?php _e(array('Settings saved.',false));
?></strong></p></div>
<?php };
