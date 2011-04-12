<?php require_once('AspisMain.php'); ?><?php
function wp_embed_handler_googlevideo ( $matches,$attr,$url,$rawattr ) {
if ( ((!((empty($rawattr[0][('width')]) || Aspis_empty( $rawattr [0][('width')])))) && (!((empty($rawattr[0][('height')]) || Aspis_empty( $rawattr [0][('height')]))))))
 {$width = int_cast($rawattr[0]['width']);
$height = int_cast($rawattr[0]['height']);
}else 
{{list($width,$height) = deAspisList(wp_expand_dimensions(array(425,false),array(344,false),$attr[0]['width'],$attr[0]['height']),array());
}}return apply_filters(array('embed_googlevideo',false),concat2(concat(concat2(concat(concat2(concat1('<embed type="application/x-shockwave-flash" src="http://video.google.com/googleplayer.swf?docid=',esc_attr(attachAspis($matches,(2)))),'&amp;hl=en&amp;fs=true" style="width:'),esc_attr($width)),'px;height:'),esc_attr($height)),'px" allowFullScreen="true" allowScriptAccess="always"></embed>'),$matches,$attr,$url,$rawattr);
 }
wp_embed_register_handler(array('googlevideo',false),array('#http://video\.google\.([A-Za-z.]{2,5})/videoplay\?docid=([\d-]+)(.*?)#i',false),array('wp_embed_handler_googlevideo',false));
function wp_embed_handler_polldaddy ( $matches,$attr,$url,$rawattr ) {
return apply_filters(array('embed_polldaddy',false),concat2(concat1('<script type="text/javascript" charset="utf8" src="http://s3.polldaddy.com/p/',esc_attr(attachAspis($matches,(1)))),'"></script>'),$matches,$attr,$url,$rawattr);
 }
wp_embed_register_handler(array('polldaddy',false),array('#http://answers.polldaddy.com/poll/(\d+)(.*?)#i',false),array('wp_embed_handler_polldaddy',false));
;
