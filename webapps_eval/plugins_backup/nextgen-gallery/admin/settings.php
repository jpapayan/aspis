<?php  
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

class nggOptions {

    /**
     * PHP4 compatibility layer for calling the PHP5 constructor.
     * 
     */
    function nggOptions() {
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
	 * Save/Load options and add a new hook for plugins
	 * 
	 * @return void
	 */
	function processor() {

    	global $ngg, $nggRewrite;
    	
    	$old_state = $ngg->options['usePermalinks'];
    
    	if ( isset($_POST['irDetect']) ) {
    		check_admin_referer('ngg_settings');
    		$ngg->options['irURL'] = ngg_search_imagerotator();
    		update_option('ngg_options', $ngg->options);
    	}	
    
    	if ( isset($_POST['updateoption']) ) {	
    		check_admin_referer('ngg_settings');
    		// get the hidden option fields, taken from WP core
    		if ( $_POST['page_options'] )	
    			$options = explode(',', stripslashes($_POST['page_options']));

    		if ($options) {
    			foreach ($options as $option) {
    				$option = trim($option);
    				$value = isset($_POST[$option]) ? trim($_POST[$option]) : false;
    		//		$value = sanitize_option($option, $value); // This does stripslashes on those that need it
    				$ngg->options[$option] = $value;
    			}

        		// the path should always end with a slash	
        		$ngg->options['gallerypath']    = trailingslashit($ngg->options['gallerypath']);
        		$ngg->options['imageMagickDir'] = trailingslashit($ngg->options['imageMagickDir']);
    
        		// the custom sortorder must be ascending
        		$ngg->options['galSortDir'] = ($ngg->options['galSort'] == 'sortorder') ? 'ASC' : $ngg->options['galSortDir'];
    		}
    		// Save options
    		update_option('ngg_options', $ngg->options);
    
    		// Flush Rewrite rules
    		if ( $old_state != $ngg->options['usePermalinks'] )
    			$nggRewrite->flush();
    		
    	 	nggGallery::show_message(__('Update Successfully','nggallery'));
    	}		
    	
    	if ( isset($_POST['clearcache']) ) {
    		
    		$path = WINABSPATH . $ngg->options['gallerypath'] . 'cache/';
    		
    		if (is_dir($path))
    	    	if ($handle = opendir($path)) {
    				while (false !== ($file = readdir($handle))) {
    			    	if ($file != '.' && $file != '..') {
    			          @unlink($path . '/' . $file);
    	          		}
    	        	}
    	      		closedir($handle);
    			}
    
    		nggGallery::show_message(__('Cache cleared','nggallery'));
    	}
        
        do_action( 'ngg_update_options_page' );
        
    }

    /**
     * Render the page content
     * 
     * @return void
     */
    function controller() {

        // get list of tabs
        $tabs = $this->tabs_order();

	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("a.switch-expert").hide();
            /*
            jQuery(".expert").hide();
			jQuery("a.switch-expert").click(function(e) {
				jQuery(".expert").toggle();
				return false;
			});
            */
			jQuery('#slider').tabs({ fxFade: true, fxSpeed: 'fast' });
			jQuery('.picker').ColorPicker({
				onSubmit: function(hsb, hex, rgb, el) {
					jQuery(el).val(hex);
					jQuery(el).ColorPickerHide();
				},
				onBeforeShow: function () {
					jQuery(this).ColorPickerSetColor(this.value);
				}
			})
			.bind('keyup', function(){
				jQuery(this).ColorPickerSetColor(this.value);
			});
		});
	
		function insertcode(value) {
			var effectcode;
			switch (value) {
			  case "none":
			    effectcode = "";
			    jQuery('#tbImage').hide("slow");
			    break;
			  case "thickbox":
			    effectcode = 'class="thickbox" rel="%GALLERY_NAME%"';
			    jQuery('#tbImage').show("slow");
			    break;
			  case "lightbox":
			    effectcode = 'rel="lightbox[%GALLERY_NAME%]"';
			    jQuery('#tbImage').hide("slow");
			    break;
			  case "highslide":
			    effectcode = 'class="highslide" onclick="return hs.expand(this, { slideshowGroup: %GALLERY_NAME% })"';
			    jQuery('#tbImage').hide("slow");
			    break;
			  case "shutter":
			    effectcode = 'class="shutterset_%GALLERY_NAME%"';
			    jQuery('#tbImage').hide("slow");
			    break;
			  default:
			    break;
			}
			jQuery("#thumbCode").val(effectcode);
		};
		
		function setcolor(fileid,color) {
			jQuery(fileid).css("background", color );
		};
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
    	
    	$tabs['generaloptions'] = __('General Options', 'nggallery');
    	$tabs['thumbnails'] = __('Thumbnails', 'nggallery');
    	$tabs['images'] = __('Images', 'nggallery');
    	$tabs['gallery'] = _n( 'Gallery', 'Galleries', 1, 'nggallery' );
    	$tabs['effects'] = __('Effects', 'nggallery');
    	$tabs['watermark'] = __('Watermark', 'nggallery');
    	$tabs['slideshow'] = __('Slideshow', 'nggallery');
    	
    	$tabs = apply_filters('ngg_settings_tabs', $tabs);
    
    	return $tabs;
        
    }

    function tab_generaloptions() {
        global $ngg;    

    ?>
        <!-- General Options -->
		<h2><?php _e('General Options','nggallery'); ?></h2>
		<form name="generaloptions" method="post">
		<?php wp_nonce_field('ngg_settings') ?>
		<input type="hidden" name="page_options" value="gallerypath,deleteImg,useMediaRSS,usePicLens,usePermalinks,graphicLibrary,imageMagickDir,activateTags,appendType,maxImages" />
			<table class="form-table ngg-options">
				<tr valign="top">
					<th align="left"><?php _e('Gallery path','nggallery'); ?></th>
					<td><input <?php if (IS_WPMU) echo 'readonly = "readonly"'; ?> type="text" size="35" name="gallerypath" value="<?php echo $ngg->options['gallerypath']; ?>" />
					<span class="setting-description"><?php _e('This is the default path for all galleries','nggallery') ?></span></td>
				</tr>
				<tr class="expert" valign="top">
					<th align="left"><?php _e('Delete image files','nggallery'); ?></th>
					<td><input <?php if (IS_WPMU) echo 'readonly = "readonly"'; ?> type="checkbox" name="deleteImg" value="1" <?php checked('1', $ngg->options['deleteImg']); ?> />
					<?php _e('Delete files, when removing a gallery in the database','nggallery'); ?></td>
				</tr>
				<tr valign="top">
					<th align="left"><?php _e('Activate permalinks','nggallery') ?></th>
					<td><input type="checkbox" name="usePermalinks" value="1" <?php checked('1', $ngg->options['usePermalinks']); ?> />
					<?php _e('When you activate this option, you need to update your permalink structure one time.','nggallery'); ?></td>
				</tr>
				<tr class="expert">
					<th valign="top"><?php _e('Select graphic library','nggallery'); ?>:</th>
					<td><label><input name="graphicLibrary" type="radio" value="gd" <?php checked('gd', $ngg->options['graphicLibrary']); ?> /> <?php _e('GD Library', 'nggallery') ;?></label><br />
					<label><input name="graphicLibrary" type="radio" value="im" <?php checked('im', $ngg->options['graphicLibrary']); ?> /> <?php _e('ImageMagick (Experimental). Path to the library :', 'nggallery') ;?>&nbsp;
					<input <?php if (IS_WPMU) echo 'readonly = "readonly"'; ?> type="text" size="35" name="imageMagickDir" value="<?php echo $ngg->options['imageMagickDir']; ?>" /></label>
					</td>
				</tr>
				<tr>
					<th align="left"><?php _e('Activate Media RSS feed','nggallery'); ?></th>
					<td><input type="checkbox" name="useMediaRSS" value="1" <?php checked('1', $ngg->options['useMediaRSS']); ?> />
					<span class="setting-description"><?php _e('A RSS feed will be added to you blog header. Useful for CoolIris/PicLens','nggallery') ?></span></td>
				</tr>
				<tr>
					<th align="left"><?php _e('Activate PicLens/CoolIris support','nggallery'); ?> (<a href="http://www.cooliris.com">CoolIris</a>)</th>
					<td><input type="checkbox" name="usePicLens" value="1" <?php checked('1', $ngg->options['usePicLens']); ?> />
					<span class="setting-description"><?php _e('When you activate this option, some javascript is added to your site footer. Make sure that wp_footer is called in your theme.','nggallery') ?></span></td>
				</tr>
			</table>
			<h3 class="expert"><?php _e('Tags / Categories','nggallery'); ?></h3>
			<table class="expert form-table ngg-options">
				<tr>
					<th valign="top"><?php _e('Activate related images','nggallery'); ?>:</th>
					<td><input name="activateTags" type="checkbox" value="1" <?php checked('1', $ngg->options['activateTags']); ?> />
					<?php _e('This option will append related images to every post','nggallery'); ?>
					</td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Match with','nggallery') ?>:</th>
					<td><label><input name="appendType" type="radio" value="category" <?php checked('category', $ngg->options['appendType']); ?> /> <?php _e('Categories', 'nggallery') ;?></label><br />
					<label><input name="appendType" type="radio" value="tags" <?php checked('tags', $ngg->options['appendType']); ?> /> <?php _e('Tags', 'nggallery') ;?></label>
					</td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Max. number of images','nggallery') ?>:</th>
					<td><input type="text" name="maxImages" value="<?php echo $ngg->options['maxImages']; ?>" size="3" maxlength="3" />
					<span class="setting-description"><?php _e('0 will show all images','nggallery'); ?></span>
					</td>
				</tr>
			</table> 				
		<div class="alignright"><a href="" class="switch-expert" >[<?php _e('More settings','nggallery'); ?>]</a></div>
		<div class="submit"><input class="button-primary" type="submit" name="updateoption" value="<?php _e('Save Changes'); ?>"/></div>
		</form>	
    <?php        
    }

    function tab_thumbnails() {
        global $ngg;
    ?>
	<!-- Thumbnail settings -->
		<h2><?php _e('Thumbnail settings','nggallery'); ?></h2>
		<form name="thumbnailsettings" method="POST" action="<?php echo $this->filepath.'#thumbnails'; ?>" >
		<?php wp_nonce_field('ngg_settings') ?>
		<input type="hidden" name="page_options" value="thumbwidth,thumbheight,thumbfix,thumbquality" />
			<p><?php _e('Please note : If you change the settings, you need to recreate the thumbnails under -> Manage Gallery .', 'nggallery') ?></p>
			<table class="form-table ngg-options">
				<tr valign="top">
					<th align="left"><?php _e('Width x height (in pixel)','nggallery'); ?></th>
					<td><input type="text" size="4" maxlength="4" name="thumbwidth" value="<?php echo $ngg->options['thumbwidth']; ?>" /> x <input type="text" size="4" maxlength="4" name="thumbheight" value="<?php echo $ngg->options['thumbheight']; ?>" />
					<span class="setting-description"><?php _e('These values are maximum values ','nggallery'); ?></span></td>
				</tr>
				<tr valign="top">
					<th align="left"><?php _e('Set fix dimension','nggallery'); ?></th>
					<td><input type="checkbox" name="thumbfix" value="1" <?php checked('1', $ngg->options['thumbfix']); ?> />
					<?php _e('Ignore the aspect ratio, no portrait thumbnails','nggallery') ?></td>
				</tr>
				<tr class="expert" valign="top">
					<th align="left"><?php _e('Thumbnail quality','nggallery'); ?></th>
					<td><input type="text" size="3" maxlength="3" name="thumbquality" value="<?php echo $ngg->options['thumbquality']; ?>" /> %</td>
				</tr>
			</table>
		<div class="alignright"><a href="" class="switch-expert" >[<?php _e('More settings','nggallery'); ?>]</a></div>
		<div class="submit"><input class="button-primary" type="submit" name="updateoption" value="<?php _e('Save Changes') ;?>"/></div>
		</form> 
    <?php        
    }
    
    function tab_images() {
        global $ngg;
    ?>
		<!-- Image settings -->
		<h2><?php _e('Image settings','nggallery'); ?></h2>
		<form name="imagesettings" method="POST" action="<?php echo $this->filepath.'#images'; ?>" >
		<?php wp_nonce_field('ngg_settings') ?>
		<input type="hidden" name="page_options" value="imgResize,imgWidth,imgHeight,imgQuality,imgBackup,imgAutoResize,imgCacheSinglePic" />
			<table class="form-table ngg-options">
				<tr valign="top">
					<th scope="row"><label for="fixratio"><?php _e('Resize Images','nggallery') ?></label></th>
					<td></td>
					<td><input type="text" size="5" name="imgWidth" value="<?php echo $ngg->options['imgWidth']; ?>" /> x <input type="text" size="5" name="imgHeight" value="<?php echo $ngg->options['imgHeight']; ?>" />
					<span class="setting-description"><?php _e('Width x height (in pixel). NextGEN Gallery will keep ratio size','nggallery') ?></span></td>
				</tr>
				<tr valign="top">
					<th align="left"><?php _e('Image quality','nggallery'); ?></th>
					<td></td>
					<td><input type="text" size="3" maxlength="3" name="imgQuality" value="<?php echo $ngg->options['imgQuality']; ?>" /> %</td>
				</tr>
				<tr>
					<th colspan="1"><?php _e('Backup original images','nggallery'); ?></th>
					<td></td>
					<td colspan="3"><input type="checkbox" name="imgBackup" value="1"<?php echo ($ngg->options['imgBackup'] == 1) ? ' checked ="chechked"' : ''; ?>/>	
					<span class="setting-description"><?php _e('Creates a backup for inserted images','nggallery'); ?></span></td>
				</tr>
				<tr>
					<th colspan="1"><?php _e('Automatically resize','nggallery'); ?></th>
					<td></td>
					<td colspan="3"><input type="checkbox" name="imgAutoResize" value="1"<?php echo ($ngg->options['imgAutoResize'] == 1) ? ' checked ="chechked"' : ''; ?>/>	
					<span class="setting-description"><?php _e('Automatically resize images on upload.','nggallery') ?></span></td>
				</tr>
			</table>
			<h3 class="expert"><?php _e('Single picture','nggallery') ?></h3>
			<table class="expert form-table ngg-options">
				<tr valign="top">
					<th align="left"><?php _e('Cache single pictures','nggallery'); ?></th>
					<td></td>
					<td><input <?php if (IS_WPMU) echo 'readonly = "readonly"'; ?> type="checkbox" name="imgCacheSinglePic" value="1" <?php checked('1', $ngg->options['imgCacheSinglePic']); ?> />
					<span class="setting-description"><?php _e('Creates a file for each singlepic settings. Reduce the CPU load','nggallery') ?></span></td>
				</tr>
				<tr valign="top">
					<th align="left"><?php _e('Clear cache folder','nggallery'); ?></th>
					<td></td>
					<td><input type="submit" name="clearcache" class="button-secondary"  value="<?php _e('Proceed now','nggallery') ;?> &raquo;"/></td>
				</tr>
			</table>
		<div class="alignright"><a href="" class="switch-expert" >[<?php _e('More settings','nggallery'); ?>]</a></div>
		<div class="submit"><input class="button-primary" type="submit" name="updateoption" value="<?php _e('Save Changes') ;?>"/></div>
		</form>	
    
    <?php        
    }
    
    function tab_gallery() {
        global $ngg;
    ?>
		<!-- Gallery settings -->
		<h2><?php _e('Gallery settings','nggallery'); ?></h2>
		<form name="galleryform" method="POST" action="<?php echo $this->filepath.'#gallery'; ?>" >
		<?php wp_nonce_field('ngg_settings') ?>
		<input type="hidden" name="page_options" value="galNoPages,galImages,galColumns,galShowSlide,galTextSlide,galTextGallery,galShowOrder,galImgBrowser,galSort,galSortDir,galHiddenImg,galAjaxNav" />
			<table class="form-table ngg-options">
				<tr class="expert" >
					<th valign="top"><?php _e('Deactivate gallery page link','nggallery') ?>:</th>
					<td><input name="galNoPages" type="checkbox" value="1" <?php checked('1', $ngg->options['galNoPages']); ?> />
					<?php _e('The album will not link to a gallery subpage. The gallery is shown on the same page.','nggallery') ?>
					</td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Number of images per page','nggallery') ?>:</th>
					<td><input type="text" name="galImages" value="<?php echo $ngg->options['galImages']; ?>" size="3" maxlength="3" />
					<span class="setting-description"><?php _e('0 will disable pagination, all images on one page','nggallery') ?></span>
					</td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Number of columns','nggallery') ?>:</th>
					<td><input type="text" name="galColumns" value="<?php echo $ngg->options['galColumns']; ?>" size="3" maxlength="3" />
					<span class="setting-description"><?php _e('0 will display as much as possible based on the width of your theme. Setting normally only required for captions below the images','nggallery') ?></span>
					</td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Integrate slideshow','nggallery') ?>:</th>
					<td><input name="galShowSlide" type="checkbox" value="1" <?php checked('1', $ngg->options['galShowSlide']); ?> />
						<input type="text" name="galTextSlide" value="<?php echo $ngg->options['galTextSlide'] ?>" size="20" />
						<input type="text" name="galTextGallery" value="<?php echo $ngg->options['galTextGallery'] ?>" size="20" />
					</td>
				</tr>
				<tr class="expert" >
					<th valign="top"><?php _e('Show first','nggallery') ?>:</th>
					<td><label><input name="galShowOrder" type="radio" value="gallery" <?php checked('gallery', $ngg->options['galShowOrder']); ?> /> <?php _e('Thumbnails', 'nggallery') ;?></label><br />
					<label><input name="galShowOrder" type="radio" value="slide" <?php checked('slide', $ngg->options['galShowOrder']); ?> /> <?php _e('Slideshow', 'nggallery') ;?></label>
					</td>
				</tr>
				<tr class="expert" >
					<th valign="top"><?php _e('Show ImageBrowser','nggallery'); ?>:</th>
					<td><input name="galImgBrowser" type="checkbox" value="1" <?php checked('1', $ngg->options['galImgBrowser']); ?> />
					<?php _e('The gallery will open the ImageBrowser instead the effect.', 'nggallery'); ?>
					</td>
				</tr>
				<tr class="expert" >
					<th valign="top"><?php _e('Add hidden images','nggallery'); ?>:</th>
					<td><input name="galHiddenImg" type="checkbox" value="1" <?php checked('1', $ngg->options['galHiddenImg']); ?> />
					<?php _e('If pagination is used, this option will still show all images in the modal window (Thickbox, Lightbox etc.). Note : This increase the page load','nggallery'); ?>
					</td>
				</tr>
				<tr class="expert" >
					<th valign="top"><?php _e('Enable AJAX pagination','nggallery'); ?>:</th>
					<td><input name="galAjaxNav" type="checkbox" value="1" <?php checked('1', $ngg->options['galAjaxNav']); ?> />
					<?php _e('Browse images without reload the page. Note : Work only in combination with Shutter effect','nggallery'); ?>
					</td>
				</tr>
			</table>
			<h3 class="expert" ><?php _e('Sort options','nggallery') ?></h3>
			<table class="expert form-table ngg-options">
				<tr>
					<th valign="top"><?php _e('Sort thumbnails','nggallery') ?>:</th>
					<td>
					<label><input name="galSort" type="radio" value="sortorder" <?php checked('sortorder', $ngg->options['galSort']); ?> /> <?php _e('Custom order', 'nggallery') ;?></label><br />
					<label><input name="galSort" type="radio" value="pid" <?php checked('pid', $ngg->options['galSort']); ?> /> <?php _e('Image ID', 'nggallery') ;?></label><br />
					<label><input name="galSort" type="radio" value="filename" <?php checked('filename', $ngg->options['galSort']); ?> /> <?php _e('File name', 'nggallery') ;?></label><br />
					<label><input name="galSort" type="radio" value="alttext" <?php checked('alttext', $ngg->options['galSort']); ?> /> <?php _e('Alt / Title text', 'nggallery') ;?></label><br />
					<label><input name="galSort" type="radio" value="imagedate" <?php checked('imagedate', $ngg->options['galSort']); ?> /> <?php _e('Date / Time', 'nggallery') ;?></label>
					</td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Sort direction','nggallery') ?>:</th>
					<td><label><input name="galSortDir" type="radio" value="ASC" <?php checked('ASC', $ngg->options['galSortDir']); ?> /> <?php _e('Ascending', 'nggallery') ;?></label><br />
					<label><input name="galSortDir" type="radio" value="DESC" <?php checked('DESC', $ngg->options['galSortDir']); ?> /> <?php _e('Descending', 'nggallery') ;?></label>
					</td>
				</tr>
			</table>
		<div class="alignright"><a href="" class="switch-expert" >[<?php _e('More settings','nggallery'); ?>]</a></div>
		<div class="submit"><input class="button-primary" type="submit" name="updateoption" value="<?php _e('Save Changes') ;?>"/></div>
		</form>    
    <?php        
    }
    
    function tab_effects() {
        global $ngg;
    ?>
		<!-- Effects settings -->
		<h2><?php _e('Effects','nggallery'); ?></h2>
		<form name="effectsform" method="POST" action="<?php echo $this->filepath.'#effects'; ?>" >
		<?php wp_nonce_field('ngg_settings') ?>
		<input type="hidden" name="page_options" value="thumbEffect,thumbCode" />
		<p><?php _e('Here you can select the thumbnail effect, NextGEN Gallery will integrate the required HTML code in the images. Please note that only the Shutter and Thickbox effect will automatic added to your theme.','nggallery'); ?>
		<?php _e('With the placeholder','nggallery'); ?><strong> %GALLERY_NAME% </strong> <?php _e('you can activate a navigation through the images (depend on the effect). Change the code line only , when you use a different thumbnail effect or you know what you do.','nggallery'); ?></p>
			<table class="form-table ngg-options">
				<tr valign="top">
					<th><?php _e('JavaScript Thumbnail effect','nggallery') ?>:</th>
					<td>
					<select size="1" id="thumbEffect" name="thumbEffect" onchange="insertcode(this.value)">
						<option value="none" <?php selected('none', $ngg->options['thumbEffect']); ?> ><?php _e('None', 'nggallery') ;?></option>
						<option value="thickbox" <?php selected('thickbox', $ngg->options['thumbEffect']); ?> ><?php _e('Thickbox', 'nggallery') ;?></option>
						<option value="lightbox" <?php selected('lightbox', $ngg->options['thumbEffect']); ?> ><?php _e('Lightbox', 'nggallery') ;?></option>
						<option value="highslide" <?php selected('highslide', $ngg->options['thumbEffect']); ?> ><?php _e('Highslide', 'nggallery') ;?></option>
						<option value="shutter" <?php selected('shutter', $ngg->options['thumbEffect']); ?> ><?php _e('Shutter', 'nggallery') ;?></option>
						<option value="custom" <?php selected('custom', $ngg->options['thumbEffect']); ?> ><?php _e('Custom', 'nggallery') ;?></option>
					</select>
					</td>
				</tr>
				<tr class="expert" valign="top">
					<th><?php _e('Link Code line','nggallery') ?> :</th>
					<td><textarea id="thumbCode" name="thumbCode" cols="50" rows="5"><?php echo htmlspecialchars(stripslashes($ngg->options['thumbCode'])); ?></textarea></td>
				</tr>
			</table>
		<div class="alignright"><a href="" class="switch-expert" >[<?php _e('More settings','nggallery'); ?>]</a></div>
		<div class="submit"><input class="button-primary" type="submit" name="updateoption" value="<?php _e('Save Changes') ;?>"/></div>
		</form>	
   
    <?php        
    }
    
    function tab_watermark() {

        global $wpdb, $ngg;
    
	   $imageID = $wpdb->get_var("SELECT MIN(pid) FROM $wpdb->nggpictures");
	   $imageID = $wpdb->get_row("SELECT * FROM $wpdb->nggpictures WHERE pid = '$imageID'");	
	   if ($imageID) $imageURL = '<img src="'. get_option ('siteurl') . '/' . 'index.php?callback=image&amp;pid='.$imageID->pid.'&amp;mode=watermark&amp;width=300&amp;height=250" alt="'.$imageID->alttext.'" title="'.$imageID->alttext.'" />';

	?>
	<!-- Watermark settings -->
		<h2><?php _e('Watermark','nggallery'); ?></h2>
		<p><?php _e('Please note : You can only activate the watermark under -> Manage Gallery . This action cannot be undone.', 'nggallery') ?></p>
		<form name="watermarkform" method="POST" action="<?php echo $this->filepath.'#watermark'; ?>" >
		<?php wp_nonce_field('ngg_settings') ?>
		<input type="hidden" name="page_options" value="wmPos,wmXpos,wmYpos,wmType,wmPath,wmFont,wmSize,wmColor,wmText,wmOpaque" />
		<div id="wm-preview">
			<h3><?php _e('Preview','nggallery') ?></h3>
			<p style="text-align:center;"><?php echo $imageURL; ?></p>
			<h3><?php _e('Position','nggallery') ?></h3>
			<div>
			    <table id="wm-position">
				<tr>
					<td valign="top">
						<strong><?php _e('Position','nggallery') ?></strong>
						<table border="1">
							<tr>
								<td><input type="radio" name="wmPos" value="topLeft" <?php checked('topLeft', $ngg->options['wmPos']); ?> /></td>
								<td><input type="radio" name="wmPos" value="topCenter" <?php checked('topCenter', $ngg->options['wmPos']); ?> /></td>
								<td><input type="radio" name="wmPos" value="topRight" <?php checked('topRight', $ngg->options['wmPos']); ?> /></td>
							</tr>
							<tr>
								<td><input type="radio" name="wmPos" value="midLeft" <?php checked('midLeft', $ngg->options['wmPos']); ?> /></td>
								<td><input type="radio" name="wmPos" value="midCenter" <?php checked('midCenter', $ngg->options['wmPos']); ?> /></td>
								<td><input type="radio" name="wmPos" value="midRight" <?php checked('midRight', $ngg->options['wmPos']); ?> /></td>
							</tr>
							<tr>
								<td><input type="radio" name="wmPos" value="botLeft" <?php checked('botLeft', $ngg->options['wmPos']); ?> /></td>
								<td><input type="radio" name="wmPos" value="botCenter" <?php checked('botCenter', $ngg->options['wmPos']); ?> /></td>
								<td><input type="radio" name="wmPos" value="botRight" <?php checked('botRight', $ngg->options['wmPos']); ?> /></td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<strong><?php _e('Offset','nggallery') ?></strong>
						<table border="0">
							<tr>
								<td>x</td>
								<td><input type="text" name="wmXpos" value="<?php echo $ngg->options['wmXpos'] ?>" size="4" /> px</td>
							</tr>
							<tr>
								<td>y</td>
								<td><input type="text" name="wmYpos" value="<?php echo $ngg->options['wmYpos'] ?>" size="4" /> px</td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
		</div> 
			<h3><label><input type="radio" name="wmType" value="image" <?php checked('image', $ngg->options['wmType']); ?> /> <?php _e('Use image as watermark','nggallery') ?></label></h3>
			<table class="wm-table form-table">
				<tr>
					<th><?php _e('URL to file','nggallery') ?> :</th>
					<td><input type="text" size="40" name="wmPath" value="<?php echo $ngg->options['wmPath']; ?>" /><br />
					<?php if(!ini_get('allow_url_fopen')) _e('The accessing of URL files is disabled at your server (allow_url_fopen)','nggallery') ?> </td>
				</tr>
			</table>	
			<h3><label><input type="radio" name="wmType" value="text" <?php checked('text', $ngg->options['wmType']); ?> /> <?php _e('Use text as watermark','nggallery') ?></label></h3>
			<table class="wm-table form-table">	
				<tr>
					<th><?php _e('Font','nggallery') ?>:</th>
					<td><select name="wmFont" size="1">	<?php 
							$fontlist = ngg_get_TTFfont();
							foreach ( $fontlist as $fontfile ) {
								echo "\n".'<option value="'.$fontfile.'" '.ngg_input_selected($fontfile, $ngg->options['wmFont']).' >'.$fontfile.'</option>';
							}
							?>
						</select><br /><span class="setting-description">
						<?php if ( !function_exists('ImageTTFBBox') ) 
								_e('This function will not work, cause you need the FreeType library','nggallery');
							  else 
							  	_e('You can upload more fonts in the folder <strong>nggallery/fonts</strong>','nggallery'); ?>
                        </span>
					</td>
				</tr>
				<tr>
					<th><?php _e('Size','nggallery') ?>:</th>
					<td><input type="text" name="wmSize" value="<?php echo $ngg->options['wmSize']; ?>" size="4" maxlength="2" /> px</td>
				</tr>
				<tr>
					<th><?php _e('Color','nggallery') ?>:</th>
					<td><input class="picker" type="text" size="6" maxlength="6" id="wmColor" name="wmColor" onchange="setcolor('#previewText', this.value)" value="<?php echo $ngg->options['wmColor'] ?>" />
					<input type="text" size="1" readonly="readonly" id="previewText" style="background-color: #<?php echo $ngg->options['wmColor']; ?>" /> <?php _e('(hex w/o #)','nggallery') ?></td>
				</tr>
				<tr>
					<th valign="top"><?php _e('Text','nggallery') ?>:</th>
					<td><textarea name="wmText" cols="40" rows="4"><?php echo $ngg->options['wmText'] ?></textarea></td>
				</tr>
				<tr>
					<th><?php _e('Opaque','nggallery') ?>:</th>
					<td><input type="text" name="wmOpaque" value="<?php echo $ngg->options['wmOpaque'] ?>" size="3" maxlength="3" /> % </td>
				</tr>
			</table>
		<div class="clear"> &nbsp; </div>
		<div class="submit"><input class="button-primary" type="submit" name="updateoption" value="<?php _e('Save Changes') ;?>"/></div>
		</form>	
    <?php        
    }

    function tab_slideshow() {

        global $ngg;
    ?>
    	<!-- Slideshow settings -->
    	<form name="player_options" method="POST" action="<?php echo $this->filepath.'#slideshow'; ?>" >
    	<?php wp_nonce_field('ngg_settings'); ?>
    	<input type="hidden" name="page_options" value="irURL,irWidth,irHeight,irShuffle,irLinkfromdisplay,irShownavigation,irShowicons,irWatermark,irOverstretch,irRotatetime,irTransition,irKenburns,irBackcolor,irFrontcolor,irLightcolor,irScreencolor,irAudio,irXHTMLvalid" />
    	<h2><?php _e('Slideshow','nggallery'); ?></h2>
    	<?php if (empty($ngg->options['irURL'])) { ?>
    		<p>
    			<div id="message" class="error">
    			<p>
    				<?php _e('The path to imagerotator.swf is not defined, the slideshow will not work.','nggallery') ?><br />
    				<?php _e('If you would like to use the JW Image Rotatator, please download the player <a href="http://www.longtailvideo.com/players/jw-image-rotator/" target="_blank" >here</a> and upload it to your Upload folder (Default is wp-content/uploads).','nggallery') ?>
    			</p>
    			</div>
    		</p>
    	<?php }?>
    	<p><?php _e('The settings are used in the JW Image Rotator Version', 'nggallery') ?> 3.17 .
    	   <?php _e('See more information for the Flash Player on the web page', 'nggallery') ?> <a href="http://www.longtailvideo.com/players/jw-image-rotator/" target="_blank" >JW Image Rotator from Jeroen Wijering</a>.
    	</p>
    			<table class="form-table ngg-options">
    				<tr>
    					<th><?php _e('Path to the Imagerotator (URL)','nggallery') ?>:</th>
    					<td>
    						<input type="text" size="50" id="irURL" name="irURL" value="<?php echo $ngg->options['irURL']; ?>" />
    						<input type="submit" name="irDetect" class="button-secondary"  value="<?php _e('Search now','nggallery') ;?> &raquo;"/>
    						<br /><span class="setting-description"><?php _e('Press the button to search automatic for the imagerotator, if you uploaded it to wp-content/uploads or a subfolder','nggallery') ?></span>
    					</td>
    				</tr>					
    				<tr>
    					<th><?php _e('Default size (W x H)','nggallery') ?>:</th>
    					<td><input type="text" size="3" maxlength="4" name="irWidth" value="<?php echo $ngg->options['irWidth']; ?>" /> x
    					<input type="text" size="3" maxlength="4" name="irHeight" value="<?php echo $ngg->options['irHeight']; ?>" /></td>
    				</tr>					
    				<tr>
    					<th><?php _e('Shuffle mode','nggallery') ?>:</th>
    					<td><input name="irShuffle" type="checkbox" value="1" <?php checked('1', $ngg->options['irShuffle']); ?> /></td>
    				</tr>
    				<tr class="expert">
    					<th><?php _e('Show next image on click','nggallery') ?>:</th>
    					<td><input name="irLinkfromdisplay" type="checkbox" value="1" <?php checked('1', $ngg->options['irLinkfromdisplay']); ?> /></td>
    				</tr>					
    				<tr class="expert">
    					<th><?php _e('Show navigation bar','nggallery') ?>:</th>
    					<td><input name="irShownavigation" type="checkbox" value="1" <?php checked('1', $ngg->options['irShownavigation']); ?> /></td>
    				</tr>
    				<tr class="expert">
    					<th><?php _e('Show loading icon','nggallery') ?>:</th>
    					<td><input name="irShowicons" type="checkbox" value="1" <?php checked('1', $ngg->options['irShowicons']); ?> /></td>
    				</tr>
    				<tr class="expert">
    					<th><?php _e('Use watermark logo','nggallery') ?>:</th>
    					<td><input name="irWatermark" type="checkbox" value="1" <?php checked('1', $ngg->options['irWatermark']); ?> />
    					<span class="setting-description"><?php _e('You can change the logo at the watermark settings','nggallery') ?></span></td>
    				</tr>
    				<tr class="expert">
    					<th><?php _e('Stretch image','nggallery') ?>:</th>
    					<td>
    					<select size="1" name="irOverstretch">
    						<option value="true" <?php selected('true', $ngg->options['irOverstretch']); ?> ><?php _e('true', 'nggallery') ;?></option>
    						<option value="false" <?php selected('false', $ngg->options['irOverstretch']); ?> ><?php _e('false', 'nggallery') ;?></option>
    						<option value="fit" <?php selected('fit', $ngg->options['irOverstretch']); ?> ><?php _e('fit', 'nggallery') ;?></option>
    						<option value="none" <?php selected('none', $ngg->options['irOverstretch']); ?> ><?php _e('none', 'nggallery') ;?></option>
    					</select>
    					</td>
    				</tr>
    				<tr>					
    					<th><?php _e('Duration time','nggallery') ?>:</th>
    					<td><input type="text" size="3" maxlength="3" name="irRotatetime" value="<?php echo $ngg->options['irRotatetime'] ?>" /> <?php _e('sec.', 'nggallery') ;?></td>
    				</tr>					
    				<tr>					
    					<th><?php _e('Transition / Fade effect','nggallery') ?>:</th>
    					<td>
    					<select size="1" name="irTransition">
    						<option value="fade" <?php selected('fade', $ngg->options['irTransition']); ?> ><?php _e('fade', 'nggallery') ;?></option>
    						<option value="bgfade" <?php selected('bgfade', $ngg->options['irTransition']); ?> ><?php _e('bgfade', 'nggallery') ;?></option>
    						<option value="slowfade" <?php selected('slowfade', $ngg->options['irTransition']); ?> ><?php _e('slowfade', 'nggallery') ;?></option>
    						<option value="circles" <?php selected('circles', $ngg->options['irTransition']); ?> ><?php _e('circles', 'nggallery') ;?></option>
    						<option value="bubbles" <?php selected('bubbles', $ngg->options['irTransition']); ?> ><?php _e('bubbles', 'nggallery') ;?></option>
    						<option value="blocks" <?php selected('blocks', $ngg->options['irTransition']); ?> ><?php _e('blocks', 'nggallery') ;?></option>
    						<option value="fluids" <?php selected('fluids', $ngg->options['irTransition']); ?> ><?php _e('fluids', 'nggallery') ;?></option>
    						<option value="flash" <?php selected('flash', $ngg->options['irTransition']); ?> ><?php _e('flash', 'nggallery') ;?></option>
    						<option value="lines" <?php selected('lines', $ngg->options['irTransition']); ?> ><?php _e('lines', 'nggallery') ;?></option>
    						<option value="random" <?php selected('random', $ngg->options['irTransition']); ?> ><?php _e('random', 'nggallery') ;?></option>
    					</select>
    				</tr>
    				<tr class="expert">
    					<th><?php _e('Use slow zooming effect','nggallery') ?>:</th>
    					<td><input name="irKenburns" type="checkbox" value="1" <?php checked('1', $ngg->options['irKenburns']); ?> /></td>
    				</tr>
    				<tr>
    					<th><?php _e('Background Color','nggallery') ?>:</th>
    					<td><input class="picker" type="text" size="6" maxlength="6" id="irBackcolor" name="irBackcolor" onchange="setcolor('#previewBack', this.value)" value="<?php echo $ngg->options['irBackcolor'] ?>" />
    					<input type="text" size="1" readonly="readonly" id="previewBack" style="background-color: #<?php echo $ngg->options['irBackcolor'] ?>" /></td>
    				</tr>
    				<tr>					
    					<th><?php _e('Texts / Buttons Color','nggallery') ?>:</th>
    					<td><input class="picker" type="text" size="6" maxlength="6" id="irFrontcolor" name="irFrontcolor" onchange="setcolor('#previewFront', this.value)" value="<?php echo $ngg->options['irFrontcolor'] ?>" />
    					<input type="text" size="1" readonly="readonly" id="previewFront" style="background-color: #<?php echo $ngg->options['irFrontcolor'] ?>" /></td>
    				</tr>
    				<tr class="expert">					
    					<th><?php _e('Rollover / Active Color','nggallery') ?>:</th>
    					<td><input class="picker" type="text" size="6" maxlength="6" id="irLightcolor" name="irLightcolor" onchange="setcolor('#previewLight', this.value)" value="<?php echo $ngg->options['irLightcolor'] ?>" />
    					<input type="text" size="1" readonly="readonly" id="previewLight" style="background-color: #<?php echo $ngg->options['irLightcolor'] ?>" /></td>
    				</tr>
    				<tr class="expert">					
    					<th><?php _e('Screen Color','nggallery') ?>:</th>
    					<td><input class="picker" type="text" size="6" maxlength="6" id="irScreencolor" name="irScreencolor" onchange="setcolor('#previewScreen', this.value)" value="<?php echo $ngg->options['irScreencolor'] ?>" />
    					<input type="text" size="1" readonly="readonly" id="previewScreen" style="background-color: #<?php echo $ngg->options['irScreencolor'] ?>" /></td>
    				</tr>
    				<tr class="expert">					
    					<th><?php _e('Background music (URL)','nggallery') ?>:</th>
    					<td><input type="text" size="50" id="irAudio" name="irAudio" value="<?php echo $ngg->options['irAudio'] ?>" /></td>
    				</tr>
    				<tr class="expert">
    					<th ><?php _e('Try XHTML validation (with CDATA)','nggallery') ?>:</th>
    					<td><input name="irXHTMLvalid" type="checkbox" value="1" <?php checked('1', $ngg->options['irXHTMLvalid']); ?> />
    					<span class="setting-description"><?php _e('Important : Could causes problem at some browser. Please recheck your page.','nggallery') ?></span></td>
    				</tr>
    				</table>
    			<div class="alignright"><a href="" class="switch-expert" >[<?php _e('More settings','nggallery'); ?>]</a></div>
    			<div class="submit"><input class="button-primary" type="submit" name="updateoption" value="<?php _e('Save Changes') ;?>"/></div>
    	</form>
    <?php        
    }
}

function ngg_get_TTFfont() {
	
	$ttf_fonts = array ();
	
	// Files in wp-content/plugins/nggallery/fonts directory
	$plugin_root = NGGALLERY_ABSPATH . 'fonts';
	
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
						if (preg_match('|\.ttf$|', $subfile))
							$ttf_fonts[] = "$file/$subfile";
					}
				}
			} else {
				if (preg_match('|\.ttf$|', $file))
					$ttf_fonts[] = $file;
			}
		}
	}

	return $ttf_fonts;
}

function ngg_search_imagerotator() {
	global $wpdb;

	$upload = wp_upload_dir();

	// look first at the old place and move it to wp-content/uploads
	if ( file_exists( NGGALLERY_ABSPATH . 'imagerotator.swf' ) )
		@rename(NGGALLERY_ABSPATH . 'imagerotator.swf', $upload['basedir'] . '/imagerotator.swf');
		
	// This should be the new place	
	if ( file_exists( $upload['basedir'] . '/imagerotator.swf' ) )
		return $upload['baseurl'] . '/imagerotator.swf';

	// Find the path to the imagerotator via the media library
	if ( $path = $wpdb->get_var( "SELECT guid FROM {$wpdb->posts} WHERE guid LIKE '%imagerotator.swf%'" ) )
		return $path;

	// maybe it's located at wp-content
	if ( file_exists( WP_CONTENT_DIR . '/imagerotator.swf' ) )
		return WP_CONTENT_URL . '/imagerotator.swf';

	// or in the plugin folder
	if ( file_exists( WP_PLUGIN_DIR . '/imagerotator.swf' ) )
		return WP_PLUGIN_URL . '/imagerotator.swf';
		
	// this is deprecated and will be ereased during a automatic upgrade
	if ( file_exists( NGGALLERY_ABSPATH . 'imagerotator.swf' ) )
		return NGGALLERY_URLPATH . 'imagerotator.swf';
		
	return '';
}

/**********************************************************/
// taken from WP Core

function ngg_input_selected( $selected, $current) {
	if ( $selected == $current)
		return ' selected="selected"';
}
	
function ngg_input_checked( $checked, $current) {
	if ( $checked == $current)
		return ' checked="checked"';
}
?>
