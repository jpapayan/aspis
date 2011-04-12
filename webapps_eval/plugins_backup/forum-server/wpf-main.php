<?php
/*
	Plugin Name: WP Forum Server
	Plugin Author: VastHTML
	Author URI: http://lucidcrew.com/
    Plugin URI: http://vasthtml.com/js/wordpress-forum-server/
	Version: 1.6.5
*/

/*
 * If the domain already exists, the translations will be merged.
 * If both sets have the same string, the translation from the original value will be taken.
 * Doc: http://phpdoc.wordpress.org/trunk/WordPress/i18n/_wp-includes---l10n.php.html
 */
//$plugin_dir = basename(dirname(__FILE__));
//load_textdomain("vasthtml", ABSPATH.'wp-content/plugins/'. $plugin_dir.'/'.'vasthtml-en_EN.mo');

include_once("wpf.class.php");

// Short and sweet :)
$vasthtml = new vasthtml();

// Activating?
register_activation_hook(__FILE__ ,array(&$vasthtml,'wp_forum_install'));

//add_action("the_content", array(&$vasthtml, "go"));

add_action('wp_head', array(&$vasthtml, "buffer_start"));
add_action('wp_footer', array(&$vasthtml, "buffer_end"));

add_action('init', array(&$vasthtml,'set_cookie'));
add_action('wp_logout', array(&$vasthtml,'unset_cookie'));
add_filter("wp_title", array(&$vasthtml, "set_pagetitle"));
		
function latest_activity($num = 5){
	global $vasthtml;
	return $vasthtml->latest_activity($num);
}

?>