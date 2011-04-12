<?php require_once('AspisMain.php'); ?><?php
function redirect_canonical ( $requested_url = array(null,false),$do_redirect = array(true,false) ) {
global $wp_rewrite,$is_IIS,$wp_query,$wpdb;
if ( (((((((deAspis(is_trackback()) || deAspis(is_search())) || deAspis(is_comments_popup())) || deAspis(is_admin())) || $is_IIS[0]) || (((isset($_POST) && Aspis_isset( $_POST))) && count($_POST[0]))) || deAspis(is_preview())) || deAspis(is_robots())))
 return ;
if ( (denot_boolean($requested_url)))
 {$requested_url = ((!((empty($_SERVER[0][('HTTPS')]) || Aspis_empty( $_SERVER [0][('HTTPS')])))) && (deAspis(Aspis_strtolower($_SERVER[0]['HTTPS'])) == ('on'))) ? array('https://',false) : array('http://',false);
$requested_url = concat($requested_url,$_SERVER[0]['HTTP_HOST']);
$requested_url = concat($requested_url,$_SERVER[0]['REQUEST_URI']);
}$original = @Aspis_parse_url($requested_url);
if ( (false === $original[0]))
 return ;
$redirect = $original;
$redirect_url = array(false,false);
if ( (!((isset($redirect[0][('path')]) && Aspis_isset( $redirect [0][('path')])))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('path',false))),addTaint(array('',false)));
if ( (!((isset($redirect[0][('query')]) && Aspis_isset( $redirect [0][('query')])))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(array('',false)));
if ( ((deAspis(is_singular()) && ((1) > $wp_query[0]->post_count[0])) && deAspis(($id = get_query_var(array('p',false))))))
 {$vars = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT post_type, post_parent FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$id));
if ( (((isset($vars[0][(0)]) && Aspis_isset( $vars [0][(0)]))) && deAspis($vars = attachAspis($vars,(0)))))
 {if ( ((('revision') == $vars[0]->post_type[0]) && ($vars[0]->post_parent[0] > (0))))
 $id = $vars[0]->post_parent;
if ( deAspis($redirect_url = get_permalink($id)))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array(array(array('p',false),array('page_id',false),array('attachment_id',false)),false),$redirect[0]['query'])));
}}if ( deAspis(is_404()))
 {$redirect_url = redirect_guess_404_permalink();
}elseif ( (is_object($wp_rewrite[0]) && deAspis($wp_rewrite[0]->using_permalinks())))
 {if ( ((deAspis(is_attachment()) && (!((empty($_GET[0][('attachment_id')]) || Aspis_empty( $_GET [0][('attachment_id')]))))) && (denot_boolean($redirect_url))))
 {if ( deAspis($redirect_url = get_attachment_link(get_query_var(array('attachment_id',false)))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('attachment_id',false),$redirect[0]['query'])));
}elseif ( ((deAspis(is_single()) && (!((empty($_GET[0][('p')]) || Aspis_empty( $_GET [0][('p')]))))) && (denot_boolean($redirect_url))))
 {if ( deAspis($redirect_url = get_permalink(get_query_var(array('p',false)))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('p',false),$redirect[0]['query'])));
if ( deAspis(get_query_var(array('page',false))))
 {$redirect_url = concat(trailingslashit($redirect_url),user_trailingslashit(get_query_var(array('page',false)),array('single_paged',false)));
arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('page',false),$redirect[0]['query'])));
}}elseif ( ((deAspis(is_single()) && (!((empty($_GET[0][('name')]) || Aspis_empty( $_GET [0][('name')]))))) && (denot_boolean($redirect_url))))
 {if ( deAspis($redirect_url = get_permalink($wp_query[0]->get_queried_object_id())))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('name',false),$redirect[0]['query'])));
}elseif ( ((deAspis(is_page()) && (!((empty($_GET[0][('page_id')]) || Aspis_empty( $_GET [0][('page_id')]))))) && (denot_boolean($redirect_url))))
 {if ( deAspis($redirect_url = get_permalink(get_query_var(array('page_id',false)))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('page_id',false),$redirect[0]['query'])));
}elseif ( ((!((empty($_GET[0][('m')]) || Aspis_empty( $_GET [0][('m')])))) && ((deAspis(is_year()) || deAspis(is_month())) || deAspis(is_day()))))
 {$m = get_query_var(array('m',false));
switch ( strlen($m[0]) ) {
case (4):$redirect_url = get_year_link($m);
break ;
case (6):$redirect_url = get_month_link(Aspis_substr($m,array(0,false),array(4,false)),Aspis_substr($m,array(4,false),array(2,false)));
break ;
case (8):$redirect_url = get_day_link(Aspis_substr($m,array(0,false),array(4,false)),Aspis_substr($m,array(4,false),array(2,false)),Aspis_substr($m,array(6,false),array(2,false)));
break ;
 }
if ( $redirect_url[0])
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('m',false),$redirect[0]['query'])));
}elseif ( (((deAspis(is_day()) && deAspis(get_query_var(array('year',false)))) && deAspis(get_query_var(array('monthnum',false)))) && (!((empty($_GET[0][('day')]) || Aspis_empty( $_GET [0][('day')]))))))
 {if ( deAspis($redirect_url = get_day_link(get_query_var(array('year',false)),get_query_var(array('monthnum',false)),get_query_var(array('day',false)))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array(array(array('year',false),array('monthnum',false),array('day',false)),false),$redirect[0]['query'])));
}elseif ( ((deAspis(is_month()) && deAspis(get_query_var(array('year',false)))) && (!((empty($_GET[0][('monthnum')]) || Aspis_empty( $_GET [0][('monthnum')]))))))
 {if ( deAspis($redirect_url = get_month_link(get_query_var(array('year',false)),get_query_var(array('monthnum',false)))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array(array(array('year',false),array('monthnum',false)),false),$redirect[0]['query'])));
}elseif ( (deAspis(is_year()) && (!((empty($_GET[0][('year')]) || Aspis_empty( $_GET [0][('year')]))))))
 {if ( deAspis($redirect_url = get_year_link(get_query_var(array('year',false)))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('year',false),$redirect[0]['query'])));
}elseif ( ((deAspis(is_category()) && (!((empty($_GET[0][('cat')]) || Aspis_empty( $_GET [0][('cat')]))))) && deAspis(Aspis_preg_match(array('|^[0-9]+$|',false),$_GET[0]['cat']))))
 {if ( deAspis($redirect_url = get_category_link(get_query_var(array('cat',false)))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('cat',false),$redirect[0]['query'])));
}elseif ( ((deAspis(is_author()) && (!((empty($_GET[0][('author')]) || Aspis_empty( $_GET [0][('author')]))))) && deAspis(Aspis_preg_match(array('|^[0-9]+$|',false),$_GET[0]['author']))))
 {$author = get_userdata(get_query_var(array('author',false)));
if ( ((false !== $author[0]) && deAspis($redirect_url = get_author_posts_url($author[0]->ID,$author[0]->user_nicename))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('author',false),$redirect[0]['author'])));
}if ( ((deAspis(get_query_var(array('paged',false))) || deAspis(is_feed())) || deAspis(get_query_var(array('cpage',false)))))
 {if ( (denot_boolean($redirect_url)))
 $redirect_url = $requested_url;
$paged_redirect = @Aspis_parse_url($redirect_url);
while ( ((deAspis(Aspis_preg_match(array('#/page/[0-9]+?(/+)?$#',false),$paged_redirect[0]['path'])) || deAspis(Aspis_preg_match(array('#/(comments/?)?(feed|rss|rdf|atom|rss2)(/+)?$#',false),$paged_redirect[0]['path']))) || deAspis(Aspis_preg_match(array('#/comment-page-[0-9]+(/+)?$#',false),$paged_redirect[0]['path']))) )
{arrayAssign($paged_redirect[0],deAspis(registerTaint(array('path',false))),addTaint(Aspis_preg_replace(array('#/page/[0-9]+?(/+)?$#',false),array('/',false),$paged_redirect[0]['path'])));
arrayAssign($paged_redirect[0],deAspis(registerTaint(array('path',false))),addTaint(Aspis_preg_replace(array('#/(comments/?)?(feed|rss2?|rdf|atom)(/+|$)#',false),array('/',false),$paged_redirect[0]['path'])));
arrayAssign($paged_redirect[0],deAspis(registerTaint(array('path',false))),addTaint(Aspis_preg_replace(array('#/comment-page-[0-9]+?(/+)?$#',false),array('/',false),$paged_redirect[0]['path'])));
}$addl_path = array('',false);
if ( deAspis(is_feed()))
 {$addl_path = (!((empty($addl_path) || Aspis_empty( $addl_path)))) ? trailingslashit($addl_path) : array('',false);
if ( deAspis(get_query_var(array('withcomments',false))))
 $addl_path = concat2($addl_path,'comments/');
$addl_path = concat($addl_path,user_trailingslashit(concat1('feed/',(((('rss2') == deAspis(get_query_var(array('feed',false)))) || (('feed') == deAspis(get_query_var(array('feed',false))))) ? array('',false) : get_query_var(array('feed',false)))),array('feed',false)));
arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('feed',false),$redirect[0]['query'])));
}if ( (deAspis(get_query_var(array('paged',false))) > (0)))
 {$paged = get_query_var(array('paged',false));
arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('paged',false),$redirect[0]['query'])));
if ( (denot_boolean(is_feed())))
 {if ( (($paged[0] > (1)) && (denot_boolean(is_single()))))
 {$addl_path = concat(((!((empty($addl_path) || Aspis_empty( $addl_path)))) ? trailingslashit($addl_path) : array('',false)),user_trailingslashit(concat1("page/",$paged),array('paged',false)));
}elseif ( (denot_boolean(is_single())))
 {$addl_path = concat(((!((empty($addl_path) || Aspis_empty( $addl_path)))) ? trailingslashit($addl_path) : array('',false)),user_trailingslashit($paged_redirect[0]['path'],array('paged',false)));
}}elseif ( ($paged[0] > (1)))
 {arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(add_query_arg(array('paged',false),$paged,$redirect[0]['query'])));
}}if ( (deAspis(get_option(array('page_comments',false))) && (((('newest') == deAspis(get_option(array('default_comments_page',false)))) && (deAspis(get_query_var(array('cpage',false))) > (0))) || ((('newest') != deAspis(get_option(array('default_comments_page',false)))) && (deAspis(get_query_var(array('cpage',false))) > (1))))))
 {$addl_path = concat(((!((empty($addl_path) || Aspis_empty( $addl_path)))) ? trailingslashit($addl_path) : array('',false)),user_trailingslashit(concat1('comment-page-',get_query_var(array('cpage',false))),array('commentpaged',false)));
arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(remove_query_arg(array('cpage',false),$redirect[0]['query'])));
}arrayAssign($paged_redirect[0],deAspis(registerTaint(array('path',false))),addTaint(user_trailingslashit(Aspis_preg_replace(array('|/index.php/?$|',false),array('/',false),$paged_redirect[0]['path']))));
if ( (((!((empty($addl_path) || Aspis_empty( $addl_path)))) && deAspis($wp_rewrite[0]->using_index_permalinks())) && (strpos(deAspis($paged_redirect[0]['path']),'/index.php/') === false)))
 arrayAssign($paged_redirect[0],deAspis(registerTaint(array('path',false))),addTaint(concat2(trailingslashit($paged_redirect[0]['path']),'index.php/')));
if ( (!((empty($addl_path) || Aspis_empty( $addl_path)))))
 arrayAssign($paged_redirect[0],deAspis(registerTaint(array('path',false))),addTaint(concat(trailingslashit($paged_redirect[0]['path']),$addl_path)));
$redirect_url = concat(concat(concat2($paged_redirect[0]['scheme'],'://'),$paged_redirect[0]['host']),$paged_redirect[0]['path']);
arrayAssign($redirect[0],deAspis(registerTaint(array('path',false))),addTaint($paged_redirect[0]['path']));
}}arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(Aspis_preg_replace(array('#^\??&*?#',false),array('',false),$redirect[0]['query'])));
if ( ($redirect_url[0] && (!((empty($redirect[0][('query')]) || Aspis_empty( $redirect [0][('query')]))))))
 {if ( (strpos($redirect_url[0],'?') !== false))
 $redirect_url = concat2($redirect_url,'&');
else 
{$redirect_url = concat2($redirect_url,'?');
}$redirect_url = concat($redirect_url,$redirect[0]['query']);
}if ( $redirect_url[0])
 $redirect = @Aspis_parse_url($redirect_url);
$user_home = @Aspis_parse_url(get_option(array('home',false)));
if ( (!((empty($user_home[0][('host')]) || Aspis_empty( $user_home [0][('host')])))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('host',false))),addTaint($user_home[0]['host']));
if ( ((empty($user_home[0][('path')]) || Aspis_empty( $user_home [0][('path')]))))
 arrayAssign($user_home[0],deAspis(registerTaint(array('path',false))),addTaint(array('/',false)));
if ( (!((empty($user_home[0][('port')]) || Aspis_empty( $user_home [0][('port')])))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('port',false))),addTaint($user_home[0]['port']));
else 
{unset($redirect[0][('port')]);
}arrayAssign($redirect[0],deAspis(registerTaint(array('path',false))),addTaint(Aspis_preg_replace(array('|/index.php/*?$|',false),array('/',false),$redirect[0]['path'])));
arrayAssign($redirect[0],deAspis(registerTaint(array('path',false))),addTaint(Aspis_preg_replace(array('#(%20| )+$#',false),array('',false),$redirect[0]['path'])));
if ( (!((empty($redirect[0][('query')]) || Aspis_empty( $redirect [0][('query')])))))
 {arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(Aspis_preg_replace(array('#((p|page_id|cat|tag)=[^&]*?)(%20| )+$#',false),array('$1',false),$redirect[0]['query'])));
arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(Aspis_trim(Aspis_preg_replace(array('#(^|&)(p|page_id|cat|tag)=?(&|$)#',false),array('&',false),$redirect[0]['query']),array('&',false))));
arrayAssign($redirect[0],deAspis(registerTaint(array('query',false))),addTaint(Aspis_preg_replace(array('#^\??&*?#',false),array('',false),$redirect[0]['query'])));
}if ( (denot_boolean($wp_rewrite[0]->using_index_permalinks())))
 arrayAssign($redirect[0],deAspis(registerTaint(array('path',false))),addTaint(Aspis_str_replace(array('/index.php/',false),array('/',false),$redirect[0]['path'])));
if ( (((is_object($wp_rewrite[0]) && deAspis($wp_rewrite[0]->using_permalinks())) && (denot_boolean(is_404()))) && ((denot_boolean(is_front_page())) || (deAspis(is_front_page()) && (deAspis(get_query_var(array('paged',false))) > (1))))))
 {$user_ts_type = array('',false);
if ( (deAspis(get_query_var(array('paged',false))) > (0)))
 {$user_ts_type = array('paged',false);
}else 
{{foreach ( (array(array('single',false),array('category',false),array('page',false),array('day',false),array('month',false),array('year',false),array('home',false))) as $type  )
{$func = concat1('is_',$type);
if ( deAspis(Aspis_call_user_func($func)))
 {$user_ts_type = $type;
break ;
}}}}arrayAssign($redirect[0],deAspis(registerTaint(array('path',false))),addTaint(user_trailingslashit($redirect[0]['path'],$user_ts_type)));
}elseif ( deAspis(is_front_page()))
 {arrayAssign($redirect[0],deAspis(registerTaint(array('path',false))),addTaint(trailingslashit($redirect[0]['path'])));
}if ( (deAspis(trailingslashit($redirect[0]['path'])) == deAspis(trailingslashit($user_home[0]['path']))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('path',false))),addTaint(trailingslashit($redirect[0]['path'])));
if ( ((deAspis(Aspis_strtolower($original[0]['host'])) == deAspis(Aspis_strtolower($redirect[0]['host']))) || ((deAspis(Aspis_strtolower($original[0]['host'])) != (deconcat1('www.',Aspis_strtolower($redirect[0]['host'])))) && ((deconcat1('www.',Aspis_strtolower($original[0]['host']))) != deAspis(Aspis_strtolower($redirect[0]['host']))))))
 arrayAssign($redirect[0],deAspis(registerTaint(array('host',false))),addTaint($original[0]['host']));
$compare_original = array(array($original[0]['host'],$original[0]['path']),false);
if ( (!((empty($original[0][('port')]) || Aspis_empty( $original [0][('port')])))))
 arrayAssignAdd($compare_original[0][],addTaint($original[0]['port']));
if ( (!((empty($original[0][('query')]) || Aspis_empty( $original [0][('query')])))))
 arrayAssignAdd($compare_original[0][],addTaint($original[0]['query']));
$compare_redirect = array(array($redirect[0]['host'],$redirect[0]['path']),false);
if ( (!((empty($redirect[0][('port')]) || Aspis_empty( $redirect [0][('port')])))))
 arrayAssignAdd($compare_redirect[0][],addTaint($redirect[0]['port']));
if ( (!((empty($redirect[0][('query')]) || Aspis_empty( $redirect [0][('query')])))))
 arrayAssignAdd($compare_redirect[0][],addTaint($redirect[0]['query']));
if ( ($compare_original[0] !== $compare_redirect[0]))
 {$redirect_url = concat(concat2($redirect[0]['scheme'],'://'),$redirect[0]['host']);
if ( (!((empty($redirect[0][('port')]) || Aspis_empty( $redirect [0][('port')])))))
 $redirect_url = concat($redirect_url,concat1(':',$redirect[0]['port']));
$redirect_url = concat($redirect_url,$redirect[0]['path']);
if ( (!((empty($redirect[0][('query')]) || Aspis_empty( $redirect [0][('query')])))))
 $redirect_url = concat($redirect_url,concat1('?',$redirect[0]['query']));
}if ( ($redirect_url[0] == $requested_url[0]))
 return array(false,false);
$redirect_url = apply_filters(array('redirect_canonical',false),$redirect_url,$requested_url);
if ( ((denot_boolean($redirect_url)) || ($redirect_url[0] == $requested_url[0])))
 return array(false,false);
if ( $do_redirect[0])
 {if ( (denot_boolean(redirect_canonical($redirect_url,array(false,false)))))
 {wp_redirect($redirect_url,array(301,false));
Aspis_exit();
}else 
{{return array(false,false);
}}}else 
{{return $redirect_url;
}} }
function redirect_guess_404_permalink (  ) {
global $wpdb;
if ( (denot_boolean(get_query_var(array('name',false)))))
 return array(false,false);
$where = $wpdb[0]->prepare(array("post_name LIKE %s",false),concat2(get_query_var(array('name',false)),'%'));
if ( deAspis(get_query_var(array('year',false))))
 $where = concat($where,$wpdb[0]->prepare(array(" AND YEAR(post_date) = %d",false),get_query_var(array('year',false))));
if ( deAspis(get_query_var(array('monthnum',false))))
 $where = concat($where,$wpdb[0]->prepare(array(" AND MONTH(post_date) = %d",false),get_query_var(array('monthnum',false))));
if ( deAspis(get_query_var(array('day',false))))
 $where = concat($where,$wpdb[0]->prepare(array(" AND DAYOFMONTH(post_date) = %d",false),get_query_var(array('day',false))));
$post_id = $wpdb[0]->get_var(concat2(concat(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE "),$where)," AND post_status = 'publish'"));
if ( (denot_boolean($post_id)))
 return array(false,false);
return get_permalink($post_id);
 }
add_action(array('template_redirect',false),array('redirect_canonical',false));
;
?>
<?php 