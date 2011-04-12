<?php require_once('AspisMain.php'); ?><?php
class MT_Import{var $posts = array(array(),false);
var $file;
var $id;
var $mtnames = array(array(),false);
var $newauthornames = array(array(),false);
var $j = array(-1,false);
function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Import Movable Type or TypePad',false))),'</h2>'));
} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function greet (  ) {
{$this->header();
;
?>
<div class="narrow">
<p><?php _e(array('Howdy! We&#8217;re about to begin importing all of your Movable Type or TypePad entries into WordPress. To begin, either choose a file to upload and click &#8220;Upload file and import&#8221;, or use FTP to upload your MT export file as <code>mt-export.txt</code> in your <code>/wp-content/</code> directory and then click "Import mt-export.txt"',false));
;
?></p>

<?php wp_import_upload_form(add_query_arg(array('step',false),array(1,false)));
;
?>
<form method="post" action="<?php echo AspisCheckPrint(esc_attr(add_query_arg(array('step',false),array(1,false))));
;
?>" class="import-upload-form">

<?php wp_nonce_field(array('import-upload',false));
;
?>
<p>
	<input type="hidden" name="upload_type" value="ftp" />
<?php _e(array('Or use <code>mt-export.txt</code> in your <code>/wp-content/</code> directory',false));
;
?></p>
<p class="submit">
<input type="submit" class="button" value="<?php esc_attr_e(array('Import mt-export.txt',false));
;
?>" />
</p>
</form>
<p><?php _e(array('The importer is smart enough not to import duplicates, so you can run this multiple times without worry if&#8212;for whatever reason&#8212;it doesn&#8217;t finish. If you get an <strong>out of memory</strong> error try splitting up the import file into pieces.',false));
;
?> </p>
</div>
<?php $this->footer();
} }
function users_form ( $n ) {
{global $wpdb;
$users = $wpdb[0]->get_results(concat2(concat1("SELECT * FROM ",$wpdb[0]->users)," ORDER BY ID"));
;
?><select name="userselect[<?php echo AspisCheckPrint($n);
;
?>]">
	<option value="#NONE#"><?php _e(array('- Select -',false));
?></option>
	<?php foreach ( $users[0] as $user  )
{echo AspisCheckPrint(concat2(concat(concat2(concat1('<option value="',$user[0]->user_login),'">'),$user[0]->user_login),'</option>'));
};
?>
	</select>
	<?php } }
function has_gzip (  ) {
{return attAspis(is_callable('gzopen'));
} }
function fopen ( $filename,$mode = array('r',false) ) {
{if ( deAspis($this->has_gzip()))
 return array(gzopen(deAspisRC($filename),deAspisRC($mode)),false);
return attAspis(fopen($filename[0],$mode[0]));
} }
function feof ( $fp ) {
{if ( deAspis($this->has_gzip()))
 return array(gzeof(deAspisRC($fp)),false);
return attAspis(feof($fp[0]));
} }
function fgets ( $fp,$len = array(8192,false) ) {
{if ( deAspis($this->has_gzip()))
 return array(gzgets(deAspisRC($fp),deAspisRC($len)),false);
return attAspis(fgets($fp[0],$len[0]));
} }
function fclose ( $fp ) {
{if ( deAspis($this->has_gzip()))
 return array(gzclose(deAspisRC($fp)),false);
return attAspis(fclose($fp[0]));
} }
function checkauthor ( $author ) {
{$pass = wp_generate_password();
if ( (denot_boolean((Aspis_in_array($author,$this->mtnames)))))
 {preincr($this->j);
arrayAssign($this->mtnames[0],deAspis(registerTaint($this->j)),addTaint($author));
$user_id = username_exists($this->newauthornames[0][$this->j[0]]);
if ( (denot_boolean($user_id)))
 {if ( ($this->newauthornames[0][$this->j[0]][0] == ('left_blank')))
 {$user_id = wp_create_user($author,$pass);
arrayAssign($this->newauthornames[0],deAspis(registerTaint($this->j)),addTaint($author));
}else 
{{$user_id = wp_create_user($this->newauthornames[0][$this->j[0]],$pass);
}}}else 
{{return $user_id;
}}}else 
{{$key = Aspis_array_search($author,$this->mtnames);
$user_id = username_exists($this->newauthornames[0][$key[0]]);
}}return $user_id;
} }
function get_mt_authors (  ) {
{$temp = array(array(),false);
$authors = array(array(),false);
$handle = $this->fopen($this->file,array('r',false));
if ( ($handle[0] == null))
 return array(false,false);
$in_comment = array(false,false);
while ( deAspis($line = $this->fgets($handle)) )
{$line = Aspis_trim($line);
if ( (('COMMENT:') == $line[0]))
 $in_comment = array(true,false);
else 
{if ( (('-----') == $line[0]))
 $in_comment = array(false,false);
}if ( ($in_comment[0] || ((0) !== strpos($line[0],"AUTHOR:"))))
 continue ;
arrayAssignAdd($temp[0][],addTaint(Aspis_trim(Aspis_substr($line,attAspis(strlen(("AUTHOR:")))))));
}arrayAssign($authors[0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_array_shift($temp)));
$y = array(count($temp[0]) + (1),false);
for ( $x = array(1,false) ; ($x[0] < $y[0]) ; postincr($x) )
{$next = Aspis_array_shift($temp);
if ( (denot_boolean((Aspis_in_array($next,$authors)))))
 Aspis_array_push($authors,$next);
}$this->fclose($handle);
return $authors;
} }
function get_authors_from_post (  ) {
{$formnames = array(array(),false);
$selectnames = array(array(),false);
foreach ( deAspis($_POST[0]['user']) as $key =>$line )
{restoreTaint($key,$line);
{$newname = Aspis_trim(Aspis_stripslashes($line));
if ( ($newname[0] == ('')))
 $newname = array('left_blank',false);
Aspis_array_push($formnames,$newname);
}}foreach ( deAspis($_POST[0]['userselect']) as $user =>$key )
{restoreTaint($user,$key);
{$selected = Aspis_trim(Aspis_stripslashes($key));
Aspis_array_push($selectnames,$selected);
}}$count = attAspis(count($formnames[0]));
for ( $i = array(0,false) ; ($i[0] < $count[0]) ; postincr($i) )
{if ( (deAspis(attachAspis($selectnames,$i[0])) != ('#NONE#')))
 {Aspis_array_push($this->newauthornames,attachAspis($selectnames,$i[0]));
}else 
{{Aspis_array_push($this->newauthornames,attachAspis($formnames,$i[0]));
}}}} }
function mt_authors_form (  ) {
{;
?>
<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e(array('Assign Authors',false));
;
?></h2>
<p><?php _e(array('To make it easier for you to edit and save the imported posts and drafts, you may want to change the name of the author of the posts. For example, you may want to import all the entries as admin&#8217;s entries.',false));
;
?></p>
<p><?php _e(array('Below, you can see the names of the authors of the MovableType posts in <em>italics</em>. For each of these names, you can either pick an author in your WordPress installation from the menu, or enter a name for the author in the textbox.',false));
;
?></p>
<p><?php _e(array('If a new user is created by WordPress, a password will be randomly generated. Manually change the user&#8217;s details if necessary.',false));
;
?></p>
	<?php $authors = $this->get_mt_authors();
echo AspisCheckPrint(array('<ol id="authors">',false));
echo AspisCheckPrint(concat2(concat1('<form action="?import=mt&amp;step=2&amp;id=',$this->id),'" method="post">'));
wp_nonce_field(array('import-mt',false));
$j = negate(array(1,false));
foreach ( $authors[0] as $author  )
{preincr($j);
echo AspisCheckPrint(concat(concat2(concat(concat2(concat1('<li><label>',__(array('Current author:',false))),' <strong>'),$author),'</strong><br />'),Aspis_sprintf(__(array('Create user %1$s or map to existing',false)),concat2(concat2(concat2(concat1(' <input type="text" value="',esc_attr($author)),'" name="'),'user[]'),'" maxlength="30"> <br />'))));
$this->users_form($j);
echo AspisCheckPrint(array('</label></li>',false));
}echo AspisCheckPrint(concat2(concat2(concat1('<p class="submit"><input type="submit" class="button" value="',esc_attr__(array('Submit',false))),'"></p>'),'<br />'));
echo AspisCheckPrint(array('</form>',false));
echo AspisCheckPrint(array('</ol></div>',false));
} }
function select_authors (  ) {
{if ( (deAspis($_POST[0]['upload_type']) === ('ftp')))
 {arrayAssign($file[0],deAspis(registerTaint(array('file',false))),addTaint(concat12(WP_CONTENT_DIR,'/mt-export.txt')));
if ( (!(file_exists(deAspis($file[0]['file'])))))
 arrayAssign($file[0],deAspis(registerTaint(array('error',false))),addTaint(__(array('<code>mt-export.txt</code> does not exist',false))));
}else 
{{$file = wp_import_handle_upload();
}}if ( ((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))))
 {$this->header();
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Sorry, there has been an error',false))),'.</p>'));
echo AspisCheckPrint(concat2(concat1('<p><strong>',$file[0]['error']),'</strong></p>'));
$this->footer();
return ;
}$this->file = $file[0]['file'];
$this->id = int_cast($file[0]['id']);
$this->mt_authors_form();
} }
function save_post ( &$post,&$comments,&$pings ) {
{set_time_limit(30);
$post = attAspis(get_object_vars(deAspisRC($post)));
$post = add_magic_quotes($post);
$post = object_cast($post);
if ( deAspis($post_id = post_exists($post[0]->post_title,array('',false),$post[0]->post_date)))
 {echo AspisCheckPrint(array('<li>',false));
printf(deAspis(__(array('Post <em>%s</em> already exists.',false))),deAspisRC(Aspis_stripslashes($post[0]->post_title)));
}else 
{{echo AspisCheckPrint(array('<li>',false));
printf(deAspis(__(array('Importing post <em>%s</em>...',false))),deAspisRC(Aspis_stripslashes($post[0]->post_title)));
if ( (('') != deAspis(Aspis_trim($post[0]->extended))))
 $post[0]->post_content = concat($post[0]->post_content ,concat1("\n<!--more-->\n",$post[0]->extended));
$post[0]->post_author = $this->checkauthor($post[0]->post_author);
$post_id = wp_insert_post($post);
if ( deAspis(is_wp_error($post_id)))
 return $post_id;
if ( ((0) != count($post[0]->categories[0])))
 {wp_create_categories($post[0]->categories,$post_id);
}if ( ((1) < strlen($post[0]->post_keywords[0])))
 {printf(deAspis(__(array('<br />Adding tags <i>%s</i>...',false))),deAspisRC(Aspis_stripslashes($post[0]->post_keywords)));
wp_add_post_tags($post_id,$post[0]->post_keywords);
}}}$num_comments = array(0,false);
foreach ( $comments[0] as $comment  )
{$comment = attAspis(get_object_vars(deAspisRC($comment)));
$comment = add_magic_quotes($comment);
if ( (denot_boolean(comment_exists($comment[0]['comment_author'],$comment[0]['comment_date']))))
 {arrayAssign($comment[0],deAspis(registerTaint(array('comment_post_ID',false))),addTaint($post_id));
$comment = wp_filter_comment($comment);
wp_insert_comment($comment);
postincr($num_comments);
}}if ( $num_comments[0])
 printf((deconcat1(' ',_n(array('(%s comment)',false),array('(%s comments)',false),$num_comments))),deAspisRC($num_comments));
$num_pings = array(0,false);
foreach ( $pings[0] as $ping  )
{$ping = attAspis(get_object_vars(deAspisRC($ping)));
$ping = add_magic_quotes($ping);
if ( (denot_boolean(comment_exists($ping[0]['comment_author'],$ping[0]['comment_date']))))
 {arrayAssign($ping[0],deAspis(registerTaint(array('comment_content',false))),addTaint(concat(concat2(concat1("<strong>",$ping[0]['title']),"</strong>\n\n"),$ping[0]['comment_content'])));
arrayAssign($ping[0],deAspis(registerTaint(array('comment_post_ID',false))),addTaint($post_id));
$ping = wp_filter_comment($ping);
wp_insert_comment($ping);
postincr($num_pings);
}}if ( $num_pings[0])
 printf((deconcat1(' ',_n(array('(%s ping)',false),array('(%s pings)',false),$num_pings))),deAspisRC($num_pings));
echo AspisCheckPrint(array("</li>",false));
} }
function process_posts (  ) {
{global $wpdb;
$handle = $this->fopen($this->file,array('r',false));
if ( ($handle[0] == null))
 return array(false,false);
$context = array('',false);
$post = array(new StdClass(),false);
$comment = array(new StdClass(),false);
$comments = array(array(),false);
$ping = array(new StdClass(),false);
$pings = array(array(),false);
echo AspisCheckPrint(array("<div class='wrap'><ol>",false));
while ( deAspis($line = $this->fgets($handle)) )
{$line = Aspis_trim($line);
if ( (('-----') == $line[0]))
 {if ( (('comment') == $context[0]))
 {arrayAssignAdd($comments[0][],addTaint($comment));
$comment = array(new StdClass(),false);
}else 
{if ( (('ping') == $context[0]))
 {arrayAssignAdd($pings[0][],addTaint($ping));
$ping = array(new StdClass(),false);
}}$context = array('',false);
}else 
{if ( (('--------') == $line[0]))
 {$context = array('',false);
$result = $this->save_post($post,$comments,$pings);
if ( deAspis(is_wp_error($result)))
 return $result;
$post = array(new StdClass,false);
$comment = array(new StdClass(),false);
$ping = array(new StdClass(),false);
$comments = array(array(),false);
$pings = array(array(),false);
}else 
{if ( (('BODY:') == $line[0]))
 {$context = array('body',false);
}else 
{if ( (('EXTENDED BODY:') == $line[0]))
 {$context = array('extended',false);
}else 
{if ( (('EXCERPT:') == $line[0]))
 {$context = array('excerpt',false);
}else 
{if ( (('KEYWORDS:') == $line[0]))
 {$context = array('keywords',false);
}else 
{if ( (('COMMENT:') == $line[0]))
 {$context = array('comment',false);
}else 
{if ( (('PING:') == $line[0]))
 {$context = array('ping',false);
}else 
{if ( ((0) === strpos($line[0],"AUTHOR:")))
 {$author = Aspis_trim(Aspis_substr($line,attAspis(strlen(("AUTHOR:")))));
if ( (('') == $context[0]))
 $post[0]->post_author = $author;
else 
{if ( (('comment') == $context[0]))
 $comment[0]->comment_author = $author;
}}else 
{if ( ((0) === strpos($line[0],"TITLE:")))
 {$title = Aspis_trim(Aspis_substr($line,attAspis(strlen(("TITLE:")))));
if ( (('') == $context[0]))
 $post[0]->post_title = $title;
else 
{if ( (('ping') == $context[0]))
 $ping[0]->title = $title;
}}else 
{if ( ((0) === strpos($line[0],"STATUS:")))
 {$status = Aspis_trim(Aspis_strtolower(Aspis_substr($line,attAspis(strlen(("STATUS:"))))));
if ( ((empty($status) || Aspis_empty( $status))))
 $status = array('publish',false);
$post[0]->post_status = $status;
}else 
{if ( ((0) === strpos($line[0],"ALLOW COMMENTS:")))
 {$allow = Aspis_trim(Aspis_substr($line,attAspis(strlen(("ALLOW COMMENTS:")))));
if ( ($allow[0] == (1)))
 $post[0]->comment_status = array('open',false);
else 
{$post[0]->comment_status = array('closed',false);
}}else 
{if ( ((0) === strpos($line[0],"ALLOW PINGS:")))
 {$allow = Aspis_trim(Aspis_substr($line,attAspis(strlen(("ALLOW PINGS:")))));
if ( ($allow[0] == (1)))
 $post[0]->ping_status = array('open',false);
else 
{$post[0]->ping_status = array('closed',false);
}}else 
{if ( ((0) === strpos($line[0],"CATEGORY:")))
 {$category = Aspis_trim(Aspis_substr($line,attAspis(strlen(("CATEGORY:")))));
if ( (('') != $category[0]))
 arrayAssignAdd($post[0]->categories[0][],addTaint($category));
}else 
{if ( ((0) === strpos($line[0],"PRIMARY CATEGORY:")))
 {$category = Aspis_trim(Aspis_substr($line,attAspis(strlen(("PRIMARY CATEGORY:")))));
if ( (('') != $category[0]))
 arrayAssignAdd($post[0]->categories[0][],addTaint($category));
}else 
{if ( ((0) === strpos($line[0],"DATE:")))
 {$date = Aspis_trim(Aspis_substr($line,attAspis(strlen(("DATE:")))));
$date = attAspis(strtotime($date[0]));
$date = attAspis(date(('Y-m-d H:i:s'),$date[0]));
$date_gmt = get_gmt_from_date($date);
if ( (('') == $context[0]))
 {$post[0]->post_modified = $date;
$post[0]->post_modified_gmt = $date_gmt;
$post[0]->post_date = $date;
$post[0]->post_date_gmt = $date_gmt;
}else 
{if ( (('comment') == $context[0]))
 {$comment[0]->comment_date = $date;
}else 
{if ( (('ping') == $context[0]))
 {$ping[0]->comment_date = $date;
}}}}else 
{if ( ((0) === strpos($line[0],"EMAIL:")))
 {$email = Aspis_trim(Aspis_substr($line,attAspis(strlen(("EMAIL:")))));
if ( (('comment') == $context[0]))
 $comment[0]->comment_author_email = $email;
else 
{$ping[0]->comment_author_email = array('',false);
}}else 
{if ( ((0) === strpos($line[0],"IP:")))
 {$ip = Aspis_trim(Aspis_substr($line,attAspis(strlen(("IP:")))));
if ( (('comment') == $context[0]))
 $comment[0]->comment_author_IP = $ip;
else 
{$ping[0]->comment_author_IP = $ip;
}}else 
{if ( ((0) === strpos($line[0],"URL:")))
 {$url = Aspis_trim(Aspis_substr($line,attAspis(strlen(("URL:")))));
if ( (('comment') == $context[0]))
 $comment[0]->comment_author_url = $url;
else 
{$ping[0]->comment_author_url = $url;
}}else 
{if ( ((0) === strpos($line[0],"BLOG NAME:")))
 {$blog = Aspis_trim(Aspis_substr($line,attAspis(strlen(("BLOG NAME:")))));
$ping[0]->comment_author = $blog;
}else 
{{if ( (!((empty($line) || Aspis_empty( $line)))))
 $line = concat2($line,"\n");
if ( (('body') == $context[0]))
 {$post[0]->post_content = concat($post[0]->post_content ,$line);
}else 
{if ( (('extended') == $context[0]))
 {$post[0]->extended = concat($post[0]->extended ,$line);
}else 
{if ( (('excerpt') == $context[0]))
 {$post[0]->post_excerpt = concat($post[0]->post_excerpt ,$line);
}else 
{if ( (('keywords') == $context[0]))
 {$post[0]->post_keywords = concat($post[0]->post_keywords ,$line);
}else 
{if ( (('comment') == $context[0]))
 {$comment[0]->comment_content = concat($comment[0]->comment_content ,$line);
}else 
{if ( (('ping') == $context[0]))
 {$ping[0]->comment_content = concat($ping[0]->comment_content ,$line);
}}}}}}}}}}}}}}}}}}}}}}}}}}}}$this->fclose($handle);
echo AspisCheckPrint(array('</ol>',false));
wp_import_cleanup($this->id);
do_action(array('import_done',false),array('mt',false));
echo AspisCheckPrint(concat2(concat1('<h3>',Aspis_sprintf(__(array('All done. <a href="%s">Have fun!</a>',false)),get_option(array('home',false)))),'</h3></div>'));
} }
function import (  ) {
{$this->id = int_cast($_GET[0]['id']);
if ( ($this->id[0] == (0)))
 $this->file = concat12(WP_CONTENT_DIR,'/mt-export.txt');
else 
{$this->file = get_attached_file($this->id);
}$this->get_authors_from_post();
$result = $this->process_posts();
if ( deAspis(is_wp_error($result)))
 return $result;
} }
function dispatch (  ) {
{if ( ((empty($_GET[0][('step')]) || Aspis_empty( $_GET [0][('step')]))))
 $step = array(0,false);
else 
{$step = int_cast($_GET[0]['step']);
}switch ( $step[0] ) {
case (0):$this->greet();
break ;
case (1):check_admin_referer(array('import-upload',false));
$this->select_authors();
break ;
case (2):check_admin_referer(array('import-mt',false));
$result = $this->import();
if ( deAspis(is_wp_error($result)))
 echo AspisCheckPrint($result[0]->get_error_message());
break ;
 }
} }
function MT_Import (  ) {
{} }
}$mt_import = array(new MT_Import(),false);
register_importer(array('mt',false),__(array('Movable Type and TypePad',false)),__(array('Import posts and comments from a Movable Type or TypePad blog.',false)),array(array($mt_import,array('dispatch',false)),false));
;
?>
<?php 