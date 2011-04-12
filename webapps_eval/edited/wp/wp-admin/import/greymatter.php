<?php require_once('AspisMain.php'); ?><?php
class GM_Import{var $gmnames = array(array(),false);
function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Import GreyMatter',false))),'</h2>'));
} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function greet (  ) {
{$this->header();
;
?>
<p><?php _e(array('This is a basic GreyMatter to WordPress import script.',false));
?></p>
<p><?php _e(array('What it does:',false));
?></p>
<ul>
<li><?php _e(array('Parses gm-authors.cgi to import (new) authors. Everyone is imported at level 1.',false));
?></li>
<li><?php _e(array('Parses the entries cgi files to import posts, comments, and karma on posts (although karma is not used on WordPress yet).<br />If authors are found not to be in gm-authors.cgi, imports them at level 0.',false));
?></li>
<li><?php _e(array("Detects duplicate entries or comments. If you don't import everything the first time, or this import should fail in the middle, duplicate entries will not be made when you try again.",false));
?></li>
</ul>
<p><?php _e(array('What it does not:',false));
?></p>
<ul>
<li><?php _e(array('Parse gm-counter.cgi, gm-banlist.cgi, gm-cplog.cgi (you can make a CP log hack if you really feel like it, but I question the need of a CP log).',false));
?></li>
<li><?php _e(array('Import gm-templates.',false));
?></li>
<li><?php _e(array("Doesn't keep entries on top.",false));
?></li>
</ul>
<p>&nbsp;</p>

<form name="stepOne" method="get" action="">
<input type="hidden" name="import" value="greymatter" />
<input type="hidden" name="step" value="1" />
<?php wp_nonce_field(array('import-greymatter',false));
;
?>
<h3><?php _e(array('Second step: GreyMatter details:',false));
?></h3>
<table class="form-table">
<tr>
<td><label for="gmpath"><?php _e(array('Path to GM files:',false));
?></label></td>
<td><input type="text" style="width:300px" name="gmpath" id="gmpath" value="/home/my/site/cgi-bin/greymatter/" /></td>
</tr>
<tr>
<td><label for="archivespath"><?php _e(array('Path to GM entries:',false));
?></label></td>
<td><input type="text" style="width:300px" name="archivespath" id="archivespath" value="/home/my/site/cgi-bin/greymatter/archives/" /></td>
</tr>
<tr>
<td><label for="lastentry"><?php _e(array('Last entry&#8217;s number:',false));
?></label></td>
<td><input type="text" name="lastentry" id="lastentry" value="00000001" /><br />
	<?php _e(array('This importer will search for files 00000001.cgi to 000-whatever.cgi,<br />so you need to enter the number of the last GM post here.<br />(if you don&#8217;t know that number, just log in to your FTP and look it out<br />in the entries&#8217; folder)',false));
?></td>
</tr>
</table>
<p class="submit"><input type="submit" name="submit" class="button" value="<?php esc_attr_e(array('Start Importing',false));
?>" /></p>
</form>
<?php $this->footer();
} }
function gm2autobr ( $string ) {
{$string = Aspis_str_replace(array("|*|",false),array("<br />\n",false),$string);
return ($string);
} }
function import (  ) {
{global $wpdb;
$wpvarstoreset = array(array(array('gmpath',false),array('archivespath',false),array('lastentry',false)),false);
for ( $i = array(0,false) ; ($i[0] < count($wpvarstoreset[0])) ; $i = array((1) + $i[0],false) )
{$wpvar = attachAspis($wpvarstoreset,$i[0]);
if ( (!((isset(${$wpvar[0]}) && Aspis_isset( ${$wpvar[0]})))))
 {if ( ((empty($_POST[0][$wpvar[0]]) || Aspis_empty( $_POST [0][ $wpvar[0]]))))
 {if ( ((empty($_GET[0][$wpvar[0]]) || Aspis_empty( $_GET [0][ $wpvar[0]]))))
 {${$wpvar[0]} = array('',false);
}else 
{{${$wpvar[0]} = attachAspis($_GET,$wpvar[0]);
}}}else 
{{${$wpvar[0]} = attachAspis($_POST,$wpvar[0]);
}}}}if ( (!(chdir($archivespath[0]))))
 wp_die(__(array("Wrong path, the path to the GM entries does not exist on the server",false)));
if ( (!(chdir($gmpath[0]))))
 wp_die(__(array("Wrong path, the path to the GM files does not exist on the server",false)));
$lastentry = int_cast($lastentry);
$this->header();
;
?>
<p><?php _e(array('The importer is running...',false));
?></p>
<ul>
<li><?php _e(array('importing users...',false));
?><ul><?php chdir($gmpath[0]);
$userbase = Aspis_file(array("gm-authors.cgi",false));
foreach ( $userbase[0] as $user  )
{$userdata = Aspis_explode(array("|",false),$user);
$user_ip = array("127.0.0.1",false);
$user_domain = array("localhost",false);
$user_browser = array("server",false);
$s = attachAspis($userdata,(4));
$user_joindate = concat2(concat(concat2(concat(concat2(Aspis_substr($s,array(6,false),array(4,false)),"-"),Aspis_substr($s,array(0,false),array(2,false))),"-"),Aspis_substr($s,array(3,false),array(2,false)))," 00:00:00");
$user_login = $wpdb[0]->escape(attachAspis($userdata,(0)));
$pass1 = $wpdb[0]->escape(attachAspis($userdata,(1)));
$user_nickname = $wpdb[0]->escape(attachAspis($userdata,(0)));
$user_email = $wpdb[0]->escape(attachAspis($userdata,(2)));
$user_url = $wpdb[0]->escape(attachAspis($userdata,(3)));
$user_joindate = $wpdb[0]->escape($user_joindate);
$user_id = username_exists($user_login);
if ( $user_id[0])
 {printf((deconcat2(concat(concat2(concat1('<li>',__(array('user %s',false))),'<strong>'),__(array('Already exists',false))),'</strong></li>')),(deconcat2(concat1("<em>",$user_login),"</em>")));
arrayAssign($this->gmnames[0],deAspis(registerTaint(attachAspis($userdata,(0)))),addTaint($user_id));
continue ;
}$user_info = array(array(deregisterTaint(array("user_login",false)) => addTaint($user_login),deregisterTaint(array("user_pass",false)) => addTaint($pass1),deregisterTaint(array("user_nickname",false)) => addTaint($user_nickname),deregisterTaint(array("user_email",false)) => addTaint($user_email),deregisterTaint(array("user_url",false)) => addTaint($user_url),deregisterTaint(array("user_ip",false)) => addTaint($user_ip),deregisterTaint(array("user_domain",false)) => addTaint($user_domain),deregisterTaint(array("user_browser",false)) => addTaint($user_browser),deregisterTaint(array("dateYMDhour",false)) => addTaint($user_joindate),"user_level" => array("1",false,false),"user_idmode" => array("nickname",false,false)),false);
$user_id = wp_insert_user($user_info);
arrayAssign($this->gmnames[0],deAspis(registerTaint(attachAspis($userdata,(0)))),addTaint($user_id));
printf((deconcat2(concat(concat2(concat1('<li>',__(array('user %s...',false))),' <strong>'),__(array('Done',false))),'</strong></li>')),(deconcat2(concat1("<em>",$user_login),"</em>")));
};
?></ul><strong><?php _e(array('Done',false));
?></strong></li>
<li><?php _e(array('importing posts, comments, and karma...',false));
?><br /><ul><?php chdir($archivespath[0]);
for ( $i = array(0,false) ; ($i[0] <= $lastentry[0]) ; $i = array($i[0] + (1),false) )
{$entryfile = array("",false);
if ( ($i[0] < (10000000)))
 {$entryfile = concat2($entryfile,"0");
if ( ($i[0] < (1000000)))
 {$entryfile = concat2($entryfile,"0");
if ( ($i[0] < (100000)))
 {$entryfile = concat2($entryfile,"0");
if ( ($i[0] < (10000)))
 {$entryfile = concat2($entryfile,"0");
if ( ($i[0] < (1000)))
 {$entryfile = concat2($entryfile,"0");
if ( ($i[0] < (100)))
 {$entryfile = concat2($entryfile,"0");
if ( ($i[0] < (10)))
 {$entryfile = concat2($entryfile,"0");
}}}}}}}$entryfile = concat($entryfile,$i);
if ( is_file((deconcat2($entryfile,".cgi"))))
 {$entry = Aspis_file(concat2($entryfile,".cgi"));
$postinfo = Aspis_explode(array("|",false),attachAspis($entry,(0)));
$postmaincontent = $this->gm2autobr(attachAspis($entry,(2)));
$postmorecontent = $this->gm2autobr(attachAspis($entry,(3)));
$post_author = Aspis_trim($wpdb[0]->escape(attachAspis($postinfo,(1))));
$post_title = $this->gm2autobr(attachAspis($postinfo,(2)));
printf((deconcat1('<li>',__(array('entry # %s : %s : by %s',false)))),deAspisRC($entryfile),deAspisRC($post_title),deAspisRC(attachAspis($postinfo,(1))));
$post_title = $wpdb[0]->escape($post_title);
$postyear = attachAspis($postinfo,(6));
$postmonth = zeroise(attachAspis($postinfo,(4)),array(2,false));
$postday = zeroise(attachAspis($postinfo,(5)),array(2,false));
$posthour = zeroise(attachAspis($postinfo,(7)),array(2,false));
$postminute = zeroise(attachAspis($postinfo,(8)),array(2,false));
$postsecond = zeroise(attachAspis($postinfo,(9)),array(2,false));
if ( ((deAspis(attachAspis($postinfo,(10))) == ("PM")) && ($posthour[0] != ("12"))))
 $posthour = array($posthour[0] + (12),false);
$post_date = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2($postyear,"-"),$postmonth),"-"),$postday)," "),$posthour),":"),$postminute),":"),$postsecond);
$post_content = $postmaincontent;
if ( (strlen($postmorecontent[0]) > (3)))
 $post_content = concat($post_content,concat1("<!--more--><br /><br />",$postmorecontent));
$post_content = $wpdb[0]->escape($post_content);
$post_karma = attachAspis($postinfo,(12));
$post_status = array('publish',false);
$comment_status = array('open',false);
$ping_status = array('closed',false);
if ( deAspis($post_ID = post_exists($post_title,array('',false),$post_date)))
 {echo AspisCheckPrint(array(' ',false));
_e(array('(already exists)',false));
}else 
{{$user_id = username_exists($post_author);
if ( (denot_boolean($user_id)))
 {$user_ip = array("127.0.0.1",false);
$user_domain = array("localhost",false);
$user_browser = array("server",false);
$user_joindate = array("1979-06-06 00:41:00",false);
$user_login = $wpdb[0]->escape($post_author);
$pass1 = $wpdb[0]->escape(array("password",false));
$user_nickname = $wpdb[0]->escape($post_author);
$user_email = $wpdb[0]->escape(array("user@deleted.com",false));
$user_url = $wpdb[0]->escape(array("",false));
$user_joindate = $wpdb[0]->escape($user_joindate);
$user_info = array(array(deregisterTaint(array("user_login",false)) => addTaint($user_login),deregisterTaint(array("user_pass",false)) => addTaint($pass1),deregisterTaint(array("user_nickname",false)) => addTaint($user_nickname),deregisterTaint(array("user_email",false)) => addTaint($user_email),deregisterTaint(array("user_url",false)) => addTaint($user_url),deregisterTaint(array("user_ip",false)) => addTaint($user_ip),deregisterTaint(array("user_domain",false)) => addTaint($user_domain),deregisterTaint(array("user_browser",false)) => addTaint($user_browser),deregisterTaint(array("dateYMDhour",false)) => addTaint($user_joindate),"user_level" => array(0,false,false),"user_idmode" => array("nickname",false,false)),false);
$user_id = wp_insert_user($user_info);
arrayAssign($this->gmnames[0],deAspis(registerTaint(attachAspis($postinfo,(1)))),addTaint($user_id));
echo AspisCheckPrint(array(': ',false));
printf(deAspis(__(array('registered deleted user %s at level 0 ',false))),(deconcat2(concat1("<em>",$user_login),"</em>")));
}if ( array_key_exists(deAspisRC(attachAspis($postinfo,(1))),deAspisRC($this->gmnames)))
 {$post_author = $this->gmnames[0][deAspis(attachAspis($postinfo,(1)))];
}else 
{{$post_author = $user_id;
}}$postdata = array(compact('post_author','post_date','post_date_gmt','post_content','post_title','post_excerpt','post_status','comment_status','ping_status','post_modified','post_modified_gmt'),false);
$post_ID = wp_insert_post($postdata);
if ( deAspis(is_wp_error($post_ID)))
 return $post_ID;
}}$c = attAspis(count($entry[0]));
if ( ($c[0] > (4)))
 {$numAddedComments = array(0,false);
$numComments = array(0,false);
for ( $j = array(4,false) ; ($j[0] < $c[0]) ; postincr($j) )
{arrayAssign($entry[0],deAspis(registerTaint($j)),addTaint($this->gm2autobr(attachAspis($entry,$j[0]))));
$commentinfo = Aspis_explode(array("|",false),attachAspis($entry,$j[0]));
$comment_post_ID = $post_ID;
$comment_author = $wpdb[0]->escape(attachAspis($commentinfo,(0)));
$comment_author_email = $wpdb[0]->escape(attachAspis($commentinfo,(2)));
$comment_author_url = $wpdb[0]->escape(attachAspis($commentinfo,(3)));
$comment_author_IP = $wpdb[0]->escape(attachAspis($commentinfo,(1)));
$commentyear = attachAspis($commentinfo,(7));
$commentmonth = zeroise(attachAspis($commentinfo,(5)),array(2,false));
$commentday = zeroise(attachAspis($commentinfo,(6)),array(2,false));
$commenthour = zeroise(attachAspis($commentinfo,(8)),array(2,false));
$commentminute = zeroise(attachAspis($commentinfo,(9)),array(2,false));
$commentsecond = zeroise(attachAspis($commentinfo,(10)),array(2,false));
if ( ((deAspis(attachAspis($commentinfo,(11))) == ("PM")) && ($commenthour[0] != ("12"))))
 $commenthour = array($commenthour[0] + (12),false);
$comment_date = concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2($commentyear,"-"),$commentmonth),"-"),$commentday)," "),$commenthour),":"),$commentminute),":"),$commentsecond);
$comment_content = $wpdb[0]->escape(attachAspis($commentinfo,(12)));
if ( (denot_boolean(comment_exists($comment_author,$comment_date))))
 {$commentdata = array(compact('comment_post_ID','comment_author','comment_author_url','comment_author_email','comment_author_IP','comment_date','comment_content','comment_approved'),false);
$commentdata = wp_filter_comment($commentdata);
wp_insert_comment($commentdata);
postincr($numAddedComments);
}postincr($numComments);
}if ( ($numAddedComments[0] > (0)))
 {echo AspisCheckPrint(array(': ',false));
printf(deAspis(_n(array('imported %s comment',false),array('imported %s comments',false),$numAddedComments)),deAspisRC($numAddedComments));
}$preExisting = array($numComments[0] - numAddedComments,false);
if ( ($preExisting[0] > (0)))
 {echo AspisCheckPrint(array(' ',false));
printf(deAspis(_n(array('ignored %s pre-existing comment',false),array('ignored %s pre-existing comments',false),$preExisting)),deAspisRC($preExisting));
}}echo AspisCheckPrint(concat2(concat1('... <strong>',__(array('Done',false))),'</strong></li>'));
}}do_action(array('import_done',false),array('greymatter',false));
;
?>
</ul><strong><?php _e(array('Done',false));
?></strong></li></ul>
<p>&nbsp;</p>
<p><?php _e(array('Completed GreyMatter import!',false));
?></p>
<?php $this->footer();
return ;
} }
function dispatch (  ) {
{if ( ((empty($_GET[0][('step')]) || Aspis_empty( $_GET [0][('step')]))))
 $step = array(0,false);
else 
{$step = int_cast($_GET[0]['step']);
}switch ( $step[0] ) {
case (0):$this->greet();
break ;
case (1):check_admin_referer(array('import-greymatter',false));
$result = $this->import();
if ( deAspis(is_wp_error($result)))
 echo AspisCheckPrint($result[0]->get_error_message());
break ;
 }
} }
function GM_Import (  ) {
{} }
}$gm_import = array(new GM_Import(),false);
register_importer(array('greymatter',false),__(array('GreyMatter',false)),__(array('Import users, posts, and comments from a Greymatter blog.',false)),array(array($gm_import,array('dispatch',false)),false));
;
?>
<?php 