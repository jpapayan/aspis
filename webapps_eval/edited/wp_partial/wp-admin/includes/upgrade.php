<?php require_once('AspisMain.php'); ?><?php
if ( file_exists(WP_CONTENT_DIR . '/install.php'))
 require (WP_CONTENT_DIR . '/install.php');
require_once (ABSPATH . 'wp-admin/includes/admin.php');
require_once (ABSPATH . 'wp-admin/includes/schema.php');
if ( !function_exists('wp_install'))
 {function wp_install ( $blog_title,$user_name,$user_email,$public,$deprecated = '' ) {
{global $wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}wp_check_mysql_version();
wp_cache_flush();
make_db_current_silent();
populate_options();
populate_roles();
update_option('blogname',$blog_title);
update_option('admin_email',$user_email);
update_option('blog_public',$public);
$guessurl = wp_guess_url();
update_option('siteurl',$guessurl);
if ( !$public)
 update_option('default_pingback_flag',0);
$user_id = username_exists($user_name);
if ( !$user_id)
 {$random_password = wp_generate_password();
$message = __('<strong><em>Note that password</em></strong> carefully! It is a <em>random</em> password that was generated just for you.');
$user_id = wp_create_user($user_name,$random_password,$user_email);
update_usermeta($user_id,'default_password_nag',true);
}else 
{{$random_password = '';
$message = __('User already exists.  Password inherited.');
}}$user = new WP_User($user_id);
$user->set_role('administrator');
wp_install_defaults($user_id);
$wp_rewrite->flush_rules();
wp_new_blog_notification($blog_title,$guessurl,$user_id,$random_password);
wp_cache_flush();
{$AspisRetTemp = array('url' => $guessurl,'user_id' => $user_id,'password' => $random_password,'password_message' => $message);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_rewrite",$AspisChangesCache);
 }
}if ( !function_exists('wp_install_defaults'))
 {function wp_install_defaults ( $user_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$cat_name = __('Uncategorized');
$cat_slug = sanitize_title(_x('Uncategorized','Default category slug'));
$wpdb->insert($wpdb->terms,array('name' => $cat_name,'slug' => $cat_slug,'term_group' => 0));
$wpdb->insert($wpdb->term_taxonomy,array('term_id' => '1','taxonomy' => 'category','description' => '','parent' => 0,'count' => 1));
$cat_name = __('Blogroll');
$cat_slug = sanitize_title(_x('Blogroll','Default link category slug'));
$wpdb->insert($wpdb->terms,array('name' => $cat_name,'slug' => $cat_slug,'term_group' => 0));
$wpdb->insert($wpdb->term_taxonomy,array('term_id' => '2','taxonomy' => 'link_category','description' => '','parent' => 0,'count' => 7));
$default_links = array();
$default_links[] = array('link_url' => 'http://codex.wordpress.org/','link_name' => 'Documentation','link_rss' => '','link_notes' => '');
$default_links[] = array('link_url' => 'http://wordpress.org/development/','link_name' => 'Development Blog','link_rss' => 'http://wordpress.org/development/feed/','link_notes' => '');
$default_links[] = array('link_url' => 'http://wordpress.org/extend/ideas/','link_name' => 'Suggest Ideas','link_rss' => '','link_notes' => '');
$default_links[] = array('link_url' => 'http://wordpress.org/support/','link_name' => 'Support Forum','link_rss' => '','link_notes' => '');
$default_links[] = array('link_url' => 'http://wordpress.org/extend/plugins/','link_name' => 'Plugins','link_rss' => '','link_notes' => '');
$default_links[] = array('link_url' => 'http://wordpress.org/extend/themes/','link_name' => 'Themes','link_rss' => '','link_notes' => '');
$default_links[] = array('link_url' => 'http://planet.wordpress.org/','link_name' => 'WordPress Planet','link_rss' => '','link_notes' => '');
foreach ( $default_links as $link  )
{$wpdb->insert($wpdb->links,$link);
$wpdb->insert($wpdb->term_relationships,array('term_taxonomy_id' => 2,'object_id' => $wpdb->insert_id));
}$now = date('Y-m-d H:i:s');
$now_gmt = gmdate('Y-m-d H:i:s');
$first_post_guid = get_option('home') . '/?p=1';
$wpdb->insert($wpdb->posts,array('post_author' => $user_id,'post_date' => $now,'post_date_gmt' => $now_gmt,'post_content' => __('Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!'),'post_excerpt' => '','post_title' => __('Hello world!'),'post_name' => _x('hello-world','Default post slug'),'post_modified' => $now,'post_modified_gmt' => $now_gmt,'guid' => $first_post_guid,'comment_count' => 1,'to_ping' => '','pinged' => '','post_content_filtered' => ''));
$wpdb->insert($wpdb->term_relationships,array('term_taxonomy_id' => 1,'object_id' => 1));
$wpdb->insert($wpdb->comments,array('comment_post_ID' => 1,'comment_author' => __('Mr WordPress'),'comment_author_email' => '','comment_author_url' => 'http://wordpress.org/','comment_date' => $now,'comment_date_gmt' => $now_gmt,'comment_content' => __('Hi, this is a comment.<br />To delete a comment, just log in and view the post&#039;s comments. There you will have the option to edit or delete them.')));
$first_post_guid = get_option('home') . '/?page_id=2';
$wpdb->insert($wpdb->posts,array('post_author' => $user_id,'post_date' => $now,'post_date_gmt' => $now_gmt,'post_content' => __('This is an example of a WordPress page, you could edit this to put information about yourself or your site so readers know where you are coming from. You can create as many pages like this one or sub-pages as you like and manage all of your content inside of WordPress.'),'post_excerpt' => '','post_title' => __('About'),'post_name' => _x('about','Default page slug'),'post_modified' => $now,'post_modified_gmt' => $now_gmt,'guid' => $first_post_guid,'post_type' => 'page','to_ping' => '','pinged' => '','post_content_filtered' => ''));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
}if ( !function_exists('wp_new_blog_notification'))
 {function wp_new_blog_notification ( $blog_title,$blog_url,$user_id,$password ) {
$user = new WP_User($user_id);
$email = $user->user_email;
$name = $user->user_login;
$message = sprintf(__("Your new WordPress blog has been successfully set up at:

%1\$s

You can log in to the administrator account with the following information:

Username: %2\$s
Password: %3\$s

We hope you enjoy your new blog. Thanks!

--The WordPress Team
http://wordpress.org/
"),$blog_url,$name,$password);
@wp_mail($email,__('New WordPress Blog'),$message);
 }
}if ( !function_exists('wp_upgrade'))
 {function wp_upgrade (  ) {
{global $wp_current_db_version,$wp_db_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_db_version,"\$wp_db_version",$AspisChangesCache);
}$wp_current_db_version = __get_option('db_version');
if ( $wp_db_version == $wp_current_db_version)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_db_version",$AspisChangesCache);
return ;
}if ( !is_blog_installed())
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_db_version",$AspisChangesCache);
return ;
}wp_check_mysql_version();
wp_cache_flush();
pre_schema_upgrade();
make_db_current_silent();
upgrade_all();
wp_cache_flush();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_db_version",$AspisChangesCache);
 }
}function upgrade_all (  ) {
{global $wp_current_db_version,$wp_db_version,$wp_rewrite;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_db_version,"\$wp_db_version",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
}$wp_current_db_version = __get_option('db_version');
if ( $wp_db_version == $wp_current_db_version)
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_db_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_rewrite",$AspisChangesCache);
return ;
}if ( empty($wp_current_db_version))
 {$wp_current_db_version = 0;
$template = __get_option('template');
if ( !empty($template))
 $wp_current_db_version = 2541;
}if ( $wp_current_db_version < 6039)
 upgrade_230_options_table();
populate_options();
if ( $wp_current_db_version < 2541)
 {upgrade_100();
upgrade_101();
upgrade_110();
upgrade_130();
}if ( $wp_current_db_version < 3308)
 upgrade_160();
if ( $wp_current_db_version < 4772)
 upgrade_210();
if ( $wp_current_db_version < 4351)
 upgrade_old_slugs();
if ( $wp_current_db_version < 5539)
 upgrade_230();
if ( $wp_current_db_version < 6124)
 upgrade_230_old_tables();
if ( $wp_current_db_version < 7499)
 upgrade_250();
if ( $wp_current_db_version < 7796)
 upgrade_251();
if ( $wp_current_db_version < 7935)
 upgrade_252();
if ( $wp_current_db_version < 8201)
 upgrade_260();
if ( $wp_current_db_version < 8989)
 upgrade_270();
if ( $wp_current_db_version < 10360)
 upgrade_280();
if ( $wp_current_db_version < 11958)
 upgrade_290();
maybe_disable_automattic_widgets();
update_option('db_version',$wp_db_version);
update_option('db_upgraded',true);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_db_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_rewrite",$AspisChangesCache);
 }
function upgrade_100 (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$posts = $wpdb->get_results("SELECT ID, post_title, post_name FROM $wpdb->posts WHERE post_name = ''");
if ( $posts)
 {foreach ( $posts as $post  )
{if ( '' == $post->post_name)
 {$newtitle = sanitize_title($post->post_title);
$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET post_name = %s WHERE ID = %d",$newtitle,$post->ID));
}}}$categories = $wpdb->get_results("SELECT cat_ID, cat_name, category_nicename FROM $wpdb->categories");
foreach ( $categories as $category  )
{if ( '' == $category->category_nicename)
 {$newtitle = sanitize_title($category->cat_name);
$wpdb > update($wpdb->categories,array('category_nicename' => $newtitle),array('cat_ID' => $category->cat_ID));
}}$wpdb->query("UPDATE $wpdb->options SET option_value = REPLACE(option_value, 'wp-links/links-images/', 'wp-images/links/')
	WHERE option_name LIKE 'links_rating_image%'
	AND option_value LIKE 'wp-links/links-images/%'");
$done_ids = $wpdb->get_results("SELECT DISTINCT post_id FROM $wpdb->post2cat");
if ( $done_ids)
 {foreach ( $done_ids as $done_id  )
{$done_posts[] = $done_id->post_id;
}$catwhere = ' AND ID NOT IN (' . implode(',',$done_posts) . ')';
}else 
{$catwhere = '';
}$allposts = $wpdb->get_results("SELECT ID, post_category FROM $wpdb->posts WHERE post_category != '0' $catwhere");
if ( $allposts)
 {foreach ( $allposts as $post  )
{$cat = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->post2cat WHERE post_id = %d AND category_id = %d",$post->ID,$post->post_category));
if ( !$cat && 0 != $post->post_category)
 {$wpdb->insert($wpdb->post2cat,array('post_id' => $post->ID,'category_id' => $post->post_category));
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function upgrade_101 (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}add_clean_index($wpdb->posts,'post_name');
add_clean_index($wpdb->posts,'post_status');
add_clean_index($wpdb->categories,'category_nicename');
add_clean_index($wpdb->comments,'comment_approved');
add_clean_index($wpdb->comments,'comment_post_ID');
add_clean_index($wpdb->links,'link_category');
add_clean_index($wpdb->links,'link_visible');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function upgrade_110 (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$users = $wpdb->get_results("SELECT ID, user_nickname, user_nicename FROM $wpdb->users");
foreach ( $users as $user  )
{if ( '' == $user->user_nicename)
 {$newname = sanitize_title($user->user_nickname);
$wpdb->update($wpdb->users,array('user_nicename' => $newname),array('ID' => $user->ID));
}}$users = $wpdb->get_results("SELECT ID, user_pass from $wpdb->users");
foreach ( $users as $row  )
{if ( !preg_match('/^[A-Fa-f0-9]{32}$/',$row->user_pass))
 {$wpdb->update($wpdb->users,array('user_pass' => md5($row->user_pass)),array('ID' => $row->ID));
}}$all_options = get_alloptions_110();
$time_difference = $all_options->time_difference;
$server_time = time() + date('Z');
$weblogger_time = $server_time + $time_difference * 3600;
$gmt_time = time();
$diff_gmt_server = ($gmt_time - $server_time) / 3600;
$diff_weblogger_server = ($weblogger_time - $server_time) / 3600;
$diff_gmt_weblogger = $diff_gmt_server - $diff_weblogger_server;
$gmt_offset = -$diff_gmt_weblogger;
add_option('gmt_offset',$gmt_offset);
$got_gmt_fields = ($wpdb->get_var("SELECT MAX(post_date_gmt) FROM $wpdb->posts") == '0000-00-00 00:00:00') ? false : true;
if ( !$got_gmt_fields)
 {$add_hours = intval($diff_gmt_weblogger);
$add_minutes = intval(60 * ($diff_gmt_weblogger - $add_hours));
$wpdb->query("UPDATE $wpdb->posts SET post_date_gmt = DATE_ADD(post_date, INTERVAL '$add_hours:$add_minutes' HOUR_MINUTE)");
$wpdb->query("UPDATE $wpdb->posts SET post_modified = post_date");
$wpdb->query("UPDATE $wpdb->posts SET post_modified_gmt = DATE_ADD(post_modified, INTERVAL '$add_hours:$add_minutes' HOUR_MINUTE) WHERE post_modified != '0000-00-00 00:00:00'");
$wpdb->query("UPDATE $wpdb->comments SET comment_date_gmt = DATE_ADD(comment_date, INTERVAL '$add_hours:$add_minutes' HOUR_MINUTE)");
$wpdb->query("UPDATE $wpdb->users SET user_registered = DATE_ADD(user_registered, INTERVAL '$add_hours:$add_minutes' HOUR_MINUTE)");
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function upgrade_130 (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$posts = $wpdb->get_results("SELECT ID, post_title, post_content, post_excerpt, guid, post_date, post_name, post_status, post_author FROM $wpdb->posts");
if ( $posts)
 {foreach ( $posts as $post  )
{$post_content = addslashes(deslash($post->post_content));
$post_title = addslashes(deslash($post->post_title));
$post_excerpt = addslashes(deslash($post->post_excerpt));
if ( empty($post->guid))
 $guid = get_permalink($post->ID);
else 
{$guid = $post->guid;
}$wpdb->update($wpdb->posts,compact('post_title','post_content','post_excerpt','guid'),array('ID' => $post->ID));
}}$comments = $wpdb->get_results("SELECT comment_ID, comment_author, comment_content FROM $wpdb->comments");
if ( $comments)
 {foreach ( $comments as $comment  )
{$comment_content = deslash($comment->comment_content);
$comment_author = deslash($comment->comment_author);
$wpdb->update($wpdb->comments,compact('comment_content','comment_author'),array('comment_ID' => $comment->comment_ID));
}}$links = $wpdb->get_results("SELECT link_id, link_name, link_description FROM $wpdb->links");
if ( $links)
 {foreach ( $links as $link  )
{$link_name = deslash($link->link_name);
$link_description = deslash($link->link_description);
$wpdb->update($wpdb->links,compact('link_name','link_description'),array('link_id' => $link->link_id));
}}$active_plugins = __get_option('active_plugins');
if ( !is_array($active_plugins))
 {$active_plugins = explode("\n",trim($active_plugins));
update_option('active_plugins',$active_plugins);
}$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'optionvalues');
$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'optiontypes');
$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'optiongroups');
$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'optiongroup_options');
$wpdb->query("UPDATE $wpdb->comments SET comment_type='trackback', comment_content = REPLACE(comment_content, '<trackback />', '') WHERE comment_content LIKE '<trackback />%'");
$wpdb->query("UPDATE $wpdb->comments SET comment_type='pingback', comment_content = REPLACE(comment_content, '<pingback />', '') WHERE comment_content LIKE '<pingback />%'");
$options = $wpdb->get_results("SELECT option_name, COUNT(option_name) AS dupes FROM `$wpdb->options` GROUP BY option_name");
foreach ( $options as $option  )
{if ( 1 != $option->dupes)
 {$limit = $option->dupes - 1;
$dupe_ids = $wpdb->get_col($wpdb->prepare("SELECT option_id FROM $wpdb->options WHERE option_name = %s LIMIT %d",$option->option_name,$limit));
if ( $dupe_ids)
 {$dupe_ids = join($dupe_ids,',');
$wpdb->query("DELETE FROM $wpdb->options WHERE option_id IN ($dupe_ids)");
}}}make_site_theme();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function upgrade_160 (  ) {
{global $wpdb,$wp_current_db_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
}populate_roles_160();
$users = $wpdb->get_results("SELECT * FROM $wpdb->users");
foreach ( $users as $user  )
{if ( !empty($user->user_firstname))
 update_usermeta($user->ID,'first_name',AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_firstname)),array(0)));
if ( !empty($user->user_lastname))
 update_usermeta($user->ID,'last_name',AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_lastname)),array(0)));
if ( !empty($user->user_nickname))
 update_usermeta($user->ID,'nickname',AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_nickname)),array(0)));
if ( !empty($user->user_level))
 update_usermeta($user->ID,$wpdb->prefix . 'user_level',$user->user_level);
if ( !empty($user->user_icq))
 update_usermeta($user->ID,'icq',AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_icq)),array(0)));
if ( !empty($user->user_aim))
 update_usermeta($user->ID,'aim',AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_aim)),array(0)));
if ( !empty($user->user_msn))
 update_usermeta($user->ID,'msn',AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_msn)),array(0)));
if ( !empty($user->user_yim))
 update_usermeta($user->ID,'yim',AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_icq)),array(0)));
if ( !empty($user->user_description))
 update_usermeta($user->ID,'description',AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_description)),array(0)));
if ( isset($user->user_idmode))
 {$idmode = $user->user_idmode;
if ( $idmode == 'nickname')
 $id = $user->user_nickname;
if ( $idmode == 'login')
 $id = $user->user_login;
if ( $idmode == 'firstname')
 $id = $user->user_firstname;
if ( $idmode == 'lastname')
 $id = $user->user_lastname;
if ( $idmode == 'namefl')
 $id = $user->user_firstname . ' ' . $user->user_lastname;
if ( $idmode == 'namelf')
 $id = $user->user_lastname . ' ' . $user->user_firstname;
if ( !$idmode)
 $id = $user->user_nickname;
$wpdb->update($wpdb->users,array('display_name' => $id),array('ID' => $user->ID));
}$caps = get_usermeta($user->ID,$wpdb->prefix . 'capabilities');
if ( empty($caps) || defined('RESET_CAPS'))
 {$level = get_usermeta($user->ID,$wpdb->prefix . 'user_level');
$role = translate_level_to_role($level);
update_usermeta($user->ID,$wpdb->prefix . 'capabilities',array($role => true));
}}$old_user_fields = array('user_firstname','user_lastname','user_icq','user_aim','user_msn','user_yim','user_idmode','user_ip','user_domain','user_browser','user_description','user_nickname','user_level');
$wpdb->hide_errors();
foreach ( $old_user_fields as $old  )
$wpdb->query("ALTER TABLE $wpdb->users DROP $old");
$wpdb->show_errors();
$comments = $wpdb->get_results("SELECT comment_post_ID, COUNT(*) as c FROM $wpdb->comments WHERE comment_approved = '1' GROUP BY comment_post_ID");
if ( is_array($comments))
 foreach ( $comments as $comment  )
$wpdb->update($wpdb->posts,array('comment_count' => $comment->c),array('ID' => $comment->comment_post_ID));
if ( $wp_current_db_version > 2541 && $wp_current_db_version <= 3091)
 {$objects = $wpdb->get_results("SELECT ID, post_type FROM $wpdb->posts WHERE post_status = 'object'");
foreach ( $objects as $object  )
{$wpdb->update($wpdb->posts,array('post_status' => 'attachment','post_mime_type' => $object->post_type,'post_type' => ''),array('ID' => $object->ID));
$meta = get_post_meta($object->ID,'imagedata',true);
if ( !empty($meta['file']))
 update_attached_file($object->ID,$meta['file']);
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_current_db_version",$AspisChangesCache);
 }
function upgrade_210 (  ) {
{global $wpdb,$wp_current_db_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
}if ( $wp_current_db_version < 3506)
 {$posts = $wpdb->get_results("SELECT ID, post_status FROM $wpdb->posts");
if ( !empty($posts))
 foreach ( $posts as $post  )
{$status = $post->post_status;
$type = 'post';
if ( 'static' == $status)
 {$status = 'publish';
$type = 'page';
}else 
{if ( 'attachment' == $status)
 {$status = 'inherit';
$type = 'attachment';
}}$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET post_status = %s, post_type = %s WHERE ID = %d",$status,$type,$post->ID));
}}if ( $wp_current_db_version < 3845)
 {populate_roles_210();
}if ( $wp_current_db_version < 3531)
 {$now = gmdate('Y-m-d H:i:59');
$wpdb->query("UPDATE $wpdb->posts SET post_status = 'future' WHERE post_status = 'publish' AND post_date_gmt > '$now'");
$posts = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status ='future'");
if ( !empty($posts))
 foreach ( $posts as $post  )
wp_schedule_single_event(mysql2date('U',$post->post_date,false),'publish_future_post',array($post->ID));
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_current_db_version",$AspisChangesCache);
 }
function upgrade_230 (  ) {
{global $wp_current_db_version,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( $wp_current_db_version < 5200)
 {populate_roles_230();
}$tt_ids = array();
$have_tags = false;
$categories = $wpdb->get_results("SELECT * FROM $wpdb->categories ORDER BY cat_ID");
foreach ( $categories as $category  )
{$term_id = (int)$category->cat_ID;
$name = $category->cat_name;
$description = $category->category_description;
$slug = $category->category_nicename;
$parent = $category->category_parent;
$term_group = 0;
if ( $exists = $wpdb->get_results($wpdb->prepare("SELECT term_id, term_group FROM $wpdb->terms WHERE slug = %s",$slug)))
 {$term_group = $exists[0]->term_group;
$id = $exists[0]->term_id;
$num = 2;
do {$alt_slug = $slug . "-$num";
$num++;
$slug_check = $wpdb->get_var($wpdb->prepare("SELECT slug FROM $wpdb->terms WHERE slug = %s",$alt_slug));
}while ($slug_check )
;
$slug = $alt_slug;
if ( empty($term_group))
 {$term_group = $wpdb->get_var("SELECT MAX(term_group) FROM $wpdb->terms GROUP BY term_group") + 1;
$wpdb->query($wpdb->prepare("UPDATE $wpdb->terms SET term_group = %d WHERE term_id = %d",$term_group,$id));
}}$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->terms (term_id, name, slug, term_group) VALUES
		(%d, %s, %s, %d)",$term_id,$name,$slug,$term_group));
$count = 0;
if ( !empty($category->category_count))
 {$count = (int)$category->category_count;
$taxonomy = 'category';
$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->term_taxonomy (term_id, taxonomy, description, parent, count) VALUES ( %d, %s, %s, %d, %d)",$term_id,$taxonomy,$description,$parent,$count));
$tt_ids[$term_id][$taxonomy] = (int)$wpdb->insert_id;
}if ( !empty($category->link_count))
 {$count = (int)$category->link_count;
$taxonomy = 'link_category';
$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->term_taxonomy (term_id, taxonomy, description, parent, count) VALUES ( %d, %s, %s, %d, %d)",$term_id,$taxonomy,$description,$parent,$count));
$tt_ids[$term_id][$taxonomy] = (int)$wpdb->insert_id;
}if ( !empty($category->tag_count))
 {$have_tags = true;
$count = (int)$category->tag_count;
$taxonomy = 'post_tag';
$wpdb->insert($wpdb->term_taxonomy,compact('term_id','taxonomy','description','parent','count'));
$tt_ids[$term_id][$taxonomy] = (int)$wpdb->insert_id;
}if ( empty($count))
 {$count = 0;
$taxonomy = 'category';
$wpdb->insert($wpdb->term_taxonomy,compact('term_id','taxonomy','description','parent','count'));
$tt_ids[$term_id][$taxonomy] = (int)$wpdb->insert_id;
}}$select = 'post_id, category_id';
if ( $have_tags)
 $select .= ', rel_type';
$posts = $wpdb->get_results("SELECT $select FROM $wpdb->post2cat GROUP BY post_id, category_id");
foreach ( $posts as $post  )
{$post_id = (int)$post->post_id;
$term_id = (int)$post->category_id;
$taxonomy = 'category';
if ( !empty($post->rel_type) && 'tag' == $post->rel_type)
 $taxonomy = 'tag';
$tt_id = $tt_ids[$term_id][$taxonomy];
if ( empty($tt_id))
 continue ;
$wpdb->insert($wpdb->term_relationships,array('object_id' => $post_id,'term_taxonomy_id' => $tt_id));
}if ( $wp_current_db_version < 3570)
 {$link_cat_id_map = array();
$default_link_cat = 0;
$tt_ids = array();
$link_cats = $wpdb->get_results("SELECT cat_id, cat_name FROM " . $wpdb->prefix . 'linkcategories');
foreach ( $link_cats as $category  )
{$cat_id = (int)$category->cat_id;
$term_id = 0;
$name = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($category->cat_name)),array(0));
$slug = sanitize_title($name);
$term_group = 0;
if ( $exists = $wpdb->get_results($wpdb->prepare("SELECT term_id, term_group FROM $wpdb->terms WHERE slug = %s",$slug)))
 {$term_group = $exists[0]->term_group;
$term_id = $exists[0]->term_id;
}if ( empty($term_id))
 {$wpdb->insert($wpdb->terms,compact('name','slug','term_group'));
$term_id = (int)$wpdb->insert_id;
}$link_cat_id_map[$cat_id] = $term_id;
$default_link_cat = $term_id;
$wpdb->insert($wpdb->term_taxonomy,array('term_id' => $term_id,'taxonomy' => 'link_category','description' => '','parent' => 0,'count' => 0));
$tt_ids[$term_id] = (int)$wpdb->insert_id;
}$links = $wpdb->get_results("SELECT link_id, link_category FROM $wpdb->links");
if ( !empty($links))
 foreach ( $links as $link  )
{if ( 0 == $link->link_category)
 continue ;
if ( !isset($link_cat_id_map[$link->link_category]))
 continue ;
$term_id = $link_cat_id_map[$link->link_category];
$tt_id = $tt_ids[$term_id];
if ( empty($tt_id))
 continue ;
$wpdb->insert($wpdb->term_relationships,array('object_id' => $link->link_id,'term_taxonomy_id' => $tt_id));
}update_option('default_link_category',$default_link_cat);
}else 
{{$links = $wpdb->get_results("SELECT link_id, category_id FROM $wpdb->link2cat GROUP BY link_id, category_id");
foreach ( $links as $link  )
{$link_id = (int)$link->link_id;
$term_id = (int)$link->category_id;
$taxonomy = 'link_category';
$tt_id = $tt_ids[$term_id][$taxonomy];
if ( empty($tt_id))
 continue ;
$wpdb->insert($wpdb->term_relationships,array('object_id' => $link_id,'term_taxonomy_id' => $tt_id));
}}}if ( $wp_current_db_version < 4772)
 {$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'linkcategories');
}$terms = $wpdb->get_results("SELECT term_taxonomy_id, taxonomy FROM $wpdb->term_taxonomy");
foreach ( (array)$terms as $term  )
{if ( ('post_tag' == $term->taxonomy) || ('category' == $term->taxonomy))
 $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->term_relationships, $wpdb->posts WHERE $wpdb->posts.ID = $wpdb->term_relationships.object_id AND post_status = 'publish' AND post_type = 'post' AND term_taxonomy_id = %d",$term->term_taxonomy_id));
else 
{$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d",$term->term_taxonomy_id));
}$wpdb->update($wpdb->term_taxonomy,array('count' => $count),array('term_taxonomy_id' => $term->term_taxonomy_id));
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
function upgrade_230_options_table (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$old_options_fields = array('option_can_override','option_type','option_width','option_height','option_description','option_admin_level');
$wpdb->hide_errors();
foreach ( $old_options_fields as $old  )
$wpdb->query("ALTER TABLE $wpdb->options DROP $old");
$wpdb->show_errors();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function upgrade_230_old_tables (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'categories');
$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'link2cat');
$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'post2cat');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function upgrade_old_slugs (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$wpdb->query("UPDATE $wpdb->postmeta SET meta_key = '_wp_old_slug' WHERE meta_key = 'old_slug'");
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function upgrade_250 (  ) {
{global $wp_current_db_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
}if ( $wp_current_db_version < 6689)
 {populate_roles_250();
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
 }
function upgrade_251 (  ) {
{global $wp_current_db_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
}update_option('secret',wp_generate_password(64));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
 }
function upgrade_252 (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$wpdb->query("UPDATE $wpdb->users SET user_activation_key = ''");
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function upgrade_260 (  ) {
{global $wp_current_db_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
}if ( $wp_current_db_version < 8000)
 populate_roles_260();
if ( $wp_current_db_version < 8201)
 {update_option('enable_app',1);
update_option('enable_xmlrpc',1);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
 }
function upgrade_270 (  ) {
{global $wpdb,$wp_current_db_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
}if ( $wp_current_db_version < 8980)
 populate_roles_270();
if ( $wp_current_db_version < 8921)
 $wpdb->query("UPDATE $wpdb->posts SET post_date = post_modified WHERE post_date = '0000-00-00 00:00:00'");
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_current_db_version",$AspisChangesCache);
 }
function upgrade_280 (  ) {
{global $wp_current_db_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
}if ( $wp_current_db_version < 10360)
 populate_roles_280();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
 }
function upgrade_290 (  ) {
{global $wp_current_db_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
}if ( $wp_current_db_version < 11958)
 {if ( get_option('thread_comments_depth') == '1')
 {update_option('thread_comments_depth',2);
update_option('thread_comments',0);
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
 }
function maybe_create_table ( $table_name,$create_ddl ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name)
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$q = $wpdb->query($create_ddl);
if ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name)
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function drop_index ( $table,$index ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$wpdb->hide_errors();
$wpdb->query("ALTER TABLE `$table` DROP INDEX `$index`");
for ( $i = 0 ; $i < 25 ; $i++ )
{$wpdb->query("ALTER TABLE `$table` DROP INDEX `{$index}_$i`");
}$wpdb->show_errors();
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function add_clean_index ( $table,$index ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}drop_index($table,$index);
$wpdb->query("ALTER TABLE `$table` ADD INDEX ( `$index` )");
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function maybe_add_column ( $table_name,$column_name,$create_ddl ) {
{global $wpdb,$debug;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($debug,"\$debug",$AspisChangesCache);
}foreach ( $wpdb->get_col("DESC $table_name",0) as $column  )
{if ( $debug)
 echo ("checking $column == $column_name<br />");
if ( $column == $column_name)
 {{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}}}$q = $wpdb->query($create_ddl);
foreach ( $wpdb->get_col("DESC $table_name",0) as $column  )
{if ( $column == $column_name)
 {{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$debug",$AspisChangesCache);
 }
function get_alloptions_110 (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( $options = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options"))
 {foreach ( $options as $option  )
{if ( 'siteurl' == $option->option_name)
 $option->option_value = preg_replace('|/+$|','',$option->option_value);
if ( 'home' == $option->option_name)
 $option->option_value = preg_replace('|/+$|','',$option->option_value);
if ( 'category_base' == $option->option_name)
 $option->option_value = preg_replace('|/+$|','',$option->option_value);
$all_options->{$option->option_name} = stripslashes($option->option_value);
}}{$AspisRetTemp = $all_options;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function __get_option ( $setting ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( $setting == 'home' && defined('WP_HOME'))
 {{$AspisRetTemp = preg_replace('|/+$|','',constant('WP_HOME'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}if ( $setting == 'siteurl' && defined('WP_SITEURL'))
 {{$AspisRetTemp = preg_replace('|/+$|','',constant('WP_SITEURL'));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}$option = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM $wpdb->options WHERE option_name = %s",$setting));
if ( 'home' == $setting && '' == $option)
 {$AspisRetTemp = __get_option('siteurl');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( 'siteurl' == $setting || 'home' == $setting || 'category_base' == $setting)
 $option = preg_replace('|/+$|','',$option);
@$kellogs = AspisUntainted_unserialize($option);
if ( $kellogs !== FALSE)
 {$AspisRetTemp = $kellogs;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = $option;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function deslash ( $content ) {
$content = preg_replace("/\\\+'/","'",$content);
$content = preg_replace('/\\\+"/','"',$content);
$content = preg_replace("/\\\+/","\\",$content);
{$AspisRetTemp = $content;
return $AspisRetTemp;
} }
function dbDelta ( $queries,$execute = true ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( !is_array($queries))
 {$queries = explode(';',$queries);
if ( '' == $queries[count($queries) - 1])
 array_pop($queries);
}$cqueries = array();
$iqueries = array();
$for_update = array();
foreach ( $queries as $qry  )
{if ( preg_match("|CREATE TABLE ([^ ]*)|",$qry,$matches))
 {$cqueries[trim(strtolower($matches[1]),'`')] = $qry;
$for_update[$matches[1]] = 'Created table ' . $matches[1];
}else 
{if ( preg_match("|CREATE DATABASE ([^ ]*)|",$qry,$matches))
 {array_unshift($cqueries,$qry);
}else 
{if ( preg_match("|INSERT INTO ([^ ]*)|",$qry,$matches))
 {$iqueries[] = $qry;
}else 
{if ( preg_match("|UPDATE ([^ ]*)|",$qry,$matches))
 {$iqueries[] = $qry;
}else 
{{}}}}}}if ( $tables = $wpdb->get_col('SHOW TABLES;'))
 {foreach ( $tables as $table  )
{if ( array_key_exists(strtolower($table),$cqueries))
 {unset($cfields);
unset($indices);
preg_match("|\((.*)\)|ms",$cqueries[strtolower($table)],$match2);
$qryline = trim($match2[1]);
$flds = explode("\n",$qryline);
foreach ( $flds as $fld  )
{preg_match("|^([^ ]*)|",trim($fld),$fvals);
$fieldname = trim($fvals[1],'`');
$validfield = true;
switch ( strtolower($fieldname) ) {
case '':case 'primary':case 'index':case 'fulltext':case 'unique':case 'key':$validfield = false;
$indices[] = trim(trim($fld),", \n");
break ;
 }
$fld = trim($fld);
if ( $validfield)
 {$cfields[strtolower($fieldname)] = trim($fld,", \n");
}}$tablefields = $wpdb->get_results("DESCRIBE {$table};
");
foreach ( $tablefields as $tablefield  )
{if ( array_key_exists(strtolower($tablefield->Field),$cfields))
 {preg_match("|" . $tablefield->Field . " ([^ ]*( unsigned)?)|i",$cfields[strtolower($tablefield->Field)],$matches);
$fieldtype = $matches[1];
if ( $tablefield->Type != $fieldtype)
 {$cqueries[] = "ALTER TABLE {$table} CHANGE COLUMN {$tablefield->Field} " . $cfields[strtolower($tablefield->Field)];
$for_update[$table . '.' . $tablefield->Field] = "Changed type of {$table}.{$tablefield->Field} from {$tablefield->Type} to {$fieldtype}";
}if ( preg_match("| DEFAULT '(.*)'|i",$cfields[strtolower($tablefield->Field)],$matches))
 {$default_value = $matches[1];
if ( $tablefield->Default != $default_value)
 {$cqueries[] = "ALTER TABLE {$table} ALTER COLUMN {$tablefield->Field} SET DEFAULT '{$default_value}'";
$for_update[$table . '.' . $tablefield->Field] = "Changed default value of {$table}.{$tablefield->Field} from {$tablefield->Default} to {$default_value}";
}}unset($cfields[strtolower($tablefield->Field)]);
}else 
{{}}}foreach ( $cfields as $fieldname =>$fielddef )
{$cqueries[] = "ALTER TABLE {$table} ADD COLUMN $fielddef";
$for_update[$table . '.' . $fieldname] = 'Added column ' . $table . '.' . $fieldname;
}$tableindices = $wpdb->get_results("SHOW INDEX FROM {$table};
");
if ( $tableindices)
 {unset($index_ary);
foreach ( $tableindices as $tableindex  )
{$keyname = $tableindex->Key_name;
$index_ary[$keyname]['columns'][] = array('fieldname' => $tableindex->Column_name,'subpart' => $tableindex->Sub_part);
$index_ary[$keyname]['unique'] = ($tableindex->Non_unique == 0) ? true : false;
}foreach ( $index_ary as $index_name =>$index_data )
{$index_string = '';
if ( $index_name == 'PRIMARY')
 {$index_string .= 'PRIMARY ';
}else 
{if ( $index_data['unique'])
 {$index_string .= 'UNIQUE ';
}}$index_string .= 'KEY ';
if ( $index_name != 'PRIMARY')
 {$index_string .= $index_name;
}$index_columns = '';
foreach ( $index_data['columns'] as $column_data  )
{if ( $index_columns != '')
 $index_columns .= ',';
$index_columns .= $column_data['fieldname'];
if ( $column_data['subpart'] != '')
 {$index_columns .= '(' . $column_data['subpart'] . ')';
}}$index_string .= ' (' . $index_columns . ')';
if ( !(($aindex = array_search($index_string,$indices)) === false))
 {unset($indices[$aindex]);
}}}foreach ( (array)$indices as $index  )
{$cqueries[] = "ALTER TABLE {$table} ADD $index";
$for_update[$table . '.' . $fieldname] = 'Added index ' . $table . ' ' . $index;
}unset($cqueries[strtolower($table)]);
unset($for_update[strtolower($table)]);
}else 
{{}}}}$allqueries = array_merge($cqueries,$iqueries);
if ( $execute)
 {foreach ( $allqueries as $query  )
{$wpdb->query($query);
}}{$AspisRetTemp = $for_update;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function make_db_current (  ) {
{global $wp_queries;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_queries,"\$wp_queries",$AspisChangesCache);
}$alterations = dbDelta($wp_queries);
echo "<ol>\n";
foreach ( $alterations as $alteration  )
echo "<li>$alteration</li>\n";
echo "</ol>\n";
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_queries",$AspisChangesCache);
 }
function make_db_current_silent (  ) {
{global $wp_queries;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_queries,"\$wp_queries",$AspisChangesCache);
}$alterations = dbDelta($wp_queries);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_queries",$AspisChangesCache);
 }
function make_site_theme_from_oldschool ( $theme_name,$template ) {
$home_path = get_home_path();
$site_dir = WP_CONTENT_DIR . "/themes/$template";
if ( !file_exists("$home_path/index.php"))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$files = array('index.php' => 'index.php','wp-layout.css' => 'style.css','wp-comments.php' => 'comments.php','wp-comments-popup.php' => 'comments-popup.php');
foreach ( $files as $oldfile =>$newfile )
{if ( $oldfile == 'index.php')
 $oldpath = $home_path;
else 
{$oldpath = ABSPATH;
}if ( $oldfile == 'index.php')
 {$index = implode('',file("$oldpath/$oldfile"));
if ( strpos($index,'WP_USE_THEMES') !== false)
 {if ( !@copy(WP_CONTENT_DIR . '/themes/default/index.php',"$site_dir/$newfile"))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}continue ;
}}if ( !@copy("$oldpath/$oldfile","$site_dir/$newfile"))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}chmod("$site_dir/$newfile",0777);
$lines = explode("\n",implode('',file("$site_dir/$newfile")));
if ( $lines)
 {$f = fopen("$site_dir/$newfile",'w');
foreach ( $lines as $line  )
{if ( preg_match('/require.*wp-blog-header/',$line))
 $line = '//' . $line;
$line = str_replace("<?php echo __get_option('siteurl'); ?>/wp-layout.css","<?php bloginfo('stylesheet_url'); ?>",$line);
$line = str_replace("<?php include(ABSPATH . 'wp-comments.php'); ?>","<?php comments_template(); ?>",$line);
fwrite($f,"{$line}\n");
}fclose($f);
}}$header = "/*\nTheme Name: $theme_name\nTheme URI: " . __get_option('siteurl') . "\nDescription: A theme automatically created by the upgrade.\nVersion: 1.0\nAuthor: Moi\n*/\n";
$stylelines = file_get_contents("$site_dir/style.css");
if ( $stylelines)
 {$f = fopen("$site_dir/style.css",'w');
fwrite($f,$header);
fwrite($f,$stylelines);
fclose($f);
}{$AspisRetTemp = true;
return $AspisRetTemp;
} }
function make_site_theme_from_default ( $theme_name,$template ) {
$site_dir = WP_CONTENT_DIR . "/themes/$template";
$default_dir = WP_CONTENT_DIR . '/themes/default';
$theme_dir = @opendir("$default_dir");
if ( $theme_dir)
 {while ( ($theme_file = readdir($theme_dir)) !== false )
{if ( is_dir("$default_dir/$theme_file"))
 continue ;
if ( !@copy("$default_dir/$theme_file","$site_dir/$theme_file"))
 {return ;
}chmod("$site_dir/$theme_file",0777);
}}@closedir($theme_dir);
$stylelines = explode("\n",implode('',file("$site_dir/style.css")));
if ( $stylelines)
 {$f = fopen("$site_dir/style.css",'w');
foreach ( $stylelines as $line  )
{if ( strpos($line,'Theme Name:') !== false)
 $line = 'Theme Name: ' . $theme_name;
elseif ( strpos($line,'Theme URI:') !== false)
 $line = 'Theme URI: ' . __get_option('url');
elseif ( strpos($line,'Description:') !== false)
 $line = 'Description: Your theme.';
elseif ( strpos($line,'Version:') !== false)
 $line = 'Version: 1';
elseif ( strpos($line,'Author:') !== false)
 $line = 'Author: You';
fwrite($f,$line . "\n");
}fclose($f);
}umask(0);
if ( !mkdir("$site_dir/images",0777))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$images_dir = @opendir("$default_dir/images");
if ( $images_dir)
 {while ( ($image = readdir($images_dir)) !== false )
{if ( is_dir("$default_dir/images/$image"))
 continue ;
if ( !@copy("$default_dir/images/$image","$site_dir/images/$image"))
 {return ;
}chmod("$site_dir/images/$image",0777);
}}@closedir($images_dir);
 }
function make_site_theme (  ) {
$theme_name = __get_option('blogname');
$template = sanitize_title($theme_name);
$site_dir = WP_CONTENT_DIR . "/themes/$template";
if ( is_dir($site_dir))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( !is_writable(WP_CONTENT_DIR . "/themes"))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}umask(0);
if ( !mkdir($site_dir,0777))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( file_exists(ABSPATH . 'wp-layout.css'))
 {if ( !make_site_theme_from_oldschool($theme_name,$template))
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}}else 
{{if ( !make_site_theme_from_default($theme_name,$template))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}}}$current_template = __get_option('template');
if ( $current_template == 'default')
 {update_option('template',$template);
update_option('stylesheet',$template);
}{$AspisRetTemp = $template;
return $AspisRetTemp;
} }
function translate_level_to_role ( $level ) {
switch ( $level ) {
case 10:case 9:case 8:{$AspisRetTemp = 'administrator';
return $AspisRetTemp;
}case 7:case 6:case 5:{$AspisRetTemp = 'editor';
return $AspisRetTemp;
}case 4:case 3:case 2:{$AspisRetTemp = 'author';
return $AspisRetTemp;
}case 1:{$AspisRetTemp = 'contributor';
return $AspisRetTemp;
}case 0:{$AspisRetTemp = 'subscriber';
return $AspisRetTemp;
} }
 }
function wp_check_mysql_version (  ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$result = $wpdb->check_database_version();
if ( is_wp_error($result))
 exit($result->get_error_message());
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function maybe_disable_automattic_widgets (  ) {
$plugins = __get_option('active_plugins');
foreach ( (array)$plugins as $plugin  )
{if ( basename($plugin) == 'widgets.php')
 {array_splice($plugins,array_search($plugin,$plugins),1);
update_option('active_plugins',$plugins);
break ;
}} }
function pre_schema_upgrade (  ) {
{global $wp_current_db_version,$wp_db_version,$wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_current_db_version,"\$wp_current_db_version",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_db_version,"\$wp_db_version",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
}if ( $wp_current_db_version < 11557)
 {$wpdb->query("DELETE o1 FROM $wpdb->options AS o1 JOIN $wpdb->options AS o2 USING (`option_name`) WHERE o2.option_id > o1.option_id");
$wpdb->query("ALTER TABLE $wpdb->options DROP PRIMARY KEY, ADD PRIMARY KEY(option_id)");
$wpdb->query("ALTER TABLE $wpdb->options DROP INDEX option_name");
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_current_db_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_db_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wpdb",$AspisChangesCache);
 }
;
?>
<?php 