<?php require_once('AspisMain.php'); ?><?php
function check_comment ( $author,$email,$url,$comment,$user_ip,$user_agent,$comment_type ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( 1 == get_option('comment_moderation'))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( get_option('comment_max_links') && preg_match_all("/<[Aa][^>]*[Hh][Rr][Ee][Ff]=['\"]([^\"'>]+)[^>]*>/",apply_filters('comment_text',$comment),$out) >= get_option('comment_max_links'))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$mod_keys = trim(get_option('moderation_keys'));
if ( !empty($mod_keys))
 {$words = explode("\n",$mod_keys);
foreach ( (array)$words as $word  )
{$word = trim($word);
if ( empty($word))
 continue ;
$word = preg_quote($word,'#');
$pattern = "#$word#i";
if ( preg_match($pattern,$author))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( preg_match($pattern,$email))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( preg_match($pattern,$url))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( preg_match($pattern,$comment))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( preg_match($pattern,$user_ip))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( preg_match($pattern,$user_agent))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}if ( 1 == get_option('comment_whitelist'))
 {if ( 'trackback' == $comment_type || 'pingback' == $comment_type)
 {$uri = parse_url($url);
$domain = $uri['host'];
$uri = parse_url(get_option('home'));
$home_domain = $uri['host'];
if ( $wpdb->get_var($wpdb->prepare("SELECT link_id FROM $wpdb->links WHERE link_url LIKE (%s) LIMIT 1",'%' . $domain . '%')) || $domain == $home_domain)
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}elseif ( $author != '' && $email != '')
 {$ok_to_comment = $wpdb->get_var("SELECT comment_approved FROM $wpdb->comments WHERE comment_author = '$author' AND comment_author_email = '$email' and comment_approved = '1' LIMIT 1");
if ( (1 == $ok_to_comment) && (empty($mod_keys) || false === strpos($email,$mod_keys)))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}else 
{{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}}{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_approved_comments ( $post_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}{$AspisRetTemp = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved = '1' ORDER BY comment_date",$post_id));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function &get_comment ( &$comment,$output = OBJECT ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$null = null;
if ( empty($comment))
 {if ( isset($GLOBALS[0]['comment']))
 $_comment = &$GLOBALS[0]['comment'];
else 
{$_comment = null;
}}elseif ( is_object($comment))
 {wp_cache_add($comment->comment_ID,$comment,'comment');
$_comment = $comment;
}else 
{{if ( isset($GLOBALS[0]['comment']) && ($GLOBALS[0]['comment']->comment_ID == $comment))
 {$_comment = &$GLOBALS[0]['comment'];
}elseif ( !$_comment = wp_cache_get($comment,'comment'))
 {$_comment = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_ID = %d LIMIT 1",$comment));
if ( !$_comment)
 {$AspisRetTemp = &$null;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}wp_cache_add($_comment->comment_ID,$_comment,'comment');
}}}$_comment = apply_filters('get_comment',$_comment);
if ( $output == OBJECT)
 {{$AspisRetTemp = &$_comment;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( $output == ARRAY_A)
 {$__comment = get_object_vars($_comment);
{$AspisRetTemp = &$__comment;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}elseif ( $output == ARRAY_N)
 {$__comment = array_values(get_object_vars($_comment));
{$AspisRetTemp = &$__comment;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = &$_comment;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_comments ( $args = '' ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$defaults = array('status' => '','orderby' => 'comment_date_gmt','order' => 'DESC','number' => '','offset' => '','post_id' => 0);
$args = wp_parse_args($args,$defaults);
extract(($args),EXTR_SKIP);
$key = md5(serialize(compact(array_keys($defaults))));
$last_changed = wp_cache_get('last_changed','comment');
if ( !$last_changed)
 {$last_changed = time();
wp_cache_set('last_changed',$last_changed,'comment');
}$cache_key = "get_comments:$key:$last_changed";
if ( $cache = wp_cache_get($cache_key,'comment'))
 {{$AspisRetTemp = $cache;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}$post_id = absint($post_id);
if ( 'hold' == $status)
 $approved = "comment_approved = '0'";
elseif ( 'approve' == $status)
 $approved = "comment_approved = '1'";
elseif ( 'spam' == $status)
 $approved = "comment_approved = 'spam'";
elseif ( 'trash' == $status)
 $approved = "comment_approved = 'trash'";
else 
{$approved = "( comment_approved = '0' OR comment_approved = '1' )";
}$order = ('ASC' == $order) ? 'ASC' : 'DESC';
$orderby = 'comment_date_gmt';
$number = absint($number);
$offset = absint($offset);
if ( !empty($number))
 {if ( $offset)
 $number = 'LIMIT ' . $offset . ',' . $number;
else 
{$number = 'LIMIT ' . $number;
}}else 
{{$number = '';
}}if ( !empty($post_id))
 $post_where = $wpdb->prepare('comment_post_ID = %d AND',$post_id);
else 
{$post_where = '';
}$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE $post_where $approved ORDER BY $orderby $order $number");
wp_cache_add($cache_key,$comments,'comment');
{$AspisRetTemp = $comments;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_comment_statuses (  ) {
$status = array('hold' => __('Unapproved'),'approve' => _x('Approved','adjective'),'spam' => _x('Spam','adjective'),);
{$AspisRetTemp = $status;
return $AspisRetTemp;
} }
function get_lastcommentmodified ( $timezone = 'server' ) {
{global $cache_lastcommentmodified,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $cache_lastcommentmodified,"\$cache_lastcommentmodified",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( isset($cache_lastcommentmodified[$timezone]))
 {$AspisRetTemp = $cache_lastcommentmodified[$timezone];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$cache_lastcommentmodified",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$add_seconds_server = date('Z');
switch ( strtolower($timezone) ) {
case 'gmt':$lastcommentmodified = $wpdb->get_var("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 1");
break ;
case 'blog':$lastcommentmodified = $wpdb->get_var("SELECT comment_date FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 1");
break ;
case 'server':$lastcommentmodified = $wpdb->get_var($wpdb->prepare("SELECT DATE_ADD(comment_date_gmt, INTERVAL %s SECOND) FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 1",$add_seconds_server));
break ;
 }
$cache_lastcommentmodified[$timezone] = $lastcommentmodified;
{$AspisRetTemp = $lastcommentmodified;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$cache_lastcommentmodified",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$cache_lastcommentmodified",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function get_comment_count ( $post_id = 0 ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post_id = (int)$post_id;
$where = '';
if ( $post_id > 0)
 {$where = $wpdb->prepare("WHERE comment_post_ID = %d",$post_id);
}$totals = (array)$wpdb->get_results("
		SELECT comment_approved, COUNT( * ) AS total
		FROM {$wpdb->comments}
		{$where}
		GROUP BY comment_approved
	",ARRAY_A);
$comment_count = array("approved" => 0,"awaiting_moderation" => 0,"spam" => 0,"total_comments" => 0);
foreach ( $totals as $row  )
{switch ( $row['comment_approved'] ) {
case 'spam':$comment_count['spam'] = $row['total'];
$comment_count["total_comments"] += $row['total'];
break ;
case 1:$comment_count['approved'] = $row['total'];
$comment_count['total_comments'] += $row['total'];
break ;
case 0:$comment_count['awaiting_moderation'] = $row['total'];
$comment_count['total_comments'] += $row['total'];
break ;
default :break ;
 }
}{$AspisRetTemp = $comment_count;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function add_comment_meta ( $comment_id,$meta_key,$meta_value,$unique = false ) {
{$AspisRetTemp = add_metadata('comment',$comment_id,$meta_key,$meta_value,$unique);
return $AspisRetTemp;
} }
function delete_comment_meta ( $comment_id,$meta_key,$meta_value = '' ) {
{$AspisRetTemp = delete_metadata('comment',$comment_id,$meta_key,$meta_value);
return $AspisRetTemp;
} }
function get_comment_meta ( $comment_id,$key,$single = false ) {
{$AspisRetTemp = get_metadata('comment',$comment_id,$key,$single);
return $AspisRetTemp;
} }
function update_comment_meta ( $comment_id,$meta_key,$meta_value,$prev_value = '' ) {
{$AspisRetTemp = update_metadata('comment',$comment_id,$meta_key,$meta_value,$prev_value);
return $AspisRetTemp;
} }
function sanitize_comment_cookies (  ) {
if ( (isset($_COOKIE[0]['comment_author_' . COOKIEHASH]) && Aspis_isset($_COOKIE[0]['comment_author_' . COOKIEHASH])))
 {$comment_author = apply_filters('pre_comment_author_name',deAspisWarningRC($_COOKIE[0]['comment_author_' . COOKIEHASH]));
$comment_author = stripslashes($comment_author);
$comment_author = esc_attr($comment_author);
$_COOKIE[0]['comment_author_' . COOKIEHASH] = attAspisRCO($comment_author);
}if ( (isset($_COOKIE[0]['comment_author_email_' . COOKIEHASH]) && Aspis_isset($_COOKIE[0]['comment_author_email_' . COOKIEHASH])))
 {$comment_author_email = apply_filters('pre_comment_author_email',deAspisWarningRC($_COOKIE[0]['comment_author_email_' . COOKIEHASH]));
$comment_author_email = stripslashes($comment_author_email);
$comment_author_email = esc_attr($comment_author_email);
$_COOKIE[0]['comment_author_email_' . COOKIEHASH] = attAspisRCO($comment_author_email);
}if ( (isset($_COOKIE[0]['comment_author_url_' . COOKIEHASH]) && Aspis_isset($_COOKIE[0]['comment_author_url_' . COOKIEHASH])))
 {$comment_author_url = apply_filters('pre_comment_author_url',deAspisWarningRC($_COOKIE[0]['comment_author_url_' . COOKIEHASH]));
$comment_author_url = stripslashes($comment_author_url);
$_COOKIE[0]['comment_author_url_' . COOKIEHASH] = attAspisRCO($comment_author_url);
} }
function wp_allow_comment ( $commentdata ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}extract(($commentdata),EXTR_SKIP);
$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND comment_approved != 'trash' AND ( comment_author = '$comment_author' ";
if ( $comment_author_email)
 $dupe .= "OR comment_author_email = '$comment_author_email' ";
$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
if ( $wpdb->get_var($dupe))
 {if ( defined('DOING_AJAX'))
 exit(__('Duplicate comment detected; it looks as though you&#8217;ve already said that!'));
wp_die(__('Duplicate comment detected; it looks as though you&#8217;ve already said that!'));
}do_action('check_comment_flood',$comment_author_IP,$comment_author_email,$comment_date_gmt);
if ( isset($user_id) && $user_id)
 {$userdata = get_userdata($user_id);
$user = new WP_User($user_id);
$post_author = $wpdb->get_var($wpdb->prepare("SELECT post_author FROM $wpdb->posts WHERE ID = %d LIMIT 1",$comment_post_ID));
}if ( isset($userdata) && ($user_id == $post_author || $user->has_cap('moderate_comments')))
 {$approved = 1;
}else 
{{if ( check_comment($comment_author,$comment_author_email,$comment_author_url,$comment_content,$comment_author_IP,$comment_agent,$comment_type))
 $approved = 1;
else 
{$approved = 0;
}if ( wp_blacklist_check($comment_author,$comment_author_email,$comment_author_url,$comment_content,$comment_author_IP,$comment_agent))
 $approved = 'spam';
}}$approved = apply_filters('pre_comment_approved',$approved);
{$AspisRetTemp = $approved;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function check_comment_flood_db ( $ip,$email,$date ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( current_user_can('manage_options'))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$hour_ago = gmdate('Y-m-d H:i:s',time() - 3600);
if ( $lasttime = $wpdb->get_var($wpdb->prepare("SELECT `comment_date_gmt` FROM `$wpdb->comments` WHERE `comment_date_gmt` >= %s AND ( `comment_author_IP` = %s OR `comment_author_email` = %s ) ORDER BY `comment_date_gmt` DESC LIMIT 1",$hour_ago,$ip,$email)))
 {$time_lastcomment = mysql2date('U',$lasttime,false);
$time_newcomment = mysql2date('U',$date,false);
$flood_die = apply_filters('comment_flood_filter',false,$time_lastcomment,$time_newcomment);
if ( $flood_die)
 {do_action('comment_flood_trigger',$time_lastcomment,$time_newcomment);
if ( defined('DOING_AJAX'))
 exit(__('You are posting comments too quickly.  Slow down.'));
wp_die(__('You are posting comments too quickly.  Slow down.'),'',array('response' => 403));
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function &separate_comments ( &$comments ) {
$comments_by_type = array('comment' => array(),'trackback' => array(),'pingback' => array(),'pings' => array());
$count = count($comments);
for ( $i = 0 ; $i < $count ; $i++ )
{$type = $comments[$i]->comment_type;
if ( empty($type))
 $type = 'comment';
$comments_by_type[$type][] = &$comments[$i];
if ( 'trackback' == $type || 'pingback' == $type)
 $comments_by_type['pings'][] = &$comments[$i];
}{$AspisRetTemp = &$comments_by_type;
return $AspisRetTemp;
} }
function get_comment_pages_count ( $comments = null,$per_page = null,$threaded = null ) {
{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}if ( null === $comments && null === $per_page && null === $threaded && !empty($wp_query->max_num_comment_pages))
 {$AspisRetTemp = $wp_query->max_num_comment_pages;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}if ( !$comments || !is_array($comments))
 $comments = $wp_query->comments;
if ( empty($comments))
 {$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}if ( !isset($per_page))
 $per_page = (int)get_query_var('comments_per_page');
if ( 0 === $per_page)
 $per_page = (int)get_option('comments_per_page');
if ( 0 === $per_page)
 {$AspisRetTemp = 1;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}if ( !isset($threaded))
 $threaded = get_option('thread_comments');
if ( $threaded)
 {$walker = new Walker_Comment;
$count = ceil($walker->get_number_of_root_elements($comments) / $per_page);
}else 
{{$count = ceil(count($comments) / $per_page);
}}{$AspisRetTemp = $count;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function get_page_of_comment ( $comment_ID,$args = array() ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !$comment = get_comment($comment_ID))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$defaults = array('type' => 'all','page' => '','per_page' => '','max_depth' => '');
$args = wp_parse_args($args,$defaults);
if ( '' === $args['per_page'] && get_option('page_comments'))
 $args['per_page'] = get_query_var('comments_per_page');
if ( empty($args['per_page']))
 {$args['per_page'] = 0;
$args['page'] = 0;
}if ( $args['per_page'] < 1)
 {$AspisRetTemp = 1;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( '' === $args['max_depth'])
 {if ( get_option('thread_comments'))
 $args['max_depth'] = get_option('thread_comments_depth');
else 
{$args['max_depth'] = -1;
}}if ( $args['max_depth'] > 1 && 0 != $comment->comment_parent)
 {$AspisRetTemp = get_page_of_comment($comment->comment_parent,$args);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$allowedtypes = array('comment' => '','pingback' => 'pingback','trackback' => 'trackback',);
$comtypewhere = ('all' != $args['type'] && isset($allowedtypes[$args['type']])) ? " AND comment_type = '" . $allowedtypes[$args['type']] . "'" : '';
$oldercoms = $wpdb->get_var($wpdb->prepare("SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_parent = 0 AND comment_approved = '1' AND comment_date_gmt < '%s'" . $comtypewhere,$comment->comment_post_ID,$comment->comment_date_gmt));
if ( 0 == $oldercoms)
 {$AspisRetTemp = 1;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = ceil(($oldercoms + 1) / $args['per_page']);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_blacklist_check ( $author,$email,$url,$comment,$user_ip,$user_agent ) {
do_action('wp_blacklist_check',$author,$email,$url,$comment,$user_ip,$user_agent);
$mod_keys = trim(get_option('blacklist_keys'));
if ( '' == $mod_keys)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$words = explode("\n",$mod_keys);
foreach ( (array)$words as $word  )
{$word = trim($word);
if ( empty($word))
 {continue ;
}$word = preg_quote($word,'#');
$pattern = "#$word#i";
if ( preg_match($pattern,$author) || preg_match($pattern,$email) || preg_match($pattern,$url) || preg_match($pattern,$comment) || preg_match($pattern,$user_ip) || preg_match($pattern,$user_agent))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_count_comments ( $post_id = 0 ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post_id = (int)$post_id;
$stats = apply_filters('wp_count_comments',array(),$post_id);
if ( !empty($stats))
 {$AspisRetTemp = $stats;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$count = wp_cache_get("comments-{$post_id}",'counts');
if ( false !== $count)
 {$AspisRetTemp = $count;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$where = '';
if ( $post_id > 0)
 $where = $wpdb->prepare("WHERE comment_post_ID = %d",$post_id);
$count = $wpdb->get_results("SELECT comment_approved, COUNT( * ) AS num_comments FROM {$wpdb->comments} {$where} GROUP BY comment_approved",ARRAY_A);
$total = 0;
$approved = array('0' => 'moderated','1' => 'approved','spam' => 'spam','trash' => 'trash','post-trashed' => 'post-trashed');
$known_types = array_keys($approved);
foreach ( (array)$count as $row_num =>$row )
{if ( 'post-trashed' != $row['comment_approved'] && 'trash' != $row['comment_approved'])
 $total += $row['num_comments'];
if ( in_array($row['comment_approved'],$known_types))
 $stats[$approved[$row['comment_approved']]] = $row['num_comments'];
}$stats['total_comments'] = $total;
foreach ( $approved as $key  )
{if ( empty($stats[$key]))
 $stats[$key] = 0;
}$stats = (object)$stats;
wp_cache_set("comments-{$post_id}",$stats,'counts');
{$AspisRetTemp = $stats;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_delete_comment ( $comment_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !$comment = get_comment($comment_id))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( wp_get_comment_status($comment_id) != 'trash' && wp_get_comment_status($comment_id) != 'spam' && EMPTY_TRASH_DAYS > 0)
 {$AspisRetTemp = wp_trash_comment($comment_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}do_action('delete_comment',$comment_id);
$children = $wpdb->get_col($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_parent = %d",$comment_id));
if ( !empty($children))
 {$wpdb->update($wpdb->comments,array('comment_parent' => $comment->comment_parent),array('comment_parent' => $comment_id));
clean_comment_cache($children);
}$meta_ids = $wpdb->get_col($wpdb->prepare("SELECT meta_id FROM $wpdb->commentmeta WHERE comment_id = %d ",$comment_id));
if ( !empty($meta_ids))
 {do_action('delete_commentmeta',$meta_ids);
$in_meta_ids = "'" . implode("', '",$meta_ids) . "'";
$wpdb->query("DELETE FROM $wpdb->commentmeta WHERE meta_id IN ($in_meta_ids)");
do_action('deleted_commentmeta',$meta_ids);
}if ( !$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->comments WHERE comment_ID = %d LIMIT 1",$comment_id)))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}do_action('deleted_comment',$comment_id);
$post_id = $comment->comment_post_ID;
if ( $post_id && $comment->comment_approved == 1)
 wp_update_comment_count($post_id);
clean_comment_cache($comment_id);
do_action('wp_set_comment_status',$comment_id,'delete');
wp_transition_comment_status('delete',$comment->comment_approved,$comment);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_trash_comment ( $comment_id ) {
if ( EMPTY_TRASH_DAYS == 0)
 {$AspisRetTemp = wp_delete_comment($comment_id);
return $AspisRetTemp;
}if ( !$comment = get_comment($comment_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}do_action('trash_comment',$comment_id);
if ( wp_set_comment_status($comment_id,'trash'))
 {add_comment_meta($comment_id,'_wp_trash_meta_status',$comment->comment_approved);
add_comment_meta($comment_id,'_wp_trash_meta_time',time());
do_action('trashed_comment',$comment_id);
{$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_untrash_comment ( $comment_id ) {
if ( !(int)$comment_id)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}do_action('untrash_comment',$comment_id);
$status = (string)get_comment_meta($comment_id,'_wp_trash_meta_status',true);
if ( empty($status))
 $status = '0';
if ( wp_set_comment_status($comment_id,$status))
 {delete_comment_meta($comment_id,'_wp_trash_meta_time');
delete_comment_meta($comment_id,'_wp_trash_meta_status');
do_action('untrashed_comment',$comment_id);
{$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_spam_comment ( $comment_id ) {
if ( !$comment = get_comment($comment_id))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}do_action('spam_comment',$comment_id);
if ( wp_set_comment_status($comment_id,'spam'))
 {add_comment_meta($comment_id,'_wp_trash_meta_status',$comment->comment_approved);
do_action('spammed_comment',$comment_id);
{$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_unspam_comment ( $comment_id ) {
if ( !(int)$comment_id)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}do_action('unspam_comment',$comment_id);
$status = (string)get_comment_meta($comment_id,'_wp_trash_meta_status',true);
if ( empty($status))
 $status = '0';
if ( wp_set_comment_status($comment_id,$status))
 {delete_comment_meta($comment_id,'_wp_trash_meta_status');
do_action('unspammed_comment',$comment_id);
{$AspisRetTemp = true;
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_get_comment_status ( $comment_id ) {
$comment = get_comment($comment_id);
if ( !$comment)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$approved = $comment->comment_approved;
if ( $approved == NULL)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}elseif ( $approved == '1')
 {$AspisRetTemp = 'approved';
return $AspisRetTemp;
}elseif ( $approved == '0')
 {$AspisRetTemp = 'unapproved';
return $AspisRetTemp;
}elseif ( $approved == 'spam')
 {$AspisRetTemp = 'spam';
return $AspisRetTemp;
}elseif ( $approved == 'trash')
 {$AspisRetTemp = 'trash';
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function wp_transition_comment_status ( $new_status,$old_status,$comment ) {
$comment_statuses = array(0 => 'unapproved','hold' => 'unapproved',1 => 'approved','approve' => 'approved',);
if ( isset($comment_statuses[$new_status]))
 $new_status = $comment_statuses[$new_status];
if ( isset($comment_statuses[$old_status]))
 $old_status = $comment_statuses[$old_status];
if ( $new_status != $old_status)
 {do_action('transition_comment_status',$new_status,$old_status,$comment);
do_action("comment_${old_status}_to_$new_status",$comment);
}do_action("comment_${new_status}_$comment->comment_type",$comment->comment_ID,$comment);
 }
function wp_get_current_commenter (  ) {
$comment_author = '';
if ( (isset($_COOKIE[0]['comment_author_' . COOKIEHASH]) && Aspis_isset($_COOKIE[0]['comment_author_' . COOKIEHASH])))
 $comment_author = deAspisWarningRC($_COOKIE[0]['comment_author_' . COOKIEHASH]);
$comment_author_email = '';
if ( (isset($_COOKIE[0]['comment_author_email_' . COOKIEHASH]) && Aspis_isset($_COOKIE[0]['comment_author_email_' . COOKIEHASH])))
 $comment_author_email = deAspisWarningRC($_COOKIE[0]['comment_author_email_' . COOKIEHASH]);
$comment_author_url = '';
if ( (isset($_COOKIE[0]['comment_author_url_' . COOKIEHASH]) && Aspis_isset($_COOKIE[0]['comment_author_url_' . COOKIEHASH])))
 $comment_author_url = deAspisWarningRC($_COOKIE[0]['comment_author_url_' . COOKIEHASH]);
{$AspisRetTemp = compact('comment_author','comment_author_email','comment_author_url');
return $AspisRetTemp;
} }
function wp_insert_comment ( $commentdata ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}extract((stripslashes_deep($commentdata)),EXTR_SKIP);
if ( !isset($comment_author_IP))
 $comment_author_IP = '';
if ( !isset($comment_date))
 $comment_date = current_time('mysql');
if ( !isset($comment_date_gmt))
 $comment_date_gmt = get_gmt_from_date($comment_date);
if ( !isset($comment_parent))
 $comment_parent = 0;
if ( !isset($comment_approved))
 $comment_approved = 1;
if ( !isset($comment_karma))
 $comment_karma = 0;
if ( !isset($user_id))
 $user_id = 0;
if ( !isset($comment_type))
 $comment_type = '';
$data = compact('comment_post_ID','comment_author','comment_author_email','comment_author_url','comment_author_IP','comment_date','comment_date_gmt','comment_content','comment_karma','comment_approved','comment_agent','comment_type','comment_parent','user_id');
$wpdb->insert($wpdb->comments,$data);
$id = (int)$wpdb->insert_id;
if ( $comment_approved == 1)
 wp_update_comment_count($comment_post_ID);
$comment = get_comment($id);
do_action('wp_insert_comment',$id,$comment);
{$AspisRetTemp = $id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_filter_comment ( $commentdata ) {
if ( isset($commentdata['user_ID']))
 $commentdata['user_id'] = apply_filters('pre_user_id',$commentdata['user_ID']);
elseif ( isset($commentdata['user_id']))
 $commentdata['user_id'] = apply_filters('pre_user_id',$commentdata['user_id']);
$commentdata['comment_agent'] = apply_filters('pre_comment_user_agent',$commentdata['comment_agent']);
$commentdata['comment_author'] = apply_filters('pre_comment_author_name',$commentdata['comment_author']);
$commentdata['comment_content'] = apply_filters('pre_comment_content',$commentdata['comment_content']);
$commentdata['comment_author_IP'] = apply_filters('pre_comment_user_ip',$commentdata['comment_author_IP']);
$commentdata['comment_author_url'] = apply_filters('pre_comment_author_url',$commentdata['comment_author_url']);
$commentdata['comment_author_email'] = apply_filters('pre_comment_author_email',$commentdata['comment_author_email']);
$commentdata['filtered'] = true;
{$AspisRetTemp = $commentdata;
return $AspisRetTemp;
} }
function wp_throttle_comment_flood ( $block,$time_lastcomment,$time_newcomment ) {
if ( $block)
 {$AspisRetTemp = $block;
return $AspisRetTemp;
}if ( ($time_newcomment - $time_lastcomment) < 15)
 {$AspisRetTemp = true;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function wp_new_comment ( $commentdata ) {
$commentdata = apply_filters('preprocess_comment',$commentdata);
$commentdata['comment_post_ID'] = (int)$commentdata['comment_post_ID'];
if ( isset($commentdata['user_ID']))
 $commentdata['user_id'] = $commentdata['user_ID'] = (int)$commentdata['user_ID'];
elseif ( isset($commentdata['user_id']))
 $commentdata['user_id'] = (int)$commentdata['user_id'];
$commentdata['comment_parent'] = isset($commentdata['comment_parent']) ? absint($commentdata['comment_parent']) : 0;
$parent_status = (0 < $commentdata['comment_parent']) ? wp_get_comment_status($commentdata['comment_parent']) : '';
$commentdata['comment_parent'] = ('approved' == $parent_status || 'unapproved' == $parent_status) ? $commentdata['comment_parent'] : 0;
$commentdata['comment_author_IP'] = preg_replace('/[^0-9a-fA-F:., ]/','',deAspisWarningRC($_SERVER[0]['REMOTE_ADDR']));
$commentdata['comment_agent'] = substr(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),0,254);
$commentdata['comment_date'] = current_time('mysql');
$commentdata['comment_date_gmt'] = current_time('mysql',1);
$commentdata = wp_filter_comment($commentdata);
$commentdata['comment_approved'] = wp_allow_comment($commentdata);
$comment_ID = wp_insert_comment($commentdata);
do_action('comment_post',$comment_ID,$commentdata['comment_approved']);
if ( 'spam' !== $commentdata['comment_approved'])
 {if ( '0' == $commentdata['comment_approved'])
 wp_notify_moderator($comment_ID);
$post = &get_post($commentdata['comment_post_ID']);
if ( get_option('comments_notify') && $commentdata['comment_approved'] && $post->post_author != $commentdata['user_id'])
 wp_notify_postauthor($comment_ID,$commentdata['comment_type']);
}{$AspisRetTemp = $comment_ID;
return $AspisRetTemp;
} }
function wp_set_comment_status ( $comment_id,$comment_status,$wp_error = false ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$status = '0';
switch ( $comment_status ) {
case 'hold':case '0':$status = '0';
break ;
case 'approve':case '1':$status = '1';
if ( get_option('comments_notify'))
 {$comment = get_comment($comment_id);
wp_notify_postauthor($comment_id,$comment->comment_type);
}break ;
case 'spam':$status = 'spam';
break ;
case 'trash':$status = 'trash';
break ;
default :{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
} }
$comment_old = wp_clone(get_comment($comment_id));
if ( !$wpdb->update($wpdb->comments,array('comment_approved' => $status),array('comment_ID' => $comment_id)))
 {if ( $wp_error)
 {$AspisRetTemp = new WP_Error('db_update_error',__('Could not update comment status'),$wpdb->last_error);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}clean_comment_cache($comment_id);
$comment = get_comment($comment_id);
do_action('wp_set_comment_status',$comment_id,$comment_status);
wp_transition_comment_status($comment_status,$comment_old->comment_approved,$comment);
wp_update_comment_count($comment->comment_post_ID);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_update_comment ( $commentarr ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$comment = get_comment($commentarr['comment_ID'],ARRAY_A);
$comment = deAspisWarningRC(esc_sql(attAspisRCO($comment)));
$old_status = $comment['comment_approved'];
$commentarr = array_merge($comment,$commentarr);
$commentarr = wp_filter_comment($commentarr);
extract((stripslashes_deep($commentarr)),EXTR_SKIP);
$comment_content = apply_filters('comment_save_pre',$comment_content);
$comment_date_gmt = get_gmt_from_date($comment_date);
if ( !isset($comment_approved))
 $comment_approved = 1;
else 
{if ( 'hold' == $comment_approved)
 $comment_approved = 0;
else 
{if ( 'approve' == $comment_approved)
 $comment_approved = 1;
}}$data = compact('comment_content','comment_author','comment_author_email','comment_approved','comment_karma','comment_author_url','comment_date','comment_date_gmt');
$wpdb->update($wpdb->comments,$data,compact('comment_ID'));
$rval = $wpdb->rows_affected;
clean_comment_cache($comment_ID);
wp_update_comment_count($comment_post_ID);
do_action('edit_comment',$comment_ID);
$comment = get_comment($comment_ID);
wp_transition_comment_status($comment->comment_approved,$old_status,$comment);
{$AspisRetTemp = $rval;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function wp_defer_comment_counting ( $defer = null ) {
static $_defer = false;
if ( is_bool($defer))
 {$_defer = $defer;
if ( !$defer)
 wp_update_comment_count(null,true);
}{$AspisRetTemp = $_defer;
return $AspisRetTemp;
} }
function wp_update_comment_count ( $post_id,$do_deferred = false ) {
static $_deferred = array();
if ( $do_deferred)
 {$_deferred = array_unique($_deferred);
foreach ( $_deferred as $i =>$_post_id )
{wp_update_comment_count_now($_post_id);
unset($_deferred[$i]);
}}if ( wp_defer_comment_counting())
 {$_deferred[] = $post_id;
{$AspisRetTemp = true;
return $AspisRetTemp;
}}elseif ( $post_id)
 {{$AspisRetTemp = wp_update_comment_count_now($post_id);
return $AspisRetTemp;
}} }
function wp_update_comment_count_now ( $post_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post_id = (int)$post_id;
if ( !$post_id)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( !$post = get_post($post_id))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$old = (int)$post->comment_count;
$new = (int)$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved = '1'",$post_id));
$wpdb->update($wpdb->posts,array('comment_count' => $new),array('ID' => $post_id));
if ( 'page' == $post->post_type)
 clean_page_cache($post_id);
else 
{clean_post_cache($post_id);
}do_action('wp_update_comment_count',$post_id,$new,$old);
do_action('edit_post',$post_id,$post);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function discover_pingback_server_uri ( $url,$deprecated = 2048 ) {
$pingback_str_dquote = 'rel="pingback"';
$pingback_str_squote = 'rel=\'pingback\'';
$parsed_url = parse_url($url);
if ( !isset($parsed_url['host']))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$uploads_dir = wp_upload_dir();
if ( 0 === strpos($url,$uploads_dir['baseurl']))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$response = wp_remote_head($url,array('timeout' => 2,'httpversion' => '1.0'));
if ( is_wp_error($response))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( isset($response['headers']['x-pingback']))
 {$AspisRetTemp = $response['headers']['x-pingback'];
return $AspisRetTemp;
}if ( isset($response['headers']['content-type']) && preg_match('#(image|audio|video|model)/#is',$response['headers']['content-type']))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$response = wp_remote_get($url,array('timeout' => 2,'httpversion' => '1.0'));
if ( is_wp_error($response))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$contents = $response['body'];
$pingback_link_offset_dquote = strpos($contents,$pingback_str_dquote);
$pingback_link_offset_squote = strpos($contents,$pingback_str_squote);
if ( $pingback_link_offset_dquote || $pingback_link_offset_squote)
 {$quote = ($pingback_link_offset_dquote) ? '"' : '\'';
$pingback_link_offset = ($quote == '"') ? $pingback_link_offset_dquote : $pingback_link_offset_squote;
$pingback_href_pos = @strpos($contents,'href=',$pingback_link_offset);
$pingback_href_start = $pingback_href_pos + 6;
$pingback_href_end = @strpos($contents,$quote,$pingback_href_start);
$pingback_server_url_len = $pingback_href_end - $pingback_href_start;
$pingback_server_url = substr($contents,$pingback_href_start,$pingback_server_url_len);
if ( $pingback_server_url_len > 0)
 {{$AspisRetTemp = $pingback_server_url;
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function do_all_pings (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}while ( $ping = $wpdb->get_row("SELECT * FROM {$wpdb->posts}, {$wpdb->postmeta} WHERE {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id AND {$wpdb->postmeta}.meta_key = '_pingme' LIMIT 1") )
{$mid = $wpdb->get_var("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = {$ping->ID} AND meta_key = '_pingme' LIMIT 1");
do_action('delete_postmeta',$mid);
$wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id = %d",$mid));
do_action('deleted_postmeta',$mid);
pingback($ping->post_content,$ping->ID);
}while ( $enclosure = $wpdb->get_row("SELECT * FROM {$wpdb->posts}, {$wpdb->postmeta} WHERE {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id AND {$wpdb->postmeta}.meta_key = '_encloseme' LIMIT 1") )
{$mid = $wpdb->get_var($wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = '_encloseme'",$enclosure->ID));
do_action('delete_postmeta',$mid);
$wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_id =  %d",$mid));
do_action('deleted_postmeta',$mid);
do_enclose($enclosure->post_content,$enclosure->ID);
}$trackbacks = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE to_ping <> '' AND post_status = 'publish'");
if ( is_array($trackbacks))
 foreach ( $trackbacks as $trackback  )
do_trackbacks($trackback);
generic_ping();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function do_trackbacks ( $post_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d",$post_id));
$to_ping = get_to_ping($post_id);
$pinged = get_pung($post_id);
if ( empty($to_ping))
 {$wpdb->update($wpdb->posts,array('to_ping' => ''),array('ID' => $post_id));
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}}if ( empty($post->post_excerpt))
 $excerpt = apply_filters('the_content',$post->post_content);
else 
{$excerpt = apply_filters('the_excerpt',$post->post_excerpt);
}$excerpt = str_replace(']]>',']]&gt;',$excerpt);
$excerpt = wp_html_excerpt($excerpt,252) . '...';
$post_title = apply_filters('the_title',$post->post_title);
$post_title = strip_tags($post_title);
if ( $to_ping)
 {foreach ( (array)$to_ping as $tb_ping  )
{$tb_ping = trim($tb_ping);
if ( !in_array($tb_ping,$pinged))
 {trackback($tb_ping,$post_title,$excerpt,$post_id);
$pinged[] = $tb_ping;
}else 
{{$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET to_ping = TRIM(REPLACE(to_ping, '$tb_ping', '')) WHERE ID = %d",$post_id));
}}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function generic_ping ( $post_id = 0 ) {
$services = get_option('ping_sites');
$services = explode("\n",$services);
foreach ( (array)$services as $service  )
{$service = trim($service);
if ( '' != $service)
 weblog_ping($service);
}{$AspisRetTemp = $post_id;
return $AspisRetTemp;
} }
function pingback ( $content,$post_ID ) {
{global $wp_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_version,"\$wp_version",$AspisChangesCache);
}include_once (ABSPATH . WPINC . '/class-IXR.php');
$post_links = array();
$pung = get_pung($post_ID);
$ltrs = '\w';
$gunk = '/#~:.?+=&%@!\-';
$punc = '.:?\-';
$any = $ltrs . $gunk . $punc;
preg_match_all("{\b http : [$any] +? (?= [$punc] * [^$any] | $)}x",$content,$post_links_temp);
foreach ( (array)$post_links_temp[0] as $link_test  )
{if ( !in_array($link_test,$pung) && (url_to_postid($link_test) != $post_ID) && !is_local_attachment($link_test))
 {if ( $test = @parse_url($link_test))
 {if ( isset($test['query']))
 $post_links[] = $link_test;
elseif ( ($test['path'] != '/') && ($test['path'] != ''))
 $post_links[] = $link_test;
}}}do_action_ref_array('pre_ping',array($post_links,$pung));
foreach ( (array)$post_links as $pagelinkedto  )
{$pingback_server_url = discover_pingback_server_uri($pagelinkedto,2048);
if ( $pingback_server_url)
 {@set_time_limit(60);
$pagelinkedfrom = get_permalink($post_ID);
$client = new IXR_Client($pingback_server_url);
$client->timeout = 3;
$client->useragent = apply_filters('pingback_useragent',$client->useragent . ' -- WordPress/' . $wp_version,$client->useragent,$pingback_server_url,$pagelinkedto,$pagelinkedfrom);
$client->debug = false;
if ( $client->query('pingback.ping',$pagelinkedfrom,$pagelinkedto) || (isset($client->error->code) && 48 == $client->error->code))
 add_ping($post_ID,$pagelinkedto);
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
 }
function privacy_ping_filter ( $sites ) {
if ( '0' != get_option('blog_public'))
 {$AspisRetTemp = $sites;
return $AspisRetTemp;
}else 
{{$AspisRetTemp = '';
return $AspisRetTemp;
}} }
function trackback ( $trackback_url,$title,$excerpt,$ID ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( empty($trackback_url))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$options = array();
$options['timeout'] = 4;
$options['body'] = array('title' => $title,'url' => get_permalink($ID),'blog_name' => get_option('blogname'),'excerpt' => $excerpt);
$response = wp_remote_post($trackback_url,$options);
if ( is_wp_error($response))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return ;
}$tb_url = addslashes($trackback_url);
$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET pinged = CONCAT(pinged, '\n', '$tb_url') WHERE ID = %d",$ID));
{$AspisRetTemp = $wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET to_ping = TRIM(REPLACE(to_ping, '$tb_url', '')) WHERE ID = %d",$ID));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function weblog_ping ( $server = '',$path = '' ) {
{global $wp_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_version,"\$wp_version",$AspisChangesCache);
}include_once (ABSPATH . WPINC . '/class-IXR.php');
$client = new IXR_Client($server,((!strlen(trim($path)) || ('/' == $path)) ? false : $path));
$client->timeout = 3;
$client->useragent .= ' -- WordPress/' . $wp_version;
$client->debug = false;
$home = trailingslashit(get_option('home'));
if ( !$client->query('weblogUpdates.extendedPing',get_option('blogname'),$home,get_bloginfo('rss2_url')))
 $client->query('weblogUpdates.ping',get_option('blogname'),$home);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_version",$AspisChangesCache);
 }
function clean_comment_cache ( $ids ) {
foreach ( (array)$ids as $id  )
wp_cache_delete($id,'comment');
 }
function update_comment_cache ( $comments ) {
foreach ( (array)$comments as $comment  )
wp_cache_add($comment->comment_ID,$comment,'comment');
 }
function _close_comments_for_old_posts ( $posts ) {
if ( empty($posts) || !is_singular() || !get_option('close_comments_for_old_posts'))
 {$AspisRetTemp = $posts;
return $AspisRetTemp;
}$days_old = (int)get_option('close_comments_days_old');
if ( !$days_old)
 {$AspisRetTemp = $posts;
return $AspisRetTemp;
}if ( time() - strtotime($posts[0]->post_date_gmt) > ($days_old * 24 * 60 * 60))
 {$posts[0]->comment_status = 'closed';
$posts[0]->ping_status = 'closed';
}{$AspisRetTemp = $posts;
return $AspisRetTemp;
} }
function _close_comments_for_old_post ( $open,$post_id ) {
if ( !$open)
 {$AspisRetTemp = $open;
return $AspisRetTemp;
}if ( !get_option('close_comments_for_old_posts'))
 {$AspisRetTemp = $open;
return $AspisRetTemp;
}$days_old = (int)get_option('close_comments_days_old');
if ( !$days_old)
 {$AspisRetTemp = $open;
return $AspisRetTemp;
}$post = get_post($post_id);
if ( time() - strtotime($post->post_date_gmt) > ($days_old * 24 * 60 * 60))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $open;
return $AspisRetTemp;
} }
;
?>
<?php 