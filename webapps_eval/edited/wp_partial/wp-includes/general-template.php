<?php require_once('AspisMain.php'); ?><?php
function get_header ( $name = null ) {
do_action('get_header',$name);
$templates = array();
if ( isset($name))
 $templates[] = "header-{$name}.php";
$templates[] = "header.php";
if ( '' == locate_template($templates,true))
 load_template(get_theme_root() . '/default/header.php');
 }
function get_footer ( $name = null ) {
do_action('get_footer',$name);
$templates = array();
if ( isset($name))
 $templates[] = "footer-{$name}.php";
$templates[] = "footer.php";
if ( '' == locate_template($templates,true))
 load_template(get_theme_root() . '/default/footer.php');
 }
function get_sidebar ( $name = null ) {
do_action('get_sidebar',$name);
$templates = array();
if ( isset($name))
 $templates[] = "sidebar-{$name}.php";
$templates[] = "sidebar.php";
if ( '' == locate_template($templates,true))
 load_template(get_theme_root() . '/default/sidebar.php');
 }
function get_search_form (  ) {
do_action('get_search_form');
$search_form_template = locate_template(array('searchform.php'));
if ( '' != $search_form_template)
 {require ($search_form_template);
{return ;
}}$form = '<form role="search" method="get" id="searchform" action="' . get_option('home') . '/" >
	<div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
	<input type="text" value="' . esc_attr(apply_filters('the_search_query',get_search_query())) . '" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__('Search') . '" />
	</div>
	</form>';
echo apply_filters('get_search_form',$form);
 }
function wp_loginout ( $redirect = '' ) {
if ( !is_user_logged_in())
 $link = '<a href="' . esc_url(wp_login_url($redirect)) . '">' . __('Log in') . '</a>';
else 
{$link = '<a href="' . esc_url(wp_logout_url($redirect)) . '">' . __('Log out') . '</a>';
}echo apply_filters('loginout',$link);
 }
function wp_logout_url ( $redirect = '' ) {
$args = array('action' => 'logout');
if ( !empty($redirect))
 {$args['redirect_to'] = urlencode($redirect);
}$logout_url = add_query_arg($args,site_url('wp-login.php','login'));
$logout_url = wp_nonce_url($logout_url,'log-out');
{$AspisRetTemp = apply_filters('logout_url',$logout_url,$redirect);
return $AspisRetTemp;
} }
function wp_login_url ( $redirect = '' ) {
$login_url = site_url('wp-login.php','login');
if ( !empty($redirect))
 {$login_url = add_query_arg('redirect_to',urlencode($redirect),$login_url);
}{$AspisRetTemp = apply_filters('login_url',$login_url,$redirect);
return $AspisRetTemp;
} }
function wp_lostpassword_url ( $redirect = '' ) {
$args = array('action' => 'lostpassword');
if ( !empty($redirect))
 {$args['redirect_to'] = $redirect;
}$lostpassword_url = add_query_arg($args,site_url('wp-login.php','login'));
{$AspisRetTemp = apply_filters('lostpassword_url',$lostpassword_url,$redirect);
return $AspisRetTemp;
} }
function wp_register ( $before = '<li>',$after = '</li>' ) {
if ( !is_user_logged_in())
 {if ( get_option('users_can_register'))
 $link = $before . '<a href="' . site_url('wp-login.php?action=register','login') . '">' . __('Register') . '</a>' . $after;
else 
{$link = '';
}}else 
{{$link = $before . '<a href="' . admin_url() . '">' . __('Site Admin') . '</a>' . $after;
}}echo apply_filters('register',$link);
 }
function wp_meta (  ) {
do_action('wp_meta');
 }
function bloginfo ( $show = '' ) {
echo get_bloginfo($show,'display');
 }
function get_bloginfo ( $show = '',$filter = 'raw' ) {
switch ( $show ) {
case 'url':case 'home':case 'siteurl':$output = get_option('home');
break ;
case 'wpurl':$output = get_option('siteurl');
break ;
case 'description':$output = get_option('blogdescription');
break ;
case 'rdf_url':$output = get_feed_link('rdf');
break ;
case 'rss_url':$output = get_feed_link('rss');
break ;
case 'rss2_url':$output = get_feed_link('rss2');
break ;
case 'atom_url':$output = get_feed_link('atom');
break ;
case 'comments_atom_url':$output = get_feed_link('comments_atom');
break ;
case 'comments_rss2_url':$output = get_feed_link('comments_rss2');
break ;
case 'pingback_url':$output = get_option('siteurl') . '/xmlrpc.php';
break ;
case 'stylesheet_url':$output = get_stylesheet_uri();
break ;
case 'stylesheet_directory':$output = get_stylesheet_directory_uri();
break ;
case 'template_directory':case 'template_url':$output = get_template_directory_uri();
break ;
case 'admin_email':$output = get_option('admin_email');
break ;
case 'charset':$output = get_option('blog_charset');
if ( '' == $output)
 $output = 'UTF-8';
break ;
case 'html_type':$output = get_option('html_type');
break ;
case 'version':{global $wp_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_version,"\$wp_version",$AspisChangesCache);
}$output = $wp_version;
break ;
case 'language':$output = get_locale();
$output = str_replace('_','-',$output);
break ;
case 'text_direction':{global $wp_locale;
$AspisVar1 = &AspisCleanTaintedGlobalUntainted( $wp_locale,"\$wp_locale",$AspisChangesCache);
}$output = $wp_locale->text_direction;
break ;
case 'name':default :$output = get_option('blogname');
break ;
 }
$url = true;
if ( strpos($show,'url') === false && strpos($show,'directory') === false && strpos($show,'home') === false)
 $url = false;
if ( 'display' == $filter)
 {if ( $url)
 $output = apply_filters('bloginfo_url',$output,$show);
else 
{$output = apply_filters('bloginfo',$output,$show);
}}{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
 }
function wp_title ( $sep = '&raquo;',$display = true,$seplocation = '' ) {
{global $wpdb,$wp_locale,$wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_locale,"\$wp_locale",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_query,"\$wp_query",$AspisChangesCache);
}$cat = get_query_var('cat');
$tag = get_query_var('tag_id');
$category_name = get_query_var('category_name');
$author = get_query_var('author');
$author_name = get_query_var('author_name');
$m = get_query_var('m');
$year = get_query_var('year');
$monthnum = get_query_var('monthnum');
$day = get_query_var('day');
$search = get_query_var('s');
$title = '';
$t_sep = '%WP_TITILE_SEP%';
if ( !empty($cat))
 {if ( !stristr($cat,'-'))
 $title = apply_filters('single_cat_title',get_the_category_by_ID($cat));
}elseif ( !empty($category_name))
 {if ( stristr($category_name,'/'))
 {$category_name = explode('/',$category_name);
if ( $category_name[count($category_name) - 1])
 $category_name = $category_name[count($category_name) - 1];
else 
{$category_name = $category_name[count($category_name) - 2];
}}$cat = get_term_by('slug',$category_name,'category',OBJECT,'display');
if ( $cat)
 $title = apply_filters('single_cat_title',$cat->name);
}if ( !empty($tag))
 {$tag = get_term($tag,'post_tag',OBJECT,'display');
if ( is_wp_error($tag))
 {$AspisRetTemp = $tag;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}if ( !empty($tag->name))
 $title = apply_filters('single_tag_title',$tag->name);
}if ( !empty($author))
 {$title = get_userdata($author);
$title = $title->display_name;
}if ( !empty($author_name))
 {$title = $wpdb->get_var($wpdb->prepare("SELECT display_name FROM $wpdb->users WHERE user_nicename = %s",$author_name));
}if ( !empty($m))
 {$my_year = substr($m,0,4);
$my_month = $wp_locale->get_month(substr($m,4,2));
$my_day = intval(substr($m,6,2));
$title = "$my_year" . ($my_month ? "$t_sep$my_month" : "") . ($my_day ? "$t_sep$my_day" : "");
}if ( !empty($year))
 {$title = $year;
if ( !empty($monthnum))
 $title .= "$t_sep" . $wp_locale->get_month($monthnum);
if ( !empty($day))
 $title .= "$t_sep" . zeroise($day,2);
}if ( is_single() || (is_home() && !is_front_page()) || (is_page() && !is_front_page()))
 {$post = $wp_query->get_queried_object();
$title = strip_tags(apply_filters('single_post_title',$post->post_title));
}if ( is_tax())
 {$taxonomy = get_query_var('taxonomy');
$tax = get_taxonomy($taxonomy);
$tax = $tax->label;
$term = $wp_query->get_queried_object();
$term = $term->name;
$title = "$tax$t_sep$term";
}if ( is_search())
 {$title = sprintf(__('Search Results %1$s %2$s'),$t_sep,strip_tags($search));
}if ( is_404())
 {$title = __('Page not found');
}$prefix = '';
if ( !empty($title))
 $prefix = " $sep ";
if ( 'right' == $seplocation)
 {$title_array = explode($t_sep,$title);
$title_array = array_reverse($title_array);
$title = implode(" $sep ",$title_array) . $prefix;
}else 
{{$title_array = explode($t_sep,$title);
$title = $prefix . implode(" $sep ",$title_array);
}}$title = apply_filters('wp_title',$title,$sep,$seplocation);
if ( $display)
 echo $title;
else 
{{$AspisRetTemp = $title;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
 }
function single_post_title ( $prefix = '',$display = true ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$p = get_query_var('p');
$name = get_query_var('name');
if ( intval($p) || '' != $name)
 {if ( !$p)
 $p = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = %s",$name));
$post = &get_post($p);
$title = $post->post_title;
$title = apply_filters('single_post_title',$title);
if ( $display)
 echo $prefix . strip_tags($title);
else 
{{$AspisRetTemp = strip_tags($title);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function single_cat_title ( $prefix = '',$display = true ) {
$cat = intval(get_query_var('cat'));
if ( !empty($cat) && !(strtoupper($cat) == 'ALL'))
 {$my_cat_name = apply_filters('single_cat_title',get_the_category_by_ID($cat));
if ( !empty($my_cat_name))
 {if ( $display)
 echo $prefix . strip_tags($my_cat_name);
else 
{{$AspisRetTemp = strip_tags($my_cat_name);
return $AspisRetTemp;
}}}}else 
{if ( is_tag())
 {{$AspisRetTemp = single_tag_title($prefix,$display);
return $AspisRetTemp;
}}} }
function single_tag_title ( $prefix = '',$display = true ) {
if ( !is_tag())
 {return ;
}$tag_id = intval(get_query_var('tag_id'));
if ( !empty($tag_id))
 {$my_tag = &get_term($tag_id,'post_tag',OBJECT,'display');
if ( is_wp_error($my_tag))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$my_tag_name = apply_filters('single_tag_title',$my_tag->name);
if ( !empty($my_tag_name))
 {if ( $display)
 echo $prefix . $my_tag_name;
else 
{{$AspisRetTemp = $my_tag_name;
return $AspisRetTemp;
}}}} }
function single_month_title ( $prefix = '',$display = true ) {
{global $wp_locale;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_locale,"\$wp_locale",$AspisChangesCache);
}$m = get_query_var('m');
$year = get_query_var('year');
$monthnum = get_query_var('monthnum');
if ( !empty($monthnum) && !empty($year))
 {$my_year = $year;
$my_month = $wp_locale->get_month($monthnum);
}elseif ( !empty($m))
 {$my_year = substr($m,0,4);
$my_month = $wp_locale->get_month(substr($m,4,2));
}if ( empty($my_month))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}$result = $prefix . $my_month . $prefix . $my_year;
if ( !$display)
 {$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}echo $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
 }
function get_archives_link ( $url,$text,$format = 'html',$before = '',$after = '' ) {
$text = wptexturize($text);
$title_text = esc_attr($text);
$url = esc_url($url);
if ( 'link' == $format)
 $link_html = "\t<link rel='archives' title='$title_text' href='$url' />\n";
elseif ( 'option' == $format)
 $link_html = "\t<option value='$url'>$before $text $after</option>\n";
elseif ( 'html' == $format)
 $link_html = "\t<li>$before<a href='$url' title='$title_text'>$text</a>$after</li>\n";
else 
{$link_html = "\t$before<a href='$url' title='$title_text'>$text</a>$after\n";
}$link_html = apply_filters("get_archives_link",$link_html);
{$AspisRetTemp = $link_html;
return $AspisRetTemp;
} }
function wp_get_archives ( $args = '' ) {
{global $wpdb,$wp_locale;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_locale,"\$wp_locale",$AspisChangesCache);
}$defaults = array('type' => 'monthly','limit' => '','format' => 'html','before' => '','after' => '','show_post_count' => false,'echo' => 1);
$r = wp_parse_args($args,$defaults);
extract(($r),EXTR_SKIP);
if ( '' == $type)
 $type = 'monthly';
if ( '' != $limit)
 {$limit = absint($limit);
$limit = ' LIMIT ' . $limit;
}$archive_week_separator = '&#8211;';
$archive_date_format_over_ride = 0;
$archive_day_date_format = 'Y/m/d';
$archive_week_start_date_format = 'Y/m/d';
$archive_week_end_date_format = 'Y/m/d';
if ( !$archive_date_format_over_ride)
 {$archive_day_date_format = get_option('date_format');
$archive_week_start_date_format = get_option('date_format');
$archive_week_end_date_format = get_option('date_format');
}$where = apply_filters('getarchives_where',"WHERE post_type = 'post' AND post_status = 'publish'",$r);
$join = apply_filters('getarchives_join',"",$r);
$output = '';
if ( 'monthly' == $type)
 {$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
$key = md5($query);
$cache = wp_cache_get('wp_get_archives','general');
if ( !isset($cache[$key]))
 {$arcresults = $wpdb->get_results($query);
$cache[$key] = $arcresults;
wp_cache_add('wp_get_archives',$cache,'general');
}else 
{{$arcresults = $cache[$key];
}}if ( $arcresults)
 {$afterafter = $after;
foreach ( (array)$arcresults as $arcresult  )
{$url = get_month_link($arcresult->year,$arcresult->month);
$text = sprintf(__('%1$s %2$d'),$wp_locale->get_month($arcresult->month),$arcresult->year);
if ( $show_post_count)
 $after = '&nbsp;(' . $arcresult->posts . ')' . $afterafter;
$output .= get_archives_link($url,$text,$format,$before,$after);
}}}elseif ( 'yearly' == $type)
 {$query = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date DESC $limit";
$key = md5($query);
$cache = wp_cache_get('wp_get_archives','general');
if ( !isset($cache[$key]))
 {$arcresults = $wpdb->get_results($query);
$cache[$key] = $arcresults;
wp_cache_add('wp_get_archives',$cache,'general');
}else 
{{$arcresults = $cache[$key];
}}if ( $arcresults)
 {$afterafter = $after;
foreach ( (array)$arcresults as $arcresult  )
{$url = get_year_link($arcresult->year);
$text = sprintf('%d',$arcresult->year);
if ( $show_post_count)
 $after = '&nbsp;(' . $arcresult->posts . ')' . $afterafter;
$output .= get_archives_link($url,$text,$format,$before,$after);
}}}elseif ( 'daily' == $type)
 {$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date DESC $limit";
$key = md5($query);
$cache = wp_cache_get('wp_get_archives','general');
if ( !isset($cache[$key]))
 {$arcresults = $wpdb->get_results($query);
$cache[$key] = $arcresults;
wp_cache_add('wp_get_archives',$cache,'general');
}else 
{{$arcresults = $cache[$key];
}}if ( $arcresults)
 {$afterafter = $after;
foreach ( (array)$arcresults as $arcresult  )
{$url = get_day_link($arcresult->year,$arcresult->month,$arcresult->dayofmonth);
$date = sprintf('%1$d-%2$02d-%3$02d 00:00:00',$arcresult->year,$arcresult->month,$arcresult->dayofmonth);
$text = mysql2date($archive_day_date_format,$date);
if ( $show_post_count)
 $after = '&nbsp;(' . $arcresult->posts . ')' . $afterafter;
$output .= get_archives_link($url,$text,$format,$before,$after);
}}}elseif ( 'weekly' == $type)
 {$start_of_week = get_option('start_of_week');
$query = "SELECT DISTINCT WEEK(post_date, $start_of_week) AS `week`, YEAR(post_date) AS yr, DATE_FORMAT(post_date, '%Y-%m-%d') AS yyyymmdd, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY WEEK(post_date, $start_of_week), YEAR(post_date) ORDER BY post_date DESC $limit";
$key = md5($query);
$cache = wp_cache_get('wp_get_archives','general');
if ( !isset($cache[$key]))
 {$arcresults = $wpdb->get_results($query);
$cache[$key] = $arcresults;
wp_cache_add('wp_get_archives',$cache,'general');
}else 
{{$arcresults = $cache[$key];
}}$arc_w_last = '';
$afterafter = $after;
if ( $arcresults)
 {foreach ( (array)$arcresults as $arcresult  )
{if ( $arcresult->week != $arc_w_last)
 {$arc_year = $arcresult->yr;
$arc_w_last = $arcresult->week;
$arc_week = get_weekstartend($arcresult->yyyymmdd,get_option('start_of_week'));
$arc_week_start = date_i18n($archive_week_start_date_format,$arc_week['start']);
$arc_week_end = date_i18n($archive_week_end_date_format,$arc_week['end']);
$url = sprintf('%1$s/%2$s%3$sm%4$s%5$s%6$sw%7$s%8$d',get_option('home'),'','?','=',$arc_year,'&amp;','=',$arcresult->week);
$text = $arc_week_start . $archive_week_separator . $arc_week_end;
if ( $show_post_count)
 $after = '&nbsp;(' . $arcresult->posts . ')' . $afterafter;
$output .= get_archives_link($url,$text,$format,$before,$after);
}}}}elseif ( ('postbypost' == $type) || ('alpha' == $type))
 {$orderby = ('alpha' == $type) ? "post_title ASC " : "post_date DESC ";
$query = "SELECT * FROM $wpdb->posts $join $where ORDER BY $orderby $limit";
$key = md5($query);
$cache = wp_cache_get('wp_get_archives','general');
if ( !isset($cache[$key]))
 {$arcresults = $wpdb->get_results($query);
$cache[$key] = $arcresults;
wp_cache_add('wp_get_archives',$cache,'general');
}else 
{{$arcresults = $cache[$key];
}}if ( $arcresults)
 {foreach ( (array)$arcresults as $arcresult  )
{if ( $arcresult->post_date != '0000-00-00 00:00:00')
 {$url = get_permalink($arcresult);
$arc_title = $arcresult->post_title;
if ( $arc_title)
 $text = strip_tags(apply_filters('the_title',$arc_title));
else 
{$text = $arcresult->ID;
}$output .= get_archives_link($url,$text,$format,$before,$after);
}}}}if ( $echo)
 echo $output;
else 
{{$AspisRetTemp = $output;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_locale",$AspisChangesCache);
 }
function calendar_week_mod ( $num ) {
$base = 7;
{$AspisRetTemp = ($num - $base * floor($num / $base));
return $AspisRetTemp;
} }
function get_calendar ( $initial = true ) {
{global $wpdb,$m,$monthnum,$year,$wp_locale,$posts;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($m,"\$m",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($monthnum,"\$monthnum",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($year,"\$year",$AspisChangesCache);
$AspisVar4 = &AspisCleanTaintedGlobalUntainted($wp_locale,"\$wp_locale",$AspisChangesCache);
$AspisVar5 = &AspisCleanTaintedGlobalUntainted($posts,"\$posts",$AspisChangesCache);
}$cache = array();
$key = md5($m . $monthnum . $year);
if ( $cache = wp_cache_get('get_calendar','calendar'))
 {if ( is_array($cache) && isset($cache[$key]))
 {echo $cache[$key];
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$m",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$monthnum",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$year",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$wp_locale",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$posts",$AspisChangesCache);
return ;
}}}if ( !is_array($cache))
 $cache = array();
if ( !$posts)
 {$gotsome = $wpdb->get_var("SELECT 1 as test FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' LIMIT 1");
if ( !$gotsome)
 {$cache[$key] = '';
wp_cache_set('get_calendar',$cache,'calendar');
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$m",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$monthnum",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$year",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$wp_locale",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$posts",$AspisChangesCache);
return ;
}}}ob_start();
if ( (isset($_GET[0]['w']) && Aspis_isset($_GET[0]['w'])))
 $w = '' . intval(deAspisWarningRC($_GET[0]['w']));
$week_begins = intval(get_option('start_of_week'));
if ( !empty($monthnum) && !empty($year))
 {$thismonth = '' . zeroise(intval($monthnum),2);
$thisyear = '' . intval($year);
}elseif ( !empty($w))
 {$thisyear = '' . intval(substr($m,0,4));
$d = (($w - 1) * 7) + 6;
$thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('${thisyear}0101', INTERVAL $d DAY) ), '%m')");
}elseif ( !empty($m))
 {$thisyear = '' . intval(substr($m,0,4));
if ( strlen($m) < 6)
 $thismonth = '01';
else 
{$thismonth = '' . zeroise(intval(substr($m,4,2)),2);
}}else 
{{$thisyear = gmdate('Y',current_time('timestamp'));
$thismonth = gmdate('m',current_time('timestamp'));
}}$unixmonth = mktime(0,0,0,$thismonth,1,$thisyear);
$previous = $wpdb->get_row("SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date < '$thisyear-$thismonth-01'
		AND post_type = 'post' AND post_status = 'publish'
			ORDER BY post_date DESC
			LIMIT 1");
$next = $wpdb->get_row("SELECT	DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date >	'$thisyear-$thismonth-01'
		AND MONTH( post_date ) != MONTH( '$thisyear-$thismonth-01' )
		AND post_type = 'post' AND post_status = 'publish'
			ORDER	BY post_date ASC
			LIMIT 1");
$calendar_caption = _x('%1$s %2$s','calendar caption');
echo '<table id="wp-calendar" summary="' . esc_attr__('Calendar') . '">
	<caption>' . sprintf($calendar_caption,$wp_locale->get_month($thismonth),date('Y',$unixmonth)) . '</caption>
	<thead>
	<tr>';
$myweek = array();
for ( $wdcount = 0 ; $wdcount <= 6 ; $wdcount++ )
{$myweek[] = $wp_locale->get_weekday(($wdcount + $week_begins) % 7);
}foreach ( $myweek as $wd  )
{$day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
$wd = esc_attr($wd);
echo "\n\t\t<th abbr=\"$wd\" scope=\"col\" title=\"$wd\">$day_name</th>";
}echo '
	</tr>
	</thead>

	<tfoot>
	<tr>';
if ( $previous)
 {echo "\n\t\t" . '<td abbr="' . $wp_locale->get_month($previous->month) . '" colspan="3" id="prev"><a href="' . get_month_link($previous->year,$previous->month) . '" title="' . sprintf(__('View posts for %1$s %2$s'),$wp_locale->get_month($previous->month),date('Y',mktime(0,0,0,$previous->month,1,$previous->year))) . '">&laquo; ' . $wp_locale->get_month_abbrev($wp_locale->get_month($previous->month)) . '</a></td>';
}else 
{{echo "\n\t\t" . '<td colspan="3" id="prev" class="pad">&nbsp;</td>';
}}echo "\n\t\t" . '<td class="pad">&nbsp;</td>';
if ( $next)
 {echo "\n\t\t" . '<td abbr="' . $wp_locale->get_month($next->month) . '" colspan="3" id="next"><a href="' . get_month_link($next->year,$next->month) . '" title="' . esc_attr(sprintf(__('View posts for %1$s %2$s'),$wp_locale->get_month($next->month),date('Y',mktime(0,0,0,$next->month,1,$next->year)))) . '">' . $wp_locale->get_month_abbrev($wp_locale->get_month($next->month)) . ' &raquo;</a></td>';
}else 
{{echo "\n\t\t" . '<td colspan="3" id="next" class="pad">&nbsp;</td>';
}}echo '
	</tr>
	</tfoot>

	<tbody>
	<tr>';
$dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(post_date)
		FROM $wpdb->posts WHERE MONTH(post_date) = '$thismonth'
		AND YEAR(post_date) = '$thisyear'
		AND post_type = 'post' AND post_status = 'publish'
		AND post_date < '" . current_time('mysql') . '\'',ARRAY_N);
if ( $dayswithposts)
 {foreach ( (array)$dayswithposts as $daywith  )
{$daywithpost[] = $daywith[0];
}}else 
{{$daywithpost = array();
}}if ( strpos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'MSIE') !== false || strpos(strtolower(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT'])),'camino') !== false || strpos(strtolower(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT'])),'safari') !== false)
 $ak_title_separator = "\n";
else 
{$ak_title_separator = ', ';
}$ak_titles_for_day = array();
$ak_post_titles = $wpdb->get_results("SELECT post_title, DAYOFMONTH(post_date) as dom " . "FROM $wpdb->posts " . "WHERE YEAR(post_date) = '$thisyear' " . "AND MONTH(post_date) = '$thismonth' " . "AND post_date < '" . current_time('mysql') . "' " . "AND post_type = 'post' AND post_status = 'publish'");
if ( $ak_post_titles)
 {foreach ( (array)$ak_post_titles as $ak_post_title  )
{$post_title = esc_attr(apply_filters('the_title',$ak_post_title->post_title));
if ( empty($ak_titles_for_day['day_' . $ak_post_title->dom]))
 $ak_titles_for_day['day_' . $ak_post_title->dom] = '';
if ( empty($ak_titles_for_day["$ak_post_title->dom"]))
 $ak_titles_for_day["$ak_post_title->dom"] = $post_title;
else 
{$ak_titles_for_day["$ak_post_title->dom"] .= $ak_title_separator . $post_title;
}}}$pad = calendar_week_mod(date('w',$unixmonth) - $week_begins);
if ( 0 != $pad)
 echo "\n\t\t" . '<td colspan="' . esc_attr($pad) . '" class="pad">&nbsp;</td>';
$daysinmonth = intval(date('t',$unixmonth));
for ( $day = 1 ; $day <= $daysinmonth ; ++$day )
{if ( isset($newrow) && $newrow)
 echo "\n\t</tr>\n\t<tr>\n\t\t";
$newrow = false;
if ( $day == gmdate('j',(time() + (get_option('gmt_offset') * 3600))) && $thismonth == gmdate('m',time() + (get_option('gmt_offset') * 3600)) && $thisyear == gmdate('Y',time() + (get_option('gmt_offset') * 3600)))
 echo '<td id="today">';
else 
{echo '<td>';
}if ( in_array($day,$daywithpost))
 echo '<a href="' . get_day_link($thisyear,$thismonth,$day) . "\" title=\"" . esc_attr($ak_titles_for_day[$day]) . "\">$day</a>";
else 
{echo $day;
}echo '</td>';
if ( 6 == calendar_week_mod(date('w',mktime(0,0,0,$thismonth,$day,$thisyear)) - $week_begins))
 $newrow = true;
}$pad = 7 - calendar_week_mod(date('w',mktime(0,0,0,$thismonth,$day,$thisyear)) - $week_begins);
if ( $pad != 0 && $pad != 7)
 echo "\n\t\t" . '<td class="pad" colspan="' . esc_attr($pad) . '">&nbsp;</td>';
echo "\n\t</tr>\n\t</tbody>\n\t</table>";
$output = ob_get_contents();
ob_end_clean();
echo $output;
$cache[$key] = $output;
wp_cache_set('get_calendar',$cache,'calendar');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$m",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$monthnum",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$year",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$wp_locale",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$posts",$AspisChangesCache);
 }
function delete_get_calendar_cache (  ) {
wp_cache_delete('get_calendar','calendar');
 }
add_action('save_post','delete_get_calendar_cache');
add_action('delete_post','delete_get_calendar_cache');
add_action('update_option_start_of_week','delete_get_calendar_cache');
add_action('update_option_gmt_offset','delete_get_calendar_cache');
function allowed_tags (  ) {
{global $allowedtags;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $allowedtags,"\$allowedtags",$AspisChangesCache);
}$allowed = '';
foreach ( (array)$allowedtags as $tag =>$attributes )
{$allowed .= '<' . $tag;
if ( 0 < count($attributes))
 {foreach ( $attributes as $attribute =>$limits )
{$allowed .= ' ' . $attribute . '=""';
}}$allowed .= '> ';
}{$AspisRetTemp = htmlentities($allowed);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$allowedtags",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$allowedtags",$AspisChangesCache);
 }
function the_date_xml (  ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}echo mysql2date('Y-m-d',$post->post_date,false);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function the_date ( $d = '',$before = '',$after = '',$echo = true ) {
{global $post,$day,$previousday;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($day,"\$day",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($previousday,"\$previousday",$AspisChangesCache);
}$the_date = '';
if ( $day != $previousday)
 {$the_date .= $before;
if ( $d == '')
 $the_date .= mysql2date(get_option('date_format'),$post->post_date);
else 
{$the_date .= mysql2date($d,$post->post_date);
}$the_date .= $after;
$previousday = $day;
$the_date = apply_filters('the_date',$the_date,$d,$before,$after);
if ( $echo)
 echo $the_date;
else 
{{$AspisRetTemp = $the_date;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$day",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$previousday",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$day",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$previousday",$AspisChangesCache);
 }
function the_modified_date ( $d = '' ) {
echo apply_filters('the_modified_date',get_the_modified_date($d),$d);
 }
function get_the_modified_date ( $d = '' ) {
if ( '' == $d)
 $the_time = get_post_modified_time(get_option('date_format'),null,null,true);
else 
{$the_time = get_post_modified_time($d,null,null,true);
}{$AspisRetTemp = apply_filters('get_the_modified_date',$the_time,$d);
return $AspisRetTemp;
} }
function the_time ( $d = '' ) {
echo apply_filters('the_time',get_the_time($d),$d);
 }
function get_the_time ( $d = '',$post = null ) {
$post = get_post($post);
if ( '' == $d)
 $the_time = get_post_time(get_option('time_format'),false,$post,true);
else 
{$the_time = get_post_time($d,false,$post,true);
}{$AspisRetTemp = apply_filters('get_the_time',$the_time,$d,$post);
return $AspisRetTemp;
} }
function get_post_time ( $d = 'U',$gmt = false,$post = null,$translate = false ) {
$post = get_post($post);
if ( $gmt)
 $time = $post->post_date_gmt;
else 
{$time = $post->post_date;
}$time = mysql2date($d,$time,$translate);
{$AspisRetTemp = apply_filters('get_post_time',$time,$d,$gmt);
return $AspisRetTemp;
} }
function the_modified_time ( $d = '' ) {
echo apply_filters('the_modified_time',get_the_modified_time($d),$d);
 }
function get_the_modified_time ( $d = '' ) {
if ( '' == $d)
 $the_time = get_post_modified_time(get_option('time_format'),null,null,true);
else 
{$the_time = get_post_modified_time($d,null,null,true);
}{$AspisRetTemp = apply_filters('get_the_modified_time',$the_time,$d);
return $AspisRetTemp;
} }
function get_post_modified_time ( $d = 'U',$gmt = false,$post = null,$translate = false ) {
$post = get_post($post);
if ( $gmt)
 $time = $post->post_modified_gmt;
else 
{$time = $post->post_modified;
}$time = mysql2date($d,$time,$translate);
{$AspisRetTemp = apply_filters('get_post_modified_time',$time,$d,$gmt);
return $AspisRetTemp;
} }
function the_weekday (  ) {
{global $wp_locale,$post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_locale,"\$wp_locale",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($post,"\$post",$AspisChangesCache);
}$the_weekday = $wp_locale->get_weekday(mysql2date('w',$post->post_date,false));
$the_weekday = apply_filters('the_weekday',$the_weekday);
echo $the_weekday;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$post",$AspisChangesCache);
 }
function the_weekday_date ( $before = '',$after = '' ) {
{global $wp_locale,$post,$day,$previousweekday;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_locale,"\$wp_locale",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($post,"\$post",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($day,"\$day",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($previousweekday,"\$previousweekday",$AspisChangesCache);
}$the_weekday_date = '';
if ( $day != $previousweekday)
 {$the_weekday_date .= $before;
$the_weekday_date .= $wp_locale->get_weekday(mysql2date('w',$post->post_date,false));
$the_weekday_date .= $after;
$previousweekday = $day;
}$the_weekday_date = apply_filters('the_weekday_date',$the_weekday_date,$before,$after);
echo $the_weekday_date;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$day",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$previousweekday",$AspisChangesCache);
 }
function wp_head (  ) {
do_action('wp_head');
 }
function wp_footer (  ) {
do_action('wp_footer');
 }
function automatic_feed_links ( $add = true ) {
if ( $add)
 add_action('wp_head','feed_links',2);
else 
{{remove_action('wp_head','feed_links',2);
remove_action('wp_head','feed_links_extra',3);
}} }
function feed_links ( $args ) {
$defaults = array('separator' => _x('&raquo;','feed link'),'feedtitle' => __('%1$s %2$s Feed'),'comstitle' => __('%1$s %2$s Comments Feed'),);
$args = wp_parse_args($args,$defaults);
echo '<link rel="alternate" type="' . feed_content_type() . '" title="' . esc_attr(sprintf($args['feedtitle'],get_bloginfo('name'),$args['separator'])) . '" href="' . get_feed_link() . "\" />\n";
echo '<link rel="alternate" type="' . feed_content_type() . '" title="' . esc_attr(sprintf($args['comstitle'],get_bloginfo('name'),$args['separator'])) . '" href="' . get_feed_link('comments_' . get_default_feed()) . "\" />\n";
 }
function feed_links_extra ( $args ) {
$defaults = array('separator' => _x('&raquo;','feed link'),'singletitle' => __('%1$s %2$s %3$s Comments Feed'),'cattitle' => __('%1$s %2$s %3$s Category Feed'),'tagtitle' => __('%1$s %2$s %3$s Tag Feed'),'authortitle' => __('%1$s %2$s Posts by %3$s Feed'),'searchtitle' => __('%1$s %2$s Search Results for &#8220;%3$s&#8221; Feed'),);
$args = wp_parse_args($args,$defaults);
if ( is_single() || is_page())
 {$post = &get_post($id = 0);
if ( comments_open() || pings_open() || $post->comment_count > 0)
 {$title = esc_attr(sprintf($args['singletitle'],get_bloginfo('name'),$args['separator'],esc_html(get_the_title())));
$href = get_post_comments_feed_link($post->ID);
}}elseif ( is_category())
 {$cat_id = intval(get_query_var('cat'));
$title = esc_attr(sprintf($args['cattitle'],get_bloginfo('name'),$args['separator'],get_cat_name($cat_id)));
$href = get_category_feed_link($cat_id);
}elseif ( is_tag())
 {$tag_id = intval(get_query_var('tag_id'));
$tag = get_tag($tag_id);
$title = esc_attr(sprintf($args['tagtitle'],get_bloginfo('name'),$args['separator'],$tag->name));
$href = get_tag_feed_link($tag_id);
}elseif ( is_author())
 {$author_id = intval(get_query_var('author'));
$title = esc_attr(sprintf($args['authortitle'],get_bloginfo('name'),$args['separator'],get_the_author_meta('display_name',$author_id)));
$href = get_author_feed_link($author_id);
}elseif ( is_search())
 {$title = esc_attr(sprintf($args['searchtitle'],get_bloginfo('name'),$args['separator'],get_search_query()));
$href = get_search_feed_link();
}if ( isset($title) && isset($href))
 echo '<link rel="alternate" type="' . feed_content_type() . '" title="' . $title . '" href="' . $href . '" />' . "\n";
 }
function rsd_link (  ) {
echo '<link rel="EditURI" type="application/rsd+xml" title="RSD" href="' . get_bloginfo('wpurl') . "/xmlrpc.php?rsd\" />\n";
 }
function wlwmanifest_link (  ) {
echo '<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="' . get_bloginfo('wpurl') . '/wp-includes/wlwmanifest.xml" /> ' . "\n";
 }
function noindex (  ) {
if ( '0' == get_option('blog_public'))
 echo "<meta name='robots' content='noindex,nofollow' />\n";
 }
function rich_edit_exists (  ) {
{global $wp_rich_edit_exists;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rich_edit_exists,"\$wp_rich_edit_exists",$AspisChangesCache);
}if ( !isset($wp_rich_edit_exists))
 $wp_rich_edit_exists = file_exists(ABSPATH . WPINC . '/js/tinymce/tiny_mce.js');
{$AspisRetTemp = $wp_rich_edit_exists;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rich_edit_exists",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rich_edit_exists",$AspisChangesCache);
 }
function user_can_richedit (  ) {
{global $wp_rich_edit,$pagenow;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rich_edit,"\$wp_rich_edit",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($pagenow,"\$pagenow",$AspisChangesCache);
}if ( !isset($wp_rich_edit))
 {if ( get_user_option('rich_editing') == 'true' && ((preg_match('!AppleWebKit/(\d+)!',deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),$match) && intval($match[1]) >= 420) || !preg_match('!opera[ /][2-8]|konqueror|safari!i',deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']))) && 'comment.php' != $pagenow)
 {$wp_rich_edit = true;
}else 
{{$wp_rich_edit = false;
}}}{$AspisRetTemp = apply_filters('user_can_richedit',$wp_rich_edit);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rich_edit",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$pagenow",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rich_edit",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$pagenow",$AspisChangesCache);
 }
function wp_default_editor (  ) {
$r = user_can_richedit() ? 'tinymce' : 'html';
if ( $user = wp_get_current_user())
 {$ed = get_user_setting('editor','tinymce');
$r = (in_array($ed,array('tinymce','html','test'))) ? $ed : $r;
}{$AspisRetTemp = apply_filters('wp_default_editor',$r);
return $AspisRetTemp;
} }
function the_editor ( $content,$id = 'content',$prev_id = 'title',$media_buttons = true,$tab_index = 2 ) {
$rows = get_option('default_post_edit_rows');
if ( ($rows < 3) || ($rows > 100))
 $rows = 12;
if ( !current_user_can('upload_files'))
 $media_buttons = false;
$richedit = user_can_richedit();
$class = '';
if ( $richedit || $media_buttons)
 {;
?>
	<div id="editor-toolbar">
<?php if ( $richedit)
 {$wp_default_editor = wp_default_editor();
;
?>
		<div class="zerosize"><input accesskey="e" type="button" onclick="switchEditors.go('<?php echo $id;
;
?>')" /></div>
<?php if ( 'html' == $wp_default_editor)
 {add_filter('the_editor_content','wp_htmledit_pre');
;
?>
			<a id="edButtonHTML" class="active hide-if-no-js" onclick="switchEditors.go('<?php echo $id;
;
?>', 'html');"><?php _e('HTML');
;
?></a>
			<a id="edButtonPreview" class="hide-if-no-js" onclick="switchEditors.go('<?php echo $id;
;
?>', 'tinymce');"><?php _e('Visual');
;
?></a>
<?php }else 
{{$class = " class='theEditor'";
add_filter('the_editor_content','wp_richedit_pre');
;
?>
			<a id="edButtonHTML" class="hide-if-no-js" onclick="switchEditors.go('<?php echo $id;
;
?>', 'html');"><?php _e('HTML');
;
?></a>
			<a id="edButtonPreview" class="active hide-if-no-js" onclick="switchEditors.go('<?php echo $id;
;
?>', 'tinymce');"><?php _e('Visual');
;
?></a>
<?php }}}if ( $media_buttons)
 {;
?>
		<div id="media-buttons" class="hide-if-no-js">
<?php do_action('media_buttons');
;
?>
		</div>
<?php };
?>
	</div>
<?php };
?>
	<div id="quicktags"><?php wp_print_scripts('quicktags');
;
?>
	<script type="text/javascript">edToolbar()</script>
	</div>

<?php $the_editor = apply_filters('the_editor',"<div id='editorcontainer'><textarea rows='$rows'$class cols='40' name='$id' tabindex='$tab_index' id='$id'>%s</textarea></div>\n");
$the_editor_content = apply_filters('the_editor_content',$content);
printf($the_editor,$the_editor_content);
;
?>
	<script type="text/javascript">
	edCanvas = document.getElementById('<?php echo $id;
;
?>');
	</script>
<?php  }
function get_search_query (  ) {
{$AspisRetTemp = apply_filters('get_search_query',get_query_var('s'));
return $AspisRetTemp;
} }
function the_search_query (  ) {
echo esc_attr(apply_filters('the_search_query',get_search_query()));
 }
function language_attributes ( $doctype = 'html' ) {
$attributes = array();
$output = '';
if ( $dir = get_bloginfo('text_direction'))
 $attributes[] = "dir=\"$dir\"";
if ( $lang = get_bloginfo('language'))
 {if ( get_option('html_type') == 'text/html' || $doctype == 'html')
 $attributes[] = "lang=\"$lang\"";
if ( get_option('html_type') != 'text/html' || $doctype == 'xhtml')
 $attributes[] = "xml:lang=\"$lang\"";
}$output = implode(' ',$attributes);
$output = apply_filters('language_attributes',$output);
echo $output;
 }
function paginate_links ( $args = '' ) {
$defaults = array('base' => '%_%','format' => '?page=%#%','total' => 1,'current' => 0,'show_all' => false,'prev_next' => true,'prev_text' => __('&laquo; Previous'),'next_text' => __('Next &raquo;'),'end_size' => 1,'mid_size' => 2,'type' => 'plain','add_args' => false,'add_fragment' => '');
$args = wp_parse_args($args,$defaults);
extract(($args),EXTR_SKIP);
$total = (int)$total;
if ( $total < 2)
 {return ;
}$current = (int)$current;
$end_size = 0 < (int)$end_size ? (int)$end_size : 1;
$mid_size = 0 <= (int)$mid_size ? (int)$mid_size : 2;
$add_args = is_array($add_args) ? $add_args : false;
$r = '';
$page_links = array();
$n = 0;
$dots = false;
if ( $prev_next && $current && 1 < $current)
 {$link = str_replace('%_%',2 == $current ? '' : $format,$base);
$link = str_replace('%#%',$current - 1,$link);
if ( $add_args)
 $link = add_query_arg($add_args,$link);
$link .= $add_fragment;
$page_links[] = "<a class='prev page-numbers' href='" . esc_url($link) . "'>$prev_text</a>";
}for ( $n = 1 ; $n <= $total ; $n++ )
{$n_display = number_format_i18n($n);
if ( $n == $current)
 {$page_links[] = "<span class='page-numbers current'>$n_display</span>";
$dots = true;
}else 
{if ( $show_all || ($n <= $end_size || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size) || $n > $total - $end_size))
 {$link = str_replace('%_%',1 == $n ? '' : $format,$base);
$link = str_replace('%#%',$n,$link);
if ( $add_args)
 $link = add_query_arg($add_args,$link);
$link .= $add_fragment;
$page_links[] = "<a class='page-numbers' href='" . esc_url($link) . "'>$n_display</a>";
$dots = true;
}elseif ( $dots && !$show_all)
 {$page_links[] = "<span class='page-numbers dots'>...</span>";
$dots = false;
}}}if ( $prev_next && $current && ($current < $total || -1 == $total))
 {$link = str_replace('%_%',$format,$base);
$link = str_replace('%#%',$current + 1,$link);
if ( $add_args)
 $link = add_query_arg($add_args,$link);
$link .= $add_fragment;
$page_links[] = "<a class='next page-numbers' href='" . esc_url($link) . "'>$next_text</a>";
}switch ( $type ) {
case 'array':{$AspisRetTemp = $page_links;
return $AspisRetTemp;
}break ;
;
case 'list':$r .= "<ul class='page-numbers'>\n\t<li>";
$r .= join("</li>\n\t<li>",$page_links);
$r .= "</li>\n</ul>\n";
break ;
default :$r = join("\n",$page_links);
break ;
 }
{$AspisRetTemp = $r;
return $AspisRetTemp;
} }
function wp_admin_css_color ( $key,$name,$url,$colors = array() ) {
{global $_wp_admin_css_colors;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_admin_css_colors,"\$_wp_admin_css_colors",$AspisChangesCache);
}if ( !isset($_wp_admin_css_colors))
 $_wp_admin_css_colors = array();
$_wp_admin_css_colors[$key] = (object)array('name' => $name,'url' => $url,'colors' => $colors);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_admin_css_colors",$AspisChangesCache);
 }
function wp_admin_css_uri ( $file = 'wp-admin' ) {
if ( defined('WP_INSTALLING'))
 {$_file = "./$file.css";
}else 
{{$_file = admin_url("$file.css");
}}$_file = add_query_arg('version',get_bloginfo('version'),$_file);
{$AspisRetTemp = apply_filters('wp_admin_css_uri',$_file,$file);
return $AspisRetTemp;
} }
function wp_admin_css ( $file = 'wp-admin',$force_echo = false ) {
{global $wp_styles;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_styles,"\$wp_styles",$AspisChangesCache);
}if ( !is_a($wp_styles,'WP_Styles'))
 $wp_styles = new WP_Styles();
$handle = 0 === strpos($file,'css/') ? substr($file,4) : $file;
if ( $wp_styles->query($handle))
 {if ( $force_echo || did_action('wp_print_styles'))
 wp_print_styles($handle);
else 
{wp_enqueue_style($handle);
}{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
return ;
}}echo apply_filters('wp_admin_css',"<link rel='stylesheet' href='" . esc_url(wp_admin_css_uri($file)) . "' type='text/css' />\n",$file);
if ( 'rtl' == get_bloginfo('text_direction'))
 echo apply_filters('wp_admin_css',"<link rel='stylesheet' href='" . esc_url(wp_admin_css_uri("$file-rtl")) . "' type='text/css' />\n","$file-rtl");
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_styles",$AspisChangesCache);
 }
function add_thickbox (  ) {
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox');
 }
function wp_generator (  ) {
the_generator(apply_filters('wp_generator_type','xhtml'));
 }
function the_generator ( $type ) {
echo apply_filters('the_generator',get_the_generator($type),$type) . "\n";
 }
function get_the_generator ( $type ) {
switch ( $type ) {
case 'html':$gen = '<meta name="generator" content="WordPress ' . get_bloginfo('version') . '">';
break ;
case 'xhtml':$gen = '<meta name="generator" content="WordPress ' . get_bloginfo('version') . '" />';
break ;
case 'atom':$gen = '<generator uri="http://wordpress.org/" version="' . get_bloginfo_rss('version') . '">WordPress</generator>';
break ;
case 'rss2':$gen = '<generator>http://wordpress.org/?v=' . get_bloginfo_rss('version') . '</generator>';
break ;
case 'rdf':$gen = '<admin:generatorAgent rdf:resource="http://wordpress.org/?v=' . get_bloginfo_rss('version') . '" />';
break ;
case 'comment':$gen = '<!-- generator="WordPress/' . get_bloginfo('version') . '" -->';
break ;
case 'export':$gen = '<!-- generator="WordPress/' . get_bloginfo_rss('version') . '" created="' . date('Y-m-d H:i') . '"-->';
break ;
 }
{$AspisRetTemp = apply_filters("get_the_generator_{$type}",$gen,$type);
return $AspisRetTemp;
} }
;
