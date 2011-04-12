<?php require_once('AspisMain.php'); ?><?php
function get_header ( $name = array(null,false) ) {
do_action(array('get_header',false),$name);
$templates = array(array(),false);
if ( ((isset($name) && Aspis_isset( $name))))
 arrayAssignAdd($templates[0][],addTaint(concat2(concat1("header-",$name),".php")));
arrayAssignAdd($templates[0][],addTaint(array("header.php",false)));
if ( (('') == deAspis(locate_template($templates,array(true,false)))))
 load_template(concat2(get_theme_root(),'/default/header.php'));
 }
function get_footer ( $name = array(null,false) ) {
do_action(array('get_footer',false),$name);
$templates = array(array(),false);
if ( ((isset($name) && Aspis_isset( $name))))
 arrayAssignAdd($templates[0][],addTaint(concat2(concat1("footer-",$name),".php")));
arrayAssignAdd($templates[0][],addTaint(array("footer.php",false)));
if ( (('') == deAspis(locate_template($templates,array(true,false)))))
 load_template(concat2(get_theme_root(),'/default/footer.php'));
 }
function get_sidebar ( $name = array(null,false) ) {
do_action(array('get_sidebar',false),$name);
$templates = array(array(),false);
if ( ((isset($name) && Aspis_isset( $name))))
 arrayAssignAdd($templates[0][],addTaint(concat2(concat1("sidebar-",$name),".php")));
arrayAssignAdd($templates[0][],addTaint(array("sidebar.php",false)));
if ( (('') == deAspis(locate_template($templates,array(true,false)))))
 load_template(concat2(get_theme_root(),'/default/sidebar.php'));
 }
function get_search_form (  ) {
do_action(array('get_search_form',false));
$search_form_template = locate_template(array(array(array('searchform.php',false)),false));
if ( (('') != $search_form_template[0]))
 {require deAspis(($search_form_template));
return ;
}$form = concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<form role="search" method="get" id="searchform" action="',get_option(array('home',false))),'/" >
	<div><label class="screen-reader-text" for="s">'),__(array('Search for:',false))),'</label>
	<input type="text" value="'),esc_attr(apply_filters(array('the_search_query',false),get_search_query()))),'" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="'),esc_attr__(array('Search',false))),'" />
	</div>
	</form>');
echo AspisCheckPrint(apply_filters(array('get_search_form',false),$form));
 }
function wp_loginout ( $redirect = array('',false) ) {
if ( (denot_boolean(is_user_logged_in())))
 $link = concat2(concat(concat2(concat1('<a href="',esc_url(wp_login_url($redirect))),'">'),__(array('Log in',false))),'</a>');
else 
{$link = concat2(concat(concat2(concat1('<a href="',esc_url(wp_logout_url($redirect))),'">'),__(array('Log out',false))),'</a>');
}echo AspisCheckPrint(apply_filters(array('loginout',false),$link));
 }
function wp_logout_url ( $redirect = array('',false) ) {
$args = array(array('action' => array('logout',false,false)),false);
if ( (!((empty($redirect) || Aspis_empty( $redirect)))))
 {arrayAssign($args[0],deAspis(registerTaint(array('redirect_to',false))),addTaint(Aspis_urlencode($redirect)));
}$logout_url = add_query_arg($args,site_url(array('wp-login.php',false),array('login',false)));
$logout_url = wp_nonce_url($logout_url,array('log-out',false));
return apply_filters(array('logout_url',false),$logout_url,$redirect);
 }
function wp_login_url ( $redirect = array('',false) ) {
$login_url = site_url(array('wp-login.php',false),array('login',false));
if ( (!((empty($redirect) || Aspis_empty( $redirect)))))
 {$login_url = add_query_arg(array('redirect_to',false),Aspis_urlencode($redirect),$login_url);
}return apply_filters(array('login_url',false),$login_url,$redirect);
 }
function wp_lostpassword_url ( $redirect = array('',false) ) {
$args = array(array('action' => array('lostpassword',false,false)),false);
if ( (!((empty($redirect) || Aspis_empty( $redirect)))))
 {arrayAssign($args[0],deAspis(registerTaint(array('redirect_to',false))),addTaint($redirect));
}$lostpassword_url = add_query_arg($args,site_url(array('wp-login.php',false),array('login',false)));
return apply_filters(array('lostpassword_url',false),$lostpassword_url,$redirect);
 }
function wp_register ( $before = array('<li>',false),$after = array('</li>',false) ) {
if ( (denot_boolean(is_user_logged_in())))
 {if ( deAspis(get_option(array('users_can_register',false))))
 $link = concat(concat2(concat(concat2(concat(concat2($before,'<a href="'),site_url(array('wp-login.php?action=register',false),array('login',false))),'">'),__(array('Register',false))),'</a>'),$after);
else 
{$link = array('',false);
}}else 
{{$link = concat(concat2(concat(concat2(concat(concat2($before,'<a href="'),admin_url()),'">'),__(array('Site Admin',false))),'</a>'),$after);
}}echo AspisCheckPrint(apply_filters(array('register',false),$link));
 }
function wp_meta (  ) {
do_action(array('wp_meta',false));
 }
function bloginfo ( $show = array('',false) ) {
echo AspisCheckPrint(get_bloginfo($show,array('display',false)));
 }
function get_bloginfo ( $show = array('',false),$filter = array('raw',false) ) {
switch ( $show[0] ) {
case ('url'):case ('home'):case ('siteurl'):$output = get_option(array('home',false));
break ;
case ('wpurl'):$output = get_option(array('siteurl',false));
break ;
case ('description'):$output = get_option(array('blogdescription',false));
break ;
case ('rdf_url'):$output = get_feed_link(array('rdf',false));
break ;
case ('rss_url'):$output = get_feed_link(array('rss',false));
break ;
case ('rss2_url'):$output = get_feed_link(array('rss2',false));
break ;
case ('atom_url'):$output = get_feed_link(array('atom',false));
break ;
case ('comments_atom_url'):$output = get_feed_link(array('comments_atom',false));
break ;
case ('comments_rss2_url'):$output = get_feed_link(array('comments_rss2',false));
break ;
case ('pingback_url'):$output = concat2(get_option(array('siteurl',false)),'/xmlrpc.php');
break ;
case ('stylesheet_url'):$output = get_stylesheet_uri();
break ;
case ('stylesheet_directory'):$output = get_stylesheet_directory_uri();
break ;
case ('template_directory'):case ('template_url'):$output = get_template_directory_uri();
break ;
case ('admin_email'):$output = get_option(array('admin_email',false));
break ;
case ('charset'):$output = get_option(array('blog_charset',false));
if ( (('') == $output[0]))
 $output = array('UTF-8',false);
break ;
case ('html_type'):$output = get_option(array('html_type',false));
break ;
case ('version'):global $wp_version;
$output = $wp_version;
break ;
case ('language'):$output = get_locale();
$output = Aspis_str_replace(array('_',false),array('-',false),$output);
break ;
case ('text_direction'):global $wp_locale;
$output = $wp_locale[0]->text_direction;
break ;
case ('name'):default :$output = get_option(array('blogname',false));
break ;
 }
$url = array(true,false);
if ( (((strpos($show[0],'url') === false) && (strpos($show[0],'directory') === false)) && (strpos($show[0],'home') === false)))
 $url = array(false,false);
if ( (('display') == $filter[0]))
 {if ( $url[0])
 $output = apply_filters(array('bloginfo_url',false),$output,$show);
else 
{$output = apply_filters(array('bloginfo',false),$output,$show);
}}return $output;
 }
function wp_title ( $sep = array('&raquo;',false),$display = array(true,false),$seplocation = array('',false) ) {
global $wpdb,$wp_locale,$wp_query;
$cat = get_query_var(array('cat',false));
$tag = get_query_var(array('tag_id',false));
$category_name = get_query_var(array('category_name',false));
$author = get_query_var(array('author',false));
$author_name = get_query_var(array('author_name',false));
$m = get_query_var(array('m',false));
$year = get_query_var(array('year',false));
$monthnum = get_query_var(array('monthnum',false));
$day = get_query_var(array('day',false));
$search = get_query_var(array('s',false));
$title = array('',false);
$t_sep = array('%WP_TITILE_SEP%',false);
if ( (!((empty($cat) || Aspis_empty( $cat)))))
 {if ( (denot_boolean(Aspis_stristr($cat,array('-',false)))))
 $title = apply_filters(array('single_cat_title',false),get_the_category_by_ID($cat));
}elseif ( (!((empty($category_name) || Aspis_empty( $category_name)))))
 {if ( deAspis(Aspis_stristr($category_name,array('/',false))))
 {$category_name = Aspis_explode(array('/',false),$category_name);
if ( deAspis(attachAspis($category_name,(count($category_name[0]) - (1)))))
 $category_name = attachAspis($category_name,(count($category_name[0]) - (1)));
else 
{$category_name = attachAspis($category_name,(count($category_name[0]) - (2)));
}}$cat = get_term_by(array('slug',false),$category_name,array('category',false),array(OBJECT,false),array('display',false));
if ( $cat[0])
 $title = apply_filters(array('single_cat_title',false),$cat[0]->name);
}if ( (!((empty($tag) || Aspis_empty( $tag)))))
 {$tag = get_term($tag,array('post_tag',false),array(OBJECT,false),array('display',false));
if ( deAspis(is_wp_error($tag)))
 return $tag;
if ( (!((empty($tag[0]->name) || Aspis_empty( $tag[0] ->name )))))
 $title = apply_filters(array('single_tag_title',false),$tag[0]->name);
}if ( (!((empty($author) || Aspis_empty( $author)))))
 {$title = get_userdata($author);
$title = $title[0]->display_name;
}if ( (!((empty($author_name) || Aspis_empty( $author_name)))))
 {$title = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT display_name FROM ",$wpdb[0]->users)," WHERE user_nicename = %s"),$author_name));
}if ( (!((empty($m) || Aspis_empty( $m)))))
 {$my_year = Aspis_substr($m,array(0,false),array(4,false));
$my_month = $wp_locale[0]->get_month(Aspis_substr($m,array(4,false),array(2,false)));
$my_day = Aspis_intval(Aspis_substr($m,array(6,false),array(2,false)));
$title = concat(concat($my_year,($my_month[0] ? concat($t_sep,$my_month) : array("",false))),($my_day[0] ? concat($t_sep,$my_day) : array("",false)));
}if ( (!((empty($year) || Aspis_empty( $year)))))
 {$title = $year;
if ( (!((empty($monthnum) || Aspis_empty( $monthnum)))))
 $title = concat($title,concat($t_sep,$wp_locale[0]->get_month($monthnum)));
if ( (!((empty($day) || Aspis_empty( $day)))))
 $title = concat($title,concat($t_sep,zeroise($day,array(2,false))));
}if ( ((deAspis(is_single()) || (deAspis(is_home()) && (denot_boolean(is_front_page())))) || (deAspis(is_page()) && (denot_boolean(is_front_page())))))
 {$post = $wp_query[0]->get_queried_object();
$title = Aspis_strip_tags(apply_filters(array('single_post_title',false),$post[0]->post_title));
}if ( deAspis(is_tax()))
 {$taxonomy = get_query_var(array('taxonomy',false));
$tax = get_taxonomy($taxonomy);
$tax = $tax[0]->label;
$term = $wp_query[0]->get_queried_object();
$term = $term[0]->name;
$title = concat(concat($tax,$t_sep),$term);
}if ( deAspis(is_search()))
 {$title = Aspis_sprintf(__(array('Search Results %1$s %2$s',false)),$t_sep,Aspis_strip_tags($search));
}if ( deAspis(is_404()))
 {$title = __(array('Page not found',false));
}$prefix = array('',false);
if ( (!((empty($title) || Aspis_empty( $title)))))
 $prefix = concat2(concat1(" ",$sep)," ");
if ( (('right') == $seplocation[0]))
 {$title_array = Aspis_explode($t_sep,$title);
$title_array = Aspis_array_reverse($title_array);
$title = concat(Aspis_implode(concat2(concat1(" ",$sep)," "),$title_array),$prefix);
}else 
{{$title_array = Aspis_explode($t_sep,$title);
$title = concat($prefix,Aspis_implode(concat2(concat1(" ",$sep)," "),$title_array));
}}$title = apply_filters(array('wp_title',false),$title,$sep,$seplocation);
if ( $display[0])
 echo AspisCheckPrint($title);
else 
{return $title;
} }
function single_post_title ( $prefix = array('',false),$display = array(true,false) ) {
global $wpdb;
$p = get_query_var(array('p',false));
$name = get_query_var(array('name',false));
if ( (deAspis(Aspis_intval($p)) || (('') != $name[0])))
 {if ( (denot_boolean($p)))
 $p = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_name = %s"),$name));
$post = &get_post($p);
$title = $post[0]->post_title;
$title = apply_filters(array('single_post_title',false),$title);
if ( $display[0])
 echo AspisCheckPrint(concat($prefix,Aspis_strip_tags($title)));
else 
{return Aspis_strip_tags($title);
}} }
function single_cat_title ( $prefix = array('',false),$display = array(true,false) ) {
$cat = Aspis_intval(get_query_var(array('cat',false)));
if ( ((!((empty($cat) || Aspis_empty( $cat)))) && (!(deAspis(Aspis_strtoupper($cat)) == ('ALL')))))
 {$my_cat_name = apply_filters(array('single_cat_title',false),get_the_category_by_ID($cat));
if ( (!((empty($my_cat_name) || Aspis_empty( $my_cat_name)))))
 {if ( $display[0])
 echo AspisCheckPrint(concat($prefix,Aspis_strip_tags($my_cat_name)));
else 
{return Aspis_strip_tags($my_cat_name);
}}}else 
{if ( deAspis(is_tag()))
 {return single_tag_title($prefix,$display);
}} }
function single_tag_title ( $prefix = array('',false),$display = array(true,false) ) {
if ( (denot_boolean(is_tag())))
 return ;
$tag_id = Aspis_intval(get_query_var(array('tag_id',false)));
if ( (!((empty($tag_id) || Aspis_empty( $tag_id)))))
 {$my_tag = &get_term($tag_id,array('post_tag',false),array(OBJECT,false),array('display',false));
if ( deAspis(is_wp_error($my_tag)))
 return array(false,false);
$my_tag_name = apply_filters(array('single_tag_title',false),$my_tag[0]->name);
if ( (!((empty($my_tag_name) || Aspis_empty( $my_tag_name)))))
 {if ( $display[0])
 echo AspisCheckPrint(concat($prefix,$my_tag_name));
else 
{return $my_tag_name;
}}} }
function single_month_title ( $prefix = array('',false),$display = array(true,false) ) {
global $wp_locale;
$m = get_query_var(array('m',false));
$year = get_query_var(array('year',false));
$monthnum = get_query_var(array('monthnum',false));
if ( ((!((empty($monthnum) || Aspis_empty( $monthnum)))) && (!((empty($year) || Aspis_empty( $year))))))
 {$my_year = $year;
$my_month = $wp_locale[0]->get_month($monthnum);
}elseif ( (!((empty($m) || Aspis_empty( $m)))))
 {$my_year = Aspis_substr($m,array(0,false),array(4,false));
$my_month = $wp_locale[0]->get_month(Aspis_substr($m,array(4,false),array(2,false)));
}if ( ((empty($my_month) || Aspis_empty( $my_month))))
 return array(false,false);
$result = concat(concat(concat($prefix,$my_month),$prefix),$my_year);
if ( (denot_boolean($display)))
 return $result;
echo AspisCheckPrint($result);
 }
function get_archives_link ( $url,$text,$format = array('html',false),$before = array('',false),$after = array('',false) ) {
$text = wptexturize($text);
$title_text = esc_attr($text);
$url = esc_url($url);
if ( (('link') == $format[0]))
 $link_html = concat2(concat(concat2(concat1("\t<link rel='archives' title='",$title_text),"' href='"),$url),"' />\n");
elseif ( (('option') == $format[0]))
 $link_html = concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\t<option value='",$url),"'>"),$before)," "),$text)," "),$after),"</option>\n");
elseif ( (('html') == $format[0]))
 $link_html = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\t<li>",$before),"<a href='"),$url),"' title='"),$title_text),"'>"),$text),"</a>"),$after),"</li>\n");
else 
{$link_html = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\t",$before),"<a href='"),$url),"' title='"),$title_text),"'>"),$text),"</a>"),$after),"\n");
}$link_html = apply_filters(array("get_archives_link",false),$link_html);
return $link_html;
 }
function wp_get_archives ( $args = array('',false) ) {
global $wpdb,$wp_locale;
$defaults = array(array('type' => array('monthly',false,false),'limit' => array('',false,false),'format' => array('html',false,false),'before' => array('',false,false),'after' => array('',false,false),'show_post_count' => array(false,false,false),'echo' => array(1,false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
if ( (('') == $type[0]))
 $type = array('monthly',false);
if ( (('') != $limit[0]))
 {$limit = absint($limit);
$limit = concat1(' LIMIT ',$limit);
}$archive_week_separator = array('&#8211;',false);
$archive_date_format_over_ride = array(0,false);
$archive_day_date_format = array('Y/m/d',false);
$archive_week_start_date_format = array('Y/m/d',false);
$archive_week_end_date_format = array('Y/m/d',false);
if ( (denot_boolean($archive_date_format_over_ride)))
 {$archive_day_date_format = get_option(array('date_format',false));
$archive_week_start_date_format = get_option(array('date_format',false));
$archive_week_end_date_format = get_option(array('date_format',false));
}$where = apply_filters(array('getarchives_where',false),array("WHERE post_type = 'post' AND post_status = 'publish'",false),$r);
$join = apply_filters(array('getarchives_join',false),array("",false),$r);
$output = array('',false);
if ( (('monthly') == $type[0]))
 {$query = concat(concat2(concat(concat2(concat(concat2(concat1("SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM ",$wpdb[0]->posts)," "),$join)," "),$where)," GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC "),$limit);
$key = attAspis(md5($query[0]));
$cache = wp_cache_get(array('wp_get_archives',false),array('general',false));
if ( (!((isset($cache[0][$key[0]]) && Aspis_isset( $cache [0][$key[0]])))))
 {$arcresults = $wpdb[0]->get_results($query);
arrayAssign($cache[0],deAspis(registerTaint($key)),addTaint($arcresults));
wp_cache_add(array('wp_get_archives',false),$cache,array('general',false));
}else 
{{$arcresults = attachAspis($cache,$key[0]);
}}if ( $arcresults[0])
 {$afterafter = $after;
foreach ( deAspis(array_cast($arcresults)) as $arcresult  )
{$url = get_month_link($arcresult[0]->year,$arcresult[0]->month);
$text = Aspis_sprintf(__(array('%1$s %2$d',false)),$wp_locale[0]->get_month($arcresult[0]->month),$arcresult[0]->year);
if ( $show_post_count[0])
 $after = concat(concat2(concat1('&nbsp;(',$arcresult[0]->posts),')'),$afterafter);
$output = concat($output,get_archives_link($url,$text,$format,$before,$after));
}}}elseif ( (('yearly') == $type[0]))
 {$query = concat(concat2(concat(concat2(concat(concat2(concat1("SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM ",$wpdb[0]->posts)," "),$join)," "),$where)," GROUP BY YEAR(post_date) ORDER BY post_date DESC "),$limit);
$key = attAspis(md5($query[0]));
$cache = wp_cache_get(array('wp_get_archives',false),array('general',false));
if ( (!((isset($cache[0][$key[0]]) && Aspis_isset( $cache [0][$key[0]])))))
 {$arcresults = $wpdb[0]->get_results($query);
arrayAssign($cache[0],deAspis(registerTaint($key)),addTaint($arcresults));
wp_cache_add(array('wp_get_archives',false),$cache,array('general',false));
}else 
{{$arcresults = attachAspis($cache,$key[0]);
}}if ( $arcresults[0])
 {$afterafter = $after;
foreach ( deAspis(array_cast($arcresults)) as $arcresult  )
{$url = get_year_link($arcresult[0]->year);
$text = Aspis_sprintf(array('%d',false),$arcresult[0]->year);
if ( $show_post_count[0])
 $after = concat(concat2(concat1('&nbsp;(',$arcresult[0]->posts),')'),$afterafter);
$output = concat($output,get_archives_link($url,$text,$format,$before,$after));
}}}elseif ( (('daily') == $type[0]))
 {$query = concat(concat2(concat(concat2(concat(concat2(concat1("SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM ",$wpdb[0]->posts)," "),$join)," "),$where)," GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date DESC "),$limit);
$key = attAspis(md5($query[0]));
$cache = wp_cache_get(array('wp_get_archives',false),array('general',false));
if ( (!((isset($cache[0][$key[0]]) && Aspis_isset( $cache [0][$key[0]])))))
 {$arcresults = $wpdb[0]->get_results($query);
arrayAssign($cache[0],deAspis(registerTaint($key)),addTaint($arcresults));
wp_cache_add(array('wp_get_archives',false),$cache,array('general',false));
}else 
{{$arcresults = attachAspis($cache,$key[0]);
}}if ( $arcresults[0])
 {$afterafter = $after;
foreach ( deAspis(array_cast($arcresults)) as $arcresult  )
{$url = get_day_link($arcresult[0]->year,$arcresult[0]->month,$arcresult[0]->dayofmonth);
$date = Aspis_sprintf(array('%1$d-%2$02d-%3$02d 00:00:00',false),$arcresult[0]->year,$arcresult[0]->month,$arcresult[0]->dayofmonth);
$text = mysql2date($archive_day_date_format,$date);
if ( $show_post_count[0])
 $after = concat(concat2(concat1('&nbsp;(',$arcresult[0]->posts),')'),$afterafter);
$output = concat($output,get_archives_link($url,$text,$format,$before,$after));
}}}elseif ( (('weekly') == $type[0]))
 {$start_of_week = get_option(array('start_of_week',false));
$query = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT DISTINCT WEEK(post_date, ",$start_of_week),") AS `week`, YEAR(post_date) AS yr, DATE_FORMAT(post_date, '%Y-%m-%d') AS yyyymmdd, count(ID) as posts FROM "),$wpdb[0]->posts)," "),$join)," "),$where)," GROUP BY WEEK(post_date, "),$start_of_week),"), YEAR(post_date) ORDER BY post_date DESC "),$limit);
$key = attAspis(md5($query[0]));
$cache = wp_cache_get(array('wp_get_archives',false),array('general',false));
if ( (!((isset($cache[0][$key[0]]) && Aspis_isset( $cache [0][$key[0]])))))
 {$arcresults = $wpdb[0]->get_results($query);
arrayAssign($cache[0],deAspis(registerTaint($key)),addTaint($arcresults));
wp_cache_add(array('wp_get_archives',false),$cache,array('general',false));
}else 
{{$arcresults = attachAspis($cache,$key[0]);
}}$arc_w_last = array('',false);
$afterafter = $after;
if ( $arcresults[0])
 {foreach ( deAspis(array_cast($arcresults)) as $arcresult  )
{if ( ($arcresult[0]->week[0] != $arc_w_last[0]))
 {$arc_year = $arcresult[0]->yr;
$arc_w_last = $arcresult[0]->week;
$arc_week = get_weekstartend($arcresult[0]->yyyymmdd,get_option(array('start_of_week',false)));
$arc_week_start = date_i18n($archive_week_start_date_format,$arc_week[0]['start']);
$arc_week_end = date_i18n($archive_week_end_date_format,$arc_week[0]['end']);
$url = Aspis_sprintf(array('%1$s/%2$s%3$sm%4$s%5$s%6$sw%7$s%8$d',false),get_option(array('home',false)),array('',false),array('?',false),array('=',false),$arc_year,array('&amp;',false),array('=',false),$arcresult[0]->week);
$text = concat(concat($arc_week_start,$archive_week_separator),$arc_week_end);
if ( $show_post_count[0])
 $after = concat(concat2(concat1('&nbsp;(',$arcresult[0]->posts),')'),$afterafter);
$output = concat($output,get_archives_link($url,$text,$format,$before,$after));
}}}}elseif ( ((('postbypost') == $type[0]) || (('alpha') == $type[0])))
 {$orderby = (('alpha') == $type[0]) ? array("post_title ASC ",false) : array("post_date DESC ",false);
$query = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," "),$join)," "),$where)," ORDER BY "),$orderby)," "),$limit);
$key = attAspis(md5($query[0]));
$cache = wp_cache_get(array('wp_get_archives',false),array('general',false));
if ( (!((isset($cache[0][$key[0]]) && Aspis_isset( $cache [0][$key[0]])))))
 {$arcresults = $wpdb[0]->get_results($query);
arrayAssign($cache[0],deAspis(registerTaint($key)),addTaint($arcresults));
wp_cache_add(array('wp_get_archives',false),$cache,array('general',false));
}else 
{{$arcresults = attachAspis($cache,$key[0]);
}}if ( $arcresults[0])
 {foreach ( deAspis(array_cast($arcresults)) as $arcresult  )
{if ( ($arcresult[0]->post_date[0] != ('0000-00-00 00:00:00')))
 {$url = get_permalink($arcresult);
$arc_title = $arcresult[0]->post_title;
if ( $arc_title[0])
 $text = Aspis_strip_tags(apply_filters(array('the_title',false),$arc_title));
else 
{$text = $arcresult[0]->ID;
}$output = concat($output,get_archives_link($url,$text,$format,$before,$after));
}}}}if ( $echo[0])
 echo AspisCheckPrint($output);
else 
{return $output;
} }
function calendar_week_mod ( $num ) {
$base = array(7,false);
return (array($num[0] - ($base[0] * floor(($num[0] / $base[0]))),false));
 }
function get_calendar ( $initial = array(true,false) ) {
global $wpdb,$m,$monthnum,$year,$wp_locale,$posts;
$cache = array(array(),false);
$key = attAspis(md5((deconcat(concat($m,$monthnum),$year))));
if ( deAspis($cache = wp_cache_get(array('get_calendar',false),array('calendar',false))))
 {if ( (is_array($cache[0]) && ((isset($cache[0][$key[0]]) && Aspis_isset( $cache [0][$key[0]])))))
 {echo AspisCheckPrint(attachAspis($cache,$key[0]));
return ;
}}if ( (!(is_array($cache[0]))))
 $cache = array(array(),false);
if ( (denot_boolean($posts)))
 {$gotsome = $wpdb[0]->get_var(concat2(concat1("SELECT 1 as test FROM ",$wpdb[0]->posts)," WHERE post_type = 'post' AND post_status = 'publish' LIMIT 1"));
if ( (denot_boolean($gotsome)))
 {arrayAssign($cache[0],deAspis(registerTaint($key)),addTaint(array('',false)));
wp_cache_set(array('get_calendar',false),$cache,array('calendar',false));
return ;
}}ob_start();
if ( ((isset($_GET[0][('w')]) && Aspis_isset( $_GET [0][('w')]))))
 $w = concat1('',Aspis_intval($_GET[0]['w']));
$week_begins = Aspis_intval(get_option(array('start_of_week',false)));
if ( ((!((empty($monthnum) || Aspis_empty( $monthnum)))) && (!((empty($year) || Aspis_empty( $year))))))
 {$thismonth = concat1('',zeroise(Aspis_intval($monthnum),array(2,false)));
$thisyear = concat1('',Aspis_intval($year));
}elseif ( (!((empty($w) || Aspis_empty( $w)))))
 {$thisyear = concat1('',Aspis_intval(Aspis_substr($m,array(0,false),array(4,false))));
$d = array((($w[0] - (1)) * (7)) + (6),false);
$thismonth = $wpdb[0]->get_var(concat2(concat(concat2(concat1("SELECT DATE_FORMAT((DATE_ADD('",$thisyear),"0101', INTERVAL "),$d)," DAY) ), '%m')"));
}elseif ( (!((empty($m) || Aspis_empty( $m)))))
 {$thisyear = concat1('',Aspis_intval(Aspis_substr($m,array(0,false),array(4,false))));
if ( (strlen($m[0]) < (6)))
 $thismonth = array('01',false);
else 
{$thismonth = concat1('',zeroise(Aspis_intval(Aspis_substr($m,array(4,false),array(2,false))),array(2,false)));
}}else 
{{$thisyear = attAspis(gmdate(('Y'),deAspis(current_time(array('timestamp',false)))));
$thismonth = attAspis(gmdate(('m'),deAspis(current_time(array('timestamp',false)))));
}}$unixmonth = attAspis(mktime((0),(0),(0),$thismonth[0],(1),$thisyear[0]));
$previous = $wpdb[0]->get_row(concat2(concat(concat2(concat(concat2(concat1("SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM ",$wpdb[0]->posts),"
		WHERE post_date < '"),$thisyear),"-"),$thismonth),"-01'
		AND post_type = 'post' AND post_status = 'publish'
			ORDER BY post_date DESC
			LIMIT 1"));
$next = $wpdb[0]->get_row(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT	DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM ",$wpdb[0]->posts),"
		WHERE post_date >	'"),$thisyear),"-"),$thismonth),"-01'
		AND MONTH( post_date ) != MONTH( '"),$thisyear),"-"),$thismonth),"-01' )
		AND post_type = 'post' AND post_status = 'publish'
			ORDER	BY post_date ASC
			LIMIT 1"));
$calendar_caption = _x(array('%1$s %2$s',false),array('calendar caption',false));
echo AspisCheckPrint(concat2(concat(concat2(concat1('<table id="wp-calendar" summary="',esc_attr__(array('Calendar',false))),'">
	<caption>'),Aspis_sprintf($calendar_caption,$wp_locale[0]->get_month($thismonth),attAspis(date(('Y'),$unixmonth[0])))),'</caption>
	<thead>
	<tr>'));
$myweek = array(array(),false);
for ( $wdcount = array(0,false) ; ($wdcount[0] <= (6)) ; postincr($wdcount) )
{arrayAssignAdd($myweek[0][],addTaint($wp_locale[0]->get_weekday(array(($wdcount[0] + $week_begins[0]) % (7),false))));
}foreach ( $myweek[0] as $wd  )
{$day_name = (true == $initial[0]) ? $wp_locale[0]->get_weekday_initial($wd) : $wp_locale[0]->get_weekday_abbrev($wd);
$wd = esc_attr($wd);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1("\n\t\t<th abbr=\"",$wd),"\" scope=\"col\" title=\""),$wd),"\">"),$day_name),"</th>"));
}echo AspisCheckPrint(array('
	</tr>
	</thead>

	<tfoot>
	<tr>',false));
if ( $previous[0])
 {echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat12("\n\t\t",'<td abbr="'),$wp_locale[0]->get_month($previous[0]->month)),'" colspan="3" id="prev"><a href="'),get_month_link($previous[0]->year,$previous[0]->month)),'" title="'),Aspis_sprintf(__(array('View posts for %1$s %2$s',false)),$wp_locale[0]->get_month($previous[0]->month),attAspis(date(('Y'),mktime((0),(0),(0),$previous[0]->month[0],(1),$previous[0]->year[0]))))),'">&laquo; '),$wp_locale[0]->get_month_abbrev($wp_locale[0]->get_month($previous[0]->month))),'</a></td>'));
}else 
{{echo AspisCheckPrint(concat12("\n\t\t",'<td colspan="3" id="prev" class="pad">&nbsp;</td>'));
}}echo AspisCheckPrint(concat12("\n\t\t",'<td class="pad">&nbsp;</td>'));
if ( $next[0])
 {echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat12("\n\t\t",'<td abbr="'),$wp_locale[0]->get_month($next[0]->month)),'" colspan="3" id="next"><a href="'),get_month_link($next[0]->year,$next[0]->month)),'" title="'),esc_attr(Aspis_sprintf(__(array('View posts for %1$s %2$s',false)),$wp_locale[0]->get_month($next[0]->month),attAspis(date(('Y'),mktime((0),(0),(0),$next[0]->month[0],(1),$next[0]->year[0])))))),'">'),$wp_locale[0]->get_month_abbrev($wp_locale[0]->get_month($next[0]->month))),' &raquo;</a></td>'));
}else 
{{echo AspisCheckPrint(concat12("\n\t\t",'<td colspan="3" id="next" class="pad">&nbsp;</td>'));
}}echo AspisCheckPrint(array('
	</tr>
	</tfoot>

	<tbody>
	<tr>',false));
$dayswithposts = $wpdb[0]->get_results(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT DISTINCT DAYOFMONTH(post_date)
		FROM ",$wpdb[0]->posts)," WHERE MONTH(post_date) = '"),$thismonth),"'
		AND YEAR(post_date) = '"),$thisyear),"'
		AND post_type = 'post' AND post_status = 'publish'
		AND post_date < '"),current_time(array('mysql',false))),'\''),array(ARRAY_N,false));
if ( $dayswithposts[0])
 {foreach ( deAspis(array_cast($dayswithposts)) as $daywith  )
{arrayAssignAdd($daywithpost[0][],addTaint(attachAspis($daywith,(0))));
}}else 
{{$daywithpost = array(array(),false);
}}if ( (((strpos(deAspis($_SERVER[0]['HTTP_USER_AGENT']),'MSIE') !== false) || (strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_USER_AGENT'])),'camino') !== false)) || (strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_USER_AGENT'])),'safari') !== false)))
 $ak_title_separator = array("\n",false);
else 
{$ak_title_separator = array(', ',false);
}$ak_titles_for_day = array(array(),false);
$ak_post_titles = $wpdb[0]->get_results(concat2(concat2(concat(concat2(concat(concat(concat1("SELECT post_title, DAYOFMONTH(post_date) as dom ",concat2(concat1("FROM ",$wpdb[0]->posts)," ")),concat2(concat1("WHERE YEAR(post_date) = '",$thisyear),"' ")),concat2(concat1("AND MONTH(post_date) = '",$thismonth),"' ")),"AND post_date < '"),current_time(array('mysql',false))),"' "),"AND post_type = 'post' AND post_status = 'publish'"));
if ( $ak_post_titles[0])
 {foreach ( deAspis(array_cast($ak_post_titles)) as $ak_post_title  )
{$post_title = esc_attr(apply_filters(array('the_title',false),$ak_post_title[0]->post_title));
if ( ((empty($ak_titles_for_day[0][(deconcat1('day_',$ak_post_title[0]->dom))]) || Aspis_empty( $ak_titles_for_day [0][(deconcat1('day_',$ak_post_title[0] ->dom ))]))))
 arrayAssign($ak_titles_for_day[0],deAspis(registerTaint(concat1('day_',$ak_post_title[0]->dom))),addTaint(array('',false)));
if ( ((empty($ak_titles_for_day[0][$ak_post_title[0]->dom[0]]) || Aspis_empty( $ak_titles_for_day [0][ $ak_post_title[0]->dom[0]]))))
 arrayAssign($ak_titles_for_day[0],deAspis(registerTaint($ak_post_title[0]->dom)),addTaint($post_title));
else 
{arrayAssign($ak_titles_for_day[0],deAspis(registerTaint($ak_post_title[0]->dom)),addTaint(concat(attachAspis($ak_titles_for_day,$ak_post_title[0]->dom[0]),concat($ak_title_separator,$post_title))));
}}}$pad = calendar_week_mod(array(date(('w'),$unixmonth[0]) - $week_begins[0],false));
if ( ((0) != $pad[0]))
 echo AspisCheckPrint(concat2(concat(concat12("\n\t\t",'<td colspan="'),esc_attr($pad)),'" class="pad">&nbsp;</td>'));
$daysinmonth = Aspis_intval(attAspis(date(('t'),$unixmonth[0])));
for ( $day = array(1,false) ; ($day[0] <= $daysinmonth[0]) ; preincr($day) )
{if ( (((isset($newrow) && Aspis_isset( $newrow))) && $newrow[0]))
 echo AspisCheckPrint(array("\n\t</tr>\n\t<tr>\n\t\t",false));
$newrow = array(false,false);
if ( ((($day[0] == gmdate(('j'),(time() + (deAspis(get_option(array('gmt_offset',false))) * (3600))))) && ($thismonth[0] == gmdate(('m'),(time() + (deAspis(get_option(array('gmt_offset',false))) * (3600)))))) && ($thisyear[0] == gmdate(('Y'),(time() + (deAspis(get_option(array('gmt_offset',false))) * (3600)))))))
 echo AspisCheckPrint(array('<td id="today">',false));
else 
{echo AspisCheckPrint(array('<td>',false));
}if ( deAspis(Aspis_in_array($day,$daywithpost)))
 echo AspisCheckPrint(concat(concat(concat2(concat1('<a href="',get_day_link($thisyear,$thismonth,$day)),"\" title=\""),esc_attr(attachAspis($ak_titles_for_day,$day[0]))),concat2(concat1("\">",$day),"</a>")));
else 
{echo AspisCheckPrint($day);
}echo AspisCheckPrint(array('</td>',false));
if ( ((6) == deAspis(calendar_week_mod(array(date(('w'),mktime((0),(0),(0),$thismonth[0],$day[0],$thisyear[0])) - $week_begins[0],false)))))
 $newrow = array(true,false);
}$pad = array((7) - deAspis(calendar_week_mod(array(date(('w'),mktime((0),(0),(0),$thismonth[0],$day[0],$thisyear[0])) - $week_begins[0],false))),false);
if ( (($pad[0] != (0)) && ($pad[0] != (7))))
 echo AspisCheckPrint(concat2(concat(concat12("\n\t\t",'<td class="pad" colspan="'),esc_attr($pad)),'">&nbsp;</td>'));
echo AspisCheckPrint(array("\n\t</tr>\n\t</tbody>\n\t</table>",false));
$output = attAspis(ob_get_contents());
ob_end_clean();
echo AspisCheckPrint($output);
arrayAssign($cache[0],deAspis(registerTaint($key)),addTaint($output));
wp_cache_set(array('get_calendar',false),$cache,array('calendar',false));
 }
function delete_get_calendar_cache (  ) {
wp_cache_delete(array('get_calendar',false),array('calendar',false));
 }
add_action(array('save_post',false),array('delete_get_calendar_cache',false));
add_action(array('delete_post',false),array('delete_get_calendar_cache',false));
add_action(array('update_option_start_of_week',false),array('delete_get_calendar_cache',false));
add_action(array('update_option_gmt_offset',false),array('delete_get_calendar_cache',false));
function allowed_tags (  ) {
global $allowedtags;
$allowed = array('',false);
foreach ( deAspis(array_cast($allowedtags)) as $tag =>$attributes )
{restoreTaint($tag,$attributes);
{$allowed = concat($allowed,concat1('<',$tag));
if ( ((0) < count($attributes[0])))
 {foreach ( $attributes[0] as $attribute =>$limits )
{restoreTaint($attribute,$limits);
{$allowed = concat($allowed,concat2(concat1(' ',$attribute),'=""'));
}}}$allowed = concat2($allowed,'> ');
}}return Aspis_htmlentities($allowed);
 }
function the_date_xml (  ) {
global $post;
echo AspisCheckPrint(mysql2date(array('Y-m-d',false),$post[0]->post_date,array(false,false)));
 }
function the_date ( $d = array('',false),$before = array('',false),$after = array('',false),$echo = array(true,false) ) {
global $post,$day,$previousday;
$the_date = array('',false);
if ( ($day[0] != $previousday[0]))
 {$the_date = concat($the_date,$before);
if ( ($d[0] == ('')))
 $the_date = concat($the_date,mysql2date(get_option(array('date_format',false)),$post[0]->post_date));
else 
{$the_date = concat($the_date,mysql2date($d,$post[0]->post_date));
}$the_date = concat($the_date,$after);
$previousday = $day;
$the_date = apply_filters(array('the_date',false),$the_date,$d,$before,$after);
if ( $echo[0])
 echo AspisCheckPrint($the_date);
else 
{return $the_date;
}} }
function the_modified_date ( $d = array('',false) ) {
echo AspisCheckPrint(apply_filters(array('the_modified_date',false),get_the_modified_date($d),$d));
 }
function get_the_modified_date ( $d = array('',false) ) {
if ( (('') == $d[0]))
 $the_time = get_post_modified_time(get_option(array('date_format',false)),array(null,false),array(null,false),array(true,false));
else 
{$the_time = get_post_modified_time($d,array(null,false),array(null,false),array(true,false));
}return apply_filters(array('get_the_modified_date',false),$the_time,$d);
 }
function the_time ( $d = array('',false) ) {
echo AspisCheckPrint(apply_filters(array('the_time',false),get_the_time($d),$d));
 }
function get_the_time ( $d = array('',false),$post = array(null,false) ) {
$post = get_post($post);
if ( (('') == $d[0]))
 $the_time = get_post_time(get_option(array('time_format',false)),array(false,false),$post,array(true,false));
else 
{$the_time = get_post_time($d,array(false,false),$post,array(true,false));
}return apply_filters(array('get_the_time',false),$the_time,$d,$post);
 }
function get_post_time ( $d = array('U',false),$gmt = array(false,false),$post = array(null,false),$translate = array(false,false) ) {
$post = get_post($post);
if ( $gmt[0])
 $time = $post[0]->post_date_gmt;
else 
{$time = $post[0]->post_date;
}$time = mysql2date($d,$time,$translate);
return apply_filters(array('get_post_time',false),$time,$d,$gmt);
 }
function the_modified_time ( $d = array('',false) ) {
echo AspisCheckPrint(apply_filters(array('the_modified_time',false),get_the_modified_time($d),$d));
 }
function get_the_modified_time ( $d = array('',false) ) {
if ( (('') == $d[0]))
 $the_time = get_post_modified_time(get_option(array('time_format',false)),array(null,false),array(null,false),array(true,false));
else 
{$the_time = get_post_modified_time($d,array(null,false),array(null,false),array(true,false));
}return apply_filters(array('get_the_modified_time',false),$the_time,$d);
 }
function get_post_modified_time ( $d = array('U',false),$gmt = array(false,false),$post = array(null,false),$translate = array(false,false) ) {
$post = get_post($post);
if ( $gmt[0])
 $time = $post[0]->post_modified_gmt;
else 
{$time = $post[0]->post_modified;
}$time = mysql2date($d,$time,$translate);
return apply_filters(array('get_post_modified_time',false),$time,$d,$gmt);
 }
function the_weekday (  ) {
global $wp_locale,$post;
$the_weekday = $wp_locale[0]->get_weekday(mysql2date(array('w',false),$post[0]->post_date,array(false,false)));
$the_weekday = apply_filters(array('the_weekday',false),$the_weekday);
echo AspisCheckPrint($the_weekday);
 }
function the_weekday_date ( $before = array('',false),$after = array('',false) ) {
global $wp_locale,$post,$day,$previousweekday;
$the_weekday_date = array('',false);
if ( ($day[0] != $previousweekday[0]))
 {$the_weekday_date = concat($the_weekday_date,$before);
$the_weekday_date = concat($the_weekday_date,$wp_locale[0]->get_weekday(mysql2date(array('w',false),$post[0]->post_date,array(false,false))));
$the_weekday_date = concat($the_weekday_date,$after);
$previousweekday = $day;
}$the_weekday_date = apply_filters(array('the_weekday_date',false),$the_weekday_date,$before,$after);
echo AspisCheckPrint($the_weekday_date);
 }
function wp_head (  ) {
do_action(array('wp_head',false));
 }
function wp_footer (  ) {
do_action(array('wp_footer',false));
 }
function automatic_feed_links ( $add = array(true,false) ) {
if ( $add[0])
 add_action(array('wp_head',false),array('feed_links',false),array(2,false));
else 
{{remove_action(array('wp_head',false),array('feed_links',false),array(2,false));
remove_action(array('wp_head',false),array('feed_links_extra',false),array(3,false));
}} }
function feed_links ( $args ) {
$defaults = array(array(deregisterTaint(array('separator',false)) => addTaint(_x(array('&raquo;',false),array('feed link',false))),deregisterTaint(array('feedtitle',false)) => addTaint(__(array('%1$s %2$s Feed',false))),deregisterTaint(array('comstitle',false)) => addTaint(__(array('%1$s %2$s Comments Feed',false))),),false);
$args = wp_parse_args($args,$defaults);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1('<link rel="alternate" type="',feed_content_type()),'" title="'),esc_attr(Aspis_sprintf($args[0]['feedtitle'],get_bloginfo(array('name',false)),$args[0]['separator']))),'" href="'),get_feed_link()),"\" />\n"));
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1('<link rel="alternate" type="',feed_content_type()),'" title="'),esc_attr(Aspis_sprintf($args[0]['comstitle'],get_bloginfo(array('name',false)),$args[0]['separator']))),'" href="'),get_feed_link(concat1('comments_',get_default_feed()))),"\" />\n"));
 }
function feed_links_extra ( $args ) {
$defaults = array(array(deregisterTaint(array('separator',false)) => addTaint(_x(array('&raquo;',false),array('feed link',false))),deregisterTaint(array('singletitle',false)) => addTaint(__(array('%1$s %2$s %3$s Comments Feed',false))),deregisterTaint(array('cattitle',false)) => addTaint(__(array('%1$s %2$s %3$s Category Feed',false))),deregisterTaint(array('tagtitle',false)) => addTaint(__(array('%1$s %2$s %3$s Tag Feed',false))),deregisterTaint(array('authortitle',false)) => addTaint(__(array('%1$s %2$s Posts by %3$s Feed',false))),deregisterTaint(array('searchtitle',false)) => addTaint(__(array('%1$s %2$s Search Results for &#8220;%3$s&#8221; Feed',false))),),false);
$args = wp_parse_args($args,$defaults);
if ( (deAspis(is_single()) || deAspis(is_page())))
 {$post = &get_post($id = array(0,false));
if ( ((deAspis(comments_open()) || deAspis(pings_open())) || ($post[0]->comment_count[0] > (0))))
 {$title = esc_attr(Aspis_sprintf($args[0]['singletitle'],get_bloginfo(array('name',false)),$args[0]['separator'],esc_html(get_the_title())));
$href = get_post_comments_feed_link($post[0]->ID);
}}elseif ( deAspis(is_category()))
 {$cat_id = Aspis_intval(get_query_var(array('cat',false)));
$title = esc_attr(Aspis_sprintf($args[0]['cattitle'],get_bloginfo(array('name',false)),$args[0]['separator'],get_cat_name($cat_id)));
$href = get_category_feed_link($cat_id);
}elseif ( deAspis(is_tag()))
 {$tag_id = Aspis_intval(get_query_var(array('tag_id',false)));
$tag = get_tag($tag_id);
$title = esc_attr(Aspis_sprintf($args[0]['tagtitle'],get_bloginfo(array('name',false)),$args[0]['separator'],$tag[0]->name));
$href = get_tag_feed_link($tag_id);
}elseif ( deAspis(is_author()))
 {$author_id = Aspis_intval(get_query_var(array('author',false)));
$title = esc_attr(Aspis_sprintf($args[0]['authortitle'],get_bloginfo(array('name',false)),$args[0]['separator'],get_the_author_meta(array('display_name',false),$author_id)));
$href = get_author_feed_link($author_id);
}elseif ( deAspis(is_search()))
 {$title = esc_attr(Aspis_sprintf($args[0]['searchtitle'],get_bloginfo(array('name',false)),$args[0]['separator'],get_search_query()));
$href = get_search_feed_link();
}if ( (((isset($title) && Aspis_isset( $title))) && ((isset($href) && Aspis_isset( $href)))))
 echo AspisCheckPrint(concat2(concat2(concat(concat2(concat(concat2(concat1('<link rel="alternate" type="',feed_content_type()),'" title="'),$title),'" href="'),$href),'" />'),"\n"));
 }
function rsd_link (  ) {
echo AspisCheckPrint(concat2(concat1('<link rel="EditURI" type="application/rsd+xml" title="RSD" href="',get_bloginfo(array('wpurl',false))),"/xmlrpc.php?rsd\" />\n"));
 }
function wlwmanifest_link (  ) {
echo AspisCheckPrint(concat2(concat2(concat1('<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="',get_bloginfo(array('wpurl',false))),'/wp-includes/wlwmanifest.xml" /> '),"\n"));
 }
function noindex (  ) {
if ( (('0') == deAspis(get_option(array('blog_public',false)))))
 echo AspisCheckPrint(array("<meta name='robots' content='noindex,nofollow' />\n",false));
 }
function rich_edit_exists (  ) {
global $wp_rich_edit_exists;
if ( (!((isset($wp_rich_edit_exists) && Aspis_isset( $wp_rich_edit_exists)))))
 $wp_rich_edit_exists = attAspis(file_exists((deconcat2(concat12(ABSPATH,WPINC),'/js/tinymce/tiny_mce.js'))));
return $wp_rich_edit_exists;
 }
function user_can_richedit (  ) {
global $wp_rich_edit,$pagenow;
if ( (!((isset($wp_rich_edit) && Aspis_isset( $wp_rich_edit)))))
 {if ( (((deAspis(get_user_option(array('rich_editing',false))) == ('true')) && ((deAspis(Aspis_preg_match(array('!AppleWebKit/(\d+)!',false),$_SERVER[0]['HTTP_USER_AGENT'],$match)) && (deAspis(Aspis_intval(attachAspis($match,(1)))) >= (420))) || (denot_boolean(Aspis_preg_match(array('!opera[ /][2-8]|konqueror|safari!i',false),$_SERVER[0]['HTTP_USER_AGENT']))))) && (('comment.php') != $pagenow[0])))
 {$wp_rich_edit = array(true,false);
}else 
{{$wp_rich_edit = array(false,false);
}}}return apply_filters(array('user_can_richedit',false),$wp_rich_edit);
 }
function wp_default_editor (  ) {
$r = deAspis(user_can_richedit()) ? array('tinymce',false) : array('html',false);
if ( deAspis($user = wp_get_current_user()))
 {$ed = get_user_setting(array('editor',false),array('tinymce',false));
$r = deAspis((Aspis_in_array($ed,array(array(array('tinymce',false),array('html',false),array('test',false)),false)))) ? $ed : $r;
}return apply_filters(array('wp_default_editor',false),$r);
 }
function the_editor ( $content,$id = array('content',false),$prev_id = array('title',false),$media_buttons = array(true,false),$tab_index = array(2,false) ) {
$rows = get_option(array('default_post_edit_rows',false));
if ( (($rows[0] < (3)) || ($rows[0] > (100))))
 $rows = array(12,false);
if ( (denot_boolean(current_user_can(array('upload_files',false)))))
 $media_buttons = array(false,false);
$richedit = user_can_richedit();
$class = array('',false);
if ( ($richedit[0] || $media_buttons[0]))
 {;
?>
	<div id="editor-toolbar">
<?php if ( $richedit[0])
 {$wp_default_editor = wp_default_editor();
;
?>
		<div class="zerosize"><input accesskey="e" type="button" onclick="switchEditors.go('<?php echo AspisCheckPrint($id);
;
?>')" /></div>
<?php if ( (('html') == $wp_default_editor[0]))
 {add_filter(array('the_editor_content',false),array('wp_htmledit_pre',false));
;
?>
			<a id="edButtonHTML" class="active hide-if-no-js" onclick="switchEditors.go('<?php echo AspisCheckPrint($id);
;
?>', 'html');"><?php _e(array('HTML',false));
;
?></a>
			<a id="edButtonPreview" class="hide-if-no-js" onclick="switchEditors.go('<?php echo AspisCheckPrint($id);
;
?>', 'tinymce');"><?php _e(array('Visual',false));
;
?></a>
<?php }else 
{{$class = array(" class='theEditor'",false);
add_filter(array('the_editor_content',false),array('wp_richedit_pre',false));
;
?>
			<a id="edButtonHTML" class="hide-if-no-js" onclick="switchEditors.go('<?php echo AspisCheckPrint($id);
;
?>', 'html');"><?php _e(array('HTML',false));
;
?></a>
			<a id="edButtonPreview" class="active hide-if-no-js" onclick="switchEditors.go('<?php echo AspisCheckPrint($id);
;
?>', 'tinymce');"><?php _e(array('Visual',false));
;
?></a>
<?php }}}if ( $media_buttons[0])
 {;
?>
		<div id="media-buttons" class="hide-if-no-js">
<?php do_action(array('media_buttons',false));
;
?>
		</div>
<?php };
?>
	</div>
<?php };
?>
	<div id="quicktags"><?php wp_print_scripts(array('quicktags',false));
;
?>
	<script type="text/javascript">edToolbar()</script>
	</div>

<?php $the_editor = apply_filters(array('the_editor',false),concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<div id='editorcontainer'><textarea rows='",$rows),"'"),$class)," cols='40' name='"),$id),"' tabindex='"),$tab_index),"' id='"),$id),"'>%s</textarea></div>\n"));
$the_editor_content = apply_filters(array('the_editor_content',false),$content);
printf($the_editor[0],deAspisRC($the_editor_content));
;
?>
	<script type="text/javascript">
	edCanvas = document.getElementById('<?php echo AspisCheckPrint($id);
;
?>');
	</script>
<?php  }
function get_search_query (  ) {
return apply_filters(array('get_search_query',false),get_query_var(array('s',false)));
 }
function the_search_query (  ) {
echo AspisCheckPrint(esc_attr(apply_filters(array('the_search_query',false),get_search_query())));
 }
function language_attributes ( $doctype = array('html',false) ) {
$attributes = array(array(),false);
$output = array('',false);
if ( deAspis($dir = get_bloginfo(array('text_direction',false))))
 arrayAssignAdd($attributes[0][],addTaint(concat2(concat1("dir=\"",$dir),"\"")));
if ( deAspis($lang = get_bloginfo(array('language',false))))
 {if ( ((deAspis(get_option(array('html_type',false))) == ('text/html')) || ($doctype[0] == ('html'))))
 arrayAssignAdd($attributes[0][],addTaint(concat2(concat1("lang=\"",$lang),"\"")));
if ( ((deAspis(get_option(array('html_type',false))) != ('text/html')) || ($doctype[0] == ('xhtml'))))
 arrayAssignAdd($attributes[0][],addTaint(concat2(concat1("xml:lang=\"",$lang),"\"")));
}$output = Aspis_implode(array(' ',false),$attributes);
$output = apply_filters(array('language_attributes',false),$output);
echo AspisCheckPrint($output);
 }
function paginate_links ( $args = array('',false) ) {
$defaults = array(array('base' => array('%_%',false,false),'format' => array('?page=%#%',false,false),'total' => array(1,false,false),'current' => array(0,false,false),'show_all' => array(false,false,false),'prev_next' => array(true,false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo; Previous',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('Next &raquo;',false))),'end_size' => array(1,false,false),'mid_size' => array(2,false,false),'type' => array('plain',false,false),'add_args' => array(false,false,false),'add_fragment' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
extract(($args[0]),EXTR_SKIP);
$total = int_cast($total);
if ( ($total[0] < (2)))
 return ;
$current = int_cast($current);
$end_size = ((0) < deAspis(int_cast($end_size))) ? int_cast($end_size) : array(1,false);
$mid_size = ((0) <= deAspis(int_cast($mid_size))) ? int_cast($mid_size) : array(2,false);
$add_args = is_array($add_args[0]) ? $add_args : array(false,false);
$r = array('',false);
$page_links = array(array(),false);
$n = array(0,false);
$dots = array(false,false);
if ( (($prev_next[0] && $current[0]) && ((1) < $current[0])))
 {$link = Aspis_str_replace(array('%_%',false),((2) == $current[0]) ? array('',false) : $format,$base);
$link = Aspis_str_replace(array('%#%',false),array($current[0] - (1),false),$link);
if ( $add_args[0])
 $link = add_query_arg($add_args,$link);
$link = concat($link,$add_fragment);
arrayAssignAdd($page_links[0][],addTaint(concat(concat1("<a class='prev page-numbers' href='",esc_url($link)),concat2(concat1("'>",$prev_text),"</a>"))));
}for ( $n = array(1,false) ; ($n[0] <= $total[0]) ; postincr($n) )
{$n_display = number_format_i18n($n);
if ( ($n[0] == $current[0]))
 {arrayAssignAdd($page_links[0][],addTaint(concat2(concat1("<span class='page-numbers current'>",$n_display),"</span>")));
$dots = array(true,false);
}else 
{if ( ($show_all[0] || ((($n[0] <= $end_size[0]) || (($current[0] && ($n[0] >= ($current[0] - $mid_size[0]))) && ($n[0] <= ($current[0] + $mid_size[0])))) || ($n[0] > ($total[0] - $end_size[0])))))
 {$link = Aspis_str_replace(array('%_%',false),((1) == $n[0]) ? array('',false) : $format,$base);
$link = Aspis_str_replace(array('%#%',false),$n,$link);
if ( $add_args[0])
 $link = add_query_arg($add_args,$link);
$link = concat($link,$add_fragment);
arrayAssignAdd($page_links[0][],addTaint(concat(concat1("<a class='page-numbers' href='",esc_url($link)),concat2(concat1("'>",$n_display),"</a>"))));
$dots = array(true,false);
}elseif ( ($dots[0] && (denot_boolean($show_all))))
 {arrayAssignAdd($page_links[0][],addTaint(array("<span class='page-numbers dots'>...</span>",false)));
$dots = array(false,false);
}}}if ( (($prev_next[0] && $current[0]) && (($current[0] < $total[0]) || (deAspis(negate(array(1,false))) == $total[0]))))
 {$link = Aspis_str_replace(array('%_%',false),$format,$base);
$link = Aspis_str_replace(array('%#%',false),array($current[0] + (1),false),$link);
if ( $add_args[0])
 $link = add_query_arg($add_args,$link);
$link = concat($link,$add_fragment);
arrayAssignAdd($page_links[0][],addTaint(concat(concat1("<a class='next page-numbers' href='",esc_url($link)),concat2(concat1("'>",$next_text),"</a>"))));
}switch ( $type[0] ) {
case ('array'):return $page_links;
break ;
;
case ('list'):$r = concat2($r,"<ul class='page-numbers'>\n\t<li>");
$r = concat($r,Aspis_join(array("</li>\n\t<li>",false),$page_links));
$r = concat2($r,"</li>\n</ul>\n");
break ;
default :$r = Aspis_join(array("\n",false),$page_links);
break ;
 }
return $r;
 }
function wp_admin_css_color ( $key,$name,$url,$colors = array(array(),false) ) {
global $_wp_admin_css_colors;
if ( (!((isset($_wp_admin_css_colors) && Aspis_isset( $_wp_admin_css_colors)))))
 $_wp_admin_css_colors = array(array(),false);
arrayAssign($_wp_admin_css_colors[0],deAspis(registerTaint($key)),addTaint(object_cast(array(array(deregisterTaint(array('name',false)) => addTaint($name),deregisterTaint(array('url',false)) => addTaint($url),deregisterTaint(array('colors',false)) => addTaint($colors)),false))));
 }
function wp_admin_css_uri ( $file = array('wp-admin',false) ) {
if ( defined(('WP_INSTALLING')))
 {$_file = concat2(concat1("./",$file),".css");
}else 
{{$_file = admin_url(concat2($file,".css"));
}}$_file = add_query_arg(array('version',false),get_bloginfo(array('version',false)),$_file);
return apply_filters(array('wp_admin_css_uri',false),$_file,$file);
 }
function wp_admin_css ( $file = array('wp-admin',false),$force_echo = array(false,false) ) {
global $wp_styles;
if ( (!(is_a(deAspisRC($wp_styles),('WP_Styles')))))
 $wp_styles = array(new WP_Styles(),false);
$handle = ((0) === strpos($file[0],'css/')) ? Aspis_substr($file,array(4,false)) : $file;
if ( deAspis($wp_styles[0]->query($handle)))
 {if ( ($force_echo[0] || deAspis(did_action(array('wp_print_styles',false)))))
 wp_print_styles($handle);
else 
{wp_enqueue_style($handle);
}return ;
}echo AspisCheckPrint(apply_filters(array('wp_admin_css',false),concat2(concat1("<link rel='stylesheet' href='",esc_url(wp_admin_css_uri($file))),"' type='text/css' />\n"),$file));
if ( (('rtl') == deAspis(get_bloginfo(array('text_direction',false)))))
 echo AspisCheckPrint(apply_filters(array('wp_admin_css',false),concat2(concat1("<link rel='stylesheet' href='",esc_url(wp_admin_css_uri(concat2($file,"-rtl")))),"' type='text/css' />\n"),concat2($file,"-rtl")));
 }
function add_thickbox (  ) {
wp_enqueue_script(array('thickbox',false));
wp_enqueue_style(array('thickbox',false));
 }
function wp_generator (  ) {
the_generator(apply_filters(array('wp_generator_type',false),array('xhtml',false)));
 }
function the_generator ( $type ) {
echo AspisCheckPrint(concat2(apply_filters(array('the_generator',false),get_the_generator($type),$type),"\n"));
 }
function get_the_generator ( $type ) {
switch ( $type[0] ) {
case ('html'):$gen = concat2(concat1('<meta name="generator" content="WordPress ',get_bloginfo(array('version',false))),'">');
break ;
case ('xhtml'):$gen = concat2(concat1('<meta name="generator" content="WordPress ',get_bloginfo(array('version',false))),'" />');
break ;
case ('atom'):$gen = concat2(concat1('<generator uri="http://wordpress.org/" version="',get_bloginfo_rss(array('version',false))),'">WordPress</generator>');
break ;
case ('rss2'):$gen = concat2(concat1('<generator>http://wordpress.org/?v=',get_bloginfo_rss(array('version',false))),'</generator>');
break ;
case ('rdf'):$gen = concat2(concat1('<admin:generatorAgent rdf:resource="http://wordpress.org/?v=',get_bloginfo_rss(array('version',false))),'" />');
break ;
case ('comment'):$gen = concat2(concat1('<!-- generator="WordPress/',get_bloginfo(array('version',false))),'" -->');
break ;
case ('export'):$gen = concat2(concat(concat2(concat1('<!-- generator="WordPress/',get_bloginfo_rss(array('version',false))),'" created="'),attAspis(date(('Y-m-d H:i')))),'"-->');
break ;
 }
return apply_filters(concat1("get_the_generator_",$type),$gen,$type);
 }
;
