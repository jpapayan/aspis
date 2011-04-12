<?php require_once('AspisMain.php'); ?><?php
function redirect_canonical ( $requested_url = null,$do_redirect = true ) {
{global $wp_rewrite,$is_IIS,$wp_query,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($is_IIS,"\$is_IIS",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_query,"\$wp_query",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( is_trackback() || is_search() || is_comments_popup() || is_admin() || $is_IIS || ((isset($_POST) && Aspis_isset($_POST)) && count(deAspisWarningRC($_POST))) || is_preview() || is_robots())
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$is_IIS",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wpdb",$AspisChangesCache);
return ;
}if ( !$requested_url)
 {$requested_url = (!(empty($_SERVER[0]['HTTPS']) || Aspis_empty($_SERVER[0]['HTTPS'])) && strtolower(deAspisWarningRC($_SERVER[0]['HTTPS'])) == 'on') ? 'https://' : 'http://';
$requested_url .= deAspisWarningRC($_SERVER[0]['HTTP_HOST']);
$requested_url .= deAspisWarningRC($_SERVER[0]['REQUEST_URI']);
}$original = @parse_url($requested_url);
if ( false === $original)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$is_IIS",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wpdb",$AspisChangesCache);
return ;
}$redirect = $original;
$redirect_url = false;
if ( !isset($redirect['path']))
 $redirect['path'] = '';
if ( !isset($redirect['query']))
 $redirect['query'] = '';
if ( is_singular() && 1 > $wp_query->post_count && ($id = get_query_var('p')))
 {$vars = $wpdb->get_results($wpdb->prepare("SELECT post_type, post_parent FROM $wpdb->posts WHERE ID = %d",$id));
if ( isset($vars[0]) && $vars = $vars[0])
 {if ( 'revision' == $vars->post_type && $vars->post_parent > 0)
 $id = $vars->post_parent;
if ( $redirect_url = get_permalink($id))
 $redirect['query'] = remove_query_arg(array('p','page_id','attachment_id'),$redirect['query']);
}}if ( is_404())
 {$redirect_url = redirect_guess_404_permalink();
}elseif ( is_object($wp_rewrite) && $wp_rewrite->using_permalinks())
 {if ( is_attachment() && !(empty($_GET[0]['attachment_id']) || Aspis_empty($_GET[0]['attachment_id'])) && !$redirect_url)
 {if ( $redirect_url = get_attachment_link(get_query_var('attachment_id')))
 $redirect['query'] = remove_query_arg('attachment_id',$redirect['query']);
}elseif ( is_single() && !(empty($_GET[0]['p']) || Aspis_empty($_GET[0]['p'])) && !$redirect_url)
 {if ( $redirect_url = get_permalink(get_query_var('p')))
 $redirect['query'] = remove_query_arg('p',$redirect['query']);
if ( get_query_var('page'))
 {$redirect_url = trailingslashit($redirect_url) . user_trailingslashit(get_query_var('page'),'single_paged');
$redirect['query'] = remove_query_arg('page',$redirect['query']);
}}elseif ( is_single() && !(empty($_GET[0]['name']) || Aspis_empty($_GET[0]['name'])) && !$redirect_url)
 {if ( $redirect_url = get_permalink($wp_query->get_queried_object_id()))
 $redirect['query'] = remove_query_arg('name',$redirect['query']);
}elseif ( is_page() && !(empty($_GET[0]['page_id']) || Aspis_empty($_GET[0]['page_id'])) && !$redirect_url)
 {if ( $redirect_url = get_permalink(get_query_var('page_id')))
 $redirect['query'] = remove_query_arg('page_id',$redirect['query']);
}elseif ( !(empty($_GET[0]['m']) || Aspis_empty($_GET[0]['m'])) && (is_year() || is_month() || is_day()))
 {$m = get_query_var('m');
switch ( strlen($m) ) {
case 4:$redirect_url = get_year_link($m);
break ;
case 6:$redirect_url = get_month_link(substr($m,0,4),substr($m,4,2));
break ;
case 8:$redirect_url = get_day_link(substr($m,0,4),substr($m,4,2),substr($m,6,2));
break ;
 }
if ( $redirect_url)
 $redirect['query'] = remove_query_arg('m',$redirect['query']);
}elseif ( is_day() && get_query_var('year') && get_query_var('monthnum') && !(empty($_GET[0]['day']) || Aspis_empty($_GET[0]['day'])))
 {if ( $redirect_url = get_day_link(get_query_var('year'),get_query_var('monthnum'),get_query_var('day')))
 $redirect['query'] = remove_query_arg(array('year','monthnum','day'),$redirect['query']);
}elseif ( is_month() && get_query_var('year') && !(empty($_GET[0]['monthnum']) || Aspis_empty($_GET[0]['monthnum'])))
 {if ( $redirect_url = get_month_link(get_query_var('year'),get_query_var('monthnum')))
 $redirect['query'] = remove_query_arg(array('year','monthnum'),$redirect['query']);
}elseif ( is_year() && !(empty($_GET[0]['year']) || Aspis_empty($_GET[0]['year'])))
 {if ( $redirect_url = get_year_link(get_query_var('year')))
 $redirect['query'] = remove_query_arg('year',$redirect['query']);
}elseif ( is_category() && !(empty($_GET[0]['cat']) || Aspis_empty($_GET[0]['cat'])) && preg_match('|^[0-9]+$|',deAspisWarningRC($_GET[0]['cat'])))
 {if ( $redirect_url = get_category_link(get_query_var('cat')))
 $redirect['query'] = remove_query_arg('cat',$redirect['query']);
}elseif ( is_author() && !(empty($_GET[0]['author']) || Aspis_empty($_GET[0]['author'])) && preg_match('|^[0-9]+$|',deAspisWarningRC($_GET[0]['author'])))
 {$author = get_userdata(get_query_var('author'));
if ( false !== $author && $redirect_url = get_author_posts_url($author->ID,$author->user_nicename))
 $redirect['query'] = remove_query_arg('author',$redirect['author']);
}if ( get_query_var('paged') || is_feed() || get_query_var('cpage'))
 {if ( !$redirect_url)
 $redirect_url = $requested_url;
$paged_redirect = @parse_url($redirect_url);
while ( preg_match('#/page/[0-9]+?(/+)?$#',$paged_redirect['path']) || preg_match('#/(comments/?)?(feed|rss|rdf|atom|rss2)(/+)?$#',$paged_redirect['path']) || preg_match('#/comment-page-[0-9]+(/+)?$#',$paged_redirect['path']) )
{$paged_redirect['path'] = preg_replace('#/page/[0-9]+?(/+)?$#','/',$paged_redirect['path']);
$paged_redirect['path'] = preg_replace('#/(comments/?)?(feed|rss2?|rdf|atom)(/+|$)#','/',$paged_redirect['path']);
$paged_redirect['path'] = preg_replace('#/comment-page-[0-9]+?(/+)?$#','/',$paged_redirect['path']);
}$addl_path = '';
if ( is_feed())
 {$addl_path = !empty($addl_path) ? trailingslashit($addl_path) : '';
if ( get_query_var('withcomments'))
 $addl_path .= 'comments/';
$addl_path .= user_trailingslashit('feed/' . (('rss2' == get_query_var('feed') || 'feed' == get_query_var('feed')) ? '' : get_query_var('feed')),'feed');
$redirect['query'] = remove_query_arg('feed',$redirect['query']);
}if ( get_query_var('paged') > 0)
 {$paged = get_query_var('paged');
$redirect['query'] = remove_query_arg('paged',$redirect['query']);
if ( !is_feed())
 {if ( $paged > 1 && !is_single())
 {$addl_path = (!empty($addl_path) ? trailingslashit($addl_path) : '') . user_trailingslashit("page/$paged",'paged');
}elseif ( !is_single())
 {$addl_path = (!empty($addl_path) ? trailingslashit($addl_path) : '') . user_trailingslashit($paged_redirect['path'],'paged');
}}elseif ( $paged > 1)
 {$redirect['query'] = add_query_arg('paged',$paged,$redirect['query']);
}}if ( get_option('page_comments') && (('newest' == get_option('default_comments_page') && get_query_var('cpage') > 0) || ('newest' != get_option('default_comments_page') && get_query_var('cpage') > 1)))
 {$addl_path = (!empty($addl_path) ? trailingslashit($addl_path) : '') . user_trailingslashit('comment-page-' . get_query_var('cpage'),'commentpaged');
$redirect['query'] = remove_query_arg('cpage',$redirect['query']);
}$paged_redirect['path'] = user_trailingslashit(preg_replace('|/index.php/?$|','/',$paged_redirect['path']));
if ( !empty($addl_path) && $wp_rewrite->using_index_permalinks() && strpos($paged_redirect['path'],'/index.php/') === false)
 $paged_redirect['path'] = trailingslashit($paged_redirect['path']) . 'index.php/';
if ( !empty($addl_path))
 $paged_redirect['path'] = trailingslashit($paged_redirect['path']) . $addl_path;
$redirect_url = $paged_redirect['scheme'] . '://' . $paged_redirect['host'] . $paged_redirect['path'];
$redirect['path'] = $paged_redirect['path'];
}}$redirect['query'] = preg_replace('#^\??&*?#','',$redirect['query']);
if ( $redirect_url && !empty($redirect['query']))
 {if ( strpos($redirect_url,'?') !== false)
 $redirect_url .= '&';
else 
{$redirect_url .= '?';
}$redirect_url .= $redirect['query'];
}if ( $redirect_url)
 $redirect = @parse_url($redirect_url);
$user_home = @parse_url(get_option('home'));
if ( !empty($user_home['host']))
 $redirect['host'] = $user_home['host'];
if ( empty($user_home['path']))
 $user_home['path'] = '/';
if ( !empty($user_home['port']))
 $redirect['port'] = $user_home['port'];
else 
{unset($redirect['port']);
}$redirect['path'] = preg_replace('|/index.php/*?$|','/',$redirect['path']);
$redirect['path'] = preg_replace('#(%20| )+$#','',$redirect['path']);
if ( !empty($redirect['query']))
 {$redirect['query'] = preg_replace('#((p|page_id|cat|tag)=[^&]*?)(%20| )+$#','$1',$redirect['query']);
$redirect['query'] = trim(preg_replace('#(^|&)(p|page_id|cat|tag)=?(&|$)#','&',$redirect['query']),'&');
$redirect['query'] = preg_replace('#^\??&*?#','',$redirect['query']);
}if ( !$wp_rewrite->using_index_permalinks())
 $redirect['path'] = str_replace('/index.php/','/',$redirect['path']);
if ( is_object($wp_rewrite) && $wp_rewrite->using_permalinks() && !is_404() && (!is_front_page() || (is_front_page() && (get_query_var('paged') > 1))))
 {$user_ts_type = '';
if ( get_query_var('paged') > 0)
 {$user_ts_type = 'paged';
}else 
{{foreach ( array('single','category','page','day','month','year','home') as $type  )
{$func = 'is_' . $type;
if ( AspisUntainted_call_user_func($func))
 {$user_ts_type = $type;
break ;
}}}}$redirect['path'] = user_trailingslashit($redirect['path'],$user_ts_type);
}elseif ( is_front_page())
 {$redirect['path'] = trailingslashit($redirect['path']);
}if ( trailingslashit($redirect['path']) == trailingslashit($user_home['path']))
 $redirect['path'] = trailingslashit($redirect['path']);
if ( strtolower($original['host']) == strtolower($redirect['host']) || (strtolower($original['host']) != 'www.' . strtolower($redirect['host']) && 'www.' . strtolower($original['host']) != strtolower($redirect['host'])))
 $redirect['host'] = $original['host'];
$compare_original = array($original['host'],$original['path']);
if ( !empty($original['port']))
 $compare_original[] = $original['port'];
if ( !empty($original['query']))
 $compare_original[] = $original['query'];
$compare_redirect = array($redirect['host'],$redirect['path']);
if ( !empty($redirect['port']))
 $compare_redirect[] = $redirect['port'];
if ( !empty($redirect['query']))
 $compare_redirect[] = $redirect['query'];
if ( $compare_original !== $compare_redirect)
 {$redirect_url = $redirect['scheme'] . '://' . $redirect['host'];
if ( !empty($redirect['port']))
 $redirect_url .= ':' . $redirect['port'];
$redirect_url .= $redirect['path'];
if ( !empty($redirect['query']))
 $redirect_url .= '?' . $redirect['query'];
}if ( $redirect_url == $requested_url)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$is_IIS",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$redirect_url = apply_filters('redirect_canonical',$redirect_url,$requested_url);
if ( !$redirect_url || $redirect_url == $requested_url)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$is_IIS",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( $do_redirect)
 {if ( !redirect_canonical($redirect_url,false))
 {wp_redirect($redirect_url,301);
exit();
}else 
{{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$is_IIS",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}}else 
{{{$AspisRetTemp = $redirect_url;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$is_IIS",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$is_IIS",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wpdb",$AspisChangesCache);
 }
function redirect_guess_404_permalink (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !get_query_var('name'))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$where = $wpdb->prepare("post_name LIKE %s",get_query_var('name') . '%');
if ( get_query_var('year'))
 $where .= $wpdb->prepare(" AND YEAR(post_date) = %d",get_query_var('year'));
if ( get_query_var('monthnum'))
 $where .= $wpdb->prepare(" AND MONTH(post_date) = %d",get_query_var('monthnum'));
if ( get_query_var('day'))
 $where .= $wpdb->prepare(" AND DAYOFMONTH(post_date) = %d",get_query_var('day'));
$post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE $where AND post_status = 'publish'");
if ( !$post_id)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = get_permalink($post_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
add_action('template_redirect','redirect_canonical');
;
?>
<?php 