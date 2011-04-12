<?php

/*
+----------------------------------------------------------------+
+	imageRotartor-XML
+	by Alex Rabe
+   	required for NextGEN Gallery
+----------------------------------------------------------------+
*/

// look up for the path
if ( !defined('ABSPATH') ) 
    require_once( dirname(__FILE__) . '/../ngg-config.php');

global $wpdb;

$ngg_options = get_option ('ngg_options');
$siteurl	 = get_option ('siteurl');

// get the gallery id
$galleryID = (int) $_GET['gid'];

// get the pictures
if ($galleryID == 0) {
	$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 ORDER BY tt.{$ngg_options['galSort']} {$ngg_options['galSortDir']} ");
} else {
	$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = '$galleryID' AND tt.exclude != 1 ORDER BY tt.{$ngg_options['galSort']} {$ngg_options['galSortDir']} ");
}

// Create XML output
header("content-type:text/xml;charset=utf-8");

echo "<playlist version='1' xmlns='http://xspf.org/ns/0/'>\n";
echo "	<title>".stripslashes(nggGallery::i18n($thepictures[0]->name))."</title>\n";
echo "	<trackList>\n";

if (is_array ($thepictures)){
	foreach ($thepictures as $picture) {
		echo "		<track>\n";
		if (!empty($picture->description))	
		echo "			<title>".strip_tags(stripslashes(html_entity_decode(nggGallery::i18n($picture->description))))."</title>\n";
		else if (!empty($picture->alttext))	
		echo "			<title>".stripslashes(nggGallery::i18n($picture->alttext))."</title>\n";
		else 
		echo "			<title>".$picture->filename."</title>\n";
		echo "			<location>".$siteurl."/".$picture->path."/".$picture->filename."</location>\n";
		echo "		</track>\n";
	}
}
 
echo "	</trackList>\n";
echo "</playlist>\n";

?>