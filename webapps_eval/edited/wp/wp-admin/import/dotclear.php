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
}function csc ( $s ) {
if ( deAspis(seems_utf8($s)))
 {return $s;
}else 
{{return Aspis_iconv(get_option(array("dccharset",false)),array("UTF-8",false),$s);
}} }
function textconv ( $s ) {
return csc(Aspis_preg_replace(array('|(?<!<br />)\s*\n|',false),array(' ',false),$s));
 }
class Dotclear_Import{function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Import DotClear',false))),'</h2>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Steps may take a few minutes depending on the size of your database. Please be patient.',false))),'</p>'));
} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function greet (  ) {
{echo AspisCheckPrint(concat2(concat1('<div class="narrow"><p>',__(array('Howdy! This importer allows you to extract posts from a DotClear database into your blog.  Mileage may vary.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Your DotClear Configuration settings are as follows:',false))),'</p>'));
echo AspisCheckPrint(array('<form action="admin.php?import=dotclear&amp;step=1" method="post">',false));
wp_nonce_field(array('import-dotclear',false));
$this->db_form();
echo AspisCheckPrint(concat2(concat1('<p class="submit"><input type="submit" name="submit" class="button" value="',esc_attr__(array('Import Categories',false))),'" /></p>'));
echo AspisCheckPrint(array('</form></div>',false));
} }
function get_dc_cats (  ) {
{global $wpdb;
$dcdb = array(new wpdb(get_option(array('dcuser',false)),get_option(array('dcpass',false)),get_option(array('dcname',false)),get_option(array('dchost',false))),false);
set_magic_quotes_runtime(0);
$dbprefix = get_option(array('dcdbprefix',false));
return $dcdb[0]->get_results(concat2(concat1('SELECT * FROM ',$dbprefix),'categorie'),array(ARRAY_A,false));
} }
function get_dc_users (  ) {
{global $wpdb;
$dcdb = array(new wpdb(get_option(array('dcuser',false)),get_option(array('dcpass',false)),get_option(array('dcname',false)),get_option(array('dchost',false))),false);
set_magic_quotes_runtime(0);
$dbprefix = get_option(array('dcdbprefix',false));
return $dcdb[0]->get_results(concat2(concat1('SELECT * FROM ',$dbprefix),'user'),array(ARRAY_A,false));
} }
function get_dc_posts (  ) {
{$dcdb = array(new wpdb(get_option(array('dcuser',false)),get_option(array('dcpass',false)),get_option(array('dcname',false)),get_option(array('dchost',false))),false);
set_magic_quotes_runtime(0);
$dbprefix = get_option(array('dcdbprefix',false));
return $dcdb[0]->get_results(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('SELECT ',$dbprefix),'post.*, '),$dbprefix),'categorie.cat_libelle_url AS post_cat_name
						FROM '),$dbprefix),'post INNER JOIN '),$dbprefix),'categorie
						ON '),$dbprefix),'post.cat_id = '),$dbprefix),'categorie.cat_id'),array(ARRAY_A,false));
} }
function get_dc_comments (  ) {
{global $wpdb;
$dcdb = array(new wpdb(get_option(array('dcuser',false)),get_option(array('dcpass',false)),get_option(array('dcname',false)),get_option(array('dchost',false))),false);
set_magic_quotes_runtime(0);
$dbprefix = get_option(array('dcdbprefix',false));
return $dcdb[0]->get_results(concat2(concat1('SELECT * FROM ',$dbprefix),'comment'),array(ARRAY_A,false));
} }
function get_dc_links (  ) {
{$dcdb = array(new wpdb(get_option(array('dcuser',false)),get_option(array('dcpass',false)),get_option(array('dcname',false)),get_option(array('dchost',false))),false);
set_magic_quotes_runtime(0);
$dbprefix = get_option(array('dcdbprefix',false));
return $dcdb[0]->get_results(concat2(concat1('SELECT * FROM ',$dbprefix),'link ORDER BY position'),array(ARRAY_A,false));
} }
function cat2wp ( $categories = array('',false) ) {
{global $wpdb;
$count = array(0,false);
$dccat2wpcat = array(array(),false);
if ( is_array($categories[0]))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Importing Categories...',false))),'<br /><br /></p>'));
foreach ( $categories[0] as $category  )
{postincr($count);
extract(($category[0]));
$name = $wpdb[0]->escape($cat_libelle_url);
$title = $wpdb[0]->escape(csc($cat_libelle));
$desc = $wpdb[0]->escape(csc($cat_desc));
if ( deAspis($cinfo = category_exists($name)))
 {$ret_id = wp_insert_category(array(array(deregisterTaint(array('cat_ID',false)) => addTaint($cinfo),deregisterTaint(array('category_nicename',false)) => addTaint($name),deregisterTaint(array('cat_name',false)) => addTaint($title),deregisterTaint(array('category_description',false)) => addTaint($desc)),false));
}else 
{{$ret_id = wp_insert_category(array(array(deregisterTaint(array('category_nicename',false)) => addTaint($name),deregisterTaint(array('cat_name',false)) => addTaint($title),deregisterTaint(array('category_description',false)) => addTaint($desc)),false));
}}arrayAssign($dccat2wpcat[0],deAspis(registerTaint($id)),addTaint($ret_id));
}add_option(array('dccat2wpcat',false),$dccat2wpcat);
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(_n(array('Done! <strong>%1$s</strong> category imported.',false),array('Done! <strong>%1$s</strong> categories imported.',false),$count),$count)),'<br /><br /></p>'));
return array(true,false);
}echo AspisCheckPrint(__(array('No Categories to Import!',false)));
return array(false,false);
} }
function users2wp ( $users = array('',false) ) {
{global $wpdb;
$count = array(0,false);
$dcid2wpid = array(array(),false);
if ( is_array($users[0]))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Importing Users...',false))),'<br /><br /></p>'));
foreach ( $users[0] as $user  )
{postincr($count);
extract(($user[0]));
$name = $wpdb[0]->escape(csc($name));
$RealName = $wpdb[0]->escape(csc($user_pseudo));
if ( deAspis($uinfo = get_userdatabylogin($name)))
 {$ret_id = wp_insert_user(array(array(deregisterTaint(array('ID',false)) => addTaint($uinfo[0]->ID),deregisterTaint(array('user_login',false)) => addTaint($user_id),deregisterTaint(array('user_nicename',false)) => addTaint($Realname),deregisterTaint(array('user_email',false)) => addTaint($user_email),'user_url' => array('http://',false,false),deregisterTaint(array('display_name',false)) => addTaint($Realname)),false));
}else 
{{$ret_id = wp_insert_user(array(array(deregisterTaint(array('user_login',false)) => addTaint($user_id),deregisterTaint(array('user_nicename',false)) => addTaint(csc($user_pseudo)),deregisterTaint(array('user_email',false)) => addTaint($user_email),'user_url' => array('http://',false,false),deregisterTaint(array('display_name',false)) => addTaint($Realname)),false));
}}arrayAssign($dcid2wpid[0],deAspis(registerTaint($user_id)),addTaint($ret_id));
$user = array(new WP_User($ret_id),false);
$wp_perms = array($user_level[0] + (1),false);
if ( ((10) == $wp_perms[0]))
 {$user[0]->set_role(array('administrator',false));
}else 
{if ( ((9) == $wp_perms[0]))
 {$user[0]->set_role(array('editor',false));
}else 
{if ( ((5) <= $wp_perms[0]))
 {$user[0]->set_role(array('editor',false));
}else 
{if ( ((4) <= $wp_perms[0]))
 {$user[0]->set_role(array('author',false));
}else 
{if ( ((3) <= $wp_perms[0]))
 {$user[0]->set_role(array('contributor',false));
}else 
{if ( ((2) <= $wp_perms[0]))
 {$user[0]->set_role(array('contributor',false));
}else 
{{$user[0]->set_role(array('subscriber',false));
}}}}}}}update_usermeta($ret_id,array('wp_user_level',false),$wp_perms);
update_usermeta($ret_id,array('rich_editing',false),array('false',false));
update_usermeta($ret_id,array('first_name',false),csc($user_prenom));
update_usermeta($ret_id,array('last_name',false),csc($user_nom));
}add_option(array('dcid2wpid',false),$dcid2wpid);
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Done! <strong>%1$s</strong> users imported.',false)),$count)),'<br /><br /></p>'));
return array(true,false);
}echo AspisCheckPrint(__(array('No Users to Import!',false)));
return array(false,false);
} }
function posts2wp ( $posts = array('',false) ) {
{global $wpdb;
$count = array(0,false);
$dcposts2wpposts = array(array(),false);
$cats = array(array(),false);
if ( is_array($posts[0]))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Importing Posts...',false))),'<br /><br /></p>'));
foreach ( $posts[0] as $post  )
{postincr($count);
extract(($post[0]));
$stattrans = array(array(0 => array('draft',false,false),1 => array('publish',false,false)),false);
$comment_status_map = array(array(0 => array('closed',false,false),1 => array('open',false,false)),false);
$uinfo = deAspis((get_userdatabylogin($user_id))) ? get_userdatabylogin($user_id) : array(1,false);
$authorid = is_object($uinfo[0]) ? $uinfo[0]->ID : $uinfo;
$Title = $wpdb[0]->escape(csc($post_titre));
$post_content = textconv($post_content);
$post_excerpt = array("",false);
if ( ($post_chapo[0] != ("")))
 {$post_excerpt = textconv($post_chapo);
$post_content = concat(concat2($post_excerpt,"\n<!--more-->\n"),$post_content);
}$post_excerpt = $wpdb[0]->escape($post_excerpt);
$post_content = $wpdb[0]->escape($post_content);
$post_status = attachAspis($stattrans,$post_pub[0]);
if ( deAspis($pinfo = post_exists($Title,$post_content)))
 {$ret_id = wp_insert_post(array(array(deregisterTaint(array('ID',false)) => addTaint($pinfo),deregisterTaint(array('post_author',false)) => addTaint($authorid),deregisterTaint(array('post_date',false)) => addTaint($post_dt),deregisterTaint(array('post_date_gmt',false)) => addTaint($post_dt),deregisterTaint(array('post_modified',false)) => addTaint($post_upddt),deregisterTaint(array('post_modified_gmt',false)) => addTaint($post_upddt),deregisterTaint(array('post_title',false)) => addTaint($Title),deregisterTaint(array('post_content',false)) => addTaint($post_content),deregisterTaint(array('post_excerpt',false)) => addTaint($post_excerpt),deregisterTaint(array('post_status',false)) => addTaint($post_status),deregisterTaint(array('post_name',false)) => addTaint($post_titre_url),deregisterTaint(array('comment_status',false)) => addTaint(attachAspis($comment_status_map,$post_open_comment[0])),deregisterTaint(array('ping_status',false)) => addTaint(attachAspis($comment_status_map,$post_open_tb[0])),'comment_count' => array($post_nb_comment[0] + $post_nb_trackback[0],false,false)),false));
if ( deAspis(is_wp_error($ret_id)))
 return $ret_id;
}else 
{{$ret_id = wp_insert_post(array(array(deregisterTaint(array('post_author',false)) => addTaint($authorid),deregisterTaint(array('post_date',false)) => addTaint($post_dt),deregisterTaint(array('post_date_gmt',false)) => addTaint($post_dt),deregisterTaint(array('post_modified',false)) => addTaint($post_modified_gmt),deregisterTaint(array('post_modified_gmt',false)) => addTaint($post_modified_gmt),deregisterTaint(array('post_title',false)) => addTaint($Title),deregisterTaint(array('post_content',false)) => addTaint($post_content),deregisterTaint(array('post_excerpt',false)) => addTaint($post_excerpt),deregisterTaint(array('post_status',false)) => addTaint($post_status),deregisterTaint(array('post_name',false)) => addTaint($post_titre_url),deregisterTaint(array('comment_status',false)) => addTaint(attachAspis($comment_status_map,$post_open_comment[0])),deregisterTaint(array('ping_status',false)) => addTaint(attachAspis($comment_status_map,$post_open_tb[0])),'comment_count' => array($post_nb_comment[0] + $post_nb_trackback[0],false,false)),false));
if ( deAspis(is_wp_error($ret_id)))
 return $ret_id;
}}arrayAssign($dcposts2wpposts[0],deAspis(registerTaint($post_id)),addTaint($ret_id));
$cats = array(array(),false);
$category1 = get_category_by_slug($post_cat_name);
$category1 = $category1[0]->term_id;
if ( deAspis($cat1 = $category1))
 {arrayAssign($cats[0],deAspis(registerTaint(array(1,false))),addTaint($cat1));
}if ( (!((empty($cats) || Aspis_empty( $cats)))))
 {wp_set_post_categories($ret_id,$cats);
}}}add_option(array('dcposts2wpposts',false),$dcposts2wpposts);
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('Done! <strong>%1$s</strong> posts imported.',false)),$count)),'<br /><br /></p>'));
return array(true,false);
} }
function comments2wp ( $comments = array('',false) ) {
{global $wpdb;
$count = array(0,false);
$dccm2wpcm = array(array(),false);
$postarr = get_option(array('dcposts2wpposts',false));
if ( is_array($comments[0]))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Importing Comments...',false))),'<br /><br /></p>'));
foreach ( $comments[0] as $comment  )
{postincr($count);
extract(($comment[0]));
$comment_ID = int_cast(Aspis_ltrim($comment_id,array('0',false)));
$comment_post_ID = int_cast(attachAspis($postarr,$post_id[0]));
$comment_approved = $comment_pub;
$name = $wpdb[0]->escape(csc($comment_auteur));
$email = $wpdb[0]->escape($comment_email);
$web = concat1("http://",$wpdb[0]->escape($comment_site));
$message = $wpdb[0]->escape(textconv($comment_content));
$comment = array(array(deregisterTaint(array('comment_post_ID',false)) => addTaint($comment_post_ID),deregisterTaint(array('comment_author',false)) => addTaint($name),deregisterTaint(array('comment_author_email',false)) => addTaint($email),deregisterTaint(array('comment_author_url',false)) => addTaint($web),deregisterTaint(array('comment_author_IP',false)) => addTaint($comment_ip),deregisterTaint(array('comment_date',false)) => addTaint($comment_dt),deregisterTaint(array('comment_date_gmt',false)) => addTaint($comment_dt),deregisterTaint(array('comment_content',false)) => addTaint($message),deregisterTaint(array('comment_approved',false)) => addTaint($comment_approved)),false);
$comment = wp_filter_comment($comment);
if ( deAspis($cinfo = comment_exists($name,$comment_dt)))
 {arrayAssign($comment[0],deAspis(registerTaint(array('comment_ID',false))),addTaint($cinfo));
$ret_id = wp_update_comment($comment);
}else 
{{$ret_id = wp_insert_comment($comment);
}}arrayAssign($dccm2wpcm[0],deAspis(registerTaint($comment_ID)),addTaint($ret_id));
}add_option(array('dccm2wpcm',false),$dccm2wpcm);
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
if ( ($title[0] != ("")))
 {if ( deAspis($cinfo = is_term(csc($title),array('link_category',false))))
 {$category = $cinfo[0]['term_id'];
}else 
{{$category = wp_insert_term($wpdb[0]->escape(csc($title)),array('link_category',false));
$category = $category[0]['term_id'];
}}}else 
{{$linkname = $wpdb[0]->escape(csc($label));
$description = $wpdb[0]->escape(csc($title));
if ( deAspis($linfo = link_exists($linkname)))
 {$ret_id = wp_insert_link(array(array(deregisterTaint(array('link_id',false)) => addTaint($linfo),deregisterTaint(array('link_url',false)) => addTaint($href),deregisterTaint(array('link_name',false)) => addTaint($linkname),deregisterTaint(array('link_category',false)) => addTaint($category),deregisterTaint(array('link_description',false)) => addTaint($description)),false));
}else 
{{$ret_id = wp_insert_link(array(array(deregisterTaint(array('link_url',false)) => addTaint($url),deregisterTaint(array('link_name',false)) => addTaint($linkname),deregisterTaint(array('link_category',false)) => addTaint($category),deregisterTaint(array('link_description',false)) => addTaint($description)),false));
}}arrayAssign($dclinks2wplinks[0],deAspis(registerTaint($link_id)),addTaint($ret_id));
}}}add_option(array('dclinks2wplinks',false),$dclinks2wplinks);
echo AspisCheckPrint(array('<p>',false));
printf(deAspis(_n(array('Done! <strong>%s</strong> link or link category imported.',false),array('Done! <strong>%s</strong> links or link categories imported.',false),$count)),deAspisRC($count));
echo AspisCheckPrint(array('<br /><br /></p>',false));
return array(true,false);
}echo AspisCheckPrint(__(array('No Links to Import!',false)));
return array(false,false);
} }
function import_categories (  ) {
{$cats = $this->get_dc_cats();
$this->cat2wp($cats);
add_option(array('dc_cats',false),$cats);
echo AspisCheckPrint(array('<form action="admin.php?import=dotclear&amp;step=2" method="post">',false));
wp_nonce_field(array('import-dotclear',false));
printf(('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>'),deAspisRC(esc_attr__(array('Import Users',false))));
echo AspisCheckPrint(array('</form>',false));
} }
function import_users (  ) {
{$users = $this->get_dc_users();
$this->users2wp($users);
echo AspisCheckPrint(array('<form action="admin.php?import=dotclear&amp;step=3" method="post">',false));
wp_nonce_field(array('import-dotclear',false));
printf(('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>'),deAspisRC(esc_attr__(array('Import Posts',false))));
echo AspisCheckPrint(array('</form>',false));
} }
function import_posts (  ) {
{$posts = $this->get_dc_posts();
$result = $this->posts2wp($posts);
if ( deAspis(is_wp_error($result)))
 return $result;
echo AspisCheckPrint(array('<form action="admin.php?import=dotclear&amp;step=4" method="post">',false));
wp_nonce_field(array('import-dotclear',false));
printf(('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>'),deAspisRC(esc_attr__(array('Import Comments',false))));
echo AspisCheckPrint(array('</form>',false));
} }
function import_comments (  ) {
{$comments = $this->get_dc_comments();
$this->comments2wp($comments);
echo AspisCheckPrint(array('<form action="admin.php?import=dotclear&amp;step=5" method="post">',false));
wp_nonce_field(array('import-dotclear',false));
printf(('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>'),deAspisRC(esc_attr__(array('Import Links',false))));
echo AspisCheckPrint(array('</form>',false));
} }
function import_links (  ) {
{$links = $this->get_dc_links();
$this->links2wp($links);
add_option(array('dc_links',false),$links);
echo AspisCheckPrint(array('<form action="admin.php?import=dotclear&amp;step=6" method="post">',false));
wp_nonce_field(array('import-dotclear',false));
printf(('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>'),deAspisRC(esc_attr__(array('Finish',false))));
echo AspisCheckPrint(array('</form>',false));
} }
function cleanup_dcimport (  ) {
{delete_option(array('dcdbprefix',false));
delete_option(array('dc_cats',false));
delete_option(array('dcid2wpid',false));
delete_option(array('dccat2wpcat',false));
delete_option(array('dcposts2wpposts',false));
delete_option(array('dccm2wpcm',false));
delete_option(array('dclinks2wplinks',false));
delete_option(array('dcuser',false));
delete_option(array('dcpass',false));
delete_option(array('dcname',false));
delete_option(array('dchost',false));
delete_option(array('dccharset',false));
do_action(array('import_done',false),array('dotclear',false));
$this->tips();
} }
function tips (  ) {
{echo AspisCheckPrint(concat2(concat1('<p>',__(array('Welcome to WordPress.  We hope (and expect!) that you will find this platform incredibly rewarding!  As a new WordPress user coming from DotClear, there are some things that we would like to point out.  Hopefully, they will help your transition go as smoothly as possible.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('Users',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('You have already setup WordPress and have been assigned an administrative login and password.  Forget it.  You didn&#8217;t have that login in DotClear, why should you have it here?  Instead we have taken care to import all of your users into our system.  Unfortunately there is one downside.  Because both WordPress and DotClear uses a strong encryption hash with passwords, it is impossible to decrypt it and we are forced to assign temporary passwords to all your users.  <strong>Every user has the same username, but their passwords are reset to password123.</strong>  So <a href="%1$s">Log in</a> and change it.',false)),array('/wp-login.php',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('Preserving Authors',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Secondly, we have attempted to preserve post authors.  If you are the only author or contributor to your blog, then you are safe.  In most cases, we are successful in this preservation endeavor.  However, if we cannot ascertain the name of the writer due to discrepancies between database tables, we assign it to you, the administrative user.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('Textile',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Also, since you&#8217;re coming from DotClear, you probably have been using Textile to format your comments and posts.  If this is the case, we recommend downloading and installing <a href="http://www.huddledmasses.org/category/development/wordpress/textile/">Textile for WordPress</a>.  Trust me&#8230; You&#8217;ll want it.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<h3>',__(array('WordPress Resources',false))),'</h3>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Finally, there are numerous WordPress resources around the internet.  Some of them are:',false))),'</p>'));
echo AspisCheckPrint(array('<ul>',false));
echo AspisCheckPrint(concat2(concat1('<li>',__(array('<a href="http://www.wordpress.org">The official WordPress site</a>',false))),'</li>'));
echo AspisCheckPrint(concat2(concat1('<li>',__(array('<a href="http://wordpress.org/support/">The WordPress support forums</a>',false))),'</li>'));
echo AspisCheckPrint(concat2(concat1('<li>',__(array('<a href="http://codex.wordpress.org">The Codex (In other words, the WordPress Bible)</a>',false))),'</li>'));
echo AspisCheckPrint(array('</ul>',false));
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('That&#8217;s it! What are you waiting for? Go <a href="%1$s">log in</a>!',false)),array('../wp-login.php',false))),'</p>'));
} }
function db_form (  ) {
{echo AspisCheckPrint(array('<table class="form-table">',false));
printf(('<tr><th><label for="dbuser">%s</label></th><td><input type="text" name="dbuser" id="dbuser" /></td></tr>'),deAspisRC(__(array('DotClear Database User:',false))));
printf(('<tr><th><label for="dbpass">%s</label></th><td><input type="password" name="dbpass" id="dbpass" /></td></tr>'),deAspisRC(__(array('DotClear Database Password:',false))));
printf(('<tr><th><label for="dbname">%s</label></th><td><input type="text" name="dbname" id="dbname" /></td></tr>'),deAspisRC(__(array('DotClear Database Name:',false))));
printf(('<tr><th><label for="dbhost">%s</label></th><td><input type="text" name="dbhost" id="dbhost" value="localhost" /></td></tr>'),deAspisRC(__(array('DotClear Database Host:',false))));
printf(('<tr><th><label for="dbprefix">%s</label></th><td><input type="text" name="dbprefix" id="dbprefix" value="dc_"/></td></tr>'),deAspisRC(__(array('DotClear Table prefix:',false))));
printf(('<tr><th><label for="dccharset">%s</label></th><td><input type="text" name="dccharset" id="dccharset" value="ISO-8859-15"/></td></tr>'),deAspisRC(__(array('Originating character set:',false))));
echo AspisCheckPrint(array('</table>',false));
} }
function dispatch (  ) {
{if ( ((empty($_GET[0][('step')]) || Aspis_empty( $_GET [0][('step')]))))
 $step = array(0,false);
else 
{$step = int_cast($_GET[0]['step']);
}$this->header();
if ( ($step[0] > (0)))
 {check_admin_referer(array('import-dotclear',false));
if ( deAspis($_POST[0]['dbuser']))
 {if ( deAspis(get_option(array('dcuser',false))))
 delete_option(array('dcuser',false));
add_option(array('dcuser',false),sanitize_user($_POST[0]['dbuser'],array(true,false)));
}if ( deAspis($_POST[0]['dbpass']))
 {if ( deAspis(get_option(array('dcpass',false))))
 delete_option(array('dcpass',false));
add_option(array('dcpass',false),sanitize_user($_POST[0]['dbpass'],array(true,false)));
}if ( deAspis($_POST[0]['dbname']))
 {if ( deAspis(get_option(array('dcname',false))))
 delete_option(array('dcname',false));
add_option(array('dcname',false),sanitize_user($_POST[0]['dbname'],array(true,false)));
}if ( deAspis($_POST[0]['dbhost']))
 {if ( deAspis(get_option(array('dchost',false))))
 delete_option(array('dchost',false));
add_option(array('dchost',false),sanitize_user($_POST[0]['dbhost'],array(true,false)));
}if ( deAspis($_POST[0]['dccharset']))
 {if ( deAspis(get_option(array('dccharset',false))))
 delete_option(array('dccharset',false));
add_option(array('dccharset',false),sanitize_user($_POST[0]['dccharset'],array(true,false)));
}if ( deAspis($_POST[0]['dbprefix']))
 {if ( deAspis(get_option(array('dcdbprefix',false))))
 delete_option(array('dcdbprefix',false));
add_option(array('dcdbprefix',false),sanitize_user($_POST[0]['dbprefix'],array(true,false)));
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
case (6):$this->cleanup_dcimport();
break ;
 }
$this->footer();
} }
function Dotclear_Import (  ) {
{} }
}$dc_import = array(new Dotclear_Import(),false);
register_importer(array('dotclear',false),__(array('DotClear',false)),__(array('Import categories, users, posts, comments, and links from a DotClear blog.',false)),array(array($dc_import,array('dispatch',false)),false));
;
?>
<?php 