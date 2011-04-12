<?php require_once('AspisMain.php'); ?><?php
function wp_embed_handler_googlevideo ( $matches,$attr,$url,$rawattr ) {
if ( !empty($rawattr['width']) && !empty($rawattr['height']))
 {$width = (int)$rawattr['width'];
$height = (int)$rawattr['height'];
}else 
{{list($width,$height) = wp_expand_dimensions(425,344,$attr['width'],$attr['height']);
}}{$AspisRetTemp = apply_filters('embed_googlevideo','<embed type="application/x-shockwave-flash" src="http://video.google.com/googleplayer.swf?docid=' . esc_attr($matches[2]) . '&amp;hl=en&amp;fs=true" style="width:' . esc_attr($width) . 'px;height:' . esc_attr($height) . 'px" allowFullScreen="true" allowScriptAccess="always"></embed>',$matches,$attr,$url,$rawattr);
return $AspisRetTemp;
} }
wp_embed_register_handler('googlevideo','#http://video\.google\.([A-Za-z.]{2,5})/videoplay\?docid=([\d-]+)(.*?)#i','wp_embed_handler_googlevideo');
function wp_embed_handler_polldaddy ( $matches,$attr,$url,$rawattr ) {
{$AspisRetTemp = apply_filters('embed_polldaddy','<script type="text/javascript" charset="utf8" src="http://s3.polldaddy.com/p/' . esc_attr($matches[1]) . '"></script>',$matches,$attr,$url,$rawattr);
return $AspisRetTemp;
} }
wp_embed_register_handler('polldaddy','#http://answers.polldaddy.com/poll/(\d+)(.*?)#i','wp_embed_handler_polldaddy');
;
