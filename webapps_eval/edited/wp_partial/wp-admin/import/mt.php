<?php require_once('AspisMain.php'); ?><?php
class MT_Import{var $posts = array();
var $file;
var $id;
var $mtnames = array();
var $newauthornames = array();
var $j = -1;
function header (  ) {
{echo '<div class="wrap">';
screen_icon();
echo '<h2>' . __('Import Movable Type or TypePad') . '</h2>';
} }
function footer (  ) {
{echo '</div>';
} }
function greet (  ) {
{$this->header();
;
?>
<div class="narrow">
<p><?php _e('Howdy! We&#8217;re about to begin importing all of your Movable Type or TypePad entries into WordPress. To begin, either choose a file to upload and click &#8220;Upload file and import&#8221;, or use FTP to upload your MT export file as <code>mt-export.txt</code> in your <code>/wp-content/</code> directory and then click "Import mt-export.txt"');
;
?></p>

<?php wp_import_upload_form(add_query_arg('step',1));
;
?>
<form method="post" action="<?php echo esc_attr(add_query_arg('step',1));
;
?>" class="import-upload-form">

<?php wp_nonce_field('import-upload');
;
?>
<p>
	<input type="hidden" name="upload_type" value="ftp" />
<?php _e('Or use <code>mt-export.txt</code> in your <code>/wp-content/</code> directory');
;
?></p>
<p class="submit">
<input type="submit" class="button" value="<?php esc_attr_e('Import mt-export.txt');
;
?>" />
</p>
</form>
<p><?php _e('The importer is smart enough not to import duplicates, so you can run this multiple times without worry if&#8212;for whatever reason&#8212;it doesn&#8217;t finish. If you get an <strong>out of memory</strong> error try splitting up the import file into pieces.');
;
?> </p>
</div>
<?php $this->footer();
} }
function users_form ( $n ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$users = $wpdb->get_results("SELECT * FROM $wpdb->users ORDER BY ID");
;
?><select name="userselect[<?php echo $n;
;
?>]">
	<option value="#NONE#"><?php _e('- Select -');
?></option>
	<?php foreach ( $users as $user  )
{echo '<option value="' . $user->user_login . '">' . $user->user_login . '</option>';
};
?>
	</select>
	<?php }AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function has_gzip (  ) {
{{$AspisRetTemp = is_callable('gzopen');
return $AspisRetTemp;
}} }
function fopen ( $filename,$mode = 'r' ) {
{if ( $this->has_gzip())
 {$AspisRetTemp = gzopen($filename,$mode);
return $AspisRetTemp;
}{$AspisRetTemp = fopen($filename,$mode);
return $AspisRetTemp;
}} }
function feof ( $fp ) {
{if ( $this->has_gzip())
 {$AspisRetTemp = gzeof($fp);
return $AspisRetTemp;
}{$AspisRetTemp = feof($fp);
return $AspisRetTemp;
}} }
function fgets ( $fp,$len = 8192 ) {
{if ( $this->has_gzip())
 {$AspisRetTemp = gzgets($fp,$len);
return $AspisRetTemp;
}{$AspisRetTemp = fgets($fp,$len);
return $AspisRetTemp;
}} }
function fclose ( $fp ) {
{if ( $this->has_gzip())
 {$AspisRetTemp = gzclose($fp);
return $AspisRetTemp;
}{$AspisRetTemp = fclose($fp);
return $AspisRetTemp;
}} }
function checkauthor ( $author ) {
{$pass = wp_generate_password();
if ( !(in_array($author,$this->mtnames)))
 {++$this->j;
$this->mtnames[$this->j] = $author;
$user_id = username_exists($this->newauthornames[$this->j]);
if ( !$user_id)
 {if ( $this->newauthornames[$this->j] == 'left_blank')
 {$user_id = wp_create_user($author,$pass);
$this->newauthornames[$this->j] = $author;
}else 
{{$user_id = wp_create_user($this->newauthornames[$this->j],$pass);
}}}else 
{{{$AspisRetTemp = $user_id;
return $AspisRetTemp;
}}}}else 
{{$key = array_search($author,$this->mtnames);
$user_id = username_exists($this->newauthornames[$key]);
}}{$AspisRetTemp = $user_id;
return $AspisRetTemp;
}} }
function get_mt_authors (  ) {
{$temp = array();
$authors = array();
$handle = $this->fopen($this->file,'r');
if ( $handle == null)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$in_comment = false;
while ( $line = $this->fgets($handle) )
{$line = trim($line);
if ( 'COMMENT:' == $line)
 $in_comment = true;
else 
{if ( '-----' == $line)
 $in_comment = false;
}if ( $in_comment || 0 !== strpos($line,"AUTHOR:"))
 continue ;
$temp[] = trim(substr($line,strlen("AUTHOR:")));
}$authors[0] = array_shift($temp);
$y = count($temp) + 1;
for ( $x = 1 ; $x < $y ; $x++ )
{$next = array_shift($temp);
if ( !(in_array($next,$authors)))
 array_push($authors,"$next");
}$this->fclose($handle);
{$AspisRetTemp = $authors;
return $AspisRetTemp;
}} }
function get_authors_from_post (  ) {
{$formnames = array();
$selectnames = array();
foreach ( deAspisWarningRC($_POST[0]['user']) as $key =>$line )
{$newname = trim(stripslashes($line));
if ( $newname == '')
 $newname = 'left_blank';
array_push($formnames,"$newname");
}foreach ( deAspisWarningRC($_POST[0]['userselect']) as $user =>$key )
{$selected = trim(stripslashes($key));
array_push($selectnames,"$selected");
}$count = count($formnames);
for ( $i = 0 ; $i < $count ; $i++ )
{if ( $selectnames[$i] != '#NONE#')
 {array_push($this->newauthornames,"$selectnames[$i]");
}else 
{{array_push($this->newauthornames,"$formnames[$i]");
}}}} }
function mt_authors_form (  ) {
{;
?>
<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e('Assign Authors');
;
?></h2>
<p><?php _e('To make it easier for you to edit and save the imported posts and drafts, you may want to change the name of the author of the posts. For example, you may want to import all the entries as admin&#8217;s entries.');
;
?></p>
<p><?php _e('Below, you can see the names of the authors of the MovableType posts in <em>italics</em>. For each of these names, you can either pick an author in your WordPress installation from the menu, or enter a name for the author in the textbox.');
;
?></p>
<p><?php _e('If a new user is created by WordPress, a password will be randomly generated. Manually change the user&#8217;s details if necessary.');
;
?></p>
	<?php $authors = $this->get_mt_authors();
echo '<ol id="authors">';
echo '<form action="?import=mt&amp;step=2&amp;id=' . $this->id . '" method="post">';
wp_nonce_field('import-mt');
$j = -1;
foreach ( $authors as $author  )
{++$j;
echo '<li><label>' . __('Current author:') . ' <strong>' . $author . '</strong><br />' . sprintf(__('Create user %1$s or map to existing'),' <input type="text" value="' . esc_attr($author) . '" name="' . 'user[]' . '" maxlength="30"> <br />');
$this->users_form($j);
echo '</label></li>';
}echo '<p class="submit"><input type="submit" class="button" value="' . esc_attr__('Submit') . '"></p>' . '<br />';
echo '</form>';
echo '</ol></div>';
} }
function select_authors (  ) {
{if ( deAspisWarningRC($_POST[0]['upload_type']) === 'ftp')
 {$file['file'] = WP_CONTENT_DIR . '/mt-export.txt';
if ( !file_exists($file['file']))
 $file['error'] = __('<code>mt-export.txt</code> does not exist');
}else 
{{$file = wp_import_handle_upload();
}}if ( isset($file['error']))
 {$this->header();
echo '<p>' . __('Sorry, there has been an error') . '.</p>';
echo '<p><strong>' . $file['error'] . '</strong></p>';
$this->footer();
{return ;
}}$this->file = $file['file'];
$this->id = (int)$file['id'];
$this->mt_authors_form();
} }
function save_post ( &$post,&$comments,&$pings ) {
{set_time_limit(30);
$post = get_object_vars($post);
$post = deAspisWarningRC(add_magic_quotes(attAspisRCO($post)));
$post = (object)$post;
if ( $post_id = post_exists($post->post_title,'',$post->post_date))
 {echo '<li>';
printf(__('Post <em>%s</em> already exists.'),stripslashes($post->post_title));
}else 
{{echo '<li>';
printf(__('Importing post <em>%s</em>...'),stripslashes($post->post_title));
if ( '' != trim($post->extended))
 $post->post_content .= "\n<!--more-->\n$post->extended";
$post->post_author = $this->checkauthor($post->post_author);
$post_id = wp_insert_post($post);
if ( is_wp_error($post_id))
 {$AspisRetTemp = $post_id;
return $AspisRetTemp;
}if ( 0 != count($post->categories))
 {wp_create_categories($post->categories,$post_id);
}if ( 1 < strlen($post->post_keywords))
 {printf(__('<br />Adding tags <i>%s</i>...'),stripslashes($post->post_keywords));
wp_add_post_tags($post_id,$post->post_keywords);
}}}$num_comments = 0;
foreach ( $comments as $comment  )
{$comment = get_object_vars($comment);
$comment = deAspisWarningRC(add_magic_quotes(attAspisRCO($comment)));
if ( !comment_exists($comment['comment_author'],$comment['comment_date']))
 {$comment['comment_post_ID'] = $post_id;
$comment = wp_filter_comment($comment);
wp_insert_comment($comment);
$num_comments++;
}}if ( $num_comments)
 printf(' ' . _n('(%s comment)','(%s comments)',$num_comments),$num_comments);
$num_pings = 0;
foreach ( $pings as $ping  )
{$ping = get_object_vars($ping);
$ping = deAspisWarningRC(add_magic_quotes(attAspisRCO($ping)));
if ( !comment_exists($ping['comment_author'],$ping['comment_date']))
 {$ping['comment_content'] = "<strong>{$ping['title']}</strong>\n\n{$ping['comment_content']}";
$ping['comment_post_ID'] = $post_id;
$ping = wp_filter_comment($ping);
wp_insert_comment($ping);
$num_pings++;
}}if ( $num_pings)
 printf(' ' . _n('(%s ping)','(%s pings)',$num_pings),$num_pings);
echo "</li>";
} }
function process_posts (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$handle = $this->fopen($this->file,'r');
if ( $handle == null)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$context = '';
$post = new StdClass();
$comment = new StdClass();
$comments = array();
$ping = new StdClass();
$pings = array();
echo "<div class='wrap'><ol>";
while ( $line = $this->fgets($handle) )
{$line = trim($line);
if ( '-----' == $line)
 {if ( 'comment' == $context)
 {$comments[] = $comment;
$comment = new StdClass();
}else 
{if ( 'ping' == $context)
 {$pings[] = $ping;
$ping = new StdClass();
}}$context = '';
}else 
{if ( '--------' == $line)
 {$context = '';
$result = $this->save_post($post,$comments,$pings);
if ( is_wp_error($result))
 {$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$post = new StdClass;
$comment = new StdClass();
$ping = new StdClass();
$comments = array();
$pings = array();
}else 
{if ( 'BODY:' == $line)
 {$context = 'body';
}else 
{if ( 'EXTENDED BODY:' == $line)
 {$context = 'extended';
}else 
{if ( 'EXCERPT:' == $line)
 {$context = 'excerpt';
}else 
{if ( 'KEYWORDS:' == $line)
 {$context = 'keywords';
}else 
{if ( 'COMMENT:' == $line)
 {$context = 'comment';
}else 
{if ( 'PING:' == $line)
 {$context = 'ping';
}else 
{if ( 0 === strpos($line,"AUTHOR:"))
 {$author = trim(substr($line,strlen("AUTHOR:")));
if ( '' == $context)
 $post->post_author = $author;
else 
{if ( 'comment' == $context)
 $comment->comment_author = $author;
}}else 
{if ( 0 === strpos($line,"TITLE:"))
 {$title = trim(substr($line,strlen("TITLE:")));
if ( '' == $context)
 $post->post_title = $title;
else 
{if ( 'ping' == $context)
 $ping->title = $title;
}}else 
{if ( 0 === strpos($line,"STATUS:"))
 {$status = trim(strtolower(substr($line,strlen("STATUS:"))));
if ( empty($status))
 $status = 'publish';
$post->post_status = $status;
}else 
{if ( 0 === strpos($line,"ALLOW COMMENTS:"))
 {$allow = trim(substr($line,strlen("ALLOW COMMENTS:")));
if ( $allow == 1)
 $post->comment_status = 'open';
else 
{$post->comment_status = 'closed';
}}else 
{if ( 0 === strpos($line,"ALLOW PINGS:"))
 {$allow = trim(substr($line,strlen("ALLOW PINGS:")));
if ( $allow == 1)
 $post->ping_status = 'open';
else 
{$post->ping_status = 'closed';
}}else 
{if ( 0 === strpos($line,"CATEGORY:"))
 {$category = trim(substr($line,strlen("CATEGORY:")));
if ( '' != $category)
 $post->categories[] = $category;
}else 
{if ( 0 === strpos($line,"PRIMARY CATEGORY:"))
 {$category = trim(substr($line,strlen("PRIMARY CATEGORY:")));
if ( '' != $category)
 $post->categories[] = $category;
}else 
{if ( 0 === strpos($line,"DATE:"))
 {$date = trim(substr($line,strlen("DATE:")));
$date = strtotime($date);
$date = date('Y-m-d H:i:s',$date);
$date_gmt = get_gmt_from_date($date);
if ( '' == $context)
 {$post->post_modified = $date;
$post->post_modified_gmt = $date_gmt;
$post->post_date = $date;
$post->post_date_gmt = $date_gmt;
}else 
{if ( 'comment' == $context)
 {$comment->comment_date = $date;
}else 
{if ( 'ping' == $context)
 {$ping->comment_date = $date;
}}}}else 
{if ( 0 === strpos($line,"EMAIL:"))
 {$email = trim(substr($line,strlen("EMAIL:")));
if ( 'comment' == $context)
 $comment->comment_author_email = $email;
else 
{$ping->comment_author_email = '';
}}else 
{if ( 0 === strpos($line,"IP:"))
 {$ip = trim(substr($line,strlen("IP:")));
if ( 'comment' == $context)
 $comment->comment_author_IP = $ip;
else 
{$ping->comment_author_IP = $ip;
}}else 
{if ( 0 === strpos($line,"URL:"))
 {$url = trim(substr($line,strlen("URL:")));
if ( 'comment' == $context)
 $comment->comment_author_url = $url;
else 
{$ping->comment_author_url = $url;
}}else 
{if ( 0 === strpos($line,"BLOG NAME:"))
 {$blog = trim(substr($line,strlen("BLOG NAME:")));
$ping->comment_author = $blog;
}else 
{{if ( !empty($line))
 $line .= "\n";
if ( 'body' == $context)
 {$post->post_content .= $line;
}else 
{if ( 'extended' == $context)
 {$post->extended .= $line;
}else 
{if ( 'excerpt' == $context)
 {$post->post_excerpt .= $line;
}else 
{if ( 'keywords' == $context)
 {$post->post_keywords .= $line;
}else 
{if ( 'comment' == $context)
 {$comment->comment_content .= $line;
}else 
{if ( 'ping' == $context)
 {$ping->comment_content .= $line;
}}}}}}}}}}}}}}}}}}}}}}}}}}}}$this->fclose($handle);
echo '</ol>';
wp_import_cleanup($this->id);
do_action('import_done','mt');
echo '<h3>' . sprintf(__('All done. <a href="%s">Have fun!</a>'),get_option('home')) . '</h3></div>';
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function import (  ) {
{$this->id = (int)deAspisWarningRC($_GET[0]['id']);
if ( $this->id == 0)
 $this->file = WP_CONTENT_DIR . '/mt-export.txt';
else 
{$this->file = get_attached_file($this->id);
}$this->get_authors_from_post();
$result = $this->process_posts();
if ( is_wp_error($result))
 {$AspisRetTemp = $result;
return $AspisRetTemp;
}} }
function dispatch (  ) {
{if ( (empty($_GET[0]['step']) || Aspis_empty($_GET[0]['step'])))
 $step = 0;
else 
{$step = (int)deAspisWarningRC($_GET[0]['step']);
}switch ( $step ) {
case 0:$this->greet();
break ;
case 1:check_admin_referer('import-upload');
$this->select_authors();
break ;
case 2:check_admin_referer('import-mt');
$result = $this->import();
if ( is_wp_error($result))
 echo $result->get_error_message();
break ;
 }
} }
function MT_Import (  ) {
{} }
}$mt_import = new MT_Import();
register_importer('mt',__('Movable Type and TypePad'),__('Import posts and comments from a Movable Type or TypePad blog.'),array($mt_import,'dispatch'));
;
?>
<?php 