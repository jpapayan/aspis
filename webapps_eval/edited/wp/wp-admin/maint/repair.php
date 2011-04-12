<?php require_once('AspisMain.php'); ?><?php
define(('WP_REPAIRING'),true);
require_once ('../../wp-load.php');
header(('Content-Type: text/html; charset=utf-8'));
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes();
;
?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php _e(array('WordPress &rsaquo; Database Repair',false));
;
?></title>
	<?php wp_admin_css(array('install',false),array(true,false));
;
?>
</head>
<body>
<h1 id="logo"><img alt="WordPress" src="../images/wordpress-logo.png" /></h1>

<?php if ( (!(defined(('WP_ALLOW_REPAIR')))))
 {_e(array("<p>To allow use of this page to automatically repair database problems, please add the following line to your wp-config.php file.  Once this line is added to your config, reload this page.</p><code>define('WP_ALLOW_REPAIR', true);</code>",false));
}elseif ( ((isset($_GET[0][('repair')]) && Aspis_isset( $_GET [0][('repair')]))))
 {$problems = array(array(),false);
check_admin_referer(array('repair_db',false));
if ( ((2) == deAspis($_GET[0]['repair'])))
 $optimize = array(true,false);
else 
{$optimize = array(false,false);
}$okay = array(true,false);
foreach ( $wpdb[0]->tables[0] as $table  )
{if ( deAspis(Aspis_in_array($table,$wpdb[0]->old_tables)))
 continue ;
$check = $wpdb[0]->get_row(concat1("CHECK TABLE ",$wpdb[0]->prefix));
if ( (('OK') == $check[0]->Msg_text[0]))
 {echo AspisCheckPrint(concat2(concat1("<p>The ",$wpdb[0]->prefix)," table is okay."));
}else 
{{echo AspisCheckPrint(concat2(concat(concat2(concat1("<p>The ",$wpdb[0]->prefix)," table is not okay. It is reporting the following error: <code>"),$check[0]->Msg_text),"</code>.  WordPress will attempt to repair this table&hellip;"));
$repair = $wpdb[0]->get_row(concat1("REPAIR TABLE ",$wpdb[0]->prefix));
if ( (('OK') == $check[0]->Msg_text[0]))
 {echo AspisCheckPrint(concat2(concat1("<br />&nbsp;&nbsp;&nbsp;&nbsp;Sucessfully repaired the ",$wpdb[0]->prefix)," table."));
}else 
{{echo AspisCheckPrint(concat2(concat(concat2(concat1("<br />&nbsp;&nbsp;&nbsp;&nbsp;Failed to repair the ",$wpdb[0]->prefix)," table. Error: "),$check[0]->Msg_text),"<br />"));
arrayAssign($problems[0],deAspis(registerTaint($wpdb[0]->prefix)),addTaint($check[0]->Msg_text));
$okay = array(false,false);
}}}}if ( ($okay[0] && $optimize[0]))
 {$check = $wpdb[0]->get_row(concat1("ANALYZE TABLE ",$wpdb[0]->prefix));
if ( (('Table is already up to date') == $check[0]->Msg_text[0]))
 {echo AspisCheckPrint(concat2(concat1("<br />&nbsp;&nbsp;&nbsp;&nbsp;The ",$wpdb[0]->prefix)," table is already optimized."));
}else 
{{$check = $wpdb[0]->get_row(concat1("OPTIMIZE TABLE ",$wpdb[0]->prefix));
if ( ((('OK') == $check[0]->Msg_text[0]) || (('Table is already up to date') == $check[0]->Msg_text[0])))
 echo AspisCheckPrint(concat2(concat1("<br />&nbsp;&nbsp;&nbsp;&nbsp;Sucessfully optimized the ",$wpdb[0]->prefix)," table."));
else 
{echo AspisCheckPrint(concat(concat2(concat1("<br />&nbsp;&nbsp;&nbsp;&nbsp;Failed to optimize the ",$wpdb[0]->prefix)," table. Error: "),$check[0]->Msg_text));
}}}}echo AspisCheckPrint(array('</p>',false));
}if ( (!((empty($problems) || Aspis_empty( $problems)))))
 {printf(deAspis(__(array('<p>Some database problems could not be repaired. Please copy-and-paste the following list of errors to the <a href="%s">WordPress support forums</a> to get additional assistance.</p>',false))),'http://wordpress.org/support/forum/3');
$problem_output = array(array(),false);
foreach ( $problems[0] as $table =>$problem )
{restoreTaint($table,$problem);
arrayAssignAdd($problem_output[0][],addTaint(concat(concat2($table,": "),$problem)));
}echo AspisCheckPrint(concat2(concat1('<textarea name="errors" id="errors" rows="20" cols="60">',format_to_edit(Aspis_implode(array("\n",false),$problem_output))),'</textarea>'));
}else 
{{_e(array("<p>Repairs complete.  Please remove the following line from wp-config.php to prevent this page from being used by unauthorized users.</p><code>define('WP_ALLOW_REPAIR', true);</code>",false));
}}}else 
{{if ( (((isset($_GET[0][('referrer')]) && Aspis_isset( $_GET [0][('referrer')]))) && (('is_blog_installed') == deAspis($_GET[0]['referrer']))))
 _e(array('One or more database tables is unavailable.  To allow WordPress to attempt to repair these tables, press the "Repair Database" button. Repairing can take awhile, so please be patient.',false));
else 
{_e(array('WordPress can automatically look for some common database problems and repair them.  Repairing can take awhile, so please be patient.',false));
}?>
	<p class="step"><a class="button" href="<?php echo AspisCheckPrint(wp_nonce_url(array('repair.php?repair=1',false),array('repair_db',false)));
?>"><?php _e(array('Repair Database',false));
;
?></a></p>
	<?php _e(array('WordPress can also attempt to optimize the database.  This improves performance in some situations.  Repairing and optimizing the database can take a long time and the database will be locked while optimizing.',false));
;
?>
	<p class="step"><a class="button" href="<?php echo AspisCheckPrint(wp_nonce_url(array('repair.php?repair=2',false),array('repair_db',false)));
?>"><?php _e(array('Repair and Optimize Database',false));
;
?></a></p>
<?php }};
?>
</body>
</html><?php 