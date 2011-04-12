<?php  
/**
* Tag management page. Inspired from the Simple Tags plugin by Amaury Balmer.
* http://code.google.com/p/simple-tags/
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 	die('You are not allowed to call this page directly.'); }

$action_status = array('message' => '', 'status' => 'ok');

if ( isset($_POST['tag_action']) ) {
	//TODO:Include nonce field
	if ( $_POST['tag_action'] == 'renametag' ) {
		$oldtag = (isset($_POST['renametag_old'])) ? $_POST['renametag_old'] : '';
		$newtag = (isset($_POST['renametag_new'])) ? $_POST['renametag_new'] : '';
		$action_status = nggTags::rename_tags( $oldtag, $newtag );
	} elseif ( $_POST['tag_action'] == 'deletetag' ) {
		$todelete = (isset($_POST['deletetag_name'])) ? $_POST['deletetag_name'] : '';
		$action_status = nggTags::delete_tags( $todelete );
	} elseif ( $_POST['tag_action'] == 'editslug' ) {
		$matchtag = (isset($_POST['tagname_match'])) ? $_POST['tagname_match'] : '';
		$newslug   = (isset($_POST['tagslug_new'])) ? $_POST['tagslug_new'] : '';
		$action_status = nggTags::edit_tag_slug( $matchtag, $newslug );
	} 
}

// Som useful variables
$admin_base_url = admin_url() . 'admin.php?page=';
$nb_tags = 50; // Number of tags to show on a single page

// Manage URL
$sort_order = ( isset($_GET['tag_sortorder']) ) ? esc_attr(stripslashes($_GET['tag_sortorder'])) : 'desc';
$search_url = ( isset($_GET['search']) ) ? '&amp;search=' . stripslashes($_GET['search']) : '';
$action_url = $admin_base_url . esc_attr(stripslashes($_GET['page'])) . '&amp;tag_sortorder=' . $sort_order. $search_url;

// Tags Filters
$order_array = array(
	'desc' => __('Most popular', 'nggallery'),
	'asc' => __('Least used', 'nggallery'),
	'natural' => __('Alphabetical', 'nggallery'));

// Build Tags Param
$param = 'hide_empty=false';
switch ($sort_order) {
	case 'natural' :
		$param .= '&number='.$nb_tags.'&orderby=name&order=asc';
		break;
	case 'asc' :
		$param .= '&number='.$nb_tags.'&orderby=count&order=asc';
		break;
	default :
		$param .= '&number='.$nb_tags.'&orderby=count&order=desc';
		break;
}


// Search
if ( !empty($_GET['search']) ) {
	$search = stripslashes($_GET['search']);
	$param .= '&name__like=' . $search;
}

// Offset
if ( !empty($_GET['offset']) ) {
	$param .= '&offset=' . $_GET['offset'];
}

// Navigation urls
if ( empty($_GET['offset']) ) {
	$offset = 0;
} else {
	$offset = $_GET['offset'];
}

$tag_count = (int)wp_count_terms('ngg_tag', 'ignore_empty=true');

if ($offset + $nb_tags < $tag_count) {
	$next_offset = '' . min($offset + $nb_tags, $tag_count - $nb_tags);
} else {
	$next_offset = '';
}

if ($nb_tags < $tag_count && $offset>0) {
	$prev_offset = '' . max($offset - $nb_tags, 0);
} else {
	$prev_offset = '';
}

?>
<style>
	.disabled, .disabled:hover { border-color: #E5E5E5; color: #999999; cursor: default; }
</style>

<div class="wrap ngg_wrap">
	<h2><?php _e('Manage image tags', 'nggallery'); ?></h2>
	
	<?php if ($action_status['message']!='') : ?>
	<div id="message" class="<?php echo ($action_status['status']=='ok' ? 'updated' : $action_status['status']); ?> fade">
		<p><strong><?php echo $action_status['message']; ?></strong></p>
	</div>
	<?php endif; ?>
	
	<table>
		<tr>
			<td class="list_tags">
				<fieldset class="options" id="taglist">
					<h3><?php _e('Existing Tags', 'nggallery'); ?></h3>

					<form method="get">
						<p>
							<label for="search"><?php _e('Search tags', 'nggallery'); ?></label><br />
							<input type="hidden" name="page" value="<?php echo esc_attr(stripslashes($_GET['page'])); ?>" />
							<input type="hidden" name="tag_sortorder" value="<?php echo $sort_order; ?>" />
							<input type="text" name="search" id="search" size="10" value="<?php if (isset($_GET['search'])) echo stripslashes($_GET['search']); ?>" />
							<input class="button" type="submit" value="<?php _e('Go', 'nggallery'); ?>" />
						</p>
					</form>

					<div class="sort_order">
						<h3><?php _e('Sort Order:', 'nggallery'); ?></h3>
						<?php
						$output = array();
						foreach( $order_array as $sort => $title ) {
							$output[] = ($sort == $sort_order) ? '<span style="color: red;">'.$title.'</span>' : '<a href="'.$admin_base_url.esc_attr(stripslashes($_GET['page'])).'&amp;tag_sortorder='.$sort.$search_url.'">'.$title.'</a>';
						}
						echo implode('<br />', $output);
						$output = array();
						unset($output);
						?>
					</div>

					<div id="ajax_area_tagslist">
						<ul>
							<?php
							$tags = (array) nggTags::find_tags($param, true);
							foreach( $tags as $tag ) {
                                //TODO:Tag link should be call a list of images in manage gallery
                                //echo '<li><span>' . $tag->name . '</span>&nbsp;<a href="'.(ngg_get_tag_link( $tag->term_id )).'" title="'.sprintf(__('View all images tagged with %s', 'nggallery'), $tag->name).'">('.$tag->count.')</a></li>'."\n";
                                echo '<li><span>' . $tag->name . '</span>&nbsp;'.'('.$tag->count.')</li>'."\n";

							}
							unset($tags);
							?>
						</ul>

						<?php if ( $prev_offset!='' || $next_offset!='' ) : ?>
						<div class="navigation">

							<?php if ($prev_offset!='') { ?>
							<form method="get" style="display: inline;">
								<span>
									<input type="hidden" name="page" value="<?php echo esc_attr(stripslashes($_GET['page'])); ?>" />
									<input type="hidden" name="tag_sortorder" value="<?php echo $sort_order; ?>" />
									<input type="hidden" name="offset" value="<?php echo $prev_offset; ?>" />
									<input class="button" type="submit" value="&laquo; <?php _e('Previous tags', 'nggallery'); ?>" />
								</span>
							</form>	
							<?php } else { ?> 
								<span><span class="button disabled">&laquo; <?php _e('Previous tags', 'nggallery'); ?></span></span>
							<?php } ?> 

							<?php if ($next_offset!='') { ?>
							<form method="get" style="display: inline;">
								<span>
									<input type="hidden" name="page" value="<?php echo esc_attr(stripslashes($_GET['page'])); ?>" />
									<input type="hidden" name="tag_sortorder" value="<?php echo $sort_order; ?>" />
									<input type="hidden" name="offset" value="<?php echo $next_offset; ?>" />
									<input class="button" type="submit" value="<?php _e('Next tags', 'nggallery'); ?> &raquo;" />
								</span>
							</form>	
							<?php } else { ?> 
								<span><span class="button disabled"><?php _e('Previous tags', 'nggallery'); ?> &raquo;</span></span>
							<?php } ?> 
						</div>						
						<?php endif; ?>
					</div>
				</fieldset>
			</td>
			<td class="forms_manage">
				<h3><?php _e('Rename Tag', 'nggallery'); ?></h3>
				<form action="<?php echo $action_url; ?>" method="post">
					<input type="hidden" name="tag_action" value="renametag" />
					<input type="hidden" name="tag_nonce" value="<?php echo wp_create_nonce('nggallery_admin'); ?>" />

					<table class="form-table">
						<tr valign="top">
							<td colspan="2">
								<p><?php _e('Enter the tag to rename and its new value.  You can use this feature to merge tags too. Click "Rename" and all posts which use this tag will be updated.', 'nggallery'); ?></p>
								<p><?php _e('You can specify multiple tags to rename by separating them with commas.', 'nggallery'); ?></p>
							</td>
						</tr>	
						<tr valign="top">
							<th scope="row"><label for="renametag_old"><?php _e('Tag(s) to rename:', 'nggallery'); ?></label></th>
							<td><input type="text" id="renametag_old" name="renametag_old" value="" size="40" /></td>
						</tr>		
						<tr valign="top">
							<th scope="row"><label for="renametag_new"><?php _e('New tag name(s):', 'nggallery'); ?></label></th>
							<td>
								<input type="text" id="renametag_new" name="renametag_new" value="" size="40" />
								<input class="button" type="submit" name="rename" value="<?php _e('Rename', 'nggallery'); ?>" />
							</td>
						</tr>	
					</table>							
				</form>

				<h3><?php _e('Delete Tag', 'nggallery'); ?></h3>
				<form action="<?php echo $action_url; ?>" method="post">
					<input type="hidden" name="tag_action" value="deletetag" />
					<input type="hidden" name="tag_nonce" value="<?php echo wp_create_nonce('nggallery_admin'); ?>" />

					<table class="form-table">
						<tr valign="top">
							<td colspan="2">
								<p><?php _e('Enter the name of the tag to delete.  This tag will be removed from all posts.', 'nggallery'); ?></p>
								<p><?php _e('You can specify multiple tags to delete by separating them with commas', 'nggallery'); ?>.</p>
							</td>
						</tr>	
						<tr valign="top">
							<th scope="row"><label for="deletetag_name"><?php _e('Tag(s) to delete:', 'nggallery'); ?></label></th>
							<td>
								<input type="text" id="deletetag_name" name="deletetag_name" value="" size="40" />
								<input class="button" type="submit" name="delete" value="<?php _e('Delete', 'nggallery'); ?>" />
							</td>
						</tr>
					</table>
				</form>				

				<h3><?php _e('Edit Tag Slug', 'nggallery'); ?></h3>
				<form action="<?php echo $action_url; ?>" method="post">
					<input type="hidden" name="tag_action" value="editslug" />
					<input type="hidden" name="tag_nonce" value="<?php echo wp_create_nonce('nggallery_admin'); ?>" />
				
					<table class="form-table">
						<tr valign="top">
							<td colspan="2">
								<p><?php _e('Enter the tag name to edit and its new slug. <a href="http://codex.wordpress.org/Glossary#Slug">Slug definition</a>', 'nggallery'); ?></p>
								<p><?php _e('You can specify multiple tags to rename by separating them with commas.', 'nggallery'); ?></p>
							</td>
						</tr>	
						<tr valign="top">
							<th scope="row"><label for="tagname_match"><?php _e('Tag(s) to match:', 'nggallery'); ?></label></th>
							<td><input type="text" id="tagname_match" name="tagname_match" value="" size="40" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="tagslug_new"><?php _e('Slug(s) to set:', 'nggallery'); ?></label></th>
							<td>
								<input type="text" id="tagslug_new" name="tagslug_new" value="" size="40" />
								<input class="button" type="submit" name="edit" value="<?php _e('Edit', 'nggallery'); ?>" />
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
  	<script type="text/javascript">
  	// <![CDATA[
  		// Register onclick event
  		function registerClick() {
  			jQuery('#taglist ul li span').bind("click", function(){
				addTag(this.innerHTML, "renametag_old");
				addTag(this.innerHTML, "deletetag_name");
				addTag(this.innerHTML, "tagname_match");
			});
  		}
  		
		// Register initial event
 		jQuery(document).ready(function() {
			registerClick();
		});
		
		// Add tag into input
		function addTag( tag, name_element ) {
			var input_element = document.getElementById( name_element );

			if ( input_element.value.length > 0 && !input_element.value.match(/,\s*$/) )
				input_element.value += ", ";

			var re = new RegExp(tag + ",");
			if ( !input_element.value.match(re) )
				input_element.value += tag + ", ";

			return true;
		}
	// ]]>
	</script>
</div>