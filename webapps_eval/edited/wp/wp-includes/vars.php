<?php require_once('AspisMain.php'); ?><?php
if ( deAspis(is_admin()))
 {Aspis_preg_match(array('#/wp-admin/?(.*?)$#i',false),$PHP_SELF,$self_matches);
$pagenow = attachAspis($self_matches,(1));
$pagenow = Aspis_trim($pagenow,array('/',false));
$pagenow = Aspis_preg_replace(array('#\?.*?$#',false),array('',false),$pagenow);
if ( (((('') === $pagenow[0]) || (('index') === $pagenow[0])) || (('index.php') === $pagenow[0])))
 {$pagenow = array('index.php',false);
}else 
{{Aspis_preg_match(array('#(.*?)(/|$)#',false),$pagenow,$self_matches);
$pagenow = Aspis_strtolower(attachAspis($self_matches,(1)));
if ( (('.php') !== deAspis(Aspis_substr($pagenow,negate(array(4,false)),array(4,false)))))
 $pagenow = concat2($pagenow,'.php');
}}}else 
{{if ( deAspis(Aspis_preg_match(array('#([^/]+\.php)([?/].*?)?$#i',false),$PHP_SELF,$self_matches)))
 $pagenow = Aspis_strtolower(attachAspis($self_matches,(1)));
else 
{$pagenow = array('index.php',false);
}}}$is_lynx = $is_gecko = $is_winIE = $is_macIE = $is_opera = $is_NS4 = $is_safari = $is_chrome = $is_iphone = array(false,false);
if ( ((isset($_SERVER[0][('HTTP_USER_AGENT')]) && Aspis_isset( $_SERVER [0][('HTTP_USER_AGENT')]))))
 {if ( (strpos(deAspis($_SERVER[0]['HTTP_USER_AGENT']),'Lynx') !== false))
 {$is_lynx = array(true,false);
}elseif ( (strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_USER_AGENT'])),'chrome') !== false))
 {$is_chrome = array(true,false);
}elseif ( (strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_USER_AGENT'])),'safari') !== false))
 {$is_safari = array(true,false);
}elseif ( (strpos(deAspis($_SERVER[0]['HTTP_USER_AGENT']),'Gecko') !== false))
 {$is_gecko = array(true,false);
}elseif ( ((strpos(deAspis($_SERVER[0]['HTTP_USER_AGENT']),'MSIE') !== false) && (strpos(deAspis($_SERVER[0]['HTTP_USER_AGENT']),'Win') !== false)))
 {$is_winIE = array(true,false);
}elseif ( ((strpos(deAspis($_SERVER[0]['HTTP_USER_AGENT']),'MSIE') !== false) && (strpos(deAspis($_SERVER[0]['HTTP_USER_AGENT']),'Mac') !== false)))
 {$is_macIE = array(true,false);
}elseif ( (strpos(deAspis($_SERVER[0]['HTTP_USER_AGENT']),'Opera') !== false))
 {$is_opera = array(true,false);
}elseif ( ((strpos(deAspis($_SERVER[0]['HTTP_USER_AGENT']),'Nav') !== false) && (strpos(deAspis($_SERVER[0]['HTTP_USER_AGENT']),'Mozilla/4.') !== false)))
 {$is_NS4 = array(true,false);
}}if ( ($is_safari[0] && (strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_USER_AGENT'])),'mobile') !== false)))
 $is_iphone = array(true,false);
$is_IE = (array($is_macIE[0] || $is_winIE[0],false));
$is_apache = (array((strpos(deAspis($_SERVER[0]['SERVER_SOFTWARE']),'Apache') !== false) || (strpos(deAspis($_SERVER[0]['SERVER_SOFTWARE']),'LiteSpeed') !== false),false));
$is_IIS = (array((strpos(deAspis($_SERVER[0]['SERVER_SOFTWARE']),'Microsoft-IIS') !== false) || (strpos(deAspis($_SERVER[0]['SERVER_SOFTWARE']),'ExpressionDevServer') !== false),false));
$is_iis7 = (array(strpos(deAspis($_SERVER[0]['SERVER_SOFTWARE']),'Microsoft-IIS/7.') !== false,false));
;
