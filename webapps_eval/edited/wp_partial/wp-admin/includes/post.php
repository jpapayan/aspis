<?php require_once('AspisMain.php'); ?><?php
function _wp_translate_postdata ( $update = false,$post_data = null ) {
if ( empty($post_data))
 $post_data = &deAspisWarningRC($_POST);
if ( $update)
 $post_data['ID'] = (int)$post_data['post_ID'];
$post_data['post_content'] = isset($post_data['content']) ? $post_data['content'] : '';
$post_data['post_excerpt'] = isset($post_data['excerpt']) ? $post_data['excerpt'] : '';
$post_data['post_parent'] = isset($post_data['parent_id']) ? $post_data['parent_id'] : '';
if ( isset($post_data['trackback_url']))
 $post_data['to_ping'] = $post_data['trackback_url'];
if ( !empty($post_data['post_author_override']))
 {$post_data['post_author'] = (int)$post_data['post_author_override'];
}else 
{{if ( !empty($post_data['post_author']))
 {$post_data['post_author'] = (int)$post_data['post_author'];
}else 
{{$post_data['post_author'] = (int)$post_data['user_ID'];
}}}}if ( isset($post_data['user_ID']) && ($post_data['post_author'] != $post_data['user_ID']))
 {if ( 'page' == $post_data['post_type'])
 {if ( !current_user_can('edit_others_pages'))
 {{$AspisRetTemp = new WP_Error('edit_others_pages',$update ? __('You are not allowed to edit pages as this user.') : __('You are not allowed to create pages as this user.'));
return $AspisRetTemp;
}}}else 
{{if ( !current_user_can('edit_others_posts'))
 {{$AspisRetTemp = new WP_Error('edit_others_posts',$update ? __('You are not allowed to edit posts as this user.') : __('You are not allowed to post as this user.'));
return $AspisRetTemp;
}}}}}if ( isset($post_data['saveasdraft']) && '' != $post_data['saveasdraft'])
 $post_data['post_status'] = 'draft';
if ( isset($post_data['saveasprivate']) && '' != $post_data['saveasprivate'])
 $post_data['post_status'] = 'private';
if ( isset($post_data['publish']) && ('' != $post_data['publish']) && ($post_data['post_status'] != 'private'))
 $post_data['post_status'] = 'publish';
if ( isset($post_data['advanced']) && '' != $post_data['advanced'])
 $post_data['post_status'] = 'draft';
if ( isset($post_data['pending']) && '' != $post_data['pending'])
 $post_data['post_status'] = 'pending';
$previous_status = get_post_field('post_status',isset($post_data['ID']) ? $post_data['ID'] : $post_data['temp_ID']);
if ( 'page' == $post_data['post_type'])
 {$publish_cap = 'publish_pages';
$edit_cap = 'edit_published_pages';
}else 
{{$publish_cap = 'publish_posts';
$edit_cap = 'edit_published_posts';
}}if ( isset($post_data['post_status']) && ('publish' == $post_data['post_status'] && !current_user_can($publish_cap)))
 if ( $previous_status != 'publish' || !current_user_can($edit_cap))
 $post_data['post_status'] = 'pending';
if ( !isset($post_data['post_status']))
 $post_data['post_status'] = $previous_status;
if ( !isset($post_data['comment_status']))
 $post_data['comment_status'] = 'closed';
if ( !isset($post_data['ping_status']))
 $post_data['ping_status'] = 'closed';
foreach ( array('aa','mm','jj','hh','mn') as $timeunit  )
{if ( !empty($post_data['hidden_' . $timeunit]) && $post_data['hidden_' . $timeunit] != $post_data[$timeunit])
 {$post_data['edit_date'] = '1';
break ;
}}if ( !empty($post_data['edit_date']))
 {$aa = $post_data['aa'];
$mm = $post_data['mm'];
$jj = $post_data['jj'];
$hh = $post_data['hh'];
$mn = $post_data['mn'];
$ss = $post_data['ss'];
$aa = ($aa <= 0) ? date('Y') : $aa;
$mm = ($mm <= 0) ? date('n') : $mm;
$jj = ($jj > 31) ? 31 : $jj;
$jj = ($jj <= 0) ? date('j') : $jj;
$hh = ($hh > 23) ? $hh - 24 : $hh;
$mn = ($mn > 59) ? $mn - 60 : $mn;
$ss = ($ss > 59) ? $ss - 60 : $ss;
$post_data['post_date'] = sprintf("%04d-%02d-%02d %02d:%02d:%02d",$aa,$mm,$jj,$hh,$mn,$ss);
$post_data['post_date_gmt'] = get_gmt_from_date($post_data['post_date']);
}{$AspisRetTemp = $post_data;
return $AspisRetTemp;
} }
function edit_post ( $post_data = null ) {
if ( empty($post_data))
 $post_data = &deAspisWarningRC($_POST);
$post_ID = (int)$post_data['post_ID'];
if ( 'page' == $post_data['post_type'])
 {if ( !current_user_can('edit_page',$post_ID))
 wp_die(__('You are not allowed to edit this page.'));
}else 
{{if ( !current_user_can('edit_post',$post_ID))
 wp_die(__('You are not allowed to edit this post.'));
}}if ( 'autosave' == $post_data['action'])
 {$post = &get_post($post_ID);
$now = time();
$then = strtotime($post->post_date_gmt . ' +0000');
$delta = AUTOSAVE_INTERVAL / 2;
if ( ($now - $then) < $delta)
 {$AspisRetTemp = $post_ID;
return $AspisRetTemp;
}}$post_data = _wp_translate_postdata(true,$post_data);
if ( is_wp_error($post_data))
 wp_die($post_data->get_error_message());
if ( isset($post_data['visibility']))
 {switch ( $post_data['visibility'] ) {
case 'public':$post_data['post_password'] = '';
break ;
case 'password':unset($post_data['sticky']);
break ;
case 'private':$post_data['post_status'] = 'private';
$post_data['post_password'] = '';
unset($post_data['sticky']);
break ;
 }
}if ( isset($post_data['meta']) && $post_data['meta'])
 {foreach ( $post_data['meta'] as $key =>$value )
update_meta($key,$value['key'],$value['value']);
}if ( isset($post_data['deletemeta']) && $post_data['deletemeta'])
 {foreach ( $post_data['deletemeta'] as $key =>$value )
delete_meta($key);
}add_meta($post_ID);
wp_update_post($post_data);
if ( !$draft_ids = get_user_option('autosave_draft_ids'))
 $draft_ids = array();
if ( $draft_temp_id = (int)array_search($post_ID,$draft_ids))
 _relocate_children($draft_temp_id,$post_ID);
_fix_attachment_links($post_ID);
wp_set_post_lock($post_ID,$GLOBALS[0]['current_user']->ID);
if ( current_user_can('edit_others_posts'))
 {if ( !empty($post_data['sticky']))
 stick_post($post_ID);
else 
{unstick_post($post_ID);
}}{$AspisRetTemp = $post_ID;
return $AspisRetTemp;
} }
function bulk_edit_posts ( $post_data = null ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( empty($post_data))
 $post_data = &deAspisWarningRC($_POST);
if ( isset($post_data['post_type']) && 'page' == $post_data['post_type'])
 {if ( !current_user_can('edit_pages'))
 wp_die(__('You are not allowed to edit pages.'));
}else 
{{if ( !current_user_can('edit_posts'))
 wp_die(__('You are not allowed to edit posts.'));
}}if ( -1 == $post_data['_status'])
 {$post_data['post_status'] = null;
unset($post_data['post_status']);
}else 
{{$post_data['post_status'] = $post_data['_status'];
}}unset($post_data['_status']);
$post_IDs = array_map('intval',(array)$post_data['post']);
$reset = array('post_author','post_status','post_password','post_parent','page_template','comment_status','ping_status','keep_private','tags_input','post_category','sticky');
foreach ( $reset as $field  )
{if ( isset($post_data[$field]) && ('' == $post_data[$field] || -1 == $post_data[$field]))
 unset($post_data[$field]);
}if ( isset($post_data['post_category']))
 {if ( is_array($post_data['post_category']) && !empty($post_data['post_category']))
 $new_cats = array_map('absint',$post_data['post_category']);
else 
{unset($post_data['post_category']);
}}if ( isset($post_data['tags_input']))
 {$new_tags = preg_replace('/\s*,\s*/',',',rtrim(trim($post_data['tags_input']),' ,'));
$new_tags = explode(',',$new_tags);
}if ( isset($post_data['post_parent']) && ($parent = (int)$post_data['post_parent']))
 {$pages = $wpdb->get_results("SELECT ID, post_parent FROM $wpdb->posts WHERE post_type = 'page'");
$children = array();
for ( $i = 0 ; $i < 50 && $parent > 0 ; $i++ )
{$children[] = $parent;
foreach ( $pages as $page  )
{if ( $page->ID == $parent)
 {$parent = $page->post_parent;
break ;
}}}}$updated = $skipped = $locked = array();
foreach ( $post_IDs as $post_ID  )
{if ( isset($children) && in_array($post_ID,$children))
 {$skipped[] = $post_ID;
continue ;
}if ( wp_check_post_lock($post_ID))
 {$locked[] = $post_ID;
continue ;
}if ( isset($new_cats))
 {$cats = (array)wp_get_post_categories($post_ID);
$post_data['post_category'] = array_unique(array_merge($cats,$new_cats));
}if ( isset($new_tags))
 {$tags = wp_get_post_tags($post_ID,array('fields' => 'names'));
$post_data['tags_input'] = array_unique(array_merge($tags,$new_tags));
}$post_data['ID'] = $post_ID;
$updated[] = wp_update_post($post_data);
if ( isset($post_data['sticky']) && current_user_can('edit_others_posts'))
 {if ( 'sticky' == $post_data['sticky'])
 stick_post($post_ID);
else 
{unstick_post($post_ID);
}}}{$AspisRetTemp = array('updated' => $updated,'skipped' => $skipped,'locked' => $locked);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_default_post_to_edit (  ) {
$post_title = '';
if ( !(empty($_REQUEST[0]['post_title']) || Aspis_empty($_REQUEST[0]['post_title'])))
 $post_title = esc_html(stripslashes(deAspisWarningRC($_REQUEST[0]['post_title'])));
$post_content = '';
if ( !(empty($_REQUEST[0]['content']) || Aspis_empty($_REQUEST[0]['content'])))
 $post_content = esc_html(stripslashes(deAspisWarningRC($_REQUEST[0]['content'])));
$post_excerpt = '';
if ( !(empty($_REQUEST[0]['excerpt']) || Aspis_empty($_REQUEST[0]['excerpt'])))
 $post_excerpt = esc_html(stripslashes(deAspisWarningRC($_REQUEST[0]['excerpt'])));
$post->ID = 0;
$post->post_name = '';
$post->post_author = '';
$post->post_date = '';
$post->post_date_gmt = '';
$post->post_password = '';
$post->post_status = 'draft';
$post->post_type = 'post';
$post->to_ping = '';
$post->pinged = '';
$post->comment_status = get_option('default_comment_status');
$post->ping_status = get_option('default_ping_status');
$post->post_pingback = get_option('default_pingback_flag');
$post->post_category = get_option('default_category');
$post->post_content = apply_filters('default_content',$post_content);
$post->post_title = apply_filters('default_title',$post_title);
$post->post_excerpt = apply_filters('default_excerpt',$post_excerpt);
$post->page_template = 'default';
$post->post_parent = 0;
$post->menu_order = 0;
{$AspisRetTemp = $post;
return $AspisRetTemp;
} }
function get_default_page_to_edit (  ) {
$page = get_default_post_to_edit();
$page->post_type = 'page';
{$AspisRetTemp = $page;
return $AspisRetTemp;
} }
function get_post_to_edit ( $id ) {
$post = get_post($id,OBJECT,'edit');
if ( $post->post_type == 'page')
 $post->page_template = get_post_meta($id,'_wp_page_template',true);
{$AspisRetTemp = $post;
return $AspisRetTemp;
} }
function post_exists ( $title,$content = '',$date = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post_title = stripslashes(sanitize_post_field('post_title',$title,0,'db'));
$post_content = stripslashes(sanitize_post_field('post_content',$content,0,'db'));
$post_date = stripslashes(sanitize_post_field('post_date',$date,0,'db'));
$query = "SELECT ID FROM $wpdb->posts WHERE 1=1";
$args = array();
if ( !empty($date))
 {$query .= ' AND post_date = %s';
$args[] = $post_date;
}if ( !empty($title))
 {$query .= ' AND post_title = %s';
$args[] = $post_title;
}if ( !empty($content))
 {$query .= 'AND post_content = %s';
$args[] = $post_content;
}if ( !empty($args))
 {$AspisRetTemp = $wpdb->get_var($wpdb->prepare($query,$args));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_write_post (  ) {
{global $user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $user_ID,"\$user_ID",$AspisChangesCache);
}if ( 'page' == deAspisWarningRC($_POST[0]['post_type']))
 {if ( !current_user_can('edit_pages'))
 {$AspisRetTemp = new WP_Error('edit_pages',__('You are not allowed to create pages on this blog.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{if ( !current_user_can('edit_posts'))
 {$AspisRetTemp = new WP_Error('edit_posts',__('You are not allowed to create posts or drafts on this blog.'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}}}$temp_id = false;
if ( (isset($_POST[0]['temp_ID']) && Aspis_isset($_POST[0]['temp_ID'])))
 {$temp_id = (int)deAspisWarningRC($_POST[0]['temp_ID']);
if ( !$draft_ids = get_user_option('autosave_draft_ids'))
 $draft_ids = array();
foreach ( $draft_ids as $temp =>$real )
if ( time() + $temp > 86400)
 unset($draft_ids[$temp]);
if ( isset($draft_ids[$temp_id]))
 {$_POST[0]['post_ID'] = attAspisRCO($draft_ids[$temp_id]);
unset($_POST[0]['temp_ID']);
update_user_option($user_ID,'autosave_draft_ids',$draft_ids);
{$AspisRetTemp = edit_post();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}}}$translated = _wp_translate_postdata(false);
if ( is_wp_error($translated))
 {$AspisRetTemp = $translated;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}if ( (isset($_POST[0]['visibility']) && Aspis_isset($_POST[0]['visibility'])))
 {switch ( deAspisWarningRC($_POST[0]['visibility']) ) {
case 'public':$_POST[0]['post_password'] = attAspisRCO('');
break ;
case 'password':unset($_POST[0]['sticky']);
break ;
case 'private':$_POST[0]['post_status'] = attAspisRCO('private');
$_POST[0]['post_password'] = attAspisRCO('');
unset($_POST[0]['sticky']);
break ;
 }
}$post_ID = wp_insert_post(deAspisWarningRC($_POST));
if ( is_wp_error($post_ID))
 {$AspisRetTemp = $post_ID;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}if ( empty($post_ID))
 {$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}add_meta($post_ID);
if ( !$draft_ids = get_user_option('autosave_draft_ids'))
 $draft_ids = array();
if ( $draft_temp_id = (int)array_search($post_ID,$draft_ids))
 _relocate_children($draft_temp_id,$post_ID);
if ( $temp_id && $temp_id != $draft_temp_id)
 _relocate_children($temp_id,$post_ID);
if ( $temp_id)
 {$draft_ids[$temp_id] = $post_ID;
update_user_option($user_ID,'autosave_draft_ids',$draft_ids);
}_fix_attachment_links($post_ID);
wp_set_post_lock($post_ID,$GLOBALS[0]['current_user']->ID);
{$AspisRetTemp = $post_ID;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
 }
function write_post (  ) {
$result = wp_write_post();
if ( is_wp_error($result))
 wp_die($result->get_error_message());
else 
{{$AspisRetTemp = $result;
return $AspisRetTemp;
}} }
function add_meta ( $post_ID ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post_ID = (int)$post_ID;
$protected = array('_wp_attached_file','_wp_attachment_metadata','_wp_old_slug','_wp_page_template');
$metakeyselect = (isset($_POST[0]['metakeyselect']) && Aspis_isset($_POST[0]['metakeyselect'])) ? stripslashes(trim(deAspisWarningRC($_POST[0]['metakeyselect']))) : '';
$metakeyinput = (isset($_POST[0]['metakeyinput']) && Aspis_isset($_POST[0]['metakeyinput'])) ? stripslashes(trim(deAspisWarningRC($_POST[0]['metakeyinput']))) : '';
$metavalue = (isset($_POST[0]['metavalue']) && Aspis_isset($_POST[0]['metavalue'])) ? maybe_serialize(stripslashes_deep(deAspisWarningRC($_POST[0]['metavalue']))) : '';
if ( is_string($metavalue))
 $metavalue = trim($metavalue);
if ( ('0' === $metavalue || !empty($metavalue)) && ((('#NONE#' != $metakeyselect) && !empty($metakeyselect)) || !empty($metakeyinput)))
 {if ( '#NONE#' != $metakeyselect)
 $metakey = $metakeyselect;
if ( $metakeyinput)
 $metakey = $metakeyinput;
if ( in_array($metakey,$protected))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}wp_cache_delete($post_ID,'post_meta');
$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->postmeta (post_id,meta_key,meta_value ) VALUES (%s, %s, %s)",$post_ID,$metakey,$metavalue));
do_action('added_postmeta',$wpdb->insert_id,$post_ID,$metakey,$metavalue);
{$AspisRetTemp = $wpdb->insert_id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function delete_meta ( $mid ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$mid = (int)$mid;
$post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_id = %d",$mid));
do_action('delete_postmeta',$mid);
wp_cache_delete($post_id,'post_meta');
$rval = $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE meta_id = %d",$mid));
do_action('deleted_postmeta',$mid);
{$AspisRetTemp = $rval;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_meta_keys (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$keys = $wpdb->get_col("
			SELECT meta_key
			FROM $wpdb->postmeta
			GROUP BY meta_key
			ORDER BY meta_key");
{$AspisRetTemp = $keys;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_post_meta_by_id ( $mid ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$mid = (int)$mid;
$meta = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->postmeta WHERE meta_id = %d",$mid));
if ( is_serialized_string($meta->meta_value))
 $meta->meta_value = maybe_unserialize($meta->meta_value);
{$AspisRetTemp = $meta;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function has_meta ( $postid ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}{$AspisRetTemp = $wpdb->get_results($wpdb->prepare("SELECT meta_key, meta_value, meta_id, post_id
			FROM $wpdb->postmeta WHERE post_id = %d
			ORDER BY meta_key,meta_id",$postid),ARRAY_A);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function update_meta ( $meta_id,$meta_key,$meta_value ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$protected = array('_wp_attached_file','_wp_attachment_metadata','_wp_old_slug','_wp_page_template');
if ( in_array($meta_key,$protected))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( '' === trim($meta_value))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_id = %d",$meta_id));
$meta_value = maybe_serialize(stripslashes_deep($meta_value));
$meta_id = (int)$meta_id;
$data = compact('meta_key','meta_value');
$where = compact('meta_id');
do_action('update_postmeta',$meta_id,$post_id,$meta_key,$meta_value);
$rval = $wpdb->update($wpdb->postmeta,$data,$where);
wp_cache_delete($post_id,'post_meta');
do_action('updated_postmeta',$meta_id,$post_id,$meta_key,$meta_value);
{$AspisRetTemp = $rval;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function _fix_attachment_links ( $post_ID ) {
{global $_fix_attachment_link_id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_fix_attachment_link_id,"\$_fix_attachment_link_id",$AspisChangesCache);
}$post = &get_post($post_ID,ARRAY_A);
$search = "#<a[^>]+rel=('|\")[^'\"]*attachment[^>]*>#ie";
if ( 0 == preg_match_all($search,$post['post_content'],$anchor_matches,PREG_PATTERN_ORDER))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_fix_attachment_link_id",$AspisChangesCache);
return ;
}$i = 0;
$search = "#[\s]+rel=(\"|')(.*?)wp-att-(\d+)\\1#i";
foreach ( $anchor_matches[0] as $anchor  )
{if ( 0 == preg_match($search,$anchor,$id_matches))
 continue ;
$id = (int)$id_matches[3];
$attachment = &get_post($id,ARRAY_A);
if ( !empty($attachment) && !is_object(get_post($attachment['post_parent'])))
 {$attachment['post_parent'] = $post_ID;
$attachment = deAspisWarningRC(add_magic_quotes(attAspisRCO($attachment)));
wp_update_post($attachment);
}$post_search[$i] = $anchor;
$_fix_attachment_link_id = $id;
$post_replace[$i] = preg_replace_callback("#href=(\"|')[^'\"]*\\1#",'_fix_attachment_links_replace_cb',$anchor);
++$i;
}$post['post_content'] = str_replace($post_search,$post_replace,$post['post_content']);
$post = deAspisWarningRC(add_magic_quotes(attAspisRCO($post)));
{$AspisRetTemp = wp_update_post($post);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_fix_attachment_link_id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_fix_attachment_link_id",$AspisChangesCache);
 }
function _fix_attachment_links_replace_cb ( $match ) {
{global $_fix_attachment_link_id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_fix_attachment_link_id,"\$_fix_attachment_link_id",$AspisChangesCache);
}{$AspisRetTemp = stripslashes('href=' . $match[1]) . get_attachment_link($_fix_attachment_link_id) . stripslashes($match[1]);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_fix_attachment_link_id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_fix_attachment_link_id",$AspisChangesCache);
 }
function _relocate_children ( $old_ID,$new_ID ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$old_ID = (int)$old_ID;
$new_ID = (int)$new_ID;
$children = $wpdb->get_col($wpdb->prepare("
		SELECT post_id
		FROM $wpdb->postmeta
		WHERE meta_key = '_wp_attachment_temp_parent'
		AND meta_value = %d",$old_ID));
foreach ( $children as $child_id  )
{$wpdb->update($wpdb->posts,array('post_parent' => $new_ID),array('ID' => $child_id));
delete_post_meta($child_id,'_wp_attachment_temp_parent');
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_available_post_statuses ( $type = 'post' ) {
$stati = wp_count_posts($type);
{$AspisRetTemp = array_keys(get_object_vars($stati));
return $AspisRetTemp;
} }
function wp_edit_posts_query ( $q = false ) {
if ( false === $q)
 $q = deAspisWarningRC($_GET);
$q['m'] = isset($q['m']) ? (int)$q['m'] : 0;
$q['cat'] = isset($q['cat']) ? (int)$q['cat'] : 0;
$post_stati = array('publish' => array(_x('Published','post'),__('Published posts'),_n_noop('Published <span class="count">(%s)</span>','Published <span class="count">(%s)</span>')),'future' => array(_x('Scheduled','post'),__('Scheduled posts'),_n_noop('Scheduled <span class="count">(%s)</span>','Scheduled <span class="count">(%s)</span>')),'pending' => array(_x('Pending Review','post'),__('Pending posts'),_n_noop('Pending Review <span class="count">(%s)</span>','Pending Review <span class="count">(%s)</span>')),'draft' => array(_x('Draft','post'),_x('Drafts','manage posts header'),_n_noop('Draft <span class="count">(%s)</span>','Drafts <span class="count">(%s)</span>')),'private' => array(_x('Private','post'),__('Private posts'),_n_noop('Private <span class="count">(%s)</span>','Private <span class="count">(%s)</span>')),'trash' => array(_x('Trash','post'),__('Trash posts'),_n_noop('Trash <span class="count">(%s)</span>','Trash <span class="count">(%s)</span>')),);
$post_stati = apply_filters('post_stati',$post_stati);
$avail_post_stati = get_available_post_statuses('post');
$post_status_q = '';
if ( isset($q['post_status']) && in_array($q['post_status'],array_keys($post_stati)))
 {$post_status_q = '&post_status=' . $q['post_status'];
$post_status_q .= '&perm=readable';
}if ( isset($q['post_status']) && 'pending' === $q['post_status'])
 {$order = 'ASC';
$orderby = 'modified';
}elseif ( isset($q['post_status']) && 'draft' === $q['post_status'])
 {$order = 'DESC';
$orderby = 'modified';
}else 
{{$order = 'DESC';
$orderby = 'date';
}}$posts_per_page = (int)get_user_option('edit_per_page',0,false);
if ( empty($posts_per_page) || $posts_per_page < 1)
 $posts_per_page = 15;
$posts_per_page = apply_filters('edit_posts_per_page',$posts_per_page);
wp("post_type=post&$post_status_q&posts_per_page=$posts_per_page&order=$order&orderby=$orderby");
{$AspisRetTemp = array($post_stati,$avail_post_stati);
return $AspisRetTemp;
} }
function get_post_mime_types (  ) {
$post_mime_types = array('image' => array(__('Images'),__('Manage Images'),_n_noop('Image <span class="count">(%s)</span>','Images <span class="count">(%s)</span>')),'audio' => array(__('Audio'),__('Manage Audio'),_n_noop('Audio <span class="count">(%s)</span>','Audio <span class="count">(%s)</span>')),'video' => array(__('Video'),__('Manage Video'),_n_noop('Video <span class="count">(%s)</span>','Video <span class="count">(%s)</span>')),);
{$AspisRetTemp = apply_filters('post_mime_types',$post_mime_types);
return $AspisRetTemp;
} }
function get_available_post_mime_types ( $type = 'attachment' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$types = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT post_mime_type FROM $wpdb->posts WHERE post_type = %s",$type));
{$AspisRetTemp = $types;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_edit_attachments_query ( $q = false ) {
if ( false === $q)
 $q = deAspisWarningRC($_GET);
$q['m'] = isset($q['m']) ? (int)$q['m'] : 0;
$q['cat'] = isset($q['cat']) ? (int)$q['cat'] : 0;
$q['post_type'] = 'attachment';
$q['post_status'] = isset($q['status']) && 'trash' == $q['status'] ? 'trash' : 'inherit';
$media_per_page = (int)get_user_option('upload_per_page',0,false);
if ( empty($media_per_page) || $media_per_page < 1)
 $media_per_page = 20;
$q['posts_per_page'] = apply_filters('upload_per_page',$media_per_page);
$post_mime_types = get_post_mime_types();
$avail_post_mime_types = get_available_post_mime_types('attachment');
if ( isset($q['post_mime_type']) && !array_intersect((array)$q['post_mime_type'],array_keys($post_mime_types)))
 unset($q['post_mime_type']);
wp($q);
{$AspisRetTemp = array($post_mime_types,$avail_post_mime_types);
return $AspisRetTemp;
} }
function postbox_classes ( $id,$page ) {
if ( (isset($_GET[0]['edit']) && Aspis_isset($_GET[0]['edit'])) && deAspisWarningRC($_GET[0]['edit']) == $id)
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$current_user = wp_get_current_user();
if ( $closed = get_user_option('closedpostboxes_' . $page,0,false))
 {if ( !is_array($closed))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = in_array($id,$closed) ? 'closed' : '';
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = '';
return $AspisRetTemp;
}}} }
function get_sample_permalink ( $id,$title = null,$name = null ) {
$post = &get_post($id);
if ( !$post->ID)
 {{$AspisRetTemp = array('','');
return $AspisRetTemp;
}}$original_status = $post->post_status;
$original_date = $post->post_date;
$original_name = $post->post_name;
if ( in_array($post->post_status,array('draft','pending')))
 {$post->post_status = 'publish';
$post->post_name = sanitize_title($post->post_name ? $post->post_name : $post->post_title,$post->ID);
}$post->post_name = wp_unique_post_slug($post->post_name,$post->ID,$post->post_status,$post->post_type,$post->post_parent);
if ( !is_null($name))
 {$post->post_name = sanitize_title($name ? $name : $title,$post->ID);
}$post->filter = 'sample';
$permalink = get_permalink($post,true);
if ( 'page' == $post->post_type)
 {$uri = get_page_uri($post->ID);
$uri = untrailingslashit($uri);
$uri = strrev(stristr(strrev($uri),'/'));
$uri = untrailingslashit($uri);
if ( !empty($uri))
 $uri .= '/';
$permalink = str_replace('%pagename%',"${uri}%pagename%",$permalink);
}$permalink = array($permalink,apply_filters('editable_slug',$post->post_name));
$post->post_status = $original_status;
$post->post_date = $original_date;
$post->post_name = $original_name;
unset($post->filter);
{$AspisRetTemp = $permalink;
return $AspisRetTemp;
} }
function get_sample_permalink_html ( $id,$new_title = null,$new_slug = null ) {
$post = &get_post($id);
list($permalink,$post_name) = get_sample_permalink($post->ID,$new_title,$new_slug);
if ( 'publish' == $post->post_status)
 {$view_post = 'post' == $post->post_type ? __('View Post') : __('View Page');
$title = __('Click to edit this part of the permalink');
}else 
{{$title = __('Temporary permalink. Click to edit this part.');
}}if ( false === strpos($permalink,'%postname%') && false === strpos($permalink,'%pagename%'))
 {$return = '<strong>' . __('Permalink:') . "</strong>\n" . '<span id="sample-permalink">' . $permalink . "</span>\n";
if ( current_user_can('manage_options') && !('page' == get_option('show_on_front') && $id == get_option('page_on_front')))
 $return .= '<span id="change-permalinks"><a href="options-permalink.php" class="button" target="_blank">' . __('Change Permalinks') . "</a></span>\n";
if ( isset($view_post))
 $return .= "<span id='view-post-btn'><a href='$permalink' class='button' target='_blank'>$view_post</a></span>\n";
$return = apply_filters('get_sample_permalink_html',$return,$id,$new_title,$new_slug);
{$AspisRetTemp = $return;
return $AspisRetTemp;
}}if ( function_exists('mb_strlen'))
 {if ( mb_strlen($post_name) > 30)
 {$post_name_abridged = mb_substr($post_name,0,14) . '&hellip;' . mb_substr($post_name,-14);
}else 
{{$post_name_abridged = $post_name;
}}}else 
{{if ( strlen($post_name) > 30)
 {$post_name_abridged = substr($post_name,0,14) . '&hellip;' . substr($post_name,-14);
}else 
{{$post_name_abridged = $post_name;
}}}}$post_name_html = '<span id="editable-post-name" title="' . $title . '">' . $post_name_abridged . '</span>';
$display_link = str_replace(array('%pagename%','%postname%'),$post_name_html,$permalink);
$view_link = str_replace(array('%pagename%','%postname%'),$post_name,$permalink);
$return = '<strong>' . __('Permalink:') . "</strong>\n" . '<span id="sample-permalink">' . $display_link . "</span>\n";
$return .= '<span id="edit-slug-buttons"><a href="#post_name" class="edit-slug button hide-if-no-js" onclick="editPermalink(' . $id . '); return false;">' . __('Edit') . "</a></span>\n";
$return .= '<span id="editable-post-name-full">' . $post_name . "</span>\n";
if ( isset($view_post))
 $return .= "<span id='view-post-btn'><a href='$view_link' class='button' target='_blank'>$view_post</a></span>\n";
$return = apply_filters('get_sample_permalink_html',$return,$id,$new_title,$new_slug);
{$AspisRetTemp = $return;
return $AspisRetTemp;
} }
function _wp_post_thumbnail_html ( $thumbnail_id = NULL ) {
{global $content_width,$_wp_additional_image_sizes;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $content_width,"\$content_width",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($_wp_additional_image_sizes,"\$_wp_additional_image_sizes",$AspisChangesCache);
}$content = '<p class="hide-if-no-js"><a href="#" id="set-post-thumbnail" onclick="jQuery(\'#add_image\').click();return false;">' . esc_html__('Set thumbnail') . '</a></p>';
if ( $thumbnail_id && get_post($thumbnail_id))
 {$old_content_width = $content_width;
$content_width = 266;
if ( !isset($_wp_additional_image_sizes['post-thumbnail']))
 $thumbnail_html = wp_get_attachment_image($thumbnail_id,array($content_width,$content_width));
else 
{$thumbnail_html = wp_get_attachment_image($thumbnail_id,'post-thumbnail');
}if ( !empty($thumbnail_html))
 {$content = '<a href="#" id="set-post-thumbnail" onclick="jQuery(\'#add_image\').click();return false;">' . $thumbnail_html . '</a>';
$content .= '<p class="hide-if-no-js"><a href="#" id="remove-post-thumbnail" onclick="WPRemoveThumbnail();return false;">' . esc_html__('Remove thumbnail') . '</a></p>';
}$content_width = $old_content_width;
}{$AspisRetTemp = apply_filters('admin_post_thumbnail_html',$content);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$content_width",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$_wp_additional_image_sizes",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$content_width",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$_wp_additional_image_sizes",$AspisChangesCache);
 }
function wp_check_post_lock ( $post_id ) {
{global $current_user;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $current_user,"\$current_user",$AspisChangesCache);
}if ( !$post = get_post($post_id))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}$lock = get_post_meta($post->ID,'_edit_lock',true);
$last = get_post_meta($post->ID,'_edit_last',true);
$time_window = apply_filters('wp_check_post_lock_window',AUTOSAVE_INTERVAL * 2);
if ( $lock && $lock > time() - $time_window && $last != $current_user->ID)
 {$AspisRetTemp = $last;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
 }
function wp_set_post_lock ( $post_id ) {
{global $current_user;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $current_user,"\$current_user",$AspisChangesCache);
}if ( !$post = get_post($post_id))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}if ( !$current_user || !$current_user->ID)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}$now = time();
if ( !add_post_meta($post->ID,'_edit_lock',$now,true))
 update_post_meta($post->ID,'_edit_lock',$now);
if ( !add_post_meta($post->ID,'_edit_last',$current_user->ID,true))
 update_post_meta($post->ID,'_edit_last',$current_user->ID);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
 }
function _admin_notice_post_locked (  ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$last_user = get_userdata(get_post_meta($post->ID,'_edit_last',true));
$last_user_name = $last_user ? $last_user->display_name : __('Somebody');
switch ( $post->post_type ) {
case 'post':$message = __('Warning: %s is currently editing this post');
break ;
case 'page':$message = __('Warning: %s is currently editing this page');
break ;
default :$message = __('Warning: %s is currently editing this.');
 }
$message = sprintf($message,esc_html($last_user_name));
echo "<div class='error'><p>$message</p></div>";
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function wp_create_post_autosave ( $post_id ) {
$translated = _wp_translate_postdata(true);
if ( is_wp_error($translated))
 {$AspisRetTemp = $translated;
return $AspisRetTemp;
}if ( $old_autosave = wp_get_post_autosave($post_id))
 {$new_autosave = _wp_post_revision_fields(deAspisWarningRC($_POST),true);
$new_autosave['ID'] = $old_autosave->ID;
$current_user = wp_get_current_user();
$new_autosave['post_author'] = $current_user->ID;
{$AspisRetTemp = wp_update_post($new_autosave);
return $AspisRetTemp;
}}$_POST = attAspisRCO(stripslashes_deep(deAspisWarningRC($_POST)));
{$AspisRetTemp = _wp_put_post_revision(deAspisWarningRC($_POST),true);
return $AspisRetTemp;
} }
function post_preview (  ) {
$post_ID = (int)deAspisWarningRC($_POST[0]['post_ID']);
if ( $post_ID < 1)
 wp_die(__('Preview not available. Please save as a draft first.'));
if ( (isset($_POST[0]['catslist']) && Aspis_isset($_POST[0]['catslist'])))
 $_POST[0]['post_category'] = attAspisRCO(explode(",",deAspisWarningRC($_POST[0]['catslist'])));
if ( (isset($_POST[0]['tags_input']) && Aspis_isset($_POST[0]['tags_input'])))
 $_POST[0]['tags_input'] = attAspisRCO(explode(",",deAspisWarningRC($_POST[0]['tags_input'])));
if ( deAspisWarningRC($_POST[0]['post_type']) == 'page' || (empty($_POST[0]['post_category']) || Aspis_empty($_POST[0]['post_category'])))
 unset($_POST[0]['post_category']);
$_POST[0]['ID'] = attAspisRCO($post_ID);
$post = get_post($post_ID);
if ( 'page' == $post->post_type)
 {if ( !current_user_can('edit_page',$post_ID))
 wp_die(__('You are not allowed to edit this page.'));
}else 
{{if ( !current_user_can('edit_post',$post_ID))
 wp_die(__('You are not allowed to edit this post.'));
}}if ( 'draft' == $post->post_status)
 {$id = edit_post();
}else 
{{$id = wp_create_post_autosave($post->ID);
if ( !is_wp_error($id))
 $id = $post->ID;
}}if ( is_wp_error($id))
 wp_die($id->get_error_message());
if ( deAspisWarningRC($_POST[0]['post_status']) == 'draft')
 {$url = add_query_arg('preview','true',get_permalink($id));
}else 
{{$nonce = wp_create_nonce('post_preview_' . $id);
$url = add_query_arg(array('preview' => 'true','preview_id' => $id,'preview_nonce' => $nonce),get_permalink($id));
}}{$AspisRetTemp = $url;
return $AspisRetTemp;
} }
function wp_tiny_mce ( $teeny = false,$settings = false ) {
{global $concatenate_scripts,$compress_scripts,$tinymce_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $concatenate_scripts,"\$concatenate_scripts",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($compress_scripts,"\$compress_scripts",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($tinymce_version,"\$tinymce_version",$AspisChangesCache);
}if ( !user_can_richedit())
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$concatenate_scripts",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$compress_scripts",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$tinymce_version",$AspisChangesCache);
return ;
}$baseurl = includes_url('js/tinymce');
$mce_locale = ('' == get_locale()) ? 'en' : strtolower(substr(get_locale(),0,2));
$mce_spellchecker_languages = apply_filters('mce_spellchecker_languages','+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv');
if ( $teeny)
 {$plugins = apply_filters('teeny_mce_plugins',array('safari','inlinepopups','media','fullscreen','wordpress'));
$ext_plugins = '';
}else 
{{$plugins = array('safari','inlinepopups','spellchecker','paste','wordpress','media','fullscreen','wpeditimage','wpgallery','tabfocus');
$mce_external_plugins = apply_filters('mce_external_plugins',array());
$ext_plugins = '';
if ( !empty($mce_external_plugins))
 {$mce_external_languages = apply_filters('mce_external_languages',array());
$loaded_langs = array();
$strings = '';
if ( !empty($mce_external_languages))
 {foreach ( $mce_external_languages as $name =>$path )
{if ( @is_file($path) && @is_readable($path))
 {include_once ($path);
$ext_plugins .= $strings . "\n";
$loaded_langs[] = $name;
}}}foreach ( $mce_external_plugins as $name =>$url )
{if ( is_ssl())
 $url = str_replace('http://','https://',$url);
$plugins[] = '-' . $name;
$plugurl = dirname($url);
$strings = $str1 = $str2 = '';
if ( !in_array($name,$loaded_langs))
 {$path = str_replace(WP_PLUGIN_URL,'',$plugurl);
$path = WP_PLUGIN_DIR . $path . '/langs/';
if ( function_exists('realpath'))
 $path = trailingslashit(realpath($path));
if ( @is_file($path . $mce_locale . '.js'))
 $strings .= @file_get_contents($path . $mce_locale . '.js') . "\n";
if ( @is_file($path . $mce_locale . '_dlg.js'))
 $strings .= @file_get_contents($path . $mce_locale . '_dlg.js') . "\n";
if ( 'en' != $mce_locale && empty($strings))
 {if ( @is_file($path . 'en.js'))
 {$str1 = @file_get_contents($path . 'en.js');
$strings .= preg_replace('/([\'"])en\./','$1' . $mce_locale . '.',$str1,1) . "\n";
}if ( @is_file($path . 'en_dlg.js'))
 {$str2 = @file_get_contents($path . 'en_dlg.js');
$strings .= preg_replace('/([\'"])en\./','$1' . $mce_locale . '.',$str2,1) . "\n";
}}if ( !empty($strings))
 $ext_plugins .= "\n" . $strings . "\n";
}$ext_plugins .= 'tinyMCEPreInit.load_ext("' . $plugurl . '", "' . $mce_locale . '");' . "\n";
$ext_plugins .= 'tinymce.PluginManager.load("' . $name . '", "' . $url . '");' . "\n";
}}}}$plugins = implode($plugins,',');
if ( $teeny)
 {$mce_buttons = apply_filters('teeny_mce_buttons',array('bold, italic, underline, blockquote, separator, strikethrough, bullist, numlist,justifyleft, justifycenter, justifyright, undo, redo, link, unlink, fullscreen'));
$mce_buttons = implode($mce_buttons,',');
$mce_buttons_2 = $mce_buttons_3 = $mce_buttons_4 = '';
}else 
{{$mce_buttons = apply_filters('mce_buttons',array('bold','italic','strikethrough','|','bullist','numlist','blockquote','|','justifyleft','justifycenter','justifyright','|','link','unlink','wp_more','|','spellchecker','fullscreen','wp_adv'));
$mce_buttons = implode($mce_buttons,',');
$mce_buttons_2 = apply_filters('mce_buttons_2',array('formatselect','underline','justifyfull','forecolor','|','pastetext','pasteword','removeformat','|','media','charmap','|','outdent','indent','|','undo','redo','wp_help'));
$mce_buttons_2 = implode($mce_buttons_2,',');
$mce_buttons_3 = apply_filters('mce_buttons_3',array());
$mce_buttons_3 = implode($mce_buttons_3,',');
$mce_buttons_4 = apply_filters('mce_buttons_4',array());
$mce_buttons_4 = implode($mce_buttons_4,',');
}}$no_captions = (apply_filters('disable_captions','')) ? true : false;
$initArray = array('mode' => 'specific_textareas','editor_selector' => 'theEditor','width' => '100%','theme' => 'advanced','skin' => 'wp_theme','theme_advanced_buttons1' => "$mce_buttons",'theme_advanced_buttons2' => "$mce_buttons_2",'theme_advanced_buttons3' => "$mce_buttons_3",'theme_advanced_buttons4' => "$mce_buttons_4",'language' => "$mce_locale",'spellchecker_languages' => "$mce_spellchecker_languages",'theme_advanced_toolbar_location' => 'top','theme_advanced_toolbar_align' => 'left','theme_advanced_statusbar_location' => 'bottom','theme_advanced_resizing' => true,'theme_advanced_resize_horizontal' => false,'dialog_type' => 'modal','relative_urls' => false,'remove_script_host' => false,'convert_urls' => false,'apply_source_formatting' => false,'remove_linebreaks' => true,'gecko_spellcheck' => true,'entities' => '38,amp,60,lt,62,gt','accessibility_focus' => true,'tabfocus_elements' => 'major-publishing-actions','media_strict' => false,'paste_remove_styles' => true,'paste_remove_spans' => true,'paste_strip_class_attributes' => 'all','wpeditimage_disable_captions' => $no_captions,'plugins' => "$plugins");
$mce_css = trim(apply_filters('mce_css',''),' ,');
if ( !empty($mce_css))
 $initArray['content_css'] = "$mce_css";
if ( is_array($settings))
 $initArray = array_merge($initArray,$settings);
if ( $teeny)
 {$initArray = apply_filters('teeny_mce_before_init',$initArray);
}else 
{{$initArray = apply_filters('tiny_mce_before_init',$initArray);
}}if ( empty($initArray['theme_advanced_buttons3']) && !empty($initArray['theme_advanced_buttons4']))
 {$initArray['theme_advanced_buttons3'] = $initArray['theme_advanced_buttons4'];
$initArray['theme_advanced_buttons4'] = '';
}if ( !isset($concatenate_scripts))
 script_concat_settings();
$language = $initArray['language'];
$zip = $compress_scripts ? 1 : 0;
$version = apply_filters('tiny_mce_version','');
$version = 'ver=' . $tinymce_version . $version;
if ( 'en' != $language)
 include_once (ABSPATH . WPINC . '/js/tinymce/langs/wp-langs.php');
$mce_options = '';
foreach ( $initArray as $k =>$v )
$mce_options .= $k . ':"' . $v . '", ';
$mce_options = rtrim(trim($mce_options),'\n\r,');
;
?>

<script type="text/javascript">
/* <![CDATA[ */
tinyMCEPreInit = {
	base : "<?php echo $baseurl;
;
?>",
	suffix : "",
	query : "<?php echo $version;
;
?>",
	mceInit : {<?php echo $mce_options;
;
?>},
	load_ext : function(url,lang){var sl=tinymce.ScriptLoader;sl.markDone(url+'/langs/'+lang+'.js');sl.markDone(url+'/langs/'+lang+'_dlg.js');}
};
/* ]]> */
</script>

<?php if ( $concatenate_scripts)
 echo "<script type='text/javascript' src='$baseurl/wp-tinymce.php?c=$zip&amp;
$version'></script>\n";
else 
{echo "<script type='text/javascript' src='$baseurl/tiny_mce.js?$version'></script>\n";
}if ( 'en' != $language && isset($lang))
 echo "<script type='text/javascript'>\n$lang\n</script>\n";
else 
{echo "<script type='text/javascript' src='$baseurl/langs/wp-langs-en.js?$version'></script>\n";
};
?>

<script type="text/javascript">
/* <![CDATA[ */
<?php if ( $ext_plugins)
 echo "$ext_plugins\n";
;
?>
<?php if ( $concatenate_scripts)
 {;
?>
tinyMCEPreInit.go();
<?php }else 
{{;
?>
(function(){var t=tinyMCEPreInit,sl=tinymce.ScriptLoader,ln=t.mceInit.language,th=t.mceInit.theme,pl=t.mceInit.plugins;sl.markDone(t.base+'/langs/'+ln+'.js');sl.markDone(t.base+'/themes/'+th+'/langs/'+ln+'.js');sl.markDone(t.base+'/themes/'+th+'/langs/'+ln+'_dlg.js');tinymce.each(pl.split(','),function(n){if(n&&n.charAt(0)!='-'){sl.markDone(t.base+'/plugins/'+n+'/langs/'+ln+'.js');sl.markDone(t.base+'/plugins/'+n+'/langs/'+ln+'_dlg.js');}});})();
<?php }};
?>
tinyMCE.init(tinyMCEPreInit.mceInit);
/* ]]> */
</script>
<?php AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$concatenate_scripts",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$compress_scripts",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$tinymce_version",$AspisChangesCache);
 }
