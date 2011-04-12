<?php require_once('AspisMain.php'); ?><?php
require_once ("wp-load.php");
function update_counter (  ) {
global $wpdb;
$wpdb[0]->hide_errors();
$table = concat2($wpdb[0]->prefix,"links_dump");
$q = concat(concat2(concat1("SELECT * FROM ",$table)," WHERE link_id="),$_GET[0]['url']);
echo AspisCheckPrint(concat2(concat1("query= ",$q),"<br>"));
$sql_query = $wpdb[0]->prepare($q);
$url = $wpdb[0]->get_row($sql_query,array(ARRAY_A,false));
$visits = array(deAspis($url[0]['visits']) + (1),false);
$sql_query = $wpdb[0]->prepare(concat2(concat(concat2(concat(concat2(concat1("UPDATE ",$table)," SET visits='"),$visits),"' WHERE link_id="),$_GET[0]['url'])," LIMIT 1"));
$wpdb[0]->query($sql_query);
if ( (deAspis(get_option(array('ld_open_branding',false))) == (0)))
 {header((deconcat1("Location:",$url[0]['url'])));
};
?>
<html>

<head>
<title><?php echo AspisCheckPrint(concat(concat2(get_option(array('ld_linkdump_title',false)),":"),$url[0]['title']));
;
?></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
</head>

<frameset rows="30,*" frameborder="0">
	<frame name="header" noresize="noresize" scrolling="no" src="<?php echo AspisCheckPrint(concat(concat2(get_settings(array('siteurl',false)),'/myLDbranding.php?url='),$_GET[0]['url']));
;
?>" />
	<frame name="main" src="<?php echo AspisCheckPrint($url[0]['url']);
;
?>" />
	<noframes>
	<body>

	<p>This page uses frames, but your browser doesn&#39;t support them.</p>


</body>
	</noframes>
</frameset>

</html>
<?php  }
update_counter();
;
?>

<?php 