<?php require_once('AspisMain.php'); ?><?php
$tableposts = $wpdb[0]->posts;
$tableusers = $wpdb[0]->users;
$tablecategories = $wpdb[0]->categories;
$tablepost2cat = $wpdb[0]->post2cat;
$tablecomments = $wpdb[0]->comments;
$tablelinks = $wpdb[0]->links;
$tablelinkcategories = array('linkcategories_is_gone',false);
$tableoptions = $wpdb[0]->options;
$tablepostmeta = $wpdb[0]->postmeta;
function get_postdata ( $postid ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_post()',false));
$post = &get_post($postid);
$postdata = array(array(deregisterTaint(array('ID',false)) => addTaint($post[0]->ID),deregisterTaint(array('Author_ID',false)) => addTaint($post[0]->post_author),deregisterTaint(array('Date',false)) => addTaint($post[0]->post_date),deregisterTaint(array('Content',false)) => addTaint($post[0]->post_content),deregisterTaint(array('Excerpt',false)) => addTaint($post[0]->post_excerpt),deregisterTaint(array('Title',false)) => addTaint($post[0]->post_title),deregisterTaint(array('Category',false)) => addTaint($post[0]->post_category),deregisterTaint(array('post_status',false)) => addTaint($post[0]->post_status),deregisterTaint(array('comment_status',false)) => addTaint($post[0]->comment_status),deregisterTaint(array('ping_status',false)) => addTaint($post[0]->ping_status),deregisterTaint(array('post_password',false)) => addTaint($post[0]->post_password),deregisterTaint(array('to_ping',false)) => addTaint($post[0]->to_ping),deregisterTaint(array('pinged',false)) => addTaint($post[0]->pinged),deregisterTaint(array('post_type',false)) => addTaint($post[0]->post_type),deregisterTaint(array('post_name',false)) => addTaint($post[0]->post_name)),false);
return $postdata;
 }
function start_wp (  ) {
global $wp_query,$post;
_deprecated_function(array(__FUNCTION__,false),array('1.5',false),__(array('new WordPress Loop',false)));
$wp_query[0]->next_post();
setup_postdata($post);
 }
function the_category_ID ( $echo = array(true,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_the_category()',false));
$categories = get_the_category();
$cat = $categories[0][(0)][0]->term_id;
if ( $echo[0])
 echo AspisCheckPrint($cat);
return $cat;
 }
function the_category_head ( $before = array('',false),$after = array('',false) ) {
global $currentcat,$previouscat;
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_the_category_by_ID()',false));
$categories = get_the_category();
$currentcat = $categories[0][(0)][0]->category_id;
if ( ($currentcat[0] != $previouscat[0]))
 {echo AspisCheckPrint($before);
echo AspisCheckPrint(get_the_category_by_ID($currentcat));
echo AspisCheckPrint($after);
$previouscat = $currentcat;
} }
function previous_post ( $format = array('%',false),$previous = array('previous post: ',false),$title = array('yes',false),$in_same_cat = array('no',false),$limitprev = array(1,false),$excluded_categories = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('previous_post_link()',false));
if ( (((empty($in_same_cat) || Aspis_empty( $in_same_cat))) || (('no') == $in_same_cat[0])))
 $in_same_cat = array(false,false);
else 
{$in_same_cat = array(true,false);
}$post = get_previous_post($in_same_cat,$excluded_categories);
if ( (denot_boolean($post)))
 return ;
$string = concat(concat2(concat1('<a href="',get_permalink($post[0]->ID)),'">'),$previous);
if ( (('yes') == $title[0]))
 $string = concat($string,apply_filters(array('the_title',false),$post[0]->post_title,$post));
$string = concat2($string,'</a>');
$format = Aspis_str_replace(array('%',false),$string,$format);
echo AspisCheckPrint($format);
 }
function next_post ( $format = array('%',false),$next = array('next post: ',false),$title = array('yes',false),$in_same_cat = array('no',false),$limitnext = array(1,false),$excluded_categories = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('next_post_link()',false));
if ( (((empty($in_same_cat) || Aspis_empty( $in_same_cat))) || (('no') == $in_same_cat[0])))
 $in_same_cat = array(false,false);
else 
{$in_same_cat = array(true,false);
}$post = get_next_post($in_same_cat,$excluded_categories);
if ( (denot_boolean($post)))
 return ;
$string = concat(concat2(concat1('<a href="',get_permalink($post[0]->ID)),'">'),$next);
if ( (('yes') == $title[0]))
 $string = concat($string,apply_filters(array('the_title',false),$post[0]->post_title,$nextpost));
$string = concat2($string,'</a>');
$format = Aspis_str_replace(array('%',false),$string,$format);
echo AspisCheckPrint($format);
 }
function user_can_create_post ( $user_id,$blog_id = array(1,false),$category_id = array('None',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('current_user_can()',false));
$author_data = get_userdata($user_id);
return (array($author_data[0]->user_level[0] > (1),false));
 }
function user_can_create_draft ( $user_id,$blog_id = array(1,false),$category_id = array('None',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('current_user_can()',false));
$author_data = get_userdata($user_id);
return (array($author_data[0]->user_level[0] >= (1),false));
 }
function user_can_edit_post ( $user_id,$post_id,$blog_id = array(1,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0',false),array('current_user_can()',false));
$author_data = get_userdata($user_id);
$post = get_post($post_id);
$post_author_data = get_userdata($post[0]->post_author);
if ( (((($user_id[0] == $post_author_data[0]->ID[0]) && (!(($post[0]->post_status[0] == ('publish')) && ($author_data[0]->user_level[0] < (2))))) || ($author_data[0]->user_level[0] > $post_author_data[0]->user_level[0])) || ($author_data[0]->user_level[0] >= (10))))
 {return array(true,false);
}else 
{{return array(false,false);
}} }
function user_can_delete_post ( $user_id,$post_id,$blog_id = array(1,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('current_user_can()',false));
return user_can_edit_post($user_id,$post_id,$blog_id);
 }
function user_can_set_post_date ( $user_id,$blog_id = array(1,false),$category_id = array('None',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('current_user_can()',false));
$author_data = get_userdata($user_id);
return (array(($author_data[0]->user_level[0] > (4)) && deAspis(user_can_create_post($user_id,$blog_id,$category_id)),false));
 }
function user_can_edit_post_date ( $user_id,$post_id,$blog_id = array(1,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('current_user_can()',false));
$author_data = get_userdata($user_id);
return (array(($author_data[0]->user_level[0] > (4)) && deAspis(user_can_edit_post($user_id,$post_id,$blog_id)),false));
 }
function user_can_edit_post_comments ( $user_id,$post_id,$blog_id = array(1,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('current_user_can()',false));
return user_can_edit_post($user_id,$post_id,$blog_id);
 }
function user_can_delete_post_comments ( $user_id,$post_id,$blog_id = array(1,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('current_user_can()',false));
return user_can_edit_post_comments($user_id,$post_id,$blog_id);
 }
function user_can_edit_user ( $user_id,$other_user ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('current_user_can()',false));
$user = get_userdata($user_id);
$other = get_userdata($other_user);
if ( ((($user[0]->user_level[0] > $other[0]->user_level[0]) || ($user[0]->user_level[0] > (8))) || ($user[0]->ID[0] == $other[0]->ID[0])))
 return array(true,false);
else 
{return array(false,false);
} }
function get_linksbyname ( $cat_name = array("noname",false),$before = array('',false),$after = array('<br />',false),$between = array(" ",false),$show_images = array(true,false),$orderby = array('id',false),$show_description = array(true,false),$show_rating = array(false,false),$limit = array(-1,false),$show_updated = array(0,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_links()',false));
$cat_id = negate(array(1,false));
$cat = get_term_by(array('name',false),$cat_name,array('link_category',false));
if ( $cat[0])
 $cat_id = $cat[0]->term_id;
get_links($cat_id,$before,$after,$between,$show_images,$orderby,$show_description,$show_rating,$limit,$show_updated);
 }
function wp_get_linksbyname ( $category,$args = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_get_links()',false));
$cat = get_term_by(array('name',false),$category,array('link_category',false));
if ( (denot_boolean($cat)))
 return array(false,false);
$cat_id = $cat[0]->term_id;
$args = add_query_arg(array('category',false),$cat_id,$args);
wp_get_links($args);
 }
function get_linkobjectsbyname ( $cat_name = array("noname",false),$orderby = array('name',false),$limit = array(-1,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_linkobjects()',false));
$cat_id = negate(array(1,false));
$cat = get_term_by(array('name',false),$cat_name,array('link_category',false));
if ( $cat[0])
 $cat_id = $cat[0]->term_id;
return get_linkobjects($cat_id,$orderby,$limit);
 }
function get_linkobjects ( $category = array(0,false),$orderby = array('name',false),$limit = array(0,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_bookmarks()',false));
$links = get_bookmarks(concat(concat2(concat(concat2(concat1("category=",$category),"&orderby="),$orderby),"&limit="),$limit));
$links_array = array(array(),false);
foreach ( $links[0] as $link  )
arrayAssignAdd($links_array[0][],addTaint($link));
return $links_array;
 }
function get_linksbyname_withrating ( $cat_name = array("noname",false),$before = array('',false),$after = array('<br />',false),$between = array(" ",false),$show_images = array(true,false),$orderby = array('id',false),$show_description = array(true,false),$limit = array(-1,false),$show_updated = array(0,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_bookmarks()',false));
get_linksbyname($cat_name,$before,$after,$between,$show_images,$orderby,$show_description,array(true,false),$limit,$show_updated);
 }
function get_links_withrating ( $category = array(-1,false),$before = array('',false),$after = array('<br />',false),$between = array(" ",false),$show_images = array(true,false),$orderby = array('id',false),$show_description = array(true,false),$limit = array(-1,false),$show_updated = array(0,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_bookmarks()',false));
get_links($category,$before,$after,$between,$show_images,$orderby,$show_description,array(true,false),$limit,$show_updated);
 }
function get_autotoggle ( $id = array(0,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false));
return array(0,false);
 }
function list_cats ( $optionall = array(1,false),$all = array('All',false),$sort_column = array('ID',false),$sort_order = array('asc',false),$file = array('',false),$list = array(true,false),$optiondates = array(0,false),$optioncount = array(0,false),$hide_empty = array(1,false),$use_desc_for_title = array(1,false),$children = array(false,false),$child_of = array(0,false),$categories = array(0,false),$recurse = array(0,false),$feed = array('',false),$feed_image = array('',false),$exclude = array('',false),$hierarchical = array(false,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_list_categories()',false));
$query = array(compact('optionall','all','sort_column','sort_order','file','list','optiondates','optioncount','hide_empty','use_desc_for_title','children','child_of','categories','recurse','feed','feed_image','exclude','hierarchical'),false);
return wp_list_cats($query);
 }
function wp_list_cats ( $args = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_list_categories()',false));
$r = wp_parse_args($args);
if ( (((isset($r[0][('optionall')]) && Aspis_isset( $r [0][('optionall')]))) && ((isset($r[0][('all')]) && Aspis_isset( $r [0][('all')])))))
 arrayAssign($r[0],deAspis(registerTaint(array('show_option_all',false))),addTaint($r[0]['all']));
if ( ((isset($r[0][('sort_column')]) && Aspis_isset( $r [0][('sort_column')]))))
 arrayAssign($r[0],deAspis(registerTaint(array('orderby',false))),addTaint($r[0]['sort_column']));
if ( ((isset($r[0][('sort_order')]) && Aspis_isset( $r [0][('sort_order')]))))
 arrayAssign($r[0],deAspis(registerTaint(array('order',false))),addTaint($r[0]['sort_order']));
if ( ((isset($r[0][('optiondates')]) && Aspis_isset( $r [0][('optiondates')]))))
 arrayAssign($r[0],deAspis(registerTaint(array('show_last_update',false))),addTaint($r[0]['optiondates']));
if ( ((isset($r[0][('optioncount')]) && Aspis_isset( $r [0][('optioncount')]))))
 arrayAssign($r[0],deAspis(registerTaint(array('show_count',false))),addTaint($r[0]['optioncount']));
if ( ((isset($r[0][('list')]) && Aspis_isset( $r [0][('list')]))))
 arrayAssign($r[0],deAspis(registerTaint(array('style',false))),addTaint(deAspis($r[0]['list']) ? array('list',false) : array('break',false)));
arrayAssign($r[0],deAspis(registerTaint(array('title_li',false))),addTaint(array('',false)));
return wp_list_categories($r);
 }
function dropdown_cats ( $optionall = array(1,false),$all = array('All',false),$orderby = array('ID',false),$order = array('asc',false),$show_last_update = array(0,false),$show_count = array(0,false),$hide_empty = array(1,false),$optionnone = array(false,false),$selected = array(0,false),$exclude = array(0,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_dropdown_categories()',false));
$show_option_all = array('',false);
if ( $optionall[0])
 $show_option_all = $all;
$show_option_none = array('',false);
if ( $optionnone[0])
 $show_option_none = __(array('None',false));
$vars = array(compact('show_option_all','show_option_none','orderby','order','show_last_update','show_count','hide_empty','selected','exclude'),false);
$query = add_query_arg($vars,array('',false));
return wp_dropdown_categories($query);
 }
function tinymce_include (  ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_tiny_mce()',false));
wp_tiny_mce();
 }
function list_authors ( $optioncount = array(false,false),$exclude_admin = array(true,false),$show_fullname = array(false,false),$hide_empty = array(true,false),$feed = array('',false),$feed_image = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_list_authors()',false));
$args = array(compact('optioncount','exclude_admin','show_fullname','hide_empty','feed','feed_image'),false);
return wp_list_authors($args);
 }
function wp_get_post_cats ( $blogid = array('1',false),$post_ID = array(0,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_get_post_categories()',false));
return wp_get_post_categories($post_ID);
 }
function wp_set_post_cats ( $blogid = array('1',false),$post_ID = array(0,false),$post_categories = array(array(),false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_set_post_categories()',false));
return wp_set_post_categories($post_ID,$post_categories);
 }
function get_archives ( $type = array('',false),$limit = array('',false),$format = array('html',false),$before = array('',false),$after = array('',false),$show_post_count = array(false,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_get_archives()',false));
$args = array(compact('type','limit','format','before','after','show_post_count'),false);
return wp_get_archives($args);
 }
function get_author_link ( $echo = array(false,false),$author_id,$author_nicename = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_author_posts_url()',false));
$link = get_author_posts_url($author_id,$author_nicename);
if ( $echo[0])
 echo AspisCheckPrint($link);
return $link;
 }
function link_pages ( $before = array('<br />',false),$after = array('<br />',false),$next_or_number = array('number',false),$nextpagelink = array('next page',false),$previouspagelink = array('previous page',false),$pagelink = array('%',false),$more_file = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_link_pages()',false));
$args = array(compact('before','after','next_or_number','nextpagelink','previouspagelink','pagelink','more_file'),false);
return wp_link_pages($args);
 }
function get_settings ( $option ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_option()',false));
return get_option($option);
 }
function permalink_link (  ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('the_permalink()',false));
the_permalink();
 }
function permalink_single_rss ( $deprecated = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('the_permalink_rss()',false));
the_permalink_rss();
 }
function wp_get_links ( $args = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_bookmarks()',false));
if ( (strpos($args[0],'=') === false))
 {$cat_id = $args;
$args = add_query_arg(array('category',false),$cat_id,$args);
}$defaults = array(array(deregisterTaint(array('category',false)) => addTaint(negate(array(1,false))),'before' => array('',false,false),'after' => array('<br />',false,false),'between' => array(' ',false,false),'show_images' => array(true,false,false),'orderby' => array('name',false,false),'show_description' => array(true,false,false),'show_rating' => array(false,false,false),deregisterTaint(array('limit',false)) => addTaint(negate(array(1,false))),'show_updated' => array(true,false,false),'echo' => array(true,false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
return get_links($category,$before,$after,$between,$show_images,$orderby,$show_description,$show_rating,$limit,$show_updated,$echo);
 }
function get_links ( $category = array(-1,false),$before = array('',false),$after = array('<br />',false),$between = array(' ',false),$show_images = array(true,false),$orderby = array('name',false),$show_description = array(true,false),$show_rating = array(false,false),$limit = array(-1,false),$show_updated = array(1,false),$echo = array(true,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_bookmarks()',false));
$order = array('ASC',false);
if ( (deAspis(Aspis_substr($orderby,array(0,false),array(1,false))) == ('_')))
 {$order = array('DESC',false);
$orderby = Aspis_substr($orderby,array(1,false));
}if ( ($category[0] == deAspis(negate(array(1,false)))))
 $category = array('',false);
$results = get_bookmarks(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("category=",$category),"&orderby="),$orderby),"&order="),$order),"&show_updated="),$show_updated),"&limit="),$limit));
if ( (denot_boolean($results)))
 return ;
$output = array('',false);
foreach ( deAspis(array_cast($results)) as $row  )
{if ( (!((isset($row[0]->recently_updated) && Aspis_isset( $row[0] ->recently_updated )))))
 $row[0]->recently_updated = array(false,false);
$output = concat($output,$before);
if ( ($show_updated[0] && $row[0]->recently_updated[0]))
 $output = concat($output,get_option(array('links_recently_updated_prepend',false)));
$the_link = array('#',false);
if ( (!((empty($row[0]->link_url) || Aspis_empty( $row[0] ->link_url )))))
 $the_link = esc_url($row[0]->link_url);
$rel = $row[0]->link_rel;
if ( (('') != $rel[0]))
 $rel = concat2(concat1(' rel="',$rel),'"');
$desc = esc_attr(sanitize_bookmark_field(array('link_description',false),$row[0]->link_description,$row[0]->link_id,array('display',false)));
$name = esc_attr(sanitize_bookmark_field(array('link_name',false),$row[0]->link_name,$row[0]->link_id,array('display',false)));
$title = $desc;
if ( $show_updated[0])
 if ( (deAspis(Aspis_substr($row[0]->link_updated_f,array(0,false),array(2,false))) != ('00')))
 $title = concat($title,concat2(concat(concat2(concat1(' (',__(array('Last updated',false))),' '),attAspis(date(deAspis(get_option(array('links_updated_date_format',false))),($row[0]->link_updated_f[0] + (deAspis(get_option(array('gmt_offset',false))) * (3600)))))),')'));
if ( (('') != $title[0]))
 $title = concat2(concat1(' title="',$title),'"');
$alt = concat2(concat1(' alt="',$name),'"');
$target = $row[0]->link_target;
if ( (('') != $target[0]))
 $target = concat2(concat1(' target="',$target),'"');
$output = concat($output,concat2(concat(concat(concat(concat2(concat1('<a href="',$the_link),'"'),$rel),$title),$target),'>'));
if ( (($row[0]->link_image[0] != null) && $show_images[0]))
 {if ( (strpos($row[0]->link_image[0],'http') !== false))
 $output = concat($output,concat2(concat(concat2(concat(concat2(concat1("<img src=\"",$row[0]->link_image),"\" "),$alt)," "),$title)," />"));
else 
{$output = concat($output,concat(concat1("<img src=\"",get_option(array('siteurl',false))),concat2(concat(concat2(concat(concat2($row[0]->link_image,"\" "),$alt)," "),$title)," />")));
}}else 
{{$output = concat($output,$name);
}}$output = concat2($output,'</a>');
if ( ($show_updated[0] && $row[0]->recently_updated[0]))
 $output = concat($output,get_option(array('links_recently_updated_append',false)));
if ( ($show_description[0] && (('') != $desc[0])))
 $output = concat($output,concat($between,$desc));
if ( $show_rating[0])
 {$output = concat($output,concat($between,get_linkrating($row)));
}$output = concat($output,concat2($after,"\n"));
}if ( (denot_boolean($echo)))
 return $output;
echo AspisCheckPrint($output);
 }
function get_links_list ( $order = array('name',false),$deprecated = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('wp_list_bookmarks()',false));
$order = Aspis_strtolower($order);
$direction = array('ASC',false);
if ( (('_') == deAspis(Aspis_substr($order,array(0,false),array(1,false)))))
 {$direction = array('DESC',false);
$order = Aspis_substr($order,array(1,false));
}if ( (!((isset($direction) && Aspis_isset( $direction)))))
 $direction = array('',false);
$cats = get_categories(concat2(concat(concat2(concat1("type=link&orderby=",$order),"&order="),$direction),"&hierarchical=0"));
if ( $cats[0])
 {foreach ( deAspis(array_cast($cats)) as $cat  )
{echo AspisCheckPrint(concat2(concat(concat2(concat1('  <li id="linkcat-',$cat[0]->term_id),'" class="linkcat"><h2>'),apply_filters(array('link_category',false),$cat[0]->name)),"</h2>\n\t<ul>\n"));
get_links($cat[0]->term_id,array('<li>',false),array("</li>",false),array("\n",false),array(true,false),array('name',false),array(false,false));
echo AspisCheckPrint(array("\n\t</ul>\n</li>\n",false));
}} }
function links_popup_script ( $text = array('Links',false),$width = array(400,false),$height = array(400,false),$file = array('links.all.php',false),$count = array(true,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false));
if ( $count[0])
 $counts = $wpdb[0]->get_var(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->links));
$javascript = concat2(concat(concat2(concat(concat2(concat1("<a href=\"#\" onclick=\"javascript:window.open('",$file),"?popup=1', '_blank', 'width="),$width),",height="),$height),",scrollbars=yes,status=no'); return false\">");
$javascript = concat($javascript,$text);
if ( $count[0])
 $javascript = concat($javascript,concat2(concat1(" (",$counts),")"));
$javascript = concat2($javascript,"</a>\n\n");
echo AspisCheckPrint($javascript);
 }
function get_linkrating ( $link ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('sanitize_bookmark_field()',false));
return sanitize_bookmark_field(array('link_rating',false),$link[0]->link_rating,$link[0]->link_id,array('display',false));
 }
function get_linkcatname ( $id = array(0,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_category()',false));
$id = int_cast($id);
if ( ((empty($id) || Aspis_empty( $id))))
 return array('',false);
$cats = wp_get_link_cats($id);
if ( (((empty($cats) || Aspis_empty( $cats))) || (!(is_array($cats[0])))))
 return array('',false);
$cat_id = int_cast(attachAspis($cats,(0)));
$cat = get_category($cat_id);
return $cat[0]->name;
 }
function comments_rss_link ( $link_text = array('Comments RSS',false),$deprecated = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('post_comments_feed_link()',false));
post_comments_feed_link($link_text);
 }
function get_category_rss_link ( $echo = array(false,false),$cat_ID = array(1,false),$deprecated = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_category_feed_link()',false));
$link = get_category_feed_link($cat_ID,array('rss2',false));
if ( $echo[0])
 echo AspisCheckPrint($link);
return $link;
 }
function get_author_rss_link ( $echo = array(false,false),$author_id = array(1,false),$deprecated = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('0.0',false),array('get_author_feed_link()',false));
$link = get_author_feed_link($author_id);
if ( $echo[0])
 echo AspisCheckPrint($link);
return $link;
 }
function comments_rss ( $deprecated = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('2.2',false),array('get_post_comments_feed_link()',false));
return get_post_comments_feed_link();
 }
function create_user ( $username,$password,$email ) {
_deprecated_function(array(__FUNCTION__,false),array('2.0',false),array('wp_create_user()',false));
return wp_create_user($username,$password,$email);
 }
function documentation_link ( $deprecated = array('',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('2.5',false),array('',false));
return ;
 }
function gzip_compression (  ) {
return array(false,false);
 }
function get_commentdata ( $comment_ID,$no_cache = array(0,false),$include_unapproved = array(false,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('2.7',false),array('get_comment()',false));
return get_comment($comment_ID,array(ARRAY_A,false));
 }
function get_catname ( $cat_ID ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_cat_name()',false));
return get_cat_name($cat_ID);
 }
function get_category_children ( $id,$before = array('/',false),$after = array('',false),$visited = array(array(),false) ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_term_children()',false));
if ( ((0) == $id[0]))
 return array('',false);
$chain = array('',false);
$cat_ids = get_all_category_ids();
foreach ( deAspis(array_cast($cat_ids)) as $cat_id  )
{if ( ($cat_id[0] == $id[0]))
 continue ;
$category = get_category($cat_id);
if ( deAspis(is_wp_error($category)))
 return $category;
if ( (($category[0]->parent[0] == $id[0]) && (denot_boolean(Aspis_in_array($category[0]->term_id,$visited)))))
 {arrayAssignAdd($visited[0][],addTaint($category[0]->term_id));
$chain = concat($chain,concat(concat($before,$category[0]->term_id),$after));
$chain = concat($chain,get_category_children($category[0]->term_id,$before,$after));
}}return $chain;
 }
function get_the_author_description (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'description\')',false));
return get_the_author_meta(array('description',false));
 }
function the_author_description (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'description\')',false));
the_author_meta(array('description',false));
 }
function get_the_author_login (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'login\')',false));
return get_the_author_meta(array('login',false));
 }
function the_author_login (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'login\')',false));
the_author_meta(array('login',false));
 }
function get_the_author_firstname (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'first_name\')',false));
return get_the_author_meta(array('first_name',false));
 }
function the_author_firstname (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'first_name\')',false));
the_author_meta(array('first_name',false));
 }
function get_the_author_lastname (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'last_name\')',false));
return get_the_author_meta(array('last_name',false));
 }
function the_author_lastname (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'last_name\')',false));
the_author_meta(array('last_name',false));
 }
function get_the_author_nickname (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'nickname\')',false));
return get_the_author_meta(array('nickname',false));
 }
function the_author_nickname (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'nickname\')',false));
the_author_meta(array('nickname',false));
 }
function get_the_author_email (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'email\')',false));
return get_the_author_meta(array('email',false));
 }
function the_author_email (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'email\')',false));
the_author_meta(array('email',false));
 }
function get_the_author_icq (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'icq\')',false));
return get_the_author_meta(array('icq',false));
 }
function the_author_icq (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'icq\')',false));
the_author_meta(array('icq',false));
 }
function get_the_author_yim (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'yim\')',false));
return get_the_author_meta(array('yim',false));
 }
function the_author_yim (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'yim\')',false));
the_author_meta(array('yim',false));
 }
function get_the_author_msn (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'msn\')',false));
return get_the_author_meta(array('msn',false));
 }
function the_author_msn (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'msn\')',false));
the_author_meta(array('msn',false));
 }
function get_the_author_aim (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'aim\')',false));
return get_the_author_meta(array('aim',false));
 }
function the_author_aim (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'aim\')',false));
the_author_meta(array('aim',false));
 }
function get_author_name ( $auth_id = array(false,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'display_name\')',false));
return get_the_author_meta(array('display_name',false),$auth_id);
 }
function get_the_author_url (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'url\')',false));
return get_the_author_meta(array('url',false));
 }
function the_author_url (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'url\')',false));
the_author_meta(array('url',false));
 }
function get_the_author_ID (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('get_the_author_meta(\'ID\')',false));
return get_the_author_meta(array('ID',false));
 }
function the_author_ID (  ) {
_deprecated_function(array(__FUNCTION__,false),array('2.8',false),array('the_author_meta(\'ID\')',false));
the_author_meta(array('ID',false));
 }
function the_content_rss ( $more_link_text = array('(more...)',false),$stripteaser = array(0,false),$more_file = array('',false),$cut = array(0,false),$encode_html = array(0,false) ) {
_deprecated_function(array(__FUNCTION__,false),array('2.9',false),array('the_content_feed',false));
$content = get_the_content($more_link_text,$stripteaser,$more_file);
$content = apply_filters(array('the_content_rss',false),$content);
if ( ($cut[0] && (denot_boolean($encode_html))))
 $encode_html = array(2,false);
if ( ((1) == $encode_html[0]))
 {$content = esc_html($content);
$cut = array(0,false);
}elseif ( ((0) == $encode_html[0]))
 {$content = make_url_footnote($content);
}elseif ( ((2) == $encode_html[0]))
 {$content = Aspis_strip_tags($content);
}if ( $cut[0])
 {$blah = Aspis_explode(array(' ',false),$content);
if ( (count($blah[0]) > $cut[0]))
 {$k = $cut;
$use_dotdotdot = array(1,false);
}else 
{{$k = attAspis(count($blah[0]));
$use_dotdotdot = array(0,false);
}}for ( $i = array(0,false) ; ($i[0] < $k[0]) ; postincr($i) )
$excerpt = concat($excerpt,concat2(attachAspis($blah,$i[0]),' '));
$excerpt = concat($excerpt,deAspis(($use_dotdotdot)) ? array('...',false) : array('',false));
$content = $excerpt;
}$content = Aspis_str_replace(array(']]>',false),array(']]&gt;',false),$content);
echo AspisCheckPrint($content);
 }
function make_url_footnote ( $content ) {
_deprecated_function(array(__FUNCTION__,false),array('2.9',false),array('',false));
Aspis_preg_match_all(array('/<a(.+?)href=\"(.+?)\"(.*?)>(.+?)<\/a>/',false),$content,$matches);
$links_summary = array("\n",false);
for ( $i = array(0,false) ; ($i[0] < count(deAspis(attachAspis($matches,(0))))) ; postincr($i) )
{$link_match = attachAspis($matches[0][(0)],$i[0]);
$link_number = concat2(concat1('[',(array($i[0] + (1),false))),']');
$link_url = attachAspis($matches[0][(2)],$i[0]);
$link_text = attachAspis($matches[0][(4)],$i[0]);
$content = Aspis_str_replace($link_match,concat(concat2($link_text,' '),$link_number),$content);
$link_url = ((deAspis(Aspis_strtolower(Aspis_substr($link_url,array(0,false),array(7,false)))) != ('http://')) && (deAspis(Aspis_strtolower(Aspis_substr($link_url,array(0,false),array(8,false)))) != ('https://'))) ? concat(get_option(array('home',false)),$link_url) : $link_url;
$links_summary = concat($links_summary,concat(concat2(concat1("\n",$link_number),' '),$link_url));
}$content = Aspis_strip_tags($content);
$content = concat($content,$links_summary);
return $content;
 }
function _c ( $text,$domain = array('default',false) ) {
_deprecated_function(array(__FUNCTION__,false),array('2.9',false),array('_x',false));
return translate_with_context($text,$domain);
 }
;
