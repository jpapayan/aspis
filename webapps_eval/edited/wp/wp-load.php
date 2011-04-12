<?php require_once('AspisMain.php'); ?><?php
define(('ABSPATH'),(deconcat2(Aspis_dirname(array(__FILE__,false)),'/')));
if ( defined(('E_RECOVERABLE_ERROR')))
 error_reporting(deAspisRC(array(((((E_ERROR | E_WARNING) | E_PARSE) | E_USER_ERROR) | E_USER_WARNING) | E_RECOVERABLE_ERROR,false)));
else 
{error_reporting(deAspisRC(array((((E_ERROR | E_WARNING) | E_PARSE) | E_USER_ERROR) | E_USER_WARNING,false)));
}if ( file_exists((deconcat12(ABSPATH,'wp-config.php'))))
 {require_once (deconcat12(ABSPATH,'wp-config.php'));
}elseif ( (file_exists((deconcat2(Aspis_dirname(array(ABSPATH,false)),'/wp-config.php'))) && (!(file_exists((deconcat2(Aspis_dirname(array(ABSPATH,false)),'/wp-settings.php')))))))
 {require_once (deconcat2(Aspis_dirname(array(ABSPATH,false)),'/wp-config.php'));
}else 
{{if ( (strpos(deAspis($_SERVER[0]['PHP_SELF']),'wp-admin') !== false))
 $path = array('',false);
else 
{$path = array('wp-admin/',false);
}require_once (deconcat12(ABSPATH,'/wp-includes/classes.php'));
require_once (deconcat12(ABSPATH,'/wp-includes/functions.php'));
require_once (deconcat12(ABSPATH,'/wp-includes/plugin.php'));
$text_direction = array("ltr",false);
wp_die(Aspis_sprintf(array("There doesn't seem to be a <code>wp-config.php</code> file. I need this before we can get started. Need more help? <a href='http://codex.wordpress.org/Editing_wp-config.php'>We got it</a>. You can create a <code>wp-config.php</code> file through a web interface, but this doesn't work for all server setups. The safest way is to manually create the file.</p><p><a href='%ssetup-config.php' class='button'>Create a Configuration File</a>",false),$path),array("WordPress &rsaquo; Error",false),array(array(deregisterTaint(array('text_direction',false)) => addTaint($text_direction)),false));
}};
?>
<?php 