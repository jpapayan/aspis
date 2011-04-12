<?php require_once('AspisMain.php'); ?><?php
wp_reset_vars(array('action','standalone','option_group_id'));
;
?>

<?php if ( (isset($_GET[0]['updated']) && Aspis_isset($_GET[0]['updated'])))
 {;
?>
<div id="message" class="updated fade"><p><strong><?php _e('Settings saved.');
?></strong></p></div>
<?php };
