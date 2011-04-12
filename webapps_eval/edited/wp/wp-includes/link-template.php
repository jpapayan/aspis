<?php require_once('AspisMain.php'); ?><?php
function the_permalink (  ) {
echo AspisCheckPrint(apply_filters(array('the_permalink',false),get_permalink()));
 }
function user_trailingslashit ( $string,$type_of_url = array('',false) ) {
global $wp_rewrite;
if ( $wp_rewrite[0]->use_trailing_slashes[0])
 $string = trailingslashit($string);
else 
{$string = untrailingslashit($string);
}$string = apply_filters(array('user_trailingslashit',false),$string,$type_of_url);
return $string;
 }
function permalink_anchor ( $mode = array('id',false) ) {
global $post;
switch ( deAspis(Aspis_strtolower($mode)) ) {
case ('title'):$title = concat(concat2(sanitize_title($post[0]->post_title),'-'),$post[0]->ID);
echo AspisCheckPrint(concat2(concat1('<a id="',$title),'"></a>'));
break ;
case ('id'):default :echo AspisCheckPrint(concat2(concat1('<a id="post-',$post[0]->ID),'"></a>'));
break ;
 }
 }
function get_permalink ( $id = array(0,false),$leavename = array(false,false) ) {
$rewritecode = array(array(array('%year%',false),array('%monthnum%',false),array('%day%',false),array('%hour%',false),array('%minute%',false),array('%second%',false),$leavename[0] ? array('',false) : array('%postname%',false),array('%post_id%',false),array('%category%',false),array('%author%',false),$leavename[0] ? array('',false) : array('%pagename%',false),),false);
if ( ((is_object($id[0]) && ((isset($id[0]->filter) && Aspis_isset( $id[0] ->filter )))) && (('sample') == $id[0]->filter[0])))
 {$post = $id;
$sample = array(true,false);
}else 
{{$post = &get_post($id);
$sample = array(false,false);
}}if ( ((empty($post[0]->ID) || Aspis_empty( $post[0] ->ID ))))
 return array(false,false);
if ( ($post[0]->post_type[0] == ('page')))
 return get_page_link($post[0]->ID,$leavename,$sample);
elseif ( ($post[0]->post_type[0] == ('attachment')))
 return get_attachment_link($post[0]->ID);
$permalink = get_option(array('permalink_structure',false));
if ( ((('') != $permalink[0]) && (denot_boolean(Aspis_in_array($post[0]->post_status,array(array(array('draft',false),array('pending',false)),false))))))
 {$unixtime = attAspis(strtotime($post[0]->post_date[0]));
$category = array('',false);
if ( (strpos($permalink[0],'%category%') !== false))
 {$cats = get_the_category($post[0]->ID);
if ( $cats[0])
 {Aspis_usort($cats,array('_usort_terms_by_ID',false));
$category = $cats[0][(0)][0]->slug;
if ( deAspis($parent = $cats[0][(0)][0]->parent))
 $category = concat(get_category_parents($parent,array(false,false),array('/',false),array(true,false)),$category);
}if ( ((empty($category) || Aspis_empty( $category))))
 {$default_category = get_category(get_option(array('default_category',false)));
$category = deAspis(is_wp_error($default_category)) ? array('',false) : $default_category[0]->slug;
}}$author = array('',false);
if ( (strpos($permalink[0],'%author%') !== false))
 {$authordata = get_userdata($post[0]->post_author);
$author = $authordata[0]->user_nicename;
}$date = Aspis_explode(array(" ",false),attAspis(date(('Y m d H i s'),$unixtime[0])));
$rewritereplace = array(array(attachAspis($date,(0)),attachAspis($date,(1)),attachAspis($date,(2)),attachAspis($date,(3)),attachAspis($date,(4)),attachAspis($date,(5)),$post[0]->post_name,$post[0]->ID,$category,$author,$post[0]->post_name,),false);
$permalink = concat(get_option(array('home',false)),Aspis_str_replace($rewritecode,$rewritereplace,$permalink));
$permalink = user_trailingslashit($permalink,array('single',false));
return apply_filters(array('post_link',false),$permalink,$post,$leavename);
}else 
{{$permalink = concat(concat2(trailingslashit(get_option(array('home',false))),'?p='),$post[0]->ID);
return apply_filters(array('post_link',false),$permalink,$post,$leavename);
}} }
function post_permalink ( $post_id = array(0,false),$deprecated = array('',false) ) {
return get_permalink($post_id);
 }
function get_page_link ( $id = array(false,false),$leavename = array(false,false),$sample = array(false,false) ) {
global $post;
$id = int_cast($id);
if ( (denot_boolean($id)))
 $id = int_cast($post[0]->ID);
if ( ((('page') == deAspis(get_option(array('show_on_front',false)))) && ($id[0] == deAspis(get_option(array('page_on_front',false))))))
 $link = get_option(array('home',false));
else 
{$link = _get_page_link($id,$leavename,$sample);
}return apply_filters(array('page_link',false),$link,$id);
 }
function _get_page_link ( $id = array(false,false),$leavename = array(false,false),$sample = array(false,false) ) {
global $post,$wp_rewrite;
if ( (denot_boolean($id)))
 $id = int_cast($post[0]->ID);
else 
{$post = &get_post($id);
}$pagestruct = $wp_rewrite[0]->get_page_permastruct();
if ( ((('') != $pagestruct[0]) && (((((isset($post[0]->post_status) && Aspis_isset( $post[0] ->post_status ))) && (('draft') != $post[0]->post_status[0])) && (('pending') != $post[0]->post_status[0])) || $sample[0])))
 {$link = get_page_uri($id);
$link = deAspis(($leavename)) ? $pagestruct : Aspis_str_replace(array('%pagename%',false),$link,$pagestruct);
$link = concat(trailingslashit(get_option(array('home',false))),$link);
$link = user_trailingslashit($link,array('page',false));
}else 
{{$link = concat(trailingslashit(get_option(array('home',false))),concat1("?page_id=",$id));
}}return apply_filters(array('_get_page_link',false),$link,$id);
 }
function get_attachment_link ( $id = array(false,false) ) {
global $post,$wp_rewrite;
$link = array(false,false);
if ( (denot_boolean($id)))
 {$id = int_cast($post[0]->ID);
}$object = get_post($id);
if ( ((deAspis($wp_rewrite[0]->using_permalinks()) && ($object[0]->post_parent[0] > (0))) && ($object[0]->post_parent[0] != $id[0])))
 {$parent = get_post($object[0]->post_parent);
if ( (('page') == $parent[0]->post_type[0]))
 $parentlink = _get_page_link($object[0]->post_parent);
else 
{$parentlink = get_permalink($object[0]->post_parent);
}if ( (is_numeric(deAspisRC($object[0]->post_name)) || (false !== strpos(deAspis(get_option(array('permalink_structure',false))),'%category%'))))
 $name = concat1('attachment/',$object[0]->post_name);
else 
{$name = $object[0]->post_name;
}if ( (strpos($parentlink[0],'?') === false))
 $link = user_trailingslashit(concat(trailingslashit($parentlink),$name));
}if ( (denot_boolean($link)))
 {$link = concat(trailingslashit(get_bloginfo(array('url',false))),concat1("?attachment_id=",$id));
}return apply_filters(array('attachment_link',false),$link,$id);
 }
function get_year_link ( $year ) {
global $wp_rewrite;
if ( (denot_boolean($year)))
 $year = attAspis(gmdate(('Y'),(time() + (deAspis(get_option(array('gmt_offset',false))) * (3600)))));
$yearlink = $wp_rewrite[0]->get_year_permastruct();
if ( (!((empty($yearlink) || Aspis_empty( $yearlink)))))
 {$yearlink = Aspis_str_replace(array('%year%',false),$year,$yearlink);
return apply_filters(array('year_link',false),concat(get_option(array('home',false)),user_trailingslashit($yearlink,array('year',false))),$year);
}else 
{{return apply_filters(array('year_link',false),concat(concat2(trailingslashit(get_option(array('home',false))),'?m='),$year),$year);
}} }
function get_month_link ( $year,$month ) {
global $wp_rewrite;
if ( (denot_boolean($year)))
 $year = attAspis(gmdate(('Y'),(time() + (deAspis(get_option(array('gmt_offset',false))) * (3600)))));
if ( (denot_boolean($month)))
 $month = attAspis(gmdate(('m'),(time() + (deAspis(get_option(array('gmt_offset',false))) * (3600)))));
$monthlink = $wp_rewrite[0]->get_month_permastruct();
if ( (!((empty($monthlink) || Aspis_empty( $monthlink)))))
 {$monthlink = Aspis_str_replace(array('%year%',false),$year,$monthlink);
$monthlink = Aspis_str_replace(array('%monthnum%',false),zeroise(Aspis_intval($month),array(2,false)),$monthlink);
return apply_filters(array('month_link',false),concat(get_option(array('home',false)),user_trailingslashit($monthlink,array('month',false))),$year,$month);
}else 
{{return apply_filters(array('month_link',false),concat(concat(concat2(trailingslashit(get_option(array('home',false))),'?m='),$year),zeroise($month,array(2,false))),$year,$month);
}} }
function get_day_link ( $year,$month,$day ) {
global $wp_rewrite;
if ( (denot_boolean($year)))
 $year = attAspis(gmdate(('Y'),(time() + (deAspis(get_option(array('gmt_offset',false))) * (3600)))));
if ( (denot_boolean($month)))
 $month = attAspis(gmdate(('m'),(time() + (deAspis(get_option(array('gmt_offset',false))) * (3600)))));
if ( (denot_boolean($day)))
 $day = attAspis(gmdate(('j'),(time() + (deAspis(get_option(array('gmt_offset',false))) * (3600)))));
$daylink = $wp_rewrite[0]->get_day_permastruct();
if ( (!((empty($daylink) || Aspis_empty( $daylink)))))
 {$daylink = Aspis_str_replace(array('%year%',false),$year,$daylink);
$daylink = Aspis_str_replace(array('%monthnum%',false),zeroise(Aspis_intval($month),array(2,false)),$daylink);
$daylink = Aspis_str_replace(array('%day%',false),zeroise(Aspis_intval($day),array(2,false)),$daylink);
return apply_filters(array('day_link',false),concat(get_option(array('home',false)),user_trailingslashit($daylink,array('day',false))),$year,$month,$day);
}else 
{{return apply_filters(array('day_link',false),concat(concat(concat(concat2(trailingslashit(get_option(array('home',false))),'?m='),$year),zeroise($month,array(2,false))),zeroise($day,array(2,false))),$year,$month,$day);
}} }
function get_feed_link ( $feed = array('',false) ) {
global $wp_rewrite;
$permalink = $wp_rewrite[0]->get_feed_permastruct();
if ( (('') != $permalink[0]))
 {if ( (false !== strpos($feed[0],'comments_')))
 {$feed = Aspis_str_replace(array('comments_',false),array('',false),$feed);
$permalink = $wp_rewrite[0]->get_comment_feed_permastruct();
}if ( (deAspis(get_default_feed()) == $feed[0]))
 $feed = array('',false);
$permalink = Aspis_str_replace(array('%feed%',false),$feed,$permalink);
$permalink = Aspis_preg_replace(array('#/+#',false),array('/',false),concat1("/",$permalink));
$output = concat(get_option(array('home',false)),user_trailingslashit($permalink,array('feed',false)));
}else 
{{if ( ((empty($feed) || Aspis_empty( $feed))))
 $feed = get_default_feed();
if ( (false !== strpos($feed[0],'comments_')))
 $feed = Aspis_str_replace(array('comments_',false),array('comments-',false),$feed);
$output = concat(trailingslashit(get_option(array('home',false))),concat1("?feed=",$feed));
}}return apply_filters(array('feed_link',false),$output,$feed);
 }
function get_post_comments_feed_link ( $post_id = array('',false),$feed = array('',false) ) {
global $id;
if ( ((empty($post_id) || Aspis_empty( $post_id))))
 $post_id = int_cast($id);
if ( ((empty($feed) || Aspis_empty( $feed))))
 $feed = get_default_feed();
if ( (('') != deAspis(get_option(array('permalink_structure',false)))))
 {$url = concat2(trailingslashit(get_permalink($post_id)),'feed');
if ( ($feed[0] != deAspis(get_default_feed())))
 $url = concat($url,concat1("/",$feed));
$url = user_trailingslashit($url,array('single_feed',false));
}else 
{{$type = get_post_field(array('post_type',false),$post_id);
if ( (('page') == $type[0]))
 $url = concat(trailingslashit(get_option(array('home',false))),concat(concat2(concat1("?feed=",$feed),"&amp;page_id="),$post_id));
else 
{$url = concat(trailingslashit(get_option(array('home',false))),concat(concat2(concat1("?feed=",$feed),"&amp;p="),$post_id));
}}}return apply_filters(array('post_comments_feed_link',false),$url);
 }
function post_comments_feed_link ( $link_text = array('',false),$post_id = array('',false),$feed = array('',false) ) {
$url = get_post_comments_feed_link($post_id,$feed);
if ( ((empty($link_text) || Aspis_empty( $link_text))))
 $link_text = __(array('Comments Feed',false));
echo AspisCheckPrint(apply_filters(array('post_comments_feed_link_html',false),concat2(concat(concat2(concat1("<a href='",$url),"'>"),$link_text),"</a>"),$post_id,$feed));
 }
function get_author_feed_link ( $author_id,$feed = array('',false) ) {
$author_id = int_cast($author_id);
$permalink_structure = get_option(array('permalink_structure',false));
if ( ((empty($feed) || Aspis_empty( $feed))))
 $feed = get_default_feed();
if ( (('') == $permalink_structure[0]))
 {$link = concat(concat(trailingslashit(get_option(array('home',false))),concat2(concat1("?feed=",$feed),"&amp;author=")),$author_id);
}else 
{{$link = get_author_posts_url($author_id);
if ( ($feed[0] == deAspis(get_default_feed())))
 $feed_link = array('feed',false);
else 
{$feed_link = concat1("feed/",$feed);
}$link = concat(trailingslashit($link),user_trailingslashit($feed_link,array('feed',false)));
}}$link = apply_filters(array('author_feed_link',false),$link,$feed);
return $link;
 }
function get_category_feed_link ( $cat_id,$feed = array('',false) ) {
$cat_id = int_cast($cat_id);
$category = get_category($cat_id);
if ( (((empty($category) || Aspis_empty( $category))) || deAspis(is_wp_error($category))))
 return array(false,false);
if ( ((empty($feed) || Aspis_empty( $feed))))
 $feed = get_default_feed();
$permalink_structure = get_option(array('permalink_structure',false));
if ( (('') == $permalink_structure[0]))
 {$link = concat(concat(trailingslashit(get_option(array('home',false))),concat2(concat1("?feed=",$feed),"&amp;cat=")),$cat_id);
}else 
{{$link = get_category_link($cat_id);
if ( ($feed[0] == deAspis(get_default_feed())))
 $feed_link = array('feed',false);
else 
{$feed_link = concat1("feed/",$feed);
}$link = concat(trailingslashit($link),user_trailingslashit($feed_link,array('feed',false)));
}}$link = apply_filters(array('category_feed_link',false),$link,$feed);
return $link;
 }
function get_tag_feed_link ( $tag_id,$feed = array('',false) ) {
$tag_id = int_cast($tag_id);
$tag = get_tag($tag_id);
if ( (((empty($tag) || Aspis_empty( $tag))) || deAspis(is_wp_error($tag))))
 return array(false,false);
$permalink_structure = get_option(array('permalink_structure',false));
if ( ((empty($feed) || Aspis_empty( $feed))))
 $feed = get_default_feed();
if ( (('') == $permalink_structure[0]))
 {$link = concat(concat(trailingslashit(get_option(array('home',false))),concat2(concat1("?feed=",$feed),"&amp;tag=")),$tag[0]->slug);
}else 
{{$link = get_tag_link($tag[0]->term_id);
if ( ($feed[0] == deAspis(get_default_feed())))
 $feed_link = array('feed',false);
else 
{$feed_link = concat1("feed/",$feed);
}$link = concat(trailingslashit($link),user_trailingslashit($feed_link,array('feed',false)));
}}$link = apply_filters(array('tag_feed_link',false),$link,$feed);
return $link;
 }
function get_edit_tag_link ( $tag_id = array(0,false),$taxonomy = array('post_tag',false) ) {
$tag = get_term($tag_id,$taxonomy);
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 return ;
$location = admin_url(concat(concat2(concat1('edit-tags.php?action=edit&amp;taxonomy=',$taxonomy),'&amp;tag_ID='),$tag[0]->term_id));
return apply_filters(array('get_edit_tag_link',false),$location);
 }
function edit_tag_link ( $link = array('',false),$before = array('',false),$after = array('',false),$tag = array(null,false) ) {
$tag = get_term($tag,array('post_tag',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 return ;
if ( ((empty($link) || Aspis_empty( $link))))
 $link = __(array('Edit This',false));
$link = concat2(concat(concat2(concat(concat2(concat1('<a href="',get_edit_tag_link($tag[0]->term_id)),'" title="'),__(array('Edit tag',false))),'">'),$link),'</a>');
echo AspisCheckPrint(concat(concat($before,apply_filters(array('edit_tag_link',false),$link,$tag[0]->term_id)),$after));
 }
function get_search_feed_link ( $search_query = array('',false),$feed = array('',false) ) {
if ( ((empty($search_query) || Aspis_empty( $search_query))))
 $search = esc_attr(Aspis_urlencode(get_search_query()));
else 
{$search = esc_attr(Aspis_urlencode(Aspis_stripslashes($search_query)));
}if ( ((empty($feed) || Aspis_empty( $feed))))
 $feed = get_default_feed();
$link = concat(trailingslashit(get_option(array('home',false))),concat(concat2(concat1("?s=",$search),"&amp;feed="),$feed));
$link = apply_filters(array('search_feed_link',false),$link);
return $link;
 }
function get_search_comments_feed_link ( $search_query = array('',false),$feed = array('',false) ) {
if ( ((empty($search_query) || Aspis_empty( $search_query))))
 $search = esc_attr(Aspis_urlencode(get_search_query()));
else 
{$search = esc_attr(Aspis_urlencode(Aspis_stripslashes($search_query)));
}if ( ((empty($feed) || Aspis_empty( $feed))))
 $feed = get_default_feed();
$link = concat(trailingslashit(get_option(array('home',false))),concat(concat2(concat1("?s=",$search),"&amp;feed=comments-"),$feed));
$link = apply_filters(array('search_feed_link',false),$link);
return $link;
 }
function get_edit_post_link ( $id = array(0,false),$context = array('display',false) ) {
if ( (denot_boolean($post = &get_post($id))))
 return ;
if ( (('display') == $context[0]))
 $action = array('action=edit&amp;',false);
else 
{$action = array('action=edit&',false);
}switch ( $post[0]->post_type[0] ) {
case ('page'):if ( (denot_boolean(current_user_can(array('edit_page',false),$post[0]->ID))))
 return ;
$file = array('page',false);
$var = array('post',false);
break ;
;
case ('attachment'):if ( (denot_boolean(current_user_can(array('edit_post',false),$post[0]->ID))))
 return ;
$file = array('media',false);
$var = array('attachment_id',false);
break ;
case ('revision'):if ( (denot_boolean(current_user_can(array('edit_post',false),$post[0]->ID))))
 return ;
$file = array('revision',false);
$var = array('revision',false);
$action = array('',false);
break ;
default :if ( (denot_boolean(current_user_can(array('edit_post',false),$post[0]->ID))))
 return apply_filters(array('get_edit_post_link',false),array('',false),$post[0]->ID,$context);
;
$file = array('post',false);
$var = array('post',false);
break ;
 }
return apply_filters(array('get_edit_post_link',false),admin_url(concat(concat2(concat(concat2($file,".php?"),$action),"="),$post[0]->ID)),$post[0]->ID,$context);
 }
function edit_post_link ( $link = array(null,false),$before = array('',false),$after = array('',false),$id = array(0,false) ) {
if ( (denot_boolean($post = &get_post($id))))
 return ;
if ( (denot_boolean($url = get_edit_post_link($post[0]->ID))))
 return ;
if ( (null === $link[0]))
 $link = __(array('Edit This',false));
$link = concat2(concat(concat2(concat(concat2(concat1('<a class="post-edit-link" href="',$url),'" title="'),esc_attr(__(array('Edit post',false)))),'">'),$link),'</a>');
echo AspisCheckPrint(concat(concat($before,apply_filters(array('edit_post_link',false),$link,$post[0]->ID)),$after));
 }
function get_delete_post_link ( $id = array(0,false),$context = array('display',false) ) {
if ( (denot_boolean($post = &get_post($id))))
 return ;
if ( (('display') == $context[0]))
 $action = array('action=trash&amp;',false);
else 
{$action = array('action=trash&',false);
}switch ( $post[0]->post_type[0] ) {
case ('page'):if ( (denot_boolean(current_user_can(array('delete_page',false),$post[0]->ID))))
 return ;
$file = array('page',false);
$var = array('post',false);
break ;
;
case ('attachment'):if ( (denot_boolean(current_user_can(array('delete_post',false),$post[0]->ID))))
 return ;
$file = array('media',false);
$var = array('attachment_id',false);
break ;
case ('revision'):if ( (denot_boolean(current_user_can(array('delete_post',false),$post[0]->ID))))
 return ;
$file = array('revision',false);
$var = array('revision',false);
$action = array('',false);
break ;
default :if ( (denot_boolean(current_user_can(array('edit_post',false),$post[0]->ID))))
 return apply_filters(array('get_delete_post_link',false),array('',false),$post[0]->ID,$context);
;
$file = array('post',false);
$var = array('post',false);
break ;
 }
return apply_filters(array('get_delete_post_link',false),wp_nonce_url(admin_url(concat(concat2(concat(concat2($file,".php?"),$action),"="),$post[0]->ID)),concat(concat2(concat1("trash-",$file),"_"),$post[0]->ID)),$context);
 }
function get_edit_comment_link ( $comment_id = array(0,false) ) {
$comment = &get_comment($comment_id);
$post = &get_post($comment[0]->comment_post_ID);
if ( ($post[0]->post_type[0] == ('page')))
 {if ( (denot_boolean(current_user_can(array('edit_page',false),$post[0]->ID))))
 return ;
}else 
{{if ( (denot_boolean(current_user_can(array('edit_post',false),$post[0]->ID))))
 return ;
}}$location = concat(admin_url(array('comment.php?action=editcomment&amp;c=',false)),$comment[0]->comment_ID);
return apply_filters(array('get_edit_comment_link',false),$location);
 }
function edit_comment_link ( $link = array(null,false),$before = array('',false),$after = array('',false) ) {
global $comment,$post;
if ( ($post[0]->post_type[0] == ('page')))
 {if ( (denot_boolean(current_user_can(array('edit_page',false),$post[0]->ID))))
 return ;
}else 
{{if ( (denot_boolean(current_user_can(array('edit_post',false),$post[0]->ID))))
 return ;
}}if ( (null === $link[0]))
 $link = __(array('Edit This',false));
$link = concat2(concat(concat2(concat(concat2(concat1('<a class="comment-edit-link" href="',get_edit_comment_link($comment[0]->comment_ID)),'" title="'),__(array('Edit comment',false))),'">'),$link),'</a>');
echo AspisCheckPrint(concat(concat($before,apply_filters(array('edit_comment_link',false),$link,$comment[0]->comment_ID)),$after));
 }
function get_edit_bookmark_link ( $link = array(0,false) ) {
$link = get_bookmark($link);
if ( (denot_boolean(current_user_can(array('manage_links',false)))))
 return ;
$location = concat(admin_url(array('link.php?action=edit&amp;link_id=',false)),$link[0]->link_id);
return apply_filters(array('get_edit_bookmark_link',false),$location,$link[0]->link_id);
 }
function edit_bookmark_link ( $link = array('',false),$before = array('',false),$after = array('',false),$bookmark = array(null,false) ) {
$bookmark = get_bookmark($bookmark);
if ( (denot_boolean(current_user_can(array('manage_links',false)))))
 return ;
if ( ((empty($link) || Aspis_empty( $link))))
 $link = __(array('Edit This',false));
$link = concat2(concat(concat2(concat(concat2(concat1('<a href="',get_edit_bookmark_link($link)),'" title="'),__(array('Edit link',false))),'">'),$link),'</a>');
echo AspisCheckPrint(concat(concat($before,apply_filters(array('edit_bookmark_link',false),$link,$bookmark[0]->link_id)),$after));
 }
function get_previous_post ( $in_same_cat = array(false,false),$excluded_categories = array('',false) ) {
return get_adjacent_post($in_same_cat,$excluded_categories);
 }
function get_next_post ( $in_same_cat = array(false,false),$excluded_categories = array('',false) ) {
return get_adjacent_post($in_same_cat,$excluded_categories,array(false,false));
 }
function get_adjacent_post ( $in_same_cat = array(false,false),$excluded_categories = array('',false),$previous = array(true,false) ) {
global $post,$wpdb;
if ( ((((empty($post) || Aspis_empty( $post))) || (denot_boolean(is_single()))) || deAspis(is_attachment())))
 return array(null,false);
$current_post_date = $post[0]->post_date;
$join = array('',false);
$posts_in_ex_cats_sql = array('',false);
if ( ($in_same_cat[0] || (!((empty($excluded_categories) || Aspis_empty( $excluded_categories))))))
 {$join = concat2(concat(concat2(concat1(" INNER JOIN ",$wpdb[0]->term_relationships)," AS tr ON p.ID = tr.object_id INNER JOIN "),$wpdb[0]->term_taxonomy)," tt ON tr.term_taxonomy_id = tt.term_taxonomy_id");
if ( $in_same_cat[0])
 {$cat_array = wp_get_object_terms($post[0]->ID,array('category',false),array('fields=ids',false));
$join = concat($join,concat2(concat1(" AND tt.taxonomy = 'category' AND tt.term_id IN (",Aspis_implode(array(',',false),$cat_array)),")"));
}$posts_in_ex_cats_sql = array("AND tt.taxonomy = 'category'",false);
if ( (!((empty($excluded_categories) || Aspis_empty( $excluded_categories)))))
 {$excluded_categories = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC(Aspis_explode(array(' and ',false),$excluded_categories))));
if ( (!((empty($cat_array) || Aspis_empty( $cat_array)))))
 {$excluded_categories = Aspis_array_diff($excluded_categories,$cat_array);
$posts_in_ex_cats_sql = array('',false);
}if ( (!((empty($excluded_categories) || Aspis_empty( $excluded_categories)))))
 {$posts_in_ex_cats_sql = concat2(concat1(" AND tt.taxonomy = 'category' AND tt.term_id NOT IN (",Aspis_implode($excluded_categories,array(',',false))),')');
}}}$adjacent = $previous[0] ? array('previous',false) : array('next',false);
$op = $previous[0] ? array('<',false) : array('>',false);
$order = $previous[0] ? array('DESC',false) : array('ASC',false);
$join = apply_filters(concat2(concat1("get_",$adjacent),"_post_join"),$join,$in_same_cat,$excluded_categories);
$where = apply_filters(concat2(concat1("get_",$adjacent),"_post_where"),$wpdb[0]->prepare(concat(concat2(concat1("WHERE p.post_date ",$op)," %s AND p.post_type = %s AND p.post_status = 'publish' "),$posts_in_ex_cats_sql),$current_post_date,$post[0]->post_type),$in_same_cat,$excluded_categories);
$sort = apply_filters(concat2(concat1("get_",$adjacent),"_post_sort"),concat2(concat1("ORDER BY p.post_date ",$order)," LIMIT 1"));
$query = concat(concat2(concat(concat2(concat(concat2(concat1("SELECT p.* FROM ",$wpdb[0]->posts)," AS p "),$join)," "),$where)," "),$sort);
$query_key = concat1('adjacent_post_',attAspis(md5($query[0])));
$result = wp_cache_get($query_key,array('counts',false));
if ( (false !== $result[0]))
 return $result;
$result = $wpdb[0]->get_row(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT p.* FROM ",$wpdb[0]->posts)," AS p "),$join)," "),$where)," "),$sort));
if ( (null === $result[0]))
 $result = array('',false);
wp_cache_set($query_key,$result,array('counts',false));
return $result;
 }
function get_adjacent_post_rel_link ( $title = array('%title',false),$in_same_cat = array(false,false),$excluded_categories = array('',false),$previous = array(true,false) ) {
if ( ($previous[0] && deAspis(is_attachment())))
 $post = &get_post($GLOBALS[0][('post')][0]->post_parent);
else 
{$post = get_adjacent_post($in_same_cat,$excluded_categories,$previous);
}if ( ((empty($post) || Aspis_empty( $post))))
 return ;
if ( ((empty($post[0]->post_title) || Aspis_empty( $post[0] ->post_title ))))
 $post[0]->post_title = $previous[0] ? __(array('Previous Post',false)) : __(array('Next Post',false));
$date = mysql2date(get_option(array('date_format',false)),$post[0]->post_date);
$title = Aspis_str_replace(array('%title',false),$post[0]->post_title,$title);
$title = Aspis_str_replace(array('%date',false),$date,$title);
$title = apply_filters(array('the_title',false),$title,$post);
$link = $previous[0] ? array("<link rel='prev' title='",false) : array("<link rel='next' title='",false);
$link = concat($link,esc_attr($title));
$link = concat($link,concat2(concat1("' href='",get_permalink($post)),"' />\n"));
$adjacent = $previous[0] ? array('previous',false) : array('next',false);
return apply_filters(concat2($adjacent,"_post_rel_link"),$link);
 }
function adjacent_posts_rel_link ( $title = array('%title',false),$in_same_cat = array(false,false),$excluded_categories = array('',false) ) {
echo AspisCheckPrint(get_adjacent_post_rel_link($title,$in_same_cat,$excluded_categories = array('',false),array(true,false)));
echo AspisCheckPrint(get_adjacent_post_rel_link($title,$in_same_cat,$excluded_categories = array('',false),array(false,false)));
 }
function next_post_rel_link ( $title = array('%title',false),$in_same_cat = array(false,false),$excluded_categories = array('',false) ) {
echo AspisCheckPrint(get_adjacent_post_rel_link($title,$in_same_cat,$excluded_categories = array('',false),array(false,false)));
 }
function prev_post_rel_link ( $title = array('%title',false),$in_same_cat = array(false,false),$excluded_categories = array('',false) ) {
echo AspisCheckPrint(get_adjacent_post_rel_link($title,$in_same_cat,$excluded_categories = array('',false),array(true,false)));
 }
function get_boundary_post ( $in_same_cat = array(false,false),$excluded_categories = array('',false),$start = array(true,false) ) {
global $post,$wpdb;
if ( ((((empty($post) || Aspis_empty( $post))) || (denot_boolean(is_single()))) || deAspis(is_attachment())))
 return array(null,false);
$cat_array = array(array(),false);
$excluded_categories = array(array(),false);
if ( ((!((empty($in_same_cat) || Aspis_empty( $in_same_cat)))) || (!((empty($excluded_categories) || Aspis_empty( $excluded_categories))))))
 {if ( (!((empty($in_same_cat) || Aspis_empty( $in_same_cat)))))
 {$cat_array = wp_get_object_terms($post[0]->ID,array('category',false),array('fields=ids',false));
}if ( (!((empty($excluded_categories) || Aspis_empty( $excluded_categories)))))
 {$excluded_categories = attAspisRC(array_map(AspisInternalCallback(array('intval',false)),deAspisRC(Aspis_explode(array(',',false),$excluded_categories))));
if ( (!((empty($cat_array) || Aspis_empty( $cat_array)))))
 $excluded_categories = Aspis_array_diff($excluded_categories,$cat_array);
$inverse_cats = array(array(),false);
foreach ( $excluded_categories[0] as $excluded_category  )
arrayAssignAdd($inverse_cats[0][],addTaint(array($excluded_category[0] * deAspis(negate(array(1,false))),false)));
$excluded_categories = $inverse_cats;
}}$categories = Aspis_implode(array(',',false),Aspis_array_merge($cat_array,$excluded_categories));
$order = $start[0] ? array('ASC',false) : array('DESC',false);
return get_posts(array(array('numberposts' => array(1,false,false),deregisterTaint(array('order',false)) => addTaint($order),'orderby' => array('ID',false,false),deregisterTaint(array('category',false)) => addTaint($categories)),false));
 }
function get_boundary_post_rel_link ( $title = array('%title',false),$in_same_cat = array(false,false),$excluded_categories = array('',false),$start = array(true,false) ) {
$posts = get_boundary_post($in_same_cat,$excluded_categories,$start);
$post = attachAspis($posts,(0));
if ( ((empty($post) || Aspis_empty( $post))))
 return ;
if ( ((empty($post[0]->post_title) || Aspis_empty( $post[0] ->post_title ))))
 $post[0]->post_title = $start[0] ? __(array('First Post',false)) : __(array('Last Post',false));
$date = mysql2date(get_option(array('date_format',false)),$post[0]->post_date);
$title = Aspis_str_replace(array('%title',false),$post[0]->post_title,$title);
$title = Aspis_str_replace(array('%date',false),$date,$title);
$title = apply_filters(array('the_title',false),$title,$post);
$link = $start[0] ? array("<link rel='start' title='",false) : array("<link rel='end' title='",false);
$link = concat($link,esc_attr($title));
$link = concat($link,concat2(concat1("' href='",get_permalink($post)),"' />\n"));
$boundary = $start[0] ? array('start',false) : array('end',false);
return apply_filters(concat2($boundary,"_post_rel_link"),$link);
 }
function start_post_rel_link ( $title = array('%title',false),$in_same_cat = array(false,false),$excluded_categories = array('',false) ) {
echo AspisCheckPrint(get_boundary_post_rel_link($title,$in_same_cat,$excluded_categories,array(true,false)));
 }
function get_index_rel_link (  ) {
$link = concat2(concat(concat2(concat1("<link rel='index' title='",esc_attr(get_bloginfo(array('name',false)))),"' href='"),get_bloginfo(array('siteurl',false))),"' />\n");
return apply_filters(array("index_rel_link",false),$link);
 }
function index_rel_link (  ) {
echo AspisCheckPrint(get_index_rel_link());
 }
function get_parent_post_rel_link ( $title = array('%title',false) ) {
if ( ((!((empty($GLOBALS[0][('post')]) || Aspis_empty( $GLOBALS [0][('post')])))) && (!((empty($GLOBALS[0][('post')][0]->post_parent) || Aspis_empty( $GLOBALS [0][('post')][0] ->post_parent ))))))
 $post = &get_post($GLOBALS[0][('post')][0]->post_parent);
if ( ((empty($post) || Aspis_empty( $post))))
 return ;
$date = mysql2date(get_option(array('date_format',false)),$post[0]->post_date);
$title = Aspis_str_replace(array('%title',false),$post[0]->post_title,$title);
$title = Aspis_str_replace(array('%date',false),$date,$title);
$title = apply_filters(array('the_title',false),$title,$post);
$link = array("<link rel='up' title='",false);
$link = concat($link,esc_attr($title));
$link = concat($link,concat2(concat1("' href='",get_permalink($post)),"' />\n"));
return apply_filters(array("parent_post_rel_link",false),$link);
 }
function parent_post_rel_link ( $title = array('%title',false) ) {
echo AspisCheckPrint(get_parent_post_rel_link($title));
 }
function previous_post_link ( $format = array('&laquo; %link',false),$link = array('%title',false),$in_same_cat = array(false,false),$excluded_categories = array('',false) ) {
adjacent_post_link($format,$link,$in_same_cat,$excluded_categories,array(true,false));
 }
function next_post_link ( $format = array('%link &raquo;',false),$link = array('%title',false),$in_same_cat = array(false,false),$excluded_categories = array('',false) ) {
adjacent_post_link($format,$link,$in_same_cat,$excluded_categories,array(false,false));
 }
function adjacent_post_link ( $format,$link,$in_same_cat = array(false,false),$excluded_categories = array('',false),$previous = array(true,false) ) {
if ( ($previous[0] && deAspis(is_attachment())))
 $post = &get_post($GLOBALS[0][('post')][0]->post_parent);
else 
{$post = get_adjacent_post($in_same_cat,$excluded_categories,$previous);
}if ( (denot_boolean($post)))
 return ;
$title = $post[0]->post_title;
if ( ((empty($post[0]->post_title) || Aspis_empty( $post[0] ->post_title ))))
 $title = $previous[0] ? __(array('Previous Post',false)) : __(array('Next Post',false));
$title = apply_filters(array('the_title',false),$title,$post);
$date = mysql2date(get_option(array('date_format',false)),$post[0]->post_date);
$rel = $previous[0] ? array('prev',false) : array('next',false);
$string = concat2(concat(concat2(concat1('<a href="',get_permalink($post)),'" rel="'),$rel),'">');
$link = Aspis_str_replace(array('%title',false),$title,$link);
$link = Aspis_str_replace(array('%date',false),$date,$link);
$link = concat2(concat($string,$link),'</a>');
$format = Aspis_str_replace(array('%link',false),$link,$format);
$adjacent = $previous[0] ? array('previous',false) : array('next',false);
echo AspisCheckPrint(apply_filters(concat2($adjacent,"_post_link"),$format,$link));
 }
function get_pagenum_link ( $pagenum = array(1,false) ) {
global $wp_rewrite;
$pagenum = int_cast($pagenum);
$request = remove_query_arg(array('paged',false));
$home_root = Aspis_parse_url(get_option(array('home',false)));
$home_root = ((isset($home_root[0][('path')]) && Aspis_isset( $home_root [0][('path')]))) ? $home_root[0]['path'] : array('',false);
$home_root = Aspis_preg_quote(trailingslashit($home_root),array('|',false));
$request = Aspis_preg_replace(concat2(concat1('|^',$home_root),'|'),array('',false),$request);
$request = Aspis_preg_replace(array('|^/+|',false),array('',false),$request);
if ( ((denot_boolean($wp_rewrite[0]->using_permalinks())) || deAspis(is_admin())))
 {$base = trailingslashit(get_bloginfo(array('home',false)));
if ( ($pagenum[0] > (1)))
 {$result = add_query_arg(array('paged',false),$pagenum,concat($base,$request));
}else 
{{$result = concat($base,$request);
}}}else 
{{$qs_regex = array('|\?.*?$|',false);
Aspis_preg_match($qs_regex,$request,$qs_match);
if ( (!((empty($qs_match[0][(0)]) || Aspis_empty( $qs_match [0][(0)])))))
 {$query_string = attachAspis($qs_match,(0));
$request = Aspis_preg_replace($qs_regex,array('',false),$request);
}else 
{{$query_string = array('',false);
}}$request = Aspis_preg_replace(array('|page/\d+/?$|',false),array('',false),$request);
$request = Aspis_preg_replace(array('|^index\.php|',false),array('',false),$request);
$request = Aspis_ltrim($request,array('/',false));
$base = trailingslashit(get_bloginfo(array('url',false)));
if ( (deAspis($wp_rewrite[0]->using_index_permalinks()) && (($pagenum[0] > (1)) || (('') != $request[0]))))
 $base = concat2($base,'index.php/');
if ( ($pagenum[0] > (1)))
 {$request = concat(((!((empty($request) || Aspis_empty( $request)))) ? trailingslashit($request) : $request),user_trailingslashit(concat1('page/',$pagenum),array('paged',false)));
}$result = concat(concat($base,$request),$query_string);
}}$result = apply_filters(array('get_pagenum_link',false),$result);
return $result;
 }
function get_next_posts_page_link ( $max_page = array(0,false) ) {
global $paged;
if ( (denot_boolean(is_single())))
 {if ( (denot_boolean($paged)))
 $paged = array(1,false);
$nextpage = array(deAspis(Aspis_intval($paged)) + (1),false);
if ( ((denot_boolean($max_page)) || ($max_page[0] >= $nextpage[0])))
 return get_pagenum_link($nextpage);
} }
function next_posts ( $max_page = array(0,false),$echo = array(true,false) ) {
$output = esc_url(get_next_posts_page_link($max_page));
if ( $echo[0])
 echo AspisCheckPrint($output);
else 
{return $output;
} }
function get_next_posts_link ( $label = array('Next Page &raquo;',false),$max_page = array(0,false) ) {
global $paged,$wp_query;
if ( (denot_boolean($max_page)))
 {$max_page = $wp_query[0]->max_num_pages;
}if ( (denot_boolean($paged)))
 $paged = array(1,false);
$nextpage = array(deAspis(Aspis_intval($paged)) + (1),false);
if ( ((denot_boolean(is_single())) && (((empty($paged) || Aspis_empty( $paged))) || ($nextpage[0] <= $max_page[0]))))
 {$attr = apply_filters(array('next_posts_link_attributes',false),array('',false));
return concat2(concat(concat(concat1('<a href="',next_posts($max_page,array(false,false))),concat2(concat1("\" ",$attr),">")),Aspis_preg_replace(array('/&([^#])(?![a-z]{1,8};)/',false),array('&#038;$1',false),$label)),'</a>');
} }
function next_posts_link ( $label = array('Next Page &raquo;',false),$max_page = array(0,false) ) {
echo AspisCheckPrint(get_next_posts_link($label,$max_page));
 }
function get_previous_posts_page_link (  ) {
global $paged;
if ( (denot_boolean(is_single())))
 {$nextpage = array(deAspis(Aspis_intval($paged)) - (1),false);
if ( ($nextpage[0] < (1)))
 $nextpage = array(1,false);
return get_pagenum_link($nextpage);
} }
function previous_posts ( $echo = array(true,false) ) {
$output = esc_url(get_previous_posts_page_link());
if ( $echo[0])
 echo AspisCheckPrint($output);
else 
{return $output;
} }
function get_previous_posts_link ( $label = array('&laquo; Previous Page',false) ) {
global $paged;
if ( ((denot_boolean(is_single())) && ($paged[0] > (1))))
 {$attr = apply_filters(array('previous_posts_link_attributes',false),array('',false));
return concat2(concat(concat(concat1('<a href="',previous_posts(array(false,false))),concat2(concat1("\" ",$attr),">")),Aspis_preg_replace(array('/&([^#])(?![a-z]{1,8};)/',false),array('&#038;$1',false),$label)),'</a>');
} }
function previous_posts_link ( $label = array('&laquo; Previous Page',false) ) {
echo AspisCheckPrint(get_previous_posts_link($label));
 }
function get_posts_nav_link ( $args = array(array(),false) ) {
global $wp_query;
$return = array('',false);
if ( (denot_boolean(is_singular())))
 {$defaults = array(array('sep' => array(' &#8212; ',false,false),deregisterTaint(array('prelabel',false)) => addTaint(__(array('&laquo; Previous Page',false))),deregisterTaint(array('nxtlabel',false)) => addTaint(__(array('Next Page &raquo;',false))),),false);
$args = wp_parse_args($args,$defaults);
$max_num_pages = $wp_query[0]->max_num_pages;
$paged = get_query_var(array('paged',false));
if ( (($paged[0] < (2)) || ($paged[0] >= $max_num_pages[0])))
 {arrayAssign($args[0],deAspis(registerTaint(array('sep',false))),addTaint(array('',false)));
}if ( ($max_num_pages[0] > (1)))
 {$return = get_previous_posts_link($args[0]['prelabel']);
$return = concat($return,Aspis_preg_replace(array('/&([^#])(?![a-z]{1,8};)/',false),array('&#038;$1',false),$args[0]['sep']));
$return = concat($return,get_next_posts_link($args[0]['nxtlabel']));
}}return $return;
 }
function posts_nav_link ( $sep = array('',false),$prelabel = array('',false),$nxtlabel = array('',false) ) {
$args = attAspisRC(array_filter(deAspisRC(array(compact('sep','prelabel','nxtlabel'),false))));
echo AspisCheckPrint(get_posts_nav_link($args));
 }
function get_comments_pagenum_link ( $pagenum = array(1,false),$max_page = array(0,false) ) {
global $post,$wp_rewrite;
$pagenum = int_cast($pagenum);
$result = get_permalink($post[0]->ID);
if ( (('newest') == deAspis(get_option(array('default_comments_page',false)))))
 {if ( ($pagenum[0] != $max_page[0]))
 {if ( deAspis($wp_rewrite[0]->using_permalinks()))
 $result = user_trailingslashit(concat(concat2(trailingslashit($result),'comment-page-'),$pagenum),array('commentpaged',false));
else 
{$result = add_query_arg(array('cpage',false),$pagenum,$result);
}}}elseif ( ($pagenum[0] > (1)))
 {if ( deAspis($wp_rewrite[0]->using_permalinks()))
 $result = user_trailingslashit(concat(concat2(trailingslashit($result),'comment-page-'),$pagenum),array('commentpaged',false));
else 
{$result = add_query_arg(array('cpage',false),$pagenum,$result);
}}$result = concat2($result,'#comments');
$result = apply_filters(array('get_comments_pagenum_link',false),$result);
return $result;
 }
function get_next_comments_link ( $label = array('',false),$max_page = array(0,false) ) {
global $wp_query;
if ( ((denot_boolean(is_singular())) || (denot_boolean(get_option(array('page_comments',false))))))
 return ;
$page = get_query_var(array('cpage',false));
$nextpage = array(deAspis(Aspis_intval($page)) + (1),false);
if ( ((empty($max_page) || Aspis_empty( $max_page))))
 $max_page = $wp_query[0]->max_num_comment_pages;
if ( ((empty($max_page) || Aspis_empty( $max_page))))
 $max_page = get_comment_pages_count();
if ( ($nextpage[0] > $max_page[0]))
 return ;
if ( ((empty($label) || Aspis_empty( $label))))
 $label = __(array('Newer Comments &raquo;',false));
return concat2(concat(concat2(concat(concat2(concat1('<a href="',esc_url(get_comments_pagenum_link($nextpage,$max_page))),'" '),apply_filters(array('next_comments_link_attributes',false),array('',false))),'>'),Aspis_preg_replace(array('/&([^#])(?![a-z]{1,8};)/',false),array('&#038;$1',false),$label)),'</a>');
 }
function next_comments_link ( $label = array('',false),$max_page = array(0,false) ) {
echo AspisCheckPrint(get_next_comments_link($label,$max_page));
 }
function get_previous_comments_link ( $label = array('',false) ) {
if ( ((denot_boolean(is_singular())) || (denot_boolean(get_option(array('page_comments',false))))))
 return ;
$page = get_query_var(array('cpage',false));
if ( (deAspis(Aspis_intval($page)) <= (1)))
 return ;
$prevpage = array(deAspis(Aspis_intval($page)) - (1),false);
if ( ((empty($label) || Aspis_empty( $label))))
 $label = __(array('&laquo; Older Comments',false));
return concat2(concat(concat2(concat(concat2(concat1('<a href="',esc_url(get_comments_pagenum_link($prevpage))),'" '),apply_filters(array('previous_comments_link_attributes',false),array('',false))),'>'),Aspis_preg_replace(array('/&([^#])(?![a-z]{1,8};)/',false),array('&#038;$1',false),$label)),'</a>');
 }
function previous_comments_link ( $label = array('',false) ) {
echo AspisCheckPrint(get_previous_comments_link($label));
 }
function paginate_comments_links ( $args = array(array(),false) ) {
global $wp_query,$wp_rewrite;
if ( ((denot_boolean(is_singular())) || (denot_boolean(get_option(array('page_comments',false))))))
 return ;
$page = get_query_var(array('cpage',false));
if ( (denot_boolean($page)))
 $page = array(1,false);
$max_page = get_comment_pages_count();
$defaults = array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('cpage',false),array('%#%',false))),'format' => array('',false,false),deregisterTaint(array('total',false)) => addTaint($max_page),deregisterTaint(array('current',false)) => addTaint($page),'echo' => array(true,false,false),'add_fragment' => array('#comments',false,false)),false);
if ( deAspis($wp_rewrite[0]->using_permalinks()))
 arrayAssign($defaults[0],deAspis(registerTaint(array('base',false))),addTaint(user_trailingslashit(concat2(trailingslashit(get_permalink()),'comment-page-%#%'),array('commentpaged',false))));
$args = wp_parse_args($args,$defaults);
$page_links = paginate_links($args);
if ( deAspis($args[0]['echo']))
 echo AspisCheckPrint($page_links);
else 
{return $page_links;
} }
function get_shortcut_link (  ) {
$link = concat2(concat1("javascript:
			var d=document,
			w=window,
			e=w.getSelection,
			k=d.getSelection,
			x=d.selection,
			s=(e?e():(k)?k():(x?x.createRange().text:0)),
			f='",admin_url(array('press-this.php',false))),"',
			l=d.location,
			e=encodeURIComponent,
			u=f+'?u='+e(l.href)+'&t='+e(d.title)+'&s='+e(s)+'&v=4';
			a=function(){if(!w.open(u,'t','toolbar=0,resizable=1,scrollbars=1,status=1,width=720,height=570'))l.href=u;};
			if (/Firefox/.test(navigator.userAgent)) setTimeout(a, 0); else a();
			void(0)");
$link = Aspis_str_replace(array(array(array("\r",false),array("\n",false),array("\t",false)),false),array('',false),$link);
return apply_filters(array('shortcut_link',false),$link);
 }
function site_url ( $path = array('',false),$scheme = array(null,false) ) {
$orig_scheme = $scheme;
if ( (denot_boolean(Aspis_in_array($scheme,array(array(array('http',false),array('https',false)),false)))))
 {if ( (((('login_post') == $scheme[0]) || (('rpc') == $scheme[0])) && (deAspis(force_ssl_login()) || deAspis(force_ssl_admin()))))
 $scheme = array('https',false);
elseif ( ((('login') == $scheme[0]) && deAspis((force_ssl_admin()))))
 $scheme = array('https',false);
elseif ( ((('admin') == $scheme[0]) && deAspis(force_ssl_admin())))
 $scheme = array('https',false);
else 
{$scheme = (deAspis(is_ssl()) ? array('https',false) : array('http',false));
}}$url = Aspis_str_replace(array('http://',false),concat2($scheme,"://"),get_option(array('siteurl',false)));
if ( (((!((empty($path) || Aspis_empty( $path)))) && is_string(deAspisRC($path))) && (strpos($path[0],'..') === false)))
 $url = concat($url,concat1('/',Aspis_ltrim($path,array('/',false))));
return apply_filters(array('site_url',false),$url,$path,$orig_scheme);
 }
function admin_url ( $path = array('',false) ) {
$url = site_url(array('wp-admin/',false),array('admin',false));
if ( (((!((empty($path) || Aspis_empty( $path)))) && is_string(deAspisRC($path))) && (strpos($path[0],'..') === false)))
 $url = concat($url,Aspis_ltrim($path,array('/',false)));
return apply_filters(array('admin_url',false),$url,$path);
 }
function includes_url ( $path = array('',false) ) {
$url = concat2(concat2(concat2(site_url(),'/'),WPINC),'/');
if ( (((!((empty($path) || Aspis_empty( $path)))) && is_string(deAspisRC($path))) && (strpos($path[0],'..') === false)))
 $url = concat($url,Aspis_ltrim($path,array('/',false)));
return apply_filters(array('includes_url',false),$url,$path);
 }
function content_url ( $path = array('',false) ) {
$scheme = (deAspis(is_ssl()) ? array('https',false) : array('http',false));
$url = array(WP_CONTENT_URL,false);
if ( ((0) === strpos($url[0],'http')))
 {if ( deAspis(is_ssl()))
 $url = Aspis_str_replace(array('http://',false),concat2($scheme,"://"),$url);
}if ( (((!((empty($path) || Aspis_empty( $path)))) && is_string(deAspisRC($path))) && (strpos($path[0],'..') === false)))
 $url = concat($url,concat1('/',Aspis_ltrim($path,array('/',false))));
return apply_filters(array('content_url',false),$url,$path);
 }
function plugins_url ( $path = array('',false),$plugin = array('',false) ) {
$scheme = (deAspis(is_ssl()) ? array('https',false) : array('http',false));
if ( (($plugin[0] !== ('')) && deAspis(Aspis_preg_match(concat2(concat1('#^',Aspis_preg_quote(concat12(WPMU_PLUGIN_DIR,DIRECTORY_SEPARATOR),array('#',false))),'#'),$plugin))))
 {$url = array(WPMU_PLUGIN_URL,false);
}else 
{{$url = array(WP_PLUGIN_URL,false);
}}if ( ((0) === strpos($url[0],'http')))
 {if ( deAspis(is_ssl()))
 $url = Aspis_str_replace(array('http://',false),concat2($scheme,"://"),$url);
}if ( ((!((empty($plugin) || Aspis_empty( $plugin)))) && is_string(deAspisRC($plugin))))
 {$folder = Aspis_dirname(plugin_basename($plugin));
if ( (('.') != $folder[0]))
 $url = concat($url,concat1('/',Aspis_ltrim($folder,array('/',false))));
}if ( (((!((empty($path) || Aspis_empty( $path)))) && is_string(deAspisRC($path))) && (strpos($path[0],'..') === false)))
 $url = concat($url,concat1('/',Aspis_ltrim($path,array('/',false))));
return apply_filters(array('plugins_url',false),$url,$path,$plugin);
 }
function rel_canonical (  ) {
if ( (denot_boolean(is_singular())))
 return ;
global $wp_the_query;
if ( (denot_boolean($id = $wp_the_query[0]->get_queried_object_id())))
 return ;
$link = get_permalink($id);
echo AspisCheckPrint(concat2(concat1("<link rel='canonical' href='",$link),"' />\n"));
 }
;
?>
<?php 