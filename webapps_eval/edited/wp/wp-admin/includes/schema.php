<?php require_once('AspisMain.php'); ?><?php
$charset_collate = array('',false);
global $wpdb,$wp_queries;
if ( (!((empty($wpdb[0]->charset) || Aspis_empty( $wpdb[0] ->charset )))))
 $charset_collate = concat1("DEFAULT CHARACTER SET ",$wpdb[0]->charset);
if ( (!((empty($wpdb[0]->collate) || Aspis_empty( $wpdb[0] ->collate )))))
 $charset_collate = concat($charset_collate,concat1(" COLLATE ",$wpdb[0]->collate));
$wp_queries = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("CREATE TABLE ",$wpdb[0]->terms)," (
 term_id bigint(20) unsigned NOT NULL auto_increment,
 name varchar(200) NOT NULL default '',
 slug varchar(200) NOT NULL default '',
 term_group bigint(10) NOT NULL default 0,
 PRIMARY KEY  (term_id),
 UNIQUE KEY slug (slug),
 KEY name (name)
) "),$charset_collate),";
CREATE TABLE "),$wpdb[0]->term_taxonomy)," (
 term_taxonomy_id bigint(20) unsigned NOT NULL auto_increment,
 term_id bigint(20) unsigned NOT NULL default 0,
 taxonomy varchar(32) NOT NULL default '',
 description longtext NOT NULL,
 parent bigint(20) unsigned NOT NULL default 0,
 count bigint(20) NOT NULL default 0,
 PRIMARY KEY  (term_taxonomy_id),
 UNIQUE KEY term_id_taxonomy (term_id,taxonomy),
 KEY taxonomy (taxonomy)
) "),$charset_collate),";
CREATE TABLE "),$wpdb[0]->term_relationships)," (
 object_id bigint(20) unsigned NOT NULL default 0,
 term_taxonomy_id bigint(20) unsigned NOT NULL default 0,
 term_order int(11) NOT NULL default 0,
 PRIMARY KEY  (object_id,term_taxonomy_id),
 KEY term_taxonomy_id (term_taxonomy_id)
) "),$charset_collate),";
CREATE TABLE "),$wpdb[0]->commentmeta)," (
  meta_id bigint(20) unsigned NOT NULL auto_increment,
  comment_id bigint(20) unsigned NOT NULL default '0',
  meta_key varchar(255) default NULL,
  meta_value longtext,
  PRIMARY KEY  (meta_id),
  KEY comment_id (comment_id),
  KEY meta_key (meta_key)
) "),$charset_collate),";
CREATE TABLE "),$wpdb[0]->comments)," (
  comment_ID bigint(20) unsigned NOT NULL auto_increment,
  comment_post_ID bigint(20) unsigned NOT NULL default '0',
  comment_author tinytext NOT NULL,
  comment_author_email varchar(100) NOT NULL default '',
  comment_author_url varchar(200) NOT NULL default '',
  comment_author_IP varchar(100) NOT NULL default '',
  comment_date datetime NOT NULL default '0000-00-00 00:00:00',
  comment_date_gmt datetime NOT NULL default '0000-00-00 00:00:00',
  comment_content text NOT NULL,
  comment_karma int(11) NOT NULL default '0',
  comment_approved varchar(20) NOT NULL default '1',
  comment_agent varchar(255) NOT NULL default '',
  comment_type varchar(20) NOT NULL default '',
  comment_parent bigint(20) unsigned NOT NULL default '0',
  user_id bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (comment_ID),
  KEY comment_approved (comment_approved),
  KEY comment_post_ID (comment_post_ID),
  KEY comment_approved_date_gmt (comment_approved,comment_date_gmt),
  KEY comment_date_gmt (comment_date_gmt)
) "),$charset_collate),";
CREATE TABLE "),$wpdb[0]->links)," (
  link_id bigint(20) unsigned NOT NULL auto_increment,
  link_url varchar(255) NOT NULL default '',
  link_name varchar(255) NOT NULL default '',
  link_image varchar(255) NOT NULL default '',
  link_target varchar(25) NOT NULL default '',
  link_description varchar(255) NOT NULL default '',
  link_visible varchar(20) NOT NULL default 'Y',
  link_owner bigint(20) unsigned NOT NULL default '1',
  link_rating int(11) NOT NULL default '0',
  link_updated datetime NOT NULL default '0000-00-00 00:00:00',
  link_rel varchar(255) NOT NULL default '',
  link_notes mediumtext NOT NULL,
  link_rss varchar(255) NOT NULL default '',
  PRIMARY KEY  (link_id),
  KEY link_visible (link_visible)
) "),$charset_collate),";
CREATE TABLE "),$wpdb[0]->options)," (
  option_id bigint(20) unsigned NOT NULL auto_increment,
  blog_id int(11) NOT NULL default '0',
  option_name varchar(64) NOT NULL default '',
  option_value longtext NOT NULL,
  autoload varchar(20) NOT NULL default 'yes',
  PRIMARY KEY  (option_id),
  UNIQUE KEY option_name (option_name)
) "),$charset_collate),";
CREATE TABLE "),$wpdb[0]->postmeta)," (
  meta_id bigint(20) unsigned NOT NULL auto_increment,
  post_id bigint(20) unsigned NOT NULL default '0',
  meta_key varchar(255) default NULL,
  meta_value longtext,
  PRIMARY KEY  (meta_id),
  KEY post_id (post_id),
  KEY meta_key (meta_key)
) "),$charset_collate),";
CREATE TABLE "),$wpdb[0]->posts)," (
  ID bigint(20) unsigned NOT NULL auto_increment,
  post_author bigint(20) unsigned NOT NULL default '0',
  post_date datetime NOT NULL default '0000-00-00 00:00:00',
  post_date_gmt datetime NOT NULL default '0000-00-00 00:00:00',
  post_content longtext NOT NULL,
  post_title text NOT NULL,
  post_excerpt text NOT NULL,
  post_status varchar(20) NOT NULL default 'publish',
  comment_status varchar(20) NOT NULL default 'open',
  ping_status varchar(20) NOT NULL default 'open',
  post_password varchar(20) NOT NULL default '',
  post_name varchar(200) NOT NULL default '',
  to_ping text NOT NULL,
  pinged text NOT NULL,
  post_modified datetime NOT NULL default '0000-00-00 00:00:00',
  post_modified_gmt datetime NOT NULL default '0000-00-00 00:00:00',
  post_content_filtered text NOT NULL,
  post_parent bigint(20) unsigned NOT NULL default '0',
  guid varchar(255) NOT NULL default '',
  menu_order int(11) NOT NULL default '0',
  post_type varchar(20) NOT NULL default 'post',
  post_mime_type varchar(100) NOT NULL default '',
  comment_count bigint(20) NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY post_name (post_name),
  KEY type_status_date (post_type,post_status,post_date,ID),
  KEY post_parent (post_parent)
) "),$charset_collate),";
CREATE TABLE "),$wpdb[0]->users)," (
  ID bigint(20) unsigned NOT NULL auto_increment,
  user_login varchar(60) NOT NULL default '',
  user_pass varchar(64) NOT NULL default '',
  user_nicename varchar(50) NOT NULL default '',
  user_email varchar(100) NOT NULL default '',
  user_url varchar(100) NOT NULL default '',
  user_registered datetime NOT NULL default '0000-00-00 00:00:00',
  user_activation_key varchar(60) NOT NULL default '',
  user_status int(11) NOT NULL default '0',
  display_name varchar(250) NOT NULL default '',
  PRIMARY KEY  (ID),
  KEY user_login_key (user_login),
  KEY user_nicename (user_nicename)
) "),$charset_collate),";
CREATE TABLE "),$wpdb[0]->usermeta)," (
  umeta_id bigint(20) unsigned NOT NULL auto_increment,
  user_id bigint(20) unsigned NOT NULL default '0',
  meta_key varchar(255) default NULL,
  meta_value longtext,
  PRIMARY KEY  (umeta_id),
  KEY user_id (user_id),
  KEY meta_key (meta_key)
) "),$charset_collate),";");
function populate_options (  ) {
global $wpdb,$wp_db_version;
$guessurl = wp_guess_url();
do_action(array('populate_options',false));
if ( (ini_get('safe_mode')))
 {$uploads_use_yearmonth_folders = array(0,false);
}else 
{{$uploads_use_yearmonth_folders = array(1,false);
}}$options = array(array(deregisterTaint(array('siteurl',false)) => addTaint($guessurl),deregisterTaint(array('blogname',false)) => addTaint(__(array('My Blog',false))),deregisterTaint(array('blogdescription',false)) => addTaint(__(array('Just another WordPress weblog',false))),'users_can_register' => array(0,false,false),'admin_email' => array('you@example.com',false,false),'start_of_week' => array(1,false,false),'use_balanceTags' => array(0,false,false),'use_smilies' => array(1,false,false),'require_name_email' => array(1,false,false),'comments_notify' => array(1,false,false),'posts_per_rss' => array(10,false,false),'rss_use_excerpt' => array(0,false,false),'mailserver_url' => array('mail.example.com',false,false),'mailserver_login' => array('login@example.com',false,false),'mailserver_pass' => array('password',false,false),'mailserver_port' => array(110,false,false),'default_category' => array(1,false,false),'default_comment_status' => array('open',false,false),'default_ping_status' => array('open',false,false),'default_pingback_flag' => array(1,false,false),'default_post_edit_rows' => array(10,false,false),'posts_per_page' => array(10,false,false),deregisterTaint(array('date_format',false)) => addTaint(__(array('F j, Y',false))),deregisterTaint(array('time_format',false)) => addTaint(__(array('g:i a',false))),deregisterTaint(array('links_updated_date_format',false)) => addTaint(__(array('F j, Y g:i a',false))),'links_recently_updated_prepend' => array('<em>',false,false),'links_recently_updated_append' => array('</em>',false,false),'links_recently_updated_time' => array(120,false,false),'comment_moderation' => array(0,false,false),'moderation_notify' => array(1,false,false),'permalink_structure' => array('',false,false),'gzipcompression' => array(0,false,false),'hack_file' => array(0,false,false),'blog_charset' => array('UTF-8',false,false),'moderation_keys' => array('',false,false),'active_plugins' => array(array(),false,false),deregisterTaint(array('home',false)) => addTaint($guessurl),'category_base' => array('',false,false),'ping_sites' => array('http://rpc.pingomatic.com/',false,false),'advanced_edit' => array(0,false,false),'comment_max_links' => array(2,false,false),'gmt_offset' => array(date(('Z')) / (3600),false,false),'default_email_category' => array(1,false,false),'recently_edited' => array('',false,false),'use_linksupdate' => array(0,false,false),'template' => array('default',false,false),'stylesheet' => array('default',false,false),'comment_whitelist' => array(1,false,false),'blacklist_keys' => array('',false,false),'comment_registration' => array(0,false,false),'rss_language' => array('en',false,false),'html_type' => array('text/html',false,false),'use_trackback' => array(0,false,false),'default_role' => array('subscriber',false,false),deregisterTaint(array('db_version',false)) => addTaint($wp_db_version),deregisterTaint(array('uploads_use_yearmonth_folders',false)) => addTaint($uploads_use_yearmonth_folders),'upload_path' => array('',false,false),deregisterTaint(array('secret',false)) => addTaint(wp_generate_password(array(64,false))),'blog_public' => array('1',false,false),'default_link_category' => array(2,false,false),'show_on_front' => array('posts',false,false),'tag_base' => array('',false,false),'show_avatars' => array('1',false,false),'avatar_rating' => array('G',false,false),'upload_url_path' => array('',false,false),'thumbnail_size_w' => array(150,false,false),'thumbnail_size_h' => array(150,false,false),'thumbnail_crop' => array(1,false,false),'medium_size_w' => array(300,false,false),'medium_size_h' => array(300,false,false),'avatar_default' => array('mystery',false,false),'enable_app' => array(0,false,false),'enable_xmlrpc' => array(0,false,false),'large_size_w' => array(1024,false,false),'large_size_h' => array(1024,false,false),'image_default_link_type' => array('file',false,false),'image_default_size' => array('',false,false),'image_default_align' => array('',false,false),'close_comments_for_old_posts' => array(0,false,false),'close_comments_days_old' => array(14,false,false),'thread_comments' => array(0,false,false),'thread_comments_depth' => array(5,false,false),'page_comments' => array(1,false,false),'comments_per_page' => array(50,false,false),'default_comments_page' => array('newest',false,false),'comment_order' => array('asc',false,false),'sticky_posts' => array(array(),false,false),'widget_categories' => array(array(),false,false),'widget_text' => array(array(),false,false),'widget_rss' => array(array(),false,false),'timezone_string' => array('',false,false),'embed_autourls' => array(1,false,false),'embed_size_w' => array('',false,false),'embed_size_h' => array(600,false,false),),false);
$fat_options = array(array(array('moderation_keys',false),array('recently_edited',false),array('blacklist_keys',false)),false);
$existing_options = $wpdb[0]->get_col(concat1("SELECT option_name FROM ",$wpdb[0]->options));
$insert = array('',false);
foreach ( $options[0] as $option =>$value )
{restoreTaint($option,$value);
{if ( deAspis(Aspis_in_array($option,$existing_options)))
 continue ;
if ( deAspis(Aspis_in_array($option,$fat_options)))
 $autoload = array('no',false);
else 
{$autoload = array('yes',false);
}$option = $wpdb[0]->escape($option);
if ( is_array($value[0]))
 $value = Aspis_serialize($value);
$value = $wpdb[0]->escape($value);
if ( (!((empty($insert) || Aspis_empty( $insert)))))
 $insert = concat2($insert,', ');
$insert = concat($insert,concat2(concat(concat2(concat(concat2(concat1("('",$option),"', '"),$value),"', '"),$autoload),"')"));
}}if ( (!((empty($insert) || Aspis_empty( $insert)))))
 $wpdb[0]->query(concat(concat2(concat1("INSERT INTO ",$wpdb[0]->options)," (option_name, option_value, autoload) VALUES "),$insert));
if ( (denot_boolean(__get_option(array('home',false)))))
 update_option(array('home',false),$guessurl);
$unusedoptions = array(array(array('blodotgsping_url',false),array('bodyterminator',false),array('emailtestonly',false),array('phoneemail_separator',false),array('smilies_directory',false),array('subjectprefix',false),array('use_bbcode',false),array('use_blodotgsping',false),array('use_phoneemail',false),array('use_quicktags',false),array('use_weblogsping',false),array('weblogs_cache_file',false),array('use_preview',false),array('use_htmltrans',false),array('smilies_directory',false),array('fileupload_allowedusers',false),array('use_phoneemail',false),array('default_post_status',false),array('default_post_category',false),array('archive_mode',false),array('time_difference',false),array('links_minadminlevel',false),array('links_use_adminlevels',false),array('links_rating_type',false),array('links_rating_char',false),array('links_rating_ignore_zero',false),array('links_rating_single_image',false),array('links_rating_image0',false),array('links_rating_image1',false),array('links_rating_image2',false),array('links_rating_image3',false),array('links_rating_image4',false),array('links_rating_image5',false),array('links_rating_image6',false),array('links_rating_image7',false),array('links_rating_image8',false),array('links_rating_image9',false),array('weblogs_cacheminutes',false),array('comment_allowed_tags',false),array('search_engine_friendly_urls',false),array('default_geourl_lat',false),array('default_geourl_lon',false),array('use_default_geourl',false),array('weblogs_xml_url',false),array('new_users_can_blog',false),array('_wpnonce',false),array('_wp_http_referer',false),array('Update',false),array('action',false),array('rich_editing',false),array('autosave_interval',false),array('deactivated_plugins',false),array('can_compress_scripts',false),array('page_uris',false),array('update_core',false),array('update_plugins',false),array('update_themes',false),array('doing_cron',false),array('random_seed',false),array('rss_excerpt_length',false)),false);
foreach ( $unusedoptions[0] as $option  )
delete_option($option);
$wpdb[0]->query(concat2(concat1("DELETE FROM ",$wpdb[0]->options)," WHERE option_name REGEXP '^rss_[0-9a-f]{32}(_ts)?$'"));
 }
function populate_roles (  ) {
populate_roles_160();
populate_roles_210();
populate_roles_230();
populate_roles_250();
populate_roles_260();
populate_roles_270();
populate_roles_280();
 }
function populate_roles_160 (  ) {
_x(array('Administrator',false),array('User role',false));
_x(array('Editor',false),array('User role',false));
_x(array('Author',false),array('User role',false));
_x(array('Contributor',false),array('User role',false));
_x(array('Subscriber',false),array('User role',false));
add_role(array('administrator',false),array('Administrator',false));
add_role(array('editor',false),array('Editor',false));
add_role(array('author',false),array('Author',false));
add_role(array('contributor',false),array('Contributor',false));
add_role(array('subscriber',false),array('Subscriber',false));
$role = &get_role(array('administrator',false));
$role[0]->add_cap(array('switch_themes',false));
$role[0]->add_cap(array('edit_themes',false));
$role[0]->add_cap(array('activate_plugins',false));
$role[0]->add_cap(array('edit_plugins',false));
$role[0]->add_cap(array('edit_users',false));
$role[0]->add_cap(array('edit_files',false));
$role[0]->add_cap(array('manage_options',false));
$role[0]->add_cap(array('moderate_comments',false));
$role[0]->add_cap(array('manage_categories',false));
$role[0]->add_cap(array('manage_links',false));
$role[0]->add_cap(array('upload_files',false));
$role[0]->add_cap(array('import',false));
$role[0]->add_cap(array('unfiltered_html',false));
$role[0]->add_cap(array('edit_posts',false));
$role[0]->add_cap(array('edit_others_posts',false));
$role[0]->add_cap(array('edit_published_posts',false));
$role[0]->add_cap(array('publish_posts',false));
$role[0]->add_cap(array('edit_pages',false));
$role[0]->add_cap(array('read',false));
$role[0]->add_cap(array('level_10',false));
$role[0]->add_cap(array('level_9',false));
$role[0]->add_cap(array('level_8',false));
$role[0]->add_cap(array('level_7',false));
$role[0]->add_cap(array('level_6',false));
$role[0]->add_cap(array('level_5',false));
$role[0]->add_cap(array('level_4',false));
$role[0]->add_cap(array('level_3',false));
$role[0]->add_cap(array('level_2',false));
$role[0]->add_cap(array('level_1',false));
$role[0]->add_cap(array('level_0',false));
$role = &get_role(array('editor',false));
$role[0]->add_cap(array('moderate_comments',false));
$role[0]->add_cap(array('manage_categories',false));
$role[0]->add_cap(array('manage_links',false));
$role[0]->add_cap(array('upload_files',false));
$role[0]->add_cap(array('unfiltered_html',false));
$role[0]->add_cap(array('edit_posts',false));
$role[0]->add_cap(array('edit_others_posts',false));
$role[0]->add_cap(array('edit_published_posts',false));
$role[0]->add_cap(array('publish_posts',false));
$role[0]->add_cap(array('edit_pages',false));
$role[0]->add_cap(array('read',false));
$role[0]->add_cap(array('level_7',false));
$role[0]->add_cap(array('level_6',false));
$role[0]->add_cap(array('level_5',false));
$role[0]->add_cap(array('level_4',false));
$role[0]->add_cap(array('level_3',false));
$role[0]->add_cap(array('level_2',false));
$role[0]->add_cap(array('level_1',false));
$role[0]->add_cap(array('level_0',false));
$role = &get_role(array('author',false));
$role[0]->add_cap(array('upload_files',false));
$role[0]->add_cap(array('edit_posts',false));
$role[0]->add_cap(array('edit_published_posts',false));
$role[0]->add_cap(array('publish_posts',false));
$role[0]->add_cap(array('read',false));
$role[0]->add_cap(array('level_2',false));
$role[0]->add_cap(array('level_1',false));
$role[0]->add_cap(array('level_0',false));
$role = &get_role(array('contributor',false));
$role[0]->add_cap(array('edit_posts',false));
$role[0]->add_cap(array('read',false));
$role[0]->add_cap(array('level_1',false));
$role[0]->add_cap(array('level_0',false));
$role = &get_role(array('subscriber',false));
$role[0]->add_cap(array('read',false));
$role[0]->add_cap(array('level_0',false));
 }
function populate_roles_210 (  ) {
$roles = array(array(array('administrator',false),array('editor',false)),false);
foreach ( $roles[0] as $role  )
{$role = &get_role($role);
if ( ((empty($role) || Aspis_empty( $role))))
 continue ;
$role[0]->add_cap(array('edit_others_pages',false));
$role[0]->add_cap(array('edit_published_pages',false));
$role[0]->add_cap(array('publish_pages',false));
$role[0]->add_cap(array('delete_pages',false));
$role[0]->add_cap(array('delete_others_pages',false));
$role[0]->add_cap(array('delete_published_pages',false));
$role[0]->add_cap(array('delete_posts',false));
$role[0]->add_cap(array('delete_others_posts',false));
$role[0]->add_cap(array('delete_published_posts',false));
$role[0]->add_cap(array('delete_private_posts',false));
$role[0]->add_cap(array('edit_private_posts',false));
$role[0]->add_cap(array('read_private_posts',false));
$role[0]->add_cap(array('delete_private_pages',false));
$role[0]->add_cap(array('edit_private_pages',false));
$role[0]->add_cap(array('read_private_pages',false));
}$role = &get_role(array('administrator',false));
if ( (!((empty($role) || Aspis_empty( $role)))))
 {$role[0]->add_cap(array('delete_users',false));
$role[0]->add_cap(array('create_users',false));
}$role = &get_role(array('author',false));
if ( (!((empty($role) || Aspis_empty( $role)))))
 {$role[0]->add_cap(array('delete_posts',false));
$role[0]->add_cap(array('delete_published_posts',false));
}$role = &get_role(array('contributor',false));
if ( (!((empty($role) || Aspis_empty( $role)))))
 {$role[0]->add_cap(array('delete_posts',false));
} }
function populate_roles_230 (  ) {
$role = &get_role(array('administrator',false));
if ( (!((empty($role) || Aspis_empty( $role)))))
 {$role[0]->add_cap(array('unfiltered_upload',false));
} }
function populate_roles_250 (  ) {
$role = &get_role(array('administrator',false));
if ( (!((empty($role) || Aspis_empty( $role)))))
 {$role[0]->add_cap(array('edit_dashboard',false));
} }
function populate_roles_260 (  ) {
$role = &get_role(array('administrator',false));
if ( (!((empty($role) || Aspis_empty( $role)))))
 {$role[0]->add_cap(array('update_plugins',false));
$role[0]->add_cap(array('delete_plugins',false));
} }
function populate_roles_270 (  ) {
$role = &get_role(array('administrator',false));
if ( (!((empty($role) || Aspis_empty( $role)))))
 {$role[0]->add_cap(array('install_plugins',false));
$role[0]->add_cap(array('update_themes',false));
} }
function populate_roles_280 (  ) {
$role = &get_role(array('administrator',false));
if ( (!((empty($role) || Aspis_empty( $role)))))
 {$role[0]->add_cap(array('install_themes',false));
} }
;
?>
<?php 