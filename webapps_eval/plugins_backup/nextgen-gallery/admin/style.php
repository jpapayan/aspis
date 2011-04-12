<?php  
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

function nggallery_admin_style()  {

global $ngg;

if ( $theme_css_exists = file_exists (TEMPLATEPATH . "/nggallery.css") ) {

	$real_file = TEMPLATEPATH . "/nggallery.css";
	$file_show = 'nggallery.css ' . __('(From the theme folder)','nggallery');
	
} else {

	if (isset($_POST['css'])) {
		check_admin_referer('ngg_style');
		$act_cssfile = $_POST['css']; 
		
		if ( isset( $_POST['activate'] ) ) {
			// save option now
			$ngg->options['activateCSS'] = $_POST['activateCSS']; 
			$ngg->options['CSSfile'] = $act_cssfile;
			update_option('ngg_options', $ngg->options);
			nggGallery::show_message(__('Update Successfully','nggallery'));
		}
	} else {
		// get the options
		if (isset($_POST['file']))
			$act_cssfile = $_POST['file'];
		else
			$act_cssfile = $ngg->options['CSSfile'];	
	}
	
	// set the path
	$real_file = NGGALLERY_ABSPATH . "css/" . $act_cssfile;
}

if (isset($_POST['updatecss'])) {
	
	check_admin_referer('ngg_style');

	if ( !current_user_can('edit_themes') )
	wp_die('<p>'.__('You do not have sufficient permissions to edit templates for this blog.').'</p>');

	$newcontent = stripslashes($_POST['newcontent']);

	if (is_writeable($real_file)) {
		$f = fopen($real_file, 'w+');
		fwrite($f, $newcontent);

		fclose($f);
		nggGallery::show_message(__('CSS file successfully updated','nggallery'));
	}
}

// get the content of the file
//TODO: BUG : Read failed after write a file, maybe a Cache problem
$error = ( !is_file($real_file) );

if (!$error && filesize($real_file) > 0) {
	$f = fopen($real_file, 'r');
	$content = fread($f, filesize($real_file));
	$content = htmlspecialchars($content); 
}

?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#colorSelector').ColorPicker({
			color: '#0000ff',
			onShow: function (colpkr) {
				jQuery(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				jQuery('#colorSelector div').css('backgroundColor', '#' + hex);
			}
		});
	});
</script>
<div class="wrap">

	<div class="bordertitle">
		<h2><?php _e('Style Editor','nggallery') ?></h2>
		<?php if (!$theme_css_exists) : ?>
		<form id="themeselector" name="cssfiles" method="post">
		<?php wp_nonce_field('ngg_style') ?>
		<strong><?php _e('Activate and use style sheet:','nggallery') ?></strong>
		<input type="checkbox" name="activateCSS" value="1" <?php checked('1', $ngg->options['activateCSS']); ?> /> 
			<select name="css" id="theme" style="margin: 0pt; padding: 0pt;" onchange="this.form.submit();">
			<?php
				$csslist = ngg_get_cssfiles();
				foreach ($csslist as $key =>$a_cssfile) {
					$css_name = $a_cssfile['Name'];
					if ($key == $act_cssfile) {
						$file_show = $key;
						$selected = " selected='selected'";
						$act_css_description = $a_cssfile['Description'];
						$act_css_author = $a_cssfile['Author'];
						$act_css_version = $a_cssfile['Version'];
					}
					else $selected = '';
					$css_name = esc_attr($css_name);
					echo "\n\t<option value=\"$key\" $selected>$css_name</option>";
				}
			?>
			</select>
			<input class="button" type="submit" name="activate" value="<?php _e('Activate','nggallery') ?> &raquo;" class="button" />
		</form>
		<?php endif; ?>
	</div>
	<br style="clear: both;"/>
	
<?php if (!IS_WPMU || wpmu_site_admin() ) { ?>
	<div class="tablenav"> 
	  <?php
		if ( is_writeable($real_file) ) {
			echo '<big>' . sprintf(__('Editing <strong>%s</strong>','nggallery'), $file_show) . '</big>';
		} else {
			echo '<big>' . sprintf(__('Browsing <strong>%s</strong>','nggallery'), $file_show) . '</big>';
		}
		?>
	</div>
	<br style="clear: both;"/>
	
	<div id="templateside">
	<?php if (!$theme_css_exists) : ?>
		<ul>
			<li><strong><?php _e('Author','nggallery') ?> :</strong> <?php echo $act_css_author ?></li>
			<li><strong><?php _e('Version','nggallery') ?> :</strong> <?php echo $act_css_version ?></li>
			<li><strong><?php _e('Description','nggallery') ?> :<br /></strong> <?php echo $act_css_description ?></li>
		</ul>
		<p><?php _e('Tip : Copy your stylesheet (nggallery.css) to your theme folder, so it will be not lost during a upgrade','nggallery') ?></p>
	<?php else: ?>
		<p><?php _e('Your theme contain a NextGEN Gallery stylesheet (nggallery.css), this file will be used','nggallery') ?></p>
	<?php endif; ?>
    	<p><?php _e('Tip No. 2: Use the color picker below to help you find the right color scheme for your gallery!','nggallery') ?></p>
    	<div id="colorSelector">
        	<div></div>
        </div>
	</div>
		<?php
		if (!$error) {
		?>
		<form name="template" id="template" method="post">
			 <?php wp_nonce_field('ngg_style') ?>
			 <div><textarea cols="70" rows="25" name="newcontent" id="newcontent" tabindex="1"  class="codepress css"><?php echo $content ?></textarea>
			 <input type="hidden" name="updatecss" value="updatecss" />
			 <input type="hidden" name="file" value="<?php echo $file_show ?>" />
			 </div>
	<?php if ( is_writeable($real_file) ) : ?>
		<p class="submit">
			<input class="button-primary action" type="submit" name="submit" value="<?php _e('Update File','nggallery') ?>" tabindex="2" />
		</p>
	<?php else : ?>
	<p><em><?php _e('If this file were writable you could edit it.','nggallery'); ?></em></p>
	<?php endif; ?>
		</form>
		<?php
		} else {
			echo '<div class="error"><p>' . __('Oops, no such file exists! Double check the name and try again, merci.','nggallery') . '</p></div>';
		}
		?>
	<div class="clear"> &nbsp; </div>
</div> <!-- wrap-->
	
<?php
	}
	
} // END nggallery_admin_style()

/**********************************************************/
// ### Code from wordpress plugin import
// read in the css files
function ngg_get_cssfiles() {
	global $cssfiles;

	if (isset ($cssfiles)) {
		return $cssfiles;
	}

	$cssfiles = array ();
	
	// Files in wp-content/plugins/nggallery/css directory
	$plugin_root = NGGALLERY_ABSPATH . "css";
	
	$plugins_dir = @ dir($plugin_root);
	if ($plugins_dir) {
		while (($file = $plugins_dir->read()) !== false) {
			if (preg_match('|^\.+$|', $file))
				continue;
			if (is_dir($plugin_root.'/'.$file)) {
				$plugins_subdir = @ dir($plugin_root.'/'.$file);
				if ($plugins_subdir) {
					while (($subfile = $plugins_subdir->read()) !== false) {
						if (preg_match('|^\.+$|', $subfile))
							continue;
						if (preg_match('|\.css$|', $subfile))
							$plugin_files[] = "$file/$subfile";
					}
				}
			} else {
				if (preg_match('|\.css$|', $file))
					$plugin_files[] = $file;
			}
		}
	}

	if ( !$plugins_dir || !$plugin_files )
		return $cssfiles;

	foreach ( $plugin_files as $plugin_file ) {
		if ( !is_readable("$plugin_root/$plugin_file"))
			continue;

		$plugin_data = ngg_get_cssfiles_data("$plugin_root/$plugin_file");

		if ( empty ($plugin_data['Name']) )
			continue;

		$cssfiles[plugin_basename($plugin_file)] = $plugin_data;
	}

	uasort($cssfiles, create_function('$a, $b', 'return strnatcasecmp($a["Name"], $b["Name"]);'));

	return $cssfiles;
}

// parse the Header information
function ngg_get_cssfiles_data($plugin_file) {
	$plugin_data = implode('', file($plugin_file));
	preg_match("|CSS Name:(.*)|i", $plugin_data, $plugin_name);
	preg_match("|Description:(.*)|i", $plugin_data, $description);
	preg_match("|Author:(.*)|i", $plugin_data, $author_name);
	if (preg_match("|Version:(.*)|i", $plugin_data, $version))
		$version = trim($version[1]);
	else
		$version = '';

	$description = wptexturize(trim($description[1]));

	$name = trim($plugin_name[1]);
	$author = trim($author_name[1]);

	return array ('Name' => $name, 'Description' => $description, 'Author' => $author, 'Version' => $version );
}
?>