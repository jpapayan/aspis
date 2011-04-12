<?php require_once('AspisMain.php'); ?><?php
function get_category_link ( $category_id ) {
global $wp_rewrite;
$catlink = $wp_rewrite[0]->get_category_permastruct();
if ( ((empty($catlink) || Aspis_empty( $catlink))))
 {$file = concat2(get_option(array('home',false)),'/');
$catlink = concat(concat2($file,'?cat='),$category_id);
}else 
{{$category = &get_category($category_id);
if ( deAspis(is_wp_error($category)))
 return $category;
$category_nicename = $category[0]->slug;
if ( ($category[0]->parent[0] == $category_id[0]))
 $category[0]->parent = array(0,false);
elseif ( ($category[0]->parent[0] != (0)))
 $category_nicename = concat(get_category_parents($category[0]->parent,array(false,false),array('/',false),array(true,false)),$category_nicename);
$catlink = Aspis_str_replace(array('%category%',false),$category_nicename,$catlink);
$catlink = concat(get_option(array('home',false)),user_trailingslashit($catlink,array('category',false)));
}}return apply_filters(array('category_link',false),$catlink,$category_id);
 }
function get_category_parents ( $id,$link = array(false,false),$separator = array('/',false),$nicename = array(false,false),$visited = array(array(),false) ) {
$chain = array('',false);
$parent = &get_category($id);
if ( deAspis(is_wp_error($parent)))
 return $parent;
if ( $nicename[0])
 $name = $parent[0]->slug;
else 
{$name = $parent[0]->cat_name;
}if ( (($parent[0]->parent[0] && ($parent[0]->parent[0] != $parent[0]->term_id[0])) && (denot_boolean(Aspis_in_array($parent[0]->parent,$visited)))))
 {arrayAssignAdd($visited[0][],addTaint($parent[0]->parent));
$chain = concat($chain,get_category_parents($parent[0]->parent,$link,$separator,$nicename,$visited));
}if ( $link[0])
 $chain = concat($chain,concat(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_category_link($parent[0]->term_id)),'" title="'),esc_attr(Aspis_sprintf(__(array("View all posts in %s",false)),$parent[0]->cat_name))),'">'),$name),'</a>'),$separator));
else 
{$chain = concat($chain,concat($name,$separator));
}return $chain;
 }
function get_the_category ( $id = array(false,false) ) {
global $post;
$id = int_cast($id);
if ( (denot_boolean($id)))
 $id = int_cast($post[0]->ID);
$categories = get_object_term_cache($id,array('category',false));
if ( (false === $categories[0]))
 {$categories = wp_get_object_terms($id,array('category',false));
wp_cache_add($id,$categories,array('category_relationships',false));
}if ( (!((empty($categories) || Aspis_empty( $categories)))))
 Aspis_usort($categories,array('_usort_terms_by_name',false));
else 
{$categories = array(array(),false);
}foreach ( deAspis(array_cast(attAspisRC(array_keys(deAspisRC($categories))))) as $key  )
{_make_cat_compat(attachAspis($categories,$key[0]));
}return $categories;
 }
function _usort_terms_by_name ( $a,$b ) {
return attAspis(strcmp($a[0]->name[0],$b[0]->name[0]));
 }
function _usort_terms_by_ID ( $a,$b ) {
if ( ($a[0]->term_id[0] > $b[0]->term_id[0]))
 return array(1,false);
elseif ( ($a[0]->term_id[0] < $b[0]->term_id[0]))
 return negate(array(1,false));
else 
{return array(0,false);
} }
function get_the_category_by_ID ( $cat_ID ) {
$cat_ID = int_cast($cat_ID);
$category = &get_category($cat_ID);
if ( deAspis(is_wp_error($category)))
 return $category;
return $category[0]->name;
 }
function get_the_category_list ( $separator = array('',false),$parents = array('',false),$post_id = array(false,false) ) {
global $wp_rewrite;
$categories = get_the_category($post_id);
if ( ((empty($categories) || Aspis_empty( $categories))))
 return apply_filters(array('the_category',false),__(array('Uncategorized',false)),$separator,$parents);
$rel = (is_object($wp_rewrite[0]) && deAspis($wp_rewrite[0]->using_permalinks())) ? array('rel="category tag"',false) : array('rel="category"',false);
$thelist = array('',false);
if ( (('') == $separator[0]))
 {$thelist = concat2($thelist,'<ul class="post-categories">');
foreach ( $categories[0] as $category  )
{$thelist = concat2($thelist,"\n\t<li>");
switch ( deAspis(Aspis_strtolower($parents)) ) {
case ('multiple'):if ( $category[0]->parent[0])
 $thelist = concat($thelist,get_category_parents($category[0]->parent,array(true,false),$separator));
$thelist = concat($thelist,concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_category_link($category[0]->term_id)),'" title="'),esc_attr(Aspis_sprintf(__(array("View all posts in %s",false)),$category[0]->name))),'" '),$rel),'>'),$category[0]->name),'</a></li>'));
break ;
case ('single'):$thelist = concat($thelist,concat2(concat(concat2(concat(concat2(concat1('<a href="',get_category_link($category[0]->term_id)),'" title="'),esc_attr(Aspis_sprintf(__(array("View all posts in %s",false)),$category[0]->name))),'" '),$rel),'>'));
if ( $category[0]->parent[0])
 $thelist = concat($thelist,get_category_parents($category[0]->parent,array(false,false),$separator));
$thelist = concat($thelist,concat2($category[0]->name,'</a></li>'));
break ;
case (''):default :$thelist = concat($thelist,concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_category_link($category[0]->term_id)),'" title="'),esc_attr(Aspis_sprintf(__(array("View all posts in %s",false)),$category[0]->name))),'" '),$rel),'>'),$category[0]->cat_name),'</a></li>'));
 }
}$thelist = concat2($thelist,'</ul>');
}else 
{{$i = array(0,false);
foreach ( $categories[0] as $category  )
{if ( ((0) < $i[0]))
 $thelist = concat($thelist,concat2($separator,' '));
switch ( deAspis(Aspis_strtolower($parents)) ) {
case ('multiple'):if ( $category[0]->parent[0])
 $thelist = concat($thelist,get_category_parents($category[0]->parent,array(true,false),$separator));
$thelist = concat($thelist,concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_category_link($category[0]->term_id)),'" title="'),esc_attr(Aspis_sprintf(__(array("View all posts in %s",false)),$category[0]->name))),'" '),$rel),'>'),$category[0]->cat_name),'</a>'));
break ;
case ('single'):$thelist = concat($thelist,concat2(concat(concat2(concat(concat2(concat1('<a href="',get_category_link($category[0]->term_id)),'" title="'),esc_attr(Aspis_sprintf(__(array("View all posts in %s",false)),$category[0]->name))),'" '),$rel),'>'));
if ( $category[0]->parent[0])
 $thelist = concat($thelist,get_category_parents($category[0]->parent,array(false,false),$separator));
$thelist = concat($thelist,concat2($category[0]->cat_name,"</a>"));
break ;
case (''):default :$thelist = concat($thelist,concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_category_link($category[0]->term_id)),'" title="'),esc_attr(Aspis_sprintf(__(array("View all posts in %s",false)),$category[0]->name))),'" '),$rel),'>'),$category[0]->name),'</a>'));
 }
preincr($i);
}}}return apply_filters(array('the_category',false),$thelist,$separator,$parents);
 }
function in_category ( $category,$_post = array(null,false) ) {
if ( ((empty($category) || Aspis_empty( $category))))
 return array(false,false);
if ( $_post[0])
 {$_post = get_post($_post);
}else 
{{$_post = &$GLOBALS[0][('post')];
}}if ( (denot_boolean($_post)))
 return array(false,false);
$r = is_object_in_term($_post[0]->ID,array('category',false),$category);
if ( deAspis(is_wp_error($r)))
 return array(false,false);
return $r;
 }
function the_category ( $separator = array('',false),$parents = array('',false),$post_id = array(false,false) ) {
echo AspisCheckPrint(get_the_category_list($separator,$parents,$post_id));
 }
function category_description ( $category = array(0,false) ) {
return term_description($category,array('category',false));
 }
function wp_dropdown_categories ( $args = array('',false) ) {
$defaults = array(array('show_option_all' => array('',false,false),'show_option_none' => array('',false,false),'orderby' => array('id',false,false),'order' => array('ASC',false,false),'show_last_update' => array(0,false,false),'show_count' => array(0,false,false),'hide_empty' => array(1,false,false),'child_of' => array(0,false,false),'exclude' => array('',false,false),'echo' => array(1,false,false),'selected' => array(0,false,false),'hierarchical' => array(0,false,false),'name' => array('cat',false,false),'class' => array('postform',false,false),'depth' => array(0,false,false),'tab_index' => array(0,false,false)),false);
arrayAssign($defaults[0],deAspis(registerTaint(array('selected',false))),addTaint(deAspis((is_category())) ? get_query_var(array('cat',false)) : array(0,false)));
$r = wp_parse_args($args,$defaults);
if ( (((!((isset($r[0][('pad_counts')]) && Aspis_isset( $r [0][('pad_counts')])))) && deAspis($r[0]['show_count'])) && deAspis($r[0]['hierarchical'])))
 {arrayAssign($r[0],deAspis(registerTaint(array('pad_counts',false))),addTaint(array(true,false)));
}arrayAssign($r[0],deAspis(registerTaint(array('include_last_update_time',false))),addTaint($r[0]['show_last_update']));
extract(($r[0]));
$tab_index_attribute = array('',false);
if ( (deAspis(int_cast($tab_index)) > (0)))
 $tab_index_attribute = concat2(concat1(" tabindex=\"",$tab_index),"\"");
$categories = get_categories($r);
$name = esc_attr($name);
$class = esc_attr($class);
$output = array('',false);
if ( (!((empty($categories) || Aspis_empty( $categories)))))
 {$output = concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<select name='",$name),"' id='"),$name),"' class='"),$class),"' "),$tab_index_attribute),">\n");
if ( $show_option_all[0])
 {$show_option_all = apply_filters(array('list_cats',false),$show_option_all);
$selected = (('0') === deAspis(Aspis_strval($r[0]['selected']))) ? array(" selected='selected'",false) : array('',false);
$output = concat($output,concat2(concat(concat2(concat1("\t<option value='0'",$selected),">"),$show_option_all),"</option>\n"));
}if ( $show_option_none[0])
 {$show_option_none = apply_filters(array('list_cats',false),$show_option_none);
$selected = (('-1') === deAspis(Aspis_strval($r[0]['selected']))) ? array(" selected='selected'",false) : array('',false);
$output = concat($output,concat2(concat(concat2(concat1("\t<option value='-1'",$selected),">"),$show_option_none),"</option>\n"));
}if ( $hierarchical[0])
 $depth = $r[0]['depth'];
else 
{$depth = negate(array(1,false));
}$output = concat($output,walk_category_dropdown_tree($categories,$depth,$r));
$output = concat2($output,"</select>\n");
}$output = apply_filters(array('wp_dropdown_cats',false),$output);
if ( $echo[0])
 echo AspisCheckPrint($output);
return $output;
 }
function wp_list_categories ( $args = array('',false) ) {
$defaults = array(array('show_option_all' => array('',false,false),'orderby' => array('name',false,false),'order' => array('ASC',false,false),'show_last_update' => array(0,false,false),'style' => array('list',false,false),'show_count' => array(0,false,false),'hide_empty' => array(1,false,false),'use_desc_for_title' => array(1,false,false),'child_of' => array(0,false,false),'feed' => array('',false,false),'feed_type' => array('',false,false),'feed_image' => array('',false,false),'exclude' => array('',false,false),'exclude_tree' => array('',false,false),'current_category' => array(0,false,false),'hierarchical' => array(true,false,false),deregisterTaint(array('title_li',false)) => addTaint(__(array('Categories',false))),'echo' => array(1,false,false),'depth' => array(0,false,false)),false);
$r = wp_parse_args($args,$defaults);
if ( (((!((isset($r[0][('pad_counts')]) && Aspis_isset( $r [0][('pad_counts')])))) && deAspis($r[0]['show_count'])) && deAspis($r[0]['hierarchical'])))
 {arrayAssign($r[0],deAspis(registerTaint(array('pad_counts',false))),addTaint(array(true,false)));
}if ( ((isset($r[0][('show_date')]) && Aspis_isset( $r [0][('show_date')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('include_last_update_time',false))),addTaint($r[0]['show_date']));
}if ( (true == deAspis($r[0]['hierarchical'])))
 {arrayAssign($r[0],deAspis(registerTaint(array('exclude_tree',false))),addTaint($r[0]['exclude']));
arrayAssign($r[0],deAspis(registerTaint(array('exclude',false))),addTaint(array('',false)));
}extract(($r[0]));
$categories = get_categories($r);
$output = array('',false);
if ( ($title_li[0] && (('list') == $style[0])))
 $output = concat2(concat1('<li class="categories">',$r[0]['title_li']),'<ul>');
if ( ((empty($categories) || Aspis_empty( $categories))))
 {if ( (('list') == $style[0]))
 $output = concat($output,concat2(concat1('<li>',__(array("No categories",false))),'</li>'));
else 
{$output = concat($output,__(array("No categories",false)));
}}else 
{{global $wp_query;
if ( (!((empty($show_option_all) || Aspis_empty( $show_option_all)))))
 if ( (('list') == $style[0]))
 $output = concat($output,concat2(concat(concat2(concat1('<li><a href="',get_bloginfo(array('url',false))),'">'),$show_option_all),'</a></li>'));
else 
{$output = concat($output,concat2(concat(concat2(concat1('<a href="',get_bloginfo(array('url',false))),'">'),$show_option_all),'</a>'));
}if ( (((empty($r[0][('current_category')]) || Aspis_empty( $r [0][('current_category')]))) && deAspis(is_category())))
 arrayAssign($r[0],deAspis(registerTaint(array('current_category',false))),addTaint($wp_query[0]->get_queried_object_id()));
if ( $hierarchical[0])
 $depth = $r[0]['depth'];
else 
{$depth = negate(array(1,false));
}$output = concat($output,walk_category_tree($categories,$depth,$r));
}}if ( ($title_li[0] && (('list') == $style[0])))
 $output = concat2($output,'</ul></li>');
$output = apply_filters(array('wp_list_categories',false),$output);
if ( $echo[0])
 echo AspisCheckPrint($output);
else 
{return $output;
} }
function wp_tag_cloud ( $args = array('',false) ) {
$defaults = array(array('smallest' => array(8,false,false),'largest' => array(22,false,false),'unit' => array('pt',false,false),'number' => array(45,false,false),'format' => array('flat',false,false),'separator' => array("\n",false,false),'orderby' => array('name',false,false),'order' => array('ASC',false,false),'exclude' => array('',false,false),'include' => array('',false,false),'link' => array('view',false,false),'taxonomy' => array('post_tag',false,false),'echo' => array(true,false,false)),false);
$args = wp_parse_args($args,$defaults);
$tags = get_terms($args[0]['taxonomy'],Aspis_array_merge($args,array(array('orderby' => array('count',false,false),'order' => array('DESC',false,false)),false)));
if ( ((empty($tags) || Aspis_empty( $tags))))
 return ;
foreach ( $tags[0] as $key =>$tag )
{restoreTaint($key,$tag);
{if ( (('edit') == deAspis($args[0]['link'])))
 $link = get_edit_tag_link($tag[0]->term_id,$args[0]['taxonomy']);
else 
{$link = get_term_link(Aspis_intval($tag[0]->term_id),$args[0]['taxonomy']);
}if ( deAspis(is_wp_error($link)))
 return array(false,false);
$tags[0][$key[0]][0]->link = $link;
$tags[0][$key[0]][0]->id = $tag[0]->term_id;
}}$return = wp_generate_tag_cloud($tags,$args);
$return = apply_filters(array('wp_tag_cloud',false),$return,$args);
if ( ((('array') == deAspis($args[0]['format'])) || ((empty($args[0][('echo')]) || Aspis_empty( $args [0][('echo')])))))
 return $return;
echo AspisCheckPrint($return);
 }
function default_topic_count_text ( $count ) {
return Aspis_sprintf(_n(array('%s topic',false),array('%s topics',false),$count),number_format_i18n($count));
 }
function default_topic_count_scale ( $count ) {
return attAspis(round((log10(($count[0] + (1))) * (100))));
 }
function wp_generate_tag_cloud ( $tags,$args = array('',false) ) {
global $wp_rewrite;
$defaults = array(array('smallest' => array(8,false,false),'largest' => array(22,false,false),'unit' => array('pt',false,false),'number' => array(0,false,false),'format' => array('flat',false,false),'separator' => array("\n",false,false),'orderby' => array('name',false,false),'order' => array('ASC',false,false),'topic_count_text_callback' => array('default_topic_count_text',false,false),'topic_count_scale_callback' => array('default_topic_count_scale',false,false),'filter' => array(1,false,false),),false);
if ( (((!((isset($args[0][('topic_count_text_callback')]) && Aspis_isset( $args [0][('topic_count_text_callback')])))) && ((isset($args[0][('single_text')]) && Aspis_isset( $args [0][('single_text')])))) && ((isset($args[0][('multiple_text')]) && Aspis_isset( $args [0][('multiple_text')])))))
 {$body = concat2(concat(concat2(concat1('return sprintf (
			_n(',Aspis_var_export($args[0]['single_text'],array(true,false))),', '),Aspis_var_export($args[0]['multiple_text'],array(true,false))),', $count),
			number_format_i18n( $count ));');
arrayAssign($args[0],deAspis(registerTaint(array('topic_count_text_callback',false))),addTaint(Aspis_create_function(array('$count',false),$body)));
}$args = wp_parse_args($args,$defaults);
extract(($args[0]));
if ( ((empty($tags) || Aspis_empty( $tags))))
 return ;
$tags_sorted = apply_filters(array('tag_cloud_sort',false),$tags,$args);
if ( ($tags_sorted[0] != $tags[0]))
 {$tags = $tags_sorted;
unset($tags_sorted);
}else 
{{if ( (('RAND') == $order[0]))
 {Aspis_shuffle($tags);
}else 
{{if ( (('name') == $orderby[0]))
 AspisInternalFunctionCall("uasort",AspisPushRefParam($tags),AspisInternalCallback(Aspis_create_function(array('$a, $b',false),array('return strnatcasecmp($a->name, $b->name);',false))),array(0));
else 
{AspisInternalFunctionCall("uasort",AspisPushRefParam($tags),AspisInternalCallback(Aspis_create_function(array('$a, $b',false),array('return ($a->count > $b->count);',false))),array(0));
}if ( (('DESC') == $order[0]))
 $tags = Aspis_array_reverse($tags,array(true,false));
}}}}if ( ($number[0] > (0)))
 $tags = Aspis_array_slice($tags,array(0,false),$number);
$counts = array(array(),false);
$real_counts = array(array(),false);
foreach ( deAspis(array_cast($tags)) as $key =>$tag )
{restoreTaint($key,$tag);
{arrayAssign($real_counts[0],deAspis(registerTaint($key)),addTaint($tag[0]->count));
arrayAssign($counts[0],deAspis(registerTaint($key)),addTaint(AspisDynamicCall($topic_count_scale_callback,$tag[0]->count)));
}}$min_count = attAspisRC(min(deAspisRC($counts)));
$spread = array(deAspis(attAspisRC(max(deAspisRC($counts)))) - $min_count[0],false);
if ( ($spread[0] <= (0)))
 $spread = array(1,false);
$font_spread = array($largest[0] - $smallest[0],false);
if ( ($font_spread[0] < (0)))
 $font_spread = array(1,false);
$font_step = array($font_spread[0] / $spread[0],false);
$a = array(array(),false);
foreach ( $tags[0] as $key =>$tag )
{restoreTaint($key,$tag);
{$count = attachAspis($counts,$key[0]);
$real_count = attachAspis($real_counts,$key[0]);
$tag_link = (('#') != $tag[0]->link[0]) ? esc_url($tag[0]->link) : array('#',false);
$tag_id = ((isset($tags[0][$key[0]][0]->id) && Aspis_isset( $tags [0][$key[0]][0] ->id ))) ? $tags[0][$key[0]][0]->id : $key;
$tag_name = $tags[0][$key[0]][0]->name;
arrayAssignAdd($a[0][],addTaint(concat(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$tag_link),"' class='tag-link-"),$tag_id),"' title='"),esc_attr(AspisDynamicCall($topic_count_text_callback,$real_count))),"' style='font-size: "),(array($smallest[0] + (($count[0] - $min_count[0]) * $font_step[0]),false))),concat2(concat(concat2($unit,";'>"),$tag_name),"</a>"))));
}}switch ( $format[0] ) {
case ('array'):$return = &$a;
break ;
;
case ('list'):$return = array("<ul class='wp-tag-cloud'>\n\t<li>",false);
$return = concat($return,Aspis_join(array("</li>\n\t<li>",false),$a));
$return = concat2($return,"</li>\n</ul>\n");
break ;
default :$return = Aspis_join($separator,$a);
break ;
 }
if ( $filter[0])
 return apply_filters(array('wp_generate_tag_cloud',false),$return,$tags,$args);
else 
{return $return;
} }
function walk_category_tree (  ) {
$args = array(func_get_args(),false);
if ( (((empty($args[0][(2)][0][('walker')]) || Aspis_empty( $args [0][(2)] [0][('walker')]))) || (!(is_a(deAspisRC($args[0][(2)][0]['walker']),('Walker'))))))
 $walker = array(new Walker_Category,false);
else 
{$walker = $args[0][(2)][0]['walker'];
}return Aspis_call_user_func_array(array(array(&$walker,array('walk',false)),false),$args);
 }
function walk_category_dropdown_tree (  ) {
$args = array(func_get_args(),false);
if ( (((empty($args[0][(2)][0][('walker')]) || Aspis_empty( $args [0][(2)] [0][('walker')]))) || (!(is_a(deAspisRC($args[0][(2)][0]['walker']),('Walker'))))))
 $walker = array(new Walker_CategoryDropdown,false);
else 
{$walker = $args[0][(2)][0]['walker'];
}return Aspis_call_user_func_array(array(array(&$walker,array('walk',false)),false),$args);
 }
function get_tag_link ( $tag_id ) {
global $wp_rewrite;
$taglink = $wp_rewrite[0]->get_tag_permastruct();
$tag = &get_term($tag_id,array('post_tag',false));
if ( deAspis(is_wp_error($tag)))
 return $tag;
$slug = $tag[0]->slug;
if ( ((empty($taglink) || Aspis_empty( $taglink))))
 {$file = concat2(get_option(array('home',false)),'/');
$taglink = concat(concat2($file,'?tag='),$slug);
}else 
{{$taglink = Aspis_str_replace(array('%tag%',false),$slug,$taglink);
$taglink = concat(get_option(array('home',false)),user_trailingslashit($taglink,array('category',false)));
}}return apply_filters(array('tag_link',false),$taglink,$tag_id);
 }
function get_the_tags ( $id = array(0,false) ) {
return apply_filters(array('get_the_tags',false),get_the_terms($id,array('post_tag',false)));
 }
function get_the_tag_list ( $before = array('',false),$sep = array('',false),$after = array('',false) ) {
return apply_filters(array('the_tags',false),get_the_term_list(array(0,false),array('post_tag',false),$before,$sep,$after),$before,$sep,$after);
 }
function the_tags ( $before = array(null,false),$sep = array(', ',false),$after = array('',false) ) {
if ( (null === $before[0]))
 $before = __(array('Tags: ',false));
echo AspisCheckPrint(get_the_tag_list($before,$sep,$after));
 }
function tag_description ( $tag = array(0,false) ) {
return term_description($tag);
 }
function term_description ( $term = array(0,false),$taxonomy = array('post_tag',false) ) {
if ( ((denot_boolean($term)) && ((deAspis(is_tax()) || deAspis(is_tag())) || deAspis(is_category()))))
 {global $wp_query;
$term = $wp_query[0]->get_queried_object();
$taxonomy = $term[0]->taxonomy;
$term = $term[0]->term_id;
}return get_term_field(array('description',false),$term,$taxonomy);
 }
function get_the_terms ( $id = array(0,false),$taxonomy ) {
global $post;
$id = int_cast($id);
if ( (denot_boolean($id)))
 {if ( (denot_boolean($post[0]->ID)))
 return array(false,false);
else 
{$id = int_cast($post[0]->ID);
}}$terms = get_object_term_cache($id,$taxonomy);
if ( (false === $terms[0]))
 $terms = wp_get_object_terms($id,$taxonomy);
if ( ((empty($terms) || Aspis_empty( $terms))))
 return array(false,false);
return $terms;
 }
function get_the_term_list ( $id = array(0,false),$taxonomy,$before = array('',false),$sep = array('',false),$after = array('',false) ) {
$terms = get_the_terms($id,$taxonomy);
if ( deAspis(is_wp_error($terms)))
 return $terms;
if ( ((empty($terms) || Aspis_empty( $terms))))
 return array(false,false);
foreach ( $terms[0] as $term  )
{$link = get_term_link($term,$taxonomy);
if ( deAspis(is_wp_error($link)))
 return $link;
arrayAssignAdd($term_links[0][],addTaint(concat2(concat(concat2(concat1('<a href="',$link),'" rel="tag">'),$term[0]->name),'</a>')));
}$term_links = apply_filters(concat1("term_links-",$taxonomy),$term_links);
return concat(concat($before,Aspis_join($sep,$term_links)),$after);
 }
function the_terms ( $id,$taxonomy,$before = array('',false),$sep = array(', ',false),$after = array('',false) ) {
$term_list = get_the_term_list($id,$taxonomy,$before,$sep,$after);
if ( deAspis(is_wp_error($term_list)))
 return array(false,false);
echo AspisCheckPrint(apply_filters(array('the_terms',false),$term_list,$taxonomy,$before,$sep,$after));
 }
function has_tag ( $tag = array('',false),$_post = array(null,false) ) {
if ( $_post[0])
 {$_post = get_post($_post);
}else 
{{$_post = &$GLOBALS[0][('post')];
}}if ( (denot_boolean($_post)))
 return array(false,false);
$r = is_object_in_term($_post[0]->ID,array('post_tag',false),$tag);
if ( deAspis(is_wp_error($r)))
 return array(false,false);
return $r;
 }
;
?>
<?php 