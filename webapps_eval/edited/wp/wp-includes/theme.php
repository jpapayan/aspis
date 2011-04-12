<?php require_once('AspisMain.php'); ?><?php
function get_stylesheet (  ) {
return apply_filters(array('stylesheet',false),get_option(array('stylesheet',false)));
 }
function get_stylesheet_directory (  ) {
$stylesheet = get_stylesheet();
$theme_root = get_theme_root($stylesheet);
$stylesheet_dir = concat(concat2($theme_root,"/"),$stylesheet);
return apply_filters(array('stylesheet_directory',false),$stylesheet_dir,$stylesheet,$theme_root);
 }
function get_stylesheet_directory_uri (  ) {
$stylesheet = get_stylesheet();
$theme_root_uri = get_theme_root_uri($stylesheet);
$stylesheet_dir_uri = concat(concat2($theme_root_uri,"/"),$stylesheet);
return apply_filters(array('stylesheet_directory_uri',false),$stylesheet_dir_uri,$stylesheet,$theme_root_uri);
 }
function get_stylesheet_uri (  ) {
$stylesheet_dir_uri = get_stylesheet_directory_uri();
$stylesheet_uri = concat2($stylesheet_dir_uri,"/style.css");
return apply_filters(array('stylesheet_uri',false),$stylesheet_uri,$stylesheet_dir_uri);
 }
function get_locale_stylesheet_uri (  ) {
global $wp_locale;
$stylesheet_dir_uri = get_stylesheet_directory_uri();
$dir = get_stylesheet_directory();
$locale = get_locale();
if ( file_exists((deconcat2(concat(concat2($dir,"/"),$locale),".css"))))
 $stylesheet_uri = concat2(concat(concat2($stylesheet_dir_uri,"/"),$locale),".css");
elseif ( ((!((empty($wp_locale[0]->text_direction) || Aspis_empty( $wp_locale[0] ->text_direction )))) && file_exists((deconcat2(concat(concat2($dir,"/"),$wp_locale[0]->text_direction),".css")))))
 $stylesheet_uri = concat2(concat(concat2($stylesheet_dir_uri,"/"),$wp_locale[0]->text_direction),".css");
else 
{$stylesheet_uri = array('',false);
}return apply_filters(array('locale_stylesheet_uri',false),$stylesheet_uri,$stylesheet_dir_uri);
 }
function get_template (  ) {
return apply_filters(array('template',false),get_option(array('template',false)));
 }
function get_template_directory (  ) {
$template = get_template();
$theme_root = get_theme_root($template);
$template_dir = concat(concat2($theme_root,"/"),$template);
return apply_filters(array('template_directory',false),$template_dir,$template,$theme_root);
 }
function get_template_directory_uri (  ) {
$template = get_template();
$theme_root_uri = get_theme_root_uri($template);
$template_dir_uri = concat(concat2($theme_root_uri,"/"),$template);
return apply_filters(array('template_directory_uri',false),$template_dir_uri,$template,$theme_root_uri);
 }
function get_theme_data ( $theme_file ) {
$default_headers = array(array('Name' => array('Theme Name',false,false),'URI' => array('Theme URI',false,false),'Description' => array('Description',false,false),'Author' => array('Author',false,false),'AuthorURI' => array('Author URI',false,false),'Version' => array('Version',false,false),'Template' => array('Template',false,false),'Status' => array('Status',false,false),'Tags' => array('Tags',false,false)),false);
$themes_allowed_tags = array(array('a' => array(array('href' => array(array(),false,false),'title' => array(array(),false,false)),false,false),'abbr' => array(array('title' => array(array(),false,false)),false,false),'acronym' => array(array('title' => array(array(),false,false)),false,false),'code' => array(array(),false,false),'em' => array(array(),false,false),'strong' => array(array(),false,false)),false);
$theme_data = get_file_data($theme_file,$default_headers,array('theme',false));
arrayAssign($theme_data[0],deAspis(registerTaint(array('Name',false))),addTaint(arrayAssign($theme_data[0],deAspis(registerTaint(array('Title',false))),addTaint(wp_kses($theme_data[0]['Name'],$themes_allowed_tags)))));
arrayAssign($theme_data[0],deAspis(registerTaint(array('URI',false))),addTaint(esc_url($theme_data[0]['URI'])));
arrayAssign($theme_data[0],deAspis(registerTaint(array('Description',false))),addTaint(wptexturize(wp_kses($theme_data[0]['Description'],$themes_allowed_tags))));
arrayAssign($theme_data[0],deAspis(registerTaint(array('AuthorURI',false))),addTaint(esc_url($theme_data[0]['AuthorURI'])));
arrayAssign($theme_data[0],deAspis(registerTaint(array('Template',false))),addTaint(wp_kses($theme_data[0]['Template'],$themes_allowed_tags)));
arrayAssign($theme_data[0],deAspis(registerTaint(array('Version',false))),addTaint(wp_kses($theme_data[0]['Version'],$themes_allowed_tags)));
if ( (deAspis($theme_data[0]['Status']) == ('')))
 arrayAssign($theme_data[0],deAspis(registerTaint(array('Status',false))),addTaint(array('publish',false)));
else 
{arrayAssign($theme_data[0],deAspis(registerTaint(array('Status',false))),addTaint(wp_kses($theme_data[0]['Status'],$themes_allowed_tags)));
}if ( (deAspis($theme_data[0]['Tags']) == ('')))
 arrayAssign($theme_data[0],deAspis(registerTaint(array('Tags',false))),addTaint(array(array(),false)));
else 
{arrayAssign($theme_data[0],deAspis(registerTaint(array('Tags',false))),addTaint(attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC(Aspis_explode(array(',',false),wp_kses($theme_data[0]['Tags'],array(array(),false))))))));
}if ( (deAspis($theme_data[0]['Author']) == ('')))
 {arrayAssign($theme_data[0],deAspis(registerTaint(array('Author',false))),addTaint(__(array('Anonymous',false))));
}else 
{{if ( ((empty($theme_data[0][('AuthorURI')]) || Aspis_empty( $theme_data [0][('AuthorURI')]))))
 {arrayAssign($theme_data[0],deAspis(registerTaint(array('Author',false))),addTaint(wp_kses($theme_data[0]['Author'],$themes_allowed_tags)));
}else 
{{arrayAssign($theme_data[0],deAspis(registerTaint(array('Author',false))),addTaint(Aspis_sprintf(array('<a href="%1$s" title="%2$s">%3$s</a>',false),$theme_data[0]['AuthorURI'],__(array('Visit author homepage',false)),wp_kses($theme_data[0]['Author'],$themes_allowed_tags))));
}}}}return $theme_data;
 }
function get_themes (  ) {
global $wp_themes,$wp_broken_themes;
if ( ((isset($wp_themes) && Aspis_isset( $wp_themes))))
 return $wp_themes;
register_theme_directory(get_theme_root());
if ( (denot_boolean($theme_files = search_theme_directories())))
 return array(false,false);
AspisInternalFunctionCall("asort",AspisPushRefParam($theme_files),array(0));
$wp_themes = array(array(),false);
foreach ( deAspis(array_cast($theme_files)) as $theme_file  )
{$theme_root = $theme_file[0]['theme_root'];
$theme_file = $theme_file[0]['theme_file'];
if ( (!(is_readable((deconcat(concat2($theme_root,"/"),$theme_file))))))
 {arrayAssign($wp_broken_themes[0],deAspis(registerTaint($theme_file)),addTaint(array(array(deregisterTaint(array('Name',false)) => addTaint($theme_file),deregisterTaint(array('Title',false)) => addTaint($theme_file),deregisterTaint(array('Description',false)) => addTaint(__(array('File not readable.',false)))),false)));
continue ;
}$theme_data = get_theme_data(concat(concat2($theme_root,"/"),$theme_file));
$name = $theme_data[0]['Name'];
$title = $theme_data[0]['Title'];
$description = wptexturize($theme_data[0]['Description']);
$version = $theme_data[0]['Version'];
$author = $theme_data[0]['Author'];
$template = $theme_data[0]['Template'];
$stylesheet = Aspis_dirname($theme_file);
$screenshot = array(false,false);
foreach ( (array(array('png',false),array('gif',false),array('jpg',false),array('jpeg',false))) as $ext  )
{if ( file_exists((deconcat(concat2(concat(concat2($theme_root,"/"),$stylesheet),"/screenshot."),$ext))))
 {$screenshot = concat1("screenshot.",$ext);
break ;
}}if ( ((empty($name) || Aspis_empty( $name))))
 {$name = Aspis_dirname($theme_file);
$title = $name;
}if ( ((empty($template) || Aspis_empty( $template))))
 {if ( file_exists((deconcat2(concat(concat2($theme_root,"/"),$stylesheet),"/index.php"))))
 $template = $stylesheet;
else 
{continue ;
}}$template = Aspis_trim($template);
if ( (!(file_exists((deconcat2(concat(concat2($theme_root,"/"),$template),"/index.php"))))))
 {$parent_dir = Aspis_dirname(Aspis_dirname($theme_file));
if ( file_exists((deconcat2(concat(concat2(concat(concat2($theme_root,"/"),$parent_dir),"/"),$template),"/index.php"))))
 {$template = concat(concat2($parent_dir,"/"),$template);
$template_directory = concat(concat2($theme_root,"/"),$template);
}else 
{{if ( (((isset($theme_files[0][$template[0]]) && Aspis_isset( $theme_files [0][$template[0]]))) && file_exists((deconcat($theme_files[0][$template[0]][0]['theme_root'],concat2(concat1("/",$template),"/index.php"))))))
 {$template_directory = concat($theme_files[0][$template[0]][0]['theme_root'],concat1("/",$template));
}else 
{{arrayAssign($wp_broken_themes[0],deAspis(registerTaint($name)),addTaint(array(array(deregisterTaint(array('Name',false)) => addTaint($name),deregisterTaint(array('Title',false)) => addTaint($title),deregisterTaint(array('Description',false)) => addTaint(__(array('Template is missing.',false)))),false)));
continue ;
}}}}}else 
{{$template_directory = Aspis_trim(concat(concat2($theme_root,'/'),$template));
}}$stylesheet_files = array(array(),false);
$template_files = array(array(),false);
$stylesheet_dir = @array(new AspisObject(dir((deconcat(concat2($theme_root,"/"),$stylesheet)))),false);
if ( $stylesheet_dir[0])
 {while ( (deAspis(($file = $stylesheet_dir[0]->read())) !== false) )
{if ( (denot_boolean(Aspis_preg_match(array('|^\.+$|',false),$file))))
 {if ( deAspis(Aspis_preg_match(array('|\.css$|',false),$file)))
 arrayAssignAdd($stylesheet_files[0][],addTaint(concat(concat2(concat(concat2($theme_root,"/"),$stylesheet),"/"),$file)));
elseif ( deAspis(Aspis_preg_match(array('|\.php$|',false),$file)))
 arrayAssignAdd($template_files[0][],addTaint(concat(concat2(concat(concat2($theme_root,"/"),$stylesheet),"/"),$file)));
}}@$stylesheet_dir[0]->close();
}$template_dir = @array(new AspisObject(dir($template_directory[0])),false);
if ( $template_dir[0])
 {while ( (deAspis(($file = $template_dir[0]->read())) !== false) )
{if ( deAspis(Aspis_preg_match(array('|^\.+$|',false),$file)))
 continue ;
if ( deAspis(Aspis_preg_match(array('|\.php$|',false),$file)))
 {arrayAssignAdd($template_files[0][],addTaint(concat(concat2($template_directory,"/"),$file)));
}elseif ( is_dir((deconcat(concat2($template_directory,"/"),$file))))
 {$template_subdir = @array(new AspisObject(dir((deconcat(concat2($template_directory,"/"),$file)))),false);
if ( (denot_boolean($template_subdir)))
 continue ;
while ( (deAspis(($subfile = $template_subdir[0]->read())) !== false) )
{if ( deAspis(Aspis_preg_match(array('|^\.+$|',false),$subfile)))
 continue ;
if ( deAspis(Aspis_preg_match(array('|\.php$|',false),$subfile)))
 arrayAssignAdd($template_files[0][],addTaint(concat(concat2(concat(concat2($template_directory,"/"),$file),"/"),$subfile)));
}@$template_subdir[0]->close();
}}@$template_dir[0]->close();
}$template_files = attAspisRC(array_unique(deAspisRC($template_files)));
$stylesheet_files = attAspisRC(array_unique(deAspisRC($stylesheet_files)));
$template_dir = Aspis_dirname(attachAspis($template_files,(0)));
$stylesheet_dir = Aspis_dirname(attachAspis($stylesheet_files,(0)));
if ( ((empty($template_dir) || Aspis_empty( $template_dir))))
 $template_dir = array('/',false);
if ( ((empty($stylesheet_dir) || Aspis_empty( $stylesheet_dir))))
 $stylesheet_dir = array('/',false);
if ( ((isset($wp_themes[0][$name[0]]) && Aspis_isset( $wp_themes [0][$name[0]]))))
 {if ( (((('WordPress Default') == $name[0]) || (('WordPress Classic') == $name[0])) && ((('default') == $stylesheet[0]) || (('classic') == $stylesheet[0]))))
 {$suffix = $wp_themes[0][$name[0]][0]['Stylesheet'];
$new_name = concat(concat2($name,"/"),$suffix);
arrayAssign($wp_themes[0],deAspis(registerTaint($new_name)),addTaint(attachAspis($wp_themes,$name[0])));
arrayAssign($wp_themes[0][$new_name[0]][0],deAspis(registerTaint(array('Name',false))),addTaint($new_name));
}else 
{{$name = concat(concat2($name,"/"),$stylesheet);
}}}arrayAssign($theme_roots[0],deAspis(registerTaint($stylesheet)),addTaint(Aspis_str_replace(array(WP_CONTENT_DIR,false),array('',false),$theme_root)));
arrayAssign($wp_themes[0],deAspis(registerTaint($name)),addTaint(array(array(deregisterTaint(array('Name',false)) => addTaint($name),deregisterTaint(array('Title',false)) => addTaint($title),deregisterTaint(array('Description',false)) => addTaint($description),deregisterTaint(array('Author',false)) => addTaint($author),deregisterTaint(array('Version',false)) => addTaint($version),deregisterTaint(array('Template',false)) => addTaint($template),deregisterTaint(array('Stylesheet',false)) => addTaint($stylesheet),deregisterTaint(array('Template Files',false)) => addTaint($template_files),deregisterTaint(array('Stylesheet Files',false)) => addTaint($stylesheet_files),deregisterTaint(array('Template Dir',false)) => addTaint($template_dir),deregisterTaint(array('Stylesheet Dir',false)) => addTaint($stylesheet_dir),deregisterTaint(array('Status',false)) => addTaint($theme_data[0]['Status']),deregisterTaint(array('Screenshot',false)) => addTaint($screenshot),deregisterTaint(array('Tags',false)) => addTaint($theme_data[0]['Tags']),deregisterTaint(array('Theme Root',false)) => addTaint($theme_root),deregisterTaint(array('Theme Root URI',false)) => addTaint(Aspis_str_replace(array(WP_CONTENT_DIR,false),content_url(),$theme_root))),false)));
}unset($theme_files);
if ( (deAspis(get_site_transient(array('theme_roots',false))) != $theme_roots[0]))
 set_site_transient(array('theme_roots',false),$theme_roots,array(7200,false));
unset($theme_roots);
$theme_names = attAspisRC(array_keys(deAspisRC($wp_themes)));
foreach ( deAspis(array_cast($theme_names)) as $theme_name  )
{arrayAssign($wp_themes[0][$theme_name[0]][0],deAspis(registerTaint(array('Parent Theme',false))),addTaint(array('',false)));
if ( (deAspis($wp_themes[0][$theme_name[0]][0]['Stylesheet']) != deAspis($wp_themes[0][$theme_name[0]][0]['Template'])))
 {foreach ( deAspis(array_cast($theme_names)) as $parent_theme_name  )
{if ( ((deAspis($wp_themes[0][$parent_theme_name[0]][0]['Stylesheet']) == deAspis($wp_themes[0][$parent_theme_name[0]][0]['Template'])) && (deAspis($wp_themes[0][$parent_theme_name[0]][0]['Template']) == deAspis($wp_themes[0][$theme_name[0]][0]['Template']))))
 {arrayAssign($wp_themes[0][$theme_name[0]][0],deAspis(registerTaint(array('Parent Theme',false))),addTaint($wp_themes[0][$parent_theme_name[0]][0]['Name']));
break ;
}}}}return $wp_themes;
 }
function get_theme_roots (  ) {
$theme_roots = get_site_transient(array('theme_roots',false));
if ( (false === $theme_roots[0]))
 {get_themes();
$theme_roots = get_site_transient(array('theme_roots',false));
}return $theme_roots;
 }
function get_theme ( $theme ) {
$themes = get_themes();
if ( array_key_exists(deAspisRC($theme),deAspisRC($themes)))
 return attachAspis($themes,$theme[0]);
return array(null,false);
 }
function get_current_theme (  ) {
if ( deAspis($theme = get_option(array('current_theme',false))))
 return $theme;
$themes = get_themes();
$theme_names = attAspisRC(array_keys(deAspisRC($themes)));
$current_template = get_option(array('template',false));
$current_stylesheet = get_option(array('stylesheet',false));
$current_theme = array('WordPress Default',false);
if ( $themes[0])
 {foreach ( deAspis(array_cast($theme_names)) as $theme_name  )
{if ( ((deAspis($themes[0][$theme_name[0]][0]['Stylesheet']) == $current_stylesheet[0]) && (deAspis($themes[0][$theme_name[0]][0]['Template']) == $current_template[0])))
 {$current_theme = $themes[0][$theme_name[0]][0]['Name'];
break ;
}}}update_option(array('current_theme',false),$current_theme);
return $current_theme;
 }
function register_theme_directory ( $directory ) {
global $wp_theme_directories;
if ( (!(file_exists($directory[0]))))
 $registered_directory = concat(concat12(WP_CONTENT_DIR,'/'),$directory);
else 
{$registered_directory = $directory;
}if ( (!(file_exists($registered_directory[0]))))
 return array(false,false);
arrayAssignAdd($wp_theme_directories[0][],addTaint($registered_directory));
return array(true,false);
 }
function search_theme_directories (  ) {
global $wp_theme_directories,$wp_broken_themes;
if ( ((empty($wp_theme_directories) || Aspis_empty( $wp_theme_directories))))
 return array(false,false);
$theme_files = array(array(),false);
$wp_broken_themes = array(array(),false);
foreach ( deAspis(array_cast($wp_theme_directories)) as $theme_root  )
{$theme_loc = $theme_root;
if ( (('/') != WP_CONTENT_DIR))
 $theme_loc = Aspis_str_replace(array(WP_CONTENT_DIR,false),array('',false),$theme_root);
$themes_dir = @attAspis(opendir($theme_root[0]));
if ( (denot_boolean($themes_dir)))
 return array(false,false);
while ( (deAspis(($theme_dir = attAspis(readdir($themes_dir[0])))) !== false) )
{if ( (is_dir((deconcat(concat2($theme_root,'/'),$theme_dir))) && is_readable((deconcat(concat2($theme_root,'/'),$theme_dir)))))
 {if ( ((deAspis(attachAspis($theme_dir,(0))) == ('.')) || ($theme_dir[0] == ('CVS'))))
 continue ;
$stylish_dir = @attAspis(opendir((deconcat(concat2($theme_root,'/'),$theme_dir))));
$found_stylesheet = array(false,false);
while ( (deAspis(($theme_file = attAspis(readdir($stylish_dir[0])))) !== false) )
{if ( ($theme_file[0] == ('style.css')))
 {arrayAssign($theme_files[0],deAspis(registerTaint($theme_dir)),addTaint(array(array(deregisterTaint(array('theme_file',false)) => addTaint(concat(concat2($theme_dir,'/'),$theme_file)),deregisterTaint(array('theme_root',false)) => addTaint($theme_root)),false)));
$found_stylesheet = array(true,false);
break ;
}}@closedir($stylish_dir[0]);
if ( (denot_boolean($found_stylesheet)))
 {$subdir = concat(concat2($theme_root,"/"),$theme_dir);
$subdir_name = $theme_dir;
$theme_subdirs = @attAspis(opendir($subdir[0]));
$found_subdir_themes = array(false,false);
while ( (deAspis(($theme_subdir = attAspis(readdir($theme_subdirs[0])))) !== false) )
{if ( (is_dir((deconcat(concat2($subdir,'/'),$theme_subdir))) && is_readable((deconcat(concat2($subdir,'/'),$theme_subdir)))))
 {if ( ((deAspis(attachAspis($theme_subdir,(0))) == ('.')) || ($theme_subdir[0] == ('CVS'))))
 continue ;
$stylish_dir = @attAspis(opendir((deconcat(concat2($subdir,'/'),$theme_subdir))));
$found_stylesheet = array(false,false);
while ( (deAspis(($theme_file = attAspis(readdir($stylish_dir[0])))) !== false) )
{if ( ($theme_file[0] == ('style.css')))
 {arrayAssign($theme_files[0],deAspis(registerTaint(concat(concat2($theme_dir,"/"),$theme_subdir))),addTaint(array(array(deregisterTaint(array('theme_file',false)) => addTaint(concat(concat2(concat(concat2($subdir_name,'/'),$theme_subdir),'/'),$theme_file)),deregisterTaint(array('theme_root',false)) => addTaint($theme_root)),false)));
$found_stylesheet = array(true,false);
$found_subdir_themes = array(true,false);
break ;
}}@closedir($stylish_dir[0]);
}}@closedir($theme_subdir[0]);
if ( (denot_boolean($found_subdir_themes)))
 arrayAssign($wp_broken_themes[0],deAspis(registerTaint($theme_dir)),addTaint(array(array(deregisterTaint(array('Name',false)) => addTaint($theme_dir),deregisterTaint(array('Title',false)) => addTaint($theme_dir),deregisterTaint(array('Description',false)) => addTaint(__(array('Stylesheet is missing.',false)))),false)));
}}}if ( is_dir($theme_dir[0]))
 @closedir($theme_dir[0]);
}return $theme_files;
 }
function get_theme_root ( $stylesheet_or_template = array(false,false) ) {
if ( $stylesheet_or_template[0])
 {$theme_roots = get_theme_roots();
if ( deAspis(attachAspis($theme_roots,$stylesheet_or_template[0])))
 $theme_root = concat1(WP_CONTENT_DIR,attachAspis($theme_roots,$stylesheet_or_template[0]));
else 
{$theme_root = concat12(WP_CONTENT_DIR,'/themes');
}}else 
{{$theme_root = concat12(WP_CONTENT_DIR,'/themes');
}}return apply_filters(array('theme_root',false),$theme_root);
 }
function get_theme_root_uri ( $stylesheet_or_template = array(false,false) ) {
$theme_roots = get_theme_roots();
if ( deAspis(attachAspis($theme_roots,$stylesheet_or_template[0])))
 $theme_root_uri = content_url(attachAspis($theme_roots,$stylesheet_or_template[0]));
else 
{$theme_root_uri = content_url(array('themes',false));
}return apply_filters(array('theme_root_uri',false),$theme_root_uri,get_option(array('siteurl',false)),$stylesheet_or_template);
 }
function get_query_template ( $type ) {
$type = Aspis_preg_replace(array('|[^a-z0-9-]+|',false),array('',false),$type);
return apply_filters(concat2($type,"_template"),locate_template(array(array(concat2($type,".php")),false)));
 }
function get_404_template (  ) {
return get_query_template(array('404',false));
 }
function get_archive_template (  ) {
return get_query_template(array('archive',false));
 }
function get_author_template (  ) {
return get_query_template(array('author',false));
 }
function get_category_template (  ) {
$cat_ID = absint(get_query_var(array('cat',false)));
$category = get_category($cat_ID);
$templates = array(array(),false);
if ( (denot_boolean(is_wp_error($category))))
 arrayAssignAdd($templates[0][],addTaint(concat2(concat1("category-",$category[0]->slug),".php")));
arrayAssignAdd($templates[0][],addTaint(concat2(concat1("category-",$cat_ID),".php")));
arrayAssignAdd($templates[0][],addTaint(array("category.php",false)));
$template = locate_template($templates);
return apply_filters(array('category_template',false),$template);
 }
function get_tag_template (  ) {
$tag_id = absint(get_query_var(array('tag_id',false)));
$tag_name = get_query_var(array('tag',false));
$templates = array(array(),false);
if ( $tag_name[0])
 arrayAssignAdd($templates[0][],addTaint(concat2(concat1("tag-",$tag_name),".php")));
if ( $tag_id[0])
 arrayAssignAdd($templates[0][],addTaint(concat2(concat1("tag-",$tag_id),".php")));
arrayAssignAdd($templates[0][],addTaint(array("tag.php",false)));
$template = locate_template($templates);
return apply_filters(array('tag_template',false),$template);
 }
function get_taxonomy_template (  ) {
$taxonomy = get_query_var(array('taxonomy',false));
$term = get_query_var(array('term',false));
$templates = array(array(),false);
if ( ($taxonomy[0] && $term[0]))
 arrayAssignAdd($templates[0][],addTaint(concat2(concat(concat2(concat1("taxonomy-",$taxonomy),"-"),$term),".php")));
if ( $taxonomy[0])
 arrayAssignAdd($templates[0][],addTaint(concat2(concat1("taxonomy-",$taxonomy),".php")));
arrayAssignAdd($templates[0][],addTaint(array("taxonomy.php",false)));
$template = locate_template($templates);
return apply_filters(array('taxonomy_template',false),$template);
 }
function get_date_template (  ) {
return get_query_template(array('date',false));
 }
function get_home_template (  ) {
$template = locate_template(array(array(array('home.php',false),array('index.php',false)),false));
return apply_filters(array('home_template',false),$template);
 }
function get_page_template (  ) {
global $wp_query;
$id = int_cast($wp_query[0]->post[0]->ID);
$template = get_post_meta($id,array('_wp_page_template',false),array(true,false));
$pagename = get_query_var(array('pagename',false));
if ( (('default') == $template[0]))
 $template = array('',false);
$templates = array(array(),false);
if ( ((!((empty($template) || Aspis_empty( $template)))) && (denot_boolean(validate_file($template)))))
 arrayAssignAdd($templates[0][],addTaint($template));
if ( $pagename[0])
 arrayAssignAdd($templates[0][],addTaint(concat2(concat1("page-",$pagename),".php")));
if ( $id[0])
 arrayAssignAdd($templates[0][],addTaint(concat2(concat1("page-",$id),".php")));
arrayAssignAdd($templates[0][],addTaint(array("page.php",false)));
return apply_filters(array('page_template',false),locate_template($templates));
 }
function get_paged_template (  ) {
return get_query_template(array('paged',false));
 }
function get_search_template (  ) {
return get_query_template(array('search',false));
 }
function get_single_template (  ) {
return get_query_template(array('single',false));
 }
function get_attachment_template (  ) {
global $posts;
$type = Aspis_explode(array('/',false),$posts[0][(0)][0]->post_mime_type);
if ( deAspis($template = get_query_template(attachAspis($type,(0)))))
 return $template;
elseif ( deAspis($template = get_query_template(attachAspis($type,(1)))))
 return $template;
elseif ( deAspis($template = get_query_template(concat(concat2(attachAspis($type,(0)),"_"),attachAspis($type,(1))))))
 return $template;
else 
{return get_query_template(array('attachment',false));
} }
function get_comments_popup_template (  ) {
$template = locate_template(array(array(array("comments-popup.php",false)),false));
if ( (('') == $template[0]))
 $template = concat2(get_theme_root(),'/default/comments-popup.php');
return apply_filters(array('comments_popup_template',false),$template);
 }
function locate_template ( $template_names,$load = array(false,false) ) {
if ( (!(is_array($template_names[0]))))
 return array('',false);
$located = array('',false);
foreach ( $template_names[0] as $template_name  )
{if ( file_exists((deconcat(concat12(STYLESHEETPATH,'/'),$template_name))))
 {$located = concat(concat12(STYLESHEETPATH,'/'),$template_name);
break ;
}else 
{if ( file_exists((deconcat(concat12(TEMPLATEPATH,'/'),$template_name))))
 {$located = concat(concat12(TEMPLATEPATH,'/'),$template_name);
break ;
}}}if ( ($load[0] && (('') != $located[0])))
 load_template($located);
return $located;
 }
function load_template ( $_template_file ) {
global $posts,$post,$wp_did_header,$wp_did_template_redirect,$wp_query,$wp_rewrite,$wpdb,$wp_version,$wp,$id,$comment,$user_ID;
if ( is_array($wp_query[0]->query_vars[0]))
 extract(($wp_query[0]->query_vars[0]),EXTR_SKIP);
require_once deAspis(($_template_file));
 }
function locale_stylesheet (  ) {
$stylesheet = get_locale_stylesheet_uri();
if ( ((empty($stylesheet) || Aspis_empty( $stylesheet))))
 return ;
echo AspisCheckPrint(concat2(concat1('<link rel="stylesheet" href="',$stylesheet),'" type="text/css" media="screen" />'));
 }
function preview_theme (  ) {
if ( (!(((isset($_GET[0][('template')]) && Aspis_isset( $_GET [0][('template')]))) && ((isset($_GET[0][('preview')]) && Aspis_isset( $_GET [0][('preview')]))))))
 return ;
if ( (denot_boolean(current_user_can(array('switch_themes',false)))))
 return ;
arrayAssign($_GET[0],deAspis(registerTaint(array('template',false))),addTaint(Aspis_preg_replace(array('|[^a-z0-9_./-]|i',false),array('',false),$_GET[0]['template'])));
if ( deAspis(validate_file($_GET[0]['template'])))
 return ;
add_filter(array('template',false),array('_preview_theme_template_filter',false));
if ( ((isset($_GET[0][('stylesheet')]) && Aspis_isset( $_GET [0][('stylesheet')]))))
 {arrayAssign($_GET[0],deAspis(registerTaint(array('stylesheet',false))),addTaint(Aspis_preg_replace(array('|[^a-z0-9_./-]|i',false),array('',false),$_GET[0]['stylesheet'])));
if ( deAspis(validate_file($_GET[0]['stylesheet'])))
 return ;
add_filter(array('stylesheet',false),array('_preview_theme_stylesheet_filter',false));
}add_filter(concat1('pre_option_mods_',get_current_theme()),Aspis_create_function(array('',false),array("return array();",false)));
ob_start(AspisInternalCallback(array('preview_theme_ob_filter',false)));
 }
add_action(array('setup_theme',false),array('preview_theme',false));
function _preview_theme_template_filter (  ) {
return ((isset($_GET[0][('template')]) && Aspis_isset( $_GET [0][('template')]))) ? $_GET[0]['template'] : array('',false);
 }
function _preview_theme_stylesheet_filter (  ) {
return ((isset($_GET[0][('stylesheet')]) && Aspis_isset( $_GET [0][('stylesheet')]))) ? $_GET[0]['stylesheet'] : array('',false);
 }
function preview_theme_ob_filter ( $content ) {
return Aspis_preg_replace_callback(array("|(<a.*?href=([\"']))(.*?)([\"'].*?>)|",false),array('preview_theme_ob_filter_callback',false),$content);
 }
function preview_theme_ob_filter_callback ( $matches ) {
if ( (strpos(deAspis(attachAspis($matches,(4))),'onclick') !== false))
 arrayAssign($matches[0],deAspis(registerTaint(array(4,false))),addTaint(Aspis_preg_replace(array('#onclick=([\'"]).*?(?<!\\\)\\1#i',false),array('',false),attachAspis($matches,(4)))));
if ( ((((false !== strpos(deAspis(attachAspis($matches,(3))),'/wp-admin/')) || ((false !== strpos(deAspis(attachAspis($matches,(3))),'://')) && ((0) !== strpos(deAspis(attachAspis($matches,(3))),deAspisRC(get_option(array('home',false))))))) || (false !== strpos(deAspis(attachAspis($matches,(3))),'/feed/'))) || (false !== strpos(deAspis(attachAspis($matches,(3))),'/trackback/'))))
 return concat(concat(attachAspis($matches,(1)),concat2(concat(concat2(concat1("#",attachAspis($matches,(2)))," onclick="),attachAspis($matches,(2))),"return false;")),attachAspis($matches,(4)));
$link = add_query_arg(array(array('preview' => array(1,false,false),deregisterTaint(array('template',false)) => addTaint($_GET[0]['template']),deregisterTaint(array('stylesheet',false)) => addTaint(@$_GET[0]['stylesheet'])),false),attachAspis($matches,(3)));
if ( ((0) === strpos($link[0],'preview=1')))
 $link = concat1("?",$link);
return concat(concat(attachAspis($matches,(1)),esc_attr($link)),attachAspis($matches,(4)));
 }
function switch_theme ( $template,$stylesheet ) {
update_option(array('template',false),$template);
update_option(array('stylesheet',false),$stylesheet);
delete_option(array('current_theme',false));
$theme = get_current_theme();
do_action(array('switch_theme',false),$theme);
 }
function validate_current_theme (  ) {
if ( (defined(('WP_INSTALLING')) || (denot_boolean(apply_filters(array('validate_current_theme',false),array(true,false))))))
 return array(true,false);
if ( ((deAspis(get_template()) != ('default')) && (!(file_exists((deconcat2(get_template_directory(),'/index.php')))))))
 {switch_theme(array('default',false),array('default',false));
return array(false,false);
}if ( ((deAspis(get_stylesheet()) != ('default')) && (!(file_exists((deconcat2(get_template_directory(),'/style.css')))))))
 {switch_theme(array('default',false),array('default',false));
return array(false,false);
}return array(true,false);
 }
function get_theme_mod ( $name,$default = array(false,false) ) {
$theme = get_current_theme();
$mods = get_option(concat1("mods_",$theme));
if ( ((isset($mods[0][$name[0]]) && Aspis_isset( $mods [0][$name[0]]))))
 return apply_filters(concat1("theme_mod_",$name),attachAspis($mods,$name[0]));
return apply_filters(concat1("theme_mod_",$name),Aspis_sprintf($default,get_template_directory_uri(),get_stylesheet_directory_uri()));
 }
function set_theme_mod ( $name,$value ) {
$theme = get_current_theme();
$mods = get_option(concat1("mods_",$theme));
arrayAssign($mods[0],deAspis(registerTaint($name)),addTaint($value));
update_option(concat1("mods_",$theme),$mods);
wp_cache_delete(concat1("mods_",$theme),array('options',false));
 }
function remove_theme_mod ( $name ) {
$theme = get_current_theme();
$mods = get_option(concat1("mods_",$theme));
if ( (!((isset($mods[0][$name[0]]) && Aspis_isset( $mods [0][$name[0]])))))
 return ;
unset($mods[0][$name[0]]);
if ( ((empty($mods) || Aspis_empty( $mods))))
 return remove_theme_mods();
update_option(concat1("mods_",$theme),$mods);
wp_cache_delete(concat1("mods_",$theme),array('options',false));
 }
function remove_theme_mods (  ) {
$theme = get_current_theme();
delete_option(concat1("mods_",$theme));
 }
function get_header_textcolor (  ) {
return get_theme_mod(array('header_textcolor',false),array(HEADER_TEXTCOLOR,false));
 }
function header_textcolor (  ) {
echo AspisCheckPrint(get_header_textcolor());
 }
function get_header_image (  ) {
return get_theme_mod(array('header_image',false),array(HEADER_IMAGE,false));
 }
function header_image (  ) {
echo AspisCheckPrint(get_header_image());
 }
function add_custom_image_header ( $header_callback,$admin_header_callback ) {
if ( (!((empty($header_callback) || Aspis_empty( $header_callback)))))
 add_action(array('wp_head',false),$header_callback);
if ( (denot_boolean(is_admin())))
 return ;
require_once (deconcat12(ABSPATH,'wp-admin/custom-header.php'));
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('custom_image_header',false))),addTaint(array(new Custom_Image_Header($admin_header_callback),false)));
add_action(array('admin_menu',false),array(array(&$GLOBALS[0][('custom_image_header')],array('init',false)),false));
 }
function add_theme_support ( $feature ) {
global $_wp_theme_features;
if ( (func_num_args() == (1)))
 arrayAssign($_wp_theme_features[0],deAspis(registerTaint($feature)),addTaint(array(true,false)));
else 
{arrayAssign($_wp_theme_features[0],deAspis(registerTaint($feature)),addTaint(Aspis_array_slice(array(func_get_args(),false),array(1,false))));
} }
function current_theme_supports ( $feature ) {
global $_wp_theme_features;
if ( (!((isset($_wp_theme_features[0][$feature[0]]) && Aspis_isset( $_wp_theme_features [0][$feature[0]])))))
 return array(false,false);
if ( (func_num_args() <= (1)))
 return array(true,false);
$args = Aspis_array_slice(array(func_get_args(),false),array(1,false));
switch ( $feature[0] ) {
case ('post-thumbnails'):if ( (true === deAspis(attachAspis($_wp_theme_features,$feature[0]))))
 return array(true,false);
$content_type = attachAspis($args,(0));
if ( deAspis(Aspis_in_array($content_type,attachAspis($_wp_theme_features[0][$feature[0]],(0)))))
 return array(true,false);
else 
{return array(false,false);
}break ;
 }
return array(true,false);
 }
function require_if_theme_supports ( $feature,$include ) {
if ( deAspis(current_theme_supports($feature)))
 require deAspis(($include));
 }
;
?>
<?php 