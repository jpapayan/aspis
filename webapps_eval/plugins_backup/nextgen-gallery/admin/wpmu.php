<?php  
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

	function nggallery_wpmu_setup()  {	
		global $wpdb;
	
	//to be sure
	if (!is_site_admin())
 		die('You are not allowed to call this page.');

	// get the options
	$ngg_options = get_site_option('ngg_options');
	
	// same as $_SERVER['REQUEST_URI'], but should work under IIS 6.0
	$filepath    = site_url( 'wp-admin/wpmu-admin.php?page=' . $_GET['page'], 'admin' );

	if ( isset($_POST['updateoption']) ) {	
		check_admin_referer('ngg_wpmu_settings');
		// get the hidden option fields, taken from WP core
		if ( $_POST['page_options'] )	
			$options = explode(',', stripslashes($_POST['page_options']));
		if ($options) {
			foreach ($options as $option) {
				$option = trim($option);
				$value = trim($_POST[$option]);
		//		$value = sanitize_option($option, $value); // This does strip slashes on those that need it
				$ngg_options[$option] = $value;
			}
		}

		update_site_option('ngg_options', $ngg_options);
	 	$messagetext = __('Update successfully','nggallery');
	}		
	
	// message windows
	if(!empty($messagetext)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$messagetext.'</p></div>'; }
	
	?>

	<div class="wrap">
		<h2><?php _e('General WordPress MU Settings','nggallery'); ?></h2>
		<form name="generaloptions" method="post">
		<?php wp_nonce_field('ngg_wpmu_settings') ?>
		<input type="hidden" name="page_options" value="gallerypath,wpmuQuotaCheck,wpmuZipUpload,wpmuStyle,wpmuRoles,wpmuCSSfile" />
			<table class="form-table">
				<tr valign="top">
					<th align="left"><?php _e('Gallery path','nggallery') ?></th>
					<td><input type="text" size="50" name="gallerypath" value="<?php echo $ngg_options[gallerypath]; ?>" title="TEST" /><br />
					<?php _e('This is the default path for all blogs. With the placeholder %BLOG_ID% you can organize the folder structure better. The path must end with a /.','nggallery') ?></td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Enable upload quota check','nggallery') ?>:</th>
					<td><input name="wpmuQuotaCheck" type="checkbox" value="1" <?php checked('1', $ngg_options[wpmuQuotaCheck]); ?> />
					<?php _e('Should work if the gallery is bellow the blog.dir','nggallery') ?>
					</td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Enable zip upload option','nggallery') ?>:</th>
					<td><input name="wpmuZipUpload" type="checkbox" value="1" <?php checked('1', $ngg_options[wpmuZipUpload]); ?> />
					<?php _e('Allow users to upload zip folders.','nggallery') ?>
					</td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Enable style selection','nggallery') ?>:</th>
					<td><input name="wpmuStyle" type="checkbox" value="1" <?php checked('1', $ngg_options[wpmuStyle]); ?> />
					<?php _e('Allow users to choose a style for the gallery.','nggallery') ?>
					</td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Enable roles/capabilities','nggallery') ?>:</th>
					<td><input name="wpmuRoles" type="checkbox" value="1" <?php checked('1', $ngg_options[wpmuRoles]); ?> />
					<?php _e('Allow users to change the roles for other blog authors.','nggallery') ?>
					</td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Default style','nggallery') ?>:</th>
					<td>
					<select name="wpmuCSSfile">
					<?php
						$csslist = ngg_get_cssfiles();
						foreach ($csslist as $key =>$a_cssfile) {
							$css_name = $a_cssfile['Name'];
							if ($key == $ngg_options[wpmuCSSfile]) {
								$file_show = $key;
								$selected = " selected='selected'";
							}
							else $selected = '';
							$css_name = esc_attr($css_name);
							echo "\n\t<option value=\"$key\" $selected>$css_name</option>";
						}
					?>
					</select><br />
					<?php _e('Choose the default style for the galleries.','nggallery') ?>
					</td>
				</tr>
			</table> 				
			<div class="submit"><input type="submit" name="updateoption" value="<?php _e('Update') ;?> &raquo;"/></div>
		</form>	
	</div>	

	<?php
}	
?>