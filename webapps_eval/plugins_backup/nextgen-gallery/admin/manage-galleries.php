<?php  

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 	die('You are not allowed to call this page directly.'); }

// *** show main gallery list
function nggallery_manage_gallery_main() {

	global $ngg, $nggdb, $wp_query;
	
	//Build the pagination for more than 25 galleries
	if ( ! isset( $_GET['paged'] ) || $_GET['paged'] < 1 )
		$_GET['paged'] = 1;
	
	$start = ( $_GET['paged'] - 1 ) * 25;
	$gallerylist = $nggdb->find_all_galleries('gid', 'asc', TRUE, 25, $start, false);

	$page_links = paginate_links( array(
		'base' => add_query_arg( 'paged', '%#%' ),
		'format' => '',
		'prev_text' => __('&laquo;'),
		'next_text' => __('&raquo;'),
		'total' => $nggdb->paged['max_objects_per_page'],
		'current' => $_GET['paged']
	));

	?>
	<script type="text/javascript"> 
	<!--
	function checkAll(form)
	{
		for (i = 0, n = form.elements.length; i < n; i++) {
			if(form.elements[i].type == "checkbox") {
				if(form.elements[i].name == "doaction[]") {
					if(form.elements[i].checked == true)
						form.elements[i].checked = false;
					else
						form.elements[i].checked = true;
				}
			}
		}
	}
	
	function getNumChecked(form)
	{
		var num = 0;
		for (i = 0, n = form.elements.length; i < n; i++) {
			if(form.elements[i].type == "checkbox") {
				if(form.elements[i].name == "doaction[]")
					if(form.elements[i].checked == true)
						num++;
			}
		}
		return num;
	}

	// this function check for a the number of selected images, sumbmit false when no one selected
	function checkSelected() {
	
		var numchecked = getNumChecked(document.getElementById('editgalleries'));
		 
		if(numchecked < 1) { 
			alert('<?php echo esc_js(__('No images selected', 'nggallery')); ?>');
			return false; 
		} 
		
		actionId = jQuery('#bulkaction').val();
		
		switch (actionId) {
			case "resize_images":
				showDialog('resize_images', 120);
				return false;
				break;
			case "new_thumbnail":
				showDialog('new_thumbnail', 160);
				return false;
				break;
		}
		
		return confirm('<?php echo sprintf(esc_js(__("You are about to start the bulk edit for %s galleries \n \n 'Cancel' to stop, 'OK' to proceed.",'nggallery')), "' + numchecked + '") ; ?>');
	}

	function showDialog( windowId, height ) {
		var form = document.getElementById('editgalleries');
		var elementlist = "";
		for (i = 0, n = form.elements.length; i < n; i++) {
			if(form.elements[i].type == "checkbox") {
				if(form.elements[i].name == "doaction[]")
					if(form.elements[i].checked == true)
						if (elementlist == "")
							elementlist = form.elements[i].value
						else
							elementlist += "," + form.elements[i].value ;
			}
		}
		jQuery("#" + windowId + "_bulkaction").val(jQuery("#bulkaction").val());
		jQuery("#" + windowId + "_imagelist").val(elementlist);
		// console.log (jQuery("#TB_imagelist").val());
		tb_show("", "#TB_inline?width=640&height=" + height + "&inlineId=" + windowId + "&modal=true", false);
	}
	
	function showAddGallery() {
		tb_show("", "#TB_inline?width=640&height=140&inlineId=addGallery&modal=true", false);
	}
	//-->
	</script>
	<div class="wrap">
		<h2><?php _e('Gallery Overview', 'nggallery'); ?></h2>
		<form class="search-form" action="" method="get">
		<p class="search-box">
			<label class="hidden" for="media-search-input"><?php _e( 'Search Images', 'nggallery' ); ?>:</label>
			<input type="hidden" id="page-name" name="page" value="nggallery-manage-gallery" />
			<input type="text" id="media-search-input" name="s" value="<?php the_search_query(); ?>" />
			<input type="submit" value="<?php _e( 'Search Images', 'nggallery' ); ?>" class="button" />
		</p>
		</form>
		<form id="editgalleries" class="nggform" method="POST" action="<?php echo $ngg->manage_page->base_page . '&amp;paged=' . $_GET['paged']; ?>" accept-charset="utf-8">
		<?php wp_nonce_field('ngg_bulkgallery') ?>
		<input type="hidden" name="page" value="manage-galleries" />
		
		<div class="tablenav">
			
			<div class="alignleft actions">
				<?php if ( function_exists('json_encode') ) : ?>
				<select name="bulkaction" id="bulkaction">
					<option value="no_action" ><?php _e("No action",'nggallery'); ?></option>
					<option value="set_watermark" ><?php _e("Set watermark",'nggallery'); ?></option>
					<option value="new_thumbnail" ><?php _e("Create new thumbnails",'nggallery'); ?></option>
					<option value="resize_images" ><?php _e("Resize images",'nggallery'); ?></option>
					<option value="import_meta" ><?php _e("Import metadata",'nggallery'); ?></option>
					<option value="recover_images" ><?php _e("Recover from backup",'nggallery'); ?></option>
				</select>
				<input name="showThickbox" class="button-secondary" type="submit" value="<?php _e('Apply','nggallery'); ?>" onclick="if ( !checkSelected() ) return false;" />
				<?php endif; ?>
				<?php if ( current_user_can('NextGEN Upload images') && nggGallery::current_user_can( 'NextGEN Add new gallery' ) ) : ?>
					<input name="doaction" class="button-secondary action" type="submit" onclick="showAddGallery(); return false;" value="<?php _e('Add new gallery', 'nggallery') ?>"/>
				<?php endif; ?>
			</div>
			
		<?php if ( $page_links ) : ?>
			<div class="tablenav-pages"><?php $page_links_text = sprintf( '<span class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s' ) . '</span>%s',
				number_format_i18n( ( $_GET['paged'] - 1 ) * $nggdb->paged['objects_per_page'] + 1 ),
				number_format_i18n( min( $_GET['paged'] * $nggdb->paged['objects_per_page'], $nggdb->paged['total_objects'] ) ),
				number_format_i18n( $nggdb->paged['total_objects'] ),
				$page_links
			); echo $page_links_text; ?></div>
		<?php endif; ?>
		
		</div>
		<table class="widefat" cellspacing="0">
			<thead>
			<tr>
				<th scope="col" class="column-cb" >
					<input type="checkbox" onclick="checkAll(document.getElementById('editgalleries'));" name="checkall"/>
				</th>
				<th scope="col" ><?php _e('ID'); ?></th>
				<th scope="col" ><?php _e('Title', 'nggallery'); ?></th>
				<th scope="col" ><?php _e('Description', 'nggallery'); ?></th>
				<th scope="col" ><?php _e('Author', 'nggallery'); ?></th>
				<th scope="col" ><?php _e('Page ID', 'nggallery'); ?></th>
				<th scope="col" ><?php _e('Quantity', 'nggallery'); ?></th>
				<th scope="col" ><?php _e('Action'); ?></th>
			</tr>
			</thead>
			<tbody>
<?php

if($gallerylist) {
	foreach($gallerylist as $gallery) {
		$class = ( !isset($class) || $class == 'class="alternate"' ) ? '' : 'class="alternate"';
		$gid = $gallery->gid;
		$name = (empty($gallery->title) ) ? $gallery->name : $gallery->title;
		$author_user = get_userdata( (int) $gallery->author );
		?>
		<tr id="gallery-<?php echo $gid ?>" <?php echo $class; ?> >
			<th scope="row" class="cb column-cb">
				<?php if (nggAdmin::can_manage_this_gallery($gallery->author)) { ?>
					<input name="doaction[]" type="checkbox" value="<?php echo $gid ?>" />
				<?php } ?>
			</th>
			<td scope="row"><?php echo $gid; ?></td>
			<td>
				<?php if (nggAdmin::can_manage_this_gallery($gallery->author)) { ?>
					<a href="<?php echo wp_nonce_url( $ngg->manage_page->base_page . '&amp;mode=edit&amp;gid=' . $gid, 'ngg_editgallery')?>" class='edit' title="<?php _e('Edit'); ?>" >
						<?php echo nggGallery::i18n($name); ?>
					</a>
				<?php } else { ?>
					<?php echo nggGallery::i18n($gallery->title); ?>
				<?php } ?>
			</td>
			<td><?php echo nggGallery::i18n($gallery->galdesc); ?>&nbsp;</td>
			<td><?php echo $author_user->display_name; ?></td>
			<td><?php echo $gallery->pageid; ?></td>
			<td><?php echo $gallery->counter; ?></td>
			<td>
				<?php if (nggAdmin::can_manage_this_gallery($gallery->author)) : ?>
					<a href="<?php echo wp_nonce_url( $ngg->manage_page->base_page . '&amp;mode=delete&amp;gid=' . $gid, 'ngg_editgallery')?>" class="delete" onclick="javascript:check=confirm( '<?php _e('Delete this gallery ?', 'nggallery'); ?>');if(check==false) return false;"><?php _e('Delete'); ?></a>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}
} else {
	echo '<tr><td colspan="7" align="center"><strong>' . __('No entries found', 'nggallery') . '</strong></td></tr>';
}
?>			
			</tbody>
		</table>
		</form>
	</div>
	<!-- #addGallery -->
	<div id="addGallery" style="display: none;" >
		<form id="form-tags" method="POST" accept-charset="utf-8">
		<?php wp_nonce_field('ngg_addgallery'); ?>
		<input type="hidden" name="page" value="manage-galleries" />
		<table width="100%" border="0" cellspacing="3" cellpadding="3" >
		  	<tr>
		    	<td>
					<strong><?php _e('New Gallery', 'nggallery') ;?>:</strong> <input type="text" size="35" name="galleryname" value="" /><br />
					<?php if(!IS_WPMU) { ?>
					<?php _e('Create a new , empty gallery below the folder', 'nggallery') ;?>  <strong><?php echo $ngg->options['gallerypath']; ?></strong><br />
					<?php } ?>
					<i>( <?php _e('Allowed characters for file and folder names are', 'nggallery') ;?>: a-z, A-Z, 0-9, -, _ )</i>
				</td>
		  	</tr>
		  	<tr align="right">
		    	<td class="submit">
		    		<input class="button-primary" type="submit" name="addgallery" value="<?php _e('OK','nggallery'); ?>" />
		    		&nbsp;
		    		<input class="button-secondary" type="reset" value="&nbsp;<?php _e('Cancel', 'nggallery'); ?>&nbsp;" onclick="tb_remove()"/>
		    	</td>
			</tr>
		</table>
		</form>
	</div>
	<!-- /#addGallery -->

	<!-- #resize_images -->
	<div id="resize_images" style="display: none;" >
		<form id="form-resize-images" method="POST" accept-charset="utf-8">
		<?php wp_nonce_field('ngg_thickbox_form') ?>
		<input type="hidden" id="resize_images_imagelist" name="TB_imagelist" value="" />
		<input type="hidden" id="resize_images_bulkaction" name="TB_bulkaction" value="" />
		<input type="hidden" name="page" value="manage-galleries" />
		<table width="100%" border="0" cellspacing="3" cellpadding="3" >
			<tr valign="top">
				<td>
					<strong><?php _e('Resize Images to', 'nggallery'); ?>:</strong> 
				</td>
				<td>
					<input type="text" size="5" name="imgWidth" value="<?php echo $ngg->options['imgWidth']; ?>" /> x <input type="text" size="5" name="imgHeight" value="<?php echo $ngg->options['imgHeight']; ?>" />
					<br /><small><?php _e('Width x height (in pixel). NextGEN Gallery will keep ratio size','nggallery') ?></small>
				</td>
			</tr>
		  	<tr align="right">
		    	<td colspan="2" class="submit">
		    		<input class="button-primary" type="submit" name="TB_ResizeImages" value="<?php _e('OK', 'nggallery'); ?>" />
		    		&nbsp;
		    		<input class="button-secondary" type="reset" value="&nbsp;<?php _e('Cancel', 'nggallery'); ?>&nbsp;" onclick="tb_remove()"/>
		    	</td>
			</tr>
		</table>
		</form>
	</div>
	<!-- /#resize_images -->

	<!-- #new_thumbnail -->
	<div id="new_thumbnail" style="display: none;" >
		<form id="form-new-thumbnail" method="POST" accept-charset="utf-8">
		<?php wp_nonce_field('ngg_thickbox_form') ?>
		<input type="hidden" id="new_thumbnail_imagelist" name="TB_imagelist" value="" />
		<input type="hidden" id="new_thumbnail_bulkaction" name="TB_bulkaction" value="" />
		<input type="hidden" name="page" value="manage-galleries" />
		<table width="100%" border="0" cellspacing="3" cellpadding="3" >
			<tr valign="top">
				<th align="left"><?php _e('Width x height (in pixel)','nggallery') ?></th>
				<td><input type="text" size="5" maxlength="5" name="thumbwidth" value="<?php echo $ngg->options['thumbwidth']; ?>" /> x <input type="text" size="5" maxlength="5" name="thumbheight" value="<?php echo $ngg->options['thumbheight']; ?>" />
				<br /><small><?php _e('These values are maximum values ','nggallery') ?></small></td>
			</tr>
			<tr valign="top">
				<th align="left"><?php _e('Set fix dimension','nggallery') ?></th>
				<td><input type="checkbox" name="thumbfix" value="1" <?php checked('1', $ngg->options['thumbfix']); ?> />
				<br /><small><?php _e('Ignore the aspect ratio, no portrait thumbnails','nggallery') ?></small></td>
			</tr>
		  	<tr align="right">
		    	<td colspan="2" class="submit">
		    		<input class="button-primary" type="submit" name="TB_NewThumbnail" value="<?php _e('OK', 'nggallery');?>" />
		    		&nbsp;
		    		<input class="button-secondary" type="reset" value="&nbsp;<?php _e('Cancel', 'nggallery'); ?>&nbsp;" onclick="tb_remove()"/>
		    	</td>
			</tr>
		</table>
		</form>
	</div>
	<!-- /#new_thumbnail -->	

<?php
} 
?>