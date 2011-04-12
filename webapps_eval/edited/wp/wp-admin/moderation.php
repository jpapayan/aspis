<?php require_once('AspisMain.php'); ?><?php
require_once ('../wp-load.php');
wp_redirect(array('edit-comments.php?comment_status=moderated',false));
;
?>
<?php 