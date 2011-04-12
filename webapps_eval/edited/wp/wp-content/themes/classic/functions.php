<?php require_once('AspisMain.php'); ?><?php
automatic_feed_links();
if ( function_exists(('register_sidebar')))
 register_sidebar(array(array('before_widget' => array('<li id="%1$s" class="widget %2$s">',false,false),'after_widget' => array('</li>',false,false),'before_title' => array('',false,false),'after_title' => array('',false,false),),false));
;
?>
<?php 