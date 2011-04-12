<?php  
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
	
	// sometimes a error feedback is better than a white screen
	@ini_set('error_reporting', E_ALL ^ E_NOTICE);

class nggAddGallery {

    /**
     * PHP4 compatibility layer for calling the PHP5 constructor.
     * 
     */
    function nggAddGallery() {
        return $this->__construct();        
    }
    
    /**
     * nggOptions::__construct()
     * 
     * @return void
     */
    function __construct() {
        
       	// same as $_SERVER['REQUEST_URI'], but should work under IIS 6.0
	   $this->filepath    = admin_url() . 'admin.php?page=' . $_GET['page'];
        
  		//Look for POST updates
		if ( !empty($_POST) )
			$this->processor();
    }

	/**
	 * Perform the upload and add a new hook for plugins
	 * 
	 * @return void
	 */
	function processor() {
        global $wpdb, $ngg;

    	$defaultpath = $ngg->options['gallerypath'];	
    	
    	if ($_POST['addgallery']){
    		check_admin_referer('ngg_addgallery');
    		
    		if ( !nggGallery::current_user_can( 'NextGEN Add new gallery' ))
    			wp_die(__('Cheatin&#8217; uh?'));
    		
    		$newgallery = esc_attr( $_POST['galleryname']);
    		if ( !empty($newgallery) )
    			nggAdmin::create_gallery($newgallery, $defaultpath);
    	}
    	
    	if ($_POST['zipupload']){
    		check_admin_referer('ngg_addgallery');
    
    		if ( !nggGallery::current_user_can( 'NextGEN Upload a zip' ))
    			wp_die(__('Cheatin&#8217; uh?'));
    
    		if ($_FILES['zipfile']['error'] == 0 || (!empty($_POST['zipurl']))) 
    			nggAdmin::import_zipfile( intval( $_POST['zipgalselect'] ) );
    		else
    			nggGallery::show_error( __('Upload failed!','nggallery') );
    	}
    	
    	if ($_POST['importfolder']){
    		check_admin_referer('ngg_addgallery');
    
    		if ( !nggGallery::current_user_can( 'NextGEN Import image folder' ))
    			wp_die(__('Cheatin&#8217; uh?'));
    
    		$galleryfolder = $_POST['galleryfolder'];
    		if ( ( !empty($galleryfolder) ) AND ($defaultpath != $galleryfolder) )
    			nggAdmin::import_gallery($galleryfolder);
    	}
    	
    	if ($_POST['uploadimage']){
    		check_admin_referer('ngg_addgallery');
    		
    		if ( !nggGallery::current_user_can( 'NextGEN Upload in all galleries' ))
    			wp_die(__('Cheatin&#8217; uh?'));		
    		
    		if ( $_FILES['imagefiles']['error'][0] == 0 )
    			$messagetext = nggAdmin::upload_images();
    		else
    			nggGallery::show_error( __('Upload failed! ' . nggAdmin::decode_upload_error( $_FILES['imagefiles']['error'][0]),'nggallery') );	
    	}
    	
    	if (isset($_POST['swf_callback'])){
    		if ($_POST['galleryselect'] == '0' )
    			nggGallery::show_error(__('No gallery selected !','nggallery'));
    		else {
    			// get the path to the gallery
    			$galleryID = (int) $_POST['galleryselect'];
    			$gallerypath = $wpdb->get_var("SELECT path FROM $wpdb->nggallery WHERE gid = '$galleryID' ");
    			nggAdmin::import_gallery($gallerypath);
    		}	
    	}
    
    	if ( isset($_POST['disable_flash']) ){
    		check_admin_referer('ngg_addgallery');
    		$ngg->options['swfUpload'] = false;	
    		update_option('ngg_options', $ngg->options);
    	}
    
    	if ( isset($_POST['enable_flash']) ){
    		check_admin_referer('ngg_addgallery');
    		$ngg->options['swfUpload'] = true;	
    		update_option('ngg_options', $ngg->options);
    	}

        do_action( 'ngg_update_addgallery_page' );
        
    }

    /**
     * Render the page content
     * 
     * @return void
     */
    function controller() {
        global $ngg, $nggdb;

        // get list of tabs
        $tabs = $this->tabs_order();
        
    	// check for the max image size
    	$this->maxsize    = nggGallery::check_memory_limit();

    	//get all galleries (after we added new ones)
    	$this->gallerylist = $nggdb->find_all_galleries('gid', 'DESC');
        
        $this->defaultpath = $ngg->options['gallerypath'];
    	
        // link for the flash file
    	$swf_upload_link = NGGALLERY_URLPATH . 'admin/upload.php';
    	$swf_upload_link = wp_nonce_url($swf_upload_link, 'ngg_swfupload');
    	//flash doesn't seem to like encoded ampersands, so convert them back here
    	$swf_upload_link = str_replace('&#038;', '&', $swf_upload_link);
	?>
	
	<?php if($ngg->options['swfUpload']) { ?>
	<!-- SWFUpload script -->
	<script type="text/javascript">
		var ngg_swf_upload;
			
		window.onload = function () {
			ngg_swf_upload = new SWFUpload({
				// Backend settings
				upload_url : "<?php echo $swf_upload_link; ?>",
				flash_url : "<?php echo NGGALLERY_URLPATH; ?>admin/js/swfupload.swf",
				
				// Button Settings
				button_placeholder_id : "spanButtonPlaceholder",
				button_width: 300,
				button_height: 27,
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,
								
				// File Upload Settings
				file_size_limit : "<?php echo wp_max_upload_size(); ?>b",
				file_types : "*.jpg;*.jpeg;*.gif;*.png",
				file_types_description : "<?php _e('Image Files', 'nggallery') ;?>",
				
				// Queue handler
				file_queued_handler : fileQueued,
				
				// Upload handler
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				
				post_params : {
					"auth_cookie" : "<?php echo $_COOKIE[AUTH_COOKIE]; ?>",
					"galleryselect" : "0"
				},
				
				// i18names
				custom_settings : {
					"remove" : "<?php _e('remove', 'nggallery') ;?>",
					"browse" : "<?php _e('Browse...', 'nggallery') ;?>",
					"upload" : "<?php _e('Upload images', 'nggallery') ;?>"
				},

				// Debug settings
				debug: false
				
			});
			
			// on load change the upload to swfupload
			initSWFUpload();
			
		};
	</script>
	
	<div class="wrap" id="progressbar-wrap">
		<div class="progressborder">
			<div class="progressbar" id="progressbar">
				<span>0%</span>
			</div>
		</div>
	</div>
	
	<?php } else { ?>
	<!-- MultiFile script -->
	<script type="text/javascript">	
	/* <![CDATA[ */
		jQuery(document).ready(function(){
			jQuery('#imagefiles').MultiFile({
				STRING: {
			    	remove:'[<?php _e('remove', 'nggallery') ;?>]'
  				}
		 	});
		});
	/* ]]> */
	</script>
	<?php } ?>
	<!-- jQuery Tabs script -->
	<script type="text/javascript">
	/* <![CDATA[ */
		jQuery(document).ready(function(){
			jQuery('#slider').tabs({ fxFade: true, fxSpeed: 'fast' });	
		});
	/* ]]> */
	</script>

	<div id="slider" class="wrap">
        <ul id="tabs">
            <?php    
        	foreach($tabs as $tab_key => $tab_name) {
        	   echo "\n\t\t<li><a href='#$tab_key'>$tab_name</a></li>";
            } 
            ?>
		</ul>
        <?php    
        foreach($tabs as $tab_key => $tab_name) {
            echo "\n\t<div id='$tab_key'>\n";
            // Looks for the internal class function, otherwise enable a hook for plugins
            if ( method_exists( $this, "tab_$tab_key" ))
                call_user_func( array( &$this , "tab_$tab_key") );
            else
                do_action( 'ngg_tab_content_' . $tab_key );
             echo "\n\t</div>";
        } 
        ?>
    </div>
    <?php
        
    }

    /**
     * Create array for tabs and add a filter for other plugins to inject more tabs
     * 
     * @return array $tabs
     */
    function tabs_order() {
     
    	$tabs = array();
    	
        if ( nggGallery::current_user_can( 'NextGEN Add new gallery' ))
    	   $tabs['addgallery'] = __('Add new gallery', 'nggallery');
        
        if ( wpmu_enable_function('wpmuZipUpload') && nggGallery::current_user_can( 'NextGEN Upload a zip' ) ) 
            $tabs['zipupload'] = __('Upload a Zip-File', 'nggallery');
    	
        if (!IS_WPMU && nggGallery::current_user_can( 'NextGEN Import image folder' ) ) 
            $tabs['importfolder'] = __('Import image folder', 'nggallery');
            
    	$tabs['uploadimage'] = __( 'Upload Images', 'nggallery' );
    	
    	$tabs = apply_filters('ngg_addgallery_tabs', $tabs);
    
    	return $tabs;
        
    }
    
    function tab_addgallery() {
    ?>
		<!-- create gallery -->
		<h2><?php _e('Add new gallery', 'nggallery') ;?></h2>
		<form name="addgallery" id="addgallery_form" method="POST" action="<?php echo $this->filepath; ?>" accept-charset="utf-8" >
		<?php wp_nonce_field('ngg_addgallery') ?>
			<table class="form-table"> 
			<tr valign="top"> 
				<th scope="row"><?php _e('New Gallery', 'nggallery') ;?>:</th> 
				<td><input type="text" size="35" name="galleryname" value="" /><br />
				<?php if(!IS_WPMU) { ?>
				<?php _e('Create a new , empty gallery below the folder', 'nggallery') ;?>  <strong><?php echo $this->defaultpath ?></strong><br />
				<?php } ?>
				<i>( <?php _e('Allowed characters for file and folder names are', 'nggallery') ;?>: a-z, A-Z, 0-9, -, _ )</i></td>
			</tr>
			<?php do_action('ngg_add_new_gallery_form'); ?>
			</table>
			<div class="submit"><input class="button-primary" type="submit" name= "addgallery" value="<?php _e('Add gallery', 'nggallery') ;?>"/></div>
		</form>
    <?php
    }

    function tab_zipupload() {
    ?>
		<!-- zip-file operation -->
		<h2><?php _e('Upload a Zip-File', 'nggallery') ;?></h2>
		<form name="zipupload" id="zipupload_form" method="POST" enctype="multipart/form-data" action="<?php echo $this->filepath.'#zipupload'; ?>" accept-charset="utf-8" >
		<?php wp_nonce_field('ngg_addgallery') ?>
			<table class="form-table"> 
			<tr valign="top"> 
				<th scope="row"><?php _e('Select Zip-File', 'nggallery') ;?>:</th> 
				<td><input type="file" name="zipfile" id="zipfile" size="35" class="uploadform"/><br />
				<?php _e('Upload a zip file with images', 'nggallery') ;?></td> 
			</tr>
			<?php if (function_exists('curl_init')) : ?>
			<tr valign="top"> 
				<th scope="row"><?php _e('or enter a Zip-File URL', 'nggallery') ;?>:</th> 
				<td><input type="text" name="zipurl" id="zipurl" size="35" class="uploadform"/><br />
				<?php _e('Import a zip file with images from a url', 'nggallery') ;?></td> 
			</tr>
			<?php endif; ?>
			<tr valign="top"> 
				<th scope="row"><?php _e('in to', 'nggallery') ;?></th> 
				<td><select name="zipgalselect">
				<option value="0" ><?php _e('a new gallery', 'nggallery') ?></option>
				<?php
					foreach($this->gallerylist as $gallery) {
						if ( !nggAdmin::can_manage_this_gallery($gallery->author) )
							continue;
						$name = ( empty($gallery->title) ) ? $gallery->name : $gallery->title;
						echo '<option value="' . $gallery->gid . '" >' . $gallery->gid . ' - ' . $name . '</option>' . "\n";
					}
				?>
				</select>
				<br /><?php echo $this->maxsize; ?>
				<br /><?php echo _e('Note : The upload limit on your server is ','nggallery') . "<strong>" . ini_get('upload_max_filesize') . "Byte</strong>\n"; ?>
				<br /><?php if ( (IS_WPMU) && wpmu_enable_function('wpmuQuotaCheck') ) display_space_usage(); ?></td> 
			</tr> 
			</table>
			<div class="submit"><input class="button-primary" type="submit" name= "zipupload" value="<?php _e('Start upload', 'nggallery') ;?>"/></div>
		</form>
    <?php
    }

    function tab_importfolder() {
    ?>
	<!-- import folder -->
	<h2><?php _e('Import image folder', 'nggallery') ;?></h2>
		<form name="importfolder" id="importfolder_form" method="POST" action="<?php echo $this->filepath.'#importfolder'; ?>" accept-charset="utf-8" >
		<?php wp_nonce_field('ngg_addgallery') ?>
			<table class="form-table"> 
			<tr valign="top"> 
				<th scope="row"><?php _e('Import from Server path:', 'nggallery') ;?></th> 
				<td><input type="text" size="35" name="galleryfolder" value="<?php echo $this->defaultpath; ?>" /><br />
				<br /><?php echo $this->maxsize; ?>
				<?php if (SAFE_MODE) {?><br /><?php _e(' Please note : For safe-mode = ON you need to add the subfolder thumbs manually', 'nggallery') ;?><?php }; ?></td> 
			</tr>
			</table>
			<div class="submit"><input class="button-primary" type="submit" name= "importfolder" value="<?php _e('Import folder', 'nggallery') ;?>"/></div>
		</form>
    <?php
    }

    function tab_uploadimage() {
        global $ngg;
    ?>
    	<!-- upload images -->
    	<h2><?php _e('Upload Images', 'nggallery') ;?></h2>
		<form name="uploadimage" id="uploadimage_form" method="POST" enctype="multipart/form-data" action="<?php echo $this->filepath.'#uploadimage'; ?>" accept-charset="utf-8" >
		<?php wp_nonce_field('ngg_addgallery') ?>
			<table class="form-table"> 
			<tr valign="top"> 
				<th scope="row"><?php _e('Upload image', 'nggallery') ;?></th>
				<td><span id='spanButtonPlaceholder'></span><input type="file" name="imagefiles[]" id="imagefiles" size="35" class="imagefiles"/></td>
			</tr> 
			<tr valign="top"> 
				<th scope="row"><?php _e('in to', 'nggallery') ;?></th> 
				<td><select name="galleryselect" id="galleryselect">
				<option value="0" ><?php _e('Choose gallery', 'nggallery') ?></option>
				<?php
					foreach($this->gallerylist as $gallery) {
						
						//special case : we check if a user has this cap, then we override the second cap check
						if ( !current_user_can( 'NextGEN Upload in all galleries' ) )
							if ( !nggAdmin::can_manage_this_gallery($gallery->author) )
								continue;
						
						$name = ( empty($gallery->title) ) ? $gallery->name : $gallery->title;
						echo '<option value="' . $gallery->gid . '" >' . $gallery->gid . ' - ' . $name . '</option>' . "\n";
					}					?>
				</select>
				<br /><?php echo $this->maxsize; ?>
				<br /><?php if ((IS_WPMU) && wpmu_enable_function('wpmuQuotaCheck')) display_space_usage(); ?></td> 
			</tr> 
			</table>
			<div class="submit">
				<?php if ($ngg->options['swfUpload']) { ?>
				<input type="submit" name="disable_flash" id="disable_flash" title="<?php _e('The batch upload requires Adobe Flash 10, disable it if you have problems','nggallery') ?>" value="<?php _e('Disable flash upload', 'nggallery') ;?>" />
				<?php } else { ?>
				<input type="submit" name="enable_flash" id="enable_flash" title="<?php _e('Upload multiple files at once by ctrl/shift-selecting in dialog','nggallery') ?>" value="<?php _e('Enable flash based upload', 'nggallery') ;?>" />
				<?php } ?>
				<input class="button-primary" type="submit" name="uploadimage" id="uploadimage_btn" value="<?php _e('Upload images', 'nggallery') ;?>" />
			</div>
		</form>
    <?php
    }        
}
?>