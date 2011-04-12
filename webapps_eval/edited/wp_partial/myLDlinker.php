<?php require_once('AspisMain.php'); ?><?php
require_once ("wp-load.php");
function update_counter (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$wpdb->hide_errors();
$table = $wpdb->prefix . "links_dump";
$q = "SELECT * FROM " . $table . " WHERE link_id=" . deAspisWarningRC($_GET[0]['url']);
echo "query= $q<br>";
$sql_query = $wpdb->prepare($q);
$url = $wpdb->get_row($sql_query,ARRAY_A);
$visits = $url['visits'] + 1;
$sql_query = $wpdb->prepare("UPDATE " . $table . " SET visits='" . $visits . "' WHERE link_id=" . deAspisWarningRC($_GET[0]['url']) . " LIMIT 1");
$wpdb->query($sql_query);
if ( get_option('ld_open_branding') == 0)
 {header("Location:" . $url['url']);
};
?>
<html>

<head>
<title><?php echo get_option('ld_linkdump_title') . ":" . $url['title'];
;
?></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
</head>

<frameset rows="30,*" frameborder="0">
	<frame name="header" noresize="noresize" scrolling="no" src="<?php echo get_settings('siteurl') . '/myLDbranding.php?url=' . deAspisWarningRC($_GET[0]['url']);
;
?>" />
	<frame name="main" src="<?php echo $url['url'];
;
?>" />
	<noframes>
	<body>

	<p>This page uses frames, but your browser doesn&#39;t support them.</p>


</body>
	</noframes>
</frameset>

</html>
<?php AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
update_counter();
;
?>

<?php 