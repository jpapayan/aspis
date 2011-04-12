<?php require_once('AspisMain.php'); ?><?php
if ( file_exists((deconcat12(WP_CONTENT_DIR,'/install.php'))))
 require (deconcat12(WP_CONTENT_DIR,'/install.php'));
require_once (deconcat12(ABSPATH,'wp-admin/includes/admin.php'));
require_once (deconcat12(ABSPATH,'wp-admin/includes/schema.php'));
if ( (!(function_exists(('wp_install')))))
 {function wp_install ( $blog_title,$user_name,$user_email,$public,$deprecated = array('',false) ) {
global $wp_rewrite;
wp_check_mysql_version();
wp_cache_flush();
make_db_current_silent();
populate_options();
populate_roles();
update_option(array('blogname',false),$blog_title);
update_option(array('admin_email',false),$user_email);
update_option(array('blog_public',false),$public);
$guessurl = wp_guess_url();
update_option(array('siteurl',false),$guessurl);
if ( (denot_boolean($public)))
 update_option(array('default_pingback_flag',false),array(0,false));
$user_id = username_exists($user_name);
if ( (denot_boolean($user_id)))
 {$random_password = wp_generate_password();
$message = __(array('<strong><em>Note that password</em></strong> carefully! It is a <em>random</em> password that was generated just for you.',false));
$user_id = wp_create_user($user_name,$random_password,$user_email);
update_usermeta($user_id,array('default_password_nag',false),array(true,false));
}else 
{{$random_password = array('',false);
$message = __(array('User already exists.  Password inherited.',false));
}}$user = array(new WP_User($user_id),false);
$user[0]->set_role(array('administrator',false));
wp_install_defaults($user_id);
$wp_rewrite[0]->flush_rules();
wp_new_blog_notification($blog_title,$guessurl,$user_id,$random_password);
wp_cache_flush();
return array(array(deregisterTaint(array('url',false)) => addTaint($guessurl),deregisterTaint(array('user_id',false)) => addTaint($user_id),deregisterTaint(array('password',false)) => addTaint($random_password),deregisterTaint(array('password_message',false)) => addTaint($message)),false);
 }
}if ( (!(function_exists(('wp_install_defaults')))))
 {function wp_install_defaults ( $user_id ) {
global $wpdb;
$cat_name = __(array('Uncategorized',false));
$cat_slug = sanitize_title(_x(array('Uncategorized',false),array('Default category slug',false)));
$wpdb[0]->insert($wpdb[0]->terms,array(array(deregisterTaint(array('name',false)) => addTaint($cat_name),deregisterTaint(array('slug',false)) => addTaint($cat_slug),'term_group' => array(0,false,false)),false));
$wpdb[0]->insert($wpdb[0]->term_taxonomy,array(array('term_id' => array('1',false,false),'taxonomy' => array('category',false,false),'description' => array('',false,false),'parent' => array(0,false,false),'count' => array(1,false,false)),false));
$cat_name = __(array('Blogroll',false));
$cat_slug = sanitize_title(_x(array('Blogroll',false),array('Default link category slug',false)));
$wpdb[0]->insert($wpdb[0]->terms,array(array(deregisterTaint(array('name',false)) => addTaint($cat_name),deregisterTaint(array('slug',false)) => addTaint($cat_slug),'term_group' => array(0,false,false)),false));
$wpdb[0]->insert($wpdb[0]->term_taxonomy,array(array('term_id' => array('2',false,false),'taxonomy' => array('link_category',false,false),'description' => array('',false,false),'parent' => array(0,false,false),'count' => array(7,false,false)),false));
$default_links = array(array(),false);
arrayAssignAdd($default_links[0][],addTaint(array(array('link_url' => array('http://codex.wordpress.org/',false,false),'link_name' => array('Documentation',false,false),'link_rss' => array('',false,false),'link_notes' => array('',false,false)),false)));
arrayAssignAdd($default_links[0][],addTaint(array(array('link_url' => array('http://wordpress.org/development/',false,false),'link_name' => array('Development Blog',false,false),'link_rss' => array('http://wordpress.org/development/feed/',false,false),'link_notes' => array('',false,false)),false)));
arrayAssignAdd($default_links[0][],addTaint(array(array('link_url' => array('http://wordpress.org/extend/ideas/',false,false),'link_name' => array('Suggest Ideas',false,false),'link_rss' => array('',false,false),'link_notes' => array('',false,false)),false)));
arrayAssignAdd($default_links[0][],addTaint(array(array('link_url' => array('http://wordpress.org/support/',false,false),'link_name' => array('Support Forum',false,false),'link_rss' => array('',false,false),'link_notes' => array('',false,false)),false)));
arrayAssignAdd($default_links[0][],addTaint(array(array('link_url' => array('http://wordpress.org/extend/plugins/',false,false),'link_name' => array('Plugins',false,false),'link_rss' => array('',false,false),'link_notes' => array('',false,false)),false)));
arrayAssignAdd($default_links[0][],addTaint(array(array('link_url' => array('http://wordpress.org/extend/themes/',false,false),'link_name' => array('Themes',false,false),'link_rss' => array('',false,false),'link_notes' => array('',false,false)),false)));
arrayAssignAdd($default_links[0][],addTaint(array(array('link_url' => array('http://planet.wordpress.org/',false,false),'link_name' => array('WordPress Planet',false,false),'link_rss' => array('',false,false),'link_notes' => array('',false,false)),false)));
foreach ( $default_links[0] as $link  )
{$wpdb[0]->insert($wpdb[0]->links,$link);
$wpdb[0]->insert($wpdb[0]->term_relationships,array(array('term_taxonomy_id' => array(2,false,false),deregisterTaint(array('object_id',false)) => addTaint($wpdb[0]->insert_id)),false));
}$now = attAspis(date(('Y-m-d H:i:s')));
$now_gmt = attAspis(gmdate(('Y-m-d H:i:s')));
$first_post_guid = concat2(get_option(array('home',false)),'/?p=1');
$wpdb[0]->insert($wpdb[0]->posts,array(array(deregisterTaint(array('post_author',false)) => addTaint($user_id),deregisterTaint(array('post_date',false)) => addTaint($now),deregisterTaint(array('post_date_gmt',false)) => addTaint($now_gmt),deregisterTaint(array('post_content',false)) => addTaint(__(array('Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!',false))),'post_excerpt' => array('',false,false),deregisterTaint(array('post_title',false)) => addTaint(__(array('Hello world!',false))),deregisterTaint(array('post_name',false)) => addTaint(_x(array('hello-world',false),array('Default post slug',false))),deregisterTaint(array('post_modified',false)) => addTaint($now),deregisterTaint(array('post_modified_gmt',false)) => addTaint($now_gmt),deregisterTaint(array('guid',false)) => addTaint($first_post_guid),'comment_count' => array(1,false,false),'to_ping' => array('',false,false),'pinged' => array('',false,false),'post_content_filtered' => array('',false,false)),false));
$wpdb[0]->insert($wpdb[0]->term_relationships,array(array('term_taxonomy_id' => array(1,false,false),'object_id' => array(1,false,false)),false));
$wpdb[0]->insert($wpdb[0]->comments,array(array('comment_post_ID' => array(1,false,false),deregisterTaint(array('comment_author',false)) => addTaint(__(array('Mr WordPress',false))),'comment_author_email' => array('',false,false),'comment_author_url' => array('http://wordpress.org/',false,false),deregisterTaint(array('comment_date',false)) => addTaint($now),deregisterTaint(array('comment_date_gmt',false)) => addTaint($now_gmt),deregisterTaint(array('comment_content',false)) => addTaint(__(array('Hi, this is a comment.<br />To delete a comment, just log in and view the post&#039;s comments. There you will have the option to edit or delete them.',false)))),false));
$first_post_guid = concat2(get_option(array('home',false)),'/?page_id=2');
$wpdb[0]->insert($wpdb[0]->posts,array(array(deregisterTaint(array('post_author',false)) => addTaint($user_id),deregisterTaint(array('post_date',false)) => addTaint($now),deregisterTaint(array('post_date_gmt',false)) => addTaint($now_gmt),deregisterTaint(array('post_content',false)) => addTaint(__(array('This is an example of a WordPress page, you could edit this to put information about yourself or your site so readers know where you are coming from. You can create as many pages like this one or sub-pages as you like and manage all of your content inside of WordPress.',false))),'post_excerpt' => array('',false,false),deregisterTaint(array('post_title',false)) => addTaint(__(array('About',false))),deregisterTaint(array('post_name',false)) => addTaint(_x(array('about',false),array('Default page slug',false))),deregisterTaint(array('post_modified',false)) => addTaint($now),deregisterTaint(array('post_modified_gmt',false)) => addTaint($now_gmt),deregisterTaint(array('guid',false)) => addTaint($first_post_guid),'post_type' => array('page',false,false),'to_ping' => array('',false,false),'pinged' => array('',false,false),'post_content_filtered' => array('',false,false)),false));
 }
}if ( (!(function_exists(('wp_new_blog_notification')))))
 {function wp_new_blog_notification ( $blog_title,$blog_url,$user_id,$password ) {
$user = array(new WP_User($user_id),false);
$email = $user[0]->user_email;
$name = $user[0]->user_login;
$message = Aspis_sprintf(__(array("Your new WordPress blog has been successfully set up at:

%1\$s

You can log in to the administrator account with the following information:

Username: %2\$s
Password: %3\$s

We hope you enjoy your new blog. Thanks!

--The WordPress Team
http://wordpress.org/
",false)),$blog_url,$name,$password);
@wp_mail($email,__(array('New WordPress Blog',false)),$message);
 }
}if ( (!(function_exists(('wp_upgrade')))))
 {function wp_upgrade (  ) {
global $wp_current_db_version,$wp_db_version;
$wp_current_db_version = __get_option(array('db_version',false));
if ( ($wp_db_version[0] == $wp_current_db_version[0]))
 return ;
if ( (denot_boolean(is_blog_installed())))
 return ;
wp_check_mysql_version();
wp_cache_flush();
pre_schema_upgrade();
make_db_current_silent();
upgrade_all();
wp_cache_flush();
 }
}function upgrade_all (  ) {
global $wp_current_db_version,$wp_db_version,$wp_rewrite;
$wp_current_db_version = __get_option(array('db_version',false));
if ( ($wp_db_version[0] == $wp_current_db_version[0]))
 return ;
if ( ((empty($wp_current_db_version) || Aspis_empty( $wp_current_db_version))))
 {$wp_current_db_version = array(0,false);
$template = __get_option(array('template',false));
if ( (!((empty($template) || Aspis_empty( $template)))))
 $wp_current_db_version = array(2541,false);
}if ( ($wp_current_db_version[0] < (6039)))
 upgrade_230_options_table();
populate_options();
if ( ($wp_current_db_version[0] < (2541)))
 {upgrade_100();
upgrade_101();
upgrade_110();
upgrade_130();
}if ( ($wp_current_db_version[0] < (3308)))
 upgrade_160();
if ( ($wp_current_db_version[0] < (4772)))
 upgrade_210();
if ( ($wp_current_db_version[0] < (4351)))
 upgrade_old_slugs();
if ( ($wp_current_db_version[0] < (5539)))
 upgrade_230();
if ( ($wp_current_db_version[0] < (6124)))
 upgrade_230_old_tables();
if ( ($wp_current_db_version[0] < (7499)))
 upgrade_250();
if ( ($wp_current_db_version[0] < (7796)))
 upgrade_251();
if ( ($wp_current_db_version[0] < (7935)))
 upgrade_252();
if ( ($wp_current_db_version[0] < (8201)))
 upgrade_260();
if ( ($wp_current_db_version[0] < (8989)))
 upgrade_270();
if ( ($wp_current_db_version[0] < (10360)))
 upgrade_280();
if ( ($wp_current_db_version[0] < (11958)))
 upgrade_290();
maybe_disable_automattic_widgets();
update_option(array('db_version',false),$wp_db_version);
update_option(array('db_upgraded',false),array(true,false));
 }
function upgrade_100 (  ) {
global $wpdb;
$posts = $wpdb[0]->get_results(concat2(concat1("SELECT ID, post_title, post_name FROM ",$wpdb[0]->posts)," WHERE post_name = ''"));
if ( $posts[0])
 {foreach ( $posts[0] as $post  )
{if ( (('') == $post[0]->post_name[0]))
 {$newtitle = sanitize_title($post[0]->post_title);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_name = %s WHERE ID = %d"),$newtitle,$post[0]->ID));
}}}$categories = $wpdb[0]->get_results(concat1("SELECT cat_ID, cat_name, category_nicename FROM ",$wpdb[0]->categories));
foreach ( $categories[0] as $category  )
{if ( (('') == $category[0]->category_nicename[0]))
 {$newtitle = sanitize_title($category[0]->cat_name);
$wpdb[0] > deAspis(update($wpdb[0]->categories,array(array(deregisterTaint(array('category_nicename',false)) => addTaint($newtitle)),false),array(array(deregisterTaint(array('cat_ID',false)) => addTaint($category[0]->cat_ID)),false)));
}}$wpdb[0]->query(concat2(concat1("UPDATE ",$wpdb[0]->options)," SET option_value = REPLACE(option_value, 'wp-links/links-images/', 'wp-images/links/')
	WHERE option_name LIKE 'links_rating_image%'
	AND option_value LIKE 'wp-links/links-images/%'"));
$done_ids = $wpdb[0]->get_results(concat1("SELECT DISTINCT post_id FROM ",$wpdb[0]->post2cat));
if ( $done_ids[0])
 {foreach ( $done_ids[0] as $done_id  )
{arrayAssignAdd($done_posts[0][],addTaint($done_id[0]->post_id));
}$catwhere = concat2(concat1(' AND ID NOT IN (',Aspis_implode(array(',',false),$done_posts)),')');
}else 
{$catwhere = array('',false);
}$allposts = $wpdb[0]->get_results(concat(concat2(concat1("SELECT ID, post_category FROM ",$wpdb[0]->posts)," WHERE post_category != '0' "),$catwhere));
if ( $allposts[0])
 {foreach ( $allposts[0] as $post  )
{$cat = $wpdb[0]->get_row($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->post2cat)," WHERE post_id = %d AND category_id = %d"),$post[0]->ID,$post[0]->post_category));
if ( ((denot_boolean($cat)) && ((0) != $post[0]->post_category[0])))
 {$wpdb[0]->insert($wpdb[0]->post2cat,array(array(deregisterTaint(array('post_id',false)) => addTaint($post[0]->ID),deregisterTaint(array('category_id',false)) => addTaint($post[0]->post_category)),false));
}}} }
function upgrade_101 (  ) {
global $wpdb;
add_clean_index($wpdb[0]->posts,array('post_name',false));
add_clean_index($wpdb[0]->posts,array('post_status',false));
add_clean_index($wpdb[0]->categories,array('category_nicename',false));
add_clean_index($wpdb[0]->comments,array('comment_approved',false));
add_clean_index($wpdb[0]->comments,array('comment_post_ID',false));
add_clean_index($wpdb[0]->links,array('link_category',false));
add_clean_index($wpdb[0]->links,array('link_visible',false));
 }
function upgrade_110 (  ) {
global $wpdb;
$users = $wpdb[0]->get_results(concat1("SELECT ID, user_nickname, user_nicename FROM ",$wpdb[0]->users));
foreach ( $users[0] as $user  )
{if ( (('') == $user[0]->user_nicename[0]))
 {$newname = sanitize_title($user[0]->user_nickname);
$wpdb[0]->update($wpdb[0]->users,array(array(deregisterTaint(array('user_nicename',false)) => addTaint($newname)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($user[0]->ID)),false));
}}$users = $wpdb[0]->get_results(concat1("SELECT ID, user_pass from ",$wpdb[0]->users));
foreach ( $users[0] as $row  )
{if ( (denot_boolean(Aspis_preg_match(array('/^[A-Fa-f0-9]{32}$/',false),$row[0]->user_pass))))
 {$wpdb[0]->update($wpdb[0]->users,array(array(deregisterTaint(array('user_pass',false)) => addTaint(attAspis(md5($row[0]->user_pass[0])))),false),array(array(deregisterTaint(array('ID',false)) => addTaint($row[0]->ID)),false));
}}$all_options = get_alloptions_110();
$time_difference = $all_options[0]->time_difference;
$server_time = array(time() + date(('Z')),false);
$weblogger_time = array($server_time[0] + ($time_difference[0] * (3600)),false);
$gmt_time = attAspis(time());
$diff_gmt_server = array(($gmt_time[0] - $server_time[0]) / (3600),false);
$diff_weblogger_server = array(($weblogger_time[0] - $server_time[0]) / (3600),false);
$diff_gmt_weblogger = array($diff_gmt_server[0] - $diff_weblogger_server[0],false);
$gmt_offset = negate($diff_gmt_weblogger);
add_option(array('gmt_offset',false),$gmt_offset);
$got_gmt_fields = (deAspis($wpdb[0]->get_var(concat1("SELECT MAX(post_date_gmt) FROM ",$wpdb[0]->posts))) == ('0000-00-00 00:00:00')) ? array(false,false) : array(true,false);
if ( (denot_boolean($got_gmt_fields)))
 {$add_hours = Aspis_intval($diff_gmt_weblogger);
$add_minutes = Aspis_intval(array((60) * ($diff_gmt_weblogger[0] - $add_hours[0]),false));
$wpdb[0]->query(concat2(concat(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_date_gmt = DATE_ADD(post_date, INTERVAL '"),$add_hours),":"),$add_minutes),"' HOUR_MINUTE)"));
$wpdb[0]->query(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_modified = post_date"));
$wpdb[0]->query(concat2(concat(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_modified_gmt = DATE_ADD(post_modified, INTERVAL '"),$add_hours),":"),$add_minutes),"' HOUR_MINUTE) WHERE post_modified != '0000-00-00 00:00:00'"));
$wpdb[0]->query(concat2(concat(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->comments)," SET comment_date_gmt = DATE_ADD(comment_date, INTERVAL '"),$add_hours),":"),$add_minutes),"' HOUR_MINUTE)"));
$wpdb[0]->query(concat2(concat(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->users)," SET user_registered = DATE_ADD(user_registered, INTERVAL '"),$add_hours),":"),$add_minutes),"' HOUR_MINUTE)"));
} }
function upgrade_130 (  ) {
global $wpdb;
$posts = $wpdb[0]->get_results(concat1("SELECT ID, post_title, post_content, post_excerpt, guid, post_date, post_name, post_status, post_author FROM ",$wpdb[0]->posts));
if ( $posts[0])
 {foreach ( $posts[0] as $post  )
{$post_content = Aspis_addslashes(deslash($post[0]->post_content));
$post_title = Aspis_addslashes(deslash($post[0]->post_title));
$post_excerpt = Aspis_addslashes(deslash($post[0]->post_excerpt));
if ( ((empty($post[0]->guid) || Aspis_empty( $post[0] ->guid ))))
 $guid = get_permalink($post[0]->ID);
else 
{$guid = $post[0]->guid;
}$wpdb[0]->update($wpdb[0]->posts,array(compact('post_title','post_content','post_excerpt','guid'),false),array(array(deregisterTaint(array('ID',false)) => addTaint($post[0]->ID)),false));
}}$comments = $wpdb[0]->get_results(concat1("SELECT comment_ID, comment_author, comment_content FROM ",$wpdb[0]->comments));
if ( $comments[0])
 {foreach ( $comments[0] as $comment  )
{$comment_content = deslash($comment[0]->comment_content);
$comment_author = deslash($comment[0]->comment_author);
$wpdb[0]->update($wpdb[0]->comments,array(compact('comment_content','comment_author'),false),array(array(deregisterTaint(array('comment_ID',false)) => addTaint($comment[0]->comment_ID)),false));
}}$links = $wpdb[0]->get_results(concat1("SELECT link_id, link_name, link_description FROM ",$wpdb[0]->links));
if ( $links[0])
 {foreach ( $links[0] as $link  )
{$link_name = deslash($link[0]->link_name);
$link_description = deslash($link[0]->link_description);
$wpdb[0]->update($wpdb[0]->links,array(compact('link_name','link_description'),false),array(array(deregisterTaint(array('link_id',false)) => addTaint($link[0]->link_id)),false));
}}$active_plugins = __get_option(array('active_plugins',false));
if ( (!(is_array($active_plugins[0]))))
 {$active_plugins = Aspis_explode(array("\n",false),Aspis_trim($active_plugins));
update_option(array('active_plugins',false),$active_plugins);
}$wpdb[0]->query(concat2(concat1('DROP TABLE IF EXISTS ',$wpdb[0]->prefix),'optionvalues'));
$wpdb[0]->query(concat2(concat1('DROP TABLE IF EXISTS ',$wpdb[0]->prefix),'optiontypes'));
$wpdb[0]->query(concat2(concat1('DROP TABLE IF EXISTS ',$wpdb[0]->prefix),'optiongroups'));
$wpdb[0]->query(concat2(concat1('DROP TABLE IF EXISTS ',$wpdb[0]->prefix),'optiongroup_options'));
$wpdb[0]->query(concat2(concat1("UPDATE ",$wpdb[0]->comments)," SET comment_type='trackback', comment_content = REPLACE(comment_content, '<trackback />', '') WHERE comment_content LIKE '<trackback />%'"));
$wpdb[0]->query(concat2(concat1("UPDATE ",$wpdb[0]->comments)," SET comment_type='pingback', comment_content = REPLACE(comment_content, '<pingback />', '') WHERE comment_content LIKE '<pingback />%'"));
$options = $wpdb[0]->get_results(concat2(concat1("SELECT option_name, COUNT(option_name) AS dupes FROM `",$wpdb[0]->options),"` GROUP BY option_name"));
foreach ( $options[0] as $option  )
{if ( ((1) != $option[0]->dupes[0]))
 {$limit = array($option[0]->dupes[0] - (1),false);
$dupe_ids = $wpdb[0]->get_col($wpdb[0]->prepare(concat2(concat1("SELECT option_id FROM ",$wpdb[0]->options)," WHERE option_name = %s LIMIT %d"),$option[0]->option_name,$limit));
if ( $dupe_ids[0])
 {$dupe_ids = Aspis_join($dupe_ids,array(',',false));
$wpdb[0]->query(concat2(concat(concat2(concat1("DELETE FROM ",$wpdb[0]->options)," WHERE option_id IN ("),$dupe_ids),")"));
}}}make_site_theme();
 }
function upgrade_160 (  ) {
global $wpdb,$wp_current_db_version;
populate_roles_160();
$users = $wpdb[0]->get_results(concat1("SELECT * FROM ",$wpdb[0]->users));
foreach ( $users[0] as $user  )
{if ( (!((empty($user[0]->user_firstname) || Aspis_empty( $user[0] ->user_firstname )))))
 update_usermeta($user[0]->ID,array('first_name',false),$wpdb[0]->escape($user[0]->user_firstname));
if ( (!((empty($user[0]->user_lastname) || Aspis_empty( $user[0] ->user_lastname )))))
 update_usermeta($user[0]->ID,array('last_name',false),$wpdb[0]->escape($user[0]->user_lastname));
if ( (!((empty($user[0]->user_nickname) || Aspis_empty( $user[0] ->user_nickname )))))
 update_usermeta($user[0]->ID,array('nickname',false),$wpdb[0]->escape($user[0]->user_nickname));
if ( (!((empty($user[0]->user_level) || Aspis_empty( $user[0] ->user_level )))))
 update_usermeta($user[0]->ID,concat2($wpdb[0]->prefix,'user_level'),$user[0]->user_level);
if ( (!((empty($user[0]->user_icq) || Aspis_empty( $user[0] ->user_icq )))))
 update_usermeta($user[0]->ID,array('icq',false),$wpdb[0]->escape($user[0]->user_icq));
if ( (!((empty($user[0]->user_aim) || Aspis_empty( $user[0] ->user_aim )))))
 update_usermeta($user[0]->ID,array('aim',false),$wpdb[0]->escape($user[0]->user_aim));
if ( (!((empty($user[0]->user_msn) || Aspis_empty( $user[0] ->user_msn )))))
 update_usermeta($user[0]->ID,array('msn',false),$wpdb[0]->escape($user[0]->user_msn));
if ( (!((empty($user[0]->user_yim) || Aspis_empty( $user[0] ->user_yim )))))
 update_usermeta($user[0]->ID,array('yim',false),$wpdb[0]->escape($user[0]->user_icq));
if ( (!((empty($user[0]->user_description) || Aspis_empty( $user[0] ->user_description )))))
 update_usermeta($user[0]->ID,array('description',false),$wpdb[0]->escape($user[0]->user_description));
if ( ((isset($user[0]->user_idmode) && Aspis_isset( $user[0] ->user_idmode ))))
 {$idmode = $user[0]->user_idmode;
if ( ($idmode[0] == ('nickname')))
 $id = $user[0]->user_nickname;
if ( ($idmode[0] == ('login')))
 $id = $user[0]->user_login;
if ( ($idmode[0] == ('firstname')))
 $id = $user[0]->user_firstname;
if ( ($idmode[0] == ('lastname')))
 $id = $user[0]->user_lastname;
if ( ($idmode[0] == ('namefl')))
 $id = concat(concat2($user[0]->user_firstname,' '),$user[0]->user_lastname);
if ( ($idmode[0] == ('namelf')))
 $id = concat(concat2($user[0]->user_lastname,' '),$user[0]->user_firstname);
if ( (denot_boolean($idmode)))
 $id = $user[0]->user_nickname;
$wpdb[0]->update($wpdb[0]->users,array(array(deregisterTaint(array('display_name',false)) => addTaint($id)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($user[0]->ID)),false));
}$caps = get_usermeta($user[0]->ID,concat2($wpdb[0]->prefix,'capabilities'));
if ( (((empty($caps) || Aspis_empty( $caps))) || defined(('RESET_CAPS'))))
 {$level = get_usermeta($user[0]->ID,concat2($wpdb[0]->prefix,'user_level'));
$role = translate_level_to_role($level);
update_usermeta($user[0]->ID,concat2($wpdb[0]->prefix,'capabilities'),array(array(deregisterTaint($role) => addTaint(array(true,false))),false));
}}$old_user_fields = array(array(array('user_firstname',false),array('user_lastname',false),array('user_icq',false),array('user_aim',false),array('user_msn',false),array('user_yim',false),array('user_idmode',false),array('user_ip',false),array('user_domain',false),array('user_browser',false),array('user_description',false),array('user_nickname',false),array('user_level',false)),false);
$wpdb[0]->hide_errors();
foreach ( $old_user_fields[0] as $old  )
$wpdb[0]->query(concat(concat2(concat1("ALTER TABLE ",$wpdb[0]->users)," DROP "),$old));
$wpdb[0]->show_errors();
$comments = $wpdb[0]->get_results(concat2(concat1("SELECT comment_post_ID, COUNT(*) as c FROM ",$wpdb[0]->comments)," WHERE comment_approved = '1' GROUP BY comment_post_ID"));
if ( is_array($comments[0]))
 foreach ( $comments[0] as $comment  )
$wpdb[0]->update($wpdb[0]->posts,array(array(deregisterTaint(array('comment_count',false)) => addTaint($comment[0]->c)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($comment[0]->comment_post_ID)),false));
if ( (($wp_current_db_version[0] > (2541)) && ($wp_current_db_version[0] <= (3091))))
 {$objects = $wpdb[0]->get_results(concat2(concat1("SELECT ID, post_type FROM ",$wpdb[0]->posts)," WHERE post_status = 'object'"));
foreach ( $objects[0] as $object  )
{$wpdb[0]->update($wpdb[0]->posts,array(array('post_status' => array('attachment',false,false),deregisterTaint(array('post_mime_type',false)) => addTaint($object[0]->post_type),'post_type' => array('',false,false)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($object[0]->ID)),false));
$meta = get_post_meta($object[0]->ID,array('imagedata',false),array(true,false));
if ( (!((empty($meta[0][('file')]) || Aspis_empty( $meta [0][('file')])))))
 update_attached_file($object[0]->ID,$meta[0]['file']);
}} }
function upgrade_210 (  ) {
global $wpdb,$wp_current_db_version;
if ( ($wp_current_db_version[0] < (3506)))
 {$posts = $wpdb[0]->get_results(concat1("SELECT ID, post_status FROM ",$wpdb[0]->posts));
if ( (!((empty($posts) || Aspis_empty( $posts)))))
 foreach ( $posts[0] as $post  )
{$status = $post[0]->post_status;
$type = array('post',false);
if ( (('static') == $status[0]))
 {$status = array('publish',false);
$type = array('page',false);
}else 
{if ( (('attachment') == $status[0]))
 {$status = array('inherit',false);
$type = array('attachment',false);
}}$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_status = %s, post_type = %s WHERE ID = %d"),$status,$type,$post[0]->ID));
}}if ( ($wp_current_db_version[0] < (3845)))
 {populate_roles_210();
}if ( ($wp_current_db_version[0] < (3531)))
 {$now = attAspis(gmdate(('Y-m-d H:i:59')));
$wpdb[0]->query(concat2(concat(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_status = 'future' WHERE post_status = 'publish' AND post_date_gmt > '"),$now),"'"));
$posts = $wpdb[0]->get_results(concat2(concat1("SELECT ID, post_date FROM ",$wpdb[0]->posts)," WHERE post_status ='future'"));
if ( (!((empty($posts) || Aspis_empty( $posts)))))
 foreach ( $posts[0] as $post  )
wp_schedule_single_event(mysql2date(array('U',false),$post[0]->post_date,array(false,false)),array('publish_future_post',false),array(array($post[0]->ID),false));
} }
function upgrade_230 (  ) {
global $wp_current_db_version,$wpdb;
if ( ($wp_current_db_version[0] < (5200)))
 {populate_roles_230();
}$tt_ids = array(array(),false);
$have_tags = array(false,false);
$categories = $wpdb[0]->get_results(concat2(concat1("SELECT * FROM ",$wpdb[0]->categories)," ORDER BY cat_ID"));
foreach ( $categories[0] as $category  )
{$term_id = int_cast($category[0]->cat_ID);
$name = $category[0]->cat_name;
$description = $category[0]->category_description;
$slug = $category[0]->category_nicename;
$parent = $category[0]->category_parent;
$term_group = array(0,false);
if ( deAspis($exists = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT term_id, term_group FROM ",$wpdb[0]->terms)," WHERE slug = %s"),$slug))))
 {$term_group = $exists[0][(0)][0]->term_group;
$id = $exists[0][(0)][0]->term_id;
$num = array(2,false);
do {$alt_slug = concat($slug,concat1("-",$num));
postincr($num);
$slug_check = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT slug FROM ",$wpdb[0]->terms)," WHERE slug = %s"),$alt_slug));
}while ($slug_check[0] )
;
$slug = $alt_slug;
if ( ((empty($term_group) || Aspis_empty( $term_group))))
 {$term_group = array(deAspis($wpdb[0]->get_var(concat2(concat1("SELECT MAX(term_group) FROM ",$wpdb[0]->terms)," GROUP BY term_group"))) + (1),false);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->terms)," SET term_group = %d WHERE term_id = %d"),$term_group,$id));
}}$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("INSERT INTO ",$wpdb[0]->terms)," (term_id, name, slug, term_group) VALUES
		(%d, %s, %s, %d)"),$term_id,$name,$slug,$term_group));
$count = array(0,false);
if ( (!((empty($category[0]->category_count) || Aspis_empty( $category[0] ->category_count )))))
 {$count = int_cast($category[0]->category_count);
$taxonomy = array('category',false);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("INSERT INTO ",$wpdb[0]->term_taxonomy)," (term_id, taxonomy, description, parent, count) VALUES ( %d, %s, %s, %d, %d)"),$term_id,$taxonomy,$description,$parent,$count));
arrayAssign($tt_ids[0][$term_id[0]][0],deAspis(registerTaint($taxonomy)),addTaint(int_cast($wpdb[0]->insert_id)));
}if ( (!((empty($category[0]->link_count) || Aspis_empty( $category[0] ->link_count )))))
 {$count = int_cast($category[0]->link_count);
$taxonomy = array('link_category',false);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("INSERT INTO ",$wpdb[0]->term_taxonomy)," (term_id, taxonomy, description, parent, count) VALUES ( %d, %s, %s, %d, %d)"),$term_id,$taxonomy,$description,$parent,$count));
arrayAssign($tt_ids[0][$term_id[0]][0],deAspis(registerTaint($taxonomy)),addTaint(int_cast($wpdb[0]->insert_id)));
}if ( (!((empty($category[0]->tag_count) || Aspis_empty( $category[0] ->tag_count )))))
 {$have_tags = array(true,false);
$count = int_cast($category[0]->tag_count);
$taxonomy = array('post_tag',false);
$wpdb[0]->insert($wpdb[0]->term_taxonomy,array(compact('term_id','taxonomy','description','parent','count'),false));
arrayAssign($tt_ids[0][$term_id[0]][0],deAspis(registerTaint($taxonomy)),addTaint(int_cast($wpdb[0]->insert_id)));
}if ( ((empty($count) || Aspis_empty( $count))))
 {$count = array(0,false);
$taxonomy = array('category',false);
$wpdb[0]->insert($wpdb[0]->term_taxonomy,array(compact('term_id','taxonomy','description','parent','count'),false));
arrayAssign($tt_ids[0][$term_id[0]][0],deAspis(registerTaint($taxonomy)),addTaint(int_cast($wpdb[0]->insert_id)));
}}$select = array('post_id, category_id',false);
if ( $have_tags[0])
 $select = concat2($select,', rel_type');
$posts = $wpdb[0]->get_results(concat2(concat(concat2(concat1("SELECT ",$select)," FROM "),$wpdb[0]->post2cat)," GROUP BY post_id, category_id"));
foreach ( $posts[0] as $post  )
{$post_id = int_cast($post[0]->post_id);
$term_id = int_cast($post[0]->category_id);
$taxonomy = array('category',false);
if ( ((!((empty($post[0]->rel_type) || Aspis_empty( $post[0] ->rel_type )))) && (('tag') == $post[0]->rel_type[0])))
 $taxonomy = array('tag',false);
$tt_id = attachAspis($tt_ids[0][$term_id[0]],$taxonomy[0]);
if ( ((empty($tt_id) || Aspis_empty( $tt_id))))
 continue ;
$wpdb[0]->insert($wpdb[0]->term_relationships,array(array(deregisterTaint(array('object_id',false)) => addTaint($post_id),deregisterTaint(array('term_taxonomy_id',false)) => addTaint($tt_id)),false));
}if ( ($wp_current_db_version[0] < (3570)))
 {$link_cat_id_map = array(array(),false);
$default_link_cat = array(0,false);
$tt_ids = array(array(),false);
$link_cats = $wpdb[0]->get_results(concat2(concat1("SELECT cat_id, cat_name FROM ",$wpdb[0]->prefix),'linkcategories'));
foreach ( $link_cats[0] as $category  )
{$cat_id = int_cast($category[0]->cat_id);
$term_id = array(0,false);
$name = $wpdb[0]->escape($category[0]->cat_name);
$slug = sanitize_title($name);
$term_group = array(0,false);
if ( deAspis($exists = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT term_id, term_group FROM ",$wpdb[0]->terms)," WHERE slug = %s"),$slug))))
 {$term_group = $exists[0][(0)][0]->term_group;
$term_id = $exists[0][(0)][0]->term_id;
}if ( ((empty($term_id) || Aspis_empty( $term_id))))
 {$wpdb[0]->insert($wpdb[0]->terms,array(compact('name','slug','term_group'),false));
$term_id = int_cast($wpdb[0]->insert_id);
}arrayAssign($link_cat_id_map[0],deAspis(registerTaint($cat_id)),addTaint($term_id));
$default_link_cat = $term_id;
$wpdb[0]->insert($wpdb[0]->term_taxonomy,array(array(deregisterTaint(array('term_id',false)) => addTaint($term_id),'taxonomy' => array('link_category',false,false),'description' => array('',false,false),'parent' => array(0,false,false),'count' => array(0,false,false)),false));
arrayAssign($tt_ids[0],deAspis(registerTaint($term_id)),addTaint(int_cast($wpdb[0]->insert_id)));
}$links = $wpdb[0]->get_results(concat1("SELECT link_id, link_category FROM ",$wpdb[0]->links));
if ( (!((empty($links) || Aspis_empty( $links)))))
 foreach ( $links[0] as $link  )
{if ( ((0) == $link[0]->link_category[0]))
 continue ;
if ( (!((isset($link_cat_id_map[0][$link[0]->link_category[0]]) && Aspis_isset( $link_cat_id_map [0][$link[0] ->link_category [0]])))))
 continue ;
$term_id = attachAspis($link_cat_id_map,$link[0]->link_category[0]);
$tt_id = attachAspis($tt_ids,$term_id[0]);
if ( ((empty($tt_id) || Aspis_empty( $tt_id))))
 continue ;
$wpdb[0]->insert($wpdb[0]->term_relationships,array(array(deregisterTaint(array('object_id',false)) => addTaint($link[0]->link_id),deregisterTaint(array('term_taxonomy_id',false)) => addTaint($tt_id)),false));
}update_option(array('default_link_category',false),$default_link_cat);
}else 
{{$links = $wpdb[0]->get_results(concat2(concat1("SELECT link_id, category_id FROM ",$wpdb[0]->link2cat)," GROUP BY link_id, category_id"));
foreach ( $links[0] as $link  )
{$link_id = int_cast($link[0]->link_id);
$term_id = int_cast($link[0]->category_id);
$taxonomy = array('link_category',false);
$tt_id = attachAspis($tt_ids[0][$term_id[0]],$taxonomy[0]);
if ( ((empty($tt_id) || Aspis_empty( $tt_id))))
 continue ;
$wpdb[0]->insert($wpdb[0]->term_relationships,array(array(deregisterTaint(array('object_id',false)) => addTaint($link_id),deregisterTaint(array('term_taxonomy_id',false)) => addTaint($tt_id)),false));
}}}if ( ($wp_current_db_version[0] < (4772)))
 {$wpdb[0]->query(concat2(concat1('DROP TABLE IF EXISTS ',$wpdb[0]->prefix),'linkcategories'));
}$terms = $wpdb[0]->get_results(concat1("SELECT term_taxonomy_id, taxonomy FROM ",$wpdb[0]->term_taxonomy));
foreach ( deAspis(array_cast($terms)) as $term  )
{if ( ((('post_tag') == $term[0]->taxonomy[0]) || (('category') == $term[0]->taxonomy[0])))
 $count = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->term_relationships),", "),$wpdb[0]->posts)," WHERE "),$wpdb[0]->posts),".ID = "),$wpdb[0]->term_relationships),".object_id AND post_status = 'publish' AND post_type = 'post' AND term_taxonomy_id = %d"),$term[0]->term_taxonomy_id));
else 
{$count = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT COUNT(*) FROM ",$wpdb[0]->term_relationships)," WHERE term_taxonomy_id = %d"),$term[0]->term_taxonomy_id));
}$wpdb[0]->update($wpdb[0]->term_taxonomy,array(array(deregisterTaint(array('count',false)) => addTaint($count)),false),array(array(deregisterTaint(array('term_taxonomy_id',false)) => addTaint($term[0]->term_taxonomy_id)),false));
} }
function upgrade_230_options_table (  ) {
global $wpdb;
$old_options_fields = array(array(array('option_can_override',false),array('option_type',false),array('option_width',false),array('option_height',false),array('option_description',false),array('option_admin_level',false)),false);
$wpdb[0]->hide_errors();
foreach ( $old_options_fields[0] as $old  )
$wpdb[0]->query(concat(concat2(concat1("ALTER TABLE ",$wpdb[0]->options)," DROP "),$old));
$wpdb[0]->show_errors();
 }
function upgrade_230_old_tables (  ) {
global $wpdb;
$wpdb[0]->query(concat2(concat1('DROP TABLE IF EXISTS ',$wpdb[0]->prefix),'categories'));
$wpdb[0]->query(concat2(concat1('DROP TABLE IF EXISTS ',$wpdb[0]->prefix),'link2cat'));
$wpdb[0]->query(concat2(concat1('DROP TABLE IF EXISTS ',$wpdb[0]->prefix),'post2cat'));
 }
function upgrade_old_slugs (  ) {
global $wpdb;
$wpdb[0]->query(concat2(concat1("UPDATE ",$wpdb[0]->postmeta)," SET meta_key = '_wp_old_slug' WHERE meta_key = 'old_slug'"));
 }
function upgrade_250 (  ) {
global $wp_current_db_version;
if ( ($wp_current_db_version[0] < (6689)))
 {populate_roles_250();
} }
function upgrade_251 (  ) {
global $wp_current_db_version;
update_option(array('secret',false),wp_generate_password(array(64,false)));
 }
function upgrade_252 (  ) {
global $wpdb;
$wpdb[0]->query(concat2(concat1("UPDATE ",$wpdb[0]->users)," SET user_activation_key = ''"));
 }
function upgrade_260 (  ) {
global $wp_current_db_version;
if ( ($wp_current_db_version[0] < (8000)))
 populate_roles_260();
if ( ($wp_current_db_version[0] < (8201)))
 {update_option(array('enable_app',false),array(1,false));
update_option(array('enable_xmlrpc',false),array(1,false));
} }
function upgrade_270 (  ) {
global $wpdb,$wp_current_db_version;
if ( ($wp_current_db_version[0] < (8980)))
 populate_roles_270();
if ( ($wp_current_db_version[0] < (8921)))
 $wpdb[0]->query(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_date = post_modified WHERE post_date = '0000-00-00 00:00:00'"));
 }
function upgrade_280 (  ) {
global $wp_current_db_version;
if ( ($wp_current_db_version[0] < (10360)))
 populate_roles_280();
 }
function upgrade_290 (  ) {
global $wp_current_db_version;
if ( ($wp_current_db_version[0] < (11958)))
 {if ( (deAspis(get_option(array('thread_comments_depth',false))) == ('1')))
 {update_option(array('thread_comments_depth',false),array(2,false));
update_option(array('thread_comments',false),array(0,false));
}} }
function maybe_create_table ( $table_name,$create_ddl ) {
global $wpdb;
if ( (deAspis($wpdb[0]->get_var(concat2(concat1("SHOW TABLES LIKE '",$table_name),"'"))) == $table_name[0]))
 return array(true,false);
$q = $wpdb[0]->query($create_ddl);
if ( (deAspis($wpdb[0]->get_var(concat2(concat1("SHOW TABLES LIKE '",$table_name),"'"))) == $table_name[0]))
 return array(true,false);
return array(false,false);
 }
function drop_index ( $table,$index ) {
global $wpdb;
$wpdb[0]->hide_errors();
$wpdb[0]->query(concat2(concat(concat2(concat1("ALTER TABLE `",$table),"` DROP INDEX `"),$index),"`"));
for ( $i = array(0,false) ; ($i[0] < (25)) ; postincr($i) )
{$wpdb[0]->query(concat2(concat(concat2(concat(concat2(concat1("ALTER TABLE `",$table),"` DROP INDEX `"),$index),"_"),$i),"`"));
}$wpdb[0]->show_errors();
return array(true,false);
 }
function add_clean_index ( $table,$index ) {
global $wpdb;
drop_index($table,$index);
$wpdb[0]->query(concat2(concat(concat2(concat1("ALTER TABLE `",$table),"` ADD INDEX ( `"),$index),"` )"));
return array(true,false);
 }
function maybe_add_column ( $table_name,$column_name,$create_ddl ) {
global $wpdb,$debug;
foreach ( deAspis($wpdb[0]->get_col(concat1("DESC ",$table_name),array(0,false))) as $column  )
{if ( $debug[0])
 echo AspisCheckPrint((concat2(concat(concat2(concat1("checking ",$column)," == "),$column_name),"<br />")));
if ( ($column[0] == $column_name[0]))
 {return array(true,false);
}}$q = $wpdb[0]->query($create_ddl);
foreach ( deAspis($wpdb[0]->get_col(concat1("DESC ",$table_name),array(0,false))) as $column  )
{if ( ($column[0] == $column_name[0]))
 {return array(true,false);
}}return array(false,false);
 }
function get_alloptions_110 (  ) {
global $wpdb;
if ( deAspis($options = $wpdb[0]->get_results(concat1("SELECT option_name, option_value FROM ",$wpdb[0]->options))))
 {foreach ( $options[0] as $option  )
{if ( (('siteurl') == $option[0]->option_name[0]))
 $option[0]->option_value = Aspis_preg_replace(array('|/+$|',false),array('',false),$option[0]->option_value);
if ( (('home') == $option[0]->option_name[0]))
 $option[0]->option_value = Aspis_preg_replace(array('|/+$|',false),array('',false),$option[0]->option_value);
if ( (('category_base') == $option[0]->option_name[0]))
 $option[0]->option_value = Aspis_preg_replace(array('|/+$|',false),array('',false),$option[0]->option_value);
$all_options[0]->{$option[0]->option_name[0]} = Aspis_stripslashes($option[0]->option_value);
}}return $all_options;
 }
function __get_option ( $setting ) {
global $wpdb;
if ( (($setting[0] == ('home')) && defined(('WP_HOME'))))
 {return Aspis_preg_replace(array('|/+$|',false),array('',false),attAspisRC(constant(('WP_HOME'))));
}if ( (($setting[0] == ('siteurl')) && defined(('WP_SITEURL'))))
 {return Aspis_preg_replace(array('|/+$|',false),array('',false),attAspisRC(constant(('WP_SITEURL'))));
}$option = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT option_value FROM ",$wpdb[0]->options)," WHERE option_name = %s"),$setting));
if ( ((('home') == $setting[0]) && (('') == $option[0])))
 return __get_option(array('siteurl',false));
if ( (((('siteurl') == $setting[0]) || (('home') == $setting[0])) || (('category_base') == $setting[0])))
 $option = Aspis_preg_replace(array('|/+$|',false),array('',false),$option);
@$kellogs = Aspis_unserialize($option);
if ( ($kellogs[0] !== FALSE))
 return $kellogs;
else 
{return $option;
} }
function deslash ( $content ) {
$content = Aspis_preg_replace(array("/\\\+'/",false),array("'",false),$content);
$content = Aspis_preg_replace(array('/\\\+"/',false),array('"',false),$content);
$content = Aspis_preg_replace(array("/\\\+/",false),array("\\",false),$content);
return $content;
 }
function dbDelta ( $queries,$execute = array(true,false) ) {
global $wpdb;
if ( (!(is_array($queries[0]))))
 {$queries = Aspis_explode(array(';',false),$queries);
if ( (('') == deAspis(attachAspis($queries,(count($queries[0]) - (1))))))
 Aspis_array_pop($queries);
}$cqueries = array(array(),false);
$iqueries = array(array(),false);
$for_update = array(array(),false);
foreach ( $queries[0] as $qry  )
{if ( deAspis(Aspis_preg_match(array("|CREATE TABLE ([^ ]*)|",false),$qry,$matches)))
 {arrayAssign($cqueries[0],deAspis(registerTaint(Aspis_trim(Aspis_strtolower(attachAspis($matches,(1))),array('`',false)))),addTaint($qry));
arrayAssign($for_update[0],deAspis(registerTaint(attachAspis($matches,(1)))),addTaint(concat1('Created table ',attachAspis($matches,(1)))));
}else 
{if ( deAspis(Aspis_preg_match(array("|CREATE DATABASE ([^ ]*)|",false),$qry,$matches)))
 {Aspis_array_unshift($cqueries,$qry);
}else 
{if ( deAspis(Aspis_preg_match(array("|INSERT INTO ([^ ]*)|",false),$qry,$matches)))
 {arrayAssignAdd($iqueries[0][],addTaint($qry));
}else 
{if ( deAspis(Aspis_preg_match(array("|UPDATE ([^ ]*)|",false),$qry,$matches)))
 {arrayAssignAdd($iqueries[0][],addTaint($qry));
}else 
{{}}}}}}if ( deAspis($tables = $wpdb[0]->get_col(array('SHOW TABLES;',false))))
 {foreach ( $tables[0] as $table  )
{if ( array_key_exists(deAspisRC(Aspis_strtolower($table)),deAspisRC($cqueries)))
 {unset($cfields);
unset($indices);
Aspis_preg_match(array("|\((.*)\)|ms",false),attachAspis($cqueries,deAspis(Aspis_strtolower($table))),$match2);
$qryline = Aspis_trim(attachAspis($match2,(1)));
$flds = Aspis_explode(array("\n",false),$qryline);
foreach ( $flds[0] as $fld  )
{Aspis_preg_match(array("|^([^ ]*)|",false),Aspis_trim($fld),$fvals);
$fieldname = Aspis_trim(attachAspis($fvals,(1)),array('`',false));
$validfield = array(true,false);
switch ( deAspis(Aspis_strtolower($fieldname)) ) {
case (''):case ('primary'):case ('index'):case ('fulltext'):case ('unique'):case ('key'):$validfield = array(false,false);
arrayAssignAdd($indices[0][],addTaint(Aspis_trim(Aspis_trim($fld),array(", \n",false))));
break ;
 }
$fld = Aspis_trim($fld);
if ( $validfield[0])
 {arrayAssign($cfields[0],deAspis(registerTaint(Aspis_strtolower($fieldname))),addTaint(Aspis_trim($fld,array(", \n",false))));
}}$tablefields = $wpdb[0]->get_results(concat2(concat1("DESCRIBE ",$table),";"));
foreach ( $tablefields[0] as $tablefield  )
{if ( array_key_exists(deAspisRC(Aspis_strtolower($tablefield[0]->Field)),deAspisRC($cfields)))
 {Aspis_preg_match(concat2(concat1("|",$tablefield[0]->Field)," ([^ ]*( unsigned)?)|i"),attachAspis($cfields,deAspis(Aspis_strtolower($tablefield[0]->Field))),$matches);
$fieldtype = attachAspis($matches,(1));
if ( ($tablefield[0]->Type[0] != $fieldtype[0]))
 {arrayAssignAdd($cqueries[0][],addTaint(concat(concat2(concat(concat2(concat1("ALTER TABLE ",$table)," CHANGE COLUMN "),$tablefield[0]->Field)," "),attachAspis($cfields,deAspis(Aspis_strtolower($tablefield[0]->Field))))));
arrayAssign($for_update[0],deAspis(registerTaint(concat(concat2($table,'.'),$tablefield[0]->Field))),addTaint(concat(concat2(concat(concat2(concat(concat2(concat1("Changed type of ",$table),"."),$tablefield[0]->Field)," from "),$tablefield[0]->Type)," to "),$fieldtype)));
}if ( deAspis(Aspis_preg_match(array("| DEFAULT '(.*)'|i",false),attachAspis($cfields,deAspis(Aspis_strtolower($tablefield[0]->Field))),$matches)))
 {$default_value = attachAspis($matches,(1));
if ( ($tablefield[0]->Default[0] != $default_value[0]))
 {arrayAssignAdd($cqueries[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1("ALTER TABLE ",$table)," ALTER COLUMN "),$tablefield[0]->Field)," SET DEFAULT '"),$default_value),"'")));
arrayAssign($for_update[0],deAspis(registerTaint(concat(concat2($table,'.'),$tablefield[0]->Field))),addTaint(concat(concat2(concat(concat2(concat(concat2(concat1("Changed default value of ",$table),"."),$tablefield[0]->Field)," from "),$tablefield[0]->Default)," to "),$default_value)));
}}unset($cfields[0][deAspis(Aspis_strtolower($tablefield[0]->Field))]);
}else 
{{}}}foreach ( $cfields[0] as $fieldname =>$fielddef )
{restoreTaint($fieldname,$fielddef);
{arrayAssignAdd($cqueries[0][],addTaint(concat(concat2(concat1("ALTER TABLE ",$table)," ADD COLUMN "),$fielddef)));
arrayAssign($for_update[0],deAspis(registerTaint(concat(concat2($table,'.'),$fieldname))),addTaint(concat(concat2(concat1('Added column ',$table),'.'),$fieldname)));
}}$tableindices = $wpdb[0]->get_results(concat2(concat1("SHOW INDEX FROM ",$table),";"));
if ( $tableindices[0])
 {unset($index_ary);
foreach ( $tableindices[0] as $tableindex  )
{$keyname = $tableindex[0]->Key_name;
arrayAssignAdd($index_ary[0][$keyname[0]][0][('columns')][0][],addTaint(array(array(deregisterTaint(array('fieldname',false)) => addTaint($tableindex[0]->Column_name),deregisterTaint(array('subpart',false)) => addTaint($tableindex[0]->Sub_part)),false)));
arrayAssign($index_ary[0][$keyname[0]][0],deAspis(registerTaint(array('unique',false))),addTaint(($tableindex[0]->Non_unique[0] == (0)) ? array(true,false) : array(false,false)));
}foreach ( $index_ary[0] as $index_name =>$index_data )
{restoreTaint($index_name,$index_data);
{$index_string = array('',false);
if ( ($index_name[0] == ('PRIMARY')))
 {$index_string = concat2($index_string,'PRIMARY ');
}else 
{if ( deAspis($index_data[0]['unique']))
 {$index_string = concat2($index_string,'UNIQUE ');
}}$index_string = concat2($index_string,'KEY ');
if ( ($index_name[0] != ('PRIMARY')))
 {$index_string = concat($index_string,$index_name);
}$index_columns = array('',false);
foreach ( deAspis($index_data[0]['columns']) as $column_data  )
{if ( ($index_columns[0] != ('')))
 $index_columns = concat2($index_columns,',');
$index_columns = concat($index_columns,$column_data[0]['fieldname']);
if ( (deAspis($column_data[0]['subpart']) != ('')))
 {$index_columns = concat($index_columns,concat2(concat1('(',$column_data[0]['subpart']),')'));
}}$index_string = concat($index_string,concat2(concat1(' (',$index_columns),')'));
if ( (!(deAspis(($aindex = Aspis_array_search($index_string,$indices))) === false)))
 {unset($indices[0][$aindex[0]]);
}}}}foreach ( deAspis(array_cast($indices)) as $index  )
{arrayAssignAdd($cqueries[0][],addTaint(concat(concat2(concat1("ALTER TABLE ",$table)," ADD "),$index)));
arrayAssign($for_update[0],deAspis(registerTaint(concat(concat2($table,'.'),$fieldname))),addTaint(concat(concat2(concat1('Added index ',$table),' '),$index)));
}unset($cqueries[0][deAspis(Aspis_strtolower($table))]);
unset($for_update[0][deAspis(Aspis_strtolower($table))]);
}else 
{{}}}}$allqueries = Aspis_array_merge($cqueries,$iqueries);
if ( $execute[0])
 {foreach ( $allqueries[0] as $query  )
{$wpdb[0]->query($query);
}}return $for_update;
 }
function make_db_current (  ) {
global $wp_queries;
$alterations = dbDelta($wp_queries);
echo AspisCheckPrint(array("<ol>\n",false));
foreach ( $alterations[0] as $alteration  )
echo AspisCheckPrint(concat2(concat1("<li>",$alteration),"</li>\n"));
echo AspisCheckPrint(array("</ol>\n",false));
 }
function make_db_current_silent (  ) {
global $wp_queries;
$alterations = dbDelta($wp_queries);
 }
function make_site_theme_from_oldschool ( $theme_name,$template ) {
$home_path = get_home_path();
$site_dir = concat1(WP_CONTENT_DIR,concat1("/themes/",$template));
if ( (!(file_exists((deconcat2($home_path,"/index.php"))))))
 return array(false,false);
$files = array(array('index.php' => array('index.php',false,false),'wp-layout.css' => array('style.css',false,false),'wp-comments.php' => array('comments.php',false,false),'wp-comments-popup.php' => array('comments-popup.php',false,false)),false);
foreach ( $files[0] as $oldfile =>$newfile )
{restoreTaint($oldfile,$newfile);
{if ( ($oldfile[0] == ('index.php')))
 $oldpath = $home_path;
else 
{$oldpath = array(ABSPATH,false);
}if ( ($oldfile[0] == ('index.php')))
 {$index = Aspis_implode(array('',false),Aspis_file(concat(concat2($oldpath,"/"),$oldfile)));
if ( (strpos($index[0],'WP_USE_THEMES') !== false))
 {if ( (denot_boolean(@attAspis(copy((deconcat12(WP_CONTENT_DIR,'/themes/default/index.php')),(deconcat(concat2($site_dir,"/"),$newfile)))))))
 return array(false,false);
continue ;
}}if ( (denot_boolean(@attAspis(copy((deconcat(concat2($oldpath,"/"),$oldfile)),(deconcat(concat2($site_dir,"/"),$newfile)))))))
 return array(false,false);
chmod((deconcat(concat2($site_dir,"/"),$newfile)),(0777));
$lines = Aspis_explode(array("\n",false),Aspis_implode(array('',false),Aspis_file(concat(concat2($site_dir,"/"),$newfile))));
if ( $lines[0])
 {$f = attAspis(fopen((deconcat(concat2($site_dir,"/"),$newfile)),('w')));
foreach ( $lines[0] as $line  )
{if ( deAspis(Aspis_preg_match(array('/require.*wp-blog-header/',false),$line)))
 $line = concat1('//',$line);
$line = Aspis_str_replace(array("<?php echo __get_option('siteurl'); ?>/wp-layout.css",false),array("<?php bloginfo('stylesheet_url'); ?>",false),$line);
$line = Aspis_str_replace(array("<?php include(ABSPATH . 'wp-comments.php'); ?>",false),array("<?php comments_template(); ?>",false),$line);
fwrite($f[0],(deconcat2($line,"\n")));
}fclose($f[0]);
}}}$header = concat2(concat(concat2(concat1("/*\nTheme Name: ",$theme_name),"\nTheme URI: "),__get_option(array('siteurl',false))),"\nDescription: A theme automatically created by the upgrade.\nVersion: 1.0\nAuthor: Moi\n*/\n");
$stylelines = attAspis(file_get_contents((deconcat2($site_dir,"/style.css"))));
if ( $stylelines[0])
 {$f = attAspis(fopen((deconcat2($site_dir,"/style.css")),('w')));
fwrite($f[0],$header[0]);
fwrite($f[0],$stylelines[0]);
fclose($f[0]);
}return array(true,false);
 }
function make_site_theme_from_default ( $theme_name,$template ) {
$site_dir = concat1(WP_CONTENT_DIR,concat1("/themes/",$template));
$default_dir = concat12(WP_CONTENT_DIR,'/themes/default');
$theme_dir = @attAspis(opendir($default_dir[0]));
if ( $theme_dir[0])
 {while ( (deAspis(($theme_file = attAspis(readdir($theme_dir[0])))) !== false) )
{if ( is_dir((deconcat(concat2($default_dir,"/"),$theme_file))))
 continue ;
if ( (denot_boolean(@attAspis(copy((deconcat(concat2($default_dir,"/"),$theme_file)),(deconcat(concat2($site_dir,"/"),$theme_file)))))))
 return ;
chmod((deconcat(concat2($site_dir,"/"),$theme_file)),(0777));
}}@closedir($theme_dir[0]);
$stylelines = Aspis_explode(array("\n",false),Aspis_implode(array('',false),Aspis_file(concat2($site_dir,"/style.css"))));
if ( $stylelines[0])
 {$f = attAspis(fopen((deconcat2($site_dir,"/style.css")),('w')));
foreach ( $stylelines[0] as $line  )
{if ( (strpos($line[0],'Theme Name:') !== false))
 $line = concat1('Theme Name: ',$theme_name);
elseif ( (strpos($line[0],'Theme URI:') !== false))
 $line = concat1('Theme URI: ',__get_option(array('url',false)));
elseif ( (strpos($line[0],'Description:') !== false))
 $line = array('Description: Your theme.',false);
elseif ( (strpos($line[0],'Version:') !== false))
 $line = array('Version: 1',false);
elseif ( (strpos($line[0],'Author:') !== false))
 $line = array('Author: You',false);
fwrite($f[0],(deconcat2($line,"\n")));
}fclose($f[0]);
}umask((0));
if ( (!(mkdir((deconcat2($site_dir,"/images")),(0777)))))
 {return array(false,false);
}$images_dir = @attAspis(opendir((deconcat2($default_dir,"/images"))));
if ( $images_dir[0])
 {while ( (deAspis(($image = attAspis(readdir($images_dir[0])))) !== false) )
{if ( is_dir((deconcat(concat2($default_dir,"/images/"),$image))))
 continue ;
if ( (denot_boolean(@attAspis(copy((deconcat(concat2($default_dir,"/images/"),$image)),(deconcat(concat2($site_dir,"/images/"),$image)))))))
 return ;
chmod((deconcat(concat2($site_dir,"/images/"),$image)),(0777));
}}@closedir($images_dir[0]);
 }
function make_site_theme (  ) {
$theme_name = __get_option(array('blogname',false));
$template = sanitize_title($theme_name);
$site_dir = concat1(WP_CONTENT_DIR,concat1("/themes/",$template));
if ( is_dir($site_dir[0]))
 {return array(false,false);
}if ( (!(is_writable((deconcat12(WP_CONTENT_DIR,"/themes"))))))
 {return array(false,false);
}umask((0));
if ( (!(mkdir($site_dir[0],(0777)))))
 {return array(false,false);
}if ( file_exists((deconcat12(ABSPATH,'wp-layout.css'))))
 {if ( (denot_boolean(make_site_theme_from_oldschool($theme_name,$template))))
 {return array(false,false);
}}else 
{{if ( (denot_boolean(make_site_theme_from_default($theme_name,$template))))
 return array(false,false);
}}$current_template = __get_option(array('template',false));
if ( ($current_template[0] == ('default')))
 {update_option(array('template',false),$template);
update_option(array('stylesheet',false),$template);
}return $template;
 }
function translate_level_to_role ( $level ) {
switch ( $level[0] ) {
case (10):case (9):case (8):return array('administrator',false);
case (7):case (6):case (5):return array('editor',false);
case (4):case (3):case (2):return array('author',false);
case (1):return array('contributor',false);
case (0):return array('subscriber',false);
 }
 }
function wp_check_mysql_version (  ) {
global $wpdb;
$result = $wpdb[0]->check_database_version();
if ( deAspis(is_wp_error($result)))
 Aspis_exit($result[0]->get_error_message());
 }
function maybe_disable_automattic_widgets (  ) {
$plugins = __get_option(array('active_plugins',false));
foreach ( deAspis(array_cast($plugins)) as $plugin  )
{if ( (deAspis(Aspis_basename($plugin)) == ('widgets.php')))
 {Aspis_array_splice($plugins,Aspis_array_search($plugin,$plugins),array(1,false));
update_option(array('active_plugins',false),$plugins);
break ;
}} }
function pre_schema_upgrade (  ) {
global $wp_current_db_version,$wp_db_version,$wpdb;
if ( ($wp_current_db_version[0] < (11557)))
 {$wpdb[0]->query(concat2(concat(concat2(concat1("DELETE o1 FROM ",$wpdb[0]->options)," AS o1 JOIN "),$wpdb[0]->options)," AS o2 USING (`option_name`) WHERE o2.option_id > o1.option_id"));
$wpdb[0]->query(concat2(concat1("ALTER TABLE ",$wpdb[0]->options)," DROP PRIMARY KEY, ADD PRIMARY KEY(option_id)"));
$wpdb[0]->query(concat2(concat1("ALTER TABLE ",$wpdb[0]->options)," DROP INDEX option_name"));
} }
;
?>
<?php 