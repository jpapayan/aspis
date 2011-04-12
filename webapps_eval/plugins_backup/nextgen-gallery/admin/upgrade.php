<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

/**
 * ngg_upgrade() - update routine for older version
 * 
 * @return Success message
 */
function ngg_upgrade() {
	
	global $wpdb, $user_ID, $nggRewrite;

	// get the current user ID
	get_currentuserinfo();

	// Be sure that the tables exist
	if($wpdb->get_var("show tables like '$wpdb->nggpictures'") == $wpdb->prefix . 'ngg_pictures') {

		echo __('Upgrade database structure...', 'nggallery');
		$wpdb->show_errors();

		$installed_ver = get_option( "ngg_db_version" );
		
		// 0.9.7 is smaller that 0.97, my fault :-)
		if ( $installed_ver == '0.9.7' ) $installed_ver = '0.97';

		// v0.33 -> v.071
		if (version_compare($installed_ver, '0.71', '<')) {
			$wpdb->query("ALTER TABLE $wpdb->nggpictures CHANGE pid pid BIGINT(20) NOT NULL AUTO_INCREMENT ");
			$wpdb->query("ALTER TABLE $wpdb->nggpictures CHANGE galleryid galleryid BIGINT(20) NOT NULL ");
			$wpdb->query("ALTER TABLE $wpdb->nggallery CHANGE gid gid BIGINT(20) NOT NULL AUTO_INCREMENT ");
			$wpdb->query("ALTER TABLE $wpdb->nggallery CHANGE pageid pageid BIGINT(20) NULL DEFAULT '0'");
			$wpdb->query("ALTER TABLE $wpdb->nggallery CHANGE previewpic previewpic BIGINT(20) NULL DEFAULT '0'");
			$wpdb->query("ALTER TABLE $wpdb->nggallery CHANGE gid gid BIGINT(20) NOT NULL AUTO_INCREMENT ");
			$wpdb->query("ALTER TABLE $wpdb->nggallery CHANGE description galdesc MEDIUMTEXT NULL");
		}
		
		// v0.71 -> v0.84
		if (version_compare($installed_ver, '0.84', '<')) {
			ngg_maybe_add_column( $wpdb->nggpictures, 'sortorder', "BIGINT(20) DEFAULT '0' NOT NULL AFTER exclude");
		}

		// v0.84 -> v0.95
		if (version_compare($installed_ver, '0.95', '<')) {
			// first add the author field and set it to the current administrator
			ngg_maybe_add_column( $wpdb->nggallery, 'author', "BIGINT(20) NOT NULL DEFAULT '$user_ID' AFTER previewpic");
			// switch back to zero
			$wpdb->query("ALTER TABLE $wpdb->nggallery CHANGE author author BIGINT(20) NOT NULL DEFAULT '0'");
		}

		// v0.95 -> v0.97 
		if (version_compare($installed_ver, '0.96', '<')) {
			// Convert into WordPress Core taxonomy scheme
			ngg_convert_tags();
			// Drop tables, we don't need them anymore
			$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ngg_tags");
			$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ngg_pic2tags");
			
			// New capability for administrator role
			$role = get_role('administrator');
			$role->add_cap('NextGEN Manage tags');
			
			// Add new option
			$ngg_options = get_option('ngg_options');
			$ngg_options['graphicLibrary']  = 'gd';
			update_option('ngg_options', $ngg_options);	
			
		}
		
		// v0.97 -> v1.00
		if (version_compare($installed_ver, '0.97', '<')) {
			ngg_maybe_add_column( $wpdb->nggpictures, 'imagedate', "DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER alttext");
		}
		
		// v0.97 -> v1.3.0
		if (version_compare($installed_ver, '1.3.0', '<')) {
			ngg_maybe_add_column( $wpdb->nggpictures, 'post_id', "BIGINT(20) DEFAULT '0' NOT NULL AFTER pid");
			ngg_maybe_add_column( $wpdb->nggpictures, 'meta_data', "LONGTEXT AFTER sortorder");
			$wpdb->query("ALTER TABLE " . $wpdb->nggpictures . " ADD INDEX post_id ( post_id )");
		}
		
		// v1.3.0 -> v1.3.1
		if (version_compare($installed_ver, '1.3.1', '<')) {
			// add description and previewpic for the album itself
			ngg_maybe_add_column( $wpdb->nggalbum, 'previewpic', "BIGINT(20) DEFAULT '0' NOT NULL AFTER name");
			ngg_maybe_add_column( $wpdb->nggalbum, 'albumdesc', "MEDIUMTEXT NULL AFTER previewpic");
		}		
		
		 // v1.3.5 -> v1.4.0
        if (version_compare($installed_ver, '1.4.0', '<')) {
            // add link from album to a page
            ngg_maybe_add_column( $wpdb->nggalbum, 'pageid', "BIGINT(20) DEFAULT '0' NOT NULL AFTER sortorder");
        }   
		
        // better to flush rewrite rules after upgrades
        $nggRewrite->flush();
        
		// update now the database
		update_option( "ngg_db_version", NGG_DBVERSION );
		echo __('finished', 'nggallery') . "<br />\n";
		$wpdb->hide_errors();
		
		// *** From here we start file operation which could failed sometimes,
		// *** ensure that the DB changes are not performed two times...
		
		// Change all thumbnail folders to "thumbs"
		if (version_compare($installed_ver, '0.96', '<')) {
			echo __('Update file structure...', 'nggallery');
			ngg_convert_filestructure();
			echo __('finished', 'nggallery') . "<br />\n";
		}
		
		// On some reason the import / date sometimes failed, due to the memory limit
		if (version_compare($installed_ver, '0.97', '<')) {
			echo __('Import date and time information...', 'nggallery');
			ngg_import_date_time();
			echo __('finished', 'nggallery') . "<br />\n";
		}		

		// Move imagerotator outside the plugin folder
		if (version_compare($installed_ver, '1.1.0', '<')) {
			$ngg_options = get_option('ngg_options');
			echo __('Move imagerotator to new location...', 'nggallery');
			$ngg_options['irURL'] = ngg_move_imagerotator();
			$ngg_options['galPagedGalleries'] = 0;
			$ngg_options['galColumns'] = 0;
			update_option('ngg_options', $ngg_options);
			echo __('finished', 'nggallery') . "<br />\n";				
		}

		// Remove thumbcrop setting, thumbfix and quare size do the same
		if (version_compare($installed_ver, '1.4.0', '<')) {
			$ngg_options = get_option('ngg_options');
			echo __('Update settings...', 'nggallery');
			if ( $ngg_options['thumpcrop'] ) {
				$ngg_options['thumbfix'] = true;
				$ngg_options['thumbheight'] = $ngg_options['thumbwidth'] ;
				$ngg_options['galAjaxNav'] = true;
			}
			$ngg_options['galHiddenImg'] = false;
			update_option('ngg_options', $ngg_options);
			echo __('finished', 'nggallery') . "<br />\n";				
		}
        
        // Remove the old widget options
        if (version_compare($installed_ver, '1.4.4', '<')) {
            delete_option( 'ngg_widget' );
            echo __('Updated widget structure. If you used NextGEN Widgets, you need to setup them again...', 'nggallery');
        }
		
		return;
	}
}

/**
 * ngg_convert_tags() - Import the tags into the wp tables (only required for pre V1.00 versions)
 * 
 * @return Success Message
 */
function ngg_convert_tags() {
	global $wpdb, $wp_taxonomies;
		
	// get the obsolete tables
	$wpdb->nggtags						= $wpdb->prefix . 'ngg_tags';
	$wpdb->nggpic2tags					= $wpdb->prefix . 'ngg_pic2tags';
	
	$picturelist = $wpdb->get_col("SELECT pid FROM $wpdb->nggpictures");
	if ( is_array($picturelist) ) {
		foreach($picturelist as $id) {
			$tags = array();
			$tagarray = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggpic2tags AS t INNER JOIN $wpdb->nggtags AS tt ON t.tagid = tt.id WHERE t.picid = '$id' ORDER BY tt.slug ASC ");
			if (!empty($tagarray)){
				foreach($tagarray as $element) {
					$tags[$element->id] = $element->name;
				}
				wp_set_object_terms($id, $tags, 'ngg_tag');
			}
		}
	}
}

/**
 * ngg_convert_filestructure() - converter for old thumnail folder structure
 * 
 * @return void
 */
function ngg_convert_filestructure() {
	global $wpdb;
	
	$gallerylist = $wpdb->get_results("SELECT * FROM $wpdb->nggallery ORDER BY gid ASC", OBJECT_K);
	if ( is_array($gallerylist) ) {
		$errors = array();
		foreach($gallerylist as $gallery) {
			$gallerypath = WINABSPATH.$gallery->path;

			// old mygallery check, convert the wrong folder/ file name now
			if (@is_dir($gallerypath . '/tumbs')) {
				if ( !@rename($gallerypath . '/tumbs' , $gallerypath .'/thumbs') )
					$errors[] = $gallery->path . '/thumbs';
				// read list of images
				$imageslist = nggAdmin::scandir($gallerypath . '/thumbs');
				if ( !empty($imageslist)) {
					foreach($imageslist as $image) {
						$purename = substr($image, 4);
						if ( !@rename($gallerypath . '/thumbs/' . $image, $gallerypath . '/thumbs/thumbs_' . $purename ))
							$errors[] = $gallery->path . '/thumbs/thumbs_' . $purename ;
					}
				}
			}
		}
		
		if (!empty($errors)) {
			echo "<div class='error_inline'><p>". __('Some folders/files could not renamed, please recheck the permission and rescan the folder in the manage gallery section.', 'nggallery') ."</p>";
			foreach($errors as $value) {
				echo __('Rename failed', 'nggallery') . ' : <strong>' . $value . "</strong><br />\n";
			}
			echo '</div>';
		}
	}
}

/**
 * Move the imagerotator outside the plugin folder, as we remove it from the REPO with the next update
 * 
 * @return string $path URL to the imagerotator
 */
function ngg_move_imagerotator() {
	
	$upload = wp_upload_dir();
	
	// look first at the old place and move it
	if ( file_exists( NGGALLERY_ABSPATH . 'imagerotator.swf' ) )
		@rename(NGGALLERY_ABSPATH . 'imagerotator.swf', $upload['basedir'] . '/imagerotator.swf');
		
	// If it's successful then we return the new path
	if ( file_exists( $upload['basedir'] . '/imagerotator.swf' ) )
		return $upload['baseurl'] . '/imagerotator.swf';

	//In some worse case it's still at the old place
	if ( file_exists( NGGALLERY_ABSPATH . 'imagerotator.swf' ) )
		return NGGALLERY_URLPATH . 'imagerotator.swf';
	
	// if something failed, we must return a empty string
	return '';	
}

/**
 * ngg_import_date_time() - Read the timestamp from exif and insert it into the database
 * 
 * @return void
 */
function ngg_import_date_time() {
	global $wpdb;
	
	$imagelist = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid ORDER BY tt.pid ASC");
	if ( is_array($imagelist) ) {
		foreach ($imagelist as $image) {
			$picture = new nggImage($image);
			$meta = new nggMeta($picture->pid, true);
			$date = $meta->get_date_time();
			$wpdb->query("UPDATE $wpdb->nggpictures SET imagedate = '$date' WHERE pid = '$picture->pid'");
		}		
	}	
}

/**
 * Adding a new column if needed
 * Example : ngg_maybe_add_column( $wpdb->nggpictures, 'imagedate', "DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER alttext");
 * 
 * @param string $table_name Database table name.
 * @param string $column_name Database column name to create.
 * @param string $create_ddl SQL statement to create column
 * @return bool True, when done with execution.
 */
function ngg_maybe_add_column($table_name, $column_name, $create_ddl) {
	global $wpdb;
	
	foreach ($wpdb->get_col("SHOW COLUMNS FROM $table_name") as $column ) {
		if ($column == $column_name)
			return true;
	}
	
	//didn't find it try to create it.
	$wpdb->query("ALTER TABLE $table_name ADD $column_name " . $create_ddl);
	
	// we cannot directly tell that whether this succeeded!
	foreach ($wpdb->get_col("SHOW COLUMNS FROM $table_name") as $column ) {
		if ($column == $column_name)
			return true;
	}
	
	echo("Could not add column $column_name in table $table_name<br />\n");
	return false;
}

/**
 * nggallery_upgrade_page() - This page showsup , when the database version doesn't fir to the script NGG_DBVERSION constant.
 * 
 * @return Upgrade Message
 */
function nggallery_upgrade_page()  {	
	$filepath    = admin_url() . 'admin.php?page=' . $_GET['page'];
	
	if ($_GET['upgrade'] == 'now') {
		nggallery_start_upgrade($filepath);
		return;
	}
?>
<div class="wrap">
	<h2><?php _e('Upgrade NextGEN Gallery', 'nggallery') ;?></h2>
	<p><?php _e('The script detect that you upgrade from a older version.', 'nggallery') ;?>
	   <?php _e('Your database tables for NextGEN Gallery is out-of-date, and must be upgraded before you can continue.', 'nggallery'); ?>
       <?php _e('If you would like to downgrade later, please make first a complete backup of your database and the images.', 'nggallery') ;?></p>
	<p><?php _e('The upgrade process may take a while, so please be patient.', 'nggallery'); ?></p>
	<h3><a href="<?php echo $filepath;?>&amp;upgrade=now"><?php _e('Start upgrade now', 'nggallery'); ?>...</a></h3>      
</div>
<?php
}

/**
 * nggallery_start_upgrade() - Proceed the upgrade routine
 * 
 * @param mixed $filepath
 * @return void
 */
function nggallery_start_upgrade($filepath) {
?>
<div class="wrap">
	<h2><?php _e('Upgrade NextGEN Gallery', 'nggallery') ;?></h2>
	<p><?php ngg_upgrade();?></p>
	<p><?php _e('Upgrade sucessful', 'nggallery') ;?></p>
	<h3><a href="<?php echo $filepath;?>"><?php _e('Continue', 'nggallery'); ?>...</a></h3>
</div>
<?php
} 
?>
