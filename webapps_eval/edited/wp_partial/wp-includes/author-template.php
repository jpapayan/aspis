<?php require_once('AspisMain.php'); ?><?php
function get_the_author ( $deprecated = '' ) {
{global $authordata;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $authordata,"\$authordata",$AspisChangesCache);
}{$AspisRetTemp = apply_filters('the_author',is_object($authordata) ? $authordata->display_name : null);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$authordata",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$authordata",$AspisChangesCache);
 }
function the_author ( $deprecated = '',$deprecated_echo = true ) {
if ( $deprecated_echo)
 echo get_the_author();
{$AspisRetTemp = get_the_author();
return $AspisRetTemp;
} }
function get_the_modified_author (  ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}if ( $last_id = get_post_meta($post->ID,'_edit_last',true))
 {$last_user = get_userdata($last_id);
{$AspisRetTemp = apply_filters('the_modified_author',$last_user->display_name);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function the_modified_author (  ) {
echo get_the_modified_author();
 }
function get_the_author_meta ( $field = '',$user_id = false ) {
if ( !$user_id)
 {global $authordata;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $authordata,"\$authordata",$AspisChangesCache);
}else 
{$authordata = get_userdata($user_id);
}$field = strtolower($field);
$user_field = "user_$field";
if ( 'id' == $field)
 $value = isset($authordata->ID) ? (int)$authordata->ID : 0;
elseif ( isset($authordata->$user_field))
 $value = $authordata->$user_field;
else 
{$value = isset($authordata->$field) ? $authordata->$field : '';
}{$AspisRetTemp = apply_filters('get_the_author_' . $field,$value,$user_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$authordata",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$authordata",$AspisChangesCache);
 }
function the_author_meta ( $field = '',$user_id = false ) {
echo apply_filters('the_author_' . $field,get_the_author_meta($field,$user_id),$user_id);
 }
function the_author_link (  ) {
if ( get_the_author_meta('url'))
 {echo '<a href="' . get_the_author_meta('url') . '" title="' . esc_attr(sprintf(__("Visit %s&#8217;s website"),get_the_author())) . '" rel="external">' . get_the_author() . '</a>';
}else 
{{the_author();
}} }
function get_the_author_posts (  ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}{$AspisRetTemp = get_usernumposts($post->post_author);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function the_author_posts (  ) {
echo get_the_author_posts();
 }
function the_author_posts_link ( $deprecated = '' ) {
{global $authordata;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $authordata,"\$authordata",$AspisChangesCache);
}$link = sprintf('<a href="%1$s" title="%2$s">%3$s</a>',get_author_posts_url($authordata->ID,$authordata->user_nicename),esc_attr(sprintf(__('Posts by %s'),get_the_author())),get_the_author());
echo apply_filters('the_author_posts_link',$link);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$authordata",$AspisChangesCache);
 }
function get_author_posts_url ( $author_id,$author_nicename = '' ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$auth_ID = (int)$author_id;
$link = $wp_rewrite->get_author_permastruct();
if ( empty($link))
 {$file = get_option('home') . '/';
$link = $file . '?author=' . $auth_ID;
}else 
{{if ( '' == $author_nicename)
 {$user = get_userdata($author_id);
if ( !empty($user->user_nicename))
 $author_nicename = $user->user_nicename;
}$link = str_replace('%author%',$author_nicename,$link);
$link = get_option('home') . trailingslashit($link);
}}$link = apply_filters('author_link',$link,$author_id,$author_nicename);
{$AspisRetTemp = $link;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function wp_list_authors ( $args = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$defaults = array('optioncount' => false,'exclude_admin' => true,'show_fullname' => false,'hide_empty' => true,'feed' => '','feed_image' => '','feed_type' => '','echo' => true,'style' => 'list','html' => true);
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
$return = '';
$authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users " . ($exclude_admin ? "WHERE user_login <> 'admin' " : '') . "ORDER BY display_name");
$author_count = array();
foreach ( (array)$wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql('post') . " GROUP BY post_author") as $row  )
{$author_count[$row->post_author] = $row->count;
}foreach ( (array)$authors as $author  )
{$link = '';
$author = get_userdata($author->ID);
$posts = (isset($author_count[$author->ID])) ? $author_count[$author->ID] : 0;
$name = $author->display_name;
if ( $show_fullname && ($author->first_name != '' && $author->last_name != ''))
 $name = "$author->first_name $author->last_name";
if ( !$html)
 {if ( $posts == 0)
 {if ( !$hide_empty)
 $return .= $name . ', ';
}else 
{$return .= $name . ', ';
}continue ;
}if ( !($posts == 0 && $hide_empty) && 'list' == $style)
 $return .= '<li>';
if ( $posts == 0)
 {if ( !$hide_empty)
 $link = $name;
}else 
{{$link = '<a href="' . get_author_posts_url($author->ID,$author->user_nicename) . '" title="' . esc_attr(sprintf(__("Posts by %s"),$author->display_name)) . '">' . $name . '</a>';
if ( (!empty($feed_image)) || (!empty($feed)))
 {$link .= ' ';
if ( empty($feed_image))
 $link .= '(';
$link .= '<a href="' . get_author_feed_link($author->ID) . '"';
if ( !empty($feed))
 {$title = ' title="' . esc_attr($feed) . '"';
$alt = ' alt="' . esc_attr($feed) . '"';
$name = $feed;
$link .= $title;
}$link .= '>';
if ( !empty($feed_image))
 $link .= "<img src=\"" . esc_url($feed_image) . "\" style=\"border: none;
\"$alt$title" . ' />';
else 
{$link .= $name;
}$link .= '</a>';
if ( empty($feed_image))
 $link .= ')';
}if ( $optioncount)
 $link .= ' (' . $posts . ')';
}}if ( !($posts == 0 && $hide_empty) && 'list' == $style)
 $return .= $link . '</li>';
else 
{if ( !$hide_empty)
 $return .= $link . ', ';
}}$return = trim($return,', ');
if ( !$echo)
 {$AspisRetTemp = $return;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}echo $return;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
;
?>
<?php 