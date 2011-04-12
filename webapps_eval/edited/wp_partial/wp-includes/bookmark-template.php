<?php require_once('AspisMain.php'); ?><?php
function _walk_bookmarks ( $bookmarks,$args = '' ) {
$defaults = array('show_updated' => 0,'show_description' => 0,'show_images' => 1,'show_name' => 0,'before' => '<li>','after' => '</li>','between' => "\n",'show_rating' => 0,'link_before' => '','link_after' => '');
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
$output = '';
foreach ( (array)$bookmarks as $bookmark  )
{if ( !isset($bookmark->recently_updated))
 $bookmark->recently_updated = false;
$output .= $before;
if ( $show_updated && $bookmark->recently_updated)
 $output .= get_option('links_recently_updated_prepend');
$the_link = '#';
if ( !empty($bookmark->link_url))
 $the_link = esc_url($bookmark->link_url);
$desc = esc_attr(sanitize_bookmark_field('link_description',$bookmark->link_description,$bookmark->link_id,'display'));
$name = esc_attr(sanitize_bookmark_field('link_name',$bookmark->link_name,$bookmark->link_id,'display'));
$title = $desc;
if ( $show_updated)
 if ( '00' != substr($bookmark->link_updated_f,0,2))
 {$title .= ' (';
$title .= sprintf(__('Last updated: %s'),date(get_option('links_updated_date_format'),$bookmark->link_updated_f + (get_option('gmt_offset') * 3600)));
$title .= ')';
}$alt = ' alt="' . $name . ($show_description ? ' ' . $title : '') . '"';
if ( '' != $title)
 $title = ' title="' . $title . '"';
$rel = $bookmark->link_rel;
if ( '' != $rel)
 $rel = ' rel="' . esc_attr($rel) . '"';
$target = $bookmark->link_target;
if ( '' != $target)
 $target = ' target="' . $target . '"';
$output .= '<a href="' . $the_link . '"' . $rel . $title . $target . '>';
$output .= $link_before;
if ( $bookmark->link_image != null && $show_images)
 {if ( strpos($bookmark->link_image,'http') === 0)
 $output .= "<img src=\"$bookmark->link_image\" $alt $title />";
else 
{$output .= "<img src=\"" . get_option('siteurl') . "$bookmark->link_image\" $alt $title />";
}if ( $show_name)
 $output .= " $name";
}else 
{{$output .= $name;
}}$output .= $link_after;
$output .= '</a>';
if ( $show_updated && $bookmark->recently_updated)
 $output .= get_option('links_recently_updated_append');
if ( $show_description && '' != $desc)
 $output .= $between . $desc;
if ( $show_rating)
 $output .= $between . sanitize_bookmark_field('link_rating',$bookmark->link_rating,$bookmark->link_id,'display');
$output .= "$after\n";
}{$AspisRetTemp = $output;
return $AspisRetTemp;
} }
function wp_list_bookmarks ( $args = '' ) {
$defaults = array('orderby' => 'name','order' => 'ASC','limit' => -1,'category' => '','exclude_category' => '','category_name' => '','hide_invisible' => 1,'show_updated' => 0,'echo' => 1,'categorize' => 1,'title_li' => __('Bookmarks'),'title_before' => '<h2>','title_after' => '</h2>','category_orderby' => 'name','category_order' => 'ASC','class' => 'linkcat','category_before' => '<li id="%id" class="%class">','category_after' => '</li>');
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
$output = '';
if ( $categorize)
 {$cats = get_terms('link_category',array('name__like' => $category_name,'include' => $category,'exclude' => $exclude_category,'orderby' => $category_orderby,'order' => $category_order,'hierarchical' => 0));
foreach ( (array)$cats as $cat  )
{$params = array_merge($r,array('category' => $cat->term_id));
$bookmarks = get_bookmarks($params);
if ( empty($bookmarks))
 continue ;
$output .= str_replace(array('%id','%class'),array("linkcat-$cat->term_id",$class),$category_before);
$catname = apply_filters("link_category",$cat->name);
$output .= "$title_before$catname$title_after\n\t<ul class='xoxo blogroll'>\n";
$output .= _walk_bookmarks($bookmarks,$r);
$output .= "\n\t</ul>\n$category_after\n";
}}else 
{{$bookmarks = get_bookmarks($r);
if ( !empty($bookmarks))
 {if ( !empty($title_li))
 {$output .= str_replace(array('%id','%class'),array("linkcat-$category",$class),$category_before);
$output .= "$title_before$title_li$title_after\n\t<ul class='xoxo blogroll'>\n";
$output .= _walk_bookmarks($bookmarks,$r);
$output .= "\n\t</ul>\n$category_after\n";
}else 
{{$output .= _walk_bookmarks($bookmarks,$r);
}}}}}$output = apply_filters('wp_list_bookmarks',$output);
if ( !$echo)
 {$AspisRetTemp = $output;
return $AspisRetTemp;
}echo $output;
 }
;
?>
<?php 