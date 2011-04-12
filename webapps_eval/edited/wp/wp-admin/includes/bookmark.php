<?php require_once('AspisMain.php'); ?><?php
function add_link (  ) {
return edit_link();
 }
function edit_link ( $link_id = array('',false) ) {
if ( (denot_boolean(current_user_can(array('manage_links',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
arrayAssign($_POST[0],deAspis(registerTaint(array('link_url',false))),addTaint(esc_html($_POST[0]['link_url'])));
arrayAssign($_POST[0],deAspis(registerTaint(array('link_url',false))),addTaint(esc_url($_POST[0]['link_url'])));
arrayAssign($_POST[0],deAspis(registerTaint(array('link_name',false))),addTaint(esc_html($_POST[0]['link_name'])));
arrayAssign($_POST[0],deAspis(registerTaint(array('link_image',false))),addTaint(esc_html($_POST[0]['link_image'])));
arrayAssign($_POST[0],deAspis(registerTaint(array('link_rss',false))),addTaint(esc_url($_POST[0]['link_rss'])));
if ( ((!((isset($_POST[0][('link_visible')]) && Aspis_isset( $_POST [0][('link_visible')])))) || (('N') != deAspis($_POST[0]['link_visible']))))
 arrayAssign($_POST[0],deAspis(registerTaint(array('link_visible',false))),addTaint(array('Y',false)));
if ( (!((empty($link_id) || Aspis_empty( $link_id)))))
 {arrayAssign($_POST[0],deAspis(registerTaint(array('link_id',false))),addTaint($link_id));
return wp_update_link($_POST);
}else 
{{return wp_insert_link($_POST);
}} }
function get_default_link_to_edit (  ) {
if ( ((isset($_GET[0][('linkurl')]) && Aspis_isset( $_GET [0][('linkurl')]))))
 $link[0]->link_url = esc_url($_GET[0]['linkurl']);
else 
{$link[0]->link_url = array('',false);
}if ( ((isset($_GET[0][('name')]) && Aspis_isset( $_GET [0][('name')]))))
 $link[0]->link_name = esc_attr($_GET[0]['name']);
else 
{$link[0]->link_name = array('',false);
}$link[0]->link_visible = array('Y',false);
return $link;
 }
function wp_delete_link ( $link_id ) {
global $wpdb;
do_action(array('delete_link',false),$link_id);
wp_delete_object_term_relationships($link_id,array('link_category',false));
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->links)," WHERE link_id = %d"),$link_id));
do_action(array('deleted_link',false),$link_id);
clean_bookmark_cache($link_id);
return array(true,false);
 }
function wp_get_link_cats ( $link_id = array(0,false) ) {
$cats = wp_get_object_terms($link_id,array('link_category',false),array('fields=ids',false));
return attAspisRC(array_unique(deAspisRC($cats)));
 }
function get_link_to_edit ( $link_id ) {
return get_bookmark($link_id,array(OBJECT,false),array('edit',false));
 }
function wp_insert_link ( $linkdata,$wp_error = array(false,false) ) {
global $wpdb,$current_user;
$defaults = array(array('link_id' => array(0,false,false),'link_name' => array('',false,false),'link_url' => array('',false,false),'link_rating' => array(0,false,false)),false);
$linkdata = wp_parse_args($linkdata,$defaults);
$linkdata = sanitize_bookmark($linkdata,array('db',false));
extract((deAspis(stripslashes_deep($linkdata))),EXTR_SKIP);
$update = array(false,false);
if ( (!((empty($link_id) || Aspis_empty( $link_id)))))
 $update = array(true,false);
if ( (deAspis(Aspis_trim($link_name)) == ('')))
 {if ( (deAspis(Aspis_trim($link_url)) != ('')))
 {$link_name = $link_url;
}else 
{{return array(0,false);
}}}if ( (deAspis(Aspis_trim($link_url)) == ('')))
 return array(0,false);
if ( ((empty($link_rating) || Aspis_empty( $link_rating))))
 $link_rating = array(0,false);
if ( ((empty($link_image) || Aspis_empty( $link_image))))
 $link_image = array('',false);
if ( ((empty($link_target) || Aspis_empty( $link_target))))
 $link_target = array('',false);
if ( ((empty($link_visible) || Aspis_empty( $link_visible))))
 $link_visible = array('Y',false);
if ( ((empty($link_owner) || Aspis_empty( $link_owner))))
 $link_owner = $current_user[0]->id;
if ( ((empty($link_notes) || Aspis_empty( $link_notes))))
 $link_notes = array('',false);
if ( ((empty($link_description) || Aspis_empty( $link_description))))
 $link_description = array('',false);
if ( ((empty($link_rss) || Aspis_empty( $link_rss))))
 $link_rss = array('',false);
if ( ((empty($link_rel) || Aspis_empty( $link_rel))))
 $link_rel = array('',false);
if ( (((!((isset($link_category) && Aspis_isset( $link_category)))) || ((0) == count($link_category[0]))) || (!(is_array($link_category[0])))))
 {$link_category = array(array(get_option(array('default_link_category',false))),false);
}if ( $update[0])
 {if ( (false === deAspis($wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->links)," SET link_url = %s,
			link_name = %s, link_image = %s, link_target = %s,
			link_visible = %s, link_description = %s, link_rating = %s,
			link_rel = %s, link_notes = %s, link_rss = %s
			WHERE link_id = %s"),$link_url,$link_name,$link_image,$link_target,$link_visible,$link_description,$link_rating,$link_rel,$link_notes,$link_rss,$link_id)))))
 {if ( $wp_error[0])
 return array(new WP_Error(array('db_update_error',false),__(array('Could not update link in the database',false)),$wpdb[0]->last_error),false);
else 
{return array(0,false);
}}}else 
{{if ( (false === deAspis($wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("INSERT INTO ",$wpdb[0]->links)," (link_url, link_name, link_image, link_target, link_description, link_visible, link_owner, link_rating, link_rel, link_notes, link_rss) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"),$link_url,$link_name,$link_image,$link_target,$link_description,$link_visible,$link_owner,$link_rating,$link_rel,$link_notes,$link_rss)))))
 {if ( $wp_error[0])
 return array(new WP_Error(array('db_insert_error',false),__(array('Could not insert link into the database',false)),$wpdb[0]->last_error),false);
else 
{return array(0,false);
}}$link_id = int_cast($wpdb[0]->insert_id);
}}wp_set_link_cats($link_id,$link_category);
if ( $update[0])
 do_action(array('edit_link',false),$link_id);
else 
{do_action(array('add_link',false),$link_id);
}clean_bookmark_cache($link_id);
return $link_id;
 }
function wp_set_link_cats ( $link_id = array(0,false),$link_categories = array(array(),false) ) {
if ( ((!(is_array($link_categories[0]))) || ((0) == count($link_categories[0]))))
 $link_categories = array(array(get_option(array('default_link_category',false))),false);
$link_categories = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC($link_categories)));
$link_categories = attAspisRC(array_unique(deAspisRC($link_categories)));
wp_set_object_terms($link_id,$link_categories,array('link_category',false));
clean_bookmark_cache($link_id);
 }
function wp_update_link ( $linkdata ) {
$link_id = int_cast($linkdata[0]['link_id']);
$link = get_link($link_id,array(ARRAY_A,false));
$link = add_magic_quotes($link);
if ( ((((isset($linkdata[0][('link_category')]) && Aspis_isset( $linkdata [0][('link_category')]))) && is_array(deAspis($linkdata[0]['link_category']))) && ((0) != count(deAspis($linkdata[0]['link_category'])))))
 $link_cats = $linkdata[0]['link_category'];
else 
{$link_cats = $link[0]['link_category'];
}$linkdata = Aspis_array_merge($link,$linkdata);
arrayAssign($linkdata[0],deAspis(registerTaint(array('link_category',false))),addTaint($link_cats));
return wp_insert_link($linkdata);
 }
;
?>
<?php 