<?php require_once('AspisMain.php'); ?><?php
define('ABSPATH',dirname(__FILE__) . '/');
if ( defined('E_RECOVERABLE_ERROR'))
 error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);
else 
{error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING);
}if ( file_exists(ABSPATH . 'wp-config.php'))
 {require_once (ABSPATH . 'wp-config.php');
}elseif ( file_exists(dirname(ABSPATH) . '/wp-config.php') && !file_exists(dirname(ABSPATH) . '/wp-settings.php'))
 {require_once (dirname(ABSPATH) . '/wp-config.php');
}else 
{{if ( strpos(deAspisWarningRC($_SERVER[0]['PHP_SELF']),'wp-admin') !== false)
 $path = '';
else 
{$path = 'wp-admin/';
}require_once (ABSPATH . '/wp-includes/classes.php');
require_once (ABSPATH . '/wp-includes/functions.php');
require_once (ABSPATH . '/wp-includes/plugin.php');
$text_direction = "ltr";
wp_die(sprintf("There doesn't seem to be a <code>wp-config.php</code> file. I need this before we can get started. Need more help? <a href='http://codex.wordpress.org/Editing_wp-config.php'>We got it</a>. You can create a <code>wp-config.php</code> file through a web interface, but this doesn't work for all server setups. The safest way is to manually create the file.</p><p><a href='%ssetup-config.php' class='button'>Create a Configuration File</a>",$path),"WordPress &rsaquo; Error",array('text_direction' => $text_direction));
}};
?>
<?php 