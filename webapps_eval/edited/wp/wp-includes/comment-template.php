<?php require_once('AspisMain.php'); ?><?php
function get_comment_author (  ) {
global $comment;
if ( ((empty($comment[0]->comment_author) || Aspis_empty( $comment[0] ->comment_author ))))
 {if ( (!((empty($comment[0]->user_id) || Aspis_empty( $comment[0] ->user_id )))))
 {$user = get_userdata($comment[0]->user_id);
$author = $user[0]->user_login;
}else 
{{$author = __(array('Anonymous',false));
}}}else 
{{$author = $comment[0]->comment_author;
}}return apply_filters(array('get_comment_author',false),$author);
 }
function comment_author (  ) {
$author = apply_filters(array('comment_author',false),get_comment_author());
echo AspisCheckPrint($author);
 }
function get_comment_author_email (  ) {
global $comment;
return apply_filters(array('get_comment_author_email',false),$comment[0]->comment_author_email);
 }
function comment_author_email (  ) {
echo AspisCheckPrint(apply_filters(array('author_email',false),get_comment_author_email()));
 }
function comment_author_email_link ( $linktext = array('',false),$before = array('',false),$after = array('',false) ) {
if ( deAspis($link = get_comment_author_email_link($linktext,$before,$after)))
 echo AspisCheckPrint($link);
 }
function get_comment_author_email_link ( $linktext = array('',false),$before = array('',false),$after = array('',false) ) {
global $comment;
$email = apply_filters(array('comment_email',false),$comment[0]->comment_author_email);
if ( ((!((empty($email) || Aspis_empty( $email)))) && ($email[0] != ('@'))))
 {$display = ($linktext[0] != ('')) ? $linktext : $email;
$return = $before;
$return = concat($return,concat2(concat(concat2(concat1("<a href='mailto:",$email),"'>"),$display),"</a>"));
$return = concat($return,$after);
return $return;
}else 
{{return array('',false);
}} }
function get_comment_author_link (  ) {
$url = get_comment_author_url();
$author = get_comment_author();
if ( (((empty($url) || Aspis_empty( $url))) || (('http://') == $url[0])))
 $return = $author;
else 
{$return = concat2(concat(concat2(concat1("<a href='",$url),"' rel='external nofollow' class='url'>"),$author),"</a>");
}return apply_filters(array('get_comment_author_link',false),$return);
 }
function comment_author_link (  ) {
echo AspisCheckPrint(get_comment_author_link());
 }
function get_comment_author_IP (  ) {
global $comment;
return apply_filters(array('get_comment_author_IP',false),$comment[0]->comment_author_IP);
 }
function comment_author_IP (  ) {
echo AspisCheckPrint(get_comment_author_IP());
 }
function get_comment_author_url (  ) {
global $comment;
$url = (('http://') == $comment[0]->comment_author_url[0]) ? array('',false) : $comment[0]->comment_author_url;
$url = esc_url($url,array(array(array('http',false),array('https',false)),false));
return apply_filters(array('get_comment_author_url',false),$url);
 }
function comment_author_url (  ) {
echo AspisCheckPrint(apply_filters(array('comment_url',false),get_comment_author_url()));
 }
function get_comment_author_url_link ( $linktext = array('',false),$before = array('',false),$after = array('',false) ) {
$url = get_comment_author_url();
$display = ($linktext[0] != ('')) ? $linktext : $url;
$display = Aspis_str_replace(array('http://www.',false),array('',false),$display);
$display = Aspis_str_replace(array('http://',false),array('',false),$display);
if ( (('/') == deAspis(Aspis_substr($display,negate(array(1,false))))))
 $display = Aspis_substr($display,array(0,false),negate(array(1,false)));
$return = concat(concat2(concat(concat2(concat(concat2($before,"<a href='"),$url),"' rel='external'>"),$display),"</a>"),$after);
return apply_filters(array('get_comment_author_url_link',false),$return);
 }
function comment_author_url_link ( $linktext = array('',false),$before = array('',false),$after = array('',false) ) {
echo AspisCheckPrint(get_comment_author_url_link($linktext,$before,$after));
 }
function comment_class ( $class = array('',false),$comment_id = array(null,false),$post_id = array(null,false),$echo = array(true,false) ) {
$class = concat2(concat1('class="',Aspis_join(array(' ',false),get_comment_class($class,$comment_id,$post_id))),'"');
if ( $echo[0])
 echo AspisCheckPrint($class);
else 
{return $class;
} }
function get_comment_class ( $class = array('',false),$comment_id = array(null,false),$post_id = array(null,false) ) {
global $comment_alt,$comment_depth,$comment_thread_alt;
$comment = get_comment($comment_id);
$classes = array(array(),false);
arrayAssignAdd($classes[0][],addTaint(((empty($comment[0]->comment_type) || Aspis_empty( $comment[0] ->comment_type ))) ? array('comment',false) : $comment[0]->comment_type));
if ( (($comment[0]->user_id[0] > (0)) && deAspis($user = get_userdata($comment[0]->user_id))))
 {arrayAssignAdd($classes[0][],addTaint(array('byuser',false)));
arrayAssignAdd($classes[0][],addTaint(concat1('comment-author-',sanitize_html_class($user[0]->user_nicename,$comment[0]->user_id))));
if ( deAspis($post = get_post($post_id)))
 {if ( ($comment[0]->user_id[0] === $post[0]->post_author[0]))
 arrayAssignAdd($classes[0][],addTaint(array('bypostauthor',false)));
}}if ( ((empty($comment_alt) || Aspis_empty( $comment_alt))))
 $comment_alt = array(0,false);
if ( ((empty($comment_depth) || Aspis_empty( $comment_depth))))
 $comment_depth = array(1,false);
if ( ((empty($comment_thread_alt) || Aspis_empty( $comment_thread_alt))))
 $comment_thread_alt = array(0,false);
if ( ($comment_alt[0] % (2)))
 {arrayAssignAdd($classes[0][],addTaint(array('odd',false)));
arrayAssignAdd($classes[0][],addTaint(array('alt',false)));
}else 
{{arrayAssignAdd($classes[0][],addTaint(array('even',false)));
}}postincr($comment_alt);
if ( ((1) == $comment_depth[0]))
 {if ( ($comment_thread_alt[0] % (2)))
 {arrayAssignAdd($classes[0][],addTaint(array('thread-odd',false)));
arrayAssignAdd($classes[0][],addTaint(array('thread-alt',false)));
}else 
{{arrayAssignAdd($classes[0][],addTaint(array('thread-even',false)));
}}postincr($comment_thread_alt);
}arrayAssignAdd($classes[0][],addTaint(concat1("depth-",$comment_depth)));
if ( (!((empty($class) || Aspis_empty( $class)))))
 {if ( (!(is_array($class[0]))))
 $class = Aspis_preg_split(array('#\s+#',false),$class);
$classes = Aspis_array_merge($classes,$class);
}$classes = attAspisRC(array_map(AspisInternalCallback(array('esc_attr',false)),deAspisRC($classes)));
return apply_filters(array('comment_class',false),$classes,$class,$comment_id,$post_id);
 }
function get_comment_date ( $d = array('',false) ) {
global $comment;
if ( (('') == $d[0]))
 $date = mysql2date(get_option(array('date_format',false)),$comment[0]->comment_date);
else 
{$date = mysql2date($d,$comment[0]->comment_date);
}return apply_filters(array('get_comment_date',false),$date,$d);
 }
function comment_date ( $d = array('',false) ) {
echo AspisCheckPrint(get_comment_date($d));
 }
function get_comment_excerpt (  ) {
global $comment;
$comment_text = Aspis_strip_tags($comment[0]->comment_content);
$blah = Aspis_explode(array(' ',false),$comment_text);
if ( (count($blah[0]) > (20)))
 {$k = array(20,false);
$use_dotdotdot = array(1,false);
}else 
{{$k = attAspis(count($blah[0]));
$use_dotdotdot = array(0,false);
}}$excerpt = array('',false);
for ( $i = array(0,false) ; ($i[0] < $k[0]) ; postincr($i) )
{$excerpt = concat($excerpt,concat2(attachAspis($blah,$i[0]),' '));
}$excerpt = concat($excerpt,deAspis(($use_dotdotdot)) ? array('...',false) : array('',false));
return apply_filters(array('get_comment_excerpt',false),$excerpt);
 }
function comment_excerpt (  ) {
echo AspisCheckPrint(apply_filters(array('comment_excerpt',false),get_comment_excerpt()));
 }
function get_comment_ID (  ) {
global $comment;
return apply_filters(array('get_comment_ID',false),$comment[0]->comment_ID);
 }
function comment_ID (  ) {
echo AspisCheckPrint(get_comment_ID());
 }
function get_comment_link ( $comment = array(null,false),$args = array(array(),false) ) {
global $wp_rewrite,$in_comment_loop;
$comment = get_comment($comment);
if ( (!(is_array($args[0]))))
 {$page = $args;
$args = array(array(),false);
arrayAssign($args[0],deAspis(registerTaint(array('page',false))),addTaint($page));
}$defaults = array(array('type' => array('all',false,false),'page' => array('',false,false),'per_page' => array('',false,false),'max_depth' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
if ( ((('') === deAspis($args[0]['per_page'])) && deAspis(get_option(array('page_comments',false)))))
 arrayAssign($args[0],deAspis(registerTaint(array('per_page',false))),addTaint(get_option(array('comments_per_page',false))));
if ( ((empty($args[0][('per_page')]) || Aspis_empty( $args [0][('per_page')]))))
 {arrayAssign($args[0],deAspis(registerTaint(array('per_page',false))),addTaint(array(0,false)));
arrayAssign($args[0],deAspis(registerTaint(array('page',false))),addTaint(array(0,false)));
}if ( deAspis($args[0]['per_page']))
 {if ( (('') == deAspis($args[0]['page'])))
 arrayAssign($args[0],deAspis(registerTaint(array('page',false))),addTaint((!((empty($in_comment_loop) || Aspis_empty( $in_comment_loop)))) ? get_query_var(array('cpage',false)) : get_page_of_comment($comment[0]->comment_ID,$args)));
if ( deAspis($wp_rewrite[0]->using_permalinks()))
 $link = user_trailingslashit(concat(concat2(trailingslashit(get_permalink($comment[0]->comment_post_ID)),'comment-page-'),$args[0]['page']),array('comment',false));
else 
{$link = add_query_arg(array('cpage',false),$args[0]['page'],get_permalink($comment[0]->comment_post_ID));
}}else 
{{$link = get_permalink($comment[0]->comment_post_ID);
}}return apply_filters(array('get_comment_link',false),concat(concat2($link,'#comment-'),$comment[0]->comment_ID),$comment,$args);
 }
function get_comments_link (  ) {
return concat2(get_permalink(),'#comments');
 }
function comments_link ( $deprecated = array('',false),$deprecated = array('',false) ) {
echo AspisCheckPrint(get_comments_link());
 }
function get_comments_number ( $post_id = array(0,false) ) {
global $id;
$post_id = int_cast($post_id);
if ( (denot_boolean($post_id)))
 $post_id = int_cast($id);
$post = get_post($post_id);
if ( (!((isset($post[0]->comment_count) && Aspis_isset( $post[0] ->comment_count )))))
 $count = array(0,false);
else 
{$count = $post[0]->comment_count;
}return apply_filters(array('get_comments_number',false),$count,$post_id);
 }
function comments_number ( $zero = array(false,false),$one = array(false,false),$more = array(false,false),$deprecated = array('',false) ) {
global $id;
$number = get_comments_number($id);
if ( ($number[0] > (1)))
 $output = Aspis_str_replace(array('%',false),number_format_i18n($number),(false === $more[0]) ? __(array('% Comments',false)) : $more);
elseif ( ($number[0] == (0)))
 $output = (false === $zero[0]) ? __(array('No Comments',false)) : $zero;
else 
{$output = (false === $one[0]) ? __(array('1 Comment',false)) : $one;
}echo AspisCheckPrint(apply_filters(array('comments_number',false),$output,$number));
 }
function get_comment_text (  ) {
global $comment;
return apply_filters(array('get_comment_text',false),$comment[0]->comment_content);
 }
function comment_text (  ) {
echo AspisCheckPrint(apply_filters(array('comment_text',false),get_comment_text()));
 }
function get_comment_time ( $d = array('',false),$gmt = array(false,false),$translate = array(true,false) ) {
global $comment;
$comment_date = $gmt[0] ? $comment[0]->comment_date_gmt : $comment[0]->comment_date;
if ( (('') == $d[0]))
 $date = mysql2date(get_option(array('time_format',false)),$comment_date,$translate);
else 
{$date = mysql2date($d,$comment_date,$translate);
}return apply_filters(array('get_comment_time',false),$date,$d,$gmt,$translate);
 }
function comment_time ( $d = array('',false) ) {
echo AspisCheckPrint(get_comment_time($d));
 }
function get_comment_type (  ) {
global $comment;
if ( (('') == $comment[0]->comment_type[0]))
 $comment[0]->comment_type = array('comment',false);
return apply_filters(array('get_comment_type',false),$comment[0]->comment_type);
 }
function comment_type ( $commenttxt = array(false,false),$trackbacktxt = array(false,false),$pingbacktxt = array(false,false) ) {
if ( (false === $commenttxt[0]))
 $commenttxt = _x(array('Comment',false),array('noun',false));
if ( (false === $trackbacktxt[0]))
 $trackbacktxt = __(array('Trackback',false));
if ( (false === $pingbacktxt[0]))
 $pingbacktxt = __(array('Pingback',false));
$type = get_comment_type();
switch ( $type[0] ) {
case ('trackback'):echo AspisCheckPrint($trackbacktxt);
break ;
case ('pingback'):echo AspisCheckPrint($pingbacktxt);
break ;
default :echo AspisCheckPrint($commenttxt);
 }
 }
function get_trackback_url (  ) {
global $id;
if ( (('') != deAspis(get_option(array('permalink_structure',false)))))
 {$tb_url = concat(trailingslashit(get_permalink()),user_trailingslashit(array('trackback',false),array('single_trackback',false)));
}else 
{{$tb_url = concat(concat2(get_option(array('siteurl',false)),'/wp-trackback.php?p='),$id);
}}return apply_filters(array('trackback_url',false),$tb_url);
 }
function trackback_url ( $deprecated = array(true,false) ) {
if ( $deprecated[0])
 echo AspisCheckPrint(get_trackback_url());
else 
{return get_trackback_url();
} }
function trackback_rdf ( $deprecated = array('',false) ) {
if ( ((stripos(deAspisRC($_SERVER[0]['HTTP_USER_AGENT']),'W3C_Validator')) === false))
 {echo AspisCheckPrint(array('<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
				xmlns:dc="http://purl.org/dc/elements/1.1/"
				xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
			<rdf:Description rdf:about="',false));
the_permalink();
echo AspisCheckPrint(concat12('"',"\n"));
echo AspisCheckPrint(array('    dc:identifier="',false));
the_permalink();
echo AspisCheckPrint(concat12('"',"\n"));
echo AspisCheckPrint(concat2(concat2(concat1('    dc:title="',Aspis_str_replace(array('--',false),array('&#x2d;&#x2d;',false),wptexturize(Aspis_strip_tags(get_the_title())))),'"'),"\n"));
echo AspisCheckPrint(concat2(concat2(concat1('    trackback:ping="',get_trackback_url()),'"')," />\n"));
echo AspisCheckPrint(array('</rdf:RDF>',false));
} }
function comments_open ( $post_id = array(NULL,false) ) {
$_post = get_post($post_id);
$open = (array(('open') == $_post[0]->comment_status[0],false));
return apply_filters(array('comments_open',false),$open,$post_id);
 }
function pings_open ( $post_id = array(NULL,false) ) {
$_post = get_post($post_id);
$open = (array(('open') == $_post[0]->ping_status[0],false));
return apply_filters(array('pings_open',false),$open,$post_id);
 }
function wp_comment_form_unfiltered_html_nonce (  ) {
global $post;
$post_id = array(0,false);
if ( (!((empty($post) || Aspis_empty( $post)))))
 $post_id = $post[0]->ID;
if ( deAspis(current_user_can(array('unfiltered_html',false))))
 wp_nonce_field(concat1('unfiltered-html-comment_',$post_id),array('_wp_unfiltered_html_comment',false),array(false,false));
 }
function comments_template ( $file = array('/comments.php',false),$separate_comments = array(false,false) ) {
global $wp_query,$withcomments,$post,$wpdb,$id,$comment,$user_login,$user_ID,$user_identity,$overridden_cpage;
if ( ((!((deAspis(is_single()) || deAspis(is_page())) || $withcomments[0])) || ((empty($post) || Aspis_empty( $post)))))
 return ;
if ( ((empty($file) || Aspis_empty( $file))))
 $file = array('/comments.php',false);
$req = get_option(array('require_name_email',false));
$commenter = wp_get_current_commenter();
$comment_author = $commenter[0]['comment_author'];
$comment_author_email = $commenter[0]['comment_author_email'];
$comment_author_url = esc_url($commenter[0]['comment_author_url']);
if ( $user_ID[0])
 {$comments = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d AND (comment_approved = '1' OR ( user_id = %d AND comment_approved = '0' ) )  ORDER BY comment_date_gmt"),$post[0]->ID,$user_ID));
}else 
{if ( ((empty($comment_author) || Aspis_empty( $comment_author))))
 {$comments = get_comments(array(array(deregisterTaint(array('post_id',false)) => addTaint($post[0]->ID),'status' => array('approve',false,false),'order' => array('ASC',false,false)),false));
}else 
{{$comments = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d AND ( comment_approved = '1' OR ( comment_author = %s AND comment_author_email = %s AND comment_approved = '0' ) ) ORDER BY comment_date_gmt"),$post[0]->ID,wp_specialchars_decode($comment_author,array(ENT_QUOTES,false)),$comment_author_email));
}}}$wp_query[0]->comments = apply_filters(array('comments_array',false),$comments,$post[0]->ID);
$comments = &$wp_query[0]->comments;
$wp_query[0]->comment_count = attAspis(count($wp_query[0]->comments[0]));
update_comment_cache($wp_query[0]->comments);
if ( $separate_comments[0])
 {$wp_query[0]->comments_by_type = &separate_comments($comments);
$comments_by_type = &$wp_query[0]->comments_by_type;
}$overridden_cpage = array(FALSE,false);
if ( ((('') == deAspis(get_query_var(array('cpage',false)))) && deAspis(get_option(array('page_comments',false)))))
 {set_query_var(array('cpage',false),(('newest') == deAspis(get_option(array('default_comments_page',false)))) ? get_comment_pages_count() : array(1,false));
$overridden_cpage = array(TRUE,false);
}if ( ((!(defined(('COMMENTS_TEMPLATE')))) || (!(COMMENTS_TEMPLATE))))
 define(('COMMENTS_TEMPLATE'),true);
$include = apply_filters(array('comments_template',false),concat1(STYLESHEETPATH,$file));
if ( file_exists($include[0]))
 require deAspis(($include));
elseif ( file_exists((deconcat1(TEMPLATEPATH,$file))))
 require (deconcat1(TEMPLATEPATH,$file));
else 
{require (deconcat2(get_theme_root(),'/default/comments.php'));
} }
function comments_popup_script ( $width = array(400,false),$height = array(400,false),$file = array('',false) ) {
global $wpcommentspopupfile,$wpcommentsjavascript;
if ( ((empty($file) || Aspis_empty( $file))))
 {$wpcommentspopupfile = array('',false);
}else 
{{$wpcommentspopupfile = $file;
}}$wpcommentsjavascript = array(1,false);
$javascript = concat2(concat(concat2(concat1("<script type='text/javascript'>\nfunction wpopen (macagna) {\n    window.open(macagna, '_blank', 'width=",$width),",height="),$height),",scrollbars=yes,status=yes');\n}\n</script>\n");
echo AspisCheckPrint($javascript);
 }
function comments_popup_link ( $zero = array(false,false),$one = array(false,false),$more = array(false,false),$css_class = array('',false),$none = array(false,false) ) {
global $id,$wpcommentspopupfile,$wpcommentsjavascript,$post;
if ( (false === $zero[0]))
 $zero = __(array('No Comments',false));
if ( (false === $one[0]))
 $one = __(array('1 Comment',false));
if ( (false === $more[0]))
 $more = __(array('% Comments',false));
if ( (false === $none[0]))
 $none = __(array('Comments Off',false));
$number = get_comments_number($id);
if ( ((((0) == $number[0]) && (denot_boolean(comments_open()))) && (denot_boolean(pings_open()))))
 {echo AspisCheckPrint(concat2(concat(concat2(concat1('<span',((!((empty($css_class) || Aspis_empty( $css_class)))) ? concat2(concat1(' class="',esc_attr($css_class)),'"') : array('',false))),'>'),$none),'</span>'));
return ;
}if ( deAspis(post_password_required()))
 {echo AspisCheckPrint(__(array('Enter your password to view comments',false)));
return ;
}echo AspisCheckPrint(array('<a href="',false));
if ( $wpcommentsjavascript[0])
 {if ( ((empty($wpcommentspopupfile) || Aspis_empty( $wpcommentspopupfile))))
 $home = get_option(array('home',false));
else 
{$home = get_option(array('siteurl',false));
}echo AspisCheckPrint(concat(concat2(concat(concat2($home,'/'),$wpcommentspopupfile),'?comments_popup='),$id));
echo AspisCheckPrint(array('" onclick="wpopen(this.href); return false"',false));
}else 
{{if ( ((0) == $number[0]))
 echo AspisCheckPrint(concat2(get_permalink(),'#respond'));
else 
{comments_link();
}echo AspisCheckPrint(array('"',false));
}}if ( (!((empty($css_class) || Aspis_empty( $css_class)))))
 {echo AspisCheckPrint(concat2(concat1(' class="',$css_class),'" '));
}$title = the_title_attribute(array('echo=0',false));
echo AspisCheckPrint(apply_filters(array('comments_popup_link_attributes',false),array('',false)));
echo AspisCheckPrint(concat2(concat1(' title="',esc_attr(Aspis_sprintf(__(array('Comment on %s',false)),$title))),'">'));
comments_number($zero,$one,$more,$number);
echo AspisCheckPrint(array('</a>',false));
 }
function get_comment_reply_link ( $args = array(array(),false),$comment = array(null,false),$post = array(null,false) ) {
global $user_ID;
$defaults = array(array('add_below' => array('comment',false,false),'respond_id' => array('respond',false,false),deregisterTaint(array('reply_text',false)) => addTaint(__(array('Reply',false))),deregisterTaint(array('login_text',false)) => addTaint(__(array('Log in to Reply',false))),'depth' => array(0,false,false),'before' => array('',false,false),'after' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
if ( (((0) == deAspis($args[0]['depth'])) || (deAspis($args[0]['max_depth']) <= deAspis($args[0]['depth']))))
 return ;
extract(($args[0]),EXTR_SKIP);
$comment = get_comment($comment);
$post = get_post($post);
if ( (denot_boolean(comments_open($post[0]->ID))))
 return array(false,false);
$link = array('',false);
if ( (deAspis(get_option(array('comment_registration',false))) && (denot_boolean($user_ID))))
 $link = concat2(concat(concat2(concat1('<a rel="nofollow" class="comment-reply-login" href="',esc_url(wp_login_url(get_permalink()))),'">'),$login_text),'</a>');
else 
{$link = concat(concat(concat2(concat1("<a rel='nofollow' class='comment-reply-link' href='",esc_url(add_query_arg(array('replytocom',false),$comment[0]->comment_ID))),"#"),$respond_id),concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("' onclick='return addComment.moveForm(\"",$add_below),"-"),$comment[0]->comment_ID),"\", \""),$comment[0]->comment_ID),"\", \""),$respond_id),"\", \""),$post[0]->ID),"\")'>"),$reply_text),"</a>"));
}return apply_filters(array('comment_reply_link',false),concat(concat($before,$link),$after),$args,$comment,$post);
 }
function comment_reply_link ( $args = array(array(),false),$comment = array(null,false),$post = array(null,false) ) {
echo AspisCheckPrint(get_comment_reply_link($args,$comment,$post));
 }
function get_post_reply_link ( $args = array(array(),false),$post = array(null,false) ) {
global $user_ID;
$defaults = array(array('add_below' => array('post',false,false),'respond_id' => array('respond',false,false),deregisterTaint(array('reply_text',false)) => addTaint(__(array('Leave a Comment',false))),deregisterTaint(array('login_text',false)) => addTaint(__(array('Log in to leave a Comment',false))),'before' => array('',false,false),'after' => array('',false,false)),false);
$args = wp_parse_args($args,$defaults);
extract(($args[0]),EXTR_SKIP);
$post = get_post($post);
if ( (denot_boolean(comments_open($post[0]->ID))))
 return array(false,false);
if ( (deAspis(get_option(array('comment_registration',false))) && (denot_boolean($user_ID))))
 {$link = concat2(concat(concat2(concat1('<a rel="nofollow" href="',wp_login_url(get_permalink())),'">'),$login_text),'</a>');
}else 
{{$link = concat(concat1("<a rel='nofollow' class='comment-reply-link' href='",get_permalink($post[0]->ID)),concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("#",$respond_id),"' onclick='return addComment.moveForm(\""),$add_below),"-"),$post[0]->ID),"\", \"0\", \""),$respond_id),"\", \""),$post[0]->ID),"\")'>"),$reply_text),"</a>"));
}}return apply_filters(array('post_comments_link',false),concat(concat($before,$link),$after),$post);
 }
function post_reply_link ( $args = array(array(),false),$post = array(null,false) ) {
echo AspisCheckPrint(get_post_reply_link($args,$post));
 }
function get_cancel_comment_reply_link ( $text = array('',false) ) {
if ( ((empty($text) || Aspis_empty( $text))))
 $text = __(array('Click here to cancel reply.',false));
$style = ((isset($_GET[0][('replytocom')]) && Aspis_isset( $_GET [0][('replytocom')]))) ? array('',false) : array(' style="display:none;"',false);
$link = concat2(esc_html(remove_query_arg(array('replytocom',false))),'#respond');
return apply_filters(array('cancel_comment_reply_link',false),concat2(concat(concat2(concat(concat2(concat1('<a rel="nofollow" id="cancel-comment-reply-link" href="',$link),'"'),$style),'>'),$text),'</a>'),$link,$text);
 }
function cancel_comment_reply_link ( $text = array('',false) ) {
echo AspisCheckPrint(get_cancel_comment_reply_link($text));
 }
function comment_id_fields (  ) {
global $id;
$replytoid = ((isset($_GET[0][('replytocom')]) && Aspis_isset( $_GET [0][('replytocom')]))) ? int_cast($_GET[0]['replytocom']) : array(0,false);
echo AspisCheckPrint(concat2(concat1("<input type='hidden' name='comment_post_ID' value='",$id),"' id='comment_post_ID' />\n"));
echo AspisCheckPrint(concat2(concat1("<input type='hidden' name='comment_parent' id='comment_parent' value='",$replytoid),"' />\n"));
 }
function comment_form_title ( $noreplytext = array(false,false),$replytext = array(false,false),$linktoparent = array(TRUE,false) ) {
global $comment;
if ( (false === $noreplytext[0]))
 $noreplytext = __(array('Leave a Reply',false));
if ( (false === $replytext[0]))
 $replytext = __(array('Leave a Reply to %s',false));
$replytoid = ((isset($_GET[0][('replytocom')]) && Aspis_isset( $_GET [0][('replytocom')]))) ? int_cast($_GET[0]['replytocom']) : array(0,false);
if ( ((0) == $replytoid[0]))
 echo AspisCheckPrint($noreplytext);
else 
{{$comment = get_comment($replytoid);
$author = deAspis(($linktoparent)) ? concat2(concat(concat2(concat1('<a href="#comment-',get_comment_ID()),'">'),get_comment_author()),'</a>') : get_comment_author();
printf($replytext[0],deAspisRC($author));
}} }
class Walker_Comment extends Walker{var $tree_type = array('comment',false);
var $db_fields = array(array('parent' => array('comment_parent',false),'id' => array('comment_ID',false)),false);
function start_lvl ( &$output,$depth,$args ) {
{arrayAssign($GLOBALS[0],deAspis(registerTaint(array('comment_depth',false))),addTaint(array($depth[0] + (1),false)));
switch ( deAspis($args[0]['style']) ) {
case ('div'):break ;
case ('ol'):echo AspisCheckPrint(array("<ol class='children'>\n",false));
break ;
default :case ('ul'):echo AspisCheckPrint(array("<ul class='children'>\n",false));
break ;
 }
} }
function end_lvl ( &$output,$depth,$args ) {
{arrayAssign($GLOBALS[0],deAspis(registerTaint(array('comment_depth',false))),addTaint(array($depth[0] + (1),false)));
switch ( deAspis($args[0]['style']) ) {
case ('div'):break ;
case ('ol'):echo AspisCheckPrint(array("</ol>\n",false));
break ;
default :case ('ul'):echo AspisCheckPrint(array("</ul>\n",false));
break ;
 }
} }
function start_el ( &$output,$comment,$depth,$args ) {
{postincr($depth);
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('comment_depth',false))),addTaint($depth));
if ( (!((empty($args[0][('callback')]) || Aspis_empty( $args [0][('callback')])))))
 {Aspis_call_user_func($args[0]['callback'],$comment,$args,$depth);
return ;
}arrayAssign($GLOBALS[0],deAspis(registerTaint(array('comment',false))),addTaint($comment));
extract(($args[0]),EXTR_SKIP);
if ( (('div') == deAspis($args[0]['style'])))
 {$tag = array('div',false);
$add_below = array('comment',false);
}else 
{{$tag = array('li',false);
$add_below = array('div-comment',false);
}};
?>
		<<?php echo AspisCheckPrint($tag);
;
?> <?php comment_class(((empty($args[0][('has_children')]) || Aspis_empty( $args [0][('has_children')]))) ? array('',false) : array('parent',false));
;
?> id="comment-<?php comment_ID();
;
?>">
		<?php if ( (('div') != deAspis($args[0]['style'])))
 {;
?>
		<div id="div-comment-<?php comment_ID();
;
?>" class="comment-body">
		<?php };
?>
		<div class="comment-author vcard">
		<?php if ( (deAspis($args[0]['avatar_size']) != (0)))
 echo AspisCheckPrint(get_avatar($comment,$args[0]['avatar_size']));
;
?>
		<?php printf(deAspis(__(array('<cite class="fn">%s</cite> <span class="says">says:</span>',false))),deAspisRC(get_comment_author_link()));
;
?>
		</div>
<?php if ( ($comment[0]->comment_approved[0] == ('0')))
 {;
?>
		<em><?php _e(array('Your comment is awaiting moderation.',false));
;
?></em>
		<br />
<?php };
?>

		<div class="comment-meta commentmetadata"><a href="<?php echo AspisCheckPrint(Aspis_htmlspecialchars(get_comment_link($comment[0]->comment_ID)));
;
?>"><?php printf(deAspis(__(array('%1$s at %2$s',false))),deAspisRC(get_comment_date()),deAspisRC(get_comment_time()));
;
?></a><?php edit_comment_link(__(array('(Edit)',false)),array('&nbsp;&nbsp;',false),array('',false));
;
?></div>

		<?php comment_text();
;
?>

		<div class="reply">
		<?php comment_reply_link(Aspis_array_merge($args,array(array(deregisterTaint(array('add_below',false)) => addTaint($add_below),deregisterTaint(array('depth',false)) => addTaint($depth),deregisterTaint(array('max_depth',false)) => addTaint($args[0]['max_depth'])),false)));
;
?>
		</div>
		<?php if ( (('div') != deAspis($args[0]['style'])))
 {;
?>
		</div>
		<?php };
?>
<?php } }
function end_el ( &$output,$comment,$depth,$args ) {
{if ( (!((empty($args[0][('end-callback')]) || Aspis_empty( $args [0][('end-callback')])))))
 {Aspis_call_user_func($args[0]['end-callback'],$comment,$args,$depth);
return ;
}if ( (('div') == deAspis($args[0]['style'])))
 echo AspisCheckPrint(array("</div>\n",false));
else 
{echo AspisCheckPrint(array("</li>\n",false));
}} }
}function wp_list_comments ( $args = array(array(),false),$comments = array(null,false) ) {
global $wp_query,$comment_alt,$comment_depth,$comment_thread_alt,$overridden_cpage,$in_comment_loop;
$in_comment_loop = array(true,false);
$comment_alt = $comment_thread_alt = array(0,false);
$comment_depth = array(1,false);
$defaults = array(array('walker' => array(null,false,false),'max_depth' => array('',false,false),'style' => array('ul',false,false),'callback' => array(null,false,false),'end-callback' => array(null,false,false),'type' => array('all',false,false),'page' => array('',false,false),'per_page' => array('',false,false),'avatar_size' => array(32,false,false),'reverse_top_level' => array(null,false,false),'reverse_children' => array('',false,false)),false);
$r = wp_parse_args($args,$defaults);
if ( (null !== $comments[0]))
 {$comments = array_cast($comments);
if ( ((empty($comments) || Aspis_empty( $comments))))
 return ;
if ( (('all') != deAspis($r[0]['type'])))
 {$comments_by_type = &separate_comments($comments);
if ( ((empty($comments_by_type[0][deAspis($r[0]['type'])]) || Aspis_empty( $comments_by_type [0][deAspis($r [0]['type'])]))))
 return ;
$_comments = attachAspis($comments_by_type,deAspis($r[0]['type']));
}else 
{{$_comments = $comments;
}}}else 
{{if ( ((empty($wp_query[0]->comments) || Aspis_empty( $wp_query[0] ->comments ))))
 return ;
if ( (('all') != deAspis($r[0]['type'])))
 {if ( ((empty($wp_query[0]->comments_by_type) || Aspis_empty( $wp_query[0] ->comments_by_type ))))
 $wp_query[0]->comments_by_type = &separate_comments($wp_query[0]->comments);
if ( ((empty($wp_query[0]->comments_by_type[0][deAspis($r[0]['type'])]) || Aspis_empty( $wp_query[0] ->comments_by_type [0][deAspis($r [0]['type'])] ))))
 return ;
$_comments = $wp_query[0]->comments_by_type[0][deAspis($r[0]['type'])];
}else 
{{$_comments = $wp_query[0]->comments;
}}}}if ( ((('') === deAspis($r[0]['per_page'])) && deAspis(get_option(array('page_comments',false)))))
 arrayAssign($r[0],deAspis(registerTaint(array('per_page',false))),addTaint(get_query_var(array('comments_per_page',false))));
if ( ((empty($r[0][('per_page')]) || Aspis_empty( $r [0][('per_page')]))))
 {arrayAssign($r[0],deAspis(registerTaint(array('per_page',false))),addTaint(array(0,false)));
arrayAssign($r[0],deAspis(registerTaint(array('page',false))),addTaint(array(0,false)));
}if ( (('') === deAspis($r[0]['max_depth'])))
 {if ( deAspis(get_option(array('thread_comments',false))))
 arrayAssign($r[0],deAspis(registerTaint(array('max_depth',false))),addTaint(get_option(array('thread_comments_depth',false))));
else 
{arrayAssign($r[0],deAspis(registerTaint(array('max_depth',false))),addTaint(negate(array(1,false))));
}}if ( (('') === deAspis($r[0]['page'])))
 {if ( ((empty($overridden_cpage) || Aspis_empty( $overridden_cpage))))
 {arrayAssign($r[0],deAspis(registerTaint(array('page',false))),addTaint(get_query_var(array('cpage',false))));
}else 
{{$threaded = (deAspis(negate(array(1,false))) == deAspis($r[0]['max_depth'])) ? array(false,false) : array(true,false);
arrayAssign($r[0],deAspis(registerTaint(array('page',false))),addTaint((('newest') == deAspis(get_option(array('default_comments_page',false)))) ? get_comment_pages_count($_comments,$r[0]['per_page'],$threaded) : array(1,false)));
set_query_var(array('cpage',false),$r[0]['page']);
}}}arrayAssign($r[0],deAspis(registerTaint(array('page',false))),addTaint(Aspis_intval($r[0]['page'])));
if ( (((0) == deAspis($r[0]['page'])) && ((0) != deAspis($r[0]['per_page']))))
 arrayAssign($r[0],deAspis(registerTaint(array('page',false))),addTaint(array(1,false)));
if ( (null === deAspis($r[0]['reverse_top_level'])))
 arrayAssign($r[0],deAspis(registerTaint(array('reverse_top_level',false))),addTaint((('desc') == deAspis(get_option(array('comment_order',false)))) ? array(TRUE,false) : array(FALSE,false)));
extract(($r[0]),EXTR_SKIP);
if ( ((empty($walker) || Aspis_empty( $walker))))
 $walker = array(new Walker_Comment,false);
$walker[0]->paged_walk($_comments,$max_depth,$page,$per_page,$r);
$wp_query[0]->max_num_comment_pages = $walker[0]->max_pages;
$in_comment_loop = array(false,false);
 }
;
?>
<?php 