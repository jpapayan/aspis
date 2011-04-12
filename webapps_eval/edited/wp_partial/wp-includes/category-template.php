<?php require_once('AspisMain.php'); ?><?php
function get_category_link ( $category_id ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$catlink = $wp_rewrite->get_category_permastruct();
if ( empty($catlink))
 {$file = get_option('home') . '/';
$catlink = $file . '?cat=' . $category_id;
}else 
{{$category = &get_category($category_id);
if ( is_wp_error($category))
 {$AspisRetTemp = $category;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}$category_nicename = $category->slug;
if ( $category->parent == $category_id)
 $category->parent = 0;
elseif ( $category->parent != 0)
 $category_nicename = get_category_parents($category->parent,false,'/',true) . $category_nicename;
$catlink = str_replace('%category%',$category_nicename,$catlink);
$catlink = get_option('home') . user_trailingslashit($catlink,'category');
}}{$AspisRetTemp = apply_filters('category_link',$catlink,$category_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function get_category_parents ( $id,$link = false,$separator = '/',$nicename = false,$visited = array() ) {
$chain = '';
$parent = &get_category($id);
if ( is_wp_error($parent))
 {$AspisRetTemp = $parent;
return $AspisRetTemp;
}if ( $nicename)
 $name = $parent->slug;
else 
{$name = $parent->cat_name;
}if ( $parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent,$visited))
 {$visited[] = $parent->parent;
$chain .= get_category_parents($parent->parent,$link,$separator,$nicename,$visited);
}if ( $link)
 $chain .= '<a href="' . get_category_link($parent->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"),$parent->cat_name)) . '">' . $name . '</a>' . $separator;
else 
{$chain .= $name . $separator;
}{$AspisRetTemp = $chain;
return $AspisRetTemp;
} }
function get_the_category ( $id = false ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$id = (int)$id;
if ( !$id)
 $id = (int)$post->ID;
$categories = get_object_term_cache($id,'category');
if ( false === $categories)
 {$categories = wp_get_object_terms($id,'category');
wp_cache_add($id,$categories,'category_relationships');
}if ( !empty($categories))
 AspisUntainted_usort($categories,'_usort_terms_by_name');
else 
{$categories = array();
}foreach ( (array)array_keys($categories) as $key  )
{_make_cat_compat($categories[$key]);
}{$AspisRetTemp = $categories;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function _usort_terms_by_name ( $a,$b ) {
{$AspisRetTemp = strcmp($a->name,$b->name);
return $AspisRetTemp;
} }
function _usort_terms_by_ID ( $a,$b ) {
if ( $a->term_id > $b->term_id)
 {$AspisRetTemp = 1;
return $AspisRetTemp;
}elseif ( $a->term_id < $b->term_id)
 {$AspisRetTemp = -1;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = 0;
return $AspisRetTemp;
}} }
function get_the_category_by_ID ( $cat_ID ) {
$cat_ID = (int)$cat_ID;
$category = &get_category($cat_ID);
if ( is_wp_error($category))
 {$AspisRetTemp = $category;
return $AspisRetTemp;
}{$AspisRetTemp = $category->name;
return $AspisRetTemp;
} }
function get_the_category_list ( $separator = '',$parents = '',$post_id = false ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$categories = get_the_category($post_id);
if ( empty($categories))
 {$AspisRetTemp = apply_filters('the_category',__('Uncategorized'),$separator,$parents);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}$rel = (is_object($wp_rewrite) && $wp_rewrite->using_permalinks()) ? 'rel="category tag"' : 'rel="category"';
$thelist = '';
if ( '' == $separator)
 {$thelist .= '<ul class="post-categories">';
foreach ( $categories as $category  )
{$thelist .= "\n\t<li>";
switch ( strtolower($parents) ) {
case 'multiple':if ( $category->parent)
 $thelist .= get_category_parents($category->parent,true,$separator);
$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"),$category->name)) . '" ' . $rel . '>' . $category->name . '</a></li>';
break ;
case 'single':$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"),$category->name)) . '" ' . $rel . '>';
if ( $category->parent)
 $thelist .= get_category_parents($category->parent,false,$separator);
$thelist .= $category->name . '</a></li>';
break ;
case '':default :$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"),$category->name)) . '" ' . $rel . '>' . $category->cat_name . '</a></li>';
 }
}$thelist .= '</ul>';
}else 
{{$i = 0;
foreach ( $categories as $category  )
{if ( 0 < $i)
 $thelist .= $separator . ' ';
switch ( strtolower($parents) ) {
case 'multiple':if ( $category->parent)
 $thelist .= get_category_parents($category->parent,true,$separator);
$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"),$category->name)) . '" ' . $rel . '>' . $category->cat_name . '</a>';
break ;
case 'single':$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"),$category->name)) . '" ' . $rel . '>';
if ( $category->parent)
 $thelist .= get_category_parents($category->parent,false,$separator);
$thelist .= "$category->cat_name</a>";
break ;
case '':default :$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"),$category->name)) . '" ' . $rel . '>' . $category->name . '</a>';
 }
++$i;
}}}{$AspisRetTemp = apply_filters('the_category',$thelist,$separator,$parents);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function in_category ( $category,$_post = null ) {
if ( empty($category))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( $_post)
 {$_post = get_post($_post);
}else 
{{$_post = &$GLOBALS[0]['post'];
}}if ( !$_post)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$r = is_object_in_term($_post->ID,'category',$category);
if ( is_wp_error($r))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $r;
return $AspisRetTemp;
} }
function the_category ( $separator = '',$parents = '',$post_id = false ) {
echo get_the_category_list($separator,$parents,$post_id);
 }
function category_description ( $category = 0 ) {
{$AspisRetTemp = term_description($category,'category');
return $AspisRetTemp;
} }
function wp_dropdown_categories ( $args = '' ) {
$defaults = array('show_option_all' => '','show_option_none' => '','orderby' => 'id','order' => 'ASC','show_last_update' => 0,'show_count' => 0,'hide_empty' => 1,'child_of' => 0,'exclude' => '','echo' => 1,'selected' => 0,'hierarchical' => 0,'name' => 'cat','class' => 'postform','depth' => 0,'tab_index' => 0);
$defaults['selected'] = (is_category()) ? get_query_var('cat') : 0;
$r = wp_parse_args($args,$defaults);
if ( !isset($r['pad_counts']) && $r['show_count'] && $r['hierarchical'])
 {$r['pad_counts'] = true;
}$r['include_last_update_time'] = $r['show_last_update'];
extract(($r));
$tab_index_attribute = '';
if ( (int)$tab_index > 0)
 $tab_index_attribute = " tabindex=\"$tab_index\"";
$categories = get_categories($r);
$name = esc_attr($name);
$class = esc_attr($class);
$output = '';
if ( !empty($categories))
 {$output = "<select name='$name' id='$name' class='$class' $tab_index_attribute>\n";
if ( $show_option_all)
 {$show_option_all = apply_filters('list_cats',$show_option_all);
$selected = ('0' === strval($r['selected'])) ? " selected='selected'" : '';
$output .= "\t<option value='0'$selected>$show_option_all</option>\n";
}if ( $show_option_none)
 {$show_option_none = apply_filters('list_cats',$show_option_none);
$selected = ('-1' === strval($r['selected'])) ? " selected='selected'" : '';
$output .= "\t<option value='-1'$selected>$show_option_none</option>\n";
}if ( $hierarchical)
 $depth = $r['depth'];
else 
{$depth = -1;
}$output .= walk_category_dropdown_tree($categories,$depth,$r);
$output .= "</select>\n";
}$output = apply_filters('wp_dropdown_cats',$output);
if ( $echo)
 echo $output;
{$AspisRetTemp = $output;
return $AspisRetTemp;
} }
function wp_list_categories ( $args = '' ) {
$defaults = array('show_option_all' => '','orderby' => 'name','order' => 'ASC','show_last_update' => 0,'style' => 'list','show_count' => 0,'hide_empty' => 1,'use_desc_for_title' => 1,'child_of' => 0,'feed' => '','feed_type' => '','feed_image' => '','exclude' => '','exclude_tree' => '','current_category' => 0,'hierarchical' => true,'title_li' => __('Categories'),'echo' => 1,'depth' => 0);
$r = wp_parse_args($args,$defaults);
if ( !isset($r['pad_counts']) && $r['show_count'] && $r['hierarchical'])
 {$r['pad_counts'] = true;
}if ( isset($r['show_date']))
 {$r['include_last_update_time'] = $r['show_date'];
}if ( true == $r['hierarchical'])
 {$r['exclude_tree'] = $r['exclude'];
$r['exclude'] = '';
}extract(($r));
$categories = get_categories($r);
$output = '';
if ( $title_li && 'list' == $style)
 $output = '<li class="categories">' . $r['title_li'] . '<ul>';
if ( empty($categories))
 {if ( 'list' == $style)
 $output .= '<li>' . __("No categories") . '</li>';
else 
{$output .= __("No categories");
}}else 
{{{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}if ( !empty($show_option_all))
 if ( 'list' == $style)
 $output .= '<li><a href="' . get_bloginfo('url') . '">' . $show_option_all . '</a></li>';
else 
{$output .= '<a href="' . get_bloginfo('url') . '">' . $show_option_all . '</a>';
}if ( empty($r['current_category']) && is_category())
 $r['current_category'] = $wp_query->get_queried_object_id();
if ( $hierarchical)
 $depth = $r['depth'];
else 
{$depth = -1;
}$output .= walk_category_tree($categories,$depth,$r);
}}if ( $title_li && 'list' == $style)
 $output .= '</ul></li>';
$output = apply_filters('wp_list_categories',$output);
if ( $echo)
 echo $output;
else 
{{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function wp_tag_cloud ( $args = '' ) {
$defaults = array('smallest' => 8,'largest' => 22,'unit' => 'pt','number' => 45,'format' => 'flat','separator' => "\n",'orderby' => 'name','order' => 'ASC','exclude' => '','include' => '','link' => 'view','taxonomy' => 'post_tag','echo' => true);
$args = wp_parse_args($args,$defaults);
$tags = get_terms($args['taxonomy'],array_merge($args,array('orderby' => 'count','order' => 'DESC')));
if ( empty($tags))
 {return ;
}foreach ( $tags as $key =>$tag )
{if ( 'edit' == $args['link'])
 $link = get_edit_tag_link($tag->term_id,$args['taxonomy']);
else 
{$link = get_term_link(intval($tag->term_id),$args['taxonomy']);
}if ( is_wp_error($link))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$tags[$key]->link = $link;
$tags[$key]->id = $tag->term_id;
}$return = wp_generate_tag_cloud($tags,$args);
$return = apply_filters('wp_tag_cloud',$return,$args);
if ( 'array' == $args['format'] || empty($args['echo']))
 {$AspisRetTemp = $return;
return $AspisRetTemp;
}echo $return;
 }
function default_topic_count_text ( $count ) {
{$AspisRetTemp = sprintf(_n('%s topic','%s topics',$count),number_format_i18n($count));
return $AspisRetTemp;
} }
function default_topic_count_scale ( $count ) {
{$AspisRetTemp = round(log10($count + 1) * 100);
return $AspisRetTemp;
} }
function wp_generate_tag_cloud ( $tags,$args = '' ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$defaults = array('smallest' => 8,'largest' => 22,'unit' => 'pt','number' => 0,'format' => 'flat','separator' => "\n",'orderby' => 'name','order' => 'ASC','topic_count_text_callback' => 'default_topic_count_text','topic_count_scale_callback' => 'default_topic_count_scale','filter' => 1,);
if ( !isset($args['topic_count_text_callback']) && isset($args['single_text']) && isset($args['multiple_text']))
 {$body = 'return sprintf (
			_n(' . var_export($args['single_text'],true) . ', ' . var_export($args['multiple_text'],true) . ', $count),
			number_format_i18n( $count ));';
$args['topic_count_text_callback'] = create_function('$count',$body);
}$args = wp_parse_args($args,$defaults);
extract(($args));
if ( empty($tags))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return ;
}$tags_sorted = apply_filters('tag_cloud_sort',$tags,$args);
if ( $tags_sorted != $tags)
 {$tags = $tags_sorted;
unset($tags_sorted);
}else 
{{if ( 'RAND' == $order)
 {shuffle($tags);
}else 
{{if ( 'name' == $orderby)
 uasort($tags,create_function('$a, $b','return strnatcasecmp($a->name, $b->name);'));
else 
{uasort($tags,create_function('$a, $b','return ($a->count > $b->count);'));
}if ( 'DESC' == $order)
 $tags = array_reverse($tags,true);
}}}}if ( $number > 0)
 $tags = array_slice($tags,0,$number);
$counts = array();
$real_counts = array();
foreach ( (array)$tags as $key =>$tag )
{$real_counts[$key] = $tag->count;
$counts[$key] = AspisUntaintedDynamicCall($topic_count_scale_callback,$tag->count);
}$min_count = min($counts);
$spread = max($counts) - $min_count;
if ( $spread <= 0)
 $spread = 1;
$font_spread = $largest - $smallest;
if ( $font_spread < 0)
 $font_spread = 1;
$font_step = $font_spread / $spread;
$a = array();
foreach ( $tags as $key =>$tag )
{$count = $counts[$key];
$real_count = $real_counts[$key];
$tag_link = '#' != $tag->link ? esc_url($tag->link) : '#';
$tag_id = isset($tags[$key]->id) ? $tags[$key]->id : $key;
$tag_name = $tags[$key]->name;
$a[] = "<a href='$tag_link' class='tag-link-$tag_id' title='" . esc_attr(AspisUntaintedDynamicCall($topic_count_text_callback,$real_count)) . "' style='font-size: " . ($smallest + (($count - $min_count) * $font_step)) . "$unit;'>$tag_name</a>";
}switch ( $format ) {
case 'array':$return = &$a;
break ;
;
case 'list':$return = "<ul class='wp-tag-cloud'>\n\t<li>";
$return .= join("</li>\n\t<li>",$a);
$return .= "</li>\n</ul>\n";
break ;
default :$return = join($separator,$a);
break ;
 }
if ( $filter)
 {$AspisRetTemp = apply_filters('wp_generate_tag_cloud',$return,$tags,$args);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = $return;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function walk_category_tree (  ) {
$args = func_get_args();
if ( empty($args[2]['walker']) || !is_a($args[2]['walker'],'Walker'))
 $walker = new Walker_Category;
else 
{$walker = $args[2]['walker'];
}{$AspisRetTemp = AspisUntainted_call_user_func_array(array(&$walker,'walk'),$args);
return $AspisRetTemp;
} }
function walk_category_dropdown_tree (  ) {
$args = func_get_args();
if ( empty($args[2]['walker']) || !is_a($args[2]['walker'],'Walker'))
 $walker = new Walker_CategoryDropdown;
else 
{$walker = $args[2]['walker'];
}{$AspisRetTemp = AspisUntainted_call_user_func_array(array(&$walker,'walk'),$args);
return $AspisRetTemp;
} }
function get_tag_link ( $tag_id ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$taglink = $wp_rewrite->get_tag_permastruct();
$tag = &get_term($tag_id,'post_tag');
if ( is_wp_error($tag))
 {$AspisRetTemp = $tag;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}$slug = $tag->slug;
if ( empty($taglink))
 {$file = get_option('home') . '/';
$taglink = $file . '?tag=' . $slug;
}else 
{{$taglink = str_replace('%tag%',$slug,$taglink);
$taglink = get_option('home') . user_trailingslashit($taglink,'category');
}}{$AspisRetTemp = apply_filters('tag_link',$taglink,$tag_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
function get_the_tags ( $id = 0 ) {
{$AspisRetTemp = apply_filters('get_the_tags',get_the_terms($id,'post_tag'));
return $AspisRetTemp;
} }
function get_the_tag_list ( $before = '',$sep = '',$after = '' ) {
{$AspisRetTemp = apply_filters('the_tags',get_the_term_list(0,'post_tag',$before,$sep,$after),$before,$sep,$after);
return $AspisRetTemp;
} }
function the_tags ( $before = null,$sep = ', ',$after = '' ) {
if ( null === $before)
 $before = __('Tags: ');
echo get_the_tag_list($before,$sep,$after);
 }
function tag_description ( $tag = 0 ) {
{$AspisRetTemp = term_description($tag);
return $AspisRetTemp;
} }
function term_description ( $term = 0,$taxonomy = 'post_tag' ) {
if ( !$term && (is_tax() || is_tag() || is_category()))
 {{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}$term = $wp_query->get_queried_object();
$taxonomy = $term->taxonomy;
$term = $term->term_id;
}{$AspisRetTemp = get_term_field('description',$term,$taxonomy);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function get_the_terms ( $id = 0,$taxonomy ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$id = (int)$id;
if ( !$id)
 {if ( !$post->ID)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}else 
{$id = (int)$post->ID;
}}$terms = get_object_term_cache($id,$taxonomy);
if ( false === $terms)
 $terms = wp_get_object_terms($id,$taxonomy);
if ( empty($terms))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $terms;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function get_the_term_list ( $id = 0,$taxonomy,$before = '',$sep = '',$after = '' ) {
$terms = get_the_terms($id,$taxonomy);
if ( is_wp_error($terms))
 {$AspisRetTemp = $terms;
return $AspisRetTemp;
}if ( empty($terms))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}foreach ( $terms as $term  )
{$link = get_term_link($term,$taxonomy);
if ( is_wp_error($link))
 {$AspisRetTemp = $link;
return $AspisRetTemp;
}$term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . '</a>';
}$term_links = apply_filters("term_links-$taxonomy",$term_links);
{$AspisRetTemp = $before . join($sep,$term_links) . $after;
return $AspisRetTemp;
} }
function the_terms ( $id,$taxonomy,$before = '',$sep = ', ',$after = '' ) {
$term_list = get_the_term_list($id,$taxonomy,$before,$sep,$after);
if ( is_wp_error($term_list))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}echo apply_filters('the_terms',$term_list,$taxonomy,$before,$sep,$after);
 }
function has_tag ( $tag = '',$_post = null ) {
if ( $_post)
 {$_post = get_post($_post);
}else 
{{$_post = &$GLOBALS[0]['post'];
}}if ( !$_post)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$r = is_object_in_term($_post->ID,'post_tag',$tag);
if ( is_wp_error($r))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $r;
return $AspisRetTemp;
} }
;
?>
<?php 