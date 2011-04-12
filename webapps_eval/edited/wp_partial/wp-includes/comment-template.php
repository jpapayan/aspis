<?php require_once('AspisMain.php'); ?><?php
function get_comment_author (  ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}if ( empty($comment->comment_author))
 {if ( !empty($comment->user_id))
 {$user = get_userdata($comment->user_id);
$author = $user->user_login;
}else 
{{$author = __('Anonymous');
}}}else 
{{$author = $comment->comment_author;
}}{$AspisRetTemp = apply_filters('get_comment_author',$author);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function comment_author (  ) {
$author = apply_filters('comment_author',get_comment_author());
echo $author;
 }
function get_comment_author_email (  ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}{$AspisRetTemp = apply_filters('get_comment_author_email',$comment->comment_author_email);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function comment_author_email (  ) {
echo apply_filters('author_email',get_comment_author_email());
 }
function comment_author_email_link ( $linktext = '',$before = '',$after = '' ) {
if ( $link = get_comment_author_email_link($linktext,$before,$after))
 echo $link;
 }
function get_comment_author_email_link ( $linktext = '',$before = '',$after = '' ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}$email = apply_filters('comment_email',$comment->comment_author_email);
if ( (!empty($email)) && ($email != '@'))
 {$display = ($linktext != '') ? $linktext : $email;
$return = $before;
$return .= "<a href='mailto:$email'>$display</a>";
$return .= $after;
{$AspisRetTemp = $return;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = '';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function get_comment_author_link (  ) {
$url = get_comment_author_url();
$author = get_comment_author();
if ( empty($url) || 'http://' == $url)
 $return = $author;
else 
{$return = "<a href='$url' rel='external nofollow' class='url'>$author</a>";
}{$AspisRetTemp = apply_filters('get_comment_author_link',$return);
return $AspisRetTemp;
} }
function comment_author_link (  ) {
echo get_comment_author_link();
 }
function get_comment_author_IP (  ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}{$AspisRetTemp = apply_filters('get_comment_author_IP',$comment->comment_author_IP);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function comment_author_IP (  ) {
echo get_comment_author_IP();
 }
function get_comment_author_url (  ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}$url = ('http://' == $comment->comment_author_url) ? '' : $comment->comment_author_url;
$url = esc_url($url,array('http','https'));
{$AspisRetTemp = apply_filters('get_comment_author_url',$url);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function comment_author_url (  ) {
echo apply_filters('comment_url',get_comment_author_url());
 }
function get_comment_author_url_link ( $linktext = '',$before = '',$after = '' ) {
$url = get_comment_author_url();
$display = ($linktext != '') ? $linktext : $url;
$display = str_replace('http://www.','',$display);
$display = str_replace('http://','',$display);
if ( '/' == substr($display,-1))
 $display = substr($display,0,-1);
$return = "$before<a href='$url' rel='external'>$display</a>$after";
{$AspisRetTemp = apply_filters('get_comment_author_url_link',$return);
return $AspisRetTemp;
} }
function comment_author_url_link ( $linktext = '',$before = '',$after = '' ) {
echo get_comment_author_url_link($linktext,$before,$after);
 }
function comment_class ( $class = '',$comment_id = null,$post_id = null,$echo = true ) {
$class = 'class="' . join(' ',get_comment_class($class,$comment_id,$post_id)) . '"';
if ( $echo)
 echo $class;
else 
{{$AspisRetTemp = $class;
return $AspisRetTemp;
}} }
function get_comment_class ( $class = '',$comment_id = null,$post_id = null ) {
{global $comment_alt,$comment_depth,$comment_thread_alt;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment_alt,"\$comment_alt",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($comment_depth,"\$comment_depth",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($comment_thread_alt,"\$comment_thread_alt",$AspisChangesCache);
}$comment = get_comment($comment_id);
$classes = array();
$classes[] = (empty($comment->comment_type)) ? 'comment' : $comment->comment_type;
if ( $comment->user_id > 0 && $user = get_userdata($comment->user_id))
 {$classes[] = 'byuser';
$classes[] = 'comment-author-' . sanitize_html_class($user->user_nicename,$comment->user_id);
if ( $post = get_post($post_id))
 {if ( $comment->user_id === $post->post_author)
 $classes[] = 'bypostauthor';
}}if ( empty($comment_alt))
 $comment_alt = 0;
if ( empty($comment_depth))
 $comment_depth = 1;
if ( empty($comment_thread_alt))
 $comment_thread_alt = 0;
if ( $comment_alt % 2)
 {$classes[] = 'odd';
$classes[] = 'alt';
}else 
{{$classes[] = 'even';
}}$comment_alt++;
if ( 1 == $comment_depth)
 {if ( $comment_thread_alt % 2)
 {$classes[] = 'thread-odd';
$classes[] = 'thread-alt';
}else 
{{$classes[] = 'thread-even';
}}$comment_thread_alt++;
}$classes[] = "depth-$comment_depth";
if ( !empty($class))
 {if ( !is_array($class))
 $class = preg_split('#\s+#',$class);
$classes = array_merge($classes,$class);
}$classes = array_map('esc_attr',$classes);
{$AspisRetTemp = apply_filters('comment_class',$classes,$class,$comment_id,$post_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$comment_depth",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$comment_thread_alt",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$comment_depth",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$comment_thread_alt",$AspisChangesCache);
 }
function get_comment_date ( $d = '' ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}if ( '' == $d)
 $date = mysql2date(get_option('date_format'),$comment->comment_date);
else 
{$date = mysql2date($d,$comment->comment_date);
}{$AspisRetTemp = apply_filters('get_comment_date',$date,$d);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function comment_date ( $d = '' ) {
echo get_comment_date($d);
 }
function get_comment_excerpt (  ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}$comment_text = strip_tags($comment->comment_content);
$blah = explode(' ',$comment_text);
if ( count($blah) > 20)
 {$k = 20;
$use_dotdotdot = 1;
}else 
{{$k = count($blah);
$use_dotdotdot = 0;
}}$excerpt = '';
for ( $i = 0 ; $i < $k ; $i++ )
{$excerpt .= $blah[$i] . ' ';
}$excerpt .= ($use_dotdotdot) ? '...' : '';
{$AspisRetTemp = apply_filters('get_comment_excerpt',$excerpt);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function comment_excerpt (  ) {
echo apply_filters('comment_excerpt',get_comment_excerpt());
 }
function get_comment_ID (  ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}{$AspisRetTemp = apply_filters('get_comment_ID',$comment->comment_ID);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function comment_ID (  ) {
echo get_comment_ID();
 }
function get_comment_link ( $comment = null,$args = array() ) {
{global $wp_rewrite,$in_comment_loop;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($in_comment_loop,"\$in_comment_loop",$AspisChangesCache);
}$comment = get_comment($comment);
if ( !is_array($args))
 {$page = $args;
$args = array();
$args['page'] = $page;
}$defaults = array('type' => 'all','page' => '','per_page' => '','max_depth' => '');
$args = wp_parse_args($args,$defaults);
if ( '' === $args['per_page'] && get_option('page_comments'))
 $args['per_page'] = get_option('comments_per_page');
if ( empty($args['per_page']))
 {$args['per_page'] = 0;
$args['page'] = 0;
}if ( $args['per_page'])
 {if ( '' == $args['page'])
 $args['page'] = (!empty($in_comment_loop)) ? get_query_var('cpage') : get_page_of_comment($comment->comment_ID,$args);
if ( $wp_rewrite->using_permalinks())
 $link = user_trailingslashit(trailingslashit(get_permalink($comment->comment_post_ID)) . 'comment-page-' . $args['page'],'comment');
else 
{$link = add_query_arg('cpage',$args['page'],get_permalink($comment->comment_post_ID));
}}else 
{{$link = get_permalink($comment->comment_post_ID);
}}{$AspisRetTemp = apply_filters('get_comment_link',$link . '#comment-' . $comment->comment_ID,$comment,$args);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$in_comment_loop",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$in_comment_loop",$AspisChangesCache);
 }
function get_comments_link (  ) {
{$AspisRetTemp = get_permalink() . '#comments';
return $AspisRetTemp;
} }
function comments_link ( $deprecated = '',$deprecated = '' ) {
echo get_comments_link();
 }
function get_comments_number ( $post_id = 0 ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}$post_id = (int)$post_id;
if ( !$post_id)
 $post_id = (int)$id;
$post = get_post($post_id);
if ( !isset($post->comment_count))
 $count = 0;
else 
{$count = $post->comment_count;
}{$AspisRetTemp = apply_filters('get_comments_number',$count,$post_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function comments_number ( $zero = false,$one = false,$more = false,$deprecated = '' ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}$number = get_comments_number($id);
if ( $number > 1)
 $output = str_replace('%',number_format_i18n($number),(false === $more) ? __('% Comments') : $more);
elseif ( $number == 0)
 $output = (false === $zero) ? __('No Comments') : $zero;
else 
{$output = (false === $one) ? __('1 Comment') : $one;
}echo apply_filters('comments_number',$output,$number);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function get_comment_text (  ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}{$AspisRetTemp = apply_filters('get_comment_text',$comment->comment_content);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function comment_text (  ) {
echo apply_filters('comment_text',get_comment_text());
 }
function get_comment_time ( $d = '',$gmt = false,$translate = true ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}$comment_date = $gmt ? $comment->comment_date_gmt : $comment->comment_date;
if ( '' == $d)
 $date = mysql2date(get_option('time_format'),$comment_date,$translate);
else 
{$date = mysql2date($d,$comment_date,$translate);
}{$AspisRetTemp = apply_filters('get_comment_time',$date,$d,$gmt,$translate);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function comment_time ( $d = '' ) {
echo get_comment_time($d);
 }
function get_comment_type (  ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}if ( '' == $comment->comment_type)
 $comment->comment_type = 'comment';
{$AspisRetTemp = apply_filters('get_comment_type',$comment->comment_type);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
function comment_type ( $commenttxt = false,$trackbacktxt = false,$pingbacktxt = false ) {
if ( false === $commenttxt)
 $commenttxt = _x('Comment','noun');
if ( false === $trackbacktxt)
 $trackbacktxt = __('Trackback');
if ( false === $pingbacktxt)
 $pingbacktxt = __('Pingback');
$type = get_comment_type();
switch ( $type ) {
case 'trackback':echo $trackbacktxt;
break ;
case 'pingback':echo $pingbacktxt;
break ;
default :echo $commenttxt;
 }
 }
function get_trackback_url (  ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}if ( '' != get_option('permalink_structure'))
 {$tb_url = trailingslashit(get_permalink()) . user_trailingslashit('trackback','single_trackback');
}else 
{{$tb_url = get_option('siteurl') . '/wp-trackback.php?p=' . $id;
}}{$AspisRetTemp = apply_filters('trackback_url',$tb_url);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function trackback_url ( $deprecated = true ) {
if ( $deprecated)
 echo get_trackback_url();
else 
{{$AspisRetTemp = get_trackback_url();
return $AspisRetTemp;
}} }
function trackback_rdf ( $deprecated = '' ) {
if ( stripos(deAspisWarningRC($_SERVER[0]['HTTP_USER_AGENT']),'W3C_Validator') === false)
 {echo '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
				xmlns:dc="http://purl.org/dc/elements/1.1/"
				xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
			<rdf:Description rdf:about="';
the_permalink();
echo '"' . "\n";
echo '    dc:identifier="';
the_permalink();
echo '"' . "\n";
echo '    dc:title="' . str_replace('--','&#x2d;&#x2d;',wptexturize(strip_tags(get_the_title()))) . '"' . "\n";
echo '    trackback:ping="' . get_trackback_url() . '"' . " />\n";
echo '</rdf:RDF>';
} }
function comments_open ( $post_id = NULL ) {
$_post = get_post($post_id);
$open = ('open' == $_post->comment_status);
{$AspisRetTemp = apply_filters('comments_open',$open,$post_id);
return $AspisRetTemp;
} }
function pings_open ( $post_id = NULL ) {
$_post = get_post($post_id);
$open = ('open' == $_post->ping_status);
{$AspisRetTemp = apply_filters('pings_open',$open,$post_id);
return $AspisRetTemp;
} }
function wp_comment_form_unfiltered_html_nonce (  ) {
{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$post_id = 0;
if ( !empty($post))
 $post_id = $post->ID;
if ( current_user_can('unfiltered_html'))
 wp_nonce_field('unfiltered-html-comment_' . $post_id,'_wp_unfiltered_html_comment',false);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function comments_template ( $file = '/comments.php',$separate_comments = false ) {
{global $wp_query,$withcomments,$post,$wpdb,$id,$comment,$user_login,$user_ID,$user_identity,$overridden_cpage;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($withcomments,"\$withcomments",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($post,"\$post",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar4 = &AspisCleanTaintedGlobalUntainted($id,"\$id",$AspisChangesCache);
$AspisVar5 = &AspisCleanTaintedGlobalUntainted($comment,"\$comment",$AspisChangesCache);
$AspisVar6 = &AspisCleanTaintedGlobalUntainted($user_login,"\$user_login",$AspisChangesCache);
$AspisVar7 = &AspisCleanTaintedGlobalUntainted($user_ID,"\$user_ID",$AspisChangesCache);
$AspisVar8 = &AspisCleanTaintedGlobalUntainted($user_identity,"\$user_identity",$AspisChangesCache);
$AspisVar9 = &AspisCleanTaintedGlobalUntainted($overridden_cpage,"\$overridden_cpage",$AspisChangesCache);
}if ( !(is_single() || is_page() || $withcomments) || empty($post))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$withcomments",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$id",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$comment",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$user_login",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$user_ID",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar8,"\$user_identity",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar9,"\$overridden_cpage",$AspisChangesCache);
return ;
}if ( empty($file))
 $file = '/comments.php';
$req = get_option('require_name_email');
$commenter = wp_get_current_commenter();
$comment_author = $commenter['comment_author'];
$comment_author_email = $commenter['comment_author_email'];
$comment_author_url = esc_url($commenter['comment_author_url']);
if ( $user_ID)
 {$comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_post_ID = %d AND (comment_approved = '1' OR ( user_id = %d AND comment_approved = '0' ) )  ORDER BY comment_date_gmt",$post->ID,$user_ID));
}else 
{if ( empty($comment_author))
 {$comments = get_comments(array('post_id' => $post->ID,'status' => 'approve','order' => 'ASC'));
}else 
{{$comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_post_ID = %d AND ( comment_approved = '1' OR ( comment_author = %s AND comment_author_email = %s AND comment_approved = '0' ) ) ORDER BY comment_date_gmt",$post->ID,wp_specialchars_decode($comment_author,ENT_QUOTES),$comment_author_email));
}}}$wp_query->comments = apply_filters('comments_array',$comments,$post->ID);
$comments = &$wp_query->comments;
$wp_query->comment_count = count($wp_query->comments);
update_comment_cache($wp_query->comments);
if ( $separate_comments)
 {$wp_query->comments_by_type = &separate_comments($comments);
$comments_by_type = &$wp_query->comments_by_type;
}$overridden_cpage = FALSE;
if ( '' == get_query_var('cpage') && get_option('page_comments'))
 {set_query_var('cpage','newest' == get_option('default_comments_page') ? get_comment_pages_count() : 1);
$overridden_cpage = TRUE;
}if ( !defined('COMMENTS_TEMPLATE') || !COMMENTS_TEMPLATE)
 define('COMMENTS_TEMPLATE',true);
$include = apply_filters('comments_template',STYLESHEETPATH . $file);
if ( file_exists($include))
 require ($include);
elseif ( file_exists(TEMPLATEPATH . $file))
 require (TEMPLATEPATH . $file);
else 
{require (get_theme_root() . '/default/comments.php');
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$withcomments",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$id",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$comment",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$user_login",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$user_ID",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar8,"\$user_identity",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar9,"\$overridden_cpage",$AspisChangesCache);
 }
function comments_popup_script ( $width = 400,$height = 400,$file = '' ) {
{global $wpcommentspopupfile,$wpcommentsjavascript;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpcommentspopupfile,"\$wpcommentspopupfile",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpcommentsjavascript,"\$wpcommentsjavascript",$AspisChangesCache);
}if ( empty($file))
 {$wpcommentspopupfile = '';
}else 
{{$wpcommentspopupfile = $file;
}}$wpcommentsjavascript = 1;
$javascript = "<script type='text/javascript'>\nfunction wpopen (macagna) {\n    window.open(macagna, '_blank', 'width=$width,height=$height,scrollbars=yes,status=yes');\n}\n</script>\n";
echo $javascript;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpcommentspopupfile",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpcommentsjavascript",$AspisChangesCache);
 }
function comments_popup_link ( $zero = false,$one = false,$more = false,$css_class = '',$none = false ) {
{global $id,$wpcommentspopupfile,$wpcommentsjavascript,$post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpcommentspopupfile,"\$wpcommentspopupfile",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wpcommentsjavascript,"\$wpcommentsjavascript",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($post,"\$post",$AspisChangesCache);
}if ( false === $zero)
 $zero = __('No Comments');
if ( false === $one)
 $one = __('1 Comment');
if ( false === $more)
 $more = __('% Comments');
if ( false === $none)
 $none = __('Comments Off');
$number = get_comments_number($id);
if ( 0 == $number && !comments_open() && !pings_open())
 {echo '<span' . ((!empty($css_class)) ? ' class="' . esc_attr($css_class) . '"' : '') . '>' . $none . '</span>';
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpcommentspopupfile",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpcommentsjavascript",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$post",$AspisChangesCache);
return ;
}}if ( post_password_required())
 {echo __('Enter your password to view comments');
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpcommentspopupfile",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpcommentsjavascript",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$post",$AspisChangesCache);
return ;
}}echo '<a href="';
if ( $wpcommentsjavascript)
 {if ( empty($wpcommentspopupfile))
 $home = get_option('home');
else 
{$home = get_option('siteurl');
}echo $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
echo '" onclick="wpopen(this.href); return false"';
}else 
{{if ( 0 == $number)
 echo get_permalink() . '#respond';
else 
{comments_link();
}echo '"';
}}if ( !empty($css_class))
 {echo ' class="' . $css_class . '" ';
}$title = the_title_attribute('echo=0');
echo apply_filters('comments_popup_link_attributes','');
echo ' title="' . esc_attr(sprintf(__('Comment on %s'),$title)) . '">';
comments_number($zero,$one,$more,$number);
echo '</a>';
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpcommentspopupfile",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpcommentsjavascript",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$post",$AspisChangesCache);
 }
function get_comment_reply_link ( $args = array(),$comment = null,$post = null ) {
{global $user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $user_ID,"\$user_ID",$AspisChangesCache);
}$defaults = array('add_below' => 'comment','respond_id' => 'respond','reply_text' => __('Reply'),'login_text' => __('Log in to Reply'),'depth' => 0,'before' => '','after' => '');
$args = wp_parse_args($args,$defaults);
if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'])
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return ;
}extract(($args),EXTR_SKIP);
$comment = get_comment($comment);
$post = get_post($post);
if ( !comments_open($post->ID))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}$link = '';
if ( get_option('comment_registration') && !$user_ID)
 $link = '<a rel="nofollow" class="comment-reply-login" href="' . esc_url(wp_login_url(get_permalink())) . '">' . $login_text . '</a>';
else 
{$link = "<a rel='nofollow' class='comment-reply-link' href='" . esc_url(add_query_arg('replytocom',$comment->comment_ID)) . "#" . $respond_id . "' onclick='return addComment.moveForm(\"$add_below-$comment->comment_ID\", \"$comment->comment_ID\", \"$respond_id\", \"$post->ID\")'>$reply_text</a>";
}{$AspisRetTemp = apply_filters('comment_reply_link',$before . $link . $after,$args,$comment,$post);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
 }
function comment_reply_link ( $args = array(),$comment = null,$post = null ) {
echo get_comment_reply_link($args,$comment,$post);
 }
function get_post_reply_link ( $args = array(),$post = null ) {
{global $user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $user_ID,"\$user_ID",$AspisChangesCache);
}$defaults = array('add_below' => 'post','respond_id' => 'respond','reply_text' => __('Leave a Comment'),'login_text' => __('Log in to leave a Comment'),'before' => '','after' => '');
$args = wp_parse_args($args,$defaults);
extract(($args),EXTR_SKIP);
$post = get_post($post);
if ( !comments_open($post->ID))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}if ( get_option('comment_registration') && !$user_ID)
 {$link = '<a rel="nofollow" href="' . wp_login_url(get_permalink()) . '">' . $login_text . '</a>';
}else 
{{$link = "<a rel='nofollow' class='comment-reply-link' href='" . get_permalink($post->ID) . "#$respond_id' onclick='return addComment.moveForm(\"$add_below-$post->ID\", \"0\", \"$respond_id\", \"$post->ID\")'>$reply_text</a>";
}}{$AspisRetTemp = apply_filters('post_comments_link',$before . $link . $after,$post);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$user_ID",$AspisChangesCache);
 }
function post_reply_link ( $args = array(),$post = null ) {
echo get_post_reply_link($args,$post);
 }
function get_cancel_comment_reply_link ( $text = '' ) {
if ( empty($text))
 $text = __('Click here to cancel reply.');
$style = (isset($_GET[0]['replytocom']) && Aspis_isset($_GET[0]['replytocom'])) ? '' : ' style="display:none;"';
$link = esc_html(remove_query_arg('replytocom')) . '#respond';
{$AspisRetTemp = apply_filters('cancel_comment_reply_link','<a rel="nofollow" id="cancel-comment-reply-link" href="' . $link . '"' . $style . '>' . $text . '</a>',$link,$text);
return $AspisRetTemp;
} }
function cancel_comment_reply_link ( $text = '' ) {
echo get_cancel_comment_reply_link($text);
 }
function comment_id_fields (  ) {
{global $id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $id,"\$id",$AspisChangesCache);
}$replytoid = (isset($_GET[0]['replytocom']) && Aspis_isset($_GET[0]['replytocom'])) ? (int)deAspisWarningRC($_GET[0]['replytocom']) : 0;
echo "<input type='hidden' name='comment_post_ID' value='$id' id='comment_post_ID' />\n";
echo "<input type='hidden' name='comment_parent' id='comment_parent' value='$replytoid' />\n";
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$id",$AspisChangesCache);
 }
function comment_form_title ( $noreplytext = false,$replytext = false,$linktoparent = TRUE ) {
{global $comment;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $comment,"\$comment",$AspisChangesCache);
}if ( false === $noreplytext)
 $noreplytext = __('Leave a Reply');
if ( false === $replytext)
 $replytext = __('Leave a Reply to %s');
$replytoid = (isset($_GET[0]['replytocom']) && Aspis_isset($_GET[0]['replytocom'])) ? (int)deAspisWarningRC($_GET[0]['replytocom']) : 0;
if ( 0 == $replytoid)
 echo $noreplytext;
else 
{{$comment = get_comment($replytoid);
$author = ($linktoparent) ? '<a href="#comment-' . get_comment_ID() . '">' . get_comment_author() . '</a>' : get_comment_author();
printf($replytext,$author);
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$comment",$AspisChangesCache);
 }
class Walker_Comment extends Walker{var $tree_type = 'comment';
var $db_fields = array('parent' => 'comment_parent','id' => 'comment_ID');
function start_lvl ( &$output,$depth,$args ) {
{$GLOBALS[0]['comment_depth'] = $depth + 1;
switch ( $args['style'] ) {
case 'div':break ;
case 'ol':echo "<ol class='children'>\n";
break ;
default :case 'ul':echo "<ul class='children'>\n";
break ;
 }
} }
function end_lvl ( &$output,$depth,$args ) {
{$GLOBALS[0]['comment_depth'] = $depth + 1;
switch ( $args['style'] ) {
case 'div':break ;
case 'ol':echo "</ol>\n";
break ;
default :case 'ul':echo "</ul>\n";
break ;
 }
} }
function start_el ( &$output,$comment,$depth,$args ) {
{$depth++;
$GLOBALS[0]['comment_depth'] = $depth;
if ( !empty($args['callback']))
 {AspisUntainted_call_user_func($args['callback'],$comment,$args,$depth);
{return ;
}}$GLOBALS[0]['comment'] = $comment;
extract(($args),EXTR_SKIP);
if ( 'div' == $args['style'])
 {$tag = 'div';
$add_below = 'comment';
}else 
{{$tag = 'li';
$add_below = 'div-comment';
}};
?>
		<<?php echo $tag;
;
?> <?php comment_class(empty($args['has_children']) ? '' : 'parent');
;
?> id="comment-<?php comment_ID();
;
?>">
		<?php if ( 'div' != $args['style'])
 {;
?>
		<div id="div-comment-<?php comment_ID();
;
?>" class="comment-body">
		<?php };
?>
		<div class="comment-author vcard">
		<?php if ( $args['avatar_size'] != 0)
 echo get_avatar($comment,$args['avatar_size']);
;
?>
		<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'),get_comment_author_link());
;
?>
		</div>
<?php if ( $comment->comment_approved == '0')
 {;
?>
		<em><?php _e('Your comment is awaiting moderation.');
;
?></em>
		<br />
<?php };
?>

		<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID));
;
?>"><?php printf(__('%1$s at %2$s'),get_comment_date(),get_comment_time());
;
?></a><?php edit_comment_link(__('(Edit)'),'&nbsp;&nbsp;','');
;
?></div>

		<?php comment_text();
;
?>

		<div class="reply">
		<?php comment_reply_link(array_merge($args,array('add_below' => $add_below,'depth' => $depth,'max_depth' => $args['max_depth'])));
;
?>
		</div>
		<?php if ( 'div' != $args['style'])
 {;
?>
		</div>
		<?php };
?>
<?php } }
function end_el ( &$output,$comment,$depth,$args ) {
{if ( !empty($args['end-callback']))
 {AspisUntainted_call_user_func($args['end-callback'],$comment,$args,$depth);
{return ;
}}if ( 'div' == $args['style'])
 echo "</div>\n";
else 
{echo "</li>\n";
}} }
}function wp_list_comments ( $args = array(),$comments = null ) {
{global $wp_query,$comment_alt,$comment_depth,$comment_thread_alt,$overridden_cpage,$in_comment_loop;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($comment_alt,"\$comment_alt",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($comment_depth,"\$comment_depth",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($comment_thread_alt,"\$comment_thread_alt",$AspisChangesCache);
$AspisVar4 = &AspisCleanTaintedGlobalUntainted($overridden_cpage,"\$overridden_cpage",$AspisChangesCache);
$AspisVar5 = &AspisCleanTaintedGlobalUntainted($in_comment_loop,"\$in_comment_loop",$AspisChangesCache);
}$in_comment_loop = true;
$comment_alt = $comment_thread_alt = 0;
$comment_depth = 1;
$defaults = array('walker' => null,'max_depth' => '','style' => 'ul','callback' => null,'end-callback' => null,'type' => 'all','page' => '','per_page' => '','avatar_size' => 32,'reverse_top_level' => null,'reverse_children' => '');
$r = wp_parse_args($args,$defaults);
if ( null !== $comments)
 {$comments = (array)$comments;
if ( empty($comments))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$comment_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$comment_depth",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$comment_thread_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$overridden_cpage",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$in_comment_loop",$AspisChangesCache);
return ;
}if ( 'all' != $r['type'])
 {$comments_by_type = &separate_comments($comments);
if ( empty($comments_by_type[$r['type']]))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$comment_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$comment_depth",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$comment_thread_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$overridden_cpage",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$in_comment_loop",$AspisChangesCache);
return ;
}$_comments = $comments_by_type[$r['type']];
}else 
{{$_comments = $comments;
}}}else 
{{if ( empty($wp_query->comments))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$comment_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$comment_depth",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$comment_thread_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$overridden_cpage",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$in_comment_loop",$AspisChangesCache);
return ;
}if ( 'all' != $r['type'])
 {if ( empty($wp_query->comments_by_type))
 $wp_query->comments_by_type = &separate_comments($wp_query->comments);
if ( empty($wp_query->comments_by_type[$r['type']]))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$comment_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$comment_depth",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$comment_thread_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$overridden_cpage",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$in_comment_loop",$AspisChangesCache);
return ;
}$_comments = $wp_query->comments_by_type[$r['type']];
}else 
{{$_comments = $wp_query->comments;
}}}}if ( '' === $r['per_page'] && get_option('page_comments'))
 $r['per_page'] = get_query_var('comments_per_page');
if ( empty($r['per_page']))
 {$r['per_page'] = 0;
$r['page'] = 0;
}if ( '' === $r['max_depth'])
 {if ( get_option('thread_comments'))
 $r['max_depth'] = get_option('thread_comments_depth');
else 
{$r['max_depth'] = -1;
}}if ( '' === $r['page'])
 {if ( empty($overridden_cpage))
 {$r['page'] = get_query_var('cpage');
}else 
{{$threaded = (-1 == $r['max_depth']) ? false : true;
$r['page'] = ('newest' == get_option('default_comments_page')) ? get_comment_pages_count($_comments,$r['per_page'],$threaded) : 1;
set_query_var('cpage',$r['page']);
}}}$r['page'] = intval($r['page']);
if ( 0 == $r['page'] && 0 != $r['per_page'])
 $r['page'] = 1;
if ( null === $r['reverse_top_level'])
 $r['reverse_top_level'] = ('desc' == get_option('comment_order')) ? TRUE : FALSE;
extract(($r),EXTR_SKIP);
if ( empty($walker))
 $walker = new Walker_Comment;
$walker->paged_walk($_comments,$max_depth,$page,$per_page,$r);
$wp_query->max_num_comment_pages = $walker->max_pages;
$in_comment_loop = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$comment_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$comment_depth",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$comment_thread_alt",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$overridden_cpage",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$in_comment_loop",$AspisChangesCache);
 }
;
?>
<?php 