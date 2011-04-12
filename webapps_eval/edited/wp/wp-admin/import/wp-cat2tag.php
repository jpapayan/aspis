<?php require_once('AspisMain.php'); ?><?php
class WP_Categories_to_Tags{var $categories_to_convert = array(array(),false);
var $all_categories = array(array(),false);
var $tags_to_convert = array(array(),false);
var $all_tags = array(array(),false);
var $hybrids_ids = array(array(),false);
function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 {echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Cheatin&#8217; uh?',false))),'</p>'));
echo AspisCheckPrint(array('</div>',false));
}else 
{{;
?>
			<div class="tablenav"><p style="margin:4px"><a style="display:inline;" class="button-secondary" href="admin.php?import=wp-cat2tag"><?php _e(array("Categories to Tags",false));
;
?></a>
			<a style="display:inline;" class="button-secondary" href="admin.php?import=wp-cat2tag&amp;step=3"><?php _e(array("Tags to Categories",false));
;
?></a></p></div>
<?php }}} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function populate_cats (  ) {
{$categories = get_categories(array('get=all',false));
foreach ( $categories[0] as $category  )
{arrayAssignAdd($this->all_categories[0][],addTaint($category));
if ( deAspis(is_term($category[0]->slug,array('post_tag',false))))
 arrayAssignAdd($this->hybrids_ids[0][],addTaint($category[0]->term_id));
}} }
function populate_tags (  ) {
{$tags = get_terms(array(array(array('post_tag',false)),false),array('get=all',false));
foreach ( $tags[0] as $tag  )
{arrayAssignAdd($this->all_tags[0][],addTaint($tag));
if ( deAspis(is_term($tag[0]->slug,array('category',false))))
 arrayAssignAdd($this->hybrids_ids[0][],addTaint($tag[0]->term_id));
}} }
function categories_tab (  ) {
{$this->populate_cats();
$cat_num = attAspis(count($this->all_categories[0]));
echo AspisCheckPrint(array('<br class="clear" />',false));
if ( ($cat_num[0] > (0)))
 {screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',Aspis_sprintf(_n(array('Convert Category to Tag.',false),array('Convert Categories (%d) to Tags.',false),$cat_num),$cat_num)),'</h2>'));
echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Hey there. Here you can selectively convert existing categories to tags. To get started, check the categories you wish to be converted, then click the Convert button.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Keep in mind that if you convert a category with child categories, the children become top-level orphans.',false))),'</p></div>'));
$this->categories_form();
}else 
{{echo AspisCheckPrint(concat2(concat1('<p>',__(array('You have no categories to convert!',false))),'</p>'));
}}} }
function categories_form (  ) {
{;
?>

<script type="text/javascript">
/* <![CDATA[ */
var checkflag = "false";
function check_all_rows() {
	field = document.catlist;
	if ( 'false' == checkflag ) {
		for ( i = 0; i < field.length; i++ ) {
			if ( 'cats_to_convert[]' == field[i].name )
				field[i].checked = true;
		}
		checkflag = 'true';
		return '<?php _e(array('Uncheck All',false));
?>';
	} else {
		for ( i = 0; i < field.length; i++ ) {
			if ( 'cats_to_convert[]' == field[i].name )
				field[i].checked = false;
		}
		checkflag = 'false';
		return '<?php _e(array('Check All',false));
?>';
	}
}
/* ]]> */
</script>

<form name="catlist" id="catlist" action="admin.php?import=wp-cat2tag&amp;step=2" method="post">
<p><input type="button" class="button-secondary" value="<?php esc_attr_e(array('Check All',false));
;
?>" onclick="this.value=check_all_rows()" />
<?php wp_nonce_field(array('import-cat2tag',false));
;
?></p>
<ul style="list-style:none">

<?php $hier = _get_term_hierarchy(array('category',false));
foreach ( $this->all_categories[0] as $category  )
{$category = sanitize_term($category,array('category',false),array('display',false));
if ( (deAspis(int_cast($category[0]->parent)) == (0)))
 {;
?>

	<li><label><input type="checkbox" name="cats_to_convert[]" value="<?php echo AspisCheckPrint(Aspis_intval($category[0]->term_id));
;
?>" /> <?php echo AspisCheckPrint(concat2(concat(concat2($category[0]->name,' ('),$category[0]->count),')'));
;
?></label><?php if ( deAspis(Aspis_in_array(Aspis_intval($category[0]->term_id),$this->hybrids_ids)))
 echo AspisCheckPrint(array(' <a href="#note"> * </a>',false));
if ( ((isset($hier[0][$category[0]->term_id[0]]) && Aspis_isset( $hier [0][$category[0] ->term_id [0]]))))
 $this->_category_children($category,$hier);
;
?></li>
<?php }};
?>
</ul>

<?php if ( (!((empty($this->hybrids_ids) || Aspis_empty( $this ->hybrids_ids )))))
 echo AspisCheckPrint(concat2(concat1('<p><a name="note"></a>',__(array('* This category is also a tag. Converting it will add that tag to all posts that are currently in the category.',false))),'</p>'));
;
?>

<p class="submit"><input type="submit" name="submit" class="button" value="<?php esc_attr_e(array('Convert Categories to Tags',false));
;
?>" /></p>
</form>

<?php } }
function tags_tab (  ) {
{$this->populate_tags();
$tags_num = attAspis(count($this->all_tags[0]));
echo AspisCheckPrint(array('<br class="clear" />',false));
if ( ($tags_num[0] > (0)))
 {screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',Aspis_sprintf(_n(array('Convert Tag to Category.',false),array('Convert Tags (%d) to Categories.',false),$tags_num),$tags_num)),'</h2>'));
echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Here you can selectively convert existing tags to categories. To get started, check the tags you wish to be converted, then click the Convert button.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('The newly created categories will still be associated with the same posts.',false))),'</p></div>'));
$this->tags_form();
}else 
{{echo AspisCheckPrint(concat2(concat1('<p>',__(array('You have no tags to convert!',false))),'</p>'));
}}} }
function tags_form (  ) {
{;
?>

<script type="text/javascript">
/* <![CDATA[ */
var checktags = "false";
function check_all_tagrows() {
	field = document.taglist;
	if ( 'false' == checktags ) {
		for ( i = 0; i < field.length; i++ ) {
			if ( 'tags_to_convert[]' == field[i].name )
				field[i].checked = true;
		}
		checktags = 'true';
		return '<?php _e(array('Uncheck All',false));
?>';
	} else {
		for ( i = 0; i < field.length; i++ ) {
			if ( 'tags_to_convert[]' == field[i].name )
				field[i].checked = false;
		}
		checktags = 'false';
		return '<?php _e(array('Check All',false));
?>';
	}
}
/* ]]> */
</script>

<form name="taglist" id="taglist" action="admin.php?import=wp-cat2tag&amp;step=4" method="post">
<p><input type="button" class="button-secondary" value="<?php esc_attr_e(array('Check All',false));
;
?>" onclick="this.value=check_all_tagrows()" />
<?php wp_nonce_field(array('import-cat2tag',false));
;
?></p>
<ul style="list-style:none">

<?php foreach ( $this->all_tags[0] as $tag  )
{;
?>
	<li><label><input type="checkbox" name="tags_to_convert[]" value="<?php echo AspisCheckPrint(Aspis_intval($tag[0]->term_id));
;
?>" /> <?php echo AspisCheckPrint(concat2(concat(concat2(esc_attr($tag[0]->name),' ('),$tag[0]->count),')'));
;
?></label><?php if ( deAspis(Aspis_in_array(Aspis_intval($tag[0]->term_id),$this->hybrids_ids)))
 echo AspisCheckPrint(array(' <a href="#note"> * </a>',false));
;
?></li>

<?php };
?>
</ul>

<?php if ( (!((empty($this->hybrids_ids) || Aspis_empty( $this ->hybrids_ids )))))
 echo AspisCheckPrint(concat2(concat1('<p><a name="note"></a>',__(array('* This tag is also a category. When converted, all posts associated with the tag will also be in the category.',false))),'</p>'));
;
?>

<p class="submit"><input type="submit" name="submit_tags" class="button" value="<?php esc_attr_e(array('Convert Tags to Categories',false));
;
?>" /></p>
</form>

<?php } }
function _category_children ( $parent,$hier ) {
{;
?>

		<ul style="list-style:none">
<?php foreach ( deAspis(attachAspis($hier,$parent[0]->term_id[0])) as $child_id  )
{$child = &get_category($child_id);
;
?>
		<li><label><input type="checkbox" name="cats_to_convert[]" value="<?php echo AspisCheckPrint(Aspis_intval($child[0]->term_id));
;
?>" /> <?php echo AspisCheckPrint(concat2(concat(concat2($child[0]->name,' ('),$child[0]->count),')'));
;
?></label><?php if ( deAspis(Aspis_in_array(Aspis_intval($child[0]->term_id),$this->hybrids_ids)))
 echo AspisCheckPrint(array(' <a href="#note"> * </a>',false));
if ( ((isset($hier[0][$child[0]->term_id[0]]) && Aspis_isset( $hier [0][$child[0] ->term_id [0]]))))
 $this->_category_children($child,$hier);
;
?></li>
<?php };
?>
		</ul><?php } }
function _category_exists ( $cat_id ) {
{$cat_id = int_cast($cat_id);
$maybe_exists = category_exists($cat_id);
if ( $maybe_exists[0])
 {return array(true,false);
}else 
{{return array(false,false);
}}} }
function convert_categories (  ) {
{global $wpdb;
if ( (((!((isset($_POST[0][('cats_to_convert')]) && Aspis_isset( $_POST [0][('cats_to_convert')])))) || (!(is_array(deAspis($_POST[0]['cats_to_convert']))))) && ((empty($this->categories_to_convert) || Aspis_empty( $this ->categories_to_convert )))))
 {;
?>
			<div class="narrow">
			<p><?php printf(deAspis(__(array('Uh, oh. Something didn&#8217;t work. Please <a href="%s">try again</a>.',false))),'admin.php?import=wp-cat2tag');
;
?></p>
			</div>
<?php return ;
}if ( ((empty($this->categories_to_convert) || Aspis_empty( $this ->categories_to_convert ))))
 $this->categories_to_convert = $_POST[0]['cats_to_convert'];
$hier = _get_term_hierarchy(array('category',false));
$hybrid_cats = $clear_parents = $parents = array(false,false);
$clean_term_cache = $clean_cat_cache = array(array(),false);
$default_cat = get_option(array('default_category',false));
echo AspisCheckPrint(array('<ul>',false));
foreach ( deAspis(array_cast($this->categories_to_convert)) as $cat_id  )
{$cat_id = int_cast($cat_id);
if ( (denot_boolean($this->_category_exists($cat_id))))
 {echo AspisCheckPrint(concat2(concat1('<li>',Aspis_sprintf(__(array('Category %s doesn&#8217;t exist!',false)),$cat_id)),"</li>\n"));
}else 
{{$category = &get_category($cat_id);
echo AspisCheckPrint(concat1('<li>',Aspis_sprintf(__(array('Converting category <strong>%s</strong> ... ',false)),$category[0]->name)));
if ( ($default_cat[0] == $category[0]->term_id[0]))
 {if ( (denot_boolean(($id = is_term($category[0]->slug,array('post_tag',false))))))
 $id = wp_insert_term($category[0]->name,array('post_tag',false),array(array(deregisterTaint(array('slug',false)) => addTaint($category[0]->slug)),false));
$id = $id[0]['term_taxonomy_id'];
$posts = get_objects_in_term($category[0]->term_id,array('category',false));
$term_order = array(0,false);
foreach ( $posts[0] as $post  )
{arrayAssignAdd($values[0][],addTaint($wpdb[0]->prepare(array("(%d, %d, %d)",false),$post,$id,$term_order)));
clean_post_cache($post);
}if ( $values[0])
 {$wpdb[0]->query(concat2(concat(concat2(concat1("INSERT INTO ",$wpdb[0]->term_relationships)," (object_id, term_taxonomy_id, term_order) VALUES "),Aspis_join(array(',',false),$values))," ON DUPLICATE KEY UPDATE term_order = VALUES(term_order)"));
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->term_taxonomy)," SET count = %d WHERE term_id = %d AND taxonomy = 'post_tag'"),$category[0]->count,$category[0]->term_id));
}echo AspisCheckPrint(concat2(__(array('Converted successfully.',false)),"</li>\n"));
continue ;
}if ( deAspis($tag_ttid = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT term_taxonomy_id FROM ",$wpdb[0]->term_taxonomy)," WHERE term_id = %d AND taxonomy = 'post_tag'"),$category[0]->term_id))))
 {$objects_ids = get_objects_in_term($category[0]->term_id,array('category',false));
$tag_ttid = int_cast($tag_ttid);
$term_order = array(0,false);
foreach ( $objects_ids[0] as $object_id  )
arrayAssignAdd($values[0][],addTaint($wpdb[0]->prepare(array("(%d, %d, %d)",false),$object_id,$tag_ttid,$term_order)));
if ( $values[0])
 {$wpdb[0]->query(concat2(concat(concat2(concat1("INSERT INTO ",$wpdb[0]->term_relationships)," (object_id, term_taxonomy_id, term_order) VALUES "),Aspis_join(array(',',false),$values))," ON DUPLICATE KEY UPDATE term_order = VALUES(term_order)"));
$count = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->term_relationships)," WHERE term_taxonomy_id = %d"),$tag_ttid));
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->term_taxonomy)," SET count = %d WHERE term_id = %d AND taxonomy = 'post_tag'"),$count,$category[0]->term_id));
}echo AspisCheckPrint(concat2(__(array('Tag added to all posts in this category.',false))," *</li>\n"));
$hybrid_cats = array(true,false);
arrayAssignAdd($clean_term_cache[0][],addTaint($category[0]->term_id));
arrayAssignAdd($clean_cat_cache[0][],addTaint($category[0]->term_id));
continue ;
}$tt_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT term_taxonomy_id FROM ",$wpdb[0]->term_taxonomy)," WHERE term_id = %d AND taxonomy = 'category'"),$category[0]->term_id));
if ( $tt_ids[0])
 {$posts = $wpdb[0]->get_col(concat2(concat(concat2(concat1("SELECT object_id FROM ",$wpdb[0]->term_relationships)," WHERE term_taxonomy_id IN ("),Aspis_join(array(',',false),$tt_ids)),") GROUP BY object_id"));
foreach ( deAspis(array_cast($posts)) as $post  )
clean_post_cache($post);
}$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->term_taxonomy)," SET taxonomy = 'post_tag' WHERE term_id = %d AND taxonomy = 'category'"),$category[0]->term_id));
$parents = $wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->term_taxonomy)," SET parent = 0 WHERE parent = %d AND taxonomy = 'category'"),$category[0]->term_id));
if ( $parents[0])
 $clear_parents = array(true,false);
arrayAssignAdd($clean_cat_cache[0][],addTaint($category[0]->term_id));
echo AspisCheckPrint(concat2(__(array('Converted successfully.',false)),"</li>\n"));
}}}echo AspisCheckPrint(array('</ul>',false));
if ( (!((empty($clean_term_cache) || Aspis_empty( $clean_term_cache)))))
 {$clean_term_cache = attAspisRC(array_unique(deAspisRC(Aspis_array_values($clean_term_cache))));
clean_term_cache($clean_term_cache,array('post_tag',false));
}if ( (!((empty($clean_cat_cache) || Aspis_empty( $clean_cat_cache)))))
 {$clean_cat_cache = attAspisRC(array_unique(deAspisRC(Aspis_array_values($clean_cat_cache))));
clean_term_cache($clean_cat_cache,array('category',false));
}if ( $clear_parents[0])
 delete_option(array('category_children',false));
if ( $hybrid_cats[0])
 echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('* This category is also a tag. The converter has added that tag to all posts currently in the category. If you want to remove it, please confirm that all tags were added successfully, then delete it from the <a href="%s">Manage Categories</a> page.',false)),array('categories.php',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('We&#8217;re all done here, but you can always <a href="%s">convert more</a>.',false)),array('admin.php?import=wp-cat2tag',false))),'</p>'));
} }
function convert_tags (  ) {
{global $wpdb;
if ( (((!((isset($_POST[0][('tags_to_convert')]) && Aspis_isset( $_POST [0][('tags_to_convert')])))) || (!(is_array(deAspis($_POST[0]['tags_to_convert']))))) && ((empty($this->tags_to_convert) || Aspis_empty( $this ->tags_to_convert )))))
 {echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Uh, oh. Something didn&#8217;t work. Please <a href="%s">try again</a>.',false)),array('admin.php?import=wp-cat2tag&amp;step=3',false))),'</p>'));
echo AspisCheckPrint(array('</div>',false));
return ;
}if ( ((empty($this->tags_to_convert) || Aspis_empty( $this ->tags_to_convert ))))
 $this->tags_to_convert = $_POST[0]['tags_to_convert'];
$hybrid_tags = $clear_parents = array(false,false);
$clean_cat_cache = $clean_term_cache = array(array(),false);
$default_cat = get_option(array('default_category',false));
echo AspisCheckPrint(array('<ul>',false));
foreach ( deAspis(array_cast($this->tags_to_convert)) as $tag_id  )
{$tag_id = int_cast($tag_id);
if ( deAspis($tag = get_term($tag_id,array('post_tag',false))))
 {printf((deconcat1('<li>',__(array('Converting tag <strong>%s</strong> ... ',false)))),deAspisRC($tag[0]->name));
if ( deAspis($cat_ttid = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT term_taxonomy_id FROM ",$wpdb[0]->term_taxonomy)," WHERE term_id = %d AND taxonomy = 'category'"),$tag[0]->term_id))))
 {$objects_ids = get_objects_in_term($tag[0]->term_id,array('post_tag',false));
$cat_ttid = int_cast($cat_ttid);
$term_order = array(0,false);
foreach ( $objects_ids[0] as $object_id  )
{arrayAssignAdd($values[0][],addTaint($wpdb[0]->prepare(array("(%d, %d, %d)",false),$object_id,$cat_ttid,$term_order)));
clean_post_cache($object_id);
}if ( $values[0])
 {$wpdb[0]->query(concat2(concat(concat2(concat1("INSERT INTO ",$wpdb[0]->term_relationships)," (object_id, term_taxonomy_id, term_order) VALUES "),Aspis_join(array(',',false),$values))," ON DUPLICATE KEY UPDATE term_order = VALUES(term_order)"));
if ( ($default_cat[0] != $tag[0]->term_id[0]))
 {$count = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->term_relationships)," WHERE term_taxonomy_id = %d"),$tag[0]->term_id));
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->term_taxonomy)," SET count = %d WHERE term_id = %d AND taxonomy = 'category'"),$count,$tag[0]->term_id));
}}$hybrid_tags = array(true,false);
arrayAssignAdd($clean_term_cache[0][],addTaint($tag[0]->term_id));
arrayAssignAdd($clean_cat_cache[0][],addTaint($tag[0]->term_id));
echo AspisCheckPrint(concat2(__(array('All posts were added to the category with the same name.',false))," *</li>\n"));
continue ;
}$parent = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT parent FROM ",$wpdb[0]->term_taxonomy)," WHERE term_id = %d AND taxonomy = 'post_tag'"),$tag[0]->term_id));
if ( (((0) == $parent[0]) || (((0) < deAspis(int_cast($parent))) && deAspis($this->_category_exists($parent)))))
 {$reset_parent = array('',false);
$clear_parents = array(true,false);
}else 
{$reset_parent = array(", parent = '0'",false);
}$wpdb[0]->query($wpdb[0]->prepare(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->term_taxonomy)," SET taxonomy = 'category' "),$reset_parent)," WHERE term_id = %d AND taxonomy = 'post_tag'"),$tag[0]->term_id));
arrayAssignAdd($clean_term_cache[0][],addTaint($tag[0]->term_id));
arrayAssignAdd($clean_cat_cache[0][],addTaint($cat[0]['term_id']));
echo AspisCheckPrint(concat2(__(array('Converted successfully.',false)),"</li>\n"));
}else 
{{printf((deconcat2(concat1('<li>',__(array('Tag #%s doesn&#8217;t exist!',false))),"</li>\n")),deAspisRC($tag_id));
}}}if ( (!((empty($clean_term_cache) || Aspis_empty( $clean_term_cache)))))
 {$clean_term_cache = attAspisRC(array_unique(deAspisRC(Aspis_array_values($clean_term_cache))));
clean_term_cache($clean_term_cache,array('post_tag',false));
}if ( (!((empty($clean_cat_cache) || Aspis_empty( $clean_cat_cache)))))
 {$clean_cat_cache = attAspisRC(array_unique(deAspisRC(Aspis_array_values($clean_cat_cache))));
clean_term_cache($clean_term_cache,array('category',false));
}if ( $clear_parents[0])
 delete_option(array('category_children',false));
echo AspisCheckPrint(array('</ul>',false));
if ( $hybrid_tags[0])
 echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('* This tag is also a category. The converter has added all posts from it to the category. If you want to remove it, please confirm that all posts were added successfully, then delete it from the <a href="%s">Manage Tags</a> page.',false)),array('edit-tags.php',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('We&#8217;re all done here, but you can always <a href="%s">convert more</a>.',false)),array('admin.php?import=wp-cat2tag&amp;step=3',false))),'</p>'));
} }
function init (  ) {
{$step = ((isset($_GET[0][('step')]) && Aspis_isset( $_GET [0][('step')]))) ? int_cast($_GET[0]['step']) : array(1,false);
$this->header();
if ( deAspis(current_user_can(array('manage_categories',false))))
 {switch ( $step[0] ) {
case (1):$this->categories_tab();
break ;
case (2):check_admin_referer(array('import-cat2tag',false));
$this->convert_categories();
break ;
case (3):$this->tags_tab();
break ;
case (4):check_admin_referer(array('import-cat2tag',false));
$this->convert_tags();
break ;
 }
}$this->footer();
} }
function WP_Categories_to_Tags (  ) {
{} }
}$wp_cat2tag_importer = array(new WP_Categories_to_Tags(),false);
register_importer(array('wp-cat2tag',false),__(array('Categories and Tags Converter',false)),__(array('Convert existing categories to tags or tags to categories, selectively.',false)),array(array(&$wp_cat2tag_importer,array('init',false)),false));
;
?>
<?php 