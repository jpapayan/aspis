<?php require_once('AspisMain.php'); ?><?php
$tableposts = $wpdb->posts;
$tableusers = $wpdb->users;
$tablecategories = $wpdb->categories;
$tablepost2cat = $wpdb->post2cat;
$tablecomments = $wpdb->comments;
$tablelinks = $wpdb->links;
$tablelinkcategories = 'linkcategories_is_gone';
$tableoptions = $wpdb->options;
$tablepostmeta = $wpdb->postmeta;
function get_postdata ( $postid ) {
_deprecated_function(__FUNCTION__,'0.0','get_post()');
$post = &get_post($postid);
$postdata = array('ID' => $post->ID,'Author_ID' => $post->post_author,'Date' => $post->post_date,'Content' => $post->post_content,'Excerpt' => $post->post_excerpt,'Title' => $post->post_title,'Category' => $post->post_category,'post_status' => $post->post_status,'comment_status' => $post->comment_status,'ping_status' => $post->ping_status,'post_password' => $post->post_password,'to_ping' => $post->to_ping,'pinged' => $post->pinged,'post_type' => $post->post_type,'post_name' => $post->post_name);
{$AspisRetTemp = $postdata;
return $AspisRetTemp;
} }
function start_wp (  ) {
{global $wp_query,$post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($post,"\$post",$AspisChangesCache);
}_deprecated_function(__FUNCTION__,'1.5',__('new WordPress Loop'));
$wp_query->next_post();
setup_postdata($post);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$post",$AspisChangesCache);
 }
function the_category_ID ( $echo = true ) {
_deprecated_function(__FUNCTION__,'0.0','get_the_category()');
$categories = get_the_category();
$cat = $categories[0]->term_id;
if ( $echo)
 echo $cat;
{$AspisRetTemp = $cat;
return $AspisRetTemp;
} }
function the_category_head ( $before = '',$after = '' ) {
{global $currentcat,$previouscat;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $currentcat,"\$currentcat",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($previouscat,"\$previouscat",$AspisChangesCache);
}_deprecated_function(__FUNCTION__,'0.0','get_the_category_by_ID()');
$categories = get_the_category();
$currentcat = $categories[0]->category_id;
if ( $currentcat != $previouscat)
 {echo $before;
echo get_the_category_by_ID($currentcat);
echo $after;
$previouscat = $currentcat;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$currentcat",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$previouscat",$AspisChangesCache);
 }
function previous_post ( $format = '%',$previous = 'previous post: ',$title = 'yes',$in_same_cat = 'no',$limitprev = 1,$excluded_categories = '' ) {
_deprecated_function(__FUNCTION__,'0.0','previous_post_link()');
if ( empty($in_same_cat) || 'no' == $in_same_cat)
 $in_same_cat = false;
else 
{$in_same_cat = true;
}$post = get_previous_post($in_same_cat,$excluded_categories);
if ( !$post)
 {return ;
}$string = '<a href="' . get_permalink($post->ID) . '">' . $previous;
if ( 'yes' == $title)
 $string .= apply_filters('the_title',$post->post_title,$post);
$string .= '</a>';
$format = str_replace('%',$string,$format);
echo $format;
 }
function next_post ( $format = '%',$next = 'next post: ',$title = 'yes',$in_same_cat = 'no',$limitnext = 1,$excluded_categories = '' ) {
_deprecated_function(__FUNCTION__,'0.0','next_post_link()');
if ( empty($in_same_cat) || 'no' == $in_same_cat)
 $in_same_cat = false;
else 
{$in_same_cat = true;
}$post = get_next_post($in_same_cat,$excluded_categories);
if ( !$post)
 {return ;
}$string = '<a href="' . get_permalink($post->ID) . '">' . $next;
if ( 'yes' == $title)
 $string .= apply_filters('the_title',$post->post_title,$nextpost);
$string .= '</a>';
$format = str_replace('%',$string,$format);
echo $format;
 }
function user_can_create_post ( $user_id,$blog_id = 1,$category_id = 'None' ) {
_deprecated_function(__FUNCTION__,'0.0','current_user_can()');
$author_data = get_userdata($user_id);
{$AspisRetTemp = ($author_data->user_level > 1);
return $AspisRetTemp;
} }
function user_can_create_draft ( $user_id,$blog_id = 1,$category_id = 'None' ) {
_deprecated_function(__FUNCTION__,'0.0','current_user_can()');
$author_data = get_userdata($user_id);
{$AspisRetTemp = ($author_data->user_level >= 1);
return $AspisRetTemp;
} }
function user_can_edit_post ( $user_id,$post_id,$blog_id = 1 ) {
_deprecated_function(__FUNCTION__,'0','current_user_can()');
$author_data = get_userdata($user_id);
$post = get_post($post_id);
$post_author_data = get_userdata($post->post_author);
if ( (($user_id == $post_author_data->ID) && !($post->post_status == 'publish' && $author_data->user_level < 2)) || ($author_data->user_level > $post_author_data->user_level) || ($author_data->user_level >= 10))
 {{$AspisRetTemp = true;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = false;
return $AspisRetTemp;
}}} }
function user_can_delete_post ( $user_id,$post_id,$blog_id = 1 ) {
_deprecated_function(__FUNCTION__,'0.0','current_user_can()');
{$AspisRetTemp = user_can_edit_post($user_id,$post_id,$blog_id);
return $AspisRetTemp;
} }
function user_can_set_post_date ( $user_id,$blog_id = 1,$category_id = 'None' ) {
_deprecated_function(__FUNCTION__,'0.0','current_user_can()');
$author_data = get_userdata($user_id);
{$AspisRetTemp = (($author_data->user_level > 4) && user_can_create_post($user_id,$blog_id,$category_id));
return $AspisRetTemp;
} }
function user_can_edit_post_date ( $user_id,$post_id,$blog_id = 1 ) {
_deprecated_function(__FUNCTION__,'0.0','current_user_can()');
$author_data = get_userdata($user_id);
{$AspisRetTemp = (($author_data->user_level > 4) && user_can_edit_post($user_id,$post_id,$blog_id));
return $AspisRetTemp;
} }
function user_can_edit_post_comments ( $user_id,$post_id,$blog_id = 1 ) {
_deprecated_function(__FUNCTION__,'0.0','current_user_can()');
{$AspisRetTemp = user_can_edit_post($user_id,$post_id,$blog_id);
return $AspisRetTemp;
} }
function user_can_delete_post_comments ( $user_id,$post_id,$blog_id = 1 ) {
_deprecated_function(__FUNCTION__,'0.0','current_user_can()');
{$AspisRetTemp = user_can_edit_post_comments($user_id,$post_id,$blog_id);
return $AspisRetTemp;
} }
function user_can_edit_user ( $user_id,$other_user ) {
_deprecated_function(__FUNCTION__,'0.0','current_user_can()');
$user = get_userdata($user_id);
$other = get_userdata($other_user);
if ( $user->user_level > $other->user_level || $user->user_level > 8 || $user->ID == $other->ID)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function get_linksbyname ( $cat_name = "noname",$before = '',$after = '<br />',$between = " ",$show_images = true,$orderby = 'id',$show_description = true,$show_rating = false,$limit = -1,$show_updated = 0 ) {
_deprecated_function(__FUNCTION__,'0.0','get_links()');
$cat_id = -1;
$cat = get_term_by('name',$cat_name,'link_category');
if ( $cat)
 $cat_id = $cat->term_id;
get_links($cat_id,$before,$after,$between,$show_images,$orderby,$show_description,$show_rating,$limit,$show_updated);
 }
function wp_get_linksbyname ( $category,$args = '' ) {
_deprecated_function(__FUNCTION__,'0.0','wp_get_links()');
$cat = get_term_by('name',$category,'link_category');
if ( !$cat)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$cat_id = $cat->term_id;
$args = add_query_arg('category',$cat_id,$args);
wp_get_links($args);
 }
function get_linkobjectsbyname ( $cat_name = "noname",$orderby = 'name',$limit = -1 ) {
_deprecated_function(__FUNCTION__,'0.0','get_linkobjects()');
$cat_id = -1;
$cat = get_term_by('name',$cat_name,'link_category');
if ( $cat)
 $cat_id = $cat->term_id;
{$AspisRetTemp = get_linkobjects($cat_id,$orderby,$limit);
return $AspisRetTemp;
} }
function get_linkobjects ( $category = 0,$orderby = 'name',$limit = 0 ) {
_deprecated_function(__FUNCTION__,'0.0','get_bookmarks()');
$links = get_bookmarks("category=$category&orderby=$orderby&limit=$limit");
$links_array = array();
foreach ( $links as $link  )
$links_array[] = $link;
{$AspisRetTemp = $links_array;
return $AspisRetTemp;
} }
function get_linksbyname_withrating ( $cat_name = "noname",$before = '',$after = '<br />',$between = " ",$show_images = true,$orderby = 'id',$show_description = true,$limit = -1,$show_updated = 0 ) {
_deprecated_function(__FUNCTION__,'0.0','get_bookmarks()');
get_linksbyname($cat_name,$before,$after,$between,$show_images,$orderby,$show_description,true,$limit,$show_updated);
 }
function get_links_withrating ( $category = -1,$before = '',$after = '<br />',$between = " ",$show_images = true,$orderby = 'id',$show_description = true,$limit = -1,$show_updated = 0 ) {
_deprecated_function(__FUNCTION__,'0.0','get_bookmarks()');
get_links($category,$before,$after,$between,$show_images,$orderby,$show_description,true,$limit,$show_updated);
 }
function get_autotoggle ( $id = 0 ) {
_deprecated_function(__FUNCTION__,'0.0');
{$AspisRetTemp = 0;
return $AspisRetTemp;
} }
function list_cats ( $optionall = 1,$all = 'All',$sort_column = 'ID',$sort_order = 'asc',$file = '',$list = true,$optiondates = 0,$optioncount = 0,$hide_empty = 1,$use_desc_for_title = 1,$children = false,$child_of = 0,$categories = 0,$recurse = 0,$feed = '',$feed_image = '',$exclude = '',$hierarchical = false ) {
_deprecated_function(__FUNCTION__,'0.0','wp_list_categories()');
$query = compact('optionall','all','sort_column','sort_order','file','list','optiondates','optioncount','hide_empty','use_desc_for_title','children','child_of','categories','recurse','feed','feed_image','exclude','hierarchical');
{$AspisRetTemp = wp_list_cats($query);
return $AspisRetTemp;
} }
function wp_list_cats ( $args = '' ) {
_deprecated_function(__FUNCTION__,'0.0','wp_list_categories()');
$r = wp_parse_args($args);
if ( isset($r['optionall']) && isset($r['all']))
 $r['show_option_all'] = $r['all'];
if ( isset($r['sort_column']))
 $r['orderby'] = $r['sort_column'];
if ( isset($r['sort_order']))
 $r['order'] = $r['sort_order'];
if ( isset($r['optiondates']))
 $r['show_last_update'] = $r['optiondates'];
if ( isset($r['optioncount']))
 $r['show_count'] = $r['optioncount'];
if ( isset($r['list']))
 $r['style'] = $r['list'] ? 'list' : 'break';
$r['title_li'] = '';
{$AspisRetTemp = wp_list_categories($r);
return $AspisRetTemp;
} }
function dropdown_cats ( $optionall = 1,$all = 'All',$orderby = 'ID',$order = 'asc',$show_last_update = 0,$show_count = 0,$hide_empty = 1,$optionnone = false,$selected = 0,$exclude = 0 ) {
_deprecated_function(__FUNCTION__,'0.0','wp_dropdown_categories()');
$show_option_all = '';
if ( $optionall)
 $show_option_all = $all;
$show_option_none = '';
if ( $optionnone)
 $show_option_none = __('None');
$vars = compact('show_option_all','show_option_none','orderby','order','show_last_update','show_count','hide_empty','selected','exclude');
$query = add_query_arg($vars,'');
{$AspisRetTemp = wp_dropdown_categories($query);
return $AspisRetTemp;
} }
function tinymce_include (  ) {
_deprecated_function(__FUNCTION__,'0.0','wp_tiny_mce()');
wp_tiny_mce();
 }
function list_authors ( $optioncount = false,$exclude_admin = true,$show_fullname = false,$hide_empty = true,$feed = '',$feed_image = '' ) {
_deprecated_function(__FUNCTION__,'0.0','wp_list_authors()');
$args = compact('optioncount','exclude_admin','show_fullname','hide_empty','feed','feed_image');
{$AspisRetTemp = wp_list_authors($args);
return $AspisRetTemp;
} }
function wp_get_post_cats ( $blogid = '1',$post_ID = 0 ) {
_deprecated_function(__FUNCTION__,'0.0','wp_get_post_categories()');
{$AspisRetTemp = wp_get_post_categories($post_ID);
return $AspisRetTemp;
} }
function wp_set_post_cats ( $blogid = '1',$post_ID = 0,$post_categories = array() ) {
_deprecated_function(__FUNCTION__,'0.0','wp_set_post_categories()');
{$AspisRetTemp = wp_set_post_categories($post_ID,$post_categories);
return $AspisRetTemp;
} }
function get_archives ( $type = '',$limit = '',$format = 'html',$before = '',$after = '',$show_post_count = false ) {
_deprecated_function(__FUNCTION__,'0.0','wp_get_archives()');
$args = compact('type','limit','format','before','after','show_post_count');
{$AspisRetTemp = wp_get_archives($args);
return $AspisRetTemp;
} }
function get_author_link ( $echo = false,$author_id,$author_nicename = '' ) {
_deprecated_function(__FUNCTION__,'0.0','get_author_posts_url()');
$link = get_author_posts_url($author_id,$author_nicename);
if ( $echo)
 echo $link;
{$AspisRetTemp = $link;
return $AspisRetTemp;
} }
function link_pages ( $before = '<br />',$after = '<br />',$next_or_number = 'number',$nextpagelink = 'next page',$previouspagelink = 'previous page',$pagelink = '%',$more_file = '' ) {
_deprecated_function(__FUNCTION__,'0.0','wp_link_pages()');
$args = compact('before','after','next_or_number','nextpagelink','previouspagelink','pagelink','more_file');
{$AspisRetTemp = wp_link_pages($args);
return $AspisRetTemp;
} }
function get_settings ( $option ) {
_deprecated_function(__FUNCTION__,'0.0','get_option()');
{$AspisRetTemp = get_option($option);
return $AspisRetTemp;
} }
function permalink_link (  ) {
_deprecated_function(__FUNCTION__,'0.0','the_permalink()');
the_permalink();
 }
function permalink_single_rss ( $deprecated = '' ) {
_deprecated_function(__FUNCTION__,'0.0','the_permalink_rss()');
the_permalink_rss();
 }
function wp_get_links ( $args = '' ) {
_deprecated_function(__FUNCTION__,'0.0','get_bookmarks()');
if ( strpos($args,'=') === false)
 {$cat_id = $args;
$args = add_query_arg('category',$cat_id,$args);
}$defaults = array('category' => -1,'before' => '','after' => '<br />','between' => ' ','show_images' => true,'orderby' => 'name','show_description' => true,'show_rating' => false,'limit' => -1,'show_updated' => true,'echo' => true);
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
{$AspisRetTemp = get_links($category,$before,$after,$between,$show_images,$orderby,$show_description,$show_rating,$limit,$show_updated,$echo);
return $AspisRetTemp;
} }
function get_links ( $category = -1,$before = '',$after = '<br />',$between = ' ',$show_images = true,$orderby = 'name',$show_description = true,$show_rating = false,$limit = -1,$show_updated = 1,$echo = true ) {
_deprecated_function(__FUNCTION__,'0.0','get_bookmarks()');
$order = 'ASC';
if ( substr($orderby,0,1) == '_')
 {$order = 'DESC';
$orderby = substr($orderby,1);
}if ( $category == -1)
 $category = '';
$results = get_bookmarks("category=$category&orderby=$orderby&order=$order&show_updated=$show_updated&limit=$limit");
if ( !$results)
 {return ;
}$output = '';
foreach ( (array)$results as $row  )
{if ( !isset($row->recently_updated))
 $row->recently_updated = false;
$output .= $before;
if ( $show_updated && $row->recently_updated)
 $output .= get_option('links_recently_updated_prepend');
$the_link = '#';
if ( !empty($row->link_url))
 $the_link = esc_url($row->link_url);
$rel = $row->link_rel;
if ( '' != $rel)
 $rel = ' rel="' . $rel . '"';
$desc = esc_attr(sanitize_bookmark_field('link_description',$row->link_description,$row->link_id,'display'));
$name = esc_attr(sanitize_bookmark_field('link_name',$row->link_name,$row->link_id,'display'));
$title = $desc;
if ( $show_updated)
 if ( substr($row->link_updated_f,0,2) != '00')
 $title .= ' (' . __('Last updated') . ' ' . date(get_option('links_updated_date_format'),$row->link_updated_f + (get_option('gmt_offset') * 3600)) . ')';
if ( '' != $title)
 $title = ' title="' . $title . '"';
$alt = ' alt="' . $name . '"';
$target = $row->link_target;
if ( '' != $target)
 $target = ' target="' . $target . '"';
$output .= '<a href="' . $the_link . '"' . $rel . $title . $target . '>';
if ( $row->link_image != null && $show_images)
 {if ( strpos($row->link_image,'http') !== false)
 $output .= "<img src=\"$row->link_image\" $alt $title />";
else 
{$output .= "<img src=\"" . get_option('siteurl') . "$row->link_image\" $alt $title />";
}}else 
{{$output .= $name;
}}$output .= '</a>';
if ( $show_updated && $row->recently_updated)
 $output .= get_option('links_recently_updated_append');
if ( $show_description && '' != $desc)
 $output .= $between . $desc;
if ( $show_rating)
 {$output .= $between . get_linkrating($row);
}$output .= "$after\n";
}if ( !$echo)
 {$AspisRetTemp = $output;
return $AspisRetTemp;
}echo $output;
 }
function get_links_list ( $order = 'name',$deprecated = '' ) {
_deprecated_function(__FUNCTION__,'0.0','wp_list_bookmarks()');
$order = strtolower($order);
$direction = 'ASC';
if ( '_' == substr($order,0,1))
 {$direction = 'DESC';
$order = substr($order,1);
}if ( !isset($direction))
 $direction = '';
$cats = get_categories("type=link&orderby=$order&order=$direction&hierarchical=0");
if ( $cats)
 {foreach ( (array)$cats as $cat  )
{echo '  <li id="linkcat-' . $cat->term_id . '" class="linkcat"><h2>' . apply_filters('link_category',$cat->name) . "</h2>\n\t<ul>\n";
get_links($cat->term_id,'<li>',"</li>","\n",true,'name',false);
echo "\n\t</ul>\n</li>\n";
}} }
function links_popup_script ( $text = 'Links',$width = 400,$height = 400,$file = 'links.all.php',$count = true ) {
_deprecated_function(__FUNCTION__,'0.0');
if ( $count)
 $counts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links");
$javascript = "<a href=\"#\" onclick=\"javascript:window.open('$file?popup=1', '_blank', 'width=$width,height=$height,scrollbars=yes,status=no'); return false\">";
$javascript .= $text;
if ( $count)
 $javascript .= " ($counts)";
$javascript .= "</a>\n\n";
echo $javascript;
 }
function get_linkrating ( $link ) {
_deprecated_function(__FUNCTION__,'0.0','sanitize_bookmark_field()');
{$AspisRetTemp = sanitize_bookmark_field('link_rating',$link->link_rating,$link->link_id,'display');
return $AspisRetTemp;
} }
function get_linkcatname ( $id = 0 ) {
_deprecated_function(__FUNCTION__,'0.0','get_category()');
$id = (int)$id;
if ( empty($id))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$cats = wp_get_link_cats($id);
if ( empty($cats) || !is_array($cats))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$cat_id = (int)$cats[0];
$cat = get_category($cat_id);
{$AspisRetTemp = $cat->name;
return $AspisRetTemp;
} }
function comments_rss_link ( $link_text = 'Comments RSS',$deprecated = '' ) {
_deprecated_function(__FUNCTION__,'0.0','post_comments_feed_link()');
post_comments_feed_link($link_text);
 }
function get_category_rss_link ( $echo = false,$cat_ID = 1,$deprecated = '' ) {
_deprecated_function(__FUNCTION__,'0.0','get_category_feed_link()');
$link = get_category_feed_link($cat_ID,'rss2');
if ( $echo)
 echo $link;
{$AspisRetTemp = $link;
return $AspisRetTemp;
} }
function get_author_rss_link ( $echo = false,$author_id = 1,$deprecated = '' ) {
_deprecated_function(__FUNCTION__,'0.0','get_author_feed_link()');
$link = get_author_feed_link($author_id);
if ( $echo)
 echo $link;
{$AspisRetTemp = $link;
return $AspisRetTemp;
} }
function comments_rss ( $deprecated = '' ) {
_deprecated_function(__FUNCTION__,'2.2','get_post_comments_feed_link()');
{$AspisRetTemp = get_post_comments_feed_link();
return $AspisRetTemp;
} }
function create_user ( $username,$password,$email ) {
_deprecated_function(__FUNCTION__,'2.0','wp_create_user()');
{$AspisRetTemp = wp_create_user($username,$password,$email);
return $AspisRetTemp;
} }
function documentation_link ( $deprecated = '' ) {
_deprecated_function(__FUNCTION__,'2.5','');
{return ;
} }
function gzip_compression (  ) {
{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function get_commentdata ( $comment_ID,$no_cache = 0,$include_unapproved = false ) {
_deprecated_function(__FUNCTION__,'2.7','get_comment()');
{$AspisRetTemp = get_comment($comment_ID,ARRAY_A);
return $AspisRetTemp;
} }
function get_catname ( $cat_ID ) {
_deprecated_function(__FUNCTION__,'2.8','get_cat_name()');
{$AspisRetTemp = get_cat_name($cat_ID);
return $AspisRetTemp;
} }
function get_category_children ( $id,$before = '/',$after = '',$visited = array() ) {
_deprecated_function(__FUNCTION__,'2.8','get_term_children()');
if ( 0 == $id)
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$chain = '';
$cat_ids = get_all_category_ids();
foreach ( (array)$cat_ids as $cat_id  )
{if ( $cat_id == $id)
 continue ;
$category = get_category($cat_id);
if ( is_wp_error($category))
 {$AspisRetTemp = $category;
return $AspisRetTemp;
}if ( $category->parent == $id && !in_array($category->term_id,$visited))
 {$visited[] = $category->term_id;
$chain .= $before . $category->term_id . $after;
$chain .= get_category_children($category->term_id,$before,$after);
}}{$AspisRetTemp = $chain;
return $AspisRetTemp;
} }
function get_the_author_description (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'description\')');
{$AspisRetTemp = get_the_author_meta('description');
return $AspisRetTemp;
} }
function the_author_description (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'description\')');
the_author_meta('description');
 }
function get_the_author_login (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'login\')');
{$AspisRetTemp = get_the_author_meta('login');
return $AspisRetTemp;
} }
function the_author_login (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'login\')');
the_author_meta('login');
 }
function get_the_author_firstname (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'first_name\')');
{$AspisRetTemp = get_the_author_meta('first_name');
return $AspisRetTemp;
} }
function the_author_firstname (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'first_name\')');
the_author_meta('first_name');
 }
function get_the_author_lastname (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'last_name\')');
{$AspisRetTemp = get_the_author_meta('last_name');
return $AspisRetTemp;
} }
function the_author_lastname (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'last_name\')');
the_author_meta('last_name');
 }
function get_the_author_nickname (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'nickname\')');
{$AspisRetTemp = get_the_author_meta('nickname');
return $AspisRetTemp;
} }
function the_author_nickname (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'nickname\')');
the_author_meta('nickname');
 }
function get_the_author_email (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'email\')');
{$AspisRetTemp = get_the_author_meta('email');
return $AspisRetTemp;
} }
function the_author_email (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'email\')');
the_author_meta('email');
 }
function get_the_author_icq (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'icq\')');
{$AspisRetTemp = get_the_author_meta('icq');
return $AspisRetTemp;
} }
function the_author_icq (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'icq\')');
the_author_meta('icq');
 }
function get_the_author_yim (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'yim\')');
{$AspisRetTemp = get_the_author_meta('yim');
return $AspisRetTemp;
} }
function the_author_yim (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'yim\')');
the_author_meta('yim');
 }
function get_the_author_msn (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'msn\')');
{$AspisRetTemp = get_the_author_meta('msn');
return $AspisRetTemp;
} }
function the_author_msn (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'msn\')');
the_author_meta('msn');
 }
function get_the_author_aim (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'aim\')');
{$AspisRetTemp = get_the_author_meta('aim');
return $AspisRetTemp;
} }
function the_author_aim (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'aim\')');
the_author_meta('aim');
 }
function get_author_name ( $auth_id = false ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'display_name\')');
{$AspisRetTemp = get_the_author_meta('display_name',$auth_id);
return $AspisRetTemp;
} }
function get_the_author_url (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'url\')');
{$AspisRetTemp = get_the_author_meta('url');
return $AspisRetTemp;
} }
function the_author_url (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'url\')');
the_author_meta('url');
 }
function get_the_author_ID (  ) {
_deprecated_function(__FUNCTION__,'2.8','get_the_author_meta(\'ID\')');
{$AspisRetTemp = get_the_author_meta('ID');
return $AspisRetTemp;
} }
function the_author_ID (  ) {
_deprecated_function(__FUNCTION__,'2.8','the_author_meta(\'ID\')');
the_author_meta('ID');
 }
function the_content_rss ( $more_link_text = '(more...)',$stripteaser = 0,$more_file = '',$cut = 0,$encode_html = 0 ) {
_deprecated_function(__FUNCTION__,'2.9','the_content_feed');
$content = get_the_content($more_link_text,$stripteaser,$more_file);
$content = apply_filters('the_content_rss',$content);
if ( $cut && !$encode_html)
 $encode_html = 2;
if ( 1 == $encode_html)
 {$content = esc_html($content);
$cut = 0;
}elseif ( 0 == $encode_html)
 {$content = make_url_footnote($content);
}elseif ( 2 == $encode_html)
 {$content = strip_tags($content);
}if ( $cut)
 {$blah = explode(' ',$content);
if ( count($blah) > $cut)
 {$k = $cut;
$use_dotdotdot = 1;
}else 
{{$k = count($blah);
$use_dotdotdot = 0;
}}for ( $i = 0 ; $i < $k ; $i++ )
$excerpt .= $blah[$i] . ' ';
$excerpt .= ($use_dotdotdot) ? '...' : '';
$content = $excerpt;
}$content = str_replace(']]>',']]&gt;',$content);
echo $content;
 }
function make_url_footnote ( $content ) {
_deprecated_function(__FUNCTION__,'2.9','');
preg_match_all('/<a(.+?)href=\"(.+?)\"(.*?)>(.+?)<\/a>/',$content,$matches);
$links_summary = "\n";
for ( $i = 0 ; $i < count($matches[0]) ; $i++ )
{$link_match = $matches[0][$i];
$link_number = '[' . ($i + 1) . ']';
$link_url = $matches[2][$i];
$link_text = $matches[4][$i];
$content = str_replace($link_match,$link_text . ' ' . $link_number,$content);
$link_url = ((strtolower(substr($link_url,0,7)) != 'http://') && (strtolower(substr($link_url,0,8)) != 'https://')) ? get_option('home') . $link_url : $link_url;
$links_summary .= "\n" . $link_number . ' ' . $link_url;
}$content = strip_tags($content);
$content .= $links_summary;
{$AspisRetTemp = $content;
return $AspisRetTemp;
} }
function _c ( $text,$domain = 'default' ) {
_deprecated_function(__FUNCTION__,'2.9','_x');
{$AspisRetTemp = translate_with_context($text,$domain);
return $AspisRetTemp;
} }
;
