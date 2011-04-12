<?php require_once('AspisMain.php'); ?><?php
function the_ID (  ) {
global $id;
echo AspisCheckPrint($id);
 }
function get_the_ID (  ) {
global $id;
return $id;
 }
function the_title ( $before = array('',false),$after = array('',false),$echo = array(true,false) ) {
$title = get_the_title();
if ( (strlen($title[0]) == (0)))
 return ;
$title = concat(concat($before,$title),$after);
if ( $echo[0])
 echo AspisCheckPrint($title);
else 
{return $title;
} }
function the_title_attribute ( $args = array('',false) ) {
$title = get_the_title();
if ( (strlen($title[0]) == (0)))
 return ;
$defaults = array(array('before' => array('',false,false),'after' => array('',false,false),'echo' => array(true,false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
$title = concat(concat($before,$title),$after);
$title = esc_attr(Aspis_strip_tags($title));
if ( $echo[0])
 echo AspisCheckPrint($title);
else 
{return $title;
} }
function get_the_title ( $id = array(0,false) ) {
$post = &get_post($id);
$title = $post[0]->post_title;
if ( (denot_boolean(is_admin())))
 {if ( (!((empty($post[0]->post_password) || Aspis_empty( $post[0] ->post_password )))))
 {$protected_title_format = apply_filters(array('protected_title_format',false),__(array('Protected: %s',false)));
$title = Aspis_sprintf($protected_title_format,$title);
}else 
{if ( (((isset($post[0]->post_status) && Aspis_isset( $post[0] ->post_status ))) && (('private') == $post[0]->post_status[0])))
 {$private_title_format = apply_filters(array('private_title_format',false),__(array('Private: %s',false)));
$title = Aspis_sprintf($private_title_format,$title);
}}}return apply_filters(array('the_title',false),$title,$post[0]->ID);
 }
function the_guid ( $id = array(0,false) ) {
echo AspisCheckPrint(get_the_guid($id));
 }
function get_the_guid ( $id = array(0,false) ) {
$post = &get_post($id);
return apply_filters(array('get_the_guid',false),$post[0]->guid);
 }
function the_content ( $more_link_text = array(null,false),$stripteaser = array(0,false) ) {
$content = get_the_content($more_link_text,$stripteaser);
$content = apply_filters(array('the_content',false),$content);
$content = Aspis_str_replace(array(']]>',false),array(']]&gt;',false),$content);
echo AspisCheckPrint($content);
 }
function get_the_content ( $more_link_text = array(null,false),$stripteaser = array(0,false) ) {
global $id,$post,$more,$page,$pages,$multipage,$preview,$pagenow;
if ( (null === $more_link_text[0]))
 $more_link_text = __(array('(more...)',false));
$output = array('',false);
$hasTeaser = array(false,false);
if ( deAspis(post_password_required($post)))
 {$output = get_the_password_form();
return $output;
}if ( ($page[0] > count($pages[0])))
 $page = attAspis(count($pages[0]));
$content = attachAspis($pages,($page[0] - (1)));
if ( deAspis(Aspis_preg_match(array('/<!--more(.*?)?-->/',false),$content,$matches)))
 {$content = Aspis_explode(attachAspis($matches,(0)),$content,array(2,false));
if ( ((!((empty($matches[0][(1)]) || Aspis_empty( $matches [0][(1)])))) && (!((empty($more_link_text) || Aspis_empty( $more_link_text))))))
 $more_link_text = Aspis_strip_tags(wp_kses_no_null(Aspis_trim(attachAspis($matches,(1)))));
$hasTeaser = array(true,false);
}else 
{{$content = array(array($content),false);
}}if ( ((false !== strpos($post[0]->post_content[0],'<!--noteaser-->')) && ((denot_boolean($multipage)) || ($page[0] == (1)))))
 $stripteaser = array(1,false);
$teaser = attachAspis($content,(0));
if ( ((deAspis(($more)) && deAspis(($stripteaser))) && deAspis(($hasTeaser))))
 $teaser = array('',false);
$output = concat($output,$teaser);
if ( (count($content[0]) > (1)))
 {if ( $more[0])
 {$output = concat($output,concat(concat2(concat1('<span id="more-',$id),'"></span>'),attachAspis($content,(1))));
}else 
{{if ( (!((empty($more_link_text) || Aspis_empty( $more_link_text)))))
 $output = concat($output,apply_filters(array('the_content_more_link',false),concat(concat1(' <a href="',get_permalink()),concat2(concat(concat2(concat1("#more-",$id),"\" class=\"more-link\">"),$more_link_text),"</a>")),$more_link_text));
$output = force_balance_tags($output);
}}}if ( $preview[0])
 $output = Aspis_preg_replace_callback(array('/\%u([0-9A-F]{4})/',false),Aspis_create_function(array('$match',false),array('return "&#" . base_convert($match[1], 16, 10) . ";";',false)),$output);
return $output;
 }
function the_excerpt (  ) {
echo AspisCheckPrint(apply_filters(array('the_excerpt',false),get_the_excerpt()));
 }
function get_the_excerpt ( $deprecated = array('',false) ) {
global $post;
$output = $post[0]->post_excerpt;
if ( deAspis(post_password_required($post)))
 {$output = __(array('There is no excerpt because this is a protected post.',false));
return $output;
}return apply_filters(array('get_the_excerpt',false),$output);
 }
function has_excerpt ( $id = array(0,false) ) {
$post = &get_post($id);
return (not_boolean(array((empty($post[0]->post_excerpt) || Aspis_empty( $post[0] ->post_excerpt )),false)));
 }
function post_class ( $class = array('',false),$post_id = array(null,false) ) {
echo AspisCheckPrint(concat2(concat1('class="',Aspis_join(array(' ',false),get_post_class($class,$post_id))),'"'));
 }
function get_post_class ( $class = array('',false),$post_id = array(null,false) ) {
$post = get_post($post_id);
$classes = array(array(),false);
if ( ((empty($post) || Aspis_empty( $post))))
 return $classes;
arrayAssignAdd($classes[0][],addTaint(concat1('post-',$post[0]->ID)));
arrayAssignAdd($classes[0][],addTaint($post[0]->post_type));
if ( (deAspis(is_sticky($post[0]->ID)) && deAspis(is_home())))
 arrayAssignAdd($classes[0][],addTaint(array('sticky',false)));
arrayAssignAdd($classes[0][],addTaint(array('hentry',false)));
foreach ( deAspis(array_cast(get_the_category($post[0]->ID))) as $cat  )
{if ( ((empty($cat[0]->slug) || Aspis_empty( $cat[0] ->slug ))))
 continue ;
arrayAssignAdd($classes[0][],addTaint(concat1('category-',sanitize_html_class($cat[0]->slug,$cat[0]->cat_ID))));
}foreach ( deAspis(array_cast(get_the_tags($post[0]->ID))) as $tag  )
{if ( ((empty($tag[0]->slug) || Aspis_empty( $tag[0] ->slug ))))
 continue ;
arrayAssignAdd($classes[0][],addTaint(concat1('tag-',sanitize_html_class($tag[0]->slug,$tag[0]->term_id))));
}if ( (!((empty($class) || Aspis_empty( $class)))))
 {if ( (!(is_array($class[0]))))
 $class = Aspis_preg_split(array('#\s+#',false),$class);
$classes = Aspis_array_merge($classes,$class);
}$classes = attAspisRC(array_map(AspisInternalCallback(array('esc_attr',false)),deAspisRC($classes)));
return apply_filters(array('post_class',false),$classes,$class,$post_id);
 }
function body_class ( $class = array('',false) ) {
echo AspisCheckPrint(concat2(concat1('class="',Aspis_join(array(' ',false),get_body_class($class))),'"'));
 }
function get_body_class ( $class = array('',false) ) {
global $wp_query,$wpdb,$current_user;
$classes = array(array(),false);
if ( (('rtl') == deAspis(get_bloginfo(array('text_direction',false)))))
 arrayAssignAdd($classes[0][],addTaint(array('rtl',false)));
if ( deAspis(is_front_page()))
 arrayAssignAdd($classes[0][],addTaint(array('home',false)));
if ( deAspis(is_home()))
 arrayAssignAdd($classes[0][],addTaint(array('blog',false)));
if ( deAspis(is_archive()))
 arrayAssignAdd($classes[0][],addTaint(array('archive',false)));
if ( deAspis(is_date()))
 arrayAssignAdd($classes[0][],addTaint(array('date',false)));
if ( deAspis(is_search()))
 arrayAssignAdd($classes[0][],addTaint(array('search',false)));
if ( deAspis(is_paged()))
 arrayAssignAdd($classes[0][],addTaint(array('paged',false)));
if ( deAspis(is_attachment()))
 arrayAssignAdd($classes[0][],addTaint(array('attachment',false)));
if ( deAspis(is_404()))
 arrayAssignAdd($classes[0][],addTaint(array('error404',false)));
if ( deAspis(is_single()))
 {$wp_query[0]->post = $wp_query[0]->posts[0][(0)];
setup_postdata($wp_query[0]->post);
$postID = $wp_query[0]->post[0]->ID;
arrayAssignAdd($classes[0][],addTaint(concat1('single postid-',$postID)));
if ( deAspis(is_attachment()))
 {$mime_type = get_post_mime_type();
$mime_prefix = array(array(array('application/',false),array('image/',false),array('text/',false),array('audio/',false),array('video/',false),array('music/',false)),false);
arrayAssignAdd($classes[0][],addTaint(concat1('attachmentid-',$postID)));
arrayAssignAdd($classes[0][],addTaint(concat1('attachment-',Aspis_str_replace($mime_prefix,array('',false),$mime_type))));
}}elseif ( deAspis(is_archive()))
 {if ( deAspis(is_author()))
 {$author = $wp_query[0]->get_queried_object();
arrayAssignAdd($classes[0][],addTaint(array('author',false)));
arrayAssignAdd($classes[0][],addTaint(concat1('author-',sanitize_html_class($author[0]->user_nicename,$author[0]->ID))));
}elseif ( deAspis(is_category()))
 {$cat = $wp_query[0]->get_queried_object();
arrayAssignAdd($classes[0][],addTaint(array('category',false)));
arrayAssignAdd($classes[0][],addTaint(concat1('category-',sanitize_html_class($cat[0]->slug,$cat[0]->cat_ID))));
}elseif ( deAspis(is_tag()))
 {$tags = $wp_query[0]->get_queried_object();
arrayAssignAdd($classes[0][],addTaint(array('tag',false)));
arrayAssignAdd($classes[0][],addTaint(concat1('tag-',sanitize_html_class($tags[0]->slug,$tags[0]->term_id))));
}}elseif ( deAspis(is_page()))
 {arrayAssignAdd($classes[0][],addTaint(array('page',false)));
$wp_query[0]->post = $wp_query[0]->posts[0][(0)];
setup_postdata($wp_query[0]->post);
$pageID = $wp_query[0]->post[0]->ID;
arrayAssignAdd($classes[0][],addTaint(concat1('page-id-',$pageID)));
if ( deAspis($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_parent = %d AND post_type = 'page' LIMIT 1"),$pageID))))
 arrayAssignAdd($classes[0][],addTaint(array('page-parent',false)));
if ( $wp_query[0]->post[0]->post_parent[0])
 {arrayAssignAdd($classes[0][],addTaint(array('page-child',false)));
arrayAssignAdd($classes[0][],addTaint(concat1('parent-pageid-',$wp_query[0]->post[0]->post_parent)));
}if ( deAspis(is_page_template()))
 {arrayAssignAdd($classes[0][],addTaint(array('page-template',false)));
arrayAssignAdd($classes[0][],addTaint(concat1('page-template-',Aspis_str_replace(array('.php',false),array('-php',false),get_post_meta($pageID,array('_wp_page_template',false),array(true,false))))));
}}elseif ( deAspis(is_search()))
 {if ( (!((empty($wp_query[0]->posts) || Aspis_empty( $wp_query[0] ->posts )))))
 arrayAssignAdd($classes[0][],addTaint(array('search-results',false)));
else 
{arrayAssignAdd($classes[0][],addTaint(array('search-no-results',false)));
}}if ( deAspis(is_user_logged_in()))
 arrayAssignAdd($classes[0][],addTaint(array('logged-in',false)));
$page = $wp_query[0]->get(array('page',false));
if ( ((denot_boolean($page)) || ($page[0] < (2))))
 $page = $wp_query[0]->get(array('paged',false));
if ( ($page[0] && ($page[0] > (1))))
 {arrayAssignAdd($classes[0][],addTaint(concat1('paged-',$page)));
if ( deAspis(is_single()))
 arrayAssignAdd($classes[0][],addTaint(concat1('single-paged-',$page)));
elseif ( deAspis(is_page()))
 arrayAssignAdd($classes[0][],addTaint(concat1('page-paged-',$page)));
elseif ( deAspis(is_category()))
 arrayAssignAdd($classes[0][],addTaint(concat1('category-paged-',$page)));
elseif ( deAspis(is_tag()))
 arrayAssignAdd($classes[0][],addTaint(concat1('tag-paged-',$page)));
elseif ( deAspis(is_date()))
 arrayAssignAdd($classes[0][],addTaint(concat1('date-paged-',$page)));
elseif ( deAspis(is_author()))
 arrayAssignAdd($classes[0][],addTaint(concat1('author-paged-',$page)));
elseif ( deAspis(is_search()))
 arrayAssignAdd($classes[0][],addTaint(concat1('search-paged-',$page)));
}if ( (!((empty($class) || Aspis_empty( $class)))))
 {if ( (!(is_array($class[0]))))
 $class = Aspis_preg_split(array('#\s+#',false),$class);
$classes = Aspis_array_merge($classes,$class);
}$classes = attAspisRC(array_map(AspisInternalCallback(array('esc_attr',false)),deAspisRC($classes)));
return apply_filters(array('body_class',false),$classes,$class);
 }
function post_password_required ( $post = array(null,false) ) {
$post = get_post($post);
if ( ((empty($post[0]->post_password) || Aspis_empty( $post[0] ->post_password ))))
 return array(false,false);
if ( (!((isset($_COOKIE[0][(deconcat12('wp-postpass_',COOKIEHASH))]) && Aspis_isset( $_COOKIE [0][(deconcat12('wp-postpass_',COOKIEHASH))])))))
 return array(true,false);
if ( (deAspis(attachAspis($_COOKIE,(deconcat12('wp-postpass_',COOKIEHASH)))) != $post[0]->post_password[0]))
 return array(true,false);
return array(false,false);
 }
function sticky_class ( $post_id = array(null,false) ) {
if ( (denot_boolean(is_sticky($post_id))))
 return ;
echo AspisCheckPrint(array(" sticky",false));
 }
function wp_link_pages ( $args = array('',false) ) {
$defaults = array(array(deregisterTaint(array('before',false)) => addTaint(concat1('<p>',__(array('Pages:',false)))),'after' => array('</p>',false,false),'link_before' => array('',false,false),'link_after' => array('',false,false),'next_or_number' => array('number',false,false),deregisterTaint(array('nextpagelink',false)) => addTaint(__(array('Next page',false))),deregisterTaint(array('previouspagelink',false)) => addTaint(__(array('Previous page',false))),'pagelink' => array('%',false,false),'echo' => array(1,false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
global $post,$page,$numpages,$multipage,$more,$pagenow;
$output = array('',false);
if ( $multipage[0])
 {if ( (('number') == $next_or_number[0]))
 {$output = concat($output,$before);
for ( $i = array(1,false) ; ($i[0] < ($numpages[0] + (1))) ; $i = array($i[0] + (1),false) )
{$j = Aspis_str_replace(array('%',false),$i,$pagelink);
$output = concat2($output,' ');
if ( (($i[0] != $page[0]) || ((denot_boolean($more)) && ($page[0] == (1)))))
 {if ( ((1) == $i[0]))
 {$output = concat($output,concat2(concat1('<a href="',get_permalink()),'">'));
}else 
{{if ( ((('') == deAspis(get_option(array('permalink_structure',false)))) || deAspis(Aspis_in_array($post[0]->post_status,array(array(array('draft',false),array('pending',false)),false)))))
 $output = concat($output,concat2(concat(concat2(concat1('<a href="',get_permalink()),'&amp;page='),$i),'">'));
else 
{$output = concat($output,concat2(concat(concat1('<a href="',trailingslashit(get_permalink())),user_trailingslashit($i,array('single_paged',false))),'">'));
}}}}$output = concat($output,$link_before);
$output = concat($output,$j);
$output = concat($output,$link_after);
if ( (($i[0] != $page[0]) || ((denot_boolean($more)) && ($page[0] == (1)))))
 $output = concat2($output,'</a>');
}$output = concat($output,$after);
}else 
{{if ( $more[0])
 {$output = concat($output,$before);
$i = array($page[0] - (1),false);
if ( ($i[0] && $more[0]))
 {if ( ((1) == $i[0]))
 {$output = concat($output,concat2(concat(concat(concat(concat2(concat1('<a href="',get_permalink()),'">'),$link_before),$previouspagelink),$link_after),'</a>'));
}else 
{{if ( ((('') == deAspis(get_option(array('permalink_structure',false)))) || deAspis(Aspis_in_array($post[0]->post_status,array(array(array('draft',false),array('pending',false)),false)))))
 $output = concat($output,concat2(concat(concat(concat(concat2(concat(concat2(concat1('<a href="',get_permalink()),'&amp;page='),$i),'">'),$link_before),$previouspagelink),$link_after),'</a>'));
else 
{$output = concat($output,concat2(concat(concat(concat(concat2(concat(concat1('<a href="',trailingslashit(get_permalink())),user_trailingslashit($i,array('single_paged',false))),'">'),$link_before),$previouspagelink),$link_after),'</a>'));
}}}}$i = array($page[0] + (1),false);
if ( (($i[0] <= $numpages[0]) && $more[0]))
 {if ( ((1) == $i[0]))
 {$output = concat($output,concat2(concat(concat(concat(concat2(concat1('<a href="',get_permalink()),'">'),$link_before),$nextpagelink),$link_after),'</a>'));
}else 
{{if ( ((('') == deAspis(get_option(array('permalink_structure',false)))) || deAspis(Aspis_in_array($post[0]->post_status,array(array(array('draft',false),array('pending',false)),false)))))
 $output = concat($output,concat2(concat(concat(concat(concat2(concat(concat2(concat1('<a href="',get_permalink()),'&amp;page='),$i),'">'),$link_before),$nextpagelink),$link_after),'</a>'));
else 
{$output = concat($output,concat2(concat(concat(concat(concat2(concat(concat1('<a href="',trailingslashit(get_permalink())),user_trailingslashit($i,array('single_paged',false))),'">'),$link_before),$nextpagelink),$link_after),'</a>'));
}}}}$output = concat($output,$after);
}}}}if ( $echo[0])
 echo AspisCheckPrint($output);
return $output;
 }
function post_custom ( $key = array('',false) ) {
$custom = get_post_custom();
if ( ((1) == count(deAspis(attachAspis($custom,$key[0])))))
 return attachAspis($custom[0][$key[0]],(0));
else 
{return attachAspis($custom,$key[0]);
} }
function the_meta (  ) {
if ( deAspis($keys = get_post_custom_keys()))
 {echo AspisCheckPrint(array("<ul class='post-meta'>\n",false));
foreach ( deAspis(array_cast($keys)) as $key  )
{$keyt = Aspis_trim($key);
if ( (('_') == deAspis(attachAspis($keyt,(0)))))
 continue ;
$values = attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC(get_post_custom_values($key))));
$value = Aspis_implode($values,array(', ',false));
echo AspisCheckPrint(apply_filters(array('the_meta_key',false),concat2(concat(concat2(concat1("<li><span class='post-meta-key'>",$key),":</span> "),$value),"</li>\n"),$key,$value));
}echo AspisCheckPrint(array("</ul>\n",false));
} }
function wp_dropdown_pages ( $args = array('',false) ) {
$defaults = array(array('depth' => array(0,false,false),'child_of' => array(0,false,false),'selected' => array(0,false,false),'echo' => array(1,false,false),'name' => array('page_id',false,false),'show_option_none' => array('',false,false),'show_option_no_change' => array('',false,false),'option_none_value' => array('',false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
$pages = get_pages($r);
$output = array('',false);
$name = esc_attr($name);
if ( (!((empty($pages) || Aspis_empty( $pages)))))
 {$output = concat2(concat(concat2(concat1("<select name=\"",$name),"\" id=\""),$name),"\">\n");
if ( $show_option_no_change[0])
 $output = concat($output,concat2(concat1("\t<option value=\"-1\">",$show_option_no_change),"</option>"));
if ( $show_option_none[0])
 $output = concat($output,concat(concat1("\t<option value=\"",esc_attr($option_none_value)),concat2(concat1("\">",$show_option_none),"</option>\n")));
$output = concat($output,walk_page_dropdown_tree($pages,$depth,$r));
$output = concat2($output,"</select>\n");
}$output = apply_filters(array('wp_dropdown_pages',false),$output);
if ( $echo[0])
 echo AspisCheckPrint($output);
return $output;
 }
function wp_list_pages ( $args = array('',false) ) {
$defaults = array(array('depth' => array(0,false,false),'show_date' => array('',false,false),deregisterTaint(array('date_format',false)) => addTaint(get_option(array('date_format',false))),'child_of' => array(0,false,false),'exclude' => array('',false,false),deregisterTaint(array('title_li',false)) => addTaint(__(array('Pages',false))),'echo' => array(1,false,false),'authors' => array('',false,false),'sort_column' => array('menu_order, post_title',false,false),'link_before' => array('',false,false),'link_after' => array('',false,false),'walker' => array('',false,false),),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
$output = array('',false);
$current_page = array(0,false);
arrayAssign($r[0],deAspis(registerTaint(array('exclude',false))),addTaint(Aspis_preg_replace(array('/[^0-9,]/',false),array('',false),$r[0]['exclude'])));
$exclude_array = deAspis(($r[0]['exclude'])) ? Aspis_explode(array(',',false),$r[0]['exclude']) : array(array(),false);
arrayAssign($r[0],deAspis(registerTaint(array('exclude',false))),addTaint(Aspis_implode(array(',',false),apply_filters(array('wp_list_pages_excludes',false),$exclude_array))));
arrayAssign($r[0],deAspis(registerTaint(array('hierarchical',false))),addTaint(array(0,false)));
$pages = get_pages($r);
if ( (!((empty($pages) || Aspis_empty( $pages)))))
 {if ( deAspis($r[0]['title_li']))
 $output = concat($output,concat2(concat1('<li class="pagenav">',$r[0]['title_li']),'<ul>'));
global $wp_query;
if ( ((deAspis(is_page()) || deAspis(is_attachment())) || $wp_query[0]->is_posts_page[0]))
 $current_page = $wp_query[0]->get_queried_object_id();
$output = concat($output,walk_page_tree($pages,$r[0]['depth'],$current_page,$r));
if ( deAspis($r[0]['title_li']))
 $output = concat2($output,'</ul></li>');
}$output = apply_filters(array('wp_list_pages',false),$output,$r);
if ( deAspis($r[0]['echo']))
 echo AspisCheckPrint($output);
else 
{return $output;
} }
function wp_page_menu ( $args = array(array(),false) ) {
$defaults = array(array('sort_column' => array('menu_order, post_title',false,false),'menu_class' => array('menu',false,false),'echo' => array(true,false,false),'link_before' => array('',false,false),'link_after' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
$args = apply_filters(array('wp_page_menu_args',false),$args);
$menu = array('',false);
$list_args = $args;
if ( (((isset($args[0][('show_home')]) && Aspis_isset( $args [0][('show_home')]))) && (!((empty($args[0][('show_home')]) || Aspis_empty( $args [0][('show_home')]))))))
 {if ( (((true === deAspis($args[0]['show_home'])) || (('1') === deAspis($args[0]['show_home']))) || ((1) === deAspis($args[0]['show_home']))))
 $text = __(array('Home',false));
else 
{$text = $args[0]['show_home'];
}$class = array('',false);
if ( (deAspis(is_front_page()) && (denot_boolean(is_paged()))))
 $class = array('class="current_page_item"',false);
$menu = concat($menu,concat2(concat(concat(concat(concat2(concat(concat2(concat(concat2(concat1('<li ',$class),'><a href="'),get_option(array('home',false))),'" title="'),esc_attr($text)),'">'),$args[0]['link_before']),$text),$args[0]['link_after']),'</a></li>'));
if ( (deAspis(get_option(array('show_on_front',false))) == ('page')))
 {if ( (!((empty($list_args[0][('exclude')]) || Aspis_empty( $list_args [0][('exclude')])))))
 {arrayAssign($list_args[0],deAspis(registerTaint(array('exclude',false))),addTaint(concat2($list_args[0]['exclude'],',')));
}else 
{{arrayAssign($list_args[0],deAspis(registerTaint(array('exclude',false))),addTaint(array('',false)));
}}arrayAssign($list_args[0],deAspis(registerTaint(array('exclude',false))),addTaint(concat($list_args[0]['exclude'],get_option(array('page_on_front',false)))));
}}arrayAssign($list_args[0],deAspis(registerTaint(array('echo',false))),addTaint(array(false,false)));
arrayAssign($list_args[0],deAspis(registerTaint(array('title_li',false))),addTaint(array('',false)));
$menu = concat($menu,Aspis_str_replace(array(array(array("\r",false),array("\n",false),array("\t",false)),false),array('',false),wp_list_pages($list_args)));
if ( $menu[0])
 $menu = concat2(concat1('<ul>',$menu),'</ul>');
$menu = concat2(concat(concat2(concat1('<div class="',esc_attr($args[0]['menu_class'])),'">'),$menu),"</div>\n");
$menu = apply_filters(array('wp_page_menu',false),$menu,$args);
if ( deAspis($args[0]['echo']))
 echo AspisCheckPrint($menu);
else 
{return $menu;
} }
function walk_page_tree ( $pages,$depth,$current_page,$r ) {
if ( ((empty($r[0][('walker')]) || Aspis_empty( $r [0][('walker')]))))
 $walker = array(new Walker_Page,false);
else 
{$walker = $r[0]['walker'];
}$args = array(array($pages,$depth,$r,$current_page),false);
return Aspis_call_user_func_array(array(array(&$walker,array('walk',false)),false),$args);
 }
function walk_page_dropdown_tree (  ) {
$args = array(func_get_args(),false);
if ( ((empty($args[0][(2)][0][('walker')]) || Aspis_empty( $args [0][(2)] [0][('walker')]))))
 $walker = array(new Walker_PageDropdown,false);
else 
{$walker = $args[0][(2)][0]['walker'];
}return Aspis_call_user_func_array(array(array(&$walker,array('walk',false)),false),$args);
 }
function the_attachment_link ( $id = array(0,false),$fullsize = array(false,false),$deprecated = array(false,false),$permalink = array(false,false) ) {
if ( $fullsize[0])
 echo AspisCheckPrint(wp_get_attachment_link($id,array('full',false),$permalink));
else 
{echo AspisCheckPrint(wp_get_attachment_link($id,array('thumbnail',false),$permalink));
} }
function wp_get_attachment_link ( $id = array(0,false),$size = array('thumbnail',false),$permalink = array(false,false),$icon = array(false,false),$text = array(false,false) ) {
$id = Aspis_intval($id);
$_post = &get_post($id);
if ( ((('attachment') != $_post[0]->post_type[0]) || (denot_boolean($url = wp_get_attachment_url($_post[0]->ID)))))
 return __(array('Missing Attachment',false));
if ( $permalink[0])
 $url = get_attachment_link($_post[0]->ID);
$post_title = esc_attr($_post[0]->post_title);
if ( $text[0])
 {$link_text = esc_attr($text);
}elseif ( (((is_int(deAspisRC($size)) && ($size[0] != (0))) or (is_string(deAspisRC($size)) && ($size[0] != ('none')))) or ($size[0] != false)))
 {$link_text = wp_get_attachment_image($id,$size,$icon);
}if ( (deAspis(Aspis_trim($link_text)) == ('')))
 $link_text = $_post[0]->post_title;
return apply_filters(array('wp_get_attachment_link',false),concat2(concat(concat2(concat(concat2(concat1("<a href='",$url),"' title='"),$post_title),"'>"),$link_text),"</a>"),$id,$size,$permalink,$icon,$text);
 }
function get_the_attachment_link ( $id = array(0,false),$fullsize = array(false,false),$max_dims = array(false,false),$permalink = array(false,false) ) {
$id = int_cast($id);
$_post = &get_post($id);
if ( ((('attachment') != $_post[0]->post_type[0]) || (denot_boolean($url = wp_get_attachment_url($_post[0]->ID)))))
 return __(array('Missing Attachment',false));
if ( $permalink[0])
 $url = get_attachment_link($_post[0]->ID);
$post_title = esc_attr($_post[0]->post_title);
$innerHTML = get_attachment_innerHTML($_post[0]->ID,$fullsize,$max_dims);
return concat2(concat(concat2(concat(concat2(concat1("<a href='",$url),"' title='"),$post_title),"'>"),$innerHTML),"</a>");
 }
function get_attachment_icon_src ( $id = array(0,false),$fullsize = array(false,false) ) {
$id = int_cast($id);
if ( (denot_boolean($post = &get_post($id))))
 return array(false,false);
$file = get_attached_file($post[0]->ID);
if ( ((denot_boolean($fullsize)) && deAspis($src = wp_get_attachment_thumb_url($post[0]->ID))))
 {$src_file = Aspis_basename($src);
$class = array('attachmentthumb',false);
}elseif ( deAspis(wp_attachment_is_image($post[0]->ID)))
 {$src = wp_get_attachment_url($post[0]->ID);
$src_file = &$file;
$class = array('attachmentimage',false);
}elseif ( deAspis($src = wp_mime_type_icon($post[0]->ID)))
 {$icon_dir = apply_filters(array('icon_dir',false),concat2(get_template_directory(),'/images'));
$src_file = concat(concat2($icon_dir,'/'),Aspis_basename($src));
}if ( ((!((isset($src) && Aspis_isset( $src)))) || (denot_boolean($src))))
 return array(false,false);
return array(array($src,$src_file),false);
 }
function get_attachment_icon ( $id = array(0,false),$fullsize = array(false,false),$max_dims = array(false,false) ) {
$id = int_cast($id);
if ( (denot_boolean($post = &get_post($id))))
 return array(false,false);
if ( (denot_boolean($src = get_attachment_icon_src($post[0]->ID,$fullsize))))
 return array(false,false);
list($src,$src_file) = deAspisList($src,array());
if ( (deAspis(($max_dims = apply_filters(array('attachment_max_dims',false),$max_dims))) && file_exists($src_file[0])))
 {$imagesize = attAspisRC(getimagesize($src_file[0]));
if ( ((deAspis(attachAspis($imagesize,(0))) > deAspis(attachAspis($max_dims,(0)))) || (deAspis(attachAspis($imagesize,(1))) > deAspis(attachAspis($max_dims,(1))))))
 {$actual_aspect = array(deAspis(attachAspis($imagesize,(0))) / deAspis(attachAspis($imagesize,(1))),false);
$desired_aspect = array(deAspis(attachAspis($max_dims,(0))) / deAspis(attachAspis($max_dims,(1))),false);
if ( ($actual_aspect[0] >= $desired_aspect[0]))
 {$height = array($actual_aspect[0] * deAspis(attachAspis($max_dims,(0))),false);
$constraint = concat2(concat1("width='",attachAspis($max_dims,(0))),"' ");
$post[0]->iconsize = array(array(attachAspis($max_dims,(0)),$height),false);
}else 
{{$width = array(deAspis(attachAspis($max_dims,(1))) / $actual_aspect[0],false);
$constraint = concat2(concat1("height='",attachAspis($max_dims,(1))),"' ");
$post[0]->iconsize = array(array($width,attachAspis($max_dims,(1))),false);
}}}else 
{{$post[0]->iconsize = array(array(attachAspis($imagesize,(0)),attachAspis($imagesize,(1))),false);
$constraint = array('',false);
}}}else 
{{$constraint = array('',false);
}}$post_title = esc_attr($post[0]->post_title);
$icon = concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<img src='",$src),"' title='"),$post_title),"' alt='"),$post_title),"' "),$constraint),"/>");
return apply_filters(array('attachment_icon',false),$icon,$post[0]->ID);
 }
function get_attachment_innerHTML ( $id = array(0,false),$fullsize = array(false,false),$max_dims = array(false,false) ) {
$id = int_cast($id);
if ( (denot_boolean($post = &get_post($id))))
 return array(false,false);
if ( deAspis($innerHTML = get_attachment_icon($post[0]->ID,$fullsize,$max_dims)))
 return $innerHTML;
$innerHTML = esc_attr($post[0]->post_title);
return apply_filters(array('attachment_innerHTML',false),$innerHTML,$post[0]->ID);
 }
function prepend_attachment ( $content ) {
global $post;
if ( (((empty($post[0]->post_type) || Aspis_empty( $post[0] ->post_type ))) || ($post[0]->post_type[0] != ('attachment'))))
 return $content;
$p = array('<p class="attachment">',false);
$p = concat($p,wp_get_attachment_link(array(0,false),array('medium',false),array(false,false)));
$p = concat2($p,'</p>');
$p = apply_filters(array('prepend_attachment',false),$p);
return concat(concat2($p,"\n"),$content);
 }
function get_the_password_form (  ) {
global $post;
$label = concat1('pwbox-',(((empty($post[0]->ID) || Aspis_empty( $post[0] ->ID ))) ? attAspis(rand()) : $post[0]->ID));
$output = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<form action="',get_option(array('siteurl',false))),'/wp-pass.php" method="post">
	<p>'),__(array("This post is password protected. To view it please enter your password below:",false))),'</p>
	<p><label for="'),$label),'">'),__(array("Password:",false))),' <input name="post_password" id="'),$label),'" type="password" size="20" /></label> <input type="submit" name="Submit" value="'),esc_attr__(array("Submit",false))),'" /></p>
	</form>
	');
return apply_filters(array('the_password_form',false),$output);
 }
function is_page_template ( $template = array('',false) ) {
if ( (denot_boolean(is_page())))
 {return array(false,false);
}global $wp_query;
$page = $wp_query[0]->get_queried_object();
$custom_fields = get_post_custom_values(array('_wp_page_template',false),$page[0]->ID);
$page_template = attachAspis($custom_fields,(0));
if ( ((empty($template) || Aspis_empty( $template))))
 {if ( (!((empty($page_template) || Aspis_empty( $page_template)))))
 {return array(true,false);
}}elseif ( ($template[0] == $page_template[0]))
 {return array(true,false);
}return array(false,false);
 }
function wp_post_revision_title ( $revision,$link = array(true,false) ) {
if ( (denot_boolean($revision = get_post($revision))))
 return $revision;
if ( (denot_boolean(Aspis_in_array($revision[0]->post_type,array(array(array('post',false),array('page',false),array('revision',false)),false)))))
 return array(false,false);
$datef = _x(array('j F, Y @ G:i',false),array('revision date format',false));
$autosavef = __(array('%1$s [Autosave]',false));
$currentf = __(array('%1$s [Current Revision]',false));
$date = date_i18n($datef,attAspis(strtotime((deconcat2($revision[0]->post_modified_gmt,' +0000')))));
if ( (($link[0] && deAspis(current_user_can(array('edit_post',false),$revision[0]->ID))) && deAspis($link = get_edit_post_link($revision[0]->ID))))
 $date = concat2(concat(concat2(concat1("<a href='",$link),"'>"),$date),"</a>");
if ( (denot_boolean(wp_is_post_revision($revision))))
 $date = Aspis_sprintf($currentf,$date);
elseif ( deAspis(wp_is_post_autosave($revision)))
 $date = Aspis_sprintf($autosavef,$date);
return $date;
 }
function wp_list_post_revisions ( $post_id = array(0,false),$args = array(null,false) ) {
if ( (denot_boolean($post = get_post($post_id))))
 return ;
$defaults = array(array('parent' => array(false,false,false),'right' => array(false,false,false),'left' => array(false,false,false),'format' => array('list',false,false),'type' => array('all',false,false)),false);
extract((deAspis(wp_parse_args($args,$defaults))),EXTR_SKIP);
switch ( $type[0] ) {
case ('autosave'):if ( (denot_boolean($autosave = wp_get_post_autosave($post[0]->ID))))
 return ;
$revisions = array(array($autosave),false);
break ;
case ('revision'):case ('all'):default :if ( (denot_boolean($revisions = wp_get_post_revisions($post[0]->ID))))
 return ;
break ;
 }
$titlef = _x(array('%1$s by %2$s',false),array('post revision',false));
if ( $parent[0])
 Aspis_array_unshift($revisions,$post);
$rows = array('',false);
$class = array(false,false);
$can_edit_post = current_user_can(array('edit_post',false),$post[0]->ID);
foreach ( $revisions[0] as $revision  )
{if ( (denot_boolean(current_user_can(array('read_post',false),$revision[0]->ID))))
 continue ;
if ( ((('revision') === $type[0]) && deAspis(wp_is_post_autosave($revision))))
 continue ;
$date = wp_post_revision_title($revision);
$name = get_the_author_meta(array('display_name',false),$revision[0]->post_author);
if ( (('form-table') == $format[0]))
 {if ( $left[0])
 $left_checked = ($left[0] == $revision[0]->ID[0]) ? array(' checked="checked"',false) : array('',false);
else 
{$left_checked = $right_checked[0] ? array(' checked="checked"',false) : array('',false);
}$right_checked = ($right[0] == $revision[0]->ID[0]) ? array(' checked="checked"',false) : array('',false);
$class = $class[0] ? array('',false) : array(" class='alternate'",false);
if ( (($post[0]->ID[0] != $revision[0]->ID[0]) && $can_edit_post[0]))
 $actions = concat2(concat(concat2(concat1('<a href="',wp_nonce_url(add_query_arg(array(array(deregisterTaint(array('revision',false)) => addTaint($revision[0]->ID),'diff' => array(false,false,false),'action' => array('restore',false,false)),false)),concat(concat2(concat1("restore-post_",$post[0]->ID),"|"),$revision[0]->ID))),'">'),__(array('Restore',false))),'</a>');
else 
{$actions = array('',false);
}$rows = concat($rows,concat2(concat1("<tr",$class),">\n"));
$rows = concat($rows,concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\t<th style='white-space: nowrap' scope='row'><input type='radio' name='left' value='",$revision[0]->ID),"'"),$left_checked)," /><input type='radio' name='right' value='"),$revision[0]->ID),"'"),$right_checked)," /></th>\n"));
$rows = concat($rows,concat2(concat1("\t<td>",$date),"</td>\n"));
$rows = concat($rows,concat2(concat1("\t<td>",$name),"</td>\n"));
$rows = concat($rows,concat2(concat1("\t<td class='action-links'>",$actions),"</td>\n"));
$rows = concat2($rows,"</tr>\n");
}else 
{{$title = Aspis_sprintf($titlef,$date,$name);
$rows = concat($rows,concat2(concat1("\t<li>",$title),"</li>\n"));
}}}if ( (('form-table') == $format[0]))
 {;
?>

<form action="revision.php" method="get">

<div class="tablenav">
	<div class="alignleft">
		<input type="submit" class="button-secondary" value="<?php esc_attr_e(array('Compare Revisions',false));
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
	<th scope="col"><?php _e(array('Date Created',false));
;
?></th>
	<th scope="col"><?php _e(array('Author',false));
;
?></th>
	<th scope="col" class="action-links"><?php _e(array('Actions',false));
;
?></th>
</tr>
</thead>
<tbody>

<?php echo AspisCheckPrint($rows);
;
?>

</tbody>
</table>

</form>

<?php }else 
{echo AspisCheckPrint(array("<ul class='post-revisions'>\n",false));
echo AspisCheckPrint($rows);
echo AspisCheckPrint(array("</ul>",false));
} }
