<?php  

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {	die('You are not allowed to call this page directly.');}

function nggallery_picturelist() {
// *** show picture list
	global $wpdb, $nggdb, $user_ID, $ngg;
	
	// Look if its a search result
	$is_search = isset ($_GET['s']) ? true : false;
	$counter	= 0;	
	
    if ($is_search) {

		// fetch the imagelist 
		$picturelist = $ngg->manage_page->search_result;
		
		// we didn't set a gallery or a pagination
		$act_gid     = 0;
		$_GET['paged'] = 1;
		$page_links = false;
		
	} else {
	
		// GET variables
		$act_gid    = $ngg->manage_page->gid;
		
		// Load the gallery metadata
		$gallery = $nggdb->find_gallery($act_gid);
	
		if (!$gallery) {
			nggGallery::show_error(__('Gallery not found.', 'nggallery'));
			return;
		}
		
		// Check if you have the correct capability
		if (!nggAdmin::can_manage_this_gallery($gallery->author)) {
			nggGallery::show_error(__('Sorry, you have no access here', 'nggallery'));
			return;
		}	
		
		// look for pagination	
		if ( ! isset( $_GET['paged'] ) || $_GET['paged'] < 1 )
			$_GET['paged'] = 1;
		
		$start = ( $_GET['paged'] - 1 ) * 50;
		
		// get picture values
		$picturelist = $nggdb->get_gallery($act_gid, $ngg->options['galSort'], $ngg->options['galSortDir'], false, 50, $start );
		
		// build pagination
		$page_links = paginate_links( array(
			'base' => add_query_arg( 'paged', '%#%' ),
			'format' => '',
			'prev_text' => __('&laquo;'),
			'next_text' => __('&raquo;'),
			'total' => $nggdb->paged['max_objects_per_page'],
			'current' => $_GET['paged']
		));
		
		// get the current author
		$act_author_user    = get_userdata( (int) $gallery->author );

	}	
		
		// list all galleries
		$gallerylist = $nggdb->find_all_galleries();

		//get the columns
		$gallery_columns = ngg_manage_gallery_columns();
		$hidden_columns  = get_hidden_columns('nggallery-manage-images');
		$num_columns     = count($gallery_columns) - count($hidden_columns);
		
		$attr = (nggGallery::current_user_can( 'NextGEN Edit gallery options' )) ? '' : 'disabled="disabled"';

?>
<!--[if IE]>
	<style type="text/css">
		.custom_thumb {
			display : none;
		}
	</style>
<![endif]-->

<script type="text/javascript"> 
<!--

function showDialog( windowId, height ) {
	var form = document.getElementById('updategallery');
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

	var numchecked = getNumChecked(document.getElementById('updategallery'));
	 
	if(numchecked < 1) { 
		alert('<?php echo esc_js(__('No images selected', 'nggallery')); ?>');
		return false; 
	} 
	
	actionId = jQuery('#bulkaction').val();
	
	switch (actionId) {
		case "copy_to":
		case "move_to":
			showDialog('selectgallery', 120);
			return false;
			break;
		case "add_tags":
		case "delete_tags":
		case "overwrite_tags":
			showDialog('entertags', 120);
			return false;
			break;
		case "resize_images":
			showDialog('resize_images', 120);
			return false;
			break;
		case "new_thumbnail":
			showDialog('new_thumbnail', 160);
			return false;
			break;			
	}
	
	return confirm('<?php echo sprintf(esc_js(__("You are about to start the bulk edit for %s images \n \n 'Cancel' to stop, 'OK' to proceed.",'nggallery')), "' + numchecked + '") ; ?>');
}

jQuery(document).ready( function() {
	// close postboxes that should be closed
	jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
	postboxes.add_postbox_toggles('ngg-manage-gallery');

});

//-->
</script>

<div class="wrap">

<?php if ($is_search) :?>
<h2><?php printf( __('Search results for &#8220;%s&#8221;', 'nggallery'), esc_html( get_search_query() ) ); ?></h2>
<form class="search-form" action="" method="get">
<p class="search-box">
	<label class="hidden" for="media-search-input"><?php _e( 'Search Images', 'nggallery' ); ?>:</label>
	<input type="hidden" id="page-name" name="page" value="nggallery-manage-gallery" />
	<input type="text" id="media-search-input" name="s" value="<?php the_search_query(); ?>" />
	<input type="submit" value="<?php _e( 'Search Images', 'nggallery' ); ?>" class="button" />
</p>
</form>

<br style="clear: both;" />

<form id="updategallery" class="nggform" method="POST" action="<?php echo $ngg->manage_page->base_page . '&amp;mode=edit&amp;s=' . $_GET['s']; ?>" accept-charset="utf-8">
<?php wp_nonce_field('ngg_updategallery') ?>
<input type="hidden" name="page" value="manage-images" />

<?php else :?>
<h2><?php echo _n( 'Gallery', 'Galleries', 1, 'nggallery' ); ?> : <?php echo nggGallery::i18n($gallery->title); ?></h2>

<br style="clear: both;" />

<form id="updategallery" class="nggform" method="POST" action="<?php echo $ngg->manage_page->base_page . '&amp;mode=edit&amp;gid=' . $act_gid . '&amp;paged=' . $_GET['paged']; ?>" accept-charset="utf-8">
<?php wp_nonce_field('ngg_updategallery') ?>
<input type="hidden" name="page" value="manage-images" />

<?php if ( nggGallery::current_user_can( 'NextGEN Edit gallery options' )) : ?>
<div id="poststuff">
	<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
	<div id="gallerydiv" class="postbox <?php echo postbox_classes('gallerydiv', 'ngg-manage-gallery'); ?>" >
		<h3><?php _e('Gallery settings', 'nggallery') ?><small> (<?php _e('Click here for more settings', 'nggallery') ?>)</small></h3>
		<div class="inside">
			<table class="form-table" >
				<tr>
					<th align="left"><?php _e('Title') ?>:</th>
					<th align="left"><input <?php nggGallery::current_user_can_form( 'NextGEN Edit gallery title' ); ?> type="text" size="50" name="title" value="<?php echo $gallery->title; ?>"  /></th>
					<th align="right"><?php _e('Page Link to', 'nggallery') ?>:</th>
					<th align="left">
					<select <?php nggGallery::current_user_can_form( 'NextGEN Edit gallery page id' ); ?>  name="pageid" style="width:95%">
						<option value="0" ><?php _e('Not linked', 'nggallery') ?></option>
						<?php parent_dropdown($gallery->pageid); ?>
					</select>
					</th>
				</tr>
				<tr>
					<th align="left"><?php _e('Description') ?>:</th> 
					<th align="left"><textarea  <?php nggGallery::current_user_can_form( 'NextGEN Edit gallery description' ); ?> name="gallerydesc" cols="30" rows="3" style="width: 95%" ><?php echo $gallery->galdesc; ?></textarea></th>
					<th align="right"><?php _e('Preview image', 'nggallery') ?>:</th>
					<th align="left">
						<select <?php nggGallery::current_user_can_form( 'NextGEN Edit gallery preview pic' ); ?> name="previewpic" style="width:95%" >
							<option value="0" ><?php _e('No Picture', 'nggallery') ?></option>
							<?php
								if(is_array($picturelist)) {
									foreach($picturelist as $picture) {
										$selected = ($picture->pid == $gallery->previewpic) ? 'selected="selected" ' : '';
										echo '<option value="'.$picture->pid.'" '.$selected.'>'.$picture->pid.' - '.$picture->filename.'</option>'."\n";
									}
								}
							?>
						</select>
					</th>
				</tr>
				<tr>
					<th align="left"><?php _e('Path', 'nggallery') ?>:</th> 
					<th align="left"><input <?php if (IS_WPMU) echo 'readonly = "readonly"'; ?> <?php nggGallery::current_user_can_form( 'NextGEN Edit gallery path' ); ?> type="text" size="50" name="path" value="<?php echo $gallery->path; ?>"  /></th>
					<th align="right"><?php _e('Author', 'nggallery'); ?>:</th>
					<th align="left"> 
					<?php
						$editable_ids = $ngg->manage_page->get_editable_user_ids( $user_ID );
						if ( $editable_ids && count( $editable_ids ) > 1 && nggGallery::current_user_can( 'NextGEN Edit gallery author')  )
							wp_dropdown_users( array('include' => $editable_ids, 'name' => 'author', 'selected' => empty( $gallery->author ) ? 0 : $gallery->author ) ); 
						else
							echo $act_author_user->display_name;
					?>
					</th>
				</tr>
				<?php if(current_user_can("publish_pages")) : ?>
				<tr>
					<th align="left">&nbsp;</th>
					<th align="left">&nbsp;</th>				
					<th align="right"><?php _e('Create new page', 'nggallery') ?>:</th>
					<th align="left"> 
					<select name="parent_id" style="width:95%">
						<option value="0"><?php _e ('Main page (No parent)', 'nggallery'); ?></option>
						<?php parent_dropdown (); ?>
					</select>
					<input class="button-secondary action" type="submit" name="addnewpage" value="<?php _e ('Add page', 'nggallery'); ?>" id="group"/>
					</th>
				</tr>
				<?php endif; ?>
			</table>
			
			<div class="submit">
				<input type="submit" class="button-secondary" name="scanfolder" value="<?php _e("Scan Folder for new images",'nggallery'); ?> " />
				<input type="submit" class="button-primary action" name="updatepictures" value="<?php _e("Save Changes",'nggallery'); ?>" />
			</div>

		</div>
	</div>
</div> <!-- poststuff -->
<?php endif; ?>

<?php endif; ?>

<div class="tablenav ngg-tablenav">
	<?php if ( $page_links ) : ?>
	<div class="tablenav-pages"><?php $page_links_text = sprintf( '<span class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s' ) . '</span>%s',
		number_format_i18n( ( $_GET['paged'] - 1 ) * $nggdb->paged['objects_per_page'] + 1 ),
		number_format_i18n( min( $_GET['paged'] * $nggdb->paged['objects_per_page'], $nggdb->paged['total_objects'] ) ),
		number_format_i18n( $nggdb->paged['total_objects'] ),
		$page_links
	); echo $page_links_text; ?></div>
	<?php endif; ?>
	<div class="alignleft actions">
	<select id="bulkaction" name="bulkaction">
		<option value="no_action" ><?php _e("No action",'nggallery'); ?></option>
		<option value="set_watermark" ><?php _e("Set watermark",'nggallery'); ?></option>
		<option value="new_thumbnail" ><?php _e("Create new thumbnails",'nggallery'); ?></option>
		<option value="resize_images" ><?php _e("Resize images",'nggallery'); ?></option>
		<option value="recover_images" ><?php _e("Recover from backup",'nggallery'); ?></option>
		<option value="delete_images" ><?php _e("Delete images",'nggallery'); ?></option>
		<option value="import_meta" ><?php _e("Import metadata",'nggallery'); ?></option>
		<option value="rotate_cw" ><?php _e("Rotate images clockwise",'nggallery'); ?></option>
		<option value="rotate_ccw" ><?php _e("Rotate images counter-clockwise",'nggallery'); ?></option>
		<option value="copy_to" ><?php _e("Copy to...",'nggallery'); ?></option>
		<option value="move_to"><?php _e("Move to...",'nggallery'); ?></option>
		<option value="add_tags" ><?php _e("Add tags",'nggallery'); ?></option>
		<option value="delete_tags" ><?php _e("Delete tags",'nggallery'); ?></option>
		<option value="overwrite_tags" ><?php _e("Overwrite tags",'nggallery'); ?></option>
	</select>
	<input class="button-secondary" type="submit" name="showThickbox" value="<?php _e('Apply', 'nggallery'); ?>" onclick="if ( !checkSelected() ) return false;" />
	
	<?php if (($ngg->options['galSort'] == "sortorder") && (!$is_search) ) { ?>
		<input class="button-secondary" type="submit" name="sortGallery" value="<?php _e('Sort gallery', 'nggallery');?>" />
	<?php } ?>
	
	<input type="submit" name="updatepictures" class="button-primary action"  value="<?php _e('Save Changes', 'nggallery');?>" />
	</div>
</div>

<table id="ngg-listimages" class="widefat fixed" cellspacing="0" >

	<thead>
	<tr>
<?php print_column_headers('nggallery-manage-images'); ?>
	</tr>
	</thead>
	<tfoot>
	<tr>
<?php print_column_headers('nggallery-manage-images', false); ?>
	</tr>
	</tfoot>
	<tbody>
<?php
if($picturelist) {
	
	$thumbsize 	= '';
		
	if ($ngg->options['thumbfix'])
		$thumbsize = 'width="' . $ngg->options['thumbwidth'] . '" height="' . $ngg->options['thumbheight'] . '"';

	foreach($picturelist as $picture) {
		
		//for search result we need to check the capatibiliy
		if ( !nggAdmin::can_manage_this_gallery($picture->author) && $is_search )
			continue;
			
		$counter++;
		$pid       = (int) $picture->pid;
		$alternate = ( !isset($alternate) || $alternate == 'alternate' ) ? '' : 'alternate';	
		$exclude   = ( $picture->exclude ) ? 'checked="checked"' : '';
		$date = mysql2date(get_option('date_format'), $picture->imagedate);
		$time = mysql2date(get_option('time_format'), $picture->imagedate);
				
		?>
		<tr id="picture-<?php echo $pid ?>" class="<?php echo $alternate ?> iedit"  valign="top">
			<?php
			foreach($gallery_columns as $gallery_column_key => $column_display_name) {
				$class = "class=\"$gallery_column_key column-$gallery_column_key\"";
		
				$style = '';
				if ( in_array($gallery_column_key, $hidden_columns) )
					$style = ' style="display:none;"';
		
				$attributes = "$class$style";
				
				switch ($gallery_column_key) {
					case 'cb' :
						?> 
						<th <?php echo $attributes ?> scope="row"><input name="doaction[]" type="checkbox" value="<?php echo $pid ?>" /></th>
						<?php
					break;
					case 'id' :
						?>
						<td <?php echo $attributes ?> scope="row" style=""><?php echo $pid; ?>
							<input type="hidden" name="pid[]" value="<?php echo $pid ?>" />
						</td>
						<?php
					break;
					case 'filename' :
						?>
						<td <?php echo $attributes ?>>
							<strong><a href="<?php echo $picture->imageURL; ?>" class="thickbox" title="<?php echo $picture->filename ?>">
								<?php echo ( empty($picture->alttext) ) ? $picture->filename : stripslashes(nggGallery::i18n($picture->alttext)); ?>
							</a></strong>
							<br /><?php echo $date; ?>
							<?php if ( !empty($picture->meta_data) ): ?>
							<br /><?php echo $picture->meta_data['width']; ?> x <?php echo $picture->meta_data['height']; ?> <?php _e('pixel', 'nggallery'); ?>
							
							<?php endif; ?>
							<p>
							<?php
							$actions = array();
							//TODO:Add a JS edit option
							//$actions['edit']   = '<a class="editinline" href="#">' . __('Edit') . '</a>';
							$actions['view']   = '<a class="thickbox" href="' . $picture->imageURL . '" title="' . esc_attr(sprintf(__('View "%s"'), $picture->filename)) . '">' . __('View', 'nggallery') . '</a>';
							$actions['meta']   = '<a class="thickbox" href="' . NGGALLERY_URLPATH . 'admin/showmeta.php?id=' . $pid . '" title="' . __('Show Meta data','nggallery') . '">' . __('Meta', 'nggallery') . '</a>';
							$actions['custom_thumb']   = '<a class="thickbox" href="' . NGGALLERY_URLPATH . 'admin/edit-thumbnail.php?id=' . $pid . '" title="' . __('Customize thumbnail','nggallery') . '">' . __('Edit thumb', 'nggallery') . '</a>';							
							$actions['rotate']	= '<a class="thickbox" href="' . NGGALLERY_URLPATH . 'admin/rotate.php?id=' . $pid . '" title="' . __('Rotate','nggallery') . '">' . __('Rotate', 'nggallery') . '</a>';
							if ( file_exists( $picture->imagePath . '_backup' ) )	
                                $actions['recover']   = '<a class="confirmrecover" href="' .wp_nonce_url("admin.php?page=nggallery-manage-gallery&amp;mode=recoverpic&amp;gid=" . $act_gid . "&amp;pid=" . $pid, 'ngg_recoverpicture'). '" title="' . __('Recover','nggallery') . '" onclick="javascript:check=confirm( \'' . esc_attr(sprintf(__('Recover "%s" ?' , 'nggallery'), $picture->filename)). '\');if(check==false) return false;">' . __('Recover', 'nggallery') . '</a>';
							$actions['delete'] = '<a class="submitdelete" href="' . wp_nonce_url("admin.php?page=nggallery-manage-gallery&amp;mode=delpic&amp;gid=" . $act_gid . "&amp;pid=" . $pid, 'ngg_delpicture'). '" class="delete column-delete" onclick="javascript:check=confirm( \'' . esc_attr(sprintf(__('Delete "%s" ?' , 'nggallery'), $picture->filename)). '\');if(check==false) return false;">' . __('Delete') . '</a>';
							$action_count = count($actions);
							$i = 0;
							echo '<div class="row-actions">';
							foreach ( $actions as $action => $link ) {
								++$i;
								( $i == $action_count ) ? $sep = '' : $sep = ' | ';
								echo "<span class='$action'>$link$sep</span>";
							}
							echo '</div>';
							?></p>
						</td>
						<?php						
					break;
					case 'thumbnail' :
     					// generate the thumbnail size if the meta data available
     					if (is_array ($size = $picture->meta_data['thumbnail']) )
							$thumbsize = 'width="' . $size['width'] . '" height="' . $size['height'] . '"';
						?>
						<td <?php echo $attributes ?>><a href="<?php echo $picture->imageURL . '?' . mt_rand(); ?>" class="thickbox" title="<?php echo $picture->filename ?>">
								<img class="thumb" src="<?php echo $picture->thumbURL . '?' . mt_rand(); ?>" <?php echo $thumbsize ?> id="thumb<?php echo $pid ?>" />
							</a>
						</td>
						<?php						
					break;
					case 'alt_title_desc' :
						?>
						<td <?php echo $attributes ?>>
							<input name="alttext[<?php echo $pid ?>]" type="text" style="width:95%; margin-bottom: 2px;" value="<?php echo stripslashes($picture->alttext) ?>" /><br/>
							<textarea name="description[<?php echo $pid ?>]" style="width:95%; margin-top: 2px;" rows="2" ><?php echo stripslashes($picture->description) ?></textarea>
						</td>
						<?php						
					break;
					case 'exclude' :
						?>
						<td <?php echo $attributes ?>><input name="exclude[<?php echo $pid ?>]" type="checkbox" value="1" <?php echo $exclude ?> /></td>
						<?php						
					break;
					case 'tags' :
						$picture->tags = wp_get_object_terms($pid, 'ngg_tag', 'fields=names');
						if (is_array ($picture->tags) ) $picture->tags = implode(', ', $picture->tags); 
						?>
						<td <?php echo $attributes ?>><textarea name="tags[<?php echo $pid ?>]" style="width:95%;" rows="2"><?php echo $picture->tags ?></textarea></td>
						<?php						
					break;
					default : 
						?>
						<td <?php echo $attributes ?>><?php do_action('ngg_manage_gallery_custom_column', $gallery_column_key, $pid); ?></td>
						<?php
					break;
				}
			?>
			<?php } ?>
		</tr>
		<?php
	}
}
 
// In the case you have no capaptibility to see the search result
if ( $counter == 0 )
	echo '<tr><td colspan="' . $num_columns . '" align="center"><strong>'.__('No entries found','nggallery').'</strong></td></tr>';

?>
	
		</tbody>
	</table>
	<p class="submit"><input type="submit" class="button-primary action" name="updatepictures" value="<?php _e('Save Changes', 'nggallery'); ?>" /></p>
	</form>	
	<br class="clear"/>
	</div><!-- /#wrap -->

	<!-- #entertags -->
	<div id="entertags" style="display: none;" >
		<form id="form-tags" method="POST" accept-charset="utf-8">
		<?php wp_nonce_field('ngg_thickbox_form') ?>
		<input type="hidden" id="entertags_imagelist" name="TB_imagelist" value="" />
		<input type="hidden" id="entertags_bulkaction" name="TB_bulkaction" value="" />
		<input type="hidden" name="page" value="manage-images" />
		<table width="100%" border="0" cellspacing="3" cellpadding="3" >
		  	<tr>
		    	<th><?php _e("Enter the tags",'nggallery'); ?> : <input name="taglist" type="text" style="width:90%" value="" /></th>
		  	</tr>
		  	<tr align="right">
		    	<td class="submit">
		    		<input class="button-primary" type="submit" name="TB_EditTags" value="<?php _e("OK",'nggallery'); ?>" />
		    		&nbsp;
		    		<input class="button-secondary" type="reset" value="&nbsp;<?php _e("Cancel",'nggallery'); ?>&nbsp;" onclick="tb_remove()"/>
		    	</td>
			</tr>
		</table>
		</form>
	</div>
	<!-- /#entertags -->

	<!-- #selectgallery -->
	<div id="selectgallery" style="display: none;" >
		<form id="form-select-gallery" method="POST" accept-charset="utf-8">
		<?php wp_nonce_field('ngg_thickbox_form') ?>
		<input type="hidden" id="selectgallery_imagelist" name="TB_imagelist" value="" />
		<input type="hidden" id="selectgallery_bulkaction" name="TB_bulkaction" value="" />
		<input type="hidden" name="page" value="manage-images" />
		<table width="100%" border="0" cellspacing="3" cellpadding="3" >
		  	<tr>
		    	<th>
		    		<?php _e('Select the destination gallery:', 'nggallery'); ?>&nbsp;
		    		<select name="dest_gid" style="width:90%" >
		    			<?php 
		    				foreach ($gallerylist as $gallery) { 
		    					if ($gallery->gid != $act_gid) { 
		    			?>
						<option value="<?php echo $gallery->gid; ?>" ><?php echo $gallery->gid; ?> - <?php echo stripslashes($gallery->title); ?></option>
						<?php 
		    					} 
		    				}
		    			?>
		    		</select>
		    	</th>
		  	</tr>
		  	<tr align="right">
		    	<td class="submit">
		    		<input type="submit" class="button-primary" name="TB_SelectGallery" value="<?php _e("OK",'nggallery'); ?>" />
		    		&nbsp;
		    		<input class="button-secondary" type="reset" value="<?php _e("Cancel",'nggallery'); ?>" onclick="tb_remove()"/>
		    	</td>
			</tr>
		</table>
		</form>
	</div>
	<!-- /#selectgallery -->

	<!-- #resize_images -->
	<div id="resize_images" style="display: none;" >
		<form id="form-resize-images" method="POST" accept-charset="utf-8">
		<?php wp_nonce_field('ngg_thickbox_form') ?>
		<input type="hidden" id="resize_images_imagelist" name="TB_imagelist" value="" />
		<input type="hidden" id="resize_images_bulkaction" name="TB_bulkaction" value="" />
		<input type="hidden" name="page" value="manage-images" />
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
		<input type="hidden" name="page" value="manage-images" />
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

	<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){columns.init('nggallery-manage-images');});	
	/* ]]> */
	</script>
	<?php
}

// define the columns to display, the syntax is 'internal name' => 'display name'
function ngg_manage_gallery_columns() {
	
	$gallery_columns = array();
	
	$gallery_columns['cb'] = '<input name="checkall" type="checkbox" onclick="checkAll(document.getElementById(\'updategallery\'));" />';
	$gallery_columns['id'] = __('ID');
	$gallery_columns['thumbnail'] = __('Thumbnail', 'nggallery');
	
	$gallery_columns['filename'] = __('Filename', 'nggallery');
	
	$gallery_columns['alt_title_desc'] = __('Alt &amp; Title Text', 'nggallery') . ' / ' . __('Description', 'nggallery');
	$gallery_columns['tags'] = __('Tags (comma separated list)', 'nggallery');

	$gallery_columns['exclude'] = __('exclude', 'nggallery');
	
	$gallery_columns = apply_filters('ngg_manage_gallery_columns', $gallery_columns);

	return $gallery_columns;
}

?>