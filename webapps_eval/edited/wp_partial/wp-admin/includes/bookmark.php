<?php require_once('AspisMain.php'); ?><?php
function add_link (  ) {
{$AspisRetTemp = edit_link();
return $AspisRetTemp;
} }
function edit_link ( $link_id = '' ) {
if ( !current_user_can('manage_links'))
 wp_die(__('Cheatin&#8217; uh?'));
$_POST[0]['link_url'] = attAspisRCO(esc_html(deAspisWarningRC($_POST[0]['link_url'])));
$_POST[0]['link_url'] = attAspisRCO(esc_url(deAspisWarningRC($_POST[0]['link_url'])));
$_POST[0]['link_name'] = attAspisRCO(esc_html(deAspisWarningRC($_POST[0]['link_name'])));
$_POST[0]['link_image'] = attAspisRCO(esc_html(deAspisWarningRC($_POST[0]['link_image'])));
$_POST[0]['link_rss'] = attAspisRCO(esc_url(deAspisWarningRC($_POST[0]['link_rss'])));
if ( !(isset($_POST[0]['link_visible']) && Aspis_isset($_POST[0]['link_visible'])) || 'N' != deAspisWarningRC($_POST[0]['link_visible']))
 $_POST[0]['link_visible'] = attAspisRCO('Y');
if ( !empty($link_id))
 {$_POST[0]['link_id'] = attAspisRCO($link_id);
{$AspisRetTemp = wp_update_link(deAspisWarningRC($_POST));
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = wp_insert_link(deAspisWarningRC($_POST));
return $AspisRetTemp;
}}} }
function get_default_link_to_edit (  ) {
if ( (isset($_GET[0]['linkurl']) && Aspis_isset($_GET[0]['linkurl'])))
 $link->link_url = esc_url(deAspisWarningRC($_GET[0]['linkurl']));
else 
{$link->link_url = '';
}if ( (isset($_GET[0]['name']) && Aspis_isset($_GET[0]['name'])))
 $link->link_name = esc_attr(deAspisWarningRC($_GET[0]['name']));
else 
{$link->link_name = '';
}$link->link_visible = 'Y';
{$AspisRetTemp = $link;
return $AspisRetTemp;
} }
function wp_delete_link ( $link_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}do_action('delete_link',$link_id);
wp_delete_object_term_relationships($link_id,'link_category');
$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->links WHERE link_id = %d",$link_id));
do_action('deleted_link',$link_id);
clean_bookmark_cache($link_id);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_get_link_cats ( $link_id = 0 ) {
$cats = wp_get_object_terms($link_id,'link_category','fields=ids');
{$AspisRetTemp = array_unique($cats);
return $AspisRetTemp;
} }
function get_link_to_edit ( $link_id ) {
{$AspisRetTemp = get_bookmark($link_id,OBJECT,'edit');
return $AspisRetTemp;
} }
function wp_insert_link ( $linkdata,$wp_error = false ) {
{global $wpdb,$current_user;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($current_user,"\$current_user",$AspisChangesCache);
}$defaults = array('link_id' => 0,'link_name' => '','link_url' => '','link_rating' => 0);
$linkdata = wp_parse_args($linkdata,$defaults);
$linkdata = sanitize_bookmark($linkdata,'db');
extract((stripslashes_deep($linkdata)),EXTR_SKIP);
$update = false;
if ( !empty($link_id))
 $update = true;
if ( trim($link_name) == '')
 {if ( trim($link_url) != '')
 {$link_name = $link_url;
}else 
{{{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}}}}if ( trim($link_url) == '')
 {$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}if ( empty($link_rating))
 $link_rating = 0;
if ( empty($link_image))
 $link_image = '';
if ( empty($link_target))
 $link_target = '';
if ( empty($link_visible))
 $link_visible = 'Y';
if ( empty($link_owner))
 $link_owner = $current_user->id;
if ( empty($link_notes))
 $link_notes = '';
if ( empty($link_description))
 $link_description = '';
if ( empty($link_rss))
 $link_rss = '';
if ( empty($link_rel))
 $link_rel = '';
if ( !isset($link_category) || 0 == count($link_category) || !is_array($link_category))
 {$link_category = array(get_option('default_link_category'));
}if ( $update)
 {if ( false === $wpdb->query($wpdb->prepare("UPDATE $wpdb->links SET link_url = %s,
			link_name = %s, link_image = %s, link_target = %s,
			link_visible = %s, link_description = %s, link_rating = %s,
			link_rel = %s, link_notes = %s, link_rss = %s
			WHERE link_id = %s",$link_url,$link_name,$link_image,$link_target,$link_visible,$link_description,$link_rating,$link_rel,$link_notes,$link_rss,$link_id)))
 {if ( $wp_error)
 {$AspisRetTemp = new WP_Error('db_update_error',__('Could not update link in the database'),$wpdb->last_error);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}}}}else 
{{if ( false === $wpdb->query($wpdb->prepare("INSERT INTO $wpdb->links (link_url, link_name, link_image, link_target, link_description, link_visible, link_owner, link_rating, link_rel, link_notes, link_rss) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",$link_url,$link_name,$link_image,$link_target,$link_description,$link_visible,$link_owner,$link_rating,$link_rel,$link_notes,$link_rss)))
 {if ( $wp_error)
 {$AspisRetTemp = new WP_Error('db_insert_error',__('Could not insert link into the database'),$wpdb->last_error);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}}}$link_id = (int)$wpdb->insert_id;
}}wp_set_link_cats($link_id,$link_category);
if ( $update)
 do_action('edit_link',$link_id);
else 
{do_action('add_link',$link_id);
}clean_bookmark_cache($link_id);
{$AspisRetTemp = $link_id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$current_user",$AspisChangesCache);
 }
function wp_set_link_cats ( $link_id = 0,$link_categories = array() ) {
if ( !is_array($link_categories) || 0 == count($link_categories))
 $link_categories = array(get_option('default_link_category'));
$link_categories = array_map('intval',$link_categories);
$link_categories = array_unique($link_categories);
wp_set_object_terms($link_id,$link_categories,'link_category');
clean_bookmark_cache($link_id);
 }
function wp_update_link ( $linkdata ) {
$link_id = (int)$linkdata['link_id'];
$link = get_link($link_id,ARRAY_A);
$link = deAspisWarningRC(add_magic_quotes(attAspisRCO($link)));
if ( isset($linkdata['link_category']) && is_array($linkdata['link_category']) && 0 != count($linkdata['link_category']))
 $link_cats = $linkdata['link_category'];
else 
{$link_cats = $link['link_category'];
}$linkdata = array_merge($link,$linkdata);
$linkdata['link_category'] = $link_cats;
{$AspisRetTemp = wp_insert_link($linkdata);
return $AspisRetTemp;
} }
;
?>
<?php 