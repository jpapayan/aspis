<?php require_once('AspisMain.php'); ?><?php
if ( !function_exists('get_comment_count'))
 {function get_comment_count ( $post_ID ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}{$AspisRetTemp = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM $wpdb->comments WHERE comment_post_ID = %d",$post_ID));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
}if ( !function_exists('link_exists'))
 {function link_exists ( $linkname ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}{$AspisRetTemp = $wpdb->get_var($wpdb->prepare("SELECT link_id FROM $wpdb->links WHERE link_name = %s",$linkname));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
}function csc ( $s ) {
if ( seems_utf8($s))
 {{$AspisRetTemp = $s;
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = iconv(get_option("dccharset"),"UTF-8",$s);
return $AspisRetTemp;
}}} }
function textconv ( $s ) {
{$AspisRetTemp = csc(preg_replace('|(?<!<br />)\s*\n|',' ',$s));
return $AspisRetTemp;
} }
class Dotclear_Import{function header (  ) {
{echo '<div class="wrap">';
screen_icon();
echo '<h2>' . __('Import DotClear') . '</h2>';
echo '<p>' . __('Steps may take a few minutes depending on the size of your database. Please be patient.') . '</p>';
} }
function footer (  ) {
{echo '</div>';
} }
function greet (  ) {
{echo '<div class="narrow"><p>' . __('Howdy! This importer allows you to extract posts from a DotClear database into your blog.  Mileage may vary.') . '</p>';
echo '<p>' . __('Your DotClear Configuration settings are as follows:') . '</p>';
echo '<form action="admin.php?import=dotclear&amp;step=1" method="post">';
wp_nonce_field('import-dotclear');
$this->db_form();
echo '<p class="submit"><input type="submit" name="submit" class="button" value="' . esc_attr__('Import Categories') . '" /></p>';
echo '</form></div>';
} }
function get_dc_cats (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$dcdb = AspisNewKnownProxy(new wpdb( attAspisRCO(get_option( 'dcuser')),attAspisRCO(get_option( 'dcpass')),attAspisRCO(get_option( 'dcname')),attAspisRCO(get_option( 'dchost'))),false);
set_magic_quotes_runtime(0);
$dbprefix = get_option('dcdbprefix');
{$AspisRetTemp = $dcdb->get_results('SELECT * FROM ' . $dbprefix . 'categorie',ARRAY_A);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_dc_users (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$dcdb = AspisNewKnownProxy(new wpdb( attAspisRCO(get_option( 'dcuser')),attAspisRCO(get_option( 'dcpass')),attAspisRCO(get_option( 'dcname')),attAspisRCO(get_option( 'dchost'))),false);
set_magic_quotes_runtime(0);
$dbprefix = get_option('dcdbprefix');
{$AspisRetTemp = $dcdb->get_results('SELECT * FROM ' . $dbprefix . 'user',ARRAY_A);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_dc_posts (  ) {
{$dcdb = AspisNewKnownProxy(new wpdb( attAspisRCO(get_option( 'dcuser')),attAspisRCO(get_option( 'dcpass')),attAspisRCO(get_option( 'dcname')),attAspisRCO(get_option( 'dchost'))),false);
set_magic_quotes_runtime(0);
$dbprefix = get_option('dcdbprefix');
{$AspisRetTemp = $dcdb->get_results('SELECT ' . $dbprefix . 'post.*, ' . $dbprefix . 'categorie.cat_libelle_url AS post_cat_name
						FROM ' . $dbprefix . 'post INNER JOIN ' . $dbprefix . 'categorie
						ON ' . $dbprefix . 'post.cat_id = ' . $dbprefix . 'categorie.cat_id',ARRAY_A);
return $AspisRetTemp;
}} }
function get_dc_comments (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$dcdb = AspisNewKnownProxy(new wpdb( attAspisRCO(get_option( 'dcuser')),attAspisRCO(get_option( 'dcpass')),attAspisRCO(get_option( 'dcname')),attAspisRCO(get_option( 'dchost'))),false);
set_magic_quotes_runtime(0);
$dbprefix = get_option('dcdbprefix');
{$AspisRetTemp = $dcdb->get_results('SELECT * FROM ' . $dbprefix . 'comment',ARRAY_A);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function get_dc_links (  ) {
{$dcdb = AspisNewKnownProxy(new wpdb( attAspisRCO(get_option( 'dcuser')),attAspisRCO(get_option( 'dcpass')),attAspisRCO(get_option( 'dcname')),attAspisRCO(get_option( 'dchost'))),false);
set_magic_quotes_runtime(0);
$dbprefix = get_option('dcdbprefix');
{$AspisRetTemp = $dcdb->get_results('SELECT * FROM ' . $dbprefix . 'link ORDER BY position',ARRAY_A);
return $AspisRetTemp;
}} }
function cat2wp ( $categories = '' ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$count = 0;
$dccat2wpcat = array();
if ( is_array($categories))
 {echo '<p>' . __('Importing Categories...') . '<br /><br /></p>';
foreach ( $categories as $category  )
{$count++;
extract(($category));
$name = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($cat_libelle_url)),array(0));
$title = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(csc($cat_libelle))),array(0));
$desc = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(csc($cat_desc))),array(0));
if ( $cinfo = category_exists($name))
 {$ret_id = wp_insert_category(array('cat_ID' => $cinfo,'category_nicename' => $name,'cat_name' => $title,'category_description' => $desc));
}else 
{{$ret_id = wp_insert_category(array('category_nicename' => $name,'cat_name' => $title,'category_description' => $desc));
}}$dccat2wpcat[$id] = $ret_id;
}add_option('dccat2wpcat',$dccat2wpcat);
echo '<p>' . sprintf(_n('Done! <strong>%1$s</strong> category imported.','Done! <strong>%1$s</strong> categories imported.',$count),$count) . '<br /><br /></p>';
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}echo __('No Categories to Import!');
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function users2wp ( $users = '' ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$count = 0;
$dcid2wpid = array();
if ( is_array($users))
 {echo '<p>' . __('Importing Users...') . '<br /><br /></p>';
foreach ( $users as $user  )
{$count++;
extract(($user));
$name = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(csc($name))),array(0));
$RealName = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(csc($user_pseudo))),array(0));
if ( $uinfo = get_userdatabylogin($name))
 {$ret_id = wp_insert_user(array('ID' => $uinfo->ID,'user_login' => $user_id,'user_nicename' => $Realname,'user_email' => $user_email,'user_url' => 'http://','display_name' => $Realname));
}else 
{{$ret_id = wp_insert_user(array('user_login' => $user_id,'user_nicename' => csc($user_pseudo),'user_email' => $user_email,'user_url' => 'http://','display_name' => $Realname));
}}$dcid2wpid[$user_id] = $ret_id;
$user = new WP_User($ret_id);
$wp_perms = $user_level + 1;
if ( 10 == $wp_perms)
 {$user->set_role('administrator');
}else 
{if ( 9 == $wp_perms)
 {$user->set_role('editor');
}else 
{if ( 5 <= $wp_perms)
 {$user->set_role('editor');
}else 
{if ( 4 <= $wp_perms)
 {$user->set_role('author');
}else 
{if ( 3 <= $wp_perms)
 {$user->set_role('contributor');
}else 
{if ( 2 <= $wp_perms)
 {$user->set_role('contributor');
}else 
{{$user->set_role('subscriber');
}}}}}}}update_usermeta($ret_id,'wp_user_level',$wp_perms);
update_usermeta($ret_id,'rich_editing','false');
update_usermeta($ret_id,'first_name',csc($user_prenom));
update_usermeta($ret_id,'last_name',csc($user_nom));
}add_option('dcid2wpid',$dcid2wpid);
echo '<p>' . sprintf(__('Done! <strong>%1$s</strong> users imported.'),$count) . '<br /><br /></p>';
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}echo __('No Users to Import!');
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function posts2wp ( $posts = '' ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$count = 0;
$dcposts2wpposts = array();
$cats = array();
if ( is_array($posts))
 {echo '<p>' . __('Importing Posts...') . '<br /><br /></p>';
foreach ( $posts as $post  )
{$count++;
extract(($post));
$stattrans = array(0 => 'draft',1 => 'publish');
$comment_status_map = array(0 => 'closed',1 => 'open');
$uinfo = (get_userdatabylogin($user_id)) ? get_userdatabylogin($user_id) : 1;
$authorid = (is_object($uinfo)) ? $uinfo->ID : $uinfo;
$Title = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(csc($post_titre))),array(0));
$post_content = textconv($post_content);
$post_excerpt = "";
if ( $post_chapo != "")
 {$post_excerpt = textconv($post_chapo);
$post_content = $post_excerpt . "\n<!--more-->\n" . $post_content;
}$post_excerpt = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($post_excerpt)),array(0));
$post_content = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($post_content)),array(0));
$post_status = $stattrans[$post_pub];
if ( $pinfo = post_exists($Title,$post_content))
 {$ret_id = wp_insert_post(array('ID' => $pinfo,'post_author' => $authorid,'post_date' => $post_dt,'post_date_gmt' => $post_dt,'post_modified' => $post_upddt,'post_modified_gmt' => $post_upddt,'post_title' => $Title,'post_content' => $post_content,'post_excerpt' => $post_excerpt,'post_status' => $post_status,'post_name' => $post_titre_url,'comment_status' => $comment_status_map[$post_open_comment],'ping_status' => $comment_status_map[$post_open_tb],'comment_count' => $post_nb_comment + $post_nb_trackback));
if ( is_wp_error($ret_id))
 {$AspisRetTemp = $ret_id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{$ret_id = wp_insert_post(array('post_author' => $authorid,'post_date' => $post_dt,'post_date_gmt' => $post_dt,'post_modified' => $post_modified_gmt,'post_modified_gmt' => $post_modified_gmt,'post_title' => $Title,'post_content' => $post_content,'post_excerpt' => $post_excerpt,'post_status' => $post_status,'post_name' => $post_titre_url,'comment_status' => $comment_status_map[$post_open_comment],'ping_status' => $comment_status_map[$post_open_tb],'comment_count' => $post_nb_comment + $post_nb_trackback));
if ( is_wp_error($ret_id))
 {$AspisRetTemp = $ret_id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}}$dcposts2wpposts[$post_id] = $ret_id;
$cats = array();
$category1 = get_category_by_slug($post_cat_name);
$category1 = $category1->term_id;
if ( $cat1 = $category1)
 {$cats[1] = $cat1;
}if ( !empty($cats))
 {wp_set_post_categories($ret_id,$cats);
}}}add_option('dcposts2wpposts',$dcposts2wpposts);
echo '<p>' . sprintf(__('Done! <strong>%1$s</strong> posts imported.'),$count) . '<br /><br /></p>';
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function comments2wp ( $comments = '' ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$count = 0;
$dccm2wpcm = array();
$postarr = get_option('dcposts2wpposts');
if ( is_array($comments))
 {echo '<p>' . __('Importing Comments...') . '<br /><br /></p>';
foreach ( $comments as $comment  )
{$count++;
extract(($comment));
$comment_ID = (int)ltrim($comment_id,'0');
$comment_post_ID = (int)$postarr[$post_id];
$comment_approved = "$comment_pub";
$name = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(csc($comment_auteur))),array(0));
$email = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($comment_email)),array(0));
$web = "http://" . AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($comment_site)),array(0));
$message = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(textconv($comment_content))),array(0));
$comment = array('comment_post_ID' => $comment_post_ID,'comment_author' => $name,'comment_author_email' => $email,'comment_author_url' => $web,'comment_author_IP' => $comment_ip,'comment_date' => $comment_dt,'comment_date_gmt' => $comment_dt,'comment_content' => $message,'comment_approved' => $comment_approved);
$comment = wp_filter_comment($comment);
if ( $cinfo = comment_exists($name,$comment_dt))
 {$comment['comment_ID'] = $cinfo;
$ret_id = wp_update_comment($comment);
}else 
{{$ret_id = wp_insert_comment($comment);
}}$dccm2wpcm[$comment_ID] = $ret_id;
}add_option('dccm2wpcm',$dccm2wpcm);
get_comment_count($ret_id);
echo '<p>' . sprintf(__('Done! <strong>%1$s</strong> comments imported.'),$count) . '<br /><br /></p>';
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}echo __('No Comments to Import!');
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function links2wp ( $links = '' ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$count = 0;
if ( is_array($links))
 {echo '<p>' . __('Importing Links...') . '<br /><br /></p>';
foreach ( $links as $link  )
{$count++;
extract(($link));
if ( $title != "")
 {if ( $cinfo = is_term(csc($title),'link_category'))
 {$category = $cinfo['term_id'];
}else 
{{$category = wp_insert_term(AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(csc($title))),array(0)),'link_category');
$category = $category['term_id'];
}}}else 
{{$linkname = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(csc($label))),array(0));
$description = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(csc($title))),array(0));
if ( $linfo = link_exists($linkname))
 {$ret_id = wp_insert_link(array('link_id' => $linfo,'link_url' => $href,'link_name' => $linkname,'link_category' => $category,'link_description' => $description));
}else 
{{$ret_id = wp_insert_link(array('link_url' => $url,'link_name' => $linkname,'link_category' => $category,'link_description' => $description));
}}$dclinks2wplinks[$link_id] = $ret_id;
}}}add_option('dclinks2wplinks',$dclinks2wplinks);
echo '<p>';
printf(_n('Done! <strong>%s</strong> link or link category imported.','Done! <strong>%s</strong> links or link categories imported.',$count),$count);
echo '<br /><br /></p>';
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}echo __('No Links to Import!');
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function import_categories (  ) {
{$cats = $this->get_dc_cats();
$this->cat2wp($cats);
add_option('dc_cats',$cats);
echo '<form action="admin.php?import=dotclear&amp;step=2" method="post">';
wp_nonce_field('import-dotclear');
printf('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>',esc_attr__('Import Users'));
echo '</form>';
} }
function import_users (  ) {
{$users = $this->get_dc_users();
$this->users2wp($users);
echo '<form action="admin.php?import=dotclear&amp;step=3" method="post">';
wp_nonce_field('import-dotclear');
printf('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>',esc_attr__('Import Posts'));
echo '</form>';
} }
function import_posts (  ) {
{$posts = $this->get_dc_posts();
$result = $this->posts2wp($posts);
if ( is_wp_error($result))
 {$AspisRetTemp = $result;
return $AspisRetTemp;
}echo '<form action="admin.php?import=dotclear&amp;step=4" method="post">';
wp_nonce_field('import-dotclear');
printf('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>',esc_attr__('Import Comments'));
echo '</form>';
} }
function import_comments (  ) {
{$comments = $this->get_dc_comments();
$this->comments2wp($comments);
echo '<form action="admin.php?import=dotclear&amp;step=5" method="post">';
wp_nonce_field('import-dotclear');
printf('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>',esc_attr__('Import Links'));
echo '</form>';
} }
function import_links (  ) {
{$links = $this->get_dc_links();
$this->links2wp($links);
add_option('dc_links',$links);
echo '<form action="admin.php?import=dotclear&amp;step=6" method="post">';
wp_nonce_field('import-dotclear');
printf('<p class="submit"><input type="submit" name="submit" class="button" value="%s" /></p>',esc_attr__('Finish'));
echo '</form>';
} }
function cleanup_dcimport (  ) {
{delete_option('dcdbprefix');
delete_option('dc_cats');
delete_option('dcid2wpid');
delete_option('dccat2wpcat');
delete_option('dcposts2wpposts');
delete_option('dccm2wpcm');
delete_option('dclinks2wplinks');
delete_option('dcuser');
delete_option('dcpass');
delete_option('dcname');
delete_option('dchost');
delete_option('dccharset');
do_action('import_done','dotclear');
$this->tips();
} }
function tips (  ) {
{echo '<p>' . __('Welcome to WordPress.  We hope (and expect!) that you will find this platform incredibly rewarding!  As a new WordPress user coming from DotClear, there are some things that we would like to point out.  Hopefully, they will help your transition go as smoothly as possible.') . '</p>';
echo '<h3>' . __('Users') . '</h3>';
echo '<p>' . sprintf(__('You have already setup WordPress and have been assigned an administrative login and password.  Forget it.  You didn&#8217;t have that login in DotClear, why should you have it here?  Instead we have taken care to import all of your users into our system.  Unfortunately there is one downside.  Because both WordPress and DotClear uses a strong encryption hash with passwords, it is impossible to decrypt it and we are forced to assign temporary passwords to all your users.  <strong>Every user has the same username, but their passwords are reset to password123.</strong>  So <a href="%1$s">Log in</a> and change it.'),'/wp-login.php') . '</p>';
echo '<h3>' . __('Preserving Authors') . '</h3>';
echo '<p>' . __('Secondly, we have attempted to preserve post authors.  If you are the only author or contributor to your blog, then you are safe.  In most cases, we are successful in this preservation endeavor.  However, if we cannot ascertain the name of the writer due to discrepancies between database tables, we assign it to you, the administrative user.') . '</p>';
echo '<h3>' . __('Textile') . '</h3>';
echo '<p>' . __('Also, since you&#8217;re coming from DotClear, you probably have been using Textile to format your comments and posts.  If this is the case, we recommend downloading and installing <a href="http://www.huddledmasses.org/category/development/wordpress/textile/">Textile for WordPress</a>.  Trust me&#8230; You&#8217;ll want it.') . '</p>';
echo '<h3>' . __('WordPress Resources') . '</h3>';
echo '<p>' . __('Finally, there are numerous WordPress resources around the internet.  Some of them are:') . '</p>';
echo '<ul>';
echo '<li>' . __('<a href="http://www.wordpress.org">The official WordPress site</a>') . '</li>';
echo '<li>' . __('<a href="http://wordpress.org/support/">The WordPress support forums</a>') . '</li>';
echo '<li>' . __('<a href="http://codex.wordpress.org">The Codex (In other words, the WordPress Bible)</a>') . '</li>';
echo '</ul>';
echo '<p>' . sprintf(__('That&#8217;s it! What are you waiting for? Go <a href="%1$s">log in</a>!'),'../wp-login.php') . '</p>';
} }
function db_form (  ) {
{echo '<table class="form-table">';
printf('<tr><th><label for="dbuser">%s</label></th><td><input type="text" name="dbuser" id="dbuser" /></td></tr>',__('DotClear Database User:'));
printf('<tr><th><label for="dbpass">%s</label></th><td><input type="password" name="dbpass" id="dbpass" /></td></tr>',__('DotClear Database Password:'));
printf('<tr><th><label for="dbname">%s</label></th><td><input type="text" name="dbname" id="dbname" /></td></tr>',__('DotClear Database Name:'));
printf('<tr><th><label for="dbhost">%s</label></th><td><input type="text" name="dbhost" id="dbhost" value="localhost" /></td></tr>',__('DotClear Database Host:'));
printf('<tr><th><label for="dbprefix">%s</label></th><td><input type="text" name="dbprefix" id="dbprefix" value="dc_"/></td></tr>',__('DotClear Table prefix:'));
printf('<tr><th><label for="dccharset">%s</label></th><td><input type="text" name="dccharset" id="dccharset" value="ISO-8859-15"/></td></tr>',__('Originating character set:'));
echo '</table>';
} }
function dispatch (  ) {
{if ( (empty($_GET[0]['step']) || Aspis_empty($_GET[0]['step'])))
 $step = 0;
else 
{$step = (int)deAspisWarningRC($_GET[0]['step']);
}$this->header();
if ( $step > 0)
 {check_admin_referer('import-dotclear');
if ( deAspisWarningRC($_POST[0]['dbuser']))
 {if ( get_option('dcuser'))
 delete_option('dcuser');
add_option('dcuser',sanitize_user(deAspisWarningRC($_POST[0]['dbuser']),true));
}if ( deAspisWarningRC($_POST[0]['dbpass']))
 {if ( get_option('dcpass'))
 delete_option('dcpass');
add_option('dcpass',sanitize_user(deAspisWarningRC($_POST[0]['dbpass']),true));
}if ( deAspisWarningRC($_POST[0]['dbname']))
 {if ( get_option('dcname'))
 delete_option('dcname');
add_option('dcname',sanitize_user(deAspisWarningRC($_POST[0]['dbname']),true));
}if ( deAspisWarningRC($_POST[0]['dbhost']))
 {if ( get_option('dchost'))
 delete_option('dchost');
add_option('dchost',sanitize_user(deAspisWarningRC($_POST[0]['dbhost']),true));
}if ( deAspisWarningRC($_POST[0]['dccharset']))
 {if ( get_option('dccharset'))
 delete_option('dccharset');
add_option('dccharset',sanitize_user(deAspisWarningRC($_POST[0]['dccharset']),true));
}if ( deAspisWarningRC($_POST[0]['dbprefix']))
 {if ( get_option('dcdbprefix'))
 delete_option('dcdbprefix');
add_option('dcdbprefix',sanitize_user(deAspisWarningRC($_POST[0]['dbprefix']),true));
}}switch ( $step ) {
default :case 0:$this->greet();
break ;
case 1:$this->import_categories();
break ;
case 2:$this->import_users();
break ;
case 3:$result = $this->import_posts();
if ( is_wp_error($result))
 echo $result->get_error_message();
break ;
case 4:$this->import_comments();
break ;
case 5:$this->import_links();
break ;
case 6:$this->cleanup_dcimport();
break ;
 }
$this->footer();
} }
function Dotclear_Import (  ) {
{} }
}$dc_import = new Dotclear_Import();
register_importer('dotclear',__('DotClear'),__('Import categories, users, posts, comments, and links from a DotClear blog.'),array($dc_import,'dispatch'));
;
?>
<?php 