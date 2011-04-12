<?php require_once('AspisMain.php'); ?><?php
$charset_collate = '';
global $wpdb,$wp_queries;
if ( !empty($wpdb->charset))
 $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
if ( !empty($wpdb->collate))
 $charset_collate .= " COLLATE $wpdb->collate";
$wp_queries = "CREATE TABLE $wpdb->terms (
 term_id bigint(20) unsigned NOT NULL auto_increment,
 name varchar(200) NOT NULL default '',
 slug varchar(200) NOT NULL default '',
 term_group bigint(10) NOT NULL default 0,
 PRIMARY KEY  (term_id),
 UNIQUE KEY slug (slug),
 KEY name (name)
) $charset_collate;
CREATE TABLE $wpdb->term_taxonomy (
 term_taxonomy_id bigint(20) unsigned NOT NULL auto_increment,
 term_id bigint(20) unsigned NOT NULL default 0,
 taxonomy varchar(32) NOT NULL default '',
 description longtext NOT NULL,
 parent bigint(20) unsigned NOT NULL default 0,
 count bigint(20) NOT NULL default 0,
 PRIMARY KEY  (term_taxonomy_id),
 UNIQUE KEY term_id_taxonomy (term_id,taxonomy),
 KEY taxonomy (taxonomy)
) $charset_collate;
CREATE TABLE $wpdb->term_relationships (
 object_id bigint(20) unsigned NOT NULL default 0,
 term_taxonomy_id bigint(20) unsigned NOT NULL default 0,
 term_order int(11) NOT NULL default 0,
 PRIMARY KEY  (object_id,term_taxonomy_id),
 KEY term_taxonomy_id (term_taxonomy_id)
) $charset_collate;
CREATE TABLE $wpdb->commentmeta (
  meta_id bigint(20) unsigned NOT NULL auto_increment,
  comment_id bigint(20) unsigned NOT NULL default '0',
  meta_key varchar(255) default NULL,
  meta_value longtext,
  PRIMARY KEY  (meta_id),
  KEY comment_id (comment_id),
  KEY meta_key (meta_key)
) $charset_collate;
CREATE TABLE $wpdb->comments (
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
) $charset_collate;
CREATE TABLE $wpdb->links (
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
) $charset_collate;
CREATE TABLE $wpdb->options (
  option_id bigint(20) unsigned NOT NULL auto_increment,
  blog_id int(11) NOT NULL default '0',
  option_name varchar(64) NOT NULL default '',
  option_value longtext NOT NULL,
  autoload varchar(20) NOT NULL default 'yes',
  PRIMARY KEY  (option_id),
  UNIQUE KEY option_name (option_name)
) $charset_collate;
CREATE TABLE $wpdb->postmeta (
  meta_id bigint(20) unsigned NOT NULL auto_increment,
  post_id bigint(20) unsigned NOT NULL default '0',
  meta_key varchar(255) default NULL,
  meta_value longtext,
  PRIMARY KEY  (meta_id),
  KEY post_id (post_id),
  KEY meta_key (meta_key)
) $charset_collate;
CREATE TABLE $wpdb->posts (
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
) $charset_collate;
CREATE TABLE $wpdb->users (
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
) $charset_collate;
CREATE TABLE $wpdb->usermeta (
  umeta_id bigint(20) unsigned NOT NULL auto_increment,
  user_id bigint(20) unsigned NOT NULL default '0',
  meta_key varchar(255) default NULL,
  meta_value longtext,
  PRIMARY KEY  (umeta_id),
  KEY user_id (user_id),
  KEY meta_key (meta_key)
) $charset_collate;
";
function populate_options (  ) {
{global $wpdb,$wp_db_version;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_db_version,"\$wp_db_version",$AspisChangesCache);
}$guessurl = wp_guess_url();
do_action('populate_options');
if ( ini_get('safe_mode'))
 {$uploads_use_yearmonth_folders = 0;
}else 
{{$uploads_use_yearmonth_folders = 1;
}}$options = array('siteurl' => $guessurl,'blogname' => __('My Blog'),'blogdescription' => __('Just another WordPress weblog'),'users_can_register' => 0,'admin_email' => 'you@example.com','start_of_week' => 1,'use_balanceTags' => 0,'use_smilies' => 1,'require_name_email' => 1,'comments_notify' => 1,'posts_per_rss' => 10,'rss_use_excerpt' => 0,'mailserver_url' => 'mail.example.com','mailserver_login' => 'login@example.com','mailserver_pass' => 'password','mailserver_port' => 110,'default_category' => 1,'default_comment_status' => 'open','default_ping_status' => 'open','default_pingback_flag' => 1,'default_post_edit_rows' => 10,'posts_per_page' => 10,'date_format' => __('F j, Y'),'time_format' => __('g:i a'),'links_updated_date_format' => __('F j, Y g:i a'),'links_recently_updated_prepend' => '<em>','links_recently_updated_append' => '</em>','links_recently_updated_time' => 120,'comment_moderation' => 0,'moderation_notify' => 1,'permalink_structure' => '','gzipcompression' => 0,'hack_file' => 0,'blog_charset' => 'UTF-8','moderation_keys' => '','active_plugins' => array(),'home' => $guessurl,'category_base' => '','ping_sites' => 'http://rpc.pingomatic.com/','advanced_edit' => 0,'comment_max_links' => 2,'gmt_offset' => date('Z') / 3600,'default_email_category' => 1,'recently_edited' => '','use_linksupdate' => 0,'template' => 'default','stylesheet' => 'default','comment_whitelist' => 1,'blacklist_keys' => '','comment_registration' => 0,'rss_language' => 'en','html_type' => 'text/html','use_trackback' => 0,'default_role' => 'subscriber','db_version' => $wp_db_version,'uploads_use_yearmonth_folders' => $uploads_use_yearmonth_folders,'upload_path' => '','secret' => wp_generate_password(64),'blog_public' => '1','default_link_category' => 2,'show_on_front' => 'posts','tag_base' => '','show_avatars' => '1','avatar_rating' => 'G','upload_url_path' => '','thumbnail_size_w' => 150,'thumbnail_size_h' => 150,'thumbnail_crop' => 1,'medium_size_w' => 300,'medium_size_h' => 300,'avatar_default' => 'mystery','enable_app' => 0,'enable_xmlrpc' => 0,'large_size_w' => 1024,'large_size_h' => 1024,'image_default_link_type' => 'file','image_default_size' => '','image_default_align' => '','close_comments_for_old_posts' => 0,'close_comments_days_old' => 14,'thread_comments' => 0,'thread_comments_depth' => 5,'page_comments' => 1,'comments_per_page' => 50,'default_comments_page' => 'newest','comment_order' => 'asc','sticky_posts' => array(),'widget_categories' => array(),'widget_text' => array(),'widget_rss' => array(),'timezone_string' => '','embed_autourls' => 1,'embed_size_w' => '','embed_size_h' => 600,);
$fat_options = array('moderation_keys','recently_edited','blacklist_keys');
$existing_options = $wpdb->get_col("SELECT option_name FROM $wpdb->options");
$insert = '';
foreach ( $options as $option =>$value )
{if ( in_array($option,$existing_options))
 continue ;
if ( in_array($option,$fat_options))
 $autoload = 'no';
else 
{$autoload = 'yes';
}$option = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($option)),array(0));
if ( is_array($value))
 $value = serialize($value);
$value = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($value)),array(0));
if ( !empty($insert))
 $insert .= ', ';
$insert .= "('$option', '$value', '$autoload')";
}if ( !empty($insert))
 $wpdb->query("INSERT INTO $wpdb->options (option_name, option_value, autoload) VALUES " . $insert);
if ( !__get_option('home'))
 update_option('home',$guessurl);
$unusedoptions = array('blodotgsping_url','bodyterminator','emailtestonly','phoneemail_separator','smilies_directory','subjectprefix','use_bbcode','use_blodotgsping','use_phoneemail','use_quicktags','use_weblogsping','weblogs_cache_file','use_preview','use_htmltrans','smilies_directory','fileupload_allowedusers','use_phoneemail','default_post_status','default_post_category','archive_mode','time_difference','links_minadminlevel','links_use_adminlevels','links_rating_type','links_rating_char','links_rating_ignore_zero','links_rating_single_image','links_rating_image0','links_rating_image1','links_rating_image2','links_rating_image3','links_rating_image4','links_rating_image5','links_rating_image6','links_rating_image7','links_rating_image8','links_rating_image9','weblogs_cacheminutes','comment_allowed_tags','search_engine_friendly_urls','default_geourl_lat','default_geourl_lon','use_default_geourl','weblogs_xml_url','new_users_can_blog','_wpnonce','_wp_http_referer','Update','action','rich_editing','autosave_interval','deactivated_plugins','can_compress_scripts','page_uris','update_core','update_plugins','update_themes','doing_cron','random_seed','rss_excerpt_length');
foreach ( $unusedoptions as $option  )
delete_option($option);
$wpdb->query("DELETE FROM $wpdb->options WHERE option_name REGEXP '^rss_[0-9a-f]{32}(_ts)?$'");
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_db_version",$AspisChangesCache);
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
_x('Administrator','User role');
_x('Editor','User role');
_x('Author','User role');
_x('Contributor','User role');
_x('Subscriber','User role');
add_role('administrator','Administrator');
add_role('editor','Editor');
add_role('author','Author');
add_role('contributor','Contributor');
add_role('subscriber','Subscriber');
$role = &get_role('administrator');
$role->add_cap('switch_themes');
$role->add_cap('edit_themes');
$role->add_cap('activate_plugins');
$role->add_cap('edit_plugins');
$role->add_cap('edit_users');
$role->add_cap('edit_files');
$role->add_cap('manage_options');
$role->add_cap('moderate_comments');
$role->add_cap('manage_categories');
$role->add_cap('manage_links');
$role->add_cap('upload_files');
$role->add_cap('import');
$role->add_cap('unfiltered_html');
$role->add_cap('edit_posts');
$role->add_cap('edit_others_posts');
$role->add_cap('edit_published_posts');
$role->add_cap('publish_posts');
$role->add_cap('edit_pages');
$role->add_cap('read');
$role->add_cap('level_10');
$role->add_cap('level_9');
$role->add_cap('level_8');
$role->add_cap('level_7');
$role->add_cap('level_6');
$role->add_cap('level_5');
$role->add_cap('level_4');
$role->add_cap('level_3');
$role->add_cap('level_2');
$role->add_cap('level_1');
$role->add_cap('level_0');
$role = &get_role('editor');
$role->add_cap('moderate_comments');
$role->add_cap('manage_categories');
$role->add_cap('manage_links');
$role->add_cap('upload_files');
$role->add_cap('unfiltered_html');
$role->add_cap('edit_posts');
$role->add_cap('edit_others_posts');
$role->add_cap('edit_published_posts');
$role->add_cap('publish_posts');
$role->add_cap('edit_pages');
$role->add_cap('read');
$role->add_cap('level_7');
$role->add_cap('level_6');
$role->add_cap('level_5');
$role->add_cap('level_4');
$role->add_cap('level_3');
$role->add_cap('level_2');
$role->add_cap('level_1');
$role->add_cap('level_0');
$role = &get_role('author');
$role->add_cap('upload_files');
$role->add_cap('edit_posts');
$role->add_cap('edit_published_posts');
$role->add_cap('publish_posts');
$role->add_cap('read');
$role->add_cap('level_2');
$role->add_cap('level_1');
$role->add_cap('level_0');
$role = &get_role('contributor');
$role->add_cap('edit_posts');
$role->add_cap('read');
$role->add_cap('level_1');
$role->add_cap('level_0');
$role = &get_role('subscriber');
$role->add_cap('read');
$role->add_cap('level_0');
 }
function populate_roles_210 (  ) {
$roles = array('administrator','editor');
foreach ( $roles as $role  )
{$role = &get_role($role);
if ( empty($role))
 continue ;
$role->add_cap('edit_others_pages');
$role->add_cap('edit_published_pages');
$role->add_cap('publish_pages');
$role->add_cap('delete_pages');
$role->add_cap('delete_others_pages');
$role->add_cap('delete_published_pages');
$role->add_cap('delete_posts');
$role->add_cap('delete_others_posts');
$role->add_cap('delete_published_posts');
$role->add_cap('delete_private_posts');
$role->add_cap('edit_private_posts');
$role->add_cap('read_private_posts');
$role->add_cap('delete_private_pages');
$role->add_cap('edit_private_pages');
$role->add_cap('read_private_pages');
}$role = &get_role('administrator');
if ( !empty($role))
 {$role->add_cap('delete_users');
$role->add_cap('create_users');
}$role = &get_role('author');
if ( !empty($role))
 {$role->add_cap('delete_posts');
$role->add_cap('delete_published_posts');
}$role = &get_role('contributor');
if ( !empty($role))
 {$role->add_cap('delete_posts');
} }
function populate_roles_230 (  ) {
$role = &get_role('administrator');
if ( !empty($role))
 {$role->add_cap('unfiltered_upload');
} }
function populate_roles_250 (  ) {
$role = &get_role('administrator');
if ( !empty($role))
 {$role->add_cap('edit_dashboard');
} }
function populate_roles_260 (  ) {
$role = &get_role('administrator');
if ( !empty($role))
 {$role->add_cap('update_plugins');
$role->add_cap('delete_plugins');
} }
function populate_roles_270 (  ) {
$role = &get_role('administrator');
if ( !empty($role))
 {$role->add_cap('install_plugins');
$role->add_cap('update_themes');
} }
function populate_roles_280 (  ) {
$role = &get_role('administrator');
if ( !empty($role))
 {$role->add_cap('install_themes');
} }
;
?>
<?php 