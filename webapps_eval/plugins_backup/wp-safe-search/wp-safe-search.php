<?php
/*
Plugin Name: WP Safe Search
Plugin URI: http://wobeo.com/wordpress-free-plugins/wp-safesearch-filter-wordpress-adult-content/
Description: Allows users to filter adult posts from the result pages. At any time users may switch 'safe' and 'unsafe' views, this action sets / unsets a session cookie.
Version: 0.7
Author: Olivier Heinrich
Author URI: http://www.wobeo.com/
*/

/* Credits
wpss_init() based on some code from WP Custom Queries
Author: Callum Macdonald (http://www.callum-macdonald.com/)
http://www.callum-macdonald.com/code/wp-custom-queries/
*/

/* Credits
wpss_spreadparam()  borrowed from YD Spread Parameter Plugin
 Author: Yann Dubois (http://yann.com)
 http://wordpress.org/extend/plugins/yd-spread-parameter/
 */
 
require_once 'wp-safe-search.inc.php'; // cookies related shared functions

// Plugin name
if (!defined('WPSS')) define('WPSS' , 'wp-safesearch' );
// Display name
if (!defined('WPSS_TXT')) define('WPSS_TXT' , 'WP Safe Search' );
// variables
$pluginname = str_replace(array(basename( __FILE__),"/"),array("/",""),plugin_basename(__FILE__));
$path = '/wp-content/plugins/'.$pluginname;

$expire = time()+3600*24*1000;

// Options - Must be called as global when used in functions
$options = get_option(WPSS);

function wpss_loadjs() {
	global $pluginname;
	if ( !is_admin() )
	{
		wp_enqueue_script('wpssloadjs', WP_PLUGIN_URL.'/'.$pluginname.'/'.$pluginname.'.js');
	}
}
add_action('init','wpss_loadjs');

function wpss_safesearch($before='',$after='')
{
	global $options;
	global $path;
	$sep = (!empty($_SERVER['QUERY_STRING']) ? '&' : '?');

	$label_enable = $options['widget']['widget_label_enable']; // 'Enable SafeSearch'
	$label_enabled = $options['widget']['widget_label_enabled']; // 'SafeSearch Enabled',
	$label_disable = $options['widget']['widget_label_disable']; // 'Disable SafeSearch',
	$label_disabled = $options['widget']['widget_label_disabled']; // 'SafeSearch Disabled',

	echo $before . '<div id="wpssbox"><script type="text/javascript">checkCookie(\'' . $path . '\',\'' . $label_enable . '\',\'' . $label_enabled . '\',\'' . $label_disable . '\',\'' . $label_disabled . '\');</script></div>' . $after;

}

function wpss_getversion() {
	return '0.7';
}

function wpss_optionspage() {
	if (function_exists('add_options_page')) {
  		add_options_page(WPSS_TXT . ' - v' . wpss_getversion(), WPSS_TXT , 8, __FILE__, 'wpss_options');
	}
}
add_action('admin_menu', 'wpss_optionspage');

function wpss_options() {
	global $options;
	$error = false;

	$taxonomies=get_taxonomies('','names');
	$options = $newoptions = get_option(WPSS);

	// mise à jour des options
	if (isset($_POST['wpss_update']))
	{
		if (!current_user_can( 'manage_options' )) die(__( 'You cannot edit the ' . WPSS_TXT . ' options.' ));
		
		// taxonomies
		foreach ($taxonomies as $taxonomy ) {
			if (in_array($taxonomy, array('category','post_tag')))
			{
				$newoptions['taxonomy'][$taxonomy] = $_POST[$taxonomy];
			}
		}
		
		// widget
		$newoptions['widget']['widget_title'] = stripslashes($_POST['widget_title']);
		$newoptions['widget']['widget_label_enable'] = stripslashes($_POST['widget_label_enable']);
		$newoptions['widget']['widget_label_disable'] = stripslashes($_POST['widget_label_disable']);
		$newoptions['widget']['widget_label_enabled'] = stripslashes($_POST['widget_label_enabled']);
		$newoptions['widget']['widget_label_disabled'] = stripslashes($_POST['widget_label_disabled']);

		if ( $options != $newoptions )
		{
			$options = $newoptions;
			update_option(WPSS, $options);
		?>
		<div class="updated"><p><?php _e('Options saved!', WPSS); ?></p></div>
		<?php
		}
	}
	else if(isset($_POST['wpss_reset']))
	{
		// taxonomies
		foreach ($taxonomies as $taxonomy ) {
			if (in_array($taxonomy, array('category','post_tag')))
			{
				$options['taxonomy'][$taxonomy] = 0;
			}
		}

		// widget
		$options['widget'] = array(
			'widget_title' => WPSS_TXT,
			'widget_label_enable' => 'Enable SafeSearch',
			'widget_label_enabled' => 'SafeSearch Enabled',
			'widget_label_disable' => 'Disable SafeSearch',
			'widget_label_disabled' => 'SafeSearch Disabled',
		);
		update_option(WPSS, $options);
		?>
		<div class="updated"><p><?php _e('Default values restored.', WPSS); ?></p></div>
		<?php
	}

	$widget_title = attribute_escape($newoptions['widget']['widget_title']);
	$widget_label_enable = attribute_escape($newoptions['widget']['widget_label_enable']);
	$widget_label_enabled = attribute_escape($newoptions['widget']['widget_label_enabled']);
	$widget_label_disable = attribute_escape($newoptions['widget']['widget_label_disable']);
	$widget_label_disabled = attribute_escape($newoptions['widget']['widget_label_disabled']);

	if (!isset($_POST['wpss_update'])) {
		$widget_title = isset($options['widget']['widget_title']) ? $options['widget']['widget_title'] : WPSS_TXT;
		$widget_label_enable = isset($options['widget']['widget_label_enable']) ? $options['widget']['widget_label_enable'] : 'Enable SafeSearch';
		$widget_label_enabled = isset($options['widget']['widget_label_enabled']) ? $options['widget']['widget_label_enabled'] : 'SafeSearch Enabled';
		$widget_label_disable = isset($options['widget']['widget_label_disable']) ? $options['widget']['widget_label_disable'] : 'Disable SafeSearch';
		$widget_label_disabled = isset($options['widget']['widget_label_disabled']) ? $options['widget']['widget_label_disabled'] : 'SafeSearch Disabled';

		foreach ($taxonomies as $taxonomy) {
			if (in_array($taxonomy, array('category','post_tag')))
			{
				$taxonomy = (isset($options['taxonomy'][$taxonomy]) ? (int) $options['taxonomy'][$taxonomy] : 0 );
			}
		}
	}

	?>
	<div class="wrap">
		<h2><?php _e(WPSS_TXT . ' Options', WPSS); echo ' - v' . wpss_getversion(); ?></h2>
		<form method="post">
			<table>
				<tr valign="top">
					<th colspan="3" scope="row"><h3><?php _e('General Options', WPSS); ?></h3></th>
				</tr>
			<?php
			$i = 0;
			foreach ($taxonomies as $taxonomy ) {
				if (in_array($taxonomy, array('category','post_tag')))
				{
					?>
					<tr valign="top">
						<th scope="row" style="width:250px;text-align:right;"><label for="<?php echo $taxonomy; ?>"></label><?php echo $taxonomy; ?>: </th>
						<td width="100"><input name="<?php echo $taxonomy; ?>" type="text" id="<?php echo $taxonomy; ?>" value="<?php if (isset($options['taxonomy'][$taxonomy])) echo $options['taxonomy'][$taxonomy]; ?>" size="35" /></td>
						<td><?php _e('Enter all id terms to filter, comma separated', WPSS); ?></td>
					</tr>
					<?php
				}
			}
			?>
				<tr valign="top">
					<th colspan="3" scope="row"><h3><?php _e('Widget Options', WPSS); ?></h3></th>
				</tr>
				<tr valign="top">
					<th scope="row" style="width:250px;text-align:right;"><label for="widget_title"><?php _e('Widget title:', WPSS); ?></label></th>
					<td width="100">
						<input name="widget_title" type="text" id="widget_title" value="<?php echo $widget_title; ?>" size="35" />
					</td>
					<td></td>
				</tr>

				<tr valign="top">
					<th scope="row" style="width:250px;text-align:right;"><label for="widget_label_enable"><?php _e('Widget label for adding filter:', WPSS); ?></label></th>
					<td width="100">
						<input name="widget_label_enable" type="text" id="widget_label_enable" value="<?php echo $widget_label_enable; ?>" size="35" />
					</td>
					<td></td>
				</tr>

				<tr valign="top">
					<th scope="row" style="width:250px;text-align:right;"><label for="widget_label_enabled"><?php _e('Widget label when enabled:', WPSS); ?></label></th>
					<td width="100">
						<input name="widget_label_enabled" type="text" id="widget_label_enabled" value="<?php echo $widget_label_enabled; ?>" size="35" />
					</td>
					<td></td>
				</tr>

				<tr valign="top">
					<th scope="row" style="width:250px;text-align:right;"><label for="widget_label_disable"><?php _e('Widget label for removing filter:', WPSS); ?></label></th>
					<td width="100">
						<input name="widget_label_disable" type="text" id="widget_label_disable" value="<?php echo $widget_label_disable; ?>" size="35" />
					</td>
					<td></td>
				</tr>

				<tr valign="top">
					<th scope="row" style="width:250px;text-align:right;"><label for="widget_label_disabled"><?php _e('Widget label when disabled:', WPSS); ?></label></th>
					<td width="100">
						<input name="widget_label_disabled" type="text" id="widget_label_disabled" value="<?php echo $widget_label_disabled; ?>" size="35" />
					</td>
					<td></td>
				</tr>

				<tr valign="top">
					<th scope="row" style="width:250px;text-align:right;"></th>
					<td width="100"><div class="submit" style="float:left;"><input type="submit" name="wpss_update" value="<?php _e('Update Options', WPSS) ?>" style="font-weight:bold;" /></div><div class="submit" style="float:right;"><input type="submit" name="wpss_reset" value=" <?php _e('Reset Defaults', WPSS) ?> " /></div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<?php
}

function wpss_getchildrenterms($taxonomy,$parents=array())
{
	if (is_taxonomy($taxonomy))
	{
		get_taxonomy($taxonomy);
		if (is_taxonomy_hierarchical($taxonomy))
		{
			$tmp_list = $parents;
			for ($i=0; $i<count($parents); $i++) {
				$children = get_term_children( $parents[$i], $taxonomy);
				$parents = array_unique(array_merge($parents,$children));
				$tmp_list = array_merge($tmp_list,$children); 
			}
			return array_unique($tmp_list);
		}
		else
		{
			return $parents;
		}
	}
	else
	{
		return array();
	}
}

function wpss_init()
{
	if (wpss_getcookie('wpss_safesearch'))
	{
		global $options;
		
		$taxonomies=get_taxonomies('','names');
		$escape_ids = 'intval';
		//$escape_slugs = 'addslashes_gpc';
		
		//tags: we must use a trick because for these the taxonomy name is post_tag while there is no 'post_tag__not_in'
		$opened_args[] = 'tag__not_in';
		$escape_function['tag__not_in'] = $escape_ids;

		foreach ($taxonomies as $taxonomy ) {
			if (in_array($taxonomy, array('category','post_tag')))
			{
				$terms[$taxonomy] = preg_split('/\,/', $options['taxonomy'][$taxonomy], -1, PREG_SPLIT_NO_EMPTY);
				$terms_tofilter[$taxonomy] = wpss_getchildrenterms($taxonomy,$terms[$taxonomy]);
				$wpss_global[$taxonomy.'__not_in'] = $terms_tofilter[$taxonomy];
				$opened_args[] = $taxonomy.'__not_in';
				$escape_function[$taxonomy.'__not_in'] = $escape_ids;
			}
		}
		
		$wpss_catntag = array('category__not_in'=>implode(',', $terms_tofilter['category']), 'tag__not_in'=>implode(',', $terms_tofilter['post_tag']));
		$wpss_global = array_merge($wpss_global,$wpss_catntag);
		
		foreach ($opened_args as $opened_arg)
		{
			global $$opened_arg;
			$$opened_arg = array_map($escape_function[$opened_arg], explode(',', $wpss_global[$opened_arg]));
		}
	}
}
if (!is_admin())
{
	add_action('init', 'wpss_init',99); // set priority very low to ensure all customs taxonomies are loaded before (cf more-taxonomies plugin which priority is 20)
} 

function first_visit()
{
	global $expire;
	global $cookie_firstvisit;
	global $cookie_safesearch;

	//est-ce que c'est le 1er passage du visiteur ?
	if (!wpss_getcookie('wpss_firstvisit'))
	{
		wpss_setcookie( 'wpss_firstvisit', true, $expire );
		wpss_setcookie( 'wpss_safesearch', true, $expire);
	}
}
add_action('init','first_visit',0);

/*-------------------------------------------------------------------*/
// Sidebar Widget
//
function wpss_widget_init() {
    function wpss_widget_view($args) {
		global $options;
		global $path;

        extract($args);
        $title = empty($options['widget']['widget_title']) ? WPSS_TXT : $options['widget']['widget_title'];
		$label_enable = $options['widget']['widget_label_enable'];
		$label_enabled = $options['widget']['widget_label_enabled'];
		$label_disable = $options['widget']['widget_label_disable'];
		$label_disabled = $options['widget']['widget_label_disabled'];

        echo $before_widget;
        echo $before_title . $title . $after_title;
		echo '<div id="wpssbox"><script type="text/javascript">checkCookie(\'' . $path . '\',\'' . $label_enable . '\',\'' . $label_enabled . '\',\'' . $label_disable . '\',\'' . $label_disabled . '\');</script></div>';
    }

    function wpss_widget_control()
	{
		global $options;

        if (isset($_POST["wpss_widget_submit"])):
            $options['widget']['widget_title'] = strip_tags(stripslashes($_POST['wpss_widget_title']));
            update_option(WPSS, $options);
        endif;
        $title = $options['widget']['widget_title'];
		?>
        <p>
            <label for="wpss_widget_title">
                <?php _e('Title:'); ?> <input type="text" value="<?php echo $title; ?>" class="widefat" id="wpss_widget_title" name="wpss_widget_title" />
            </label>
        </p>
        <input type="hidden" name="wpss_widget_submit" value="1" />
		<?php
    }

    register_sidebar_widget(WPSS_TXT, 'wpss_widget_view');
	register_widget_control(WPSS_TXT, 'wpss_widget_control' );
}
add_action('widgets_init', 'wpss_widget_init');

/* for caching systems */
// filter_var introduced in php 5.2
if (!function_exists('filter_var'))
{
	function filter_var($string, $scope = '')
	{
		$special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
		return str_replace(' ', '-', str_replace($special_chars, '', strtolower($string)));	
	}
}

function remove_qsvar($url, $key) {
	$url = preg_replace('#(&|\?)' .$key.'=([\w]+)#is', '', $url);
	$url = preg_replace('#(http:\/{2}.*)(\/\/+)(.*)#is', '$1/$3', $url);
	return ($url);
}

function rebuild_qsvar($url,$key) {
	//$url = preg_replace('#(http:\/{2}.*)(&|\?' .$key.'=[A-Za-z0-9]*)(\/.*)#is', '$1$3$2', $url);
	$url = preg_replace('#(http:\/{2}.*)(&|\?' .$key.'=[\w]+)(\/.*)(\/$)#is', '$1$3$4$2', $url);
	$url = preg_replace('#(http:\/{2}.*)(\/\/+)(.*)#is', '$1/$3', $url);
	return $url;
return $url;;
}

function wpss_spreadparam( $html ) {
	$paramlist = array('safesearch');
	foreach( $paramlist as $param ) {
		if( isset( $_GET[$param] ) )
		{
			$tmp = filter_var($_GET[$param], FILTER_SANITIZE_STRING);
			switch($tmp)
			{
				case 'true':
				case 'false':	
					$value = $tmp;
					break;
				default:
					break;
			}
		}
		else
		{
			$value = wpss_getcookie('wpss_safesearch') ? 'true' : 'false';
		}
		
		if (empty($value)) $value = 'true';

		// remove extra qs var when filter is applied more than once (ie get_home_url)
		$html = remove_qsvar($html, "safesearch");
		
		if ($value=='false')
		{
			if( preg_match( '/\?/', $html ) ) {
				$html .= '&' . urlencode( $param ) . '=' . $value;
			} else {
				$html .= '?' . urlencode( $param ) . '=' . $value;
			}
			$html = rebuild_qsvar($html, "safesearch");
		}
	}
	
	return $html;
}

add_filter( 'attachment_link', 'wpss_spreadparam', 10 );
add_filter( 'author_feed_link', 'wpss_spreadparam', 10 );
add_filter( 'author_link', 'wpss_spreadparam', 10 );
add_filter( 'comment_reply_link', 'wpss_spreadparam', 10 );
add_filter( 'day_link', 'wpss_spreadparam', 10 );
add_filter( 'feed_link', 'wpss_spreadparam', 10 );
add_filter( 'get_comment_author_link', 'wpss_spreadparam', 10 );
add_filter( 'get_comment_author_url_link', 'wpss_spreadparam', 10 );
add_filter( 'month_link', 'wpss_spreadparam', 10 );
add_filter( 'page_link', 'wpss_spreadparam', 1, 2 );
add_filter( 'post_link', 'wpss_spreadparam', 10 );
add_filter( 'the_permalink', 'wpss_spreadparam', 10 );
add_filter( 'year_link', 'wpss_spreadparam', 10 );
add_filter( 'tag_link', 'wpss_spreadparam', 10 );
add_filter( 'post_comments_feed_link', 'wpss_spreadparam', 10 ); 
add_filter( 'category_feed_link', 'wpss_spreadparam', 10 );
add_filter( 'category_link', 'wpss_spreadparam', 10 );
//add_filter( 'admin_url', 'wpss_spreadparam', 10 );
add_filter( 'plugins_url', 'wpss_spreadparam', 10 );
add_filter( 'register', 'wpss_spreadparam', 10 );
// added for specific template functions
add_filter( 'get_home_url', 'wpss_spreadparam', 10 );
?>
