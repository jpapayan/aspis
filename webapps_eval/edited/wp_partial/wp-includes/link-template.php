<?php require_once('AspisMain.php'); ?><?php
function the_permalink (  ) {
echo apply_filters('the_permalink',get_permalink());
 }
function user_trailingslashit ( $string,$type_of_url = '' ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}if ( $wp_rewrite->use_trailing_slashes)
 $string = trailingslashit($string);
else 
{$string = untrailingslashit($string);
}$string = apply_filters('user_trailingslashit',$string,$type_of_url);
{$AspisRetTemp = $string;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function permalink_anchor ( $mode = 'id' ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}switch ( strtolower($mode) ) {
case 'title':$title = sanitize_title($post->post_title) . '-' . $post->ID;
echo '<a id="' . $title . '"></a>';
break ;
case 'id':default :echo '<a id="post-' . $post->ID . '"></a>';
break ;
 }
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function get_permalink ( $id = 0,$leavename = false ) {
$rewritecode = array('%year%','%monthnum%','%day%','%hour%','%minute%','%second%',$leavename ? '' : '%postname%','%post_id%','%category%','%author%',$leavename ? '' : '%pagename%',);
if ( is_object($id) && isset($id->filter) && 'sample' == $id->filter)
 {$post = $id;
$sample = true;
}else 
{{$post = &get_post($id);
$sample = false;
}}if ( empty($post->ID))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( $post->post_type == 'page')
 {$AspisRetTemp = get_page_link($post->ID,$leavename,$sample);
return $AspisRetTemp;
}elseif ( $post->post_type == 'attachment')
 {$AspisRetTemp = get_attachment_link($post->ID);
return $AspisRetTemp;
}$permalink = get_option('permalink_structure');
if ( '' != $permalink && !in_array($post->post_status,array('draft','pending')))
 {$unixtime = strtotime($post->post_date);
$category = '';
if ( strpos($permalink,'%category%') !== false)
 {$cats = get_the_category($post->ID);
if ( $cats)
 {AspisUntainted_usort($cats,'_usort_terms_by_ID');
$category = $cats[0]->slug;
if ( $parent = $cats[0]->parent)
 $category = get_category_parents($parent,false,'/',true) . $category;
}if ( empty($category))
 {$default_category = get_category(get_option('default_category'));
$category = is_wp_error($default_category) ? '' : $default_category->slug;
}}$author = '';
if ( strpos($permalink,'%author%') !== false)
 {$authordata = get_userdata($post->post_author);
$author = $authordata->user_nicename;
}$date = explode(" ",date('Y m d H i s',$unixtime));
$rewritereplace = array($date[0],$date[1],$date[2],$date[3],$date[4],$date[5],$post->post_name,$post->ID,$category,$author,$post->post_name,);
$permalink = get_option('home') . str_replace($rewritecode,$rewritereplace,$permalink);
$permalink = user_trailingslashit($permalink,'single');
{$AspisRetTemp = apply_filters('post_link',$permalink,$post,$leavename);
return $AspisRetTemp;
}}else 
{{$permalink = trailingslashit(get_option('home')) . '?p=' . $post->ID;
{$AspisRetTemp = apply_filters('post_link',$permalink,$post,$leavename);
return $AspisRetTemp;
}}} }
function post_permalink ( $post_id = 0,$deprecated = '' ) {
{$AspisRetTemp = get_permalink($post_id);
return $AspisRetTemp;
} }
function get_page_link ( $id = false,$leavename = false,$sample = false ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$id = (int)$id;
if ( !$id)
 $id = (int)$post->ID;
if ( 'page' == get_option('show_on_front') && $id == get_option('page_on_front'))
 $link = get_option('home');
else 
{$link = _get_page_link($id,$leavename,$sample);
}{$AspisRetTemp = apply_filters('page_link',$link,$id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function _get_page_link ( $id = false,$leavename = false,$sample = false ) {
{global $post,$wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}if ( !$id)
 $id = (int)$post->ID;
else 
{$post = &get_post($id);
}$pagestruct = $wp_rewrite->get_page_permastruct();
if ( '' != $pagestruct && ((isset($post->post_status) && 'draft' != $post->post_status && 'pending' != $post->post_status) || $sample))
 {$link = get_page_uri($id);
$link = ($leavename) ? $pagestruct : str_replace('%pagename%',$link,$pagestruct);
$link = trailingslashit(get_option('home')) . "$link";
$link = user_trailingslashit($link,'page');
}else 
{{$link = trailingslashit(get_option('home')) . "?page_id=$id";
}}{$AspisRetTemp = apply_filters('_get_page_link',$link,$id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
 }
function get_attachment_link ( $id = false ) {
{global $post,$wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$link = false;
if ( !$id)
 {$id = (int)$post->ID;
}$object = get_post($id);
if ( $wp_rewrite->using_permalinks() && ($object->post_parent > 0) && ($object->post_parent != $id))
 {$parent = get_post($object->post_parent);
if ( 'page' == $parent->post_type)
 $parentlink = _get_page_link($object->post_parent);
else 
{$parentlink = get_permalink($object->post_parent);
}if ( is_numeric($object->post_name) || false !== strpos(get_option('permalink_structure'),'%category%'))
 $name = 'attachment/' . $object->post_name;
else 
{$name = $object->post_name;
}if ( strpos($parentlink,'?') === false)
 $link = user_trailingslashit(trailingslashit($parentlink) . $name);
}if ( !$link)
 {$link = trailingslashit(get_bloginfo('url')) . "?attachment_id=$id";
}{$AspisRetTemp = apply_filters('attachment_link',$link,$id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
 }
function get_year_link ( $year ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}if ( !$year)
 $year = gmdate('Y',time() + (get_option('gmt_offset') * 3600));
$yearlink = $wp_rewrite->get_year_permastruct();
if ( !empty($yearlink))
 {$yearlink = str_replace('%year%',$year,$yearlink);
{$AspisRetTemp = apply_filters('year_link',get_option('home') . user_trailingslashit($yearlink,'year'),$year);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = apply_filters('year_link',trailingslashit(get_option('home')) . '?m=' . $year,$year);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function get_month_link ( $year,$month ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}if ( !$year)
 $year = gmdate('Y',time() + (get_option('gmt_offset') * 3600));
if ( !$month)
 $month = gmdate('m',time() + (get_option('gmt_offset') * 3600));
$monthlink = $wp_rewrite->get_month_permastruct();
if ( !empty($monthlink))
 {$monthlink = str_replace('%year%',$year,$monthlink);
$monthlink = str_replace('%monthnum%',zeroise(intval($month),2),$monthlink);
{$AspisRetTemp = apply_filters('month_link',get_option('home') . user_trailingslashit($monthlink,'month'),$year,$month);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = apply_filters('month_link',trailingslashit(get_option('home')) . '?m=' . $year . zeroise($month,2),$year,$month);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function get_day_link ( $year,$month,$day ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}if ( !$year)
 $year = gmdate('Y',time() + (get_option('gmt_offset') * 3600));
if ( !$month)
 $month = gmdate('m',time() + (get_option('gmt_offset') * 3600));
if ( !$day)
 $day = gmdate('j',time() + (get_option('gmt_offset') * 3600));
$daylink = $wp_rewrite->get_day_permastruct();
if ( !empty($daylink))
 {$daylink = str_replace('%year%',$year,$daylink);
$daylink = str_replace('%monthnum%',zeroise(intval($month),2),$daylink);
$daylink = str_replace('%day%',zeroise(intval($day),2),$daylink);
{$AspisRetTemp = apply_filters('day_link',get_option('home') . user_trailingslashit($daylink,'day'),$year,$month,$day);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = apply_filters('day_link',trailingslashit(get_option('home')) . '?m=' . $year . zeroise($month,2) . zeroise($day,2),$year,$month,$day);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function get_feed_link ( $feed = '' ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$permalink = $wp_rewrite->get_feed_permastruct();
if ( '' != $permalink)
 {if ( false !== strpos($feed,'comments_'))
 {$feed = str_replace('comments_','',$feed);
$permalink = $wp_rewrite->get_comment_feed_permastruct();
}if ( get_default_feed() == $feed)
 $feed = '';
$permalink = str_replace('%feed%',$feed,$permalink);
$permalink = preg_replace('#/+#','/',"/$permalink");
$output = get_option('home') . user_trailingslashit($permalink,'feed');
}else 
{{if ( empty($feed))
 $feed = get_default_feed();
if ( false !== strpos($feed,'comments_'))
 $feed = str_replace('comments_','comments-',$feed);
$output = trailingslashit(get_option('home')) . "?feed={$feed}";
}}{$AspisRetTemp = apply_filters('feed_link',$output,$feed);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function get_post_comments_feed_link ( $post_id = '',$feed = '' ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}if ( empty($post_id))
 $post_id = (int)$id;
if ( empty($feed))
 $feed = get_default_feed();
if ( '' != get_option('permalink_structure'))
 {$url = trailingslashit(get_permalink($post_id)) . 'feed';
if ( $feed != get_default_feed())
 $url .= "/$feed";
$url = user_trailingslashit($url,'single_feed');
}else 
{{$type = get_post_field('post_type',$post_id);
if ( 'page' == $type)
 $url = trailingslashit(get_option('home')) . "?feed=$feed&amp;
page_id=$post_id";
else 
{$url = trailingslashit(get_option('home')) . "?feed=$feed&amp;
p=$post_id";
}}}{$AspisRetTemp = apply_filters('post_comments_feed_link',$url);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function post_comments_feed_link ( $link_text = '',$post_id = '',$feed = '' ) {
$url = get_post_comments_feed_link($post_id,$feed);
if ( empty($link_text))
 $link_text = __('Comments Feed');
echo apply_filters('post_comments_feed_link_html',"<a href='$url'>$link_text</a>",$post_id,$feed);
 }
function get_author_feed_link ( $author_id,$feed = '' ) {
$author_id = (int)$author_id;
$permalink_structure = get_option('permalink_structure');
if ( empty($feed))
 $feed = get_default_feed();
if ( '' == $permalink_structure)
 {$link = trailingslashit(get_option('home')) . "?feed=$feed&amp;
author=" . $author_id;
}else 
{{$link = get_author_posts_url($author_id);
if ( $feed == get_default_feed())
 $feed_link = 'feed';
else 
{$feed_link = "feed/$feed";
}$link = trailingslashit($link) . user_trailingslashit($feed_link,'feed');
}}$link = apply_filters('author_feed_link',$link,$feed);
{$AspisRetTemp = $link;
return $AspisRetTemp;
} }
function get_category_feed_link ( $cat_id,$feed = '' ) {
$cat_id = (int)$cat_id;
$category = get_category($cat_id);
if ( empty($category) || is_wp_error($category))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( empty($feed))
 $feed = get_default_feed();
$permalink_structure = get_option('permalink_structure');
if ( '' == $permalink_structure)
 {$link = trailingslashit(get_option('home')) . "?feed=$feed&amp;
cat=" . $cat_id;
}else 
{{$link = get_category_link($cat_id);
if ( $feed == get_default_feed())
 $feed_link = 'feed';
else 
{$feed_link = "feed/$feed";
}$link = trailingslashit($link) . user_trailingslashit($feed_link,'feed');
}}$link = apply_filters('category_feed_link',$link,$feed);
{$AspisRetTemp = $link;
return $AspisRetTemp;
} }
function get_tag_feed_link ( $tag_id,$feed = '' ) {
$tag_id = (int)$tag_id;
$tag = get_tag($tag_id);
if ( empty($tag) || is_wp_error($tag))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$permalink_structure = get_option('permalink_structure');
if ( empty($feed))
 $feed = get_default_feed();
if ( '' == $permalink_structure)
 {$link = trailingslashit(get_option('home')) . "?feed=$feed&amp;
tag=" . $tag->slug;
}else 
{{$link = get_tag_link($tag->term_id);
if ( $feed == get_default_feed())
 $feed_link = 'feed';
else 
{$feed_link = "feed/$feed";
}$link = trailingslashit($link) . user_trailingslashit($feed_link,'feed');
}}$link = apply_filters('tag_feed_link',$link,$feed);
{$AspisRetTemp = $link;
return $AspisRetTemp;
} }
function get_edit_tag_link ( $tag_id = 0,$taxonomy = 'post_tag' ) {
$tag = get_term($tag_id,$taxonomy);
if ( !current_user_can('manage_categories'))
 {return ;
}$location = admin_url('edit-tags.php?action=edit&amp;taxonomy=' . $taxonomy . '&amp;tag_ID=' . $tag->term_id);
{$AspisRetTemp = apply_filters('get_edit_tag_link',$location);
return $AspisRetTemp;
} }
function edit_tag_link ( $link = '',$before = '',$after = '',$tag = null ) {
$tag = get_term($tag,'post_tag');
if ( !current_user_can('manage_categories'))
 {return ;
}if ( empty($link))
 $link = __('Edit This');
$link = '<a href="' . get_edit_tag_link($tag->term_id) . '" title="' . __('Edit tag') . '">' . $link . '</a>';
echo $before . apply_filters('edit_tag_link',$link,$tag->term_id) . $after;
 }
function get_search_feed_link ( $search_query = '',$feed = '' ) {
if ( empty($search_query))
 $search = esc_attr(urlencode(get_search_query()));
else 
{$search = esc_attr(urlencode(stripslashes($search_query)));
}if ( empty($feed))
 $feed = get_default_feed();
$link = trailingslashit(get_option('home')) . "?s=$search&amp;
feed=$feed";
$link = apply_filters('search_feed_link',$link);
{$AspisRetTemp = $link;
return $AspisRetTemp;
} }
function get_search_comments_feed_link ( $search_query = '',$feed = '' ) {
if ( empty($search_query))
 $search = esc_attr(urlencode(get_search_query()));
else 
{$search = esc_attr(urlencode(stripslashes($search_query)));
}if ( empty($feed))
 $feed = get_default_feed();
$link = trailingslashit(get_option('home')) . "?s=$search&amp;
feed=comments-$feed";
$link = apply_filters('search_feed_link',$link);
{$AspisRetTemp = $link;
return $AspisRetTemp;
} }
function get_edit_post_link ( $id = 0,$context = 'display' ) {
if ( !$post = &get_post($id))
 {return ;
}if ( 'display' == $context)
 $action = 'action=edit&amp;';
else 
{$action = 'action=edit&';
}switch ( $post->post_type ) {
case 'page':if ( !current_user_can('edit_page',$post->ID))
 {return ;
}$file = 'page';
$var = 'post';
break ;
;
case 'attachment':if ( !current_user_can('edit_post',$post->ID))
 {return ;
}$file = 'media';
$var = 'attachment_id';
break ;
case 'revision':if ( !current_user_can('edit_post',$post->ID))
 {return ;
}$file = 'revision';
$var = 'revision';
$action = '';
break ;
default :if ( !current_user_can('edit_post',$post->ID))
 {$AspisRetTemp = apply_filters('get_edit_post_link','',$post->ID,$context);
return $AspisRetTemp;
};
$file = 'post';
$var = 'post';
break ;
 }
{$AspisRetTemp = apply_filters('get_edit_post_link',admin_url("$file.php?{$action}$var=$post->ID"),$post->ID,$context);
return $AspisRetTemp;
} }
function edit_post_link ( $link = null,$before = '',$after = '',$id = 0 ) {
if ( !$post = &get_post($id))
 {return ;
}if ( !$url = get_edit_post_link($post->ID))
 {return ;
}if ( null === $link)
 $link = __('Edit This');
$link = '<a class="post-edit-link" href="' . $url . '" title="' . esc_attr(__('Edit post')) . '">' . $link . '</a>';
echo $before . apply_filters('edit_post_link',$link,$post->ID) . $after;
 }
function get_delete_post_link ( $id = 0,$context = 'display' ) {
if ( !$post = &get_post($id))
 {return ;
}if ( 'display' == $context)
 $action = 'action=trash&amp;';
else 
{$action = 'action=trash&';
}switch ( $post->post_type ) {
case 'page':if ( !current_user_can('delete_page',$post->ID))
 {return ;
}$file = 'page';
$var = 'post';
break ;
;
case 'attachment':if ( !current_user_can('delete_post',$post->ID))
 {return ;
}$file = 'media';
$var = 'attachment_id';
break ;
case 'revision':if ( !current_user_can('delete_post',$post->ID))
 {return ;
}$file = 'revision';
$var = 'revision';
$action = '';
break ;
default :if ( !current_user_can('edit_post',$post->ID))
 {$AspisRetTemp = apply_filters('get_delete_post_link','',$post->ID,$context);
return $AspisRetTemp;
};
$file = 'post';
$var = 'post';
break ;
 }
{$AspisRetTemp = apply_filters('get_delete_post_link',wp_nonce_url(admin_url("$file.php?{$action}$var=$post->ID"),"trash-{$file}_" . $post->ID),$context);
return $AspisRetTemp;
} }
function get_edit_comment_link ( $comment_id = 0 ) {
$comment = &get_comment($comment_id);
$post = &get_post($comment->comment_post_ID);
if ( $post->post_type == 'page')
 {if ( !current_user_can('edit_page',$post->ID))
 {return ;
}}else 
{{if ( !current_user_can('edit_post',$post->ID))
 {return ;
}}}$location = admin_url('comment.php?action=editcomment&amp;c=') . $comment->comment_ID;
{$AspisRetTemp = apply_filters('get_edit_comment_link',$location);
return $AspisRetTemp;
} }
function edit_comment_link ( $link = null,$before = '',$after = '' ) {
{global $comment,$post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($post,"\$post",$AspisChangesCache);
}if ( $post->post_type == 'page')
 {if ( !current_user_can('edit_page',$post->ID))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$post",$AspisChangesCache);
return ;
}}else 
{{if ( !current_user_can('edit_post',$post->ID))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$post",$AspisChangesCache);
return ;
}}}if ( null === $link)
 $link = __('Edit This');
$link = '<a class="comment-edit-link" href="' . get_edit_comment_link($comment->comment_ID) . '" title="' . __('Edit comment') . '">' . $link . '</a>';
echo $before . apply_filters('edit_comment_link',$link,$comment->comment_ID) . $after;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$post",$AspisChangesCache);
 }
function get_edit_bookmark_link ( $link = 0 ) {
$link = get_bookmark($link);
if ( !current_user_can('manage_links'))
 {return ;
}$location = admin_url('link.php?action=edit&amp;link_id=') . $link->link_id;
{$AspisRetTemp = apply_filters('get_edit_bookmark_link',$location,$link->link_id);
return $AspisRetTemp;
} }
function edit_bookmark_link ( $link = '',$before = '',$after = '',$bookmark = null ) {
$bookmark = get_bookmark($bookmark);
if ( !current_user_can('manage_links'))
 {return ;
}if ( empty($link))
 $link = __('Edit This');
$link = '<a href="' . get_edit_bookmark_link($link) . '" title="' . __('Edit link') . '">' . $link . '</a>';
echo $before . apply_filters('edit_bookmark_link',$link,$bookmark->link_id) . $after;
 }
function get_previous_post ( $in_same_cat = false,$excluded_categories = '' ) {
{$AspisRetTemp = get_adjacent_post($in_same_cat,$excluded_categories);
return $AspisRetTemp;
} }
function get_next_post ( $in_same_cat = false,$excluded_categories = '' ) {
{$AspisRetTemp = get_adjacent_post($in_same_cat,$excluded_categories,false);
return $AspisRetTemp;
} }
function get_adjacent_post ( $in_same_cat = false,$excluded_categories = '',$previous = true ) {
{global $post,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( empty($post) || !is_single() || is_attachment())
 {$AspisRetTemp = null;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$current_post_date = $post->post_date;
$join = '';
$posts_in_ex_cats_sql = '';
if ( $in_same_cat || !empty($excluded_categories))
 {$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
if ( $in_same_cat)
 {$cat_array = wp_get_object_terms($post->ID,'category','fields=ids');
$join .= " AND tt.taxonomy = 'category' AND tt.term_id IN (" . implode(',',$cat_array) . ")";
}$posts_in_ex_cats_sql = "AND tt.taxonomy = 'category'";
if ( !empty($excluded_categories))
 {$excluded_categories = array_map('intval',explode(' and ',$excluded_categories));
if ( !empty($cat_array))
 {$excluded_categories = array_diff($excluded_categories,$cat_array);
$posts_in_ex_cats_sql = '';
}if ( !empty($excluded_categories))
 {$posts_in_ex_cats_sql = " AND tt.taxonomy = 'category' AND tt.term_id NOT IN (" . implode($excluded_categories,',') . ')';
}}}$adjacent = $previous ? 'previous' : 'next';
$op = $previous ? '<' : '>';
$order = $previous ? 'DESC' : 'ASC';
$join = apply_filters("get_{$adjacent}_post_join",$join,$in_same_cat,$excluded_categories);
$where = apply_filters("get_{$adjacent}_post_where",$wpdb->prepare("WHERE p.post_date $op %s AND p.post_type = %s AND p.post_status = 'publish' $posts_in_ex_cats_sql",$current_post_date,$post->post_type),$in_same_cat,$excluded_categories);
$sort = apply_filters("get_{$adjacent}_post_sort","ORDER BY p.post_date $order LIMIT 1");
$query = "SELECT p.* FROM $wpdb->posts AS p $join $where $sort";
$query_key = 'adjacent_post_' . md5($query);
$result = wp_cache_get($query_key,'counts');
if ( false !== $result)
 {$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$result = $wpdb->get_row("SELECT p.* FROM $wpdb->posts AS p $join $where $sort");
if ( null === $result)
 $result = '';
wp_cache_set($query_key,$result,'counts');
{$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function get_adjacent_post_rel_link ( $title = '%title',$in_same_cat = false,$excluded_categories = '',$previous = true ) {
if ( $previous && is_attachment())
 $post = &get_post($GLOBALS[0]['post']->post_parent);
else 
{$post = get_adjacent_post($in_same_cat,$excluded_categories,$previous);
}if ( empty($post))
 {return ;
}if ( empty($post->post_title))
 $post->post_title = $previous ? __('Previous Post') : __('Next Post');
$date = mysql2date(get_option('date_format'),$post->post_date);
$title = str_replace('%title',$post->post_title,$title);
$title = str_replace('%date',$date,$title);
$title = apply_filters('the_title',$title,$post);
$link = $previous ? "<link rel='prev' title='" : "<link rel='next' title='";
$link .= esc_attr($title);
$link .= "' href='" . get_permalink($post) . "' />\n";
$adjacent = $previous ? 'previous' : 'next';
{$AspisRetTemp = apply_filters("{$adjacent}_post_rel_link",$link);
return $AspisRetTemp;
} }
function adjacent_posts_rel_link ( $title = '%title',$in_same_cat = false,$excluded_categories = '' ) {
echo get_adjacent_post_rel_link($title,$in_same_cat,$excluded_categories = '',true);
echo get_adjacent_post_rel_link($title,$in_same_cat,$excluded_categories = '',false);
 }
function next_post_rel_link ( $title = '%title',$in_same_cat = false,$excluded_categories = '' ) {
echo get_adjacent_post_rel_link($title,$in_same_cat,$excluded_categories = '',false);
 }
function prev_post_rel_link ( $title = '%title',$in_same_cat = false,$excluded_categories = '' ) {
echo get_adjacent_post_rel_link($title,$in_same_cat,$excluded_categories = '',true);
 }
function get_boundary_post ( $in_same_cat = false,$excluded_categories = '',$start = true ) {
{global $post,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( empty($post) || !is_single() || is_attachment())
 {$AspisRetTemp = null;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$cat_array = array();
$excluded_categories = array();
if ( !empty($in_same_cat) || !empty($excluded_categories))
 {if ( !empty($in_same_cat))
 {$cat_array = wp_get_object_terms($post->ID,'category','fields=ids');
}if ( !empty($excluded_categories))
 {$excluded_categories = array_map('intval',explode(',',$excluded_categories));
if ( !empty($cat_array))
 $excluded_categories = array_diff($excluded_categories,$cat_array);
$inverse_cats = array();
foreach ( $excluded_categories as $excluded_category  )
$inverse_cats[] = $excluded_category * -1;
$excluded_categories = $inverse_cats;
}}$categories = implode(',',array_merge($cat_array,$excluded_categories));
$order = $start ? 'ASC' : 'DESC';
{$AspisRetTemp = get_posts(array('numberposts' => 1,'order' => $order,'orderby' => 'ID','category' => $categories));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function get_boundary_post_rel_link ( $title = '%title',$in_same_cat = false,$excluded_categories = '',$start = true ) {
$posts = get_boundary_post($in_same_cat,$excluded_categories,$start);
$post = $posts[0];
if ( empty($post))
 {return ;
}if ( empty($post->post_title))
 $post->post_title = $start ? __('First Post') : __('Last Post');
$date = mysql2date(get_option('date_format'),$post->post_date);
$title = str_replace('%title',$post->post_title,$title);
$title = str_replace('%date',$date,$title);
$title = apply_filters('the_title',$title,$post);
$link = $start ? "<link rel='start' title='" : "<link rel='end' title='";
$link .= esc_attr($title);
$link .= "' href='" . get_permalink($post) . "' />\n";
$boundary = $start ? 'start' : 'end';
{$AspisRetTemp = apply_filters("{$boundary}_post_rel_link",$link);
return $AspisRetTemp;
} }
function start_post_rel_link ( $title = '%title',$in_same_cat = false,$excluded_categories = '' ) {
echo get_boundary_post_rel_link($title,$in_same_cat,$excluded_categories,true);
 }
function get_index_rel_link (  ) {
$link = "<link rel='index' title='" . esc_attr(get_bloginfo('name')) . "' href='" . get_bloginfo('siteurl') . "' />\n";
{$AspisRetTemp = apply_filters("index_rel_link",$link);
return $AspisRetTemp;
} }
function index_rel_link (  ) {
echo get_index_rel_link();
 }
function get_parent_post_rel_link ( $title = '%title' ) {
if ( !empty($GLOBALS[0]['post']) && !empty($GLOBALS[0]['post']->post_parent))
 $post = &get_post($GLOBALS[0]['post']->post_parent);
if ( empty($post))
 {return ;
}$date = mysql2date(get_option('date_format'),$post->post_date);
$title = str_replace('%title',$post->post_title,$title);
$title = str_replace('%date',$date,$title);
$title = apply_filters('the_title',$title,$post);
$link = "<link rel='up' title='";
$link .= esc_attr($title);
$link .= "' href='" . get_permalink($post) . "' />\n";
{$AspisRetTemp = apply_filters("parent_post_rel_link",$link);
return $AspisRetTemp;
} }
function parent_post_rel_link ( $title = '%title' ) {
echo get_parent_post_rel_link($title);
 }
function previous_post_link ( $format = '&laquo; %link',$link = '%title',$in_same_cat = false,$excluded_categories = '' ) {
adjacent_post_link($format,$link,$in_same_cat,$excluded_categories,true);
 }
function next_post_link ( $format = '%link &raquo;',$link = '%title',$in_same_cat = false,$excluded_categories = '' ) {
adjacent_post_link($format,$link,$in_same_cat,$excluded_categories,false);
 }
function adjacent_post_link ( $format,$link,$in_same_cat = false,$excluded_categories = '',$previous = true ) {
if ( $previous && is_attachment())
 $post = &get_post($GLOBALS[0]['post']->post_parent);
else 
{$post = get_adjacent_post($in_same_cat,$excluded_categories,$previous);
}if ( !$post)
 {return ;
}$title = $post->post_title;
if ( empty($post->post_title))
 $title = $previous ? __('Previous Post') : __('Next Post');
$title = apply_filters('the_title',$title,$post);
$date = mysql2date(get_option('date_format'),$post->post_date);
$rel = $previous ? 'prev' : 'next';
$string = '<a href="' . get_permalink($post) . '" rel="' . $rel . '">';
$link = str_replace('%title',$title,$link);
$link = str_replace('%date',$date,$link);
$link = $string . $link . '</a>';
$format = str_replace('%link',$link,$format);
$adjacent = $previous ? 'previous' : 'next';
echo apply_filters("{$adjacent}_post_link",$format,$link);
 }
function get_pagenum_link ( $pagenum = 1 ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$pagenum = (int)$pagenum;
$request = remove_query_arg('paged');
$home_root = parse_url(get_option('home'));
$home_root = (isset($home_root['path'])) ? $home_root['path'] : '';
$home_root = preg_quote(trailingslashit($home_root),'|');
$request = preg_replace('|^' . $home_root . '|','',$request);
$request = preg_replace('|^/+|','',$request);
if ( !$wp_rewrite->using_permalinks() || is_admin())
 {$base = trailingslashit(get_bloginfo('home'));
if ( $pagenum > 1)
 {$result = add_query_arg('paged',$pagenum,$base . $request);
}else 
{{$result = $base . $request;
}}}else 
{{$qs_regex = '|\?.*?$|';
preg_match($qs_regex,$request,$qs_match);
if ( !empty($qs_match[0]))
 {$query_string = $qs_match[0];
$request = preg_replace($qs_regex,'',$request);
}else 
{{$query_string = '';
}}$request = preg_replace('|page/\d+/?$|','',$request);
$request = preg_replace('|^index\.php|','',$request);
$request = ltrim($request,'/');
$base = trailingslashit(get_bloginfo('url'));
if ( $wp_rewrite->using_index_permalinks() && ($pagenum > 1 || '' != $request))
 $base .= 'index.php/';
if ( $pagenum > 1)
 {$request = ((!empty($request)) ? trailingslashit($request) : $request) . user_trailingslashit('page/' . $pagenum,'paged');
}$result = $base . $request . $query_string;
}}$result = apply_filters('get_pagenum_link',$result);
{$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function get_next_posts_page_link ( $max_page = 0 ) {
{global $paged;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $paged,"\$paged",$AspisChangesCache);
}if ( !is_single())
 {if ( !$paged)
 $paged = 1;
$nextpage = intval($paged) + 1;
if ( !$max_page || $max_page >= $nextpage)
 {$AspisRetTemp = get_pagenum_link($nextpage);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$paged",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$paged",$AspisChangesCache);
 }
function next_posts ( $max_page = 0,$echo = true ) {
$output = esc_url(get_next_posts_page_link($max_page));
if ( $echo)
 echo $output;
else 
{{$AspisRetTemp = $output;
return $AspisRetTemp;
}} }
function get_next_posts_link ( $label = 'Next Page &raquo;',$max_page = 0 ) {
{global $paged,$wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $paged,"\$paged",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_query,"\$wp_query",$AspisChangesCache);
}if ( !$max_page)
 {$max_page = $wp_query->max_num_pages;
}if ( !$paged)
 $paged = 1;
$nextpage = intval($paged) + 1;
if ( !is_single() && (empty($paged) || $nextpage <= $max_page))
 {$attr = apply_filters('next_posts_link_attributes','');
{$AspisRetTemp = '<a href="' . next_posts($max_page,false) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/','&#038;$1',$label) . '</a>';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$paged",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$paged",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_query",$AspisChangesCache);
 }
function next_posts_link ( $label = 'Next Page &raquo;',$max_page = 0 ) {
echo get_next_posts_link($label,$max_page);
 }
function get_previous_posts_page_link (  ) {
{global $paged;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $paged,"\$paged",$AspisChangesCache);
}if ( !is_single())
 {$nextpage = intval($paged) - 1;
if ( $nextpage < 1)
 $nextpage = 1;
{$AspisRetTemp = get_pagenum_link($nextpage);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$paged",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$paged",$AspisChangesCache);
 }
function previous_posts ( $echo = true ) {
$output = esc_url(get_previous_posts_page_link());
if ( $echo)
 echo $output;
else 
{{$AspisRetTemp = $output;
return $AspisRetTemp;
}} }
function get_previous_posts_link ( $label = '&laquo; Previous Page' ) {
{global $paged;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $paged,"\$paged",$AspisChangesCache);
}if ( !is_single() && $paged > 1)
 {$attr = apply_filters('previous_posts_link_attributes','');
{$AspisRetTemp = '<a href="' . previous_posts(false) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/','&#038;$1',$label) . '</a>';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$paged",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$paged",$AspisChangesCache);
 }
function previous_posts_link ( $label = '&laquo; Previous Page' ) {
echo get_previous_posts_link($label);
 }
function get_posts_nav_link ( $args = array() ) {
{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}$return = '';
if ( !is_singular())
 {$defaults = array('sep' => ' &#8212; ','prelabel' => __('&laquo; Previous Page'),'nxtlabel' => __('Next Page &raquo;'),);
$args = wp_parse_args($args,$defaults);
$max_num_pages = $wp_query->max_num_pages;
$paged = get_query_var('paged');
if ( $paged < 2 || $paged >= $max_num_pages)
 {$args['sep'] = '';
}if ( $max_num_pages > 1)
 {$return = get_previous_posts_link($args['prelabel']);
$return .= preg_replace('/&([^#])(?![a-z]{1,8};)/','&#038;$1',$args['sep']);
$return .= get_next_posts_link($args['nxtlabel']);
}}{$AspisRetTemp = $return;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function posts_nav_link ( $sep = '',$prelabel = '',$nxtlabel = '' ) {
$args = array_filter(compact('sep','prelabel','nxtlabel'));
echo get_posts_nav_link($args);
 }
function get_comments_pagenum_link ( $pagenum = 1,$max_page = 0 ) {
{global $post,$wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$pagenum = (int)$pagenum;
$result = get_permalink($post->ID);
if ( 'newest' == get_option('default_comments_page'))
 {if ( $pagenum != $max_page)
 {if ( $wp_rewrite->using_permalinks())
 $result = user_trailingslashit(trailingslashit($result) . 'comment-page-' . $pagenum,'commentpaged');
else 
{$result = add_query_arg('cpage',$pagenum,$result);
}}}elseif ( $pagenum > 1)
 {if ( $wp_rewrite->using_permalinks())
 $result = user_trailingslashit(trailingslashit($result) . 'comment-page-' . $pagenum,'commentpaged');
else 
{$result = add_query_arg('cpage',$pagenum,$result);
}}$result .= '#comments';
$result = apply_filters('get_comments_pagenum_link',$result);
{$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
 }
function get_next_comments_link ( $label = '',$max_page = 0 ) {
{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}if ( !is_singular() || !get_option('page_comments'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return ;
}$page = get_query_var('cpage');
$nextpage = intval($page) + 1;
if ( empty($max_page))
 $max_page = $wp_query->max_num_comment_pages;
if ( empty($max_page))
 $max_page = get_comment_pages_count();
if ( $nextpage > $max_page)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return ;
}if ( empty($label))
 $label = __('Newer Comments &raquo;');
{$AspisRetTemp = '<a href="' . esc_url(get_comments_pagenum_link($nextpage,$max_page)) . '" ' . apply_filters('next_comments_link_attributes','') . '>' . preg_replace('/&([^#])(?![a-z]{1,8};)/','&#038;$1',$label) . '</a>';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function next_comments_link ( $label = '',$max_page = 0 ) {
echo get_next_comments_link($label,$max_page);
 }
function get_previous_comments_link ( $label = '' ) {
if ( !is_singular() || !get_option('page_comments'))
 {return ;
}$page = get_query_var('cpage');
if ( intval($page) <= 1)
 {return ;
}$prevpage = intval($page) - 1;
if ( empty($label))
 $label = __('&laquo; Older Comments');
{$AspisRetTemp = '<a href="' . esc_url(get_comments_pagenum_link($prevpage)) . '" ' . apply_filters('previous_comments_link_attributes','') . '>' . preg_replace('/&([^#])(?![a-z]{1,8};)/','&#038;$1',$label) . '</a>';
return $AspisRetTemp;
} }
function previous_comments_link ( $label = '' ) {
echo get_previous_comments_link($label);
 }
function paginate_comments_links ( $args = array() ) {
{global $wp_query,$wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}if ( !is_singular() || !get_option('page_comments'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
return ;
}$page = get_query_var('cpage');
if ( !$page)
 $page = 1;
$max_page = get_comment_pages_count();
$defaults = array('base' => add_query_arg('cpage','%#%'),'format' => '','total' => $max_page,'current' => $page,'echo' => true,'add_fragment' => '#comments');
if ( $wp_rewrite->using_permalinks())
 $defaults['base'] = user_trailingslashit(trailingslashit(get_permalink()) . 'comment-page-%#%','commentpaged');
$args = wp_parse_args($args,$defaults);
$page_links = paginate_links($args);
if ( $args['echo'])
 echo $page_links;
else 
{{$AspisRetTemp = $page_links;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_rewrite",$AspisChangesCache);
 }
function get_shortcut_link (  ) {
$link = "javascript:
			var d=document,
			w=window,
			e=w.getSelection,
			k=d.getSelection,
			x=d.selection,
			s=(e?e():(k)?k():(x?x.createRange().text:0)),
			f='" . admin_url('press-this.php') . "',
			l=d.location,
			e=encodeURIComponent,
			u=f+'?u='+e(l.href)+'&t='+e(d.title)+'&s='+e(s)+'&v=4';
			a=function(){if(!w.open(u,'t','toolbar=0,resizable=1,scrollbars=1,status=1,width=720,height=570'))l.href=u;};
			if (/Firefox/.test(navigator.userAgent)) setTimeout(a, 0); else a();
			void(0)";
$link = str_replace(array("\r","\n","\t"),'',$link);
{$AspisRetTemp = apply_filters('shortcut_link',$link);
return $AspisRetTemp;
} }
function site_url ( $path = '',$scheme = null ) {
$orig_scheme = $scheme;
if ( !in_array($scheme,array('http','https')))
 {if ( ('login_post' == $scheme || 'rpc' == $scheme) && (force_ssl_login() || force_ssl_admin()))
 $scheme = 'https';
elseif ( ('login' == $scheme) && (force_ssl_admin()))
 $scheme = 'https';
elseif ( ('admin' == $scheme) && force_ssl_admin())
 $scheme = 'https';
else 
{$scheme = (is_ssl() ? 'https' : 'http');
}}$url = str_replace('http://',"{$scheme}://",get_option('siteurl'));
if ( !empty($path) && is_string($path) && strpos($path,'..') === false)
 $url .= '/' . ltrim($path,'/');
{$AspisRetTemp = apply_filters('site_url',$url,$path,$orig_scheme);
return $AspisRetTemp;
} }
function admin_url ( $path = '' ) {
$url = site_url('wp-admin/','admin');
if ( !empty($path) && is_string($path) && strpos($path,'..') === false)
 $url .= ltrim($path,'/');
{$AspisRetTemp = apply_filters('admin_url',$url,$path);
return $AspisRetTemp;
} }
function includes_url ( $path = '' ) {
$url = site_url() . '/' . WPINC . '/';
if ( !empty($path) && is_string($path) && strpos($path,'..') === false)
 $url .= ltrim($path,'/');
{$AspisRetTemp = apply_filters('includes_url',$url,$path);
return $AspisRetTemp;
} }
function content_url ( $path = '' ) {
$scheme = (is_ssl() ? 'https' : 'http');
$url = WP_CONTENT_URL;
if ( 0 === strpos($url,'http'))
 {if ( is_ssl())
 $url = str_replace('http://',"{$scheme}://",$url);
}if ( !empty($path) && is_string($path) && strpos($path,'..') === false)
 $url .= '/' . ltrim($path,'/');
{$AspisRetTemp = apply_filters('content_url',$url,$path);
return $AspisRetTemp;
} }
function plugins_url ( $path = '',$plugin = '' ) {
$scheme = (is_ssl() ? 'https' : 'http');
if ( $plugin !== '' && preg_match('#^' . preg_quote(WPMU_PLUGIN_DIR . DIRECTORY_SEPARATOR,'#') . '#',$plugin))
 {$url = WPMU_PLUGIN_URL;
}else 
{{$url = WP_PLUGIN_URL;
}}if ( 0 === strpos($url,'http'))
 {if ( is_ssl())
 $url = str_replace('http://',"{$scheme}://",$url);
}if ( !empty($plugin) && is_string($plugin))
 {$folder = dirname(plugin_basename($plugin));
if ( '.' != $folder)
 $url .= '/' . ltrim($folder,'/');
}if ( !empty($path) && is_string($path) && strpos($path,'..') === false)
 $url .= '/' . ltrim($path,'/');
{$AspisRetTemp = apply_filters('plugins_url',$url,$path,$plugin);
return $AspisRetTemp;
} }
function rel_canonical (  ) {
if ( !is_singular())
 {return ;
}{global $wp_the_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_the_query,"\$wp_the_query",$AspisChangesCache);
}if ( !$id = $wp_the_query->get_queried_object_id())
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_the_query",$AspisChangesCache);
return ;
}$link = get_permalink($id);
echo "<link rel='canonical' href='$link' />\n";
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_the_query",$AspisChangesCache);
 }
;
?>
<?php 