<?php require_once('AspisMain.php'); ?><?php
function the_ID (  ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}echo $id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function get_the_ID (  ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}{$AspisRetTemp = $id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function the_title ( $before = '',$after = '',$echo = true ) {
$title = get_the_title();
if ( strlen($title) == 0)
 {return ;
}$title = $before . $title . $after;
if ( $echo)
 echo $title;
else 
{{$AspisRetTemp = $title;
return $AspisRetTemp;
}} }
function the_title_attribute ( $args = '' ) {
$title = get_the_title();
if ( strlen($title) == 0)
 {return ;
}$defaults = array('before' => '','after' => '','echo' => true);
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
$title = $before . $title . $after;
$title = esc_attr(strip_tags($title));
if ( $echo)
 echo $title;
else 
{{$AspisRetTemp = $title;
return $AspisRetTemp;
}} }
function get_the_title ( $id = 0 ) {
$post = &get_post($id);
$title = $post->post_title;
if ( !is_admin())
 {if ( !empty($post->post_password))
 {$protected_title_format = apply_filters('protected_title_format',__('Protected: %s'));
$title = sprintf($protected_title_format,$title);
}else 
{if ( isset($post->post_status) && 'private' == $post->post_status)
 {$private_title_format = apply_filters('private_title_format',__('Private: %s'));
$title = sprintf($private_title_format,$title);
}}}{$AspisRetTemp = apply_filters('the_title',$title,$post->ID);
return $AspisRetTemp;
} }
function the_guid ( $id = 0 ) {
echo get_the_guid($id);
 }
function get_the_guid ( $id = 0 ) {
$post = &get_post($id);
{$AspisRetTemp = apply_filters('get_the_guid',$post->guid);
return $AspisRetTemp;
} }
function the_content ( $more_link_text = null,$stripteaser = 0 ) {
$content = get_the_content($more_link_text,$stripteaser);
$content = apply_filters('the_content',$content);
$content = str_replace(']]>',']]&gt;',$content);
echo $content;
 }
function get_the_content ( $more_link_text = null,$stripteaser = 0 ) {
{global $id,$post,$more,$page,$pages,$multipage,$preview,$pagenow;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($post,"\$post",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($more,"\$more",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($page,"\$page",$AspisChangesCache);
$AspisVar4 = &AspisCleanTaintedGlobalUntainted($pages,"\$pages",$AspisChangesCache);
$AspisVar5 = &AspisCleanTaintedGlobalUntainted($multipage,"\$multipage",$AspisChangesCache);
$AspisVar6 = &AspisCleanTaintedGlobalUntainted($preview,"\$preview",$AspisChangesCache);
$AspisVar7 = &AspisCleanTaintedGlobalUntainted($pagenow,"\$pagenow",$AspisChangesCache);
}if ( null === $more_link_text)
 $more_link_text = __('(more...)');
$output = '';
$hasTeaser = false;
if ( post_password_required($post))
 {$output = get_the_password_form();
{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$more",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$pages",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$multipage",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$preview",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$pagenow",$AspisChangesCache);
return $AspisRetTemp;
}}if ( $page > count($pages))
 $page = count($pages);
$content = $pages[$page - 1];
if ( preg_match('/<!--more(.*?)?-->/',$content,$matches))
 {$content = explode($matches[0],$content,2);
if ( !empty($matches[1]) && !empty($more_link_text))
 $more_link_text = strip_tags(wp_kses_no_null(trim($matches[1])));
$hasTeaser = true;
}else 
{{$content = array($content);
}}if ( (false !== strpos($post->post_content,'<!--noteaser-->') && ((!$multipage) || ($page == 1))))
 $stripteaser = 1;
$teaser = $content[0];
if ( ($more) && ($stripteaser) && ($hasTeaser))
 $teaser = '';
$output .= $teaser;
if ( count($content) > 1)
 {if ( $more)
 {$output .= '<span id="more-' . $id . '"></span>' . $content[1];
}else 
{{if ( !empty($more_link_text))
 $output .= apply_filters('the_content_more_link',' <a href="' . get_permalink() . "#more-$id\" class=\"more-link\">$more_link_text</a>",$more_link_text);
$output = force_balance_tags($output);
}}}if ( $preview)
 $output = preg_replace_callback('/\%u([0-9A-F]{4})/',create_function('$match','return "&#" . base_convert($match[1], 16, 10) . ";";'),$output);
{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$more",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$pages",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$multipage",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$preview",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$pagenow",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$more",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$pages",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$multipage",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$preview",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$pagenow",$AspisChangesCache);
 }
function the_excerpt (  ) {
echo apply_filters('the_excerpt',get_the_excerpt());
 }
function get_the_excerpt ( $deprecated = '' ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$output = $post->post_excerpt;
if ( post_password_required($post))
 {$output = __('There is no excerpt because this is a protected post.');
{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = apply_filters('get_the_excerpt',$output);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function has_excerpt ( $id = 0 ) {
$post = &get_post($id);
{$AspisRetTemp = (!empty($post->post_excerpt));
return $AspisRetTemp;
} }
function post_class ( $class = '',$post_id = null ) {
echo 'class="' . join(' ',get_post_class($class,$post_id)) . '"';
 }
function get_post_class ( $class = '',$post_id = null ) {
$post = get_post($post_id);
$classes = array();
if ( empty($post))
 {$AspisRetTemp = $classes;
return $AspisRetTemp;
}$classes[] = 'post-' . $post->ID;
$classes[] = $post->post_type;
if ( is_sticky($post->ID) && is_home())
 $classes[] = 'sticky';
$classes[] = 'hentry';
foreach ( (array)get_the_category($post->ID) as $cat  )
{if ( empty($cat->slug))
 continue ;
$classes[] = 'category-' . sanitize_html_class($cat->slug,$cat->cat_ID);
}foreach ( (array)get_the_tags($post->ID) as $tag  )
{if ( empty($tag->slug))
 continue ;
$classes[] = 'tag-' . sanitize_html_class($tag->slug,$tag->term_id);
}if ( !empty($class))
 {if ( !is_array($class))
 $class = preg_split('#\s+#',$class);
$classes = array_merge($classes,$class);
}$classes = array_map('esc_attr',$classes);
{$AspisRetTemp = apply_filters('post_class',$classes,$class,$post_id);
return $AspisRetTemp;
} }
function body_class ( $class = '' ) {
echo 'class="' . join(' ',get_body_class($class)) . '"';
 }
function get_body_class ( $class = '' ) {
{global $wp_query,$wpdb,$current_user;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($current_user,"\$current_user",$AspisChangesCache);
}$classes = array();
if ( 'rtl' == get_bloginfo('text_direction'))
 $classes[] = 'rtl';
if ( is_front_page())
 $classes[] = 'home';
if ( is_home())
 $classes[] = 'blog';
if ( is_archive())
 $classes[] = 'archive';
if ( is_date())
 $classes[] = 'date';
if ( is_search())
 $classes[] = 'search';
if ( is_paged())
 $classes[] = 'paged';
if ( is_attachment())
 $classes[] = 'attachment';
if ( is_404())
 $classes[] = 'error404';
if ( is_single())
 {$wp_query->post = $wp_query->posts[0];
setup_postdata($wp_query->post);
$postID = $wp_query->post->ID;
$classes[] = 'single postid-' . $postID;
if ( is_attachment())
 {$mime_type = get_post_mime_type();
$mime_prefix = array('application/','image/','text/','audio/','video/','music/');
$classes[] = 'attachmentid-' . $postID;
$classes[] = 'attachment-' . str_replace($mime_prefix,'',$mime_type);
}}elseif ( is_archive())
 {if ( is_author())
 {$author = $wp_query->get_queried_object();
$classes[] = 'author';
$classes[] = 'author-' . sanitize_html_class($author->user_nicename,$author->ID);
}elseif ( is_category())
 {$cat = $wp_query->get_queried_object();
$classes[] = 'category';
$classes[] = 'category-' . sanitize_html_class($cat->slug,$cat->cat_ID);
}elseif ( is_tag())
 {$tags = $wp_query->get_queried_object();
$classes[] = 'tag';
$classes[] = 'tag-' . sanitize_html_class($tags->slug,$tags->term_id);
}}elseif ( is_page())
 {$classes[] = 'page';
$wp_query->post = $wp_query->posts[0];
setup_postdata($wp_query->post);
$pageID = $wp_query->post->ID;
$classes[] = 'page-id-' . $pageID;
if ( $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'page' LIMIT 1",$pageID)))
 $classes[] = 'page-parent';
if ( $wp_query->post->post_parent)
 {$classes[] = 'page-child';
$classes[] = 'parent-pageid-' . $wp_query->post->post_parent;
}if ( is_page_template())
 {$classes[] = 'page-template';
$classes[] = 'page-template-' . str_replace('.php','-php',get_post_meta($pageID,'_wp_page_template',true));
}}elseif ( is_search())
 {if ( !empty($wp_query->posts))
 $classes[] = 'search-results';
else 
{$classes[] = 'search-no-results';
}}if ( is_user_logged_in())
 $classes[] = 'logged-in';
$page = $wp_query->get('page');
if ( !$page || $page < 2)
 $page = $wp_query->get('paged');
if ( $page && $page > 1)
 {$classes[] = 'paged-' . $page;
if ( is_single())
 $classes[] = 'single-paged-' . $page;
elseif ( is_page())
 $classes[] = 'page-paged-' . $page;
elseif ( is_category())
 $classes[] = 'category-paged-' . $page;
elseif ( is_tag())
 $classes[] = 'tag-paged-' . $page;
elseif ( is_date())
 $classes[] = 'date-paged-' . $page;
elseif ( is_author())
 $classes[] = 'author-paged-' . $page;
elseif ( is_search())
 $classes[] = 'search-paged-' . $page;
}if ( !empty($class))
 {if ( !is_array($class))
 $class = preg_split('#\s+#',$class);
$classes = array_merge($classes,$class);
}$classes = array_map('esc_attr',$classes);
{$AspisRetTemp = apply_filters('body_class',$classes,$class);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$current_user",$AspisChangesCache);
 }
function post_password_required ( $post = null ) {
$post = get_post($post);
if ( empty($post->post_password))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !(isset($_COOKIE[0]['wp-postpass_' . COOKIEHASH]) && Aspis_isset($_COOKIE[0]['wp-postpass_' . COOKIEHASH])))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}if ( deAspisWarningRC($_COOKIE[0]['wp-postpass_' . COOKIEHASH]) != $post->post_password)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function sticky_class ( $post_id = null ) {
if ( !is_sticky($post_id))
 {return ;
}echo " sticky";
 }
function wp_link_pages ( $args = '' ) {
$defaults = array('before' => '<p>' . __('Pages:'),'after' => '</p>','link_before' => '','link_after' => '','next_or_number' => 'number','nextpagelink' => __('Next page'),'previouspagelink' => __('Previous page'),'pagelink' => '%','echo' => 1);
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
{global $post,$page,$numpages,$multipage,$more,$pagenow;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($page,"\$page",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($numpages,"\$numpages",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($multipage,"\$multipage",$AspisChangesCache);
$AspisVar4 = &AspisCleanTaintedGlobalUntainted($more,"\$more",$AspisChangesCache);
$AspisVar5 = &AspisCleanTaintedGlobalUntainted($pagenow,"\$pagenow",$AspisChangesCache);
}$output = '';
if ( $multipage)
 {if ( 'number' == $next_or_number)
 {$output .= $before;
for ( $i = 1 ; $i < ($numpages + 1) ; $i = $i + 1 )
{$j = str_replace('%',"$i",$pagelink);
$output .= ' ';
if ( ($i != $page) || ((!$more) && ($page == 1)))
 {if ( 1 == $i)
 {$output .= '<a href="' . get_permalink() . '">';
}else 
{{if ( '' == get_option('permalink_structure') || in_array($post->post_status,array('draft','pending')))
 $output .= '<a href="' . get_permalink() . '&amp;page=' . $i . '">';
else 
{$output .= '<a href="' . trailingslashit(get_permalink()) . user_trailingslashit($i,'single_paged') . '">';
}}}}$output .= $link_before;
$output .= $j;
$output .= $link_after;
if ( ($i != $page) || ((!$more) && ($page == 1)))
 $output .= '</a>';
}$output .= $after;
}else 
{{if ( $more)
 {$output .= $before;
$i = $page - 1;
if ( $i && $more)
 {if ( 1 == $i)
 {$output .= '<a href="' . get_permalink() . '">' . $link_before . $previouspagelink . $link_after . '</a>';
}else 
{{if ( '' == get_option('permalink_structure') || in_array($post->post_status,array('draft','pending')))
 $output .= '<a href="' . get_permalink() . '&amp;page=' . $i . '">' . $link_before . $previouspagelink . $link_after . '</a>';
else 
{$output .= '<a href="' . trailingslashit(get_permalink()) . user_trailingslashit($i,'single_paged') . '">' . $link_before . $previouspagelink . $link_after . '</a>';
}}}}$i = $page + 1;
if ( $i <= $numpages && $more)
 {if ( 1 == $i)
 {$output .= '<a href="' . get_permalink() . '">' . $link_before . $nextpagelink . $link_after . '</a>';
}else 
{{if ( '' == get_option('permalink_structure') || in_array($post->post_status,array('draft','pending')))
 $output .= '<a href="' . get_permalink() . '&amp;page=' . $i . '">' . $link_before . $nextpagelink . $link_after . '</a>';
else 
{$output .= '<a href="' . trailingslashit(get_permalink()) . user_trailingslashit($i,'single_paged') . '">' . $link_before . $nextpagelink . $link_after . '</a>';
}}}}$output .= $after;
}}}}if ( $echo)
 echo $output;
{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$numpages",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$multipage",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$more",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$pagenow",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$page",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$numpages",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$multipage",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$more",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$pagenow",$AspisChangesCache);
 }
function post_custom ( $key = '' ) {
$custom = get_post_custom();
if ( 1 == count($custom[$key]))
 {$AspisRetTemp = $custom[$key][0];
return $AspisRetTemp;
}else 
{{$AspisRetTemp = $custom[$key];
return $AspisRetTemp;
}} }
function the_meta (  ) {
if ( $keys = get_post_custom_keys())
 {echo "<ul class='post-meta'>\n";
foreach ( (array)$keys as $key  )
{$keyt = trim($key);
if ( '_' == $keyt[0])
 continue ;
$values = array_map('trim',get_post_custom_values($key));
$value = implode($values,', ');
echo apply_filters('the_meta_key',"<li><span class='post-meta-key'>$key:</span> $value</li>\n",$key,$value);
}echo "</ul>\n";
} }
function wp_dropdown_pages ( $args = '' ) {
$defaults = array('depth' => 0,'child_of' => 0,'selected' => 0,'echo' => 1,'name' => 'page_id','show_option_none' => '','show_option_no_change' => '','option_none_value' => '');
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
$pages = get_pages($r);
$output = '';
$name = esc_attr($name);
if ( !empty($pages))
 {$output = "<select name=\"$name\" id=\"$name\">\n";
if ( $show_option_no_change)
 $output .= "\t<option value=\"-1\">$show_option_no_change</option>";
if ( $show_option_none)
 $output .= "\t<option value=\"" . esc_attr($option_none_value) . "\">$show_option_none</option>\n";
$output .= walk_page_dropdown_tree($pages,$depth,$r);
$output .= "</select>\n";
}$output = apply_filters('wp_dropdown_pages',$output);
if ( $echo)
 echo $output;
{$AspisRetTemp = $output;
return $AspisRetTemp;
} }
function wp_list_pages ( $args = '' ) {
$defaults = array('depth' => 0,'show_date' => '','date_format' => get_option('date_format'),'child_of' => 0,'exclude' => '','title_li' => __('Pages'),'echo' => 1,'authors' => '','sort_column' => 'menu_order, post_title','link_before' => '','link_after' => '','walker' => '',);
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
$output = '';
$current_page = 0;
$r['exclude'] = preg_replace('/[^0-9,]/','',$r['exclude']);
$exclude_array = ($r['exclude']) ? explode(',',$r['exclude']) : array();
$r['exclude'] = implode(',',apply_filters('wp_list_pages_excludes',$exclude_array));
$r['hierarchical'] = 0;
$pages = get_pages($r);
if ( !empty($pages))
 {if ( $r['title_li'])
 $output .= '<li class="pagenav">' . $r['title_li'] . '<ul>';
{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}if ( is_page() || is_attachment() || $wp_query->is_posts_page)
 $current_page = $wp_query->get_queried_object_id();
$output .= walk_page_tree($pages,$r['depth'],$current_page,$r);
if ( $r['title_li'])
 $output .= '</ul></li>';
}$output = apply_filters('wp_list_pages',$output,$r);
if ( $r['echo'])
 echo $output;
else 
{{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function wp_page_menu ( $args = array() ) {
$defaults = array('sort_column' => 'menu_order, post_title','menu_class' => 'menu','echo' => true,'link_before' => '','link_after' => '');
$args = wp_parse_args($args,$defaults);
$args = apply_filters('wp_page_menu_args',$args);
$menu = '';
$list_args = $args;
if ( isset($args['show_home']) && !empty($args['show_home']))
 {if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'])
 $text = __('Home');
else 
{$text = $args['show_home'];
}$class = '';
if ( is_front_page() && !is_paged())
 $class = 'class="current_page_item"';
$menu .= '<li ' . $class . '><a href="' . get_option('home') . '" title="' . esc_attr($text) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
if ( get_option('show_on_front') == 'page')
 {if ( !empty($list_args['exclude']))
 {$list_args['exclude'] .= ',';
}else 
{{$list_args['exclude'] = '';
}}$list_args['exclude'] .= get_option('page_on_front');
}}$list_args['echo'] = false;
$list_args['title_li'] = '';
$menu .= str_replace(array("\r","\n","\t"),'',wp_list_pages($list_args));
if ( $menu)
 $menu = '<ul>' . $menu . '</ul>';
$menu = '<div class="' . esc_attr($args['menu_class']) . '">' . $menu . "</div>\n";
$menu = apply_filters('wp_page_menu',$menu,$args);
if ( $args['echo'])
 echo $menu;
else 
{{$AspisRetTemp = $menu;
return $AspisRetTemp;
}} }
function walk_page_tree ( $pages,$depth,$current_page,$r ) {
if ( empty($r['walker']))
 $walker = new Walker_Page;
else 
{$walker = $r['walker'];
}$args = array($pages,$depth,$r,$current_page);
{$AspisRetTemp = AspisUntainted_call_user_func_array(array(&$walker,'walk'),$args);
return $AspisRetTemp;
} }
function walk_page_dropdown_tree (  ) {
$args = func_get_args();
if ( empty($args[2]['walker']))
 $walker = new Walker_PageDropdown;
else 
{$walker = $args[2]['walker'];
}{$AspisRetTemp = AspisUntainted_call_user_func_array(array(&$walker,'walk'),$args);
return $AspisRetTemp;
} }
function the_attachment_link ( $id = 0,$fullsize = false,$deprecated = false,$permalink = false ) {
if ( $fullsize)
 echo wp_get_attachment_link($id,'full',$permalink);
else 
{echo wp_get_attachment_link($id,'thumbnail',$permalink);
} }
function wp_get_attachment_link ( $id = 0,$size = 'thumbnail',$permalink = false,$icon = false,$text = false ) {
$id = intval($id);
$_post = &get_post($id);
if ( ('attachment' != $_post->post_type) || !$url = wp_get_attachment_url($_post->ID))
 {$AspisRetTemp = __('Missing Attachment');
return $AspisRetTemp;
}if ( $permalink)
 $url = get_attachment_link($_post->ID);
$post_title = esc_attr($_post->post_title);
if ( $text)
 {$link_text = esc_attr($text);
}elseif ( (is_int($size) && $size != 0) or (is_string($size) && $size != 'none') or $size != false)
 {$link_text = wp_get_attachment_image($id,$size,$icon);
}if ( trim($link_text) == '')
 $link_text = $_post->post_title;
{$AspisRetTemp = apply_filters('wp_get_attachment_link',"<a href='$url' title='$post_title'>$link_text</a>",$id,$size,$permalink,$icon,$text);
return $AspisRetTemp;
} }
function get_the_attachment_link ( $id = 0,$fullsize = false,$max_dims = false,$permalink = false ) {
$id = (int)$id;
$_post = &get_post($id);
if ( ('attachment' != $_post->post_type) || !$url = wp_get_attachment_url($_post->ID))
 {$AspisRetTemp = __('Missing Attachment');
return $AspisRetTemp;
}if ( $permalink)
 $url = get_attachment_link($_post->ID);
$post_title = esc_attr($_post->post_title);
$innerHTML = get_attachment_innerHTML($_post->ID,$fullsize,$max_dims);
{$AspisRetTemp = "<a href='$url' title='$post_title'>$innerHTML</a>";
return $AspisRetTemp;
} }
function get_attachment_icon_src ( $id = 0,$fullsize = false ) {
$id = (int)$id;
if ( !$post = &get_post($id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$file = get_attached_file($post->ID);
if ( !$fullsize && $src = wp_get_attachment_thumb_url($post->ID))
 {$src_file = basename($src);
$class = 'attachmentthumb';
}elseif ( wp_attachment_is_image($post->ID))
 {$src = wp_get_attachment_url($post->ID);
$src_file = &$file;
$class = 'attachmentimage';
}elseif ( $src = wp_mime_type_icon($post->ID))
 {$icon_dir = apply_filters('icon_dir',get_template_directory() . '/images');
$src_file = $icon_dir . '/' . basename($src);
}if ( !isset($src) || !$src)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = array($src,$src_file);
return $AspisRetTemp;
} }
function get_attachment_icon ( $id = 0,$fullsize = false,$max_dims = false ) {
$id = (int)$id;
if ( !$post = &get_post($id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !$src = get_attachment_icon_src($post->ID,$fullsize))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}list($src,$src_file) = $src;
if ( ($max_dims = apply_filters('attachment_max_dims',$max_dims)) && file_exists($src_file))
 {$imagesize = getimagesize($src_file);
if ( ($imagesize[0] > $max_dims[0]) || $imagesize[1] > $max_dims[1])
 {$actual_aspect = $imagesize[0] / $imagesize[1];
$desired_aspect = $max_dims[0] / $max_dims[1];
if ( $actual_aspect >= $desired_aspect)
 {$height = $actual_aspect * $max_dims[0];
$constraint = "width='{$max_dims[0]}' ";
$post->iconsize = array($max_dims[0],$height);
}else 
{{$width = $max_dims[1] / $actual_aspect;
$constraint = "height='{$max_dims[1]}' ";
$post->iconsize = array($width,$max_dims[1]);
}}}else 
{{$post->iconsize = array($imagesize[0],$imagesize[1]);
$constraint = '';
}}}else 
{{$constraint = '';
}}$post_title = esc_attr($post->post_title);
$icon = "<img src='$src' title='$post_title' alt='$post_title' $constraint/>";
{$AspisRetTemp = apply_filters('attachment_icon',$icon,$post->ID);
return $AspisRetTemp;
} }
function get_attachment_innerHTML ( $id = 0,$fullsize = false,$max_dims = false ) {
$id = (int)$id;
if ( !$post = &get_post($id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( $innerHTML = get_attachment_icon($post->ID,$fullsize,$max_dims))
 {$AspisRetTemp = $innerHTML;
return $AspisRetTemp;
}$innerHTML = esc_attr($post->post_title);
{$AspisRetTemp = apply_filters('attachment_innerHTML',$innerHTML,$post->ID);
return $AspisRetTemp;
} }
function prepend_attachment ( $content ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}if ( empty($post->post_type) || $post->post_type != 'attachment')
 {$AspisRetTemp = $content;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}$p = '<p class="attachment">';
$p .= wp_get_attachment_link(0,'medium',false);
$p .= '</p>';
$p = apply_filters('prepend_attachment',$p);
{$AspisRetTemp = "$p\n$content";
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function get_the_password_form (  ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
$output = '<form action="' . get_option('siteurl') . '/wp-pass.php" method="post">
	<p>' . __("This post is password protected. To view it please enter your password below:") . '</p>
	<p><label for="' . $label . '">' . __("Password:") . ' <input name="post_password" id="' . $label . '" type="password" size="20" /></label> <input type="submit" name="Submit" value="' . esc_attr__("Submit") . '" /></p>
	</form>
	';
{$AspisRetTemp = apply_filters('the_password_form',$output);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function is_page_template ( $template = '' ) {
if ( !is_page())
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}$page = $wp_query->get_queried_object();
$custom_fields = get_post_custom_values('_wp_page_template',$page->ID);
$page_template = $custom_fields[0];
if ( empty($template))
 {if ( !empty($page_template))
 {{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}}}elseif ( $template == $page_template)
 {{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function wp_post_revision_title ( $revision,$link = true ) {
if ( !$revision = get_post($revision))
 {$AspisRetTemp = $revision;
return $AspisRetTemp;
}if ( !in_array($revision->post_type,array('post','page','revision')))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$datef = _x('j F, Y @ G:i','revision date format');
$autosavef = __('%1$s [Autosave]');
$currentf = __('%1$s [Current Revision]');
$date = date_i18n($datef,strtotime($revision->post_modified_gmt . ' +0000'));
if ( $link && current_user_can('edit_post',$revision->ID) && $link = get_edit_post_link($revision->ID))
 $date = "<a href='$link'>$date</a>";
if ( !wp_is_post_revision($revision))
 $date = sprintf($currentf,$date);
elseif ( wp_is_post_autosave($revision))
 $date = sprintf($autosavef,$date);
{$AspisRetTemp = $date;
return $AspisRetTemp;
} }
function wp_list_post_revisions ( $post_id = 0,$args = null ) {
if ( !$post = get_post($post_id))
 {return ;
}$defaults = array('parent' => false,'right' => false,'left' => false,'format' => 'list','type' => 'all');
extract((wp_parse_args($args,$defaults)),EXTR_SKIP);
switch ( $type ) {
case 'autosave':if ( !$autosave = wp_get_post_autosave($post->ID))
 {return ;
}$revisions = array($autosave);
break ;
case 'revision':case 'all':default :if ( !$revisions = wp_get_post_revisions($post->ID))
 {return ;
}break ;
 }
$titlef = _x('%1$s by %2$s','post revision');
if ( $parent)
 array_unshift($revisions,$post);
$rows = '';
$class = false;
$can_edit_post = current_user_can('edit_post',$post->ID);
foreach ( $revisions as $revision  )
{if ( !current_user_can('read_post',$revision->ID))
 continue ;
if ( 'revision' === $type && wp_is_post_autosave($revision))
 continue ;
$date = wp_post_revision_title($revision);
$name = get_the_author_meta('display_name',$revision->post_author);
if ( 'form-table' == $format)
 {if ( $left)
 $left_checked = $left == $revision->ID ? ' checked="checked"' : '';
else 
{$left_checked = $right_checked ? ' checked="checked"' : '';
}$right_checked = $right == $revision->ID ? ' checked="checked"' : '';
$class = $class ? '' : " class='alternate'";
if ( $post->ID != $revision->ID && $can_edit_post)
 $actions = '<a href="' . wp_nonce_url(add_query_arg(array('revision' => $revision->ID,'diff' => false,'action' => 'restore')),"restore-post_$post->ID|$revision->ID") . '">' . __('Restore') . '</a>';
else 
{$actions = '';
}$rows .= "<tr$class>\n";
$rows .= "\t<th style='white-space: nowrap' scope='row'><input type='radio' name='left' value='$revision->ID'$left_checked /><input type='radio' name='right' value='$revision->ID'$right_checked /></th>\n";
$rows .= "\t<td>$date</td>\n";
$rows .= "\t<td>$name</td>\n";
$rows .= "\t<td class='action-links'>$actions</td>\n";
$rows .= "</tr>\n";
}else 
{{$title = sprintf($titlef,$date,$name);
$rows .= "\t<li>$title</li>\n";
}}}if ( 'form-table' == $format)
 {;
?>

<form action="revision.php" method="get">

<div class="tablenav">
	<div class="alignleft">
		<input type="submit" class="button-secondary" value="<?php esc_attr_e('Compare Revisions');
;
?>" />
		<input type="hidden" name="action" value="diff" />
	</div>
</div>

<br class="clear" />

<table class="widefat post-revisions" cellspacing="0">
	<col />
	<col style="width: 33%" />
	<col style="width: 33%" />
	<col style="width: 33%" />
<thead>
<tr>
	<th scope="col"></th>
	<th scope="col"><?php _e('Date Created');
;
?></th>
	<th scope="col"><?php _e('Author');
;
?></th>
	<th scope="col" class="action-links"><?php _e('Actions');
;
?></th>
</tr>
</thead>
<tbody>

<?php echo $rows;
;
?>

</tbody>
</table>

</form>

<?php }else 
{echo "<ul class='post-revisions'>\n";
echo $rows;
echo "</ul>";
} }
