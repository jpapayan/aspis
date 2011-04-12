<?php require_once('AspisMain.php'); ?><?php
if ( is_admin())
 {preg_match('#/wp-admin/?(.*?)$#i',$PHP_SELF,$self_matches);
$pagenow = $self_matches[1];
$pagenow = trim($pagenow,'/');
$pagenow = preg_replace('#\?.*?$#','',$pagenow);
if ( '' === $pagenow || 'index' === $pagenow || 'index.php' === $pagenow)
 {$pagenow = 'index.php';
}else 
{{preg_match('#(.*?)(/|$)#',$pagenow,$self_matches);
$pagenow = strtolower($self_matches[1]);
if ( '.php' !== substr($pagenow,-4,4))
 $pagenow .= '.php';
}}}else 
{{if ( preg_match('#([^/]+\.php)([?/].*?)?$#i',$PHP_SELF,$self_matches))
 $pagenow = strtolower($self_matches[1]);
else 
{$pagenow = 'index.php';
}}}$is_lynx = $is_gecko = $is_winIE = $is_macIE = $is_opera = $is_NS4 = $is_safari = $is_chrome = $is_iphone = false;
if ( (isset($_SERVER[0]['HTTP_USER_AGENT']) && Aspis_isset($_SERVER[0]['HTTP_USER_AGENT'])))
 {if ( strpos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'Lynx') !== false)
 {$is_lynx = true;
}elseif ( strpos(strtolower(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT'])),'chrome') !== false)
 {$is_chrome = true;
}elseif ( strpos(strtolower(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT'])),'safari') !== false)
 {$is_safari = true;
}elseif ( strpos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'Gecko') !== false)
 {$is_gecko = true;
}elseif ( strpos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'MSIE') !== false && strpos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'Win') !== false)
 {$is_winIE = true;
}elseif ( strpos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'MSIE') !== false && strpos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'Mac') !== false)
 {$is_macIE = true;
}elseif ( strpos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'Opera') !== false)
 {$is_opera = true;
}elseif ( strpos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'Nav') !== false && strpos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'Mozilla/4.') !== false)
 {$is_NS4 = true;
}}if ( $is_safari && strpos(strtolower(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT'])),'mobile') !== false)
 $is_iphone = true;
$is_IE = ($is_macIE || $is_winIE);
$is_apache = (strpos(deAspisWarningRC($_SERVER[0]['SERVER_SOFTWARE']),'Apache') !== false || strpos(deAspisWarningRC($_SERVER[0]['SERVER_SOFTWARE']),'LiteSpeed') !== false);
$is_IIS = (strpos(deAspisWarningRC($_SERVER[0]['SERVER_SOFTWARE']),'Microsoft-IIS') !== false || strpos(deAspisWarningRC($_SERVER[0]['SERVER_SOFTWARE']),'ExpressionDevServer') !== false);
$is_iis7 = (strpos(deAspisWarningRC($_SERVER[0]['SERVER_SOFTWARE']),'Microsoft-IIS/7.') !== false);
;
