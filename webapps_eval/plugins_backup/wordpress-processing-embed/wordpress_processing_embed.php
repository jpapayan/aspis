<?php
/*
Plugin Name: Wordpress Processing Embed
Plugin URI: http://anthonymattox.com
Version: .5
Author: Anthony Mattox
Description: Embeds Processing applets into pages. | <a href="options-general.php?page=wordpress_processing_embed.php">Settings</a>
Author URI: http://www.anthonymattox.com
License: GPLv2


Copyright 2010  Anthony Mattox  (email : ahmattox@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if (!class_exists("ProcessingEmbed")){
	class ProcessingEmbed{
		var $optionName = 'pembed_options';
		
		function ProcessingEmbed() {
		}
		
		// add script tag to header to load javascript
		function addHeaderScripts() {
			$html = "\r\n<!-- processing embed scripts -->\r\n";
			$html .= '<script src="'.get_bloginfo('url').'/wp-content/plugins/wordpress-processing-embed/data/pe_deployJava.js"></script>';
			$html .= "\r\n\r\n";
			echo($html);
		}
		
		// create options when plugin is activated
		function initialize() {
			$this->getOptions();
		}
		
		// Returns an array of options
		public function getOptions() {
			$pembed_options = array(
				'width' => '450',
				'height' => '300',
				'method' => 'inline');
			$pembed_saved_options = get_option($this->optionName);
			foreach ($pembed_saved_options as $key => $option) {
				$pembed_options[$key] = $option;
			}
			update_option($this->optionName, $pembed_options);
			return $pembed_options;
		}
		
		function createAdminPanel() {
			$options = $this->getOptions();
			// update options if they have been set
			if (isset($_POST['update_settings'])) {
				if(isset($_POST['width'])) {
					// $options['width'] = $_POST['width'];
					$options['width'] = preg_replace('/[a-zA-Z ;,]+/', '', $_POST['width']);
				}
				if(isset($_POST['height'])) {
					// $options['height'] = $_POST['height'];
					$options['height'] = preg_replace('/[a-zA-Z ;,]+/', '', $_POST['height']);
				}
				if(isset($_POST['method'])) {
					$options['method'] = $_POST['method'];
				}
				
				update_option($this->optionName, $options);
				echo('<div class="updated"><p><strong>');
				_e("Settings Updated.", "processing_embed");
				echo('</strong></p></div>');
			}
			
			/*
			 *  Wordpress Admin Panel
			 *
			 */ ?>
			<div class="wrap">
				<form method="post" action="<?php echo($_SERVER["REQUEST_URI"]); ?>" >
					<h2>Wordpress Processing Embed</h2>
					<h3>Load Method</h3>
					<input type="radio" name="method" value="inline" <?php if($options['method']=='inline') {echo('checked="checked"' );} ?>/> <label>Inline: <small>Embed directly in the page.</small></label><br />
					<input type="radio" name="method" value="newwindow" <?php if($options['method']=='newwindow') {echo('checked="checked"' );} ?>/> <label>New Window: <small>Load in a new window when alt content is clicked.</small></label><br />
					<input type="radio" name="method" value="onclick" <?php if($options['method']=='onclick') {echo('checked="checked"' );} ?>/> <label>On Click: <small>Load in page when alt content is clicked.</small></label><br />
					<br />
					<h3>Default Size <small>(in pixels)</small></h3>
					<label for="width" style="float:left;width:5em;padding:3px 0 0;">Width:</label>
					<input type="text" name="width" id="width" value="<?php echo($options['width']); ?>" />
					<br />
					<label for="height" style="float:left;width:5em;padding:3px 0 0;">Height:</label>
					<input type="text" name="height" id="height" value="<?php echo($options['height']); ?>" />
					<br />
					<div class="submit">
						<input type="submit" name="update_settings" value="<?php _e('Update Settings', 'processing_embed'); ?> &raquo;" />
					</div>
				</form>
				<br />
				<div style="width:450px;">
					<h3>Usage Notes</h3>
					<p>To embed a <a href="http://www.processing.org">Processing</a> applet in a page: first check that '<em>use multiple .jar files</em>' is selected in <a href="http://www.processing.org">Processing</a>, then export the applet and upload the '.jar' file with the title of your script.</p>
					<p>Add the shortcode to the post or page that the applet should appear in.</p>
					<code>[processing file="your-applet.jar"]</code>
					<p>The 'width', 'height', and 'method' paramaters can also be set if they should be different from the defaults above. Alternate content can be closed in the shortcode. This will be wrapped in a link for the 'newwindow' and 'onclick' methods and will display in the 'inline' method if java is not installed.</p>
					<code>example: [processing width="450" height="300" file="http://domain.com/wp-content/uploads/2010/11/your-applet.jar" method="onclick"]Load the applet[/processing]</code>
				</div>
				<br />
				<p>Wordpres Processing Embed created by <a href="http://www.anthonymattox.com">Anthony Mattox</a>.</p>
			</div><?php
		}
	}
}

if (class_exists("ProcessingEmbed")) {
	$pembed = new ProcessingEmbed();
}

//Initialize the admin panel
if (!function_exists("pembed_ap")) {
	function pembed_ap() {
		global $pembed;
		if (!isset($pembed)) {
			return;
		}
		if (function_exists('add_options_page')) {
			add_options_page('Processing Embed', 'Processing Embed', 9, basename(__FILE__), array(&$pembed, 'createAdminPanel'));
		}
	}	
}
		
function embed_applet($attributes, $altcontent=null) {
	$html = "";
	if (!isset($attributes['file']) || $attributes['file']=='') {
		// if no file is selectd display error message and alternate content
		$html.='<p><strong>No File Selected</strong></p>';
		$html.='<p>'.$altcontent.'</p>';
	} else {
		// otherwise insert embed code
		$options = get_option('pembed_options');
		// merge the passed attributes into the default settings
		$settings = array_merge($options, $attributes);
		$settings['name'] = preg_replace('/.jar/', '', $settings['file']);
		$settings['name'] = preg_replace('/^.+\//', '', $settings['name']);
		$settings['pluginurl'] = get_bloginfo('url')."/wp-content/plugins/wordpress-processing-embed";
		
		/* // Output settings for testing
		$html .= "<ul>";
		foreach ($settings as $key => $value) {
			$html .= "<li>{$key}: {$value}</li>";
		}
		$html .= "</ul>";*/
		
		// generate the embed code
		$html .= "<div class=\"processing_embed\" id=\"{$settings['name']}_container\">";
		
		if ($settings['method']=='inline') {
			/*
			 *   Inline
			 */
			$html .= "<script type=\"text/javascript\">
				/* <![CDATA[ */
				var attributes = { 
					code: '{$settings['name']}.class',
					archive: '{$settings['file']},{$settings['pluginurl']}/data/core.jar',
					width: {$settings['width']}, 
					height: {$settings['height']},
					image: '{$settings['pluginurl']}/data/loading.gif'
					};
				var parameters = { };
				var version = '1.5';
				deployJava.runApplet(attributes, parameters, version);
				/* ]]> */
			</script>
			<noscript><div>
				<!--[if !IE]> -->
				<object classid=\"java:{$settings['name']}.class\" 
					type=\"application/x-java-applet\"
					archive=\"{$settings['file']},{$settings['pluginurl']}/data/core.jar\"
					width=\"{$settings['width']}\" height=\"{$settings['height']}\"
					standby=\"Loading Processing software...\" >
				<param name=\"archive\" value=\"{$settings['file']},{$settings['pluginurl']}/data/core.jar\" />
				
				<param name=\"mayscript\" value=\"true\" />
				<param name=\"scriptable\" value=\"true\" />
				
				<param name=\"image\" value=\"{$settings['pluginurl']}/data/loading.gif\" />
				<param name=\"boxmessage\" value=\"Loading Processing software...\" />
				<param name=\"boxbgcolor\" value=\"#FFFFFF\" />
				
				<param name=\"test_string\" value=\"outer\" />
				<!--<![endif]-->
				
				<object classid=\"clsid:8AD9C840-044E-11D1-B3E9-00805F499D93\"
					codebase=\"http://java.sun.com/update/1.6.0/jinstall-6u20-windows-i586.cab\"
					width=\"{$settings['width']}\" height=\"{{$settings['height']}}\"
					standby=\"Loading Processing software...\"  >
					
					<param name=\"code\" value=\"{$settings['name']}\" />
					<param name=\"archive\" value=\"{$settings['file']},{$settings['pluginurl']}/data/core.jar\" />
					
					<param name=\"mayscript\" value=\"true\" />
					<param name=\"scriptable\" value=\"true\" />
					
					<param name=\"image\" value=\"{$settings['pluginurl']}/data/loading.gif\" />
					<param name=\"boxmessage\" value=\"Loading Processing software...\" />
					<param name=\"boxbgcolor\" value=\"#FFFFFF\" />
					
					<param name=\"test_string\" value=\"inner\" />
					
					<p>
						{$altcontent}
						<strong>This browser does not have a Java Plug-in.
						<br />
						<a href=\"http://www.java.com/getjava\" title=\"Download Java Plug-in\">Get the latest Java Plug-in here.</a>
						</strong>
					</p>
				
				</object>
				<!--[if !IE]> -->
				</object>
				<!--<![endif]-->
			</div></noscript>";
		} elseif ($settings['method'] == 'onclick') {
			/*
			 *   On Click
			 */
			$html .= "<p><a href=\"#\" onclick=\"deployJava.addAppletTo('{$settings['name']}', '{$settings['file']}', {$settings['width']}, {$settings['height']}, '{$settings['pluginurl']}', '{$settings['name']}_container'); return false;\">";
			if (isset($altcontent)) {
				$html .= $altcontent;
			} else {
				$html .= 'Load Applet';
			}
			$html .= '</a></p>';
		} elseif ($settings['method'] == 'newwindow') {
			/*
			 *   New Window
			 */
			$html .= "<p><a href=\"#\" onclick=\"deployJava.openAppletInNewWindow('{$settings['name']}', '{$settings['file']}', {$settings['width']}, {$settings['height']}, '{$settings['pluginurl']}', '{$altcontent}'); return false;\">";
			if (isset($altcontent)) {
				$html .= $altcontent;
			} else {
				$html .= 'Load Applet';
			}
			$html .= '</a></p>';
		}
		$html .= "</div>";

	}
	return($html);
}

function addJarMime($mimes) {
	$mimes['jar'] = 'application/java-archive';
    return $mimes;
}

// Actions
if (isset($pembed)) {
	add_action('wordpress_processing_embed.php',  array(&$pembed, 'initialize'));
	add_action('admin_menu', 'pembed_ap');
	add_filter('upload_mimes', 'addJarMime');
	add_action('wp_head', array(&$pembed, 'addHeaderScripts'), 1);
	
	add_shortcode('processing', 'embed_applet');
}

?>