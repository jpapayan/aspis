<?php require_once('AspisMain.php'); ?><?php
if ( (!(function_exists(('get_comment_count')))))
 {function get_comment_count ( $post_ID ) {
global $wpdb;
return $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT count(*) FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d"),$post_ID));
 }
}if ( (!(function_exists(('link_exists')))))
 {function link_exists ( $linkname ) {
global $wpdb;
return $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT link_id FROM ",$wpdb[0]->links)," WHERE link_name = %s"),$linkname));
 }
}class Textpattern_Import{function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Import Textpattern',false))),'</h2>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Steps may take a few minutes depending on the size of your database. Please be patient.',false))),'</p>'));
} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function greet (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Howdy! This imports categories, users, posts, comments, and links from any Textpattern 4.0.2+ into this blog.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('This has not been tested on previous versions of Textpattern.  Mileage may vary.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Your Textpattern Configuration settings are as follows:',false))),'</p>'));
echo AspisCheckPrint(array('<form action="admin.php?import=textpattern&amp;step=1" method="post">',false));
wp_nonce_field(array('import-textpattern',false));
$this->db_form();
echo AspisCheckPrint(concat2(concat1('<p class="submit"><input type="submit" name="submit" class="button" value="',esc_attr__(array('Import',false))),'" /></p>'));
echo AspisCheckPrint(array('</form>',false));
echo AspisCheckPrint(array('</div>',false));
} }
function get_txp_cats (  ) {
{global $wpdb;
$txpdb = array(new wpdb(get_option(array('txpuser',false)),get_option(array('txppass',false)),get_option(array('txpname',false)),get_option(array('txphost',false))),false);
set_magic_quotes_runtime(0);
$prefix = get_option(array('tpre',false));
return $txpdb[0]->get_results(concat2(concat1('SELECT
			id,
			name,
			title
			FROM ',$prefix),'txp_category
			WHERE type = "article"'),array(ARRAY_A,false));
} }
function get_txp_users (  ) {
{global $wpdb;
$txpdb = array(new wpdb(get_option(array('txpuser',false)),get_option(array('txppass',false)),get_option(array('txpname',false)),get_option(array('txphost',false))),false);
set_magic_quotes_runtime(0);
$prefix = get_option(array('tpre',false));
return $txpdb[0]->get_results(concat2(concat1('SELECT
			user_id,
			name,
			RealName,
			email,
			privs
			FROM ',$prefix),'txp_users'),array(ARRAY_A,false));
} }
function get_txp_posts (  ) {
{$txpdb = array(new wpdb(get_option(array('txpuser',false)),get_option(array('txppass',false)),get_option(array('txpname',false)),get_option(array('txphost',false))),false);
set_magic_quotes_runtime(0);
$prefix = get_option(array('tpre',false));
return $txpdb[0]->get_results(concat2(concat1('SELECT
			ID,
			Posted,
			AuthorID,
			LastMod,
			Title,
			Body,
			Excerpt,
			Category1,
			Category2,
			Status,
			Keywords,
			url_title,
			comments_count
			FROM ',$prefix),'textpattern
			'),array(ARRAY_A,false));
} }
function get_txp_comments (  ) {
{global $wpdb;
$txpdb = array(new wpdb(get_option(array('txpuser',false)),get_option(array('txppass',false)),get_option(array('txpname',false)),get_option(array('txphost',false))),false);
set_magic_quotes_runtime(0);
$prefix = get_option(array('tpre',false));
return $txpdb[0]->get_results(concat2(concat1('SELECT * FROM ',$prefix),'txp_discuss'),array(ARRAY_A,false));
} }
function get_txp_links (  ) {
{$txpdb = array(new wpdb(get_option(array('txpuser',false)),get_option(array('txppass',false)),get_option(array('txpname',false)),get_option(array('txphost',false))),false);
set_magic_quotes_runtime(0);
$prefix = get_option(array('tpre',false));
return $txpdb[0]->get_results(concat2(concat1('SELECT
			id,
			date,
			category,
			url,
			linkname,
			description
			FROM ',$prefix),'txp_link'),array(ARRAY_A,false));
} }
function cat2wp ( $categories = array('',false) ) {
{global $wpdb;
$count = array(0,false);
$txpcat2wpcat = array(array(),false);
if ( is_array($categories[0]))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Importing Categories...',false))),'<br /><br /></p>'));
foreach ( $categories[0] as $category  )
{postincr($count);
extract(($category[0]));
$name = $wpdb[0]->escape($name);
$title = $wpdb[0]->escape($title);
if ( deAspis($cinfo = category_exists($name)))
 {$ret_id = wp_insert_category(array(array(deregisterTaint(array('cat_ID',false)) => addTaint($cinfo),deregisterTaint(array('category_nicename',false)) => addTaint($name),deregisterTaint(array('cat_name',false)) => addTaint($title)),false));
}else 
{{$ret_id = wp_insert_category(array(array(deregisterTaint(array('category_nicename',false)) => addTaint($name),deregisterTaint(array('cat_name',false)) => addTaint($title)),false));
}}arrayAssign($txpcat2wpcat[0],deAspis(registerTaint($id)),addTaint($ret_id));
}add_option(array('txpcat2wpcat',false),$txpcat2wpcat);
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(_n(array('Done! <strong>%1$s</strong> category imported.',false),array('Done! <strong>%1$s</strong> categories imported.',false),$count),$count)),'<br /><br /></p>'));
return array(true,false);
}echo AspisCheckPrint(__(array('No Categories to Import!',false)));
return array(false,false);
} }
function users2wp ( $users = array('',false) ) {
{global $wpdb;
$count = array(0,false);
$txpid2wpid = array(array(),false);
if ( is_array($users[0]))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Importing Users...',false))),'<br /><br /></p>'));
foreach ( $users[0] as $user  )
{postincr($count);
extract(($user[0]));
$name = $wpdb[0]->escape($name);
$RealName = $wpdb[0]->escape($RealName);
if ( deAspis($uinfo = get_userdatabylogin($name)))
 {$ret_id = wp_insert_user(array(array(deregisterTaint(array('ID',false)) => addTaint($uinfo[0]->ID),deregisterTaint(array('user_login',false)) => addTaint($name),deregisterTaint(array('user_nicename',false)) => addTaint($RealName),deregisterTaint(array('user_email',false)) => addTaint($email),'user_url' => array('http://',false,false),deregisterTaint(array('display_name',false)) => addTaint($name)),false));
}else 
{{$ret_id = wp_insert_user(array(array(deregisterTaint(array('user_login',false)) => addTaint($name),deregisterTaint(array('user_nicename',false)) => addTaint($RealName),deregisterTaint(array('user_email',false)) => addTaint($email),'user_url' => array('http://',false,false),deregisterTaint(array('display_name',false)) => addTaint($name)),false));
}}arrayAssign($txpid2wpid[0],deAspis(registerTaint($user_id)),addTaint($ret_id));
$transperms = array(array(1 => array('10',false,false),2 => array('9',false,false),3 => array('5',false,false),4 => array('4',false,false),5 => array('3',false,false),6 => array('2',false,false),7 => array('0',false,false)),false);
$user = array(new WP_User($ret_id),false);
if ( (('10') == deAspis(attachAspis($transperms,$privs[0]))))
 {$user[0]->set_role(array('administrator',false));
}if ( (('9') == deAspis(attachAspis($transperms,$privs[0]))))
 {$user[0]->set_role(array('editor',false));
}if ( (('5') == deAspis(attachAspis($transperms,$privs[0]))))
 {$user[0]->set_role(array('editor',false));
}if ( (('4') == deAspis(attachAspis($transperms,$privs[0]))))
 {$user[0]->set_role(array('author',false));
}if ( (('3') == deAspis(attachAspis($transperms,$privs[0]))))
 {$user[0]->set_role(array('contributor',false));
}if ( (('2') == deAspis(attachAspis($transperms,$privs[0]))))
 {$user[0]->set_role(array('contributor',false));
}if ( (('0') == deAspis(attachAspis($transperms,$privs[0]))))
 {$user[0]->set_role(array('subscriber',false));
}update_usermeta($ret_id,array('wp_user_level',false),attachAspis($transperms,$privs[0]));
update_usermeta($ret_id,array('rich_editing',false),array('false',false));
}add_option(array('txpid2wpid',false),$txpid2wpid);
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Done! <strong>%1$s</strong> users imported.',false)),$count)),'<br /><br /></p>'));
return array(true,false);
}echo AspisCheckPrint(__(array('No Users to Import!',false)));
return array(false,false);
} }
function posts2wp ( $posts = array('',false) ) {
{global $wpdb;
$count = array(0,false);
$txpposts2wpposts = array(array(),false);
$cats = array(array(),false);
if ( is_array($posts[0]))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Importing Posts...',false))),'<br /><br /></p>'));
foreach ( $posts[0] as $post  )
{postincr($count);
extract(($post[0]));
$stattrans = array(array(1 => array('draft',false,false),2 => array('private',false,false),3 => array('draft',false,false),4 => array('publish',false,false),5 => array('publish',false,false)),false);
$uinfo = deAspis((get_userdatabylogin($AuthorID))) ? get_userdatabylogin($AuthorID) : array(1,false);
$authorid = is_object($uinfo[0]) ? $uinfo[0]->ID : $uinfo;
$Title = $wpdb[0]->escape($Title);
$Body = $wpdb[0]->escape($Body);
$Excerpt = $wpdb[0]->escape($Excerpt);
$post_status = attachAspis($stattrans,$Status[0]);
if ( deAspis($pinfo = post_exists($Title,$Body)))
 {$ret_id = wp_insert_post(array(array(deregisterTaint(array('ID',false)) => addTaint($pinfo),deregisterTaint(array('post_date',false)) => addTaint($Posted),deregisterTaint(array('post_date_gmt',false)) => addTaint($post_date_gmt),deregisterTaint(array('post_author',false)) => addTaint($authorid),deregisterTaint(array('post_modified',false)) => addTaint($LastMod),deregisterTaint(array('post_modified_gmt',false)) => addTaint($post_modified_gmt),deregisterTaint(array('post_title',false)) => addTaint($Title),deregisterTaint(array('post_content',false)) => addTaint($Body),deregisterTaint(array('post_excerpt',false)) => addTaint($Excerpt),deregisterTaint(array('post_status',false)) => addTaint($post_status),deregisterTaint(array('post_name',false)) => addTaint($url_title),deregisterTaint(array('comment_count',false)) => addTaint($comments_count)),false));
if ( deAspis(is_wp_error($ret_id)))
 return $ret_id;
}else 
{{$ret_id = wp_insert_post(array(array(deregisterTaint(array('post_date',false)) => addTaint($Posted),deregisterTaint(array('post_date_gmt',false)) => addTaint($post_date_gmt),deregisterTaint(array('post_author',false)) => addTaint($authorid),deregisterTaint(array('post_modified',false)) => addTaint($LastMod),deregisterTaint(array('post_modified_gmt',false)) => addTaint($post_modified_gmt),deregisterTaint(array('post_title',false)) => addTaint($Title),deregisterTaint(array('post_content',false)) => addTaint($Body),deregisterTaint(array('post_excerpt',false)) => addTaint($Excerpt),deregisterTaint(array('post_status',false)) => addTaint($post_status),deregisterTaint(array('post_name',false)) => addTaint($url_title),deregisterTaint(array('comment_count',false)) => addTaint($comments_count)),false));
if ( deAspis(is_wp_error($ret_id)))
 return $ret_id;
}}arrayAssign($txpposts2wpposts[0],deAspis(registerTaint($ID)),addTaint($ret_id));
$cats = array(array(),false);
$category1 = get_category_by_slug($Category1);
$category1 = $category1[0]->term_id;
$category2 = get_category_by_slug($Category2);
$category2 = $category2[0]->term_id;
if ( deAspis($cat1 = $category1))
 {arrayAssign($cats[0],deAspis(registerTaint(array(1,false))),addTaint($cat1));
}if ( deAspis($cat2 = $category2))
 {arrayAssign($cats[0],deAspis(registerTaint(array(2,false))),addTaint($cat2));
}if ( (!((empty($cats) || Aspis_empty( $cats)))))
 {wp_set_post_categories($ret_id,$cats);
}}}add_option(array('txpposts2wpposts',false),$txpposts2wpposts);
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Done! <strong>%1$s</strong> posts imported.',false)),$count)),'<br /><br /></p>'));
return array(true,false);
} }
function comments2wp ( $comments = array('',false) ) {
{global $wpdb;
$count = array(0,false);
$txpcm2wpcm = array(array(),false);
$postarr = get_option(array('txpposts2wpposts',false));
if ( is_array($comments[0]))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Importing Comments...',false))),'<br /><br /></p>'));
foreach ( $comments[0] as $comment  )
{postincr($count);
extract(($comment[0]));
$comment_ID = Aspis_ltrim($discussid,array('0',false));
$comment_post_ID = attachAspis($postarr,$parentid[0]);
$comment_approved = ((1) == $visible[0]) ? array(1,false) : array(0,false);
$name = $wpdb[0]->escape($name);
$email = $wpdb[0]->escape($email);
$web = $wpdb[0]->escape($web);
$message = $wpdb[0]->escape($message);
$comment = array(array(deregisterTaint(array('comment_post_ID',false)) => addTaint($comment_post_ID),deregisterTaint(array('comment_author',false)) => addTaint($name),deregisterTaint(array('comment_author_IP',false)) => addTaint($ip),deregisterTaint(array('comment_author_email',false)) => addTaint($email),deregisterTaint(array('comment_author_url',false)) => addTaint($web),deregisterTaint(array('comment_date',false)) => addTaint($posted),deregisterTaint(array('comment_content',false)) => addTaint($message),deregisterTaint(array('comment_approved',false)) => addTaint($comment_approved)),false);
$comment = wp_filter_comment($comment);
if ( deAspis($cinfo = comment_exists($name,$posted)))
 {arrayAssign($comment[0],deAspis(registerTaint(array('comment_ID',false))),addTaint($cinfo));
$ret_id = wp_update_comment($comment);
}else 
{{$ret_id = wp_insert_comment($comment);
}}arrayAssign($txpcm2wpcm[0],deAspis(registerTaint($comment_ID)),addTaint($ret_id));
}add_option(array('txpcm2wpcm',false),$txpcm2wpcm);
get_comment_count($ret_id);
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Done! <strong>%1$s</strong> comments imported.',false)),$count)),'<br /><br /></p>'));
return array(true,false);
}echo AspisCheckPrint(__(array('No Comments to Import!',false)));
return array(false,false);
} }
function links2wp ( $links = array('',false) ) {
{global $wpdb;
$count = array(0,false);
if ( is_array($links[0]))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Importing Links...',false))),'<br /><br /></p>'));
foreach ( $links[0] as $link  )
{postincr($count);
extract(($link[0]));
$category = $wpdb[0]->escape($category);
$linkname = $wpdb[0]->escape($linkname);
$description = $wpdb[0]->escape($description);
if ( deAspis($linfo = link_exists($linkname)))
 {$ret_id = wp_insert_link(array(array(deregisterTaint(array('link_id',false)) => addTaint($linfo),deregisterTaint(array('link_url',false)) => addTaint($url),deregisterTaint(array('link_name',false)) => addTaint($linkname),deregisterTaint(array('link_category',false)) => addTaint($category),deregisterTaint(array('link_description',false)) => addTaint($description),deregisterTaint(array('link_updated',false)) => addTaint($date)),false));
}else 
{{$ret_id = wp_insert_link(array(array(deregisterTaint(array('link_url',false)) => addTaint($url),deregisterTaint(array('link_name',false)) => addTaint($linkname),deregisterTaint(array('link_category',false)) => addTaint($category),deregisterTaint(array('link_description',false)) => addTaint($description),deregisterTaint(array('link_updated',false)) => addTaint($date)),false));
}}arrayAssign($txplinks2wplinks[0],deAspis(registerTaint($link_id)),addTaint($ret_id));
}add_option(array('txplinks2wplinks',false),$txplinks2wplinks);
echo AspisCheckPrint(array('<p>',false));
printf(deAspis(_n(array('Done! <strong>%s</strong> link imported',false),array('Done! <strong>%s</strong> links imported',false),$count)),deAspisRC($count));
echo AspisCheckPrint(array('<br /><br /></p>',false));
return array(true,false);
}echo AspisCheckPrint(__(array('No Links to Import!',false)));
return array(false,false);
} }
function import_categories (  ) {
{$cats = $this->get_txp_cats();
$this->cat2wp($cats);
add_option(array('txp_cats',false),$cats);
echo AspisCheckPrint(array('<form action="admin.php?import=textpattern&amp;step=2" method="post">',false));
wp_nonce_field(array('import-textpattern',false));
printf(('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>'),deAspisRC(esc_attr__(array('Import Users',false))));
echo AspisCheckPrint(array('</form>',false));
} }
function import_users (  ) {
{$users = $this->get_txp_users();
$this->users2wp($users);
echo AspisCheckPrint(array('<form action="admin.php?import=textpattern&amp;step=3" method="post">',false));
wp_nonce_field(array('import-textpattern',false));
printf(('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>'),deAspisRC(esc_attr__(array('Import Posts',false))));
echo AspisCheckPrint(array('</form>',false));
} }
function import_posts (  ) {
{$posts = $this->get_txp_posts();
$result = $this->posts2wp($posts);
if ( deAspis(is_wp_error($result)))
 return $result;
echo AspisCheckPrint(array('<form action="admin.php?import=textpattern&amp;step=4" method="post">',false));
wp_nonce_field(array('import-textpattern',false));
printf(('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>'),deAspisRC(esc_attr__(array('Import Comments',false))));
echo AspisCheckPrint(array('</form>',false));
} }
function import_comments (  ) {
{$comments = $this->get_txp_comments();
$this->comments2wp($comments);
echo AspisCheckPrint(array('<form action="admin.php?import=textpattern&amp;step=5" method="post">',false));
wp_nonce_field(array('import-textpattern',false));
printf(('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>'),deAspisRC(esc_attr__(array('Import Links',false))));
echo AspisCheckPrint(array('</form>',false));
} }
function import_links (  ) {
{$links = $this->get_txp_links();
$this->links2wp($links);
add_option(array('txp_links',false),$links);
echo AspisCheckPrint(array('<form action="admin.php?import=textpattern&amp;step=6" method="post">',false));
wp_nonce_field(array('import-textpattern',false));
printf(('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>'),deAspisRC(esc_attr__(array('Finish',false))));
echo AspisCheckPrint(array('</form>',false));
} }
function cleanup_txpimport (  ) {
{delete_option(array('tpre',false));
delete_option(array('txp_cats',false));
delete_option(array('txpid2wpid',false));
delete_option(array('txpcat2wpcat',false));
delete_option(array('txpposts2wpposts',false));
delete_option(array('txpcm2wpcm',false));
delete_option(array('txplinks2wplinks',false));
delete_option(array('txpuser',false));
delete_option(array('txppass',false));
delete_option(array('txpname',false));
delete_option(array('txphost',false));
do_action(array('import_done',false),array('textpattern',false));
$this->tips();
} }
function tips (  ) {
{echo AspisCheckPrint(concat2(concat1('<p>',__(array('Welcome to WordPress.  We hope (and expect!) that you will find this platform incredibly rewarding!  As a new WordPress user coming from Textpattern, there are some things that we would like to point out.  Hopefully, they will help your transition go as smoothly as possible.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('Users',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('You have already setup WordPress and have been assigned an administrative login and password.  Forget it.  You didn&#8217;t have that login in Textpattern, why should you have it here?  Instead we have taken care to import all of your users into our system.  Unfortunately there is one downside.  Because both WordPress and Textpattern uses a strong encryption hash with passwords, it is impossible to decrypt it and we are forced to assign temporary passwords to all your users.  <strong>Every user has the same username, but their passwords are reset to password123.</strong>  So <a href="%1$s">log in</a> and change it.',false)),concat2(get_bloginfo(array('wpurl',false)),'/wp-login.php'))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('Preserving Authors',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Secondly, we have attempted to preserve post authors.  If you are the only author or contributor to your blog, then you are safe.  In most cases, we are successful in this preservation endeavor.  However, if we cannot ascertain the name of the writer due to discrepancies between database tables, we assign it to you, the administrative user.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('Textile',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Also, since you&#8217;re coming from Textpattern, you probably have been using Textile to format your comments and posts.  If this is the case, we recommend downloading and installing <a href="http://www.huddledmasses.org/category/development/wordpress/textile/">Textile for WordPress</a>.  Trust me... You&#8217;ll want it.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('WordPress Resources',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Finally, there are numerous WordPress resources around the internet.  Some of them are:',false))),'</p>'));
echo AspisCheckPrint(array('<ul>',false));
echo AspisCheckPrint(concat2(concat1('<li>',__(array('<a href="http://www.wordpress.org">The official WordPress site</a>',false))),'</li>'));
echo AspisCheckPrint(concat2(concat1('<li>',__(array('<a href="http://wordpress.org/support/">The WordPress support forums</a>',false))),'</li>'));
echo AspisCheckPrint(concat2(concat1('<li>',__(array('<a href="http://codex.wordpress.org">The Codex (In other words, the WordPress Bible)</a>',false))),'</li>'));
echo AspisCheckPrint(array('</ul>',false));
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('That&#8217;s it! What are you waiting for? Go <a href="%1$s">log in</a>!',false)),concat2(get_bloginfo(array('wpurl',false)),'/wp-login.php'))),'</p>'));
} }
function db_form (  ) {
{echo AspisCheckPrint(array('<table class="form-table">',false));
printf(('<tr><th scope="row"><label for="dbuser">%s</label></th><td><input type="text" name="dbuser" id="dbuser" /></td></tr>'),deAspisRC(__(array('Textpattern Database User:',false))));
printf(('<tr><th scope="row"><label for="dbpass">%s</label></th><td><input type="password" name="dbpass" id="dbpass" /></td></tr>'),deAspisRC(__(array('Textpattern Database Password:',false))));
printf(('<tr><th scope="row"><label for="dbname">%s</label></th><td><input type="text" id="dbname" name="dbname" /></td></tr>'),deAspisRC(__(array('Textpattern Database Name:',false))));
printf(('<tr><th scope="row"><label for="dbhost">%s</label></th><td><input type="text" id="dbhost" name="dbhost" value="localhost" /></td></tr>'),deAspisRC(__(array('Textpattern Database Host:',false))));
printf(('<tr><th scope="row"><label for="dbprefix">%s</label></th><td><input type="text" name="dbprefix" id="dbprefix"  /></td></tr>'),deAspisRC(__(array('Textpattern Table prefix (if any):',false))));
echo AspisCheckPrint(array('</table>',false));
} }
function dispatch (  ) {
{if ( ((empty($_GET[0][('step')]) || Aspis_empty( $_GET [0][('step')]))))
 $step = array(0,false);
else 
{$step = int_cast($_GET[0]['step']);
}$this->header();
if ( ($step[0] > (0)))
 {check_admin_referer(array('import-textpattern',false));
if ( deAspis($_POST[0]['dbuser']))
 {if ( deAspis(get_option(array('txpuser',false))))
 delete_option(array('txpuser',false));
add_option(array('txpuser',false),sanitize_user($_POST[0]['dbuser'],array(true,false)));
}if ( deAspis($_POST[0]['dbpass']))
 {if ( deAspis(get_option(array('txppass',false))))
 delete_option(array('txppass',false));
add_option(array('txppass',false),sanitize_user($_POST[0]['dbpass'],array(true,false)));
}if ( deAspis($_POST[0]['dbname']))
 {if ( deAspis(get_option(array('txpname',false))))
 delete_option(array('txpname',false));
add_option(array('txpname',false),sanitize_user($_POST[0]['dbname'],array(true,false)));
}if ( deAspis($_POST[0]['dbhost']))
 {if ( deAspis(get_option(array('txphost',false))))
 delete_option(array('txphost',false));
add_option(array('txphost',false),sanitize_user($_POST[0]['dbhost'],array(true,false)));
}if ( deAspis($_POST[0]['dbprefix']))
 {if ( deAspis(get_option(array('tpre',false))))
 delete_option(array('tpre',false));
add_option(array('tpre',false),sanitize_user($_POST[0]['dbprefix']));
}}switch ( $step[0] ) {
default :case (0):$this->greet();
break ;
case (1):$this->import_categories();
break ;
case (2):$this->import_users();
break ;
case (3):$result = $this->import_posts();
if ( deAspis(is_wp_error($result)))
 echo AspisCheckPrint($result[0]->get_error_message());
break ;
case (4):$this->import_comments();
break ;
case (5):$this->import_links();
break ;
case (6):$this->cleanup_txpimport();
break ;
 }
$this->footer();
} }
function Textpattern_Import (  ) {
{} }
}$txp_import = array(new Textpattern_Import(),false);
register_importer(array('textpattern',false),__(array('Textpattern',false)),__(array('Import categories, users, posts, comments, and links from a Textpattern blog.',false)),array(array($txp_import,array('dispatch',false)),false));
;
?>
<?php 