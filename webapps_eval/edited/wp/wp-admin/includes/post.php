<?php require_once('AspisMain.php'); ?><?php
function _wp_translate_postdata ( $update = array(false,false),$post_data = array(null,false) ) {
if ( ((empty($post_data) || Aspis_empty( $post_data))))
 $post_data = &$_POST;
if ( $update[0])
 arrayAssign($post_data[0],deAspis(registerTaint(array('ID',false))),addTaint(int_cast($post_data[0]['post_ID'])));
arrayAssign($post_data[0],deAspis(registerTaint(array('post_content',false))),addTaint(((isset($post_data[0][('content')]) && Aspis_isset( $post_data [0][('content')]))) ? $post_data[0]['content'] : array('',false)));
arrayAssign($post_data[0],deAspis(registerTaint(array('post_excerpt',false))),addTaint(((isset($post_data[0][('excerpt')]) && Aspis_isset( $post_data [0][('excerpt')]))) ? $post_data[0]['excerpt'] : array('',false)));
arrayAssign($post_data[0],deAspis(registerTaint(array('post_parent',false))),addTaint(((isset($post_data[0][('parent_id')]) && Aspis_isset( $post_data [0][('parent_id')]))) ? $post_data[0]['parent_id'] : array('',false)));
if ( ((isset($post_data[0][('trackback_url')]) && Aspis_isset( $post_data [0][('trackback_url')]))))
 arrayAssign($post_data[0],deAspis(registerTaint(array('to_ping',false))),addTaint($post_data[0]['trackback_url']));
if ( (!((empty($post_data[0][('post_author_override')]) || Aspis_empty( $post_data [0][('post_author_override')])))))
 {arrayAssign($post_data[0],deAspis(registerTaint(array('post_author',false))),addTaint(int_cast($post_data[0]['post_author_override'])));
}else 
{{if ( (!((empty($post_data[0][('post_author')]) || Aspis_empty( $post_data [0][('post_author')])))))
 {arrayAssign($post_data[0],deAspis(registerTaint(array('post_author',false))),addTaint(int_cast($post_data[0]['post_author'])));
}else 
{{arrayAssign($post_data[0],deAspis(registerTaint(array('post_author',false))),addTaint(int_cast($post_data[0]['user_ID'])));
}}}}if ( (((isset($post_data[0][('user_ID')]) && Aspis_isset( $post_data [0][('user_ID')]))) && (deAspis($post_data[0]['post_author']) != deAspis($post_data[0]['user_ID']))))
 {if ( (('page') == deAspis($post_data[0]['post_type'])))
 {if ( (denot_boolean(current_user_can(array('edit_others_pages',false)))))
 {return array(new WP_Error(array('edit_others_pages',false),$update[0] ? __(array('You are not allowed to edit pages as this user.',false)) : __(array('You are not allowed to create pages as this user.',false))),false);
}}else 
{{if ( (denot_boolean(current_user_can(array('edit_others_posts',false)))))
 {return array(new WP_Error(array('edit_others_posts',false),$update[0] ? __(array('You are not allowed to edit posts as this user.',false)) : __(array('You are not allowed to post as this user.',false))),false);
}}}}if ( (((isset($post_data[0][('saveasdraft')]) && Aspis_isset( $post_data [0][('saveasdraft')]))) && (('') != deAspis($post_data[0]['saveasdraft']))))
 arrayAssign($post_data[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('draft',false)));
if ( (((isset($post_data[0][('saveasprivate')]) && Aspis_isset( $post_data [0][('saveasprivate')]))) && (('') != deAspis($post_data[0]['saveasprivate']))))
 arrayAssign($post_data[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('private',false)));
if ( ((((isset($post_data[0][('publish')]) && Aspis_isset( $post_data [0][('publish')]))) && (('') != deAspis($post_data[0]['publish']))) && (deAspis($post_data[0]['post_status']) != ('private'))))
 arrayAssign($post_data[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('publish',false)));
if ( (((isset($post_data[0][('advanced')]) && Aspis_isset( $post_data [0][('advanced')]))) && (('') != deAspis($post_data[0]['advanced']))))
 arrayAssign($post_data[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('draft',false)));
if ( (((isset($post_data[0][('pending')]) && Aspis_isset( $post_data [0][('pending')]))) && (('') != deAspis($post_data[0]['pending']))))
 arrayAssign($post_data[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('pending',false)));
$previous_status = get_post_field(array('post_status',false),((isset($post_data[0][('ID')]) && Aspis_isset( $post_data [0][('ID')]))) ? $post_data[0]['ID'] : $post_data[0]['temp_ID']);
if ( (('page') == deAspis($post_data[0]['post_type'])))
 {$publish_cap = array('publish_pages',false);
$edit_cap = array('edit_published_pages',false);
}else 
{{$publish_cap = array('publish_posts',false);
$edit_cap = array('edit_published_posts',false);
}}if ( (((isset($post_data[0][('post_status')]) && Aspis_isset( $post_data [0][('post_status')]))) && ((('publish') == deAspis($post_data[0]['post_status'])) && (denot_boolean(current_user_can($publish_cap))))))
 if ( (($previous_status[0] != ('publish')) || (denot_boolean(current_user_can($edit_cap)))))
 arrayAssign($post_data[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('pending',false)));
if ( (!((isset($post_data[0][('post_status')]) && Aspis_isset( $post_data [0][('post_status')])))))
 arrayAssign($post_data[0],deAspis(registerTaint(array('post_status',false))),addTaint($previous_status));
if ( (!((isset($post_data[0][('comment_status')]) && Aspis_isset( $post_data [0][('comment_status')])))))
 arrayAssign($post_data[0],deAspis(registerTaint(array('comment_status',false))),addTaint(array('closed',false)));
if ( (!((isset($post_data[0][('ping_status')]) && Aspis_isset( $post_data [0][('ping_status')])))))
 arrayAssign($post_data[0],deAspis(registerTaint(array('ping_status',false))),addTaint(array('closed',false)));
foreach ( (array(array('aa',false),array('mm',false),array('jj',false),array('hh',false),array('mn',false))) as $timeunit  )
{if ( ((!((empty($post_data[0][(deconcat1('hidden_',$timeunit))]) || Aspis_empty( $post_data [0][(deconcat1('hidden_',$timeunit))])))) && (deAspis(attachAspis($post_data,(deconcat1('hidden_',$timeunit)))) != deAspis(attachAspis($post_data,$timeunit[0])))))
 {arrayAssign($post_data[0],deAspis(registerTaint(array('edit_date',false))),addTaint(array('1',false)));
break ;
}}if ( (!((empty($post_data[0][('edit_date')]) || Aspis_empty( $post_data [0][('edit_date')])))))
 {$aa = $post_data[0]['aa'];
$mm = $post_data[0]['mm'];
$jj = $post_data[0]['jj'];
$hh = $post_data[0]['hh'];
$mn = $post_data[0]['mn'];
$ss = $post_data[0]['ss'];
$aa = ($aa[0] <= (0)) ? attAspis(date(('Y'))) : $aa;
$mm = ($mm[0] <= (0)) ? attAspis(date(('n'))) : $mm;
$jj = ($jj[0] > (31)) ? array(31,false) : $jj;
$jj = ($jj[0] <= (0)) ? attAspis(date(('j'))) : $jj;
$hh = ($hh[0] > (23)) ? array($hh[0] - (24),false) : $hh;
$mn = ($mn[0] > (59)) ? array($mn[0] - (60),false) : $mn;
$ss = ($ss[0] > (59)) ? array($ss[0] - (60),false) : $ss;
arrayAssign($post_data[0],deAspis(registerTaint(array('post_date',false))),addTaint(Aspis_sprintf(array("%04d-%02d-%02d %02d:%02d:%02d",false),$aa,$mm,$jj,$hh,$mn,$ss)));
arrayAssign($post_data[0],deAspis(registerTaint(array('post_date_gmt',false))),addTaint(get_gmt_from_date($post_data[0]['post_date'])));
}return $post_data;
 }
function edit_post ( $post_data = array(null,false) ) {
if ( ((empty($post_data) || Aspis_empty( $post_data))))
 $post_data = &$_POST;
$post_ID = int_cast($post_data[0]['post_ID']);
if ( (('page') == deAspis($post_data[0]['post_type'])))
 {if ( (denot_boolean(current_user_can(array('edit_page',false),$post_ID))))
 wp_die(__(array('You are not allowed to edit this page.',false)));
}else 
{{if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 wp_die(__(array('You are not allowed to edit this post.',false)));
}}if ( (('autosave') == deAspis($post_data[0]['action'])))
 {$post = &get_post($post_ID);
$now = attAspis(time());
$then = attAspis(strtotime((deconcat2($post[0]->post_date_gmt,' +0000'))));
$delta = array(AUTOSAVE_INTERVAL / (2),false);
if ( (($now[0] - $then[0]) < $delta[0]))
 return $post_ID;
}$post_data = _wp_translate_postdata(array(true,false),$post_data);
if ( deAspis(is_wp_error($post_data)))
 wp_die($post_data[0]->get_error_message());
if ( ((isset($post_data[0][('visibility')]) && Aspis_isset( $post_data [0][('visibility')]))))
 {switch ( deAspis($post_data[0]['visibility']) ) {
case ('public'):arrayAssign($post_data[0],deAspis(registerTaint(array('post_password',false))),addTaint(array('',false)));
break ;
case ('password'):unset($post_data[0][('sticky')]);
break ;
case ('private'):arrayAssign($post_data[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('private',false)));
arrayAssign($post_data[0],deAspis(registerTaint(array('post_password',false))),addTaint(array('',false)));
unset($post_data[0][('sticky')]);
break ;
 }
}if ( (((isset($post_data[0][('meta')]) && Aspis_isset( $post_data [0][('meta')]))) && deAspis($post_data[0]['meta'])))
 {foreach ( deAspis($post_data[0]['meta']) as $key =>$value )
{restoreTaint($key,$value);
update_meta($key,$value[0]['key'],$value[0]['value']);
}}if ( (((isset($post_data[0][('deletemeta')]) && Aspis_isset( $post_data [0][('deletemeta')]))) && deAspis($post_data[0]['deletemeta'])))
 {foreach ( deAspis($post_data[0]['deletemeta']) as $key =>$value )
{restoreTaint($key,$value);
delete_meta($key);
}}add_meta($post_ID);
wp_update_post($post_data);
if ( (denot_boolean($draft_ids = get_user_option(array('autosave_draft_ids',false)))))
 $draft_ids = array(array(),false);
if ( deAspis($draft_temp_id = int_cast(Aspis_array_search($post_ID,$draft_ids))))
 _relocate_children($draft_temp_id,$post_ID);
_fix_attachment_links($post_ID);
wp_set_post_lock($post_ID,$GLOBALS[0][('current_user')][0]->ID);
if ( deAspis(current_user_can(array('edit_others_posts',false))))
 {if ( (!((empty($post_data[0][('sticky')]) || Aspis_empty( $post_data [0][('sticky')])))))
 stick_post($post_ID);
else 
{unstick_post($post_ID);
}}return $post_ID;
 }
function bulk_edit_posts ( $post_data = array(null,false) ) {
global $wpdb;
if ( ((empty($post_data) || Aspis_empty( $post_data))))
 $post_data = &$_POST;
if ( (((isset($post_data[0][('post_type')]) && Aspis_isset( $post_data [0][('post_type')]))) && (('page') == deAspis($post_data[0]['post_type']))))
 {if ( (denot_boolean(current_user_can(array('edit_pages',false)))))
 wp_die(__(array('You are not allowed to edit pages.',false)));
}else 
{{if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 wp_die(__(array('You are not allowed to edit posts.',false)));
}}if ( (deAspis(negate(array(1,false))) == deAspis($post_data[0]['_status'])))
 {arrayAssign($post_data[0],deAspis(registerTaint(array('post_status',false))),addTaint(array(null,false)));
unset($post_data[0][('post_status')]);
}else 
{{arrayAssign($post_data[0],deAspis(registerTaint(array('post_status',false))),addTaint($post_data[0]['_status']));
}}unset($post_data[0][('_status')]);
$post_IDs = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC(array_cast($post_data[0]['post']))));
$reset = array(array(array('post_author',false),array('post_status',false),array('post_password',false),array('post_parent',false),array('page_template',false),array('comment_status',false),array('ping_status',false),array('keep_private',false),array('tags_input',false),array('post_category',false),array('sticky',false)),false);
foreach ( $reset[0] as $field  )
{if ( (((isset($post_data[0][$field[0]]) && Aspis_isset( $post_data [0][$field[0]]))) && ((('') == deAspis(attachAspis($post_data,$field[0]))) || (deAspis(negate(array(1,false))) == deAspis(attachAspis($post_data,$field[0]))))))
 unset($post_data[0][$field[0]]);
}if ( ((isset($post_data[0][('post_category')]) && Aspis_isset( $post_data [0][('post_category')]))))
 {if ( (is_array(deAspis($post_data[0]['post_category'])) && (!((empty($post_data[0][('post_category')]) || Aspis_empty( $post_data [0][('post_category')]))))))
 $new_cats = attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC($post_data[0]['post_category'])));
else 
{unset($post_data[0][('post_category')]);
}}if ( ((isset($post_data[0][('tags_input')]) && Aspis_isset( $post_data [0][('tags_input')]))))
 {$new_tags = Aspis_preg_replace(array('/\s*,\s*/',false),array(',',false),Aspis_rtrim(Aspis_trim($post_data[0]['tags_input']),array(' ,',false)));
$new_tags = Aspis_explode(array(',',false),$new_tags);
}if ( (((isset($post_data[0][('post_parent')]) && Aspis_isset( $post_data [0][('post_parent')]))) && deAspis(($parent = int_cast($post_data[0]['post_parent'])))))
 {$pages = $wpdb[0]->get_results(concat2(concat1("SELECT ID, post_parent FROM ",$wpdb[0]->posts)," WHERE post_type = 'page'"));
$children = array(array(),false);
for ( $i = array(0,false) ; (($i[0] < (50)) && ($parent[0] > (0))) ; postincr($i) )
{arrayAssignAdd($children[0][],addTaint($parent));
foreach ( $pages[0] as $page  )
{if ( ($page[0]->ID[0] == $parent[0]))
 {$parent = $page[0]->post_parent;
break ;
}}}}$updated = $skipped = $locked = array(array(),false);
foreach ( $post_IDs[0] as $post_ID  )
{if ( (((isset($children) && Aspis_isset( $children))) && deAspis(Aspis_in_array($post_ID,$children))))
 {arrayAssignAdd($skipped[0][],addTaint($post_ID));
continue ;
}if ( deAspis(wp_check_post_lock($post_ID)))
 {arrayAssignAdd($locked[0][],addTaint($post_ID));
continue ;
}if ( ((isset($new_cats) && Aspis_isset( $new_cats))))
 {$cats = array_cast(wp_get_post_categories($post_ID));
arrayAssign($post_data[0],deAspis(registerTaint(array('post_category',false))),addTaint(attAspisRC(array_unique(deAspisRC(Aspis_array_merge($cats,$new_cats))))));
}if ( ((isset($new_tags) && Aspis_isset( $new_tags))))
 {$tags = wp_get_post_tags($post_ID,array(array('fields' => array('names',false,false)),false));
arrayAssign($post_data[0],deAspis(registerTaint(array('tags_input',false))),addTaint(attAspisRC(array_unique(deAspisRC(Aspis_array_merge($tags,$new_tags))))));
}arrayAssign($post_data[0],deAspis(registerTaint(array('ID',false))),addTaint($post_ID));
arrayAssignAdd($updated[0][],addTaint(wp_update_post($post_data)));
if ( (((isset($post_data[0][('sticky')]) && Aspis_isset( $post_data [0][('sticky')]))) && deAspis(current_user_can(array('edit_others_posts',false)))))
 {if ( (('sticky') == deAspis($post_data[0]['sticky'])))
 stick_post($post_ID);
else 
{unstick_post($post_ID);
}}}return array(array(deregisterTaint(array('updated',false)) => addTaint($updated),deregisterTaint(array('skipped',false)) => addTaint($skipped),deregisterTaint(array('locked',false)) => addTaint($locked)),false);
 }
function get_default_post_to_edit (  ) {
$post_title = array('',false);
if ( (!((empty($_REQUEST[0][('post_title')]) || Aspis_empty( $_REQUEST [0][('post_title')])))))
 $post_title = esc_html(Aspis_stripslashes($_REQUEST[0]['post_title']));
$post_content = array('',false);
if ( (!((empty($_REQUEST[0][('content')]) || Aspis_empty( $_REQUEST [0][('content')])))))
 $post_content = esc_html(Aspis_stripslashes($_REQUEST[0]['content']));
$post_excerpt = array('',false);
if ( (!((empty($_REQUEST[0][('excerpt')]) || Aspis_empty( $_REQUEST [0][('excerpt')])))))
 $post_excerpt = esc_html(Aspis_stripslashes($_REQUEST[0]['excerpt']));
$post[0]->ID = array(0,false);
$post[0]->post_name = array('',false);
$post[0]->post_author = array('',false);
$post[0]->post_date = array('',false);
$post[0]->post_date_gmt = array('',false);
$post[0]->post_password = array('',false);
$post[0]->post_status = array('draft',false);
$post[0]->post_type = array('post',false);
$post[0]->to_ping = array('',false);
$post[0]->pinged = array('',false);
$post[0]->comment_status = get_option(array('default_comment_status',false));
$post[0]->ping_status = get_option(array('default_ping_status',false));
$post[0]->post_pingback = get_option(array('default_pingback_flag',false));
$post[0]->post_category = get_option(array('default_category',false));
$post[0]->post_content = apply_filters(array('default_content',false),$post_content);
$post[0]->post_title = apply_filters(array('default_title',false),$post_title);
$post[0]->post_excerpt = apply_filters(array('default_excerpt',false),$post_excerpt);
$post[0]->page_template = array('default',false);
$post[0]->post_parent = array(0,false);
$post[0]->menu_order = array(0,false);
return $post;
 }
function get_default_page_to_edit (  ) {
$page = get_default_post_to_edit();
$page[0]->post_type = array('page',false);
return $page;
 }
function get_post_to_edit ( $id ) {
$post = get_post($id,array(OBJECT,false),array('edit',false));
if ( ($post[0]->post_type[0] == ('page')))
 $post[0]->page_template = get_post_meta($id,array('_wp_page_template',false),array(true,false));
return $post;
 }
function post_exists ( $title,$content = array('',false),$date = array('',false) ) {
global $wpdb;
$post_title = Aspis_stripslashes(sanitize_post_field(array('post_title',false),$title,array(0,false),array('db',false)));
$post_content = Aspis_stripslashes(sanitize_post_field(array('post_content',false),$content,array(0,false),array('db',false)));
$post_date = Aspis_stripslashes(sanitize_post_field(array('post_date',false),$date,array(0,false),array('db',false)));
$query = concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE 1=1");
$args = array(array(),false);
if ( (!((empty($date) || Aspis_empty( $date)))))
 {$query = concat2($query,' AND post_date = %s');
arrayAssignAdd($args[0][],addTaint($post_date));
}if ( (!((empty($title) || Aspis_empty( $title)))))
 {$query = concat2($query,' AND post_title = %s');
arrayAssignAdd($args[0][],addTaint($post_title));
}if ( (!((empty($content) || Aspis_empty( $content)))))
 {$query = concat2($query,'AND post_content = %s');
arrayAssignAdd($args[0][],addTaint($post_content));
}if ( (!((empty($args) || Aspis_empty( $args)))))
 return $wpdb[0]->get_var($wpdb[0]->prepare($query,$args));
return array(0,false);
 }
function wp_write_post (  ) {
global $user_ID;
if ( (('page') == deAspis($_POST[0]['post_type'])))
 {if ( (denot_boolean(current_user_can(array('edit_pages',false)))))
 return array(new WP_Error(array('edit_pages',false),__(array('You are not allowed to create pages on this blog.',false))),false);
}else 
{{if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 return array(new WP_Error(array('edit_posts',false),__(array('You are not allowed to create posts or drafts on this blog.',false))),false);
}}$temp_id = array(false,false);
if ( ((isset($_POST[0][('temp_ID')]) && Aspis_isset( $_POST [0][('temp_ID')]))))
 {$temp_id = int_cast($_POST[0]['temp_ID']);
if ( (denot_boolean($draft_ids = get_user_option(array('autosave_draft_ids',false)))))
 $draft_ids = array(array(),false);
foreach ( $draft_ids[0] as $temp =>$real )
{restoreTaint($temp,$real);
if ( ((time() + $temp[0]) > (86400)))
 unset($draft_ids[0][$temp[0]]);
}if ( ((isset($draft_ids[0][$temp_id[0]]) && Aspis_isset( $draft_ids [0][$temp_id[0]]))))
 {arrayAssign($_POST[0],deAspis(registerTaint(array('post_ID',false))),addTaint(attachAspis($draft_ids,$temp_id[0])));
unset($_POST[0][('temp_ID')]);
update_user_option($user_ID,array('autosave_draft_ids',false),$draft_ids);
return edit_post();
}}$translated = _wp_translate_postdata(array(false,false));
if ( deAspis(is_wp_error($translated)))
 return $translated;
if ( ((isset($_POST[0][('visibility')]) && Aspis_isset( $_POST [0][('visibility')]))))
 {switch ( deAspis($_POST[0]['visibility']) ) {
case ('public'):arrayAssign($_POST[0],deAspis(registerTaint(array('post_password',false))),addTaint(array('',false)));
break ;
case ('password'):unset($_POST[0][('sticky')]);
break ;
case ('private'):arrayAssign($_POST[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('private',false)));
arrayAssign($_POST[0],deAspis(registerTaint(array('post_password',false))),addTaint(array('',false)));
unset($_POST[0][('sticky')]);
break ;
 }
}$post_ID = wp_insert_post($_POST);
if ( deAspis(is_wp_error($post_ID)))
 return $post_ID;
if ( ((empty($post_ID) || Aspis_empty( $post_ID))))
 return array(0,false);
add_meta($post_ID);
if ( (denot_boolean($draft_ids = get_user_option(array('autosave_draft_ids',false)))))
 $draft_ids = array(array(),false);
if ( deAspis($draft_temp_id = int_cast(Aspis_array_search($post_ID,$draft_ids))))
 _relocate_children($draft_temp_id,$post_ID);
if ( ($temp_id[0] && ($temp_id[0] != $draft_temp_id[0])))
 _relocate_children($temp_id,$post_ID);
if ( $temp_id[0])
 {arrayAssign($draft_ids[0],deAspis(registerTaint($temp_id)),addTaint($post_ID));
update_user_option($user_ID,array('autosave_draft_ids',false),$draft_ids);
}_fix_attachment_links($post_ID);
wp_set_post_lock($post_ID,$GLOBALS[0][('current_user')][0]->ID);
return $post_ID;
 }
function write_post (  ) {
$result = wp_write_post();
if ( deAspis(is_wp_error($result)))
 wp_die($result[0]->get_error_message());
else 
{return $result;
} }
function add_meta ( $post_ID ) {
global $wpdb;
$post_ID = int_cast($post_ID);
$protected = array(array(array('_wp_attached_file',false),array('_wp_attachment_metadata',false),array('_wp_old_slug',false),array('_wp_page_template',false)),false);
$metakeyselect = ((isset($_POST[0][('metakeyselect')]) && Aspis_isset( $_POST [0][('metakeyselect')]))) ? Aspis_stripslashes(Aspis_trim($_POST[0]['metakeyselect'])) : array('',false);
$metakeyinput = ((isset($_POST[0][('metakeyinput')]) && Aspis_isset( $_POST [0][('metakeyinput')]))) ? Aspis_stripslashes(Aspis_trim($_POST[0]['metakeyinput'])) : array('',false);
$metavalue = ((isset($_POST[0][('metavalue')]) && Aspis_isset( $_POST [0][('metavalue')]))) ? maybe_serialize(stripslashes_deep($_POST[0]['metavalue'])) : array('',false);
if ( is_string(deAspisRC($metavalue)))
 $metavalue = Aspis_trim($metavalue);
if ( (((('0') === $metavalue[0]) || (!((empty($metavalue) || Aspis_empty( $metavalue))))) && (((('#NONE#') != $metakeyselect[0]) && (!((empty($metakeyselect) || Aspis_empty( $metakeyselect))))) || (!((empty($metakeyinput) || Aspis_empty( $metakeyinput)))))))
 {if ( (('#NONE#') != $metakeyselect[0]))
 $metakey = $metakeyselect;
if ( $metakeyinput[0])
 $metakey = $metakeyinput;
if ( deAspis(Aspis_in_array($metakey,$protected)))
 return array(false,false);
wp_cache_delete($post_ID,array('post_meta',false));
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("INSERT INTO ",$wpdb[0]->postmeta)," (post_id,meta_key,meta_value ) VALUES (%s, %s, %s)"),$post_ID,$metakey,$metavalue));
do_action(array('added_postmeta',false),$wpdb[0]->insert_id,$post_ID,$metakey,$metavalue);
return $wpdb[0]->insert_id;
}return array(false,false);
 }
function delete_meta ( $mid ) {
global $wpdb;
$mid = int_cast($mid);
$post_id = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT post_id FROM ",$wpdb[0]->postmeta)," WHERE meta_id = %d"),$mid));
do_action(array('delete_postmeta',false),$mid);
wp_cache_delete($post_id,array('post_meta',false));
$rval = $wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->postmeta)," WHERE meta_id = %d"),$mid));
do_action(array('deleted_postmeta',false),$mid);
return $rval;
 }
function get_meta_keys (  ) {
global $wpdb;
$keys = $wpdb[0]->get_col(concat2(concat1("
			SELECT meta_key
			FROM ",$wpdb[0]->postmeta),"
			GROUP BY meta_key
			ORDER BY meta_key"));
return $keys;
 }
function get_post_meta_by_id ( $mid ) {
global $wpdb;
$mid = int_cast($mid);
$meta = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->postmeta)," WHERE meta_id = %d"),$mid));
if ( deAspis(is_serialized_string($meta[0]->meta_value)))
 $meta[0]->meta_value = maybe_unserialize($meta[0]->meta_value);
return $meta;
 }
function has_meta ( $postid ) {
global $wpdb;
return $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT meta_key, meta_value, meta_id, post_id
			FROM ",$wpdb[0]->postmeta)," WHERE post_id = %d
			ORDER BY meta_key,meta_id"),$postid),array(ARRAY_A,false));
 }
function update_meta ( $meta_id,$meta_key,$meta_value ) {
global $wpdb;
$protected = array(array(array('_wp_attached_file',false),array('_wp_attachment_metadata',false),array('_wp_old_slug',false),array('_wp_page_template',false)),false);
if ( deAspis(Aspis_in_array($meta_key,$protected)))
 return array(false,false);
if ( (('') === deAspis(Aspis_trim($meta_value))))
 return array(false,false);
$post_id = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT post_id FROM ",$wpdb[0]->postmeta)," WHERE meta_id = %d"),$meta_id));
$meta_value = maybe_serialize(stripslashes_deep($meta_value));
$meta_id = int_cast($meta_id);
$data = array(compact('meta_key','meta_value'),false);
$where = array(compact('meta_id'),false);
do_action(array('update_postmeta',false),$meta_id,$post_id,$meta_key,$meta_value);
$rval = $wpdb[0]->update($wpdb[0]->postmeta,$data,$where);
wp_cache_delete($post_id,array('post_meta',false));
do_action(array('updated_postmeta',false),$meta_id,$post_id,$meta_key,$meta_value);
return $rval;
 }
function _fix_attachment_links ( $post_ID ) {
global $_fix_attachment_link_id;
$post = &get_post($post_ID,array(ARRAY_A,false));
$search = array("#<a[^>]+rel=('|\")[^'\"]*attachment[^>]*>#ie",false);
if ( ((0) == deAspis(Aspis_preg_match_all($search,$post[0]['post_content'],$anchor_matches,array(PREG_PATTERN_ORDER,false)))))
 return ;
$i = array(0,false);
$search = array("#[\s]+rel=(\"|')(.*?)wp-att-(\d+)\\1#i",false);
foreach ( deAspis(attachAspis($anchor_matches,(0))) as $anchor  )
{if ( ((0) == deAspis(Aspis_preg_match($search,$anchor,$id_matches))))
 continue ;
$id = int_cast(attachAspis($id_matches,(3)));
$attachment = &get_post($id,array(ARRAY_A,false));
if ( ((!((empty($attachment) || Aspis_empty( $attachment)))) && (!(is_object(deAspis(get_post($attachment[0]['post_parent'])))))))
 {arrayAssign($attachment[0],deAspis(registerTaint(array('post_parent',false))),addTaint($post_ID));
$attachment = add_magic_quotes($attachment);
wp_update_post($attachment);
}arrayAssign($post_search[0],deAspis(registerTaint($i)),addTaint($anchor));
$_fix_attachment_link_id = $id;
arrayAssign($post_replace[0],deAspis(registerTaint($i)),addTaint(Aspis_preg_replace_callback(array("#href=(\"|')[^'\"]*\\1#",false),array('_fix_attachment_links_replace_cb',false),$anchor)));
preincr($i);
}arrayAssign($post[0],deAspis(registerTaint(array('post_content',false))),addTaint(Aspis_str_replace($post_search,$post_replace,$post[0]['post_content'])));
$post = add_magic_quotes($post);
return wp_update_post($post);
 }
function _fix_attachment_links_replace_cb ( $match ) {
global $_fix_attachment_link_id;
return concat(concat(Aspis_stripslashes(concat1('href=',attachAspis($match,(1)))),get_attachment_link($_fix_attachment_link_id)),Aspis_stripslashes(attachAspis($match,(1))));
 }
function _relocate_children ( $old_ID,$new_ID ) {
global $wpdb;
$old_ID = int_cast($old_ID);
$new_ID = int_cast($new_ID);
$children = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("
		SELECT post_id
		FROM ",$wpdb[0]->postmeta),"
		WHERE meta_key = '_wp_attachment_temp_parent'
		AND meta_value = %d"),$old_ID));
foreach ( $children[0] as $child_id  )
{$wpdb[0]->update($wpdb[0]->posts,array(array(deregisterTaint(array('post_parent',false)) => addTaint($new_ID)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($child_id)),false));
delete_post_meta($child_id,array('_wp_attachment_temp_parent',false));
} }
function get_available_post_statuses ( $type = array('post',false) ) {
$stati = wp_count_posts($type);
return attAspisRC(array_keys(deAspisRC(attAspis(get_object_vars(deAspisRC($stati))))));
 }
function wp_edit_posts_query ( $q = array(false,false) ) {
if ( (false === $q[0]))
 $q = $_GET;
arrayAssign($q[0],deAspis(registerTaint(array('m',false))),addTaint(((isset($q[0][('m')]) && Aspis_isset( $q [0][('m')]))) ? int_cast($q[0]['m']) : array(0,false)));
arrayAssign($q[0],deAspis(registerTaint(array('cat',false))),addTaint(((isset($q[0][('cat')]) && Aspis_isset( $q [0][('cat')]))) ? int_cast($q[0]['cat']) : array(0,false)));
$post_stati = array(array('publish' => array(array(_x(array('Published',false),array('post',false)),__(array('Published posts',false)),_n_noop(array('Published <span class="count">(%s)</span>',false),array('Published <span class="count">(%s)</span>',false))),false,false),'future' => array(array(_x(array('Scheduled',false),array('post',false)),__(array('Scheduled posts',false)),_n_noop(array('Scheduled <span class="count">(%s)</span>',false),array('Scheduled <span class="count">(%s)</span>',false))),false,false),'pending' => array(array(_x(array('Pending Review',false),array('post',false)),__(array('Pending posts',false)),_n_noop(array('Pending Review <span class="count">(%s)</span>',false),array('Pending Review <span class="count">(%s)</span>',false))),false,false),'draft' => array(array(_x(array('Draft',false),array('post',false)),_x(array('Drafts',false),array('manage posts header',false)),_n_noop(array('Draft <span class="count">(%s)</span>',false),array('Drafts <span class="count">(%s)</span>',false))),false,false),'private' => array(array(_x(array('Private',false),array('post',false)),__(array('Private posts',false)),_n_noop(array('Private <span class="count">(%s)</span>',false),array('Private <span class="count">(%s)</span>',false))),false,false),'trash' => array(array(_x(array('Trash',false),array('post',false)),__(array('Trash posts',false)),_n_noop(array('Trash <span class="count">(%s)</span>',false),array('Trash <span class="count">(%s)</span>',false))),false,false),),false);
$post_stati = apply_filters(array('post_stati',false),$post_stati);
$avail_post_stati = get_available_post_statuses(array('post',false));
$post_status_q = array('',false);
if ( (((isset($q[0][('post_status')]) && Aspis_isset( $q [0][('post_status')]))) && deAspis(Aspis_in_array($q[0]['post_status'],attAspisRC(array_keys(deAspisRC($post_stati)))))))
 {$post_status_q = concat1('&post_status=',$q[0]['post_status']);
$post_status_q = concat2($post_status_q,'&perm=readable');
}if ( (((isset($q[0][('post_status')]) && Aspis_isset( $q [0][('post_status')]))) && (('pending') === deAspis($q[0]['post_status']))))
 {$order = array('ASC',false);
$orderby = array('modified',false);
}elseif ( (((isset($q[0][('post_status')]) && Aspis_isset( $q [0][('post_status')]))) && (('draft') === deAspis($q[0]['post_status']))))
 {$order = array('DESC',false);
$orderby = array('modified',false);
}else 
{{$order = array('DESC',false);
$orderby = array('date',false);
}}$posts_per_page = int_cast(get_user_option(array('edit_per_page',false),array(0,false),array(false,false)));
if ( (((empty($posts_per_page) || Aspis_empty( $posts_per_page))) || ($posts_per_page[0] < (1))))
 $posts_per_page = array(15,false);
$posts_per_page = apply_filters(array('edit_posts_per_page',false),$posts_per_page);
wp(concat(concat2(concat(concat2(concat(concat2(concat1("post_type=post&",$post_status_q),"&posts_per_page="),$posts_per_page),"&order="),$order),"&orderby="),$orderby));
return array(array($post_stati,$avail_post_stati),false);
 }
function get_post_mime_types (  ) {
$post_mime_types = array(array('image' => array(array(__(array('Images',false)),__(array('Manage Images',false)),_n_noop(array('Image <span class="count">(%s)</span>',false),array('Images <span class="count">(%s)</span>',false))),false,false),'audio' => array(array(__(array('Audio',false)),__(array('Manage Audio',false)),_n_noop(array('Audio <span class="count">(%s)</span>',false),array('Audio <span class="count">(%s)</span>',false))),false,false),'video' => array(array(__(array('Video',false)),__(array('Manage Video',false)),_n_noop(array('Video <span class="count">(%s)</span>',false),array('Video <span class="count">(%s)</span>',false))),false,false),),false);
return apply_filters(array('post_mime_types',false),$post_mime_types);
 }
function get_available_post_mime_types ( $type = array('attachment',false) ) {
global $wpdb;
$types = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT DISTINCT post_mime_type FROM ",$wpdb[0]->posts)," WHERE post_type = %s"),$type));
return $types;
 }
function wp_edit_attachments_query ( $q = array(false,false) ) {
if ( (false === $q[0]))
 $q = $_GET;
arrayAssign($q[0],deAspis(registerTaint(array('m',false))),addTaint(((isset($q[0][('m')]) && Aspis_isset( $q [0][('m')]))) ? int_cast($q[0]['m']) : array(0,false)));
arrayAssign($q[0],deAspis(registerTaint(array('cat',false))),addTaint(((isset($q[0][('cat')]) && Aspis_isset( $q [0][('cat')]))) ? int_cast($q[0]['cat']) : array(0,false)));
arrayAssign($q[0],deAspis(registerTaint(array('post_type',false))),addTaint(array('attachment',false)));
arrayAssign($q[0],deAspis(registerTaint(array('post_status',false))),addTaint((((isset($q[0][('status')]) && Aspis_isset( $q [0][('status')]))) && (('trash') == deAspis($q[0]['status']))) ? array('trash',false) : array('inherit',false)));
$media_per_page = int_cast(get_user_option(array('upload_per_page',false),array(0,false),array(false,false)));
if ( (((empty($media_per_page) || Aspis_empty( $media_per_page))) || ($media_per_page[0] < (1))))
 $media_per_page = array(20,false);
arrayAssign($q[0],deAspis(registerTaint(array('posts_per_page',false))),addTaint(apply_filters(array('upload_per_page',false),$media_per_page)));
$post_mime_types = get_post_mime_types();
$avail_post_mime_types = get_available_post_mime_types(array('attachment',false));
if ( (((isset($q[0][('post_mime_type')]) && Aspis_isset( $q [0][('post_mime_type')]))) && (denot_boolean(Aspis_array_intersect(array_cast($q[0]['post_mime_type']),attAspisRC(array_keys(deAspisRC($post_mime_types))))))))
 unset($q[0][('post_mime_type')]);
wp($q);
return array(array($post_mime_types,$avail_post_mime_types),false);
 }
function postbox_classes ( $id,$page ) {
if ( (((isset($_GET[0][('edit')]) && Aspis_isset( $_GET [0][('edit')]))) && (deAspis($_GET[0]['edit']) == $id[0])))
 return array('',false);
$current_user = wp_get_current_user();
if ( deAspis($closed = get_user_option(concat1('closedpostboxes_',$page),array(0,false),array(false,false))))
 {if ( (!(is_array($closed[0]))))
 return array('',false);
return deAspis(Aspis_in_array($id,$closed)) ? array('closed',false) : array('',false);
}else 
{{return array('',false);
}} }
function get_sample_permalink ( $id,$title = array(null,false),$name = array(null,false) ) {
$post = &get_post($id);
if ( (denot_boolean($post[0]->ID)))
 {return array(array(array('',false),array('',false)),false);
}$original_status = $post[0]->post_status;
$original_date = $post[0]->post_date;
$original_name = $post[0]->post_name;
if ( deAspis(Aspis_in_array($post[0]->post_status,array(array(array('draft',false),array('pending',false)),false))))
 {$post[0]->post_status = array('publish',false);
$post[0]->post_name = sanitize_title($post[0]->post_name[0] ? $post[0]->post_name : $post[0]->post_title,$post[0]->ID);
}$post[0]->post_name = wp_unique_post_slug($post[0]->post_name,$post[0]->ID,$post[0]->post_status,$post[0]->post_type,$post[0]->post_parent);
if ( (!(is_null(deAspisRC($name)))))
 {$post[0]->post_name = sanitize_title($name[0] ? $name : $title,$post[0]->ID);
}$post[0]->filter = array('sample',false);
$permalink = get_permalink($post,array(true,false));
if ( (('page') == $post[0]->post_type[0]))
 {$uri = get_page_uri($post[0]->ID);
$uri = untrailingslashit($uri);
$uri = Aspis_strrev(Aspis_stristr(Aspis_strrev($uri),array('/',false)));
$uri = untrailingslashit($uri);
if ( (!((empty($uri) || Aspis_empty( $uri)))))
 $uri = concat2($uri,'/');
$permalink = Aspis_str_replace(array('%pagename%',false),concat2($uri,"%pagename%"),$permalink);
}$permalink = array(array($permalink,apply_filters(array('editable_slug',false),$post[0]->post_name)),false);
$post[0]->post_status = $original_status;
$post[0]->post_date = $original_date;
$post[0]->post_name = $original_name;
unset($post[0]->filter);
return $permalink;
 }
function get_sample_permalink_html ( $id,$new_title = array(null,false),$new_slug = array(null,false) ) {
$post = &get_post($id);
list($permalink,$post_name) = deAspisList(get_sample_permalink($post[0]->ID,$new_title,$new_slug),array());
if ( (('publish') == $post[0]->post_status[0]))
 {$view_post = (('post') == $post[0]->post_type[0]) ? __(array('View Post',false)) : __(array('View Page',false));
$title = __(array('Click to edit this part of the permalink',false));
}else 
{{$title = __(array('Temporary permalink. Click to edit this part.',false));
}}if ( ((false === strpos($permalink[0],'%postname%')) && (false === strpos($permalink[0],'%pagename%'))))
 {$return = concat2(concat(concat2(concat2(concat1('<strong>',__(array('Permalink:',false))),"</strong>\n"),'<span id="sample-permalink">'),$permalink),"</span>\n");
if ( (deAspis(current_user_can(array('manage_options',false))) && (!((('page') == deAspis(get_option(array('show_on_front',false)))) && ($id[0] == deAspis(get_option(array('page_on_front',false))))))))
 $return = concat($return,concat2(concat1('<span id="change-permalinks"><a href="options-permalink.php" class="button" target="_blank">',__(array('Change Permalinks',false))),"</a></span>\n"));
if ( ((isset($view_post) && Aspis_isset( $view_post))))
 $return = concat($return,concat2(concat(concat2(concat1("<span id='view-post-btn'><a href='",$permalink),"' class='button' target='_blank'>"),$view_post),"</a></span>\n"));
$return = apply_filters(array('get_sample_permalink_html',false),$return,$id,$new_title,$new_slug);
return $return;
}if ( function_exists(('mb_strlen')))
 {if ( ((mb_strlen(deAspisRC($post_name))) > (30)))
 {$post_name_abridged = concat2(concat12(mb_substr(deAspisRC($post_name),0,14),'&hellip;'),mb_substr(deAspisRC($post_name),deAspisRC(negate(array(14,false)))));
}else 
{{$post_name_abridged = $post_name;
}}}else 
{{if ( (strlen($post_name[0]) > (30)))
 {$post_name_abridged = concat(concat2(Aspis_substr($post_name,array(0,false),array(14,false)),'&hellip;'),Aspis_substr($post_name,negate(array(14,false))));
}else 
{{$post_name_abridged = $post_name;
}}}}$post_name_html = concat2(concat(concat2(concat1('<span id="editable-post-name" title="',$title),'">'),$post_name_abridged),'</span>');
$display_link = Aspis_str_replace(array(array(array('%pagename%',false),array('%postname%',false)),false),$post_name_html,$permalink);
$view_link = Aspis_str_replace(array(array(array('%pagename%',false),array('%postname%',false)),false),$post_name,$permalink);
$return = concat2(concat(concat2(concat2(concat1('<strong>',__(array('Permalink:',false))),"</strong>\n"),'<span id="sample-permalink">'),$display_link),"</span>\n");
$return = concat($return,concat2(concat(concat2(concat1('<span id="edit-slug-buttons"><a href="#post_name" class="edit-slug button hide-if-no-js" onclick="editPermalink(',$id),'); return false;">'),__(array('Edit',false))),"</a></span>\n"));
$return = concat($return,concat2(concat1('<span id="editable-post-name-full">',$post_name),"</span>\n"));
if ( ((isset($view_post) && Aspis_isset( $view_post))))
 $return = concat($return,concat2(concat(concat2(concat1("<span id='view-post-btn'><a href='",$view_link),"' class='button' target='_blank'>"),$view_post),"</a></span>\n"));
$return = apply_filters(array('get_sample_permalink_html',false),$return,$id,$new_title,$new_slug);
return $return;
 }
function _wp_post_thumbnail_html ( $thumbnail_id = array(NULL,false) ) {
global $content_width,$_wp_additional_image_sizes;
$content = concat2(concat1('<p class="hide-if-no-js"><a href="#" id="set-post-thumbnail" onclick="jQuery(\'#add_image\').click();return false;">',esc_html__(array('Set thumbnail',false))),'</a></p>');
if ( ($thumbnail_id[0] && deAspis(get_post($thumbnail_id))))
 {$old_content_width = $content_width;
$content_width = array(266,false);
if ( (!((isset($_wp_additional_image_sizes[0][('post-thumbnail')]) && Aspis_isset( $_wp_additional_image_sizes [0][('post-thumbnail')])))))
 $thumbnail_html = wp_get_attachment_image($thumbnail_id,array(array($content_width,$content_width),false));
else 
{$thumbnail_html = wp_get_attachment_image($thumbnail_id,array('post-thumbnail',false));
}if ( (!((empty($thumbnail_html) || Aspis_empty( $thumbnail_html)))))
 {$content = concat2(concat1('<a href="#" id="set-post-thumbnail" onclick="jQuery(\'#add_image\').click();return false;">',$thumbnail_html),'</a>');
$content = concat($content,concat2(concat1('<p class="hide-if-no-js"><a href="#" id="remove-post-thumbnail" onclick="WPRemoveThumbnail();return false;">',esc_html__(array('Remove thumbnail',false))),'</a></p>'));
}$content_width = $old_content_width;
}return apply_filters(array('admin_post_thumbnail_html',false),$content);
 }
function wp_check_post_lock ( $post_id ) {
global $current_user;
if ( (denot_boolean($post = get_post($post_id))))
 return array(false,false);
$lock = get_post_meta($post[0]->ID,array('_edit_lock',false),array(true,false));
$last = get_post_meta($post[0]->ID,array('_edit_last',false),array(true,false));
$time_window = apply_filters(array('wp_check_post_lock_window',false),array(AUTOSAVE_INTERVAL * (2),false));
if ( (($lock[0] && ($lock[0] > (time() - $time_window[0]))) && ($last[0] != $current_user[0]->ID[0])))
 return $last;
return array(false,false);
 }
function wp_set_post_lock ( $post_id ) {
global $current_user;
if ( (denot_boolean($post = get_post($post_id))))
 return array(false,false);
if ( ((denot_boolean($current_user)) || (denot_boolean($current_user[0]->ID))))
 return array(false,false);
$now = attAspis(time());
if ( (denot_boolean(add_post_meta($post[0]->ID,array('_edit_lock',false),$now,array(true,false)))))
 update_post_meta($post[0]->ID,array('_edit_lock',false),$now);
if ( (denot_boolean(add_post_meta($post[0]->ID,array('_edit_last',false),$current_user[0]->ID,array(true,false)))))
 update_post_meta($post[0]->ID,array('_edit_last',false),$current_user[0]->ID);
 }
function _admin_notice_post_locked (  ) {
global $post;
$last_user = get_userdata(get_post_meta($post[0]->ID,array('_edit_last',false),array(true,false)));
$last_user_name = $last_user[0] ? $last_user[0]->display_name : __(array('Somebody',false));
switch ( $post[0]->post_type[0] ) {
case ('post'):$message = __(array('Warning: %s is currently editing this post',false));
break ;
case ('page'):$message = __(array('Warning: %s is currently editing this page',false));
break ;
default :$message = __(array('Warning: %s is currently editing this.',false));
 }
$message = Aspis_sprintf($message,esc_html($last_user_name));
echo AspisCheckPrint(concat2(concat1("<div class='error'><p>",$message),"</p></div>"));
 }
function wp_create_post_autosave ( $post_id ) {
$translated = _wp_translate_postdata(array(true,false));
if ( deAspis(is_wp_error($translated)))
 return $translated;
if ( deAspis($old_autosave = wp_get_post_autosave($post_id)))
 {$new_autosave = _wp_post_revision_fields($_POST,array(true,false));
arrayAssign($new_autosave[0],deAspis(registerTaint(array('ID',false))),addTaint($old_autosave[0]->ID));
$current_user = wp_get_current_user();
arrayAssign($new_autosave[0],deAspis(registerTaint(array('post_author',false))),addTaint($current_user[0]->ID));
return wp_update_post($new_autosave);
}$_POST = stripslashes_deep($_POST);
return _wp_put_post_revision($_POST,array(true,false));
 }
function post_preview (  ) {
$post_ID = int_cast($_POST[0]['post_ID']);
if ( ($post_ID[0] < (1)))
 wp_die(__(array('Preview not available. Please save as a draft first.',false)));
if ( ((isset($_POST[0][('catslist')]) && Aspis_isset( $_POST [0][('catslist')]))))
 arrayAssign($_POST[0],deAspis(registerTaint(array('post_category',false))),addTaint(Aspis_explode(array(",",false),$_POST[0]['catslist'])));
if ( ((isset($_POST[0][('tags_input')]) && Aspis_isset( $_POST [0][('tags_input')]))))
 arrayAssign($_POST[0],deAspis(registerTaint(array('tags_input',false))),addTaint(Aspis_explode(array(",",false),$_POST[0]['tags_input'])));
if ( ((deAspis($_POST[0]['post_type']) == ('page')) || ((empty($_POST[0][('post_category')]) || Aspis_empty( $_POST [0][('post_category')])))))
 unset($_POST[0][('post_category')]);
arrayAssign($_POST[0],deAspis(registerTaint(array('ID',false))),addTaint($post_ID));
$post = get_post($post_ID);
if ( (('page') == $post[0]->post_type[0]))
 {if ( (denot_boolean(current_user_can(array('edit_page',false),$post_ID))))
 wp_die(__(array('You are not allowed to edit this page.',false)));
}else 
{{if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 wp_die(__(array('You are not allowed to edit this post.',false)));
}}if ( (('draft') == $post[0]->post_status[0]))
 {$id = edit_post();
}else 
{{$id = wp_create_post_autosave($post[0]->ID);
if ( (denot_boolean(is_wp_error($id))))
 $id = $post[0]->ID;
}}if ( deAspis(is_wp_error($id)))
 wp_die($id[0]->get_error_message());
if ( (deAspis($_POST[0]['post_status']) == ('draft')))
 {$url = add_query_arg(array('preview',false),array('true',false),get_permalink($id));
}else 
{{$nonce = wp_create_nonce(concat1('post_preview_',$id));
$url = add_query_arg(array(array('preview' => array('true',false,false),deregisterTaint(array('preview_id',false)) => addTaint($id),deregisterTaint(array('preview_nonce',false)) => addTaint($nonce)),false),get_permalink($id));
}}return $url;
 }
function wp_tiny_mce ( $teeny = array(false,false),$settings = array(false,false) ) {
global $concatenate_scripts,$compress_scripts,$tinymce_version;
if ( (denot_boolean(user_can_richedit())))
 return ;
$baseurl = includes_url(array('js/tinymce',false));
$mce_locale = (('') == deAspis(get_locale())) ? array('en',false) : Aspis_strtolower(Aspis_substr(get_locale(),array(0,false),array(2,false)));
$mce_spellchecker_languages = apply_filters(array('mce_spellchecker_languages',false),array('+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv',false));
if ( $teeny[0])
 {$plugins = apply_filters(array('teeny_mce_plugins',false),array(array(array('safari',false),array('inlinepopups',false),array('media',false),array('fullscreen',false),array('wordpress',false)),false));
$ext_plugins = array('',false);
}else 
{{$plugins = array(array(array('safari',false),array('inlinepopups',false),array('spellchecker',false),array('paste',false),array('wordpress',false),array('media',false),array('fullscreen',false),array('wpeditimage',false),array('wpgallery',false),array('tabfocus',false)),false);
$mce_external_plugins = apply_filters(array('mce_external_plugins',false),array(array(),false));
$ext_plugins = array('',false);
if ( (!((empty($mce_external_plugins) || Aspis_empty( $mce_external_plugins)))))
 {$mce_external_languages = apply_filters(array('mce_external_languages',false),array(array(),false));
$loaded_langs = array(array(),false);
$strings = array('',false);
if ( (!((empty($mce_external_languages) || Aspis_empty( $mce_external_languages)))))
 {foreach ( $mce_external_languages[0] as $name =>$path )
{restoreTaint($name,$path);
{if ( (deAspis(@attAspis(is_file($path[0]))) && deAspis(@attAspis(is_readable($path[0])))))
 {include_once deAspis(($path));
$ext_plugins = concat($ext_plugins,concat2($strings,"\n"));
arrayAssignAdd($loaded_langs[0][],addTaint($name));
}}}}foreach ( $mce_external_plugins[0] as $name =>$url )
{restoreTaint($name,$url);
{if ( deAspis(is_ssl()))
 $url = Aspis_str_replace(array('http://',false),array('https://',false),$url);
arrayAssignAdd($plugins[0][],addTaint(concat1('-',$name)));
$plugurl = Aspis_dirname($url);
$strings = $str1 = $str2 = array('',false);
if ( (denot_boolean(Aspis_in_array($name,$loaded_langs))))
 {$path = Aspis_str_replace(array(WP_PLUGIN_URL,false),array('',false),$plugurl);
$path = concat2(concat1(WP_PLUGIN_DIR,$path),'/langs/');
if ( function_exists(('realpath')))
 $path = trailingslashit(Aspis_realpath($path));
if ( deAspis(@attAspis(is_file((deconcat2(concat($path,$mce_locale),'.js'))))))
 $strings = concat($strings,concat2(@attAspis(file_get_contents((deconcat2(concat($path,$mce_locale),'.js')))),"\n"));
if ( deAspis(@attAspis(is_file((deconcat2(concat($path,$mce_locale),'_dlg.js'))))))
 $strings = concat($strings,concat2(@attAspis(file_get_contents((deconcat2(concat($path,$mce_locale),'_dlg.js')))),"\n"));
if ( ((('en') != $mce_locale[0]) && ((empty($strings) || Aspis_empty( $strings)))))
 {if ( deAspis(@attAspis(is_file((deconcat2($path,'en.js'))))))
 {$str1 = @attAspis(file_get_contents((deconcat2($path,'en.js'))));
$strings = concat($strings,concat2(Aspis_preg_replace(array('/([\'"])en\./',false),concat2(concat1('$1',$mce_locale),'.'),$str1,array(1,false)),"\n"));
}if ( deAspis(@attAspis(is_file((deconcat2($path,'en_dlg.js'))))))
 {$str2 = @attAspis(file_get_contents((deconcat2($path,'en_dlg.js'))));
$strings = concat($strings,concat2(Aspis_preg_replace(array('/([\'"])en\./',false),concat2(concat1('$1',$mce_locale),'.'),$str2,array(1,false)),"\n"));
}}if ( (!((empty($strings) || Aspis_empty( $strings)))))
 $ext_plugins = concat($ext_plugins,concat2(concat1("\n",$strings),"\n"));
}$ext_plugins = concat($ext_plugins,concat2(concat2(concat(concat2(concat1('tinyMCEPreInit.load_ext("',$plugurl),'", "'),$mce_locale),'");'),"\n"));
$ext_plugins = concat($ext_plugins,concat2(concat2(concat(concat2(concat1('tinymce.PluginManager.load("',$name),'", "'),$url),'");'),"\n"));
}}}}}$plugins = Aspis_implode($plugins,array(',',false));
if ( $teeny[0])
 {$mce_buttons = apply_filters(array('teeny_mce_buttons',false),array(array(array('bold, italic, underline, blockquote, separator, strikethrough, bullist, numlist,justifyleft, justifycenter, justifyright, undo, redo, link, unlink, fullscreen',false)),false));
$mce_buttons = Aspis_implode($mce_buttons,array(',',false));
$mce_buttons_2 = $mce_buttons_3 = $mce_buttons_4 = array('',false);
}else 
{{$mce_buttons = apply_filters(array('mce_buttons',false),array(array(array('bold',false),array('italic',false),array('strikethrough',false),array('|',false),array('bullist',false),array('numlist',false),array('blockquote',false),array('|',false),array('justifyleft',false),array('justifycenter',false),array('justifyright',false),array('|',false),array('link',false),array('unlink',false),array('wp_more',false),array('|',false),array('spellchecker',false),array('fullscreen',false),array('wp_adv',false)),false));
$mce_buttons = Aspis_implode($mce_buttons,array(',',false));
$mce_buttons_2 = apply_filters(array('mce_buttons_2',false),array(array(array('formatselect',false),array('underline',false),array('justifyfull',false),array('forecolor',false),array('|',false),array('pastetext',false),array('pasteword',false),array('removeformat',false),array('|',false),array('media',false),array('charmap',false),array('|',false),array('outdent',false),array('indent',false),array('|',false),array('undo',false),array('redo',false),array('wp_help',false)),false));
$mce_buttons_2 = Aspis_implode($mce_buttons_2,array(',',false));
$mce_buttons_3 = apply_filters(array('mce_buttons_3',false),array(array(),false));
$mce_buttons_3 = Aspis_implode($mce_buttons_3,array(',',false));
$mce_buttons_4 = apply_filters(array('mce_buttons_4',false),array(array(),false));
$mce_buttons_4 = Aspis_implode($mce_buttons_4,array(',',false));
}}$no_captions = deAspis((apply_filters(array('disable_captions',false),array('',false)))) ? array(true,false) : array(false,false);
$initArray = array(array('mode' => array('specific_textareas',false,false),'editor_selector' => array('theEditor',false,false),'width' => array('100%',false,false),'theme' => array('advanced',false,false),'skin' => array('wp_theme',false,false),deregisterTaint(array('theme_advanced_buttons1',false)) => addTaint($mce_buttons),deregisterTaint(array('theme_advanced_buttons2',false)) => addTaint($mce_buttons_2),deregisterTaint(array('theme_advanced_buttons3',false)) => addTaint($mce_buttons_3),deregisterTaint(array('theme_advanced_buttons4',false)) => addTaint($mce_buttons_4),deregisterTaint(array('language',false)) => addTaint($mce_locale),deregisterTaint(array('spellchecker_languages',false)) => addTaint($mce_spellchecker_languages),'theme_advanced_toolbar_location' => array('top',false,false),'theme_advanced_toolbar_align' => array('left',false,false),'theme_advanced_statusbar_location' => array('bottom',false,false),'theme_advanced_resizing' => array(true,false,false),'theme_advanced_resize_horizontal' => array(false,false,false),'dialog_type' => array('modal',false,false),'relative_urls' => array(false,false,false),'remove_script_host' => array(false,false,false),'convert_urls' => array(false,false,false),'apply_source_formatting' => array(false,false,false),'remove_linebreaks' => array(true,false,false),'gecko_spellcheck' => array(true,false,false),'entities' => array('38,amp,60,lt,62,gt',false,false),'accessibility_focus' => array(true,false,false),'tabfocus_elements' => array('major-publishing-actions',false,false),'media_strict' => array(false,false,false),'paste_remove_styles' => array(true,false,false),'paste_remove_spans' => array(true,false,false),'paste_strip_class_attributes' => array('all',false,false),deregisterTaint(array('wpeditimage_disable_captions',false)) => addTaint($no_captions),deregisterTaint(array('plugins',false)) => addTaint($plugins)),false);
$mce_css = Aspis_trim(apply_filters(array('mce_css',false),array('',false)),array(' ,',false));
if ( (!((empty($mce_css) || Aspis_empty( $mce_css)))))
 arrayAssign($initArray[0],deAspis(registerTaint(array('content_css',false))),addTaint($mce_css));
if ( is_array($settings[0]))
 $initArray = Aspis_array_merge($initArray,$settings);
if ( $teeny[0])
 {$initArray = apply_filters(array('teeny_mce_before_init',false),$initArray);
}else 
{{$initArray = apply_filters(array('tiny_mce_before_init',false),$initArray);
}}if ( (((empty($initArray[0][('theme_advanced_buttons3')]) || Aspis_empty( $initArray [0][('theme_advanced_buttons3')]))) && (!((empty($initArray[0][('theme_advanced_buttons4')]) || Aspis_empty( $initArray [0][('theme_advanced_buttons4')]))))))
 {arrayAssign($initArray[0],deAspis(registerTaint(array('theme_advanced_buttons3',false))),addTaint($initArray[0]['theme_advanced_buttons4']));
arrayAssign($initArray[0],deAspis(registerTaint(array('theme_advanced_buttons4',false))),addTaint(array('',false)));
}if ( (!((isset($concatenate_scripts) && Aspis_isset( $concatenate_scripts)))))
 script_concat_settings();
$language = $initArray[0]['language'];
$zip = $compress_scripts[0] ? array(1,false) : array(0,false);
$version = apply_filters(array('tiny_mce_version',false),array('',false));
$version = concat(concat1('ver=',$tinymce_version),$version);
if ( (('en') != $language[0]))
 include_once (deconcat2(concat12(ABSPATH,WPINC),'/js/tinymce/langs/wp-langs.php'));
$mce_options = array('',false);
foreach ( $initArray[0] as $k =>$v )
{restoreTaint($k,$v);
$mce_options = concat($mce_options,concat2(concat(concat2($k,':"'),$v),'", '));
}$mce_options = Aspis_rtrim(Aspis_trim($mce_options),array('\n\r,',false));
;
?>

<script type="text/javascript">
/* <![CDATA[ */
tinyMCEPreInit = {
	base : "<?php echo AspisCheckPrint($baseurl);
;
?>",
	suffix : "",
	query : "<?php echo AspisCheckPrint($version);
;
?>",
	mceInit : {<?php echo AspisCheckPrint($mce_options);
;
?>},
	load_ext : function(url,lang){var sl=tinymce.ScriptLoader;sl.markDone(url+'/langs/'+lang+'.js');sl.markDone(url+'/langs/'+lang+'_dlg.js');}
};
/* ]]> */
</script>

<?php if ( $concatenate_scripts[0])
 echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1("<script type='text/javascript' src='",$baseurl),"/wp-tinymce.php?c="),$zip),"&amp;"),$version),"'></script>\n"));
else 
{echo AspisCheckPrint(concat2(concat(concat2(concat1("<script type='text/javascript' src='",$baseurl),"/tiny_mce.js?"),$version),"'></script>\n"));
}if ( ((('en') != $language[0]) && ((isset($lang) && Aspis_isset( $lang)))))
 echo AspisCheckPrint(concat2(concat1("<script type='text/javascript'>\n",$lang),"\n</script>\n"));
else 
{echo AspisCheckPrint(concat2(concat(concat2(concat1("<script type='text/javascript' src='",$baseurl),"/langs/wp-langs-en.js?"),$version),"'></script>\n"));
};
?>

<script type="text/javascript">
/* <![CDATA[ */
<?php if ( $ext_plugins[0])
 echo AspisCheckPrint(concat2($ext_plugins,"\n"));
;
?>
<?php if ( $concatenate_scripts[0])
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
<?php  }
