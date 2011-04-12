<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit();
global $opml,$map;
$opml_map = array(array('URL' => array('link_url',false,false),'HTMLURL' => array('link_url',false,false),'TEXT' => array('link_name',false,false),'TITLE' => array('link_name',false,false),'TARGET' => array('link_target',false,false),'DESCRIPTION' => array('link_description',false,false),'XMLURL' => array('link_rss',false,false)),false);
$map = $opml_map;
function startElement ( $parser,$tagName,$attrs ) {
global $updated_timestamp,$all_links,$map;
global $names,$urls,$targets,$descriptions,$feeds;
if ( ($tagName[0] == ('OUTLINE')))
 {foreach ( deAspis(attAspisRC(array_keys(deAspisRC($map)))) as $key  )
{if ( ((isset($attrs[0][$key[0]]) && Aspis_isset( $attrs [0][$key[0]]))))
 {${$map[0][$key[0]][0]} = attachAspis($attrs,$key[0]);
}}arrayAssignAdd($names[0][],addTaint($link_name));
arrayAssignAdd($urls[0][],addTaint($link_url));
arrayAssignAdd($targets[0][],addTaint($link_target));
arrayAssignAdd($feeds[0][],addTaint($link_rss));
arrayAssignAdd($descriptions[0][],addTaint($link_description));
} }
function endElement ( $parser,$tagName ) {
 }
$xml_parser = array(xml_parser_create(),false);
Aspis_xml_set_element_handler($xml_parser,array("startElement",false),array("endElement",false));
if ( (!(xml_parse($xml_parser[0],$opml[0],true))))
 {echo AspisCheckPrint((Aspis_sprintf(__(array('XML error: %1$s at line %2$s',false)),array(xml_error_string(deAspisRC(array(xml_get_error_code(deAspisRC($xml_parser)),false))),false),array(xml_get_current_line_number(deAspisRC($xml_parser)),false))));
}xml_parser_free(deAspisRC($xml_parser));
;
?>
<?php 