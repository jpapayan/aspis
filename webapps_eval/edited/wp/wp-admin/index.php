<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
require_once (deconcat12(ABSPATH,'wp-admin/includes/dashboard.php'));
wp_dashboard_setup();
wp_enqueue_script(array('dashboard',false));
wp_enqueue_script(array('plugin-install',false));
wp_enqueue_script(array('media-upload',false));
wp_admin_css(array('dashboard',false));
wp_admin_css(array('plugin-install',false));
add_thickbox();
$title = __(array('Dashboard',false));
$parent_file = array('index.php',false);
require_once ('admin-header.php');
$today = current_time(array('mysql',false),array(1,false));
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<div id="dashboard-widgets-wrap">

<?php wp_dashboard();
;
?>

<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<?php require (deconcat12(ABSPATH,'wp-admin/admin-footer.php'));
;
?>
<?php 