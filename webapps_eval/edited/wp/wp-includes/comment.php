<?php require_once('AspisMain.php'); ?><?php
function check_comment ( $author,$email,$url,$comment,$user_ip,$user_agent,$comment_type ) {
global $wpdb;
if ( ((1) == deAspis(get_option(array('comment_moderation',false)))))
 return array(false,false);
if ( (deAspis(get_option(array('comment_max_links',false))) && (deAspis(Aspis_preg_match_all(array("/<[Aa][^>]*[Hh][Rr][Ee][Ff]=['\"]([^\"'>]+)[^>]*>/",false),apply_filters(array('comment_text',false),$comment),$out)) >= deAspis(get_option(array('comment_max_links',false))))))
 return array(false,false);
$mod_keys = Aspis_trim(get_option(array('moderation_keys',false)));
if ( (!((empty($mod_keys) || Aspis_empty( $mod_keys)))))
 {$words = Aspis_explode(array("\n",false),$mod_keys);
foreach ( deAspis(array_cast($words)) as $word  )
{$word = Aspis_trim($word);
if ( ((empty($word) || Aspis_empty( $word))))
 continue ;
$word = Aspis_preg_quote($word,array('#',false));
$pattern = concat2(concat1("#",$word),"#i");
if ( deAspis(Aspis_preg_match($pattern,$author)))
 return array(false,false);
if ( deAspis(Aspis_preg_match($pattern,$email)))
 return array(false,false);
if ( deAspis(Aspis_preg_match($pattern,$url)))
 return array(false,false);
if ( deAspis(Aspis_preg_match($pattern,$comment)))
 return array(false,false);
if ( deAspis(Aspis_preg_match($pattern,$user_ip)))
 return array(false,false);
if ( deAspis(Aspis_preg_match($pattern,$user_agent)))
 return array(false,false);
}}if ( ((1) == deAspis(get_option(array('comment_whitelist',false)))))
 {if ( ((('trackback') == $comment_type[0]) || (('pingback') == $comment_type[0])))
 {$uri = Aspis_parse_url($url);
$domain = $uri[0]['host'];
$uri = Aspis_parse_url(get_option(array('home',false)));
$home_domain = $uri[0]['host'];
if ( (deAspis($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT link_id FROM ",$wpdb[0]->links)," WHERE link_url LIKE (%s) LIMIT 1"),concat2(concat1('%',$domain),'%')))) || ($domain[0] == $home_domain[0])))
 return array(true,false);
else 
{return array(false,false);
}}elseif ( (($author[0] != ('')) && ($email[0] != (''))))
 {$ok_to_comment = $wpdb[0]->get_var(concat2(concat(concat2(concat(concat2(concat1("SELECT comment_approved FROM ",$wpdb[0]->comments)," WHERE comment_author = '"),$author),"' AND comment_author_email = '"),$email),"' and comment_approved = '1' LIMIT 1"));
if ( (((1) == $ok_to_comment[0]) && (((empty($mod_keys) || Aspis_empty( $mod_keys))) || (false === strpos($email[0],deAspisRC($mod_keys))))))
 return array(true,false);
else 
{return array(false,false);
}}else 
{{return array(false,false);
}}}return array(true,false);
 }
function get_approved_comments ( $post_id ) {
global $wpdb;
return $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d AND comment_approved = '1' ORDER BY comment_date"),$post_id));
 }
function &get_comment ( &$comment,$output = array(OBJECT,false) ) {
global $wpdb;
$null = array(null,false);
if ( ((empty($comment) || Aspis_empty( $comment))))
 {if ( ((isset($GLOBALS[0][('comment')]) && Aspis_isset( $GLOBALS [0][('comment')]))))
 $_comment = &$GLOBALS[0][('comment')];
else 
{$_comment = array(null,false);
}}elseif ( is_object($comment[0]))
 {wp_cache_add($comment[0]->comment_ID,$comment,array('comment',false));
$_comment = $comment;
}else 
{{if ( (((isset($GLOBALS[0][('comment')]) && Aspis_isset( $GLOBALS [0][('comment')]))) && ($GLOBALS[0][('comment')][0]->comment_ID[0] == $comment[0])))
 {$_comment = &$GLOBALS[0][('comment')];
}elseif ( (denot_boolean($_comment = wp_cache_get($comment,array('comment',false)))))
 {$_comment = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->comments)," WHERE comment_ID = %d LIMIT 1"),$comment));
if ( (denot_boolean($_comment)))
 return $null;
wp_cache_add($_comment[0]->comment_ID,$_comment,array('comment',false));
}}}$_comment = apply_filters(array('get_comment',false),$_comment);
if ( ($output[0] == OBJECT))
 {return $_comment;
}elseif ( ($output[0] == ARRAY_A))
 {$__comment = attAspis(get_object_vars(deAspisRC($_comment)));
return $__comment;
}elseif ( ($output[0] == ARRAY_N))
 {$__comment = Aspis_array_values(attAspis(get_object_vars(deAspisRC($_comment))));
return $__comment;
}else 
{{return $_comment;
}} }
function get_comments ( $args = array('',false) ) {
global $wpdb;
$defaults = array(array('status' => array('',false,false),'orderby' => array('comment_date_gmt',false,false),'order' => array('DESC',false,false),'number' => array('',false,false),'offset' => array('',false,false),'post_id' => array(0,false,false)),false);
$args = wp_parse_args($args,$defaults);
extract(($args[0]),EXTR_SKIP);
$key = attAspis(md5(deAspis(Aspis_serialize(array(compact(deAspisRC(attAspisRC(array_keys(deAspisRC($defaults))))),false)))));
$last_changed = wp_cache_get(array('last_changed',false),array('comment',false));
if ( (denot_boolean($last_changed)))
 {$last_changed = attAspis(time());
wp_cache_set(array('last_changed',false),$last_changed,array('comment',false));
}$cache_key = concat(concat2(concat1("get_comments:",$key),":"),$last_changed);
if ( deAspis($cache = wp_cache_get($cache_key,array('comment',false))))
 {return $cache;
}$post_id = absint($post_id);
if ( (('hold') == $status[0]))
 $approved = array("comment_approved = '0'",false);
elseif ( (('approve') == $status[0]))
 $approved = array("comment_approved = '1'",false);
elseif ( (('spam') == $status[0]))
 $approved = array("comment_approved = 'spam'",false);
elseif ( (('trash') == $status[0]))
 $approved = array("comment_approved = 'trash'",false);
else 
{$approved = array("( comment_approved = '0' OR comment_approved = '1' )",false);
}$order = (('ASC') == $order[0]) ? array('ASC',false) : array('DESC',false);
$orderby = array('comment_date_gmt',false);
$number = absint($number);
$offset = absint($offset);
if ( (!((empty($number) || Aspis_empty( $number)))))
 {if ( $offset[0])
 $number = concat(concat2(concat1('LIMIT ',$offset),','),$number);
else 
{$number = concat1('LIMIT ',$number);
}}else 
{{$number = array('',false);
}}if ( (!((empty($post_id) || Aspis_empty( $post_id)))))
 $post_where = $wpdb[0]->prepare(array('comment_post_ID = %d AND',false),$post_id);
else 
{$post_where = array('',false);
}$comments = $wpdb[0]->get_results(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT * FROM ",$wpdb[0]->comments)," WHERE "),$post_where)," "),$approved)," ORDER BY "),$orderby)," "),$order)," "),$number));
wp_cache_add($cache_key,$comments,array('comment',false));
return $comments;
 }
function get_comment_statuses (  ) {
$status = array(array(deregisterTaint(array('hold',false)) => addTaint(__(array('Unapproved',false))),deregisterTaint(array('approve',false)) => addTaint(_x(array('Approved',false),array('adjective',false))),deregisterTaint(array('spam',false)) => addTaint(_x(array('Spam',false),array('adjective',false))),),false);
return $status;
 }
function get_lastcommentmodified ( $timezone = array('server',false) ) {
global $cache_lastcommentmodified,$wpdb;
if ( ((isset($cache_lastcommentmodified[0][$timezone[0]]) && Aspis_isset( $cache_lastcommentmodified [0][$timezone[0]]))))
 return attachAspis($cache_lastcommentmodified,$timezone[0]);
$add_seconds_server = attAspis(date(('Z')));
switch ( deAspis(Aspis_strtolower($timezone)) ) {
case ('gmt'):$lastcommentmodified = $wpdb[0]->get_var(concat2(concat1("SELECT comment_date_gmt FROM ",$wpdb[0]->comments)," WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 1"));
break ;
case ('blog'):$lastcommentmodified = $wpdb[0]->get_var(concat2(concat1("SELECT comment_date FROM ",$wpdb[0]->comments)," WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 1"));
break ;
case ('server'):$lastcommentmodified = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT DATE_ADD(comment_date_gmt, INTERVAL %s SECOND) FROM ",$wpdb[0]->comments)," WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 1"),$add_seconds_server));
break ;
 }
arrayAssign($cache_lastcommentmodified[0],deAspis(registerTaint($timezone)),addTaint($lastcommentmodified));
return $lastcommentmodified;
 }
function get_comment_count ( $post_id = array(0,false) ) {
global $wpdb;
$post_id = int_cast($post_id);
$where = array('',false);
if ( ($post_id[0] > (0)))
 {$where = $wpdb[0]->prepare(array("WHERE comment_post_ID = %d",false),$post_id);
}$totals = array_cast($wpdb[0]->get_results(concat2(concat(concat2(concat1("
		SELECT comment_approved, COUNT( * ) AS total
		FROM ",$wpdb[0]->comments),"
		"),$where),"
		GROUP BY comment_approved
	"),array(ARRAY_A,false)));
$comment_count = array(array("approved" => array(0,false,false),"awaiting_moderation" => array(0,false,false),"spam" => array(0,false,false),"total_comments" => array(0,false,false)),false);
foreach ( $totals[0] as $row  )
{switch ( deAspis($row[0]['comment_approved']) ) {
case ('spam'):arrayAssign($comment_count[0],deAspis(registerTaint(array('spam',false))),addTaint($row[0]['total']));
arrayAssign($comment_count[0],deAspis(registerTaint(array("total_comments",false))),addTaint(array(deAspis($row[0]['total']) + deAspis($comment_count[0]["total_comments"]),false)));
break ;
case (1):arrayAssign($comment_count[0],deAspis(registerTaint(array('approved',false))),addTaint($row[0]['total']));
arrayAssign($comment_count[0],deAspis(registerTaint(array('total_comments',false))),addTaint(array(deAspis($row[0]['total']) + deAspis($comment_count[0]['total_comments']),false)));
break ;
case (0):arrayAssign($comment_count[0],deAspis(registerTaint(array('awaiting_moderation',false))),addTaint($row[0]['total']));
arrayAssign($comment_count[0],deAspis(registerTaint(array('total_comments',false))),addTaint(array(deAspis($row[0]['total']) + deAspis($comment_count[0]['total_comments']),false)));
break ;
default :break ;
 }
}return $comment_count;
 }
function add_comment_meta ( $comment_id,$meta_key,$meta_value,$unique = array(false,false) ) {
return add_metadata(array('comment',false),$comment_id,$meta_key,$meta_value,$unique);
 }
function delete_comment_meta ( $comment_id,$meta_key,$meta_value = array('',false) ) {
return delete_metadata(array('comment',false),$comment_id,$meta_key,$meta_value);
 }
function get_comment_meta ( $comment_id,$key,$single = array(false,false) ) {
return get_metadata(array('comment',false),$comment_id,$key,$single);
 }
function update_comment_meta ( $comment_id,$meta_key,$meta_value,$prev_value = array('',false) ) {
return update_metadata(array('comment',false),$comment_id,$meta_key,$meta_value,$prev_value);
 }
function sanitize_comment_cookies (  ) {
if ( ((isset($_COOKIE[0][(deconcat12('comment_author_',COOKIEHASH))]) && Aspis_isset( $_COOKIE [0][(deconcat12('comment_author_',COOKIEHASH))]))))
 {$comment_author = apply_filters(array('pre_comment_author_name',false),attachAspis($_COOKIE,(deconcat12('comment_author_',COOKIEHASH))));
$comment_author = Aspis_stripslashes($comment_author);
$comment_author = esc_attr($comment_author);
arrayAssign($_COOKIE[0],deAspis(registerTaint(concat12('comment_author_',COOKIEHASH))),addTaint($comment_author));
}if ( ((isset($_COOKIE[0][(deconcat12('comment_author_email_',COOKIEHASH))]) && Aspis_isset( $_COOKIE [0][(deconcat12('comment_author_email_',COOKIEHASH))]))))
 {$comment_author_email = apply_filters(array('pre_comment_author_email',false),attachAspis($_COOKIE,(deconcat12('comment_author_email_',COOKIEHASH))));
$comment_author_email = Aspis_stripslashes($comment_author_email);
$comment_author_email = esc_attr($comment_author_email);
arrayAssign($_COOKIE[0],deAspis(registerTaint(concat12('comment_author_email_',COOKIEHASH))),addTaint($comment_author_email));
}if ( ((isset($_COOKIE[0][(deconcat12('comment_author_url_',COOKIEHASH))]) && Aspis_isset( $_COOKIE [0][(deconcat12('comment_author_url_',COOKIEHASH))]))))
 {$comment_author_url = apply_filters(array('pre_comment_author_url',false),attachAspis($_COOKIE,(deconcat12('comment_author_url_',COOKIEHASH))));
$comment_author_url = Aspis_stripslashes($comment_author_url);
arrayAssign($_COOKIE[0],deAspis(registerTaint(concat12('comment_author_url_',COOKIEHASH))),addTaint($comment_author_url));
} }
function wp_allow_comment ( $commentdata ) {
global $wpdb;
extract(($commentdata[0]),EXTR_SKIP);
$dupe = concat2(concat(concat2(concat(concat2(concat1("SELECT comment_ID FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = '"),$comment_post_ID),"' AND comment_approved != 'trash' AND ( comment_author = '"),$comment_author),"' ");
if ( $comment_author_email[0])
 $dupe = concat($dupe,concat2(concat1("OR comment_author_email = '",$comment_author_email),"' "));
$dupe = concat($dupe,concat2(concat1(") AND comment_content = '",$comment_content),"' LIMIT 1"));
if ( deAspis($wpdb[0]->get_var($dupe)))
 {if ( defined(('DOING_AJAX')))
 Aspis_exit(__(array('Duplicate comment detected; it looks as though you&#8217;ve already said that!',false)));
wp_die(__(array('Duplicate comment detected; it looks as though you&#8217;ve already said that!',false)));
}do_action(array('check_comment_flood',false),$comment_author_IP,$comment_author_email,$comment_date_gmt);
if ( (((isset($user_id) && Aspis_isset( $user_id))) && $user_id[0]))
 {$userdata = get_userdata($user_id);
$user = array(new WP_User($user_id),false);
$post_author = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT post_author FROM ",$wpdb[0]->posts)," WHERE ID = %d LIMIT 1"),$comment_post_ID));
}if ( (((isset($userdata) && Aspis_isset( $userdata))) && (($user_id[0] == $post_author[0]) || deAspis($user[0]->has_cap(array('moderate_comments',false))))))
 {$approved = array(1,false);
}else 
{{if ( deAspis(check_comment($comment_author,$comment_author_email,$comment_author_url,$comment_content,$comment_author_IP,$comment_agent,$comment_type)))
 $approved = array(1,false);
else 
{$approved = array(0,false);
}if ( deAspis(wp_blacklist_check($comment_author,$comment_author_email,$comment_author_url,$comment_content,$comment_author_IP,$comment_agent)))
 $approved = array('spam',false);
}}$approved = apply_filters(array('pre_comment_approved',false),$approved);
return $approved;
 }
function check_comment_flood_db ( $ip,$email,$date ) {
global $wpdb;
if ( deAspis(current_user_can(array('manage_options',false))))
 return ;
$hour_ago = attAspis(gmdate(('Y-m-d H:i:s'),(time() - (3600))));
if ( deAspis($lasttime = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT `comment_date_gmt` FROM `",$wpdb[0]->comments),"` WHERE `comment_date_gmt` >= %s AND ( `comment_author_IP` = %s OR `comment_author_email` = %s ) ORDER BY `comment_date_gmt` DESC LIMIT 1"),$hour_ago,$ip,$email))))
 {$time_lastcomment = mysql2date(array('U',false),$lasttime,array(false,false));
$time_newcomment = mysql2date(array('U',false),$date,array(false,false));
$flood_die = apply_filters(array('comment_flood_filter',false),array(false,false),$time_lastcomment,$time_newcomment);
if ( $flood_die[0])
 {do_action(array('comment_flood_trigger',false),$time_lastcomment,$time_newcomment);
if ( defined(('DOING_AJAX')))
 Aspis_exit(__(array('You are posting comments too quickly.  Slow down.',false)));
wp_die(__(array('You are posting comments too quickly.  Slow down.',false)),array('',false),array(array('response' => array(403,false,false)),false));
}} }
function &separate_comments ( &$comments ) {
$comments_by_type = array(array('comment' => array(array(),false,false),'trackback' => array(array(),false,false),'pingback' => array(array(),false,false),'pings' => array(array(),false,false)),false);
$count = attAspis(count($comments[0]));
for ( $i = array(0,false) ; ($i[0] < $count[0]) ; postincr($i) )
{$type = $comments[0][$i[0]][0]->comment_type;
if ( ((empty($type) || Aspis_empty( $type))))
 $type = array('comment',false);
$comments_by_type[0][$type[0]][0][] = &addTaintR($comments[0][$i[0]]);
if ( ((('trackback') == $type[0]) || (('pingback') == $type[0])))
 $comments_by_type[0][('pings')][0][] = &addTaintR($comments[0][$i[0]]);
}return $comments_by_type;
 }
function get_comment_pages_count ( $comments = array(null,false),$per_page = array(null,false),$threaded = array(null,false) ) {
global $wp_query;
if ( ((((null === $comments[0]) && (null === $per_page[0])) && (null === $threaded[0])) && (!((empty($wp_query[0]->max_num_comment_pages) || Aspis_empty( $wp_query[0] ->max_num_comment_pages ))))))
 return $wp_query[0]->max_num_comment_pages;
if ( ((denot_boolean($comments)) || (!(is_array($comments[0])))))
 $comments = $wp_query[0]->comments;
if ( ((empty($comments) || Aspis_empty( $comments))))
 return array(0,false);
if ( (!((isset($per_page) && Aspis_isset( $per_page)))))
 $per_page = int_cast(get_query_var(array('comments_per_page',false)));
if ( ((0) === $per_page[0]))
 $per_page = int_cast(get_option(array('comments_per_page',false)));
if ( ((0) === $per_page[0]))
 return array(1,false);
if ( (!((isset($threaded) && Aspis_isset( $threaded)))))
 $threaded = get_option(array('thread_comments',false));
if ( $threaded[0])
 {$walker = array(new Walker_Comment,false);
$count = attAspis(ceil((deAspis($walker[0]->get_number_of_root_elements($comments)) / $per_page[0])));
}else 
{{$count = attAspis(ceil((count($comments[0]) / $per_page[0])));
}}return $count;
 }
function get_page_of_comment ( $comment_ID,$args = array(array(),false) ) {
global $wpdb;
if ( (denot_boolean($comment = get_comment($comment_ID))))
 return ;
$defaults = array(array('type' => array('all',false,false),'page' => array('',false,false),'per_page' => array('',false,false),'max_depth' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
if ( ((('') === deAspis($args[0]['per_page'])) && deAspis(get_option(array('page_comments',false)))))
 arrayAssign($args[0],deAspis(registerTaint(array('per_page',false))),addTaint(get_query_var(array('comments_per_page',false))));
if ( ((empty($args[0][('per_page')]) || Aspis_empty( $args [0][('per_page')]))))
 {arrayAssign($args[0],deAspis(registerTaint(array('per_page',false))),addTaint(array(0,false)));
arrayAssign($args[0],deAspis(registerTaint(array('page',false))),addTaint(array(0,false)));
}if ( (deAspis($args[0]['per_page']) < (1)))
 return array(1,false);
if ( (('') === deAspis($args[0]['max_depth'])))
 {if ( deAspis(get_option(array('thread_comments',false))))
 arrayAssign($args[0],deAspis(registerTaint(array('max_depth',false))),addTaint(get_option(array('thread_comments_depth',false))));
else 
{arrayAssign($args[0],deAspis(registerTaint(array('max_depth',false))),addTaint(negate(array(1,false))));
}}if ( ((deAspis($args[0]['max_depth']) > (1)) && ((0) != $comment[0]->comment_parent[0])))
 return get_page_of_comment($comment[0]->comment_parent,$args);
$allowedtypes = array(array('comment' => array('',false,false),'pingback' => array('pingback',false,false),'trackback' => array('trackback',false,false),),false);
$comtypewhere = ((('all') != deAspis($args[0]['type'])) && ((isset($allowedtypes[0][deAspis($args[0]['type'])]) && Aspis_isset( $allowedtypes [0][deAspis($args [0]['type'])])))) ? concat2(concat1(" AND comment_type = '",attachAspis($allowedtypes,deAspis($args[0]['type']))),"'") : array('',false);
$oldercoms = $wpdb[0]->get_var($wpdb[0]->prepare(concat(concat2(concat1("SELECT COUNT(comment_ID) FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d AND comment_parent = 0 AND comment_approved = '1' AND comment_date_gmt < '%s'"),$comtypewhere),$comment[0]->comment_post_ID,$comment[0]->comment_date_gmt));
if ( ((0) == $oldercoms[0]))
 return array(1,false);
return attAspis(ceil((($oldercoms[0] + (1)) / deAspis($args[0]['per_page']))));
 }
function wp_blacklist_check ( $author,$email,$url,$comment,$user_ip,$user_agent ) {
do_action(array('wp_blacklist_check',false),$author,$email,$url,$comment,$user_ip,$user_agent);
$mod_keys = Aspis_trim(get_option(array('blacklist_keys',false)));
if ( (('') == $mod_keys[0]))
 return array(false,false);
$words = Aspis_explode(array("\n",false),$mod_keys);
foreach ( deAspis(array_cast($words)) as $word  )
{$word = Aspis_trim($word);
if ( ((empty($word) || Aspis_empty( $word))))
 {continue ;
}$word = Aspis_preg_quote($word,array('#',false));
$pattern = concat2(concat1("#",$word),"#i");
if ( (((((deAspis(Aspis_preg_match($pattern,$author)) || deAspis(Aspis_preg_match($pattern,$email))) || deAspis(Aspis_preg_match($pattern,$url))) || deAspis(Aspis_preg_match($pattern,$comment))) || deAspis(Aspis_preg_match($pattern,$user_ip))) || deAspis(Aspis_preg_match($pattern,$user_agent))))
 return array(true,false);
}return array(false,false);
 }
function wp_count_comments ( $post_id = array(0,false) ) {
global $wpdb;
$post_id = int_cast($post_id);
$stats = apply_filters(array('wp_count_comments',false),array(array(),false),$post_id);
if ( (!((empty($stats) || Aspis_empty( $stats)))))
 return $stats;
$count = wp_cache_get(concat1("comments-",$post_id),array('counts',false));
if ( (false !== $count[0]))
 return $count;
$where = array('',false);
if ( ($post_id[0] > (0)))
 $where = $wpdb[0]->prepare(array("WHERE comment_post_ID = %d",false),$post_id);
$count = $wpdb[0]->get_results(concat2(concat(concat2(concat1("SELECT comment_approved, COUNT( * ) AS num_comments FROM ",$wpdb[0]->comments)," "),$where)," GROUP BY comment_approved"),array(ARRAY_A,false));
$total = array(0,false);
$approved = array(array('0' => array('moderated',false,false),'1' => array('approved',false,false),'spam' => array('spam',false,false),'trash' => array('trash',false,false),'post-trashed' => array('post-trashed',false,false)),false);
$known_types = attAspisRC(array_keys(deAspisRC($approved)));
foreach ( deAspis(array_cast($count)) as $row_num =>$row )
{restoreTaint($row_num,$row);
{if ( ((('post-trashed') != deAspis($row[0]['comment_approved'])) && (('trash') != deAspis($row[0]['comment_approved']))))
 $total = array(deAspis($row[0]['num_comments']) + $total[0],false);
if ( deAspis(Aspis_in_array($row[0]['comment_approved'],$known_types)))
 arrayAssign($stats[0],deAspis(registerTaint(attachAspis($approved,deAspis($row[0]['comment_approved'])))),addTaint($row[0]['num_comments']));
}}arrayAssign($stats[0],deAspis(registerTaint(array('total_comments',false))),addTaint($total));
foreach ( $approved[0] as $key  )
{if ( ((empty($stats[0][$key[0]]) || Aspis_empty( $stats [0][$key[0]]))))
 arrayAssign($stats[0],deAspis(registerTaint($key)),addTaint(array(0,false)));
}$stats = object_cast($stats);
wp_cache_set(concat1("comments-",$post_id),$stats,array('counts',false));
return $stats;
 }
function wp_delete_comment ( $comment_id ) {
global $wpdb;
if ( (denot_boolean($comment = get_comment($comment_id))))
 return array(false,false);
if ( (((deAspis(wp_get_comment_status($comment_id)) != ('trash')) && (deAspis(wp_get_comment_status($comment_id)) != ('spam'))) && (EMPTY_TRASH_DAYS > (0))))
 return wp_trash_comment($comment_id);
do_action(array('delete_comment',false),$comment_id);
$children = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT comment_ID FROM ",$wpdb[0]->comments)," WHERE comment_parent = %d"),$comment_id));
if ( (!((empty($children) || Aspis_empty( $children)))))
 {$wpdb[0]->update($wpdb[0]->comments,array(array(deregisterTaint(array('comment_parent',false)) => addTaint($comment[0]->comment_parent)),false),array(array(deregisterTaint(array('comment_parent',false)) => addTaint($comment_id)),false));
clean_comment_cache($children);
}$meta_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT meta_id FROM ",$wpdb[0]->commentmeta)," WHERE comment_id = %d "),$comment_id));
if ( (!((empty($meta_ids) || Aspis_empty( $meta_ids)))))
 {do_action(array('delete_commentmeta',false),$meta_ids);
$in_meta_ids = concat2(concat1("'",Aspis_implode(array("', '",false),$meta_ids)),"'");
$wpdb[0]->query(concat2(concat(concat2(concat1("DELETE FROM ",$wpdb[0]->commentmeta)," WHERE meta_id IN ("),$in_meta_ids),")"));
do_action(array('deleted_commentmeta',false),$meta_ids);
}if ( (denot_boolean($wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->comments)," WHERE comment_ID = %d LIMIT 1"),$comment_id)))))
 return array(false,false);
do_action(array('deleted_comment',false),$comment_id);
$post_id = $comment[0]->comment_post_ID;
if ( ($post_id[0] && ($comment[0]->comment_approved[0] == (1))))
 wp_update_comment_count($post_id);
clean_comment_cache($comment_id);
do_action(array('wp_set_comment_status',false),$comment_id,array('delete',false));
wp_transition_comment_status(array('delete',false),$comment[0]->comment_approved,$comment);
return array(true,false);
 }
function wp_trash_comment ( $comment_id ) {
if ( (EMPTY_TRASH_DAYS == (0)))
 return wp_delete_comment($comment_id);
if ( (denot_boolean($comment = get_comment($comment_id))))
 return array(false,false);
do_action(array('trash_comment',false),$comment_id);
if ( deAspis(wp_set_comment_status($comment_id,array('trash',false))))
 {add_comment_meta($comment_id,array('_wp_trash_meta_status',false),$comment[0]->comment_approved);
add_comment_meta($comment_id,array('_wp_trash_meta_time',false),attAspis(time()));
do_action(array('trashed_comment',false),$comment_id);
return array(true,false);
}return array(false,false);
 }
function wp_untrash_comment ( $comment_id ) {
if ( (denot_boolean(int_cast($comment_id))))
 return array(false,false);
do_action(array('untrash_comment',false),$comment_id);
$status = string_cast(get_comment_meta($comment_id,array('_wp_trash_meta_status',false),array(true,false)));
if ( ((empty($status) || Aspis_empty( $status))))
 $status = array('0',false);
if ( deAspis(wp_set_comment_status($comment_id,$status)))
 {delete_comment_meta($comment_id,array('_wp_trash_meta_time',false));
delete_comment_meta($comment_id,array('_wp_trash_meta_status',false));
do_action(array('untrashed_comment',false),$comment_id);
return array(true,false);
}return array(false,false);
 }
function wp_spam_comment ( $comment_id ) {
if ( (denot_boolean($comment = get_comment($comment_id))))
 return array(false,false);
do_action(array('spam_comment',false),$comment_id);
if ( deAspis(wp_set_comment_status($comment_id,array('spam',false))))
 {add_comment_meta($comment_id,array('_wp_trash_meta_status',false),$comment[0]->comment_approved);
do_action(array('spammed_comment',false),$comment_id);
return array(true,false);
}return array(false,false);
 }
function wp_unspam_comment ( $comment_id ) {
if ( (denot_boolean(int_cast($comment_id))))
 return array(false,false);
do_action(array('unspam_comment',false),$comment_id);
$status = string_cast(get_comment_meta($comment_id,array('_wp_trash_meta_status',false),array(true,false)));
if ( ((empty($status) || Aspis_empty( $status))))
 $status = array('0',false);
if ( deAspis(wp_set_comment_status($comment_id,$status)))
 {delete_comment_meta($comment_id,array('_wp_trash_meta_status',false));
do_action(array('unspammed_comment',false),$comment_id);
return array(true,false);
}return array(false,false);
 }
function wp_get_comment_status ( $comment_id ) {
$comment = get_comment($comment_id);
if ( (denot_boolean($comment)))
 return array(false,false);
$approved = $comment[0]->comment_approved;
if ( ($approved[0] == NULL))
 return array(false,false);
elseif ( ($approved[0] == ('1')))
 return array('approved',false);
elseif ( ($approved[0] == ('0')))
 return array('unapproved',false);
elseif ( ($approved[0] == ('spam')))
 return array('spam',false);
elseif ( ($approved[0] == ('trash')))
 return array('trash',false);
else 
{return array(false,false);
} }
function wp_transition_comment_status ( $new_status,$old_status,$comment ) {
$comment_statuses = array(array(0 => array('unapproved',false,false),'hold' => array('unapproved',false,false),1 => array('approved',false,false),'approve' => array('approved',false,false),),false);
if ( ((isset($comment_statuses[0][$new_status[0]]) && Aspis_isset( $comment_statuses [0][$new_status[0]]))))
 $new_status = attachAspis($comment_statuses,$new_status[0]);
if ( ((isset($comment_statuses[0][$old_status[0]]) && Aspis_isset( $comment_statuses [0][$old_status[0]]))))
 $old_status = attachAspis($comment_statuses,$old_status[0]);
if ( ($new_status[0] != $old_status[0]))
 {do_action(array('transition_comment_status',false),$new_status,$old_status,$comment);
do_action(concat(concat2(concat1("comment_",$old_status),"_to_"),$new_status),$comment);
}do_action(concat(concat2(concat1("comment_",$new_status),"_"),$comment[0]->comment_type),$comment[0]->comment_ID,$comment);
 }
function wp_get_current_commenter (  ) {
$comment_author = array('',false);
if ( ((isset($_COOKIE[0][(deconcat12('comment_author_',COOKIEHASH))]) && Aspis_isset( $_COOKIE [0][(deconcat12('comment_author_',COOKIEHASH))]))))
 $comment_author = attachAspis($_COOKIE,(deconcat12('comment_author_',COOKIEHASH)));
$comment_author_email = array('',false);
if ( ((isset($_COOKIE[0][(deconcat12('comment_author_email_',COOKIEHASH))]) && Aspis_isset( $_COOKIE [0][(deconcat12('comment_author_email_',COOKIEHASH))]))))
 $comment_author_email = attachAspis($_COOKIE,(deconcat12('comment_author_email_',COOKIEHASH)));
$comment_author_url = array('',false);
if ( ((isset($_COOKIE[0][(deconcat12('comment_author_url_',COOKIEHASH))]) && Aspis_isset( $_COOKIE [0][(deconcat12('comment_author_url_',COOKIEHASH))]))))
 $comment_author_url = attachAspis($_COOKIE,(deconcat12('comment_author_url_',COOKIEHASH)));
return array(compact('comment_author','comment_author_email','comment_author_url'),false);
 }
function wp_insert_comment ( $commentdata ) {
global $wpdb;
extract((deAspis(stripslashes_deep($commentdata))),EXTR_SKIP);
if ( (!((isset($comment_author_IP) && Aspis_isset( $comment_author_IP)))))
 $comment_author_IP = array('',false);
if ( (!((isset($comment_date) && Aspis_isset( $comment_date)))))
 $comment_date = current_time(array('mysql',false));
if ( (!((isset($comment_date_gmt) && Aspis_isset( $comment_date_gmt)))))
 $comment_date_gmt = get_gmt_from_date($comment_date);
if ( (!((isset($comment_parent) && Aspis_isset( $comment_parent)))))
 $comment_parent = array(0,false);
if ( (!((isset($comment_approved) && Aspis_isset( $comment_approved)))))
 $comment_approved = array(1,false);
if ( (!((isset($comment_karma) && Aspis_isset( $comment_karma)))))
 $comment_karma = array(0,false);
if ( (!((isset($user_id) && Aspis_isset( $user_id)))))
 $user_id = array(0,false);
if ( (!((isset($comment_type) && Aspis_isset( $comment_type)))))
 $comment_type = array('',false);
$data = array(compact('comment_post_ID','comment_author','comment_author_email','comment_author_url','comment_author_IP','comment_date','comment_date_gmt','comment_content','comment_karma','comment_approved','comment_agent','comment_type','comment_parent','user_id'),false);
$wpdb[0]->insert($wpdb[0]->comments,$data);
$id = int_cast($wpdb[0]->insert_id);
if ( ($comment_approved[0] == (1)))
 wp_update_comment_count($comment_post_ID);
$comment = get_comment($id);
do_action(array('wp_insert_comment',false),$id,$comment);
return $id;
 }
function wp_filter_comment ( $commentdata ) {
if ( ((isset($commentdata[0][('user_ID')]) && Aspis_isset( $commentdata [0][('user_ID')]))))
 arrayAssign($commentdata[0],deAspis(registerTaint(array('user_id',false))),addTaint(apply_filters(array('pre_user_id',false),$commentdata[0]['user_ID'])));
elseif ( ((isset($commentdata[0][('user_id')]) && Aspis_isset( $commentdata [0][('user_id')]))))
 arrayAssign($commentdata[0],deAspis(registerTaint(array('user_id',false))),addTaint(apply_filters(array('pre_user_id',false),$commentdata[0]['user_id'])));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_agent',false))),addTaint(apply_filters(array('pre_comment_user_agent',false),$commentdata[0]['comment_agent'])));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_author',false))),addTaint(apply_filters(array('pre_comment_author_name',false),$commentdata[0]['comment_author'])));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_content',false))),addTaint(apply_filters(array('pre_comment_content',false),$commentdata[0]['comment_content'])));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_author_IP',false))),addTaint(apply_filters(array('pre_comment_user_ip',false),$commentdata[0]['comment_author_IP'])));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_author_url',false))),addTaint(apply_filters(array('pre_comment_author_url',false),$commentdata[0]['comment_author_url'])));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_author_email',false))),addTaint(apply_filters(array('pre_comment_author_email',false),$commentdata[0]['comment_author_email'])));
arrayAssign($commentdata[0],deAspis(registerTaint(array('filtered',false))),addTaint(array(true,false)));
return $commentdata;
 }
function wp_throttle_comment_flood ( $block,$time_lastcomment,$time_newcomment ) {
if ( $block[0])
 return $block;
if ( (($time_newcomment[0] - $time_lastcomment[0]) < (15)))
 return array(true,false);
return array(false,false);
 }
function wp_new_comment ( $commentdata ) {
$commentdata = apply_filters(array('preprocess_comment',false),$commentdata);
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_post_ID',false))),addTaint(int_cast($commentdata[0]['comment_post_ID'])));
if ( ((isset($commentdata[0][('user_ID')]) && Aspis_isset( $commentdata [0][('user_ID')]))))
 arrayAssign($commentdata[0],deAspis(registerTaint(array('user_id',false))),addTaint(arrayAssign($commentdata[0],deAspis(registerTaint(array('user_ID',false))),addTaint(int_cast($commentdata[0]['user_ID'])))));
elseif ( ((isset($commentdata[0][('user_id')]) && Aspis_isset( $commentdata [0][('user_id')]))))
 arrayAssign($commentdata[0],deAspis(registerTaint(array('user_id',false))),addTaint(int_cast($commentdata[0]['user_id'])));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_parent',false))),addTaint(((isset($commentdata[0][('comment_parent')]) && Aspis_isset( $commentdata [0][('comment_parent')]))) ? absint($commentdata[0]['comment_parent']) : array(0,false)));
$parent_status = ((0) < deAspis($commentdata[0]['comment_parent'])) ? wp_get_comment_status($commentdata[0]['comment_parent']) : array('',false);
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_parent',false))),addTaint(((('approved') == $parent_status[0]) || (('unapproved') == $parent_status[0])) ? $commentdata[0]['comment_parent'] : array(0,false)));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_author_IP',false))),addTaint(Aspis_preg_replace(array('/[^0-9a-fA-F:., ]/',false),array('',false),$_SERVER[0]['REMOTE_ADDR'])));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_agent',false))),addTaint(Aspis_substr($_SERVER[0]['HTTP_USER_AGENT'],array(0,false),array(254,false))));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_date',false))),addTaint(current_time(array('mysql',false))));
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_date_gmt',false))),addTaint(current_time(array('mysql',false),array(1,false))));
$commentdata = wp_filter_comment($commentdata);
arrayAssign($commentdata[0],deAspis(registerTaint(array('comment_approved',false))),addTaint(wp_allow_comment($commentdata)));
$comment_ID = wp_insert_comment($commentdata);
do_action(array('comment_post',false),$comment_ID,$commentdata[0]['comment_approved']);
if ( (('spam') !== deAspis($commentdata[0]['comment_approved'])))
 {if ( (('0') == deAspis($commentdata[0]['comment_approved'])))
 wp_notify_moderator($comment_ID);
$post = &get_post($commentdata[0][('comment_post_ID')]);
if ( ((deAspis(get_option(array('comments_notify',false))) && deAspis($commentdata[0]['comment_approved'])) && ($post[0]->post_author[0] != deAspis($commentdata[0]['user_id']))))
 wp_notify_postauthor($comment_ID,$commentdata[0]['comment_type']);
}return $comment_ID;
 }
function wp_set_comment_status ( $comment_id,$comment_status,$wp_error = array(false,false) ) {
global $wpdb;
$status = array('0',false);
switch ( $comment_status[0] ) {
case ('hold'):case ('0'):$status = array('0',false);
break ;
case ('approve'):case ('1'):$status = array('1',false);
if ( deAspis(get_option(array('comments_notify',false))))
 {$comment = get_comment($comment_id);
wp_notify_postauthor($comment_id,$comment[0]->comment_type);
}break ;
case ('spam'):$status = array('spam',false);
break ;
case ('trash'):$status = array('trash',false);
break ;
default :return array(false,false);
 }
$comment_old = wp_clone(get_comment($comment_id));
if ( (denot_boolean($wpdb[0]->update($wpdb[0]->comments,array(array(deregisterTaint(array('comment_approved',false)) => addTaint($status)),false),array(array(deregisterTaint(array('comment_ID',false)) => addTaint($comment_id)),false)))))
 {if ( $wp_error[0])
 return array(new WP_Error(array('db_update_error',false),__(array('Could not update comment status',false)),$wpdb[0]->last_error),false);
else 
{return array(false,false);
}}clean_comment_cache($comment_id);
$comment = get_comment($comment_id);
do_action(array('wp_set_comment_status',false),$comment_id,$comment_status);
wp_transition_comment_status($comment_status,$comment_old[0]->comment_approved,$comment);
wp_update_comment_count($comment[0]->comment_post_ID);
return array(true,false);
 }
function wp_update_comment ( $commentarr ) {
global $wpdb;
$comment = get_comment($commentarr[0]['comment_ID'],array(ARRAY_A,false));
$comment = esc_sql($comment);
$old_status = $comment[0]['comment_approved'];
$commentarr = Aspis_array_merge($comment,$commentarr);
$commentarr = wp_filter_comment($commentarr);
extract((deAspis(stripslashes_deep($commentarr))),EXTR_SKIP);
$comment_content = apply_filters(array('comment_save_pre',false),$comment_content);
$comment_date_gmt = get_gmt_from_date($comment_date);
if ( (!((isset($comment_approved) && Aspis_isset( $comment_approved)))))
 $comment_approved = array(1,false);
else 
{if ( (('hold') == $comment_approved[0]))
 $comment_approved = array(0,false);
else 
{if ( (('approve') == $comment_approved[0]))
 $comment_approved = array(1,false);
}}$data = array(compact('comment_content','comment_author','comment_author_email','comment_approved','comment_karma','comment_author_url','comment_date','comment_date_gmt'),false);
$wpdb[0]->update($wpdb[0]->comments,$data,array(compact('comment_ID'),false));
$rval = $wpdb[0]->rows_affected;
clean_comment_cache($comment_ID);
wp_update_comment_count($comment_post_ID);
do_action(array('edit_comment',false),$comment_ID);
$comment = get_comment($comment_ID);
wp_transition_comment_status($comment[0]->comment_approved,$old_status,$comment);
return $rval;
 }
function wp_defer_comment_counting ( $defer = array(null,false) ) {
static $_defer = array(false,false);
if ( is_bool(deAspisRC($defer)))
 {$_defer = $defer;
if ( (denot_boolean($defer)))
 wp_update_comment_count(array(null,false),array(true,false));
}return $_defer;
 }
function wp_update_comment_count ( $post_id,$do_deferred = array(false,false) ) {
static $_deferred = array(array(),false);
if ( $do_deferred[0])
 {$_deferred = attAspisRC(array_unique(deAspisRC($_deferred)));
foreach ( $_deferred[0] as $i =>$_post_id )
{restoreTaint($i,$_post_id);
{wp_update_comment_count_now($_post_id);
unset($_deferred[0][$i[0]]);
}}}if ( deAspis(wp_defer_comment_counting()))
 {arrayAssignAdd($_deferred[0][],addTaint($post_id));
return array(true,false);
}elseif ( $post_id[0])
 {return wp_update_comment_count_now($post_id);
} }
function wp_update_comment_count_now ( $post_id ) {
global $wpdb;
$post_id = int_cast($post_id);
if ( (denot_boolean($post_id)))
 return array(false,false);
if ( (denot_boolean($post = get_post($post_id))))
 return array(false,false);
$old = int_cast($post[0]->comment_count);
$new = int_cast($wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d AND comment_approved = '1'"),$post_id)));
$wpdb[0]->update($wpdb[0]->posts,array(array(deregisterTaint(array('comment_count',false)) => addTaint($new)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($post_id)),false));
if ( (('page') == $post[0]->post_type[0]))
 clean_page_cache($post_id);
else 
{clean_post_cache($post_id);
}do_action(array('wp_update_comment_count',false),$post_id,$new,$old);
do_action(array('edit_post',false),$post_id,$post);
return array(true,false);
 }
function discover_pingback_server_uri ( $url,$deprecated = array(2048,false) ) {
$pingback_str_dquote = array('rel="pingback"',false);
$pingback_str_squote = array('rel=\'pingback\'',false);
$parsed_url = Aspis_parse_url($url);
if ( (!((isset($parsed_url[0][('host')]) && Aspis_isset( $parsed_url [0][('host')])))))
 return array(false,false);
$uploads_dir = wp_upload_dir();
if ( ((0) === strpos($url[0],deAspisRC($uploads_dir[0]['baseurl']))))
 return array(false,false);
$response = wp_remote_head($url,array(array('timeout' => array(2,false,false),'httpversion' => array('1.0',false,false)),false));
if ( deAspis(is_wp_error($response)))
 return array(false,false);
if ( ((isset($response[0][('headers')][0][('x-pingback')]) && Aspis_isset( $response [0][('headers')] [0][('x-pingback')]))))
 return $response[0][('headers')][0]['x-pingback'];
if ( (((isset($response[0][('headers')][0][('content-type')]) && Aspis_isset( $response [0][('headers')] [0][('content-type')]))) && deAspis(Aspis_preg_match(array('#(image|audio|video|model)/#is',false),$response[0][('headers')][0]['content-type']))))
 return array(false,false);
$response = wp_remote_get($url,array(array('timeout' => array(2,false,false),'httpversion' => array('1.0',false,false)),false));
if ( deAspis(is_wp_error($response)))
 return array(false,false);
$contents = $response[0]['body'];
$pingback_link_offset_dquote = attAspis(strpos($contents[0],deAspisRC($pingback_str_dquote)));
$pingback_link_offset_squote = attAspis(strpos($contents[0],deAspisRC($pingback_str_squote)));
if ( ($pingback_link_offset_dquote[0] || $pingback_link_offset_squote[0]))
 {$quote = deAspis(($pingback_link_offset_dquote)) ? array('"',false) : array('\'',false);
$pingback_link_offset = ($quote[0] == ('"')) ? $pingback_link_offset_dquote : $pingback_link_offset_squote;
$pingback_href_pos = @attAspis(strpos($contents[0],'href=',$pingback_link_offset[0]));
$pingback_href_start = array($pingback_href_pos[0] + (6),false);
$pingback_href_end = @attAspis(strpos($contents[0],deAspisRC($quote),$pingback_href_start[0]));
$pingback_server_url_len = array($pingback_href_end[0] - $pingback_href_start[0],false);
$pingback_server_url = Aspis_substr($contents,$pingback_href_start,$pingback_server_url_len);
if ( ($pingback_server_url_len[0] > (0)))
 {return $pingback_server_url;
}}return array(false,false);
 }
function do_all_pings (  ) {
global $wpdb;
while ( deAspis($ping = $wpdb[0]->get_row(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts),", "),$wpdb[0]->postmeta)," WHERE "),$wpdb[0]->posts),".ID = "),$wpdb[0]->postmeta),".post_id AND "),$wpdb[0]->postmeta),".meta_key = '_pingme' LIMIT 1"))) )
{$mid = $wpdb[0]->get_var(concat2(concat(concat2(concat1("SELECT meta_id FROM ",$wpdb[0]->postmeta)," WHERE post_id = "),$ping[0]->ID)," AND meta_key = '_pingme' LIMIT 1"));
do_action(array('delete_postmeta',false),$mid);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->postmeta)," WHERE meta_id = %d"),$mid));
do_action(array('deleted_postmeta',false),$mid);
pingback($ping[0]->post_content,$ping[0]->ID);
}while ( deAspis($enclosure = $wpdb[0]->get_row(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts),", "),$wpdb[0]->postmeta)," WHERE "),$wpdb[0]->posts),".ID = "),$wpdb[0]->postmeta),".post_id AND "),$wpdb[0]->postmeta),".meta_key = '_encloseme' LIMIT 1"))) )
{$mid = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT meta_id FROM ",$wpdb[0]->postmeta)," WHERE post_id = %d AND meta_key = '_encloseme'"),$enclosure[0]->ID));
do_action(array('delete_postmeta',false),$mid);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("DELETE FROM ",$wpdb[0]->postmeta)," WHERE meta_id =  %d"),$mid));
do_action(array('deleted_postmeta',false),$mid);
do_enclose($enclosure[0]->post_content,$enclosure[0]->ID);
}$trackbacks = $wpdb[0]->get_col(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE to_ping <> '' AND post_status = 'publish'"));
if ( is_array($trackbacks[0]))
 foreach ( $trackbacks[0] as $trackback  )
do_trackbacks($trackback);
generic_ping();
 }
function do_trackbacks ( $post_id ) {
global $wpdb;
$post = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$post_id));
$to_ping = get_to_ping($post_id);
$pinged = get_pung($post_id);
if ( ((empty($to_ping) || Aspis_empty( $to_ping))))
 {$wpdb[0]->update($wpdb[0]->posts,array(array('to_ping' => array('',false,false)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($post_id)),false));
return ;
}if ( ((empty($post[0]->post_excerpt) || Aspis_empty( $post[0] ->post_excerpt ))))
 $excerpt = apply_filters(array('the_content',false),$post[0]->post_content);
else 
{$excerpt = apply_filters(array('the_excerpt',false),$post[0]->post_excerpt);
}$excerpt = Aspis_str_replace(array(']]>',false),array(']]&gt;',false),$excerpt);
$excerpt = concat2(wp_html_excerpt($excerpt,array(252,false)),'...');
$post_title = apply_filters(array('the_title',false),$post[0]->post_title);
$post_title = Aspis_strip_tags($post_title);
if ( $to_ping[0])
 {foreach ( deAspis(array_cast($to_ping)) as $tb_ping  )
{$tb_ping = Aspis_trim($tb_ping);
if ( (denot_boolean(Aspis_in_array($tb_ping,$pinged))))
 {trackback($tb_ping,$post_title,$excerpt,$post_id);
arrayAssignAdd($pinged[0][],addTaint($tb_ping));
}else 
{{$wpdb[0]->query($wpdb[0]->prepare(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET to_ping = TRIM(REPLACE(to_ping, '"),$tb_ping),"', '')) WHERE ID = %d"),$post_id));
}}}} }
function generic_ping ( $post_id = array(0,false) ) {
$services = get_option(array('ping_sites',false));
$services = Aspis_explode(array("\n",false),$services);
foreach ( deAspis(array_cast($services)) as $service  )
{$service = Aspis_trim($service);
if ( (('') != $service[0]))
 weblog_ping($service);
}return $post_id;
 }
function pingback ( $content,$post_ID ) {
global $wp_version;
include_once (deconcat2(concat12(ABSPATH,WPINC),'/class-IXR.php'));
$post_links = array(array(),false);
$pung = get_pung($post_ID);
$ltrs = array('\w',false);
$gunk = array('/#~:.?+=&%@!\-',false);
$punc = array('.:?\-',false);
$any = concat(concat($ltrs,$gunk),$punc);
Aspis_preg_match_all(concat2(concat(concat2(concat(concat2(concat1("{\b http : [",$any),"] +? (?= ["),$punc),"] * [^"),$any),"] | $)}x"),$content,$post_links_temp);
foreach ( deAspis(array_cast(attachAspis($post_links_temp,(0)))) as $link_test  )
{if ( (((denot_boolean(Aspis_in_array($link_test,$pung))) && (deAspis(url_to_postid($link_test)) != $post_ID[0])) && (denot_boolean(is_local_attachment($link_test)))))
 {if ( deAspis($test = @Aspis_parse_url($link_test)))
 {if ( ((isset($test[0][('query')]) && Aspis_isset( $test [0][('query')]))))
 arrayAssignAdd($post_links[0][],addTaint($link_test));
elseif ( ((deAspis($test[0]['path']) != ('/')) && (deAspis($test[0]['path']) != (''))))
 arrayAssignAdd($post_links[0][],addTaint($link_test));
}}}do_action_ref_array(array('pre_ping',false),array(array(&$post_links,&$pung),false));
foreach ( deAspis(array_cast($post_links)) as $pagelinkedto  )
{$pingback_server_url = discover_pingback_server_uri($pagelinkedto,array(2048,false));
if ( $pingback_server_url[0])
 {@array(set_time_limit(60),false);
$pagelinkedfrom = get_permalink($post_ID);
$client = array(new IXR_Client($pingback_server_url),false);
$client[0]->timeout = array(3,false);
$client[0]->useragent = apply_filters(array('pingback_useragent',false),concat(concat2($client[0]->useragent,' -- WordPress/'),$wp_version),$client[0]->useragent,$pingback_server_url,$pagelinkedto,$pagelinkedfrom);
$client[0]->debug = array(false,false);
if ( (deAspis($client[0]->query(array('pingback.ping',false),$pagelinkedfrom,$pagelinkedto)) || (((isset($client[0]->error[0]->code) && Aspis_isset( $client[0] ->error[0] ->code ))) && ((48) == $client[0]->error[0]->code[0]))))
 add_ping($post_ID,$pagelinkedto);
}} }
function privacy_ping_filter ( $sites ) {
if ( (('0') != deAspis(get_option(array('blog_public',false)))))
 return $sites;
else 
{return array('',false);
} }
function trackback ( $trackback_url,$title,$excerpt,$ID ) {
global $wpdb;
if ( ((empty($trackback_url) || Aspis_empty( $trackback_url))))
 return ;
$options = array(array(),false);
arrayAssign($options[0],deAspis(registerTaint(array('timeout',false))),addTaint(array(4,false)));
arrayAssign($options[0],deAspis(registerTaint(array('body',false))),addTaint(array(array(deregisterTaint(array('title',false)) => addTaint($title),deregisterTaint(array('url',false)) => addTaint(get_permalink($ID)),deregisterTaint(array('blog_name',false)) => addTaint(get_option(array('blogname',false))),deregisterTaint(array('excerpt',false)) => addTaint($excerpt)),false)));
$response = wp_remote_post($trackback_url,$options);
if ( deAspis(is_wp_error($response)))
 return ;
$tb_url = Aspis_addslashes($trackback_url);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET pinged = CONCAT(pinged, '\n', '"),$tb_url),"') WHERE ID = %d"),$ID));
return $wpdb[0]->query($wpdb[0]->prepare(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET to_ping = TRIM(REPLACE(to_ping, '"),$tb_url),"', '')) WHERE ID = %d"),$ID));
 }
function weblog_ping ( $server = array('',false),$path = array('',false) ) {
global $wp_version;
include_once (deconcat2(concat12(ABSPATH,WPINC),'/class-IXR.php'));
$client = array(new IXR_Client($server,(((!(strlen(deAspis(Aspis_trim($path))))) || (('/') == $path[0])) ? array(false,false) : $path)),false);
$client[0]->timeout = array(3,false);
$client[0]->useragent = concat($client[0]->useragent ,concat1(' -- WordPress/',$wp_version));
$client[0]->debug = array(false,false);
$home = trailingslashit(get_option(array('home',false)));
if ( (denot_boolean($client[0]->query(array('weblogUpdates.extendedPing',false),get_option(array('blogname',false)),$home,get_bloginfo(array('rss2_url',false))))))
 $client[0]->query(array('weblogUpdates.ping',false),get_option(array('blogname',false)),$home);
 }
function clean_comment_cache ( $ids ) {
foreach ( deAspis(array_cast($ids)) as $id  )
wp_cache_delete($id,array('comment',false));
 }
function update_comment_cache ( $comments ) {
foreach ( deAspis(array_cast($comments)) as $comment  )
wp_cache_add($comment[0]->comment_ID,$comment,array('comment',false));
 }
function _close_comments_for_old_posts ( $posts ) {
if ( ((((empty($posts) || Aspis_empty( $posts))) || (denot_boolean(is_singular()))) || (denot_boolean(get_option(array('close_comments_for_old_posts',false))))))
 return $posts;
$days_old = int_cast(get_option(array('close_comments_days_old',false)));
if ( (denot_boolean($days_old)))
 return $posts;
if ( ((time() - strtotime($posts[0][(0)][0]->post_date_gmt[0])) > ((($days_old[0] * (24)) * (60)) * (60))))
 {$posts[0][(0)][0]->comment_status = array('closed',false);
$posts[0][(0)][0]->ping_status = array('closed',false);
}return $posts;
 }
function _close_comments_for_old_post ( $open,$post_id ) {
if ( (denot_boolean($open)))
 return $open;
if ( (denot_boolean(get_option(array('close_comments_for_old_posts',false)))))
 return $open;
$days_old = int_cast(get_option(array('close_comments_days_old',false)));
if ( (denot_boolean($days_old)))
 return $open;
$post = get_post($post_id);
if ( ((time() - strtotime($post[0]->post_date_gmt[0])) > ((($days_old[0] * (24)) * (60)) * (60))))
 return array(false,false);
return $open;
 }
;
?>
<?php 