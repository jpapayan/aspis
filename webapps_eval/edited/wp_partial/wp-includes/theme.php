<?php require_once('AspisMain.php'); ?><?php
function get_stylesheet (  ) {
{$AspisRetTemp = apply_filters('stylesheet',get_option('stylesheet'));
return $AspisRetTemp;
} }
function get_stylesheet_directory (  ) {
$stylesheet = get_stylesheet();
$theme_root = get_theme_root($stylesheet);
$stylesheet_dir = "$theme_root/$stylesheet";
{$AspisRetTemp = apply_filters('stylesheet_directory',$stylesheet_dir,$stylesheet,$theme_root);
return $AspisRetTemp;
} }
function get_stylesheet_directory_uri (  ) {
$stylesheet = get_stylesheet();
$theme_root_uri = get_theme_root_uri($stylesheet);
$stylesheet_dir_uri = "$theme_root_uri/$stylesheet";
{$AspisRetTemp = apply_filters('stylesheet_directory_uri',$stylesheet_dir_uri,$stylesheet,$theme_root_uri);
return $AspisRetTemp;
} }
function get_stylesheet_uri (  ) {
$stylesheet_dir_uri = get_stylesheet_directory_uri();
$stylesheet_uri = $stylesheet_dir_uri . "/style.css";
{$AspisRetTemp = apply_filters('stylesheet_uri',$stylesheet_uri,$stylesheet_dir_uri);
return $AspisRetTemp;
} }
function get_locale_stylesheet_uri (  ) {
{global $wp_locale;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_locale,"\$wp_locale",$AspisChangesCache);
}$stylesheet_dir_uri = get_stylesheet_directory_uri();
$dir = get_stylesheet_directory();
$locale = get_locale();
if ( file_exists("$dir/$locale.css"))
 $stylesheet_uri = "$stylesheet_dir_uri/$locale.css";
elseif ( !empty($wp_locale->text_direction) && file_exists("$dir/{$wp_locale->text_direction}.css"))
 $stylesheet_uri = "$stylesheet_dir_uri/{$wp_locale->text_direction}.css";
else 
{$stylesheet_uri = '';
}{$AspisRetTemp = apply_filters('locale_stylesheet_uri',$stylesheet_uri,$stylesheet_dir_uri);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_locale",$AspisChangesCache);
 }
function get_template (  ) {
{$AspisRetTemp = apply_filters('template',get_option('template'));
return $AspisRetTemp;
} }
function get_template_directory (  ) {
$template = get_template();
$theme_root = get_theme_root($template);
$template_dir = "$theme_root/$template";
{$AspisRetTemp = apply_filters('template_directory',$template_dir,$template,$theme_root);
return $AspisRetTemp;
} }
function get_template_directory_uri (  ) {
$template = get_template();
$theme_root_uri = get_theme_root_uri($template);
$template_dir_uri = "$theme_root_uri/$template";
{$AspisRetTemp = apply_filters('template_directory_uri',$template_dir_uri,$template,$theme_root_uri);
return $AspisRetTemp;
} }
function get_theme_data ( $theme_file ) {
$default_headers = array('Name' => 'Theme Name','URI' => 'Theme URI','Description' => 'Description','Author' => 'Author','AuthorURI' => 'Author URI','Version' => 'Version','Template' => 'Template','Status' => 'Status','Tags' => 'Tags');
$themes_allowed_tags = array('a' => array('href' => array(),'title' => array()),'abbr' => array('title' => array()),'acronym' => array('title' => array()),'code' => array(),'em' => array(),'strong' => array());
$theme_data = get_file_data($theme_file,$default_headers,'theme');
$theme_data['Name'] = $theme_data['Title'] = wp_kses($theme_data['Name'],$themes_allowed_tags);
$theme_data['URI'] = esc_url($theme_data['URI']);
$theme_data['Description'] = wptexturize(wp_kses($theme_data['Description'],$themes_allowed_tags));
$theme_data['AuthorURI'] = esc_url($theme_data['AuthorURI']);
$theme_data['Template'] = wp_kses($theme_data['Template'],$themes_allowed_tags);
$theme_data['Version'] = wp_kses($theme_data['Version'],$themes_allowed_tags);
if ( $theme_data['Status'] == '')
 $theme_data['Status'] = 'publish';
else 
{$theme_data['Status'] = wp_kses($theme_data['Status'],$themes_allowed_tags);
}if ( $theme_data['Tags'] == '')
 $theme_data['Tags'] = array();
else 
{$theme_data['Tags'] = array_map('trim',explode(',',wp_kses($theme_data['Tags'],array())));
}if ( $theme_data['Author'] == '')
 {$theme_data['Author'] = __('Anonymous');
}else 
{{if ( empty($theme_data['AuthorURI']))
 {$theme_data['Author'] = wp_kses($theme_data['Author'],$themes_allowed_tags);
}else 
{{$theme_data['Author'] = sprintf('<a href="%1$s" title="%2$s">%3$s</a>',$theme_data['AuthorURI'],__('Visit author homepage'),wp_kses($theme_data['Author'],$themes_allowed_tags));
}}}}{$AspisRetTemp = $theme_data;
return $AspisRetTemp;
} }
function get_themes (  ) {
{global $wp_themes,$wp_broken_themes;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_themes,"\$wp_themes",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_broken_themes,"\$wp_broken_themes",$AspisChangesCache);
}if ( isset($wp_themes))
 {$AspisRetTemp = $wp_themes;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_themes",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_broken_themes",$AspisChangesCache);
return $AspisRetTemp;
}register_theme_directory(get_theme_root());
if ( !$theme_files = search_theme_directories())
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_themes",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_broken_themes",$AspisChangesCache);
return $AspisRetTemp;
}asort($theme_files);
$wp_themes = array();
foreach ( (array)$theme_files as $theme_file  )
{$theme_root = $theme_file['theme_root'];
$theme_file = $theme_file['theme_file'];
if ( !is_readable("$theme_root/$theme_file"))
 {$wp_broken_themes[$theme_file] = array('Name' => $theme_file,'Title' => $theme_file,'Description' => __('File not readable.'));
continue ;
}$theme_data = get_theme_data("$theme_root/$theme_file");
$name = $theme_data['Name'];
$title = $theme_data['Title'];
$description = wptexturize($theme_data['Description']);
$version = $theme_data['Version'];
$author = $theme_data['Author'];
$template = $theme_data['Template'];
$stylesheet = dirname($theme_file);
$screenshot = false;
foreach ( array('png','gif','jpg','jpeg') as $ext  )
{if ( file_exists("$theme_root/$stylesheet/screenshot.$ext"))
 {$screenshot = "screenshot.$ext";
break ;
}}if ( empty($name))
 {$name = dirname($theme_file);
$title = $name;
}if ( empty($template))
 {if ( file_exists("$theme_root/$stylesheet/index.php"))
 $template = $stylesheet;
else 
{continue ;
}}$template = trim($template);
if ( !file_exists("$theme_root/$template/index.php"))
 {$parent_dir = dirname(dirname($theme_file));
if ( file_exists("$theme_root/$parent_dir/$template/index.php"))
 {$template = "$parent_dir/$template";
$template_directory = "$theme_root/$template";
}else 
{{if ( isset($theme_files[$template]) && file_exists($theme_files[$template]['theme_root'] . "/$template/index.php"))
 {$template_directory = $theme_files[$template]['theme_root'] . "/$template";
}else 
{{$wp_broken_themes[$name] = array('Name' => $name,'Title' => $title,'Description' => __('Template is missing.'));
continue ;
}}}}}else 
{{$template_directory = trim($theme_root . '/' . $template);
}}$stylesheet_files = array();
$template_files = array();
$stylesheet_dir = @dir("$theme_root/$stylesheet");
if ( $stylesheet_dir)
 {while ( ($file = $stylesheet_dir->read()) !== false )
{if ( !preg_match('|^\.+$|',$file))
 {if ( preg_match('|\.css$|',$file))
 $stylesheet_files[] = "$theme_root/$stylesheet/$file";
elseif ( preg_match('|\.php$|',$file))
 $template_files[] = "$theme_root/$stylesheet/$file";
}}@$stylesheet_dir->close();
}$template_dir = @dir("$template_directory");
if ( $template_dir)
 {while ( ($file = $template_dir->read()) !== false )
{if ( preg_match('|^\.+$|',$file))
 continue ;
if ( preg_match('|\.php$|',$file))
 {$template_files[] = "$template_directory/$file";
}elseif ( is_dir("$template_directory/$file"))
 {$template_subdir = @dir("$template_directory/$file");
if ( !$template_subdir)
 continue ;
while ( ($subfile = $template_subdir->read()) !== false )
{if ( preg_match('|^\.+$|',$subfile))
 continue ;
if ( preg_match('|\.php$|',$subfile))
 $template_files[] = "$template_directory/$file/$subfile";
}@$template_subdir->close();
}}@$template_dir->close();
}$template_files = array_unique($template_files);
$stylesheet_files = array_unique($stylesheet_files);
$template_dir = dirname($template_files[0]);
$stylesheet_dir = dirname($stylesheet_files[0]);
if ( empty($template_dir))
 $template_dir = '/';
if ( empty($stylesheet_dir))
 $stylesheet_dir = '/';
if ( isset($wp_themes[$name]))
 {if ( ('WordPress Default' == $name || 'WordPress Classic' == $name) && ('default' == $stylesheet || 'classic' == $stylesheet))
 {$suffix = $wp_themes[$name]['Stylesheet'];
$new_name = "$name/$suffix";
$wp_themes[$new_name] = $wp_themes[$name];
$wp_themes[$new_name]['Name'] = $new_name;
}else 
{{$name = "$name/$stylesheet";
}}}$theme_roots[$stylesheet] = str_replace(WP_CONTENT_DIR,'',$theme_root);
$wp_themes[$name] = array('Name' => $name,'Title' => $title,'Description' => $description,'Author' => $author,'Version' => $version,'Template' => $template,'Stylesheet' => $stylesheet,'Template Files' => $template_files,'Stylesheet Files' => $stylesheet_files,'Template Dir' => $template_dir,'Stylesheet Dir' => $stylesheet_dir,'Status' => $theme_data['Status'],'Screenshot' => $screenshot,'Tags' => $theme_data['Tags'],'Theme Root' => $theme_root,'Theme Root URI' => str_replace(WP_CONTENT_DIR,content_url(),$theme_root));
}unset($theme_files);
if ( get_site_transient('theme_roots') != $theme_roots)
 set_site_transient('theme_roots',$theme_roots,7200);
unset($theme_roots);
$theme_names = array_keys($wp_themes);
foreach ( (array)$theme_names as $theme_name  )
{$wp_themes[$theme_name]['Parent Theme'] = '';
if ( $wp_themes[$theme_name]['Stylesheet'] != $wp_themes[$theme_name]['Template'])
 {foreach ( (array)$theme_names as $parent_theme_name  )
{if ( ($wp_themes[$parent_theme_name]['Stylesheet'] == $wp_themes[$parent_theme_name]['Template']) && ($wp_themes[$parent_theme_name]['Template'] == $wp_themes[$theme_name]['Template']))
 {$wp_themes[$theme_name]['Parent Theme'] = $wp_themes[$parent_theme_name]['Name'];
break ;
}}}}{$AspisRetTemp = $wp_themes;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_themes",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_broken_themes",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_themes",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_broken_themes",$AspisChangesCache);
 }
function get_theme_roots (  ) {
$theme_roots = get_site_transient('theme_roots');
if ( false === $theme_roots)
 {get_themes();
$theme_roots = get_site_transient('theme_roots');
}{$AspisRetTemp = $theme_roots;
return $AspisRetTemp;
} }
function get_theme ( $theme ) {
$themes = get_themes();
if ( array_key_exists($theme,$themes))
 {$AspisRetTemp = $themes[$theme];
return $AspisRetTemp;
}{$AspisRetTemp = null;
return $AspisRetTemp;
} }
function get_current_theme (  ) {
if ( $theme = get_option('current_theme'))
 {$AspisRetTemp = $theme;
return $AspisRetTemp;
}$themes = get_themes();
$theme_names = array_keys($themes);
$current_template = get_option('template');
$current_stylesheet = get_option('stylesheet');
$current_theme = 'WordPress Default';
if ( $themes)
 {foreach ( (array)$theme_names as $theme_name  )
{if ( $themes[$theme_name]['Stylesheet'] == $current_stylesheet && $themes[$theme_name]['Template'] == $current_template)
 {$current_theme = $themes[$theme_name]['Name'];
break ;
}}}update_option('current_theme',$current_theme);
{$AspisRetTemp = $current_theme;
return $AspisRetTemp;
} }
function register_theme_directory ( $directory ) {
{global $wp_theme_directories;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_theme_directories,"\$wp_theme_directories",$AspisChangesCache);
}if ( !file_exists($directory))
 $registered_directory = WP_CONTENT_DIR . '/' . $directory;
else 
{$registered_directory = $directory;
}if ( !file_exists($registered_directory))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_theme_directories",$AspisChangesCache);
return $AspisRetTemp;
}$wp_theme_directories[] = $registered_directory;
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_theme_directories",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_theme_directories",$AspisChangesCache);
 }
function search_theme_directories (  ) {
{global $wp_theme_directories,$wp_broken_themes;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_theme_directories,"\$wp_theme_directories",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_broken_themes,"\$wp_broken_themes",$AspisChangesCache);
}if ( empty($wp_theme_directories))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_theme_directories",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_broken_themes",$AspisChangesCache);
return $AspisRetTemp;
}$theme_files = array();
$wp_broken_themes = array();
foreach ( (array)$wp_theme_directories as $theme_root  )
{$theme_loc = $theme_root;
if ( '/' != WP_CONTENT_DIR)
 $theme_loc = str_replace(WP_CONTENT_DIR,'',$theme_root);
$themes_dir = @opendir($theme_root);
if ( !$themes_dir)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_theme_directories",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_broken_themes",$AspisChangesCache);
return $AspisRetTemp;
}while ( ($theme_dir = readdir($themes_dir)) !== false )
{if ( is_dir($theme_root . '/' . $theme_dir) && is_readable($theme_root . '/' . $theme_dir))
 {if ( $theme_dir[0] == '.' || $theme_dir == 'CVS')
 continue ;
$stylish_dir = @opendir($theme_root . '/' . $theme_dir);
$found_stylesheet = false;
while ( ($theme_file = readdir($stylish_dir)) !== false )
{if ( $theme_file == 'style.css')
 {$theme_files[$theme_dir] = array('theme_file' => $theme_dir . '/' . $theme_file,'theme_root' => $theme_root);
$found_stylesheet = true;
break ;
}}@closedir($stylish_dir);
if ( !$found_stylesheet)
 {$subdir = "$theme_root/$theme_dir";
$subdir_name = $theme_dir;
$theme_subdirs = @opendir($subdir);
$found_subdir_themes = false;
while ( ($theme_subdir = readdir($theme_subdirs)) !== false )
{if ( is_dir($subdir . '/' . $theme_subdir) && is_readable($subdir . '/' . $theme_subdir))
 {if ( $theme_subdir[0] == '.' || $theme_subdir == 'CVS')
 continue ;
$stylish_dir = @opendir($subdir . '/' . $theme_subdir);
$found_stylesheet = false;
while ( ($theme_file = readdir($stylish_dir)) !== false )
{if ( $theme_file == 'style.css')
 {$theme_files["$theme_dir/$theme_subdir"] = array('theme_file' => $subdir_name . '/' . $theme_subdir . '/' . $theme_file,'theme_root' => $theme_root);
$found_stylesheet = true;
$found_subdir_themes = true;
break ;
}}@closedir($stylish_dir);
}}@closedir($theme_subdir);
if ( !$found_subdir_themes)
 $wp_broken_themes[$theme_dir] = array('Name' => $theme_dir,'Title' => $theme_dir,'Description' => __('Stylesheet is missing.'));
}}}if ( is_dir($theme_dir))
 @closedir($theme_dir);
}{$AspisRetTemp = $theme_files;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_theme_directories",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_broken_themes",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_theme_directories",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_broken_themes",$AspisChangesCache);
 }
function get_theme_root ( $stylesheet_or_template = false ) {
if ( $stylesheet_or_template)
 {$theme_roots = get_theme_roots();
if ( $theme_roots[$stylesheet_or_template])
 $theme_root = WP_CONTENT_DIR . $theme_roots[$stylesheet_or_template];
else 
{$theme_root = WP_CONTENT_DIR . '/themes';
}}else 
{{$theme_root = WP_CONTENT_DIR . '/themes';
}}{$AspisRetTemp = apply_filters('theme_root',$theme_root);
return $AspisRetTemp;
} }
function get_theme_root_uri ( $stylesheet_or_template = false ) {
$theme_roots = get_theme_roots();
if ( $theme_roots[$stylesheet_or_template])
 $theme_root_uri = content_url($theme_roots[$stylesheet_or_template]);
else 
{$theme_root_uri = content_url('themes');
}{$AspisRetTemp = apply_filters('theme_root_uri',$theme_root_uri,get_option('siteurl'),$stylesheet_or_template);
return $AspisRetTemp;
} }
function get_query_template ( $type ) {
$type = preg_replace('|[^a-z0-9-]+|','',$type);
{$AspisRetTemp = apply_filters("{$type}_template",locate_template(array("{$type}.php")));
return $AspisRetTemp;
} }
function get_404_template (  ) {
{$AspisRetTemp = get_query_template('404');
return $AspisRetTemp;
} }
function get_archive_template (  ) {
{$AspisRetTemp = get_query_template('archive');
return $AspisRetTemp;
} }
function get_author_template (  ) {
{$AspisRetTemp = get_query_template('author');
return $AspisRetTemp;
} }
function get_category_template (  ) {
$cat_ID = absint(get_query_var('cat'));
$category = get_category($cat_ID);
$templates = array();
if ( !is_wp_error($category))
 $templates[] = "category-{$category->slug}.php";
$templates[] = "category-$cat_ID.php";
$templates[] = "category.php";
$template = locate_template($templates);
{$AspisRetTemp = apply_filters('category_template',$template);
return $AspisRetTemp;
} }
function get_tag_template (  ) {
$tag_id = absint(get_query_var('tag_id'));
$tag_name = get_query_var('tag');
$templates = array();
if ( $tag_name)
 $templates[] = "tag-$tag_name.php";
if ( $tag_id)
 $templates[] = "tag-$tag_id.php";
$templates[] = "tag.php";
$template = locate_template($templates);
{$AspisRetTemp = apply_filters('tag_template',$template);
return $AspisRetTemp;
} }
function get_taxonomy_template (  ) {
$taxonomy = get_query_var('taxonomy');
$term = get_query_var('term');
$templates = array();
if ( $taxonomy && $term)
 $templates[] = "taxonomy-$taxonomy-$term.php";
if ( $taxonomy)
 $templates[] = "taxonomy-$taxonomy.php";
$templates[] = "taxonomy.php";
$template = locate_template($templates);
{$AspisRetTemp = apply_filters('taxonomy_template',$template);
return $AspisRetTemp;
} }
function get_date_template (  ) {
{$AspisRetTemp = get_query_template('date');
return $AspisRetTemp;
} }
function get_home_template (  ) {
$template = locate_template(array('home.php','index.php'));
{$AspisRetTemp = apply_filters('home_template',$template);
return $AspisRetTemp;
} }
function get_page_template (  ) {
{global $wp_query;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_query,"\$wp_query",$AspisChangesCache);
}$id = (int)$wp_query->post->ID;
$template = get_post_meta($id,'_wp_page_template',true);
$pagename = get_query_var('pagename');
if ( 'default' == $template)
 $template = '';
$templates = array();
if ( !empty($template) && !validate_file($template))
 $templates[] = $template;
if ( $pagename)
 $templates[] = "page-$pagename.php";
if ( $id)
 $templates[] = "page-$id.php";
$templates[] = "page.php";
{$AspisRetTemp = apply_filters('page_template',locate_template($templates));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_query",$AspisChangesCache);
 }
function get_paged_template (  ) {
{$AspisRetTemp = get_query_template('paged');
return $AspisRetTemp;
} }
function get_search_template (  ) {
{$AspisRetTemp = get_query_template('search');
return $AspisRetTemp;
} }
function get_single_template (  ) {
{$AspisRetTemp = get_query_template('single');
return $AspisRetTemp;
} }
function get_attachment_template (  ) {
{global $posts;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $posts,"\$posts",$AspisChangesCache);
}$type = explode('/',$posts[0]->post_mime_type);
if ( $template = get_query_template($type[0]))
 {$AspisRetTemp = $template;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$posts",$AspisChangesCache);
return $AspisRetTemp;
}elseif ( $template = get_query_template($type[1]))
 {$AspisRetTemp = $template;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$posts",$AspisChangesCache);
return $AspisRetTemp;
}elseif ( $template = get_query_template("$type[0]_$type[1]"))
 {$AspisRetTemp = $template;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$posts",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = get_query_template('attachment');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$posts",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$posts",$AspisChangesCache);
 }
function get_comments_popup_template (  ) {
$template = locate_template(array("comments-popup.php"));
if ( '' == $template)
 $template = get_theme_root() . '/default/comments-popup.php';
{$AspisRetTemp = apply_filters('comments_popup_template',$template);
return $AspisRetTemp;
} }
function locate_template ( $template_names,$load = false ) {
if ( !is_array($template_names))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$located = '';
foreach ( $template_names as $template_name  )
{if ( file_exists(STYLESHEETPATH . '/' . $template_name))
 {$located = STYLESHEETPATH . '/' . $template_name;
break ;
}else 
{if ( file_exists(TEMPLATEPATH . '/' . $template_name))
 {$located = TEMPLATEPATH . '/' . $template_name;
break ;
}}}if ( $load && '' != $located)
 load_template($located);
{$AspisRetTemp = $located;
return $AspisRetTemp;
} }
function load_template ( $_template_file ) {
{global $posts,$post,$wp_did_header,$wp_did_template_redirect,$wp_query,$wp_rewrite,$wpdb,$wp_version,$wp,$id,$comment,$user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $posts,"\$posts",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($post,"\$post",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_did_header,"\$wp_did_header",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($wp_did_template_redirect,"\$wp_did_template_redirect",$AspisChangesCache);
$AspisVar4 = &AspisCleanTaintedGlobalUntainted($wp_query,"\$wp_query",$AspisChangesCache);
$AspisVar5 = &AspisCleanTaintedGlobalUntainted($wp_rewrite,"\$wp_rewrite",$AspisChangesCache);
$AspisVar6 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar7 = &AspisCleanTaintedGlobalUntainted($wp_version,"\$wp_version",$AspisChangesCache);
$AspisVar8 = &AspisCleanTaintedGlobalUntainted($wp,"\$wp",$AspisChangesCache);
$AspisVar9 = &AspisCleanTaintedGlobalUntainted($id,"\$id",$AspisChangesCache);
$AspisVar10 = &AspisCleanTaintedGlobalUntainted($comment,"\$comment",$AspisChangesCache);
$AspisVar11 = &AspisCleanTaintedGlobalUntainted($user_ID,"\$user_ID",$AspisChangesCache);
}if ( is_array($wp_query->query_vars))
 extract(($wp_query->query_vars),EXTR_SKIP);
require_once ($_template_file);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$posts",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_did_header",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$wp_did_template_redirect",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$wp_rewrite",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$wp_version",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar8,"\$wp",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar9,"\$id",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar10,"\$comment",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar11,"\$user_ID",$AspisChangesCache);
 }
function locale_stylesheet (  ) {
$stylesheet = get_locale_stylesheet_uri();
if ( empty($stylesheet))
 {return ;
}echo '<link rel="stylesheet" href="' . $stylesheet . '" type="text/css" media="screen" />';
 }
function preview_theme (  ) {
if ( !((isset($_GET[0]['template']) && Aspis_isset($_GET[0]['template'])) && (isset($_GET[0]['preview']) && Aspis_isset($_GET[0]['preview']))))
 {return ;
}if ( !current_user_can('switch_themes'))
 {return ;
}$_GET[0]['template'] = attAspisRCO(preg_replace('|[^a-z0-9_./-]|i','',deAspisWarningRC($_GET[0]['template'])));
if ( validate_file(deAspisWarningRC($_GET[0]['template'])))
 {return ;
}add_filter('template','_preview_theme_template_filter');
if ( (isset($_GET[0]['stylesheet']) && Aspis_isset($_GET[0]['stylesheet'])))
 {$_GET[0]['stylesheet'] = attAspisRCO(preg_replace('|[^a-z0-9_./-]|i','',deAspisWarningRC($_GET[0]['stylesheet'])));
if ( validate_file(deAspisWarningRC($_GET[0]['stylesheet'])))
 {return ;
}add_filter('stylesheet','_preview_theme_stylesheet_filter');
}add_filter('pre_option_mods_' . get_current_theme(),create_function('',"return array();"));
ob_start('preview_theme_ob_filter');
 }
add_action('setup_theme','preview_theme');
function _preview_theme_template_filter (  ) {
{$AspisRetTemp = (isset($_GET[0]['template']) && Aspis_isset($_GET[0]['template'])) ? deAspisWarningRC($_GET[0]['template']) : '';
return $AspisRetTemp;
} }
function _preview_theme_stylesheet_filter (  ) {
{$AspisRetTemp = (isset($_GET[0]['stylesheet']) && Aspis_isset($_GET[0]['stylesheet'])) ? deAspisWarningRC($_GET[0]['stylesheet']) : '';
return $AspisRetTemp;
} }
function preview_theme_ob_filter ( $content ) {
{$AspisRetTemp = preg_replace_callback("|(<a.*?href=([\"']))(.*?)([\"'].*?>)|",'preview_theme_ob_filter_callback',$content);
return $AspisRetTemp;
} }
function preview_theme_ob_filter_callback ( $matches ) {
if ( strpos($matches[4],'onclick') !== false)
 $matches[4] = preg_replace('#onclick=([\'"]).*?(?<!\\\)\\1#i','',$matches[4]);
if ( (false !== strpos($matches[3],'/wp-admin/')) || (false !== strpos($matches[3],'://') && 0 !== strpos($matches[3],get_option('home'))) || (false !== strpos($matches[3],'/feed/')) || (false !== strpos($matches[3],'/trackback/')))
 {$AspisRetTemp = $matches[1] . "#$matches[2] onclick=$matches[2]return false;
" . $matches[4];
return $AspisRetTemp;
}$link = add_query_arg(array('preview' => 1,'template' => deAspisWarningRC($_GET[0]['template']),'stylesheet' => @deAspisWarningRC($_GET[0]['stylesheet'])),$matches[3]);
if ( 0 === strpos($link,'preview=1'))
 $link = "?$link";
{$AspisRetTemp = $matches[1] . esc_attr($link) . $matches[4];
return $AspisRetTemp;
} }
function switch_theme ( $template,$stylesheet ) {
update_option('template',$template);
update_option('stylesheet',$stylesheet);
delete_option('current_theme');
$theme = get_current_theme();
do_action('switch_theme',$theme);
 }
function validate_current_theme (  ) {
if ( defined('WP_INSTALLING') || !apply_filters('validate_current_theme',true))
 {$AspisRetTemp = true;
return $AspisRetTemp;
}if ( get_template() != 'default' && !file_exists(get_template_directory() . '/index.php'))
 {switch_theme('default','default');
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( get_stylesheet() != 'default' && !file_exists(get_template_directory() . '/style.css'))
 {switch_theme('default','default');
{$AspisRetTemp = false;
return $AspisRetTemp;
}}{$AspisRetTemp = true;
return $AspisRetTemp;
} }
function get_theme_mod ( $name,$default = false ) {
$theme = get_current_theme();
$mods = get_option("mods_$theme");
if ( isset($mods[$name]))
 {$AspisRetTemp = apply_filters("theme_mod_$name",$mods[$name]);
return $AspisRetTemp;
}{$AspisRetTemp = apply_filters("theme_mod_$name",sprintf($default,get_template_directory_uri(),get_stylesheet_directory_uri()));
return $AspisRetTemp;
} }
function set_theme_mod ( $name,$value ) {
$theme = get_current_theme();
$mods = get_option("mods_$theme");
$mods[$name] = $value;
update_option("mods_$theme",$mods);
wp_cache_delete("mods_$theme",'options');
 }
function remove_theme_mod ( $name ) {
$theme = get_current_theme();
$mods = get_option("mods_$theme");
if ( !isset($mods[$name]))
 {return ;
}unset($mods[$name]);
if ( empty($mods))
 {$AspisRetTemp = remove_theme_mods();
return $AspisRetTemp;
}update_option("mods_$theme",$mods);
wp_cache_delete("mods_$theme",'options');
 }
function remove_theme_mods (  ) {
$theme = get_current_theme();
delete_option("mods_$theme");
 }
function get_header_textcolor (  ) {
{$AspisRetTemp = get_theme_mod('header_textcolor',HEADER_TEXTCOLOR);
return $AspisRetTemp;
} }
function header_textcolor (  ) {
echo get_header_textcolor();
 }
function get_header_image (  ) {
{$AspisRetTemp = get_theme_mod('header_image',HEADER_IMAGE);
return $AspisRetTemp;
} }
function header_image (  ) {
echo get_header_image();
 }
function add_custom_image_header ( $header_callback,$admin_header_callback ) {
if ( !empty($header_callback))
 add_action('wp_head',$header_callback);
if ( !is_admin())
 {return ;
}require_once (ABSPATH . 'wp-admin/custom-header.php');
$GLOBALS[0]['custom_image_header'] = &new Custom_Image_Header($admin_header_callback);
add_action('admin_menu',array($GLOBALS[0]['custom_image_header'],'init'));
 }
function add_theme_support ( $feature ) {
{global $_wp_theme_features;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_theme_features,"\$_wp_theme_features",$AspisChangesCache);
}if ( func_num_args() == 1)
 $_wp_theme_features[$feature] = true;
else 
{$_wp_theme_features[$feature] = array_slice(func_get_args(),1);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_theme_features",$AspisChangesCache);
 }
function current_theme_supports ( $feature ) {
{global $_wp_theme_features;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $_wp_theme_features,"\$_wp_theme_features",$AspisChangesCache);
}if ( !isset($_wp_theme_features[$feature]))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_theme_features",$AspisChangesCache);
return $AspisRetTemp;
}if ( func_num_args() <= 1)
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_theme_features",$AspisChangesCache);
return $AspisRetTemp;
}$args = array_slice(func_get_args(),1);
switch ( $feature ) {
case 'post-thumbnails':if ( true === $_wp_theme_features[$feature])
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_theme_features",$AspisChangesCache);
return $AspisRetTemp;
}$content_type = $args[0];
if ( in_array($content_type,$_wp_theme_features[$feature][0]))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_theme_features",$AspisChangesCache);
return $AspisRetTemp;
}else 
{{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_theme_features",$AspisChangesCache);
return $AspisRetTemp;
}}break ;
 }
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_theme_features",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$_wp_theme_features",$AspisChangesCache);
 }
function require_if_theme_supports ( $feature,$include ) {
if ( current_theme_supports($feature))
 require ($include);
 }
;
?>
<?php 