<?php require_once('AspisMain.php'); ?><?php
automatic_feed_links();
if ( function_exists('register_sidebar'))
 register_sidebar(array('before_widget' => '<li id="%1$s" class="widget %2$s">','after_widget' => '</li>','before_title' => '','after_title' => '',));
;
?>
<?php 