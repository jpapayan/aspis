<?php require_once('AspisMain.php'); ?><?php
if ( !defined('ABSPATH'))
 exit();
global $opml,$map;
$opml_map = array('URL' => 'link_url','HTMLURL' => 'link_url','TEXT' => 'link_name','TITLE' => 'link_name','TARGET' => 'link_target','DESCRIPTION' => 'link_description','XMLURL' => 'link_rss');
$map = $opml_map;
function startElement ( $parser,$tagName,$attrs ) {
{global $updated_timestamp,$all_links,$map;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $updated_timestamp,"\$updated_timestamp",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($all_links,"\$all_links",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($map,"\$map",$AspisChangesCache);
}{global $names,$urls,$targets,$descriptions,$feeds;
$AspisVar3 = &AspisCleanTaintedGlobalUntainted( $names,"\$names",$AspisChangesCache);
$AspisVar4 = &AspisCleanTaintedGlobalUntainted($urls,"\$urls",$AspisChangesCache);
$AspisVar5 = &AspisCleanTaintedGlobalUntainted($targets,"\$targets",$AspisChangesCache);
$AspisVar6 = &AspisCleanTaintedGlobalUntainted($descriptions,"\$descriptions",$AspisChangesCache);
$AspisVar7 = &AspisCleanTaintedGlobalUntainted($feeds,"\$feeds",$AspisChangesCache);
}if ( $tagName == 'OUTLINE')
 {foreach ( array_keys($map) as $key  )
{if ( isset($attrs[$key]))
 {$$map[$key] = $attrs[$key];
}}$names[] = $link_name;
$urls[] = $link_url;
$targets[] = $link_target;
$feeds[] = $link_rss;
$descriptions[] = $link_description;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$updated_timestamp",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$all_links",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$map",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$names",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$urls",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$targets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$descriptions",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$feeds",$AspisChangesCache);
 }
function endElement ( $parser,$tagName ) {
 }
$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser,"startElement","endElement");
if ( !xml_parse($xml_parser,$opml,true))
 {echo (sprintf(__('XML error: %1$s at line %2$s'),xml_error_string(xml_get_error_code($xml_parser)),xml_get_current_line_number($xml_parser)));
}xml_parser_free($xml_parser);
;
?>
<?php 