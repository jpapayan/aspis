<?php  
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

	function nggallery_admin_setup()  {	
		global $wpdb, $ngg;
				
		if (isset($_POST['resetdefault'])) {	
			check_admin_referer('ngg_uninstall');
						
			include_once ( dirname (__FILE__).  '/install.php');
			
			ngg_default_options();
			$ngg->load_options();
			
			nggGallery::show_message(__('Reset all settings to default parameter','nggallery'));
		}

		if (isset($_POST['uninstall'])) {	
			
			check_admin_referer('ngg_uninstall');
			
			include_once ( dirname (__FILE__).  '/install.php');

			nggallery_uninstall();
				 	
		 	nggGallery::show_message(__('Uninstall sucessful ! Now delete the plugin and enjoy your life ! Good luck !','nggallery'));
		}
	?>
	<div class="wrap">
	<h2><?php _e('Reset options', 'nggallery') ;?></h2>
		<form name="resetsettings" method="post">
			<?php wp_nonce_field('ngg_uninstall') ?>
			<p><?php _e('Reset all options/settings to the default installation.', 'nggallery') ;?></p>
			<div align="center"><input type="submit" class="button" name="resetdefault" value="<?php _e('Reset settings', 'nggallery') ;?>" onclick="javascript:check=confirm('<?php _e('Reset all options to default settings ?\n\nChoose [Cancel] to Stop, [OK] to proceed.\n','nggallery'); ?>');if(check==false) return false;" /></div>
		</form>
	</div>
	<?php if (!IS_WPMU || wpmu_site_admin() ) : ?>
	<div class="wrap">
	<h2><?php _e('Uninstall plugin tables', 'nggallery') ;?></h2>
		
		<form name="resetsettings" method="post">
		<div>
			<?php wp_nonce_field('ngg_uninstall') ?>
			<p><?php _e('You don\'t like NextGEN Gallery ?', 'nggallery') ;?></p>
			<p><?php _e('No problem, before you deactivate this plugin press the Uninstall Button, because deactivating NextGEN Gallery does not remove any data that may have been created. ', 'nggallery') ;?>
		</div>
		<p><font color="red"><strong><?php _e('WARNING:', 'nggallery') ;?></strong><br />
		<?php _e('Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to backup all the tables first. NextGEN gallery is stored in the tables', 'nggallery') ;?> <strong><?php echo $wpdb->nggpictures; ?></strong>, <strong><?php echo $wpdb->nggalbum; ?></strong> <?php _e('and', 'nggallery') ;?> <strong><?php echo $wpdb->nggalbum; ?></strong>.</font></p>
		<div align="center">
			<input type="submit" name="uninstall" class="button delete" value="<?php _e('Uninstall plugin', 'nggallery') ?>" onclick="javascript:check=confirm('<?php _e('You are about to Uninstall this plugin from WordPress.\nThis action is not reversible.\n\nChoose [Cancel] to Stop, [OK] to Uninstall.\n','nggallery'); ?>');if(check==false) return false;"/>
		</div>
		</form>
	</div>
	<?php endif; ?>

	<?php
}
?>
