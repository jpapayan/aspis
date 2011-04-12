<?php require_once('AspisMain.php'); ?><?php
require (deconcat2(Aspis_dirname(array(__FILE__,false)),'/wp-load.php'));
do_action(array('wp-mail.php',false));
require_once (deconcat2(concat12(ABSPATH,WPINC),'/class-pop3.php'));
if ( (!(defined(('WP_MAIL_INTERVAL')))))
 define(('WP_MAIL_INTERVAL'),300);
$last_checked = get_transient(array('mailserver_last_checked',false));
if ( $last_checked[0])
 wp_die(__(array('Slow down cowboy, no need to check for new mails so often!',false)));
set_transient(array('mailserver_last_checked',false),array(true,false),array(WP_MAIL_INTERVAL,false));
$time_difference = array(deAspis(get_option(array('gmt_offset',false))) * (3600),false);
$phone_delim = array('::',false);
$pop3 = array(new POP3(),false);
$count = array(0,false);
if ( (((denot_boolean($pop3[0]->connect(get_option(array('mailserver_url',false)),get_option(array('mailserver_port',false))))) || (denot_boolean($pop3[0]->user(get_option(array('mailserver_login',false)))))) || (denot_boolean($count = $pop3[0]->pass(get_option(array('mailserver_pass',false)))))))
 {$pop3[0]->quit();
wp_die(((0) === $count[0]) ? __(array('There doesn&#8217;t seem to be any new mail.',false)) : esc_html($pop3[0]->ERROR));
}for ( $i = array(1,false) ; ($i[0] <= $count[0]) ; postincr($i) )
{$message = $pop3[0]->get($i);
$bodysignal = array(false,false);
$boundary = array('',false);
$charset = array('',false);
$content = array('',false);
$content_type = array('',false);
$content_transfer_encoding = array('',false);
$post_author = array(1,false);
$author_found = array(false,false);
$dmonths = array(array(array('Jan',false),array('Feb',false),array('Mar',false),array('Apr',false),array('May',false),array('Jun',false),array('Jul',false),array('Aug',false),array('Sep',false),array('Oct',false),array('Nov',false),array('Dec',false)),false);
foreach ( $message[0] as $line  )
{if ( (strlen($line[0]) < (3)))
 $bodysignal = array(true,false);
if ( $bodysignal[0])
 {$content = concat($content,$line);
}else 
{{if ( deAspis(Aspis_preg_match(array('/Content-Type: /i',false),$line)))
 {$content_type = Aspis_trim($line);
$content_type = Aspis_substr($content_type,array(14,false),array(strlen($content_type[0]) - (14),false));
$content_type = Aspis_explode(array(';',false),$content_type);
if ( (!((empty($content_type[0][(1)]) || Aspis_empty( $content_type [0][(1)])))))
 {$charset = Aspis_explode(array('=',false),attachAspis($content_type,(1)));
$charset = (!((empty($charset[0][(1)]) || Aspis_empty( $charset [0][(1)])))) ? Aspis_trim(attachAspis($charset,(1))) : array('',false);
}$content_type = attachAspis($content_type,(0));
}if ( deAspis(Aspis_preg_match(array('/Content-Transfer-Encoding: /i',false),$line)))
 {$content_transfer_encoding = Aspis_trim($line);
$content_transfer_encoding = Aspis_substr($content_transfer_encoding,array(27,false),array(strlen($content_transfer_encoding[0]) - (27),false));
$content_transfer_encoding = Aspis_explode(array(';',false),$content_transfer_encoding);
$content_transfer_encoding = attachAspis($content_transfer_encoding,(0));
}if ( ((($content_type[0] == ('multipart/alternative')) && (false !== strpos($line[0],'boundary="'))) && (('') == $boundary[0])))
 {$boundary = Aspis_trim($line);
$boundary = Aspis_explode(array('"',false),$boundary);
$boundary = attachAspis($boundary,(1));
}if ( deAspis(Aspis_preg_match(array('/Subject: /i',false),$line)))
 {$subject = Aspis_trim($line);
$subject = Aspis_substr($subject,array(9,false),array(strlen($subject[0]) - (9),false));
if ( function_exists(('iconv_mime_decode')))
 {$subject = array(iconv_mime_decode(deAspisRC($subject),2,deAspisRC(get_option(array('blog_charset',false)))),false);
}else 
{{$subject = wp_iso_descrambler($subject);
}}$subject = Aspis_explode($phone_delim,$subject);
$subject = attachAspis($subject,(0));
}if ( deAspis(Aspis_preg_match(array('/(From|Reply-To): /',false),$line)))
 {if ( deAspis(Aspis_preg_match(array('|[a-z0-9_.-]+@[a-z0-9_.-]+(?!.*<)|i',false),$line,$matches)))
 $author = attachAspis($matches,(0));
else 
{$author = Aspis_trim($line);
}$author = sanitize_email($author);
if ( deAspis(is_email($author)))
 {echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Author is %s',false)),$author)),'</p>'));
$userdata = get_user_by_email($author);
if ( ((empty($userdata) || Aspis_empty( $userdata))))
 {$author_found = array(false,false);
}else 
{{$post_author = $userdata[0]->ID;
$author_found = array(true,false);
}}}else 
{{$author_found = array(false,false);
}}}if ( deAspis(Aspis_preg_match(array('/Date: /i',false),$line)))
 {$ddate = Aspis_trim($line);
$ddate = Aspis_str_replace(array('Date: ',false),array('',false),$ddate);
if ( strpos($ddate[0],','))
 {$ddate = Aspis_trim(Aspis_substr($ddate,array(strpos($ddate[0],',') + (1),false),attAspis(strlen($ddate[0]))));
}$date_arr = Aspis_explode(array(' ',false),$ddate);
$date_time = Aspis_explode(array(':',false),attachAspis($date_arr,(3)));
$ddate_H = attachAspis($date_time,(0));
$ddate_i = attachAspis($date_time,(1));
$ddate_s = attachAspis($date_time,(2));
$ddate_m = attachAspis($date_arr,(1));
$ddate_d = attachAspis($date_arr,(0));
$ddate_Y = attachAspis($date_arr,(2));
for ( $j = array(0,false) ; ($j[0] < (12)) ; postincr($j) )
{if ( ($ddate_m[0] == deAspis(attachAspis($dmonths,$j[0]))))
 {$ddate_m = array($j[0] + (1),false);
}}$time_zn = array(deAspis(Aspis_intval(attachAspis($date_arr,(4)))) * (36),false);
$ddate_U = attAspis(gmmktime($ddate_H[0],$ddate_i[0],$ddate_s[0],$ddate_m[0],$ddate_d[0],$ddate_Y[0]));
$ddate_U = array($ddate_U[0] - $time_zn[0],false);
$post_date = attAspis(gmdate(('Y-m-d H:i:s'),($ddate_U[0] + $time_difference[0])));
$post_date_gmt = attAspis(gmdate(('Y-m-d H:i:s'),$ddate_U[0]));
}}}}if ( $author_found[0])
 {$user = array(new WP_User($post_author),false);
$post_status = deAspis(($user[0]->has_cap(array('publish_posts',false)))) ? array('publish',false) : array('pending',false);
}else 
{{$post_status = array('pending',false);
}}$subject = Aspis_trim($subject);
if ( ($content_type[0] == ('multipart/alternative')))
 {$content = Aspis_explode(concat1('--',$boundary),$content);
$content = attachAspis($content,(2));
if ( deAspis(Aspis_preg_match(array('/Content-Transfer-Encoding: quoted-printable/i',false),$content,$delim)))
 {$content = Aspis_explode(attachAspis($delim,(0)),$content);
$content = attachAspis($content,(1));
}$content = Aspis_strip_tags($content,array('<img><p><br><i><b><u><em><strong><strike><font><span><div>',false));
}$content = Aspis_trim($content);
$content = apply_filters(array('wp_mail_original_content',false),$content);
if ( (false !== (stripos(deAspisRC($content_transfer_encoding),"quoted-printable"))))
 {$content = attAspis(quoted_printable_decode($content[0]));
}if ( (function_exists(('iconv')) && (!((empty($charset) || Aspis_empty( $charset))))))
 {$content = Aspis_iconv($charset,get_option(array('blog_charset',false)),$content);
}$content = Aspis_explode($phone_delim,$content);
$content = ((empty($content[0][(1)]) || Aspis_empty( $content [0][(1)]))) ? attachAspis($content,(0)) : attachAspis($content,(1));
$content = Aspis_trim($content);
$post_content = apply_filters(array('phone_content',false),$content);
$post_title = xmlrpc_getposttitle($content);
if ( ($post_title[0] == ('')))
 $post_title = $subject;
$post_category = array(array(get_option(array('default_email_category',false))),false);
$post_data = array(compact('post_content','post_title','post_date','post_date_gmt','post_author','post_category','post_status'),false);
$post_data = add_magic_quotes($post_data);
$post_ID = wp_insert_post($post_data);
if ( deAspis(is_wp_error($post_ID)))
 echo AspisCheckPrint(concat1("\n",$post_ID[0]->get_error_message()));
if ( ((empty($post_ID) || Aspis_empty( $post_ID))))
 continue ;
do_action(array('publish_phone',false),$post_ID);
echo AspisCheckPrint(concat2(concat1("\n<p>",Aspis_sprintf(__(array('<strong>Author:</strong> %s',false)),esc_html($post_author))),'</p>'));
echo AspisCheckPrint(concat2(concat1("\n<p>",Aspis_sprintf(__(array('<strong>Posted title:</strong> %s',false)),esc_html($post_title))),'</p>'));
if ( (denot_boolean($pop3[0]->delete($i))))
 {echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Oops: %s',false)),esc_html($pop3[0]->ERROR))),'</p>'));
$pop3[0]->reset();
Aspis_exit();
}else 
{{echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Mission complete.  Message <strong>%s</strong> deleted.',false)),$i)),'</p>'));
}}}$pop3[0]->quit();
;
?>
<?php 